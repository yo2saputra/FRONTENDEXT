<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

class Discharge extends BaseController
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
        $this->data['session_usr_id']    = (string)($this->session->get('usr_id') ?? '');
        $this->data['session_emp_nm']    = (string)($this->session->get('emp_nm') ?? $this->session->get('fullname') ?? '');
        $this->data['session_is_dokter'] = ($this->session->get('role_cd') == 'ROLE002');
        return view('discharge/index', $this->data);
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $no_registrasi = $this->request->getVar('no_registrasi');
            helper(['restclient']);

            $url    = "{$this->server3}/api/lembar-discharge-planning/{$no_registrasi}";
            $result = akses_restapikey('DELETE', $url, []);
            $result = is_string($result) ? json_decode($result, true) : $result;

            if (isset($result['success']) && $result['success'] === true) {
                return $this->response->setJSON([
                    'status'  => 'success',
                    'message' => $result['message'] ?? 'Data discharge planning berhasil dihapus',
                    'data'    => $result
                ]);
            } else {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => $result['message'] ?? 'Gagal menghapus data',
                    'errors'  => $result['errors'] ?? null
                ]);
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
                    paging: false,
                    searching: false,
                    info: false,
                    autoWidth: false
                });
            });
            </script>
        ';

        echo $output;
    }

    public function fetchDischargeByRegistrasi()
    {
        $no_registrasi = $this->request->getVar('no_registrasi');
        helper(['restclient']);

        $url      = "{$this->server3}/api/lembar-discharge-planning/{$no_registrasi}";
        $response = akses_restapikey('GET', $url, []);
        $result   = json_decode($response, true);

        if (isset($result['data']) && is_array($result['data'])) {
            $data = isset($result['data'][0]) ? $result['data'] : [$result['data']];
        } elseif (is_array($result) && !empty($result) && !isset($result['message'])) {
            $data = isset($result[0]) ? $result : [$result];
        } else {
            $data = [];
        }

        $tbl_wrap  = 'style="border:2px solid #333; width:100%; background-color:#fff; color:#333; border-collapse:collapse; table-layout:fixed;"';
        $th_style  = 'style="border:1px solid #333; background-color:#f4f6f9; color:#333; vertical-align:middle; padding:6px 8px; text-align:center;"';
        $td_style  = 'style="border:1px solid #333; background-color:#fff; color:#333; vertical-align:top; padding:6px 8px; cursor:pointer; word-break:break-word; overflow-wrap:break-word;" title="Klik untuk edit"';
        $td_center = 'style="border:1px solid #333; background-color:#fff; color:#333; vertical-align:top; text-align:center; padding:6px 8px;"';

        $output = '
            <table class="table table-bordered table-sm" ' . $tbl_wrap . '>
                <thead style="text-align:center; border-bottom:2px solid #333;">
                    <tr>
                        <th ' . $th_style . ' style="width:8%;">Info</th>
                        <th ' . $th_style . ' style="width:11%;">Data Umum</th>
                        <th ' . $th_style . ' style="width:11%;">Perawatan Rumah</th>
                        <th ' . $th_style . ' style="width:11%;">Diet &amp; Nutrisi</th>
                        <th ' . $th_style . ' style="width:13%;">Obat &amp; Aktivitas</th>
                        <th ' . $th_style . ' style="width:13%;">Hasil &amp; Lain-lain</th>
                        <th ' . $th_style . ' style="width:11%;">Tanda Tangan</th>
                        <th ' . $th_style . ' style="width:5%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
        ';

        if (empty($data)) {
            $output .= '
                <tr>
                    <td colspan="8" style="border:1px solid #333; color:#777; text-align:center; padding:20px; font-style:italic;">
                        Belum ada data discharge planning untuk pasien ini.
                    </td>
                </tr>
            ';
        } else {
            $row = $data[0];

            $fmt_dt = function($raw) {
                if (!$raw) return '-';
                try { return (new \DateTime($raw))->format('d/m/Y H:i'); }
                catch (\Exception $e) { return htmlspecialchars($raw); }
            };

            $row_data     = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
            $no_reg_row   = htmlspecialchars($row['no_registrasi'] ?? '');
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

            $waktu_raw    = $row['waktu_kntrl'] ?? '';
            $waktu_display = '-';
            if ($waktu_raw) {
                try {
                    $waktu_display = (new \DateTime($waktu_raw))->format('d/m/Y H:i');
                } catch (\Exception $e) {
                    $waktu_display = htmlspecialchars($waktu_raw);
                }
            }
            $tempat_kntrl  = htmlspecialchars($row['tempat_kntrl'] ?? '');

            $fmt_date = function($raw) {
                if (!$raw) return '-';
                try { return (new \DateTime($raw))->format('d/m/Y'); }
                catch (\Exception $e) { return htmlspecialchars($raw); }
            };

            $col_umum = '<small>'
                . '<b>Diagnosa:</b> '     . htmlspecialchars($row['diagnosa_medis']  ?? '-') . '<br>'
                . '<b>Pulang:</b> '       . htmlspecialchars($row['keadaan_pulang']  ?? '-') . '<br>'
                . '<b>Tgl Periksa:</b> '  . $fmt_date($row['tgl_pemeriksaan'] ?? null)      . '<br>'
                . '<b>Kontrol:</b> '      . ($waktu_display !== '-' ? $waktu_display : '-')
                . ($tempat_kntrl ? ' @ ' . $tempat_kntrl : '')
                . '</small>';

            $col_perawatan = '<small>'
                . '<b>1:</b> ' . htmlspecialchars($row['lanjutan_perawatan_dirumah1'] ?? '-') . '<br>'
                . '<b>2:</b> ' . htmlspecialchars($row['lanjutan_perawatan_dirumah2'] ?? '-')
                . '</small>';

            $col_diet = '<small>'
                . '<b>1:</b> ' . htmlspecialchars($row['aturan_diet_nutrisi1'] ?? '-') . '<br>'
                . '<b>2:</b> ' . htmlspecialchars($row['aturan_diet_nutrisi2'] ?? '-')
                . '</small>';

            $col_obat = '<small>'
                . '<b>Obat 1:</b> '  . htmlspecialchars($row['obat_diminum_jumlah1'] ?? '-') . '<br>'
                . '<b>Obat 2:</b> '  . htmlspecialchars($row['obat_diminum_jumlah2'] ?? '-') . '<br>'
                . '<b>Aktv 1:</b> '  . htmlspecialchars($row['aktivitas_istirahat1'] ?? '-') . '<br>'
                . '<b>Aktv 2:</b> '  . htmlspecialchars($row['aktivitas_istirahat2'] ?? '-')
                . '</small>';

            $col_lainlain = '<small>'
                . '<b>Surat 1:</b> '   . htmlspecialchars($row['hasil_surat1'] ?? '-') . '<br>'
                . '<b>Surat 2:</b> '   . htmlspecialchars($row['hasil_surat2'] ?? '-') . '<br>'
                . '<b>Lain-lain:</b><br><span style="word-break:break-all; white-space:normal; display:block;">'
                . htmlspecialchars($row['lain_lain'] ?? '-') . '</span>'
                . '</small>';

            $col_ttd = '<small>'
                . '<b>Pasien/Klg:</b> ' . htmlspecialchars($row['pasien_keluarga'] ?? '-') . '<br>'
                . '<b>Dokter:</b> '     . htmlspecialchars($row['usr_dokter']      ?? '-') . '<br>'
                . '<b>Perawat:</b> '    . htmlspecialchars($row['usr_perawat']     ?? '-') . '<br>'
                . '<b>Tgl TTD:</b> '    . $fmt_date($row['tgl_ttd'] ?? null)
                . '</small>';

            $btn_delete = '<button type="button" class="btn btn-danger btn-sm delete"
                data-no_registrasi="' . $no_reg_row . '"
                title="Hapus"><i class="fas fa-trash"></i></button>';

            $td_click = function($tab, $content) use ($td_style) {
                return '<td ' . $td_style . ' class="clickable-col" data-tab="' . $tab . '">' . $content . '</td>';
            };

            $td_ttd_style = 'style="border:1px solid #333; background-color:#f8f9fa; color:#999; vertical-align:top; padding:6px 8px; cursor:not-allowed;" title="Fitur tanda tangan belum tersedia"';

            $output .= '
                <tr class="edit-discharge-row" data-row="' . $row_data . '" data-no_registrasi="' . $no_reg_row . '">
                    <td style="border:1px solid #333; background-color:#fff; color:#333; vertical-align:top; padding:6px 8px;">' . $info . '</td>
                    ' . $td_click('edit-tab-umum',      $col_umum)      . '
                    ' . $td_click('edit-tab-perawatan', $col_perawatan) . '
                    ' . $td_click('edit-tab-diet',      $col_diet)      . '
                    ' . $td_click('edit-tab-obat',      $col_obat)      . '
                    ' . $td_click('edit-tab-lainlain',  $col_lainlain)  . '
                    <td ' . $td_ttd_style . '>' . $col_ttd . '</td>
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
        $url      = "{$this->server3}/api/lembar-discharge-planning/{$no_registrasi}";
        $response = akses_restapikey('GET', $url, []);
        $result   = json_decode($response, true);

        if (isset($result['data']) && is_array($result['data'])) {
            $row = isset($result['data'][0]) ? $result['data'][0] : $result['data'];
        } elseif (is_array($result) && !empty($result) && !isset($result['message'])) {
            $row = isset($result[0]) ? $result[0] : $result;
        } else {
            $row = [];
        }

        return $row;
    }

    public function action()
    {
        if (!$this->request->getPost('action')) {
            echo json_encode(['error' => ['diagnosa_medis' => 'Request tidak valid.']]);
            return;
        }

        helper(['form', 'restclient']);

        $no_registrasi = $this->request->getPost('no_registrasi') ?: $this->session->get('no_registrasi');
        if (empty($no_registrasi)) {
            echo json_encode(['error' => ['diagnosa_medis' => 'Pasien belum dipilih.']]);
            return;
        }

        $usr_id    = (string)($this->session->get('usr_id') ?? '0');
        $action    = $this->request->getPost('action');
        $usr_name  = (string)($this->session->get('emp_nm') ?? $this->session->get('fullname') ?? $usr_id);
        $is_dokter = ($this->session->get('role_cd') == 'ROLE002');

        // Ambil data lama supaya nama perawat/dokter yang bukan peran user saat ini tidak ikut ketimpa kosong
        $existingRow = $this->apiDataGetByRegistrasi($no_registrasi);

        if ($is_dokter) {
            $usr_dokter  = $usr_name;
            $usr_perawat = $existingRow['usr_perawat'] ?? '';
        } else {
            $usr_perawat = $usr_name;
            $usr_dokter  = $existingRow['usr_dokter'] ?? '';
        }

        $waktu_kntrl_raw = $this->request->getPost('waktu_kntrl') ?? '';
        if ($waktu_kntrl_raw && strpos($waktu_kntrl_raw, 'T') !== false) {
            $waktu_kntrl_raw = str_replace('T', ' ', $waktu_kntrl_raw) . ':00';
        }

        $payload = [
            'no_registrasi'               => $no_registrasi,
            'created_by'                  => $usr_id,
            'updated_by'                  => ($action === 'Edit') ? $usr_id : null,
            'diagnosa_medis'              => $this->request->getPost('diagnosa_medis')              ?? '',
            'tgl_pemeriksaan'             => $this->request->getPost('tgl_pemeriksaan')             ?: null,
            'tgl_ttd'                     => $this->request->getPost('tgl_ttd')                     ?: null,
            'keadaan_pulang'              => $this->request->getPost('keadaan_pulang')              ?? '',
            'waktu_kntrl'                 => $waktu_kntrl_raw ?: null,
            'tempat_kntrl'                => $this->request->getPost('tempat_kntrl')                ?? '',
            'lanjutan_perawatan_dirumah1' => $this->request->getPost('lanjutan_perawatan_dirumah1') ?? '',
            'lanjutan_perawatan_dirumah2' => $this->request->getPost('lanjutan_perawatan_dirumah2') ?? '',
            'aturan_diet_nutrisi1'        => $this->request->getPost('aturan_diet_nutrisi1')        ?? '',
            'aturan_diet_nutrisi2'        => $this->request->getPost('aturan_diet_nutrisi2')        ?? '',
            'obat_diminum_jumlah1'        => $this->request->getPost('obat_diminum_jumlah1')        ?? '',
            'obat_diminum_jumlah2'        => $this->request->getPost('obat_diminum_jumlah2')        ?? '',
            'aktivitas_istirahat1'        => $this->request->getPost('aktivitas_istirahat1')        ?? '',
            'aktivitas_istirahat2'        => $this->request->getPost('aktivitas_istirahat2')        ?? '',
            'hasil_surat1'                => $this->request->getPost('hasil_surat1')                ?? '',
            'hasil_surat2'                => $this->request->getPost('hasil_surat2')                ?? '',
            'lain_lain'                   => $this->request->getPost('lain_lain')                   ?? '',
            'usr_perawat'                 => $usr_perawat,
            'usr_dokter'                  => $usr_dokter,
            'pasien_keluarga'             => $this->request->getPost('pasien_keluarga')             ?? '',
        ];

        if ($action === 'Edit') {
            $url      = "{$this->server3}/api/lembar-discharge-planning/{$no_registrasi}";
            $response = akses_restapikey('PUT', $url, $payload);
        } else {
            $url      = "{$this->server3}/api/lembar-discharge-planning";
            $response = akses_restapikey('POST', $url, $payload);
        }

        $result = json_decode($response, true);

        if ($result === null) {
            echo json_encode(['error' => ['diagnosa_medis' => 'Server tidak merespons dengan benar. Coba lagi.']]);
            return;
        }

        if (!empty($result['error'])) {
            echo json_encode(['error' => ['diagnosa_medis' => 'API Error: ' . (is_string($result['error']) ? $result['error'] : json_encode($result['error']))]]);
        } elseif (isset($result['success']) && $result['success'] === false) {
            echo json_encode(['error' => ['diagnosa_medis' => $result['message'] ?? 'Gagal menyimpan data.']]);
        } else {
            $msg = ($action === 'Edit') ? 'Data discharge planning berhasil diubah!' : 'Data discharge planning berhasil disimpan!';
            echo json_encode(['success' => $msg]);
        }
    }

    public function printDischarge($no_registrasi = null)
    {
        if (!$no_registrasi) {
            $no_registrasi = $this->request->getVar('no_registrasi');
        }

        helper(['restclient']);

        $url      = "{$this->server3}/api/lembar-discharge-planning/{$no_registrasi}";
        $response = akses_restapikey('GET', $url, []);
        $result   = json_decode($response, true);

        if (isset($result['data']) && is_array($result['data'])) {
            $pdf_data = isset($result['data'][0]) ? $result['data'] : [$result['data']];
        } elseif (is_array($result) && !empty($result) && !isset($result['message'])) {
            $pdf_data = isset($result[0]) ? $result : [$result];
        } else {
            $pdf_data = [];
        }

        $row    = !empty($pdf_data) ? $pdf_data[0] : [];
        $gender = $this->request->getVar('gender') ?? '';
        $jk     = (stripos($gender, 'P') !== false || stripos($gender, 'Wanita') !== false || stripos($gender, 'Perempuan') !== false) ? 'Perempuan' : 'Laki-laki';

        $tgl_periksa = '-';
        if (!empty($row['tgl_pemeriksaan'])) {
            try { $tgl_periksa = (new \DateTime($row['tgl_pemeriksaan']))->format('d/m/Y'); }
            catch (\Exception $e) { $tgl_periksa = $row['tgl_pemeriksaan']; }
        }

        $waktu_kntrl_display = '';
        if (!empty($row['waktu_kntrl'])) {
            try {
                $waktu_kntrl_display = (new \DateTime($row['waktu_kntrl']))->format('d/m/Y H:i');
            } catch (\Exception $e) {
                $waktu_kntrl_display = $row['waktu_kntrl'];
            }
        }

        $this->data['title_pdf'] = 'Lembar Discharge Planning';

        $this->data['d'] = [
            'rm'              => $this->request->getVar('no_rm')       ?? '',
            'nama'            => $this->request->getVar('nama_pasien') ?? '',
            'tgl_lahir'       => $this->request->getVar('tgl_lahir')   ?? '',
            'jk'              => $jk,
            'alamat'          => '',
            'tgl_periksa'     => $tgl_periksa,
            'diagnosa'        => $row['diagnosa_medis']                 ?? '',
            'keadaan_pulang'  => $row['keadaan_pulang']                 ?? '',
            'kontrol_waktu'   => $waktu_kntrl_display,
            'kontrol_tempat'  => $row['tempat_kntrl']                   ?? '',
            'perawatan1'      => $row['lanjutan_perawatan_dirumah1']    ?? '',
            'perawatan2'      => $row['lanjutan_perawatan_dirumah2']    ?? '',
            'diet1'           => $row['aturan_diet_nutrisi1']           ?? '',
            'diet2'           => $row['aturan_diet_nutrisi2']           ?? '',
            'obat1'           => $row['obat_diminum_jumlah1']           ?? '',
            'obat2'           => $row['obat_diminum_jumlah2']           ?? '',
            'aktivitas1'      => $row['aktivitas_istirahat1']           ?? '',
            'aktivitas2'      => $row['aktivitas_istirahat2']           ?? '',
            'hasil_surat1'    => $row['hasil_surat1']                   ?? '',
            'hasil_surat2'    => $row['hasil_surat2']                   ?? '',
            'lain_lain'       => $row['lain_lain']                      ?? '',
            'usr_perawat'     => $row['usr_perawat']                    ?? '',
            'usr_dokter'      => $row['usr_dokter']                     ?? '',
            'pasien_keluarga' => $row['pasien_keluarga']                ?? '',
            'kota_tgl'        => 'Surabaya, ' . date('d/m/Y'),
        ];

        $html = view('discharge/discharge_pdf', $this->data);

        $Pdfgenerator = new Pdfgenerator();
        $Pdfgenerator->generate($html, 'DischargePlanning_' . $no_registrasi, 'A4', 'portrait');
    }
}