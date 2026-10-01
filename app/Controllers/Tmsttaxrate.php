<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Tmsttaxrate extends BaseController
{
    protected $data;
    protected $server;
    protected $server3;
    protected $client;

    public function __construct()
    {
        $this->server = $_ENV['APP_API'];
        $this->server3 = $_ENV['APP_API3'];
        $this->data['session'] = $this->session;
    }

    public function index()
    {
        helper(['dropdown']);
        return view('tmsttaxrate/index', $this->data);
    }

    public function datatablestaxclass()
    {
        helper(['restclient']);
        $rawBody = $this->request->getBody();
        $json = json_decode($rawBody, true);

        $url = "{$this->server3}/api/taxrate/datatablestaxclass";
        $response = akses_restapikey('POST', $url, $json);
        $result = json_decode($response, true);

        if (isset($result['data']) && is_array($result['data'])) {
            foreach ($result['data'] as $i => &$row) {
                $taxId = $row['TaxID'] ?? $row['taxID'] ?? $row['taxId'] ?? '';
                $taxName = $row['TaxName'] ?? $row['taxName'] ?? '';
                $actTaxPurch = $row['ActTaxPurch'] ?? $row['actTaxPurch'] ?? '';
                $actTaxPSales = $row['ActTaxPSales'] ?? $row['actTaxPSales'] ?? '';
                $isactive = $row['Isactive'] ?? $row['isactive'] ?? '';
                $status = $row['Status'] ?? $row['status'] ?? '';

                $taxData = [
                    'taxId' => $taxId,
                    'taxName' => $taxName,
                    'actTaxPSales' => $actTaxPSales,
                    'actTaxPurch' => $actTaxPurch,
                    'isactive' => $isactive,
                    'status' => $status
                ];

                $encodedData = base64_encode(json_encode($taxData));

                $row['rownum'] = $i + ($json['start'] ?? 0) + 1;
                $row['taxId'] = $taxId;
                $row['taxName'] = $taxName;
                $row['actTaxPSales'] = $actTaxPSales;
                $row['actTaxPurch'] = $actTaxPurch;
                $row['isactive'] = $isactive;
                $row['status'] = $status;
                $row['encoded_data'] = $encodedData;
            }
        }

        return $this->response->setJSON($result);
    }

    public function getTaxRateDetails()
    {
        if ($this->request->isAJAX()) {
            $taxId = $this->request->getVar('TaxId');

            if (empty($taxId)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Tax ID tidak boleh kosong',
                    'data' => []
                ]);
            }

            helper(['restclient']);

            $url = "{$this->server3}/api/taxrate/getbytaxid/{$taxId}";
            $response = akses_restapikey('GET', $url, []);
            $result = json_decode($response, true);

            if (isset($result['success']) && $result['success'] === true) {
                $data = $result['data'] ?? [];
                if (!is_array($data)) {
                    $data = [$data];
                }

                $mappedData = [];
                foreach ($data as $item) {
                    $mappedData[] = [
                        'taxId' => $item['taxId'] ?? $item['TaxId'] ?? '',
                        'taxRateName' => $item['taxRateName'] ?? $item['TaxRateName'] ?? '',
                        'lineNo' => (int)($item['line_No'] ?? $item['Line_No'] ?? $item['lineNo'] ?? $item['LineNo'] ?? 0),
                        'taxRate' => $item['taxRate'] ?? $item['TaxRate'] ?? '',
                        'createdBy' => $item['createdBy'] ?? $item['CreatedBy'] ?? '',
                        'createdDate' => $item['createdDate'] ?? $item['CreatedDate'] ?? '',
                    ];
                }

                return $this->response->setJSON([
                    'success' => true,
                    'data' => $mappedData
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $result['message'] ?? 'Gagal mengambil data',
                    'data' => []
                ]);
            }
        }
    }

    public function getDetailData()
    {
        if ($this->request->isAJAX()) {
            $taxId = $this->request->getVar('TaxId');
            $lineNo = $this->request->getVar('Line_No');

            if (empty($taxId) || empty($lineNo)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Parameter tidak lengkap',
                    'data' => null
                ]);
            }

            helper(['restclient']);

            $url = "{$this->server3}/api/taxrate/getdetail/{$taxId}/{$lineNo}";
            $response = akses_restapikey('GET', $url, []);
            $result = json_decode($response, true);

            if (isset($result['success']) && $result['success'] === true && !empty($result['data'])) {
                $data = $result['data'];
                return $this->response->setJSON([
                    'success' => true,
                    'data' => [
                        'taxId' => $data['TaxId'] ?? $data['taxId'] ?? '',
                        'taxRateName' => $data['TaxRateName'] ?? $data['taxRateName'] ?? '',
                        'lineNo' => (int)($data['Line_No'] ?? $data['lineNo'] ?? $data['line_No'] ?? 0),
                        'taxRate' => $data['TaxRate'] ?? $data['taxRate'] ?? '',
                    ]
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $result['message'] ?? 'Gagal mengambil data',
                    'data' => null
                ]);
            }
        }
    }

    public function fetchSingleData()
    {
        if ($this->request->isAJAX()) {
            $taxId = $this->request->getVar('TaxId');

            if ($taxId) {
                helper(['restclient']);

                $url = "{$this->server3}/api/taxrate/getby/{$taxId}";
                $response = akses_restapikey('GET', $url, []);
                $data = json_decode($response, true);

                if (isset($data['success']) && $data['success'] === true && !empty($data['data'])) {
                    $row = $data['data'];
                    if (is_array($row) && isset($row[0])) {
                        $row = $row[0];
                    }

                    $msg = [
                        'data' => [
                            'TaxId'          => $row['TaxId'] ?? $row['taxId'] ?? '',
                            'TaxRateName'    => $row['TaxRateName'] ?? $row['taxRateName'] ?? '',
                            'Line_No'        => $row['Line_No'] ?? $row['lineNo'] ?? $row['line_No'] ?? '',
                            'TaxRate'        => $row['TaxRate'] ?? $row['taxRate'] ?? '',
                            'CreatedBy'      => $row['CreatedBy'] ?? $row['createdBy'] ?? '',
                            'CreatedDate'    => $row['CreatedDate'] ?? $row['createdDate'] ?? '',
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

    public function action()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getVar('action')) {
                helper(['form', 'url']);

                $validation = \Config\Services::validation();
                $action = $this->request->getVar('action');

                if ($action == 'Add' || $action == 'Update') {
                    $validationRules = [
                        'TaxId' => [
                            'label' => 'Tax ID',
                            'rules' => 'required|max_length[50]|regex_match[/^[^\s]+$/]',
                            'errors' => [
                                'required' => 'Tax ID harus diisi',
                                'max_length' => 'Tax ID maksimal 50 karakter',
                                'regex_match' => 'Tax ID tidak boleh mengandung spasi'
                            ]
                        ],
                        'TaxRateName' => [
                            'label' => 'Tax Rate Name',
                            'rules' => 'required|max_length[100]',
                            'errors' => []
                        ],
                        'TaxRate' => [
                            'label' => 'Tax Rate',
                            'rules' => 'required|numeric',
                            'errors' => []
                        ]
                    ];

                    if (!$this->validate($validationRules)) {
                        return $this->response->setJSON([
                            'error' => [
                                'TaxId'          => $validation->getError('TaxId'),
                                'TaxRateName'    => $validation->getError('TaxRateName'),
                                'TaxRate'        => $validation->getError('TaxRate'),
                            ]
                        ]);
                    }
                }

                $taxId = $this->request->getVar('TaxId');
                $taxRateName = $this->request->getVar('TaxRateName');
                $taxRate = $this->request->getVar('TaxRate');
                $lineNo = $this->request->getVar('LineNo');

                if ($action == 'Update' || (!empty($lineNo) && $lineNo !== '0' && $lineNo !== '' && $lineNo !== null)) {
                    return $this->updateTaxRate($taxId, $taxRateName, (int)$lineNo, (float)$taxRate);
                } else {
                    return $this->saveTaxRate($taxId, $taxRateName, (float)$taxRate);
                }
            }
        }

        exit('Maaf tidak dapat diproses!');
    }

    private function saveTaxRate($taxId, $taxRateName, $taxRate)
    {
        helper(['restclient']);

        $taxRateFloat = (float)$taxRate;
        if ($taxRateFloat < 0 || $taxRateFloat > 99.99) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Tax Rate hanya boleh antara 0 - 99.99'
            ]);
        }

        $decimals = strlen(substr(strrchr((string)$taxRate, "."), 1));
        if ($decimals > 2) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Tax Rate hanya boleh 2 digit di belakang koma'
            ]);
        }

        $createdDate = date('Y-m-d\TH:i:s');
        $createdBy = session()->get('usr_id');

        $body = [
            "taxId" => $taxId,
            "taxRateName" => $taxRateName,
            "lineNo" => null,
            "taxRate" => $taxRateFloat,
            "createdBy" => $createdBy,
            "createdDate" => $createdDate,
        ];

        $url = "{$this->server3}/api/taxrate";
        $response = akses_restapikey('POST', $url, $body);
        $result = is_string($response) ? json_decode($response, true) : $response;

        if (isset($result['success']) && $result['success'] === true) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => $result['message'] ?? 'Data Tax Rate berhasil ditambahkan'
            ]);
        } else {
            $errorMsg = isset($result['message']) ? $result['message'] : 'Gagal menyimpan data';
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $errorMsg
            ]);
        }
    }

    private function updateTaxRate($taxId, $taxRateName, $lineNo, $taxRate)
    {
        helper(['restclient']);

        $taxRateFloat = (float)$taxRate;
        if ($taxRateFloat < 0 || $taxRateFloat > 99.99) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Tax Rate hanya boleh antara 0 - 99.99'
            ]);
        }

        $decimals = strlen(substr(strrchr((string)$taxRate, "."), 1));
        if ($decimals > 2) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Tax Rate hanya boleh 2 digit di belakang koma'
            ]);
        }

        $createdDate = date('Y-m-d\TH:i:s');
        $createdBy = session()->get('usr_id');

        $body = [
            "taxId" => $taxId,
            "taxRateName" => $taxRateName,
            "Line_No" => $lineNo,
            "taxRate" => $taxRateFloat,
            "createdBy" => $createdBy,
            "createdDate" => $createdDate,
        ];

        $url = "{$this->server3}/api/taxrate/update";
        $response = akses_restapikey('PUT', $url, $body);
        $result = is_string($response) ? json_decode($response, true) : $response;

        if (isset($result['success']) && $result['success'] === true) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data Tax Rate berhasil diupdate'
            ]);
        } else {
            $errorMsg = isset($result['message']) ? $result['message'] : 'Gagal menyimpan data';
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $errorMsg
            ]);
        }
    }

    public function deleteDetail()
    {
        if ($this->request->isAJAX()) {
            $taxId = $this->request->getVar('TaxId');
            $lineNo = $this->request->getVar('Line_No');

            if (empty($taxId) || empty($lineNo)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Parameter tidak lengkap'
                ]);
            }

            helper(['restclient']);

            $url = "{$this->server3}/api/taxrate/deletedetail";
            $query = [
                'TaxId' => $taxId,
                'Line_No' => $lineNo
            ];

            $response = akses_restapikey('DELETE', $url, [], $query);
            $result = is_string($response) ? json_decode($response, true) : $response;

            if (isset($result['success']) && $result['success'] === true) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Detail Tax Rate berhasil dihapus'
                ]);
            } else {
                $errorMsg = isset($result['message']) ? $result['message'] : 'Gagal menghapus detail';
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $errorMsg
                ]);
            }
        }
    }

    private function deleteTaxRate($taxId)
    {
        helper(['restclient']);

        $url = "{$this->server3}/api/taxrate";
        $query = ['TaxId' => $taxId];

        $response = akses_restapikey('DELETE', $url, [], $query);
        $result = is_string($response) ? json_decode($response, true) : $response;

        if (isset($result['success']) && $result['success'] === true) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data Tax Rate berhasil dihapus'
            ]);
        } else {
            $errorMsg = isset($result['message']) ? $result['message'] : 'Gagal menghapus data';
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $errorMsg
            ]);
        }
    }
}
