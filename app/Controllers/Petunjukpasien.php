<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

class Petunjukpasien extends BaseController
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
        $this->data['session_emp_nm'] = (string)($this->session->get('emp_nm') ?? '');
        return view('petunjukpasien/index', $this->data);
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $no_registrasi = $this->request->getVar('no_registrasi');
            helper(['restclient']);

            $url    = "{$this->server3}/api/petunjuk-pasien-pulang/{$no_registrasi}";
            $result = akses_restapikey('DELETE', $url, []);
            $result = is_string($result) ? json_decode($result, true) : $result;

            if (isset($result['success']) && $result['success'] === true) {
                return $this->response->setJSON(['status' => 'success', 'message' => $result['message'] ?? 'Data berhasil dihapus']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => $result['message'] ?? 'Gagal menghapus data']);
            }
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
                <thead>
                    <tr>
                        <th>Pasien</th>
                        <th>Hadir</th>
                        <th></th>
                    </tr>
                </thead>
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
                if ($.fn.DataTable.isDataTable("#example1")) {
                    $("#example1").DataTable().destroy();
                }
                $("#example1").DataTable({
                    columnDefs: [{ orderable: false, targets: 2 }],
                    paging: false, searching: false, info: false, autoWidth: false
                });
            });
            </script>
        ';

        echo $output;
    }

    public function fetchPetunjukByRegistrasi()
    {
        $no_registrasi = $this->request->getVar('no_registrasi');

        if (empty($no_registrasi)) {
            echo '<p class="text-muted text-center py-3">Pilih pasien untuk melihat data petunjuk pulang.</p>';
            return;
        }

        helper(['restclient']);

        $url      = "{$this->server3}/api/petunjuk-pasien-pulang/{$no_registrasi}";
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
        $td_style  = 'style="border:1px solid #333; background-color:#fff; color:#333; vertical-align:top; padding:6px 8px; cursor:pointer; max-width:0; word-break:break-all; overflow-wrap:break-word; white-space:normal;" title="Klik untuk edit"';
        $td_center = 'style="border:1px solid #333; background-color:#fff; color:#333; vertical-align:top; text-align:center; padding:6px 8px;"';

        $output = '
            <table class="table table-bordered table-sm" ' . $tbl_wrap . '>
                <thead style="text-align:center; border-bottom:2px solid #333;">
                    <tr>
                        <th ' . $th_style . ' style="width:10%; cursor:default;">Info</th>
                        <th ' . $th_style . ' style="width:12%;">Diagnosis &amp; Vital</th>
                        <th ' . $th_style . ' style="width:14%;">Obat &amp; Lembar</th>
                        <th ' . $th_style . ' style="width:14%;">Kontrol &amp; Penyuluhan</th>
                        <th ' . $th_style . ' style="width:14%;">Pemeriksaan &amp; Penjelasan</th>
                        <th ' . $th_style . ' style="width:7%; cursor:default;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
        ';

        if (empty($data)) {
            $output .= '<tr><td colspan="6" style="border:1px solid #333; color:#777; text-align:center; padding:20px; font-style:italic;">Belum ada data petunjuk pulang untuk pasien ini.</td></tr>';
        } else {
            $row         = $data[0];
            $petunjuk_id = $row['no_registrasi'] ?? '';

            $fmt_dt = function($raw) {
                if (!$raw) return '-';
                try { return (new \DateTime($raw))->format('d/m/Y H:i'); }
                catch (\Exception $e) { return htmlspecialchars($raw); }
            };

            $fmt_date = function($raw) {
                if (!$raw) return '-';
                try { return (new \DateTime($raw))->format('d/m/Y'); }
                catch (\Exception $e) { return htmlspecialchars($raw); }
            };

            $row_data = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');

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

            $diag_vital = '<small>'
                . '<b>Diagnosa:</b> ' . htmlspecialchars($row['diagnosa_medis'] ?? '-') . '<br>'
                . '<b>BB:</b> '    . htmlspecialchars($row['berat_badan']    ?? '-') . ' kg'
                . ' | <b>TB:</b> ' . htmlspecialchars($row['tinggi_badan']   ?? '-') . ' cm<br>'
                . '<b>TD:</b> '    . htmlspecialchars($row['tensi']          ?? '-') . ' mmHg<br>'
                . '<b>N:</b> '     . htmlspecialchars($row['nadi']           ?? '-') . ' x/mnt'
                . ' | <b>RR:</b> ' . htmlspecialchars($row['respiratory_rate'] ?? '-') . ' x/mnt<br>'
                . '<b>S:</b> '     . htmlspecialchars($row['suhu']           ?? '-') . ' °C'
                . '</small>';

            $obat_lembar = '<small>'
                . '<b>Diberikan:</b> <span style="word-break:break-all;">'     . htmlspecialchars($row['diberikan_obt']     ?? '-') . '</span><br>'
                . '<b>Dibawa pulang:</b> <span style="word-break:break-all;">' . htmlspecialchars($row['dibawapulang_obt']  ?? '-') . '</span><br>'
                . '<b>Lab:</b> '           . htmlspecialchars($row['laboratorium_lmbr'] ?? '-') . ' lembar<br>'
                . '<b>Thorax:</b> '        . htmlspecialchars($row['foto_thorax_lmbr']  ?? '-') . ' lembar<br>'
                . '<b>USG:</b> '           . htmlspecialchars($row['usg_lmbr']          ?? '-') . ' lembar<br>'
                . '<b>Lainnya:</b> '       . htmlspecialchars($row['lainnya_lmbr']      ?? '-') . ' lembar'
                . '</small>';

            $pparts = explode('||', $row['penyuluhan_kesehatan'] ?? '');
            $p1 = trim($pparts[0] ?? '') ?: '-';
            $p2 = trim($pparts[1] ?? '') ?: '-';
            $p3 = trim($pparts[2] ?? '') ?: '-';

            $kontrol_penyuluhan = '<small>'
                . '<b>Penyuluhan 1:</b> ' . htmlspecialchars($p1) . '<br>'
                . '<b>Penyuluhan 2:</b> ' . htmlspecialchars($p2) . '<br>'
                . '<b>Penyuluhan 3:</b> ' . htmlspecialchars($p3) . '<br>'
                . '<b>Tgl Kontrol:</b> '  . $fmt_date($row['tgl_kntrl'] ?? null) . '<br>'
                . '<b>Poli Kontrol:</b> ' . htmlspecialchars($row['poli_kntrl']    ?? '-') . '<br>'
                . '<b>Membawa:</b> '      . htmlspecialchars($row['membawa_kntrl'] ?? '-')
                . '</small>';

            $pemeriksaan_penjelasan = '<small>'
                . '<b>Tgl Periksa:</b> '       . $fmt_date($row['tgl_pemeriksaan'] ?? null) . '<br>'
                . '<b>Diberi Penjelasan:</b> '  . htmlspecialchars($row['diberi_pnjlsan']  ?? '-') . '<br>'
                . '<b>Pemberi Penjelasan:</b> ' . htmlspecialchars($row['pemberi_pnjlsan'] ?? '-')
                . '</small>';

            $btn_delete = '<button type="button" class="btn btn-danger btn-sm delete"
                data-no_registrasi="' . htmlspecialchars($petunjuk_id) . '"
                title="Hapus"><i class="fas fa-trash"></i></button>';

            $td_click = function($tab, $content) use ($td_style) {
                return '<td ' . $td_style . ' class="clickable-col" data-tab="' . $tab . '">' . $content . '</td>';
            };

            $output .= '
                <tr class="edit-petunjuk-row"
                    data-row="' . $row_data . '"
                    data-no_registrasi="' . htmlspecialchars($petunjuk_id) . '">
                    <td style="border:1px solid #333; background-color:#fff; color:#333; vertical-align:top; padding:6px 8px; max-width:0; word-break:break-all;">' . $info . '</td>
                    ' . $td_click('edit-tab-diag',        $diag_vital)             . '
                    ' . $td_click('edit-tab-obat',        $obat_lembar)            . '
                    ' . $td_click('edit-tab-kontrol',     $kontrol_penyuluhan)     . '
                    ' . $td_click('edit-tab-pemeriksaan', $pemeriksaan_penjelasan) . '
                    <td ' . $td_center . '>' . $btn_delete . '</td>
                </tr>
            ';
        }

        $output .= '</tbody></table>';
        echo $output;
    }

    private function apiDataGetByRegistrasi($no_registrasi)
    {
        helper(['restclient']);
        $url      = "{$this->server3}/api/petunjuk-pasien-pulang/{$no_registrasi}";
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

        return $row;
    }

    public function fetchPetunjukJson()
    {
        $no_registrasi = $this->request->getVar('no_registrasi');
        if (empty($no_registrasi)) {
            return $this->response->setJSON(['status' => 'empty', 'data' => null]);
        }

        $row = $this->apiDataGetByRegistrasi($no_registrasi);

        if (!empty($row)) {
            return $this->response->setJSON(['status' => 'success', 'data' => $row]);
        }
        return $this->response->setJSON(['status' => 'empty', 'data' => null]);
    }

    public function action()
    {
        helper(['form', 'restclient']);

        $no_registrasi = $this->request->getPost('no_registrasi') ?: $this->session->get('no_registrasi');
        if (empty($no_registrasi)) {
            echo json_encode(['error' => 'Pasien belum dipilih.']);
            return;
        }

        $usr_id = (string)($this->session->get('usr_id') ?? '0');

        $existingRow = $this->apiDataGetByRegistrasi($no_registrasi);
        $action      = !empty($existingRow) ? 'Edit' : 'Add';

        $post = $this->request->getPost();

        $payload = ['no_registrasi' => $no_registrasi];

        if ($action === 'Add') {
            $payload['created_by'] = $usr_id;
        } else {
            $payload['created_by'] = $existingRow['created_by'] ?? $usr_id;
            $payload['updated_by'] = $usr_id;
        }

        $strFields = [
            'diagnosa_medis', 'tensi', 'diberikan_obt', 'dibawapulang_obt',
            'laboratorium_lmbr', 'foto_thorax_lmbr', 'usg_lmbr', 'lainnya_lmbr',
            'penyuluhan_kesehatan', 'poli_kntrl', 'membawa_kntrl',
            'diberi_pnjlsan',
        ];
        foreach ($strFields as $f) {
            $v = isset($post[$f]) ? trim($post[$f]) : null;
            $payload[$f] = ($v !== null && $v !== '') ? $v : null;
        }

        $payload['pemberi_pnjlsan'] = (string)($this->session->get('emp_nm') ?? '');

        foreach (['berat_badan', 'tinggi_badan', 'suhu'] as $f) {
            $v = $post[$f] ?? null;
            $payload[$f] = ($v !== null && $v !== '') ? (float)number_format((float)$v, 1, '.', '') : null;
        }

        foreach (['nadi', 'respiratory_rate'] as $f) {
            $v = $post[$f] ?? null;
            $payload[$f] = ($v !== null && $v !== '') ? (int)$v : null;
        }

        foreach (['tgl_kntrl', 'tgl_pemeriksaan'] as $f) {
            $v = $post[$f] ?? null;
            $payload[$f] = ($v !== null && $v !== '') ? $v : null;
        }

        if ($action === 'Edit') {
            $url      = "{$this->server3}/api/petunjuk-pasien-pulang/{$no_registrasi}";
            $response = akses_restapikey('PUT', $url, $payload);
        } else {
            $url      = "{$this->server3}/api/petunjuk-pasien-pulang";
            $response = akses_restapikey('POST', $url, $payload);
        }

        log_message('debug', '[Petunjukpasien::action] action=' . $action);
        log_message('debug', '[Petunjukpasien::action] url=' . $url);
        log_message('debug', '[Petunjukpasien::action] payload=' . json_encode($payload));
        log_message('debug', '[Petunjukpasien::action] raw_response=' . $response);

        $result = json_decode($response, true);

        if ($result === null) {
            echo json_encode(['error' => 'Server error. Raw response: ' . substr($response, 0, 1000)]);
            return;
        }

        if (isset($result['success']) && $result['success'] === false) {
            echo json_encode(['error' => $result['message'] ?? json_encode($result)]);
            return;
        }

        if (isset($result['error'])) {
            $msg = is_string($result['error']) ? $result['error'] : json_encode($result['error']);
            echo json_encode(['error' => $msg]);
            return;
        }

        if (isset($result['errors'])) {
            $msg = is_string($result['errors']) ? $result['errors'] : json_encode($result['errors']);
            echo json_encode(['error' => $msg]);
            return;
        }

        if (isset($result['status']) && !in_array($result['status'], [200, 201, true, 'success'])) {
            echo json_encode(['error' => $result['message'] ?? json_encode($result)]);
            return;
        }

        $msg = ($action === 'Edit') ? 'Data petunjuk pulang berhasil diubah!' : 'Data petunjuk pulang berhasil disimpan!';
        echo json_encode(['success' => $msg]);
    }

    public function printPetunjuk($no_registrasi = null)
    {
        if (!$no_registrasi) {
            $no_registrasi = $this->request->getVar('no_registrasi');
        }

        helper(['restclient']);

        $url      = "{$this->server3}/api/petunjuk-pasien-pulang/{$no_registrasi}";
        $response = akses_restapikey('GET', $url, []);
        $result   = json_decode($response, true);

        if (isset($result['data']) && is_array($result['data'])) {
            $row = isset($result['data'][0]) ? $result['data'][0] : $result['data'];
        } elseif (is_array($result) && !empty($result) && !isset($result['message'])) {
            $row = isset($result[0]) ? $result[0] : $result;
        } else {
            $row = [];
        }

        $gender = $this->request->getVar('gender') ?? '';
        $jk     = (stripos($gender, 'P') !== false || stripos($gender, 'Wanita') !== false || stripos($gender, 'Perempuan') !== false) ? 'P' : 'L';

        $pparts = explode('||', $row['penyuluhan_kesehatan'] ?? '');

        $this->data['title_pdf'] = 'Petunjuk Pulang Pasien';
        $this->data['d'] = [
            'rm'                   => $this->request->getVar('no_rm')       ?? '',
            'nama'                 => $this->request->getVar('nama_pasien') ?? '',
            'tgl_lahir'            => $this->request->getVar('tgl_lahir')   ?? '',
            'jk'                   => $jk,
            'diagnosa_medis'       => $row['diagnosa_medis']       ?? '',
            'berat_badan'          => $row['berat_badan']          ?? '',
            'tinggi_badan'         => $row['tinggi_badan']         ?? '',
            'tensi'                => $row['tensi']                ?? '',
            'nadi'                 => $row['nadi']                 ?? '',
            'respiratory_rate'     => $row['respiratory_rate']     ?? '',
            'suhu'                 => $row['suhu']                 ?? '',
            'diberikan_obt'        => $row['diberikan_obt']        ?? '',
            'dibawapulang_obt'     => $row['dibawapulang_obt']     ?? '',
            'laboratorium_lmbr'    => $row['laboratorium_lmbr']    ?? '',
            'foto_thorax_lmbr'     => $row['foto_thorax_lmbr']     ?? '',
            'usg_lmbr'             => $row['usg_lmbr']             ?? '',
            'lainnya_lmbr'         => $row['lainnya_lmbr']         ?? '',
            'penyuluhan_1'         => trim($pparts[0] ?? ''),
            'penyuluhan_2'         => trim($pparts[1] ?? ''),
            'penyuluhan_3'         => trim($pparts[2] ?? ''),
            'tgl_kntrl'            => $row['tgl_kntrl']            ?? '',
            'poli_kntrl'           => $row['poli_kntrl']           ?? '',
            'membawa_kntrl'        => $row['membawa_kntrl']        ?? '',
            'tgl_pemeriksaan'      => $row['tgl_pemeriksaan']      ?? '',
            'diberi_pnjlsan'       => $row['diberi_pnjlsan']       ?? '',
            'pemberi_pnjlsan'      => $row['pemberi_pnjlsan']      ?? '',
            'kota_tgl'             => 'Surabaya, ' . date('d/m/Y'),
        ];

        $html = view('petunjukpasien/petunjukpasien_pdf', $this->data);

        $Pdfgenerator = new Pdfgenerator();
        $Pdfgenerator->generate($html, 'PetunjukPulang_' . $no_registrasi, 'A4', 'portrait');
    }
}