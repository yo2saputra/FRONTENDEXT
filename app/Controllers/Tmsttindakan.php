<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as excel;

class Tmsttindakan extends BaseController
{

    protected $data;
    protected $server;
    protected $server3;
    protected $client;

    public function __construct()
    {
        $this->server3 = $_ENV['APP_API3'];
    }

    public function index()
    {
        helper(['dropdown']);

        $this->data['cb_subUnit'] = getDropdownCustom('subUnit_ID', 'subUnit_ID', 'Sub Unit', 2, 4);
        $this->data['cb_available_disc'] = getDropdownCustom('available_Disc', 'available_Disc', 'Available Disc', 2, 4);
        return view('tmsttindakan/index', $this->data);
    }

    public function datatables()
    {
        helper(['restclient']);
        $rawBody = $this->request->getBody();
        $json = json_decode($rawBody, true);

        $url = "{$this->server3}/api/mi-tindakan/datatables";
        $response = akses_restapikey('POST', $url, $json);
        $result = json_decode($response, true);

        foreach ($result['data'] as $i => &$row) {
            $id = $row['tindakan_ID'];
            $row['rownum'] = $i + ($json['start'] ?? 0) + 1;
            $row['aksi'] = '
            <div class="btn-group">
                <a class="btn btn-sm btn-info view ' . ($this->session->get("flag_view") === 1 ? "" : "d-none") . '" data-tindakan_id="' . $id . '"><i class="fas fa-eye"></i></a>
                <a class="btn btn-sm btn-primary edit ' . ($this->session->get("flag_update") === 1 ? "" : "d-none") . '" data-tindakan_id="' . $id . '"><i class="fas fa-tags"></i></a>
                <a class="btn btn-sm btn-danger delete ' . ($this->session->get("flag_delete") === 1 ? "" : "d-none") . '" data-tindakan_id="' . $id . '"><i class="fas fa-trash"></i></a>
            </div>';
        }

        return $this->response->setJSON($result);
    }

    public function apiDataGetAll()
    {
        helper(['restclient']);

        $url = "{$this->server3}/api/mi-tindakan";

        $query = [
            'action' => 'getall',
            'tindakanId' => ''
        ];

        $response = akses_restapikey('GET', $url, $body = [], $query);
        $data = json_decode($response, true);

        return $data["data"];
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $tindakan_id = $this->request->getVar('tindakan_id');

            helper(['restclient']);

            $url = "{$this->server3}/api/mi-tindakan/{$tindakan_id}";
            $query = [];

            $result = akses_restapikey('DELETE', $url, $body = [], $query);

            $result = is_string($result) ? json_decode($result, true) : $result;

            if (isset($result['success']) && $result['success'] === true) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => $result['message'] ?? 'Data tindakan berhasil dihapus',
                    'data' => $result
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $result['message'] ?? 'Gagal menghapus data',
                    'errors' => $result['errors'] ?? null
                ]);
            }
        }
    }

    function action()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getVar('action')) {
                helper(['form', 'url']);

                $validation = \Config\Services::validation();
                $valid = $this->validate([
                    'tindakan_Name' => [
                        'label' => 'Nama Tindakan',
                        'rules' => 'required',
                        'errors' => []
                    ],
                    'subUnit_ID' => [
                        'label' => 'Sub Unit',
                        'rules' => 'required',
                        'errors' => []
                    ],
                    'available_Disc' => [
                        'label' => 'Available Disc',
                        'rules' => 'required',
                        'errors' => []
                    ],
                    'overide_GL' => [
                        'label' => 'Override GL',
                        'rules' => 'required',
                        'errors' => []
                    ],
                    'segment_No' => [
                        'label' => 'Segment No',
                        'rules' => 'required',
                        'errors' => []
                    ],
                    'segment_Value' => [
                        'label' => 'Segment Value',
                        'rules' => 'required',
                        'errors' => []
                    ]
                ]);

                if (!$valid) {
                    return $this->response->setJSON([
                        'error' => [
                            'tindakan_ID'    => $validation->getError('tindakan_ID'),
                            'tindakan_Name'  => $validation->getError('tindakan_Name'),
                            'subUnit_ID'     => $validation->getError('subUnit_ID'),
                            'available_Disc' => $validation->getError('available_Disc'),
                            'overide_GL'     => $validation->getError('overide_GL'),
                            'segment_No'     => $validation->getError('segment_No'),
                            'segment_Value'  => $validation->getError('segment_Value'),
                        ]
                    ]);
                } else {

                    if ($this->request->getVar('action') == 'Add') {

                        helper(['restclient']);

                        $url = "{$this->server3}/api/mi-tindakan";

                        $body = [
                            "tindakan_ID"    => str_replace(" ", "_", trim($this->request->getVar('tindakan_ID'))),
                            "tindakan_Name"  => $this->request->getVar('tindakan_Name'),
                            "subUnit_ID"     => $this->request->getVar('subUnit_ID'),
                            "available_Disc" => $this->request->getVar('available_Disc'),
                            "overide_GL"     => (int) $this->request->getVar('overide_GL'),
                            "segment_No"     => (int) $this->request->getVar('segment_No'),
                            "segment_Value"  => (float) $this->request->getVar('segment_Value'),
                        ];

                        $result = akses_restapikey('POST', $url, $body, $query = []);
                        $result = is_string($result) ? json_decode($result, true) : $result;

                        if (isset($result['success']) && $result['success'] === true) {
                            return $this->response->setJSON([
                                'status' => 'success',
                                'message' => 'Data tindakan berhasil ditambahkan',
                                'data' => $result
                            ]);
                        } else {
                            return $this->response->setJSON([
                                'status' => 'error',
                                'message' => $result['message'] ?? 'Gagal menambahkan data',
                                'errors' => $result['errors'] ?? null
                            ]);
                        }
                    }

                    if ($this->request->getVar('action') == 'Edit') {

                        helper(['restclient']);

                        $tindakan_id = str_replace(" ", "_", trim($this->request->getVar('tindakan_ID')));
                        $url = "{$this->server3}/api/mi-tindakan/{$tindakan_id}";

                        $body = [
                            "tindakan_Name"  => $this->request->getVar('tindakan_Name'),
                            "subUnit_ID"     => $this->request->getVar('subUnit_ID'),
                            "available_Disc" => $this->request->getVar('available_Disc'),
                            "overide_GL"     => (int) $this->request->getVar('overide_GL'),
                            "segment_No"     => (int) $this->request->getVar('segment_No'),
                            "segment_Value"  => (float) $this->request->getVar('segment_Value'),
                        ];

                        $result = akses_restapikey('PUT', $url, $body, $query = []);
                        $result = is_string($result) ? json_decode($result, true) : $result;

                        if (isset($result['success']) && $result['success'] === true) {
                            return $this->response->setJSON([
                                'status' => 'success',
                                'message' => 'Data tindakan berhasil diubah',
                                'data' => $result
                            ]);
                        } else {
                            return $this->response->setJSON([
                                'status' => 'error',
                                'message' => $result['message'] ?? 'Gagal mengubah data',
                                'errors' => $result['errors'] ?? null
                            ]);
                        }
                    }
                }
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    function fetchSingleData()
    {
        if ($this->request->isAJAX()) {

            $tindakan_id = $this->request->getVar('tindakan_id');

            if ($tindakan_id) {

                helper(['restclient']);

                $url = "{$this->server3}/api/mi-tindakan/{$tindakan_id}";

                $response = akses_restapikey('GET', $url, $body = [], $query = []);
                $data = json_decode($response, true);

                $msg = [
                    'data' => [
                        'tindakan_ID'    => $data["data"][0]["tindakan_ID"]    ?? $data["data"]["tindakan_ID"]    ?? '',
                        'tindakan_Name'  => $data["data"][0]["tindakan_Name"]  ?? $data["data"]["tindakan_Name"]  ?? '',
                        'subUnit_ID'     => $data["data"][0]["subUnit_ID"]     ?? $data["data"]["subUnit_ID"]     ?? '',
                        'available_Disc' => $data["data"][0]["available_Disc"] ?? $data["data"]["available_Disc"] ?? '',
                        'overide_GL'     => $data["data"][0]["overide_GL"]     ?? $data["data"]["overide_GL"]     ?? '',
                        'segment_No'     => $data["data"][0]["segment_No"]     ?? $data["data"]["segment_No"]     ?? '',
                        'segment_Value'  => $data["data"][0]["segment_Value"]  ?? $data["data"]["segment_Value"]  ?? '',
                    ]
                ];

                echo json_encode($msg);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    function fetchSingleDataPrint($tindakan_id)
    {
        if ($tindakan_id) {

            helper(['restclient']);

            $url = "{$this->server3}/api/mi-tindakan/{$tindakan_id}";

            $response = akses_restapikey('GET', $url, $body = [], $query = []);
            $data['response_data'] = json_decode($response, true);

            $pdf_data = $data['response_data'];
            $pdf_name = 'Single Data Tindakan';
            $pdf_title = 'Data Tindakan';
            $pdf_paper = 'A4';
            $pdf_orientation = 'portrait';
            $pdf_format = 'laporan_pdf';

            $this->view_pdf($pdf_name, $pdf_title, $pdf_data, $pdf_paper, $pdf_orientation, $pdf_format);
        }
    }

    public function view_pdf($pdf_name, $pdf_title, $pdf_data, $pdf_paper, $pdf_orientation, $pdf_format)
    {
        $Pdfgenerator = new Pdfgenerator();

        $file_pdf = $pdf_name;
        $this->data['title_pdf'] = $pdf_title;
        $this->data['produk'] = $pdf_data;

        $paper = $pdf_paper;
        $orientation = $pdf_orientation;

        $html = view($pdf_format, $this->data);
        $Pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    }

    public function download()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue("A1", "KODE");
        $sheet->setCellValue("B1", "NAMA TINDAKAN");
        $sheet->setCellValue("C1", "SUB UNIT ID");
        $sheet->setCellValue("D1", "AVAILABLE DISC");
        $sheet->setCellValue("E1", "OVERRIDE GL");
        $sheet->setCellValue("F1", "SEGMENT NO");
        $sheet->setCellValue("G1", "SEGMENT VALUE");

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
        return $this->response->download("data.xlsx", null)->setFileName("TEMPLATE TINDAKAN.xlsx");
    }

    public function preview()
    {
        if ($this->request->getMethod() == "post") {
            $rules = $this->validate([
                'filename' => 'uploaded[filename]|max_size[filename,500]|ext_in[filename,csv,xlsx]',
            ]);
            if ($rules == true) {
                $filename = $this->request->getFile('filename');
                $path = WRITEPATH . 'uploads/';
                $filename->move($path, $filename->getName());
                $this->session->set("fileupload", $path . "" . $filename->getName());
            } else {
                return $this->response->setStatusCode(400)->setJSON(['error' => 'File yang diunggah harus berformat .xlsx']);
            }
        } else {

            if ($this->session->get("fileupload") !== '') {

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
                 <table id="exampleImport" class="table table-sm table-bordered table-striped">
                 <thead>
                         <tr>
                             <th>Kode</th>
                             <th>Nama Tindakan</th>
                             <th>Sub Unit ID</th>
                             <th>Available Disc</th>
                             <th>Override GL</th>
                             <th>Segment No</th>
                             <th>Segment Value</th>
                         </tr>
                     </thead>
                         ';
                if (empty($sheetData)) {
                    $output .= '<tr>
                                 <td>Data not Found</td>
                                 <td></td><td></td><td></td><td></td><td></td><td></td>
                             </tr>';
                } else {
                    if (count($sheetData) > 1) {
                        $kosong = 0;
                        for ($i = 1; $i < count($sheetData); $i++) {

                            $tindakan_ID    = $sheetData[$i][0];
                            $tindakan_Name  = $sheetData[$i][1];
                            $subUnit_ID     = $sheetData[$i][2];
                            $available_Disc = $sheetData[$i][3];
                            $overide_GL     = $sheetData[$i][4];
                            $segment_No     = $sheetData[$i][5];
                            $segment_Value  = $sheetData[$i][6];

                            $td0 = ($tindakan_ID    !== null) ? "" : " style='background: #E07171;'";
                            $td1 = ($tindakan_Name  !== null) ? "" : " style='background: #E07171;'";
                            $td2 = ($subUnit_ID     !== null) ? "" : " style='background: #E07171;'";
                            $td3 = ($available_Disc !== null) ? "" : " style='background: #E07171;'";
                            $td4 = ($overide_GL     !== null) ? "" : " style='background: #E07171;'";
                            $td5 = ($segment_No     !== null) ? "" : " style='background: #E07171;'";
                            $td6 = ($segment_Value  !== null) ? "" : " style='background: #E07171;'";

                            if ($tindakan_ID == "" || $tindakan_Name == "" || $subUnit_ID == "" || $available_Disc == "" || $overide_GL == "" || $segment_No == "" || $segment_Value == "") {
                                $kosong++;
                            }

                            $output .= '
                            <tr data-id="' . $tindakan_ID . '">
                                <td ' . $td0 . '>' . $tindakan_ID . '</td>
                                <td ' . $td1 . '>' . $tindakan_Name . '</td>
                                <td ' . $td2 . '>' . $subUnit_ID . '</td>
                                <td ' . $td3 . '>' . $available_Disc . '</td>
                                <td ' . $td4 . '>' . $overide_GL . '</td>
                                <td ' . $td5 . '>' . $segment_No . '</td>
                                <td ' . $td6 . '>' . $segment_Value . '</td>
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
                     $("#exampleImport").DataTable({
                         columnDefs: [{ orderable: false, targets: 6 }],
                         "responsive": true,
                         "lengthChange": false,
                         "autoWidth": false,
                         "buttons": [{
                            text: "Import",
                            action: function(e, dt, node, config) {
                                $.post("' . site_url('tmsttindakan/upload') . '", {})
                                .done(function(response) {
                                    Swal.fire({ icon: "success", title: "Berhasil", text: "Data berhasil diimport." });
                                    $("#modalimport").modal("hide");
                                    $("#tindakanTable").DataTable().ajax.reload(null, false);
                                })
                                .fail(function(error) {
                                    Swal.fire({ icon: "error", title: "Gagal", text: "Terjadi kesalahan saat mengimport data." });
                                });
                            },
                            attr: {
                                id: "postButton",
                                style: "background-color:#56b746;' . ($this->session->get("flag_insert") === 1 ? "" : "display:none;") . '",
                                name:"postButton",
                                nameClass:"btn-sm"
                            }
                        }],
                         "oLanguage": {
                             "sSearch": "Cari Data:",
                             "sInfoEmpty": "Tidak ada data",
                             "sInfo": "Total: _TOTAL_ data",
                             "sInfoFiltered": " dari _MAX_ data",
                             "sZeroRecords": "Data tidak ditemukan",
                             "oPaginate": { "sFirst": "Awal", "sPrevious": "Sebelum", "sNext": "Berikut", "sLast": "Akhir" },
                         },
                     }).buttons().container().appendTo("#exampleImport_wrapper .col-md-6:eq(0)");
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
                    $tindakan_ID    = $sheetData[$i][0];
                    $tindakan_Name  = $sheetData[$i][1];
                    $subUnit_ID     = $sheetData[$i][2];
                    $available_Disc = $sheetData[$i][3];
                    $overide_GL     = $sheetData[$i][4];
                    $segment_No     = $sheetData[$i][5];
                    $segment_Value  = $sheetData[$i][6];

                    helper(['restclient']);
                    $url = "{$this->server3}/api/mi-tindakan";

                    $body = [
                        "tindakan_ID"    => $tindakan_ID,
                        "tindakan_Name"  => $tindakan_Name,
                        "subUnit_ID"     => $subUnit_ID,
                        "available_Disc" => $available_Disc ?? 'NO',
                        "overide_GL"     => (int) $overide_GL,
                        "segment_No"     => (int) $segment_No,
                        "segment_Value"  => (float) $segment_Value,
                    ];

                    $response = akses_restapikey('POST', $url, $body, $query = []);
                }

                $msg = ['success' => $i . ' data berhasil di import!'];
                return $this->response->setJSON($msg);
            } else {
                return view("upload");
            }
        } else {
            return view("upload");
        }
    }
}