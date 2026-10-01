<?php

namespace App\Controllers;

use App\Controllers\BaseController;
// use Config\Services;
// use App\Libraries\Pdfgenerator;
// use CodeIgniter\I18n\Time;



class Konsultasidokter extends BaseController
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

        $this->data['cb_kategori_alergi'] = getDropdownNolabelVertical('kategori_alergi'); // (id, input size)
        $this->data['cb_bahan_alergi'] = getDropdownNolabelVertical('bahan_alergi'); // (id, input size)
        $this->data['cb_komponen_alergi'] = getDropdownNolabelVertical('komponen_alergi'); // (id, input size)
        $this->data['cb_reaksi_alergi'] = getDropdownNolabelVertical('reaksi_alergi'); // (id, input size)
        $this->data['cb_tingkat_kegawatan_alergi'] = getDropdownNolabelVertical('tingkat_kegawatan_alergi'); // (id, input size)
        $this->data['cb_status_alergi'] = getDropdownNolabelVertical('status_alergi'); // (id, input size)
        $this->data['cb_verifikasi_alergi'] = getDropdownNolabelVertical('verifikasi_alergi'); // (id, input size)
        return view('konsultasidokter/indexdraft', $this->data);
    }

    public function apiDataGetAllAnamnesaByPasien($patient_no)
    {
        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/listparameter/anamnesabyno_pasien/$patient_no";

        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);

        return $data['response_data'];
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

    public function apiDataGetByNoRegistrasi()
    {
        $no_registrasi = $this->request->getVar('no_registrasi');

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/ttitikkeluhan/getby/$no_registrasi";

        // client request
        $response = akses_restapi('GET', $url, []);

        // $data['response_data'] = json_decode($response, true);
        // return $data['response_data'];

        return $response;
    }

    public function apiDataGetByDokter()
    {
        $emp_cd = $this->session->get('emp_cd');
        // $emp_cd = 'E0003';

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

    public function apiDataGetAlergiByPasien()
    {
        // $emp_cd = $this->session->get('emp_cd');
        $patient_no = $this->request->getVar('patient_no');
        // $patient_no = "24040023";

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/tpatientalergi/getby/$patient_no";

        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);

        return $data['response_data'];
    }

    public function apiDataGetAnamnesaByPasien()
    {
        // $emp_cd = $this->session->get('emp_cd');
        $patient_no = $this->request->getVar('patient_no');
        // $patient_no = "24040023";

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/tpatientalergi/getby/$patient_no";

        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);

        return $data['response_data'];
    }

    public function fetchAllAlergi()
    {
        // if ($this->request->isAJAX()) {

        $output = '';
        $data =  $this->apiDataGetAlergiByPasien();
        $output .= '  
                    <table id="example2" class="table table-sm table-striped" style="border-spacing: 0;">
                    <thead>
                            <tr>
                                <th>No</th>
                                <th>Status</th>
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
                            <tr id="addMdlBarang" data-id="' . $data[$a]["patient_no"] . '">
                                <td >' . $data[$a]["alergi_no"] . '</td>
                                <td >' . $data[$a]["verifikasi"] . '</td>
                                <td>
                                    <button data-widget="control-sidebar" data-slide="true" type="button" class="btn btn-info btn-sm float-right mr-1 mt-1 pilihpasien pasien btn-fix-w" data-alergi_no="' . $data[$a]["alergi_no"] . '" data-patient_no="' . $data[$a]["patient_no"] . '">
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

    public function fetchAllAnamnesa()
    {
        // if ($this->request->isAJAX()) {

        $output = '';
        $data =  $this->apiDataGetAlergiByPasien();
        $output .= '  
                    <table id="example2" class="table table-sm table-striped" style="border-spacing: 0;">
                    <thead>
                            <tr>
                                <th>No</th>
                                <th>Status</th>
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
                            <tr id="addMdlBarang" data-id="' . $data[$a]["patient_no"] . '">
                                <td >' . $data[$a]["alergi_no"] . '</td>
                                <td >' . $data[$a]["verifikasi"] . '</td>
                                <td>
                                    <button data-widget="control-sidebar" data-slide="true" type="button" class="btn btn-info btn-sm float-right mr-1 mt-1 pilihpasien pasien btn-fix-w" data-alergi_no="' . $data[$a]["alergi_no"] . '" data-patient_no="' . $data[$a]["patient_no"] . '">
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
                                    <button data-widget="control-sidebar" data-slide="true" type="button" class="btn btn-info btn-sm float-right mr-1 mt-1 pilihpasien pasien btn-fix-w" data-no_registrasi="' . $data[$a]["no_registrasi"] . '" data-patient_no="' . $data[$a]["no_pasien"] . '" data-kode_dokter="' . $data[$a]["dokter"] . '" data-fullname="' . $data[$a]["fullname"] . '" data-tahun="' . $data[$a]["tahun"] . '" data-bulan="' . $data[$a]["bulan"] . '" data-hari="' . $data[$a]["hari"] . '" data-gender="' . $data[$a]["gender_desc"] . '" data-birth_dt="' . $data[$a]["birth_dt"] . '" data-mobile_no="' . $data[$a]["mobile_no"] . '" data-jam_mulai="' . $data[$a]["jam_mulai"] . '" data-jam_selesai="' . $data[$a]["jam_selesai"] . '" data-tujuan_registrasi_desc="' . $data[$a]["tujuan_registrasi_desc"] . '" data-type_pasien="' . $data[$a]["type_pasien"] . '" data-nama_dokter="' . $data[$a]["nama_dokter"] . '" data-no_kwitansi="' . $data[$a]["no_kwitansi"] . '" data-flag_alergi="' . $data[$a]["flag_alergi"] . '">
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

    public function fetchAllAnamnesaCardByPasien()
    {
        if ($this->request->isAJAX()) {

            $patient_no = $this->request->getVar('patient_no');

            $output = '';
            $data =  $this->apiDataGetAllAnamnesaByPasien($patient_no);

            if ($data == '') {
                $output .= '';
            } else {
                for ($a = 0; $a < count($data); $a++) {

                    $output .= '
                        <div class="card dudu" data-keluhan_utama="' . $data[$a]["keluhan_utama"] . '" data-riwayat_perjalanan_keluhan="' . $data[$a]["riwayat_perjalanan_keluhan"] . '" data-riwayat_penyakit_sekarang="' . $data[$a]["riwayat_penyakit_sekarang"] . '" data-riwayat_operasi_pengobatan="' . $data[$a]["riwayat_operasi_pengobatan"] . '" data-riwayat_penyakit_keluarga="' . $data[$a]["riwayat_penyakit_keluarga"] . '" data-riwayat_lain="' . $data[$a]["riwayat_lain"] . '" data-riwayat_penyakit_dahulu="' . $data[$a]["riwayat_penyakit_dahulu"] . '">
                            <div class="card-body">
                                <p>Anamnesa – ' . date('d/m/Y', strtotime($data[$a]["tgl_registrasi"])) . '</p>
                                <p>Keluhan : </p>
                                <p>[Isi informasi Keluhan]</p>
                            </div>
                        </div>
                        ';
                }
            }
            echo $output;
        } else {
            exit('Maaf tidak dapat diproses!');
        }
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
                         data-icd10="' . $data[$a]["icd10"] . '" >
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
                            "icd10" => $this->request->getVar('icd10')
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
                    'kategori_alergi' => [
                        'label' => 'Kategori',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'bahan_alergi' => [
                        'label' => 'Bahan',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'permulaan_dt' => [
                        'label' => 'Permulaan Date',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'komponen_alergi' => [
                        'label' => 'Komponen',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'reaksi_alergi' => [
                        'label' => 'Reaksi',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'tingkat_kegawatan_alergi' => [
                        'label' => 'Tingkat Kegawatan',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'status_alergi' => [
                        'label' => 'Status',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'verifikasi_alergi' => [
                        'label' => 'Verifikasi',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'catatan' => [
                        'label' => 'Catatan',
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
                            // 'patient_no' => $validation->getError('patient_no'),
                            'kategori_alergi' => $validation->getError('kategori_alergi'),
                            'bahan_alergi' => $validation->getError('bahan_alergi'),
                            'permulaan_dt' => $validation->getError('permulaan_dt'),
                            'komponen_alergi' => $validation->getError('komponen_alergi'),
                            'reaksi_alergi' => $validation->getError('reaksi_alergi'),
                            'tingkat_kegawatan_alergi' => $validation->getError('tingkat_kegawatan_alergi'),
                            'status_alergi' => $validation->getError('status_alergi'),
                            'verifikasi_alergi' => $validation->getError('verifikasi_alergi'),
                            'catatan' => $validation->getError('catatan')
                        ]
                    ];
                } else {

                    if ($this->request->getVar('action2') == 'Add') {

                        // helper curl request
                        helper(['restclient']);

                        // endpoint
                        $url = "$this->server/tpatientalergi/insert";

                        // form params
                        $data = [
                            "patient_no" => str_replace(" ", "_", trim($this->request->getVar('patient_no'))),
                            "kategori" => $this->request->getVar('kategori_alergi'),
                            "bahan" => $this->request->getVar('bahan_alergi'),
                            "permulaan_dt" => $this->request->getVar('permulaan_dt'),
                            "komponen" => $this->request->getVar('komponen_alergi'),
                            "reaksi" => $this->request->getVar('reaksi_alergi'),
                            "tingkat_kegawatan" => $this->request->getVar('tingkat_kegawatan_alergi'),
                            "status" => $this->request->getVar('status_alergi'),
                            "verifikasi" => $this->request->getVar('verifikasi_alergi'),
                            "catatan" => $this->request->getVar('catatan'),
                            // "icd10" => $this->request->getVar('icd10')
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

    function action_anamnesa()
    {
        // if ($this->request->isAJAX()) {
        if ($this->request->getVar('action_anamnesa')) {
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
                'keluhan_utama' => [
                    'label' => 'Keluhan Utama',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'riwayat_keluhan_utama' => [
                    'label' => 'Riwayat Keluhan Utama',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'status_psikologi_lain' => [
                    'label' => 'Status Psikologi Lain',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'status_sosial_tidakbaik' => [
                    'label' => 'Status Sosial Lain',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'status_spiritual' => [
                    'label' => 'Status Spiritual',
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
                        'no_registrasi' => $validation->getError('no_registrasi'),
                        'responden' => $validation->getError('responden'),
                        'keluhan_utama' => $validation->getError('keluhan_utama'),
                        'riwayat_perjalanan_keluhan' => $validation->getError('riwayat_perjalanan_keluhan'),
                        'riwayat_penyakit_sekarang' => $validation->getError('riwayat_penyakit_sekarang'),
                        'riwayat_penyakit_dahulu' => $validation->getError('riwayat_penyakit_dahulu'),
                        'riwayat_operasi_pengobatan' => $validation->getError('riwayat_operasi_pengobatan'),
                        'riwayat_penyakit_keluarga' => $validation->getError('riwayat_penyakit_keluarga'),
                        'riwayat_lain' => $validation->getError('riwayat_lain')
                    ]
                ];
            } else {

                if ($this->request->getVar('action_anamnesa') == 'Add') {

                    // helper curl request
                    helper(['restclient']);

                    // endpoint
                    $url = "$this->server/tregistrasianamnesa/insert";

                    // form params
                    $data = [
                        "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
                        "responden" => $this->request->getVar('responden'),
                        "keluhan_utama" => $this->request->getVar('keluhan_utama'),
                        "riwayat_perjalanan_keluhan" => $this->request->getVar('riwayat_perjalanan_keluhan'),
                        "riwayat_penyakit_sekarang" => $this->request->getVar('riwayat_penyakit_sekarang'),
                        "riwayat_penyakit_dahulu" => $this->request->getVar('riwayat_penyakit_dahulu'),
                        "riwayat_operasi_pengobatan" => $this->request->getVar('riwayat_operasi_pengobatan'),
                        "riwayat_penyakit_keluarga" => $this->request->getVar('riwayat_penyakit_keluarga'),
                        "riwayat_lain" => $this->request->getVar('riwayat_lain')
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
        // } else {
        //     exit('Maaf tidak dapat diproses!');
        // }
    }

    function action_periksa()
    {
        // if ($this->request->isAJAX()) {
        if ($this->request->getVar('action_periksa')) {
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
                'kondisi_umum' => [
                    'label' => 'Kondisi Umum',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'kondisi_khusus' => [
                    'label' => 'Kondisi Khusus',
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
                'sistolik' => [
                    'label' => 'Sistolik',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'diastolik' => [
                    'label' => 'Diastolik',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'denyut_nadi' => [
                    'label' => 'Denyut Nadi',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'laju_nafas' => [
                    'label' => 'Laju Nafas',
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
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'no_registrasi' => $validation->getError('no_registrasi'),
                        'kondisi_umum' => $validation->getError('kondisi_umum'),
                        'kondisi_khusus' => $validation->getError('kondisi_khusus'),
                        'tinggi_badan' => $validation->getError('tinggi_badan'),
                        'berat_badan' => $validation->getError('berat_badan'),
                        'sistolik' => $validation->getError('sistolik'),
                        'diastolik' => $validation->getError('diastolik'),
                        'denyut_nadi' => $validation->getError('denyut_nadi'),
                        'laju_nafas' => $validation->getError('laju_nafas'),
                        'suhu' => $validation->getError('suhu'),
                        'bmi' => $validation->getError('bmi'),
                        'pemeriksaan_tambahan' => $validation->getError('pemeriksaan_tambahan')
                    ]
                ];
            } else {

                if ($this->request->getVar('action_periksa') == 'Add') {

                    // helper curl request
                    helper(['restclient']);

                    // endpoint
                    $url = "$this->server/tregistrasiperiksa/insert";

                    // form params
                    $data = [
                        "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
                        "kondisi_umum" => $this->request->getVar('kondisi_umum'),
                        "kondisi_khusus" => $this->request->getVar('kondisi_khusus'),
                        "tinggi_badan" => $this->request->getVar('tinggi_badan'),
                        "berat_badan" => $this->request->getVar('berat_badan'),
                        "sistolik" => $this->request->getVar('sistolik'),
                        "diastolik" => $this->request->getVar('diastolik'),
                        "denyut_nadi" => $this->request->getVar('denyut_nadi'),
                        "laju_nafas" => $this->request->getVar('laju_nafas'),
                        "suhu" => $this->request->getVar('suhu'),
                        "bmi" => $this->request->getVar('bmi'),
                        "pemerisaan_tambahan" => $this->request->getVar('pemerisaan_tambahan')
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
        // } else {
        //     exit('Maaf tidak dapat diproses!');
        // }
    }

    function action_diagnosa()
    {
        // if ($this->request->isAJAX()) {
        if ($this->request->getVar('action_diagnosa')) {
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
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'diagnosa_utama' => $validation->getError('diagnosa_utama'),
                        'diagnosa_sekunder' => $validation->getError('diagnosa_sekunder')
                    ]
                ];
            } else {

                if ($this->request->getVar('action_diagnosa') == 'Add') {

                    // helper curl request
                    helper(['restclient']);

                    // endpoint
                    $url = "$this->server/tregistrasidiagnosa/insert";

                    // form params
                    $data = [
                        "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
                        "diagnosa_utama" => $this->request->getVar('diagnosa_utama'),
                        "icd10_utama" => $this->request->getVar('icd10_utama'),
                        "klasifikasi_utama" => $this->request->getVar('klasifikasi_utama'),
                        "diagnosa_sekunder" => $this->request->getVar('diagnosa_sekunder'),
                        "icd10_sekunder" => $this->request->getVar('icd10_sekunder'),
                        "klasifikasi_sekunder" => $this->request->getVar('klasifikasi_sekunder'),
                        "diagnosa_utama_sta" => $this->request->getVar('diagnosa_utama_sta'),
                        "diagnosa_sekunder_sta" => $this->request->getVar('diagnosa_sekunder_sta')
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
        // } else {
        //     exit('Maaf tidak dapat diproses!');
        // }
    }

    function action_all()
    {
        // if ($this->request->isAJAX()) {
        if ($this->request->getVar('action_all')) {
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
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'diagnosa_utama' => $validation->getError('diagnosa_utama'),
                        'diagnosa_sekunder' => $validation->getError('diagnosa_sekunder')
                    ]
                ];
            } else {

                if ($this->request->getVar('action_diagnosa') == 'Add') {

                    // helper curl request
                    helper(['restclient']);

                    // endpoint
                    $url = "$this->server/tregistrasidiagnosa/insert";

                    // form params
                    $data = [
                        "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
                        "diagnosa_utama" => $this->request->getVar('diagnosa_utama'),
                        "icd10_utama" => $this->request->getVar('icd10_utama'),
                        "klasifikasi_utama" => $this->request->getVar('klasifikasi_utama'),
                        "diagnosa_sekunder" => $this->request->getVar('diagnosa_sekunder'),
                        "icd10_sekunder" => $this->request->getVar('icd10_sekunder'),
                        "klasifikasi_sekunder" => $this->request->getVar('klasifikasi_sekunder'),
                        "diagnosa_utama_sta" => $this->request->getVar('diagnosa_utama_sta'),
                        "diagnosa_sekunder_sta" => $this->request->getVar('diagnosa_sekunder_sta')
                    ];
                    // client request
                    $response = akses_restapi('POST', $url, $data);

                    $msg = [
                        'success' => 'data berhasil di create!'
                    ];
                }

                /*--START ANAMNESA--*/
                // helper curl request
                helper(['restclient']);
                // endpoint
                $url = "$this->server/tregistrasianamnesa/insert";
                // form params
                $data = [
                    "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
                    "responden" => $this->request->getVar('responden'),
                    "keluhan_utama" => $this->request->getVar('keluhan_utama'),
                    "riwayat_perjalanan_keluhan" => $this->request->getVar('riwayat_perjalanan_keluhan'),
                    "riwayat_penyakit_sekarang" => $this->request->getVar('riwayat_penyakit_sekarang'),
                    "riwayat_penyakit_dahulu" => $this->request->getVar('riwayat_penyakit_dahulu'),
                    "riwayat_operasi_pengobatan" => $this->request->getVar('riwayat_operasi_pengobatan'),
                    "riwayat_penyakit_keluarga" => $this->request->getVar('riwayat_penyakit_keluarga'),
                    "riwayat_lain" => $this->request->getVar('riwayat_lain')
                ];
                // client request
                $response = akses_restapi('POST', $url, $data);
                /*--END ANAMNESA--*/

                // helper curl request
                helper(['restclient']);

                // endpoint
                $url = "$this->server/tregistrasiperiksa/insert";

                // form params
                $data = [
                    "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
                    "kondisi_umum" => $this->request->getVar('kondisi_umum'),
                    "kondisi_khusus" => $this->request->getVar('kondisi_khusus'),
                    "tinggi_badan" => $this->request->getVar('tinggi_badan'),
                    "berat_badan" => $this->request->getVar('berat_badan'),
                    "sistolik" => $this->request->getVar('sistolik'),
                    "diastolik" => $this->request->getVar('diastolik'),
                    "denyut_nadi" => $this->request->getVar('denyut_nadi'),
                    "laju_nafas" => $this->request->getVar('laju_nafas'),
                    "suhu" => $this->request->getVar('suhu'),
                    "bmi" => $this->request->getVar('bmi'),
                    "pemerisaan_tambahan" => $this->request->getVar('pemerisaan_tambahan')
                ];
                // client request
                $response = akses_restapi('POST', $url, $data);

                $diagnosa_utama = $this->request->getVar('diagnosa_utama');
                $number = count($diagnosa_utama);
                if ($number > 0) {
                    for ($i = 0; $i < $number; $i++) {
                        if (trim($diagnosa_utama[$i] != '')) {
                        }
                    }
                }
            }

            echo json_encode($msg);
        }
        // } else {
        //     exit('Maaf tidak dapat diproses!');
        // }
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

    public function draw1()
    {
        $this->data['title'] = ' | ' . $_ENV['APP_TITLE'];

        return view('konsultasidokter/draw1', $this->data);
    }

    public function draw2()
    {
        $this->data['title'] = ' | ' . $_ENV['APP_TITLE'];

        return view('konsultasidokter/draw2', $this->data);
    }

    public function draw3()
    {
        $this->data['title'] = ' | ' . $_ENV['APP_TITLE'];

        return view('konsultasidokter/draw3', $this->data);
    }

    public function draw4()
    {
        $this->data['title'] = ' | ' . $_ENV['APP_TITLE'];

        return view('konsultasidokter/draw4', $this->data);
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

    public function doupload1()
    {
        helper('form');


        if ($this->request->isAJAX()) {
            $image_nm = $this->request->getVar('image_nm');
            $no_registrasi = $this->request->getVar('no_registrasi');

            $validation = \Config\Services::validation();

            if ($this->request->getPost('gambar') == '') {
                $msg = ['error' => 'Silahkan klik ambil gambar...'];
            } else {

                $image = $this->request->getPost('gambar');
                $image = str_replace('data:image/jpeg;base64,', '', $image);

                $image = base64_decode($image);

                $filename = $image_nm . '.jpg';

                file_put_contents(FCPATH . '/assets/img/titikkeluhan/' . $filename, $image);

                // endpoint
                $url = "$this->server/ttitikkeluhan/insert";

                // form params
                $data = [
                    "no_registrasi" => $no_registrasi,
                    "image" => $image_nm
                ];
                // client request
                $response = akses_restapi('POST', $url, $data);

                $msg = [
                    'success' => 'Foto berhasil di upload menggunakan webcam'
                ];
            }


            echo json_encode($msg);
        }
    }

    public function doupload2()
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

    public function doupload3()
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

    public function doupload4()
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
