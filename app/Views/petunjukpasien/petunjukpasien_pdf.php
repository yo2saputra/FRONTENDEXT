<!DOCTYPE html>
<html>
<head>
    <title><?= $title_pdf ?></title>
    <style>
        @page { margin: 10mm 15mm 15mm 15mm; size: A4 portrait; }
        body { font-family: Arial, Helvetica, sans-serif; font-size: 10px; line-height: 1.4; color: #000; margin: 0; }
        table { width: 100%; border-collapse: collapse; border-spacing: 0; table-layout: fixed; }
        td, th { vertical-align: top; padding: 2px 4px; word-break: break-word; overflow-wrap: break-word; }
        .box-outer { border: 1px solid black; }
        .bg-gray { background-color: #ffffff; font-weight: bold; border-top: 1px solid black; border-bottom: 1px solid black; padding: 3px 5px; }
        .text-bold { font-weight: bold; }
        .text-center { text-align: center; }
        .cb {
            display: inline-block; width: 10px; height: 10px;
            border: 1px solid black; margin-right: 4px;
            text-align: center; line-height: 8px; font-size: 8px;
            vertical-align: middle;
        }
        #footer {
            position: fixed; bottom: 0px; left: 0px; right: 0px; height: 20px;
            border-top: 1px solid #ccc; padding-top: 4px; font-size: 8px; color: #444;
        }
    </style>
</head>
<body>

<?php
    $path = FCPATH . 'assets/img/logo-medicelle.png';
    if (file_exists($path)) {
        $type    = pathinfo($path, PATHINFO_EXTENSION);
        $imgdata = file_get_contents($path);
        $base64  = 'data:image/' . $type . ';base64,' . base64_encode($imgdata);
    } else {
        $base64 = '';
    }

    function fmt_date_pulang($raw) {
        if (!$raw) return '-';
        try {
            return (new DateTime($raw))->format('d/m/Y');
        } catch (Exception $e) {
            return htmlspecialchars($raw);
        }
    }
?>

<div id="footer">
    <table style="width:100%; table-layout:fixed;">
        <tr>
            <td width="25%">+62 31 3000 8008</td>
            <td width="25%">+62 31 3000 9009</td>
            <td width="25%">info@medicelle.co.id</td>
            <td width="25%" align="right">www.medicelle.co.id</td>
        </tr>
    </table>
</div>

<!-- Header -->
<table style="margin-bottom: 8px;">
    <tr>
        <td>
            <?php if ($base64): ?>
                <img src="<?= $base64 ?>" height="45" alt="Logo MedicElle">
            <?php endif; ?>
            <div style="font-size: 8px; margin-top: 2px;">Jl. Raya Gubeng No. 11, Surabaya - 60281</div>
        </td>
    </tr>
</table>

<div class="text-center text-bold" style="font-size: 11px; text-decoration: underline; margin-bottom: 6px;">PETUNJUK PASIEN PULANG</div>

<div class="box-outer">

    <!-- Identitas Pasien -->
    <table style="border-collapse: collapse; width: 100%;">
        <tr>
            <td width="55%" style="border-right: 1px solid black; border-bottom: 1px solid black; padding: 4px 5px;">
                <table style="width: 100%; border-collapse: collapse; table-layout: fixed;">
                    <tr>
                        <td style="width:35%; padding: 1px 0;">Nama Pasien</td>
                        <td style="width:5%; padding: 1px 0;">:</td>
                        <td class="text-bold" style="width:60%; padding: 1px 0;"><?= htmlspecialchars($d['nama']) ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 1px 0;">Jenis Kelamin</td>
                        <td style="padding: 1px 0;">:</td>
                        <td class="text-bold" style="padding: 1px 0;"><?= htmlspecialchars($d['jk']) ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 1px 0;">Tanggal Lahir</td>
                        <td style="padding: 1px 0;">:</td>
                        <td class="text-bold" style="padding: 1px 0;"><?= htmlspecialchars($d['tgl_lahir']) ?></td>
                    </tr>
                </table>
            </td>
            <td width="45%" style="border-bottom: 1px solid black; padding: 4px 5px;">
                <table style="width: 100%; border-collapse: collapse; table-layout: fixed;">
                    <tr>
                        <td style="width:35%; padding: 1px 0;">NO. RM</td>
                        <td style="width:5%; padding: 1px 0;">:</td>
                        <td class="text-bold" style="width:60%; padding: 1px 0;"><?= htmlspecialchars($d['rm']) ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 1px 0;">Tanggal Periksa</td>
                        <td style="padding: 1px 0;">:</td>
                        <td class="text-bold" style="padding: 1px 0;"><?= fmt_date_pulang($d['tgl_pemeriksaan']) ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- Diagnosa -->
    <div style="border-bottom: 1px solid black; padding: 3px 5px; word-wrap: break-word; overflow-wrap: break-word;">
        <span class="text-bold">Diagnosa Medis :</span> <?= htmlspecialchars($d['diagnosa_medis'] ?: '-') ?>
    </div>

    <!-- Observasi Triage -->
    <div class="bg-gray">Observasi Triage :</div>
    <div style="border-bottom: 1px solid black; padding: 4px 5px;">
        BB <span class="text-bold"><?= htmlspecialchars($d['berat_badan'] ?: '-') ?></span> kg &nbsp;&nbsp;
        TB <span class="text-bold"><?= htmlspecialchars($d['tinggi_badan'] ?: '-') ?></span> cm &nbsp;&nbsp;
        Tensi <span class="text-bold"><?= htmlspecialchars($d['tensi'] ?: '-') ?></span> mmHg &nbsp;&nbsp;
        Nadi <span class="text-bold"><?= htmlspecialchars($d['nadi'] ?: '-') ?></span> x/mnt &nbsp;&nbsp;
        RR <span class="text-bold"><?= htmlspecialchars($d['respiratory_rate'] ?: '-') ?></span> x/mnt &nbsp;&nbsp;
        Suhu <span class="text-bold"><?= htmlspecialchars($d['suhu'] ?: '-') ?></span> °C
    </div>

    <!-- Obat-obatan -->
    <div class="bg-gray">Obat-obatan (Jenis, Dosis, dan Cara Pemakaian)</div>
    <div style="border-bottom: 1px solid black; padding: 5px; min-height: 70px;">
        <div style="margin-bottom: 8px;">
            <div style="margin-bottom: 2px;">a. Yang telah diberikan di klinik</div>
            <div style="margin-left: 14px; word-wrap: break-word; overflow-wrap: break-word; white-space: pre-wrap;">
                <?= htmlspecialchars($d['diberikan_obt'] ?: '-') ?>
            </div>
        </div>
        <div>
            <div style="margin-bottom: 2px;">b. Yang dibawa pulang</div>
            <div class="text-bold" style="margin-left: 14px; word-wrap: break-word; overflow-wrap: break-word; white-space: pre-wrap;">
                <?= htmlspecialchars($d['dibawapulang_obt'] ?: '-') ?>
            </div>
        </div>
    </div>

    <!-- Hasil Pemeriksaan -->
    <div class="bg-gray">Hasil-hasil Pemeriksaan</div>
    <table style="width: 100%; border-bottom: 1px solid black;">
        <colgroup>
            <col width="18%">
            <col width="32%">
            <col width="18%">
            <col width="32%">
        </colgroup>
        <tr>
            <td style="padding: 3px 5px;">Laboratorium</td>
            <td style="padding: 3px 5px;">: <span class="text-bold"><?= htmlspecialchars($d['laboratorium_lmbr'] ?: '-') ?></span> lembar</td>
            <td style="padding: 3px 5px;">USG</td>
            <td style="padding: 3px 5px;">: <span class="text-bold"><?= htmlspecialchars($d['usg_lmbr'] ?: '-') ?></span> lembar</td>
        </tr>
        <tr>
            <td style="padding: 3px 5px;">Foto Thorax</td>
            <td style="padding: 3px 5px;">: <span class="text-bold"><?= htmlspecialchars($d['foto_thorax_lmbr'] ?: '-') ?></span> lembar</td>
            <td style="padding: 3px 5px;">Lainnya</td>
            <td style="padding: 3px 5px;">: <span class="text-bold"><?= htmlspecialchars($d['lainnya_lmbr'] ?: '-') ?></span> lembar</td>
        </tr>
    </table>

    <!-- Penyuluhan Kesehatan -->
    <div class="bg-gray">Penyuluhan Kesehatan</div>
    <div style="border-bottom: 1px solid black; padding: 5px; min-height: 45px;">
        <div style="margin-bottom: 4px;">
            <span class="cb"><?= !empty($d['penyuluhan_1']) ? 'v' : '' ?></span>
            <span style="word-wrap: break-word; overflow-wrap: break-word; white-space: pre-wrap;"><?= htmlspecialchars($d['penyuluhan_1'] ?: '.............................................................') ?></span>
        </div>
        <div style="margin-bottom: 4px;">
            <span class="cb"><?= !empty($d['penyuluhan_2']) ? 'v' : '' ?></span>
            <span style="word-wrap: break-word; overflow-wrap: break-word; white-space: pre-wrap;"><?= htmlspecialchars($d['penyuluhan_2'] ?: '.............................................................') ?></span>
        </div>
        <div>
            <span class="cb"><?= !empty($d['penyuluhan_3']) ? 'v' : '' ?></span>
            <span style="word-wrap: break-word; overflow-wrap: break-word; white-space: pre-wrap;"><?= htmlspecialchars($d['penyuluhan_3'] ?: '.............................................................') ?></span>
        </div>
    </div>

    <!-- Jadwal Kontrol -->
    <div class="bg-gray">Jadwal Kontrol</div>
    <table style="width: 100%; border-collapse: collapse; table-layout: fixed; padding: 0; border-bottom: 1px solid black;">
        <tr>
            <td style="width:3%; padding: 3px 5px;">a.</td>
            <td style="width:22%; padding: 3px 5px;">Hari/Tanggal</td>
            <td style="width:3%; padding: 3px 5px;">:</td>
            <td class="text-bold" style="width:72%; padding: 3px 5px;"><?= fmt_date_pulang($d['tgl_kntrl']) ?></td>
        </tr>
        <tr>
            <td style="width:3%; padding: 3px 5px;">b.</td>
            <td style="width:22%; padding: 3px 5px;">Poli</td>
            <td style="width:3%; padding: 3px 5px;">:</td>
            <td class="text-bold" style="width:72%; padding: 3px 5px;"><?= htmlspecialchars($d['poli_kntrl'] ?: '-') ?></td>
        </tr>
        <tr>
            <td style="width:3%; padding: 3px 5px;">c.</td>
            <td style="width:22%; padding: 3px 5px;">Dengan membawa</td>
            <td style="width:3%; padding: 3px 5px;">:</td>
            <td class="text-bold" style="width:72%; padding: 3px 5px;"><?= htmlspecialchars($d['membawa_kntrl'] ?: '-') ?></td>
        </tr>
    </table>

</div>

<!-- Tanda Tangan -->
<table class="box-outer" style="width: 100%; margin-top: 10px; border-collapse: collapse; table-layout: fixed;">
    <tr>
        <td width="50%" align="center" style="padding: 10px 5px; height: 90px; border-right: 1px solid black; word-break: break-word; overflow-wrap: break-word;">
            Yang Diberi Penjelasan<br>
            Pasien / Keluarga<br><br><br><br>
            ( <span class="text-bold"><?= htmlspecialchars($d['diberi_pnjlsan'] ?: '.....................') ?></span> )
        </td>
        <td width="50%" align="center" style="padding: 10px 5px; word-break: break-word; overflow-wrap: break-word;">
            <?= htmlspecialchars($d['kota_tgl']) ?><br>
            Yang memberi penjelasan<br>
            Perawat<br><br><br>
            ( <span class="text-bold"><?= htmlspecialchars($d['pemberi_pnjlsan'] ?: '.....................') ?></span> )
        </td>
    </tr>
</table>

</body>
</html>