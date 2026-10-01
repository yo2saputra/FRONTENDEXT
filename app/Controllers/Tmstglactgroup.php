<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as excel;

class Tmstglactgroup extends BaseController
{

    protected $data;
    protected $server;
    protected $server3;
    protected $client;

    public function __construct()
    {
        $this->server = $_ENV['APP_API'];
        $this->server3 = $_ENV['APP_API3'];
    }

    public function index()
    {
        // helper dropdown
        helper(['dropdown']);
        return view('tmstglactgroup/index', $this->data);
    }

    public function datatables()
    {
        helper(['restclient']);
        $rawBody = $this->request->getBody();
        $json = json_decode($rawBody, true);

        $url = "{$this->server3}/api/tmstglaccountgroup/datatables";
        $response = akses_restapikey('POST', $url, $json);

        $result = json_decode($response, true);

        // Tambahkan kolom aksi ke setiap data
        foreach ($result['data'] as $i => &$row) {
            $cd = $row['accNo'];
            $row['rownum'] = $i + ($json['start'] ?? 0) + 1;
            $row['aksi'] = '
            <div class="btn-group">
                <a class="btn btn-sm btn-info view ' . ($this->session->get("flag_view") === 1 ? "" : "d-none") . '" data-accno="' . $cd . '"><i class="fas fa-eye"></i></a>
                <a class="btn btn-sm btn-primary edit ' . ($this->session->get("flag_update") === 1 ? "" : "d-none") . '" data-accno="' . $cd . '"><i class="fas fa-tags"></i></a>
                <a class="btn btn-sm btn-danger delete ' . ($this->session->get("flag_delete") === 1 ? "" : "d-none") . '" data-accno="' . $cd . '"><i class="fas fa-trash"></i></a>
            </div>';
        }

        return $this->response->setJSON($result);
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $accNo = $this->request->getVar('AccNo');

            helper(['restclient']);

            $url = "{$this->server3}/api/tmstglaccountgroup";
            $query = [
                'accNo' => $accNo
            ];

            $result = akses_restapikey('DELETE', $url, $body = [], $query);

            $result = is_string($result) ? json_decode($result, true) : $result;

            if (isset($result['success']) && $result['success'] === true) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => $result['message'] ?? 'Data Account Group berhasil dihapus',
                    'data' => $result,
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

    private function checkDuplicate($accGrId, $accGrLine, $excludeAccNo = null)
    {
        helper(['restclient']);

        $url = "{$this->server3}/api/tmstglaccountgroup/checkduplicate";

        $body = [
            'accGrId' => $accGrId,
            'accGrLine' => $accGrLine,
            'excludeAccNo' => $excludeAccNo
        ];

        $response = akses_restapikey('POST', $url, $body);
        $result = is_string($response) ? json_decode($response, true) : $response;

        return isset($result['isDuplicate']) && $result['isDuplicate'] === true;
    }

    function action()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getVar('action')) {
                helper(['form', 'url']);

                $validation = \Config\Services::validation();

                $validationRules = [
                    'AccGrId' => [
                        'label' => 'Account Group Id',
                        'rules' => 'required',
                        'errors' => []
                    ],
                    'AccGrLine' => [
                        'label' => 'Account Group Line',
                        'rules' => 'required',
                        'errors' => []
                    ],
                    'AccGrName' => [
                        'label' => 'Account Group Name',
                        'rules' => 'required',
                        'errors' => []
                    ]
                ];

                if (!$this->validate($validationRules)) {
                    return $this->response->setJSON([
                        'error' => [
                            'AccGrId'    => $validation->getError('AccGrId'),
                            'AccGrLine'      => $validation->getError('AccGrLine'),
                            'AccGrName'      => $validation->getError('AccGrName'),
                        ]
                    ]);
                } else {
                    $accNo = $this->request->getVar('AccNo');
                    $accGrId = $this->request->getVar('AccGrId');
                    $accGrLine = $this->request->getVar('AccGrLine');
                    $accGrName = $this->request->getVar('AccGrName');

                    $isDuplicate = $this->checkDuplicate(
                        $accGrId,
                        $accGrLine,
                        $this->request->getVar('action') == 'Edit' ? $accNo : null
                    );

                    if ($isDuplicate) {
                        return $this->response->setJSON([
                            'error' => [
                                'AccGrId' => 'Data dengan Account Group Id ' . $accGrId . ' sudah ada',
                                'AccGrLine' => 'Data dengan Account Group Line ' . $accGrLine . ' sudah ada'
                            ]
                        ]);
                    }

                    if ($this->request->getVar('action') == 'Add') {
                        helper(['restclient']);
                        $url = "{$this->server3}/api/tmstglaccountgroup";

                        $createdDate = date('Y-m-d');
                        $createdBy = session()->get('usr_id');

                        $body = [
                            "AccNo"     => $this->request->getVar('AccNo'),
                            "AccGrId" => $accGrId,
                            "AccGrLine"   => $accGrLine,
                            "AccGrName"   => $accGrName,
                            "CreatedDate"   => $createdDate,
                            "CreatedBy"   => $createdBy,
                        ];

                        $result = akses_restapikey('POST', $url, $body, $query = []);
                        $result = is_string($result) ? json_decode($result, true) : $result;

                        if (isset($result['success']) && $result['success'] === true) {
                            return $this->response->setJSON([
                                'status' => 'success',
                                'message' => 'Data Account Group berhasil ditambahkan',
                                'data' => $result,
                                'redirect_url' => site_url('tmstglactgroup/index')
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
                        $url = "{$this->server3}/api/tmstglaccountgroup";
                        $query = ['accNo' => str_replace(" ", "_", trim($accNo))];

                        $createdDate = date('Y-m-d');
                        $createdBy = session()->get('usr_id');

                        $body = [
                            "accGrId"     => $accGrId,
                            "accGrLine" => $accGrLine,
                            "accGrName"   => $accGrName,
                            "createdDate"   => $createdDate,
                            "createdBy"   => $createdBy,
                        ];

                        $result = akses_restapikey('PUT', $url, $body, $query);
                        $result = is_string($result) ? json_decode($result, true) : $result;

                        if (isset($result['success']) && $result['success'] === true) {
                            return $this->response->setJSON([
                                'status' => 'success',
                                'message' => 'Data Account Group diubah',
                                'data' => $result,
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

    public function fetchSingleData()
    {
        if ($this->request->isAJAX()) {
            $accNo = $this->request->getVar('AccNo');

            if ($accNo) {
                helper(['restclient']);

                $url = "{$this->server3}/api/tmstglaccountgroup/getby/{$accNo}";

                $response = akses_restapikey('GET', $url);

                $data = json_decode($response, true);

                if (isset($data['success']) && $data['success'] === true) {
                    $row = $data['data'];

                    $msg = [
                        'data' => [
                            'AccNo'        => $row['accNo'],
                            'AccGrId'      => $row['accGrId'],
                            'AccGrLine'    => $row['accGrLine'],
                            'AccGrName'    => $row['accGrName'],
                            'CreatedDate'  => $row['createdDate'],
                            'CreatedBy'    => $row['createdBy'],
                        ]
                    ];

                    return $this->response->setJSON($msg);
                }

                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }

        exit('Maaf tidak dapat diproses!');
    }

    // ============================
    // DOWNLOAD TEMPLATE
    // ============================
    public function download()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = [
            'A1' => 'Account Group ID',
            'B1' => 'Account Group Line',
            'C1' => 'Account Group Name'
        ];

        // Set header values
        foreach ($headers as $cell => $header) {
            $sheet->setCellValue($cell, $header);
        }

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(20); // Account Group Id
        $sheet->getColumnDimension('B')->setWidth(15); // Account Group Line
        $sheet->getColumnDimension('C')->setWidth(30); // Account Group Name

        $writer = new Xlsx($spreadsheet);
        $filename = "TEMPLATE_GL_ACCOUNT_GROUP_" . date('Ymd_His') . ".xlsx";
        $writer->save($filename);

        return $this->response->download($filename, null)->setFileName("TEMPLATE GL ACCOUNT GROUP.xlsx");
    }

    // ============================
    // PREVIEW FILE
    // ============================
    public function preview()
    {
        // Jika POST request untuk upload file
        if ($this->request->getMethod() == "post") {
            $rules = $this->validate([
                'filename' => 'uploaded[filename]|max_size[filename,50000]|ext_in[filename,csv,xlsx]',
            ]);

            if ($rules == true) {
                $filename = $this->request->getFile('filename');

                // Validasi file
                if (!$filename->isValid()) {
                    return $this->response->setStatusCode(400)->setJSON([
                        'error' => $filename->getErrorString()
                    ]);
                }

                $path = WRITEPATH . 'uploads/';

                // Pastikan directory exists
                if (!is_dir($path)) {
                    mkdir($path, 0755, true);
                }

                // Generate safe filename
                $newName = $filename->getRandomName();

                if ($filename->move($path, $newName)) {
                    $this->session->set("fileupload", $path . $newName);
                    $this->session->set("action", $this->request->getPost('pas'));
                } else {
                    return $this->response->setStatusCode(500)->setJSON([
                        'error' => 'Gagal mengupload file'
                    ]);
                }
            } else {
                return $this->response->setStatusCode(400)->setJSON([
                    'error' => 'File yang diunggah harus berformat CSV atau Excel (maks 50000KB)'
                ]);
            }
        }

        // Process preview data
        if ($this->session->get("fileupload") && file_exists($this->session->get("fileupload"))) {
            // Load Excel file
            $filePath = $this->session->get("fileupload");
            $arr_file = explode(".", $filePath);
            $extension = end($arr_file);

            if ('csv' == $extension) {
                $reader = new Csv();
            } else {
                $reader = new Excel();
            }

            $spreadsheet = $reader->load($filePath);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();

            $output = '';
            $output .= '
    <br>
    <table id="previewImportTable" class="table table-sm table-bordered table-striped">
    <thead>
            <tr>  
                <th width="50" class="text-center">No</th>
                <th>Account Group ID</th>
                <th>Account Group Line</th>
                <th>Account Group Name</th>
                <th>Action</th>
            </tr>
        </thead>
    <tbody>';

            $kosong = 0;
            $totalRows = 0;

            if (!empty($sheetData) && count($sheetData) > 1) {
                $totalRows = count($sheetData) - 1;

                for ($i = 1; $i < count($sheetData); $i++) {
                    $rowNumber = $i;
                    $AccGrId = $sheetData[$i][0];
                    $AccGrLine = $sheetData[$i][1];
                    $AccGrName = $sheetData[$i][2];
                    $Action = $this->session->get("action");

                    $AccGrId_td = (!empty($AccGrId)) ? "" : " style='background: #E07171;'";
                    $AccGrLine_td = (!empty($AccGrLine)) ? "" : " style='background: #E07171;'";
                    $AccGrName_td = (!empty($AccGrName)) ? "" : " style='background: #E07171;'";
                    $Action_td = (!empty($Action)) ? "" : " style='background: #E07171;'";

                    if (empty($AccGrId) || empty($AccGrLine) || empty($AccGrName)) {
                        $kosong++;
                    }

                    $output .= '  
            <tr>
                <td class="text-center">' . $rowNumber . '</td>
                <td ' . $AccGrId_td . '>' . htmlspecialchars($AccGrId) . '</td>
                <td ' . $AccGrLine_td . '>' . htmlspecialchars($AccGrLine) . '</td>
                <td ' . $AccGrName_td . '>' . htmlspecialchars($AccGrName) . '</td>
                <td ' . $Action_td . '>' . htmlspecialchars($Action) . '</td>
            </tr>  
            ';
                }
            } else {
                $output .= '<tr><td colspan="5" class="text-center">Tidak ada data ditemukan dalam file</td></tr>';
            }

            $output .= '</tbody></table>';

            $output .= '
    <div class="alert>
        <i class="fas fa-info-circle"></i>';

            if ($kosong > 0) {
                $output .= ' | <span class="text-warning"><i class="fas fa-exclamation-triangle"></i> Ada ' . $kosong . ' baris dengan data tidak lengkap</span>';
            }

            $output .= '
    </div>';

            $output .= '
    <div class="text-right mt-3">
        <button type="button" class="btn btn-success btn-sm" id="btnImportPreview">
            <i class="fas fa-upload"></i> Import Data
        </button>
    </div>';

            $output .= '
    <script>
    $(document).ready(function() {
        // Inisialisasi DataTable untuk preview
        $("#previewImportTable").DataTable({
            columnDefs: [{
                orderable: false,
                targets: [0, 4]
            }],
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "pageLength": 10,
            "language": {
                "sSearch": "Cari Data:",
                "sInfoEmpty": "Tidak ada data",
                "sInfo": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "sInfoFiltered": " dari _MAX_ data",
                "sZeroRecords": "Data tidak ditemukan",
                "oPaginate": {
                    "sFirst": "Pertama",
                    "sPrevious": "Sebelum",
                    "sNext": "Berikut",
                    "sLast": "Akhir"
                },
            },
        });
        
        // Handle tombol import preview
        $("#btnImportPreview").click(function() {
            const $btn = $(this);
            
            Swal.fire({
                title: "Konfirmasi Import",
                text: "Apakah anda yakin ingin import data?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#28a745",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Ya, Import Sekarang",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    $btn.prop("disabled", true).html(\'<i class="fa fa-spinner fa-spin"></i> Importing...\');
                    
                    $.post("' . site_url('tmstglactgroup/upload') . '", {
                        csrf_token: "' . csrf_hash() . '"
                    })
                    .done(function(response) {
                        try {
                            const data = typeof response === "string" ? JSON.parse(response) : response;
                            if(data.success) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Berhasil",
                                    text: data.success,
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                $("#modalimport").modal("hide");
                                
                                // Refresh main datatable
                                if ($("#glaccountgrupTable").length && typeof $.fn.DataTable !== "undefined") {
                                    $("#glaccountgrupTable").DataTable().ajax.reload(null, false);
                                }
                            } else if(data.error) {
                                Swal.fire({
                                    icon: "error",
                                    title: "Error",
                                    text: data.error
                                });
                            } else if(data.errors) {
                                let errorMsg = "Terdapat error:<br>";
                                data.errors.forEach(function(error, index) {
                                    if (index < 5) {
                                        errorMsg += "• " + error + "<br>";
                                    }
                                });
                                Swal.fire({
                                    icon: "warning",
                                    title: "Import dengan Warning",
                                    html: errorMsg
                                });
                            }
                        } catch(e) {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: "Gagal memproses response"
                            });
                        }
                    })
                    .fail(function(xhr) {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "Request gagal: " + xhr.status
                        });
                    })
                    .always(function() {
                        $btn.prop("disabled", false).html(\'<i class="fas fa-upload"></i> Import Data\');
                    });
                }
            });
        });
    });
    </script>';

            echo $output;
        } else {
            echo '<div class="alert alert-warning">Tidak ada file yang diupload atau session telah expired.</div>';
        }
    }

    // ============================
    // UPLOAD/PROSES IMPORT
    // ============================
    public function upload()
    {
        if ($this->request->getMethod() == "post") {
            // Check if file exists in session
            if (!$this->session->get("fileupload") || !file_exists($this->session->get("fileupload"))) {
                return $this->response->setStatusCode(400)->setJSON([
                    'error' => 'File tidak ditemukan. Silakan upload ulang file.'
                ]);
            }

            $filePath = $this->session->get("fileupload");
            $action   = $this->session->get("action");

            try {
                // Load Excel file
                $arr_file   = explode(".", $filePath);
                $extension  = end($arr_file);

                if ('csv' == $extension) {
                    $reader = new Csv();
                } else {
                    $reader = new Excel();
                }

                $spreadsheet = $reader->load($filePath);
                $sheetData   = $spreadsheet->getActiveSheet()->toArray();

                $successCount = 0;
                $errorCount   = 0;
                $totalRows    = count($sheetData) - 1;
                $errors       = [];

                if (!empty($sheetData) && $totalRows > 0) {
                    helper(['restclient']);

                    for ($i = 1; $i < count($sheetData); $i++) {
                        $rowNumber = $i + 1; // Actual row number in Excel

                        $AccGrId = $sheetData[$i][0];
                        $AccGrLine   = $sheetData[$i][1];
                        $AccGrName   = $sheetData[$i][2];

                        // Skip jika data required kosong
                        if (empty($AccGrId) || empty($AccGrLine)) {
                            $errorCount++;
                            $errors[] = "Baris $rowNumber: Data required kosong";
                            continue;
                        }

                        try {
                            $createdDate = date('Y-m-d');
                            $createdBy = session()->get('usr_id');

                            if ($action == 'insert') {
                                $dataAccountGroup = [
                                    "AccNo"     => "", // Auto generate by API
                                    "AccGrId" => trim($AccGrId),
                                    "AccGrLine"   => trim($AccGrLine),
                                    "AccGrName"   => trim($AccGrName),
                                    "CreatedDate"   => $createdDate,
                                    "CreatedBy"   => $createdBy,
                                ];

                                $url = "{$this->server3}/api/tmstglaccountgroup";
                                $result = akses_restapikey('POST', $url, $dataAccountGroup, $query = []);
                                $result = is_string($result) ? json_decode($result, true) : $result;

                                if (isset($result['success']) && $result['success'] === true) {
                                    $successCount++;
                                } else {
                                    $errorCount++;
                                    $errors[] = "Baris $rowNumber: " . ($result['message'] ?? 'Gagal menyimpan data');
                                }
                            } else {
                                $errorCount++;
                                $errors[] = "Baris $rowNumber: Update tidak didukung untuk import tanpa AccNo";
                            }
                        } catch (\Exception $e) {
                            $errorCount++;
                            $errors[] = "Baris $rowNumber: " . $e->getMessage();
                        }
                    }

                    // Clean up uploaded file
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                    $this->session->remove("fileupload");
                    $this->session->remove("action");

                    // Prepare response
                    $response = [
                        'success' => "$successCount dari $totalRows data berhasil diimport!"
                    ];

                    if ($errorCount > 0) {
                        $response['errors'] = array_slice($errors, 0, 10);
                        if (count($errors) > 10) {
                            $response['errors'][] = "... dan " . (count($errors) - 10) . " error lainnya";
                        }
                    }

                    return $this->response->setJSON($response);
                } else {
                    return $this->response->setStatusCode(400)->setJSON([
                        'error' => 'Tidak ada data yang dapat diimport dari file'
                    ]);
                }
            } catch (\Exception $e) {
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                $this->session->remove("fileupload");
                $this->session->remove("action");

                return $this->response->setStatusCode(500)->setJSON([
                    'error' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
                ]);
            }
        }

        return $this->response->setStatusCode(405)->setJSON([
            'error' => 'Method tidak diizinkan'
        ]);
    }
}
