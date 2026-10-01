<?php

namespace App\Controllers;

use App\Models\OperasionalModel;
use App\Controllers\GalleryOperasional;

class Operasional extends BaseController
{
    protected $session = null;
    protected $data;
    protected $operasionalModel;
    protected $galleryOperasional;

    public function __construct()
    {
        $this->data = [
            'title' => 'Operasional |  PT. DELTA FOOD DISTRIBUSI',
            'template' => $this->getTemplateData()
        ];
        $this->operasionalModel = new OperasionalModel();
        $this->galleryOperasional = new GalleryOperasional();
    }

    public function index()
    {
        $this->data['operasionals'] = $this->operasionalModel->getOperasional();
        $this->data['galleries'] = $this->galleryOperasional->getGalleryOperasional();

        return view('operasional', $this->data);
    }
}
