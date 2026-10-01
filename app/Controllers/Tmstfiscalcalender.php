<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Tmstfiscalcalender extends BaseController
{
    protected $data;
    protected $server;
    protected $server3;
    protected $client;

    public function __construct()
    {
        $this->server = $_ENV['APP_API'];
        $this->server3 = $_ENV['APP_API3'];

        $this->client = service('curlrequest');

        
    }

    public function index()
    {
        helper(['dropdown']);
        $defaultFiscal = apiDropdownSetFscsyr('SetFscsyr');

        $this->data['default_fiscal_year'] = $defaultFiscal['data'][0]['value'] ?? date('Y');

        return view('tmstfiscalcalender/index', $this->data);
    }

    public function datatables()
    {
        helper(['restclient']);

        $rawBody = $this->request->getBody();
        $json = json_decode($rawBody, true);

        $json['draw']   = $json['draw']   ?? 1;
        $json['start']  = 0;
        $json['length'] = 1000;

        if (!isset($json['search'])) {
            $json['search'] = [
                'value' => '',
                'regex' => false
            ];
        }

        if (!isset($json['order'])) {
            $json['order'] = [
                [
                    'column' => 0,
                    'dir' => 'asc'
                ]
            ];
        }

        if (!isset($json['columns'])) {
            $json['columns'] = [
                ['data' => 'FiscYear'],
                ['data' => 'FiscPeriod'],
                ['data' => 'StartDate'],
                ['data' => 'EndDate'],
                ['data' => 'CreatedDate'],
                ['data' => 'CreatedBy']
            ];
        }

        $url = "{$this->server3}/api/tmstfiscalcalender/datatables";
        $response = akses_restapikey('POST', $url, $json);

        $result = json_decode($response, true);

        if (!isset($result['data']) || !is_array($result['data'])) {
            return $this->response->setJSON([
                'draw' => $json['draw'],
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => []
            ]);
        }

        return $this->response->setJSON($result);
    }

    public function action()
    {
        if (!$this->request->isAJAX()) {
            exit('Maaf tidak dapat diproses!');
        }

        $action = $this->request->getVar('action');
        $year = $this->request->getVar('year');

        if (!$action) {
            return $this->response->setJSON(['error' => 'Action tidak valid']);
        }

        helper(['restclient', 'form', 'url', 'dropdown']);

        if ($action === 'Generate') {
            if (empty($year)) {
                $defaultFiscal = apiDropdownSetFscsyr('SetFscsyr');
                $year = $defaultFiscal['data'][0]['value'] ?? date('Y');
            }

            // Validasi input
            if (empty($year)) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Tidak dapat menentukan tahun fiskal'
                ]);
            }

            $periods = apiDropdown('fiscal_period');

            if (!$periods || !isset($periods['data'])) {
                $defaultPeriods = [
                    ['fld_valu' => '01', 'orderby' => 1],
                    ['fld_valu' => '02', 'orderby' => 2],
                    ['fld_valu' => '03', 'orderby' => 3],
                    ['fld_valu' => '04', 'orderby' => 4],
                    ['fld_valu' => '05', 'orderby' => 5],
                    ['fld_valu' => '06', 'orderby' => 6],
                    ['fld_valu' => '07', 'orderby' => 7],
                    ['fld_valu' => '08', 'orderby' => 8],
                    ['fld_valu' => '09', 'orderby' => 9],
                    ['fld_valu' => '10', 'orderby' => 10],
                    ['fld_valu' => '11', 'orderby' => 11],
                    ['fld_valu' => '12', 'orderby' => 12],
                    ['fld_valu' => '14', 'orderby' => 14],
                    ['fld_valu' => '15', 'orderby' => 15]
                ];
                $periods = $defaultPeriods;
            } else {
                $periods = $periods['data'];
            }

            $dateNow = date('Y-m-d');
            $user = session()->get('usr_id');

            $successCount = 0;
            $errorCount = 0;

            usort($periods, function ($a, $b) {
                return ($a['orderby'] ?? 0) <=> ($b['orderby'] ?? 0);
            });

            foreach ($periods as $periodData) {
                $period = $periodData['fld_valu'];

                if (isset($periodData['hiddenfield']) && $periodData['hiddenfield'] == 1) {
                    continue;
                }
                if (isset($periodData['deleted']) && $periodData['deleted'] == 1) {
                    continue;
                }

                if ($period == '14' || $period == '15') {
                    $startDate = date('Y-m-d', strtotime("$year-12-01"));
                    $endDate = date('Y-m-t', strtotime("$year-12-01"));
                } else {
                    $month = (int)$period;
                    $startDate = date('Y-m-d', strtotime("$year-$month-01"));
                    $endDate = date('Y-m-t', strtotime($startDate));
                }

                $body = [
                    "FiscYear"          => $year,
                    "FiscPeriod"        => $period,
                    "StartDate"         => $startDate,
                    "EndDate"           => $endDate,
                    "CreatedBy"         => $user,
                    "CreatedDate"       => $dateNow
                ];

                $url = "{$this->server3}/api/tmstfiscalcalender";
                $result = akses_restapikey('POST', $url, $body, []);
                $result = is_string($result) ? json_decode($result, true) : $result;

                if (isset($result['success']) && $result['success'] === true) {
                    $successCount++;
                } else {
                    $errorCount++;
                }
            }

            return $this->response->setJSON([
                'status'        => $successCount > 0 ? 'success' : 'error',
                'fiscal_year'   => $year,
                'total_success' => $successCount,
                'total_error'   => $errorCount,
                'total_periods' => count($periods),
                'message'       => "Generate tahun fiskal $year selesai"
            ]);
        }

        return $this->response->setJSON(['error' => 'Action tidak dikenali']);
    }

    public function fetchSingleData()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Request tidak valid'
            ]);
        }

        $fiscYear   = $this->request->getVar('fiscyear');
        $fiscPeriod = $this->request->getVar('fiscperiod');

        helper(['restclient']);

        $url = "{$this->server3}/api/tmstfiscalcalender/getby/{$fiscYear}/{$fiscPeriod}";
        $response = akses_restapikey('GET', $url);
        $data = is_string($response) ? json_decode($response, true) : $response;

        if (!empty($data) && isset($data['success']) && $data['success'] === true && !empty($data['data'])) {
            return $this->response->setJSON([
                'status' => 'success',
                'data'   => $data['data']
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Data tidak ditemukan'
        ]);
    }
}
