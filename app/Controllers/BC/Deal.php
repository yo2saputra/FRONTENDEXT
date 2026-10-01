<?php

namespace App\Controllers;

use App\Models\DealModel;

class Deal extends BaseController
{
    protected $dealModel;
    protected $data;

    public function __construct()
    {
        $this->dealModel = new DealModel();
        $this->data = [
            'template' => $this->getTemplateData()
        ];
    }

    public function modulDeal()
    {
        return $data['deal'] = $this->dealModel->getDeal();
    }
}
