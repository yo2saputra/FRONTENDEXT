<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.css">
<style>
    .btn-fix-w {
        width: 60px;
        padding-top: 0px;
        padding-bottom: 0px;
    }

    .control-sidebar {
        color: black;
    }

    .list-group {
        max-height: 80vh;
        margin-bottom: 10px;
        overflow-y: scroll;
        -webkit-overflow-scrolling: touch;
    }

    .content-header-fixed {
        -webkit-transition: -webkit-transform .3s ease-in-out, margin .3s ease-in-out;
        transition: transform .3s ease-in-out, margin .3s ease-in-out;
        position: fixed;
        color: #fff;
        margin-left: 245px;
        left: 0;
        right: 0;
        padding: 5px;
        z-index: 800;
    }

    @media (min-width:768px) {
        .contents {
            margin-top: 1.5rem;
        }

        .sidebar-collapse .content-header-fixed {
            margin-left: 0px;
        }

        .sidebar-mini.sidebar-collapse .content-header-fixed {
            margin-left: 70px !important;
            z-index: 840;
        }

        #melayang {
            padding-top: 180px;
        }
    }

    @media (max-width:767px) {
        .contents {
            margin-top: 5.5rem;
        }

        .sidebar-collapse .content-header-fixed {
            margin-left: 0px;
        }

        .sidebar-mini.sidebar-collapse .content-header-fixed {
            margin-left: 0px !important;
            z-index: 840;
        }

        .content-header-fixed {
            position: relative !important;
            margin-left: 0 !important;
        }

        #melayang {
            padding-top: 0 !important;
            display: block !important;
        }
    }

    .caption_text {
        font-size: 0.6rem;
    }

    .content_text {
        font-size: 0.8rem;
    }

    .field-error-msg {
        display: none;
        color: #e8833a;
        font-size: 0.78rem;
        margin-top: 3px;
    }

    .field-error-msg.show {
        display: block;
    }

    #viewdatacppt {
        background-color: #fff !important;
    }

    #viewdatacppt table {
        background-color: #fff !important;
        color: #333 !important;
    }

    #viewdatacppt table thead tr th {
        background-color: #ffffff !important;
        color: #333 !important;
    }

    #viewdatacppt table tbody tr td {
        background-color: #fff !important;
        color: #333 !important;
    }

    #viewdatacppt table tbody tr:nth-child(even) td {
        background-color: #fafafa !important;
    }

    .note-editor.note-frame {
        z-index: auto;
    }

    .note-popover {
        z-index: 1060;
    }

    .modal .note-popover {
        z-index: 1200;
    }

    .section-divider {
        font-weight: bold;
        font-size: 0.8rem;
        background: #e9ecef;
        padding: 4px 8px;
        border-radius: 4px;
        margin-bottom: 10px;
        margin-top: 6px;
    }
</style>
<?= $this->endSection('style'); ?>

<?= $this->section('controlsidebaricon'); ?>
<li class="nav-item">
    <a class="nav-link text-md" data-widget="control-sidebar" data-slide="true" href="#" role="button" id="toggle-sidebar-pasien">
        <i class="fas fa-wheelchair"></i>
    </a>
</li>
<?= $this->endSection('controlsidebaricon'); ?>

<?= $this->section('content'); ?>

<?php
$session = session();
?>

<div class="content-wrapper">

    <input type="hidden" id="f_no_registrasi" value="">
    <input type="hidden" id="f_medrec_id" value="">

    <!-- HEADER IDENTITAS -->
    <section class="content-header-fixed" id="header-identitas-pasien" style="display:none;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card bg-info" style="padding:2px;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-6">
                                    <dl>
                                        <dt class="caption_text">Nomor Registrasi</dt><span id="no_registrasi_display" class="content_text">&nbsp;</span>
                                    </dl>
                                </div>
                                <div class="col-md-3 col-6">
                                    <dl>
                                        <dt class="caption_text">No. Rekam Medis</dt><span id="medrec_id_info" class="content_text">&nbsp;</span>
                                    </dl>
                                </div>
                                <div class="col-md-3 col-6">
                                    <dl>
                                        <dt class="caption_text">Nama Pasien</dt><span id="fullname_tm" class="content_text">&nbsp;</span>
                                    </dl>
                                </div>
                                <div class="col-md-3 col-6">
                                    <dl>
                                        <dt class="caption_text">Jenis Kelamin - Tanggal Lahir - Usia</dt><span class="content_text"><span id="gender_tm">&nbsp;</span> - <span id="birth_dt_tm">&nbsp;</span> - <span id="tahun">&nbsp;</span> Th,<span id="bulan">&nbsp;</span> Bln.</span>
                                    </dl>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-6">
                                    <dl>
                                        <dt class="caption_text">Poliklinik</dt><span id="tujuan_registrasi_desc" class="content_text">&nbsp;</span>
                                    </dl>
                                </div>
                                <div class="col-md-3 col-6">
                                    <dl>
                                        <dt class="caption_text">Dokter</dt><span id="nama_dokter" class="content_text">&nbsp;</span>
                                    </dl>
                                </div>
                                <div class="col-md-3 col-6">
                                    <dl>
                                        <dt class="caption_text">Jaminan</dt><span id="type_pasien" class="content_text">&nbsp;</span>
                                    </dl>
                                </div>
                                <div class="col-md-3 col-6">
                                    <dl>
                                        <dt class="caption_text">Riwayat Alergi</dt><span id="birth_dt_tmx" class="content_text">&nbsp;</span>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- KONTEN UTAMA -->
    <section class="content" id="melayang" style="display:none;">
        <div class="container-fluid">
            <div class="row contents">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <!-- TOOLBAR -->
                            <div class="row mb-3">
                                <div class="col-sm-12 d-flex flex-wrap align-items-center" style="gap:6px;">
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-input-section" id="btn_add_umum" disabled data-toggle="modal" data-target="#modalAddUmum">
                                        <i class="fas fa-file-medical mr-1"></i> Data Umum
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-input-section" id="btn_add_soap" disabled data-toggle="modal" data-target="#modalAddSoap">
                                        <i class="fas fa-notes-medical mr-1"></i> SOAP
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-input-section" id="btn_add_instruksi" disabled data-toggle="modal" data-target="#modalAddInstruksi">
                                        <i class="fas fa-tasks mr-1"></i> Instruksi PPA
                                    </button>
                                    <div class="ml-auto d-flex" style="gap:6px;">
                                        <button type="button" id="btn_refresh" class="btn btn-sm btn-secondary"><i class="fas fa-sync-alt"></i> Refresh</button>
                                        <button type="button" id="btn_cetak" class="btn btn-sm btn-danger"><i class="fas fa-print"></i> Cetak PDF</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive" id="viewdatacppt">
                                <p class="text-muted text-center">Pilih pasien untuk melihat catatan CPPT.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== MODAL ADD: Data Umum ===== -->
    <div class="modal fade" id="modalAddUmum" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-file-medical mr-2"></i> Data Umum</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form class="form-add-section" data-section="umum" autocomplete="off">
                    <input type="hidden" name="no_registrasi" class="sync-no-reg">
                    <input type="hidden" name="action" value="Add">
                    <input type="hidden" name="section" value="umum">
                    <div class="modal-body">
                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label col-form-label-sm">Tanggal &amp; Jam</label>
                            <div class="col-sm-8">
                                <input type="datetime-local" class="form-control form-control-sm" name="cppt_tgl" id="add_umum_tgl">
                                <span class="field-error-msg" id="add_umum_err_tgl">Tanggal &amp; Jam wajib diisi.</span>

                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label col-form-label-sm">Profesional Pemberi Asuhan</label>
                            <div class="col-sm-8">
                                <?= view('components/dropdown2', [
                                    'id'          => 'add_umum_ppa',
                                    'name'        => 'cppt_profesional_pemberiasuhan',
                                    'apiUrl'      => base_url('/dropdown/server5/1/1/tfield-value/null/fieldName/profesional_pemberi_asuhan/null/null'),
                                    'placeholder' => 'Pilih Profesional Pemberi Asuhan',
                                    'extraKeys'   => [],
                                    'selected'    => '',
                                    'errors'      => $errors ?? []
                                ]) ?>
                                <span class="field-error-msg" id="add_umum_err_ppa">Bidang ini wajib diisi.</span>
                            </div>
                            <input type="hidden" id="add_soap_text" name="cppt_hasil_assesment_pasien" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-submit-section"><i class="fas fa-save mr-1"></i> Simpan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ===== MODAL ADD: SOAP ===== -->
    <div class="modal fade" id="modalAddSoap" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-notes-medical mr-2"></i> Hasil Asesmen Pasien (SOAP)</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form class="form-add-section" data-section="soap" autocomplete="off">
                    <input type="hidden" name="no_registrasi" class="sync-no-reg">
                    <input type="hidden" name="action" value="Add">
                    <input type="hidden" name="section" value="soap">
                    <input type="hidden" name="cppt_tgl" class="sync-cppt-tgl">
                    <input type="hidden" name="cppt_profesional_pemberiasuhan" class="sync-cppt-ppa">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-form-label col-form-label-sm">Hasil Asesmen Pasien dan Pemberian Pelayanan <small class="text-muted">(SOAP)</small></label>
                            <textarea id="add_soap_textarea" name="cppt_hasil_assesment_pasien"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-submit-section"><i class="fas fa-save mr-1"></i> Simpan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ===== MODAL ADD: Instruksi PPA ===== -->
    <div class="modal fade" id="modalAddInstruksi" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-tasks mr-2"></i> Instruksi PPA</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form class="form-add-section" data-section="instruksi" autocomplete="off">
                    <input type="hidden" name="no_registrasi" class="sync-no-reg">
                    <input type="hidden" name="action" value="Add">
                    <input type="hidden" name="section" value="instruksi">
                    <input type="hidden" name="cppt_tgl" class="sync-cppt-tgl">
                    <input type="hidden" name="cppt_profesional_pemberiasuhan" class="sync-cppt-ppa">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-form-label col-form-label-sm">Instruksi PPA <small class="text-muted">(termasuk pasca bedah/tindakan invasif)</small></label>
                            <textarea id="add_instruksi_textarea" name="cppt_instruksi_ppa"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-submit-section"><i class="fas fa-save mr-1"></i> Simpan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ===== MODAL EDIT CPPT ===== -->
    <div class="modal fade" id="modalEditCppt" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-edit mr-2"></i> Ubah Data CPPT</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form id="edit_form" autocomplete="off">
                    <input type="hidden" id="edit_hidden_cppt_cd" name="hidden_cppt_cd" value="">
                    <input type="hidden" id="edit_no_registrasi" name="no_registrasi" value="">
                    <input type="hidden" name="action" value="Edit">
                    <input type="hidden" name="section" value="umum">
                    <input type="hidden" id="edit_verifikasi_dpjp" name="cppt_verifikasi_dpjp" value="">
                    <div class="modal-body">

                        <div class="mb-3">
                            <span class="badge badge-primary px-3 py-2" style="font-size:0.9rem;" id="edit-section-label"></span>
                        </div>

                        <!-- Section: Data Umum -->
                        <div id="edit-section-umum" style="display:none;">
                            <div class="mb-3 row">
                                <label class="col-sm-4 col-form-label col-form-label-sm">Tanggal &amp; Jam</label>
                                <div class="col-sm-8">
                                    <input type="datetime-local" class="form-control form-control-sm" id="edit_cppt_tgl" name="cppt_tgl">
                                    <span class="field-error-msg" id="edit_err_tgl">Tanggal &amp; Jam wajib diisi.</span>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-4 col-form-label col-form-label-sm">Profesional Pemberi Asuhan</label>
                                <div class="col-sm-8">
                                    <?= view('components/dropdown2', [
                                        'id'          => 'edit_cppt_ppa',
                                        'name'        => 'cppt_profesional_pemberiasuhan',
                                        'apiUrl'      => base_url('/dropdown/server5/1/1/tfield-value/null/fieldName/profesional_pemberi_asuhan/null/null'),
                                        'placeholder' => 'Pilih Profesional Pemberi Asuhan',
                                        'extraKeys'   => [],
                                        'selected'    => '',
                                        'errors'      => $errors ?? []
                                    ]) ?>
                                    <span class="field-error-msg" id="edit_err_ppa">Bidang ini wajib diisi.</span>
                                </div>
                            </div>
                        </div>

                        <!-- Section: SOAP -->
                        <div id="edit-section-soap" style="display:none;">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm">Hasil Asesmen Pasien dan Pemberian Pelayanan <small class="text-muted">(SOAP)</small></label>
                                <textarea id="edit_cppt_soap" name="cppt_hasil_assesment_pasien"></textarea>
                            </div>
                        </div>

                        <!-- Section: Instruksi PPA -->
                        <div id="edit-section-instruksi" style="display:none;">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm">Instruksi PPA <small class="text-muted">(termasuk pasca bedah/tindakan invasif)</small></label>
                                <textarea id="edit_cppt_instruksi" name="cppt_instruksi_ppa"></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="edit_submit_button" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan Perubahan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<?= $this->endSection('content'); ?>

<?= $this->section('control-sidebar'); ?>
<aside class="control-sidebar control-sidebar-dark" style="height:100vh;">
    <div class="p-1 control-sidebar-content" style="height:602px; overflow-y:auto;">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="card-title">Daftar Pasien</h3>
            </div>
            <div class="card-body p-0"><span id="viewdata"></span></div>
        </div>
    </div>
</aside>
<?= $this->endSection('control-sidebar'); ?>

<?= $this->section('script'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.js"></script>
<script>
    $(document).prop("title", $('p#active-menu').html());


    const dataO = {
        keluhanUtama: "",
        riwayatKesehatanPasien: "",
        tekananDarah: "",
        sh: "",
        nd: "",
        lajuNafas: ""
    };

    // const soapTemplate = `
    //         <p><b>S :</b>&nbsp;${dataO.keluhanUtama}, ${dataO.riwayatKesehatanPasien}</p>
    //         <p><b>O :</b></p>
    //         <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; T = ${dataO.tekananDarah} &nbsp;&nbsp;&nbsp;&nbsp; sh = ${dataO.sh}</p>
    //         <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; nd = ${dataO.nd} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; RR = ${dataO.lajuNafas}%</p>
    //         <p><b>A :</b></p>
    //         <p><b>P :</b></p>
    //         `;

    var soapTemplate =
        '<p><b>S :</b>&nbsp;</p>' +
        '<p><b>O :</b>&nbsp;</p>' +
        '<p><b>A :</b>&nbsp;</p>' +
        '<p><b>P :</b>&nbsp;</p>';

    var instruksiTemplate =
        '<p>- &nbsp;</p>' +
        '<p>- &nbsp;</p>' +
        '<p>- &nbsp;</p>';

    var summernoteConfig = {
        height: 200,
        toolbar: [
            ['style', ['bold', 'italic', 'underline']],
            ['para', ['ul', 'ol']],
            ['paragraph', ['paragraph']],
            ['view', ['fullscreen']],
        ]
    };

    var sectionMap = {
        'umum': {
            div: 'edit-section-umum',
            label: 'Data Umum'
        },
        'soap': {
            div: 'edit-section-soap',
            label: 'Hasil Asesmen (SOAP)'
        },
        'instruksi': {
            div: 'edit-section-instruksi',
            label: 'Instruksi PPA'
        }
    };

    function showEditSection(key) {
        $.each(sectionMap, function(k, v) {
            $('#' + v.div).hide();
        });
        $('#edit_form input[name="section"]').val(key);
        if (sectionMap[key]) {
            $('#' + sectionMap[key].div).show();
            $('#edit-section-label').text(sectionMap[key].label);
        }
    }

    function getNowDatetimeLocal() {
        var now = new Date();
        return now.getFullYear() + '-' +
            String(now.getMonth() + 1).padStart(2, '0') + '-' +
            String(now.getDate()).padStart(2, '0') + 'T' +
            String(now.getHours()).padStart(2, '0') + ':' +
            String(now.getMinutes()).padStart(2, '0');
    }

    function tregistrasi() {
        $.ajax({
            method: "GET",
            url: "<?= site_url('cppt/fetchAll'); ?>",
            success: function(data) {
                $('#viewdata').html(data);
            },
            error: function(xhr) {
                console.error('fetchAll error:', xhr.responseText);
            }
        });
    }

    function fetchCpptData() {
        var no_reg = $('#f_no_registrasi').val();
        if (!no_reg) return;
        $('#viewdatacppt').html('<p class="text-center text-muted py-3"><i class="fas fa-spinner fa-spin"></i> Memuat data...</p>');
        $.ajax({
            url: "<?= site_url('cppt/fetchCpptByRegistrasi'); ?>",
            method: "GET",
            cache: false,
            data: {
                no_registrasi: no_reg
            },
            success: function(data) {
                $('#viewdatacppt').html(data);
                $('.btn-input-section').prop('disabled', false);
            },
            error: function() {
                $('#viewdatacppt').html('<p class="text-center text-danger py-3">Gagal memuat data. Coba refresh.</p>');
            }
        });
    }

    $(document).ready(function() {
        $('.btn-input-section').prop('disabled', true);
        tregistrasi();
        if (!$('body').hasClass('control-sidebar-slide-open')) {
            $('#toggle-sidebar-pasien').trigger('click');
        }

        $('#add_soap_textarea').summernote($.extend({}, summernoteConfig));
        $('#add_soap_textarea').summernote('code', soapTemplate);

        //baru
        $('#add_soap_text').val(soapTemplate);

        $('#add_instruksi_textarea').summernote($.extend({}, summernoteConfig));
        $('#add_instruksi_textarea').summernote('code', instruksiTemplate);

        $('#edit_cppt_soap').summernote($.extend({}, summernoteConfig));
        $('#edit_cppt_instruksi').summernote($.extend({}, summernoteConfig));
    });

    $('#modalAddUmum').on('show.bs.modal', function() {
        $('#add_umum_tgl').val(getNowDatetimeLocal());
        if (window.dropdown_add_umum_ppa) {
            window.dropdown_add_umum_ppa.setValue('');
        }
        $('.field-error-msg').removeClass('show');
    });

    $('#modalAddSoap').on('show.bs.modal', function() {
        // $('#add_soap_textarea').summernote('code', soapTemplate);
        $('.sync-cppt-tgl').val(getNowDatetimeLocal());
        $('.sync-cppt-ppa').val('-');
    });

    $('#modalAddInstruksi').on('show.bs.modal', function() {
        $('#add_instruksi_textarea').summernote('code', instruksiTemplate);
        $('.sync-cppt-tgl').val(getNowDatetimeLocal());
        $('.sync-cppt-ppa').val('-');
    });

    $('#modalEditCppt').on('hidden.bs.modal', function() {
        $('#edit_cppt_soap').summernote('code', '');
        $('#edit_cppt_instruksi').summernote('code', '');
        if (window.dropdown_edit_cppt_ppa) {
            window.dropdown_edit_cppt_ppa.setValue('');
        }
        $('#edit_cppt_tgl').val('');
        $('#edit_hidden_cppt_cd').val('');
        $('.field-error-msg').removeClass('show');
        $.each(sectionMap, function(k, v) {
            $('#' + v.div).hide();
        });
    });

    $(document).on('click', '.pilihpasien', function() {
        var no_registrasi = $(this).data('no_registrasi');
        var patient_no = $(this).data('patient_no');
        var fullname = $(this).data('fullname');
        var birth_dt = $(this).data('birth_dt');
        var tahun = $(this).data('tahun');
        var bulan = $(this).data('bulan');
        var gender = $(this).data('gender');
        var nama_dokter = $(this).data('nama_dokter');
        var tujuan_registrasi_desc = $(this).data('tujuan_registrasi_desc');
        var type_pasien = $(this).data('type_pasien');
        var flag_alergi = $(this).data('flag_alergi');

        $.ajax({
            url: "<?= site_url('cppt/setNoRegistrasi'); ?>",
            method: "GET",
            data: {
                no_registrasi: no_registrasi,
                patient_no: patient_no
            }
        });

        $('#f_no_registrasi').val(no_registrasi);
        $('#f_medrec_id').val(patient_no);
        $('.sync-no-reg').val(no_registrasi);
        $('#edit_no_registrasi').val(no_registrasi);

        var clean_birth_dt = '';
        if (birth_dt) {
            var dateOnly = String(birth_dt).split(' ')[0];
            var parts = dateOnly.split('/');
            if (parts.length === 3) {
                clean_birth_dt = parts[1] + '/' + parts[0] + '/' + parts[2];
            } else {
                var dash = dateOnly.split('-');
                clean_birth_dt = (dash.length === 3) ? dash[2] + '/' + dash[1] + '/' + dash[0] : dateOnly;
            }
        }

        $('#no_registrasi_display').html(no_registrasi);
        $('#medrec_id_info').html(patient_no);
        $('#fullname_tm').html(fullname);
        $('#birth_dt_tm').html(clean_birth_dt);
        $('#tahun').html(tahun);
        $('#bulan').html(bulan);
        $('#gender_tm').html(gender);
        $('#nama_dokter').html(nama_dokter);
        $('#tujuan_registrasi_desc').html(tujuan_registrasi_desc);
        $('#type_pasien').html(type_pasien);
        $('#birth_dt_tmx').html(flag_alergi || '-');

        $('#header-identitas-pasien').fadeIn();
        $('#melayang').fadeIn();
        fetchCpptData();

        // =============================================
        // AMBIL DATA PEMERIKSAAN PERAWAT
        // =============================================
        $.ajax({
            url: "<?= site_url('cppt/setDataPemeriksaanPerawat'); ?>",
            method: "GET",
            data: {
                no_registrasi: no_registrasi
            },
            dataType: "JSON",
            beforeSend: function() {
                $('#submit_button').prop('disabled', true);
                $('#submit_button').html('<i class="fa fa-spin fa-spinner"></i>');
                console.log('Mengambil data pemeriksaan perawat untuk:', no_registrasi);
            },
            complete: function() {
                $('#submit_button').prop('disabled', false);
                $('#submit_button').html('Simpan');
            },
            success: function(response) {
                console.log('Response:', response);

                // Cek apakah response sukses dan memiliki data
                if (response.status === 'success' && response.data) {
                    // Ambil data pemeriksaan dari response.data
                    var pemeriksaanData = response.data;
                    console.log('Data pemeriksaan:', pemeriksaanData);

                    // Isi form dengan data pemeriksaan perawat
                    fillPemeriksaanPerawatForm(pemeriksaanData);
                } else {
                    console.log('Data pemeriksaan tidak ditemukan atau error');
                    resetPemeriksaanPerawatForm();
                }
            },
            error: function(xhr, status, error) {
                console.log('Error status:', status);
                console.log('Error message:', error);
                console.log('Response text:', xhr.responseText);
                console.log('Status code:', xhr.status);

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Mengambil Data',
                    text: 'Terjadi kesalahan saat mengambil data pemeriksaan. Status: ' + xhr.status,
                    footer: xhr.responseText
                });

                resetPemeriksaanPerawatForm();
            }
        });

        // =============================================
        // FUNGSI UNTUK MENGISI FORM PEMERIKSAAN PERAWAT
        // =============================================
        // function fillPemeriksaanPerawatForm(data) {
        //     console.log('Mengisi form dengan data:', data);

        //     // Anamnesa
        //     if (data.keluhanUtama) {
        //         $('#keluhan_utama').val(data.keluhanUtama);
        //         $('#inih').val(data.keluhanUtama);
        //         alert(data.keluhanUtama)
        //         console.log('Keluhan Utama diisi:', data.keluhanUtama);
        //     }
        //     if (data.riwayatKesehatanPasien) {
        //         $('#riwayat_kesehatan_pasien').val(data.riwayatKesehatanPasien);
        //         console.log('Riwayat Kesehatan diisi:', data.riwayatKesehatanPasien);
        //     }

        //     // Antropometri
        //     if (data.tinggiBadan) {
        //         $('#tinggi_badan').val(data.tinggiBadan);
        //         console.log('Tinggi Badan diisi:', data.tinggiBadan);
        //     }
        //     if (data.beratBadan) {
        //         $('#berat_badan').val(data.beratBadan);
        //         console.log('Berat Badan diisi:', data.beratBadan);
        //     }
        //     if (data.lingkarPinggang) {
        //         $('#lingkar_pinggang').val(data.lingkarPinggang);
        //         console.log('Lingkar Pinggang diisi:', data.lingkarPinggang);
        //     }
        //     if (data.lingkarPinggul) {
        //         $('#lingkar_pinggul').val(data.lingkarPinggul);
        //         console.log('Lingkar Pinggul diisi:', data.lingkarPinggul);
        //     }
        //     if (data.lingkarLenganAtas) {
        //         $('#muac').val(data.lingkarLenganAtas);
        //         console.log('MUAC diisi:', data.lingkarLenganAtas);
        //     }

        //     // Trigger BMI dan WHR calculation
        //     $('#tinggi_badan, #berat_badan').trigger('change');
        //     $('#lingkar_pinggang, #lingkar_pinggul').trigger('change');
        //     $('#muac').trigger('change');

        //     // Tanda Vital
        //     if (data.sistolik) {
        //         $('#sistolik').val(data.sistolik);
        //         console.log('Sistolik diisi:', data.sistolik);
        //     }
        //     if (data.diastolik) {
        //         $('#diastolik').val(data.diastolik);
        //         console.log('Diastolik diisi:', data.diastolik);
        //     }
        //     if (data.nadi) {
        //         $('#nadi').val(data.nadi);
        //         console.log('Nadi diisi:', data.nadi);
        //     }
        //     if (data.lajuNafas) {
        //         $('#laju_nafas').val(data.lajuNafas);
        //         console.log('Laju Nafas diisi:', data.lajuNafas);
        //     }
        //     if (data.spo2) {
        //         $('#spo2').val(data.spo2);
        //         console.log('SpO2 diisi:', data.spo2);
        //     }
        //     if (data.suhu) {
        //         $('#suhu').val(data.suhu);
        //         console.log('Suhu diisi:', data.suhu);
        //     }

        //     // Kondisi Umum (dropdown)
        //     if (data.kondisiUmum) {
        //         $('#kondisi_umum').val(data.kondisiUmum).trigger('change');
        //         console.log('Kondisi Umum diisi:', data.kondisiUmum);
        //     }

        //     // Kesadaran (dropdown)
        //     if (data.kesadaranUmum) {
        //         $('#kesadaran').val(data.kesadaranUmum).trigger('change');
        //         console.log('Kesadaran diisi:', data.kesadaranUmum);
        //     }

        //     // Status Fungsional (radio buttons)
        //     if (data.statusFungsional) {
        //         var status = data.statusFungsional.toLowerCase();
        //         console.log('Status Fungsional:', status);

        //         if (status === 'mandiri' || status === '1') {
        //             $('#mandiri').prop('checked', true);
        //             console.log('Radio Mandiri dipilih');
        //         } else if (status === 'perlubantuan' || status === '2') {
        //             $('#perlu_bantuan').prop('checked', true);
        //             console.log('Radio Perlu Bantuan dipilih');
        //         } else if (status === 'ketergantungantotal' || status === '3') {
        //             $('#ketergantungan_total').prop('checked', true);
        //             console.log('Radio Ketergantungan Total dipilih');
        //         }
        //     }

        //     // Perlu Bantuan Text
        //     if (data.statusFungsionalPerlubantuan) {
        //         $('#perlu_bantuan_text').val(data.statusFungsionalPerlubantuan);
        //         console.log('Perlu Bantuan Text diisi:', data.statusFungsionalPerlubantuan);
        //     }

        //     // Kebutuhan Edukasi
        //     if (data.kebutuhanEdukasi) {
        //         $('#kebutuhan_edukasi').val(data.kebutuhanEdukasi);
        //         console.log('Kebutuhan Edukasi diisi:', data.kebutuhanEdukasi);
        //     }

        //     // Pemeriksaan Fisik - Sub fields
        //     if (data.kepalaDanWajah) {
        //         $('#kepala_dan_wajah').val(data.kepalaDanWajah);
        //         console.log('Kepala dan Wajah diisi:', data.kepalaDanWajah);
        //     }
        //     if (data.cervicalSpin) {
        //         $('#cervical_spin').val(data.cervicalSpin);
        //         console.log('Cervical Spin diisi:', data.cervicalSpin);
        //     }
        //     if (data.thorax) {
        //         $('#thorax').val(data.thorax);
        //         console.log('Thorax diisi:', data.thorax);
        //     }
        //     if (data.abdomen) {
        //         $('#abdomen').val(data.abdomen);
        //         console.log('Abdomen diisi:', data.abdomen);
        //     }
        //     if (data.pemeriksaanNeurologis) {
        //         $('#pemeriksaan_neurologis').val(data.pemeriksaanNeurologis);
        //         console.log('Pemeriksaan Neurologis diisi:', data.pemeriksaanNeurologis);
        //     }
        //     if (data.ekstremitasMuskulosekeletal) {
        //         $('#ekstremitas_muskulosekeletal').val(data.ekstremitasMuskulosekeletal);
        //         console.log('Ekstremitas Muskulosekeletal diisi:', data.ekstremitasMuskulosekeletal);
        //     }
        //     if (data.statusLokalis) {
        //         $('#status_lokalis').val(data.statusLokalis);
        //         console.log('Status Lokalis diisi:', data.statusLokalis);
        //     }

        //     // Psikososial dan Spiritual (dropdown)
        //     if (data.psikososialDanSpiritual) {
        //         $('#psikososial_dan_spiritual').val(data.psikososialDanSpiritual).trigger('change');
        //         console.log('Psikososial dan Spiritual diisi:', data.psikososialDanSpiritual);
        //     }

        //     // Riwayat Penggunaan Obat
        //     if (data.riwayatPenggunaanObat) {
        //         $('#riwayat_penggunaan_obat').val(data.riwayatPenggunaanObat);
        //         console.log('Riwayat Penggunaan Obat diisi:', data.riwayatPenggunaanObat);
        //     }

        //     // Skrining Nyeri (dropdown)
        //     var nyeri = data.skalaNyeri || data.skriningNyeri;
        //     if (nyeri) {
        //         $('#skrining_nyeri').val(nyeri).trigger('change');
        //         console.log('Skrining Nyeri diisi:', nyeri);
        //     }

        //     // Status Kehamilan (radio buttons)
        //     if (data.statusKehamilan) {
        //         var kehamilan = data.statusKehamilan.toLowerCase();
        //         console.log('Status Kehamilan:', kehamilan);

        //         if (kehamilan === 'hamil' || kehamilan === '1') {
        //             $('#status_kehamilan_hamil').prop('checked', true);
        //             console.log('Radio Hamil dipilih');
        //         } else {
        //             $('#status_kehamilan_tidak').prop('checked', true);
        //             console.log('Radio Tidak Hamil dipilih');
        //         }
        //     }
        //     if (data.statusKehamilanHpht) {
        //         $('#status_kehamilan_hpht').val(data.statusKehamilanHpht);
        //         console.log('HPHT diisi:', data.statusKehamilanHpht);
        //     }
        //     if (data.statusKehamilanGravid) {
        //         $('#status_kehamilan_gravid').val(data.statusKehamilanGravid);
        //         console.log('Gravid diisi:', data.statusKehamilanGravid);
        //     }
        //     if (data.statusKehamilanAbortus) {
        //         $('#status_kehamilan_abortus').val(data.statusKehamilanAbortus);
        //         console.log('Abortus diisi:', data.statusKehamilanAbortus);
        //     }

        //     // Pemeriksaan Diagnostik
        //     if (data.pemeriksaanDiagnostik) {
        //         $('#pemeriksaan_diagnostik').val(data.pemeriksaanDiagnostik);
        //         console.log('Pemeriksaan Diagnostik diisi:', data.pemeriksaanDiagnostik);
        //     }

        //     // Diagnosa Keperawatan
        //     if (data.diagnosaKeperawatan) {
        //         $('#diagnosa_keperawatan').val(data.diagnosaKeperawatan);
        //         console.log('Diagnosa Keperawatan diisi:', data.diagnosaKeperawatan);
        //     }

        //     // Tampilkan notifikasi sukses
        //     Swal.fire({
        //         icon: 'success',
        //         title: 'Berhasil',
        //         text: 'Data pemeriksaan berhasil dimuat',
        //         timer: 2000,
        //         showConfirmButton: false
        //     });
        // }


        function updateSoapTemplate() {
            // Define the function to get keluhan utama value
            const updatedSoapTemplate = `
            <p><b>S :</b>&nbsp;${dataO.keluhanUtama}</p>
            <p><b>O :</b></p>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TD : ${dataO.tekananDarah} &nbsp;&nbsp;&nbsp;&nbsp; S : ${dataO.sh}</p>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; N : ${dataO.nd} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; RR : ${dataO.lajuNafas}</p>
            <p><b>A :</b></p>
            <p><b>P :</b></p>
            `;

            // Update the summernote content
            <?php if ($session->get('role_cd') === 'ROLE002') { ?>
                $('#add_soap_textarea').summernote('code', soapTemplate);
                $('#add_soap_text').val(soapTemplate);
            <?php } else { ?>
                $('#add_soap_textarea').summernote('code', updatedSoapTemplate);
                $('#add_soap_text').val(updatedSoapTemplate);
            <?php } ?>


        }

        function fillPemeriksaanPerawatForm(data) {
            console.log('Mengisi form dengan data:', data);

            // Update dataO with values from API response
            if (data.sistolik && data.diastolik) {
                dataO.tekananDarah = `${data.sistolik}/${data.diastolik}`;
            }
            if (data.suhu) {
                dataO.sh = data.suhu;
            }
            if (data.nadi) {
                dataO.nd = data.nadi;
            }
            if (data.lajuNafas) {
                dataO.lajuNafas = data.lajuNafas;
            }
            // alert(data.keluhanUtama);
            // Anamnesa
            if (data.keluhanUtama) {
                dataO.keluhanUtama = data.keluhanUtama;

            }

            if (data.riwayatKesehatanPasien) {
                dataO.riwayatKesehatanPasien = data.riwayatKesehatanPasien;
            }

            // Antropometri
            if (data.tinggiBadan) {
                $('#tinggi_badan').val(data.tinggiBadan);
                console.log('Tinggi Badan diisi:', data.tinggiBadan);
            }
            if (data.beratBadan) {
                $('#berat_badan').val(data.beratBadan);
                console.log('Berat Badan diisi:', data.beratBadan);
            }
            if (data.lingkarPinggang) {
                $('#lingkar_pinggang').val(data.lingkarPinggang);
                console.log('Lingkar Pinggang diisi:', data.lingkarPinggang);
            }
            if (data.lingkarPinggul) {
                $('#lingkar_pinggul').val(data.lingkarPinggul);
                console.log('Lingkar Pinggul diisi:', data.lingkarPinggul);
            }
            if (data.lingkarLenganAtas) {
                $('#muac').val(data.lingkarLenganAtas);
                console.log('MUAC diisi:', data.lingkarLenganAtas);
            }

            // Trigger BMI dan WHR calculation
            $('#tinggi_badan, #berat_badan').trigger('change');
            $('#lingkar_pinggang, #lingkar_pinggul').trigger('change');
            $('#muac').trigger('change');

            // Tanda Vital
            if (data.sistolik) {
                $('#sistolik').val(data.sistolik);
                console.log('Sistolik diisi:', data.sistolik);
            }
            if (data.diastolik) {
                $('#diastolik').val(data.diastolik);
                console.log('Diastolik diisi:', data.diastolik);
            }
            if (data.nadi) {
                $('#nadi').val(data.nadi);
                console.log('Nadi diisi:', data.nadi);
            }
            if (data.lajuNafas) {
                $('#laju_nafas').val(data.lajuNafas);
                console.log('Laju Nafas diisi:', data.lajuNafas);
            }
            if (data.spo2) {
                $('#spo2').val(data.spo2);
                console.log('SpO2 diisi:', data.spo2);
            }
            if (data.suhu) {
                $('#suhu').val(data.suhu);
                console.log('Suhu diisi:', data.suhu);
            }

            // Update SOAP template with new dataO values
            updateSoapTemplate();

            // ... rest of your function remains the same
        }

        // function resetPemeriksaanPerawatForm() {
        //     console.log('Reset form pemeriksaan perawat');

        //     // Reset semua field ke kosong
        //     $('#keluhan_utama').val('');
        //     $('#riwayat_kesehatan_pasien').val('');
        //     $('#tinggi_badan').val('');
        //     $('#berat_badan').val('');
        //     $('#lingkar_pinggang').val('');
        //     $('#lingkar_pinggul').val('');
        //     $('#muac').val('');
        //     $('#lingkar_lengan_atas').val('');
        //     $('#sistolik').val('');
        //     $('#diastolik').val('');
        //     $('#nadi').val('');
        //     $('#laju_nafas').val('');
        //     $('#spo2').val('');
        //     $('#suhu').val('');
        //     $('#bmi').val('');
        //     $('#whr').val('');
        //     $('#kondisi_umum').val('').trigger('change');
        //     $('#kesadaran').val('').trigger('change');
        //     $('#mandiri').prop('checked', true);
        //     $('#perlu_bantuan_text').val('');
        //     $('#kebutuhan_edukasi').val('');
        //     $('#kepala_dan_wajah').val('');
        //     $('#cervical_spin').val('');
        //     $('#thorax').val('');
        //     $('#abdomen').val('');
        //     $('#pemeriksaan_neurologis').val('');
        //     $('#ekstremitas_muskulosekeletal').val('');
        //     $('#status_lokalis').val('');
        //     $('#psikososial_dan_spiritual').val('').trigger('change');
        //     $('#riwayat_penggunaan_obat').val('');
        //     $('#skrining_nyeri').val('').trigger('change');
        //     $('#status_kehamilan_tidak').prop('checked', true);
        //     $('#status_kehamilan_hpht').val('');
        //     $('#status_kehamilan_gravid').val('');
        //     $('#status_kehamilan_abortus').val('');
        //     $('#pemeriksaan_diagnostik').val('');
        //     $('#diagnosa_keperawatan').val('');
        // }
    });

    $(document).on('submit', '.form-add-section', function(e) {
        e.preventDefault();
        var $form = $(this);
        var section = $form.data('section');
        var isValid = true;

        if (section === 'umum') {
            if (!$('#add_umum_tgl').val()) {
                $('#add_umum_err_tgl').addClass('show');
                isValid = false;
            } else {
                $('#add_umum_err_tgl').removeClass('show');
            }
            if ($('#add_umum_ppa').val().trim() === '') {
                $('#add_umum_err_ppa').addClass('show');
                isValid = false;
            } else {
                $('#add_umum_err_ppa').removeClass('show');
            }
        }

        if (!isValid) return;

        var no_reg = $('#f_no_registrasi').val();
        if (!no_reg) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Pilih pasien terlebih dahulu.'
            });
            return;
        }

        var $btn = $form.find('.btn-submit-section');
        $.ajax({
            url: "<?= site_url('cppt/action'); ?>",
            method: "POST",
            data: $form.serialize(),
            dataType: "JSON",
            beforeSend: function() {
                $btn.prop('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Menyimpan...');
            },
            complete: function() {
                $btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Simpan');
            },
            success: function(response) {
                if (response.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Menyimpan',
                        text: Object.values(response.error).filter(Boolean).join('\n')
                    });
                } else if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.success
                    }).then(function() {
                        $form.closest('.modal').modal('hide');
                        fetchCpptData();
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Tidak dapat menghubungi server.'
                });
            }
        });
    });

    $(document).on('click', '.cppt-edit-col', function() {
        var tab = $(this).data('tab');
        var d = $(this).closest('tr').data('row');
        if (!d) return;

        var tabToSection = {
            'edit-tab-umum': 'umum',
            'edit-tab-soap': 'soap',
            'edit-tab-instruksi': 'instruksi'
        };

        var tgl_raw = d.cppt_tgl || '';
        var tgl_clean = tgl_raw ? String(tgl_raw).replace('Z', '').replace(/\.\d+$/, '').substring(0, 16).replace(' ', 'T') : '';

        $('#edit_hidden_cppt_cd').val(d.cppt_cd || '');
        $('#edit_no_registrasi').val(d.no_registrasi || $('#f_no_registrasi').val());
        $('#edit_cppt_tgl').val(tgl_clean);
        if (window.dropdown_edit_cppt_ppa) {
            window.dropdown_edit_cppt_ppa.setValue(d.cppt_profesional_pemberiasuhan || '');
        } else {
            $('#edit_cppt_ppa').val(d.cppt_profesional_pemberiasuhan || '');
        }
        $('#edit_cppt_soap').summernote('code', d.cppt_hasil_assesment_pasien || soapTemplate);
        $('#edit_cppt_instruksi').summernote('code', d.cppt_instruksi_ppa || instruksiTemplate);
        $('#edit_verifikasi_dpjp').val(d.cppt_verifikasi_dpjp || '');
        $('.field-error-msg').removeClass('show');

        showEditSection(tabToSection[tab] || 'umum');
        $('#modalEditCppt').modal('show');
    });

    $('#edit_form').on('submit', function(e) {
        e.preventDefault();
        var currentSection = $(this).find('input[name="section"]').val();
        var isValid = true;

        if (currentSection === 'umum') {
            if (!$('#edit_cppt_tgl').val()) {
                $('#edit_err_tgl').addClass('show');
                isValid = false;
            } else {
                $('#edit_err_tgl').removeClass('show');
            }

            if ($('#edit_cppt_ppa').val().trim() === '') {
                $('#edit_err_ppa').addClass('show');
                isValid = false;
            } else {
                $('#edit_err_ppa').removeClass('show');
            }
        }

        if (!isValid) return;

        $.ajax({
            url: "<?= site_url('cppt/action'); ?>",
            method: "POST",
            data: $(this).serialize(),
            dataType: "JSON",
            beforeSend: function() {
                $('#edit_submit_button').prop('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Menyimpan...');
            },
            complete: function() {
                $('#edit_submit_button').prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Simpan Perubahan');
            },
            success: function(response) {
                if (response.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: Object.values(response.error).join('\n')
                    });
                } else if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.success
                    }).then(function() {
                        $('#modalEditCppt').modal('hide');
                        fetchCpptData();
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Tidak dapat menghubungi server.'
                });
            }
        });
    });

    $('#btn_refresh').on('click', function() {
        fetchCpptData();
    });

    $('#btn_cetak').on('click', function() {
        var no_reg = $('#f_no_registrasi').val();
        if (!no_reg) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Pilih pasien terlebih dahulu.'
            });
            return;
        }
        var params = new URLSearchParams({
            no_rm: $('#medrec_id_info').text().trim(),
            nama_pasien: $('#fullname_tm').text().trim(),
            tgl_lahir: $('#birth_dt_tm').text().trim(),
            gender: $('#gender_tm').text().trim()
        });
        window.open("<?= site_url('cppt/printCppt'); ?>/" + no_reg + '?' + params.toString(), '_blank');
    });

    $(document).on('click', '.delete', function(e) {
        e.stopPropagation();
        const cppt_cd = $(this).data('id');
        if (!cppt_cd) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'ID tidak ditemukan.'
            });
            return;
        }

        Swal.fire({
            title: 'Yakin ingin menghapus data?',
            text: 'Data CPPT akan dihapus secara permanen.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('cppt/delete'); ?>",
                    method: "POST",
                    data: {
                        cppt_cd: cppt_cd
                    },
                    dataType: "JSON",
                    success: function(response) {
                        if (response.status === 'error') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message || 'Gagal menghapus.'
                            });
                        } else {
                            Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message || 'Data berhasil dihapus.'
                                })
                                .then(function() {
                                    fetchCpptData();
                                });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Terjadi kesalahan server.'
                        });
                    }
                });
            }
        });
    });
</script>
<?= $this->endSection('script'); ?>