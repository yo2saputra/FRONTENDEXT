<!DOCTYPE html>
<html>
<head>
    <title><?= $title_pdf ?></title>
    <style>
        @page { margin: 10mm 15mm 15mm 15mm; size: A4 portrait; }
        body { font-family: Arial, Helvetica, sans-serif; font-size: 10px; line-height: 1.3; color: #000; margin: 0; }

        table { width: 100%; border-collapse: collapse; border-spacing: 0; }
        td, th { vertical-align: top; padding: 2px 4px; font-family: Arial, Helvetica, sans-serif; font-size: 10px; }

        .box-outer { border: 1px solid black; }
        .bb { border-bottom: 1px solid black; }
        .br { border-right: 1px solid black; }

        .bold { font-weight: bold; }
        .text-center { text-align: center; }

        .cb {
            display: inline-block; width: 11px; height: 11px;
            border: 1px solid black; margin-right: 4px;
            text-align: center; line-height: 10px; font-size: 10px;
            font-family: DejaVu Sans, Arial, sans-serif;
            vertical-align: middle;
        }

        .data-line {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: normal;
            border-bottom: 1px dotted black;
            display: inline-block;
            min-height: 12px;
            vertical-align: bottom;
            word-wrap: break-word;
            word-break: break-word;
            white-space: normal;
        }

        .data-line-block {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: normal;
            border-bottom: 1px dotted black;
            display: block;
            min-height: 14px;
            word-wrap: break-word;
            word-break: break-word;
            white-space: normal;
            width: 100%;
            padding: 2px 0;
        }

        .w-full  { width: 95%; }
        .w-half  { width: 45%; }
        .w-short { width: 150px; }

        #footer {
            position: fixed; bottom: 0px; left: 0px; right: 0px; height: 20px;
            border-top: 1px solid #ccc; padding-top: 4px; font-size: 8px; color: #444;
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>
<body>

<?php
function cb($checked = false) {
    return '<span class="cb">' . ($checked ? '&#10004;' : '&nbsp;') . '</span>';
}

$keadaan = strtolower($d['keadaan_pulang'] ?? '');

$is_sembuh    = str_contains($keadaan, 'sembuh');
$is_jalan     = str_contains($keadaan, 'jalan') || str_contains($keadaan, 'berobat');
$is_pindah    = str_contains($keadaan, 'pindah');
$is_paksa     = str_contains($keadaan, 'paksa');
$is_lari      = str_contains($keadaan, 'lari');
$is_meninggal = str_contains($keadaan, 'meninggal');

$path_png  = FCPATH . 'assets/img/logo-medicelle.png';
$path_jpg  = FCPATH . 'assets/img/logo-medicelle.jpg';
$path_jpeg = FCPATH . 'assets/img/logo-medicelle.jpeg';
$path_final = '';
if (file_exists($path_png))       { $path_final = $path_png; }
elseif (file_exists($path_jpg))   { $path_final = $path_jpg; }
elseif (file_exists($path_jpeg))  { $path_final = $path_jpeg; }

$base64 = '';
if ($path_final != '') {
    $type   = pathinfo($path_final, PATHINFO_EXTENSION);
    $data_img = file_get_contents($path_final);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data_img);
}
?>

    <div id="footer">
        <table width="100%" style="table-layout:fixed;">
            <tr>
                <td width="25%">+62 31 3000 8008</td>
                <td width="25%">+62 31 3000 9009</td>
                <td width="25%">info@medicelle.co.id</td>
                <td width="25%" align="right">www.medicelle.co.id</td>
            </tr>
        </table>
    </div>

    <!-- HEADER -->
    <table style="margin-bottom: 5px;">
        <tr>
            <td width="60%">
                <?php if ($base64): ?>
                    <img src="<?= $base64 ?>" style="height: 45px; width: auto; display: block; margin-bottom: 5px;" alt="Logo MedicElle">
                <?php endif; ?>
                <div style="font-size: 8px;">Jl. Raya Gubeng No. 11, Surabaya - 60281</div>
            </td>
            <td width="40%" class="text-center" style="vertical-align: middle;">
                <div style="font-size: 13px; font-weight: bold;">LEMBAR DISCHARGE PLANNING</div>
            </td>
        </tr>
    </table>

    <div class="box-outer">

        <!-- IDENTITAS PASIEN -->
        <table class="bb">
            <tr>
                <td width="55%" class="br" style="padding:0;">
                    <table style="width:100%;">
                        <tr><td width="30%">Nama Pasien</td><td width="2%">:</td><td class="bold"><?= htmlspecialchars($d['nama']) ?></td></tr>
                        <tr><td>Jenis Kelamin</td><td>:</td><td class="bold"><?= htmlspecialchars($d['jk']) ?></td></tr>
                        <tr><td>Tanggal Lahir</td><td>:</td><td class="bold"><?= htmlspecialchars($d['tgl_lahir']) ?></td></tr>
                    </table>
                </td>
                <td width="45%" style="padding:0;">
                    <table style="width:100%;">
                        <tr><td width="35%">NO. RM</td><td width="2%">:</td><td class="bold"><?= htmlspecialchars($d['rm']) ?></td></tr>
                        <tr><td>Alamat</td><td>:</td><td class="bold"><?= htmlspecialchars($d['alamat'] ?? '') ?></td></tr>
                        <tr><td>Tanggal Pemeriksaan</td><td>:</td><td class="bold"><?= htmlspecialchars($d['tgl_periksa']) ?></td></tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- DIAGNOSA -->
        <div class="bb" style="padding:3px 5px;">
            <span class="bold">Diagnosa Medis :</span>
            <span class="data-line w-full"><?= htmlspecialchars($d['diagnosa']) ?></span>
        </div>

        <!-- KEADAAN PULANG -->
        <div class="bb" style="padding:3px 5px;">
            <div class="bold" style="margin-bottom:3px;">Dipulangkan dari Klinik dalam keadaan :</div>
            <table width="100%">
                <tr>
                    <td width="50%"><?= cb($is_sembuh) ?> Sembuh</td>
                    <td width="50%"><?= cb($is_paksa)  ?> Pulang Paksa</td>
                </tr>
                <tr>
                    <td><?= cb($is_jalan)   ?> Meneruskan Berobat Jalan</td>
                    <td><?= cb($is_lari)    ?> Lari</td>
                </tr>
                <tr>
                    <td><?= cb($is_pindah)  ?> Pindah ke Klinik/RS Lain</td>
                    <td><?= cb($is_meninggal) ?> Meninggal</td>
                </tr>
            </table>
        </div>

        <!-- A. KONTROL -->
        <div class="bb" style="padding:3px 5px;">
            <div class="bold">A. Kontrol</div>
            <table width="100%" style="margin-left:10px;">
                <tr>
                    <td width="5">a.</td>
                    <td width="40">Waktu</td>
                    <td width="5">:</td>
                    <td><span class="data-line w-full"><?= htmlspecialchars($d['kontrol_waktu']) ?></span></td>
                </tr>
                <tr>
                    <td>b.</td>
                    <td>Tempat</td>
                    <td>:</td>
                    <td><span class="data-line w-full"><?= htmlspecialchars($d['kontrol_tempat']) ?></span></td>
                </tr>
            </table>
        </div>

        <!-- B. PERAWATAN DI RUMAH -->
        <div class="bb" style="padding:3px 5px;">
            <div class="bold">B. Lanjutan Perawatan di Rumah (luka operasi, pemasangan gips, pengobatan dan lain-lain)</div>
            <div style="margin-top:3px;">
                <?= cb(!empty(trim($d['perawatan1'] ?? ''))) ?>
                <span class="data-line w-full"><?= htmlspecialchars($d['perawatan1'] ?? '') ?></span>
            </div>
            <div style="margin-top:5px;">
                <?= cb(!empty(trim($d['perawatan2'] ?? ''))) ?>
                <span class="data-line w-full"><?= htmlspecialchars($d['perawatan2'] ?? '') ?></span>
            </div>
        </div>

        <!-- C. DIET/NUTRISI -->
        <div class="bb" style="padding:3px 5px;">
            <div class="bold">C. Aturan Diet/Nutrisi</div>
            <div style="margin-top:3px;">
                <?= cb(!empty(trim($d['diet1'] ?? ''))) ?>
                <span class="data-line w-full"><?= htmlspecialchars($d['diet1'] ?? '') ?></span>
            </div>
            <div style="margin-top:5px;">
                <?= cb(!empty(trim($d['diet2'] ?? ''))) ?>
                <span class="data-line w-full"><?= htmlspecialchars($d['diet2'] ?? '') ?></span>
            </div>
        </div>

        <!-- D. OBAT -->
        <div class="bb" style="padding:3px 5px;">
            <div class="bold">D. Obat-obatan yang masih diminum dan jumlahnya</div>
            <div style="margin-top:3px;">
                <?= cb(!empty(trim($d['obat1'] ?? ''))) ?>
                <span class="data-line w-full"><?= htmlspecialchars($d['obat1'] ?? '') ?></span>
            </div>
            <div style="margin-top:5px;">
                <?= cb(!empty(trim($d['obat2'] ?? ''))) ?>
                <span class="data-line w-full"><?= htmlspecialchars($d['obat2'] ?? '') ?></span>
            </div>
        </div>

        <!-- E. AKTIVITAS -->
        <div class="bb" style="padding:3px 5px;">
            <div class="bold">E. Aktivitas dan Istirahat</div>
            <div style="margin-top:3px;">
                <?= cb(!empty(trim($d['aktivitas1'] ?? ''))) ?>
                <span class="data-line w-full"><?= htmlspecialchars($d['aktivitas1'] ?? '') ?></span>
            </div>
            <div style="margin-top:5px;">
                <?= cb(!empty(trim($d['aktivitas2'] ?? ''))) ?>
                <span class="data-line w-full"><?= htmlspecialchars($d['aktivitas2'] ?? '') ?></span>
            </div>
        </div>

        <!-- F. HASIL PEMERIKSAAN -->
        <div class="bb" style="padding:3px 5px;">
            <div class="bold">F. Hasil Pemeriksaan Penunjang, Surat Keterangan Istirahat :</div>
            <div style="margin-top:3px;">
                <?= cb(!empty(trim($d['hasil_surat1'] ?? ''))) ?>
                <span class="data-line w-full"><?= htmlspecialchars($d['hasil_surat1'] ?? '') ?></span>
            </div>
            <div style="margin-top:5px;">
                <?= cb(!empty(trim($d['hasil_surat2'] ?? ''))) ?>
                <span class="data-line w-full"><?= htmlspecialchars($d['hasil_surat2'] ?? '') ?></span>
            </div>
        </div>

        <!-- G. LAIN-LAIN -->
        <div style="padding:3px 5px; min-height:30px;">
            <div class="bold">G. Lain-lain :</div>
            <?php if (!empty($d['lain_lain'])): ?>
            <div style="margin-top:3px;">
                <span class="data-line-block"><?= htmlspecialchars($d['lain_lain']) ?></span>
            </div>
            <?php endif; ?>
        </div>

    </div>

    <!-- TANGGAL TTD -->
    <div style="margin-top:5px; font-size:10px;">
        Surabaya,
        <span class="data-line" style="min-width:120px; text-align:center;"><?= htmlspecialchars($d['tgl_periksa']) ?></span>
    </div>

    <!-- TTD -->
    <table class="box-outer" style="margin-top:5px; width:100%;">
        <tr>
            <td width="33%" class="text-center br" style="padding-top:10px;">
                Pasien / Keluarga<br><br><br><br><br>
                (
                <span style="display:inline-block; min-width:120px; border-bottom:1px solid #000; text-align:center;">
                    <?= htmlspecialchars($d['pasien_keluarga']) ?>
                </span>
                )
            </td>
            <td width="33%" class="text-center br" style="padding-top:10px;">
                Mengetahui,<br>Dokter<br><br><br><br>
                (
                <span style="display:inline-block; min-width:120px; border-bottom:1px solid #000; text-align:center;">
                    <?= htmlspecialchars($d['usr_dokter']) ?>
                </span>
                )
            </td>
            <td width="33%" class="text-center" style="padding-top:10px;">
                Perawat<br><br><br><br><br>
                (
                <span style="display:inline-block; min-width:120px; border-bottom:1px solid #000; text-align:center;">
                    <?= htmlspecialchars($d['usr_perawat']) ?>
                </span>
                )
            </td>
        </tr>
    </table>

</body>
</html>