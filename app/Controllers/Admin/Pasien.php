<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
//use App\Libraries\Pdfgenerator;



class Pasien extends BaseController
{

    protected $data;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->session = session();

        //library CURLrequest
        $this->client = \Config\Services::curlrequest();
    }

    public function index()
    {

        $this->data['title'] = 'Produk | PT. DELTA FOOD DISTRIBUSI';
        $this->data['produk'] = $this->apiProdukGetAll();

        return view('admin/pasien/index', $this->data);
    }

    public function apiProdukGetAll()
    {
        //Set metode request dan endpoint
        $response = $this->client->request('GET', 'http://103.136.19.83:8060/clinic/tfield_value/getall');
        //Ambil body dari response
        $content = $response->getBody();
        $data['respon_produk'] = json_decode($content, true);
        return $data['respon_produk'];
    }
}
