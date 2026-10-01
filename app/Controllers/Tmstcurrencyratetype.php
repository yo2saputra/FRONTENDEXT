<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as excel;

class Tmstcurrencyratetype extends BaseController
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
        helper(['dropdown']);

        $this->data['cb_status'] = getDropdownCurrencyRateTypeStatus('isactive', 'cb_status');

        return view('tmstcurrencyratetype/index', $this->data);
    }

    public function datatables()
    {
        helper(['restclient']);
        $rawBody = $this->request->getBody();
        $json = json_decode($rawBody, true);

        $url = "{$this->server3}/api/currencyratetype/datatables";
        $response = akses_restapikey('POST', $url, $json);

        if (empty($response)) {
            return $this->response->setJSON([
                'draw' => $json['draw'] ?? 1,
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => []
            ]);
        }

        $result = json_decode($response, true);

        if (!isset($result['data']) || !is_array($result['data'])) {
            $result = [
                'draw' => $json['draw'] ?? 1,
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => []
            ];
        }

        foreach ($result['data'] as $i => &$row) {
            $cd = $row['currencyRateTypeCode'] ?? '';
            $row['rownum'] = $i + ($json['start'] ?? 0) + 1;
            $row['aksi'] = '
            <div class="btn-group">
                <a class="btn btn-sm btn-info view ' . ($this->session->get("flag_view") === 1 ? "" : "d-none") . '" data-currencyratetypecode="' . $cd . '"><i class="fas fa-eye"></i></a>
                <a class="btn btn-sm btn-primary edit ' . ($this->session->get("flag_update") === 1 ? "" : "d-none") . '" data-currencyratetypecode="' . $cd . '"><i class="fas fa-tags"></i></a>
                <a class="btn btn-sm btn-danger delete ' . ($this->session->get("flag_delete") === 1 ? "" : "d-none") . '" data-currencyratetypecode="' . $cd . '"><i class="fas fa-trash"></i></a>
            </div>';
        }

        return $this->response->setJSON($result);
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $currencyRateTypeCode = $this->request->getVar('currencyRateTypeCode');

            if (empty($currencyRateTypeCode)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Kode Rate Type tidak boleh kosong'
                ]);
            }

            helper(['restclient']);

            $url = "{$this->server3}/api/currencyratetype";
            $query = ['currencyRateTypeCode' => $currencyRateTypeCode];

            $response = akses_restapikey('DELETE', $url, [], $query);

            if (empty($response)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Tidak ada response dari server'
                ]);
            }

            $result = is_string($response) ? json_decode($response, true) : $response;

            if ($result === null) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Response tidak valid'
                ]);
            }

            if (isset($result['success']) && $result['success'] === true) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => $result['message'] ?? 'Rate berhasil dihapus.'
                ]);
            } else {
                // Cek apakah ada status dari SP
                $status = $result['status'] ?? 'error';
                $message = $result['message'] ?? 'Gagal memproses permintaan';

                return $this->response->setJSON([
                    'status' => $status,
                    'message' => $message
                ]);
            }
        }
    }

    public function checkduplicate()
    {
        if ($this->request->isAJAX()) {
            $currencyRateTypeValue = $this->request->getVar('CurrencyRateTypeValue');
            $excludeCurrencyRateTypeCode = $this->request->getVar('ExcludeCurrencyRateTypeCode');

            helper(['restclient']);
            $url = "{$this->server3}/api/currencyratetype/checkduplicate";

            $body = [
                'currencyRateTypeValue' => $currencyRateTypeValue,
                'excludeCurrencyRateTypeCode' => $excludeCurrencyRateTypeCode
            ];

            $response = akses_restapikey('POST', $url, $body);
            $result = is_string($response) ? json_decode($response, true) : $response;

            return $this->response->setJSON([
                'isDuplicate' => isset($result['isDuplicate']) && $result['isDuplicate'] === true,
                'message' => $result['message'] ?? ''
            ]);
        }
    }

    function action()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getVar('action')) {
                helper(['form', 'url']);

                $validation = \Config\Services::validation();

                $validationRules = [
                    'CurrencyRateTypeValue' => [
                        'label' => 'Rate Type Code',
                        'rules' => 'required|max_length[50]',
                    ],
                    'CurrencyRateTypeName' => [
                        'label' => 'Rate Type Name',
                        'rules' => 'required|max_length[50]',
                    ],
                    'CurrencyRate' => [
                        'label' => 'Rate',
                        'rules' => 'required|decimal',
                    ]
                ];

                if (!$this->validate($validationRules)) {
                    return $this->response->setJSON([
                        'error' => [
                            'CurrencyRateTypeValue' => $validation->getError('CurrencyRateTypeValue'),
                            'CurrencyRateTypeName' => $validation->getError('CurrencyRateTypeName'),
                            'CurrencyRate' => $validation->getError('CurrencyRate'),
                        ]
                    ]);
                } else {
                    $currencyRateTypeValue = $this->request->getVar('CurrencyRateTypeValue');
                    $hiddenId = $this->request->getVar('hidden_id');
                    $action = $this->request->getVar('action');

                    $isDuplicate = $this->checkDuplicateInternal($currencyRateTypeValue, $action == 'Edit' ? $hiddenId : null);
                    if ($isDuplicate) {
                        return $this->response->setJSON([
                            'error' => [
                                'CurrencyRateTypeValue' => 'Data dengan Rate Type Code "' . $currencyRateTypeValue . '" sudah ada'
                            ]
                        ]);
                    }

                    if ($action == 'Add') {
                        helper(['restclient']);
                        $url = "{$this->server3}/api/currencyratetype";

                        $createdDate = date('Y-m-d');
                        $createdBy = session()->get('usr_id');
                        $isActive = $this->request->getVar('cb_status');
                        $isActiveBool = $isActive === '1' ? true : false;
                        $currencyRate = $this->request->getVar('CurrencyRate');

                        $body = [
                            "currencyRateTypeValue" => $currencyRateTypeValue,
                            "currencyRateTypeName" => $this->request->getVar('CurrencyRateTypeName'),
                            "currencyRate" => (float)$currencyRate,
                            "isActive" => $isActiveBool,
                            "createdBy" => $createdBy,
                            "createdDate" => $createdDate,
                        ];

                        $response = akses_restapikey('POST', $url, $body);

                        if (empty($response)) {
                            return $this->response->setJSON([
                                'status' => 'error',
                                'message' => 'Tidak ada response dari server'
                            ]);
                        }

                        $result = is_string($response) ? json_decode($response, true) : $response;

                        if ($result === null) {
                            return $this->response->setJSON([
                                'status' => 'error',
                                'message' => 'Response tidak valid'
                            ]);
                        }

                        if (isset($result['status']) && $result['status'] == 'DUPLICATE') {
                            return $this->response->setJSON([
                                'error' => [
                                    'CurrencyRateTypeValue' => $result['message'] ?? 'Data sudah ada'
                                ]
                            ]);
                        }

                        if (isset($result['success']) && $result['success'] === true) {
                            return $this->response->setJSON([
                                'status' => 'success',
                                'message' => 'Rate berhasil ditambahkan',
                                'data' => $result,
                            ]);
                        } else {
                            return $this->response->setJSON([
                                'status' => 'error',
                                'message' => $result['message'] ?? 'Gagal menambahkan data',
                            ]);
                        }
                    }

                    if ($action == 'Edit') {
                        helper(['restclient']);
                        $url = "{$this->server3}/api/currencyratetype";
                        $query = ['currencyRateTypeCode' => $hiddenId];

                        $isActive = $this->request->getVar('cb_status');
                        $isActiveBool = $isActive === '1' ? true : false;
                        $currencyRate = $this->request->getVar('CurrencyRate');

                        $body = [
                            "currencyRateTypeValue" => $currencyRateTypeValue,
                            "currencyRateTypeName" => $this->request->getVar('CurrencyRateTypeName'),
                            "currencyRate" => (float)$currencyRate,
                            "isActive" => $isActiveBool,
                        ];

                        $response = akses_restapikey('PUT', $url, $body, $query);

                        if (empty($response)) {
                            return $this->response->setJSON([
                                'status' => 'error',
                                'message' => 'Tidak ada response dari server'
                            ]);
                        }

                        $result = is_string($response) ? json_decode($response, true) : $response;

                        if ($result === null) {
                            return $this->response->setJSON([
                                'status' => 'error',
                                'message' => 'Response tidak valid'
                            ]);
                        }

                        if (isset($result['success']) && $result['success'] === true) {
                            return $this->response->setJSON([
                                'status' => 'success',
                                'message' => 'Rate berhasil diubah',
                                'data' => $result,
                            ]);
                        } else {
                            return $this->response->setJSON([
                                'status' => 'error',
                                'message' => $result['message'] ?? 'Gagal mengubah data',
                            ]);
                        }
                    }
                }
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    private function checkDuplicateInternal($currencyRateTypeValue, $excludeCurrencyRateTypeCode = null)
    {
        helper(['restclient']);
        $url = "{$this->server3}/api/currencyratetype/checkduplicate";

        $body = [
            'currencyRateTypeValue' => $currencyRateTypeValue,
            'excludeCurrencyRateTypeCode' => $excludeCurrencyRateTypeCode
        ];

        $response = akses_restapikey('POST', $url, $body);
        $result = is_string($response) ? json_decode($response, true) : $response;

        return isset($result['isDuplicate']) && $result['isDuplicate'] === true;
    }

    public function fetchSingleData()
    {
        if ($this->request->isAJAX()) {
            $currencyRateTypeCode = $this->request->getVar('CurrencyRateTypeCode');

            if ($currencyRateTypeCode) {
                helper(['restclient']);

                $url = "{$this->server3}/api/currencyratetype/getby/{$currencyRateTypeCode}";
                $response = akses_restapikey('GET', $url);
                $data = json_decode($response, true);

                if (isset($data['success']) && $data['success'] === true && !empty($data['data'])) {
                    $row = $data['data'];

                    $msg = [
                        'data' => [
                            'CurrencyRateTypeCode' => $row['currencyRateTypeCode'] ?? '',
                            'CurrencyRateTypeValue' => $row['currencyRateTypeValue'] ?? '',
                            'CurrencyRateTypeName' => $row['currencyRateTypeName'] ?? '',
                            'CurrencyRate' => $row['currencyRate'] ?? '',
                            'cb_status' => isset($row['isActive']) ? ($row['isActive'] ? '1' : '0') : '',
                            'StatusDesc' => $row['statusDesc'] ?? '',
                            'CreatedBy' => $row['createdBy'] ?? '',
                            'CreatedDate' => $row['createdDate'] ?? '',
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

    public function download()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = [
            'A1' => 'Currency Rate Type Value',
            'B1' => 'Currency Rate Type Name',
            'C1' => 'Currency Rate',
            'D1' => 'Status (1/0)'
        ];

        foreach ($headers as $cell => $header) {
            $sheet->setCellValue($cell, $header);
        }

        $sheet->getColumnDimension('A')->setWidth(25);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(15);

        $examples = [
            ['Rupiah', 'Indonesian Rupiah', '1.00000000', '1'],
            ['USD', 'US Dollar', '0.00006250', '1'],
            ['EUR', 'Euro', '0.00005800', '0'],
        ];

        $row = 2;
        foreach ($examples as $example) {
            $sheet->setCellValue('A' . $row, $example[0]);
            $sheet->setCellValue('B' . $row, $example[1]);
            $sheet->setCellValue('C' . $row, $example[2]);
            $sheet->setCellValue('D' . $row, $example[3]);
            $row++;
        }

        $sheet->getStyle('C2:C' . ($row - 1))->getNumberFormat()->setFormatCode('0.00000000');

        $writer = new Xlsx($spreadsheet);
        $filename = "TEMPLATE_CURRENCY_RATE_TYPE_" . date('Ymd_His') . ".xlsx";
        $writer->save($filename);

        return $this->response->download($filename, null)->setFileName("TEMPLATE CURRENCY RATE TYPE.xlsx");
    }

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
                <th>Currency Rate Type Value</th>
                <th>Currency Rate Type Name</th>
                <th>Currency Rate</th>
                <th>Is Active</th>
            </tr>
        </thead>
    <tbody>';

            $kosong = 0;
            $totalRows = 0;

            if (!empty($sheetData) && count($sheetData) > 1) {
                $totalRows = count($sheetData) - 1;

                for ($i = 1; $i < count($sheetData); $i++) {
                    $rowNumber = $i;
                    $CurrencyRateTypeValue = $sheetData[$i][0] ?? '';
                    $CurrencyRateTypeName = $sheetData[$i][1] ?? '';
                    $CurrencyRate = $sheetData[$i][2] ?? '';
                    $IsActive = $sheetData[$i][3] ?? '';

                    $CurrencyRateTypeValue_td = (!empty($CurrencyRateTypeValue)) ? "" : " style='background: #E07171;'";
                    $CurrencyRateTypeName_td = (!empty($CurrencyRateTypeName)) ? "" : " style='background: #E07171;'";
                    $CurrencyRate_td = (!empty($CurrencyRate)) ? "" : " style='background: #E07171;'";
                    $IsActive_td = (!empty($IsActive)) ? "" : " style='background: #E07171;'";

                    if (empty($CurrencyRateTypeValue) || empty($CurrencyRateTypeName) || empty($CurrencyRate) || empty($IsActive)) {
                        $kosong++;
                    }

                    $output .= '  
            <tr>
                <td class="text-center">' . $rowNumber . '</td>
                <td ' . $CurrencyRateTypeValue_td . '>' . htmlspecialchars($CurrencyRateTypeValue) . '</td>
                <td ' . $CurrencyRateTypeName_td . '>' . htmlspecialchars($CurrencyRateTypeName) . '</td>
                <td ' . $CurrencyRate_td . '>' . htmlspecialchars($CurrencyRate) . '</td>
                <td ' . $IsActive_td . '>' . htmlspecialchars($IsActive) . '</td>
            </tr>  
            ';
                }
            } else {
                $output .= '<tr><td colspan="5" class="text-center">Tidak ada data ditemukan dalam file</td></tr>';
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
                targets: [0]
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
                    
                    $.post("' . site_url('tmstcurrencyratetype/upload') . '", {
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
                                
                                if ($("#currencyratetypeTable").length && typeof $.fn.DataTable !== "undefined") {
                                    $("#currencyratetypeTable").DataTable().ajax.reload(null, false);
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

                        $currencyRateTypeValue = trim($sheetData[$i][0] ?? '');
                        $currencyRateTypeName = trim($sheetData[$i][1] ?? '');
                        $currencyRate = trim($sheetData[$i][2] ?? '');
                        $isActive = trim($sheetData[$i][3] ?? '');

                        if (empty($currencyRateTypeValue) || empty($currencyRateTypeName) || empty($currencyRate) || empty($isActive)) {
                            $errorCount++;
                            $errors[] = "Baris $rowNumber: Data required kosong";
                            continue;
                        }

                        if (strlen($currencyRateTypeValue) > 50) {
                            $errorCount++;
                            $errors[] = "Baris $rowNumber: Rate Value terlalu panjang (max 50 karakter)";
                            continue;
                        }

                        if (strlen($currencyRateTypeName) > 50) {
                            $errorCount++;
                            $errors[] = "Baris $rowNumber: Rate Name terlalu panjang (max 50 karakter)";
                            continue;
                        }

                        if (!is_numeric($currencyRate)) {
                            $errorCount++;
                            $errors[] = "Baris $rowNumber: Rate harus berupa angka";
                            continue;
                        }

                        try {
                            $createdDate = date('Y-m-d');
                            $createdBy = session()->get('usr_id');

                            if ($action == 'insert') {
                                $isActiveBool = $isActive === '1' ? true : false;

                                $data = [
                                    "currencyRateTypeValue" => $currencyRateTypeValue,
                                    "currencyRateTypeName" => $currencyRateTypeName,
                                    "currencyRate" => (float)$currencyRate,
                                    "isActive" => $isActiveBool,
                                    "createdBy" => $createdBy,
                                    "createdDate" => $createdDate,
                                ];

                                $url = "{$this->server3}/api/currencyratetype";
                                $result = akses_restapikey('POST', $url, $data);
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

    public function exportExcel()
    {
        $allData = [];
        $start = 0;
        $batchSize = 500;

        do {
            $json = [
                'start' => $start,
                'length' => $batchSize,
                'search' => ['value' => ''],
                'columns' => [
                    ['data' => 'currencyRateTypeValue', 'searchable' => true],
                    ['data' => 'currencyRateTypeName', 'searchable' => true],
                    ['data' => 'currencyRate', 'searchable' => true],
                    ['data' => 'createdBy', 'searchable' => true],
                    ['data' => 'createdDate', 'searchable' => true],
                    ['data' => 'statusDesc', 'searchable' => true]
                ],
                'order' => [['column' => 0, 'dir' => 'asc']]
            ];

            helper(['restclient']);
            $url = "{$this->server3}/api/currencyratetype/datatables";
            $response = akses_restapikey('POST', $url, $json);
            $result = json_decode($response, true);

            if (isset($result['data']) && is_array($result['data']) && count($result['data']) > 0) {
                $allData = array_merge($allData, $result['data']);
                $start += $batchSize;
            } else {
                break;
            }

            if (count($allData) > 10000) {
                break;
            }
        } while (isset($result['data']) && count($result['data']) === $batchSize);

        if (empty($allData)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Tidak ada data untuk diexport'
            ]);
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Rate Value');
        $sheet->setCellValue('B1', 'Rate Name');
        $sheet->setCellValue('C1', 'Rate');
        $sheet->setCellValue('D1', 'Created By');
        $sheet->setCellValue('E1', 'Created Date');
        $sheet->setCellValue('F1', 'Status');

        $row = 2;
        foreach ($allData as $item) {
            $sheet->setCellValue('A' . $row, $item['currencyRateTypeValue'] ?? '');
            $sheet->setCellValue('B' . $row, $item['currencyRateTypeName'] ?? '');
            if (isset($item['currencyRate']) && $item['currencyRate'] !== '') {
                $sheet->setCellValue('C' . $row, (float)$item['currencyRate']);
            } else {
                $sheet->setCellValue('C' . $row, '');
            }
            $sheet->setCellValue('D' . $row, $item['createdBy'] ?? '');
            if (isset($item['createdDate'])) {
                $date = date('d/m/Y', strtotime($item['createdDate']));
                $sheet->setCellValue('E' . $row, $date);
            } else {
                $sheet->setCellValue('E' . $row, '');
            }
            $sheet->setCellValue('F' . $row, $item['statusDesc'] ?? '');
            $row++;
        }

        $sheet->getStyle('C2:C' . ($row - 1))->getNumberFormat()->setFormatCode('0.00000000');

        foreach (range('A', 'F') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Export_Currency_Rate_' . date('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Expires: 0');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }

    public function printData()
    {
        $allData = [];
        $start = 0;
        $batchSize = 500;

        do {
            $json = [
                'start' => $start,
                'length' => $batchSize,
                'search' => ['value' => ''],
                'columns' => [
                    ['data' => 'currencyRateTypeValue', 'searchable' => true],
                    ['data' => 'currencyRateTypeName', 'searchable' => true],
                    ['data' => 'currencyRate', 'searchable' => true],
                    ['data' => 'createdBy', 'searchable' => true],
                    ['data' => 'createdDate', 'searchable' => true],
                    ['data' => 'statusDesc', 'searchable' => true]
                ],
                'order' => [['column' => 0, 'dir' => 'asc']]
            ];

            helper(['restclient']);
            $url = "{$this->server3}/api/currencyratetype/datatables";
            $response = akses_restapikey('POST', $url, $json);
            $result = json_decode($response, true);

            if (isset($result['data']) && is_array($result['data']) && count($result['data']) > 0) {
                $allData = array_merge($allData, $result['data']);
                $start += $batchSize;
            } else {
                break;
            }

            if (count($allData) > 10000) {
                break;
            }
        } while (isset($result['data']) && count($result['data']) === $batchSize);

        return $this->response->setJSON($allData);
    }
}
