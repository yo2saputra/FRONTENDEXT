<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Listbilling extends BaseController
{
    protected $data;
    protected $server5;

    public function __construct()
    {
        $this->server5 = $_ENV['APP_API5'] ?? '';
    }

    public function index()
    {
        return view('listbilling/index', $this->data);
    }

    // ============================================================
    // DROPDOWN / FILTER OPTIONS
    // ============================================================

    public function fetchFilterOptions()
    {
        helper(['restclient']);
        $url      = "{$this->server5}/api/Billing/filter-options";
        $response = akses_restapikey('GET', $url, [], []);
        $result   = json_decode($response, true);

        $paymentStatuses = $result['paymentStatuses'] ?? [];
        $paymentMethods  = $result['paymentMethods']  ?? [];

        $methodList = [];
        foreach ($paymentMethods as $m) {
            $methodList[] = [
                'id'   => $m['jenisPembayaranId'] ?? '',
                'text' => $m['jenisPembayaranNm'] ?? '',
            ];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => [
                'paymentStatuses' => $paymentStatuses,
                'paymentMethods'  => $methodList,
            ],
        ]);
    }

    public function fetchKasirList()
    {
        helper(['restclient']);
        $url      = "{$this->server5}/api/Billing/kasir-list";
        $response = akses_restapikey('GET', $url, [], []);
        $result   = json_decode($response, true);

        $rows = $result['data'] ?? $result ?? [];
        $list = [];
        foreach ($rows as $row) {
            if (empty($row['isActive'])) continue;
            $list[] = ['id' => $row['empCd'] ?? '', 'text' => $row['fullName'] ?? ''];
        }

        return $this->response->setJSON(['status' => 'success', 'data' => $list]);
    }

    // ============================================================
    // DATATABLE
    // ============================================================

    public function datatables()
    {
        helper(['restclient']);
        $rawBody = $this->request->getBody();
        $json    = json_decode($rawBody, true) ?? [];

        $requestPayload = [
            'draw'    => $json['draw']   ?? 1,
            'start'   => $json['start']  ?? 0,
            'length'  => $json['length'] ?? 10,
            'search'  => [
                'value' => $json['cari'] ?? '',
                'regex' => false,
            ],
            'columns' => $json['columns'] ?? [],
            'order'   => $json['order']   ?? [],
        ];

        // Filter tambahan - nempel langsung ke payload, mengikuti pola yang sudah
        // terbukti jalan di modul Tindakan (itemType/status/kategori/group).
        if (!empty($json['startDate'])) {
            $requestPayload['startDate'] = $json['startDate'];
        }
        // $requestPayload['startDate'] = '2026-07-30';
        if (!empty($json['endDate'])) {
            $requestPayload['endDate'] = $json['endDate'];
        }
        // $requestPayload['endDate'] = '2026-07-31';
        if (!empty($json['paymentStatus'])) {
            $requestPayload['paymentStatus'] = $json['paymentStatus'];
        }
        if (!empty($json['kasirId'])) {
            $requestPayload['kasirId'] = $json['kasirId'];
        }
        if (!empty($json['noRegistrasi'])) {
            $requestPayload['noRegistrasi'] = $json['noRegistrasi'];
        }
        if (!empty($json['namaPasien'])) {
            $requestPayload['namaPasien'] = $json['namaPasien'];
        }

        $url      = "{$this->server5}/api/Billing/datatable";
        $response = akses_restapikey('POST', $url, $requestPayload, []);
        $body     = json_decode($response, true);

        if (!isset($body['data']) || !is_array($body['data'])) {
            log_message('error', 'Billing Datatables invalid response: ' . $response);
            return $this->response->setJSON([
                'draw'            => $requestPayload['draw'] ?? 1,
                'recordsTotal'    => 0,
                'recordsFiltered' => 0,
                'data'            => [],
            ]);
        }

        $rows = $body['data'];

        foreach ($rows as $idx => &$row) {
            $noKwitansi = $row['NoKwitansi'] ?? '';

            $row['rownum']       = $idx + ($requestPayload['start'] ?? 0) + 1;
            $row['kwitansiLink'] = '<a href="#" class="kwitansi-link" data-nokwitansi="' . $noKwitansi . '">' . $noKwitansi . '</a>';

            $tgl = $row['TglKwitansi'] ?? null;
            $row['tglFormat'] = $tgl ? date('d M Y, H:i', strtotime($tgl)) . ' WIB' : '-';

            $row['totalTagihanFormat'] = 'Rp ' . number_format((float) ($row['TotalTagihan'] ?? 0), 0, ',', '.');
            $row['totalDibayarFormat'] = 'Rp ' . number_format((float) ($row['TotalDibayar'] ?? 0), 0, ',', '.');

            $paymentStatus = $row['PaymentStatus'] ?? '';
            $badgeMap = [
                'lunas'       => '<span class="badge-bil-lunas">Lunas</span>',
                'belum_bayar' => '<span class="badge-bil-belum">Belum Bayar</span>',
                'lebih_bayar' => '<span class="badge-bil-lebih">Lebih Bayar</span>',
            ];
            $row['paymentStatusBadge'] = $badgeMap[$paymentStatus] ?? '<span class="badge-bil-belum">' . esc($paymentStatus) . '</span>';

            $statusKwitansi = $row['StatusKwitansi'] ?? '';
            $row['statusKwitansiBadge'] = strtolower($statusKwitansi) === 'aktif'
                ? '<span class="badge-bil-aktif">Aktif</span>'
                : '<span class="badge-bil-batal">' . esc($statusKwitansi ?: '-') . '</span>';

            $canVoid = !empty($row['CanVoid']);
            $voidBtn = $canVoid
                ? '<button type="button" class="btn-icon-bil void" data-nokwitansi="' . $noKwitansi . '" title="Void"><i class="fas fa-ban"></i></button>'
                : '<button type="button" class="btn-icon-bil void disabled" disabled title="Tidak dapat di-void"><i class="fas fa-ban"></i></button>';

            $row['aksi'] = '
            <div class="aksi-cell">
                <button type="button" class="btn-icon-bil view" data-nokwitansi="' . $noKwitansi . '" title="Lihat Detail"><i class="fas fa-eye"></i></button>
                <button type="button" class="btn-icon-bil print" data-nokwitansi="' . $noKwitansi . '" title="Cetak Ulang Kwitansi"><i class="fas fa-print"></i></button>
                ' . $voidBtn . '
            </div>';
        }

        $recordsTotal    = $body['recordsTotal']    ?? count($rows);
        $recordsFiltered = $body['recordsFiltered'] ?? $recordsTotal;

        return $this->response->setJSON([
            'draw'            => (int) ($requestPayload['draw'] ?? 1),
            'recordsTotal'    => (int) $recordsTotal,
            'recordsFiltered' => (int) $recordsFiltered,
            'data'            => $rows,
        ]);
    }

    // ============================================================
    // DETAIL TRANSAKSI (modal)
    // ============================================================

    public function fetchSingleData($noKwitansi = null)
    {
        if (!$noKwitansi) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'No. Kwitansi tidak ditemukan']);
        }

        helper(['restclient']);
        $url      = "{$this->server5}/api/Billing/{$noKwitansi}";
        $response = akses_restapikey('GET', $url, [], []);
        $result   = json_decode($response, true);

        // Response bisa berupa object langsung atau dibungkus {"data": {...}}
        $d = $result['data'] ?? $result ?? null;

        if (!$d || empty($d['noKwitansi'])) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data transaksi tidak ditemukan']);
        }

        $details = [];
        foreach (($d['details'] ?? []) as $item) {
            $details[] = [
                'itemCd'    => $item['itemCd']    ?? '',
                'itemName'  => $item['itemName']  ?? '',
                'itemType'  => $item['itemType']  ?? '',
                'jumlah'    => $item['jumlah']    ?? 0,
                'tarif'     => $item['tarif']     ?? 0,
                'potongan'  => $item['potongan']  ?? 0,
                'pajak'     => $item['pajak']     ?? 0,
                'total'     => $item['total']     ?? 0,
            ];
        }

        $paymentMethods = [];
        foreach (($d['paymentMethods'] ?? []) as $pm) {
            $paymentMethods[] = [
                'jenisPembayaranNm' => $pm['jenisPembayaranNm'] ?? '',
                'amount'            => $pm['amount']            ?? 0,
                'isDeposit'         => $pm['isDeposit']         ?? false,
                'notes'             => $pm['notes']             ?? '',
            ];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => [
                'noKwitansi'    => $d['noKwitansi']    ?? '',
                'noRegistrasi'  => $d['noRegistrasi']  ?? '',
                'tglKwitansi'   => $d['tglKwitansi']   ?? '',
                'kasirName'     => $d['kasirName']     ?? '',
                'statusKwitansi' => $d['statusKwitansi'] ?? '',
                'paymentStatus' => $d['paymentStatus'] ?? '',
                'noPasien'      => $d['noPasien']      ?? '',
                'namaPasien'    => $d['namaPasien']    ?? '',
                'totalTagihan'  => $d['totalTagihan']  ?? 0,
                'totalDibayar'  => $d['totalDibayar']  ?? 0,
                'changeAmount'  => $d['changeAmount']  ?? 0,
                'paymentDate'   => $d['paymentDate']   ?? null,
                'canVoid'       => $d['canVoid']       ?? false,
                'details'       => $details,
                'paymentMethods' => $paymentMethods,
            ],
        ]);
    }

    // ============================================================
    // VOID
    // ============================================================

    public function fetchCanVoid($noKwitansi = null)
    {
        if (!$noKwitansi) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'No. Kwitansi tidak ditemukan']);
        }

        helper(['restclient']);
        $url      = "{$this->server5}/api/Billing/can-void/{$noKwitansi}";
        $response = akses_restapikey('GET', $url, [], []);
        $result   = json_decode($response, true);

        $d = $result['data'] ?? $result ?? [];

        return $this->response->setJSON([
            'status'  => 'success',
            'canVoid' => $d['canVoid'] ?? false,
            'reason'  => $d['reason']  ?? '',
        ]);
    }

    public function void()
    {
        if (!$this->request->isAJAX()) {
            exit('Maaf tidak dapat diproses!');
        }

        $noKwitansi = trim($this->request->getVar('noKwitansi') ?? '');
        $reason     = trim($this->request->getVar('reason') ?? '');
        $approvedBy = trim($this->request->getVar('approvedBy') ?? '');

        $errors = [];
        if (!$noKwitansi) $errors['noKwitansi'] = 'No. Kwitansi tidak valid';
        if (!$reason)     $errors['reason']     = 'Alasan void harus diisi';
        if (!$approvedBy) $errors['approvedBy'] = 'Approval supervisor harus diisi';
        if (!empty($errors)) {
            return $this->response->setJSON(['status' => 'error', 'errors' => $errors]);
        }

        helper(['restclient']);

        // Validasi ulang ke server sebelum eksekusi void, untuk menghindari race condition
        // (misal status transaksi berubah di antara load tabel dan klik tombol Void).
        $checkUrl = "{$this->server5}/api/Billing/validate-void/{$noKwitansi}";
        $checkRes = akses_restapikey('GET', $checkUrl, [], []);
        $checkRes = json_decode($checkRes, true);
        $checkData = $checkRes['data'] ?? $checkRes ?? [];

        if (empty($checkData['canVoid'])) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => $checkData['reason'] ?? 'Transaksi ini tidak dapat dibatalkan',
            ]);
        }

        $body = [
            'noKwitansi' => $noKwitansi,
            'reason'     => $reason,
            'approvedBy' => $approvedBy,
        ];

        $url    = "{$this->server5}/api/Billing/void";
        $result = akses_restapikey('POST', $url, $body, []);
        $result = is_string($result) ? json_decode($result, true) : $result;

        log_message('debug', 'Billing Void Response: ' . json_encode($result));

        if (isset($result['success']) && $result['success'] === true) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => $result['message'] ?? 'Transaksi berhasil dibatalkan',
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => $result['message'] ?? 'Gagal membatalkan transaksi',
            'errors'  => $result['errors'] ?? null,
        ]);
    }

    // ============================================================
    // REPRINT
    // ============================================================

    public function reprint()
    {
        if (!$this->request->isAJAX()) {
            exit('Maaf tidak dapat diproses!');
        }

        $noKwitansi  = trim($this->request->getVar('noKwitansi') ?? '');
        $reprintType = trim($this->request->getVar('reprintType') ?? 'KWITANSI');

        if (!$noKwitansi) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'No. Kwitansi tidak valid']);
        }

        helper(['restclient']);
        $body = [
            'noKwitansi'  => $noKwitansi,
            'reprintType' => $reprintType,
        ];

        $url    = "{$this->server5}/api/Billing/reprint";
        $raw    = akses_restapikey('POST', $url, $body, []);
        $result = is_string($raw) ? json_decode($raw, true) : $raw;

        log_message('debug', 'Billing Reprint Response: ' . json_encode($result));

        // Endpoint ini dipanggil untuk mencatat/audit reprint di server (misal menaikkan
        // reprint-count). Konten kwitansi/rincian yang ditampilkan & dicetak di browser
        // dibangun di sisi frontend dari data /api/Billing/{noKwitansi} yang sudah kita
        // punya, sehingga fitur cetak tidak bergantung pada bentuk response endpoint ini.
        // Response dianggap gagal HANYA jika secara eksplisit success === false, atau body
        // tidak bisa didecode sama sekali (indikasi request gagal total).
        if ($result === null && $raw !== null && $raw !== '') {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Gagal menghubungi server untuk mencatat cetak ulang',
            ]);
        }
        if (isset($result['success']) && $result['success'] === false) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => $result['message'] ?? 'Gagal mencetak ulang',
            ]);
        }

        // Ambil jumlah reprint terbaru (untuk ditampilkan sebagai info, opsional di UI)
        $countUrl  = "{$this->server5}/api/Billing/reprint-count/{$noKwitansi}";
        $countRaw  = akses_restapikey('GET', $countUrl, [], []);
        $countRes  = json_decode($countRaw, true);
        $countData = $countRes['data'] ?? $countRes ?? [];

        return $this->response->setJSON([
            'status'       => 'success',
            'message'      => $result['message'] ?? 'Cetak ulang berhasil dicatat',
            'reprintCount' => $countData['reprintCount'] ?? $countData['count'] ?? null,
        ]);
    }
}
