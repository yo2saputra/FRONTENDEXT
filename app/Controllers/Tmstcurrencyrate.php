<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Tmstcurrencyrate extends BaseController
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
        helper(['dropdown']);
        $this->data['cb_to_currency_code'] = getDropdownToCurrencyCode('ToCurrencyCode', 'cb_to_currency_code');
        $this->data['cb_from_currency_code'] = getDropdownFromCurrencyCode('FromCurrencyCode', 'cb_from_currency_code');
        $this->data['cb_rate_type'] = getDropdownToRateType('RateType', 'cb_rate_type');

        return view('tmstcurrencyrate/index', $this->data);
    }

    public function datatables()
    {
        if ($this->request->isAJAX()) {
            helper(['restclient']);

            $rawBody = $this->request->getBody();
            $json = json_decode($rawBody, true);

            $draw = $json['draw'] ?? 1;
            $start = $json['start'] ?? 0;
            $length = $json['length'] ?? 10;
            $search = $json['search']['value'] ?? '';
            $currencyId = $json['currencyId'] ?? $this->request->getPost('CurrencyId');

            if (empty($currencyId)) {
                return $this->response->setJSON([
                    'draw' => (int)$draw,
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0,
                    'data' => []
                ]);
            }

            $requestBody = [
                'draw' => (int)$draw,
                'start' => (int)$start,
                'length' => (int)$length,
                'search' => ['value' => $search, 'regex' => false],
                'currencyId' => $currencyId,
                'columns' => $json['columns'] ?? [],
                'order' => $json['order'] ?? [['column' => 0, 'dir' => 'asc']]
            ];

            $url = "{$this->server3}/api/currencyrate/datatables";
            $response = akses_restapikey('POST', $url, $requestBody);
            $result = json_decode($response, true);

            if (!$result || !isset($result['data'])) {
                return $this->response->setJSON([
                    'draw' => (int)$draw,
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0,
                    'data' => []
                ]);
            }

            if (isset($result['data']) && is_array($result['data'])) {
                foreach ($result['data'] as &$item) {
                    if (isset($item['rateDate'])) {
                        $item['rateDate'] = date('Y-m-d', strtotime($item['rateDate']));
                    }
                }
            }

            return $this->response->setJSON($result);
        }
    }

    public function getDetailsByToCurrency()
    {
        if ($this->request->isAJAX()) {
            helper(['restclient']);

            $toCurrency = $this->request->getPost('ToCurrencyCode');
            $rateType = $this->request->getPost('RateType');

            if (empty($toCurrency)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'To Currency tidak boleh kosong',
                    'details' => []
                ]);
            }

            $url = "{$this->server3}/api/currencyrate/getbytocurrency/{$toCurrency}";
            $result = akses_restapikey('GET', $url);
            $result = is_string($result) ? json_decode($result, true) : $result;

            $responseData = [
                'success' => true,
                'rateType' => '',
                'rateOperation' => 'Multiply',
                'details' => []
            ];

            if (isset($result['success']) && $result['success'] === true && !empty($result['data'])) {
                $data = $result['data'];

                if (!empty($data['rateType']) && empty($rateType)) {
                    $responseData['rateType'] = $data['rateType'];
                }

                if (!empty($data['rateOperation'])) {
                    $responseData['rateOperation'] = $data['rateOperation'];
                }

                $responseData['details'] = $data['details'] ?? [];
            }

            return $this->response->setJSON($responseData);
        }
    }

    public function getCurrencyId()
    {
        if ($this->request->isAJAX()) {
            $toCurrency = $this->request->getVar('ToCurrencyCode');
            helper(['restclient']);
            $url = "{$this->server3}/api/currencyrate/getcurrencyid/{$toCurrency}";
            $result = akses_restapikey('GET', $url);
            $data = json_decode($result, true);
            $currencyId = $data['currencyId'] ?? '';
            return $this->response->setJSON(['currencyId' => $currencyId]);
        }
    }

    public function getAllCurrencies()
    {
        if ($this->request->isAJAX()) {
            helper(['restclient']);
            $url = "{$this->server}/api/tmstcurrency";
            $result = akses_restapikey('GET', $url, [], ['action' => 'getall']);
            $result = is_string($result) ? json_decode($result, true) : $result;
            if (isset($result['success']) && $result['success'] === true) {
                return $this->response->setJSON([
                    'success' => true,
                    'data' => $result['data'] ?? []
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'data' => []
                ]);
            }
        }
    }

    public function getAllRateTypes()
    {
        if ($this->request->isAJAX()) {
            helper(['restclient']);
            $url = "{$this->server}/api/tmstratetype";
            $result = akses_restapikey('GET', $url, [], ['action' => 'getall']);
            $result = is_string($result) ? json_decode($result, true) : $result;
            if (isset($result['success']) && $result['success'] === true) {
                return $this->response->setJSON([
                    'success' => true,
                    'data' => $result['data'] ?? []
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'data' => []
                ]);
            }
        }
    }

    public function fetchSingleData()
    {
        if ($this->request->isAJAX()) {
            $toCurrency = $this->request->getVar('ToCurrencyCode');
            $fromCurrency = $this->request->getVar('FromCurrency');
            $rateDate = $this->request->getVar('RateDate');

            if (empty($toCurrency) || empty($fromCurrency) || empty($rateDate)) {
                return $this->response->setJSON(['data' => null]);
            }

            helper(['restclient']);

            try {
                $url = "{$this->server3}/api/currencyrate/getsingledetail?ToCurrency=" . urlencode($toCurrency) . "&FromCurrency=" . urlencode($fromCurrency) . "&RateDate=" . urlencode($rateDate);
                $response = akses_restapikey('GET', $url);
                $data = json_decode($response, true);

                if (isset($data['success']) && $data['success'] === true && !empty($data['data'])) {
                    $detail = $data['data'];
                    $result = [
                        'data' => [
                            'ToCurrencyCode' => $detail['toCurrency'],
                            'RateType' => $detail['rateType'],
                            'RateOperation' => $detail['rateOperation'],
                            'FromCurrency' => $detail['fromCurrency'],
                            'Rate' => $detail['rate'],
                            'RateDate' => $detail['rateDate']
                        ]
                    ];
                } else {
                    $result = ['data' => null];
                }

                return $this->response->setJSON($result);
            } catch (\Exception $e) {
                return $this->response->setJSON(['data' => null]);
            }
        }
    }

    public function action()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getVar('action')) {
                helper(['form', 'url']);

                $validation = \Config\Services::validation();
                $action = $this->request->getVar('action');

                $toCurrency = $this->request->getVar('ToCurrencyCode');
                $rateType = $this->request->getVar('RateType');
                $rateOperation = $this->request->getVar('RateOperation');
                $fromCurrency = $this->request->getVar('FromCurrency');
                $rate = $this->request->getVar('Rate');
                $rateDate = $this->request->getVar('RateDate');
                $oldFromCurrency = $this->request->getVar('OldFromCurrency');
                $oldRateDate = $this->request->getVar('OldRateDate');
                $editMode = $this->request->getVar('EditMode');

                $isHeaderOnly = $this->request->getVar('HeaderOnly') == 'true';

                $validationRules = [
                    'ToCurrencyCode' => ['label' => 'To Currency', 'rules' => 'required', 'errors' => ['required' => 'To Currency harus dipilih']],
                    'RateType' => ['label' => 'Rate Type', 'rules' => 'required', 'errors' => ['required' => 'Rate Type harus dipilih']],
                    'RateOperation' => ['label' => 'Rate Operation', 'rules' => 'required', 'errors' => ['required' => 'Rate Operation harus dipilih']]
                ];

                if (!$isHeaderOnly) {
                    $validationRules['FromCurrency'] = ['label' => 'From Currency', 'rules' => 'required', 'errors' => ['required' => 'From Currency harus dipilih']];
                    $validationRules['Rate'] = ['label' => 'Rate', 'rules' => 'required|numeric', 'errors' => ['required' => 'Rate harus diisi', 'numeric' => 'Rate harus berupa angka']];
                }

                if (!$this->validate($validationRules)) {
                    $errors = [];
                    if ($validation->getError('ToCurrencyCode')) $errors['ToCurrencyCode'] = $validation->getError('ToCurrencyCode');
                    if ($validation->getError('RateType')) $errors['RateType'] = $validation->getError('RateType');
                    if ($validation->getError('RateOperation')) $errors['RateOperation'] = $validation->getError('RateOperation');
                    if (!$isHeaderOnly) {
                        if ($validation->getError('FromCurrency')) $errors['FromCurrency'] = $validation->getError('FromCurrency');
                        if ($validation->getError('Rate')) $errors['Rate'] = $validation->getError('Rate');
                    }
                    return $this->response->setJSON(['error' => $errors]);
                }

                try {
                    $rateDateFormatted = !empty($rateDate) ? date('Y-m-d', strtotime($rateDate)) : date('Y-m-d');

                    if ($action == 'Save' || $action == 'Update') {
                        helper(['restclient']);

                        $checkUrl = "{$this->server3}/api/currencyrate/getbytocurrency/{$toCurrency}";
                        $checkResult = akses_restapikey('GET', $checkUrl);
                        $checkResult = is_string($checkResult) ? json_decode($checkResult, true) : $checkResult;
                        $headerExists = isset($checkResult['success']) && $checkResult['success'] === true && !empty($checkResult['data']);

                        if ($headerExists) {
                            $updateHeaderUrl = "{$this->server3}/api/currencyrate/{$toCurrency}";
                            $headerData = [
                                "RateType" => $rateType,
                                "RateOperation" => $rateOperation
                            ];

                            if (!$isHeaderOnly && !empty($fromCurrency) && !empty($rate)) {
                                $headerData["Details"] = [[
                                    "FromCurrency" => $fromCurrency,
                                    "Rate" => floatval($rate),
                                    "RateDate" => $rateDateFormatted
                                ]];
                            }

                            $result = akses_restapikey('PUT', $updateHeaderUrl, $headerData);
                        } else {
                            $details = [];
                            if (!$isHeaderOnly && !empty($fromCurrency) && !empty($rate)) {
                                $details[] = [
                                    "FromCurrency" => $fromCurrency,
                                    "Rate" => floatval($rate),
                                    "RateDate" => $rateDateFormatted
                                ];
                            }

                            $dataToSend = [
                                "ToCurrency" => $toCurrency,
                                "RateType" => $rateType,
                                "RateOperation" => $rateOperation,
                                "Details" => $details
                            ];
                            $url = "{$this->server3}/api/currencyrate";
                            $result = akses_restapikey('POST', $url, $dataToSend);
                        }

                        $result = is_string($result) ? json_decode($result, true) : $result;

                        if (isset($result['success']) && $result['success'] === true) {
                            $message = '';
                            if ($action == 'Update') {
                                if ($editMode == 'detail') {
                                    $message = 'Detail Currency Rate berhasil diupdate';
                                } else if ($isHeaderOnly) {
                                    $message = 'Header Currency Rate berhasil diupdate';
                                } else {
                                    $message = 'Data Currency Rate berhasil diupdate';
                                }
                            } else {
                                if ($isHeaderOnly) {
                                    $message = 'Header Currency Rate berhasil ditambahkan';
                                } else {
                                    $message = 'Data Currency Rate berhasil ditambahkan';
                                }
                            }
                            return $this->response->setJSON([
                                'status' => 'success',
                                'message' => $message
                            ]);
                        } else {
                            return $this->response->setJSON([
                                'status' => 'error',
                                'message' => $result['message'] ?? 'Gagal menyimpan data'
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
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $toCurrency = $this->request->getVar('ToCurrencyCode');
            $fromCurrency = $this->request->getVar('FromCurrency');
            $rateDate = $this->request->getVar('RateDate');

            if (empty($toCurrency) || empty($fromCurrency) || empty($rateDate)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Parameter tidak lengkap'
                ]);
            }

            helper(['restclient']);
            $url = "{$this->server3}/api/currencyrate/detail?ToCurrency=" . urlencode($toCurrency) . "&FromCurrency=" . urlencode($fromCurrency) . "&RateDate=" . urlencode($rateDate);
            $result = akses_restapikey('DELETE', $url);
            $result = is_string($result) ? json_decode($result, true) : $result;

            if (isset($result['success']) && $result['success'] === true) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Data Currency Rate berhasil dihapus'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $result['message'] ?? 'Gagal menghapus data'
                ]);
            }
        }
    }

    public function deleteDetail()
    {
        if ($this->request->isAJAX()) {
            $currencyId = $this->request->getVar('CurrencyId');
            $fromCurrency = $this->request->getVar('FromCurrency');
            $rateDate = $this->request->getVar('RateDate');

            if (empty($currencyId) || empty($fromCurrency) || empty($rateDate)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Parameter tidak lengkap'
                ]);
            }

            helper(['restclient']);
            $url = "{$this->server3}/api/currencyrate/deletedetailbyid?CurrencyId=" . urlencode($currencyId) . "&FromCurrency=" . urlencode($fromCurrency) . "&RateDate=" . urlencode($rateDate);
            $result = akses_restapikey('DELETE', $url);
            $result = is_string($result) ? json_decode($result, true) : $result;

            if (isset($result['success']) && $result['success'] === true) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Detail berhasil dihapus'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $result['message'] ?? 'Gagal menghapus detail'
                ]);
            }
        }
    }

    public function checkDuplicate()
    {
        if ($this->request->isAJAX()) {
            $toCurrency = $this->request->getVar('ToCurrencyCode');
            $excludeToCurrency = $this->request->getVar('ExcludeToCurrency');
            helper(['restclient']);
            $url = "{$this->server3}/api/currencyrate/checkduplicate";
            $body = [
                'ToCurrency' => $toCurrency,
                'ExcludeToCurrency' => $excludeToCurrency
            ];
            $response = akses_restapikey('POST', $url, $body);
            $result = is_string($response) ? json_decode($response, true) : $response;
            return $this->response->setJSON($result);
        }
    }
}
