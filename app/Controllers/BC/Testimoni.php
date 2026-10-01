<?php

namespace App\Controllers;

use App\Models\TestimoniModel;

class Testimoni extends BaseController
{
    protected $testimoniModel;
    public function __construct()
    {
        $this->testimoniModel = new TestimoniModel();
    }

    public function modulTestimoni()
    {
        return $data['testimoni'] = $this->testimoniModel->getTestimoni();
    }
}
