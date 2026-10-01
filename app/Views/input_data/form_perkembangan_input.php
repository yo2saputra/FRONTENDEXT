<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>
<style>
    .form-container-paper, .form-container-paper td, .form-container-paper th, .input-invisible {
        font-family: Arial, sans-serif;
        font-size: 10px !important;
        color: #000;
    }

    .form-container-paper {
        background: white;
        padding: 40px; 
        border: 1px solid #000;
        margin: 0 auto;
    }

    .header-table, .table-cppt { width: 100%; border-collapse: collapse; border: 1px solid black; }
    .header-td { padding: 8px; vertical-align: middle; }
    .bold { font-weight: bold; }
    .text-center { text-align: center; }

    .table-cppt tbody td {
        border-left: 1px solid black; 
        border-right: 1px solid black;
        border-top: none; 
        border-bottom: none; 
        padding: 10px 5px; 
        vertical-align: top;
    }

    .table-cppt thead th { 
        border: 1px solid black; 
        padding: 8px; 
        background-color: #d0d0d0 !important; 
    }

    .judul-box {
        border: 1px solid black;
        border-bottom: none; 
        background-color: #d0d0d0 !important;
        text-align: center;
        font-weight: bold;
        padding: 8px;
    }

    .gender-option {
        cursor: pointer;
        padding: 2px 5px;
        border: 1px solid transparent;
        transition: 0.2s;
    }
    .gender-radio:checked + .gender-option {
        border: 1px solid black;
        border-radius: 50%;
        font-weight: bold;
    }
    .gender-radio { display: none; }

    .input-invisible { width: 100%; border: none; outline: none; background: transparent; }
    .input-invisible:focus { background: #f8f9fa; }

    textarea.full-cell {
        width: 100%;
        border: none;
        resize: none;
        outline: none;
        background: transparent;
        min-height: 100px;
        line-height: 1.5;
    }
</style>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid pt-3">
            <form id="form_cppt" action="<?= base_url('tmstformulir/save/cppt') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                
                <div class="form-container-paper">
                    <table class="header-table">
                        <tr>
                            <td width="50%" class="header-td" style="border-right: 1px solid black;">
                                <table width="100%">
                                    <tr>
                                        <td width="20%"><img src="<?= base_url('assets/img/Logo_MedicElle.png') ?>" style="height: 45px;"></td>
                                        <td><div style="font-size: 8px;">Jl. Raya Gubeng No. 11, Surabaya - 60281</div></td>
                                    </tr>
                                </table>
                            </td>
                            <td width="50%" class="header-td">
                                <div class="bold text-right" style="font-size: 10px; margin-bottom: 5px;">CATATAN PERKEMBANGAN PASIEN TERINTEGRASI</div>
                                <table width="100%" style="font-size: 9px;">
                                    <tr>
                                        <td width="25%">NO RM</td>
                                        <td width="2%">:</td>
                                        <td class="bold"><input type="text" name="rm" class="input-invisible bold" value="" placeholder=""></td>
                                        <td align="right" class="bold">
                                            (<label><input type="radio" name="jk" value="L" class="gender-radio"><span class="gender-option">L</span></label> / 
                                             <label><input type="radio" name="jk" value="P" class="gender-radio" checked><span class="gender-option">P</span></label>)
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nama Pasien</td><td>:</td>
                                        <td colspan="2"><input type="text" name="nama" class="input-invisible bold" value="" placeholder=""></td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Lahir</td><td>:</td>
                                        <td colspan="2"><input type="text" name="tgl_lahir" class="input-invisible bold" value="" placeholder="dd/mm/yyyy"></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                    <div class="judul-box">CATATAN PERKEMBANGAN TERINTEGRASI</div>

                    <table class="table-cppt">
                        <thead>
                            <tr>
                                <td colspan="5" style="font-size: 8px; padding: 5px; border: 1px solid black; background: #fff;">
                                    (Ditulis dengan format SOAP, disertai dengan target dan tujuan terukur, dituliskan nama dan paraf pada setiap akhir catatan, DPJP harus membaca dan memverifikasi ulang seluruh rencana perawatan)
                                </td>
                            </tr>
                            <tr class="text-center">
                                <th width="12%">Tanggal/<br>Jam</th>
                                <th width="15%">Profesional<br>Pemberi<br>Asuhan</th>
                                <th width="35%">Hasil Asesmen Pasien dan<br>Pemberian Pelayanan</th>
                                <th width="25%">INSTRUKSI PPA</th>
                                <th width="13%">Verifikasi DPJP</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for($i=0; $i<5; $i++): ?>
                            <tr>
                                <td class="text-center"><input type="text" name="rows[<?= $i ?>][tgl_jam]" class="input-invisible text-center" placeholder="Tgl/Jam"></td>
                                <td class="text-center"><input type="text" name="rows[<?= $i ?>][ppa]" class="input-invisible text-center" placeholder="PPA"></td>
                                <td>
                                    <textarea name="rows[<?= $i ?>][soap]" class="full-cell" onfocus="addSoapTemplate(this)">S : &#10;O : &#10;A : &#10;P : </textarea>
                                </td>
                                <td><textarea name="rows[<?= $i ?>][instruksi]" class="full-cell" placeholder="Instruksi..."></textarea></td>
                                <td class="text-center">
                                    <input type="file" name="ttd_file[]" style="font-size: 8px; width: 100%; margin-bottom: 5px;">
                                    <input type="text" name="rows[<?= $i ?>][verif]" class="input-invisible text-center" placeholder="(Nama)">
                                </td>
                            </tr>
                            <?php endfor; ?>
                            <tr>
                                <td style="border-bottom: 1px solid black; height: 1px;"></td>
                                <td style="border-bottom: 1px solid black;"></td>
                                <td style="border-bottom: 1px solid black;"></td>
                                <td style="border-bottom: 1px solid black;"></td>
                                <td style="border-bottom: 1px solid black;"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 text-right pb-5">
                    <a href="<?= base_url('tmstformulir') ?>" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary" id="btn_save">
                        <i class="fas fa-save mr-1"></i> Simpan Formulir CPPT
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    function addSoapTemplate(el) {
        if (el.value.trim() === "") {
            el.value = "S : \nO : \nA : \nP : ";
        }
    }

    $('#form_cppt').on('submit', function(e) {
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
                btn.prop('disabled', false).html('Simpan Formulir CPPT');
                toastr.error('Error simpan data ces!'); 
            }
        });
    });
</script>
<?= $this->endSection(); ?>