<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Excel;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class Tmstgljournal extends BaseController
{
    // SECTION: PROPERTIES
    protected $data;
    protected $server;
    protected $server3;
    protected $client;

    // SECTION: CONSTRUCTOR
    public function __construct()
    {
        $this->session = session();
        $uri = service('uri');
        $this->server = $_ENV['APP_API'];
        $this->server3 = $_ENV['APP_API3'];
        $this->client = service('curlrequest');
    }

    // ====================================================================================
    // SECTION: VIEW RENDERING
    // ====================================================================================

    /**
     * Display main journal entry page
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     */
    public function index()
    {
        helper(['dropdown']);

        // Get parameters from URL for preselection
        $batchIdFromUrl = $this->request->getGet('batchId');
        $srceLedgerFromUrl = $this->request->getGet('srceLedger');

        // Set preselected batch ID in session
        if ($batchIdFromUrl) {
            session()->set('preselected_batch_id', $batchIdFromUrl);
            $this->data['preselected_batch_id'] = $batchIdFromUrl;
        } else {
            $this->data['preselected_batch_id'] = null;
        }

        $selectedSrceLedger = $srceLedgerFromUrl ?: null;

        // Load dropdown data
        $this->data['cb_batchid'] = getDropdownBatchNumberInject('BatchId', 'cb_batchid');
        $this->data['cb_srceledger'] = getDropdownSrceLedgerDesc('SrceLedger', 'cb_srceledger', $selectedSrceLedger);
        $this->data['cb_srcetype'] = getDropdownSrceType('SrceType', 'cb_srcetype');
        $this->data['cb_batchentry'] = getDropdownBatchEntry('BatchEntry', 'cb_batchentry');
        $this->data['cb_scurncode'] = getDropdownCurrencyRateGl('ScurnCode', 'cb_scurncode');
        $this->data['cb_startrangebatchentry'] = getDropdownStartRangeBatchEntry('RangeBatchEntry', 'cb_startrangebatchentry');
        $this->data['cb_endrangebatchentry'] = getDropdownEndRangeBatchEntry('RangeBatchEntry', 'cb_endrangebatchentry');
        $this->data['cb_fiscalcalender'] = getDropdownFiscalCalender('cb_fiscal_calender', 'cb_fiscal_calender');

        return view('tmstgljournal/index', $this->data);
    }

    // ====================================================================================
    // SECTION: DROPDOWN DATA FETCH (AJAX)
    // ====================================================================================

    /**
     * Get source type based on selected source ledger
     * 
     * @return \CodeIgniter\HTTP\Response
     */

    public function getFiscalYear()
    {
        $fiscYear = $this->request->getGet('fiscYear');

        helper(['dropdown']);

        $obj = apiDropdownFiscalCalender($fiscYear);

        return $this->response->setJSON($obj);
    }

    public function getSourceType()
    {
        $srceLedger = $this->request->getGet('srceLedger');

        helper(['dropdown']);
        $result = apiDropdownSrceType('SrceType', $srceLedger);

        return $this->response->setJSON($result);
    }

    /**
     * Get batch entry based on selected batch ID
     * 
     * @return \CodeIgniter\HTTP\Response
     */
    public function getSrceDesc()
    {
        $srceLedger = $this->request->getGet('SrceLedger');
        $srceType = $this->request->getGet('SrceType');

        if (!$srceLedger || !$srceType) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Missing parameters'
            ]);
        }

        $server3 = $_ENV['APP_API3'];
        $url = "{$server3}/api/tmstgljournal/getsrcedesc";

        $query = [
            'SrceLedger' => $srceLedger,
            'SrceType' => $srceType
        ];

        $response = akses_restapikey('GET', $url, [], $query);
        $result = json_decode($response, true);

        if ($result && isset($result['success']) && $result['success']) {
            return $this->response->setJSON([
                'success' => true,
                'data' => [
                    'srceDesc' => $result['data']['srceDesc']
                ]
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => $result['message'] ?? 'Data not found'
        ]);
    }

    public function getBatchEntry()
    {
        $batchId = $this->request->getPost('batchId') ?? $this->request->getGet('batchId');

        helper(['dropdown']);
        $result = apiDropdownBatchEntry('BatchEntry', $batchId);

        return $this->response->setJSON($result);
    }

    // ====================================================================================
    // SECTION: API DATA FETCH
    // ====================================================================================

    /**
     * Get all data from warehouse API
     * 
     * @return array
     */
    public function apiDataGetAll()
    {
        helper(['restclient']);

        $url = "{$this->server3}/api/warehouse";
        $query = [
            'action' => 'getall',
            'warehouseCd' => ''
        ];

        $response = akses_restapikey('GET', $url, $body = [], $query);
        $data = json_decode($response, true);

        return $data["data"];
    }

    // ====================================================================================
    // SECTION: REVERSE BATCH ENTRY
    // ====================================================================================

    public function reverseBatchEntry()
    {
        try {

            $data = $this->request->getJSON(true);

            $batchId = $data['batchId'] ?? null;
            $batchEntry = $data['batchEntry'] ?? null;
            $userId = session()->get('usr_id');

            helper(['restclient']);

            $payload = [
                'BatchId' => $batchId,
                'BatchEntry' => $batchEntry,
                'User_Id' => $userId
            ];

            $url = "{$this->server3}/api/tmstgljournal/reversebatchentry";

            $response = akses_restapikey('POST', $url, $payload, [
                'Content-Type' => 'application/json'
            ]);

            return $this->response->setJSON($response);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    // ====================================================================================
    // SECTION: CRUD OPERATIONS
    // ====================================================================================

    /**
     * Handle edit action for journal entry
     * 
     * @return \CodeIgniter\HTTP\Response
     */
    public function action()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid request method'
            ]);
        }

        if (!$this->request->getVar('action')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Action tidak ditemukan'
            ]);
        }

        helper(['form', 'url']);

        if ($this->request->getVar('action') == 'Edit') {
            helper(['restclient']);

            $url = "{$this->server3}/api/tmstgljournal/updatedetail";

            $audtDate = date('Y-m-d');
            $audtTime = date('H:i:s');
            $audtUser = session()->get('usr_id');

            // Calculate amounts
            $scurnAmtDebit = (float) $this->request->getVar('ScurnAmtDebit');
            $scurnAmtCredit = (float) $this->request->getVar('ScurnAmtCredit');
            $scurnAmt = $scurnAmtDebit > 0 ? $scurnAmtDebit : ($scurnAmtCredit > 0 ? -$scurnAmtCredit : 0);

            $transAmtDebit = (float) $this->request->getVar('TransAmtDebit');
            $transAmtCredit = (float) $this->request->getVar('TransAmtCredit');
            $transAmt = $transAmtDebit > 0 ? $transAmtDebit : ($transAmtCredit > 0 ? -$transAmtCredit : 0);

            // Prepare request body
            $body = [
                "BatchId"    => $this->request->getVar('BatchId'),
                "BatchEntry" => $this->request->getVar('BatchEntry'),
                "TransNbr"   => $this->request->getVar('TransNbr'),
                "AudtDate"   => $audtDate,
                "AudtTime"   => $audtTime,
                "AudtUser"   => $audtUser,
                "AcctId"     => $this->request->getVar('AcctId'),
                "AcctName"   => $this->request->getVar('AcctName'),
                "ScurnCode"  => $this->request->getVar('ScurnCode'),
                "ScurnAmt"   => $scurnAmt,
                "HcurnCode"  => $this->request->getVar('HcurnCode'),
                "TransAmt"   => $transAmt,
                "RateDate"   => $this->request->getVar('RateDate'),
                "ConvRate"   => (float) ($this->request->getVar('ConvRate') ?: 1),
                "TransDesc"  => $this->request->getVar('TransDesc'),
                "TransRef"   => $this->request->getVar('TransRef'),
                "Comment"    => $this->request->getVar('Comment')
            ];

            $result = akses_restapikey('PUT', $url, $body);
            $result = is_string($result) ? json_decode($result, true) : $result;

            if (isset($result['success']) && $result['success'] === true) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Journal Entry berhasil diubah',
                    'data' => $result,
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $result['message'] ?? 'Gagal mengubah Journal Entry',
                    'errors' => $result['errors'] ?? null
                ]);
            }
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Action tidak dikenali'
        ]);
    }

    /**
     * Check balance for specific batch entry
     * 
     * @return \CodeIgniter\HTTP\Response
     */
    public function checkBalance()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request'
            ]);
        }

        $batchId = $this->request->getGet('batchId');
        $batchEntry = $this->request->getGet('batchEntry');

        if (!$batchId || !$batchEntry) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Batch ID dan Batch Entry harus diisi'
            ]);
        }

        helper(['restclient']);

        $url = "{$this->server3}/api/tmstgljournal/checkbalance/{$batchId}/{$batchEntry}";

        try {
            $response = akses_restapikey('GET', $url, [], []);
            $result = is_string($response) ? json_decode($response, true) : $response;

            return $this->response->setJSON([
                'success' => true,
                'data' => $result['data'] ?? [
                    'TotalDebit' => 0,
                    'TotalCredit' => 0,
                    'OutOfBalance' => 0
                ]
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to check balance: ' . $e->getMessage(),
                'data' => [
                    'TotalDebit' => 0,
                    'TotalCredit' => 0,
                    'OutOfBalance' => 0
                ]
            ]);
        }
    }

    // ====================================================================================
    // SECTION: DATATABLES
    // ====================================================================================

    /**
     * Get fiscal calendar data for datatables
     * 
     * @return \CodeIgniter\HTTP\Response
     */
    public function datatablesfiscalcalender()
    {
        helper(['restclient']);

        $rawBody = $this->request->getBody();
        $json = json_decode($rawBody, true);

        $srceLedger = $json['SrceLedger'] ?? null;
        $fiscYear   = $json['FiscYear']   ?? null;

        if (!$srceLedger || !$fiscYear) {
            return $this->response->setJSON([
                'draw' => $json['draw'] ?? 0,
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => 'SrceLedger and FiscYear are required'
            ]);
        }

        $json['SrceLedger'] = $srceLedger;
        $json['FiscYear']   = $fiscYear;

        $url = "{$this->server3}/api/tmstfiscalcalenderlock/datatablesget";

        $response = akses_restapikey('POST', $url, $json);

        $result = json_decode($response, true);

        // fallback kalau API error / kosong
        if (!$result) {
            return $this->response->setJSON([
                'draw' => $json['draw'] ?? 0,
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => 'Failed to get response from API'
            ]);
        }

        return $this->response->setJSON($result);
    }

    /**
     * Get batch entry data for datatables
     * 
     * @return \CodeIgniter\HTTP\Response
     */
    public function datatablesbatchentry()
    {
        helper(['restclient']);

        $rawBody = $this->request->getBody();
        $json = json_decode($rawBody, true);

        $batchId = $json['BatchId'] ?? null;

        if (!$batchId) {
            return $this->response->setJSON([
                'draw' => $json['draw'] ?? 0,
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => 'BatchId is required'
            ]);
        }

        $json['BatchId'] = $batchId;

        $url = "{$this->server3}/api/tmstgljournal/datatablesbatchentry";
        $response = akses_restapikey('POST', $url, $json);

        $result = json_decode($response, true);

        return $this->response->setJSON($result);
    }

    /**
     * Get master COA data for datatables
     * 
     * @return \CodeIgniter\HTTP\Response
     */
    public function datatablesmastercoa()
    {
        helper(['restclient']);
        $rawBody = $this->request->getBody();
        $json = json_decode($rawBody, true);

        $url = "{$this->server3}/api/tmstcoa/datatablesget";
        $response = akses_restapikey('POST', $url, $json);

        $result = json_decode($response, true);

        if (isset($result['data'])) {
            foreach ($result['data'] as $i => &$row) {
                $acctNo = $row['acctNo'];
                $acctName = $row['acctName'];

                $row['acctNo'] = $acctNo;
                $row['acctName'] = $acctName;
                $row['rownum'] = $i + ($json['start'] ?? 0) + 1;
            }
        }

        return $this->response->setJSON($result);
    }

    /**
     * Get journal data for datatables
     * 
     * @return \CodeIgniter\HTTP\Response
     */
    public function datatables()
    {
        helper(['restclient']);
        $rawBody = $this->request->getBody();
        $json = json_decode($rawBody, true);

        $url = "{$this->server3}/api/tmstgljournal/datatables";
        $response = akses_restapikey('POST', $url, $json);

        $result = json_decode($response, true);

        $originalRecordsTotal = $result['recordsTotal'] ?? 0;
        $originalRecordsFiltered = $result['recordsFiltered'] ?? 0;

        if (!empty($result['data']) && is_array($result['data'])) {
            $filteredData = array_filter($result['data'], function ($row) {
                return !empty($row['transNbr']) ||
                    !empty($row['transRef']) ||
                    !empty($row['acctId']) ||
                    !empty($row['acctName']) ||
                    !empty($row['scurnAmt']) ||
                    !empty($row['transAmt']);
            });

            $filteredData = array_values($filteredData);

            $result['data'] = $filteredData;

            $result['recordsTotal'] = $originalRecordsTotal;
            $result['recordsFiltered'] = $originalRecordsFiltered;

            foreach ($result['data'] as $i => &$row) {
                $cd     = $row['batchId'] ?? '';
                $entry  = $row['batchEntry'] ?? '';
                $trans  = $row['transNbr'] ?? '';

                $row['rownum'] = $i + ($json['start'] ?? 0) + 1;

                $row['aksi'] = '
            <div class="btn-group">
                <a class="btn btn-sm btn-info view ' . ($this->session->get("flag_view") === 1 ? "" : "d-none") . '"
                   data-batchid="' . $cd . '"
                   data-batchentry="' . $entry . '"
                   data-transnbr="' . $trans . '">
                   <i class="fas fa-eye"></i>
                </a>

                <a class="btn btn-sm btn-primary edit ' . ($this->session->get("flag_update") === 1 ? "" : "d-none") . '"
                   data-batchid="' . $cd . '"
                   data-batchentry="' . $entry . '"
                   data-transnbr="' . $trans . '">
                   <i class="fas fa-tags"></i>
                </a>

                <a class="btn btn-sm btn-danger delete ' . ($this->session->get("flag_delete") === 1 ? "" : "d-none") . '"
                   data-batchid="' . $cd . '"
                   data-batchentry="' . $entry . '"
                   data-transnbr="' . $trans . '">
                   <i class="fas fa-trash"></i>
                </a>
            </div>';
            }
        } else {
            $result['data'] = [];
            $result['recordsTotal'] = 0;
            $result['recordsFiltered'] = 0;
        }

        return $this->response->setJSON($result);
    }

    // ====================================================================================
    // SECTION: DELETE OPERATIONS
    // ====================================================================================

    /**
     * Delete journal entry (multiple parameter options)
     * 
     * @param string|null $batchId
     * @param string|null $batchEntry
     * @param string|null $transNbr
     * @return \CodeIgniter\HTTP\Response
     */
    public function delete($batchId = null, $batchEntry = null, $transNbr = null)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Request tidak valid'
            ]);
        }

        helper(['restclient']);

        if ($batchId && $batchEntry && $transNbr) {
            return $this->processDelete($batchId, $batchEntry, $transNbr);
        }

        $input = $this->request->getJSON(true);
        $batchId = $input['batchId'] ?? null;
        $batchEntry = $input['batchEntry'] ?? null;
        $transNbr = $input['transNbr'] ?? null;

        if ($batchId && $batchEntry && $transNbr) {
            return $this->processDelete($batchId, $batchEntry, $transNbr);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Parameter tidak lengkap'
        ]);
    }

    /**
     * Process delete operation
     * 
     * @param string $batchId
     * @param string $batchEntry
     * @param string $transNbr
     * @return \CodeIgniter\HTTP\Response
     */
    private function processDelete($batchId, $batchEntry, $transNbr)
    {
        $url = "{$this->server3}/api/tmstgljournal/{$batchId}/{$batchEntry}/{$transNbr}";
        $result = akses_restapikey('DELETE', $url, [], []);
        $result = is_string($result) ? json_decode($result, true) : $result;

        if (isset($result['success']) && $result['success'] === true) {
            return $this->response->setJSON([
                'success' => true,
                'message' => $result['message'] ?? 'Detail transaksi berhasil dihapus'
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => $result['message'] ?? 'Gagal menghapus detail transaksi',
            'errors' => $result['errors'] ?? null
        ]);
    }

    /**
     * Delete entire batch entry
     * 
     * @return \CodeIgniter\HTTP\Response
     */
    public function deleteBatchEntry()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request method'
            ]);
        }

        $input = $this->request->getJSON(true);
        $batchId = $input['batchId'] ?? null;
        $batchEntry = $input['batchEntry'] ?? null;

        if (!$batchId || !$batchEntry) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Batch ID dan Batch Entry harus diisi'
            ]);
        }

        helper(['restclient']);

        $url = "{$this->server3}/api/tmstgljournal/deletebatchentry";

        $body = [
            "BatchId" => $batchId,
            "BatchEntry" => $batchEntry
        ];

        $response = akses_restapikey('PUT', $url, $body);
        $result = is_string($response) ? json_decode($response, true) : $response;

        if (isset($result['success']) && $result['success'] === true) {
            return $this->response->setJSON([
                'success' => true,
                'message' => $result['message'] ?? 'Batch entry berhasil dihapus'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => $result['message'] ?? 'Gagal menghapus batch entry'
            ]);
        }
    }

    // ====================================================================================
    // SECTION: DATA FETCHING
    // ====================================================================================

    /**
     * Fetch single journal entry data
     * 
     * @return \CodeIgniter\HTTP\Response
     */
    public function fetchSingleData()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Maaf tidak dapat diproses!'
            ]);
        }

        $batchNbr = $this->request->getVar('BatchId');
        $batchEntry = $this->request->getVar('BatchEntry');
        $transNbr = $this->request->getVar('TransNbr');

        if (!$batchNbr || !$batchEntry || !$transNbr) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Parameter tidak lengkap'
            ]);
        }

        helper(['restclient']);

        $url = "{$this->server3}/api/tmstgljournal/getdetail/{$batchNbr}/{$batchEntry}/{$transNbr}";

        $response = akses_restapikey('GET', $url, $body = [], $query = []);
        $data = json_decode($response, true);

        if (isset($data['success']) && $data['success'] === true && !empty($data['data'])) {
            $row = $data['data'];

            return $this->response->setJSON([
                'success' => true,
                'data' => [
                    'BatchId'     => $batchNbr,
                    'BatchEntry'  => $batchEntry,
                    'JournalId'   => $row['journalId'],
                    'TransNbr'    => $row['transNbr'],
                    'AcctId'      => $row['acctId'],
                    'AcctName'    => $row['acctName'],
                    'ScurnCode'   => $row['scurnCode'],
                    'ScurnAmt'    => $row['scurnAmt'],
                    'HcurnCode'   => $row['hcurnCode'],
                    'TransAmt'    => $row['transAmt'],
                    'TransDesc'   => $row['transDesc'],
                    'TransRef'    => $row['transRef'],
                    'Comment'     => $row['comment'],
                    'RateDate'    => $row['rateDate'],
                    'ConvRate'    => $row['convRate']
                ]
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => $data['message'] ?? 'Data tidak ditemukan'
        ]);
    }

    // ====================================================================================
    // SECTION: SAVE OPERATIONS
    // ====================================================================================

    /**
     * Save journal data (bulk operation)
     * 
     * @return \CodeIgniter\HTTP\Response
     */
    public function savedata()
    {
        helper(['restclient', 'dropdown']);

        $input = $this->request->getJSON(true);
        $batchId = $input['batchId'] ?? null;
        $batchEntry = $input['batchEntry'] ?? null;

        if (empty($batchId) || empty($batchEntry)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Batch ID dan Batch Entry harus diisi'
            ]);
        }

        $currentDate = date('Y-m-d');
        $currentTime = date('H:i:s');
        $userId = session()->get('usr_id');

        $entries = $input['entries'] ?? [];
        $deletedEntries = $input['deletedEntries'] ?? [];
        $headerData = $input['header'] ?? [];
        $softEditEntries = $input['softEditEntries'] ?? [];

        $successCount = 0;
        $errorCount = 0;
        $errors = [];
        $deletedCount = 0;
        $updatedCount = 0;

        // Process soft edit entries
        if (!empty($softEditEntries)) {
            foreach ($softEditEntries as $softEditEntry) {
                $transNbr = $softEditEntry['TransNbr'] ?? null;

                if ($transNbr) {
                    $saveResult = $this->updateJournalEntry($softEditEntry, $headerData, $batchId, $batchEntry, $userId, $currentDate, $currentTime);

                    if ($saveResult['success']) {
                        $updatedCount++;
                    } else {
                        $errorCount++;
                        $errors[] = $saveResult['message'];
                    }
                }
            }
        }

        // Process deleted entries
        if (!empty($deletedEntries)) {
            foreach ($deletedEntries as $deletedEntry) {
                $isLocalData = $deletedEntry['isLocalData'] ?? true;

                if (!$isLocalData) {
                    $transNbr = $deletedEntry['TransNbr'] ?? $deletedEntry['lineNumber'] ?? $deletedEntry['transNbr'] ?? null;

                    if ($transNbr) {
                        $deleteResult = $this->deleteDatabaseEntry($batchId, $batchEntry, $transNbr);

                        if ($deleteResult['success']) {
                            $deletedCount++;
                        } else {
                            if (!$deleteResult['not_found']) {
                                $errorCount++;
                                $errors[] = "Hapus Entry {$transNbr}: " . $deleteResult['message'];
                            } else {
                                $deletedCount++;
                            }
                        }
                    }
                }
            }
        }

        // Process new entries
        if (!empty($entries)) {
            foreach ($entries as $index => $entry) {
                $saveResult = $this->saveJournalEntry($entry, $headerData, $batchId, $batchEntry, $userId, $currentDate, $currentTime, $index);

                if ($saveResult['success']) {
                    $successCount++;
                } else {
                    $errorCount++;
                    $errors[] = $saveResult['message'];
                }
            }
        }

        // Update header data if exists
        if (!empty($headerData)) {
            $this->updateHeaderData($headerData, $batchId, $batchEntry, $userId, $currentDate, $currentTime);
        }

        $summaryData = $this->getUpdatedSummaryData($batchId);

        if ($errorCount === 0) {
            $message = "Data berhasil disimpan";
            $details = [];

            return $this->response->setJSON([
                'success' => true,
                'message' => $message,
                'saved_count' => $successCount,
                'updated_count' => $updatedCount,
                'deleted_count' => $deletedCount,
                'summary' => $summaryData
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => "Data disimpan: {$successCount} ditambah, {$updatedCount} diupdate, {$deletedCount} dihapus, {$errorCount} gagal",
            'saved_count' => $successCount,
            'updated_count' => $updatedCount,
            'deleted_count' => $deletedCount,
            'error_count' => $errorCount,
            'errors' => $errors,
            'summary' => $summaryData
        ]);
    }

    /**
     * Update existing journal entry
     * 
     * @param array $entry
     * @param array $headerData
     * @param string $batchId
     * @param string $batchEntry
     * @param string $userId
     * @param string $currentDate
     * @param string $currentTime
     * @return array
     */
    private function updateJournalEntry($entry, $headerData, $batchId, $batchEntry, $userId, $currentDate, $currentTime)
    {
        // Calculate amounts
        $scurnAmtDebit = floatval($entry['ScurnAmtDebit'] ?? 0);
        $scurnAmtCredit = floatval($entry['ScurnAmtCredit'] ?? 0);
        $scurnAmt = $scurnAmtDebit > 0 ? $scurnAmtDebit : ($scurnAmtCredit > 0 ? -$scurnAmtCredit : 0);

        $transAmtDebit = floatval($entry['TransAmtDebit'] ?? 0);
        $transAmtCredit = floatval($entry['TransAmtCredit'] ?? 0);
        $transAmt = $transAmtDebit > 0 ? $transAmtDebit : ($transAmtCredit > 0 ? -$transAmtCredit : 0);

        $detailBody = [
            "action" => "updatedetail",
            "BatchId" => $batchId,
            "BatchEntry" => $batchEntry,
            "TransNbr" => $entry['TransNbr'],
            "AudtDate" => $currentDate,
            "AudtTime" => $currentTime,
            "AudtUser" => $userId,
            "AcctId" => $entry['AcctId'],
            "ScurnCode" => $entry['ScurnCode'],
            "ScurnAmt" => $scurnAmt,
            "HcurnCode" => $entry['HcurnCode'] ?? $entry['ScurnCode'],
            "TransAmt" => $transAmt,
            "RateDate" => $this->convertDate($entry['RateDate'] ?? $currentDate),
            "ConvRate" => floatval($entry['ConvRate'] ?? 1),
            "TransDesc" => $entry['TransDesc'],
            "TransRef" => $entry['TransRef'],
            "Comment" => $entry['Comment']
        ];

        $url = "{$this->server3}/api/tmstgljournal";
        $response = akses_restapikey('POST', $url, $detailBody);
        $result = is_string($response) ? json_decode($response, true) : $response;

        if (isset($result['success']) && $result['success'] === true) {
            return ['success' => true, 'message' => ''];
        }

        $errorMsg = $result['message'] ?? 'Gagal mengupdate detail';
        return [
            'success' => false,
            'message' => "Entry " . ($entry['TransNbr'] ?? 'Unknown') . ": " . $errorMsg
        ];
    }

    /**
     * Delete database entry
     * 
     * @param string $batchId
     * @param string $batchEntry
     * @param string $transNbr
     * @return array
     */
    private function deleteDatabaseEntry($batchId, $batchEntry, $transNbr)
    {
        $url = "{$this->server3}/api/tmstgljournal/{$batchId}/{$batchEntry}/{$transNbr}";
        $response = akses_restapikey('DELETE', $url, [], []);
        $result = is_string($response) ? json_decode($response, true) : $response;

        if (isset($result['success']) && $result['success'] === true) {
            return ['success' => true, 'message' => $result['message'] ?? 'Success'];
        }

        $errorMessage = $result['message'] ?? 'Unknown error';
        $isNotFoundError = stripos($errorMessage, 'tidak ditemukan') !== false;

        return [
            'success' => false,
            'message' => $errorMessage,
            'not_found' => $isNotFoundError
        ];
    }

    /**
     * Save new journal entry
     * 
     * @param array $entry
     * @param array $headerData
     * @param string $batchId
     * @param string $batchEntry
     * @param string $userId
     * @param string $currentDate
     * @param string $currentTime
     * @param int $index
     * @return array
     */
    private function saveJournalEntry($entry, $headerData, $batchId, $batchEntry, $userId, $currentDate, $currentTime, $index)
    {
        // Calculate amounts
        $scurnAmtDebit = floatval($entry['ScurnAmtDebit'] ?? 0);
        $scurnAmtCredit = floatval($entry['ScurnAmtCredit'] ?? 0);
        $scurnAmt = $scurnAmtDebit > 0 ? $scurnAmtDebit : ($scurnAmtCredit > 0 ? -$scurnAmtCredit : 0);

        $transAmtDebit = floatval($entry['TransAmtDebit'] ?? 0);
        $transAmtCredit = floatval($entry['TransAmtCredit'] ?? 0);
        $transAmt = $transAmtDebit > 0 ? $transAmtDebit : ($transAmtCredit > 0 ? -$transAmtCredit : 0);

        // Validate amounts
        if ($scurnAmt == 0 && $transAmt == 0) {
            return [
                'success' => false,
                'message' => "Entry " . ($entry['lineNumber'] ?? ($index + 1)) . ": Debit atau Credit harus diisi"
            ];
        }

        $detailBody = [
            "action" => "insert",
            "BatchId" => $batchId,
            "BatchEntry" => $batchEntry,
            "AudtDate" => $currentDate,
            "AudtTime" => $currentTime,
            "AudtUser" => $userId,
            "SrceLedger" => $entry['SrceLedger'] ?? $headerData['SrceLedger'],
            "SrceType" => $entry['SrceType'] ?? $headerData['SrceType'],
            "FscsYr" => $this->extractYearFromPeriod($entry['YearPeriod'] ?? $headerData['YearPeriod']),
            "FscsPerd" => $this->extractPeriodFromPeriod($entry['YearPeriod'] ?? $headerData['YearPeriod']),
            "JrnlDesc" => $entry['JrnlDesc'] ?? $headerData['JrnlDesc'],
            "DateEntry" => $this->convertDate($entry['DataEntry'] ?? $headerData['DataEntry'] ?? $currentDate),
            "PostDate" => $this->convertDate($entry['PostDate'] ?? $headerData['PostDate'] ?? $currentDate),
            "TransNbr" => $entry['lineNumber'] ?? ($index + 1),
            "AcctId" => $entry['AcctId'],
            "ScurnCode" => $entry['ScurnCode'],
            "ScurnAmt" => $scurnAmt,
            "HcurnCode" => $entry['HcurnCode'] ?? $entry['ScurnCode'],
            "TransAmt" => $transAmt,
            "RateDate" => $this->convertDate($entry['RateDate'] ?? $currentDate),
            "ConvRate" => floatval($entry['ConvRate'] ?? 1),
            "TransDesc" => $entry['TransDesc'],
            "TransRef" => $entry['TransRef'],
            "Comment" => $entry['Comment']
        ];

        $url = "{$this->server3}/api/tmstgljournal";
        $response = akses_restapikey('POST', $url, $detailBody);
        $result = is_string($response) ? json_decode($response, true) : $response;

        if (isset($result['success']) && $result['success'] === true) {
            return ['success' => true, 'message' => ''];
        }

        $errorMsg = $result['message'] ?? 'Gagal menyimpan detail';
        return [
            'success' => false,
            'message' => "Entry " . ($entry['lineNumber'] ?? ($index + 1)) . ": " . $errorMsg
        ];
    }

    /**
     * Convert date to Y-m-d format
     * 
     * @param string $dateString
     * @return string
     */
    private function convertDate($dateString)
    {
        if (empty($dateString)) {
            return date('Y-m-d');
        }

        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateString)) {
            return $dateString;
        }

        if (preg_match('/^(\d{2})\/(\d{2})\/(\d{4})$/', $dateString, $matches)) {
            return $matches[3] . '-' . $matches[2] . '-' . $matches[1];
        }

        return date('Y-m-d');
    }

    /**
     * Update header data
     * 
     * @param array $headerData
     * @param string $batchId
     * @param string $batchEntry
     * @param string $userId
     * @param string $currentDate
     * @param string $currentTime
     * @return bool
     */
    private function updateHeaderData($headerData, $batchId, $batchEntry, $userId, $currentDate, $currentTime)
    {
        try {
            $headerBody = [
                "action"        => "updateheader",
                "BatchId"       => $batchId,
                "BatchEntry"    => $batchEntry,
                "AudtDate"      => $currentDate,
                "AudtTime"      => $currentTime,
                "AudtUser"      => $userId,
                "SrceLedger"    => $headerData['SrceLedger'],
                "DrilApp"       => $headerData['SrceLedger'],
                "SrceType"      => $headerData['SrceType'],
                "FscsYr"        => $this->extractYearFromPeriod($headerData['YearPeriod']),
                "FscsPerd"      => $this->extractPeriodFromPeriod($headerData['YearPeriod']),
                "JrnlDesc"      => $headerData['JrnlDesc'],
                "DateEntry"     => $this->convertDate($headerData['DataEntry'] ?? $currentDate),
                "PostDate"      => $this->convertDate($headerData['PostDate'] ?? $currentDate)
            ];

            $url = "{$this->server3}/api/tmstgljournal";
            $response = akses_restapikey('POST', $url, $headerBody);
            $result = is_string($response) ? json_decode($response, true) : $response;

            return isset($result['success']) && $result['success'] === true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getAllowimport()
    {
        try {
            if (!$this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Maaf tidak dapat diproses!'
                ]);
            }

            helper(['restclient']);

            $url = "{$this->server3}/api/tmstgljournal/getallowimport";

            $response = akses_restapikey('GET', $url, $body = [], $query = []);
            $data = json_decode($response, true);

            if (isset($data['success']) && $data['success'] === true && isset($data['data']['allowImport'])) {
                return $this->response->setJSON([
                    'success' => true,
                    'data' => [
                        'allowImport' => $data['data']['allowImport']
                    ]
                ]);
            }

            return $this->response->setJSON([
                'success' => false,
                'message' => $data['message'] ?? 'Gagal mendapatkan data allow import'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ]);
        }
    }

    // ====================================================================================
    // SECTION: SUMMARY DATA
    // ====================================================================================

    /**
     * Get summary data for batch
     * 
     * @return \CodeIgniter\HTTP\Response
     */
    public function getSummaryData()
    {
        helper(['dropdown']);

        $batchId = $this->request->getGet('batchId');

        if (!$batchId) {
            return $this->response->setJSON([
                'success' => true,
                'data' => $this->getEmptySummaryData()
            ]);
        }

        $summaryData = $this->getUpdatedSummaryData($batchId);

        return $this->response->setJSON([
            'success' => true,
            'data' => $summaryData
        ]);
    }

    /**
     * Get updated summary data for batch
     * 
     * @param string $batchId
     * @return array
     */
    private function getUpdatedSummaryData($batchId)
    {
        if (!$batchId) {
            return $this->getEmptySummaryData();
        }

        $obj = apiDropdownBatchNumberInject('BatchId');

        if (!$obj || !isset($obj['data']) || !is_array($obj['data'])) {
            return $this->getEmptySummaryData();
        }

        foreach ($obj['data'] as $data) {
            if (isset($data['batchId']) && $data['batchId'] == $batchId) {
                return [
                    'SummaryBatchType' => $data['summaryBatchType'],
                    'SummaryBatchStatus' => $data['summaryBatchStatus'],
                    'SummaryEntries' => $data['summaryEntries'] ?? 0,
                    'SummaryDebits' => $data['summaryDebits'] ?? 0,
                    'SummaryCredits' => $data['summaryCredits'] ?? 0,
                ];
            }
        }

        return $this->getEmptySummaryData();
    }

    /**
     * Get empty summary data structure
     * 
     * @return array
     */
    private function getEmptySummaryData()
    {
        return [
            'SummaryBatchType' => '',
            'SummaryBatchStatus' => '',
            'SummaryEntries' => 0,
            'SummaryDebits' => 0,
            'SummaryCredits' => 0,
        ];
    }

    /**
     * Extract period from year-period string
     * 
     * @param string $yearPeriod
     * @return string
     */
    private function extractPeriodFromPeriod($yearPeriod)
    {
        if (empty($yearPeriod)) {
            return date('m');
        }

        $parts = explode('-', $yearPeriod);
        return $parts[1] ?? date('m');
    }

    /**
     * Extract year from year-period string
     * 
     * @param string $yearPeriod
     * @return string
     */
    private function extractYearFromPeriod($yearPeriod)
    {
        if (empty($yearPeriod)) {
            return date('Y');
        }

        $parts = explode('-', $yearPeriod);
        return $parts[0] ?? date('Y');
    }

    // ====================================================================================
    // SECTION: PDF GENERATION
    // ====================================================================================

    /**
     * Fetch single data for PDF printing
     * 
     * @param string $warehouse_cd
     * @return void
     */
    function fetchSingleDataPrint($warehouse_cd)
    {
        if ($warehouse_cd) {
            helper(['restclient']);

            $url = "{$this->server3}/tmstgljournal/getby/$warehouse_cd";

            $response = akses_restapikey('GET', $url, []);
            $data['response_data'] = json_decode($response, true);

            $pdf_data = $data['response_data'];
            $pdf_name = 'Single Data Field Value';
            $pdf_title = 'Data Field Value';
            $pdf_paper = 'A4';
            $pdf_orientation = 'portrait';
            $pdf_format = 'laporan_pdf';

            $this->view_pdf($pdf_name, $pdf_title, $pdf_data, $pdf_paper, $pdf_orientation, $pdf_format);
        }
    }

    /**
     * Generate PDF view
     * 
     * @param string $pdf_name
     * @param string $pdf_title
     * @param array $pdf_data
     * @param string $pdf_paper
     * @param string $pdf_orientation
     * @param string $pdf_format
     * @return void
     */
    public function view_pdf($pdf_name, $pdf_title, $pdf_data, $pdf_paper, $pdf_orientation, $pdf_format)
    {
        $Pdfgenerator = new Pdfgenerator();

        $file_pdf = $pdf_name;
        $this->data['title_pdf'] = $pdf_title;
        $this->data['produk'] = $pdf_data;
        $paper = $pdf_paper;
        $orientation = $pdf_orientation;

        $html = view($pdf_format, $this->data);

        $Pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    }

    // ====================================================================================
    // SECTION: EXPORT OPERATIONS
    // ====================================================================================

    /**
     * Export journal data to Excel
     * 
     * @return void
     */
    public function export()
    {
        $batchId = $this->request->getGet('batchId');
        $exportType = $this->request->getGet('exportType');
        $startBatchEntry = $this->request->getGet('startBatchEntry');
        $endBatchEntry = $this->request->getGet('endBatchEntry');

        if (!$batchId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Batch ID harus dipilih'
            ]);
        }

        helper(['restclient']);

        $exportUrl = "{$this->server3}/api/tmstgljournal/export/{$batchId}";

        if ($exportType === 'range' && $startBatchEntry && $endBatchEntry) {
            $exportUrl .= "/{$startBatchEntry}/{$endBatchEntry}";
        } else {
            $exportUrl .= "/ALL/ALL";
        }

        $exportResponse = akses_restapikey('GET', $exportUrl, [], []);
        $exportData = json_decode($exportResponse, true);

        $spreadsheet = new Spreadsheet();

        $headerSheet = $spreadsheet->getActiveSheet();
        $headerSheet->setTitle('Journal Header');

        $headerColumns = [
            'BatchId',
            'BatchEntry',
            'JrnlDesc',
            'SrceLedger',
            'SrceType',
            'FscsYr',
            'FscsPerd',
            'DateEntry',
            'PostDate'
        ];

        $headerSheet->fromArray($headerColumns, NULL, 'A1');

        $headers = $exportData['headers'] ?? [];
        $headerRows = [];

        if (!empty($headers) && is_array($headers)) {
            foreach ($headers as $header) {
                $headerRows[] = [
                    $header['BatchId'] ?? $batchId,
                    $header['BatchEntry'],
                    $header['JrnlDesc'],
                    $header['SrceLedger'],
                    $header['SrceType'],
                    $header['FscsYr'],
                    $header['FscsPerd'],
                    $this->formatDateForExport($header['DateEntry'] ?? null),
                    $this->formatDateForExport($header['PostDate'] ?? null)
                ];
            }
        }

        if (!empty($headerRows)) {
            $headerSheet->fromArray($headerRows, NULL, 'A2');
        }

        $detailSheet = $spreadsheet->createSheet();
        $detailSheet->setTitle('Journal Detail');

        $detailColumns = [
            'BatchId',
            'BatchEntry',
            'TransNbr',
            'AcctId',
            'AcctName',
            'ScurnCode',
            'ScurnAmt',
            'HcurnCode',
            'TransAmt',
            'ConvRate',
            'TransDesc',
            'TransRef',
            'Comment'
        ];

        $detailSheet->fromArray($detailColumns, NULL, 'A1');

        $details = $exportData['details'] ?? [];
        $detailRows = [];

        if (!empty($details) && is_array($details)) {
            foreach ($details as $detail) {
                $detailRows[] = [
                    $detail['BatchId'] ?? $batchId,
                    $detail['BatchEntry'],
                    $detail['TransNbr'],
                    $detail['AcctId'],
                    $detail['AcctName'],
                    $detail['ScurnCode'] ?? 'IDR',
                    $this->formatNumberForExport($detail['ScurnAmt'] ?? 0),
                    $detail['HcurnCode'] ?? ($detail['ScurnCode'] ?? 'IDR'),
                    $this->formatNumberForExport($detail['TransAmt'] ?? 0),
                    $this->formatNumberForExport($detail['ConvRate'] ?? 1, 6),
                    $detail['TransDesc'],
                    $detail['TransRef'],
                    $detail['Comment']
                ];
            }
        }

        if (!empty($detailRows)) {
            $detailSheet->fromArray($detailRows, NULL, 'A2');
        }

        $headerStyle = [
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'E6E6FA']
            ]
        ];

        $headerSheet->getStyle('A1:I1')->applyFromArray($headerStyle);
        $detailSheet->getStyle('A1:M1')->applyFromArray($headerStyle);

        $this->applyProperNumberFormatting($headerSheet, $detailSheet);

        foreach (range('A', 'I') as $col) {
            $headerSheet->getColumnDimension($col)->setAutoSize(true);
        }
        foreach (range('A', 'M') as $col) {
            $detailSheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);

        $rangeInfo = ($exportType === 'range' && $startBatchEntry && $endBatchEntry) ? "{$startBatchEntry}-{$endBatchEntry}" : 'ALL';
        $filename = "GL_Journal_Export_{$batchId}_{$rangeInfo}_" . date('Ymd_His') . '.xlsx';

        if (ob_get_length()) ob_end_clean();

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }

    /**
     * Format number for export
     * 
     * @param mixed $number
     * @param int $decimals
     * @return string
     */
    private function formatNumberForExport($number, $decimals = 3)
    {
        $number = floatval($number);
        $formatted = number_format($number, $decimals, '.', '');

        if ($number < 0) {
            return $formatted;
        }

        return $formatted;
    }

    /**
     * Format date for export
     * 
     * @param string $dateString
     * @return string
     */
    private function formatDateForExport($dateString)
    {
        if (empty($dateString)) {
            return date('Y-m-d');
        }

        if (strpos($dateString, 'T') !== false) {
            $dateString = explode('T', $dateString)[0];
        }

        if (strpos($dateString, ' ') !== false) {
            $dateString = explode(' ', $dateString)[0];
        }

        $timestamp = strtotime($dateString);
        if ($timestamp === false) {
            return date('Y-m-d');
        }

        return date('Y-m-d', $timestamp);
    }

    /**
     * Apply proper number formatting to spreadsheet
     * 
     * @param \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $headerSheet
     * @param \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $detailSheet
     * @return void
     */
    private function applyProperNumberFormatting($headerSheet, $detailSheet)
    {
        $lastHeaderRow = $headerSheet->getHighestRow();

        if ($lastHeaderRow > 1) {
            $headerSheet->getStyle('F2:F' . $lastHeaderRow)
                ->getNumberFormat()
                ->setFormatCode('0');

            $headerSheet->getStyle('G2:G' . $lastHeaderRow)
                ->getNumberFormat()
                ->setFormatCode('0');
        }

        $detailNumberColumns = [
            'G' => '#,##0.000',
            'I' => '#,##0.000',
            'J' => '#,##0.000000'
        ];

        $lastDetailRow = $detailSheet->getHighestRow();

        foreach ($detailNumberColumns as $col => $format) {
            if ($lastDetailRow > 1) {
                $range = $col . '2:' . $col . $lastDetailRow;
                $detailSheet->getStyle($range)
                    ->getNumberFormat()
                    ->setFormatCode($format);
            }
        }

        if ($lastDetailRow > 1) {
            $range = 'C2:C' . $lastDetailRow;
            $detailSheet->getStyle($range)
                ->getNumberFormat()
                ->setFormatCode('0');
        }
    }

    // ====================================================================================
    // SECTION: IMPORT OPERATIONS - PREVIEW
    // ====================================================================================

    /**
     * 
     * @param string $batchId
     * @return int
     */
    private function getLastBatchEntry($batchId)
    {
        helper(['restclient']);

        $url = "{$this->server3}/api/tmstgljournal/getlastbatchentry/{$batchId}";
        $response = akses_restapikey('GET', $url, [], []);
        $result = is_string($response) ? json_decode($response, true) : $response;

        $lastBatchEntry = 0;

        if (isset($result['success']) && $result['success'] === true) {
            if (isset($result['data']['batchEntry']) && $result['data']['batchEntry'] !== null) {
                $lastBatchEntry = intval($result['data']['batchEntry']);
            } else {
                $lastBatchEntry = 0;
            }
        } else {
            $lastBatchEntry = 0;
        }

        return $lastBatchEntry;
    }

    /**
     * 
     * @param string $batchId
     * @return string
     */
    private function generateNextBatchEntry($batchId)
    {
        $lastBatchEntry = $this->getLastBatchEntry($batchId);
        $nextBatchEntry = $lastBatchEntry + 1;

        // Format to 7 digits
        return str_pad($nextBatchEntry, 7, '0', STR_PAD_LEFT);
    }

    /**
     * Preview data from Excel/CSV file
     * 
     * @return \CodeIgniter\HTTP\Response
     */
    public function preview()
    {
        if (!$this->request->getFile('filename')) {
            return $this->response->setJSON(['error' => 'File tidak ditemukan']);
        }

        $file = $this->request->getFile('filename');

        if (!$file->isValid()) {
            return $this->response->setJSON(['error' => $file->getErrorString()]);
        }

        $extension = $file->getClientExtension();

        if ($extension == 'csv') {
            $reader = new Csv();
        } else {
            $reader = new Excel();
        }

        try {
            $spreadsheet = $reader->load($file->getTempName());

            $headerData = [];
            $detailData = [];

            if ($spreadsheet->sheetNameExists('Journal Header')) {
                $headerSheet = $spreadsheet->getSheetByName('Journal Header');
                $headerData = $headerSheet->toArray();
            }

            if ($spreadsheet->sheetNameExists('Journal Detail')) {
                $detailSheet = $spreadsheet->getSheetByName('Journal Detail');
                $detailData = $detailSheet->toArray();
            }

            $tempPath = WRITEPATH . 'uploads/temp_import_' . session()->get('usr_id') . '.xlsx';
            $file->move(WRITEPATH . 'uploads/', 'temp_import_' . session()->get('usr_id') . '.xlsx');

            $previewData = [
                'header' => $this->formatHeaderPreviewMultiple($headerData),
                'detail' => $this->formatDetailPreview($detailData)
            ];

            return $this->response->setJSON([
                'success' => true,
                'preview' => $previewData
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'error' => 'Error membaca file: ' . $e->getMessage()
            ]);
        }
    }

    // ====================================================================================
    // SECTION: IMPORT OPERATIONS - TEMPLATE DOWNLOAD
    // ====================================================================================

    /**
     * Download Excel template
     * 
     * @return void
     */
    public function download()
    {
        $spreadsheet = new Spreadsheet();

        $headerSheet = $spreadsheet->getActiveSheet();
        $headerSheet->setTitle('Journal Header');

        $headerColumns = [
            'BatchId',
            'BatchEntry',
            'JrnlDesc',
            'SrceLedger',
            'SrceType',
            'FscsYr',
            'FscsPerd',
            'DateEntry',
            'PostDate'
        ];
        $headerSheet->fromArray($headerColumns, NULL, 'A1');

        foreach (range('A', 'I') as $col) {
            $headerSheet->getStyle($col . '2:' . $col . '1000')
                ->getNumberFormat()
                ->setFormatCode(NumberFormat::FORMAT_TEXT);
        }

        $headerStyle = [
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['rgb' => 'E6E6FA']
            ]
        ];
        $headerSheet->getStyle('A1:I1')->applyFromArray($headerStyle);

        foreach (range('A', 'I') as $col) {
            $headerSheet->getColumnDimension($col)->setAutoSize(true);
        }

        $detailSheet = $spreadsheet->createSheet();
        $detailSheet->setTitle('Journal Detail');

        $detailColumns = [
            'BatchId',
            'BatchEntry',
            'AcctId',
            'AcctName',
            'ScurnCode',
            'ScurnAmt',
            'HcurnCode',
            'TransAmt',
            'ConvRate',
            'TransDesc',
            'TransRef',
            'Comment'
        ];
        $detailSheet->fromArray($detailColumns, NULL, 'A1');

        $detailSheet->getStyle('F2:F1000')->getNumberFormat()->setFormatCode('0.000');
        $detailSheet->getStyle('H2:H1000')->getNumberFormat()->setFormatCode('0.000');
        $detailSheet->getStyle('I2:I1000')->getNumberFormat()->setFormatCode('0.000000');

        $detailSheet->getStyle('A1:L1')->applyFromArray($headerStyle);

        foreach (range('A', 'L') as $col) {
            $detailSheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'GL_Journal_Template.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    /**
     * Clear temporary files
     * 
     * @return \CodeIgniter\HTTP\Response
     */
    public function clearTempFile()
    {
        try {
            $this->cleanupTempFile();
            return $this->response->setJSON([
                'success' => true,
                'message' => 'File temp telah dibersihkan'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal membersihkan file temp: ' . $e->getMessage()
            ]);
        }
    }

    // ====================================================================================
    // SECTION: IMPORT OPERATIONS - MAIN PROCESS
    // ====================================================================================

    /**
     * Process file upload/import
     * 
     * @param string $action
     * @return \CodeIgniter\HTTP\Response
     */
    public function processFile($action = 'upload')
    {
        set_time_limit(300);
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '512M');

        try {
            $batchId = $this->request->getPost('batchId');

            if (!$batchId) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Batch ID harus dipilih'
                ]);
            }

            $filePath = $this->handleFileUpload();
            if (!$filePath) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'File tidak ditemukan, silakan upload ulang'
                ]);
            }

            $spreadsheet = $this->loadSpreadsheet($filePath);

            if ($action === 'previewAndValidate') {
                return $this->processPreviewAndValidate($batchId, $spreadsheet);
            } else {
                // Use API /import for upload
                return $this->processImportUsingAPI($batchId, $spreadsheet);
            }
        } catch (\Exception $e) {
            $this->cleanupTempFile();
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Process import using API
     * 
     * @param string $batchId
     * @param \PhpOffice\PhpSpreadsheet\Spreadsheet $spreadsheet
     * @return \CodeIgniter\HTTP\Response
     */
    private function processImportUsingAPI($batchId, $spreadsheet)
    {
        $this->cleanupTempFile();

        try {
            $importData = $this->parseImportDataFromSpreadsheet($batchId, $spreadsheet);

            if (empty($importData['Headers']) || empty($importData['Details'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Data tidak valid atau kosong'
                ]);
            }

            $payload = [
                'Headers' => $importData['Headers'],
                'Details' => $importData['Details'],
                'IsChunked' => false
            ];

            helper(['restclient']);
            $url = "{$this->server3}/api/tmstgljournal/import";
            $response = akses_restapikey('POST', $url, $payload, [], 300);

            $result = is_string($response) ? json_decode($response, true) : $response;

            if (isset($result['success'])) {
                if ($result['success'] === true || $result['success'] == 1) {
                    // Import sukses
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => $result['message'] ?? 'Import berhasil',
                        'stats' => [
                            'headers_imported' => $result['headerCount'] ?? count($importData['Headers']),
                            'details_imported' => $result['detailCount'] ?? count($importData['Details']),
                            'processed_rows' => $result['processedRows'] ?? 0
                        ]
                    ]);
                } else {
                    // Validasi gagal - format errors dari SP
                    return $this->formatValidationErrors($result);
                }
            }

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Response tidak valid dari API'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    private function formatValidationErrors($result)
    {
        $errors = [];
        $headerErrors = [];
        $detailErrors = [];
        $errorsByBatch = [];

        // Ambil message dari response
        $message = $result['message'] ?? 'Validasi gagal';

        // Cek apakah ada errors dari SP
        if (isset($result['errors'])) {
            $errorData = $result['errors'];

            // Jika errors adalah string (JSON), parse
            if (is_string($errorData)) {
                $parsedErrors = json_decode($errorData, true);
                if (is_array($parsedErrors)) {
                    foreach ($parsedErrors as $err) {
                        if (is_array($err)) {
                            $errorMessage = $err['ErrorMessage'] ?? '';
                            $errorType = $err['ErrorType'] ?? '';
                            $batchEntry = $err['BatchEntry'] ?? 'Unknown';

                            if (!empty($errorMessage)) {
                                $errors[] = $errorMessage;

                                if ($errorType == 'HEADER') {
                                    $headerErrors[] = $errorMessage;
                                } else if ($errorType == 'DETAIL') {
                                    $detailErrors[] = $errorMessage;
                                }

                                // Group by batch entry
                                if (!isset($errorsByBatch[$batchEntry])) {
                                    $errorsByBatch[$batchEntry] = [];
                                }
                                $errorsByBatch[$batchEntry][] = $errorMessage;
                            }
                        } else if (is_string($err)) {
                            $errors[] = $err;
                        }
                    }
                } else {
                    // Jika bukan array, tambahkan sebagai string
                    $errors[] = $errorData;
                }
            }
            // Jika errors sudah array
            else if (is_array($errorData)) {
                foreach ($errorData as $err) {
                    if (is_array($err)) {
                        $errorMessage = $err['ErrorMessage'] ?? '';
                        $errorType = $err['ErrorType'] ?? '';
                        $batchEntry = $err['BatchEntry'] ?? 'Unknown';

                        if (!empty($errorMessage)) {
                            $errors[] = $errorMessage;

                            if ($errorType == 'HEADER') {
                                $headerErrors[] = $errorMessage;
                            } else if ($errorType == 'DETAIL') {
                                $detailErrors[] = $errorMessage;
                            }

                            // Group by batch entry
                            if (!isset($errorsByBatch[$batchEntry])) {
                                $errorsByBatch[$batchEntry] = [];
                            }
                            $errorsByBatch[$batchEntry][] = $errorMessage;
                        }
                    } else if (is_string($err)) {
                        $errors[] = $err;
                    }
                }
            }
        }

        // Cek validation_details jika ada
        if (isset($result['validation_details'])) {
            $details = $result['validation_details'];

            if (isset($details['header_errors']) && is_array($details['header_errors'])) {
                $headerErrors = array_merge($headerErrors, $details['header_errors']);
            }

            if (isset($details['detail_errors']) && is_array($details['detail_errors'])) {
                $detailErrors = array_merge($detailErrors, $details['detail_errors']);
            }

            if (isset($details['errors_by_batch']) && is_array($details['errors_by_batch'])) {
                $errorsByBatch = array_merge($errorsByBatch, $details['errors_by_batch']);
            }
        }

        // Jika tidak ada errors terstruktur, gunakan message saja
        if (empty($errors)) {
            $errors[] = $message;
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
            'validation_details' => [
                'header_errors' => $headerErrors,
                'detail_errors' => $detailErrors,
                'errors_by_batch' => $errorsByBatch
            ]
        ]);
    }

    /**
     * Parse import data from spreadsheet
     * 
     * @param string $batchId
     * @param \PhpOffice\PhpSpreadsheet\Spreadsheet $spreadsheet
     * @return array
     */
    private function parseImportDataFromSpreadsheet($batchId, $spreadsheet)
    {
        $headers = [];
        $details = [];
        $userId = session()->get('usr_id');
        $currentDate = date('Y-m-d');
        $currentTime = date('H:i:s');

        $startingBatchEntry = $this->getLastBatchEntry($batchId) + 1;
        $batchEntryCounter = 1;
        $batchEntryMapping = [];

        if ($spreadsheet->sheetNameExists('Journal Header')) {
            $headerSheet = $spreadsheet->getSheetByName('Journal Header');
            $headerData = $headerSheet->toArray();

            if (count($headerData) > 1) {
                $headerColumns = $headerData[0];

                for ($rowIndex = 1; $rowIndex < count($headerData); $rowIndex++) {
                    $rowData = $headerData[$rowIndex];

                    if ($this->isHeaderRowEmpty($rowData)) {
                        continue;
                    }

                    $rowMap = [];
                    foreach ($headerColumns as $colIndex => $colName) {
                        $rowMap[$colName] = $rowData[$colIndex] ?? '';
                    }

                    $excelBatchEntry = trim($rowMap['BatchEntry']);

                    if (empty($excelBatchEntry)) {
                        continue;
                    }

                    $systemBatchEntry = str_pad($startingBatchEntry + $batchEntryCounter - 1, 7, '0', STR_PAD_LEFT);

                    $batchEntryMapping[$excelBatchEntry] = $systemBatchEntry;

                    $header = [
                        'BatchId' => $batchId,
                        'BatchEntry' => $systemBatchEntry,
                        'AudtDate' => $currentDate,
                        'AudtTime' => $currentTime,
                        'AudtUser' => $userId,
                        'SrceLedger' => trim($rowMap['SrceLedger']),
                        'SrceType' => trim($rowMap['SrceType']),
                        'FscsYr' => trim($rowMap['FscsYr']),
                        'FscsPerd' => trim($rowMap['FscsPerd']),
                        'JrnlDesc' => trim($rowMap['JrnlDesc']),
                        'JrnlDr' => 0,
                        'JrnlCr' => 0,
                        'DateEntry' => $this->convertDateImport($rowMap['DateEntry'] ?? $currentDate),
                        'DrilSrcTy' => 0,
                        'DrillDwnLk' => '',
                        'DrilApp' => trim($rowMap['SrceLedger']),
                        'ErrEntry' => 0,
                        'DetailCnt' => 0,
                        'PostDate' => $this->convertDateImport($rowMap['PostDate'] ?? $currentDate)
                    ];

                    $headers[] = $header;
                    $batchEntryCounter++;
                }
            }
        }

        if ($spreadsheet->sheetNameExists('Journal Detail')) {
            $detailSheet = $spreadsheet->getSheetByName('Journal Detail');
            $detailData = $detailSheet->toArray();

            if (count($detailData) > 1) {
                $detailColumns = $detailData[0];
                $transNbrCounters = [];

                for ($rowIndex = 1; $rowIndex < count($detailData); $rowIndex++) {
                    $rowData = $detailData[$rowIndex];

                    if ($this->isDetailRowEmpty($rowData, $detailColumns)) {
                        continue;
                    }

                    $rowMap = [];
                    foreach ($detailColumns as $colIndex => $colName) {
                        $rowMap[$colName] = $rowData[$colIndex] ?? '';
                    }

                    $excelBatchEntry = trim($rowMap['BatchEntry']);
                    if (empty($excelBatchEntry)) {
                        continue;
                    }

                    $systemBatchEntry = null;

                    if (isset($batchEntryMapping[$excelBatchEntry])) {
                        $systemBatchEntry = $batchEntryMapping[$excelBatchEntry];
                    } else {
                        $excelEntryNum = intval($excelBatchEntry);
                        if ($excelEntryNum > 0 && $excelEntryNum <= count($headers)) {
                            $systemBatchEntry = $headers[$excelEntryNum - 1]['BatchEntry'] ?? null;
                        }
                    }

                    if (!$systemBatchEntry) {
                        continue;
                    }

                    if (!isset($transNbrCounters[$systemBatchEntry])) {
                        $transNbrCounters[$systemBatchEntry] = 1;
                    }

                    $scurnAmt = $this->parseNumber($rowMap['ScurnAmt']);
                    $transAmt = $this->parseNumber($rowMap['TransAmt']);
                    $convRate = $this->parseNumber($rowMap['ConvRate']);

                    if ($transAmt == 0 && $scurnAmt != 0) {
                        $transAmt = $scurnAmt;
                    }

                    $currentTransNbr = $transNbrCounters[$systemBatchEntry];

                    $detail = [
                        'BatchNbr' => $batchId,
                        'JournalId' => $systemBatchEntry,
                        'TransNbr' => (string) $currentTransNbr,
                        'AudtDate' => $currentDate,
                        'AudtTime' => $currentTime,
                        'AudtUser' => $userId,
                        'AcctId' => trim($rowMap['AcctId']),
                        'AcctName' => trim($rowMap['AcctName'] ?? ''),
                        'ScurnCode' => trim($rowMap['ScurnCode'] ?? 'IDR'),
                        'ScurnAmt' => $scurnAmt,
                        'HcurnCode' => trim($rowMap['HcurnCode'] ?? $rowMap['ScurnCode'] ?? 'IDR'),
                        'TransAmt' => $transAmt,
                        'RateDate' => $currentDate,
                        'ConvRate' => $convRate > 0 ? $convRate : 1,
                        'TransDesc' => trim($rowMap['TransDesc'] ?? ''),
                        'TransRef' => trim($rowMap['TransRef'] ?? ''),
                        'Comment' => trim($rowMap['Comment'] ?? '')
                    ];

                    $details[] = $detail;

                    $transNbrCounters[$systemBatchEntry]++;
                }
            }
        }

        return [
            'Headers' => $headers,
            'Details' => $details,
            'StartingBatchEntry' => $startingBatchEntry
        ];
    }

    /**
     * Check if detail row is empty
     * 
     * @param array $rowData
     * @param array $headers
     * @return bool
     */
    private function isDetailRowEmpty($rowData, $headers)
    {
        if (!is_array($rowData) || empty($rowData)) {
            return true;
        }

        $requiredFields = ['BatchEntry', 'AcctId', 'AcctName'];
        $hasRequiredData = false;

        foreach ($headers as $index => $headerName) {
            if (in_array($headerName, $requiredFields)) {
                $cellValue = $rowData[$index] ?? '';
                if (!empty(trim($cellValue))) {
                    $hasRequiredData = true;
                    break;
                }
            }
        }

        return !$hasRequiredData;
    }

    // ====================================================================================
    // SECTION: IMPORT OPERATIONS - ALIAS FUNCTIONS
    // ====================================================================================

    /**
     * Alias for processFile('upload')
     * 
     * @return \CodeIgniter\HTTP\Response
     */
    public function upload()
    {
        return $this->processFile('upload');
    }

    /**
     * Alias for processFile('previewAndValidate')
     * 
     * @return \CodeIgniter\HTTP\Response
     */
    public function previewAndValidate()
    {
        return $this->processFile('previewAndValidate');
    }

    // ====================================================================================
    // SECTION: IMPORT OPERATIONS - UTILITY METHODS
    // ====================================================================================

    /**
     * Clear batch entry (legacy function)
     * 
     * @return \CodeIgniter\HTTP\Response
     */
    public function clearBatchEntry()
    {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Fungsi clear batch entry sudah tidak tersedia'
        ]);
    }

    // ====================================================================================
    // SECTION: IMPORT OPERATIONS - PRIVATE HELPER METHODS
    // ====================================================================================

    /**
     * Handle file upload
     * 
     * @return string|null
     * @throws \Exception
     */
    private function handleFileUpload()
    {
        if ($file = $this->request->getFile('filename')) {
            if (!$file->isValid()) {
                throw new \Exception($file->getErrorString());
            }
            return $this->saveTempFile($file);
        }

        return $this->getTempFile();
    }

    /**
     * Load spreadsheet from file
     * 
     * @param string $filePath
     * @return \PhpOffice\PhpSpreadsheet\Spreadsheet
     */
    private function loadSpreadsheet($filePath)
    {
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $reader = ($extension == 'csv') ? new Csv() : new Excel();
        return $reader->load($filePath);
    }

    /**
     * Generate preview data from spreadsheet
     * 
     * @param \PhpOffice\PhpSpreadsheet\Spreadsheet $spreadsheet
     * @return array
     */
    private function generatePreviewData($spreadsheet)
    {
        $headerData = [];
        $detailData = [];

        if ($spreadsheet->sheetNameExists('Journal Header')) {
            $headerSheet = $spreadsheet->getSheetByName('Journal Header');
            $headerData = $headerSheet->toArray();
        }

        if ($spreadsheet->sheetNameExists('Journal Detail')) {
            $detailSheet = $spreadsheet->getSheetByName('Journal Detail');
            $detailData = $detailSheet->toArray();
        }

        return [
            'header' => $this->formatHeaderPreviewMultiple($headerData),
            'detail' => $this->formatDetailPreview($detailData)
        ];
    }

    /**
     * Process preview and validation
     * 
     * @param string $batchId
     * @param \PhpOffice\PhpSpreadsheet\Spreadsheet $spreadsheet
     * @return \CodeIgniter\HTTP\Response
     */
    private function processPreviewAndValidate($batchId, $spreadsheet)
    {
        $previewData = $this->generatePreviewData($spreadsheet);

        return $this->response->setJSON([
            'success' => true,
            'preview' => $previewData,
            'validation_results' => [
                'header_errors' => [],
                'detail_errors' => []
            ]
        ]);
    }

    /**
     * Save temporary file
     * 
     * @param \CodeIgniter\HTTP\Files\UploadedFile $file
     * @return string
     */
    private function saveTempFile($file)
    {
        $tempDir = WRITEPATH . 'uploads/temp/';

        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        $userId = session()->get('usr_id');
        $tempFilename = 'import_' . $userId . '_' . time() . '.' . $file->getClientExtension();
        $tempFilePath = $tempDir . $tempFilename;

        $file->move($tempDir, $tempFilename);

        session()->set('temp_import_file', [
            'filename' => $tempFilename,
            'path' => $tempFilePath,
            'original_name' => $file->getClientName(),
            'timestamp' => time()
        ]);

        return $tempFilePath;
    }

    /**
     * Clean up temporary files
     * 
     * @return void
     */
    private function cleanupTempFile()
    {
        $tempFile = session()->get('temp_import_file');

        if ($tempFile && isset($tempFile['path']) && file_exists($tempFile['path'])) {
            unlink($tempFile['path']);
        }

        session()->remove('temp_import_file');
    }

    /**
     * Get temporary file path
     * 
     * @return string|null
     */
    private function getTempFile()
    {
        $tempFile = session()->get('temp_import_file');

        if (!$tempFile || !isset($tempFile['path']) || !file_exists($tempFile['path'])) {
            return null;
        }

        if (time() - $tempFile['timestamp'] > 3600) {
            $this->cleanupTempFile();
            return null;
        }

        return $tempFile['path'];
    }

    // ====================================================================================
    // SECTION: FORMATTING AND VALIDATION HELPERS
    // ====================================================================================

    /**
     * Format header preview for multiple rows
     * 
     * @param array $headerData
     * @return array
     */
    private function formatHeaderPreviewMultiple($headerData)
    {
        if (count($headerData) < 2) return [];

        $headers = $headerData[0];
        $formatted = [];

        for ($rowIndex = 1; $rowIndex < count($headerData); $rowIndex++) {
            $rowData = $headerData[$rowIndex];

            if ($this->isHeaderRowEmpty($rowData)) {
                continue;
            }

            $rowFormatted = [];
            for ($i = 0; $i < count($headers); $i++) {
                $field = $headers[$i];
                $value = $rowData[$i];

                if (in_array($field, [
                    'AudtDate',
                    'AudtTime',
                    'AudtUser',
                    'JrnlDr',
                    'JrnlCr',
                    'DrilSrcTy',
                    'DrillDwnLk',
                    'DrilApp',
                    'ErrEntry',
                    'DetailCnt'
                ])) {
                    continue;
                }

                if ($field === 'BatchEntry') {
                    $value = $value ?: 'Generated';
                }

                $rowFormatted[] = [
                    'field' => $field,
                    'value' => $value,
                    'row_index' => $rowIndex
                ];
            }

            $formatted[] = $rowFormatted;
        }

        return $formatted;
    }

    /**
     * Check if header row is empty
     * 
     * @param array $rowData
     * @return bool
     */
    private function isHeaderRowEmpty($rowData)
    {
        if (!is_array($rowData) || empty($rowData)) {
            return true;
        }

        $emptyCells = 0;
        foreach ($rowData as $cellValue) {
            if ($cellValue === null || $cellValue === '' || trim($cellValue) === '') {
                $emptyCells++;
            }
        }

        return $emptyCells === count($rowData);
    }

    /**
     * Parse number from string
     * 
     * @param mixed $value
     * @return float
     */
    private function parseNumber($value)
    {
        if (empty($value)) return 0;

        if (is_numeric($value)) {
            return floatval($value);
        }

        if (is_string($value)) {
            $cleaned = preg_replace('/[^\d.,-]/', '', $value);

            if (strpos($cleaned, ',') !== false && strpos($cleaned, '.') !== false) {
                $cleaned = str_replace(',', '', $cleaned);
            } elseif (strpos($cleaned, ',') !== false && strpos($cleaned, '.') === false) {
                $cleaned = str_replace('.', '', $cleaned);
                $cleaned = str_replace(',', '.', $cleaned);
            }

            $result = floatval($cleaned);

            return $result;
        }

        return floatval($value);
    }

    /**
     * Format detail preview
     * 
     * @param array $detailData
     * @param int|null $limit
     * @return array
     */
    private function formatDetailPreview($detailData, $limit = null)
    {
        if (count($detailData) < 2) return [];

        $headers = $detailData[0];
        $previewData = [];

        $maxRow = count($detailData) - 1;

        for ($row = 1; $row <= $maxRow; $row++) {
            $rowData = $detailData[$row];

            if ($this->isDetailRowEmpty($rowData, $headers)) {
                continue;
            }

            $formattedRow = [];
            for ($col = 0; $col < count($headers); $col++) {
                $value = $rowData[$col];
                $header = $headers[$col];

                if (in_array($header, ['AudtDate', 'AudtTime', 'AudtUser', 'RateDate', 'deleted'])) {
                    continue;
                }

                if ($header === 'ConvRate' && is_numeric($value)) {
                    $value = number_format($value, 6);
                }

                $formattedRow[$header] = $value;
            }

            $previewData[] = $formattedRow;
        }

        return $previewData;
    }

    /**
     * Convert date string to Y-m-d format for import
     * 
     * @param mixed $dateString
     * @return string
     */
    private function convertDateImport($dateString)
    {
        if (empty($dateString) || trim($dateString) === '') {
            return date('Y-m-d');
        }

        try {
            // If it's a number (Excel serial date)
            if (is_numeric($dateString)) {
                try {
                    $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($dateString);
                    return $date->format('Y-m-d');
                } catch (\Exception $e) {
                    // Fallback: assume it's a timestamp
                    return date('Y-m-d', $dateString);
                }
            }

            // If already in Y-m-d format
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateString)) {
                return $dateString;
            }

            // Try to parse common date formats
            $formats = [
                'd/m/Y',
                'd-m-Y',
                'd.m.Y',
                'Y/m/d',
                'Y-m-d',
                'Y.m.d',
                'm/d/Y',
                'm-d-Y',
                'm.d.Y',
                'd M Y',
                'd F Y',
                'j M Y',
                'j F Y'
            ];

            foreach ($formats as $format) {
                $date = \DateTime::createFromFormat($format, $dateString);
                if ($date !== false) {
                    return $date->format('Y-m-d');
                }
            }

            // Try with strtotime as fallback
            $timestamp = strtotime($dateString);
            if ($timestamp !== false) {
                return date('Y-m-d', $timestamp);
            }
        } catch (\Exception $e) {
            // Log error if needed
            log_message('error', 'Date conversion error: ' . $e->getMessage() . ' - Input: ' . $dateString);
        }

        // Default to today's date if all parsing fails
        return date('Y-m-d');
    }
}
