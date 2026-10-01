<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

class Resikojatuh extends BaseController
{
    protected $data;
    protected $server;
    protected $server3;

    public function __construct()
    {
        $this->session = session();
        $this->server  = $_ENV['APP_API'];
        $this->server3 = $_ENV['APP_API3'];
    }

    public function index()
    {
        $this->data['session_usr_id'] = (string)($this->session->get('usr_id') ?? '');
        $this->data['session_emp_nm'] = (string)($this->session->get('emp_nm') ?? $this->session->get('fullname') ?? '');
        return view('resikojatuh/index', $this->data);
    }

    public function delete()
    {
        $no_registrasi = $this->request->getVar('no_registrasi');
        helper(['restclient']);

        $url    = "{$this->server3}/api/resiko-jatuh/{$no_registrasi}";
        $result = akses_restapikey('DELETE', $url, []);

        if (empty($result) || $result === '' || $result === null) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Data berhasil dihapus']);
        }

        $result = is_string($result) ? json_decode($result, true) : $result;

        if (!empty($result) && (
            (isset($result['success']) && $result['success']) ||
            (isset($result['status']) && in_array($result['status'], ['success', 200, 201]))
        )) {
            return $this->response->setJSON(['status' => 'success', 'message' => $result['message'] ?? 'Data berhasil dihapus']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => $result['message'] ?? 'Gagal menghapus data']);
        }
    }

    public function setNoRegistrasi()
    {
        if ($this->request->isAJAX()) {
            $this->session->set([
                'no_registrasi' => $this->request->getVar('no_registrasi'),
                'patient_no'    => $this->request->getVar('patient_no'),
            ]);
            echo json_encode(['status' => 'success']);
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    private function apiDataGetByDokter(): array
    {
        $emp_cd = $this->session->get('emp_cd');
        helper(['restclient']);

        if ($this->session->get('role_cd') == 'ROLE002') {
            $url = "$this->server/tregistrasi/getbydokter/$emp_cd";
        } else {
            $url = "$this->server/tregistrasi/getbyperawat";
        }

        $response = akses_restapi('GET', $url, []);
        $decoded  = json_decode($response, true);
        return is_array($decoded) ? $decoded : [];
    }

    public function fetchAll()
    {
        $data   = $this->apiDataGetByDokter();
        $output = '
            <table id="example1" class="table table-sm table-striped" style="border-spacing: 0;">
                <thead><tr><th>Pasien</th><th>Hadir</th><th></th></tr></thead>
                <tbody>
        ';

        if (empty($data)) {
            $output .= '<tr><td colspan="3" class="text-center">Data tidak ditemukan</td></tr>';
        } else {
            foreach ($data as $row) {
                $btnClass = ($row['status'] === 'DT') ? 'btn-warning' : 'btn-info';
                $output .= '
                    <tr>
                        <td>' . htmlspecialchars($row['fullname']) . '</td>
                        <td>' . htmlspecialchars($row['hadir']) . '</td>
                        <td>
                            <button data-widget="control-sidebar" data-slide="true"
                                type="button"
                                class="btn ' . $btnClass . ' btn-sm float-right mr-1 mt-1 pilihpasien btn-fix-w"
                                data-no_registrasi="'          . $row['no_registrasi']                           . '"
                                data-patient_no="'             . $row['no_pasien']                               . '"
                                data-fullname="'               . htmlspecialchars($row['fullname'])               . '"
                                data-birth_dt="'               . $row['birth_dt']                                . '"
                                data-tahun="'                  . $row['tahun']                                   . '"
                                data-bulan="'                  . $row['bulan']                                   . '"
                                data-hari="'                   . $row['hari']                                    . '"
                                data-gender="'                 . $row['gender_desc']                             . '"
                                data-mobile_no="'              . $row['mobile_no']                               . '"
                                data-nama_dokter="'            . htmlspecialchars($row['nama_dokter'])            . '"
                                data-tujuan_registrasi_desc="' . htmlspecialchars($row['tujuan_registrasi_desc']) . '"
                                data-type_pasien="'            . $row['type_pasien']                             . '"
                                data-flag_alergi="'            . $row['flag_alergi']                             . '"
                            >Pilih</button>
                        </td>
                    </tr>
                ';
            }
        }

        $output .= '
                </tbody>
            </table>
            <script>
            $(function() {
                if ($.fn.DataTable.isDataTable("#example1")) { $("#example1").DataTable().destroy(); }
                $("#example1").DataTable({
                    columnDefs: [{ orderable: false, targets: 2 }],
                    paging: false, searching: false, info: false, autoWidth: false
                });
            });
            </script>
        ';

        echo $output;
    }

    public function fetchResikoByRegistrasi()
    {
        $no_registrasi = $this->request->getVar('no_registrasi');

        if (empty($no_registrasi)) {
            echo '<p class="text-muted text-center py-3">Pilih pasien untuk melihat data asesmen risiko jatuh.</p>';
            return;
        }

        helper(['restclient']);

        $url      = "{$this->server3}/api/resiko-jatuh/{$no_registrasi}";
        $response = akses_restapikey('GET', $url, []);
        $result   = json_decode($response, true);

        if (isset($result['data']) && is_array($result['data'])) {
            $row = isset($result['data'][0]) ? $result['data'][0] : $result['data'];
        } elseif (is_array($result) && !empty($result) && !isset($result['message'])) {
            $row = isset($result[0]) ? $result[0] : $result;
        } else {
            $row = [];
        }

        if (!empty($row) && isset($row['no_registrasi']) && $row['no_registrasi'] !== $no_registrasi) {
            $row = [];
        }

        $data = empty($row) ? [] : [$row];

        $tbl_wrap  = 'style="border:2px solid #333; width:100%; background-color:#fff; color:#333; border-collapse:collapse; table-layout:fixed;"';
        $th_style  = 'style="border:1px solid #333; background-color:#f4f6f9; color:#333; vertical-align:middle; padding:6px 8px; text-align:center;"';
        $td_click  = 'style="border:1px solid #333; background-color:#fff; color:#333; vertical-align:top; padding:6px 8px; cursor:pointer; word-break:break-word; overflow-wrap:break-word;" title="Klik untuk edit"';
        $td_center = 'style="border:1px solid #333; background-color:#fff; color:#333; vertical-align:top; text-align:center; padding:6px 8px;"';

        $output = '
            <table ' . $tbl_wrap . '>
                <thead style="text-align:center; border-bottom:2px solid #333;">
                    <tr>
                        <th ' . $th_style . ' style="width:12%;">Info</th>
                        <th ' . $th_style . ' style="width:38%;">Pengkajian</th>
                        <th ' . $th_style . ' style="width:22%;">Hasil</th>
                        <th ' . $th_style . ' style="width:20%;">Petugas</th>
                        <th ' . $th_style . ' style="width:8%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
        ';

        if (empty($data)) {
            $output .= '<tr><td colspan="5" style="border:1px solid #333; color:#777; text-align:center; padding:20px; font-style:italic;">Belum ada data asesmen risiko jatuh untuk pasien ini.</td></tr>';
        } else {
            $row        = $data[0];
            $no_reg_row = htmlspecialchars($row['no_registrasi'] ?? '');
            $row_data   = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');

            $fmt_dt = function($raw) {
                if (!$raw) return '-';
                try { return (new \DateTime($raw))->format('d/m/Y H:i'); }
                catch (\Exception $e) { return htmlspecialchars($raw); }
            };

            $created_by   = htmlspecialchars($row['created_by'] ?? '-');
            $created_at   = $fmt_dt($row['created_at'] ?? null);
            $updated_by   = $row['updated_by'] ?? null;
            $updated_at   = $row['updated_at'] ?? null;
            $show_updated = $updated_by && ($updated_at !== ($row['created_at'] ?? null));

            $info = '<small>'
                . '<span class="badge badge-secondary" style="font-size:0.65rem;">Dibuat</span><br>'
                . '<b>' . $created_by . '</b><br>'
                . '<span style="color:#666;">' . $created_at . '</span>';
            if ($show_updated) {
                $info .= '<br><span class="badge badge-info mt-1" style="font-size:0.65rem;">Diubah</span><br>'
                    . '<b>' . htmlspecialchars($updated_by) . '</b><br>'
                    . '<span style="color:#666;">' . $fmt_dt($updated_at) . '</span>';
            }
            $info .= '</small>';

            $col_pengkajian = '<small>'
                . '<b>a.1. Tidak seimbang/sempoyongan:</b> ' . htmlspecialchars($row['cara_berjalan']  ?? '-') . '<br>'
                . '<b>a.2. Jalan dengan alat bantu:</b> '     . htmlspecialchars($row['cara_berjalan2'] ?? '-') . '<br>'
                . '<b>b. Menopang duduk:</b> '                . htmlspecialchars($row['menopang_duduk'] ?? '-')
                . '</small>';

            $hasil_label = '-';
            if (($row['tidak_beresiko_hasil']  ?? '') === 'ya') $hasil_label = 'Tidak Berisiko';
            elseif (($row['beresiko_sedang_hasil']  ?? '') === 'ya') $hasil_label = 'Berisiko Sedang';
            elseif (($row['beresiko_tinggi_hasil']  ?? '') === 'ya') $hasil_label = 'Berisiko Tinggi';
            $col_hasil = '<small><b>Hasil:</b> ' . htmlspecialchars($hasil_label) . '</small>';

            $col_petugas = '<small>' . htmlspecialchars($row['usr_petugas'] ?? '-') . '</small>';

            $btn_delete = '<button type="button" class="btn btn-danger btn-sm delete"
                data-no_registrasi="' . $no_reg_row . '"
                title="Hapus"><i class="fas fa-trash"></i></button>';

            $output .= '
                <tr data-row="' . $row_data . '" data-no_registrasi="' . $no_reg_row . '">
                    <td style="border:1px solid #333; background-color:#fff; color:#333; vertical-align:top; padding:6px 8px;">' . $info . '</td>
                    <td ' . $td_click . ' class="clickable-col" data-section="pengkajian">' . $col_pengkajian . '</td>
                    <td style="border:1px solid #333; background-color:#f8f9fa; color:#333; vertical-align:top; padding:6px 8px; word-break:break-word; overflow-wrap:break-word;" title="Dihitung otomatis dari pengkajian">' . $col_hasil . '</td>
                    <td ' . $td_click . ' class="clickable-col" data-section="petugas">'    . $col_petugas    . '</td>
                    <td ' . $td_center . '>' . $btn_delete . '</td>
                </tr>
            ';
        }

        $output .= '</tbody></table>';
        echo $output;
    }

    public function action()
    {
        if (!$this->request->getPost('action')) {
            echo json_encode(['error' => 'Request tidak valid.']);
            return;
        }

        helper(['form', 'restclient']);

        $no_registrasi = $this->request->getPost('no_registrasi') ?: $this->session->get('no_registrasi');
        if (empty($no_registrasi)) {
            echo json_encode(['error' => 'Pasien belum dipilih.']);
            return;
        }

        $usr_id = (string)($this->session->get('usr_id') ?? '0');
        $action = $this->request->getPost('action');

        $cara_berjalan_1 = $this->request->getPost('cara_berjalan_1') ?? '';
        $cara_berjalan_2 = $this->request->getPost('cara_berjalan_2') ?? '';
        $menopang_duduk  = $this->request->getPost('menopang_duduk')  ?? '';

        $a_ya = ($cara_berjalan_1 === 'ya' || $cara_berjalan_2 === 'ya');
        $b_ya = ($menopang_duduk === 'ya');

        if ($a_ya && $b_ya) {
            $hasil = 'tinggi';
        } elseif ($a_ya || $b_ya) {
            $hasil = 'sedang';
        } else {
            $hasil = 'tidak_beresiko';
        }

        $tind_tidak  = ($hasil === 'tidak_beresiko') ? 'ya' : 'tidak';
        $tind_sedang = ($hasil === 'sedang')         ? 'ya' : 'tidak';
        $tind_tinggi = ($hasil === 'tinggi')         ? 'ya' : 'tidak';

        $payload = [
            'no_registrasi'            => $no_registrasi,
            'cara_berjalan'            => $cara_berjalan_1,
            'cara_berjalan2'           => $cara_berjalan_2,
            'menopang_duduk'           => $menopang_duduk,
            'tidak_beresiko_hasil'     => ($hasil === 'tidak_beresiko') ? 'ya' : 'tidak',
            'beresiko_sedang_hasil'    => ($hasil === 'sedang')         ? 'ya' : 'tidak',
            'beresiko_tinggi_hasil'    => ($hasil === 'tinggi')         ? 'ya' : 'tidak',
            'tidak_beresiko_tindakan'  => $tind_tidak,
            'beresiko_sedang_tindakan' => $tind_sedang,
            'beresiko_tinggi_tindakan' => $tind_tinggi,
            'usr_petugas'              => (string)($this->session->get('emp_nm') ?? $this->session->get('fullname') ?? ''),
        ];

        if ($action === 'Add') {
            $payload['created_by'] = $usr_id;
        } else {
            $payload['updated_by'] = $usr_id;
        }

        if ($action === 'Edit') {
            $url      = "{$this->server3}/api/resiko-jatuh/{$no_registrasi}";
            $response = akses_restapikey('PUT', $url, $payload);
        } else {
            $url      = "{$this->server3}/api/resiko-jatuh";
            $response = akses_restapikey('POST', $url, $payload);
        }

        log_message('debug', '[Resikojatuh::action] action=' . $action);
        log_message('debug', '[Resikojatuh::action] payload=' . json_encode($payload));
        log_message('debug', '[Resikojatuh::action] raw_response=' . $response);

        $result = json_decode($response, true);

        if ($result === null) {
            echo json_encode(['error' => 'Server error. Raw: ' . substr($response, 0, 500)]);
            return;
        }
        if (isset($result['success']) && $result['success'] === false) {
            echo json_encode(['error' => $result['message'] ?? json_encode($result)]);
            return;
        }
        if (isset($result['error'])) {
            echo json_encode(['error' => is_string($result['error']) ? $result['error'] : json_encode($result['error'])]);
            return;
        }
        if (isset($result['errors'])) {
            echo json_encode(['error' => is_string($result['errors']) ? $result['errors'] : json_encode($result['errors'])]);
            return;
        }
        if (isset($result['status']) && !in_array($result['status'], [200, 201, true, 'success'])) {
            echo json_encode(['error' => $result['message'] ?? json_encode($result)]);
            return;
        }

        $msg = ($action === 'Edit') ? 'Data asesmen risiko jatuh berhasil diubah!' : 'Data asesmen risiko jatuh berhasil disimpan!';
        echo json_encode(['success' => $msg]);
    }

    public function printResiko($no_registrasi = null)
    {
        if (!$no_registrasi) {
            $no_registrasi = $this->request->getVar('no_registrasi');
        }

        helper(['restclient']);

        $url      = "{$this->server3}/api/resiko-jatuh/{$no_registrasi}";
        $response = akses_restapikey('GET', $url, []);
        $result   = json_decode($response, true);

        if (isset($result['data']) && is_array($result['data'])) {
            $row = isset($result['data'][0]) ? $result['data'][0] : $result['data'];
        } elseif (is_array($result) && !empty($result) && !isset($result['message'])) {
            $row = isset($result[0]) ? $result[0] : $result;
        } else {
            $row = [];
        }

        $cara_berjalan_1 = $row['cara_berjalan']  ?? '';
        $cara_berjalan_2 = $row['cara_berjalan2'] ?? '';
        $menopang_duduk  = $row['menopang_duduk'] ?? '';

        $a_ya = ($cara_berjalan_1 === 'ya' || $cara_berjalan_2 === 'ya');

        $kajian_a_ya     = $a_ya ? 'v' : '';
        $kajian_a_tidak  = !$a_ya ? 'v' : '';
        $kajian_a1_ya    = ($cara_berjalan_1 === 'ya')    ? 'v' : '';
        $kajian_a1_tidak = ($cara_berjalan_1 === 'tidak') ? 'v' : '';
        $kajian_a2_ya    = ($cara_berjalan_2 === 'ya')    ? 'v' : '';
        $kajian_a2_tidak = ($cara_berjalan_2 === 'tidak') ? 'v' : '';
        $kajian_b_ya     = ($menopang_duduk  === 'ya')    ? 'v' : '';
        $kajian_b_tidak  = ($menopang_duduk  === 'tidak') ? 'v' : '';

        $hasil_risiko = '';
        if (($row['tidak_beresiko_hasil']  ?? '') === 'ya') $hasil_risiko = 'tidak_berisiko';
        if (($row['beresiko_sedang_hasil'] ?? '') === 'ya') $hasil_risiko = 'sedang';
        if (($row['beresiko_tinggi_hasil'] ?? '') === 'ya') $hasil_risiko = 'tinggi';

        $this->data['title_pdf'] = 'Asesmen Risiko Jatuh';
        $this->data['d'] = [
            'rm'              => $this->request->getVar('no_rm')       ?? '',
            'nama'            => $this->request->getVar('nama_pasien') ?? '',
            'tgl_lahir'       => $this->request->getVar('tgl_lahir')   ?? '',
            'kajian_a_ya'     => $kajian_a_ya,
            'kajian_a_tidak'  => $kajian_a_tidak,
            'kajian_a1_ya'    => $kajian_a1_ya,
            'kajian_a1_tidak' => $kajian_a1_tidak,
            'kajian_a2_ya'    => $kajian_a2_ya,
            'kajian_a2_tidak' => $kajian_a2_tidak,
            'kajian_b_ya'     => $kajian_b_ya,
            'kajian_b_tidak'  => $kajian_b_tidak,
            'hasil_risiko'    => $hasil_risiko,
            'usr_petugas'     => $row['usr_petugas'] ?? '',
        ];

        $html = view('resikojatuh/resikojatuh_pdf', $this->data);

        $Pdfgenerator = new Pdfgenerator();
        $Pdfgenerator->generate($html, 'ResikoJatuh_' . $no_registrasi, 'A4', 'portrait');
    }
}