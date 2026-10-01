<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Tmstglactstructur extends BaseController
{

    protected $data;
    protected $server;
    protected $server3;
    protected $client;

    public function __construct()
    {
        $this->server = $_ENV['APP_API'];
        $this->server3 = $_ENV['APP_API3'];
    }

    public function index()
    {
        // helper dropdown
        helper(['dropdown']);
        return view('tmstglactstructur/index', $this->data);
    }

    public function datatables()
    {
        helper(['restclient']);
        $rawBody = $this->request->getBody();
        $json = json_decode($rawBody, true);

        $url = "{$this->server3}/api/tmstglaccountstructure/datatables";
        $response = akses_restapikey('POST', $url, $json);

        $result = json_decode($response, true);

        return $this->response->setJSON($result);
    }
}
