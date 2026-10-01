<?php

namespace App\Controllers;

use App\Models\TemplateModel;
use App\Controllers\Deltafood;

class Template extends BaseController
{
    protected $templateModel;
    protected $deltafood;
    protected $data;

    public function __construct()
    {
        $this->templateModel = new TemplateModel();
        $this->deltafood = new Deltafood();
    }
}
