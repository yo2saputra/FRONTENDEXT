<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Componenn extends BaseController
{

    protected $data;
    protected $server;
    protected $server3;
    protected $client;

    public function __construct()
    {
        $this->session = session();
        $uri = service('uri');
        $this->server = $_ENV['APP_API'];
        $this->server3 = $_ENV['APP_API3'];
    }

    public function index()
    {
        $this->data['title'] = 'Menu Formulir Pasien';
        return view('componen/index', $this->data);
    }

    // public function index()
    // {
    //     return view('underconstruction');
    // }
}
