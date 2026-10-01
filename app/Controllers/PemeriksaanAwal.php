<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;
use CodeIgniter\I18n\Time;



class PemeriksaanAwal extends BaseController
{

    protected $data;
    protected $server, $server5;
    protected $client;

    public function __construct()
    {
        $this->session = session();
        $uri = service('uri');
        $this->server = $_ENV['APP_API'];
        $this->server5 = $_ENV['APP_API5'];
    }

    public function index()
    {
        // helper dropdown
        helper(['dropdown']);
        $this->data['cb_gender'] = getDropdown2('gender', 'Jenis Kelamin', 2, 2); // (id,Label,label size, input size)
        $this->data['cb_id_typ'] = getDropdown2('id_typ', 'Jenis Identitas Pasien', 2, 2); // (id,Label,label size, input size)
        $this->data['cb_job_title_cd'] = getDropdown2('job_title_cd', 'Pekerjaan', 1, 3); // (id,Label,label size, input size)
        $this->data['cb_religion'] = getDropdown2('religion', 'Agama', 1, 3); // (id,Label,label size, input size)
        $this->data['cb_birthplace'] = getDropdownKotaCustomFilter('birthplace', 'birthplace', 'Tempat', 2, 2, []); // (id, input size)$key, $name, $label, $label_size, $input_size, $filter
        $this->data['cb_city_cd'] = getDropdownKotaCustomFilter('city_cd', 'city_cd', 'Kota', 2, 4, []); // (id, input size)$key, $name, $label, $label_size, $input_size, $filter
        $this->data['cb_married_sta_id'] = getDropdown2('married_sta_id', 'Status', 1, 3); // (id,Label,label size, input size)
        $this->data['cb_source_info'] = getDropdown2('source_info', 'Source Info', 1, 3); // (id,Label,label size, input size)
        $this->data['cb_education'] = getDropdown2('education', 'Pendidikan', 1, 3); // (id,Label,label size, input size)
        $this->data['cb_family_relation'] = getDropdown('family_relation', 'Hubungan dengan Pasien', 2, 10); // (id,Label,label size, input size)
        $this->data['cb_title_cd'] = getDropdown2('title_cd', 'Title', 2, 2); // (id,Label,label size, input size)
        $this->data['cb_country'] = getDropdown2('country', '', 2, 2); // (id,Label,label size, input size)
        $this->data['cb_country_cd'] = getDropdown2('country_cd', 'Kode Negara', 2, 2); // (id,Label,label size, input size)

        $this->data['cb_dokter'] = getDropdownDokterNolabelVertical('dokter_rujukan'); // (name)
        $this->data['cb_jenissurat'] = getDropdownNolabelVertical('jenis_surat'); // (name)
        $this->data['cb_layanan'] = getDropdownNolabelVerticalWithoutName('layanan'); // (name)
        $this->data['cb_layanan_item'] = getDropdownNolabelVertical('item_test'); // (name)

        $this->data['cb_kesadaran'] = getDropdownNolabelVertical('kesadaran'); // (id,Label,label size, input size)
        $this->data['cb_pemeriksaan_fisik'] = getDropdownNolabelVertical('pemeriksaan_fisik'); // (id,Label,label size, input size)
        $this->data['cb_psikososial_dan_spiritual'] = getDropdownNolabelVertical('psikososial_dan_spiritual'); // (id,Label,label size, input size)
        $this->data['cb_skrining_nyeri'] = getDropdownNolabelVertical('skrining_nyeri'); // (id,Label,label size, input size)

        $this->data['cb_kondisi_umum'] = getDropdownNolabelVertical('kondisi_umum'); // (id,Label,label size, input size)

        return view('pemeriksaanawal/indexdraft', $this->data);
    }

    function action()
    {
        // if ($this->request->isAJAX()) {
        if ($this->request->getVar('action')) {
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
                // 'tinggi_badan' => [
                //     'label' => 'Tinggi Badan',
                //     'rules' => 'required',
                //     'errors' => [
                //         //'required' => '{field} tidak boleh kosong',
                //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                //     ]
                // ],
                // 'berat_badan' => [
                //     'label' => 'Berat Badan',
                //     'rules' => 'required',
                //     'errors' => [
                //         //'required' => '{field} tidak boleh kosong',
                //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                //     ]
                // ],
                // 'lingkar_pinggang' => [
                //     'label' => 'Lingkar Pinggang',
                //     'rules' => 'required',
                //     'errors' => [
                //         //'required' => '{field} tidak boleh kosong',
                //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                //     ]
                // ],
                // 'lingkar_pinggul' => [
                //     'label' => 'Lingkar Pinggul',
                //     'rules' => 'required',
                //     'errors' => [
                //         //'required' => '{field} tidak boleh kosong',
                //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                //     ]
                // ],
                // 'lingkar_lengan_atas' => [
                //     'label' => 'Lingkar Lengan Atas',
                //     'rules' => 'required',
                //     'errors' => [
                //         //'required' => '{field} tidak boleh kosong',
                //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                //     ]
                // ],
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
                'nadi' => [
                    'label' => 'Nadi',
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
                'spo2' => [
                    'label' => 'SpO2',
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
                'kesadaran' => [
                    'label' => 'Kondisi Umum',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                // 'kondisi_umum' => [
                //     'label' => 'Kondisi Umum',
                //     'rules' => 'required',
                //     'errors' => [
                //         //'required' => '{field} tidak boleh kosong',
                //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                //     ]
                // ],
                // 'kesadaran_umum' => [
                //     'label' => 'Kesadaran Umum',
                //     'rules' => 'required',
                //     'errors' => [
                //         //'required' => '{field} tidak boleh kosong',
                //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                //     ]
                // ],
                // 'skala_nyeri' => [
                //     'label' => 'Skala Nyeri',
                //     'rules' => 'required',
                //     'errors' => [
                //         //'required' => '{field} tidak boleh kosong',
                //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                //     ]
                // ],
                // 'resiko_jatuh' => [
                //     'label' => 'Resiko Jatuh',
                //     'rules' => 'required',
                //     'errors' => [
                //         //'required' => '{field} tidak boleh kosong',
                //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                //     ]
                // ],
                'status_fungsional' => [
                    'label' => 'Status Fungsional',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'kebutuhan_edukasi' => [
                    'label' => 'Kebutuhan Edukasi',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                // 'input_user' => [
                //     'label' => 'Input User',
                //     'rules' => 'required',
                //     'errors' => [
                //         //'required' => '{field} tidak boleh kosong',
                //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                //     ]
                // ],
                // 'input_date' => [
                //     'label' => 'Input Date',
                //     'rules' => 'required',
                //     'errors' => [
                //         //'required' => '{field} tidak boleh kosong',
                //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                //     ]
                // ],
                // 'update_user' => [
                //     'label' => 'Update User',
                //     'rules' => 'required',
                //     'errors' => [
                //         //'required' => '{field} tidak boleh kosong',
                //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                //     ]
                // ],
                // 'update_date' => [
                //     'label' => 'Update Date',
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
                        // 'tinggi_badan' => $validation->getError('tinggi_badan'),
                        // 'berat_badan' => $validation->getError('berat_badan'),
                        // 'lingkar_pinggang' => $validation->getError('lingkar_pinggang'),
                        // 'lingkar_pinggul' => $validation->getError('lingkar_pinggul'),
                        // 'lingkar_lengan_atas' => $validation->getError('lingkar_lengan_atas'),
                        'sistolik' => $validation->getError('sistolik'),
                        'diastolik' => $validation->getError('diastolik'),
                        'nadi' => $validation->getError('nadi'),
                        'laju_nafas' => $validation->getError('laju_nafas'),
                        'spo2' => $validation->getError('spo2'),
                        'suhu' => $validation->getError('suhu'),
                        // 'kondisi_umum' => $validation->getError('kondisi_umum'),
                        // 'kesadaran' => $validation->getError('kesadaran'),
                        // 'skala_nyeri' => $validation->getError('skrining_nyeri'), // berbeda nama field
                        // 'resiko_jatuh' => $validation->getError('resiko_jatuh'),
                        'status_fungsional' => $validation->getError('status_fungsional'),
                        'kebutuhan_edukasi' => $validation->getError('kebutuhan_edukasi'),
                        // 'input_user' => $validation->getError('input_user'),
                        // 'input_date' => $validation->getError('input_date'),
                        // 'update_user' => $validation->getError('update_user'),
                        // 'update_date' => $validation->getError('update_date')
                    ]
                ];
            } else {

                // helper curl request
                helper(['restclient']);

                $no_registrasi_clean = str_replace(" ", "_", trim($this->request->getVar('no_registrasi')));

                // cek apakah data sudah pernah ada -> menentukan insert (Add) atau update (Edit)
                $existingRow = $this->apiDataGetPemeriksaanAwalByRegistrasi($no_registrasi_clean);
                $isEdit      = !empty($existingRow);

                $usr_id = (string)($this->session->get('usr_id') ?? '');

                $data = [
                    "no_registrasi" => $no_registrasi_clean,
                    "tinggi_badan" => $this->request->getVar('tinggi_badan'),
                    "berat_badan" => $this->request->getVar('berat_badan'),
                    "lingkar_pinggang" => $this->request->getVar('lingkar_pinggang'),
                    "lingkar_pinggul" => $this->request->getVar('lingkar_pinggul'),
                    "lingkar_lengan_atas" => $this->request->getVar('muac'),
                    "sistolik" => $this->request->getVar('sistolik'),
                    "diastolik" => $this->request->getVar('diastolik'),
                    "nadi" => $this->request->getVar('nadi'),
                    "laju_nafas" => $this->request->getVar('laju_nafas'),
                    "spo2" => $this->request->getVar('spo2'),
                    "suhu" => $this->request->getVar('suhu'),
                    "kondisi_umum" => $this->request->getVar('kondisi_umum'),
                    "kesadaran_umum" => $this->request->getVar('kesadaran'),
                    "skala_nyeri" => $this->request->getVar('skrining_nyeri'), // berbeda nama field
                    "resiko_jatuh" => $this->request->getVar('resiko_jatuh'),
                    "status_fungsional" => $this->request->getVar('status_fungsional'),
                    "kebutuhan_edukasi" => $this->request->getVar('kebutuhan_edukasi'),
                    "input_user" => $isEdit ? ($existingRow['input_user'] ?? $usr_id) : $usr_id,
                    "update_user" => $isEdit ? $usr_id : '',
                    "input_date" => $isEdit ? ($existingRow['input_date'] ?? date('Y-m-d')) : date('Y-m-d'),
                    "update_date" => date('Y-m-d'),

                    // "input_date" => '2024-10-02',
                    // "update_date" => '2024-10-02',

                    // Field baru dari ALTER TABLE pertama
                    "pemeriksaan_fisik" => $this->request->getVar('pemeriksaan_fisik'),
                    "psikososial_dan_spiritual" => $this->request->getVar('psikososial_dan_spiritual'),
                    "riwayat_kesehatan_pasien" => $this->request->getVar('riwayat_kesehatan_pasien'),
                    "riwayat_operasi_pengobatan" => $this->request->getVar('riwayat_operasi_pengobatan'),
                    "riwayat_penggunaan_obat" => $this->request->getVar('riwayat_penggunaan_obat'),
                    "keluhan_utama" => $this->request->getVar('keluhan_utama'),

                    // Field baru dari ALTER TABLE kedua
                    // "resiko_jatuh_a" => $this->request->getVar('resiko_jatuh_a'),
                    // "resiko_jatuh_a1" => $this->request->getVar('resiko_jatuh_a1'),
                    // "resiko_jatuh_a2" => $this->request->getVar('resiko_jatuh_a2'),
                    // "resiko_jatuh_b" => $this->request->getVar('resiko_jatuh_b'),
                    // "resiko_jatuh_hasil_b1" => $this->request->getVar('resiko_jatuh_hasil_b1'),
                    // "resiko_jatuh_hasil_b2" => $this->request->getVar('resiko_jatuh_hasil_b2'),
                    // "resiko_jatuh_hasil_b3" => $this->request->getVar('resiko_jatuh_hasil_b3'),
                    // "resiko_jatuh_tindakan_b1" => $this->request->getVar('resiko_jatuh_tindakan_b1'),
                    // "resiko_jatuh_tindakan_b2" => $this->request->getVar('resiko_jatuh_tindakan_b2'),
                    // "resiko_jatuh_tindakan_b3" => $this->request->getVar('resiko_jatuh_tindakan_b3'),
                    "pemeriksaan_diagnostik" => $this->request->getVar('pemeriksaan_diagnostik'),
                    "diagnosa_keperawatan" => $this->request->getVar('diagnosa_keperawatan'),
                    "status_kehamilan" => $this->request->getVar('status_kehamilan'),
                    "status_kehamilan_hpht" => $this->request->getVar('status_kehamilan_hpht'),
                    "status_kehamilan_gravid" => $this->request->getVar('status_kehamilan_gravid'),
                    "status_kehamilan_abortus" => $this->request->getVar('status_kehamilan_abortus'),
                    "status_fungsional_mandiri" => $this->request->getVar('status_fungsional_mandiri'),
                    "status_fungsional_perlubantuan" => $this->request->getVar('status_fungsional_perlubantuan'),
                    "status_fungsional_perlubantuan_text" => $this->request->getVar('status_fungsional_perlubantuan_text'),
                    "status_fungsional_ketergantungan_total" => $this->request->getVar('status_fungsional_ketergantungan_total'),
                    "ssc_nama_operator" => $this->request->getVar('ssc_nama_operator'),
                    "ssc_tindakan" => $this->request->getVar('ssc_tindakan'),
                    "ssc_tgl" => $this->request->getVar('ssc_tgl'),

                    // Field baru dari ALTER TABLE ketiga
                    "kepala_dan_wajah" => $this->request->getVar('kepala_dan_wajah'),
                    "cervical_spin" => $this->request->getVar('cervical_spin'),
                    "thorax" => $this->request->getVar('thorax'),
                    "abdomen" => $this->request->getVar('abdomen'),
                    "pemeriksaan_neurologis" => $this->request->getVar('pemeriksaan_neurologis'),
                    "ekstremitas_muskulosekeletal" => $this->request->getVar('ekstremitas_muskulosekeletal'),
                    "status_lokalis" => $this->request->getVar('status_lokalis')
                ];

                /*--START ALERGI--*/
                $alergi_data = $this->request->getVar('alergi');

                if (!empty($alergi_data)) {
                    foreach ($alergi_data as $i => $alergi) {
                        // Ambil komponen dan reaksi (pastikan dalam bentuk array)
                        $komponen_arr = (array) ($alergi['komponen'] ?? []);
                        $reaksi_arr = (array) ($alergi['reaksi'] ?? []);

                        // Bersihkan data dari karakter '+' dan spasi
                        $komponen_arr = array_map(function ($v) {
                            return trim(str_replace('+', '', $v));
                        }, $komponen_arr);

                        $reaksi_arr = array_map(function ($v) {
                            return trim(str_replace('+', '', $v));
                        }, $reaksi_arr);

                        // Hapus nilai kosong
                        $komponen_arr = array_filter($komponen_arr);
                        $reaksi_arr = array_filter($reaksi_arr);

                        // Gabung jadi string dengan koma
                        $komponen_gabung = implode(',', $komponen_arr);
                        $reaksi_gabung = implode(',', $reaksi_arr);

                        // Siapkan data untuk API
                        $data_alergi = [
                            "patient_no" => str_replace(" ", "_", trim($this->request->getVar('patient_no'))),
                            "kategori" => $alergi['kategori'] ?? '',
                            "komponen" => $komponen_gabung,
                            "reaksi" => $reaksi_gabung,
                            "keterangan" => $alergi['keterangan'] ?? ''
                        ];



                        $alergi_no = trim($alergi['alergi_no'] ?? '');

                        // Log untuk debugging (opsional)
                        log_message('info', 'Processing alergi index ' . $i . ': kategori=' . $data_alergi['kategori'] . ', komponen=' . $komponen_gabung . ', reaksi=' . $reaksi_gabung . ', alergi_no=' . $alergi_no);

                        // Pilih method berdasarkan ada/tidaknya alergi_no
                        if (!empty($alergi_no)) {
                            // Update data yang sudah ada
                            $data_alergi["alergi_no"] = $alergi_no;
                            $url = "$this->server/tpatientalergi/update";
                            $response = akses_restapi('PUT', $url, $data_alergi);
                        } else {
                            // Insert data baru
                            $url = "$this->server/tpatientalergi/insert";
                            $response = akses_restapi('POST', $url, $data_alergi);
                        }

                        // Cek response jika perlu
                        if (isset($response['error'])) {
                            log_message('error', 'Gagal proses alergi: ' . json_encode($response));
                        }
                    }
                }

                // client request
                if ($isEdit) {
                    $url = "$this->server/tregistrasipemeriksaanawalperawat/update";
                    $response = akses_restapi('PUT', $url, $data);
                    $msg = ['success' => 'Data pemeriksaan awal berhasil diubah!'];

                    log_message('debug', '[PemeriksaanAwal::action] payload=' . json_encode($data));
                    log_message('debug', '[PemeriksaanAwal::action] raw_response=' . $response);
                } else {
                    $url = "$this->server/tregistrasipemeriksaanawalperawat/insert";
                    $response = akses_restapi('POST', $url, $data);
                    $msg = ['success' => 'Data pemeriksaan awal berhasil disimpan!'];
                }
            }

            echo json_encode($msg);
        }
        // } else {
        //     exit('Maaf tidak dapat diproses!');
        // }
    }

    function fetchAllDataPrint()
    {
        // helper curl request
        helper(['restclient']);
        // end point
        $url = "$this->server/pasien/getby/23090001";
        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);

        $pdf_data = $data['response_data'];
        $pdf_name = 'Single Data Patient';
        $pdf_title = 'Data Patient';
        $pdf_paper = 'A4';
        $pdf_orientation = 'portrait';
        $pdf_format = 'rpt_checklist_verifikasi_pdf';

        $this->view_pdf($pdf_name, $pdf_title, $pdf_data, $pdf_paper, $pdf_orientation, $pdf_format);
    }

    public function apiDataGetByDokter()
    {
        $emp_cd = $this->session->get('emp_cd');
        // $emp_cd = 'E0003';

        // helper curl request
        helper(['restclient']);

        // check role for endpoint
        if ($this->session->get('role_cd') == 'ROLE002') {
            // endpoint
            $url = "$this->server/tregistrasi/getbydokter/$emp_cd";
        } else {
            // endpoint
            $url = "$this->server/tregistrasi/getbyperawat";
        }


        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);

        return $data['response_data'];
    }

    private function apiDataGetPemeriksaanAwalByRegistrasi($no_registrasi)
    {
        helper(['restclient']);
        $url = "$this->server/tregistrasipemeriksaanawalperawat/getby/$no_registrasi";
        $response = akses_restapi('GET', $url, []);
        $decoded  = json_decode($response, true);

        if (empty($decoded)) return null;
        $row = isset($decoded['data']) ? (isset($decoded['data'][0]) ? $decoded['data'][0] : $decoded['data']) : (isset($decoded[0]) ? $decoded[0] : $decoded);

        if (empty($row) || !isset($row['no_registrasi'])) return null;
        return $row;
    }

    public function fetchPemeriksaanAwalByRegistrasi()
    {
        $no_registrasi = $this->request->getVar('no_registrasi');
        if (empty($no_registrasi)) {
            return $this->response->setJSON(['status' => 'empty', 'data' => null]);
        }

        $row = $this->apiDataGetPemeriksaanAwalByRegistrasi($no_registrasi);

        if ($row) {
            return $this->response->setJSON(['status' => 'success', 'data' => $row]);
        }
        return $this->response->setJSON(['status' => 'empty', 'data' => null]);
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
        // $data['response_data'] = json_decode($response, true);

        return $response;
    }

    public function fetchAllAlergi()
    {
        // if ($this->request->isAJAX()) {

        $output = '';
        $data =  $this->apiDataGetAlergiByPasien();

        if ($data == '') {
            $output .= '';
        } else {
            for ($a = 1; $a < count($data); $a++) {

                $output .= '
                            <tr id="row' . $a . '">
                                <td>
                                    <select class="custom-select" name="kategori_alergi[]" id="kategori_alergi' . $a . '">
                                        <option value=" " selected="selected">-- Select --</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="custom-select" name="komponen_alergi[]" id="komponen_alergi' . $a . '">
                                        <option value=" " selected="selected">-- Select --</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="custom-select" name="reaksi_alergi[]" id="reaksi_alergi' . $a . '">
                                        <option value=" " selected="selected">-- Select --</option>
                                    </select>
                                    <input type="hidden" name="alergi_no" value="' . $data[$a]["alergi_no"] . '_' . $a . '">
                                </td>
                                <td>
                                    <button type="button" name="remove" id="' . $a . '" class="btn btn-danger btn_remove_alergi">X</button>
                                </td>
                            </tr>
                            <script type="text/javascript">
                            $(document).ready(function() {
                                $("#kategori_alergi' . $a . '", "#dynamic_alergi").select2({
                                    ajax: {
                                        url: "' . site_url('konsultasidokter/ajaxKategoriAlergi/kategori_alergi') . '",
                                        dataType: "json",
                                        data: function(params) {
                                            var query = {
                                                search: params.term
                                            }

                                            // Query parameters will be ?search=[term]&type=user_search
                                            return query;
                                        },
                                        processResults: function(data) {
                                            return {
                                                results: data
                                            };
                                        }
                                    },
                                    cache: true,
                                    placeholder: "Search ...",
                                    minimumInputLength: 0,
                                    width: "auto",
                                    // templateResult: formatResult2 //your selection format
                                });

                                $("#komponen_alergi' . $a . '", "#dynamic_alergi").select2({
                                    ajax: {
                                        url: "' . site_url('konsultasidokter/ajaxKategoriAlergi/komponen_alergi') . '",
                                        dataType: "json",
                                        data: function(params) {
                                            var query = {
                                                search: params.term
                                            }

                                            // Query parameters will be ?search=[term]&type=user_search
                                            return query;
                                        },
                                        processResults: function(data) {
                                            return {
                                                results: data
                                            };
                                        }
                                    },
                                    cache: true,
                                    placeholder: "Search ...",
                                    minimumInputLength: 0,
                                    width: "auto",
                                    // templateResult: formatResult2 //your selection format
                                });

                                $("#reaksi_alergi' . $a . '", "#dynamic_alergi").select2({
                                    ajax: {
                                        url: "' . site_url('konsultasidokter/ajaxKategoriAlergi/reaksi_alergi') . '",
                                        dataType: "json",
                                        data: function(params) {
                                            var query = {
                                                search: params.term
                                            }

                                            // Query parameters will be ?search=[term]&type=user_search
                                            return query;
                                        },
                                        processResults: function(data) {
                                            return {
                                                results: data
                                            };
                                        }
                                    },
                                    cache: true,
                                    placeholder: "Search ...",
                                    minimumInputLength: 0,
                                    width: "auto",
                                    // templateResult: formatResult2 //your selection format
                                });
                            });
                            </script>
                    ';
            }
        }

        echo $output;
        // } else {
        //     exit('Maaf tidak dapat diproses!');
        // }
    }

    public function apiDataGetDiagnosaTambahanByRegistrasi()
    {
        // $emp_cd = $this->session->get('emp_cd');
        $no_registrasi = $this->request->getVar('no_registrasi');
        // $patient_no = "24040023";

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/tregistrasidiagnosatambahan/getby/$no_registrasi";

        // client request
        $response = akses_restapi('GET', $url, []);
        // $data['response_data'] = json_decode($response, true);

        return $response;
    }

    public function setDataPemeriksaanPerawat()
    {
        // if ($this->request->isAJAX()) {
        $no_registrasi = $this->request->getVar('no_registrasi');

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "{$this->server5}/api/PemeriksaanPerawat/by-no-registrasi/$no_registrasi";
        $response = akses_restapikey('GET', $url, [], []);

        // client request
        $data = json_decode($response, true);

        // Jika data ditemukan, kirimkan ke view untuk diisi ke form
        if (!empty($data) && is_array($data)) {
            echo json_encode([
                'status' => 'success',
                'data' => $data['data']
            ]);
        } else {
            echo json_encode([
                'status' => 'empty',
                'message' => 'Data pemeriksaan belum tersedia'
            ]);
        }
        // } else {
        //     exit('Maaf tidak dapat diproses!');
        // }
    }

    public function apiDataGetAllRiwayatByPasien($patient_no)
    {
        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/listparameter/riwayatbyno_pasien/$patient_no";

        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);

        return $data['response_data'];
    }

    public function fetchAllRiwayatCardByPasien()
    {
        // if ($this->request->isAJAX()) {

        $patient_no = $this->request->getVar('patient_no');

        $output = '';
        $data =  $this->apiDataGetAllRiwayatByPasien($patient_no);

        if ($data == '') {
            $output .= '';
        } else {
            for ($a = 0; $a < count($data); $a++) {

                $output .= '
                        <div class="card riwayat" data-no_registrasi="' . $data[$a]["no_registrasi"] . '" data-patient_no="' . $data[$a]["no_pasien"] . '">
                            <div class="card-body">
                                <p>Anamnesa – ' . date('d/m/Y', strtotime($data[$a]["tgl_registrasi"])) . '</p>
                                <p>Keluhan : ' . $data[$a]["keluhan_utama"] . '</p>
                                <p>Dokter : ' . ucwords($data[$a]["dokter"]) . '</p>
                            </div>
                        </div>
                        ';
            }
        }
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
                                    <button data-widget="control-sidebar" data-slide="true" type="button" class="btn ' . ($data[$a]["status"] === "DT" ? "btn-warning" : "btn-info") . ' btn-sm float-right mr-1 mt-1 pilihpasien pasien btn-fix-w" data-no_registrasi="' . $data[$a]["no_registrasi"] . '" data-patient_no="' . $data[$a]["no_pasien"] . '" data-kode_dokter="' . $data[$a]["dokter"] . '" data-fullname="' . $data[$a]["fullname"] . '" data-tahun="' . $data[$a]["tahun"] . '" data-bulan="' . $data[$a]["bulan"] . '" data-hari="' . $data[$a]["hari"] . '" data-gender="' . $data[$a]["gender_desc"] . '" data-birth_dt="' . $data[$a]["birth_dt"] . '" data-mobile_no="' . $data[$a]["mobile_no"] . '" data-jam_mulai="' . $data[$a]["jam_mulai"] . '" data-jam_selesai="' . $data[$a]["jam_selesai"] . '" data-tujuan_registrasi="' . $data[$a]["tujuan_registrasi"] . '" data-tujuan_registrasi_desc="' . $data[$a]["tujuan_registrasi_desc"] . '" data-type_pasien="' . $data[$a]["type_pasien"] . '" data-nama_dokter="' . $data[$a]["nama_dokter"] . '" data-no_kwitansi="' . $data[$a]["no_kwitansi"] . '" data-flag_alergi="' . $data[$a]["flag_alergi"] . '" data-status="' . $data[$a]["status"] . '"
                                    data-keluhan_utama="' . $data[$a]["keluhan_utama"] . '"
                                    data-responden="' . $data[$a]["responden"] . '"
                                    data-riwayat_lain="' . $data[$a]["riwayat_lain"] . '"
                                    data-riwayat_operasi_pengobatan="' . $data[$a]["riwayat_operasi_pengobatan"] . '"
                                    data-riwayat_penyakit_dahulu="' . $data[$a]["riwayat_penyakit_dahulu"] . '"
                                    data-riwayat_penyakit_keluarga="' . $data[$a]["riwayat_penyakit_keluarga"] . '"
                                    data-riwayat_penyakit_sekarang="' . $data[$a]["riwayat_penyakit_sekarang"] . '"
                                    data-riwayat_perjalanan_keluhan="' . $data[$a]["riwayat_perjalanan_keluhan"] . '"
                                    data-berat_badan="' . $data[$a]["berat_badan"] . '"
                                    data-bmi="' . $data[$a]["bmi"] . '"
                                    data-denyut_nadi="' . $data[$a]["denyut_nadi"] . '"
                                    data-diastolik="' . $data[$a]["diastolik"] . '"
                                    data-kondisi_khusus="' . $data[$a]["kondisi_khusus"] . '"
                                    data-kondisi_umum="' . $data[$a]["kondisi_umum"] . '"
                                    data-laju_nafas="' . $data[$a]["laju_nafas"] . '"
                                    data-pemeriksaan_tambahan="' . $data[$a]["pemeriksaan_tambahan"] . '"
                                    data-sistolik="' . $data[$a]["sistolik"] . '"
                                    data-suhu="' . $data[$a]["suhu"] . '"
                                    data-tinggi_badan="' . $data[$a]["tinggi_badan"] . '"
                                    data-diagnosa_sekunder="' . $data[$a]["diagnosa_sekunder"] . '"
                                    data-diagnosa_sekunder_sta="' . $data[$a]["diagnosa_sekunder_sta"] . '"
                                    data-diagnosa_utama="' . $data[$a]["diagnosa_utama"] . '"
                                    data-diagnosa_utama_sta="' . $data[$a]["diagnosa_utama_sta"] . '"
                                    data-icd10_sekunder="' . $data[$a]["icd10_sekunder"] . '"
                                    data-icd10_utama="' . $data[$a]["icd10_utama"] . '"
                                    data-klasifikasi_sekunder="' . $data[$a]["klasifikasi_sekunder"] . '"
                                    data-klasifikasi_utama="' . $data[$a]["klasifikasi_utama"] . '"
                                    data-laboratorium="' . $data[$a]["laboratorium"] . '"
                                    data-prosedur_primer="' . $data[$a]["prosedur_primer"] . '"
                                    data-prosedur_skunder="' . $data[$a]["prosedur_skunder"] . '"
                                    data-radiologi="' . $data[$a]["radiologi"] . '"
                                    data-reduksi="' . $data[$a]["reduksi"] . '"
                                    data-resep="' . $data[$a]["resep"] . '"
                                    data-tatalaksana="' . $data[$a]["tatalaksana"] . '"
                                    data-dokter_rujukan="' . $data[$a]["dokter_rujukan"] . '"
                                    data-ket_rujukan="' . $data[$a]["ket_rujukan"] . '"
                                    data-rujukan="' . $data[$a]["ket_rujukan"] . '"
                                    data-user_rujukan="' . $data[$a]["user_rujukan"] . '"
                                    >
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
