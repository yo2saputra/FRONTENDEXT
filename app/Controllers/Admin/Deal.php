<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Master\DealModel;
use App\Controllers\Produk;

class Deal extends BaseController
{
    protected $dealModel;
    protected $data;
    protected $produk;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->client = \Config\Services::curlrequest();
        $this->dealModel = new DealModel();
        $this->produk = new Produk();
    }

    public function index()
    {
        $this->data = [
            'title' => 'Deal | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['deals'] = $this->dealModel->getDeal();

        return view('admin/deal/index', $this->data);
    }

    public function detail($id)
    {
        $this->data = [
            'title' => 'Detail Deal | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['deals'] = $this->dealModel->where(['id' => $id])->first();

        if (empty($this->data['deals'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Id ' . $id . ' tidak ditemukan.');
        }

        return view('admin/deal/detail', $this->data);
    }

    public function edit($id)
    {
        helper(['form']);
        $this->data = [
            'title' => 'Edit Deal | PT. DELTA FOOD DISTRIBUSI'
        ];
        $this->data['deals'] = $this->dealModel->getDeal($id);
        //Set metode request dan endpoint
        $response = $this->client->request('GET', "http://103.136.19.83:8060/wazaran/item_list/all");
        //Ambil body dari response
        $content = $response->getBody();
        $data['respon_produk'] = json_decode($content, true);
        // $this->data['respon_produk'] = $data['respon_produk'];
        $this->data['respon_produk'] = $this->produk->apiProdukGetAll();
        $this->data['filter_produk'] = $this->produk->getProdukFilter();

        return view('admin/deal/edit', $this->data);
    }

    public function update($id)
    {
        helper(['form']);

        $rules = [
            'judulDeal' => [
                'label' => 'Judul Deal',
                'rules' => 'required'
            ],
            'judulDealWarna' => [
                'label' => 'Judul Deal Warna',
                'rules' => 'required'
            ],
            'discDeal' => [
                'label' => 'Disc Deal',
                'rules' => 'required'
            ],
            'kode_item' => [
                'label' => 'Judul Deal',
                'rules' => 'required'
            ],
            'textDeal' => [
                'label' => 'Text Deal',
                'rules' => 'required'
            ],
            'statusDeal' => [
                'label' => 'Status Deal',
                'rules' => 'required'
            ]
        ];

        if ($this->validate($rules)) {

            $this->dealModel->save([
                'id' => $id,
                'judulDeal' => $this->request->getVar('judulDeal'),
                'judulDealWarna' => $this->request->getVar('judulDealWarna'),
                'discDeal' => $this->request->getVar('discDeal'),
                'kode_item' => $this->request->getVar('kode_item'),
                'textDeal' => $this->request->getVar('textDeal'),
                'statusDeal' => $this->request->getVar('statusDeal'),
                'userId' => session()->get('id')
            ]);

            // buat session pesan
            session()->setFlashdata('pesan', 'Data berhasil diupdate!');

            return redirect()->to('/admin/deal');
        } else {

            $this->data = [
                'title' => 'Edit Deal | PT. DELTA FOOD DISTRIBUSI'
            ];

            return redirect()->to('/admin/deal/edit/' . $this->request->getVar('id'))->withInput()->with('errors', $this->validator->getErrors());
        }
    }
}
