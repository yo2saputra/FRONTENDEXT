<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as excel;

class Tmstpaketbaru extends BaseController
{
    protected $data;
    protected $server3;
    protected $server5;

    public function __construct()
    {
        $this->server3 = $_ENV['APP_API3'];
        $this->server5 = $_ENV['APP_API5'];
    }

    public function index()
    {
        return view('tmstpaketbaru/index', $this->data);
    }
    public function getKategoriDropdown()
    {
        helper(['restclient']);
        $url      = "{$this->server5}/api/Dropdown/item-categories";
        $response = akses_restapikey('GET', $url, [], []);
        $result   = json_decode($response, true);

        log_message('debug', 'Kategori Dropdown Raw Response: ' . $response);

        $rows = $result['data'] ?? $result ?? [];
        $list = [];
        foreach ($rows as $row) {
            $list[] = [
                'id'   => $row['value'] ?? '',
                'text' => $row['desc']  ?? '',
            ];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $list,
        ]);
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
            $list[] = [
                'id'   => $row['value'] ?? '',
                'text' => $row['desc']  ?? '',
            ];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $list,
        ]);
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
            $list[] = [
                'id'   => $row['value'] ?? '',
                'text' => $row['desc']  ?? '',
            ];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $list,
        ]);
    }

    public function getItemTypeDropdown()
    {
        helper(['restclient']);
        $url      = "{$this->server5}/api/Dropdown/item-types";
        $response = akses_restapikey('GET', $url, [], []);
        $result   = json_decode($response, true);

        $rows = $result['data'] ?? $result ?? [];
        $list = [];
        foreach ($rows as $row) {
            $list[] = [
                'id'   => $row['value'] ?? '',
                'text' => $row['desc']  ?? '',
            ];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $list,
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
                'value' => $json['cari_paket'] ?? '',
                'regex' => false,
            ],
            'columns'   => $json['columns'] ?? [],
            'order'     => $json['order']   ?? [],
            'itemType'  => 'PACKAGE',
            'cari'      => $json['cari_paket'] ?? '',
            'cariPaket' => $json['cari_paket'] ?? '',
        ];

        if (!empty($json['status'])) {
            $requestPayload['status'] = $json['status'];
        }
        if (!empty($json['kategori'])) {
            $requestPayload['kategori'] = $json['kategori'];
        }

        $url      = "{$this->server5}/api/Items/datatable";
        $response = akses_restapikey('POST', $url, $requestPayload, []);
        $result   = json_decode($response, true);

        if (!isset($result['data']) || !is_array($result['data'])) {
            log_message('error', 'Paket Datatables invalid response: ' . $response);
            return $this->response->setJSON([
                'draw'            => $requestPayload['draw'] ?? 1,
                'recordsTotal'    => 0,
                'recordsFiltered' => 0,
                'data'            => []
            ]);
        }

        foreach ($result['data'] as $i => &$row) {
            $id   = $row['itemId'];
            $code = $row['itemCode'];
            $row['rownum'] = $i + ($requestPayload['start'] ?? 0) + 1;

            $row['paketId']        = $code;
            $row['kodePaketLink']  = '<a href="#" class="kode-paket-link paket-link" data-id="' . $code . '">' . $code . '</a>';
            $row['namaPaket']      = $row['itemName']     ?? '-';
            $row['kategori']       = $row['categoryName']  ?? '-';
            $row['hargaJualFormat'] = !empty($row['defaultSellingPrice'])
                ? 'Rp ' . number_format($row['defaultSellingPrice'], 0, ',', '.')
                : '-';
            $row['statusBadge']    = !empty($row['isActive'])
                ? '<span class="badge-pkt-aktif">Aktif</span>'
                : '<span class="badge-pkt-nonaktif">Non-Aktif</span>';
            $rawDate = $row['updatedDate'] ?? $row['createdDate'] ?? '';
            $formattedDate = $rawDate ? date('Y-m-d H:i:s', strtotime(str_replace(['T', 'Z'], [' ', ''], preg_replace('/\.\d+Z?$/', '', $rawDate)))) : '-';
            $row['updatedInfo']    = '<span class="last-updated-date">' . $formattedDate . '</span><br><span class="last-updated-by">' . ($row['updatedBy'] ?? $row['createdBy'] ?? '-') . '</span>';

            $row['aksi'] = '
            <button type="button" class="btn-aksi-pkt view '   . ($this->session->get('flag_view')   === 1 ? '' : 'd-none') . '" data-id="' . $id . '" title="Lihat"><i class="fas fa-eye"></i></button>
            <button type="button" class="btn-aksi-pkt edit '   . ($this->session->get('flag_update') === 1 ? '' : 'd-none') . '" data-id="' . $id . '" title="Edit"><i class="fas fa-pencil-alt"></i></button>
            <button type="button" class="btn-aksi-pkt delete ' . ($this->session->get('flag_delete') === 1 ? '' : 'd-none') . '" data-id="' . $id . '" title="Hapus"><i class="fas fa-trash"></i></button>';
        }

        $result['draw'] = (int) ($requestPayload['draw'] ?? 1);
        return $this->response->setJSON($result);
    }

    public function fetchSingleData()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Request bukan AJAX']);
        }

        $itemCode = $this->request->getVar('paketId');
        if (!$itemCode) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'itemCode tidak ditemukan']);
        }

        helper(['restclient']);
        $url      = "{$this->server5}/api/Items/{$itemCode}";
        $response = akses_restapikey('GET', $url, [], []);
        $data     = json_decode($response, true);

        if (!isset($data['data'])) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        }
        $d = $data['data'];

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => [
                'paketId'         => $d['itemCode']     ?? '',
                'kodePaket'       => $d['itemCode']     ?? '',
                'namaPaket'       => $d['itemName']     ?? '',
                'kategoriId'      => $d['itemCategoryId'] ?? '',
                'deskripsi'       => $d['notes']        ?? '',
                'satuanDasar'     => $d['baseUomId']    ?? '',
                'baseUomId'       => $d['baseUomId']    ?? '',
                'isActive'        => $d['isActive']     ?? true,
                'createdBy'       => $d['createdBy']    ?? '',
                'createdDate'     => $d['createdDate']  ?? '',
                'updatedBy'       => $d['updatedBy']    ?? '',
                'updatedDate'     => $d['updatedDate']  ?? '',
                'berlakuUntuk'    => $d['berlakuUntuk'] ?? 'semua_outlet',
                'tipePaket'       => $d['tipePaket']    ?? 'standar',
                'catatanInternal' => $d['notes']        ?? '',
            ]
        ]);
    }

    public function action()
    {
        if (!$this->request->isAJAX() || !$this->request->getVar('action')) {
            exit('Maaf tidak dapat diproses!');
        }

        helper(['form', 'url', 'restclient']);

        $errors = [];
        if ($this->request->getVar('action') === 'Add' && empty(trim($this->request->getVar('kodePaket')))) {
            $errors['kodePaket'] = 'Kode Paket harus diisi';
        }
        if (empty(trim($this->request->getVar('namaPaket')))) {
            $errors['namaPaket'] = 'Nama Paket harus diisi';
        }
        if (empty(trim($this->request->getVar('kategoriId')))) {
            $errors['kategoriId'] = 'Kategori harus dipilih';
        }
        if (!empty($errors)) {
            return $this->response->setJSON(['error' => $errors]);
        }

        $empCd = $this->session->get('fullname') ?? '';

        $defaultGroupId = '455aa35e-27ff-4978-a43c-0e7e94448ac7';

        $itemCode = trim($this->request->getVar('kodePaket'));

        $body = [
            'itemCode'      => $itemCode,
            'itemName'      => trim($this->request->getVar('namaPaket')),
            'itemCategoryId' => trim($this->request->getVar('kategoriId')),
            'itemGroupId'   => $defaultGroupId,
            'itemType'      => 'PACKAGE',
            'baseUomId'     => trim($this->request->getVar('satuanDasar')),
            'isStockItem'   => false,
            'isSaleItem'    => true,
            'isPurchaseItem' => false,
            'isBatchTracked' => false,
            'isExpiredTracked' => false,
            'isPrescriptionRequired' => false,
            'isActive'      => $this->request->getVar('isActive') === '1',
            'notes'         => trim($this->request->getVar('deskripsi') ?? ''),
        ];

        if ($this->request->getVar('action') === 'Add') {
            $body['createdBy'] = $empCd;
            $url = "{$this->server5}/api/Items";

            log_message('debug', 'Paket Add Request: ' . json_encode($body));
            $result = akses_restapikey('POST', $url, $body, []);
            $result = is_string($result) ? json_decode($result, true) : $result;
            log_message('debug', 'Paket Add Response: ' . json_encode($result));

            if (isset($result['success']) && $result['success'] === true) {
                $created = $result['data'] ?? [];
                return $this->response->setJSON([
                    'status'    => 'success',
                    'message'   => 'Data Paket berhasil ditambahkan',
                    'itemCode'  => $created['itemCode'] ?? $body['itemCode'],
                    'itemId'    => $created['itemId']   ?? null,
                    'baseUomId' => $created['baseUomId'] ?? $body['baseUomId'],
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
            $itemCodeEdit = $this->request->getVar('hidden_id');
            $url = "{$this->server5}/api/Items/{$itemCodeEdit}";

            log_message('debug', 'Paket Edit Request: ' . json_encode($body));
            $result = akses_restapikey('PUT', $url, $body, []);
            $result = is_string($result) ? json_decode($result, true) : $result;
            log_message('debug', 'Paket Edit Response: ' . json_encode($result));

            if (isset($result['success']) && $result['success'] === true) {
                return $this->response->setJSON([
                    'status'   => 'success',
                    'message'  => 'Data Paket berhasil diubah',
                    'itemCode' => $itemCodeEdit,
                ]);
            }

            return $this->response->setJSON([
                'status'  => 'error',
                'message' => $result['message'] ?? 'Gagal mengubah data',
                'errors'  => $result['errors'] ?? null
            ]);
        }
    }

    public function delete()
    {
        if (!$this->request->isAJAX()) return;

        $itemCode = $this->request->getVar('paketId');
        helper(['restclient']);
        $url    = "{$this->server5}/api/Items/{$itemCode}";
        $result = akses_restapikey('DELETE', $url, [], []);
        $result = is_string($result) ? json_decode($result, true) : $result;

        if (isset($result['success']) && $result['success'] === true) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => $result['message'] ?? 'Data Paket berhasil dihapus',
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => $result['message'] ?? 'Gagal menghapus data',
        ]);
    }

    public function searchItem()
    {
        helper(['restclient']);
        $search = $this->request->getVar('q') ?? '';
        $tipe = $this->request->getVar('tipe') ?? '';

        $url = "{$this->server5}/api/Items/all?search=" . urlencode($search);
        if ($tipe) {
            $url .= "&itemType=" . urlencode($tipe);
        }

        $response = akses_restapikey('GET', $url, [], []);
        $result = json_decode($response, true);

        $list = [];
        foreach (($result['data'] ?? []) as $row) {
            $list[] = [
                'kode'   => $row['itemCode'] ?? '',
                'nama'   => $row['itemName'] ?? '',
                'tipe'   => $row['itemType'] ?? '',
                'uomId'  => $row['baseUomId'] ?? '',
                'satuan' => $row['uomCode'] ?? '',
            ];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $list,
        ]);
    }

    public function packageComponents($itemCode)
    {
        helper(['restclient']);
        $url      = "{$this->server5}/api/Items/{$itemCode}/package-components";
        $response = akses_restapikey('GET', $url, [], []);
        $result   = json_decode($response, true);

        $data = $result['data'] ?? [];
        $list = [];
        foreach ($data as $row) {
            $componentCode = $row['componentItemCode'] ?? '';
            $list[] = [
                'id'         => $row['packageComponentId'] ?? null,
                'kode'       => $componentCode,
                'nama'       => $row['componentItemName']   ?? '',
                'tipe'       => $row['componentItemType']   ?? '-',
                'satuan'     => $row['uomCode']              ?? '',
                'uomId'      => $row['uomId']               ?? '',
                'qty'        => $row['qty']                  ?? 0,
                'harga'      => $this->getComponentPrice($componentCode, $row['uomId'] ?? ''),
                'optional'   => !empty($row['isOptional']),
                'terpisah'   => !empty($row['isChargedSeparately']),
                'potongStok' => !empty($row['isStockDeducted']),
                'sortNo'     => $row['sortNo']               ?? 0,
                'aktif'      => $row['isActive']             ?? true,
            ];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $list,
        ]);
    }

    private function getComponentPrice(string $itemCode, string $uomId = ''): float
    {
        if (!$itemCode) return 0;
        helper(['restclient']);
        $url    = "{$this->server5}/api/Items/{$itemCode}/prices";
        $result = json_decode(akses_restapikey('GET', $url, [], []), true);
        $prices = $result['data'] ?? [];
        if (empty($prices)) return 0;

        $active = array_values(array_filter($prices, fn($p) => !empty($p['isActive']))) ?: $prices;
        foreach ($active as $p) {
            if ($uomId && ($p['uomId'] ?? '') === $uomId) return (float) ($p['sellingPrice'] ?? 0);
        }
        return (float) ($active[0]['sellingPrice'] ?? 0);
    }

    public function savePackageComponent($itemCode)
    {
        helper(['restclient']);
        $empCd = $this->session->get('fullname') ?? '';
        $componentId = $this->request->getVar('component_id');

        $body = [
            'componentItemCode'    => trim($this->request->getVar('componentItemCode')),
            'uomId'                => trim($this->request->getVar('uomId')),
            'qty'                  => (float) $this->request->getVar('qty'),
            'isOptional'           => $this->request->getVar('isOptional') === '1',
            'isChargedSeparately'  => $this->request->getVar('isChargedSeparately') === '1',
            'isStockDeducted'      => $this->request->getVar('isStockDeducted') === '1',
            'sortNo'               => (int) ($this->request->getVar('sortNo') ?? 0),
            'isActive'             => $this->request->getVar('isActive') === '1',
        ];

        if ($componentId) {
            $body['updatedBy'] = $empCd;
            $url = "{$this->server5}/api/Items/{$itemCode}/package-components/{$componentId}";
            $result = akses_restapikey('PUT', $url, $body, []);
        } else {
            $body['createdBy'] = $empCd;
            $url = "{$this->server5}/api/Items/{$itemCode}/package-components";
            $result = akses_restapikey('POST', $url, $body, []);
        }

        $result = is_string($result) ? json_decode($result, true) : $result;
        log_message('debug', 'Paket SaveComponent Response: ' . json_encode($result));

        return $this->response->setJSON([
            'status'  => (isset($result['success']) && $result['success']) ? 'success' : 'error',
            'message' => (isset($result['success']) && $result['success'])
                ? 'Komponen berhasil disimpan'
                : ($result['message'] ?? 'Gagal menyimpan komponen'),
        ]);
    }

    public function deletePackageComponent($itemCode, $componentId)
    {
        helper(['restclient']);
        $url    = "{$this->server5}/api/Items/{$itemCode}/package-components/{$componentId}";
        $result = akses_restapikey('DELETE', $url, [], []);
        $result = is_string($result) ? json_decode($result, true) : $result;

        return $this->response->setJSON([
            'status'  => (isset($result['success']) && $result['success']) ? 'success' : 'error',
            'message' => (isset($result['success']) && $result['success'])
                ? 'Komponen berhasil dihapus'
                : ($result['message'] ?? 'Gagal menghapus komponen'),
        ]);
    }

    public function saveAllPackageComponents($itemCode)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Request harus AJAX'
            ]);
        }

        helper(['restclient']);
        $empCd = $this->session->get('fullname') ?? 'SYSTEM';

        $components = $this->request->getVar('components');

        if (empty($components) || !is_array($components)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Tidak ada komponen yang akan disimpan'
            ]);
        }

        $validComponents = [];
        foreach ($components as $comp) {
            if (empty($comp['componentItemCode'])) continue;

            $validComponents[] = [
                'componentItemCode' => trim($comp['componentItemCode']),
                'uomId' => trim($comp['uomId'] ?? ''),
                'qty' => (float) ($comp['qty'] ?? 1),
                'isOptional' => isset($comp['isOptional']) && $comp['isOptional'] === '1',
                'isChargedSeparately' => isset($comp['isChargedSeparately']) && $comp['isChargedSeparately'] === '1',
                'isStockDeducted' => isset($comp['isStockDeducted']) && $comp['isStockDeducted'] === '1',
                'sortNo' => (int) ($comp['sortNo'] ?? 0),
                'isActive' => isset($comp['isActive']) && $comp['isActive'] === '1',
                'createdBy' => $empCd,
            ];
        }

        if (empty($validComponents)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Tidak ada komponen valid yang akan disimpan'
            ]);
        }

        $url = "{$this->server5}/api/Items/{$itemCode}/package-components/replace";
        $payload = ['components' => $validComponents];

        log_message('debug', 'Paket Replace Components Request: ' . json_encode($payload));

        $result = akses_restapikey('PUT', $url, $payload, []);
        $result = is_string($result) ? json_decode($result, true) : $result;

        log_message('debug', 'Paket Replace Components Response: ' . json_encode($result));

        if (isset($result['success']) && $result['success'] === true) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => $result['message'] ?? 'Semua komponen berhasil disimpan',
                'data' => $result['data'] ?? null
            ]);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => $result['message'] ?? 'Gagal menyimpan komponen',
            'errors' => $result['errors'] ?? null
        ]);
    }

    public function harga($itemCode)
    {
        helper(['restclient']);
        $url      = "{$this->server5}/api/Items/{$itemCode}/prices";
        $response = akses_restapikey('GET', $url, [], []);
        $result   = json_decode($response, true);

        $data = $result['data'] ?? [];
        $list = [];
        foreach ($data as $row) {
            $list[] = [
                'id'            => $row['sellingPriceId'] ?? null,
                'kelasId'       => $row['priceClassId']    ?? '',
                'kelas'         => $row['priceClassCode']  ?? '',
                'mataUang'      => $row['currencyCode']    ?? 'IDR',
                'hargaJual'     => $row['sellingPrice']    ?? 0,
                'berlakuMulai'  => $row['effectiveDate'] ?? null,
                'berlakuSampai' => $row['expiredDate']   ?? null,
                'aktif'         => $row['isActive']        ?? true,
            ];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $list,
        ]);
    }

    public function saveHarga($itemCode)
    {
        helper(['restclient']);
        $empCd   = $this->session->get('fullname') ?? '';
        $priceId = $this->request->getVar('price_id');

        $priceClassId = trim($this->request->getVar('priceClassId'));

        if (!$priceClassId) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Kelas harga wajib dipilih.',
            ]);
        }

        $body = [
            'priceClassId'  => $priceClassId,
            'uomId'         => trim($this->request->getVar('uomId')),
            'currencyCode'  => 'IDR',
            'sellingPrice'  => (float) $this->request->getVar('hargaJual'),
            'effectiveDate' => trim($this->request->getVar('berlakuMulai')),
            'expiredDate'   => trim($this->request->getVar('berlakuSampai')) ?: null,
            'isActive'      => $this->request->getVar('isActive') === '1',
        ];

        if ($priceId) {
            $body['updatedBy'] = $empCd;
            $url = "{$this->server5}/api/Items/{$itemCode}/prices/{$priceId}";
            $result = akses_restapikey('PUT', $url, $body, []);
        } else {
            $body['createdBy'] = $empCd;
            $body['changeReason'] = 'Initial price creation via frontend';
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

    public function saveAllHarga($itemCode)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Request harus AJAX'
            ]);
        }

        helper(['restclient']);
        $empCd = $this->session->get('fullname') ?? 'SYSTEM';

        $prices = $this->request->getVar('prices');

        if (empty($prices) || !is_array($prices)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Tidak ada harga yang akan disimpan'
            ]);
        }

        $validPrices = [];
        foreach ($prices as $price) {
            if (empty($price['priceClassId']) || empty($price['sellingPrice'])) continue;

            $validPrices[] = [
                'priceClassId' => trim($price['priceClassId']),
                'uomId' => trim($price['uomId'] ?? ''),
                'currencyCode' => trim($price['currencyCode'] ?? 'IDR'),
                'sellingPrice' => (float) $price['sellingPrice'],
                'effectiveDate' => trim($price['effectiveDate']),
                'expiredDate' => !empty($price['expiredDate']) ? trim($price['expiredDate']) : null,
                'isActive' => isset($price['isActive']) && $price['isActive'] === '1',
                'createdBy' => $empCd,
                'changeReason' => $price['changeReason'] ?? 'Bulk update via frontend',
            ];
        }

        if (empty($validPrices)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Tidak ada harga valid yang akan disimpan'
            ]);
        }

        $url = "{$this->server5}/api/Items/{$itemCode}/prices/replace";
        $payload = ['prices' => $validPrices];

        log_message('debug', 'Paket Replace Prices Request: ' . json_encode($payload));

        $result = akses_restapikey('PUT', $url, $payload, []);
        $result = is_string($result) ? json_decode($result, true) : $result;

        log_message('debug', 'Paket Replace Prices Response: ' . json_encode($result));

        if (isset($result['success']) && $result['success'] === true) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => $result['message'] ?? 'Semua harga berhasil disimpan',
                'data' => $result['data'] ?? null
            ]);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => $result['message'] ?? 'Gagal menyimpan harga',
            'errors' => $result['errors'] ?? null
        ]);
    }

    public function download()
    {
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Kode Paket');
        $sheet->setCellValue('B1', 'Nama Paket');
        $sheet->setCellValue('C1', 'Kategori');
        $sheet->setCellValue('D1', 'Deskripsi');
        $sheet->setCellValue('E1', 'Satuan Dasar');
        $sheet->setCellValue('F1', 'Tipe Paket (standar/custom)');
        $sheet->setCellValue('G1', 'Berlaku Untuk');
        $sheet->setCellValue('H1', 'Berlaku Mulai (yyyy-mm-dd)');
        $sheet->setCellValue('I1', 'Berlaku Sampai (yyyy-mm-dd)');
        $sheet->setCellValue('J1', 'Harga Jual');
        $sheet->setCellValue('K1', 'Catatan Internal');
        $sheet->setCellValue('L1', 'Is Active (1/0)');

        foreach (range('A', 'L') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save('data.xlsx');
        return $this->response->download('data.xlsx', null)->setFileName('TEMPLATE MASTER PAKET.xlsx');
    }

    public function preview()
    {
        if ($this->request->getMethod() == 'post') {
            $rules = $this->validate([
                'filename' => 'uploaded[filename]|max_size[filename,500]|ext_in[filename,csv,xlsx]',
            ]);
            if ($rules) {
                $filename = $this->request->getFile('filename');
                $path     = WRITEPATH . 'uploads/';
                $filename->move($path, $filename->getName());
                $this->session->set('fileupload_paket', $path . $filename->getName());
            } else {
                return $this->response->setStatusCode(400)->setJSON(['error' => 'File harus berformat .xlsx']);
            }
        } else {
            if ($this->session->get('fileupload_paket') !== '') {
                $arr_file  = explode('.', $this->session->get('fileupload_paket'));
                $extension = end($arr_file);
                $reader    = ('csv' == $extension) ? new Csv() : new excel();

                $spreadsheet = $reader->load($this->session->get('fileupload_paket'));
                $sheetData   = $spreadsheet->getActiveSheet()->toArray();

                $output = '<br><table id="exampleImportPaket" class="table table-sm table-bordered table-striped">
                <thead><tr>
                    <th>Kode Paket</th><th>Nama Paket</th><th>Kategori</th><th>Deskripsi</th>
                    <th>Satuan Dasar</th><th>Tipe Paket</th><th>Berlaku Untuk</th>
                    <th>Berlaku Mulai</th><th>Berlaku Sampai</th><th>Harga Jual</th>
                    <th>Catatan Internal</th><th>Is Active</th>
                </tr></thead><tbody>';

                if (empty($sheetData)) {
                    $output .= '<tr><td colspan="12">Data not Found</td></tr>';
                } else {
                    $kosong = 0;
                    for ($i = 1; $i < count($sheetData); $i++) {
                        $kodePaket      = $sheetData[$i][0];
                        $namaPaket      = $sheetData[$i][1];
                        $kategori       = $sheetData[$i][2];
                        $deskripsi      = $sheetData[$i][3];
                        $satuanDasar    = $sheetData[$i][4];
                        $tipePaket      = $sheetData[$i][5];
                        $berlakuUntuk   = $sheetData[$i][6];
                        $berlakuMulai   = $sheetData[$i][7];
                        $berlakuSampai  = $sheetData[$i][8];
                        $hargaJual      = $sheetData[$i][9];
                        $catatan        = $sheetData[$i][10];
                        $isActive       = $sheetData[$i][11];

                        $nama_td = (!empty($namaPaket)) ? '' : " style='background:#E07171;'";
                        $kat_td  = (!empty($kategori))  ? '' : " style='background:#E07171;'";
                        $sat_td  = (!empty($satuanDasar)) ? '' : " style='background:#E07171;'";

                        if (empty($namaPaket) || empty($kategori) || empty($satuanDasar)) {
                            $kosong++;
                        }

                        $output .= '<tr>
                            <td>'               . htmlspecialchars($kodePaket)     . '</td>
                            <td' . $nama_td . '>' . htmlspecialchars($namaPaket)     . '</td>
                            <td' . $kat_td  . '>' . htmlspecialchars($kategori)      . '</td>
                            <td>'               . htmlspecialchars($deskripsi)      . '</td>
                            <td' . $sat_td  . '>' . htmlspecialchars($satuanDasar)   . '</td>
                            <td>'               . htmlspecialchars($tipePaket)      . '</td>
                            <td>'               . htmlspecialchars($berlakuUntuk)   . '</td>
                            <td>'               . htmlspecialchars($berlakuMulai)   . '</td>
                            <td>'               . htmlspecialchars($berlakuSampai)  . '</td>
                            <td>'               . htmlspecialchars($hargaJual)      . '</td>
                            <td>'               . htmlspecialchars($catatan)        . '</td>
                            <td>'               . htmlspecialchars($isActive)       . '</td>
                        </tr>';
                    }
                }

                $output .= '</tbody></table><script>
                if(' . $kosong . '>0){
                    Swal.fire({icon:"warning",title:"Perhatian",text:"Ada ' . $kosong . ' baris yang terdapat data kosong!"});
                }
                $(function(){
                    $("#exampleImportPaket").DataTable({
                        "responsive":true,"lengthChange":false,"autoWidth":false,"scrollX":true,
                        "buttons":[{
                            text:"Import",
                            action:function(){
                                $.post("' . site_url('tmstpaketbaru/upload') . '",{})
                                .done(function(response){
                                    let message = response.success || "Data berhasil diimport.";
                                    if(response.details?.errors?.length>0){
                                        message += "\\n\\nDetail Error:\\n"+response.details.errors.join("\\n");
                                    }
                                    Swal.fire({
                                        icon: response.details.fail_count>0?"warning":"success",
                                        title: response.details.fail_count>0?"Import Selesai dengan Error":"Berhasil",
                                        text: message, width:600
                                    });
                                    $("#modalimportpaket").modal("hide");
                                    $("#paketTable").DataTable().ajax.reload(null,false);
                                })
                                .fail(function(error){
                                    Swal.fire({icon:"error",title:"Gagal",text:error.responseJSON?.message||"Terjadi kesalahan."});
                                });
                            },
                            attr:{id:"postButtonPaket",style:"background-color:#56b746;' . ($this->session->get('flag_insert') === 1 ? '' : 'display:none;') . '",name:"postButtonPaket"}
                        }],
                        "oLanguage":{
                            "sSearch":"Cari Data:","sInfoEmpty":"Tidak ada data",
                            "sInfo":"Total: _TOTAL_ data","sInfoFiltered":" dari _MAX_ data",
                            "sZeroRecords":"Data tidak ditemukan",
                            "oPaginate":{"sFirst":"Awal","sPrevious":"Sebelum","sNext":"Berikut","sLast":"Akhir"}
                        }
                    }).buttons().container().appendTo("#exampleImportPaket_wrapper .col-md-6:eq(0)");
                });
                </script>';
                echo $output;
            }
        }
    }

    public function upload()
    {
        if ($this->request->getMethod() == 'post') {
            $arr_file  = explode('.', $this->session->get('fileupload_paket'));
            $extension = end($arr_file);
            $reader    = ('csv' == $extension) ? new Csv() : new excel();

            $spreadsheet  = $reader->load($this->session->get('fileupload_paket'));
            $sheetData    = $spreadsheet->getActiveSheet()->toArray();
            $successCount = 0;
            $failCount    = 0;
            $errors       = [];

            if (!empty($sheetData)) {
                for ($i = 1; $i < count($sheetData); $i++) {
                    $namaPaket   = trim($sheetData[$i][1]);
                    $kategori    = trim($sheetData[$i][2]);
                    $satuanDasar = trim($sheetData[$i][4]);

                    if (empty($namaPaket) || empty($kategori) || empty($satuanDasar)) {
                        $failCount++;
                        $errors[] = 'Baris ' . ($i + 1) . ': Data tidak lengkap';
                        continue;
                    }

                    $successCount++;
                }

                return $this->response->setJSON([
                    'success' => $successCount . ' data berhasil diimport' . ($failCount > 0 ? ', ' . $failCount . ' data gagal' : '') . ' (dummy, belum tersambung ke API)',
                    'details' => [
                        'success_count' => $successCount,
                        'fail_count'    => $failCount,
                        'errors'        => $errors,
                    ],
                ]);
            }

            return $this->response->setJSON(['status' => 'error', 'message' => 'File Excel kosong']);
        }
    }
}
