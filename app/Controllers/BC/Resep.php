<?php

namespace App\Controllers;

use App\Models\ResepModel;
use App\Controllers\Mitra;
use App\Controllers\Produk;

class Resep extends BaseController
{
    protected $resepModel, $mitra, $data;
    protected $produk;

    public function __construct()
    {
        $this->resepModel = new ResepModel();
        $this->mitra = new Mitra();
        $this->produk = new Produk();
        $this->data = [
            'template' => $this->getTemplateData()
        ];
    }

    public function index()
    {
        $this->data['title'] = 'Resep | PT. DELTA FOOD DISTRIBUSI';
        $this->data['resep'] = $this->resepModel->getResep();
        // dd($this->data['resep']);
        $this->data['pager'] = $this->resepModel->pager;
        $this->data['mitras'] = $this->mitra->modulMitra();

        return view('resep', $this->data);
    }

    public function detail($id = false)
    {
        $this->data['title'] = 'Detail Resep | PT. DELTA FOOD DISTRIBUSI';
        $this->data['resep'] = $this->resepModel->getResepDetail($id);
        $this->data['resepTerbaru'] = $this->resepTerbaru(5);
        $this->data['resepArsip'] = $this->resepArsip(5);
        $this->data['produks'] = $this->produk->modulProduk();
        $this->data['produk_filter'] = $this->produk->getProdukFilter();
        //dd($this->data['resepArsip']);

        return view('resep_detail', $this->data);
    }

    public function modulResep($card)
    {
        $this->data['resep'] = $this->resepModel->getResepSelected($card);
        return $this->data['resep'];
    }

    public function resepTerbaru($baris)
    {
        $this->data['resepTerbaru'] = $this->resepModel->getResepTerbaru($baris);
        return $this->data['resepTerbaru'];
    }

    public function resepArsip($baris)
    {
        $this->data['resepArsip'] = $this->resepModel->getResepArsip($baris);
        return $this->data['resepArsip'];
    }

    public function arsip($tahun)
    {
        $this->data['title'] = 'Resep Arsip | PT. DELTA FOOD DISTRIBUSI';
        $this->data['resep'] = $this->resepModel->getResepArsipTahun($tahun);
        $this->data['pager'] = $this->resepModel->pager;
        $this->data['mitras'] = $this->mitra->modulMitra();

        return view('resep', $this->data);
    }
}
