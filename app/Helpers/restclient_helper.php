<?php

function akses_restapi($method, $url, $data)
{

    //library CURLrequest
    $client = service('curlrequest');

    // $token = "";

    $headers = [
        // "Authorization" => "Bearer " . $token,
        // "Content-Type" => "application/json",
        "Accept" => "application/json"
    ];

    $response = $client->request($method, $url, ['headers' => $headers, 'http_errors' => false, 'form_params' => $data]);

    return $response->getBody();
}

function akses_restapikey($method, $url, $data = [], $query = [])
{
    $client = service('curlrequest');

    $apiKey = "XXXXXXXXXXXXXXXXXXXXXXXX";
    $headers = [
        "X-API-KEY"     => $apiKey,
        "X-API-Owner"   => "xxxx",
        "Content-Type"  => "application/json",
        "Accept"        => "application/json"
    ];

    $options = [
        "headers" => $headers,
        "http_errors" => false,
        "timeout" => 500,
        "query" => $query
    ];

    if (strtoupper($method) !== 'GET' && strtoupper($method) !== 'DELETE') {
        $options['body'] = json_encode($data);
    }

    try {
        $response = $client->request($method, $url, $options);
        return $response->getBody();
    } catch (\Exception $e) {
        log_message('error', "API Error: " . $e->getMessage());
        return json_encode(['error' => 'Request failed']);
    }
}

function akses_restapikeypdf($method, $url, $data = [], $query = [], $isBinary = false)
{
    $client = service('curlrequest');

    $apiKey = "XXXXXXXXXXXXXXXXXXXXXXXX";
    $headers = [
        "X-API-KEY"     => $apiKey,
        "X-API-Owner"   => "xxxx",
        "Content-Type"  => "application/json",
    ];

    // Jika binary, jangan minta JSON
    if ($isBinary) {
        $headers["Accept"] = "application/pdf, application/octet-stream, */*";
    } else {
        $headers["Accept"] = "application/json";
    }

    $options = [
        "headers" => $headers,
        "http_errors" => false,
        "timeout" => 500,
        "query" => $query
    ];

    if (strtoupper($method) !== 'GET' && strtoupper($method) !== 'DELETE') {
        $options['body'] = json_encode($data);
    }

    try {
        $response = $client->request($method, $url, $options);

        // Jika binary, return raw body tanpa mengubah apapun
        if ($isBinary) {
            return $response->getBody();
        }

        // Jika JSON, return body
        return $response->getBody();
    } catch (\Exception $e) {
        log_message('error', "API Error: " . $e->getMessage());
        return json_encode(['error' => 'Request failed: ' . $e->getMessage()]);
    }
}

function akses_restapikeytoken($method, $url, $data, $apiKey, $token)
{

    //library CURLrequest
    $client = service('curlrequest');

    // API key statis
    $apiKey = "";

    $token = "";

    $headers = [
        "X-API-KEY" => $apiKey, // API Key untuk otorisasi
        "API-Owner"    => "xxxx", // Test
        "Authorization" => "Bearer " . $token,
        "Content-Type" => "application/json",
        "Accept" => "application/json"
    ];

    $response = $client->request($method, $url, ['headers' => $headers, 'http_errors' => false, 'form_params' => $data]);

    return $response->getBody();
}
