<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

class Prints extends BaseController
{

    protected $server5;

    public function __construct()
    {
        $this->session = session();
        $uri = service('uri');
        $this->server5 = $_ENV['APP_API5'];
    }


    public function savePrintHistory()
    {
        if ($this->request->isAJAX()) {
            // Ambil data dari request
            $payload = $this->request->getJSON(true); // true untuk return array

            // Validasi required fields
            if (!isset($payload['print_type']) || !isset($payload['document_type']) || !isset($payload['document_id']) || !isset($payload['usr_id'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Missing required fields: print_type, document_type, document_id, usr_id'
                ])->setStatusCode(400);
            }

            // Helper curl request
            helper(['restclient']);

            // Endpoint API
            $url = "$this->server5/api/PrintHistories";

            // Client request (POST)
            $response = akses_restapikey('POST', $url, $payload);

            // Decode response
            $result = json_decode($response, true);

            // Cek apakah sukses
            if ($result && isset($result['success']) && $result['success'] === true) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Print history saved successfully',
                    'data' => $result
                ]);
            } else {
                // Jika gagal
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to save print history',
                    'error' => $result
                ])->setStatusCode(500);
            }
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request method'
            ])->setStatusCode(405);
        }
    }
}
