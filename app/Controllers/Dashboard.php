<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;
//use App\Libraries\Pdfgenerator;



class Dashboard extends BaseController
{

    protected $data;
    protected $server;
    protected $client;

    public function __construct()
    {
        $this->session = session();
        $this->server = $_ENV['APP_API'];

        //library CURLrequest
        $this->client = service('curlrequest');
    }

    public function index()
    {
        $date_exp = Time::parse(date('Y-m-d', strtotime(session()->get('pwd_exp_dt'))));
        $date_now = Time::parse(date('Y/m/d', strtotime(date('Y/m/d'))));

        $diff = $date_now->difference($date_exp);

        $this->data['exp_tomorrow'] = ($diff->getDays()) == 0 ? 1 : 0;
        $this->data['title'] = 'Dashboard | ' . $_ENV['APP_TITLE'];

        return view('dashboard/index', $this->data);
    }
}
