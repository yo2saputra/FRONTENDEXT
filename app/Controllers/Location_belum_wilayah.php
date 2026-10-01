<?php

namespace App\Controllers;

use App\Models\LocationModel;
use CodeIgniter\Controller;

class Location extends Controller
{
    public function getProvinsi()
    {
        $model = new LocationModel();
        $data = $model->getAll('t_provinsi');
        return $this->response->setJSON($data);
    }

    public function getKota($provinceId)
    {
        $model = new LocationModel();
        $data = $model->getByParent('t_kota', 'id', $provinceId, 2);
        return $this->response->setJSON($data);
    }

    public function getKecamatan($cityId)
    {
        $model = new LocationModel();
        $data = $model->getByParent('t_kecamatan', 'id', $cityId, 4);
        return $this->response->setJSON($data);
    }

    public function getKelurahan($districtId)
    {
        $model = new LocationModel();
        $data = $model->getByParent('t_kelurahan', 'id', $districtId, 6);
        return $this->response->setJSON($data);
    }
}
