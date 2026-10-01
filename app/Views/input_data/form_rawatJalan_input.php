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
        font-size: 11px;
        color: #000;
        max-width: 850px;
    }

    table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
    td, th { vertical-align: middle; padding: 6px 8px; border: 1px solid black; }
    
    .no-border { border: none !important; }
    .text-center { text-align: center; }
    .text-bold { font-weight: bold; }
    
    .bg-gray-custom { 
        background-color: #ffffff !important; 
        color: #000000 !important;           
        font-weight: bold !important;          
        text-transform: uppercase;
        text-align: center;
    }

    .cb-custom-input {
        display: none !important;
    }

    .cb-box {
        display: inline-block;
        width: 14px;
        height: 14px;
        border: 1px solid black;
        text-align: center;
        line-height: 12px;
        vertical-align: middle;
        background: white;
        cursor: pointer;
        font-family: Arial, sans-serif;
        font-weight: bold;
        font-size: 12px;
    }

    .cb-custom-input:checked + .cb-box::before {
        content: "v";
    }

    .input-ttd {
        border: none;
        border-bottom: 1px dotted black;
        outline: none;
        background: transparent;
        font-family: 'Courier New', monospace;
        font-weight: bold;
        text-align: center;
        width: 90%;
    }

    .ttd-preview-wrap {
        min-height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 5px;
    }
</style>
<script>document.title = "<?= $title ?? 'FORM RISIKO JATUH' ?>";</script>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid pt-3">
            <form id="form_rawatJalan" action="<?= base_url('tmstformulir/save/rawatJalan') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>

                <div class="form-container-paper">
                    <table class="no-border" style="margin-bottom: 20px;">
                        <tr class="no-border">
                            <td width="20%" class="no-border">
                            </td>
                            <td width="60%" class="no-border text-center">
                                <div class="text-bold" style="font-size: 14px;">FORM ASSESMENT RISIKO JATUH RAWAT JALAN</div>
                                <div class="text-bold" style="font-size: 14px;">GET UP AND GO</div>
                            </td>
                            <td width="20%" class="no-border"></td>
                        </tr>
                    </table>

                    <div class="text-bold" style="margin-bottom: 5px;">1. Pengkajian</div>
                    <table>
                        <tr class="bg-gray-custom">
                            <td width="5%">No</td>
                            <td width="75%">Penilaian/Pengkajian</td>
                            <td width="10%">Ya</td>
                            <td width="10%">Tidak</td>
                        </tr>
                        <tr>
                            <td class="text-center">a.</td>
                            <td>
                                Cara berjalan pasien <br>
                                &nbsp;&nbsp;&nbsp; 1. Tidak seimbang/ sempoyongan <br>
                                &nbsp;&nbsp;&nbsp; 2. Jalan dengan menggunakan alat bantu (kruk, tripot, kursiroda, bantuan orang)
                            </td>
                            <td class="text-center">
                                <label><input type="radio" name="kajian_a" value="ya" class="cb-custom-input"><span class="cb-box"></span></label>
                            </td>
                            <td class="text-center">
                                <label><input type="radio" name="kajian_a" value="tidak" class="cb-custom-input"><span class="cb-box"></span></label>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">b.</td>
                            <td>
                                Menopang saat akan duduk : tampak memegang pinggiran kursi atau meja atau benda lain sebagai penopang saat akan duduk
                            </td>
                            <td class="text-center">
                                <label><input type="radio" name="kajian_b" value="ya" class="cb-custom-input"><span class="cb-box"></span></label>
                            </td>
                            <td class="text-center">
                                <label><input type="radio" name="kajian_b" value="tidak" class="cb-custom-input"><span class="cb-box"></span></label>
                            </td>
                        </tr>
                    </table>

                    <div class="text-bold" style="margin-bottom: 5px;">2. Hasil</div>
                    <table>
                        <tr class="bg-gray-custom">
                            <td width="5%">No</td>
                            <td width="20%">Hasil</td>
                            <td width="55%">Penilaian/Pengkajian</td>
                            <td width="20%">Keterangan</td>
                        </tr>
                        <tr>
                            <td class="text-center">1.</td>
                            <td>Tidak Berisiko</td>
                            <td>Tidak ditemukan a & b</td>
                            <td class="text-center">
                                <label><input type="radio" name="hasil_risiko" value="tidak_berisiko" class="cb-custom-input"><span class="cb-box"></span></label>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">2.</td>
                            <td>Berisiko Sedang</td>
                            <td>Ditemukan salah satu dari a & b</td>
                            <td class="text-center">
                                <label><input type="radio" name="hasil_risiko" value="sedang" class="cb-custom-input"><span class="cb-box"></span></label>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">3.</td>
                            <td>Berisiko Tinggi</td>
                            <td>Ditemukan a & b</td>
                            <td class="text-center">
                                <label><input type="radio" name="hasil_risiko" value="tinggi" class="cb-custom-input"><span class="cb-box"></span></label>
                            </td>
                        </tr>
                    </table>

                    <div class="text-bold" style="margin-bottom: 5px;">3. Tindakan</div>
                    <table>
                        <tr class="bg-gray-custom">
                            <td width="5%">No</td>
                            <td width="20%">Hasil kajian</td>
                            <td width="35%">Tindakan</td>
                            <td width="10%">Ya</td>
                            <td width="10%">Tidak</td>
                            <td width="20%">TTD/ Nama Petugas</td>
                        </tr>
                        <?php for($i=1; $i<=3; $i++): 
                            $label = ($i==1) ? "Tidak Berisiko" : (($i==2) ? "Berisiko Sedang" : "Berisiko Tinggi");
                            $action = ($i==1) ? "Tidak ada tindakan" : (($i==2) ? "Edukasi" : "Pasang stiker kuning dan edukasi");
                        ?>
                        <tr>
                            <td class="text-center"><?= $i ?>.</td>
                            <td><?= $label ?></td>
                            <td><?= $action ?></td>
                            <td class="text-center">
                                <label><input type="radio" name="act_<?= $i ?>" value="ya" class="cb-custom-input"><span class="cb-box"></span></label>
                            </td>
                            <td class="text-center">
                                <label><input type="radio" name="act_<?= $i ?>" value="tidak" class="cb-custom-input"><span class="cb-box"></span></label>
                            </td>
                            <td class="text-center">
                                <div class="ttd-preview-wrap">
                                    <img id="pv_act_<?= $i ?>" src="" style="max-height: 50px; display: none;">
                                </div>
                                <input type="file" name="ttd_act_<?= $i ?>" accept="image/*" onchange="showPreview(this, 'pv_act_<?= $i ?>')" style="font-size: 8px; width: 100%; margin-bottom: 5px;">
                                <input type="text" name="act_<?= $i ?>_ttd" class="input-ttd" placeholder="Nama Petugas">
                            </td>
                        </tr>
                        <?php endfor; ?>
                    </table>
                </div>

                <div class="mt-3 text-right pb-5">
                    <a href="<?= base_url('tmstformulir') ?>" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary" id="btn_save">
                        <i class="fas fa-save mr-1"></i> Simpan Risiko Jatuh
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
    function showPreview(input, imgId) {
        const preview = document.getElementById(imgId);
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = "";
            preview.style.display = 'none';
        }
    }

    $('#form_rawatJalan').on('submit', function(e) {
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
                btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Simpan Risiko Jatuh');
                toastr.error('Error saat menyimpan data!'); 
            }
        });
    });
</script>
<?= $this->endSection(); ?>