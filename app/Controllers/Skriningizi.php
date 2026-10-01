<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

class Skriningizi extends BaseController
{
    protected $data;
    protected $server;
    protected $server5;

    public function __construct()
    {
        $this->session  = session();
        $this->server   = $_ENV['APP_API'];
        $this->server5  = $_ENV['APP_API5'];
    }

    public function index()
    {
        $this->data['session_usr_id'] = (string)($this->session->get('usr_id') ?? '');
        return view('skriningizi/index', $this->data);
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

    private function apiDataGetByRegistrasi($no_registrasi)
    {
        helper(['restclient']);
        $url      = "{$this->server5}/api/SkriningGizi/{$no_registrasi}";
        $response = akses_restapikey('GET', $url, [], []);
        $result   = json_decode($response, true);

        if (isset($result['data']) && is_array($result['data'])) {
            $row = isset($result['data'][0]) ? $result['data'][0] : $result['data'];
        } elseif (is_array($result) && !empty($result) && !isset($result['message'])) {
            $row = isset($result[0]) ? $result[0] : $result;
        } else {
            $row = [];
        }

        if (!empty($row) && isset($row['noRegistrasi']) && $row['noRegistrasi'] !== $no_registrasi) {
            $row = [];
        }
        if (isset($row['error']) || isset($row['errors'])) {
            $row = [];
        }

        return $row;
    }

    public function fetchByRegistrasi()
    {
        $no_registrasi = $this->request->getVar('no_registrasi');

        if (empty($no_registrasi)) {
            echo '<p class="text-muted text-center py-3">Pilih pasien untuk melihat data skrining gizi.</p>';
            return;
        }

        $row = $this->apiDataGetByRegistrasi($no_registrasi);

        $tbl_wrap  = 'style="border:2px solid #333; width:100%; background-color:#fff; color:#333; border-collapse:collapse; table-layout:fixed;"';
        $th_style  = 'style="border:1px solid #333; background-color:#f4f6f9; color:#333; vertical-align:middle; padding:6px 8px; text-align:center;"';
        $td_click  = 'style="border:1px solid #333; background-color:#fff; color:#333; vertical-align:top; padding:6px 8px; cursor:pointer; word-break:break-word; overflow-wrap:break-word;" title="Klik untuk edit"';
        $td_center = 'style="border:1px solid #333; background-color:#fff; color:#333; vertical-align:top; text-align:center; padding:6px 8px;"';

        $output = '
            <table ' . $tbl_wrap . '>
                <thead style="text-align:center; border-bottom:2px solid #333;">
                    <tr>
                        <th ' . $th_style . ' style="width:14%;">Info</th>
                        <th ' . $th_style . ' style="width:12%;">Jenis</th>
                        <th ' . $th_style . ' style="width:38%;">Skrining</th>
                        <th ' . $th_style . ' style="width:14%;">Perlu Pengkajian</th>
                        <th ' . $th_style . ' style="width:14%;">Petugas</th>
                        <th ' . $th_style . ' style="width:8%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
        ';

        if (empty($row)) {
            $output .= '<tr><td colspan="6" style="border:1px solid #333; color:#777; text-align:center; padding:20px; font-style:italic;">Belum ada data skrining gizi untuk pasien ini.</td></tr>';
        } else {
            $no_reg_row = htmlspecialchars($row['noRegistrasi'] ?? '');
            $row_data   = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');

            $fmt_dt = function ($raw) {
                if (!$raw) return '-';
                try {
                    return (new \DateTime($raw))->format('d/m/Y H:i');
                } catch (\Exception $e) {
                    return htmlspecialchars($raw);
                }
            };

            $created_by   = htmlspecialchars($row['createdBy'] ?? '-');
            $created_at   = $fmt_dt($row['createdDate'] ?? null);
            $updated_by   = $row['updatedBy'] ?? null;
            $updated_at   = $row['updatedDate'] ?? null;
            $show_updated = $updated_by && ($updated_at !== ($row['createdDate'] ?? null));

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

            $jenis = htmlspecialchars($row['jenisScreening'] ?? '-');

            if ($jenis === 'DEWASA') {
                $col_skrining = '<small>'
                    . '<b>Penurunan BB:</b> ' . htmlspecialchars((string)($row['penurunanBeratBadan'] ?? '-')) . '<br>'
                    . '<b>Jumlah Penurunan:</b> ' . htmlspecialchars((string)($row['jumlahPenurunanBeratBadan'] ?? '-')) . '<br>'
                    . '<b>Asupan Berkurang:</b> ' . htmlspecialchars((string)($row['asupanBerkurang'] ?? '-')) . '<br>'
                    . '<b>Diagnosa Khusus:</b> ' . htmlspecialchars((string)($row['diagnosaKhusus'] ?? '-'))
                    . '</small>';
            } else {
                $col_skrining = '<small>'
                    . '<b>Tampak Kurus:</b> ' . htmlspecialchars((string)($row['tampakKurus'] ?? '-')) . '<br>'
                    . '<b>Penurunan BB:</b> ' . htmlspecialchars((string)($row['anakPenurunanBeratBadan'] ?? '-')) . '<br>'
                    . '<b>Kondisi:</b> ' . htmlspecialchars((string)($row['kondisi'] ?? '-')) . '<br>'
                    . '<b>Penyakit/Keadaan:</b> ' . htmlspecialchars((string)($row['terdapatPenyakitKeadaan'] ?? '-'))
                    . '</small>';
            }

            $perlu_int   = (int)($row['perluPengkajian'] ?? 0);
            $perlu_badge = $perlu_int === 1
                ? '<span class="badge badge-danger">Ya</span>'
                : '<span class="badge badge-success">Tidak</span>';

            $col_petugas = '<small>' . htmlspecialchars($row['usrPetugas'] ?? '-') . '</small>';

            $btn_delete = '<button type="button" class="btn btn-danger btn-sm delete"
                data-no_registrasi="' . $no_reg_row . '"
                title="Hapus"><i class="fas fa-trash"></i></button>';

            $output .= '
                <tr data-row="' . $row_data . '" data-no_registrasi="' . $no_reg_row . '">
                    <td style="border:1px solid #333; background-color:#fff; color:#333; vertical-align:top; padding:6px 8px;">' . $info . '</td>
                    <td ' . $td_click . ' class="clickable-col">' . $jenis . '</td>
                    <td ' . $td_click . ' class="clickable-col">' . $col_skrining . '</td>
                    <td ' . $td_center . '>' . $perlu_badge . '</td>
                    <td ' . $td_click . ' class="clickable-col">' . $col_petugas . '</td>
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

        $usr_id   = (string)($this->session->get('usr_id') ?? '0');
        $usr_name = (string)($this->session->get('emp_nm') ?? $this->session->get('fullname') ?? $usr_id);
        $action   = $this->request->getPost('action');

        $jenis = $this->request->getPost('jenisScreening') ?: 'DEWASA';

        $toIntOrNull = function ($val) {
            return ($val === null || $val === '') ? null : (int)$val;
        };

        $payload = [
            'noRegistrasi'              => $no_registrasi,
            'tanggalScreening'          => date('Y-m-d\TH:i:s'),
            'jenisScreening'            => $jenis,
            'penurunanBeratBadan'       => $toIntOrNull($this->request->getPost('penurunanBeratBadan')),
            'jumlahPenurunanBeratBadan' => $toIntOrNull($this->request->getPost('jumlahPenurunanBeratBadan')),
            'asupanBerkurang'           => $toIntOrNull($this->request->getPost('asupanBerkurang')),
            'diagnosaKhusus'            => $toIntOrNull($this->request->getPost('diagnosaKhusus')),
            'tampakKurus'               => $toIntOrNull($this->request->getPost('tampakKurus')),
            'anakPenurunanBeratBadan'   => $toIntOrNull($this->request->getPost('anakPenurunanBeratBadan')),
            'kondisi'                   => $toIntOrNull($this->request->getPost('kondisi')),
            'terdapatPenyakitKeadaan'   => $toIntOrNull($this->request->getPost('terdapatPenyakitKeadaan')),
            'perluPengkajian'           => $toIntOrNull($this->request->getPost('perluPengkajian')) ?? 0,
            'usrPetugas'                => $usr_name,
        ];

        $existingRow = $this->apiDataGetByRegistrasi($no_registrasi);
        $isEdit      = !empty($existingRow);

        if ($isEdit) {
            $payload['updatedBy'] = $usr_id;
            $url      = "{$this->server5}/api/SkriningGizi/{$no_registrasi}";
            $response = akses_restapikey('PUT', $url, $payload, []);
        } else {
            $payload['createdBy'] = $usr_id;
            $url      = "{$this->server5}/api/SkriningGizi";
            $response = akses_restapikey('POST', $url, $payload, []);
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

        $msg = $isEdit ? 'Data skrining gizi berhasil diubah!' : 'Data skrining gizi berhasil disimpan!';
        echo json_encode(['success' => $msg]);
    }

    public function delete()
    {
        $no_registrasi = $this->request->getVar('no_registrasi');
        helper(['restclient']);

        $url    = "{$this->server5}/api/SkriningGizi/{$no_registrasi}";
        $result = akses_restapikey('DELETE', $url, [], []);

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

    public function printSkriningGizi($no_registrasi = null)
    {
        if (!$no_registrasi) {
            $no_registrasi = $this->request->getVar('no_registrasi');
        }

        $row = $this->apiDataGetByRegistrasi($no_registrasi);

        $this->data['title_pdf'] = 'Skrining Gizi';
        $this->data['d'] = [
            'rm'         => $this->request->getVar('no_rm')       ?? '',
            'nama'       => $this->request->getVar('nama_pasien') ?? '',
            'tgl_lahir'  => $this->request->getVar('tgl_lahir')   ?? '',
            'gender'     => $this->request->getVar('gender')      ?? '',

            'jenis'                     => $row['jenisScreening']            ?? 'DEWASA',
            'penurunanBeratBadan'       => $row['penurunanBeratBadan']       ?? null,
            'jumlahPenurunanBeratBadan' => $row['jumlahPenurunanBeratBadan'] ?? null,
            'asupanBerkurang'           => $row['asupanBerkurang']           ?? null,
            'diagnosaKhusus'            => $row['diagnosaKhusus']            ?? null,
            'tampakKurus'               => $row['tampakKurus']               ?? null,
            'anakPenurunanBeratBadan'   => $row['anakPenurunanBeratBadan']   ?? null,
            'kondisi'                   => $row['kondisi']                   ?? null,
            'terdapatPenyakitKeadaan'   => $row['terdapatPenyakitKeadaan']   ?? null,
            'perluPengkajian'           => $row['perluPengkajian']           ?? 0,
            'usrPetugas'                => $row['usrPetugas']                ?? '',
        ];

        $html = view('skriningizi/skriningizi_pdf', $this->data);

        $Pdfgenerator = new Pdfgenerator();
        $Pdfgenerator->generate($html, 'SkriningGizi_' . $no_registrasi, 'A4', 'portrait');
    }
}
