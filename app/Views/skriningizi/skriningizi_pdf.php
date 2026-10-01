<!DOCTYPE html>
<html>
<head>
    <title><?= $title_pdf ?></title>
    <style>
        @page { 
            margin: 15mm; 
            size: A4 portrait; 
        }
        body { 
            font-family: Arial, Helvetica, sans-serif; 
            font-size: 10px; 
            line-height: 1.3; 
            color: #000; 
            margin: 0; 
        }
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        td, th { vertical-align: middle; padding: 4px 6px; border: 1px solid black; }
        .no-border { border: none !important; }
        .text-center { text-align: center; }
        .text-bold { font-weight: bold; }
        .check {
            font-family: 'Courier New', monospace;
            font-weight: bold;
            font-size: 13px;
            display: inline-block;
            text-align: center;
            width: 14px;
        }
        .bg-gray { background-color: #ffffff; }
        .section-title {
            font-weight: bold;
            font-size: 11px;
            background-color: #ffffff;
            padding: 5px 8px;
            border: 1px solid black;
            border-bottom: none;
        }
        .keterangan {
            font-size: 8.5px;
            color: #444;
        }
        .catatan-box {
            font-size: 9px;
            border: 1px solid black;
            padding: 6px 8px;
            margin-top: 6px;
            background-color: #ffffff;
        }
    </style>
</head>
<body>

    <?php
        $path_png  = FCPATH . 'asset/img/Logo_MedicElle.png';
        $path_jpg  = FCPATH . 'asset/img/Logo_MedicElle.jpg';
        $path_jpeg = FCPATH . 'asset/img/Logo_MedicElle.jpeg';
        $path_final = '';
        if (file_exists($path_png))       { $path_final = $path_png; }
        elseif (file_exists($path_jpg))   { $path_final = $path_jpg; }
        elseif (file_exists($path_jpeg))  { $path_final = $path_jpeg; }
        $base64 = '';
        if ($path_final != '') {
            $type   = pathinfo($path_final, PATHINFO_EXTENSION);
            $data   = file_get_contents($path_final);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }

        $chk = function ($actual, $expected) {
            return ((string)$actual === (string)$expected) ? 'v' : '';
        };
    ?>

    <table class="no-border" width="100%" style="margin-bottom: 15px;">
        <tr class="no-border">
            <td width="20%" style="vertical-align: middle;" class="no-border">
                <?php if ($base64): ?>
                    <img src="<?= $base64 ?>" style="height: 50px; width: auto;" alt="Logo">
                <?php endif; ?>
            </td>
            <td width="60%" class="no-border text-center" align="center" style="vertical-align: middle;">
                <div class="text-bold" style="font-size: 13px;">FORMULIR SKRINING GIZI</div>
            </td>
            <td width="20%" class="no-border"></td>
        </tr>
    </table>

    <table style="margin-bottom: 15px;">
        <tr>
            <td width="12%">No. RM</td><td width="2%">:</td>
            <td width="36%"><?= htmlspecialchars($d['rm']) ?></td>
            <td width="12%">Jenis Kelamin</td><td width="2%">:</td>
            <td width="36%"><?= htmlspecialchars($d['gender']) ?></td>
        </tr>
        <tr>
            <td>Nama Pasien</td><td>:</td>
            <td><?= htmlspecialchars($d['nama']) ?></td>
            <td>Tanggal Lahir</td><td>:</td>
            <td><?= htmlspecialchars($d['tgl_lahir']) ?></td>
        </tr>
    </table>

    <?php if (($d['jenis'] ?? 'DEWASA') === 'DEWASA'): ?>

        <div class="section-title">SKRINING GIZI DEWASA</div>
        <table>
            <tr class="bg-gray text-center text-bold">
                <td width="5%">No</td>
                <td width="80%">Parameter</td>
                <td width="15%">Skor</td>
            </tr>
            <tr>
                <td class="text-center">1.</td>
                <td>
                    Apakah pasien mengalami penurunan BB yang tidak diinginkan dalam 6 bulan terakhir?<br><br>
                    A. Tidak ada penurunan berat badan
                    <span class="check">[<?= $chk($d['penurunanBeratBadan'] ?? '', '0') ?>]</span><br>
                    B. Tidak yakin/tidak tahu/terasa baju lebih longgar
                    <span class="check">[<?= $chk($d['penurunanBeratBadan'] ?? '', '2') ?>]</span><br>
                    C. Jika ya, berapa penurunan berat badan tersebut
                    <span class="check">[<?= (!empty($d['jumlahPenurunanBeratBadan'])) ? 'v' : '' ?>]</span>
                    <div style="padding-left: 16px; margin-top: 4px;">
                        1-5 kg <span class="check">[<?= $chk($d['jumlahPenurunanBeratBadan'] ?? '', '1') ?>]</span>&nbsp;&nbsp;
                        6-10 kg <span class="check">[<?= $chk($d['jumlahPenurunanBeratBadan'] ?? '', '2') ?>]</span>&nbsp;&nbsp;
                        11-15 kg <span class="check">[<?= $chk($d['jumlahPenurunanBeratBadan'] ?? '', '3') ?>]</span>&nbsp;&nbsp;
                        &gt; 15 kg <span class="check">[<?= $chk($d['jumlahPenurunanBeratBadan'] ?? '', '4') ?>]</span>
                    </div>
                </td>
                <td class="text-center">
                    <?= !empty($d['jumlahPenurunanBeratBadan']) ? htmlspecialchars($d['jumlahPenurunanBeratBadan']) : htmlspecialchars($d['penurunanBeratBadan'] ?? '0') ?>
                </td>
            </tr>
            <tr>
                <td class="text-center">2.</td>
                <td>Apakah asupan makanan berkurang karena tidak nafsu makan?</td>
                <td class="text-center">
                    Tidak <span class="check">[<?= $chk($d['asupanBerkurang'] ?? '', '0') ?>]</span>
                    &nbsp; Ya <span class="check">[<?= $chk($d['asupanBerkurang'] ?? '', '1') ?>]</span>
                </td>
            </tr>
            <tr>
                <td class="text-center">3.</td>
                <td>
                    Pasien dengan diagnosa khusus?
                    <div class="keterangan" style="margin-top: 3px;">
                        (Garis bawahi bila terdapat pada pasien, contoh: PPOK, Hemodialisis, Fraktur tulang punggung,
                        sirosis hati, hemodialisis, diabetes, kanker, bedah digestive, pneumonia berat, cidera kepala,
                        transplantasi, luka bakar, pasien kritis di ICU/HCU, usia lanjut, psikiatri, mendapat kemoterapi
                        atau radiasi, imunitas rendah / HIV-AIDS, penyakit kronis lain.)
                    </div>
                </td>
                <td class="text-center">
                    Tidak <span class="check">[<?= $chk($d['diagnosaKhusus'] ?? '', '0') ?>]</span>
                    &nbsp; Ya <span class="check">[<?= $chk($d['diagnosaKhusus'] ?? '', '1') ?>]</span>
                </td>
            </tr>
        </table>
        <div class="catatan-box">
            (Bila skor &gt; 2 dan / atau pasien dengan diagnosis khusus, dilakukan pengkajian lebih lanjut oleh nutritionis / dietisen)
        </div>

    <?php else: ?>

        <div class="section-title">SKRINING GIZI ANAK (Usia 0-16 tahun)</div>
        <table>
            <tr class="bg-gray text-center text-bold">
                <td width="65%">Parameter</td>
                <td width="20%">Jawaban</td>
                <td width="15%">Skor</td>
            </tr>
            <tr>
                <td>Pasien anak tampak kurus</td>
                <td class="text-center">
                    Ya <span class="check">[<?= $chk($d['tampakKurus'] ?? '', '1') ?>]</span>
                    &nbsp; Tidak <span class="check">[<?= $chk($d['tampakKurus'] ?? '', '0') ?>]</span>
                </td>
                <td class="text-center"><?= ((int)($d['tampakKurus'] ?? 0) === 1) ? '1' : '0' ?></td>
            </tr>
            <tr>
                <td>Apakah terdapat penurunan berat badan selama 1 bulan terakhir (berdasarkan penilaian objektif data berat badan bila ada, atau penilaian subjektif orangtua untuk bayi &lt; 1 tahun: berat badan tidak naik 3 bulan terakhir)?</td>
                <td class="text-center">
                    Ya <span class="check">[<?= $chk($d['anakPenurunanBeratBadan'] ?? '', '1') ?>]</span>
                    &nbsp; Tidak <span class="check">[<?= $chk($d['anakPenurunanBeratBadan'] ?? '', '0') ?>]</span>
                </td>
                <td class="text-center"><?= ((int)($d['anakPenurunanBeratBadan'] ?? 0) === 1) ? '1' : '0' ?></td>
            </tr>
            <tr>
                <td>
                    Apakah terdapat salah satu kondisi tersebut di bawah ini:<br>
                    <span class="keterangan">
                        &bull; Diare &gt; 5 kali sehari dalam seminggu terakhir<br>
                        &bull; Muntah &gt; 3 kali sehari dalam seminggu terakhir<br>
                        &bull; Asupan makan berkurang dalam seminggu terakhir
                    </span>
                </td>
                <td class="text-center">
                    Ya <span class="check">[<?= $chk($d['kondisi'] ?? '', '1') ?>]</span>
                    &nbsp; Tidak <span class="check">[<?= $chk($d['kondisi'] ?? '', '0') ?>]</span>
                </td>
                <td class="text-center"><?= ((int)($d['kondisi'] ?? 0) === 1) ? '1' : '0' ?></td>
            </tr>
            <tr>
                <td>Apakah terdapat penyakit atau keadaan yang mengakibatkan pasien berisiko mengalami malnutrisi atau apakah ada pembedahan besar?</td>
                <td class="text-center">
                    Ya <span class="check">[<?= $chk($d['terdapatPenyakitKeadaan'] ?? '', '1') ?>]</span>
                    &nbsp; Tidak <span class="check">[<?= $chk($d['terdapatPenyakitKeadaan'] ?? '', '0') ?>]</span>
                </td>
                <td class="text-center"><?= ((int)($d['terdapatPenyakitKeadaan'] ?? 0) === 1) ? '2' : '0' ?></td>
            </tr>
            <?php
                $totalSkorAnak =
                    (((int)($d['tampakKurus'] ?? 0) === 1) ? 1 : 0) +
                    (((int)($d['anakPenurunanBeratBadan'] ?? 0) === 1) ? 1 : 0) +
                    (((int)($d['kondisi'] ?? 0) === 1) ? 1 : 0) +
                    (((int)($d['terdapatPenyakitKeadaan'] ?? 0) === 1) ? 2 : 0);
            ?>
            <tr>
                <td colspan="2" class="text-bold" style="text-align: right;">Total Skor</td>
                <td class="text-center text-bold"><?= $totalSkorAnak ?></td>
            </tr>
        </table>
        <div class="catatan-box">
            Nilai score: 0 = risiko rendah, 1-3 = risiko malnutrisi sedang, 4-5 = risiko malnutrisi tinggi.<br>
            Total skor jika jawaban Ya &ge; 1 dilakukan pengkajian oleh dietisan.
        </div>

    <?php endif; ?>

    <table style="margin-top: 15px;">
        <tr class="bg-gray text-center text-bold">
            <td width="50%">Perlu Pengkajian Lebih Lanjut</td>
            <td width="50%">TTD / Nama Petugas</td>
        </tr>
        <tr>
            <td class="text-center" style="height: 60px; vertical-align: middle;">
                <span class="text-bold" style="font-size: 12px;">
                    <?= ((int)($d['perluPengkajian'] ?? 0) === 1) ? 'YA' : 'TIDAK' ?>
                </span>
            </td>
            <td style="height: 60px;">&nbsp;</td>
        </tr>
        <tr>
            <td></td>
            <td class="text-center"><?= htmlspecialchars($d['usrPetugas'] ?? '') ?></td>
        </tr>
    </table>

</body>
</html>