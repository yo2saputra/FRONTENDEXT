<?php

namespace App\Controllers;

use App\Models\IklanModel;

class Iklan extends BaseController
{
    protected $iklanModel;
    protected $data;

    public function __construct()
    {
        $this->iklanModel = new IklanModel();
    }

    public function modulIklan()
    {
        return $this->data['iklan'] = $this->iklanModel->getIklan();
    }
}
