<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>

<!-- datepicker styles -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css">

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

    .list-group {
        max-height: 80vh;
        margin-bottom: 10px;
        overflow-y: scroll;
        -webkit-overflow-scrolling: touch;
    }

    .text_small {
        font-size: 10px;
        color: grey;
        margin-left: 10px;
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
            padding-top: 130px;
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
    /* .signature-pad {
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 100%;
        height: 547px;

    } */

    .caption_text {
        font-size: 0.6rem;
    }

    .content_text {
        font-size: 0.8rem;
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
                    <div class="card bg-info" style="padding:2px;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <dl>
                                        <dt class="caption_text">Nomor Registrasi <?= session()->get('emp_cd') ?></dt>
                                        <span id="no_registrasi" class="content_text">&nbsp;</span>
                                    </dl>
                                </div>
                                <div class="col-md-3">
                                    <dl>
                                        <dt class="caption_text">No. Rekam Medis</dt>
                                        <span id="medrec_id_info" class="content_text">&nbsp;</span>
                                    </dl>
                                </div>
                                <div class="col-md-3">
                                    <dl>
                                        <dt class="caption_text">Nama Pasien</dt>
                                        <span id="fullname_tm" class="content_text">&nbsp;</span>
                                    </dl>
                                </div>
                                <div class="col-md-3">
                                    <dl>
                                        <dt class="caption_text">Jenis Kelamin - Tanggal Lahir - Usia</dt>
                                        <span id="gender_tm" class="content_text">&nbsp;</span> - <span id="birth_dt_tm">&nbsp;</span> - <span id="tahun">&nbsp;</span> Th,<span id="bulan">&nbsp;</span> Bln.
                                    </dl>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <dl>
                                        <dt class="caption_text">Poliklinik</dt>
                                        <span id="tujuan_registrasi_desc" class="content_text">&nbsp;</span>
                                    </dl>
                                </div>
                                <div class="col-md-3">
                                    <dl>
                                        <dt class="caption_text">Dokter</dt>
                                        <span id="nama_dokter" class="content_text">&nbsp;</span>
                                    </dl>
                                </div>
                                <div class="col-md-3">
                                    <dl>
                                        <dt class="caption_text">Status Pemeriksaan</dt>
                                        <span id="birth_dt_tmx" class="content_text">&nbsp;
                                            <!-- Button trigger modal -->
                                            <!-- <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modalAlergi">
                                                ADA ALERGI
                                            </button> -->
                                            <button type="button" class="btn btn-default btn-xs" id="modalAlergiBtn">
                                                ALERGI
                                            </button>
                                        </span>
                                    </dl>
                                </div>
                                <div class="col-md-3">
                                    <dl>
                                        <dt class="caption_text">Jaminan</dt>
                                        <span id="type_pasien" class="content_text">&nbsp;</span>
                                    </dl>
                                </div>
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
                                            <a class="nav-link" id="custom-tabs-one-alergi-tab" data-toggle="pill" href="#custom-tabs-one-alergi" role="tab" aria-controls="custom-tabs-one-alergi" aria-selected="true">Catatan Alergi</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-one-lama-tab" data-toggle="pill" href="#custom-tabs-one-lama" role="tab" aria-controls="custom-tabs-one-lama" aria-selected="true">Order</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-one-order-tab" data-toggle="pill" href="#custom-tabs-one-order" role="tab" aria-controls="custom-tabs-one-order" aria-selected="false">Rekam Medis</a>
                                        </li>

                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                            <div class="col-sm-12">


                                                <div class="container-fluid">
                                                    <form id="data_form" autocomplete="off">
                                                        <div class="row">
                                                            <!-- left column -->
                                                            <div class="col-md-6">
                                                                <!-- general form elements disabled -->
                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        <h3 class="card-title">Kadaan Umum
                                                                        </h3>
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
                                                                                    <label>Suhu (&deg;c)</label>
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
                                                                                    <label>Tinggi (cm)</label>
                                                                                    <input type="text" name="tinggi_badan" class="form-control" placeholder="" id="tinggi_badan">
                                                                                    <span class="error invalid-feedback errorTinggi_badan">
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                                <!-- text input -->
                                                                                <div class="form-group">
                                                                                    <label>Berat (kg)</label>
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
                                                                        <input type="hidden" class="medrec_id" name="medrec_id" />
                                                                        <input type="hidden" id="action" name="action" value="Add" />


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
                                                                                <a href="/konsultasidokter/draw" id="titikKeluhan" target="_blank" class="btn btn-sm btn-primary m-2 float-right">TITIK KELUHAN</a>
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
                                                                                    <select class="form-control form-control-sm " name="user_id" id="user_select">
                                                                                        <option value="">-- Select user --</option>
                                                                                    </select>
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

                                                        <div class="row">
                                                            <!-- right column -->
                                                            <div class="col-md-6">
                                                                <!-- general form elements disabled -->
                                                                <div class="card ">
                                                                    <!-- <div class="card-header">
                                                                        <h3 class="card-title">Pemeriksaan & Tindakan</h3>
                                                                    </div> -->
                                                                    <!-- /.card-header -->
                                                                    <div class="card-body">

                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                                <!-- text input -->
                                                                                <div class="form-group">
                                                                                    <label>Reduksi (%)</label>
                                                                                    <input type="number" name="reduksi_persen" class="form-control" placeholder="%" id="reduksi_persen">
                                                                                    <span class="error invalid-feedback errorReduksi_persen">
                                                                                    </span>
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
                                                        <input type="hidden" id="no_kwitansi" name="no_kwitansi" />
                                                        <div class="mt-10 mb-10 row">
                                                            <div class="col-sm text-center">
                                                                <button type="submit" name="submit" id="submit_button" class="btn btn-lg btn-primary ml-2" value="SIMPAN" disabled>SIMPAN</button>
                                                            </div>
                                                        </div>
                                                    </form>

                                                </div>
                                                <!-- /.container-fluid -->



                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="custom-tabs-one-alergi" role="tabpanel" aria-labelledby="custom-tabs-one-alergi-tab">

                                        </div>

                                        <div class="tab-pane fade" id="custom-tabs-one-lama" role="tabpanel" aria-labelledby="custom-tabs-one-lama-tab">
                                            <div class="col-sm-12">



                                            </div>
                                        </div>
                                        <div class="tab-pane fade " id="custom-tabs-one-order" role="tabpanel" aria-labelledby="custom-tabs-one-order-tab">
                                            <!-- Main content -->
                                            <section class="content">
                                                <div class="container-fluid">
                                                    <!-- Main row -->
                                                    <div class="row">

                                                        <div class="col-md-4">
                                                            <!-- PRODUCT LIST -->
                                                            <div class="card">
                                                                <!-- <div class="card-header">
                                                                    <h3 class="card-title">Recently Added Products</h3>

                                                                    <div class="card-tools">
                                                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                                            <i class="fas fa-minus"></i>
                                                                        </button>
                                                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                                                            <i class="fas fa-times"></i>
                                                                        </button>
                                                                    </div>
                                                                </div> -->
                                                                <!-- /.card-header -->
                                                                <div class="card-body p-0" style="height: 80vh;">
                                                                    <ul class="products-list product-list-in-card pl-2 pr-2 list-group" id="viewdatariwayat">
                                                                        <li class="item">
                                                                            <div class="product-img">
                                                                                <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                                            </div>
                                                                            <div class="product-info">
                                                                                <a href="javascript:void(0)" class="product-title">
                                                                                    <span class="badge badge-warning float-right"></span></a>
                                                                                <span class="product-description">
                                                                                    <p>
                                                                                        <center>Data Tidak Ditemukan!</center>
                                                                                    </p>
                                                                                </span>
                                                                            </div>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <!-- /.card-body -->
                                                                <!-- <div class="card-footer text-center">
                                                                    <a href="javascript:void(0)" class="uppercase">View All Products</a>
                                                                </div> -->
                                                                <!-- /.card-footer -->
                                                            </div>
                                                            <!-- /.card -->


                                                        </div>
                                                        <!-- /.col -->

                                                        <div class="col-md-8">
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
                                                                                                    <dt class="caption_text">Usia</dt>
                                                                                                    <dd><span id="usia_rm" class="content_text"></span></dd>
                                                                                                </dl>
                                                                                            </div>
                                                                                            <div class="col-md-3">
                                                                                                <dl>
                                                                                                    <dt class="caption_text">Berat Badan (Kg)</dt>
                                                                                                    <dd><span id="berat_badan_rm" class="content_text"></span> Kg</dd>
                                                                                                </dl>
                                                                                            </div>
                                                                                            <div class="col-md-3">
                                                                                                <dl>
                                                                                                    <dt class="caption_text">Tinggi Badan (cm)</dt>
                                                                                                    <dd><span id="tinggi_badan_rm" class="content_text"></span> CM</dd>
                                                                                                </dl>
                                                                                            </div>
                                                                                            <div class="col-md-3">
                                                                                                <dl>
                                                                                                    <dt class="caption_text">Tensi Darah</dt>
                                                                                                    <dd><span id="tekanan_darah_rm" class="content_text"></span> mmHg</dd>
                                                                                                </dl>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div class="col-md-3">
                                                                                                <dl>
                                                                                                    <dt class="caption_text"></dt>
                                                                                                    <dd><span id="" class="content_text"></span></dd>
                                                                                                </dl>
                                                                                            </div>
                                                                                            <div class="col-md-3">
                                                                                                <dl>
                                                                                                    <dt class="caption_text">Nadi</dt>
                                                                                                    <dd><span id="nadi_rm" class="content_text"></span> </dd>
                                                                                                </dl>
                                                                                            </div>
                                                                                            <div class="col-md-3">
                                                                                                <dl>
                                                                                                    <dt class="caption_text">Suhu (&deg;c)</dt>
                                                                                                    <dd><span id="suhu_rm" class="content_text"></span> &degC</dd>
                                                                                                </dl>
                                                                                            </div>
                                                                                            <div class="col-md-3">
                                                                                                <dl>
                                                                                                    <dt class="caption_text">Nafas</dt>
                                                                                                    <dd><span id="nafas_rm" class="content_text"></span> </dd>
                                                                                                </dl>
                                                                                            </div>
                                                                                        </div>

                                                                                        <hr>
                                                                                        <div class="row"></div>

                                                                                        <div class="row">
                                                                                            <div class="col-md-4">
                                                                                                <dl>
                                                                                                    <dt class="caption_text">Poliklinik</dt>
                                                                                                    <dd><span id="tujuan_registrasi_desc_rm" class="content_text"></span></dd>
                                                                                                </dl>
                                                                                            </div>
                                                                                            <div class="col-md-4">
                                                                                                <dl>
                                                                                                    <dt class="caption_text">Keluhan Utama</dt>
                                                                                                    <dd><span id="keluhan_utama_rm" class="content_text"></span></dd>
                                                                                                </dl>
                                                                                            </div>
                                                                                            <div class="col-md-4">
                                                                                                <dl>
                                                                                                    <dt class="caption_text">Keluhan Sekunder</dt>
                                                                                                    <dd><span id="keluhan_sekunder_rm" class="content_text"></span></dd>
                                                                                                </dl>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div class="col-md-4">
                                                                                                <dl>
                                                                                                    <dt class="caption_text"></dt>
                                                                                                    <dd><span id="" class="content_text"></span></dd>
                                                                                                </dl>
                                                                                            </div>
                                                                                            <div class="col-md-4">
                                                                                                <dl>
                                                                                                    <dt class="caption_text">Diagnosa Utama</dt>
                                                                                                    <dd><span id="diagnosa_utama_rm" class="content_text"></span></dd>
                                                                                                </dl>
                                                                                            </div>
                                                                                            <div class="col-md-4">
                                                                                                <dl>
                                                                                                    <dt class="caption_text">Diagnosa Sekunder</dt>
                                                                                                    <dd><span id="diagnosa_sekunder_rm"></span></dd>
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
                                                                                                                <dt class="caption_text">Dokter</dt>
                                                                                                                <dd><span id="nama_dokter_rm" class="content_text"></span></dd>
                                                                                                            </dl>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-md-6">
                                                                                                        <div class="card-body">
                                                                                                            <dl>
                                                                                                                <dt class="caption_text">Spesialis / Sub-spesialis</dt>
                                                                                                                <dd>Umum</dd>
                                                                                                            </dl>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="card-body">
                                                                                                    <dl>
                                                                                                        <dt class="caption_text">Ringkasan</dt>
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
                                                                                        <div class="row" style="display:none;">
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
                                                                                                        <dt>Catatan Alergi</dt>
                                                                                                        <dd class="alergi"></dd>
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
                                                                                        <img src="/assets/img/titikkeluhan/default.jpg" class="img-fluid titikkeluhan" height="250px" alt="">
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
                                                        <!-- /.col -->

                                                    </div><!--/. container-fluid -->
                                            </section>
                                            <!-- /.content -->


                                        </div>




                                    </div>
                                </div>
                                <!-- /.card -->
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="modalAlergi" tabindex=" " role="dialog" aria-labelledby="modalAlergiLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <form id="data_form2" autocomplete="off">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalAlergiLabel">Alergi</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="col-12 col-sm-12">
                                            <div class="card card-primary card-outline card-outline-tabs">
                                                <div class="card-header p-0 border-bottom-0">
                                                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">List</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Tambah</a>
                                                        </li>

                                                    </ul>
                                                </div>
                                                <div class="card-body">
                                                    <div class="tab-content" id="custom-tabs-four-tabContent">
                                                        <div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">

                                                        </div>
                                                        <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">

                                                            <!-- right column -->
                                                            <div class="col-md-12">
                                                                <!-- general form elements disabled -->
                                                                <div class="card ">
                                                                    <!-- <div class="card-header">
                                                                    <h3 class="card-title"></h3>
                                                                </div> -->
                                                                    <!-- /.card-header -->
                                                                    <div class="card-body">

                                                                        <input type="hidden" class="form-control form-control-sm" id="patient_no" name="patient_no" readonly>
                                                                        <input type="hidden" id="action2" name="action2" value="Add" />
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <!-- textarea -->
                                                                                <div class="form-group">
                                                                                    <label>Kategori</label>
                                                                                    <?= $cb_kategori_alergi ?>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-6">
                                                                                <label>Tgl Resign</label>
                                                                                <div class="form-group">
                                                                                    <div class="input-group date permulaan_dt" data-date-format="mm/dd/yyyy">
                                                                                        <input type="text" class="form-control form-control-sm datepicker" placeholder="mm/dd/yyyy" id="permulaan_dt" name="permulaan_dt" autocomplete="off">
                                                                                        <div class="input-group-append" data-target="#permulaan_dt" data-toggle="permulaan_dt">
                                                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <span class="error invalid-feedback errorPermulaan_dt">
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <!-- textarea -->
                                                                                <div class="form-group">
                                                                                    <label>Bahan</label>
                                                                                    <?= $cb_bahan_alergi ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <!-- textarea -->
                                                                                <div class="form-group">
                                                                                    <label>Komponen</label>
                                                                                    <?= $cb_komponen_alergi ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <!-- textarea -->
                                                                                <div class="form-group">
                                                                                    <label>Reaksi</label>
                                                                                    <?= $cb_reaksi_alergi ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <!-- textarea -->
                                                                                <div class="form-group">
                                                                                    <label>Tingkat Kegawatan</label>
                                                                                    <?= $cb_tingkat_kegawatan_alergi ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <!-- textarea -->
                                                                                <div class="form-group">
                                                                                    <label>Status</label>
                                                                                    <?= $cb_status_alergi ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <!-- textarea -->
                                                                                <div class="form-group">
                                                                                    <label>Verifikasi</label>
                                                                                    <?= $cb_verifikasi_alergi ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                                <!-- textarea -->
                                                                                <div class="form-group">
                                                                                    <label>Catatan Diagnosa</label>
                                                                                    <textarea class="form-control" name="catatan" rows="2" placeholder="Enter ..." id="catatan"></textarea>
                                                                                    <span class="error invalid-feedback errorCatatan">
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

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" name="submit" id="submit_button2" class="btn btn-primary btn-sm" value="SIMPAN">SIMPAN</button>
                                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                                        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /end modal -->

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

<!-- Datepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>


<!-- set menu name by active-menu -->
<script>
    $('#active-menu').html($('p#active-menu').html()); // set top navbar
    $(document).prop("title", $('p#active-menu').html()); // set title
    alert("body");
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

    tregistrasi();

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
        var patient_no = $('.medrec_id_info').text();

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

    function riwayatRmAnamnesa(patient_no) {
        // var patient_no = $(this).data('patient_no');
        $.ajax({
            url: "<?= site_url('konsultasidokter/fetchAllRiwayatAnamnesa'); ?>",
            method: "GET",
            data: {
                patient_no: patient_no
            },
            // dataType: "JSON",
            success: function(data) {
                $('#viewdatariwayatanamnesa').html(data);
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

        $(".tab-pane").css("display", "none");
        $('#titikKeluhan').addClass('disabled');
        $('#submit_button').prop('disabled', true);
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
        var patient_no = $(this).data('patient_no');
        $.ajax({
            url: "<?= site_url('konsultasidokter/setNoRegistrasi'); ?>",
            method: "GET",
            data: {
                no_registrasi: no_registrasi,
                patient_no: patient_no
            },
            // dataType: "JSON",
            success: function(data) {
                // $('#viewdatariwayat').html(data);
                // alert(no_registrasi);
                $('#titikKeluhan').removeClass('disabled');
                $('#submit_button').prop('disabled', false);
            }
        });

        var medrec_id = $(this).data('medrec_id');
        var patient_no = $(this).data('patient_no');
        var fullname = $(this).data('fullname');
        var birth_dt = $(this).data('birth_dt');
        var tahun = $(this).data('tahun');
        var bulan = $(this).data('bulan');
        var hari = $(this).data('hari');
        var gender = $(this).data('gender');
        var mobile_no = $(this).data('mobile_no');
        var nama_dokter = $(this).data('nama_dokter');
        var tujuan_registrasi_desc = $(this).data('tujuan_registrasi_desc');
        var type_pasien = $(this).data('type_pasien');
        var today = new Date();
        var no_kwitansi = $(this).data('no_kwitansi');
        var alergi = $(this).data('alergi');
        var flag_alergi = $(this).data('flag_alergi');
        if (flag_alergi == 'YES') {
            $('#modalAlergiBtn').removeClass("btn-default");
            $('#modalAlergiBtn').removeClass("btn-success");
            $('#modalAlergiBtn').addClass("btn-danger");
            $('#modalAlergiBtn').text("Ada Alergi");

        } else {
            $('#modalAlergiBtn').removeClass("btn-default");
            $('#modalAlergiBtn').removeClass("btn-danger");
            $('#modalAlergiBtn').addClass("btn-success");
            $('#modalAlergiBtn').text("Alergi");

        }

        // $('#no_registrasi').val(no_registrasi);
        $('#patient_no').val(patient_no);
        $('#fullname_tm').html(fullname);
        // $('#fullname').val(fullname);
        $('#tgl_pemeriksaan').val(today.toLocaleDateString("en-US"));
        $('#birth_dt_tm').html(convertDateIndo(birth_dt));
        $('#usia_tm').html('<b>' + tahun + '</b> Tahun, <b>' + bulan + '</b> Bulan, <b>' + hari + '</b> Hari');
        $('#tahun').html(tahun);
        $('#bulan').html(bulan);
        $('#gender_tm').html(gender);
        $('#mobile_no_tm').html(mobile_no);
        // $('#keluhan').val('');
        // $('#anamnesa').val('');
        $('#nama_dokter').html(nama_dokter);
        $('#tujuan_registrasi_desc').html(tujuan_registrasi_desc);
        $('#no_registrasi').html(no_registrasi);
        $('.medrec_id_info').html(patient_no);
        $('.medrec_id').val(patient_no);
        $('#type_pasien').html(type_pasien);
        // $('.tab-pane').show();
        $(".tab-pane").css("display", "");
        $('#alergi').val(alergi);
        $('.alergi').html(alergi);
        $('#no_kwitansi').val(no_kwitansi);


    });

    $(document).on('click', '.pilihregistrasi', function() {

        var tahun = $(this).data('tahun');
        var bulan = $(this).data('bulan');
        var hari = $(this).data('hari');
        var no_registrasi = $(this).data('no_registrasi');
        var tujuan_registrasi_desc = $(this).data('tujuan_registrasi_desc');
        var nama_dokter = $(this).data('nama_dokter');
        var nadi = $(this).data('nadi');
        var suhu = $(this).data('suhu');
        var nafas = $(this).data('nafas');
        var tekanan_darah = $(this).data('tekanan_darah');
        var tinggi_badan = $(this).data('tinggi_badan');
        var berat_badan = $(this).data('berat_badan');
        var keluhan_utama = $(this).data('keluhan_utama');
        var keluhan_sekunder = $(this).data('keluhan_sekunder');
        var diagnosa_utama = $(this).data('diagnosa_utama');
        var diagnosa_sekunder = $(this).data('diagnosa_sekunder');
        var diagnosa_note = $(this).data('diagnosa_note');
        var pf_rambut = $(this).data('pf_rambut');
        var pf_mata = $(this).data('pf_mata');
        var pf_telinga = $(this).data('pf_telinga');
        var pf_hidung = $(this).data('pf_hidung');
        var pf_tenggorokan = $(this).data('pf_tenggorokan');
        var photo = $(this).data('photo');


        $('#tahun_rm').html(tahun);
        $('#bulan_rm').html(bulan);
        $('#hari_rm').html(hari);
        $('#no_registrasi_rm').html(no_registrasi);
        $('#tujuan_registrasi_desc_rm').html(tujuan_registrasi_desc);
        $('#nama_dokter_rm').html(nama_dokter);
        $('#nadi_rm').html(nadi);
        $('#suhu_rm').html(suhu);
        $('#nafas_rm').html(nafas);
        $('#tekanan_darah_rm').html(tekanan_darah);
        $('#tinggi_badan_rm').html(tinggi_badan);
        $('#berat_badan_rm').html(berat_badan);
        $('#keluhan_utama_rm').html(keluhan_utama);
        $('#keluhan_sekunder_rm').html(keluhan_sekunder);
        $('#diagnosa_utama_rm').html(diagnosa_utama);
        $('#diagnosa_sekunder_rm').html(diagnosa_sekunder);
        $('#diagnosa_note_rm').html(diagnosa_note);
        $('#pf_rambut_rm').html(pf_rambut);
        $('#pf_mata_rm').html(pf_mata);
        $('#pf_telinga_rm').html(pf_telinga);
        $('#pf_hidung_rm').html(pf_hidung);
        $('#pf_tenggorokan_rm').html(pf_tenggorokan);
        $('#photo_rm').html(photo);
        $('.titikkeluhan').attr('src', '/assets/img/titikkeluhan/' + (photo !== '' ? photo : 'default') + '.jpg?' + new Date().getTime());
        $('#usia_rm').html('<b>' + tahun + '</b> Tahun, <b>' + bulan + '</b> Bulan, <b>' + hari + '</b> Hari');



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
                    if (response.error.reduksi_persen) {
                        $('#reduksi_persen').addClass('is-invalid');
                        $('.errorReduksi_persen').html(response.error.reduksi_persen);
                    } else {
                        $('#reduksi_persen').removeClass('is-invalid');
                        $('.errorReduksi_persen').html('');
                    }



                } else {
                    //sweet alert
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.success,
                        //footer: '<a href="">Why do I have this issue?</a>'
                    });

                    $(".tab-pane").css("display", "none");

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

                    $('#nadi').val('');
                    $('#suhu').val('');
                    $('#tekanan_darah').val('');
                    $('#tinggi_badan').val('');
                    $('#berat_badan').val('');
                    $('#nafas').val('');
                    $('#pf_rambut').val('');
                    $('#pf_telinga').val('');
                    $('#pf_mata').val('');
                    $('#pf_hidung').val('');
                    $('#pf_tenggorokan').val('');
                    $('#reduksi_persen').val('');

                    $('#keluhan_utama').val('');
                    $('#keluhan_sekunder').val('');
                    $('#diagnosa_note').val('');

                    $('.errorNadi').html('');
                    $('.errorSuhu').html('');
                    $('.errorTekanan_darah').html('');
                    $('.errorTinggi_badan').html('');
                    $('.errorBerat_badan').html('');
                    $('.errorNafas').html('');
                    $('.errorPf_rambut').html('');
                    $('.errorPf_telinga').html('');
                    $('.errorPf_mata').html('');
                    $('.errorPf_hidung').html('');
                    $('.errorPf_tenggorokan').html('');
                    $('.errorDiagnosa_utama').html('');
                    $('.errorDiagnosa_sekunder').html('');
                    $('.errorDiagnosa_note').html('');
                    $('.errorKeluhan_utama').html('');
                    $('.errorKeluhan_sekunder').html('');
                    $('.errorReduksi_persen').html('');

                    $('#nadi').removeClass('is-invalid');
                    $('#suhu').removeClass('is-invalid');
                    $('#tekanan_darah').removeClass('is-invalid');
                    $('#tinggi_badan').removeClass('is-invalid');
                    $('#berat_badan').removeClass('is-invalid');
                    $('#nafas').removeClass('is-invalid');
                    $('#pf_rambut').removeClass('is-invalid');
                    $('#pf_telinga').removeClass('is-invalid');
                    $('#pf_mata').removeClass('is-invalid');
                    $('#pf_hidung').removeClass('is-invalid');
                    $('#pf_tenggorokan').removeClass('is-invalid');
                    $('#keluhan_utama').removeClass('is-invalid');
                    $('#keluhan_sekunder').removeClass('is-invalid');
                    $('#diagnosa_note').removeClass('is-invalid');
                    $('#reduksi_persen').removeClass('is-invalid');




                    //select 2
                    $('#diagnosa_utama').val(' ');
                    $('#diagnosa_utama').trigger('change');
                    $('#diagnosa_sekunder').val(' ');
                    $('#diagnosa_sekunder').trigger('change');

                    $('.modal-title').text('Rekam Medis');
                    $('#submit_button').val('SIMPAN');
                    $('#submit_button').html('SIMPAN');

                    riwayatRm($('.medrec_id_info').text());
                    tregistrasi();

                }
            }
        })
    });

    $('#data_form2').on('submit', function(event) {

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

                    if (response.error.kategori_alergi) {
                        $('#kategori_alergi').addClass('is-invalid');
                        $('.errorKategori_alergi').html(response.error.kategori_alergi);
                    } else {
                        $('#kategori_alergi').removeClass('is-invalid');
                        $('.errorKategori_alergi').html('');
                    }
                    if (response.error.bahan_alergi) {
                        $('#bahan_alergi').addClass('is-invalid');
                        $('.errorBahan_alergi').html(response.error.bahan_alergi);
                    } else {
                        $('#bahan_alergi').removeClass('is-invalid');
                        $('.errorBahan_alergi').html('');
                    }
                    if (response.error.komponen_alergi) {
                        $('#komponen_alergi').addClass('is-invalid');
                        $('.errorKomponen_alergi').html(response.error.komponen_alergi);
                    } else {
                        $('#komponen_alergi').removeClass('is-invalid');
                        $('.errorKomponen_alergi').html('');
                    }
                    if (response.error.permulaan_dt) {
                        $('#permulaan_dt').addClass('is-invalid');
                        $('.errorPermulaan_dt').html(response.error.permulaan_dt);
                    } else {
                        $('#permulaan_dt').removeClass('is-invalid');
                        $('.errorPermulaan_dt').html('');
                    }
                    if (response.error.reaksi_alergi) {
                        $('#reaksi_alergi').addClass('is-invalid');
                        $('.errorReaksi_alergi').html(response.error.reaksi_alergi);
                    } else {
                        $('#reaksi_alergi').removeClass('is-invalid');
                        $('.errorReaksi_alergi').html('');
                    }
                    if (response.error.tingkat_kegawatan_alergi) {
                        $('#tingkat_kegawatan_alergi').addClass('is-invalid');
                        $('.errorTingkat_kegawatan_alergi').html(response.error.tingkat_kegawatan_alergi);
                    } else {
                        $('#tingkat_kegawatan_alergi').removeClass('is-invalid');
                        $('.errorTingkat_kegawatan_alergi').html('');
                    }
                    if (response.error.status_alergi) {
                        $('#status_alergi').addClass('is-invalid');
                        $('.errorStatus_alergi').html(response.error.status_alergi);
                    } else {
                        $('#status_alergi').removeClass('is-invalid');
                        $('.errorStatus_alergi').html('');
                    }
                    if (response.error.verifikasi_alergi) {
                        $('#verifikasi_alergi').addClass('is-invalid');
                        $('.errorVerifikasi_alergi').html(response.error.verifikasi_alergi);
                    } else {
                        $('#verifikasi_alergi').removeClass('is-invalid');
                        $('.errorVerifikasi_alergi').html('');
                    }
                    if (response.error.catatan) {
                        $('#catatan').addClass('is-invalid');
                        $('.errorCatatan').html(response.error.catatan);
                    } else {
                        $('#catatan').removeClass('is-invalid');
                        $('.errorCatatan').html('');
                    }


                } else {
                    //sweet alert
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.success,
                        //footer: '<a href="">Why do I have this issue?</a>'
                    });

                    //set input
                    $('#permulaan_dt').val('');

                    //set error validation
                    $('.errorPermulaan_dt').html('');
                    $('.errorKategori_alergi').html('');
                    $('.errorBahan_alergi').html('');
                    $('.errorKomponen_alergi').html('');
                    $('.errorReaksi_alergi').html('');
                    $('.errorTingkat_kegawatan_alergi').html('');
                    $('.errorStatus_alergi').html('');
                    $('.errorVerifikasi_alergi').html('');
                    $('.errorCatatan').html('');

                    //select 2
                    $('#kategori_alergi').val(' ');
                    $('#kategori_alergi').trigger('change');
                    $('#bahan_alergi').val(' ');
                    $('#bahan_alergi').trigger('change');
                    $('#komponen_alergi').val(' ');
                    $('#komponen_alergi').trigger('change');
                    $('#reaksi_alergi').val(' ');
                    $('#reaksi_alergi').trigger('change');
                    $('#tingkat_kegawatan_alergi').val(' ');
                    $('#tingkat_kegawatan_alergi').trigger('change');
                    $('#status_alergi').val(' ');
                    $('#status_alergi').trigger('change');
                    $('#verifikasi_alergi').val(' ');
                    $('#verifikasi_alergi').trigger('change');
                    $('#catatan').val(' ');
                    $('#catatan').trigger('change');

                    $('#submit_button2').val('SIMPAN');
                    $('#submit_button2').html('SIMPAN');

                    // riwayatRm($('.medrec_id_info').text());
                    // tregistrasi();

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

<script>
    $(document).ready(function() {

        $(document).on('click', '#modalAlergiBtn', function() {

            $('#modalAlergi').modal();


        });

        function formatResult(item) {
            //checks if the id present or not
            if (!item.id) {
                return item.text;
            }
            //return the format options..
            var element = $(`<span>${item.text}<span class="text_small">${item.username}</span></span>'`)
            return element;
        };
        $("#user_select").select2({
            ajax: {
                url: "<?= site_url('icdapi/ajax-search-icdn'); ?>",
                dataType: 'json',
                data: function(params) {
                    var query = {
                        search: params.term
                    }

                    // Query parameters will be ?search=[term]&type=user_search
                    return query;
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                }
            },
            cache: true,
            placeholder: 'Search for a user...',
            minimumInputLength: 1,
            templateResult: formatResult //your selection format
        });
    });
</script>

<script>
    $('#permulaan_dt').datepicker({
        todayHighlight: true,
        autoclose: true,
        dateFormat: 'MM/DD/YYYY'
    }).val();
</script>





<!-- Signature-pad.js -->
<!-- <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script> -->
<!-- <script type="text/javascript" src="<?= base_url('assets/js/signature-pad.js') ?>"></script> -->

<?= $this->endSection('script'); ?>