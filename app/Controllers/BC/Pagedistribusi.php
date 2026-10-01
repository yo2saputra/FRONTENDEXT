<?php

namespace App\Controllers;

use App\Models\PagedistribusiModel;

class Pagedistribusi extends BaseController
{
    protected $pagedistribusiModel;
    protected $data;

    public function __construct()
    {
        $this->data = [
            'title' => 'Page Distribusi|  PT. DELTA FOOD DISTRIBUSI',
            'template' => $this->getTemplateData()
        ];
        $this->pagedistribusiModel = new PagedistribusiModel();
    }

    public function getPagedistribusi()
    {
        $this->data['pagedistribusi'] = $this->pagedistribusiModel->getPagedistribusi();
        return $this->data['pagedistribusi'];
    }
}
