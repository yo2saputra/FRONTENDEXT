<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Tmstglclosingyear extends BaseController
{
    protected $data;
    protected $server;
    protected $server3;

    public function __construct()
    {
        $this->session = session();
        $this->server = $_ENV['APP_API'];
        $this->server3 = $_ENV['APP_API3'];
    }

    public function index()
    {
        helper(['dropdown']);
        $defaultFiscal = apiDropdownSetFscsyr('SetFscsyr');

        $this->data['default_fiscal_year'] = $defaultFiscal['data'][0]['value'] ?? date('Y');

        return view('tmstglclosingyear/index', $this->data);
    }

    public function startClosing()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request'
            ]);
        }

        $confirmed = $this->request->getPost('confirmed');
        if (!$confirmed) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Confirmation required'
            ]);
        }

        try {
            helper(['restclient']);

            $payload = [
                'UserId' => session()->get('usr_id')
            ];

            $url = "{$this->server3}/api/tmstglclosingyear";

            $response = akses_restapikey('POST', $url, $payload, [
                'Content-Type' => 'application/json'
            ]);

            $result = is_string($response) ? json_decode($response, true) : $response;

            return $this->response->setJSON($result);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Closing Year gagal diproses: ' . $e->getMessage(),
            ]);
        }
    }


    public function action()
    {
        return $this->startClosing();
    }
}
