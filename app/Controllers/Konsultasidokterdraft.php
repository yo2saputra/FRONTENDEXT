<?php

namespace App\Controllers;

use App\Controllers\BaseController;
// use Config\Services;
// use App\Libraries\Pdfgenerator;
// use CodeIgniter\I18n\Time;



class Konsultasidokterdraft extends BaseController
{

    protected $data;
    protected $server;
    protected $client;

    public function __construct()
    {
        $this->session = session();
        $uri = service('uri');
        $this->server = $_ENV['APP_API'];

        //set flag session
        $this->apiMenuFlag($this->apiMenuMenucd($uri->getSegment(1))[0]['menu_cd'], session()->get('role_cd'));

        $this->data = [
            'menu_header' => $this->apiMenuHeader(session()->get('usr_id')),
            'menu' => $this->apiMenu(session()->get('usr_id'))
        ];
    }

    public function index()
    {
        // helper dropdown
        helper(['dropdown']);

        $this->data['title'] = ' | ' . $_ENV['APP_TITLE'];
        $this->data['cb_diagnosa_utama'] = getDropdownNolabelDiagnosa('diagnosa_utama', 4); // (id, input size)
        $this->data['cb_diagnosa_sekunder'] = getDropdownNolabelDiagnosa('diagnosa_sekunder', 4); // (id, input size)
        return view('konsultasidokter/indexdraft', $this->data);
    }

    public function apiDataGetAll()
    {
        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/tregistrasi/getalldphadir";

        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);

        return $data['response_data'];
    }

    public function apiDataGetByDokter()
    {
        // $emp_cd = $this->session->get('emp_cd');
        $emp_cd = 'E0003';

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/tregistrasi/getbydokter/$emp_cd";

        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);

        return $data['response_data'];
    }

    public function apiDataGetAllRiwayat($patient_no)
    {
        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/tmedicalrecord/getbypasien/$patient_no";

        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);

        return $data['response_data'];
    }


    public function setNoRegistrasi()
    {
        if ($this->request->isAJAX()) {
            $ses_data = [
                'no_registrasi' => $this->request->getVar('no_registrasi'),
                'patient_no' => $this->request->getVar('patient_no')
            ];
            $this->session->set($ses_data);
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }


    public function fetchAll()
    {
        // if ($this->request->isAJAX()) {

        $output = '';
        $data =  $this->apiDataGetByDokter();
        $output .= '  
                    <table id="example1" class="table table-sm table-striped" style="border-spacing: 0;">
                    <thead>
                            <tr>
                                <th>Pasien</th>
                                <th>Hadir</th>
                                <th></th>
                            </tr>
                        </thead>
                            ';
        if ($data == '') {
            $output .= '<tr>  
                                <td >Data not Found</td>
                                <td ></td>
                                <th></th>
                            </tr>';
        } else {
            for ($a = 0; $a < count($data); $a++) {

                $output .= '  
                            <tr id="addMdlBarang" data-id="' . $data[$a]["no_registrasi"] . '">
                                <td >' . $data[$a]["fullname"] . '</td>
                                <td >' . $data[$a]["hadir"] . '</td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm float-right mr-1 mt-1 pilihpasien pasien btn-fix-w" data-no_registrasi="' . $data[$a]["no_registrasi"] . '" data-patient_no="' . $data[$a]["no_pasien"] . '" data-kode_dokter="' . $data[$a]["dokter"] . '" data-fullname="' . $data[$a]["fullname"] . '" data-tahun="' . $data[$a]["tahun"] . '" data-bulan="' . $data[$a]["bulan"] . '" data-hari="' . $data[$a]["hari"] . '" data-gender="' . $data[$a]["gender_desc"] . '" data-birth_dt="' . $data[$a]["birth_dt"] . '" data-mobile_no="' . $data[$a]["mobile_no"] . '" data-jam_mulai="' . $data[$a]["jam_mulai"] . '" data-jam_selesai="' . $data[$a]["jam_selesai"] . '" data-tujuan_registrasi="' . $data[$a]["tujuan_registrasi"] . '" data-tujuan_registrasi_desc="' . $data[$a]["tujuan_registrasi_desc"] . '" data-type_pasien="' . $data[$a]["type_pasien"] . '" data-nama_dokter="' . $data[$a]["nama_dokter"] . '" data-no_kwitansi="' . $data[$a]["no_kwitansi"] . '" data-alergi="' . $data[$a]["alergi"] . '">
                                        Pilih
                                    </button>
                                </td>
                            </tr>  
                    ';
            }
        }
        $output .= '</table>
            <script type="text/javascript">
            $(function() {
                $("#example1").DataTable({
                    columnDefs: [{
                        orderable: false,
                        targets: 2
                    }],
                    // "dom": "Bfplit",
                    // "buttons": [
                    //     "copy", "csv", "excel", "pdf", "print"
                    // ],
                    "paging": false,
                    "lengthChange": true,
                    "searching": false,
                    "info": false,
                    "autoWidth": false
                });
            });
            </script>
            ';
        echo $output;
        // } else {
        //     exit('Maaf tidak dapat diproses!');
        // }
    }

    public function fetchAllRiwayatAnamnesa()
    {
        if ($this->request->isAJAX()) {

            $patient_no = $this->request->getVar('patient_no');

            $output = '';
            $data =  $this->apiDataGetAllRiwayat($patient_no);
            $output .= '  
                    <table id="example2" class="table table-sm table-striped" style="border-spacing: 0;">
                    <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Keluhan</th>
                                <th>Anamnesa</th>
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
                        <tr id="addMdlBarang" data-id="' . $data[$a]["medrec_id"] . '">
                            <td >' . date('d/m/Y', strtotime($data[$a]["tgl_pemeriksaan"])) . '</td>
                            <td >' . $data[$a]["keluhan"] . '</td>
                            <td >' . $data[$a]["anamnesa"] . '</td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm float-right mr-1 mt-1 pilihmr btn-fix-w" data-medrec_id="' . $data[$a]["medrec_id"] . '">
                                    Pilih
                                </button>
                            </td>
                        </tr>  
                ';
                }
            }
            $output .= '</table>
            <script type="text/javascript">
            $(function() {
                $("#example2").DataTable({
                    columnDefs: [{
                        orderable: false,
                        targets: 7
                    }],
                    "dom": "Bfplit",
                    // "buttons": [
                    //     "copy", "csv", "excel", "pdf", "print"
                    // ],
                    "paging": false,
                    "lengthChange": true,
                    "searching": false,
                    "info": false,
                    "autoWidth": false
                });
            });
            </script>
            ';
            echo $output;
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    public function fetchAllRiwayat()
    {
        if ($this->request->isAJAX()) {

            $patient_no = $this->request->getVar('patient_no');

            $output = '';
            $data =  $this->apiDataGetAllRiwayat($patient_no);

            if ($data == '') {
                $output .= '
                        <li class="item">
                            <div class="product-img">
                                <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                            </div>
                            <div class="product-info">
                                <a href="javascript:void(0)" class="product-title">
                                    <span class="badge badge-warning float-right"></span></a>
                                <span class="product-description">
                                    <p></p>
                                    <p></p>
                                </span>
                            </div>
                        </li>
                ';
            } else {
                for ($a = 0; $a < count($data); $a++) {

                    $output .= '  
                        <li class="item pilihregistrasi"
                         data-no_registrasi="' . $data[$a]["no_registrasi"] . '"
                         data-no_pasien="' . $data[$a]["no_pasien"] . '" 
                         data-tujuan_registrasi_desc="' . $data[$a]["tujuan_registrasi_desc"] . '"
                         data-tgl_praktek="' . $data[$a]["tgl_praktek"] . '" 
                         data-tahun="' . $data[$a]["tahun"] . '" 
                         data-bulan="' . $data[$a]["bulan"] . '" 
                         data-hari="' . $data[$a]["hari"] . '" 
                         data-nama_dokter="' . $data[$a]["nama_dokter"] . '" 
                         data-nadi="' . (int)$data[$a]["nadi"] . '" 
                         data-suhu="' . (int)$data[$a]["suhu"] . '" 
                         data-nafas="' . (int)$data[$a]["nafas"] . '" 
                         data-tekanan_darah="' . (int)$data[$a]["tekanan_darah"] . '" 
                         data-tinggi_badan="' . (int)$data[$a]["tinggi_badan"] . '" 
                         data-berat_badan="' . (int)$data[$a]["berat_badan"] . '" 
                         data-keluhan_utama="' . $data[$a]["keluhan_utama"] . '" 
                         data-keluhan_sekunder="' . $data[$a]["keluhan_sekunder"] . '" 
                         data-diagnosa_utama="' . $data[$a]["diagnosa_utama"] . '" 
                         data-diagnosa_sekunder="' . $data[$a]["diagnosa_sekunder"] . '" 
                         data-diagnosa_note="' . $data[$a]["diagnosa_note"] . '"
                         data-pf_rambut="' . $data[$a]["pf_rambut"] . '"
                         data-pf_mata="' . $data[$a]["pf_mata"] . '"
                         data-pf_telinga="' . $data[$a]["pf_telinga"] . '"
                         data-pf_hidung="' . $data[$a]["pf_hidung"] . '"
                         data-pf_tenggorokan="' . $data[$a]["pf_tenggorokan"] . '"
                         data-photo="' . $data[$a]["photo"] . '" >
                        <a href="javascript:void(0)" class="product-title">
                            <div class="product-img">
                                <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                            </div>
                            <div class="product-info">
                                ' . $data[$a]["no_registrasi"] . '
                                    <span class="badge badge-warning float-right">' . date('d/m/Y', strtotime($data[$a]["tgl_praktek"])) . '</span>
                                <span class="product-description">
                                    Rawat Jalan - ' . ($data[$a]["tujuan_registrasi_desc"] !== '' ? $data[$a]["tujuan_registrasi_desc"] : "") . '<br>
                                    ' . ($data[$a]["keluhan_utama"] !== '' ? $data[$a]["keluhan_utama"] : "") . '
                                </span>
                                
                            </div>
                            </a>
                        </li>
                    ';
                }
            }


            echo $output;
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    function fetchSingleData()
    {
        if ($this->request->isAJAX()) {

            $medrec_id = $this->request->getVar('medrec_id');

            if ($medrec_id) {

                // helper curl request
                helper(['restclient']);

                // end point
                $url = "$this->server/tmedicalrecord/getby/$medrec_id";

                // client request
                $response = akses_restapi('GET', $url, []);
                $data['response_data'] = json_decode($response, true);

                $msg = [
                    'data' => [
                        'medrec_id' => $data["response_data"][0]["medrec_id"],
                        'patient_no' => $data["response_data"][0]["patient_no"],
                        'fullname' => $data["response_data"][0]["fullname"],
                        'no_registrasi' => $data["response_data"][0]["no_registrasi"],
                        'tgl_pemeriksaan' => $data["response_data"][0]["tgl_pemeriksaan"],
                        'tahun' => $data["response_data"][0]["tahun"],
                        'bulan' => $data["response_data"][0]["bulan"],
                        'hari' => $data["response_data"][0]["hari"],
                        'keluhan' => $data["response_data"][0]["keluhan"],
                        'anamnesa' => $data["response_data"][0]["anamnesa"]
                    ]
                ];

                echo json_encode($msg);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    // function action()
    // {
    //     if ($this->request->isAJAX()) {
    //         if ($this->request->getVar('action')) {
    //             helper(['form', 'url']);

    //             $validation = \Config\Services::validation();
    //             $valid = $this->validate([
    //                 'no_registrasi' => [
    //                     'label' => 'No. Registrasi',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ],
    //                 'patient_no' => [
    //                     'label' => 'No. RM',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ],
    //                 'keluhan' => [
    //                     'label' => 'Keluhan',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ],
    //                 'anamnesa' => [
    //                     'label' => 'Anamnesa',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ]
    //             ]);
    //             if (!$valid) {
    //                 $msg = [
    //                     'error' => [
    //                         'no_registrasi' => $validation->getError('no_registrasi'),
    //                         'patient_no' => $validation->getError('patient_no'),
    //                         'keluhan' => $validation->getError('keluhan'),
    //                         'anamnesa' => $validation->getError('anamnesa')
    //                     ]
    //                 ];
    //             } else {

    //                 if ($this->request->getVar('action') == 'Add') {

    //                     // helper curl request
    //                     helper(['restclient']);

    //                     // endpoint
    //                     $url = "$this->server/tmedicalrecord/insert";

    //                     // form params
    //                     $data = [
    //                         "medrec_id" => '',
    //                         "patient_no" => str_replace(" ", "_", trim($this->request->getVar('patient_no'))),
    //                         "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
    //                         "fullname" => $this->request->getVar('fullname'),
    //                         "tgl_pemeriksaan" => $this->request->getVar('tgl_pemeriksaan'),
    //                         // "tahun" => $this->request->getVar('tahun'),
    //                         // "bulan" => $this->request->getVar('bulan'),
    //                         // "hari" => $this->request->getVar('hari'),
    //                         "keluhan" => $this->request->getVar('keluhan'),
    //                         "anamnesa" => $this->request->getVar('anamnesa'),
    //                         // "patient_no" => '23090001',
    //                         // "no_registrasi" => 'REG122300048',
    //                         // "fullname" => 'yoyo',
    //                         // "tgl_pemeriksaan" => '12-20-2023',
    //                         // "tgl_pemeriksaan" => '12-20-2023',
    //                         // "tahun" => 22,
    //                         // "bulan" => 2,
    //                         // "hari" => 2,
    //                         // "keluhan" => 'sehat 67676767',
    //                         // "anamnesa" => 'sehat 78787878'
    //                     ];
    //                     // client request
    //                     $response = akses_restapi('POST', $url, $data);

    //                     $msg = [
    //                         'success' => 'data berhasil di create!'
    //                     ];
    //                 }
    //             }

    //             echo json_encode($msg);
    //         }
    //     } else {
    //         exit('Maaf tidak dapat diproses!');
    //     }
    // }

    function action()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getVar('action')) {
                helper(['form', 'url']);

                $validation = \Config\Services::validation();
                $valid = $this->validate([
                    // 'no_registrasi' => [
                    //     'label' => 'No. Registrasi',
                    //     'rules' => 'required',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ],
                    'nadi' => [
                        'label' => 'Nadi',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'suhu' => [
                        'label' => 'Suhu',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'nafas' => [
                        'label' => 'Nafas',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'tekanan_darah' => [
                        'label' => 'Tekanan Darah',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'tinggi_badan' => [
                        'label' => 'Tinggi Badan',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'berat_badan' => [
                        'label' => 'Berat Badan',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'keluhan_utama' => [
                        'label' => 'Keluhan Utama',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'keluhan_sekunder' => [
                        'label' => 'Keluhan Sekunder',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'diagnosa_utama' => [
                        'label' => 'Diagnosa Utama',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'diagnosa_sekunder' => [
                        'label' => 'Diagnosa Sekunder',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'diagnosa_note' => [
                        'label' => 'Diagnosa Note',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'pf_rambut' => [
                        'label' => 'Rambut',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'pf_mata' => [
                        'label' => 'Mata',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'pf_telinga' => [
                        'label' => 'Telinga',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'pf_hidung' => [
                        'label' => 'Hidung',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'pf_tenggorokan' => [
                        'label' => 'Tenggorokan',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'reduksi_persen' => [
                        'label' => 'Reduksi',
                        'rules' => 'required|greater_than[0]|less_than[101]|numeric',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ]
                    // ,
                    // 'photo' => [
                    //     'label' => 'Photo',
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
                            'no_registrasi' => $validation->getError('no_registrasi'),
                            'patient_no' => $validation->getError('patient_no'),
                            'keluhan' => $validation->getError('keluhan'),
                            'anamnesa' => $validation->getError('anamnesa'),
                            'nadi' => $validation->getError('nadi'),
                            'suhu' => $validation->getError('suhu'),
                            'nafas' => $validation->getError('nafas'),
                            'tekanan_darah' => $validation->getError('tekanan_darah'),
                            'tinggi_badan' => $validation->getError('tinggi_badan'),
                            'berat_badan' => $validation->getError('berat_badan'),
                            'keluhan_utama' => $validation->getError('keluhan_utama'),
                            'keluhan_sekunder' => $validation->getError('keluhan_sekunder'),
                            'diagnosa_utama' => $validation->getError('diagnosa_utama'),
                            'diagnosa_sekunder' => $validation->getError('diagnosa_sekunder'),
                            'diagnosa_note' => $validation->getError('diagnosa_note'),
                            'pf_rambut' => $validation->getError('pf_rambut'),
                            'pf_mata' => $validation->getError('pf_mata'),
                            'pf_telinga' => $validation->getError('pf_telinga'),
                            'pf_hidung' => $validation->getError('pf_hidung'),
                            'pf_tenggorokan' => $validation->getError('pf_tenggorokan'),
                            'reduksi_persen' => $validation->getError('reduksi_persen'),
                        ]
                    ];
                } else {

                    if ($this->request->getVar('action') == 'Add') {

                        // helper curl request
                        helper(['restclient']);

                        $no_registrasi = $this->session->get('no_registrasi');

                        // endpoint
                        $url = "$this->server/tregistrasi/konsultasidokter/$no_registrasi";

                        // client request
                        $response = akses_restapi('PATCH', $url, []);
                        $data['response_data'] = json_decode($response, true);

                        // // endpoint
                        // $url = "$this->server/tmedicalrecord/insert";

                        // // form params
                        // $data = [
                        //     "patient_no" => str_replace(" ", "_", trim($this->request->getVar('patient_no'))),
                        //     "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
                        //     "fullname" => $this->request->getVar('fullname'),
                        //     "tgl_pemeriksaan" => $this->request->getVar('tgl_pemeriksaan'),
                        //     "keluhan" => $this->request->getVar('keluhan'),
                        //     "anamnesa" => $this->request->getVar('anamnesa')
                        // ];
                        // // client request
                        // $response = akses_restapi('POST', $url, $data);


                        // endpoint
                        $url = "$this->server/tregistrasipemeriksaanawal/insert";

                        // form params
                        $data = [
                            // "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
                            "no_registrasi" => $no_registrasi,
                            "nadi" => $this->request->getVar('nadi'),
                            "suhu" => $this->request->getVar('suhu'),
                            "nafas" => $this->request->getVar('nafas'),
                            "tekanan_darah" => $this->request->getVar('tekanan_darah'),
                            "tinggi_badan" => $this->request->getVar('tinggi_badan'),
                            "berat_badan" => $this->request->getVar('berat_badan')
                        ];
                        // client request
                        $response = akses_restapi('POST', $url, $data);



                        // endpoint
                        $url = "$this->server/tregistrasipemeriksaanumum/insert";

                        // form params RG000001
                        $data = [
                            // "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('patient_no'))),
                            "no_registrasi" => $no_registrasi,
                            "keluhan_utama" => $this->request->getVar('keluhan_utama'),
                            "keluhan_sekunder" => $this->request->getVar('keluhan_sekunder'),
                            "diagnosa_utama" => $this->request->getVar('diagnosa_utama'),
                            "diagnosa_sekunder" => $this->request->getVar('diagnosa_sekunder'),
                            "diagnosa_note" => $this->request->getVar('diagnosa_note'),
                            "pf_rambut" => $this->request->getVar('pf_rambut'),
                            "pf_mata" => $this->request->getVar('pf_mata'),
                            "pf_telinga" => $this->request->getVar('pf_telinga'),
                            "pf_hidung" => $this->request->getVar('pf_hidung'),
                            "pf_tenggorokan" => $this->request->getVar('pf_tenggorokan'),
                            "photo" => $this->request->getVar('medrec_id') . '_' . $no_registrasi
                        ];
                        // client request
                        $response = akses_restapi('POST', $url, $data);

                        // endpoint
                        $url = "$this->server/tregistrasipemeriksaaninfo/insert";

                        // form params
                        $data = [
                            "no_registrasi" => $no_registrasi,
                            "reduksi_persen" => $this->request->getVar('reduksi_persen'),
                            "reduksi_jumlah" => $this->request->getVar('suhu')
                        ];
                        // client request
                        $response = akses_restapi('POST', $url, $data);

                        // // endpoint
                        // $urlbilling = "$this->server/billing/update";

                        // // form params
                        // $databilling = [
                        //     'no_kwitansi' => $this->request->getVar('no_kwitansi'),
                        //     'no_registrasi' => $no_registrasi,
                        //     'tgl_kwitansi' => date("Y-m-d H:i:s"),
                        //     'emp_cd' => $this->session->get('usr_id'),
                        //     'status_kwitansi' => 'aktif',
                        //     'terbilang' => '',
                        //     'tagihan' => 100000,
                        //     // 'tagihan' => '1000000000',
                        //     'saldo' => 0,
                        // ];

                        // // client request
                        // $response = akses_restapi('POST', $urlbilling, $databilling);

                        // endpoint
                        $urlbillingdetail = "$this->server/billingdetail/insert";

                        // form params
                        $databillingdetail = [
                            'no_kwitansi' => $this->request->getVar('no_kwitansi'),
                            'item_cd' => 'PD1454',
                            'jumlah' => 1,
                            'tarif' => 100000,
                            'potongan' => $this->request->getVar('reduksi_persen'),
                            'pajak' => 0,
                            'total' => 100000 - (100000 * $this->request->getVar('reduksi_persen')) / 100,
                        ];

                        // client request
                        akses_restapi('POST', $urlbillingdetail, $databillingdetail);



                        // // endpoint
                        // $url = "$this->server/tpatientalergi/insert";

                        // // form params
                        // $data = [
                        //     "patient_no" => $this->request->getVar('patient_no'),
                        //     "alergi" => $this->request->getVar('alergi'),
                        //     "reported_dt" => $this->request->getVar('reported_dt')
                        // ];
                        // // client request
                        // $response = akses_restapi('POST', $url, $data);


                        // // helper curl request
                        // helper(['restclient']);

                        // // endpoint
                        // $url = "$this->server/tregistrasi/konsultasidokter/$no_registrasi";

                        // // client request
                        // $response = akses_restapi('PATCH', $url, []);
                        // $data['response_data'] = json_decode($response, true);

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

    function action2()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getVar('action2')) {
                helper(['form', 'url']);

                $validation = \Config\Services::validation();
                $valid = $this->validate([
                    // 'patient_no' => [
                    //     'label' => 'Code',
                    //     'rules' => 'required',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ],
                    'alergi' => [
                        'label' => 'Patient No',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'reported_dt' => [
                        'label' => 'reported_dt',
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
                            'patient_no' => $validation->getError('patient_no'),
                            'alergi' => $validation->getError('alergi'),
                            'reported_dt' => $validation->getError('reported_dt')
                        ]
                    ];
                } else {

                    if ($this->request->getVar('action2') == 'Add') {

                        // helper curl request
                        helper(['restclient']);

                        // endpoint
                        $url = "$this->server/tpatientalergi/double";

                        // form params
                        $data = [
                            "patient_no" => str_replace(" ", "_", trim($this->request->getVar('patient_no'))),
                            "alergi" => $this->request->getVar('alergi'),
                            "reported_dt" => date('Y-m-d')
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

    // function action2()
    // {
    //     if ($this->request->isAJAX()) {
    //         if ($this->request->getVar('action2')) {
    //             helper(['form', 'url']);

    //             $validation = \Config\Services::validation();
    //             $valid = $this->validate([
    //                 // 'no_registrasi' => [
    //                 //     'label' => 'No. Registrasi',
    //                 //     'rules' => 'required',
    //                 //     'errors' => [
    //                 //         //'required' => '{field} tidak boleh kosong',
    //                 //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                 //     ]
    //                 // ],
    //                 'nadi' => [
    //                     'label' => 'Nadi',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ],
    //                 'suhu' => [
    //                     'label' => 'Suhu',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ],
    //                 'nafas' => [
    //                     'label' => 'Nafas',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ],
    //                 'tekanan_darah' => [
    //                     'label' => 'Tekanan Darah',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ],
    //                 'tinggi_badan' => [
    //                     'label' => 'Tinggi Badan',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ],
    //                 'berat_badan' => [
    //                     'label' => 'Berat Badan',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ],
    //                 'keluhan_utama' => [
    //                     'label' => 'Keluhan Utama',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ],
    //                 'keluhan_sekunder' => [
    //                     'label' => 'Keluhan Sekunder',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ],
    //                 'diagnosa_utama' => [
    //                     'label' => 'Diagnosa Utama',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ],
    //                 'diagnosa_sekunder' => [
    //                     'label' => 'Diagnosa Sekunder',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ],
    //                 'diagnosa_note' => [
    //                     'label' => 'Diagnosa Note',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ],
    //                 'pf_rambut' => [
    //                     'label' => 'Rambut',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ],
    //                 'pf_mata' => [
    //                     'label' => 'Mata',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ],
    //                 'pf_telinga' => [
    //                     'label' => 'Telinga',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ],
    //                 'pf_hidung' => [
    //                     'label' => 'Hidung',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ],
    //                 'pf_tenggorokan' => [
    //                     'label' => 'Tenggorokan',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ],
    //                 'reduksi_persen' => [
    //                     'label' => 'Reduksi',
    //                     'rules' => 'required|greater_than[0]|less_than[101]|numeric',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ]
    //                 // ,
    //                 // 'photo' => [
    //                 //     'label' => 'Photo',
    //                 //     'rules' => 'required',
    //                 //     'errors' => [
    //                 //         //'required' => '{field} tidak boleh kosong',
    //                 //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                 //     ]
    //                 // ]
    //             ]);
    //             if (!$valid) {
    //                 $msg = [
    //                     'error' => [
    //                         'no_registrasi' => $validation->getError('no_registrasi'),
    //                         'patient_no' => $validation->getError('patient_no'),
    //                         'keluhan' => $validation->getError('keluhan'),
    //                         'anamnesa' => $validation->getError('anamnesa'),
    //                         'nadi' => $validation->getError('nadi'),
    //                         'suhu' => $validation->getError('suhu'),
    //                         'nafas' => $validation->getError('nafas'),
    //                         'tekanan_darah' => $validation->getError('tekanan_darah'),
    //                         'tinggi_badan' => $validation->getError('tinggi_badan'),
    //                         'berat_badan' => $validation->getError('berat_badan'),
    //                         'keluhan_utama' => $validation->getError('keluhan_utama'),
    //                         'keluhan_sekunder' => $validation->getError('keluhan_sekunder'),
    //                         'diagnosa_utama' => $validation->getError('diagnosa_utama'),
    //                         'diagnosa_sekunder' => $validation->getError('diagnosa_sekunder'),
    //                         'diagnosa_note' => $validation->getError('diagnosa_note'),
    //                         'pf_rambut' => $validation->getError('pf_rambut'),
    //                         'pf_mata' => $validation->getError('pf_mata'),
    //                         'pf_telinga' => $validation->getError('pf_telinga'),
    //                         'pf_hidung' => $validation->getError('pf_hidung'),
    //                         'pf_tenggorokan' => $validation->getError('pf_tenggorokan'),
    //                         'reduksi_persen' => $validation->getError('reduksi_persen'),
    //                     ]
    //                 ];
    //             } else {

    //                 if ($this->request->getVar('action2') == 'Add') {

    //                     // helper curl request
    //                     helper(['restclient']);

    //                     $no_registrasi = $this->session->get('no_registrasi');

    //                     // endpoint
    //                     $url = "$this->server/tregistrasi/konsultasidokter/$no_registrasi";

    //                     // client request
    //                     $response = akses_restapi('PATCH', $url, []);
    //                     $data['response_data'] = json_decode($response, true);

    //                     // // endpoint
    //                     // $url = "$this->server/tmedicalrecord/insert";

    //                     // // form params
    //                     // $data = [
    //                     //     "patient_no" => str_replace(" ", "_", trim($this->request->getVar('patient_no'))),
    //                     //     "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
    //                     //     "fullname" => $this->request->getVar('fullname'),
    //                     //     "tgl_pemeriksaan" => $this->request->getVar('tgl_pemeriksaan'),
    //                     //     "keluhan" => $this->request->getVar('keluhan'),
    //                     //     "anamnesa" => $this->request->getVar('anamnesa')
    //                     // ];
    //                     // // client request
    //                     // $response = akses_restapi('POST', $url, $data);


    //                     // endpoint
    //                     $url = "$this->server/tregistrasipemeriksaanawal/insert";

    //                     // form params
    //                     $data = [
    //                         // "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
    //                         "no_registrasi" => $no_registrasi,
    //                         "nadi" => $this->request->getVar('nadi'),
    //                         "suhu" => $this->request->getVar('suhu'),
    //                         "nafas" => $this->request->getVar('nafas'),
    //                         "tekanan_darah" => $this->request->getVar('tekanan_darah'),
    //                         "tinggi_badan" => $this->request->getVar('tinggi_badan'),
    //                         "berat_badan" => $this->request->getVar('berat_badan')
    //                     ];
    //                     // client request
    //                     $response = akses_restapi('POST', $url, $data);



    //                     // endpoint
    //                     $url = "$this->server/tregistrasipemeriksaanumum/insert";

    //                     // form params RG000001
    //                     $data = [
    //                         // "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('patient_no'))),
    //                         "no_registrasi" => $no_registrasi,
    //                         "keluhan_utama" => $this->request->getVar('keluhan_utama'),
    //                         "keluhan_sekunder" => $this->request->getVar('keluhan_sekunder'),
    //                         "diagnosa_utama" => $this->request->getVar('diagnosa_utama'),
    //                         "diagnosa_sekunder" => $this->request->getVar('diagnosa_sekunder'),
    //                         "diagnosa_note" => $this->request->getVar('diagnosa_note'),
    //                         "pf_rambut" => $this->request->getVar('pf_rambut'),
    //                         "pf_mata" => $this->request->getVar('pf_mata'),
    //                         "pf_telinga" => $this->request->getVar('pf_telinga'),
    //                         "pf_hidung" => $this->request->getVar('pf_hidung'),
    //                         "pf_tenggorokan" => $this->request->getVar('pf_tenggorokan'),
    //                         "photo" => $this->request->getVar('medrec_id') . '_' . $no_registrasi
    //                     ];
    //                     // client request
    //                     $response = akses_restapi('POST', $url, $data);

    //                     // endpoint
    //                     $url = "$this->server/tregistrasipemeriksaaninfo/insert";

    //                     // form params
    //                     $data = [
    //                         "no_registrasi" => $no_registrasi,
    //                         "reduksi_persen" => $this->request->getVar('reduksi_persen'),
    //                         "reduksi_jumlah" => $this->request->getVar('suhu')
    //                     ];
    //                     // client request
    //                     $response = akses_restapi('POST', $url, $data);


    //                     // endpoint
    //                     $url = "$this->server/tpatientalergi/insert";

    //                     // form params
    //                     $data = [
    //                         "patient_no" => $this->request->getVar('patient_no'),
    //                         "alergi" => $this->request->getVar('alergi'),
    //                         "reported_dt" => $this->request->getVar('reported_dt')
    //                     ];
    //                     // client request
    //                     $response = akses_restapi('POST', $url, $data);


    //                     // // helper curl request
    //                     // helper(['restclient']);

    //                     // // endpoint
    //                     // $url = "$this->server/tregistrasi/konsultasidokter/$no_registrasi";

    //                     // // client request
    //                     // $response = akses_restapi('PATCH', $url, []);
    //                     // $data['response_data'] = json_decode($response, true);

    //                     $msg = [
    //                         'success' => 'data berhasil di create!'
    //                     ];
    //                 }
    //             }

    //             echo json_encode($msg);
    //         }
    //     } else {
    //         exit('Maaf tidak dapat diproses!');
    //     }
    // }

    public function draw()
    {
        $this->data['title'] = ' | ' . $_ENV['APP_TITLE'];

        return view('konsultasidokter/draw', $this->data);
    }

    public function doupload()
    {
        helper('form');


        if ($this->request->isAJAX()) {
            $nobp = $this->request->getVar('nobp');

            $validation = \Config\Services::validation();

            if ($this->request->getPost('gambar') == '') {
                $msg = ['error' => 'Silahkan klik ambil gambar...'];
            } else {

                //cek dulu fotonya
                // $cekdata = $this->mhs->find($nobp);
                // $fotolama = $cekdata['foto'];
                // if ($fotolama != NULL || $fotolama != "") {
                //     unlink($fotolama);
                // }


                $image = $this->request->getPost('gambar');
                $image = str_replace('data:image/jpeg;base64,', '', $image);

                $image = base64_decode($image);
                // echo $image;
                $filename = $nobp . '.jpg';
                // $filename = 'yoyo' . '.jpg';
                file_put_contents(FCPATH . '/assets/img/titikkeluhan/' . $filename, $image);

                // $updatedata = [
                //     'foto' => './assets/images/foto/' . $filename
                // ];

                // $this->mhs->update($nobp, $updatedata);
                $msg = [
                    'success' => 'Foto berhasil di upload menggunakan webcam'
                ];
            }


            echo json_encode($msg);
        }
    }


    // public function fetchAll()
    // {
    //     if ($this->request->isAJAX()) {
    //         $output = '';
    //         $data =  $this->apiDataGetAll();
    //         $output .= '
    //         <div class="table-responsive">
    //                 <table id="example4" class="table table-hover table-striped">
    //                 <thead>
    //                         <tr>  
    //                             <th>Patient No</th>
    //                             <th>Full Name</th>
    //                             <th>ID No</th>
    //                             <th>Gender</th>
    //                             <th>Address</th>
    //                             <th>Mobile</th>
    //                             <th>Birth Date</th>
    //                             <th></th>
    //                         </tr>
    //                     </thead>
    //                         ';
    //         if ($data == '') {
    //             $output .= '<tr>  
    //                         <td >Data not Found</td>
    //                         <td ></td>
    //                         <td ></td>
    //                         <td ></td>
    //                         <td ></td>
    //                         <td ></td>
    //                         <td ></td>
    //                         <td ></td>
    //                     </tr>';
    //         } else {
    //             for ($a = 0; $a < count($data); $a++) {
    //                 $output .= '  
    //                 <tr id="addMdlBarang" data-id="' . $data[$a]["patient_no"] . '">
    //                     <td >' . $data[$a]["patient_no"] . '</td>
    //                     <td >' . $data[$a]["fullname"] . '</td>
    //                     <td >' . $data[$a]["id_no"] . '</td>
    //                     <td >' . $data[$a]["gender"] . '</td>
    //                     <td >' . $data[$a]["addr"] . '</td>
    //                     <td >' . $data[$a]["mobile_no"] . '</td>
    //                     <td >' . date('d/m/Y', strtotime($data[$a]["birth_dt"])) . '</td>
    //                     <td>
    //                         <button type="button" class="btn btn-danger btn-sm float-right mr-1 mt-1 delete btn-fix-w" data-patient_no="' . $data[$a]["patient_no"] . '" >
    //                             <i class="fas fa-trash"></i>
    //                         </button>
    //                         <button type="button" class="btn btn-primary btn-sm float-right mr-1 mt-1 edit btn-fix-w" data-patient_no="' . $data[$a]["patient_no"] . '" >
    //                             <i class="fas fa-tags"></i>
    //                         </button>
    //                         <a href="' . base_url('/patient/fetchSingleDataPrint/') . $data[$a]['patient_no'] . '" target="_blank" class="btn btn-warning btn-sm float-right mr-1 mt-1 print btn-fix-w" > <i class="fas fa-print"></i></a>
    //                     </td>
    //                 </tr>  
    //         ';
    //             }
    //         }
    //         $output .= '</table></div>
    //         <script type="text/javascript">
    //         $(function() {
    //             $("#example4").DataTable({
    //                 columnDefs: [{
    //                     orderable: false,
    //                     targets: 7
    //                 }],
    //                 "dom": "Bfplit",
    //                 "buttons": [
    //                     "copy", "csv", "excel", "pdf", "print"
    //                 ],
    //                 "paging": false,
    //                 "lengthChange": true,
    //                 "searching": false,
    //                 "info": false,
    //                 "autoWidth": false
    //             });
    //         });
    //         </script>
    //         ';
    //         echo $output;
    //     } else {
    //         exit('Maaf tidak dapat diproses!');
    //     }
    // }
}
