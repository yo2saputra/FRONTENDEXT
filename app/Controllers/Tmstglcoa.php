<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as excel;

class Tmstglcoa extends BaseController
{

    protected $data;
    protected $server;
    protected $server3;

    public function __construct()
    {
        $this->server = $_ENV['APP_API'];
        $this->server3 = $_ENV['APP_API3'];
    }

    public function index()
    {
        // helper dropdown
        helper(['dropdown']);
        $this->data['cb_account_structure'] = getDropdownAccountStructure('cb_account_structure', 'cb_account_structure');

        // Normal Balance
        $this->data['cb_normal_balance'] = getDropdownTfieldValue('normal_balance', 'cb_normal_balance');
        // Account Type
        $this->data['cb_account_type'] = getDropdownTfieldValue('account_type', 'cb_account_type');
        // Coa Status
        $this->data['cb_sta_coa'] = getDropdownTfieldValue('sta_coa', 'cb_sta_coa');

        // Segment Delimiter (-)
        $this->data['cb_segment_delimiter'] = getDropdownSegmentDelimiter('cb_segment_delimiter', 'cb_segment_delimiter');

        // Segment 2
        $this->data['cb_segment_2'] = getDropdownGlSegmentCoa('cb_segment_2', ['2']);
        // Segment 3
        $this->data['cb_segment_3'] = getDropdownGlSegmentCoa('cb_segment_3', ['3']);
        // Segment 4
        $this->data['cb_segment_4'] = getDropdownGlSegmentCoa('cb_segment_4', ['4']);
        // Segment 5
        $this->data['cb_segment_5'] = getDropdownGlSegmentCoa('cb_segment_5', ['5']);
        // Segment 6
        $this->data['cb_segment_6'] = getDropdownGlSegmentCoa('cb_segment_6', ['6']);
        // Segment 7
        $this->data['cb_segment_7'] = getDropdownGlSegmentCoa('cb_segment_7', ['7']);
        // Segment 8
        $this->data['cb_segment_8'] = getDropdownGlSegmentCoa('cb_segment_8', ['8']);
        // Segment 9
        $this->data['cb_segment_9'] = getDropdownGlSegmentCoa('cb_segment_9', ['9']);
        // Segment 10
        $this->data['cb_segment_10'] = getDropdownGlSegmentCoa('cb_segment_10', ['10']);

        return view('tmstglcoa/index', $this->data);
    }

    public function datatables()
    {
        helper(['restclient']);
        $rawBody = $this->request->getBody();
        $json = json_decode($rawBody, true);

        $url = "{$this->server3}/api/tmstcoa/datatables";
        $response = akses_restapikey('POST', $url, $json);

        $result = json_decode($response, true);

        // Tambahkan kolom aksi ke setiap data
        foreach ($result['data'] as $i => &$row) {
            $cd = $row['acctNo'];
            $row['rownum'] = $i + ($json['start'] ?? 0) + 1;
            $row['aksi'] = '
            <div class="btn-group">
                <a class="btn btn-sm btn-info view ' . ($this->session->get("flag_view") === 1 ? "" : "d-none") . '" data-acctno="' . $cd . '"><i class="fas fa-eye"></i></a>
                <a class="btn btn-sm btn-primary edit ' . ($this->session->get("flag_update") === 1 ? "" : "d-none") . '" data-acctno="' . $cd . '"><i class="fas fa-tags"></i></a>
                <a class="btn btn-sm btn-danger delete ' . ($this->session->get("flag_delete") === 1 ? "" : "d-none") . '" data-acctno="' . $cd . '"><i class="fas fa-trash"></i></a>
            </div>';
        }

        return $this->response->setJSON($result);
    }

    public function datatablesaccountgroup()
    {
        helper(['restclient']);
        $rawBody = $this->request->getBody();
        $json = json_decode($rawBody, true);

        $url = "{$this->server3}/api/tmstglaccountgroup/datatables";
        $response = akses_restapikey('POST', $url, $json);

        $result = json_decode($response, true);

        return $this->response->setJSON($result);
    }

    public function datatablesaccountclosing()
    {
        helper(['restclient']);
        $rawBody = $this->request->getBody();
        $json = json_decode($rawBody, true);

        $url = "{$this->server3}/api/tmstcoa/datatablescls";
        $response = akses_restapikey('POST', $url, $json);

        $result = json_decode($response, true);

        return $this->response->setJSON($result);
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $acctNo = $this->request->getVar('AcctNo');

            helper(['restclient']);

            $url = "{$this->server3}/api/tmstcoa/deactivate";
            $query = ['acctNo' => $acctNo];

            $result = akses_restapikey('PUT', $url, $body = [], $query);
            $result = is_string($result) ? json_decode($result, true) : $result;

            if (isset($result['success']) && $result['success'] === true) {
                return $this->response->setJSON([
                    'success' => true,
                    'status' => 'SUKSES',
                    'message' => $result['message'] ?? 'COA berhasil dihapus.'
                ]);
            } else {
                $status = $result['status'] ?? 'error';
                $message = $result['message'] ?? 'Gagal memproses permintaan';

                return $this->response->setJSON([
                    'success' => false,
                    'status' => $status,
                    'message' => $message
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

                $validationRules = [
                    'AcctNo' => [
                        'label' => 'Account Number',
                        'rules' => 'required',
                        'errors' => []
                    ],
                    'AcctName' => [
                        'label' => 'Account Name',
                        'rules' => 'required',
                        'errors' => []
                    ],
                    'AcctType' => [
                        'label' => 'Account Type',
                        'rules' => 'required',
                        'errors' => []
                    ],
                    'AccGrID' => [
                        'label' => 'Account Group',
                        'rules' => 'required',
                        'errors' => []
                    ],
                    'StructureID' => [
                        'label' => 'Account Structure',
                        'rules' => 'required',
                        'errors' => []
                    ],
                    'AcctBal' => [
                        'label' => 'Normal Balance',
                        'rules' => 'required',
                        'errors' => []
                    ]
                ];

                if (!$this->validate($validationRules)) {
                    return $this->response->setJSON([
                        'error' => [
                            'AcctNo'        => $validation->getError('AcctNo'),
                            'AcctName'      => $validation->getError('AcctName'),
                            'AcctType'      => $validation->getError('AcctType'),
                            'AccGrID'       => $validation->getError('AccGrID'),
                            'StructureID'   => $validation->getError('StructureID'),
                            'AcctBal'       => $validation->getError('AcctBal')
                        ]
                    ]);
                } else {
                    $acctNo = $this->request->getVar('AcctNo');
                    $excludeAcctNo = $this->request->getVar('hidden_id');

                    // Check duplicate untuk Add
                    if ($this->request->getVar('action') == 'Add') {
                        $isDuplicate = $this->checkDuplicate($acctNo, null);
                        if ($isDuplicate) {
                            return $this->response->setJSON([
                                'error' => [
                                    'AcctNo' => 'Account Number ' . $acctNo . ' sudah digunakan'
                                ]
                            ]);
                        }
                    }

                    if ($this->request->getVar('action') == 'Add') {
                        helper(['restclient']);

                        $userId = session()->get('usr_id') ?? 'SYSTEM';

                        $acctType = $this->request->getVar('AcctType');
                        $structureId = $this->request->getVar('StructureID');
                        $acctBal = $this->request->getVar('AcctBal');

                        $segmentData = [
                            "Segment1"  => $this->request->getVar('segment1_hidden') ?: '',
                            "Segment2"  => $this->request->getVar('segment2_hidden') ?: '',
                            "Segment3"  => $this->request->getVar('segment3_hidden') ?: '',
                            "Segment4"  => $this->request->getVar('segment4_hidden') ?: '',
                            "Segment5"  => $this->request->getVar('segment5_hidden') ?: '',
                            "Segment6"  => $this->request->getVar('segment6_hidden') ?: '',
                            "Segment7"  => $this->request->getVar('segment7_hidden') ?: '',
                            "Segment8"  => $this->request->getVar('segment8_hidden') ?: '',
                            "Segment9"  => $this->request->getVar('segment9_hidden') ?: '',
                            "Segment10" => $this->request->getVar('segment10_hidden') ?: '',
                            "Note1"     => $this->request->getVar('note1_hidden') ?: '',
                            "Note2"     => $this->request->getVar('note2_hidden') ?: ''
                        ];

                        $acvStatus = $this->request->getVar('cb_sta_coa') == '1';

                        $body = [
                            "AcctNo"       => $acctNo,
                            "AcctName"     => $this->request->getVar('AcctName'),
                            "AcctType"     => $acctType,
                            "AccGrId"      => $this->request->getVar('AccGrID'),
                            "StructureID"  => $structureId,
                            "AcctBal"      => $acctBal,
                            "AcctCls"      => $this->request->getVar('AccountClosing') ?: '',
                            "AcvStatus"    => $acvStatus,
                            "CreatedBy"    => $userId,
                            "UpdatedBy"    => $userId,
                            "HcurnCode"    => $this->request->getVar('HcurnCode') ?: 'IDR',
                            "Comment1"     => $this->request->getVar('Comment1') ?: '',
                            "Comment2"     => $this->request->getVar('Comment2') ?: '',
                            "Comment3"     => $this->request->getVar('Comment3') ?: '',
                            "Segment1"     => $segmentData["Segment1"],
                            "Segment2"     => $segmentData["Segment2"],
                            "Segment3"     => $segmentData["Segment3"],
                            "Segment4"     => $segmentData["Segment4"],
                            "Segment5"     => $segmentData["Segment5"],
                            "Segment6"     => $segmentData["Segment6"],
                            "Segment7"     => $segmentData["Segment7"],
                            "Segment8"     => $segmentData["Segment8"],
                            "Segment9"     => $segmentData["Segment9"],
                            "Segment10"    => $segmentData["Segment10"],
                            "Note1"        => $segmentData["Note1"],
                            "Note2"        => $segmentData["Note2"]
                        ];

                        $url = "{$this->server3}/api/tmstcoa/insert";
                        $result = akses_restapikey('POST', $url, $body, $query = []);
                        $result = is_string($result) ? json_decode($result, true) : $result;

                        if (isset($result['success']) && $result['success'] === true) {
                            return $this->response->setJSON([
                                'status' => 'success',
                                'message' => 'Data COA berhasil ditambahkan',
                                'data' => $result,
                                'redirect_url' => site_url('tmstglcoa/index')
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

                        $userId = session()->get('usr_id') ?? 'SYSTEM';

                        $acctType = $this->request->getVar('AcctType');
                        $structureId = $this->request->getVar('StructureID');
                        $acctBal = $this->request->getVar('AcctBal');

                        $segmentData = [
                            "Segment1"  => $this->request->getVar('segment1_hidden') ?: '',
                            "Segment2"  => $this->request->getVar('segment2_hidden') ?: '',
                            "Segment3"  => $this->request->getVar('segment3_hidden') ?: '',
                            "Segment4"  => $this->request->getVar('segment4_hidden') ?: '',
                            "Segment5"  => $this->request->getVar('segment5_hidden') ?: '',
                            "Segment6"  => $this->request->getVar('segment6_hidden') ?: '',
                            "Segment7"  => $this->request->getVar('segment7_hidden') ?: '',
                            "Segment8"  => $this->request->getVar('segment8_hidden') ?: '',
                            "Segment9"  => $this->request->getVar('segment9_hidden') ?: '',
                            "Segment10" => $this->request->getVar('segment10_hidden') ?: '',
                            "Note1"     => $this->request->getVar('note1_hidden') ?: '',
                            "Note2"     => $this->request->getVar('note2_hidden') ?: ''
                        ];

                        $acvStatus = $this->request->getVar('cb_sta_coa') == '1';

                        $body = [
                            "AcctNo"       => $acctNo,
                            "AcctName"     => $this->request->getVar('AcctName'),
                            "AcctType"     => $acctType,
                            "AccGrId"      => $this->request->getVar('AccGrID'),
                            "StructureID"  => $structureId,
                            "AcctBal"      => $acctBal,
                            "AcctCls"      => $this->request->getVar('AccountClosing') ?: '',
                            "AcvStatus"    => $acvStatus,
                            "CreatedBy"    => $userId,
                            "UpdatedBy"    => $userId,
                            "HcurnCode"    => $this->request->getVar('HcurnCode') ?: 'IDR',
                            "Comment1"     => $this->request->getVar('Comment1') ?: '',
                            "Comment2"     => $this->request->getVar('Comment2') ?: '',
                            "Comment3"     => $this->request->getVar('Comment3') ?: '',
                            "Segment1"     => $segmentData["Segment1"],
                            "Segment2"     => $segmentData["Segment2"],
                            "Segment3"     => $segmentData["Segment3"],
                            "Segment4"     => $segmentData["Segment4"],
                            "Segment5"     => $segmentData["Segment5"],
                            "Segment6"     => $segmentData["Segment6"],
                            "Segment7"     => $segmentData["Segment7"],
                            "Segment8"     => $segmentData["Segment8"],
                            "Segment9"     => $segmentData["Segment9"],
                            "Segment10"    => $segmentData["Segment10"],
                            "Note1"        => $segmentData["Note1"],
                            "Note2"        => $segmentData["Note2"]
                        ];

                        $url = "{$this->server3}/api/tmstcoa/update/{$acctNo}";
                        $result = akses_restapikey('PUT', $url, $body, $query = []);
                        $result = is_string($result) ? json_decode($result, true) : $result;

                        if (isset($result['success']) && $result['success'] === true) {
                            return $this->response->setJSON([
                                'status' => 'success',
                                'message' => 'Data COA berhasil diubah',
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
            } else {
                exit('Maaf tidak dapat diproses!');
            }
        }
    }

    private function checkDuplicate($acctNo, $excludeAcctNo = null)
    {
        helper(['restclient']);

        $url = "{$this->server3}/api/tmstcoa/checkduplicate";

        $body = [
            'AcctNo' => $acctNo,
            'ExcludeAcctNo' => $excludeAcctNo
        ];

        $response = akses_restapikey('POST', $url, $body);
        $result = is_string($response) ? json_decode($response, true) : $response;

        return isset($result['isDuplicate']) && $result['isDuplicate'] === true;
    }

    public function fetchSingleData()
    {
        if ($this->request->isAJAX()) {

            $AcctNo = $this->request->getVar('AcctNo');

            if ($AcctNo) {

                helper(['restclient']);

                $url = "{$this->server3}/api/tmstcoa/getby/{$AcctNo}";

                $response = akses_restapikey('GET', $url, $body = [], $query = []);
                $data = json_decode($response, true);

                if (isset($data['success']) && $data['success'] === true && !empty($data['data'])) {
                    $row = $data['data'];

                    $msg = [
                        'data' => [
                            'AcctNo'        => $row['acctNo'],
                            'AcctName'      => $row['acctName'],
                            'AcctType'      => $row['acctType'],
                            'AccGrID'       => $row['accGrId'],
                            'StructureID'   => $row['structureID'],
                            'StructureName' => $row['structureName'],
                            'AcctBal'       => $row['acctBal'],
                            'AcvStatus'     => $row['acvStatus'],
                            'CreatedDate'   => $row['createdDate'],
                            'CreatedBy'     => $row['createdBy'],
                            'UpdatedDate'   => $row['updatedDate'],
                            'UpdatedBy'     => $row['updatedBy'],
                            'AcctCls'       => $row['acctCls'],
                            'Comment1'      => $row['comment1'],
                            'Comment2'      => $row['comment2'],
                            'Comment3'      => $row['comment3'],
                            'CompanyID'     => $row['companyID'],
                            'AccGrName'     => $row['accGrName'],
                            'AcctTypeDesc'  => $row['acctTypeDesc'],
                            'AcctBalDesc'   => $row['acctBalDesc'],
                            'IsActiveDesc'  => $row['isActiveDesc'],
                            // ===== Data Segment =====
                            'Segment1'      => $row['segment1'],
                            'Segment2'      => $row['segment2'],
                            'Segment3'      => $row['segment3'],
                            'Segment4'      => $row['segment4'],
                            'Segment5'      => $row['segment5'],
                            'Segment6'      => $row['segment6'],
                            'Segment7'      => $row['segment7'],
                            'Segment8'      => $row['segment8'],
                            'Segment9'      => $row['segment9'],
                            'Segment10'     => $row['segment10'],
                            'Note1'         => $row['note1'],
                            'Note2'         => $row['note2']
                        ]
                    ];

                    return $this->response->setJSON($msg);
                }

                if (isset($data['success']) && $data['success'] === false) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => $data['message'] ?? 'Data tidak ditemukan'
                    ]);
                }

                return $this->response->setJSON([
                    'success' => false,
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
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = [
            'A1' => 'Account Number',
            'B1' => 'Account Name',
            'C1' => 'Account Type',
            'D1' => 'Account Group ID',
            'E1' => 'Structure ID',
            'F1' => 'Account Balance',
            'G1' => 'Currency',
            'H1' => 'Status',
            'I1' => 'Account Closing',
            'J1' => 'Commentar 1',
            'K1' => 'Commentar 2',
            'L1' => 'Commentar 3',
        ];

        foreach ($headers as $cell => $header) {
            $sheet->setCellValue($cell, $header);
        }

        $dataRows = [
            [
                '11101-00-00',
                'Petty Cash',
                'B',
                '110',
                'ACCT',
                'DB',
                'IDR',
                '1',
                '',
                '',
                '',
                ''
            ],
            [
                '32011-00-00',
                'Previous Year Retained Earnings',
                'R',
                '320',
                'ACCT',
                'CR',
                'IDR',
                '1',
                '',
                '',
                '',
                ''
            ],
            [
                '41110-10-01',
                'Medical Services Revenue - Polyclinic - Pediatrics',
                'I',
                '410',
                'ACCT',
                'CR',
                'IDR',
                '1',
                '32010-00-00',
                '',
                '',
                ''
            ]
        ];

        $row = 2;
        foreach ($dataRows as $data) {
            $sheet->setCellValue('A' . $row, $data[0]);
            $sheet->setCellValue('B' . $row, $data[1]);
            $sheet->setCellValue('C' . $row, $data[2]);
            $sheet->setCellValue('D' . $row, $data[3]);
            $sheet->setCellValue('E' . $row, $data[4]);
            $sheet->setCellValue('F' . $row, $data[5]);
            $sheet->setCellValue('G' . $row, $data[6]);
            $sheet->setCellValue('H' . $row, $data[7]);
            $sheet->setCellValue('I' . $row, $data[8]);
            $sheet->setCellValue('J' . $row, $data[9]);
            $sheet->setCellValue('K' . $row, $data[10]);
            $sheet->setCellValue('L' . $row, $data[11]);
            $row++;
        }

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(35);
        $sheet->getColumnDimension('C')->setWidth(12);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(12);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(10);
        $sheet->getColumnDimension('H')->setWidth(10);
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getColumnDimension('J')->setWidth(20);
        $sheet->getColumnDimension('K')->setWidth(20);
        $sheet->getColumnDimension('L')->setWidth(20);

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = "TEMPLATE_GL_COA.xlsx";

        if (ob_get_length()) {
            ob_end_clean();
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Expires: 0');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }

    public function upload()
    {
        if ($this->request->getMethod() !== "post") {
            return $this->response->setStatusCode(405)->setJSON([
                'error' => 'Method tidak diizinkan'
            ]);
        }

        $filePathEncoded = $this->request->getPost('file_path');
        $filePath = $filePathEncoded
            ? base64_decode($filePathEncoded)
            : $this->session->get("fileupload");

        if (!$filePath || !file_exists($filePath)) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'File tidak ditemukan. Silakan upload ulang file.'
            ]);
        }

        try {
            $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
            $reader = ($extension === 'csv') ? new Csv() : new Excel();

            $spreadsheet = $reader->load($filePath);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();

            if (empty($sheetData) || (count($sheetData) - 1) <= 0) {
                return $this->response->setStatusCode(400)->setJSON([
                    'error' => 'Tidak ada data yang dapat diimport dari file'
                ]);
            }

            helper(['restclient', 'dropdown']);

            $userId = $this->session->get('usr_id');
            $coas = [];

            for ($i = 1; $i < count($sheetData); $i++) {
                $AcctNo      = trim($sheetData[$i][0] ?? '');
                $AcctName    = trim($sheetData[$i][1] ?? '');
                $AcctType    = trim($sheetData[$i][2] ?? '');
                $AccGrID     = trim($sheetData[$i][3] ?? '');
                $StructureID = trim($sheetData[$i][4] ?? '');
                $AcctBal     = trim($sheetData[$i][5] ?? '');
                $HcurnCode   = trim($sheetData[$i][6] ?? '');
                $AcvStatus   = trim($sheetData[$i][7] ?? '');
                $AcctCls     = trim($sheetData[$i][8] ?? '');
                $Comment1    = $sheetData[$i][9] ?? '';
                $Comment2    = $sheetData[$i][10] ?? '';
                $Comment3    = $sheetData[$i][11] ?? '';

                $segments = explode('-', $AcctNo);
                $Segment1  = $segments[0] ?? '';
                $Segment2  = $segments[1] ?? '';
                $Segment3  = $segments[2] ?? '';
                $Segment4  = $segments[3] ?? '';
                $Segment5  = $segments[4] ?? '';
                $Segment6  = $segments[5] ?? '';
                $Segment7  = $segments[6] ?? '';
                $Segment8  = $segments[7] ?? '';
                $Segment9  = $segments[8] ?? '';
                $Segment10 = $segments[9] ?? '';

                for ($s = 0; $s < 10; $s++) {
                    if (isset($sheetData[$i][12 + $s]) && trim($sheetData[$i][12 + $s]) !== '') {
                        ${"Segment" . ($s + 1)} = trim($sheetData[$i][12 + $s]);
                    }
                }

                $coaData = [
                    "acctNo"       => substr($AcctNo, 0, 25),
                    "acctName"     => substr($AcctName, 0, 255),
                    "acctType"     => substr($AcctType, 0, 25),
                    "accGrID"      => substr($AccGrID, 0, 50),
                    "structureID"  => substr($StructureID, 0, 50),
                    "acctBal"      => substr($AcctBal, 0, 5),
                    "acvStatus"    => ($AcvStatus === '1'),
                    "createdDate"  => date('Y-m-d\TH:i:s'),
                    "createdBy"    => $userId,
                    "updatedDate"  => date('Y-m-d\TH:i:s'),
                    "updatedBy"    => $userId,
                    "acctCls"      => substr($AcctCls, 0, 50),
                    "comment1"     => $Comment1,
                    "comment2"     => $Comment2,
                    "comment3"     => $Comment3,
                    "companyID"    => '',
                    "hcurnCode"    => substr($HcurnCode, 0, 3) ?: 'IDR',
                    "segment1"     => substr($Segment1, 0, 100),
                    "segment2"     => substr($Segment2, 0, 100),
                    "segment3"     => substr($Segment3, 0, 100),
                    "segment4"     => substr($Segment4, 0, 100),
                    "segment5"     => substr($Segment5, 0, 100),
                    "segment6"     => substr($Segment6, 0, 100),
                    "segment7"     => substr($Segment7, 0, 100),
                    "segment8"     => substr($Segment8, 0, 100),
                    "segment9"     => substr($Segment9, 0, 100),
                    "segment10"    => substr($Segment10, 0, 100),
                    "note1"        => '',
                    "note2"        => ''
                ];

                $coas[] = $coaData;
            }

            if (!empty($coas)) {
                $payload = [
                    "coas" => $coas,
                    "isChunked" => false,
                    "chunkIndex" => 0
                ];

                $client = \Config\Services::curlrequest();
                $response = $client->request('POST', $this->server3 . "/api/tmstcoa/import", [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json'
                    ],
                    'body' => json_encode($payload),
                    'http_errors' => false,
                    'timeout' => 300,
                    'verify' => false
                ]);

                $responseData = json_decode($response->getBody(), true);

                if (isset($responseData['success']) && $responseData['success'] === false) {
                    if (isset($responseData['validations']) && !empty($responseData['validations'])) {

                        return $this->response->setJSON([
                            'success' => false,
                            'message' => $responseData['message'] ?? 'Terdapat data COA yang tidak valid',
                            'validations' => $responseData['validations']
                        ]);
                    } else {
                        @unlink($filePath);
                        $this->session->remove("fileupload");

                        return $this->response->setJSON([
                            'error' => $responseData['message'] ?? 'Import gagal'
                        ]);
                    }
                }

                if (isset($responseData['success']) && $responseData['success'] === true) {
                    @unlink($filePath);
                    $this->session->remove("fileupload");
                    $this->session->remove("fileupload_time");
                    $this->session->remove("action");

                    return $this->response->setJSON([
                        'success' => true,
                        'message' => $responseData['message'] ?? 'Import data berhasil',
                        'insertedCoa' => $responseData['insertedCoa'] ?? 0,
                        'insertedSegment' => $responseData['insertedSegment'] ?? 0
                    ]);
                }

                @unlink($filePath);
                $this->session->remove("fileupload");

                return $this->response->setJSON([
                    'error' => 'Response tidak dikenal dari server'
                ]);
            }

            @unlink($filePath);
            $this->session->remove("fileupload");

            return $this->response->setJSON([
                'error' => 'Tidak ada data yang diproses'
            ]);
        } catch (\Exception $e) {
            @unlink($filePath);
            $this->session->remove("fileupload");
            $this->session->remove("action");

            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ]);
        }
    }

    // ============================
    // PREVIEW FILE
    // ============================
    public function preview()
    {
        if ($this->request->getMethod() == "post") {
            $rules = $this->validate([
                'filename' => 'uploaded[filename]|max_size[filename,500]|ext_in[filename,csv,xlsx]',
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
                $filePath = $path . $newName;

                if ($filename->move($path, $newName)) {
                    // Simpan ke session
                    $this->session->set("fileupload", $filePath);
                    $this->session->set("fileupload_time", time());
                    $this->session->set("action", $this->request->getPost('pas'));

                    // Proses preview
                    return $this->processPreview($filePath);
                } else {
                    return $this->response->setStatusCode(500)->setJSON([
                        'error' => 'Gagal mengupload file'
                    ]);
                }
            } else {
                return $this->response->setStatusCode(400)->setJSON([
                    'error' => 'File yang diunggah harus berformat CSV atau Excel (maks 500KB)'
                ]);
            }
        }

        return $this->response->setStatusCode(405)->setJSON([
            'error' => 'Method tidak diizinkan'
        ]);
    }

    private function processPreview($filePath)
    {
        try {
            $arr_file = explode(".", $filePath);
            $extension = end($arr_file);

            if ('csv' == strtolower($extension)) {
                $reader = new Csv();
            } else {
                $reader = new Excel();
            }

            $spreadsheet = $reader->load($filePath);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();

            $output = '';
            $output .= '
        <br>
        <input type="hidden" id="current_file_path" value="' . base64_encode($filePath) . '">
        <div class="mb-3">
            <button type="button" id="postButton" class="btn btn-success btn-sm">
                <i class="fas fa-upload"></i> Import Data
            </button>
        </div>
        <table id="previewImportTable" class="table table-sm table-bordered table-striped">
        <thead>
            <tr>  
                <th>Account Number</th>
                <th>Account Name</th>
                <th>Account Type</th>
                <th>Account Group ID</th>
                <th>Structure ID</th>
                <th>Account Balance</th>
                <th>Currency</th>
                <th>Status</th>
                <th>Account Closing</th>
                <th>Segment1</th>
                <th>Segment2</th>
                <th>Segment3</th>
            </tr>
        </thead>
        <tbody>';

            if (!empty($sheetData) && count($sheetData) > 1) {
                for ($i = 1; $i < count($sheetData); $i++) {
                    $AcctNo = $sheetData[$i][0] ?? '';
                    $AcctName = $sheetData[$i][1] ?? '';
                    $AcctType = $sheetData[$i][2] ?? '';
                    $AccGrID = $sheetData[$i][3] ?? '';
                    $StructureID = $sheetData[$i][4] ?? '';
                    $AcctBal = $sheetData[$i][5] ?? '';
                    $HcurnCode = $sheetData[$i][6] ?? '';
                    $AcvStatus = $sheetData[$i][7] ?? '';
                    $AcctCls = $sheetData[$i][8] ?? '';

                    $segments = explode('-', $AcctNo);
                    $Segment1 = $segments[0] ?? '';
                    $Segment2 = $segments[1] ?? '';
                    $Segment3 = $segments[2] ?? '';

                    $output .= '  
            <tr>
                <td>' . htmlspecialchars($AcctNo) . '</td>
                <td>' . htmlspecialchars($AcctName) . '</td>
                <td>' . htmlspecialchars($AcctType) . '</td>
                <td>' . htmlspecialchars($AccGrID) . '</td>
                <td>' . htmlspecialchars($StructureID) . '</td>
                <td>' . htmlspecialchars($AcctBal) . '</td>
                <td>' . htmlspecialchars($HcurnCode) . '</td>
                <td>' . htmlspecialchars($AcvStatus) . '</td>
                <td>' . htmlspecialchars($AcctCls) . '</td>
                <td>' . htmlspecialchars($Segment1) . '</td>
                <td>' . htmlspecialchars($Segment2) . '</td>
                <td>' . htmlspecialchars($Segment3) . '</td>
            </tr>';
                }
            } else {
                $output .= '<tr><td colspan="12" class="text-center">Tidak ada data ditemukan dalam file</td></tr>';
            }

            $output .= '</tbody>';

            // Hanya render DataTable, tanpa button handler di sini
            $output .= '
        <script>
        $(document).ready(function() {
            $("#previewImportTable").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "pageLength": 10,
                "oLanguage": {
                    "sSearch": "Cari Data:",
                    "sInfoEmpty": "Tidak ada data",
                    "sInfo": "Total: _TOTAL_ data",
                    "sInfoFiltered": " dari _MAX_ data",
                    "sZeroRecords": "Data tidak ditemukan",
                    "oPaginate": {
                        "sFirst": "Awal",
                        "sPrevious": "Sebelum",
                        "sNext": "Berikut",
                        "sLast": "Akhir"
                    }
                }
            });
        });
        </script>';

            echo $output;
        } catch (\Exception $e) {
            echo '<div class="alert alert-danger">Error membaca file: ' . $e->getMessage() . '</div>';
        }
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
                    ['data' => 'acctNo', 'searchable' => true],
                    ['data' => 'acctName', 'searchable' => true],
                    ['data' => 'acctType', 'searchable' => true],
                    ['data' => 'accGrId', 'searchable' => true],
                    ['data' => 'structureID', 'searchable' => true],
                    ['data' => 'acctBal', 'searchable' => true],
                    ['data' => 'hcurnCode', 'searchable' => true],
                    ['data' => 'acvStatus', 'searchable' => true],
                    ['data' => 'acctCls', 'searchable' => true],
                    ['data' => 'comment1', 'searchable' => true],
                    ['data' => 'comment2', 'searchable' => true],
                    ['data' => 'comment3', 'searchable' => true]
                ],
                'order' => [['column' => 0, 'dir' => 'asc']]
            ];

            helper(['restclient']);
            $url = "{$this->server3}/api/tmstcoa/datatables";
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

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = [
            'A1' => 'Account Number',
            'B1' => 'Account Name',
            'C1' => 'Account Type',
            'D1' => 'Account Group ID',
            'E1' => 'Structure ID',
            'F1' => 'Account Balance',
            'G1' => 'Currency',
            'H1' => 'Status',
            'I1' => 'Account Closing',
            'J1' => 'Commentar 1',
            'K1' => 'Commentar 2',
            'L1' => 'Commentar 3',
        ];

        foreach ($headers as $cell => $header) {
            $sheet->setCellValue($cell, $header);
        }

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(12);
        $sheet->getColumnDimension('D')->setWidth(10);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('L')->setWidth(15);

        $row = 2;
        foreach ($allData as $item) {
            $sheet->setCellValue('A' . $row, $item['acctNo'] ?? '');
            $sheet->setCellValue('B' . $row, $item['acctName'] ?? '');
            $sheet->setCellValue('C' . $row, $item['acctType'] ?? '');
            $sheet->setCellValue('D' . $row, $item['accGrId'] ?? '');
            $sheet->setCellValue('E' . $row, $item['structureID'] ?? '');
            $sheet->setCellValue('F' . $row, $item['acctBal'] ?? '');
            $sheet->setCellValue('G' . $row, $item['hcurnCode'] ?? '');

            $acvStatus = $item['acvStatus'] ?? '';
            $sheet->setCellValue('H' . $row, is_bool($acvStatus) ? ($acvStatus ? '1' : '0') : $acvStatus);

            $sheet->setCellValue('I' . $row, $item['acctCls'] ?? '');
            $sheet->setCellValue('J' . $row, $item['comment1'] ?? '');
            $sheet->setCellValue('K' . $row, $item['comment2'] ?? '');
            $sheet->setCellValue('L' . $row, $item['comment3'] ?? '');
            $row++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = "COA_Export_" . date('Ymd_His') . ".xlsx";

        if (ob_get_length()) {
            ob_end_clean();
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Expires: 0');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }
}
