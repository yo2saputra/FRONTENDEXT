<?php

namespace App\Controllers;

class Cabang extends BaseController
{
    protected $client;
    protected $data;

    public function __construct()
    {
        //library CURLrequest
        $this->client = \Config\Services::curlrequest();
        $this->data = [
            'template' => $this->getTemplateData()
        ];
    }

    public function index()
    {

        $this->data['title'] = 'Cabang | PT. DELTA FOOD DISTRIBUSI';
        //Set metode request dan endpoint
        $response = $this->client->request('GET', 'https://test-api.jualinternet.com/cabang');

        //Ambil body dari response
        $content = $response->getBody();
        $data['respon_cabang'] = json_decode($content, true);
        $this->data['cabang'] = $data['respon_cabang']['cabang'];


        return view('cabang', $this->data);
    }

    public function modulCabang()
    {
        $this->data['cabang'] = $this->apiCabangGetAll();
        return $this->data['cabang'];
    }

    public function apiCabangGetAll()
    {
        //Set metode request dan endpoint
        $response = $this->client->request('GET', 'https://test-api.jualinternet.com/cabang');

        //Ambil body dari response
        $content = $response->getBody();
        $data['respon_cabang'] = json_decode($content, true);
        $data['cabang'] = $data['respon_cabang']['cabang'];
        return $data['cabang'];
    }
}
