<!DOCTYPE html>
<html>
<head>
    <title><?= $title_pdf ?></title>
    <style>
        @page { margin: 15mm; size: A4 portrait; }
        body { font-family: Arial, sans-serif; font-size: 10px; line-height: 1.2; color: #000; margin: 0; }
        table { width: 100%; border-collapse: collapse; border-spacing: 0; }
        td, th { vertical-align: top; padding: 3px 5px; }
        .box { border: 1px solid black; }
        .bt { border-top: 1px solid black; }
        .bb { border-bottom: 1px solid black; }
        .br { border-right: 1px solid black; }
        .bl { border-left: 1px solid black; }
        .bold { font-weight: bold; }
        .text-center { text-align: center; }
        .bg-gray { background-color: #ffffff; }
        .fill {
            font-family: 'Courier New', Courier, monospace;
            font-weight: bold;
            font-size: 11px;
            display: block;
            word-break: break-word;
            overflow-wrap: break-word;
            white-space: normal;
        }
        span.fill {
            display: inline;
        }
        .dots-time { border-bottom: 1px dotted black; display: inline-block; min-width: 40px; text-align: center; }
        .dotted-line { border-bottom: 1px dotted black; display: inline-block; min-width: 80px; }
        .spacer { height: 8px; }
        .mb-5 { margin-bottom: 5px; }
        .check { font-family: 'Courier New', monospace; font-weight: bold; font-size: 12px; }
        .val-block {
            font-family: 'Courier New', Courier, monospace;
            font-weight: bold;
            font-size: 11px;
            display: block;
            word-break: break-word;
            overflow-wrap: break-word;
            white-space: normal;
            padding-left: 14px;
            margin-top: 3px;
            margin-bottom: 3px;
        }
    </style>
</head>
<body>

    <?php
        $path_png  = FCPATH . 'assets/img/logo-medicelle.png';
        $path_jpg  = FCPATH . 'assets/img/logo-medicelle.jpg';
        $path_jpeg = FCPATH . 'assets/img/logo-medicelle.jpeg';
        $path_final = '';
        if (file_exists($path_png)) { $path_final = $path_png; }
        elseif (file_exists($path_jpg)) { $path_final = $path_jpg; }
        elseif (file_exists($path_jpeg)) { $path_final = $path_jpeg; }

        $base64 = '';
        if ($path_final != '') {
            $type   = pathinfo($path_final, PATHINFO_EXTENSION);
            $data   = file_get_contents($path_final);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
    ?>

    <div class="box">
        <table class="bb">
            <tr>
                <td width="35%" style="padding: 10px;">
                    <?php if ($base64): ?>
                        <img src="<?= $base64 ?>" style="height: 45px; width: auto; display: block; margin-bottom: 5px;" alt="Logo MedicElle">
                    <?php endif; ?>
                    <div style="font-size: 8px;">Jl. Raya Gubeng No. 11, Surabaya - 60281</div>
                </td>
                <td width="65%" class="text-center" style="vertical-align: middle;">
                    <div class="bold" style="font-size: 16px;">SURGICAL SAFETY CHECKLIST</div>
                </td>
            </tr>
        </table>

        <table class="bb" style="table-layout: fixed;">
            <tr>
                <td width="15%" style="word-break: break-word;">Nama</td><td width="2%">:</td>
                <td width="33%" class="fill" style="word-break: break-word; overflow-wrap: break-word;"><?= $d['nama'] ?></td>
                <td width="15%" style="word-break: break-word;">Diagnosa</td><td width="2%">:</td>
                <td width="33%" class="fill" style="word-break: break-word; overflow-wrap: break-word;"><?= $d['diagnosis'] ?></td>
            </tr>
            <tr>
                <td style="word-break: break-word;">No. RM</td><td>:</td>
                <td class="fill" style="word-break: break-word; overflow-wrap: break-word;"><?= $d['rm'] ?></td>
                <td style="word-break: break-word;">Jenis Anestesi</td><td>:</td>
                <td class="fill" style="word-break: break-word; overflow-wrap: break-word;"><?= $d['jenis_anestesi'] ?></td>
            </tr>
            <tr>
                <td style="word-break: break-word;">Tanggal Lahir</td><td>:</td>
                <td class="fill" style="word-break: break-word; overflow-wrap: break-word;"><?= $d['tgl_lahir'] ?><?= !empty($d['gender']) ? ' / ' . $d['gender'] : '' ?></td>
                <td style="word-break: break-word;">Obat Anestesi</td><td>:</td>
                <td class="fill" style="word-break: break-word; overflow-wrap: break-word;"><?= $d['obat_anestesi'] ?></td>
            </tr>
            <tr>
                <td style="word-break: break-word;">Tgl Tindakan</td><td>:</td>
                <td class="fill" style="word-break: break-word; overflow-wrap: break-word;"><?= $d['tgl_tindakan'] ?></td>
                <td style="word-break: break-word;">Dokter Operator</td><td>:</td>
                <td class="fill" style="word-break: break-word; overflow-wrap: break-word;"><?= $d['dokter'] ?></td>
            </tr>
            <tr>
                <td style="word-break: break-word;">Jenis Tindakan</td><td>:</td>
                <td class="fill" style="word-break: break-word; overflow-wrap: break-word;"><?= $d['jenis_tindakan'] ?></td>
                <td colspan="3"></td>
            </tr>
        </table>

        <table style="width: 100%; table-layout: fixed;">
            <tr>
                <!-- SIGN IN -->
                <td width="33%" class="br" style="padding: 0; vertical-align: top;">
                    <div class="bg-gray bb text-center bold" style="padding: 6px;">
                        SIGN IN (Jam : <span class="fill dots-time"><?= $d['signin_jam'] ?></span>)<br>
                        <span style="font-size: 8px; font-weight: normal;">(Sebelum Induksi)</span>
                    </div>
                    <div style="padding: 8px;">
                        <div class="bold mb-5">Verifikasi</div>
                        <div>(<span class="check"><?= $d['signin_identitas'] ?></span>) Identitas pasien</div>
                        <div>(<span class="check"><?= $d['signin_consent'] ?></span>) Informed consent</div>

                        <div class="spacer"></div>
                        <div class="bold mb-5">Pemberian tanda di lokasi operasi</div>
                        <div>(<span class="check"><?= $d['signin_lokasi_ya'] ?></span>) Ya</div>
                        <div>(<span class="check"><?= $d['signin_lokasi_tidak'] ?></span>) Tidak</div>

                        <div class="spacer"></div>
                        <div class="bold mb-5">Diagnosa pasien</div>
                        <div class="fill" style="border-bottom: 1px dotted black; min-height: 12px; margin-bottom: 5px;">
                            <?= $d['signin_diagnosa'] ?>
                        </div>

                        <div class="spacer"></div>
                        <div class="bold mb-5">Pemeriksaan TTV</div>
                        <table width="100%">
                            <tr>
                                <td>TD: <span class="fill"><?= $d['signin_td'] ?></span></td>
                                <td>N: <span class="fill"><?= $d['signin_n'] ?></span></td>
                            </tr>
                            <tr>
                                <td>S: <span class="fill"><?= $d['signin_s'] ?></span></td>
                                <td>RR: <span class="fill"><?= $d['signin_rr'] ?></span></td>
                            </tr>
                        </table>

                        <div class="spacer"></div>
                        <div class="bold mb-5">Riwayat Alergi</div>
                        <?php if (trim($d['signin_alergi_tidak']) === 'v'): ?>
                            <div>() Ada:</div>
                            <div>(<span class="check">v</span>) Tidak ada</div>
                        <?php else: ?>
                            <div>(<span class="check">v</span>) Ada:</div>
                            <div class="val-block"><?= $d['signin_alergi_nama'] ?></div>
                            <div>() Tidak ada</div>
                        <?php endif; ?>

                        <div class="spacer"></div>
                        <div class="bold mb-5">Risiko Aspirasi & Gangguan Nafas</div>
                        <div>(<span class="check"><?= $d['signin_aspirasi_ya'] ?></span>) Ya</div>
                        <div>(<span class="check"><?= $d['signin_aspirasi_tidak'] ?></span>) Tidak</div>

                        <div class="spacer"></div>
                        <div class="bold mb-5">Risiko Perdarahan</div>
                        <div>(<span class="check"><?= $d['signin_darah_ya'] ?></span>) Ya</div>
                        <div>(<span class="check"><?= $d['signin_darah_tidak'] ?></span>) Tidak</div>
                    </div>
                </td>

                <!-- TIME OUT -->
                <td width="34%" class="br" style="padding: 0; vertical-align: top;">
                    <div class="bg-gray bb text-center bold" style="padding: 6px;">
                        TIME OUT (Jam : <span class="fill dots-time"><?= $d['timeout_jam'] ?></span>)<br>
                        <span style="font-size: 8px; font-weight: normal;">(Sebelum Insisi)</span>
                    </div>
                    <div style="padding: 8px;">
                        <div class="bold mb-5">Kelengkapan Tim & Fasilitas</div>
                        <?php if (trim($d['timeout_tim_lengkap']) === 'v'): ?>
                            <div>(<span class="check">v</span>) Lengkap</div>
                            <div>() Tidak lengkap:</div>
                        <?php else: ?>
                            <div>() Lengkap</div>
                            <div>(<span class="check">v</span>) Tidak lengkap:</div>
                            <div class="val-block"><?= $d['timeout_alasan'] ?></div>
                        <?php endif; ?>

                        <div class="spacer"></div>
                        <div class="bold mb-5">Pemeriksaan Kelengkapan Alat</div>
                        <div>(<span class="check"><?= $d['timeout_inst'] ?></span>) Instrumen</div>
                        <div>(<span class="check"><?= $d['timeout_kassa'] ?></span>) Kassa</div>
                        <div>(<span class="check"><?= $d['timeout_jarum'] ?></span>) Jarum</div>

                        <div class="spacer"></div>
                        <div class="bold mb-5">Pemeriksaan TTV</div>
                        <table width="100%">
                            <tr>
                                <td>TD: <span class="fill"><?= $d['timeout_td'] ?></span></td>
                                <td>N: <span class="fill"><?= $d['timeout_n'] ?></span></td>
                            </tr>
                            <tr>
                                <td>S: <span class="fill"><?= $d['timeout_s'] ?></span></td>
                                <td>RR: <span class="fill"><?= $d['timeout_rr'] ?></span></td>
                            </tr>
                        </table>

                        <div class="spacer"></div>
                        <div class="bold mb-5">Baca Secara Verbal</div>
                        <div>(<span class="check"><?= $d['verb_tgl'] ?></span>) Tanggal Tindakan</div>
                        <div>(<span class="check"><?= $d['verb_nama'] ?></span>) Nama Tindakan</div>
                        <div>(<span class="check"><?= $d['verb_lokasi'] ?></span>) Lokasi Tindakan</div>
                        <div>(<span class="check"><?= $d['verb_identitas'] ?></span>) Identitas Pasien</div>
                        <div>(<span class="check"><?= $d['verb_prosedur'] ?></span>) Prosedur Tindakan</div>
                        <div>(<span class="check"><?= $d['verb_consent'] ?></span>) Informed Consent</div>

                        <div class="spacer"></div>
                        <div class="bold mb-5">Antibiotik Profilaksis (&lt; 60 mnt)</div>
                        <?php if (trim($d['timeout_ab_tidak']) === 'v'): ?>
                            <div>(<span class="check">v</span>) Tidak</div>
                            <div>() Iya, Obat:</div>
                        <?php else: ?>
                            <div>() Tidak</div>
                            <div>(<span class="check">v</span>) Iya, Obat:</div>
                            <div class="val-block"><?= $d['timeout_ab_nama'] ?></div>
                            <div style="padding-left: 14px;">Dosis:</div>
                            <div class="val-block"><?= $d['timeout_ab_dosis'] ?></div>
                            <div style="padding-left: 14px;">Jam: <span class="fill"><?= $d['timeout_ab_jam'] ?></span></div>
                        <?php endif; ?>
                    </div>
                </td>

                <!-- SIGN OUT -->
                <td width="33%" style="padding: 0; vertical-align: top;">
                    <div class="bg-gray bb text-center bold" style="padding: 6px;">
                        SIGN OUT (Jam : <span class="fill dots-time"><?= $d['signout_jam'] ?></span>)<br>
                        <span style="font-size: 8px; font-weight: normal;">(Sebelum Keluar Kamar Operasi)</span>
                    </div>
                    <div style="padding: 8px;">
                        <div class="bold mb-5">Kelengkapan Sebelum Luka Ditutup</div>
                        <div>(<span class="check"><?= $d['signout_inst'] ?></span>) Instrumen</div>
                        <div>(<span class="check"><?= $d['signout_kassa'] ?></span>) Kassa</div>
                        <div>(<span class="check"><?= $d['signout_jarum'] ?></span>) Jarum</div>

                        <div class="spacer"></div>
                        <div class="bold mb-5">Kelengkapan Bahan Pemeriksaan</div>
                        <div class="bold">&bull; Preparat</div>
                        <div>(<span class="check"><?= $d['signout_spesimen_ya'] ?></span>) Ya (<span class="check"><?= $d['signout_spesimen_tidak'] ?></span>) Tidak</div>

                        <div class="spacer"></div>
                        <div class="bold">&bull; Jenis</div>
                        <div>(<span class="check"><?= $d['signout_jenis_pa'] ?></span>) PA (<span class="check"><?= $d['signout_jenis_kultur'] ?></span>) Kultur</div>
                        <div>(<span class="check"><?= $d['signout_jenis_sitologi'] ?></span>) Sitologi (<span class="check"><?= $d['signout_jenis_tidakada'] ?></span>) Tidak ada</div>
                        <?php if (trim($d['signout_jenis_lainnya']) === 'v'): ?>
                            <div>(<span class="check">v</span>) Lainnya:</div>
                            <div class="val-block"><?= $d['signout_jenis_lainnya_text'] ?></div>
                        <?php else: ?>
                            <div>() Lainnya:</div>
                        <?php endif; ?>

                        <div class="spacer"></div>
                        <div class="bold mb-5">Pemeriksaan TTV</div>
                        <table width="100%">
                            <tr><td>TD: <span class="fill"><?= $d['signout_td'] ?></span></td><td>N: <span class="fill"><?= $d['signout_n'] ?></span></td></tr>
                            <tr><td>S: <span class="fill"><?= $d['signout_s'] ?></span></td><td>RR: <span class="fill"><?= $d['signout_rr'] ?></span></td></tr>
                            <tr><td colspan="2">Nyeri: <span class="fill"><?= $d['signout_nyeri'] ?></span></td></tr>
                        </table>

                        <div class="spacer"></div>
                        <div class="bold mb-5">Pemeriksaan Kembali Luka</div>
                        <div>(<span class="check"><?= $d['signout_rembes_ada'] ?></span>) Ada Rembesan</div>
                        <div>(<span class="check"><?= $d['signout_rembes_tidak'] ?></span>) Tidak ada</div>

                        <div class="spacer"></div>
                        <div class="bold mb-5">Instruksi Khusus</div>
                        <div class="fill" style="border-bottom: 1px dotted black; min-height: 15px;"><?= $d['signout_instruksi'] ?></div>
                    </div>
                </td>
            </tr>
        </table>

        <table class="bt text-center">
            <tr>
                <td width="33%" class="br" style="padding-bottom: 20px;">
                    <div class="bold mb-5">TTD/Nama Petugas</div>
                    <div style="height: 40px;"></div>
                    <div class="fill">( <?= $d['ttd_signin'] ?> )</div>
                </td>
                <td width="34%" class="br" style="padding-bottom: 20px;">
                    <div class="bold mb-5">TTD/Nama Petugas</div>
                    <div style="height: 40px;"></div>
                    <div class="fill">( <?= $d['ttd_timeout'] ?> )</div>
                </td>
                <td width="33%" style="padding-bottom: 20px;">
                    <div class="bold mb-5">TTD/Nama Petugas</div>
                    <div style="height: 40px;"></div>
                    <div class="fill">( <?= $d['ttd_signout'] ?> )</div>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>