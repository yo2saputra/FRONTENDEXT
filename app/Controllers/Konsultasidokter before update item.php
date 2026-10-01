<?php

namespace App\Controllers;

use App\Controllers\BaseController;
// use Config\Services;
use App\Libraries\Pdfgenerator;
// use CodeIgniter\I18n\Time;



class Konsultasidokter extends BaseController
{

    protected $data;
    protected $server;
    protected $client;

    public function __construct()
    {
        $this->session = session();
        $uri = service('uri');
        $this->server = $_ENV['APP_API'];
    }

    public function index()
    {
        // helper dropdown
        helper(['dropdown']);

        $this->data['title'] = ' | ' . $_ENV['APP_TITLE'];
        // $this->data['cb_diagnosa_utama'] = getDropdownNolabelDiagnosa('diagnosa_utama', 4); // (id, input size)
        // $this->data['cb_diagnosa_sekunder'] = getDropdownNolabelDiagnosa('diagnosa_sekunder', 4); // (id, input size)

        // $this->data['cb_kategori_alergi'] = getDropdownNolabelVertical('kategori_alergi'); // (id, input size)
        // $this->data['cb_bahan_alergi'] = getDropdownNolabelVertical('bahan_alergi'); // (id, input size)
        // $this->data['cb_komponen_alergi'] = getDropdownNolabelVertical('komponen_alergi'); // (id, input size)
        // $this->data['cb_reaksi_alergi'] = getDropdownNolabelVertical('reaksi_alergi'); // (id, input size)
        // $this->data['cb_tingkat_kegawatan_alergi'] = getDropdownNolabelVertical('tingkat_kegawatan_alergi'); // (id, input size)
        // $this->data['cb_status_alergi'] = getDropdownNolabelVertical('status_alergi'); // (id, input size)
        // $this->data['cb_verifikasi_alergi'] = getDropdownNolabelVertical('verifikasi_alergi'); // (id, input size)
        $this->data['cb_dokter'] = getDropdownDokterNolabelVertical('dokter_rujukan'); // (name)
        $this->data['cb_jenissurat'] = getDropdownNolabelVertical('jenis_surat'); // (name)
        $this->data['cb_layanan'] = getDropdownNolabelVerticalWithoutName('layanan'); // (name)
        $this->data['cb_layanan_item'] = getDropdownNolabelVertical('item_test'); // (name)

        //appointment
        $this->data['cb_pasien'] = getDropdownPasien2('patient_no', 'Pasien', 2, 4); // (id,Label,label size, input size)
        $this->data['cb_tujuan'] = getDropdownPolyclinicCustom('tujuan_registrasi', 'tujuan_registrasi', 'Tujuan Registrasi', 2, 4); // (key,id,Label,label size, input size, filter)
        // $this->data['cb_tujuan'] = getDropdownCustomFilter('tujuan_registrasi', 'tujuan_registrasi', 'Tujuan Registrasi', 2, 4, ['dokter']); // (key,id,Label,label size, input size, filter)
        $this->data['cb_pasien2'] = getDropdownPasienCustom('patient_no', 'patient_no_v', 'Pasien', 2, 4); // (key,id,Label,label size, input size)
        $this->data['cb_tujuan2'] = getDropdownPolyclinicCustom('tujuan_registrasi', 'tujuan_registrasi_v', 'Tujuan Registrasi', 2, 4); // (key,id,Label,label size, input size)
        // $this->data['cb_tujuan2'] = getDropdownCustom('tujuan_registrasi', 'tujuan_registrasi_v', 'Tujuan Registrasi', 2, 4); // (key,id,Label,label size, input size)
        $this->data['cb_type_pasien'] = getDropdown2('Tipe_Pasien', 'Tipe Pasien', 2, 4); // (id,Label,label size, input size)
        $this->data['cb_type_pasien2'] = getDropdownCustom('Tipe_Pasien', 'Tipe_Pasien_v', 'Tipe Pasien', 2, 4); // (key,id,Label,label size, input size)
        $this->data['cb_asuransi'] = getDropdownAsuransiCustomFilter('asr_cd', 'asr_cd', 'Asuransi', 2, 4, []); // (key,id,Label,label size, input size)
        $this->data['cb_asuransi2'] = getDropdownAsuransiCustomFilter('asr_cd', 'asr_cd_v', 'Asuransi', 2, 4, []); // (key,id,Label,label size, input size)
        // $this->data['cb_dokter'] = getDropdownDokterCustom('kode_dokter', 'kode_dokter', 'Dokter', 2, 10); // (key,id,Label,label size, input size)

        // $this->data['cb_tujuan'] = getDropdownPolyclinicCustom('tujuan_registrasi', 'tujuan_registrasi', 'Tujuan Registrasi', 2, 4); // (key,id,Label,label size, input size, filter)
        $this->data['cb_registrasi_via'] = getDropdown2('registrasi_via', 'Daftar Via', 2, 4); // (id,Label,label size, input size)

        return view('konsultasidokter/indexdraft', $this->data);
    }

    public function apiDataLabGetAll()
    {
        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/tmstitemlaboratorium/getlist";

        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);
        $data = $data['response_data'];

        // Mengelompokkan data berdasarkan kolom dan title
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
                'description' => $entry['nama_item']
            ];
        }

        // Menyusun data dalam format yang diinginkan
        $output = ['columns' => []];
        foreach ($groupedData as $group) {
            $output['columns'][] = $group;
        }

        return $this->response->setJSON($output);
    }

    public function apiDataRadiologiGetAll()
    {
        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/tmstitemradiologi/getlist";

        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);
        $data = $data['response_data'];

        // Mengelompokkan data berdasarkan kolom dan title
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
                'description' => $entry['nama_item']
            ];
        }

        // Menyusun data dalam format yang diinginkan
        $output = ['columns' => []];
        foreach ($groupedData as $group) {
            $output['columns'][] = $group;
        }

        return $this->response->setJSON($output);
    }

    function getDropdownLayananItem()
    {

        // helper dropdown
        helper(['dropdown']);

        $layanan = $this->request->getVar('layanan');

        $data = getDropdownLayananItemCustomTree($layanan);

        return $data;
    }

    public function apiDataGetTindakan()
    {
        $no_registrasi = $this->request->getVar('no_registrasi');

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/tregistrasitindakan/getby/$no_registrasi";

        // client request
        $response = akses_restapi('GET', $url, []);

        // $data['response_data'] = json_decode($response, true);
        // return $data['response_data'];

        return $response;
    }

    public function titikKeluhan()
    {
        // if ($this->request->isAJAX()) {

        $no_registrasi = $this->request->getVar('no_registrasi');
        $gambar = $this->request->getVar('gambar');

        // helper curl request
        helper(['restclient']);

        // end point
        $url = "$this->server/ttitikkeluhan/getby/$no_registrasi/$gambar";

        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);

        $output = '';
        $data =  $data['response_data'];
        if ($data == '') {
            $output .= '';
        } else {
            if ($data[0]["image"] != '') {
                $output .= '<p>
                        <img src="' . base_url() . '/assets/img/titikkeluhan/' . strtoupper($data[0]["image"]) . '.jpg?' . rand() . '" style="text-align: center; width: 25%;" class=""></p>
                        ';
            }
        }
        echo $output;
        // } else {
        //     exit('Maaf tidak dapat diproses!');
        // }
    }

    public function suratLayakTerbang()
    {
        // if ($this->request->isAJAX()) {

        $no_registrasi = $this->request->getVar('no_registrasi');

        // helper curl request
        helper(['restclient']);

        // end point
        $url = "$this->server/tregistrasi/getby/$no_registrasi";

        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);

        $output = '';
        $data =  $data['response_data'];
        if ($data == '') {
            $output .= '
                        <p style="line-height:107%;margin:0cm 0cm 8pt;text-align:center;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:14.0pt;"><span style="line-height:107%;" lang="IN" dir="ltr"><strong><u>SURAT KETERANGAN LAYAK TERBANG</u></strong></span></span>
                        </p>
                        <p style="line-height:107%;margin:0cm 0cm 8pt;text-align:center;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:14.0pt;"><span style="line-height:107%;" lang="EN-GB" dir="ltr"><strong>&nbsp; &nbsp; &nbsp;/ SLT / MDC / 202</strong></span><span style="line-height:107%;" lang="IN" dir="ltr"><strong>4</strong></span></span>
                        </p>
                        <p style="line-height:107%;margin:0cm 0cm 8pt;text-align:center;">
                            &nbsp;
                        </p>
                        <p style="line-height:150%;margin:0cm 0cm 8pt;text-align:justify;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Yang bertanda tangan di bawah ini menerangkan bahwa :&nbsp;</span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 0cm 8pt 36.0pt;text-align:justify;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-US" dir="ltr">Nama&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : $nama</span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 0cm 8pt 36.0pt;text-align:justify;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="IN" dir="ltr">Usia &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : $usia</span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 0cm 8pt 36.0pt;text-align:justify;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-GB" dir="ltr">Jenis Kelamin&nbsp;: Perempuan / Laki – Laki&nbsp;</span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 0cm 8pt 36.0pt;text-align:justify;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-US" dir="ltr">Alamat &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : $alamat</span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 0cm 8pt 36.0pt;text-align:justify;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-US" dir="ltr">Pekerjaan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: $pekerjaan</span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 0cm 8pt 36.0pt;text-align:justify;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-US" dir="ltr">Diagnosa&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : $diagnosa</span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 0cm 8pt;text-align:justify;text-indent:36.0pt;">
                            &nbsp;
                        </p>
                        <p style="line-height:150%;margin:0cm 0cm 8pt 36.0pt;text-align:justify;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="IN" dir="ltr">Telah di</span><span style="line-height:150%;" lang="EN-GB" dir="ltr">lakukan </span><span style="line-height:150%;" lang="IN" dir="ltr">pe</span><span style="line-height:150%;" lang="EN-GB" dir="ltr">mer</span><span style="line-height:150%;" lang="IN" dir="ltr">iksa</span><span style="line-height:150%;" lang="EN-GB" dir="ltr">an</span><span style="line-height:150%;" lang="IN" dir="ltr"> dan dinyatakan dalam kondisi&nbsp;</span><span style="line-height:150%;" lang="EN-GB" dir="ltr"><strong>STABIL dan LAYAK TERBANG</strong>&nbsp;</span><span style="line-height:150%;" lang="IN" dir="ltr">dari </span><span style="line-height:150%;" lang="EN-US" dir="ltr">..........&nbsp;</span><span style="line-height:150%;" lang="IN" dir="ltr">&nbsp;menuju ke</span><span style="line-height:150%;" lang="EN-GB" dir="ltr">…………………….. pada tanggal……………...</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 0cm 8pt;text-align:justify;">
                            &nbsp;
                        </p>
                        <p style="line-height:150%;margin:0cm 0cm 8pt 36.0pt;text-align:justify;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-GB" dir="ltr">Demikian surat keterangan ini kami buat, agar dapat dipergunakan sebagaimana mestinya.&nbsp;</span></span>
                        </p>
                        <p style="line-height:107%;margin:0cm 0cm 8pt;text-align:justify;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:107%;" lang="EN-US" dir="ltr">&nbsp; &nbsp; &nbsp; &nbsp;</span></span>
                        </p>
                        <p style="line-height:107%;margin:0cm 0cm 8pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:107%;" lang="EN-US" dir="ltr">&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Surabaya,&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;2024</span></span>
                        </p>
                        <p style="line-height:107%;margin:0cm 0cm 8pt 252.0pt;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:107%;" lang="EN-GB" dir="ltr">&nbsp; &nbsp;</span><span style="line-height:107%;" lang="IN" dir="ltr">Dokter yang memeriksa&nbsp;</span></span>
                        </p>
                        <p style="line-height:107%;margin:0cm 0cm 8pt 288.0pt;text-indent:36.0pt;">
                            &nbsp;
                        </p>
                        <p style="line-height:107%;margin:0cm 0cm 8pt;">
                            &nbsp;
                        </p>
                        <p style="line-height:107%;margin:0cm 0cm 8pt 252.0pt;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:107%;" lang="EN-GB" dir="ltr">&nbsp; &nbsp;…………………………</span></span>
                        </p>
                        <p><br></p>';
        } else {
            $output .= '

                        <p style="line-height:107%;margin:0cm 0cm 8pt;text-align:center;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:14.0pt;"><span style="line-height:107%;" lang="IN" dir="ltr"><strong><u>SURAT KETERANGAN LAYAK TERBANG</u></strong></span></span>
                        </p>
                        <p style="line-height:107%;margin:0cm 0cm 8pt;text-align:center;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:14.0pt;"><span style="line-height:107%;" lang="EN-GB" dir="ltr"><strong>&nbsp; &nbsp; &nbsp;/ SLT / MDC / 202</strong></span><span style="line-height:107%;" lang="IN" dir="ltr"><strong>4</strong></span></span>
                        </p>
                        <p style="line-height:107%;margin:0cm 0cm 8pt;text-align:center;">
                            &nbsp;
                        </p>
                        <p style="line-height:150%;margin:0cm 0cm 8pt;text-align:justify;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Yang bertanda tangan di bawah ini menerangkan bahwa :&nbsp;</span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 0cm 8pt 36.0pt;text-align:justify;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-US" dir="ltr">Nama&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : ' . $data[0]["fullname"] . '</span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 0cm 8pt 36.0pt;text-align:justify;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="IN" dir="ltr">Usia &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : ' . $data[0]["tahun"] . '</span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 0cm 8pt 36.0pt;text-align:justify;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-GB" dir="ltr">Jenis Kelamin&nbsp;: ' . ($data[0]["gender"] == 'M' ? 'Laki - laki' : 'Perempuan') . '&nbsp;</span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 0cm 8pt 36.0pt;text-align:justify;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-US" dir="ltr">Alamat &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : ' . $data[0]["addr"] . '</span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 0cm 8pt 36.0pt;text-align:justify;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-US" dir="ltr">Pekerjaan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ' . $data[0]["pekerjaan"] . '</span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 0cm 8pt 36.0pt;text-align:justify;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-US" dir="ltr">Diagnosa&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : ' . $data[0]["diagnosa"] . '</span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 0cm 8pt;text-align:justify;text-indent:36.0pt;">
                            &nbsp;
                        </p>
                        <p style="line-height:150%;margin:0cm 0cm 8pt 36.0pt;text-align:justify;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="IN" dir="ltr">Telah di</span><span style="line-height:150%;" lang="EN-GB" dir="ltr">lakukan </span><span style="line-height:150%;" lang="IN" dir="ltr">pe</span><span style="line-height:150%;" lang="EN-GB" dir="ltr">mer</span><span style="line-height:150%;" lang="IN" dir="ltr">iksa</span><span style="line-height:150%;" lang="EN-GB" dir="ltr">an</span><span style="line-height:150%;" lang="IN" dir="ltr"> dan dinyatakan dalam kondisi&nbsp;</span><span style="line-height:150%;" lang="EN-GB" dir="ltr"><strong>STABIL dan LAYAK TERBANG</strong>&nbsp;</span><span style="line-height:150%;" lang="IN" dir="ltr">dari </span><span style="line-height:150%;" lang="EN-US" dir="ltr">...........&nbsp;</span><span style="line-height:150%;" lang="IN" dir="ltr">&nbsp;menuju ke</span><span style="line-height:150%;" lang="EN-GB" dir="ltr">…………………….. pada tanggal……………...</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 0cm 8pt;text-align:justify;">
                            &nbsp;
                        </p>
                        <p style="line-height:150%;margin:0cm 0cm 8pt 36.0pt;text-align:justify;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-GB" dir="ltr">Demikian surat keterangan ini kami buat, agar dapat dipergunakan sebagaimana mestinya.&nbsp;</span></span>
                        </p>
                        <p style="line-height:107%;margin:0cm 0cm 8pt;text-align:justify;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:107%;" lang="EN-US" dir="ltr">&nbsp; &nbsp; &nbsp; &nbsp;</span></span>
                        </p>
                        <br>
                        <br>
                        <br>
                        <br>
                        <table style="width:100%">
                        <tbody><tr>
                            <td style="width:20%"></td>
                            <td style="width:20%"></td>
                            <td style="width:20%"></td>
                            <td style="width:20%"><span style="font-family: &quot;Times New Roman&quot;, serif; font-size: 16px; text-align: right;">Surabaya,&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;2024</span><br></td>
                            <td style="width:20%"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><span style="font-family: &quot;Times New Roman&quot;, serif; font-size: 16px; text-align: right; text-indent: 48px;">Dokter yang memeriksa</span><br></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><br></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><br></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><br></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>....................................................</td>
                            <td></td>
                        </tr>
                        </tbody></table>
                        <p><br></p>';
        }
        echo $output;
        // } else {
        //     exit('Maaf tidak dapat diproses!');
        // }
    }

    public function suratLayakTerbangIbuHamil()
    {
        // if ($this->request->isAJAX()) {

        $no_registrasi = $this->request->getVar('no_registrasi');

        // helper curl request
        helper(['restclient']);

        // end point
        $url = "$this->server/tregistrasi/getby/$no_registrasi";

        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);

        $output = '';
        $data =  $data['response_data'];
        if ($data == '') {
            $output .= '
                        <p style="line-height:107%;margin:0cm 0cm 8pt;text-align:center;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:14.0pt;"><span style="line-height:107%;" lang="IN" dir="ltr"><strong><u>SURAT KETERANGAN LAYAK TERBANG&nbsp;</u></strong></span><span style="line-height:107%;" lang="EN-GB" dir="ltr"><strong><u>IBU HAMIL&nbsp;</u></strong></span></span>
                        </p>
                        <p style="line-height:107%;margin:0cm 0cm 8pt;text-align:center;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:14.0pt;"><span style="line-height:107%;" lang="EN-GB" dir="ltr"><strong>&nbsp;&nbsp;/ SLTIH / MDC / 2024</strong></span></span>
                        </p>
                        <p style="line-height:107%;margin:0cm 0cm 8pt;text-align:center;">
                            &nbsp;
                        </p>
                        <p style="line-height:150%;margin:0cm 0cm 8pt;text-align:justify;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Yang bertanda tangan di bawah ini menerangkan bahwa :&nbsp;</span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 0cm 8pt 36.0pt;text-align:justify;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-US" dir="ltr">Nama&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : $fullname</span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 0cm 8pt 36.0pt;text-align:justify;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="IN" dir="ltr">Usia &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : $tahun</span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 0cm 8pt 36.0pt;text-align:justify;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-US" dir="ltr">Alamat &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : $addr</span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 0cm 8pt 36.0pt;text-align:justify;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-US" dir="ltr">Pekerjaan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : $pekerjaan</span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 0cm 8pt 36.0pt;text-align:justify;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-US" dir="ltr">Diagnosa &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : $diagnosa</span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 0cm 8pt 36.0pt;text-align:justify;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-US" dir="ltr">Usia Kehamilan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;</span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 0cm 8pt 36.0pt;text-align:justify;text-indent:36.0pt;">
                            &nbsp;
                        </p>
                        <p style="line-height:150%;margin:0cm 0cm 8pt 36.0pt;text-align:justify;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="IN" dir="ltr">Telah di</span><span style="line-height:150%;" lang="EN-GB" dir="ltr">lakukan </span><span style="line-height:150%;" lang="IN" dir="ltr">pe</span><span style="line-height:150%;" lang="EN-GB" dir="ltr">mer</span><span style="line-height:150%;" lang="IN" dir="ltr">iksa</span><span style="line-height:150%;" lang="EN-GB" dir="ltr">an</span><span style="line-height:150%;" lang="IN" dir="ltr"> dan dinyatakan dalam kondisi&nbsp;</span><span style="line-height:150%;" lang="EN-GB" dir="ltr"><strong>SEHAT dan LAYAK/ TIDAK LAYAK TERBANG&nbsp;</strong></span><span style="line-height:150%;" lang="IN" dir="ltr">dari&nbsp;</span><span style="line-height:150%;" lang="EN-US" dir="ltr">&nbsp;…..&nbsp;</span><span style="line-height:150%;" lang="IN" dir="ltr">&nbsp;menuju ke</span><span style="line-height:150%;" lang="EN-GB" dir="ltr"> …… .pada tanggal…………….&nbsp;</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 0cm 8pt 36.0pt;text-align:justify;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-GB" dir="ltr">Demikian surat keterangan ini kami buat, agar dapat dipergunakan sebagaimana mestinya.&nbsp;</span></span>
                        </p>
                        <p style="line-height:107%;margin:0cm 0cm 8pt 252.0pt;text-align:justify;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:107%;" lang="EN-US" dir="ltr">&nbsp; &nbsp; &nbsp; &nbsp;</span></span>
                        </p>
                        <p style="line-height:107%;margin:0cm 0cm 8pt 252.0pt;text-align:justify;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:107%;" lang="EN-US" dir="ltr">Surabaya,……………..2024</span></span>
                        </p>
                        <p style="line-height:107%;margin:0cm 0cm 8pt;text-align:justify;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:107%;" lang="EN-GB" dir="ltr">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;</span><span style="line-height:107%;" lang="IN" dir="ltr">Dokter yang memeriksa&nbsp;</span></span>
                        </p>
                        <p style="line-height:107%;margin:0cm 0cm 8pt 252.0pt;text-align:justify;text-indent:36.0pt;">
                            &nbsp;
                        </p>
                        <p style="line-height:107%;margin:0cm 0cm 8pt 252.0pt;text-align:justify;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:107%;" lang="EN-GB" dir="ltr">&nbsp;</span></span>
                        </p>
                        <p style="line-height:107%;margin:0cm 0cm 8pt 252.0pt;text-align:justify;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:107%;" lang="EN-GB" dir="ltr">………………………………...</span></span>
                        </p>
                        <p style="line-height:107%;margin:0cm 0cm 8pt;">
                            &nbsp;
                        </p>
                        <p style="line-height:107%;margin:0cm 0cm 8pt;">
                            &nbsp;
                        </p>
                        <p><br></p>';
        } else {
            $output .= '

                        <p style="line-height:107%;margin:0cm 0cm 8pt;text-align:center;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:14.0pt;"><span style="line-height:107%;" lang="IN" dir="ltr"><strong><u>SURAT KETERANGAN LAYAK TERBANG&nbsp;</u></strong></span><span style="line-height:107%;" lang="EN-GB" dir="ltr"><strong><u>IBU HAMIL&nbsp;</u></strong></span></span>
                        </p>
                        <p style="line-height:107%;margin:0cm 0cm 8pt;text-align:center;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:14.0pt;"><span style="line-height:107%;" lang="EN-GB" dir="ltr"><strong>&nbsp;&nbsp;/ SLTIH / MDC / 2024</strong></span></span>
                        </p>
                        <p style="line-height:107%;margin:0cm 0cm 8pt;text-align:center;">
                            &nbsp;
                        </p>
                        <p style="line-height:150%;margin:0cm 0cm 8pt;text-align:justify;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Yang bertanda tangan di bawah ini menerangkan bahwa :&nbsp;</span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 0cm 8pt 36.0pt;text-align:justify;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-US" dir="ltr">Nama&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : ' . $data[0]["fullname"] . '</span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 0cm 8pt 36.0pt;text-align:justify;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="IN" dir="ltr">Usia &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : ' . $data[0]["tahun"] . '</span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 0cm 8pt 36.0pt;text-align:justify;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-US" dir="ltr">Alamat &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : ' . $data[0]["addr"] . '</span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 0cm 8pt 36.0pt;text-align:justify;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-US" dir="ltr">Pekerjaan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : ' . $data[0]["pekerjaan"] . '</span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 0cm 8pt 36.0pt;text-align:justify;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-US" dir="ltr">Diagnosa &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : ' . $data[0]["diagnosa"] . '</span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 0cm 8pt 36.0pt;text-align:justify;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-US" dir="ltr">Usia Kehamilan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;</span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 0cm 8pt 36.0pt;text-align:justify;text-indent:36.0pt;">
                            &nbsp;
                        </p>
                        <p style="line-height:150%;margin:0cm 0cm 8pt 36.0pt;text-align:justify;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="IN" dir="ltr">Telah di</span><span style="line-height:150%;" lang="EN-GB" dir="ltr">lakukan </span><span style="line-height:150%;" lang="IN" dir="ltr">pe</span><span style="line-height:150%;" lang="EN-GB" dir="ltr">mer</span><span style="line-height:150%;" lang="IN" dir="ltr">iksa</span><span style="line-height:150%;" lang="EN-GB" dir="ltr">an</span><span style="line-height:150%;" lang="IN" dir="ltr"> dan dinyatakan dalam kondisi&nbsp;</span><span style="line-height:150%;" lang="EN-GB" dir="ltr"><strong>SEHAT dan LAYAK/ TIDAK LAYAK TERBANG&nbsp;</strong></span><span style="line-height:150%;" lang="IN" dir="ltr">dari&nbsp;</span><span style="line-height:150%;" lang="EN-US" dir="ltr">&nbsp;…..&nbsp;</span><span style="line-height:150%;" lang="IN" dir="ltr">&nbsp;menuju ke</span><span style="line-height:150%;" lang="EN-GB" dir="ltr"> …… .pada tanggal…………….&nbsp;</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 0cm 8pt 36.0pt;text-align:justify;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-GB" dir="ltr">Demikian surat keterangan ini kami buat, agar dapat dipergunakan sebagaimana mestinya.&nbsp;</span></span>
                        </p>
                        <p style="line-height:107%;margin:0cm 0cm 8pt 252.0pt;text-align:justify;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:107%;" lang="EN-US" dir="ltr">&nbsp; &nbsp; &nbsp; &nbsp;</span></span>
                        </p>
                        <br>
                        <br>
                        <br>
                        <br>
                        <table style="width:100%">
                        <tbody><tr>
                            <td style="width:20%"></td>
                            <td style="width:20%"></td>
                            <td style="width:20%"></td>
                            <td style="width:20%"><span style="font-family: &quot;Times New Roman&quot;, serif; font-size: 16px; text-align: right;">Surabaya,&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;2024</span><br></td>
                            <td style="width:20%"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><span style="font-family: &quot;Times New Roman&quot;, serif; font-size: 16px; text-align: right; text-indent: 48px;">Dokter yang memeriksa</span><br></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><br></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><br></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><br></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>....................................................</td>
                            <td></td>
                        </tr>
                        </tbody></table>
                        <p><br></p>';
        }
        echo $output;
        // } else {
        //     exit('Maaf tidak dapat diproses!');
        // }
    }

    public function suratKeteranganIstirahat()
    {
        // if ($this->request->isAJAX()) {

        $no_registrasi = $this->request->getVar('no_registrasi');

        // helper curl request
        helper(['restclient']);

        // end point
        $url = "$this->server/tregistrasi/getby/$no_registrasi";

        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);

        $output = '';
        $data =  $data['response_data'];
        if ($data == '') {
            $output .= '
                        <p style="line-height:107%;margin:0cm 0cm 8pt;">
                            &nbsp;
                        </p>
                        <p style="line-height:115%;margin:0cm 0cm 0cm 36.0pt;text-align:center;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:115%;"><strong><u><o:p><span style="text-decoration:none;"> </span></o:p></u></strong></span></span>
                        </p>
                        <p style="line-height:115%;margin:0cm 0cm 0cm 36.0pt;text-align:center;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:115%;"><strong><u><o:p><span style="text-decoration:none;"> </span></o:p></u></strong></span></span>
                        </p>
                        <p style="line-height:115%;margin:0cm 0cm 0cm 36.0pt;text-align:center;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:115%;" lang="EN-US" dir="ltr"><strong><u>SURAT KETERANGAN&nbsp;</u></strong></span><span style="line-height:115%;" lang="EN-GB" dir="ltr"><strong><u>ISTIRAHAT</u></strong></span></span>
                        </p>
                        <p style="line-height:115%;margin:0cm 0cm 0cm 36.0pt;text-align:center;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:115%;" lang="EN-GB" dir="ltr"><strong>&nbsp;</strong></span><span style="line-height:115%;" lang="IN" dir="ltr"><strong>/ SK</strong></span><span style="line-height:115%;" lang="EN-GB" dir="ltr"><strong>I</strong></span><span style="line-height:115%;" lang="IN" dir="ltr"><strong> / MDC</strong></span><span style="line-height:115%;" lang="EN-GB" dir="ltr"><strong> /&nbsp;</strong></span><span style="line-height:115%;" lang="IN" dir="ltr"><strong>20</strong></span><span style="line-height:115%;" lang="EN-GB" dir="ltr"><strong>24</strong></span></span>
                        </p>
                        <p style="line-height:115%;margin:0cm 0cm 0cm 36.0pt;text-align:justify;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:115%;" lang="IN" dir="ltr"><strong>&nbsp; &nbsp; &nbsp; &nbsp;</strong></span></span>
                        </p>
                        <p style="line-height:115%;margin:0cm 0cm 0cm 36.0pt;text-align:justify;">
                            &nbsp;
                        </p>
                        <p style="line-height:normal;margin:0cm 36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-US" dir="ltr">Yang bertanda tangan di bawah ini&nbsp;</span><span lang="IN" dir="ltr">menerangkan bahwa :&nbsp;</span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 36.0pt;">
                            &nbsp;
                        </p>
                        <p style="line-height:normal;margin:0cm 36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-US" dir="ltr">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nama&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : </span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 36.0pt;">
                            &nbsp;
                        </p>
                        <p style="line-height:normal;margin:0cm 36.0pt 0cm 72.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="IN" dir="ltr">Usia&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : </span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 36.0pt;">
                            &nbsp;
                        </p>
                        <p style="line-height:normal;margin:0cm 36.0pt 0cm 72.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-GB" dir="ltr">Jenis Kelamin&nbsp; </span><span lang="IN" dir="ltr">: </span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 36.0pt;">
                            &nbsp;
                        </p>
                        <p style="line-height:normal;margin:0cm 36.0pt 0cm 72.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-US" dir="ltr">Alamat&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : $addr</span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 36.0pt 0cm 72.0pt;">
                            &nbsp;
                        </p>
                        <p style="line-height:normal;margin:0cm 36.0pt 0cm 72.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="IN" dir="ltr">Pekerjaan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : $pekerjaan</span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 36.0pt 0cm 72.0pt;">
                            &nbsp;
                        </p>
                        <p style="line-height:normal;margin:0cm 36.0pt 0cm 72.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="IN" dir="ltr">Diagnosa&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span lang="EN-GB" dir="ltr">: $diagnosa</span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 36.0pt 0cm 72.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-GB" dir="ltr">&nbsp;</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 36.0pt;text-align:justify;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="IN" dir="ltr">Berdasarkan pemeriksaa</span><span style="line-height:150%;" lang="EN-US" dir="ltr">n medis yang kami lakukan ,&nbsp;</span><span style="line-height:150%;" lang="IN" dir="ltr">&nbsp;pasien tersebut diatas dalam keadaan&nbsp;</span><span style="line-height:150%;" lang="EN-GB" dir="ltr"><strong>SAKIT</strong></span><span style="line-height:150%;" lang="IN" dir="ltr">, sehingga perlu istirahat</span><span style="line-height:150%;" lang="EN-GB" dir="ltr"> / cuti&nbsp;</span><span style="line-height:150%;" lang="IN" dir="ltr">selama&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</span><span style="line-height:150%;" lang="EN-GB" dir="ltr">(</span><span style="line-height:150%;" lang="IN" dir="ltr">&nbsp; &nbsp;&nbsp; &nbsp;</span><span style="line-height:150%;" lang="EN-GB" dir="ltr">)&nbsp;</span><span style="line-height:150%;" lang="IN" dir="ltr">hari,&nbsp;</span><span style="line-height:150%;" lang="EN-GB" dir="ltr">terhitung sejak&nbsp;</span><span style="line-height:150%;" lang="IN" dir="ltr">tanggal&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</span><span style="line-height:150%;" lang="EN-GB" dir="ltr">s/d</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 36.0pt;text-align:justify;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="IN" dir="ltr">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 36.0pt;text-align:justify;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="IN" dir="ltr">Demikian surat keterangan ini diberikan untuk diketahui dan dipergunakan dengan semestinya.</span></span>
                        </p>
                        <br>
                        <br>
                        <br>
                        <br>
                        <table style="width:100%">
                        <tbody><tr>
                            <td style="width:20%"></td>
                            <td style="width:20%"></td>
                            <td style="width:20%"></td>
                            <td style="width:20%"><span style="font-family: &quot;Times New Roman&quot;, serif; font-size: 16px; text-align: right;">Surabaya,&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;2024</span><br></td>
                            <td style="width:20%"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><span style="font-family: &quot;Times New Roman&quot;, serif; font-size: 16px; text-align: right; text-indent: 48px;">Dokter yang merawat,</span><br></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><br></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><br></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><br></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>....................................................</td>
                            <td></td>
                        </tr>
                        </tbody></table>
                        <p><br></p>';
        } else {
            $output .= '

                        <p style="line-height:107%;margin:0cm 0cm 8pt;">
                            &nbsp;
                        </p>
                        <p style="line-height:115%;margin:0cm 0cm 0cm 36.0pt;text-align:center;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:115%;"><strong><u><o:p><span style="text-decoration:none;"> </span></o:p></u></strong></span></span>
                        </p>
                        <p style="line-height:115%;margin:0cm 0cm 0cm 36.0pt;text-align:center;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:115%;"><strong><u><o:p><span style="text-decoration:none;"> </span></o:p></u></strong></span></span>
                        </p>
                        <p style="line-height:115%;margin:0cm 0cm 0cm 36.0pt;text-align:center;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:115%;" lang="EN-US" dir="ltr"><strong><u>SURAT KETERANGAN&nbsp;</u></strong></span><span style="line-height:115%;" lang="EN-GB" dir="ltr"><strong><u>ISTIRAHAT</u></strong></span></span>
                        </p>
                        <p style="line-height:115%;margin:0cm 0cm 0cm 36.0pt;text-align:center;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:115%;" lang="EN-GB" dir="ltr"><strong>&nbsp;</strong></span><span style="line-height:115%;" lang="IN" dir="ltr"><strong>/ SK</strong></span><span style="line-height:115%;" lang="EN-GB" dir="ltr"><strong>I</strong></span><span style="line-height:115%;" lang="IN" dir="ltr"><strong> / MDC</strong></span><span style="line-height:115%;" lang="EN-GB" dir="ltr"><strong> /&nbsp;</strong></span><span style="line-height:115%;" lang="IN" dir="ltr"><strong>20</strong></span><span style="line-height:115%;" lang="EN-GB" dir="ltr"><strong>24</strong></span></span>
                        </p>
                        <p style="line-height:115%;margin:0cm 0cm 0cm 36.0pt;text-align:justify;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:115%;" lang="IN" dir="ltr"><strong>&nbsp; &nbsp; &nbsp; &nbsp;</strong></span></span>
                        </p>
                        <p style="line-height:115%;margin:0cm 0cm 0cm 36.0pt;text-align:justify;">
                            &nbsp;
                        </p>
                        <p style="line-height:normal;margin:0cm 36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-US" dir="ltr">Yang bertanda tangan di bawah ini&nbsp;</span><span lang="IN" dir="ltr">menerangkan bahwa :&nbsp;</span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 36.0pt;">
                            &nbsp;
                        </p>
                        <p style="line-height:normal;margin:0cm 36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-US" dir="ltr">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nama&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : ' . $data[0]["fullname"] . '</span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 36.0pt;">
                            &nbsp;
                        </p>
                        <p style="line-height:normal;margin:0cm 36.0pt 0cm 72.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="IN" dir="ltr">Usia&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : ' . $data[0]["tahun"] . '</span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 36.0pt;">
                            &nbsp;
                        </p>
                        <p style="line-height:normal;margin:0cm 36.0pt 0cm 72.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-GB" dir="ltr">Jenis Kelamin&nbsp; </span><span lang="IN" dir="ltr">: ' . ($data[0]["gender"] == 'M' ? 'Laki - laki' : 'Perempuan') . '</span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 36.0pt;">
                            &nbsp;
                        </p>
                        <p style="line-height:normal;margin:0cm 36.0pt 0cm 72.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-US" dir="ltr">Alamat&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : ' . $data[0]["addr"] . '</span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 36.0pt 0cm 72.0pt;">
                            &nbsp;
                        </p>
                        <p style="line-height:normal;margin:0cm 36.0pt 0cm 72.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="IN" dir="ltr">Pekerjaan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : ' . $data[0]["pekerjaan"] . '</span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 36.0pt 0cm 72.0pt;">
                            &nbsp;
                        </p>
                        <p style="line-height:normal;margin:0cm 36.0pt 0cm 72.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="IN" dir="ltr">Diagnosa&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span lang="EN-GB" dir="ltr">: ' . $data[0]["diagnosa"] . '</span></span>
                        </p>
                        <p style="line-height:normal;margin:0cm 36.0pt 0cm 72.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span lang="EN-GB" dir="ltr">&nbsp;</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 36.0pt;text-align:justify;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="IN" dir="ltr">Berdasarkan pemeriksaa</span><span style="line-height:150%;" lang="EN-US" dir="ltr">n medis yang kami lakukan ,&nbsp;</span><span style="line-height:150%;" lang="IN" dir="ltr">&nbsp;pasien tersebut diatas dalam keadaan&nbsp;</span><span style="line-height:150%;" lang="EN-GB" dir="ltr"><strong>SAKIT</strong></span><span style="line-height:150%;" lang="IN" dir="ltr">, sehingga perlu istirahat</span><span style="line-height:150%;" lang="EN-GB" dir="ltr"> / cuti&nbsp;</span><span style="line-height:150%;" lang="IN" dir="ltr">selama&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</span><span style="line-height:150%;" lang="EN-GB" dir="ltr">(</span><span style="line-height:150%;" lang="IN" dir="ltr">&nbsp; &nbsp;&nbsp; &nbsp;</span><span style="line-height:150%;" lang="EN-GB" dir="ltr">)&nbsp;</span><span style="line-height:150%;" lang="IN" dir="ltr">hari,&nbsp;</span><span style="line-height:150%;" lang="EN-GB" dir="ltr">terhitung sejak&nbsp;</span><span style="line-height:150%;" lang="IN" dir="ltr">tanggal&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</span><span style="line-height:150%;" lang="EN-GB" dir="ltr">s/d</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 36.0pt;text-align:justify;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="IN" dir="ltr">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 36.0pt;text-align:justify;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="IN" dir="ltr">Demikian surat keterangan ini diberikan untuk diketahui dan dipergunakan dengan semestinya.</span></span>
                        </p>
                        <br>
                        <br>
                        <br>
                        <br>
                        <table style="width:100%">
                        <tbody><tr>
                            <td style="width:20%"></td>
                            <td style="width:20%"></td>
                            <td style="width:20%"></td>
                            <td style="width:20%"><span style="font-family: &quot;Times New Roman&quot;, serif; font-size: 16px; text-align: right;">Surabaya,&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;2024</span><br></td>
                            <td style="width:20%"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><span style="font-family: &quot;Times New Roman&quot;, serif; font-size: 16px; text-align: right; text-indent: 48px;">Dokter yang merawat,</span><br></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><br></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><br></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><br></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>....................................................</td>
                            <td></td>
                        </tr>
                        </tbody></table>
                        <p><br></p>';
        }
        echo $output;
        // } else {
        //     exit('Maaf tidak dapat diproses!');
        // }
    }

    public function suratKeteranganDokter()
    {
        // if ($this->request->isAJAX()) {

        $no_registrasi = $this->request->getVar('no_registrasi');

        // helper curl request
        helper(['restclient']);

        // end point
        $url = "$this->server/tregistrasi/getby/$no_registrasi";

        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);

        $output = '';
        $data =  $data['response_data'];
        if ($data == '') {
            $output .= '
                        <p style="line-height:115%;margin:0cm;text-align:center;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:115%;"><strong><u><o:p><span style="text-decoration:none;"> </span></o:p></u></strong></span></span>
                        </p>
                        <p style="line-height:115%;margin:0cm;text-align:center;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:115%;"><strong><u><o:p><span style="text-decoration:none;"> </span></o:p></u></strong></span></span>
                        </p>
                        <p style="line-height:115%;margin:0cm;text-align:center;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:115%;"><strong><u><o:p><span style="text-decoration:none;"> </span></o:p></u></strong></span></span>
                        </p>
                        <p style="line-height:115%;margin:0cm;text-align:center;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:115%;" lang="EN-US" dir="ltr"><strong><u>SURAT KETERANGAN&nbsp; DOKTER&nbsp;</u></strong></span></span>
                        </p>
                        <p style="line-height:115%;margin:0cm;text-align:center;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:115%;" lang="IN" dir="ltr"><strong>/ SKD / MDC</strong></span><span style="line-height:115%;" lang="EN-GB" dir="ltr"><strong> /&nbsp;</strong></span><span style="line-height:115%;" lang="IN" dir="ltr"><strong>20</strong></span><span style="line-height:115%;" lang="EN-GB" dir="ltr"><strong>2</strong></span><span style="line-height:115%;" lang="IN" dir="ltr"><strong>4</strong></span></span>
                        </p>
                        <p style="line-height:115%;margin:0cm;text-align:justify;">
                            &nbsp;
                        </p>
                        <p style="line-height:115%;margin:0cm;text-align:justify;">
                            &nbsp;
                        </p>
                        <p style="line-height:150%;margin:0cm 0cm 0cm 36.0pt;text-align:justify;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Pasien yang tersebut dibawah ini :</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm;text-align:justify;">
                            &nbsp;
                        </p>
                        <p style="line-height:150%;margin:0cm 0cm 0cm 36.0pt;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Nama&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : $fullname</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 0cm 0cm 36.0pt;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="IN" dir="ltr">Tempat tanggal lahir</span><span style="line-height:150%;" lang="EN-US" dir="ltr">&nbsp;&nbsp; </span><span style="line-height:150%;" lang="IN" dir="ltr">: $tempat_lahir</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 0cm 0cm 36.0pt;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Jenis Kelamin &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :</span><span style="line-height:150%;" lang="IN" dir="ltr"> $gender</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 0cm 0cm 36.0pt;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Alamat &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp; $addr</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 0cm 0cm 72.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Diagnosa &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : $diagnosa</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 0cm 0cm 72.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="IN" dir="ltr">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 0cm 0cm 180.0pt;text-align:justify;text-indent:-108.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Keterangan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span style="line-height:150%;" lang="IN" dir="ltr">: </span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 0cm 0cm 36.0pt;text-align:justify;">
                            &nbsp;
                        </p>
                        <p style="line-height:150%;margin:0cm 0cm 0cm 36.0pt;tab-stops:70.9pt;text-align:justify;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Demikian surat keterangan ini kami buat, atas perhatiannya kami ucapkan terima kasih&nbsp;</span></span>
                        </p>
                        <br>
                        <br>
                        <br>
                        <br>
                        <table style="width:100%">
                        <tbody><tr>
                            <td style="width:20%"></td>
                            <td style="width:20%"></td>
                            <td style="width:20%"></td>
                            <td style="width:20%"><span style="font-family: &quot;Times New Roman&quot;, serif; font-size: 16px; text-align: right;">Surabaya,&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;2024</span><br></td>
                            <td style="width:20%"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><span style="font-family: &quot;Times New Roman&quot;, serif; font-size: 16px; text-align: right; text-indent: 48px;">Dokter yang merawat,</span><br></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><br></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><br></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><br></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>....................................................</td>
                            <td></td>
                        </tr>
                        </tbody></table>
                        <p><br></p>';
        } else {
            $output .= '

                        <p style="line-height:115%;margin:0cm;text-align:center;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:115%;"><strong><u><o:p><span style="text-decoration:none;"> </span></o:p></u></strong></span></span>
                        </p>
                        <p style="line-height:115%;margin:0cm;text-align:center;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:115%;"><strong><u><o:p><span style="text-decoration:none;"> </span></o:p></u></strong></span></span>
                        </p>
                        <p style="line-height:115%;margin:0cm;text-align:center;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:115%;"><strong><u><o:p><span style="text-decoration:none;"> </span></o:p></u></strong></span></span>
                        </p>
                        <p style="line-height:115%;margin:0cm;text-align:center;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:115%;" lang="EN-US" dir="ltr"><strong><u>SURAT KETERANGAN&nbsp; DOKTER&nbsp;</u></strong></span></span>
                        </p>
                        <p style="line-height:115%;margin:0cm;text-align:center;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:115%;" lang="IN" dir="ltr"><strong>/ SKD / MDC</strong></span><span style="line-height:115%;" lang="EN-GB" dir="ltr"><strong> /&nbsp;</strong></span><span style="line-height:115%;" lang="IN" dir="ltr"><strong>20</strong></span><span style="line-height:115%;" lang="EN-GB" dir="ltr"><strong>2</strong></span><span style="line-height:115%;" lang="IN" dir="ltr"><strong>4</strong></span></span>
                        </p>
                        <p style="line-height:115%;margin:0cm;text-align:justify;">
                            &nbsp;
                        </p>
                        <p style="line-height:115%;margin:0cm;text-align:justify;">
                            &nbsp;
                        </p>
                        <p style="line-height:150%;margin:0cm 0cm 0cm 36.0pt;text-align:justify;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Pasien yang tersebut dibawah ini :</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm;text-align:justify;">
                            &nbsp;
                        </p>
                        <p style="line-height:150%;margin:0cm 0cm 0cm 36.0pt;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Nama&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : ' . $data[0]["fullname"] . '</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 0cm 0cm 36.0pt;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="IN" dir="ltr">Tempat tanggal lahir</span><span style="line-height:150%;" lang="EN-US" dir="ltr">&nbsp;&nbsp; </span><span style="line-height:150%;" lang="IN" dir="ltr">: ' . $data[0]["birthplace"] . ', ' . date('d M Y', strtotime($data[0]["birth_dt"])) . '</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 0cm 0cm 36.0pt;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Jenis Kelamin &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :</span><span style="line-height:150%;" lang="IN" dir="ltr"> ' . ($data[0]["gender"] == 'M' ? 'Laki - laki' : 'Perempuan') . '</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 0cm 0cm 36.0pt;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Alamat &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp; ' . $data[0]["addr"] . '</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 0cm 0cm 72.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Diagnosa &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : ' . $data[0]["diagnosa"] . '</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 0cm 0cm 72.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="IN" dir="ltr">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 0cm 0cm 180.0pt;text-align:justify;text-indent:-108.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Keterangan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span style="line-height:150%;" lang="IN" dir="ltr">: </span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 0cm 0cm 36.0pt;text-align:justify;">
                            &nbsp;
                        </p>
                        <p style="line-height:150%;margin:0cm 0cm 0cm 36.0pt;tab-stops:70.9pt;text-align:justify;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Demikian surat keterangan ini kami buat, atas perhatiannya kami ucapkan terima kasih&nbsp;</span></span>
                        </p>
                        <br>
                        <br>
                        <br>
                        <br>
                        <table style="width:100%">
                        <tbody><tr>
                            <td style="width:20%"></td>
                            <td style="width:20%"></td>
                            <td style="width:20%"></td>
                            <td style="width:20%"><span style="font-family: &quot;Times New Roman&quot;, serif; font-size: 16px; text-align: right;">Surabaya,&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;2024</span><br></td>
                            <td style="width:20%"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><span style="font-family: &quot;Times New Roman&quot;, serif; font-size: 16px; text-align: right; text-indent: 48px;">Dokter yang merawat,</span><br></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><br></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><br></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><br></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>....................................................</td>
                            <td></td>
                        </tr>
                        </tbody></table>
                        <p><br></p>';
        }
        echo $output;
        // } else {
        //     exit('Maaf tidak dapat diproses!');
        // }
    }

    public function suratKeteranganSehat()
    {
        // if ($this->request->isAJAX()) {

        $no_registrasi = $this->request->getVar('no_registrasi');

        // helper curl request
        helper(['restclient']);

        // end point
        $url = "$this->server/tregistrasi/getby/$no_registrasi";

        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);

        $output = '';
        $data =  $data['response_data'];
        if ($data == '') {
            $output .= '
                        <p style="line-height:107%;margin:0cm 0cm 8pt 36.0pt;">
                            &nbsp;
                        </p>
                        <p style="line-height:107%;margin:0cm 0cm 8pt 36.0pt;">
                            &nbsp;
                        </p>
                        <p style="line-height:107%;margin:0cm 0cm 8pt;">
                            &nbsp;
                        </p>
                        <p style="line-height:115%;margin:0cm;text-align:center;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:115%;" lang="EN-US" dir="ltr"><strong><u>SURAT KETERANGAN SEHAT</u></strong></span></span>
                        </p>
                        <p style="line-height:115%;margin:0cm;text-align:center;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:115%;" lang="EN-US" dir="ltr"><strong>&nbsp; &nbsp; &nbsp;&nbsp;</strong></span><span style="line-height:115%;" lang="IN" dir="ltr"><strong> &nbsp;</strong></span><span style="line-height:115%;" lang="EN-US" dir="ltr"><strong>/ SKS / MDC / 2024</strong></span></span>
                        </p>
                        <p style="line-height:115%;margin:0cm;">
                            &nbsp;
                        </p>
                        <p style="line-height:150%;margin:0cm 36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Yang bertanda tangan di bawah ini, dokter MedicElle Clinic menerangkan dengan sesungguhnya bahwa :&nbsp;</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 36.0pt;">
                            &nbsp;
                        </p>
                        <p style="line-height:150%;margin:0cm 36.0pt;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Nama &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : </span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 36.0pt;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Alamat &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 36.0pt;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Jenis kelamin &nbsp;:&nbsp;</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 36.0pt;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Usia&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : </span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 36.0pt;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Pekerjaan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 36.0pt;tab-stops:42.55pt;text-align:justify;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Berdasarkan hasil pemeriksaan yang telah dilakukan :&nbsp;</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 36.0pt;tab-stops:70.9pt;text-align:justify;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TD :&nbsp;$tekanan_darah&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; N&nbsp; :</span><span style="line-height:150%;" lang="IN" dir="ltr">&nbsp;$n &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;</span><span style="line-height:150%;" lang="EN-US" dir="ltr">RR :&nbsp;$rr&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Suhu</span><span style="line-height:150%;" lang="IN" dir="ltr"> : $suhu&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</span><span style="line-height:150%;" lang="EN-US" dir="ltr">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 36.0pt;tab-stops:70.9pt;text-align:justify;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BB : $berat_badan &nbsp;&nbsp; </span><span style="line-height:150%;" lang="IN" dir="ltr">Kg</span><span style="line-height:150%;" lang="EN-US" dir="ltr">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TB:</span><span style="line-height:150%;" lang="IN" dir="ltr">&nbsp;$tinggi_badan &nbsp;C</span><span style="line-height:150%;" lang="EN-US" dir="ltr">m &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;Buta Warna :&nbsp;</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 36.0pt;tab-stops:70.9pt;text-align:justify;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pemeriksaan Mata &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;</span><span style="line-height:150%;" lang="IN" dir="ltr">Dalam Batas Normal</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 36.0pt;tab-stops:70.9pt;text-align:justify;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pemeriksaan Telinga&nbsp;&nbsp; :</span><span style="line-height:150%;" lang="IN" dir="ltr"> Dalam Batas Normal&nbsp;&nbsp;</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 36.0pt;tab-stops:70.9pt;">
                            &nbsp;
                        </p>
                        <p style="line-height:150%;margin:0cm 36.0pt;tab-stops:70.9pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Benar telah diperiksa dengan teliti dan dinyatakan dalam keadaan&nbsp;</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 36.0pt;tab-stops:70.9pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="IN" dir="ltr"><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</strong></span><span style="line-height:150%;" lang="EN-US" dir="ltr"><strong>SEHAT </strong></span><span style="line-height:150%;" lang="IN" dir="ltr"><strong>/TIDAK SEHAT&nbsp;</strong></span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 36.0pt;tab-stops:70.9pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Surat Keterangan sehat ini dipergunakan untuk Perpanjangan&nbsp;</span><span style="line-height:150%;" lang="IN" dir="ltr">SIP</span></span>
                        </p>
                        <br>
                        <br>
                        <br>
                        <br>
                        <table style="width:100%">
                        <tbody><tr>
                            <td style="width:20%"></td>
                            <td style="width:20%"></td>
                            <td style="width:20%"></td>
                            <td style="width:20%"><span style="font-family: &quot;Times New Roman&quot;, serif; font-size: 16px; text-align: right;">Surabaya,&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;2024</span><br></td>
                            <td style="width:20%"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><span style="font-family: &quot;Times New Roman&quot;, serif; font-size: 16px; text-align: right; text-indent: 48px;">Dokter yang merawat,</span><br></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><br></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><br></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><br></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>....................................................</td>
                            <td></td>
                        </tr>
                        </tbody></table>
                        <p><br></p>';
        } else {
            $output .= '

                        <p style="line-height:107%;margin:0cm 0cm 8pt 36.0pt;">
                            &nbsp;
                        </p>
                        <p style="line-height:107%;margin:0cm 0cm 8pt 36.0pt;">
                            &nbsp;
                        </p>
                        <p style="line-height:107%;margin:0cm 0cm 8pt;">
                            &nbsp;
                        </p>
                        <p style="line-height:115%;margin:0cm;text-align:center;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:115%;" lang="EN-US" dir="ltr"><strong><u>SURAT KETERANGAN SEHAT</u></strong></span></span>
                        </p>
                        <p style="line-height:115%;margin:0cm;text-align:center;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:115%;" lang="EN-US" dir="ltr"><strong>&nbsp; &nbsp; &nbsp;&nbsp;</strong></span><span style="line-height:115%;" lang="IN" dir="ltr"><strong> &nbsp;</strong></span><span style="line-height:115%;" lang="EN-US" dir="ltr"><strong>/ SKS / MDC / 2024</strong></span></span>
                        </p>
                        <p style="line-height:115%;margin:0cm;">
                            &nbsp;
                        </p>
                        <p style="line-height:150%;margin:0cm 36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Yang bertanda tangan di bawah ini, dokter MedicElle Clinic menerangkan dengan sesungguhnya bahwa :&nbsp;</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 36.0pt;">
                            &nbsp;
                        </p>
                        <p style="line-height:150%;margin:0cm 36.0pt;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Nama &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : ' . $data[0]["fullname"] . '</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 36.0pt;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Alamat &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;' . $data[0]["addr"] . '</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 36.0pt;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Jenis kelamin &nbsp;:&nbsp;' . ($data[0]["gender"] == 'M' ? 'Laki - laki' : 'Perempuan') . '</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 36.0pt;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Usia&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : ' . $data[0]["tahun"] . '</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 36.0pt;text-indent:36.0pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Pekerjaan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;' . $data[0]["pekerjaan"] . '</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 36.0pt;tab-stops:42.55pt;text-align:justify;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Berdasarkan hasil pemeriksaan yang telah dilakukan :&nbsp;</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 36.0pt;tab-stops:70.9pt;text-align:justify;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TD :&nbsp;' . $data[0]["diastolik"] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; N&nbsp; :</span><span style="line-height:150%;" lang="IN" dir="ltr">&nbsp;' . $data[0]["denyut_nadi"] . ' &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;</span><span style="line-height:150%;" lang="EN-US" dir="ltr">RR :&nbsp;$rr&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Suhu</span><span style="line-height:150%;" lang="IN" dir="ltr"> : ' . $data[0]["suhu"] . '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</span><span style="line-height:150%;" lang="EN-US" dir="ltr">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 36.0pt;tab-stops:70.9pt;text-align:justify;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BB : ' . $data[0]["berat_badan"] . ' &nbsp;&nbsp; </span><span style="line-height:150%;" lang="IN" dir="ltr">Kg</span><span style="line-height:150%;" lang="EN-US" dir="ltr">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TB:</span><span style="line-height:150%;" lang="IN" dir="ltr">&nbsp;' . $data[0]["tinggi_badan"] . ' &nbsp;C</span><span style="line-height:150%;" lang="EN-US" dir="ltr">m &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;Buta Warna :&nbsp;</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 36.0pt;tab-stops:70.9pt;text-align:justify;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pemeriksaan Mata &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;</span><span style="line-height:150%;" lang="IN" dir="ltr">Dalam Batas Normal</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 36.0pt;tab-stops:70.9pt;text-align:justify;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pemeriksaan Telinga&nbsp;&nbsp; :</span><span style="line-height:150%;" lang="IN" dir="ltr"> Dalam Batas Normal&nbsp;&nbsp;</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 36.0pt;tab-stops:70.9pt;">
                            &nbsp;
                        </p>
                        <p style="line-height:150%;margin:0cm 36.0pt;tab-stops:70.9pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Benar telah diperiksa dengan teliti dan dinyatakan dalam keadaan&nbsp;</span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 36.0pt;tab-stops:70.9pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="IN" dir="ltr"><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</strong></span><span style="line-height:150%;" lang="EN-US" dir="ltr"><strong>SEHAT </strong></span><span style="line-height:150%;" lang="IN" dir="ltr"><strong>/TIDAK SEHAT&nbsp;</strong></span></span>
                        </p>
                        <p style="line-height:150%;margin:0cm 36.0pt;tab-stops:70.9pt;">
                            <span style="font-family:&quot;Times New Roman&quot;,serif;font-size:12.0pt;"><span style="line-height:150%;" lang="EN-US" dir="ltr">Surat Keterangan sehat ini dipergunakan untuk Perpanjangan&nbsp;</span><span style="line-height:150%;" lang="IN" dir="ltr">SIP</span></span>
                        </p>
                        <br>
                        <br>
                        <br>
                        <br>
                        <table style="width:100%">
                        <tbody><tr>
                            <td style="width:20%"></td>
                            <td style="width:20%"></td>
                            <td style="width:20%"></td>
                            <td style="width:20%"><span style="font-family: &quot;Times New Roman&quot;, serif; font-size: 16px; text-align: right;">Surabaya,&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;2024</span><br></td>
                            <td style="width:20%"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><span style="font-family: &quot;Times New Roman&quot;, serif; font-size: 16px; text-align: right; text-indent: 48px;">Dokter yang merawat,</span><br></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><br></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><br></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><br></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>....................................................</td>
                            <td></td>
                        </tr>
                        </tbody></table>
                        <p><br></p>';
        }
        echo $output;
        // } else {
        //     exit('Maaf tidak dapat diproses!');
        // }
    }

    public function headerRujukan()
    {
        // if ($this->request->isAJAX()) {

        $no_registrasi = $this->request->getVar('no_registrasi');

        // helper curl request
        helper(['restclient']);

        // end point
        $url = "$this->server/tregistrasi/getby/$no_registrasi";

        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);

        $output = '';
        $data =  $data['response_data'];
        if ($data == '') {
            $output .= '
                        <table class="table table-responsive" style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td colspan="5">
                                        <h2 style="text-align: center;"><b>RESUME MEDIS</b></h2>
                                    </td>
                                </tr>
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
                                    <td><b><br></b></td>
                                    <td><b><br></b></td>
                                    <td>&nbsp;</td>
                                    <td><b><br></b></td>
                                    <td><b><br></b></td>
                                </tr>
                                <tr>
                                    <td><b>Tgl. Kunjungan :</b></td>
                                    <td style="text-align: right;"><b><br></b></td>
                                    <td>&nbsp;</td>
                                    <td><b>Tanggal&nbsp;Dibuat :</b></td>
                                    <td style="text-align: right;"><b>27 Jul 2024 16:43</b></td>
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
                                    <td style="text-align: right;"><b>dr. Amira Cholid Bawazeer<br></b></td>
                                </tr>
                                <tr>
                                    <td><b>Spesialisasi :</b></td>
                                    <td style="text-align: right;"><b>N / A</b></td>
                                    <td>&nbsp;</td>
                                    <td><b>Dicetak Pada :</b></td>
                                    <td style="text-align: right;"><b>27 Jul 2024 16:43</b><br></td>
                                </tr>
                            </tbody>
                        </table>
                        <p><br></p>';
        } else {
            $output .= '
                        <table class="table table-responsive" style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td colspan="5">
                                        <h2 style="text-align: center;"><b>RESUME MEDIS</b></h2>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Nama Pasien :</b></td>
                                    <td style="text-align: right;"><b>' . $data[0]["fullname"] . '</b></td>
                                    <td>&nbsp;</td>
                                    <td><b>No. RM :</b></td>
                                    <td style="text-align: right;"><b>' . $data[0]["no_pasien"] . '</b></td>
                                </tr>
                                <tr>
                                    <td><b>Umur :</b></td>
                                    <td style="text-align: right;"><b>' . $data[0]["tahun"] . ' years</b></td>
                                    <td>&nbsp;</td>
                                    <td><b>Tanggal Lahir :</b></td>
                                    <td style="text-align: right;"><b>' . date('d M Y', strtotime($data[0]["birth_dt"])) . '</b></td>
                                </tr>
                                <tr>
                                    <td><b>Jenis Kelamin :</b></td>
                                    <td style="text-align: right;"><b>' . ($data[0]["gender"] == 'M' ? 'Laki - laki' : 'Perempuan') . '</b></td>
                                    <td>&nbsp;</td>
                                    <td><b><br></b></td>
                                    <td style="text-align: right;"><b><br></b></td>
                                </tr>
                                <tr>
                                    <td><b><br></b></td>
                                    <td><b><br></b></td>
                                    <td>&nbsp;</td>
                                    <td><b><br></b></td>
                                    <td><b><br></b></td>
                                </tr>
                                <tr>
                                    <td><b>Tgl. Kunjungan :</b></td>
                                    <td style="text-align: right;"><b>' .  date('d M Y H:i', strtotime($data[0]["tgl_praktek"])) . '</b></td>
                                    <td>&nbsp;</td>
                                    <td><b>Tanggal&nbsp;Dibuat :</b></td>
                                    <td style="text-align: right;"><b>' . date("d M Y H:i") . '</b></td>
                                </tr>
                                <tr>
                                    <td><b>Tipe Kunjungan :</b></td>
                                    <td style="text-align: right;"><b>' . $data[0]["tujuan_registrasi_desc"] . '</b></td>
                                    <td>&nbsp;</td>
                                    <td><b>Status :</b></td>
                                    <td style="text-align: right;"><b>' . $data[0]["tujuan_registrasi_desc"] . '</b></td>
                                </tr>
                                <tr>
                                    <td><b>Nama Dokter :</b></td>
                                    <td style="text-align: right;"><b>' . $data[0]["nama_dokter"] . '</b></td>
                                    <td>&nbsp;</td>
                                    <td><b>Dicetak Oleh :</b></td>
                                    <td style="text-align: right;"><b>' . $data[0]["nama_dokter"] . '</b></td>
                                </tr>
                                <tr>
                                    <td><b>Spesialisasi :</b></td>
                                    <td style="text-align: right;"><b>N / A</b></td>
                                    <td>&nbsp;</td>
                                    <td><b>Dicetak Pada :</b></td>
                                    <td style="text-align: right;"><b>' . date("d M Y H:i") . '</b><br></td>
                                </tr>
                            </tbody>
                        </table>
                        <p><br></p>';
        }
        echo $output;
        // } else {
        //     exit('Maaf tidak dapat diproses!');
        // }
    }

    public function apiDataGetAnamnesa()
    {
        $no_registrasi = $this->request->getVar('no_registrasi');

        // helper curl request
        helper(['restclient']);

        // endpoint
        // $url = "$this->server/tregistrasianamnesa/getby/REG240700227";
        $url = "$this->server/tregistrasianamnesa/getby/$no_registrasi";

        // client request
        $response = akses_restapi('GET', $url, []);

        // $data['response_data'] = json_decode($response, true);
        // return $data['response_data'];

        return $response;
    }

    public function apiDataGetPeriksa()
    {
        $no_registrasi = $this->request->getVar('no_registrasi');

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/tregistrasiperiksa/getby/$no_registrasi";

        // client request
        $response = akses_restapi('GET', $url, []);

        // $data['response_data'] = json_decode($response, true);
        // return $data['response_data'];

        return $response;
    }

    public function apiDataGetDiagnosa()
    {
        $no_registrasi = $this->request->getVar('no_registrasi');

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/tregistrasidiagnosa/getby/$no_registrasi";

        // client request
        $response = akses_restapi('GET', $url, []);

        // $data['response_data'] = json_decode($response, true);
        // return $data['response_data'];

        return $response;
    }

    public function apiDataGetRujukan()
    {
        $no_registrasi = $this->request->getVar('no_registrasi');

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/tregistrasirujukan/getby/$no_registrasi";

        // client request
        $response = akses_restapi('GET', $url, []);

        return $response;
    }

    public function apiDataGetAllAnamnesaByPasien($patient_no)
    {
        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/listparameter/anamnesabyno_pasien/$patient_no";

        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);

        return $data['response_data'];
    }

    public function apiDataGetAllRiwayatByPasien($patient_no)
    {
        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/listparameter/riwayatbyno_pasien/$patient_no";

        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);

        return $data['response_data'];
    }

    public function apiDataGetAll()
    {
        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/tregistrasi/getalldpdthadir";

        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);

        return $data['response_data'];
    }

    public function apiDataGetByNoRegistrasi()
    {
        $no_registrasi = $this->request->getVar('no_registrasi');

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/ttitikkeluhan/getby/$no_registrasi";

        // client request
        $response = akses_restapi('GET', $url, []);

        // $data['response_data'] = json_decode($response, true);
        // return $data['response_data'];

        return $response;
    }

    public function apiDataRegistrasiGetByNoRegistrasi()
    {
        $no_registrasi = $this->session->get('no_registrasi');
        // $emp_cd = 'E0003';

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/tregistrasi/getby/$no_registrasi";

        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);

        return $data['response_data'];
    }

    public function apiDataGetByDokter()
    {
        $emp_cd = $this->session->get('emp_cd');
        // $emp_cd = 'E0003';

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/tregistrasi/getbydokter/$emp_cd";

        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);

        return $data['response_data'];
    }

    public function apiDataGetAllRiwayat($patient_no)
    {
        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/tmedicalrecord/getbypasien/$patient_no";

        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);

        return $data['response_data'];
    }


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

    public function apiDataGetAlergiByPasien()
    {
        // $emp_cd = $this->session->get('emp_cd');
        $patient_no = $this->request->getVar('patient_no');
        // $patient_no = "24040023";

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/tpatientalergi/getby/$patient_no";

        // client request
        $response = akses_restapi('GET', $url, []);
        // $data['response_data'] = json_decode($response, true);

        return $response;
    }

    public function apiDataGetDiagnosaTambahanByRegistrasi()
    {
        // $emp_cd = $this->session->get('emp_cd');
        $no_registrasi = $this->request->getVar('no_registrasi');
        // $patient_no = "24040023";

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/tregistrasidiagnosatambahan/getby/$no_registrasi";

        // client request
        $response = akses_restapi('GET', $url, []);
        // $data['response_data'] = json_decode($response, true);

        return $response;
    }

    public function apiDataGetAnamnesaByPasien()
    {
        // $emp_cd = $this->session->get('emp_cd');
        $patient_no = $this->request->getVar('patient_no');
        // $patient_no = "24040023";

        // helper curl request
        helper(['restclient']);

        // endpoint
        $url = "$this->server/tpatientalergi/getby/$patient_no";

        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);

        return $data['response_data'];
    }

    public function fetchAllAlergi()
    {
        // if ($this->request->isAJAX()) {

        $output = '';
        $data =  $this->apiDataGetAlergiByPasien();

        if ($data == '') {
            $output .= '';
        } else {
            for ($a = 1; $a < count($data); $a++) {

                $output .= '
                            <tr id="row' . $a . '">
                                <td>
                                    <select class="custom-select" name="kategori_alergi[]" id="kategori_alergi' . $a . '">
                                        <option value=" " selected="selected">-- Select --</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="custom-select" name="komponen_alergi[]" id="komponen_alergi' . $a . '">
                                        <option value=" " selected="selected">-- Select --</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="custom-select" name="reaksi_alergi[]" id="reaksi_alergi' . $a . '">
                                        <option value=" " selected="selected">-- Select --</option>
                                    </select>
                                    <input type="hidden" name="alergi_no" value="' . $data[$a]["alergi_no"] . '_' . $a . '">
                                </td>
                                <td>
                                    <button type="button" name="remove" id="' . $a . '" class="btn btn-danger btn_remove_alergi">X</button>
                                </td>
                            </tr>
                            <script type="text/javascript">
                            $(document).ready(function() {
                                $("#kategori_alergi' . $a . '", "#dynamic_alergi").select2({
                                    ajax: {
                                        url: "' . site_url('konsultasidokter/ajaxKategoriAlergi/kategori_alergi') . '",
                                        dataType: "json",
                                        data: function(params) {
                                            var query = {
                                                search: params.term
                                            }

                                            // Query parameters will be ?search=[term]&type=user_search
                                            return query;
                                        },
                                        processResults: function(data) {
                                            return {
                                                results: data
                                            };
                                        }
                                    },
                                    cache: true,
                                    placeholder: "Search ...",
                                    minimumInputLength: 0,
                                    width: "auto",
                                    // templateResult: formatResult2 //your selection format
                                });

                                $("#komponen_alergi' . $a . '", "#dynamic_alergi").select2({
                                    ajax: {
                                        url: "' . site_url('konsultasidokter/ajaxKategoriAlergi/komponen_alergi') . '",
                                        dataType: "json",
                                        data: function(params) {
                                            var query = {
                                                search: params.term
                                            }

                                            // Query parameters will be ?search=[term]&type=user_search
                                            return query;
                                        },
                                        processResults: function(data) {
                                            return {
                                                results: data
                                            };
                                        }
                                    },
                                    cache: true,
                                    placeholder: "Search ...",
                                    minimumInputLength: 0,
                                    width: "auto",
                                    // templateResult: formatResult2 //your selection format
                                });

                                $("#reaksi_alergi' . $a . '", "#dynamic_alergi").select2({
                                    ajax: {
                                        url: "' . site_url('konsultasidokter/ajaxKategoriAlergi/reaksi_alergi') . '",
                                        dataType: "json",
                                        data: function(params) {
                                            var query = {
                                                search: params.term
                                            }

                                            // Query parameters will be ?search=[term]&type=user_search
                                            return query;
                                        },
                                        processResults: function(data) {
                                            return {
                                                results: data
                                            };
                                        }
                                    },
                                    cache: true,
                                    placeholder: "Search ...",
                                    minimumInputLength: 0,
                                    width: "auto",
                                    // templateResult: formatResult2 //your selection format
                                });
                            });
                            </script>
                    ';
            }
        }

        echo $output;
        // } else {
        //     exit('Maaf tidak dapat diproses!');
        // }
    }

    public function fetchAllAlergi_x()
    {
        // if ($this->request->isAJAX()) {

        $output = '';
        $data =  $this->apiDataGetAlergiByPasien();
        $output .= '  
                    <table id="example2" class="table table-sm table-striped" style="border-spacing: 0;">
                    <thead>
                            <tr>
                                <th>No</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                            ';
        if ($data == '') {
            $output .= '<tr>  
                                <td >Data not Found</td>
                                <td ></td>
                                <th></th>
                            </tr>';
        } else {
            for ($a = 0; $a < count($data); $a++) {

                $output .= '  
                            <tr id="addMdlBarang" data-id="' . $data[$a]["patient_no"] . '">
                                <td >' . $data[$a]["alergi_no"] . '</td>
                                <td >' . $data[$a]["verifikasi"] . '</td>
                                <td>
                                    <button data-widget="control-sidebar" data-slide="true" type="button" class="btn btn-info btn-sm float-right mr-1 mt-1 pilihpasien pasien btn-fix-w" data-alergi_no="' . $data[$a]["alergi_no"] . '" data-patient_no="' . $data[$a]["patient_no"] . '">
                                        Pilih
                                    </button>
                                </td>
                            </tr>  
                    ';
            }
        }
        $output .= '</table>
            <script type="text/javascript">
            $(function() {
                $("#example2").DataTable({
                    columnDefs: [{
                        orderable: false,
                        targets: 2
                    }],
                    // "dom": "Bfplit",
                    // "buttons": [
                    //     "copy", "csv", "excel", "pdf", "print"
                    // ],
                    "paging": false,
                    "lengthChange": true,
                    "searching": false,
                    "info": false,
                    "autoWidth": false
                });
            });
            </script>
            ';
        echo $output;
        // } else {
        //     exit('Maaf tidak dapat diproses!');
        // }
    }

    public function fetchAllAnamnesa()
    {
        // if ($this->request->isAJAX()) {

        $output = '';
        $data =  $this->apiDataGetAlergiByPasien();
        $output .= '  
                    <table id="example2" class="table table-sm table-striped" style="border-spacing: 0;">
                    <thead>
                            <tr>
                                <th>No</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                            ';
        if ($data == '') {
            $output .= '<tr>  
                                <td >Data not Found</td>
                                <td ></td>
                                <th></th>
                            </tr>';
        } else {
            for ($a = 0; $a < count($data); $a++) {

                $output .= '  
                            <tr id="addMdlBarang" data-id="' . $data[$a]["patient_no"] . '">
                                <td >' . $data[$a]["alergi_no"] . '</td>
                                <td >' . $data[$a]["verifikasi"] . '</td>
                                <td>
                                    <button data-widget="control-sidebar" data-slide="true" type="button" class="btn btn-info btn-sm float-right mr-1 mt-1 pilihpasien pasien btn-fix-w" data-alergi_no="' . $data[$a]["alergi_no"] . '" data-patient_no="' . $data[$a]["patient_no"] . '">
                                        Pilih
                                    </button>
                                </td>
                            </tr>  
                    ';
            }
        }
        $output .= '</table>
            <script type="text/javascript">
            $(function() {
                $("#example2").DataTable({
                    columnDefs: [{
                        orderable: false,
                        targets: 2
                    }],
                    // "dom": "Bfplit",
                    // "buttons": [
                    //     "copy", "csv", "excel", "pdf", "print"
                    // ],
                    "paging": false,
                    "lengthChange": true,
                    "searching": false,
                    "info": false,
                    "autoWidth": false
                });
            });
            </script>
            ';
        echo $output;
        // } else {
        //     exit('Maaf tidak dapat diproses!');
        // }
    }


    public function fetchAll()
    {
        // if ($this->request->isAJAX()) {

        $output = '';
        $data =  $this->apiDataGetByDokter();
        $output .= '  
                    <table id="example1" class="table table-sm table-striped" style="border-spacing: 0;">
                    <thead>
                            <tr>
                                <th>Pasien</th>
                                <th>Hadir</th>
                                <th></th>
                            </tr>
                        </thead>
                            ';
        if ($data == '') {
            $output .= '<tr>  
                                <td >Data not Found</td>
                                <td ></td>
                                <th></th>
                            </tr>';
        } else {
            for ($a = 0; $a < count($data); $a++) {

                $output .= '  
                            <tr id="addMdlBarang" data-id="' . $data[$a]["no_registrasi"] . '">
                                <td >' . $data[$a]["fullname"] . '</td>
                                <td >' . $data[$a]["hadir"] . '</td>
                                <td>
                                    <button data-widget="control-sidebar" data-slide="true" type="button" class="btn ' . ($data[$a]["status"] === "DT" ? "btn-warning" : "btn-info") . ' btn-sm float-right mr-1 mt-1 pilihpasien pasien btn-fix-w" data-no_registrasi="' . $data[$a]["no_registrasi"] . '" data-patient_no="' . $data[$a]["no_pasien"] . '" data-kode_dokter="' . $data[$a]["dokter"] . '" data-fullname="' . $data[$a]["fullname"] . '" data-tahun="' . $data[$a]["tahun"] . '" data-bulan="' . $data[$a]["bulan"] . '" data-hari="' . $data[$a]["hari"] . '" data-gender="' . $data[$a]["gender_desc"] . '" data-birth_dt="' . $data[$a]["birth_dt"] . '" data-mobile_no="' . $data[$a]["mobile_no"] . '" data-jam_mulai="' . $data[$a]["jam_mulai"] . '" data-jam_selesai="' . $data[$a]["jam_selesai"] . '" data-tujuan_registrasi="' . $data[$a]["tujuan_registrasi"] . '" data-tujuan_registrasi_desc="' . $data[$a]["tujuan_registrasi_desc"] . '" data-type_pasien="' . $data[$a]["type_pasien"] . '" data-nama_dokter="' . $data[$a]["nama_dokter"] . '" data-no_kwitansi="' . $data[$a]["no_kwitansi"] . '" data-flag_alergi="' . $data[$a]["flag_alergi"] . '" data-status="' . $data[$a]["status"] . '"
                                    data-keluhan_utama="' . $data[$a]["keluhan_utama"] . '"
                                    data-responden="' . $data[$a]["responden"] . '"
                                    data-riwayat_lain="' . $data[$a]["riwayat_lain"] . '"
                                    data-riwayat_operasi_pengobatan="' . $data[$a]["riwayat_operasi_pengobatan"] . '"
                                    data-riwayat_penyakit_dahulu="' . $data[$a]["riwayat_penyakit_dahulu"] . '"
                                    data-riwayat_penyakit_keluarga="' . $data[$a]["riwayat_penyakit_keluarga"] . '"
                                    data-riwayat_penyakit_sekarang="' . $data[$a]["riwayat_penyakit_sekarang"] . '"
                                    data-riwayat_perjalanan_keluhan="' . $data[$a]["riwayat_perjalanan_keluhan"] . '"
                                    data-berat_badan="' . $data[$a]["berat_badan"] . '"
                                    data-bmi="' . $data[$a]["bmi"] . '"
                                    data-denyut_nadi="' . $data[$a]["denyut_nadi"] . '"
                                    data-diastolik="' . $data[$a]["diastolik"] . '"
                                    data-kondisi_khusus="' . $data[$a]["kondisi_khusus"] . '"
                                    data-kondisi_umum="' . $data[$a]["kondisi_umum"] . '"
                                    data-laju_nafas="' . $data[$a]["laju_nafas"] . '"
                                    data-pemeriksaan_tambahan="' . $data[$a]["pemeriksaan_tambahan"] . '"
                                    data-sistolik="' . $data[$a]["sistolik"] . '"
                                    data-suhu="' . $data[$a]["suhu"] . '"
                                    data-tinggi_badan="' . $data[$a]["tinggi_badan"] . '"
                                    data-diagnosa_sekunder="' . $data[$a]["diagnosa_sekunder"] . '"
                                    data-diagnosa_sekunder_sta="' . $data[$a]["diagnosa_sekunder_sta"] . '"
                                    data-diagnosa_utama="' . $data[$a]["diagnosa_utama"] . '"
                                    data-diagnosa_utama_sta="' . $data[$a]["diagnosa_utama_sta"] . '"
                                    data-icd10_sekunder="' . $data[$a]["icd10_sekunder"] . '"
                                    data-icd10_utama="' . $data[$a]["icd10_utama"] . '"
                                    data-klasifikasi_sekunder="' . $data[$a]["klasifikasi_sekunder"] . '"
                                    data-klasifikasi_utama="' . $data[$a]["klasifikasi_utama"] . '"
                                    data-laboratorium="' . $data[$a]["laboratorium"] . '"
                                    data-prosedur_primer="' . $data[$a]["prosedur_primer"] . '"
                                    data-prosedur_skunder="' . $data[$a]["prosedur_skunder"] . '"
                                    data-radiologi="' . $data[$a]["radiologi"] . '"
                                    data-reduksi="' . $data[$a]["reduksi"] . '"
                                    data-resep="' . $data[$a]["resep"] . '"
                                    data-tatalaksana="' . $data[$a]["tatalaksana"] . '"
                                    data-dokter_rujukan="' . $data[$a]["dokter_rujukan"] . '"
                                    data-ket_rujukan="' . $data[$a]["ket_rujukan"] . '"
                                    data-rujukan="' . $data[$a]["ket_rujukan"] . '"
                                    data-user_rujukan="' . $data[$a]["user_rujukan"] . '"
                                    >
                                        Pilih
                                    </button>
                                </td>
                            </tr>  
                    ';
            }
        }
        $output .= '</table>
            <script type="text/javascript">
            $(function() {
                $("#example1").DataTable({
                    columnDefs: [{
                        orderable: false,
                        targets: 2
                    }],
                    // "dom": "Bfplit",
                    // "buttons": [
                    //     "copy", "csv", "excel", "pdf", "print"
                    // ],
                    "paging": false,
                    "lengthChange": true,
                    "searching": false,
                    "info": false,
                    "autoWidth": false
                });
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
        if ($this->request->isAJAX()) {

            $patient_no = $this->request->getVar('patient_no');

            $output = '';
            $data =  $this->apiDataGetAllAnamnesaByPasien($patient_no);

            if ($data == '') {
                $output .= '';
            } else {
                for ($a = 0; $a < count($data); $a++) {

                    $output .= '
                        <div class="card dudu" data-keluhan_utama="' . $data[$a]["keluhan_utama"] . '" data-riwayat_perjalanan_keluhan="' . $data[$a]["riwayat_perjalanan_keluhan"] . '" data-riwayat_penyakit_sekarang="' . $data[$a]["riwayat_penyakit_sekarang"] . '" data-riwayat_operasi_pengobatan="' . $data[$a]["riwayat_operasi_pengobatan"] . '" data-riwayat_penyakit_keluarga="' . $data[$a]["riwayat_penyakit_keluarga"] . '" data-riwayat_lain="' . $data[$a]["riwayat_lain"] . '" data-riwayat_penyakit_dahulu="' . $data[$a]["riwayat_penyakit_dahulu"] . '">
                            <div class="card-body">
                                <p>Anamnesa – ' . date('d/m/Y', strtotime($data[$a]["tgl_registrasi"])) . '</p>
                                <p>Keluhan : </p>
                                <p>[Isi informasi Keluhan]</p>
                            </div>
                        </div>
                        ';
                }
            }
            echo $output;
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    // public function fetchAllRiwayatCardByPasien()
    // {
    //     // if ($this->request->isAJAX()) {

    //     $patient_no = $this->request->getVar('patient_no');

    //     $output = '';
    //     $data =  $this->apiDataGetAllRiwayatByPasien($patient_no);

    //     if ($data == '') {
    //         $output .= '';
    //     } else {
    //         for ($a = 0; $a < count($data); $a++) {

    //             $output .= '
    //                     <div class="card riwayat" data-no_registrasi="' . $data[$a]["no_registrasi"] . '" data-patient_no="' . $data[$a]["no_pasien"] . '">
    //                         <div class="card-body">
    //                             <p>Anamnesa – ' . date('d/m/Y', strtotime($data[$a]["tgl_registrasi"])) . '</p>
    //                             <p>Keluhan : ' . $data[$a]["keluhan_utama"] . '</p>
    //                             <p>Dokter : ' . ucwords($data[$a]["dokter"]) . '</p>
    //                         </div>
    //                     </div>
    //                     ';
    //         }
    //     }
    //     echo $output;
    //     // } else {
    //     //     exit('Maaf tidak dapat diproses!');
    //     // }
    // }


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
                            </tr>
                        </thead>
                            ';
        if ($data == '') {
            $output .= '<tr>  
                                <td >Data not Found</td>
                                <td ></td>
                                <td ></td>
                                <td ></td>
                            </tr>';
        } else {
            for ($a = 0; $a < count($data); $a++) {
                $output .= ' 
                            <tr class="riwayat" data-no_registrasi="' . $data[$a]["no_registrasi"] . '" data-patient_no="' . $data[$a]["no_pasien"] . '">
                                <td>' . ($a + 1) . '</td>
                                <td>' . date('d/m/Y', strtotime($data[$a]["tgl_registrasi"])) . '</td>
                                <td>' . $data[$a]["keluhan_utama"] . '</td>
                                <td>' . ucwords($data[$a]["dokter"]) . '</td>
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

    public function fetchAllRiwayatAnamnesa()
    {
        if ($this->request->isAJAX()) {

            $patient_no = $this->request->getVar('patient_no');

            $output = '';
            $data =  $this->apiDataGetAllRiwayat($patient_no);
            $output .= '  
                    <table id="example2" class="table table-sm table-striped" style="border-spacing: 0;">
                    <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Keluhan</th>
                                <th>Anamnesa</th>
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
                            </tr>';
            } else {
                for ($a = 0; $a < count($data); $a++) {

                    $output .= '  
                        <tr id="addMdlBarang" data-id="' . $data[$a]["medrec_id"] . '">
                            <td >' . date('d/m/Y', strtotime($data[$a]["tgl_pemeriksaan"])) . '</td>
                            <td >' . $data[$a]["keluhan"] . '</td>
                            <td >' . $data[$a]["anamnesa"] . '</td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm float-right mr-1 mt-1 pilihmr btn-fix-w" data-medrec_id="' . $data[$a]["medrec_id"] . '">
                                    Pilih
                                </button>
                            </td>
                        </tr>  
                ';
                }
            }
            $output .= '</table>
            <script type="text/javascript">
            $(function() {
                $("#example2").DataTable({
                    columnDefs: [{
                        orderable: false,
                        targets: 7
                    }],
                    "dom": "Bfplit",
                    // "buttons": [
                    //     "copy", "csv", "excel", "pdf", "print"
                    // ],
                    "paging": false,
                    "lengthChange": true,
                    "searching": false,
                    "info": false,
                    "autoWidth": false
                });
            });
            </script>
            ';
            echo $output;
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    public function fetchAllRiwayat()
    {
        if ($this->request->isAJAX()) {

            $patient_no = $this->request->getVar('patient_no');

            $output = '';
            $data =  $this->apiDataGetAllRiwayat($patient_no);

            if ($data == '') {
                $output .= '
                        <li class="item">
                            <div class="product-img">
                                <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                            </div>
                            <div class="product-info">
                                <a href="javascript:void(0)" class="product-title">
                                    <span class="badge badge-warning float-right"></span></a>
                                <span class="product-description">
                                    <p></p>
                                    <p></p>
                                </span>
                            </div>
                        </li>
                ';
            } else {
                for ($a = 0; $a < count($data); $a++) {

                    $output .= '  
                        <li class="item pilihregistrasi"
                         data-no_registrasi="' . $data[$a]["no_registrasi"] . '"
                         data-no_pasien="' . $data[$a]["no_pasien"] . '" 
                         data-tujuan_registrasi_desc="' . $data[$a]["tujuan_registrasi_desc"] . '"
                         data-tgl_praktek="' . $data[$a]["tgl_praktek"] . '" 
                         data-tahun="' . $data[$a]["tahun"] . '" 
                         data-bulan="' . $data[$a]["bulan"] . '" 
                         data-hari="' . $data[$a]["hari"] . '" 
                         data-nama_dokter="' . $data[$a]["nama_dokter"] . '" 
                         data-nadi="' . (int)$data[$a]["nadi"] . '" 
                         data-suhu="' . (int)$data[$a]["suhu"] . '" 
                         data-nafas="' . (int)$data[$a]["nafas"] . '" 
                         data-tekanan_darah="' . (int)$data[$a]["tekanan_darah"] . '" 
                         data-tinggi_badan="' . (int)$data[$a]["tinggi_badan"] . '" 
                         data-berat_badan="' . (int)$data[$a]["berat_badan"] . '" 
                         data-keluhan_utama="' . $data[$a]["keluhan_utama"] . '" 
                         data-keluhan_sekunder="' . $data[$a]["keluhan_sekunder"] . '" 
                         data-diagnosa_utama="' . $data[$a]["diagnosa_utama"] . '" 
                         data-diagnosa_sekunder="' . $data[$a]["diagnosa_sekunder"] . '" 
                         data-diagnosa_note="' . $data[$a]["diagnosa_note"] . '"
                         data-pf_rambut="' . $data[$a]["pf_rambut"] . '"
                         data-pf_mata="' . $data[$a]["pf_mata"] . '"
                         data-pf_telinga="' . $data[$a]["pf_telinga"] . '"
                         data-pf_hidung="' . $data[$a]["pf_hidung"] . '"
                         data-pf_tenggorokan="' . $data[$a]["pf_tenggorokan"] . '"
                         data-icd10="' . $data[$a]["icd10"] . '" >
                        <a href="javascript:void(0)" class="product-title">
                            <div class="product-img">
                                <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                            </div>
                            <div class="product-info">
                                ' . $data[$a]["no_registrasi"] . '
                                    <span class="badge badge-warning float-right">' . date('d/m/Y', strtotime($data[$a]["tgl_praktek"])) . '</span>
                                <span class="product-description">
                                    Rawat Jalan - ' . ($data[$a]["tujuan_registrasi_desc"] !== '' ? $data[$a]["tujuan_registrasi_desc"] : "") . '<br>
                                    ' . ($data[$a]["keluhan_utama"] !== '' ? $data[$a]["keluhan_utama"] : "") . '
                                </span>
                                
                            </div>
                            </a>
                        </li>
                    ';
                }
            }


            echo $output;
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    function fetchSingleData()
    {
        if ($this->request->isAJAX()) {

            $medrec_id = $this->request->getVar('medrec_id');

            if ($medrec_id) {

                // helper curl request
                helper(['restclient']);

                // end point
                $url = "$this->server/tmedicalrecord/getby/$medrec_id";

                // client request
                $response = akses_restapi('GET', $url, []);
                $data['response_data'] = json_decode($response, true);

                $msg = [
                    'data' => [
                        'medrec_id' => $data["response_data"][0]["medrec_id"],
                        'patient_no' => $data["response_data"][0]["patient_no"],
                        'fullname' => $data["response_data"][0]["fullname"],
                        'no_registrasi' => $data["response_data"][0]["no_registrasi"],
                        'tgl_pemeriksaan' => $data["response_data"][0]["tgl_pemeriksaan"],
                        'tahun' => $data["response_data"][0]["tahun"],
                        'bulan' => $data["response_data"][0]["bulan"],
                        'hari' => $data["response_data"][0]["hari"],
                        'keluhan' => $data["response_data"][0]["keluhan"],
                        'anamnesa' => $data["response_data"][0]["anamnesa"]
                    ]
                ];

                echo json_encode($msg);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    // function action()
    // {
    //     if ($this->request->isAJAX()) {
    //         if ($this->request->getVar('action')) {
    //             helper(['form', 'url']);

    //             $validation = \Config\Services::validation();
    //             $valid = $this->validate([
    //                 'no_registrasi' => [
    //                     'label' => 'No. Registrasi',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ],
    //                 'patient_no' => [
    //                     'label' => 'No. RM',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ],
    //                 'keluhan' => [
    //                     'label' => 'Keluhan',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ],
    //                 'anamnesa' => [
    //                     'label' => 'Anamnesa',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ]
    //             ]);
    //             if (!$valid) {
    //                 $msg = [
    //                     'error' => [
    //                         'no_registrasi' => $validation->getError('no_registrasi'),
    //                         'patient_no' => $validation->getError('patient_no'),
    //                         'keluhan' => $validation->getError('keluhan'),
    //                         'anamnesa' => $validation->getError('anamnesa')
    //                     ]
    //                 ];
    //             } else {

    //                 if ($this->request->getVar('action') == 'Add') {

    //                     // helper curl request
    //                     helper(['restclient']);

    //                     // endpoint
    //                     $url = "$this->server/tmedicalrecord/insert";

    //                     // form params
    //                     $data = [
    //                         "medrec_id" => '',
    //                         "patient_no" => str_replace(" ", "_", trim($this->request->getVar('patient_no'))),
    //                         "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
    //                         "fullname" => $this->request->getVar('fullname'),
    //                         "tgl_pemeriksaan" => $this->request->getVar('tgl_pemeriksaan'),
    //                         // "tahun" => $this->request->getVar('tahun'),
    //                         // "bulan" => $this->request->getVar('bulan'),
    //                         // "hari" => $this->request->getVar('hari'),
    //                         "keluhan" => $this->request->getVar('keluhan'),
    //                         "anamnesa" => $this->request->getVar('anamnesa'),
    //                         // "patient_no" => '23090001',
    //                         // "no_registrasi" => 'REG122300048',
    //                         // "fullname" => 'yoyo',
    //                         // "tgl_pemeriksaan" => '12-20-2023',
    //                         // "tgl_pemeriksaan" => '12-20-2023',
    //                         // "tahun" => 22,
    //                         // "bulan" => 2,
    //                         // "hari" => 2,
    //                         // "keluhan" => 'sehat 67676767',
    //                         // "anamnesa" => 'sehat 78787878'
    //                     ];
    //                     // client request
    //                     $response = akses_restapi('POST', $url, $data);

    //                     $msg = [
    //                         'success' => 'data berhasil di create!'
    //                     ];
    //                 }
    //             }

    //             echo json_encode($msg);
    //         }
    //     } else {
    //         exit('Maaf tidak dapat diproses!');
    //     }
    // }

    function fetchAllDataPrint($isi)
    {
        // // helper curl request
        // helper(['restclient']);
        // // end point
        // $url = "$this->server/pasien/getby/23090001";
        // // client request
        // $response = akses_restapi('GET', $url, []);
        // $data['response_data'] = json_decode($response, true);

        $pdf_data = $isi;
        $pdf_name = 'Surat Rujukan Pasien';
        $pdf_title = 'SURAT RUJUKAN';
        $pdf_paper = 'A4';
        $pdf_orientation = 'portrait';
        $pdf_format = 'rpt_surat_rujukan';

        $this->view_pdf($pdf_name, $pdf_title, $pdf_data, $pdf_paper, $pdf_orientation, $pdf_format);
    }

    function fetchSingleDataPrint($no_registrasi)
    {

        if ($no_registrasi) {

            // helper curl request
            helper(['restclient']);
            // end point
            $url = "$this->server/tregistrasirujukan/getby/$no_registrasi";
            // client request
            $response = akses_restapi('GET', $url, []);
            $data['response_data'] = json_decode($response, true);

            $pdf_data = $data['response_data'];
            $pdf_name = 'Surat Rujukan Pasien';
            $pdf_title = 'SURAT RUJUKAN';
            $pdf_paper = 'A4';
            $pdf_orientation = 'portrait';
            $pdf_format = 'rpt_surat_rujukan';

            $this->view_pdf($pdf_name, $pdf_title, $pdf_data, $pdf_paper, $pdf_orientation, $pdf_format);
        }
    }

    public function view_pdf($pdf_name, $pdf_title, $pdf_data, $pdf_paper, $pdf_orientation, $pdf_format)
    {

        $Pdfgenerator = new Pdfgenerator();

        // filename dari pdf ketika didownload
        $file_pdf = $pdf_name;

        // title dari pdf
        $this->data['title_pdf'] = $pdf_title;

        //data
        $this->data['content'] = $pdf_data;

        // setting paper
        $paper = $pdf_paper;

        //orientasi paper potrait / landscape
        $orientation = $pdf_orientation;

        $html = view($pdf_format, $this->data);

        // run dompdf
        $Pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    }

    function action_rujukan()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getVar('action')) {
                helper(['form', 'url']);

                $validation = \Config\Services::validation();
                $valid = $this->validate([
                    'no_registrasi' => [
                        'label' => 'No. Registrasi',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ]
                ]);
                if (!$valid) {
                    $msg = [
                        'error' => [
                            'no_registrasi' => $validation->getError('no_registrasi'),
                            'rujukan' => $validation->getError('rujukan'),
                            'ket_rujukan' => $validation->getError('ket_rujukan'),
                            'dokter_rujukan' => $validation->getError('dokter_rujukan'),
                            'user_rujukan' => $validation->getError('user_rujukan'),
                        ]
                    ];
                } else {

                    if ($this->request->getVar('action') == 'Add') {

                        // helper curl request
                        helper(['restclient']);

                        // endpoint
                        $url = "$this->server/tregistrasirujukan/double";

                        // form params
                        $data = [
                            "no_registrasi" => $this->request->getVar('no_registrasi'),
                            "rujukan" => $this->request->getVar('rujukan'),
                            "ket_rujukan" => $this->request->getVar('ket_rujukan'),
                            "dokter_rujukan" => $this->request->getVar('dokter_rujukan'),
                            "user_rujukan" => $this->session->get('fullname'),
                        ];
                        // client request
                        $response = akses_restapi('POST', $url, $data);

                        $msg = [
                            'success' => 'data berhasil di create!'
                        ];
                    }
                }

                echo json_encode($msg);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    function action()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getVar('action')) {
                helper(['form', 'url']);

                $validation = \Config\Services::validation();
                $valid = $this->validate([
                    // 'no_registrasi' => [
                    //     'label' => 'No. Registrasi',
                    //     'rules' => 'required',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ],
                    'nadi' => [
                        'label' => 'Nadi',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'suhu' => [
                        'label' => 'Suhu',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'nafas' => [
                        'label' => 'Nafas',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'tekanan_darah' => [
                        'label' => 'Tekanan Darah',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'tinggi_badan' => [
                        'label' => 'Tinggi Badan',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'berat_badan' => [
                        'label' => 'Berat Badan',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'keluhan_utama' => [
                        'label' => 'Keluhan Utama',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'keluhan_sekunder' => [
                        'label' => 'Keluhan Sekunder',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'diagnosa_utama' => [
                        'label' => 'Diagnosa Utama',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'diagnosa_sekunder' => [
                        'label' => 'Diagnosa Sekunder',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'diagnosa_note' => [
                        'label' => 'Diagnosa Note',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'pf_rambut' => [
                        'label' => 'Rambut',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'pf_mata' => [
                        'label' => 'Mata',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'pf_telinga' => [
                        'label' => 'Telinga',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'pf_hidung' => [
                        'label' => 'Hidung',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'pf_tenggorokan' => [
                        'label' => 'Tenggorokan',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'reduksi_persen' => [
                        'label' => 'Reduksi',
                        'rules' => 'required|greater_than[0]|less_than[101]|numeric',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ]
                    // ,
                    // 'photo' => [
                    //     'label' => 'Photo',
                    //     'rules' => 'required',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ]
                ]);
                if (!$valid) {
                    $msg = [
                        'error' => [
                            'no_registrasi' => $validation->getError('no_registrasi'),
                            'patient_no' => $validation->getError('patient_no'),
                            'keluhan' => $validation->getError('keluhan'),
                            'anamnesa' => $validation->getError('anamnesa'),
                            'nadi' => $validation->getError('nadi'),
                            'suhu' => $validation->getError('suhu'),
                            'nafas' => $validation->getError('nafas'),
                            'tekanan_darah' => $validation->getError('tekanan_darah'),
                            'tinggi_badan' => $validation->getError('tinggi_badan'),
                            'berat_badan' => $validation->getError('berat_badan'),
                            'keluhan_utama' => $validation->getError('keluhan_utama'),
                            'keluhan_sekunder' => $validation->getError('keluhan_sekunder'),
                            'diagnosa_utama' => $validation->getError('diagnosa_utama'),
                            'diagnosa_sekunder' => $validation->getError('diagnosa_sekunder'),
                            'diagnosa_note' => $validation->getError('diagnosa_note'),
                            'pf_rambut' => $validation->getError('pf_rambut'),
                            'pf_mata' => $validation->getError('pf_mata'),
                            'pf_telinga' => $validation->getError('pf_telinga'),
                            'pf_hidung' => $validation->getError('pf_hidung'),
                            'pf_tenggorokan' => $validation->getError('pf_tenggorokan'),
                            'reduksi_persen' => $validation->getError('reduksi_persen'),
                        ]
                    ];
                } else {

                    if ($this->request->getVar('action') == 'Add') {

                        // helper curl request
                        helper(['restclient']);

                        $no_registrasi = $this->session->get('no_registrasi');

                        // endpoint
                        $url = "$this->server/tregistrasi/konsultasidokter/$no_registrasi";

                        // client request
                        $response = akses_restapi('PATCH', $url, []);
                        $data['response_data'] = json_decode($response, true);

                        // // endpoint
                        // $url = "$this->server/tmedicalrecord/insert";

                        // // form params
                        // $data = [
                        //     "patient_no" => str_replace(" ", "_", trim($this->request->getVar('patient_no'))),
                        //     "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
                        //     "fullname" => $this->request->getVar('fullname'),
                        //     "tgl_pemeriksaan" => $this->request->getVar('tgl_pemeriksaan'),
                        //     "keluhan" => $this->request->getVar('keluhan'),
                        //     "anamnesa" => $this->request->getVar('anamnesa')
                        // ];
                        // // client request
                        // $response = akses_restapi('POST', $url, $data);


                        // endpoint
                        $url = "$this->server/tregistrasipemeriksaanawal/insert";

                        // form params
                        $data = [
                            // "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
                            "no_registrasi" => $no_registrasi,
                            "nadi" => $this->request->getVar('nadi'),
                            "suhu" => $this->request->getVar('suhu'),
                            "nafas" => $this->request->getVar('nafas'),
                            "tekanan_darah" => $this->request->getVar('tekanan_darah'),
                            "tinggi_badan" => $this->request->getVar('tinggi_badan'),
                            "berat_badan" => $this->request->getVar('berat_badan')
                        ];
                        // client request
                        $response = akses_restapi('POST', $url, $data);



                        // endpoint
                        $url = "$this->server/tregistrasipemeriksaanumum/insert";

                        // form params RG000001
                        $data = [
                            // "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('patient_no'))),
                            "no_registrasi" => $no_registrasi,
                            "keluhan_utama" => $this->request->getVar('keluhan_utama'),
                            "keluhan_sekunder" => $this->request->getVar('keluhan_sekunder'),
                            "diagnosa_utama" => $this->request->getVar('diagnosa_utama'),
                            "diagnosa_sekunder" => $this->request->getVar('diagnosa_sekunder'),
                            "diagnosa_note" => $this->request->getVar('diagnosa_note'),
                            "pf_rambut" => $this->request->getVar('pf_rambut'),
                            "pf_mata" => $this->request->getVar('pf_mata'),
                            "pf_telinga" => $this->request->getVar('pf_telinga'),
                            "pf_hidung" => $this->request->getVar('pf_hidung'),
                            "pf_tenggorokan" => $this->request->getVar('pf_tenggorokan'),
                            "icd10" => $this->request->getVar('icd10')
                        ];
                        // client request
                        $response = akses_restapi('POST', $url, $data);

                        // endpoint
                        $url = "$this->server/tregistrasipemeriksaaninfo/insert";

                        // form params
                        $data = [
                            "no_registrasi" => $no_registrasi,
                            "reduksi_persen" => $this->request->getVar('reduksi_persen'),
                            "reduksi_jumlah" => $this->request->getVar('suhu')
                        ];
                        // client request
                        $response = akses_restapi('POST', $url, $data);

                        // // endpoint
                        // $urlbilling = "$this->server/billing/update";

                        // // form params
                        // $databilling = [
                        //     'no_kwitansi' => $this->request->getVar('no_kwitansi'),
                        //     'no_registrasi' => $no_registrasi,
                        //     'tgl_kwitansi' => date("Y-m-d H:i:s"),
                        //     'emp_cd' => $this->session->get('usr_id'),
                        //     'status_kwitansi' => 'aktif',
                        //     'terbilang' => '',
                        //     'tagihan' => 100000,
                        //     // 'tagihan' => '1000000000',
                        //     'saldo' => 0,
                        // ];

                        // // client request
                        // $response = akses_restapi('POST', $urlbilling, $databilling);

                        // endpoint
                        $urlbillingdetail = "$this->server/billingdetail/insert";

                        // form params
                        $databillingdetail = [
                            'no_kwitansi' => $this->request->getVar('no_kwitansi'),
                            'item_cd' => 'PD1454',
                            'jumlah' => 1,
                            'tarif' => 100000,
                            'potongan' => $this->request->getVar('reduksi_persen'),
                            'pajak' => 0,
                            'total' => 100000 - (100000 * $this->request->getVar('reduksi_persen')) / 100,
                        ];

                        // client request
                        akses_restapi('POST', $urlbillingdetail, $databillingdetail);



                        // // endpoint
                        // $url = "$this->server/tpatientalergi/insert";

                        // // form params
                        // $data = [
                        //     "patient_no" => $this->request->getVar('patient_no'),
                        //     "alergi" => $this->request->getVar('alergi'),
                        //     "reported_dt" => $this->request->getVar('reported_dt')
                        // ];
                        // // client request
                        // $response = akses_restapi('POST', $url, $data);


                        // // helper curl request
                        // helper(['restclient']);

                        // // endpoint
                        // $url = "$this->server/tregistrasi/konsultasidokter/$no_registrasi";

                        // // client request
                        // $response = akses_restapi('PATCH', $url, []);
                        // $data['response_data'] = json_decode($response, true);

                        $msg = [
                            'success' => 'data berhasil di create!'
                        ];
                    }
                }

                echo json_encode($msg);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    function action2()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getVar('action2')) {
                helper(['form', 'url']);

                $validation = \Config\Services::validation();
                $valid = $this->validate([
                    // 'patient_no' => [
                    //     'label' => 'Code',
                    //     'rules' => 'required',
                    //     'errors' => [
                    //         //'required' => '{field} tidak boleh kosong',
                    //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    //     ]
                    // ],
                    'kategori_alergi' => [
                        'label' => 'Kategori',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'bahan_alergi' => [
                        'label' => 'Bahan',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'permulaan_dt' => [
                        'label' => 'Permulaan Date',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'komponen_alergi' => [
                        'label' => 'Komponen',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'reaksi_alergi' => [
                        'label' => 'Reaksi',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'tingkat_kegawatan_alergi' => [
                        'label' => 'Tingkat Kegawatan',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'status_alergi' => [
                        'label' => 'Status',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'verifikasi_alergi' => [
                        'label' => 'Verifikasi',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ],
                    'catatan' => [
                        'label' => 'Catatan',
                        'rules' => 'required',
                        'errors' => [
                            //'required' => '{field} tidak boleh kosong',
                            //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                        ]
                    ]
                ]);
                if (!$valid) {
                    $msg = [
                        'error' => [
                            // 'patient_no' => $validation->getError('patient_no'),
                            'kategori_alergi' => $validation->getError('kategori_alergi'),
                            'bahan_alergi' => $validation->getError('bahan_alergi'),
                            'permulaan_dt' => $validation->getError('permulaan_dt'),
                            'komponen_alergi' => $validation->getError('komponen_alergi'),
                            'reaksi_alergi' => $validation->getError('reaksi_alergi'),
                            'tingkat_kegawatan_alergi' => $validation->getError('tingkat_kegawatan_alergi'),
                            'status_alergi' => $validation->getError('status_alergi'),
                            'verifikasi_alergi' => $validation->getError('verifikasi_alergi'),
                            'catatan' => $validation->getError('catatan')
                        ]
                    ];
                } else {

                    if ($this->request->getVar('action2') == 'Add') {

                        // helper curl request
                        helper(['restclient']);

                        // endpoint
                        $url = "$this->server/tpatientalergi/insert";

                        // form params
                        $data = [
                            "patient_no" => str_replace(" ", "_", trim($this->request->getVar('patient_no'))),
                            "kategori" => $this->request->getVar('kategori_alergi'),
                            "bahan" => $this->request->getVar('bahan_alergi'),
                            "permulaan_dt" => $this->request->getVar('permulaan_dt'),
                            "komponen" => $this->request->getVar('komponen_alergi'),
                            "reaksi" => $this->request->getVar('reaksi_alergi'),
                            "tingkat_kegawatan" => $this->request->getVar('tingkat_kegawatan_alergi'),
                            "status" => $this->request->getVar('status_alergi'),
                            "verifikasi" => $this->request->getVar('verifikasi_alergi'),
                            "catatan" => $this->request->getVar('catatan'),
                            // "icd10" => $this->request->getVar('icd10')
                        ];
                        // client request
                        $response = akses_restapi('POST', $url, $data);

                        $msg = [
                            'success' => 'data berhasil di create!'
                        ];
                    }
                }

                echo json_encode($msg);
            }
        } else {
            exit('Maaf tidak dapat diproses!');
        }
    }

    function action_anamnesa()
    {
        // if ($this->request->isAJAX()) {
        if ($this->request->getVar('action_anamnesa')) {
            helper(['form', 'url']);

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                // 'patient_no' => [
                //     'label' => 'Code',
                //     'rules' => 'required',
                //     'errors' => [
                //         //'required' => '{field} tidak boleh kosong',
                //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                //     ]
                // ],
                'keluhan_utama' => [
                    'label' => 'Keluhan Utama',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'no_registrasi' => $validation->getError('no_registrasi'),
                        'responden' => $validation->getError('responden'),
                        'keluhan_utama' => $validation->getError('keluhan_utama'),
                        'riwayat_perjalanan_keluhan' => $validation->getError('riwayat_perjalanan_keluhan'),
                        'riwayat_penyakit_sekarang' => $validation->getError('riwayat_penyakit_sekarang'),
                        'riwayat_penyakit_dahulu' => $validation->getError('riwayat_penyakit_dahulu'),
                        'riwayat_operasi_pengobatan' => $validation->getError('riwayat_operasi_pengobatan'),
                        'riwayat_penyakit_keluarga' => $validation->getError('riwayat_penyakit_keluarga'),
                        'riwayat_lain' => $validation->getError('riwayat_lain')
                    ]
                ];
            } else {

                if ($this->request->getVar('action_anamnesa') == 'Add') {

                    // helper curl request
                    helper(['restclient']);

                    // endpoint
                    $url = "$this->server/tregistrasianamnesa/insert";

                    // form params
                    $data = [
                        "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
                        "responden" => $this->request->getVar('responden'),
                        "keluhan_utama" => $this->request->getVar('keluhan_utama'),
                        "riwayat_perjalanan_keluhan" => $this->request->getVar('riwayat_perjalanan_keluhan'),
                        "riwayat_penyakit_sekarang" => $this->request->getVar('riwayat_penyakit_sekarang'),
                        "riwayat_penyakit_dahulu" => $this->request->getVar('riwayat_penyakit_dahulu'),
                        "riwayat_operasi_pengobatan" => $this->request->getVar('riwayat_operasi_pengobatan'),
                        "riwayat_penyakit_keluarga" => $this->request->getVar('riwayat_penyakit_keluarga'),
                        "riwayat_lain" => $this->request->getVar('riwayat_lain')
                    ];
                    // client request
                    $response = akses_restapi('POST', $url, $data);

                    $msg = [
                        'success' => 'data berhasil di create!'
                    ];
                }
            }

            echo json_encode($msg);
        }
        // } else {
        //     exit('Maaf tidak dapat diproses!');
        // }
    }

    function action_periksa()
    {
        // if ($this->request->isAJAX()) {
        if ($this->request->getVar('action_periksa')) {
            helper(['form', 'url']);

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                // 'patient_no' => [
                //     'label' => 'Code',
                //     'rules' => 'required',
                //     'errors' => [
                //         //'required' => '{field} tidak boleh kosong',
                //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                //     ]
                // ],
                'kondisi_umum' => [
                    'label' => 'Kondisi Umum',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'kondisi_khusus' => [
                    'label' => 'Kondisi Khusus',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'tinggi_badan' => [
                    'label' => 'Tinggi Badan',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'berat_badan' => [
                    'label' => 'Berat Badan',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'sistolik' => [
                    'label' => 'Sistolik',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'diastolik' => [
                    'label' => 'Diastolik',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'denyut_nadi' => [
                    'label' => 'Denyut Nadi',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'laju_nafas' => [
                    'label' => 'Laju Nafas',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'suhu' => [
                    'label' => 'Suhu',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'no_registrasi' => $validation->getError('no_registrasi'),
                        'kondisi_umum' => $validation->getError('kondisi_umum'),
                        'kondisi_khusus' => $validation->getError('kondisi_khusus'),
                        'tinggi_badan' => $validation->getError('tinggi_badan'),
                        'berat_badan' => $validation->getError('berat_badan'),
                        'sistolik' => $validation->getError('sistolik'),
                        'diastolik' => $validation->getError('diastolik'),
                        'denyut_nadi' => $validation->getError('denyut_nadi'),
                        'laju_nafas' => $validation->getError('laju_nafas'),
                        'suhu' => $validation->getError('suhu'),
                        'bmi' => $validation->getError('bmi'),
                        'pemeriksaan_tambahan' => $validation->getError('pemeriksaan_tambahan')
                    ]
                ];
            } else {

                if ($this->request->getVar('action_periksa') == 'Add') {

                    // helper curl request
                    helper(['restclient']);

                    // endpoint
                    $url = "$this->server/tregistrasiperiksa/insert";

                    // form params
                    $data = [
                        "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
                        "kondisi_umum" => $this->request->getVar('kondisi_umum'),
                        "kondisi_khusus" => $this->request->getVar('kondisi_khusus'),
                        "tinggi_badan" => $this->request->getVar('tinggi_badan'),
                        "berat_badan" => $this->request->getVar('berat_badan'),
                        "sistolik" => $this->request->getVar('sistolik'),
                        "diastolik" => $this->request->getVar('diastolik'),
                        "denyut_nadi" => $this->request->getVar('denyut_nadi'),
                        "laju_nafas" => $this->request->getVar('laju_nafas'),
                        "suhu" => $this->request->getVar('suhu'),
                        "bmi" => $this->request->getVar('bmi'),
                        "pemeriksaan_tambahan" => $this->request->getVar('pemeriksaan_tambahan')
                    ];
                    // client request
                    $response = akses_restapi('POST', $url, $data);

                    $msg = [
                        'success' => 'data berhasil di create!'
                    ];
                }
            }

            echo json_encode($msg);
        }
        // } else {
        //     exit('Maaf tidak dapat diproses!');
        // }
    }

    function action_diagnosa()
    {
        // if ($this->request->isAJAX()) {
        if ($this->request->getVar('action_diagnosa')) {
            helper(['form', 'url']);

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                // 'patient_no' => [
                //     'label' => 'Code',
                //     'rules' => 'required',
                //     'errors' => [
                //         //'required' => '{field} tidak boleh kosong',
                //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                //     ]
                // ],
                'diagnosa_utama' => [
                    'label' => 'Diagnosa Utama',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'diagnosa_sekunder' => [
                    'label' => 'Diagnosa Sekunder',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'diagnosa_utama' => $validation->getError('diagnosa_utama'),
                        'diagnosa_sekunder' => $validation->getError('diagnosa_sekunder')
                    ]
                ];
            } else {

                if ($this->request->getVar('action_diagnosa') == 'Add') {

                    // helper curl request
                    helper(['restclient']);

                    // endpoint
                    $url = "$this->server/tregistrasidiagnosa/insert";

                    // form params
                    $data = [
                        "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
                        "diagnosa_utama" => $this->request->getVar('diagnosa_utama'),
                        "icd10_utama" => $this->request->getVar('icd10_utama'),
                        "klasifikasi_utama" => $this->request->getVar('klasifikasi_utama'),
                        "diagnosa_sekunder" => $this->request->getVar('diagnosa_sekunder'),
                        "icd10_sekunder" => $this->request->getVar('icd10_sekunder'),
                        "klasifikasi_sekunder" => $this->request->getVar('klasifikasi_sekunder'),
                        "diagnosa_utama_sta" => $this->request->getVar('diagnosa_utama_sta'),
                        "diagnosa_sekunder_sta" => $this->request->getVar('diagnosa_sekunder_sta')
                    ];
                    // client request
                    $response = akses_restapi('POST', $url, $data);

                    $msg = [
                        'success' => 'data berhasil di create!'
                    ];
                }
            }

            echo json_encode($msg);
        }
        // } else {
        //     exit('Maaf tidak dapat diproses!');
        // }
    }

    function action_all()
    {
        // if ($this->request->isAJAX()) {
        if ($this->request->getVar('action_all') == 'Add') {
            helper(['form', 'url']);

            $validation = \Config\Services::validation();
            $valid = $this->validate([

                'patient_no' => [
                    'label' => 'Code',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'keluhan_utama' => [
                    'label' => 'Keluhan Utama',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'riwayat_perjalanan_keluhan' => [
                    'label' => 'Riwayat Perjalanan Keluhan',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                // 'riwayat_penyakit_sekarang' => [
                //     'label' => 'Riwayat Penyakit Sekarang',
                //     'rules' => 'required',
                //     'errors' => [
                //         //'required' => '{field} tidak boleh kosong',
                //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                //     ]
                // ],
                'riwayat_penyakit_dahulu' => [
                    'label' => 'Riwayat Penyakit Dahulu',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'riwayat_operasi_pengobatan' => [
                    'label' => 'Riwayat Operasi Pengobatan',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'riwayat_penyakit_keluarga' => [
                    'label' => 'Riwayat Penyakit Keluarga',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'riwayat_lain' => [
                    'label' => 'Riwayat Lain',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'kondisi_umum' => [
                    'label' => 'Kondisi Umum',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'tinggi_badan' => [
                    'label' => 'Tinggi Badan',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'berat_badan' => [
                    'label' => 'Berat Badan',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'suhu' => [
                    'label' => 'Suhu',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'sistolik' => [
                    'label' => 'Sistolik',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'diastolik' => [
                    'label' => 'Diastolik',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'denyut_nadi' => [
                    'label' => 'Denyut_nadi',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'laju_nafas' => [
                    'label' => 'Laju Nafas',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'kondisi_khusus' => [
                    'label' => 'Kondisi Khusus',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'pemeriksaan_tambahan' => [
                    'label' => 'Pemeriksaan Tambahan',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'diagnosa_utama' => [
                    'label' => 'Diagnosa Utama',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'diagnosa_sekunder' => [
                    'label' => 'Diagnosa Sekunder',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'keluhan_utama' => $validation->getError('keluhan_utama'), //START ANAMNESA
                        'riwayat_perjalanan_keluhan' => $validation->getError('riwayat_perjalanan_keluhan'),
                        'riwayat_penyakit_sekarang' => $validation->getError('riwayat_penyakit_sekarang'),
                        'riwayat_penyakit_dahulu' => $validation->getError('riwayat_penyakit_dahulu'),
                        'riwayat_operasi_pengobatan' => $validation->getError('riwayat_operasi_pengobatan'),
                        'riwayat_penyakit_keluarga' => $validation->getError('riwayat_penyakit_keluarga'),
                        'riwayat_lain' => $validation->getError('riwayat_lain'), //END ANAMNESA

                        'kondisi_umum' => $validation->getError('kondisi_umum'), //START PERIKSA
                        'kondisi_khusus' => $validation->getError('kondisi_khusus'),
                        'tinggi_badan' => $validation->getError('tinggi_badan'),
                        'berat_badan' => $validation->getError('berat_badan'),
                        'sistolik' => $validation->getError('sistolik'),
                        'diastolik' => $validation->getError('diastolik'),
                        'denyut_nadi' => $validation->getError('denyut_nadi'),
                        'laju_nafas' => $validation->getError('laju_nafas'),
                        'suhu' => $validation->getError('suhu'),
                        'pemeriksaan_tambahan' => $validation->getError('pemeriksaan_tambahan'), //END PERIKSA

                        'diagnosa_utama' => $validation->getError('diagnosa_utama'), //START DIAGNOSA
                        'diagnosa_sekunder' => $validation->getError('diagnosa_sekunder') //END DIAGNOSA
                    ]
                ];
            } else {

                /*--START SET STATUS PM--*/
                // helper curl request
                helper(['restclient']);
                $no_registrasi = $this->request->getVar('no_registrasi');
                // endpoint
                $url = "$this->server/tregistrasi/konsultasidokter/$no_registrasi";
                // client request
                $response = akses_restapi('PATCH', $url, []);
                $data['response_data'] = json_decode($response, true);
                /*--END SET STATUS PM--*/

                /*--START GET NO KWT--*/
                // helper curl request
                helper(['restclient']);
                // endpoint
                $url = "$this->server/billing/getkwtby/$no_registrasi";
                // client request
                $response = akses_restapi('GET', $url, []);
                $data['response_data'] = json_decode($response, true);
                $no_kwitansi = $data['response_data'][0]['no_kwitansi'];
                /*--END GET NO KWT--*/

                /*--START ANAMNESA--*/
                // helper curl request
                helper(['restclient']);
                // endpoint
                $url = "$this->server/tregistrasianamnesa/double";
                // form params
                $data = [
                    "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
                    "responden" => $this->request->getVar('responden'),
                    "keluhan_utama" => $this->request->getVar('keluhan_utama'),
                    "riwayat_perjalanan_keluhan" => $this->request->getVar('riwayat_perjalanan_keluhan'),
                    "riwayat_penyakit_sekarang" => $this->request->getVar('riwayat_penyakit_sekarang'),
                    "riwayat_penyakit_dahulu" => $this->request->getVar('riwayat_penyakit_dahulu'),
                    "riwayat_operasi_pengobatan" => $this->request->getVar('riwayat_operasi_pengobatan'),
                    "riwayat_penyakit_keluarga" => $this->request->getVar('riwayat_penyakit_keluarga'),
                    "riwayat_lain" => $this->request->getVar('riwayat_lain')
                ];
                // client request
                $response = akses_restapi('POST', $url, $data);
                /*--END ANAMNESA--*/

                /*--START PERIKSA--*/
                // helper curl request
                helper(['restclient']);
                // endpoint
                $url = "$this->server/tregistrasiperiksa/double";
                // form params
                $data = [
                    "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
                    "kondisi_umum" => $this->request->getVar('kondisi_umum'),
                    "kondisi_khusus" => $this->request->getVar('kondisi_khusus'),
                    "tinggi_badan" => $this->request->getVar('tinggi_badan'),
                    "berat_badan" => $this->request->getVar('berat_badan'),
                    "sistolik" => $this->request->getVar('sistolik'),
                    "diastolik" => $this->request->getVar('diastolik'),
                    "denyut_nadi" => $this->request->getVar('denyut_nadi'),
                    "laju_nafas" => $this->request->getVar('laju_nafas'),
                    "suhu" => $this->request->getVar('suhu'),
                    "bmi" => $this->request->getVar('bmi'),
                    "pemeriksaan_tambahan" => $this->request->getVar('pemeriksaan_tambahan')
                ];
                // client request
                $response = akses_restapi('POST', $url, $data);
                /*--END PERIKSA--*/

                /*--START DIAGNOSA--*/
                // helper curl request
                helper(['restclient']);
                // endpoint
                $url = "$this->server/tregistrasidiagnosa/double";
                // form params
                $data = [
                    "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
                    "diagnosa_utama" => $this->request->getVar('diagnosa_utama'),
                    "icd10_utama" => $this->request->getVar('icd10_utama'),
                    "klasifikasi_utama" => $this->request->getVar('klasifikasi_utama'),
                    "diagnosa_sekunder" => $this->request->getVar('diagnosa_sekunder'),
                    "icd10_sekunder" => $this->request->getVar('icd10_sekunder'),
                    "klasifikasi_sekunder" => $this->request->getVar('klasifikasi_sekunder'),
                    "diagnosa_utama_sta" => $this->request->getVar('diagnosa_utama_sta'),
                    "diagnosa_sekunder_sta" => $this->request->getVar('diagnosa_sekunder_sta')
                ];
                // client request
                $response = akses_restapi('POST', $url, $data);
                /*--END DIAGNOSA--*/

                /*--START ALERGI--*/
                $alergi = $this->request->getVar('kategori_alergi');
                $alergi_no = $this->request->getVar('alergi_no');
                $number = count($alergi);
                if ($number > 0) {
                    for ($i = 0; $i < $number; $i++) {

                        if (trim($alergi[$i] != '') && trim($alergi_no[$i] != '')) {

                            // helper curl request
                            helper(['restclient']);

                            // endpoint
                            $url = "$this->server/tpatientalergi/update";

                            // form params
                            $data = [
                                "patient_no" => str_replace(" ", "_", trim($this->request->getVar('patient_no'))),
                                "kategori" => $this->request->getVar('kategori_alergi')[$i],
                                "komponen" => $this->request->getVar('komponen_alergi')[$i],
                                "reaksi" => $this->request->getVar('reaksi_alergi')[$i],
                                "alergi_no" => $this->request->getVar('alergi_no')[$i]
                            ];
                            // client request
                            $response = akses_restapi('PUT', $url, $data);
                        } else {
                            // helper curl request
                            helper(['restclient']);

                            // endpoint
                            $url = "$this->server/tpatientalergi/insert";

                            // form params
                            $data = [
                                "patient_no" => str_replace(" ", "_", trim($this->request->getVar('patient_no'))),
                                "kategori" => $this->request->getVar('kategori_alergi')[$i],
                                "komponen" => $this->request->getVar('komponen_alergi')[$i],
                                "reaksi" => $this->request->getVar('reaksi_alergi')[$i]
                            ];
                            // client request
                            $response = akses_restapi('POST', $url, $data);
                        }
                    }
                }
                /*--END ALERGI--*/

                /*--START DIAGNOSA TAMBAHAN--*/
                $diagnosa = $this->request->getVar('diagnosa_tambahan');
                $seq_id = $this->request->getVar('seq_id');
                if (isset($diagnosa)) {
                    $number = count($diagnosa);
                    if ($number > 0) {
                        for ($i = 0; $i < $number; $i++) {

                            if (trim($diagnosa[$i] != '') && trim($seq_id[$i] != '')) {
                                // helper curl request
                                helper(['restclient']);
                                // endpoint
                                $url = "$this->server/tregistrasidiagnosatambahan/update";
                                // form params
                                $data = [
                                    "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
                                    "diagnosa" => $this->request->getVar('diagnosa_tambahan')[$i],
                                    "icd10" => $this->request->getVar('icd10_tambahan')[$i],
                                    "klasifikasi" => $this->request->getVar('klasifikasi_tambahan')[$i],
                                    "seq_id" => $this->request->getVar('seq_id')[$i]
                                ];
                                // client request
                                $response = akses_restapi('PUT', $url, $data);
                            } else {
                                // helper curl request
                                helper(['restclient']);
                                // endpoint
                                $url = "$this->server/tregistrasidiagnosatambahan/insert";
                                // form params
                                $data = [
                                    "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
                                    "diagnosa" => $this->request->getVar('diagnosa_tambahan')[$i],
                                    "icd10" => $this->request->getVar('icd10_tambahan')[$i],
                                    "klasifikasi" => $this->request->getVar('klasifikasi_tambahan')[$i]
                                ];
                                // client request
                                $response = akses_restapi('POST', $url, $data);
                            }
                        }
                    }
                }
                /*--END DIAGNOSA TAMBAHAN--*/

                /*--START LABORATORIUM--*/
                $layanan = $this->request->getVar('layanan');

                $item_cd = $this->request->getVar('item_cd');
                $number = count($layanan);
                if ($number > 0) {
                    for ($i = 0; $i < $number; $i++) {

                        if (trim($layanan[$i] != '') && trim($item_cd[$i] != '')) {

                            // helper curl request
                            helper(['restclient']);

                            // endpoint
                            // $url = "$this->server/tregistrasilayananlrmu/update";
                            $url = "$this->server/tregistrasilayananlrmu/insert";

                            // form params
                            $data = [
                                "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
                                "layanan" => $this->request->getVar('layanan')[$i],
                                "item_cd" => $this->request->getVar('item_cd')[$i]
                            ];

                            // client request
                            // $response = akses_restapi('PUT', $url, $data);
                            $response = akses_restapi('POST', $url, $data);

                            // helper curl request
                            helper(['restclient']);

                            // endpoint
                            $urlbillingdetail = "$this->server/billingdetail/insert";

                            // form params
                            // $databillingdetail = [
                            //     'no_kwitansi' => $no_kwitansi,
                            //     'item_cd' => $this->request->getVar('item_cd')[$i],
                            //     'jumlah' => $this->request->getVar('qty')[$i],
                            //     'tarif' => $this->request->getVar('biaya_amount')[$i],
                            //     'potongan' => $this->request->getVar('item_cd')[$i],
                            //     'pajak' => $this->request->getVar('pajak')[$i],
                            //     'total' => $this->request->getVar('harga')[$i]
                            // ];

                            $databillingdetail = [
                                'no_kwitansi' => $no_kwitansi,
                                'item_cd' => $this->request->getVar('item_cd')[$i],
                                'jumlah' => $this->request->getVar('qty')[$i],
                                'tarif' => $this->request->getVar('biaya_amount')[$i],
                                'potongan' => $this->request->getVar('reduksi')[$i],
                                'pajak' => $this->request->getVar('pajak')[$i],
                                'total' => $this->request->getVar('harga')[$i]
                            ];

                            // $databillingdetail = [
                            //     'no_kwitansi' => $no_kwitansi,
                            //     'item_cd' => 'PD1408',
                            //     'jumlah' => '1',
                            //     'tarif' => '50.000',
                            //     'potongan' => '5.000',
                            //     'pajak' => '11',
                            //     'total' => '45.000'
                            // ];

                            // client request
                            // $response = akses_restapi('POST', $urlbillingdetail, $databillingdetail);
                            akses_restapi('POST', $urlbillingdetail, $databillingdetail);
                        } else {
                            // helper curl request
                            helper(['restclient']);

                            // endpoint
                            $url = "$this->server/tregistrasilayananlrmu/insert";

                            // form params
                            $data = [
                                "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
                                "layanan" => $this->request->getVar('layanan')[$i],
                                "item_cd" => $this->request->getVar('item_cd')[$i]
                            ];
                            // client request
                            $response = akses_restapi('POST', $url, $data);

                            // helper curl request
                            helper(['restclient']);

                            // endpoint
                            $urlbillingdetail = "$this->server/billingdetail/insert";

                            // form params
                            // $databillingdetail = [
                            //     'no_kwitansi' => 'KWT202410383',
                            //     'item_cd' => $this->request->getVar('item_cd')[$i],
                            //     'jumlah' => $this->request->getVar('qty')[$i],
                            //     'tarif' => $this->request->getVar('biaya_amount')[$i],
                            //     'potongan' => $this->request->getVar('item_cd')[$i],
                            //     'pajak' => $this->request->getVar('pajak')[$i],
                            //     'total' => $this->request->getVar('harga')[$i]
                            // ];

                            // $databillingdetail = [
                            //     'no_kwitansi' => 'KWT202410383',
                            //     'item_cd' => $this->request->getVar('item_cd')[$i],
                            //     'jumlah' => $this->request->getVar('qty')[$i],
                            //     'tarif' => $this->request->getVar('biaya_amount')[$i],
                            //     'potongan' => $this->request->getVar('item_cd')[$i],
                            //     'pajak' => $this->request->getVar('pajak')[$i],
                            //     'total' => $this->request->getVar('harga')[$i]
                            // ];

                            $databillingdetail = [
                                'no_kwitansi' => 'KWT202410389',
                                'item_cd' => 'PD1408',
                                'jumlah' => '1',
                                'tarif' => '50.000',
                                'potongan' => '5.000',
                                'pajak' => '11',
                                'total' => '45.000'
                            ];

                            // dd($databillingdetail);


                            // client request
                            // $response = akses_restapi('POST', $urlbillingdetail, $databillingdetail);
                            akses_restapi('POST', $urlbillingdetail, $databillingdetail);
                        }
                    }
                }
                /*--END LABORATORIUM--*/


                /*--START LABORATORIUM AI REFACTOR--*/
                // helper(['restclient']);

                // $layanan = $this->request->getVar('layanan');
                // $item_cd = $this->request->getVar('item_cd');
                // $no_registrasi = str_replace(" ", "_", trim($this->request->getVar('no_registrasi')));
                // $no_kwitansi = $this->request->getVar('no_kwitansi');

                // if (is_array($layanan) && count($layanan) > 0) {
                //     foreach ($layanan as $i => $layananVal) {
                //         $itemVal = $item_cd[$i] ?? '';
                //         if (trim($layananVal) != '' && trim($itemVal) != '') {
                //             $data = [
                //                 "no_registrasi" => $no_registrasi,
                //                 "layanan" => $layananVal,
                //                 "item_cd" => $itemVal
                //             ];
                //             akses_restapi('POST', "$this->server/tregistrasilayananlrmu/insert", $data);

                //             $databillingdetail = [
                //                 'no_kwitansi' => $no_kwitansi,
                //                 'item_cd' => $itemVal,
                //                 'jumlah' => $this->request->getVar('qty')[$i],
                //                 'tarif' => $this->request->getVar('biaya_amount')[$i],
                //                 'potongan' => $this->request->getVar('reduksi')[$i],
                //                 'pajak' => $this->request->getVar('pajak')[$i],
                //                 'total' => $this->request->getVar('harga')[$i]
                //             ];
                //             akses_restapi('POST', "$this->server/billingdetail/insert", $databillingdetail);
                //         }
                //     }
                // }
                /*--END LABORATORIUM--*/

                /*--START TINDAKAN--*/
                // helper curl request
                helper(['restclient']);
                // endpoint
                $url = "$this->server/tregistrasitindakan/double";
                // form params
                $data = [
                    "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
                    "resep" => $this->request->getVar('resep'),
                    "laboratorium" => $this->request->getVar('laboratorium'),
                    "radiologi" => $this->request->getVar('radiologi'),
                    "prosedur_primer" => $this->request->getVar('prosedur_primer'),
                    "prosedur_skunder" => $this->request->getVar('prosedur_skunder'),
                    "tatalaksana" => $this->request->getVar('tatalaksana'),
                    "reduksi" => $this->request->getVar('reduksi')
                ];
                // client request
                $response = akses_restapi('POST', $url, $data);
                /*--END TINDAKAN--*/

                $msg = [
                    'success' => 'data berhasil di create!'
                ];
            }

            echo json_encode($msg);
        }

        if ($this->request->getVar('action_all') == 'Draft') {
            helper(['form', 'url']);

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                // 'patient_no' => [
                //     'label' => 'Code',
                //     'rules' => 'required',
                //     'errors' => [
                //         //'required' => '{field} tidak boleh kosong',
                //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                //     ]
                // ],
                'keluhan_utama' => [
                    'label' => 'Keluhan Utama',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'riwayat_perjalanan_keluhan' => [
                    'label' => 'Riwayat Perjalanan Keluhan',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                // 'riwayat_penyakit_sekarang' => [
                //     'label' => 'Riwayat Penyakit Sekarang',
                //     'rules' => 'required',
                //     'errors' => [
                //         //'required' => '{field} tidak boleh kosong',
                //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                //     ]
                // ],
                'riwayat_penyakit_dahulu' => [
                    'label' => 'Riwayat Penyakit Dahulu',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'riwayat_operasi_pengobatan' => [
                    'label' => 'Riwayat Operasi Pengobatan',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'riwayat_penyakit_keluarga' => [
                    'label' => 'Riwayat Penyakit Keluarga',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'riwayat_lain' => [
                    'label' => 'Riwayat Lain',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'kondisi_umum' => [
                    'label' => 'Kondisi Umum',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'tinggi_badan' => [
                    'label' => 'Tinggi Badan',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'berat_badan' => [
                    'label' => 'Berat Badan',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'suhu' => [
                    'label' => 'Suhu',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'sistolik' => [
                    'label' => 'Sistolik',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'diastolik' => [
                    'label' => 'Diastolik',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'denyut_nadi' => [
                    'label' => 'Denyut_nadi',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'laju_nafas' => [
                    'label' => 'Laju Nafas',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'kondisi_khusus' => [
                    'label' => 'Kondisi Khusus',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'pemeriksaan_tambahan' => [
                    'label' => 'Pemeriksaan Tambahan',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'diagnosa_utama' => [
                    'label' => 'Diagnosa Utama',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'diagnosa_sekunder' => [
                    'label' => 'Diagnosa Sekunder',
                    'rules' => 'required',
                    'errors' => [
                        //'required' => '{field} tidak boleh kosong',
                        //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'keluhan_utama' => $validation->getError('keluhan_utama'), //START ANAMNESA
                        'riwayat_perjalanan_keluhan' => $validation->getError('riwayat_perjalanan_keluhan'),
                        'riwayat_penyakit_sekarang' => $validation->getError('riwayat_penyakit_sekarang'),
                        'riwayat_penyakit_dahulu' => $validation->getError('riwayat_penyakit_dahulu'),
                        'riwayat_operasi_pengobatan' => $validation->getError('riwayat_operasi_pengobatan'),
                        'riwayat_penyakit_keluarga' => $validation->getError('riwayat_penyakit_keluarga'),
                        'riwayat_lain' => $validation->getError('riwayat_lain'), //END ANAMNESA

                        'kondisi_umum' => $validation->getError('kondisi_umum'), //START PERIKSA
                        'kondisi_khusus' => $validation->getError('kondisi_khusus'),
                        'tinggi_badan' => $validation->getError('tinggi_badan'),
                        'berat_badan' => $validation->getError('berat_badan'),
                        'sistolik' => $validation->getError('sistolik'),
                        'diastolik' => $validation->getError('diastolik'),
                        'denyut_nadi' => $validation->getError('denyut_nadi'),
                        'laju_nafas' => $validation->getError('laju_nafas'),
                        'suhu' => $validation->getError('suhu'),
                        'pemeriksaan_tambahan' => $validation->getError('pemeriksaan_tambahan'), //END PERIKSA

                        'diagnosa_utama' => $validation->getError('diagnosa_utama'), //START DIAGNOSA
                        'diagnosa_sekunder' => $validation->getError('diagnosa_sekunder') //END DIAGNOSA
                    ]
                ];
            } else {

                /*--START SET STATUS DRAFT--*/
                // helper curl request
                helper(['restclient']);
                $no_registrasi = $this->request->getVar('no_registrasi');
                // endpoint
                $url = "$this->server/tregistrasi/draft/$no_registrasi";
                // client request
                $response = akses_restapi('PATCH', $url, []);
                $data['response_data'] = json_decode($response, true);
                /*--END SET STATUS DRAFT--*/

                /*--START ANAMNESA--*/
                // helper curl request
                helper(['restclient']);
                // endpoint
                $url = "$this->server/tregistrasianamnesa/double";
                // form params
                $data = [
                    "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
                    "responden" => $this->request->getVar('responden'),
                    "keluhan_utama" => $this->request->getVar('keluhan_utama'),
                    "riwayat_perjalanan_keluhan" => $this->request->getVar('riwayat_perjalanan_keluhan'),
                    "riwayat_penyakit_sekarang" => $this->request->getVar('riwayat_penyakit_sekarang'),
                    "riwayat_penyakit_dahulu" => $this->request->getVar('riwayat_penyakit_dahulu'),
                    "riwayat_operasi_pengobatan" => $this->request->getVar('riwayat_operasi_pengobatan'),
                    "riwayat_penyakit_keluarga" => $this->request->getVar('riwayat_penyakit_keluarga'),
                    "riwayat_lain" => $this->request->getVar('riwayat_lain')
                ];
                // client request
                $response = akses_restapi('POST', $url, $data);
                /*--END ANAMNESA--*/

                /*--START PERIKSA--*/
                // helper curl request
                helper(['restclient']);
                // endpoint
                $url = "$this->server/tregistrasiperiksa/double";
                // form params
                $data = [
                    "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
                    "kondisi_umum" => $this->request->getVar('kondisi_umum'),
                    "kondisi_khusus" => $this->request->getVar('kondisi_khusus'),
                    "tinggi_badan" => $this->request->getVar('tinggi_badan'),
                    "berat_badan" => $this->request->getVar('berat_badan'),
                    "sistolik" => $this->request->getVar('sistolik'),
                    "diastolik" => $this->request->getVar('diastolik'),
                    "denyut_nadi" => $this->request->getVar('denyut_nadi'),
                    "laju_nafas" => $this->request->getVar('laju_nafas'),
                    "suhu" => $this->request->getVar('suhu'),
                    "bmi" => $this->request->getVar('bmi'),
                    "pemeriksaan_tambahan" => $this->request->getVar('pemeriksaan_tambahan')
                ];
                // client request
                $response = akses_restapi('POST', $url, $data);
                /*--END PERIKSA--*/

                /*--START DIAGNOSA--*/
                // helper curl request
                helper(['restclient']);
                // endpoint
                $url = "$this->server/tregistrasidiagnosa/double";
                // form params
                $data = [
                    "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
                    "diagnosa_utama" => $this->request->getVar('diagnosa_utama'),
                    "icd10_utama" => $this->request->getVar('icd10_utama'),
                    "klasifikasi_utama" => $this->request->getVar('klasifikasi_utama'),
                    "diagnosa_sekunder" => $this->request->getVar('diagnosa_sekunder'),
                    "icd10_sekunder" => $this->request->getVar('icd10_sekunder'),
                    "klasifikasi_sekunder" => $this->request->getVar('klasifikasi_sekunder'),
                    "diagnosa_utama_sta" => $this->request->getVar('diagnosa_utama_sta'),
                    "diagnosa_sekunder_sta" => $this->request->getVar('diagnosa_sekunder_sta')
                ];
                // client request
                $response = akses_restapi('POST', $url, $data);
                /*--END DIAGNOSA--*/

                /*--START ALERGI--*/
                $alergi = $this->request->getVar('kategori_alergi');
                $alergi_no = $this->request->getVar('alergi_no');
                $number = count($alergi);
                if ($number > 0) {
                    for ($i = 0; $i < $number; $i++) {

                        if (trim($alergi[$i] != '') && trim($alergi_no[$i] != '')) {

                            // helper curl request
                            helper(['restclient']);

                            // endpoint
                            $url = "$this->server/tpatientalergi/update";

                            // form params
                            $data = [
                                "patient_no" => str_replace(" ", "_", trim($this->request->getVar('patient_no'))),
                                "kategori" => $this->request->getVar('kategori_alergi')[$i],
                                "komponen" => $this->request->getVar('komponen_alergi')[$i],
                                "reaksi" => $this->request->getVar('reaksi_alergi')[$i],
                                "alergi_no" => $this->request->getVar('alergi_no')[$i]
                            ];
                            // client request
                            $response = akses_restapi('PUT', $url, $data);
                        } else {
                            // helper curl request
                            helper(['restclient']);

                            // endpoint
                            $url = "$this->server/tpatientalergi/insert";

                            // form params
                            $data = [
                                "patient_no" => str_replace(" ", "_", trim($this->request->getVar('patient_no'))),
                                "kategori" => $this->request->getVar('kategori_alergi')[$i],
                                "komponen" => $this->request->getVar('komponen_alergi')[$i],
                                "reaksi" => $this->request->getVar('reaksi_alergi')[$i]
                            ];
                            // client request
                            $response = akses_restapi('POST', $url, $data);
                        }
                    }
                }
                /*--END ALERGI--*/

                /*--START DIAGNOSA TAMBAHAN--*/
                $diagnosa = $this->request->getVar('diagnosa_tambahan');
                $seq_id = $this->request->getVar('seq_id');
                if (isset($diagnosa)) {
                    $number = count($diagnosa);
                    if ($number > 0) {
                        for ($i = 0; $i < $number; $i++) {
                            if (trim($diagnosa[$i] != '') && trim($seq_id[$i] != '')) {
                                // helper curl request
                                helper(['restclient']);
                                // endpoint
                                $url = "$this->server/tregistrasidiagnosatambahan/update";
                                // form params
                                $data = [
                                    "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
                                    "diagnosa" => $this->request->getVar('diagnosa_tambahan')[$i],
                                    "icd10" => $this->request->getVar('icd10_tambahan')[$i],
                                    "klasifikasi" => $this->request->getVar('klasifikasi_tambahan')[$i],
                                    "seq_id" => $this->request->getVar('seq_id')[$i]
                                ];
                                // client request
                                $response = akses_restapi('PUT', $url, $data);
                            } else {
                                // helper curl request
                                helper(['restclient']);
                                // endpoint
                                $url = "$this->server/tregistrasidiagnosatambahan/insert";
                                // form params
                                $data = [
                                    "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
                                    "diagnosa" => $this->request->getVar('diagnosa_tambahan')[$i],
                                    "icd10" => $this->request->getVar('icd10_tambahan')[$i],
                                    "klasifikasi" => $this->request->getVar('klasifikasi_tambahan')[$i]
                                ];
                                // client request
                                $response = akses_restapi('POST', $url, $data);
                            }
                        }
                    }
                }
                /*--END DIAGNOSA TAMBAHAN--*/

                /*--START LABORATORIUM--*/
                $layanan = $this->request->getVar('layanan');
                $item_cd = $this->request->getVar('item_cd');
                $number = count($layanan);
                if ($number > 0) {
                    for ($i = 0; $i < $number; $i++) {

                        if (trim($layanan[$i] != '') && trim($item_cd[$i] != '')) {

                            // helper curl request
                            helper(['restclient']);

                            // endpoint
                            if ($layanan == 'LY_003') {
                                $url = "$this->server/tregistrasilayananradiologi/update";
                            }

                            if ($layanan == 'LY_004') {
                                $url = "$this->server/tregistrasilayananlrmu/update";
                            }


                            // form params
                            $data = [
                                "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
                                "layanan" => $this->request->getVar('layanan')[$i],
                                "item_cd" => $this->request->getVar('item_cd')[$i]
                            ];
                            // client request
                            $response = akses_restapi('PUT', $url, $data);
                        } else {
                            // helper curl request
                            helper(['restclient']);

                            // endpoint
                            if ($layanan == 'LY_003') {
                                $url = "$this->server/tregistrasilayananradiologi/insert";
                            }

                            if ($layanan == 'LY_004') {
                                $url = "$this->server/tregistrasilayananlrmu/insert";
                            }

                            // form params
                            $data = [
                                "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
                                "layanan" => $this->request->getVar('layanan')[$i],
                                "item_cd" => $this->request->getVar('item_cd')[$i]
                            ];
                            // client request
                            $response = akses_restapi('POST', $url, $data);
                        }
                    }
                }
                /*--END LABORATORIUM--*/

                // /*--START LABORATORIUM--*/
                // $layanan = $this->request->getVar('layanan_lab');
                // $item_cd = $this->request->getVar('item_cd_lab');
                // $number = count($layanan);
                // if ($number > 0) {
                //     for ($i = 0; $i < $number; $i++) {

                //         if (trim($layanan[$i] != '') && trim($item_cd[$i] != '')) {

                //             // helper curl request
                //             helper(['restclient']);

                //             // endpoint
                //             $url = "$this->server/tregistrasilayananradiologi/update";

                //             // form params
                //             $data = [
                //                 "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
                //                 "layanan" => $this->request->getVar('layanan_lab')[$i],
                //                 "item_cd" => $this->request->getVar('item_cd_lab')[$i]
                //             ];
                //             // client request
                //             $response = akses_restapi('PUT', $url, $data);
                //         } else {
                //             // helper curl request
                //             helper(['restclient']);

                //             // endpoint
                //             $url = "$this->server/tregistrasilayananradiologi/insert";

                //             // form params
                //             $data = [
                //                 "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
                //                 "layanan" => $this->request->getVar('layanan_lab')[$i],
                //                 "item_cd" => $this->request->getVar('item_cd_lab')[$i]
                //             ];
                //             // client request
                //             $response = akses_restapi('POST', $url, $data);
                //         }
                //     }
                // }
                // /*--END LABORATORIUM--*/

                /*--START TINDAKAN--*/
                // helper curl request
                helper(['restclient']);
                // endpoint
                $url = "$this->server/tregistrasitindakan/double";
                // form params
                $data = [
                    "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
                    "resep" => $this->request->getVar('resep'),
                    "laboratorium" => $this->request->getVar('laboratorium'),
                    "radiologi" => $this->request->getVar('radiologi'),
                    "prosedur_primer" => $this->request->getVar('prosedur_primer'),
                    "prosedur_skunder" => $this->request->getVar('prosedur_skunder'),
                    "tatalaksana" => $this->request->getVar('tatalaksana'),
                    "reduksi" => $this->request->getVar('reduksi')
                ];
                // client request
                $response = akses_restapi('POST', $url, $data);
                /*--END TINDAKAN--*/

                $msg = [
                    'success' => 'data berhasil di create!'
                ];
                // } 
            }

            echo json_encode($msg);
        }


        // } else {
        //     exit('Maaf tidak dapat diproses!');
        // }
    }

    public function delete_alergi()
    {
        if ($this->request->isAJAX()) {
            $patient_no = $this->request->getVar('patient_no');
            $alergi_no = $this->request->getVar('alergi_no');

            // helper curl request
            helper(['restclient']);

            // endpoint
            $url = "$this->server/tpatientalergi/delete/$patient_no/$alergi_no";

            // client request
            $response = akses_restapi('DELETE', $url, []);
            $data['response_data'] = json_decode($response, true);

            $msg = [
                'success' => "Data dengan no pasien $patient_no dan no alergi $alergi_no berhasil dihapus"
            ];
            echo json_encode($msg);
        }
    }

    public function delete_diagnosa()
    {
        if ($this->request->isAJAX()) {
            $no_registrasi = $this->request->getVar('no_registrasi');
            $seq_id = $this->request->getVar('seq_id');

            // helper curl request
            helper(['restclient']);

            // endpoint
            $url = "$this->server/tregistrasidiagnosatambahan/delete/$no_registrasi/$seq_id";

            // client request
            $response = akses_restapi('DELETE', $url, []);
            $data['response_data'] = json_decode($response, true);

            $msg = [
                'success' => "Data dengan no pasien $no_registrasi dan seq $seq_id berhasil dihapus"
            ];
            echo json_encode($msg);
        }
    }

    // function action2()
    // {
    //     if ($this->request->isAJAX()) {
    //         if ($this->request->getVar('action2')) {
    //             helper(['form', 'url']);

    //             $validation = \Config\Services::validation();
    //             $valid = $this->validate([
    //                 // 'no_registrasi' => [
    //                 //     'label' => 'No. Registrasi',
    //                 //     'rules' => 'required',
    //                 //     'errors' => [
    //                 //         //'required' => '{field} tidak boleh kosong',
    //                 //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                 //     ]
    //                 // ],
    //                 'nadi' => [
    //                     'label' => 'Nadi',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ],
    //                 'suhu' => [
    //                     'label' => 'Suhu',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ],
    //                 'nafas' => [
    //                     'label' => 'Nafas',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ],
    //                 'tekanan_darah' => [
    //                     'label' => 'Tekanan Darah',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ],
    //                 'tinggi_badan' => [
    //                     'label' => 'Tinggi Badan',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ],
    //                 'berat_badan' => [
    //                     'label' => 'Berat Badan',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ],
    //                 'keluhan_utama' => [
    //                     'label' => 'Keluhan Utama',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ],
    //                 'keluhan_sekunder' => [
    //                     'label' => 'Keluhan Sekunder',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ],
    //                 'diagnosa_utama' => [
    //                     'label' => 'Diagnosa Utama',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ],
    //                 'diagnosa_sekunder' => [
    //                     'label' => 'Diagnosa Sekunder',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ],
    //                 'diagnosa_note' => [
    //                     'label' => 'Diagnosa Note',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ],
    //                 'pf_rambut' => [
    //                     'label' => 'Rambut',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ],
    //                 'pf_mata' => [
    //                     'label' => 'Mata',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ],
    //                 'pf_telinga' => [
    //                     'label' => 'Telinga',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ],
    //                 'pf_hidung' => [
    //                     'label' => 'Hidung',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ],
    //                 'pf_tenggorokan' => [
    //                     'label' => 'Tenggorokan',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ],
    //                 'reduksi_persen' => [
    //                     'label' => 'Reduksi',
    //                     'rules' => 'required|greater_than[0]|less_than[101]|numeric',
    //                     'errors' => [
    //                         //'required' => '{field} tidak boleh kosong',
    //                         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                     ]
    //                 ]
    //                 // ,
    //                 // 'photo' => [
    //                 //     'label' => 'Photo',
    //                 //     'rules' => 'required',
    //                 //     'errors' => [
    //                 //         //'required' => '{field} tidak boleh kosong',
    //                 //         //'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
    //                 //     ]
    //                 // ]
    //             ]);
    //             if (!$valid) {
    //                 $msg = [
    //                     'error' => [
    //                         'no_registrasi' => $validation->getError('no_registrasi'),
    //                         'patient_no' => $validation->getError('patient_no'),
    //                         'keluhan' => $validation->getError('keluhan'),
    //                         'anamnesa' => $validation->getError('anamnesa'),
    //                         'nadi' => $validation->getError('nadi'),
    //                         'suhu' => $validation->getError('suhu'),
    //                         'nafas' => $validation->getError('nafas'),
    //                         'tekanan_darah' => $validation->getError('tekanan_darah'),
    //                         'tinggi_badan' => $validation->getError('tinggi_badan'),
    //                         'berat_badan' => $validation->getError('berat_badan'),
    //                         'keluhan_utama' => $validation->getError('keluhan_utama'),
    //                         'keluhan_sekunder' => $validation->getError('keluhan_sekunder'),
    //                         'diagnosa_utama' => $validation->getError('diagnosa_utama'),
    //                         'diagnosa_sekunder' => $validation->getError('diagnosa_sekunder'),
    //                         'diagnosa_note' => $validation->getError('diagnosa_note'),
    //                         'pf_rambut' => $validation->getError('pf_rambut'),
    //                         'pf_mata' => $validation->getError('pf_mata'),
    //                         'pf_telinga' => $validation->getError('pf_telinga'),
    //                         'pf_hidung' => $validation->getError('pf_hidung'),
    //                         'pf_tenggorokan' => $validation->getError('pf_tenggorokan'),
    //                         'reduksi_persen' => $validation->getError('reduksi_persen'),
    //                     ]
    //                 ];
    //             } else {

    //                 if ($this->request->getVar('action2') == 'Add') {

    //                     // helper curl request
    //                     helper(['restclient']);

    //                     $no_registrasi = $this->session->get('no_registrasi');

    //                     // endpoint
    //                     $url = "$this->server/tregistrasi/konsultasidokter/$no_registrasi";

    //                     // client request
    //                     $response = akses_restapi('PATCH', $url, []);
    //                     $data['response_data'] = json_decode($response, true);

    //                     // // endpoint
    //                     // $url = "$this->server/tmedicalrecord/insert";

    //                     // // form params
    //                     // $data = [
    //                     //     "patient_no" => str_replace(" ", "_", trim($this->request->getVar('patient_no'))),
    //                     //     "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
    //                     //     "fullname" => $this->request->getVar('fullname'),
    //                     //     "tgl_pemeriksaan" => $this->request->getVar('tgl_pemeriksaan'),
    //                     //     "keluhan" => $this->request->getVar('keluhan'),
    //                     //     "anamnesa" => $this->request->getVar('anamnesa')
    //                     // ];
    //                     // // client request
    //                     // $response = akses_restapi('POST', $url, $data);


    //                     // endpoint
    //                     $url = "$this->server/tregistrasipemeriksaanawal/insert";

    //                     // form params
    //                     $data = [
    //                         // "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('no_registrasi'))),
    //                         "no_registrasi" => $no_registrasi,
    //                         "nadi" => $this->request->getVar('nadi'),
    //                         "suhu" => $this->request->getVar('suhu'),
    //                         "nafas" => $this->request->getVar('nafas'),
    //                         "tekanan_darah" => $this->request->getVar('tekanan_darah'),
    //                         "tinggi_badan" => $this->request->getVar('tinggi_badan'),
    //                         "berat_badan" => $this->request->getVar('berat_badan')
    //                     ];
    //                     // client request
    //                     $response = akses_restapi('POST', $url, $data);



    //                     // endpoint
    //                     $url = "$this->server/tregistrasipemeriksaanumum/insert";

    //                     // form params RG000001
    //                     $data = [
    //                         // "no_registrasi" => str_replace(" ", "_", trim($this->request->getVar('patient_no'))),
    //                         "no_registrasi" => $no_registrasi,
    //                         "keluhan_utama" => $this->request->getVar('keluhan_utama'),
    //                         "keluhan_sekunder" => $this->request->getVar('keluhan_sekunder'),
    //                         "diagnosa_utama" => $this->request->getVar('diagnosa_utama'),
    //                         "diagnosa_sekunder" => $this->request->getVar('diagnosa_sekunder'),
    //                         "diagnosa_note" => $this->request->getVar('diagnosa_note'),
    //                         "pf_rambut" => $this->request->getVar('pf_rambut'),
    //                         "pf_mata" => $this->request->getVar('pf_mata'),
    //                         "pf_telinga" => $this->request->getVar('pf_telinga'),
    //                         "pf_hidung" => $this->request->getVar('pf_hidung'),
    //                         "pf_tenggorokan" => $this->request->getVar('pf_tenggorokan'),
    //                         "photo" => $this->request->getVar('medrec_id') . '_' . $no_registrasi
    //                     ];
    //                     // client request
    //                     $response = akses_restapi('POST', $url, $data);

    //                     // endpoint
    //                     $url = "$this->server/tregistrasipemeriksaaninfo/insert";

    //                     // form params
    //                     $data = [
    //                         "no_registrasi" => $no_registrasi,
    //                         "reduksi_persen" => $this->request->getVar('reduksi_persen'),
    //                         "reduksi_jumlah" => $this->request->getVar('suhu')
    //                     ];
    //                     // client request
    //                     $response = akses_restapi('POST', $url, $data);


    //                     // endpoint
    //                     $url = "$this->server/tpatientalergi/insert";

    //                     // form params
    //                     $data = [
    //                         "patient_no" => $this->request->getVar('patient_no'),
    //                         "alergi" => $this->request->getVar('alergi'),
    //                         "reported_dt" => $this->request->getVar('reported_dt')
    //                     ];
    //                     // client request
    //                     $response = akses_restapi('POST', $url, $data);


    //                     // // helper curl request
    //                     // helper(['restclient']);

    //                     // // endpoint
    //                     // $url = "$this->server/tregistrasi/konsultasidokter/$no_registrasi";

    //                     // // client request
    //                     // $response = akses_restapi('PATCH', $url, []);
    //                     // $data['response_data'] = json_decode($response, true);

    //                     $msg = [
    //                         'success' => 'data berhasil di create!'
    //                     ];
    //                 }
    //             }

    //             echo json_encode($msg);
    //         }
    //     } else {
    //         exit('Maaf tidak dapat diproses!');
    //     }
    // }

    public function draw()
    {
        $this->data['title'] = ' | ' . $_ENV['APP_TITLE'];

        return view('konsultasidokter/draw', $this->data);
    }

    public function draw1()
    {
        $this->data['title'] = ' | ' . $_ENV['APP_TITLE'];

        return view('konsultasidokter/draw1', $this->data);
    }

    public function draw2()
    {
        $this->data['title'] = ' | ' . $_ENV['APP_TITLE'];

        return view('konsultasidokter/draw2', $this->data);
    }

    public function draw3()
    {
        $this->data['title'] = ' | ' . $_ENV['APP_TITLE'];

        return view('konsultasidokter/draw3', $this->data);
    }

    public function draw4()
    {
        $this->data['title'] = ' | ' . $_ENV['APP_TITLE'];

        return view('konsultasidokter/draw4', $this->data);
    }

    public function draw5()
    {
        $this->data['title'] = ' | ' . $_ENV['APP_TITLE'];

        return view('konsultasidokter/draw5', $this->data);
    }

    public function draw6()
    {
        $this->data['title'] = ' | ' . $_ENV['APP_TITLE'];

        return view('konsultasidokter/draw6', $this->data);
    }

    public function draw7()
    {
        $this->data['title'] = ' | ' . $_ENV['APP_TITLE'];

        return view('konsultasidokter/draw7', $this->data);
    }

    public function doupload()
    {
        helper('form');


        if ($this->request->isAJAX()) {
            $nobp = $this->request->getVar('nobp');

            $validation = \Config\Services::validation();

            if ($this->request->getPost('gambar') == '') {
                $msg = ['error' => 'Silahkan klik ambil gambar...'];
            } else {

                //cek dulu fotonya
                // $cekdata = $this->mhs->find($nobp);
                // $fotolama = $cekdata['foto'];
                // if ($fotolama != NULL || $fotolama != "") {
                //     unlink($fotolama);
                // }


                $image = $this->request->getPost('gambar');
                $image = str_replace('data:image/jpeg;base64,', '', $image);

                $image = base64_decode($image);
                // echo $image;
                $filename = $nobp . '.jpg';
                // $filename = 'yoyo' . '.jpg';
                file_put_contents(FCPATH . '/assets/img/titikkeluhan/' . $filename, $image);

                // $updatedata = [
                //     'foto' => './assets/images/foto/' . $filename
                // ];

                // $this->mhs->update($nobp, $updatedata);
                $msg = [
                    'success' => 'Gambar berhasil di upload'
                ];
            }


            echo json_encode($msg);
        }
    }

    public function doupload1()
    {
        helper('form');


        if ($this->request->isAJAX()) {
            $image_nm = $this->request->getVar('image_nm');
            $no_registrasi = $this->request->getVar('no_registrasi');

            $validation = \Config\Services::validation();

            if ($this->request->getPost('gambar') == '') {
                $msg = ['error' => 'Silahkan klik ambil gambar...'];
            } else {

                $image = $this->request->getPost('gambar');
                $image = str_replace('data:image/jpeg;base64,', '', $image);

                $image = base64_decode($image);

                $filename = $image_nm . '.jpg';

                file_put_contents(FCPATH . '/assets/img/titikkeluhan/' . $filename, $image);

                // endpoint
                $url = "$this->server/ttitikkeluhan/insert";

                // form params
                $data = [
                    "no_registrasi" => $no_registrasi,
                    "image" => $image_nm
                ];
                // client request
                $response = akses_restapi('POST', $url, $data);

                $msg = [
                    'success' => 'Gambar berhasil di upload'
                ];
            }


            echo json_encode($msg);
        }
    }

    public function apiDropdown($nama)
    {
        // helper curl request
        helper(['restclient']);
        // endpoint
        $url = "$this->server/dropdown/tfield_value/$nama";
        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);
        return $data['response_data'];
    }

    public function apiDropdownItem($nama)
    {
        // helper curl request
        helper(['restclient']);
        // endpoint
        $url = "$this->server/dropdown/tfield_value/$nama";
        // client request
        $response = akses_restapi('GET', $url, []);
        $data['response_data'] = json_decode($response, true);
        return $data['response_data'];
    }

    public function ajaxKategoriAlergi($nama)
    {
        // $searchTerm = $this->request->getVar('search');
        $results = $this->apiDropdown($nama);

        // Generate array with filtered records  
        $data_array = array();
        if (count($results) > 0) {
            for ($d = 0; $d < count($results); $d++) {
                $data['id'] = $results[$d]['fld_valu'];
                $data['text'] = $results[$d]['fld_desc'];
                array_push($data_array, $data);
            }
        }

        return $this->response->setJSON($data_array);
    }

    public function ajaxKategoriBiaya($nama)
    {
        $results = $this->apiDropdown($nama);

        // Generate array with filtered records  
        $data_array = array();
        if (count($results) > 0) {
            for ($d = 0; $d < count($results); $d++) {
                $data['id'] = $results[$d]['fld_valu'];
                $data['text'] = $results[$d]['fld_desc'];
                array_push($data_array, $data);
            }
        }

        return $this->response->setJSON($data_array);
    }

    public function ajaxItem($nama)
    {
        $results = $this->apiDropdown($nama);

        // Generate array with filtered records  
        $data_array = array();
        if (count($results) > 0) {
            for ($d = 0; $d < count($results); $d++) {
                $data['id'] = $results[$d]['fld_valu'];
                $data['text'] = $results[$d]['fld_desc'];
                array_push($data_array, $data);
            }
        }

        return $this->response->setJSON($data_array);
    }


    // public function fetchAll()
    // {
    //     if ($this->request->isAJAX()) {
    //         $output = '';
    //         $data =  $this->apiDataGetAll();
    //         $output .= '
    //         <div class="table-responsive">
    //                 <table id="example4" class="table table-hover table-striped">
    //                 <thead>
    //                         <tr>  
    //                             <th>Patient No</th>
    //                             <th>Full Name</th>
    //                             <th>ID No</th>
    //                             <th>Gender</th>
    //                             <th>Address</th>
    //                             <th>Mobile</th>
    //                             <th>Birth Date</th>
    //                             <th></th>
    //                         </tr>
    //                     </thead>
    //                         ';
    //         if ($data == '') {
    //             $output .= '<tr>  
    //                         <td >Data not Found</td>
    //                         <td ></td>
    //                         <td ></td>
    //                         <td ></td>
    //                         <td ></td>
    //                         <td ></td>
    //                         <td ></td>
    //                         <td ></td>
    //                     </tr>';
    //         } else {
    //             for ($a = 0; $a < count($data); $a++) {
    //                 $output .= '  
    //                 <tr id="addMdlBarang" data-id="' . $data[$a]["patient_no"] . '">
    //                     <td >' . $data[$a]["patient_no"] . '</td>
    //                     <td >' . $data[$a]["fullname"] . '</td>
    //                     <td >' . $data[$a]["id_no"] . '</td>
    //                     <td >' . $data[$a]["gender"] . '</td>
    //                     <td >' . $data[$a]["addr"] . '</td>
    //                     <td >' . $data[$a]["mobile_no"] . '</td>
    //                     <td >' . date('d/m/Y', strtotime($data[$a]["birth_dt"])) . '</td>
    //                     <td>
    //                         <button type="button" class="btn btn-danger btn-sm float-right mr-1 mt-1 delete btn-fix-w" data-patient_no="' . $data[$a]["patient_no"] . '" >
    //                             <i class="fas fa-trash"></i>
    //                         </button>
    //                         <button type="button" class="btn btn-primary btn-sm float-right mr-1 mt-1 edit btn-fix-w" data-patient_no="' . $data[$a]["patient_no"] . '" >
    //                             <i class="fas fa-tags"></i>
    //                         </button>
    //                         <a href="' . base_url('/patient/fetchSingleDataPrint/') . $data[$a]['patient_no'] . '" target="_blank" class="btn btn-warning btn-sm float-right mr-1 mt-1 print btn-fix-w" > <i class="fas fa-print"></i></a>
    //                     </td>
    //                 </tr>  
    //         ';
    //             }
    //         }
    //         $output .= '</table></div>
    //         <script type="text/javascript">
    //         $(function() {
    //             $("#example4").DataTable({
    //                 columnDefs: [{
    //                     orderable: false,
    //                     targets: 7
    //                 }],
    //                 "dom": "Bfplit",
    //                 "buttons": [
    //                     "copy", "csv", "excel", "pdf", "print"
    //                 ],
    //                 "paging": false,
    //                 "lengthChange": true,
    //                 "searching": false,
    //                 "info": false,
    //                 "autoWidth": false
    //             });
    //         });
    //         </script>
    //         ';
    //         echo $output;
    //     } else {
    //         exit('Maaf tidak dapat diproses!');
    //     }
    // }
}
