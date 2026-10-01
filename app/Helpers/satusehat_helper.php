<?php

/**
 * =====================================================================
 * SATUSEHAT HELPER - OAuth2 Client Credentials + Auto Token Cache
 * =====================================================================
 * Semua konfigurasi dibaca langsung dari .env.
 * Tidak butuh file Config tambahan.
 * =====================================================================
 */

if (!function_exists('ss_get_token')) {
    /**
     * Ambil access token SATUSEHAT dari cache.
     * Kalau tidak ada / expired → request token baru.
     *
     * @param bool $forceRefresh  Paksa ambil token baru
     * @return string|null
     */
    function ss_get_token(bool $forceRefresh = false): ?string
    {
        $authUrl      = env('SATUSEHAT_AUTH_URL');
        $clientId     = env('SATUSEHAT_CLIENT_ID');
        $clientSecret = env('SATUSEHAT_CLIENT_SECRET');

        if (empty($authUrl) || empty($clientId) || empty($clientSecret)) {
            log_message('error', '[SS] Konfigurasi SATUSEHAT di .env belum lengkap.');
            return null;
        }

        $cache    = \Config\Services::cache();
        $cacheKey = 'ss_token_' . md5($authUrl . $clientId);
        $lockKey  = $cacheKey . '_lock';

        // 1. Cek cache dulu (kecuali force refresh)
        if (!$forceRefresh) {
            $token = $cache->get($cacheKey);
            if (!empty($token)) {
                log_message('info', '[SS] Pakai token dari cache.');
                return $token;
            }
        } else {
            $cache->delete($cacheKey);
            log_message('warning', '[SS] Force refresh token.');
        }

        // 2. Cek lock (biar tidak bentrok kalau banyak user akses bareng)
        if ($cache->get($lockKey) !== null) {
            log_message('info', '[SS] Nunggu proses lain ambil token...');
            for ($i = 0; $i < 5; $i++) {
                sleep(1);
                $token = $cache->get($cacheKey);
                if (!empty($token)) {
                    return $token;
                }
            }
        } else {
            $cache->save($lockKey, '1', 30);
        }

        // 3. Request token baru
        $token = ss_request_new_token($authUrl, $clientId, $clientSecret);

        // 4. Lepas lock
        $cache->delete($lockKey);

        // 5. Simpan ke cache
        if ($token !== null) {
            $ttl = 4 * 3600 - 60; // 4 jam - 60 detik buffer
            $cache->save($cacheKey, $token, $ttl);
            log_message('info', "[SS] Token baru disimpan. TTL: {$ttl}s");
        }

        return $token;
    }
}

if (!function_exists('ss_request_new_token')) {
    /**
     * Request token baru ke SATUSEHAT (internal).
     */
    function ss_request_new_token(string $authUrl, string $clientId, string $clientSecret): ?string
    {
        $client = service('curlrequest');

        $url = rtrim($authUrl, '/') . '/accesstoken?grant_type=client_credentials';

        try {
            $response = $client->request('POST', $url, [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Accept'       => 'application/json',
                ],
                'http_errors' => false,
                'timeout'     => 15,
                'form_params' => [
                    'client_id'     => $clientId,
                    'client_secret' => $clientSecret,
                ],
            ]);

            $body = (string) $response->getBody();
            $code = $response->getStatusCode();

            if ($code !== 200) {
                log_message('error', "[SS] Token gagal. HTTP {$code}. Body: {$body}");
                return null;
            }

            $data = json_decode($body, true);

            if (!isset($data['access_token'])) {
                log_message('error', "[SS] Response tidak ada access_token: {$body}");
                return null;
            }

            return $data['access_token'];
        } catch (\Throwable $e) {
            log_message('error', '[SS] Exception request token: ' . $e->getMessage());
            return null;
        }
    }
}

if (!function_exists('ss_api')) {
    /**
     * Request ke SATUSEHAT FHIR API.
     *
     * @param string $method    GET|POST|PUT|PATCH|DELETE
     * @param string $endpoint  Contoh: '/Patient/100000030009'
     * @param array  $data      Body/query
     * @param bool   $retry     Internal untuk auto-retry 401
     * @return array{status:int, body:mixed, raw:string, error?:string}
     */
    function ss_api(string $method, string $endpoint, array $data = [], bool $retry = true): array
    {
        $baseUrl = env('SATUSEHAT_BASE_URL');

        if (empty($baseUrl)) {
            return [
                'status' => 0,
                'body'   => null,
                'raw'    => '',
                'error'  => 'SATUSEHAT_BASE_URL belum diisi di .env',
            ];
        }

        // Bangun URL
        if (!preg_match('/^https?:\/\//i', $endpoint)) {
            $url = rtrim($baseUrl, '/') . '/' . ltrim($endpoint, '/');
        } else {
            $url = $endpoint;
        }

        // Ambil token
        $token = ss_get_token();
        if ($token === null) {
            return [
                'status' => 0,
                'body'   => null,
                'raw'    => '',
                'error'  => 'Gagal mendapatkan access token SATUSEHAT',
            ];
        }

        $client = service('curlrequest');

        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ];

        $options = [
            'headers'     => $headers,
            'http_errors' => false,
            'timeout'     => 30,
        ];

        $method = strtoupper($method);

        if (!empty($data)) {
            if (in_array($method, ['POST', 'PUT', 'PATCH', 'DELETE'])) {
                $options['json'] = $data;
            } elseif ($method === 'GET') {
                $url .= (str_contains($url, '?') ? '&' : '?') . http_build_query($data);
            }
        }

        try {
            $response = $client->request($method, $url, $options);
        } catch (\Throwable $e) {
            log_message('error', '[SS] Exception API: ' . $e->getMessage());
            return [
                'status' => 0,
                'body'   => null,
                'raw'    => '',
                'error'  => $e->getMessage(),
            ];
        }

        $code = $response->getStatusCode();
        $raw  = (string) $response->getBody();
        $json = json_decode($raw, true);

        // Auto-retry kalau 401 (token dicabut lebih awal)
        if ($code === 401 && $retry) {
            log_message('warning', '[SS] 401, force refresh token & retry.');
            ss_get_token(true);
            return ss_api($method, $endpoint, $data, false);
        }

        return [
            'status' => $code,
            'body'   => $json,
            'raw'    => $raw,
        ];
    }
}

if (!function_exists('ss_clear_token')) {
    /**
     * Hapus token dari cache (untuk debugging).
     */
    function ss_clear_token(): void
    {
        $authUrl  = env('SATUSEHAT_AUTH_URL');
        $clientId = env('SATUSEHAT_CLIENT_ID');

        $cache    = \Config\Services::cache();
        $cacheKey = 'ss_token_' . md5($authUrl . $clientId);
        $cache->delete($cacheKey);

        log_message('info', '[SS] Token cache dibersihkan.');
    }
}
