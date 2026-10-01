<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Formulir CPPT Medicelle - Dynamic Height</title>
<style>

    * { 
        box-sizing: border-box; 
        -webkit-print-color-adjust: exact; 
        print-color-adjust: exact;
    }
    
    body { 
        background-color: #525659; 
        font-family: Arial, sans-serif; 
        padding: 40px;
        margin: 0;
        display: flex;
        justify-content: center;
    }

    .form-container {
        background: white;
        width: 210mm; 
        min-height: 297mm; 
        height: auto;      
        border: 2px solid black; 
        padding: 0;
        position: relative;
        box-shadow: 0 0 20px rgba(0,0,0,0.5);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        table-layout: fixed; 
    }
    
    td, th {
        border: 1px solid black;
        padding: 0;
        vertical-align: middle;
        font-size: 11px;
        word-wrap: break-word; 
    }


    .header-row td { padding: 5px; }

    .logo-box {
        width: 50%;
        vertical-align: top;
        height: 110px;
        border-right: 1px solid black;
    }
    
    .pasien-box {
        width: 50%;
        vertical-align: top;
        padding: 0 !important;
    }

    .judul-pasien {
        font-weight: bold;
        font-size: 10px;
        padding: 5px;
        border-bottom: 1px solid black;
    }

    .form-pasien {
        width: 100%;
        padding: 5px;
        font-size: 11px;
        font-weight: bold;
    }

    .row-input {
        display: flex;
        align-items: center;
        margin-bottom: 5px;
        justify-content: space-between;
    }
    .label { width: 80px; }
    .titik-dua { width: 10px; text-align: center; }
    
    .filled-data {
        flex-grow: 1;
        border-bottom: 1px dotted black;
        font-family: 'Courier New', monospace;
        font-weight: bold;
        font-size: 12px;
        padding-left: 5px;
        color: #000;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .lp-wrapper {
        display: flex;
        gap: 5px;
        margin-left: 10px;
        font-size: 10px;
        align-items: center;
    }
    .gender-label {
        width: 20px; height: 20px;
        text-align: center;
        line-height: 18px;
        border-radius: 50%;
        border: 1px solid transparent;
        display: inline-block;
        font-weight: bold;
    }
    .gender-selected { border: 1px solid black; }

    .judul-tengah {
        text-align: center;
        background-color: #e6e6e6;
        padding: 8px !important;
        border-top: 2px solid black;
        border-bottom: 2px solid black;
    }
    .main-title { font-weight: bold; font-size: 12px; text-transform: uppercase; }
    .sub-title { font-size: 9px; font-style: italic; font-weight: normal; margin-top: 2px; }

    .header-kolom th {
        background-color: #e6e6e6;
        text-align: center;
        padding: 5px;
        font-weight: normal;
        height: 45px;
        border: 1px solid black;
    }

    .data-row td {
        height: auto; 
        vertical-align: top;
        padding: 8px 5px;
        

        border-top: none;
        border-bottom: 1px dotted #ccc; 
        
        border-left: 1px solid black;
        border-right: 1px solid black;
        
        font-family: Arial, sans-serif;
        font-size: 11px;
        line-height: 1.5;
    }

    .data-row:last-child td {
        border-bottom: 1px solid black; 
    }

    .text-soap {
        white-space: pre-wrap; 
    }

    .ttd-box {
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        height: 100%; 
        min-height: 80px;
        align-items: center;
        padding-bottom: 10px;
    }
    .nama-dokter {
        margin-top: 20px;
        font-weight: bold;
        text-decoration: underline;
    }

</style>
</head>
<body>

<div class="form-container">
    <table>
        <tr class="header-row">
            <td class="logo-box">
                <div style="font-size: 26px; font-weight: bold; font-family: 'Times New Roman';">MEDICELLE</div>
                <div style="font-size: 13px; font-weight: bold; letter-spacing: 4px; font-family: 'Times New Roman'; margin-left: 2px;">C L I N I C</div>
                <div style="font-size: 10px; margin-top: 10px; font-family: Arial;">Jl. Raya Gubeng No. 11, Surabaya - 60281</div>
            </td>

            <td class="pasien-box">
                <div class="judul-pasien">
                    CATATAN PERKEMBANGAN PASIEN TERINTEGRASI
                </div>
                <div class="form-pasien">
                    <div class="row-input">
                        <span class="label">NO RM</span>
                        <span class="titik-dua">:</span>
                        <div class="filled-data">12.34.56.78</div>
                        
                        <div class="lp-wrapper">
                            (
                            <span class="gender-label">L</span>
                            /
                            <span class="gender-label gender-selected">P</span>
                            )
                        </div>
                    </div>
                    <div class="row-input">
                        <span class="label">Nama Pasien</span>
                        <span class="titik-dua">:</span>
                        <div class="filled-data">Ny. Lorem Ipsum Dolor</div>
                    </div>
                    <div class="row-input">
                        <span class="label">Tgl Lahir</span>
                        <span class="titik-dua">:</span>
                        <div class="filled-data">01 / 01 / 1980</div>
                    </div>
                </div>
            </td>
        </tr>

        <tr>
            <td colspan="2" class="judul-tengah">
                <div class="main-title">CATATAN PERKEMBANGAN TERINTEGRASI</div>
                <div class="sub-title">
                    (Ditulis dengan format SOAP, disertai dengan target dan tujuan terukur, dituliskan nama dan paraf pada setiap akhir catatan, DPJP harus membaca dan memverifikasi ulang seluruh rencana perawatan)
                </div>
            </td>
        </tr>
    </table>

    <table style="border-top: none;"> 
        <thead>
            <tr class="header-kolom">
                <th width="10%">Tanggal/<br>Jam</th>
                <th width="15%">Profesional<br>Pemberi<br>Asuhan</th>
                <th width="30%">Hasil Asesmen Pasien dan<br>Pemberian Pelayanan</th>
                <th width="30%">INSTRUKSI PPA<br><span style="font-size:9px">(Ditulis rinci termasuk pasca bedah)</span></th>
                <th width="15%">Verifikasi DPJP<br><span style="font-size:9px">(Nama Terang & Tanda Tangan)</span></th>
            </tr>
        </thead>
        <tbody>
            
            <tr class="data-row">
                <td align="center">
                    03/02/2026<br>08:00
                </td>
                <td>
                    <b>Perawat</b><br>
                    Sr. Siti
                </td>
                <td class="text-soap">S: Nyeri luka operasi berkurang.
O: Luka kering, tidak ada rembesan.
A: Masalah teratasi sebagian.
P: Lanjutkan intervensi.</td>
                <td class="text-soap">- Ganti balut sore ini.</td>
                <td>
                    <div class="ttd-box">
                        <div class="nama-dokter">( Sr. Siti )</div>
                    </div>
                </td>
            </tr>

            <tr class="data-row">
                <td align="center">
                    03/02/2026<br>10:00
                </td>
                <td>
                    <b>dr. Spesialis</b><br>
                    Sp.PD
                </td>
                <td class="text-soap">S: Pasien mengatakan masih merasa lemas namun sudah bisa duduk sendiri. Mual berkurang, muntah (-). Makan habis 1/2 porsi.

O: Keadaan Umum Sedang. Kesadaran Compos Mentis.
GCS 456.
TD: 110/70 mmHg
Nadi: 82 x/menit
RR: 20 x/menit
Suhu: 36.8 C
SpO2: 98% room air.

Pemeriksaan Fisik:
- Kepala: Anemis (-/-), Ikterik (-/-)
- Thorax: Simetris, Retraksi (-), Cor S1S2 tunggal reg, Pulmo Vesikuler (+/+) Rh (-/-) Wh (-/-)
- Abdomen: Soepel, BU (+) normal, Nyeri tekan epigastrium berkurang.
- Ekstremitas: Akral hangat, CRT < 2 detik, Edema (-).

Lab Pagi Ini:
- Hb: 11.2
- Leukosit: 8.500
- Trombosit: 250.000
- GDA: 110

A: Dyspepsia Syndrome + Febris H-3 (Susp. Viral Infection) dd/ Typhoid Fever.
Masalah keperawatan: Resiko defisit nutrisi, Hipertermia (teratasi).

P: 
1. IVFD RL 20 tpm (makro).
2. Inj. Omeprazole 40mg/12 jam IV.
3. Inj. Ondansetron 4mg/8 jam IV (k/p mual).
4. PO: Sucralfate syr 3x1 C.
5. PO: Paracetamol 500mg (jika suhu > 38C).
6. Diet Lunak TKTP.
7. Mobilisasi bertahap.
8. Edukasi keluarga tentang kebersihan makanan.</td>
                
                <td class="text-soap">- Lapor DPJP jika ada muntah profus atau nyeri perut hebat.
- Pantau intake output cairan per 24 jam.
- Cek ulang Darah Lengkap + Widal besok pagi jika masih demam.
- Motivasi pasien untuk makan sedikit tapi sering.
- Pastikan pasien minum air putih minimal 2 liter/hari.

Instruksi Tambahan:
Jika pasien mengeluh pusing berputar, boleh diberikan Betahistine 6mg (extra).
Observasi tanda-tanda dehidrasi.</td>
                
                <td>
                    <div class="ttd-box">
                        <div class="nama-dokter">( dr. Spesialis )</div>
                    </div>
                </td>
            </tr>

            <tr class="data-row">
                <td align="center">
                    03/02/2026<br>14:00
                </td>
                <td>
                    <b>Ahli Gizi</b>
                </td>
                <td class="text-soap">S: Pasien mau makan bubur saring.
O: Asupan energi 70% dari kebutuhan.
A: Asupan oral belum adekuat.
P: Lanjut diet lunak, edukasi keluarga untuk memberi snack di antara jam makan utama.</td>
                <td class="text-soap">- Berikan ekstra putih telur 2 butir/hari.</td>
                <td>
                    <div class="ttd-box">
                        <div class="nama-dokter">( Ahli Gizi )</div>
                    </div>
                </td>
            </tr>

        </tbody>
    </table>
</div>

</body>
</html>