<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

class Observasi extends BaseController
{
    protected $data;
    protected $server;
    protected $server3;
    protected $server5;

    public function __construct()
    {
        $this->session = session();
        $this->server  = $_ENV['APP_API'];
        $this->server3 = $_ENV['APP_API3'];
        $this->server5 = $_ENV['APP_API5'];
    }

    public function index()
    {
        $this->data['session_usr_id']    = (string)($this->session->get('usr_id') ?? '');
        $this->data['session_emp_nm']    = (string)($this->session->get('emp_nm') ?? $this->session->get('fullname') ?? '');
        $this->data['session_is_dokter'] = ($this->session->get('role_cd') == 'ROLE002');
        return view('observasi/index', $this->data);
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $obs_id = $this->request->getVar('obs_id');

            helper(['restclient']);

            $url   = "{$this->server3}/api/lotpdla";
            $query = ['id' => $obs_id];

            $result = akses_restapikey('DELETE', $url, [], $query);
            $result = is_string($result) ? json_decode($result, true) : $result;

            if (isset($result['success']) && $result['success'] === true) {
                return $this->response->setJSON([
                    'status'  => 'success',
                    'message' => $result['message'] ?? 'Data observasi berhasil dihapus',
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

    public function fetchObservasiByRegistrasi()
    {
        $no_registrasi = $this->request->getVar('no_registrasi');
        helper(['restclient']);

        $url      = "{$this->server3}/api/lotpdla";
        $query    = [
            'action'        => 'getbynoreg',
            'no_registrasi' => $no_registrasi,
        ];
        $response = akses_restapikey('GET', $url, [], $query);
        $result   = json_decode($response, true);

        if (isset($result['data']) && is_array($result['data'])) {
            $data = $result['data'];
        } elseif (is_array($result) && array_values($result) === $result) {
            $data = $result;
        } else {
            $data = [];
        }

        $tbl_wrap  = 'style="border:2px solid #333; width:100%; background-color:#fff; color:#333; border-collapse:collapse; table-layout:fixed;"';
        $th_style  = 'style="border:1px solid #333; background-color:#f4f6f9; color:#333; vertical-align:middle; padding:6px 8px; text-align:center;"';
        $td_style  = 'style="border:1px solid #333; background-color:#fff; color:#333; vertical-align:top; padding:6px 8px; cursor:pointer; word-break:break-word; overflow-wrap:break-word;" title="Klik untuk edit"';
        $td_center = 'style="border:1px solid #333; background-color:#fff; color:#333; vertical-align:top; text-align:center; padding:6px 8px; word-break:break-word;"';

        $output = '
            <table class="table table-bordered table-sm" ' . $tbl_wrap . '>
                <thead style="text-align:center; border-bottom:2px solid #333;">
                    <tr>
                        <th ' . $th_style . ' style="width:11%;">Info</th>
                        <th ' . $th_style . ' style="width:10%;">Diagnosis &amp; Tindakan</th>
                        <th ' . $th_style . ' style="width:18%;">Keadaan Pra Tindakan</th>
                        <th ' . $th_style . ' style="width:22%;">Keadaan Intra Tindakan</th>
                        <th ' . $th_style . ' style="width:18%;">Keadaan Post Tindakan</th>
                        <th ' . $th_style . ' style="width:14%;">Catatan</th>
                        <th ' . $th_style . ' style="width:7%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
        ';

        if (empty($data)) {
            $output .= '
                <tr>
                    <td colspan="7" style="border:1px solid #333; color:#777; text-align:center; padding:20px; font-style:italic;">
                        Belum ada data observasi untuk pasien ini.
                    </td>
                </tr>
            ';
        } else {
            $row    = $data[0];
            $obs_id = $row['id'] ?? '';

            $fmt_dt = function($raw) {
                if (!$raw) return '-';
                try { return (new \DateTime($raw))->format('d/m/Y H:i'); }
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

            $diag = '<small>'
                . '<b>Diagnosis:</b> ' . htmlspecialchars($row['diagnosis_medis'] ?? '-') . '<br>'
                . '<b>Tindakan:</b> '  . htmlspecialchars($row['tindakan']        ?? '-')
                . '</small>';

            $pra = '<small>'
                . '<b>Keadaan Umum:</b> '   . htmlspecialchars($row['keadaan_umum_kpt']  ?? '-') . '<br>'
                . '<b>Tekanan Darah:</b> '  . htmlspecialchars($row['tekanan_darah_kpt'] ?? '-') . ' mmHg<br>'
                . '<b>Suhu:</b> '           . htmlspecialchars($row['suhu_kpt']          ?? '-') . ' °C<br>'
                . '<b>Nadi:</b> '           . htmlspecialchars($row['nadi_kpt']          ?? '-') . ' x/mnt<br>'
                . '<b>RR:</b> '             . htmlspecialchars($row['rr_kpt']            ?? '-') . ' x/mnt<br>'
                . '<b>SpO2:</b> '           . htmlspecialchars($row['spo2_kpt']          ?? '-') . '%'
                . '</small>';

            $intra = '<small>'
                . '<b>Keadaan Umum:</b> '      . htmlspecialchars($row['keadaan_umum_kit']        ?? '-') . '<br>'
                . '<b>Dokter:</b> '            . htmlspecialchars($row['dokter_kit']              ?? '-') . '<br>'
                . '<b>Obat Anestesi:</b> '     . htmlspecialchars($row['obat_anestesi_lokal_kit'] ?? '-') . '<br>'
                . '<b>Dosis:</b> '             . htmlspecialchars($row['dosis_obat_kit']          ?? '-') . '<br>'
                . '<b>Rute:</b> '              . htmlspecialchars($row['rute_obat_kit']           ?? '-') . '<br>'
                . '<b>Jam Mulai:</b> '         . htmlspecialchars($row['jam_mulai_kit']           ?? '-') . '<br>'
                . '<b>Jam Selesai:</b> '       . htmlspecialchars($row['jam_selesai_kit']         ?? '-') . '<br>'
                . '<b>Tekanan Darah:</b> '     . htmlspecialchars($row['tekanan_darah_kit']       ?? '-') . ' mmHg<br>'
                . '<b>Suhu:</b> '              . htmlspecialchars($row['suhu_kit']                ?? '-') . ' °C<br>'
                . '<b>Nadi:</b> '              . htmlspecialchars($row['nadi_kit']                ?? '-') . ' x/mnt<br>'
                . '<b>RR:</b> '               . htmlspecialchars($row['rr_kit']                  ?? '-') . ' x/mnt<br>'
                . '<b>SpO2:</b> '              . htmlspecialchars($row['spo2_kit']                ?? '-') . '%'
                . '</small>';

            $post = '<small>'
                . '<b>Keadaan Umum:</b> '   . htmlspecialchars($row['keadaan_umum_kpot']  ?? '-') . '<br>'
                . '<b>Tekanan Darah:</b> '  . htmlspecialchars($row['tekanan_darah_kpot'] ?? '-') . ' mmHg<br>'
                . '<b>Suhu:</b> '           . htmlspecialchars($row['suhu_kpot']          ?? '-') . ' °C<br>'
                . '<b>Nadi:</b> '           . htmlspecialchars($row['nadi_kpot']          ?? '-') . ' x/mnt<br>'
                . '<b>RR:</b> '             . htmlspecialchars($row['rr_kpot']            ?? '-') . ' x/mnt<br>'
                . '<b>SpO2:</b> '           . htmlspecialchars($row['spo2_kpot']          ?? '-') . '%'
                . '</small>';

            $catatan = '<small style="white-space:pre-wrap;">'
                . htmlspecialchars($row['catatan'] ?? '-')
                . '</small>';

            $btn_delete = '<button type="button" class="btn btn-danger btn-sm delete"
                data-id="' . htmlspecialchars($obs_id) . '"
                title="Hapus"><i class="fas fa-trash"></i></button>';

            $td_click = function($tab, $content) use ($td_style) {
                return '<td ' . $td_style . ' class="clickable-col" data-tab="' . $tab . '">' . $content . '</td>';
            };

            $output .= '
                <tr class="edit-observasi-row" data-row="' . $row_data . '" data-id="' . htmlspecialchars($obs_id) . '">
                    <td style="border:1px solid #333; background-color:#fff; color:#333; vertical-align:top; padding:6px 8px; word-break:break-word;">' . $info . '</td>
                    ' . $td_click('edit-tab-umum',    $diag)   . '
                    ' . $td_click('edit-tab-kpt',     $pra)    . '
                    ' . $td_click('edit-tab-kit',     $intra)  . '
                    ' . $td_click('edit-tab-kpot',    $post)   . '
                    ' . $td_click('edit-tab-catatan', $catatan) . '
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
        $url      = "{$this->server3}/api/lotpdla";
        $query    = [
            'action'        => 'getbynoreg',
            'no_registrasi' => $no_registrasi,
        ];
        $response = akses_restapikey('GET', $url, [], $query);
        $result   = json_decode($response, true);

        if (isset($result['data']) && is_array($result['data'])) {
            $data = $result['data'];
        } elseif (is_array($result) && array_values($result) === $result) {
            $data = $result;
        } else {
            $data = [];
        }

        return !empty($data) ? $data[0] : [];
    }

        public function setDataPemeriksaanPerawat()
    {
        $no_registrasi = $this->request->getVar('no_registrasi');

        helper(['restclient']);

        $url      = "{$this->server5}/api/PemeriksaanPerawat/by-no-registrasi/$no_registrasi";
        $response = akses_restapikey('GET', $url, [], []);

        $data = json_decode($response, true);

        if (!empty($data) && is_array($data)) {
            echo json_encode([
                'status' => 'success',
                'data'   => $data['data']
            ]);
        } else {
            echo json_encode([
                'status'  => 'empty',
                'message' => 'Data pemeriksaan belum tersedia'
            ]);
        }
    }

    public function getPostTindakanForPetunjuk()
    {
        $no_registrasi = $this->request->getVar('no_registrasi');

        if (empty($no_registrasi)) {
            return $this->response->setJSON(['status' => 'empty', 'data' => null]);
        }

        $row = $this->apiDataGetByRegistrasi($no_registrasi);

        if (!empty($row)) {
            return $this->response->setJSON([
                'status' => 'success',
                'data'   => [
                    'diagnosis_medis'    => $row['diagnosis_medis']    ?? '',
                    'tekanan_darah_kpot' => $row['tekanan_darah_kpot'] ?? '',
                    'suhu_kpot'          => $row['suhu_kpot']          ?? '',
                    'nadi_kpot'          => $row['nadi_kpot']          ?? '',
                    'rr_kpot'            => $row['rr_kpot']            ?? '',
                ]
            ]);
        }

        return $this->response->setJSON(['status' => 'empty', 'data' => null]);
    }

    public function action()
    {
        if (!$this->request->getPost('action')) {
            echo json_encode(['error' => ['diagnosis_medis' => 'Request tidak valid.']]);
            return;
        }

        helper(['form', 'restclient']);

        $no_registrasi = $this->request->getPost('no_registrasi') ?: $this->session->get('no_registrasi');
        if (empty($no_registrasi)) {
            echo json_encode(['error' => ['diagnosis_medis' => 'Pasien belum dipilih.']]);
            return;
        }

        $usr_id    = (string)($this->session->get('usr_id') ?? '0');
        $action    = $this->request->getPost('action');
        $usr_name  = (string)($this->session->get('emp_nm') ?? $this->session->get('fullname') ?? $usr_id);
        $is_dokter = ($this->session->get('role_cd') == 'ROLE002');

        $existingRow = $this->apiDataGetByRegistrasi($no_registrasi);

        if ($is_dokter) {
            $val_dokter  = $usr_name;
            $val_perawat = $existingRow['perawat'] ?? '';
        } else {
            $val_perawat = $usr_name;
            $val_dokter  = $existingRow['dokter'] ?? '';
        }

        $payload = [
            'no_registrasi'           => $no_registrasi,
            'created_by'              => $usr_id,
            'updated_by'              => ($action === 'Edit') ? $usr_id : null,
            'dokter'                  => $val_dokter,
            'perawat'                 => $val_perawat,
            'diagnosis_medis'         => $this->request->getPost('diagnosis_medis')         ?? '',
            'tindakan'                => $this->request->getPost('tindakan')                ?? '',
    'catatan'                 => $this->request->getPost('catatan')                 ?? '',
            'keadaan_umum_kpt'        => $this->request->getPost('keadaan_umum_kpt')        ?? '',
            'tekanan_darah_kpt'       => $this->request->getPost('tekanan_darah_kpt')       ?? '',
            'suhu_kpt'                => (float)($this->request->getPost('suhu_kpt')        ?? 0),
            'nadi_kpt'                => (int)($this->request->getPost('nadi_kpt')          ?? 0),
            'rr_kpt'                  => (int)($this->request->getPost('rr_kpt')            ?? 0),
            'spo2_kpt'                => (int)($this->request->getPost('spo2_kpt')          ?? 0),
            'keadaan_umum_kit'        => $this->request->getPost('keadaan_umum_kit')        ?? '',
            'dokter_kit'              => $this->request->getPost('dokter_kit')              ?? '',
            'obat_anestesi_lokal_kit' => $this->request->getPost('obat_anestesi_lokal_kit') ?? '',
            'dosis_obat_kit'          => $this->request->getPost('dosis_obat_kit')          ?? '',
            'rute_obat_kit'           => $this->request->getPost('rute_obat_kit')           ?? '',
            'jam_mulai_kit'           => $this->request->getPost('jam_mulai_kit')           ?? '',
            'jam_selesai_kit'         => $this->request->getPost('jam_selesai_kit')         ?? '',
            'tekanan_darah_kit'       => $this->request->getPost('tekanan_darah_kit')       ?? '',
            'suhu_kit'                => (float)($this->request->getPost('suhu_kit')        ?? 0),
            'nadi_kit'                => (int)($this->request->getPost('nadi_kit')          ?? 0),
            'rr_kit'                  => (int)($this->request->getPost('rr_kit')            ?? 0),
            'spo2_kit'                => (int)($this->request->getPost('spo2_kit')          ?? 0),
            'keadaan_umum_kpot'       => $this->request->getPost('keadaan_umum_kpot')       ?? '',
            'tekanan_darah_kpot'      => $this->request->getPost('tekanan_darah_kpot')      ?? '',
            'suhu_kpot'               => (float)($this->request->getPost('suhu_kpot')       ?? 0),
            'nadi_kpot'               => (int)($this->request->getPost('nadi_kpot')         ?? 0),
            'rr_kpot'                 => (int)($this->request->getPost('rr_kpot')           ?? 0),
            'spo2_kpot'               => (int)($this->request->getPost('spo2_kpot')         ?? 0),
        ];

        $url = "{$this->server3}/api/lotpdla";

        if ($action === 'Edit') {
            $query    = ['id' => $this->request->getPost('hidden_obs_id')];
            $response = akses_restapikey('PUT', $url, $payload, $query);
        } else {
            $response = akses_restapikey('POST', $url, $payload);
        }

        $result = json_decode($response, true);

        if ($result === null) {
            echo json_encode(['error' => ['diagnosis_medis' => 'Server tidak merespons dengan benar. Coba lagi.']]);
            return;
        }

        if (!empty($result['error'])) {
            echo json_encode(['error' => ['diagnosis_medis' => 'API Error: ' . (is_string($result['error']) ? $result['error'] : json_encode($result['error']))]]);
        } elseif (isset($result['success']) && $result['success'] === false) {
            echo json_encode(['error' => ['diagnosis_medis' => $result['message'] ?? 'Gagal menyimpan data.']]);
        } else {
            $msg = ($action === 'Edit') ? 'Data observasi berhasil diubah!' : 'Data observasi berhasil disimpan!';
            echo json_encode(['success' => $msg]);
        }
    }

    public function printObservasi($no_registrasi = null)
    {
        if (!$no_registrasi) {
            $no_registrasi = $this->request->getVar('no_registrasi');
        }

        helper(['restclient']);

        $url      = "{$this->server3}/api/lotpdla";
        $query    = [
            'action'        => 'getbynoreg',
            'no_registrasi' => $no_registrasi,
        ];
        $response = akses_restapikey('GET', $url, [], $query);
        $result   = json_decode($response, true);

        if (isset($result['data']) && is_array($result['data'])) {
            $pdf_data = $result['data'];
        } elseif (is_array($result) && isset($result[0])) {
            $pdf_data = $result;
        } else {
            $pdf_data = [];
        }

        $row = !empty($pdf_data) ? $pdf_data[0] : [];

        $gender = $this->request->getVar('gender') ?? '';
        $jk     = (stripos($gender, 'P') !== false || stripos($gender, 'Wanita') !== false || stripos($gender, 'Perempuan') !== false) ? 'P' : 'L';

        $this->data['title_pdf'] = 'Lembar Observasi Tindakan Pasien Dengan Lokal Anestesi';
        $this->data['d'] = [
            'rm'            => $this->request->getVar('no_rm')       ?? '',
            'nama'          => $this->request->getVar('nama_pasien') ?? '',
            'tgl_lahir'     => $this->request->getVar('tgl_lahir')   ?? '',
            'jk'            => $jk,
            'diagnosis'     => $row['diagnosis_medis']         ?? '',
            'tindakan'      => $row['tindakan']                ?? '',
            'pra_ku'        => $row['keadaan_umum_kpt']        ?? '',
            'pra_td'        => $row['tekanan_darah_kpt']       ?? '',
            'pra_suhu'      => $row['suhu_kpt']                ?? '',
            'pra_nadi'      => $row['nadi_kpt']                ?? '',
            'pra_rr'        => $row['rr_kpt']                  ?? '',
            'pra_spo2'      => $row['spo2_kpt']                ?? '',
            'intra_ku'      => $row['keadaan_umum_kit']        ?? '',
            'dokter'        => $row['dokter_kit']              ?? '',
            'obat_anestesi' => $row['obat_anestesi_lokal_kit'] ?? '',
            'dosis'         => $row['dosis_obat_kit']          ?? '',
            'rute'          => $row['rute_obat_kit']           ?? '',
            'jam_mulai'     => $row['jam_mulai_kit']           ?? '',
            'jam_selesai'   => $row['jam_selesai_kit']         ?? '',
            'intra_td'      => $row['tekanan_darah_kit']       ?? '',
            'intra_suhu'    => $row['suhu_kit']                ?? '',
            'intra_nadi'    => $row['nadi_kit']                ?? '',
            'intra_rr'      => $row['rr_kit']                  ?? '',
            'intra_spo2'    => $row['spo2_kit']                ?? '',
            'post_ku'       => $row['keadaan_umum_kpot']       ?? '',
            'post_td'       => $row['tekanan_darah_kpot']      ?? '',
            'post_suhu'     => $row['suhu_kpot']               ?? '',
            'post_nadi'     => $row['nadi_kpot']               ?? '',
            'post_rr'       => $row['rr_kpot']                 ?? '',
            'post_spo2'     => $row['spo2_kpot']               ?? '',
            'catatan'       => $row['catatan']                 ?? '',
            'perawat'       => '',
            'dokter_nama'   => $row['dokter']                  ?? '',
            'kota_tgl'      => 'Surabaya, ' . date('d/m/Y'),
        ];

        $html = view('observasi/observasi_pdf', $this->data);

        $Pdfgenerator = new Pdfgenerator();
        $Pdfgenerator->generate($html, 'Observasi_' . $no_registrasi, 'A4', 'portrait');
    }
}