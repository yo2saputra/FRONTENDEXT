<!DOCTYPE html>
<html>
<head>
    <title><?= $title_pdf ?></title>
    <style>
        @page { margin: 10mm 15mm 10mm 15mm; size: A4 portrait; }
        body { font-family: Arial, sans-serif; font-size: 10px; line-height: 1.4; color: #000; margin: 0; }

        table { width: 100%; border-collapse: collapse; border-spacing: 0; }
        td, th { vertical-align: top; padding: 3px 6px; font-family: Arial, sans-serif; font-size: 10px; }

        .box  { border: 1px solid black; }
        .bt   { border-top: 1px solid black; }
        .bb   { border-bottom: 1px solid black; }
        .br   { border-right: 1px solid black; }
        .bl   { border-left: 1px solid black; }

        .bg-gray    { background-color: #ffffff; font-weight: bold; }
        .bold       { font-weight: bold; }
        .text-center{ text-align: center; }

        .fill {
            font-family: Arial, sans-serif;
            font-size: 10px;
        }

        #footer {
            position: fixed; bottom: 0; left: 0; right: 0;
            padding-top: 5px; font-size: 8px;
            border-top: 1px solid #ffffff;
        }

        .fill {
            font-family: Arial, sans-serif;
            font-size: 10px;
            word-break: break-word;
            overflow-wrap: break-word;
            white-space: normal;
            max-width: 0; 
        }

    </style>
</head>
<body>

    <?php
        $logo_dir   = FCPATH . 'assets/img/';
        $path_final = '';

        $candidates = glob($logo_dir . '*', GLOB_NOSORT);
        foreach ($candidates as $f) {
            if (preg_match('/medic.?elle\.(png|jpg|jpeg)$/i', $f)) {
                $path_final = $f;
                break;
            }
        }

        $base64 = '';
        if ($path_final !== '' && file_exists($path_final)) {
            $type   = strtolower(pathinfo($path_final, PATHINFO_EXTENSION));
            $type   = ($type === 'jpg') ? 'jpeg' : $type;
            $data   = file_get_contents($path_final);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
    ?>

    <div class="box">

        <!-- HEADER -->
        <table class="bb">
            <tr>
                <td width="50%" class="br text-center" style="padding: 12px; vertical-align: middle;">
                    <?php if ($base64): ?>
                        <img src="<?= $base64 ?>" style="height: 48px; width: auto;" alt="Logo">
                    <?php endif; ?>
                    <div style="font-size: 9px; margin-top: 4px;">Jl. Raya Gubeng No. 11, Surabaya - 60281</div>
                </td>
                <td width="50%" class="text-center" style="vertical-align: middle;">
                    <div class="bold" style="font-size: 12px;">LEMBAR OBSERVASI TINDAKAN PASIEN</div>
                    <div class="bold" style="font-size: 12px;">DENGAN LOKAL ANESTESI</div>
                </td>
            </tr>
        </table>

        <table class="bb" style="table-layout:fixed; width:100%;">
            <tr>
                <td width="28%" style="white-space:nowrap;">Nama</td>
                <td width="2%">:</td>
                <td width="70%" class="fill"><?= htmlspecialchars($d['nama']) ?></td>
            </tr>
            <tr>
                <td style="white-space:nowrap;">No. Rekam Medis</td>
                <td>:</td>
                <td class="fill"><?= htmlspecialchars($d['rm']) ?></td>
            </tr>
            <tr>
                <td style="white-space:nowrap;">Diagnosis Medis</td>
                <td>:</td>
                <td class="fill"><?= htmlspecialchars($d['diagnosis']) ?></td>
            </tr>
            <tr>
                <td style="white-space:nowrap;">Tindakan</td>
                <td>:</td>
                <td class="fill"><?= htmlspecialchars($d['tindakan']) ?></td>
            </tr>
        </table>

        <!-- KEADAAN PRA TINDAKAN -->
        <div class="bg-gray bb" style="padding: 3px 6px;">KEADAAN PRA TINDAKAN</div>
        <table class="bb">
            <tr>
                <td width="22%">KEADAAN UMUM</td>
                <td width="2%">:</td>
                <td class="fill"><?= htmlspecialchars($d['pra_ku']) ?></td>
            </tr>
            <tr>
                <td colspan="3">TANDA-TANDA VITAL :</td>
            </tr>
            <tr>
                <td colspan="3" style="padding-left: 15px; padding-bottom: 5px;">
                    Tekanan Darah : <span class="fill"><?= htmlspecialchars($d['pra_td']) ?></span> mmHg &nbsp;&nbsp;
                    Suhu : <span class="fill"><?= htmlspecialchars($d['pra_suhu']) ?></span> °C &nbsp;&nbsp;
                    Nadi : <span class="fill"><?= htmlspecialchars($d['pra_nadi']) ?></span> x/mnt &nbsp;&nbsp;
                    RR : <span class="fill"><?= htmlspecialchars($d['pra_rr']) ?></span> x/mnt &nbsp;&nbsp;
                    SPO2 : <span class="fill"><?= htmlspecialchars($d['pra_spo2']) ?></span> %
                </td>
            </tr>
        </table>

        <!-- KEADAAN INTRA TINDAKAN -->
        <div class="bg-gray bb" style="padding: 3px 6px;">KEADAAN INTRA TINDAKAN</div>
        <table class="bb">
           <tr>
                <td width="22%">KEADAAN UMUM</td>
                <td width="2%">:</td>
                <td class="fill"><?= htmlspecialchars($d['pra_ku']) ?></td>
            </tr>
            <tr>
                <td>DOKTER</td>
                <td>:</td>
                <td class="fill"><?= htmlspecialchars($d['dokter']) ?></td>
            </tr>
            <tr>
                <td>OBAT ANESTESI LOKAL</td>
                <td>:</td>
                <td class="fill"><?= htmlspecialchars($d['obat_anestesi']) ?></td>
            </tr>
            <tr>
                <td>DOSIS OBAT</td>
                <td>:</td>
                <td class="fill"><?= htmlspecialchars($d['dosis']) ?></td>
            </tr>
            <tr>
                <td>RUTE OBAT</td>
                <td>:</td>
                <td class="fill"><?= htmlspecialchars($d['rute']) ?></td>
            </tr>
            <tr>
                <td>JAM MULAI</td>
                <td>:</td>
                <td>
                    <span class="fill"><?= htmlspecialchars($d['jam_mulai']) ?></span>
                    &nbsp;&nbsp;&nbsp;
                    <span style="margin-left:20px;">JAM SELESAI : </span>
                    <span class="fill"><?= htmlspecialchars($d['jam_selesai']) ?></span>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="padding-top: 4px;">TANDA-TANDA VITAL :</td>
            </tr>
            <tr>
                <td colspan="3" style="padding-left: 15px; padding-bottom: 5px;">
                    Tekanan Darah : <span class="fill"><?= htmlspecialchars($d['intra_td']) ?></span> mmHg &nbsp;&nbsp;
                    Suhu : <span class="fill"><?= htmlspecialchars($d['intra_suhu']) ?></span> °C &nbsp;&nbsp;
                    Nadi : <span class="fill"><?= htmlspecialchars($d['intra_nadi']) ?></span> x/mnt &nbsp;&nbsp;
                    RR : <span class="fill"><?= htmlspecialchars($d['intra_rr']) ?></span> x/mnt &nbsp;&nbsp;
                    SPO2 : <span class="fill"><?= htmlspecialchars($d['intra_spo2']) ?></span> %
                </td>
            </tr>
        </table>

        <!-- KEADAAN POST TINDAKAN -->
        <div class="bg-gray bb" style="padding: 3px 6px;">KEADAAN POST TINDAKAN</div>
        <table class="bb">
            <tr>
                <td width="22%">KEADAAN UMUM</td>
                <td width="2%">:</td>
                <td class="fill"><?= htmlspecialchars($d['pra_ku']) ?></td>
            </tr>
            <tr>
                <td colspan="3">TANDA-TANDA VITAL :</td>
            </tr>
            <tr>
                <td colspan="3" style="padding-left: 15px; padding-bottom: 5px;">
                    Tekanan Darah : <span class="fill"><?= htmlspecialchars($d['post_td']) ?></span> mmHg &nbsp;&nbsp;
                    Suhu : <span class="fill"><?= htmlspecialchars($d['post_suhu']) ?></span> °C &nbsp;&nbsp;
                    Nadi : <span class="fill"><?= htmlspecialchars($d['post_nadi']) ?></span> x/mnt &nbsp;&nbsp;
                    RR : <span class="fill"><?= htmlspecialchars($d['post_rr']) ?></span> x/mnt &nbsp;&nbsp;
                    SPO2 : <span class="fill"><?= htmlspecialchars($d['post_spo2']) ?></span> %
                </td>
            </tr>
        </table>

        <div style="padding: 5px 6px; min-height: 80px;">
            <div class="bold" style="text-decoration: underline; margin-bottom: 4px;">CATATAN :</div>
            <div style="padding-left: 10px; line-height: 1.6; font-family: Arial, sans-serif; font-size: 10px;
                        word-break: break-word; overflow-wrap: break-word; white-space: normal;">
                <?= nl2br(htmlspecialchars($d['catatan'])) ?>
            </div>
        </div>

    </div>

    <!-- TANDA TANGAN -->
    <table style="width: 100%; margin-top: 20px;">
        <tr>
            <td width="50%" align="center" style="vertical-align: top; font-family: Arial, sans-serif; font-size: 10px;">
                <span style="visibility:hidden;"><?= htmlspecialchars($d['kota_tgl']) ?></span><br>
                Perawat<br><br><br><br>
                <div style="border-bottom: 1px dotted black; display: inline-block; min-width: 150px; padding-bottom: 2px;">
                    <span style="font-size: 10px;"><?= htmlspecialchars($d['perawat']) ?></span>
                </div>
            </td>
            <td width="50%" align="center" style="vertical-align: top; font-family: Arial, sans-serif; font-size: 10px;">
                <?= htmlspecialchars($d['kota_tgl']) ?><br>
                Dokter<br><br><br><br>
                <div style="border-bottom: 1px dotted black; display: inline-block; min-width: 150px; padding-bottom: 2px; font-weight: bold;">
                    <?= htmlspecialchars($d['dokter_nama']) ?>
                </div>
            </td>
        </tr>
    </table>

</body>
</html>