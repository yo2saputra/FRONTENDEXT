<?php

namespace App\Controllers;

use App\Models\DeltafoodModel;
use App\Controllers\Testimoni;
use App\Controllers\Mitra;
use App\Controllers\Iklan;

class Deltafood extends BaseController
{
    protected $data;
    protected $deltafoodModel;
    protected $mitra;
    protected $testimoni;
    protected $iklan;

    public function __construct()
    {
        $this->deltafoodModel = new DeltafoodModel();
        $this->mitra = new Mitra();
        $this->testimoni = new Testimoni();
        $this->iklan = new Iklan();
        $this->data = [
            'template' => $this->getTemplateData()
        ];
    }

    public function index()
    {
        $this->data['title'] = 'Delta Food | PT. DELTA FOOD DISTRIBUSI';
        $this->data['testimoni'] = $this->testimoni->modulTestimoni();
        $this->data['mitras'] = $this->mitra->modulMitra();
        $this->data['iklan'] = $this->iklan->modulIklan();
        $this->data['deltafood'] = $this->getDeltafood();

        return view('deltafood', $this->data);
    }

    public function getTextFooterDeltafood()
    {
        return $this->data['deltafood'] = $this->deltafoodModel->getDeltafood();
    }

    // public function modulIklan()
    // {
    //     return $this->data['iklan'] = $this->iklan->modulIklan();
    // }

    public function getDeltafood()
    {
        return $this->data['deltafood'] = $this->deltafoodModel->getDeltafood();
    }

    public function getModulDeltafood()
    {
        return $this->data['deltafood'] = $this->deltafoodModel->getModulDeltafood();
    }
}
