<?php

namespace App\Controllers\Clinic;

use App\Controllers\BaseController;
//use App\Libraries\Pdfgenerator;



class Dokter2 extends BaseController
{

    protected $data;
    protected $server;
    protected $client;

    public function __construct()
    {
        $this->session = session();
        $this->server = $_ENV['APP_API'];

        //library CURLrequest
        //$this->client = \Config\Services::curlrequest();
        $this->client = service('curlrequest');
    }

    public function index()
    {

        $this->data['title'] = 'Dokter | ' . $_ENV['APP_TITLE'];
        $this->data['blood_typ'] = $this->apiDropdownq();
        $this->data['cb_city_cd'] = $this->getDropdown('city_cd', 'Kota');
        $this->data['cb_classteraphy_cd'] = $this->getDropdown('classteraphy_cd', 'Kelas Terapi');
        $this->data['cb_drug_typ'] = $this->getDropdown('drug_typ', 'Drug Type');

        return view('clinic/dokter2/index', $this->data);
    }

    public function apiDropdownq()
    {
        //Set metode request dan endpoint
        $response = $this->client->request("GET", "$this->server/clinic/dropdown/tfieldvalues/blood_typ");
        //Ambil body dari response
        $content = $response->getBody();
        $data['response_data'] = json_decode($content, true);
        return $data['response_data'];
    }

    public function apiProdukGetAll()
    {
        //Set metode request dan endpoint
        $response = $this->client->request("GET", "$this->server/clinic/tfield_value/getall");
        //Ambil body dari response
        $content = $response->getBody();
        $data['response_data'] = json_decode($content, true);
        return $data['response_data'];
    }

    public function fetchAll()
    {
        if ($this->request->isAJAX()) {


            $output = '';
            $data =  $this->apiProdukGetAll();
            $output .= '  
                    <table id="example4" class="table table-hover table-striped">
                    <thead>
                            <tr>  
                                <th>Nama</th>
                                <th>Value</th>
                                <th>Desc</th>
                                <th></th>
                            </tr>
                        </thead>
                            ';
            if ($data == '') {
                $output .= '<tr>  
                                    <td >Data not Found</td>
                                    <td ></td>
                                    <td ></td>
                                    <td ></td>
                                </tr>';
            } else {
                for ($a = 0; $a < count($data); $a++) {
                    $output .= '  
                            <tr id="addMdlBarang" data-id="' . $data[$a]["fld_valu"] . '">
                                <td >' . $data[$a]["fld_nm"] . '</td>
                                <td >' . $data[$a]["fld_valu"] . '</td>
                                <td >' . $data[$a]["fld_desc"] . '</td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm float-right mr-1 mt-1 delete btn-fix-w" data-fld_nm="' . $data[$a]["fld_nm"] . '" data-fld_valu="' . $data[$a]["fld_valu"] . '">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm float-right mr-1 mt-1 edit btn-fix-w" data-fld_nm="' . $data[$a]["fld_nm"] . '" data-fld_valu="' . $data[$a]["fld_valu"] . '">
                                        <i class="fas fa-tags"></i>
                                    </button>
                                </td>
                            </tr>  
                    ';
                }
                //onclick="delete(' . $data[$a]["fld_valu"] . ')"
            }
            $output .= '</table>
                <script type="text/javascript">
                $(function () {
                    $("#example4").DataTable({
                    columnDefs: [
                        { orderable: false, targets: 3 }
                    ],
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "info": false,
                    "autoWidth": true
                    });
                });
                </script>
                ';
            echo $output;
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }


    public function delete()
    {
        if ($this->request->isAJAX()) {
            $fld_nm = $this->request->getVar('fld_nm');
            $fld_valu = $this->request->getVar('fld_valu');

            $response = $this->client->request("DELETE", "$this->server/clinic/tfield_value/delete/$fld_nm/$fld_valu");

            $content = $response->getBody();
            $data['respon_data'] = json_decode($content, true);

            $msg = [
                'success' => "Data dengan nama $fld_nm berhasil dihapus"
                //'success' => $data['respon_data']
            ];
            echo json_encode($msg);
        }
    }

    function action()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getVar('action')) {
                helper(['form', 'url']);

                $validation = \Config\Services::validation();
                $valid = $this->validate([
                    'nama' => [
                        'label' => 'Nama',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'value' => [
                        'label' => 'Value',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'desc' => [
                        'label' => 'Desc',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ]
                ]);
                if (!$valid) {
                    $msg = [
                        'error' => [
                            'nama' => $validation->getError('nama'),
                            'value' => $validation->getError('value'),
                            'desc' => $validation->getError('desc')
                        ]
                    ];
                } else {

                    if ($this->request->getVar('action') == 'Add') {

                        $response = $this->client->request("POST", "$this->server/clinic/tfield_value/insert", [
                            "headers" => [
                                //"Content-Type: application/json",
                                "Accept" => "application/json"
                            ],
                            "form_params" => [
                                "fld_nm" => $this->request->getVar('nama'),
                                "fld_valu" => $this->request->getVar('value'),
                                "fld_desc" => $this->request->getVar('desc')
                            ]
                        ]);

                        $msg = [
                            'success' => 'data berhasil di create!'
                        ];
                    }

                    if ($this->request->getVar('action') == 'Edit') {
                        $fld_nm = $this->request->getVar('nama');
                        $fld_valu = $this->request->getVar('value');

                        $response = $this->client->request("PUT", "$this->server/clinic/tfield_value/update/$fld_nm/$fld_valu", [
                            "headers" => [
                                //"Content-Type: application/json",
                                "Accept" => "application/json"
                            ],
                            "form_params" => [
                                "fld_desc" => $this->request->getVar('desc')
                                //"fld_desc" => 'seng123'
                            ]
                        ]);

                        $msg = [
                            'success' => 'data berhasil diupdate'
                        ];
                    }
                }

                echo json_encode($msg);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }



    function fetchSingleData()
    {
        if ($this->request->isAJAX()) {

            $fld_nm = $this->request->getVar('fld_nm');
            $fld_valu = $this->request->getVar('fld_valu');

            if ($fld_nm) {

                $response = $this->client->request("GET", "$this->server/clinic/tfield_value/getby/$fld_nm/$fld_valu", [
                    "headers" => [
                        "Accept" => "application/json"
                    ]
                ]);

                $content = $response->getBody();
                $data['respon_produk'] = json_decode($content, true);

                $msg = [
                    'data' => [
                        'nama' => $data["respon_produk"][0]["fld_nm"],
                        'value' => $data["respon_produk"][0]["fld_valu"],
                        'desc' => $data["respon_produk"][0]["fld_desc"]
                    ]
                ];

                echo json_encode($msg);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }
}
