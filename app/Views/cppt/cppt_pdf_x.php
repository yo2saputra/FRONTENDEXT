<!DOCTYPE html>
<html>
<head>
    <title><?= $title_pdf ?></title>
    <style>
        @page { margin: 10mm; size: A4 portrait; }
        body { font-family: Arial, sans-serif; font-size: 10px; line-height: 1.3; color: #000; margin: 0; }
        
        .table-cppt { 
            width: 100%; 
            border-collapse: collapse;
            table-layout: fixed;
        }
        .table-cppt thead { display: table-header-group; }
        .table-cppt tbody tr { page-break-inside: avoid; }
        
        .table-cppt th, .table-cppt td {
            border: 1px solid black;
            word-break: break-word;
            overflow-wrap: break-word;
        }

        .kop-wrapper {
            border: none !important; 
            padding: 0 !important;
            font-weight: normal;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid black; 
            border-bottom: none;
        }
        .header-table td {
            border: none; 
            padding: 5px;
            vertical-align: middle;
        }
        .header-table .col-kanan {
            border-left: 1px solid black; 
        }

        .info-pasien {
            width: 100%;
            border-collapse: collapse;
        }
        .info-pasien td {
            border: none !important; 
            padding: 2px !important;
        }

        .judul-box {
            border: 1px solid black;
            border-bottom: none;
            background-color: #ffffff;
            text-align: center;
            font-weight: bold;
            padding: 5px;
            font-size: 12px;
        }

        .col-header {
            background-color: #ffffff; 
            padding: 5px;
            text-align: center;
            font-weight: bold;
            vertical-align: middle;
        }

        .table-cppt tbody td {
            padding: 5px;
            vertical-align: top;
        }

        .text-center { text-align: center; }
        .bold { font-weight: bold; }
    </style>
</head>
<body>

    <?php
        $logo_path = FCPATH . 'assets/img/logo-medicelle.png';
        $base64 = '';
        if (file_exists($logo_path)) {
            $data   = file_get_contents($logo_path);
            $base64 = 'data:image/png;base64,' . base64_encode($data);
        }
    ?>

    <table class="table-cppt">
        <thead>
            <tr>
                <th colspan="5" class="kop-wrapper" align="left">
                    <table class="header-table">
                        <tr>
                            <td width="50%" align="center">
                                <?php if($base64): ?>
                                    <img src="<?= $base64 ?>" style="height: 45px; width: auto; display: block; margin: 0 auto;">
                                <?php endif; ?>
                                <div style="font-size: 8px; margin-top: 3px;">Jl. Raya Gubeng No. 11, Surabaya - 60281</div>
                            </td>
                            <td width="50%" class="col-kanan">
                                <div class="bold" style="font-size: 10px; margin-bottom: 5px; text-align: right;">CATATAN PERKEMBANGAN PASIEN TERINTEGRASI</div>
                                <table class="info-pasien">
                                    <tr>
                                        <td width="25%">NO RM</td>
                                        <td width="2%">:</td>
                                        <td class="bold"><?= $d['rm'] ?></td>
                                        <td align="right" class="bold">(<?= $d['jk'] == 'P' ? 'P' : 'L' ?>)</td>
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
                </th>
            </tr>
            
            <tr>
                <td colspan="5" style="font-size: 8px; padding: 4px; border-bottom: none; background-color: white;">
                    (Ditulis dengan format SOAP, disertai dengan target dan tujuan terukur, dituliskan nama dan paraf pada setiap akhir catatan, DPJP harus membaca dan memverifikasi ulang seluruh rencana perawatan)
                </td>
            </tr>

            <tr>
                <th class="col-header" style="width:10%;">Tanggal/<br>Jam</th>
                <th class="col-header" style="width:15%;">Profesional<br>Pemberi<br>Asuhan</th>
                <th class="col-header" style="width:37%;">Hasil Asesmen Pasien dan<br>Pemberian Pelayanan</th>
                <th class="col-header" style="width:25%;">INSTRUKSI PPA<br><span style="font-weight:normal; font-size:8px;">(Ditulis dengan rinci dan jelas,<br>termasuk pasca bedah/tindakan<br>invasive lainnya)</span></th>
                <th class="col-header" style="width:13%;">Verifikasi DPJP<br><span style="font-weight:normal; font-size:8px;">(Nama Terang<br>dan Tanda<br>Tangan)</span></th>
            </tr>
        </thead>
        
        <tbody>
            <?php if (empty($d['rows'])): ?>
            <tr>
                <td colspan="5" style="text-align:center; padding:20px; font-style:italic; color:#777;">
                    Belum ada catatan CPPT untuk pasien ini.
                </td>
            </tr>
            <?php else: ?>
            <?php foreach ($d['rows'] as $row): ?>
            <tr>
                <td class="text-center"><?= $row['tgl'] ?><br><?= $row['jam'] ?></td>
                <td class="text-center"><?= $row['ppa'] ?></td>
                <td><?= $row['soap'] ?></td>
                <td><?= $row['instruksi'] ?></td>
                <td class="text-center" style="vertical-align:bottom;">
                    <?php if (!empty($row['verif'])): ?>
                        <br><br><br>
                        ( <?= $row['verif'] ?> )
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>