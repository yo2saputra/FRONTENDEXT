<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as excel;

class Tmstpaket extends BaseController
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

        $this->data['cb_aktif'] = getDropdownCustom('poly_sta_id', 'status_paket', 'Status', 2, 4);
        return view('tmstpaket/index', $this->data);
    }

    public function apiDataGetAll()
    {

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/tmstpaket/getall";

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
                                <th>Nama</th>
                                <th>Keterangan</th>
                                <th>Tgl Dibuat</th>
                                <th>Status Paket</th>
                                <th>Periode Dari</th>
                                <th>Periode Sampai</th>
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
                            <tr id="addMdlBarang" data-id="' . $data[$a]["kode_paket"] . '">
                                <td >' . $data[$a]["kode_paket"] . '</td>
                                <td >' . $data[$a]["nama_paket"] . '</td>
                                <td >' . $data[$a]["keterangan"] . '</td>
                                <td >' . date('d/m/Y', strtotime($data[$a]["tanggal_dibuat"])) . '</td>
                                <td >' . $data[$a]["status_paket"] . '</td>
                                <td >' . date('d/m/Y', strtotime($data[$a]["periode_dari"])) . '</td>
                                <td >' . date('d/m/Y', strtotime($data[$a]["periode_sampai"])) . '</td>
                                <td class="text-center">
                                    
                                    <div class="btn-group">
                                    <a data-toggle="tooltip" data-placement="top" title="View" class="btn btn-sm btn-info view ' . ($this->session->get("flag_view") === 1 ? "" : "d-none") . '" data-kode_paket="' . $data[$a]["kode_paket"] . '"><i class="fas fa-eye"></i></a>
                                    <a data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-sm btn-primary edit ' . ($this->session->get("flag_update") === 1 ? "" : "d-none") . '" data-kode_paket="' . $data[$a]["kode_paket"] . '"><i class="fas fa-tags"></i></a>
                                    <a data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-sm btn-danger delete ' . ($this->session->get("flag_delete") === 1 ? "" : "d-none") . '" data-kode_paket="' . $data[$a]["kode_paket"] . '"><i class="fas fa-trash"></i></a>
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
                        targets: 7
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
                        { text: "Excel",extend: "excel", className: "btn-sm btn-primary ' . ($this->session->get("flag_export") === 1 ? "" : "d-none") . '", exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7]} },
                        { text: "Cetak",extend: "print", className: "btn-sm btn-info ' . ($this->session->get("flag_print") === 1 ? "" : "d-none") . '", exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7]} },
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
            $kode_paket = $this->request->getVar('kode_paket');

            // helper curl request
            helper(['restclient']);

            // endpoint
            $url = "$this->server/tmstpaket/delete/$kode_paket";

            // client request
            $response = akses_restapi('DELETE', $url, []);
            $data['response_data'] = json_decode($response, true);

            $msg = [
                'success' => "Data dengan nama $kode_paket berhasil dihapus"
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
                    // 'obat_cd' => [
                    //     'label' => 'Code',
                    //     'rules' => 'required',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ],
                    'nama_paket' => [
                        'label' => 'Nama Paket',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'keterangan' => [
                        'label' => 'Keterangan',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'status_paket' => [
                        'label' => 'Status Paket',
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
                            'kode_paket' => $validation->getError('kode_paket'),
                            'nama_paket' => $validation->getError('nama_paket'),
                            'keterangan' => $validation->getError('keterangan'),
                            'tanggal_dibuat' => $validation->getError('tanggal_dibuat'),
                            'status_paket' => $validation->getError('status_paket'),
                            'periode_dari' => $validation->getError('periode_dari'),
                            'periode_sampai' => $validation->getError('periode_sampai')
                        ]
                    ];
                } else {

                    if ($this->request->getVar('action') == 'Add') {

                        // helper curl request
                        helper(['restclient']);

                        // endpoint
                        $url = "$this->server/tmstpaket/insert";

                        // form params
                        $data = [
                            "kode_paket" => str_replace(" ", "_", trim($this->request->getVar('kode_paket'))),
                            "nama_paket" => $this->request->getVar('nama_paket'),
                            "keterangan" => $this->request->getVar('keterangan'),
                            "tanggal_dibuat" => date('Y-m-d', strtotime($this->request->getVar('tanggal_dibuat'))),
                            "status_paket" => $this->request->getVar('status_paket'),
                            "periode_dari" => date('Y-m-d', strtotime($this->request->getVar('periode_dari'))),
                            "periode_sampai" => date('Y-m-d', strtotime($this->request->getVar('periode_sampai')))
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
                        $url = "$this->server/tmstpaket/update";

                        // form params
                        $data = [
                            "kode_paket" => str_replace(" ", "_", trim($this->request->getVar('kode_paket'))),
                            "nama_paket" => $this->request->getVar('nama_paket'),
                            "keterangan" => $this->request->getVar('keterangan'),
                            "tanggal_dibuat" => date('Y-m-d', strtotime($this->request->getVar('tanggal_dibuat'))),
                            "status_paket" => $this->request->getVar('status_paket'),
                            "periode_dari" => date('Y-m-d', strtotime($this->request->getVar('periode_dari'))),
                            "periode_sampai" => date('Y-m-d', strtotime($this->request->getVar('periode_sampai')))
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

            $kode_paket = $this->request->getVar('kode_paket');

            if ($kode_paket) {

                // helper curl request
                helper(['restclient']);

                // end point
                $url = "$this->server/tmstpaket/getby/$kode_paket";

                // client request
                $response = akses_restapi('GET', $url, []);
                $data['response_data'] = json_decode($response, true);

                $msg = [
                    'data' => [
                        'kode_paket' => $data["response_data"][0]["kode_paket"],
                        'nama_paket' => $data["response_data"][0]["nama_paket"],
                        'keterangan' => $data["response_data"][0]["keterangan"],
                        'tanggal_dibuat' => $data["response_data"][0]["tanggal_dibuat"],
                        'status_paket' => $data["response_data"][0]["status_paket"],
                        'periode_dari' => $data["response_data"][0]["periode_dari"],
                        'periode_sampai' => $data["response_data"][0]["periode_sampai"]
                    ]
                ];

                echo json_encode($msg);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    function fetchSingleDataPrint($kode_paket)
    {

        if ($kode_paket) {

            // helper curl request
            helper(['restclient']);

            // end point
            $url = "$this->server/tmstpaket/getby/$kode_paket";

            // client request
            $response = akses_restapi('GET', $url, []);
            $data['response_data'] = json_decode($response, true);

            $pdf_data = $data['response_data'];
            $pdf_name = 'Single Data Paket';
            $pdf_title = 'Data Paket';
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
        $sheet->setCellValue("B1", "PAKET");
        $sheet->setCellValue("C1", "KETERANGAN");
        $sheet->setCellValue("D1", "TANGGAL DIBUAT");
        $sheet->setCellValue("E1", "STATUS PAKET");
        $sheet->setCellValue("F1", "PERIODE DARI");
        $sheet->setCellValue("G1", "PERIODE SAMPAI");

        $count = 2;

        $sheet->setCellValue("A" . $count, "");
        $sheet->setCellValue("B" . $count, "");
        $sheet->setCellValue("C" . $count, "");
        $sheet->setCellValue("D" . $count, "");
        $sheet->setCellValue("E" . $count, "");
        $sheet->setCellValue("F" . $count, "");
        $sheet->setCellValue("G" . $count, "");


        $writer = new Xlsx($spreadsheet);
        $writer->save("data.xlsx");
        return $this->response->download("data.xlsx", null)->setFileName("TEMPLATE PAKET.xlsx");
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
                             <th>Paket</th>
                             <th>Keterangan</th>
                             <th>Tanggal Dibuat</th>
                             <th>Status Paket</th>
                             <th>Periode Dari</th>
                             <th>Periode Sampai</th>
                         </tr>
                     </thead>
                         ';
                if (empty($sheetData)) {
                    $output .= '<tr>  
                                 <td >Data not Found</td>
                                 <td ></td>
                                 <td ></td>
                                 <td ></td>
                                 <td ></td>
                                 <td ></td>
                                 <td ></td>
                             </tr>';
                } else {
                    if (count($sheetData) > 1) {
                        $kosong = 0;
                        for ($i = 1; $i < count($sheetData); $i++) {

                            $kode_paket = $sheetData[$i][0];
                            $nama_paket = $sheetData[$i][1];
                            $keterangan = $sheetData[$i][2];
                            $tanggal_dibuat = $sheetData[$i][3];
                            $status_paket = $sheetData[$i][4];
                            $periode_dari = $sheetData[$i][5];
                            $periode_sampai = $sheetData[$i][6];

                            $kode_paket_td = ($kode_paket !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            $nama_paket_td = ($nama_paket !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            $keterangan_td = ($keterangan !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            $tanggal_dibuat_td = ($tanggal_dibuat !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            $status_paket_td = ($status_paket !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            $periode_dari_td = ($periode_dari !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            $periode_sampai_td = ($periode_sampai !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,


                            // Jika salah satu data ada yang kosong
                            if ($kode_paket == "" or $nama_paket == "" or $keterangan == "" or $tanggal_dibuat == "" or $status_paket == "" or $periode_dari == "" or $periode_sampai == "") {
                                $kosong++; // Tambah 1 variabel $kosong
                            }

                            $output .= '  
                            <tr id="addMdlBarang" data-id="' . $kode_paket . '">
                                <td ' . $kode_paket_td . '>' . $kode_paket . '</td>
                                <td ' . $nama_paket_td . '>' . $nama_paket . '</td>
                                <td ' . $keterangan_td . '>' . $keterangan . '</td>
                                <td ' . $tanggal_dibuat_td . '>' . $tanggal_dibuat . '</td>
                                <td ' . $status_paket_td . '>' . $status_paket . '</td>
                                <td ' . $periode_dari_td . '>' . $periode_dari . '</td>
                                <td ' . $periode_sampai_td . '>' . $periode_sampai . '</td>
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
                                $.post("' . site_url('tmstpaket/upload') . '", {

                                })
                                .done(function(response) {
                                    alert("done");
                                    $("#modalimport").modal("hide");
                                    tmstpaket();
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
                    $kode_paket = $sheetData[$i][0];
                    $nama_paket = $sheetData[$i][1];
                    $keterangan = $sheetData[$i][2];
                    $tanggal_dibuat = $sheetData[$i][3];
                    $status_paket = $sheetData[$i][4];
                    $periode_dari = $sheetData[$i][5];
                    $periode_sampai = $sheetData[$i][6];


                    // helper curl request
                    helper(['restclient']);
                    // endpoint
                    $url = "$this->server/tmstpaket/insert";

                    $data = [
                        "kode_paket" => '',
                        "nama_paket" => $nama_paket,
                        "keterangan" => $keterangan,
                        "tanggal_dibuat" => $tanggal_dibuat,
                        "status_paket" => 'A', // Default A = 'Aktif'
                        "periode_dari" => $periode_dari,
                        "periode_sampai" => $periode_sampai
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
