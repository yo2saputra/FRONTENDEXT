<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as excel;

class Tmstunit extends BaseController
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
        return view('tmstunit/index', $this->data);
    }

    public function datatables()
    {
        helper(['restclient']);
        $rawBody = $this->request->getBody();
        $json = json_decode($rawBody, true);

        $url = "{$this->server3}/api/mi-unit/datatables";
        $response = akses_restapikey('POST', $url, $json);
        $result = json_decode($response, true);

        foreach ($result['data'] as $i => &$row) {
            $id = $row['unit_ID'];
            $row['rownum'] = $i + ($json['start'] ?? 0) + 1;
            $row['aksi'] = '
            <div class="btn-group">
                <a class="btn btn-sm btn-info view '    . ($this->session->get("flag_view")   === 1 ? "" : "d-none") . '" data-unit_id="' . $id . '"><i class="fas fa-eye"></i></a>
                <a class="btn btn-sm btn-primary edit ' . ($this->session->get("flag_update") === 1 ? "" : "d-none") . '" data-unit_id="' . $id . '"><i class="fas fa-tags"></i></a>
                <a class="btn btn-sm btn-danger delete '. ($this->session->get("flag_delete") === 1 ? "" : "d-none") . '" data-unit_id="' . $id . '"><i class="fas fa-trash"></i></a>
            </div>';
        }

        return $this->response->setJSON($result);
    }

    public function fetchAll()
    {
        helper(['restclient']);

        $url = "{$this->server3}/api/mi-unit";
        $query = [
            'action' => 'getall',
            'unitId' => ''
        ];

        $response = akses_restapikey('GET', $url, $body = [], $query);
        $data = json_decode($response, true);

        return $this->response->setJSON($data);
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $unit_id = $this->request->getVar('unit_id');

            helper(['restclient']);

            $url = "{$this->server3}/api/mi-unit/{$unit_id}";

            $result = akses_restapikey('DELETE', $url, $body = [], $query = []);
            $result = is_string($result) ? json_decode($result, true) : $result;

            if (isset($result['success']) && $result['success'] === true) {
                return $this->response->setJSON([
                    'status'  => 'success',
                    'message' => $result['message'] ?? 'Data unit berhasil dihapus',
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
                    'unit_Name' => [
                        'label'  => 'Nama Unit',
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
                ]);

                if (!$valid) {
                    return $this->response->setJSON([
                        'error' => [
                            'unit_ID'       => $validation->getError('unit_ID'),
                            'unit_Name'     => $validation->getError('unit_Name'),
                            'segment_No'    => $validation->getError('segment_No'),
                            'segment_Value' => $validation->getError('segment_Value'),
                        ]
                    ]);
                } else {

                    if ($this->request->getVar('action') == 'Add') {

                        helper(['restclient']);

                        $url = "{$this->server3}/api/mi-unit";

                        $body = [
                            "unit_ID"       => str_replace(" ", "_", trim($this->request->getVar('unit_ID'))),
                            "unit_Name"     => $this->request->getVar('unit_Name'),
                            "segment_No"    => (int) $this->request->getVar('segment_No'),
                            "segment_Value" => (float) $this->request->getVar('segment_Value'),
                        ];

                        $result = akses_restapikey('POST', $url, $body, $query = []);
                        $result = is_string($result) ? json_decode($result, true) : $result;

                        if (isset($result['success']) && $result['success'] === true) {
                            return $this->response->setJSON([
                                'status'  => 'success',
                                'message' => 'Data unit berhasil ditambahkan',
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

                        $unit_id = str_replace(" ", "_", trim($this->request->getVar('unit_ID')));
                        $url = "{$this->server3}/api/mi-unit/{$unit_id}";

                        $body = [
                            "unit_Name"     => $this->request->getVar('unit_Name'),
                            "segment_No"    => (int) $this->request->getVar('segment_No'),
                            "segment_Value" => (float) $this->request->getVar('segment_Value'),
                        ];

                        $result = akses_restapikey('PUT', $url, $body, $query = []);
                        $result = is_string($result) ? json_decode($result, true) : $result;

                        if (isset($result['success']) && $result['success'] === true) {
                            return $this->response->setJSON([
                                'status'  => 'success',
                                'message' => 'Data unit berhasil diubah',
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

            $unit_id = $this->request->getVar('unit_id');

            if ($unit_id) {

                helper(['restclient']);

                $url = "{$this->server3}/api/mi-unit/{$unit_id}";

                $response = akses_restapikey('GET', $url, $body = [], $query = []);
                $data = json_decode($response, true);

                $msg = [
                    'data' => [
                        'unit_ID'       => $data["data"][0]["unit_ID"]       ?? $data["data"]["unit_ID"]       ?? '',
                        'unit_Name'     => $data["data"][0]["unit_Name"]     ?? $data["data"]["unit_Name"]     ?? '',
                        'segment_No'    => $data["data"][0]["segment_No"]    ?? $data["data"]["segment_No"]    ?? '',
                        'segment_Value' => $data["data"][0]["segment_Value"] ?? $data["data"]["segment_Value"] ?? '',
                    ]
                ];

                echo json_encode($msg);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    public function fetchSingleDataPrint($unit_id)
    {
        if ($unit_id) {

            helper(['restclient']);

            $url = "{$this->server3}/api/mi-unit/{$unit_id}";

            $response = akses_restapikey('GET', $url, $body = [], $query = []);
            $data['response_data'] = json_decode($response, true);

            $pdf_data        = $data['response_data'];
            $pdf_name        = 'Single Data Unit';
            $pdf_title       = 'Data Unit';
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

        $paper       = $pdf_paper;
        $orientation = $pdf_orientation;

        $html = view($pdf_format, $this->data);
        $Pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    }

    public function download()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue("A1", "KODE");
        $sheet->setCellValue("B1", "NAMA UNIT");
        $sheet->setCellValue("C1", "SEGMENT NO");
        $sheet->setCellValue("D1", "SEGMENT VALUE");

        $count = 2;
        $sheet->setCellValue("A" . $count, "");
        $sheet->setCellValue("B" . $count, "");
        $sheet->setCellValue("C" . $count, "");
        $sheet->setCellValue("D" . $count, "");

        $writer = new Xlsx($spreadsheet);
        $writer->save("data.xlsx");
        return $this->response->download("data.xlsx", null)->setFileName("TEMPLATE UNIT.xlsx");
    }

    public function preview()
    {
        if ($this->request->getMethod() == "post") {
            $rules = $this->validate([
                'filename' => 'uploaded[filename]|max_size[filename,500]|ext_in[filename,csv,xlsx]',
            ]);
            if ($rules == true) {
                $filename = $this->request->getFile('filename');
                $path     = WRITEPATH . 'uploads/';
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

                $output  = '';
                $output .= '
                <br>
                <table id="exampleImport" class="table table-sm table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Unit</th>
                        <th>Segment No</th>
                        <th>Segment Value</th>
                    </tr>
                </thead>';

                if (empty($sheetData)) {
                    $output .= '<tr><td>Data not Found</td><td></td><td></td><td></td></tr>';
                } else {
                    if (count($sheetData) > 1) {
                        $kosong = 0;
                        for ($i = 1; $i < count($sheetData); $i++) {

                            $unit_ID       = $sheetData[$i][0];
                            $unit_Name     = $sheetData[$i][1];
                            $segment_No    = $sheetData[$i][2];
                            $segment_Value = $sheetData[$i][3];

                            $td0 = ($unit_ID       !== null) ? "" : " style='background: #E07171;'";
                            $td1 = ($unit_Name     !== null) ? "" : " style='background: #E07171;'";
                            $td2 = ($segment_No    !== null) ? "" : " style='background: #E07171;'";
                            $td3 = ($segment_Value !== null) ? "" : " style='background: #E07171;'";

                            if ($unit_ID == "" || $unit_Name == "" || $segment_No == "" || $segment_Value == "") {
                                $kosong++;
                            }

                            $output .= '
                            <tr data-id="' . $unit_ID . '">
                                <td ' . $td0 . '>' . $unit_ID . '</td>
                                <td ' . $td1 . '>' . $unit_Name . '</td>
                                <td ' . $td2 . '>' . $segment_No . '</td>
                                <td ' . $td3 . '>' . $segment_Value . '</td>
                            </tr>';
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
                        columnDefs: [{ orderable: false, targets: 3 }],
                        "responsive": true,
                        "lengthChange": false,
                        "autoWidth": false,
                        "buttons": [{
                            text: "Import",
                            action: function(e, dt, node, config) {
                                $.post("' . site_url('tmstunit/upload') . '", {})
                                .done(function(response) {
                                    Swal.fire({ icon: "success", title: "Berhasil", text: "Data berhasil diimport." });
                                    $("#modalimport").modal("hide");
                                    $("#unitTable").DataTable().ajax.reload(null, false);
                                })
                                .fail(function(error) {
                                    Swal.fire({ icon: "error", title: "Gagal", text: "Terjadi kesalahan saat mengimport data." });
                                });
                            },
                            attr: {
                                id: "postButton",
                                style: "background-color:#56b746;' . ($this->session->get("flag_insert") === 1 ? "" : "display:none;") . '",
                                name: "postButton",
                                nameClass: "btn-sm"
                            }
                        }],
                        "oLanguage": {
                            "sSearch": "Cari Data:",
                            "sInfoEmpty": "Tidak ada data",
                            "sInfo": "Total: _TOTAL_ data",
                            "sInfoFiltered": " dari _MAX_ data",
                            "sZeroRecords": "Data tidak ditemukan",
                            "oPaginate": { "sFirst": "Awal", "sPrevious": "Sebelum", "sNext": "Berikut", "sLast": "Akhir" }
                        }
                    }).buttons().container().appendTo("#exampleImport_wrapper .col-md-6:eq(0)");
                });
                </script>';

                echo $output;
            } else {
                echo '';
            }
        }
    }

    public function uploaded()
    {
        return $this->preview();
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
                    $unit_ID       = $sheetData[$i][0];
                    $unit_Name     = $sheetData[$i][1];
                    $segment_No    = $sheetData[$i][2];
                    $segment_Value = $sheetData[$i][3];

                    helper(['restclient']);
                    $url = "{$this->server3}/api/mi-unit";

                    $body = [
                        "unit_ID"       => $unit_ID,
                        "unit_Name"     => $unit_Name,
                        "segment_No"    => (int) $segment_No,
                        "segment_Value" => (float) $segment_Value,
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