<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class SatusehatController extends BaseController
{
    public function index()
    {
        return view('patient');
    }
    /**
     * Contoh 1: Ambil data Patient by ID
     */
    public function getPatient($id = null)
    {
        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID Patient wajib diisi',
            ]);
        }

        $result = ss_api('GET', '/Patient/' . $id);

        return $this->response->setJSON([
            'success' => $result['status'] === 200,
            'status'  => $result['status'],
            'data'    => $result['body'],
            'error'   => $result['error'] ?? null,
        ]);
    }

    /**
     * Contoh 2: Cari Patient by NIK
     */
    public function searchPatientByNik()
    {
        $nik = $this->request->getGet('nik');

        if (!$nik) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Parameter nik wajib diisi',
            ]);
        }

        // SATUSEHAT: cari pakai parameter identifier
        $result = ss_api('GET', '/Patient', [
            'identifier' => 'https://fhir.kemkes.go.id/id/nik|' . $nik,
        ]);

        return $this->response->setJSON([
            'success' => $result['status'] === 200,
            'status'  => $result['status'],
            'data'    => $result['body'],
        ]);
    }

    /**
     * Contoh 3: Ambil data Organization
     */
    public function getOrganization($id = null)
    {
        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID Organization wajib diisi',
            ]);
        }

        $result = ss_api('GET', '/Organization/' . $id);

        return $this->response->setJSON([
            'success' => $result['status'] === 200,
            'data'    => $result['body'],
        ]);
    }

    /**
     * Contoh 4: POST Encounter (buat kunjungan baru)
     */
    public function createEncounter()
    {
        $payload = $this->request->getJSON(true);

        if (!$payload) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Payload JSON tidak valid',
            ]);
        }

        $result = ss_api('POST', '/Encounter', $payload);

        return $this->response->setJSON([
            'success' => in_array($result['status'], [200, 201]),
            'status'  => $result['status'],
            'data'    => $result['body'],
        ]);
    }

    /**
     * Contoh 5: Debug - cek token (khusus development)
     */
    public function debugToken()
    {
        if (ENVIRONMENT !== 'development') {
            return $this->response->setStatusCode(403)->setBody('Forbidden');
        }

        $token = ss_get_token();

        return $this->response->setJSON([
            'token_preview' => $token ? substr($token, 0, 30) . '...' : null,
            'token_length'  => $token ? strlen($token) : 0,
            'cache_exists'  => $token !== null,
        ]);
    }

    /**
     * Contoh 6: Force refresh token
     */
    public function refreshToken()
    {
        ss_clear_token();
        $token = ss_get_token();

        return $this->response->setJSON([
            'success' => $token !== null,
            'message' => $token ? 'Token berhasil di-refresh' : 'Gagal refresh token',
        ]);
    }
}
