<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as excel;

class Tmstgloption extends BaseController
{

    protected $data;
    protected $server;
    protected $server3;
    protected $client;

    public function __construct()
    {


        $this->server = $_ENV['APP_API'];
        $this->server3 = $_ENV['APP_API3'];
    }

    public function index()
    {
        // helper dropdown
        helper(['dropdown']);

        // GL Option Posting
        $this->data['cb_srceledger'] = getDropdownSrceLedgerGlOptionPosting('SrceLedger', 'cb_srceledger');
        $this->data['cb_srcetype'] = getDropdownSrceTypeGlOptionPosting('SrceType', 'cb_srcetype');
        $this->data['cb_functionalcurrency'] = getDropdownFunctionalCurrency('FunctionalCurrency', 'cb_functionalcurrency');
        $this->data['cb_defaultclosingaccount'] = getDropdownDefaultClosingAccount('DefaultClosingAccount', 'cb_defaultclosingaccount');

        // GL Option Email
        $this->data['cb_segmentaccount'] = getDropdownAccountSegmentGlOptionSegment('AccountSegment', 'cb_segmentaccount');
        $this->data['cb_segmentdelimiter'] = getDropdownSegmentDelimiterGlOptionSegment('SegmentDelimiter', 'cb_segmentdelimiter');
        $this->data['cb_structurecode'] = getDropdownDefaultStructureCodeGlOptionSegment('SegmentCode', 'cb_structurecode');

        $this->data['cb_emailservice'] = getDropdownGlOptionEmailService('gl_option_email_service', 'EmailService');

        $this->data['cb_country'] = getDropdownCountryFilterIn('country', 'Country', ['IDN']);

        return view('tmstgloption/index', $this->data);
    }

    public function datatables()
    {
        helper(['restclient']);
        $rawBody = $this->request->getBody();
        $json = json_decode($rawBody, true);

        $url = "{$this->server3}/api/tmstgloption/datatables";
        $response = akses_restapikey('POST', $url, $json);

        $result = json_decode($response, true);

        // Tambahkan kolom aksi ke setiap data
        foreach ($result['data'] as $i => &$row) {
            $cd = $row['batchId'];
            $row['rownum'] = $i + ($json['start'] ?? 0) + 1;
            $row['aksi'] = '
            <div class="btn-group">
                <a class="btn btn-sm btn-info view ' . ($this->session->get("flag_view") === 1 ? "" : "d-none") . '" data-batchid="' . $cd . '"><i class="fas fa-eye"></i></a>
                <a class="btn btn-sm btn-primary edit ' . (
                $this->session->get("flag_update") === 1 && $row['batchStat'] !== '4' ? "" : "d-none"
            ) . '" data-batchid="' . $cd . '" title="Edit">
                    <i class="fas fa-tags"></i>
                </a>
                <a href="' . base_url("tmstgljournalentry?batchId={$cd}") . '" class="btn btn-sm btn-success ' . ($this->session->get("flag_view") === 1 ? "" : "d-none") . '" title="Journal Entry">
                    <i class="fas fa-arrow-right"></i>
                </a>                
            </div>';
        }

        return $this->response->setJSON($result);
    }


    function action()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getVar('action')) {
                helper(['form', 'url']);

                $validation = \Config\Services::validation();
                $valid = $this->validate([
                    // 'SrceLedger' => [
                    //     'label' => 'Soure Ledger',
                    //     'rules' => 'required',
                    //     'errors' => []
                    // ],
                    // 'SrceType' => [
                    //     'label' => 'Source Type',
                    //     'rules' => 'required',
                    //     'errors' => []
                    // ],
                    // 'SrceDesc' => [
                    //     'label' => 'Source Description',
                    //     'rules' => 'required',
                    //     'errors' => []
                    // ]
                ]);
                // if (!$valid) {
                //     return $this->response->setJSON([
                //         'error' => [
                //             'SrceLedger'    => $validation->getError('SrceLedger'),
                //             'SrceType'      => $validation->getError('SrceType'),
                //             'SrceDesc'      => $validation->getError('SrceDesc'),
                //         ]
                //     ]);
                // } else {

                if ($this->request->getVar('action') == 'Add') {

                    // helper curl request
                    helper(['restclient']);

                    // endpoint
                    $url = "{$this->server3}/api/tmstgloption";

                    $date = date('Y-m-d');
                    $time = date('H:i:s');
                    $user = session()->get('usr_id');

                    $body = [
                        "BatchId"     => $this->request->getVar('BatchId'),
                        "BatchDesc"   => $this->request->getVar('BatchDesc'),
                        "SrceLedgr"   => $this->request->getVar('cb_sourceledger'),
                        "BatchType"   => $this->request->getVar('cb_batchtype'),
                        "BatchStat"   => $this->request->getVar('cb_batchstatusins'),
                        "DateCreat"   => $date,
                        "AudtUser"    => $user,
                        "AudtTime"    => $time,
                        "AudtDate"    => $date,
                        "DateEdit"    => $date,
                        "SwPrinted"   => 0,
                    ];
                    $result = akses_restapikey('POST', $url, $body, $query = []);

                    $result = is_string($result) ? json_decode($result, true) : $result;

                    if (isset($result['success']) && $result['success'] === true) {
                        return $this->response->setJSON([
                            'status' => 'success',
                            'message' => 'Data Batch Number berhasil ditambahkan',
                            'data' => $result,
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

                    // helper curl request
                    helper(['restclient']);

                    // endpoint
                    $url = "{$this->server3}/api/tmstgloption";

                    // Parameter yang ingin dikirim
                    $query = ['batchId' => str_replace(" ", "_", trim($this->request->getVar('BatchId')))];

                    $audtDate  = date('Y-m-d');
                    $audtTime  = date('H:i:s');
                    $audtUser  = session()->get('usr_id');

                    $body = [
                        "batchId"     => $this->request->getVar('BatchId'),
                        "batchDesc"   => $this->request->getVar('BatchDesc'),
                        "batchStat"   => $this->request->getVar('cb_batchstatus'),
                        "audtUser"    => $audtUser,
                        "audtTime"    => $audtTime,
                        "audtDate"    => $audtDate,
                        "dateEdit"    => $audtDate,
                    ];


                    // client request
                    $result = akses_restapikey('PUT', $url, $body, $query);

                    // pastikan hasilnya berupa array
                    $result = is_string($result) ? json_decode($result, true) : $result;

                    // Tampilkan hasil (bisa diganti dengan redirect atau view)
                    if (isset($result['success']) && $result['success'] === true) {
                        return $this->response->setJSON([
                            'status' => 'success',
                            'message' => 'Data Batch Number diubah',
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
        }
        // } else {
        //     exit('Maaf tidak dapat diproses!');
        // }
    }

    // Start Method GL Option Address
    public function fetchGlOptionAddress()
    {
        if ($this->request->isAJAX()) {
            helper(['restclient']);

            $url = "{$this->server3}/api/tmstgloption/address";
            $query = [
                'action' => 'get'
            ];

            $response = akses_restapikey('GET', $url, $body = [], $query);
            $data = json_decode($response, true);

            if (isset($data['success']) && $data['success'] === true && !empty($data['data'])) {
                $row = $data['data'][0];

                return $this->response->setJSON([
                    'status' => 'success',
                    'data' => [
                        'SystemID' => $row['systemID'],
                        'CompanyId' => $row['companyId'],
                        'LegalName' => $row['legalName'],
                        'TaxNumber' => $row['taxNumber'],
                        'BusinessRegistration' => $row['businessRegistration'],
                        'ContactName' => $row['contactName'],
                        'Phone' => $row['phone'],
                        'Fax' => $row['fax'],
                        'AddressLine1' => $row['addressLine1'],
                        'AddressLine2' => $row['addressLine2'],
                        'AddressLine3' => $row['addressLine3'],
                        'AddressLine4' => $row['addressLine4'],
                        'City' => $row['city'],
                        'State' => $row['stateProvince'],
                        'Country' => $row['country'],
                        'PostalCode' => $row['postalCode']
                    ]
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
    }

    public function saveGlOptionAddress()
    {
        if ($this->request->isAJAX()) {

            helper(['form', 'url', 'restclient']);

            $validation = \Config\Services::validation();

            $rules = [
                'CompanyId' => [
                    'label' => 'Company ID',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Company ID is required'
                    ]
                ],
                'LegalName' => [
                    'label' => 'Legal Name',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Legal Name is required'
                    ]
                ]
            ];

            if (!$this->validate($rules)) {
                return $this->response->setJSON([
                    'error' => $validation->getErrors()
                ]);
            }

            $systemID = 'Medicelle';

            $url = "{$this->server3}/api/tmstgloption/address/update";

            $body = [
                "SystemID"             => $systemID,
                "CompanyId"            => $this->request->getVar('CompanyId'),
                "LegalName"            => $this->request->getVar('LegalName'),
                "TaxNumber"            => $this->request->getVar('TaxNumber'),
                "BusinessRegistration" => $this->request->getVar('BusinessRegistration'),
                "ContactName"          => $this->request->getVar('ContactName'),
                "Phone"                => $this->request->getVar('Phone'),
                "Fax"                  => $this->request->getVar('Fax'),
                "AddressLine1"         => $this->request->getVar('AddressLine1'),
                "AddressLine2"         => $this->request->getVar('AddressLine2'),
                "AddressLine3"         => $this->request->getVar('AddressLine3'),
                "AddressLine4"         => $this->request->getVar('AddressLine4'),
                "City"                 => $this->request->getVar('City'),
                "StateProvince"        => $this->request->getVar('State'),
                "Country"              => $this->request->getVar('Country'),
                "PostalCode"           => $this->request->getVar('PostalCode')
            ];

            $result = akses_restapikey('PUT', $url, $body, []);

            $result = is_string($result) ? json_decode($result, true) : $result;

            if (isset($result['success']) && $result['success'] === true) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Save data successfully',
                    'data' => $result,
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $result['message'] ?? 'Failed to update address',
                    'errors' => $result['errors'] ?? null
                ]);
            }
        }
    }
    // End Method GL Option Address

    // Start Method GL Option Posting
    public function fetchGlOptionPosting()
    {
        if ($this->request->isAJAX()) {
            helper(['restclient']);

            $url = "{$this->server3}/api/tmstgloption/posting";
            $query = ['action' => 'get'];

            $response = akses_restapikey('GET', $url, [], $query);
            $data = is_string($response) ? json_decode($response, true) : $response;

            if (isset($data['success']) && $data['success'] === true && !empty($data['data'])) {
                $row = $data['data'][0];

                return $this->response->setJSON([
                    'status' => 'success',
                    'data' => [
                        'postingData' => $row,
                        'nextPostingSequence' => isset($data['nextPostingSequence'])
                            ? $data['nextPostingSequence']
                            : ($row['nextPostingSequence'] ?? '1')
                    ]
                ]);
            }

            return $this->response->setJSON([
                'status' => 'success',
                'data' => [
                    'postingData' => [],
                    'nextPostingSequence' => '0'
                ]
            ]);
        }
    }

    public function saveGlOptionPosting()
    {
        if ($this->request->isAJAX()) {
            helper(['form', 'url', 'restclient']);

            $url = "{$this->server3}/api/tmstgloption/posting/update";
            $systemID = 'Medicelle';

            $body = [
                "SystemID"             => $systemID,
                "LockBudgetSets"        => ($this->request->getVar('LockBudgetSets') === 'on'),
                "UseAccountGroups"      => ($this->request->getVar('UseAccountGroups') === 'on'),
                "AllowImportedEntries"  => ($this->request->getVar('AllowImportedEntries') === 'on'),
                "StartYear"             => $this->request->getVar('StartYear'),
                "CurrentYearFiscal"     => $this->request->getVar('CurrentYearFiscal'),
                "DefaultSrceLedger"     => $this->request->getVar('cb_srceledger'),
                "DefaultSrceType"       => $this->request->getVar('cb_srcetype'),
                "FunctionalCurrency"    => $this->request->getVar('cb_functionalcurrency'),
                "DefaultClosingAccount" => $this->request->getVar('cb_defaultclosingaccount'),
                "Edited"                => ($this->request->getVar('Edited') === '0'),
            ];

            $result = akses_restapikey('PUT', $url, $body, []);
            $data = is_string($result) ? json_decode($result, true) : $result;

            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Data berhasil disimpan',
                'data'    => $data
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Permintaan tidak valid',
            'data'    => []
        ]);
    }
    // End Method GL Option Posting

    // Start Method GL Option Segment
    public function fetchGlOptionSegment()
    {
        if ($this->request->isAJAX()) {
            helper(['restclient']);

            $url = "{$this->server3}/api/tmstgloption/segment";
            $query = [
                'action' => 'getall'
            ];

            $response = akses_restapikey('GET', $url, $body = [], $query);
            $data = json_decode($response, true);

            if (isset($data['success']) && $data['success'] === true && !empty($data['data'])) {
                $segmentsData = [];

                foreach ($data['data'] as $row) {
                    $segmentsData[] = [
                        'SegmentNumber' => $row['SegmentNumber'] ?? $row['segmentNumber'] ?? null,
                        'SegmentID' => $row['SegmentID'] ?? $row['segmentID'] ?? '',
                        'SegmentName' => $row['SegmentName'] ?? $row['segmentName'] ?? '',
                        'SegmentLength' => $row['SegmentLength'] ?? $row['segmentLength'] ?? 0,
                        'SegmentClosing' => $row['SegmentClosing'] ?? $row['segmentClosing'] ?? false
                    ];
                }

                return $this->response->setJSON([
                    'status' => 'success',
                    'data' => $segmentsData
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'success',
                    'data' => []
                ]);
            }
        }
    }

    public function saveGlOptionSegment()
    {
        if ($this->request->isAJAX()) {
            helper(['restclient']);

            $jsonData = $this->request->getJSON();

            if (empty($jsonData)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'No segments data received'
                ]);
            }

            $segments = json_decode(json_encode($jsonData), true);

            $url = "{$this->server3}/api/tmstgloption/segment";

            $response = akses_restapikey('POST', $url, $segments, [], true);
            $data = json_decode($response, true);

            if (isset($data['success']) && $data['success'] === true) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => $data['message'] ?? 'All segments saved successfully'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $data['message'] ?? 'Failed to save segments',
                    'error' => $data['error'] ?? null
                ]);
            }
        }
    }
    // End Method GL Option Segment

    // Start Method GL Option Email
    public function fetchGlOptionEmail()
    {
        if ($this->request->isAJAX()) {
            helper(['restclient']);

            $url = "{$this->server3}/api/tmstgloption/email";
            $query = [
                'action' => 'get'
            ];

            $response = akses_restapikey('GET', $url, $body = [], $query);
            $data = json_decode($response, true);

            if (isset($data['success']) && $data['success'] === true && !empty($data['data'])) {
                $row = $data['data'][0];

                return $this->response->setJSON([
                    'status' => 'success',
                    'data' => [
                        'EmailService' => $row['emailService'],
                        'ServerName' => $row['serverName'],
                        'ServerPort' => $row['serverPort'],
                        'Ssl' => $row['ssl'] ?? false,
                        'Username' => $row['username'],
                        'Password' => $row['password'],
                        'FormEmail' => $row['formEmail'],
                        'SendCopies' => $row['sendCopies'],
                        'SendTest' => $row['sendTest'],
                    ]
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
    }

    public function saveGlOptionEmail()
    {
        if ($this->request->isAJAX()) {

            helper(['form', 'url', 'restclient']);

            $validation = \Config\Services::validation();

            // $rules = [
            //     'EmailService' => [
            //         'label' => 'Email Service',
            //         'rules' => 'required',
            //         'errors' => [
            //             'required' => 'Email Service is required'
            //         ]
            //     ]
            // ];

            // if (!$this->validate($rules)) {
            //     return $this->response->setJSON([
            //         'error' => $validation->getErrors()
            //     ]);
            // }

            $systemID = 'Medicelle';

            $url = "{$this->server3}/api/tmstgloption/email/update";

            $body = [
                "SystemID"     => $systemID,
                "EmailService" => $this->request->getVar('EmailService'),
                "ServerName" => $this->request->getVar('ServerName'),
                "ServerPort" => $this->request->getVar('ServerPort') ? (int)$this->request->getVar('ServerPort') : null,
                "Ssl" => ($this->request->getVar('Ssl') === 'on'),
                "Username" => $this->request->getVar('Username'),
                "Password" => $this->request->getVar('Password'),
                "FormEmail" => $this->request->getVar('FormEmail'),
                "SendCopies" => $this->request->getVar('SendCopies'),
                "SendTest" => $this->request->getVar('SendTest'),
            ];

            $result = akses_restapikey('PUT', $url, $body, []);

            $result = is_string($result) ? json_decode($result, true) : $result;

            if (isset($result['success']) && $result['success'] === true) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Save data successfully',
                    'data' => $result,
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $result['message'] ?? 'Failed to update email configuration',
                    'errors' => $result['errors'] ?? null,
                    'debug' => $result
                ]);
            }
        }
    }
    // End Method GL Option Email
}
