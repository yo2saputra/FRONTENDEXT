<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;
use CodeIgniter\I18n\Time;

class Patient extends BaseController
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
        $this->data['cb_gender'] = getDropdown2('gender', 'Jenis Kelamin', 2, 2);
        $this->data['cb_id_typ'] = getDropdown2('id_typ', 'Jenis Identitas Pasien', 2, 2);
        $this->data['cb_job_title_cd'] = getDropdown2('job_title_cd', 'Pekerjaan', 1, 3);
        $this->data['cb_religion'] = getDropdown2('religion', 'Agama', 1, 3);
        $this->data['cb_birthplace'] = getDropdownKotaCustomFilter('birthplace', 'birthplace', 'Tempat Lahir', 2, 2, []);
        $this->data['cb_city_cd'] = getDropdownKotaCustomFilter('city_cd', 'city_cd', 'Kota', 2, 4, []);
        $this->data['cb_married_sta_id'] = getDropdown2('married_sta_id', 'Status', 1, 3);
        $this->data['cb_source_info'] = getDropdown2('source_info', 'Source Info', 1, 3);
        $this->data['cb_education'] = getDropdown2('education', 'Pendidikan', 1, 3);
        $this->data['cb_family_relation'] = getDropdown('family_relation', 'Hubungan dengan Pasien', 2, 10);
        $this->data['cb_title_cd'] = getDropdown2('title_cd', 'Title', 2, 2);
        $this->data['cb_country'] = getDropdown2('country', '', 2, 2);
        $this->data['cb_country_cd'] = getDropdown2('country_cd', 'Kode Negara', 2, 2);

        return view('patient/index', $this->data);
    }

    public function apiDataGetAll()
    {
        helper(['restclient']);
        $url = "$this->server/pasien/getall";
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);
        return $data['response_data'];
    }

    public function fetchAll()
    {
        $output = '';
        $data = $this->apiDataGetAll();

        $output .= '
            <div class="row mb-2">
                <div class="col-sm-8">
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-secondary filter-btn active" data-filter="all">
                            <i class="fas fa-list"></i> Semua
                        </button>
                        <button class="btn btn-sm btn-warning filter-btn" data-filter="draft">
                            <i class="fas fa-file-alt"></i> Draft
                        </button>
                        <button class="btn btn-sm btn-success filter-btn" data-filter="published">
                            <i class="fas fa-check-circle"></i> Published
                        </button>
                        <button class="btn btn-sm btn-info filter-btn" data-filter="booking">
                            <i class="fas fa-calendar-plus"></i> Booking
                        </button>
                    </div>
                </div>
                <div class="col-sm-4 text-right">
                    <button class="btn btn-sm btn-primary" id="add_record">
                        <i class="fas fa-plus"></i> Tambah Data
                    </button>
                </div>
            </div>
            <table id="example4" class="table table-sm table-hover table-striped">
                <thead>
                    <tr>  
                        <th>Nomor RM</th>
                        <th>Full Name</th>
                        <th>ID No</th>
                        <th>Gender</th>
                        <th>Address</th>
                        <th>Mobile</th>
                        <th>Birth Date</th>
                        <th>Status</th>
                        <th>Sumber</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>';

        if ($data == '' || empty($data)) {
            $output .= '<tr><td colspan="10" class="text-center">Data tidak ditemukan</td></tr>';
        } else {
            foreach ($data as $row) {
                $isDraft = isset($row['is_draft']) && $row['is_draft'] == 1;
                $isBooking = isset($row['flag_booking']) && $row['flag_booking'] == 1;
                $draftClass = $isDraft ? 'draft-row' : '';
                $draftBadge = $isDraft ? '<span class="draft-badge"><i class="fas fa-file-alt"></i> DRAFT</span>' : '';
                $bookingBadge = $isBooking ? '<span class="booking-badge"><i class="fas fa-calendar-plus"></i> BOOKING</span>' : '';
                $patientNo = $isBooking ? '' : $row['patient_no'];
                $sourceLabel = $isBooking ? 'Booking' : 'Pasien';
                $sourceClass = $isBooking ? 'badge-warning' : 'badge-primary';
                $sourceIcon = $isBooking ? 'fa-calendar-plus' : 'fa-user';

                $whatsappUrl = isset($row['mobile_no']) && isset($row['country_cd'])
                    ? 'https://wa.me/' . preg_replace("/^0/", $row['country_cd'], $row['mobile_no'])
                    : '#';

                // Tentukan kelas untuk tombol
                $insertintoClass = $isBooking ? '' : 'd-none';
                $continueDraftClass = $isDraft ? '' : 'd-none';

                $output .= '  
                    <tr class="' . $draftClass . '" data-is-draft="' . ($isDraft ? '1' : '0') . '" data-is-booking="' . ($isBooking ? '1' : '0') . '" data-patient_no="' . $row['patient_no'] . '">
                        <td>' . $patientNo . '</td>
                        <td>' . ($row['fullname'] ?? '') . '</td>
                        <td>' . ($row['id_no'] ?? '') . '</td>
                        <td>' . ($row['gender'] ?? '') . '</td>
                        <td>' . ($row['addr'] ?? '') . '</td>
                        <td>' . ($row['mobile_no'] ?? '') . '</td>
                        <td>' . (isset($row['birth_dt']) && $row['birth_dt'] ? date('d/m/Y', strtotime($row['birth_dt'])) : '') . '</td>
                        <td>
                            ' . $draftBadge . '
                            ' . $bookingBadge . '
                        </td>
                        <td>
                            <span class="badge ' . $sourceClass . '">
                                <i class="fas ' . $sourceIcon . '"></i>
                                ' . $sourceLabel . '
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="' . $whatsappUrl . '" target="_blank" data-toggle="tooltip" data-placement="top" title="Chat" class="btn btn-sm btn-success chat"><i class="fas fa-comment-dots"></i></a>
                                <a data-toggle="tooltip" data-placement="top" title="View" class="btn btn-sm btn-info view" data-patient_no="' . $row['patient_no'] . '" data-is-booking="' . ($isBooking ? '1' : '0') . '"><i class="fas fa-eye"></i></a>
                                <a data-toggle="tooltip" data-placement="top" title="Add ke Pasien" class="btn btn-sm btn-success insertinto ' . $insertintoClass . '" data-patient_no="' . $row['patient_no'] . '">
                                    <i class="fas fa-check"></i>
                                </a>
                                <a data-toggle="tooltip" data-placement="top" title="Lanjutkan Draft" class="btn btn-sm btn-warning continue-draft ' . $continueDraftClass . '" data-patient_no="' . $row['patient_no'] . '"><i class="fas fa-pen"></i></a>
                                <a data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-sm btn-primary edit" data-patient_no="' . $row['patient_no'] . '" data-is-booking="' . ($isBooking ? '1' : '0') . '"><i class="fas fa-tags"></i></a>
                                <a data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-sm btn-danger delete" data-patient_no="' . $row['patient_no'] . '"><i class="fas fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>  
                ';
            }
        }

        $output .= '</tbody></table>
            <script type="text/javascript">
            $(function() {
                var table = $("#example4").DataTable({
                    columnDefs: [
                        { orderable: false, targets: 9 }
                    ],
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    "buttons": [
                        {
                            text: "Tambah Data",
                            action: function(e, dt, node, config) {
                                $("#add_record").click();
                            },
                            attr: {
                                id: "add_record_btn",
                                style: "background-color:#56b746;",
                                name: "add_record"
                            }
                        },
                        {
                            text: "Cetak",
                            action: function(e, dt, node, config) {
                                window.open("' . base_url('/patient/prints') . '");
                            },
                            attr: {
                                style: "background-color:#56b746;"
                            }
                        },
                        { text: "Excel", extend: "excel", className: "btn-sm btn-primary", exportOptions: {columns: [0,1,2,3,4,5,6]} },
                        { text: "Cetak", extend: "print", className: "btn-sm btn-info", exportOptions: {columns: [0,1,2,3,4,5,6]} }
                    ],
                    "oLanguage": {
                        "sSearch": "Cari Data:",
                        "sInfoEmpty": "Tidak ada data",
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
                });
                
                // Filter buttons
                $(".filter-btn").on("click", function() {
                    var filter = $(this).data("filter");
                    $(".filter-btn").removeClass("active");
                    $(this).addClass("active");
                    
                    // Reset semua filter terlebih dahulu
                    table.column(7).search("").draw();
                    table.column(8).search("").draw();
                    
                    if (filter === "draft") {
                        table.column(7).search("DRAFT", true, false).draw();
                    } else if (filter === "published") {
                        table.column(8).search("Pasien", true, false).draw();
                    } else if (filter === "booking") {
                        table.column(7).search("BOOKING", true, false).draw();
                    }
                    // all = tidak ada filter
                });
            });
            </script>
            <style>
                .draft-row { background-color: #fff3cd !important; }
                .draft-badge {
                    background-color: #ffc107;
                    color: #212529;
                    padding: 2px 8px;
                    border-radius: 12px;
                    font-size: 10px;
                    font-weight: bold;
                    display: inline-block;
                }
                .booking-badge {
                    background-color: #17a2b8;
                    color: #fff;
                    padding: 2px 8px;
                    border-radius: 12px;
                    font-size: 10px;
                    font-weight: bold;
                    display: inline-block;
                    margin-left: 2px;
                }
                .filter-btn.active {
                    outline: 2px solid #007bff;
                    outline-offset: 2px;
                }
                .d-none {
                    display: none !important;
                }
            </style>
        ';
        echo $output;
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $patient_no = $this->request->getVar('patient_no');
            $flag_booking = $this->request->getVar('flag_booking');

            helper(['restclient']);

            if ($flag_booking == FALSE || $flag_booking == 0 || $flag_booking == '0') {
                $url = "$this->server/pasien/delete/$patient_no";
            } else {
                $url = "$this->server/tmstbooking/delete/$patient_no";
            }

            $response = akses_restapi('DELETE', $url, []);

            $msg = ['success' => "Data $patient_no berhasil dihapus"];
            echo json_encode($msg);
        }
    }

    function action()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getVar('action')) {
                helper(['form', 'url']);

                // Ambil status draft
                $isDraft = $this->request->getVar('is_draft') ? 1 : 0;

                // Jika draft, validasi lebih ringan
                $isRequired = function ($field) use ($isDraft) {
                    return $isDraft ? 'permit_empty' : 'required';
                };

                $validation = \Config\Services::validation();
                $valid = $this->validate([
                    'fullname' => [
                        'label' => 'Nama Lengkap',
                        'rules' => $isRequired('fullname'),
                        'errors' => []
                    ],
                    'id_no' => [
                        'label' => 'ID No',
                        'rules' => $isRequired('id_no'),
                        'errors' => []
                    ],
                    'gender' => [
                        'label' => 'Jenis Kelamin',
                        'rules' => $isRequired('gender'),
                        'errors' => []
                    ],
                    'addr' => [
                        'label' => 'Alamat Lengkap',
                        'rules' => $isRequired('addr'),
                        'errors' => []
                    ],
                    'addr_domisili' => [
                        'label' => 'Alamat Domisili',
                        'rules' => $isRequired('addr_domisili'),
                        'errors' => []
                    ],
                    'mobile_no' => [
                        'label' => 'Mobile No',
                        'rules' => $isRequired('mobile_no'),
                        'errors' => []
                    ],
                    'birth_dt' => [
                        'label' => 'Tanggal Lahir',
                        'rules' => $isRequired('birth_dt'),
                        'errors' => []
                    ],
                    'id_typ' => [
                        'label' => 'Tipe ID',
                        'rules' => $isRequired('id_typ'),
                        'errors' => []
                    ],
                    'job_title_cd' => [
                        'label' => 'Pekerjaan',
                        'rules' => $isRequired('job_title_cd'),
                        'errors' => []
                    ],
                    'religion' => [
                        'label' => 'Agama',
                        'rules' => $isRequired('religion'),
                        'errors' => []
                    ],
                    'married_sta_id' => [
                        'label' => 'Status Pernikahan',
                        'rules' => $isRequired('married_sta_id'),
                        'errors' => []
                    ],
                    'source_info' => [
                        'label' => 'Mengenal Medicelle dari',
                        'rules' => $isRequired('source_info'),
                        'errors' => []
                    ],
                    'birthplace' => [
                        'label' => 'Tempat Lahir',
                        'rules' => $isRequired('birthplace'),
                        'errors' => []
                    ],
                    'education' => [
                        'label' => 'Pendidikan',
                        'rules' => $isRequired('education'),
                        'errors' => []
                    ],
                    'family_name' => [
                        'label' => 'Nama Lengkap Keluarga',
                        'rules' => $isRequired('family_name'),
                        'errors' => []
                    ],
                    'family_addr' => [
                        'label' => 'Alamat Lengkap Keluarga',
                        'rules' => $isRequired('family_addr'),
                        'errors' => []
                    ],
                    'family_handphone' => [
                        'label' => 'No Telpon Keluarga',
                        'rules' => $isRequired('family_handphone'),
                        'errors' => []
                    ],
                    'family_relation' => [
                        'label' => 'Hubungan Dengan Pasien',
                        'rules' => $isRequired('family_relation'),
                        'errors' => []
                    ],
                    'job_lain' => [
                        'label' => 'Pekerjaan Lain',
                        'rules' => $this->request->getVar('job_title_cd') === '89' && !$isDraft ? 'required' : 'permit_empty',
                        'errors' => []
                    ],
                    'source_info_lain' => [
                        'label' => 'Source Info Lainnya',
                        'rules' => $this->request->getVar('source_info') === 'lainnya' && !$isDraft ? 'required' : 'permit_empty',
                        'errors' => []
                    ],
                    'family_relation_lain' => [
                        'label' => 'Hubungan Dengan Pasien Lain',
                        'rules' => $this->request->getVar('family_relation') === 'lainnya' && !$isDraft ? 'required' : 'permit_empty',
                        'errors' => []
                    ]
                ]);

                if (!$valid) {
                    $msg = ['error' => []];
                    foreach ($validation->getErrors() as $key => $error) {
                        $msg['error'][$key] = $error;
                    }
                } else {
                    $data = [
                        "patient_no" => $this->request->getVar('patient_no'),
                        "fullname" => $this->request->getVar('fullname'),
                        "id_no" => $this->request->getVar('id_no'),
                        "gender" => $this->request->getVar('gender'),
                        "addr" => $this->request->getVar('addr'),
                        "addr_domisili" => $this->request->getVar('addr_domisili'),
                        "mobile_no" => $this->request->getVar('mobile_no'),
                        "birth_dt" => $this->request->getVar('birth_dt') ? date('Y-m-d', strtotime($this->request->getVar('birth_dt'))) : null,
                        "id_typ" => $this->request->getVar('id_typ'),
                        "job_title_cd" => $this->request->getVar('job_title_cd'),
                        "religion" => $this->request->getVar('religion'),
                        "city_cd" => $this->request->getVar('city_cd'),
                        "married_sta_id" => $this->request->getVar('married_sta_id'),
                        "source_info" => $this->request->getVar('source_info'),
                        "birthplace" => $this->request->getVar('birthplace'),
                        "postcode" => $this->request->getVar('postcode'),
                        "education" => $this->request->getVar('education'),
                        "family_name" => $this->request->getVar('family_name'),
                        "family_addr" => $this->request->getVar('family_addr'),
                        "family_handphone" => $this->request->getVar('family_handphone'),
                        "family_relation" => $this->request->getVar('family_relation'),
                        "register_dt" => date('Y-m-d'),
                        "job_lain" => $this->request->getVar('job_lain'),
                        "family_relation_lain" => $this->request->getVar('family_relation_lain'),
                        "source_info_lain" => $this->request->getVar('source_info_lain'),
                        "flag_booking" => ($this->request->getVar('flag_booking') == FALSE) ? 0 : 1,
                        "flag_wna" => ($this->request->getVar('flag_wna') == FALSE) ? 0 : 1,
                        "country" => $this->request->getVar('country'),
                        "country_cd" => $this->request->getVar('country_cd'),
                        "provinsi_umum" => $this->request->getVar('provinsi-umum'),
                        "kota_umum" => $this->request->getVar('kabupaten-umum'),
                        "kecamatan_umum" => $this->request->getVar('kecamatan-umum'),
                        "kelurahan_umum" => $this->request->getVar('kelurahan-umum'),
                        "provinsi_domisili" => $this->request->getVar('provinsi-domisili'),
                        "kota_domisili" => $this->request->getVar('kabupaten-domisili'),
                        "kecamatan_domisili" => $this->request->getVar('kecamatan-domisili'),
                        "kelurahan_domisili" => $this->request->getVar('kelurahan-domisili'),
                        "postcode_domisili" => $this->request->getVar('kodepos_domisili'),
                        "provinsi_keluarga" => $this->request->getVar('provinsi-keluarga'),
                        "kota_keluarga" => $this->request->getVar('kabupaten-keluarga'),
                        "kecamatan_keluarga" => $this->request->getVar('kecamatan-keluarga'),
                        "kelurahan_keluarga" => $this->request->getVar('kelurahan-keluarga'),
                        "postcode_keluarga" => $this->request->getVar('kodepos_keluarga'),
                        "title_cd" => $this->request->getVar('title_cd'),
                        "is_draft" => $isDraft
                    ];

                    helper(['restclient']);
                    $action = $this->request->getVar('action');
                    $flag_booking = $this->request->getVar('flag_booking');

                    try {
                        if ($action == 'Add') {
                            if ($flag_booking == FALSE) {
                                $url = "$this->server/pasien/insert";
                            } else {
                                $url = "$this->server/tmstbooking/insert";
                            }
                            $response = akses_restapi('POST', $url, $data);
                            $msg = ['success' => 'Data berhasil disimpan' . ($isDraft ? ' sebagai draft!' : '!')];
                        }

                        if ($action == 'Edit') {
                            // Cek apakah data berasal dari booking atau pasien
                            if ($flag_booking == FALSE) {
                                // Data dari tmst_patient
                                if ($this->request->getVar('flag_booking_old') == 1) {
                                    $url = "$this->server/pasien/insertdelete";
                                } else {
                                    $url = "$this->server/pasien/update";
                                }
                            } else {
                                // Data dari tmst_booking
                                $url = "$this->server/tmstbooking/update";
                            }
                            $response = akses_restapi('PUT', $url, $data);
                            $msg = ['success' => 'Data berhasil diupdate' . ($isDraft ? ' sebagai draft!' : '!')];
                        }
                    } catch (\Exception $e) {
                        $msg = ['error' => ['general' => $e->getMessage()]];
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
            $patient_no = $this->request->getVar('patient_no');
            $is_booking = $this->request->getVar('is_booking');

            if ($patient_no) {
                helper(['restclient']);

                // Tentukan endpoint berdasarkan sumber data
                if ($is_booking == 1) {
                    // Data dari tmst_booking
                    $url = "$this->server/tmstbooking/getby/$patient_no";
                } else {
                    // Data dari tmst_patient
                    $url = "$this->server/pasien/getby/$patient_no";
                }

                $response = akses_restapi('GET', $url, []);
                $data['response_data'] = json_decode($response, true);

                // Cek apakah data ditemukan
                if (empty($data['response_data']) || !isset($data['response_data'][0])) {
                    $msg = ['error' => 'Data tidak ditemukan'];
                    echo json_encode($msg);
                    return;
                }

                $msg = [
                    'data' => [
                        'patient_no' => $data["response_data"][0]["patient_no"] ?? '',
                        'fullname' => $data["response_data"][0]["fullname"] ?? '',
                        'id_no' => $data["response_data"][0]["id_no"] ?? '',
                        'gender' => $data["response_data"][0]["gender"] ?? '',
                        'addr' => $data["response_data"][0]["addr"] ?? '',
                        'addr_domisili' => $data["response_data"][0]["addr_domisili"] ?? '',
                        'mobile_no' => $data["response_data"][0]["mobile_no"] ?? '',
                        'birth_dt' => isset($data["response_data"][0]["birth_dt"]) && $data["response_data"][0]["birth_dt"] ? date('m/d/Y', strtotime($data["response_data"][0]["birth_dt"])) : '',
                        'id_typ' => $data["response_data"][0]["id_typ"] ?? '',
                        'job_title_cd' => $data["response_data"][0]["job_title_cd"] ?? '',
                        'religion' => $data["response_data"][0]["religion"] ?? '',
                        'city_cd' => $data["response_data"][0]["city_cd"] ?? '',
                        'married_sta_id' => $data["response_data"][0]["married_sta_id"] ?? '',
                        'source_info' => $data["response_data"][0]["source_info"] ?? '',
                        'birthplace' => $data["response_data"][0]["birthplace"] ?? '',
                        'postcode' => $data["response_data"][0]["postcode"] ?? '',
                        'education' => $data["response_data"][0]["education"] ?? '',
                        'family_name' => $data["response_data"][0]["family_name"] ?? '',
                        'family_addr' => $data["response_data"][0]["family_addr"] ?? '',
                        'family_handphone' => $data["response_data"][0]["family_handphone"] ?? '',
                        'family_relation' => $data["response_data"][0]["family_relation"] ?? '',
                        'job_lain' => $data["response_data"][0]["job_lain"] ?? '',
                        'family_relation_lain' => $data["response_data"][0]["family_relation_lain"] ?? '',
                        'source_info_lain' => $data["response_data"][0]["source_info_lain"] ?? '',
                        'flag_booking' => $data["response_data"][0]["flag_booking"] ?? 0,
                        'flag_wna' => $data["response_data"][0]["flag_wna"] ?? 0,
                        'country' => $data["response_data"][0]["country"] ?? '',
                        'country_cd' => $data["response_data"][0]["country_cd"] ?? '',
                        'provinsi_umum' => $data["response_data"][0]["provinsi_umum"] ?? '',
                        'kota_umum' => $data["response_data"][0]["kota_umum"] ?? '',
                        'kecamatan_umum' => $data["response_data"][0]["kecamatan_umum"] ?? '',
                        'kelurahan_umum' => $data["response_data"][0]["kelurahan_umum"] ?? '',
                        'provinsi_domisili' => $data["response_data"][0]["provinsi_domisili"] ?? '',
                        'kota_domisili' => $data["response_data"][0]["kota_domisili"] ?? '',
                        'kecamatan_domisili' => $data["response_data"][0]["kecamatan_domisili"] ?? '',
                        'kelurahan_domisili' => $data["response_data"][0]["kelurahan_domisili"] ?? '',
                        'postcode_domisili' => $data["response_data"][0]["postcode_domisili"] ?? '',
                        'provinsi_keluarga' => $data["response_data"][0]["provinsi_keluarga"] ?? '',
                        'kota_keluarga' => $data["response_data"][0]["kota_keluarga"] ?? '',
                        'kecamatan_keluarga' => $data["response_data"][0]["kecamatan_keluarga"] ?? '',
                        'kelurahan_keluarga' => $data["response_data"][0]["kelurahan_keluarga"] ?? '',
                        'postcode_keluarga' => $data["response_data"][0]["postcode_keluarga"] ?? '',
                        'title_cd' => $data["response_data"][0]["title_cd"] ?? '',
                        'is_draft' => $data["response_data"][0]["is_draft"] ?? 0
                    ]
                ];

                echo json_encode($msg);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    public function insertinto()
    {
        if ($this->request->isAJAX()) {
            $patient_no = $this->request->getVar('patient_no');

            if (!$patient_no) {
                $msg = ['error' => 'Patient No tidak ditemukan'];
                echo json_encode($msg);
                return;
            }

            helper(['restclient']);
            $url = "$this->server/pasien/insertinto/$patient_no";
            $response = akses_restapi('PATCH', $url, []);

            $msg = ['success' => "Data dengan no $patient_no berhasil dipindahkan ke pasien"];
            echo json_encode($msg);
        }
    }
}
