<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;
use CodeIgniter\I18n\Time;



class Jadwaldokter extends BaseController
{

    protected $data;
    protected $server;
    protected $client;

    public function __construct()
    {
        $this->session = session();
        $this->server = $_ENV['APP_API'];

        $this->data = [
            'menu_header' => $this->apiMenuHeader(session()->get('usr_id')),
            'menu' => $this->apiMenu(session()->get('usr_id'))
        ];
    }

    public function index()
    {
        // helper dropdown
        helper(['dropdown']);

        //$this->data['cb_pasien'] = getDropdown2('tujuan_registrasi', 'Tujuan Registrasi', 2, 4); // (id,Label,label size, input size)
        $this->data['cb_pasien'] = getDropdownPasien2('patient_no', 'Pasien', 2, 4); // (id,Label,label size, input size)
        // $this->data['cb_tujuan'] = getDropdown2('tujuan_registrasi', 'Tujuan Registrasi', 2, 4); // (id,Label,label size, input size)
        $this->data['cb_type_pasien'] = getDropdown2('Tipe_Pasien', 'Tipe Pasien', 2, 4); // (id,Label,label size, input size)
        $this->data['cb_asuransi'] = getDropdownAsuransiCustomFilter('asr_cd', 'asr_cd', 'Asuransi', 2, 4, []); // (key,id,Label,label size, input size)
        return view('jadwaldokter/index', $this->data);
    }

    public function apiDataGetDokter()
    {
        // helper curl request
        helper(['restclient']);
        // endpoint
        $url = "$this->server/list/dokter";
        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);

        return $data['response_data'];
    }

    public function fetchDokter()
    {
        if ($this->request->isAJAX()) {

            $output = '';
            $data =  $this->apiDataGetDokter();
            $output .= '  
                    <table id="example1" class="table table-sm table-bordered table-striped">
                    <thead>
                            <tr>
                                <th>Dokter</th>
                                <th>Spesialis</th>
                                <th></th>
                            </tr>
                        </thead>
                            ';
            if ($data == '') {
                $output .= '<tr>  
                                <td >Data not Found</td>
                                <td ></td>
                                <td ></td>
                               
                            </tr>';
            } else {
                for ($a = 0; $a < count($data); $a++) {
                    $output .= '  
                            <tr id="addMdlBarang" data-id="' . $data[$a]["kode_dokter"] . '">
                                <td >' . $data[$a]["nama_dokter"] . '</td>
                                <td >' . $data[$a]["spesialis"] . '</td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm float-right mr-1 mt-1 view btn-fix-w" data-kode_dokter="' . $data[$a]["kode_dokter"] . '">
                                        Pilih
                                    </button>
                                </td>
                            </tr>  
                    ';
                }
            }
            $output .= '</table>
            <script>
            $(function() {
                $("#example1").DataTable({
                    "responsive": true, "lengthChange": false, "autoWidth": false,
                    columnDefs: [{
                        orderable: false,
                        targets: 2
                    }],
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    // "columns": [
                    //   { "width": "10%" }, null, null, null, nuul, null
                    // ],
                    // "buttons": [{
                    //         text: "Add New",
                    //         action: function(e, dt, node, config) {
                    //             // alert("Button activated");
                    //         },
                    //         attr: {
                    //             id: "add_record",
                    //             style: "background-color:#56b746;' . ($this->session->get("flag_insert") === 1 ? "" : "display:none;") . '",
                    //             name:"add_record",
                    //             nameClass:"btn-lg"
                    //         }
                    //     },
                    //     { extend: "excel", className: "btn-sm btn-primary ' . ($this->session->get("flag_export") === 1 ? "" : "d-none") . '", exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]} },
                    //     { extend: "print", className: "btn-sm btn-info ' . ($this->session->get("flag_print") === 1 ? "" : "d-none") . '", exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]} }
                           
                    // ],
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
                }).buttons().container().appendTo("#example1_wrapper .col-sm-6:eq(0)");
            });
            </script>
            ';
            echo $output;
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    public function apiDataGetJadwalByTgl($tgl_praktek)
    {
        // helper curl request
        helper(['restclient']);
        // endpoint
        $url = "$this->server/jadwaldokter/pertgl/$tgl_praktek";
        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);

        return $data['response_data'];
    }

    public function fetchJadwalByTgl()
    {
        if ($this->request->isAJAX()) {

            $tgl_praktek = $this->request->getVar('tgl_praktek');

            $output = '';
            $data =  $this->apiDataGetJadwalByTgl($tgl_praktek);

            $output .= '  
                    <table id="example2" class="table table-sm table-bordered table-striped">
                    <thead>
                            <tr>
                                <th>Dokter</th>
                                <th>Spesialis</th>
                                <th>Praktek</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
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
                            </tr>';
            } else {
                for ($a = 0; $a < count($data); $a++) {
                    $output .= '  
                            <tr id="addMdlBarang" data-id="' . $data[$a]["nama_dokter"] . '">
                                <td >' . $data[$a]["nama_dokter"] . '</td>
                                <td >' . $data[$a]["spesialis"] . '</td>
                                <td >' . $data[$a]["fld_desc"] . '</td>      
                                <td >' . $data[$a]["jam_mulai"] . '</td>
                                <td >' . $data[$a]["jam_selesai"] . '</td>
                                <td >' . $data[$a]["keterangan"] . '</td>
                                <td >
                                    <button type="button" class="btn btn-info btn-sm float-right mr-1 mt-1 pilih btn-fix-w"  data-jadwal_id="' . $data[$a]["jadwal_id"] . '" data-kode_dokter="' . $data[$a]["kode_dokter"] . '" data-nama_dokter="' . $data[$a]["nama_dokter"] . '" data-tgl_praktek="' . $data[$a]["tanggal"] . '" data-jam_mulai="' . $data[$a]["jam_mulai"] . '" data-jam_selesai="' . $data[$a]["jam_selesai"] . '">
                                        Daftar
                                    </button>
                                </td>
                            </tr>  
                    ';
                }
            }
            $output .= '</table>
            <script>
            $(function() {
                $("#example2").DataTable({
                    // "responsive": true, "lengthChange": false, "autoWidth": false,
                    // columnDefs: [{
                    //     orderable: false,
                    //     targets: 7
                    // }],
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    // "columns": [
                    //   { "width": "10%" }, null, null, null, nuul, null
                    // ],
                    // "buttons": [{
                    //         text: "Add New",
                    //         action: function(e, dt, node, config) {
                    //             // alert("Button activated");
                    //         },
                    //         attr: {
                    //             id: "add_record",
                    //             style: "background-color:#56b746;' . ($this->session->get("flag_insert") === 1 ? "" : "display:none;") . '",
                    //             name:"add_record",
                    //             nameClass:"btn-lg"
                    //         }
                    //     },
                    //     { extend: "excel", className: "btn-sm btn-primary ' . ($this->session->get("flag_export") === 1 ? "" : "d-none") . '", exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]} },
                    //     { extend: "print", className: "btn-sm btn-info ' . ($this->session->get("flag_print") === 1 ? "" : "d-none") . '", exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]} }

                    // ],
                    "oLanguage": {
                        "sSearch": "Cari Data:",
                        "sInfoEmpty": "Tidak ada data",
                        // "sInfo": "_START_ untuk _END_ dari _TOTAL_ data",
                        "sInfo": "Total: _TOTAL_ Jadwal",
                        "sInfoFiltered": " dari _MAX_ Jadwal",
                        "sZeroRecords": "Data tidak ditemukan",
                        "oPaginate": {
                            "sFirst": "Awal",
                            "sPrevious": "Sebelum",
                            "sNext": "Berikut",
                            "sLast": "Akhir"
                        },
                    },
                }).buttons().container().appendTo("#example2_wrapper .col-sm-6:eq(0)");
            });
            </script>
            ';
            echo $output;
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    // public function fetchJadwalByTgl()
    // {
    //     // if ($this->request->isAJAX()) {

    //     $tgl_praktek = $this->request->getVar('tgl_praktek');
    //     // $tgl_praktek = "11-30-2023";

    //     $output = '';
    //     $data =  $this->apiDataGetJadwalByTgl($tgl_praktek);
    //     $output .= '  
    //                 <table id="example2" class="table table-sm table-bordered table-striped">
    //                 <thead>
    //                         <tr>
    //                             <th>Nama Dokter</th>
    //                             <th>Spesialis</th>
    //                             <th>Tanggal</th>
    //                             <th>Mulai</th>
    //                             <th>Selesai</th>
    //                             <th>Jenis</th>
    //                             <th>Status</th>
    //                             <th>Keterangan</th>
    //                         </tr>
    //                     </thead>
    //                         ';
    //     if ($data == '') {
    //         $output .= '<tr>  
    //                             <td >Data not Found</td>
    //                             <td ></td>
    //                             <td ></td>
    //                             <td ></td>
    //                             <td ></td>
    //                             <td ></td>
    //                             <td ></td>
    //                             <td ></td>
    //                         </tr>';
    //     } else {
    //         for ($a = 0; $a < count($data); $a++) {
    //             $output .= '  
    //                         <tr id="addMdlBarang" data-id="' . $data[$a]["kode_dokter"] . '">
    //                             <td >' . $data[$a]["nama_dokter"] . '</td>
    //                             <td >' . $data[$a]["spesialis"] . '</td>
    //                             <td >' . date('d/m/Y', strtotime($data[$a]["tgl_praktek"])) . '</td>
    //                             <td >' . $data[$a]["jam_mulai"] . '</td>
    //                             <td >' . $data[$a]["jam_selesai"] . '</td>
    //                             <td >' . $data[$a]["jenis_jadwal"] . '</td>
    //                             <td ><span class="right badge ' . ($data[$a]['status_jadwal'] == 1 ? 'badge-info' : 'badge-warning') . '">' . ($data[$a]["status_jadwal"] == 1 ? "Aktif" : "Tidak Aktif") . '</td>
    //                             <td >' . $data[$a]["keterangan"] . '</td>
    //                         </tr>  
    //                 ';
    //         }
    //     }
    //     $output .= '</table>
    //         <script>
    //         $(function() {
    //             $("#example2").DataTable({
    //                 // "responsive": true, "lengthChange": false, "autoWidth": false,
    //                 // columnDefs: [{
    //                 //     orderable: false,
    //                 //     targets: 7
    //                 // }],
    //                 "responsive": true,
    //                 "lengthChange": false,
    //                 "autoWidth": false,
    //                 // "columns": [
    //                 //   { "width": "10%" }, null, null, null, nuul, null
    //                 // ],
    //                 // "buttons": [{
    //                 //         text: "Add New",
    //                 //         action: function(e, dt, node, config) {
    //                 //             // alert("Button activated");
    //                 //         },
    //                 //         attr: {
    //                 //             id: "add_record",
    //                 //             style: "background-color:#56b746;' . ($this->session->get("flag_insert") === 1 ? "" : "display:none;") . '",
    //                 //             name:"add_record",
    //                 //             nameClass:"btn-lg"
    //                 //         }
    //                 //     },
    //                 //     { extend: "excel", className: "btn-sm btn-primary ' . ($this->session->get("flag_export") === 1 ? "" : "d-none") . '", exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]} },
    //                 //     { extend: "print", className: "btn-sm btn-info ' . ($this->session->get("flag_print") === 1 ? "" : "d-none") . '", exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]} }

    //                 // ],
    //                 "oLanguage": {
    //                     "sSearch": "Cari Data:",
    //                     "sInfoEmpty": "Tidak ada data",
    //                     // "sInfo": "_START_ untuk _END_ dari _TOTAL_ data",
    //                     "sInfo": "Total: _TOTAL_ data",
    //                     "sInfoFiltered": " dari _MAX_ data",
    //                     "sZeroRecords": "Data tidak ditemukan",
    //                     "oPaginate": {
    //                         "sFirst": "Awal",
    //                         "sPrevious": "Sebelum",
    //                         "sNext": "Berikut",
    //                         "sLast": "Akhir"
    //                     },
    //                 },
    //             }).buttons().container().appendTo("#example4_wrapper .col-md-6:eq(0)");
    //         });
    //         </script>
    //         ';
    //     echo $output;
    //     // } else {
    //     //     exit('Maaf tidak dapat diproses!');
    //     // }
    // }

    public function apiDataGetJadwalByDokter($kode_dokter)
    {
        // helper curl request
        helper(['restclient']);
        // endpoint
        $url = "$this->server/jadwaldokter/perdokter/$kode_dokter";
        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);

        return $data['response_data'];
    }

    public function fetchJadwalByDokter()
    {
        if ($this->request->isAJAX()) {

            $kode_dokter = $this->request->getVar('kode_dokter');

            $output = '';
            $data =  $this->apiDataGetJadwalByDokter($kode_dokter);

            $output .= '  
                    <table id="example3" class="table table-sm table-bordered table-striped">
                    <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Praktek</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
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
                            </tr>';
            } else {
                for ($a = 0; $a < count($data); $a++) {
                    $output .= '  
                            <tr id="addMdlBarang" data-id="' . $data[$a]["tanggal"] . '">
                                <td >' . date('d/m/Y', strtotime($data[$a]["tanggal"])) . '</td>
                                <td >' . $data[$a]["fld_desc"] . '</td>
                                <td >' . $data[$a]["jam_mulai"] . '</td>
                                <td >' . $data[$a]["jam_selesai"] . '</td>
                                <td >' . $data[$a]["keterangan"] . '</td>
                                <td >
                                    <button type="button" class="btn btn-info btn-sm float-right mr-1 mt-1 pilih btn-fix-w"  data-jadwal_id="' . $data[$a]["jadwal_id"] . '" data-kode_dokter="' . $data[$a]["kode_dokter"] . '" data-nama_dokter="' . $data[$a]["nama_dokter"] . '" data-tgl_praktek="' . $data[$a]["tanggal"] . '" data-jam_mulai="' . $data[$a]["jam_mulai"] . '" data-jam_selesai="' . $data[$a]["jam_selesai"] . '">
                                        Daftar
                                    </button>
                                </td>
                            </tr>  
                    ';
                }
            }
            $output .= '</table>
            <script>
            $(function() {
                $("#example3").DataTable({
                    // "responsive": true, "lengthChange": false, "autoWidth": false,
                    // columnDefs: [{
                    //     orderable: false,
                    //     targets: 7
                    // }],
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    // "columns": [
                    //   { "width": "10%" }, null, null, null, nuul, null
                    // ],
                    // "buttons": [{
                    //         text: "Add New",
                    //         action: function(e, dt, node, config) {
                    //             // alert("Button activated");
                    //         },
                    //         attr: {
                    //             id: "add_record",
                    //             style: "background-color:#56b746;' . ($this->session->get("flag_insert") === 1 ? "" : "display:none;") . '",
                    //             name:"add_record",
                    //             nameClass:"btn-lg"
                    //         }
                    //     },
                    //     { extend: "excel", className: "btn-sm btn-primary ' . ($this->session->get("flag_export") === 1 ? "" : "d-none") . '", exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]} },
                    //     { extend: "print", className: "btn-sm btn-info ' . ($this->session->get("flag_print") === 1 ? "" : "d-none") . '", exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]} }

                    // ],
                    "oLanguage": {
                        "sSearch": "Cari Data:",
                        "sInfoEmpty": "Tidak ada data",
                        // "sInfo": "_START_ untuk _END_ dari _TOTAL_ data",
                        "sInfo": "Total: _TOTAL_ Jadwal",
                        "sInfoFiltered": " dari _MAX_ Jadwal",
                        "sZeroRecords": "Data tidak ditemukan",
                        "oPaginate": {
                            "sFirst": "Awal",
                            "sPrevious": "Sebelum",
                            "sNext": "Berikut",
                            "sLast": "Akhir"
                        },
                    },
                }).buttons().container().appendTo("#example3_wrapper .col-sm-6:eq(0)");
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
            $patient_no = $this->request->getVar('patient_no');

            // helper curl request
            helper(['restclient']);
            // endpoint
            $url = "$this->server/patient/delete/$patient_no";
            // client request
            $response = akses_restapi('DELETE', $url, []);
            $data['response_data'] = json_decode($response, true);

            $msg = [
                'success' => "Data $patient_no berhasil dihapus"
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
                    'fullname' => [
                        'label' => 'Nama Lengkap',
                        'rules' => 'trim|required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'id_no' => [
                        'label' => 'ID No',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'gender' => [
                        'label' => 'Jenis Kelamin',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'addr' => [
                        'label' => 'Alamat Lengkap',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'mobile_no' => [
                        'label' => 'Mobile No',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'birth_dt' => [
                        'label' => 'Tanggal Lahir',
                        'rules' => 'trim|required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'id_typ' => [
                        'label' => 'Tipe ID',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'job_title_cd' => [
                        'label' => 'Pekerjaan',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'religion' => [
                        'label' => 'Agama',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'city_cd' => [
                        'label' => 'Kota',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'married_sta_id' => [
                        'label' => 'Status Pernikahan',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'source_info' => [
                        'label' => 'Mengenal Medicelle dari',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    // 'phone_no' => [
                    //     'label' => 'No Telepon',
                    //     'rules' => 'required',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ],
                    // 'register_dt' => [
                    //     'label' => 'Birth Date',
                    //     'rules' => 'required',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ],
                    'birthplace' => [
                        'label' => 'Tempat Lahir',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    // 'createdby' => [
                    //     'label' => 'Birth Date',
                    //     'rules' => 'required',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ],
                    'postcode' => [
                        'label' => 'Kode Pos',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'education' => [
                        'label' => 'Pendidikan',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'family_name' => [
                        'label' => 'Nama Lengkap Keluarga',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'family_addr' => [
                        'label' => 'Alamat Lengkap Keluarga',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'family_handphone' => [
                        'label' => 'No Telpon Keluarga',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'family_relation' => [
                        'label' => 'Hubungan Dengan Pasien',
                        'rules' => 'required|number',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ]

                ]);
                if (!$valid) {
                    $msg = [
                        'error' => [
                            'fullname' => $validation->getError('fullname'),
                            'id_no' => $validation->getError('id_no'),
                            'gender' => $validation->getError('gender'),
                            'addr' => $validation->getError('addr'),
                            'mobile_no' => $validation->getError('mobile_no'),
                            'birth_dt' => $validation->getError('birth_dt'),
                            'id_typ' => $validation->getError('id_typ'),
                            'job_title_cd' => $validation->getError('job_title_cd'),
                            'religion' => $validation->getError('religion'),
                            'city_cd' => $validation->getError('city_cd'),
                            'married_sta_id' => $validation->getError('married_sta_id'),
                            'source_info' => $validation->getError('source_info'),
                            // // 'register_dt' => $validation->getError('register_dt'),
                            // 'phone_no' => $validation->getError('phone_no'),
                            'birthplace' => $validation->getError('birthplace'),
                            // // 'createdby' => $validation->getError('createdby'),
                            'postcode' => $validation->getError('postcode'),
                            'education' => $validation->getError('education'),
                            'family_name' => $validation->getError('family_name'),
                            'family_addr' => $validation->getError('family_addr'),
                            'family_handphone' => $validation->getError('family_handphone'),
                            'family_relation' => $validation->getError('family_relation')
                        ]
                    ];
                } else {

                    if ($this->request->getVar('action') == 'Add') {

                        // helper curl request
                        helper(['restclient']);
                        // endpoint
                        $url = "$this->server/patient/insert";
                        // form params
                        $data = [
                            "fullname" => $this->request->getVar('fullname'),
                            "id_no" => $this->request->getVar('id_no'),
                            "gender" => $this->request->getVar('gender'),
                            "addr" => $this->request->getVar('addr'),
                            "mobile_no" => $this->request->getVar('mobile_no'),
                            "birth_dt" => date('Y-m-d', strtotime($this->request->getVar('birth_dt'))),
                            "id_typ" => $this->request->getVar('id_typ'),
                            "job_title_cd" => $this->request->getVar('job_title_cd'),
                            "religion" => $this->request->getVar('religion'),
                            "city_cd" => $this->request->getVar('city_cd'),
                            "married_sta_id" => $this->request->getVar('married_sta_id'),
                            "source_info" => $this->request->getVar('source_info'),
                            // // "register_dt" => $this->request->getVar('register_dt'),
                            // "phone_no" => $this->request->getVar('phone_no'),
                            "birthplace" => $this->request->getVar('birthplace'),
                            // // "createdby" => $this->request->getVar('createdby'),
                            'postcode' => $validation->getError('postcode'),
                            "education" => $this->request->getVar('education'),
                            "family_name" => $this->request->getVar('family_name'),
                            "family_addr" => $this->request->getVar('family_addr'),
                            "family_handphone" => $this->request->getVar('family_handphone'),
                            "family_relation" => $this->request->getVar('family_relation')

                        ];
                        // client request
                        $response = akses_restapi('POST', $url, $data);

                        $msg = [
                            'success' => 'data berhasil di create!'
                        ];
                    }

                    if ($this->request->getVar('action') == 'Edit') {
                        $patient_no = $this->request->getVar('patient_no');

                        // helper curl request
                        helper(['restclient']);
                        // endpoint
                        $url = "$this->server/patient/update/$patient_no";
                        // form params
                        $data = [
                            "fullname" => $this->request->getVar('fullname'),
                            "id_no" => $this->request->getVar('id_no'),
                            "gender" => $this->request->getVar('gender'),
                            "addr" => $this->request->getVar('addr'),
                            "mobile_no" => $this->request->getVar('mobile_no'),
                            "birth_dt" => date('Y-m-d', strtotime($this->request->getVar('birth_dt'))),
                            "id_typ" => $this->request->getVar('id_typ'),
                            "job_title_cd" => $this->request->getVar('job_title_cd'),
                            "religion" => $this->request->getVar('religion'),
                            "city_cd" => $this->request->getVar('city_cd'),
                            "married_sta_id" => $this->request->getVar('married_sta_id'),
                            "source_info" => $this->request->getVar('source_info'),
                            // // "register_dt" => $this->request->getVar('register_dt'),
                            // "phone_no" => $this->request->getVar('phone_no'),
                            "birthplace" => $this->request->getVar('birthplace'),
                            // // "createdby" => $this->request->getVar('createdby'),
                            'postcode' => $this->request->getVar('postcode'),
                            "education" => $this->request->getVar('education'),
                            "family_name" => $this->request->getVar('family_name'),
                            "family_addr" => $this->request->getVar('family_addr'),
                            "family_handphone" => $this->request->getVar('family_handphone'),
                            "family_relation" => $this->request->getVar('family_relation')
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

    function  validate_string($input)
    {
        return $input == '' ? FALSE : TRUE;
    }

    function fetchSingleData()
    {
        if ($this->request->isAJAX()) {

            $patient_no = $this->request->getVar('patient_no');

            if ($patient_no) {

                // helper curl request
                helper(['restclient']);
                // end point
                $url = "$this->server/patient/getby/$patient_no";
                // client request
                $response = akses_restapi('GET', $url, []);
                $data['response_data'] = json_decode($response, true);


                $msg = [
                    'data' => [
                        'patient_no' => $data["response_data"][0]["patient_no"],
                        'fullname' => $data["response_data"][0]["fullname"],
                        'id_no' => $data["response_data"][0]["id_no"],
                        'gender' => $data["response_data"][0]["gender"],
                        'addr' => $data["response_data"][0]["addr"],
                        'mobile_no' => $data["response_data"][0]["mobile_no"],
                        'birth_dt' => date('m/d/Y', strtotime($data["response_data"][0]["birth_dt"])),
                        'id_typ' => $data["response_data"][0]["id_typ"],
                        'job_title_cd' => $data["response_data"][0]["job_title_cd"],
                        'religion' => $data["response_data"][0]["religion"],
                        'city_cd' => $data["response_data"][0]["city_cd"],
                        'married_sta_id' => $data["response_data"][0]["married_sta_id"],
                        'source_info' => $data["response_data"][0]["source_info"],
                        'birthplace' => $data["response_data"][0]["birthplace"],
                        'postcode' => $data["response_data"][0]["postcode"],
                        'education' => $data["response_data"][0]["education"],
                        'family_name' => $data["response_data"][0]["family_name"],
                        'family_addr' => $data["response_data"][0]["family_addr"],
                        'family_handphone' => $data["response_data"][0]["family_handphone"],
                        'family_relation' => $data["response_data"][0]["family_relation"]
                    ]
                ];

                echo json_encode($msg);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    function fetchSingleDataPrint($patient_no)
    {

        if ($patient_no) {

            // helper curl request
            helper(['restclient']);
            // end point
            $url = "$this->server/patient/getby/$patient_no";
            // client request
            $response = akses_restapi('GET', $url, []);
            $data['response_data'] = json_decode($response, true);

            $pdf_data = $data['response_data'];
            $pdf_name = 'Single Data Patient';
            $pdf_title = 'Data Patient';
            $pdf_paper = 'A4';
            $pdf_orientation = 'portrait';
            $pdf_format = 'rpt_patient_pdf';

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

    public function getAge($birth_dt)
    {
        $date_exp = Time::parse(date('Y-m-d', strtotime($birth_dt)));
        $date_now = Time::now();
        $diff = $date_now->diff($date_exp);
        return $diff->y;
    }
}
