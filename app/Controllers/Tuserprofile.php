<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

class Tuserprofile extends BaseController
{

    protected $data;
    protected $server;
    protected $client;

    public function __construct()
    {
        $this->session = session();
        $uri = service('uri');
        $this->server = $_ENV['APP_API'];
    }

    public function index()
    {
        // helper dropdown
        helper(['dropdown']);

        $this->data['cb_role'] = getDropdownRole2('role_cd', 'Role', 2, 4); // (id,Label,label size, input size)
        $this->data['cb_employee'] = getDropdownEmployeeCustomFilter('emp_cd', 'emp_cd', 'Employee', 2, 4, []); // (key,id,Label,label size, input size)
        return view('tuserprofile/index', $this->data);
    }

    public function apiDataGetAll()
    {

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/tuserprofile/getall";

        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);
        return $data['response_data'];
    }

    public function fetchAll()
    {
        if ($this->request->isAJAX()) {

            $output = '';
            $data =  $this->apiDataGetAll();
            $output .= '  
                    <table id="example4" class="table table-sm table-bordered table-striped">
                    <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Lengkap</th>
                                <th>Employee Code</th>
                                <th>Role Code</th>
                                <th>Role Name</th>
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
                                <td ></td>
                                <td ></td>
                            </tr>';
            } else {
                for ($a = 0; $a < count($data); $a++) {
                    $output .= '  
                            <tr id="addMdlBarang" data-id="' . $data[$a]["usr_id"] . '">
                                <td >' . $data[$a]["usr_id"] . '</td>
                                <td >' . $data[$a]["fullname"] . '</td>
                                <td >' . $data[$a]["emp_cd"] . '</td>
                                <td >' . $data[$a]["role_cd"] . '</td>
                                <td >' . $data[$a]["role_nm"] . '</td>
                                <td class="text-center">
                                    
                                    <div class="btn-group">
                                    <a data-toggle="tooltip" data-placement="top" title="View" class="btn btn-sm btn-info view ' . ($this->session->get("flag_view") === 1 ? "" : "d-none") . '" data-usr_id="' . $data[$a]["usr_id"] . '"><i class="fas fa-eye"></i></a>
                                    <a data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-sm btn-primary edit ' . ($this->session->get("flag_update") === 1 ? "" : "d-none") . '" data-usr_id="' . $data[$a]["usr_id"] . '"><i class="fas fa-tags"></i></a>
                                    <a data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-sm btn-danger delete ' . ($this->session->get("flag_delete") === 1 ? "" : "d-none") . '" data-usr_id="' . $data[$a]["usr_id"] . '"><i class="fas fa-trash"></i></a>
                                    </div>
                                    
                                </td>
                            </tr>  
                    ';
                }
            }
            $output .= '</table>
            <script>
            $(function() {
                $("#example4").DataTable({
                    // "responsive": true, "lengthChange": false, "autoWidth": false,
                    columnDefs: [{
                        orderable: false,
                        targets: 5
                    }],
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    // "columns": [
                    //   { "width": "10%" }, null, null, null, nuul, null
                    // ],
                    "buttons": [{
                            text: "Tambah Data",
                            action: function(e, dt, node, config) {
                                // alert("Button activated");
                            },
                            attr: {
                                id: "add_record",
                                style: "background-color:#56b746;' . ($this->session->get("flag_insert") === 1 ? "" : "display:none;") . '",
                                name:"add_record",
                                nameClass:"btn-lg"
                            }
                        },
                        { text: "Excel",extend: "excel", className: "btn-sm btn-primary ' . ($this->session->get("flag_export") === 1 ? "" : "d-none") . '", exportOptions: {columns: [ 0, 1, 2, 3, 4 ]} },
                        { text: "Cetak",extend: "print", className: "btn-sm btn-info ' . ($this->session->get("flag_print") === 1 ? "" : "d-none") . '", exportOptions: {columns: [ 0, 1, 2, 3, 4 ]} }
                           
                    ],
                    "oLanguage": {
                        "sSearch": "Cari Data:",
                        "sInfoEmpty": "Tidak ada data",
                        // "sInfo": "_START_ untuk _END_ dari _TOTAL_ data",
                        "sInfo": "Total: _TOTAL_ data",
                        "sInfoFiltered": " dari _MAX_ data",
                        "sZeroRecords": "Data tidak ditemukan",
                        "oPaginate": {
                            "sFirst": "Awal",
                            "sPrevious": "Sebelum",
                            "sNext": "Berikut",
                            "sLast": "Akhir"
                        },
                    },
                }).buttons().container().appendTo("#example4_wrapper .col-md-6:eq(0)");
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
            $usr_id = $this->request->getVar('usr_id');

            // helper curl request
            helper(['restclient']);

            // endpoint
            $url = "$this->server/tuserprofile/delete/$usr_id";

            // client request
            $response = akses_restapi('DELETE', $url, []);
            $data['response_data'] = json_decode($response, true);

            $msg = [
                'success' => "Data dengan nama $usr_id berhasil dihapus"
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
                    'usr_id' => [
                        'label' => 'Code',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'fullname' => [
                        'label' => 'Nama Lengkap',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'email' => [
                        'label' => 'Email',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'mobile_no' => [
                        'label' => 'No HP',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'mobile_no_process' => [
                        'label' => 'No HP Proses',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'home_no' => [
                        'label' => 'No Rumah',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ]
                    // ,
                    // 'pwd_exp_dt' => [
                    //     'label' => 'Tgl Exp Password',
                    //     'rules' => 'required',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ],
                    // 'resign_dt' => [
                    //     'label' => 'Tgl Resign',
                    //     'rules' => 'required',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ]
                    ,
                    'whatsapp_no' => [
                        'label' => 'No Whatsapp',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ]
                    // ,
                    // 'last_token' => [
                    //     'label' => 'Last Token',
                    //     'rules' => 'required',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ]
                    // ,
                    // 'passwd' => [
                    //     'label' => 'Password',
                    //     'rules' => 'required',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ]
                    ,
                    'emp_cd' => [
                        'label' => 'Kode Employee',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ]
                    // ,
                    // 'salespointcd' => [
                    //     'label' => 'Sales Point CD',
                    //     'rules' => 'required',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ],
                    // 'token_dt' => [
                    //     'label' => 'Tgl Token',
                    //     'rules' => 'required',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ],
                    // 'initname' => [
                    //     'label' => 'Initname',
                    //     'rules' => 'required',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ]
                    // ,
                    // 'isactive' => [
                    //     'label' => 'Isactive',
                    //     'rules' => 'required',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ]
                    // ,
                    // 'initname' => [
                    //     'label' => 'Initname',
                    //     'rules' => 'required',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ]
                    ,
                    'role_cd' => [
                        'label' => 'Role CD',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ]
                    // ,
                    // 'pwdbinary' => [
                    //     'label' => 'Binary',
                    //     'rules' => 'required',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ]
                ]);
                if (!$valid) {
                    $msg = [
                        'error' => [
                            'usr_id' => $validation->getError('usr_id'),
                            'fullname' => $validation->getError('fullname'),
                            'email' => $validation->getError('email'),
                            'mobile_no' => $validation->getError('mobile_no'),
                            'mobile_no_process' => $validation->getError('mobile_no_process'),
                            'home_no' => $validation->getError('home_no'),
                            'pwd_exp_dt' => $validation->getError('pwd_exp_dt'),
                            'resign_dt' => $validation->getError('resign_dt'),
                            'whatsapp_no' => $validation->getError('whatsapp_no'),
                            // 'last_token' => $validation->getError('last_token'),
                            'passwd' => $validation->getError('passwd'),
                            'emp_cd' => $validation->getError('emp_cd'),
                            // 'salespointcd' => $validation->getError('salespointcd'),
                            // 'token_dt' => $validation->getError('token_dt'),
                            // 'initname' => $validation->getError('initname'),
                            'isactive' => $validation->getError('isactive'),
                            'role_cd' => $validation->getError('role_cd'),
                            // 'pwdbinary' => $validation->getError('pwdbinary')

                        ]
                    ];
                } else {

                    if ($this->request->getVar('action') == 'Add') {

                        // helper curl request
                        helper(['restclient']);

                        // endpoint
                        $url = "$this->server/tuserprofile/insert";

                        // form params
                        $data = [
                            "usr_id" => str_replace(" ", "_", trim($this->request->getVar('usr_id'))),
                            "fullname" => $this->request->getVar('fullname'),
                            "email" => $this->request->getVar('email'),
                            "mobile_no" => $this->request->getVar('mobile_no'),
                            "mobile_no_process" => $this->request->getVar('mobile_no_process'),
                            "home_no" => $this->request->getVar('home_no'),
                            "pwd_exp_dt" => $this->request->getVar('pwd_exp_dt'),
                            "resign_dt" => $this->request->getVar('resign_dt'),
                            "whatsapp_no" => $this->request->getVar('whatsapp_no'),
                            "passwd" => $this->request->getVar('passwd'),
                            "emp_cd" => $this->request->getVar('emp_cd'),
                            "isactive" => ($this->request->getVar('isactive') == FALSE) ? 0 : 1,
                            "role_cd" => $this->request->getVar('role_cd')


                            // "usr_id" => str_replace(" ", "_", trim($this->request->getVar('usr_id'))),
                            // "fullname" => $this->request->getVar('fullname'),
                            // "email" => $this->request->getVar('email'),
                            // "mobile_no" => $this->request->getVar('mobile_no'),
                            // "mobile_no_process" => $this->request->getVar('mobile_no_process'),
                            // "home_no" => $this->request->getVar('home_no'),
                            // "pwd_exp_dt" => $this->request->getVar('pwd_exp_dt'),
                            // "resign_dt" => $this->request->getVar('resign_dt'),
                            // "whatsapp_no" => $this->request->getVar('whatsapp_no'),
                            // // "last_token" => $this->request->getVar('last_token'),
                            // "passwd" => $this->request->getVar('passwd'),
                            // "emp_cd" => $this->request->getVar('emp_cd'),
                            // // "salespointcd" => $this->request->getVar('salespointcd'),
                            // // "token_dt" => $this->request->getVar('token_dt'),
                            // // "initname" => $this->request->getVar('initname'),
                            // "isactive" => $this->request->getVar('isactive'),
                            // "role_cd" => $this->request->getVar('role_cd'),
                            // // "pwdbinary" => $this->request->getVar('pwdbinary'),

                        ];
                        // client request
                        $response = akses_restapi('POST', $url, $data);

                        $msg = [
                            'success' => 'data berhasil di create!'
                        ];
                    }

                    if ($this->request->getVar('action') == 'Edit') {

                        // helper curl request
                        helper(['restclient']);

                        // endpoint
                        $url = "$this->server/tuserprofile/update";

                        // form params
                        $data = [
                            "usr_id" => str_replace(" ", "_", trim($this->request->getVar('usr_id'))),
                            "fullname" => $this->request->getVar('fullname'),
                            "email" => $this->request->getVar('email'),
                            "mobile_no" => $this->request->getVar('mobile_no'),
                            "mobile_no_process" => $this->request->getVar('mobile_no_process'),
                            "home_no" => $this->request->getVar('home_no'),
                            "pwd_exp_dt" => $this->request->getVar('pwd_exp_dt'),
                            "resign_dt" => $this->request->getVar('resign_dt'),
                            "whatsapp_no" => $this->request->getVar('whatsapp_no'),
                            // "last_token" => $this->request->getVar('last_token'),
                            "passwd" => $this->request->getVar('passwd'),
                            "emp_cd" => $this->request->getVar('emp_cd'),
                            // "salespointcd" => $this->request->getVar('salespointcd'),
                            // "token_dt" => $this->request->getVar('token_dt'),
                            // "initname" => $this->request->getVar('initname'),
                            "isactive" => ($this->request->getVar('isactive') == FALSE) ? 0 : 1,
                            "role_cd" => $this->request->getVar('role_cd'),
                            // "pwdbinary" => $this->request->getVar('pwdbinary'),
                        ];
                        // client request
                        $response = akses_restapi('PUT', $url, $data);

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

            $usr_id = $this->request->getVar('usr_id');

            if ($usr_id) {

                // helper curl request
                helper(['restclient']);

                // end point
                $url = "$this->server/tuserprofile/getby/$usr_id";

                // client request
                $response = akses_restapi('GET', $url, []);
                $data['response_data'] = json_decode($response, true);

                $msg = [
                    'data' => [
                        'usr_id' => $data["response_data"][0]["usr_id"],
                        'fullname' => $data["response_data"][0]["fullname"],
                        'email' => $data["response_data"][0]["email"],
                        'mobile_no' => $data["response_data"][0]["mobile_no"],
                        'mobile_no_process' => $data["response_data"][0]["mobile_no_process"],
                        'home_no' => $data["response_data"][0]["home_no"],
                        'pwd_exp_dt' => $data["response_data"][0]["pwd_exp_dt"],
                        'resign_dt' => $data["response_data"][0]["resign_dt"],
                        'whatsapp_no' => $data["response_data"][0]["whatsapp_no"],
                        // 'last_token' => $data["response_data"][0]["last_token"],
                        // 'passwd' => $data["response_data"][0]["passwd"],
                        'emp_cd' => $data["response_data"][0]["emp_cd"],
                        // 'salespointcd' => $data["response_data"][0]["salespointcd"],
                        // 'token_dt' => $data["response_data"][0]["token_dt"],
                        // 'initname' => $data["response_data"][0]["initname"],
                        'isactive' => $data["response_data"][0]["isactive"],
                        'role_cd' => $data["response_data"][0]["role_cd"]
                    ]
                ];

                echo json_encode($msg);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    function fetchSingleDataPrint($usr_id)
    {

        if ($usr_id) {

            // helper curl request
            helper(['restclient']);

            // end point
            $url = "$this->server/tuserprofile/getby/$usr_id";

            // client request
            $response = akses_restapi('GET', $url, []);
            $data['response_data'] = json_decode($response, true);

            $pdf_data = $data['response_data'];
            $pdf_name = 'Single Data Field Value';
            $pdf_title = 'Data Field Value';
            $pdf_paper = 'A4';
            $pdf_orientation = 'portrait';
            $pdf_format = 'laporan_pdf';

            $this->view_pdf($pdf_name, $pdf_title, $pdf_data, $pdf_paper, $pdf_orientation, $pdf_format);
        }
    }

    public function view_pdf($pdf_name, $pdf_title, $pdf_data, $pdf_paper, $pdf_orientation, $pdf_format)
    {

        $Pdfgenerator = new Pdfgenerator();

        // filename dari pdf ketika didownload
        $file_pdf = $pdf_name;

        // title dari pdf
        $this->data['title_pdf'] = $pdf_title;

        //data
        $this->data['produk'] = $pdf_data;

        // setting paper
        $paper = $pdf_paper;

        //orientasi paper potrait / landscape
        $orientation = $pdf_orientation;

        $html = view($pdf_format, $this->data);

        // run dompdf
        $Pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    }
}
