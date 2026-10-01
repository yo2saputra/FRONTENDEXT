<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as excel;

class Tmstobatbaru extends BaseController
{
    protected $data;
    protected $server3;
    protected $server5;

    public function __construct()
    {
        $this->server3 = $_ENV['APP_API3'] ?? '';
        $this->server5 = $_ENV['APP_API5'] ?? '';
    }

    public function index()
    {
        return view('tmstobatbaru/index', $this->data);
    }

    public function getKategoriDropdown()
    {
        helper(['restclient']);
        $url      = "{$this->server5}/api/Dropdown/item-categories";
        $response = akses_restapikey('GET', $url, [], []);
        $result   = json_decode($response, true);
        $rows = $result['data'] ?? $result ?? [];
        $list = [];
        foreach ($rows as $row) {
            $list[] = ['id' => $row['value'] ?? '', 'text' => $row['desc'] ?? ''];
        }
        return $this->response->setJSON(['status' => 'success', 'data' => $list]);
    }

    public function getGroupDropdown()
    {
        helper(['restclient']);
        $url      = "{$this->server5}/api/Dropdown/item-groups";
        $response = akses_restapikey('GET', $url, [], []);
        $result   = json_decode($response, true);
        $rows = $result['data'] ?? $result ?? [];
        $list = [];
        foreach ($rows as $row) {
            $list[] = ['id' => $row['value'] ?? '', 'text' => $row['desc'] ?? ''];
        }
        return $this->response->setJSON(['status' => 'success', 'data' => $list]);
    }

    public function getSubGroupDropdown()
    {
        helper(['restclient']);
        $groupId  = $this->request->getVar('groupId') ?? '';
        $url      = "{$this->server5}/api/Dropdown/item-subgroups" . ($groupId ? "?groupId={$groupId}" : '');
        $response = akses_restapikey('GET', $url, [], []);
        $result   = json_decode($response, true);
        $rows = $result['data'] ?? $result ?? [];
        $list = [];
        foreach ($rows as $row) {
            $list[] = ['id' => $row['value'] ?? '', 'text' => $row['desc'] ?? ''];
        }
        return $this->response->setJSON(['status' => 'success', 'data' => $list]);
    }

    public function getSatuanDropdown()
    {
        helper(['restclient']);
        $url      = "{$this->server5}/api/Dropdown/uoms";
        $response = akses_restapikey('GET', $url, [], []);
        $result   = json_decode($response, true);
        $rows = $result['data'] ?? $result ?? [];
        $list = [];
        foreach ($rows as $row) {
            $list[] = ['id' => $row['value'] ?? '', 'text' => $row['desc'] ?? ''];
        }
        return $this->response->setJSON(['status' => 'success', 'data' => $list]);
    }

    public function getKelasHargaDropdown()
    {
        helper(['restclient']);
        $url      = "{$this->server5}/api/Dropdown/price-classes";
        $response = akses_restapikey('GET', $url, [], []);
        $result   = json_decode($response, true);
        $rows = $result['data'] ?? $result ?? [];
        $list = [];
        foreach ($rows as $row) {
            $list[] = ['id' => $row['value'] ?? '', 'text' => $row['desc'] ?? ''];
        }
        return $this->response->setJSON(['status' => 'success', 'data' => $list]);
    }

    public function getSupplierDropdown()
    {
        helper(['restclient']);
        $url      = "{$this->server5}/api/Dropdown/supplier";
        $response = akses_restapikey('GET', $url, [], []);
        $result   = json_decode($response, true);
        $rows = $result['data'] ?? $result ?? [];
        $list = [];
        foreach ($rows as $row) {
            $list[] = ['id' => $row['value'] ?? '', 'text' => $row['desc'] ?? ''];
        }
        return $this->response->setJSON(['status' => 'success', 'data' => $list]);
    }

    public function getPrincipalDropdown()
    {
        helper(['restclient']);
        $url      = "{$this->server5}/api/Dropdown/principals";
        $response = akses_restapikey('GET', $url, [], []);
        $result   = json_decode($response, true);
        $rows = $result['data'] ?? $result ?? [];
        $list = [];
        foreach ($rows as $row) {
            $list[] = ['id' => $row['value'] ?? '', 'text' => $row['desc'] ?? ''];
        }
        return $this->response->setJSON(['status' => 'success', 'data' => $list]);
    }

    public function getDosageFormDropdown()
    {
        helper(['restclient']);
        $url      = "{$this->server5}/api/Dropdown/dosage-forms";
        $response = akses_restapikey('GET', $url, [], []);
        $result   = json_decode($response, true);
        $rows = $result['data'] ?? $result ?? [];
        $list = [];
        foreach ($rows as $row) {
            $list[] = ['id' => $row['value'] ?? '', 'text' => $row['desc'] ?? ''];
        }
        return $this->response->setJSON(['status' => 'success', 'data' => $list]);
    }

    public function getFixedEnums()
    {
        return $this->response->setJSON([
            'status' => 'success',
            'route' => [
                ['id' => 'Oral', 'text' => 'Oral'],
                ['id' => 'Topikal', 'text' => 'Topikal'],
                ['id' => 'Injeksi', 'text' => 'Injeksi'],
                ['id' => 'Rektal', 'text' => 'Rektal'],
            ],
            'regulationClass' => [
                ['id' => 'OBAT_BEBAS', 'text' => 'Obat Bebas'],
                ['id' => 'OBAT_BEBAS_TERBATAS', 'text' => 'Obat Bebas Terbatas'],
                ['id' => 'OBAT_KERAS', 'text' => 'Obat Keras'],
                ['id' => 'PSIKOTROPIKA', 'text' => 'Psikotropika'],
                ['id' => 'NARKOTIKA', 'text' => 'Narkotika'],
            ],
        ]);
    }

    public function datatables()
    {
        helper(['restclient']);
        $rawBody = $this->request->getBody();
        $json    = json_decode($rawBody, true) ?? [];

        $requestPayload = [
            'draw'      => $json['draw']   ?? 1,
            'start'     => $json['start']  ?? 0,
            'length'    => $json['length'] ?? 10,
            'search'    => [
                'value' => $json['cari'] ?? '',
                'regex' => false,
            ],
            'columns'   => $json['columns'] ?? [],
            'order'     => $json['order']   ?? [],
            'itemType'  => 'DRUG',
            'cari'      => $json['cari'] ?? '',
        ];

        if (!empty($json['status'])) {
            $requestPayload['status'] = $json['status'];
        }
        if (!empty($json['kategori'])) {
            $requestPayload['kategori'] = $json['kategori'];
        }
        if (!empty($json['group'])) {
            $requestPayload['group'] = $json['group'];
        }
        if (!empty($json['bentuk'])) {
            $requestPayload['bentuk'] = $json['bentuk'];
        }
        if (!empty($json['resep'])) {
            $requestPayload['resep'] = $json['resep'];
        }
        if (!empty($json['batch'])) {
            $requestPayload['batch'] = $json['batch'];
        }
        if (!empty($json['expired'])) {
            $requestPayload['expired'] = $json['expired'];
        }

        $url      = "{$this->server5}/api/Items/datatable";
        $response = akses_restapikey('POST', $url, $requestPayload, []);
        $result   = json_decode($response, true);

        if (!isset($result['data']) || !is_array($result['data'])) {
            log_message('error', 'Items(Obat) Datatables invalid response: ' . $response);
            return $this->response->setJSON([
                'draw'            => $json['draw'] ?? 1,
                'recordsTotal'    => 0,
                'recordsFiltered' => 0,
                'data'            => []
            ]);
        }

        foreach ($result['data'] as $i => &$row) {
            $id            = $row['itemId'];
            $code          = $row['itemCode'];
            $row['rownum'] = $i + ($json['start'] ?? 0) + 1;

            $row['checkbox'] = '<div class="icheck-primary d-inline"><input type="checkbox" id="chk_' . $id . '" class="row-chk"><label for="chk_' . $id . '"></label></div>';
            $row['kodeLink'] = '<a href="#" class="kode-link" data-id="' . $id . '" data-code="' . $code . '">' . $code . '</a>';
            $row['nama']     = $row['itemName'] ?? '-';
            $row['generic']  = $row['genericName'] ?? '-';
            $row['bentuk']   = $row['dosageForm'] ?? '-';
            $row['strength'] = $row['strength'] ?? '-';

            $row['resep_badge'] = !empty($row['isPrescriptionRequired'])
                ? '<span class="badge" style="background:#e6f4ea; color:#0f5132;">Ya</span>'
                : '<span class="badge" style="background:#f8f9fa; color:#6c757d;">Tidak</span>';

            $row['statusBadge'] = !empty($row['isActive'])
                ? '<span class="badge-ob-aktif">Aktif</span>'
                : '<span class="badge-ob-nonaktif">Non Aktif</span>';

            $row['stok'] = $row['totalStock'] ?? '-';
            $row['expired_badge'] = isset($row['expiringBatchCount']) && $row['expiringBatchCount'] > 0
                ? '<span class="badge" style="background:#fff3cd; color:#856404;">' . $row['expiringBatchCount'] . ' item</span>'
                : '<span class="badge" style="background:#e6f4ea; color:#0f5132;">0</span>';

            $row['aksi'] = '
            <div class="aksi-cell">
                <button type="button" class="btn-icon-ob view '   . ($this->session->get('flag_view')   === 1 ? '' : 'd-none') . '" data-id="' . $id . '" data-code="' . $code . '" title="Lihat"><i class="fas fa-eye"></i></button>
                <button type="button" class="btn-icon-ob edit '   . ($this->session->get('flag_update') === 1 ? '' : 'd-none') . '" data-id="' . $id . '" data-code="' . $code . '" title="Edit"><i class="fas fa-pencil-alt"></i></button>
                <button type="button" class="btn-icon-ob delete ' . ($this->session->get('flag_delete') === 1 ? '' : 'd-none') . '" data-id="' . $id . '" data-code="' . $code . '" title="Hapus"><i class="fas fa-trash-alt"></i></button>
            </div>';
        }

        $result['draw'] = (int) ($json['draw'] ?? 1);
        return $this->response->setJSON($result);
    }

    public function fetchSingleData()
    {
        if ($this->request->isAJAX()) {
            $itemCode = $this->request->getVar('itemCode');

            if ($itemCode) {
                helper(['restclient']);
                $url = "{$this->server5}/api/Items/{$itemCode}";

                try {
                    $response = akses_restapikey('GET', $url, [], []);
                    $data     = json_decode($response, true);

                    if (!isset($data['data']) || empty($data['data'])) {
                        return $this->response->setJSON([
                            'status'  => 'error',
                            'message' => 'Data tidak ditemukan atau format response salah'
                        ]);
                    }

                    $d = isset($data['data'][0]) ? $data['data'][0] : $data['data'];

                    return $this->response->setJSON([
                        'status' => 'success',
                        'data'   => [
                            'itemId'                 => $d['itemId']                 ?? '',
                            'itemCode'                => $d['itemCode']                ?? '',
                            'itemName'                => $d['itemName']                ?? '',
                            'itemCategoryId'          => $d['itemCategoryId']          ?? '',
                            'categoryName'            => $d['categoryName']            ?? '',
                            'itemGroupId'             => $d['itemGroupId']             ?? '',
                            'groupName'               => $d['groupName']               ?? '',
                            'itemSubGroupId'          => $d['itemSubGroupId']          ?? '',
                            'subGroupName'            => $d['subGroupName']            ?? '',
                            'itemType'                => $d['itemType']                ?? 'DRUG',
                            'baseUomId'               => $d['baseUomId']               ?? '',
                            'uomCode'                 => $d['uomCode']                 ?? '',
                            'uomName'                 => $d['uomName']                 ?? '',
                            'barcode'                 => $d['barcode']                 ?? '',
                            'isStockItem'             => $d['isStockItem']             ?? true,
                            'isSaleItem'              => $d['isSaleItem']              ?? true,
                            'isPurchaseItem'          => $d['isPurchaseItem']          ?? true,
                            'isBatchTracked'          => $d['isBatchTracked']          ?? true,
                            'isExpiredTracked'        => $d['isExpiredTracked']        ?? true,
                            'isPrescriptionRequired'  => $d['isPrescriptionRequired']  ?? false,
                            'isReturnableItem'        => $d['isReturnableItem']        ?? false,
                            'isControlledItem'        => $d['isControlledItem']        ?? false,
                            'isActive'                => $d['isActive']                ?? true,
                            'itemImageUrl'            => $d['itemImageUrl']            ?? '',
                            'createdDate'             => $d['createdDate']             ?? '',
                        ]
                    ]);
                } catch (\Exception $e) {
                    log_message('error', 'Exception in fetchSingleData Items(Obat): ' . $e->getMessage());
                    return $this->response->setJSON([
                        'status'  => 'error',
                        'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                    ]);
                }
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'itemCode tidak ditemukan']);
            }
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Request bukan AJAX']);
        }
    }

    public function action()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getVar('action')) {
                helper(['form', 'url', 'restclient']);

                $errors = [];
                if (empty(trim($this->request->getVar('inp_nama')))) {
                    $errors['inp_nama'] = 'Nama Obat harus diisi';
                }
                if (empty(trim($this->request->getVar('inp_base_uom_id') ?? ''))) {
                    $errors['inp_base_uom_id'] = 'Satuan Dasar harus dipilih';
                }

                if (!empty($errors)) {
                    return $this->response->setJSON(['error' => $errors]);
                }

                $empCd = $this->session->get('fullname') ?? '';

                $body = [
                    'itemName'                => trim($this->request->getVar('inp_nama')),
                    'itemCategoryId'          => null,
                    'itemGroupId'             => null,
                    'itemSubGroupId'          => null,
                    'itemType'                => 'DRUG',
                    'baseUomId'               => trim($this->request->getVar('inp_base_uom_id')),
                    'isStockItem'             => $this->request->getVar('chk_stock')     === '1',
                    'isSaleItem'              => $this->request->getVar('chk_sale')      === '1',
                    'isPurchaseItem'          => $this->request->getVar('chk_purchase')  === '1',
                    'isBatchTracked'          => $this->request->getVar('chk_batch')     === '1',
                    'isExpiredTracked'        => $this->request->getVar('chk_expired')   === '1',
                    'isPrescriptionRequired'  => $this->request->getVar('chk_resep')     === '1',
                    'isReturnableItem'        => $this->request->getVar('chk_returnable') === '1',
                    'isControlledItem'        => $this->request->getVar('chk_controlled') === '1',
                    'isActive'                => $this->request->getVar('chk_active')    === '1',
                    'costingMethod'           => 'FEFO',
                ];

                $rawKode = trim($this->request->getVar('inp_kode') ?? '');
                $rawKode = preg_replace('/^OBT-?/i', '', $rawKode);
                if ($rawKode !== '') {
                    $body['itemCode'] = 'OBT-' . $rawKode; 
                }

                $barcode = trim($this->request->getVar('inp_barcode') ?? '');
                if ($barcode !== '') {
                    $body['barcode'] = $barcode;
                }

                $itemImageUrl = trim($this->request->getVar('inp_image_url') ?? '');
                if ($itemImageUrl !== '') {
                    $body['itemImageUrl'] = $itemImageUrl;
                }
                    if ($this->request->getVar('action') === 'Add') {
                        $body['createdBy'] = $empCd;
                        $url = "{$this->server5}/api/Items";

                        log_message('debug', 'Items(Obat) Add Request: ' . json_encode($body));
                        $result = akses_restapikey('POST', $url, $body, []);
                        $result = is_string($result) ? json_decode($result, true) : $result;
                        log_message('debug', 'Items(Obat) Add Response: ' . json_encode($result));

                        if (isset($result['success']) && $result['success'] === true) {
                            $created = $result['data'] ?? [];
                            return $this->response->setJSON([
                                'status'    => 'success',
                                'message'   => 'Data Obat berhasil ditambahkan',
                                'itemCode'  => $created['itemCode'] ?? $body['itemCode'],
                                'itemId'    => $created['itemId']   ?? null,
                                'data'      => $result,
                            ]);
                        }

                        return $this->response->setJSON([
                            'status'  => 'error',
                            'message' => $result['message'] ?? 'Gagal menambahkan data',
                            'errors'  => $result['errors'] ?? null
                        ]);
                    }

                    if ($this->request->getVar('action') === 'Edit') {
                        $body['updatedBy'] = $empCd;
                        $itemCode = $this->request->getVar('hidden_code');
                        $url      = "{$this->server5}/api/Items/{$itemCode}";

                        log_message('debug', 'Items(Obat) Edit Request: ' . json_encode($body));
                        $result = akses_restapikey('PUT', $url, $body, []);
                        $result = is_string($result) ? json_decode($result, true) : $result;
                        log_message('debug', 'Items(Obat) Edit Response: ' . json_encode($result));

                        if (isset($result['success']) && $result['success'] === true) {
                            return $this->response->setJSON([
                                'status'   => 'success',
                                'message'  => 'Data Obat berhasil diubah',
                                'itemCode' => $itemCode,
                                'data'     => $result
                            ]);
                        }

                        return $this->response->setJSON([
                            'status'  => 'error',
                            'message' => $result['message'] ?? 'Gagal mengubah data',
                            'errors'  => $result['errors'] ?? null
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
            $itemCode = $this->request->getVar('itemCode');

            helper(['restclient']);
            $url    = "{$this->server5}/api/Items/{$itemCode}";
            $result = akses_restapikey('DELETE', $url, [], []);
            $result = is_string($result) ? json_decode($result, true) : $result;

            if (isset($result['success']) && $result['success'] === true) {
                return $this->response->setJSON([
                    'status'  => 'success',
                    'message' => $result['message'] ?? 'Data Obat berhasil dihapus',
                    'data'    => $result
                ]);
            }

            return $this->response->setJSON([
                'status'  => 'error',
                'message' => $result['message'] ?? 'Gagal menghapus data',
                'errors'  => $result['errors'] ?? null
            ]);
        }
    }

    public function drugDetail($itemCode)
    {
        helper(['restclient']);
        $url      = "{$this->server5}/api/Items/{$itemCode}/drug-detail";
        $response = akses_restapikey('GET', $url, [], []);
        $result   = json_decode($response, true);

        return $this->response->setJSON([
            'status' => isset($result['data']) ? 'success' : 'error',
            'data'   => $result['data'] ?? null,
        ]);
    }

    private function toEnumFormat($value)
    {
        $value = trim($value);
        if ($value === '') return '';
        return strtoupper(str_replace(' ', '_', $value));
    }

    public function saveDrugDetail($itemCode)
    {
        helper(['restclient']);
        $empCd = $this->session->get('fullname') ?? '';

        $regulationInput = $this->request->getVar('dd_regulation') ?? '';
        $regulationClass = $this->toEnumFormat($regulationInput);

        if (empty($regulationClass)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Drug Regulation Class wajib dipilih.',
            ]);
        }

        $generic = trim($this->request->getVar('dd_generic') ?? '');
        if (empty($generic)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Generic Name wajib diisi.',
            ]);
        }

        $body = [
            'genericName'         => $generic,
            'brandName'           => trim($this->request->getVar('dd_brand') ?? ''),
            'strength'            => trim($this->request->getVar('dd_strength') ?? ''),
            'dosageForm'          => trim($this->request->getVar('dd_dosage') ?? ''),
            'route'               => trim($this->request->getVar('dd_route') ?? ''),
            'drugClass'           => trim($this->request->getVar('dd_drug_class') ?? ''),
            'therapeuticClass'    => trim($this->request->getVar('dd_therapeutic') ?? ''),
            'atcCode'             => trim($this->request->getVar('dd_atc') ?? ''),
            'kfaCode'             => trim($this->request->getVar('dd_kfa') ?? ''),
            'composition'         => trim($this->request->getVar('dd_composition') ?? ''),
            'indication'          => trim($this->request->getVar('dd_indication') ?? ''),
            'contraIndication'    => trim($this->request->getVar('dd_contra') ?? ''),
            'sideEffect'          => trim($this->request->getVar('dd_side') ?? ''),
            'drugRegulationClass' => $regulationClass,
            'storageInstruction'  => trim($this->request->getVar('dd_storage') ?? ''),
            'defaultUsageInstruction' => trim($this->request->getVar('dd_aturan') ?? ''),
            'registrationNo'      => trim($this->request->getVar('dd_reg_no') ?? ''),
            'isPrescriptionRequired'     => true,
            'isAntibiotic'               => false,
            'isNarcotic'                 => false,
            'isPsychotropic'             => false, 
            'isHighAlert'                => false, 
            'regulatoryAgency'           => 'BPOM', 
            'packaging'                  => '',
            'packageContent'             => '',
            'storageTemperature'         => '',
            'storageLightInstruction'    => '',
            'storageHumidityInstruction' => '',
        ];

        $url = "{$this->server5}/api/Items/{$itemCode}/drug-detail";

        log_message('debug', 'Items(Obat) SaveDrugDetail Request: ' . json_encode($body));
        $result = akses_restapikey('PUT', $url, $body, []);
        $result = is_string($result) ? json_decode($result, true) : $result;
        log_message('debug', 'Items(Obat) SaveDrugDetail Response: ' . json_encode($result));

        return $this->response->setJSON([
            'status'  => (isset($result['success']) && $result['success']) ? 'success' : 'error',
            'message' => (isset($result['success']) && $result['success'])
                ? 'Data Drug Detail berhasil disimpan'
                : ($result['message'] ?? 'Gagal menyimpan drug detail'),
            'errors'  => $result['errors'] ?? null,
        ]);
    }

    public function uomConversion($itemCode)
    {
        helper(['restclient']);
        $url      = "{$this->server5}/api/Items/{$itemCode}/uoms";
        $response = akses_restapikey('GET', $url, [], []);
        $result   = json_decode($response, true);

        $data = $result['data'] ?? [];
        foreach ($data as &$row) {
            $row['id']        = $row['itemUomId']        ?? null;
            $row['uom']       = $row['uomCode']           ?? '';
            $row['deskripsi'] = $row['uomName']           ?? ''; 
            $row['faktor']    = $row['conversionToBase']  ?? 1;  
            $row['isi']       = '1 ' . ($row['uomCode'] ?? '') . ' = ' . ($row['conversionToBase'] ?? 1) . ' (base)';
            $row['purchase']  = !empty($row['isPurchaseUom']); 
            $row['sales']     = !empty($row['isSalesUom']);    
            $row['aktif']     = $row['isActive']          ?? true;
            $row['base']      = !empty($row['isBaseUom']);
        }

        return $this->response->setJSON([
            'status'   => 'success',
            'data'     => $data,
            'base_uom' => $result['baseUomLabel'] ?? '',
        ]);
    }

    public function saveUom($itemCode)
    {
        helper(['restclient']);
        $empCd    = $this->session->get('fullname') ?? '';
        $uomId    = $this->request->getVar('uom_id'); 

        $body = [
            'uomId'            => trim($this->request->getVar('uom_id_master')), 
            'conversionToBase' => (float) $this->request->getVar('uom_faktor'),
            'isPurchaseUom'    => $this->request->getVar('uom_purchase') === '1',
            'isSalesUom'       => $this->request->getVar('uom_sales') === '1',
            'isActive'         => $this->request->getVar('uom_status') === 'Aktif',
        ];

        if ($uomId) {
            $body['updatedBy'] = $empCd;
            $url = "{$this->server5}/api/Items/{$itemCode}/uoms/{$uomId}";
            $result = akses_restapikey('PUT', $url, $body, []);
        } else {
            $body['createdBy'] = $empCd;
            $url = "{$this->server5}/api/Items/{$itemCode}/uoms";
            $result = akses_restapikey('POST', $url, $body, []);
        }

        $result = is_string($result) ? json_decode($result, true) : $result;

        return $this->response->setJSON([
            'status'  => (isset($result['success']) && $result['success']) ? 'success' : 'error',
            'message' => (isset($result['success']) && $result['success'])
                ? 'Satuan UOM berhasil disimpan'
                : ($result['message'] ?? 'Gagal menyimpan UOM'),
        ]);
    }

    public function deleteUom($itemCode, $itemUomId)
    {
        helper(['restclient']);
        $url    = "{$this->server5}/api/Items/{$itemCode}/uoms/{$itemUomId}";
        $result = akses_restapikey('DELETE', $url, [], []);
        $result = is_string($result) ? json_decode($result, true) : $result;

        return $this->response->setJSON([
            'status'  => (isset($result['success']) && $result['success']) ? 'success' : 'error',
            'message' => (isset($result['success']) && $result['success'])
                ? 'Satuan UOM berhasil dihapus'
                : ($result['message'] ?? 'Gagal menghapus UOM'),
        ]);
    }
    public function harga($itemCode)
    {
        helper(['restclient']);
        $url      = "{$this->server5}/api/Items/{$itemCode}/prices";
        $response = akses_restapikey('GET', $url, [], []);
        $result   = json_decode($response, true);

        $data = $result['data'] ?? [];
        $hargaList = [];
        foreach ($data as $row) {
            $sellingPrice = $row['sellingPrice'] ?? 0;
            $hpp          = $row['hppPrice']     ?? null;
            $margin       = ($hpp !== null && $sellingPrice > 0)
                ? round((($sellingPrice - $hpp) / $sellingPrice) * 100, 2)
                : null;

            $hargaList[] = [
                'id'          => $row['sellingPriceId']  ?? null,
                'price_class' => $row['priceClassCode']  ?? '',
                'deskripsi'   => $row['priceClassName']  ?? '',
                'uom_code'    => $row['uomCode']         ?? '', 
                'mata_uang'   => $row['currencyCode']    ?? 'IDR',
                'harga_jual'  => $sellingPrice,
                'hpp'         => $hpp,
                'margin'      => $margin,
                'aktif'       => $row['isActive']        ?? true,
                'berlaku_mulai'   => $row['effectiveDate'] ?? null,
                'berlaku_sampai'  => $row['expiredDate']   ?? null,
                'rounding_enabled'       => $row['isRoundingEnabled']       ?? false,
                'rounding_multiple'      => $row['roundingMultiple']        ?? null,
                'default_margin_enabled' => $row['isDefaultMarginEnabled']  ?? false,
                'default_margin_percent' => $row['defaultMarginPercent']    ?? null,
                'promo_enabled'          => $row['isPromoEnabled']           ?? false,
                'promo_price'            => $row['promoPrice']               ?? null,
                'promo_start'            => $row['promoStartDate']           ?? null,
                'promo_end'              => $row['promoEndDate']             ?? null,
            ];
        }

        $marginValues = array_filter(array_column($hargaList, 'margin'), fn($m) => $m !== null);

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $hargaList,
            'total_price_class' => count($hargaList),
            'harga_terendah'    => $hargaList ? min(array_column($hargaList, 'harga_jual')) : 0,
            'harga_tertinggi'   => $hargaList ? max(array_column($hargaList, 'harga_jual')) : 0,
            'rata_margin'       => $marginValues ? round(array_sum($marginValues) / count($marginValues), 2) : null,
        ]);
    }

    public function saveHarga($itemCode)
    {
        helper(['restclient']);
        $empCd   = $this->session->get('fullname') ?? '';
        $priceId = $this->request->getVar('price_id');

        $body = [
            'priceClassId'  => trim($this->request->getVar('h_price_class_id')),
            'uomId'         => trim($this->request->getVar('h_uom_id')), 
            'currencyCode'  => trim($this->request->getVar('h_mata_uang')) ?: 'IDR',
            'sellingPrice'  => (int) str_replace('.', '', $this->request->getVar('h_harga_jual')),
            'hppPrice'      => (int) $this->request->getVar('h_hpp'),
            'effectiveDate' => trim($this->request->getVar('h_tgl_mulai')),
            'expiredDate'   => trim($this->request->getVar('h_tgl_selesai')) ?: null,
            'isActive'      => $this->request->getVar('h_status_aktif') === '1',
            'isRoundingEnabled'      => $this->request->getVar('h_rounding_enabled') === '1',
            'roundingMultiple'       => $this->request->getVar('h_rounding_multiple') !== '' ? (int) $this->request->getVar('h_rounding_multiple') : null,
            'isDefaultMarginEnabled' => $this->request->getVar('h_margin_enabled') === '1',
            'defaultMarginPercent'   => $this->request->getVar('h_margin_percent') !== '' ? (float) $this->request->getVar('h_margin_percent') : null,
            'isPromoEnabled'         => $this->request->getVar('h_promo_enabled') === '1',
            'promoPrice'             => (int) $this->request->getVar('h_promo_harga'),
            'promoStartDate'         => trim($this->request->getVar('h_promo_start') ?? '') ?: null,
            'promoEndDate'           => trim($this->request->getVar('h_promo_end') ?? '') ?: null,
        ];
        if ($priceId) {
            $body['updatedBy'] = $empCd;
            $url = "{$this->server5}/api/Items/{$itemCode}/prices/{$priceId}";
            $result = akses_restapikey('PUT', $url, $body, []);
        } else {
            $body['createdBy'] = $empCd;
            $url = "{$this->server5}/api/Items/{$itemCode}/prices";
            $result = akses_restapikey('POST', $url, $body, []);
        }

        $result = is_string($result) ? json_decode($result, true) : $result;

        return $this->response->setJSON([
            'status'  => (isset($result['success']) && $result['success']) ? 'success' : 'error',
            'message' => (isset($result['success']) && $result['success'])
                ? 'Harga berhasil disimpan'
                : ($result['message'] ?? 'Gagal menyimpan harga'),
        ]);
    }

    public function deleteHarga($itemCode, $priceId)
    {
        helper(['restclient']);
        $url    = "{$this->server5}/api/Items/{$itemCode}/prices/{$priceId}";
        $result = akses_restapikey('DELETE', $url, [], []);
        $result = is_string($result) ? json_decode($result, true) : $result;

        return $this->response->setJSON([
            'status'  => (isset($result['success']) && $result['success']) ? 'success' : 'error',
            'message' => (isset($result['success']) && $result['success'])
                ? 'Harga berhasil dihapus'
                : ($result['message'] ?? 'Gagal menghapus harga'),
        ]);
    }

    public function supplier($itemCode)
    {
        helper(['restclient']);
        $url      = "{$this->server5}/api/Items/{$itemCode}/suppliers";
        $response = akses_restapikey('GET', $url, [], []);
        $result   = json_decode($response, true);

        $data = $result['data'] ?? [];
        $list = [];
        $leadTimes = [];
        $hargaBeliList = [];
        foreach ($data as $row) {
            $leadTime  = $row['leadTimeDays'] ?? 0;
            $hargaBeli = $row['lastPurchasePrice'] ?? 0;
            $leadTimes[] = $leadTime;
            if ($hargaBeli > 0) $hargaBeliList[] = $hargaBeli;

            $list[] = [
                'id'            => $row['itemSupplierId'] ?? null,
                'supplierId'    => $row['supplierId']      ?? '',
                'supplier'      => $row['supplierName']    ?? '',
                'principalId'   => $row['principalId']     ?? '',
                'principal'     => $row['principalName']   ?? '',
                'mata_uang'     => 'IDR',
                'harga_beli'    => $hargaBeli,
                'lead_time'     => $leadTime,
                'min_order'     => $row['minimumOrderQty'] ?? '-',
                'utama'         => !empty($row['isDefault']),
                'aktif'         => $row['isActive']        ?? true,
                'catatan'       => $row['notes']           ?? '',
                'terakhir_beli' => $row['lastPurchaseDate'] ?? null,
            ];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $list,
            'total_supplier'      => count($list),
            'lead_time_avg'       => count($leadTimes) ? round(array_sum($leadTimes) / count($leadTimes), 1) : null,
            'harga_beli_terendah' => $hargaBeliList ? min($hargaBeliList) : null,
        ]);
    }

    public function saveSupplier($itemCode)
    {
        helper(['restclient']);
        $empCd = $this->session->get('fullname') ?? '';
        $supplierId = $this->request->getVar('item_supplier_id');

        $body = [
            'supplierId'        => trim($this->request->getVar('s_supplier_id')),  
            'principalId'       => trim($this->request->getVar('s_principal_id')),
            'lastPurchasePrice' => (int) str_replace('.', '', $this->request->getVar('s_harga_beli')),
            'leadTimeDays'      => (int) $this->request->getVar('s_lead_time'),
            'minimumOrderQty'   => (int) $this->request->getVar('s_min_order'),
            'notes'             => trim($this->request->getVar('s_catatan')),   
            'isDefault'         => $this->request->getVar('s_utama') === '1',
            'isActive'          => $this->request->getVar('s_aktif') === '1',
        ];

        if ($supplierId) {
            $body['updatedBy'] = $empCd;
            $url = "{$this->server5}/api/Items/{$itemCode}/suppliers/{$supplierId}";
            $result = akses_restapikey('PUT', $url, $body, []);
        } else {
            $body['createdBy'] = $empCd;
            $url = "{$this->server5}/api/Items/{$itemCode}/suppliers";
            $result = akses_restapikey('POST', $url, $body, []);
        }

        $result = is_string($result) ? json_decode($result, true) : $result;

        return $this->response->setJSON([
            'status'  => (isset($result['success']) && $result['success']) ? 'success' : 'error',
            'message' => (isset($result['success']) && $result['success'])
                ? 'Supplier berhasil disimpan'
                : ($result['message'] ?? 'Gagal menyimpan supplier'),
        ]);
    }

    public function deleteSupplier($itemCode, $itemSupplierId)
    {
        helper(['restclient']);
        $url    = "{$this->server5}/api/Items/{$itemCode}/suppliers/{$itemSupplierId}";
        $result = akses_restapikey('DELETE', $url, [], []);
        $result = is_string($result) ? json_decode($result, true) : $result;

        return $this->response->setJSON([
            'status'  => (isset($result['success']) && $result['success']) ? 'success' : 'error',
            'message' => (isset($result['success']) && $result['success'])
                ? 'Supplier berhasil dihapus'
                : ($result['message'] ?? 'Gagal menghapus supplier'),
        ]);
    }

    public function stock($itemCode)
    {
        helper(['restclient']);

        $urlStock = "{$this->server5}/api/Items/{$itemCode}/stocks";
        $urlLots  = "{$this->server5}/api/Items/{$itemCode}/lots";

        $respStock = akses_restapikey('GET', $urlStock, [], []);
        $respLots  = akses_restapikey('GET', $urlLots, [], []);

        $resultStock = json_decode($respStock, true);
        $resultLots  = json_decode($respLots, true);

        $summary   = $resultStock['summary']  ?? [];
        $batchRows = $resultStock['batches']  ?? [];

        $stockList = [];
        foreach ($batchRows as $row) {
            $stockList[] = [
                'id'        => $row['stockId']         ?? null,
                'warehouse' => $row['warehouseName']    ?? '',
                'bin'       => $row['binCode']          ?? '-',
                'stok'      => $row['qtyOnHandBase']    ?? 0,  
                'reservasi' => $row['qtyReservedBase']  ?? 0,  
                'tersedia'  => $row['qtyAvailableBase'] ?? 0,  
                'min'       => 0,
                'po'        => 0, 
                'paket'     => 0, 
                'satuan'    => '', 
                'nilai'     => ($row['qtyOnHandBase'] ?? 0) * ($row['unitCostBase'] ?? 0),
                'batch'     => $row['batchNo']          ?? '', 
            ];
        }

        $batchList = [];
        foreach (($resultLots['data'] ?? $resultLots) as $row) {
            if (!is_array($row) || !isset($row['lotId'])) continue;
            $batchList[] = [
                'id'         => $row['lotId']            ?? null,
                'no_batch'   => $row['batchNo']           ?? '',
                'prod'       => $row['manufactureDate']   ?? '-',
                'exp'        => $row['expiredDate']       ?? '-',
                'stok'       => $row['qtyOnHandBase']      ?? 0,  
                'reservasi'  => $row['qtyReservedBase']    ?? 0,  
                'satuan'     => '', 
                'status'     => !empty($row['isExpired']) ? 'Expired' : (!empty($row['isNearExpired']) ? 'Hampir Expired' : 'Aman'), 
                'supplier'   => $row['supplierName']       ?? '', 
                'blocked'    => !empty($row['isBlocked']), 
            ];
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'summary' => [ 
                'total_stok'     => $summary['totalQtyOnHandBase']    ?? 0,
                'total_tersedia' => $summary['totalQtyAvailableBase'] ?? 0,
                'batch_aktif'    => $summary['activeBatchCount']      ?? 0,
                'batch_expired'  => $summary['expiredBatchCount']     ?? 0,
                'batch_near_exp' => $summary['nearExpiredBatchCount'] ?? 0,
                'batch_blocked'  => $summary['blockedBatchCount']     ?? 0,
            ],
            'stock'   => $stockList,
            'batch'   => $batchList,
        ]);
    }

    public function saveStock($itemCode)
    {
        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Endpoint untuk menambah stok belum tersedia di backend. Hubungi tim API.',
        ]);
    }

    public function saveBatch($itemCode)
    {
        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Endpoint untuk menambah batch belum tersedia di backend. Hubungi tim API.',
        ]);
    }

    public function dokumen($itemCode)
    {
        helper(['restclient']);
        $url      = "{$this->server5}/api/Items/{$itemCode}/documents";
        $response = akses_restapikey('GET', $url, [], []);
        $result   = json_decode($response, true);

        $data = $result['data'] ?? [];
        $list = [];
        foreach ($data as $row) {
            $list[] = [
                'id'      => $row['documentId']   ?? null,
                'jenis'   => $row['documentType']  ?? '',
                'nomor'   => $row['referenceNo']   ?? '-',
                'tanggal' => $row['documentDate']  ?? '-',
                'berlaku' => $row['validUntil']    ?? '-',
                'file'    => $row['fileName']      ?? '',
                'ukuran'  => $row['fileSize']      ?? '',
                'aktif'   => $row['isActive']      ?? true,
            ];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $list,
            'wajib'  => [], 
        ]);
    }

    public function saveDokumen($itemCode)
    {
        helper(['restclient']);
        $empCd = $this->session->get('fullname') ?? '';
        $documentId = $this->request->getVar('document_id');

        $file = $this->request->getFile('file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Upload file dokumen belum bisa diproses: API belum menyediakan endpoint upload file (hanya field fileUrl yang perlu URL yang sudah ada). Hubungi tim backend untuk endpoint upload storage.',
            ]);
        }

        $body = [
            'documentType' => trim($this->request->getVar('d_jenis')),
            'referenceNo'  => trim($this->request->getVar('d_nomor')),
            'documentDate' => trim($this->request->getVar('d_tanggal')),
            'validUntil'   => trim($this->request->getVar('d_berlaku')) ?: null,
            'description'  => trim($this->request->getVar('d_deskripsi')),
        ];

        if ($documentId) {
            $body['updatedBy'] = $empCd;
            $url = "{$this->server5}/api/Items/{$itemCode}/documents/{$documentId}";
            $result = akses_restapikey('PUT', $url, $body, []);
        } else {
            $body['createdBy'] = $empCd;
            $url = "{$this->server5}/api/Items/{$itemCode}/documents";
            $result = akses_restapikey('POST', $url, $body, []);
        }

        $result = is_string($result) ? json_decode($result, true) : $result;

        return $this->response->setJSON([
            'status'  => (isset($result['success']) && $result['success']) ? 'success' : 'error',
            'message' => (isset($result['success']) && $result['success'])
                ? 'Dokumen berhasil disimpan'
                : ($result['message'] ?? 'Gagal menyimpan dokumen'),
        ]);
    }

    public function deleteDokumen($itemCode, $documentId)
    {
        helper(['restclient']);
        $url    = "{$this->server5}/api/Items/{$itemCode}/documents/{$documentId}";
        $result = akses_restapikey('DELETE', $url, [], []);
        $result = is_string($result) ? json_decode($result, true) : $result;

        return $this->response->setJSON([
            'status'  => (isset($result['success']) && $result['success']) ? 'success' : 'error',
            'message' => (isset($result['success']) && $result['success'])
                ? 'Dokumen berhasil dihapus'
                : ($result['message'] ?? 'Gagal menghapus dokumen'),
        ]);
    }

    public function getSummary()
    {
        helper(['restclient']);

        $payloadAll = [
            'draw'    => 1,
            'start'   => 0,
            'length'  => 0,
            'itemType'=> 'DRUG',
            'search'  => ['value' => '', 'regex' => false],
            'columns' => [],
            'order'   => [],
        ];
        $url        = "{$this->server5}/api/Items/datatable";
        $resAll     = akses_restapikey('POST', $url, $payloadAll, []);
        $bodyAll    = json_decode($resAll, true);
        $totalAll   = (int) ($bodyAll['recordsTotal'] ?? $bodyAll['totalRecords'] ?? $bodyAll['total'] ?? 0);

        $payloadActive = $payloadAll;
        $payloadActive['isActive'] = true;
        $resActive  = akses_restapikey('POST', $url, $payloadActive, []);
        $bodyActive = json_decode($resActive, true);
        $totalAktif = (int) ($bodyActive['recordsFiltered'] ?? $bodyActive['filteredRecords'] ?? $bodyActive['totalFiltered'] ?? 0);
        $rows       = $bodyActive['data'] ?? [];

        $batchTracked = 0;
        $expiringSoon = 0;
        $stokHabis    = 0;

        if (!empty($rows)) {
            foreach ($rows as $row) {
                if (!empty($row['isBatchTracked'])) $batchTracked++;
                if ((int) ($row['expiringBatchCount'] ?? 0) > 0) $expiringSoon++;
                if ((int) ($row['totalStock'] ?? 0) <= 0 && !is_string($row['totalStock'] ?? null)) $stokHabis++;
            }
        }

        $pctAktif = $totalAll > 0 ? round($totalAktif / $totalAll * 100, 1) : 0;

        return $this->response->setJSON([
            'status'       => 'success',
            'total'        => $totalAll,
            'aktif'        => $totalAktif,
            'pctAktif'     => $pctAktif,
            'batchTracked' => $batchTracked,
            'expiringSoon' => $expiringSoon,
            'stokHabis'    => $stokHabis,
        ]);
    }

    public function download() { }
    public function upload() { }
    public function preview() { }
}