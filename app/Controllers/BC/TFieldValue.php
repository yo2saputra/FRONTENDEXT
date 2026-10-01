<?php

namespace App\Controllers;

//use App\Controllers\Mitra;
//use App\Models\Master\ProdukFilterModel;
//use App\Models\Master\ProdukModel;

use App\Libraries\Pdfgenerator;

class TFieldValue extends BaseController
{
    protected $client;
    protected $data;
    //protected $mitra;
    //protected $produkFilterModel;
    //protected $produkModel;

    public function __construct()
    {
        //library CURLrequest
        $this->client = \Config\Services::curlrequest();
        //$this->mitra = new Mitra();
        //$this->produkModel = new ProdukModel();
        //$this->produkFilterModel = new ProdukFilterModel();
        $this->data = [
            'template' => $this->getTemplateData()
        ];
    }

    public function index()
    {
        $this->data['title'] = 'Produk | PT. DELTA FOOD DISTRIBUSI';
        $this->data['produk'] = $this->apiProdukGetAll();

        //dd($this->data['produk']);
        //$this->data['produk_filter'] = $this->getProdukFilter();
        //$this->data['mitras'] = $this->mitra->modulMitra();
        return view('tfieldvalue', $this->data);
    }

    public function detail($id = null)
    {
        $this->data['title'] = 'Detail Produk | PT. DELTA FOOD DISTRIBUSI';
        if (is_null($id)) {
            return redirect()->to('/produk');
        }
        $this->data['produkDetail'] = $this->apiProdukGetById($id);
        $this->data['produks'] = $this->modulProdukTerkait();
        //$this->data['pageProdukDetail'] = $this->pageProdukDetail();
        //$this->data['produk_filter'] = $this->getProdukFilter();

        return view('produk_detail', $this->data);
    }

    public function modulProduk()
    {
        $this->data['produk'] = $this->apiProdukGetAll();
        return $this->data['produk'];
    }

    public function modulProdukTerkait()
    {
        $this->data['produk'] = $this->apiProdukGetAll();
        return $this->data['produk'];
    }

    public function apiProdukGetAll()
    {
        //Set metode request dan endpoint
        $response = $this->client->request('GET', 'http://103.136.19.83:8060/clinic/tfield_value');
        //Ambil body dari response
        $content = $response->getBody();
        $data['respon_produk'] = json_decode($content, true);
        return $data['respon_produk'];
    }

    public function apiProdukGetById($id = null)
    {
        //Set metode request dan endpoint dengan parameter id
        $response = $this->client->request("GET", "http://103.136.19.83:8060/wazaran/item_list/$id");
        //Ambil body dari response
        $content = $response->getBody();
        $data['respon_produk'] = json_decode($content, true);
        return $data['respon_produk'];
    }

    // public function getProdukFilter()
    // {
    //     $data['produk_filter'] = $this->produkFilterModel->getProdukFilter();
    //     return $data['produk_filter'];
    // }

    // public function pageProdukDetail()
    // {
    //     $data['detailProduk'] = $this->produkModel->getDetailProduk();
    //     return $data['detailProduk'];
    // }

    public function view_pdf()
    {
        $Pdfgenerator = new Pdfgenerator();

        // title dari pdf
        $this->data['title_pdf'] = 'Laporan Penjualan Toko Kita';

        //data
        $this->data['produk'] = $this->apiProdukGetAll();

        // filename dari pdf ketika didownload
        $file_pdf = 'laporan_penjualan_toko_kita';

        // setting paper
        $paper = 'A4';

        //orientasi paper potrait / landscape
        $orientation = "portrait";

        $html = view('laporan_pdf', $this->data);

        // run dompdf
        $Pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    }
}
