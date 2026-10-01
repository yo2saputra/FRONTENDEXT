<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

class Tmstdistributor extends BaseController
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
        // $this->data['cb_empstacd'] = getDropdownCustomFilter('employee_status', 'emp_sta_cd', 'Status', 2, 4, []); // (key,id,Label,label size, input size, filter)
        // $this->data['cb_tujuan'] = getDropdownPolyclinicCustom('tujuan_registrasi', 'poli', 'Poli', 2, 4); // (key,id,Label,label size, input size, filter)
        //--------------- $this->data['cd_tujuan'] = getDropdownCustomFilter('tujuan_registrasi', 'poli', 'Poli', 2, 4, []); // (key,id,Label,label size, input size, filter)
        // $this->data['cb_jobtitle'] = getDropdownCustomFilterNotIn('job_title_internal', 'job_title_cd', 'Job Title', 2, 4, ['DR']); // (key,id,Label,label size, input size, filter)
        // $this->data['cb_jenisdokter'] = getDropdownCustomFilter('jenis_dokter', 'jenis_dokter', 'Jenis Dokter', 2, 4, []); // (key,id,Label,label size, input size, filter)
        // $this->data['cb_spesialis'] = getDropdownCustomFilter('Spesialis', 'spesialis', 'Spesialis', 2, 4, []); // (key,id,Label,label size, input size, filter)
        $this->data['cb_kategori'] = getDropdownCustomFilter('kategori_distributor', 'kategori', 'Kategori', 2, 4, []); // (key,id,Label,label size, input size, filter)
        return view('tmstdistributor/index', $this->data);
    }

    public function apiDataGetAll()
    {

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/tmstdistributor/getall";

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
                    <table id="example4" class="table table-sm table-bordered table-striped">
                    <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Nama Kontak</th>
                                <th>Nomor Kontak</th>
                                <th>Inactive</th>
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
                            <tr id="addMdlBarang" data-id="' . $data[$a]["kodedistributor"] . '">
                                <td >' . $no . '</td>
                                <td >' . $data[$a]["nama"] . '</td>
                                <td >' . $data[$a]["namakontak"] . '</td>
                                <td >' . $data[$a]["nomorkontak"] . '</td>
                                <td ><span class="right badge ' . ($data[$a]['inactive'] == '1' ? 'badge-info' : 'badge-warning') . '">' . ($data[$a]["inactive"] == '1' ? "Aktif" : "Tidak Aktif") . '</span></td>
                                <td class="text-right">
                                    
                                    <div class="btn-group">
                                    <a data-toggle="tooltip" data-placement="top" title="View" class="btn btn-sm btn-info view ' . ($this->session->get("flag_view") === 1 ? "" : "d-none") . '" data-kodedistributor="' . $data[$a]["kodedistributor"] . '"><i class="fas fa-eye"></i></a>
                                    <a data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-sm btn-primary edit ' . ($this->session->get("flag_update") === 1 ? "" : "d-none") . '" data-kodedistributor="' . $data[$a]["kodedistributor"] . '"><i class="fas fa-tags"></i></a>
                                    <a data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-sm btn-danger delete ' . ($this->session->get("flag_delete") === 1 ? "" : "d-none") . '" data-kodedistributor="' . $data[$a]["kodedistributor"] . '"><i class="fas fa-trash"></i></a>
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
                        { text: "Excel",extend: "excel", className: "btn-sm btn-primary ' . ($this->session->get("flag_export") === 1 ? "" : "d-none") . '", exportOptions: {columns: [ 0, 1, 2, 3, 4]} },
                        { text: "Cetak",extend: "print", className: "btn-sm btn-info ' . ($this->session->get("flag_print") === 1 ? "" : "d-none") . '", exportOptions: {columns: [ 0, 1, 2, 3, 4]} }
                           
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
            $kodedistributor = $this->request->getVar('kodedistributor');

            // helper curl request
            helper(['restclient']);

            // endpoint
            $url = "$this->server/tmstemployee/delete/$kodedistributor";

            // client request
            $response = akses_restapi('DELETE', $url, []);
            $data['response_data'] = json_decode($response, true);

            $msg = [
                'success' => "Data dengan nama $kodedistributor berhasil dihapus"
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
                    // 'kodedistributor' => [
                    //     'label' => 'Distribute',
                    //     'rules' => 'required',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ],
                    'nama' => [
                        'label' => 'Nama',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'kategori' => [
                        'label' => 'Kategori',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'alamat' => [
                        'label' => 'Alamat',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'kodekota' => [
                        'label' => 'Kota',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'kodenegara' => [
                        'label' => 'Negara',
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
                    'npwp' => [
                        'label' => 'NPWP',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'namasebutan' => [
                        'label' => 'Nama Sebutan',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'tglterdaftar' => [
                        'label' => 'Tgl Terdaftar',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ]
                    // ,
                    // 'inactive' => [
                    //     'label' => 'Status',
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
                            // 'kodedistributor' => $validation->getError('kodedistributor'),
                            'nama' => $validation->getError('nama'),
                            'kategori' => $validation->getError('kategori'),
                            'namakontak' => $validation->getError('namakontak'),
                            'nomorkontak' => $validation->getError('nomorkontak'),
                            'alamat' => $validation->getError('alamat'),
                            'kodekota' => $validation->getError('kodekota'),
                            'kodenegara' => $validation->getError('kodenegara'),
                            'email' => $validation->getError('email'),
                            'npwp' => $validation->getError('npwp'),
                            'namasebutan' => $validation->getError('namasebutan'),
                            'tglterdaftar' => $validation->getError('tglterdaftar'),
                            'inactive' => $validation->getError('inactive')
                        ]
                    ];
                } else {

                    if ($this->request->getVar('action') == 'Add') {

                        // helper curl request
                        helper(['restclient']);

                        // endpoint
                        $url = "$this->server/tmstdistributor/insert";

                        // form params
                        $data = [
                            "kodedistributor" => NULL,
                            "nama" => $this->request->getVar('nama'),
                            "kategori" => $this->request->getVar('kategori'),
                            "namakontak" => $this->request->getVar('namakontak'),
                            "nomorkontak" => $this->request->getVar('nomorkontak'),
                            "alamat" => $this->request->getVar('alamat'),
                            "kodekota" => $this->request->getVar('kodekota'),
                            "kodenegara" => $this->request->getVar('kodenegara'),
                            "email" => $this->request->getVar('email'),
                            "npwp" => $this->request->getVar('npwp'),
                            "namasebutan" => $this->request->getVar('namasebutan'),
                            "tglterdaftar" => $this->request->getVar('tglterdaftar'),
                            "inactive" => ($this->request->getVar('inactive') == FALSE) ? 0 : 1,
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
                        $url = "$this->server/tmstdistributor/update";

                        // form params
                        $data = [
                            "kodedistributor" => $this->request->getVar('kodedistributor'),
                            "nama" => $this->request->getVar('nama'),
                            "kategori" => $this->request->getVar('kategori'),
                            "namakontak" => $this->request->getVar('namakontak'),
                            "nomorkontak" => $this->request->getVar('nomorkontak'),
                            "alamat" => $this->request->getVar('alamat'),
                            "kodekota" => $this->request->getVar('kodekota'),
                            "kodenegara" => $this->request->getVar('kodenegara'),
                            "email" => $this->request->getVar('email'),
                            "npwp" => $this->request->getVar('npwp'),
                            "namasebutan" => $this->request->getVar('namasebutan'),
                            "tglterdaftar" => $this->request->getVar('tglterdaftar'),
                            "inactive" => ($this->request->getVar('inactive') == FALSE) ? 0 : 1,

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

        $kodedistributor = $this->request->getVar('kodedistributor');

        if ($kodedistributor) {

            // helper curl request
            helper(['restclient']);

            // end point
            $url = "$this->server/tmstdistributor/getby/$kodedistributor";

            // client request
            $response = akses_restapi('GET', $url, []);
            $data['response_data'] = json_decode($response, true);

            $msg = [
                'data' => [
                    'kodedistributor' => $data["response_data"][0]["kodedistributor"],
                    'nama' => $data["response_data"][0]["nama"],
                    'kategori' => $data["response_data"][0]["kategori"],
                    'namakontak' => $data["response_data"][0]["namakontak"],
                    'nomorkontak' => $data["response_data"][0]["nomorkontak"],
                    'alamat' => $data["response_data"][0]["alamat"],
                    'kodekota' => $data["response_data"][0]["kodekota"],
                    'kodenegara' => $data["response_data"][0]["kodenegara"],
                    'email' => $data["response_data"][0]["email"],
                    'npwp' => $data["response_data"][0]["npwp"],
                    'namasebutan' => $data["response_data"][0]["namasebutan"],
                    'tglterdaftar' => $data["response_data"][0]["tglterdaftar"],
                    'inactive' => $data["response_data"][0]["inactive"],
                ]
            ];

            echo json_encode($msg);
        }
        // } else {
        //     exit('Maaf tidak dapat diproses!');
        // }
    }

    function fetchSingleDataPrint($kodedistributor)
    {

        if ($kodedistributor) {

            // helper curl request
            helper(['restclient']);

            // end point
            $url = "$this->server/tmstdistributor/getby/$kodedistributor";

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
