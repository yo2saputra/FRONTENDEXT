<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as excel;

class Fieldvalue extends BaseController
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

        $this->data['blood_typ'] = $this->apiDropdownq();
        $this->data['cb_city_cd'] = getDropdown('city_cd', 'Kota', 2, 10); // (id,Label,label size, input size)
        $this->data['cb_classteraphy_cd'] = getDropdown('classteraphy_cd', 'Kelas Terapi', 2, 10);
        $this->data['cb_drug_typ'] = getDropdown('drug_typ', 'Drug Type', 2, 10);


        return view('fieldvalue/index', $this->data);
    }

    public function apiDropdownq()
    {
        //Set metode request dan endpoint
        //$response = $this->client->request("GET", "$this->server/dropdown/tfieldvalues/blood_typ");
        //Ambil body dari response
        //$content = $response->getBody();
        //$data['response_data'] = json_decode($content, true);
        //return $data['response_data'];

        // helper curl request
        helper(['restclient']);
        // endpoint
        $url = "$this->server/dropdown/tfield_value/blood_typ";
        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);
        return $data['response_data'];
    }

    public function apiDataGetAll()
    {
        //Set metode request dan endpoint
        //$response = $this->client->request("GET", "$this->server/clinic/tfield_value/getall");
        //Ambil body dari response
        //$content = $response->getBody();
        //$data['response_data'] = json_decode($content, true);
        //return $data['response_data'];

        // helper curl request
        helper(['restclient']);
        // endpoint
        $url = "$this->server/tfield_value/getall";
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
                                <th>Nama</th>
                                <th>Value</th>
                                <th>Desc</th>
                                <th>Hidden Field</th>
                                <th>Deleted</th>
                                <th>Order</th>
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
                                </tr>';
            } else {
                for ($a = 0; $a < count($data); $a++) {
                    $output .= '  
                            <tr id="addMdlBarang" data-id="' . $data[$a]["fld_valu"] . '">
                                <td >' . $data[$a]["fld_nm"] . '</td>
                                <td >' . $data[$a]["fld_valu"] . '</td>
                                <td >' . $data[$a]["fld_desc"] . '</td>
                                <td ><span class="right badge ' . ($data[$a]['hiddenfield'] == 1 ? 'badge-info' : 'badge-warning') . '">' . ($data[$a]["hiddenfield"] == 1 ? "Ya" : "Tidak") . '</span></td>
                                <td ><span class="right badge ' . ($data[$a]['deleted'] == 1 ? 'badge-info' : 'badge-warning') . '">' . ($data[$a]["deleted"] == 1 ? "Ya" : "Tidak") . '</span></td>
                                <td >' . $data[$a]["orderby"] . '</td>
                                <td class="text-center">
                                    
                                    <div class="btn-group">
                                    <a data-toggle="tooltip" data-placement="top" title="View" class="btn btn-sm btn-info view ' . ($this->session->get("flag_view") === 1 ? "" : "d-none") . '" data-fld_nm="' . $data[$a]["fld_nm"] . '" data-fld_valu="' . $data[$a]["fld_valu"] . '"><i class="fas fa-eye"></i></a>
                                    <a data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-sm btn-primary edit ' . ($this->session->get("flag_update") === 1 ? "" : "d-none") . '" data-fld_nm="' . $data[$a]["fld_nm"] . '" data-fld_valu="' . $data[$a]["fld_valu"] . '"><i class="fas fa-tags"></i></a>
                                    <a data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-sm btn-danger delete ' . ($this->session->get("flag_delete") === 1 ? "" : "d-none") . '" data-fld_nm="' . $data[$a]["fld_nm"] . '" data-fld_valu="' . $data[$a]["fld_valu"] . '"><i class="fas fa-trash"></i></a>
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
                        targets: 6
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
                        { text: "Excel",extend: "excel", className: "btn-sm btn-primary ' . ($this->session->get("flag_export") === 1 ? "" : "d-none") . '", exportOptions: {columns: [ 0, 1, 2, 3, 4, 5]} },
                        { text: "Cetak",extend: "print", className: "btn-sm btn-info ' . ($this->session->get("flag_print") === 1 ? "" : "d-none") . '", exportOptions: {columns: [ 0, 1, 2, 3, 4, 5]} },
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
            $fld_nm = $this->request->getVar('fld_nm');
            $fld_valu = $this->request->getVar('fld_valu');

            // $response = $this->client->request("DELETE", "$this->server/tfield_value/delete/$fld_nm/$fld_valu");

            // $content = $response->getBody();
            // $data['respon_data'] = json_decode($content, true);

            // helper curl request
            helper(['restclient']);
            // endpoint
            $url = "$this->server/tfield_value/delete/$fld_nm/$fld_valu";
            // $data = [
            //     "fld_nm" => $this->request->getVar('nama'),
            //     "fld_valu" => $this->request->getVar('value')
            // ];

            // client request
            $response = akses_restapi('DELETE', $url, []);
            $data['response_data'] = json_decode($response, true);

            $msg = [
                'success' => "Data dengan nama $fld_nm berhasil dihapus"
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
                    'nama' => [
                        'label' => 'Nama',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'value' => [
                        'label' => 'Value',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'desc' => [
                        'label' => 'Desc',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'orderby' => [
                        'label' => 'Order By',
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
                            'nama' => $validation->getError('nama'),
                            'value' => $validation->getError('value'),
                            'desc' => $validation->getError('desc'),
                            'orderby' => $validation->getError('orderby')
                        ]
                    ];
                } else {

                    if ($this->request->getVar('action') == 'Add') {

                        // $response = $this->client->request("POST", "$this->server/tfield_value/insert", [
                        //     "headers" => [
                        //         //"Content-Type: application/json",
                        //         "Accept" => "application/json"
                        //     ],
                        //     "form_params" => [
                        //         "fld_nm" => $this->request->getVar('nama'),
                        //         "fld_valu" => $this->request->getVar('value'),
                        //         "fld_desc" => $this->request->getVar('desc')
                        //     ]
                        // ]);

                        // helper curl request
                        helper(['restclient']);
                        // endpoint
                        $url = "$this->server/tfield_value/insert";
                        // form params
                        $data = [
                            "fld_nm" => str_replace(" ", "_", trim($this->request->getVar('nama'))),
                            "fld_valu" => $this->request->getVar('value'),
                            "fld_desc" => $this->request->getVar('desc'),
                            "hiddenfield" => ($this->request->getVar('hiddenfield') == FALSE) ? 0 : 1,
                            "deleted" => ($this->request->getVar('deleted') == FALSE) ? 0 : 1,
                            "orderby" => $this->request->getVar('orderby')
                        ];
                        // client request
                        $response = akses_restapi('POST', $url, $data);

                        $msg = [
                            'success' => 'data berhasil di create!'
                        ];
                    }

                    if ($this->request->getVar('action') == 'Edit') {
                        // $fld_nm = $this->request->getVar('nama');
                        // $fld_valu = $this->request->getVar('value');

                        // $response = $this->client->request("PUT", "$this->server/tfield_value/update/$fld_nm/$fld_valu", [
                        //     "headers" => [
                        //         //"Content-Type: application/json",
                        //         "Accept" => "application/json"
                        //     ],
                        //     "form_params" => [
                        //         "fld_desc" => $this->request->getVar('desc')
                        //     ]
                        // ]);

                        // helper curl request
                        helper(['restclient']);
                        // endpoint
                        // $url = "$this->server/tfield_value/update/$fld_nm/$fld_valu";
                        $url = "$this->server/tfield_value/update";
                        // form params
                        $data = [
                            "fld_nm" => $this->request->getVar('nama'),
                            "fld_valu" => $this->request->getVar('value'),
                            "fld_desc" => $this->request->getVar('desc'),
                            "hiddenfield" => ($this->request->getVar('hiddenfield') == FALSE) ? 0 : 1,
                            "deleted" => ($this->request->getVar('deleted') == FALSE) ? 0 : 1,
                            "orderby" => $this->request->getVar('orderby')
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

            $fld_nm = $this->request->getVar('fld_nm');
            $fld_valu = $this->request->getVar('fld_valu');

            if ($fld_nm) {

                // $response = $this->client->request("GET", "$this->server/tfield_value/getby/$fld_nm/$fld_valu", [
                //     "headers" => [
                //         "Accept" => "application/json"
                //     ]
                // ]);

                // $content = $response->getBody();
                // $data['respon_produk'] = json_decode($content, true);

                // helper curl request
                helper(['restclient']);
                // end point
                $url = "$this->server/tfield_value/getby/$fld_nm/$fld_valu";
                // client request
                $response = akses_restapi('GET', $url, []);
                $data['response_data'] = json_decode($response, true);


                $msg = [
                    'data' => [
                        'nama' => $data["response_data"][0]["fld_nm"],
                        'value' => $data["response_data"][0]["fld_valu"],
                        'desc' => $data["response_data"][0]["fld_desc"],
                        'hiddenfield' => $data["response_data"][0]["hiddenfield"],
                        'deleted' => $data["response_data"][0]["deleted"],
                        'orderby' => $data["response_data"][0]["orderby"]
                    ]
                ];

                echo json_encode($msg);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    function fetchSingleDataPrint($fld_nm, $fld_valu)
    {

        if ($fld_nm) {

            // $response = $this->client->request("GET", "$this->server/tfield_value/getby/$fld_nm/$fld_valu", [
            //     "headers" => [
            //         "Accept" => "application/json"
            //     ]
            // ]);

            // $content = $response->getBody();
            // $data['respon_produk'] = json_decode($content, true);

            // helper curl request
            helper(['restclient']);
            // end point
            $url = "$this->server/tfield_value/getby/$fld_nm/$fld_valu";
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

        $sheet->setCellValue("A1", "NAMA");
        $sheet->setCellValue("B1", "VALUE");
        $sheet->setCellValue("C1", "DESC");
        $sheet->setCellValue("D1", "HIDDEN FIELD");
        $sheet->setCellValue("E1", "DELETED");
        $sheet->setCellValue("F1", "ORDERBY");
        $count = 2;

        $sheet->setCellValue("A" . $count, "");
        $sheet->setCellValue("B" . $count, "");
        $sheet->setCellValue("C" . $count, "");
        $sheet->setCellValue("D" . $count, "");
        $sheet->setCellValue("E" . $count, "");
        $sheet->setCellValue("F" . $count, "");


        // foreach ($result as $row) {
        //     $sheet->setCellValue("A" . $count, $row->name);
        //     $sheet->setCellValue("B" . $count, $row->phone);
        //     $sheet->setCellValue("C" . $count, $row->email);
        //     $sheet->setCellValue("D" . $count, $row->address);
        //     $sheet->setCellValue("E" . $count, $row->postalZip);
        //     $sheet->setCellValue("F" . $count, $row->region);
        //     $sheet->setCellValue("G" . $count, $row->country);
        //     $sheet->setCellValue("H" . $count, $row->id);
        //     $count++;
        // }

        $writer = new Xlsx($spreadsheet);
        $writer->save("data.xlsx");
        return $this->response->download("data.xlsx", null)->setFileName("TEMPLATE FIELD VALUE.xlsx");
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
                <hr>
                 <table id="example5" class="table table-sm table-bordered table-striped">
                 <thead>
                         <tr>  
                             <th>Nama</th>
                             <th>Value</th>
                             <th>Desc</th>
                             <th>Hidden</th>
                             <th>Delete</th>
                             <th>Order</th>
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
                             </tr>';
                } else {
                    if (count($sheetData) > 1) {
                        $kosong = 0;
                        for ($i = 1; $i < count($sheetData); $i++) {

                            $nama = $sheetData[$i][0];
                            $value = $sheetData[$i][1];
                            $desc = $sheetData[$i][2];
                            $hiddenfield = $sheetData[$i][3];
                            $deleted = $sheetData[$i][4];
                            $orderby = $sheetData[$i][5];

                            // $role_code_td = (!empty($role_code)) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            // $menu_code_td = (!empty($menu_code)) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            // $insert_td = (!empty($insert)) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            // $update_td = (!empty($update)) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            // $delete_td = (!empty($delete)) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            // $view_td = (!empty($view)) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            // $print_td = (!empty($print)) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            // $export_td = (!empty($export)) ? "" : " style='background: #E07171;'"; // Jika data kosong,

                            $nama_td = ($nama !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            $value_td = ($value !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            $desc_td = ($desc !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            $hiddenfield_td = ($hiddenfield !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            $deleted_td = ($deleted !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            $orderby_td = ($orderby !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,



                            // Jika salah satu data ada yang kosong
                            if ($nama == "" or $value == "" or $desc == "" or $hiddenfield == "" or $deleted == "" or $orderby == "") {
                                $kosong++; // Tambah 1 variabel $kosong
                            }

                            $output .= '  
                            <tr id="addMdlBarang" data-id="">
                                <td ' . $nama_td . '>' . $nama . '</td>
                                <td ' . $value_td . '>' . $value . '</td>
                                <td ' . $desc_td . '>' . $desc . '</td>
                                <td ' . $hiddenfield_td . '><span class="right badge ' . ($hiddenfield == 1 ? 'badge-info' : 'badge-warning') . '">' . ($hiddenfield == 1 ? "Ya" : "Tidak") . '</span></td>
                                <td ' . $deleted_td . '><span class="right badge ' . ($deleted == 1 ? 'badge-info' : 'badge-warning') . '">' . ($deleted == 1 ? "Ya" : "Tidak") . '</span></td>
                                <td ' . $orderby_td . '><span class="right badge ' . ($orderby == 1 ? 'badge-info' : 'badge-warning') . '">' . ($orderby == 1 ? "Ya" : "Tidak") . '</span></td>
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
                             targets: 5
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
                                $.post("' . site_url('fieldvalue/upload') . '", {

                                })
                                .done(function(response) {
                                    alert("done");
                                    fieldvalue();
                                    $("#modalimport").modal("hide");
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
                    $nama = $sheetData[$i][0];
                    $value = $sheetData[$i][1];
                    $desc = $sheetData[$i][2];
                    $hiddenfield = $sheetData[$i][3];
                    $deleted = $sheetData[$i][4];
                    $orderby = $sheetData[$i][5];


                    // helper curl request
                    helper(['restclient']);
                    // endpoint
                    $url = "$this->server/tfield_value/insert";

                    $data = [
                        'fld_nm' => $nama,
                        'fld_valu' => $value,
                        'fld_desc' => $desc,
                        'hiddenfield' => $hiddenfield,
                        'deleted' => $deleted,
                        'orderby' => $orderby,
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
