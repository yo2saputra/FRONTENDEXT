<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as excel;


class Tdocnumsetting extends BaseController
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

        $this->data['cb_role'] = getDropdownRole2('name', 'Role', 2, 4); // (id,Label,label size, input size)
        $this->data['cb_menu'] = getDropdownMenu2('menu_cd', 'Menu', 2, 4);

        return view('tdocnumsetting/index', $this->data);
    }

    public function apiDataGetAll()
    {

        // helper curl request
        helper(['restclient']);
        // endpoint
        $url = "$this->server/tdocnumsetting/getall";
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
                                <th>Description</th>
                                <th>Prefix</th>
                                <th>Leading Prefix</th>
                                <th>Leading Zero</th>
                                <th>Leading Month</th>
                                <th>Leading Year</th>
                                <th>Restart Month</th>
                                <th>Restart Year</th>
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
                                </tr>';
            } else {
                for ($a = 0; $a < count($data); $a++) {
                    $output .= '  
                            <tr id="addMdlBarang" data-id="' . $data[$a]["name"] . '">
                                <td >' . $data[$a]["name"] . '</td>
                                <td >' . $data[$a]["docnum_description"] . '</td>
                                <td >' . $data[$a]["prefix"] . '</td>
                                <td ><span class="right badge ' . ($data[$a]['leadingprefix'] == 1 ? 'badge-info' : 'badge-warning') . '">' . ($data[$a]["leadingprefix"] == 1 ? "Ya" : "Tidak") . '</span></td>
                                <td ><span class="right badge ' . ($data[$a]['leadingzero'] == 1 ? 'badge-info' : 'badge-warning') . '">' . ($data[$a]["leadingzero"] == 1 ? "Ya" : "Tidak") . '</span></td>
                                <td ><span class="right badge ' . ($data[$a]['leadingmonth'] == 1 ? 'badge-info' : 'badge-warning') . '">' . ($data[$a]["leadingmonth"] == 1 ? "Ya" : "Tidak") . '</span></td>
                                <td ><span class="right badge ' . ($data[$a]['leadingyear'] == 1 ? 'badge-info' : 'badge-warning') . '">' . ($data[$a]["leadingyear"] == 1 ? "Ya" : "Tidak") . '</span></td>
                                <td ><span class="right badge ' . ($data[$a]['restart_month'] == 1 ? 'badge-info' : 'badge-warning') . '">' . ($data[$a]["restart_month"] == 1 ? "Ya" : "Tidak") . '</span></td>
                                <td ><span class="right badge ' . ($data[$a]['restart_year'] == 1 ? 'badge-info' : 'badge-warning') . '">' . ($data[$a]["restart_year"] == 1 ? "Ya" : "Tidak") . '</span></td>
                                <td class="text-center">
                                    
                                    <div class="btn-group">
                                    <a data-toggle="tooltip" data-placement="top" title="View" class="btn btn-sm btn-info view ' . ($this->session->get("flag_delete") === 1 ? "" : "d-none") . '" data-name="' . $data[$a]["name"] . '"><i class="fas fa-eye"></i></a>
                                    <a data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-sm btn-primary edit ' . ($this->session->get("flag_update") === 1 ? "" : "d-none") . '" data-name="' . $data[$a]["name"] . '"><i class="fas fa-tags"></i></a>
                                    <a data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-sm btn-danger delete ' . ($this->session->get("flag_insert") === 1 ? "" : "d-none") . '" data-name="' . $data[$a]["name"] . '"><i class="fas fa-trash"></i></a>
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
                        targets: 9
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
                        { text: "Excel",extend: "excel", className: "btn-sm btn-primary ' . ($this->session->get("flag_export") === 1 ? "" : "d-none") . '", exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8]} },
                        { text: "Cetak",extend: "print", className: "btn-sm btn-info ' . ($this->session->get("flag_print") === 1 ? "" : "d-none") . '", exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8]} },
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
            $name = $this->request->getVar('name');

            // helper curl request
            helper(['restclient']);
            // endpoint
            $url = "$this->server/tdocnumsetting/delete/$name";

            // client request
            $response = akses_restapi('DELETE', $url, []);
            $data['response_data'] = json_decode($response, true);

            $msg = [
                'success' => "Data dengan nama $name berhasil dihapus"
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
                    'name' => [
                        'label' => 'Name',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'docnum_description' => [
                        'label' => 'Description',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ]
                    // ,
                    // 'prefix' => [
                    //     'label' => 'Prefix',
                    //     'rules' => 'required',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ]
                    // ,
                    // 'orderby' => [
                    //     'label' => 'Order By',
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
                            'name' => $validation->getError('name'),
                            'docnum_description' => $validation->getError('docnum_description'),
                            'prefix' => $validation->getError('prefix'),
                            'leadingprefix' => $validation->getError('leadingprefix'),
                            'leadingzero' => $validation->getError('leadingzero'),
                            'leadingmonth' => $validation->getError('leadingmonth'),
                            'leadingyear' => $validation->getError('leadingyear'),
                            'restart_month' => $validation->getError('restart_month'),
                            'restart_year' => $validation->getError('restart_year')
                        ]
                    ];
                } else {

                    if ($this->request->getVar('action') == 'Add') {

                        // helper curl request
                        helper(['restclient']);
                        // endpoint
                        $url = "$this->server/tdocnumsetting/insert";
                        // form params
                        $data = [
                            "name" => str_replace(" ", "_", trim($this->request->getVar('name'))),
                            "docnum_description" => $this->request->getVar('docnum_description'),
                            "prefix" => $this->request->getVar('prefix'),
                            "leadingprefix" => ($this->request->getVar('leadingprefix') == FALSE) ? 0 : 1,
                            "leadingzero" => ($this->request->getVar('leadingzero') == FALSE) ? 0 : 1,
                            "leadingmonth" => ($this->request->getVar('leadingmonth') == FALSE) ? 0 : 1,
                            "leadingyear" => ($this->request->getVar('leadingyear') == FALSE) ? 0 : 1,
                            "restart_month" => ($this->request->getVar('restart_month') == FALSE) ? 0 : 1,
                            "restart_year" => ($this->request->getVar('restart_year') == FALSE) ? 0 : 1,
                            "startwith" => $this->request->getVar('startwith'),
                            "increment" => $this->request->getVar('increment'),
                            "minvalue" => $this->request->getVar('minvalue'),
                            "maxvalue" => $this->request->getVar('maxvalue')
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
                        // $url = "$this->server/tdocnumsetting/update/$name/$hapusaja";
                        $url = "$this->server/tdocnumsetting/update";
                        // form params
                        $data = [
                            "name" => $this->request->getVar('name'),
                            "docnum_description" => $this->request->getVar('docnum_description'),
                            "prefix" => $this->request->getVar('prefix'),
                            "leadingprefix" => ($this->request->getVar('leadingprefix') == FALSE) ? 0 : 1,
                            "leadingzero" => ($this->request->getVar('leadingzero') == FALSE) ? 0 : 1,
                            "leadingmonth" => ($this->request->getVar('leadingmonth') == FALSE) ? 0 : 1,
                            "leadingyear" => ($this->request->getVar('leadingyear') == FALSE) ? 0 : 1,
                            "restart_month" => ($this->request->getVar('restart_month') == FALSE) ? 0 : 1,
                            "restart_year" => ($this->request->getVar('restart_year') == FALSE) ? 0 : 1
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

        $name = $this->request->getVar('name');

        if ($name) {

            // helper curl request
            helper(['restclient']);
            // end point
            $url = "$this->server/tdocnumsetting/getby/$name";
            // client request
            $response = akses_restapi('GET', $url, []);
            $data['response_data'] = json_decode($response, true);


            $msg = [
                'data' => [
                    'name' => $data["response_data"][0]["name"],
                    'docnum_description' => $data["response_data"][0]["docnum_description"],
                    'prefix' => $data["response_data"][0]["prefix"],
                    'leadingprefix' => $data["response_data"][0]["leadingprefix"],
                    'leadingzero' => $data["response_data"][0]["leadingzero"],
                    'leadingmonth' => $data["response_data"][0]["leadingmonth"],
                    'leadingyear' => $data["response_data"][0]["leadingyear"],
                    'restart_month' => $data["response_data"][0]["restart_month"],
                    'restart_year' => $data["response_data"][0]["restart_year"],
                    'start_value' => $data["response_data"][0]["start_value"],
                    'increment' => $data["response_data"][0]["increment"],
                    'minimum_value' => $data["response_data"][0]["minimum_value"],
                    'maximum_value' => $data["response_data"][0]["maximum_value"],
                ]
            ];

            echo json_encode($msg);
        }
        // } else {
        //     exit('Maaf tidak dapat diproses!');
        // }
    }

    function fetchSingleDataPrint($name)
    {

        if ($name) {

            // helper curl request
            helper(['restclient']);
            // end point
            $url = "$this->server/tdocnumsetting/getby/$name";
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

        $sheet->setCellValue("A1", "ROLE CODE");
        $sheet->setCellValue("B1", "MENU CODE");
        $sheet->setCellValue("C1", "INSERT");
        $sheet->setCellValue("D1", "UPDATE");
        $sheet->setCellValue("E1", "DELETE");
        $sheet->setCellValue("F1", "VIEW");
        $sheet->setCellValue("G1", "PRINT");
        $sheet->setCellValue("H1", "EXPORT");
        $count = 2;

        $sheet->setCellValue("A" . $count, "");
        $sheet->setCellValue("B" . $count, "");
        $sheet->setCellValue("C" . $count, "");
        $sheet->setCellValue("D" . $count, "");
        $sheet->setCellValue("E" . $count, "");
        $sheet->setCellValue("F" . $count, "");
        $sheet->setCellValue("G" . $count, "");
        $sheet->setCellValue("H" . $count, "");


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
        return $this->response->download("data.xlsx", null)->setFileName("TEMPLATE MENUROLE.xlsx");
    }

    // public function upload()
    // {
    //     // $model = new CommonModel();
    //     if ($this->request->getMethod() == "post") {
    //         $rules = $this->validate([
    //             'filename' => 'uploaded[filename]|max_size[filename,500]|ext_in[filename,csv,xlsx]',
    //         ]);
    //         if ($rules == true) {
    //             $filename =  $this->request->getFile('filename');
    //             $name = $filename->getName();
    //             $tempName = $filename->getTempName();
    //             $arr_file = explode(".", $name);
    //             $extension = end($arr_file);
    //             if ('csv' == $extension) {
    //                 $reader = new Csv();
    //             } else {
    //                 $reader = new excel();
    //             }
    //             $spreadsheet = $reader->load($tempName);
    //             $sheetData = $spreadsheet->getActiveSheet()->toArray();
    //             if (!empty($sheetData)) {
    //                 for ($i = 1; $i < count($sheetData); $i++) {
    //                     $name = $sheetData[$i][0];
    //                     $hapusaja = $sheetData[$i][1];
    //                     $leadingprefix = $sheetData[$i][2];
    //                     $leadingzero = $sheetData[$i][3];
    //                     $leadingmonth = $sheetData[$i][4];
    //                     $leadingyear = $sheetData[$i][5];
    //                     $restart_month = $sheetData[$i][6];
    //                     $restart_year = $sheetData[$i][7];
    //                     // $id = $sheetData[$i][7];

    //                     // helper curl request
    //                     helper(['restclient']);
    //                     // endpoint
    //                     $url = "$this->server/tdocnumsetting/insert";

    //                     $data = [
    //                         'name' => $name,
    //                         'hapusaja' => $hapusaja,
    //                         'leadingprefix' => $leadingprefix,
    //                         'leadingzero' => $leadingzero,
    //                         'leadingmonth' => $leadingmonth,
    //                         'leadingyear' => $leadingyear,
    //                         'restart_month' => $restart_month,
    //                         'restart_year' => $restart_year,
    //                     ];

    //                     // client request
    //                     $response = akses_restapi('POST', $url, $data);

    //                     $msg = [
    //                         'success' => 'data berhasil di create!'
    //                     ];

    //                     // $fetchSingleData = $model->selectRow($id);

    //                     // if (!empty($fetchSingleData)) {
    //                     //     $model->updateValue($id, $data);
    //                     // } else {
    //                     //     $model->insertValue($data);
    //                     // }
    //                 }

    //                 return redirect()->to(site_url("/"));
    //             } else {
    //                 return view("upload");
    //             }
    //         } else {
    //             return view("upload");
    //         }
    //     } else {
    //         return view("upload");
    //     }
    // }

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
                             <th>Role Code</th>
                             <th>Menu Code</th>
                             <th>Insert</th>
                             <th>Update</th>
                             <th>Delete</th>
                             <th>View</th>
                             <th>Print</th>
                             <th>Export</th>
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

                            $role_code = $sheetData[$i][0];
                            $menu_code = $sheetData[$i][1];
                            $insert = $sheetData[$i][2];
                            $update = $sheetData[$i][3];
                            $delete = $sheetData[$i][4];
                            $view = $sheetData[$i][5];
                            $print = $sheetData[$i][6];
                            $export = $sheetData[$i][7];

                            // $role_code_td = (!empty($role_code)) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            // $menu_code_td = (!empty($menu_code)) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            // $insert_td = (!empty($insert)) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            // $update_td = (!empty($update)) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            // $delete_td = (!empty($delete)) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            // $view_td = (!empty($view)) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            // $print_td = (!empty($print)) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            // $export_td = (!empty($export)) ? "" : " style='background: #E07171;'"; // Jika data kosong,

                            $role_code_td = ($role_code !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            $menu_code_td = ($menu_code !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            $insert_td = ($insert !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            $update_td = ($update !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            $delete_td = ($delete !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            $view_td = ($view !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            $print_td = ($print !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,
                            $export_td = ($export !== null) ? "" : " style='background: #E07171;'"; // Jika data kosong,


                            // Jika salah satu data ada yang kosong
                            if ($role_code == "" or $menu_code == "" or $insert == "" or $update == "" or $delete == "" or $view == "" or $print == "" or $export == "") {
                                $kosong++; // Tambah 1 variabel $kosong
                            }

                            $output .= '  
                            <tr id="addMdlBarang" data-id="' . $role_code . '">
                                <td ' . $role_code_td . '>' . $role_code . '</td>
                                <td ' . $menu_code_td . '>' . $menu_code . '</td>
                                <td ' . $insert_td . '><span class="right badge ' . ($insert == 1 ? 'badge-info' : 'badge-warning') . '">' . ($insert == 1 ? "Ya" : "Tidak") . '</span></td>
                                <td ' . $update_td . '><span class="right badge ' . ($update == 1 ? 'badge-info' : 'badge-warning') . '">' . ($update == 1 ? "Ya" : "Tidak") . '</span></td>
                                <td ' . $delete_td . '><span class="right badge ' . ($delete == 1 ? 'badge-info' : 'badge-warning') . '">' . ($delete == 1 ? "Ya" : "Tidak") . '</span></td>
                                <td ' . $view_td . '><span class="right badge ' . ($view == 1 ? 'badge-info' : 'badge-warning') . '">' . ($view == 1 ? "Ya" : "Tidak") . '</span></td>
                                <td ' . $print_td . '><span class="right badge ' . ($print == 1 ? 'badge-info' : 'badge-warning') . '">' . ($print == 1 ? "Ya" : "Tidak") . '</span></td>
                                <td ' . $export_td . '><span class="right badge ' . ($export == 1 ? 'badge-info' : 'badge-warning') . '">' . ($export == 1 ? "Ya" : "Tidak") . '</span></td>
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
                             targets: 7
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
                                $.post("' . site_url('tdocnumsetting/upload') . '", {

                                })
                                .done(function(response) {
                                    alert("done");
                                    $("#modalimport").modal("hide");
                                    tdocnumsetting();
                                    // console.log("Data Loaded: " + response);
                                })
                                .fail(function(error) {
                                    alert("error");
                                    // console.error("Error: " + error);
                                });
                            },
                            attr: {
                                id: "postButton",
                                style: "background-color:#56b746;' . ($this->session->get("leadingprefix") === 1 ? "" : "display:none;") . '",
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
                    $name = $sheetData[$i][0];
                    $docnum_description = $sheetData[$i][1];
                    $leadingprefix = $sheetData[$i][2];
                    $leadingzero = $sheetData[$i][3];
                    $leadingmonth = $sheetData[$i][4];
                    $leadingyear = $sheetData[$i][5];
                    $restart_month = $sheetData[$i][6];
                    $restart_year = $sheetData[$i][7];
                    // $id = $sheetData[$i][7];

                    // helper curl request
                    helper(['restclient']);
                    // endpoint
                    $url = "$this->server/tdocnumsetting/insert";

                    $data = [
                        'name' => $name,
                        'docnum_description' => $docnum_description,
                        'leadingprefix' => $leadingprefix,
                        'leadingzero' => $leadingzero,
                        'leadingmonth' => $leadingmonth,
                        'leadingyear' => $leadingyear,
                        'restart_month' => $restart_month,
                        'restart_year' => $restart_year,
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

    public function upload2()
    {
        // $model = new CommonModel();
        if ($this->request->getMethod() == "post") {
            $rules = $this->validate([
                'filename' => 'uploaded[filename]|max_size[filename,500]|ext_in[filename,csv,xlsx]',
            ]);
            if ($rules == true) {
                $filename =  $this->request->getFile('filename');
                $name = $filename->getName();
                $tempName = $filename->getTempName();
                //
                // $filename = WRITEPATH . 'uploads/' . $file->getName(); // Simpan file di folder uploads
                // move_uploaded_file($tmpFilePath, $filename);
                //
                $arr_file = explode(".", $name);
                $extension = end($arr_file);
                if ('csv' == $extension) {
                    $reader = new Csv();
                } else {
                    $reader = new excel();
                }
                $spreadsheet = $reader->load($tempName);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();
                if (!empty($sheetData)) {
                    for ($i = 1; $i < count($sheetData); $i++) {
                        $name = $sheetData[$i][0];
                        $docnum_description = $sheetData[$i][1];
                        $leadingprefix = $sheetData[$i][2];
                        $leadingzero = $sheetData[$i][3];
                        $leadingmonth = $sheetData[$i][4];
                        $leadingyear = $sheetData[$i][5];
                        $restart_month = $sheetData[$i][6];
                        $restart_year = $sheetData[$i][7];
                        // $id = $sheetData[$i][7];

                        // helper curl request
                        helper(['restclient']);
                        // endpoint
                        $url = "$this->server/tdocnumsetting/insert";

                        $data = [
                            'name' => $name,
                            'docnum_description' => $docnum_description,
                            'leadingprefix' => $leadingprefix,
                            'leadingzero' => $leadingzero,
                            'leadingmonth' => $leadingmonth,
                            'leadingyear' => $leadingyear,
                            'restart_month' => $restart_month,
                            'restart_year' => $restart_year,
                        ];

                        // client request
                        $response = akses_restapi('POST', $url, $data);

                        // $fetchSingleData = $model->selectRow($id);

                        // if (!empty($fetchSingleData)) {
                        //     $model->updateValue($id, $data);
                        // } else {
                        //     $model->insertValue($data);
                        // }
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

                // Tampilkan data dalam bentuk tabel (dalam format JSON)
                // return $this->response->setJSON($sheetData);
            } else {
                // return view("upload");

                return $this->response->setStatusCode(400)->setJSON(['error' => 'File yang diunggah harus berformat .xlsx']);
            }
        } else {
            return view("upload");
        }
    }
}
