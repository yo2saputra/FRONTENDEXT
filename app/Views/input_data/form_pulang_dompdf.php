<!DOCTYPE html>
<html>
<head>
    <title><?= $title_pdf ?></title>
    <style>
        @page { margin: 10mm 15mm 10mm 15mm; size: A4 portrait; }
        body { font-family: Arial, Helvetica, sans-serif; font-size: 10px; line-height: 1.3; color: #000; margin: 0; }
        
        table { width: 100%; border-collapse: collapse; border-spacing: 0; }
        td, th { vertical-align: top; padding: 2px 4px; }
        
        .box-outer { border: 1px solid black; }
        .border-all { border: 1px solid black; }
        .border-all td { border: 1px solid black; }
        
        .bg-gray { background-color: #e0e0e0; font-weight: bold; border-top: 1px solid black; border-bottom: 1px solid black; }
        .text-bold { font-weight: bold; }
        .text-center { text-align: center; }
        
        .dots { border-bottom: 1px dotted #000; display: inline-block; min-width: 20px; }
        .cb { 
            display: inline-block; width: 10px; height: 10px; 
            border: 1px solid black; margin-right: 4px; 
            text-align: center; line-height: 8px; font-size: 8px;
        }
        
        #footer {
            position: fixed; bottom: 0px; left: 0px; right: 0px; height: 25px;
            border-top: 1px solid #ccc; padding-top: 5px; font-size: 8px; color: #444;
        }
    </style>
</head>
<body>

    <?php
        $path = FCPATH . 'assets/img/Logo_MedicElle.png'; 
        if (file_exists($path)) {
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        } else {
            $base64 = '';
        }
    ?>

    <table style="margin-bottom: 10px;">
        <tr>
            <td>
                <?php if($base64): ?>
                    <img src="<?= $base64 ?>" height="45" alt="Logo MedicElle">
                <?php else: ?>
                <?php endif; ?>
                <div style="font-size: 8px; margin-top: 2px;">Jl. Raya Gubeng No. 11, Surabaya - 60281</div>
            </td>
        </tr>
    </table>

    <div class="text-center text-bold" style="font-size: 11px; text-decoration: underline; margin-bottom: 5px;">PETUNJUK PASIEN PULANG</div>

    <div class="box-outer">
        
        <table class="border-all" style="border: none;">
            <tr>
                <td width="55%" style="border-right: 1px solid black; border-bottom: 1px solid black;">
                    <table style="width: 100%;">
                        <tr><td width="80">Nama Pasien</td><td width="5">:</td><td class="text-bold"><?= $d['nama'] ?></td></tr>
                        <tr><td>Jenis Kelamin</td><td>:</td><td class="text-bold"><?= $d['jk'] ?></td></tr>
                        <tr><td>Tanggal Lahir</td><td>:</td><td class="text-bold"><?= $d['tgl_lahir'] ?></td></tr>
                    </table>
                </td>
                <td width="45%" style="border-bottom: 1px solid black;">
                     <table style="width: 100%;">
                        <tr><td width="80">NO. RM</td><td width="5">:</td><td class="text-bold"><?= $d['rm'] ?></td></tr>
                        <tr><td>Alamat</td><td>:</td><td class="text-bold"><?= $d['alamat'] ?></td></tr>
                        <tr><td>Tanggal Periksa</td><td>:</td><td class="text-bold"><?= $d['tgl_periksa'] ?></td></tr>
                    </table>
                </td>
            </tr>
        </table>

        <div style="border-bottom: 1px solid black; padding: 3px 5px;">
            <span class="text-bold">Diagnosa Medis :</span> <?= $d['diagnosa'] ?>
        </div>

        <div class="bg-gray" style="padding: 2px 5px;">Observasi Triage :</div>
        <div style="border-bottom: 1px solid black; padding: 3px 5px;">
            BB <span class="text-bold"><?= $d['bb'] ?></span> kg, &nbsp;
            TB <span class="text-bold"><?= $d['tb'] ?></span> cm, &nbsp;
            Tensi <span class="text-bold"><?= $d['tensi'] ?></span> mmHg, &nbsp;
            Nadi <span class="text-bold"><?= $d['nadi'] ?></span> x/mnt, &nbsp;
            RR <span class="text-bold"><?= $d['rr'] ?></span> x/mnt, &nbsp;
            Suhu <span class="text-bold"><?= $d['suhu'] ?></span> °C
        </div>

        <div class="bg-gray" style="padding: 2px 5px;">Obat-obatan (Jenis, Dosis, dan Cara Pemakaian)</div>
        <table style="width: 100%; border-bottom: 1px solid black;">
            <tr>
                <td style="height: 90px; padding: 5px;">
                    <div>a. Yang telah diberikan di klinik</div>
                    <div style="margin-left: 10px; margin-bottom: 5px;">
                        <?= $d['obat_klinik'] ?>
                    </div>

                    <div>b. Yang dibawa pulang</div>
                    <div style="margin-left: 10px; font-weight: bold; white-space: pre-line;">
                        <?= $d['obat_pulang'] ?>
                    </div>
                </td>
            </tr>
        </table>

        <div class="bg-gray" style="padding: 2px 5px;">Hasil-hasil Pemeriksaan</div>
        <table style="width: 100%; border-bottom: 1px solid black;">
            <tr>
                <td width="15%">Laboratorium</td>
                <td width="35%">: <span class="text-bold"><?= $d['lab'] ?></span> lembar</td>
                <td width="15%">USG</td>
                <td width="35%">: <span class="text-bold"><?= $d['usg'] ?></span> lembar</td>
            </tr>
            <tr>
                <td>Foto Thorax</td>
                <td>: <span class="text-bold"><?= $d['thorax'] ?></span> lembar</td>
                <td>Lainnya</td>
                <td>: <span class="text-bold"><?= $d['lain'] ?></span> lembar</td>
            </tr>
        </table>

        <div class="bg-gray" style="padding: 2px 5px;">Penyuluhan Kesehatan</div>
        <table style="width: 100%; border-bottom: 1px solid black;">
            <tr>
                <td style="height: 50px; padding: 5px;">
                    <div style="margin-bottom: 3px;">
                        <span class="cb">v</span> <?= $d['edukasi'] ?>
                    </div>
                    <div style="margin-bottom: 3px;">
                        <span class="cb"></span> .............................................................
                    </div>
                    <div>
                        <span class="cb"></span> .............................................................
                    </div>
                </td>
            </tr>
        </table>

        <div class="bg-gray" style="padding: 2px 5px;">Jadwal Kontrol</div>
        <table style="width: 100%;">
            <tr>
                <td style="padding: 5px;">
                    <table width="100%">
                        <tr>
                            <td width="15">a.</td>
                            <td width="80">Hari/Tanggal</td>
                            <td width="10">:</td>
                            <td class="text-bold"><?= $d['kontrol_hari'] ?></td>
                        </tr>
                        <tr>
                            <td>b.</td>
                            <td>Poli</td>
                            <td>:</td>
                            <td class="text-bold"><?= $d['kontrol_poli'] ?></td>
                        </tr>
                        <tr>
                            <td>c.</td>
                            <td>Dengan membawa</td>
                            <td>:</td>
                            <td class="text-bold"><?= $d['kontrol_bawa'] ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </div> <table class="box-outer" style="width: 100%; margin-top: 10px;">
        <tr>
            <td width="50%" align="center" style="vertical-align: top; padding-top: 10px; height: 100px;">
                Yang Diberi Penjelasan<br>
                Pasien / Keluarga<br><br><br><br><br>
                ( <span class="text-bold">Keluarga Pasien</span> )
            </td>
            <td width="50%" align="center" style="vertical-align: top; padding-top: 10px;">
                Surabaya, <span class="text-bold">10 Oktober 2025</span><br>
                Yang memberi penjelasan<br>
                Perawat<br><br><br>
                
                <div style="font-size: 14px; font-family: 'Times New Roman'; margin-bottom: 2px;">
                    <?= $d['perawat'] ?>
                </div>
                
                ( <span class="text-bold">Sr. Siti</span> )
            </td>
        </tr>
    </table>

    <div id="footer">
        <table width="100%">
            <tr>
                <td width="25%"><img src="" width="10" height="10"> +62 31 3000 8008</td>
                <td width="25%"><img src="" width="10" height="10"> +62 31 3000 9009</td>
                <td width="25%"><img src="" width="10" height="10"> info@medicelle.co.id</td>
                <td width="25%" align="right"><img src="" width="10" height="10"> www.medicelle.co.id</td>
            </tr>
        </table>
    </div>

</body>
</html>