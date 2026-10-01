<?php

namespace App\Controllers;

use App\Models\CarouselModel;

class Carousel extends BaseController
{
    protected $carouselModel;
    protected $data;

    public function __construct()
    {
        $this->carouselModel = new CarouselModel();
        $this->data = [
            'template' => $this->getTemplateData()
        ];
    }

    public function index()
    {
        $this->data['title'] = 'Carousel | PT. DELTA FOOD DISTRIBUSI';
        $this->data['carousel'] = $this->carouselModel->getCarousel();
        return view('mitra', $this->data);
    }

    public function modulCarousel()
    {
        return $data['carousel'] = $this->carouselModel->getCarousel();
    }
}
