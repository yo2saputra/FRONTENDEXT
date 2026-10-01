<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Master\ModulProdukFilterModel;
use App\Models\Master\ProdukFilterModel;
use App\Models\Master\ProdukModel;

class Produk extends BaseController
{
    protected $client;
    protected $data;
    protected $modulProdukFilterModel;
    protected $produkFilterModel;
    protected $produkModel;

    public function __construct()
    {
        //library CURLrequest
        $this->client = \Config\Services::curlrequest();
        $this->modulProdukFilterModel = new ModulProdukFilterModel();
        $this->produkFilterModel = new ProdukFilterModel();
        $this->produkModel = new ProdukModel();
        $this->data = [
            'template' => $this->getTemplateData()
        ];
    }

    public function index()
    {
        $this->data['title'] = 'Produk | PT. DELTA FOOD DISTRIBUSI';
        $this->data['produk'] = $this->produkModel->getDetailProduk();
        return view('admin/produk/index', $this->data);
    }

    public function detail($id = null)
    {
        $this->data['title'] = 'Detail Produk | PT. DELTA FOOD DISTRIBUSI';
        if (is_null($id)) {
            return redirect()->to('admin/produk');
        }
        $this->data['produk'] = $this->produkModel->getDetailProduk($id);
        // $this->data['produks'] = $this->modulProdukTerkait();
        return view('admin/produk/detail', $this->data);
    }

    public function edit($id)
    {
        helper(['form']);
        $this->data = [
            'title' => 'Edit Produk | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['produk'] = $this->produkModel->getDetailProduk($id);
        return view('admin/produk/edit', $this->data);
    }

    public function update($id)
    {
        helper(['form']);

        $rules = [
            'judulDetailProduk' => [
                'label' => 'Judul Produk',
                'rules' => 'required'
            ],
            'judulDetailProdukWarna' => [
                'label' => 'Judul Produk Warna',
                'rules' => 'required'
            ],
            'textDetailProdukTerkait' => [
                'label' => 'Text Produk Terkait',
                'rules' => 'required'
            ]
        ];

        if ($this->validate($rules)) {

            $this->produkModel->save([
                'id' => $id,
                'judulDetailProduk' => $this->request->getVar('judulDetailProduk'),
                'judulDetailProdukWarna' => $this->request->getVar('judulDetailProdukWarna'),
                'textDetailProdukTerkait' => $this->request->getVar('textDetailProdukTerkait'),
                'userId' => session()->get('id')
            ]);

            // buat session pesan
            session()->setFlashdata('pesan', 'Data berhasil diupdate!');

            return redirect()->to('/admin/produk');
        } else {

            $this->data = [
                'title' => 'Edit Produk | PT. DELTA FOOD DISTRIBUSI'
            ];

            return redirect()->to('/admin/produk/edit/' . $this->request->getVar('id'))->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function modulProduk($item)
    {
        $this->data['produk'] = array_slice($this->apiProdukGetAll(), 0, $item);
        return $this->data['produk'];
    }

    public function modulProdukTerkait()
    {
        $this->data['produk'] = array_slice($this->apiProdukGetAll(), 0, 6);
        return $this->data['produk'];
    }

    public function filter()
    {
        $this->data['title'] = 'Produk Filter | PT. DELTA FOOD DISTRIBUSI';
        $this->data['produk'] = $this->apiProdukGetAll();
        $this->data['produk_filter'] = $this->produkFilterModel->getProdukFilter();
        return view('admin/produk/filter', $this->data);
    }

    public function update_filter($id)
    {
        helper(['form']);

        $this->produkFilterModel->save([
            'id' => $id,
            'filter' => $this->request->getVar('filter'),
            'userId' => session()->get('id')
        ]);

        // buat session pesan
        session()->setFlashdata('pesan', 'Data berhasil diupdate!');

        return redirect()->to('/admin/produk/filter');
    }

    public function filter_modul()
    {
        $this->data['title'] = 'Produk Filter Modul | PT. DELTA FOOD DISTRIBUSI';
        $this->data['produk'] = $this->apiProdukGetAll();
        $this->data['produk_filter'] = $this->modulProdukFilterModel->getProdukFilterModul();
        return view('admin/produk/filter_modul', $this->data);
    }

    public function update_filter_modul($id)
    {
        helper(['form']);

        $this->modulProdukFilterModel->save([
            'id' => $id,
            'filter' => $this->request->getVar('filter'),
            'userId' => session()->get('id')
        ]);

        // buat session pesan
        session()->setFlashdata('pesan', 'Data berhasil diupdate!');

        return redirect()->to('/admin/produk/modul_produk_filter');
    }

    public function apiProdukGetAll()
    {
        //Set metode request dan endpoint
        $response = $this->client->request('GET', 'http://103.136.19.83:8060/wazaran/item_list/all');
        //Ambil body dari response
        $content = $response->getBody();
        $data['respon_produk'] = json_decode($content, true);

        return $data['respon_produk'];
    }

    public function apiProdukGetById($id = null)
    {
        //Set metode request dan endpoint
        $response = $this->client->request("GET", "http://103.136.19.83:8060/wazaran/item_list/$id");
        //Ambil body dari response
        $content = $response->getBody();
        $data['respon_produk'] = json_decode($content, true);

        return $data['respon_produk'];
    }

    public function getProdukFilterModul()
    {
        $data['produk_filter'] = $this->modulProdukFilterModel->getProdukFilterModul();
        return $data['produk_filter'];
    }

    public function getProdukFilter()
    {
        $data['produk_filter'] = $this->produkFilterModel->getProdukFilter();
        return $data['produk_filter'];
    }
}
