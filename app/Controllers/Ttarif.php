<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

class Ttarif extends BaseController
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
        $this->data['cb_itemcd'] = getDropdownObatCustomFilter('obat_cd', 'item_cd', 'Obat', 2, 10, []); // (key,id,Label,label size, input size, filter)
        return view('tarif/index', $this->data);
    }

    public function apiDataGetAll()
    {

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/tmsttarif/getall";

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
                                <th>Item</th>
                                <th>Harga Beli</th>
                                <th>Het</th>
                                <th>From</th>
                                <th>To</th>
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
                            <tr id="addMdlBarang" data-id="' . $data[$a]["item_cd"] . '">
                                <td >' . $data[$a]["item_nm"] . '</td>
                                <td >' . $data[$a]["hargabeli"] . '</td>
                                <td >' . $data[$a]["het"] . '</td>
                                <td >' . date('d/m/Y', strtotime($data[$a]["from_date"])) . '</td>
                                <td >' . date('d/m/Y', strtotime($data[$a]["to_date"])) . '</td>
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
            $url = "$this->server/tmsttarif/delete/$item_cd";

            // client request
            $response = akses_restapi('DELETE', $url, []);
            $data['response_data'] = json_decode($response, true);

            $msg = [
                'success' => "Data dengan nama $item_cd berhasil dihapus"
            ];
            echo json_encode($msg);
        }
    }

    function ubahFormat($nilai)
    {
        // Menghapus titik sebagai pemisah ribuan
        $nilai = str_replace('.', '', $nilai);
        // Mengganti koma dengan titik sebagai pemisah desimal
        $nilai = str_replace(',', '.', $nilai);
        return $nilai;
    }

    // function desimal($angka)
    // {
    //     $angka_baru = str_replace('.', '', substr($angka, 0, strrpos($angka, '.'))) . substr($angka, strrpos($angka, '.'));
    //     return $angka_baru;
    // }

    // function desimal($angka)
    // {
    //     $angka_bersih = str_replace('.', '', $angka); // Menghapus semua titik
    //     $angka_baru = str_replace(',', '.', $angka_bersih); // Mengganti koma dengan titik
    //     return $angka_baru;
    // }

    function desimal($angka)
    {
        $angka_baru = str_replace('.', '', substr($angka, 0, strrpos($angka, '.'))) . substr($angka, strrpos($angka, '.'));
        return $angka_baru;
    }

    function nondesimal($angka)
    {
        $angka_baru = str_replace('.', '', $angka);
        return $angka_baru;
    }

    function action()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getVar('action')) {
                helper(['form', 'url']);

                $validation = \Config\Services::validation();
                $valid = $this->validate([
                    'hargabeli' => [
                        'label' => 'Harga Beli',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    // 'tarif_asr' => [
                    //     'label' => 'Tarif Asuransi',
                    //     'rules' => 'required',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ],
                    'from_date' => [
                        'label' => 'From Date',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'to_date' => [
                        'label' => 'To Date',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'item_cd' => [
                        'label' => 'Item Code',
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
                            'hargabeli' => $validation->getError('hargabeli'),
                            'het' => $validation->getError('het'),
                            'from_date' => $validation->getError('from_date'),
                            'to_date' => $validation->getError('to_date'),
                            'item_cd' => $validation->getError('item_cd'),
                            'ppn' => $validation->getError('ppn'),
                            'hb_sppn' => $validation->getError('hb_sppn'),
                            'diskon_pct' => $validation->getError('diskon_pct'),
                            'diskon_nom' => $validation->getError('diskon_nom'),
                            'hb_sdiskon' => $validation->getError('hb_sdiskon'),
                            'margin_pct' => $validation->getError('margin_pct'),
                            'margin_nom' => $validation->getError('margin_nom'),
                            'harga_jual' => $validation->getError('harga_jual')
                        ]
                    ];
                } else {

                    if ($this->request->getVar('action') == 'Add') {

                        // helper curl request
                        helper(['restclient']);

                        // endpoint
                        $url = "$this->server/tmsttarif/insert";

                        // form params
                        $data = [
                            "hargabeli" => $this->desimal($this->request->getVar('hargabeli')),
                            "het" => $this->desimal($this->request->getVar('het')),
                            "from_date" => date('Y-m-d', strtotime($this->request->getVar('from_date'))),
                            "to_date" => date('Y-m-d', strtotime($this->request->getVar('to_date'))),
                            "item_cd" => $this->request->getVar('item_cd'),
                            "ppn" => $this->request->getVar('ppn'),
                            "hb_sppn" => $this->request->getVar('hb_sppn'),
                            "diskon_pct" => $this->request->getVar('diskon_pct'),
                            "diskon_nom" => $this->request->getVar('diskon_nom'),
                            "hb_sdiskon" => $this->request->getVar('hb_sdiskon'),
                            "margin_pct" => $this->request->getVar('margin_pct'),
                            "margin_nom" => $this->request->getVar('margin_nom'),
                            "harga_jual" => $this->request->getVar('harga_jual')

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
                        $url = "$this->server/tmsttarif/update";

                        // form params
                        $data = [
                            "hargabeli" => $this->desimal($this->request->getVar('hargabeli')),
                            "het" => $this->desimal($this->request->getVar('het')),
                            "from_date" => date('Y-m-d', strtotime($this->request->getVar('from_date'))),
                            "to_date" => date('Y-m-d', strtotime($this->request->getVar('to_date'))),
                            "item_cd" => $this->request->getVar('item_cd'),
                            "ppn" => $this->request->getVar('ppn'),
                            "hb_sppn" => $this->desimal($this->request->getVar('hb_sppn')),
                            "diskon_pct" => $this->request->getVar('diskon_pct'),
                            "diskon_nom" => $this->ubahFormat($this->request->getVar('diskon_nom')),
                            "hb_sdiskon" => $this->desimal($this->request->getVar('hb_sdiskon')),
                            "margin_pct" => $this->request->getVar('margin_pct'),
                            "margin_nom" => $this->ubahFormat($this->request->getVar('margin_nom')),
                            "harga_jual" => $this->ubahFormat($this->request->getVar('harga_jual'))



                            // "hargabeli" => str_replace('.', '', $this->request->getVar('hargabeli')),
                            // "het" => str_replace('.', '', $this->request->getVar('het')),
                            // "from_date" => date('Y-m-d', strtotime($this->request->getVar('from_date'))),
                            // "to_date" => date('Y-m-d', strtotime($this->request->getVar('to_date'))),
                            // "item_cd" => $this->request->getVar('item_cd'),
                            // "ppn" => str_replace('.', '', $this->request->getVar('ppn')),
                            // "hb_sppn" => str_replace('.', '', $this->request->getVar('hb_sppn')),
                            // "diskon_pct" => str_replace('.', '', $this->request->getVar('diskon_pct')),
                            // "diskon_nom" => str_replace('.', '', $this->request->getVar('diskon_nom')),
                            // "hb_sdiskon" => str_replace('.', '', $this->request->getVar('hb_sdiskon')),
                            // "margin_pct" => str_replace('.', '', $this->request->getVar('margin_pct')),
                            // "margin_nom" => str_replace('.', '', $this->request->getVar('margin_nom')),
                            // "harga_jual" => str_replace('.', '', $this->request->getVar('harga_jual'))

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

    function is_decimal($num)
    {
        if (fmod($num, 1) !== 0.0) {
            return true;
        } else {
            return false;
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
                $url = "$this->server/tmsttarif/getby/$item_cd";

                // client request
                $response = akses_restapi('GET', $url, []);
                $data['response_data'] = json_decode($response, true);

                $msg = [
                    'data' => [
                        'hargabeli' => $data["response_data"][0]["hargabeli"],
                        'het' => $data["response_data"][0]["het"],
                        'from_date' => date('m/d/Y', strtotime($data["response_data"][0]["from_date"])),
                        'to_date' => date('m/d/Y', strtotime($data["response_data"][0]["to_date"])),
                        'ppn' => $data["response_data"][0]["ppn"],
                        'hb_sppn' => $data["response_data"][0]["hb_sppn"],
                        'diskon_pct' => $data["response_data"][0]["diskon_pct"],
                        'diskon_nom' => $data["response_data"][0]["diskon_nom"],
                        'hb_sdiskon' => $data["response_data"][0]["hb_sdiskon"],
                        'margin_pct' => $data["response_data"][0]["margin_pct"],
                        'margin_nom' => $data["response_data"][0]["margin_nom"],
                        'harga_jual' => $data["response_data"][0]["harga_jual"],
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
            $url = "$this->server/tmsttarif/getby/$item_cd";

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
