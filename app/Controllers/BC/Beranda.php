<?php

namespace App\Controllers;

use App\Models\BerandaModel;
use App\Controllers\Blog;
use App\Controllers\Testimoni;
use App\Controllers\Mitra;
use App\Controllers\Deal;
use App\Controllers\Produk;
use App\Controllers\Iklan;
use App\Controllers\Deltafood;
use App\Controllers\Carousel;

class Beranda extends BaseController
{
    protected $blog;
    protected $berandaModel;
    protected $modulProdukFilterModel;
    protected $session = null;
    protected $data;
    protected $testimoni;
    protected $mitra;
    protected $deal;
    protected $produk;
    protected $iklan;
    protected $deltafood;
    protected $carousel;

    public function __construct()
    {
        $this->data = [
            'title' => 'Beranda |  PT. DELTA FOOD DISTRIBUSI',
            'template' => $this->getTemplateData()
        ];
        $this->berandaModel = new BerandaModel();
        $this->blog = new Blog();
        $this->testimoni = new Testimoni();
        $this->mitra = new Mitra();
        $this->deal = new Deal();
        $this->produk = new Produk();
        $this->iklan = new Iklan();
        $this->deltafood = new Deltafood();
        $this->carousel = new Carousel();
    }

    public function index()
    {
        $this->data['respon_produk'] = $this->produk->apiProdukGetAll();
        $this->data['deal'] = $this->deal->modulDeal();
        $this->data['beranda'] = $this->berandaModel->getBeranda();
        $this->data['blog'] = $this->blog->modulBlog(3);
        $this->data['testimoni'] = $this->testimoni->modulTestimoni();
        $this->data['mitras'] = $this->mitra->modulMitra();
        $this->data['produks'] = $this->produk->modulProduk();
        $this->data['produk_filter'] = $this->produk->getProdukFilter();
        $this->data['iklan'] = $this->iklan->modulIklan();
        $this->data['deltafood'] = $this->deltafood->getModulDeltafood();
        $this->data['carousels'] = $this->carousel->modulCarousel();
        // dd($this->data['carousels']);

        return view('beranda', $this->data);
    }
}
