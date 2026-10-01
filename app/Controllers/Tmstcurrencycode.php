<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Tmstcurrencycode extends BaseController
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
        return view('tmstcurrencycode/index', $this->data);
    }

    public function datatables()
    {
        helper(['restclient']);
        $rawBody = $this->request->getBody();
        $json = json_decode($rawBody, true);

        $url = "{$this->server3}/api/currency/datatables";
        $response = akses_restapikey('POST', $url, $json);
        $result = json_decode($response, true);

        if (isset($result['data']) && is_array($result['data'])) {
            foreach ($result['data'] as $i => &$row) {
                $currencyCode = $row['currencyCode'] ?? $row['CurrencyCode'] ?? '';
                $currencyName = $row['currencyName'] ?? $row['CurrencyName'] ?? '';
                $symbol = $row['symbol'] ?? $row['Symbol'] ?? '';

                $currencyData = [
                    'currencyCode' => $currencyCode,
                    'currencyName' => $currencyName,
                    'symbol' => $symbol
                ];

                $encodedData = base64_encode(json_encode($currencyData));

                $row['rownum'] = $i + ($json['start'] ?? 0) + 1;
                $row['currencyCode'] = $currencyCode;
                $row['currencyName'] = $currencyName;
                $row['symbol'] = $symbol;
                $row['encoded_data'] = $encodedData;
            }
        }

        return $this->response->setJSON($result);
    }

    public function fetchSingleData()
    {
        if ($this->request->isAJAX()) {
            $currencyCode = $this->request->getVar('CurrencyCode');

            if ($currencyCode) {
                helper(['restclient']);

                $url = "{$this->server3}/api/currency/getby/{$currencyCode}";
                $response = akses_restapikey('GET', $url, []);
                $data = json_decode($response, true);

                if (isset($data['success']) && $data['success'] === true && !empty($data['data'])) {
                    $row = $data['data'];

                    $msg = [
                        'data' => [
                            'CurrencyCode'       => $row['currencyCode'] ?? $row['CurrencyCode'] ?? '',
                            'CurrencyName'       => $row['currencyName'] ?? $row['CurrencyName'] ?? '',
                            'Symbol'             => $row['symbol'] ?? $row['Symbol'] ?? '',
                            'CreatedBy'          => $row['createdBy'] ?? $row['CreatedBy'] ?? '',
                            'CreatedDate'        => $row['createdDate'] ?? $row['CreatedDate'] ?? '',
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
                        'CurrencyCode' => [
                            'label' => 'Currency Code',
                            'rules' => 'required|max_length[10]',
                            'errors' => []
                        ],
                        'CurrencyName' => [
                            'label' => 'Currency Name',
                            'rules' => 'required|max_length[50]',
                            'errors' => []
                        ],
                        'Symbol' => [
                            'label' => 'Symbol',
                            'rules' => 'permit_empty|max_length[5]',
                            'errors' => []
                        ]
                    ];

                    if (!$this->validate($validationRules)) {
                        return $this->response->setJSON([
                            'error' => [
                                'CurrencyCode'    => $validation->getError('CurrencyCode'),
                                'CurrencyName'    => $validation->getError('CurrencyName'),
                                'Symbol'          => $validation->getError('Symbol'),
                            ]
                        ]);
                    }
                }

                $currencyCode = $this->request->getVar('CurrencyCode');
                $currencyName = $this->request->getVar('CurrencyName');
                $symbol = $this->request->getVar('Symbol');

                switch ($action) {
                    case 'Save':
                        return $this->saveCurrency($currencyCode, $currencyName, $symbol);
                    case 'Delete':
                        return $this->deleteCurrency($currencyCode);
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

    private function saveCurrency($currencyCode, $currencyName, $symbol)
    {
        helper(['restclient']);

        $existingData = $this->getCurrencyData($currencyCode);
        $createdDate = date('Y-m-d\TH:i:s');
        $createdBy = session()->get('usr_id');

        $body = [
            "currencyCode" => $currencyCode,
            "currencyName" => $currencyName,
            "symbol" => $symbol,
            "createdBy" => $createdBy,
            "createdDate" => $createdDate,
        ];

        $url = "{$this->server3}/api/currency";
        $response = akses_restapikey('POST', $url, $body);
        $result = is_string($response) ? json_decode($response, true) : $response;

        if (isset($result['success']) && $result['success'] === true) {
            $message = $existingData ? 'Data Currency berhasil diupdate' : 'Data Currency berhasil ditambahkan';
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

    private function deleteCurrency($currencyCode)
    {
        helper(['restclient']);

        $url = "{$this->server3}/api/currency";
        $query = ['CurrencyCode' => $currencyCode];

        $response = akses_restapikey('DELETE', $url, [], $query);
        $result = is_string($response) ? json_decode($response, true) : $response;

        if (isset($result['success']) && $result['success'] === true) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data Currency berhasil dihapus'
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

    private function getCurrencyData($currencyCode)
    {
        helper(['restclient']);

        $url = "{$this->server3}/api/currency/getby/{$currencyCode}";
        $response = akses_restapikey('GET', $url, []);
        $data = json_decode($response, true);

        if (isset($data['success']) && $data['success'] === true && !empty($data['data'])) {
            return $data['data'];
        }

        return null;
    }

    private function checkDuplicate($currencyCode, $excludeCode = null)
    {
        helper(['restclient']);

        $url = "{$this->server3}/api/currency/checkduplicate";

        $body = [
            'currencyCode' => $currencyCode
        ];

        if ($excludeCode) {
            $body['excludeCurrencyCode'] = $excludeCode;
        }

        $response = akses_restapikey('POST', $url, $body);
        $result = json_decode($response, true);

        return isset($result['isDuplicate']) ? $result['isDuplicate'] : false;
    }
}
