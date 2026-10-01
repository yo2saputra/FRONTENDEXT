<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

class Tdokter extends BaseController
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
        $this->data['cb_empstacd'] = getDropdownCustomFilter('employee_status', 'emp_sta_cd', 'Status', 2, 4, []); // (key,id,Label,label size, input size, filter)
        // $this->data['cb_tujuan'] = getDropdownPolyclinicCustom('tujuan_registrasi', 'poli', 'Poli', 2, 4); // (key,id,Label,label size, input size, filter)
        $this->data['cb_tujuan'] = getDropdownUnitCustom('tujuan_registrasi', 'poli', 'Poli', 2, 4);
        // $this->data['cd_tujuan'] = getDropdownCustomFilter('tujuan_registrasi', 'poli', 'Poli', 2, 4, []); // (key,id,Label,label size, input size, filter)
        $this->data['cb_jobtitle'] = getDropdownCustomFilterIn('job_title_internal', 'job_title_cd', 'Job Title', 2, 4, ['DR']); // (key,id,Label,label size, input size, filter)
        $this->data['cb_jenisdokter'] = getDropdownCustomFilter('jenis_dokter', 'jenis_dokter', 'Jenis Dokter', 2, 4, []); // (key,id,Label,label size, input size, filter)
        $this->data['cb_spesialis'] = getDropdownCustomFilter('Spesialis', 'spesialis', 'Spesialis', 2, 4, []); // (key,id,Label,label size, input size, filter)
        return view('dokter/index', $this->data);
    }

    public function apiDataGetAll()
    {

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/tmstdokter/getall";

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
                                <th>No</th>
                                <th>Name</th>
                                <th>Poli</th>
                                <th>Spesialis</th>
                                <th>Jenis Dokter</th>
                                <th>Status</th>
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
                $no = 0;
                for ($a = 0; $a < count($data); $a++) {
                    $no++;
                    $output .= '  
                            <tr id="addMdlBarang" data-id="' . $data[$a]["emp_cd"] . '">
                                <td >' . $no . '</td>
                                <td >' . $data[$a]["prefix"] . ' ' . $data[$a]["emp_nm"] . ' ' . $data[$a]["endfix"] . '</td>
                                <td >' . $data[$a]["poli_nm"] . '</td>
                                <td >' . $data[$a]["spesialis_nm"] . '</td>
                                <td >' . $data[$a]["jenis_dokter_nm"] . '</td>
                                <td ><span class="right badge ' . ($data[$a]['emp_sta_cd'] == 'A' ? 'badge-info' : 'badge-warning') . '">' . ($data[$a]["emp_sta_cd"] == 'A' ? "Aktif" : "Tidak Aktif") . '</span></td>
                                <td class="text-right">
                                    
                                    <div class="btn-group">
                                    <a data-toggle="tooltip" data-placement="top" title="View" class="btn btn-sm btn-info view ' . ($this->session->get("flag_view") === 1 ? "" : "d-none") . '" data-emp_cd="' . $data[$a]["emp_cd"] . '"><i class="fas fa-eye"></i></a>
                                    <a data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-sm btn-primary edit ' . ($this->session->get("flag_update") === 1 ? "" : "d-none") . '" data-emp_cd="' . $data[$a]["emp_cd"] . '"><i class="fas fa-tags"></i></a>
                                    <a data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-sm btn-danger delete ' . ($this->session->get("flag_delete") === 1 ? "" : "d-none") . '" data-emp_cd="' . $data[$a]["emp_cd"] . '"><i class="fas fa-trash"></i></a>
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
                        targets: 6
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
                        { text: "Excel",extend: "excel", className: "btn-sm btn-primary ' . ($this->session->get("flag_export") === 1 ? "" : "d-none") . '", exportOptions: {columns: [ 0, 1, 2, 3, 4, 5]} },
                        { text: "Cetak",extend: "print", className: "btn-sm btn-info ' . ($this->session->get("flag_print") === 1 ? "" : "d-none") . '", exportOptions: {columns: [ 0, 1, 2, 3, 4, 5]} }
                           
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
            $emp_cd = $this->request->getVar('emp_cd');

            // helper curl request
            helper(['restclient']);

            // endpoint
            $url = "$this->server/tmstdokter/delete/$emp_cd";

            // client request
            $response = akses_restapi('DELETE', $url, []);
            $data['response_data'] = json_decode($response, true);

            $msg = [
                'success' => "Data dengan nama $emp_cd berhasil dihapus"
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
                    // 'emp_cd' => [
                    //     'label' => 'Employee Code',
                    //     'rules' => 'required',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ],
                    'emp_nm' => [
                        'label' => 'Name',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'job_title_cd' => [
                        'label' => 'Job Title',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'addr' => [
                        'label' => 'Address',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'city_cd' => [
                        'label' => 'City',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    // 'phone_no' => [
                    //     'label' => 'Phone',
                    //     'rules' => 'required',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ],
                    'mobile_no' => [
                        'label' => 'Mobile',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'email' => [
                        'label' => 'Email',
                        'rules' => 'required|valid_email',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    // 'prefix' => [
                    //     'label' => 'Prefix',
                    //     'rules' => 'required',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ],
                    // 'endfix' => [
                    //     'label' => 'Endfix',
                    //     'rules' => 'required',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ],
                    'whatsapp_cd' => [
                        'label' => 'Whatsapp',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'level_cd' => [
                        'label' => 'Level',
                        'rules' => 'permit_empty',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    // 'flag_dokter' => [
                    //     'label' => 'Dokter',
                    //     'rules' => 'required',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ],
                    'emp_sta_cd' => [
                        'label' => 'Status',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'poli' => [
                        'label' => 'Poli',
                        'rules' => 'permit_empty',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'jenis_dokter' => [
                        'label' => 'Jenis Dokter',
                        'rules' => 'permit_empty',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'spesialis' => [
                        'label' => 'Job Title',
                        'rules' => 'permit_empty',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],

                ]);
                if (!$valid) {
                    $msg = [
                        'error' => [
                            // 'emp_cd' => $validation->getError('emp_cd'),
                            'emp_nm' => $validation->getError('emp_nm'),
                            'job_title_cd' => $validation->getError('job_title_cd'),
                            'addr' => $validation->getError('addr'),
                            'city_cd' => $validation->getError('city_cd'),
                            'phone_no' => $validation->getError('phone_no'),
                            'mobile_no' => $validation->getError('pic_mobile_no'),
                            'email' => $validation->getError('email'),
                            'prefix' => $validation->getError('prefix'),
                            'endfix' => $validation->getError('endfix'),
                            'whatsapp_cd' => $validation->getError('whatsapp_cd'),
                            'level_cd' => $validation->getError('level_cd'),
                            'flag_dokter' => $validation->getError('flag_dokter'),
                            'emp_sta_cd' => $validation->getError('emp_sta_cd'),
                            'poli' => $validation->getError('poli'),
                            'jenis_dokter' => $validation->getError('jenis_dokter'),
                            'spesialis' => $validation->getError('spesialis')

                        ]
                    ];
                } else {

                    if ($this->request->getVar('action') == 'Add') {

                        // helper curl request
                        helper(['restclient']);

                        // endpoint
                        $url = "$this->server/tmstdokter/insert";

                        // form params
                        $data = [
                            "emp_cd" => NULL,
                            "emp_nm" => $this->request->getVar('emp_nm'),
                            "job_title_cd" => $this->request->getVar('job_title_cd'),
                            "addr" => $this->request->getVar('addr'),
                            "city_cd" => $this->request->getVar('city_cd'),
                            "phone_no" => $this->request->getVar('phone_no'),
                            "mobile_no" => $this->request->getVar('mobile_no'),
                            "email" => $this->request->getVar('email'),
                            "prefix" => $this->request->getVar('prefix'),
                            "endfix" => $this->request->getVar('endfix'),
                            "whatsapp_cd" => $this->request->getVar('whatsapp_cd'),
                            "level_cd" => $this->request->getVar('level_cd'),
                            "flag_dokter" => ($this->request->getVar('flag_dokter') == FALSE) ? 0 : 1,
                            "emp_sta_cd" => $this->request->getVar('emp_sta_cd'),
                            "poli" => $this->request->getVar('poli'),
                            "jenis_dokter" => $this->request->getVar('jenis_dokter'),
                            "spesialis" => $this->request->getVar('spesialis')


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
                        $url = "$this->server/tmstdokter/update";

                        // form params
                        $data = [
                            "emp_cd" => $this->request->getVar('emp_cd'),
                            "emp_nm" => $this->request->getVar('emp_nm'),
                            "job_title_cd" => $this->request->getVar('job_title_cd'),
                            "addr" => $this->request->getVar('addr'),
                            "city_cd" => $this->request->getVar('city_cd'),
                            "phone_no" => $this->request->getVar('phone_no'),
                            "mobile_no" => $this->request->getVar('mobile_no'),
                            "email" => $this->request->getVar('email'),
                            "prefix" => $this->request->getVar('prefix'),
                            "endfix" => $this->request->getVar('endfix'),
                            "whatsapp_cd" => $this->request->getVar('whatsapp_cd'),
                            "level_cd" => $this->request->getVar('level_cd'),
                            "flag_dokter" => ($this->request->getVar('flag_dokter') == FALSE) ? 0 : 1,
                            // "flag_dokter" => $this->request->getVar('flag_dokter'),
                            "emp_sta_cd" => $this->request->getVar('emp_sta_cd'),
                            "poli" => $this->request->getVar('poli'),
                            "jenis_dokter" => $this->request->getVar('jenis_dokter'),
                            // "jenis_dokter" => 'home',
                            "spesialis" => $this->request->getVar('spesialis'),

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
        // if ($this->request->isAJAX()) {

        $emp_cd = $this->request->getVar('emp_cd');

        if ($emp_cd) {

            // helper curl request
            helper(['restclient']);

            // end point
            $url = "$this->server/tmstdokter/getby/$emp_cd";

            // client request
            $response = akses_restapi('GET', $url, []);
            $data['response_data'] = json_decode($response, true);

            $msg = [
                'data' => [
                    'emp_cd' => $data["response_data"][0]["emp_cd"],
                    'emp_nm' => $data["response_data"][0]["emp_nm"],
                    'job_title_cd' => $data["response_data"][0]["job_title_cd"],
                    'addr' => $data["response_data"][0]["addr"],
                    'city_cd' => $data["response_data"][0]["city_cd"],
                    'phone_no' => $data["response_data"][0]["phone_no"],
                    'mobile_no' => $data["response_data"][0]["mobile_no"],
                    'email' => $data["response_data"][0]["email"],
                    'prefix' => $data["response_data"][0]["prefix"],
                    'endfix' => $data["response_data"][0]["endfix"],
                    'whatsapp_cd' => $data["response_data"][0]["whatsapp_cd"],
                    'level_cd' => $data["response_data"][0]["level_cd"],
                    'flag_dokter' => $data["response_data"][0]["flag_dokter"],
                    'emp_sta_cd' => $data["response_data"][0]["emp_sta_cd"],
                    'poli' => $data["response_data"][0]["poli"],
                    'jenis_dokter' => $data["response_data"][0]["jenis_dokter"],
                    'spesialis' => $data["response_data"][0]["spesialis"],
                ]
            ];

            echo json_encode($msg);
        }
        // } else {
        //     exit('Maaf tidak dapat diproses!');
        // }
    }

    function fetchSingleDataPrint($emp_cd)
    {

        if ($emp_cd) {

            // helper curl request
            helper(['restclient']);

            // end point
            $url = "$this->server/tmstdokter/getby/$emp_cd";

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
