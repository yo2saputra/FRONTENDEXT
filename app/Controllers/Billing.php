<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Billing extends BaseController
{
    protected $data;
    protected $server5;

    public function __construct()
    {
        $this->server5 = $_ENV['APP_API5'];
    }

    public function index()
    {
        return view('billing/index', $this->data);
    }

    public function datatables()
    {
        helper(['restclient']);
        $rawBody = $this->request->getBody();
        $json    = json_decode($rawBody, true);

        $url      = "{$this->server5}/api/Billing/datatable";
        $response = akses_restapikey('POST', $url, $json);
        $result   = json_decode($response, true);

        if (!isset($result['data']) || !is_array($result['data'])) {
            log_message('error', 'Billing Datatables invalid response: ' . $response);
            return $this->response->setJSON([
                'draw'            => $json['draw'] ?? 1,
                'recordsTotal'    => 0,
                'recordsFiltered' => 0,
                'data'            => []
            ]);
        }

        foreach ($result['data'] as $i => &$row) {
            $row['rownum'] = $i + ($json['start'] ?? 0) + 1;

            $canVoid = isset($row['canVoid']) && $row['canVoid'] === true;
            $paymentStatus = $row['paymentStatus'] ?? '';

            $row['aksi'] = '
            <div class="btn-group btn-group-sm">
                <a class="btn btn-sm btn-info view" data-id="' . $row['noKwitansi'] . '" title="Lihat Detail">
                    <i class="fas fa-eye"></i>
                </a>
                <a class="btn btn-sm btn-success print" data-id="' . $row['noKwitansi'] . '" title="Cetak Kwitansi">
                    <i class="fas fa-print"></i>
                </a>
                <a class="btn btn-sm btn-danger void ' . ($canVoid ? '' : 'd-none') . '" 
                   data-id="' . $row['noKwitansi'] . '" 
                   data-status="' . $paymentStatus . '"
                   title="Void/Batal">
                    <i class="fas fa-times"></i>
                </a>
            </div>';

            // Format tanggal untuk display
            if (!empty($row['tglKwitansi'])) {
                $date = new \DateTime($row['tglKwitansi']);
                $row['tglKwitansiDisplay'] = $date->format('d M Y H:i');
            } else {
                $row['tglKwitansiDisplay'] = '-';
            }

            // Format total tagihan
            $row['totalTagihanDisplay'] = isset($row['totalTagihan'])
                ? 'Rp ' . number_format($row['totalTagihan'], 0, ',', '.')
                : 'Rp 0';

            // Status badge
            $statusClass = match ($row['paymentStatus'] ?? '') {
                'lunas' => 'badge-success',
                'belum_bayar' => 'badge-warning',
                'lebih_bayar' => 'badge-info',
                'void' => 'badge-danger',
                default => 'badge-secondary'
            };
            $statusLabel = match ($row['paymentStatus'] ?? '') {
                'lunas' => 'Lunas',
                'belum_bayar' => 'Belum Bayar',
                'lebih_bayar' => 'Lebih Bayar',
                'void' => 'Batal',
                default => ucfirst($row['paymentStatus'] ?? '-')
            };
            $row['paymentStatusBadge'] = '<span class="badge ' . $statusClass . '">' . $statusLabel . '</span>';
        }

        return $this->response->setJSON($result);
    }

    public function search()
    {
        if ($this->request->isAJAX()) {
            helper(['restclient']);

            $startDate = $this->request->getVar('startDate');
            $endDate = $this->request->getVar('endDate');
            $paymentStatus = $this->request->getVar('paymentStatus');
            $paymentMethod = $this->request->getVar('paymentMethod');
            $search = $this->request->getVar('search');
            $noRegistrasi = $this->request->getVar('noRegistrasi');
            $namaPasien = $this->request->getVar('namaPasien');
            $pageNumber = (int) ($this->request->getVar('pageNumber') ?? 1);
            $pageSize = (int) ($this->request->getVar('pageSize') ?? 10);
            $sortBy = $this->request->getVar('sortBy') ?? 'tglKwitansi';
            $sortDirection = $this->request->getVar('sortDirection') ?? 'DESC';

            $body = [
                'startDate' => $startDate,
                'endDate' => $endDate,
                'paymentStatus' => $paymentStatus,
                'paymentMethod' => $paymentMethod,
                'search' => $search,
                'noRegistrasi' => $noRegistrasi,
                'namaPasien' => $namaPasien,
                'pageNumber' => $pageNumber,
                'pageSize' => $pageSize,
                'sortBy' => $sortBy,
                'sortDirection' => $sortDirection
            ];

            $url = "{$this->server5}/api/Billing/search";
            $response = akses_restapikey('POST', $url, $body);
            $result = json_decode($response, true);

            if (!isset($result['data']) || !is_array($result['data'])) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan',
                    'data' => []
                ]);
            }

            return $this->response->setJSON([
                'status' => 'success',
                'data' => $result['data']
            ]);
        }
    }

    public function detail()
    {
        if ($this->request->isAJAX()) {
            $noKwitansi = $this->request->getVar('noKwitansi');

            if (empty($noKwitansi)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'No Kwitansi tidak ditemukan'
                ]);
            }

            helper(['restclient']);

            $url = "{$this->server5}/api/Billing/{$noKwitansi}";
            $response = akses_restapikey('GET', $url, [], []);
            $result = json_decode($response, true);

            if (!isset($result['data']) || empty($result['data'])) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan'
                ]);
            }

            $data = $result['data'];

            // Format data untuk UI
            $tanggal = !empty($data['tglKwitansi'])
                ? date('d F Y, H:i', strtotime($data['tglKwitansi'])) . ' WIB'
                : '-';

            $totalTagihan = isset($data['totalTagihan'])
                ? 'Rp ' . number_format($data['totalTagihan'], 0, ',', '.')
                : 'Rp 0';

            $totalDibayar = isset($data['totalDibayar'])
                ? 'Rp ' . number_format($data['totalDibayar'], 0, ',', '.')
                : 'Rp 0';

            $changeAmount = isset($data['changeAmount'])
                ? 'Rp ' . number_format($data['changeAmount'], 0, ',', '.')
                : 'Rp 0';

            // Cara Bayar
            $caraBayar = [];
            if (!empty($data['paymentMethods'])) {
                foreach ($data['paymentMethods'] as $pm) {
                    $caraBayar[] = $pm['jenisPembayaranNm'] ?? 'Unknown';
                }
            }
            $caraBayarText = !empty($caraBayar) ? implode(' + ', $caraBayar) : '-';

            // Petugas
            $petugas = $data['kasirName'] ?? '-';
            if (!empty($data['empCd'])) {
                $petugas .= ' (Kasir)';
            }

            // Can Void
            $canVoid = isset($data['canVoid']) ? $data['canVoid'] : false;

            $responseData = [
                'noKwitansi' => $data['noKwitansi'] ?? '',
                'noRegistrasi' => $data['noRegistrasi'] ?? '',
                'noPasien' => $data['noPasien'] ?? '',
                'namaPasien' => $data['namaPasien'] ?? '',
                'tanggal' => $tanggal,
                'paymentStatus' => $data['paymentStatus'] ?? '',
                'statusKwitansi' => $data['statusKwitansi'] ?? '',
                'totalTagihan' => $totalTagihan,
                'totalTagihanRaw' => $data['totalTagihan'] ?? 0,
                'totalDibayar' => $totalDibayar,
                'changeAmount' => $changeAmount,
                'caraBayar' => $caraBayarText,
                'petugas' => $petugas,
                'kasirName' => $data['kasirName'] ?? '',
                'canVoid' => $canVoid,
                'details' => $data['details'] ?? [],
                'paymentMethods' => $data['paymentMethods'] ?? []
            ];

            return $this->response->setJSON([
                'status' => 'success',
                'data' => $responseData
            ]);
        }
    }

    public function printReceipt()
    {
        if ($this->request->isAJAX()) {
            $noKwitansi = $this->request->getVar('noKwitansi');
            $printType = $this->request->getVar('printType') ?? 'KWITANSI';

            if (empty($noKwitansi)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'No Kwitansi tidak ditemukan'
                ]);
            }

            helper(['restclient']);

            $body = [
                'noKwitansi' => $noKwitansi,
                'reprintType' => $printType
            ];

            $url = "{$this->server5}/api/Billing/reprint";
            $response = akses_restapikey('POST', $url, $body);
            $result = json_decode($response, true);

            if (isset($result['success']) && $result['success'] === true) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Kwitansi berhasil dicetak ulang',
                    'data' => $result['data'] ?? null
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $result['message'] ?? 'Gagal mencetak ulang kwitansi'
                ]);
            }
        }
    }

    public function void()
    {
        if ($this->request->isAJAX()) {
            $noKwitansi = $this->request->getVar('noKwitansi');
            $reason = $this->request->getVar('reason');
            $approvedBy = $this->request->getVar('approvedBy');

            if (empty($noKwitansi)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'No Kwitansi tidak ditemukan'
                ]);
            }

            if (empty($reason)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Alasan void harus diisi'
                ]);
            }

            helper(['restclient']);

            $body = [
                'noKwitansi' => $noKwitansi,
                'reason' => $reason,
                'approvedBy' => $approvedBy
            ];

            $url = "{$this->server5}/api/Billing/void";
            $response = akses_restapikey('POST', $url, $body);
            $result = json_decode($response, true);

            if (isset($result['success']) && $result['success'] === true) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Transaksi berhasil dibatalkan (void)'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $result['message'] ?? 'Gagal melakukan void transaksi'
                ]);
            }
        }
    }

    public function canVoid()
    {
        if ($this->request->isAJAX()) {
            $noKwitansi = $this->request->getVar('noKwitansi');

            if (empty($noKwitansi)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'No Kwitansi tidak ditemukan'
                ]);
            }

            helper(['restclient']);

            $url = "{$this->server5}/api/Billing/can-void/{$noKwitansi}";
            $response = akses_restapikey('GET', $url, [], []);
            $result = json_decode($response, true);

            if (isset($result['data'])) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'data' => $result['data']
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $result['message'] ?? 'Gagal mengecek status void'
                ]);
            }
        }
    }

    public function shiftSummary()
    {
        if ($this->request->isAJAX()) {
            $shiftStart = $this->request->getVar('shiftStart');
            $shiftEnd = $this->request->getVar('shiftEnd');
            $kasirId = $this->request->getVar('kasirId');

            if (empty($shiftStart) || empty($shiftEnd)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Tanggal shift harus diisi'
                ]);
            }

            helper(['restclient']);

            $url = "{$this->server5}/api/Billing/shift-summary";
            $params = [
                'shiftStart' => $shiftStart,
                'shiftEnd' => $shiftEnd,
                'kasirId' => $kasirId
            ];

            $response = akses_restapikey('GET', $url, [], $params);
            $result = json_decode($response, true);

            if (isset($result['data'])) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'data' => $result['data']
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $result['message'] ?? 'Gagal mengambil data shift'
                ]);
            }
        }
    }

    public function filterOptions()
    {
        if ($this->request->isAJAX()) {
            helper(['restclient']);

            $url = "{$this->server5}/api/Billing/filter-options";
            $response = akses_restapikey('GET', $url, [], []);
            $result = json_decode($response, true);

            if (isset($result['data'])) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'data' => $result['data']
                ]);
            } else {
                // Fallback data if API not available
                return $this->response->setJSON([
                    'status' => 'success',
                    'data' => [
                        'paymentStatuses' => ['lunas', 'belum_bayar', 'lebih_bayar', 'void'],
                        'paymentMethods' => [
                            ['jenisPembayaranId' => 1, 'jenisPembayaranNm' => 'Tunai'],
                            ['jenisPembayaranId' => 2, 'jenisPembayaranNm' => 'E-Wallet / QRIS'],
                            ['jenisPembayaranId' => 3, 'jenisPembayaranNm' => 'Transfer Bank'],
                            ['jenisPembayaranId' => 4, 'jenisPembayaranNm' => 'Kartu Debit / Kredit (EDC)'],
                            ['jenisPembayaranId' => 5, 'jenisPembayaranNm' => 'Asuransi / Corporate'],
                            ['jenisPembayaranId' => 6, 'jenisPembayaranNm' => 'Deposit Pasien'],
                            ['jenisPembayaranId' => 7, 'jenisPembayaranNm' => 'Voucher / Potongan']
                        ]
                    ]
                ]);
            }
        }
    }
}
