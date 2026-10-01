<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

class Konsultasidokter2 extends BaseController
{
    protected $data;
    protected $server;
    protected $client;

    public function __construct()
    {
        $this->session = session();
        $uri = service('uri');
        $this->server = $_ENV['APP_API'];
        helper(['restclient', 'form', 'url', 'dropdown']);
    }

    public function index()
    {
        $this->data['title'] = ' | ' . $_ENV['APP_TITLE'];
        $this->data['cb_dokter'] = getDropdownDokterNolabelVertical('dokter_rujukan');
        $this->data['cb_jenissurat'] = getDropdownNolabelVertical('jenis_surat');
        $this->data['cb_layanan'] = getDropdownNolabelVerticalWithoutName('layanan');
        $this->data['cb_layanan_item'] = getDropdownNolabelVertical('item_test');

        $this->data['cb_pasien'] = getDropdownPasien2('patient_no', 'Pasien', 2, 4);
        $this->data['cb_tujuan'] = getDropdownPolyclinicCustom('tujuan_registrasi', 'tujuan_registrasi', 'Tujuan Registrasi', 2, 4);
        $this->data['cb_pasien2'] = getDropdownPasienCustom('patient_no', 'patient_no_v', 'Pasien', 2, 4);
        $this->data['cb_tujuan2'] = getDropdownPolyclinicCustom('tujuan_registrasi', 'tujuan_registrasi_v', 'Tujuan Registrasi', 2, 4);
        $this->data['cb_type_pasien'] = getDropdown2('Tipe_Pasien', 'Tipe Pasien', 2, 4);
        $this->data['cb_type_pasien2'] = getDropdownCustom('Tipe_Pasien', 'Tipe_Pasien_v', 'Tipe Pasien', 2, 4);
        $this->data['cb_asuransi'] = getDropdownAsuransiCustomFilter('asr_cd', 'asr_cd', 'Asuransi', 2, 4, []);
        $this->data['cb_asuransi2'] = getDropdownAsuransiCustomFilter('asr_cd', 'asr_cd_v', 'Asuransi', 2, 4, []);
        $this->data['cb_registrasi_via'] = getDropdown2('registrasi_via', 'Daftar Via', 2, 4);

        return view('konsultasidokter2/indexdraft', $this->data);
    }

    // ==================== API DATA ====================

    public function apiDataLabGetAll()
    {
        $url = "$this->server/tmstitemlaboratorium/getlist";
        $response = akses_restapi('GET', $url, []);
        $data = json_decode($response, true);

        $groupedData = [];
        foreach ($data as $entry) {
            $key = $entry['kolom_no'] . '-' . $entry['kd_parent'];
            if (!isset($groupedData[$key])) {
                $groupedData[$key] = [
                    'kolom' => $entry['kolom_no'],
                    'title' => $entry['kd_parent'],
                    'items' => []
                ];
            }
            $groupedData[$key]['items'][] = [
                'code' => $entry['kd_item'],
                'description' => $entry['nama_item'],
                'harga_jual' => $entry['harga_jual'],
                'ppn' => $entry['ppn'],
                'diskon_pct' => $entry['diskon_pct']
            ];
        }

        $output = ['columns' => []];
        foreach ($groupedData as $group) {
            $output['columns'][] = $group;
        }

        return $this->response->setJSON($output);
    }

    public function apiDataRadiologiGetAll()
    {
        $url = "$this->server/tmstitemradiologi/getlist";
        $response = akses_restapi('GET', $url, []);
        $data = json_decode($response, true);

        $groupedData = [];
        foreach ($data as $entry) {
            $key = $entry['kolom_no'] . '-' . $entry['kd_parent'];
            if (!isset($groupedData[$key])) {
                $groupedData[$key] = [
                    'kolom' => $entry['kolom_no'],
                    'title' => $entry['kd_parent'],
                    'items' => []
                ];
            }
            $groupedData[$key]['items'][] = [
                'code' => $entry['kd_item'],
                'description' => $entry['nama_item'],
                'harga_jual' => $entry['harga_jual'],
                'ppn' => $entry['ppn'],
                'diskon_pct' => $entry['diskon_pct']
            ];
        }

        $output = ['columns' => []];
        foreach ($groupedData as $group) {
            $output['columns'][] = $group;
        }

        return $this->response->setJSON($output);
    }

    public function getDropdownLayananItem()
    {
        $layanan = $this->request->getVar('layanan');
        return getDropdownLayananItemCustomTree($layanan);
    }

    public function apiDataGetTindakan()
    {
        $no_registrasi = $this->request->getVar('no_registrasi');
        $url = "$this->server/tregistrasitindakan/getby/$no_registrasi";
        return akses_restapi('GET', $url, []);
    }

    public function apiDataGetAnamnesa()
    {
        $no_registrasi = $this->request->getVar('no_registrasi');
        $url = "$this->server/tregistrasianamnesa/getby/$no_registrasi";
        return akses_restapi('GET', $url, []);
    }

    public function apiDataGetPeriksa()
    {
        $no_registrasi = $this->request->getVar('no_registrasi');
        $url = "$this->server/tregistrasiperiksa/getby/$no_registrasi";
        return akses_restapi('GET', $url, []);
    }

    public function apiDataGetDiagnosa()
    {
        $no_registrasi = $this->request->getVar('no_registrasi');
        $url = "$this->server/tregistrasidiagnosa/getby/$no_registrasi";
        return akses_restapi('GET', $url, []);
    }

    public function apiDataGetRujukan()
    {
        $no_registrasi = $this->request->getVar('no_registrasi');
        $url = "$this->server/tregistrasirujukan/getby/$no_registrasi";
        return akses_restapi('GET', $url, []);
    }

    public function apiDataGetAlergiByPasien()
    {
        $patient_no = $this->request->getVar('patient_no');
        $url = "$this->server/tpatientalergi/getby/$patient_no";
        return akses_restapi('GET', $url, []);
    }

    public function apiDataGetDiagnosaTambahanByRegistrasi()
    {
        $no_registrasi = $this->request->getVar('no_registrasi');
        $url = "$this->server/tregistrasidiagnosatambahan/getby/$no_registrasi";
        return akses_restapi('GET', $url, []);
    }

    public function apiDataGetByDokter()
    {
        $emp_cd = $this->session->get('emp_cd');
        $url = "$this->server/tregistrasi/getbydokter/$emp_cd";
        $response = akses_restapi('GET', $url, []);
        return json_decode($response, true);
    }

    public function apiDataGetByNoRegistrasi()
    {
        $no_registrasi = $this->request->getVar('no_registrasi');
        $url = "$this->server/ttitikkeluhan/getby/$no_registrasi";
        return akses_restapi('GET', $url, []);
    }

    public function apiDataGetAllRiwayat($patient_no)
    {
        $url = "$this->server/tmedicalrecord/getbypasien/$patient_no";
        $response = akses_restapi('GET', $url, []);
        return json_decode($response, true);
    }

    // ==================== FETCH VIEWS ====================

    public function fetchAll()
    {
        $data = $this->apiDataGetByDokter();
        $output = '
        <table id="example1" class="table table-sm table-striped" style="border-spacing: 0;">
            <thead>
                <tr>
                    <th>Pasien</th>
                    <th>Hadir</th>
                    <th></th>
                </tr>
            </thead>
        ';

        if (empty($data)) {
            $output .= '<tr><td>Data not Found</td><td></td><th></th></tr>';
        } else {
            foreach ($data as $a => $row) {
                $btnClass = ($row['status'] ?? '') === 'DT' ? 'btn-warning' : 'btn-info';
                $output .= '
                <tr id="addMdlBarang" data-id="' . ($row['no_registrasi'] ?? '') . '">
                    <td>' . ($row['fullname'] ?? '') . '</td>
                    <td>' . ($row['hadir'] ?? '') . '</td>
                    <td>
                        <button data-widget="control-sidebar" data-slide="true" type="button" 
                            class="btn ' . $btnClass . ' btn-sm float-right mr-1 mt-1 pilihpasien pasien btn-fix-w" 
                            data-no_registrasi="' . ($row['no_registrasi'] ?? '') . '" 
                            data-patient_no="' . ($row['no_pasien'] ?? '') . '" 
                            data-kode_dokter="' . ($row['dokter'] ?? '') . '" 
                            data-fullname="' . ($row['fullname'] ?? '') . '" 
                            data-tahun="' . ($row['tahun'] ?? '') . '" 
                            data-bulan="' . ($row['bulan'] ?? '') . '" 
                            data-hari="' . ($row['hari'] ?? '') . '" 
                            data-gender="' . ($row['gender_desc'] ?? '') . '" 
                            data-birth_dt="' . ($row['birth_dt'] ?? '') . '" 
                            data-mobile_no="' . ($row['mobile_no'] ?? '') . '" 
                            data-jam_mulai="' . ($row['jam_mulai'] ?? '') . '" 
                            data-jam_selesai="' . ($row['jam_selesai'] ?? '') . '" 
                            data-tujuan_registrasi="' . ($row['tujuan_registrasi'] ?? '') . '" 
                            data-tujuan_registrasi_desc="' . ($row['tujuan_registrasi_desc'] ?? '') . '" 
                            data-type_pasien="' . ($row['type_pasien'] ?? '') . '" 
                            data-nama_dokter="' . ($row['nama_dokter'] ?? '') . '" 
                            data-no_kwitansi="' . ($row['no_kwitansi'] ?? '') . '" 
                            data-flag_alergi="' . ($row['flag_alergi'] ?? '') . '" 
                            data-status="' . ($row['status'] ?? '') . '"
                            data-keluhan_utama="' . ($row['keluhan_utama'] ?? '') . '"
                            data-responden="' . ($row['responden'] ?? '') . '"
                            data-riwayat_lain="' . ($row['riwayat_lain'] ?? '') . '"
                            data-riwayat_operasi_pengobatan="' . ($row['riwayat_operasi_pengobatan'] ?? '') . '"
                            data-riwayat_penyakit_dahulu="' . ($row['riwayat_penyakit_dahulu'] ?? '') . '"
                            data-riwayat_penyakit_keluarga="' . ($row['riwayat_penyakit_keluarga'] ?? '') . '"
                            data-riwayat_penyakit_sekarang="' . ($row['riwayat_penyakit_sekarang'] ?? '') . '"
                            data-riwayat_perjalanan_keluhan="' . ($row['riwayat_perjalanan_keluhan'] ?? '') . '"
                            data-berat_badan="' . ($row['berat_badan'] ?? '') . '"
                            data-bmi="' . ($row['bmi'] ?? '') . '"
                            data-denyut_nadi="' . ($row['denyut_nadi'] ?? '') . '"
                            data-diastolik="' . ($row['diastolik'] ?? '') . '"
                            data-kondisi_khusus="' . ($row['kondisi_khusus'] ?? '') . '"
                            data-kondisi_umum="' . ($row['kondisi_umum'] ?? '') . '"
                            data-laju_nafas="' . ($row['laju_nafas'] ?? '') . '"
                            data-pemeriksaan_tambahan="' . ($row['pemeriksaan_tambahan'] ?? '') . '"
                            data-sistolik="' . ($row['sistolik'] ?? '') . '"
                            data-suhu="' . ($row['suhu'] ?? '') . '"
                            data-tinggi_badan="' . ($row['tinggi_badan'] ?? '') . '"
                            data-diagnosa_sekunder="' . ($row['diagnosa_sekunder'] ?? '') . '"
                            data-diagnosa_sekunder_sta="' . ($row['diagnosa_sekunder_sta'] ?? '') . '"
                            data-diagnosa_utama="' . ($row['diagnosa_utama'] ?? '') . '"
                            data-diagnosa_utama_sta="' . ($row['diagnosa_utama_sta'] ?? '') . '"
                            data-icd10_sekunder="' . ($row['icd10_sekunder'] ?? '') . '"
                            data-icd10_utama="' . ($row['icd10_utama'] ?? '') . '"
                            data-klasifikasi_sekunder="' . ($row['klasifikasi_sekunder'] ?? '') . '"
                            data-klasifikasi_utama="' . ($row['klasifikasi_utama'] ?? '') . '"
                            data-laboratorium="' . ($row['laboratorium'] ?? '') . '"
                            data-prosedur_primer="' . ($row['prosedur_primer'] ?? '') . '"
                            data-prosedur_skunder="' . ($row['prosedur_skunder'] ?? '') . '"
                            data-radiologi="' . ($row['radiologi'] ?? '') . '"
                            data-reduksi="' . ($row['reduksi'] ?? '') . '"
                            data-resep="' . ($row['resep'] ?? '') . '"
                            data-tatalaksana="' . ($row['tatalaksana'] ?? '') . '"
                            data-dokter_rujukan="' . ($row['dokter_rujukan'] ?? '') . '"
                            data-ket_rujukan="' . ($row['ket_rujukan'] ?? '') . '"
                            data-rujukan="' . ($row['ket_rujukan'] ?? '') . '"
                            data-user_rujukan="' . ($row['user_rujukan'] ?? '') . '"
                        >
                            Pilih
                        </button>
                    </td>
                </tr>';
            }
        }

        $output .= '</table>
        <script type="text/javascript">
            $(function() {
                $("#example1").DataTable({
                    columnDefs: [{ orderable: false, targets: 2 }],
                    paging: false,
                    lengthChange: true,
                    searching: false,
                    info: false,
                    autoWidth: false
                });
            });
        </script>';
        echo $output;
    }

    // public function fetchAllRiwayatCardByPasien()
    // {
    //     $patient_no = $this->request->getVar('patient_no');
    //     $data = $this->apiDataGetAllRiwayat($patient_no);

    //     $output = '
    //     <table id="example3" class="table table-sm table-bordered table-striped">
    //         <thead>
    //             <tr>
    //                 <th>NO</th>
    //                 <th>Tanggal</th>
    //                 <th>Keluhan</th>
    //                 <th>Dokter</th>
    //                 <th></th>
    //             </tr>
    //         </thead>
    //     ';

    //     if (empty($data)) {
    //         $output .= '<tr><td>Data not Found</td><td></td><td></td><td></td><td></td></tr>';
    //     } else {
    //         foreach ($data as $a => $row) {
    //             $output .= '
    //             <tr>
    //                 <td>' . ($a + 1) . '</td>
    //                 <td>' . (!empty($row['tgl_registrasi']) ? date('d/m/Y', strtotime($row['tgl_registrasi'])) : '') . '</td>
    //                 <td>' . ($row['keluhan_utama'] ?? '') . '</td>
    //                 <td>' . ucwords($row['dokter'] ?? '') . '</td>
    //                 <td class="text-center"><button class="btn btn-xs btn-success riwayat" 
    //                     data-no_registrasi="' . ($row['no_registrasi'] ?? '') . '" 
    //                     data-patient_no="' . ($row['no_pasien'] ?? '') . '">Detail</button></td>
    //             </tr>';
    //         }
    //     }

    //     $output .= '</table>
    //     <script>
    //         $(function() {
    //             $("#example3").DataTable({
    //                 responsive: true,
    //                 lengthChange: false,
    //                 autoWidth: false,
    //                 pageLength: 5,
    //                 oLanguage: {
    //                     sSearch: "Cari Data:",
    //                     sInfoEmpty: "Tidak ada data",
    //                     sInfo: "Total: _TOTAL_ Data",
    //                     sInfoFiltered: " dari _MAX_ Jadwal",
    //                     sZeroRecords: "Data tidak ditemukan",
    //                     oPaginate: {
    //                         sFirst: "Awal",
    //                         sPrevious: "Sebelum",
    //                         sNext: "Berikut",
    //                         sLast: "Akhir"
    //                     }
    //                 }
    //             });
    //         });
    //     </script>';
    //     echo $output;
    // }

    public function apiDataGetAllRiwayatByPasien($patient_no)
    {

        // endpoint
        $url = "$this->server/listparameter/riwayatbyno_pasien/$patient_no";

        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);

        return $data['response_data'];
    }

    //berbentuk tabel
    public function fetchAllRiwayatCardByPasien()
    {
        // if ($this->request->isAJAX()) {

        $patient_no = $this->request->getVar('patient_no');

        $output = '';
        $data =  $this->apiDataGetAllRiwayatByPasien($patient_no);



        $output .= '  
                    <table id="example3" class="table table-sm table-bordered table-striped">
                    <thead>
                            <tr>
                                <th>NO</th>
                                <th>Tanggal</th>
                                <th>Keluhan</th>
                                <th>Dokter</th>
                                <th></th>
                            </tr>
                        </thead>
                            ';
        if ($data == '') {
            $output .= '<tr>  
                                <td >Data not Found</td>
                                <td ></td>
                                <td ></td>
                                <td ></td>
                                <td ></td>
                            </tr>';
        } else {
            for ($a = 0; $a < count($data); $a++) {
                $output .= ' 
                            <tr>
                                <td>' . ($a + 1) . '</td>
                                <td>' . date('d/m/Y', strtotime($data[$a]["tgl_registrasi"])) . '</td>
                                <td>' . $data[$a]["keluhan_utama"] . '</td>
                                <td>' . ucwords($data[$a]["dokter"]) . '</td>
                                <td class="text-center"><button class="btn btn-xs btn-success riwayat" data-no_registrasi="' . $data[$a]["no_registrasi"] . '" data-patient_no="' . $data[$a]["no_pasien"] . '">Detail</button></td>
                            </tr>
                    ';
            }
        }
        $output .= '</table>
            <script>
            $(function() {
                $("#example3").DataTable({
                    // "responsive": true, "lengthChange": false, "autoWidth": false,
                    // columnDefs: [{
                    //     orderable: false,
                    //     targets: 7
                    // }],
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    // "columns": [
                    //   { "width": "10%" }, null, null, null, nuul, null
                    // ],
                    // "buttons": [{
                    //         text: "Add New",
                    //         action: function(e, dt, node, config) {
                    //             // alert("Button activated");
                    //         },
                    //         attr: {
                    //             id: "add_record",
                    //             style: "background-color:#56b746;' . ($this->session->get("flag_insert") === 1 ? "" : "display:none;") . '",
                    //             name:"add_record",
                    //             nameClass:"btn-lg"
                    //         }
                    //     },
                    //     { extend: "excel", className: "btn-sm btn-primary ' . ($this->session->get("flag_export") === 1 ? "" : "d-none") . '", exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]} },
                    //     { extend: "print", className: "btn-sm btn-info ' . ($this->session->get("flag_print") === 1 ? "" : "d-none") . '", exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]} }

                    // ],
                    "pageLength": 5,
                    "oLanguage": {
                        "sSearch": "Cari Data:",
                        "sInfoEmpty": "Tidak ada data",
                        // "sInfo": "_START_ untuk _END_ dari _TOTAL_ data",
                        "sInfo": "Total: _TOTAL_ Data",
                        "sInfoFiltered": " dari _MAX_ Jadwal",
                        "sZeroRecords": "Data tidak ditemukan",
                        "oPaginate": {
                            "sFirst": "Awal",
                            "sPrevious": "Sebelum",
                            "sNext": "Berikut",
                            "sLast": "Akhir"
                        },
                    },
                }).buttons().container().appendTo("#example3_wrapper .col-sm-6:eq(0)");
            });
            </script>
            ';
        echo $output;
        // } else {
        //     exit('Maaf tidak dapat diproses!');
        // }
    }

    public function fetchAllAnamnesaCardByPasien()
    {
        if (!$this->request->isAJAX()) {
            exit('Maaf tidak dapat diproses!');
        }

        $patient_no = $this->request->getVar('patient_no');
        $url = "$this->server/listparameter/anamnesabyno_pasien/$patient_no";
        $response = akses_restapi('GET', $url, []);
        $data = json_decode($response, true);

        $output = '';
        if (!empty($data)) {
            foreach ($data as $row) {
                $output .= '
                <div class="card dudu" 
                    data-keluhan_utama="' . ($row['keluhan_utama'] ?? '') . '" 
                    data-riwayat_perjalanan_keluhan="' . ($row['riwayat_perjalanan_keluhan'] ?? '') . '" 
                    data-riwayat_penyakit_sekarang="' . ($row['riwayat_penyakit_sekarang'] ?? '') . '" 
                    data-riwayat_operasi_pengobatan="' . ($row['riwayat_operasi_pengobatan'] ?? '') . '" 
                    data-riwayat_penyakit_keluarga="' . ($row['riwayat_penyakit_keluarga'] ?? '') . '" 
                    data-riwayat_lain="' . ($row['riwayat_lain'] ?? '') . '" 
                    data-riwayat_penyakit_dahulu="' . ($row['riwayat_penyakit_dahulu'] ?? '') . '">
                    <div class="card-body">
                        <p>Anamnesa – ' . (!empty($row['tgl_registrasi']) ? date('d/m/Y', strtotime($row['tgl_registrasi'])) : '') . '</p>
                        <p>Keluhan : ' . ($row['keluhan_utama'] ?? '') . '</p>
                        <p>[Isi informasi Keluhan]</p>
                    </div>
                </div>';
            }
        }
        echo $output;
    }

    public function fetchAllAlergi()
    {
        $output = '';
        $data = $this->apiDataGetAlergiByPasien();

        if (empty($data)) {
            $output .= '<tr><td colspan="4" class="text-center">Tidak ada data alergi</td></tr>';
        } else {
            foreach ($data as $a => $row) {
                $komponen_arr = !empty($row['komponen']) ? explode(',', $row['komponen']) : [];
                $reaksi_arr = !empty($row['reaksi']) ? explode(',', $row['reaksi']) : [];

                $output .= '
                <tr id="row' . $a . '" class="all_row">
                    <td>
                        <select class="custom-select" name="alergi[' . $a . '][kategori]" id="kategori_alergi' . $a . '">
                            <option value="">-- Select --</option>
                        </select>
                    </td>
                    <td>
                        <select class="custom-select" multiple="multiple" name="alergi[' . $a . '][komponen][]" id="komponen_alergi' . $a . '">
                            <option value="">-- Select --</option>
                        </select>
                    </td>
                    <td>
                        <select class="custom-select" multiple="multiple" name="alergi[' . $a . '][reaksi][]" id="reaksi_alergi' . $a . '">
                            <option value="">-- Select --</option>
                        </select>
                        <input type="hidden" name="alergi[' . $a . '][alergi_no]" value="' . ($row['alergi_no'] ?? '') . '">
                    </td>
                    <td>
                        <button type="button" name="remove" id="' . $a . '" 
                            class="btn btn-sm btn-danger btn_remove_alergi"
                            data-patient_no="' . ($row['patient_no'] ?? '') . '"
                            data-alergi_no="' . ($row['alergi_no'] ?? '') . '">X</button>
                    </td>
                </tr>';

                $output .= '
                <script type="text/javascript">
                    $(document).ready(function() {
                        $("#kategori_alergi' . $a . '").select2({
                            ajax: {
                                url: "' . site_url('konsultasidokter/ajaxKategoriAlergi/kategori_alergi') . '",
                                dataType: "json",
                                data: function(params) { return { search: params.term }; },
                                processResults: function(data) { return { results: data }; }
                            },
                            cache: true,
                            placeholder: "Search Kategori...",
                            minimumInputLength: 0,
                            width: "auto"
                        });
                        $("#kategori_alergi' . $a . '").val("' . ($row['kategori'] ?? '') . '").trigger("change");
                        
                        $("#komponen_alergi' . $a . '").select2({
                            ajax: {
                                url: "' . site_url('konsultasidokter/ajaxKategoriAlergi/komponen_alergi') . '",
                                dataType: "json",
                                data: function(params) { return { search: params.term }; },
                                processResults: function(data) { return { results: data }; }
                            },
                            cache: true,
                            placeholder: "Search Komponen...",
                            minimumInputLength: 0,
                            width: "auto"
                        });
                        let komponen' . $a . ' = ' . json_encode($komponen_arr) . ';
                        if(komponen' . $a . '.length > 0 && komponen' . $a . '[0] != "") {
                            $("#komponen_alergi' . $a . '").val(komponen' . $a . ').trigger("change");
                        }
                        
                        $("#reaksi_alergi' . $a . '").select2({
                            ajax: {
                                url: "' . site_url('konsultasidokter/ajaxKategoriAlergi/reaksi_alergi') . '",
                                dataType: "json",
                                data: function(params) { return { search: params.term }; },
                                processResults: function(data) { return { results: data }; }
                            },
                            cache: true,
                            placeholder: "Search Reaksi...",
                            minimumInputLength: 0,
                            width: "auto"
                        });
                        let reaksi' . $a . ' = ' . json_encode($reaksi_arr) . ';
                        if(reaksi' . $a . '.length > 0 && reaksi' . $a . '[0] != "") {
                            $("#reaksi_alergi' . $a . '").val(reaksi' . $a . ').trigger("change");
                        }
                    });
                </script>';
            }
        }
        echo $output;
    }

    // ==================== SURAT ====================

    public function headerRujukan()
    {
        $no_registrasi = $this->request->getVar('no_registrasi');
        $url = "$this->server/tregistrasi/getby/$no_registrasi";
        $response = akses_restapi('GET', $url, []);
        $data = json_decode($response, true);

        $output = '';
        if (empty($data)) {
            $output = '<table class="table table-responsive" style="width: 100%;">
                <tbody>
                    <tr><td colspan="5"><h2 style="text-align: center;"><b>RESUME MEDIS</b></h2></td></tr>
                    <tr>
                        <td><b>Nama Pasien :</b></td>
                        <td style="text-align: right;"><b>SUPRIYATI</b></td>
                        <td>&nbsp;</td>
                        <td><b>No. RM :</b></td>
                        <td style="text-align: right;"><b>22101703</b></td>
                    </tr>
                    <tr>
                        <td><b>Umur :</b></td>
                        <td style="text-align: right;"><b>46 years</b></td>
                        <td>&nbsp;</td>
                        <td><b>Tanggal Lahir :</b></td>
                        <td style="text-align: right;"><b>03 May 1973</b></td>
                    </tr>
                    <tr>
                        <td><b>Jenis Kelamin :</b></td>
                        <td style="text-align: right;"><b>Perempuan</b></td>
                        <td>&nbsp;</td>
                        <td><b><br></b></td>
                        <td style="text-align: right;"><b><br></b></td>
                    </tr>
                    <tr>
                        <td><b>Tgl. Kunjungan :</b></td>
                        <td style="text-align: right;"><b><br></b></td>
                        <td>&nbsp;</td>
                        <td><b>Tanggal Dibuat :</b></td>
                        <td style="text-align: right;"><b>' . date("d M Y H:i") . '</b></td>
                    </tr>
                    <tr>
                        <td><b>Tipe Kunjungan :</b></td>
                        <td style="text-align: right;"><b>Rawat Jalan</b></td>
                        <td>&nbsp;</td>
                        <td><b>Status :</b></td>
                        <td style="text-align: right;"><b>New</b></td>
                    </tr>
                    <tr>
                        <td><b>Nama Dokter :</b></td>
                        <td style="text-align: right;"><b>dr. Amira Cholid Bawazeer</b></td>
                        <td>&nbsp;</td>
                        <td><b>Dicetak Oleh :</b></td>
                        <td style="text-align: right;"><b>dr. Amira Cholid Bawazeer</b></td>
                    </tr>
                    <tr>
                        <td><b>Spesialisasi :</b></td>
                        <td style="text-align: right;"><b>N / A</b></td>
                        <td>&nbsp;</td>
                        <td><b>Dicetak Pada :</b></td>
                        <td style="text-align: right;"><b>' . date("d M Y H:i") . '</b></td>
                    </tr>
                </tbody>
            </table>';
        } else {
            $p = $data[0];
            $output = '
            <table class="table table-responsive" style="width: 100%;">
                <tbody>
                    <tr><td colspan="5"><h2 style="text-align: center;"><b>RESUME MEDIS</b></h2></td></tr>
                    <tr>
                        <td><b>Nama Pasien :</b></td>
                        <td style="text-align: right;"><b>' . ($p['fullname'] ?? '') . '</b></td>
                        <td>&nbsp;</td>
                        <td><b>No. RM :</b></td>
                        <td style="text-align: right;"><b>' . ($p['no_pasien'] ?? '') . '</b></td>
                    </tr>
                    <tr>
                        <td><b>Umur :</b></td>
                        <td style="text-align: right;"><b>' . ($p['tahun'] ?? '') . ' years</b></td>
                        <td>&nbsp;</td>
                        <td><b>Tanggal Lahir :</b></td>
                        <td style="text-align: right;"><b>' . (!empty($p['birth_dt']) ? date('d M Y', strtotime($p['birth_dt'])) : '') . '</b></td>
                    </tr>
                    <tr>
                        <td><b>Jenis Kelamin :</b></td>
                        <td style="text-align: right;"><b>' . (($p['gender'] ?? '') == 'M' ? 'Laki - laki' : 'Perempuan') . '</b></td>
                        <td>&nbsp;</td>
                        <td><b><br></b></td>
                        <td style="text-align: right;"><b><br></b></td>
                    </tr>
                    <tr>
                        <td><b>Tgl. Kunjungan :</b></td>
                        <td style="text-align: right;"><b>' . (!empty($p['tgl_praktek']) ? date('d M Y H:i', strtotime($p['tgl_praktek'])) : '') . '</b></td>
                        <td>&nbsp;</td>
                        <td><b>Tanggal Dibuat :</b></td>
                        <td style="text-align: right;"><b>' . date("d M Y H:i") . '</b></td>
                    </tr>
                    <tr>
                        <td><b>Tipe Kunjungan :</b></td>
                        <td style="text-align: right;"><b>' . ($p['tujuan_registrasi_desc'] ?? '') . '</b></td>
                        <td>&nbsp;</td>
                        <td><b>Status :</b></td>
                        <td style="text-align: right;"><b>' . ($p['tujuan_registrasi_desc'] ?? '') . '</b></td>
                    </tr>
                    <tr>
                        <td><b>Nama Dokter :</b></td>
                        <td style="text-align: right;"><b>' . ($p['nama_dokter'] ?? '') . '</b></td>
                        <td>&nbsp;</td>
                        <td><b>Dicetak Oleh :</b></td>
                        <td style="text-align: right;"><b>' . ($p['nama_dokter'] ?? '') . '</b></td>
                    </tr>
                    <tr>
                        <td><b>Spesialisasi :</b></td>
                        <td style="text-align: right;"><b>N / A</b></td>
                        <td>&nbsp;</td>
                        <td><b>Dicetak Pada :</b></td>
                        <td style="text-align: right;"><b>' . date("d M Y H:i") . '</b></td>
                    </tr>
                </tbody>
            </table>';
        }
        echo $output;
    }

    public function titikKeluhan()
    {
        $no_registrasi = $this->request->getVar('no_registrasi');
        $gambar = $this->request->getVar('gambar');

        $url = "$this->server/ttitikkeluhan/getby/$no_registrasi/$gambar";
        $response = akses_restapi('GET', $url, []);
        $data = json_decode($response, true);

        $output = '';
        if (!empty($data) && !empty($data[0]['image'])) {
            $output = '<p><img src="' . base_url() . '/assets/img/titikkeluhan/' . strtoupper($data[0]['image']) . '.jpg?' . rand() . '" style="text-align: center; width: 25%;" class=""></p>';
        }
        echo $output;
    }

    private function generateSuratHtml($no_registrasi, $template, $placeholders = [])
    {
        $url = "$this->server/tregistrasi/getby/$no_registrasi";
        $response = akses_restapi('GET', $url, []);
        $data = json_decode($response, true);

        if (empty($data)) {
            $html = $template;
            foreach ($placeholders as $key => $value) {
                $html = str_replace('$' . $key, $value, $html);
            }
            return $html;
        }

        $html = $template;
        $p = $data[0];
        $replacements = [
            'fullname' => $p['fullname'] ?? '',
            'tahun' => $p['tahun'] ?? '',
            'gender' => ($p['gender'] ?? '') == 'M' ? 'Laki - laki' : 'Perempuan',
            'addr' => $p['addr'] ?? '',
            'pekerjaan' => $p['pekerjaan'] ?? '',
            'diagnosa' => $p['diagnosa'] ?? '',
            'tempat_lahir' => $p['birthplace'] ?? '',
            'birth_dt' => isset($p['birth_dt']) ? date('d M Y', strtotime($p['birth_dt'])) : '',
            'tekanan_darah' => $p['diastolik'] ?? '',
            'n' => $p['denyut_nadi'] ?? '',
            'rr' => '0',
            'suhu' => $p['suhu'] ?? '',
            'berat_badan' => $p['berat_badan'] ?? '',
            'tinggi_badan' => $p['tinggi_badan'] ?? '',
        ];

        foreach ($replacements as $key => $value) {
            $html = str_replace('$' . $key, $value, $html);
        }

        return $html;
    }

    public function suratLayakTerbang()
    {
        $no_registrasi = $this->request->getVar('no_registrasi');
        echo $this->generateSuratHtml($no_registrasi, $this->getTemplateLayakTerbang());
    }

    public function suratLayakTerbangIbuHamil()
    {
        $no_registrasi = $this->request->getVar('no_registrasi');
        echo $this->generateSuratHtml($no_registrasi, $this->getTemplateLayakTerbangIbuHamil());
    }

    public function suratKeteranganIstirahat()
    {
        $no_registrasi = $this->request->getVar('no_registrasi');
        echo $this->generateSuratHtml($no_registrasi, $this->getTemplateKeteranganIstirahat());
    }

    public function suratKeteranganDokter()
    {
        $no_registrasi = $this->request->getVar('no_registrasi');
        echo $this->generateSuratHtml($no_registrasi, $this->getTemplateKeteranganDokter());
    }

    public function suratKeteranganSehat()
    {
        $no_registrasi = $this->request->getVar('no_registrasi');
        echo $this->generateSuratHtml($no_registrasi, $this->getTemplateKeteranganSehat());
    }

    // ==================== SURAT TEMPLATES ====================

    private function getTemplateLayakTerbang()
    {
        return '
        <p style="line-height:107%;margin:0cm 0cm 8pt;text-align:center;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:14.0pt;"><span style="line-height:107%;" lang="IN" dir="ltr"><strong><u>SURAT KETERANGAN LAYAK TERBANG</u></strong></span></span>
        </p>
        <p style="line-height:107%;margin:0cm 0cm 8pt;text-align:center;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:14.0pt;"><span style="line-height:107%;" lang="EN-GB" dir="ltr"><strong>&nbsp; &nbsp; &nbsp;/ SLT / MDC / 2024</strong></span></span>
        </p>
        <p style="line-height:150%;margin:0cm 0cm 8pt;text-align:justify;text-indent:36.0pt;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Yang bertanda tangan di bawah ini menerangkan bahwa :&nbsp;</span></span>
        </p>
        <p style="line-height:normal;margin:0cm 0cm 8pt 36.0pt;text-align:justify;text-indent:36.0pt;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-US" dir="ltr">Nama&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : $fullname</span></span>
        </p>
        <p style="line-height:normal;margin:0cm 0cm 8pt 36.0pt;text-align:justify;text-indent:36.0pt;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="IN" dir="ltr">Usia &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : $tahun</span></span>
        </p>
        <p style="line-height:normal;margin:0cm 0cm 8pt 36.0pt;text-align:justify;text-indent:36.0pt;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-GB" dir="ltr">Jenis Kelamin&nbsp;: $gender</span></span>
        </p>
        <p style="line-height:normal;margin:0cm 0cm 8pt 36.0pt;text-align:justify;text-indent:36.0pt;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-US" dir="ltr">Alamat &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : $addr</span></span>
        </p>
        <p style="line-height:normal;margin:0cm 0cm 8pt 36.0pt;text-align:justify;text-indent:36.0pt;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-US" dir="ltr">Pekerjaan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: $pekerjaan</span></span>
        </p>
        <p style="line-height:normal;margin:0cm 0cm 8pt 36.0pt;text-align:justify;text-indent:36.0pt;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-US" dir="ltr">Diagnosa&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : $diagnosa</span></span>
        </p>
        <p style="line-height:150%;margin:0cm 0cm 8pt 36.0pt;text-align:justify;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="IN" dir="ltr">Telah dilakukan pemeriksaan dan dinyatakan dalam kondisi&nbsp;</span><span style="line-height:150%;" lang="EN-GB" dir="ltr"><strong>STABIL dan LAYAK TERBANG</strong></span></span>
        </p>
        <p style="line-height:150%;margin:0cm 0cm 8pt 36.0pt;text-align:justify;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-GB" dir="ltr">Demikian surat keterangan ini kami buat, agar dapat dipergunakan sebagaimana mestinya.&nbsp;</span></span>
        </p>
        <table style="width:100%">
            <tr>
                <td style="width:20%"></td>
                <td style="width:20%"></td>
                <td style="width:20%"></td>
                <td style="width:20%"><span style="font-family: Times New Roman, serif; font-size: 16px;">Surabaya, &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;2024</span></td>
                <td style="width:20%"></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td><span style="font-family: Times New Roman, serif; font-size: 16px;">Dokter yang memeriksa</span></td>
                <td></td>
            </tr>
            <tr><td></td><td></td><td></td><td><br><br><br></td><td></td></tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>....................................................</td>
                <td></td>
            </tr>
        </table>';
    }

    private function getTemplateLayakTerbangIbuHamil()
    {
        return '
        <p style="line-height:107%;margin:0cm 0cm 8pt;text-align:center;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:14.0pt;"><span style="line-height:107%;" lang="IN" dir="ltr"><strong><u>SURAT KETERANGAN LAYAK TERBANG IBU HAMIL</u></strong></span></span>
        </p>
        <p style="line-height:107%;margin:0cm 0cm 8pt;text-align:center;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:14.0pt;"><span style="line-height:107%;" lang="EN-GB" dir="ltr"><strong>&nbsp;&nbsp;/ SLTIH / MDC / 2024</strong></span></span>
        </p>
        <p style="line-height:150%;margin:0cm 0cm 8pt;text-align:justify;text-indent:36.0pt;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Yang bertanda tangan di bawah ini menerangkan bahwa :&nbsp;</span></span>
        </p>
        <p style="line-height:normal;margin:0cm 0cm 8pt 36.0pt;text-align:justify;text-indent:36.0pt;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-US" dir="ltr">Nama&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : $fullname</span></span>
        </p>
        <p style="line-height:normal;margin:0cm 0cm 8pt 36.0pt;text-align:justify;text-indent:36.0pt;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="IN" dir="ltr">Usia &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : $tahun</span></span>
        </p>
        <p style="line-height:normal;margin:0cm 0cm 8pt 36.0pt;text-align:justify;text-indent:36.0pt;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-US" dir="ltr">Alamat &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : $addr</span></span>
        </p>
        <p style="line-height:normal;margin:0cm 0cm 8pt 36.0pt;text-align:justify;text-indent:36.0pt;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-US" dir="ltr">Pekerjaan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: $pekerjaan</span></span>
        </p>
        <p style="line-height:normal;margin:0cm 0cm 8pt 36.0pt;text-align:justify;text-indent:36.0pt;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-US" dir="ltr">Diagnosa&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : $diagnosa</span></span>
        </p>
        <p style="line-height:150%;margin:0cm 0cm 8pt 36.0pt;text-align:justify;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="IN" dir="ltr">Telah dilakukan pemeriksaan dan dinyatakan dalam kondisi&nbsp;</span><span style="line-height:150%;" lang="EN-GB" dir="ltr"><strong>SEHAT dan LAYAK TERBANG</strong></span></span>
        </p>
        <p style="line-height:150%;margin:0cm 0cm 8pt 36.0pt;text-align:justify;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-GB" dir="ltr">Demikian surat keterangan ini kami buat, agar dapat dipergunakan sebagaimana mestinya.&nbsp;</span></span>
        </p>
        <table style="width:100%">
            <tr>
                <td style="width:20%"></td>
                <td style="width:20%"></td>
                <td style="width:20%"></td>
                <td style="width:20%"><span style="font-family: Times New Roman, serif; font-size: 16px;">Surabaya, &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;2024</span></td>
                <td style="width:20%"></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td><span style="font-family: Times New Roman, serif; font-size: 16px;">Dokter yang memeriksa</span></td>
                <td></td>
            </tr>
            <tr><td></td><td></td><td></td><td><br><br><br></td><td></td></tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>....................................................</td>
                <td></td>
            </tr>
        </table>';
    }

    private function getTemplateKeteranganIstirahat()
    {
        return '
        <p style="line-height:115%;margin:0cm 0cm 0cm 36.0pt;text-align:center;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:115%;" lang="EN-US" dir="ltr"><strong><u>SURAT KETERANGAN ISTIRAHAT</u></strong></span></span>
        </p>
        <p style="line-height:115%;margin:0cm 0cm 0cm 36.0pt;text-align:center;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:115%;" lang="IN" dir="ltr"><strong>/ SKI / MDC / 2024</strong></span></span>
        </p>
        <p style="line-height:normal;margin:0cm 36.0pt;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-US" dir="ltr">Yang bertanda tangan di bawah ini menerangkan bahwa :&nbsp;</span></span>
        </p>
        <p style="line-height:normal;margin:0cm 36.0pt;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-US" dir="ltr">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nama&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : $fullname</span></span>
        </p>
        <p style="line-height:normal;margin:0cm 36.0pt 0cm 72.0pt;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="IN" dir="ltr">Usia&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : $tahun</span></span>
        </p>
        <p style="line-height:normal;margin:0cm 36.0pt 0cm 72.0pt;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-GB" dir="ltr">Jenis Kelamin&nbsp; : $gender</span></span>
        </p>
        <p style="line-height:normal;margin:0cm 36.0pt 0cm 72.0pt;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-US" dir="ltr">Alamat&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : $addr</span></span>
        </p>
        <p style="line-height:normal;margin:0cm 36.0pt 0cm 72.0pt;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="IN" dir="ltr">Pekerjaan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : $pekerjaan</span></span>
        </p>
        <p style="line-height:normal;margin:0cm 36.0pt 0cm 72.0pt;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="IN" dir="ltr">Diagnosa&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : $diagnosa</span></span>
        </p>
        <p style="line-height:150%;margin:0cm 36.0pt;text-align:justify;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="IN" dir="ltr">Berdasarkan pemeriksaan medis yang kami lakukan, pasien tersebut diatas dalam keadaan&nbsp;</span><span style="line-height:150%;" lang="EN-GB" dir="ltr"><strong>SAKIT</strong></span><span style="line-height:150%;" lang="IN" dir="ltr">, sehingga perlu istirahat</span></span>
        </p>
        <p style="line-height:150%;margin:0cm 36.0pt;text-align:justify;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="IN" dir="ltr">Demikian surat keterangan ini diberikan untuk diketahui dan dipergunakan dengan semestinya.</span></span>
        </p>
        <table style="width:100%">
            <tr>
                <td style="width:20%"></td>
                <td style="width:20%"></td>
                <td style="width:20%"></td>
                <td style="width:20%"><span style="font-family: Times New Roman, serif; font-size: 16px;">Surabaya, &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;2024</span></td>
                <td style="width:20%"></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td><span style="font-family: Times New Roman, serif; font-size: 16px;">Dokter yang merawat,</span></td>
                <td></td>
            </tr>
            <tr><td></td><td></td><td></td><td><br><br><br></td><td></td></tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>....................................................</td>
                <td></td>
            </tr>
        </table>';
    }

    private function getTemplateKeteranganDokter()
    {
        return '
        <p style="line-height:115%;margin:0cm;text-align:center;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:115%;" lang="EN-US" dir="ltr"><strong><u>SURAT KETERANGAN DOKTER</u></strong></span></span>
        </p>
        <p style="line-height:115%;margin:0cm;text-align:center;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:115%;" lang="IN" dir="ltr"><strong>/ SKD / MDC / 2024</strong></span></span>
        </p>
        <p style="line-height:150%;margin:0cm 0cm 0cm 36.0pt;text-align:justify;text-indent:36.0pt;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Pasien yang tersebut dibawah ini :</span></span>
        </p>
        <p style="line-height:150%;margin:0cm 0cm 0cm 36.0pt;text-indent:36.0pt;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Nama&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : $fullname</span></span>
        </p>
        <p style="line-height:150%;margin:0cm 0cm 0cm 36.0pt;text-indent:36.0pt;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="IN" dir="ltr">Tempat tanggal lahir : $tempat_lahir, $birth_dt</span></span>
        </p>
        <p style="line-height:150%;margin:0cm 0cm 0cm 36.0pt;text-indent:36.0pt;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Jenis Kelamin : $gender</span></span>
        </p>
        <p style="line-height:150%;margin:0cm 0cm 0cm 36.0pt;text-indent:36.0pt;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Alamat : $addr</span></span>
        </p>
        <p style="line-height:150%;margin:0cm 0cm 0cm 72.0pt;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Diagnosa : $diagnosa</span></span>
        </p>
        <p style="line-height:150%;margin:0cm 0cm 0cm 36.0pt;tab-stops:70.9pt;text-align:justify;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Demikian surat keterangan ini kami buat, atas perhatiannya kami ucapkan terima kasih&nbsp;</span></span>
        </p>
        <table style="width:100%">
            <tr>
                <td style="width:20%"></td>
                <td style="width:20%"></td>
                <td style="width:20%"></td>
                <td style="width:20%"><span style="font-family: Times New Roman, serif; font-size: 16px;">Surabaya, &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;2024</span></td>
                <td style="width:20%"></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td><span style="font-family: Times New Roman, serif; font-size: 16px;">Dokter yang merawat,</span></td>
                <td></td>
            </tr>
            <tr><td></td><td></td><td></td><td><br><br><br></td><td></td></tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>....................................................</td>
                <td></td>
            </tr>
        </table>';
    }

    private function getTemplateKeteranganSehat()
    {
        return '
        <p style="line-height:115%;margin:0cm;text-align:center;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:115%;" lang="EN-US" dir="ltr"><strong><u>SURAT KETERANGAN SEHAT</u></strong></span></span>
        </p>
        <p style="line-height:115%;margin:0cm;text-align:center;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:115%;" lang="EN-US" dir="ltr"><strong>/ SKS / MDC / 2024</strong></span></span>
        </p>
        <p style="line-height:150%;margin:0cm 36.0pt;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Yang bertanda tangan di bawah ini, dokter MedicElle Clinic menerangkan dengan sesungguhnya bahwa :&nbsp;</span></span>
        </p>
        <p style="line-height:150%;margin:0cm 36.0pt;text-indent:36.0pt;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Nama : $fullname</span></span>
        </p>
        <p style="line-height:150%;margin:0cm 36.0pt;text-indent:36.0pt;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Alamat : $addr</span></span>
        </p>
        <p style="line-height:150%;margin:0cm 36.0pt;text-indent:36.0pt;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Jenis kelamin : $gender</span></span>
        </p>
        <p style="line-height:150%;margin:0cm 36.0pt;text-indent:36.0pt;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Usia : $tahun</span></span>
        </p>
        <p style="line-height:150%;margin:0cm 36.0pt;text-indent:36.0pt;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Pekerjaan : $pekerjaan</span></span>
        </p>
        <p style="line-height:150%;margin:0cm 36.0pt;tab-stops:42.55pt;text-align:justify;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Berdasarkan hasil pemeriksaan yang telah dilakukan :&nbsp;</span></span>
        </p>
        <p style="line-height:150%;margin:0cm 36.0pt;tab-stops:70.9pt;text-align:justify;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TD : $tekanan_darah&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; N : $n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; RR : $rr&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Suhu : $suhu</span></span>
        </p>
        <p style="line-height:150%;margin:0cm 36.0pt;tab-stops:70.9pt;text-align:justify;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BB : $berat_badan Kg&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TB : $tinggi_badan Cm</span></span>
        </p>
        <p style="line-height:150%;margin:0cm 36.0pt;tab-stops:70.9pt;text-align:justify;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pemeriksaan Mata : Dalam Batas Normal</span></span>
        </p>
        <p style="line-height:150%;margin:0cm 36.0pt;tab-stops:70.9pt;text-align:justify;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pemeriksaan Telinga : Dalam Batas Normal</span></span>
        </p>
        <p style="line-height:150%;margin:0cm 36.0pt;tab-stops:70.9pt;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Benar telah diperiksa dengan teliti dan dinyatakan dalam keadaan <strong>SEHAT</strong></span></span>
        </p>
        <p style="line-height:150%;margin:0cm 36.0pt;tab-stops:70.9pt;">
            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Surat Keterangan sehat ini dipergunakan untuk Perpanjangan SIP</span></span>
        </p>
        <table style="width:100%">
            <tr>
                <td style="width:20%"></td>
                <td style="width:20%"></td>
                <td style="width:20%"></td>
                <td style="width:20%"><span style="font-family: Times New Roman, serif; font-size: 16px;">Surabaya, &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;2024</span></td>
                <td style="width:20%"></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td><span style="font-family: Times New Roman, serif; font-size: 16px;">Dokter yang merawat,</span></td>
                <td></td>
            </tr>
            <tr><td></td><td></td><td></td><td><br><br><br></td><td></td></tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>....................................................</td>
                <td></td>
            </tr>
        </table>';
    }

    // ==================== PDF ====================

    public function fetchSingleDataPrint($no_registrasi)
    {
        if ($no_registrasi) {
            $url = "$this->server/tregistrasirujukan/getby/$no_registrasi";
            $response = akses_restapi('GET', $url, []);
            $data = json_decode($response, true);

            $Pdfgenerator = new Pdfgenerator();
            $this->data['title_pdf'] = 'SURAT RUJUKAN';
            $this->data['content'] = $data;
            $html = view('rpt_surat_rujukan', $this->data);
            $Pdfgenerator->generate($html, 'Surat Rujukan Pasien', 'A4', 'portrait');
        }
    }

    // ==================== SET SESSION ====================

    public function setNoRegistrasi()
    {
        if ($this->request->isAJAX()) {
            $ses_data = [
                'no_registrasi' => $this->request->getVar('no_registrasi'),
                'patient_no' => $this->request->getVar('patient_no')
            ];
            $this->session->set($ses_data);
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    // ==================== DRAW PAGES ====================

    public function draw()
    {
        $this->data['title'] = ' | ' . $_ENV['APP_TITLE'];
        return view('konsultasidokter2/draw', $this->data);
    }
    public function draw1()
    {
        $this->data['title'] = ' | ' . $_ENV['APP_TITLE'];
        return view('konsultasidokter2/draw1', $this->data);
    }
    public function draw2()
    {
        $this->data['title'] = ' | ' . $_ENV['APP_TITLE'];
        return view('konsultasidokter2/draw2', $this->data);
    }
    public function draw3()
    {
        $this->data['title'] = ' | ' . $_ENV['APP_TITLE'];
        return view('konsultasidokter2/draw3', $this->data);
    }
    public function draw4()
    {
        $this->data['title'] = ' | ' . $_ENV['APP_TITLE'];
        return view('konsultasidokter2/draw4', $this->data);
    }
    public function draw5()
    {
        $this->data['title'] = ' | ' . $_ENV['APP_TITLE'];
        return view('konsultasidokter2/draw5', $this->data);
    }
    public function draw6()
    {
        $this->data['title'] = ' | ' . $_ENV['APP_TITLE'];
        return view('konsultasidokter2/draw6', $this->data);
    }
    public function draw7()
    {
        $this->data['title'] = ' | ' . $_ENV['APP_TITLE'];
        return view('konsultasidokter2/draw7', $this->data);
    }

    // ==================== UPLOAD ====================

    public function doupload1()
    {
        if ($this->request->isAJAX()) {
            $image_nm = $this->request->getVar('image_nm');
            $no_registrasi = $this->request->getVar('no_registrasi');

            if ($this->request->getPost('gambar') == '') {
                $msg = ['error' => 'Silahkan klik ambil gambar...'];
            } else {
                $image = $this->request->getPost('gambar');
                $image = str_replace('data:image/jpeg;base64,', '', $image);
                $image = base64_decode($image);
                $filename = $image_nm . '.jpg';
                file_put_contents(FCPATH . '/assets/img/titikkeluhan/' . $filename, $image);

                $url = "$this->server/ttitikkeluhan/insert";
                $data = ['no_registrasi' => $no_registrasi, 'image' => $image_nm];
                akses_restapi('POST', $url, $data);

                $msg = ['success' => 'Gambar berhasil di upload'];
            }
            echo json_encode($msg);
        }
    }

    // ==================== AJAX DROPDOWN ====================

    public function ajaxKategoriAlergi($nama)
    {
        $url = "$this->server/dropdown/tfield_value/$nama";
        $response = akses_restapi('GET', $url, []);
        $results = json_decode($response, true);

        $data_array = [];
        if (!empty($results)) {
            foreach ($results as $row) {
                $data_array[] = ['id' => $row['fld_valu'], 'text' => $row['fld_desc']];
            }
        }
        return $this->response->setJSON($data_array);
    }

    public function ajaxKategoriBiaya($nama)
    {
        $url = "$this->server/dropdown/tfield_value/$nama";
        $response = akses_restapi('GET', $url, []);
        $results = json_decode($response, true);

        $data_array = [];
        if (!empty($results)) {
            foreach ($results as $row) {
                $data_array[] = ['id' => $row['fld_valu'], 'text' => $row['fld_desc']];
            }
        }
        return $this->response->setJSON($data_array);
    }

    // ==================== ACTION: RUJUKAN ====================

    public function action_rujukan()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'no_registrasi' => ['label' => 'No. Registrasi', 'rules' => 'required']
            ]);

            if (!$valid) {
                $msg = ['error' => ['no_registrasi' => $validation->getError('no_registrasi')]];
            } else {
                $url = "$this->server/tregistrasirujukan/double";
                $data = [
                    'no_registrasi' => $this->request->getVar('no_registrasi'),
                    'rujukan' => $this->request->getVar('rujukan'),
                    'ket_rujukan' => $this->request->getVar('ket_rujukan'),
                    'dokter_rujukan' => $this->request->getVar('dokter_rujukan'),
                    'user_rujukan' => $this->session->get('fullname'),
                ];
                akses_restapi('POST', $url, $data);
                $msg = ['success' => 'data berhasil di create!'];
            }
            echo json_encode($msg);
        }
    }

    // ==================== ACTION: MAIN SAVE ====================

    public function action_all()
    {
        $action = $this->request->getVar('action_all');

        if ($action == 'Add' || $action == 'Draft') {
            $validation = \Config\Services::validation();

            $rules = [
                'patient_no' => ['label' => 'Code', 'rules' => 'required'],
                'keluhan_utama' => ['label' => 'Keluhan Utama', 'rules' => 'required'],
                'riwayat_perjalanan_keluhan' => ['label' => 'Riwayat Perjalanan Keluhan', 'rules' => 'required'],
                'riwayat_penyakit_dahulu' => ['label' => 'Riwayat Penyakit Dahulu', 'rules' => 'required'],
                'riwayat_operasi_pengobatan' => ['label' => 'Riwayat Operasi Pengobatan', 'rules' => 'required'],
                'riwayat_penyakit_keluarga' => ['label' => 'Riwayat Penyakit Keluarga', 'rules' => 'required'],
                'riwayat_lain' => ['label' => 'Riwayat Lain', 'rules' => 'required'],
                'kondisi_umum' => ['label' => 'Kondisi Umum', 'rules' => 'required'],
                'tinggi_badan' => ['label' => 'Tinggi Badan', 'rules' => 'required'],
                'berat_badan' => ['label' => 'Berat Badan', 'rules' => 'required'],
                'suhu' => ['label' => 'Suhu', 'rules' => 'required'],
                'sistolik' => ['label' => 'Sistolik', 'rules' => 'required'],
                'diastolik' => ['label' => 'Diastolik', 'rules' => 'required'],
                'denyut_nadi' => ['label' => 'Denyut_nadi', 'rules' => 'required'],
                'laju_nafas' => ['label' => 'Laju Nafas', 'rules' => 'required'],
                'kondisi_khusus' => ['label' => 'Kondisi Khusus', 'rules' => 'required'],
                'pemeriksaan_tambahan' => ['label' => 'Pemeriksaan Tambahan', 'rules' => 'required'],
                'diagnosa_utama' => ['label' => 'Diagnosa Utama', 'rules' => 'required'],
                'diagnosa_sekunder' => ['label' => 'Diagnosa Sekunder', 'rules' => 'required'],
            ];

            $valid = $this->validate($rules);
            $no_registrasi = $this->request->getVar('no_registrasi');

            if (!$valid) {
                $msg = ['error' => array_combine(
                    array_keys($rules),
                    array_map(function ($key) use ($validation) {
                        return $validation->getError($key);
                    }, array_keys($rules))
                )];
            } else {
                // Update status
                $statusUrl = $action == 'Add'
                    ? "$this->server/tregistrasi/konsultasidokter/$no_registrasi"
                    : "$this->server/tregistrasi/draft/$no_registrasi";
                akses_restapi('PATCH', $statusUrl, []);

                // Get no_kwitansi
                $kwtUrl = "$this->server/billing/getkwtby/$no_registrasi";
                $kwtResponse = akses_restapi('GET', $kwtUrl, []);
                $kwtData = json_decode($kwtResponse, true);
                $no_kwitansi = $kwtData[0]['no_kwitansi'] ?? '';

                // Save all data
                $this->saveAnamnesa();
                $this->savePeriksa();
                $this->saveDiagnosa();
                $this->saveAlergi();
                $this->saveDiagnosaTambahan();
                $this->saveLayananAndBilling($no_registrasi, $no_kwitansi);
                $this->saveTindakan();

                $msg = ['success' => 'data berhasil di create!'];
            }
            echo json_encode($msg);
        }
    }

    // ==================== HELPER SAVE METHODS ====================

    private function saveAnamnesa()
    {
        $url = "$this->server/tregistrasianamnesa/double";
        $data = [
            'no_registrasi' => $this->request->getVar('no_registrasi'),
            'responden' => $this->request->getVar('responden'),
            'keluhan_utama' => $this->request->getVar('keluhan_utama'),
            'riwayat_perjalanan_keluhan' => $this->request->getVar('riwayat_perjalanan_keluhan'),
            'riwayat_penyakit_sekarang' => $this->request->getVar('riwayat_penyakit_sekarang'),
            'riwayat_penyakit_dahulu' => $this->request->getVar('riwayat_penyakit_dahulu'),
            'riwayat_operasi_pengobatan' => $this->request->getVar('riwayat_operasi_pengobatan'),
            'riwayat_penyakit_keluarga' => $this->request->getVar('riwayat_penyakit_keluarga'),
            'riwayat_lain' => $this->request->getVar('riwayat_lain'),
        ];
        akses_restapi('POST', $url, $data);
    }

    private function savePeriksa()
    {
        $url = "$this->server/tregistrasiperiksa/double";
        $data = [
            'no_registrasi' => $this->request->getVar('no_registrasi'),
            'kondisi_umum' => $this->request->getVar('kondisi_umum'),
            'kondisi_khusus' => $this->request->getVar('kondisi_khusus'),
            'tinggi_badan' => $this->request->getVar('tinggi_badan'),
            'berat_badan' => $this->request->getVar('berat_badan'),
            'sistolik' => $this->request->getVar('sistolik'),
            'diastolik' => $this->request->getVar('diastolik'),
            'denyut_nadi' => $this->request->getVar('denyut_nadi'),
            'laju_nafas' => $this->request->getVar('laju_nafas'),
            'suhu' => $this->request->getVar('suhu'),
            'bmi' => $this->request->getVar('bmi'),
            'pemeriksaan_tambahan' => $this->request->getVar('pemeriksaan_tambahan'),
        ];
        akses_restapi('POST', $url, $data);
    }

    private function saveDiagnosa()
    {
        $url = "$this->server/tregistrasidiagnosa/double";
        $data = [
            'no_registrasi' => $this->request->getVar('no_registrasi'),
            'diagnosa_utama' => $this->request->getVar('diagnosa_utama'),
            'icd10_utama' => $this->request->getVar('icd10_utama'),
            'klasifikasi_utama' => $this->request->getVar('klasifikasi_utama'),
            'diagnosa_sekunder' => $this->request->getVar('diagnosa_sekunder'),
            'icd10_sekunder' => $this->request->getVar('icd10_sekunder'),
            'klasifikasi_sekunder' => $this->request->getVar('klasifikasi_sekunder'),
            'diagnosa_utama_sta' => $this->request->getVar('diagnosa_utama_sta'),
            'diagnosa_sekunder_sta' => $this->request->getVar('diagnosa_sekunder_sta'),
        ];
        akses_restapi('POST', $url, $data);
    }

    private function saveAlergi()
    {
        $alergi_data = $this->request->getVar('alergi');
        if (!empty($alergi_data)) {
            foreach ($alergi_data as $alergi) {
                $komponen_arr = array_map(function ($v) {
                    return trim(str_replace('+', '', $v));
                }, (array)($alergi['komponen'] ?? []));
                $reaksi_arr = array_map(function ($v) {
                    return trim(str_replace('+', '', $v));
                }, (array)($alergi['reaksi'] ?? []));
                $komponen_gabung = implode(',', array_filter($komponen_arr));
                $reaksi_gabung = implode(',', array_filter($reaksi_arr));

                $data = [
                    'patient_no' => $this->request->getVar('patient_no'),
                    'kategori' => $alergi['kategori'] ?? '',
                    'komponen' => $komponen_gabung,
                    'reaksi' => $reaksi_gabung,
                ];

                $alergi_no = trim($alergi['alergi_no'] ?? '');
                if (!empty($alergi_no)) {
                    $data['alergi_no'] = $alergi_no;
                    akses_restapi('PUT', "$this->server/tpatientalergi/update", $data);
                } else {
                    akses_restapi('POST', "$this->server/tpatientalergi/insert", $data);
                }
            }
        }
    }

    private function saveDiagnosaTambahan()
    {
        $diagnosa = $this->request->getVar('diagnosa_tambahan');
        $seq_id = $this->request->getVar('seq_id');
        if (!empty($diagnosa)) {
            foreach ($diagnosa as $i => $d) {
                $data = [
                    'no_registrasi' => $this->request->getVar('no_registrasi'),
                    'diagnosa' => $d,
                    'icd10' => ($this->request->getVar('icd10_tambahan')[$i] ?? ''),
                    'klasifikasi' => ($this->request->getVar('klasifikasi_tambahan')[$i] ?? ''),
                ];
                if (!empty($seq_id[$i])) {
                    $data['seq_id'] = $seq_id[$i];
                    akses_restapi('PUT', "$this->server/tregistrasidiagnosatambahan/update", $data);
                } else {
                    akses_restapi('POST', "$this->server/tregistrasidiagnosatambahan/insert", $data);
                }
            }
        }
    }

    private function saveLayananAndBilling($no_registrasi, $no_kwitansi)
    {
        $layanan = $this->request->getVar('layanan');
        $item_cd = $this->request->getVar('item_cd');
        if (!empty($layanan)) {
            $harga_sp = $this->request->getVar('harga_sp');
            $total = is_array($harga_sp) ? array_sum($harga_sp) : 0;

            foreach ($layanan as $i => $layananVal) {
                $itemVal = $item_cd[$i] ?? '';
                if (!empty($layananVal) && !empty($itemVal)) {
                    $data = [
                        'no_registrasi' => $no_registrasi,
                        'layanan' => $layananVal,
                        'item_cd' => $itemVal,
                    ];
                    akses_restapi('POST', "$this->server/tregistrasilayananlrmu/insert", $data);

                    $billingData = [
                        'no_kwitansi' => $no_kwitansi,
                        'item_cd' => $itemVal,
                        'jumlah' => (int)str_replace([',', '.'], ['', ''], ($this->request->getVar('qty')[$i] ?? 1)),
                        'tarif' => (int)str_replace([',', '.'], ['', ''], ($this->request->getVar('harga_sd')[$i] ?? 0)),
                        'potongan' => (int)str_replace([',', '.'], ['', ''], ($this->request->getVar('reduksi')[$i] ?? 0)),
                        'pajak' => (int)str_replace([',', '.'], ['', ''], ($this->request->getVar('pajak')[$i] ?? 0)),
                        'total' => (int)str_replace([',', '.'], ['', ''], ($this->request->getVar('harga_sp')[$i] ?? 0)),
                    ];
                    akses_restapi('POST', "$this->server/billingdetail/insert", $billingData);
                }
            }

            if ($total > 0) {
                $billing = [
                    'no_kwitansi' => $no_kwitansi,
                    'no_registrasi' => $no_registrasi,
                    'tgl_kwitansi' => date('Y-m-d H:i:s'),
                    'emp_cd' => $this->session->get('usr_id'),
                    'status_kwitansi' => 'aktif',
                    'terbilang' => '',
                    'tagihan' => $total,
                    'saldo' => 0,
                ];
                akses_restapi('PUT', "$this->server/billing/update", $billing);
            }
        }
    }

    private function saveTindakan()
    {
        $url = "$this->server/tregistrasitindakan/double";
        $data = [
            'no_registrasi' => $this->request->getVar('no_registrasi'),
            'resep' => $this->request->getVar('resep'),
            'laboratorium' => $this->request->getVar('laboratorium'),
            'radiologi' => $this->request->getVar('radiologi'),
            'prosedur_primer' => $this->request->getVar('prosedur_primer'),
            'prosedur_skunder' => $this->request->getVar('prosedur_skunder'),
            'tatalaksana' => $this->request->getVar('tatalaksana'),
            'reduksi' => $this->request->getVar('reduksi'),
        ];
        akses_restapi('POST', $url, $data);
    }

    // ==================== DELETE METHODS ====================

    public function delete_alergi()
    {
        if ($this->request->isAJAX()) {
            $patient_no = $this->request->getVar('patient_no');
            $alergi_no = $this->request->getVar('alergi_no');
            $url = "$this->server/tpatientalergi/delete/$patient_no/$alergi_no";
            akses_restapi('DELETE', $url, []);
            echo json_encode(['success' => "Data berhasil dihapus"]);
        }
    }

    public function delete_diagnosa()
    {
        if ($this->request->isAJAX()) {
            $no_registrasi = $this->request->getVar('no_registrasi');
            $seq_id = $this->request->getVar('seq_id');
            $url = "$this->server/tregistrasidiagnosatambahan/delete/$no_registrasi/$seq_id";
            akses_restapi('DELETE', $url, []);
            echo json_encode(['success' => "Data berhasil dihapus"]);
        }
    }
}
