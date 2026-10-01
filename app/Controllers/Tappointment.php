<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;
use CodeIgniter\I18n\Time;

class Tappointment extends BaseController
{

    protected $data;
    protected $server, $server3;
    protected $client;

    public function __construct()
    {
        $this->session = session();
        $uri = service('uri');
        $this->server = $_ENV['APP_API'];
        $this->server3 = $_ENV['APP_API3'];
    }

    public function index()
    {
        // helper dropdown
        helper(['dropdown']);

        $this->data['cb_pasien'] = getDropdownPasien2('patient_no', 'Pasien', 2, 4); // (id,Label,label size, input size)
        $this->data['cb_tujuan'] = getDropdownPolyclinicCustom('tujuan_registrasi', 'tujuan_registrasi', 'Tujuan Registrasi', 2, 4); // (key,id,Label,label size, input size, filter)
        // $this->data['cb_tujuan'] = getDropdownCustomFilter('tujuan_registrasi', 'tujuan_registrasi', 'Tujuan Registrasi', 2, 4, ['dokter']); // (key,id,Label,label size, input size, filter)
        $this->data['cb_pasien2'] = getDropdownPasienCustom('patient_no', 'patient_no_v', 'Pasien', 2, 4); // (key,id,Label,label size, input size)
        $this->data['cb_tujuan2'] = getDropdownPolyclinicCustom('tujuan_registrasi', 'tujuan_registrasi_v', 'Tujuan Registrasi', 2, 4); // (key,id,Label,label size, input size)
        // $this->data['cb_tujuan2'] = getDropdownCustom('tujuan_registrasi', 'tujuan_registrasi_v', 'Tujuan Registrasi', 2, 4); // (key,id,Label,label size, input size)
        $this->data['cb_type_pasien'] = getDropdown2('Tipe_Pasien', 'Tipe Pasien', 2, 4); // (id,Label,label size, input size)
        $this->data['cb_type_pasien2'] = getDropdownCustom('Tipe_Pasien', 'Tipe_Pasien_v', 'Tipe Pasien', 2, 4); // (key,id,Label,label size, input size)
        $this->data['cb_asuransi'] = getDropdownAsuransiCustomFilter('asr_cd', 'asr_cd', 'Asuransi', 2, 4, []); // (key,id,Label,label size, input size)
        $this->data['cb_asuransi2'] = getDropdownAsuransiCustomFilter('asr_cd', 'asr_cd_v', 'Asuransi', 2, 4, []); // (key,id,Label,label size, input size)
        // $this->data['cb_dokter'] = getDropdownDokterCustom('kode_dokter', 'kode_dokter', 'Dokter', 2, 10); // (key,id,Label,label size, input size)

        // $this->data['cb_tujuan'] = getDropdownPolyclinicCustom('tujuan_registrasi', 'tujuan_registrasi', 'Tujuan Registrasi', 2, 4); // (key,id,Label,label size, input size, filter)
        $this->data['cb_registrasi_via'] = getDropdown2('registrasi_via', 'Daftar Via', 2, 4); // (id,Label,label size, input size)

        return view('appointment/index', $this->data);
    }

    public function datatables()
    {
        helper(['restclient']);
        $rawBody = $this->request->getBody();
        $json = json_decode($rawBody, true);

        $startDate = $json['startDate'] ?? null;
        $endDate = $json['endDate'] ?? null;
        $search = $json['search']['value'] ?? '';

        $url = "{$this->server3}/api/appointment/datatables2";
        $payload = $json + [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'search' =>  $search,
        ];


        // $url = "{$this->server3}/api/purchaserequest/datatables";
        $response = akses_restapikey('POST', $url, $payload);
        $result = json_decode($response, true);


        // Tambahkan kolom aksi ke setiap data
        foreach ($result['data'] as $i => &$row) {
            $cd = $row['no_appointment'];
            $row['rownum'] = $i + ($json['start'] ?? 0) + 1;
            $row['aksi'] = '
                <div class="btn-group text-right">
                <a href="https://wa.me/' . preg_replace("/0/", "62", $row["mobile_no"], 1) . '" target="_blank" data-toggle="tooltip" data-placement="top" title="Chat" class="btn btn-sm btn-default chat" data-no_appointment="' . $row["no_appointment"] . '"><i class="fas fa-comment-dots"></i></a>
                <a data-toggle="tooltip" data-placement="top" title="View" class="btn btn-sm btn-info view ' . ($this->session->get("flag_view") === 1 ? "" : "d-none") . '" data-no_appointment="' . $row["no_appointment"] . '"><i class="fas fa-eye"></i></a>
                <a data-toggle="tooltip" data-placement="top" title="Batal" class="btn btn-sm btn-warning batal ' . ($this->session->get("flag_update") === 1 ? "" : "d-none") . '" data-no_appointment="' . $row["no_appointment"] . '"><i class="fas fa-tags"></i></a>
                <a data-toggle="tooltip" data-placement="top" title="Hadir" class="btn btn-sm btn-success hadir ' . ($this->session->get("flag_update") === 1 ? "" : "d-none") . '" data-no_appointment="' . $row["no_appointment"] . '"><i class="fas fa-tags"></i></a>
                <a data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-sm btn-danger delete ' . ($this->session->get("flag_delete") === 1 ? "" : "d-none") . '" data-no_appointment="' . $row["no_appointment"] . '"><i class="fas fa-trash"></i></a>
                </div>
            ';
        }

        return $this->response->setJSON($result);
    }

    public function apiDataGetAll()
    {

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/tappointment/getall";

        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);
        return $data['response_data'];
    }

    function fetchAllView()
    {
        if ($this->request->isAJAX()) {

            $no_appointment = $this->request->getVar('no_appointment');

            if ($no_appointment) {

                // helper curl request
                helper(['restclient']);

                // end point
                $url = "$this->server/tappointment/getby/$no_appointment";

                // client request
                $response = akses_restapi('GET', $url, []);
                $data['response_data'] = json_decode($response, true);

                $msg = [
                    'data' => [
                        'no_appointment' => $data["response_data"][0]["no_appointment"],
                        'no_pasien' => $data["response_data"][0]["no_pasien"],
                        'tgl_registrasi' => $data["response_data"][0]["tgl_registrasi"],
                        'registrasi_via' => $data["response_data"][0]["registrasi_via"],
                        'tujuan_registrasi' => $data["response_data"][0]["tujuan_registrasi"],
                        'dokter' => $data["response_data"][0]["dokter"],
                        'jadwal_dokter' => $data["response_data"][0]["jadwal_dokter"],
                        'created_by' => $data["response_data"][0]["created_by"],
                        'created_date' => $data["response_data"][0]["created_date"],
                        'tgl_praktek' => $data["response_data"][0]["tgl_praktek"],
                        'jam_mulai' => $data["response_data"][0]["jam_mulai"],
                        'jam_selesai' => $data["response_data"][0]["jam_selesai"],
                        'tahun' => $data["response_data"][0]["tahun"],
                        'bulan' => $data["response_data"][0]["bulan"],
                        'hari' => $data["response_data"][0]["hari"],
                        'fullname' => $data["response_data"][0]["fullname"],
                        'gender' => $data["response_data"][0]["gender"],
                        'birth_dt' => $data["response_data"][0]["birth_dt"],
                        'addr' => $data["response_data"][0]["addr"],
                        'mobile_no' => $data["response_data"][0]["mobile_no"],
                        'nama_dokter' => $data["response_data"][0]["nama_dokter"],
                        'daftar' => $data["response_data"][0]["daftar"],
                        'hadir' => $data["response_data"][0]["hadir"],
                        'selesai' => $data["response_data"][0]["selesai"],
                        'Tipe_Pasien' => $data["response_data"][0]["type_pasien"],
                        'asr_cd' => $data["response_data"][0]["asr_cd"],
                        'lainnya' => $data["response_data"][0]["lainnya"] // Ditambahkan
                    ]
                ];

                echo json_encode($msg);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    public function hadir()
    {
        if ($this->request->isAJAX()) {
            $no_appointment = $this->request->getVar('no_appointment');

            // helper curl request
            helper(['restclient']);

            // endpoint
            $url = "$this->server/tappointment/hadir/$no_appointment";

            // client request
            $response = akses_restapi('PATCH', $url, []);
            $data['response_data'] = json_decode($response, true);

            $msg = [
                'success' => "Data dengan no $no_appointment berhasil diubah"
            ];
            echo json_encode($msg);
        }
    }

    public function batal()
    {
        if ($this->request->isAJAX()) {
            $no_appointment = $this->request->getVar('no_appointment');

            // helper curl request
            helper(['restclient']);

            // endpoint
            $url = "$this->server/tappointment/batal/$no_appointment";

            // client request
            $response = akses_restapi('PATCH', $url, []);
            $data['response_data'] = json_decode($response, true);

            $msg = [
                'success' => "Data dengan no $no_appointment berhasil diubah"
            ];
            echo json_encode($msg);
        }
    }


    public function delete()
    {
        if ($this->request->isAJAX()) {
            $no_appointment = $this->request->getVar('no_appointment');

            // helper curl request
            helper(['restclient']);

            // endpoint
            $url = "$this->server/tappointment/delete/$no_appointment";

            // client request
            $response = akses_restapi('DELETE', $url, []);
            $data['response_data'] = json_decode($response, true);

            $msg = [
                'success' => "Data dengan no $no_appointment berhasil dihapus"
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
                    'patient_no' => [
                        'label' => 'Pasien',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'tujuan_registrasi' => [
                        'label' => 'Tujuan',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'Tipe_Pasien' => [
                        'label' => 'Tipe Pasien',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'asr_cd' => [
                        'label' => 'Asuransi',
                        'rules' => $this->request->getVar('Tipe_Pasien') === 'ASRN' ? 'required' : 'permit_empty',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'kode_dokter' => [
                        'label' => 'Dokter',
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
                            'tujuan_registrasi' => $validation->getError('tujuan_registrasi'),
                            'Tipe_Pasien' => $validation->getError('Tipe_Pasien'),
                            'asr_cd' => $validation->getError('asr_cd'),
                            'kode_dokter' => $validation->getError('kode_dokter'),
                            'jam_mulai' => $validation->getError('jam_mulai')
                        ]
                    ];
                } else {

                    if ($this->request->getVar('action') == 'Add') {

                        // helper curl request
                        helper(['restclient']);

                        // endpoint
                        $url = "$this->server/tappointment/insert";

                        // form params
                        $data = [
                            "no_appointment" => str_replace(" ", "_", trim($this->request->getVar('no_appointment'))),
                            "no_pasien" => str_replace(" ", "_", trim($this->request->getVar('no_pasien'))),
                            "type_pasien" => $this->request->getVar('Tipe_Pasien'),
                            "asr_cd" => $this->request->getVar('asr_cd'),
                            "jam_mulai" => $this->request->getVar('jam_mulai'),
                            "jam_selesai" => $this->request->getVar('jam_selesai'),
                            // "reference" => $this->request->getVar('reference'),
                            // "deleted" => ($this->request->getVar('deleted') == FALSE) ? 0 : 1,
                            // "header_id" => $this->request->getVar('id'),
                            // "menu_order" => $this->request->getVar('menu_order'),
                            // "menu_icon" => $this->request->getVar('menu_icon')
                        ];
                        // client request
                        $response = akses_restapi('POST', $url, $data);

                        $msg = [
                            'success' => 'data berhasil di create!'
                        ];
                    }

                    if ($this->request->getVar('action') == 'Registrasi') {

                        // helper curl request
                        helper(['restclient']);

                        // endpoint
                        $url = "$this->server/tappointment/insert";

                        // form params
                        $data = [
                            // "no_appointment" => str_replace(" ", "_", trim($this->request->getVar('no_appointment'))),
                            "no_appointment" => '',
                            "no_pasien" => str_replace(" ", "_", trim($this->request->getVar('patient_no'))),
                            "tgl_registrasi" => $this->request->getVar('tgl_registrasi'),
                            // "deleted" => ($this->request->getVar('deleted') == FALSE) ? 0 : 1,
                            // "registrasi_via" => $this->request->getVar('registrasi_via'),
                            "registrasi_via" => $this->request->getVar('registrasi_via'),
                            "tujuan_registrasi" => $this->request->getVar('tujuan_registrasi'),
                            "dokter" => $this->request->getVar('kode_dokter'),
                            "jadwal_dokter" => $this->request->getVar('jadwal_id'),
                            "created_by" => session()->get('usr_id'),
                            // "created_date" => $this->request->getVar('tgl_registrasi'),
                            "created_date" => Time::now('Asia/Jakarta')->toDateTimeString(),
                            "tgl_praktek" => $this->request->getVar('tanggal'),
                            "jam_mulai" => $this->request->getVar('jam_mulai'),
                            "jam_selesai" => $this->request->getVar('jam_selesai'),
                            "tahun" => $this->request->getVar('tahun'),
                            "bulan" => $this->request->getVar('bulan'),
                            "hari" => $this->request->getVar('hari'),
                            "daftar" => 1,
                            "hadir" => 0,
                            "type_pasien" => $this->request->getVar('Tipe_Pasien'),
                            "cashless" => $this->request->getVar('cashless'),
                            "asr_cd" => $this->request->getVar('asr_cd'),
                            "lainnya" => $this->request->getVar('lainnya')
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
                        $url = "$this->server/tappointment/update";

                        // form params
                        $data = [
                            "no_appointment" => str_replace(" ", "_", trim($this->request->getVar('no_appointment'))),
                            "no_pasien" => str_replace(" ", "_", trim($this->request->getVar('no_pasien'))),
                            // "reference" => $this->request->getVar('reference'),
                            // "deleted" => ($this->request->getVar('deleted') == FALSE) ? 0 : 1,
                            // "header_id" => $this->request->getVar('id'),
                            // "menu_order" => $this->request->getVar('menu_order'),
                            // "menu_icon" => $this->request->getVar('menu_icon')
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



    // function fetchSingleData()
    // {
    //     if ($this->request->isAJAX()) {

    //         $menu_cd = $this->request->getVar('menu_cd');

    //         if ($menu_cd) {

    //             // helper curl request
    //             helper(['restclient']);

    //             // end point
    //             $url = "$this->server/menu/getby/$menu_cd";

    //             // client request
    //             $response = akses_restapi('GET', $url, []);
    //             $data['response_data'] = json_decode($response, true);

    //             $msg = [
    //                 'data' => [
    //                     'menu_cd' => $data["response_data"][0]["menu_cd"],
    //                     'menu_nm' => $data["response_data"][0]["menu_nm"],
    //                     'reference' => $data["response_data"][0]["reference"],
    //                     'header_id' => $data["response_data"][0]["header_id"],
    //                     'deleted' => $data["response_data"][0]["deleted"],
    //                     'menu_order' => $data["response_data"][0]["menu_order"],
    //                     'menu_icon' => $data["response_data"][0]["menu_icon"]
    //                 ]
    //             ];

    //             echo json_encode($msg);
    //         }
    //     } else {
    //         exit('Maaf tidak dapat diproses!');
    //     }
    // }

    function fetchSingleDataPrint($menu_cd)
    {

        if ($menu_cd) {

            // helper curl request
            helper(['restclient']);

            // end point
            $url = "$this->server/menu/getby/$menu_cd";

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

    function getDropdown()
    {

        // helper dropdown
        helper(['dropdown']);

        $poli = $this->request->getVar('poli');

        $cb_dokter = getDropdownDokterCustomTree($poli); // (key,id,Label,label size, input size);

        return $cb_dokter;
    }
}
