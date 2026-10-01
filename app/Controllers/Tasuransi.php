<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

class Tasuransi extends BaseController
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
        // $this->data['cb_asuransi'] = getDropdownAsuransiCustomFilter('asr_cd', 'asr_cd', 'Asuransi Code', 2, 4, []); // (key,id,Label,label size, input size, filter)
        return view('asuransi/index', $this->data);
    }

    public function apiDataGetAll()
    {

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/tmstasuransi/getall";

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
                                <th>Asuransi Code</th>
                                <th>Name</th>
                                <th>Perjanjian Date</th>
                                <th>Efektif Date</th>
                                <th>PIC Name</th>
                                <th>PIC Phone</th>
                                <th>PIC Email</th>
                                <th>PIC Address</th>
                                <th>Deleted</th>
                                <th>Cashless</th>
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
                                <td ></td>
                                <td ></td>
                            </tr>';
            } else {
                for ($a = 0; $a < count($data); $a++) {
                    $output .= '  
                            <tr id="addMdlBarang" data-id="' . $data[$a]["asr_cd"] . '">
                                <td >' . $data[$a]["asr_cd"] . '</td>
                                <td >' . $data[$a]["asr_nm"] . '</td>
                                <td >' . date('d/m/Y', strtotime($data[$a]["perjanjian_dt"])) . '</td>
                                <td >' . date('d/m/Y', strtotime($data[$a]["efektif_dt"])) . '</td>
                                <td >' . $data[$a]["pic_nm"] . '</td>
                                <td >' . $data[$a]["pic_mobile_no"] . '</td>
                                <td >' . $data[$a]["pic_email"] . '</td>
                                <td >' . $data[$a]["pic_addr"] . '</td>
                                <td ><span class="right badge ' . ($data[$a]['deleted'] == 1 ? 'badge-info' : 'badge-warning') . '">' . ($data[$a]["deleted"] == 1 ? "Ya" : "Tidak") . '</span></td>
                                <td ><span class="right badge ' . ($data[$a]['cashless'] == 1 ? 'badge-info' : 'badge-warning') . '">' . ($data[$a]["cashless"] == 1 ? "Ya" : "Tidak") . '</span></td>
                                <td class="text-right">
                                    <div class="btn-group">
                                    <a data-toggle="tooltip" data-placement="top" title="View" class="btn btn-sm btn-info view ' . ($this->session->get("flag_view") === 1 ? "" : "d-none") . '" data-asr_cd="' . $data[$a]["asr_cd"] . '"><i class="fas fa-eye"></i></a>
                                    <a data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-sm btn-primary edit ' . ($this->session->get("flag_update") === 1 ? "" : "d-none") . '" data-asr_cd="' . $data[$a]["asr_cd"] . '"><i class="fas fa-tags"></i></a>
                                    <a data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-sm btn-danger delete ' . ($this->session->get("flag_delete") === 1 ? "" : "d-none") . '" data-asr_cd="' . $data[$a]["asr_cd"] . '"><i class="fas fa-trash"></i></a>
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
            $asr_cd = $this->request->getVar('asr_cd');

            // helper curl request
            helper(['restclient']);

            // endpoint
            $url = "$this->server/tmstasuransi/delete/$asr_cd";

            // client request
            $response = akses_restapi('DELETE', $url, []);
            $data['response_data'] = json_decode($response, true);

            $msg = [
                'success' => "Data dengan nama $asr_cd berhasil dihapus"
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
                    // 'asr_cd' => [
                    //     'label' => 'asr_cd',
                    //     'rules' => 'required',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ],
                    'asr_nm' => [
                        'label' => 'Asuransi Name',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'perjanjian_dt' => [
                        'label' => 'Perjanjian Date',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'efektif_dt' => [
                        'label' => 'Efektif Date',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'pic_nm' => [
                        'label' => 'PIC Name',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'pic_mobile_no' => [
                        'label' => 'PIC Phone',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'pic_email' => [
                        'label' => 'PIC Email',
                        'rules' => 'required|valid_email',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'pic_addr' => [
                        'label' => 'PIC Address',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    // ,
                    // 'asr_cd' => [
                    //     'label' => 'Item CD',
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
                            // 'asr_cd' => $validation->getError('asr_cd'),
                            'asr_nm' => $validation->getError('asr_nm'),
                            'perjanjian_dt' => $validation->getError('perjanjian_dt'),
                            'efektif_dt' => $validation->getError('efektif_dt'),
                            'pic_nm' => $validation->getError('pic_nm'),
                            'pic_mobile_no' => $validation->getError('pic_mobile_no'),
                            'pic_email' => $validation->getError('pic_email'),
                            'pic_addr' => $validation->getError('pic_addr'),


                        ]
                    ];
                } else {

                    if ($this->request->getVar('action') == 'Add') {

                        // helper curl request
                        helper(['restclient']);

                        // endpoint
                        $url = "$this->server/tmstasuransi/insert";

                        // form params
                        $data = [
                            // "asr_cd" => $this->request->getVar('asr_cd'),
                            "asr_nm" => $this->request->getVar('asr_nm'),
                            "perjanjian_dt" => date('Y-m-d', strtotime($this->request->getVar('perjanjian_dt'))),
                            "efektif_dt" => date('Y-m-d', strtotime($this->request->getVar('efektif_dt'))),
                            "pic_nm" => $this->request->getVar('pic_nm'),
                            "pic_mobile_no" => $this->request->getVar('pic_mobile_no'),
                            "pic_email" => $this->request->getVar('pic_email'),
                            "pic_addr" => $this->request->getVar('pic_addr'),
                            "deleted" => ($this->request->getVar('deleted') == FALSE) ? 0 : 1,
                            "cashless" => ($this->request->getVar('cashless') == FALSE) ? 0 : 1


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
                        $url = "$this->server/tmstasuransi/update";

                        // form params
                        $data = [
                            "asr_cd" => $this->request->getVar('asr_cd'),
                            "asr_nm" => $this->request->getVar('asr_nm'),
                            "perjanjian_dt" => date('Y-m-d', strtotime($this->request->getVar('perjanjian_dt'))),
                            "efektif_dt" => date('Y-m-d', strtotime($this->request->getVar('efektif_dt'))),
                            "pic_nm" => $this->request->getVar('pic_nm'),
                            "pic_mobile_no" => $this->request->getVar('pic_mobile_no'),
                            "pic_email" => $this->request->getVar('pic_email'),
                            "pic_addr" => $this->request->getVar('pic_addr'),
                            "deleted" => ($this->request->getVar('deleted') == FALSE) ? 0 : 1,
                            "cashless" => ($this->request->getVar('cashless') == FALSE) ? 0 : 1

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
        if ($this->request->isAJAX()) {

            $asr_cd = $this->request->getVar('asr_cd');

            if ($asr_cd) {

                // helper curl request
                helper(['restclient']);

                // end point
                $url = "$this->server/tmstasuransi/getby/$asr_cd";

                // client request
                $response = akses_restapi('GET', $url, []);
                $data['response_data'] = json_decode($response, true);

                $msg = [
                    'data' => [
                        'asr_cd' => $data["response_data"][0]["asr_cd"],
                        'asr_nm' => $data["response_data"][0]["asr_nm"],
                        'perjanjian_dt' => date('m/d/Y', strtotime($data["response_data"][0]["perjanjian_dt"])),
                        'efektif_dt' => date('m/d/Y', strtotime($data["response_data"][0]["efektif_dt"])),
                        'pic_nm' => $data["response_data"][0]["pic_nm"],
                        'pic_mobile_no' => $data["response_data"][0]["pic_mobile_no"],
                        'pic_email' => $data["response_data"][0]["pic_email"],
                        'pic_addr' => $data["response_data"][0]["pic_addr"],
                        'deleted' => $data["response_data"][0]["deleted"],
                        'cashless' => $data["response_data"][0]["cashless"],
                    ]
                ];

                echo json_encode($msg);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    function fetchSingleDataPrint($asr_cd)
    {

        if ($asr_cd) {

            // helper curl request
            helper(['restclient']);

            // end point
            $url = "$this->server/tmstasuransi/getby/$asr_cd";

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
