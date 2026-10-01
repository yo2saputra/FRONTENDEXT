<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Tmsttaxgroup extends BaseController
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

        $this->data['cb_tax_type'] = getDropdownTaxType('tax_type', 'cb_tax_type');
        $this->data['cb_tax_id'] = getDropdownTaxId('tax_id', 'cb_tax_id');
        $this->data['cb_tax_group_line_no'] = getDropdownTaxGroupLineNo('tax_group_line_no', 'cb_tax_group_line_no');
        $this->data['cb_tax_group_rate_type'] = getDropdownTaxGroupRateType('tax_group_rate_type', 'cb_tax_group_rate_type');

        return view('tmsttaxgroup/index', $this->data);
    }

    public function getLineNoDropdown()
    {
        if ($this->request->isAJAX()) {
            $taxId = $this->request->getVar('TaxId');
            helper(['restclient']);

            $url = "{$this->server3}/api/ftadropdown/taxgroup/line_no";
            $query = ['action' => 'tax_group_line_no'];

            if (!empty($taxId)) {
                $query['TaxId'] = $taxId;
            }

            $response = akses_restapikey('GET', $url, [], $query);
            return $this->response->setJSON(json_decode($response, true));
        }
    }

    public function getRateTypeDropdown()
    {
        if ($this->request->isAJAX()) {
            $taxId = $this->request->getVar('TaxId');
            $lineNo = $this->request->getVar('Line_No');
            helper(['restclient']);

            $url = "{$this->server3}/api/ftadropdown/taxgroup/rate_type";
            $query = ['action' => 'tax_group_rate_type'];

            if (!empty($taxId)) {
                $query['TaxId'] = $taxId;
            }

            if (!empty($lineNo)) {
                $query['Line_No'] = $lineNo;
            }

            $response = akses_restapikey('GET', $url, [], $query);
            return $this->response->setJSON(json_decode($response, true));
        }
    }

    public function fetchSingleData()
    {
        if ($this->request->isAJAX()) {
            $taxGroup = $this->request->getVar('TaxGroup');

            if ($taxGroup) {
                helper(['restclient']);

                $url = "{$this->server3}/api/taxgroup/getby/{$taxGroup}";
                $response = akses_restapikey('GET', $url, []);
                $data = json_decode($response, true);

                if (isset($data['success']) && $data['success'] === true && !empty($data['data'])) {
                    $row = $data['data'];

                    return $this->response->setJSON([
                        'data' => [
                            'TaxGroup' => $row['taxGroup'] ?? $row['TaxGroup'] ?? '',
                            'TaxGroupName' => $row['taxGroupName'] ?? $row['TaxGroupName'] ?? '',
                            'TaxType' => $row['taxType'] ?? $row['TaxType'] ?? '',
                            'IsActive' => $row['isActive'] ?? $row['IsActive'] ?? false,
                            'CreatedBy' => $row['createdBy'] ?? $row['CreatedBy'] ?? '',
                            'CreatedDate' => $row['createdDate'] ?? $row['CreatedDate'] ?? '',
                            'UpdatedBy' => $row['updatedBy'] ?? $row['UpdatedBy'] ?? '',
                            'UpdatedDate' => $row['updatedDate'] ?? $row['UpdatedDate'] ?? '',
                            'details' => $row['details'] ?? $row['Details'] ?? []
                        ]
                    ]);
                }

                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
    }

    public function datatables()
    {
        helper(['restclient']);
        $rawBody = $this->request->getBody();
        $json = json_decode($rawBody, true);

        $url = "{$this->server3}/api/taxgroup/datatables";
        $response = akses_restapikey('POST', $url, $json);
        $result = json_decode($response, true);

        if (isset($result['data']) && is_array($result['data'])) {
            foreach ($result['data'] as $i => &$row) {
                $taxGroup = $row['TaxGroup'] ?? '';
                $taxGroupName = $row['TaxGroupName'] ?? '';
                $taxType = $row['TaxType'] ?? '';
                $isActive = $row['IsActive'] ?? false;
                $status = $isActive ? 'Active' : 'Inactive';

                $taxData = [
                    'taxGroup' => $taxGroup,
                    'taxGroupName' => $taxGroupName,
                    'taxType' => $taxType,
                    'isactive' => $isActive,
                    'status' => $status
                ];

                $encodedData = base64_encode(json_encode($taxData));

                $row['rownum'] = ($json['start'] ?? 0) + $i + 1;
                $row['taxGroup'] = $taxGroup;
                $row['taxGroupName'] = $taxGroupName;
                $row['taxType'] = $taxType;
                $row['status'] = $status;
                $row['encoded_data'] = $encodedData;
            }
        }

        $responseData = [
            'draw' => isset($json['draw']) ? (int)$json['draw'] : 1,
            'recordsTotal' => isset($result['recordsTotal']) ? (int)$result['recordsTotal'] : 0,
            'recordsFiltered' => isset($result['recordsFiltered']) ? (int)$result['recordsFiltered'] : 0,
            'data' => isset($result['data']) ? $result['data'] : []
        ];

        return $this->response->setJSON($responseData);
    }

    public function datatablesgroupheader()
    {
        helper(['restclient']);
        $rawBody = $this->request->getBody();
        $json = json_decode($rawBody, true);

        $url = "{$this->server3}/api/taxgroup/datatables";
        $response = akses_restapikey('POST', $url, $json);
        $result = json_decode($response, true);

        if (isset($result['data']) && is_array($result['data'])) {
            foreach ($result['data'] as $i => &$row) {
                $taxGroup = $row['taxGroup'] ?? $row['TaxGroup'] ?? '';
                $taxGroupName = $row['taxGroupName'] ?? $row['TaxGroupName'] ?? '';
                $taxType = $row['taxType'] ?? $row['TaxType'] ?? '';
                $isActive = $row['isActive'] ?? $row['IsActive'] ?? false;
                $status = $isActive ? 'Active' : 'Inactive';

                $taxData = [
                    'taxGroup' => $taxGroup,
                    'taxGroupName' => $taxGroupName,
                    'taxType' => $taxType,
                    'isactive' => $isActive,
                    'status' => $status
                ];

                $encodedData = base64_encode(json_encode($taxData));

                $row['rownum'] = ($json['start'] ?? 0) + $i + 1;
                $row['taxGroup'] = $taxGroup;
                $row['taxGroupName'] = $taxGroupName;
                $row['taxType'] = $taxType;
                $row['status'] = $status;
                $row['encoded_data'] = $encodedData;
            }
        }

        $responseData = [
            'draw' => isset($json['draw']) ? (int)$json['draw'] : 1,
            'recordsTotal' => isset($result['recordsTotal']) ? (int)$result['recordsTotal'] : 0,
            'recordsFiltered' => isset($result['recordsFiltered']) ? (int)$result['recordsFiltered'] : 0,
            'data' => isset($result['data']) ? $result['data'] : []
        ];

        return $this->response->setJSON($responseData);
    }

    public function action()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getVar('action')) {
                helper(['form', 'url']);

                $validation = \Config\Services::validation();
                $action = $this->request->getVar('action');

                if ($action == 'Save' || $action == 'Update') {
                    $validationRules = [
                        'TaxGroup' => [
                            'label' => 'Tax Group',
                            'rules' => 'required|max_length[100]|regex_match[/^[^\s]+$/]',
                            'errors' => [
                                'required' => 'Tax Group harus diisi',
                                'max_length' => 'Tax Group maksimal 100 karakter',
                                'regex_match' => 'Tax Group tidak boleh mengandung spasi'
                            ]
                        ],
                        'TaxGroupName' => [
                            'label' => 'Tax Group Name',
                            'rules' => 'required|max_length[100]',
                            'errors' => []
                        ],
                        'TaxType' => [
                            'label' => 'Tax Type',
                            'rules' => 'required|max_length[100]',
                            'errors' => []
                        ]
                    ];

                    if (!$this->validate($validationRules)) {
                        return $this->response->setJSON([
                            'error' => [
                                'TaxGroup' => $validation->getError('TaxGroup'),
                                'TaxGroupName' => $validation->getError('TaxGroupName'),
                                'TaxType' => $validation->getError('TaxType'),
                            ]
                        ]);
                    }
                }

                $taxGroup = $this->request->getVar('TaxGroup');

                if ($action == 'Save') {
                    return $this->saveTaxGroup($taxGroup);
                } elseif ($action == 'Delete') {
                    return $this->deleteTaxGroup($taxGroup);
                }
            }
        }
    }

    private function saveTaxGroup($taxGroup)
    {
        helper(['restclient']);

        $taxGroupName = $this->request->getVar('TaxGroupName');
        $taxType = $this->request->getVar('TaxType');
        $isActive = $this->request->getVar('Isactive') == 'true' || $this->request->getVar('Isactive') === true;
        $details = $this->request->getVar('Details');

        $detailsArray = [];
        if (!empty($details)) {
            $detailsArray = json_decode($details, true);
            if (!is_array($detailsArray)) {
                $detailsArray = [];
            }
        }

        $createdDate = date('Y-m-d\TH:i:s');
        $updatedDate = date('Y-m-d\TH:i:s');
        $userId = session()->get('usr_id');

        $formattedDetails = [];
        foreach ($detailsArray as $item) {
            $formattedDetails[] = [
                'taxId' => $item['taxId'] ?? $item['TaxId'] ?? '',
                'taxLine' => $item['taxLine'] ?? $item['TaxLine'] ?? '',
                'taxRate' => (float)($item['taxRate'] ?? $item['TaxRate'] ?? 0)
            ];
        }

        $body = [
            "taxGroup" => $taxGroup,
            "taxGroupName" => $taxGroupName,
            "taxType" => $taxType,
            "isActive" => $isActive,
            "createdBy" => $userId,
            "createdDate" => $createdDate,
            "updatedBy" => $userId,
            "updatedDate" => $updatedDate,
            "details" => $formattedDetails
        ];

        $url = "{$this->server3}/api/taxgroup";
        $response = akses_restapikey('POST', $url, $body);
        $result = is_string($response) ? json_decode($response, true) : $response;

        if (isset($result['success']) && $result['success'] === true) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => $result['message'] ?? 'Data Tax Group berhasil disimpan'
            ]);
        } else {
            $errorMsg = isset($result['message']) ? $result['message'] : 'Gagal menyimpan data';
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $errorMsg
            ]);
        }
    }

    private function deleteTaxGroup($taxGroup)
    {
        helper(['restclient']);

        $url = "{$this->server3}/api/taxgroup";
        $query = ['TaxGroup' => $taxGroup];

        $response = akses_restapikey('DELETE', $url, [], $query);
        $result = is_string($response) ? json_decode($response, true) : $response;

        if (isset($result['success']) && $result['success'] === true) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data Tax Group berhasil dihapus'
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
