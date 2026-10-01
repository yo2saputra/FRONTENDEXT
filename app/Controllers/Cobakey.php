<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;
//use App\Libraries\Pdfgenerator;



class Cobakey extends BaseController
{

    protected $data;
    protected $server;
    protected $server2;
    protected $server3;
    protected $client;

    public function __construct()
    {
        $this->session = session();
        $this->server = $_ENV['APP_API'];
        $this->server2 = $_ENV['APP_API2'];
        $this->server3 = $_ENV['APP_API3'];

        //library CURLrequest
        $this->client = service('curlrequest');

        $this->data = [
            'menu_header' => $this->apiMenuHeader(session()->get('usr_id')),
            'menu' => $this->apiMenu(session()->get('usr_id'))
        ];
    }



    public function index()
    {

        return view('cobakey/index');
    }

    // public function index()
    // {
    //     // helper dropdown
    //     helper(['dropdown']);

    //     $this->data['cb_aktif'] = getDropdownCustom('warehouse_sta_id', 'warehouse_sta_id', 'Status', 2, 4);
    //     return view('tmstwarehouse/index', $this->data);
    // }

    public function getall()
    {
        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "{$this->server3}/api/warehouse";

        // Parameter yang ingin dikirim
        $query = [
            'action' => 'getall',          // atau 'getall'
            'warehouseCd' => ''        // ganti sesuai kebutuhan
        ];

        // client request
        $response = akses_restapikey('GET', $url, $body = [], $query);
        $data['response_data'] = json_decode($response, true);

        dd($data['response_data']);
    }

    public function getby()
    {
        // helper dropdown
        // helper(['dropdown']);

        // $this->data['cb_aktif'] = getDropdownCustom('warehouse_sta_id', 'warehouse_sta_id', 'Status', 2, 4);
        // return view('tmstwarehouse/index', $this->data);

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "{$this->server3}/api/warehouse";

        // Parameter yang ingin dikirim
        $query = [
            'action' => 'getby',          // atau 'getall'
            'warehouseCd' => 'WH00002'        // ganti sesuai kebutuhan
        ];

        // client request
        $response = akses_restapikey('GET', $url, $body = [], $query);
        $data['response_data'] = json_decode($response, true);

        dd($data['response_data']);
    }


    public function insert()
    {
        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "{$this->server3}/api/warehouse";

        // Parameter yang ingin dikirim
        $params = [
            'warehouse_cd' => 'string',
            'warehouse_nm' => 'BSD WH',
            'lokasi' => 'BSD',
            'warehouse_sta_id' => 'A',
            'warehousecode' => 'string'
        ];

        // client request
        $response = akses_restapikey('POST', $url, $params);
        $data['response_data'] = json_decode($response, true);

        dd($data['response_data']);
    }

    public function update()
    {
        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "{$this->server3}/api/warehouse";

        // Parameter yang ingin dikirim
        $query = ['warehouse_cd' => 'WH00033'];
        $body = [
            'warehouse_nm' => 'Test 1234',
            'lokasi' => 'Test 1234',
            'warehouse_sta_id' => 'A',
            'warehousecode' => 'string'
        ];

        // client request
        $response = akses_restapikey('PUT', $url, $body, $query);


        // Parameter yang ingin dikirim
        // $params = [
        //     'warehouse_cd' => 'WH00033',
        //     'warehouse_nm' => 'Test 1234',
        //     'lokasi' => 'Test 1234',
        //     'warehouse_sta_id' => 'A',
        //     'warehousecode' => 'string'
        // ];

        // client request
        // $response = akses_restapikey('PUT', $url, $params);
        $data['response_data'] = json_decode($response, true);

        dd($data['response_data']);
    }

    public function delete()
    {
        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "{$this->server3}/api/warehouse";

        // Parameter yang ingin dikirim
        $params = [
            'warehouse_cd' => 'WH00031'
        ];

        // client request
        $response = akses_restapikey('DELETE', $url, $params);
        $data['response_data'] = json_decode($response, true);

        dd($data['response_data']);
    }



    public function datatables()
    {
        // helper curl request
        helper(['restclient']);
        $rawBody = $this->request->getBody(); // Ambil raw JSON
        $json = json_decode($rawBody, true);  // Decode ke array

        $url = "{$this->server3}/api/warehouse/datatables";
        $response = akses_restapikey('POST', $url, $json); // Kirim sebagai array

        return $this->response->setJSON(json_decode($response, true));
    }



    public function index22()
    {
        //dd("yoyo");
        $date_exp = Time::parse(date('Y-m-d', strtotime(session()->get('pwd_exp_dt'))));
        $date_now = Time::parse(date('Y/m/d', strtotime(date('Y/m/d'))));
        // $date_now = Time::parse(date('Y-m-d', strtotime('2023-12-12 00:00:00')));

        $diff = $date_now->difference($date_exp);

        $this->data['exp_tomorrow'] = ($diff->getDays()) == 0 ? 1 : 0;
        $this->data['title'] = 'Dashboard | ' . $_ENV['APP_TITLE'];

        return view('dashboard/index', $this->data);
    }
}
