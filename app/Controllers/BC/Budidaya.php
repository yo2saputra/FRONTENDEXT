<?php

namespace App\Controllers;

use App\Models\BudidayaModel;
use App\Controllers\GalleryBudidaya;

class Budidaya extends BaseController
{
    protected $session = null;
    protected $data;
    protected $budidayaModel;
    protected $galleryBudidaya;

    public function __construct()
    {
        $this->data = [
            'title' => 'Budidaya |  PT. DELTA FOOD DISTRIBUSI',
            'template' => $this->getTemplateData()
        ];
        $this->budidayaModel = new BudidayaModel();
        $this->galleryBudidaya = new GalleryBudidaya();
    }

    public function index()
    {
        $this->data['budidayas'] = $this->budidayaModel->getBudidaya();
        $this->data['galleries'] = $this->galleryBudidaya->getGalleryBudidaya();

        return view('budidaya', $this->data);
    }
}
