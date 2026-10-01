<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
//use App\Models\DeltafoodModel;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Beranda | PT. DELTA FOOD DISTRIBUSI'
        ];

        //model
        //$berandaModel = new BerandaModel();
        //$beranda = $berandaModel->findAll();

        //dd($bearanda);

        //return view('admin\deltafood', $data);
        return view('admin/home', $data);
    }
}
