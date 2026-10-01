<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as excel;

class Tmstglsourceledger extends BaseController
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
        return view('tmstglsourceledger/index', $this->data);
    }

    public function datatables()
    {
        helper(['restclient']);
        $rawBody = $this->request->getBody();
        $json = json_decode($rawBody, true);

        $url = "{$this->server3}/api/tmstglsourceledger/datatables";
        $response = akses_restapikey('POST', $url, $json);

        $result = json_decode($response, true);

        // Tambahkan kolom aksi ke setiap data
        foreach ($result['data'] as $i => &$row) {
            $cd = $row['srceId'];
            $row['rownum'] = $i + ($json['start'] ?? 0) + 1;
            $row['aksi'] = '
            <div class="btn-group">
                <a class="btn btn-sm btn-info view ' . ($this->session->get("flag_view") === 1 ? "" : "d-none") . '" data-srceid="' . $cd . '"><i class="fas fa-eye"></i></a>
                <a class="btn btn-sm btn-primary edit ' . ($this->session->get("flag_update") === 1 ? "" : "d-none") . '" data-srceid="' . $cd . '"><i class="fas fa-tags"></i></a>
                <a class="btn btn-sm btn-danger delete ' . ($this->session->get("flag_delete") === 1 ? "" : "d-none") . '" data-srceid="' . $cd . '"><i class="fas fa-trash"></i></a>
            </div>';
        }

        return $this->response->setJSON($result);
    }

    // public function apiDataGetAll()
    // {

    //     // helper curl request
    //     helper(['restclient']);

    //     // endpoint
    //     $url = "{$this->server3}/api/gksourceledger";

    //     // Parameter yang ingin dikirim
    //     $query = [
    //         'action' => 'getall',          // atau 'getall'
    //         'SrceLedger' => ''        // ganti sesuai kebutuhan
    //     ];

    //     // client request
    //     $response = akses_restapikey('GET', $url, $body = [], $query);
    //     $data = json_decode($response, true);


    //     return $data["data"];
    // }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $srceId = $this->request->getVar('SrceId');

            helper(['restclient']);

            $url = "{$this->server3}/api/tmstglsourceledger";
            $query = [
                'srceId' => $srceId
            ];

            $result = akses_restapikey('DELETE', $url, $body = [], $query);

            $result = is_string($result) ? json_decode($result, true) : $result;

            if (isset($result['success']) && $result['success'] === true) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => $result['message'] ?? 'Data source ledger berhasil dihapus',
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

    private function checkDuplicate($srceLedger, $srceType, $excludeSrceId = null)
    {
        helper(['restclient']);

        $url = "{$this->server3}/api/tmstglsourceledger/checkduplicate";

        $body = [
            'srceLedger' => $srceLedger,
            'srceType' => $srceType,
            'excludeSrceId' => $excludeSrceId
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
                    'SrceLedger' => [
                        'label' => 'Source Ledger',
                        'rules' => 'required',
                        'errors' => []
                    ],
                    'SrceType' => [
                        'label' => 'Source Type',
                        'rules' => 'required',
                        'errors' => []
                    ],
                    'SrceDesc' => [
                        'label' => 'Source Description',
                        'rules' => 'required',
                        'errors' => []
                    ]
                ];

                if (!$this->validate($validationRules)) {
                    return $this->response->setJSON([
                        'error' => [
                            'SrceLedger'    => $validation->getError('SrceLedger'),
                            'SrceType'      => $validation->getError('SrceType'),
                            'SrceDesc'      => $validation->getError('SrceDesc'),
                        ]
                    ]);
                } else {
                    $srceLedger = $this->request->getVar('SrceLedger');
                    $srceType = $this->request->getVar('SrceType');
                    $srceId = $this->request->getVar('SrceId');

                    $isDuplicate = $this->checkDuplicate(
                        $srceLedger,
                        $srceType,
                        $this->request->getVar('action') == 'Edit' ? $srceId : null
                    );

                    if ($isDuplicate) {
                        return $this->response->setJSON([
                            'error' => [
                                'SrceLedger' => 'Data dengan Source Ledger ' . $srceLedger . 'sudah ada',
                                'SrceType' => 'Data dengan Source Type ' . $srceType . ' sudah ada'
                            ]
                        ]);
                    }

                    if ($this->request->getVar('action') == 'Add') {
                        helper(['restclient']);
                        $url = "{$this->server3}/api/tmstglsourceledger";

                        $audtDate = date('Y-m-d');
                        $audtTime = date('H:i:s');
                        $audtUser = session()->get('usr_id');

                        $body = [
                            "SrceId"     => $this->request->getVar('SrceId'),
                            "SrceLedger" => $srceLedger,
                            "SrceType"   => $srceType,
                            "SrceDesc"   => $this->request->getVar('SrceDesc'),
                            "AudtDate"   => $audtDate,
                            "AudtTime"   => $audtTime,
                            "AudtUser"   => $audtUser,
                        ];

                        $result = akses_restapikey('POST', $url, $body, $query = []);
                        $result = is_string($result) ? json_decode($result, true) : $result;

                        if (isset($result['success']) && $result['success'] === true) {
                            return $this->response->setJSON([
                                'status' => 'success',
                                'message' => 'Data Source Ledger berhasil ditambahkan',
                                'data' => $result,
                                'redirect_url' => site_url('tmstglsourceledger/index')
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
                        $url = "{$this->server3}/api/tmstglsourceledger";
                        $query = ['srceId' => str_replace(" ", "_", trim($srceId))];

                        $audtDate = date('Y-m-d');
                        $audtTime = date('H:i:s');
                        $audtUser = session()->get('usr_id');

                        $body = [
                            "srceId"     => $srceId,
                            "srceLedger" => $srceLedger,
                            "srceType"   => $srceType,
                            "srceDesc"   => $this->request->getVar('SrceDesc'),
                            "audtDate"   => $audtDate,
                            "audtTime"   => $audtTime,
                            "audtUser"   => $audtUser,
                        ];

                        $result = akses_restapikey('PUT', $url, $body, $query);
                        $result = is_string($result) ? json_decode($result, true) : $result;

                        if (isset($result['success']) && $result['success'] === true) {
                            return $this->response->setJSON([
                                'status' => 'success',
                                'message' => 'Data Source Ledger diubah',
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

            $srceId = $this->request->getVar('SrceId');

            if ($srceId) {

                helper(['restclient']);

                $url = "{$this->server3}/api/tmstglsourceledger";
                $query = [
                    'action' => 'getby',
                    'srceId' => $srceId
                ];

                $response = akses_restapikey('GET', $url, $body = [], $query);
                $data = json_decode($response, true);

                if (isset($data['success']) && $data['success'] === true && !empty($data['data'])) {
                    $row = $data['data'][0];

                    $msg = [
                        'data' => [
                            'SrceId'    => $row['srceId'],
                            'SrceLedger'    => $row['srceLedger'],
                            'SrceType'      => $row['srceType'],
                            'SrceDesc'      => $row['srceDesc'],
                            'AudtDate'      => $row['audtDate'],
                            'AudtTime'      => $row['audtTime'],
                            'AudtUser'      => $row['audtUser'],
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
            'A1' => 'Source Ledger',
            'B1' => 'Source Type',
            'C1' => 'Source Description'
        ];

        // Set header values
        foreach ($headers as $cell => $header) {
            $sheet->setCellValue($cell, $header);
        }

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(20); // Source Ledger
        $sheet->getColumnDimension('B')->setWidth(15); // Source Type
        $sheet->getColumnDimension('C')->setWidth(30); // Source Description

        $examples = [
            ['AR/Invoice', 'In', 'Description'],
            ['AR/Invoice', 'Oit', 'Description'],
        ];

        $row = 2;
        foreach ($examples as $example) {
            $sheet->setCellValue('A' . $row, $example[0]);
            $sheet->setCellValue('B' . $row, $example[1]);
            $sheet->setCellValue('C' . $row, $example[2]);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = "TEMPLATE_GL_SOURCE_LEDGER_" . date('Ymd_His') . ".xlsx";
        $writer->save($filename);

        return $this->response->download($filename, null)->setFileName("TEMPLATE GL SOURCE LEDGER.xlsx");
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
                <th>Source Ledger</th>
                <th>Source Type</th>
                <th>Source Description</th>
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
                    $SrceLedger = $sheetData[$i][0] ?? '';
                    $SrceType = $sheetData[$i][1] ?? '';
                    $SrceDesc = $sheetData[$i][2] ?? '';
                    $Action = $this->session->get("action");

                    $SrceLedger_td = (!empty($SrceLedger)) ? "" : " style='background: #E07171;'";
                    $SrceType_td = (!empty($SrceType)) ? "" : " style='background: #E07171;'";
                    $SrceDesc_td = (!empty($SrceDesc)) ? "" : " style='background: #E07171;'";
                    $Action_td = (!empty($Action)) ? "" : " style='background: #E07171;'";

                    if (empty($SrceLedger) || empty($SrceType) || empty($SrceDesc)) {
                        $kosong++;
                    }

                    $output .= '  
            <tr>
                <td class="text-center">' . $rowNumber . '</td>
                <td ' . $SrceLedger_td . '>' . htmlspecialchars($SrceLedger) . '</td>
                <td ' . $SrceType_td . '>' . htmlspecialchars($SrceType) . '</td>
                <td ' . $SrceDesc_td . '>' . htmlspecialchars($SrceDesc) . '</td>
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
                text: "Anda yakin ingin import data?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#28a745",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Ya, Import Sekarang",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    $btn.prop("disabled", true).html(\'<i class="fa fa-spinner fa-spin"></i> Importing...\');
                    
                    $.post("' . site_url('tmstglsourceledger/upload') . '", {
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
                                
                                // Refresh main datatable - glsourceledgerTable
                                if ($("#glsourceledgerTable").length && typeof $.fn.DataTable !== "undefined") {
                                    $("#glsourceledgerTable").DataTable().ajax.reload(null, false);
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

                        $SrceLedger = $sheetData[$i][0] ?? '';
                        $SrceType   = $sheetData[$i][1] ?? '';
                        $SrceDesc   = $sheetData[$i][2] ?? '';

                        // Skip jika data required kosong
                        if (empty($SrceLedger) || empty($SrceType)) {
                            $errorCount++;
                            $errors[] = "Baris $rowNumber: Data required kosong";
                            continue;
                        }

                        // Validasi panjang data
                        if (strlen($SrceLedger) > 100) {
                            $errorCount++;
                            $errors[] = "Baris $rowNumber: Source Ledger terlalu panjang (max 50 karakter)";
                            continue;
                        }

                        if (strlen($SrceType) > 100) {
                            $errorCount++;
                            $errors[] = "Baris $rowNumber: Source Type terlalu panjang (max 10 karakter)";
                            continue;
                        }

                        if (strlen($SrceDesc) > 255) {
                            $errorCount++;
                            $errors[] = "Baris $rowNumber: Source Description terlalu panjang (max 255 karakter)";
                            continue;
                        }

                        try {
                            $audtDate = date('Y-m-d');
                            $audtTime = date('H:i:s');
                            $audtUser = session()->get('usr_id');

                            if ($action == 'insert') {
                                $dataSource = [
                                    "SrceId"     => "", // Auto generate by API
                                    "SrceLedger" => trim($SrceLedger),
                                    "SrceType"   => trim($SrceType),
                                    "SrceDesc"   => trim($SrceDesc),
                                    "AudtDate"   => $audtDate,
                                    "AudtTime"   => $audtTime,
                                    "AudtUser"   => $audtUser,
                                ];

                                $url = "{$this->server3}/api/tmstglsourceledger";
                                $result = akses_restapikey('POST', $url, $dataSource, $query = []);
                                $result = is_string($result) ? json_decode($result, true) : $result;

                                if (isset($result['success']) && $result['success'] === true) {
                                    $successCount++;
                                } else {
                                    $errorCount++;
                                    $errors[] = "Baris $rowNumber: " . ($result['message'] ?? 'Gagal menyimpan data');
                                }
                            } else {
                                $errorCount++;
                                $errors[] = "Baris $rowNumber: Update tidak didukung untuk import tanpa SrceId";
                            }
                        } catch (\Exception $e) {
                            $errorCount++;
                            $errors[] = "Baris $rowNumber: " . $e->getMessage();
                            log_message('error', "Error processing row $rowNumber: " . $e->getMessage());
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
                log_message('error', 'Upload process failed: ' . $e->getMessage());

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
