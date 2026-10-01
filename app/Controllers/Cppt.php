<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

class Cppt extends BaseController
{
    protected $data;
    protected $server, $server3, $server5;

    public function __construct()
    {
        $this->session = session();
        $this->server  = $_ENV['APP_API'];
        $this->server3 = $_ENV['APP_API3'];
        $this->server5 = $_ENV['APP_API5'];
    }

    public function index()
    {
        $this->data['session_usr_id'] = (string)($this->session->get('usr_id') ?? '');
        return view('cppt/index', $this->data);
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $cppt_cd = $this->request->getVar('cppt_cd');

            helper(['restclient']);

            $url   = "{$this->server3}/api/cppt";
            $query = ['cppt_cd' => $cppt_cd];

            $result = akses_restapikey('DELETE', $url, [], $query);
            $result = is_string($result) ? json_decode($result, true) : $result;

            if (isset($result['success']) && $result['success'] === true) {
                return $this->response->setJSON([
                    'status'  => 'success',
                    'message' => $result['message'] ?? 'Data CPPT berhasil dihapus',
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

    private function parseCpptTgl(string $raw): int|false
    {
        $str = str_replace(['T', 'Z'], [' ', ''], $raw);
        $str = preg_replace('/\.\d+/', '', $str);
        return strtotime(trim($str));
    }

    public function fetchCpptByRegistrasi()
    {
        $no_registrasi  = $this->request->getVar('no_registrasi');
        $session_usr_id = (string)($this->session->get('usr_id') ?? '');
        helper(['restclient']);

        $url      = "{$this->server3}/api/cppt";
        $query    = [
            'action' => 'getbynoreg',
            'id'     => $no_registrasi,
        ];
        $response = akses_restapikey('GET', $url, [], $query);
        $result   = json_decode($response, true);
        $data     = $result['data'] ?? $result ?? [];

        $tbl_wrap  = 'style="border:2px solid #333; width:100%; background-color:#fff; color:#333; border-collapse:collapse; table-layout:fixed;"';
        $th_style  = 'style="border:1px solid #333; background-color:#f4f6f9; color:#333; vertical-align:middle; padding:6px 8px; text-align:center;"';
        $td_style  = 'style="border:1px solid #333; background-color:#fff; color:#333; vertical-align:top; padding:6px 8px; word-break:break-word; overflow-wrap:break-word;"';
        $td_center = 'style="border:1px solid #333; background-color:#fff; color:#333; vertical-align:top; text-align:center; padding:6px 8px;"';

        $output = '
            <table class="table table-bordered table-sm" ' . $tbl_wrap . '>
                <thead style="text-align:center; border-bottom:2px solid #333;">
                    <tr>
                        <th style="border:1px solid #333; background-color:#f4f6f9; color:#333; vertical-align:middle; padding:6px 8px; text-align:center; width:9%;">Tanggal/<br>Jam</th>
                        <th style="border:1px solid #333; background-color:#f4f6f9; color:#333; vertical-align:middle; padding:6px 8px; text-align:center; width:20%;">Profesional<br>Pemberi Asuhan</th>
                        <th style="border:1px solid #333; background-color:#f4f6f9; color:#333; vertical-align:middle; padding:6px 8px; text-align:center; width:32%;">Hasil Asesmen Pasien dan<br>Pemberian Pelayanan</th>
                        <th style="border:1px solid #333; background-color:#f4f6f9; color:#333; vertical-align:middle; padding:6px 8px; text-align:center; width:27%;">INSTRUKSI PPA<br><small style="font-weight:normal; color:#555;">(termasuk pasca bedah/tindakan invasif)</small></th>
                        <th style="border:1px solid #333; background-color:#f4f6f9; color:#333; vertical-align:middle; padding:6px 8px; text-align:center; width:12%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
        ';

        if (empty($data) || !is_array($data)) {
            $output .= '
                <tr>
                    <td colspan="5" ' . $td_style . ' style="color:#777; text-align:center; padding:20px; font-style:italic;">
                        Belum ada catatan CPPT untuk pasien ini.
                    </td>
                </tr>
            ';
        } else {
            foreach ($data as $row) {
                $tgl_jam = '-';
                if (!empty($row['cppt_tgl'])) {
                    $ts = $this->parseCpptTgl($row['cppt_tgl']);
                    if ($ts) {
                        $tgl_jam = date('d/m/y', $ts) . '<br>' . date('H:i', $ts);
                    } else {
                        $tgl_jam = htmlspecialchars($row['cppt_tgl']);
                    }
                }

                $soap      = $row['cppt_hasil_assesment_pasien'] ?? '';
                $instruksi = $row['cppt_instruksi_ppa'] ?? '';

                $row_usr_id = (string)($row['usr_id'] ?? '');
                $is_owner   = ($row_usr_id === $session_usr_id);
                $cppt_id    = $row['cppt_cd'] ?? '';

                $row_data = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');

                if ($is_owner) {
                    $td_umum      = 'class="cppt-edit-col" data-tab="edit-tab-umum"      style="border:1px solid #333; background-color:#fff; color:#333; vertical-align:top; padding:6px 8px; cursor:pointer; word-break:break-word;" title="Klik untuk edit Data Umum"';
                    $td_soap      = 'class="cppt-edit-col" data-tab="edit-tab-soap"      style="border:1px solid #333; background-color:#fff; color:#333; vertical-align:top; padding:6px 8px; cursor:pointer; word-break:break-word;" title="Klik untuk edit SOAP"';
                    $td_instruksi = 'class="cppt-edit-col" data-tab="edit-tab-instruksi" style="border:1px solid #333; background-color:#fff; color:#333; vertical-align:top; padding:6px 8px; cursor:pointer; word-break:break-word;" title="Klik untuk edit Instruksi PPA"';
                    $btn_delete   = '<button type="button" class="btn btn-danger btn-sm delete"
                        data-id="' . htmlspecialchars($cppt_id) . '"
                        title="Hapus"><i class="fas fa-trash"></i></button>';
                } else {
                    $td_umum      = $td_style;
                    $td_soap      = $td_style;
                    $td_instruksi = $td_style;
                    $btn_delete   = '<button type="button" class="btn btn-danger btn-sm" disabled title="Hanya pembuat yang bisa menghapus"><i class="fas fa-trash"></i></button>';
                }

                $output .= '
                    <tr data-row="' . $row_data . '">
                        <td ' . $td_center   . '>' . $tgl_jam . '</td>
                        <td ' . $td_umum     . '>' . htmlspecialchars($row['cppt_profesional_pemberiasuhan'] ?? '-') . '</td>
                        <td ' . $td_soap     . '>' . $soap . '</td>
                        <td ' . $td_instruksi . '>' . $instruksi . '</td>
                        <td ' . $td_center   . '>
                            ' . $btn_delete . '
                        </td>
                    </tr>
                ';
            }
        }

        $output .= '</tbody></table>';
        echo $output;
    }

    public function fetchSingleCppt()
    {
        if ($this->request->isAJAX()) {
            $cppt_cd = $this->request->getVar('cppt_cd');

            if ($cppt_cd) {
                helper(['restclient']);

                $url   = "{$this->server3}/api/TregistrasiCppt";
                $query = [
                    'action' => 'getby',
                    'id'     => $cppt_cd,
                ];

                try {
                    $response = akses_restapikey('GET', $url, [], $query);
                    $data     = json_decode($response, true);
                    $row      = $data['data'][0] ?? $data['data'] ?? null;

                    if (!$row) {
                        return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan']);
                    }

                    return $this->response->setJSON([
                        'status' => 'success',
                        'data'   => [
                            'cppt_cd'                        => $cppt_cd,
                            'cppt_tgl'                       => $row['cppt_tgl'] ?? '',
                            'cppt_profesional_pemberiasuhan' => $row['cppt_profesional_pemberiasuhan'] ?? '',
                            'cppt_hasil_assesment_pasien'    => $row['cppt_hasil_assesment_pasien'] ?? '',
                            'cppt_instruksi_ppa'             => $row['cppt_instruksi_ppa'] ?? '',
                        ]
                    ]);
                } catch (\Exception $e) {
                    return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
                }
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'ID tidak ditemukan']);
            }
        }
    }

    public function action()
    {
        if (!$this->request->getPost('action')) {
            echo json_encode(['error' => ['cppt_tgl' => 'Request tidak valid.']]);
            return;
        }

        helper(['form', 'restclient']);
        $validation = \Config\Services::validation();

        $section = $this->request->getPost('section') ?? 'umum';

        if (in_array($section, ['umum', ''])) {
            $valid = $this->validate([
                'cppt_tgl' => [
                    'label' => 'Tanggal CPPT',
                    'rules' => 'required',
                ],
                'cppt_profesional_pemberiasuhan' => [
                    'label' => 'Profesional Pemberi Asuhan',
                    'rules' => 'required',
                ],
            ]);

            if (!$valid) {
                echo json_encode([
                    'error' => [
                        'cppt_tgl'                       => $validation->getError('cppt_tgl'),
                        'cppt_profesional_pemberiasuhan' => $validation->getError('cppt_profesional_pemberiasuhan'),
                    ]
                ]);
                return;
            }
        }

        $no_registrasi = $this->request->getPost('no_registrasi') ?: $this->session->get('no_registrasi');
        if (empty($no_registrasi)) {
            echo json_encode(['error' => ['cppt_tgl' => 'Pasien belum dipilih.']]);
            return;
        }

        $tgl_raw = $this->request->getPost('cppt_tgl');
        try {
            $tgl_clean = str_replace('T', ' ', $tgl_raw);
            $ts        = strtotime($tgl_clean);
            if (!$ts) throw new \Exception('Invalid date: ' . $tgl_raw);
            $tgl_api = date('Y-m-d', $ts) . 'T' . date('H:i:s', $ts) . '.000Z';
        } catch (\Exception $e) {
            $tgl_api = date('Y-m-d\TH:i:s') . '.000Z';
        }

        $payload = [
            'no_registrasi'                  => $no_registrasi,
            'role_cd'                        => $this->session->get('role_cd') ?? 'ROLE002',
            'usr_id'                         => (string)($this->session->get('usr_id') ?? '0'),
            'cppt_tgl'                       => $tgl_api,
            'cppt_profesional_pemberiasuhan' => $this->request->getPost('cppt_profesional_pemberiasuhan') ?? '',
            'cppt_hasil_assesment_pasien'    => $this->request->getPost('cppt_hasil_assesment_pasien')    ?? '',
            'cppt_instruksi_ppa'             => $this->request->getPost('cppt_instruksi_ppa')             ?? '',
            // 'cppt_verifikasi_dpjp'           => $this->request->getPost('cppt_verifikasi_dpjp')           ?? '',
            'cppt_verifikasi_dpjp'           => (string)($this->session->get('emp_nm') ?? ''),
        ];

        $action = $this->request->getPost('action');
        $url    = "{$this->server3}/api/cppt";

        if ($action === 'Edit') {
            $query    = ['cppt_cd' => $this->request->getPost('hidden_cppt_cd')];
            $response = akses_restapikey('PUT', $url, $payload, $query);
        } else {
            $response = akses_restapikey('POST', $url, $payload);
        }

        $result = json_decode($response, true);

        if (!empty($result['error'])) {
            echo json_encode(['error' => ['cppt_tgl' => 'API Error: ' . (is_string($result['error']) ? $result['error'] : json_encode($result['error']))]]);
        } else {
            $msg = ($action === 'Edit') ? 'Data CPPT berhasil diubah!' : 'Data CPPT berhasil disimpan!';
            echo json_encode(['success' => $msg]);
        }
    }

    public function printCppt($no_registrasi = null)
    {
        if (!$no_registrasi) {
            $no_registrasi = $this->request->getVar('no_registrasi');
        }

        helper(['restclient']);

        $url      = "{$this->server3}/api/cppt";
        $query    = [
            'action' => 'getbynoreg',
            'id'     => $no_registrasi,
        ];
        $response = akses_restapikey('GET', $url, [], $query);
        $result   = json_decode($response, true);
        $pdf_data = $result['data'] ?? $result ?? [];

        $rows = [];
        if (!is_array($pdf_data)) $pdf_data = [];
        foreach ($pdf_data as $row) {
            $tgl = '-';
            $jam = '-';
            if (!empty($row['cppt_tgl'])) {
                $ts = $this->parseCpptTgl($row['cppt_tgl']);
                if ($ts) {
                    $tgl = date('d/m/y', $ts);
                    $jam = date('H.i', $ts);
                } else {
                    $tgl = htmlspecialchars($row['cppt_tgl']);
                }
            }

            $rows[] = [
                'tgl'       => $tgl,
                'jam'       => $jam,
                'ppa'       => htmlspecialchars($row['cppt_profesional_pemberiasuhan'] ?? '-'),
                'soap'      => $row['cppt_hasil_assesment_pasien'] ?? '',
                'instruksi' => $row['cppt_instruksi_ppa'] ?? '',
            ];
        }

        $gender = $this->request->getVar('gender') ?? '';
        $jk     = (stripos($gender, 'P') !== false || stripos($gender, 'Wanita') !== false || stripos($gender, 'Perempuan') !== false) ? 'P' : 'L';

        $this->data['title_pdf'] = 'Catatan Perkembangan Pasien Terintegrasi (CPPT)';
        $this->data['d'] = [
            'rm'        => $this->request->getVar('no_rm')       ?? '',
            'nama'      => $this->request->getVar('nama_pasien') ?? '',
            'tgl_lahir' => $this->request->getVar('tgl_lahir')   ?? '',
            'jk'        => $jk,
            'rows'      => $rows,
        ];

        $html = view('cppt/cppt_pdf', $this->data);

        $Pdfgenerator = new Pdfgenerator();
        $Pdfgenerator->generate($html, 'CPPT_' . $no_registrasi, 'A4', 'portrait');
    }

    public function setDataPemeriksaanPerawat()
    {
        // if ($this->request->isAJAX()) {
        $no_registrasi = $this->request->getVar('no_registrasi');

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "{$this->server5}/api/PemeriksaanPerawat/by-no-registrasi/$no_registrasi";
        $response = akses_restapikey('GET', $url, [], []);

        // client request
        $data = json_decode($response, true);

        // Jika data ditemukan, kirimkan ke view untuk diisi ke form
        if (!empty($data) && is_array($data)) {
            echo json_encode([
                'status' => 'success',
                'data' => $data['data']
            ]);
        } else {
            echo json_encode([
                'status' => 'empty',
                'message' => 'Data pemeriksaan belum tersedia'
            ]);
        }
        // } else {
        //     exit('Maaf tidak dapat diproses!');
        // }
    }
}
