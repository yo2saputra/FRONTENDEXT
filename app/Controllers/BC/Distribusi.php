<?php

namespace App\Controllers;

use App\Models\DistribusiModel;
use App\Controllers\Cabang;
use App\Controllers\Pagedistribusi;

class Distribusi extends BaseController
{
    protected $distribusiModel;
    protected $data;
    protected $cabang;
    protected $pagedistribusi;

    public function __construct()
    {
        $this->distribusiModel = new DistribusiModel();
        $this->pagedistribusi = new Pagedistribusi();
        $this->cabang = new Cabang();
        $this->data = [
            'template' => $this->getTemplateData()
        ];
    }

    public function index()
    {
        $this->data['title'] = 'Distribusi | PT. DELTA FOOD DISTRIBUSI';
        $this->data['distribusies'] = $this->distribusiModel->getDistribusi();
        $this->data['pagedistribusi'] = $this->pagedistribusi->getPagedistribusi();
        $this->data['cabangs'] = $this->cabang->modulCabang();
        return view('distribusi', $this->data);
    }
}
