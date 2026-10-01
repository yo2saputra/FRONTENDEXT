<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as excel;

class Tmstroleapproval extends BaseController
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

        $this->data['cb_aktif'] = getDropdownCustom('warehouse_sta_id', 'warehouse_sta_id', 'Status', 2, 4);
        return view('tmstroleapproval/index', $this->data);
    }

    public function apiDataGetAll()
    {

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/tmstroleapproval/getall";

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
                                <th>Kode</th>
                                <th>Warehouse</th>
                                <th>Lokasi</th>
                                <th>Status</th>
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
                            </tr>';
            } else {
                for ($a = 0; $a < count($data); $a++) {
                    $output .= '  
                            <tr id="addMdlBarang" data-id="' . $data[$a]["warehouse_cd"] . '">
                                <td >' . $data[$a]["warehouse_cd"] . '</td>
                                <td >' . $data[$a]["warehouse_nm"] . '</td>
                                <td >' . $data[$a]["lokasi"] . '</td>
                                <td >' . $data[$a]['warehouse_sta_id'] . '</td>
                                <td class="text-center">
                                    
                                    <div class="btn-group">
                                    <a data-toggle="tooltip" data-placement="top" title="View" class="btn btn-sm btn-info view ' . ($this->session->get("flag_view") === 1 ? "" : "d-none") . '" data-warehouse_cd="' . $data[$a]["warehouse_cd"] . '"><i class="fas fa-eye"></i></a>
                                    <a data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-sm btn-primary edit ' . ($this->session->get("flag_update") === 1 ? "" : "d-none") . '" data-warehouse_cd="' . $data[$a]["warehouse_cd"] . '"><i class="fas fa-tags"></i></a>
                                    <a data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-sm btn-danger delete ' . ($this->session->get("flag_delete") === 1 ? "" : "d-none") . '" data-warehouse_cd="' . $data[$a]["warehouse_cd"] . '"><i class="fas fa-trash"></i></a>
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
                        targets: 4
                    }],
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    // "columns": [
                    //   { "width": "10%" }, null, null, null, nuul, null
                    // ],
                    "buttons": [{
                            text: "Tambah",
                            action: function(e, dt, node, config) {
                                // alert("Button activated");
                            },
                            attr: {
                                id: "add_record",
                                style: "background-color:#56b746;' . ($this->session->get("flag_insert") === 1 ? "" : "display:none;") . '",
                                name:"add_record",
                                // nemeClass:"btn-sm btn-primary"
                            }
                        },
                        { text: "Excel",extend: "excel", className: "btn-sm btn-primary ' . ($this->session->get("flag_export") === 1 ? "" : "d-none") . '", exportOptions: {columns: [ 0, 1, 2, 3]} },
                        { text: "Cetak",extend: "print", className: "btn-sm btn-info ' . ($this->session->get("flag_print") === 1 ? "" : "d-none") . '", exportOptions: {columns: [ 0, 1, 2, 3]} },
                        {
                            text: "Import",
                            action: function(e, dt, node, config) {
                                // alert("Button activated");
                            },
                            attr: {
                                id: "import",
                                style: "background-color:#56b746;' . ($this->session->get("flag_insert") === 1 ? "" : "display:none;") . '",
                                name:"import",
                                nameClass:"btn btn-sm"
                            }
                        },
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
            $warehouse_cd = $this->request->getVar('warehouse_cd');

            // helper curl request
            helper(['restclient']);

            // endpoint
            $url = "$this->server/tmstroleapproval/delete/$warehouse_cd";

            // client request
            $response = akses_restapi('DELETE', $url, []);
            $data['response_data'] = json_decode($response, true);

            $msg = [
                'success' => "Data dengan nama $warehouse_cd berhasil dihapus"
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
                    // 'warehouse_cd' => [
                    //     'label' => 'Code',
                    //     'rules' => 'required',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ],
                    'warehouse_nm' => [
                        'label' => 'Warehouse',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'lokasi' => [
                        'label' => 'Lokasi',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'warehouse_sta_id' => [
                        'label' => 'Status',
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
                            'warehouse_cd' => $validation->getError('warehouse_cd'),
                            'warehouse_nm' => $validation->getError('warehouse_nm'),
                            'lokasi' => $validation->getError('lokasi'),
                            'warehouse_sta_id' => $validation->getError('warehouse_sta_id')
                        ]
                    ];
                } else {

                    if ($this->request->getVar('action') == 'Add') {

                        // helper curl request
                        helper(['restclient']);

                        // endpoint
                        $url = "$this->server/tmstroleapproval/insert";

                        // form params
                        $data = [
                            "warehouse_cd" => str_replace(" ", "_", trim($this->request->getVar('warehouse_cd'))),
                            "warehouse_nm" => $this->request->getVar('warehouse_nm'),
                            "lokasi" => $this->request->getVar('lokasi'),
                            "warehouse_sta_id" => $this->request->getVar('warehouse_sta_id')
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
                        $url = "$this->server/tmstroleapproval/update";

                        // form params
                        $data = [
                            "warehouse_cd" => str_replace(" ", "_", trim($this->request->getVar('warehouse_cd'))),
                            "warehouse_nm" => $this->request->getVar('warehouse_nm'),
                            "lokasi" => $this->request->getVar('lokasi'),
                            "warehouse_sta_id" => $this->request->getVar('warehouse_sta_id')
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

            $warehouse_cd = $this->request->getVar('warehouse_cd');

            if ($warehouse_cd) {

                // helper curl request
                helper(['restclient']);

                // end point
                $url = "$this->server/tmstroleapproval/getby/$warehouse_cd";

                // client request
                $response = akses_restapi('GET', $url, []);
                $data['response_data'] = json_decode($response, true);

                $msg = [
                    'data' => [
                        'warehouse_cd' => $data["response_data"][0]["warehouse_cd"],
                        'warehouse_nm' => $data["response_data"][0]["warehouse_nm"],
                        'lokasi' => $data["response_data"][0]["lokasi"],
                        'warehouse_sta_id' => $data["response_data"][0]["warehouse_sta_id"]
                    ]
                ];

                echo json_encode($msg);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    function fetchSingleDataPrint($warehouse_cd)
    {

        if ($warehouse_cd) {

            // helper curl request
            helper(['restclient']);

            // end point
            $url = "$this->server/tmstroleapproval/getby/$warehouse_cd";

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

    public function download()
    {
        // $model = new CommonModel();
        $spreadsheet = new Spreadsheet();
        // $result = $model->selectQuery();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue("A1", "KODE");
        $sheet->setCellValue("B1", "WAREHOUSE");
        $sheet->setCellValue("C1", "LOKASI");
        $sheet->setCellValue("D1", "STATUS");

        $count = 2;

        $sheet->setCellValue("A" . $count, "");
        $sheet->setCellValue("B" . $count, "");
        $sheet->setCellValue("C" . $count, "");
        $sheet->setCellValue("D" . $count, "");


        $writer = new Xlsx($spreadsheet);
        $writer->save("data.xlsx");
        return $this->response->download("data.xlsx", null)->setFileName("TEMPLATE WAREHOUSE.xlsx");
    }

    public function preview()
    {

        if ($this->request->getMethod() == "post") {
            $rules = $this->validate([
                'filename' => 'uploaded[filename]|max_size[filename,500]|ext_in[filename,csv,xlsx]',
            ]);
            if ($rules == true) {
                $filename =  $this->request->getFile('filename');
                $name = $filename->getName();
                $tempName = $filename->getTempName();
                $tgl_sekarang = date('YmdHis');

                $path = WRITEPATH . 'uploads/'; // Folder untuk menyimpan file
                $filename->move($path, $filename->getName());

                $this->session->set("fileupload", $path . "" . $filename->getName());
            } else {
                // return view("upload");
                return $this->response->setStatusCode(400)->setJSON(['error' => 'File yang diunggah harus berformat .xlsx']);
            }
        } else {

            if ($this->session->get("fileupload") !== '') {

                // Load Excel file
                $arr_file = explode(".", $this->session->get("fileupload"));
                $extension = end($arr_file);
                if ('csv' == $extension) {
                    $reader = new Csv();
                } else {
                    $reader = new excel();
                }

                $spreadsheet = $reader->load($this->session->get("fileupload"));
                $sheetData = $spreadsheet->getActiveSheet()->toArray();

                $output = '';
                $output .= '
                <br>
                 <table id="example5" class="table table-sm table-bordered table-striped">
                 <thead>
                         <tr>  
                             <th>Kode</th>
                             <th>Warehouse</th>
                             <th>Lokasi</th>
                             <th>Status</th>
                             
                         </tr>
                     </thead>
                         ';
                if (empty($sheetData)) {
                    $output .= '<tr>  
                                 <td >Data not Found</td>
                                 <td ></td>
                                 <td ></td>
                                 <td ></td>
                                 
                             </tr>';
                } else {
                    if (count($sheetData) > 1) {
                        $kosong = 0;
                        for ($i = 1; $i < count($sheetData); $i++) {

                            $warehouse_cd = $sheetData[$i][0];
                            $warehouse_nm = $sheetData[$i][1];
                            $lokasi = $sheetData[$i][2];
                            $warehouse_sta_id = $sheetData[$i][3];


                            $warehouse_cd_td = ($warehouse_cd !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            $warehouse_nm_td = ($warehouse_nm !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            $keterangan_td = ($lokasi !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            $warehouse_sta_id_td = ($warehouse_sta_id !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,


                            // Jika salah satu data ada yang kosong
                            if ($warehouse_cd == "" or $warehouse_nm == "" or $lokasi == "" or $warehouse_sta_id == "") {
                                $kosong++; // Tambah 1 variabel $kosong
                            }

                            $output .= '  
                            <tr id="addMdlBarang" data-id="' . $warehouse_cd . '">
                                <td ' . $warehouse_cd_td . '>' . $warehouse_cd . '</td>
                                <td ' . $warehouse_nm_td . '>' . $warehouse_nm . '</td>
                                <td ' . $keterangan_td . '>' . $lokasi . '</td>
                                <td ' . $warehouse_sta_id_td . '>' . $warehouse_sta_id . '</td>
                                
                            </tr>  
                            ';
                        }
                    }
                }
                $output .= '</table>
                
                 <script>
                 if(' . $kosong . '>0){
                    alert("Ada ' . $kosong . ' Baris Yang Terdapat Data Kosong!");
                 }
                 
                 $(function() {
                     $("#example5").DataTable({
                         // "responsive": true, "lengthChange": false, "autoWidth": false,
                         columnDefs: [{
                             orderable: false,
                             targets: 3
                         }],
                         "responsive": true,
                         "lengthChange": false,
                         "autoWidth": false,
                         // "columns": [
                         //   { "width": "10%" }, null, null, null, nuul, null
                         // ],
                         "buttons": [{
                            text: "Import",
                            action: function(e, dt, node, config) {
                                // alert("Button activated");
                                $.post("' . site_url('tmstroleapproval/upload') . '", {

                                })
                                .done(function(response) {
                                    alert("done");
                                    $("#modalimport").modal("hide");
                                    tmstroleapproval();
                                    // console.log("Data Loaded: " + response);
                                })
                                .fail(function(error) {
                                    alert("error");
                                    // console.error("Error: " + error);
                                });
                            },
                            attr: {
                                id: "postButton",
                                style: "background-color:#56b746;' . ($this->session->get("flag_insert") === 1 ? "" : "display:none;") . '",
                                name:"postButton",
                                nameClass:"btn-sm"
                            }
                        }
                           
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
                     }).buttons().container().appendTo("#example5_wrapper .col-md-6:eq(0)");
                 });
                 </script>
                 ';
                echo $output;
            } else {
                echo '';
            }
        }
    }

    public function upload()
    {
        if ($this->request->getMethod() == "post") {

            // Load Excel file
            $arr_file = explode(".", $this->session->get("fileupload"));
            $extension = end($arr_file);
            if ('csv' == $extension) {
                $reader = new Csv();
            } else {
                $reader = new excel();
            }

            $spreadsheet = $reader->load($this->session->get("fileupload"));
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            if (!empty($sheetData)) {
                for ($i = 1; $i < count($sheetData); $i++) {
                    $warehouse_cd = $sheetData[$i][0];
                    $warehouse_nm = $sheetData[$i][1];
                    $lokasi = $sheetData[$i][2];
                    $warehouse_sta_id = $sheetData[$i][3];


                    // helper curl request
                    helper(['restclient']);
                    // endpoint
                    $url = "$this->server/tmstroleapproval/insert";

                    $data = [
                        "warehouse_cd" => '',
                        "warehouse_nm" => $warehouse_nm,
                        "lokasi" => $lokasi,
                        "warehouse_sta_id" => 'A', // Default A = 'Aktif'
                    ];


                    // client request
                    $response = akses_restapi('POST', $url, $data);
                }

                $msg = [
                    'success' => $i . ' data berhasil di import!'
                ];

                return $this->response->setJSON($msg);

                // echo json_encode($msg);
                // return redirect()->to(site_url("/"));
            } else {
                return view("upload");
            }
        } else {
            return view("upload");
        }
    }
}
