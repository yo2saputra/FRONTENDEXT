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
    /* set width action button crud */
    .btn-fix-w {
        width: 60px;
        padding-top: 0px;
        padding-bottom: 0px;
    }

    /* set font size dropdown select2 */
    select.form-control-sm~.select2-container--default {
        font-size: .720rem !important;
    }

    /* set font size input form */
    .form-control-sm {
        font-size: .720rem !important;
    }

    select.is-invalid#id_typ {
        border-color: #FF0000 !important;
    }
</style>
<?= $this->endSection('style'); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1></h1>
                </div>
                <div class="col-sm-6">
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <!-- left column -->
                <div class="col-md-12">

                    <!-- jquery validation -->
                    <div class="card card-outline card-info">

                        <div class="card-body">

                            <div class="card-title">
                            </div>

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
                                                            <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                                                <div class="col-sm-12">

                                                                    <div class="mb-3 row">
                                                                        <label for="patient_no" class="col-sm-2 col-form-label">Nomor RM</label>
                                                                        <div class="col-sm-2">
                                                                            <input type="text" class="form-control form-control-sm" id="patient_no" name="patient_no" autofocus autocomplete="off">
                                                                            <span class="error invalid-feedback errorPatient_no">
                                                                            </span>
                                                                        </div>
                                                                        <label for="flag_booking" class="col-sm-1 col-form-label"></label>
                                                                        <div class="col-sm-1">
                                                                            <div class="icheck-primary d-inline">
                                                                                <input type="checkbox" id="flag_booking" name="flag_booking">
                                                                                <label for="flag_booking">Booking</label>
                                                                            </div>
                                                                            <span class="error invalid-feedback errorFlag_booking">
                                                                            </span>
                                                                        </div>
                                                                        <label for="flag_wna" class="col-sm-1 col-form-label"></label>
                                                                        <div class="col-sm-1">
                                                                            <div class="icheck-primary d-inline">
                                                                                <input type="checkbox" id="flag_wna" name="flag_wna">
                                                                                <label for="flag_wna">WNA</label>
                                                                            </div>
                                                                            <span class="error invalid-feedback errorFlag_wna">
                                                                            </span>
                                                                        </div>
                                                                        <?= $cb_country ?>
                                                                    </div>
                                                                    <div class="mb-3 row">
                                                                        <?= $cb_country_cd ?>
                                                                        <label for="mobile_no" class="col-sm-1 col-form-label">No. HP</label>
                                                                        <div class="col-sm-3">
                                                                            <input type="text" class="form-control form-control-sm" id="mobile_no" name="mobile_no" placeholder="(0xxxxxxxx)" autocomplete="off">
                                                                            <span class="error invalid-feedback errorMobile_no">
                                                                            </span>
                                                                        </div>
                                                                        <?= $cb_source_info ?>
                                                                    </div>
                                                                    <div class="mb-3 row">
                                                                        <label for="source_info_lain" class="col-sm-2 col-form-label source_info_lain_input"></label>
                                                                        <div class="col-sm-10">
                                                                            <textarea class="form-control form-control-sm source_info_lain_input" rows="3" placeholder="..." id="source_info_lain" name="source_info_lain" autocomplete="off"></textarea>
                                                                            <span class="error invalid-feedback errorSource_info_lain">
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 row">
                                                                        <?= $cb_title_cd ?>
                                                                        <label for="fullname" class="col-sm-1 col-form-label">Nama Pasien</label>
                                                                        <div class="col-sm-3">
                                                                            <input type="text" class="form-control form-control-sm" id="fullname" name="fullname" autocomplete="off">
                                                                            <span class="error invalid-feedback errorFullname">
                                                                            </span>
                                                                        </div>
                                                                        <?= $cb_religion ?>
                                                                    </div>
                                                                    <div class="mb-3 row">
                                                                        <?= $cb_id_typ ?>
                                                                        <label for="id_no" class="col-sm-1 col-form-label">No. Identitas</label>
                                                                        <div class="col-sm-3">
                                                                            <input type="text" class="form-control form-control-sm" id="id_no" name="id_no" autocomplete="off">
                                                                            <span class="error invalid-feedback errorId_no">
                                                                            </span>
                                                                        </div>
                                                                        <?= $cb_job_title_cd ?>
                                                                    </div>
                                                                    <div class="mb-3 row">
                                                                        <div class="col-sm-2 job_lain_input">
                                                                        </div>
                                                                        <div class="col-sm-4 job_lain_input">
                                                                        </div>
                                                                        <label for="job_lain" class="col-sm-2 col-form-label job_lain_input"></label>
                                                                        <div class="col-sm-4">
                                                                            <textarea class="form-control form-control-sm job_lain_input" rows="3" placeholder="..." id="job_lain" name="job_lain" autocomplete="off"></textarea>
                                                                            <span class="error invalid-feedback errorJob_lain">
                                                                            </span>
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
                                                                            <span class="error invalid-feedback errorBirth_dt">
                                                                            </span>
                                                                        </div>
                                                                    </div>

                                                                    <!-- ===== Cari Kode Pos (auto-fill Provinsi s/d Kelurahan) - UMUM ===== -->
                                                                    <div class="mb-3 row">
                                                                        <label for="kodepos-umum" class="col-sm-2 col-form-label">Cari Kode Pos</label>
                                                                        <div class="col-sm-6">
                                                                            <select class="form-control form-control-sm" id="kodepos-umum" name="kodepos-umum" style="width:100%">
                                                                                <option value=""></option>
                                                                            </select>
                                                                            <small class="form-text text-muted">Ketik kode pos atau nama kelurahan, minimal 3 karakter.</small>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3 row">
                                                                        <label for="provinsi-umum" class="col-sm-2 col-form-label">Provinsi</label>
                                                                        <div class="col-sm-3">
                                                                            <select class="form-control form-control-sm umum" id="provinsi-umum" name="provinsi-umum">
                                                                                <option value=" ">Select Provinsi</option>
                                                                            </select>
                                                                        </div>
                                                                        <label for="kabupaten-umum" class="col-sm-1 col-form-label">Kabupaten</label>
                                                                        <div class="col-sm-3">
                                                                            <select class="form-control form-control-sm umum" id="kabupaten-umum" name="kabupaten-umum">
                                                                                <option value=" ">Select Kota</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 row">
                                                                        <label for="kecamatan-umum" class="col-sm-2 col-form-label">Kecamatan</label>
                                                                        <div class="col-sm-3">
                                                                            <select class="form-control form-control-sm umum" id="kecamatan-umum" name="kecamatan-umum">
                                                                                <option value=" ">Select Kecamatan</option>
                                                                            </select>
                                                                        </div>
                                                                        <label for="kelurahan-umum" class="col-sm-1 col-form-label">Kelurahan</label>
                                                                        <div class="col-sm-3">
                                                                            <select class="form-control form-control-sm umum" id="kelurahan-umum" name="kelurahan-umum">
                                                                                <option value=" ">Select Kelurahan</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 row">
                                                                        <label for="addr" class="col-sm-2 col-form-label">Alamat Lengkap KTP</label>
                                                                        <div class="col-sm-10">
                                                                            <textarea class="form-control form-control-sm" rows="2" placeholder="..." id="addr" name="addr" autocomplete="off"></textarea>
                                                                            <span class="error invalid-feedback errorAddr">
                                                                            </span>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                                                                <div class="col-sm-12">

                                                                    <!-- ===== Cari Kode Pos (auto-fill Provinsi s/d Kelurahan) - DOMISILI ===== -->
                                                                    <div class="mb-3 row">
                                                                        <label for="kodepos-domisili" class="col-sm-2 col-form-label">Cari Kode Pos</label>
                                                                        <div class="col-sm-6">
                                                                            <select class="form-control form-control-sm" id="kodepos-domisili" name="kodepos-domisili" style="width:100%">
                                                                                <option value=""></option>
                                                                            </select>
                                                                            <small class="form-text text-muted">Ketik kode pos atau nama kelurahan, minimal 3 karakter.</small>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3 row">
                                                                        <label for="provinsi-domisili" class="col-sm-2 col-form-label">Provinsi</label>
                                                                        <div class="col-sm-4">
                                                                            <select class="form-control form-control-sm domisili" id="provinsi-domisili" name="provinsi-domisili"></select>
                                                                        </div>
                                                                        <label for="kabupaten-domisili" class="col-sm-2 col-form-label">Kabupaten / Kota</label>
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
                                                                        <div class="col-sm-4">
                                                                        </div>
                                                                        <div class="col-sm-8">
                                                                            <button type="button" class="btn btn-xs btn-info float-right" id="addr_copy">Copy Alamat KTP</button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 row">
                                                                        <label for="addr_domisili" class="col-sm-2 col-form-label">Alamat Lengkap Domisili</label>
                                                                        <div class="col-sm-10">
                                                                            <textarea class="form-control form-control-sm" rows="3" placeholder="..." id="addr_domisili" name="addr_domisili" autocomplete="off"></textarea>
                                                                            <span class="error invalid-feedback errorAddr_domisili">
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 row" style="display:none;">
                                                                        <div class="col-sm-6">
                                                                            <input type="text" class="form-control form-control-sm" id="postcode" name="postcode" placeholder="Kode Pos" autocomplete="off">
                                                                            <span class="error invalid-feedback errorPostcode">
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
                                                                <div class="col-sm-12">

                                                                    <!-- ===== Cari Kode Pos (auto-fill Provinsi s/d Kelurahan) - KELUARGA ===== -->
                                                                    <div class="mb-3 row">
                                                                        <label for="kodepos-keluarga" class="col-sm-2 col-form-label">Cari Kode Pos</label>
                                                                        <div class="col-sm-6">
                                                                            <select class="form-control form-control-sm" id="kodepos-keluarga" name="kodepos-keluarga" style="width:100%">
                                                                                <option value=""></option>
                                                                            </select>
                                                                            <small class="form-text text-muted">Ketik kode pos atau nama kelurahan, minimal 3 karakter.</small>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3 row">
                                                                        <label for="provinsi-keluarga" class="col-sm-2 col-form-label">Provinsi</label>
                                                                        <div class="col-sm-4">
                                                                            <select class="form-control form-control-sm keluarga" id="provinsi-keluarga" name="provinsi-keluarga"></select>
                                                                        </div>
                                                                        <label for="kabupaten-keluarga" class="col-sm-2 col-form-label">Kabupaten / Kota</label>
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
                                                                            <span class="error invalid-feedback errorFamily_name">
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 row">
                                                                        <div class="col-sm-2">
                                                                        </div>
                                                                        <div class="col-sm-10">
                                                                            <button type="button" class="btn btn-xs btn-info float-right" id="family_addr_copy">Copy Alamat Domisili</button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 row">
                                                                        <label for="family_addr" class="col-sm-2 col-form-label">Alamat Lengkap</label>
                                                                        <div class="col-sm-10">
                                                                            <textarea class="form-control form-control-sm" rows="3" placeholder="..." id="family_addr" name="family_addr" autocomplete="off"></textarea>
                                                                            <span class="error invalid-feedback errorFamily_addr">
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 row">
                                                                        <label for="family_handphone" class="col-sm-2 col-form-label">No. Hp</label>
                                                                        <div class="col-sm-10">
                                                                            <input type="text" class="form-control form-control-sm" id="family_handphone" name="family_handphone" autocomplete="off">
                                                                            <span class="error invalid-feedback errorFamily_handphone">
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <?= $cb_family_relation ?>
                                                                    <div class="mb-3 row">
                                                                        <label for="family_relation_lain" class="col-sm-2 col-form-label family_relation_lain_input"></label>
                                                                        <div class="col-sm-10">
                                                                            <textarea class="form-control form-control-sm family_relation_lain_input" rows="3" placeholder="..." id="family_relation_lain" name="family_relation_lain" autocomplete="off"></textarea>
                                                                            <span class="error invalid-feedback errorFamily_relation_lain">
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /.card -->
                                                </div>
                                            </div>
                                        </div>



                                        <div class="modal-footer">
                                            <input type="hidden" id="lokasi" />
                                            <input type="hidden" id="flag_booking_old" name="flag_booking_old" />
                                            <input type="hidden" id="hidden_id" name="hidden_id" />
                                            <input type="hidden" id="form_active" />
                                            <input type="hidden" id="action" name="action" value="Add" />
                                            <button type="submit" name="submit" id="submit_button" class="btn btn-sm btn-primary" value="Simpan"></button>
                                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                                        </div>

                                    </form>



                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->

                </div>
                <!--/.col (left) -->
                <!-- right column -->
                <div class="col-md-6">

                </div>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


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

<!-- set menu name by active-menu -->
<script>
    $('#active-menu').html($('p#active-menu').html()); // set top navbar
    $(document).prop("title", $('p#active-menu').html()); // set title
</script>

<script>
    // INISIALISASI SELECT2 GENERIK - EXCLUDE KODEPOS
    $(".select").not('#kodepos-umum, #kodepos-domisili, #kodepos-keluarga').select2({
        minimumResultsForSearch: Infinity
    });

    $('#birth_dt').datepicker({
        minDate: 0,
        todayHighlight: true,
        autoclose: true,
        dateFormat: 'MM/DD/YYYY'
    }).val();
</script>

<!--
    ============================================================
    CASCADING LOCATION DROPDOWN (Provinsi > Kabupaten > Kecamatan > Kelurahan)
    + PENCARIAN KODE POS (auto-fill Provinsi s/d Kelurahan)
    ============================================================

    - Semua pengisian dropdown anak dilakukan lewat CALLBACK (bukan
      setTimeout) sehingga level berikutnya baru dimuat setelah ajax
      level sebelumnya benar-benar selesai.
    - Variabel isProgrammaticLoad mencegah handler .change() milik
      interaksi user ikut jalan (dan menabrak proses pengisian) saat
      value di-set lewat kode (view / edit / copy alamat / pilih kode pos).
    - Value provinsi/kabupaten/kecamatan/kelurahan sekarang berupa kode
      string dari tabel wilayah (mis. '11', '11.01', '11.01.01', '11.01.01.2001'),
      bukan id numerik lagi.
-->
<script>
    // flag: true selama proses pengisian dropdown dilakukan lewat kode
    // (view/edit/copy/kodepos), bukan lewat klik user di dropdown.
    var isProgrammaticLoad = false;

    function clearOptionsGeneric(ids) {
        ids.forEach(function(id) {
            $('#' + id).empty().append('<option value="">Select</option>').trigger('change');
        });
    }

    // set value pada select (provinsi) + refresh tampilan select2,
    // TANPA memicu handler .change() milik interaksi user.
    function setSelectSilently(id, value, callback) {
        isProgrammaticLoad = true;
        $('#' + id).val(value || '').trigger('change');
        isProgrammaticLoad = false;
        if (typeof callback === 'function') callback();
    }

    function loadKota(provinceId, targetId, selectedValue, callback) {
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
                setSelectSilently(targetId, selectedValue, callback);
            }
        });
    }

    function loadKecamatan(cityId, targetId, selectedValue, callback) {
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
                setSelectSilently(targetId, selectedValue, callback);
            }
        });
    }

    function loadKelurahan(districtId, targetId, selectedValue, callback) {
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
                setSelectSilently(targetId, selectedValue, callback);
            }
        });
    }

    // Mengisi 1 grup dropdown lokasi (umum / domisili / keluarga) secara
    // berantai: provinsi -> kabupaten -> kecamatan -> kelurahan.
    // prefix contoh: 'umum', 'domisili', 'keluarga'
    function fillLocationGroup(prefix, provinsiVal, kotaVal, kecamatanVal, kelurahanVal, callback) {
        setSelectSilently('provinsi-' + prefix, provinsiVal, function() {
            loadKota(provinsiVal, 'kabupaten-' + prefix, kotaVal, function() {
                loadKecamatan(kotaVal, 'kecamatan-' + prefix, kecamatanVal, function() {
                    loadKelurahan(kecamatanVal, 'kelurahan-' + prefix, kelurahanVal, function() {
                        if (typeof callback === 'function') callback();
                    });
                });
            });
        });
    }

    // ============================================================
    // PENCARIAN KODE POS -> auto-fill Provinsi s/d Kelurahan
    // ============================================================

    // Ambil hirarki lengkap (provinsi..kelurahan) dari 1 kode kelurahan,
    // lalu isi grup dropdown terkait via fillLocationGroup().
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
                        // isi juga input postcode tersembunyi khusus grup domisili
                        if (prefix === 'domisili' && data.kodepos) {
                            $('#postcode').val(data.kodepos);
                        }
                        if (typeof callback === 'function') callback(data);
                    }
                );
            }
        });
    }

    // Menampilkan value+label pada Select2 "Cari Kode Pos" secara terprogram
    // (dipakai saat tombol Copy Alamat diklik), TANPA melalui pencarian ajax.
    // Select2 dengan mode ajax butuh <option> nyata ditambahkan dulu supaya
    // bisa menampilkan label yang benar untuk value yang di-set via .val().
    function setKodeposDisplay(prefix, kodeKelurahan, kodepos, namaKelurahan) {
        var $target = $('#kodepos-' + prefix);
        if ($target.length === 0) return;

        if (!kodeKelurahan || !kodepos) {
            $target.val(null).trigger('change');
            return;
        }

        var text = kodepos + ' - ' + (namaKelurahan || '');
        if ($target.find('option[value="' + kodeKelurahan + '"]').length === 0) {
            var newOption = new Option(text, kodeKelurahan, true, true);
            $target.append(newOption);
        }
        $target.val(kodeKelurahan).trigger('change');
    }

    // Ambil kodepos + nama kelurahan untuk 1 kode kelurahan, lalu tampilkan
    // di field "Cari Kode Pos" grup tujuan. Dipakai oleh tombol copy alamat
    // supaya kode pos ikut ter-copy sesuai kelurahan yang baru disalin.
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
                if (typeof callback === 'function') callback();
            }
        });
    }

    // Inisialisasi 1 field Select2 "Cari Kode Pos" (ajax search-as-you-type)
    // untuk 1 grup (umum/domisili/keluarga).
    function initKodeposSearch(prefix) {
        var $el = $('#kodepos-' + prefix);
        if ($el.length === 0) {
            console.warn('[kodepos] elemen #kodepos-' + prefix + ' TIDAK ditemukan di DOM saat init dijalankan.');
            return;
        }

        // CEK APAKAH SUDAH TERINISIALISASI SEBELUM DESTROY
        var isSelect2Inited = $el.hasClass('select2-hidden-accessible') || $el.data('select2');

        if (isSelect2Inited) {
            try {
                $el.select2('destroy');
                $el.removeClass('select2-hidden-accessible');
                $el.removeData('select2');
                $el.next('.select2-container').remove();
            } catch (e) {
                console.warn('[kodepos] Destroy gagal, mungkin sudah di-destroy:', e);
            }
        }

        $el.select2({
            dropdownParent: $('#modalform'),
            placeholder: 'Ketik kode pos / nama kelurahan...',
            minimumInputLength: 3,
            allowClear: true,
            ajax: {
                url: '<?= base_url('location/searchKodepos') ?>',
                dataType: 'json',
                delay: 300,
                data: function(params) {
                    return {
                        term: params.term
                    };
                },
                processResults: function(data) {
                    console.log('[kodepos] response searchKodepos untuk #kodepos-' + prefix + ':', data);
                    return data;
                },
                transport: function(params, success, failure) {
                    var $request = $.ajax(params);
                    $request.then(success);
                    $request.fail(function(jqXHR) {
                        console.error('[kodepos] AJAX searchKodepos GAGAL untuk #kodepos-' + prefix + '. Status: ' + jqXHR.status + ', response: ' + jqXHR.responseText);
                        failure(jqXHR);
                    });
                    return $request;
                },
                cache: true
            }
        });

        // Event handler - PASTIKAN hanya sekali
        $el.off('select2:select').on('select2:select', function(e) {
            console.log('[kodepos] select2:select terpicu pada #kodepos-' + prefix + ', data:', e.params.data);
            var kodeKelurahan = e.params.data.id;
            fetchAndFillByKodepos(prefix, kodeKelurahan);
        });

        console.log('[kodepos] #kodepos-' + prefix + ' berhasil di-init (ajax mode), event select2:select ter-bind.');
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

        patient()

        // INISIALISASI KODEPOS SEARCH - HANYA SEKALI DI SINI
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

        //Initialize Select2 Elements
        $('.select2').select2()

        //Copy data provinsi/kabupaten/kecamatan/kelurahan + kode pos + alamat KTP -> Domisili
        $(document).on('click', '#addr_copy', function() {
            $('#addr_domisili').val($('#addr').val());

            var provinsiVal = $('#provinsi-umum').val();
            var kotaVal = $('#kabupaten-umum').val();
            var kecamatanVal = $('#kecamatan-umum').val();
            var kelurahanVal = $('#kelurahan-umum').val();

            fillLocationGroup('domisili', provinsiVal, kotaVal, kecamatanVal, kelurahanVal, function() {
                // kode pos ikut di-copy, mengikuti kelurahan yang baru disalin
                copyKodeposTo('domisili', kelurahanVal);
            });
        });

        //Copy data provinsi/kabupaten/kecamatan/kelurahan + kode pos + alamat Domisili -> Keluarga
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

        // CLEANUP SAAT MODAL DITUTUP
        $('#modalform').on('hidden.bs.modal', function() {
            ['umum', 'domisili', 'keluarga'].forEach(function(prefix) {
                var $el = $('#kodepos-' + prefix);
                if ($el.length) {
                    if ($el.hasClass('select2-hidden-accessible') || $el.data('select2')) {
                        try {
                            $el.select2('destroy');
                            $el.removeClass('select2-hidden-accessible');
                            $el.removeData('select2');
                            $el.next('.select2-container').remove();
                        } catch (e) {
                            // Abaikan error
                        }
                    }
                }
            });
            console.log('Modal cleanup completed');
        });

        $(document).on('click', '#add_record', function() {
            $('#form_active').val('add');
            //set input
            $('#flag_booking').removeAttr('disabled', '');
            $('#flag_booking').removeAttr('checked');
            $('#patient_no').removeAttr('disabled');
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
            $('#patient_no').prop('disabled', true);

            $('#provinsi-umum').removeAttr('disabled');
            $('#kabupaten-umum').removeAttr('disabled');
            $('#kecamatan-umum').removeAttr('disabled');
            $('#kelurahan-umum').removeAttr('disabled');

            $('#provinsi-domisili').removeAttr('disabled');
            $('#kabupaten-domisili').removeAttr('disabled');
            $('#kecamatan-domisili').removeAttr('disabled');
            $('#kelurahan-domisili').removeAttr('disabled');

            $('#provinsi-keluarga').removeAttr('disabled');
            $('#kabupaten-keluarga').removeAttr('disabled');
            $('#kecamatan-keluarga').removeAttr('disabled');
            $('#kelurahan-keluarga').removeAttr('disabled');

            $('#title_cd').removeAttr('disabled');
            $('#country_cd').removeAttr('disabled');
            $('#country').removeAttr('disabled');
            $('#flag_wna').removeAttr('disabled');

            // AKTIFKAN KEMBALI FIELD KODEPOS SAAT ADD
            $('#kodepos-umum').prop('disabled', false);
            $('#kodepos-domisili').prop('disabled', false);
            $('#kodepos-keluarga').prop('disabled', false);

            //set datepicker input value
            $('#birth_dt').datepicker('update', '');

            $('#data_form')[0].reset();

            //set error validation
            $('#patient_no').removeClass('is-invalid');
            $('#fullname').removeClass('is-invalid');
            $('#id_typ').removeClass('is-invalid');
            $("[aria-labelledby=select2-id_typ-container]").css("border-color", "#aaa");
            $('#id_no').removeClass('is-invalid');
            $('#gender').removeClass('is-invalid');
            $('#addr').removeClass('is-invalid');
            $('#addr_domisili').removeClass('is-invalid');
            $('#mobile_no').removeClass('is-invalid');
            $('#birth_dt').removeClass('is-invalid');
            $('#register_dt').removeClass('is-invalid');
            $('#job_title_cd').removeClass('is-invalid');
            $('#religion').removeClass('is-invalid');
            $('#city_cd').removeClass('is-invalid');
            $('#postcode').removeClass('is-invalid');
            $('#phone_no').removeClass('is-invalid');
            $('#birthplace').removeClass('is-invalid');
            $('#married_sta_id').removeClass('is-invalid');
            $('#createdby').removeClass('is-invalid');
            $('#education').removeClass('is-invalid');
            $('#source_info').removeClass('is-invalid');
            $('#source_info_lain').removeClass('is-invalid');
            $('#family_name').removeClass('is-invalid');
            $('#family_addr').removeClass('is-invalid');
            $('#family_handphone').removeClass('is-invalid');
            $('#family_relation').removeClass('is-invalid');
            $('#job_lain').removeClass('is-invalid');
            $('#family_relation_lain').removeClass('is-invalid');
            $('#flag_booking').removeClass('is-invalid');

            $('.errorPatient_no').html('');
            $('.errorFullname').html('');
            $('.errorId_typ').html('');
            $('.errorId_no').html('');
            $('.errorGender').html('');
            $('.errorAddr').html('');
            $('.errorAddr_domisili').html('');
            $('.errorJob_lain').html('');
            $('.errorMobile_no').html('');
            $('.errorBirth_dt').html('');
            $('.errorRegister_dt').html('');
            $('.errorJob_title_cd').html('');
            $('.errorReligion').html('');
            $('.errorCity_cd').html('');
            $('.errorPostcode').html('');
            $('.errorPhone_no').html('');
            $('.errorBirthplace').html('');
            $('.errorMarried_sta_id').html('');
            $('.errorCreatedby').html('');
            $('.errorEducation').html('');
            $('.errorSource_info').html('');
            $('.errorFamily_name').html('');
            $('.errorFamily_addr').html('');
            $('.errorFamily_handphone').html('');
            $('.errorFamily_relation').html('');

            //clear input value
            $('#patient_no').val('');
            $('#fullname').val('');
            $('#id_no').val('');
            $('#addr').text('');
            $('#addr_domisili').text('');
            $('#mobile_no').val('');
            $('#birth_dt').val('');
            $('#register_dt').val('');
            $('#postcode').val('');
            $('#phone_no').val('');
            $('#birthplace').val('');
            $('#createdby').val('');
            $('#family_name').val('');
            $('#family_addr').text('');
            $('#family_handphone').val('');
            $('#job_lain').text('');
            $('#source_info_lain').text('');
            $('#family_relation_lain').text('');

            $('#title_cd').val(' ');

            // reset field "Cari Kode Pos" ke kosong
            $('#kodepos-umum').val(null).trigger('change');
            $('#kodepos-domisili').val(null).trigger('change');
            $('#kodepos-keluarga').val(null).trigger('change');

            //set selected data select2
            $('#gender').val(' ').trigger('change');
            $('#id_typ').val(' ').trigger('change');
            $('#job_title_cd').val(' ').trigger('change');
            $('#religion').val(' ').trigger('change');
            $('#city_cd').val(' ').trigger('change');
            $('#married_sta_id').val(' ').trigger('change');
            $('#education').val(' ').trigger('change');
            $('#source_info').val(' ').trigger('change');
            $('#family_relation').val(' ').trigger('change');
            $('#country').val('IDN').trigger('change');
            $('#country_cd').val('62').trigger('change');
            $('#birthplace').val(' ').trigger('change');

            // reset ketiga grup lokasi ke kosong
            fillLocationGroup('umum', '', '', '', '');
            fillLocationGroup('domisili', '', '', '', '');
            fillLocationGroup('keluarga', '', '', '', '');

            // RE-INIT KODEPOS SEARCH AGAR SELECT2 BEKERJA KEMBALI
            initKodeposSearch('umum');
            initKodeposSearch('domisili');
            initKodeposSearch('keluarga');

            //set modal & form
            $('.modal-title').text('Tambah Data');
            $('#action').val('Add');
            $('#submit_button').show();
            $('#submit_button').val('Simpan');
            $('#submit_button').html('Simpan');
            $('#modalform').modal('show');
        });

        $('#data_form').on('submit', function(event) {
            event.preventDefault();

            $.ajax({
                url: "<?= site_url('patient/action'); ?>",
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                beforeSend: function() {
                    $('#submit_button').prop('disabled', true);
                    $('#submit_button').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('#submit_button').prop('disabled', false);
                    $('#submit_button').html($('#submit_button').val());
                },
                success: function(response) {

                    if (response.error) {
                        if (response.error.patient_no) {
                            $('#patient_no').addClass('is-invalid');
                            $('.errorPatient_no').html(response.error.patient_no);
                        } else {
                            $('#patient_no').removeClass('is-invalid');
                            $('.errorPatient_no').html('');
                        }
                        if (response.error.fullname) {
                            $('#fullname').addClass('is-invalid');
                            $('.errorFullname').html(response.error.fullname);
                        } else {
                            $('#fullname').removeClass('is-invalid');
                            $('.errorFullname').html('');
                        }
                        if (response.error.id_typ) {
                            $('#id_typ').addClass('is-invalid');
                            $('.errorId_typ').html(response.error.id_typ);
                        } else {
                            $('#id_typ').removeClass('is-invalid');
                            $('.errorId_typ').html('');
                        }
                        if (response.error.id_no) {
                            $('#id_no').addClass('is-invalid');
                            $('.errorId_no').html(response.error.id_no);
                        } else {
                            $('#id_no').removeClass('is-invalid');
                            $('.errorId_no').html('');
                        }
                        if (response.error.gender) {
                            $('#gender').addClass('is-invalid');
                            $('.errorGender').html(response.error.gender);
                        } else {
                            $('#gender').removeClass('is-invalid');
                            $('.errorGender').html('');
                        }
                        if (response.error.addr) {
                            $('#addr').addClass('is-invalid');
                            $('.errorAddr').html(response.error.addr);
                        } else {
                            $('#addr').removeClass('is-invalid');
                            $('.errorAddr').html('');
                        }
                        if (response.error.addr_domisili) {
                            $('#addr_domisili').addClass('is-invalid');
                            $('.errorAddr_domisili').html(response.error.addr_domisili);
                        } else {
                            $('#addr_domisili').removeClass('is-invalid');
                            $('.errorAddr_domisili').html('');
                        }
                        if (response.error.job_lain) {
                            $('#job_lain').addClass('is-invalid');
                            $('.errorJob_lain').html(response.error.job_lain);
                        } else {
                            $('#job_lain').removeClass('is-invalid');
                            $('.errorJob_lain').html('');
                        }
                        if (response.error.family_relation_lain) {
                            $('#family_relation_lain').addClass('is-invalid');
                            $('.errorFamily_relation_lain').html(response.error.family_relation_lain);
                        } else {
                            $('#family_relation_lain').removeClass('is-invalid');
                            $('.errorFamily_relation_lain').html('');
                        }
                        if (response.error.mobile_no) {
                            $('#mobile_no').addClass('is-invalid');
                            $('.errorMobile_no').html(response.error.mobile_no);
                        } else {
                            $('#mobile_no').removeClass('is-invalid');
                            $('.errorMobile_no').html('');
                        }
                        if (response.error.birth_dt) {
                            $('#birth_dt').addClass('is-invalid');
                            $('.errorBirth_dt').html(response.error.birth_dt);
                        } else {
                            $('#birth_dt').removeClass('is-invalid');
                            $('.errorBirth_dt').html('');
                        }
                        if (response.error.register_dt) {
                            $('#register_dt').addClass('is-invalid');
                            $('.errorRegister_dt').html(response.error.register_dt);
                        } else {
                            $('#register_dt').removeClass('is-invalid');
                            $('.errorRegister_dt').html('');
                        }
                        if (response.error.job_title_cd) {
                            $('#job_title_cd').addClass('is-invalid');
                            $('.errorJob_title_cd').html(response.error.job_title_cd);
                        } else {
                            $('#job_title_cd').removeClass('is-invalid');
                            $('.errorJob_title_cd').html('');
                        }
                        if (response.error.religion) {
                            $('#religion').addClass('is-invalid');
                            $('.errorReligion').html(response.error.religion);
                        } else {
                            $('#religion').removeClass('is-invalid');
                            $('.errorReligion').html('');
                        }
                        if (response.error.city_cd) {
                            $('#city_cd').addClass('is-invalid');
                            $('.errorCity_cd').html(response.error.city_cd);
                        } else {
                            $('#city_cd').removeClass('is-invalid');
                            $('.errorCity_cd').html('');
                        }
                        if (response.error.postcode) {
                            $('#postcode').addClass('is-invalid');
                            $('.errorPostcode').html(response.error.postcode);
                        } else {
                            $('#postcode').removeClass('is-invalid');
                            $('.errorPostcode').html('');
                        }
                        if (response.error.phone_no) {
                            $('#phone_no').addClass('is-invalid');
                            $('.errorPhone_no').html(response.error.phone_no);
                        } else {
                            $('#phone_no').removeClass('is-invalid');
                            $('.errorPhone_no').html('');
                        }
                        if (response.error.birthplace) {
                            $('#birthplace').addClass('is-invalid');
                            $('.errorBirthplace').html(response.error.birthplace);
                        } else {
                            $('#birthplace').removeClass('is-invalid');
                            $('.errorBirthplace').html('');
                        }
                        if (response.error.married_sta_id) {
                            $('#married_sta_id').addClass('is-invalid');
                            $('.errorMarried_sta_id').html(response.error.married_sta_id);
                        } else {
                            $('#married_sta_id').removeClass('is-invalid');
                            $('.errorMarried_sta_id').html('');
                        }
                        if (response.error.createdby) {
                            $('#createdby').addClass('is-invalid');
                            $('.errorCreatedby').html(response.error.createdby);
                        } else {
                            $('#createdby').removeClass('is-invalid');
                            $('.errorCreatedby').html('');
                        }
                        if (response.error.education) {
                            $('#education').addClass('is-invalid');
                            $('.errorEducation').html(response.error.education);
                        } else {
                            $('#education').removeClass('is-invalid');
                            $('.errorEducation').html('');
                        }
                        if (response.error.source_info) {
                            $('#source_info').addClass('is-invalid');
                            $('.errorSource_info').html(response.error.source_info);
                        } else {
                            $('#source_info').removeClass('is-invalid');
                            $('.errorSource_info').html('');
                        }
                        if (response.error.source_info_lain) {
                            $('#source_info_lain').addClass('is-invalid');
                            $('.errorSource_info_lain').html(response.error.source_info_lain);
                        } else {
                            $('#source_info_lain').removeClass('is-invalid');
                            $('.errorSource_info_lain').html('');
                        }
                        if (response.error.family_name) {
                            $('#family_name').addClass('is-invalid');
                            $('.errorFamily_name').html(response.error.family_name);
                        } else {
                            $('#family_name').removeClass('is-invalid');
                            $('.errorFamily_name').html('');
                        }
                        if (response.error.family_addr) {
                            $('#family_addr').addClass('is-invalid');
                            $('.errorFamily_addr').html(response.error.family_addr);
                        } else {
                            $('#family_addr').removeClass('is-invalid');
                            $('.errorFamily_addr').html('');
                        }
                        if (response.error.family_handphone) {
                            $('#family_handphone').addClass('is-invalid');
                            $('.errorFamily_handphone').html(response.error.family_handphone);
                        } else {
                            $('#family_handphone').removeClass('is-invalid');
                            $('.errorFamily_handphone').html('');
                        }
                        if (response.error.family_relation) {
                            $('#family_relation').addClass('is-invalid');
                            $('.errorFamily_relation').html(response.error.family_relation);
                        } else {
                            $('#family_relation').removeClass('is-invalid');
                            $('.errorFamily_relation').html('');
                        }
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                        });

                        //set error validation
                        $('#patient_no').removeClass('is-invalid');
                        $('#fullname').removeClass('is-invalid');
                        $('#id_typ').removeClass('is-invalid');
                        $('#id_no').removeClass('is-invalid');
                        $('#gender').removeClass('is-invalid');
                        $('#addr').removeClass('is-invalid');
                        $('#mobile_no').removeClass('is-invalid');
                        $('#birth_dt').removeClass('is-invalid');
                        $('#register_dt').removeClass('is-invalid');
                        $('#job_title_cd').removeClass('is-invalid');
                        $('#religion').removeClass('is-invalid');
                        $('#city_cd').removeClass('is-invalid');
                        $('#postcode').removeClass('is-invalid');
                        $('#phone_no').removeClass('is-invalid');
                        $('#birthplace').removeClass('is-invalid');
                        $('#married_sta_id').removeClass('is-invalid');
                        $('#createdby').removeClass('is-invalid');
                        $('#education').removeClass('is-invalid');
                        $('#source_info').removeClass('is-invalid');
                        $('#family_name').removeClass('is-invalid');
                        $('#family_addr').removeClass('is-invalid');
                        $('#family_handphone').removeClass('is-invalid');
                        $('#family_relation').removeClass('is-invalid');

                        $('.errorPatient_no').html('');
                        $('.errorFullname').html('');
                        $('.errorId_typ').html('');
                        $('.errorId_no').html('');
                        $('.errorGender').html('');
                        $('.errorAddr').html('');
                        $('.errorAddr_domisili').html('');
                        $('.errorJob_lain').html('');
                        $('.errorFamily_relation_lain').html('');
                        $('.errorMobile_no').html('');
                        $('.errorBirth_dt').html('');
                        $('.errorRegister_dt').html('');
                        $('.errorJob_title_cd').html('');
                        $('.errorReligion').html('');
                        $('.errorCity_cd').html('');
                        $('.errorPostcode').html('');
                        $('.errorPhone_no').html('');
                        $('.errorBirthplace').html('');
                        $('.errorMarried_sta_id').html('');
                        $('.errorCreatedby').html('');
                        $('.errorEducation').html('');
                        $('.errorSource_info').html('');
                        $('.errorFamily_name').html('');
                        $('.errorFamily_addr').html('');
                        $('.errorFamily_handphone').html('');
                        $('.errorFamily_relation').html('');

                        patient();
                        $('#modalform').modal('hide');
                    }
                },
            })
        });

        $(document).on('click', '.view', function() {
            var patient_no = $(this).data('patient_no');

            $.ajax({
                url: "<?= site_url('patient/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    patient_no: patient_no
                },
                dataType: "JSON",
                success: function(response) {

                    $('#flag_booking').attr('disabled', '');
                    $('#patient_no').attr('disabled', '');
                    $('#fullname').attr('disabled', '');
                    $('#id_typ').attr('disabled', '');
                    $('#id_no').attr('disabled', '');
                    $('#gender').attr('disabled', '');
                    $('#addr').attr('disabled', '');
                    $('#addr_domisili').attr('disabled', '');
                    $('#mobile_no').attr('disabled', '');
                    $('#birth_dt').attr('disabled', '');
                    $('#register_dt').attr('disabled', '');
                    $('#job_title_cd').attr('disabled', '');
                    $('#religion').attr('disabled', '');
                    $('#city_cd').attr('disabled', '');
                    $('#postcode').attr('disabled', '');
                    $('#phone_no').attr('disabled', '');
                    $('#birthplace').attr('disabled', '');
                    $('#married_sta_id').attr('disabled', '');
                    $('#createdby').attr('disabled', '');
                    $('#education').attr('disabled', '');
                    $('#source_info').attr('disabled', '');
                    $('#family_name').attr('disabled', '');
                    $('#family_addr').attr('disabled', '');
                    $('#family_handphone').attr('disabled', '');
                    $('#family_relation').attr('disabled', '');
                    $('#job_lain').attr('disabled', '');
                    $('#family_relation_lain').attr('disabled', '');
                    $('#patient_no').prop('disabled', false);

                    $('#title_cd').attr('disabled', '');
                    $('#country_cd').attr('disabled', '');
                    $('#country').attr('disabled', '');
                    $('#flag_wna').attr('disabled', '');

                    $('#provinsi-umum').attr('disabled', '');
                    $('#kabupaten-umum').attr('disabled', '');
                    $('#kecamatan-umum').attr('disabled', '');
                    $('#kelurahan-umum').attr('disabled', '');

                    $('#provinsi-domisili').attr('disabled', '');
                    $('#kabupaten-domisili').attr('disabled', '');
                    $('#kecamatan-domisili').attr('disabled', '');
                    $('#kelurahan-domisili').attr('disabled', '');

                    $('#provinsi-keluarga').attr('disabled', '');
                    $('#kabupaten-keluarga').attr('disabled', '');
                    $('#kecamatan-keluarga').attr('disabled', '');
                    $('#kelurahan-keluarga').attr('disabled', '');

                    // field "cari kode pos" ikut dinonaktifkan saat mode Lihat
                    $('#kodepos-umum').prop('disabled', true);
                    $('#kodepos-domisili').prop('disabled', true);
                    $('#kodepos-keluarga').prop('disabled', true);

                    //set input readonly
                    $('#patient_no').attr('readonly', '');

                    //set datepicker input value
                    $('#birth_dt').datepicker('update', response.data.birth_dt);

                    //set data from response record
                    (response.data.flag_booking === 1 ? $('#flag_booking').attr('checked', 'checked') : $('#flag_booking').removeAttr('checked'));
                    (response.data.flag_wna === 1 ? $('#flag_wna').attr('checked', 'checked') : $('#flag_wna').removeAttr('checked'));
                    $('#patient_no').val(response.data.patient_no);
                    $('#fullname').val(response.data.fullname);
                    $('#id_typ').val(response.data.id_typ);
                    $('#id_no').val(response.data.id_no);
                    $('#gender').val(response.data.gender);
                    $('#addr').text(response.data.addr);
                    $('#addr_domisili').text(response.data.addr_domisili);
                    $('#mobile_no').val(response.data.mobile_no);
                    $('#birth_dt').val(response.data.birth_dt);
                    $('#register_dt').val(response.data.register_dt);
                    $('#job_title_cd').val(response.data.job_title_cd);
                    if (response.data.job_title_cd === '89') {
                        $(".job_lain_input").css("display", "block");
                    } else {
                        $(".job_lain_input").css("display", "none");
                    }
                    $('#religion').val(response.data.religion);
                    $('#city_cd').val(response.data.city_cd);
                    $('#postcode').val(response.data.postcode);
                    $('#phone_no').val(response.data.phone_no);
                    $('#birthplace').val(response.data.birthplace);
                    $('#married_sta_id').val(response.data.married_sta_id);
                    $('#createdby').val(response.data.createdby);
                    $('#education').val(response.data.education);
                    $('#source_info').val(response.data.source_info);
                    $('#family_name').val(response.data.family_name);
                    $('#family_addr').text(response.data.family_addr);
                    $('#family_handphone').val(response.data.family_handphone);
                    $('#family_relation').val(response.data.family_relation);
                    if (response.data.family_relation === 'lainnya') {
                        $(".family_relation_lain_input").css("display", "block");
                    } else {
                        $(".family_relation_lain_input").css("display", "none");
                    }
                    if (response.data.source_info === 'lainnya') {
                        $(".source_info_lain_input").css("display", "block");
                    } else {
                        $(".source_info_lain_input").css("display", "none");
                    }
                    $('#job_lain').val(response.data.job_lain);
                    $('#family_relation_lain').val(response.data.family_relation_lain);
                    $('#source_info_lain').val(response.data.source_info_lain);

                    //set error validation
                    $('#patient_no').removeClass('is-invalid');
                    $('#fullname').removeClass('is-invalid');
                    $('#id_typ').removeClass('is-invalid');
                    $('#id_no').removeClass('is-invalid');
                    $('#gender').removeClass('is-invalid');
                    $('#addr').removeClass('is-invalid');
                    $('#addr_lain').removeClass('is-invalid');
                    $('#mobile_no').removeClass('is-invalid');
                    $('#birth_dt').removeClass('is-invalid');
                    $('#register_dt').removeClass('is-invalid');
                    $('#job_title_cd').removeClass('is-invalid');
                    $('#religion').removeClass('is-invalid');
                    $('#city_cd').removeClass('is-invalid');
                    $('#postcode').removeClass('is-invalid');
                    $('#phone_no').removeClass('is-invalid');
                    $('#birthplace').removeClass('is-invalid');
                    $('#married_sta_id').removeClass('is-invalid');
                    $('#createdby').removeClass('is-invalid');
                    $('#education').removeClass('is-invalid');
                    $('#source_info').removeClass('is-invalid');
                    $('#family_name').removeClass('is-invalid');
                    $('#family_addr').removeClass('is-invalid');
                    $('#family_handphone').removeClass('is-invalid');
                    $('#family_relation').removeClass('is-invalid');
                    $('#job_lain').removeClass('is-invalid');
                    $('#family_relation_lain').removeClass('is-invalid');
                    $('#source_info_lain').removeClass('is-invalid');

                    $('.errorPatient_no').html('');
                    $('.errorFullname').html('');
                    $('.errorId_typ').html('');
                    $('.errorId_no').html('');
                    $('.errorGender').html('');
                    $('.errorAddr').html('');
                    $('.errorAddr_domisili').html('');
                    $('.errorMobile_no').html('');
                    $('.errorBirth_dt').html('');
                    $('.errorRegister_dt').html('');
                    $('.errorJob_title_cd').html('');
                    $('.errorReligion').html('');
                    $('.errorCity_cd').html('');
                    $('.errorPostcode').html('');
                    $('.errorPhone_no').html('');
                    $('.errorBirthplace').html('');
                    $('.errorMarried_sta_id').html('');
                    $('.errorCreatedby').html('');
                    $('.errorEducation').html('');
                    $('.errorSource_info').html('');
                    $('.errorFamily_name').html('');
                    $('.errorFamily_addr').html('');
                    $('.errorFamily_handphone').html('');
                    $('.errorFamily_relation').html('');
                    $('.errorJob_lain').html('');
                    $('.errorFamily_relation_lain').html('');
                    $('.errorSource_info_lain').html('');

                    //set selected data select2
                    $('#gender').val(response.data.gender).trigger('change');
                    $('#id_typ').val(response.data.id_typ).trigger('change');
                    $('#job_title_cd').val(response.data.job_title_cd).trigger('change');
                    $('#religion').val(response.data.religion).trigger('change');
                    $('#city_cd').val(response.data.city_cd).trigger('change');
                    $('#married_sta_id').val(response.data.married_sta_id).trigger('change');
                    $('#education').val(response.data.education).trigger('change');
                    $('#source_info').val(response.data.source_info).trigger('change');
                    $('#family_relation').val(response.data.family_relation).trigger('change');

                    $('#birthplace').val(response.data.birthplace).trigger('change');
                    $('#country').val(response.data.country).trigger('change');
                    $('#country_cd').val(response.data.country_cd).trigger('change');
                    $('#title_cd').val(response.data.title_cd).trigger('change');

                    $('.umum').select2({
                        dropdownParent: $('#modalform')
                    });
                    $('.domisili').select2({
                        dropdownParent: $('#modalform')
                    });
                    $('.keluarga').select2({
                        dropdownParent: $('#modalform')
                    });

                    // isi 3 grup dropdown lokasi secara berantai & aman dari race condition
                    fillLocationGroup('umum', response.data.provinsi_umum, response.data.kota_umum, response.data.kecamatan_umum, response.data.kelurahan_umum);
                    fillLocationGroup('domisili', response.data.provinsi_domisili, response.data.kota_domisili, response.data.kecamatan_domisili, response.data.kelurahan_domisili);
                    fillLocationGroup('keluarga', response.data.provinsi_keluarga, response.data.kota_keluarga, response.data.kecamatan_keluarga, response.data.kelurahan_keluarga);

                    //set modal & form
                    $('.modal-title').text('Lihat Data');
                    $('#action').val('View');
                    $('#submit_button').hide();
                    $('#submit_button').val('Lihat');
                    $('#submit_button').html('Lihat');
                    $('#modalform').modal('show');
                    $('#hidden_id').val(patient_no);
                }
            });
            $('#lokasi').val('');
        });

        $(document).on('click', '.edit', function() {
            $('#form_active').val('edit');

            var patient_no = $(this).data('patient_no');
            var flag_booking = $(this).data('flag_booking');

            // RE-INIT KODEPOS SEARCH SEBELUM LOAD DATA EDIT
            initKodeposSearch('umum');
            initKodeposSearch('domisili');
            initKodeposSearch('keluarga');

            $.ajax({
                url: "<?= site_url('patient/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    patient_no: patient_no,
                    flag_booking: flag_booking,
                },
                dataType: "JSON",
                success: function(response) {
                    $('#flag_booking').removeAttr('disabled', '');
                    $('#flag_booking').removeAttr('checked');
                    $('#patient_no').removeAttr('disabled');
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
                    $('#family_name').removeAttr('disabled');
                    $('#family_addr').removeAttr('disabled');
                    $('#family_handphone').removeAttr('disabled');
                    $('#family_relation').removeAttr('disabled');
                    $('#job_lain').removeAttr('disabled');
                    $('#family_relation_lain').removeAttr('disabled');
                    $('#source_info_lain').removeAttr('disabled');
                    $('#patient_no').prop('disabled', false);

                    $('#provinsi-umum').removeAttr('disabled');
                    $('#kabupaten-umum').removeAttr('disabled');
                    $('#kecamatan-umum').removeAttr('disabled');
                    $('#kelurahan-umum').removeAttr('disabled');

                    $('#provinsi-domisili').removeAttr('disabled');
                    $('#kabupaten-domisili').removeAttr('disabled');
                    $('#kecamatan-domisili').removeAttr('disabled');
                    $('#kelurahan-domisili').removeAttr('disabled');

                    $('#provinsi-keluarga').removeAttr('disabled');
                    $('#kabupaten-keluarga').removeAttr('disabled');
                    $('#kecamatan-keluarga').removeAttr('disabled');
                    $('#kelurahan-keluarga').removeAttr('disabled');

                    $('#title_cd').removeAttr('disabled');
                    $('#country_cd').removeAttr('disabled');
                    $('#country').removeAttr('disabled');
                    $('#flag_wna').removeAttr('disabled');

                    // field "cari kode pos" diaktifkan lagi saat mode Edit
                    $('#kodepos-umum').prop('disabled', false);
                    $('#kodepos-domisili').prop('disabled', false);
                    $('#kodepos-keluarga').prop('disabled', false);

                    //set input readonly
                    $('#patient_no').attr('readonly', '');

                    //set datepicker input value
                    $('#birth_dt').datepicker('update', response.data.birth_dt);

                    //set data from response record
                    (response.data.flag_booking === 1 ? $('#flag_booking').attr('checked', 'checked') : $('#flag_booking').removeAttr('checked'));
                    (response.data.flag_booking === 0 ? $('#flag_booking').attr('disabled', '') : $('#flag_booking').removeAttr('disabled'));
                    $('#patient_no').val(response.data.patient_no);
                    $('#fullname').val(response.data.fullname);
                    $('#id_typ').val(response.data.id_typ);
                    $('#id_no').val(response.data.id_no);
                    $('#gender').val(response.data.gender);
                    $('#addr').text(response.data.addr);
                    $('#addr_domisili').text(response.data.addr_domisili);
                    $('#mobile_no').val(response.data.mobile_no);
                    $('#birth_dt').val(response.data.birth_dt);
                    $('#register_dt').val(response.data.register_dt);
                    $('#job_title_cd').val(response.data.job_title_cd);
                    if (response.data.job_title_cd === '89') {
                        $(".job_lain_input").css("display", "block");
                    } else {
                        $(".job_lain_input").css("display", "none");
                    }
                    $('#religion').val(response.data.religion);
                    $('#city_cd').val(response.data.city_cd);
                    $('#postcode').val(response.data.postcode);
                    $('#phone_no').val(response.data.phone_no);
                    $('#birthplace').val(response.data.birthplace);
                    $('#married_sta_id').val(response.data.married_sta_id);
                    $('#createdby').val(response.data.createdby);
                    $('#education').val(response.data.education);
                    $('#source_info').val(response.data.source_info);
                    $('#family_name').val(response.data.family_name);
                    $('#family_addr').text(response.data.family_addr);
                    $('#family_handphone').val(response.data.family_handphone);
                    $('#family_relation').val(response.data.family_relation);
                    if (response.data.family_relation === 'lainnya') {
                        $(".family_relation_lain_input").css("display", "block");
                    } else {
                        $(".family_relation_lain_input").css("display", "none");
                    }
                    if (response.data.source_info === 'lainnya') {
                        $(".source_info_lain_input").css("display", "block");
                    } else {
                        $(".source_info_lain_input").css("display", "none");
                    }
                    $('#job_lain').val(response.data.job_lain);
                    $('#family_relation_lain').val(response.data.family_relation_lain);
                    $('#source_info_lain').val(response.data.source_info_lain);
                    $('#flag_booking_old').val(response.data.flag_booking);

                    //set error validation
                    $('#patient_no').removeClass('is-invalid');
                    $('#fullname').removeClass('is-invalid');
                    $('#id_typ').removeClass('is-invalid');
                    $('#id_no').removeClass('is-invalid');
                    $('#gender').removeClass('is-invalid');
                    $('#addr').removeClass('is-invalid');
                    $('#addr_domisili').removeClass('is-invalid');
                    $('#mobile_no').removeClass('is-invalid');
                    $('#birth_dt').removeClass('is-invalid');
                    $('#register_dt').removeClass('is-invalid');
                    $('#job_title_cd').removeClass('is-invalid');
                    $('#religion').removeClass('is-invalid');
                    $('#city_cd').removeClass('is-invalid');
                    $('#postcode').removeClass('is-invalid');
                    $('#phone_no').removeClass('is-invalid');
                    $('#birthplace').removeClass('is-invalid');
                    $('#married_sta_id').removeClass('is-invalid');
                    $('#createdby').removeClass('is-invalid');
                    $('#education').removeClass('is-invalid');
                    $('#source_info').removeClass('is-invalid');
                    $('#family_name').removeClass('is-invalid');
                    $('#family_addr').removeClass('is-invalid');
                    $('#family_handphone').removeClass('is-invalid');
                    $('#family_relation').removeClass('is-invalid');
                    $('#job_lain').removeClass('is-invalid');
                    $('#family_relation_lain').removeClass('is-invalid');

                    $('.errorPatient_no').html('');
                    $('.errorFullname').html('');
                    $('.errorId_typ').html('');
                    $('.errorId_no').html('');
                    $('.errorGender').html('');
                    $('.errorAddr').html('');
                    $('.errorAddr_lain').html('');
                    $('.errorMobile_no').html('');
                    $('.errorBirth_dt').html('');
                    $('.errorRegister_dt').html('');
                    $('.errorJob_title_cd').html('');
                    $('.errorReligion').html('');
                    $('.errorCity_cd').html('');
                    $('.errorPostcode').html('');
                    $('.errorPhone_no').html('');
                    $('.errorBirthplace').html('');
                    $('.errorMarried_sta_id').html('');
                    $('.errorCreatedby').html('');
                    $('.errorEducation').html('');
                    $('.errorSource_info').html('');
                    $('.errorFamily_name').html('');
                    $('.errorFamily_addr').html('');
                    $('.errorFamily_handphone').html('');
                    $('.errorFamily_relation').html('');
                    $('.errorJob_lain').html('');
                    $('.errorFamily_relation_lain').html('');

                    //set selected data select2
                    $('#gender').val(response.data.gender).trigger('change');
                    $('#id_typ').val(response.data.id_typ).trigger('change');
                    $('#job_title_cd').val(response.data.job_title_cd).trigger('change');
                    $('#religion').val(response.data.religion).trigger('change');
                    $('#city_cd').val(response.data.city_cd).trigger('change');
                    $('#married_sta_id').val(response.data.married_sta_id).trigger('change');
                    $('#education').val(response.data.education).trigger('change');
                    $('#source_info').val(response.data.source_info).trigger('change');
                    $('#family_relation').val(response.data.family_relation).trigger('change');

                    $('#birthplace').val(response.data.birthplace).trigger('change');
                    $('#country').val(response.data.country).trigger('change');
                    $('#country_cd').val(response.data.country_cd).trigger('change');
                    $('#title_cd').val(response.data.title_cd).trigger('change');

                    $('#lokasi').val('');

                    $('.umum').select2({
                        dropdownParent: $('#modalform')
                    });
                    $('.domisili').select2({
                        dropdownParent: $('#modalform')
                    });
                    $('.keluarga').select2({
                        dropdownParent: $('#modalform')
                    });

                    // RE-INIT KODEPOS SEARCH SETELAH MODAL TERBUKA UNTUK MEMASTIKAN SELECT2 BEKERJA
                    setTimeout(function() {
                        initKodeposSearch('umum');
                        initKodeposSearch('domisili');
                        initKodeposSearch('keluarga');

                        // isi 3 grup dropdown lokasi secara berantai & aman dari race condition
                        fillLocationGroup('umum', response.data.provinsi_umum, response.data.kota_umum, response.data.kecamatan_umum, response.data.kelurahan_umum);
                        fillLocationGroup('domisili', response.data.provinsi_domisili, response.data.kota_domisili, response.data.kecamatan_domisili, response.data.kelurahan_domisili);
                        fillLocationGroup('keluarga', response.data.provinsi_keluarga, response.data.kota_keluarga, response.data.kecamatan_keluarga, response.data.kelurahan_keluarga);
                    }, 100);

                    //set modal & form
                    $('.modal-title').text('Ubah Data');
                    $('#action').val('Edit');
                    $('#submit_button').show();
                    $('#submit_button').val('Simpan');
                    $('#submit_button').html('Simpan');
                    $('#modalform').modal('show');
                    $('#hidden_id').val(patient_no);
                }
            })
        });

        $(document).on('click', '.delete', function() {
            var patient_no = $(this).data('patient_no');
            var flag_booking = $(this).data('flag_booking');
            if (confirm("Are you sure you want to remove it?")) {
                $.ajax({
                    url: "<?= site_url('patient/delete'); ?>",
                    method: "POST",
                    data: {
                        patient_no: patient_no,
                        flag_booking: flag_booking,
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
                })
            }
        });

        $(document).on('click', '.usia', function() {
            var patient_no = $(this).data('patient_no');

            $.ajax({
                url: "<?= site_url('patient/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    patient_no: patient_no
                },
                dataType: "JSON",
                success: function(response) {

                    $('#patient_no').prop('disabled', false);

                    //set input
                    $('#patient_no').attr('readonly', '');
                    $('#value').attr('readonly', '');

                    //set data from response record
                    $('#patient_no').val(response.data.patient_no);
                    $('#fullname').val(response.data.fullname);
                    $('#id_no').val(response.data.id_no);
                    $('#gender').val(response.data.gender);
                    $('#addr').val(response.data.addr);
                    $('#mobile_no').val(response.data.mobile_no);
                    $('#birth_dt').val(response.data.birth_dt);
                    $('#register_dt').val(response.data.register_dt);

                    //set error validation
                    $('#patient_no').removeClass('is-invalid');
                    $('#fullname').removeClass('is-invalid');
                    $('#id_no').removeClass('is-invalid');
                    $('#gender').removeClass('is-invalid');
                    $('#addr').removeClass('is-invalid');
                    $('#mobile_no').removeClass('is-invalid');
                    $('#birth_dt').removeClass('is-invalid');
                    $('#register_dt').removeClass('is-invalid');
                    $('.errorPatient_no').html('');
                    $('.errorFullname').html('');
                    $('.errorId_no').html('');
                    $('.errorGender').html('');
                    $('.errorAddr').html('');
                    $('.errorMobile_no').html('');
                    $('.errorBirth_dt').html('');
                    $('.errorRegister_dt').html('');

                    //set selected data
                    $("#gender option[value='" + response.data.gender + "']").attr('selected', 'selected');

                    //set modal & form
                    $('.modal-title').text('Ubah Data');
                    $('#action').val('Edit');
                    $('#submit_button').val('Simpan');
                    $('#submit_button').html('Simpan');
                    $('#modalform').modal('show');
                    $('#hidden_id').val(patient_no);
                }
            })
        });

        $(document).on('click', '.insertinto', function() {
            var patient_no = $(this).data('patient_no');
            if (confirm("Apakah anda yakin mendaftarkan pasient ini?")) {
                $.ajax({
                    url: "<?= site_url('patient/insertinto'); ?>",
                    method: "POST",
                    data: {
                        patient_no: patient_no
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
                })
            }
        });

        $("#flag_wna").change(function() {
            if (this.checked) {
                $('#country').val(' ');
                $('#country').trigger('change');
            } else {
                $('#country').val('IDN');
                $('#country').trigger('change');
            }
        });

    });
</script>

<!--
    ============================================================
    Handler UNTUK INTERAKSI USER (klik/pilih dropdown secara manual).
    Dijaga dengan isProgrammaticLoad supaya TIDAK ikut jalan saat
    pengisian data dilakukan lewat kode (view/edit/copy alamat/kode pos).
    ============================================================
-->
<script>
    $(document).ready(function() {

        $('.umum').select2({
            dropdownParent: $('#modalform')
        });

        // Populate provinces on page load (grup UMUM)
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
            if (isProgrammaticLoad) return;
            var provinceId = $(this).val();
            clearOptionsGeneric(['kabupaten-umum', 'kecamatan-umum', 'kelurahan-umum']);
            loadKota(provinceId, 'kabupaten-umum', '');
        });

        $('#kabupaten-umum').change(function() {
            if (isProgrammaticLoad) return;
            var cityId = $(this).val();
            clearOptionsGeneric(['kecamatan-umum', 'kelurahan-umum']);
            loadKecamatan(cityId, 'kecamatan-umum', '');
        });

        $('#kecamatan-umum').change(function() {
            if (isProgrammaticLoad) return;
            var districtId = $(this).val();
            clearOptionsGeneric(['kelurahan-umum']);
            loadKelurahan(districtId, 'kelurahan-umum', '');
        });

    });
</script>

<script>
    $(document).ready(function() {

        $('.domisili').select2({
            dropdownParent: $('#modalform')
        });

        // Populate provinces on page load (grup DOMISILI)
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
            if (isProgrammaticLoad) return;
            var provinceId = $(this).val();
            clearOptionsGeneric(['kabupaten-domisili', 'kecamatan-domisili', 'kelurahan-domisili']);
            loadKota(provinceId, 'kabupaten-domisili', '');
        });

        $('#kabupaten-domisili').change(function() {
            if (isProgrammaticLoad) return;
            var cityId = $(this).val();
            clearOptionsGeneric(['kecamatan-domisili', 'kelurahan-domisili']);
            loadKecamatan(cityId, 'kecamatan-domisili', '');
        });

        $('#kecamatan-domisili').change(function() {
            if (isProgrammaticLoad) return;
            var districtId = $(this).val();
            clearOptionsGeneric(['kelurahan-domisili']);
            loadKelurahan(districtId, 'kelurahan-domisili', '');
        });

    });
</script>

<script>
    $(document).ready(function() {

        $('.keluarga').select2({
            dropdownParent: $('#modalform')
        });

        // Populate provinces on page load (grup KELUARGA)
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
            if (isProgrammaticLoad) return;
            var provinceId = $(this).val();
            clearOptionsGeneric(['kabupaten-keluarga', 'kecamatan-keluarga', 'kelurahan-keluarga']);
            loadKota(provinceId, 'kabupaten-keluarga', '');
        });

        $('#kabupaten-keluarga').change(function() {
            if (isProgrammaticLoad) return;
            var cityId = $(this).val();
            clearOptionsGeneric(['kecamatan-keluarga', 'kelurahan-keluarga']);
            loadKecamatan(cityId, 'kecamatan-keluarga', '');
        });

        $('#kecamatan-keluarga').change(function() {
            if (isProgrammaticLoad) return;
            var districtId = $(this).val();
            clearOptionsGeneric(['kelurahan-keluarga']);
            loadKelurahan(districtId, 'kelurahan-keluarga', '');
        });

    });
</script>

<!-- HAPUS BLOK INI - SUDAH TIDAK DIPERLUKAN -->
<?php
/*
$(window).on('load', function() {
    setTimeout(function() {
        initKodeposSearch('umum');
        initKodeposSearch('domisili');
        initKodeposSearch('keluarga');
    }, 0);
});
*/
?>

<?= $this->endSection('script'); ?>