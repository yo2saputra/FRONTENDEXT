<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>

<!-- datepicker styles -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css">

<!-- summernote -->
<!-- <link rel="stylesheet" href="../../plugins/summernote/summernote-bs4.min.css"> -->

<style>
    ul {
        list-style-type: none;
    }

    .wrapper_m {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        /* grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); */
        grid-auto-rows: minmax(300px, auto);
        border: 1px solid #000;
    }

    .captions {
        background-color: #f1a983;
        font-weight: bold;
        text-align: center;
        padding: 7px;
        text-transform: uppercase;
    }

    .wrapper_m>div {
        background-color: #fff;
        padding: 1em;
    }
</style>

<style>
    /* CSS untuk Select2 */
    .select2-container .select2-selection--single {
        height: 30px !important;
        /* Atur tinggi */
        display: flex;
        align-items: center;
        /* Vertikal tengah */
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 30px !important;
        /* Atur tinggi teks */
        font-size: 12px !important;
        /* Atur ukuran font */
        /* text-align: center; */
        /* Horizontal tengah */
        margin-top: -2px !important;
        top: 0px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 30px !important;
        /* Atur tinggi panah */
    }

    /* CSS untuk Bootstrap 4 */
    .form-control {
        height: 30px;
        /* Atur tinggi */
        font-size: 12px;
        /* Atur ukuran font */
        display: flex;
        align-items: center;
        /* Vertikal tengah */

    }

    #overlay-riwayat-pemeriksaan {
        position: absolute;
        display: none;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 2;
        cursor: pointer;
    }

    #overlay-tes {
        position: absolute;
        display: none;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 2;
        cursor: pointer;
    }

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
        max-height: 20vh;
        margin-bottom: 10px;
        overflow-y: scroll;
        -webkit-overflow-scrolling: touch;
    }

    .list-group-a {
        max-height: 80vh;
        margin-bottom: 10px;
        overflow-y: scroll;
        -webkit-overflow-scrolling: touch;
    }

    .my-tbody {
        height: 60vh;
        display: content;
        overflow-y: scroll;
        /* width: 100%; */
    }

    .table-responsive {
        display: table;
    }

    /** tab custom */
    .nav-tabs.flex-column .nav-link {
        /* border-bottom-left-radius: 0.25rem;
        border-top-right-radius: 0;
        margin-right: -1px; */
        background-color: #f37038;
        margin-bottom: 0.3rem;
        color: white;
    }

    .nav-tabs.flex-column .nav-item.show .nav-link,
    .nav-tabs.flex-column .nav-link.active {
        border-color: #dee2e6 transparent #dee2e6 #dee2e6;
        background-color: green;
        color: white;
    }

    .nav-tabs.flex-column .nav-item.show .nav-link,
    .nav-tabs.flex-column .nav-link.active a {
        color: #fff;
    }

    /* sub tabs */
    .card-primary.card-outline-tabs>.card-header a.active,
    .card-primary.card-outline-tabs>.card-header a.active:hover {
        border-top: 3px solid #3f6791;
        background-color: green;
    }

    .nav-tabs .nav-link {
        margin-bottom: -1px;
        border: 1px solid transparent;
        border-top-left-radius: 0.25rem;
        border-top-right-radius: 0.25rem;
        background-color: #f37038;
        margin-right: 0.3rem;
    }

    .card.card-outline-tabs .card-header a {
        border-top: 3px solid transparent;
        color: white;
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
        font-size: 1rem;
        color: blue;
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
    <a class="nav-link text-md" data-widget="control-sidebar" data-slide="true" href="#" role="button" id="wheelChair">
        <i class="fas fa-wheelchair"></i>
    </a>
</li>

<?= $this->endSection('controlsidebaricon'); ?>

<?= $this->section('content'); ?>

<?php
$session = session();
?>

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
                <div class="col-md-12 header-info">
                    <div class="card bg-info" style="padding:2px;">
                        <div class="card-body" style="padding-top: 0.6rem !important;padding-right: 1rem !important;padding-bottom: 0.6rem !important;padding-left: 1rem !important;">
                            <div class="row">
                                <input type="hidden" id="alergi_array_length">
                                <input type="hidden" id="diagnosa_array_length">
                                <input type="hidden" id="biaya_array_length">
                                <input type="hidden" id="biaya_sub_array_length">
                                <div class="col-md-3">
                                    <dl>
                                        <dt class="caption_text">Nomor Registrasi </dt>
                                        <span id="no_registrasi" class="content_text">&nbsp;</span>
                                    </dl>
                                </div>
                                <div class="col-md-3">
                                    <dl>
                                        <dt class="caption_text">No. Rekam Medis</dt>
                                        <span class="content_text medrec_id_info">&nbsp;</span>
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
                                        <dt class="caption_text">Jaminan</dt>
                                        <span id="type_pasien" class="content_text">&nbsp;</span>
                                    </dl>
                                </div>
                                <div class="col-md-3">
                                    <dl>
                                        <dt class="caption_text">Riwayat Alergi</dt>
                                        <span id="birth_dt_tmx" class="content_text">&nbsp;</span>
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
        <div class="container-fluid" id="body-container" style="display: none;">
            <div class="row contents">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-5 col-sm-2">
                            <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link active" id="vert-tabs-one-tab" data-toggle="pill" href="#vert-tabs-one" role="tab" aria-controls="vert-tabs-one" aria-selected="true">PEMERIKSAAN SAAT INI</a>
                                <a class="nav-link" id="vert-tabs-two-tab" data-toggle="pill" href="#vert-tabs-two" role="tab" aria-controls="vert-tabs-two" aria-selected="false">RIWAYAT REKAM MEDIS</a>
                                <a class="nav-link" id="vert-tabs-thre-tab" data-toggle="pill" href="#vert-tabs-thre" role="tab" aria-controls="vert-tabs-thre" aria-selected="false">RIWAYAT RADIOLOGI</a>
                                <a class="nav-link" id="vert-tabs-four-tab" data-toggle="pill" href="#vert-tabs-four" role="tab" aria-controls="vert-tabs-four" aria-selected="false">RIWAYAT LABORATORIUM</a>
                                <a class="nav-link" id="vert-tabs-five-tab" data-toggle="pill" href="#vert-tabs-five" role="tab" aria-controls="vert-tabs-five" aria-selected="false">SURAT</a>
                            </div>
                        </div>
                        <div class="col-7 col-sm-10">
                            <div class="tab-content" id="vert-tabs-tabContent">
                                <div class="tab-pane text-left fade show active" id="vert-tabs-one" role="tabpanel" aria-labelledby="vert-tabs-one-tab">
                                    <div class="row">
                                        <div class="col-12">
                                            <h5>PEMERIKSAAN SAAT INI</h5>
                                        </div>
                                    </div>
                                    <form id="data_form_3">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-6">
                                                <div class="card card-primary card-outline card-outline-tabs">
                                                    <div class="card-header p-0 border-bottom-0">

                                                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">

                                                            <li class="nav-item">
                                                                <a class="nav-link active" id="custom-tabs-one-one2-tab" data-toggle="pill" href="#custom-tabs-one-one2" role="tab" aria-controls="custom-tabs-one-one2" aria-selected="false" tabindex="1">Anamnesa</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="custom-tabs-one-two2-tab" data-toggle="pill" href="#custom-tabs-one-two2" role="tab" aria-controls="custom-tabs-one-two2" aria-selected="false" tabindex="11">Pemeriksaan</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="custom-tabs-one-three2-tab" data-toggle="pill" href="#custom-tabs-one-three2" role="tab" aria-controls="custom-tabs-one-three2" aria-selected="false" tabindex="23">Diagnosa</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="custom-tabs-one-four2-tab" data-toggle="pill" href="#custom-tabs-one-four2" role="tab" aria-controls="custom-tabs-one-four2" aria-selected="false" tabindex="33">Tindakan & Biaya</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="custom-tabs-one-five2-tab" data-toggle="pill" href="#custom-tabs-one-five2" role="tab" aria-controls="custom-tabs-one-five2" aria-selected="false" tabindex="35">Rujuk & Resume</a>
                                                            </li>

                                                            <!-- Tombol yang membuka URL di tab baru -->
                                                            <li class="nav-item">
                                                                <a class="nav-link appointment">
                                                                    <!-- <i class="fas fa-plus"></i> Appointment -->Appointment
                                                                </a>
                                                            </li>



                                                        </ul>
                                                    </div>

                                                    <div class="card-body">
                                                        <div id="overlay-tes">
                                                            <div class="w-100 d-flex justify-content-center align-items-center">
                                                                <div class="spinner"></div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-content" id="custom-tabs-one-tabContent">

                                                            <div class="tab-pane fade show active" id="custom-tabs-one-one2" role="tabpanel" aria-labelledby="custom-tabs-one-one2-tab">
                                                                <div class="col-sm-12">

                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <!-- .card -->
                                                                            <div class="card ">
                                                                                <!-- <div class="card-header">
                                                                                        <h3 class="card-title">Pemeriksaan & Tindakan</h3>
                                                                                    </div> -->
                                                                                <!-- /.card-header -->
                                                                                <div class="card-body">

                                                                                    <div class="row">
                                                                                        <div class="col-sm-6">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-12">
                                                                                                    <label>Responden</label>
                                                                                                    <br>
                                                                                                    <div class="form-group d-flex justify-content-between align-items-center">

                                                                                                        <div class="form-check-inline">
                                                                                                            <label class="form-check-label">
                                                                                                                <input class="responden" type="radio" class="form-check-input" name="responden" value="1" tabindex="2">Autoanamnesis
                                                                                                            </label>
                                                                                                        </div>
                                                                                                        <div class="form-check-inline">
                                                                                                            <label class="form-check-label">
                                                                                                                <input class="responden" type="radio" class="form-check-input" name="responden" value="0" tabindex="3">Alloanamnesis
                                                                                                            </label>
                                                                                                        </div>

                                                                                                        <br>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <div class="col-sm-12">
                                                                                                    <!-- textarea -->
                                                                                                    <div class="form-group">
                                                                                                        <label>Keluhan Utama</label>
                                                                                                        <textarea class="form-control" name="keluhan_utama" rows="3" placeholder="Enter ..." id="keluhan_utama" tabindex="3"></textarea>
                                                                                                        <span class="error invalid-feedback errorKeluhan_utama">
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <div class="col-sm-12">
                                                                                                    <!-- textarea -->
                                                                                                    <div class="form-group">
                                                                                                        <label>Riwayat Perjalanan Keluhan</label>
                                                                                                        <textarea class="form-control" name="riwayat_perjalanan_keluhan" rows="3" placeholder="Enter ..." id="riwayat_perjalanan_keluhan" tabindex="5"></textarea>
                                                                                                        <span class="error invalid-feedback errorRiwayat_perjalanan_keluhan">
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row" style="display: none;">
                                                                                                <div class="col-sm-12">
                                                                                                    <!-- textarea -->
                                                                                                    <div class="form-group">
                                                                                                        <label>Riwayat Penyakit Sekarang - HAPUSSS</label>
                                                                                                        <textarea class="form-control" name="riwayat_penyakit_sekarang" rows="3" placeholder="Enter ..." id="riwayat_penyakit_sekarang" tabindex=""></textarea>
                                                                                                        <span class="error invalid-feedback errorRiwayat_penyakit_sekarang">
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <div class="col-sm-12">
                                                                                                    <!-- textarea -->
                                                                                                    <div class="form-group">
                                                                                                        <label>Riwayat Penyakit Dahulu</label>
                                                                                                        <textarea class="form-control" name="riwayat_penyakit_dahulu" rows="3" placeholder="Enter ..." id="riwayat_penyakit_dahulu" tabindex="6"></textarea>
                                                                                                        <span class="error invalid-feedback errorRiwayat_penyakit_dahulu">
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>


                                                                                        </div>
                                                                                        <div class="col-sm-6">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-12">
                                                                                                    <label></label>
                                                                                                    <br>
                                                                                                    <div class="col-sm text-center">
                                                                                                        <a href="#" id="modalCopyAnamnesaBtn" class="btn btn-xs btn-primary float-right ml-2" tabindex="7">Salin Dari</a>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="row" style="margin-top: 1.1rem;">
                                                                                                <div class="col-sm-12">
                                                                                                    <!-- textarea -->
                                                                                                    <div class="form-group">
                                                                                                        <label>Riwayat Operasi / Pengobatan</label>
                                                                                                        <textarea class="form-control" name="riwayat_operasi_pengobatan" rows="3" placeholder="Enter ..." id="riwayat_operasi_pengobatan" tabindex="8"></textarea>
                                                                                                        <span class="error invalid-feedback errorRiwayat_operasi_pengobatan">
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <div class="col-sm-12">
                                                                                                    <!-- textarea -->
                                                                                                    <div class="form-group">
                                                                                                        <label>Riwayat Penyakit Keluarga</label>
                                                                                                        <textarea class="form-control" name="riwayat_penyakit_keluarga" rows="3" placeholder="Enter ..." id="riwayat_penyakit_keluarga" tabindex="9"></textarea>
                                                                                                        <span class="error invalid-feedback errorRiwayat_penyakit_keluarga">
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <div class="col-sm-12">
                                                                                                    <!-- textarea -->
                                                                                                    <div class="form-group">
                                                                                                        <label>Riwayat Lain - lain</label>
                                                                                                        <textarea class="form-control" name="riwayat_lain" rows="3" placeholder="Enter ..." id="riwayat_lain" tabindex="10"></textarea>
                                                                                                        <span class="error invalid-feedback errorRiwayat_lain">
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>

                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="row">
                                                                                        <div class="col-sm-12">
                                                                                            <button type="button" name="add_alergi" id="add_alergi" class="btn btn-xs btn-success float-right mb-2">Add Alergi</button>
                                                                                            <!-- textarea -->
                                                                                            <div class="form-group">
                                                                                                <label>Riwayat Alergi</label>
                                                                                            </div>
                                                                                            <div style="height:250px;overflow-y: scroll;">
                                                                                                <table class="table table-head-fixed table-border table-sm" id="dynamic_alergi">
                                                                                                    <thead>
                                                                                                        <tr>
                                                                                                            <th>Jenis</th>
                                                                                                            <th>Komponen1</th>
                                                                                                            <th>Reaksi1</th>
                                                                                                            <th></th>
                                                                                                        </tr>
                                                                                                    </thead>
                                                                                                    <tbody>
                                                                                                        <span id="viewdataalergi"></span>
                                                                                                    </tbody>

                                                                                                </table>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                                <!-- /.card-body -->
                                                                            </div>
                                                                            <!-- /.card -->
                                                                        </div>
                                                                    </div>


                                                                </div>
                                                            </div>
                                                            <div class="tab-pane fade" id="custom-tabs-one-two2" role="tabpanel" aria-labelledby="custom-tabs-one-two2-tab">
                                                                <div class="col-sm-12">

                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <!-- .card -->
                                                                            <div class="card ">
                                                                                <!-- <div class="card-header">
                                                                                        <h3 class="card-title">Pemeriksaan & Tindakan</h3>
                                                                                    </div> -->
                                                                                <!-- /.card-header -->
                                                                                <div class="card-body">
                                                                                    <div class="row">
                                                                                        <div class="col-sm-8">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-12">
                                                                                                    <!-- text input -->
                                                                                                    <div class="form-group">
                                                                                                        <label>Kondisi Umum</label>
                                                                                                        <input type="text" name="kondisi_umum" class="form-control" placeholder="" id="kondisi_umum" tabindex="11">
                                                                                                        <span class="error invalid-feedback errorKondisi_umum">
                                                                                                        </span>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <div class="col-sm-12">
                                                                                                    <div class="row">
                                                                                                        <div class="col-sm-3">
                                                                                                            <!-- text input -->
                                                                                                            <div class="form-group">
                                                                                                                <label>Tinggi (cm)</label>
                                                                                                                <input type="number" name="tinggi_badan" class="form-control" placeholder="" id="tinggi_badan" min="0" tabindex="12">
                                                                                                                <span class="error invalid-feedback errorTinggi_badan">
                                                                                                                </span>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="col-sm-3">
                                                                                                            <!-- text input -->
                                                                                                            <div class="form-group">
                                                                                                                <label>Berat (kg)</label>
                                                                                                                <input type="number" name="berat_badan" class="form-control" placeholder="" id="berat_badan" min="0" tabindex="15">
                                                                                                                <span class="error invalid-feedback errorBerat_badan">
                                                                                                                </span>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="col-sm-3">
                                                                                                            <!-- text input -->
                                                                                                            <div class="form-group">
                                                                                                                <label>BMI (kg/m2)</label>
                                                                                                                <input type="number" name="bmi" class="form-control" placeholder="" id="bmi" tabindex="14" disabled>
                                                                                                                <span class="error invalid-feedback errorBmi">
                                                                                                                </span>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="col-sm-3">
                                                                                                            <!-- text input -->
                                                                                                            <div class="form-group">
                                                                                                                <label>Suhu (&deg;c)</label>
                                                                                                                <input type="number" name="suhu" class="form-control" placeholder="" id="suhu" min="1" tabindex="18">
                                                                                                                <span class="error invalid-feedback errorSuhu">
                                                                                                                </span>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="row">
                                                                                                        <div class="col-sm-3">
                                                                                                            <!-- text input -->
                                                                                                            <div class="form-group">
                                                                                                                <label>Sistolik (mmHg)</label>
                                                                                                                <input type="number" name="sistolik" class="form-control" placeholder="" id="sistolik" min="1" tabindex="13">
                                                                                                                <span class="error invalid-feedback errorSistolik">
                                                                                                                </span>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="col-sm-3">
                                                                                                            <!-- text input -->
                                                                                                            <div class="form-group">
                                                                                                                <label>Diastolik (mmHg)</label>
                                                                                                                <input type="number" name="diastolik" class="form-control" placeholder="" id="diastolik" min="1" tabindex="16">
                                                                                                                <span class="error invalid-feedback errorDiastolik">
                                                                                                                </span>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="col-sm-3">
                                                                                                            <div class="form-group">
                                                                                                                <label>Nadi (bpm)</label>
                                                                                                                <input type="number" name="denyut_nadi" class="form-control" placeholder="" id="denyut_nadi" min="1" tabindex="17">
                                                                                                                <span class="error invalid-feedback errorDenyut_nadi">
                                                                                                                </span>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="col-sm-3">
                                                                                                            <div class="form-group">
                                                                                                                <label>Pernafasan (rpm)</label>
                                                                                                                <input type="number" name="laju_nafas" class="form-control" placeholder="" id="laju_nafas" min="1" tabindex="19">
                                                                                                                <span class="error invalid-feedback errorLaju_nafas">
                                                                                                                </span>
                                                                                                            </div>
                                                                                                        </div>

                                                                                                    </div>


                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <div class="col-sm-12">
                                                                                                    <!-- textarea -->
                                                                                                    <div class="form-group">
                                                                                                        <label>Status Lokalis</label>
                                                                                                        <textarea class="form-control" name="kondisi_khusus" rows="5" placeholder="Enter ..." id="kondisi_khusus" tabindex="20"></textarea>
                                                                                                        <span class="error invalid-feedback errorKondisi_khusus">
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <div class="col-sm-12">
                                                                                                    <!-- textarea -->
                                                                                                    <div class="form-group">
                                                                                                        <label>Pemeriksaan Tambahan</label>
                                                                                                        <textarea class="form-control" name="pemeriksaan_tambahan" rows="5" placeholder="Enter ..." id="pemeriksaan_tambahan" tabindex="21"></textarea>
                                                                                                        <span class="error invalid-feedback errorPemeriksaan_tambahan">
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-sm-4">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-12">
                                                                                                    <div class="form-group">
                                                                                                        <label>Titik Keluhan</label>
                                                                                                        <select class="form-control form-control-sm select2 titi" name="name1" id="titikKeluhan" style="width: 100%; heigh:100%;" tabindex="22">
                                                                                                            <option selected>-- Select --</option>
                                                                                                            <option value="Head">Head</option>
                                                                                                            <option value="Breast">Breast</option>
                                                                                                            <option value="Dental">Dental</option>
                                                                                                            <option value="RectumAnalCanal">Rectum Anal Canal</option>
                                                                                                            <option value="Wajah">Wajah</option>
                                                                                                            <option value="Wajah2">Wajah 2</option>
                                                                                                            <option value="Blank">Blank</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <div class="col-sm-12">
                                                                                                    <div class="card card-info">
                                                                                                        <div class="card-header">

                                                                                                            <h3 class="card-title">
                                                                                                                <!-- <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                                                                                                                </button> -->
                                                                                                                <button type="button" class="btn btn-tool refreshTitikKeluhan" data-card-widget="" data-no_registrasi="REG240600207"><i id="refreshBtn" class="fas fa-sync-alt"></i>
                                                                                                                </button>

                                                                                                            </h3>
                                                                                                            <div class="card-tools" style="margin: 0rem 0rem 0rem !important;">
                                                                                                                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                                                                                                                </button>
                                                                                                            </div>
                                                                                                        </div>

                                                                                                        <div class="card-body" style="height: 62.5vh; overflow-y: scroll;">

                                                                                                            <!-- <img src="" class="img-fluid titikkeluhan rounded mx-auto d-block" height="250px" alt=""> -->

                                                                                                            <div id="printcard"></div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- /.card-body -->
                                                                            </div>
                                                                            <!-- /.card -->
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="tab-pane fade" id="custom-tabs-one-three2" role="tabpanel" aria-labelledby="custom-tabs-one-three2-tab">
                                                                <div class="col-sm-12">

                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <!-- .card -->
                                                                            <div class="card ">
                                                                                <!-- <div class="card-header">
                                                                                        <h3 class="card-title">Pemeriksaan & Tindakan</h3>
                                                                                    </div> -->
                                                                                <!-- /.card-header -->
                                                                                <div class="card-body">
                                                                                    <div class="row">
                                                                                        <div class="col-sm-12">
                                                                                            <button type="button" name="add" id="add" class="btn btn-xs btn-success float-right mb-2" tabindex="32">Add More</button>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-sm-6">
                                                                                            <div class="card ">
                                                                                                <div class="card-body">
                                                                                                    <div class="row">
                                                                                                        <div class="col-sm-12">
                                                                                                            <!-- text input -->
                                                                                                            <div class="form-group">
                                                                                                                <label>Diagnosa 1</label>
                                                                                                                <input type="text" name="diagnosa_utama" class="form-control" placeholder="" id="diagnosa_utama" tabindex="24">
                                                                                                                <span class="error invalid-feedback errorDiagnosa_utama">
                                                                                                                </span>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="row">
                                                                                                        <div class="col-sm-12">
                                                                                                            <label>ICD 10</label>
                                                                                                            <!-- textarea -->
                                                                                                            <div class="form-group">
                                                                                                                <select class="form-control form-control-sm" name="icd10_utama" id="icd10_utama" tabindex="25">
                                                                                                                    <option value=" " selected="selected">-- Select --</option>
                                                                                                                </select>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="row">
                                                                                                        <div class="col-sm-12">
                                                                                                            <label></label>
                                                                                                            <br>
                                                                                                            <div class="form-group d-flex justify-content-between align-items-center">

                                                                                                                <div class="form-check-inline">
                                                                                                                    <label class="form-check-label">
                                                                                                                        <input type="radio" class="form-check-input" name="klasifikasi_utama" value="terduga" tabindex="26" checked>Terduga
                                                                                                                    </label>
                                                                                                                </div>
                                                                                                                <div class="form-check-inline">
                                                                                                                    <label class="form-check-label">
                                                                                                                        <input type="radio" class="form-check-input" name="klasifikasi_utama" value="gejala" tabindex="">Gejala
                                                                                                                    </label>
                                                                                                                </div>
                                                                                                                <div class="form-check-inline">
                                                                                                                    <label class="form-check-label">
                                                                                                                        <input type="radio" class="form-check-input" name="klasifikasi_utama" value="dikonfirmasi" tabindex="">Sudah Dikonfirmasi
                                                                                                                    </label>
                                                                                                                </div>

                                                                                                                <br>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="card ">
                                                                                                <div class="card-body">
                                                                                                    <div class="row">
                                                                                                        <div class="col-sm-12">
                                                                                                            <!-- text input -->
                                                                                                            <div class="form-group">
                                                                                                                <label>Diagnosa 2</label>
                                                                                                                <input type="text" name="diagnosa_sekunder" class="form-control" placeholder="" id="diagnosa_sekunder" tabindex="27">
                                                                                                                <span class="error invalid-feedback errorDiagnosa_sekunder">
                                                                                                                </span>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="row">
                                                                                                        <div class="col-sm-12">
                                                                                                            <label>ICD 10 </label>
                                                                                                            <!-- textarea -->
                                                                                                            <div class="form-group">
                                                                                                                <select class="form-control form-control-sm icd10_sekunder" name="icd10_sekunder" id="icd10_sekunder" tabindex="28">
                                                                                                                    <option value=" " selected="selected">-- Select --</option>
                                                                                                                </select>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="row">
                                                                                                        <div class="col-sm-12">
                                                                                                            <label></label>
                                                                                                            <br>
                                                                                                            <div class="form-group d-flex justify-content-between align-items-center">

                                                                                                                <div class="form-check-inline">
                                                                                                                    <label class="form-check-label">
                                                                                                                        <input type="radio" class="form-check-input" name="klasifikasi_sekunder" value="terduga" tabindex="29" checked>Terduga
                                                                                                                    </label>
                                                                                                                </div>
                                                                                                                <div class="form-check-inline">
                                                                                                                    <label class="form-check-label">
                                                                                                                        <input type="radio" class="form-check-input" name="klasifikasi_sekunder" value="gejala" tabindex="30">Gejala
                                                                                                                    </label>
                                                                                                                </div>
                                                                                                                <div class="form-check-inline">
                                                                                                                    <label class="form-check-label">
                                                                                                                        <input type="radio" class="form-check-input" name="klasifikasi_sekunder" value="dikonfirmasi" tabindex="31">Sudah Dikonfirmasi
                                                                                                                    </label>
                                                                                                                </div>

                                                                                                                <br>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-sm-6">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-12">
                                                                                                    <div class="card card-info">
                                                                                                        <!-- <div class="card-header">

                                                                                                            <h3 class="card-title">
                                                                                                                <button type="button" class="btn btn-tool refreshTitikKeluhan" data-card-widget="" data-no_registrasi="REG240600207"><i id="refreshBtn" class="fas fa-sync-alt"></i>
                                                                                                                </button>

                                                                                                            </h3>
                                                                                                            <div class="card-tools" style="margin: 0rem 0rem 0rem !important;">
                                                                                                                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                                                                                                                </button>
                                                                                                            </div>
                                                                                                        </div> -->

                                                                                                        <div class="card-body" style="height: 80vh; overflow-y: scroll;" id="dynamic_field">

                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- /.card-body -->
                                                                            </div>
                                                                            <!-- /.card -->
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="tab-pane fade" id="custom-tabs-one-four2" role="tabpanel" aria-labelledby="custom-tabs-one-four2-tab">
                                                                <div class="card card-info">

                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                                <div class="row">
                                                                                    <div class="col-sm-8">
                                                                                    </div>
                                                                                    <div class="col-sm-4">
                                                                                        <h2 class="text-right" id="grand_total">Rp. 0,00</h2>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">

                                                                                    <div class="col-sm-8">
                                                                                        <button type="button" name="add" id="modalTindakanRow" class="btn btn-xs btn-success mb-2" tabindex="34">Input Order</button>
                                                                                        <!-- <button type="button" name="add" id="modalFarmasiRow" class="btn btn-xs btn-success float-right">test 2</button> -->
                                                                                    </div>
                                                                                    <div class="col-sm-4">
                                                                                    </div>
                                                                                </div>

                                                                                <div style="height:190px;overflow-y: scroll;">
                                                                                    <table class="table table-head-fixed table-border table-sm" width="100%" id="dynamic_biaya">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th width="13%">Layanan</th>
                                                                                                <th width="35%">Item</th>
                                                                                                <th width="7%">Qty</th>
                                                                                                <th width="15%">Amount</th>
                                                                                                <th width="15%">Total</th>
                                                                                                <th width="15%"></th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            <span id="viewdatabiaya"></span>
                                                                                        </tbody>

                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <br>

                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                                <!-- <button type="button" name="add" id="add" class="btn btn-xs btn-success float-right mb-2">Add</button>
                                                                        <table class="table table-stripe table-bordered">
                                                                            <tr>
                                                                                <th>Layanan</th>
                                                                                <th>Item Layanan</th>
                                                                                <th>Amount</th>
                                                                                <th></th>
                                                                            </tr>
                                                                            <tr id="modalTindakanRow">
                                                                                <td>Tindakan</td>
                                                                                <td>Ganti Perban</td>
                                                                                <td>1</td>
                                                                                <td><button type="button" name="add" id="add" class="btn btn-xs btn-success float-right"><i class="far fas fa-edit"></i></button><button type="button" name="delete" id="delete" class="btn btn-xs btn-success float-right"><i class="fas fa-minus"></i></button></td>
                                                                            </tr>
                                                                            <tr id="modalFarmasiRow">
                                                                                <td>Farmasi</td>
                                                                                <td>Obat2an</td>
                                                                                <td>1</td>
                                                                            </tr>
                                                                            <tr id="modalRadiologiRow">
                                                                                <td>Radiologi</td>
                                                                                <td></td>
                                                                                <td>1</td>
                                                                            </tr>
                                                                            <tr id="modalLaboratoriumRow">
                                                                                <td>Laboratorium</td>
                                                                                <td></td>
                                                                                <td>1</td>
                                                                            </tr>
                                                                            <tr id="modalMcuRow">
                                                                                <td>MCU</td>
                                                                                <td></td>
                                                                                <td>1</td>
                                                                            </tr>
                                                                        </table> -->




                                                                                <!-- Modal -->
                                                                                <div class="modal fade" id="modalTindakan" tabindex=" " role="dialog" aria-labelledby="modalTindakanLabel" aria-hidden="true">
                                                                                    <div class="modal-dialog modal-lg" role="document">
                                                                                        <div class="modal-content">

                                                                                            <div class="modal-header">
                                                                                                <h5 class="modal-title" id="modalTindakanLabel"></h5>
                                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                    <span aria-hidden="true">&times;</span>
                                                                                                </button>
                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                                <div class="col-12 col-sm-12">
                                                                                                    <div class="row">
                                                                                                        <div class="col-sm-12">
                                                                                                            <!-- textarea -->
                                                                                                            <div class="form-group">
                                                                                                                <label>Jenis Layanan</label>
                                                                                                                <?= $cb_layanan ?>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="row">
                                                                                                        <div class="col-sm-12">
                                                                                                            <div class="card">
                                                                                                                <div class="card-body">
                                                                                                                    <div class="mb-3 row" id="block_item">
                                                                                                                        <label for="item" class="col-sm-2 col-form-label">Item</label>
                                                                                                                        <div class="col-sm-10">
                                                                                                                            <span id="dropdown_layananitem"></span>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <div class="mb-3 row" id="block_takaran">
                                                                                                                        <label for="takaran" class="col-sm-2 col-form-label">Takaran</label>
                                                                                                                        <div class="col-sm-4">
                                                                                                                            <input type="number" class="form-control form-control-sm" dir="rtl" id="takaran" name="takaran">
                                                                                                                            <span class="error invalid-feedback errorNama">
                                                                                                                            </span>
                                                                                                                        </div>
                                                                                                                        <label for="hari" class="col-sm-2 col-form-label">Hari</label>
                                                                                                                        <div class="col-sm-4">
                                                                                                                            <input type="number" class="form-control form-control-sm" dir="rtl" id="hari" name="hari">
                                                                                                                            <span class="error invalid-feedback errorValue">
                                                                                                                            </span>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <div class="mb-3 row" id="block_frekuensi">
                                                                                                                        <label for="frekuensi" class="col-sm-2 col-form-label">Frekuensi</label>
                                                                                                                        <div class="col-sm-4">
                                                                                                                            <input type="number" class="form-control form-control-sm" dir="rtl" id="frekuensi" name="frekuensi">
                                                                                                                            <span class="error invalid-feedback errorDesc">
                                                                                                                            </span>
                                                                                                                        </div>
                                                                                                                        <label for="pemakaian" class="col-sm-2 col-form-label">Petunjuk</label>
                                                                                                                        <div class="col-sm-4">
                                                                                                                            <input type="text" class="form-control form-control-sm" id="pemakaian" name="pemakaian">
                                                                                                                            <span class="error invalid-feedback errorDesc">
                                                                                                                            </span>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <div class="mb-3 row" id="block_kuantitas">
                                                                                                                        <label for="kuantitas" class="col-sm-2 col-form-label">Qty</label>
                                                                                                                        <div class="col-sm-4">
                                                                                                                            <input type="text" class="form-control form-control-sm" dir="rtl" id="kuantitas" name="kuantitas">
                                                                                                                            <span class="error invalid-feedback errorKuantitas">
                                                                                                                            </span>
                                                                                                                        </div>
                                                                                                                        <div class="col-sm-6"></div>
                                                                                                                    </div>
                                                                                                                    <div class="mb-3 row" id="block_harga">
                                                                                                                        <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                                                                                                                        <div class="col-sm-4">
                                                                                                                            <input type="text" class="form-control form-control-sm num" dir="rtl" value="0,00" id="harga" name="harga" readonly>
                                                                                                                            <span class="error invalid-feedback errorHarga">
                                                                                                                            </span>
                                                                                                                        </div>
                                                                                                                        <label for="bagihasil" class="col-sm-2 col-form-label block_bagihasil" style="display: none;">Bagihasil User</label>
                                                                                                                        <div class="col-sm-4 block_bagihasil" style="display: none;">
                                                                                                                            <input type="text" class="form-control form-control-sm num" dir="rtl" value="0,00" id="bagihasil" name="bagihasil" readonly>
                                                                                                                        </div>
                                                                                                                    </div>

                                                                                                                    <div class=" row" id="block_diskon" style="display: none;">

                                                                                                                        <label for="diskon" class="col-sm-2 col-form-label">Diskon</label>

                                                                                                                        <div class="col-sm-1">
                                                                                                                            <a class="nav-link" data-widget="customSwitch" data-controlsidebar-slide="true" href="#" role="button">
                                                                                                                                <div class="form-group">
                                                                                                                                    <div class="custom-control custom-switch">
                                                                                                                                        <input type="checkbox" class="custom-control-input" id="customSwitch" style="display:none">
                                                                                                                                        <label class="custom-control-label" for="customSwitch"></label>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </a>
                                                                                                                        </div>

                                                                                                                        <div class="col-sm-3">
                                                                                                                            <input type="text" class="form-control form-control-sm" dir="rtl" id="diskon" name="diskon" min="0" readonly>
                                                                                                                            <span class="error invalid-feedback errorNama">
                                                                                                                            </span>
                                                                                                                        </div>

                                                                                                                        <label for="bagihasil_setelah" class="col-sm-2 col-form-label">BSU Setelah Diskon</label>
                                                                                                                        <div class="col-sm-4">
                                                                                                                            <input type="text" class="form-control form-control-sm num" value="0,00" dir="rtl" id="bagihasil_setelah" name="bagihasil_setelah" min="0" readonly>
                                                                                                                            <span class="error invalid-feedback errorBagi_hasil">
                                                                                                                            </span>
                                                                                                                        </div>
                                                                                                                    </div>

                                                                                                                    <div class="mb-3 row" id="block_harganormal" style="display: none;">
                                                                                                                        <label for="harga_normal" class="col-sm-2 col-form-label">Harga Normal</label>
                                                                                                                        <div class="col-sm-4">
                                                                                                                            <input type="text" class="form-control form-control-sm num" value="0,00" dir="rtl" id="harga_normal" name="harga_normal" disabled>
                                                                                                                        </div>
                                                                                                                        <label for="harga_order" class="col-sm-2 col-form-label block_hargaorder" style="display: none;">Harga Order</label>
                                                                                                                        <div class="col-sm-4 block_hargaorder" style="display: none;">
                                                                                                                            <input type="text" class="form-control form-control-sm num" value="0,00" dir="rtl" id="harga_order" name="harga_order" disabled>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <input type="hidden" id="pengurang">

                                                                                                                    <div class="mb-3 row" id="block_btn_laboratorium" style="display: none;">
                                                                                                                        <div class="col-sm-12">
                                                                                                                            <center><button type="button" id="modalLaboratoriumRow" class="btn btn-lg btn-success">Form Laboratorium</button></center>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <div class="mb-3 row" id="block_btn_medicalcheckup" style="display: none;">
                                                                                                                        <div class="col-sm-12">
                                                                                                                            <center><button type="button" id="modalFarmasiRow" class="btn btn-lg btn-success">Medical Check-Up</button></center>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <div class="mb-3 row" id="block_btn_radiologi" style="display: none;">
                                                                                                                        <div class="col-sm-12">
                                                                                                                            <center><button type="button" id="modalRadiologiRow" class="btn btn-lg btn-success">Form Radiologi</button></center>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="modal-footer">
                                                                                                <button type="button" name="add_header_biaya" id="add_header_biaya" class="btn btn-md btn-success mb-2 float-right">SAVE</button>
                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- /end modal -->

                                                                                <!-- Modal -->
                                                                                <div class="modal fade" id="modalFarmasi" tabindex=" " role="dialog" aria-labelledby="modalFarmasiLabel" aria-hidden="true">
                                                                                    <div class="modal-dialog modal-xl" role="document">
                                                                                        <div class="modal-content">

                                                                                            <div class="modal-header">
                                                                                                <h5 class="modal-title" id="modalFarmasiLabel"></h5>
                                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                    <span aria-hidden="true">&times;</span>
                                                                                                </button>
                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                                <div class="col-12 col-sm-12">
                                                                                                    <div class="row">
                                                                                                        <div class="col-sm-12">
                                                                                                            <div class="row">
                                                                                                                <div class="farmasi_wrapper_m" id="farmasi_wrapper_m"></div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <!-- <div class="modal-footer">
                                                                                        <button id="btnclose" type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                                                                                        </div> -->

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <!-- /end modal -->

                                                                            <!-- Modal -->
                                                                            <div class="modal fade" id="modalRadiologi" tabindex=" " role="dialog" aria-labelledby="modalRadiologiLabel" aria-hidden="true">
                                                                                <div class="modal-dialog modal-xl" role="document">
                                                                                    <div class="modal-content">

                                                                                        <div class="modal-header">
                                                                                            <h5 class="modal-title" id="modalRadiologiLabel">Radiologi</h5>
                                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                <span aria-hidden="true">&times;</span>
                                                                                            </button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <div class="col-12 col-sm-12">
                                                                                                <div class="row">
                                                                                                    <div class="col-sm-12">
                                                                                                        <div class="row">
                                                                                                            <div class="wrapper_m" id="radiologi_wrapper_m"></div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <!-- <div class="modal-footer">
                                                                                        <button id="btnclose" type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                                                                                    </div> -->

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <!-- /end modal -->

                                                                            <!-- Modal -->
                                                                            <div class="modal fade" id="modalLaboratorium" tabindex=" " role="dialog" aria-labelledby="modalLaboratoriumLabel" aria-hidden="true">
                                                                                <div class="modal-dialog modal-xl" role="document">
                                                                                    <div class="modal-content">

                                                                                        <div class="modal-header">
                                                                                            <h5 class="modal-title" id="modalLaboratoriumLabel">Laboratorium</h5>
                                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                <span aria-hidden="true">&times;</span>
                                                                                            </button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <div class="col-12 col-sm-12">
                                                                                                <div class="row">
                                                                                                    <div class="col-sm-12">
                                                                                                        <div class="row">
                                                                                                            <div class="wrapper_m" id="lab_wrapper_m"></div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <!-- <div class="modal-footer">
                                                                                        <button id="btnclose" type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                                                                                    </div> -->

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <!-- /end modal -->

                                                                            <!-- Modal -->
                                                                            <div class="modal fade" id="modalMcu" tabindex=" " role="dialog" aria-labelledby="modalMcuLabel" aria-hidden="true">
                                                                                <div class="modal-dialog modal-xl" role="document">
                                                                                    <div class="modal-content">

                                                                                        <div class="modal-header">
                                                                                            <h5 class="modal-title" id="modalMcuLabel">Medical Check-Up</h5>
                                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                <span aria-hidden="true">&times;</span>
                                                                                            </button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <div class="col-12 col-sm-12">
                                                                                                <div class="row">
                                                                                                    <div class="col-sm-12">
                                                                                                        <div class="row">
                                                                                                            <table class="table table-stripe table-bordered">
                                                                                                                <tr>
                                                                                                                    <th>Layanan</th>
                                                                                                                    <th>Item Layanan</th>
                                                                                                                    <th>Amount</th>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td>Tindakan</td>
                                                                                                                    <td>Ganti Perban</td>
                                                                                                                    <td>1</td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td>Farmasi</td>
                                                                                                                    <td>Obat2an</td>
                                                                                                                    <td>1</td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td>Radiologi</td>
                                                                                                                    <td></td>
                                                                                                                    <td>1</td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td>Laboratorium</td>
                                                                                                                    <td></td>
                                                                                                                    <td>1</td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td>MCU</td>
                                                                                                                    <td></td>
                                                                                                                    <td>1</td>
                                                                                                                </tr>
                                                                                                            </table>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <!-- <div class="modal-footer">
                                                                                        <button id="btnclose" type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                                                                                    </div> -->

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <!-- /end modal -->

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <input type="hidden" id="action_all" name="action_all" value="Add" />
                                                            <input type="hidden" id="new" name="new" />
                                                            <input type="hidden" id="patient_no" name="patient_no" />
                                                            <input type="hidden" class="no_registrasi" name="no_registrasi" />
                                                            <input type="hidden" id="diagnosa_utama_sta" name="diagnosa_utama_sta" value="n" />
                                                            <input type="hidden" id="diagnosa_sekunder_sta" name="diagnosa_sekunder_sta" value="n" />


                                    </form>
                                    <div class="tab-pane fade" id="custom-tabs-one-five2" role="tabpanel" aria-labelledby="custom-tabs-one-five2-tab">

                                        <div class="row">
                                            <br>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <!-- <form id="data_form_rujukan"> -->
                                                <div class="row">
                                                    <div class="col-sm-9">
                                                        <!-- textarea -->
                                                        <div class="form-group">
                                                            <label>Keterangan Rujukan</label>
                                                            <textarea class="form-control form1" name="ket_rujukan" rows="5" placeholder="Enter ..." id="ket_rujukan" tabindex="36"></textarea>
                                                            <span class="error invalid-feedback errorKet_rujukan">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="row mb-3">
                                                            <div class="col-sm-12">
                                                                <!-- textarea -->
                                                                <div class="form-group">
                                                                    <label>Dirujuk ke dokter</label>
                                                                    <?= $cb_dokter ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <!-- textarea -->
                                                                <div class="form-group">
                                                                    <label>Catatan Konsultasi Dibuat Oleh</label>
                                                                    <input class="form-control form1" name="user_rujukan" id="user_rujukan" readonly />
                                                                    <span class="error invalid-feedback errorUser_rujukan">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-9">
                                                        <!-- <div id="summernotet"></div> -->
                                                        <textarea id="summernotet" name="rujukan" class="form1"></textarea>
                                                        <input type="hidden" class="no_registrasi form1" name="no_registrasi" />
                                                        <input type="hidden" class="form1" id="action" name="action" value="Add" />
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="checkList">
                                                            <!-- <p id="checkTitle">CHECKLIST (<span id="fraction">0/5</span>)</p> -->
                                                            <ul class="list-group" id="trigList" style="max-height: 250px;overflow-y: scroll;cursor: pointer;">
                                                                <li class='list-group-item' data-id='all' onclick='appendListItemAll()'>Retrieve All</li>
                                                                <li class='list-group-item' data-id='header' onclick='appendListItemCustom(this)'>Header</li>
                                                                <li class='list-group-item' data-id='keluhan_utama' onclick='appendListItem(this)'>Keluhan Utama</li>
                                                                <li class='list-group-item' data-id='riwayat_perjalanan_keluhan' onclick='appendListItem(this)'>Riwayat Perjalanan Keluhan</li>
                                                                <li class='list-group-item' data-id='riwayat_penyakit_sekarang' onclick='appendListItem(this)'>Riwayat Penyakit Sekarang</li>
                                                                <li class='list-group-item' data-id='riwayat_penyakit_dahulu' onclick='appendListItem(this)'>Riwayat Penyakit Dahulu</li>
                                                                <li class='list-group-item' data-id='riwayat_operasi_pengobatan' onclick='appendListItem(this)'>Riwayat Operasi / Pengobatan</li>
                                                                <li class='list-group-item' data-id='riwayat_penyakit_keluarga' onclick='appendListItem(this)'>Riwayat Penyakit Keluarga</li>
                                                                <li class='list-group-item' data-id='riwayat_lain' onclick='appendListItem(this)'>Riwayat Lain - lain</li>
                                                                <li class='list-group-item' data-id='head' onclick='appendListItemImage(this)'>G Head</li>
                                                                <li class='list-group-item' data-id='breast' onclick='appendListItemImage(this)'>G Breast</li>
                                                                <li class='list-group-item' data-id='dental' onclick='appendListItemImage(this)'>G Dental</li>
                                                                <li class='list-group-item' data-id='rectum_anus' onclick='appendListItemImage(this)'>G Rectum Anal Canal</li>
                                                                <li class='list-group-item' data-id='wajah' onclick='appendListItemImage(this)'>G Wajah</li>
                                                                <li class='list-group-item' data-id='wajah2' onclick='appendListItemImage(this)'>G Wajah 2</li>
                                                                <li class='list-group-item' data-id='blank' onclick='appendListItemImage(this)'>G Blank</li>
                                                            </ul>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="col-sm text-center">
                                                                    <button id="print_button_rujukan" class="btn btn-warning float-center ml-2">Cetak Resume Medis</button>
                                                                    <!-- <button id="submit_button_rujukan" class="btn btn-primary float-center ml-2">SIMPAN</button> -->
                                                                </div>
                                                            </div>
                                                            <!-- /.col-->
                                                        </div>
                                                        <!-- ./row -->
                                                    </div>
                                                </div>
                                                <!-- </form> -->


                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-sm">
                                                    <button id="draft_button_all" class="btn btn-warning" style="display:none;">Simpan Sebagai Draft</button>
                                                    <button id="submit_button_all" class="btn btn-primary ml-2">SIMPAN</button>
                                                </div>
                                            </div>
                                            <!-- /.col-->
                                        </div>
                                        <!-- ./row -->
                                    </div>

                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>

            </div>
            <div class="tab-pane fade" id="vert-tabs-two" role="tabpanel" aria-labelledby="vert-tabs-two-tab">
                <div class="row">
                    <div class="col-12">
                        <h5>RIWAYAT PEMERIKSAAN</h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card card-info">
                                    <!-- <div class="card-header">

                                                        <h3 class="card-title">
                                                            <button type="button" class="btn btn-tool refreshTitikKeluhan" data-card-widget="" data-no_registrasi="REG240600207"><i id="refreshBtn" class="fas fa-sync-alt"></i>
                                                            </button>

                                                        </h3>
                                                        <div class="card-tools" style="margin: 0rem 0rem 0rem !important;">
                                                            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                                                            </button>
                                                        </div>
                                                    </div> -->

                                    <div class="card-body" style="height: 75vh; overflow-y: scroll;">


                                        <span id="viewriwayatcard"></span>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-md-12 col-sm-6">
                                <div class="card card-primary card-outline card-outline-tabs">
                                    <div class="card-header p-0 border-bottom-0">
                                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">

                                            <li class="nav-item">
                                                <a class="nav-link active" id="custom-tabs-one-one1-tab" data-toggle="pill" href="#custom-tabs-one-one1" role="tab" aria-controls="custom-tabs-one-one1" aria-selected="false">Anamnesa</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="custom-tabs-one-two1-tab" data-toggle="pill" href="#custom-tabs-one-two1" role="tab" aria-controls="custom-tabs-one-two1" aria-selected="false">Pemeriksaan</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="custom-tabs-one-three1-tab" data-toggle="pill" href="#custom-tabs-one-three1" role="tab" aria-controls="custom-tabs-one-three1" aria-selected="false">Diagnosa</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="custom-tabs-one-four1-tab" data-toggle="pill" href="#custom-tabs-one-four1" role="tab" aria-controls="custom-tabs-one-four1" aria-selected="false">Tindakan</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="custom-tabs-one-five1-tab" data-toggle="pill" href="#custom-tabs-one-five1" role="tab" aria-controls="custom-tabs-one-five1" aria-selected="false">Jadwal Kontrol</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content" id="custom-tabs-one-tabContent">

                                            <div class="tab-pane fade show active" id="custom-tabs-one-one1" role="tabpanel" aria-labelledby="custom-tabs-one-one1-tab">
                                                <div class="col-sm-12">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label>Keluhan Utama</label>
                                                                <textarea class="form-control" rows="3" placeholder="..." id="r_keluhan_utama" readonly></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <!-- textarea -->
                                                            <div class="form-group">
                                                                <label>Riwayat Perjalanan Keluhan</label>
                                                                <textarea class="form-control" rows="3" placeholder="..." id="r_riwayat_perjalanan_keluhan" readonly></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label>Riwayat Penyakit Sekarang</label>
                                                                <textarea class="form-control" rows="3" placeholder="..." id="r_riwayat_penyakit_sekarang" readonly></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label>Riwayat Penyakit Dahulu</label>
                                                                <textarea class="form-control" rows="3" placeholder="..." id="r_riwayat_penyakit_dahulu" readonly></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label>Riwayat Operasi Pengobatan</label>
                                                                <textarea class="form-control" rows="3" placeholder="..." id="r_riwayat_operasi_pengobatan" readonly></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label>Riwayat Penyakit Keluarga</label>
                                                                <textarea class="form-control" rows="3" placeholder="..." id="r_riwayat_penyakit_keluarga" readonly></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label>Riwayat Lain-lain</label>
                                                                <textarea class="form-control" rows="3" placeholder="..." id="r_riwayat_lain" readonly></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-12">

                                                            <!-- textarea -->
                                                            <div class="form-group">
                                                                <label>Riwayat Alergi</label>
                                                            </div>
                                                            <div style="height:250px;overflow-y: scroll;">
                                                                <table class="table table-head-fixed table-border table-sm" id="r_dynamic_alergi">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Jenis</th>
                                                                            <th>Komponen2</th>
                                                                            <th>Reaksi2</th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <span id="viewrdataalergi"></span>
                                                                    </tbody>

                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="custom-tabs-one-two1" role="tabpanel" aria-labelledby="custom-tabs-one-two1-tab">
                                                <div class="col-sm-12">

                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <!-- .card -->
                                                            <div class="card ">
                                                                <!-- <div class="card-header">
                                                                                        <h3 class="card-title">Pemeriksaan & Tindakan</h3>
                                                                                    </div> -->
                                                                <!-- /.card-header -->
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-sm-8">
                                                                            <div class="row">
                                                                                <div class="col-sm-12">
                                                                                    <!-- text input -->
                                                                                    <div class="form-group">
                                                                                        <label>Kondisi Umum</label>
                                                                                        <input type="text" name="kondisi_umum" class="form-control" placeholder="" id="r_kondisi_umum" readonly>
                                                                                        <span class="error invalid-feedback errorKondisi_umum">
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-sm-12">
                                                                                    <div class="row">
                                                                                        <div class="col-sm-3">
                                                                                            <!-- text input -->
                                                                                            <div class="form-group">
                                                                                                <label>Tinggi (cm)</label>
                                                                                                <input type="number" name="tinggi_badan" class="form-control" placeholder="" id="r_tinggi_badan" min="0" step="5" readonly>
                                                                                                <span class="error invalid-feedback errorTinggi_badan">
                                                                                                </span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-sm-3">
                                                                                            <!-- text input -->
                                                                                            <div class="form-group">
                                                                                                <label>Berat (kg)</label>
                                                                                                <input type="number" name="berat_badan" class="form-control" placeholder="" id="r_berat_badan" min="0" step="5" readonly>
                                                                                                <span class="error invalid-feedback errorBerat_badan">
                                                                                                </span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-sm-3">
                                                                                            <!-- text input -->
                                                                                            <div class="form-group">
                                                                                                <label>BMI (kg/m2)</label>
                                                                                                <input type="number" name="bmi" class="form-control" placeholder="" id="r_bmi" readonly>
                                                                                                <span class="error invalid-feedback errorBmi">
                                                                                                </span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-sm-3">
                                                                                            <!-- text input -->
                                                                                            <div class="form-group">
                                                                                                <label>Suhu (&deg;c)</label>
                                                                                                <input type="number" name="suhu" class="form-control" placeholder="" id="r_suhu" min="1" readonly>
                                                                                                <span class="error invalid-feedback errorSuhu">
                                                                                                </span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-sm-3">
                                                                                            <!-- text input -->
                                                                                            <div class="form-group">
                                                                                                <label>Sistolik (mmHg)</label>
                                                                                                <input type="number" name="sistolik" class="form-control" placeholder="" id="r_sistolik" min="1" readonly>
                                                                                                <span class="error invalid-feedback errorSistolik">
                                                                                                </span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-sm-3">
                                                                                            <!-- text input -->
                                                                                            <div class="form-group">
                                                                                                <label>Diastolik (mmHg)</label>
                                                                                                <input type="number" name="diastolik" class="form-control" placeholder="" id="r_diastolik" min="1" readonly>
                                                                                                <span class="error invalid-feedback errorDiastolik">
                                                                                                </span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-sm-3">
                                                                                            <div class="form-group">
                                                                                                <label>Nadi (bpm)</label>
                                                                                                <input type="number" name="denyut_nadi" class="form-control" placeholder="" id="r_denyut_nadi" min="1" readonly>
                                                                                                <span class="error invalid-feedback errorDenyut_nadi">
                                                                                                </span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-sm-3">
                                                                                            <div class="form-group">
                                                                                                <label>Pernafasan (rpm)</label>
                                                                                                <input type="number" name="laju_nafas" class="form-control" placeholder="" id="r_laju_nafas" min="1" readonly>
                                                                                                <span class="error invalid-feedback errorLaju_nafas">
                                                                                                </span>
                                                                                            </div>
                                                                                        </div>

                                                                                    </div>


                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-sm-12">
                                                                                    <!-- textarea -->
                                                                                    <div class="form-group">
                                                                                        <label>Status Lokalis</label>
                                                                                        <textarea class="form-control" name="kondisi_khusus" rows="5" placeholder="Enter ..." id="r_kondisi_khusus" readonly></textarea>
                                                                                        <span class="error invalid-feedback errorKondisi_khusus">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-sm-12">
                                                                                    <!-- textarea -->
                                                                                    <div class="form-group">
                                                                                        <label>Pemeriksaan Tambahan</label>
                                                                                        <textarea class="form-control" name="pemeriksaan_tambahan" rows="5" placeholder="Enter ..." id="r_pemeriksaan_tambahan" readonly></textarea>
                                                                                        <span class="error invalid-feedback errorPemeriksaan_tambahan">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-4">
                                                                            <div class="row">
                                                                                <div class="col-sm-12">
                                                                                    <div class="form-group">
                                                                                        <label>Titik Keluhan</label>
                                                                                        <select class="form-control form-control-sm select2 titi" name="name1" id="titikKeluhan" style="width: 100%; heigh:100%;" disabled>
                                                                                            <option selected>-- Select --</option>
                                                                                            <option value="Head">Head</option>
                                                                                            <option value="Breast">Breast</option>
                                                                                            <option value="Dental">Dental</option>
                                                                                            <option value="RectumAnalCanal">Rectum Anal Canal</option>
                                                                                            <option value="Wajah">Wajah</option>
                                                                                            <option value="Wajah2">Wajah 2</option>
                                                                                            <option value="Blank">Blank</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-sm-12">
                                                                                    <div class="card card-info">
                                                                                        <div class="card-header">

                                                                                            <h3 class="card-title">
                                                                                                <!-- <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                                            </button> -->
                                                                                                <button type="button" class="btn btn-tool refreshTitikKeluhan" data-card-widget="" data-no_registrasi="REG240600207"><i id="refreshBtn" class="fas fa-sync-alt"></i>
                                                                                                </button>

                                                                                            </h3>
                                                                                            <div class="card-tools" style="margin: 0rem 0rem 0rem !important;">
                                                                                                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="card-body" style="height: 62.5vh; overflow-y: scroll;">

                                                                                            <!-- <img src="" class="img-fluid titikkeluhan rounded mx-auto d-block" height="250px" alt=""> -->

                                                                                            <div id="printcard"></div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- /.card-body -->
                                                            </div>
                                                            <!-- /.card -->
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="custom-tabs-one-three1" role="tabpanel" aria-labelledby="custom-tabs-one-three1-tab">
                                                <div class="col-sm-12">

                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <!-- .card -->
                                                            <div class="card ">
                                                                <!-- <div class="card-header">
                    <h3 class="card-title">Pemeriksaan & Tindakan</h3>
                </div> -->
                                                                <!-- /.card-header -->
                                                                <div class="card-body">

                                                                    <div class="row">
                                                                        <div class="col-sm-6">
                                                                            <div class="card ">
                                                                                <div class="card-body">
                                                                                    <div class="row">
                                                                                        <div class="col-sm-12">
                                                                                            <!-- text input -->
                                                                                            <div class="form-group">
                                                                                                <label>Diagnosa 2</label>
                                                                                                <input type="text" name="diagnosa_utama" class="form-control" placeholder="" id="r_diagnosa_utama" readonly>
                                                                                                <span class="error invalid-feedback errorDiagnosa_utama">
                                                                                                </span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-sm-12">
                                                                                            <label>ICD 10 </label>
                                                                                            <!-- textarea -->
                                                                                            <div class="form-group">
                                                                                                <select class="form-control form-control-sm" name="icd10_utama" id="r_icd10_utama" tabindex="25" disabled>
                                                                                                    <option value=" " selected="selected">-- Select --</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-sm-12">
                                                                                            <label></label>
                                                                                            <br>
                                                                                            <div class="form-group d-flex justify-content-between align-items-center">

                                                                                                <div class="form-check-inline">
                                                                                                    <label class="form-check-label">
                                                                                                        <input type="radio" class="form-check-input" name="r_klasifikasi_utama" value="terduga" disabled>Terduga
                                                                                                    </label>
                                                                                                </div>
                                                                                                <div class="form-check-inline">
                                                                                                    <label class="form-check-label">
                                                                                                        <input type="radio" class="form-check-input" name="r_klasifikasi_utama" value="gejala" disabled>Gejala
                                                                                                    </label>
                                                                                                </div>
                                                                                                <div class="form-check-inline">
                                                                                                    <label class="form-check-label">
                                                                                                        <input type="radio" class="form-check-input" name="r_klasifikasi_utama" value="dikonfirmasi" disabled>Sudah Dikonfirmasi
                                                                                                    </label>
                                                                                                </div>

                                                                                                <br>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="card ">
                                                                                <div class="card-body">
                                                                                    <div class="row">
                                                                                        <div class="col-sm-12">
                                                                                            <!-- text input -->
                                                                                            <div class="form-group">
                                                                                                <label>Diagnosa Sekunder</label>
                                                                                                <input type="text" name="diagnosa_sekunder" class="form-control" placeholder="" id="r_diagnosa_sekunder" readonly>
                                                                                                <span class="error invalid-feedback errorDiagnosa_sekunder">
                                                                                                </span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-sm-12">
                                                                                            <label>ICD 10 Sekunder</label>
                                                                                            <!-- textarea -->
                                                                                            <div class="form-group">
                                                                                                <select class="form-control form-control-sm icd10_sekunder" name="icd10_sekunder" id="r_icd10_sekunder" disabled>
                                                                                                    <option value=" " selected="selected">-- Select --</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-sm-12">
                                                                                            <label></label>
                                                                                            <br>
                                                                                            <div class="form-group d-flex justify-content-between align-items-center">

                                                                                                <div class="form-check-inline">
                                                                                                    <label class="form-check-label">
                                                                                                        <input type="radio" class="form-check-input" name="r_klasifikasi_sekunder" value="terduga" disabled>Terduga
                                                                                                    </label>
                                                                                                </div>
                                                                                                <div class="form-check-inline">
                                                                                                    <label class="form-check-label">
                                                                                                        <input type="radio" class="form-check-input" name="r_klasifikasi_sekunder" value="gejala" disabled>Gejala
                                                                                                    </label>
                                                                                                </div>
                                                                                                <div class="form-check-inline">
                                                                                                    <label class="form-check-label">
                                                                                                        <input type="radio" class="form-check-input" name="r_klasifikasi_sekunder" value="dikonfirmasi" disabled>Sudah Dikonfirmasi
                                                                                                    </label>
                                                                                                </div>

                                                                                                <br>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="row">
                                                                                <div class="col-sm-12">
                                                                                    <div class="card card-info">
                                                                                        <div class="card-body" style="height: 80vh; overflow-y: scroll;" id="r_dynamic_field">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- /.card-body -->
                                                            </div>
                                                            <!-- /.card -->
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="custom-tabs-one-four1" role="tabpanel" aria-labelledby="custom-tabs-one-four1-tab">
                                                <div class="col-sm-12">
                                                    <h5 class="text-center" style="color:grey">No Data Available!</h5>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="custom-tabs-one-five1" role="tabpanel" aria-labelledby="custom-tabs-one-five1-tab">
                                                <div class="col-sm-12">
                                                    <h5 class="text-center" style="color:grey">No Data Available!</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card -->
                                </div>
                            </div>
                        </div>

                    </div>
                </div>



            </div>
            <div class="tab-pane fade" id="vert-tabs-thre" role="tabpanel" aria-labelledby="vert-tabs-thre-tab">
                <div class="row">
                    <div class="col-12">
                        <h5>RIWAYAT PEMERIKSAAN RADIOLOGI</h5>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-12 col-sm-6">
                        <div class="card card-primary card-outline card-outline-tabs">
                            <div class="card-header p-0 border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">

                                    <li class="nav-item">
                                        <a class="nav-link active" id="custom-tabs-three-one3-tab" data-toggle="pill" href="#custom-tabs-three-one3" role="tab" aria-controls="custom-tabs-three-one3" aria-selected="true">X-RAY</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-three-two3-tab" data-toggle="pill" href="#custom-tabs-three-two3" role="tab" aria-controls="custom-tabs-three-two3" aria-selected="false">MAMMOGRAFI</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-three-three3-tab" data-toggle="pill" href="#custom-tabs-three-three3" role="tab" aria-controls="custom-tabs-three-three3" aria-selected="false">USG MAMAE</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-three-four3-tab" data-toggle="pill" href="#custom-tabs-three-four3" role="tab" aria-controls="custom-tabs-three-four3" aria-selected="false">LAINNYA</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-three-tabContent">
                                    <div class="tab-pane fade active" id="custom-tabs-three-one3" role="tabpanel" aria-labelledby="custom-tabs-three-one3-tab">
                                        <div class="col-sm-12">
                                            <h5 class="text-center" style="color:grey">No Data Available!</h5>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-three-two3" role="tabpanel" aria-labelledby="custom-tabs-three-two3-tab">
                                        <div class="col-sm-12">
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
                                                            <ul class="products-list product-list-in-card pl-2 pr-2 list-group-a" id="viewdatariwayat">
                                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500187" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/31/2024 12:00:00 AM" data-tahun="35" data-bulan="2" data-hari="6" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="0" data-suhu="0" data-nafas="0" data-tekanan_darah="0" data-tinggi_badan="0" data-berat_badan="0" data-keluhan_utama="" data-keluhan_sekunder="" data-diagnosa_utama="" data-diagnosa_sekunder="" data-diagnosa_note="" data-pf_rambut="" data-pf_mata="" data-pf_telinga="" data-pf_hidung="" data-pf_tenggorokan="" data-photo="">
                                                                    <a href="javascript:void(0)" class="product-title">
                                                                        <div class="product-img">
                                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                                        </div>
                                                                        <div class="product-info">
                                                                            REG240500187
                                                                            <span class="badge badge-warning float-right">31/05/2024</span>
                                                                            <span class="product-description">
                                                                                Rawat Jalan - Umum<br>

                                                                            </span>

                                                                        </div>
                                                                    </a>
                                                                </li>

                                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500185" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/30/2024 12:00:00 AM" data-tahun="35" data-bulan="2" data-hari="5" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="0" data-suhu="0" data-nafas="0" data-tekanan_darah="0" data-tinggi_badan="0" data-berat_badan="0" data-keluhan_utama="" data-keluhan_sekunder="" data-diagnosa_utama="" data-diagnosa_sekunder="" data-diagnosa_note="" data-pf_rambut="" data-pf_mata="" data-pf_telinga="" data-pf_hidung="" data-pf_tenggorokan="" data-photo="">
                                                                    <a href="javascript:void(0)" class="product-title">
                                                                        <div class="product-img">
                                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                                        </div>
                                                                        <div class="product-info">
                                                                            REG240500185
                                                                            <span class="badge badge-warning float-right">30/05/2024</span>
                                                                            <span class="product-description">
                                                                                Rawat Jalan - Umum<br>

                                                                            </span>

                                                                        </div>
                                                                    </a>
                                                                </li>

                                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500183" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/29/2024 12:00:00 AM" data-tahun="35" data-bulan="2" data-hari="4" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="0" data-suhu="0" data-nafas="0" data-tekanan_darah="0" data-tinggi_badan="0" data-berat_badan="0" data-keluhan_utama="" data-keluhan_sekunder="" data-diagnosa_utama="" data-diagnosa_sekunder="" data-diagnosa_note="" data-pf_rambut="" data-pf_mata="" data-pf_telinga="" data-pf_hidung="" data-pf_tenggorokan="" data-photo="">
                                                                    <a href="javascript:void(0)" class="product-title">
                                                                        <div class="product-img">
                                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                                        </div>
                                                                        <div class="product-info">
                                                                            REG240500183
                                                                            <span class="badge badge-warning float-right">29/05/2024</span>
                                                                            <span class="product-description">
                                                                                Rawat Jalan - Umum<br>

                                                                            </span>

                                                                        </div>
                                                                    </a>
                                                                </li>

                                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500180" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/22/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="27" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="0" data-suhu="0" data-nafas="0" data-tekanan_darah="0" data-tinggi_badan="0" data-berat_badan="0" data-keluhan_utama="" data-keluhan_sekunder="" data-diagnosa_utama="" data-diagnosa_sekunder="" data-diagnosa_note="" data-pf_rambut="" data-pf_mata="" data-pf_telinga="" data-pf_hidung="" data-pf_tenggorokan="" data-photo="">
                                                                    <a href="javascript:void(0)" class="product-title">
                                                                        <div class="product-img">
                                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                                        </div>
                                                                        <div class="product-info">
                                                                            REG240500180
                                                                            <span class="badge badge-warning float-right">22/05/2024</span>
                                                                            <span class="product-description">
                                                                                Rawat Jalan - Umum<br>

                                                                            </span>

                                                                        </div>
                                                                    </a>
                                                                </li>

                                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500179" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/22/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="27" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="6" data-suhu="6" data-nafas="6" data-tekanan_darah="6" data-tinggi_badan="6" data-berat_badan="6" data-keluhan_utama="6" data-keluhan_sekunder="6" data-diagnosa_utama="Anemi aplastik" data-diagnosa_sekunder="Anemi aplastik" data-diagnosa_note="6" data-pf_rambut="6" data-pf_mata="6" data-pf_telinga="6" data-pf_hidung="6" data-pf_tenggorokan="6" data-photo="24050024_REG240500179">
                                                                    <a href="javascript:void(0)" class="product-title">
                                                                        <div class="product-img">
                                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                                        </div>
                                                                        <div class="product-info">
                                                                            REG240500179
                                                                            <span class="badge badge-warning float-right">22/05/2024</span>
                                                                            <span class="product-description">
                                                                                Rawat Jalan - Umum<br>
                                                                                6
                                                                            </span>

                                                                        </div>
                                                                    </a>
                                                                </li>

                                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500178" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/22/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="27" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="8" data-suhu="8" data-nafas="8" data-tekanan_darah="8" data-tinggi_badan="8" data-berat_badan="8" data-keluhan_utama="8" data-keluhan_sekunder="8" data-diagnosa_utama="Anemi aplastik" data-diagnosa_sekunder="Anemi aplastik" data-diagnosa_note="8" data-pf_rambut="8" data-pf_mata="8" data-pf_telinga="8" data-pf_hidung="8" data-pf_tenggorokan="8" data-photo="24050024_REG240500178">
                                                                    <a href="javascript:void(0)" class="product-title">
                                                                        <div class="product-img">
                                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                                        </div>
                                                                        <div class="product-info">
                                                                            REG240500178
                                                                            <span class="badge badge-warning float-right">22/05/2024</span>
                                                                            <span class="product-description">
                                                                                Rawat Jalan - Umum<br>
                                                                                8
                                                                            </span>

                                                                        </div>
                                                                    </a>
                                                                </li>

                                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500177" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/22/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="27" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="7" data-suhu="7" data-nafas="7" data-tekanan_darah="7" data-tinggi_badan="7" data-berat_badan="7" data-keluhan_utama="7" data-keluhan_sekunder="7" data-diagnosa_utama="Anemi aplastik" data-diagnosa_sekunder="Anemi aplastik" data-diagnosa_note="7" data-pf_rambut="7" data-pf_mata="7" data-pf_telinga="7" data-pf_hidung="7" data-pf_tenggorokan="7" data-photo="24050024_REG240500177">
                                                                    <a href="javascript:void(0)" class="product-title">
                                                                        <div class="product-img">
                                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                                        </div>
                                                                        <div class="product-info">
                                                                            REG240500177
                                                                            <span class="badge badge-warning float-right">22/05/2024</span>
                                                                            <span class="product-description">
                                                                                Rawat Jalan - Umum<br>
                                                                                7
                                                                            </span>

                                                                        </div>
                                                                    </a>
                                                                </li>

                                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500176" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/22/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="27" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="6" data-suhu="6" data-nafas="6" data-tekanan_darah="6" data-tinggi_badan="6" data-berat_badan="6" data-keluhan_utama="6" data-keluhan_sekunder="1" data-diagnosa_utama="Anemi aplastik" data-diagnosa_sekunder="Anemi aplastik" data-diagnosa_note="1" data-pf_rambut="6" data-pf_mata="6" data-pf_telinga="6" data-pf_hidung="6" data-pf_tenggorokan="6" data-photo="24050024_REG240500176">
                                                                    <a href="javascript:void(0)" class="product-title">
                                                                        <div class="product-img">
                                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                                        </div>
                                                                        <div class="product-info">
                                                                            REG240500176
                                                                            <span class="badge badge-warning float-right">22/05/2024</span>
                                                                            <span class="product-description">
                                                                                Rawat Jalan - Umum<br>
                                                                                6
                                                                            </span>

                                                                        </div>
                                                                    </a>
                                                                </li>

                                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500174" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/21/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="26" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="7" data-suhu="7" data-nafas="7" data-tekanan_darah="7" data-tinggi_badan="7" data-berat_badan="7" data-keluhan_utama="7" data-keluhan_sekunder="7" data-diagnosa_utama="Anemi aplastik" data-diagnosa_sekunder="TEST4" data-diagnosa_note="7" data-pf_rambut="7" data-pf_mata="7" data-pf_telinga="7" data-pf_hidung="7" data-pf_tenggorokan="7" data-photo="24050024_REG240500174">
                                                                    <a href="javascript:void(0)" class="product-title">
                                                                        <div class="product-img">
                                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                                        </div>
                                                                        <div class="product-info">
                                                                            REG240500174
                                                                            <span class="badge badge-warning float-right">21/05/2024</span>
                                                                            <span class="product-description">
                                                                                Rawat Jalan - Umum<br>
                                                                                7
                                                                            </span>

                                                                        </div>
                                                                    </a>
                                                                </li>

                                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500173" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/21/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="26" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="0" data-suhu="0" data-nafas="0" data-tekanan_darah="0" data-tinggi_badan="0" data-berat_badan="0" data-keluhan_utama="" data-keluhan_sekunder="" data-diagnosa_utama="" data-diagnosa_sekunder="" data-diagnosa_note="" data-pf_rambut="" data-pf_mata="" data-pf_telinga="" data-pf_hidung="" data-pf_tenggorokan="" data-photo="">
                                                                    <a href="javascript:void(0)" class="product-title">
                                                                        <div class="product-img">
                                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                                        </div>
                                                                        <div class="product-info">
                                                                            REG240500173
                                                                            <span class="badge badge-warning float-right">21/05/2024</span>
                                                                            <span class="product-description">
                                                                                Rawat Jalan - Umum<br>

                                                                            </span>

                                                                        </div>
                                                                    </a>
                                                                </li>

                                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500172" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/21/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="26" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="4" data-suhu="4" data-nafas="4" data-tekanan_darah="4" data-tinggi_badan="4" data-berat_badan="4" data-keluhan_utama="4" data-keluhan_sekunder="4" data-diagnosa_utama="Anemi aplastik" data-diagnosa_sekunder="Anemi aplastik" data-diagnosa_note="44" data-pf_rambut="4" data-pf_mata="4" data-pf_telinga="4" data-pf_hidung="4" data-pf_tenggorokan="4" data-photo="24050024_REG240500172">
                                                                    <a href="javascript:void(0)" class="product-title">
                                                                        <div class="product-img">
                                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                                        </div>
                                                                        <div class="product-info">
                                                                            REG240500172
                                                                            <span class="badge badge-warning float-right">21/05/2024</span>
                                                                            <span class="product-description">
                                                                                Rawat Jalan - Umum<br>
                                                                                4
                                                                            </span>

                                                                        </div>
                                                                    </a>
                                                                </li>

                                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500171" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/20/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="25" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="0" data-suhu="0" data-nafas="0" data-tekanan_darah="0" data-tinggi_badan="0" data-berat_badan="0" data-keluhan_utama="" data-keluhan_sekunder="" data-diagnosa_utama="" data-diagnosa_sekunder="" data-diagnosa_note="" data-pf_rambut="" data-pf_mata="" data-pf_telinga="" data-pf_hidung="" data-pf_tenggorokan="" data-photo="">
                                                                    <a href="javascript:void(0)" class="product-title">
                                                                        <div class="product-img">
                                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                                        </div>
                                                                        <div class="product-info">
                                                                            REG240500171
                                                                            <span class="badge badge-warning float-right">20/05/2024</span>
                                                                            <span class="product-description">
                                                                                Rawat Jalan - Umum<br>

                                                                            </span>

                                                                        </div>
                                                                    </a>
                                                                </li>

                                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500170" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/20/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="25" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="3" data-suhu="3" data-nafas="3" data-tekanan_darah="3" data-tinggi_badan="3" data-berat_badan="3" data-keluhan_utama="3" data-keluhan_sekunder="3" data-diagnosa_utama="Anemi aplastik" data-diagnosa_sekunder="Anemi aplastik" data-diagnosa_note="3" data-pf_rambut="3" data-pf_mata="3" data-pf_telinga="3" data-pf_hidung="3" data-pf_tenggorokan="3" data-photo="24050024_REG240500170">
                                                                    <a href="javascript:void(0)" class="product-title">
                                                                        <div class="product-img">
                                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                                        </div>
                                                                        <div class="product-info">
                                                                            REG240500170
                                                                            <span class="badge badge-warning float-right">20/05/2024</span>
                                                                            <span class="product-description">
                                                                                Rawat Jalan - Umum<br>
                                                                                3
                                                                            </span>

                                                                        </div>
                                                                    </a>
                                                                </li>

                                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500169" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/20/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="25" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="1" data-suhu="1" data-nafas="1" data-tekanan_darah="1" data-tinggi_badan="1" data-berat_badan="1" data-keluhan_utama="1" data-keluhan_sekunder="1" data-diagnosa_utama="TEST4" data-diagnosa_sekunder="TEST4" data-diagnosa_note="1" data-pf_rambut="1" data-pf_mata="1" data-pf_telinga="1" data-pf_hidung="1" data-pf_tenggorokan="1" data-photo="24050024_REG240500169">
                                                                    <a href="javascript:void(0)" class="product-title">
                                                                        <div class="product-img">
                                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                                        </div>
                                                                        <div class="product-info">
                                                                            REG240500169
                                                                            <span class="badge badge-warning float-right">20/05/2024</span>
                                                                            <span class="product-description">
                                                                                Rawat Jalan - Umum<br>
                                                                                1
                                                                            </span>

                                                                        </div>
                                                                    </a>
                                                                </li>

                                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500168" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/20/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="25" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="0" data-suhu="0" data-nafas="0" data-tekanan_darah="0" data-tinggi_badan="0" data-berat_badan="0" data-keluhan_utama="Sering Pusing " data-keluhan_sekunder="Muntah-muntah" data-diagnosa_utama="TEST5" data-diagnosa_sekunder="TEST6" data-diagnosa_note="Ada menjurus kearah gangguan vertigo" data-pf_rambut="Rambut Rontok" data-pf_mata="Pupil agak mengecil" data-pf_telinga="Telinga bersih" data-pf_hidung="Bersih" data-pf_tenggorokan="Bagus" data-photo="24050024_REG240500168">
                                                                    <a href="javascript:void(0)" class="product-title">
                                                                        <div class="product-img">
                                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                                        </div>
                                                                        <div class="product-info">
                                                                            REG240500168
                                                                            <span class="badge badge-warning float-right">20/05/2024</span>
                                                                            <span class="product-description">
                                                                                Rawat Jalan - Umum<br>
                                                                                Sering Pusing
                                                                            </span>

                                                                        </div>
                                                                    </a>
                                                                </li>

                                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500167" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/17/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="22" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="0" data-suhu="0" data-nafas="0" data-tekanan_darah="0" data-tinggi_badan="0" data-berat_badan="0" data-keluhan_utama="" data-keluhan_sekunder="" data-diagnosa_utama="" data-diagnosa_sekunder="" data-diagnosa_note="" data-pf_rambut="" data-pf_mata="" data-pf_telinga="" data-pf_hidung="" data-pf_tenggorokan="" data-photo="">
                                                                    <a href="javascript:void(0)" class="product-title">
                                                                        <div class="product-img">
                                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                                        </div>
                                                                        <div class="product-info">
                                                                            REG240500167
                                                                            <span class="badge badge-warning float-right">17/05/2024</span>
                                                                            <span class="product-description">
                                                                                Rawat Jalan - Umum<br>

                                                                            </span>

                                                                        </div>
                                                                    </a>
                                                                </li>

                                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500165" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/16/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="21" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="0" data-suhu="0" data-nafas="0" data-tekanan_darah="0" data-tinggi_badan="0" data-berat_badan="0" data-keluhan_utama="" data-keluhan_sekunder="" data-diagnosa_utama="" data-diagnosa_sekunder="" data-diagnosa_note="" data-pf_rambut="" data-pf_mata="" data-pf_telinga="" data-pf_hidung="" data-pf_tenggorokan="" data-photo="">
                                                                    <a href="javascript:void(0)" class="product-title">
                                                                        <div class="product-img">
                                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                                        </div>
                                                                        <div class="product-info">
                                                                            REG240500165
                                                                            <span class="badge badge-warning float-right">16/05/2024</span>
                                                                            <span class="product-description">
                                                                                Rawat Jalan - Umum<br>

                                                                            </span>

                                                                        </div>
                                                                    </a>
                                                                </li>

                                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500164" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/16/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="21" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="3" data-suhu="3" data-nafas="3" data-tekanan_darah="3" data-tinggi_badan="3" data-berat_badan="3" data-keluhan_utama="3" data-keluhan_sekunder="3" data-diagnosa_utama="Anemi aplastik" data-diagnosa_sekunder="Anemi aplastik" data-diagnosa_note="3" data-pf_rambut="3" data-pf_mata="3" data-pf_telinga="3" data-pf_hidung="3" data-pf_tenggorokan="3" data-photo="24050024_REG240500164">
                                                                    <a href="javascript:void(0)" class="product-title">
                                                                        <div class="product-img">
                                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                                        </div>
                                                                        <div class="product-info">
                                                                            REG240500164
                                                                            <span class="badge badge-warning float-right">16/05/2024</span>
                                                                            <span class="product-description">
                                                                                Rawat Jalan - Umum<br>
                                                                                3
                                                                            </span>

                                                                        </div>
                                                                    </a>
                                                                </li>

                                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500163" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/16/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="21" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="0" data-suhu="0" data-nafas="0" data-tekanan_darah="0" data-tinggi_badan="0" data-berat_badan="0" data-keluhan_utama="" data-keluhan_sekunder="" data-diagnosa_utama="" data-diagnosa_sekunder="" data-diagnosa_note="" data-pf_rambut="" data-pf_mata="" data-pf_telinga="" data-pf_hidung="" data-pf_tenggorokan="" data-photo="">
                                                                    <a href="javascript:void(0)" class="product-title">
                                                                        <div class="product-img">
                                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                                        </div>
                                                                        <div class="product-info">
                                                                            REG240500163
                                                                            <span class="badge badge-warning float-right">16/05/2024</span>
                                                                            <span class="product-description">
                                                                                Rawat Jalan - Umum<br>

                                                                            </span>

                                                                        </div>
                                                                    </a>
                                                                </li>

                                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500162" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/16/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="21" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="2" data-suhu="2" data-nafas="2" data-tekanan_darah="2" data-tinggi_badan="2" data-berat_badan="2" data-keluhan_utama="2" data-keluhan_sekunder="2" data-diagnosa_utama="Anemi aplastik" data-diagnosa_sekunder="Anemi aplastik" data-diagnosa_note="2" data-pf_rambut="2" data-pf_mata="2" data-pf_telinga="2" data-pf_hidung="2" data-pf_tenggorokan="2" data-photo="24050024_REG240500162">
                                                                    <a href="javascript:void(0)" class="product-title">
                                                                        <div class="product-img">
                                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                                        </div>
                                                                        <div class="product-info">
                                                                            REG240500162
                                                                            <span class="badge badge-warning float-right">16/05/2024</span>
                                                                            <span class="product-description">
                                                                                Rawat Jalan - Umum<br>
                                                                                2
                                                                            </span>

                                                                        </div>
                                                                    </a>
                                                                </li>

                                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500161" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/16/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="21" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="5" data-suhu="5" data-nafas="5" data-tekanan_darah="5" data-tinggi_badan="5" data-berat_badan="5" data-keluhan_utama="5" data-keluhan_sekunder="5" data-diagnosa_utama="Anemi aplastik" data-diagnosa_sekunder="Anemi aplastik" data-diagnosa_note="5" data-pf_rambut="5" data-pf_mata="5" data-pf_telinga="5" data-pf_hidung="5" data-pf_tenggorokan="5" data-photo="24050024_REG240500161">
                                                                    <a href="javascript:void(0)" class="product-title">
                                                                        <div class="product-img">
                                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                                        </div>
                                                                        <div class="product-info">
                                                                            REG240500161
                                                                            <span class="badge badge-warning float-right">16/05/2024</span>
                                                                            <span class="product-description">
                                                                                Rawat Jalan - Umum<br>
                                                                                5
                                                                            </span>

                                                                        </div>
                                                                    </a>
                                                                </li>

                                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500160" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/16/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="21" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="44" data-suhu="3" data-nafas="3" data-tekanan_darah="3" data-tinggi_badan="3" data-berat_badan="3" data-keluhan_utama="3" data-keluhan_sekunder="3" data-diagnosa_utama="Anemi aplastik" data-diagnosa_sekunder="Anemi aplastik" data-diagnosa_note="3" data-pf_rambut="3" data-pf_mata="3" data-pf_telinga="3" data-pf_hidung="3" data-pf_tenggorokan="3" data-photo="24050024_REG240500160">
                                                                    <a href="javascript:void(0)" class="product-title">
                                                                        <div class="product-img">
                                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                                        </div>
                                                                        <div class="product-info">
                                                                            REG240500160
                                                                            <span class="badge badge-warning float-right">16/05/2024</span>
                                                                            <span class="product-description">
                                                                                Rawat Jalan - Umum<br>
                                                                                3
                                                                            </span>

                                                                        </div>
                                                                    </a>
                                                                </li>

                                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500159" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/16/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="21" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="2" data-suhu="2" data-nafas="2" data-tekanan_darah="2" data-tinggi_badan="2" data-berat_badan="2" data-keluhan_utama="2" data-keluhan_sekunder="2" data-diagnosa_utama="Anemi aplastik" data-diagnosa_sekunder="Anemi aplastik" data-diagnosa_note="2" data-pf_rambut="2" data-pf_mata="2" data-pf_telinga="2" data-pf_hidung="2" data-pf_tenggorokan="2" data-photo="24050024_REG240500159">
                                                                    <a href="javascript:void(0)" class="product-title">
                                                                        <div class="product-img">
                                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                                        </div>
                                                                        <div class="product-info">
                                                                            REG240500159
                                                                            <span class="badge badge-warning float-right">16/05/2024</span>
                                                                            <span class="product-description">
                                                                                Rawat Jalan - Umum<br>
                                                                                2
                                                                            </span>

                                                                        </div>
                                                                    </a>
                                                                </li>

                                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500158" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/16/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="21" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="3" data-suhu="3" data-nafas="3" data-tekanan_darah="3" data-tinggi_badan="3" data-berat_badan="3" data-keluhan_utama="3" data-keluhan_sekunder="3" data-diagnosa_utama="Anemi aplastik" data-diagnosa_sekunder="TEST4" data-diagnosa_note="3" data-pf_rambut="3" data-pf_mata="3" data-pf_telinga="3" data-pf_hidung="3" data-pf_tenggorokan="3" data-photo="24050024_REG240500158">
                                                                    <a href="javascript:void(0)" class="product-title">
                                                                        <div class="product-img">
                                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                                        </div>
                                                                        <div class="product-info">
                                                                            REG240500158
                                                                            <span class="badge badge-warning float-right">16/05/2024</span>
                                                                            <span class="product-description">
                                                                                Rawat Jalan - Umum<br>
                                                                                3
                                                                            </span>

                                                                        </div>
                                                                    </a>
                                                                </li>

                                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500157" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/16/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="21" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="0" data-suhu="0" data-nafas="0" data-tekanan_darah="0" data-tinggi_badan="0" data-berat_badan="0" data-keluhan_utama="" data-keluhan_sekunder="" data-diagnosa_utama="" data-diagnosa_sekunder="" data-diagnosa_note="" data-pf_rambut="" data-pf_mata="" data-pf_telinga="" data-pf_hidung="" data-pf_tenggorokan="" data-photo="">
                                                                    <a href="javascript:void(0)" class="product-title">
                                                                        <div class="product-img">
                                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                                        </div>
                                                                        <div class="product-info">
                                                                            REG240500157
                                                                            <span class="badge badge-warning float-right">16/05/2024</span>
                                                                            <span class="product-description">
                                                                                Rawat Jalan - Umum<br>

                                                                            </span>

                                                                        </div>
                                                                    </a>
                                                                </li>

                                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500156" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/16/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="21" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="0" data-suhu="0" data-nafas="0" data-tekanan_darah="0" data-tinggi_badan="0" data-berat_badan="0" data-keluhan_utama="" data-keluhan_sekunder="" data-diagnosa_utama="" data-diagnosa_sekunder="" data-diagnosa_note="" data-pf_rambut="" data-pf_mata="" data-pf_telinga="" data-pf_hidung="" data-pf_tenggorokan="" data-photo="">
                                                                    <a href="javascript:void(0)" class="product-title">
                                                                        <div class="product-img">
                                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                                        </div>
                                                                        <div class="product-info">
                                                                            REG240500156
                                                                            <span class="badge badge-warning float-right">16/05/2024</span>
                                                                            <span class="product-description">
                                                                                Rawat Jalan - Umum<br>

                                                                            </span>

                                                                        </div>
                                                                    </a>
                                                                </li>

                                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500154" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/16/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="21" data-nama_dokter="dr. SANTI SEPTIKA Sp. Rad" data-nadi="0" data-suhu="0" data-nafas="0" data-tekanan_darah="0" data-tinggi_badan="0" data-berat_badan="0" data-keluhan_utama="" data-keluhan_sekunder="" data-diagnosa_utama="" data-diagnosa_sekunder="" data-diagnosa_note="" data-pf_rambut="" data-pf_mata="" data-pf_telinga="" data-pf_hidung="" data-pf_tenggorokan="" data-photo="">
                                                                    <a href="javascript:void(0)" class="product-title">
                                                                        <div class="product-img">
                                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                                        </div>
                                                                        <div class="product-info">
                                                                            REG240500154
                                                                            <span class="badge badge-warning float-right">16/05/2024</span>
                                                                            <span class="product-description">
                                                                                Rawat Jalan - Umum<br>

                                                                            </span>

                                                                        </div>
                                                                    </a>
                                                                </li>

                                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500153" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/15/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="20" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="1" data-suhu="1" data-nafas="1" data-tekanan_darah="1" data-tinggi_badan="1" data-berat_badan="1" data-keluhan_utama="1" data-keluhan_sekunder="1" data-diagnosa_utama="Anemi aplastik" data-diagnosa_sekunder="Anemi aplastik" data-diagnosa_note="1" data-pf_rambut="1" data-pf_mata="1" data-pf_telinga="1" data-pf_hidung="1" data-pf_tenggorokan="1" data-photo="24050024_REG240500153">
                                                                    <a href="javascript:void(0)" class="product-title">
                                                                        <div class="product-img">
                                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                                        </div>
                                                                        <div class="product-info">
                                                                            REG240500153
                                                                            <span class="badge badge-warning float-right">15/05/2024</span>
                                                                            <span class="product-description">
                                                                                Rawat Jalan - Umum<br>
                                                                                1
                                                                            </span>

                                                                        </div>
                                                                    </a>
                                                                </li>

                                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500152" data-no_pasien="24050024" data-tujuan_registrasi_desc="Radiologi" data-tgl_praktek="5/15/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="20" data-nama_dokter="dr. SANTI SEPTIKA Sp. Rad" data-nadi="13" data-suhu="13" data-nafas="13" data-tekanan_darah="13" data-tinggi_badan="13" data-berat_badan="13" data-keluhan_utama="13" data-keluhan_sekunder="13" data-diagnosa_utama="Anemi aplastik" data-diagnosa_sekunder="TEST4" data-diagnosa_note="13" data-pf_rambut="13" data-pf_mata="13" data-pf_telinga="13" data-pf_hidung="13" data-pf_tenggorokan="13" data-photo="24050024_REG240500152">
                                                                    <a href="javascript:void(0)" class="product-title">
                                                                        <div class="product-img">
                                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                                        </div>
                                                                        <div class="product-info">
                                                                            REG240500152
                                                                            <span class="badge badge-warning float-right">15/05/2024</span>
                                                                            <span class="product-description">
                                                                                Rawat Jalan - Radiologi<br>
                                                                                13
                                                                            </span>

                                                                        </div>
                                                                    </a>
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
                                                                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                                                                    </button>
                                                                    <i class="fas fa-folder"></i>
                                                                    Rekam Medis : <span id="tgl_pemeriksaan_rm"></span>
                                                                </h3>
                                                                <div class="card-tools" style="margin: 0rem 0rem 0rem !important;">
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
                                                                                            <dt class="caption_text">Suhu (°c)</dt>
                                                                                            <dd><span id="suhu_rm" class="content_text"></span> °C</dd>
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
                                                                                                <dd class="alergi">test</dd>
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
                                                                        <!-- <div class="card">
                                                                                                <div class="card-body">
                                                                                                    <img src="/assets/img/titikkeluhan/default.jpg" class="img-fluid titikkeluhan" height="250px" alt="">
                                                                                                </div>
                                                                                            </div> -->

                                                                        <!-- <div id="printcard"></div> -->

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

                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-three-three3" role="tabpanel" aria-labelledby="custom-tabs-three-three3-tab">
                                        <div class="col-sm-12">
                                            <h5 class="text-center" style="color:grey">No Data Available!</h5>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-three-four3" role="tabpanel" aria-labelledby="custom-tabs-three-four3-tab">
                                        <div class="col-sm-12">
                                            <h5 class="text-center" style="color:grey">No Data Available!</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="vert-tabs-four" role="tabpanel" aria-labelledby="vert-tabs-four-tab">
                <div class="row">
                    <div class="col-12">
                        <h5>RIWAYAT PEMERIKSAAN LABORATORIUM</h5>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">

                        <div class="row">
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
                                            <ul class="products-list product-list-in-card pl-2 pr-2 list-group-a" id="viewdatariwayat">
                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500187" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/31/2024 12:00:00 AM" data-tahun="35" data-bulan="2" data-hari="6" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="0" data-suhu="0" data-nafas="0" data-tekanan_darah="0" data-tinggi_badan="0" data-berat_badan="0" data-keluhan_utama="" data-keluhan_sekunder="" data-diagnosa_utama="" data-diagnosa_sekunder="" data-diagnosa_note="" data-pf_rambut="" data-pf_mata="" data-pf_telinga="" data-pf_hidung="" data-pf_tenggorokan="" data-photo="">
                                                    <a href="javascript:void(0)" class="product-title">
                                                        <div class="product-img">
                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                        </div>
                                                        <div class="product-info">
                                                            REG240500187
                                                            <span class="badge badge-warning float-right">31/05/2024</span>
                                                            <span class="product-description">
                                                                Rawat Jalan - Umum<br>

                                                            </span>

                                                        </div>
                                                    </a>
                                                </li>

                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500185" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/30/2024 12:00:00 AM" data-tahun="35" data-bulan="2" data-hari="5" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="0" data-suhu="0" data-nafas="0" data-tekanan_darah="0" data-tinggi_badan="0" data-berat_badan="0" data-keluhan_utama="" data-keluhan_sekunder="" data-diagnosa_utama="" data-diagnosa_sekunder="" data-diagnosa_note="" data-pf_rambut="" data-pf_mata="" data-pf_telinga="" data-pf_hidung="" data-pf_tenggorokan="" data-photo="">
                                                    <a href="javascript:void(0)" class="product-title">
                                                        <div class="product-img">
                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                        </div>
                                                        <div class="product-info">
                                                            REG240500185
                                                            <span class="badge badge-warning float-right">30/05/2024</span>
                                                            <span class="product-description">
                                                                Rawat Jalan - Umum<br>

                                                            </span>

                                                        </div>
                                                    </a>
                                                </li>

                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500183" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/29/2024 12:00:00 AM" data-tahun="35" data-bulan="2" data-hari="4" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="0" data-suhu="0" data-nafas="0" data-tekanan_darah="0" data-tinggi_badan="0" data-berat_badan="0" data-keluhan_utama="" data-keluhan_sekunder="" data-diagnosa_utama="" data-diagnosa_sekunder="" data-diagnosa_note="" data-pf_rambut="" data-pf_mata="" data-pf_telinga="" data-pf_hidung="" data-pf_tenggorokan="" data-photo="">
                                                    <a href="javascript:void(0)" class="product-title">
                                                        <div class="product-img">
                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                        </div>
                                                        <div class="product-info">
                                                            REG240500183
                                                            <span class="badge badge-warning float-right">29/05/2024</span>
                                                            <span class="product-description">
                                                                Rawat Jalan - Umum<br>

                                                            </span>

                                                        </div>
                                                    </a>
                                                </li>

                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500180" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/22/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="27" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="0" data-suhu="0" data-nafas="0" data-tekanan_darah="0" data-tinggi_badan="0" data-berat_badan="0" data-keluhan_utama="" data-keluhan_sekunder="" data-diagnosa_utama="" data-diagnosa_sekunder="" data-diagnosa_note="" data-pf_rambut="" data-pf_mata="" data-pf_telinga="" data-pf_hidung="" data-pf_tenggorokan="" data-photo="">
                                                    <a href="javascript:void(0)" class="product-title">
                                                        <div class="product-img">
                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                        </div>
                                                        <div class="product-info">
                                                            REG240500180
                                                            <span class="badge badge-warning float-right">22/05/2024</span>
                                                            <span class="product-description">
                                                                Rawat Jalan - Umum<br>

                                                            </span>

                                                        </div>
                                                    </a>
                                                </li>

                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500179" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/22/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="27" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="6" data-suhu="6" data-nafas="6" data-tekanan_darah="6" data-tinggi_badan="6" data-berat_badan="6" data-keluhan_utama="6" data-keluhan_sekunder="6" data-diagnosa_utama="Anemi aplastik" data-diagnosa_sekunder="Anemi aplastik" data-diagnosa_note="6" data-pf_rambut="6" data-pf_mata="6" data-pf_telinga="6" data-pf_hidung="6" data-pf_tenggorokan="6" data-photo="24050024_REG240500179">
                                                    <a href="javascript:void(0)" class="product-title">
                                                        <div class="product-img">
                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                        </div>
                                                        <div class="product-info">
                                                            REG240500179
                                                            <span class="badge badge-warning float-right">22/05/2024</span>
                                                            <span class="product-description">
                                                                Rawat Jalan - Umum<br>
                                                                6
                                                            </span>

                                                        </div>
                                                    </a>
                                                </li>

                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500178" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/22/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="27" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="8" data-suhu="8" data-nafas="8" data-tekanan_darah="8" data-tinggi_badan="8" data-berat_badan="8" data-keluhan_utama="8" data-keluhan_sekunder="8" data-diagnosa_utama="Anemi aplastik" data-diagnosa_sekunder="Anemi aplastik" data-diagnosa_note="8" data-pf_rambut="8" data-pf_mata="8" data-pf_telinga="8" data-pf_hidung="8" data-pf_tenggorokan="8" data-photo="24050024_REG240500178">
                                                    <a href="javascript:void(0)" class="product-title">
                                                        <div class="product-img">
                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                        </div>
                                                        <div class="product-info">
                                                            REG240500178
                                                            <span class="badge badge-warning float-right">22/05/2024</span>
                                                            <span class="product-description">
                                                                Rawat Jalan - Umum<br>
                                                                8
                                                            </span>

                                                        </div>
                                                    </a>
                                                </li>

                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500177" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/22/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="27" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="7" data-suhu="7" data-nafas="7" data-tekanan_darah="7" data-tinggi_badan="7" data-berat_badan="7" data-keluhan_utama="7" data-keluhan_sekunder="7" data-diagnosa_utama="Anemi aplastik" data-diagnosa_sekunder="Anemi aplastik" data-diagnosa_note="7" data-pf_rambut="7" data-pf_mata="7" data-pf_telinga="7" data-pf_hidung="7" data-pf_tenggorokan="7" data-photo="24050024_REG240500177">
                                                    <a href="javascript:void(0)" class="product-title">
                                                        <div class="product-img">
                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                        </div>
                                                        <div class="product-info">
                                                            REG240500177
                                                            <span class="badge badge-warning float-right">22/05/2024</span>
                                                            <span class="product-description">
                                                                Rawat Jalan - Umum<br>
                                                                7
                                                            </span>

                                                        </div>
                                                    </a>
                                                </li>

                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500176" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/22/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="27" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="6" data-suhu="6" data-nafas="6" data-tekanan_darah="6" data-tinggi_badan="6" data-berat_badan="6" data-keluhan_utama="6" data-keluhan_sekunder="1" data-diagnosa_utama="Anemi aplastik" data-diagnosa_sekunder="Anemi aplastik" data-diagnosa_note="1" data-pf_rambut="6" data-pf_mata="6" data-pf_telinga="6" data-pf_hidung="6" data-pf_tenggorokan="6" data-photo="24050024_REG240500176">
                                                    <a href="javascript:void(0)" class="product-title">
                                                        <div class="product-img">
                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                        </div>
                                                        <div class="product-info">
                                                            REG240500176
                                                            <span class="badge badge-warning float-right">22/05/2024</span>
                                                            <span class="product-description">
                                                                Rawat Jalan - Umum<br>
                                                                6
                                                            </span>

                                                        </div>
                                                    </a>
                                                </li>

                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500174" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/21/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="26" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="7" data-suhu="7" data-nafas="7" data-tekanan_darah="7" data-tinggi_badan="7" data-berat_badan="7" data-keluhan_utama="7" data-keluhan_sekunder="7" data-diagnosa_utama="Anemi aplastik" data-diagnosa_sekunder="TEST4" data-diagnosa_note="7" data-pf_rambut="7" data-pf_mata="7" data-pf_telinga="7" data-pf_hidung="7" data-pf_tenggorokan="7" data-photo="24050024_REG240500174">
                                                    <a href="javascript:void(0)" class="product-title">
                                                        <div class="product-img">
                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                        </div>
                                                        <div class="product-info">
                                                            REG240500174
                                                            <span class="badge badge-warning float-right">21/05/2024</span>
                                                            <span class="product-description">
                                                                Rawat Jalan - Umum<br>
                                                                7
                                                            </span>

                                                        </div>
                                                    </a>
                                                </li>

                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500173" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/21/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="26" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="0" data-suhu="0" data-nafas="0" data-tekanan_darah="0" data-tinggi_badan="0" data-berat_badan="0" data-keluhan_utama="" data-keluhan_sekunder="" data-diagnosa_utama="" data-diagnosa_sekunder="" data-diagnosa_note="" data-pf_rambut="" data-pf_mata="" data-pf_telinga="" data-pf_hidung="" data-pf_tenggorokan="" data-photo="">
                                                    <a href="javascript:void(0)" class="product-title">
                                                        <div class="product-img">
                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                        </div>
                                                        <div class="product-info">
                                                            REG240500173
                                                            <span class="badge badge-warning float-right">21/05/2024</span>
                                                            <span class="product-description">
                                                                Rawat Jalan - Umum<br>

                                                            </span>

                                                        </div>
                                                    </a>
                                                </li>

                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500172" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/21/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="26" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="4" data-suhu="4" data-nafas="4" data-tekanan_darah="4" data-tinggi_badan="4" data-berat_badan="4" data-keluhan_utama="4" data-keluhan_sekunder="4" data-diagnosa_utama="Anemi aplastik" data-diagnosa_sekunder="Anemi aplastik" data-diagnosa_note="44" data-pf_rambut="4" data-pf_mata="4" data-pf_telinga="4" data-pf_hidung="4" data-pf_tenggorokan="4" data-photo="24050024_REG240500172">
                                                    <a href="javascript:void(0)" class="product-title">
                                                        <div class="product-img">
                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                        </div>
                                                        <div class="product-info">
                                                            REG240500172
                                                            <span class="badge badge-warning float-right">21/05/2024</span>
                                                            <span class="product-description">
                                                                Rawat Jalan - Umum<br>
                                                                4
                                                            </span>

                                                        </div>
                                                    </a>
                                                </li>

                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500171" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/20/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="25" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="0" data-suhu="0" data-nafas="0" data-tekanan_darah="0" data-tinggi_badan="0" data-berat_badan="0" data-keluhan_utama="" data-keluhan_sekunder="" data-diagnosa_utama="" data-diagnosa_sekunder="" data-diagnosa_note="" data-pf_rambut="" data-pf_mata="" data-pf_telinga="" data-pf_hidung="" data-pf_tenggorokan="" data-photo="">
                                                    <a href="javascript:void(0)" class="product-title">
                                                        <div class="product-img">
                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                        </div>
                                                        <div class="product-info">
                                                            REG240500171
                                                            <span class="badge badge-warning float-right">20/05/2024</span>
                                                            <span class="product-description">
                                                                Rawat Jalan - Umum<br>

                                                            </span>

                                                        </div>
                                                    </a>
                                                </li>

                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500170" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/20/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="25" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="3" data-suhu="3" data-nafas="3" data-tekanan_darah="3" data-tinggi_badan="3" data-berat_badan="3" data-keluhan_utama="3" data-keluhan_sekunder="3" data-diagnosa_utama="Anemi aplastik" data-diagnosa_sekunder="Anemi aplastik" data-diagnosa_note="3" data-pf_rambut="3" data-pf_mata="3" data-pf_telinga="3" data-pf_hidung="3" data-pf_tenggorokan="3" data-photo="24050024_REG240500170">
                                                    <a href="javascript:void(0)" class="product-title">
                                                        <div class="product-img">
                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                        </div>
                                                        <div class="product-info">
                                                            REG240500170
                                                            <span class="badge badge-warning float-right">20/05/2024</span>
                                                            <span class="product-description">
                                                                Rawat Jalan - Umum<br>
                                                                3
                                                            </span>

                                                        </div>
                                                    </a>
                                                </li>

                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500169" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/20/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="25" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="1" data-suhu="1" data-nafas="1" data-tekanan_darah="1" data-tinggi_badan="1" data-berat_badan="1" data-keluhan_utama="1" data-keluhan_sekunder="1" data-diagnosa_utama="TEST4" data-diagnosa_sekunder="TEST4" data-diagnosa_note="1" data-pf_rambut="1" data-pf_mata="1" data-pf_telinga="1" data-pf_hidung="1" data-pf_tenggorokan="1" data-photo="24050024_REG240500169">
                                                    <a href="javascript:void(0)" class="product-title">
                                                        <div class="product-img">
                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                        </div>
                                                        <div class="product-info">
                                                            REG240500169
                                                            <span class="badge badge-warning float-right">20/05/2024</span>
                                                            <span class="product-description">
                                                                Rawat Jalan - Umum<br>
                                                                1
                                                            </span>

                                                        </div>
                                                    </a>
                                                </li>

                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500168" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/20/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="25" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="0" data-suhu="0" data-nafas="0" data-tekanan_darah="0" data-tinggi_badan="0" data-berat_badan="0" data-keluhan_utama="Sering Pusing " data-keluhan_sekunder="Muntah-muntah" data-diagnosa_utama="TEST5" data-diagnosa_sekunder="TEST6" data-diagnosa_note="Ada menjurus kearah gangguan vertigo" data-pf_rambut="Rambut Rontok" data-pf_mata="Pupil agak mengecil" data-pf_telinga="Telinga bersih" data-pf_hidung="Bersih" data-pf_tenggorokan="Bagus" data-photo="24050024_REG240500168">
                                                    <a href="javascript:void(0)" class="product-title">
                                                        <div class="product-img">
                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                        </div>
                                                        <div class="product-info">
                                                            REG240500168
                                                            <span class="badge badge-warning float-right">20/05/2024</span>
                                                            <span class="product-description">
                                                                Rawat Jalan - Umum<br>
                                                                Sering Pusing
                                                            </span>

                                                        </div>
                                                    </a>
                                                </li>

                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500167" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/17/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="22" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="0" data-suhu="0" data-nafas="0" data-tekanan_darah="0" data-tinggi_badan="0" data-berat_badan="0" data-keluhan_utama="" data-keluhan_sekunder="" data-diagnosa_utama="" data-diagnosa_sekunder="" data-diagnosa_note="" data-pf_rambut="" data-pf_mata="" data-pf_telinga="" data-pf_hidung="" data-pf_tenggorokan="" data-photo="">
                                                    <a href="javascript:void(0)" class="product-title">
                                                        <div class="product-img">
                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                        </div>
                                                        <div class="product-info">
                                                            REG240500167
                                                            <span class="badge badge-warning float-right">17/05/2024</span>
                                                            <span class="product-description">
                                                                Rawat Jalan - Umum<br>

                                                            </span>

                                                        </div>
                                                    </a>
                                                </li>

                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500165" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/16/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="21" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="0" data-suhu="0" data-nafas="0" data-tekanan_darah="0" data-tinggi_badan="0" data-berat_badan="0" data-keluhan_utama="" data-keluhan_sekunder="" data-diagnosa_utama="" data-diagnosa_sekunder="" data-diagnosa_note="" data-pf_rambut="" data-pf_mata="" data-pf_telinga="" data-pf_hidung="" data-pf_tenggorokan="" data-photo="">
                                                    <a href="javascript:void(0)" class="product-title">
                                                        <div class="product-img">
                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                        </div>
                                                        <div class="product-info">
                                                            REG240500165
                                                            <span class="badge badge-warning float-right">16/05/2024</span>
                                                            <span class="product-description">
                                                                Rawat Jalan - Umum<br>

                                                            </span>

                                                        </div>
                                                    </a>
                                                </li>

                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500164" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/16/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="21" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="3" data-suhu="3" data-nafas="3" data-tekanan_darah="3" data-tinggi_badan="3" data-berat_badan="3" data-keluhan_utama="3" data-keluhan_sekunder="3" data-diagnosa_utama="Anemi aplastik" data-diagnosa_sekunder="Anemi aplastik" data-diagnosa_note="3" data-pf_rambut="3" data-pf_mata="3" data-pf_telinga="3" data-pf_hidung="3" data-pf_tenggorokan="3" data-photo="24050024_REG240500164">
                                                    <a href="javascript:void(0)" class="product-title">
                                                        <div class="product-img">
                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                        </div>
                                                        <div class="product-info">
                                                            REG240500164
                                                            <span class="badge badge-warning float-right">16/05/2024</span>
                                                            <span class="product-description">
                                                                Rawat Jalan - Umum<br>
                                                                3
                                                            </span>

                                                        </div>
                                                    </a>
                                                </li>

                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500163" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/16/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="21" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="0" data-suhu="0" data-nafas="0" data-tekanan_darah="0" data-tinggi_badan="0" data-berat_badan="0" data-keluhan_utama="" data-keluhan_sekunder="" data-diagnosa_utama="" data-diagnosa_sekunder="" data-diagnosa_note="" data-pf_rambut="" data-pf_mata="" data-pf_telinga="" data-pf_hidung="" data-pf_tenggorokan="" data-photo="">
                                                    <a href="javascript:void(0)" class="product-title">
                                                        <div class="product-img">
                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                        </div>
                                                        <div class="product-info">
                                                            REG240500163
                                                            <span class="badge badge-warning float-right">16/05/2024</span>
                                                            <span class="product-description">
                                                                Rawat Jalan - Umum<br>

                                                            </span>

                                                        </div>
                                                    </a>
                                                </li>

                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500162" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/16/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="21" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="2" data-suhu="2" data-nafas="2" data-tekanan_darah="2" data-tinggi_badan="2" data-berat_badan="2" data-keluhan_utama="2" data-keluhan_sekunder="2" data-diagnosa_utama="Anemi aplastik" data-diagnosa_sekunder="Anemi aplastik" data-diagnosa_note="2" data-pf_rambut="2" data-pf_mata="2" data-pf_telinga="2" data-pf_hidung="2" data-pf_tenggorokan="2" data-photo="24050024_REG240500162">
                                                    <a href="javascript:void(0)" class="product-title">
                                                        <div class="product-img">
                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                        </div>
                                                        <div class="product-info">
                                                            REG240500162
                                                            <span class="badge badge-warning float-right">16/05/2024</span>
                                                            <span class="product-description">
                                                                Rawat Jalan - Umum<br>
                                                                2
                                                            </span>

                                                        </div>
                                                    </a>
                                                </li>

                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500161" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/16/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="21" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="5" data-suhu="5" data-nafas="5" data-tekanan_darah="5" data-tinggi_badan="5" data-berat_badan="5" data-keluhan_utama="5" data-keluhan_sekunder="5" data-diagnosa_utama="Anemi aplastik" data-diagnosa_sekunder="Anemi aplastik" data-diagnosa_note="5" data-pf_rambut="5" data-pf_mata="5" data-pf_telinga="5" data-pf_hidung="5" data-pf_tenggorokan="5" data-photo="24050024_REG240500161">
                                                    <a href="javascript:void(0)" class="product-title">
                                                        <div class="product-img">
                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                        </div>
                                                        <div class="product-info">
                                                            REG240500161
                                                            <span class="badge badge-warning float-right">16/05/2024</span>
                                                            <span class="product-description">
                                                                Rawat Jalan - Umum<br>
                                                                5
                                                            </span>

                                                        </div>
                                                    </a>
                                                </li>

                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500160" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/16/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="21" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="44" data-suhu="3" data-nafas="3" data-tekanan_darah="3" data-tinggi_badan="3" data-berat_badan="3" data-keluhan_utama="3" data-keluhan_sekunder="3" data-diagnosa_utama="Anemi aplastik" data-diagnosa_sekunder="Anemi aplastik" data-diagnosa_note="3" data-pf_rambut="3" data-pf_mata="3" data-pf_telinga="3" data-pf_hidung="3" data-pf_tenggorokan="3" data-photo="24050024_REG240500160">
                                                    <a href="javascript:void(0)" class="product-title">
                                                        <div class="product-img">
                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                        </div>
                                                        <div class="product-info">
                                                            REG240500160
                                                            <span class="badge badge-warning float-right">16/05/2024</span>
                                                            <span class="product-description">
                                                                Rawat Jalan - Umum<br>
                                                                3
                                                            </span>

                                                        </div>
                                                    </a>
                                                </li>

                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500159" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/16/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="21" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="2" data-suhu="2" data-nafas="2" data-tekanan_darah="2" data-tinggi_badan="2" data-berat_badan="2" data-keluhan_utama="2" data-keluhan_sekunder="2" data-diagnosa_utama="Anemi aplastik" data-diagnosa_sekunder="Anemi aplastik" data-diagnosa_note="2" data-pf_rambut="2" data-pf_mata="2" data-pf_telinga="2" data-pf_hidung="2" data-pf_tenggorokan="2" data-photo="24050024_REG240500159">
                                                    <a href="javascript:void(0)" class="product-title">
                                                        <div class="product-img">
                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                        </div>
                                                        <div class="product-info">
                                                            REG240500159
                                                            <span class="badge badge-warning float-right">16/05/2024</span>
                                                            <span class="product-description">
                                                                Rawat Jalan - Umum<br>
                                                                2
                                                            </span>

                                                        </div>
                                                    </a>
                                                </li>

                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500158" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/16/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="21" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="3" data-suhu="3" data-nafas="3" data-tekanan_darah="3" data-tinggi_badan="3" data-berat_badan="3" data-keluhan_utama="3" data-keluhan_sekunder="3" data-diagnosa_utama="Anemi aplastik" data-diagnosa_sekunder="TEST4" data-diagnosa_note="3" data-pf_rambut="3" data-pf_mata="3" data-pf_telinga="3" data-pf_hidung="3" data-pf_tenggorokan="3" data-photo="24050024_REG240500158">
                                                    <a href="javascript:void(0)" class="product-title">
                                                        <div class="product-img">
                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                        </div>
                                                        <div class="product-info">
                                                            REG240500158
                                                            <span class="badge badge-warning float-right">16/05/2024</span>
                                                            <span class="product-description">
                                                                Rawat Jalan - Umum<br>
                                                                3
                                                            </span>

                                                        </div>
                                                    </a>
                                                </li>

                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500157" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/16/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="21" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="0" data-suhu="0" data-nafas="0" data-tekanan_darah="0" data-tinggi_badan="0" data-berat_badan="0" data-keluhan_utama="" data-keluhan_sekunder="" data-diagnosa_utama="" data-diagnosa_sekunder="" data-diagnosa_note="" data-pf_rambut="" data-pf_mata="" data-pf_telinga="" data-pf_hidung="" data-pf_tenggorokan="" data-photo="">
                                                    <a href="javascript:void(0)" class="product-title">
                                                        <div class="product-img">
                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                        </div>
                                                        <div class="product-info">
                                                            REG240500157
                                                            <span class="badge badge-warning float-right">16/05/2024</span>
                                                            <span class="product-description">
                                                                Rawat Jalan - Umum<br>

                                                            </span>

                                                        </div>
                                                    </a>
                                                </li>

                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500156" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/16/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="21" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="0" data-suhu="0" data-nafas="0" data-tekanan_darah="0" data-tinggi_badan="0" data-berat_badan="0" data-keluhan_utama="" data-keluhan_sekunder="" data-diagnosa_utama="" data-diagnosa_sekunder="" data-diagnosa_note="" data-pf_rambut="" data-pf_mata="" data-pf_telinga="" data-pf_hidung="" data-pf_tenggorokan="" data-photo="">
                                                    <a href="javascript:void(0)" class="product-title">
                                                        <div class="product-img">
                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                        </div>
                                                        <div class="product-info">
                                                            REG240500156
                                                            <span class="badge badge-warning float-right">16/05/2024</span>
                                                            <span class="product-description">
                                                                Rawat Jalan - Umum<br>

                                                            </span>

                                                        </div>
                                                    </a>
                                                </li>

                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500154" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/16/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="21" data-nama_dokter="dr. SANTI SEPTIKA Sp. Rad" data-nadi="0" data-suhu="0" data-nafas="0" data-tekanan_darah="0" data-tinggi_badan="0" data-berat_badan="0" data-keluhan_utama="" data-keluhan_sekunder="" data-diagnosa_utama="" data-diagnosa_sekunder="" data-diagnosa_note="" data-pf_rambut="" data-pf_mata="" data-pf_telinga="" data-pf_hidung="" data-pf_tenggorokan="" data-photo="">
                                                    <a href="javascript:void(0)" class="product-title">
                                                        <div class="product-img">
                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                        </div>
                                                        <div class="product-info">
                                                            REG240500154
                                                            <span class="badge badge-warning float-right">16/05/2024</span>
                                                            <span class="product-description">
                                                                Rawat Jalan - Umum<br>

                                                            </span>

                                                        </div>
                                                    </a>
                                                </li>

                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500153" data-no_pasien="24050024" data-tujuan_registrasi_desc="Umum" data-tgl_praktek="5/15/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="20" data-nama_dokter="dr. SAHAR BAWAZEER Sp.B" data-nadi="1" data-suhu="1" data-nafas="1" data-tekanan_darah="1" data-tinggi_badan="1" data-berat_badan="1" data-keluhan_utama="1" data-keluhan_sekunder="1" data-diagnosa_utama="Anemi aplastik" data-diagnosa_sekunder="Anemi aplastik" data-diagnosa_note="1" data-pf_rambut="1" data-pf_mata="1" data-pf_telinga="1" data-pf_hidung="1" data-pf_tenggorokan="1" data-photo="24050024_REG240500153">
                                                    <a href="javascript:void(0)" class="product-title">
                                                        <div class="product-img">
                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                        </div>
                                                        <div class="product-info">
                                                            REG240500153
                                                            <span class="badge badge-warning float-right">15/05/2024</span>
                                                            <span class="product-description">
                                                                Rawat Jalan - Umum<br>
                                                                1
                                                            </span>

                                                        </div>
                                                    </a>
                                                </li>

                                                <li class="item pilihregistrasi" data-no_registrasi="REG240500152" data-no_pasien="24050024" data-tujuan_registrasi_desc="Radiologi" data-tgl_praktek="5/15/2024 12:00:00 AM" data-tahun="35" data-bulan="1" data-hari="20" data-nama_dokter="dr. SANTI SEPTIKA Sp. Rad" data-nadi="13" data-suhu="13" data-nafas="13" data-tekanan_darah="13" data-tinggi_badan="13" data-berat_badan="13" data-keluhan_utama="13" data-keluhan_sekunder="13" data-diagnosa_utama="Anemi aplastik" data-diagnosa_sekunder="TEST4" data-diagnosa_note="13" data-pf_rambut="13" data-pf_mata="13" data-pf_telinga="13" data-pf_hidung="13" data-pf_tenggorokan="13" data-photo="24050024_REG240500152">
                                                    <a href="javascript:void(0)" class="product-title">
                                                        <div class="product-img">
                                                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                        </div>
                                                        <div class="product-info">
                                                            REG240500152
                                                            <span class="badge badge-warning float-right">15/05/2024</span>
                                                            <span class="product-description">
                                                                Rawat Jalan - Radiologi<br>
                                                                13
                                                            </span>

                                                        </div>
                                                    </a>
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
                                                                            <dt class="caption_text">Suhu (°c)</dt>
                                                                            <dd><span id="suhu_rm" class="content_text"></span> °C</dd>
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
                                                                                <dd class="alergi">test</dd>
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

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="vert-tabs-five" role="tabpanel" aria-labelledby="vert-tabs-five-tab">
                <div class="row">
                    <div class="col-12">
                        <h5>SURAT</h5>
                        <button type="button" class="btn btn-default btn-xs" id="modalSuratBtn">
                            Buat Surat
                        </button>
                        <!-- <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <span class="list_surat"></span>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>

            </div>
        </div>
</div>
</div>

</div>
<!-- /.col -->
</div>
<!-- /.row -->

<!-- Modal -->
<div class="modal fade" id="modalSurat" tabindex=" " role="dialog" aria-labelledby="modalSuratLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="modalSuratLabel">Surat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <!-- textarea -->
                                            <div class="form-group">
                                                <label>Keterangan Surat</label>
                                                <textarea class="form-control" name="ket_surat" rows="4" placeholder="Enter ..." id="ket_surat"></textarea>
                                                <span class="error invalid-feedback errorKet_surat">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="row mb-2">
                                        <div class="col-sm-12">
                                            <!-- textarea -->
                                            <div class="form-group">
                                                <label>Jenis Surat</label>
                                                <?= $cb_jenissurat ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-12">
                                            <!-- textarea -->
                                            <!-- <div class="form-group">
                                                <label>Catatan Konsultasi Dibuat Oleh</label>
                                                <input class="form-control form1" name="user_rujukan" id="user_rujukan" readonly />
                                                <span class="error invalid-feedback errorUser_rujukan">
                                            </div> -->
                                            <button type="button" class="btn-block btn-danger btn-md" id="clearSuratBtn">
                                                Hapus Isi Surat
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <textarea id="summernotet2" name="rujukan"></textarea>
                                    <input type="hidden" class="no_registrasi" name="no_registrasi" />
                                    <input type="hidden" id="action" name="action" value="Add" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="modal-footer">
                            <button id="btnclose" type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        </div> -->

        </div>
    </div>
</div>
<!-- /end modal -->

<!-- Modal -->
<div class="modal fade" id="modalCopyAnamnesa" tabindex=" " role="dialog" aria-labelledby="modalCopyAnamnesaLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="modalCopyAnamnesaLabel">Anamnesa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12 col-sm-12">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card card-info">
                                        <!-- <div class="card-header">

                                                        <h3 class="card-title">
                                                            <button type="button" class="btn btn-tool refreshTitikKeluhan" data-card-widget="" data-no_registrasi="REG240600207"><i id="refreshBtn" class="fas fa-sync-alt"></i>
                                                            </button>

                                                        </h3>
                                                        <div class="card-tools" style="margin: 0rem 0rem 0rem !important;">
                                                            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                                                            </button>
                                                        </div>
                                                    </div> -->

                                        <div class="card-body" style="height: 75vh; overflow-y: scroll;">


                                            <span id="viewanamnesacard"></span>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <!-- textarea -->
                                            <div class="form-group">
                                                <label>Keluhan Utama</label>
                                                <textarea class="form-control" name="keluhan_utama_c" rows="3" placeholder="Enter ..." id="keluhan_utama_c" readonly></textarea>
                                                <span class="error invalid-feedback errorKeluhan_utama_c">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-check" style="margin-top: 3rem;">
                                                <input type="checkbox" class="form-check-input" id="checkKeluhan_utama_c">
                                                <label class="form-check-label" for="checkKeluhan_utama_c"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <!-- textarea -->
                                            <div class="form-group">
                                                <label>Riwayat Perjalanan Keluhan</label>
                                                <textarea class="form-control" name="riwayat_perjalanan_keluhan_c" rows="3" placeholder="Enter ..." id="riwayat_perjalanan_keluhan_c" readonly></textarea>
                                                <span class="error invalid-feedback errorRiwayat_perjalanan_keluhan_c">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-check" style="margin-top: 3rem;">
                                                <input type="checkbox" class="form-check-input" id="checkRiwayat_perjalanan_keluhan_c">
                                                <label class="form-check-label" for="checkRiwayat_perjalanan_keluhan_c"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <!-- textarea -->
                                            <div class="form-group">
                                                <label>Riwayat Penyakit Sekarang - Hapus</label>
                                                <textarea class="form-control" name="riwayat_penyakit_sekarang_c" rows="3" placeholder="Enter ..." id="riwayat_penyakit_sekarang_c" readonly></textarea>
                                                <span class="error invalid-feedback errorRiwayat_penyakit_sekarang_c">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-check" style="margin-top: 3rem;">
                                                <input type="checkbox" class="form-check-input" id="checkRiwayat_penyakit_sekarang_c">
                                                <label class="form-check-label" for="checkRiwayat_penyakit_sekarang_c"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <!-- textarea -->
                                            <div class="form-group">
                                                <label>Riwayat Operasi / Pengobatan</label>
                                                <textarea class="form-control" name="riwayat_operasi_pengobatan_c" rows="3" placeholder="Enter ..." id="riwayat_operasi_pengobatan_c" readonly></textarea>
                                                <span class="error invalid-feedback errorRiwayat_operasi_pengobatan_c">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-check" style="margin-top: 3rem;">
                                                <input type="checkbox" class="form-check-input" id="checkRiwayat_operasi_pengobatan_c">
                                                <label class="form-check-label" for="checkRiwayat_operasi_pengobatan_c"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <!-- textarea -->
                                            <div class="form-group">
                                                <label>Riwayat Penyakit Keluarga</label>
                                                <textarea class="form-control" name="riwayat_penyakit_keluarga_c" rows="3" placeholder="Enter ..." id="riwayat_penyakit_keluarga_c" readonly></textarea>
                                                <span class="error invalid-feedback errorRiwayat_penyakit_keluarga_c">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-check" style="margin-top: 3rem;">
                                                <input type="checkbox" class="form-check-input" id="checkRiwayat_penyakit_keluarga_c">
                                                <label class="form-check-label" for="checkRiwayat_penyakit_keluarga_c"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <!-- textarea -->
                                            <div class="form-group">
                                                <label>Riwayat Lain - lain</label>
                                                <textarea class="form-control" name="riwayat_lain_c" rows="3" placeholder="Enter ..." id="riwayat_lain_c" readonly></textarea>
                                                <span class="error invalid-feedback errorRiwayat_lain_c">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-check" style="margin-top: 3rem;">
                                                <input type="checkbox" class="form-check-input" id="checkRiwayat_lain_c">
                                                <label class="form-check-label" for="checkRiwayat_lain_c"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-11">
                                            <!-- textarea -->
                                            <div class="form-group">
                                                <label>Riwayat Penyakit Dahulu</label>
                                                <textarea class="form-control" name="riwayat_penyakit_dahulu_c" rows="3" placeholder="Enter ..." id="riwayat_penyakit_dahulu_c" readonly></textarea>
                                                <span class="error invalid-feedback errorRiwayat_penyakit_dahulu_c">
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                            <div class="form-check" style="margin-top: 3rem;">
                                                <input type="checkbox" class="form-check-input" id="checkRiwayat_penyakit_dahulu_c">
                                                <label class="form-check-label" for="checkRiwayat_penyakit_dahulu_c"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-11">
                                            <button name="submit" id="copy_button" class="btn btn-primary btn-sm float-right ml-1" value="Salin">Salin</button>
                                            <button name="submit" id="clear_button" class="btn btn-warning btn-sm float-right" value="Tutup">Tutup</button>
                                        </div>
                                        <div class="col-sm-1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="modal-footer">
                            <button id="btnclose" type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        </div> -->

        </div>
    </div>
</div>
<!-- /end modal -->

<!-- Modal -->
<div class="modal fade" id="modalformregistrasi" tabindex="" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Appointment</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="data_form_appointment" autocomplete="off">
                <?= csrf_field(); ?>
                <div class="modal-body">

                    <div class="mb-3 row">

                        <input type="hidden" name="tgl_registrasi" value="<?= date('Y-m-d') ?>">

                        <label for="tanggal" class="col-sm-2 col-form-label">Tanggal Kunjungan</label>
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

                    <div class="mb-3 row">
                        <label for="jam_mulai" class="col-sm-2 col-form-label">Jam Mulai</label>
                        <div class="col-sm-4">
                            <input type="time" class="form-control form-control-sm" id="jam_mulai" name="jam_mulai">
                            <span class="error invalid-feedback errorJam_mulai">
                            </span>
                        </div>
                        <label for="jam_selesai" class="col-sm-2 col-form-label">jam Selesai</label>
                        <div class="col-sm-4">
                            <input type="time" class="form-control form-control-sm" id="jam_selesai" name="jam_selesai">
                            <span class="error invalid-feedback errorJam_selesai">
                            </span>
                        </div>
                    </div>

                    <input type="hidden" id="cashless" name="cashless" value="0">
                    <input type="hidden" id="ap_patient_no" name="patient_no">
                    <input type="hidden" id="ap_tujuan_registrasi" name="tujuan_registrasi">
                    <input type="hidden" id="ap_tipe_pasien" name="Tipe_Pasien" value="UMUM">
                    <input type="hidden" id="nama_dokter" name="nama_dokter">

                    <!-- <input type="hidden" id="tanggal" name="tanggal"> -->
                    <!-- <input type="text" id="tgl_registrasi" name="tgl_registrasi"> -->
                    <!-- <input type="text" id="ap_jam_mulai" name="jam_mulai">
                    <input type="text" id="ap_jam_selesai" name="jam_selesai"> -->
                    <input type="hidden" id="ap_registrasi_via" name="registrasi_via" value="off">




                    <input type="hidden" id="ap_kode_dokter" name="kode_dokter">
                    <input type="hidden" id="ap_tahun" name="tahun">
                    <input type="hidden" id="ap_bulan" name="bulan">
                    <input type="hidden" id="ap_hari" name="hari">
                    <!-- <input type="hidden" id="registrasi_via" name="registrasi_via" value="offline"> -->



                </div>
                <div class="modal-footer">
                    <input type="hidden" id="hidden_id" name="hidden_id" />
                    <input type="hidden" id="action" name="action" value="Registrasi" />
                    <button type="submit" name="submit" id="submit_button4" class="btn btn-sm btn-primary" value="Simpan"></button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                </div>

            </form>
        </div>
    </div>
</div>

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

<!-- Summernote -->
<!-- <script src="../../plugins/summernote/summernote-bs4.min.js"></script> -->


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

    function clearForm() {

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

        // $('#submit_button2').val('SIMPAN');
        // $('#submit_button2').html('SIMPAN');

        // riwayatRm($('.medrec_id_info').text());
        // tregistrasi();

        /* SET FORM */
        //Anamnesa
        $('input[name=responden]').prop('checked', false);
        $('#keluhan_utama').val('');
        $('#riwayat_perjalanan_keluhan').val('');
        $('#riwayat_penyakit_sekarang').val('');
        $('#riwayat_penyakit_dahulu').val('');
        $('#riwayat_operasi_pengobatan').val('');
        $('#riwayat_penyakit_keluarga').val('');
        $('#riwayat_lain').val('');

        //Pemeriksaan
        $('#kondisi_umum').val('');
        $('#tinggi_badan').val('');
        $('#berat_badan').val('');
        $('#bmi').val('');
        $('#suhu').val('');
        $('#sistolik').val('');
        $('#diastolik').val('');
        $('#denyut_nadi').val('');
        $('#laju_nafas').val('');
        $('#kondisi_khusus').val('');
        $('#pemeriksaan_tambahan').val('');

        //Diagnosa
        $('#diagnosa_utama').val('');
        $('input[name=klasifikasi_utama]').prop('checked', false);
        $('#diagnosa_sekunder').val('');
        $('input[name=klasifikasi_sekunder]').prop('checked', false);

        $('.all_row_diagnosa').remove();

        $('.all_row').remove();

        //Layanan
        $('h2#grand_total').val('Rp. 0,00');

        //Tindakan 
        $('#ket_rujukan').val('');
        $('#summernotet').summernote('code', '');
    }

    function tregistrasi() {
        $.ajax({
            method: "get",
            url: "<?= site_url('konsultasidokter/fetchAll'); ?>",
            beforeSend: function() {
                $('#wheelChair').prop('disabled', true);
                $('#wheelChair').html('<i class="fas fa-sync-alt fa-spin"></i>');
            },
            complete: function() {
                $('#wheelChair').prop('disabled', false);
                $('#wheelChair').html('<i class="fas fa-wheelchair"></i>');
            },
            success: function(data) {
                $('#viewdata').html(data);
            }
        });
    }

    // function alergi(patient_no) {
    //     $.ajax({
    //         method: "get",
    //         data: {
    //             patient_no: patient_no
    //         },
    //         url: "<?= site_url('konsultasidokter/fetchAllAlergi'); ?>",
    //         success: function(data) {
    //             $('#dynamic_alergi').append(data);
    //         }
    //     });
    // }

    function alergi(patient_no) {
        $.ajax({
            method: "get",
            dataType: "JSON",
            data: {
                patient_no: patient_no
            },
            url: "<?= site_url('konsultasidokter/apiDataGetAlergiByPasien'); ?>",
            success: function(data) {
                return data.length;
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
        $(document).on('click', '.appointment', function() {

            $("#modalformregistrasi").modal('show');

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
                    // $('#no_pasien_v').val(response.data.no_pasien);
                    $('#tgl_registrasi_v').val(convertDateIndo(response.data.tgl_registrasi));
                    $('#tanggal_v').val(convertDateIndo(response.data.tgl_praktek));
                    $('#nama_dokter_v').val(response.data.nama_dokter);
                    $('#jam_mulai_v').val(response.data.jam_mulai);
                    $('#jam_selesai_v').val(response.data.jam_selesai);

                    $('#patient_no_v').val(response.data.no_pasien);
                    $('#patient_no_v').trigger('change');
                    $('#patient_no_v').attr('disabled', '');
                    $('#tujuan_registrasi_v').val(response.data.tujuan_registrasi);
                    $('#tujuan_registrasi_v').trigger('change');
                    $('#tujuan_registrasi_v').attr('disabled', '');
                    $('#Tipe_Pasien_v').val(response.data.Tipe_Pasien);
                    $('#Tipe_Pasien_v').trigger('change');
                    $('#Tipe_Pasien_v').attr('disabled', '');
                    $('#asr_cd_v').val(response.data.asr_cd);
                    $('#asr_cd_v').trigger('change');
                    $('#asr_cd_v').attr('disabled', '');

                    $('#nama_v').val(response.data.fullname);
                    $('#gender_v').val(response.data.gender == 'F' ? 'Perempuan' : 'Laki - Laki');
                    $('#birth_dt_v').val(convertDateIndo(response.data.birth_dt));
                    $('#addr_v').val(response.data.addr);
                    $('#mobile_no_v').val(response.data.mobile_no);
                    $('p#usia').html('<b>' + response.data.tahun + '</b> Tahun, <b>' + response.data.bulan + '</b> Bulan, <b>' + response.data.hari + '</b> Hari');

                    $('.modal-title').text('Lihat Data');
                    $("#modalappointment").modal('show');
                    // $('#viewjadwalbydokter').html(data);
                }
            });
        });

        $('#data_form_appointment').on('submit', function(event) {
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
                // data: {
                //     nama: nama,
                //     value: value,
                //     desc: desc,
                //     action: action
                // },
                dataType: "JSON",
                // beforeSend: function() {
                //     // $('#asr_cd').removeAttr('disabled');
                //     // $('#asr_cd').val('ASR202402008');
                //     // $('#asr_cd').trigger('change');
                // },
                // complete: function() {
                //     $('#asr_cd').attr('disabled', '');
                // },
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
                        alert('terjadi error!');

                    } else {
                        //sweet alert
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                            //footer: '<a href="">Why do I have this issue?</a>'
                        });


                        $('#modalformregistrasi').modal('hide');
                    }
                },
            })
        });

        $(document).on('click', '.riwayat', function() {
            var no_registrasi = $(this).data('no_registrasi');
            var patient_no = $(this).data('patient_no');
            $("#overlay-riwayat-pemeriksaan").css("display", "flex");

            $.ajax({
                url: "<?= site_url('konsultasidokter/apiDataGetAlergiByPasien'); ?>",
                method: "GET",
                data: {
                    patient_no: patient_no
                },
                dataType: "JSON",
                success: function(data) {

                    $('#alergi_array_length').val(data.length);

                    $('.r_all_row').remove();

                    for (var i = 0; i < data.length; i++) {

                        $('#r_dynamic_alergi').append('<tr id="r_row' + i + '" class="r_all_row"><td><select class="custom-select" name="r_kategori_alergi[]" id="r_kategori_alergi' + i + '"><option value="' + data[i].kategori + '" selected="selected">' + data[i].kategori_desc + '</option></select></td><td><select class="custom-select" multiple="multiple" name="komponen_alergi[]" id="komponen_alergi' + i + '"><option value="' + data[i].komponen + '" selected="selected">' + data[i].komponen_desc + '</option></select></td><td><select class="custom-select" multiple="multiple" name="reaksi_alergi[]" id="reaksi_alergi' + i + '"><option value="' + data[i].reaksi + '" selected="selected">' + data[i].reaksi_desc + '</option></select></td><td><input type="hidden" name="alergi_no[]" value="' + data[i].alergi_no + '"><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove_alergi" data-alergi_no="' + data[i].alergi_no + '" data-patient_no="' + data[i].patient_no + '">X</button></td></tr>');

                        $('#r_kategori_alergi' + i + '', '#r_dynamic_alergi').select2({
                            ajax: {
                                url: "<?= site_url('konsultasidokter/ajaxKategoriAlergi/kategori_alergi'); ?>",
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
                            placeholder: 'Search ...',
                            minimumInputLength: 0,
                            width: 'auto',
                            // templateResult: formatResult2 //your selection format
                        });

                        $('#r_komponen_alergi' + i + '', '#r_dynamic_alergi').select2({
                            ajax: {
                                url: "<?= site_url('konsultasidokter/ajaxKategoriAlergi/komponen_alergi'); ?>",
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
                            placeholder: 'Search ...',
                            minimumInputLength: 0,
                            width: 'auto',
                            // templateResult: formatResult2 //your selection format
                        });

                        $('#r_reaksi_alergi' + i + '', '#r_dynamic_alergi').select2({
                            ajax: {
                                url: "<?= site_url('konsultasidokter/ajaxKategoriAlergi/reaksi_alergi'); ?>",
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
                            placeholder: 'Search ...',
                            minimumInputLength: 0,
                            width: 'auto',
                            // templateResult: formatResult2 //your selection format
                        });


                    }

                }
            });

            $.ajax({

                url: "<?= site_url('konsultasidokter/apiDataGetDiagnosaTambahanByRegistrasi'); ?>",
                method: "GET",
                data: {
                    no_registrasi: no_registrasi
                },
                dataType: "JSON",
                success: function(data) {

                    $('#diagnosa_array_length').val(data.length);

                    $('.r_all_row_diagnosa').remove();

                    for (var i = 0; i < data.length; i++) {

                        function formatResult2(item) {
                            //checks if the id present or not
                            if (!item.id) {
                                return item.text;
                            }
                            //return the format options..
                            var element = $(`<span>${item.id} - ${item.english} <br><span style="color:red;">[ ${item.indonesia} ]</span></span>'`)
                            return element;
                        };

                        $('#r_dynamic_field').append('<div class="card r_all_row_diagnosa" id="row' + i + '" ><div class="card-body"><div class="row"><div class="col-sm-12"><div class="form-group"><label>Diagnosa Tambahan</label><input type="text" name="diagnosa_tambahan[]" class="form-control" placeholder="" id="diagnosa_tambahan' + i + '" value="' + data[i].diagnosa + '"><span class="error invalid-feedback errorDiagnosa_tambahan"></span></div></div></div><div class="row"><div class="col-sm-12"><label>ICD 10 </label><div class="form-group"><select class="form-control form-control-sm" name="icd10_tambahan[]" id="r_icd10_tambahan' + i + '"><option value=" " selected="selected">-- Select --</option></select></div></div></div><div class="row"><div class="col-sm-12"><label></label><br><div class="form-group d-flex justify-content-between align-items-center"><div class="form-check-inline"><label class="form-check-label"><input type="radio" class="form-check-input radio" name="klasifikasi_tambahan' + i + '" value="terduga" data-id="' + i + '" ' + (data[i].klasifikasi == 'terduga' ? 'checked' : '') + '>Terduga</label></div><div class="form-check-inline"><label class="form-check-label"><input type="radio" class="form-check-input radio" name="klasifikasi_tambahan' + i + '" value="gejala"  data-id="' + i + '" ' + (data[i].klasifikasi == 'gejala' ? 'checked' : '') + '>Gejala</label></div><div class="form-check-inline"><label class="form-check-label"><input type="radio" class="form-check-input radio" name="klasifikasi_tambahan' + i + '" value="dikonfirmasi" data-id="' + i + '" ' + (data[i].klasifikasi == 'dikonfirmasi' ? 'checked' : '') + '>Sudah Dikonfirmasi</label></div><br></div></div></div><div class="row"><input type="hidden" name="klasifikasi_tambahan[]" id="klasifikasi_tambahan' + i + '" value="' + data[i].klasifikasi + '"><div class="col-sm-12"><input type="hidden" name="seq_id[]" value="' + data[i].seq_id + '"><button type="button" name="remove" id="' + i + '" class="btn btn-xs btn-danger btn_remove float-right" data-no_registrasi="' + data[i].no_registrasi + '" data-seq_id="' + data[i].seq_id + '">HAPUS</button></div></div></div></div>');

                        $('#r_icd10_tambahan' + i + '', '#r_dynamic_field').select2({
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
                            placeholder: 'Search for a ICD10...',
                            minimumInputLength: 1,
                            templateResult: formatResult2 //your selection format
                        });

                        var defaultValueUtama = {
                            id: data[i].icd10_tambahan,
                            text: data[i].icd10_tambahan
                        };

                        var newOptionUtama = new Option(defaultValueUtama.text, defaultValueUtama.id, true, true);
                        $('#r_icd10_tambahan' + i + '', '#r_dynamic_field').append(newOptionUtama).trigger('change');

                    }

                }
            });

            // alergi(patient_no);

            if ($(this).data('status') === 'DT') {
                $('#status').val('Draft');
            } else {
                $('#status').val('New');
            }



            /* SET FORM */
            //Anamnesa
            $('input[name=responden]').prop('checked', false);
            $('#r_keluhan_utama').val('');
            $('#r_riwayat_perjalanan_keluhan').val('');
            $('#r_riwayat_penyakit_sekarang').val('');
            $('#r_riwayat_penyakit_dahulu').val('');
            $('#r_riwayat_operasi_pengobatan').val('');
            $('#r_riwayat_penyakit_keluarga').val('');
            $('#r_riwayat_lain').val('');

            //Pemeriksaan
            $('#r_kondisi_umum').val('');
            $('#r_tinggi_badan').val('');
            $('#r_berat_badan').val('');
            $('#r_bmi').val('');
            $('#r_suhu').val('');
            $('#r_sistolik').val('');
            $('#r_diastolik').val('');
            $('#r_denyut_nadi').val('');
            $('#r_laju_nafas').val('');
            $('#r_kondisi_khusus').val('');
            $('#r_pemeriksaan_tambahan').val('');

            //Diagnosa
            $('#r_diagnosa_utama').val('');
            $('input[name=klasifikasi_utama]').prop('checked', false);
            $('#r_diagnosa_sekunder').val('');
            $('input[name=klasifikasi_sekunder]').prop('checked', false);

            $.ajax({

                url: "<?= site_url('konsultasidokter/apiDataGetAnamnesa'); ?>",
                method: "GET",
                data: {
                    no_registrasi: no_registrasi
                },
                dataType: "JSON",
                success: function(data) {

                    if (data.length > 0) {
                        /* SET FORM */
                        //Anamnesa
                        $('input[type=radio][name*=responden][value=' + (data[0].keluhan_utama == 'True' ? 1 : 0) + ']').prop('checked', true).change();
                        // $('input[name=responden]').prop('checked', false);
                        $('#r_keluhan_utama').val(data[0].keluhan_utama);
                        $('#r_riwayat_perjalanan_keluhan').val(data[0].riwayat_perjalanan_keluhan);
                        $('#r_riwayat_penyakit_sekarang').val(data[0].riwayat_penyakit_sekarang);
                        $('#r_riwayat_penyakit_dahulu').val(data[0].riwayat_penyakit_dahulu);
                        $('#r_riwayat_operasi_pengobatan').val(data[0].riwayat_operasi_pengobatan);
                        $('#r_riwayat_penyakit_keluarga').val(data[0].riwayat_penyakit_keluarga);
                        $('#r_riwayat_lain').val(data[0].riwayat_lain);
                    } else {
                        /* SET FORM */
                        //Anamnesa
                        $('input[name=responden]').prop('checked', false);
                        $('#r_keluhan_utama').val('');
                        $('#r_riwayat_perjalanan_keluhan').val('');
                        $('#r_riwayat_penyakit_sekarang').val('');
                        $('#r_riwayat_penyakit_dahulu').val('');
                        $('#r_riwayat_operasi_pengobatan').val('');
                        $('#r_riwayat_penyakit_keluarga').val('');
                        $('#r_riwayat_lain').val('');
                    }

                }
            });

            $.ajax({

                url: "<?= site_url('konsultasidokter/apiDataGetPeriksa'); ?>",
                method: "GET",
                data: {
                    no_registrasi: no_registrasi
                },
                dataType: "JSON",
                success: function(data) {

                    if (data.length > 0) {
                        /* SET FORM */
                        //Pemeriksaan
                        $('#r_kondisi_umum').val(data[0].kondisi_umum);
                        $('#r_tinggi_badan').val(Math.trunc(data[0].tinggi_badan));
                        $('#r_berat_badan').val(Math.trunc(data[0].berat_badan));
                        $('#r_bmi').val(45);
                        $('#r_suhu').val(Math.trunc(data[0].suhu));
                        $('#r_sistolik').val(Math.trunc(data[0].sistolik));
                        $('#r_diastolik').val(Math.trunc(data[0].diastolik));
                        $('#r_denyut_nadi').val(Math.trunc(data[0].denyut_nadi));
                        $('#r_laju_nafas').val(Math.trunc(data[0].laju_nafas));
                        $('#r_kondisi_khusus').val(data[0].kondisi_khusus);
                        $('#r_pemeriksaan_tambahan').val(data[0].pemeriksaan_tambahan);

                        var tinggi = $('#r_tinggi_badan').val();
                        var berat = $('#r_berat_badan').val();
                        var bmi = berat / ((tinggi / 100) * (tinggi / 100));
                        $('#r_bmi').val(Math.round(bmi * 100) / 100);

                    } else {
                        /* SET FORM */
                        //Pemeriksaan
                        $('#r_kondisi_umum').val('');
                        $('#r_tinggi_badan').val('');
                        $('#r_berat_badan').val('');
                        $('#r_bmi').val('');
                        $('#r_suhu').val('');
                        $('#r_sistolik').val('');
                        $('#r_diastolik').val('');
                        $('#r_denyut_nadi').val('');
                        $('#r_laju_nafas').val('');
                        $('#r_kondisi_khusus').val('');
                        $('#r_pemeriksaan_tambahan').val('');
                    }
                }
            });

            $.ajax({

                url: "<?= site_url('konsultasidokter/apiDataGetDiagnosa'); ?>",
                method: "GET",
                data: {
                    no_registrasi: no_registrasi
                },
                dataType: "JSON",
                success: function(data) {

                    if (data.length > 0) {
                        /* SET FORM */
                        //Diagnosa
                        $('#r_diagnosa_utama').val(data[0].diagnosa_utama);
                        $('input[type=radio][name*=klasifikasi_utama][value=' + data[0].klasifikasi_utama + ']').prop('checked', true).change();
                        $('#r_diagnosa_sekunder').val(data[0].diagnosa_sekunder);
                        $('input[type=radio][name*=klasifikasi_sekunder][value=' + data[0].klasifikasi_sekunder + ']').prop('checked', true).change();

                        // Set the default value
                        var defaultValueUtama = {
                            id: data[0].icd10_utama,
                            text: data[0].icd10_utama
                        };
                        var newOptionUtama = new Option(defaultValueUtama.text, defaultValueUtama.id, true, true);
                        $('#r_icd10_utama').append(newOptionUtama).trigger('change');

                        var defaultValueSekunder = {
                            id: data[0].icd10_sekunder,
                            text: data[0].icd10_sekunder
                        };
                        var newOptionSekunder = new Option(defaultValueSekunder.text, defaultValueSekunder.id, true, true);
                        $('#r_icd10_sekunder').append(newOptionSekunder).trigger('change');

                    } else {
                        /* SET FORM */
                        //Diagnosa
                        $('#r_diagnosa_utama').val('');
                        $('input[name=klasifikasi_utama]').prop('checked', false);
                        $('#r_diagnosa_sekunder').val('');
                        $('input[name=klasifikasi_sekunder]').prop('checked', false);

                        $('#r_icd10_utama').val(' ');
                        $('#r_icd10_utama').trigger('change');
                        $('#r_icd10_sekunder').val(' ');
                        $('#r_icd10_sekunder').trigger('change');

                    }

                }
            });
        });

        $(document).on('click', '.dudu', function() {
            $('#keluhan_utama_c').val($(this).data('keluhan_utama'));
            $('#riwayat_perjalanan_keluhan_c').val($(this).data('riwayat_perjalanan_keluhan'));
            $('#riwayat_penyakit_sekarang_c').val($(this).data('riwayat_penyakit_sekarang'));
            $('#riwayat_operasi_pengobatan_c').val($(this).data('riwayat_operasi_pengobatan'));
            $('#riwayat_penyakit_keluarga_c').val($(this).data('riwayat_penyakit_keluarga'));
            $('#riwayat_lain_c').val($(this).data('riwayat_lain'));
            $('#riwayat_penyakit_dahulu_c').val($(this).data('riwayat_penyakit_dahulu'));
        });

        $(document).on('click', '#copy_button', function() {
            if ($('input#checkKeluhan_utama_c').is(':checked')) {
                $('#keluhan_utama').val($('#keluhan_utama_c').val());
            }
            if ($('input#checkRiwayat_perjalanan_keluhan_c').is(':checked')) {
                $('#riwayat_perjalanan_keluhan').val($('#riwayat_perjalanan_keluhan_c').val());
            }
            if ($('input#checkRiwayat_penyakit_sekarang_c').is(':checked')) {
                $('#riwayat_penyakit_sekarang').val($('#riwayat_penyakit_sekarang_c').val());
            }
            if ($('input#checkRiwayat_operasi_pengobatan_c').is(':checked')) {
                $('#riwayat_operasi_pengobatan').val($('#riwayat_operasi_pengobatan_c').val());
            }
            if ($('input#checkRiwayat_penyakit_keluarga_c').is(':checked')) {
                $('#riwayat_penyakit_keluarga').val($('#riwayat_penyakit_keluarga_c').val());
            }
            if ($('input#checkRiwayat_lain_c').is(':checked')) {
                $('#riwayat_lain').val($('#riwayat_lain_c').val());
            }
            if ($('input#checkRiwayat_penyakit_dahulu_c').is(':checked')) {
                $('#riwayat_penyakit_dahulu').val($('#riwayat_penyakit_dahulu_c').val());
            }

            //clear checkbox
            $('input#checkKeluhan_utama_c:checked').prop('checked', false);
            $('input#checkRiwayat_perjalanan_keluhan_c:checked').prop('checked', false);
            $('input#checkRiwayat_penyakit_sekarang_c:checked').prop('checked', false);
            $('input#checkRiwayat_operasi_pengobatan_c:checked').prop('checked', false);
            $('input#checkRiwayat_penyakit_keluarga_c:checked').prop('checked', false);
            $('input#checkRiwayat_lain_c:checked').prop('checked', false);
            $('input#checkRiwayat_penyakit_dahulu_c:checked').prop('checked', false);

            //clear textarea
            $('#keluhan_utama_c').val('');
            $('#riwayat_perjalanan_keluhan_c').val('');
            $('#riwayat_penyakit_sekarang_c').val('');
            $('#riwayat_operasi_pengobatan_c').val('');
            $('#riwayat_penyakit_keluarga_c').val('');
            $('#riwayat_lain_c').val('');
            $('#riwayat_penyakit_dahulu_c').val('');

            //close modal
            $('#modalCopyAnamnesa').modal('hide');
        });

        $(document).on('click', '#clear_button', function() {
            //clear checkbox
            $('input#checkKeluhan_utama_c:checked').prop('checked', false);
            $('input#checkRiwayat_perjalanan_keluhan_c:checked').prop('checked', false);
            $('input#checkRiwayat_penyakit_sekarang_c:checked').prop('checked', false);
            $('input#checkRiwayat_operasi_pengobatan_c:checked').prop('checked', false);
            $('input#checkRiwayat_penyakit_keluarga_c:checked').prop('checked', false);
            $('input#checkRiwayat_lain_c:checked').prop('checked', false);
            $('input#checkRiwayat_penyakit_dahulu_c:checked').prop('checked', false);

            //clear textarea
            $('#keluhan_utama_c').val('');
            $('#riwayat_perjalanan_keluhan_c').val('');
            $('#riwayat_penyakit_sekarang_c').val('');
            $('#riwayat_operasi_pengobatan_c').val('');
            $('#riwayat_penyakit_keluarga_c').val('');
            $('#riwayat_lain_c').val('');
            $('#riwayat_penyakit_dahulu_c').val('');

            //close modal
            $('#modalCopyAnamnesa').modal('hide');
        });

        $(document).on('click', '#modalSuratBtn', function() {
            $('#modalSurat').modal();
        });

        $(document).on('click', '#clearSuratBtn', function() {
            $('#summernotet2').summernote('code', '');
        });

        $(document).on('click', '#modalCopyAnamnesaBtn', function() {
            $('#modalCopyAnamnesa').modal();
            var patient_no = $('.medrec_id_info').text();
            $.ajax({
                url: "<?= site_url('konsultasidokter/fetchAllAnamnesaCardByPasien'); ?>",
                method: "GET",
                data: {
                    patient_no: patient_no
                },
                // dataType: "JSON",
                beforeSend: function() {
                    $('#copy_button').prop('disabled', true);
                    $('#copy_button').html('<i class="fas fa-sync-alt fa-spin"></i>');
                },
                complete: function() {
                    $('#copy_button').prop('disabled', false);
                    $('#copy_button').html($('#copy_button').val());
                },
                success: function(data) {
                    $('#viewanamnesacard').html(data);
                }
            })
        });

        $(document).on('click', '#modalFarmasiRow', function() {
            $('#modalFarmasi').modal();

        });

        $(document).on('click', '#modalRadiologiRow', function() {
            $('#modalRadiologi').modal();
            if ($('#radiologi_wrapper_m').html() == '') {
                $.ajax({

                    url: "<?= site_url('konsultasidokter/apiDataRadiologiGetAll'); ?>",
                    method: "GET",
                    // data: {
                    //     no_registrasi: no_registrasi
                    // },
                    dataType: "JSON",
                    beforeSend: function() {
                        // $('#btnclose').prop('disabled', true);
                        // $('#btnclose').html('<i class="fa fa-spin fa-spinner"></i>');
                    },
                    complete: function() {
                        // $('#btnclose').prop('disabled', false);
                        // $('#btnclose').html('Close');
                    },
                    success: function(data) {

                        // Mengurutkan berdasarkan title
                        // data.columns.sort((a, b) => a.title.localeCompare(b.title));

                        // Mengurutkan berdasarkan kolom
                        // data.columns.sort((a, b) => b.kolom.localeCompare(a.kolom));

                        $('#radiologi_wrapper_m').html('');
                        const $wrapper = $('#radiologi_wrapper_m');
                        const columns = {};

                        data.columns.forEach(column => {
                            if (!columns[column.kolom]) {
                                columns[column.kolom] = $('<div></div>');
                            }

                            const $titleDiv = $('<div></div>')
                                .addClass('captions')
                                .text(column.title);

                            const $ul = $('<ul></ul>');
                            column.items.forEach(item => {
                                const $li = $('<li></li>');
                                const $formcheck = $('<div class="form-check"></div>');
                                const $checkbox = $(`<input type="checkbox" class="form-check-input myCheckbox" id="${item.code}" data-id="${item.code}" data-desc="${item.description}" data-layanan="LY_003">`);
                                const $label = $(`<label class="form-check-label" for="${item.code}"></label>`);
                                $li.append($formcheck);
                                $formcheck.append($checkbox);
                                $formcheck.append($label);
                                // $label.append(` ${item.code} - ${item.description}`);
                                $label.append(`${item.description}`);
                                $ul.append($li);
                            });

                            columns[column.kolom].append($titleDiv);
                            columns[column.kolom].append($ul);
                        });

                        Object.values(columns).forEach($columnDiv => {
                            $wrapper.append($columnDiv);
                        });

                    }
                });

                $.ajax({

                    url: "<?= site_url('konsultasidokter/apiDataRadiologiGetAll'); ?>",
                    method: "GET",
                    // data: {
                    //     no_registrasi: no_registrasi
                    // },
                    dataType: "JSON",
                    success: function(data) {
                        // Buat objek baru untuk menyimpan item_cd sebagai key dan true sebagai value
                        var jsonData = {};
                        $.each(data, function(index, item) {
                            jsonData[item.item_cd.toLowerCase()] = true;
                        });

                        // Loop melalui data JSON dan set checkbox
                        $.each(jsonData, function(key, value) {
                            $('#' + key).prop('checked', value);
                        });
                    }
                });
            } else {
                // alert('timpa');
                // $.ajax({

                //     url: "<?= site_url('konsultasidokter/apiDataLabGetAll'); ?>",
                //     method: "GET",
                //     // data: {
                //     //     no_registrasi: no_registrasi
                //     // },
                //     dataType: "JSON",
                //     beforeSend: function() {},
                //     complete: function() {},
                //     success: function(data) {

                //         $('#wrapper_m').html('');
                //         const $wrapper = $('#wrapper_m');
                //         const columns = {};

                //         data.columns.forEach(column => {
                //             if (!columns[column.kolom]) {
                //                 columns[column.kolom] = $('<div></div>');
                //             }

                //             const $titleDiv = $('<div></div>')
                //                 .addClass('captions')
                //                 .text(column.title);

                //             const $ul = $('<ul></ul>');
                //             column.items.forEach(item => {
                //                 const $li = $('<li></li>');
                //                 const $formcheck = $('<div class="form-check"></div>');
                //                 const $checkbox = $(`<input type="checkbox" class="form-check-input myCheckbox" id="${item.code}" data-id="${item.code}" data-layanan="LY_004">`);
                //                 const $label = $(`<label class="form-check-label" for="${item.code}"></label>`);
                //                 $li.append($formcheck);
                //                 $formcheck.append($checkbox);
                //                 $formcheck.append($label);
                //                 // $label.append(` ${item.code} - ${item.description}`);
                //                 $label.append(`${item.description}`);
                //                 $ul.append($li);
                //             });

                //             columns[column.kolom].append($titleDiv);
                //             columns[column.kolom].append($ul);
                //         });

                //         Object.values(columns).forEach($columnDiv => {
                //             $wrapper.append($columnDiv);
                //         });

                //     }
                // });
            }
        });

        $(document).on('click', '#modalLaboratoriumRow', function() {
            $('#modalLaboratorium').modal();
            if ($('#lab_wrapper_m').html() == '') {
                $.ajax({

                    url: "<?= site_url('konsultasidokter/apiDataLabGetAll'); ?>",
                    method: "GET",
                    // data: {
                    //     no_registrasi: no_registrasi
                    // },
                    dataType: "JSON",
                    beforeSend: function() {
                        // $('#btnclose').prop('disabled', true);
                        // $('#btnclose').html('<i class="fa fa-spin fa-spinner"></i>');
                    },
                    complete: function() {
                        // $('#btnclose').prop('disabled', false);
                        // $('#btnclose').html('Close');
                    },
                    success: function(data) {

                        // Mengurutkan berdasarkan title
                        // data.columns.sort((a, b) => a.title.localeCompare(b.title));

                        // Mengurutkan berdasarkan kolom
                        // data.columns.sort((a, b) => b.kolom.localeCompare(a.kolom));

                        $('#lab_wrapper_m').html('');
                        const $wrapper = $('#lab_wrapper_m');
                        const columns = {};

                        data.columns.forEach(column => {
                            if (!columns[column.kolom]) {
                                columns[column.kolom] = $('<div></div>');
                            }

                            const $titleDiv = $('<div></div>')
                                .addClass('captions')
                                .text(column.title);

                            const $ul = $('<ul></ul>');
                            column.items.forEach(item => {
                                const $li = $('<li></li>');
                                const $formcheck = $('<div class="form-check"></div>');
                                const $checkbox = $(`<input type="checkbox" class="form-check-input myCheckbox" id="${item.code}" data-id="${item.code}" data-desc="${item.description}" data-layanan="LY_004">`);
                                const $label = $(`<label class="form-check-label" for="${item.code}"></label>`);
                                $li.append($formcheck);
                                $formcheck.append($checkbox);
                                $formcheck.append($label);
                                // $label.append(` ${item.code} - ${item.description}`);
                                $label.append(`${item.description}`);
                                $ul.append($li);
                            });

                            columns[column.kolom].append($titleDiv);
                            columns[column.kolom].append($ul);
                        });

                        Object.values(columns).forEach($columnDiv => {
                            $wrapper.append($columnDiv);
                        });

                    }
                });

                $.ajax({

                    url: "<?= site_url('konsultasidokter/apiDataLabGetAll'); ?>",
                    method: "GET",
                    // data: {
                    //     no_registrasi: no_registrasi
                    // },
                    dataType: "JSON",
                    success: function(data) {
                        // Buat objek baru untuk menyimpan item_cd sebagai key dan true sebagai value
                        var jsonData = {};
                        $.each(data, function(index, item) {
                            jsonData[item.item_cd.toLowerCase()] = true;
                        });

                        // Loop melalui data JSON dan set checkbox
                        $.each(jsonData, function(key, value) {
                            $('#' + key).prop('checked', value);
                        });
                    }
                });
            } else {
                // alert('timpa');
                // $.ajax({

                //     url: "<?= site_url('konsultasidokter/apiDataLabGetAll'); ?>",
                //     method: "GET",
                //     // data: {
                //     //     no_registrasi: no_registrasi
                //     // },
                //     dataType: "JSON",
                //     beforeSend: function() {},
                //     complete: function() {},
                //     success: function(data) {

                //         $('#wrapper_m').html('');
                //         const $wrapper = $('#wrapper_m');
                //         const columns = {};

                //         data.columns.forEach(column => {
                //             if (!columns[column.kolom]) {
                //                 columns[column.kolom] = $('<div></div>');
                //             }

                //             const $titleDiv = $('<div></div>')
                //                 .addClass('captions')
                //                 .text(column.title);

                //             const $ul = $('<ul></ul>');
                //             column.items.forEach(item => {
                //                 const $li = $('<li></li>');
                //                 const $formcheck = $('<div class="form-check"></div>');
                //                 const $checkbox = $(`<input type="checkbox" class="form-check-input myCheckbox" id="${item.code}" data-id="${item.code}" data-layanan="LY_004">`);
                //                 const $label = $(`<label class="form-check-label" for="${item.code}"></label>`);
                //                 $li.append($formcheck);
                //                 $formcheck.append($checkbox);
                //                 $formcheck.append($label);
                //                 // $label.append(` ${item.code} - ${item.description}`);
                //                 $label.append(`${item.description}`);
                //                 $ul.append($li);
                //             });

                //             columns[column.kolom].append($titleDiv);
                //             columns[column.kolom].append($ul);
                //         });

                //         Object.values(columns).forEach($columnDiv => {
                //             $wrapper.append($columnDiv);
                //         });

                //     }
                // });
            }
        });

        $(document).on('click', '#modalMcuRow', function() {
            $('#modalMcu').modal();
            if ($('#mcu_wrapper_m').html() == '') {
                $.ajax({

                    url: "<?= site_url('konsultasidokter/apiDataMcuGetAll'); ?>",
                    method: "GET",
                    // data: {
                    //     no_registrasi: no_registrasi
                    // },
                    dataType: "JSON",
                    beforeSend: function() {
                        // $('#btnclose').prop('disabled', true);
                        // $('#btnclose').html('<i class="fa fa-spin fa-spinner"></i>');
                    },
                    complete: function() {
                        // $('#btnclose').prop('disabled', false);
                        // $('#btnclose').html('Close');
                    },
                    success: function(data) {

                        // Mengurutkan berdasarkan title
                        // data.columns.sort((a, b) => a.title.localeCompare(b.title));

                        // Mengurutkan berdasarkan kolom
                        // data.columns.sort((a, b) => b.kolom.localeCompare(a.kolom));

                        $('#mcu_wrapper_m').html('');
                        const $wrapper = $('#mcu_wrapper_m');
                        const columns = {};

                        data.columns.forEach(column => {
                            if (!columns[column.kolom]) {
                                columns[column.kolom] = $('<div></div>');
                            }

                            const $titleDiv = $('<div></div>')
                                .addClass('captions')
                                .text(column.title);

                            const $ul = $('<ul></ul>');
                            column.items.forEach(item => {
                                const $li = $('<li></li>');
                                const $formcheck = $('<div class="form-check"></div>');
                                const $checkbox = $(`<input type="checkbox" class="form-check-input myCheckbox" id="${item.code}" data-id="${item.code}" data-desc="${item.description}" data-layanan="LY_005">`);
                                const $label = $(`<label class="form-check-label" for="${item.code}"></label>`);
                                $li.append($formcheck);
                                $formcheck.append($checkbox);
                                $formcheck.append($label);
                                // $label.append(` ${item.code} - ${item.description}`);
                                $label.append(`${item.description}`);
                                $ul.append($li);
                            });

                            columns[column.kolom].append($titleDiv);
                            columns[column.kolom].append($ul);
                        });

                        Object.values(columns).forEach($columnDiv => {
                            $wrapper.append($columnDiv);
                        });

                    }
                });

                $.ajax({

                    url: "<?= site_url('konsultasidokter/apiDataMcuGetAll'); ?>",
                    method: "GET",
                    // data: {
                    //     no_registrasi: no_registrasi
                    // },
                    dataType: "JSON",
                    success: function(data) {
                        // Buat objek baru untuk menyimpan item_cd sebagai key dan true sebagai value
                        var jsonData = {};
                        $.each(data, function(index, item) {
                            jsonData[item.item_cd.toLowerCase()] = true;
                        });

                        // Loop melalui data JSON dan set checkbox
                        $.each(jsonData, function(key, value) {
                            $('#' + key).prop('checked', value);
                        });
                    }
                });
            } else {
                // alert('timpa');
                // $.ajax({

                //     url: "<?= site_url('konsultasidokter/apiDataMcuGetAll'); ?>",
                //     method: "GET",
                //     // data: {
                //     //     no_registrasi: no_registrasi
                //     // },
                //     dataType: "JSON",
                //     beforeSend: function() {},
                //     complete: function() {},
                //     success: function(data) {

                //         $('#wrapper_m').html('');
                //         const $wrapper = $('#wrapper_m');
                //         const columns = {};

                //         data.columns.forEach(column => {
                //             if (!columns[column.kolom]) {
                //                 columns[column.kolom] = $('<div></div>');
                //             }

                //             const $titleDiv = $('<div></div>')
                //                 .addClass('captions')
                //                 .text(column.title);

                //             const $ul = $('<ul></ul>');
                //             column.items.forEach(item => {
                //                 const $li = $('<li></li>');
                //                 const $formcheck = $('<div class="form-check"></div>');
                //                 const $checkbox = $(`<input type="checkbox" class="form-check-input myCheckbox" id="${item.code}" data-id="${item.code}" data-layanan="LY_004">`);
                //                 const $label = $(`<label class="form-check-label" for="${item.code}"></label>`);
                //                 $li.append($formcheck);
                //                 $formcheck.append($checkbox);
                //                 $formcheck.append($label);
                //                 // $label.append(` ${item.code} - ${item.description}`);
                //                 $label.append(`${item.description}`);
                //                 $ul.append($li);
                //             });

                //             columns[column.kolom].append($titleDiv);
                //             columns[column.kolom].append($ul);
                //         });

                //         Object.values(columns).forEach($columnDiv => {
                //             $wrapper.append($columnDiv);
                //         });

                //     }
                // });
            }
        });

        // $.ajax({
        //     url: "<?= site_url('konsultasidokter/fetchAllRiwayatCardByPasien'); ?>",
        //     method: "GET",
        //     data: {
        //         patient_no: patient_no
        //     },
        //     // dataType: "JSON",
        //     beforeSend: function() {

        //     },
        //     complete: function() {

        //     },
        //     success: function(data) {
        //         $('#viewriwayatcard').html(data);
        //     }
        // });

        $(".tab-pane").css("display", "none");
        $('#titikKeluhan').addClass('disabled');
        $('#submit_button').prop('disabled', true);
        // tregistrasi();

    });

    $(document).on('click', '.pilihpasien', function() {

        var noreg = $(this).data('no_registrasi');

        // const noreg = $(this).val();
        // $('#noreg').val(noreg);
        loadDraft(noreg);

        $('#body-container').show();
        $('.header-info').show();

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

        $.ajax({
            url: "<?= site_url('konsultasidokter/apiDataGetAlergiByPasien'); ?>",
            method: "GET",
            data: {
                patient_no: patient_no
            },
            dataType: "JSON",
            beforeSend: function() {
                $('#btnclose').prop('disabled', true);
                $('#btnclose').html('<i class="fa fa-spin fa-spinner"></i>');
                $("#overlay-tes").css("display", "flex");
            },
            complete: function() {
                $('#btnclose').prop('disabled', false);
                $('#btnclose').html('Close');
                $("#overlay-tes").css("display", "none");
            },
            success: function(data) {

                $('#alergi_array_length').val(data.length);

                $('.all_row').remove();

                for (var i = 0; i < data.length; i++) {

                    $('#dynamic_alergi').append('<tr id="row' + i + '" class="all_row"><td><select class="custom-select" name="kategori_alergi[]" id="kategori_alergi' + i + '"><option value="' + data[i].kategori + '" selected="selected">' + data[i].kategori_desc + '</option></select></td><td><select class="custom-select" multiple="multiple" name="komponen_alergi[]" id="komponen_alergi' + i + '"><option value="' + data[i].komponen + '" selected="selected">' + data[i].komponen_desc + '</option></select></td><td><select class="custom-select" multiple="multiple" name="reaksi_alergi[]" id="reaksi_alergi' + i + '"><option value="' + data[i].reaksi + '" selected="selected">' + data[i].reaksi_desc + '</option></select></td><td><input type="hidden" name="alergi_no[]" value="' + data[i].alergi_no + '"><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove_alergi" data-alergi_no="' + data[i].alergi_no + '" data-patient_no="' + data[i].patient_no + '">X</button></td></tr>');

                    $('#kategori_alergi' + i + '', '#dynamic_alergi').select2({
                        ajax: {
                            url: "<?= site_url('konsultasidokter/ajaxKategoriAlergi/kategori_alergi'); ?>",
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
                        placeholder: 'Search ...',
                        minimumInputLength: 0,
                        width: 'auto',
                        // templateResult: formatResult2 //your selection format
                    });

                    $('#komponen_alergi' + i + '', '#dynamic_alergi').select2({
                        ajax: {
                            url: "<?= site_url('konsultasidokter/ajaxKategoriAlergi/komponen_alergi'); ?>",
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
                        placeholder: 'Search ...',
                        minimumInputLength: 0,
                        width: 'auto',
                        // templateResult: formatResult2 //your selection format
                    });

                    $('#reaksi_alergi' + i + '', '#dynamic_alergi').select2({
                        ajax: {
                            url: "<?= site_url('konsultasidokter/ajaxKategoriAlergi/reaksi_alergi'); ?>",
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
                        placeholder: 'Search ...',
                        minimumInputLength: 0,
                        width: 'auto',
                        // templateResult: formatResult2 //your selection format
                    });

                    $('#kategori_alergi' + i).val(data[i].kategori);
                    $('#kategori_alergi' + i).trigger('change');
                    $('#komponen_alergi' + i).val(data[i].komponen);
                    $('#komponen_alergi' + i).trigger('change');
                    $('#reaksi_alergi' + i).val(data[i].reaksi);
                    $('#reaksi_alergi' + i).trigger('change');
                }
            }
        });

        $.ajax({

            url: "<?= site_url('konsultasidokter/apiDataGetDiagnosaTambahanByRegistrasi'); ?>",
            method: "GET",
            data: {
                no_registrasi: no_registrasi
            },
            dataType: "JSON",
            beforeSend: function() {
                $('#btnclose').prop('disabled', true);
                $('#btnclose').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function() {
                $('#btnclose').prop('disabled', false);
                $('#btnclose').html('Close');
            },
            success: function(data) {

                $('#diagnosa_array_length').val(data.length + 3);

                $('.all_row_diagnosa').remove();

                for (var i = 0; i < data.length; i++) {

                    function formatResult2(item) {
                        //checks if the id present or not
                        if (!item.id) {
                            return item.text;
                        }
                        //return the format options..
                        var element = $(`<span>${item.id} - ${item.english} <br><span style="color:red;">[ ${item.indonesia} ]</span></span>'`)
                        return element;
                    };

                    $('#dynamic_field').append('<div class="card all_row_diagnosa" id="row' + i + '"><div class="card-body"><div class="row"><div class="col-sm-12"><div class="form-group"><label>Diagnosa Tambahan</label><input type="text" name="diagnosa_tambahan[]" class="form-control" placeholder="" id="diagnosa_tambahan' + i + '" value="' + data[i].diagnosa + '"><span class="error invalid-feedback errorDiagnosa_tambahan"></span></div></div></div><div class="row"><div class="col-sm-12"><label>ICD 10 </label><div class="form-group"><select class="form-control form-control-sm" name="icd10_tambahan[]" id="icd10_tambahan' + i + '"><option value=" " selected="selected">-- Select --</option></select></div></div></div><div class="row"><div class="col-sm-12"><label></label><br><div class="form-group d-flex justify-content-between align-items-center"><div class="form-check-inline"><label class="form-check-label"><input type="radio" class="form-check-input radio" name="klasifikasi_tambahan' + i + '" value="terduga" data-id="' + i + '" ' + (data[i].klasifikasi == 'terduga' ? 'checked' : '') + '>Terduga</label></div><div class="form-check-inline"><label class="form-check-label"><input type="radio" class="form-check-input radio" name="klasifikasi_tambahan' + i + '" value="gejala"  data-id="' + i + '" ' + (data[i].klasifikasi == 'gejala' ? 'checked' : '') + '>Gejala</label></div><div class="form-check-inline"><label class="form-check-label"><input type="radio" class="form-check-input radio" name="klasifikasi_tambahan' + i + '" value="dikonfirmasi" data-id="' + i + '" ' + (data[i].klasifikasi == 'dikonfirmasi' ? 'checked' : '') + '>Sudah Dikonfirmasi</label></div><br></div></div></div><div class="row"><input type="hidden" name="klasifikasi_tambahan[]" id="klasifikasi_tambahan' + i + '" value="' + data[i].klasifikasi + '"><div class="col-sm-12"><input type="hidden" name="seq_id[]" value="' + data[i].seq_id + '"><button type="button" name="remove" id="' + i + '" class="btn btn-xs btn-danger btn_remove float-right" data-no_registrasi="' + data[i].no_registrasi + '" data-seq_id="' + data[i].seq_id + '">HAPUS</button></div></div></div></div>');

                    $('#icd10_tambahan' + i + '', '#dynamic_field').select2({
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
                        placeholder: 'Search for a ICD10...',
                        minimumInputLength: 1,
                        templateResult: formatResult2 //your selection format
                    });

                    var defaultValueUtama = {
                        id: data[i].icd10,
                        text: data[i].icd10
                    };

                    var newOptionUtama = new Option(defaultValueUtama.text, defaultValueUtama.id, true, true);
                    $('#icd10_tambahan' + i + '', '#dynamic_field').append(newOptionUtama).trigger('change');

                }

            }
        });

        // alergi(patient_no);

        if ($(this).data('status') === 'DT') {
            $('#status').val('Draft');
        } else {
            $('#status').val('New');
        }

        var medrec_id = $(this).data('medrec_id');
        var patient_no = $(this).data('patient_no');
        var fullname = $(this).data('fullname');
        var birth_dt = $(this).data('birth_dt');
        var tahun = $(this).data('tahun');
        var bulan = $(this).data('bulan');
        var hari = $(this).data('hari');
        var gender = $(this).data('gender');
        var mobile_no = $(this).data('mobile_no');
        var kode_dokter = $(this).data('kode_dokter');
        var nama_dokter = $(this).data('nama_dokter');
        var tujuan_registrasi = $(this).data('tujuan_registrasi');
        var tujuan_registrasi_desc = $(this).data('tujuan_registrasi_desc');
        var type_pasien = $(this).data('type_pasien');
        var today = new Date();
        var no_kwitansi = $(this).data('no_kwitansi');
        var alergi = $(this).data('alergi');
        var flag_alergi = $(this).data('flag_alergi');


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
        $('.no_registrasi').val(no_registrasi);

        //Appointment


        //Appointment
        $('#ap_patient_no').val(patient_no);
        $('#ap_tujuan_registrasi').val(tujuan_registrasi);
        // $('#ap_tipe_pasien').val(type_pasien);
        // $('#ap_registrasi_via').val(registrasi_via);
        $('#ap_tanggal').val(tanggal);
        $('#ap_kode_dokter').val(kode_dokter);
        // $('#ap_jam_mulai').val(jam_mulai);
        // $('#ap_jam_selesai').val(jam_selesai);
        $('#ap_tahun').val(tahun);
        $('#ap_bulan').val(bulan);
        $('#ap_hari').val(hari);

        /* SET FORM */
        //Anamnesa
        $('input[name=responden]').prop('checked', false);
        $('#keluhan_utama').val('');
        $('#riwayat_perjalanan_keluhan').val('');
        $('#riwayat_penyakit_sekarang').val('');
        $('#riwayat_penyakit_dahulu').val('');
        $('#riwayat_operasi_pengobatan').val('');
        $('#riwayat_penyakit_keluarga').val('');
        $('#riwayat_lain').val('');

        //Pemeriksaan
        $('#kondisi_umum').val('');
        $('#tinggi_badan').val('');
        $('#berat_badan').val('');
        $('#bmi').val('');
        $('#suhu').val('');
        $('#sistolik').val('');
        $('#diastolik').val('');
        $('#denyut_nadi').val('');
        $('#laju_nafas').val('');
        $('#kondisi_khusus').val('');
        $('#pemeriksaan_tambahan').val('');

        //Diagnosa
        $('#diagnosa_utama').val('');
        $('input[name=klasifikasi_utama]').prop('checked', false);
        $('#diagnosa_sekunder').val('');
        $('input[name=klasifikasi_sekunder]').prop('checked', false);

        //Tindakan
        $('#resep').val('');
        $('#laboratorium').val('');
        $('#radiologi').val('');
        $('#prosedur_primer').val('');
        $('#prosedur_skunder').val('');
        $('#tatalaksana').val('');
        $('#reduksi').val('');
        $('input[name=check_resep]').prop('checked', false);
        $('input[name=check_laboratorium]').prop('checked', false);
        $('input[name=check_radiologi]').prop('checked', false);

        //Rujukan
        $('#summernotet').val('');
        $('#ket_rujukan').val('');
        $('#dokter_rujukan').val('').trigger('change');
        $('#user_rujukan').val('');

        /* SET FORM BY DATA*/
        //Anamnesa
        $('input[name=responden][name*=responden][value=' + ($(this).data('responden') == 'True' ? 1 : 0) + ']').prop('checked', true);
        // $('input[type=radio][name*=responden][value=' + (responden == 'True' ? 1 : 0) + ']').prop('checked', true);
        // (responden == 'True' ? $('input[type=radio][name*=responden]').prop('checked', false) : $('input[type=radio][name*=responden]').prop('checked', true));
        $('#keluhan_utama').val($(this).data('keluhan_utama'));
        $('#riwayat_perjalanan_keluhan').val($(this).data('riwayat_perjalanan_keluhan'));
        $('#riwayat_penyakit_sekarang').val($(this).data('riwayat_penyakit_sekarang'));
        $('#riwayat_penyakit_dahulu').val($(this).data('riwayat_penyakit_dahulu'));
        $('#riwayat_operasi_pengobatan').val($(this).data('riwayat_operasi_pengobatan'));
        $('#riwayat_penyakit_keluarga').val($(this).data('riwayat_penyakit_keluarga'));
        $('#riwayat_lain').val($(this).data('riwayat_lain'));

        //Pemeriksaan
        $('#kondisi_umum').val($(this).data('kondisi_umum'));
        $('#tinggi_badan').val($(this).data('tinggi_badan'));
        $('#berat_badan').val($(this).data('berat_badan'));
        $('#bmi').val($(this).data('bmi'));
        $('#suhu').val($(this).data('suhu'));
        $('#sistolik').val($(this).data('sistolik'));
        $('#diastolik').val($(this).data('diastolik'));
        $('#denyut_nadi').val($(this).data('denyut_nadi'));
        $('#laju_nafas').val($(this).data('laju_nafas'));
        $('#kondisi_khusus').val($(this).data('kondisi_khusus'));
        $('#pemeriksaan_tambahan').val($(this).data('pemeriksaan_tambahan'));

        //Diagnosa
        $('#diagnosa_utama').val($(this).data('diagnosa_utama'));
        $('input[name=klasifikasi_utama]').prop('checked', false);
        $('#diagnosa_sekunder').val($(this).data('diagnosa_sekunder'));
        $('input[name=klasifikasi_sekunder]').prop('checked', false);

        //Tindakan
        $('#resep').val($(this).data('resep'));
        $('#laboratorium').val($(this).data('laboratorium'));
        $('#radiologi').val($(this).data('radiologi'));
        $('#prosedur_primer').val($(this).data('prosedur_primer'));
        $('#prosedur_skunder').val($(this).data('prosedur_skunder'));
        $('#tatalaksana').val($(this).data('tatalaksana'));
        $('#reduksi').val($(this).data('reduksi'));
        $('input[name=check_resep]').prop('checked', false);
        $('input[name=check_laboratorium]').prop('checked', false);
        $('input[name=check_radiologi]').prop('checked', false);

        //Rujukan
        $('#summernotet').val($(this).data('summernotet'));
        $('#ket_rujukan').val($(this).data('ket_rujukan'));
        $('#dokter_rujukan').val($(this).data('dokter_rujukan')).trigger('change');
        $('#user_rujukan').val($(this).data('user_rujukan'));


        $.ajax({
            url: "<?= site_url('konsultasidokter/fetchAllRiwayatCardByPasien'); ?>",
            method: "GET",
            data: {
                patient_no: patient_no
            },
            // dataType: "JSON",
            beforeSend: function() {

            },
            complete: function() {

            },
            success: function(data) {
                $('#viewriwayatcard').html(data);
            }
        });

        var no_registrasi = $('#no_registrasi').text();

        $.ajax({
            url: "<?= site_url('konsultasidokter/apiDataGetByNoRegistrasi'); ?>",
            method: "GET",
            data: {
                no_registrasi: no_registrasi
            },
            dataType: "JSON",
            beforeSend: function() {
                $('.refreshTitikKeluhan').prop('disabled', true);
                $('.refreshTitikKeluhan').html('<i class="fas fa-sync-alt fa-spin"></i>');
            },
            complete: function() {
                $('.refreshTitikKeluhan').prop('disabled', false);
                $('.refreshTitikKeluhan').html('<i class="fas fa-sync-alt"></i>');
            },
            success: function(data) {
                $('#printcard').empty();

                var html = '<div class="card">';
                html += '<div class="card-body userimg">';
                html += '</div>';
                html += '</div>';

                for (var i = 0; i < data.length; i++) {
                    $('#printcard').append(html);

                    uimg = data[i].image;

                    var $img = $("<img/>");
                    // $img.width('340px');
                    // $img.height('250px');
                    $img.addClass('img-fluid rounded mx-auto d-block');
                    $img.attr("src", '/assets/img/titikkeluhan/' + uimg + '.jpg?' + new Date().getTime());
                    $(".userimg:eq(" + i + ")").append($img);
                }
            }
        })


    });

    $(document).on('click', '.pilihregistrasi', function() {

        var tahun = $(this).data('tahun');
        var bulan = $(this).data('bulan');
        var hari = $(this).data('hari');
        var no_registrasi = $(this).data('no_registrasi');
        var tujuan_registrasi = $(this).data('tujuan_registrasi');
        var tujuan_registrasi_desc = $(this).data('tujuan_registrasi_desc');
        var kode_dokter = $(this).data('kode_dokter');
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


        $.ajax({
            url: "<?= site_url('konsultasidokter/apiDataGetByNoRegistrasi'); ?>",
            method: "GET",
            data: {
                no_registrasi: no_registrasi
            },
            dataType: "JSON",
            success: function(data) {
                $('#printcard').empty();

                var html = '<div class="card">';
                html += '<div class="card-body userimg">';
                html += '</div>';
                html += '</div>';

                for (var i = 0; i < data.length; i++) {
                    $('#printcard').append(html);

                    uimg = data[i].image;

                    var $img = $("<img/>");
                    // $img.width('340px');
                    // $img.height('250px');
                    $img.addClass('img-fluid');
                    $img.attr("src", '/assets/img/titikkeluhan/' + uimg + '.jpg?');
                    $(".userimg:eq(" + i + ")").append($img);
                }
            }
        })

        // Ganti dengan URL API yang sesuai
        // var apiURL = "https://api.example.com/data";

        // $.getJSON(apiURL, function(data) {
        //     $.each(data, function(i, ent) {
        //         var imageUrl = ent.image; // Sesuaikan dengan nama atribut gambar pada JSON Anda
        //         var listItem = $("<li>").append($("<img>").attr("src", imageUrl));
        //         $("#tvshow").append(listItem);
        //     });
        // });

    });

    // sementara hidden
    // $(document).on('click', '.pasien', function() {
    //     var patient_no = $(this).data('patient_no');
    //     $.ajax({
    //         url: "<?= site_url('konsultasidokter/fetchAllRiwayat'); ?>",
    //         method: "GET",
    //         data: {
    //             patient_no: patient_no
    //         },
    //         // dataType: "JSON",
    //         success: function(data) {
    //             $('#viewdatariwayat').html(data);
    //         }
    //     })
    // });

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
                // alert(response.data.bulan);
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

                    alert('Form1');

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

                    alert('Form2');

                }
            }
        })
    });

    $('#data_form_anamnesa').on('submit', function(event) {

        event.preventDefault();
        $.ajax({
            url: "<?= site_url('konsultasidokter/action_anamnesa'); ?>",
            method: "POST",
            data: $(this).serialize(),
            dataType: "JSON",
            beforeSend: function() {
                $('#submit_button_anamnesa').prop('disabled', true);
                $('#submit_button_anamnesa').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function() {
                $('#submit_button_anamnesa').prop('disabled', false);
                $('#submit_button_anamnesa').html($('#submit_button_anamnesa').val());
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

    // $('#draft_button_all').click(function() {
    //     $('#action_all').val('Draft');
    //     $('#data_form_all').submit(); // trigger the submit event
    // });

    // $('#submit_button_all').click(function() {
    //     $('#action_all').val('Add');
    //     $('#data_form_all').submit(); // trigger the submit event
    // });

    $('#data_form_allx').on('submit', function(event) {

        event.preventDefault();
        $.ajax({
            url: "<?= site_url('konsultasidokter/action_all'); ?>",
            type: "POST",
            data: $('#data_form_all').serialize(),
            dataType: "JSON",
            beforeSend: function() {
                if ($('#action_all').val() == 'Draft') {
                    $('#draft_button_all').prop('disabled', true);
                    $('#draft_button_all').html('<i class="fa fa-spin fa-spinner"></i>');
                } else {
                    $('#submit_button_all').prop('disabled', true);
                    $('#submit_button_all').html('<i class="fa fa-spin fa-spinner"></i>');
                }

            },
            complete: function() {
                if ($('#action_all').val() == 'Draft') {
                    $('#draft_button_all').prop('disabled', false);
                    $('#draft_button_all').html($('#draft_button_all').val());
                    alert($('#draft_button_all').val());
                } else {
                    $('#submit_button_all').prop('disabled', false);
                    $('#submit_button_all').html($('#submit_button_all').val());
                    alert($('#submit_button_all').val());
                }

            },
            success: function(response) {

                if (response.error) {

                    /*START ANAMNESA*/
                    if (response.error.keluhan_utama) {
                        $('#keluhan_utama').addClass('is-invalid');
                        $('.errorKeluhan_utama').html(response.error.keluhan_utama);
                    } else {
                        $('#keluhan_utama').removeClass('is-invalid');
                        $('.errorKeluhan_utama').html('');
                    }
                    if (response.error.riwayat_perjalanan_keluhan) {
                        $('#riwayat_perjalanan_keluhan').addClass('is-invalid');
                        $('.errorRiwayat_perjalanan_keluhan').html(response.error.riwayat_perjalanan_keluhan);
                    } else {
                        $('#riwayat_perjalanan_keluhan').removeClass('is-invalid');
                        $('.errorRiwayat_perjalanan_keluhan').html('');
                    }
                    if (response.error.riwayat_penyakit_sekarang) {
                        $('#riwayat_penyakit_sekarang').addClass('is-invalid');
                        $('.errorRiwayat_penyakit_sekarang').html(response.error.riwayat_penyakit_sekarang);
                    } else {
                        $('#riwayat_penyakit_sekarang').removeClass('is-invalid');
                        $('.errorRiwayat_penyakit_sekarang').html('');
                    }
                    if (response.error.riwayat_penyakit_dahulu) {
                        $('#riwayat_penyakit_dahulu').addClass('is-invalid');
                        $('.errorRiwayat_penyakit_dahulu').html(response.error.riwayat_penyakit_dahulu);
                    } else {
                        $('#riwayat_penyakit_dahulu').removeClass('is-invalid');
                        $('.errorRiwayat_penyakit_dahulu').html('');
                    }
                    if (response.error.riwayat_operasi_pengobatan) {
                        $('#riwayat_operasi_pengobatan').addClass('is-invalid');
                        $('.errorRiwayat_operasi_pengobatan').html(response.error.riwayat_operasi_pengobatan);
                    } else {
                        $('#riwayat_operasi_pengobatan').removeClass('is-invalid');
                        $('.errorRiwayat_operasi_pengobatan').html('');
                    }
                    if (response.error.riwayat_penyakit_keluarga) {
                        $('#riwayat_penyakit_keluarga').addClass('is-invalid');
                        $('.errorRiwayat_penyakit_keluarga').html(response.error.riwayat_penyakit_keluarga);
                    } else {
                        $('#riwayat_penyakit_keluarga').removeClass('is-invalid');
                        $('.errorRiwayat_penyakit_keluarga').html('');
                    }
                    if (response.error.riwayat_lain) {
                        $('#riwayat_lain').addClass('is-invalid');
                        $('.errorRiwayat_lain').html(response.error.riwayat_lain);
                    } else {
                        $('#riwayat_lain').removeClass('is-invalid');
                        $('.errorRiwayat_lain').html('');
                    }
                    /*END ANAMNESA*/

                    /*START PERIKSA*/
                    if (response.error.kondisi_umum) {
                        $('#kondisi_umum').addClass('is-invalid');
                        $('.errorKondisi_umum').html(response.error.kondisi_umum);
                    } else {
                        $('#kondisi_umum').removeClass('is-invalid');
                        $('.errorKondisi_umum').html('');
                    }
                    if (response.error.kondisi_khusus) {
                        $('#kondisi_khusus').addClass('is-invalid');
                        $('.errorKondisi_khusus').html(response.error.kondisi_khusus);
                    } else {
                        $('#kondisi_khusus').removeClass('is-invalid');
                        $('.errorKondisi_khusus').html('');
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
                    if (response.error.sistolik) {
                        $('#sistolik').addClass('is-invalid');
                        $('.errorSistolik').html(response.error.sistolik);
                    } else {
                        $('#sistolik').removeClass('is-invalid');
                        $('.errorSistolik').html('');
                    }
                    if (response.error.diastolik) {
                        $('#diastolik').addClass('is-invalid');
                        $('.errorDiastolik').html(response.error.diastolik);
                    } else {
                        $('#diastolik').removeClass('is-invalid');
                        $('.errorDiastolik').html('');
                    }
                    if (response.error.denyut_nadi) {
                        $('#denyut_nadi').addClass('is-invalid');
                        $('.errorDenyut_nadi').html(response.error.denyut_nadi);
                    } else {
                        $('#denyut_nadi').removeClass('is-invalid');
                        $('.errorDenyut_nadi').html('');
                    }
                    if (response.error.laju_nafas) {
                        $('#laju_nafas').addClass('is-invalid');
                        $('.errorLaju_nafas').html(response.error.laju_nafas);
                    } else {
                        $('#laju_nafas').removeClass('is-invalid');
                        $('.errorLaju_nafas').html('');
                    }
                    if (response.error.suhu) {
                        $('#suhu').addClass('is-invalid');
                        $('.errorSuhu').html(response.error.suhu);
                    } else {
                        $('#suhu').removeClass('is-invalid');
                        $('.errorSuhu').html('');
                    }
                    if (response.error.pemeriksaan_tambahan) {
                        $('#pemeriksaan_tambahan').addClass('is-invalid');
                        $('.errorPemeriksaan_tambahan').html(response.error.pemeriksaan_tambahan);
                    } else {
                        $('#pemeriksaan_tambahan').removeClass('is-invalid');
                        $('.errorPemeriksaan_tambahan').html('');
                    }
                    /*END PERIKSA*/

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

                    // $('#submit_button2').val('SIMPAN');
                    // $('#submit_button2').html('SIMPAN');

                    // riwayatRm($('.medrec_id_info').text());
                    // tregistrasi();

                    /* SET FORM */
                    //Anamnesa
                    $('input[name=responden]').prop('checked', false);
                    $('#keluhan_utama').val('');
                    $('#riwayat_perjalanan_keluhan').val('');
                    $('#riwayat_penyakit_sekarang').val('');
                    $('#riwayat_penyakit_dahulu').val('');
                    $('#riwayat_operasi_pengobatan').val('');
                    $('#riwayat_penyakit_keluarga').val('');
                    $('#riwayat_lain').val('');

                    //Pemeriksaan
                    $('#kondisi_umum').val('');
                    $('#tinggi_badan').val('');
                    $('#berat_badan').val('');
                    $('#bmi').val('');
                    $('#suhu').val('');
                    $('#sistolik').val('');
                    $('#diastolik').val('');
                    $('#denyut_nadi').val('');
                    $('#laju_nafas').val('');
                    $('#kondisi_khusus').val('');
                    $('#pemeriksaan_tambahan').val('');

                    //Diagnosa
                    $('#diagnosa_utama').val('');
                    $('input[name=klasifikasi_utama]').prop('checked', false);
                    $('#diagnosa_sekunder').val('');
                    $('input[name=klasifikasi_sekunder]').prop('checked', false);

                    $('.all_row').remove();

                }
            }
        })
    });



    $('#data_form_periksa').on('submit', function(event) {

        event.preventDefault();
        $.ajax({
            url: "<?= site_url('konsultasidokter/action_periksa'); ?>",
            method: "POST",
            data: $(this).serialize(),
            dataType: "JSON",
            beforeSend: function() {
                $('#submit_button_anamnesa').prop('disabled', true);
                $('#submit_button_anamnesa').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function() {
                $('#submit_button_anamnesa').prop('disabled', false);
                $('#submit_button_anamnesa').html($('#submit_button_anamnesa').val());
            },
            success: function(response) {

                if (response.error) {

                    if (response.error.kondisi_umum) {
                        $('#kondisi_umum').addClass('is-invalid');
                        $('.errorKondisi_umum').html(response.error.kondisi_umum);
                    } else {
                        $('#kondisi_umum').removeClass('is-invalid');
                        $('.errorKondisi_umum').html('');
                    }
                    if (response.error.kondisi_khusus) {
                        $('#kondisi_khusus').addClass('is-invalid');
                        $('.errorKondisi_khusus').html(response.error.kondisi_khusus);
                    } else {
                        $('#kondisi_khusus').removeClass('is-invalid');
                        $('.errorKondisi_khusus').html('');
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
                    if (response.error.sistolik) {
                        $('#sistolik').addClass('is-invalid');
                        $('.errorSistolik').html(response.error.sistolik);
                    } else {
                        $('#sistolik').removeClass('is-invalid');
                        $('.errorSistolik').html('');
                    }
                    if (response.error.diastolik) {
                        $('#diastolik').addClass('is-invalid');
                        $('.errorDiastolik').html(response.error.diastolik);
                    } else {
                        $('#diastolik').removeClass('is-invalid');
                        $('.errorDiastolik').html('');
                    }
                    if (response.error.denyut_nadi) {
                        $('#denyut_nadi').addClass('is-invalid');
                        $('.errorDenyut_nadi').html(response.error.denyut_nadi);
                    } else {
                        $('#denyut_nadi').removeClass('is-invalid');
                        $('.errorDenyut_nadi').html('');
                    }
                    if (response.error.laju_nafas) {
                        $('#laju_nafas').addClass('is-invalid');
                        $('.errorLaju_nafas').html(response.error.laju_nafas);
                    } else {
                        $('#laju_nafas').removeClass('is-invalid');
                        $('.errorLaju_nafas').html('');
                    }
                    if (response.error.suhu) {
                        $('#suhu').addClass('is-invalid');
                        $('.errorSuhu').html(response.error.suhu);
                    } else {
                        $('#suhu').removeClass('is-invalid');
                        $('.errorSuhu').html('');
                    }
                    if (response.error.pemeriksaan_tambahan) {
                        $('#pemeriksaan_tambahan').addClass('is-invalid');
                        $('.errorPemeriksaan_tambahan').html(response.error.pemeriksaan_tambahan);
                    } else {
                        $('#pemeriksaan_tambahan').removeClass('is-invalid');
                        $('.errorPemeriksaan_tambahan').html('');
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

                    $('#submit_button_periksa').val('SIMPAN');
                    $('#submit_button_periksa').html('SIMPAN');

                    // riwayatRm($('.medrec_id_info').text());
                    // tregistrasi();

                }
            }
        })
    });

    $('#data_form_diagnosa').on('submit', function(event) {

        event.preventDefault();
        $.ajax({
            url: "<?= site_url('konsultasidokter/action_diagnosa'); ?>",
            method: "POST",
            data: $(this).serialize(),
            dataType: "JSON",
            beforeSend: function() {
                $('#submit_button_diagnosa').prop('disabled', true);
                $('#submit_button_diagnosa').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function() {
                $('#submit_button_diagnosa').prop('disabled', false);
                $('#submit_button_diagnosa').html($('#submit_button_diagnosa').val());
            },
            success: function(response) {

                if (response.error) {

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
                    $('#icd10_utama').val(' ');
                    $('#icd10_utama').trigger('change');
                    $('#icd10_sekunder').val(' ');
                    $('#icd10_sekunder').trigger('change');

                    $('#submit_button_periksa').val('SIMPAN');
                    $('#submit_button_periksa').html('SIMPAN');

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

        $('#layanan', '.dynamic_biaya').select2({
            ajax: {
                url: "<?= site_url('konsultasidokter/ajaxKategoriBiaya/layanan'); ?>",
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
            placeholder: 'Search ...',
            minimumInputLength: 0,
            width: 'auto',
            // templateResult: formatResult2 //your selection format
        });

        // function fOpenNewTab(event) {
        //     var OpenNewTab = window.open(event.value, '_blank');
        // }

        function doSomething() {
            alert("BISA!");
        };

        $(document).on('click', '#modalSuratBtn', function() {

            $('#modalSurat').modal();


        });

        function formatResult(item) {
            //checks if the id present or not
            if (!item.id) {
                return item.text;
            }
            //return the format options..
            var element = $(`<span>${item.id} - ${item.english} <br><span style="color:red;">[ ${item.indonesia} ]</span></span>'`)
            return element;
        };


        $("#icd10_utama").select2({
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
            placeholder: 'Search for a ICD10...',
            minimumInputLength: 1,
            templateResult: formatResult //your selection format
        });

        $("#icd10_sekunder").select2({
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
            placeholder: 'Search for a ICD10...',
            minimumInputLength: 1,
            templateResult: formatResult //your selection format
        });

        var data = [{
                id: 0,
                text: 'enhancement',
                img: 'human-vector2'
            },
            {
                id: 1,
                text: 'bug',
                img: '02'
            },
            {
                id: 2,
                text: 'duplicate',
                img: '03'
            },
            {
                id: 3,
                text: 'invalid',
                img: '04'
            }
        ];

        $("#titik_img").select2({
            data: data
        })

        // $("#titik_img-selected").select2({
        //     data: data
        // })

        // function formatTitik(titik) {
        //     if (!titik.id) {
        //         return titik.text;
        //     }
        //     var baseUrl = "/dist/img";
        //     var $titik = $(
        //         '<span><img src="' + baseUrl + '/' + titik.img.value.toLowerCase() + '.jpg" class="img-flag" /> ' + titik.text + '</span>'
        //     );
        //     return $titik;
        // };

        // $("#titik_img").select2({
        //     templateResult: formatTitik
        // });
    });

    $(document).ready(function() {
        // var i = 0;
        $('#add').click(function() {
            var i = $('#diagnosa_array_length').val();


            function formatResult2(item) {
                //checks if the id present or not
                if (!item.id) {
                    return item.text;
                }
                //return the format options..
                var element = $(`<span>${item.id} - ${item.english} <br><span style="color:red;">[ ${item.indonesia} ]</span></span>'`)
                return element;
            };

            $('#dynamic_field').append('<div class="card all_row_diagnosa" id="row' + i + '"><div class="card-body"><div class="row"><div class="col-sm-12"><div class="form-group"><label>Diagnosa ' + i + '</label><input type="text" name="diagnosa_tambahan[]" class="form-control" placeholder="" id="diagnosa_tambahan' + i + '"><span class="error invalid-feedback errorDiagnosa_tambahan"></span></div></div></div><div class="row"><div class="col-sm-12"><label>ICD 10 </label><div class="form-group"><select class="form-control form-control-sm" name="icd10_tambahan[]" id="icd10_tambahan' + i + '"><option value=" " selected="selected">-- Select --</option></select></div></div></div><div class="row"><div class="col-sm-12"><label></label><br><div class="form-group d-flex justify-content-between align-items-center"><div class="form-check-inline"><label class="form-check-label"><input type="radio" class="form-check-input radio" name="klasifikasi_tambahan' + i + '" value="terduga" data-id="' + i + '">Terduga</label></div><div class="form-check-inline"><label class="form-check-label"><input type="radio" class="form-check-input radio" name="klasifikasi_tambahan' + i + '" value="gejala"  data-id="' + i + '">Gejala</label></div><div class="form-check-inline"><label class="form-check-label"><input type="radio" class="form-check-input radio" name="klasifikasi_tambahan' + i + '" value="dikonfirmasi" data-id="' + i + '">Sudah Dikonfirmasi</label></div><br></div></div></div><div class="row"><input type="hidden" name="klasifikasi_tambahan[]" id="klasifikasi_tambahan' + i + '"><div class="col-sm-12"><input type="hidden" name="seq_id[]" value=""><button type="button" name="remove" id="' + i + '" class="btn btn-xs btn-danger btn_remove float-right">HAPUS</button></div></div></div></div>');

            $('#icd10_tambahan' + i + '', '#dynamic_field').select2({
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
                placeholder: 'Search for a ICD10...',
                minimumInputLength: 1,
                templateResult: formatResult2 //your selection format
            });

            i++;

            $('#diagnosa_array_length').val(i);

        });

        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id).remove();

            var no_registrasi = $(this).data('no_registrasi');
            var seq_id = $(this).data('seq_id');

            if (confirm("Are you sure you want to remove it?")) {
                $.ajax({
                    url: "<?= site_url('konsultasidokter/delete_diagnosa'); ?>",
                    method: "POST",
                    data: {
                        no_registrasi: no_registrasi,
                        seq_id: seq_id
                    },
                    dataType: "JSON",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                            //footer: '<a href="">Why do I have this issue?</a>'
                        });

                        // setTimeout(function() {
                        //     $('#message').html('');
                        // }, 5000);
                    }
                })
            }

        });

        $(document).on('change', '.radio', function() {
            var radio = $(this).data("id");
            $('#klasifikasi_tambahan' + radio + '').val($(this).val());
        });

    });

    $(document).ready(function() {

        // var i = $('#alergi_array_length').val();
        // var i = 18;

        $('#add_alergi').click(function() {
            var i = $('#alergi_array_length').val();
            // i++;

            $('#dynamic_alergi').append('<tr id="row' + i + '" class="all_row"><td><select class="custom-select" name="kategori_alergi[]" id="kategori_alergi' + i + '"><option value=" " selected="selected">-- Select --</option></select></td><td><select class="custom-select" multiple="multiple" name="komponen_alergi[]" id="komponen_alergi' + i + '"><option value=" " selected="selected">-- Select --</option></select></td><td><select class="custom-select" multiple="multiple" name="reaksi_alergi[]" id="reaksi_alergi' + i + '"><option value=" " selected="selected">-- Select --</option></select></td><td><input type="hidden" name="alergi_no[]" value=""><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove_alergi" data-alergi_no="" data-patient_no="">X</button></td></tr>');

            $('#kategori_alergi' + i + '', '#dynamic_alergi').select2({
                ajax: {
                    url: "<?= site_url('konsultasidokter/ajaxKategoriAlergi/kategori_alergi'); ?>",
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
                placeholder: 'Search ...',
                minimumInputLength: 0,
                width: 'auto',
                // templateResult: formatResult2 //your selection format
            });

            $('#komponen_alergi' + i + '', '#dynamic_alergi').select2({
                ajax: {
                    url: "<?= site_url('konsultasidokter/ajaxKategoriAlergi/komponen_alergi'); ?>",
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
                placeholder: 'Search ...',
                minimumInputLength: 0,
                width: 'auto',
                // templateResult: formatResult2 //your selection format
            });

            $('#reaksi_alergi' + i + '', '#dynamic_alergi').select2({
                ajax: {
                    url: "<?= site_url('konsultasidokter/ajaxKategoriAlergi/reaksi_alergi'); ?>",
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
                placeholder: 'Search ...',
                minimumInputLength: 0,
                width: 'auto',
                // templateResult: formatResult2 //your selection format
            });

            i++;

            $('#alergi_array_length').val(i);

        });

        $(document).on('click', '.btn_remove_alergi', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id).remove();

            var patient_no = $(this).data('patient_no');
            var alergi_no = $(this).data('alergi_no');
            if (confirm("Are you sure you want to remove it?")) {
                $.ajax({
                    url: "<?= site_url('konsultasidokter/delete_alergi'); ?>",
                    method: "POST",
                    data: {
                        patient_no: patient_no,
                        alergi_no: alergi_no
                    },
                    dataType: "JSON",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                            //footer: '<a href="">Why do I have this issue?</a>'
                        });

                        // setTimeout(function() {
                        //     $('#message').html('');
                        // }, 5000);
                    }
                })
            }
        });

        $('#add_header_biaya').click(function() {

            var item = $("#kode_item.select2 option:selected").val();
            if (item == ' ') {
                alert("Item belum dipilih");
            } else {

                var i = $('#biaya_array_length').val();
                // i++;
                var layanan_text = $("#layanan.select2 option:selected").text();
                var layanan = $("#layanan.select2 option:selected").val();
                var item_text = $("#kode_item.select2 option:selected").text();
                var item_cd = $("#kode_item.select2 option:selected").val();
                var qty = Number($("#kuantitas").val().replace(/\./g, "").replace(',', '.'));
                var harga = Number($("#harga").val().replace(/\./g, "").replace(',', '.'));
                var total = qty * harga;
                var takaran = $("#takaran").val();
                var hari = $("#hari").val();
                var frekuensi = $("#frekuensi").val();
                var petunjuk = $("#petunjuk").val();
                var reduksi = Number($("#pengurang").val().replace(/\./g, "").replace(',', '.'));
                var harga_sd = Number($("#harga_order").val().replace(/\./g, "").replace(',', '.'));
                var pajak_persen = 11;
                var pajak = (harga_sd * pajak_persen / 100);
                var harga_sp = harga_sd - pajak;

                $('#dynamic_biaya').append('<tr id="row_biaya' + i + '" class="all_row"><td><input type="text" class="form-control inputfield" id="layanan_text' + i + '" value="' + layanan_text + '" readonly/></td><td><input type="text" class="form-control inputfield" name="item[]" id="item' + i + '" value="' + item_text + '" readonly/></td><td><input type="text" class="form-control inputfield" name="qty[]" id="qty' + i + '" value="' + qty + '" readonly/></td><td><input type="text" class="form-control inputfield" dir="rtl" name="biaya_amount[]" id="biaya_amount' + i + '" value="' + addCommas(harga_sd) + '" readonly/></td><td><input type="text" class="form-control inputfield" dir="rtl" value="' + addCommas(total) + '" readonly/></td><td><input type="hidden"  id="layanan' + i + '" name="layanan[]" value="' + layanan + '"><input type="hidden"  id="item_cd' + i + '" name="item_cd[]" value="' + item_cd + '"><input class="amount" type="hidden" name="harga[]" value="' + total + '"><input type="hidden" name="takaran[]" value="' + takaran + '"><input type="hidden" name="hari[]" value="' + hari + '"><input type="hidden" name="frekuensi[]" value="' + frekuensi + '"><input type="hidden" name="pemakaian[]" value="' + pemakaian + '"><input type="hidden" name="kuantitas[]" value="' + kuantitas + '"><input type="hidden" name="reduksi[]" value="' + reduksi + '"><input type="hidden" name="harga_sd[]" value="' + harga_sd + '"><input type="hidden" name="pajak_persen[]" value="' + pajak_persen + '"><input type="hidden" name="pajak[]" value="' + pajak + '"><input type="hidden" name="harga_sp[]" value="' + harga_sp + '"><button type="button" name="select"  style="display:none;" id="' + i + '" class="btn btn-xs btn-info btn_select_biaya ml-1" data-biaya_no="" data-patient_no="">View</button><button type="button" name="edit" style="display:none;" id="' + i + '" class="btn btn-xs btn-warning btn_edit_biaya ml-1" data-biaya_no="" data-patient_no="">Edit</button><button type="button" name="remove" id="' + i + '" class="btn btn-xs btn-danger btn_remove_biaya ml-1" data-biaya_no="" data-patient_no="">X</button></td></tr>');

                i++;

                $('#biaya_array_length').val(i);
                sumTotal();

                $('#modalTindakan').modal('hide');
            }

        });


        function sumTotal() {
            var sum = 0;

            $('.amount').each(function() {
                sum += parseInt($(this).val());
            });

            $('#grand_total').html(addCommasRupiah(sum));
        }

        function addCommas(value) {
            return new Intl.NumberFormat('id-ID', {
                minimumFractionDigits: 2
            }).format(value);
        }

        function addCommasRupiah(nilai) {
            var bilangan = nilai;
            if (bilangan == "") {
                bilangan = 0;
            }
            var reverse = bilangan.toString().split('').reverse().join('');
            ribuan = reverse.match(/\d{1,3}/g);
            ribuan = ribuan.join('.').split('').reverse().join('');

            return 'Rp. ' + ribuan;
        }

        $(document).on('click', '.btn_remove_biaya', function() {
            var button_id = $(this).attr("id");
            $('#row_biaya' + button_id).remove();

            var patient_no = $(this).data('patient_no');
            var alergi_no = $(this).data('alergi_no');

            sumTotal();

            // alert(button_id);

            $('#' + button_id).prop("checked", false);


            // if (confirm("Are you sure you want to remove it?")) {
            //     $.ajax({
            //         url: "<?= site_url('konsultasidokter/delete_alergi'); ?>",
            //         method: "POST",
            //         data: {
            //             patient_no: patient_no,
            //             alergi_no: alergi_no
            //         },
            //         dataType: "JSON",
            //         success: function(response) {
            //             Swal.fire({
            //                 icon: 'success',
            //                 title: 'Success',
            //                 text: response.success,
            //                 //footer: '<a href="">Why do I have this issue?</a>'
            //             });

            //             // setTimeout(function() {
            //             //     $('#message').html('');
            //             // }, 5000);
            //         }
            //     })
            // }
        });

        // $('button.btn.btn-xs.btn-success.add_header_biaya_sub').click(function() {
        $(document).on('click', '.add_header_biaya_sub', function() {
            var i = $('#biaya_sub_array_length').val();
            // i++;

            $('#dynamic_biaya_sub').append('<tr id="row_biaya_sub' + i + '" class="all_row"><td><select class="custom-select" name="layanan[]" id="layanan_biaya_sub' + i + '"><option value=" " selected="selected">-- Select --</option></select></td><td><input type="text" size="2" class="form-control input-sm" name="biaya_amount[]" id="biaya_amount' + i + '"/></td><td><input type="text" size="2" class="form-control input-sm" name="biaya_amount[]" id="biaya_amount' + i + '"/></td><td><input type="text" size="2" class="form-control input-sm" name="biaya_amount[]" id="biaya_amount' + i + '"/></td><td><input type="text" class="form-control input-sm" name="biaya_amount[]" id="biaya_amount' + i + '"/></td><td><input type="text" size="3" class="form-control input-sm" name="biaya_amount[]" id="biaya_amount' + i + '"/></td><td><input type="text" size="2" class="form-control input-sm" name="biaya_amount[]" id="biaya_amount' + i + '"/></td><td><input type="text" size="15" class="form-control input-sm" name="biaya_amount[]" id="biaya_amount' + i + '"/></td><td><input type="hidden" name="alergi_no[]" value=""><button type="button" name="remove" id="' + i + '" class="btn btn-xs btn-danger btn_remove_biaya_sub ml-1" data-biaya_no="" data-patient_no="">X</button></td></tr>');

            $('#layanan_biaya_sub' + i + '', '#dynamic_biaya_sub').select2({
                ajax: {
                    url: "<?= site_url('konsultasidokter/ajaxKategoriBiaya/item_test'); ?>",
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
                placeholder: 'Search ...',
                minimumInputLength: 0,
                width: 'auto',
                // templateResult: formatResult2 //your selection format
            });

            $('#layanan_produk' + i + '', '#dynamic_biaya_sub').select2({
                ajax: {
                    url: "<?= site_url('konsultasidokter/ajaxKategoriBiaya/item'); ?>",
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
                placeholder: 'Search ...',
                minimumInputLength: 0,
                width: 'auto',
                // templateResult: formatResult2 //your selection format
            });

            $('#reaksi_alergi' + i + '', '#dynamic_alergi').select2({
                ajax: {
                    url: "<?= site_url('konsultasidokter/ajaxKategoriAlergi/reaksi_alergi'); ?>",
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
                placeholder: 'Search ...',
                minimumInputLength: 0,
                width: 'auto',
                // templateResult: formatResult2 //your selection format
            });

            i++;

            $('#biaya_sub_array_length').val(i);

        });

        $(document).on('click', '.btn_remove_biaya_sub', function() {
            var button_id = $(this).attr("id");
            $('#row_biaya_sub' + button_id).remove();

            var patient_no = $(this).data('patient_no');
            var alergi_no = $(this).data('alergi_no');
            // if (confirm("Are you sure you want to remove it?")) {
            //     $.ajax({
            //         url: "<?= site_url('konsultasidokter/delete_alergi'); ?>",
            //         method: "POST",
            //         data: {
            //             patient_no: patient_no,
            //             alergi_no: alergi_no
            //         },
            //         dataType: "JSON",
            //         success: function(response) {
            //             Swal.fire({
            //                 icon: 'success',
            //                 title: 'Success',
            //                 text: response.success,
            //                 //footer: '<a href="">Why do I have this issue?</a>'
            //             });

            //             // setTimeout(function() {
            //             //     $('#message').html('');
            //             // }, 5000);
            //         }
            //     })
            // }
        });

    });
</script>

<script>
    $('#permulaan_dt').datepicker({
        todayHighlight: true,
        autoclose: true,
        dateFormat: 'MM/DD/YYYY'
    }).val();

    $(document).ready(function() {
        $('input[type="radio"]').click(function() {
            if ($(this).attr('name') == 'status_psikologi') {
                if ($(this).attr('value') == 'lain') {
                    $("#status_psikologi_lain").prop("readonly", false);
                } else {
                    $("#status_psikologi_lain").prop("readonly", true);
                    $("#status_psikologi_lain").val("");
                }
            }
        });

        $('input[type="radio"]').click(function() {
            if ($(this).attr('name') == 'status_sosial') {
                if ($(this).attr('value') == 'tidak') {
                    $("#status_sosial_tidakbaik").prop("readonly", false);
                } else {
                    $("#status_sosial_tidakbaik").prop("readonly", true);
                    $("#status_sosial_tidakbaik").val("");
                }
            }
        });

        $(document).on('change keyup', '#tinggi_badan', function() {
            var tinggi = $('#tinggi_badan').val();
            var berat = $('#berat_badan').val();
            var bmi = berat / ((tinggi / 100) * (tinggi / 100));
            // $('#bmi').val(bmi).toFixed(2)
            $('#bmi').val(Math.round(bmi * 100) / 100);


        });

        $(document).on('change keyup', '#berat_badan', function() {
            var tinggi = $('#tinggi_badan').val();
            var berat = $('#berat_badan').val();
            var bmi = berat / ((tinggi / 100) * (tinggi / 100));

            $('#bmi').val(Math.round(bmi * 100) / 100);
        });

        $(document).on('change', '.titi ', function(e) {
            var val = $(this).val();
            var link, linkimg;
            if (val == "Head") {
                link = "/konsultasidokter/draw1";
                linkimg = "/dist/img/Head.jpg";
                window.open(link, '_blank');
            } else if (val == "Breast") {
                link = "/konsultasidokter/draw2";
                linkimg = "/dist/img/Breast.jpg";
                window.open(link, '_blank');
            } else if (val == "Dental") {
                link = "/konsultasidokter/draw3";
                linkimg = "/dist/img/Dental.jpg";
                window.open(link, '_blank');
            } else if (val == "RectumAnalCanal") {
                link = "/konsultasidokter/draw4";
                linkimg = "/dist/img/RectumAnalCanal.jpg";
                window.open(link, '_blank');
            } else if (val == "Blank") {
                link = "/konsultasidokter/draw5";
                linkimg = "/dist/img/Blank.jpg";
                window.open(link, '_blank');
            } else if (val == "Wajah") {
                link = "/konsultasidokter/draw6";
                linkimg = "/dist/img/Wajah.jpg";
                window.open(link, '_blank');
            } else if (val == "Wajah2") {
                link = "/konsultasidokter/draw7";
                linkimg = "/dist/img/Wajah2.jpg";
                window.open(link, '_blank');
            } else {
                link = "/konsultasidokter/draw1";
                linkimg = "/dist/img/Blank.jpg";
                // window.open(link, '_blank');
            }
            $('.titikkeluhan').attr("src", linkimg);

        });

        $(document).on('click', '.refreshTitikKeluhan', function() {
            // var no_registrasi = $(this).data('no_registrasi');
            var no_registrasi = $('#no_registrasi').text();

            $.ajax({
                url: "<?= site_url('konsultasidokter/apiDataGetByNoRegistrasi'); ?>",
                method: "GET",
                data: {
                    no_registrasi: no_registrasi
                },
                dataType: "JSON",
                beforeSend: function() {
                    $('.refreshTitikKeluhan').prop('disabled', true);
                    $('.refreshTitikKeluhan').html('<i class="fas fa-sync-alt fa-spin"></i>');
                },
                complete: function() {
                    $('.refreshTitikKeluhan').prop('disabled', false);
                    $('.refreshTitikKeluhan').html('<i class="fas fa-sync-alt"></i>');
                },
                success: function(data) {
                    $('#printcard').empty();

                    var html = '<div class="card">';
                    html += '<div class="card-body userimg">';
                    html += '</div>';
                    html += '</div>';

                    for (var i = 0; i < data.length; i++) {
                        $('#printcard').append(html);

                        uimg = data[i].image;

                        var $img = $("<img/>");
                        // $img.width('340px');
                        // $img.height('250px');
                        $img.addClass('img-fluid rounded mx-auto d-block');
                        $img.attr("src", '/assets/img/titikkeluhan/' + uimg + '.jpg?' + new Date().getTime());
                        $(".userimg:eq(" + i + ")").append($img);
                    }
                }
            })
        });

        $(document).on('click', '#wheelChair', function() {
            // $('#body-container').show();
            // $('.header-info').show();
            $.ajax({
                method: "get",
                url: "<?= site_url('konsultasidokter/fetchAll'); ?>",
                beforeSend: function() {
                    $('#wheelChair').prop('disabled', true);
                    $('#wheelChair').html('<i class="fas fa-sync-alt fa-spin"></i>');
                },
                complete: function() {
                    $('#wheelChair').prop('disabled', false);
                    $('#wheelChair').html('<i class="fas fa-wheelchair"></i>');
                },
                success: function(data) {
                    $('#viewdata').html(data);
                }
            });

        });

        // $('#print_button_rujukan').click(function() {
        //     $('#action').val('Print');
        //     $('#data_form_rujukan').submit(); // trigger the submit event
        // });

        $('#print_button_rujukan').click(function() {
            event.preventDefault();
            $.ajax({
                url: "<?= site_url('konsultasidokter/action_rujukan'); ?>",
                type: "POST",
                // data: $('#data_form_rujukan').serialize(),
                data: $('.form1').serialize(),
                dataType: "JSON",
                beforeSend: function() {
                    $('#action').val('Add');
                    $('#print_button_rujukan').prop('disabled', true);
                    $('#print_button_rujukan').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('#print_button_rujukan').prop('disabled', false);
                    $('#print_button_rujukan').html('Cetak Resume Medis');
                },
                success: function(response) {

                    if (response.error) {

                    } else {
                        // //sweet alert
                        // Swal.fire({
                        //     icon: 'success',
                        //     title: 'Success',
                        //     text: response.success,
                        //     //footer: '<a href="">Why do I have this issue?</a>'
                        // });
                        var isi = $('.no_registrasi').val();

                        const winPdf = window.open("<?= base_url('/konsultasidokter/print/') ?>" + isi);
                        winPdf.print();

                    }
                }
            })


        });

        $('#submit_button_rujukan').click(function() {
            event.preventDefault();
            $.ajax({
                url: "<?= site_url('konsultasidokter/action_rujukan'); ?>",
                type: "POST",
                // data: $('#data_form_rujukan').serialize(),
                data: $('.form1').serialize(),
                dataType: "JSON",
                beforeSend: function() {
                    $('#action').val('Add');
                    $('#submit_button_rujukan').prop('disabled', true);
                    $('#submit_button_rujukan').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('#submit_button_rujukan').prop('disabled', false);
                    $('#submit_button_rujukan').html('SIMPAN');
                },
                success: function(response) {

                    if (response.error) {

                    } else {
                        //sweet alert
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                            //footer: '<a href="">Why do I have this issue?</a>'
                        });
                        // var isi = $('.no_registrasi').val();
                        // const winPdf = window.open("<?= base_url('/konsultasidokter/print/') ?>" + isi);
                        // winPdf.print();

                    }
                }
            })

        });



        $(function() {
            // Summernote
            // $('#summernotet').summernote({
            //     height: 150, //set editable area's height
            // });


        });
    });
</script>

<script>
    $('#customSwitch').change(function() {
        let cek = $(this).is(':checked') ? 1 : 0;
        if (cek == 1) {
            $('#diskon').prop('readonly', false);
        } else {
            $('#diskon').prop('readonly', true);
        }
    });

    function hitungDiskon() {
        let input_harga = $('#harga');
        let input_diskon = $('#diskon');
        let input_qty = $('#kuantitas');

        let harga_satuan = parseFloat(input_harga.val().replace(/\./g, '').replace(',', '.')) || 0;
        let diskon = parseFloat(input_diskon.val().replace(/\./g, '').replace(',', '.')) || 0;
        let qty = parseFloat(input_qty.val().replace(/\./g, '').replace(',', '.')) || 0;

        $('#harga_normal').val(harga_satuan * qty);
        let input_harga_normal = $('#harga_normal');

        let total_normal = parseFloat(input_harga_normal.val().replace(/\./g, '').replace(',', '.')) || 0;

        $('#bagihasil').val(total_normal * 80 / 100);

        let bagihasil = $('#bagihasil').val();

        // if ($('#diskon').val().replace(/\./g, "").replace(',', '.') >= 101 && $('#diskon').val().replace(/\./g, "") != 0) {
        //     $('#harga_order').val(($('#bagihasil').val().replace(/\./g, "").replace(',', '.') - diskon) + (total_normal * 20 / 100));
        //     $('#bagihasil_setelah').val(($('#bagihasil').val().replace(/\./g, "").replace(',', '.') - diskon));
        //     $('#pengurang').val(diskon);
        // } else {
        //     $('#harga_order').val(($('#bagihasil').val().replace(/\./g, "").replace(',', '.') - ($('#bagihasil').val().replace(/\./g, "").replace(',', '.') * diskon / 100)) + (total_normal * 20 / 100));
        //     $('#bagihasil_setelah').val(($('#bagihasil').val().replace(/\./g, "").replace(',', '.') - ($('#bagihasil').val().replace(/\./g, "").replace(',', '.') * diskon / 100)));
        //     $('#pengurang').val(($('#bagihasil').val().replace(/\./g, "").replace(',', '.') * diskon / 100));
        // }

        // if (diskon > $('#bagihasil').val().replace(/\./g, "").replace(',', '.')) {
        //     alert('Reduksi Melebihi Batas!');
        //     $('#diskon').val(0);
        //     // $('#harga_order').val($('#harga_normal').val().replace(/\./g, ""));
        //     $('#bagihasil_setelah').val($('#bagihasil').val());
        //     $('#harga_order').val($('#harga_normal').val());
        // }

        // if (diskon < 0) {
        //     alert('Nilai Reduksi Tidak Boleh Minus!');
        //     $('#diskon').val(0);
        //     // $('#harga_order').val($('#harga_normal').val().replace(/\./g, ""));
        //     $('#bagihasil_setelah').val($('#bagihasil').val());
        //     $('#harga_order').val($('#harga_normal').val());
        // }

        if (diskon >= 101 && diskon != 0) {
            $('#harga_order').val((bagihasil - diskon) + (total_normal * 20 / 100));
            $('#bagihasil_setelah').val((bagihasil - diskon));
            $('#pengurang').val(diskon);
        } else {
            $('#harga_order').val((bagihasil - (bagihasil * diskon / 100)) + (total_normal * 20 / 100));
            $('#bagihasil_setelah').val((bagihasil - (bagihasil * diskon / 100)));
            $('#pengurang').val((bagihasil * diskon / 100));
        }

        if (diskon > bagihasil) {
            alert('Reduksi Melebihi Batas!');
            $('#diskon').val(0);
            $('#bagihasil_setelah').val(bagihasil);
            $('#harga_order').val(input_harga_normal);
        }

        if (diskon < 0) {
            alert('Nilai Reduksi Tidak Boleh Minus!');
            $('#diskon').val(0);
            $('#bagihasil_setelah').val(bagihasil);
            $('#harga_order').val(input_harga_normal);
        }

        formatAllDecimals();

    }

    //FARMASI
    $('#takaran, #frekuensi, #hari').on('input', function() {
        let takaran = $('#takaran').val();
        let frekuensi = $('#frekuensi').val();
        let hari = $('#hari').val();
        let kuantitas = takaran * frekuensi * hari;
        $('#kuantitas').val(kuantitas);
        // alert(kuantitas);

        formatAllDecimals();

    });

    $('#diskon, #kuantitas, #harga').on('input', function() {
        let input_harga = $('#harga');
        let input_diskon = $('#diskon');
        let input_qty = $('#kuantitas');

        let harga_satuan = parseFloat(input_harga.val().replace(/\./g, '').replace(',', '.')) || 0;
        let diskon = parseFloat(input_diskon.val().replace(/\./g, '').replace(',', '.')) || 0;
        let qty = parseFloat(input_qty.val().replace(/\./g, '').replace(',', '.')) || 0;

        $('#harga_normal').val(harga_satuan * qty);
        let input_harga_normal = $('#harga_normal');

        let total_normal = parseFloat(input_harga_normal.val().replace(/\./g, '').replace(',', '.')) || 0;

        $('#bagihasil').val(total_normal * 80 / 100);
        let bagihasil = $('#bagihasil').val();

        if (diskon >= 101 && diskon != 0) {
            $('#harga_order').val((bagihasil - diskon) + (total_normal * 20 / 100));
            $('#bagihasil_setelah').val((bagihasil - diskon));
            $('#pengurang').val(diskon);
        } else {
            $('#harga_order').val((bagihasil - (bagihasil * diskon / 100)) + (total_normal * 20 / 100));
            $('#bagihasil_setelah').val((bagihasil - (bagihasil * diskon / 100)));
            $('#pengurang').val((bagihasil * diskon / 100));
        }

        if (diskon > bagihasil) {
            alert('Reduksi Melebihi Batas!');
            $('#diskon').val(0);
            $('#bagihasil_setelah').val(bagihasil);
            $('#harga_order').val(input_harga_normal);
        }

        if (diskon < 0) {
            alert('Nilai Reduksi Tidak Boleh Minus!');
            $('#diskon').val(0);
            $('#bagihasil_setelah').val(bagihasil);
            $('#harga_order').val(input_harga_normal);
        }

        formatAllDecimals();

    });

    function formatDecimal(input) {

        let value = parseFloat(input.val().replace(/\./g, '').replace(',', '.'));
        if (!isNaN(value)) {
            input.val(formatNumber(value));
        }
    }

    function formatNumber(value) {
        return new Intl.NumberFormat('id-ID', {
            minimumFractionDigits: 2
        }).format(value);
    }

    function formatAllDecimals() {
        $('input.num').each(function() {
            formatDecimal($(this));
        });
    }

    $(document).on('click', '#modalTindakanRow', function() {
        formatAllDecimals();
        $('#modalTindakan').modal();
    });

    $(document).on('change', '#kode_item.select2', function() {
        var harga = $("#kode_item").select2().find(":selected").data("harga");
        $("#harga").val(formatNumber(harga));
        hitungDiskon();

        formatAllDecimals();

    });

    $(document).ready(function() {
        $('#summernotet').summernote({
            height: 250
        });
        $('#summernotet2').summernote({
            height: 250
        });
    });

    function appendListItem(elem) {
        // var id = $(elem).attr("id");
        var id = $('#' + $(elem).data('id')).val();
        // var caption = $(elem).data('caption');

        let htmlContent = $('#summernotet').summernote('code');
        htmlContent = htmlContent + id;
        $('#summernotet').summernote('code', htmlContent);
    }

    function formatRow(label, value) {
        // .trim() digunakan untuk menghapus spasi di awal/akhir agar input berisi spasi saja dianggap kosong
        if (value && value.trim() !== "") {
            return '<b>' + label + ' : </b>' + value + '<br>';
        }
        return ""; // Kembalikan string kosong jika tidak ada data
    }

    async function appendListItemAll() {
        // 1. Ambil Header
        var header = await appendListItemHeader();

        // 2. Ambil Berbagai Gambar (Hanya tampil jika ada datanya)
        var imgHead = await getImageData('head');
        var imgBreast = await getImageData('breast');
        var imgDental = await getImageData('dental');
        var imgRectumAnus = await getImageData('rectum_anus');
        var imgWajah = await getImageData('wajah');
        var imgWajah2 = await getImageData('wajah2');
        var imgBlank = await getImageData('blank');

        // 3. Ambil Data Form dengan Pengecekan Kosong
        var keluhan_utama = formatRow('Keluhan Utama', $('#keluhan_utama').val());
        var riwayat_perjalanan_keluhan = formatRow('Riwayat Perjalanan Keluhan', $('#riwayat_perjalanan_keluhan').val());
        var riwayat_penyakit_sekarang = formatRow('Riwayat Penyakit Sekarang', $('#riwayat_penyakit_sekarang').val());
        var riwayat_penyakit_dahulu = formatRow('Riwayat Penyakit Dahulu', $('#riwayat_penyakit_dahulu').val());
        var riwayat_operasi_pengobatan = formatRow('Riwayat Operasi Pengobatan', $('#riwayat_operasi_pengobatan').val());
        var riwayat_penyakit_keluarga = formatRow('Riwayat Penyakit Keluarga', $('#riwayat_penyakit_keluarga').val());
        var riwayat_lain = formatRow('Riwayat Lain', $('#riwayat_lain').val());

        // 4. Gabungkan Semua
        // Gambar hanya akan menambah baris jika variabelnya tidak ""
        var all = "<br>" + header +
            keluhan_utama +
            riwayat_perjalanan_keluhan +
            riwayat_penyakit_sekarang +
            riwayat_penyakit_dahulu +
            riwayat_operasi_pengobatan +
            riwayat_penyakit_keluarga +
            riwayat_lain + "<br>" +
            imgHead +
            imgBreast +
            imgDental +
            imgRectumAnus +
            imgWajah +
            imgWajah2 +
            imgBlank;

        // 5. Masukkan ke Summernote
        let htmlContent = $('#summernotet').summernote('code');
        $('#summernotet').summernote('code', htmlContent + all);
    }



    function appendListItemHeader() {
        var no_registrasi = $("#no_registrasi").html();

        // Return langsung promise dari $.ajax
        return $.ajax({
            url: "<?= site_url('konsultasidokter/headerRujukan'); ?>",
            method: "GET",
            data: {
                no_registrasi: no_registrasi
            }
        });
    }

    async function getImageData(jenisGambar) {
        var no_registrasi = $("#no_registrasi").html();
        try {
            let response = await $.ajax({
                url: "<?= site_url('konsultasidokter/titikKeluhan'); ?>",
                method: "GET",
                data: {
                    no_registrasi: no_registrasi,
                    gambar: jenisGambar // Mengirim 'gigi', 'mata', dll
                }
            });

            // Jika response ada isinya, kembalikan response + baris baru
            // Jika kosong, kembalikan string kosong
            return response ? response + "<br>" : "";
        } catch (error) {
            console.error("Gagal mengambil gambar: " + jenisGambar);
            return ""; // Lewatkan jika error
        }
    }

    function appendListItemCustom(elem) {
        var no_registrasi = $("#no_registrasi").html();

        if ($(elem).data("id") == "header") {
            $.ajax({
                url: "<?= site_url('konsultasidokter/headerRujukan'); ?>",
                method: "GET",
                data: {
                    no_registrasi: no_registrasi
                },
                // dataType: "JSON",
                success: function(data) {
                    // $('#summernotet').summernote('code', data);

                    var id = data;
                    let htmlContent = $('#summernotet').summernote('code');
                    htmlContent = htmlContent + id;
                    $('#summernotet').summernote('code', htmlContent);
                }
            });
        }

    }

    function appendListItemImage(elem) {
        var no_registrasi = $("#no_registrasi").html();
        if ($(elem).data("id")) {
            var gambar = $(elem).data("id");
            $.ajax({
                url: "<?= site_url('konsultasidokter/titikKeluhan'); ?>",
                method: "GET",
                data: {
                    no_registrasi: no_registrasi,
                    gambar: gambar
                },
                // dataType: "JSON",
                success: function(data) {
                    var id = data;
                    let htmlContent = $('#summernotet').summernote('code');
                    htmlContent = htmlContent + id;
                    $('#summernotet').summernote('code', htmlContent);
                }
            });
        }
    }
</script>

<script>
    $(document).ready(function() {
        $("#block_item").hide();
        $("#block_takaran").hide();
        // $("#block_hari").hide();
        $("#block_frekuensi").hide();
        // $("#block_pemakaian").hide();
        $("#block_btn_laboratorium").hide();
        $("#block_btn_medicalcheckup").hide();
        $("#block_btn_radiologi").hide();
        $(".block_bagihasil").hide();
        $("#block_diskon").hide();
        $("#block_harganormal").hide();
        $(".block_hargaorder").hide();
        $("#block_harga").hide();
        $("#block_kuantitas").hide();


        $("#kode_item").val('');
        $("#takaran").val('');
        $("#hari").val('');
        $("#frekuensi").val('');
        $("#pemakaian").val('');
        $("#kuantitas").val(1);
        $("#bagihasil").val(0);
        $("#diskon").val(0);
        $("#harganormal").val(0);
        $("#hargaorder").val(0);

        // $('#submit_button_all').click(function() {
        $('#submit_button_all').on('click', function(event) {

            event.preventDefault();
            $.ajax({
                url: "<?= site_url('konsultasidokter/action_all'); ?>",
                type: "POST",
                data: $('#data_form_3').serialize(),
                dataType: "JSON",
                beforeSend: function() {
                    $('#action_all').val('Add');
                    $('#submit_button_all').prop('disabled', true);
                    $('#submit_button_all').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('#submit_button_all').prop('disabled', false);
                    $('#submit_button_all').html('SIMPAN');
                },
                success: function(response) {

                    if (response.error) {

                        /*START ANAMNESA*/
                        if (response.error.keluhan_utama) {
                            $('#keluhan_utama').addClass('is-invalid');
                            $('.errorKeluhan_utama').html(response.error.keluhan_utama);
                        } else {
                            $('#keluhan_utama').removeClass('is-invalid');
                            $('.errorKeluhan_utama').html('');
                        }
                        if (response.error.riwayat_perjalanan_keluhan) {
                            $('#riwayat_perjalanan_keluhan').addClass('is-invalid');
                            $('.errorRiwayat_perjalanan_keluhan').html(response.error.riwayat_perjalanan_keluhan);
                        } else {
                            $('#riwayat_perjalanan_keluhan').removeClass('is-invalid');
                            $('.errorRiwayat_perjalanan_keluhan').html('');
                        }
                        if (response.error.riwayat_penyakit_sekarang) {
                            $('#riwayat_penyakit_sekarang').addClass('is-invalid');
                            $('.errorRiwayat_penyakit_sekarang').html(response.error.riwayat_penyakit_sekarang);
                        } else {
                            $('#riwayat_penyakit_sekarang').removeClass('is-invalid');
                            $('.errorRiwayat_penyakit_sekarang').html('');
                        }
                        if (response.error.riwayat_penyakit_dahulu) {
                            $('#riwayat_penyakit_dahulu').addClass('is-invalid');
                            $('.errorRiwayat_penyakit_dahulu').html(response.error.riwayat_penyakit_dahulu);
                        } else {
                            $('#riwayat_penyakit_dahulu').removeClass('is-invalid');
                            $('.errorRiwayat_penyakit_dahulu').html('');
                        }
                        if (response.error.riwayat_operasi_pengobatan) {
                            $('#riwayat_operasi_pengobatan').addClass('is-invalid');
                            $('.errorRiwayat_operasi_pengobatan').html(response.error.riwayat_operasi_pengobatan);
                        } else {
                            $('#riwayat_operasi_pengobatan').removeClass('is-invalid');
                            $('.errorRiwayat_operasi_pengobatan').html('');
                        }
                        if (response.error.riwayat_penyakit_keluarga) {
                            $('#riwayat_penyakit_keluarga').addClass('is-invalid');
                            $('.errorRiwayat_penyakit_keluarga').html(response.error.riwayat_penyakit_keluarga);
                        } else {
                            $('#riwayat_penyakit_keluarga').removeClass('is-invalid');
                            $('.errorRiwayat_penyakit_keluarga').html('');
                        }
                        if (response.error.riwayat_lain) {
                            $('#riwayat_lain').addClass('is-invalid');
                            $('.errorRiwayat_lain').html(response.error.riwayat_lain);
                        } else {
                            $('#riwayat_lain').removeClass('is-invalid');
                            $('.errorRiwayat_lain').html('');
                        }
                        /*END ANAMNESA*/

                        /*START PERIKSA*/
                        if (response.error.kondisi_umum) {
                            $('#kondisi_umum').addClass('is-invalid');
                            $('.errorKondisi_umum').html(response.error.kondisi_umum);
                        } else {
                            $('#kondisi_umum').removeClass('is-invalid');
                            $('.errorKondisi_umum').html('');
                        }
                        if (response.error.kondisi_khusus) {
                            $('#kondisi_khusus').addClass('is-invalid');
                            $('.errorKondisi_khusus').html(response.error.kondisi_khusus);
                        } else {
                            $('#kondisi_khusus').removeClass('is-invalid');
                            $('.errorKondisi_khusus').html('');
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
                        if (response.error.sistolik) {
                            $('#sistolik').addClass('is-invalid');
                            $('.errorSistolik').html(response.error.sistolik);
                        } else {
                            $('#sistolik').removeClass('is-invalid');
                            $('.errorSistolik').html('');
                        }
                        if (response.error.diastolik) {
                            $('#diastolik').addClass('is-invalid');
                            $('.errorDiastolik').html(response.error.diastolik);
                        } else {
                            $('#diastolik').removeClass('is-invalid');
                            $('.errorDiastolik').html('');
                        }
                        if (response.error.denyut_nadi) {
                            $('#denyut_nadi').addClass('is-invalid');
                            $('.errorDenyut_nadi').html(response.error.denyut_nadi);
                        } else {
                            $('#denyut_nadi').removeClass('is-invalid');
                            $('.errorDenyut_nadi').html('');
                        }
                        if (response.error.laju_nafas) {
                            $('#laju_nafas').addClass('is-invalid');
                            $('.errorLaju_nafas').html(response.error.laju_nafas);
                        } else {
                            $('#laju_nafas').removeClass('is-invalid');
                            $('.errorLaju_nafas').html('');
                        }
                        if (response.error.suhu) {
                            $('#suhu').addClass('is-invalid');
                            $('.errorSuhu').html(response.error.suhu);
                        } else {
                            $('#suhu').removeClass('is-invalid');
                            $('.errorSuhu').html('');
                        }
                        if (response.error.pemeriksaan_tambahan) {
                            $('#pemeriksaan_tambahan').addClass('is-invalid');
                            $('.errorPemeriksaan_tambahan').html(response.error.pemeriksaan_tambahan);
                        } else {
                            $('#pemeriksaan_tambahan').removeClass('is-invalid');
                            $('.errorPemeriksaan_tambahan').html('');
                        }
                        /*END PERIKSA*/

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


                    } else {
                        //sweet alert
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                            //footer: '<a href="">Why do I have this issue?</a>'
                        });


                        // //set input
                        // $('#permulaan_dt').val('');

                        // //set error validation
                        // $('.errorPermulaan_dt').html('');
                        // $('.errorKategori_alergi').html('');
                        // $('.errorBahan_alergi').html('');
                        // $('.errorKomponen_alergi').html('');
                        // $('.errorReaksi_alergi').html('');
                        // $('.errorTingkat_kegawatan_alergi').html('');
                        // $('.errorStatus_alergi').html('');
                        // $('.errorVerifikasi_alergi').html('');
                        // $('.errorCatatan').html('');

                        // //select 2
                        // $('#kategori_alergi').val(' ');
                        // $('#kategori_alergi').trigger('change');
                        // $('#bahan_alergi').val(' ');
                        // $('#bahan_alergi').trigger('change');
                        // $('#komponen_alergi').val(' ');
                        // $('#komponen_alergi').trigger('change');
                        // $('#reaksi_alergi').val(' ');
                        // $('#reaksi_alergi').trigger('change');
                        // $('#tingkat_kegawatan_alergi').val(' ');
                        // $('#tingkat_kegawatan_alergi').trigger('change');
                        // $('#status_alergi').val(' ');
                        // $('#status_alergi').trigger('change');
                        // $('#verifikasi_alergi').val(' ');
                        // $('#verifikasi_alergi').trigger('change');
                        // $('#catatan').val(' ');
                        // $('#catatan').trigger('change');

                        // // $('#submit_button2').val('SIMPAN');
                        // // $('#submit_button2').html('SIMPAN');

                        // // riwayatRm($('.medrec_id_info').text());
                        // // tregistrasi();

                        // /* SET FORM */
                        // //Anamnesa
                        // $('input[name=responden]').prop('checked', false);
                        // $('#keluhan_utama').val('');
                        // $('#riwayat_perjalanan_keluhan').val('');
                        // $('#riwayat_penyakit_sekarang').val('');
                        // $('#riwayat_penyakit_dahulu').val('');
                        // $('#riwayat_operasi_pengobatan').val('');
                        // $('#riwayat_penyakit_keluarga').val('');
                        // $('#riwayat_lain').val('');

                        // //Pemeriksaan
                        // $('#kondisi_umum').val('');
                        // $('#tinggi_badan').val('');
                        // $('#berat_badan').val('');
                        // $('#bmi').val('');
                        // $('#suhu').val('');
                        // $('#sistolik').val('');
                        // $('#diastolik').val('');
                        // $('#denyut_nadi').val('');
                        // $('#laju_nafas').val('');
                        // $('#kondisi_khusus').val('');
                        // $('#pemeriksaan_tambahan').val('');

                        // //Diagnosa
                        // $('#diagnosa_utama').val('');
                        // $('input[name=klasifikasi_utama]').prop('checked', false);
                        // $('#diagnosa_sekunder').val('');
                        // $('input[name=klasifikasi_sekunder]').prop('checked', false);

                        // $('.all_row_diagnosa').remove();

                        // $('.all_row').remove();

                        // //Layanan
                        // $('h2#grand_total').val('Rp. 0,00');

                        // //Tindakan 
                        // $('#ket_rujukan').val('');
                        // $('#summernotet').summernote('code', '');

                        clearFormAll();
                        let noreg = $('#no_registrasi').text();
                        // deleteDraft(noreg);
                        // alert(noreg);

                        //Set layanan
                        $(".hiddenLayanan").remove();
                        $(".hiddenItem_cd").remove();
                        $('#lab_wrapper_m').html('');
                        $('#radiologi_wrapper_m').html('');
                        $('#mcu_wrapper_m').html('');


                        // tregistrasi();

                    }
                }
            });
        });

        $('#draft_button_all').click(function() {
            alert('test');
            event.preventDefault();
            $.ajax({
                url: "<?= site_url('konsultasidokter/action_all'); ?>",
                type: "POST",
                data: $('#data_form_3').serialize(),
                dataType: "JSON",
                beforeSend: function() {
                    $('#action_all').val('Draft');
                    $('#draft_button_all').prop('disabled', true);
                    $('#draft_button_all').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('#draft_button_all').prop('disabled', false);
                    $('#draft_button_all').html('Simpan Sebagai Draft');
                },
                success: function(response) {

                    if (response.error) {

                        /*START ANAMNESA*/
                        if (response.error.keluhan_utama) {
                            $('#keluhan_utama').addClass('is-invalid');
                            $('.errorKeluhan_utama').html(response.error.keluhan_utama);
                        } else {
                            $('#keluhan_utama').removeClass('is-invalid');
                            $('.errorKeluhan_utama').html('');
                        }
                        if (response.error.riwayat_perjalanan_keluhan) {
                            $('#riwayat_perjalanan_keluhan').addClass('is-invalid');
                            $('.errorRiwayat_perjalanan_keluhan').html(response.error.riwayat_perjalanan_keluhan);
                        } else {
                            $('#riwayat_perjalanan_keluhan').removeClass('is-invalid');
                            $('.errorRiwayat_perjalanan_keluhan').html('');
                        }
                        if (response.error.riwayat_penyakit_sekarang) {
                            $('#riwayat_penyakit_sekarang').addClass('is-invalid');
                            $('.errorRiwayat_penyakit_sekarang').html(response.error.riwayat_penyakit_sekarang);
                        } else {
                            $('#riwayat_penyakit_sekarang').removeClass('is-invalid');
                            $('.errorRiwayat_penyakit_sekarang').html('');
                        }
                        if (response.error.riwayat_penyakit_dahulu) {
                            $('#riwayat_penyakit_dahulu').addClass('is-invalid');
                            $('.errorRiwayat_penyakit_dahulu').html(response.error.riwayat_penyakit_dahulu);
                        } else {
                            $('#riwayat_penyakit_dahulu').removeClass('is-invalid');
                            $('.errorRiwayat_penyakit_dahulu').html('');
                        }
                        if (response.error.riwayat_operasi_pengobatan) {
                            $('#riwayat_operasi_pengobatan').addClass('is-invalid');
                            $('.errorRiwayat_operasi_pengobatan').html(response.error.riwayat_operasi_pengobatan);
                        } else {
                            $('#riwayat_operasi_pengobatan').removeClass('is-invalid');
                            $('.errorRiwayat_operasi_pengobatan').html('');
                        }
                        if (response.error.riwayat_penyakit_keluarga) {
                            $('#riwayat_penyakit_keluarga').addClass('is-invalid');
                            $('.errorRiwayat_penyakit_keluarga').html(response.error.riwayat_penyakit_keluarga);
                        } else {
                            $('#riwayat_penyakit_keluarga').removeClass('is-invalid');
                            $('.errorRiwayat_penyakit_keluarga').html('');
                        }
                        if (response.error.riwayat_lain) {
                            $('#riwayat_lain').addClass('is-invalid');
                            $('.errorRiwayat_lain').html(response.error.riwayat_lain);
                        } else {
                            $('#riwayat_lain').removeClass('is-invalid');
                            $('.errorRiwayat_lain').html('');
                        }
                        /*END ANAMNESA*/

                        /*START PERIKSA*/
                        if (response.error.kondisi_umum) {
                            $('#kondisi_umum').addClass('is-invalid');
                            $('.errorKondisi_umum').html(response.error.kondisi_umum);
                        } else {
                            $('#kondisi_umum').removeClass('is-invalid');
                            $('.errorKondisi_umum').html('');
                        }
                        if (response.error.kondisi_khusus) {
                            $('#kondisi_khusus').addClass('is-invalid');
                            $('.errorKondisi_khusus').html(response.error.kondisi_khusus);
                        } else {
                            $('#kondisi_khusus').removeClass('is-invalid');
                            $('.errorKondisi_khusus').html('');
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
                        if (response.error.sistolik) {
                            $('#sistolik').addClass('is-invalid');
                            $('.errorSistolik').html(response.error.sistolik);
                        } else {
                            $('#sistolik').removeClass('is-invalid');
                            $('.errorSistolik').html('');
                        }
                        if (response.error.diastolik) {
                            $('#diastolik').addClass('is-invalid');
                            $('.errorDiastolik').html(response.error.diastolik);
                        } else {
                            $('#diastolik').removeClass('is-invalid');
                            $('.errorDiastolik').html('');
                        }
                        if (response.error.denyut_nadi) {
                            $('#denyut_nadi').addClass('is-invalid');
                            $('.errorDenyut_nadi').html(response.error.denyut_nadi);
                        } else {
                            $('#denyut_nadi').removeClass('is-invalid');
                            $('.errorDenyut_nadi').html('');
                        }
                        if (response.error.laju_nafas) {
                            $('#laju_nafas').addClass('is-invalid');
                            $('.errorLaju_nafas').html(response.error.laju_nafas);
                        } else {
                            $('#laju_nafas').removeClass('is-invalid');
                            $('.errorLaju_nafas').html('');
                        }
                        if (response.error.suhu) {
                            $('#suhu').addClass('is-invalid');
                            $('.errorSuhu').html(response.error.suhu);
                        } else {
                            $('#suhu').removeClass('is-invalid');
                            $('.errorSuhu').html('');
                        }
                        if (response.error.pemeriksaan_tambahan) {
                            $('#pemeriksaan_tambahan').addClass('is-invalid');
                            $('.errorPemeriksaan_tambahan').html(response.error.pemeriksaan_tambahan);
                        } else {
                            $('#pemeriksaan_tambahan').removeClass('is-invalid');
                            $('.errorPemeriksaan_tambahan').html('');
                        }
                        /*END PERIKSA*/

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


                    } else {
                        //sweet alert
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                            //footer: '<a href="">Why do I have this issue?</a>'
                        });



                        // //set input
                        // $('#permulaan_dt').val('');

                        // //set error validation
                        // $('.errorPermulaan_dt').html('');
                        // $('.errorKategori_alergi').html('');
                        // $('.errorBahan_alergi').html('');
                        // $('.errorKomponen_alergi').html('');
                        // $('.errorReaksi_alergi').html('');
                        // $('.errorTingkat_kegawatan_alergi').html('');
                        // $('.errorStatus_alergi').html('');
                        // $('.errorVerifikasi_alergi').html('');
                        // $('.errorCatatan').html('');

                        // //select 2
                        // $('#kategori_alergi').val(' ');
                        // $('#kategori_alergi').trigger('change');
                        // $('#bahan_alergi').val(' ');
                        // $('#bahan_alergi').trigger('change');
                        // $('#komponen_alergi').val(' ');
                        // $('#komponen_alergi').trigger('change');
                        // $('#reaksi_alergi').val(' ');
                        // $('#reaksi_alergi').trigger('change');
                        // $('#tingkat_kegawatan_alergi').val(' ');
                        // $('#tingkat_kegawatan_alergi').trigger('change');
                        // $('#status_alergi').val(' ');
                        // $('#status_alergi').trigger('change');
                        // $('#verifikasi_alergi').val(' ');
                        // $('#verifikasi_alergi').trigger('change');
                        // $('#catatan').val(' ');
                        // $('#catatan').trigger('change');

                        // // $('#submit_button2').val('SIMPAN');
                        // // $('#submit_button2').html('SIMPAN');

                        // // riwayatRm($('.medrec_id_info').text());
                        // // tregistrasi();

                        // /* SET FORM */
                        // //Anamnesa
                        // $('input[name=responden]').prop('checked', false);
                        // $('#keluhan_utama').val('');
                        // $('#riwayat_perjalanan_keluhan').val('');
                        // $('#riwayat_penyakit_sekarang').val('');
                        // $('#riwayat_penyakit_dahulu').val('');
                        // $('#riwayat_operasi_pengobatan').val('');
                        // $('#riwayat_penyakit_keluarga').val('');
                        // $('#riwayat_lain').val('');

                        // //Pemeriksaan
                        // $('#kondisi_umum').val('');
                        // $('#tinggi_badan').val('');
                        // $('#berat_badan').val('');
                        // $('#bmi').val('');
                        // $('#suhu').val('');
                        // $('#sistolik').val('');
                        // $('#diastolik').val('');
                        // $('#denyut_nadi').val('');
                        // $('#laju_nafas').val('');
                        // $('#kondisi_khusus').val('');
                        // $('#pemeriksaan_tambahan').val('');

                        // //Diagnosa
                        // $('#diagnosa_utama').val('');
                        // $('input[name=klasifikasi_utama]').prop('checked', false);
                        // $('#diagnosa_sekunder').val('');
                        // $('input[name=klasifikasi_sekunder]').prop('checked', false);

                        // $('.all_row').remove();

                        clearFormAll();
                        let noreg = $('#no_registrasi').text();
                        deleteDraft(noreg);
                        alert(noreg);
                        tregistrasi();


                    }
                }
            });
        });

        $('#jenis_surat.select2').on('change', function() {

            var jenis = $("#jenis_surat.select2 option:selected").val();
            var no_registrasi = $("#no_registrasi").html();
            // alert(jenis);


            if (jenis !== ' ') {

                if (jenis == '002') {
                    $.ajax({
                        url: "<?= site_url('konsultasidokter/suratLayakTerbang'); ?>",
                        method: "GET",
                        data: {
                            no_registrasi: no_registrasi
                        },
                        // dataType: "JSON",
                        success: function(data) {
                            var id = data;
                            let htmlContent = $('#summernotet2').summernote('code');
                            htmlContent = htmlContent + id;
                            $('#summernotet2').summernote('code', htmlContent);
                        }
                    });
                }

                if (jenis == '003') {
                    $.ajax({
                        url: "<?= site_url('konsultasidokter/suratLayakTerbangIbuHamil'); ?>",
                        method: "GET",
                        data: {
                            no_registrasi: no_registrasi
                        },
                        // dataType: "JSON",
                        success: function(data) {
                            var id = data;
                            let htmlContent = $('#summernotet2').summernote('code');
                            htmlContent = htmlContent + id;
                            $('#summernotet2').summernote('code', htmlContent);
                        }
                    });
                }

                if (jenis == '006') {
                    $.ajax({
                        url: "<?= site_url('konsultasidokter/suratKeteranganDokter'); ?>",
                        method: "GET",
                        data: {
                            no_registrasi: no_registrasi
                        },
                        // dataType: "JSON",
                        success: function(data) {
                            var id = data;
                            let htmlContent = $('#summernotet2').summernote('code');
                            htmlContent = htmlContent + id;
                            $('#summernotet2').summernote('code', htmlContent);
                        }
                    });
                }

                if (jenis == '004') {
                    $.ajax({
                        url: "<?= site_url('konsultasidokter/suratKeteranganSehat'); ?>",
                        method: "GET",
                        data: {
                            no_registrasi: no_registrasi
                        },
                        // dataType: "JSON",
                        success: function(data) {
                            var id = data;
                            let htmlContent = $('#summernotet2').summernote('code');
                            htmlContent = htmlContent + id;
                            $('#summernotet2').summernote('code', htmlContent);
                        }
                    });
                }

                if (jenis == '005') {
                    $.ajax({
                        url: "<?= site_url('konsultasidokter/suratKeteranganIstirahat'); ?>",
                        method: "GET",
                        data: {
                            no_registrasi: no_registrasi
                        },
                        // dataType: "JSON",
                        success: function(data) {
                            var id = data;
                            let htmlContent = $('#summernotet2').summernote('code');
                            htmlContent = htmlContent + id;
                            $('#summernotet2').summernote('code', htmlContent);
                        }
                    });
                }
            } else {
                // $('.kode_dokter').hide();
                // alert('gak ada');
            }
        });

        // $(document).on('change', '#kode_item.select2', function() {
        //     var harga = $("#kode_item").select2().find(":selected").data("harga");
        //     $("#harga").val(Number(harga));
        //     hitungDiskon();

        //     $("#diskon").val($("#diskon").val());

        //     $('#harga').val(addCommas($('#harga').val()));
        //     $('#bagihasil').val(addCommas($('#bagihasil').val()));
        //     $('#harga_order').val(addCommas($('#harga_order').val()));
        //     // $('#harga_normal').val(addCommas($('#harga_normal').val()));
        //     $('#bagihasil_setelah').val(addCommas($('#bagihasil_setelah').val()));
        //     $('#harga_normal').val(addCommas($('#harga_normal').val()));

        // });



        function addCommas(value) {
            return new Intl.NumberFormat('id-ID', {
                minimumFractionDigits: 2
            }).format(value);
        }

        $('#layanan.select2').on('change', function() {

            var jenis = $("#layanan.select2 option:selected").val();
            // var no_registrasi = $("#no_registrasi").html();

            $("#kode_item").val('');
            $("#takaran").val('');
            $("#hari").val('');
            $("#frekuensi").val('');
            $("#pemakaian").val('');
            $("#kuantitas").val(1);
            $("#bagihasil").val(0);
            $("#diskon").val(0);
            $("#harganormal").val(0);
            $("#hargaorder").val(0);
            $("#add_header_biaya").hide();


            if (jenis !== ' ') {

                if (jenis == 'LY_001') {
                    // alert(jenis);
                    $("#block_item").show();
                    $("#block_takaran").hide();
                    // $("#block_hari").hide();
                    $("#block_frekuensi").hide();
                    // $("#block_pemakaian").hide();
                    $("#block_btn_laboratorium").hide();
                    $("#block_btn_medicalcheckup").hide();
                    $("#block_btn_radiologi").hide();
                    $(".block_bagihasil").show();
                    $("#block_diskon").show();
                    $("#block_harganormal").show();
                    $(".block_hargaorder").show();

                    $("#block_kuantitas").show();
                    $("#block_harga").show();
                    $("#add_header_biaya").show();

                    $("#modalTindakanLabel").html('Tindakan');



                    $.ajax({
                        url: "<?= site_url('konsultasidokter/getDropdownLayananItem'); ?>",
                        method: "GET",
                        data: {
                            layanan: jenis
                        },
                        // dataType: "JSON",
                        beforeSend: function() {
                            // $('#submit_button4').prop('disabled', true);
                            // $('#submit_button4').html('<i class="fa fa-spin fa-spinner"></i>');
                        },
                        complete: function() {
                            // $('#submit_button4').prop('disabled', false);
                            // $('#submit_button4').html($('#submit_button4').val());
                        },
                        success: function(data) {
                            $('#dropdown_layananitem').html(data);
                            $('#kode_item').select2(); // Set up a Select2 control
                        }
                    });
                }

                if (jenis == 'LY_002') {
                    // alert(jenis);
                    $("#block_item").show();
                    $("#block_takaran").show();
                    // $("#block_hari").show();
                    $("#block_frekuensi").show();
                    // $("#block_pemakaian").show();
                    $("#block_btn_laboratorium").hide();
                    $("#block_btn_medicalcheckup").hide();
                    $("#block_btn_radiologi").hide();
                    $(".block_bagihasil").hide();
                    $("#block_diskon").hide();
                    $("#block_harganormal").hide();
                    $(".block_hargaorder").hide();

                    $("#block_kuantitas").show();
                    $("#block_harga").show();
                    $("#add_header_biaya").show();
                    $("#modalTindakanLabel").html('Farmasi');


                    $.ajax({
                        url: "<?= site_url('konsultasidokter/getDropdownLayananItem'); ?>",
                        method: "GET",
                        data: {
                            layanan: jenis
                        },
                        // dataType: "JSON",
                        beforeSend: function() {
                            // $('#submit_button4').prop('disabled', true);
                            // $('#submit_button4').html('<i class="fa fa-spin fa-spinner"></i>');
                        },
                        complete: function() {
                            // $('#submit_button4').prop('disabled', false);
                            // $('#submit_button4').html($('#submit_button4').val());
                        },
                        success: function(data) {
                            $('#dropdown_layananitem').html(data);
                            $('#kode_item').select2(); // Set up a Select2 control
                        }
                    });
                }

                if (jenis == 'LY_003') {
                    // alert(jenis);
                    $("#block_item").hide();
                    $("#block_takaran").hide();
                    // $("#block_hari").hide();
                    $("#block_frekuensi").hide();
                    // $("#block_pemakaian").hide();
                    $("#block_btn_laboratorium").hide();
                    $("#block_btn_medicalcheckup").hide();
                    $("#block_btn_radiologi").show();
                    $(".block_bagihasil").hide();
                    $("#block_diskon").hide();
                    $("#block_harganormal").hide();
                    $(".block_hargaorder").hide();

                    $("#block_kuantitas").hide();
                    $("#block_harga").hide();
                    $("#add_header_biaya").hide();
                    $("#modalTindakanLabel").html('Radiologi');

                }

                if (jenis == 'LY_004') {
                    // alert(jenis);
                    $("#block_item").hide();
                    $("#block_takaran").hide();
                    // $("#block_hari").hide();
                    $("#block_frekuensi").hide();
                    // $("#block_pemakaian").hide();
                    // $("#block_pemakaian").hide();
                    // $("#block_pemakaian").hide();
                    $("#block_btn_medicalcheckup").hide();
                    $("#block_btn_radiologi").hide();
                    $("#block_btn_laboratorium").show();
                    $(".block_bagihasil").hide();
                    $("#block_diskon").hide();
                    $("#block_harganormal").hide();
                    $(".block_hargaorder").hide();

                    $("#block_kuantitas").hide();
                    $("#block_harga").hide();
                    $("#add_header_biaya").hide();
                    $("#modalTindakanLabel").html('Laboratorium');


                }

                if (jenis == 'LY_005') {
                    // alert(jenis);
                    $("#block_item").hide();
                    $("#block_takaran").hide();
                    // $("#block_hari").hide();
                    $("#block_frekuensi").hide();
                    // $("#block_pemakaian").hide();
                    $("#block_btn_laboratorium").hide();
                    $("#block_btn_radiologi").hide();
                    $("#block_btn_medicalcheckup").show();
                    $(".block_bagihasil").hide();
                    $("#block_diskon").hide();
                    $("#block_harganormal").hide();
                    $(".block_hargaorder").hide();

                    $("#block_kuantitas").hide();
                    $("#block_harga").hide();
                    $("#add_header_biaya").hide();
                    $("#modalTindakanLabel").html('Medical Check-Up');

                }
            } else {
                // $('.kode_dokter').hide();
                // alert('gak ada');
            }
        });

        $('#check_resep').change(function() {
            if ($(this).is(':checked')) {
                $("#resep").prop("readonly", false);
            } else {
                $('#resep').prop('readonly', true);
                $('#resep').val('');
            }
        });

        $('#check_laboratorium').change(function() {
            if ($(this).is(':checked')) {
                $("#laboratorium").prop("readonly", false);
            } else {
                $('#laboratorium').prop('readonly', true);
                $('#laboratorium').val('');
            }
        });

        $('#check_radiologi').change(function() {
            if ($(this).is(':checked')) {
                $("#radiologi").prop("readonly", false);
            } else {
                $('#radiologi').prop('readonly', true);
                $('#radiologi').val('');
            }
        });

        function hitungTotalNilaiDariKelas(namaKelas) {
            const nilaiInput = $(`.${namaKelas}`).map(function() {
                return parseFloat($(this).val()) || 0;
            }).get();

            const total = nilaiInput.reduce((acc, nilai) => acc + nilai, 0);
            return total;
        }

        function formatRupiah(angka) {
            const numberString = angka.toString().replace(/[^0-9]/g, '');
            const formattedNumber = new Intl.NumberFormat("id-ID").format(numberString);
            return formattedNumber;
        }

    });

    $(document).on('click', '.myCheckbox', function() {
        var item_cd = $(this).data('id');
        // var layanan_text = $(this).data('layanan_text');

        var layanan = $(this).data('layanan');
        if (layanan == 'LY_003') {
            var layanan_text = 'Radiologi';
        }
        if (layanan == 'LY_004') {
            var layanan_text = 'Laboratorium';
        }
        var item = $(this).data('desc');

        if ($(this).is(':checked')) {
            // $('<input>').attr({
            //     type: 'hidden',
            //     id: "hiddenItem_cd" + kode,
            //     class: "hiddenItem_cd",
            //     name: 'item_cd[]',
            //     value: kode
            // }).appendTo('#data_form_3');
            // $('<input>').attr({
            //     type: 'hidden',
            //     id: "hiddenLayanan" + kode,
            //     class: "hiddenLayanan",
            //     name: 'layanan[]',
            //     value: layanan
            // }).appendTo('#data_form_3');
            // alert('buat ' + kode);

            var i = $('#biaya_array_length').val();
            // var layanan = "LY_004";
            var item = item;
            var qty = 1;
            var harga = 1000;
            var total = qty * harga;
            var takaran = "1";
            var hari = "1";
            var frekuensi = "1";
            var petunjuk = "1";
            var reduksi = 0;
            var harga_sd = 1000;
            var pajak_persen = 11;
            var pajak = (harga_sd * pajak_persen / 100);
            var harga_sp = harga_sd - pajak;

            $('#dynamic_biaya').append('<tr id="row_biaya' + item_cd + '" class="all_row"><td><input type="text" class="form-control inputfield" name="layanan_text[]" id="layanan_text' + i + '" value="' + layanan_text + '" readonly/></td><td><input type="text" class="form-control inputfield" name="item[]" id="item' + i + '" value="' + item + '" readonly/></td><td><input type="text" class="form-control inputfield" name="qty[]" id="qty' + i + '" value="' + qty + '" readonly/></td><td><input type="text" class="form-control inputfield" dir="rtl" name="biaya_amount[]" id="biaya_amount' + i + '" value="' + addCommas(harga) + '" readonly/></td><td><input type="text" class="form-control inputfield" dir="rtl" value="' + addCommas(total) + '" readonly/></td><td><input type="hidden" id="layanan' + i + '" name="layanan[]" value="' + layanan + '"><input type="hidden" id="item_cd' + i + '" name="item_cd[]" value="' + item_cd + '"><input class="amount" type="hidden" name="harga[]" value="' + total + '"><input type="hidden" name="takaran[]" value="' + takaran + '"><input type="hidden" name="hari[]" value="' + hari + '"><input type="hidden" name="frekuensi[]" value="' + frekuensi + '"><input type="hidden" name="pemakaian[]" value="' + "1" + '"><input type="hidden" name="kuantitas[]" value="' + "1" + '"><input type="hidden" name="reduksi[]" value="' + reduksi + '"><input type="hidden" name="harga_sd[]" value="' + harga_sd + '"><input type="hidden" name="pajak_persen[]" value="' + pajak_persen + '"><input type="hidden" name="pajak[]" value="' + pajak + '"><input type="hidden" name="harga_sp[]" value="' + harga_sp + '"><button type="button" name="select"  style="display:none;" id="' + i + '" class="btn btn-xs btn-info btn_select_biaya ml-1" data-biaya_no="" data-patient_no="">View</button><button type="button" name="edit" style="display:none;" id="' + i + '" class="btn btn-xs btn-warning btn_edit_biaya ml-1" data-biaya_no="" data-patient_no="">Edit</button><button type="button" name="remove" id="' + item_cd + '" class="btn btn-xs btn-danger btn_remove_biaya ml-1" data-biaya_no="" data-patient_no="">X</button></td></tr>');

            i++;

            $('#biaya_array_length').val(i);
            sumTotal();
            // alert(i);

            // function addCommas(n) {
            //     return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            // }

            function addCommas(value) {
                return new Intl.NumberFormat('id-ID', {
                    minimumFractionDigits: 2
                }).format(value);
            }

            function sumTotal() {
                var sum = 0;

                $('.amount').each(function() {
                    sum += parseInt($(this).val());
                });

                $('#grand_total').html(addCommasRupiah(sum));
            }

            function addCommasRupiah(nilai) {
                var bilangan = nilai;
                if (bilangan == "") {
                    bilangan = 0;
                }
                var reverse = bilangan.toString().split('').reverse().join('');
                ribuan = reverse.match(/\d{1,3}/g);
                ribuan = ribuan.join('.').split('').reverse().join('');

                return 'Rp. ' + ribuan;
            }



        } else {
            $("#hiddenLayanan" + kode).remove();
            $("#hiddenItem_cd" + kode).remove();
            // alert('hapus ' + kode);
            $("#row_biaya" + kode).remove();
            sumTotal();
        }
    });
    // $('#tanggal').datepicker({
    //     startDate: new Date(),
    //     todayHighlight: true,
    //     autoclose: true,
    //     dateFormat: 'MM/DD/YYYY'
    // }).val();
    $('#tanggal').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });
</script>

<script>
    $(document).ready(function() {
        $('.header-info').hide();
        $('[data-widget="control-sidebar"]').ControlSidebar('show');
        tregistrasi();
    });
</script>

<script>
    let db;
    const menu = "konsultasi";

    // Inisialisasi IndexedDB
    function initDB() {
        const request = indexedDB.open("FormDraftDB", 1);

        request.onupgradeneeded = function(event) {
            db = event.target.result;
            if (!db.objectStoreNames.contains("drafts")) {
                db.createObjectStore("drafts", {
                    keyPath: "id"
                });
            }
        };

        request.onsuccess = function(event) {
            db = event.target.result;
        };

        request.onerror = function(event) {
            console.error("IndexedDB error:", event.target.errorCode);
        };
    }

    // Tambah baris resep
    function addResepRow(obat = '', dosis = '') {
        $('#resepTable tbody').append(`
    <tr>
      <td><input class="obat" value="${obat}"></td>
      <td><input class="dosis" value="${dosis}"></td>
      <td><button type="button" onclick="$(this).closest('tr').remove()">Hapus</button></td>
    </tr>
  `);
    }

    // Simpan draft ke IndexedDB
    function saveDraft() {
        // const noreg = $('#noreg').val();
        const noreg = $('#no_registrasi').text();
        // const poli = $('#selectPoli').val();
        const icd10_utama = $('#icd10_utama').val();
        const icd10_sekunder = $('#icd10_sekunder').val();

        const dokter_rujukan = $('#dokter_rujukan').val();

        if (!noreg || !db) return;

        const draft = {
            id: `${menu}_${noreg}`,
            // poli: poli,
            // nama: $('[name="nama"]').val(),
            // umur: $('[name="umur"]').val(),
            // jk: $('[name="jk"]:checked').val(),
            // keluhan: $('[name="keluhan"]').val(),
            // diagnosa: $('[name="diagnosa"]').val(),
            // resep: []

            /** Anamnesa */
            responden: $('[name="responden"]:checked').val(),
            keluhan_utama: $('[name="keluhan_utama"]').val(),
            riwayat_penyakit_dahulu: $('[name="riwayat_penyakit_dahulu"]').val(),
            riwayat_perjalanan_keluhan: $('[name="riwayat_perjalanan_keluhan"]').val(),
            riwayat_operasi_pengobatan: $('[name="riwayat_operasi_pengobatan"]').val(),
            riwayat_penyakit_keluarga: $('[name="riwayat_penyakit_keluarga"]').val(),
            riwayat_penyakit_sekarang: $('[name="riwayat_penyakit_sekarang"]').val(),
            riwayat_lain: $('[name="riwayat_lain"]').val(),

            // Pemeriksaan
            kondisi_umum: $('[name="kondisi_umum"]').val(),
            tinggi_badan: $('[name="tinggi_badan"]').val(),
            berat_badan: $('[name="berat_badan"]').val(),
            bmi: $('[name="bmi"]').val(),
            suhu: $('[name="suhu"]').val(),
            sistolik: $('[name="sistolik"]').val(),
            diastolik: $('[name="diastolik"]').val(),
            denyut_nadi: $('[name="denyut_nadi"]').val(),
            laju_nafas: $('[name="laju_nafas"]').val(),
            kondisi_khusus: $('[name="kondisi_khusus"]').val(),
            pemeriksaan_tambahan: $('[name="pemeriksaan_tambahan"]').val(),

            // Diagnosa
            diagnosa_utama: $('[name="diagnosa_utama"]').val(),
            icd10_utama: icd10_utama,
            klasifikasi_utama: $('[name="klasifikasi_utama"]:checked').val(),
            diagnosa_sekunder: $('[name="diagnosa_sekunder"]').val(),
            icd10_sekunder: icd10_sekunder,
            klasifikasi_sekunder: $('[name="klasifikasi_sekunder"]:checked').val(),

            // Rujukan
            // summernotet: $('[name="summernotet"]').val(),
            summernotet: $('#summernotet').summernote('code'),
            ket_rujukan: $('[name="ket_rujukan"]').val(),
            dokter_rujukan: dokter_rujukan,
            user_rujukan: $('[name="user_rujukan"]').val()



        };

        $('#resepTable tbody tr').each(function() {
            draft.resep.push({
                obat: $(this).find('.obat').val(),
                dosis: $(this).find('.dosis').val()
            });
        });

        const tx = db.transaction("drafts", "readwrite");
        tx.objectStore("drafts").put(draft);
    }

    // Load draft dari IndexedDB
    function loadDraft(noreg) {
        if (!db || !noreg) return;

        const tx = db.transaction("drafts", "readonly");
        const request = tx.objectStore("drafts").get(`${menu}_${noreg}`);

        request.onsuccess = function(event) {
            const draft = event.target.result;

            // Kosongkan form terlebih dahulu
            // $('[name="nama"]').val('');
            // $('[name="umur"]').val('');
            // $('#resepTable tbody').empty();
            // $('#selectPoli').val('').trigger('change');

            /** Anamnesa */
            $('[name="responden"]').prop('checked', false);
            $('[name="keluhan_utama"]').val(''); //ok
            $('[name="riwayat_penyakit_dahulu"]').val('');
            $('[name="riwayat_perjalanan_keluhan"]').val('');
            $('[name="riwayat_operasi_pengobatan"]').val('');
            $('[name="riwayat_penyakit_keluarga"]').val('');
            $('[name="riwayat_penyakit_sekarang"]').val('');
            $('[name="riwayat_lain"]').val('');


            // Pemeriksaan
            $('[name="kondisi_umum"]').val('');
            $('[name="tinggi_badan"]').val('');
            $('[name="berat_badan"]').val('');
            $('[name="bmi"]').val('');
            $('[name="suhu"]').val('');
            $('[name="sistolik"]').val('');
            $('[name="diastolik"]').val('');
            $('[name="denyut_nadi"]').val('');
            $('[name="laju_nafas"]').val('');
            $('[name="kondisi_khusus"]').val('');
            $('[name="pemeriksaan_tambahan"]').val('');

            // Diagnosa
            $('[name="diagnosa_utama"]').val('');
            $('#icd10_utama').val('').trigger('change');
            $('[name="klasifikasi_utama"]').prop('checked', false);
            $('[name="diagnosa_sekunder"]').val('');
            $('#icd10_sekunder').val('').trigger('change');
            $('[name="klasifikasi_sekunder"]').prop('checked', false);

            // Tindakan & Biaya
            $('.all_row').remove();

            // Rujukan
            // $('[name="summernotet"]').val('');
            $('#summernotet').summernote('code', '');
            $('[name="ket_rujukan"]').val('');
            $('#dokter_rujukan').val('').trigger('change');
            $('[name="user_rujukan"]').val('');

            // Isi jika draft ditemukan
            if (draft) {
                // $('#selectPoli').val(draft.poli || '').trigger('change');
                // $('[name="nama"]').val(draft.nama || '');
                // $('[name="umur"]').val(draft.umur || '');
                // (draft.resep || []).forEach(item => addResepRow(item.obat, item.dosis));

                /** Anamnesa */
                if (draft.responden) $(`[name="responden"][value="${draft.responden}"]`).prop('checked', true);
                $('[name="keluhan_utama"]').val(draft.keluhan_utama || '');
                $('[name="riwayat_penyakit_dahulu"]').val(draft.riwayat_penyakit_dahulu || '');
                $('[name="riwayat_perjalanan_keluhan"]').val(draft.riwayat_perjalanan_keluhan || '');
                $('[name="riwayat_operasi_pengobatan"]').val(draft.riwayat_operasi_pengobatan || '');
                $('[name="riwayat_penyakit_keluarga"]').val(draft.riwayat_penyakit_keluarga || '');
                $('[name="riwayat_penyakit_sekarang"]').val(draft.riwayat_penyakit_sekarang || '');
                $('[name="riwayat_lain"]').val(draft.riwayat_lain || '');

                // Pemeriksaan
                $('[name="kondisi_umum"]').val(draft.kondisi_umum || '');
                $('[name="tinggi_badan"]').val(draft.tinggi_badan || '');
                $('[name="berat_badan"]').val(draft.berat_badan || '');
                $('[name="bmi"]').val(draft.bmi || '');
                $('[name="suhu"]').val(draft.suhu || '');
                $('[name="sistolik"]').val(draft.sistolik || '');
                $('[name="diastolik"]').val(draft.diastolik || '');
                $('[name="denyut_nadi"]').val(draft.denyut_nadi || '');
                $('[name="laju_nafas"]').val(draft.laju_nafas || '');
                $('[name="kondisi_khusus"]').val(draft.kondisi_khusus || '');
                $('[name="pemeriksaan_tambahan"]').val(draft.pemeriksaan_tambahan || '');

                // Diagnosa
                $('[name="diagnosa_utama"]').val(draft.diagnosa_utama || '');
                $('#icd10_utama').val(draft.icd10_utama || '').trigger('change');
                if (draft.klasifikasi_utama) $(`[name="klasifikasi_utama"][value="${draft.klasifikasi_utama}"]`).prop('checked', true);

                $('[name="diagnosa_sekunder"]').val(draft.diagnosa_sekunder || '');
                $('#icd10_sekunder').val(draft.icd10_sekunder || '').trigger('change');
                if (draft.klasifikasi_sekunder) $(`[name="klasifikasi_sekunder"][value="${draft.klasifikasi_sekunder}"]`).prop('checked', true);


                // Tindakan & Biaya

                // Rujukan
                // $('[name="summernotet"]').val(draft.summernotet || '');
                $('#summernotet').summernote('code', draft.summernotet || '');
                $('[name="ket_rujukan"]').val(draft.ket_rujukan || '');
                $('[name="dokter_rujukan"]').val(draft.dokter_rujukan || '').trigger('change');
                $('[name="user_rujukan"]').val(draft.user_rujukan || '');



            }
        };
    }

    // Hapus draft setelah simpan
    function clearDraft() {
        const noreg = $('#noreg').val();
        if (!db || !noreg) return;

        const tx = db.transaction("drafts", "readwrite");
        tx.objectStore("drafts").delete(`${menu}_${noreg}`);
    }

    // Hapus draft setelah submit
    function deleteDraft(noreg) {
        alert(noreg);
        if (!db || !noreg) return;

        const tx = db.transaction("drafts", "readwrite");
        tx.objectStore("drafts").delete(`${menu}_${noreg}`);
    }

    // Simulasi simpan ke database
    $('#formKonsultasi').on('submit', function(e) {
        e.preventDefault();
        alert("Data disimpan ke database (simulasi)");
        clearDraft();
    });

    // Auto-save setiap 10 detik
    setInterval(() => {
        // const noreg = $('#noreg').val();
        const noreg = $('#no_registrasi').text();
        if (noreg) saveDraft();
        // Tampilkan Draft Saved notification
        // toastr.success('Saved Draft.')
    }, 5000);

    // Inisialisasi Select2 dan event
    $(document).ready(function() {
        $('#selectNoreg').select2();
        $('#selectPoli').select2();
        $('#selectNoreg').on('change', function() {
            // const noreg = $(this).val();
            const noreg = $('#no_registrasi').text();
            // $('#noreg').val(noreg);
            loadDraft(noreg);
        });
        initDB();
    });
</script>


<!-- Signature-pad.js -->
<!-- <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script> -->
<!-- <script type="text/javascript" src="<?= base_url('assets/js/signature-pad.js') ?>"></script> -->

<?= $this->endSection('script'); ?>