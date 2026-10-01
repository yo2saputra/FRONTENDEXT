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
        $this->data['cb_gender'] = getDropdown2('gender', 'Jenis Kelamin', 2, 2); // (id,Label,label size, input size)
        // $this->data['cb_gender'] = getDropdown('gender', 'Jenis Kelamin', 4, 8); // (id,Label,label size, input size)

        $this->data['cb_id_typ'] = getDropdown2('id_typ', 'Jenis Identitas Pasien', 2, 2); // (id,Label,label size, input size)
        // $this->data['cb_id_typ'] = getDropdown('id_typ', 'Jenis Identitas Pasien', 4, 8); // (id,Label,label size, input size)

        $this->data['cb_job_title_cd'] = getDropdown2('job_title_cd', 'Pekerjaan', 1, 3); // (id,Label,label size, input size)
        // $this->data['cb_job_title_cd'] = getDropdown('job_title_cd', 'Pekerjaan', 4, 8); // (id,Label,label size, input size)

        $this->data['cb_religion'] = getDropdown2('religion', 'Agama', 1, 3); // (id,Label,label size, input size)
        //$this->data['cb_religion'] = getDropdown('religion', 'Agama', 4, 8); // (id,Label,label size, input size)

        $this->data['cb_birthplace'] = getDropdownKotaCustomFilter('birthplace', 'birthplace', 'Tempat Lahir', 2, 2, []); // (id, input size)$key, $name, $label, $label_size, $input_size, $filter

        $this->data['cb_city_cd'] = getDropdownKotaCustomFilter('city_cd', 'city_cd', 'Kota', 2, 4, []); // (id, input size)$key, $name, $label, $label_size, $input_size, $filter

        $this->data['cb_married_sta_id'] = getDropdown2('married_sta_id', 'Status', 1, 3); // (id,Label,label size, input size)
        // $this->data['cb_married_sta_id'] = getDropdown('married_sta_id', 'Status', 4, 8); // (id,Label,label size, input size)

        $this->data['cb_source_info'] = getDropdown2('source_info', 'Source Info', 1, 3); // (id,Label,label size, input size)
        // $this->data['cb_source_info'] = getDropdown('source_info', 'Source Info', 4, 8); // (id,Label,label size, input size)

        $this->data['cb_education'] = getDropdown2('education', 'Pendidikan', 1, 3); // (id,Label,label size, input size)
        // $this->data['cb_education'] = getDropdown('education', 'Pendidikan', 4, 8); // (id,Label,label size, input size)

        // $this->data['cb_family_relation'] = getDropdown2('family_relation', 'Hubungan dengan Pasien', 4, 8); // (id,Label,label size, input size)
        $this->data['cb_family_relation'] = getDropdown('family_relation', 'Hubungan dengan Pasien', 2, 10); // (id,Label,label size, input size)

        $this->data['cb_title_cd'] = getDropdown2('title_cd', 'Title', 2, 2); // (id,Label,label size, input size)

        $this->data['cb_country'] = getDropdown2('country', '', 2, 2); // (id,Label,label size, input size)

        $this->data['cb_country_cd'] = getDropdown2('country_cd', 'Kode Negara', 2, 2); // (id,Label,label size, input size)

        return view('patient/index', $this->data);
    }

    public function apiDataGetAll()
    {
        // helper curl request
        helper(['restclient']);
        // endpoint
        $url = "$this->server/pasien/getall";
        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);

        return $data['response_data'];
    }

    public function fetchAll()
    {
        // if ($this->request->isAJAX()) {
        $output = '';
        $data =  $this->apiDataGetAll();
        $output .= '
            
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
                        </tr>';
        } else {
            for ($a = 0; $a < count($data); $a++) {
                $output .= '  
                    <tr id="addMdlBarang" data-id="' . $data[$a]["patient_no"] . '">
                        <td >' . ($data[$a]["flag_booking"] == 1 ? '' : $data[$a]["patient_no"]) . '</td>
                        <td >' . $data[$a]["fullname"] . '</td>
                        <td >' . $data[$a]["id_no"] . '</td>
                        <td >' . $data[$a]["gender"] . '</td>
                        <td >' . $data[$a]["addr"] . '</td>
                        <td >' . $data[$a]["mobile_no"] . '</td>
                        <td >' . date('d/m/Y', strtotime($data[$a]["birth_dt"])) . '</td>
                        
                        <td class="text-center">
                        <div class="btn-group">
                        <a href="https://wa.me/' . preg_replace("/0/", $data[$a]["country_cd"], $data[$a]["mobile_no"], 1) . '" target="_blank" data-toggle="tooltip" data-placement="top" title="Chat" class="btn btn-sm btn-success chat" data-patient_no="' . $data[$a]["patient_no"] . '"><i class="fas fa-comment-dots"></i></a>
                        <a data-toggle="tooltip" data-placement="top" title="View" class="btn btn-sm btn-info view ' . ($this->session->get("flag_view") === 1 ? "" : "d-none") . '" data-patient_no="' . $data[$a]["patient_no"] . '"><i class="fas fa-eye"></i></a>
                        <a data-toggle="tooltip" data-placement="top" title="Add" class="btn btn-sm btn-success insertinto ' . ($data[$a]["flag_booking"] === 1 ? "" : "d-none") . '" data-patient_no="' . $data[$a]["patient_no"] . '"><i class="fas fa-check"></i></a>
                        <a data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-sm btn-primary edit ' . ($this->session->get("flag_update") === 1 ? "" : "d-none") . '" data-patient_no="' . $data[$a]["patient_no"] . '"><i class="fas fa-tags"></i></a>
                        <a data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-sm btn-danger delete ' . ($this->session->get("flag_delete") === 1 ? "" : "d-none") . '" data-patient_no="' . $data[$a]["patient_no"] . '"><i class="fas fa-trash"></i></a>
                        </div>
                        
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
                        targets: 7
                    }],
                    "dom": "Bfplit",
                    "buttons": [
                        "copy", "csv", "excel", "pdf", "print"
                    ],
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                });
            });
            </script>
            <script>
            $(function() {
                $("#example4").DataTable({
                    // "responsive": true, "lengthChange": false, "autoWidth": false,
                    columnDefs: [{
                        orderable: false,
                        targets: 7
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
                                name:"add_record"
                            }
                        },
                        {
                            text: "Cetak",
                            action: function(e, dt, node, config) {
                                // alert("Button activated");
                                window.open("' . base_url('/patient/prints') . '");
                            },
                            attr: {
                                // id: "add_record",
                                style: "background-color:#56b746;' . ($this->session->get("flag_insert") === 1 ? "" : "display:none;") . '",
                                // name:"add_record"
                            }
                        },
                        { text: "Excel",extend: "excel", className: "btn-sm btn-primary ' . ($this->session->get("flag_export") === 1 ? "" : "d-none") . '", exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6]} },
                        { text: "Cetak",extend: "print", className: "btn-sm btn-info ' . ($this->session->get("flag_print") === 1 ? "" : "d-none") . '", exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6]} }
                    
                           
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
        // } else {
        //     exit('Maaf tidak dapat diproses!');
        // }
    }


    public function delete()
    {
        if ($this->request->isAJAX()) {
            $patient_no = $this->request->getVar('patient_no');

            // helper curl request
            helper(['restclient']);

            if ($this->request->getVar('flag_booking') == FALSE) {
                // endpoint
                $url = "$this->server/pasien/delete/$patient_no";
                // client request
            } else {
                // endpoint
                $url = "$this->server/tmstbooking/delete/$patient_no";
                // client request
            }

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
                    'addr_domisili' => [
                        'label' => 'Alamat Domisili',
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
                    'job_lain' => [
                        'label' => 'Pekerjaan',
                        'rules' => $this->request->getVar('job_title_cd') === '89' ? 'required' : 'permit_empty',
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
                    // 'city_cd' => [
                    //     'label' => 'Kota',
                    //     'rules' => 'required',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ],
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
                    'source_info_lain' => [
                        'label' => 'Source Info Lainnya',
                        'rules' => $this->request->getVar('source_info') === 'lainnya' ? 'required' : 'permit_empty',
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
                    // 'postcode' => [
                    //     'label' => 'Kode Pos',
                    //     'rules' => 'required',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ],
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
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'family_relation_lain' => [
                        'label' => 'Hubungan Dengan Pasien',
                        'rules' => $this->request->getVar('family_relation') === 'lainnya' ? 'required' : 'permit_empty',
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
                            'addr_domisili' => $validation->getError('addr_domisili'),
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
                            'family_relation' => $validation->getError('family_relation'),
                            'job_lain' => $validation->getError('job_lain'),
                            'family_relation_lain' => $validation->getError('family_relation_lain'),
                            'flag_booking' => $validation->getError('flag_booking'),

                        ]
                    ];
                } else {

                    if ($this->request->getVar('action') == 'Add') {

                        // helper curl request
                        helper(['restclient']);

                        if ($this->request->getVar('flag_booking') == FALSE) {
                            // endpoint
                            $url = "$this->server/pasien/insert";

                            // form params
                            $data = [
                                "fullname" => $this->request->getVar('fullname'),
                                "id_no" => $this->request->getVar('id_no'),
                                "gender" => $this->request->getVar('gender'),
                                "addr" => $this->request->getVar('addr'),
                                "addr_domisili" => $this->request->getVar('addr_domisili'),
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
                                "postcode" => $this->request->getVar('postcode'),
                                "education" => $this->request->getVar('education'),
                                "family_name" => $this->request->getVar('family_name'),
                                "family_addr" => $this->request->getVar('family_addr'),
                                "family_handphone" => $this->request->getVar('family_handphone'),
                                "family_relation" => $this->request->getVar('family_relation'),
                                "register_dt" => date('Y-m-d'),
                                "job_lain" => $this->request->getVar('job_lain'),
                                "family_relation_lain" => $this->request->getVar('family_relation_lain'),
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
                                "title_cd" => $this->request->getVar('title_cd')
                            ];
                        } else {
                            // endpoint
                            $url = "$this->server/tmstbooking/insert";

                            // form params
                            $data = [
                                "fullname" => $this->request->getVar('fullname'),
                                "id_no" => $this->request->getVar('id_no'),
                                "gender" => $this->request->getVar('gender'),
                                "addr" => $this->request->getVar('addr'),
                                "addr_domisili" => $this->request->getVar('addr_domisili'),
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
                                "postcode" => $this->request->getVar('postcode'),
                                "education" => $this->request->getVar('education'),
                                "family_name" => $this->request->getVar('family_name'),
                                "family_addr" => $this->request->getVar('family_addr'),
                                "family_handphone" => $this->request->getVar('family_handphone'),
                                "family_relation" => $this->request->getVar('family_relation'),
                                "register_dt" => date('Y-m-d'),
                                "job_lain" => $this->request->getVar('job_lain'),
                                "family_relation_lain" => $this->request->getVar('family_relation_lain'),
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
                                "title_cd" => $this->request->getVar('title_cd')

                            ];
                        }


                        // client request
                        $response = akses_restapi('POST', $url, $data);

                        $msg = [
                            'success' => 'data berhasil di create!'
                        ];
                    }

                    if ($this->request->getVar('action') == 'Edit') {

                        // helper curl request
                        helper(['restclient']);

                        if ($this->request->getVar('flag_booking') == FALSE && $this->request->getVar('flag_booking_old') == 1) {
                            // endpoint
                            $url = "$this->server/pasien/insertdelete";

                            // form params
                            $data = [
                                "patient_no" => $this->request->getVar('patient_no'),
                                "fullname" => $this->request->getVar('fullname'),
                                "id_no" => $this->request->getVar('id_no'),
                                "gender" => $this->request->getVar('gender'),
                                "addr" => $this->request->getVar('addr'),
                                "addr_domisili" => $this->request->getVar('addr_domisili'),
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
                                "postcode" => $this->request->getVar('postcode'),
                                "education" => $this->request->getVar('education'),
                                "family_name" => $this->request->getVar('family_name'),
                                "family_addr" => $this->request->getVar('family_addr'),
                                "family_handphone" => $this->request->getVar('family_handphone'),
                                "family_relation" => $this->request->getVar('family_relation'),
                                "job_lain" => $this->request->getVar('job_lain'),
                                "family_relation_lain" => $this->request->getVar('family_relation_lain'),
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
                                "title_cd" => $this->request->getVar('title_cd')
                            ];

                            // client request
                            $response = akses_restapi('POST', $url, $data);
                        } elseif ($this->request->getVar('flag_booking') == FALSE) {
                            // endpoint
                            $url = "$this->server/pasien/update";

                            // form params
                            $data = [
                                "patient_no" => $this->request->getVar('patient_no'),
                                "fullname" => $this->request->getVar('fullname'),
                                "id_no" => $this->request->getVar('id_no'),
                                "gender" => $this->request->getVar('gender'),
                                "addr" => $this->request->getVar('addr'),
                                "addr_domisili" => $this->request->getVar('addr_domisili'),
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
                                "postcode" => $this->request->getVar('postcode'),
                                "education" => $this->request->getVar('education'),
                                "family_name" => $this->request->getVar('family_name'),
                                "family_addr" => $this->request->getVar('family_addr'),
                                "family_handphone" => $this->request->getVar('family_handphone'),
                                "family_relation" => $this->request->getVar('family_relation'),
                                "job_lain" => $this->request->getVar('job_lain'),
                                "family_relation_lain" => $this->request->getVar('family_relation_lain'),
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
                                "title_cd" => $this->request->getVar('title_cd')
                            ];

                            // client request
                            $response = akses_restapi('PUT', $url, $data);
                        } else {
                            // endpoint
                            $url = "$this->server/tmstbooking/update";

                            // form params
                            $data = [
                                "patient_no" => $this->request->getVar('patient_no'),
                                "fullname" => $this->request->getVar('fullname'),
                                "id_no" => $this->request->getVar('id_no'),
                                "gender" => $this->request->getVar('gender'),
                                "addr" => $this->request->getVar('addr'),
                                "addr_domisili" => $this->request->getVar('addr_domisili'),
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
                                "postcode" => $this->request->getVar('postcode'),
                                "education" => $this->request->getVar('education'),
                                "family_name" => $this->request->getVar('family_name'),
                                "family_addr" => $this->request->getVar('family_addr'),
                                "family_handphone" => $this->request->getVar('family_handphone'),
                                "family_relation" => $this->request->getVar('family_relation'),
                                "job_lain" => $this->request->getVar('job_lain'),
                                "family_relation_lain" => $this->request->getVar('family_relation_lain'),
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
                                "title_cd" => $this->request->getVar('title_cd')
                            ];

                            // client request
                            $response = akses_restapi('PUT', $url, $data);
                        }



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
                $url = "$this->server/pasien/getby/$patient_no";

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
                        'addr_domisili' => $data["response_data"][0]["addr_domisili"],
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
                        'family_relation' => $data["response_data"][0]["family_relation"],
                        'job_lain' => $data["response_data"][0]["job_lain"],
                        'family_relation_lain' => $data["response_data"][0]["family_relation_lain"],
                        'flag_booking' => $data["response_data"][0]["flag_booking"],
                        'flag_wna' => $data["response_data"][0]["flag_wna"],
                        'country' => $data["response_data"][0]["country"],
                        'country_cd' => $data["response_data"][0]["country_cd"],
                        'provinsi_umum' => $data["response_data"][0]["provinsi_umum"],
                        'kota_umum' => $data["response_data"][0]["kota_umum"],
                        'kecamatan_umum' => $data["response_data"][0]["kecamatan_umum"],
                        'kelurahan_umum' => $data["response_data"][0]["kelurahan_umum"],
                        'provinsi_domisili' => $data["response_data"][0]["provinsi_domisili"],
                        'kota_domisili' => $data["response_data"][0]["kota_domisili"],
                        'kecamatan_domisili' => $data["response_data"][0]["kecamatan_domisili"],
                        'kelurahan_domisili' => $data["response_data"][0]["kelurahan_domisili"],
                        'postcode_domisili' => $data["response_data"][0]["postcode_domisili"],
                        'provinsi_keluarga' => $data["response_data"][0]["provinsi_keluarga"],
                        'kota_keluarga' => $data["response_data"][0]["kota_keluarga"],
                        'kecamatan_keluarga' => $data["response_data"][0]["kecamatan_keluarga"],
                        'kelurahan_keluarga' => $data["response_data"][0]["kelurahan_keluarga"],
                        'postcode_keluarga' => $data["response_data"][0]["postcode_keluarga"],
                        'title_cd' => $data["response_data"][0]["title_cd"]
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
            $url = "$this->server/pasien/getby/$patient_no";
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

    function fetchAllDataPrint3()
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
        $pdf_format = 'rpt_patient_pdf';

        $this->view_pdf($pdf_name, $pdf_title, $pdf_data, $pdf_paper, $pdf_orientation, $pdf_format);
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

    public function insertinto()
    {
        if ($this->request->isAJAX()) {
            $patient_no = $this->request->getVar('patient_no');

            // helper curl request
            helper(['restclient']);

            // endpoint
            $url = "$this->server/pasien/insertinto/$patient_no";

            // client request
            $response = akses_restapi('PATCH', $url, []);
            $data['response_data'] = json_decode($response, true);

            $msg = [
                'success' => "Data dengan no $patient_no berhasil diubah"
            ];
            echo json_encode($msg);
        }
    }
}
