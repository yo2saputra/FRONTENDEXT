<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>
<link rel="stylesheet" href="<?= base_url('plugins/toastr/toastr.min.css') ?>">
<style>
    .form-container-paper {
        background: white;
        padding: 40px;
        border: 1px solid #000;
        margin: 0 auto;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 10px !important;
        color: #000;
        min-height: 297mm;
        display: flex;
        flex-direction: column;
    }

    table { width: 100%; border-collapse: collapse; border-spacing: 0; }
    td, th { vertical-align: top; padding: 3px 5px; }
    
    .box-outer { border: 1px solid black; }
    .border-all td { border: 1px solid black; }
    .bg-gray { background-color: #e0e0e0 !important; font-weight: bold; border-top: 1px solid black; border-bottom: 1px solid black; padding: 3px 5px; }
    
    .bold { font-weight: bold; }
    .text-center { text-align: center; }

    .input-invisible {
        border: none;
        border-bottom: 1px dotted black;
        outline: none;
        background: transparent;
        font-family: 'Courier New', Courier, monospace;
        font-weight: bold;
        font-size: 11px;
        width: 100%;
    }
    .input-invisible:focus { background: #f0f8ff; }

    .input-triage {
        width: 45px !important;
        border: none;
        border-bottom: 1px dotted black;
        text-align: center;
        outline: none;
        background: transparent;
        font-weight: bold;
    }

    textarea.full-cell {
        width: 100%;
        border: none;
        resize: none;
        outline: none;
        background: transparent;
        font-family: 'Courier New', monospace;
        font-weight: bold;
        line-height: 1.5;
    }

    .cb-custom { 
        width: 12px; height: 12px; border: 1px solid black; 
        display: inline-block; text-align: center; line-height: 10px; font-size: 10px;
    }
    input[type="checkbox"] { margin-right: 5px; transform: scale(1.1); }

    .footer-pdf {
        margin-top: auto;
        border-top: 1px solid #ccc;
        padding-top: 5px;
        font-size: 8px;
        color: #444;
    }

    .ttd-box {
        padding: 10px, 5px;
        text-align: center;
        vertical-align: top;
        height: 120px;
    }

    .ttd-box input[type="file"] {
        font-size: 8px;
        width: 150px;
        margin: 10px auto;
        display: inline-block;
    }

    .nama-ttd-wrapper {
        width: 100%;
        margin-top: auto;
        padding-top: 5px;
    }   

    .input-tgl-ttd {
        width: 150px !important;
        border: none;
        border-bottom: 1px dotted black;
        text-align: center;
        background: transparent;
        font-weight: bold;
    }
</style>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid pt-3">
            <form id="form_pulang" action="<?= base_url('tmstformulir/save/pulang') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>

                <div class="form-container-paper">
                    <table style="margin-bottom: 10px;">
                        <tr>
                            <td>
                                <img src="<?= base_url('assets/img/Logo_MedicElle.png') ?>" height="45">
                                <div style="font-size: 8px; margin-top: 2px;">Jl. Raya Gubeng No. 11, Surabaya - 60281</div>
                            </td>
                        </tr>
                    </table>

                    <div class="text-center bold" style="font-size: 11px; text-decoration: underline; margin-bottom: 8px;">PETUNJUK PASIEN PULANG</div>

                    <div class="box-outer">
                        <table class="border-all" style="border: none;">
                            <tr>
                                <td width="55%" style="border-right: 1px solid black; border-bottom: 1px solid black;">
                                    <table width="100%">
                                        <tr><td width="80">Nama Pasien</td><td width="5">:</td><td><input type="text" name="nama" class="input-invisible" placeholder=""></td></tr>
                                        <tr><td>Jenis Kelamin</td><td>:</td><td><input type="text" name="jk" class="input-invisible" placeholder="L/P" style="width: 40px;"></td></tr>
                                        <tr><td>Tanggal Lahir</td><td>:</td><td><input type="text" name="tgl_lahir" class="input-invisible" placeholder="dd/mm/yyyy"></td></tr>
                                    </table>
                                </td>
                                <td width="45%" style="border-bottom: 1px solid black;">
                                     <table width="100%">
                                        <tr><td width="80">NO. RM</td><td width="5">:</td><td><input type="text" name="rm" class="input-invisible" placeholder=""></td></tr>
                                        <tr><td>Alamat</td><td>:</td><td><input type="text" name="alamat" class="input-invisible" placeholder=""></td></tr>
                                        <tr><td>Tanggal Periksa</td><td>:</td><td><input type="text" name="tgl_periksa" class="input-invisible" placeholder="dd/mm/yyyy"></td></tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        <div style="border-bottom: 1px solid black; padding: 5px;">
                            <span class="bold">Diagnosa Medis :</span> 
                            <input type="text" name="diagnosa" class="input-invisible" style="width: 80%;" placeholder="">
                        </div>

                        <div class="bg-gray">Observasi Triage :</div>
                        <div style="border-bottom: 1px solid black; padding: 8px 5px;">
                            BB <input type="text" name="bb" class="input-triage"> kg, &nbsp;
                            TB <input type="text" name="tb" class="input-triage"> cm, &nbsp;
                            Tensi <input type="text" name="tensi" class="input-triage" style="width: 60px !important;"> mmHg, &nbsp;
                            Nadi <input type="text" name="nadi" class="input-triage"> x/mnt, &nbsp;
                            RR <input type="text" name="rr" class="input-triage"> x/mnt, &nbsp;
                            Suhu <input type="text" name="suhu" class="input-triage"> °C
                        </div>

                        <div class="bg-gray">Obat-obatan (Jenis, Dosis, dan Cara Pemakaian)</div>
                        <table style="width: 100%; border-bottom: 1px solid black;">
                            <tr>
                                <td style="padding: 5px;">
                                    <div class="bold">a. Yang telah diberikan di klinik</div>
                                    <textarea name="obat_klinik" rows="2" class="full-cell" placeholder=".........."></textarea>
                                    <div class="bold" style="margin-top: 5px;">b. Yang dibawa pulang</div>
                                    <textarea name="obat_pulang" rows="4" class="full-cell" placeholder=".........."></textarea>
                                </td>
                            </tr>
                        </table>

                        <div class="bg-gray">Hasil-hasil Pemeriksaan</div>
                        <table style="width: 100%; border-bottom: 1px solid black;">
                            <tr>
                                <td width="15%">Laboratorium</td><td width="35%">: <input type="text" name="lab" class="input-triage"> lembar</td>
                                <td width="15%">USG</td><td width="35%">: <input type="text" name="usg" class="input-triage"> lembar</td>
                            </tr>
                            <tr>
                                <td>Foto Thorax</td><td>: <input type="text" name="thorax" class="input-triage"> lembar</td>
                                <td>Lainnya</td><td>: <input type="text" name="lain" class="input-triage"> lembar</td>
                            </tr>
                        </table>

                        <div class="bg-gray">Penyuluhan Kesehatan</div>
                        <div style="border-bottom: 1px solid black; padding: 5px;">
                            <div style="margin-bottom: 5px;"><input type="checkbox" name="edu1" > <input type="text" name="edu_txt1" class="input-invisible" style="width: 90%;" value=""></div>
                            <div style="margin-bottom: 5px;"><input type="checkbox" name="edu2"> <input type="text" name="edu_txt2" class="input-invisible" style="width: 90%" placeholder=""></div>
                        </div>

                        <div class="bg-gray">Jadwal Kontrol</div>
                        <div style="padding: 5px;">
                            <table width="100%">
                                <tr><td width="100">a. Hari/Tanggal</td><td width="10">:</td><td><input type="text" name="kontrol_tgl" class="input-invisible"></td></tr>
                                <tr><td>b. Poli</td><td>:</td><td><input type="text" name="kontrol_poli" class="input-invisible"></td></tr>
                                <tr><td>c. Dengan membawa</td><td>:</td><td><input type="text" name="kontrol_bawa" class="input-invisible"></td></tr>
                            </table>
                        </div>
                    </div>

                    <table class="box-outer" style="width: 100%; margin-top: 10px; border-top: 1px solid black;">
                        <tr>
                            <td width="50%" class="ttd-box" style="border-right: 1px solid black;">
                                <div class="bold">Yang Diberi Penjelasan</div>
                                <div>Pasien / Keluarga</div>
                                
                                <input type="file" name="ttd_keluarga">
                                
                                <div class="nama-ttd-wrapper">
                                    ( <input type="text" name="n_keluarga" class="input-invisible text-center" style="width: 80%" placeholder="Nama Terang"> )
                                </div>
                            </td>
                            
                            <td width="50%" class="ttd-box">
                                <div>
                                    Surabaya, <input type="text" name="tgl_ttd" class="input-tgl-ttd" value="" placeholder="dd/mm/yy" style="width: 100px !important;">
                                </div>
                                <div class="bold">Yang memberi penjelasan</div>
                                <div>Perawat</div>
                                
                                <input type="file" name="ttd_perawat">
                                
                                <div class="nama-ttd-wrapper">
                                    ( <input type="text" name="n_perawat" class="input-invisible text-center" style="width: 80%" placeholder="Nama Perawat"> )
                                </div>
                            </td>
                        </tr>
                    </table>

                    <div class="footer-pdf">
                        <table width="100%">
                            <tr>
                                <td width="25%">+62 31 3000 8008</td>
                                <td width="25%">+62 31 3000 9009</td>
                                <td width="25%">info@medicelle.co.id</td>
                                <td width="25%" align="right">www.medicelle.co.id</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="mt-3 text-right pb-5">
                    <a href="<?= base_url('tmstformulir') ?>" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary" id="btn_save">
                        <i class="fas fa-save mr-1"></i> Simpan Petunjuk Pulang
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script src="<?= base_url('plugins/toastr/toastr.min.js') ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $('#form_pulang').on('submit', function(e) {
        e.preventDefault();
        let btn = $('#btn_save');
        let formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            beforeSend: function() { btn.prop('disabled', true).html('Saving...'); },
            success: function(res) {
                if(res.status === 'success') {
                    Swal.fire('Berhasil!', res.message, 'success').then(() => {
                        window.location.href = "<?= base_url('tmstformulir') ?>";
                    });
                }
            },
            error: function() { 
                btn.prop('disabled', false).html('Simpan Petunjuk Pulang');
                toastr.error('Sistem error!'); 
            }
        });
    });
</script>
<?= $this->endSection(); ?>