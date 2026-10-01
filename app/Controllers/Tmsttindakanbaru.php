<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Tmsttindakanbaru extends BaseController
{
    protected $data;
    protected $server5;

    public function __construct()
    {
        $this->server5 = $_ENV['APP_API5'] ?? '';
    }

    public function index()
    {
        return view('tmsttindakanbaru/index', $this->data);
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

    public function getJenisDropdown()
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
            'itemType'  => 'SERVICE',
            'cari'      => $json['cari'] ?? '',
        ];

        if (!empty($json['status'])) {
            $requestPayload['status'] = $json['status'];
        }
        if (!empty($json['kategori'])) {
            $requestPayload['kategori'] = $json['kategori'];
        }
        if (!empty($json['jenis'])) {
            $requestPayload['group'] = $json['jenis'];
        }

        $url      = "{$this->server5}/api/Items/datatable";
        $response = akses_restapikey('POST', $url, $requestPayload, []);
        $body     = json_decode($response, true);

        if (!isset($body['data']) || !is_array($body['data'])) {
            log_message('error', 'Tindakan Datatables invalid response: ' . $response);
            return $this->response->setJSON([
                'draw'            => $requestPayload['draw'] ?? 1,
                'recordsTotal'    => 0,
                'recordsFiltered' => 0,
                'data'            => [],
            ]);
        }

        $rows = $body['data'];

        foreach ($rows as $idx => &$row) {
            $id = $row['itemId'];

            $row['rownum'] = $idx + ($requestPayload['start'] ?? 0) + 1;
            $row['checkbox'] = '<div class="icheck-primary d-inline"><input type="checkbox" id="chk_' . $id . '" class="row-chk"><label for="chk_' . $id . '"></label></div>';
            $row['kodeLink'] = '<a href="#" class="kode-link" data-id="' . $id . '" data-code="' . $row['itemCode'] . '">' . $row['itemCode'] . '</a>';
            $row['nama'] = $row['itemName'] ?? '-';
            $row['kategori'] = $row['categoryName'] ?? '-';
            $row['jenis'] = $row['groupName'] ?? '-';
            $row['durasi'] = $row['durationMinutes'] ?? '-';

            $hargaMulai = $row['defaultSellingPrice'] ?? $row['minPrice'] ?? null;
            $row['hargaFormat'] = $hargaMulai ? 'Rp ' . number_format($hargaMulai, 0, ',', '.') : '-';

            $row['statusBadge'] = !empty($row['isActive'])
                ? '<span class="badge-tnd-aktif">Aktif</span>'
                : '<span class="badge-tnd-nonaktif">Non Aktif</span>';

            $row['aksi'] = '
            <div class="aksi-cell">
                <button type="button" class="btn-icon-tnd view" data-id="' . $id . '" data-code="' . $row['itemCode'] . '" title="Lihat"><i class="fas fa-eye"></i></button>
                <button type="button" class="btn-icon-tnd edit" data-id="' . $id . '" data-code="' . $row['itemCode'] . '" title="Edit"><i class="fas fa-pencil-alt"></i></button>
                <button type="button" class="btn-icon-tnd delete" data-code="' . $row['itemCode'] . '" title="Hapus"><i class="fas fa-trash"></i></button>
            </div>';
        }

        $recordsTotal    = $body['recordsTotal']    ?? $body['totalRecords']    ?? $body['total']    ?? count($rows);
        $recordsFiltered = $body['recordsFiltered'] ?? $body['filteredRecords'] ?? $body['totalFiltered'] ?? $recordsTotal;

        return $this->response->setJSON([
            'draw'            => (int) ($requestPayload['draw'] ?? 1),
            'recordsTotal'    => (int) $recordsTotal,
            'recordsFiltered' => (int) $recordsFiltered,
            'data'            => $rows,
        ]);
    }

    public function action()
    {
        if (!$this->request->isAJAX() || !$this->request->getVar('action')) {
            exit('Maaf tidak dapat diproses!');
        }

        helper(['form', 'url', 'restclient']);

        $errors = [];
        if (empty(trim($this->request->getVar('inp_nama') ?? ''))) {
            $errors['inp_nama'] = 'Nama Tindakan harus diisi';
        }
        if (empty(trim($this->request->getVar('inp_kategori') ?? ''))) {
            $errors['inp_kategori'] = 'Kategori Tindakan harus dipilih';
        }
        if (empty(trim($this->request->getVar('inp_jenis') ?? ''))) {
            $errors['inp_jenis'] = 'Jenis Tindakan harus dipilih';
        }
        if (!empty($errors)) {
            return $this->response->setJSON(['error' => $errors]);
        }

        $empCd = $this->session->get('fullname') ?? '';

        $itemCategoryId = trim($this->request->getVar('inp_kategori'));
        $itemGroupId    = trim($this->request->getVar('inp_jenis'));
        $baseUomId      = trim($this->request->getVar('inp_satuan'));

        $body = [
            'itemName'                => trim($this->request->getVar('inp_nama')),
            'itemCategoryId'          => $itemCategoryId,
            'itemGroupId'             => $itemGroupId,
            'itemType'                => 'SERVICE',
            'baseUomId'               => $baseUomId,
            'isStockItem'             => false,
            'isSaleItem'              => true,
            'isPurchaseItem'          => false,
            'isBatchTracked'          => false,
            'isExpiredTracked'        => false,
            'isPrescriptionRequired'  => false,
            'isActive'                => $this->request->getVar('inp_status') === '1',
        ];

        $itemCode = trim($this->request->getVar('inp_kode') ?? '');
        if ($itemCode !== '') {
            $body['itemCode'] = $itemCode;
        }

        $notes = trim($this->request->getVar('inp_deskripsi') ?? '');
        if ($notes !== '') {
            $body['notes'] = $notes;
        }

        $itemCodeEdit = $this->request->getVar('hidden_code');

        if ($this->request->getVar('action') === 'Add') {
            $body['createdBy'] = $empCd;
            $url = "{$this->server5}/api/Items";

            log_message('debug', 'Tindakan Add Request: ' . json_encode($body));
            $result = akses_restapikey('POST', $url, $body, []);
            $result = is_string($result) ? json_decode($result, true) : $result;
            log_message('debug', 'Tindakan Add Response: ' . json_encode($result));

            if (isset($result['success']) && $result['success'] === true) {
                $created = $result['data'] ?? [];
                return $this->response->setJSON([
                    'status'    => 'success',
                    'message'   => 'Data Tindakan berhasil ditambahkan',
                    'itemCode'  => $created['itemCode'] ?? $body['itemCode'],
                    'itemId'    => $created['itemId']   ?? null,
                    'baseUomId' => $created['baseUomId'] ?? $baseUomId,
                ]);
            }

            return $this->response->setJSON([
                'status'  => 'error',
                'message' => $result['message'] ?? 'Gagal menambahkan data',
                'errors'  => $result['errors'] ?? null,
            ]);
        }

        if ($this->request->getVar('action') === 'Edit') {
            $body['updatedBy'] = $empCd;
            $url = "{$this->server5}/api/Items/{$itemCodeEdit}";

            log_message('debug', 'Tindakan Edit Request: ' . json_encode($body));
            $result = akses_restapikey('PUT', $url, $body, []);
            $result = is_string($result) ? json_decode($result, true) : $result;
            log_message('debug', 'Tindakan Edit Response: ' . json_encode($result));

            if (isset($result['success']) && $result['success'] === true) {
                $updated = $result['data'] ?? [];
                return $this->response->setJSON([
                    'status'    => 'success',
                    'message'   => 'Data Tindakan berhasil diubah',
                    'itemCode'  => $itemCodeEdit,
                    'baseUomId' => $updated['baseUomId'] ?? $baseUomId,
                ]);
            }

            return $this->response->setJSON([
                'status'  => 'error',
                'message' => $result['message'] ?? 'Gagal mengubah data',
                'errors'  => $result['errors'] ?? null,
            ]);
        }
    }

    public function delete()
    {
        if (!$this->request->isAJAX()) return;

        $itemCode = $this->request->getVar('itemCode');
        helper(['restclient']);
        $url    = "{$this->server5}/api/Items/{$itemCode}";
        $result = akses_restapikey('DELETE', $url, [], []);
        $result = is_string($result) ? json_decode($result, true) : $result;

        if (isset($result['success']) && $result['success'] === true) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => $result['message'] ?? 'Data Tindakan berhasil dihapus',
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
        $search  = $this->request->getVar('q') ?? '';
        $jenis   = $this->request->getVar('jenis') ?? '';
        $url     = "{$this->server5}/api/Items/all?search=" . urlencode($search) . ($jenis ? '&itemType=' . urlencode($jenis) : '');
        $response = akses_restapikey('GET', $url, [], []);
        $result   = json_decode($response, true);

        $list = [];
        foreach (($result['data'] ?? []) as $row) {
            $list[] = [
                'kode'   => $row['itemCode'] ?? '',
                'nama'   => $row['itemName'] ?? '',
                'tipe'   => $row['itemType'] ?? '',
                'uomId'  => $row['baseUomId'] ?? '',
                'satuan' => $row['uomCode']   ?? '',
            ];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $list,
        ]);
    }

    public function getHarga($itemCode)
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
                'kelas'         => $row['priceClassCode']  ?? '',
                'mataUang'      => $row['currencyCode']    ?? 'IDR',
                'hargaJual'     => $row['sellingPrice']    ?? 0,
                'berlakuMulai'  => $row['effectiveDate']   ?? null,
                'berlakuSampai' => $row['expiredDate']     ?? null,
                'aktif'         => $row['isActive']        ?? true,
            ];
        }

        return $this->response->setJSON(['status' => 'success', 'data' => $list]);
    }

    public function saveHarga($itemCode)
    {
        helper(['restclient']);
        $empCd   = $this->session->get('fullname') ?? '';
        $priceId = $this->request->getVar('price_id');

        $priceClassId = trim($this->request->getVar('kelasHargaId') ?? '');
        $uomId        = trim($this->request->getVar('uomId') ?? '');

        if (!$priceClassId) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Kelas harga wajib dipilih.',
            ]);
        }
        if (!$uomId) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Satuan (UOM) tindakan belum diatur. Lengkapi Satuan/Unit pada Step 1 terlebih dahulu.',
            ]);
        }

        $currencyCode = trim($this->request->getVar('mataUang') ?? '') ?: 'IDR';
        $currencyCode = strtoupper(substr($currencyCode, 0, 3));

        $body = [
            'priceClassId'  => $priceClassId,
            'uomId'         => $uomId,
            'currencyCode'  => $currencyCode,
            'sellingPrice'  => (int) $this->request->getVar('hargaJual'),
            'effectiveDate' => trim($this->request->getVar('berlakuMulai') ?? ''),
            'expiredDate'   => trim($this->request->getVar('berlakuSampai') ?? '') ?: null,
            'isActive'      => $this->request->getVar('status') === '1',
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
        log_message('debug', 'Tindakan SaveHarga Response: ' . json_encode($result));

        return $this->response->setJSON([
            'status'  => (isset($result['success']) && $result['success']) ? 'success' : 'error',
            'message' => (isset($result['success']) && $result['success'])
                ? 'Harga berhasil disimpan'
                : ($result['message'] ?? 'Gagal menyimpan harga'),
            'errors'  => $result['errors'] ?? null,
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

    public function getKebutuhan($itemCode)
    {
        helper(['restclient']);
        $url      = "{$this->server5}/api/Items/{$itemCode}/package-components";
        $response = akses_restapikey('GET', $url, [], []);
        $result   = json_decode($response, true);

        $data = $result['data'] ?? [];
        $list = [];
        foreach ($data as $row) {
            $list[] = [
                'id'         => $row['packageComponentId'] ?? null,
                'kode'       => $row['componentItemCode']   ?? '',
                'nama'       => $row['componentItemName']   ?? '',
                'jenis'      => $row['componentItemType']   ?? '-',
                'satuan'     => $row['uomCode']              ?? '',
                'qty'        => $row['qty']                  ?? 0,
                'keterangan' => $row['notes']                ?? '-',
                'aktif'      => $row['isActive']             ?? true,
            ];
        }

        return $this->response->setJSON(['status' => 'success', 'data' => $list]);
    }

    public function saveKebutuhan($itemCode)
    {
        helper(['restclient']);
        $empCd = $this->session->get('fullname') ?? '';
        $componentId = $this->request->getVar('component_id');

        $componentItemCode = trim($this->request->getVar('itemCode') ?? '');
        $satuanId          = trim($this->request->getVar('satuanId') ?? '');

        if (!$componentItemCode) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Item kebutuhan wajib dipilih.',
            ]);
        }
        if (!$satuanId) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Satuan item kebutuhan tidak ditemukan.',
            ]);
        }

        $body = [
            'componentItemCode'   => $componentItemCode,
            'uomId'               => $satuanId,
            'qty'                 => (float) $this->request->getVar('kuantitas'),
            'isOptional'          => false,
            'isChargedSeparately' => false,
            'isStockDeducted'     => true,
            'sortNo'              => 0,
            'isActive'            => true,
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
        log_message('debug', 'Tindakan SaveKebutuhan Response: ' . json_encode($result));

        return $this->response->setJSON([
            'status'  => (isset($result['success']) && $result['success']) ? 'success' : 'error',
            'message' => (isset($result['success']) && $result['success'])
                ? 'Kebutuhan berhasil disimpan'
                : ($result['message'] ?? 'Gagal menyimpan kebutuhan'),
            'errors'  => $result['errors'] ?? null,
        ]);
    }

    public function deleteKebutuhan($itemCode, $componentId)
    {
        helper(['restclient']);
        $url    = "{$this->server5}/api/Items/{$itemCode}/package-components/{$componentId}";
        $result = akses_restapikey('DELETE', $url, [], []);
        $result = is_string($result) ? json_decode($result, true) : $result;

        return $this->response->setJSON([
            'status'  => (isset($result['success']) && $result['success']) ? 'success' : 'error',
            'message' => (isset($result['success']) && $result['success'])
                ? 'Kebutuhan berhasil dihapus'
                : ($result['message'] ?? 'Gagal menghapus kebutuhan'),
        ]);
    }

    public function fetchSingleData()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Request bukan AJAX']);
        }
        $itemCode = $this->request->getVar('itemCode');
        if (!$itemCode) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'itemCode tidak ditemukan']);
        }

        helper(['restclient']);
        $url      = "{$this->server5}/api/Items/{$itemCode}";
        $response = akses_restapikey('GET', $url, [], []);
        $result   = json_decode($response, true);

        if (!isset($result['data'])) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        }
        $d = $result['data'];

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => [
                'itemCode'    => $d['itemCode']     ?? '',
                'itemName'    => $d['itemName']     ?? '',
                'categoryId'  => $d['itemCategoryId'] ?? '',
                'categoryName'=> $d['categoryName']  ?? '',
                'groupId'     => $d['itemGroupId']   ?? '',
                'groupName'   => $d['groupName']     ?? '',
                'baseUomId'   => $d['baseUomId']     ?? '',
                'isActive'    => $d['isActive']      ?? true,
                'notes'       => $d['notes']         ?? '',
                'createdBy'   => $d['createdBy']     ?? '',
                'createdDate' => $d['createdDate']   ?? '',
                'updatedBy'   => $d['updatedBy']     ?? '',
                'updatedDate' => $d['updatedDate']   ?? '',
            ]
        ]);
    }

    public function getSummary()
    {
        helper(['restclient']);

        $payloadAll = [
            'draw'    => 1,
            'start'   => 0,
            'length'  => 0,
            'itemType'=> 'SERVICE',
            'search'  => ['value' => '', 'regex' => false],
            'columns' => [],
            'order'   => [],
        ];
        $urlAll      = "{$this->server5}/api/Items/datatable";
        $resAll      = akses_restapikey('POST', $urlAll, $payloadAll, []);
        $bodyAll     = json_decode($resAll, true);
        $totalAll    = (int) ($bodyAll['recordsTotal'] ?? $bodyAll['totalRecords'] ?? $bodyAll['total'] ?? 0);

        $payloadActive = $payloadAll;
        $payloadActive['isActive'] = true;
        $resActive     = akses_restapikey('POST', $urlAll, $payloadActive, []);
        $bodyActive    = json_decode($resActive, true);
        $totalActive   = (int) ($bodyActive['recordsFiltered'] ?? $bodyActive['filteredRecords'] ?? $bodyActive['totalFiltered'] ?? 0);
        $rowsActive    = $bodyActive['data'] ?? [];

        $totalHarga  = 0;
        $countHarga  = 0;
        $totalDurasi = 0;
        $countDurasi = 0;
        $katCount    = [];

        if (!empty($rowsActive)) {
            foreach ($rowsActive as $row) {
                $harga = (float) ($row['minPrice'] ?? $row['sellingPrice'] ?? 0);
                if ($harga > 0) {
                    $totalHarga += $harga;
                    $countHarga++;
                }
                $durasi = (int) ($row['durationMinutes'] ?? 0);
                if ($durasi > 0) {
                    $totalDurasi += $durasi;
                    $countDurasi++;
                }
                $kat = $row['categoryName'] ?? '-';
                $katCount[$kat] = ($katCount[$kat] ?? 0) + 1;
            }
        }

        $avgHarga  = $countHarga > 0 ? round($totalHarga / $countHarga) : 0;
        $avgDurasi = $countDurasi > 0 ? round($totalDurasi / $countDurasi) : 0;
        $pctActive = $totalAll > 0 ? round($totalActive / $totalAll * 100, 1) : 0;

        arsort($katCount);
        $kategori = [];
        foreach (array_slice($katCount, 0, 4, true) as $kat => $cnt) {
            $pct = $totalActive > 0 ? round($cnt / $totalActive * 100, 1) : 0;
            $kategori[] = ['nama' => $kat, 'jumlah' => $cnt, 'persen' => $pct];
        }

        return $this->response->setJSON([
            'status'      => 'success',
            'total'       => $totalAll,
            'aktif'       => $totalActive,
            'pctAktif'    => $pctActive,
            'avgHarga'    => $avgHarga,
            'avgDurasi'   => $avgDurasi,
            'kategori'    => $kategori,
        ]);
    }

    public function download() { }
    public function upload() { }
    public function preview() { }
}