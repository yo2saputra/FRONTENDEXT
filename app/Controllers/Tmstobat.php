<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as excel;

class Tmstobat extends BaseController
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

        $this->data['cb_jenis'] = getDropdownCustom('jenis_admin', 'jenis_admin', 'Jenis', 2, 10);
        $this->data['cb_kelas'] = getDropdownCustom('kelas_terapi', 'kelas_terapi', 'Kelas', 2, 4);
        $this->data['cb_subkelas'] = getDropdownCustom('subkelas_terapi', 'subkelas_terapi', 'Sub Kelas', 2, 4);
        $this->data['cb_generik'] = getDropdownCustom('nm_generik', 'nm_generik', 'Nama Generik', 2, 4);
        $this->data['cb_dagang'] = getDropdownCustom('nm_dagang', 'nm_dagang', 'Nama Dagang', 2, 4);
        $this->data['cb_aktif'] = getDropdownCustom('obat_sta_id', 'obat_sta_id', 'Status', 2, 4);
        return view('tmstobat/index', $this->data);
    }

    public function apiDataGetAll()
    {

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/tmstobat/getall";

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
                                <th>Obat</th>
                                <th>Jenis Admin</th>
                                <th>Kelas Terapi</th>
                                <th>Sub Kelas Terapi</th>
                                <th>Nama Generik</th>
                                <th>Nama Dagang</th>
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
                                <td ></td>
                                <td ></td>
                                <td ></td>
                                <td ></td>
                            </tr>';
            } else {
                for ($a = 0; $a < count($data); $a++) {
                    $output .= '  
                            <tr id="addMdlBarang" data-id="' . $data[$a]["obat_cd"] . '">
                                <td >' . $data[$a]["obat_cd"] . '</td>
                                <td >' . $data[$a]["obat"] . '</td>
                                <td >' . $data[$a]["jenis_admin"] . '</td>
                                <td >' . $data[$a]["kelas_terapi"] . '</td>
                                <td >' . $data[$a]["subkelas_terapi"] . '</td>
                                <td >' . $data[$a]["nm_generik"] . '</td>
                                <td >' . $data[$a]["nm_dagang"] . '</td>
                                <td >' . $data[$a]["obat_sta_id"] . '</td>
                                <td class="text-center">
                                    
                                    <div class="btn-group">
                                    <a data-toggle="tooltip" data-placement="top" title="View" class="btn btn-sm btn-info view ' . ($this->session->get("flag_view") === 1 ? "" : "d-none") . '" data-obat_cd="' . $data[$a]["obat_cd"] . '"><i class="fas fa-eye"></i></a>
                                    <a data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-sm btn-primary edit ' . ($this->session->get("flag_update") === 1 ? "" : "d-none") . '" data-obat_cd="' . $data[$a]["obat_cd"] . '"><i class="fas fa-tags"></i></a>
                                    <a data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-sm btn-danger delete ' . ($this->session->get("flag_delete") === 1 ? "" : "d-none") . '" data-obat_cd="' . $data[$a]["obat_cd"] . '"><i class="fas fa-trash"></i></a>
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
            $obat_cd = $this->request->getVar('obat_cd');

            // helper curl request
            helper(['restclient']);

            // endpoint
            $url = "$this->server/tmstobat/delete/$obat_cd";

            // client request
            $response = akses_restapi('DELETE', $url, []);
            $data['response_data'] = json_decode($response, true);

            $msg = [
                'success' => "Data dengan nama $obat_cd berhasil dihapus"
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
                    'obat' => [
                        'label' => 'Obat',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'jenis_admin' => [
                        'label' => 'Jenis Admin',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'kelas_terapi' => [
                        'label' => 'Kelas Terapi',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'subkelas_terapi' => [
                        'label' => 'Subkelas Terapi',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'nm_generik' => [
                        'label' => 'Nama Generik',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'nm_dagang' => [
                        'label' => 'Nama Dagang',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'obat_sta_id' => [
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
                            'obat_cd' => $validation->getError('obat_cd'),
                            'obat' => $validation->getError('obat'),
                            'jenis_admin' => $validation->getError('jenis_admin'),
                            'kelas_terapi' => $validation->getError('kelas_terapi'),
                            'subkelas_terapi' => $validation->getError('subkelas_terapi'),
                            'nm_generik' => $validation->getError('nm_generik'),
                            'nm_dagang' => $validation->getError('nm_dagang'),
                            'obat_sta_id' => $validation->getError('obat_sta_id')
                        ]
                    ];
                } else {

                    if ($this->request->getVar('action') == 'Add') {

                        // helper curl request
                        helper(['restclient']);

                        // endpoint
                        $url = "$this->server/tmstobat/insert";

                        // form params
                        $data = [
                            "obat_cd" => str_replace(" ", "_", trim($this->request->getVar('obat_cd'))),
                            "obat" => $this->request->getVar('obat'),
                            "jenis_admin" => $this->request->getVar('jenis_admin'),
                            "kelas_terapi" => $this->request->getVar('kelas_terapi'),
                            "subkelas_terapi" => $this->request->getVar('subkelas_terapi'),
                            "nm_generik" => $this->request->getVar('nm_generik'),
                            "nm_dagang" => $this->request->getVar('nm_dagang'),
                            "obat_sta_id" => $this->request->getVar('obat_sta_id')
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
                        $url = "$this->server/tmstobat/update";

                        // form params
                        $data = [
                            "obat_cd" => str_replace(" ", "_", trim($this->request->getVar('obat_cd'))),
                            "obat" => $this->request->getVar('obat'),
                            "jenis_admin" => $this->request->getVar('jenis_admin'),
                            "kelas_terapi" => $this->request->getVar('kelas_terapi'),
                            "subkelas_terapi" => $this->request->getVar('subkelas_terapi'),
                            "nm_generik" => $this->request->getVar('nm_generik'),
                            "nm_dagang" => $this->request->getVar('nm_dagang'),
                            "obat_sta_id" => $this->request->getVar('obat_sta_id')
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

            $obat_cd = $this->request->getVar('obat_cd');

            if ($obat_cd) {

                // helper curl request
                helper(['restclient']);

                // end point
                $url = "$this->server/tmstobat/getby/$obat_cd";

                // client request
                $response = akses_restapi('GET', $url, []);
                $data['response_data'] = json_decode($response, true);

                $msg = [
                    'data' => [
                        'obat_cd' => $data["response_data"][0]["obat_cd"],
                        'obat' => $data["response_data"][0]["obat"],
                        'jenis_admin' => $data["response_data"][0]["jenis_admin"],
                        'kelas_terapi' => $data["response_data"][0]["kelas_terapi"],
                        'subkelas_terapi' => $data["response_data"][0]["subkelas_terapi"],
                        'nm_generik' => $data["response_data"][0]["nm_generik"],
                        'nm_dagang' => $data["response_data"][0]["nm_dagang"],
                        'obat_sta_id' => $data["response_data"][0]["obat_sta_id"]
                    ]
                ];

                echo json_encode($msg);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    function fetchSingleDataPrint($obat_cd)
    {

        if ($obat_cd) {

            // helper curl request
            helper(['restclient']);

            // end point
            $url = "$this->server/tmstobat/getby/$obat_cd";

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
        $sheet->setCellValue("B1", "OBAT");
        $sheet->setCellValue("C1", "JENIS ADMIN");
        $sheet->setCellValue("D1", "KELAS TERAPI");
        $sheet->setCellValue("E1", "SUBKELAS TERAPI");
        $sheet->setCellValue("F1", "NAMA GENERIK");
        $sheet->setCellValue("G1", "NAMA DAGANG");
        $sheet->setCellValue("H1", "STATUS");

        $count = 2;

        $sheet->setCellValue("A" . $count, "");
        $sheet->setCellValue("B" . $count, "");
        $sheet->setCellValue("C" . $count, "");
        $sheet->setCellValue("D" . $count, "");
        $sheet->setCellValue("E" . $count, "");
        $sheet->setCellValue("F" . $count, "");
        $sheet->setCellValue("G" . $count, "");
        $sheet->setCellValue("H" . $count, "");


        $writer = new Xlsx($spreadsheet);
        $writer->save("data.xlsx");
        return $this->response->download("data.xlsx", null)->setFileName("TEMPLATE OBAT.xlsx");
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
                             <th>Obat</th>
                             <th>Jenis Admin</th>
                             <th>Kelas Terapi</th>
                             <th>Sub Kelas Terapi</th>
                             <th>Nama Generik</th>
                             <th>Nama Dagang</th>
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
                                 <td ></td>
                                 <td ></td>
                                 <td ></td>
                                 <td ></td>
                                 
                             </tr>';
                } else {
                    if (count($sheetData) > 1) {
                        $kosong = 0;
                        for ($i = 1; $i < count($sheetData); $i++) {

                            $obat_cd = $sheetData[$i][0];
                            $obat = $sheetData[$i][1];
                            $jenis_admin = $sheetData[$i][2];
                            $kelas_terapi = $sheetData[$i][3];
                            $subkelas_terapi = $sheetData[$i][4];
                            $nm_generik = $sheetData[$i][5];
                            $nm_dagang = $sheetData[$i][6];
                            $obat_sta_id = $sheetData[$i][7];


                            $obat_cd_td = ($obat_cd !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            $obat_td = ($obat !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            $jenis_admin_td = ($jenis_admin !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            $kelas_terapi_td = ($kelas_terapi !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            $subkelas_terapi_td = ($subkelas_terapi !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            $nm_generik_td = ($nm_generik !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            $nm_dagang_td = ($nm_dagang !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            $obat_sta_id_td = ($obat_sta_id !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,


                            // Jika salah satu data ada yang kosong
                            if ($obat_cd == "" or $obat == "" or $jenis_admin == "" or $kelas_terapi == "" or $subkelas_terapi == "" or $nm_generik == "" or $nm_dagang == "" or $obat_sta_id == "") {
                                $kosong++; // Tambah 1 variabel $kosong
                            }

                            $output .= '  
                            <tr id="addMdlBarang" data-id="' . $obat_cd . '">
                                <td ' . $obat_cd_td . '>' . $obat_cd . '</td>
                                <td ' . $obat_td . '>' . $obat . '</td>
                                <td ' . $jenis_admin_td . '>' . $jenis_admin . '</td>
                                <td ' . $kelas_terapi_td . '>' . $kelas_terapi . '</td>
                                <td ' . $subkelas_terapi_td . '>' . $subkelas_terapi . '</td>
                                <td ' . $nm_generik_td . '>' . $nm_generik . '</td>
                                <td ' . $nm_dagang_td . '>' . $nm_dagang . '</td>
                                <td ' . $obat_sta_id_td . '>' . $obat_sta_id . '</td>
                                
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
                                $.post("' . site_url('tmstobat/upload') . '", {

                                })
                                .done(function(response) {
                                    alert("done");
                                    $("#modalimport").modal("hide");
                                    tmstobat();
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
                    $obat_cd = $sheetData[$i][0];
                    $obat = $sheetData[$i][1];
                    $jenis_admin = $sheetData[$i][2];
                    $kelas_terapi = $sheetData[$i][3];
                    $subkelas_terapi = $sheetData[$i][4];
                    $nm_generik = $sheetData[$i][5];
                    $nm_dagang = $sheetData[$i][6];
                    $obat_sta_id = $sheetData[$i][7];


                    // helper curl request
                    helper(['restclient']);
                    // endpoint
                    $url = "$this->server/tmstobat/insert";

                    $data = [
                        "obat_cd" => '',
                        "obat" => $obat,
                        "jenis_admin" => $jenis_admin,
                        "kelas_terapi" => $kelas_terapi,
                        "subkelas_terapi" => $subkelas_terapi,
                        "nm_generik" => $nm_generik,
                        "nm_dagang" => $nm_dagang,
                        "obat_sta_id" => 'A', // Default A = 'Aktif'
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
