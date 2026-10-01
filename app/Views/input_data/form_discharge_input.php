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
    }

    table { width: 100%; border-collapse: collapse; border-spacing: 0; }
    td, th { vertical-align: top; padding: 2px 4px; }
    
    .box-outer { border: 1px solid black; }
    .bb { border-bottom: 1px solid black; }
    .br { border-right: 1px solid black; }
    .bold { font-weight: bold; }
    .text-center { text-align: center; }
    .text-right { text-align: right; }

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

    .cb-wrapper { display: inline-flex; align-items: center; margin-right: 15px; cursor: pointer; }
    .cb-custom { 
        width: 12px; height: 12px; 
        border: 1px solid black; 
        margin-right: 5px; 
        display: inline-block; 
        text-align: center; line-height: 10px; font-size: 10px;
    }
    input[type="checkbox"]:checked + .cb-custom::before { content: 'v'; font-weight: bold; }
    input[type="checkbox"] { display: none; }

    .w-full { width: 98%; }
    .w-short { width: 150px; }

    

    .ttd-box-input {
        border: 1px solid black;
        margin-top: 10px;
        padding: 10px;
    }

    .ttd-box-cell {
        text-align: center;
        padding: 10px 5px;
        vertical-align: top;
    }

    .ttd-box input[type="file"] {
        font-size: 8px;
        width: 150%;
        margin: 10px auto;
        display: block;
    }

    
</style>
<?= $this->endSection('style'); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid pt-3">
            <form id="form_discharge" action="<?= base_url('tmstformulir/save/discharge') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>

                <div class="form-container-paper">
                    <table style="margin-bottom: 10px; width: 100%;">
                        <tr>
                            <td width="50%" style="vertical-align: middle;">
                                <table width="100%">
                                    <tr>
                                        <td width="20%">
                                            <img src="<?= base_url('assets/img/Logo_MedicElle.png') ?>" style="height: 45px; width: auto;">
                                        </td>
                                        <td width="80%" style="vertical-align: middle;">
                                            <div style="font-size: 8px; margin-left: 5px;">Jl. Raya Gubeng No. 11, Surabaya - 60281</div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td width="50%" style="text-align: right; vertical-align: middle;">
                                <div class="bold" style="font-size: 18px; font-family: 'Times New Roman', serif;"></div>
                                <div style="font-size: 9px; letter-spacing: 2px; font-weight: bold;"></div>
                            </td>
                        </tr>
                    </table>

                    <div class="text-center bold" style="font-size: 12px; margin-bottom: 5px;">LEMBAR DISCHARGE PLANNING</div>

                    <div class="box-outer">
                        <table class="bb">
                            <tr>
                                <td width="55%" class="br" style="padding: 5px;">
                                    <table width="100%">
                                        <tr><td width="30%">Nama Pasien</td><td width="2%">:</td><td><input type="text" name="nama" class="input-invisible" value="" placeholder=""></td></tr>
                                        <tr><td>Jenis Kelamin</td><td>:</td><td><input type="text" name="jk" class="input-invisible" value="" placeholder="L/P" style="width:30px;"></td></tr>
                                        <tr><td>Tanggal Lahir</td><td>:</td><td><input type="text" name="tgl_lahir" class="input-invisible" value="" placeholder="dd/mm/yy " ></td></tr>
                                    </table>
                                </td>
                                <td width="45%" style="padding: 5px;">
                                    <table width="100%">
                                        <tr><td width="35%">NO RM</td><td width="2%">:</td><td><input type="text" name="rm" class="input-invisible" value="" placeholder="" ></td></tr>
                                        <tr><td>Alamat</td><td>:</td><td><input type="text" name="alamat" class="input-invisible" value="" placeholder="" ></td></tr>
                                        <tr><td>Tanggal Periksa</td><td>:</td><td><input type="text" name="tgl_periksa" class="input-invisible" value="" placeholder="dd/mm/yyyy"></td></tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        <div class="bb" style="padding: 8px 5px;">
                            <span class="bold">Diagnosa Medis :</span> 
                            <input type="text" name="diagnosa" class="input-invisible" style="width: 85%;">
                        </div>

                        <div class="bb" style="padding: 8px 5px;">
                            <div class="bold" style="margin-bottom: 5px;">Dipulangkan dari Klinik dalam keadaan :</div>
                            <table width="100%">
                                <tr>
                                    <td width="50%">
                                        <label class="cb-wrapper"><input type="checkbox" name="kondisi[]" value="sembuh"><span class="cb-custom"></span> Sembuh</label><br>
                                        <label class="cb-wrapper"><input type="checkbox" name="kondisi[]" value="berobat_jalan" ><span class="cb-custom"></span> Meneruskan Berobat Jalan</label><br>
                                        <label class="cb-wrapper"><input type="checkbox" name="kondisi[]" value="pindah"><span class="cb-custom"></span> Pindah ke Klinik/RS Lain</label>
                                    </td>
                                    <td width="50%">
                                        <label class="cb-wrapper"><input type="checkbox" name="kondisi[]" value="paksa"><span class="cb-custom"></span> Pulang Paksa</label><br>
                                        <label class="cb-wrapper"><input type="checkbox" name="kondisi[]" value="lari"><span class="cb-custom"></span> Lari</label><br>
                                        <label class="cb-wrapper"><input type="checkbox" name="kondisi[]" value="meninggal"><span class="cb-custom"></span> Meninggal</label>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="bb" style="padding: 8px 5px;">
                            <div class="bold">A. Kontrol</div>
                            <table width="100%" style="margin-left: 10px; margin-top: 3px;">
                                <tr><td width="20">a.</td><td width="50">Waktu</td><td width="5">:</td><td><input type="text" name="kontrol_waktu" class="input-invisible w-full"></td></tr>
                                <tr><td>b.</td><td>Tempat</td><td>:</td><td><input type="text" name="kontrol_tempat" class="input-invisible w-full"></td></tr>
                            </table>
                        </div>

                        <div class="bb" style="padding: 8px 5px;">
                            <div class="bold">B. Lanjutan Perawatan di Rumah</div>
                            <div style="margin-top: 5px;"><label class="cb-wrapper"><input type="checkbox" ><span class="cb-custom"></span></label> <input type="text" name="perawatan" class="input-invisible w-full" style="width: 90%;"></div>
                        </div>

                        <div class="bb" style="padding: 8px 5px;">
                            <div class="bold">C. Aturan Diet/Nutrisi</div>
                            <div style="margin-top: 5px;"><label class="cb-wrapper"><input type="checkbox" ><span class="cb-custom"></span></label> <input type="text" name="diet" class="input-invisible w-full" style="width: 90%;"></div>
                        </div>

                        <div class="bb" style="padding: 8px 5px;">
                            <div class="bold">D. Obat-obatan yang masih diminum</div>
                            <div style="margin-top: 5px;"><label class="cb-wrapper"><input type="checkbox" ><span class="cb-custom"></span></label> <input type="text" name="obat1" class="input-invisible w-full" style="width: 90%;"></div>
                            <div style="margin-top: 5px;"><label class="cb-wrapper"><input type="checkbox" ><span class="cb-custom"></span></label> <input type="text" name="obat2" class="input-invisible w-full" style="width: 90%;"></div>
                        </div>

                        <div class="bb" style="padding: 8px 5px;">
                            <div class="bold">E. Aktivitas dan Istirahat</div>
                            <div style="margin-top: 5px;"><label class="cb-wrapper"><input type="checkbox"><span class="cb-custom"></span></label> <input type="text" name="aktivitas" class="input-invisible w-full" style="width: 90%;"></div>
                        </div>

                        <div class="bb" style="padding: 8px 5px;">
                            <div class="bold">F. Hasil Pemeriksaan Penunjang</div>
                            <div style="margin-top: 5px;">Hasil USG : <input type="text" name="usg" class="input-invisible w-short"></div>
                            <div style="margin-top: 5px;">Surat Ket. Istirahat : <input type="text" name="istirahat" class="input-invisible w-short"></div>
                        </div>

                        <div style="padding: 8px 5px; min-height: 50px;">
                            <div class="bold">G. Lain-lain :</div>
                            <input type="text" name="lain_lain" class="input-invisible w-full">
                        </div>
                    </div>

                    <div style="margin-top: 10px;">
                        Surabaya, <input type="text" name="tgl_ttd" class="input-invisible w-short text-center" value="">
                    </div>

                    <table class="box-outer" style="margin-top: 10px; width: 100%;">
                        <tr>
                            <td width="33.3%" class="ttd-box-cell">
                                Pasien / Keluarga<br><br>
                                
                                <input type="file" name="ttd_pasien">
                                
                                <div style="margin-top: 10px;">
                                    ( <input type="text" name="nama_pasien_ttd" class="input-invisible text-center" style="width: 80%;" placeholder=""> )
                                </div>
                            </td>

                            <td width="33.4%" class="ttd-box-cell" style="border-left: 1px solid black; border-right: 1px solid black;">
                                Mengetahui,<br>Dokter<br><br>
                                
                                <input type="file" name="ttd_dokter">
                                
                                <div style="margin-top: 10px;">
                                    ( <input type="text" name="nama_dokter_ttd" class="input-invisible text-center" style="width: 80%;" placeholder=""> )
                                </div>
                            </td>

                            <td width="33.3%" class="ttd-box-cell">
                                Perawat<br><br>
                                
                                <input type="file" name="ttd_perawat">
                                
                                <div style="margin-top: 10px;">
                                    ( <input type="text" name="nama_perawat_ttd" class="input-invisible text-center" style="width: 80%;" placeholder=""> )
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="mt-3 text-right pb-5">
                    <a href="<?= base_url('tmstformulir') ?>" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary" id="btn_save">
                        <i class="fas fa-save mr-1"></i> Simpan Discharge Planning
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
    $('#form_discharge').on('submit', function(e) {
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
                btn.prop('disabled', false).html('Simpan Discharge Planning');
                toastr.error('Error simpan data!'); 
            }
        });
    });
</script>
<?= $this->endSection(); ?>