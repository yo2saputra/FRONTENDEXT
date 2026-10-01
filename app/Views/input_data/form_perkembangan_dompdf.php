<!DOCTYPE html>
<html>
<head>
    <title><?= $title_pdf ?></title>
    <style>
        
        @page { margin: 10mm 10mm 10mm 10mm; size: A4 portrait; }
        body { font-family: Arial, sans-serif; font-size: 10px; line-height: 1.3; color: #000; margin: 0; }
        
        .header-table { width: 100%; border-collapse: collapse; margin-bottom: 2px; border: 1px solid black; }
        .header-td { padding: 5px; vertical-align: middle; }
        .dots { border-bottom: 1px dotted black; display: inline-block; }
        .circle { border: 1px solid black; border-radius: 50%; padding: 1px 4px; }
        
        .table-cppt { 
            width: 100%; 
            border-collapse: collapse; 
            border: 1px solid black;
        }
        
        .table-cppt thead th { 
            border: 1px solid black; 
            padding: 5px; 
            background-color: #d0d0d0; 
            text-align: center;
            font-weight: bold;
            vertical-align: middle;
        }

        .table-cppt tbody td {
            border-left: 1px solid black; 
            border-right: 1px solid black;
            border-top: none;             
            border-bottom: none;           
            padding: 5px;
            vertical-align: top;
        }

        .text-center { text-align: center; }
        .bold { font-weight: bold; }
        
        .judul-box {
            border: 1px solid black;
            border-bottom: none; 
            background-color: #d0d0d0;
            text-align: center;
            font-weight: bold;
            padding: 5px;
            font-size: 12px;
        }
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

    <table class="header-table">
        <tr>
            <td width="50%" class="header-td" style="border-right: 1px solid black;">
                <table width="100%">
                    <tr>
                        <td width="20%">
                            <?php if($base64): ?>
                                <img src="<?= $base64 ?>" style="height: 45px; width: auto;">
                            <?php endif; ?>
                        </td>
                        <td width="80%">


                            <div style="font-size: 8px;">Jl. Raya Gubeng No. 11, Surabaya - 60281</div>
                        </td>
                    </tr>
                </table>
            </td>
            
            <td width="50%" class="header-td">
                <div class="bold" style="font-size: 10px; margin-bottom: 5px; text-align: right;">CATATAN PERKEMBANGAN PASIEN TERINTEGRASI</div>
                <table width="100%" style="font-size: 9px;">
                    <tr>
                        <td width="25%">NO RM</td>
                        <td width="2%">:</td>
                        <td class="bold"><?= $d['rm'] ?></td>
                        <td align="right" class="bold">(L/ <span class="<?= $d['jk'] == 'P' ? 'circle' : '' ?>">P</span>)</td>
                    </tr>
                    <tr>
                        <td>Nama Pasien</td>
                        <td>:</td>
                        <td colspan="2" class="bold"><?= $d['nama'] ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Lahir</td>
                        <td>:</td>
                        <td colspan="2" class="bold"><?= $d['tgl_lahir'] ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="judul-box">
        CATATAN PERKEMBANGAN TERINTEGRASI
    </div>

    <table class="table-cppt">
        <thead>
            <tr>
                <td colspan="5" style="font-size: 8px; padding: 4px; border: 1px solid black;">
                    (Ditulis dengan format SOAP, disertai dengan target dan tujuan terukur, dituliskan nama dan paraf pada setiap akhir catatan, DPJP harus membaca dan memverifikasi ulang seluruh rencana perawatan)
                </td>
            </tr>
            <tr>
                <th width="12%">Tanggal/<br>Jam</th>
                <th width="15%">Profesional<br>Pemberi<br>Asuhan</th>
                <th width="35%">Hasil Asesmen Pasien dan<br>Pemberian Pelayanan</th>
                <th width="25%">INSTRUKSI PPA<br><span style="font-weight: normal; font-size: 8px;">(Ditulis dengan rinci dan jelas,<br>termasuk pasca bedah/ tindakan<br>invasive lainnya)</span></th>
                <th width="13%">Verifikasi DPJP<br><span style="font-weight: normal; font-size: 8px;">(Nama Terang<br>dan Tanda<br>Tangan)</span></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($d['rows'] as $row): ?>
            <tr>
                <td class="text-center"><?= $row['tgl'] ?><br><?= $row['jam'] ?></td>
                <td class="text-center"><?= $row['ppa'] ?></td>
                
                <td><?= $row['soap'] ?></td>
                
                <td><?= $row['instruksi'] ?></td>
                
                <td class="text-center" style="vertical-align: bottom;">
                    <br><br><br>
                    ( <?= $row['verif'] ?> )
                </td>
            </tr>
            <?php endforeach; ?>

            <?php for($i=0; $i<15; $i++): ?>
            <tr>
                <td style="height: 25px;">&nbsp;</td> <td>&nbsp;</td> <td>&nbsp;</td> <td>&nbsp;</td> <td>&nbsp;</td> </tr>
            <?php endfor; ?>
            
            <tr>
                <td style="border-bottom: 1px solid black;"></td>
                <td style="border-bottom: 1px solid black;"></td>
                <td style="border-bottom: 1px solid black;"></td>
                <td style="border-bottom: 1px solid black;"></td>
                <td style="border-bottom: 1px solid black;"></td>
            </tr>
        </tbody>
    </table>

</body>
</html>