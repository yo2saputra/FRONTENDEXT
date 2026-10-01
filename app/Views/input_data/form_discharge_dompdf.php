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
        .bb { border-bottom: 1px solid black; }
        .br { border-right: 1px solid black; }
        
        .bold { font-weight: bold; }
        .text-center { text-align: center; }
        
        
        .cb { 
            display: inline-block; width: 10px; height: 10px; 
            border: 1px solid black; margin-right: 4px; 
            text-align: center; line-height: 9px; font-size: 9px; font-family: sans-serif;
            vertical-align: middle;
        }
        
        
        .data-line {
            font-family: 'Courier New', Courier, monospace; 
            font-weight: bold;
            border-bottom: 1px dotted black; 
            display: inline-block;
            min-height: 12px; 
            vertical-align: bottom; 
        }

        .w-full { width: 95%; }
        .w-half { width: 45%; }
        .w-short { width: 150px; }

        #footer {
            position: fixed; bottom: -5px; left: 0px; right: 0px; height: 30px;
            border-top: 1px solid #ccc; padding-top: 5px; font-size: 8px; color: #444;
        }
    </style>
</head>
<body>

    <table style="margin-bottom: 5px;">
        <tr>
            <td>
                <div style="font-size: 18px; font-weight: bold; font-family: 'Times New Roman', serif;">MEDICELLE</div>
                <div style="font-size: 9px; letter-spacing: 2px; font-weight: bold;">C L I N I C</div>
                <div style="font-size: 8px;">Jl. Raya Gubeng No. 11, Surabaya - 60281</div>
            </td>
        </tr>
    </table>

    <div class="text-center bold" style="font-size: 11px; margin-bottom: 3px;">LEMBAR DISCHARGE PLANNING</div>

    <div class="box-outer">
        
        <table class="bb">
            <tr>
                <td width="55%" class="br" style="padding: 0;">
                    <table style="width: 100%;">
                        <tr><td width="25%">Nama Pasien</td><td width="2%">:</td><td class="bold"><?= $d['nama'] ?></td></tr>
                        <tr><td>Jenis Kelamin</td><td>:</td><td class="bold"><?= $d['jk'] ?></td></tr>
                        <tr><td>Tanggal Lahir</td><td>:</td><td class="bold"><?= $d['tgl_lahir'] ?></td></tr>
                    </table>
                </td>
                <td width="45%" style="padding: 0;">
                     <table style="width: 100%;">
                        <tr><td width="30%">NO. RM</td><td width="2%">:</td><td class="bold"><?= $d['rm'] ?></td></tr>
                        <tr><td>Alamat</td><td>:</td><td class="bold"><?= $d['alamat'] ?></td></tr>
                        <tr><td>Tanggal Periksa</td><td>:</td><td class="bold"><?= $d['tgl_periksa'] ?></td></tr>
                    </table>
                </td>
            </tr>
        </table>

        <div class="bb" style="padding: 3px 5px;">
            <span class="bold">Diagnosa Medis :</span> 
            <span class="data-line w-full"><?= $d['diagnosa'] ?></span>
        </div>

        <div class="bb" style="padding: 3px 5px;">
            <div class="bold" style="margin-bottom: 2px;">Dipulangkan dari Klinik dalam keadaan :</div>
            <table width="100%">
                <tr>
                    <td width="40%"><span class="cb"></span> Sembuh</td>
                    <td width="40%"><span class="cb"></span> Pulang Paksa</td>
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
        </div>

        <div class="bb" style="padding: 3px 5px;">
            <div class="bold">A. Kontrol</div>
            <table width="100%" style="margin-left: 10px;">
                <tr>
                    <td width="15">a.</td><td width="40">Waktu</td><td width="5">:</td>
                    <td><span class="data-line w-full"><?= $d['kontrol_waktu'] ?></span></td>
                </tr>
                <tr>
                    <td>b.</td><td>Tempat</td><td>:</td>
                    <td><span class="data-line w-full"><?= $d['kontrol_tempat'] ?></span></td>
                </tr>
            </table>
        </div>

        <div class="bb" style="padding: 3px 5px;">
            <div class="bold">B. Lanjutan Perawatan di Rumah (luka operasi, pemasangan gips, pengobatan dan lain-lain)</div>
            <div style="margin-top: 2px;">
                <span class="cb">v</span> 
                <span class="data-line w-full"><?= $d['perawatan'] ?></span>
            </div>
            <div style="margin-top: 4px;">
                <span class="cb"></span> <span class="data-line w-full"></span>
            </div>
        </div>

        <div class="bb" style="padding: 3px 5px;">
            <div class="bold">C. Aturan Diet/Nutrisi</div>
             <div style="margin-top: 2px;">
                <span class="cb">v</span> 
                <span class="data-line w-full"><?= $d['diet'] ?></span>
            </div>
             <div style="margin-top: 4px;">
                 <span class="cb"></span> <span class="data-line w-full"></span>
            </div>
        </div>

        <div class="bb" style="padding: 3px 5px;">
            <div class="bold">D. Obat-obatan yang masih diminum dan jumlahnya</div>
             <div style="margin-top: 2px;">
                <span class="cb"></span> 
                <span class="data-line w-full"><?= $d['obat1'] ?></span>
            </div>
             <div style="margin-top: 4px;">
                <span class="cb"></span> 
                <span class="data-line w-full"><?= $d['obat2'] ?></span>
            </div>
        </div>

        <div class="bb" style="padding: 3px 5px;">
            <div class="bold">E. Aktivitas dan Istirahat</div>
             <div style="margin-top: 2px;">
                 <span class="cb"></span> 
                 <span class="data-line w-full">-</span>
             </div>
             <div style="margin-top: 4px;">
                 <span class="cb"></span> <span class="data-line w-full"></span>
             </div>
        </div>

        <div class="bb" style="padding: 3px 5px;">
            <div class="bold">F. Hasil Pemeriksaan Penunjang, Surat Keterangan Istirahat :</div>
             <div style="margin-top: 4px;">
                 <span class="cb"></span> Hasil USG : 
                 <span class="data-line w-short"></span>
             </div>
             <div style="margin-top: 4px;">
                 <span class="cb"></span> Surat Keterangan Istirahat : 
                 <span class="data-line w-short"></span>
             </div>
        </div>

        <div style="padding: 3px 5px; height: 30px;">
            <div class="bold">G. Lain-lain :</div>
            </div>

    </div> 
    
   <div style="margin-top: 5px; font-size: 10px;">
        Surabaya, <span class="data-line" style="min-width: 120px; text-align: center;"><?= $d['tgl_periksa'] ?></span>
    </div>
    
    <table class="box-outer" style="margin-top: 5px; width: 100%;">
        <tr>
            <td width="33%" class="text-center" style="padding-top: 10px;">
                Pasien / Keluarga<br><br><br><br><br>
                ( &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; )
            </td>
            <td width="33%" class="text-center" style="padding-top: 10px;">
                Mengetahui,<br>Dokter<br><br><br><br>
                ( &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; )
            </td>
            <td width="33%" class="text-center" style="padding-top: 10px;">
                Perawat<br><br><br><br><br>
                ( &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; )
            </td>
        </tr>
    </table>

    <div id="footer">
        <table width="100%">
            <tr>
                <td width="25%">+62 31 3000 8008</td>
                <td width="25%">+62 31 3000 9009</td>
                <td width="25%">info@medicelle.co.id</td>
                <td width="25%" align="right">www.medicelle.co.id</td>
            </tr>
        </table>
    </div>

</body>
</html>