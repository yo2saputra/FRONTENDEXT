<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

class Tmstitem extends BaseController
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
        $this->data['cb_itemtyp'] = getDropdownCustomFilter('item_typ', 'item_typ', 'Type', 2, 4, []); // (key,id,Label,label size, input size, filter)
        $this->data['cb_itemcatcd'] = getDropdownCustomFilter('item_cat_cd', 'item_cat_cd', 'Category', 2, 4, []); // (key,id,Label,label size, input size, filter)
        $this->data['cb_uombase'] = getDropdownCustomFilter('uom_base', 'uom_base', 'Unit', 2, 4, []); // (key,id,Label,label size, input size, filter)
        return view('tmstitem/index', $this->data);
    }

    public function apiDataGetAll()
    {

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/tmstitem/getall";

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
                                <th>Name</th>
                                <th>Type</th>
                                <th>Unit</th>
                                <th>Barcode</th>
                                <th>Remark</th>
                                <th>Delete</th>
                                <th>Pajak</th>
                                <th>kategori</th>
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
                            <tr id="addMdlBarang" data-id="' . $data[$a]["item_cd"] . '">
                                <td >' . $data[$a]["item_nm"] . '</td>
                                <td >' . $data[$a]["item_typ"] . '</td>
                                <td >' . $data[$a]["uom_base"] . '</td>
                                <td >' . $data[$a]["barcode"] . '</td>
                                <td >' . $data[$a]["remark"] . '</td>
                                <td ><span class="right badge ' . ($data[$a]['deleted'] == 1 ? 'badge-info' : 'badge-warning') . '">' . ($data[$a]["deleted"] == 1 ? "Ya" : "Tidak") . '</td>
                                <td ><span class="right badge ' . ($data[$a]['isvat'] == 1 ? 'badge-info' : 'badge-warning') . '">' . ($data[$a]["isvat"] == 1 ? "Ya" : "Tidak") . '</td>
                                <td >' . $data[$a]["item_cat_cd"] . '</td>
                                <td class="text-right">
                                    
                                    <div class="btn-group">
                                    <a data-toggle="tooltip" data-placement="top" title="View" class="btn btn-sm btn-info view ' . ($this->session->get("flag_view") === 1 ? "" : "d-none") . '" data-item_cd="' . $data[$a]["item_cd"] . '"><i class="fas fa-eye"></i></a>
                                    <a data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-sm btn-primary edit ' . ($this->session->get("flag_update") === 1 ? "" : "d-none") . '" data-item_cd="' . $data[$a]["item_cd"] . '"><i class="fas fa-tags"></i></a>
                                    <a data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-sm btn-danger delete ' . ($this->session->get("flag_delete") === 1 ? "" : "d-none") . '" data-item_cd="' . $data[$a]["item_cd"] . '"><i class="fas fa-trash"></i></a>
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
            $item_cd = $this->request->getVar('item_cd');

            // helper curl request
            helper(['restclient']);

            // endpoint
            $url = "$this->server/tmstitem/delete/$item_cd";

            // client request
            $response = akses_restapi('DELETE', $url, []);
            $data['response_data'] = json_decode($response, true);

            $msg = [
                'success' => "Data dengan nama $item_cd berhasil dihapus"
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
                    'item_nm' => [
                        'label' => 'Item Name',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'uom_base' => [
                        'label' => 'Unit',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    // 'barcode' => [
                    //     'label' => 'Barcode',
                    //     'rules' => '',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ],
                    // 'remark' => [
                    //     'label' => 'Remark',
                    //     'rules' => '',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ],
                    // 'delete' => [
                    //     'label' => 'Deleted',
                    //     'rules' => 'required',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ],
                    // 'isvat' => [
                    //     'label' => 'Pajak',
                    //     'rules' => 'required',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ],
                    'item_typ' => [
                        'label' => 'Item Type',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'item_cat_cd' => [
                        'label' => 'Item Kategori',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ]
                    // ,
                    // 'item_cd' => [
                    //     'label' => 'Item Code',
                    //     'rules' => '',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ]

                ]);
                if (!$valid) {
                    $msg = [
                        'error' => [
                            'item_nm' => $validation->getError('item_nm'),
                            'uom_base' => $validation->getError('uom_base'),
                            'barcode' => $validation->getError('barcode'),
                            'remark' => $validation->getError('remark'),
                            'deleted' => $validation->getError('deleted'),
                            'isvat' => $validation->getError('isvat'),
                            'item_typ' => $validation->getError('item_typ'),
                            'item_cat_cd' => $validation->getError('item_cat_cd'),
                            'item_cd' => $validation->getError('item_cd')
                        ]
                    ];
                } else {

                    if ($this->request->getVar('action') == 'Add') {

                        // helper curl request
                        helper(['restclient']);

                        // endpoint
                        $url = "$this->server/tmstitem/insert";

                        // form params
                        $data = [
                            "item_nm" => $this->request->getVar('item_nm'),
                            "uom_base" => $this->request->getVar('uom_base'),
                            "barcode" => $this->request->getVar('barcode'),
                            "remark" => $this->request->getVar('remark'),
                            "deleted" => ($this->request->getVar('deleted') == FALSE) ? 0 : 1,
                            "isvat" => ($this->request->getVar('isvat') == FALSE) ? 0 : 1,
                            "item_typ" => $this->request->getVar('item_typ'),
                            "item_cat_cd" => $this->request->getVar('item_cat_cd'),
                            "item_cd" => NULL

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
                        $url = "$this->server/tmstitem/update";

                        // form params
                        $data = [
                            "item_nm" => $this->request->getVar('item_nm'),
                            "uom_base" => $this->request->getVar('uom_base'),
                            "barcode" => $this->request->getVar('barcode'),
                            "remark" => $this->request->getVar('remark'),
                            "deleted" => ($this->request->getVar('deleted') == FALSE) ? 0 : 1,
                            "isvat" => ($this->request->getVar('isvat') == FALSE) ? 0 : 1,
                            "item_typ" => $this->request->getVar('item_typ'),
                            "item_cat_cd" => $this->request->getVar('item_cat_cd'),
                            "item_cd" => $this->request->getVar('item_cd')
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

            $item_cd = $this->request->getVar('item_cd');

            if ($item_cd) {

                // helper curl request
                helper(['restclient']);

                // end point
                $url = "$this->server/tmstitem/getby/$item_cd";

                // client request
                $response = akses_restapi('GET', $url, []);
                $data['response_data'] = json_decode($response, true);

                $msg = [
                    'data' => [
                        'item_nm' => $data["response_data"][0]["item_nm"],
                        'uom_base' => $data["response_data"][0]["uom_base"],
                        'barcode' => $data["response_data"][0]["barcode"],
                        'remark' => $data["response_data"][0]["remark"],
                        'deleted' => $data["response_data"][0]["deleted"],
                        'isvat' => $data["response_data"][0]["isvat"],
                        'unitprice' => $data["response_data"][0]["unitprice"],
                        'item_typ' => $data["response_data"][0]["item_typ"],
                        'item_cat_cd' => $data["response_data"][0]["item_cat_cd"],
                        'item_cd' => $data["response_data"][0]["item_cd"]
                    ]
                ];

                echo json_encode($msg);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    function fetchSingleDataPrint($item_cd)
    {

        if ($item_cd) {

            // helper curl request
            helper(['restclient']);

            // end point
            $url = "$this->server/tmstitem/getby/$item_cd";

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
