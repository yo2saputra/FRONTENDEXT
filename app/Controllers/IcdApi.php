<?php

namespace App\Controllers;

use App\Models\IcdApiModel;
use CodeIgniter\API\ResponseTrait;

class IcdApi extends BaseController
{
    use ResponseTrait;
    protected $model;

    public function __construct()
    {
        $this->model = new IcdApiModel();
    }

    // public function index($id = null)
    // {
    //     if ($id == null) {
    //         $fetchRecord = $this->model->selectRecord("icds");
    //         $result = [
    //             "status" => 201,
    //             "data" => $fetchRecord
    //         ];
    //     } else {
    //         $fetchRecord = $this->model->selectRow("icds", ["code" => $id]);
    //         if (!empty($fetchRecord)) {
    //             $result = [
    //                 "status" => 201,
    //                 "data" => $fetchRecord
    //             ];
    //         } else {
    //             $result = [
    //                 "status" => 404,
    //                 "data" => "No Record Found"
    //             ];
    //         }
    //     }


    //     return $this->respond($fetchRecord);
    // }

    // public function index()
    // {
    //     return view('select_view');
    // }

    public function ajaxSearch()
    {
        // $request = service('request');
        // $searchTerm = $request->getGet('q');
        // $page = $request->getGet('page') ?? 1;

        // $searchTerm = $this->request->getVar('q');
        // $page = $this->request->getVar('page') ?? 1;

        $searchTerm = "pada";
        $page = $this->request->getVar('page') ?? 1;
        $pageSize = 100; // Atur jumlah data per halaman

        $model = new \App\Models\IcdApiModel();
        $results = $model->searchData($searchTerm, $page, $pageSize);

        return $this->response->setJSON($results);
    }

    public function ajaxSearchIdn()
    {
        $searchTerm = $this->request->getVar('search');
        $model = new \App\Models\IcdApiModel();
        $results = $model->searchDataIdn($searchTerm);

        // Generate array with filtered records  
        $dataIcd = array();
        if (count($results) > 0) {
            for ($d = 0; $d < count($results); $d++) {
                $data['id'] = $results[$d]['code'];
                $data['text'] = $results[$d]['code'] . ' - ' . $results[$d]['name_en'] . ' [ ' . $results[$d]['name_id'] . ' ] ';
                $data['english'] = $results[$d]['name_en'];
                $data['indonesia'] = $results[$d]['name_id'];
                array_push($dataIcd, $data);
            }
        }

        // $results = [
        //     "result" => $results
        // ];

        return $this->response->setJSON($dataIcd);
    }
}
