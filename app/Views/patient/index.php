<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>
<!-- Toastr -->
<link rel="stylesheet" href="<?= base_url('plugins/toastr/toastr.min.css') ?>">
<!-- Button datatable -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<!-- datepicker styles -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="<?= base_url('plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">

<style>
    .btn-fix-w {
        width: 60px;
        padding-top: 0px;
        padding-bottom: 0px;
    }

    select.form-control-sm~.select2-container--default {
        font-size: .720rem !important;
    }

    .form-control-sm {
        font-size: .720rem !important;
    }

    select.is-invalid#id_typ {
        border-color: #FF0000 !important;
    }

    .draft-row {
        background-color: #fff3cd !important;
    }

    .draft-badge {
        background-color: #ffc107;
        color: #212529;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 10px;
        font-weight: bold;
        display: inline-block;
    }

    .booking-badge {
        background-color: #17a2b8;
        color: #fff;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 10px;
        font-weight: bold;
        display: inline-block;
        margin-left: 2px;
    }

    .filter-btn.active {
        outline: 2px solid #007bff;
        outline-offset: 2px;
    }

    .btn-insertinto {
        background-color: #28a745;
        color: white;
    }

    .btn-insertinto:hover {
        background-color: #218838;
        color: white;
    }

    .d-none {
        display: none !important;
    }
</style>
<?= $this->endSection('style'); ?>

<?= $this->section('content'); ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1></h1>
                </div>
                <div class="col-sm-6">
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-info">
                        <div class="card-body">
                            <div class="card-title"></div>
                            <span id="viewdata"></span>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="modalform" tabindex="" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                            <div class="modal-dialog modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLabel"></h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="post" id="data_form" autocomplete="off">
                                        <?= csrf_field(); ?>
                                        <div class="modal-body">
                                            <div class="col-12 col-sm-12">
                                                <div class="card card-primary card-outline card-outline-tabs">
                                                    <div class="card-header p-0 border-bottom-0">
                                                        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                                            <li class="nav-item">
                                                                <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Informasi Umum</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Domisili</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">Keluarga Terdekat</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="tab-content" id="custom-tabs-four-tabContent">
                                                            <!-- Tab Informasi Umum -->
                                                            <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                                                <div class="col-sm-12">

                                                                    <div class="mb-3 row">
                                                                        <label for="patient_no" class="col-sm-2 col-form-label">Nomor RM</label>
                                                                        <div class="col-sm-2">
                                                                            <input type="text" class="form-control form-control-sm" id="patient_no" name="patient_no" autofocus autocomplete="off">
                                                                            <span class="error invalid-feedback errorPatient_no"></span>
                                                                        </div>
                                                                        <label for="flag_booking" class="col-sm-1 col-form-label"></label>
                                                                        <div class="col-sm-1">
                                                                            <div class="icheck-primary d-inline">
                                                                                <input type="checkbox" id="flag_booking" name="flag_booking">
                                                                                <label for="flag_booking">Booking</label>
                                                                            </div>
                                                                            <span class="error invalid-feedback errorFlag_booking"></span>
                                                                        </div>
                                                                        <label for="flag_wna" class="col-sm-1 col-form-label"></label>
                                                                        <div class="col-sm-1">
                                                                            <div class="icheck-primary d-inline">
                                                                                <input type="checkbox" id="flag_wna" name="flag_wna">
                                                                                <label for="flag_wna">WNA</label>
                                                                            </div>
                                                                            <span class="error invalid-feedback errorFlag_wna"></span>
                                                                        </div>
                                                                        <?= $cb_country ?>
                                                                    </div>

                                                                    <div class="mb-3 row">
                                                                        <?= $cb_country_cd ?>
                                                                        <label for="mobile_no" class="col-sm-1 col-form-label">No. HP</label>
                                                                        <div class="col-sm-3">
                                                                            <input type="text" class="form-control form-control-sm" id="mobile_no" name="mobile_no" placeholder="(0xxxxxxxx)" autocomplete="off">
                                                                            <span class="error invalid-feedback errorMobile_no"></span>
                                                                        </div>
                                                                        <?= $cb_source_info ?>
                                                                    </div>

                                                                    <div class="mb-3 row">
                                                                        <label for="source_info_lain" class="col-sm-2 col-form-label source_info_lain_input"></label>
                                                                        <div class="col-sm-10">
                                                                            <textarea class="form-control form-control-sm source_info_lain_input" rows="3" placeholder="..." id="source_info_lain" name="source_info_lain" autocomplete="off"></textarea>
                                                                            <span class="error invalid-feedback errorSource_info_lain"></span>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3 row">
                                                                        <?= $cb_title_cd ?>
                                                                        <label for="fullname" class="col-sm-1 col-form-label">Nama Pasien</label>
                                                                        <div class="col-sm-3">
                                                                            <input type="text" class="form-control form-control-sm" id="fullname" name="fullname" autocomplete="off">
                                                                            <span class="error invalid-feedback errorFullname"></span>
                                                                        </div>
                                                                        <?= $cb_religion ?>
                                                                    </div>

                                                                    <div class="mb-3 row">
                                                                        <?= $cb_id_typ ?>
                                                                        <label for="id_no" class="col-sm-1 col-form-label">No. Identitas</label>
                                                                        <div class="col-sm-3">
                                                                            <input type="text" class="form-control form-control-sm" id="id_no" name="id_no" autocomplete="off">
                                                                            <span class="error invalid-feedback errorId_no"></span>
                                                                        </div>
                                                                        <?= $cb_job_title_cd ?>
                                                                    </div>

                                                                    <div class="mb-3 row">
                                                                        <div class="col-sm-2 job_lain_input"></div>
                                                                        <div class="col-sm-4 job_lain_input"></div>
                                                                        <label for="job_lain" class="col-sm-2 col-form-label job_lain_input"></label>
                                                                        <div class="col-sm-4">
                                                                            <textarea class="form-control form-control-sm job_lain_input" rows="3" placeholder="..." id="job_lain" name="job_lain" autocomplete="off"></textarea>
                                                                            <span class="error invalid-feedback errorJob_lain"></span>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3 row">
                                                                        <?= $cb_gender ?>
                                                                        <?= $cb_education ?>
                                                                        <?= $cb_married_sta_id ?>
                                                                    </div>

                                                                    <div class="mb-3 row">
                                                                        <?= $cb_birthplace ?>
                                                                        <label for="birth_dt" class="col-sm-1 col-form-label">Tgl Lahir</label>
                                                                        <div class="col-sm-3">
                                                                            <div class="input-group date birth_dt" data-date-format="mm/dd/yyyy">
                                                                                <input type="text" class="form-control form-control-sm datepicker" placeholder="mm/dd/yyyy" id="birth_dt" name="birth_dt" autocomplete="off">
                                                                                <div class="input-group-append" data-target="#birth_dt" data-toggle="birth_dt">
                                                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                                </div>
                                                                            </div>
                                                                            <span class="error invalid-feedback errorBirth_dt"></span>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Cari Kode Pos - UMUM -->
                                                                    <div class="mb-3 row">
                                                                        <label for="kodepos-umum" class="col-sm-2 col-form-label">Cari Kode Pos</label>
                                                                        <div class="col-sm-6">
                                                                            <select class="form-control form-control-sm" id="kodepos-umum" style="width:100%">
                                                                                <option value=""></option>
                                                                            </select>
                                                                            <input type="hidden" id="kodepos-umum-value" name="kodepos_umum" />
                                                                            <small class="form-text text-muted">Ketik kode pos atau nama kelurahan, minimal 3 karakter.</small>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3 row">
                                                                        <label for="provinsi-umum" class="col-sm-2 col-form-label">Provinsi</label>
                                                                        <div class="col-sm-3">
                                                                            <select class="form-control form-control-sm umum" id="provinsi-umum" name="provinsi-umum">
                                                                                <option value="">Select Provinsi</option>
                                                                            </select>
                                                                        </div>
                                                                        <label for="kabupaten-umum" class="col-sm-1 col-form-label">Kab / Kota</label>
                                                                        <div class="col-sm-3">
                                                                            <select class="form-control form-control-sm umum" id="kabupaten-umum" name="kabupaten-umum">
                                                                                <option value="">Select Kab / Kota</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3 row">
                                                                        <label for="kecamatan-umum" class="col-sm-2 col-form-label">Kecamatan</label>
                                                                        <div class="col-sm-3">
                                                                            <select class="form-control form-control-sm umum" id="kecamatan-umum" name="kecamatan-umum">
                                                                                <option value="">Select Kecamatan</option>
                                                                            </select>
                                                                        </div>
                                                                        <label for="kelurahan-umum" class="col-sm-1 col-form-label">Kelurahan</label>
                                                                        <div class="col-sm-3">
                                                                            <select class="form-control form-control-sm umum" id="kelurahan-umum" name="kelurahan-umum">
                                                                                <option value="">Select Kelurahan</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3 row">
                                                                        <label for="addr" class="col-sm-2 col-form-label">Alamat Lengkap KTP</label>
                                                                        <div class="col-sm-10">
                                                                            <textarea class="form-control form-control-sm" rows="2" placeholder="..." id="addr" name="addr" autocomplete="off"></textarea>
                                                                            <span class="error invalid-feedback errorAddr"></span>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                            <!-- Tab Domisili -->
                                                            <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                                                                <div class="col-sm-12">

                                                                    <!-- Cari Kode Pos - DOMISILI -->
                                                                    <div class="mb-3 row">
                                                                        <label for="kodepos-domisili" class="col-sm-2 col-form-label">Cari Kode Pos</label>
                                                                        <div class="col-sm-6">
                                                                            <select class="form-control form-control-sm" id="kodepos-domisili" style="width:100%">
                                                                                <option value=""></option>
                                                                            </select>
                                                                            <input type="hidden" id="kodepos-domisili-value" name="kodepos_domisili" />
                                                                            <small class="form-text text-muted">Ketik kode pos atau nama kelurahan, minimal 3 karakter.</small>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3 row">
                                                                        <label for="provinsi-domisili" class="col-sm-2 col-form-label">Provinsi</label>
                                                                        <div class="col-sm-4">
                                                                            <select class="form-control form-control-sm domisili" id="provinsi-domisili" name="provinsi-domisili"></select>
                                                                        </div>
                                                                        <label for="kabupaten-domisili" class="col-sm-2 col-form-label">Kab / Kota</label>
                                                                        <div class="col-sm-4">
                                                                            <select class="form-control form-control-sm domisili" id="kabupaten-domisili" name="kabupaten-domisili"></select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3 row">
                                                                        <label for="kecamatan-domisili" class="col-sm-2 col-form-label">Kecamatan</label>
                                                                        <div class="col-sm-4">
                                                                            <select class="form-control form-control-sm domisili" id="kecamatan-domisili" name="kecamatan-domisili"></select>
                                                                        </div>
                                                                        <label for="kelurahan-domisili" class="col-sm-2 col-form-label">Kelurahan</label>
                                                                        <div class="col-sm-4">
                                                                            <select class="form-control form-control-sm domisili" id="kelurahan-domisili" name="kelurahan-domisili"></select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3 row">
                                                                        <div class="col-sm-4"></div>
                                                                        <div class="col-sm-8">
                                                                            <button type="button" class="btn btn-xs btn-info float-right" id="addr_copy">Copy Alamat KTP</button>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3 row">
                                                                        <label for="addr_domisili" class="col-sm-2 col-form-label">Alamat Lengkap Domisili</label>
                                                                        <div class="col-sm-10">
                                                                            <textarea class="form-control form-control-sm" rows="3" placeholder="..." id="addr_domisili" name="addr_domisili" autocomplete="off"></textarea>
                                                                            <span class="error invalid-feedback errorAddr_domisili"></span>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3 row" style="display:none;">
                                                                        <div class="col-sm-6">
                                                                            <input type="text" class="form-control form-control-sm" id="postcode" name="postcode" placeholder="Kode Pos" autocomplete="off">
                                                                            <span class="error invalid-feedback errorPostcode"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Tab Keluarga -->
                                                            <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
                                                                <div class="col-sm-12">

                                                                    <!-- Cari Kode Pos - KELUARGA -->
                                                                    <div class="mb-3 row">
                                                                        <label for="kodepos-keluarga" class="col-sm-2 col-form-label">Cari Kode Pos</label>
                                                                        <div class="col-sm-6">
                                                                            <select class="form-control form-control-sm" id="kodepos-keluarga" style="width:100%">
                                                                                <option value=""></option>
                                                                            </select>
                                                                            <input type="hidden" id="kodepos-keluarga-value" name="kodepos_keluarga" />
                                                                            <small class="form-text text-muted">Ketik kode pos atau nama kelurahan, minimal 3 karakter.</small>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3 row">
                                                                        <label for="provinsi-keluarga" class="col-sm-2 col-form-label">Provinsi</label>
                                                                        <div class="col-sm-4">
                                                                            <select class="form-control form-control-sm keluarga" id="provinsi-keluarga" name="provinsi-keluarga"></select>
                                                                        </div>
                                                                        <label for="kabupaten-keluarga" class="col-sm-2 col-form-label">Kab / Kota</label>
                                                                        <div class="col-sm-4">
                                                                            <select class="form-control form-control-sm keluarga" id="kabupaten-keluarga" name="kabupaten-keluarga"></select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3 row">
                                                                        <label for="kecamatan-keluarga" class="col-sm-2 col-form-label">Kecamatan</label>
                                                                        <div class="col-sm-4">
                                                                            <select class="form-control form-control-sm keluarga" id="kecamatan-keluarga" name="kecamatan-keluarga"></select>
                                                                        </div>
                                                                        <label for="kelurahan-keluarga" class="col-sm-2 col-form-label">Kelurahan</label>
                                                                        <div class="col-sm-4">
                                                                            <select class="form-control form-control-sm keluarga" id="kelurahan-keluarga" name="kelurahan-keluarga"></select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3 row">
                                                                        <label for="family_name" class="col-sm-2 col-form-label">Nama Lengkap</label>
                                                                        <div class="col-sm-10">
                                                                            <input type="text" class="form-control form-control-sm" id="family_name" name="family_name" autocomplete="off">
                                                                            <span class="error invalid-feedback errorFamily_name"></span>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3 row">
                                                                        <div class="col-sm-2"></div>
                                                                        <div class="col-sm-10">
                                                                            <button type="button" class="btn btn-xs btn-info float-right" id="family_addr_copy">Copy Alamat Domisili</button>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3 row">
                                                                        <label for="family_addr" class="col-sm-2 col-form-label">Alamat Lengkap</label>
                                                                        <div class="col-sm-10">
                                                                            <textarea class="form-control form-control-sm" rows="3" placeholder="..." id="family_addr" name="family_addr" autocomplete="off"></textarea>
                                                                            <span class="error invalid-feedback errorFamily_addr"></span>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3 row">
                                                                        <label for="family_handphone" class="col-sm-2 col-form-label">No. Hp</label>
                                                                        <div class="col-sm-10">
                                                                            <input type="text" class="form-control form-control-sm" id="family_handphone" name="family_handphone" autocomplete="off">
                                                                            <span class="error invalid-feedback errorFamily_handphone"></span>
                                                                        </div>
                                                                    </div>

                                                                    <?= $cb_family_relation ?>

                                                                    <div class="mb-3 row">
                                                                        <label for="family_relation_lain" class="col-sm-2 col-form-label family_relation_lain_input"></label>
                                                                        <div class="col-sm-10">
                                                                            <textarea class="form-control form-control-sm family_relation_lain_input" rows="3" placeholder="..." id="family_relation_lain" name="family_relation_lain" autocomplete="off"></textarea>
                                                                            <span class="error invalid-feedback errorFamily_relation_lain"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <input type="hidden" id="lokasi" />
                                            <input type="hidden" id="flag_booking_old" name="flag_booking_old" />
                                            <input type="hidden" id="hidden_id" name="hidden_id" />
                                            <input type="hidden" id="form_active" />
                                            <input type="hidden" id="action" name="action" value="Add" />
                                            <input type="hidden" id="is_draft" name="is_draft" value="0" />

                                            <!-- Tombol Simpan sebagai Draft -->
                                            <button type="button" id="save_draft_button" class="btn btn-sm btn-warning">
                                                <i class="fas fa-file-alt"></i> Simpan sebagai Draft
                                            </button>

                                            <!-- Tombol Simpan (Publish) -->
                                            <button type="submit" name="submit" id="submit_button" class="btn btn-sm btn-primary" value="Simpan">
                                                <i class="fas fa-save"></i> Simpan
                                            </button>

                                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection('content'); ?>

<?= $this->section('script'); ?>

<!-- Toastr -->
<script src="<?= base_url('plugins/toastr/toastr.min.js') ?>"></script>

<!-- Button datatable -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<!-- Select2 -->
<script src="<?= base_url('plugins/select2/js/select2.full.min.js') ?>"></script>

<!-- Datepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<script>
    $('#active-menu').html($('p#active-menu').html());
    $(document).prop("title", $('p#active-menu').html());
</script>

<script>
    // INISIALISASI SELECT2 GENERIK
    $(".select").select2({
        minimumResultsForSearch: Infinity
    });

    $('#birth_dt').datepicker({
        minDate: 0,
        todayHighlight: true,
        autoclose: true,
        dateFormat: 'MM/DD/YYYY'
    }).val();
</script>

<!-- =====================================================================
     SCRIPT LOKASI
     ===================================================================== -->
<script>
    // Flag per-grup
    var isProgrammaticLoad = {
        umum: false,
        domisili: false,
        keluarga: false
    };

    function clearOptionsGeneric(ids) {
        ids.forEach(function(id) {
            $('#' + id).empty().append('<option value="">Select</option>').trigger('change');
        });
    }

    function getPrefixFromId(id) {
        var parts = id.split('-');
        return parts[parts.length - 1];
    }

    function setSelectSilently(prefix, id, value, callback) {
        isProgrammaticLoad[prefix] = true;
        $('#' + id).val(value || '').trigger('change');
        isProgrammaticLoad[prefix] = false;
        if (typeof callback === 'function') callback();
    }

    function loadKota(provinceId, targetId, selectedValue, callback) {
        var prefix = getPrefixFromId(targetId);
        if (!provinceId) {
            $('#' + targetId).html('<option value="">Select Kota</option>');
            if (typeof callback === 'function') callback();
            return;
        }
        $.ajax({
            url: '<?= base_url('location/getKota') ?>/' + provinceId,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var options = '<option value="">Select Kota</option>';
                $.each(data, function(index, value) {
                    options += '<option value="' + value.kode + '">' + value.nama + '</option>';
                });
                $('#' + targetId).html(options);
                setSelectSilently(prefix, targetId, selectedValue, callback);
            }
        });
    }

    function loadKecamatan(cityId, targetId, selectedValue, callback) {
        var prefix = getPrefixFromId(targetId);
        if (!cityId) {
            $('#' + targetId).html('<option value="">Select Kecamatan</option>');
            if (typeof callback === 'function') callback();
            return;
        }
        $.ajax({
            url: '<?= base_url('location/getKecamatan') ?>/' + cityId,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var options = '<option value="">Select Kecamatan</option>';
                $.each(data, function(index, value) {
                    options += '<option value="' + value.kode + '">' + value.nama + '</option>';
                });
                $('#' + targetId).html(options);
                setSelectSilently(prefix, targetId, selectedValue, callback);
            }
        });
    }

    function loadKelurahan(districtId, targetId, selectedValue, callback) {
        var prefix = getPrefixFromId(targetId);
        if (!districtId) {
            $('#' + targetId).html('<option value="">Select Kelurahan</option>');
            if (typeof callback === 'function') callback();
            return;
        }
        $.ajax({
            url: '<?= base_url('location/getKelurahan') ?>/' + districtId,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var options = '<option value="">Select Kelurahan</option>';
                $.each(data, function(index, value) {
                    options += '<option value="' + value.kode + '">' + value.nama + '</option>';
                });
                $('#' + targetId).html(options);
                setSelectSilently(prefix, targetId, selectedValue, callback);
            }
        });
    }

    function fillLocationGroup(prefix, provinsiVal, kotaVal, kecamatanVal, kelurahanVal, callback) {
        setSelectSilently(prefix, 'provinsi-' + prefix, provinsiVal, function() {
            loadKota(provinsiVal, 'kabupaten-' + prefix, kotaVal, function() {
                loadKecamatan(kotaVal, 'kecamatan-' + prefix, kecamatanVal, function() {
                    loadKelurahan(kecamatanVal, 'kelurahan-' + prefix, kelurahanVal, function() {
                        if (kelurahanVal) {
                            $.ajax({
                                url: '<?= base_url('location/getKodeposByKelurahan') ?>/' + kelurahanVal,
                                type: 'GET',
                                dataType: 'json',
                                success: function(data) {
                                    if (data.kodepos) {
                                        $('#kodepos-' + prefix + '-value').val(data.kodepos);
                                    }
                                    if (typeof callback === 'function') callback();
                                },
                                error: function() {
                                    if (typeof callback === 'function') callback();
                                }
                            });
                        } else {
                            if (typeof callback === 'function') callback();
                        }
                    });
                });
            });
        });
    }

    function fetchAndFillByKodepos(prefix, kodeKelurahan, callback) {
        $.ajax({
            url: '<?= base_url('location/getHierarchy') ?>/' + kodeKelurahan,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                fillLocationGroup(
                    prefix,
                    data.provinsi.kode,
                    data.kabupaten.kode,
                    data.kecamatan.kode,
                    data.kelurahan.kode,
                    function() {
                        if (data.kodepos) {
                            $('#kodepos-' + prefix + '-value').val(data.kodepos);
                        }
                        if (prefix === 'domisili' && data.kodepos) {
                            $('#postcode').val(data.kodepos);
                        }
                        if (typeof callback === 'function') callback(data);
                    }
                );
            },
            error: function() {
                console.error('Error fetching hierarchy for:', kodeKelurahan);
                if (typeof callback === 'function') callback();
            }
        });
    }

    function setKodeposDisplay(prefix, kodeKelurahan, kodepos, namaKelurahan) {
        var $target = $('#kodepos-' + prefix);
        if ($target.length === 0) return;

        if (!kodeKelurahan || !kodepos) {
            $target.val(null).trigger('change');
            $('#kodepos-' + prefix + '-value').val('');
            return;
        }

        var text = kodepos + ' - ' + (namaKelurahan || '');
        if ($target.find('option[value="' + kodeKelurahan + '"]').length === 0) {
            var newOption = new Option(text, kodeKelurahan, true, true);
            $target.append(newOption);
        }
        $target.val(kodeKelurahan).trigger('change');
        $('#kodepos-' + prefix + '-value').val(kodepos);
    }

    function copyKodeposTo(targetPrefix, kodeKelurahan, callback) {
        if (!kodeKelurahan) {
            setKodeposDisplay(targetPrefix, null, null, null);
            if (targetPrefix === 'domisili') $('#postcode').val('');
            if (typeof callback === 'function') callback();
            return;
        }
        $.ajax({
            url: '<?= base_url('location/getHierarchy') ?>/' + kodeKelurahan,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                setKodeposDisplay(targetPrefix, kodeKelurahan, data.kodepos, data.kelurahan.nama);
                if (targetPrefix === 'domisili') {
                    $('#postcode').val(data.kodepos || '');
                }
                if (typeof callback === 'function') callback(data);
            },
            error: function() {
                console.error('Error copying kodepos for:', kodeKelurahan);
                if (typeof callback === 'function') callback();
            }
        });
    }

    function initKodeposSearch(prefix) {
        var $el = $('#kodepos-' + prefix);
        if ($el.length === 0) return;

        if ($el.hasClass('select2-hidden-accessible')) {
            try {
                $el.select2('destroy');
                $el.removeClass('select2-hidden-accessible');
                $el.removeData('select2');
                $el.next('.select2-container').remove();
            } catch (e) {}
        }

        var lastRequest = null;

        $el.select2({
            dropdownParent: $('#modalform'),
            placeholder: 'Ketik kode pos / nama kelurahan...',
            minimumInputLength: 3,
            allowClear: true,
            ajax: {
                url: '<?= base_url('location/searchKodepos') ?>',
                dataType: 'json',
                delay: 500,
                data: function(params) {
                    return {
                        term: params.term
                    };
                },
                processResults: function(data) {
                    return data;
                },
                transport: function(params, success, failure) {
                    if (lastRequest && typeof lastRequest.abort === 'function') {
                        lastRequest.abort();
                    }
                    lastRequest = $.ajax(params);
                    lastRequest.then(success);
                    lastRequest.fail(function(jqXHR) {
                        if (jqXHR.statusText !== 'abort') {
                            failure(jqXHR);
                        }
                    });
                    return lastRequest;
                },
                cache: true
            }
        });

        $el.off('select2:select').on('select2:select', function(e) {
            var data = e.params.data;
            var kodeWilayah = data.id;
            var text = data.text;
            var kodePos = text.split(' - ')[0] || '';

            $('#kodepos-' + prefix + '-value').val(kodePos);
            if (prefix === 'domisili') {
                $('#postcode').val(kodePos);
            }

            fetchAndFillByKodepos(prefix, kodeWilayah);
        });

        $el.off('select2:clear').on('select2:clear', function() {
            $('#kodepos-' + prefix + '-value').val('');
            if (prefix === 'domisili') {
                $('#postcode').val('');
            }
        });
    }
</script>

<script>
    function patient() {
        $.ajax({
            method: "get",
            url: "<?= site_url('patient/fetchAll'); ?>",
            success: function(data) {
                $('#viewdata').html(data);
            }
        });
    }

    $(document).ready(function() {

        patient();

        initKodeposSearch('umum');
        initKodeposSearch('domisili');
        initKodeposSearch('keluarga');

        $('#job_title_cd').on("change", function(e) {
            var val = $(this).val();
            if (val === '89') {
                $(".job_lain_input").css("display", "block");
            } else {
                $(".job_lain_input").css("display", "none");
            }
        });

        $('#family_relation').on("change", function(e) {
            var val = $(this).val();
            if (val === 'lainnya') {
                $(".family_relation_lain_input").css("display", "block");
            } else {
                $(".family_relation_lain_input").css("display", "none");
            }
        });

        $('#source_info').on("change", function(e) {
            var val = $(this).val();
            if (val === 'lainnya') {
                $(".source_info_lain_input").css("display", "block");
            } else {
                $(".source_info_lain_input").css("display", "none");
            }
        });

        $('.select2').select2();

        // Copy Alamat KTP -> Domisili
        $(document).on('click', '#addr_copy', function() {
            $('#addr_domisili').val($('#addr').val());

            var provinsiVal = $('#provinsi-umum').val();
            var kotaVal = $('#kabupaten-umum').val();
            var kecamatanVal = $('#kecamatan-umum').val();
            var kelurahanVal = $('#kelurahan-umum').val();

            fillLocationGroup('domisili', provinsiVal, kotaVal, kecamatanVal, kelurahanVal, function() {
                copyKodeposTo('domisili', kelurahanVal);
            });
        });

        // Copy Alamat Domisili -> Keluarga
        $(document).on('click', '#family_addr_copy', function() {
            $('#family_addr').val($('#addr_domisili').val());

            var provinsiVal = $('#provinsi-domisili').val();
            var kotaVal = $('#kabupaten-domisili').val();
            var kecamatanVal = $('#kecamatan-domisili').val();
            var kelurahanVal = $('#kelurahan-domisili').val();

            fillLocationGroup('keluarga', provinsiVal, kotaVal, kecamatanVal, kelurahanVal, function() {
                copyKodeposTo('keluarga', kelurahanVal);
            });
        });

        // Add Record
        $(document).on('click', '#add_record', function() {
            $('#form_active').val('add');

            $('#flag_booking').removeAttr('disabled');
            $('#flag_booking').removeAttr('checked');
            $('#patient_no').prop('disabled', true);
            $('#fullname').removeAttr('disabled');
            $('#id_typ').removeAttr('disabled');
            $('#id_no').removeAttr('disabled');
            $('#gender').removeAttr('disabled');
            $('#addr').removeAttr('disabled');
            $('#addr_domisili').removeAttr('disabled');
            $('#mobile_no').removeAttr('disabled');
            $('#birth_dt').removeAttr('disabled');
            $('#register_dt').removeAttr('disabled');
            $('#job_title_cd').removeAttr('disabled');
            $('#religion').removeAttr('disabled');
            $('#city_cd').removeAttr('disabled');
            $('#postcode').removeAttr('disabled');
            $('#phone_no').removeAttr('disabled');
            $('#birthplace').removeAttr('disabled');
            $('#married_sta_id').removeAttr('disabled');
            $('#createdby').removeAttr('disabled');
            $('#education').removeAttr('disabled');
            $('#source_info').removeAttr('disabled');
            $('#source_info_lain').removeAttr('disabled');
            $('#family_name').removeAttr('disabled');
            $('#family_addr').removeAttr('disabled');
            $('#family_handphone').removeAttr('disabled');
            $('#family_relation').removeAttr('disabled');
            $('#job_lain').removeAttr('disabled');
            $('#family_relation_lain').removeAttr('disabled');
            $('#title_cd').removeAttr('disabled');
            $('#country_cd').removeAttr('disabled');
            $('#country').removeAttr('disabled');
            $('#flag_wna').removeAttr('disabled');

            $('.umum, .domisili, .keluarga').removeAttr('disabled');
            $('#kodepos-umum, #kodepos-domisili, #kodepos-keluarga').prop('disabled', false);

            $('#birth_dt').datepicker('update', '');
            $('#data_form')[0].reset();

            // Reset validation
            $('.form-control, .umum, .domisili, .keluarga').removeClass('is-invalid');
            $('.error').html('');

            // Reset values
            $('#patient_no, #fullname, #id_no, #mobile_no, #birth_dt, #register_dt, #postcode, #phone_no, #birthplace, #createdby, #family_name, #family_handphone').val('');
            $('#addr, #addr_domisili, #family_addr, #job_lain, #source_info_lain, #family_relation_lain').text('');
            $('#title_cd, #gender, #id_typ, #job_title_cd, #religion, #city_cd, #married_sta_id, #education, #source_info, #family_relation, #country, #country_cd, #birthplace').val('').trigger('change');

            // Reset kodepos
            $('#kodepos-umum, #kodepos-domisili, #kodepos-keluarga').val(null).trigger('change');
            $('#kodepos-umum-value, #kodepos-domisili-value, #kodepos-keluarga-value').val('');

            // Reset location groups
            fillLocationGroup('umum', '', '', '', '');
            fillLocationGroup('domisili', '', '', '', '');
            fillLocationGroup('keluarga', '', '', '', '');

            // Re-init kodepos
            initKodeposSearch('umum');
            initKodeposSearch('domisili');
            initKodeposSearch('keluarga');

            $('.modal-title').text('Tambah Data');
            $('#action').val('Add');
            $('#submit_button').show().val('Simpan').html('Simpan');
            $('#is_draft').val('0');
            $('#save_draft_button').show();
            // $('#save_draft_button').html('<i class="fas fa-file-alt"></i> Simpan sebagai Draft');
            $('#modalform').modal('show');
        });

        // Submit Form
        $('#data_form').on('submit', function(event) {
            event.preventDefault();

            // Ambil flag_booking dari checkbox
            var flag_booking = $('#flag_booking').is(':checked') ? 1 : 0;

            $.ajax({
                url: "<?= site_url('patient/action'); ?>",
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                beforeSend: function() {
                    $('#submit_button').prop('disabled', true).html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('#submit_button').prop('disabled', false).html($('#submit_button').val());
                },
                success: function(response) {
                    if (response.error) {
                        // Handle validation errors
                        $.each(response.error, function(key, value) {
                            var field = $('#' + key);
                            if (field.length) {
                                field.addClass('is-invalid');
                                $('.error' + key.charAt(0).toUpperCase() + key.slice(1)).html(value);
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                        });
                        patient();
                        $('#modalform').modal('hide');
                    }
                }
            });
        });

        // ============================================================
        // FITUR DRAFT - Tombol Simpan sebagai Draft
        // ============================================================
        $(document).on('click', '#save_draft_button', function() {
            $('#is_draft').val('1');
            $('#data_form').submit();
        });

        // Reset is_draft saat tombol Simpan biasa diklik
        $(document).on('click', '#submit_button', function() {
            $('#is_draft').val('0');
        });

        // ============================================================
        // TOMBOL ADD (INSERT INTO) 
        // ============================================================
        $(document).on('click', '.insertinto', function(e) {
            e.preventDefault();
            var patient_no = $(this).data('patient_no');

            if (!patient_no) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Patient No tidak ditemukan!'
                });
                return;
            }

            Swal.fire({
                title: 'Konfirmasi',
                text: "Apakah Anda yakin ingin memindahkan data booking ini ke data pasien?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Pindahkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Sedang memindahkan data',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: "<?= site_url('patient/insertinto'); ?>",
                        method: "POST",
                        data: {
                            patient_no: patient_no
                        },
                        dataType: "JSON",
                        success: function(response) {
                            if (response.error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.error
                                });
                            } else {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.success
                                });
                                patient();
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan: ' + error
                            });
                        }
                    });
                }
            });
        });

        // ============================================================
        // DELETE
        // ============================================================
        $(document).on('click', '.delete', function() {
            var patient_no = $(this).data('patient_no');
            var flag_booking = $(this).closest('tr').data('is-booking') == '1' ? 1 : 0;

            if (confirm("Are you sure you want to remove it?")) {
                $.ajax({
                    url: "<?= site_url('patient/delete'); ?>",
                    method: "POST",
                    data: {
                        patient_no: patient_no,
                        flag_booking: flag_booking
                    },
                    dataType: "JSON",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                        });
                        patient();
                    }
                });
            }
        });

        // ============================================================
        // VIEW DATA - PERBAIKAN UNTUK DATA BOOKING
        // ============================================================
        $(document).on('click', '.view', function() {
            var patient_no = $(this).data('patient_no');
            var is_booking = $(this).data('is-booking') || 0;

            $.ajax({
                url: "<?= site_url('patient/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    patient_no: patient_no,
                    is_booking: is_booking
                },
                dataType: "JSON",
                success: function(response) {
                    if (response.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.error
                        });
                        return;
                    }

                    // Disable all inputs
                    $('input, select, textarea').attr('disabled', 'disabled');
                    $('#patient_no').prop('disabled', false);
                    $('#kodepos-umum, #kodepos-domisili, #kodepos-keluarga').prop('disabled', true);

                    // Set data
                    $('#patient_no').val(response.data.patient_no);
                    $('#fullname').val(response.data.fullname);
                    $('#id_typ').val(response.data.id_typ).trigger('change');
                    $('#id_no').val(response.data.id_no);
                    $('#gender').val(response.data.gender).trigger('change');
                    $('#addr').text(response.data.addr);
                    $('#addr_domisili').text(response.data.addr_domisili);
                    $('#mobile_no').val(response.data.mobile_no);
                    $('#birth_dt').datepicker('update', response.data.birth_dt);
                    $('#register_dt').val(response.data.register_dt);
                    $('#job_title_cd').val(response.data.job_title_cd).trigger('change');
                    $('#religion').val(response.data.religion).trigger('change');
                    $('#city_cd').val(response.data.city_cd).trigger('change');
                    $('#postcode').val(response.data.postcode);
                    $('#phone_no').val(response.data.phone_no);
                    $('#birthplace').val(response.data.birthplace).trigger('change');
                    $('#married_sta_id').val(response.data.married_sta_id).trigger('change');
                    $('#createdby').val(response.data.createdby);
                    $('#education').val(response.data.education).trigger('change');
                    $('#source_info').val(response.data.source_info).trigger('change');
                    $('#family_name').val(response.data.family_name);
                    $('#family_addr').text(response.data.family_addr);
                    $('#family_handphone').val(response.data.family_handphone);
                    $('#family_relation').val(response.data.family_relation).trigger('change');
                    $('#job_lain').val(response.data.job_lain);
                    $('#family_relation_lain').val(response.data.family_relation_lain);
                    $('#source_info_lain').val(response.data.source_info_lain);
                    $('#title_cd').val(response.data.title_cd).trigger('change');
                    $('#country_cd').val(response.data.country_cd).trigger('change');
                    $('#country').val(response.data.country).trigger('change');
                    $('#flag_wna').prop('checked', response.data.flag_wna == 1);
                    $('#flag_booking').prop('checked', response.data.flag_booking == 1);
                    $('#flag_booking_old').val(response.data.flag_booking);

                    // Fill location groups
                    fillLocationGroup('umum', response.data.provinsi_umum, response.data.kota_umum, response.data.kecamatan_umum, response.data.kelurahan_umum, function() {
                        if (response.data.kelurahan_umum) {
                            copyKodeposTo('umum', response.data.kelurahan_umum);
                        }
                    });
                    fillLocationGroup('domisili', response.data.provinsi_domisili, response.data.kota_domisili, response.data.kecamatan_domisili, response.data.kelurahan_domisili, function() {
                        if (response.data.kelurahan_domisili) {
                            copyKodeposTo('domisili', response.data.kelurahan_domisili);
                        }
                    });
                    fillLocationGroup('keluarga', response.data.provinsi_keluarga, response.data.kota_keluarga, response.data.kecamatan_keluarga, response.data.kelurahan_keluarga, function() {
                        if (response.data.kelurahan_keluarga) {
                            copyKodeposTo('keluarga', response.data.kelurahan_keluarga);
                        }
                    });

                    $('.modal-title').text('Lihat Data');
                    $('#action').val('View');
                    $('#submit_button').hide();
                    $('#save_draft_button').hide();
                    $('#modalform').modal('show');
                    $('#hidden_id').val(patient_no);
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan: ' + error
                    });
                }
            });
        });

        // ============================================================
        // EDIT DATA - PERBAIKAN UNTUK DATA BOOKING
        // ============================================================
        $(document).on('click', '.edit', function() {
            var patient_no = $(this).data('patient_no');
            var is_booking = $(this).data('is-booking') || 0;

            $('#form_active').val('edit');

            // Enable all inputs
            $('input, select, textarea').removeAttr('disabled');
            $('#patient_no').prop('disabled', false);
            $('#kodepos-umum, #kodepos-domisili, #kodepos-keluarga').prop('disabled', false);

            // Re-init kodepos
            initKodeposSearch('umum');
            initKodeposSearch('domisili');
            initKodeposSearch('keluarga');

            $.ajax({
                url: "<?= site_url('patient/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    patient_no: patient_no,
                    is_booking: is_booking
                },
                dataType: "JSON",
                success: function(response) {
                    if (response.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.error
                        });
                        return;
                    }

                    // Set data
                    $('#patient_no').val(response.data.patient_no);
                    $('#fullname').val(response.data.fullname);
                    $('#id_typ').val(response.data.id_typ).trigger('change');
                    $('#id_no').val(response.data.id_no);
                    $('#gender').val(response.data.gender).trigger('change');
                    $('#addr').text(response.data.addr);
                    $('#addr_domisili').text(response.data.addr_domisili);
                    $('#mobile_no').val(response.data.mobile_no);
                    $('#birth_dt').datepicker('update', response.data.birth_dt);
                    $('#register_dt').val(response.data.register_dt);
                    $('#job_title_cd').val(response.data.job_title_cd).trigger('change');
                    $('#religion').val(response.data.religion).trigger('change');
                    $('#city_cd').val(response.data.city_cd).trigger('change');
                    $('#postcode').val(response.data.postcode);
                    $('#phone_no').val(response.data.phone_no);
                    $('#birthplace').val(response.data.birthplace).trigger('change');
                    $('#married_sta_id').val(response.data.married_sta_id).trigger('change');
                    $('#createdby').val(response.data.createdby);
                    $('#education').val(response.data.education).trigger('change');
                    $('#source_info').val(response.data.source_info).trigger('change');
                    $('#family_name').val(response.data.family_name);
                    $('#family_addr').text(response.data.family_addr);
                    $('#family_handphone').val(response.data.family_handphone);
                    $('#family_relation').val(response.data.family_relation).trigger('change');
                    $('#job_lain').val(response.data.job_lain);
                    $('#family_relation_lain').val(response.data.family_relation_lain);
                    $('#source_info_lain').val(response.data.source_info_lain);
                    $('#title_cd').val(response.data.title_cd).trigger('change');
                    $('#country_cd').val(response.data.country_cd).trigger('change');
                    $('#country').val(response.data.country).trigger('change');
                    $('#flag_wna').prop('checked', response.data.flag_wna == 1);
                    $('#flag_booking').prop('checked', response.data.flag_booking == 1);
                    $('#flag_booking_old').val(response.data.flag_booking);

                    // Reset validation
                    $('.form-control, .umum, .domisili, .keluarga').removeClass('is-invalid');
                    $('.error').html('');

                    $('.umum, .domisili, .keluarga').select2({
                        dropdownParent: $('#modalform')
                    });

                    setTimeout(function() {
                        initKodeposSearch('umum');
                        initKodeposSearch('domisili');
                        initKodeposSearch('keluarga');

                        fillLocationGroup('umum', response.data.provinsi_umum, response.data.kota_umum, response.data.kecamatan_umum, response.data.kelurahan_umum, function() {
                            if (response.data.kelurahan_umum) {
                                copyKodeposTo('umum', response.data.kelurahan_umum);
                            }
                        });
                        fillLocationGroup('domisili', response.data.provinsi_domisili, response.data.kota_domisili, response.data.kecamatan_domisili, response.data.kelurahan_domisili, function() {
                            if (response.data.kelurahan_domisili) {
                                copyKodeposTo('domisili', response.data.kelurahan_domisili);
                            }
                        });
                        fillLocationGroup('keluarga', response.data.provinsi_keluarga, response.data.kota_keluarga, response.data.kecamatan_keluarga, response.data.kelurahan_keluarga, function() {
                            if (response.data.kelurahan_keluarga) {
                                copyKodeposTo('keluarga', response.data.kelurahan_keluarga);
                            }
                        });
                    }, 200);

                    $('.modal-title').text('Ubah Data');
                    $('#action').val('Edit');
                    $('#submit_button').show().val('Simpan').html('Simpan');
                    $('#save_draft_button').show();
                    $('#modalform').modal('show');
                    $('#hidden_id').val(patient_no);
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan: ' + error
                    });
                }
            });
        });

        // ============================================================
        // TOMBOL LANJUTKAN DRAFT
        // ============================================================
        $(document).on('click', '.continue-draft', function() {
            var patient_no = $(this).data('patient_no');

            $('#is_draft').val('1');
            $('#form_active').val('edit');

            $.ajax({
                url: "<?= site_url('patient/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    patient_no: patient_no,
                    is_booking: 0
                },
                dataType: "JSON",
                success: function(response) {
                    if (response.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.error
                        });
                        return;
                    }

                    // Isi form dengan data draft
                    $('#patient_no').val(response.data.patient_no);
                    $('#fullname').val(response.data.fullname);
                    $('#id_typ').val(response.data.id_typ).trigger('change');
                    $('#id_no').val(response.data.id_no);
                    $('#gender').val(response.data.gender).trigger('change');
                    $('#addr').text(response.data.addr);
                    $('#addr_domisili').text(response.data.addr_domisili);
                    $('#mobile_no').val(response.data.mobile_no);
                    $('#birth_dt').datepicker('update', response.data.birth_dt);
                    $('#register_dt').val(response.data.register_dt);
                    $('#job_title_cd').val(response.data.job_title_cd).trigger('change');
                    $('#religion').val(response.data.religion).trigger('change');
                    $('#city_cd').val(response.data.city_cd).trigger('change');
                    $('#postcode').val(response.data.postcode);
                    $('#phone_no').val(response.data.phone_no);
                    $('#birthplace').val(response.data.birthplace).trigger('change');
                    $('#married_sta_id').val(response.data.married_sta_id).trigger('change');
                    $('#createdby').val(response.data.createdby);
                    $('#education').val(response.data.education).trigger('change');
                    $('#source_info').val(response.data.source_info).trigger('change');
                    $('#family_name').val(response.data.family_name);
                    $('#family_addr').text(response.data.family_addr);
                    $('#family_handphone').val(response.data.family_handphone);
                    $('#family_relation').val(response.data.family_relation).trigger('change');
                    $('#job_lain').val(response.data.job_lain);
                    $('#family_relation_lain').val(response.data.family_relation_lain);
                    $('#source_info_lain').val(response.data.source_info_lain);
                    $('#title_cd').val(response.data.title_cd).trigger('change');
                    $('#country_cd').val(response.data.country_cd).trigger('change');
                    $('#country').val(response.data.country).trigger('change');
                    $('#flag_wna').prop('checked', response.data.flag_wna == 1);
                    $('#flag_booking').prop('checked', response.data.flag_booking == 1);
                    $('#flag_booking_old').val(response.data.flag_booking);

                    $('.form-control, .umum, .domisili, .keluarga').removeClass('is-invalid');
                    $('.error').html('');

                    fillLocationGroup('umum', response.data.provinsi_umum, response.data.kota_umum, response.data.kecamatan_umum, response.data.kelurahan_umum);
                    fillLocationGroup('domisili', response.data.provinsi_domisili, response.data.kota_domisili, response.data.kecamatan_domisili, response.data.kelurahan_domisili);
                    fillLocationGroup('keluarga', response.data.provinsi_keluarga, response.data.kota_keluarga, response.data.kecamatan_keluarga, response.data.kelurahan_keluarga);

                    $('.modal-title').text('Lanjutkan Draft');
                    $('#action').val('Edit');
                    $('#submit_button').show().val('Simpan').html('<i class="fas fa-save"></i> Simpan');
                    $('#modalform').modal('show');
                    $('#hidden_id').val(patient_no);

                    $('#save_draft_button').html('<i class="fas fa-file-alt"></i> Simpan Draft Lagi');
                }
            });
        });

        // Reset tombol draft saat modal ditutup
        $('#modalform').on('hidden.bs.modal', function() {
            $('#is_draft').val('0');
            $('#save_draft_button').html('<i class="fas fa-file-alt"></i> Simpan sebagai Draft');
        });

        // Flag WNA
        $("#flag_wna").change(function() {
            if (this.checked) {
                $('#country').val('').trigger('change');
            } else {
                $('#country').val('IDN').trigger('change');
            }
        });

        // Cleanup modal
        $('#modalform').on('hidden.bs.modal', function() {
            ['umum', 'domisili', 'keluarga'].forEach(function(prefix) {
                var $el = $('#kodepos-' + prefix);
                if ($el.length && ($el.hasClass('select2-hidden-accessible') || $el.data('select2'))) {
                    try {
                        $el.select2('destroy');
                    } catch (e) {}
                }
            });
        });

    });
</script>

<script>
    $(document).ready(function() {
        // ============= Grup UMUM =============
        $('.umum').select2({
            dropdownParent: $('#modalform')
        });

        $.ajax({
            url: '<?= base_url('location/getProvinsi') ?>',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var options = '<option value="">Select Provinsi</option>';
                $.each(data, function(index, value) {
                    options += '<option value="' + value.kode + '">' + value.nama + '</option>';
                });
                $('#provinsi-umum').html(options);
            }
        });

        $('#provinsi-umum').change(function() {
            if (isProgrammaticLoad.umum) return;
            var provinceId = $(this).val();
            clearOptionsGeneric(['kabupaten-umum', 'kecamatan-umum', 'kelurahan-umum']);
            loadKota(provinceId, 'kabupaten-umum', '');
        });

        $('#kabupaten-umum').change(function() {
            if (isProgrammaticLoad.umum) return;
            var cityId = $(this).val();
            clearOptionsGeneric(['kecamatan-umum', 'kelurahan-umum']);
            loadKecamatan(cityId, 'kecamatan-umum', '');
        });

        $('#kecamatan-umum').change(function() {
            if (isProgrammaticLoad.umum) return;
            var districtId = $(this).val();
            clearOptionsGeneric(['kelurahan-umum']);
            loadKelurahan(districtId, 'kelurahan-umum', '');
        });

        // ============= Grup DOMISILI =============
        $('.domisili').select2({
            dropdownParent: $('#modalform')
        });

        $.ajax({
            url: '<?= base_url('location/getProvinsi') ?>',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var options = '<option value="">Select Provinsi</option>';
                $.each(data, function(index, value) {
                    options += '<option value="' + value.kode + '">' + value.nama + '</option>';
                });
                $('#provinsi-domisili').html(options);
            }
        });

        $('#provinsi-domisili').change(function() {
            if (isProgrammaticLoad.domisili) return;
            var provinceId = $(this).val();
            clearOptionsGeneric(['kabupaten-domisili', 'kecamatan-domisili', 'kelurahan-domisili']);
            loadKota(provinceId, 'kabupaten-domisili', '');
        });

        $('#kabupaten-domisili').change(function() {
            if (isProgrammaticLoad.domisili) return;
            var cityId = $(this).val();
            clearOptionsGeneric(['kecamatan-domisili', 'kelurahan-domisili']);
            loadKecamatan(cityId, 'kecamatan-domisili', '');
        });

        $('#kecamatan-domisili').change(function() {
            if (isProgrammaticLoad.domisili) return;
            var districtId = $(this).val();
            clearOptionsGeneric(['kelurahan-domisili']);
            loadKelurahan(districtId, 'kelurahan-domisili', '');
        });

        // ============= Grup KELUARGA =============
        $('.keluarga').select2({
            dropdownParent: $('#modalform')
        });

        $.ajax({
            url: '<?= base_url('location/getProvinsi') ?>',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var options = '<option value="">Select Provinsi</option>';
                $.each(data, function(index, value) {
                    options += '<option value="' + value.kode + '">' + value.nama + '</option>';
                });
                $('#provinsi-keluarga').html(options);
            }
        });

        $('#provinsi-keluarga').change(function() {
            if (isProgrammaticLoad.keluarga) return;
            var provinceId = $(this).val();
            clearOptionsGeneric(['kabupaten-keluarga', 'kecamatan-keluarga', 'kelurahan-keluarga']);
            loadKota(provinceId, 'kabupaten-keluarga', '');
        });

        $('#kabupaten-keluarga').change(function() {
            if (isProgrammaticLoad.keluarga) return;
            var cityId = $(this).val();
            clearOptionsGeneric(['kecamatan-keluarga', 'kelurahan-keluarga']);
            loadKecamatan(cityId, 'kecamatan-keluarga', '');
        });

        $('#kecamatan-keluarga').change(function() {
            if (isProgrammaticLoad.keluarga) return;
            var districtId = $(this).val();
            clearOptionsGeneric(['kelurahan-keluarga']);
            loadKelurahan(districtId, 'kelurahan-keluarga', '');
        });
    });
</script>

<?= $this->endSection('script'); ?>