<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>
<!-- Toastr -->
<link rel="stylesheet" href="<?= base_url('plugins/toastr/toastr.min.css') ?>">
<!-- Button datatable -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<!-- datepicker styles -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
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

    fieldset.scheduler-border {
        border: 1px groove #ddd !important;
        padding: 0 1.4em 1.4em 1.4em !important;
        margin: 0 0 1.5em 0 !important;
        -webkit-box-shadow: 0px 0px 0px 0px #000;
        box-shadow: 0px 0px 0px 0px #000;
    }

    legend.scheduler-border {
        font-size: 1.2em !important;
        font-weight: bold !important;
        text-align: left !important;
        width: auto;
        padding: 0 10px;
        border-bottom: none;
    }

    /* Style untuk select2 disabled */
    .select2-container--default .select2-selection--single[aria-disabled="true"] {
        background-color: #e9ecef !important;
        opacity: 1;
    }

    .select2-container--default .select2-selection--single[aria-disabled="true"] .select2-selection__arrow {
        display: none;
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
                    <!-- <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Field Value</li>
                    </ol> -->
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

                    <div class="card card-outline card-info">
                        <div class="card-body">
                            <div class="card-title">
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="start_date">Tanggal Mulai</label>
                                    <div class="input-group">
                                        <input type="text" id="start_date" class="form-control">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label for="end_date">Tanggal Akhir</label>
                                    <div class="input-group">
                                        <input type="text" id="end_date" class="form-control">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label for="globalSearch">Pencarian</label>
                                    <input type="text" id="globalSearch" class="form-control" placeholder="Cari kata kunci...">
                                </div>

                                <div class="col-md-2 d-flex align-items-end">
                                    <button id="filterBtn" class="btn btn-primary w-100">Filter</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-outline card-info">
                        <div class="card-body">
                            <div class="card-title">
                            </div>
                            <table id="appointmentTable" class="table table-sm table-bordered table-striped">
                                <thead class="table">
                                    <tr>
                                        <th>No</th>
                                        <th>No. Appointment</th>
                                        <th>Pasien</th>
                                        <th>Tgl Registrasi</th>
                                        <th>Via</th>
                                        <th>Tujuan</th>
                                        <th>Dokter</th>
                                        <th>Tgl Praktek</th>
                                        <th>Jam Mulai</th>
                                        <th>Jam Selesai</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Modal Form Registrasi -->
                    <div class="modal fade" id="modalformregistrasi" tabindex="" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                        <div class="modal-dialog modal-lg" role="document">
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
                                        <div class="mb-3 row">
                                            <label for="pasien" class="col-sm-2 col-form-label">Pasien</label>
                                            <div class="input-group input-group-sm col-sm-4 form-control-sm">
                                                <input type="text" class="form-control" id="patient_no" style="direction: ltr;" name="patient_no" readonly>
                                                <span class="input-group-append">
                                                    <button type="button" class="btn btn-success btn-flat" id="pasien_search"><i class='fas fa-search'></i></button>
                                                </span>
                                            </div>
                                            <label for="tgl_registrasi" class="col-sm-2 col-form-label">Tujuan Registrasi</label>
                                            <div class="col-sm-4">
                                                <?= view('components/dropdown2', [
                                                    'id'          => 'tujuan_registrasi',
                                                    'name'        => 'tujuan_registrasi',
                                                    'apiUrl'      => base_url('/dropdown/server3/2/1/dropdown/subunit/null/null/null/null'),
                                                    'extraKeys'   => [],
                                                    'selected'    => '',
                                                    'errors'      => $errors ?? []
                                                ]) ?>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <?= $cb_type_pasien ?>
                                            <?= $cb_asuransi ?>
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="tgl_registrasi" class="col-sm-2 col-form-label" style="display: none;">Tanggal Registrasi</label>
                                            <div class="col-sm-4" style="display: none;">
                                                <div class="input-group date tgl_registrasi" data-date-format="mm/dd/yyyy">
                                                    <input type="text" class="form-control form-control-sm datepicker" placeholder="mm/dd/yyyy" id="tgl_registrasi" name="tgl_registrasi" autocomplete="off">
                                                    <div class="input-group-append" data-target="#tgl_registrasi" data-toggle="tgl_registrasi">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                                <span class="error invalid-feedback errorTgl_registrasi">
                                                </span>
                                            </div>
                                            <!-- Daftar Via -->

                                            <label class="col-sm-2 col-form-label col-form-label-sm">Registrasi Via</label>
                                            <div class="col-sm-4">
                                                <?= view('components/dropdown2', [
                                                    'id'          => 'registrasi_via',
                                                    'name'        => 'registrasi_via',
                                                    'apiUrl'      => base_url('/dropdown/server5/1/1/tfield-value/null/fieldName/registrasi_via/null/null'),
                                                    'placeholder' => 'Registrasi Via',
                                                    'extraKeys'   => [],
                                                    'selected'    => '',
                                                    'errors'      => $errors ?? []
                                                ]) ?>
                                                <!-- <span class="field-error-msg" id="add_umum_err_ppa">Bidang ini wajib diisi.</span> -->
                                            </div>

                                            <label for="tanggal" class="col-sm-2 col-form-label">Tanggal Praktek</label>
                                            <div class="col-sm-4">
                                                <div class="input-group date tanggal" data-date-format="mm/dd/yyyy">
                                                    <input type="text" class="form-control form-control-sm datepicker" placeholder="mm/dd/yyyy" id="tanggal" name="tanggal" autocomplete="off">
                                                    <div class="input-group-append" data-target="#tanggal" data-toggle="tanggal">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                                <span class="error invalid-feedback errorBirth_dt">
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Field Lainnya - muncul jika registrasi_via = lainnya -->
                                        <div class="mb-3 row" id="lainnya_container" style="display: none;">
                                            <label for="lainnya" class="col-sm-2 col-form-label">Keterangan Lainnya</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control form-control-sm" id="lainnya" name="lainnya" placeholder="Masukkan keterangan lainnya...">
                                                <span class="error invalid-feedback errorLainnya">
                                                </span>
                                            </div>
                                        </div>

                                        <div class="mb-3 row kode_dokter">
                                            <label for="kode_dokter" class="col-sm-2 col-form-label">Dokter</label>
                                            <div class="col-sm-10">
                                                <span id="dropdown_dokter"></span>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="jam_mulai" class="col-sm-2 col-form-label">Jam Mulai</label>
                                            <div class="col-sm-4">
                                                <input type="time" class="form-control form-control-sm" id="jam_mulai" name="jam_mulai">
                                                <span class="error invalid-feedback errorJam_mulai">
                                                </span>
                                            </div>
                                            <label for="jam_selesai" class="col-sm-2 col-form-label">Jam Selesai</label>
                                            <div class="col-sm-4">
                                                <input type="time" class="form-control form-control-sm" id="jam_selesai" name="jam_selesai">
                                                <span class="error invalid-feedback errorJam_selesai">
                                                </span>
                                            </div>
                                        </div>

                                        <input type="hidden" id="cashless" name="cashless" value="0">
                                        <input type="hidden" id="nama_dokter" name="nama_dokter">
                                        <input type="hidden" id="tahun" name="tahun">
                                        <input type="hidden" id="bulan" name="bulan">
                                        <input type="hidden" id="hari" name="hari">

                                        <br>

                                        <div class="mb-3 row">
                                            <div class="col-sm-12">
                                                <fieldset class="scheduler-border">
                                                    <legend class="scheduler-border">Profile Pasien</legend>
                                                    <div class="control-group">
                                                        <div class="mb-3 row">
                                                            <label for="nama" class="col-sm-2 col-form-label">Nama Pasien</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control form-control-sm" id="nama" name="nama" disabled>
                                                                <span class="error invalid-feedback errorNama">
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="gender" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control form-control-sm" id="gender" name="gender" disabled>
                                                                <span class="error invalid-feedback errorGender">
                                                                </span>
                                                            </div>
                                                            <label for="mobile_no" class="col-sm-2 col-form-label">Nomor HP</label>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control form-control-sm" id="mobile_no" name="mobile_no" disabled>
                                                                <span class="error invalid-feedback errorMobile_no">
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="birth_dt" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control form-control-sm" id="birth_dt" name="birth_dt" disabled>
                                                                <span class="error invalid-feedback errorBirth_dt">
                                                                </span>
                                                            </div>
                                                            <span for="usia" class="col-sm-2 col-form-label"><b>Usia</b></span>
                                                            <div class="col-sm-4">
                                                                <p id="usia" class="mt-1"></p>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="addr" class="col-sm-2 col-form-label">Alamat Lengkap</label>
                                                            <div class="col-sm-10">
                                                                <textarea class="form-control form-control-sm" rows="3" placeholder="..." id="addr" name="addr" disabled></textarea>
                                                                <span class="error invalid-feedback errorAddr">
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" id="hidden_id" name="hidden_id" />
                                        <input type="hidden" id="action" name="action" value="Add" />
                                        <button type="submit" name="submit" id="submit_button4" class="btn btn-sm btn-primary" value="Add"></button>
                                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal View -->
                    <div class="modal fade" id="modalformview" tabindex="" role="dialog" aria-labelledby="exampleModalLabelView" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="exampleModalLabelView">Lihat Data</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="post" id="data_formx" autocomplete="off">
                                    <?= csrf_field(); ?>
                                    <div class="modal-body">
                                        <!-- Row 1: Pasien & Tujuan Registrasi -->
                                        <div class="mb-3 row">
                                            <label for="pasien" class="col-sm-2 col-form-label">Pasien</label>
                                            <div class="col-sm-4">
                                                <select class="form-control form-control-sm select2-view" id="patient_no_v" name="patient_no" disabled style="width: 100%;">
                                                    <option value="">Pilih Pasien</option>
                                                </select>
                                            </div>
                                            <label for="tujuan_registrasi_v" class="col-sm-2 col-form-label">Tujuan Registrasi</label>
                                            <div class="col-sm-4">
                                                <?= view('components/dropdown2', [
                                                    'id'          => 'tujuan_registrasi_v',
                                                    'name'        => 'tujuan_registrasi_v',
                                                    'apiUrl'      => base_url('/dropdown/server5/1/1/tfield-value/null/fieldName/tujuan_registrasi/null/null'),
                                                    'placeholder' => 'Tujuan Registrasi',
                                                    'extraKeys'   => [],
                                                    'selected'    => '',
                                                    'errors'      => $errors ?? []
                                                ]) ?>
                                                <!-- <span class="field-error-msg" id="add_umum_err_ppa">Bidang ini wajib diisi.</span> -->
                                            </div>
                                            <!-- <div class="col-sm-4">
                                                <select class="form-control form-control-sm select2-view" id="tujuan_registrasi_v" name="tujuan_registrasi" disabled style="width: 100%;">
                                                    <option value="">Pilih Tujuan</option>
                                                </select>
                                            </div> -->
                                        </div>

                                        <!-- Row 2: Tipe Pasien & Asuransi -->
                                        <div class="mb-3 row">
                                            <label for="Tipe_Pasien" class="col-sm-2 col-form-label">Tipe Pasien</label>
                                            <div class="col-sm-4">
                                                <select class="form-control form-control-sm select2-view" id="Tipe_Pasien_v" name="Tipe_Pasien" disabled style="width: 100%;">
                                                    <option value="">Pilih Tipe Pasien</option>
                                                </select>
                                            </div>
                                            <label for="asr_cd" class="col-sm-2 col-form-label">Asuransi</label>
                                            <div class="col-sm-4">
                                                <select class="form-control form-control-sm select2-view" id="asr_cd_v" name="asr_cd" disabled style="width: 100%;">
                                                    <option value="">Pilih Asuransi</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Row 3: Daftar Via & Tanggal Praktek -->
                                        <div class="mb-3 row">
                                            <label for="registrasi_via_v" class="col-sm-2 col-form-label">Daftar Via</label>
                                            <div class="col-sm-4">
                                                <?= view('components/dropdown2', [
                                                    'id'          => 'registrasi_via_v',
                                                    'name'        => 'registrasi_via_v',
                                                    'apiUrl'      => base_url('/dropdown/server5/1/1/tfield-value/null/fieldName/registrasi_via/null/null'),
                                                    'placeholder' => 'Daftar Via',
                                                    'extraKeys'   => [],
                                                    'selected'    => '',
                                                    'errors'      => $errors ?? []
                                                ]) ?>
                                                <!-- <span class="field-error-msg" id="add_umum_err_ppa">Bidang ini wajib diisi.</span> -->
                                            </div>
                                            <label for="tanggal" class="col-sm-2 col-form-label">Tanggal Praktek</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control form-control-sm" id="tanggal_v" name="tanggal" readonly>
                                            </div>
                                        </div>

                                        <!-- Row 4: Keterangan Lainnya (jika ada) -->
                                        <div class="mb-3 row" id="lainnya_view_container">
                                            <label for="lainnya" class="col-sm-2 col-form-label">Keterangan Lainnya</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control form-control-sm" id="lainnya_v" name="lainnya" readonly>
                                            </div>
                                        </div>

                                        <!-- Row 5: Dokter -->
                                        <div class="mb-3 row">
                                            <label for="nama_dokter" class="col-sm-2 col-form-label">Dokter</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control form-control-sm" id="nama_dokter_v" name="nama_dokter" readonly>
                                            </div>
                                        </div>

                                        <!-- Row 6: Jam Mulai & Jam Selesai -->
                                        <div class="mb-3 row">
                                            <label for="jam_mulai" class="col-sm-2 col-form-label">Jam Mulai</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control form-control-sm" id="jam_mulai_v" name="jam_mulai" readonly>
                                            </div>
                                            <label for="jam_selesai" class="col-sm-2 col-form-label">Jam Selesai</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control form-control-sm" id="jam_selesai_v" name="jam_selesai" readonly>
                                            </div>
                                        </div>

                                        <br>

                                        <!-- Profile Pasien -->
                                        <div class="mb-3 row">
                                            <div class="col-sm-12">
                                                <fieldset class="scheduler-border">
                                                    <legend class="scheduler-border">Profile Pasien</legend>
                                                    <div class="control-group">
                                                        <div class="mb-3 row">
                                                            <label for="nama" class="col-sm-2 col-form-label">Nama Pasien</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control form-control-sm" id="nama_v" name="nama" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="gender" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control form-control-sm" id="gender_v" name="gender" disabled>
                                                            </div>
                                                            <label for="mobile_no" class="col-sm-2 col-form-label">Nomor HP</label>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control form-control-sm" id="mobile_no_v" name="mobile_no" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="birth_dt" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control form-control-sm" id="birth_dt_v" name="birth_dt" disabled>
                                                            </div>
                                                            <label for="usia" class="col-sm-2 col-form-label">Usia</label>
                                                            <div class="col-sm-4">
                                                                <p id="usia_v" class="mt-1"></p>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="addr" class="col-sm-2 col-form-label">Alamat Lengkap</label>
                                                            <div class="col-sm-10">
                                                                <textarea class="form-control form-control-sm" rows="3" placeholder="..." id="addr_v" name="addr" disabled></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal List Pasien-->
                    <div class="modal fade" id="modalpasien" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="exampleModalLabel">List Pasien</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="card-title">
                                            </div>
                                            <table id="pasienTable" class="table table-sm table-bordered table-striped">
                                                <thead class="table">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Patient No</th>
                                                        <th>Nama</th>
                                                        <th>Id</th>
                                                        <th>Email</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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

<!-- Datepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<!-- Button datatable -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<!-- set menu name by active-menu -->
<script>
    let table;
    $('#active-menu').html($('p#active-menu').html()); // set top navbar
    $(document).prop("title", $('p#active-menu').html()); // set title
</script>

<script>
    $(".select").select2({
        minimumResultsForSearch: Infinity
    });
    $('#tgl_registrasi').datepicker({
        startDate: new Date(),
        todayHighlight: true,
        autoclose: true,
        dateFormat: 'MM/DD/YYYY'
    }).val();
    $('#tanggal').datepicker({
        startDate: new Date(),
        todayHighlight: true,
        autoclose: true,
        dateFormat: 'MM/DD/YYYY'
    }).val();
    $('#birth_dt').datepicker({
        todayHighlight: true,
        autoclose: true,
        dateFormat: 'MM/DD/YYYY'
    }).val();
</script>

<script>
    function refresh() {
        if (table) {
            table.ajax.reload();
        } else {
            console.warn('DataTable belum terinisialisasi');
        }
    }

    $(document).ready(function() {
        refresh()

        // Tampilkan/sembunyikan field lainnya berdasarkan pilihan registrasi_via
        $(document).on('change', '#registrasi_via', function() {
            var selected = $(this).val();
            if (selected === 'lainnya' || selected === 'Lainnya' || selected === 'LAINNYA') {
                $('#lainnya_container').show();
                $('#lainnya').prop('required', true);
            } else {
                $('#lainnya_container').hide();
                $('#lainnya').prop('required', false);
                $('#lainnya').val('');
            }
        });

        // Saat modal dibuka, reset field lainnya
        $(document).on('shown.bs.modal', '#modalformregistrasi', function() {
            // Reset field lainnya
            $('#lainnya_container').hide();
            $('#lainnya').val('');
            $('#lainnya').prop('required', false);
        });

        $('#Tipe_Pasien').on("change", function(e) {
            var val = $(this).val();
            if (val === 'ASRN') {
                $('#asr_cd').removeAttr('disabled');
            } else {
                $('#asr_cd').val(' ');
                $('#asr_cd').trigger('change');
                $('#asr_cd').attr('disabled', '');
            }
        });

        $(document).on('click', '#add_record', function() {

            var today = new Date();
            $('#tanggal').val(today.toLocaleDateString("en-US"));
            $('#tgl_registrasi').val(today.toLocaleDateString("en-US"));

            //set selected data select2
            $('#patient_no').val(' ');
            $('#patient_no').trigger('change');
            $('#tujuan_registrasi').val(' ');
            $('#tujuan_registrasi').trigger('change');
            $('#Tipe_Pasien').val(' ');
            $('#Tipe_Pasien').trigger('change');
            $('#asr_cd').val(' ');
            $('#asr_cd').trigger('change');
            $('#asr_cd_v').attr('disabled', '');
            $('#birthplace').removeAttr('disabled');

            // Reset field lainnya
            $('#lainnya_container').hide();
            $('#lainnya').val('');
            $('#lainnya').prop('required', false);

            //set datepicker input value
            $('#tgl_registrasi').datepicker('update', today.toLocaleDateString("en-US"));
            $('#tanggal').datepicker('update', today.toLocaleDateString("en-US"));

            //remove error validation message
            $('#patient_no').removeClass('is-invalid');
            $('.errorPatient_no').html('');
            $('#tujuan_registrasi').removeClass('is-invalid');
            $('.errorTujuan_registrasi').html('');
            $('#Tipe_Pasien').removeClass('is-invalid');
            $('.errorTipe_Pasien').html('');
            $('#asr_cd').removeClass('is-invalid');
            $('.errorAsr_cd').html('');

            // clear form profile input
            $('#jam_mulai').val("");
            $('#jam_selesai').val("");
            $('#nama').val("");
            $('#gender').val("");
            $('#birth_dt').val("");
            $('#addr').val("");
            $('#mobile_no').val("");
            $('p#usia').html('<b>0</b> Tahun, <b>0</b> Bulan, <b>0</b> Hari');

            //set modal & form
            $('.modal-title').text('Tambah Data');
            $('#action').val('Registrasi');
            $('#submit_button4').val('Simpan');
            $('#submit_button4').html('Simpan');
            $('#modalformregistrasi').modal('show');

        });

        $(document).on('click', '.hadir', function() {
            var no_appointment = $(this).data('no_appointment');
            if (confirm("Apakah anda yakin merubah status menjadi hadir?")) {
                $.ajax({
                    url: "<?= site_url('tappointment/hadir'); ?>",
                    method: "POST",
                    data: {
                        no_appointment: no_appointment
                    },
                    dataType: "JSON",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                        });
                        refresh();
                        setTimeout(function() {
                            $('#message').html('');
                        }, 5000);
                    }
                })
            }
        });

        $(document).on('click', '.batal', function() {
            var no_appointment = $(this).data('no_appointment');
            if (confirm("Apakah anda yakin merubah status menjadi batal?")) {
                $.ajax({
                    url: "<?= site_url('tappointment/batal'); ?>",
                    method: "POST",
                    data: {
                        no_appointment: no_appointment
                    },
                    dataType: "JSON",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                        });
                        refresh();
                        setTimeout(function() {
                            $('#message').html('');
                        }, 5000);
                    }
                })
            }
        });

        $(document).on('click', '.delete', function() {
            var no_appointment = $(this).data('no_appointment');
            if (confirm("Are you sure you want to remove it?")) {
                $.ajax({
                    url: "<?= site_url('tappointment/delete'); ?>",
                    method: "POST",
                    data: {
                        no_appointment: no_appointment
                    },
                    dataType: "JSON",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                        });
                        refresh();
                        setTimeout(function() {
                            $('#message').html('');
                        }, 5000);
                    }
                })
            }
        });
    });
</script>

<script>
    $(document).ready(function() {

        $(document).on('click', '.view', function() {
            var no_appointment = $(this).data('no_appointment');

            $.ajax({
                url: "<?= site_url('tappointment/fetchAllView'); ?>",
                method: "GET",
                data: {
                    no_appointment: no_appointment
                },
                dataType: "JSON",
                beforeSend: function() {
                    $('#submit_button4').prop('disabled', true);
                    $('#submit_button4').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('#submit_button4').prop('disabled', false);
                    $('#submit_button4').html($('#submit_button4').val());
                },
                success: function(response) {
                    // Data dari response
                    var data = response.data;

                    // 1. Set Pasien (Select2)
                    var patientSelect = $('#patient_no_v');
                    patientSelect.empty();
                    if (data.no_pasien) {
                        patientSelect.append($('<option>', {
                            value: data.no_pasien,
                            text: data.no_pasien + ' - ' + (data.fullname || '')
                        }));
                        patientSelect.val(data.no_pasien).trigger('change');
                    } else {
                        patientSelect.append($('<option>', {
                            value: '',
                            text: 'Pilih Pasien'
                        }));
                        patientSelect.val('').trigger('change');
                    }
                    patientSelect.prop('disabled', true);

                    // 2. Set Tujuan Registrasi (Select2)
                    // var tujuanSelect = $('#tujuan_registrasi_v');
                    // tujuanSelect.empty();
                    // if (data.tujuan_registrasi) {
                    //     tujuanSelect.append($('<option>', {
                    //         value: data.tujuan_registrasi,
                    //         text: data.tujuan_registrasi_desc || data.tujuan_registrasi
                    //     }));
                    //     tujuanSelect.val(data.tujuan_registrasi).trigger('change');
                    // } else {
                    //     tujuanSelect.append($('<option>', {
                    //         value: '',
                    //         text: 'Pilih Tujuan'
                    //     }));
                    //     tujuanSelect.val('').trigger('change');
                    // }
                    // tujuanSelect.prop('disabled', true);


                    if (window.dropdown_tujuan_registrasi_v) {
                        window.dropdown_tujuan_registrasi_v.setValue(data.tujuan_registrasi || '');
                        // window.dropdown_registrasi_via_v.setValue(data.registrasi_via || '');
                        // window.dropdown_tujuan_registrasi_v.disable(); // jika ingin disable
                        $('#tujuan_registrasi_v').prop('disabled', true).trigger('change');
                    }

                    // 3. Set Tipe Pasien (Select2)
                    var tipeSelect = $('#Tipe_Pasien_v');
                    tipeSelect.empty();
                    if (data.Tipe_Pasien) {
                        tipeSelect.append($('<option>', {
                            value: data.Tipe_Pasien,
                            text: data.Tipe_Pasien
                        }));
                        tipeSelect.val(data.Tipe_Pasien).trigger('change');
                    } else {
                        tipeSelect.append($('<option>', {
                            value: '',
                            text: 'Pilih Tipe Pasien'
                        }));
                        tipeSelect.val('').trigger('change');
                    }
                    tipeSelect.prop('disabled', true);

                    // 4. Set Asuransi (Select2)
                    var asuransiSelect = $('#asr_cd_v');
                    asuransiSelect.empty();
                    if (data.asr_cd) {
                        asuransiSelect.append($('<option>', {
                            value: data.asr_cd,
                            text: data.asr_cd
                        }));
                        asuransiSelect.val(data.asr_cd).trigger('change');
                    } else {
                        asuransiSelect.append($('<option>', {
                            value: '',
                            text: 'Pilih Asuransi'
                        }));
                        asuransiSelect.val('').trigger('change');
                    }
                    asuransiSelect.prop('disabled', true);

                    // 5. Set Daftar Via (Select2)
                    // var viaSelect = $('#registrasi_via_v');
                    // viaSelect.empty();
                    // if (data.registrasi_via) {
                    //     viaSelect.append($('<option>', {
                    //         value: data.registrasi_via,
                    //         text: data.registrasi_via
                    //     }));
                    //     viaSelect.val(data.registrasi_via).trigger('change');
                    // } else {
                    //     viaSelect.append($('<option>', {
                    //         value: '',
                    //         text: 'Pilih Via'
                    //     }));
                    //     viaSelect.val('').trigger('change');
                    // }
                    // viaSelect.prop('disabled', true);

                    // Set Daftar Via (Select2)
                    if (window.dropdown_registrasi_via_v) {
                        window.dropdown_registrasi_via_v.setValue(data.registrasi_via || '');
                        // window.dropdown_registrasi_via_v.disable(); // jika ingin disable
                        $('#registrasi_via_v').prop('disabled', true).trigger('change');
                    }

                    // 6. Set Tanggal Praktek
                    $('#tanggal_v').val(convertDateIndo(data.tgl_praktek) || '');

                    // 7. Set Keterangan Lainnya
                    var lainnya = data.lainnya || '';
                    if (lainnya !== '') {
                        $('#lainnya_v').val(lainnya);
                        $('#lainnya_view_container').show();
                    } else {
                        $('#lainnya_v').val('');
                        $('#lainnya_view_container').hide();
                    }

                    // 8. Set Dokter
                    $('#nama_dokter_v').val(data.nama_dokter || '');

                    // 9. Set Jam Mulai & Jam Selesai
                    $('#jam_mulai_v').val(data.jam_mulai || '');
                    $('#jam_selesai_v').val(data.jam_selesai || '');

                    // 10. Profile Pasien
                    $('#nama_v').val(data.fullname || '');
                    $('#gender_v').val(data.gender == 'F' ? 'Perempuan' : 'Laki - Laki');
                    $('#birth_dt_v').val(convertDateIndo(data.birth_dt) || '');
                    $('#addr_v').val(data.addr || '');
                    $('#mobile_no_v').val(data.mobile_no || '');

                    // 11. Usia
                    var tahun = data.tahun || 0;
                    var bulan = data.bulan || 0;
                    var hari = data.hari || 0;
                    $('#usia_v').html('<b>' + tahun + '</b> Tahun, <b>' + bulan + '</b> Bulan, <b>' + hari + '</b> Hari');

                    // Set judul modal
                    $('#exampleModalLabelView').text('Lihat Data');
                    $("#modalformview").modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Gagal mengambil data. Silakan coba lagi.'
                    });
                }
            });
        });

        $('#patient_no.select2').on('change', function() {
            var patient_no = $("#patient_no.select2 option:selected").val();

            if (patient_no !== ' ') {

                $.ajax({
                    url: "<?= site_url('mod/fetchSingleDataPasien'); ?>",
                    method: "GET",
                    data: {
                        patient_no: patient_no
                    },
                    dataType: "JSON",
                    beforeSend: function() {
                        $('#submit_button4').prop('disabled', true);
                        $('#submit_button4').html('<i class="fa fa-spin fa-spinner"></i>');
                    },
                    complete: function() {
                        $('#submit_button4').prop('disabled', false);
                        $('#submit_button4').html($('#submit_button4').val());
                    },
                    success: function(response) {

                        $('#nama').val(response.data.fullname);
                        $('#gender').val((response.data.gender == 'F' ? 'Perempuan' : 'Laki - Laki'));
                        var d_arr = response.data.birth_dt.split("/");
                        var birth_dt = d_arr[1] + '/' + d_arr[0] + '/' + d_arr[2];
                        $('#birth_dt').val(birth_dt);
                        $('#addr').val(response.data.addr);
                        $('#mobile_no').val(response.data.mobile_no);
                        calculate();
                    }
                });
            }
        });

        $('#tujuan_registrasi.select2').on('change', function() {
            var poli = $("#tujuan_registrasi.select2 option:selected").val();

            if (poli !== ' ') {

                $.ajax({
                    url: "<?= site_url('tappointment/getDropdown'); ?>",
                    method: "GET",
                    data: {
                        poli: poli
                    },
                    beforeSend: function() {
                        $('#submit_button4').prop('disabled', true);
                        $('#submit_button4').html('<i class="fa fa-spin fa-spinner"></i>');
                    },
                    complete: function() {
                        $('#submit_button4').prop('disabled', false);
                        $('#submit_button4').html($('#submit_button4').val());
                    },
                    success: function(data) {
                        $('#dropdown_dokter').html(data);
                        $('#kode_dokter').select2();
                    }
                });
                $('.kode_dokter').show();
            } else {
                $('.kode_dokter').hide();
            }
        });

        $('#asr_cd.select2').on('change', function() {
            var asr_cd = $("#asr_cd.select2 option:selected").val();

            if (asr_cd !== ' ') {

                $.ajax({
                    url: "<?= site_url('mod/fetchSingleDataAsuransi'); ?>",
                    method: "GET",
                    data: {
                        asr_cd: asr_cd
                    },
                    dataType: "JSON",
                    beforeSend: function() {
                        $('#submit_button4').prop('disabled', true);
                        $('#submit_button4').html('<i class="fa fa-spin fa-spinner"></i>');
                    },
                    complete: function() {
                        $('#submit_button4').prop('disabled', false);
                        $('#submit_button4').html($('#submit_button4').val());
                    },
                    success: function(response) {
                        $('#cashless').val(response.data.cashless);
                    }
                });
            } else {
                $('#cashless').val(0);
            }
        });

        $(document).on('click', '.pilih', function() {
            var jadwal_id = $(this).data('jadwal_id');
            var kode_dokter = $(this).data('kode_dokter');
            var jam_mulai = $(this).data('jam_mulai');
            var jam_selesai = $(this).data('jam_selesai');
            var nama_dokter = $(this).data('nama_dokter');
            var tanggal = $(this).data('tgl_praktek');
            var tgl_registrasi = new Date(Date.now()).toLocaleString().split(',')[0];

            $('#jadwal_id').val('');
            $('#jam_mulai').val('');
            $('#jam_selesai').val('');
            $('#kode_dokter').val('');
            $('#nama_dokter').val('');
            $('#tanggal').val('');
            $('#tgl_daftar').val('');
            $('#usia').html('');

            $('#data_form')[0].reset();

            $('#jadwal_id').val(jadwal_id);
            $('#jam_mulai').val(jam_mulai);
            $('#jam_selesai').val(jam_selesai);
            $('#kode_dokter').val(kode_dokter);
            $('#nama_dokter').val(nama_dokter);
            $('#tanggal').val(tanggal);
            $('#tgl_registrasi').val(tgl_registrasi);

            $('#modalformregistrasi').modal('show');

            // set modal & form
            $('.modal-title').text('Registrasi ');
            $('#action').val('Registrasi');
            $('#submit_button4').val('Simpan');
            $('#submit_button4').html('Simpan');
            $('#modalformregistrasi').modal('show');

        });

        $('#data_form').on('submit', function(event) {
            $('#asr_cd').removeAttr('disabled');
            if (!$.trim($('#asr_cd').val())) {
                $('#asr_cd').removeAttr('disabled');
                $('#asr_cd').val(' ');
                $('#asr_cd').trigger('change');
            }
            event.preventDefault();
            $.ajax({
                url: "<?= site_url('tappointment/action'); ?>",
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                beforeSend: function() {
                    $('#submit_button4').prop('disabled', true);
                    $('#submit_button4').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('#submit_button4').prop('disabled', false);
                    $('#submit_button4').html('Simpan');
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
                        if (response.error.tujuan_registrasi) {
                            $('#tujuan_registrasi').addClass('is-invalid');
                            $('.errorTujuan_registrasi').html(response.error.tujuan_registrasi);
                        } else {
                            $('#tujuan_registrasi').removeClass('is-invalid');
                            $('.errorTujuan_registrasi').html('');
                        }
                        if (response.error.Tipe_Pasien) {
                            $('#Tipe_Pasien').addClass('is-invalid');
                            $('.errorTipe_Pasien').html(response.error.Tipe_Pasien);
                        } else {
                            $('#Tipe_Pasien').removeClass('is-invalid');
                            $('.errorTipe_Pasien').html('');
                        }
                        if (response.error.asr_cd) {
                            $('#asr_cd').addClass('is-invalid');
                            $('.errorAsr_cd').html(response.error.asr_cd);
                        } else {
                            $('#asr_cd').removeClass('is-invalid');
                            $('.errorAsr_cd').html('');
                        }
                        if (response.error.kode_dokter) {
                            $('#kode_dokter').addClass('is-invalid');
                            $('.errorKode_dokter').html(response.error.kode_dokter);
                        } else {
                            $('#kode_dokter').removeClass('is-invalid');
                            $('.errorKode_dokter').html('');
                        }

                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                        });

                        $('#patient_no').removeClass('is-invalid');
                        $('#patient_no').val('');
                        $('#tujuan_registrasi').removeClass('is-invalid');
                        $('#tujuan_registrasi').val('');
                        $('#Tipe_Pasien').removeClass('is-invalid');
                        $('#Tipe_Pasien').val('');
                        $('#asr_cd').removeClass('is-invalid');
                        $('#asr_cd').val('');
                        $('#kode_dokter').removeClass('is-invalid');
                        $('#kode_dokter').val('');
                        $('#lainnya').val('');

                        refresh();

                        $('#modalformregistrasi').modal('hide');
                    }
                },
            })
        });

        $(document).on('click', '.pilihpasien', function() {
            var patient_no = $(this).data('patient_no');

            if (patient_no !== ' ') {

                $.ajax({
                    url: "<?= site_url('mod/fetchSingleDataPasien'); ?>",
                    method: "GET",
                    data: {
                        patient_no: patient_no
                    },
                    dataType: "JSON",
                    beforeSend: function() {
                        $('#submit_button4').prop('disabled', true);
                        $('#submit_button4').html('<i class="fa fa-spin fa-spinner"></i>');
                    },
                    complete: function() {
                        $('#submit_button4').prop('disabled', false);
                        $('#submit_button4').html($('#submit_button4').val());
                    },
                    success: function(response) {
                        $('#patient_no').val(response.data.patient_no);
                        $('#nama').val(response.data.fullname);
                        $('#gender').val((response.data.gender == 'F' ? 'Perempuan' : 'Laki - Laki'));
                        var d_arr = response.data.birth_dt.split("/");
                        var birth_dt = d_arr[1] + '/' + d_arr[0] + '/' + d_arr[2];
                        $('#birth_dt').val(birth_dt);
                        $('#addr').val(response.data.addr);
                        $('#mobile_no').val(response.data.mobile_no);
                        calculate();
                        $('#modalpasien').modal('hide');
                    }
                });
            }
        });
    });
</script>

<script>
    function convertDateIndo(date) {
        if (!date) return '';
        var d_arr = date.split("/");
        if (d_arr.length < 3) return date;
        var fromDate = d_arr[1] + '/' + d_arr[0] + '/' + d_arr[2];
        dateNew = fromDate.split(' ')[0];
        return dateNew;
    }
</script>

<script>
    $('#tglStart').datepicker({
        todayHighlight: true,
        autoclose: true,
        format: 'dd-mm-yyyy'
    }).val();
    $('#tglEnd').datepicker({
        todayHighlight: true,
        autoclose: true,
        format: 'dd-mm-yyyy'
    }).val();
</script>

<script>
    $(document).ready(function() {

        const today = new Date().toISOString().split('T')[0];

        // Set ke input startDate dan endDate
        $('#startDate').val(today);
        $('#endDate').val(today);

        table = $("#appointmentTable").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            searching: false,

            dom: 'Brtip',
            ajax: {
                url: "<?= base_url('tappointment/datatables') ?>",
                type: "POST",
                contentType: "application/json",
                data: function(d) {
                    d.startDate = $('#start_date').val();
                    d.endDate = $('#end_date').val();
                    d.search = {
                        value: $('#globalSearch').val(),
                        regex: false
                    };

                    return JSON.stringify(d);
                }
            },
            columns: [{
                    data: 'rownum',
                    orderable: false
                },
                {
                    data: 'no_appointment'
                },
                {
                    data: 'fullname'
                },
                {
                    data: 'tgl_registrasi',
                    render: function(data, type, row) {
                        if (!data) return '';
                        return formatDate(data)['dd/mm/yyyy'];
                    }

                },
                {
                    data: 'registrasi_via'
                },
                {
                    data: 'tujuan_registrasi_desc'
                },
                {
                    data: 'nama_dokter'
                },
                {
                    data: 'tgl_praktek',
                    render: function(data, type, row) {
                        if (!data) return '';
                        return formatDate(data)['dd/mm/yyyy'];
                    }

                },
                {
                    data: 'jam_mulai'
                },
                {
                    data: 'jam_selesai'
                },
                {
                    data: 'status',
                    render: function(data, type, row) {
                        let badgeClass = '';
                        let label = '';

                        switch (data) {
                            case 'OP':
                                badgeClass = 'badge-primary';
                                label = 'Open';
                                break;
                            case 'DP':
                                badgeClass = 'badge-secondary';
                                label = 'Deposit';
                                break;
                            case 'PM':
                                badgeClass = 'badge-success';
                                label = 'Pemeriksaan';
                                break;
                            case 'BY':
                                badgeClass = 'badge-danger';
                                label = 'Bayar';
                                break;
                            case 'CL':
                                badgeClass = 'badge-dark';
                                label = 'Closed';
                                break;
                            default:
                                badgeClass = 'badge-warning';
                                label = 'Tidak Aktif';
                        }

                        return `<span class="right badge ${badgeClass}">${label}</span>`;
                    },
                    orderable: false

                },
                {
                    data: 'aksi',
                    orderable: false,
                    className: 'text-right'

                }
            ],
            buttons: [{
                    text: "Tambah",
                    action: function() {
                        // Tambah logic
                    },
                    className: "btn-sm btn-success mb-3",
                    attr: {
                        id: "add_record",
                        style: "background-color:#56b746; <?= session()->get('flag_insert') === 1 ? '' : 'd-none' ?>",
                        name: "add_record"
                    }

                },
                {
                    text: "Registrasi",
                    action: function(e, dt, node, config) {
                        e.preventDefault();
                        window.open("<?= base_url('tregistrasi') ?>", "_blank");
                    },
                    className: "btn-sm btn-success mb-3 <?= session()->get('flag_insert') === 1 ? '' : 'd-none' ?>",
                    attr: {
                        id: "registrasi",
                        style: "background-color:#56b746;"
                    }
                },

                {
                    extend: "excel",
                    text: "Excel",
                    className: "btn-sm mb-3 btn-primary <?= session()->get('flag_export') === 1 ? '' : 'd-none' ?>",
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                },
                {
                    extend: "print",
                    text: "Cetak",
                    className: "btn-sm mb-3 btn-info <?= session()->get('flag_print') === 1 ? '' : 'd-none' ?>",
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                }
            ],
            oLanguage: {
                sSearch: "Cari Data:",
                sInfoEmpty: "Tidak ada data",
                sInfo: "Total: _TOTAL_ data",
                sInfoFiltered: " dari _MAX_ data",
                sZeroRecords: "Data tidak ditemukan",
                oPaginate: {
                    sFirst: "Awal",
                    sPrevious: "Sebelum",
                    sNext: "Berikut",
                    sLast: "Akhir"
                }
            }
        });

        table.buttons().container().appendTo("#appointmentTable_wrapper .col-md-6:eq(0)");

        // Tombol filter
        $('#filterBtn').on('click', function() {
            if (table) {
                table.ajax.reload();
            } else {
                console.warn('DataTable belum terinisialisasi');
            }
        });

        // Pencarian global
        $('#globalSearch').on('keyup', function(e) {
            if (e.key === 'Enter') {
                if (table) {
                    table.search($(this).val()).draw();
                } else {
                    console.warn('DataTable belum terinisialisasi');
                }
            }
        });

    });
</script>

<script>
    $(document).ready(function() {
        const today = new Date();
        const formattedToday = today.toISOString().split('T')[0];

        $('#start_date').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        }).datepicker('setDate', formattedToday);

        $('#end_date').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        }).datepicker('setDate', formattedToday);

        table.ajax.reload();
    });
</script>

<script>
    $(document).ready(function() {
        $(document).on('click', '#pasien_search', function() {
            $('#modalpasien').modal('show');
        });

        $("#pasienTable").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            dom: 'Bfrtip',
            ajax: {
                url: "<?= base_url('tregistrasi/datatables') ?>",
                type: "POST",
                contentType: "application/json",
                data: function(d) {
                    return JSON.stringify(d);
                }
            },
            columnDefs: [{
                    orderable: false,
                    targets: [0, 5]
                },
                {
                    targets: [0, 5],
                    className: 'text-center'
                }
            ],
            columns: [{
                    data: 'rownum',
                    orderable: false
                },
                {
                    data: 'patient_no'
                },
                {
                    data: 'fullname'
                },
                {
                    data: 'id_no'
                },
                {
                    data: 'email'
                },
                {
                    data: 'aksi',
                    orderable: false
                }
            ],
            buttons: [],
            oLanguage: {
                sSearch: "Cari Data:",
                sInfoEmpty: "Tidak ada data",
                sInfo: "Total: _TOTAL_ data",
                sInfoFiltered: " dari _MAX_ data",
                sZeroRecords: "Data tidak ditemukan",
                oPaginate: {
                    sFirst: "Awal",
                    sPrevious: "Sebelum",
                    sNext: "Berikut",
                    sLast: "Akhir"
                }
            }
        }).buttons().container().appendTo("#pasienTable_wrapper .col-md-6:eq(0)");

        $('#pasienTable').on('xhr.dt', function(e, settings, json, xhr) {
            if (json.status === 'session_expired') {
                window.location.href = "<?= base_url('auth/login') ?>";
                alert('Sesi Anda telah berakhir. Silakan login kembali.');
            }
        });
    });
</script>

<?= $this->endSection('script'); ?>