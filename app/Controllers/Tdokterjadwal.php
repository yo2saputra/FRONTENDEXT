<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

class Tdokterjadwal extends BaseController
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

        $this->data['cb_dokter'] = getDropdownDokter2('kode_dokter', 'Dokter', 2, 10); // (id,Label,label size, input size)
        $this->data['cb_jenis'] = getDropdown2('jenis_jadwal', 'Jenis Jadwal', 2, 4); // (id,Label,label size, input size)

        $this->data['cb_dokter2'] = getDropdownDokterCustom('kode_dokter', 'kode_dokter2', 'Dokter', 2, 10); // (key,id,Label,label size, input size)
        $this->data['cb_jenis2'] = getDropdownCustom('jenis_jadwal', 'jenis_jadwal2', 'Jenis Jadwal', 2, 4); // (key,id,Label,label size, input size)

        $this->data['cb_dokter3'] = getDropdownDokterCustom('kode_dokter', 'kode_dokter3', 'Dokter', 2, 10); // (key,id,Label,label size, input size)
        $this->data['cb_jenis3'] = getDropdownCustom('jenis_jadwal', 'jenis_jadwal3', 'Jenis Jadwal', 2, 4); // (key,id,Label,label size, input size)



        return view('tdokterjadwal/index', $this->data);
    }

    public function apiDataGetAll()
    {

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/tdokterjadwal/getall";

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
                                <th>Nama Dokter</th>
                                <th>Spesialis</th>
                                <th>Tanggal</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Jenis Praktek</th>
                                <th>Aktif</th>
                                <th>Keterangan</th>
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
                                <td ></td>
                                <td ></td>
                                <td ></td>
                            </tr>';
            } else {
                for ($a = 0; $a < count($data); $a++) {
                    $output .= '  
                            <tr id="addMdlBarang" data-id="' . $data[$a]["jadwal_id"] . '">
                                <td >' . $data[$a]["nama_dokter"] . '</td>
                                <td >' . $data[$a]["spesialis"] . '</td>
                                <td >' . date('d/m/Y', strtotime($data[$a]["tgl_praktek"])) . '</td>
                                <td >' . $data[$a]["jam_mulai"] . '</td>
                                <td >' . $data[$a]["jam_selesai"] . '</td>
                                <td >' . $data[$a]["jenis_jadwal_desc"] . '</td>
                                <td ><span class="right badge ' . ($data[$a]['status_jadwal'] == 1 ? 'badge-info' : 'badge-warning') . '">' . ($data[$a]["status_jadwal"] == 1 ? "Aktif" : "Tidak Aktif") . '</td>
                                <td >' . $data[$a]["keterangan"] . '</td>
                                <td class="text-right">
                                    
                                    <div class="btn-group">
                                    <a data-toggle="tooltip" data-placement="top" title="Rescedule" class="btn btn-sm btn-warning rescedule ' . ($data[$a]["jenis_jadwal"] === 'REGT' || $data[$a]["jenis_jadwal"] === 'RBH' || $data[$a]["status_jadwal"] === 0 ? "d-none" : "") . '" data-jadwal_id="' . $data[$a]["jadwal_id"] . '"><i class="fas fa-redo"></i></a>
                                    <a data-toggle="tooltip" data-placement="top" title="View" class="btn btn-sm btn-info view ' . ($this->session->get("flag_view") === 1 ? "" : "d-none") . '" data-jadwal_id="' . $data[$a]["jadwal_id"] . '"><i class="fas fa-eye"></i></a>
                                    <a data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-sm btn-primary edit ' . ($this->session->get("flag_update") === 1 ? "" : "d-none") . '" data-jadwal_id="' . $data[$a]["jadwal_id"] . '"><i class="fas fa-tags"></i></a>
                                    
                                    <a data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-sm btn-danger delete ' . ($this->session->get("flag_delete") === 1 ? "" : "d-none") . '" data-jadwal_id="' . $data[$a]["jadwal_id"] . '"><i class="fas fa-trash"></i></a>
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
                        targets: 8
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
                        { text: "Excel",extend: "excel", className: "btn-sm btn-primary ' . ($this->session->get("flag_export") === 1 ? "" : "d-none") . '", exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7]} },
                        { text: "Cetak",extend: "print", className: "btn-sm btn-info ' . ($this->session->get("flag_print") === 1 ? "" : "d-none") . '", exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7]} }
                           
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
            $jadwal_id = $this->request->getVar('jadwal_id');

            // helper curl request
            helper(['restclient']);

            // endpoint
            $url = "$this->server/tdokterjadwal/delete/$jadwal_id";

            // client request
            $response = akses_restapi('DELETE', $url, []);
            $data['response_data'] = json_decode($response, true);

            $msg = [
                'success' => "Data dengan nama $jadwal_id berhasil dihapus"
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
                    'kode_dokter' => [
                        'label' => 'Kode Dokter',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'tgl_praktek' => [
                        'label' => 'Tgl Praktek',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'jam_mulai' => [
                        'label' => 'Jam Mulai',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'jam_selesai' => [
                        'label' => 'Jam Selesai',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'jenis_jadwal' => [
                        'label' => 'Jenis Jadwal',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    // 'status_jadwal' => [
                    //     'label' => 'Status Jadwal',
                    //     'rules' => 'required',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ],
                    'keterangan' => [
                        'label' => 'Keterangan',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ]
                    // ,
                    // 'created_by' => [
                    //     'label' => 'Created By',
                    //     'rules' => 'required',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ]
                    // ,
                    // 'jadwal_id' => [
                    //     'label' => 'Jadwal ID',
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
                            'kode_dokter' => $validation->getError('kode_dokter'),
                            'nama_dokter' => $validation->getError('nama_dokter'),
                            'tgl_praktek' => $validation->getError('tgl_praktek'),
                            'jam_mulai' => $validation->getError('jam_mulai'),
                            'jam_selesai' => $validation->getError('jam_selesai'),
                            'jenis_jadwal' => $validation->getError('jenis_jadwal'),
                            'status_jadwal' => $validation->getError('status_jadwal'),
                            'keterangan' => $validation->getError('keterangan'),
                            'jadwal_id' => $validation->getError('jadwal_id')
                            // ,
                            // 'created_by' => $validation->getError('created_by')

                        ]
                    ];
                } else {

                    if ($this->request->getVar('action') == 'Add') {

                        // helper curl request
                        helper(['restclient']);

                        // endpoint
                        $url = "$this->server/tdokterjadwal/insert";

                        // form params
                        $data = [
                            "kode_dokter" => str_replace(" ", "_", trim($this->request->getVar('kode_dokter'))),
                            // "nama_dokter" => $this->request->getVar('nama_dokter'),
                            "tgl_praktek" => date('Y-m-d', strtotime($this->request->getVar('tgl_praktek'))),
                            "jam_mulai" => $this->request->getVar('jam_mulai'),
                            "jam_selesai" => $this->request->getVar('jam_selesai'),
                            "jenis_jadwal" => $this->request->getVar('jenis_jadwal'),
                            "status_jadwal" => ($this->request->getVar('status_jadwal') == FALSE) ? 0 : 1,
                            "keterangan" => $this->request->getVar('keterangan'),
                            // "created_by" => $this->request->getVar('created_by'),
                            "jadwal_id" => NULL


                            // "kode_dokter" => str_replace(" ", "_", trim($this->request->getVar('kode_dokter'))),
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
                        $url = "$this->server/tdokterjadwal/update";

                        // form params
                        $data = [
                            "kode_dokter" => str_replace(" ", "_", trim($this->request->getVar('kode_dokter'))),
                            // "nama_dokter" => $this->request->getVar('nama_dokter'),
                            "tgl_praktek" => date('Y-m-d', strtotime($this->request->getVar('tgl_praktek'))),
                            "jam_mulai" => $this->request->getVar('jam_mulai'),
                            "jam_selesai" => $this->request->getVar('jam_selesai'),
                            "jenis_jadwal" => $this->request->getVar('jenis_jadwal'),
                            "status_jadwal" => ($this->request->getVar('status_jadwal') == FALSE) ? 0 : 1,
                            "keterangan" => $this->request->getVar('keterangan'),
                            // "created_by" => $this->request->getVar('created_by'),
                            "jadwal_id" => $this->request->getVar('jadwal_id')

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

    function actionRescedule()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getVar('action2')) {
                helper(['form', 'url']);

                $validation = \Config\Services::validation();
                $valid = $this->validate([
                    // 'kode_dokter3' => [
                    //     'label' => 'Kode Dokter',
                    //     'rules' => 'required',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ],
                    'tgl_praktek3' => [
                        'label' => 'Tgl Praktek',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'jam_mulai3' => [
                        'label' => 'Jam Mulai',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'jam_selesai3' => [
                        'label' => 'Jam Selesai',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    // 'jenis_jadwal3' => [
                    //     'label' => 'Jenis Jadwal',
                    //     'rules' => 'required',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ],
                    'keterangan3' => [
                        'label' => 'Keterangan',
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
                            'kode_dokter' => $validation->getError('kode_dokter3'),
                            'nama_dokter' => $validation->getError('nama_dokter3'),
                            'tgl_praktek' => $validation->getError('tgl_praktek3'),
                            'jam_mulai' => $validation->getError('jam_mulai3'),
                            'jam_selesai' => $validation->getError('jam_selesai3'),
                            'jenis_jadwal' => $validation->getError('jenis_jadwal3'),
                            'status_jadwal' => $validation->getError('status_jadwal3'),
                            'keterangan' => $validation->getError('keterangan3'),
                            'jadwal_id' => $validation->getError('jadwal_id3')
                            // ,
                            // 'created_by' => $validation->getError('created_by')

                        ]
                    ];
                } else {

                    if ($this->request->getVar('action2') == 'Rescedule') {

                        // helper curl request
                        helper(['restclient']);

                        // endpoint
                        $url = "$this->server/tdokterjadwal/reschedule";

                        // form params
                        $data = [
                            "kode_dokter" => str_replace(" ", "_", trim($this->request->getVar('kode_dokter3_h'))),
                            // "kode_dokter" => "E0002",
                            "tgl_praktek" => date('Y-m-d', strtotime($this->request->getVar('tgl_praktek3'))),
                            "jam_mulai" => $this->request->getVar('jam_mulai3'),
                            "jam_selesai" => $this->request->getVar('jam_selesai3'),
                            "jenis_jadwal" => $this->request->getVar('jenis_jadwal3_h'),
                            // "jenis_jadwal" => "0D11F2BFFB99",
                            "status_jadwal" => 1,
                            "keterangan" => $this->request->getVar('keterangan3'),
                            "jadwal_id" => $this->request->getVar('jadwal_id3_h')

                        ];
                        // client request
                        $response = akses_restapi('POST', $url, $data);

                        $msg = [
                            'success' => 'data berhasil di create!'
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

            $jadwal_id = $this->request->getVar('jadwal_id');

            if ($jadwal_id) {

                // helper curl request
                helper(['restclient']);

                // end point
                $url = "$this->server/tdokterjadwal/getby/$jadwal_id";

                // client request
                $response = akses_restapi('GET', $url, []);
                $data['response_data'] = json_decode($response, true);

                $msg = [
                    'data' => [
                        'kode_dokter' => $data["response_data"][0]["kode_dokter"],
                        // 'kode_dokter' => $data["response_data"][0]["kode_dokter"],
                        // 'client_id' => $data["response_data"][0]["client_id"],
                        'tgl_praktek' => date('m/d/Y', strtotime($data["response_data"][0]["tgl_praktek"])),
                        'jam_mulai' => $data["response_data"][0]["jam_mulai"],
                        'jam_selesai' => $data["response_data"][0]["jam_selesai"],
                        'jenis_jadwal' => $data["response_data"][0]["jenis_jadwal"],
                        'status_jadwal' => $data["response_data"][0]["status_jadwal"],
                        'keterangan' => $data["response_data"][0]["keterangan"],
                        // 'created_by' => $data["response_data"][0]["created_by"],
                        // 'created_date' => $data["response_data"][0]["created_date"],
                        'jadwal_id' => $data["response_data"][0]["jadwal_id"]
                    ]
                ];

                echo json_encode($msg);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    function fetchSingleDataPrint($jadwal_id)
    {

        if ($jadwal_id) {

            // helper curl request
            helper(['restclient']);

            // end point
            $url = "$this->server/tdokterjadwal/getby/$jadwal_id";

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
