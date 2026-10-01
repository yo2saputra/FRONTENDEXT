<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdfgenerator;

class Tmstformulir extends BaseController
{
    protected $data = [];

    public function index()
    {
        $this->data['title'] = 'Menu Formulir Pasien';
        return view('input_data/index', $this->data);
    }

    public function input($jenis)
    {
        $this->data['title'] = 'Input ' . strtoupper($jenis);
        $this->data['jenis'] = $jenis;

        $viewMap = [
            'cppt'       => 'input_data/form_perkembangan_input',
            'discharge'  => 'input_data/form_discharge_input',
            'pulang'     => 'input_data/form_pulang_input',
            'observasi'  => 'input_data/form_observasi_input',
            'operasi'    => 'input_data/form_operasi_input',
            'rawatJalan' => 'input_data/form_rawatJalan_input'
        ];

        if (!array_key_exists($jenis, $viewMap)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view($viewMap[$jenis], $this->data);
    }

    public function save($jenis)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to('/tmstformulir');
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Data ' . strtoupper($jenis) . ' berhasil diproses!'
        ]);
    }

    public function view_pdf($pdf_name, $pdf_title, $pdf_data, $pdf_paper, $pdf_orientation, $pdf_format)
    {
        $Pdfgenerator = new Pdfgenerator();
        $this->data['title_pdf'] = $pdf_title;
        $this->data['d'] = $pdf_data;

        $html = view($pdf_format, $this->data);
        $Pdfgenerator->generate($html, $pdf_name, $pdf_paper, $pdf_orientation);
    }

    public function cetak($jenis)
    {
        $pdf_paper = 'A4';
        $pdf_orientation = 'portrait';
        $pdf_data = [];

        if ($jenis == 'discharge') {
            $pdf_format = 'input_data/form_discharge_dompdf';
            $pdf_data = [
                'nama' => 'Ny. Aliyah', 'rm' => '22 10 38 21', 'jk' => 'P', 'tgl_lahir' => '14/11/1990',
                'alamat' => 'Surabaya', 'tgl_periksa' => '10/10/2025', 'diagnosa' => 'FAM',
                'kontrol_waktu' => 'Rabu, 15/10/2025', 'kontrol_tempat' => 'Poli Bedah',
                'perawatan' => 'Kompres dingin', 'diet' => 'Tinggi Protein', 'obat1' => 'Kaltrofen', 'obat2' => 'Cefixim'
            ];
        } elseif ($jenis == 'pulang') {
            $pdf_format = 'input_data/form_pulang_dompdf';
            $pdf_data = [
                'nama' => 'Ny. Aliyah', 'rm' => '22 10 38 21', 'jk' => 'P', 'tgl_lahir' => '14/11/1990',
                'alamat' => 'Surabaya', 'tgl_periksa' => '10/10/2025', 'diagnosa' => 'FAM (S)',
                'bb' => '54', 'tb' => '158', 'tensi' => '110/80', 'nadi' => '80', 'rr' => '20', 'suhu' => '36',
                'obat_klinik' => '-', 'obat_pulang' => "Kaltofen 2x1\nCefixim 2x1",
                'lab' => '-', 'usg' => '1', 'thorax' => '-', 'lain' => '-', 'edukasi' => 'Istirahat cukup',
                'kontrol_hari' => 'Rabu', 'kontrol_poli' => 'Bedah', 'kontrol_bawa' => 'Hasil USG', 'perawat' => 'Suster Siti'
            ];
        } elseif ($jenis == 'cppt') {
            $pdf_format = 'input_data/form_perkembangan_dompdf';
            $pdf_data = [
                'nama' => 'Ny. Aliyah', 'rm' => '22 10 38 21', 'tgl_lahir' => '14/11/1990', 'jk' => 'P',
                'rows' => [['tgl' => '22/10/25', 'jam' => '09.00', 'ppa' => 'Perawat', 'soap' => 'S: Nyeri berkurang', 'instruksi' => 'Lanjut obat', 'verif' => 'Sr. Siti']]
            ];
        } elseif ($jenis == 'observasi') {
            $pdf_format = 'input_data/form_observasi';
            $pdf_data = [
                'nama' => 'Ny. Aliyah', 'rm' => '22 10 38 21', 'tgl_lahir' => '14/11/1990', 'diagnosis' => 'FAM',
                'tindakan' => 'Biopsi', 'pra_ku' => 'Baik', 'pra_td' => '120/80', 'pra_suhu' => '36.5', 'pra_nadi' => '80', 
                'pra_rr' => '20', 'pra_spo2' => '98', 'intra_ku' => 'Stabil', 'dokter' => 'dr. Bedah', 
                'obat_anestesi' => 'Lidocaine', 'jam_mulai' => '10.00', 'jam_selesai' => '10.30', 'catatan' => 'Normal',
                'perawat' => 'Sr. Siti', 'dokter_nama' => 'dr. Bedah, Sp.B', 'kota_tgl' => 'Surabaya, 10/10/2025'
            ];
        } elseif ($jenis == 'operasi') {
            $pdf_format = 'input_data/form_operasi'; 

            $pdf_data = [
                'nama' => 'Ny. Aliyah', 'rm' => '22 10 38 21', 'tgl_lahir' => '14/11/1990',
                'diagnosis' => 'Fibro Adenoma Mammae', 
                'jns_anestesi' => 'Lokal Anestesi', 
                'obat_anestesi' => 'Lidocaine 2% Infiltrasi', 
                'tgl_tindakan' => '10/10/2025', 
                'dokter' => 'dr. Bedah, Sp.B',
                'jenis_tindakan' => 'MIBS / Biopsi',
                'signin_jam' => '08:00', 
                'signin_identitas' => 'v',
                'signin_consent' => 'v',
                'signin_lokasi' => 'Ya',
                'signin_diagnosa' => 'Tumor Mammae S',
                'signin_td' => '120/80', 'signin_n' => '80', 'signin_s' => '36', 'signin_rr' => '20',
                'signin_alergi' => 'Tidak ada', 'signin_aspirasi' => 'Tidak', 'signin_darah' => 'Tidak',
                'timeout_jam' => '08:15', 'timeout_tim' => 'v', 'timeout_inst' => 'v', 'timeout_kassa' => 'v', 'timeout_jarum' => 'v',
                'verb_tgl' => 'v', 'verb_nama' => 'v', 'verb_lokasi' => 'v', 'verb_identitas' => 'v', 'verb_prosedur' => 'v', 'verb_consent' => 'v',
                'timeout_ab' => 'Ya', 'timeout_ab_nama' => 'Cefazolin', 'timeout_ab_dosis' => '1 gr', 'timeout_ab_jam' => '07:30',
                'signout_jam' => '09:00', 'signout_inst' => 'v', 'signout_kassa' => 'v', 'signout_jarum' => 'v',
                'signout_spesimen' => 'Ya', 'signout_jenis' => 'PA',
                'signout_td' => '120/80', 'signout_n' => '82', 'signout_s' => '36.5', 'signout_rr' => '20',
                'signout_gcs' => '15', 'signout_nyeri' => '2', 'signout_rembes' => 'Tidak ada rembesan',
                'signout_instruksi' => 'Observasi TTV tiap 15 menit',
                'ttd_signin' => 'Sr. Siti', 'ttd_timeout' => 'Sr. Siti', 'ttd_signout' => 'Sr. Siti'
            ];
        } elseif ($jenis == 'rawatJalan') {
            $pdf_format = 'input_data/form_rawatJalan';
            
            $pdf_data = [
            'nama'           => 'Ny. Aliyah',
            'rm'             => '22 10 38 21',
            'tgl_lahir'      => '14/11/1990',
            'jk'             => 'P',
            
            'kajian_a_ya'    => 'v', 
            'kajian_a_tidak' => '',
            'kajian_b_ya'    => '',
            'kajian_b_tidak' => 'v', 
            
            'hasil_risiko'   => 'sedang', 
            
            'act_1_ya'       => '',
            'act_1_tidak'    => 'v',
            'act_2_ya'       => 'v',
            'act_2_tidak'    => '',
            'act_2_ttd'      => 'Sr. Siti', 
            'act_3_ya'       => '',
            'act_3_tidak'    => 'v',
            'act_3_ttd'      => ''
    

            ];

        } 
        
        
        else {
            return redirect()->to('/tmstformulir');
        }

        $this->view_pdf('' . $jenis, 'Laporan ' . strtoupper($jenis), $pdf_data, $pdf_paper, $pdf_orientation, $pdf_format);
    }
}