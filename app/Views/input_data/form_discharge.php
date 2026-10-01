<!DOCTYPE html>
<html>
<head>
    <title><?= $title_pdf ?></title>
    <style>
        @page { margin: 10mm 10mm 10mm 10mm; size: A4 portrait; }
        body { font-family: Arial, sans-serif; font-size: 10px; line-height: 1.3; }
        
        
        table { width: 100%; border-collapse: collapse; }
        td, th { padding: 3px; vertical-align: top; }
        .border-all { border: 1px solid black; }
        .border-bottom { border-bottom: 1px solid black; }
        .text-bold { font-weight: bold; }
        .text-center { text-align: center; }
        
        
        .cb { 
            display: inline-block; width: 10px; height: 10px; 
            border: 1px solid black; margin-right: 3px; 
            text-align: center; line-height: 9px; font-size: 8px;
        }
        
        
        #footer { position: fixed; bottom: 0px; left: 0px; right: 0px; height: 30px; border-top: 1px solid #ccc; padding-top: 5px; font-size: 9px; }
        
        
        .content { margin-bottom: 40px; }
    </style>
</head>
<body>
    <div class="content">
        <table style="margin-bottom: 10px;">
            <tr>
                <td>
                    <div style="font-size: 18px; font-weight: bold; font-family: 'Times New Roman', serif;">MEDICELLE</div>
                    <div style="font-size: 9px; letter-spacing: 2px; font-weight: bold;">C L I N I C</div>
                    <div style="font-size: 8px;">Jl. Raya Gubeng No. 11, Surabaya - 60281</div>
                </td>
            </tr>
        </table>

        <div class="text-center text-bold" style="font-size: 12px; margin-bottom: 5px;">LEMBAR DISCHARGE PLANNING</div>

        <table class="border-all">
            <tr>
                <td width="50%" style="border-right: 1px solid black;">
                    <table>
                        <tr><td width="80">Nama Pasien</td><td>: <b><?= $d['nama'] ?></b></td></tr>
                        <tr><td>Jenis Kelamin</td><td>: <b><?= $d['jk'] ?></b></td></tr>
                        <tr><td>Tanggal Lahir</td><td>: <b><?= $d['tgl_lahir'] ?></b></td></tr>
                    </table>
                </td>
                <td width="50%">
                    <table>
                        <tr><td width="80">NO. RM</td><td>: <b><?= $d['rm'] ?></b></td></tr>
                        <tr><td>Alamat</td><td>: <b><?= $d['alamat'] ?></b></td></tr>
                        <tr><td>Tanggal Periksa</td><td>: <b><?= $d['tgl_periksa'] ?></b></td></tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="border-all" style="border-left:none; border-right:none;">
                    <b>Diagnosa Medis :</b> <?= $d['diagnosa'] ?>
                </td>
            </tr>
            
            <tr>
                <td colspan="2" class="border-bottom" style="padding: 5px;">
                    <b>Dipulangkan dari Klinik dalam keadaan :</b><br>
                    <table width="100%">
                        <tr>
                            <td width="33%"><span class="cb"></span> Sembuh</td>
                            <td width="33%"><span class="cb"></span> Pulang Paksa</td>
                        </tr>
                        <tr>
                            <td><span class="cb">v</span> Meneruskan Berobat Jalan</td>
                            <td><span class="cb"></span> Lari</td>
                        </tr>
                        <tr>
                            <td><span class="cb"></span> Pindah ke Klinik/RS Lain</td>
                            <td><span class="cb"></span> Meninggal</td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td colspan="2" class="border-bottom">
                    <b>A. Kontrol</b><br>
                    &nbsp;&nbsp;&nbsp; a. Waktu : <b>Rabu, 15 / 10 / 2025</b><br>
                    &nbsp;&nbsp;&nbsp; b. Tempat : <b>Poli Bedah Medicelle Clinic</b>
                </td>
            </tr>

            <tr>
                <td colspan="2" class="border-bottom">
                    <b>B. Lanjutan Perawatan di Rumah (luka operasi, pemasangan gips, pengobatan dan lain-lain)</b><br>
                    <span class="cb">v</span> <b>Kompres dingin diatas luka post MIBS</b><br>
                    <span class="cb"></span> ................................................................................................
                </td>
            </tr>

            <tr>
                <td colspan="2" class="border-bottom">
                    <b>C. Aturan Diet/Nutrisi</b><br>
                    <span class="cb">v</span> <b>Makanan yang bergizi</b><br>
                    <span class="cb"></span> ................................................................................................
                </td>
            </tr>

            <tr>
                <td colspan="2" class="border-bottom">
                    <b>D. Obat-obatan yang masih diminum dan jumlahnya</b><br>
                    <span class="cb"></span> <b>Kaltrofen tab 2x1</b><br>
                    <span class="cb"></span> <b>Cefixim tab 2x1</b>
                </td>
            </tr>

            <tr>
                <td colspan="2" class="border-bottom">
                    <b>E. Aktivitas dan Istirahat</b><br>
                    <span class="cb"></span> - <br>
                    <span class="cb"></span> ................................................................................................
                </td>
            </tr>

            <tr>
                <td colspan="2" class="border-bottom">
                    <b>F. Hasil Pemeriksaan Penunjang, Surat Keterangan Istirahat :</b><br>
                    <span class="cb"></span> Hasil USG<br>
                    <span class="cb"></span> Surat Keterangan Istirahat
                </td>
            </tr>

            <tr>
                <td colspan="2" style="height: 50px;">
                    <b>G. Lain-lain :</b>
                </td>
            </tr>
        </table>

        <div style="margin-top: 10px;">Surabaya, <?= $d['tgl_periksa'] ?></div>
        <table class="border-all" style="margin-top: 5px;">
            <tr>
                <td width="33%" align="center" style="height: 80px; vertical-align: bottom;">
                    Pasien / Keluarga<br><br><br>
                    ( .......................... )
                </td>
                <td width="33%" align="center" style="vertical-align: bottom;">
                    Mengetahui,<br>Dokter<br><br><br>
                    ( .......................... )
                </td>
                <td width="33%" align="center" style="vertical-align: bottom;">
                    Perawat<br><br><br>
                    ( .......................... )
                </td>
            </tr>
        </table>
    </div>

    <div id="footer">
        <table width="100%">
            <tr>
                <td><img src="" alt="icon-telp" width="10"> +62 31 3000 8008</td>
                <td><img src="" alt="icon-wa" width="10"> +62 31 3000 9009</td>
                <td>info@medicelle.co.id</td>
                <td align="right">www.medicelle.co.id</td>
            </tr>
        </table>
    </div>
</body>
</html>