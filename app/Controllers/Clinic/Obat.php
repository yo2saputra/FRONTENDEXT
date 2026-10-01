<?php

namespace App\Controllers\Clinic;

use App\Controllers\BaseController;
//use App\Libraries\Pdfgenerator;



class Obat extends BaseController
{

    protected $data;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->session = session();

        //library CURLrequest
        $this->client = \Config\Services::curlrequest();
    }

    public function index()
    {

        $this->data['title'] = 'Produk | PT. DELTA FOOD DISTRIBUSI';
        $this->data['produk'] = $this->apiProdukGetAll();

        return view('clinic/obat/index', $this->data);
    }

    public function apiProdukGetAll()
    {
        //Set metode request dan endpoint
        $response = $this->client->request('GET', 'http://103.136.19.83:8060/clinic/tfield_value/getall');
        //Ambil body dari response
        $content = $response->getBody();
        $data['respon_produk'] = json_decode($content, true);
        return $data['respon_produk'];
    }

    public function ambildata()
    {
        if ($this->request->isAJAX()) {

            $data =  $this->apiProdukGetAll();
            $msg = [
                'data' => view('clinic/pasien/ambildata', $data)
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    public function formtambah()
    {
        if ($this->request->isAJAX()) {
            $msg = [
                'data' => view('clinic/pasien/modaltambah')
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    // public function index()
    // {
    //     $curl = service('curlrequest');

    //     $posts_data = $curl->request("GET", "http://103.136.19.83:8060/clinic/tfield_value/getall", [
    //         "headers" => [
    //             "Accept" => "application/json"
    //         ]
    //     ]);

    //     echo "<pre>";
    //     print_r($posts_data->getBody());
    // }

    public function get()
    {
        $curl = service('curlrequest');

        $posts_data = $curl->request("GET", "http://103.136.19.83:8060/clinic/tfield_value/1", [
            "headers" => [
                "Accept" => "application/json"
            ]
        ]);

        echo "<pre>";
        print_r($posts_data->getBody());
    }

    // public function create()
    // {
    //     $curl = service('curlrequest');

    //     $posts_data = $curl->request("POST", "http://103.136.19.83:8060/clinic/tfield_value/insert", [
    //         "headers" => [
    //             //"Content-Type: application/json",
    //             "Accept" => "application/json"
    //         ],
    //         "form_params" => [
    //             "fld_nm" => "----yoyo",
    //             "fld_valu" => "string",
    //             "fld_desc" => "yoyo saputra"
    //         ]
    //     ]);

    //     echo "<pre>";
    //     print_r($posts_data->getBody());
    // }

    // public function update()
    // {
    //     $curl = service('curlrequest');

    //     $posts_data = $curl->request("PUT", "http://103.136.19.83:8060/clinic/tfield_value/update/---trial/trial", [
    //         "headers" => [
    //             //"Content-Type: application/json",
    //             "Accept" => "application/json"
    //         ],
    //         "form_params" => [
    //             "fld_desc" => "Berhasil"
    //         ]
    //     ]);

    //     echo "<pre>";
    //     print_r($posts_data->getBody());
    // }

    // public function delete()
    // {
    //     $curl = service('curlrequest');

    //     $posts_data = $curl->request("DELETE", "http://103.136.19.83:8060/clinic/tfield_value/delete/--yoyo/yy");

    //     echo "<pre>";
    //     print_r($posts_data->getBody());
    // }

    public function detail($fld_nm, $fld_valu)
    {

        $this->data = [
            'title' => 'Detail Distribusi | PT. DELTA FOOD DISTRIBUSI'
        ];

        //$this->data['distribusies'] = $this->distribusiModel->where(['id' => $id])->first();

        if (empty($this->data['distribusies'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Id ' . $fld_nm . '' . $fld_valu . ' tidak ditemukan.');
        }

        return view('admin/distribusi/detail', $this->data);
    }

    public function create()
    {
        helper(['form']);
        $this->data = [
            'title' => 'Create Obat | PT. DELTA FOOD DISTRIBUSI'
        ];

        $this->data['validation'] = $this->validator;

        return view('clinic/obat/create', $this->data);
    }

    public function save()
    {
        helper(['form']);
        $rules = [
            'fld_nm' => [
                'label' => 'Nama',
                'rules' => 'required'
            ],
            'fld_valu' => [
                'label' => 'Value',
                'rules' => 'required'
            ],
            'fld_desc' => [
                'label' => 'Desc',
                'rules' => 'required'
            ]
        ];

        if ($this->validate($rules)) {

            $curl = service('curlrequest');

            $posts_data = $curl->request("POST", "http://103.136.19.83:8060/clinic/tfield_value/insert", [
                "headers" => [
                    //"Content-Type: application/json",
                    "Accept" => "application/json"
                ],
                "form_params" => [
                    "fld_nm" => $this->request->getVar('fld_nm'),
                    "fld_valu" => $this->request->getVar('fld_valu'),
                    "fld_desc" => $this->request->getVar('fld_desc')
                ]
            ]);

            session()->setFlashdata('pesan', 'Data berhasil tambah!');

            return redirect()->to('/clinic/obat');
        } else {

            $this->data = [
                'title' => 'Create Distribusi | PT. DELTA FOOD DISTRIBUSI'
            ];

            return redirect()->to('/clinic/obat/create')->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function edit($id)
    {
        helper(['form']);
        $this->data = [
            'title' => 'Edit Distribusi | PT. DELTA FOOD DISTRIBUSI'
        ];

        //$this->data['distribusies'] = $this->distribusiModel->getDistribusi($id);

        return view('admin/distribusi/edit', $this->data);
    }

    public function update($fld_nm, $fld_valu)
    {
        helper(['form']);
        $rules = [
            'fld_nm' => [
                'label' => 'Nama',
                'rules' => 'required'
            ],
            'fld_valu' => [
                'label' => 'Value',
                'rules' => 'required'
            ],
            'fld_desc' => [
                'label' => 'Desc',
                'rules' => 'required'
            ]
        ];


        if ($this->validate($rules)) {

            $curl = service('curlrequest');

            $posts_data = $curl->request("PUT", "http://103.136.19.83:8060/clinic/tfield_value/update/$fld_nm/$fld_valu", [
                "headers" => [
                    //"Content-Type: application/json",
                    "Accept" => "application/json"
                ],
                "form_params" => [
                    "fld_desc" => "Berhasil"
                ]
            ]);

            // buat session pesan
            session()->setFlashdata('pesan', 'Data berhasil diupdate!');

            return redirect()->to('/clinic/obat');
        } else {

            $this->data = [
                'title' => 'Edit Distribusi | PT. DELTA FOOD DISTRIBUSI'
            ];

            return redirect()->to('/clinic/obat/edit/' . $this->request->getVar('id'))->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function delete($fld_nm, $fld_valu)
    {
        $curl = service('curlrequest');

        $posts_data = $curl->request("DELETE", "http://103.136.19.83:8060/clinic/tfield_value/delete/$fld_nm/$fld_valu");

        session()->setFlashdata('pesan', 'Data berhasil dihapus!');
        return redirect()->to('/clinic/obat');
    }
}
