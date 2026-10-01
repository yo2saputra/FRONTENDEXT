<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Tmstglallocationprocess extends BaseController
{
    protected $data;
    protected $server;
    protected $server3;

    public function __construct()
    {
        $this->session = session();
        $this->server = $_ENV['APP_API'];
        $this->server3 = $_ENV['APP_API3'];
    }

    public function index()
    {
        helper(['dropdown']);

        // Get current date for transaction date
        $this->data['transaction_date'] = date('Y-m-d');

        // Get current fiscal year
        $defaultFiscal = apiDropdownSetFscsyr('SetFscsyr');
        $this->data['default_fiscal_year'] = $defaultFiscal['data'][0]['value'] ?? date('Y');

        // Create dropdowns
        $this->data['cb_fiscal_calender_year'] = getDropdownFiscalCalenderYear('cb_fiscal_calender_year', 'cb_fiscal_calender_year');

        // Untuk allocation process, hanya perlu periode 1-12 (bukan 14,15)
        $this->data['cb_fiscal_period'] = getDropdownFiscalPeriodAllocationProcess('fiscal_period', 'cb_fiscal_period', ['14', '15']);

        return view('tmstglallocationprocess/index', $this->data);
    }

    public function startAllocation()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request'
            ]);
        }

        try {
            helper(['restclient']);

            // Get parameters from POST
            $fiscalYear = $this->request->getPost('fiscal_year');
            $fiscalPeriod = $this->request->getPost('fiscal_period');

            if (!$fiscalYear || !$fiscalPeriod) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Fiscal Year and Period are required'
                ]);
            }

            $payload = [
                'UserId' => session()->get('usr_id'),
                'FiscalYear' => $fiscalYear,
                'FiscalPeriod' => $fiscalPeriod
            ];

            $url = "{$this->server3}/api/tmstglallocationprocess";

            $response = akses_restapikey('POST', $url, $payload, [
                'Content-Type' => 'application/json'
            ]);

            $result = is_string($response) ? json_decode($response, true) : $response;

            return $this->response->setJSON($result);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Allocation process failed: ' . $e->getMessage(),
            ]);
        }
    }

    public function action()
    {
        return $this->startAllocation();
    }
}
