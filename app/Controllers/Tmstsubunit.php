<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as excel;

class Tmstsubunit extends BaseController
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

        $this->data['cb_unit'] = getDropdownCustom('unit_ID', 'unit_ID', 'Unit', 2, 4);
        return view('tmstsubunit/index', $this->data);
    }

    public function datatables()
    {
        helper(['restclient']);
        $rawBody = $this->request->getBody();
        $json = json_decode($rawBody, true);

        $url = "{$this->server3}/api/mi-sub-unit/datatables";
        $response = akses_restapikey('POST', $url, $json);
        $result = json_decode($response, true);

        foreach ($result['data'] as $i => &$row) {
            $id = $row['subUnit_ID'];
            $row['rownum'] = $i + ($json['start'] ?? 0) + 1;
            $row['aksi'] = '
            <div class="btn-group">
                <a class="btn btn-sm btn-info view ' . ($this->session->get("flag_view") === 1 ? "" : "d-none") . '" data-id="' . $id . '"><i class="fas fa-eye"></i></a>
                <a class="btn btn-sm btn-primary edit ' . ($this->session->get("flag_update") === 1 ? "" : "d-none") . '" data-id="' . $id . '"><i class="fas fa-tags"></i></a>
                <a class="btn btn-sm btn-danger delete ' . ($this->session->get("flag_delete") === 1 ? "" : "d-none") . '" data-id="' . $id . '"><i class="fas fa-trash"></i></a>
            </div>';
        }

        return $this->response->setJSON($result);
    }

    public function fetchAll()
    {
        helper(['restclient']);

        $url = "{$this->server3}/api/mi-sub-unit";

        $query = [
            'action'    => 'getall',
            'subUnitId' => ''
        ];

        $response = akses_restapikey('GET', $url, $body = [], $query);
        $data = json_decode($response, true);

        return $this->response->setJSON($data["data"]);
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $subUnit_id = $this->request->getVar('subUnit_id');

            helper(['restclient']);

            $url = "{$this->server3}/api/mi-sub-unit/{$subUnit_id}";

            $result = akses_restapikey('DELETE', $url, $body = [], $query = []);
            $result = is_string($result) ? json_decode($result, true) : $result;

            if (isset($result['success']) && $result['success'] === true) {
                return $this->response->setJSON([
                    'status'  => 'success',
                    'message' => $result['message'] ?? 'Data Sub Unit berhasil dihapus',
                    'data'    => $result
                ]);
            } else {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => $result['message'] ?? 'Gagal menghapus data',
                    'errors'  => $result['errors'] ?? null
                ]);
            }
        }
    }

    public function action()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getVar('action')) {
                helper(['form', 'url']);

                $validation = \Config\Services::validation();
                $valid = $this->validate([
                    'subUnit_ID' => [
                        'label'  => 'Sub Unit ID',
                        'rules'  => 'required',
                        'errors' => []
                    ],
                    'subUnit_Name' => [
                        'label'  => 'Nama Sub Unit',
                        'rules'  => 'required',
                        'errors' => []
                    ],
                    'segment_No' => [
                        'label'  => 'Segment No',
                        'rules'  => 'required',
                        'errors' => []
                    ],
                    'segment_Value' => [
                        'label'  => 'Segment Value',
                        'rules'  => 'required',
                        'errors' => []
                    ],
                    'unit_ID' => [
                        'label'  => 'Unit ID',
                        'rules'  => 'required',
                        'errors' => []
                    ],
                ]);

                if (!$valid) {
                    return $this->response->setJSON([
                        'error' => [
                            'subUnit_ID'   => $validation->getError('subUnit_ID'),
                            'subUnit_Name' => $validation->getError('subUnit_Name'),
                            'segment_No'   => $validation->getError('segment_No'),
                            'segment_Value'=> $validation->getError('segment_Value'),
                            'unit_ID'      => $validation->getError('unit_ID'),
                        ]
                    ]);
                } else {

                    if ($this->request->getVar('action') == 'Add') {

                        helper(['restclient']);

                        $url = "{$this->server3}/api/mi-sub-unit";

                        $body = [
                            "subUnit_ID"   => str_replace(" ", "_", trim($this->request->getVar('subUnit_ID'))),
                            "subUnit_Name" => $this->request->getVar('subUnit_Name'),
                            "segment_No"   => (int) $this->request->getVar('segment_No'),
                            "segment_Value"=> (float) $this->request->getVar('segment_Value'),
                            "unit_ID"      => $this->request->getVar('unit_ID'),
                        ];

                        $result = akses_restapikey('POST', $url, $body, $query = []);
                        $result = is_string($result) ? json_decode($result, true) : $result;

                        if (isset($result['success']) && $result['success'] === true) {
                            return $this->response->setJSON([
                                'status'  => 'success',
                                'message' => 'Data Sub Unit berhasil ditambahkan',
                                'data'    => $result
                            ]);
                        } else {
                            return $this->response->setJSON([
                                'status'  => 'error',
                                'message' => $result['message'] ?? 'Gagal menambahkan data',
                                'errors'  => $result['errors'] ?? null
                            ]);
                        }
                    }

                    if ($this->request->getVar('action') == 'Edit') {

                        helper(['restclient']);

                        $subUnit_id = str_replace(" ", "_", trim($this->request->getVar('subUnit_ID')));
                        $url = "{$this->server3}/api/mi-sub-unit/{$subUnit_id}";

                        $body = [
                            "subUnit_Name" => $this->request->getVar('subUnit_Name'),
                            "segment_No"   => (int) $this->request->getVar('segment_No'),
                            "segment_Value"=> (float) $this->request->getVar('segment_Value'),
                            "unit_ID"      => $this->request->getVar('unit_ID'),
                        ];

                        $result = akses_restapikey('PUT', $url, $body, $query = []);
                        $result = is_string($result) ? json_decode($result, true) : $result;

                        if (isset($result['success']) && $result['success'] === true) {
                            return $this->response->setJSON([
                                'status'  => 'success',
                                'message' => 'Data Sub Unit berhasil diubah',
                                'data'    => $result
                            ]);
                        } else {
                            return $this->response->setJSON([
                                'status'  => 'error',
                                'message' => $result['message'] ?? 'Gagal mengubah data',
                                'errors'  => $result['errors'] ?? null
                            ]);
                        }
                    }
                }
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    public function fetchSingleData()
    {
        if ($this->request->isAJAX()) {

            $subUnit_id = $this->request->getVar('subUnit_id');

            if ($subUnit_id) {

                helper(['restclient']);

                $url = "{$this->server3}/api/mi-sub-unit/{$subUnit_id}";

                $response = akses_restapikey('GET', $url, $body = [], $query = []);
                $data = json_decode($response, true);

                $msg = [
                    'data' => [
                        'subUnit_ID'   => $data["data"][0]["subUnit_ID"]   ?? $data["data"]["subUnit_ID"]   ?? '',
                        'subUnit_Name' => $data["data"][0]["subUnit_Name"] ?? $data["data"]["subUnit_Name"] ?? '',
                        'segment_No'   => $data["data"][0]["segment_No"]   ?? $data["data"]["segment_No"]   ?? '',
                        'segment_Value'=> $data["data"][0]["segment_Value"]?? $data["data"]["segment_Value"]?? '',
                        'unit_ID'      => $data["data"][0]["unit_ID"]      ?? $data["data"]["unit_ID"]      ?? '',
                        'unit_Name'    => $data["data"][0]["unit_Name"]    ?? $data["data"]["unit_Name"]    ?? '',
                    ]
                ];

                echo json_encode($msg);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    public function fetchSingleDataPrint($subUnit_id)
    {
        if ($subUnit_id) {

            helper(['restclient']);

            $url = "{$this->server3}/api/mi-sub-unit/{$subUnit_id}";

            $response = akses_restapikey('GET', $url, $body = [], $query = []);
            $data['response_data'] = json_decode($response, true);

            $pdf_data        = $data['response_data'];
            $pdf_name        = 'Single Data Sub Unit';
            $pdf_title       = 'Data Sub Unit';
            $pdf_paper       = 'A4';
            $pdf_orientation = 'portrait';
            $pdf_format      = 'laporan_pdf';

            $this->view_pdf($pdf_name, $pdf_title, $pdf_data, $pdf_paper, $pdf_orientation, $pdf_format);
        }
    }

    public function view_pdf($pdf_name, $pdf_title, $pdf_data, $pdf_paper, $pdf_orientation, $pdf_format)
    {
        $Pdfgenerator = new Pdfgenerator();

        $file_pdf = $pdf_name;
        $this->data['title_pdf'] = $pdf_title;
        $this->data['produk']    = $pdf_data;

        $html = view($pdf_format, $this->data);
        $Pdfgenerator->generate($html, $file_pdf, $pdf_paper, $pdf_orientation);
    }

    public function download()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue("A1", "SUB UNIT ID");
        $sheet->setCellValue("B1", "NAMA SUB UNIT");
        $sheet->setCellValue("C1", "SEGMENT NO");
        $sheet->setCellValue("D1", "SEGMENT VALUE");
        $sheet->setCellValue("E1", "UNIT ID");

        $count = 2;
        $sheet->setCellValue("A" . $count, "");
        $sheet->setCellValue("B" . $count, "");
        $sheet->setCellValue("C" . $count, "");
        $sheet->setCellValue("D" . $count, "");
        $sheet->setCellValue("E" . $count, "");

        $writer = new Xlsx($spreadsheet);
        $writer->save("data.xlsx");
        return $this->response->download("data.xlsx", null)->setFileName("TEMPLATE SUB UNIT.xlsx");
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

                $arr_file  = explode(".", $this->session->get("fileupload"));
                $extension = end($arr_file);
                if ('csv' == $extension) {
                    $reader = new Csv();
                } else {
                    $reader = new excel();
                }

                $spreadsheet = $reader->load($this->session->get("fileupload"));
                $sheetData   = $spreadsheet->getActiveSheet()->toArray();

                $output = '';
                $output .= '
                <br>
                <table id="exampleImport" class="table table-sm table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Sub Unit ID</th>
                        <th>Nama Sub Unit</th>
                        <th>Segment No</th>
                        <th>Segment Value</th>
                        <th>Unit ID</th>
                    </tr>
                </thead>
                ';
                if (empty($sheetData)) {
                    $output .= '<tr>
                                <td>Data not Found</td>
                                <td></td><td></td><td></td><td></td>
                            </tr>';
                } else {
                    if (count($sheetData) > 1) {
                        $kosong = 0;
                        for ($i = 1; $i < count($sheetData); $i++) {

                            $subUnit_ID   = $sheetData[$i][0];
                            $subUnit_Name = $sheetData[$i][1];
                            $segment_No   = $sheetData[$i][2];
                            $segment_Value= $sheetData[$i][3];
                            $unit_ID      = $sheetData[$i][4];

                            $td0 = ($subUnit_ID    !== null) ? "" : " style='background: #E07171;'";
                            $td1 = ($subUnit_Name  !== null) ? "" : " style='background: #E07171;'";
                            $td2 = ($segment_No    !== null) ? "" : " style='background: #E07171;'";
                            $td3 = ($segment_Value !== null) ? "" : " style='background: #E07171;'";
                            $td4 = ($unit_ID       !== null) ? "" : " style='background: #E07171;'";

                            if ($subUnit_ID == "" || $subUnit_Name == "" || $segment_No == "" || $segment_Value == "" || $unit_ID == "") {
                                $kosong++;
                            }

                            $output .= '
                            <tr data-id="' . $subUnit_ID . '">
                                <td ' . $td0 . '>' . $subUnit_ID . '</td>
                                <td ' . $td1 . '>' . $subUnit_Name . '</td>
                                <td ' . $td2 . '>' . $segment_No . '</td>
                                <td ' . $td3 . '>' . $segment_Value . '</td>
                                <td ' . $td4 . '>' . $unit_ID . '</td>
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
                        columnDefs: [{ orderable: false, targets: 4 }],
                        "responsive": true,
                        "lengthChange": false,
                        "autoWidth": false,
                        "buttons": [{
                            text: "Import",
                            action: function(e, dt, node, config) {
                                $.post("' . site_url('tmstsubunit/upload') . '", {})
                                .done(function(response) {
                                    Swal.fire({ icon: "success", title: "Berhasil", text: "Data berhasil diimport." });
                                    $("#modalimport").modal("hide");
                                    $("#subUnitTable").DataTable().ajax.reload(null, false);
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

            $arr_file  = explode(".", $this->session->get("fileupload"));
            $extension = end($arr_file);
            if ('csv' == $extension) {
                $reader = new Csv();
            } else {
                $reader = new excel();
            }

            $spreadsheet = $reader->load($this->session->get("fileupload"));
            $sheetData   = $spreadsheet->getActiveSheet()->toArray();

            if (!empty($sheetData)) {
                for ($i = 1; $i < count($sheetData); $i++) {
                    $subUnit_ID    = $sheetData[$i][0];
                    $subUnit_Name  = $sheetData[$i][1];
                    $segment_No    = $sheetData[$i][2];
                    $segment_Value = $sheetData[$i][3];
                    $unit_ID       = $sheetData[$i][4];

                    helper(['restclient']);
                    $url = "{$this->server3}/api/mi-sub-unit";

                    $body = [
                        "subUnit_ID"    => $subUnit_ID,
                        "subUnit_Name"  => $subUnit_Name,
                        "segment_No"    => (int) $segment_No,
                        "segment_Value" => (float) $segment_Value,
                        "unit_ID"       => $unit_ID,
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

    public function uploaded()
    {
        return $this->preview();
    }
}