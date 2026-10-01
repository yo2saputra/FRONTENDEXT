<?php

namespace App\Controllers\Clinic;

use App\Controllers\BaseController;
//use App\Libraries\Pdfgenerator;



class Pasien extends BaseController
{

    protected $data;
    //protected $helpers = ['form'];

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

        return view('clinic/pasien/index', $this->data);
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
                                    <button type="button" class="btn btn-primary btn-sm tomboledit" data-id="' . $data[$a]["fld_nm"] . '" >
                                        <i class="fas fa-tags"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm tomboldelete" data-id="' . $data[$a]["fld_nm"] . '">
                                        <i class="fas fa-trash"></i>
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
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": false,
                    "autoWidth": true
                    });
                });

                // $(".tomboledit").click(function(e) {
                //     e.preventDefault();
                //     $.ajax({
                //       //type: "post",
                //       url: "' . site_url('clinic/pasien/formedit') . '",
                //       dataType: "json",
                //       success: function(response) {
                //         $(".viewmodal").html(response.data).show();
                //         $("#modaledit").modal("show");
                //       },
                //       error: function(xhr, ajaxOptions, thrownError) {
                //         alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                //       }
                //     });
                // });

                // function edit(fld_nm) {
                // $.ajax({
                //     // type: "post",
                //     url: "' . site_url('clinic/pasien/formedit') . '",
                //     data: {
                //     fld_nm: fld_nm,
                //     // fld_valu: fld_valu,
                //     // fld_desc: fld_desc
                //     },
                //     dataType: "json",
                //     success: function(response) {
                //     if (response.sukses) {
                //         $(".viewmodal").html(response.data).show();
                //         $("#modaledit").modal("show");
                //     }
                //     },
                //     error: function(xhr, ajaxOptions, thrownError) {
                //     alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                //     }
            
                // });
                // }
                </script>
                ';
            echo $output;
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    // public function ambildata()
    // {
    //     if ($this->request->isAJAX()) {

    //         $data =  $this->apiProdukGetAll();

    //         $msg = [
    //             'data' => view('clinic/pasien/viewpasien', $data)
    //         ];
    //         echo json_encode($msg);

    //     } else {
    //         exit('Maaf tidak dapat diproses!');
    //     }
    // }

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

    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama' => [
                    'label' => 'Nama',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'value' => [
                    'label' => 'Value',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'desc' => [
                    'label' => 'Desc',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
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

                $curl = service('curlrequest');

                $posts_data = $curl->request("POST", "http://103.136.19.83:8060/clinic/tfield_value/insert", [
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
                    'success' => 'data berhasil'
                ];
            }
            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    public function formedit()
    {
        if ($this->request->isAJAX()) {

            $pasien =  $this->apiProdukGetAll();

            $data = [
                'fld_nm' => $pasien['fld_nm']
                // 'fld_nm' => $pasien['fld_nm'],
                // 'fld_valu' => $pasien['fld_valu'],
                // 'fld_desc' => $pasien['fld_desc']
            ];

            // $msg = [
            //     'sukses' => view('mahasiswa/modaledit', $data)
            // ];

            $msg = [
                'data' => view('clinic/pasien/modaledit', $data)
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama' => [
                    'label' => 'Nama',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'value' => [
                    'label' => 'Value',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'desc' => [
                    'label' => 'Desc',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
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

                $curl = service('curlrequest');

                $posts_data = $curl->request("POST", "http://103.136.19.83:8060/clinic/tfield_value/insert", [
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
                    'success' => 'data berhasil'
                ];
            }
            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    public function deletedata()
    {
        if ($this->request->isAJAX()) {
            $fld_nm = $this->request->getVar('fld_nm');
            //$fld_valu = $this->request->getVar('fld_valu');
            $fld_valu = "string";

            $curl = service('curlrequest');
            $posts_data = $curl->request("DELETE", "http://103.136.19.83:8060/clinic/tfield_value/delete/$fld_nm/$fld_valu");

            $msg = [
                'sukses' => "Data dengan nama $fld_nm berhasil dihapus"
            ];
            echo json_encode($msg);
        }
    }
}
