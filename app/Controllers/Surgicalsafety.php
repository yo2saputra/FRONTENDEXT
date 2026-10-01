<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

class Surgicalsafety extends BaseController
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
        return view('surgicalsafety/index', $this->data);
    }

    public function delete()
    {
        $no_registrasi = $this->request->getVar('no_registrasi');
        helper(['restclient']);

        $url    = "{$this->server3}/api/surgical-safety-checklist/{$no_registrasi}";
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

    public function fetchByRegistrasi()
    {
        $no_registrasi = $this->request->getVar('no_registrasi');

        if (empty($no_registrasi)) {
            return $this->response->setJSON(['data' => null]);
        }

        helper(['restclient']);

        $url      = "{$this->server3}/api/surgical-safety-checklist/{$no_registrasi}";
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

        if (isset($row['error']) || isset($row['errors'])) {
            $row = [];
        }

        return $this->response->setJSON(['data' => empty($row) ? null : $row]);
    }

    private function formatJam($jam): ?string
    {
        if ($jam === null || $jam === '' || $jam === false) return null;
        $jam = trim((string)$jam);
        if ($jam === '') return null;
        if (strlen($jam) >= 8) return substr($jam, 0, 8);
        if (strlen($jam) === 5) return $jam . ':00';
        return $jam;
    }

    private function bsvToDateTime($val): ?string
    {
        if ($val === null || $val === '' || $val === false) return null;
        $val = trim((string)$val);
        if ($val === '') return null;
        if ($val === 'ya') return date('Y-m-d\TH:i:s');
        if (str_contains($val, 'T')) return $val;
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $val)) return $val . 'T00:00:00';
        return null;
    }

    private function formatTanggal($tgl): ?string
    {
        if (empty($tgl)) return null;
        $tgl = trim((string)$tgl);
        if ($tgl === '') return null;
        if (str_contains($tgl, 'T')) return $tgl;
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $tgl)) return $tgl . 'T00:00:00';
        return null;
    }

    public function action()
    {
        $fase = $this->request->getPost('fase');

        if (!$fase || !in_array($fase, ['signin', 'timeout', 'signout'])) {
            echo json_encode(['error' => 'Request tidak valid. Fase tidak dikenali.']);
            return;
        }

        helper(['form', 'restclient']);

        $no_registrasi = $this->request->getPost('no_registrasi') ?: $this->session->get('no_registrasi');
        if (empty($no_registrasi)) {
            echo json_encode(['error' => 'Pasien belum dipilih.']);
            return;
        }

        $usr_id   = (string)($this->session->get('usr_id') ?? '0');
        $usr_name = (string)($this->session->get('emp_nm') ?? $this->session->get('fullname') ?? $usr_id);
        $isEdit   = ($this->request->getPost('is_edit') === '1');

        if ($fase === 'signin') {

            $existingUrl  = "{$this->server3}/api/surgical-safety-checklist/{$no_registrasi}";
            $existingResp = akses_restapikey('GET', $existingUrl, []);
            $existing     = json_decode($existingResp, true);
            $existingRow  = [];

            if (isset($existing['data'])) {
                $existingRow = isset($existing['data'][0]) ? $existing['data'][0] : $existing['data'];
            } elseif (is_array($existing) && !empty($existing) && !isset($existing['message'])) {
                $existingRow = isset($existing[0]) ? $existing[0] : $existing;
            }

            $payload = [
                'no_registrasi'                    => $no_registrasi,
                'tgl_tindakan'                     => $this->formatTanggal($this->request->getPost('tgl_tindakan') ?? date('Y-m-d')),
                'jenis_tindakan'                   => $this->request->getPost('jenis_tindakan')                   ?? '',
                'diagnosa'                         => $this->request->getPost('diagnosa')                         ?? '',
                'jenis_anastesi'                   => $this->request->getPost('jenis_anastesi')                   ?? '',
                'obat_anastesi'                    => $this->request->getPost('obat_anastesi')                    ?? '',
                'dokter_operator'                  => $this->request->getPost('dokter_operator')                  ?? '',
                'jam_signin'                       => $this->formatJam($this->request->getPost('jam_signin')),
                'identitas_pasien_verifikasi'      => $this->request->getPost('identitas_pasien_verifikasi')      ?? 'tidak',
                'informed_consent_verifikasi'      => $this->request->getPost('informed_consent_verifikasi')      ?? 'tidak',
                'tanda_lokasi_operasi'             => $this->request->getPost('tanda_lokasi_operasi')             ?? '',
                'diagnosa_pasien'                  => $this->request->getPost('diagnosa_pasien')                  ?? '',
                'tekanan_darah_ttv_si'             => $this->request->getPost('tekanan_darah_ttv_si')             ?? '',
                'nadi_ttv_si'                      => (int)($this->request->getPost('nadi_ttv_si')                ?? 0),
                'suhu_ttv_si'                      => (float)($this->request->getPost('suhu_ttv_si')              ?? 0),
                'rr_ttv_si'                        => (int)($this->request->getPost('rr_ttv_si')                  ?? 0),
                'riwayat_alergi_ra'                => $this->request->getPost('riwayat_alergi_ra')                ?? '',
                'sebutkan_ra'                      => $this->request->getPost('sebutkan_ra')                      ?? '',
                'resikoaspirasi_ganguanpernafasan' => $this->request->getPost('resikoaspirasi_ganguanpernafasan') ?? '',
                'resiko_perdarahan'                => $this->request->getPost('resiko_perdarahan')                ?? '',
                'petugas_si'                       => $usr_name,
                'tekanan_darah_ttv_to'             => $existingRow['tekanan_darah_ttv_to']    ?? '',
                'nadi_ttv_to'                      => (int)($existingRow['nadi_ttv_to']       ?? 0),
                'suhu_ttv_to'                      => (float)($existingRow['suhu_ttv_to']     ?? 0),
                'rr_ttv_to'                        => (int)($existingRow['rr_ttv_to']         ?? 0),
                'jam_timeout'                      => $this->formatJam($existingRow['jam_timeout'] ?? null),
                'kelengkapantim_ktdfo'             => $existingRow['kelengkapantim_ktdfo']    ?? '',
                'alasan_tdklengkap_ktdfo'          => $existingRow['alasan_tdklengkap_ktdfo'] ?? '',
                'istrument_pkpo'                   => $existingRow['istrument_pkpo']          ?? 'tidak',
                'kassa_pkpo'                       => $existingRow['kassa_pkpo']              ?? 'tidak',
                'jarum_pkpo'                       => $existingRow['jarum_pkpo']              ?? 'tidak',
                'tgl_tindakan_bsv'                 => $existingRow['tgl_tindakan_bsv']        ?? 'tidak',
                'nama_tindakan_bsv'                => $existingRow['nama_tindakan_bsv']       ?? 'tidak',
                'lokasi_tindakan_bsv'              => $existingRow['lokasi_tindakan_bsv']     ?? 'tidak',
                'identitas_pasien_bsv'             => $existingRow['identitas_pasien_bsv']    ?? 'tidak',
                'prosedur_tindakan_bsv'            => $existingRow['prosedur_tindakan_bsv']   ?? 'tidak',
                'informed_consent_bsv'             => $existingRow['informed_consent_bsv']    ?? 'tidak',
                'diberikan_kurang_dari60menit_ap'  => $existingRow['diberikan_kurang_dari60menit_ap'] ?? '',
                'nama_obat_ap'                     => $existingRow['nama_obat_ap']            ?? '',
                'dosis_obat_ap'                    => $existingRow['dosis_obat_ap']           ?? '',
                'jam_diberikan_ap'                 => $this->formatJam($existingRow['jam_diberikan_ap'] ?? null),
                'petugas_to'                       => $existingRow['petugas_to']              ?? '',

                'jam_signout'                      => $this->formatJam($existingRow['jam_signout'] ?? null),
                'istrument_pkslod'                 => $existingRow['istrument_pkslod']        ?? 'tidak',
                'kassa_pkslod'                     => $existingRow['kassa_pkslod']            ?? 'tidak',
                'jarum_pkslod'                     => $existingRow['jarum_pkslod']            ?? 'tidak',
                'preparat_pkbp'                    => $existingRow['preparat_pkbp']           ?? '',
                'jenis_pkbp'                       => $existingRow['jenis_pkbp']              ?? '',
                'lainnya_pkbp'                     => $existingRow['lainnya_pkbp']            ?? '',
                'tekanan_darah_ttv_so'             => $existingRow['tekanan_darah_ttv_so']    ?? '',
                'nadi_ttv_so'                      => (int)($existingRow['nadi_ttv_so']       ?? 0),
                'suhu_ttv_so'                      => (float)($existingRow['suhu_ttv_so']     ?? 0),
                'rr_ttv_so'                        => (int)($existingRow['rr_ttv_so']         ?? 0),
                'skalanyeri_ttv_so'                => $existingRow['skalanyeri_ttv_so']       ?? '',
                'rembesan_pklo'                    => $existingRow['rembesan_pklo']           ?? '',
                'instruksi_khusus'                 => $existingRow['instruksi_khusus']        ?? '',
                'petugas_so'                       => $existingRow['petugas_so']              ?? '',
                'updated_by'                       => $usr_id,
            ];

            if (!empty($existingRow)) {
                $url      = "{$this->server3}/api/surgical-safety-checklist/{$no_registrasi}";
                $response = akses_restapikey('PUT', $url, $payload);
            } else {
                $payload['created_by'] = $usr_id;
                $url      = "{$this->server3}/api/surgical-safety-checklist";
                $response = akses_restapikey('POST', $url, $payload);
            }

        } elseif ($fase === 'timeout') {

            $existingUrl  = "{$this->server3}/api/surgical-safety-checklist/{$no_registrasi}";
            $existingResp = akses_restapikey('GET', $existingUrl, []);
            $existing     = json_decode($existingResp, true);
            $existingRow  = [];

            if (isset($existing['data'])) {
                $existingRow = isset($existing['data'][0]) ? $existing['data'][0] : $existing['data'];
            } elseif (is_array($existing) && !empty($existing) && !isset($existing['message'])) {
                $existingRow = isset($existing[0]) ? $existing[0] : $existing;
            }

            $payload = [
                'no_registrasi'                    => $no_registrasi,

                'tgl_tindakan'                     => $this->formatTanggal($existingRow['tgl_tindakan'] ?? date('Y-m-d')),
                'jenis_tindakan'                   => $existingRow['jenis_tindakan']                   ?? '',
                'diagnosa'                         => $existingRow['diagnosa']                         ?? '',
                'jenis_anastesi'                   => $existingRow['jenis_anastesi']                   ?? '',
                'obat_anastesi'                    => $existingRow['obat_anastesi']                    ?? '',
                'dokter_operator'                  => $existingRow['dokter_operator']                  ?? '',
                'jam_signin'                       => $this->formatJam($existingRow['jam_signin']      ?? null),
                'identitas_pasien_verifikasi'      => $existingRow['identitas_pasien_verifikasi']      ?? '',
                'informed_consent_verifikasi'      => $existingRow['informed_consent_verifikasi']      ?? '',
                'tanda_lokasi_operasi'             => $existingRow['tanda_lokasi_operasi']             ?? '',
                'diagnosa_pasien'                  => $existingRow['diagnosa_pasien']                  ?? '',
                'tekanan_darah_ttv_si'             => $existingRow['tekanan_darah_ttv_si']             ?? '',
                'nadi_ttv_si'                      => (int)($existingRow['nadi_ttv_si']                ?? 0),
                'suhu_ttv_si'                      => (float)($existingRow['suhu_ttv_si']              ?? 0),
                'rr_ttv_si'                        => (int)($existingRow['rr_ttv_si']                  ?? 0),
                'riwayat_alergi_ra'                => $existingRow['riwayat_alergi_ra']                ?? '',
                'sebutkan_ra'                      => $existingRow['sebutkan_ra']                      ?? '',
                'resikoaspirasi_ganguanpernafasan' => $existingRow['resikoaspirasi_ganguanpernafasan'] ?? '',
                'resiko_perdarahan'                => $existingRow['resiko_perdarahan']                ?? '',
                'petugas_si'                       => $existingRow['petugas_si']                       ?? '',


                'jam_timeout'                      => $this->formatJam($this->request->getPost('jam_timeout')),
                'kelengkapantim_ktdfo'             => $this->request->getPost('kelengkapantim_ktdfo')             ?? '',
                'tekanan_darah_ttv_to'             => $this->request->getPost('tekanan_darah_ttv_to')             ?? '',
                'nadi_ttv_to'                      => (int)($this->request->getPost('nadi_ttv_to')                ?? 0),
                'suhu_ttv_to'                      => (float)($this->request->getPost('suhu_ttv_to')              ?? 0),
                'rr_ttv_to'                        => (int)($this->request->getPost('rr_ttv_to')                  ?? 0),
                'alasan_tdklengkap_ktdfo'          => $this->request->getPost('alasan_tdklengkap_ktdfo')          ?? '',
                'istrument_pkpo'                   => $this->request->getPost('istrument_pkpo')                   ?? 'tidak',
                'kassa_pkpo'                       => $this->request->getPost('kassa_pkpo')                       ?? 'tidak',
                'jarum_pkpo'                       => $this->request->getPost('jarum_pkpo')                       ?? 'tidak',
                'tgl_tindakan_bsv'                => $this->request->getPost('tgl_tindakan_bsv')                ?? 'tidak',
                'nama_tindakan_bsv'                => $this->request->getPost('nama_tindakan_bsv')                ?? 'tidak',
                'lokasi_tindakan_bsv'              => $this->request->getPost('lokasi_tindakan_bsv')              ?? 'tidak',
                'identitas_pasien_bsv'             => $this->request->getPost('identitas_pasien_bsv')             ?? 'tidak',
                'prosedur_tindakan_bsv'            => $this->request->getPost('prosedur_tindakan_bsv')            ?? 'tidak',
                'informed_consent_bsv'             => $this->request->getPost('informed_consent_bsv')             ?? 'tidak',
                'diberikan_kurang_dari60menit_ap'  => $this->request->getPost('diberikan_kurang_dari60menit_ap')  ?? '',
                'nama_obat_ap'                     => $this->request->getPost('nama_obat_ap')                     ?? '',
                'dosis_obat_ap'                    => $this->request->getPost('dosis_obat_ap')                    ?? '',
                'jam_diberikan_ap'                 => $this->formatJam($this->request->getPost('jam_diberikan_ap')),
                'petugas_to'                       => $usr_name,

                'jam_signout'                      => $this->formatJam($existingRow['jam_signout']     ?? null),
                'istrument_pkslod'                 => $existingRow['istrument_pkslod']                 ?? 'tidak',
                'kassa_pkslod'                     => $existingRow['kassa_pkslod']                     ?? 'tidak',
                'jarum_pkslod'                     => $existingRow['jarum_pkslod']                     ?? 'tidak',
                'preparat_pkbp'                    => $existingRow['preparat_pkbp']                    ?? '',
                'jenis_pkbp'                       => $existingRow['jenis_pkbp']                       ?? '',
                'lainnya_pkbp'                     => $existingRow['lainnya_pkbp']                     ?? '',
                'tekanan_darah_ttv_so'             => $existingRow['tekanan_darah_ttv_so']             ?? '',
                'nadi_ttv_so'                      => (int)($existingRow['nadi_ttv_so']                ?? 0),
                'suhu_ttv_so'                      => (float)($existingRow['suhu_ttv_so']              ?? 0),
                'rr_ttv_so'                        => (int)($existingRow['rr_ttv_so']                  ?? 0),
                'skalanyeri_ttv_so'                => $existingRow['skalanyeri_ttv_so']                ?? '',
                'rembesan_pklo'                    => $existingRow['rembesan_pklo']                    ?? '',
                'instruksi_khusus'                 => $existingRow['instruksi_khusus']                 ?? '',
                'petugas_so'                       => $existingRow['petugas_so']                       ?? '',
                'updated_by'                       => $usr_id,
            ];

            $url      = "{$this->server3}/api/surgical-safety-checklist/{$no_registrasi}";
            log_message('debug', '[TIMEOUT REQUEST BODY] ' . json_encode($payload));
            $response = akses_restapikey('PUT', $url, $payload);
            log_message('debug', '[TIMEOUT RAW RESPONSE] ' . $response);

        } else {

            $existingUrl  = "{$this->server3}/api/surgical-safety-checklist/{$no_registrasi}";
            $existingResp = akses_restapikey('GET', $existingUrl, []);
            $existing     = json_decode($existingResp, true);
            $existingRow  = [];

            if (isset($existing['data'])) {
                $existingRow = isset($existing['data'][0]) ? $existing['data'][0] : $existing['data'];
            } elseif (is_array($existing) && !empty($existing) && !isset($existing['message'])) {
                $existingRow = isset($existing[0]) ? $existing[0] : $existing;
            }

            $payload = [
                'no_registrasi'                    => $no_registrasi,

                'tgl_tindakan'                     => $this->formatTanggal($existingRow['tgl_tindakan'] ?? date('Y-m-d')),
                'jenis_tindakan'                   => $existingRow['jenis_tindakan']                   ?? '',
                'diagnosa'                         => $existingRow['diagnosa']                         ?? '',
                'jenis_anastesi'                   => $existingRow['jenis_anastesi']                   ?? '',
                'obat_anastesi'                    => $existingRow['obat_anastesi']                    ?? '',
                'dokter_operator'                  => $existingRow['dokter_operator']                  ?? '',
                'jam_signin'                       => $this->formatJam($existingRow['jam_signin']      ?? null),
                'identitas_pasien_verifikasi'      => $existingRow['identitas_pasien_verifikasi']      ?? '',
                'informed_consent_verifikasi'      => $existingRow['informed_consent_verifikasi']      ?? '',
                'tanda_lokasi_operasi'             => $existingRow['tanda_lokasi_operasi']             ?? '',
                'diagnosa_pasien'                  => $existingRow['diagnosa_pasien']                  ?? '',
                'tekanan_darah_ttv_si'             => $existingRow['tekanan_darah_ttv_si']             ?? '',
                'nadi_ttv_si'                      => (int)($existingRow['nadi_ttv_si']                ?? 0),
                'suhu_ttv_si'                      => (float)($existingRow['suhu_ttv_si']              ?? 0),
                'rr_ttv_si'                        => (int)($existingRow['rr_ttv_si']                  ?? 0),
                'riwayat_alergi_ra'                => $existingRow['riwayat_alergi_ra']                ?? '',
                'sebutkan_ra'                      => $existingRow['sebutkan_ra']                      ?? '',
                'resikoaspirasi_ganguanpernafasan' => $existingRow['resikoaspirasi_ganguanpernafasan'] ?? '',
                'resiko_perdarahan'                => $existingRow['resiko_perdarahan']                ?? '',
                'petugas_si'                       => $existingRow['petugas_si']                       ?? '',

                'jam_timeout'                      => $this->formatJam($existingRow['jam_timeout']     ?? null),
                'kelengkapantim_ktdfo'             => $existingRow['kelengkapantim_ktdfo']             ?? '',
                'tekanan_darah_ttv_to'             => $existingRow['tekanan_darah_ttv_to']             ?? '',
                'nadi_ttv_to'                      => (int)($existingRow['nadi_ttv_to']                ?? 0),
                'suhu_ttv_to'                      => (float)($existingRow['suhu_ttv_to']              ?? 0),
                'rr_ttv_to'                        => (int)($existingRow['rr_ttv_to']                  ?? 0),
                'alasan_tdklengkap_ktdfo'          => $existingRow['alasan_tdklengkap_ktdfo']          ?? '',
                'istrument_pkpo'                   => $existingRow['istrument_pkpo']                   ?? 'tidak',
                'kassa_pkpo'                       => $existingRow['kassa_pkpo']                       ?? 'tidak',
                'jarum_pkpo'                       => $existingRow['jarum_pkpo']                       ?? 'tidak',
                'tgl_tindakan_bsv'                 => $existingRow['tgl_tindakan_bsv']                 ?? 'tidak',
                'nama_tindakan_bsv'                => $existingRow['nama_tindakan_bsv']                ?? 'tidak',
                'lokasi_tindakan_bsv'              => $existingRow['lokasi_tindakan_bsv']              ?? 'tidak',
                'identitas_pasien_bsv'             => $existingRow['identitas_pasien_bsv']             ?? 'tidak',
                'prosedur_tindakan_bsv'            => $existingRow['prosedur_tindakan_bsv']            ?? 'tidak',
                'informed_consent_bsv'             => $existingRow['informed_consent_bsv']             ?? 'tidak',
                'diberikan_kurang_dari60menit_ap'  => $existingRow['diberikan_kurang_dari60menit_ap']  ?? '',
                'nama_obat_ap'                     => $existingRow['nama_obat_ap']                     ?? '',
                'dosis_obat_ap'                    => $existingRow['dosis_obat_ap']                    ?? '',
                'jam_diberikan_ap'                 => $this->formatJam($existingRow['jam_diberikan_ap'] ?? null),
                'petugas_to'                       => $existingRow['petugas_to']                       ?? '',

                'jam_signout'                      => $this->formatJam($this->request->getPost('jam_signout')),
                'istrument_pkslod'                 => $this->request->getPost('istrument_pkslod')                 ?? 'tidak',
                'kassa_pkslod'                     => $this->request->getPost('kassa_pkslod')                     ?? 'tidak',
                'jarum_pkslod'                     => $this->request->getPost('jarum_pkslod')                     ?? 'tidak',
                'preparat_pkbp'                    => $this->request->getPost('preparat_pkbp')                    ?? '',
                'jenis_pkbp'                       => $this->request->getPost('jenis_pkbp')                       ?? '',
                'lainnya_pkbp'                     => $this->request->getPost('lainnya_pkbp')                     ?? '',
                'tekanan_darah_ttv_so'             => $this->request->getPost('tekanan_darah_ttv_so')             ?? '',
                'nadi_ttv_so'                      => (int)($this->request->getPost('nadi_ttv_so')                ?? 0),
                'suhu_ttv_so'                      => (float)($this->request->getPost('suhu_ttv_so')              ?? 0),
                'rr_ttv_so'                        => (int)($this->request->getPost('rr_ttv_so')                  ?? 0),
                'skalanyeri_ttv_so'                => $this->request->getPost('skalanyeri_ttv_so')                ?? '',
                'rembesan_pklo'                    => $this->request->getPost('rembesan_pklo')                    ?? '',
                'instruksi_khusus'                 => $this->request->getPost('instruksi_khusus')                 ?? '',
                'petugas_so'                       => $usr_name,
                'updated_by'                       => $usr_id,
            ];

            $url      = "{$this->server3}/api/surgical-safety-checklist/{$no_registrasi}";
            $response = akses_restapikey('PUT', $url, $payload);
        }

        if ($response === null || $response === '') {
            echo json_encode(['error' => 'API tidak mengembalikan response. Endpoint: ' . $url]);
            return;
        }

        $result = json_decode($response, true);

        if ($result === null) {
            echo json_encode(['error' => 'Response API bukan JSON valid. Preview: ' . substr(strip_tags($response), 0, 300)]);
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

        $messages = [
            'signin'  => 'Sign In berhasil disimpan!',
            'timeout' => 'Time Out berhasil disimpan!',
            'signout' => 'Sign Out berhasil disimpan!',
        ];
        echo json_encode(['success' => $messages[$fase], 'fase' => $fase]);
    }

    public function printSurgical($no_registrasi = null)
    {
        if (!$no_registrasi) {
            $no_registrasi = $this->request->getVar('no_registrasi');
        }

        helper(['restclient']);

        $url      = "{$this->server3}/api/surgical-safety-checklist/{$no_registrasi}";
        $response = akses_restapikey('GET', $url, []);
        $result   = json_decode($response, true);

        if (isset($result['data']) && is_array($result['data'])) {
            $row = isset($result['data'][0]) ? $result['data'][0] : $result['data'];
        } elseif (is_array($result) && !empty($result) && !isset($result['message'])) {
            $row = isset($result[0]) ? $result[0] : $result;
        } else {
            $row = [];
        }

        $chk_ya = function($val) {
            return (strtolower(trim((string)$val)) === 'ya') ? 'v' : '';
        };
        
        $chk_value = function($val, $expected) {
            return (strtolower(trim((string)$val)) === strtolower($expected)) ? 'v' : '';
        };

        $fmt_jam = function($v) {
            if (empty($v)) return '........';
            $jam = (string)$v;
            return (strlen($jam) >= 5) ? substr($jam, 0, 5) : $jam;
        };

        $fmt_tgl = function($v) {
            if (empty($v)) return '';
            return substr((string)$v, 0, 10);
        };

        $this->data['title_pdf'] = 'SURGICAL SAFETY CHECKLIST';
        $this->data['d'] = [
            'rm'             => $this->request->getVar('no_rm')       ?? '-',
            'nama'           => $this->request->getVar('nama_pasien') ?? '-',
            'tgl_lahir'      => $this->request->getVar('tgl_lahir')   ?? '-',
            'gender'         => $this->request->getVar('gender')      ?? '',
            
            'diagnosis'      => $row['diagnosa'] ?? '-',
            'jenis_anestesi' => $row['jenis_anastesi'] ?? '-',
            'obat_anestesi'  => $row['obat_anastesi'] ?? '-',
            'tgl_tindakan'   => $fmt_tgl($row['tgl_tindakan'] ?? ''),
            'dokter'         => $row['dokter_operator'] ?? '-',
            'jenis_tindakan' => $row['jenis_tindakan'] ?? '-',
            
            'signin_jam'       => $fmt_jam($row['jam_signin'] ?? ''),
            'signin_identitas' => $chk_ya($row['identitas_pasien_verifikasi'] ?? ''),
            'signin_consent'   => $chk_ya($row['informed_consent_verifikasi'] ?? ''),
            'signin_lokasi_ya'    => $chk_value($row['tanda_lokasi_operasi'] ?? '', 'Ya'),
            'signin_lokasi_tidak' => $chk_value($row['tanda_lokasi_operasi'] ?? '', 'Tidak'),
            'signin_diagnosa'  => $row['diagnosa_pasien'] ?? '-',
            'signin_td'        => $row['tekanan_darah_ttv_si'] ?? '-',
            'signin_n'         => $row['nadi_ttv_si'] ?? '-',
            'signin_s'         => $row['suhu_ttv_si'] ?? '-',
            'signin_rr'        => $row['rr_ttv_si'] ?? '-',
            'signin_alergi_ada'    => ($row['riwayat_alergi_ra'] ?? '') !== 'tidak_ada' ? 'v' : '',
            'signin_alergi_tidak'  => ($row['riwayat_alergi_ra'] ?? '') === 'tidak_ada' ? 'v' : '',
            'signin_alergi_nama'   => ($row['riwayat_alergi_ra'] ?? '') !== 'tidak_ada' ? ($row['sebutkan_ra'] ?? '') : '',
            'signin_aspirasi_ya'    => $chk_value($row['resikoaspirasi_ganguanpernafasan'] ?? '', 'Ya'),
            'signin_aspirasi_tidak' => $chk_value($row['resikoaspirasi_ganguanpernafasan'] ?? '', 'Tidak'),
            'signin_darah_ya'       => $chk_value($row['resiko_perdarahan'] ?? '', 'Ya'),
            'signin_darah_tidak'    => $chk_value($row['resiko_perdarahan'] ?? '', 'Tidak'),
            
            'timeout_jam'    => $fmt_jam($row['jam_timeout'] ?? ''),
            'timeout_td' => $row['tekanan_darah_ttv_to'] ?? '-',
            'timeout_n'  => $row['nadi_ttv_to'] ?? '-',
            'timeout_s'  => $row['suhu_ttv_to'] ?? '-',
            'timeout_rr' => $row['rr_ttv_to'] ?? '-',
            'timeout_tim_lengkap' => $chk_value($row['kelengkapantim_ktdfo'] ?? '', 'lengkap'),
            'timeout_tim_tidak'   => $chk_value($row['kelengkapantim_ktdfo'] ?? '', 'tidak_leng') || $chk_value($row['kelengkapantim_ktdfo'] ?? '', 'tidak_lengkap') ? 'v' : '',
            'timeout_alasan' => $row['alasan_tdklengkap_ktdfo'] ?? '',
            'timeout_inst'   => $chk_ya($row['istrument_pkpo'] ?? ''),
            'timeout_kassa'  => $chk_ya($row['kassa_pkpo'] ?? ''),
            'timeout_jarum'  => $chk_ya($row['jarum_pkpo'] ?? ''),
            
            'verb_tgl'       => $chk_ya($row['tgl_tindakan_bsv'] ?? ''),
            'verb_nama'      => $chk_ya($row['nama_tindakan_bsv'] ?? ''),
            'verb_lokasi'    => $chk_ya($row['lokasi_tindakan_bsv'] ?? ''),
            'verb_identitas' => $chk_ya($row['identitas_pasien_bsv'] ?? ''),
            'verb_prosedur'  => $chk_ya($row['prosedur_tindakan_bsv'] ?? ''),
            'verb_consent'   => $chk_ya($row['informed_consent_bsv'] ?? ''),
            
            'timeout_ab_tidak' => $chk_value($row['diberikan_kurang_dari60menit_ap'] ?? '', 'Tidak'),
            'timeout_ab_ya'    => $chk_value($row['diberikan_kurang_dari60menit_ap'] ?? '', 'Ya'),
            'timeout_ab_nama'  => $row['nama_obat_ap'] ?? '',
            'timeout_ab_dosis' => $row['dosis_obat_ap'] ?? '',
            'timeout_ab_jam'   => $fmt_jam($row['jam_diberikan_ap'] ?? ''),
            
            'signout_jam'      => $fmt_jam($row['jam_signout'] ?? ''),
            'signout_inst'     => $chk_ya($row['istrument_pkslod'] ?? ''),
            'signout_kassa'    => $chk_ya($row['kassa_pkslod'] ?? ''),
            'signout_jarum'    => $chk_ya($row['jarum_pkslod'] ?? ''),
            'signout_spesimen_ya'    => $chk_value($row['preparat_pkbp'] ?? '', 'Ya'),
            'signout_spesimen_tidak' => $chk_value($row['preparat_pkbp'] ?? '', 'Tidak'),
            'signout_jenis_pa'        => $chk_value($row['jenis_pkbp'] ?? '', 'PA'),
            'signout_jenis_kultur'    => $chk_value($row['jenis_pkbp'] ?? '', 'Kultur'),
            'signout_jenis_sitologi' => $chk_value($row['jenis_pkbp'] ?? '', 'sitologi'),
            'signout_jenis_tidakada'  => $chk_value($row['jenis_pkbp'] ?? '', 'Tidak ada'),
            'signout_jenis_lainnya'   => $chk_value($row['jenis_pkbp'] ?? '', 'Lainnya'),
            'signout_jenis_lainnya_text' => $row['lainnya_pkbp'] ?? '',
            'signout_td'       => $row['tekanan_darah_ttv_so'] ?? '-',
            'signout_n'        => $row['nadi_ttv_so'] ?? '-',
            'signout_s'        => $row['suhu_ttv_so'] ?? '-',
            'signout_rr'       => $row['rr_ttv_so'] ?? '-',
            'signout_nyeri'    => $row['skalanyeri_ttv_so'] ?? '-',
            'signout_rembes_ada'   => $chk_value($row['rembesan_pklo'] ?? '', 'ada'),
            'signout_rembes_tidak' => $chk_value($row['rembesan_pklo'] ?? '', 'tidak_ada'),
            'signout_instruksi' => $row['instruksi_khusus'] ?? '',
            
            'ttd_signin'  => $row['petugas_si'] ?? '..........',
            'ttd_timeout' => $row['petugas_to'] ?? '..........',
            'ttd_signout' => $row['petugas_so'] ?? '..........',
        ];

        $html = view('surgicalsafety/surgicalsafety_pdf', $this->data);
        $Pdfgenerator = new Pdfgenerator();
        $Pdfgenerator->generate($html, 'SurgicalSafety_' . $no_registrasi, 'A4', 'portrait');
    }
}