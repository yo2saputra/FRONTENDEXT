<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Tmsttaxclass extends BaseController
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

        $this->data['cb_account_tax_sales'] = getDropdownAccountTaxSales('ActTaxPSales', 'cb_account_tax_sales');
        $this->data['cb_account_tax_purchase'] = getDropdownAccountTaxPurchase('ActTaxPurch', 'cb_account_tax_purchase');

        return view('tmsttaxclass/index', $this->data);
    }

    public function datatables()
    {
        helper(['restclient']);
        $rawBody = $this->request->getBody();
        $json = json_decode($rawBody, true);

        $url = "{$this->server3}/api/taxclass/datatables";
        $response = akses_restapikey('POST', $url, $json);
        $result = json_decode($response, true);

        if (isset($result['data']) && is_array($result['data'])) {
            foreach ($result['data'] as $i => &$row) {
                $taxId = $row['taxID'] ?? $row['TaxID'] ?? $row['taxId'] ?? '';
                $taxName = $row['taxName'] ?? $row['TaxName'] ?? '';
                $actTaxPSales = $row['actTaxPSales'] ?? $row['ActTaxPSales'] ?? '';
                $actTaxPurch = $row['actTaxPurch'] ?? $row['ActTaxPurch'] ?? '';
                $isactive = $row['isactive'] ?? $row['Isactive'] ?? '';

                $statusText = '';
                if (is_bool($isactive) || is_numeric($isactive)) {
                    $statusText = ($isactive == 1 || $isactive === true) ? 'Active' : 'Inactive';
                } else {
                    $statusText = $isactive;
                }

                $taxData = [
                    'taxId' => $taxId,
                    'taxName' => $taxName,
                    'actTaxPSales' => $actTaxPSales,
                    'actTaxPurch' => $actTaxPurch,
                    'isactive' => $isactive,
                    'status' => $statusText
                ];

                $encodedData = base64_encode(json_encode($taxData));

                $row['rownum'] = $i + ($json['start'] ?? 0) + 1;
                $row['taxId'] = $taxId;
                $row['taxName'] = $taxName;
                $row['actTaxPSales'] = $actTaxPSales;
                $row['actTaxPurch'] = $actTaxPurch;
                $row['isactive'] = $isactive;
                $row['status'] = $statusText;
                $row['encoded_data'] = $encodedData;
            }
        }

        return $this->response->setJSON($result);
    }

    public function fetchSingleData()
    {
        if ($this->request->isAJAX()) {
            $taxId = $this->request->getVar('TaxId');

            if ($taxId) {
                helper(['restclient']);

                $url = "{$this->server3}/api/taxclass/getby/{$taxId}";
                $response = akses_restapikey('GET', $url, []);
                $data = json_decode($response, true);

                if (isset($data['success']) && $data['success'] === true && !empty($data['data'])) {
                    $row = $data['data'];

                    $isActive = $row['isactive'] ?? $row['Isactive'] ?? false;
                    $checked = (is_bool($isActive) && $isActive) || (is_numeric($isActive) && $isActive == 1);

                    $msg = [
                        'data' => [
                            'TaxId' => $row['taxID'] ?? $row['TaxID'] ?? $row['TaxId'] ?? '',
                            'TaxName' => $row['taxName'] ?? $row['TaxName'] ?? '',
                            'ActTaxPSales' => $row['actTaxPSales'] ?? $row['ActTaxPSales'] ?? '',
                            'ActTaxPurch' => $row['actTaxPurch'] ?? $row['ActTaxPurch'] ?? '',
                            'Isactive' => $isActive,
                            'IsactiveChecked' => $checked,
                            'CreatedBy' => $row['createdBy'] ?? $row['CreatedBy'] ?? '',
                            'CreatedDate' => $row['createdDate'] ?? $row['CreatedDate'] ?? '',
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

                if ($action == 'Save') {
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
                        'TaxName' => [
                            'label' => 'Tax Name',
                            'rules' => 'required|max_length[100]',
                            'errors' => []
                        ]
                    ];

                    if (!$this->validate($validationRules)) {
                        return $this->response->setJSON([
                            'error' => [
                                'TaxId' => $validation->getError('TaxId'),
                                'TaxName' => $validation->getError('TaxName')
                            ]
                        ]);
                    }
                }

                $taxId = $this->request->getVar('TaxId');
                $taxName = $this->request->getVar('TaxName');
                $actTaxPSales = $this->request->getVar('ActTaxPSales');
                $actTaxPurch = $this->request->getVar('ActTaxPurch');
                $isactive = $this->request->getVar('Isactive');

                $isactiveBool = false;
                if ($isactive === '1' || $isactive === 1 || $isactive === 'true' || $isactive === true || $isactive === 'on') {
                    $isactiveBool = true;
                }

                switch ($action) {
                    case 'Save':
                        return $this->saveTaxClass($taxId, $taxName, $actTaxPSales, $actTaxPurch, $isactiveBool);
                    case 'Delete':
                        return $this->deleteTaxClass($taxId);
                    default:
                        return $this->response->setJSON([
                            'status' => 'error',
                            'message' => 'Action tidak dikenal'
                        ]);
                }
            }
        }

        exit('Maaf tidak dapat diproses!');
    }

    private function saveTaxClass($taxId, $taxName, $actTaxPSales, $actTaxPurch, $isactive)
    {
        helper(['restclient']);

        $existingData = $this->getTaxClassData($taxId);

        $createdDate = date('Y-m-d\TH:i:s.v\Z');
        $createdBy = session()->get('usr_id') ?? 'string';

        $body = [
            "taxID" => $taxId,
            "taxName" => $taxName,
            "actTaxPurch" => $actTaxPurch,
            "actTaxPSales" => $actTaxPSales,
            "isactive" => $isactive,
            "createdBy" => $createdBy,
            "createdDate" => $createdDate,
        ];

        if ($existingData) {
            $body["updatedBy"] = $createdBy;
            $body["updatedDate"] = $createdDate;
        }

        $url = "{$this->server3}/api/taxclass";
        $response = akses_restapikey('POST', $url, $body);

        $result = is_string($response) ? json_decode($response, true) : $response;

        if (isset($result['success']) && $result['success'] === true) {
            $message = $existingData ? 'Data Tax Class berhasil diupdate' : 'Data Tax Class berhasil ditambahkan';
            return $this->response->setJSON([
                'status' => 'success',
                'message' => $message
            ]);
        } else {
            $errorMsg = isset($result['message']) ? $result['message'] : 'Gagal menyimpan data';

            if (isset($result['errors']) && is_array($result['errors'])) {
                $errorDetails = [];
                foreach ($result['errors'] as $key => $value) {
                    if (is_array($value)) {
                        $errorDetails[] = implode(', ', $value);
                    } else {
                        $errorDetails[] = (string)$value;
                    }
                }
                if (!empty($errorDetails)) {
                    $errorMsg .= ' - ' . implode(' | ', $errorDetails);
                }
            }

            return $this->response->setJSON([
                'status' => 'error',
                'message' => $errorMsg
            ]);
        }
    }

    private function deleteTaxClass($taxId)
    {
        helper(['restclient']);

        $url = "{$this->server3}/api/taxclass";
        $query = ['TaxId' => $taxId];

        $response = akses_restapikey('DELETE', $url, [], $query);
        $result = is_string($response) ? json_decode($response, true) : $response;

        if (isset($result['success']) && $result['success'] === true) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data Tax Class berhasil dihapus'
            ]);
        } else {
            $errorMsg = isset($result['message']) ? $result['message'] : 'Gagal menghapus data';

            if (isset($result['errors']) && is_array($result['errors'])) {
                $errorDetails = [];
                foreach ($result['errors'] as $key => $value) {
                    if (is_array($value)) {
                        $errorDetails[] = implode(', ', $value);
                    } else {
                        $errorDetails[] = (string)$value;
                    }
                }
                if (!empty($errorDetails)) {
                    $errorMsg .= ' - ' . implode(' | ', $errorDetails);
                }
            }

            return $this->response->setJSON([
                'status' => 'error',
                'message' => $errorMsg
            ]);
        }
    }

    private function getTaxClassData($taxId)
    {
        helper(['restclient']);

        $url = "{$this->server3}/api/taxclass/getby/{$taxId}";
        $response = akses_restapikey('GET', $url, []);
        $data = json_decode($response, true);

        if (isset($data['success']) && $data['success'] === true && !empty($data['data'])) {
            return $data['data'];
        }

        return null;
    }
}
