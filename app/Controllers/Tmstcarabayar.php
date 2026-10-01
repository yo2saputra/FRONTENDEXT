<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as excel;

class Tmstcarabayar extends BaseController
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
        $this->data['cb_type'] = getDropdownCustom('type_payment', 'Type', 'Type', 2, 4);
        $this->data['cb_integrated_module'] = getDropdownCustom('integrated_module', 'IntegratedModule', 'Integrated Module', 2, 4);
        $this->data['cb_glcoa'] = getDropdownGlCoaCustom('AccountNo', 'AccountNo', 'Account No', 2, 4);

        return view('tmstcarabayar/index', $this->data);
    }

    public function apiDataGetAll()
    {

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/tmstcarabayar/getall";

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
                                <th>Name</th>
                                <th>Type</th>
                                <th>Integrated Module</th>
                                <th>Markup Percentage</th>
                                <th>Account No</th>
                                <th>Account Desc</th>
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
                            <tr id="addMdlBarang" data-id="' . $data[$a]["kodeCaraBayar"] . '">
                                <td >' . $data[$a]["kodeCaraBayar"] . '</td>
                                <td >' . $data[$a]["descriptionCaraBayar"] . '</td>
                                <td >' . $data[$a]["type"] . '</td>
                                <td >' . $data[$a]['integratedModule'] . '</td>
                                <td >' . $data[$a]['markupPercentage'] . '</td>
                                <td >' . $data[$a]['accountNo'] . '</td>
                                <td >' . $data[$a]['accountDescription'] . '</td>
                                <td class="text-center">
                                    
                                    <div class="btn-group">
                                    <a data-toggle="tooltip" data-placement="top" title="View" class="btn btn-sm btn-info view ' . ($this->session->get("flag_view") === 1 ? "" : "d-none") . '" data-kodecarabayar="' . $data[$a]["kodeCaraBayar"] . '"><i class="fas fa-eye"></i></a>
                                    <a data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-sm btn-primary edit ' . ($this->session->get("flag_update") === 1 ? "" : "d-none") . '" data-kodecarabayar="' . $data[$a]["kodeCaraBayar"] . '"><i class="fas fa-tags"></i></a>
                                    <a data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-sm btn-danger delete ' . ($this->session->get("flag_delete") === 1 ? "" : "d-none") . '" data-kodecarabayar="' . $data[$a]["kodeCaraBayar"] . '"><i class="fas fa-trash"></i></a>
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
                        { text: "Excel",extend: "excel", className: "btn-sm btn-primary ' . ($this->session->get("flag_export") === 1 ? "" : "d-none") . '", exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6]} },
                        { text: "Cetak",extend: "print", className: "btn-sm btn-info ' . ($this->session->get("flag_print") === 1 ? "" : "d-none") . '", exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6]} },
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
            $KodeCaraBayar = $this->request->getVar('KodeCaraBayar');

            // helper curl request
            helper(['restclient']);

            // endpoint
            $url = "$this->server/tmstcarabayar/delete/$KodeCaraBayar";

            // client request
            $response = akses_restapi('DELETE', $url, []);
            $data['response_data'] = json_decode($response, true);

            $msg = [
                'success' => "Data dengan nama $KodeCaraBayar berhasil dihapus"
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
                    // 'KodeCaraBayar' => [
                    //     'label' => 'Code',
                    //     'rules' => 'required',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ],
                    'DescriptionCaraBayar' => [
                        'label' => 'Description',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'Type' => [
                        'label' => 'Type',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ]
                    // ,
                    // 'IntegratedModule' => [
                    //     'label' => 'Integrated Module',
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
                            'KodeCaraBayar' => $validation->getError('KodeCaraBayar'),
                            'DescriptionCaraBayar' => $validation->getError('DescriptionCaraBayar'),
                            'Type' => $validation->getError('Type'),
                            'IntegratedModule' => $validation->getError('IntegratedModule')
                        ]
                    ];
                } else {

                    if ($this->request->getVar('action') == 'Add') {

                        // helper curl request
                        helper(['restclient']);

                        // endpoint
                        $url = "$this->server/tmstcarabayar/insert";

                        // form params
                        $data = [
                            "KodeCaraBayar" => str_replace(" ", "_", trim($this->request->getVar('KodeCaraBayar'))),
                            "DescriptionCaraBayar" => $this->request->getVar('DescriptionCaraBayar'),
                            "Type" => $this->request->getVar('Type'),
                            "IntegratedModule" => $this->request->getVar('IntegratedModule'),
                            "MarkupPercentage" => $this->request->getVar('MarkupPercentage'),
                            "AccountNo" => $this->request->getVar('AccountNo'),
                            "AccountDescription" => $this->request->getVar('AccountDescription'),
                            "CreatedBy" => $this->request->getVar('CreatedBy'),
                            "CreatedDate" => $this->request->getVar('CreatedDate'),
                            "UpdatedBy" => $this->request->getVar('UpdatedBy'),
                            "UpdatedDate" => $this->request->getVar('UpdatedDate'),
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
                        $url = "$this->server/tmstcarabayar/update";

                        // form params
                        $data = [
                            "KodeCaraBayar" => str_replace(" ", "_", trim($this->request->getVar('KodeCaraBayar'))),
                            "DescriptionCaraBayar" => $this->request->getVar('DescriptionCaraBayar'),
                            "Type" => $this->request->getVar('Type'),
                            "IntegratedModule" => $this->request->getVar('IntegratedModule'),
                            "MarkupPercentage" => $this->request->getVar('MarkupPercentage'),
                            "AccountNo" => $this->request->getVar('AccountNo'),
                            "AccountDescription" => $this->request->getVar('AccountDescription'),
                            "UpdatedBy" => $this->request->getVar('UpdatedBy'),
                            "UpdatedDate" => $this->request->getVar('UpdatedDate'),
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

        $KodeCaraBayar = $this->request->getVar('KodeCaraBayar');

        if ($KodeCaraBayar) {

            // helper curl request
            helper(['restclient']);

            // end point
            $url = "$this->server/tmstcarabayar/getby/$KodeCaraBayar";

            // client request
            $response = akses_restapi('GET', $url, []);
            $data['response_data'] = json_decode($response, true);

            $msg = [
                'data' => [
                    'KodeCaraBayar' => $data["response_data"][0]["kodeCaraBayar"],
                    'DescriptionCaraBayar' => $data["response_data"][0]["descriptionCaraBayar"],
                    'Type' => $data["response_data"][0]["type"],
                    'IntegratedModule' => $data["response_data"][0]["integratedModule"],
                    'MarkupPercentage' => $data["response_data"][0]["markupPercentage"],
                    'AccountNo' => $data["response_data"][0]["accountNo"],
                    'AccountDescription' => $data["response_data"][0]["accountDescription"]
                ]
            ];

            echo json_encode($msg);
        }
        // } else {
        //     exit('Maaf tidak dapat diproses!');
        // }
    }

    function fetchSingleDataPrint($KodeCaraBayar)
    {

        if ($KodeCaraBayar) {

            // helper curl request
            helper(['restclient']);

            // end point
            $url = "$this->server/tmstcarabayar/getby/$KodeCaraBayar";

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

        $sheet->setCellValue("A1", "Kode");
        $sheet->setCellValue("B1", "Description Cara Bayar");
        $sheet->setCellValue("C1", "Type");
        $sheet->setCellValue("D1", "Integrated Module");
        $sheet->setCellValue("E1", "Mark Up Percentage");
        $sheet->setCellValue("F1", "Account No");
        $sheet->setCellValue("G1", "Account Description");

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
        return $this->response->download("data.xlsx", null)->setFileName("TEMPLATE CARA BAYAR.xlsx");
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
                             <th>Kode Cara Bayar</th>
                             <th>Description Cara Bayar</th>
                             <th>Type</th>
                             <th>Integrated Module</th>
                             <th>Mark up Percentage</th>
                             <th>Account No</th>
                             <th>Account Description</th>
                             
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

                            $KodeCaraBayar = $sheetData[$i][0];
                            $DescriptionCaraBayar = $sheetData[$i][1];
                            $Type = $sheetData[$i][2];
                            $IntegratedModule = $sheetData[$i][3];
                            $MarkupPercentage = $sheetData[$i][4];
                            $AccountNo = $sheetData[$i][5];
                            $AccountDescription = $sheetData[$i][6];


                            $KodeCaraBayar_td = ($KodeCaraBayar !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            $DescriptionCaraBayar_td = ($DescriptionCaraBayar !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            $Type_td = ($Type !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            $IntegratedModule_td = ($IntegratedModule !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            $MarkupPercentage_td = ($MarkupPercentage !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            $AccountNo_td = ($AccountNo !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            $AccountDescription_td = ($AccountDescription !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,


                            // Jika salah satu data ada yang kosong
                            if ($KodeCaraBayar == "" or $DescriptionCaraBayar == "" or $Type == "" or $IntegratedModule == "" or $MarkupPercentage == "" or $AccountNo == "" or $AccountDescription == "") {
                                $kosong++; // Tambah 1 variabel $kosong
                            }

                            $output .= '  
                            <tr id="addMdlBarang" data-id="' . $KodeCaraBayar . '">
                                <td ' . $KodeCaraBayar_td . '>' . $KodeCaraBayar . '</td>
                                <td ' . $DescriptionCaraBayar_td . '>' . $DescriptionCaraBayar . '</td>
                                <td ' . $Type_td . '>' . $Type . '</td>
                                <td ' . $IntegratedModule_td . '>' . $IntegratedModule . '</td>
                                <td ' . $MarkupPercentage_td . '>' . $MarkupPercentage . '</td>
                                <td ' . $AccountNo_td . '>' . $AccountNo . '</td>
                                <td ' . $AccountDescription_td . '>' . $AccountDescription . '</td>
                                
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
                             targets: 6
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
                                $.post("' . site_url('tmstcarabayar/upload') . '", {

                                })
                                .done(function(response) {
                                    alert("done");
                                    $("#modalimport").modal("hide");
                                    tmstwarehouse();
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
                    $KodeCaraBayar = $sheetData[$i][0];
                    $DescriptionCaraBayar = $sheetData[$i][1];
                    $Type = $sheetData[$i][2];
                    $IntegratedModule = $sheetData[$i][3];
					$MarkupPercentage = $sheetData[$i][4];
					$AccountNo = $sheetData[$i][5];
					$AccountDescription = $sheetData[$i][6];


                    // helper curl request
                    helper(['restclient']);
                    // endpoint
                    $url = "$this->server/tmstcarabayar/insert";

                    $data = [
                        "KodeCaraBayar" => '',
                        "DescriptionCaraBayar" => $DescriptionCaraBayar,
                        "Type" => $Type,
                        "IntegratedModule" => $IntegratedModule,
						"MarkupPercentage" => $MarkupPercentage,
						"AccountNo" => $AccountNo,
						"AccountDescription" => $AccountDescription,
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
