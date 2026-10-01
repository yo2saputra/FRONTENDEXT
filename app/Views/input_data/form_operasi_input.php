<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>
<link rel="stylesheet" href="<?= base_url('plugins/toastr/toastr.min.css') ?>">
<style>
    .form-container-paper {
        background: white;
        padding: 30px;
        border: 1px solid #000;
        margin: 0 auto;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 10px !important;
        color: #000;
        max-width: 950px;
    }

    table { width: 100%; border-collapse: collapse; border-spacing: 0; }
    td, th { vertical-align: top; padding: 3px 5px; border: 1px solid black; }
    
    .no-border-table td { border: none !important; padding: 2px 0; }
    .bold { font-weight: bold; }
    .text-center { text-align: center; }
    .bg-gray { 
        background-color: #ffff !important; 
        color: #000000 !important;           /* Memastikan teks hitam pekat */
        font-weight: 900 !important;          /* Menambah ketebalan font */
        text-transform: uppercase;
    }
    
    /* Input Styling agar mirip PDF */
    .input-invisible {
        border: none;
        border-bottom: 1px dotted black;
        outline: none;
        background: transparent;
        font-family: 'Courier New', Courier, monospace;
        font-weight: bold;
        font-size: 11px;
        width: 100%;
        padding: 0;
    }

    .dots-time { width: 45px; text-align: center; border-bottom: 1px dotted black; }
    .input-mini { width: 40px; text-align: center; }

    /* Custom Checkbox Appearance */
    .cb-label { display: block; margin-bottom: 2px; cursor: pointer; font-weight: normal; }
    .cb-label input { margin-right: 5px; transform: scale(1.1); vertical-align: middle; }

    .sub-item { padding-left: 15px; display: block; }

    
</style>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid pt-3">
            <form id="form_operasi" action="<?= base_url('tmstformulir/save/operasi') ?>" method="post">
                <?= csrf_field(); ?>

                <div class="form-container-paper">
                    <table style="border-bottom: 2px solid black;">
                        <tr>
                            <td width="35%" style="border: none; padding: 5px;">
                                <img src="<?= base_url('assets/img/Logo_MedicElle.png') ?>" style="height: 50px; width: auto;">
                                <div style="font-size: 7px; margin-top: 3px;">Jl. Raya Gubeng No. 11, Surabaya - 60281</div>
                            </td>
                            <td width="65%" class="text-center" style="vertical-align: middle; border: none;">
                                <div class="bold" style="font-size: 15px; letter-spacing: 1px;">SURGICAL SAFETY CHECKLIST</div>
                            </td>
                        </tr>
                    </table>

                    <table style="border-top: none;">
                        <tr>
                            <td width="12%" style="border-top: none;">Nama</td><td width="1%" style="border-top: none;">:</td>
                            <td width="37%" style="border-top: none;"><input type="text" name="nama" class="input-invisible"></td>
                            <td width="15%" style="border-top: none;">Diagnosa</td><td width="1%" style="border-top: none;">:</td>
                            <td width="34%" style="border-top: none;"><input type="text" name="diagnosis" class="input-invisible"></td>
                        </tr>
                        <tr>
                            <td>No.RM</td><td>:</td><td><input type="text" name="rm" class="input-invisible"></td>
                            <td>Jenis Anestesi</td><td>:</td><td><input type="text" name="jns_anestesi" class="input-invisible"></td>
                        </tr>
                        <tr>
                            <td>Tanggal Lahir</td><td>:</td><td><input type="text" name="tgl_lahir" class="input-invisible" placeholder="dd/mm/yyyy"></td>
                            <td>Obat Anestesi Yang Diberikan</td><td>:</td><td><input type="text" name="obat_anestesi" class="input-invisible"></td>
                        </tr>
                        <tr>
                            <td>Tanggal Tindakan</td><td>:</td><td><input type="text" name="tgl_tindakan" class="input-invisible" placeholder="dd/mm/yyyy"></td>
                            <td>Dokter Operator</td><td>:</td><td><input type="text" name="dokter" class="input-invisible"></td>
                        </tr>
                        <tr>
                            <td>Jenis Tindakan</td><td>:</td><td colspan="4"><input type="text" name="jenis_tindakan" class="input-invisible"></td>
                        </tr>
                    </table>

                    <table style="border-top: none;">
                        <tr class="bg-gray">
                            <td width="33.3%" class="text-center bold">
                                SIGN IN (Jam : <input type="text" name="signin_jam" class="dots-time" placeholder="00:00"> wib)<br>
                                <span style="font-size: 8px; font-weight: normal;">(Sebelum Induksi)</span>
                            </td>
                            <td width="33.4%" class="text-center bold">
                                TIME OUT (Jam : <input type="text" name="timeout_jam" class="dots-time" placeholder="00:00"> wib)<br>
                                <span style="font-size: 8px; font-weight: normal;">(Sebelum Insisi)</span>
                            </td>
                            <td width="33.3%" class="text-center bold">
                                SIGN OUT (Jam : <input type="text" name="signout_jam" class="dots-time" placeholder="00:00"> wib)<br>
                                <span style="font-size: 8px; font-weight: normal;">(Sebelum Keluar Kamar Operasi)</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="bold">Verifikasi</div>
                                <label class="cb-label"><input type="checkbox" name="signin_identitas" value="v"> Identitas pasien</label>
                                <label class="cb-label"><input type="checkbox" name="signin_consent" value="v"> Informed consent</label>
                                
                                <div class="bold mt-2">Pemberian tanda di lokasi operasi</div>
                                <label class="cb-label"><input type="radio" name="signin_lokasi" value="Ya"> Ya</label>
                                <label class="cb-label"><input type="radio" name="signin_lokasi" value="Tidak"> Tidak</label>

                                <div class="bold mt-2">Diagnosa pasien</div>
                                <input type="text" name="signin_diagnosa" class="input-invisible">

                                <div class="bold mt-2">Pemeriksaan TTV</div>
                                <table class="no-border-table">
                                    <tr><td>TD: <input type="text" name="signin_td" class="input-invisible input-mini"></td><td>N: <input type="text" name="signin_n" class="input-invisible input-mini"></td></tr>
                                    <tr><td>S: <input type="text" name="signin_s" class="input-invisible input-mini"></td><td>RR: <input type="text" name="signin_rr" class="input-invisible input-mini"></td></tr>
                                </table>

                                <div class="bold mt-2">Riwayat Alergi</div>
                                <label class="cb-label"><input type="radio" name="signin_alergi_status" value="Ada"> Ada, sebutkan: <input type="text" name="signin_alergi_txt" class="input-invisible" style="width:60px"></label>
                                <label class="cb-label"><input type="radio" name="signin_alergi_status" value="Tidak"> Tidak ada</label>

                                <div class="bold mt-2">Risiko Aspirasi & Gangguan Nafas</div>
                                <label class="cb-label"><input type="radio" name="signin_aspirasi" value="Ya"> Ya</label>
                                <label class="cb-label"><input type="radio" name="signin_aspirasi" value="Tidak"> Tidak</label>

                                <div class="bold mt-2">Risiko Perdarahan</div>
                                <label class="cb-label"><input type="radio" name="signin_darah" value="Ya"> Ya</label>
                                <label class="cb-label"><input type="radio" name="signin_darah" value="Tidak"> Tidak</label>
                            </td>

                            <td>
                                <div class="bold">Kelengkapan Tim dan Fasilitas Operasi</div>
                                <label class="cb-label"><input type="checkbox" name="timeout_tim" value="v"> Lengkap</label>
                                <label class="cb-label"><input type="checkbox" name="timeout_tim_no" value="v"> Tidak lengkap, Karena <br> <input type="text" name="timeout_tim_alasan" class="input-invisible" style="width:60px"></label>

                                <div class="bold mt-2">Pemeriksaan Kelengkapan Alat Operasi</div>
                                <label class="cb-label"><input type="checkbox" name="timeout_inst" value="v"> Instrument</label>
                                <label class="cb-label"><input type="checkbox" name="timeout_kassa" value="v"> Kassa</label>
                                <label class="cb-label"><input type="checkbox" name="timeout_jarum" value="v"> Jarum</label>

                                <div class="bold mt-2">Baca Secara Verbal</div>
                                <label class="cb-label"><input type="checkbox" name="verb_tgl" value="v"> Tanggal Tindakan</label>
                                <label class="cb-label"><input type="checkbox" name="verb_nama" value="v"> Nama Tindakan</label>
                                <label class="cb-label"><input type="checkbox" name="verb_lokasi" value="v"> Lokasi Tindakan</label>
                                <label class="cb-label"><input type="checkbox" name="verb_identitas" value="v"> Identitas Pasien</label>
                                <label class="cb-label"><input type="checkbox" name="verb_prosedur" value="v"> Prosedur Tindakan</label>
                                <label class="cb-label"><input type="checkbox" name="verb_consent" value="v"> Informed Consent</label>

                                <div class="bold mt-2">Antibiotik Profilaksis</div>
                                <div style="font-size: 10px;">apakah diberikan dalam waktu kurang dari 60 menit</div>
                                <label class="cb-label"><input type="radio" name="timeout_ab" value="Tidak"> Tidak</label>
                                <label class="cb-label"><input type="radio" name="timeout_ab" value="Ya"> Iya, Nama obat: <br> <input type="text" name="timeout_ab_nama" class="input-invisible" style="width:80px"></label>
                                <div class="sub-item">Dosis Obat : <input type="text" name="timeout_ab_dosis" class="input-invisible" style="width:80px"></div>
                                <div class="sub-item">Jam diberikan : <input type="text" name="timeout_ab_jam" class="input-invisible" style="width:80px"></div>
                            </td>

                            <td>
                                <div class="bold">Kelengkapan sebelum luka operasi ditutup</div>
                                <label class="cb-label"><input type="checkbox" name="signout_inst" value="v"> Instrument</label>
                                <label class="cb-label"><input type="checkbox" name="signout_kassa" value="v"> Kassa</label>
                                <label class="cb-label"><input type="checkbox" name="signout_jarum" value="v"> Jarum</label>

                                <div class="bold mt-2">Kelengkapan bahan pemeriksaan</div>
                                <div class="bold">&bull; Preparat</div>
                                <label class="cb-label"><input type="radio" name="signout_spesimen" value="Ya"> Ya</label>
                                <label class="cb-label"><input type="radio" name="signout_spesimen" value="Tidak"> Tidak</label>
                                <div class="bold">&bull; Jenis</div>
                                <div class="row no-gutters">
                                    <div class="col-6"><label class="cb-label"><input type="checkbox" name="signout_pa" value="v"> PA</label></div>
                                    <div class="col-6"><label class="cb-label"><input type="checkbox" name="signout_lain" value="v"> Lainnya: <input type="text" name="signout_lain_txt" class="input-invisible" style="width:40px"></label></div>
                                    <div class="col-6"><label class="cb-label"><input type="checkbox" name="signout_kultur" value="v"> Kultur</label></div>
                                    <div class="col-6"><label class="cb-label"><input type="checkbox" name="signout_no_preparat" value="v"> Tidak ada</label></div>
                                    <div class="col-12"><label class="cb-label"><input type="checkbox" name="signout_sitologi" value="v"> Sitologi</label></div>
                                </div>

                                <div class="bold mt-2">Pemeriksaan TTV :</div>
                                <table class="no-border-table">
                                    <tr><td>TD: <input type="text" name="signout_td" class="input-invisible input-mini"></td><td>N: <input type="text" name="signout_n" class="input-invisible input-mini"></td></tr>
                                    <tr><td>S: <input type="text" name="signout_s" class="input-invisible input-mini"></td><td>RR: <input type="text" name="signout_rr" class="input-invisible input-mini"></td></tr>
                                    <tr><td>GCS: <input type="text" name="signout_gcs" class="input-invisible input-mini"></td><td>Skala Nyeri: <input type="text" name="signout_nyeri" class="input-invisible input-mini"></td></tr>
                                </table>

                                <div class="bold mt-2">Pemeriksaan Kembali Luka Operasi</div>
                                <label class="cb-label"><input type="radio" name="signout_rembes" value="Ada"> Ada Rembesan</label>
                                <label class="cb-label"><input type="radio" name="signout_rembes" value="Tidak"> Tidak ada rembesan</label>

                                <div class="bold mt-2">Instruksi Khusus :</div>
                                <textarea name="signout_instruksi" class="input-invisible" rows="2"></textarea>
                            </td>
                        </tr>
                    </table>

                    <table>
                        <tr class="text-center">
                            <td width="33.3%" style="padding: 15px 5px;">
                                <div class="bold">TTD dan Nama Petugas</div>
                                <div style="height: 40px;"></div>
                                ( <input type="text" name="ttd_signin" class="input-invisible text-center" style="width: 80%"> )
                            </td>
                            <td width="33.4%" style="padding: 15px 5px;">
                                <div class="bold">TTD dan Nama Petugas</div>
                                <div style="height: 40px;"></div>
                                ( <input type="text" name="ttd_timeout" class="input-invisible text-center" style="width: 80%"> )
                            </td>
                            <td width="33.3%" style="padding: 15px 5px;">
                                <div class="bold">TTD dan Nama Petugas</div>
                                <div style="height: 40px;"></div>
                                ( <input type="text" name="ttd_signout" class="input-invisible text-center" style="width: 80%"> )
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="mt-3 text-right pb-5">
                    <a href="<?= base_url('tmstformulir') ?>" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary" id="btn_save">
                        <i class="fas fa-save mr-1"></i> Simpan Data Operasi
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
    $('#form_operasi').on('submit', function(e) {
        e.preventDefault();
        let btn = $('#btn_save');
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
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
                btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Simpan Data Operasi');
                toastr.error('Sistem error!'); 
            }
        });
    });
</script>
<?= $this->endSection(); ?>