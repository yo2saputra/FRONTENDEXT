<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as excel;

class Tdocnumberformat extends BaseController
{
    protected $data;
    protected $server3;

    public function __construct()
    {
        $this->server3 = $_ENV['APP_API3'];
    }

    public function index()
    {
        // helper dropdown
        helper(['dropdown']);

        $this->data['cb_reset_type'] = getDropdownNolabelVertical2('reset_type', 'resetType');

        return view('tdocnumberformat/index', $this->data);
    }

    public function datatables()
    {
        helper(['restclient']);
        $rawBody = $this->request->getBody();
        $json = json_decode($rawBody, true);

        $url = "{$this->server3}/api/docnumberformat/datatables";
        $response = akses_restapikey('POST', $url, $json);
        $result = json_decode($response, true);

        // Tambahkan kolom aksi ke setiap data
        foreach ($result['data'] as $i => &$row) {
            $docType = $row['docType'];
            $row['rownum'] = $i + ($json['start'] ?? 0) + 1;
            $row['aksi'] = '
            <div class="btn-group">
                <a class="btn btn-sm btn-info view ' . ($this->session->get("flag_view") === 1 ? "" : "d-none") . '" data-doc_type="' . $docType . '"><i class="fas fa-eye"></i></a>
                <a class="btn btn-sm btn-primary edit ' . ($this->session->get("flag_update") === 1 ? "" : "d-none") . '" data-doc_type="' . $docType . '"><i class="fas fa-tags"></i></a>
                <a class="btn btn-sm btn-danger delete ' . ($this->session->get("flag_delete") === 1 ? "" : "d-none") . '" data-doc_type="' . $docType . '"><i class="fas fa-trash"></i></a>
            </div>';
        }

        return $this->response->setJSON($result);
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $doc_type = $this->request->getVar('doc_type');

            helper(['restclient']);
            $url = "{$this->server3}/api/docnumberformat?doc_type=" . urlencode($doc_type);

            $result = akses_restapikey('DELETE', $url);
            $result = is_string($result) ? json_decode($result, true) : $result;

            if (isset($result['success']) && $result['success'] === true) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => $result['message'] ?? 'Format dokumen berhasil dihapus',
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

    public function action()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getVar('action')) {
                helper(['form', 'url']);

                $validation = \Config\Services::validation();
                $valid = $this->validate([
                    'docType' => [
                        'label' => 'Tipe Dokumen',
                        'rules' => 'required',
                        'errors' => []
                    ],
                    'formatPattern' => [
                        'label' => 'Format Pattern',
                        'rules' => 'required',
                        'errors' => []
                    ],
                    'resetType' => [
                        'label' => 'Reset Type',
                        'rules' => 'required',
                        'errors' => []
                    ],
                    'sequenceName' => [
                        'label' => 'Sequence Name',
                        'rules' => 'required',
                        'errors' => []
                    ]
                ]);

                if (!$valid) {
                    return $this->response->setJSON([
                        'error' => [
                            'docType' => $validation->getError('docType'),
                            'formatPattern' => $validation->getError('formatPattern'),
                            'resetType' => $validation->getError('resetType'),
                            'sequenceName' => $validation->getError('sequenceName')
                        ]
                    ]);
                } else {
                    helper(['restclient']);

                    if ($this->request->getVar('action') == 'Add') {
                        $url = "{$this->server3}/api/docnumberformat";

                        $body = [
                            "docType" => $this->request->getVar('docType'),
                            "formatPattern" => $this->request->getVar('formatPattern'),
                            "resetType" => $this->request->getVar('resetType'),
                            "sequenceName" => $this->request->getVar('sequenceName')
                        ];

                        $result = akses_restapikey('POST', $url, $body);
                        $result = is_string($result) ? json_decode($result, true) : $result;

                        if (isset($result['success']) && $result['success'] === true) {
                            return $this->response->setJSON([
                                'status' => 'success',
                                'message' => 'Format dokumen berhasil ditambahkan',
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
                        // $url = "{$this->server3}/api/docnumberformat?doc_type=" . urlencode($this->request->getVar('docType'));
                        $url = "{$this->server3}/api/docnumberformat";
                        $query = ['doc_type' => trim($this->request->getVar('docType'))];
                        $body = [
                            "docType" => $this->request->getVar('docType'),
                            "formatPattern" => $this->request->getVar('formatPattern'),
                            "resetType" => $this->request->getVar('resetType'),
                            "sequenceName" => $this->request->getVar('sequenceName')
                        ];

                        $result = akses_restapikey('PUT', $url, $body, $query);
                        $result = is_string($result) ? json_decode($result, true) : $result;

                        if (isset($result['success']) && $result['success'] === true) {
                            return $this->response->setJSON([
                                'status' => 'success',
                                'message' => 'Format dokumen berhasil diubah',
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

    public function fetchSingleData()
    {
        if ($this->request->isAJAX()) {
            $doc_type = $this->request->getVar('doc_type');

            if ($doc_type) {
                helper(['restclient']);
                $url = "{$this->server3}/api/docnumberformat/getby/{$doc_type}";

                $response = akses_restapikey('GET', $url);
                $data = json_decode($response, true);

                if (isset($data['success']) && $data['success'] === true) {
                    $formatData = $data['data'];

                    $msg = [
                        'data' => [
                            'docType' => $formatData['docType'] ?? '',
                            'formatPattern' => $formatData['formatPattern'] ?? '',
                            'resetType' => $formatData['resetType'] ?? '',
                            'sequenceName' => $formatData['sequenceName'] ?? ''
                        ]
                    ];

                    return $this->response->setJSON($msg);
                } else {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'Data tidak ditemukan'
                    ]);
                }
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    public function download()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue("A1", "TIPE DOKUMEN");
        $sheet->setCellValue("B1", "FORMAT PATTERN");
        $sheet->setCellValue("C1", "RESET TYPE");
        $sheet->setCellValue("D1", "SEQUENCE NAME");

        $count = 2;
        $sheet->setCellValue("A" . $count, "INVOICE");
        $sheet->setCellValue("B" . $count, "{PREFIX}/{YEAR}/{MONTH}/{DAY}/{SEQ:5}");
        $sheet->setCellValue("C" . $count, "DAILY");
        $sheet->setCellValue("D" . $count, "SEQ_INVOICE");

        $count = 3;
        $sheet->setCellValue("A" . $count, "PO");
        $sheet->setCellValue("B" . $count, "{COMPANY}/{BRANCH}/{PREFIX}/{YEAR}/{SEQ:6}");
        $sheet->setCellValue("C" . $count, "MONTHLY");
        $sheet->setCellValue("D" . $count, "SEQ_PO");

        $writer = new Xlsx($spreadsheet);
        $writer->save("data.xlsx");
        return $this->response->download("data.xlsx", null)->setFileName("TEMPLATE FORMAT DOKUMEN.xlsx");
    }
}
