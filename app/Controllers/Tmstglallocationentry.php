<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as excel;

class Tmstglallocationentry extends BaseController
{
    protected $data;
    protected $server;
    protected $server3;
    protected $session;

    public function __construct()
    {
        $this->session = session();
        $this->server = $_ENV['APP_API'];
        $this->server3 = $_ENV['APP_API3'];
    }

    public function index()
    {
        // helper dropdown
        helper(['dropdown']);
        $this->data['cb_allocation_method'] = getDropdownAllocationMethod('allocation_method', 'cb_allocation_method');
        $this->data['cb_from_allocation_account'] = getDropdownFromAllocationAccount('cb_from_allocation_account', 'cb_from_allocation_account');
        $this->data['cb_to_allocation_account'] = getDropdownToAllocationAccount('cb_to_allocation_account', 'cb_to_allocation_account');

        return view('tmstglallocationentry/index', $this->data);
    }

    public function datatables()
    {
        helper(['restclient']);
        $rawBody = $this->request->getBody();
        $json = json_decode($rawBody, true);

        $url = "{$this->server3}/api/tmstglallocation/datatables";
        $response = akses_restapikey('POST', $url, $json);
        $result = json_decode($response, true);

        if (!isset($result['data']) || !is_array($result['data'])) {
            $result['data'] = [];
        }

        foreach ($result['data'] as $i => &$row) {
            $allocationNo = $row['allocationNo'];
            $row['rownum'] = $i + ($json['start'] ?? 0) + 1;
            $row['aksi'] = '
        <div class="btn-group">
            <a class="btn btn-sm btn-info view ' . ($this->session->get("flag_view") === 1 ? "" : "d-none") . '" data-allocationno="' . $allocationNo . '"><i class="fas fa-eye"></i></a>
            <a class="btn btn-sm btn-primary edit ' . ($this->session->get("flag_update") === 1 ? "" : "d-none") . '" data-allocationno="' . $allocationNo . '"><i class="fas fa-tags"></i></a>
            <a class="btn btn-sm btn-danger delete ' . ($this->session->get("flag_delete") === 1 ? "" : "d-none") . '" data-allocationno="' . $allocationNo . '"><i class="fas fa-trash"></i></a>
        </div>';
        }

        return $this->response->setJSON($result);
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $AllocationNo = $this->request->getVar('AllocationNo');

            helper(['restclient']);

            $url = "{$this->server3}/api/tmstglallocation";
            $query = [
                'AllocationNo' => $AllocationNo
            ];

            $result = akses_restapikey('DELETE', $url, $body = [], $query);

            $result = is_string($result) ? json_decode($result, true) : $result;

            if (isset($result['success']) && $result['success'] === true) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => $result['message'] ?? 'Data allocation berhasil dihapus',
                    'data' => $result,
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

    private function checkDuplicate($AllocationNo, $excludeAllocationNo = null)
    {
        helper(['restclient']);

        $url = "{$this->server3}/api/tmstglallocation/checkduplicate";

        $body = [
            'AllocationNo' => $AllocationNo,
            'excludeAllocationNo' => $excludeAllocationNo
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
                    'AllocationDesc' => [
                        'label' => 'Description',
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Description harus diisi'
                        ]
                    ],
                    'cb_from_allocation_account' => [
                        'label' => 'Source Account',
                        'rules' => 'required',
                        'errors' => []
                    ],
                    'cb_allocation_method' => [
                        'label' => 'Allocation Method',
                        'rules' => 'required',
                        'errors' => []
                    ],
                    'ExpiredDate' => [
                        'label' => 'Expired Date',
                        'rules' => 'required',
                        'errors' => []
                    ]
                ];

                if (!$this->validate($validationRules)) {
                    return $this->response->setJSON([
                        'error' => [
                            'AllocationDesc' => $validation->getError('AllocationDesc'),
                            'FromAlloAccount'    => $validation->getError('cb_from_allocation_account'),
                            'AllocationMethod'   => $validation->getError('cb_allocation_method'),
                            'ExpiredDate'        => $validation->getError('ExpiredDate')
                        ]
                    ]);
                } else {
                    try {
                        $allocationNo = $this->request->getVar('AllocationNoDisplay') ?: $this->request->getVar('AllocationNo');
                        $fromAccount = $this->request->getVar('cb_from_allocation_account');
                        $allocationMethod = $this->request->getVar('cb_allocation_method');

                        // Check duplicate untuk Add action
                        if ($this->request->getVar('action') == 'Add') {
                            $isDuplicate = $this->checkDuplicate($allocationNo);
                            if ($isDuplicate) {
                                return $this->response->setJSON([
                                    'error' => [
                                        'AllocationNo' => 'Data dengan Allocation Number ' . $allocationNo . ' sudah ada'
                                    ]
                                ]);
                            }
                        }

                        // Collect details
                        $details = [];
                        $lineNumber = 1;

                        $toAccounts = $this->request->getVar('to_allocation_account') ?? [];
                        $percentages = $this->request->getVar('AlloPercent') ?? [];
                        $notes = $this->request->getVar('notes') ?? [];

                        foreach ($toAccounts as $index => $toAccount) {
                            if (!empty($toAccount) && isset($percentages[$index])) {
                                $percent = floatval($percentages[$index]);
                                if ($percent <= 0) {
                                    return $this->response->setJSON([
                                        'error' => [
                                            'AllocationMethod' => 'Percentage harus lebih dari 0%'
                                        ]
                                    ]);
                                }

                                $details[] = [
                                    'LineNumber' => $lineNumber,
                                    'ToAlloAccount' => $toAccount,
                                    'AlloPercent' => $percent,
                                    'Notes' => $notes[$index] ?? ''
                                ];
                                $lineNumber++;
                            }
                        }

                        $audtDate = date('Y-m-d');
                        $audtTime = date('H:i:s');
                        $audtUser = session()->get('usr_id') ?? 'SYSTEM';

                        // Persiapan data untuk dikirim ke API
                        $dataToSend = [
                            "AllocationNo" => $allocationNo,
                            "AllocationDesc" => $this->request->getVar('AllocationDesc') ?? '',
                            "FromAlloAccount" => $fromAccount,
                            "AllocationMethod" => $allocationMethod,
                            "ExpiredDate" => $this->request->getVar('ExpiredDate'),
                            "IsActive" => $this->request->getVar('Status') ? true : false,
                            "AudtUser" => $audtUser,
                            "AudtDate" => $audtDate,
                            "AudtTime" => $audtTime,
                            "Details" => $details
                        ];

                        if ($this->request->getVar('action') == 'Add') {
                            helper(['restclient']);
                            $url = "{$this->server3}/api/tmstglallocation";

                            $result = akses_restapikey('POST', $url, $dataToSend, $query = []);

                            $result = is_string($result) ? json_decode($result, true) : $result;

                            if (isset($result['success']) && $result['success'] === true) {
                                return $this->response->setJSON([
                                    'status' => 'success',
                                    'message' => 'Data Allocation berhasil ditambahkan',
                                    'data' => $result
                                ]);
                            } else {
                                return $this->response->setJSON([
                                    'status' => 'error',
                                    'message' => $result['message'] ?? 'Gagal menambahkan data',
                                    'errors' => $result['errors'] ?? null,
                                    'api_response' => $result
                                ]);
                            }
                        }

                        if ($this->request->getVar('action') == 'Edit') {
                            helper(['restclient']);
                            $url = "{$this->server3}/api/tmstglallocation";
                            $query = ['AllocationNo' => $allocationNo];

                            $result = akses_restapikey('PUT', $url, $dataToSend, $query);

                            $result = is_string($result) ? json_decode($result, true) : $result;

                            if (isset($result['success']) && $result['success'] === true) {
                                return $this->response->setJSON([
                                    'status' => 'success',
                                    'message' => 'Data Allocation berhasil diubah',
                                    'data' => $result,
                                ]);
                            } else {
                                return $this->response->setJSON([
                                    'status' => 'error',
                                    'message' => $result['message'] ?? 'Gagal mengubah data',
                                    'errors' => $result['errors'] ?? null,
                                    'api_response' => $result
                                ]);
                            }
                        }
                    } catch (\Exception $e) {
                        return $this->response->setJSON([
                            'status' => 'error',
                            'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
                        ]);
                    }
                }
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    public function fetchSingleData()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid request'
            ]);
        }

        $AllocationNo = $this->request->getVar('AllocationNo');

        if (!$AllocationNo) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'AllocationNo tidak valid'
            ]);
        }

        helper(['restclient']);

        try {
            $encodedAllocationNo = rawurlencode($AllocationNo);
            $url = "{$this->server3}/api/tmstglallocation/getby/{$encodedAllocationNo}";

            $response = akses_restapikey('GET', $url);
            $data = json_decode($response, true);

            // ================= VALIDASI =================
            if (!isset($data['success']) || $data['success'] !== true || empty($data['data'])) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $data['message'] ?? 'Data tidak ditemukan'
                ]);
            }

            $row = $data['data'];

            // ================= FORMAT DATE =================
            $expiredDate = !empty($row['expiredDate']) ? substr($row['expiredDate'], 0, 10) : null;
            $audtDate    = !empty($row['audtDate']) ? substr($row['audtDate'], 0, 10) : null;

            // ================= HEADER =================
            $result = [
                'data' => [
                    'AllocationNo'     => $row['allocationNo'],
                    'AllocationDesc'   => $row['allocationDesc'],
                    'FromAlloAccount'  => $row['fromAlloAccount'],
                    'AllocationMethod' => $row['allocationMethod'],
                    'ExpiredDate'      => $expiredDate,
                    'Status'           => !empty($row['isActive']) ? 1 : 0,
                    'AudtUser'         => $row['audtUser'],
                    'AudtDate'         => $audtDate,
                    'AudtTime'         => $row['audtTime'],
                ]
            ];

            // ================= DETAIL =================
            if (!empty($row['details']) && is_array($row['details'])) {
                $details = [];
                foreach ($row['details'] as $detail) {
                    $details[] = [
                        'ToAlloAccount' => $detail['toAlloAccount'],
                        'AccountName'   => $detail['accountName'],
                        'AlloPercent'   => $detail['alloPercent'] ?? 0,
                        'Notes'         => $detail['notes']
                    ];
                }
                $result['details'] = $details;
            }

            return $this->response->setJSON($result);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data'
            ]);
        }
    }

    // ============================
    // DOWNLOAD TEMPLATE
    // ============================
    public function download()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = [
            'A1' => 'Allocation Number',
            'B1' => 'Description',
            'C1' => 'Source Account',
            'D1' => 'Allocation Method',
            'E1' => 'Expired Date (YYYY-MM-DD)',
            'F1' => 'Status (1=Active, 0=Inactive)'
        ];

        foreach ($headers as $cell => $header) {
            $sheet->setCellValue($cell, $header);
        }

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(10);

        $examples = [
            ['ALC-001', 'Monthly salary allocation', '51101-00-00', 'Percentage', '2024-12-31', 1],
            ['ALC-002', 'Utility bills allocation', '51102-00-00', 'Percentage', '2024-12-31', 1],
        ];

        $row = 2;
        foreach ($examples as $example) {
            $sheet->setCellValue('A' . $row, $example[0]);
            $sheet->setCellValue('B' . $row, $example[1]);
            $sheet->setCellValue('C' . $row, $example[2]);
            $sheet->setCellValue('D' . $row, $example[3]);
            $sheet->setCellValue('E' . $row, $example[4]);
            $sheet->setCellValue('F' . $row, $example[5]);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = "TEMPLATE_GL_ALLOCATION_" . date('Ymd_His') . ".xlsx";
        $writer->save($filename);

        return $this->response->download($filename, null)->setFileName("TEMPLATE GL ALLOCATION.xlsx");
    }

    // ============================
    // PREVIEW FILE
    // ============================
    public function preview()
    {
        if ($this->request->getMethod() == "post") {
            $rules = $this->validate([
                'filename' => 'uploaded[filename]|max_size[filename,50000]|ext_in[filename,csv,xlsx]',
            ]);

            if ($rules == true) {
                $filename = $this->request->getFile('filename');

                if (!$filename->isValid()) {
                    return $this->response->setStatusCode(400)->setJSON([
                        'error' => $filename->getErrorString()
                    ]);
                }

                $path = WRITEPATH . 'uploads/';

                if (!is_dir($path)) {
                    mkdir($path, 0755, true);
                }

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

        if ($this->session->get("fileupload") && file_exists($this->session->get("fileupload"))) {
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
                <th>Allocation Number</th>
                <th>Description</th>
                <th>Source Account</th>
                <th>Allocation Method</th>
                <th>Expired Date</th>
                <th>Status</th>
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
                    $AllocationNo = $sheetData[$i][0];
                    $AllocationDesc = $sheetData[$i][1];
                    $FromAlloAccount = $sheetData[$i][2];
                    $AllocationMethod = $sheetData[$i][3];
                    $ExpiredDate = $sheetData[$i][4];
                    $Status = $sheetData[$i][5];
                    $Action = $this->session->get("action");

                    $AllocationNo_td = (!empty($AllocationNo)) ? "" : " style='background: #E07171;'";
                    $AllocationDesc_td = (!empty($AllocationDesc)) ? "" : " style='background: #E07171;'";
                    $FromAlloAccount_td = (!empty($FromAlloAccount)) ? "" : " style='background: #E07171;'";
                    $AllocationMethod_td = (!empty($AllocationMethod)) ? "" : " style='background: #E07171;'";
                    $Action_td = (!empty($Action)) ? "" : " style='background: #E07171;'";

                    if (empty($AllocationNo) || empty($AllocationDesc) || empty($FromAlloAccount) || empty($AllocationMethod)) {
                        $kosong++;
                    }

                    $output .= '  
            <tr>
                <td class="text-center">' . $rowNumber . '</td>
                <td ' . $AllocationNo_td . '>' . htmlspecialchars($AllocationNo) . '</td>
                <td ' . $AllocationDesc_td . '>' . htmlspecialchars($AllocationDesc) . '</td>
                <td ' . $FromAlloAccount_td . '>' . htmlspecialchars($FromAlloAccount) . '</td>
                <td ' . $AllocationMethod_td . '>' . htmlspecialchars($AllocationMethod) . '</td>
                <td>' . htmlspecialchars($ExpiredDate) . '</td>
                <td>' . ($Status == 1 ? 'Active' : 'Inactive') . '</td>
                <td ' . $Action_td . '>' . htmlspecialchars($Action) . '</td>
            </tr>  
            ';
                }
            } else {
                $output .= '<tr><td colspan="8" class="text-center">Tidak ada data ditemukan dalam file</td></tr>';
            }

            $output .= '</tbody></table>';

            $output .= '
    <div class="alert">
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
        $("#previewImportTable").DataTable({
            columnDefs: [{
                orderable: false,
                targets: [0, 7]
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
                    
                    $.post("' . site_url('tmstglallocationentry/upload') . '", {
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
                                
                                if ($("#glallocationTable").length && typeof $.fn.DataTable !== "undefined") {
                                    $("#glallocationTable").DataTable().ajax.reload(null, false);
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
                            text: "Request gagal: " . xhr.status
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
            if (!$this->session->get("fileupload") || !file_exists($this->session->get("fileupload"))) {
                return $this->response->setStatusCode(400)->setJSON([
                    'error' => 'File tidak ditemukan. Silakan upload ulang file.'
                ]);
            }

            $filePath = $this->session->get("fileupload");
            $action   = $this->session->get("action");

            try {
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
                        $rowNumber = $i + 1;

                        $AllocationNo = $sheetData[$i][0];
                        $AllocationDesc = $sheetData[$i][1];
                        $FromAlloAccount = $sheetData[$i][2];
                        $AllocationMethod = $sheetData[$i][3];
                        $ExpiredDate = $sheetData[$i][4];
                        $Status = $sheetData[$i][5];

                        if (empty($AllocationNo) || empty($AllocationDesc) || empty($FromAlloAccount) || empty($AllocationMethod)) {
                            $errorCount++;
                            $errors[] = "Baris $rowNumber: Data required kosong";
                            continue;
                        }

                        try {
                            $audtDate = date('Y-m-d');
                            $audtTime = date('H:i:s');
                            $audtUser = session()->get('usr_id') ?? 'SYSTEM';

                            if ($action == 'insert') {
                                // Check duplicate sebelum import
                                $isDuplicate = $this->checkDuplicate($AllocationNo);
                                if ($isDuplicate) {
                                    $errorCount++;
                                    $errors[] = "Baris $rowNumber: Allocation Number $AllocationNo sudah ada";
                                    continue;
                                }

                                // Untuk import, kita buat dengan detail kosong
                                $dataAllocation = [
                                    "AllocationNo" => trim($AllocationNo),
                                    "AllocationDesc" => trim($AllocationDesc),
                                    "FromAlloAccount" => trim($FromAlloAccount),
                                    "AllocationMethod" => trim($AllocationMethod),
                                    "ExpiredDate" => trim($ExpiredDate),
                                    "IsActive" => ($Status == 1 || strtoupper($Status) == 'ACTIVE') ? true : false,
                                    "AudtUser" => $audtUser,
                                    "AudtDate" => $audtDate,
                                    "AudtTime" => $audtTime,
                                    "Details" => [] // Detail kosong untuk import
                                ];

                                $url = "{$this->server3}/api/tmstglallocation";
                                $result = akses_restapikey('POST', $url, $dataAllocation, $query = []);
                                $result = is_string($result) ? json_decode($result, true) : $result;

                                if (isset($result['success']) && $result['success'] === true) {
                                    $successCount++;
                                } else {
                                    $errorCount++;
                                    $errors[] = "Baris $rowNumber: " . ($result['message'] ?? 'Gagal menyimpan data');
                                }
                            } else {
                                $errorCount++;
                                $errors[] = "Baris $rowNumber: Update tidak didukung untuk import";
                            }
                        } catch (\Exception $e) {
                            $errorCount++;
                            $errors[] = "Baris $rowNumber: " . $e->getMessage();
                        }
                    }

                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                    $this->session->remove("fileupload");
                    $this->session->remove("action");

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
