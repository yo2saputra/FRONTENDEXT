<?php

namespace App\Controllers;

use App\Models\LocationModel;

class Location extends BaseController
{
    protected $locationModel;

    public function __construct()
    {
        $this->locationModel = new LocationModel();
    }

    /**
     * Get province list
     */
    public function getProvinsi()
    {
        $data = $this->locationModel->getProvinsi();
        return $this->response->setJSON($data);
    }

    /**
     * Get city list by province code
     * @param string $provinceId - Kode provinsi (2 digit)
     */
    public function getKota($provinceId)
    {
        $data = $this->locationModel->getKota($provinceId);
        return $this->response->setJSON($data);
    }

    /**
     * Get district list by city code
     * @param string $cityId - Kode kabupaten/kota (5 karakter)
     */
    public function getKecamatan($cityId)
    {
        $data = $this->locationModel->getKecamatan($cityId);
        return $this->response->setJSON($data);
    }

    /**
     * Get village list by district code
     * @param string $districtId - Kode kecamatan (8 karakter)
     */
    public function getKelurahan($districtId)
    {
        $data = $this->locationModel->getKelurahan($districtId);
        return $this->response->setJSON($data);
    }

    /**
     * Get kodepos by village code (kode wilayah 13 karakter)
     * @param string $kodeKelurahan - Kode wilayah 13 karakter (contoh: 36.74.07.1004)
     * @return JSON
     */
    public function getKodeposByKelurahan($kodeKelurahan)
    {
        // Validasi parameter
        if (empty($kodeKelurahan)) {
            return $this->response->setJSON(['kodepos' => '']);
        }

        // Cari data berdasarkan kode wilayah
        $data = $this->locationModel->getKodeposByKelurahan($kodeKelurahan);

        if ($data) {
            return $this->response->setJSON([
                'kodepos' => $data->kodepos ?? ''
            ]);
        }

        return $this->response->setJSON(['kodepos' => '']);
    }

    /**
     * Search kodepos by term (kode pos atau nama kelurahan)
     * @return JSON
     */
    public function searchKodepos()
    {
        $term = $this->request->getVar('term');

        if (empty($term) || strlen($term) < 3) {
            return $this->response->setJSON(['results' => []]);
        }

        $results = $this->locationModel->searchKodepos($term);

        return $this->response->setJSON([
            'results' => $results
        ]);
    }

    /**
     * Get complete hierarchy by village code
     * @param string $kodeKelurahan - Kode wilayah 13 karakter
     * @return JSON
     */
    public function getHierarchy($kodeKelurahan)
    {
        if (empty($kodeKelurahan)) {
            return $this->response->setJSON([]);
        }

        $data = $this->locationModel->getHierarchy($kodeKelurahan);
        return $this->response->setJSON($data);
    }
}
