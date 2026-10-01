<?php

namespace App\Controllers;

use App\Controllers\BaseController;


class Tmstfiscalcalenderlock extends BaseController
{

    protected $data;
    protected $server;
    protected $server3;
    protected $client;

    public function __construct()
    {

        
        $this->server = $_ENV['APP_API'];
        $this->server3 = $_ENV['APP_API3'];

        //library CURLrequest
        $this->client = service('curlrequest');

        
    }

    public function index()
    {
        helper(['dropdown']);
        $defaultFiscal = apiDropdownSetFscsyr('SetFscsyr');

        $this->data['default_fiscal_year'] = $defaultFiscal['data'][0]['value'] ?? date('Y');

        return view('tmstfiscalcalenderlock/index', $this->data);
    }

    public function pivot()
    {
        helper(['restclient']);

        $rawBody = $this->request->getBody();
        $json = json_decode($rawBody, true);

        $page = $json['pageNumber'] ?? 1;
        $countOnly = $json['countOnly'] ?? false;

        $payload = [
            'draw' => $json['draw'] ?? 1,
            'pageNumber' => $page,
            'pageSize' => 1,
            'countOnly' => $countOnly,
            'search' => $json['search'] ?? ['value' => '']
        ];

        $url = "{$this->server3}/api/tmstfiscalcalenderlock/pivot";
        $response = akses_restapikey('POST', $url, $payload);

        $result = json_decode($response, true);

        return $this->response->setJSON($result);
    }


    public function datatables()
    {
        helper(['restclient']);
        $rawBody = $this->request->getBody();
        $json = json_decode($rawBody, true);

        $url = "{$this->server3}/api/tmstfiscalcalenderlock/datatables";
        $response = akses_restapikey('POST', $url, $json);

        $result = json_decode($response, true);

        foreach ($result['data'] as $i => &$row) {
            $fiscId = $row['fiscId'];
            $row['rownum'] = $i + ($json['start'] ?? 0) + 1;
            $row['aksi'] = '
        <div class="btn-group">

            <a class="btn btn-sm btn-info view ' . ($this->session->get("flag_view") === 1 ? "" : "d-none") . '" 
               data-fiscid="' . $fiscId . '">
               <i class="fas fa-eye"></i>
            </a>

            <a class="btn btn-sm btn-primary edit ' . ($this->session->get("flag_update") === 1 ? "" : "d-none") . '" 
               data-fiscid="' . $fiscId . '">
               <i class="fas fa-tags"></i>
            </a>
        </div>';
        }

        return $this->response->setJSON($result);
    }

    public function updateLock()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request'
            ]);
        }

        helper(['restclient']);

        $payload = [
            'fiscYear'   => $this->request->getVar('fiscYear'),
            'fiscPeriod' => $this->request->getVar('fiscPeriod'),
            'moduleName' => $this->request->getVar('moduleName'),
            'statusLock' => filter_var(
                $this->request->getVar('statusLock'),
                FILTER_VALIDATE_BOOLEAN
            )
        ];

        // basic validation
        if (
            empty($payload['fiscYear']) ||
            empty($payload['fiscPeriod']) ||
            empty($payload['moduleName'])
        ) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data tidak lengkap'
            ]);
        }

        $url = "{$this->server3}/api/tmstfiscalcalenderlock/update-lock";

        $response = akses_restapikey(
            'POST',
            $url,
            $payload
        );

        $result = is_string($response)
            ? json_decode($response, true)
            : $response;

        return $this->response->setJSON($result);
    }



    public function fetchSingleData()
    {
        if ($this->request->isAJAX()) {

            $fiscId   = $this->request->getVar('fiscId');

            if ($fiscId) {
                helper(['restclient']);

                $url = "{$this->server3}/api/tmstfiscalcalenderlock/getby/$fiscId";

                $response = akses_restapikey('GET', $url);
                $data = is_string($response) ? json_decode($response, true) : $response;

                if (isset($data['success']) && $data['success'] === true && !empty($data['data'])) {

                    return $this->response->setJSON([
                        'data' => $data['data']
                    ]);
                }

                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }

        exit('Maaf tidak dapat diproses!');
    }
}
