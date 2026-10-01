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
    td, th { vertical-align: top; padding: 4px 6px; }
    
    .box-outer { border: 1px solid black; flex-grow: 1; }
    .bb { border-bottom: 1px solid black; }
    .br { border-right: 1px solid black; }
    .bg-gray { background-color: #d0d0d0 !important; font-weight: bold; padding: 4px 8px; }
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

    .input-tgl-ttd {
        width: 130px !important;
        border: none;
        border-bottom: 1px dotted black;
        text-align: center;
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
        min-height: 80px;
    }

    .footer-pdf {
        margin-top: auto;
        border-top: 1px solid #ccc;
        padding-top: 5px;
        font-size: 8px;
        color: #444;
    }
</style>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid pt-3">
            <form id="form_observasi" action="<?= base_url('tmstformulir/save/observasi') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>

                <div class="form-container-paper">
                    <table class="box-outer" style="border-bottom: none;">
                        <tr>
                            <td width="50%" class="br text-center" style="padding: 15px; vertical-align: middle;">
                                <img src="<?= base_url('assets/img/Logo_MedicElle.png') ?>" style="height: 45px;">
                                <div style="font-size: 8px; margin-top: 5px;">Jl. Raya Gubeng No. 11, Surabaya - 60281</div>
                            </td>
                            <td width="50%" class="text-center" style="vertical-align: middle; background-color: #f0f0f0 !important;">
                                <div class="bold" style="font-size: 11px;">LEMBAR OBSERVASI TINDAKAN PASIEN</div>
                                <div class="bold" style="font-size: 11px;">DENGAN LOKAL ANESTESI</div>
                            </td>
                        </tr>
                    </table>

                    <div class="box-outer">
                        <table class="bb">
                            <tr><td width="20%">Nama</td><td width="2%">:</td><td><input type="text" name="nama" class="input-invisible"></td></tr>
                            <tr><td>NO RM</td><td>:</td><td><input type="text" name="rm" class="input-invisible" ></td></tr>
                            <tr><td>Tanggal Lahir</td><td>:</td><td><input type="text" name="tgl_lahir" class="input-invisible" placeholder="dd/mm/yyyy"></td></tr>
                            <tr><td>Diagnosis Medis</td><td>:</td><td><input type="text" name="diagnosis" class="input-invisible" ></td></tr>
                            <tr><td>Tindakan</td><td>:</td><td><input type="text" name="tindakan" class="input-invisible" ></td></tr>
                        </table>

                        <div class="bg-gray bb">KEADAAN PRA TINDAKAN</div>
                        <table class="bb">
                            <tr><td>KEADAAN UMUM :</td><td><input type="text" name="pra_ku" class="input-invisible" ></td></tr>
                            <tr><td colspan="2">TANDA-TANDA VITAL :</td></tr>
                            <tr>
                                <td colspan="2" style="padding-left: 15px; padding-bottom: 8px;">
                                    TD: <input type="text" name="pra_td" class="input-invisible" style="width: 60px;"> mmHg &nbsp;&nbsp;
                                    Suhu: <input type="text" name="pra_suhu" class="input-invisible" style="width: 40px;"> °C &nbsp;&nbsp;
                                    Nadi: <input type="text" name="pra_nadi" class="input-invisible" style="width: 40px;"> x/mnt &nbsp;&nbsp;
                                    RR: <input type="text" name="pra_rr" class="input-invisible" style="width: 40px;"> x/mnt &nbsp;&nbsp;
                                    SPO2: <input type="text" name="pra_spo2" class="input-invisible" style="width: 40px;"> %
                                </td>
                            </tr>
                        </table>

                        <div class="bg-gray bb">KEADAAN INTRA TINDAKAN</div>
                        <table class="bb">
                            <tr><td width="20%">KEADAAN UMUM :</td><td colspan="3"><input type="text" name="intra_ku" class="input-invisible"></td></tr>
                            <tr><td>DOKTER :</td><td colspan="3"><input type="text" name="dokter_nama" class="input-invisible"></td></tr>
                            <tr><td>OBAT ANESTESI :</td><td colspan="3"><input type="text" name="obat_anestesi" class="input-invisible"></td></tr>
                            <tr><td>JAM MULAI :</td><td><input type="text" name="jam_mulai" class="input-invisible"></td><td width="15%">JAM SELESAI :</td><td><input type="text" name="jam_selesai" class="input-invisible"></td></tr>
                            <tr><td colspan="4">TANDA-TANDA VITAL :</td></tr>
                            <tr>
                                <td colspan="4" style="padding-left: 15px; padding-bottom: 8px;">
                                    TD: <input type="text" name="intra_td" class="input-invisible" style="width: 60px;"> mmHg &nbsp;&nbsp;
                                    Suhu: <input type="text" name="intra_suhu" class="input-invisible" style="width: 40px;"> °C &nbsp;&nbsp;
                                    Nadi: <input type="text" name="intra_nadi" class="input-invisible" style="width: 40px;"> x/mnt &nbsp;&nbsp;
                                    RR: <input type="text" name="intra_rr" class="input-invisible" style="width: 40px;"> x/mnt &nbsp;&nbsp;
                                    SPO2: <input type="text" name="intra_spo2" class="input-invisible" style="width: 40px;"> %
                                </td>
                            </tr>
                        </table>

                        <div class="bg-gray bb">KEADAAN POST TINDAKAN</div>
                        <table class="bb">
                            <tr><td width="20%">KEADAAN UMUM :</td><td><input type="text" name="post_ku" class="input-invisible"></td></tr>
                            <tr><td colspan="2">TANDA-TANDA VITAL :</td></tr>
                            <tr>
                                <td colspan="2" style="padding-left: 15px; padding-bottom: 8px;">
                                    TD: <input type="text" name="post_td" class="input-invisible" style="width: 60px;"> mmHg &nbsp;&nbsp;
                                    Suhu: <input type="text" name="post_suhu" class="input-invisible" style="width: 40px;"> °C &nbsp;&nbsp;
                                    Nadi: <input type="text" name="post_nadi" class="input-invisible" style="width: 40px;"> x/mnt &nbsp;&nbsp;
                                    RR: <input type="text" name="post_rr" class="input-invisible" style="width: 40px;"> x/mnt &nbsp;&nbsp;
                                    SPO2: <input type="text" name="post_spo2" class="input-invisible" style="width: 40px;"> %
                                </td>
                            </tr>
                        </table>

                        <div style="padding: 10px; min-height: 120px;">
                            <div class="bold" style="text-decoration: underline; margin-bottom: 5px;">CATATAN :</div>
                            <textarea name="catatan" class="full-cell" placeholder="Tambahkan catatan observasi di sini..."></textarea>
                        </div>
                    </div>

                    <table style="width: 100%; margin-top: 15px;">
                        <tr>
                            <td width="50%" style="text-align: center;">
                                <div style="display: flex; flex-direction: column; align-items: center; height: 100%;">
                                    <div>Perawat</div>
                                    <input type="file" name="ttd_perawat" style="font-size: 8px; margin: 15px 0;">
                                    <div style="margin-top: auto;">
                                         <input type="text" name="perawat_nama" class="input-invisible text-center" style="width: 150px;" placeholder="Nama Perawat"> 
                                    </div>
                                </div>
                            </td>
                            <td width="50%" style="text-align: center;">
                                <div style="display: flex; flex-direction: column; align-items: center; height: 100%;">
                                    <div>Surabaya, <input type="text" name="kota_tgl" class="input-tgl-ttd" value=""><br>Dokter</div>
                                    <input type="file" name="ttd_dokter" style="font-size: 8px; margin: 15px 0;">
                                    <div style="margin-top: auto;">
                                        <input type="text" name="dokter_verif" class="input-invisible text-center" style="width: 150px;" placeholder="Nama Dokter"> 
                                    </div>
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
                        <i class="fas fa-save mr-1"></i> Simpan Observasi Tindakan
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
    $('#form_observasi').on('submit', function(e) {
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
                btn.prop('disabled', false).html('Simpan Observasi Tindakan');
                toastr.error('Gagal menyimpan data!'); 
            }
        });
    });
</script>
<?= $this->endSection(); ?>