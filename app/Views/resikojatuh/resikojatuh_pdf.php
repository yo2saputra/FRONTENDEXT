<!DOCTYPE html>
<html>
<head>
    <title><?= $title_pdf ?></title>
    <style>
        @page { 
            margin: 20mm 20mm 20mm 20mm; 
            size: A4 portrait; 
        }
        body { 
            font-family: Arial, Helvetica, sans-serif; 
            font-size: 11px; 
            line-height: 1.3; 
            color: #000; 
            margin: 0; 
        }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        td, th { vertical-align: middle; padding: 4px 5px; border: 1px solid black; }
        .no-border { border: none !important; }
        .text-center { text-align: center; }
        .text-bold { font-weight: bold; }
        .check { 
            font-family: 'Courier New', monospace; 
            font-weight: bold; 
            font-size: 14px; 
            display: block; 
            text-align: center;
        }
        .handwriting { 
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px; 
            text-align: center;
        }
        .bg-gray { background-color: #ffffff; }
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
    ?>

    <table class="no-border" width="100%" style="margin-bottom: 20px;">
        <tr class="no-border">
            <td width="20%" style="vertical-align: middle;" class="no-border">
                <?php if ($base64): ?>
                    <img src="<?= $base64 ?>" style="height: 50px; width: auto;" alt="Logo">
                <?php endif; ?>
            </td>
            <td width="60%" class="no-border text-center" align="center" style="vertical-align: middle;">
                <div class="text-bold" style="font-size: 12px; text-align: center;">FORM ASSESMENT RISIKO JATUH RAWAT JALAN</div>
                <div class="text-bold" style="font-size: 12px; text-align: center;">GET UP AND GO</div>
            </td>
            <td width="20%" class="no-border"></td>
        </tr>
    </table>

    <div class="text-bold" style="margin-bottom: 5px;">1. Pengkajian</div>
    <table style="width: 100%;">
        <tr class="bg-gray text-center text-bold">
            <td width="5%">No</td>
            <td width="75%">Penilaian/Pengkajian</td>
            <td width="10%">Ya</td>
            <td width="10%">Tidak</td>
        </tr>
        <tr>
            <td class="text-center">a.</td>
            <td>Cara berjalan pasien (salah satu atau lebih)</td>
            <td class="text-center"><span class="check"><?= $d['kajian_a_ya'] ?></span></td>
            <td class="text-center"><span class="check"><?= $d['kajian_a_tidak'] ?></span></td>
        </tr>
        <tr>
            <td class="text-center">a.1</td>
            <td style="padding-left:15px;">Tidak seimbang/ sempoyongan</td>
            <td class="text-center"><span class="check"><?= $d['kajian_a1_ya'] ?></span></td>
            <td class="text-center"><span class="check"><?= $d['kajian_a1_tidak'] ?></span></td>
        </tr>
        <tr>
            <td class="text-center">a.2</td>
            <td style="padding-left:15px;">Jalan dengan menggunakan alat bantu (kruk, tripot, kursiroda, bantuan orang)</td>
            <td class="text-center"><span class="check"><?= $d['kajian_a2_ya'] ?></span></td>
            <td class="text-center"><span class="check"><?= $d['kajian_a2_tidak'] ?></span></td>
        </tr>
        <tr>
            <td class="text-center">b.</td>
            <td>Menopang saat akan duduk : tampak memegang pinggiran kursi atau meja atau benda lain sebagai penopang saat akan duduk</td>
            <td class="text-center"><span class="check"><?= $d['kajian_b_ya'] ?></span></td>
            <td class="text-center"><span class="check"><?= $d['kajian_b_tidak'] ?></span></td>
        </tr>
    </table>

    <div class="text-bold" style="margin-bottom: 5px;">2. Hasil</div>
    <table style="width: 100%;">
        <tr class="bg-gray text-center text-bold">
            <td width="5%">No</td>
            <td width="20%">Hasil</td>
            <td width="55%">Penilaian/Pengkajian</td>
            <td width="20%">Keterangan</td>
        </tr>
        <tr>
            <td class="text-center">1.</td>
            <td>Tidak Berisiko</td>
            <td>Tidak ditemukan a &amp; b</td>
            <td class="text-center"><span class="check"><?= $d['hasil_risiko'] == 'tidak_berisiko' ? 'v' : '' ?></span></td>
        </tr>
        <tr>
            <td class="text-center">2.</td>
            <td>Berisiko Sedang</td>
            <td>Ditemukan salah satu dari a &amp; b</td>
            <td class="text-center"><span class="check"><?= $d['hasil_risiko'] == 'sedang' ? 'v' : '' ?></span></td>
        </tr>
        <tr>
            <td class="text-center">3.</td>
            <td>Berisiko Tinggi</td>
            <td>Ditemukan a &amp; b</td>
            <td class="text-center"><span class="check"><?= $d['hasil_risiko'] == 'tinggi' ? 'v' : '' ?></span></td>
        </tr>
    </table>

    <div class="text-bold" style="margin-bottom: 5px;">3. TTD / Nama Petugas</div>
    <table style="width: 100%;">
        <tr class="bg-gray text-center text-bold">
            <td width="100%">TTD/ Nama Petugas</td>
        </tr>
        <tr>
            <td style="height: 60px;">&nbsp;</td>
        </tr>
        <tr>
                <td class="text-center" style="border-top: none; padding-top: 2px;"><span class="handwriting"><?= $d['usr_petugas'] ?? '' ?></span></td>
        </tr>
    </table>

</body>
</html>