<?php

namespace App\Controllers;

use App\Models\MitraModel;

class Mitra extends BaseController
{
    protected $mitraModel;
    protected $data;

    public function __construct()
    {
        $this->mitraModel = new MitraModel();
        $this->data = [
            'template' => $this->getTemplateData()
        ];
    }

    public function index()
    {
        $this->data['title'] = 'Mitra | PT. DELTA FOOD DISTRIBUSI';
        $this->data['mitra'] = $this->mitraModel->getMitra();
        return view('mitra', $this->data);
    }

    public function modulMitra()
    {
        return $data['mitra'] = $this->mitraModel->getMitra();
    }
}
