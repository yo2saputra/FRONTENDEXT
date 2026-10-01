<!DOCTYPE html>
<html>
<head>
    <title><?= $title_pdf ?></title>
    <style>
        @page { margin: 20mm; size: A4 portrait; }
        body { font-family: Arial, sans-serif; font-size: 10px; line-height: 1.3; color: #000; margin: 0; }
        
        table { width: 100%; border-collapse: collapse; border-spacing: 0; }
        td, th { vertical-align: top; padding: 4px 5px; }
        
        .box { border: 1px solid black; }
        .bt { border-top: 1px solid black; }
        .bb { border-bottom: 1px solid black; }
        .br { border-right: 1px solid black; }
        .bl { border-left: 1px solid black; }
        
        .bold { font-weight: bold; }
        .text-center { text-align: center; }
        .bg-gray { background-color: #e0e0e0; }
        
        .fill { font-family: 'Courier New', Courier, monospace; font-weight: bold; font-size: 11px; }
        .dots-time { border-bottom: 1px dotted black; display: inline-block; min-width: 40px; text-align: center; }
        .dotted-line { border-bottom: 1px dotted black; display: inline-block; min-width: 80px; }
        
        .spacer { height: 10px; }
        .mb-5 { margin-bottom: 5px; }
    </style>
</head>
<body>

    <?php

        
        $path_png = FCPATH . 'assets/img/Logo_MedicElle.png';
        $path_jpg = FCPATH . 'assets/img/Logo_MedicElle.jpg';
        $path_jpeg = FCPATH . 'assets/img/Logo_MedicElle.jpeg';
        
        $path_final = '';
        if(file_exists($path_png)) { $path_final = $path_png; }
        elseif(file_exists($path_jpg)) { $path_final = $path_jpg; }
        elseif(file_exists($path_jpeg)) { $path_final = $path_jpeg; }
        
        $base64 = '';
        if ($path_final != '') {
            $type = pathinfo($path_final, PATHINFO_EXTENSION);
            $data = file_get_contents($path_final);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
    ?>

    <div class="box">
        <table class="bb">
            <tr>
                <td width="40%" style="padding: 10px;">
                    <?php if($base64): ?>
                        <img src="<?= $base64 ?>" style="height: 50px; width: auto;" alt="Logo MedicElle">
                    <?php else: ?>
                    <?php endif; ?>
                    
                    <div style="font-size: 8px; margin-top: 5px;">Jl. Raya Gubeng No. 11, Surabaya - 60281</div>
                </td>
                <td width="60%" class="text-center" style="vertical-align: middle;">
                    <div class="bold" style="font-size: 16px;">SURGICAL SAFETY CHECKLIST</div>
                </td>
            </tr>
        </table>

        <table class="bb">
            <tr>
                <td width="15%">Nama</td><td width="1%">:</td>
                <td width="29%" class="fill"><?= $d['nama'] ?></td>
                
                <td width="20%">Diagnosa</td><td width="1%">:</td>
                <td width="34%" class="fill"><?= $d['diagnosis'] ?></td>
            </tr>
            <tr>
                <td>No.RM</td><td>:</td><td class="fill"><?= $d['rm'] ?></td>
                <td>Jenis Anestesi</td><td>:</td><td class="fill"><?= $d['obat_anestesi'] ?></td>
            </tr>
            <tr>
                <td>Tanggal Lahir</td><td>:</td><td class="fill"><?= $d['tgl_lahir'] ?></td>
                <td style="white-space: nowrap;">Obat Anestesi Yang Diberikan</td><td>:</td>
                <td class="fill"><?= $d['obat_anestesi'] ?></td>
            </tr>
            <tr>
                <td>Tanggal Tindakan</td><td>:</td><td class="fill"><?= $d['tgl_tindakan'] ?></td>
                <td>Dokter Operator</td><td>:</td><td class="fill"><?= $d['dokter'] ?></td>
            </tr>
            <tr>
                <td>Jenis Tindakan</td><td>:</td><td class="fill"><?= $d['jenis_tindakan'] ?></td>
                <td colspan="3"></td>
            </tr>
        </table>

        <table style="width: 100%;">
            <tr>
                <td width="33%" class="br" style="padding: 0; vertical-align: top;">
                    <div class="bg-gray bb text-center bold" style="padding: 6px;">
                        SIGN IN (Jam : <span class="fill dots-time"><?= $d['signin_jam'] ?></span> wib)<br>
                        <span style="font-size: 8px; font-weight: normal;">(Sebelum Induksi)</span>
                    </div>
                    
                    <div style="padding: 8px;"> 
                        <div class="bold mb-5">Verifikasi</div>
                        <div>(<?= $d['signin_identitas'] == 'v' ? 'v' : ' ' ?>) Identitas pasien</div>
                        <div>(<?= $d['signin_consent'] == 'v' ? 'v' : ' ' ?>) Informed consent</div>
                        
                        <div class="spacer"></div>
                        <div class="bold mb-5">Pemberian tanda di lokasi operasi</div>
                        <div>(<?= $d['signin_lokasi'] == 'Ya' ? 'v' : ' ' ?>) Ya</div>
                        <div>(<?= $d['signin_lokasi'] != 'Ya' ? 'v' : ' ' ?>) Tidak</div>

                        <div class="spacer"></div>
                        <div class="bold mb-5">Diagnosa pasien</div>
                        <div class="fill" style="border-bottom: 1px dotted black; min-height: 14px; margin-bottom: 5px;">
                            <?= $d['signin_diagnosa'] ?>
                        </div>

                        <div class="spacer"></div>
                        <div class="bold mb-5">Pemeriksaan TTV</div>
                        <table width="100%" style="margin-bottom: 5px;">
                            <tr><td>TD: <span class="fill"><?= $d['signin_td'] ?></span></td><td>N: <span class="fill"><?= $d['signin_n'] ?></span></td></tr>
                            <tr><td>S: <span class="fill"><?= $d['signin_s'] ?></span></td><td>RR: <span class="fill"><?= $d['signin_rr'] ?></span></td></tr>
                        </table>

                        <div class="spacer"></div>
                        <div class="bold mb-5">Riwayat Alergi</div>
                        <div>(<?= $d['signin_alergi'] != 'Tidak ada' ? 'v' : ' ' ?>) Ada, sebutkan: <span class="fill"><?= $d['signin_alergi'] != 'Tidak ada' ? $d['signin_alergi'] : '...' ?></span></div>
                        <div>(<?= $d['signin_alergi'] == 'Tidak ada' ? 'v' : ' ' ?>) Tidak ada</div>

                        <div class="spacer"></div>
                        <div class="bold mb-5">Risiko Aspirasi & Gangguan Nafas</div>
                        <div>(<?= $d['signin_aspirasi'] == 'Ya' ? 'v' : ' ' ?>) Ya</div>
                        <div>(<?= $d['signin_aspirasi'] != 'Ya' ? 'v' : ' ' ?>) Tidak</div>

                        <div class="spacer"></div>
                        <div class="bold mb-5">Risiko Perdarahan</div>
                        <div>(<?= $d['signin_darah'] == 'Ya' ? 'v' : ' ' ?>) Ya</div>
                        <div>(<?= $d['signin_darah'] != 'Ya' ? 'v' : ' ' ?>) Tidak</div>
                        
                        <div style="height: 30px;"></div> 
                    </div>
                </td>

                <td width="34%" class="br" style="padding: 0; vertical-align: top;">
                    <div class="bg-gray bb text-center bold" style="padding: 6px;">
                        TIME OUT (Jam : <span class="fill dots-time"><?= $d['timeout_jam'] ?></span> wib)<br>
                        <span style="font-size: 8px; font-weight: normal;">(Sebelum Insisi)</span>
                    </div>

                    <div style="padding: 8px;">
                        <div class="bold mb-5">Kelengkapan Tim dan Fasilitas Operasi</div>
                        <div>(<?= $d['timeout_tim'] == 'v' ? 'v' : ' ' ?>) Lengkap</div>
                        <div>( ) Tidak lengkap, Karena <span style="border-bottom: 1px dotted black; width: 30px; display:inline-block;"></span></div>

                        <div class="spacer"></div>
                        <div class="bold mb-5">Pemeriksaan Kelengkapan Alat Operasi</div>
                        <div>(<?= $d['timeout_inst'] == 'v' ? 'v' : ' ' ?>) Instrument</div>
                        <div>(<?= $d['timeout_kassa'] == 'v' ? 'v' : ' ' ?>) Kassa</div>
                        <div>(<?= $d['timeout_jarum'] == 'v' ? 'v' : ' ' ?>) Jarum</div>

                        <div class="spacer"></div>
                        <div class="bold mb-5">Baca Secara Verbal</div>
                        <div>(<?= $d['verb_tgl'] == 'v' ? 'v' : ' ' ?>) Tanggal Tindakan</div>
                        <div>(<?= $d['verb_nama'] == 'v' ? 'v' : ' ' ?>) Nama Tindakan</div>
                        <div>(<?= $d['verb_lokasi'] == 'v' ? 'v' : ' ' ?>) Lokasi Tindakan</div>
                        <div>(<?= $d['verb_identitas'] == 'v' ? 'v' : ' ' ?>) Identitas Pasien</div>
                        <div>(<?= $d['verb_prosedur'] == 'v' ? 'v' : ' ' ?>) Prosedur Tindakan</div>
                        <div>(<?= $d['verb_consent'] == 'v' ? 'v' : ' ' ?>) Informed Consent</div>

                        <div class="spacer"></div>
                        <div class="bold mb-5">Antibiotik Profilaksis</div>
                        <div style="font-size: 10px; margin-bottom: 3px;">apakah diberikan dalam waktu kurang dari 60 menit</div>
                        <div>(<?= $d['timeout_ab'] != 'Tidak' ? 'v' : ' ' ?>) Tidak</div>
                        
                        <div>
                            (<?= $d['timeout_ab'] == 'Ya' ? 'v' : ' ' ?>) Iya, Nama obat: 
                            <span class="fill dotted-line"><?= $d['timeout_ab_nama'] ?></span>
                        </div>
                        <div style="padding-left: 14px;">
                            Dosis Obat : 
                            <span class="fill dotted-line"><?= $d['timeout_ab_dosis'] ?></span>
                        </div>
                        <div style="padding-left: 14px;">
                            Jam diberikan : 
                            <span class="fill dotted-line"><?= $d['timeout_ab_jam'] ?></span>
                        </div>
                    </div>
                </td>

                <td width="33%" style="padding: 0; vertical-align: top;">
                    <div class="bg-gray bb text-center bold" style="padding: 6px;">
                        SIGN OUT (Jam : <span class="fill dots-time"><?= $d['signout_jam'] ?></span> wib)<br>
                        <span style="font-size: 8px; font-weight: normal;">(Sebelum Keluar Kamar Operasi)</span>
                    </div>

                    <div style="padding: 8px;">
                        <div class="bold mb-5">Kelengkapan sebelum luka operasi ditutup</div>
                        <div>(<?= $d['signout_inst'] == 'v' ? 'v' : ' ' ?>) Instrument</div>
                        <div>(<?= $d['signout_kassa'] == 'v' ? 'v' : ' ' ?>) Kassa</div>
                        <div>(<?= $d['signout_jarum'] == 'v' ? 'v' : ' ' ?>) Jarum</div>

                        <div class="spacer"></div>
                        <div class="bold mb-5">Kelengkapan bahan pemeriksaan</div>
                        <div class="mb-5"><span class="bold">&bull; Preparat</span></div>
                        <div>&nbsp;&nbsp;(<?= $d['signout_spesimen'] == 'Ya' ? 'v' : ' ' ?>) Ya</div>
                        <div>&nbsp;&nbsp;(<?= $d['signout_spesimen'] != 'Ya' ? 'v' : ' ' ?>) Tidak</div>
                        
                        <div class="mt-5 mb-5"><span class="bold">&bull; Jenis</span></div>
                        <div>&nbsp;&nbsp;(<?= $d['signout_jenis'] == 'PA' ? 'v' : ' ' ?>) PA &nbsp;&nbsp;&nbsp; (<?= $d['signout_jenis'] == 'Lain' ? 'v' : ' ' ?>) Lainnya: ...</div>
                        <div>&nbsp;&nbsp;(<?= $d['signout_jenis'] == 'Kultur' ? 'v' : ' ' ?>) Kultur &nbsp; ( ) Tidak ada</div>
                        <div>&nbsp;&nbsp;(<?= $d['signout_jenis'] == 'Sitologi' ? 'v' : ' ' ?>) Sitologi</div>

                        <div class="spacer"></div>
                        <div class="bold mb-5">Pemeriksaan TTV :</div>
                        <table width="100%" style="margin-bottom: 5px;">
                            <tr><td>TD: <span class="fill"><?= $d['signout_td'] ?></span></td><td>N: <span class="fill"><?= $d['signout_n'] ?></span></td></tr>
                            <tr><td>S: <span class="fill"><?= $d['signout_s'] ?></span></td><td>RR: <span class="fill"><?= $d['signout_rr'] ?></span></td></tr>
                            <tr>
                                <td>GCS: <span class="fill"><?= $d['signout_gcs'] ?></span></td>
                                <td>Skala Nyeri: <span class="fill"><?= $d['signout_nyeri'] ?></span></td>
                            </tr>
                        </table>

                        <div class="bold mt-5 mb-5">Pemeriksaan Kembali Luka Operasi</div>
                        <div>(<?= $d['signout_rembes'] != 'Tidak ada rembesan' ? 'v' : ' ' ?>) Ada Rembesan</div>
                        <div>(<?= $d['signout_rembes'] == 'Tidak ada rembesan' ? 'v' : ' ' ?>) Tidak ada rembesan</div>

                        <div class="bold mt-5 mb-5">Instruksi Khusus :</div>
                        <div class="fill" style="border-bottom: 1px dotted black; min-height: 15px; margin-bottom: 3px;"><?= $d['signout_instruksi'] ?></div>
                        <div style="border-bottom: 1px dotted black; min-height: 15px; margin-bottom: 3px;"></div>
                    </div>
                </td>
            </tr>
        </table>

        <table class="bt" style="width: 100%;">
            <tr>
                <td width="33%" class="br text-center" style="vertical-align: bottom; padding-bottom: 15px;">
                    <div style="margin-bottom: 40px; margin-top: 5px; font-weight: bold;">TTD dan Nama Petugas</div>
                    <div style="height: 20px;"></div> 
                    <div style="font-weight: bold;">
                        ( <span class="fill dots-time"><?= $d['ttd_signin'] ?></span> )
                    </div>
                </td>
                
                <td width="34%" class="br text-center" style="vertical-align: bottom; padding-bottom: 15px;">
                    <div style="margin-bottom: 40px; margin-top: 5px; font-weight: bold;">TTD dan Nama Petugas</div>
                    <div style="height: 20px;"></div>
                    <div style="font-weight: bold;">
                        ( <span class="fill dots-time"><?= $d['ttd_timeout'] ?></span> )
                    </div>
                </td>
                
                <td width="33%" class="text-center" style="vertical-align: bottom; padding-bottom: 15px;">
                    <div style="margin-bottom: 40px; margin-top: 5px; font-weight: bold;">TTD dan Nama Petugas</div>
                    <div style="height: 20px;"></div>
                    <div style="font-weight: bold;">
                        ( <span class="fill dots-time"><?= $d['ttd_signout'] ?></span> )
                    </div>
                </td>
            </tr>
        </table>

    </div>

</body>
</html>