<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Petunjuk Pasien Pulang</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>

    * { box-sizing: border-box; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    body { background-color: #525659; font-family: Arial, sans-serif; padding: 40px; margin: 0; display: flex; justify-content: center; min-width: 210mm; }

    .form-container {
        background: white; 
        width: 210mm; 
        height: 297mm; 
        border: 2px solid black; 
        padding: 10mm; 
        position: relative;
        box-shadow: 0 0 20px rgba(0,0,0,0.5); 
        display: flex; 
        flex-direction: column;
    }

    table { width: 100%; border-collapse: collapse; border-spacing: 0; font-size: 11px; }
    td, th { border: 1px solid black; padding: 4px; vertical-align: top; }

    .filled-text { font-family: 'Courier New', monospace; font-weight: bold; color: #000; font-size: 11px; }
    .filled-area { font-family: 'Courier New', monospace; font-weight: bold; white-space: pre-wrap; line-height: 1.4; }
    
    .label-bold { font-weight: bold; }
    .col-label { width: 100px; }
    .col-sep { width: 10px; text-align: center; }
    
    .header-logo { margin-bottom: 5px; }
    .judul-halaman { text-align: center; font-weight: bold; text-transform: uppercase; font-size: 14px; margin-bottom: 5px; text-decoration: underline; }

    .ttd-wrapper { margin-top: 10px; display: flex; justify-content: space-between; border: 1px solid black; padding: 15px; flex-grow: 1; max-height: 180px; }
    .ttd-box { width: 45%; text-align: center; display: flex; flex-direction: column; justify-content: space-between; }
    .fake-signature { font-family: 'Brush Script MT', cursive; font-size: 24px; transform: rotate(-5deg); margin-top: 10px; }

    .footer-contact { margin-top: auto; padding-top: 10px; display: flex; justify-content: space-between; font-size: 9px; border-top: 1px solid #ccc; align-items: center; width: 100%; }
    .footer-item { display: flex; align-items: center; gap: 5px; }
</style>
</head>
<body>

<div class="form-container">
    
    <div class="header-logo">
        <div style="font-size: 24px; font-weight: bold; font-family: 'Times New Roman';">MEDICELLE</div>
        <div style="font-size: 11px; font-weight: bold; letter-spacing: 3px; font-family: 'Times New Roman'; margin-left: 2px;">C L I N I C</div>
        <div style="font-size: 9px; margin-top: 5px; font-family: Arial;">Jl. Raya Gubeng No. 11, Surabaya - 60281</div>
    </div>

    <div class="judul-halaman">PETUNJUK PASIEN PULANG</div>

    <table style="border: 2px solid black;">
        <tr>
            <td width="50%" style="border-right: 1px solid black;">
                <table style="border: none;">
                    <tr><td class="col-label" style="border:none;">Nama Pasien</td><td class="col-sep" style="border:none;">:</td><td style="border:none;"><span class="filled-text">Ny. Aliyah</span></td></tr>
                    <tr><td class="col-label" style="border:none;">Jenis Kelamin</td><td class="col-sep" style="border:none;">:</td><td style="border:none;"><span class="filled-text">P</span></td></tr>
                    <tr><td class="col-label" style="border:none;">Tanggal Lahir</td><td class="col-sep" style="border:none;">:</td><td style="border:none;"><span class="filled-text">14 / 11 / 1950</span></td></tr>
                </table>
            </td>
            <td width="50%">
                <table style="border: none;">
                    <tr><td class="col-label" style="border:none;">NO. RM</td><td class="col-sep" style="border:none;">:</td><td style="border:none;"><span class="filled-text">22 10 38 21</span></td></tr>
                    <tr><td class="col-label" style="border:none;">Alamat</td><td class="col-sep" style="border:none;">:</td><td style="border:none;"><span class="filled-text">Teluk Kumai Barat 192</span></td></tr>
                    <tr><td class="col-label" style="border:none;">Tanggal Periksa</td><td class="col-sep" style="border:none;">:</td><td style="border:none;"><span class="filled-text">10 / 10 / 2025</span></td></tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="border-top: 1px solid black;">
                <span class="label-bold" style="width: 120px;">Diagnosa Medis : </span>
                <span class="filled-text">Fibro Adenoma Mammae (S)</span>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="background: #e6e6e6; border-top: 1px solid black; padding: 2px;">
                <span class="label-bold">Observasi Triage :</span>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding: 6px;">
                BB <span class="filled-text">54</span> kg, &nbsp;
                TB <span class="filled-text">158</span> cm, &nbsp;
                Tensi <span class="filled-text">110/80</span> mmHg, &nbsp;
                Nadi <span class="filled-text">80</span> x/mnt, &nbsp;
                RR <span class="filled-text">20</span> x/mnt, &nbsp;
                Suhu <span class="filled-text">36</span> °C
            </td>
        </tr>
    </table>

    <table style="border: 2px solid black; border-top: none;">
        <tr><td colspan="2" style="background: #e6e6e6; border-bottom: 1px solid black; padding: 2px;"><span class="label-bold">Obat-obatan (Jenis, Dosis, dan Cara Pemakaian)</span></td></tr>
        <tr>
            <td colspan="2" style="padding: 5px;">
                <div>a. Yang telah diberikan di klinik</div>
                <div class="filled-area" style="min-height: 15px; margin-bottom: 5px;">-</div>
                <div>b. Yang dibawa pulang</div>
                <div class="filled-area">- Kaltofen tab 2x1
- Cefixim tab 2x1</div>
            </td>
        </tr>
    </table>

    <table style="border: 2px solid black; border-top: none;">
        <tr><td colspan="4" style="background: #e6e6e6; border-bottom: 1px solid black; padding: 2px;"><span class="label-bold">Hasil-hasil Pemeriksaan</span></td></tr>
        <tr>
            <td width="15%" style="border:none;">Laboratorium</td><td width="35%" style="border:none;">: <span class="filled-text">-</span> lembar</td>
            <td width="15%" style="border:none;">USG</td><td width="35%" style="border:none;">: <span class="filled-text">1</span> lembar</td>
        </tr>
        <tr>
            <td style="border:none;">Foto Thorax</td><td style="border:none;">: <span class="filled-text">-</span> lembar</td>
            <td style="border:none;">Lainnya</td><td style="border:none;">: <span class="filled-text">-</span> lembar</td>
        </tr>
    </table>

    <table style="border: 2px solid black; border-top: none;">
        <tr><td style="background: #e6e6e6; border-bottom: 1px solid black; padding: 2px;"><span class="label-bold">Penyuluhan Kesehatan</span></td></tr>
        <tr>
            <td style="padding: 5px;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 5px;">
                    <i class="far fa-check-square"></i> 
                    <span class="filled-text">Kompres dingin di luka post MIBT</span>
                </div>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 5px;">
                    <i class="far fa-square"></i> 
                    <span class="filled-text">....................................</span>
                </div>
                 <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="far fa-square"></i> 
                    <span class="filled-text">....................................</span>
                </div>
            </td>
        </tr>
    </table>

    <table style="border: 2px solid black; border-top: none;">
        <tr><td colspan="2" style="background: #e6e6e6; border-bottom: 1px solid black; padding: 2px;"><span class="label-bold">Jadwal Kontrol</span></td></tr>
        <tr>
            <td style="border:none; padding-left: 10px;">
                <table style="border:none;">
                    <tr><td style="border:none; width: 120px;">a. Hari/Tanggal</td><td style="border:none;">: <span class="filled-text">Rabu, 15 Oktober 2025</span></td></tr>
                    <tr><td style="border:none;">b. Poli</td><td style="border:none;">: <span class="filled-text">Bedah Payudara</span></td></tr>
                    <tr><td style="border:none;">c. Dengan membawa</td><td style="border:none;">: <span class="filled-text">Hasil USG yang Lama</span></td></tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="ttd-wrapper">
        <div class="ttd-box">
            <div>Yang Diberi Penjelasan<br>Pasien / Keluarga</div>
            <div class="fake-signature" style="margin-top: 40px; color: transparent;">.</div>
            <div>( <span class="filled-text">Keluarga Pasien</span> )</div>
        </div>
        <div class="ttd-box">
            <div style="text-align: center;">Surabaya, <span class="filled-text">10 Oktober 2025</span><br>Yang memberi penjelasan<br>Perawat</div>
            <div class="fake-signature">Suster Siti</div>
            <div>( <span class="filled-text">Sr. Siti</span> )</div>
        </div>
    </div>

    <div class="footer-contact">
        <div class="footer-item"><i class="fas fa-headset"></i> +62 31 3000 8008</div>
        <div class="footer-item"><i class="fab fa-whatsapp"></i> +62 31 3000 9009</div>
        <div class="footer-item"><i class="far fa-envelope"></i> info@medicelle.co.id</div>
        <div class="footer-item"><i class="fas fa-globe"></i> www.medicelle.co.id</div>
    </div>
</div>

</body>
</html>