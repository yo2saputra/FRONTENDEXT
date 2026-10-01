<?php

namespace App\Controllers;

use App\Models\GalleryBudidayaModel;

class GalleryBudidaya extends BaseController
{
    protected $galleryBudidayaModel;
    protected $data;

    public function __construct()
    {
        $this->galleryBudidayaModel = new GalleryBudidayaModel();
        $this->data = [
            'template' => $this->getTemplateData()
        ];
    }

    public function getGalleryBudidaya()
    {
        return $data['galleries'] = $this->galleryBudidayaModel->getGalleryBudidaya();
    }
}
