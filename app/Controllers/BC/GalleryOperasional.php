<?php

namespace App\Controllers;

use App\Models\GalleryOperasionalModel;

class GalleryOperasional extends BaseController
{
    protected $galleryOperasionalModel;
    protected $data;

    public function __construct()
    {
        $this->galleryOperasionalModel = new GalleryOperasionalModel();
        $this->data = [
            'template' => $this->getTemplateData()
        ];
    }

    public function getGalleryOperasional()
    {
        return $data['galleries'] = $this->galleryOperasionalModel->getGalleryOperasional();
    }
}
