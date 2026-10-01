<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>

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

    .control-sidebar {
        color: black;
    }
</style>

<style>
    .content-header-fixed {
        -webkit-transition: -webkit-transform .3s ease-in-out, margin .3s ease-in-out;
        -moz-transition: -moz-transform .3s ease-in-out, margin .3s ease-in-out;
        -o-transition: -o-transform .3s ease-in-out, margin .3s ease-in-out;
        transition: transform .3s ease-in-out, margin .3s ease-in-out;
        position: fixed;
        /* background-color: #ecf0f5; */
        color: #fff;
        /* background-color: #156571; */
        margin-left: 245px;
        left: 0;
        right: 0;
        padding: 5px 5px 5px 5px;
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
            padding-top: 80px;
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

        #melayang {
            padding-top: 180px;
        }

    }
</style>

<style type="text/css">
    .signature-pad {
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 100%;
        height: 547px;

    }
</style>

<style>
    * {
        margin: 0;
        padding: 0;
    }

    .navigate {
        width: 310px;
        height: 50px;
        position: fixed;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        align-items: center;
        justify-content: space-around;
        opacity: .3;
        transition: opacity .5s;
    }

    .navnavigate:hover {
        opacity: 1;
    }

    .clr {
        height: 30px;
        width: 30px;
        background-color: blue;
        border-radius: 50%;
        border: 3px solid rgb(214, 214, 214);
        transition: transform .5s;
    }

    .clr:hover {
        transform: scale(1.2);
    }

    .clr:nth-child(1) {
        background-color: #000;
    }

    .clr:nth-child(2) {
        background-color: #EF626C;
    }

    .clr:nth-child(3) {
        background-color: #fdec03;
    }

    .clr:nth-child(4) {
        background-color: #24d102;
    }

    .clr:nth-child(5) {
        background-color: #fff;
    }

    button {
        border: none;
        outline: none;
        padding: .6em 1em;
        border-radius: 3px;
        background-color: #03bb56;
        color: #fff;
    }

    .save {
        background-color: #0f65d4;
    }

    #canvas {
        border: 1px solid rgba(0, 0, 0, .5);
        touch-action: none;
    }
</style>

<!-- <script type="text/javascript" src="<?= base_url('assets/js/signature-pad.js') ?>"></script> -->

<?= $this->endSection('style'); ?>

<?= $this->section('controlsidebaricon'); ?>

<!-- Control Sidebar Icon -->
<li class="nav-item">
    <a class="nav-link text-md" data-widget="control-sidebar" data-slide="true" href="#" role="button">
        <i class="fas fa-wheelchair"></i>
    </a>
</li>

<?= $this->endSection('controlsidebaricon'); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header-fixed">
        <div class="container-fluid">
            <div class="row">
                <!-- <div class="col-sm-4">
                    <div class="bg-white">
                        <div class="row p-2">
                            <label for="" class="col-sm-2 col-form-label">NO. REGISTRASI</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control form-control-sm" placeholder="" id="birthplace" name="birthplace" autocomplete="off">
                                <span class="error invalid-feedback errorBirthplace">
                                </span>
                            </div>
                            <label for="" class="col-sm-2 col-form-label">NO. RM</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control form-control-sm" placeholder="" id="birthplace" name="birthplace" autocomplete="off">
                                <span class="error invalid-feedback errorBirthplace">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="bg-white">
                        <div class="row p-2">
                            <label for="" class="col-sm-2 col-form-label">NO. REGISTRASI</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control form-control-sm" placeholder="" id="birthplace" name="birthplace" autocomplete="off">
                                <span class="error invalid-feedback errorBirthplace">
                                </span>
                            </div>
                            <label for="" class="col-sm-2 col-form-label">NO. RM</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control form-control-sm" placeholder="" id="birthplace" name="birthplace" autocomplete="off">
                                <span class="error invalid-feedback errorBirthplace">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="bg-white">
                        <div class="row p-2">
                            <label for="" class="col-sm-2 col-form-label">NO. REGISTRASI</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control form-control-sm" placeholder="" id="birthplace" name="birthplace" autocomplete="off">
                                <span class="error invalid-feedback errorBirthplace">
                                </span>
                            </div>
                            <label for="" class="col-sm-2 col-form-label">NO. RM</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control form-control-sm" placeholder="" id="birthplace" name="birthplace" autocomplete="off">
                                <span class="error invalid-feedback errorBirthplace">
                                </span>
                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="col-md-12">
                    <div class="card bg-info">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <dl>
                                        <dt>Nama Pasien</dt>
                                        <dd id="fullname_tm">&nbsp;</dd>
                                    </dl>
                                </div>
                                <div class="col-md-3">
                                    <dl>
                                        <dt>Jenis Kelamin</dt>
                                        <dd id="gender_tm">&nbsp;</dd>
                                    </dl>
                                </div>
                                <div class="col-md-3">
                                    <dl>
                                        <dt>Tanggal Lahir</dt>
                                        <dd id="birth_dt_tm">&nbsp;</dd>
                                    </dl>
                                </div>
                                <div class="col-md-3">
                                    <dl>
                                        <dt>Usia</dt>
                                        <dd id="usia_tm">&nbsp;</dd>
                                    </dl>
                                </div>
                                <!-- <div class="col-md-2">
                                    <dl>
                                        <dt>Nomor HP</dt>
                                        <dd id="mobile_no_tm">&nbsp;</dd>
                                    </dl>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Content Header (Page header) -->
    <!-- <section class="content-header-fixed">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-4">
                    <div class="bg-white">
                        <h3>Kolom1</h3>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="bg-white">
                        <h3>Kolom1</h3>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="bg-white">
                        <h3>Kolom1</h3>
                    </div>
                </div>
            </div>
        </div>-->
    <!-- /.container-fluid -->
    <!--</section> -->

    <!-- Main content -->
    <section class="content" id='melayang'>
        <div class="container-fluid">
            <div class="row contents">

                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12 col-sm-6">
                            <div class="card card-primary card-outline card-outline-tabs">
                                <div class="card-header p-0 border-bottom-0">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Anamnesa</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-one-lama-tab" data-toggle="pill" href="#custom-tabs-one-lama" role="tab" aria-controls="custom-tabs-one-lama" aria-selected="true">Lama</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-one-order-tab" data-toggle="pill" href="#custom-tabs-one-order" role="tab" aria-controls="custom-tabs-one-order" aria-selected="false">Order</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Rekam Medis</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                            <div class="col-sm-12">
                                                <form id="data_form" autocomplete="off">
                                                    <?= csrf_field(); ?>
                                                    <div class="mb-3 row">
                                                        <label for="no_registrasi" class="col-sm-2 col-form-label">NO. REGISTRASI</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control form-control-sm" placeholder="" id="no_registrasi" name="no_registrasi" autocomplete="off" readonly>
                                                            <span class="error invalid-feedback errorNo_registrasi">
                                                            </span>
                                                        </div>
                                                        <label for="patient_no" class="col-sm-2 col-form-label">NO. RM</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control form-control-sm" placeholder="" id="patient_no" name="patient_no" autocomplete="off" readonly>
                                                            <span class="error invalid-feedback errorPatient_no">
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label for="tgl_pemeriksaan" class="col-sm-2 col-form-label">TGL. KUNJUNGAN</label>
                                                        <div class="col-sm-4">
                                                            <div class="input-group date birth_dt" data-date-format="mm/dd/yyyy">
                                                                <input type="text" class="form-control form-control-sm datepicker" placeholder="mm/dd/yyyy" id="tgl_pemeriksaan" name="tgl_pemeriksaan" autocomplete="off" readonly>
                                                                <div class="input-group-append" data-target="#birth_dt" data-toggle="birth_dt">
                                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                </div>
                                                            </div>
                                                            <span class="error invalid-feedback errorBirth_dt">
                                                            </span>
                                                        </div>
                                                        <label for="fullname" class="col-sm-2 col-form-label">NAMA PASIEN</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control form-control-sm" placeholder="" id="fullname" name="fullname" autocomplete="off" readonly>
                                                            <span class="error invalid-feedback errorFullname">
                                                            </span>
                                                        </div>
                                                        <input type="hidden" id="tahun" name="tahun">
                                                        <input type="hidden" id="bulan" name="bulan">
                                                        <input type="hidden" id="hari" name="hari">
                                                    </div>


                                                    <hr>
                                                    <div class="mb-3 row">
                                                        <label for="keluhan" class="col-sm-2 col-form-label">KELUHAN</label>
                                                        <div class="col-sm-4">
                                                            <textarea class="form-control form-control-sm" rows="3" placeholder="..." id="keluhan" name="keluhan" autocomplete="off"></textarea>
                                                            <span class="error invalid-feedback errorKeluhan">
                                                            </span>
                                                        </div>
                                                        <label for="anamnesa" class="col-sm-2 col-form-label">DIAGNOSA / ANAMNESA</label>
                                                        <div class="col-sm-4">
                                                            <textarea class="form-control form-control-sm" rows="3" placeholder="..." id="anamnesa" name="anamnesa" autocomplete="off"></textarea>
                                                            <span class="error invalid-feedback errorAnamnesa">
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="mb-3 row">
                                                    <label for="" class="col-sm-2 col-form-label">DI RUJUK</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control form-control-sm" placeholder="" id="birthplace" name="birthplace" autocomplete="off">
                                                        <span class="error invalid-feedback errorBirthplace">
                                                        </span>
                                                    </div>
                                                    <label for="" class="col-sm-2 col-form-label"></label>
                                                    <div class="col-sm-4">

                                                    </div>
                                                </div> -->
                                                    <input type="hidden" id="action" name="action" value="Add" />
                                                    <div class="mb-5 row">
                                                        <div class="col-sm text-center">
                                                            <button type="button" class="btn btn-sm btn-primary">RESEP</button><a href="/konsultasidokter/draw" id="titikKeluhan" target="_blank" class="btn btn-sm btn-primary ml-2">TITIK KELUHAN</a><button type="submit" name="submit" id="submit_button" class="btn btn-sm btn-primary ml-2" value="SIMPAN">SIMPAN</button>
                                                        </div>
                                                    </div>
                                                </form>

                                                <div class="container-fluid">
                                                    <form id="data_form2" autocomplete="off">
                                                        <div class="row">
                                                            <!-- left column -->
                                                            <div class="col-md-6">
                                                                <!-- general form elements disabled -->
                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        <h3 class="card-title">Kadaan Umum</h3>
                                                                    </div>
                                                                    <!-- /.card-header -->
                                                                    <div class="card-body">

                                                                        <div class="row">
                                                                            <div class="col-sm-3">
                                                                                <!-- text input -->
                                                                                <div class="form-group">
                                                                                    <label>Nadi</label>
                                                                                    <input type="text" name="nadi" class="form-control" placeholder="" id="nadi">
                                                                                    <span class="error invalid-feedback errorNadi">
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                                <!-- text input -->
                                                                                <div class="form-group">
                                                                                    <label>Suhu</label>
                                                                                    <input type="text" name="suhu" class="form-control" placeholder="" id="suhu">
                                                                                    <span class="error invalid-feedback errorSuhu">
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form-group">
                                                                                    <label>Tekanan Darah</label>
                                                                                    <input type="text" name="tekanan_darah" class="form-control" placeholder="" id="tekanan_darah">
                                                                                    <span class="error invalid-feedback errorTekanan_darah">
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-3">
                                                                                <!-- text input -->
                                                                                <div class="form-group">
                                                                                    <label>Tinggi</label>
                                                                                    <input type="text" name="tinggi_badan" class="form-control" placeholder="" id="tinggi_badan">
                                                                                    <span class="error invalid-feedback errorTinggi_badan">
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                                <!-- text input -->
                                                                                <div class="form-group">
                                                                                    <label>Berat</label>
                                                                                    <input type="text" name="berat_badan" class="form-control" placeholder="" id="berat_badan">
                                                                                    <span class="error invalid-feedback errorBerat_badan">
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form-group">
                                                                                    <label>Pernafasan</label>
                                                                                    <input type="text" name="nafas" class="form-control" placeholder="" id="nafas">
                                                                                    <span class="error invalid-feedback errorNafas">
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                                Keadaan Fisik
                                                                                <hr>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                                <!-- text input -->
                                                                                <div class="form-group">
                                                                                    <label>Rambut</label>
                                                                                    <input type="text" name="pf_rambut" class="form-control" placeholder="" id="pf_rambut">
                                                                                    <span class="error invalid-feedback errorPf_rambut">
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                                <!-- text input -->
                                                                                <div class="form-group">
                                                                                    <label>Telinga</label>
                                                                                    <input type="text" name="pf_telinga" class="form-control" placeholder="" id="pf_telinga">
                                                                                    <span class="error invalid-feedback errorPf_telinga">
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                                <!-- text input -->
                                                                                <div class="form-group">
                                                                                    <label>Mata</label>
                                                                                    <input type="text" name="pf_mata" class="form-control" placeholder="" id="pf_mata">
                                                                                    <span class="error invalid-feedback errorPf_mata">
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                                <!-- text input -->
                                                                                <div class="form-group">
                                                                                    <label>Hidung</label>
                                                                                    <input type="text" name="pf_hidung" class="form-control" placeholder="" id="pf_hidung">
                                                                                    <span class="error invalid-feedback errorPf_hidung">
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                                <!-- text input -->
                                                                                <div class="form-group">
                                                                                    <label>Tenggorokan</label>
                                                                                    <input type="text" name="pf_tenggorokan" class="form-control" placeholder="" id="pf_tenggorokan">
                                                                                    <span class="error invalid-feedback errorPf_tenggorokan">
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <input type="hidden" id="action2" name="action2" value="Add" />


                                                                    </div>
                                                                    <!-- /.card-body -->
                                                                </div>
                                                                <!-- /.card -->
                                                            </div>
                                                            <!--/.col (left) -->

                                                            <!-- right column -->
                                                            <div class="col-md-6">
                                                                <!-- general form elements disabled -->
                                                                <div class="card ">
                                                                    <div class="card-header">
                                                                        <h3 class="card-title">Pemeriksaan & Tindakan</h3>
                                                                    </div>
                                                                    <!-- /.card-header -->
                                                                    <div class="card-body">

                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                                <a href="/konsultasidokter/draw" id="titikKeluhan2" target="_blank" class="btn btn-sm btn-primary m-2 float-right">TITIK KELUHAN</a>
                                                                                <!-- textarea -->
                                                                                <div class="form-group">

                                                                                    <label>Keluhan Utama </label>
                                                                                    <textarea class="form-control" name="keluhan_utama" rows="3" placeholder="Enter ..." id="keluhan_utama"></textarea>
                                                                                    <span class="error invalid-feedback errorKeluhan_utama">
                                                                                </div>

                                                                            </div>

                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                                <!-- textarea -->
                                                                                <div class="form-group">
                                                                                    <label>Keluhan Sekunder</label>
                                                                                    <textarea class="form-control" name="keluhan_sekunder" rows="3" placeholder="Enter ..." id="keluhan_sekunder"></textarea>
                                                                                    <span class="error invalid-feedback errorKeluhan_sekunder">
                                                                                </div>
                                                                            </div>

                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-sm-4">
                                                                                <div class="row">
                                                                                    <div class="col-sm-12">
                                                                                        <!-- text input -->
                                                                                        <div class="form-group">
                                                                                            <label>Diagnosa Utama</label>
                                                                                            <?= $cb_diagnosa_utama  ?>

                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-sm-12">
                                                                                        <!-- text input -->
                                                                                        <div class="form-group">
                                                                                            <label>Diagnosa Sekunder</label>
                                                                                            <?= $cb_diagnosa_sekunder  ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-8">
                                                                                <!-- textarea -->
                                                                                <div class="form-group">
                                                                                    <label>Catatan Diagnosa</label>
                                                                                    <textarea class="form-control" name="diagnosa_note" rows="4" placeholder="Enter ..." id="diagnosa_note"></textarea>
                                                                                    <span class="error invalid-feedback errorDiagnosa_note">
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                                <!-- textarea -->
                                                                                <div class="form-group">
                                                                                    <label>Tindakan</label>
                                                                                    <textarea class="form-control" name="diagnosa_tindakan" rows="6" placeholder="Enter ..."></textarea>
                                                                                    <span class="error invalid-feedback errorDiagnosa_tindakan">
                                                                                </div>
                                                                            </div>
                                                                        </div>



                                                                    </div>
                                                                    <!-- /.card-body -->
                                                                </div>
                                                                <!-- /.card -->
                                                            </div>
                                                            <!--/.col (right) -->

                                                        </div>
                                                        <!-- /.row -->
                                                        <div class="mt-10 mb-10 row">
                                                            <div class="col-sm text-center">
                                                                <button type="submit" name="submit" id="submit_button2" class="btn btn-lg btn-primary ml-2" value="SIMPAN" disabled>SIMPAN 2</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div><!-- /.container-fluid -->

                                                <!-- Modal -->
                                                <div class="modal fade" id="modaljadwaldokter" tabindex="" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <!-- <div class="modal-header">
                                                                <h4 class="modal-title" id="exampleModalLabel"></h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div> -->

                                                            <div class="modal-body">
                                                                <div class="col-12 col-sm-12">
                                                                    <div class="card card-danger shadow-lg" style="transition: all 0.15s ease 0s; height: inherit; width: inherit;">
                                                                        <div class="card-header">
                                                                            <h3 class="card-title">Shadow - Large</h3>
                                                                            <div class="card-tools">
                                                                                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                                                                                </button>
                                                                            </div>

                                                                        </div>

                                                                        <div class="card-body">
                                                                            <div class="container">

                                                                                <div class="row">
                                                                                    <form method="POST" action="upload.php">
                                                                                        <div class="col-md-4">
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <br>
                                                                                            <br>
                                                                                            <div class="text-right">
                                                                                                <!-- <button type="button" class="btn btn-default btn-sm" id="undo"><i class="fa fa-undo"></i> Undo</button>
						                                                                        <button type="button" class="btn btn-danger btn-sm" id="clear"><i class="fa fa-eraser"></i> Clear</button>-->
                                                                                            </div>
                                                                                            <br>
                                                                                            <img id="scream" src="/dist/img/human-vector2.jpg" alt="The Scream" style="display:none">
                                                                                            <div class="wrapper">
                                                                                                <canvas id="signature-pad" class="signature-pad"></canvas>
                                                                                            </div>
                                                                                            <br>
                                                                                            <!-- Modal untuk tampil preview tanda tangan-->
                                                                                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                                                                <div class="modal-dialog modal-lg" role="document">
                                                                                                    <div class="modal-content">
                                                                                                        <div class="modal-header">
                                                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                                            <h4 class="modal-title" id="myModalLabel">Preview Gambar</h4>
                                                                                                        </div>
                                                                                                        <div class="modal-body text-center">
                                                                                                        </div>
                                                                                                        <div class="modal-footer">
                                                                                                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                                                                                                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-upload"></i> Submit</button>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>


                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                        </div>
                                                                                        <div class="navigate">
                                                                                            <div class="clr" data-clr="#000"></div>
                                                                                            <div class="clr" data-clr="#EF626C"></div>
                                                                                            <div class="clr" data-clr="#fdec03"></div>
                                                                                            <div class="clr" data-clr="#24d102"></div>
                                                                                            <div class="clr" data-clr="#fff"></div>
                                                                                            <button type="button" class="btn btn-danger btn-sm ml-2" id="clear"><i class="fa fa-eraser"></i> Clear</button>
                                                                                            <button type="button" class="btn btn-success btn-sm ml-2" id="save-jpeg"><i class="fa fa-save"></i> Save</button>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>

                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <!-- <input type="hidden" id="hidden_id" name="hidden_id" />
                                                                    <input type="hidden" id="action" name="action" value="Add" />
                                                                    <button type="submit" name="submit" id="submit_button" class="btn btn-sm btn-primary" value="Add"></button> -->
                                                                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="custom-tabs-one-lama" role="tabpanel" aria-labelledby="custom-tabs-one-lama-tab">
                                            <div class="col-sm-12">

                                                <form id="data_form" autocomplete="off">
                                                    <?= csrf_field(); ?>
                                                    <div class="mb-3 row">
                                                        <label for="no_registrasi" class="col-sm-2 col-form-label">NO. REGISTRASI</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control form-control-sm" placeholder="" id="no_registrasi" name="no_registrasi" autocomplete="off" readonly>
                                                            <span class="error invalid-feedback errorNo_registrasi">
                                                            </span>
                                                        </div>
                                                        <label for="patient_no" class="col-sm-2 col-form-label">NO. RM</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control form-control-sm" placeholder="" id="patient_no" name="patient_no" autocomplete="off" readonly>
                                                            <span class="error invalid-feedback errorPatient_no">
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label for="tgl_pemeriksaan" class="col-sm-2 col-form-label">TGL. KUNJUNGAN</label>
                                                        <div class="col-sm-4">
                                                            <div class="input-group date birth_dt" data-date-format="mm/dd/yyyy">
                                                                <input type="text" class="form-control form-control-sm datepicker" placeholder="mm/dd/yyyy" id="tgl_pemeriksaan" name="tgl_pemeriksaan" autocomplete="off" readonly>
                                                                <div class="input-group-append" data-target="#birth_dt" data-toggle="birth_dt">
                                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                </div>
                                                            </div>
                                                            <span class="error invalid-feedback errorBirth_dt">
                                                            </span>
                                                        </div>
                                                        <label for="fullname" class="col-sm-2 col-form-label">NAMA PASIEN</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control form-control-sm" placeholder="" id="fullname" name="fullname" autocomplete="off" readonly>
                                                            <span class="error invalid-feedback errorFullname">
                                                            </span>
                                                        </div>
                                                        <input type="hidden" id="tahun" name="tahun">
                                                        <input type="hidden" id="bulan" name="bulan">
                                                        <input type="hidden" id="hari" name="hari">
                                                    </div>


                                                    <hr>
                                                    <div class="mb-3 row">
                                                        <label for="keluhan" class="col-sm-2 col-form-label">KELUHAN</label>
                                                        <div class="col-sm-4">
                                                            <textarea class="form-control form-control-sm" rows="3" placeholder="..." id="keluhan" name="keluhan" autocomplete="off"></textarea>
                                                            <span class="error invalid-feedback errorKeluhan">
                                                            </span>
                                                        </div>
                                                        <label for="anamnesa" class="col-sm-2 col-form-label">DIAGNOSA / ANAMNESA</label>
                                                        <div class="col-sm-4">
                                                            <textarea class="form-control form-control-sm" rows="3" placeholder="..." id="anamnesa" name="anamnesa" autocomplete="off"></textarea>
                                                            <span class="error invalid-feedback errorAnamnesa">
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="mb-3 row">
                                                    <label for="" class="col-sm-2 col-form-label">DI RUJUK</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control form-control-sm" placeholder="" id="birthplace" name="birthplace" autocomplete="off">
                                                        <span class="error invalid-feedback errorBirthplace">
                                                        </span>
                                                    </div>
                                                    <label for="" class="col-sm-2 col-form-label"></label>
                                                    <div class="col-sm-4">

                                                    </div>
                                                </div> -->
                                                    <input type="hidden" id="action" name="action" value="Add" />
                                                    <div class="mb-5 row">
                                                        <div class="col-sm text-center">
                                                            <button type="button" class="btn btn-sm btn-primary">RESEP</button><a href="/konsultasidokter/draw" id="titikKeluhan" target="_blank" class="btn btn-sm btn-primary ml-2">TITIK KELUHAN</a><button type="submit" name="submit" id="submit_button" class="btn btn-sm btn-primary ml-2" value="SIMPAN">SIMPAN</button>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                        <div class="tab-pane fade " id="custom-tabs-one-order" role="tabpanel" aria-labelledby="custom-tabs-one-order-tab">
                                            <div class="col-sm-12">

                                                <h1>TAB ORDER</h1>

                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                                            <div class="row">

                                                <!-- Riwayat Rekam Medis   -->
                                                <div class="col-md-12">
                                                    <div class="card card-info">
                                                        <div class="card-header">
                                                            <h3 class="card-title">
                                                                <i class="fas fa-folder"></i>
                                                                Riwayat Rekam Medis
                                                            </h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <!-- <table id="example1" class="table table-sm table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 10px">Tgl. Berobat</th>
                                                                        <th>Keluhan</th>
                                                                        <th>Anamnesa</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>2/05/2022</td>
                                                                        <td>Sakit Kepala</td>
                                                                        <td>Lorem ipsum dolor sit amet sit amet </td>
                                                                        <td><button type="button" class="btn btn-xs btn-primary">Lebih Detail</button></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>2/06/2022</td>
                                                                        <td>Sakit Dada</td>
                                                                        <td>Lorem ipsum dolor sit amet sit amet
                                                                        </td>
                                                                        <td><button type="button" class="btn btn-xs btn-primary">Lebih Detail</button></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>2/09/2022</td>
                                                                        <td>Demam</td>
                                                                        <td>Lorem ipsum dolor sit amet sit amet
                                                                        </td>
                                                                        <td><button type="button" class="btn btn-xs btn-primary">Lebih Detail</button></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>19/01/2023</td>
                                                                        <td>Lambung Perih</td>
                                                                        <td>Lorem ipsum dolor sit amet sit amet
                                                                        </td>
                                                                        <td><button type="button" class="btn btn-xs btn-primary">Lebih Detail</button></td>
                                                                    </tr>

                                                                </tbody>

                                                            </table> -->

                                                            <span id="viewdatariwayat"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Detail Rekam Medis -->
                                                <div class="col-md-12">
                                                    <div class="card card-info">
                                                        <div class="card-header">
                                                            <h3 class="card-title">
                                                                <i class="fas fa-folder"></i>
                                                                Rekam Medis : <span id="tgl_pemeriksaan_rm"></span>
                                                            </h3>
                                                            <div class="card-tools">
                                                                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                                                                </button>
                                                            </div>
                                                        </div>

                                                        <div class="card-body" style="height: 72vh; overflow-y: scroll;">
                                                            <!-- row 1  -->
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                    <div class="card bg-info">
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <div class="col-md-3">
                                                                                    <dl>
                                                                                        <dt>Usia</dt>
                                                                                        <dd><span id="usia_rm"></span></dd>
                                                                                    </dl>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <dl>
                                                                                        <dt>Berat Badan</dt>
                                                                                        <dd>65 Kg</dd>
                                                                                    </dl>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <dl>
                                                                                        <dt>Tensi Darah</dt>
                                                                                        <dd>120/90 mmHg</dd>
                                                                                    </dl>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <dl>
                                                                                        <dt>Suhu</dt>
                                                                                        <dd>37 &degC</dd>
                                                                                    </dl>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row">
                                                                                <div class="col-md-3">
                                                                                    <dl>
                                                                                        <dt>Jenis Medis</dt>
                                                                                        <dd>Rawat Jalan</dd>
                                                                                    </dl>
                                                                                </div>
                                                                                <div class="col-md-9">
                                                                                    <dl>
                                                                                        <dt>Keluhan</dt>
                                                                                        <dd><span id="keluhan_rm"></span></dd>
                                                                                    </dl>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="card bg-primary">
                                                                                <div class="card-body">
                                                                                    <div class="row">
                                                                                        <div class="col-md-6">
                                                                                            <div class="card-body">
                                                                                                <dl>
                                                                                                    <dt>Dokter</dt>
                                                                                                    <dd>dr. Agus Purwanto</dd>
                                                                                                </dl>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-6">
                                                                                            <div class="card-body">
                                                                                                <dl>
                                                                                                    <dt>Spesialis / Sub-spesialis</dt>
                                                                                                    <dd>Umum</dd>
                                                                                                </dl>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="card-body">
                                                                                        <dl>
                                                                                            <dt>Ringkasan</dt>
                                                                                            <dd>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Magni
                                                                                                laudantium ad
                                                                                                ipsam
                                                                                                ut alias quasi necessitatibus, illo exercitationem laborum cum sequi
                                                                                                accusantium
                                                                                                maiores enim quam provident, minus expedita eum ullam.</dd>
                                                                                        </dl>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="card bg-info">
                                                                                        <div class="card-body">
                                                                                            <h6 class="font-weight-bold">HASIL LAB</h6>
                                                                                            <div class="table-responsive">
                                                                                                <table class="table table-bordered">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <th>
                                                                                                                Nama Pemeriksaan
                                                                                                            </th>
                                                                                                            <th>
                                                                                                                Hasil
                                                                                                            </th>
                                                                                                            <th>
                                                                                                                Nilai Rujukan
                                                                                                            </th>
                                                                                                            <th>
                                                                                                                Satuan
                                                                                                            </th>
                                                                                                            <th>
                                                                                                                Keterangan
                                                                                                            </th>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                                Hematologi Rutin
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                                <ul>
                                                                                                                    <li>
                                                                                                                        Hemoglobin
                                                                                                                    </li>
                                                                                                                </ul>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                10.8*
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                11.7 - 15.5
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                g/dL
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                Perempuan Dewasa sample darah, vena/kapiler
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                                <ul>
                                                                                                                    <li>
                                                                                                                        Hematokrit
                                                                                                                    </li>
                                                                                                                </ul>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                33.8*
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                35-47
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                %
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                Perempuan Dewasa sample darah, vena/kapiler
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                                <ul>
                                                                                                                    <li>
                                                                                                                        Eritrosit
                                                                                                                    </li>
                                                                                                                </ul>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                4.37
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                3.8-5.2
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                10<sup>^</sup>6
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                Perempuan Dewasa sample darah, vena/kapiler
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                                <ul>
                                                                                                                    <li>
                                                                                                                        MCV
                                                                                                                    </li>
                                                                                                                </ul>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                77.3*
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                80-100
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                fL
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                Perempuan Dewasa sample darah, vena/kapiler
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                                <ul>
                                                                                                                    <li>
                                                                                                                        MCH
                                                                                                                    </li>
                                                                                                                </ul>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                24.7*
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                26-34
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                pg
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                Perempuan Dewasa sample darah, vena/kapiler
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                                <ul>
                                                                                                                    <li>
                                                                                                                        MCHC
                                                                                                                    </li>
                                                                                                                </ul>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                32.0
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                32-36
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                pg
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                Perempuan Dewasa sample darah, vena/kapiler
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                                <ul>
                                                                                                                    <li>
                                                                                                                        Trombosit
                                                                                                                    </li>
                                                                                                                </ul>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                436
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                150-440
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                10<sup>3</sup>/uL
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                Dewasa
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                                <ul>
                                                                                                                    <li>
                                                                                                                        Leukosit
                                                                                                                    </li>
                                                                                                                </ul>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                6.22
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                3.6-11.0
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                10<sup>3</sup>/uL
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                Perempuan Dewasa sample darah, vena/kapiler
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                                <ul>
                                                                                                                    <li>
                                                                                                                        LED
                                                                                                                    </li>
                                                                                                                </ul>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                35*
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                0-20
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                mm/jam
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                Perempuan Usia &lt; 50 Tahun
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                                <ul>
                                                                                                                    <li>
                                                                                                                        IP MESSAGE
                                                                                                                    </li>
                                                                                                                </ul>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                Eosinophilia
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                Anisocytosis
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                Microcytosis
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                                Hitung Jenis Leukosit
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                                <ul>
                                                                                                                    <li>
                                                                                                                        Neutrofil
                                                                                                                    </li>
                                                                                                                </ul>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                51.9
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                50 -70
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                %
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                                <ul>
                                                                                                                    <li>
                                                                                                                        Limfosit
                                                                                                                    </li>
                                                                                                                </ul>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                35.0
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                25 - 40
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                %
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                                <ul>
                                                                                                                    <li>
                                                                                                                        Monosit
                                                                                                                    </li>
                                                                                                                </ul>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                6.9
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                2 - 8
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                %
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                                <ul>
                                                                                                                    <li>
                                                                                                                        Eosinofil
                                                                                                                    </li>
                                                                                                                </ul>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                5.9
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                2 - 4
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                %
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                                <ul>
                                                                                                                    <li>
                                                                                                                        Basofil
                                                                                                                    </li>
                                                                                                                </ul>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                0.3
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                0 - 1
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                %
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                                <ul>
                                                                                                                    <li>
                                                                                                                        Neutrofil Absolut
                                                                                                                    </li>
                                                                                                                </ul>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                3.22
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                1.8 - 8.0
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                10<sup>3</sup>/uL
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                                <ul>
                                                                                                                    <li>
                                                                                                                        Limfosit Absolut
                                                                                                                    </li>
                                                                                                                </ul>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                2.18
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                0.9 - 5.2
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                10<sup>3</sup>/uL
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                                <ul>
                                                                                                                    <li>
                                                                                                                        Monosit Absolut
                                                                                                                    </li>
                                                                                                                </ul>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                0.43
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                0.16 - 1
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                10<sup>3</sup>/uL
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                                <ul>
                                                                                                                    <li>
                                                                                                                        Eosinofil Absolut
                                                                                                                    </li>
                                                                                                                </ul>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                0.37
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                0.045 - 0.44
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                10<sup>3</sup>/uL
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                                <ul>
                                                                                                                    <li>
                                                                                                                        Basofil Absolut
                                                                                                                    </li>
                                                                                                                </ul>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                0.02
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                0 - 0.2
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                10<sup>3</sup>/uL
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                        </tr>

                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="card bg-info">
                                                                                        <div class="card-body">
                                                                                            <h6 class="font-weight-bold">HASIL RADIOLOGI</h6>
                                                                                            <dl>
                                                                                                <dt><u>KETERANGAN KLINIS</u></dt>
                                                                                                <ul>
                                                                                                    <li>Intoksikasi Zat H2S</li>
                                                                                                </ul>
                                                                                            </dl>
                                                                                            <dl>
                                                                                                <dt><u>URAIAN HASIL PEMERIKSAAN</u></dt>
                                                                                                Telah dilakukan pemeriksaan foto toraks PA view, posisi erect, asimetris, inspirasi dan kondisi cukup.
                                                                                                Hasil :
                                                                                                <ul>
                                                                                                    <li>Tampak infiltrat dengan air bronchrogram dari suplahiler bilateral</li>
                                                                                                    <li>Tampak sinus costophrenicus et sinistra lancip</li>
                                                                                                    <li>Tampak diafragma dextra et sinistra licin</li>
                                                                                                    <li>Hilus bilateral tampak normal</li>
                                                                                                    <li>Cof,CTR : 0.57</li>
                                                                                                    <li>Trachea di tengah, tak terdeviasi</li>
                                                                                                    <li>Sistema tulang yang tervisualisasi infact</li>
                                                                                                </ul>
                                                                                            </dl>
                                                                                            <dl>
                                                                                                <dt>Kesan / Kesimpulan :</dt>
                                                                                                <ul>
                                                                                                    <li>Pheunomia Bilateral</li>
                                                                                                    <li>Kardiomegali</li>
                                                                                                </ul>
                                                                                            </dl>
                                                                                            <dl>
                                                                                                <dt>Catatan :</dt>
                                                                                                <ul>
                                                                                                    <li>Jika sekiranya ada keraguan dengan hasil pemeriksaan dengan pembacaan foto, diharap segera menghubungi instalasi radiologi RSUD penyambungan</li>
                                                                                                </ul>
                                                                                            </dl>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="card bg-primary">
                                                                                        <div class="card-body">
                                                                                            <dt>Rehab. Medis</dt>
                                                                                            <dd>Tidak ada</dd>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <img src="/assets/img/titikkeluhan/yoyo.jpg" class="img-fluid" height="250px" alt="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="card card-outline">
                                                                        <div class="card-body">
                                                                            <dl>
                                                                                <dt>Obat-obatan</dt>
                                                                                <ul>
                                                                                    <li>Paracetamol</li>
                                                                                    <li>Paracetamol</li>
                                                                                    <li>Paracetamol</li>
                                                                                    <li>Paracetamol</li>
                                                                                    <li>Paracetamol</li>
                                                                                    <li>Paracetamol</li>
                                                                                    <li>Paracetamol</li>
                                                                                    <li>Ambroxol</li>
                                                                                    <li>Racikan Multivitamin
                                                                                        <ul>
                                                                                            <li>Vitamin C</li>
                                                                                            <li>Vitamin D</li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </dl>
                                                                        </div>
                                                                    </div>


                                                                </div>
                                                            </div>
                                                            <!-- end of row 1  -->



                                                        </div>
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
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?= $this->endSection('content'); ?>

<?= $this->section('control-sidebar'); ?>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark" style="height:100vh;">
    <div class="p-1 control-sidebar-content os-host os-theme-light os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition os-host-overflow os-host-overflow-y" style="height: 602px;">

        <!-- Control sidebar content goes here -->
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="card-title">Daftar Pasien</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">

                <span id="viewdata"></span>

            </div>
            <!-- /.card-body -->
        </div>
    </div>
</aside>
<!-- /.control-sidebar -->
<?= $this->endSection('control-sidebar'); ?>

<?= $this->section('script'); ?>

<!-- set menu name by active-menu -->
<script>
    $('#active-menu').html($('p#active-menu').html()); // set top navbar
    $(document).prop("title", $('p#active-menu').html()); // set title
</script>

<script>
    // function setNoRegistrasi() {
    //     $.ajax({
    //         method: "get",
    //         url: "<?= site_url('konsultasidokter/setNoRegistrasi'); ?>",
    //         success: function(data) {
    //             $('#viewdata').html(data);
    //         }
    //     });
    // }

    function tregistrasi() {
        $.ajax({
            method: "get",
            url: "<?= site_url('konsultasidokter/fetchAll'); ?>",
            success: function(data) {
                $('#viewdata').html(data);
            }
        });
    }

    function riwayatRm(patient_no) {
        // var patient_no = $(this).data('patient_no');
        $.ajax({
            url: "<?= site_url('konsultasidokter/fetchAllRiwayat'); ?>",
            method: "GET",
            data: {
                patient_no: patient_no
            },
            // dataType: "JSON",
            success: function(data) {
                $('#viewdatariwayat').html(data);
            }
        });
    }

    // function rekamMedisRiwayat() {
    //     $.ajax({
    //         method: "get",
    //         url: "<?= site_url('konsultasidokter/fetchAllRiwayat'); ?>",
    //         success: function(data) {
    //             $('#viewdatariwayat').html(data);
    //         }
    //     });
    // }

    $(document).ready(function() {
        $('#titikKeluhan2').addClass('disabled');
        $('#submit_button2').prop('disabled', true);
        tregistrasi();
    });

    $(document).on('click', '.pilihpasien', function() {

        // $('#tgl_registrasi_v').val(convertDateIndo(response.data.tgl_registrasi));
        // $('#tanggal_v').val(convertDateIndo(response.data.tgl_praktek));
        // $('#nama_dokter_v').val(response.data.nama_dokter);
        // $('#jam_mulai_v').val(response.data.jam_mulai);
        // $('#jam_selesai_v').val(response.data.jam_selesai);

        // $('#patient_no_v').val(response.data.no_pasien);
        // $('#patient_no_v').trigger('change');
        // $('#tujuan_registrasi_v').val(response.data.tujuan_registrasi);
        // $('#tujuan_registrasi_v').trigger('change');
        // $('#patient_no_v').attr('disabled', '');
        // $('#tujuan_registrasi_v').attr('disabled', '');

        // $('#nama_v').val(response.data.fullname);
        // $('#gender_v').val(response.data.gender == 'F' ? 'Perempuan' : 'Laki - Laki');
        // $('#birth_dt_v').val(convertDateIndo(response.data.birth_dt));
        // $('#addr_v').val(response.data.addr);
        // $('#mobile_no_v').val(response.data.mobile_no);
        // $('p#usia').html('<b>' + response.data.tahun + '</b> Tahun, <b>' + response.data.bulan + '</b> Bulan, <b>' + response.data.hari + '</b> Hari');

        // var jadwal_id = $(this).data('jadwal_id');
        // var kode_dokter = $(this).data('kode_dokter');
        // var jam_mulai = $(this).data('jam_mulai');
        // var jam_selesai = $(this).data('jam_selesai');
        // var nama_dokter = $(this).data('nama_dokter');
        // var tanggal = $(this).data('tgl_praktek');
        // var tgl_registrasi = new Date(Date.now()).toLocaleString().split(',')[0];

        // $('#jadwal_id').html('');
        // $('#jam_mulai').html('');
        // $('#jam_selesai').html('');
        // $('#kode_dokter').html('');
        // $('#nama_dokter').html('');
        // $('#tanggal').html('');
        // $('#tgl_daftar').html('');
        // $('#usia').html('');
        // $('#tujuan_registrasi').html(' ');

        // $('#jadwal_id').html(jadwal_id);
        // $('#jam_mulai').html(jam_mulai);
        // $('#jam_selesai').html(jam_selesai);
        // $('#kode_dokter').html(kode_dokter);
        // $('#nama_dokter').html(nama_dokter);
        // $('#tanggal').html(convertDateUs(tanggal));
        // $('#tgl_registrasi').html(tgl_registrasi);
        // $('#tujuan_registrasi').html('dokter');

        var no_registrasi = $(this).data('no_registrasi');
        $.ajax({
            url: "<?= site_url('konsultasidokter/setNoRegistrasi'); ?>",
            method: "GET",
            data: {
                no_registrasi: no_registrasi
            },
            // dataType: "JSON",
            success: function(data) {
                // $('#viewdatariwayat').html(data);
                alert(no_registrasi);
                $('#titikKeluhan2').removeClass('disabled');
                $('#submit_button2').prop('disabled', false);
            }
        });
        var patient_no = $(this).data('patient_no');
        var fullname = $(this).data('fullname');
        var birth_dt = $(this).data('birth_dt');
        var tahun = $(this).data('tahun');
        var bulan = $(this).data('bulan');
        var hari = $(this).data('hari');
        var gender = $(this).data('gender');
        var mobile_no = $(this).data('mobile_no');

        var today = new Date();

        $('#no_registrasi').val(no_registrasi);
        $('#patient_no').val(patient_no);
        $('#fullname_tm').html(fullname);
        $('#fullname').val(fullname);
        $('#tgl_pemeriksaan').val(today.toLocaleDateString("en-US"));
        $('#birth_dt_tm').html(convertDateIndo(birth_dt));
        $('#usia_tm').html('<b>' + tahun + '</b> Tahun, <b>' + bulan + '</b> Bulan, <b>' + hari + '</b> Hari');
        $('#gender_tm').html(gender);
        $('#mobile_no_tm').html(mobile_no);
        $('#keluhan').val('');
        $('#anamnesa').val('');


    });

    $(document).on('click', '.pasien', function() {
        var patient_no = $(this).data('patient_no');
        $.ajax({
            url: "<?= site_url('konsultasidokter/fetchAllRiwayat'); ?>",
            method: "GET",
            data: {
                patient_no: patient_no
            },
            // dataType: "JSON",
            success: function(data) {
                $('#viewdatariwayat').html(data);
            }
        })
    });

    $(document).on('click', '.pilihmr', function() {
        var medrec_id = $(this).data('medrec_id');

        $.ajax({
            url: "<?= site_url('konsultasidokter/fetchSingleData'); ?>",
            method: "GET",
            data: {
                medrec_id: medrec_id
            },
            dataType: "JSON",
            success: function(response) {

                //alert(response.data.tgl_pemeriksaan);
                $('#medrec_id_rm').val('');
                $('#patient_no_rm').val('');
                $('#fullname_rm').val('');
                $('#no_registrasi_rm').val('');
                $('#tgl_pemeriksaan_rm').val('');
                $('#usia_rm').html('');
                $('#keluhan_rm').val('');
                $('#anamnesa_rm').val('');

                //set data from response record
                $('#medrec_id_rm').html(response.data.medrec_id);
                $('#patient_no_rm').html(response.data.patient_no);
                $('#fullname_rm').html(response.data.fullname);
                $('#no_registrasi_rm').html(response.data.no_registrasi);
                $('#tgl_pemeriksaan_rm').html(convertDateIndo(response.data.tgl_pemeriksaan));
                alert(response.data.bulan);
                $('#usia_rm').html('<b>' + response.data.tahun + '</b> Tahun, <b>' + response.data.bulan + '</b> Bulan, <b>' + response.data.hari + '</b> Hari');
                $('#keluhan_rm').html(response.data.keluhan);
                $('#anamnesa_rm').html(response.data.anamnesa);

            }
        })
    });

    $('#data_form').on('submit', function(event) {
        // alert($('#no_registrasi').val());
        // alert($('#patient_no').val());
        // alert($('#fullname').val());
        // alert($('#tgl_pemeriksaan').val());
        // alert($('#tahun').val());
        // alert($('#bulan').val());
        // alert($('#hari').val());
        // alert($('#keluhan').val());
        // alert($('#anamnesa').val());
        // alert($('#action').val());
        event.preventDefault();
        $.ajax({
            url: "<?= site_url('konsultasidokter/action'); ?>",
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
                    if (response.error.no_registrasi) {
                        $('#no_registrasi').addClass('is-invalid');
                        $('.errorNo_registrasi').html(response.error.no_registrasi);
                    } else {
                        $('#no_registrasi').removeClass('is-invalid');
                        $('.errorNo_registrasi').html('');
                    }
                    if (response.error.patient_no) {
                        $('#patient_no').addClass('is-invalid');
                        $('.errorPatient_no').html(response.error.patient_no);
                    } else {
                        $('#patient_no').removeClass('is-invalid');
                        $('.errorPatient_no').html('');
                    }
                    if (response.error.keluhan) {
                        $('#keluhan').addClass('is-invalid');
                        $('.errorKeluhan').html(response.error.keluhan);
                    } else {
                        $('#keluhan').removeClass('is-invalid');
                        $('.errorKeluhan').html('');
                    }
                    if (response.error.anamnesa) {
                        $('#anamnesa').addClass('is-invalid');
                        $('.errorAnamnesa').html(response.error.anamnesa);
                    } else {
                        $('#anamnesa').removeClass('is-invalid');
                        $('.errorAnamnesa').html('');
                    }

                } else {
                    //sweet alert
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.success,
                        //footer: '<a href="">Why do I have this issue?</a>'
                    });

                    //set error validation
                    $('#keluhan').removeClass('is-invalid');
                    $('#anamnesa').removeClass('is-invalid');
                    $('#keluhan').html('');
                    $('#anamnesa').html('');

                    // $('#no_registrasi').val();
                    // $('#patient_no').val();
                    // $('#fullname').val();
                    // $('#tgl_pemeriksaan').val();
                    // $('#tahun').val();
                    // $('#bulan').val();
                    // $('#hari').val();
                    // $('#keluhan').val();
                    // $('#anamnesa').val();

                    $('.modal-title').text('Rekam Medis');
                    $('#submit_button').val('SIMPAN');
                    $('#submit_button').html('SIMPAN');

                    riwayatRm($('#patient_no').val());

                }
            }
        })
    });

    $('#data_form2').on('submit', function(event) {
        // alert($('#no_registrasi').val());
        // alert($('#patient_no').val());
        // alert($('#fullname').val());
        // alert($('#tgl_pemeriksaan').val());
        // alert($('#tahun').val());
        // alert($('#bulan').val());
        // alert($('#hari').val());
        // alert($('#keluhan').val());
        // alert($('#anamnesa').val());
        // alert($('#action').val());
        event.preventDefault();
        $.ajax({
            url: "<?= site_url('konsultasidokter/action2'); ?>",
            method: "POST",
            data: $(this).serialize(),
            dataType: "JSON",
            beforeSend: function() {
                $('#submit_button2').prop('disabled', true);
                $('#submit_button2').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function() {
                $('#submit_button2').prop('disabled', false);
                $('#submit_button2').html($('#submit_button2').val());
            },
            success: function(response) {

                if (response.error) {

                    if (response.error.no_registrasi) {
                        $('#no_registrasi').addClass('is-invalid');
                        $('.errorNo_registrasi').html(response.error.no_registrasi);
                    } else {
                        $('#no_registrasi').removeClass('is-invalid');
                        $('.errorNo_registrasi').html('');
                    }
                    if (response.error.patient_no) {
                        $('#patient_no').addClass('is-invalid');
                        $('.errorPatient_no').html(response.error.patient_no);
                    } else {
                        $('#patient_no').removeClass('is-invalid');
                        $('.errorPatient_no').html('');
                    }
                    if (response.error.keluhan) {
                        $('#keluhan').addClass('is-invalid');
                        $('.errorKeluhan').html(response.error.keluhan);
                    } else {
                        $('#keluhan').removeClass('is-invalid');
                        $('.errorKeluhan').html('');
                    }
                    if (response.error.anamnesa) {
                        $('#anamnesa').addClass('is-invalid');
                        $('.errorAnamnesa').html(response.error.anamnesa);
                    } else {
                        $('#anamnesa').removeClass('is-invalid');
                        $('.errorAnamnesa').html('');
                    }
                    if (response.error.nadi) {
                        $('#nadi').addClass('is-invalid');
                        $('.errorNadi').html(response.error.nadi);
                    } else {
                        $('#nadi').removeClass('is-invalid');
                        $('.errorNadi').html('');
                    }
                    if (response.error.suhu) {
                        $('#suhu').addClass('is-invalid');
                        $('.errorSuhu').html(response.error.suhu);
                    } else {
                        $('#suhu').removeClass('is-invalid');
                        $('.errorSuhu').html('');
                    }
                    if (response.error.nafas) {
                        $('#nafas').addClass('is-invalid');
                        $('.errorNafas').html(response.error.nafas);
                    } else {
                        $('#nafas').removeClass('is-invalid');
                        $('.errorNafas').html('');
                    }
                    if (response.error.tekanan_darah) {
                        $('#tekanan_darah').addClass('is-invalid');
                        $('.errorTekanan_darah').html(response.error.tekanan_darah);
                    } else {
                        $('#tekanan_darah').removeClass('is-invalid');
                        $('.errorTekanan_darah').html('');
                    }
                    if (response.error.tinggi_badan) {
                        $('#tinggi_badan').addClass('is-invalid');
                        $('.errorTinggi_badan').html(response.error.tinggi_badan);
                    } else {
                        $('#tinggi_badan').removeClass('is-invalid');
                        $('.errorTinggi_badan').html('');
                    }
                    if (response.error.berat_badan) {
                        $('#berat_badan').addClass('is-invalid');
                        $('.errorBerat_badan').html(response.error.berat_badan);
                    } else {
                        $('#berat_badan').removeClass('is-invalid');
                        $('.errorBerat_badan').html('');
                    }
                    if (response.error.keluhan_utama) {
                        $('#keluhan_utama').addClass('is-invalid');
                        $('.errorKeluhan_utama').html(response.error.keluhan_utama);
                    } else {
                        $('#keluhan_utama').removeClass('is-invalid');
                        $('.errorKeluhan_utama').html('');
                    }
                    if (response.error.keluhan_sekunder) {
                        $('#keluhan_sekunder').addClass('is-invalid');
                        $('.errorKeluhan_sekunder').html(response.error.keluhan_sekunder);
                    } else {
                        $('#keluhan_sekunder').removeClass('is-invalid');
                        $('.errorKeluhan_sekunder').html('');
                    }
                    if (response.error.diagnosa_utama) {
                        $('#diagnosa_utama').addClass('is-invalid');
                        $('.errorDiagnosa_utama').html(response.error.diagnosa_utama);
                    } else {
                        $('#diagnosa_utama').removeClass('is-invalid');
                        $('.errorDiagnosa_utama').html('');
                    }
                    if (response.error.diagnosa_sekunder) {
                        $('#diagnosa_sekunder').addClass('is-invalid');
                        $('.errorDiagnosa_sekunder').html(response.error.diagnosa_sekunder);
                    } else {
                        $('#diagnosa_sekunder').removeClass('is-invalid');
                        $('.errorDiagnosa_sekunder').html('');
                    }
                    if (response.error.diagnosa_note) {
                        $('#diagnosa_note').addClass('is-invalid');
                        $('.errorDiagnosa_note').html(response.error.diagnosa_note);
                    } else {
                        $('#diagnosa_note').removeClass('is-invalid');
                        $('.errorDiagnosa_note').html('');
                    }
                    if (response.error.pf_rambut) {
                        $('#pf_rambut').addClass('is-invalid');
                        $('.errorPf_rambut').html(response.error.pf_rambut);
                    } else {
                        $('#pf_rambut').removeClass('is-invalid');
                        $('.errorPf_rambut').html('');
                    }
                    if (response.error.pf_mata) {
                        $('#pf_mata').addClass('is-invalid');
                        $('.errorPf_mata').html(response.error.pf_mata);
                    } else {
                        $('#pf_mata').removeClass('is-invalid');
                        $('.errorPf_mata').html('');
                    }
                    if (response.error.pf_telinga) {
                        $('#pf_telinga').addClass('is-invalid');
                        $('.errorPf_telinga').html(response.error.pf_telinga);
                    } else {
                        $('#pf_telinga').removeClass('is-invalid');
                        $('.errorPf_telinga').html('');
                    }
                    if (response.error.pf_hidung) {
                        $('#pf_hidung').addClass('is-invalid');
                        $('.errorPf_hidung').html(response.error.pf_hidung);
                    } else {
                        $('#pf_hidung').removeClass('is-invalid');
                        $('.errorPf_hidung').html('');
                    }
                    if (response.error.pf_tenggorokan) {
                        $('#pf_tenggorokan').addClass('is-invalid');
                        $('.errorPf_tenggorokan').html(response.error.pf_tenggorokan);
                    } else {
                        $('#pf_tenggorokan').removeClass('is-invalid');
                        $('.errorPf_tenggorokan').html('');
                    }



                } else {
                    //sweet alert
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.success,
                        //footer: '<a href="">Why do I have this issue?</a>'
                    });

                    //set error validation
                    $('#keluhan').removeClass('is-invalid');
                    $('#anamnesa').removeClass('is-invalid');
                    $('#keluhan').html('');
                    $('#anamnesa').html('');

                    // $('#no_registrasi').val();
                    // $('#patient_no').val();
                    // $('#fullname').val();
                    // $('#tgl_pemeriksaan').val();
                    // $('#tahun').val();
                    // $('#bulan').val();
                    // $('#hari').val();
                    // $('#keluhan').val();
                    // $('#anamnesa').val();

                    $('.modal-title').text('Rekam Medis');
                    $('#submit_button2').val('SIMPAN');
                    $('#submit_button2').html('SIMPAN');

                    riwayatRm($('#patient_no').val());

                }
            }
        })
    });

    function convertDateIndo(date) {
        var d_arr = date.split("/");
        var fromDate = d_arr[1] + '/' + d_arr[0] + '/' + d_arr[2];
        dateNew = fromDate.split(' ')[0];
        // var fromDate = date.toLocaleDateString('en-GB');
        return dateNew;
    }

    function convertDateUs(date) {
        var d_arr = date.split("/");
        var fromDate = d_arr[1] + '/' + d_arr[0] + '/' + d_arr[2];
        dateNew = fromDate.split(' ')[0];
        return dateNew;
    }

    function getDateUs() {
        var dateNew = new Date().toLocaleDateString('en-US');
        // var dateNew = date.toLocaleDateString('en-US');
        return dateNew;
    }

    function getDateIndo() {
        var dateNew = new Date().toLocaleDateString('en-GB');
        return dateNew;
    }

    // $('#titikKeluhan').click(function() {
    //     //set modal & form
    //     $('.modal-title').text('Jadwal Dokter');
    //     $('#modaljadwaldokter').modal('show');
    // });

    // function dokter() {
    //     $.ajax({
    //         method: "get",
    //         url: "<?= site_url('patient/fetchAll'); ?>",
    //         success: function(data) {
    //             $('#viewdata').html(data);
    //         }
    //     });
    // }
    // $(document).ready(function() {

    //     dokter();
    // });

    // function obat() {
    //     $.ajax({
    //         method: "get",
    //         url: "<?= site_url('patient/fetchAll'); ?>",
    //         success: function(data) {
    //             $('#viewdata').html(data);
    //         }
    //     });
    // }
    // $(document).ready(function() {

    //     obat();
    // });

    // function rehab() {
    //     $.ajax({
    //         method: "get",
    //         url: "<?= site_url('patient/fetchAll'); ?>",
    //         success: function(data) {
    //             $('#viewdata').html(data);
    //         }
    //     });
    // }
    // $(document).ready(function() {

    //     rehab();
    // });
</script>

<!-- Signature-pad.js -->
<script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
<script type="text/javascript" src="<?= base_url('assets/js/signature-pad.js') ?>"></script>

<?= $this->endSection('script'); ?>