<!DOCTYPE html>
<html>
<head>
    <title><?= $title_pdf ?></title>
    <style>
        
        @page { margin: 10mm 15mm 10mm 15mm; size: A4 portrait; }
        body { font-family: Arial, sans-serif; font-size: 10px; line-height: 1.3; color: #000; margin: 0; }
        
        
        table { width: 100%; border-collapse: collapse; border-spacing: 0; }
        td, th { vertical-align: top; padding: 3px 5px; }
        
        
        .box { border: 1px solid black; }
        .bt { border-top: 1px solid black; }
        .bb { border-bottom: 1px solid black; }
        .br { border-right: 1px solid black; }
        .bl { border-left: 1px solid black; }
        
        
        .bg-gray { background-color: #d0d0d0; font-weight: bold; }
        .bold { font-weight: bold; }
        .text-center { text-align: center; }
        
        
        .fill { font-family: 'Courier New', Courier, monospace; font-weight: bold; font-size: 11px; }
        
        
        #footer { position: fixed; bottom: 0; left: 0; right: 0; padding-top: 5px; font-size: 8px; border-top: 1px solid #ccc; }
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
                <td width="50%" class="br text-center" style="padding: 15px; vertical-align: middle;">
                    <?php if($base64): ?>
                        <img src="<?= $base64 ?>" style="height: 50px; width: auto;" alt="Logo">
                    <?php else: ?>
                    <?php endif; ?>
                    <div style="font-size: 9px; margin-top: 5px;">Jl. Raya Gubeng No. 11, Surabaya - 60281</div>
                </td>
                <td width="50%" class="text-center" style="vertical-align: middle; background-color: #f0f0f0;">
                    <div class="bold" style="font-size: 11px;">LEMBAR OBSERVASI TINDAKAN PASIEN</div>
                    <div class="bold" style="font-size: 11px;">DENGAN LOKAL ANESTESI</div>
                </td>
            </tr>
        </table>

        <table class="bb">
            <tr>
                <td width="20%">Nama</td><td width="2%">:</td>
                <td class="fill"><?= $d['nama'] ?></td>
            </tr>
            <tr>
                <td>NO RM</td><td>:</td>
                <td class="fill"><?= $d['rm'] ?></td>
            </tr>
            <tr>
                <td>Tanggal Lahir</td><td>:</td>
                <td class="fill"><?= $d['tgl_lahir'] ?></td>
            </tr>
            <tr>
                <td>Diagnosis Medis</td><td>:</td>
                <td class="fill"><?= $d['diagnosis'] ?></td>
            </tr>
            <tr>
                <td>Tindakan</td><td>:</td>
                <td class="fill"><?= $d['tindakan'] ?></td>
            </tr>
        </table>

        <div class="bg-gray bb" style="padding: 3px 5px;">KEADAAN PRA TINDAKAN</div>
        <table class="bb" style="width: 100%;">
            <tr>
                <td colspan="2">
                    KEADAAN UMUM : <span class="fill" style="margin-left: 5px;"><?= $d['pra_ku'] ?></span>
                </td>
            </tr>
            <tr>
                <td colspan="2">TANDA-TANDA VITAL :</td>
            </tr>
            <tr>
                <td colspan="2" style="padding-left: 15px; padding-bottom: 5px;">
                    Tekanan Darah : <span class="fill"><?= $d['pra_td'] ?></span> mmHg &nbsp;&nbsp;&nbsp;
                    Suhu : <span class="fill"><?= $d['pra_suhu'] ?></span> °C &nbsp;&nbsp;&nbsp;
                    Nadi : <span class="fill"><?= $d['pra_nadi'] ?></span> x/mnt &nbsp;&nbsp;&nbsp;
                    RR : <span class="fill"><?= $d['pra_rr'] ?></span> x/mnt &nbsp;&nbsp;&nbsp;
                    SPO2 : <span class="fill"><?= $d['pra_spo2'] ?></span> %
                </td>
            </tr>
        </table>

        <div class="bg-gray bb" style="padding: 3px 5px;">KEADAAN INTRA TINDAKAN</div>
        <table class="bb" style="width: 100%;">
            <tr>
                <td colspan="4">
                    KEADAAN UMUM : <span class="fill" style="margin-left: 5px;"><?= $d['intra_ku'] ?></span>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    DOKTER : <span class="fill" style="margin-left: 5px;"><?= $d['dokter'] ?></span>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    OBAT ANESTESI LOKAL : <span class="fill" style="margin-left: 5px;"><?= $d['obat_anestesi'] ?></span>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    DOSIS OBAT : <span class="fill" style="margin-left: 5px;"><?= $d['dosis'] ?></span>
                </td>
            </tr>
            
            <tr>
                <td colspan="4">
                    RUTE OBAT : <span class="fill" style="margin-left: 5px;"><?= $d['rute'] ?></span>
                </td>
            </tr>

            <tr>
                <td width="20%">JAM MULAI :</td>
                <td width="30%" class="fill"><?= $d['jam_mulai'] ?></td>
                <td width="20%">JAM SELESAI :</td>
                <td width="30%" class="fill"><?= $d['jam_selesai'] ?></td>
            </tr>
            
            <tr>
                <td colspan="4" style="padding-top: 5px;">TANDA-TANDA VITAL :</td>
            </tr>
            <tr>
                <td colspan="4" style="padding-left: 15px; padding-bottom: 5px;">
                    Tekanan Darah : <span class="fill"><?= $d['intra_td'] ?></span> mmHg &nbsp;&nbsp;&nbsp;
                    Suhu : <span class="fill"><?= $d['intra_suhu'] ?></span> °C &nbsp;&nbsp;&nbsp;
                    Nadi : <span class="fill"><?= $d['intra_nadi'] ?></span> x/mnt &nbsp;&nbsp;&nbsp;
                    RR : <span class="fill"><?= $d['intra_rr'] ?></span> x/mnt &nbsp;&nbsp;&nbsp;
                    SPO2 : <span class="fill"><?= $d['intra_spo2'] ?></span> %
                </td>
            </tr>
        </table>

        <div class="bg-gray bb" style="padding: 3px 5px;">KEADAAN POST TINDAKAN</div>
        <table class="bb" style="width: 100%;">
            <tr>
                <td colspan="2">
                    KEADAAN UMUM : <span class="fill" style="margin-left: 5px;"><?= $d['post_ku'] ?></span>
                </td>
            </tr>
            <tr>
                <td colspan="2">TANDA-TANDA VITAL :</td>
            </tr>
            <tr>
                <td colspan="2" style="padding-left: 15px; padding-bottom: 5px;">
                    Tekanan Darah : <span class="fill"><?= $d['post_td'] ?></span> mmHg &nbsp;&nbsp;&nbsp;
                    Suhu : <span class="fill"><?= $d['post_suhu'] ?></span> °C &nbsp;&nbsp;&nbsp;
                    Nadi : <span class="fill"><?= $d['post_nadi'] ?></span> x/mnt &nbsp;&nbsp;&nbsp;
                    RR : <span class="fill"><?= $d['post_rr'] ?></span> x/mnt &nbsp;&nbsp;&nbsp;
                    SPO2 : <span class="fill"><?= $d['post_spo2'] ?></span> %
                </td>
            </tr>
        </table>

        <div style="padding: 5px; min-height: 100px;">
            <div class="bold" style="text-decoration: underline; margin-bottom: 5px;">CATATAN :</div>
            <div class="fill" style="padding-left: 10px; line-height: 1.6;">
                <?= $d['catatan'] ?>
            </div>
        </div>

    </div> 
    
    <table style="width: 100%; margin-top: 20px;">
        <tr>
            <td width="50%" align="center" style="vertical-align: top;">
                Perawat<br><br><br><br>
                <div style="border-bottom: 1px dotted black; display: inline-block; min-width: 150px; padding-bottom: 2px;">
                    <span style="font-family: 'Brush Script MT', cursive; font-size: 16px;"><?= $d['perawat'] ?></span>
                </div>
            </td>
            <td width="50%" align="center" style="vertical-align: top;">
                <?= $d['kota_tgl'] ?><br>
                Dokter<br><br><br><br>
                <div style="border-bottom: 1px dotted black; display: inline-block; min-width: 150px; padding-bottom: 2px; font-weight: bold;">
                    <?= $d['dokter_nama'] ?>
                </div>
            </td>
        </tr>
    </table>

</body>
</html>