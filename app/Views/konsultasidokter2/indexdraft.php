<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>

<!-- datepicker styles -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css">

<style>
    ul {
        list-style-type: none;
    }

    .wrapper_m {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
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

    /* CSS untuk Select2 */
    .select2-container .select2-selection--single {
        height: 30px !important;
        display: flex;
        align-items: center;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 30px !important;
        font-size: 12px !important;
        margin-top: -2px !important;
        top: 0px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 30px !important;
    }

    .form-control {
        height: 30px;
        font-size: 12px;
        display: flex;
        align-items: center;
    }

    #overlay-riwayat-pemeriksaan {
        position: absolute;
        display: none;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 3;
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

    #overlay-rujukan {
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
    }

    .table-responsive {
        display: table;
    }

    .nav-tabs.flex-column .nav-link {
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

    .content-header-fixed {
        -webkit-transition: -webkit-transform .3s ease-in-out, margin .3s ease-in-out;
        -moz-transition: -moz-transform .3s ease-in-out, margin .3s ease-in-out;
        -o-transition: -o-transform .3s ease-in-out, margin .3s ease-in-out;
        transition: transform .3s ease-in-out, margin .3s ease-in-out;
        position: fixed;
        color: #fff;
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

    .caption_text {
        font-size: 0.6rem;
    }

    .content_text {
        font-size: 1rem;
        color: blue;
    }

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

<?= $this->endSection('style'); ?>

<?= $this->section('controlsidebaricon'); ?>

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

<div class="content-wrapper">

    <section class="content-header-fixed">
        <div class="container-fluid">
            <div class="row">
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
                                        <dt class="caption_text">Nomor Registrasi</dt>
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
        </div>
    </section>

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
                                    <?= view('konsultasidokter2/tab-one') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="vert-tabs-two" role="tabpanel" aria-labelledby="vert-tabs-two-tab">
                <?= view('konsultasidokter2/tab-two') ?>
            </div>
            <div class="tab-pane fade" id="vert-tabs-thre" role="tabpanel" aria-labelledby="vert-tabs-thre-tab">
                <?= view('konsultasidokter2/tab-thre') ?>
            </div>
            <div class="tab-pane fade" id="vert-tabs-four" role="tabpanel" aria-labelledby="vert-tabs-four-tab">
                <?= view('konsultasidokter2/tab-four') ?>
            </div>
            <div class="tab-pane fade" id="vert-tabs-five" role="tabpanel" aria-labelledby="vert-tabs-five-tab">
                <?= view('konsultasidokter2/tab-five') ?>
            </div>
        </div>
</div>

</div>

</div>

</div>

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
                                            <div class="form-group">
                                                <label>Jenis Surat</label>
                                                <?= $cb_jenissurat ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-12">
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

        </div>
    </div>
</div>

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

        </div>
    </div>
</div>

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
                    <input type="hidden" id="ap_registrasi_via" name="registrasi_via" value="off">
                    <input type="hidden" id="ap_kode_dokter" name="kode_dokter">
                    <input type="hidden" id="ap_tahun" name="tahun">
                    <input type="hidden" id="ap_bulan" name="bulan">
                    <input type="hidden" id="ap_hari" name="hari">

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
</section>
</div>

<?= $this->endSection('content'); ?>

<?= $this->section('control-sidebar'); ?>

<aside class="control-sidebar control-sidebar-dark" style="height:100vh;">
    <div class="p-1 control-sidebar-content os-host os-theme-light os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition os-host-overflow os-host-overflow-y" style="height: 602px;">

        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="card-title">Daftar Pasien</h3>
            </div>
            <div class="card-body p-0">
                <span id="viewdata"></span>
            </div>
        </div>
    </div>
</aside>

<?= $this->endSection('control-sidebar'); ?>

<?= $this->section('script'); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<script>
    $('#active-menu').html($('p#active-menu').html());
    $(document).prop("title", $('p#active-menu').html());
</script>

<script>
    function clearForm() {
        $('#permulaan_dt').val('');

        $('.errorPermulaan_dt').html('');
        $('.errorKategori_alergi').html('');
        $('.errorBahan_alergi').html('');
        $('.errorKomponen_alergi').html('');
        $('.errorReaksi_alergi').html('');
        $('.errorTingkat_kegawatan_alergi').html('');
        $('.errorStatus_alergi').html('');
        $('.errorVerifikasi_alergi').html('');
        $('.errorCatatan').html('');

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

        $('input[name=responden]').prop('checked', false);
        $('#keluhan_utama').val('');
        $('#riwayat_perjalanan_keluhan').val('');
        $('#riwayat_penyakit_sekarang').val('');
        $('#riwayat_penyakit_dahulu').val('');
        $('#riwayat_operasi_pengobatan').val('');
        $('#riwayat_penyakit_keluarga').val('');
        $('#riwayat_lain').val('');

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

        $('#diagnosa_utama').val('');
        $('input[name=klasifikasi_utama]').prop('checked', false);
        $('#diagnosa_sekunder').val('');
        $('input[name=klasifikasi_sekunder]').prop('checked', false);

        $('.all_row_diagnosa').remove();
        $('.all_row').remove();

        $('h2#grand_total').val('Rp. 0,00');

        $('#ket_rujukan').val('');
        $('#summernotet').summernote('code', '');
    }

    function tregistrasi() {
        $.ajax({
            method: "get",
            url: "<?= site_url('konsultasidokter2/fetchAll'); ?>",
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

    function riwayatRm(patient_no) {
        $.ajax({
            url: "<?= site_url('konsultasidokter2/fetchAllRiwayat'); ?>",
            method: "GET",
            data: {
                patient_no: patient_no
            },
            success: function(data) {
                $('#viewdatariwayat').html(data);
            }
        });
    }

    function riwayatRmAnamnesa(patient_no) {
        $.ajax({
            url: "<?= site_url('konsultasidokter2/fetchAllRiwayatAnamnesa'); ?>",
            method: "GET",
            data: {
                patient_no: patient_no
            },
            success: function(data) {
                $('#viewdatariwayatanamnesa').html(data);
            }
        });
    }

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
                        alert('terjadi error!');
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                        });
                        $('#modalformregistrasi').modal('hide');
                    }
                },
            })
        });

        $(document).on('click', '.riwayat', function() {
            var no_registrasi = $(this).data('no_registrasi');
            var patient_no = $(this).data('patient_no');

            $.ajax({
                url: "<?= site_url('konsultasidokter2/apiDataGetAlergiByPasien'); ?>",
                method: "GET",
                data: {
                    patient_no: patient_no
                },
                dataType: "JSON",
                beforeSend: function() {
                    $("#overlay-riwayat-pemeriksaan").css("display", "flex");
                },
                complete: function() {
                    $("#overlay-riwayat-pemeriksaan").css("display", "none");
                },
                success: function(data) {
                    $('#alergi_array_length').val(data.length);
                    $('.r_all_row').remove();

                    for (var i = 0; i < data.length; i++) {
                        $('#r_dynamic_alergi').append(
                            '<tr id="r_row' + i + '" class="r_all_row">' +
                            '<td><select class="custom-select" name="r_kategori_alergi[]" id="r_kategori_alergi' + i + '"></select></td>' +
                            '<td><select class="custom-select" multiple="multiple" name="r_komponen_alergi[]" id="r_komponen_alergi' + i + '"></select></td>' +
                            '<td><select class="custom-select" multiple="multiple" name="r_reaksi_alergi[]" id="r_reaksi_alergi' + i + '"></select></td>' +
                            '<td>' +
                            '<input type="hidden" name="r_alergi_no[]" value="' + data[i].alergi_no + '">' +
                            '<button type="button" name="remove" id="' + i + '" ' +
                            'class="btn btn-sm btn-danger btn_remove_alergi" ' +
                            'data-alergi_no="' + data[i].alergi_no + '" ' +
                            'data-patient_no="' + data[i].patient_no + '">X</button>' +
                            '</td>' +
                            '</tr>'
                        );

                        $('#r_kategori_alergi' + i).select2(select2AjaxConfig('kategori_alergi'));
                        var kategoriOption = new Option(data[i].kategori_desc, data[i].kategori, true, true);
                        $('#r_kategori_alergi' + i).append(kategoriOption).trigger('change');

                        $('#r_komponen_alergi' + i).select2(select2AjaxConfig('komponen_alergi'));
                        var komponenIds = data[i].komponen ? data[i].komponen.split(',') : [];
                        var komponenDescs = data[i].komponen_desc ? data[i].komponen_desc.split(',') : [];
                        $.each(komponenIds, function(j, val) {
                            var desc = komponenDescs[j] ? $.trim(komponenDescs[j]) : val;
                            var option = new Option(desc, $.trim(val), true, true);
                            $('#r_komponen_alergi' + i).append(option);
                        });
                        $('#r_komponen_alergi' + i).trigger('change');

                        $('#r_reaksi_alergi' + i).select2(select2AjaxConfig('reaksi_alergi'));
                        var reaksiIds = data[i].reaksi ? data[i].reaksi.split(',') : [];
                        var reaksiDescs = data[i].reaksi_desc ? data[i].reaksi_desc.split(',') : [];
                        $.each(reaksiIds, function(j, val) {
                            var desc = reaksiDescs[j] ? $.trim(reaksiDescs[j]) : val;
                            var option = new Option(desc, $.trim(val), true, true);
                            $('#r_reaksi_alergi' + i).append(option);
                        });
                        $('#r_reaksi_alergi' + i).trigger('change');
                    }
                }
            });

            $.ajax({
                url: "<?= site_url('konsultasidokter2/apiDataGetDiagnosaTambahanByRegistrasi'); ?>",
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
                            if (!item.id) {
                                return item.text;
                            }
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
                            templateResult: formatResult2
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

            if ($(this).data('status') === 'DT') {
                $('#status').val('Draft');
            } else {
                $('#status').val('New');
            }

            $('input[name=responden]').prop('checked', false);
            $('#r_keluhan_utama').val('');
            $('#r_riwayat_perjalanan_keluhan').val('');
            $('#r_riwayat_penyakit_sekarang').val('');
            $('#r_riwayat_penyakit_dahulu').val('');
            $('#r_riwayat_operasi_pengobatan').val('');
            $('#r_riwayat_penyakit_keluarga').val('');
            $('#r_riwayat_lain').val('');

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

            $('#r_diagnosa_utama').val('');
            $('input[name=klasifikasi_utama]').prop('checked', false);
            $('#r_diagnosa_sekunder').val('');
            $('input[name=klasifikasi_sekunder]').prop('checked', false);

            $.ajax({
                url: "<?= site_url('konsultasidokter2/apiDataGetAnamnesa'); ?>",
                method: "GET",
                data: {
                    no_registrasi: no_registrasi
                },
                dataType: "JSON",
                success: function(data) {
                    if (data.length > 0) {
                        $('input[type=radio][name*=responden][value=' + (data[0].keluhan_utama == 'True' ? 1 : 0) + ']').prop('checked', true).change();
                        $('#r_keluhan_utama').val(data[0].keluhan_utama);
                        $('#r_riwayat_perjalanan_keluhan').val(data[0].riwayat_perjalanan_keluhan);
                        $('#r_riwayat_penyakit_sekarang').val(data[0].riwayat_penyakit_sekarang);
                        $('#r_riwayat_penyakit_dahulu').val(data[0].riwayat_penyakit_dahulu);
                        $('#r_riwayat_operasi_pengobatan').val(data[0].riwayat_operasi_pengobatan);
                        $('#r_riwayat_penyakit_keluarga').val(data[0].riwayat_penyakit_keluarga);
                        $('#r_riwayat_lain').val(data[0].riwayat_lain);
                    } else {
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
                url: "<?= site_url('konsultasidokter2/apiDataGetPeriksa'); ?>",
                method: "GET",
                data: {
                    no_registrasi: no_registrasi
                },
                dataType: "JSON",
                success: function(data) {
                    if (data.length > 0) {
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
                url: "<?= site_url('konsultasidokter2/apiDataGetDiagnosa'); ?>",
                method: "GET",
                data: {
                    no_registrasi: no_registrasi
                },
                dataType: "JSON",
                success: function(data) {
                    if (data.length > 0) {
                        $('#r_diagnosa_utama').val(data[0].diagnosa_utama);
                        $('input[type=radio][name*=klasifikasi_utama][value=' + data[0].klasifikasi_utama + ']').prop('checked', true).change();
                        $('#r_diagnosa_sekunder').val(data[0].diagnosa_sekunder);
                        $('input[type=radio][name*=klasifikasi_sekunder][value=' + data[0].klasifikasi_sekunder + ']').prop('checked', true).change();

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

            $('input#checkKeluhan_utama_c:checked').prop('checked', false);
            $('input#checkRiwayat_perjalanan_keluhan_c:checked').prop('checked', false);
            $('input#checkRiwayat_penyakit_sekarang_c:checked').prop('checked', false);
            $('input#checkRiwayat_operasi_pengobatan_c:checked').prop('checked', false);
            $('input#checkRiwayat_penyakit_keluarga_c:checked').prop('checked', false);
            $('input#checkRiwayat_lain_c:checked').prop('checked', false);
            $('input#checkRiwayat_penyakit_dahulu_c:checked').prop('checked', false);

            $('#keluhan_utama_c').val('');
            $('#riwayat_perjalanan_keluhan_c').val('');
            $('#riwayat_penyakit_sekarang_c').val('');
            $('#riwayat_operasi_pengobatan_c').val('');
            $('#riwayat_penyakit_keluarga_c').val('');
            $('#riwayat_lain_c').val('');
            $('#riwayat_penyakit_dahulu_c').val('');

            $('#modalCopyAnamnesa').modal('hide');
        });

        $(document).on('click', '#clear_button', function() {
            $('input#checkKeluhan_utama_c:checked').prop('checked', false);
            $('input#checkRiwayat_perjalanan_keluhan_c:checked').prop('checked', false);
            $('input#checkRiwayat_penyakit_sekarang_c:checked').prop('checked', false);
            $('input#checkRiwayat_operasi_pengobatan_c:checked').prop('checked', false);
            $('input#checkRiwayat_penyakit_keluarga_c:checked').prop('checked', false);
            $('input#checkRiwayat_lain_c:checked').prop('checked', false);
            $('input#checkRiwayat_penyakit_dahulu_c:checked').prop('checked', false);

            $('#keluhan_utama_c').val('');
            $('#riwayat_perjalanan_keluhan_c').val('');
            $('#riwayat_penyakit_sekarang_c').val('');
            $('#riwayat_operasi_pengobatan_c').val('');
            $('#riwayat_penyakit_keluarga_c').val('');
            $('#riwayat_lain_c').val('');
            $('#riwayat_penyakit_dahulu_c').val('');

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
                url: "<?= site_url('konsultasidokter2/fetchAllAnamnesaCardByPasien'); ?>",
                method: "GET",
                data: {
                    patient_no: patient_no
                },
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

        $(document).on('click', '#modalRadiologiRow', function() {
            $('#modalRadiologi').modal();
            if ($('#radiologi_wrapper_m').html() == '') {
                $.ajax({
                    url: "<?= site_url('konsultasidokter2/apiDataRadiologiGetAll'); ?>",
                    method: "GET",
                    dataType: "JSON",
                    success: function(data) {
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
                                const $checkbox = $(`<input type="checkbox" class="form-check-input myCheckbox" id="${item.code}" data-id="${item.code}" data-ppn="${item.ppn}" data-harga="${item.harga_jual}" data-diskon="${item.diskon_pct}" data-desc="${item.description}" data-layanan="LY_003">`);
                                const $label = $(`<label class="form-check-label" for="${item.code}"></label>`);
                                $li.append($formcheck);
                                $formcheck.append($checkbox);
                                $formcheck.append($label);
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
                    url: "<?= site_url('konsultasidokter2/apiDataRadiologiGetAll'); ?>",
                    method: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        var jsonData = {};
                        $.each(data, function(index, item) {
                            jsonData[item.item_cd.toLowerCase()] = true;
                        });
                        $.each(jsonData, function(key, value) {
                            $('#' + key).prop('checked', value);
                        });
                    }
                });
            }
        });

        $(document).on('click', '#modalLaboratoriumRow', function() {
            $('#modalLaboratorium').modal();
            if ($('#lab_wrapper_m').html() == '') {
                $.ajax({
                    url: "<?= site_url('konsultasidokter2/apiDataLabGetAll'); ?>",
                    method: "GET",
                    dataType: "JSON",
                    success: function(data) {
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
                                const $checkbox = $(`<input type="checkbox" class="form-check-input myCheckbox" id="${item.code}" data-id="${item.code}" data-ppn="${item.ppn}" data-harga="${item.harga_jual}" data-diskon="${item.diskon_pct}" data-desc="${item.description}" data-layanan="LY_004">`);
                                const $label = $(`<label class="form-check-label" for="${item.code}"></label>`);
                                $li.append($formcheck);
                                $formcheck.append($checkbox);
                                $formcheck.append($label);
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
                    url: "<?= site_url('konsultasidokter2/apiDataLabGetAll'); ?>",
                    method: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        var jsonData = {};
                        $.each(data, function(index, item) {
                            jsonData[item.item_cd.toLowerCase()] = true;
                        });
                        $.each(jsonData, function(key, value) {
                            $('#' + key).prop('checked', value);
                        });
                    }
                });
            }
        });

        $(".tab-pane").css("display", "none");
        $('#titikKeluhan').addClass('disabled');
        $('#submit_button').prop('disabled', true);

    });

    $(document).on('click', '.pilihpasien', function() {

        var noreg = $(this).data('no_registrasi');

        loadDraft(noreg);
        alert(noreg);

        $('#body-container').show();
        $('.header-info').show();

        var no_registrasi = $(this).data('no_registrasi');
        var patient_no = $(this).data('patient_no');

        $.ajax({
            url: "<?= site_url('konsultasidokter2/setNoRegistrasi'); ?>",
            method: "GET",
            data: {
                no_registrasi: no_registrasi,
                patient_no: patient_no
            },
            success: function(data) {
                $('#titikKeluhan').removeClass('disabled');
                $('#submit_button').prop('disabled', false);
            }
        });

        $.ajax({
            url: "<?= site_url('konsultasidokter2/apiDataGetAlergiByPasien'); ?>",
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
                    var komponenIds = data[i].komponen ? String(data[i].komponen).split(',') : [];
                    var komponenDescs = data[i].komponen_desc ? String(data[i].komponen_desc).split(',') : [];
                    var reaksiIds = data[i].reaksi ? String(data[i].reaksi).split(',') : [];
                    var reaksiDescs = data[i].reaksi_desc ? String(data[i].reaksi_desc).split(',') : [];

                    komponenIds = komponenIds.map(function(v) {
                        return v.replace(/\+/g, '').trim();
                    });
                    reaksiIds = reaksiIds.map(function(v) {
                        return v.replace(/\+/g, '').trim();
                    });

                    komponenIds = komponenIds.filter(function(v) {
                        return v !== '';
                    });
                    reaksiIds = reaksiIds.filter(function(v) {
                        return v !== '';
                    });

                    $('#dynamic_alergi').append(
                        '<tr id="row' + i + '" class="all_row">' +
                        '<td>' +
                        '<select class="custom-select" name="alergi[' + i + '][kategori]" id="kategori_alergi' + i + '">' +
                        '</select>' +
                        '</td>' +
                        '<td>' +
                        '<select class="custom-select" multiple="multiple" name="alergi[' + i + '][komponen][]" id="komponen_alergi' + i + '">' +
                        '</select>' +
                        '</td>' +
                        '<td>' +
                        '<select class="custom-select" multiple="multiple" name="alergi[' + i + '][reaksi][]" id="reaksi_alergi' + i + '">' +
                        '</select>' +
                        '<input type="hidden" name="alergi[' + i + '][alergi_no]" value="' + (data[i].alergi_no || '') + '">' +
                        '</td>' +
                        '<td>' +
                        '<button type="button" name="remove" id="' + i + '" ' +
                        'class="btn btn-sm btn-danger btn_remove_alergi" ' +
                        'data-alergi_no="' + (data[i].alergi_no || '') + '" ' +
                        'data-patient_no="' + (data[i].patient_no || patient_no) + '">X</button>' +
                        '</td>' +
                        '</tr>'
                    );

                    $('#kategori_alergi' + i).select2({
                        ajax: {
                            url: "<?= site_url('konsultasidokter2/ajaxKategoriAlergi/kategori_alergi'); ?>",
                            dataType: 'json',
                            data: function(params) {
                                return {
                                    search: params.term
                                };
                            },
                            processResults: function(data) {
                                return {
                                    results: data
                                };
                            }
                        },
                        cache: true,
                        placeholder: 'Cari Kategori...',
                        minimumInputLength: 0,
                        width: 'auto',
                    });

                    if (data[i].kategori) {
                        var kategoriOption = new Option(data[i].kategori_desc || data[i].kategori, data[i].kategori, true, true);
                        $('#kategori_alergi' + i).append(kategoriOption).trigger('change');
                    }

                    $('#komponen_alergi' + i).select2({
                        ajax: {
                            url: "<?= site_url('konsultasidokter2/ajaxKategoriAlergi/komponen_alergi'); ?>",
                            dataType: 'json',
                            data: function(params) {
                                return {
                                    search: params.term
                                };
                            },
                            processResults: function(data) {
                                return {
                                    results: data
                                };
                            }
                        },
                        cache: true,
                        placeholder: 'Cari Komponen...',
                        minimumInputLength: 0,
                        width: 'auto',
                    });

                    if (komponenIds.length > 0) {
                        $.each(komponenIds, function(j, val) {
                            var desc = komponenDescs[j] ? komponenDescs[j] : val;
                            var option = new Option(desc, val, true, true);
                            $('#komponen_alergi' + i).append(option);
                        });
                        $('#komponen_alergi' + i).trigger('change');
                    }

                    $('#reaksi_alergi' + i).select2({
                        ajax: {
                            url: "<?= site_url('konsultasidokter2/ajaxKategoriAlergi/reaksi_alergi'); ?>",
                            dataType: 'json',
                            data: function(params) {
                                return {
                                    search: params.term
                                };
                            },
                            processResults: function(data) {
                                return {
                                    results: data
                                };
                            }
                        },
                        cache: true,
                        placeholder: 'Cari Reaksi...',
                        minimumInputLength: 0,
                        width: 'auto',
                    });

                    if (reaksiIds.length > 0) {
                        $.each(reaksiIds, function(j, val) {
                            var desc = reaksiDescs[j] ? reaksiDescs[j] : val;
                            var option = new Option(desc, val, true, true);
                            $('#reaksi_alergi' + i).append(option);
                        });
                        $('#reaksi_alergi' + i).trigger('change');
                    }
                }
            }
        });

        $.ajax({
            url: "<?= site_url('konsultasidokter2/apiDataGetDiagnosaTambahanByRegistrasi'); ?>",
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
                    var formatResult2 = function(item) {
                        if (!item.id) return item.text;
                        return $('<span>' + item.id + ' - ' + item.english + ' <br><span style="color:red;">[ ' + item.indonesia + ' ]</span></span>');
                    };

                    $('#dynamic_field').append(
                        '<div class="card all_row_diagnosa" id="row' + i + '">' +
                        '<div class="card-body">' +
                        '<div class="row">' +
                        '<div class="col-sm-12">' +
                        '<div class="form-group">' +
                        '<label>Diagnosa Tambahan</label>' +
                        '<input type="text" name="diagnosa_tambahan[]" class="form-control" id="diagnosa_tambahan' + i + '" value="' + (data[i].diagnosa || '') + '">' +
                        '<span class="error invalid-feedback errorDiagnosa_tambahan"></span>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="row">' +
                        '<div class="col-sm-12">' +
                        '<label>ICD 10</label>' +
                        '<div class="form-group">' +
                        '<select class="form-control form-control-sm" name="icd10_tambahan[]" id="icd10_tambahan' + i + '">' +
                        '<option value="">-- Select --</option>' +
                        '</select>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="row">' +
                        '<div class="col-sm-12">' +
                        '<label></label><br>' +
                        '<div class="form-group d-flex justify-content-between align-items-center">' +
                        '<div class="form-check-inline">' +
                        '<label class="form-check-label">' +
                        '<input type="radio" class="form-check-input radio" name="klasifikasi_tambahan' + i + '" value="terduga" data-id="' + i + '" ' + (data[i].klasifikasi == 'terduga' ? 'checked' : '') + '>Terduga' +
                        '</label>' +
                        '</div>' +
                        '<div class="form-check-inline">' +
                        '<label class="form-check-label">' +
                        '<input type="radio" class="form-check-input radio" name="klasifikasi_tambahan' + i + '" value="gejala" data-id="' + i + '" ' + (data[i].klasifikasi == 'gejala' ? 'checked' : '') + '>Gejala' +
                        '</label>' +
                        '</div>' +
                        '<div class="form-check-inline">' +
                        '<label class="form-check-label">' +
                        '<input type="radio" class="form-check-input radio" name="klasifikasi_tambahan' + i + '" value="dikonfirmasi" data-id="' + i + '" ' + (data[i].klasifikasi == 'dikonfirmasi' ? 'checked' : '') + '>Sudah Dikonfirmasi' +
                        '</label>' +
                        '</div>' +
                        '<br>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="row">' +
                        '<input type="hidden" name="klasifikasi_tambahan[]" id="klasifikasi_tambahan' + i + '" value="' + (data[i].klasifikasi || '') + '">' +
                        '<div class="col-sm-12">' +
                        '<input type="hidden" name="seq_id[]" value="' + (data[i].seq_id || '') + '">' +
                        '<button type="button" name="remove" id="' + i + '" class="btn btn-xs btn-danger btn_remove float-right" data-no_registrasi="' + (data[i].no_registrasi || '') + '" data-seq_id="' + (data[i].seq_id || '') + '">HAPUS</button>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>'
                    );

                    $('#icd10_tambahan' + i).select2({
                        ajax: {
                            url: "<?= site_url('icdapi/ajax-search-icdn'); ?>",
                            dataType: 'json',
                            data: function(params) {
                                return {
                                    search: params.term
                                };
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
                        templateResult: formatResult2
                    });

                    if (data[i].icd10) {
                        var newOptionUtama = new Option(data[i].icd10, data[i].icd10, true, true);
                        $('#icd10_tambahan' + i).append(newOptionUtama).trigger('change');
                    }
                }
            }
        });

        if ($(this).data('status') === 'DT') {
            $('#status').val('Draft');
        } else {
            $('#status').val('New');
        }

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
        var tanggal = $(this).data('tanggal') || today.toISOString().split('T')[0];

        $('#patient_no').val(patient_no);
        $('#fullname_tm').html(fullname);
        $('#tgl_pemeriksaan').val(today.toLocaleDateString("en-US"));
        $('#birth_dt_tm').html(convertDateIndo(birth_dt));
        $('#usia_tm').html('<b>' + tahun + '</b> Tahun, <b>' + bulan + '</b> Bulan, <b>' + hari + '</b> Hari');
        $('#tahun').html(tahun);
        $('#bulan').html(bulan);
        $('#gender_tm').html(gender);
        $('#mobile_no_tm').html(mobile_no);
        $('#nama_dokter').html(nama_dokter);
        $('#tujuan_registrasi_desc').html(tujuan_registrasi_desc);
        $('#no_registrasi').html(no_registrasi);
        $('.medrec_id_info').html(patient_no);
        $('.medrec_id').val(patient_no);
        $('#type_pasien').html(type_pasien);
        $(".tab-pane").css("display", "");
        $('#alergi').val(alergi);
        $('.alergi').html(alergi);
        $('#no_kwitansi').val(no_kwitansi);
        $('.no_registrasi').val(no_registrasi);

        $('#ap_patient_no').val(patient_no);
        $('#ap_tujuan_registrasi').val(tujuan_registrasi);
        $('#ap_tanggal').val(tanggal);
        $('#ap_kode_dokter').val(kode_dokter);
        $('#ap_tahun').val(tahun);
        $('#ap_bulan').val(bulan);
        $('#ap_hari').val(hari);

        $('input[name=responden]').prop('checked', false);
        $('#keluhan_utama').val('');
        $('#riwayat_perjalanan_keluhan').val('');
        $('#riwayat_penyakit_sekarang').val('');
        $('#riwayat_penyakit_dahulu').val('');
        $('#riwayat_operasi_pengobatan').val('');
        $('#riwayat_penyakit_keluarga').val('');
        $('#riwayat_lain').val('');
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
        $('#diagnosa_utama').val('');
        $('input[name=klasifikasi_utama]').prop('checked', false);
        $('#diagnosa_sekunder').val('');
        $('input[name=klasifikasi_sekunder]').prop('checked', false);

        $.ajax({
            url: "<?= site_url('konsultasidokter2/fetchAllRiwayatCardByPasien'); ?>",
            method: "GET",
            data: {
                patient_no: patient_no
            },
            success: function(data) {
                $('#viewriwayatcard').html(data);
            }
        });

        $.ajax({
            url: "<?= site_url('konsultasidokter2/apiDataGetByNoRegistrasi'); ?>",
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

                $('#printcard').css({
                    'display': 'flex',
                    'flex-direction': 'row',
                    'height': '100%'
                });

                for (var i = 0; i < data.length; i++) {
                    var html = '<div style="flex: 0 0 auto; width: 100%; height: 100%;">' +
                        '  <div class="card h-100" style="border: none; background: transparent;">' +
                        '    <div class="card-body userimg d-flex align-items-center justify-content-center" style="height: 100%;">' +
                        '    </div>' +
                        '  </div>' +
                        '</div>';

                    $('#printcard').append(html);

                    var $img = $("<img/>");
                    $img.addClass('img-fluid rounded mx-auto d-block');
                    $img.css({
                        'max-width': '100%',
                        'max-height': '100%',
                        'object-fit': 'contain'
                    });
                    $img.attr("src", '/assets/img/titikkeluhan/' + data[i].image + '.jpg?' + new Date().getTime());

                    $(".userimg:eq(" + i + ")").append($img);
                }
            }
        });

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
            url: "<?= site_url('konsultasidokter2/apiDataGetByNoRegistrasi'); ?>",
            method: "GET",
            data: {
                no_registrasi: no_registrasi
            },
            dataType: "JSON",
            success: function(data) {
                $('#printcard').empty();

                $('#printcard').css({
                    'display': 'flex',
                    'flex-direction': 'row',
                    'height': '100%',
                    'overflow-x': 'auto'
                });

                var html = '<div style="flex: 0 0 auto; width: 100%; height: 100%;">';
                html += '<div class="card h-100" style="border: none; background: transparent;">';
                html += '<div class="card-body userimg d-flex align-items-center justify-content-center" style="height: 100%; padding: 10px;">';
                html += '</div>';
                html += '</div>';
                html += '</div>';

                for (var i = 0; i < data.length; i++) {
                    $('#printcard').append(html);

                    uimg = data[i].image;

                    var $img = $("<img/>");
                    $img.addClass('img-fluid');
                    $img.css({
                        'max-width': '100%',
                        'max-height': '100%',
                        'object-fit': 'contain'
                    });
                    $img.attr("src", '/assets/img/titikkeluhan/' + uimg + '.jpg?' + new Date().getTime());
                    $(".userimg:eq(" + i + ")").append($img);
                }
            }
        })
    });

    $(document).on('click', '.pilihmr', function() {
        var medrec_id = $(this).data('medrec_id');

        $.ajax({
            url: "<?= site_url('konsultasidokter2/fetchSingleData'); ?>",
            method: "GET",
            data: {
                medrec_id: medrec_id
            },
            dataType: "JSON",
            success: function(response) {
                $('#medrec_id_rm').val('');
                $('#patient_no_rm').val('');
                $('#fullname_rm').val('');
                $('#no_registrasi_rm').val('');
                $('#tgl_pemeriksaan_rm').val('');
                $('#usia_rm').html('');
                $('#keluhan_rm').val('');
                $('#anamnesa_rm').val('');

                $('#medrec_id_rm').html(response.data.medrec_id);
                $('#patient_no_rm').html(response.data.patient_no);
                $('#fullname_rm').html(response.data.fullname);
                $('#no_registrasi_rm').html(response.data.no_registrasi);
                $('#tgl_pemeriksaan_rm').html(convertDateIndo(response.data.tgl_pemeriksaan));
                $('#usia_rm').html('<b>' + response.data.tahun + '</b> Tahun, <b>' + response.data.bulan + '</b> Bulan, <b>' + response.data.hari + '</b> Hari');
                $('#keluhan_rm').html(response.data.keluhan);
                $('#anamnesa_rm').html(response.data.anamnesa);
            }
        })
    });

    $('#data_form2').on('submit', function(event) {

        event.preventDefault();
        $.ajax({
            url: "<?= site_url('konsultasidokter2/action2'); ?>",
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
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.success,
                    });

                    $('#permulaan_dt').val('');
                    $('.errorPermulaan_dt').html('');
                    $('.errorKategori_alergi').html('');
                    $('.errorBahan_alergi').html('');
                    $('.errorKomponen_alergi').html('');
                    $('.errorReaksi_alergi').html('');
                    $('.errorTingkat_kegawatan_alergi').html('');
                    $('.errorStatus_alergi').html('');
                    $('.errorVerifikasi_alergi').html('');
                    $('.errorCatatan').html('');

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
                }
            }
        })
    });

    $('#data_form_anamnesa').on('submit', function(event) {

        event.preventDefault();
        $.ajax({
            url: "<?= site_url('konsultasidokter2/action_anamnesa'); ?>",
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
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.success,
                    });

                    $('#permulaan_dt').val('');
                    $('.errorPermulaan_dt').html('');
                    $('.errorKategori_alergi').html('');
                    $('.errorBahan_alergi').html('');
                    $('.errorKomponen_alergi').html('');
                    $('.errorReaksi_alergi').html('');
                    $('.errorTingkat_kegawatan_alergi').html('');
                    $('.errorStatus_alergi').html('');
                    $('.errorVerifikasi_alergi').html('');
                    $('.errorCatatan').html('');

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
                }
            }
        })
    });

    $('#data_form_periksa').on('submit', function(event) {

        event.preventDefault();
        $.ajax({
            url: "<?= site_url('konsultasidokter2/action_periksa'); ?>",
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
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.success,
                    });

                    $('#permulaan_dt').val('');
                    $('.errorPermulaan_dt').html('');
                    $('.errorKategori_alergi').html('');
                    $('.errorBahan_alergi').html('');
                    $('.errorKomponen_alergi').html('');
                    $('.errorReaksi_alergi').html('');
                    $('.errorTingkat_kegawatan_alergi').html('');
                    $('.errorStatus_alergi').html('');
                    $('.errorVerifikasi_alergi').html('');
                    $('.errorCatatan').html('');

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
                }
            }
        })
    });

    $('#data_form_diagnosa').on('submit', function(event) {

        event.preventDefault();
        $.ajax({
            url: "<?= site_url('konsultasidokter2/action_diagnosa'); ?>",
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
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.success,
                    });

                    $('#permulaan_dt').val('');
                    $('.errorPermulaan_dt').html('');
                    $('.errorKategori_alergi').html('');
                    $('.errorBahan_alergi').html('');
                    $('.errorKomponen_alergi').html('');
                    $('.errorReaksi_alergi').html('');
                    $('.errorTingkat_kegawatan_alergi').html('');
                    $('.errorStatus_alergi').html('');
                    $('.errorVerifikasi_alergi').html('');
                    $('.errorCatatan').html('');

                    $('#icd10_utama').val(' ');
                    $('#icd10_utama').trigger('change');
                    $('#icd10_sekunder').val(' ');
                    $('#icd10_sekunder').trigger('change');

                    $('#submit_button_periksa').val('SIMPAN');
                    $('#submit_button_periksa').html('SIMPAN');
                }
            }
        })
    });

    function convertDateIndo(date) {
        var d_arr = date.split("/");
        var fromDate = d_arr[1] + '/' + d_arr[0] + '/' + d_arr[2];
        dateNew = fromDate.split(' ')[0];
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
        return dateNew;
    }

    function getDateIndo() {
        var dateNew = new Date().toLocaleDateString('en-GB');
        return dateNew;
    }
</script>

<script>
    $(document).ready(function() {

        $('#layanan', '.dynamic_biaya').select2({
            ajax: {
                url: "<?= site_url('konsultasidokter2/ajaxKategoriBiaya/layanan'); ?>",
                dataType: 'json',
                data: function(params) {
                    var query = {
                        search: params.term
                    }
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
        });

        $(document).on('click', '#modalSuratBtn', function() {
            $('#modalSurat').modal();
        });

        function formatResult(item) {
            if (!item.id) {
                return item.text;
            }
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
            templateResult: formatResult
        });

        $("#icd10_sekunder").select2({
            ajax: {
                url: "<?= site_url('icdapi/ajax-search-icdn'); ?>",
                dataType: 'json',
                data: function(params) {
                    var query = {
                        search: params.term
                    }
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
            templateResult: formatResult
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
    });

    $(document).ready(function() {
        $('#add').click(function() {
            var i = $('#diagnosa_array_length').val();

            function formatResult2(item) {
                if (!item.id) {
                    return item.text;
                }
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
                templateResult: formatResult2
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
                    url: "<?= site_url('konsultasidokter2/delete_diagnosa'); ?>",
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
                        });
                    }
                })
            }
        });

        $(document).on('change', '.radio', function() {
            var radio = $(this).data("id");
            $('#klasifikasi_tambahan' + radio + '').val($(this).val());
        });

    });

    function select2AjaxConfig(type) {
        return {
            ajax: {
                url: "<?= site_url('konsultasidokter2/ajaxKategoriAlergi/'); ?>" + type,
                dataType: 'json',
                data: function(params) {
                    return {
                        search: params.term
                    };
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
        };
    }

    $(document).ready(function() {

        $('#add_alergi').click(function() {
            var i = parseInt($('#alergi_array_length').val());
            var patient_no = $('#patient_no').val();

            $('#dynamic_alergi').append(
                '<tr id="row' + i + '" class="all_row">' +
                '<td>' +
                '<select class="custom-select" name="alergi[' + i + '][kategori]" id="kategori_alergi' + i + '">' +
                '</select>' +
                '</td>' +
                '<td>' +
                '<select class="custom-select" multiple="multiple" name="alergi[' + i + '][komponen][]" id="komponen_alergi' + i + '">' +
                '</select>' +
                '</td>' +
                '<td>' +
                '<select class="custom-select" multiple="multiple" name="alergi[' + i + '][reaksi][]" id="reaksi_alergi' + i + '">' +
                '</select>' +
                '<input type="hidden" name="alergi[' + i + '][alergi_no]" value="">' +
                '</td>' +
                '<td>' +
                '<button type="button" name="remove" id="' + i + '" ' +
                'class="btn btn-sm btn-danger btn_remove_alergi" ' +
                'data-patient_no="' + patient_no + '" ' +
                'data-alergi_no="">X</button>' +
                '</td>' +
                '</tr>'
            );

            $('#kategori_alergi' + i).select2({
                ajax: {
                    url: "<?= site_url('konsultasidokter2/ajaxKategoriAlergi/kategori_alergi'); ?>",
                    dataType: 'json',
                    data: function(params) {
                        return {
                            search: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    }
                },
                cache: true,
                placeholder: 'Cari Kategori...',
                minimumInputLength: 0,
                width: 'auto'
            });

            $('#komponen_alergi' + i).select2({
                ajax: {
                    url: "<?= site_url('konsultasidokter2/ajaxKategoriAlergi/komponen_alergi'); ?>",
                    dataType: 'json',
                    data: function(params) {
                        return {
                            search: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    }
                },
                cache: true,
                placeholder: 'Cari Komponen...',
                minimumInputLength: 0,
                width: 'auto'
            });

            $('#reaksi_alergi' + i).select2({
                ajax: {
                    url: "<?= site_url('konsultasidokter2/ajaxKategoriAlergi/reaksi_alergi'); ?>",
                    dataType: 'json',
                    data: function(params) {
                        return {
                            search: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    }
                },
                cache: true,
                placeholder: 'Cari Reaksi...',
                minimumInputLength: 0,
                width: 'auto'
            });

            $('#alergi_array_length').val(i + 1);
        });

        $(document).on('click', '.btn_remove_alergi', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id).remove();

            var patient_no = $(this).data('patient_no');
            var alergi_no = $(this).data('alergi_no');
            if (confirm("Are you sure you want to remove it?")) {
                $.ajax({
                    url: "<?= site_url('konsultasidokter2/delete_alergi'); ?>",
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
                        });
                    }
                })
            }
        });

        $('#add_header_biaya').click(function() {

            var item = $("#kode_item.select2 option:selected").val();
            // if (item == ' ') {
            //     alert("Item belum dipilih");
            // } else {

            //     var i = $('#biaya_array_length').val();
            //     var layanan_text = $("#layanan.select2 option:selected").text();
            //     var layanan = $("#layanan.select2 option:selected").val();
            //     var item_text = $("#kode_item.select2 option:selected").text();
            //     var item_cd = $("#kode_item.select2 option:selected").val();
            //     var qty = Number($("#kuantitas").val().replace(/\./g, "").replace(',', '.'));
            //     var harga = Number($("#harga").val().replace(/\./g, "").replace(',', '.'));
            //     var total = qty * harga;
            //     var takaran = $("#takaran").val();
            //     var hari = $("#hari").val();
            //     var frekuensi = $("#frekuensi").val();
            //     var petunjuk = $("#petunjuk").val();
            //     var reduksi = Number($("#pengurang").val().replace(/\./g, "").replace(',', '.'));
            //     var harga_sd = Number($("#harga_order").val().replace(/\./g, "").replace(',', '.'));
            //     var pajak_persen = 11;
            //     var pajak = (harga_sd * pajak_persen / 100);
            //     var harga_sp = harga_sd + pajak;

            //     alert(pajak);

            //     $('#dynamic_biaya').append('<tr id="row_biaya' + i + '" class="all_row"><td><input type="text" class="form-control inputfield" id="layanan_text' + i + '" value="' + layanan_text + '" readonly/></td><td><input type="text" class="form-control inputfield" name="item[]" id="item' + i + '" value="' + item_text + '" readonly/></td><td><input type="text" class="form-control inputfield" name="qty[]" id="qty' + i + '" value="' + qty + '" readonly/></td><td><input type="text" class="form-control inputfield" dir="rtl" name="biaya_amount[]" id="biaya_amount' + i + '" value="' + addCommas(harga_sd) + '" readonly/></td><td><input type="text" class="form-control inputfield" dir="rtl" value="' + addCommas(total) + '" readonly/></td><td><input type="hidden" id="layanan' + i + '" name="layanan[]" value="' + layanan + '"><input type="hidden" id="item_cd' + i + '" name="item_cd[]" value="' + item_cd + '"><input class="amount" type="hidden" name="harga[]" value="' + total + '"><input type="hidden" name="takaran[]" value="' + takaran + '"><input type="hidden" name="hari[]" value="' + hari + '"><input type="hidden" name="frekuensi[]" value="' + frekuensi + '"><input type="hidden" name="pemakaian[]" value="' + pemakaian + '"><input type="hidden" name="kuantitas[]" value="' + kuantitas + '"><input type="hidden" name="reduksi[]" value="' + reduksi + '"><input type="hidden" name="harga_sd[]" value="' + harga_sd + '"><input type="hidden" name="pajak_persen[]" value="' + pajak_persen + '"><input type="hidden" name="pajak[]" value="' + pajak + '"><input type="hidden" name="harga_sp[]" value="' + harga_sp + '"><button type="button" name="select"  style="display:none;" id="' + i + '" class="btn btn-xs btn-info btn_select_biaya ml-1" data-biaya_no="" data-patient_no="">View</button><button type="button" name="edit" style="display:none;" id="' + i + '" class="btn btn-xs btn-warning btn_edit_biaya ml-1" data-biaya_no="" data-patient_no="">Edit</button><button type="button" name="remove" id="' + i + '" class="btn btn-xs btn-danger btn_remove_biaya ml-1" data-biaya_no="" data-patient_no="">X</button></td></tr>');

            //     i++;

            //     $('#biaya_array_length').val(i);
            //     sumTotal();

            //     $('#modalTindakan').modal('hide');
            // }


            if (item == ' ') {
                alert("Item belum dipilih");
            } else {
                // Ambil nilai dengan parsing yang benar
                var i = $('#biaya_array_length').val();
                var layanan_text = $("#layanan.select2 option:selected").text();
                var layanan = $("#layanan.select2 option:selected").val();
                var item_text = $("#kode_item.select2 option:selected").text();
                var item_cd = $("#kode_item.select2 option:selected").val();

                // var harga_jual = $("#kode_item.select2 option:selected").data("harga");
                // var ppn = $("#kode_item.select2 option:selected").data("ppn");
                // var diskon_pct = $("#kode_item.select2 option:selected").data("diskon");
                // alert(harga_jual + " - " + ppn + " - " + diskon_pct);


                // Parsing angka dengan benar
                var qty = parseFloat($("#kuantitas").val().replace(/\./g, "").replace(',', '.'));
                var harga = parseFloat($("#harga").val().replace(/\./g, "").replace(',', '.'));
                var total = qty * harga;
                var takaran = $("#takaran").val();
                var hari = $("#hari").val();
                var frekuensi = $("#frekuensi").val();
                var petunjuk = $("#petunjuk").val();
                var reduksi = parseFloat($("#pengurang").val().replace(/\./g, "").replace(',', '.'));

                // Ambil harga_sd dan hitung pajak dengan benar
                var harga_sd = parseFloat($("#harga_order").val().replace(/\./g, "").replace(',', '.'));
                var pajak_persen = 11;
                var pajak = Math.round(harga_sd * pajak_persen / 100); // Dibulatkan
                var harga_sp = harga_sd + pajak;

                // Pastikan nilai pemakaian dan kuantitas tidak undefined
                var pemakaian = $("#pemakaian").val() || '';
                var kuantitas = qty || 0;

                $('#dynamic_biaya').append('<tr id="row_biaya' + i + '" class="all_row"><td><input type="text" class="form-control inputfield" id="layanan_text' + i + '" value="' + layanan_text + '" readonly/></td><td><input type="text" class="form-control inputfield" name="item[]" id="item' + i + '" value="' + item_text + '" readonly/></td><td><input type="text" class="form-control inputfield" name="qty[]" id="qty' + i + '" value="' + qty + '" readonly/></td><td><input type="text" class="form-control inputfield" dir="rtl" name="biaya_amount[]" id="biaya_amount' + i + '" value="' + addCommas(harga_sd) + '" readonly/></td><td><input type="text" class="form-control inputfield" dir="rtl" value="' + addCommas(total) + '" readonly/></td><td><input type="hidden" id="layanan' + i + '" name="layanan[]" value="' + layanan + '"><input type="hidden" id="item_cd' + i + '" name="item_cd[]" value="' + item_cd + '"><input class="amount" type="hidden" name="harga[]" value="' + total + '"><input type="hidden" name="takaran[]" value="' + takaran + '"><input type="hidden" name="hari[]" value="' + hari + '"><input type="hidden" name="frekuensi[]" value="' + frekuensi + '"><input type="hidden" name="pemakaian[]" value="' + pemakaian + '"><input type="hidden" name="kuantitas[]" value="' + kuantitas + '"><input type="hidden" name="reduksi[]" value="' + reduksi + '"><input type="text" name="harga_sd[]" value="' + harga_sd + '"><input type="text" name="pajak_persen[]" value="' + pajak_persen + '"><input type="text" name="pajak[]" value="' + pajak + '"><input type="text" name="harga_sp[]" value="' + harga_sp + '"><button type="button" name="select"  style="display:none;" id="' + i + '" class="btn btn-xs btn-info btn_select_biaya ml-1" data-biaya_no="" data-patient_no="">View</button><button type="button" name="edit" style="display:none;" id="' + i + '" class="btn btn-xs btn-warning btn_edit_biaya ml-1" data-biaya_no="" data-patient_no="">Edit</button><button type="button" name="remove" id="' + i + '" class="btn btn-xs btn-danger btn_remove_biaya ml-1" data-biaya_no="" data-patient_no="">X</button></td></tr>');

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
            sumTotal();
        });

        $(document).on('click', '.add_header_biaya_sub', function() {
            var i = $('#biaya_sub_array_length').val();

            $('#dynamic_biaya_sub').append('<tr id="row_biaya_sub' + i + '" class="all_row"><td><select class="custom-select" name="layanan[]" id="layanan_biaya_sub' + i + '"><option value=" " selected="selected">-- Select --</option></select></td><td><input type="text" size="2" class="form-control input-sm" name="biaya_amount[]" id="biaya_amount' + i + '"/></td><td><input type="text" size="2" class="form-control input-sm" name="biaya_amount[]" id="biaya_amount' + i + '"/></td><td><input type="text" size="2" class="form-control input-sm" name="biaya_amount[]" id="biaya_amount' + i + '"/></td><td><input type="text" class="form-control input-sm" name="biaya_amount[]" id="biaya_amount' + i + '"/></td><td><input type="text" size="3" class="form-control input-sm" name="biaya_amount[]" id="biaya_amount' + i + '"/></td><td><input type="text" size="2" class="form-control input-sm" name="biaya_amount[]" id="biaya_amount' + i + '"/></td><td><input type="text" size="15" class="form-control input-sm" name="biaya_amount[]" id="biaya_amount' + i + '"/></td><td><input type="hidden" name="alergi_no[]" value=""><button type="button" name="remove" id="' + i + '" class="btn btn-xs btn-danger btn_remove_biaya_sub ml-1" data-biaya_no="" data-patient_no="">X</button></td></tr>');

            $('#layanan_biaya_sub' + i + '', '#dynamic_biaya_sub').select2({
                ajax: {
                    url: "<?= site_url('konsultasidokter2/ajaxKategoriBiaya/item_test'); ?>",
                    dataType: 'json',
                    data: function(params) {
                        var query = {
                            search: params.term
                        }
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
            });

            $('#layanan_produk' + i + '', '#dynamic_biaya_sub').select2({
                ajax: {
                    url: "<?= site_url('konsultasidokter2/ajaxKategoriBiaya/item'); ?>",
                    dataType: 'json',
                    data: function(params) {
                        var query = {
                            search: params.term
                        }
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
            });

            $('#reaksi_alergi' + i + '', '#dynamic_alergi').select2({
                ajax: {
                    url: "<?= site_url('konsultasidokter2/ajaxKategoriAlergi/reaksi_alergi'); ?>",
                    dataType: 'json',
                    data: function(params) {
                        var query = {
                            search: params.term
                        }
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
            });

            i++;

            $('#biaya_sub_array_length').val(i);

        });

        $(document).on('click', '.btn_remove_biaya_sub', function() {
            var button_id = $(this).attr("id");
            $('#row_biaya_sub' + button_id).remove();
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
                link = "/konsultasidokter2/draw1";
                linkimg = "/dist/img/Head.jpg";
                window.open(link, '_blank');
            } else if (val == "Breast") {
                link = "/konsultasidokter2/draw2";
                linkimg = "/dist/img/Breast.jpg";
                window.open(link, '_blank');
            } else if (val == "Dental") {
                link = "/konsultasidokter2/draw3";
                linkimg = "/dist/img/Dental.jpg";
                window.open(link, '_blank');
            } else if (val == "RectumAnalCanal") {
                link = "/konsultasidokter2/draw4";
                linkimg = "/dist/img/RectumAnalCanal.jpg";
                window.open(link, '_blank');
            } else if (val == "Blank") {
                link = "/konsultasidokter2/draw5";
                linkimg = "/dist/img/Blank.jpg";
                window.open(link, '_blank');
            } else if (val == "Wajah") {
                link = "/konsultasidokter2/draw6";
                linkimg = "/dist/img/Wajah.jpg";
                window.open(link, '_blank');
            } else if (val == "Wajah2") {
                link = "/konsultasidokter2/draw7";
                linkimg = "/dist/img/Wajah2.jpg";
                window.open(link, '_blank');
            } else {
                link = "/konsultasidokter2/draw1";
                linkimg = "/dist/img/Blank.jpg";
            }
            $('.titikkeluhan').attr("src", linkimg);
        });

        $(document).on('click', '.refreshTitikKeluhan', function() {
            var no_registrasi = $('#no_registrasi').text();

            $.ajax({
                url: "<?= site_url('konsultasidokter2/apiDataGetByNoRegistrasi'); ?>",
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

                    if (!data || data.length === 0) {
                        $('#printcard').html('<div class="alert alert-warning">Tidak ada data</div>');
                        return;
                    }

                    for (var i = 0; i < data.length; i++) {
                        var uimg = data[i].image;
                        var imgSrc = '/assets/img/titikkeluhan/' + uimg + '.jpg?' + new Date().getTime();

                        var html = '<div style="flex: 0 0 auto; width: 100%; height: 100%;">';
                        html += '  <div class="card h-100" style="border: none; background: transparent;">';
                        html += '    <div class="card-body d-flex align-items-center justify-content-center p-0" style="height: 100%;">';
                        html += '      <img src="' + imgSrc + '" ';
                        html += '           class="img-fluid" ';
                        html += '           style="width: 100%; height: 100%; object-fit: contain;" ';
                        html += '           onerror="this.src=\'/assets/img/default.png\'">';
                        html += '    </div>';
                        html += '  </div>';
                        html += '</div>';

                        $('#printcard').append(html);
                    }
                }
            })
        });

        $(document).on('click', '#wheelChair', function() {
            $.ajax({
                method: "get",
                url: "<?= site_url('konsultasidokter2/fetchAll'); ?>",
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

        $('#print_button_rujukan').click(function() {
            event.preventDefault();
            $.ajax({
                url: "<?= site_url('konsultasidokter2/action_rujukan'); ?>",
                type: "POST",
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
                    if (response.error) {} else {
                        var isi = $('.no_registrasi').val();
                        const winPdf = window.open("<?= base_url('/konsultasidokter2/print/') ?>" + isi);
                        winPdf.print();
                    }
                }
            })
        });

        $('#submit_button_rujukan').click(function() {
            event.preventDefault();
            $.ajax({
                url: "<?= site_url('konsultasidokter2/action_rujukan'); ?>",
                type: "POST",
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
                    if (response.error) {} else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                        });
                    }
                }
            })
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

    $('#takaran, #frekuensi, #hari').on('input', function() {
        let takaran = $('#takaran').val();
        let frekuensi = $('#frekuensi').val();
        let hari = $('#hari').val();
        let kuantitas = takaran * frekuensi * hari;
        $('#kuantitas').val(kuantitas);
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
        var id = $('#' + $(elem).data('id')).val();
        let htmlContent = $('#summernotet').summernote('code');
        htmlContent = htmlContent + id;
        $('#summernotet').summernote('code', htmlContent);
    }

    function formatRow(label, value) {
        if (value && value.trim() !== "") {
            return '<b>' + label + ' : </b>' + value + '<br>';
        }
        return "";
    }

    async function appendListItemAll() {
        $("#overlay-rujukan").css("display", "flex");
        var header = await appendListItemHeader();

        var imgHead = await getImageData('head');
        var imgBreast = await getImageData('breast');
        var imgDental = await getImageData('dental');
        var imgRectumAnus = await getImageData('rectum_anus');
        var imgWajah = await getImageData('wajah');
        var imgWajah2 = await getImageData('wajah2');
        var imgBlank = await getImageData('blank');

        var keluhan_utama = formatRow('Keluhan Utama', $('#keluhan_utama').val());
        var riwayat_perjalanan_keluhan = formatRow('Riwayat Perjalanan Keluhan', $('#riwayat_perjalanan_keluhan').val());
        var riwayat_penyakit_sekarang = formatRow('Riwayat Penyakit Sekarang', $('#riwayat_penyakit_sekarang').val());
        var riwayat_penyakit_dahulu = formatRow('Riwayat Penyakit Dahulu', $('#riwayat_penyakit_dahulu').val());
        var riwayat_operasi_pengobatan = formatRow('Riwayat Operasi / Pengobatan', $('#riwayat_operasi_pengobatan').val());
        var riwayat_penyakit_keluarga = formatRow('Riwayat Penyakit Keluarga', $('#riwayat_penyakit_keluarga').val());
        var riwayat_lain = formatRow('Riwayat Lain', $('#riwayat_lain').val());

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

        let htmlContent = $('#summernotet').summernote('code');
        $('#summernotet').summernote('code', htmlContent + all);
        $("#overlay-rujukan").css("display", "none");
    }

    function appendListItemHeader() {
        var no_registrasi = $("#no_registrasi").html();
        return $.ajax({
            url: "<?= site_url('konsultasidokter2/headerRujukan'); ?>",
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
                url: "<?= site_url('konsultasidokter2/titikKeluhan'); ?>",
                method: "GET",
                data: {
                    no_registrasi: no_registrasi,
                    gambar: jenisGambar
                }
            });
            return response ? response + "<br>" : "";
        } catch (error) {
            console.error("Gagal mengambil gambar: " + jenisGambar);
            return "";
        }
    }

    function appendListItemCustom(elem) {
        var no_registrasi = $("#no_registrasi").html();

        if ($(elem).data("id") == "header") {
            $.ajax({
                url: "<?= site_url('konsultasidokter2/headerRujukan'); ?>",
                method: "GET",
                data: {
                    no_registrasi: no_registrasi
                },
                success: function(data) {
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
                url: "<?= site_url('konsultasidokter2/titikKeluhan'); ?>",
                method: "GET",
                data: {
                    no_registrasi: no_registrasi,
                    gambar: gambar
                },
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
        $("#block_frekuensi").hide();
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

        $('#submit_button_all').on('click', function(event) {
            event.preventDefault();
            $.ajax({
                url: "<?= site_url('konsultasidokter2/action_all'); ?>",
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
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                        });

                        clearFormAll();
                        let noreg = $('#no_registrasi').text();

                        $(".hiddenLayanan").remove();
                        $(".hiddenItem_cd").remove();
                        $('#lab_wrapper_m').html('');
                        $('#radiologi_wrapper_m').html('');
                        $('#mcu_wrapper_m').html('');
                    }
                }
            });
        });

        $('#draft_button_all').click(function() {
            alert('test');
            event.preventDefault();
            $.ajax({
                url: "<?= site_url('konsultasidokter2/action_all'); ?>",
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
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                        });

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

            if (jenis !== ' ') {
                if (jenis == '002') {
                    $.ajax({
                        url: "<?= site_url('konsultasidokter2/suratLayakTerbang'); ?>",
                        method: "GET",
                        data: {
                            no_registrasi: no_registrasi
                        },
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
                        url: "<?= site_url('konsultasidokter2/suratLayakTerbangIbuHamil'); ?>",
                        method: "GET",
                        data: {
                            no_registrasi: no_registrasi
                        },
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
                        url: "<?= site_url('konsultasidokter2/suratKeteranganDokter'); ?>",
                        method: "GET",
                        data: {
                            no_registrasi: no_registrasi
                        },
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
                        url: "<?= site_url('konsultasidokter2/suratKeteranganSehat'); ?>",
                        method: "GET",
                        data: {
                            no_registrasi: no_registrasi
                        },
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
                        url: "<?= site_url('konsultasidokter2/suratKeteranganIstirahat'); ?>",
                        method: "GET",
                        data: {
                            no_registrasi: no_registrasi
                        },
                        success: function(data) {
                            var id = data;
                            let htmlContent = $('#summernotet2').summernote('code');
                            htmlContent = htmlContent + id;
                            $('#summernotet2').summernote('code', htmlContent);
                        }
                    });
                }
            }
        });

        $('#layanan.select2').on('change', function() {
            var jenis = $("#layanan.select2 option:selected").val();

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
                    $("#block_item").show();
                    $("#block_takaran").hide();
                    $("#block_frekuensi").hide();
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
                        url: "<?= site_url('konsultasidokter2/getDropdownLayananItem'); ?>",
                        method: "GET",
                        data: {
                            layanan: jenis
                        },
                        success: function(data) {
                            $('#dropdown_layananitem').html(data);
                            $('#kode_item').select2();
                        }
                    });
                }
                if (jenis == 'LY_002') {
                    $("#block_item").show();
                    $("#block_takaran").show();
                    $("#block_frekuensi").show();
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
                        url: "<?= site_url('konsultasidokter2/getDropdownLayananItem'); ?>",
                        method: "GET",
                        data: {
                            layanan: jenis
                        },
                        success: function(data) {
                            $('#dropdown_layananitem').html(data);
                            $('#kode_item').select2();
                        }
                    });
                }
                if (jenis == 'LY_003') {
                    $("#block_item").hide();
                    $("#block_takaran").hide();
                    $("#block_frekuensi").hide();
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
                    $("#block_item").hide();
                    $("#block_takaran").hide();
                    $("#block_frekuensi").hide();
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
                    $("#block_item").hide();
                    $("#block_takaran").hide();
                    $("#block_frekuensi").hide();
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
    });

    $(document).on('click', '.myCheckbox', function() {
        var item_cd = $(this).data('id');
        var layanan = $(this).data('layanan');
        if (layanan == 'LY_003') {
            var layanan_text = 'Radiologi';
        }
        if (layanan == 'LY_004') {
            var layanan_text = 'Laboratorium';
        }
        var item = $(this).data('desc');
        var harga_jual = $(this).data('harga');
        var ppn = $(this).data('ppn');
        var diskon_pct = $(this).data('diskon');

        if ($(this).is(':checked')) {
            var i = $('#biaya_array_length').val();
            var item = item;
            var qty = 1;
            var harga = harga_jual;
            var total = qty * harga;
            var takaran = "1";
            var hari = "1";
            var frekuensi = "1";
            var petunjuk = "1";
            var reduksi = 0;
            var harga_sd = harga;
            var pajak_persen = ppn;
            var pajak = (harga_sd * pajak_persen / 100);
            var harga_sp = harga_sd + pajak;

            // alert(pajak);
            // alert(pajak + persen);

            $('#dynamic_biaya').append('<tr id="row_biaya' + item_cd + '" class="all_row"><td><input type="text" class="form-control inputfield" name="layanan_text[]" id="layanan_text' + i + '" value="' + layanan_text + '" readonly/></td><td><input type="text" class="form-control inputfield" name="item[]" id="item' + i + '" value="' + item + '" readonly/></td><td><input type="text" class="form-control inputfield" name="qty[]" id="qty' + i + '" value="' + qty + '" readonly/></td><td><input type="text" class="form-control inputfield" dir="rtl" name="biaya_amount[]" id="biaya_amount' + i + '" value="' + addCommas(harga) + '" readonly/></td><td><input type="text" class="form-control inputfield" dir="rtl" value="' + addCommas(total) + '" readonly/></td><td><input type="hidden" id="layanan' + i + '" name="layanan[]" value="' + layanan + '"><input type="hidden" id="item_cd' + i + '" name="item_cd[]" value="' + item_cd + '"><input class="amount" type="hidden" name="harga[]" value="' + total + '"><input type="hidden" name="takaran[]" value="' + takaran + '"><input type="hidden" name="hari[]" value="' + hari + '"><input type="hidden" name="frekuensi[]" value="' + frekuensi + '"><input type="hidden" name="pemakaian[]" value="' + "1" + '"><input type="hidden" name="kuantitas[]" value="' + "1" + '"><input type="hidden" name="reduksi[]" value="' + reduksi + '"><input type="text" name="harga_sd[]" value="' + harga_sd + '"><input type="text" name="pajak_persen[]" value="' + pajak_persen + '"><input type="text" name="pajak[]" value="' + pajak + '"><input type="text" name="harga_sp[]" value="' + harga_sp + '"><button type="button" name="select"  style="display:none;" id="' + i + '" class="btn btn-xs btn-info btn_select_biaya ml-1" data-biaya_no="" data-patient_no="">View</button><button type="button" name="edit" style="display:none;" id="' + i + '" class="btn btn-xs btn-warning btn_edit_biaya ml-1" data-biaya_no="" data-patient_no="">Edit</button><button type="button" name="remove" id="' + item_cd + '" class="btn btn-xs btn-danger btn_remove_biaya ml-1" data-biaya_no="" data-patient_no="">X</button></td></tr>');

            i++;
            $('#biaya_array_length').val(i);
            sumTotal();

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
            $("#row_biaya" + kode).remove();
            sumTotal();
        }
    });

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
    const menu = "konsultasi";

    function saveDraft() {
        const noreg = $('#no_registrasi').text();

        if (!noreg || noreg === '') {
            return;
        }

        const draft = {
            id: `${menu}_${noreg}`,
            last_saved: new Date().toLocaleString(),

            responden: $('input[name="responden"]:checked').val(),
            keluhan_utama: $('#keluhan_utama').val(),
            riwayat_penyakit_dahulu: $('#riwayat_penyakit_dahulu').val(),
            riwayat_perjalanan_keluhan: $('#riwayat_perjalanan_keluhan').val(),
            riwayat_operasi_pengobatan: $('#riwayat_operasi_pengobatan').val(),
            riwayat_penyakit_keluarga: $('#riwayat_penyakit_keluarga').val(),
            riwayat_penyakit_sekarang: $('#riwayat_penyakit_sekarang').val(),
            riwayat_lain: $('#riwayat_lain').val(),

            kondisi_umum: $('#kondisi_umum').val(),
            tinggi_badan: $('#tinggi_badan').val(),
            berat_badan: $('#berat_badan').val(),
            bmi: $('#bmi').val(),
            suhu: $('#suhu').val(),
            sistolik: $('#sistolik').val(),
            diastolik: $('#diastolik').val(),
            denyut_nadi: $('#denyut_nadi').val(),
            laju_nafas: $('#laju_nafas').val(),
            kondisi_khusus: $('#kondisi_khusus').val(),
            pemeriksaan_tambahan: $('#pemeriksaan_tambahan').val(),

            diagnosa_utama: $('#diagnosa_utama').val(),
            icd10_utama: $('#icd10_utama').val(),
            klasifikasi_utama: $('input[name="klasifikasi_utama"]:checked').val(),
            diagnosa_sekunder: $('#diagnosa_sekunder').val(),
            icd10_sekunder: $('#icd10_sekunder').val(),
            klasifikasi_sekunder: $('input[name="klasifikasi_sekunder"]:checked').val(),

            ket_rujukan: $('#ket_rujukan').val(),
            dokter_rujukan: $('#dokter_rujukan').val(),
            user_rujukan: $('#user_rujukan').val(),
            summernotet: $('#summernotet').val()
        };

        try {
            localStorage.setItem(draft.id, JSON.stringify(draft));
        } catch (e) {
            console.error("Gagal menyimpan draft:", e.message);
        }
    }

    function loadDraft(noreg) {
        if (!noreg || noreg === '') {
            return;
        }

        const id = `${menu}_${noreg}`;
        const data = localStorage.getItem(id);

        if (!data) {
            return;
        }

        try {
            const draft = JSON.parse(data);

            if (draft.responden) $(`input[name="responden"][value="${draft.responden}"]`).prop('checked', true);
            $('#keluhan_utama').val(draft.keluhan_utama || '');
            $('#riwayat_penyakit_dahulu').val(draft.riwayat_penyakit_dahulu || '');
            $('#riwayat_perjalanan_keluhan').val(draft.riwayat_perjalanan_keluhan || '');
            $('#riwayat_operasi_pengobatan').val(draft.riwayat_operasi_pengobatan || '');
            $('#riwayat_penyakit_keluarga').val(draft.riwayat_penyakit_keluarga || '');
            $('#riwayat_penyakit_sekarang').val(draft.riwayat_penyakit_sekarang || '');
            $('#riwayat_lain').val(draft.riwayat_lain || '');

            $('#kondisi_umum').val(draft.kondisi_umum || '');
            $('#tinggi_badan').val(draft.tinggi_badan || '');
            $('#berat_badan').val(draft.berat_badan || '');
            $('#bmi').val(draft.bmi || '');
            $('#suhu').val(draft.suhu || '');
            $('#sistolik').val(draft.sistolik || '');
            $('#diastolik').val(draft.diastolik || '');
            $('#denyut_nadi').val(draft.denyut_nadi || '');
            $('#laju_nafas').val(draft.laju_nafas || '');
            $('#kondisi_khusus').val(draft.kondisi_khusus || '');
            $('#pemeriksaan_tambahan').val(draft.pemeriksaan_tambahan || '');

            $('#diagnosa_utama').val(draft.diagnosa_utama || '');
            $('#icd10_utama').val(draft.icd10_utama || '').trigger('change');
            if (draft.klasifikasi_utama) $(`input[name="klasifikasi_utama"][value="${draft.klasifikasi_utama}"]`).prop('checked', true);
            $('#diagnosa_sekunder').val(draft.diagnosa_sekunder || '');
            $('#icd10_sekunder').val(draft.icd10_sekunder || '').trigger('change');
            if (draft.klasifikasi_sekunder) $(`input[name="klasifikasi_sekunder"][value="${draft.klasifikasi_sekunder}"]`).prop('checked', true);

            $('#ket_rujukan').val(draft.ket_rujukan || '');
            $('#dokter_rujukan').val(draft.dokter_rujukan || '').trigger('change');
            $('#user_rujukan').val(draft.user_rujukan || '');
            $('#summernotet').val(draft.summernotet || '');

        } catch (e) {
            console.error("Gagal memuat draft:", e.message);
        }
    }

    function deleteDraft(noreg) {
        if (!noreg) return;
        const id = `${menu}_${noreg}`;
        localStorage.removeItem(id);
    }

    function showAllDrafts() {
        let total = 0;
        let message = "=== DRAFT TERSIMPAN ===\n\n";

        for (let i = 0; i < localStorage.length; i++) {
            const key = localStorage.key(i);
            if (key && key.startsWith(menu)) {
                total++;
                try {
                    const data = JSON.parse(localStorage.getItem(key));
                    message += total + ". " + key + "\n";
                    message += "   Keluhan: " + (data.keluhan_utama || '-').substring(0, 30) + "\n";
                    message += "   Waktu: " + (data.last_saved || '-') + "\n\n";
                } catch (e) {}
            }
        }

        if (total === 0) {
            alert("📭 Belum ada draft yang tersimpan");
        } else {
            alert(message + "Total: " + total + " draft");
        }
    }

    function clearAllDrafts() {
        if (confirm("Hapus SEMUA draft?")) {
            for (let i = localStorage.length - 1; i >= 0; i--) {
                const key = localStorage.key(i);
                if (key && key.startsWith(menu)) {
                    localStorage.removeItem(key);
                }
            }
            alert("✅ Semua draft telah dihapus!");
        }
    }

    setInterval(() => {
        const noreg = $('#no_registrasi').text();
        if (noreg && noreg !== '') {
            const keluhan = $('#keluhan_utama').val();
            if (keluhan && keluhan !== '') {
                saveDraft();
            }
        }
    }, 10000);

    $(document).ready(function() {
        $('#draft_button_all').on('click', function(e) {
            e.preventDefault();
            saveDraft();
        });

        $(document).on('click', '.pilihpasien', function() {
            var noreg = $(this).data('no_registrasi');
            $('#no_registrasi').text(noreg);
            loadDraft(noreg);
        });

        $('#formKonsultasi').off('submit').on('submit', function(e) {
            e.preventDefault();
            const noreg = $('#no_registrasi').text();
            deleteDraft(noreg);
        });

        $('body').append(`
            <div id="draftPanel" style="position: fixed; bottom: 10px; right: 10px; z-index: 9999; background: #343a40; padding: 8px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.3); cursor: move;">
                <div style="margin-bottom: 5px; font-size: 10px; color: white; text-align: center;">☰ DRAFT TOOLS ☰</div>
                <button id="btnShowAll" style="margin: 2px; padding: 5px 10px;" class="btn btn-info btn-sm">📋 Lihat Semua</button>
                <button id="btnClearAll" style="margin: 2px; padding: 5px 10px;" class="btn btn-danger btn-sm">🗑️ Hapus Semua</button>
                <button id="btnSaveNow" style="margin: 2px; padding: 5px 10px;" class="btn btn-success btn-sm">💾 Simpan</button>
            </div>
        `);

        const panel = $('#draftPanel');
        let isDragging = false;
        let startX, startY, startLeft, startTop;

        const savedLeft = localStorage.getItem('draftPanelLeft');
        const savedTop = localStorage.getItem('draftPanelTop');
        if (savedLeft && savedTop) {
            panel.css({
                left: savedLeft + 'px',
                right: 'auto',
                top: savedTop + 'px',
                bottom: 'auto'
            });
        }

        panel.on('mousedown', function(e) {
            if ($(e.target).is('button')) return;
            isDragging = true;
            startX = e.clientX;
            startY = e.clientY;
            startLeft = panel.position().left;
            startTop = panel.position().top;
            panel.css({
                opacity: '0.8',
                cursor: 'grabbing'
            });
            e.preventDefault();
        });

        $(document).on('mousemove', function(e) {
            if (!isDragging) return;
            let newLeft = startLeft + (e.clientX - startX);
            let newTop = startTop + (e.clientY - startY);
            const maxLeft = $(window).width() - panel.outerWidth();
            const maxTop = $(window).height() - panel.outerHeight();
            newLeft = Math.min(Math.max(0, newLeft), maxLeft);
            newTop = Math.min(Math.max(0, newTop), maxTop);
            panel.css({
                left: newLeft + 'px',
                right: 'auto',
                top: newTop + 'px',
                bottom: 'auto'
            });
        });

        $(document).on('mouseup', function() {
            if (isDragging) {
                isDragging = false;
                panel.css({
                    opacity: '1',
                    cursor: 'move'
                });
                localStorage.setItem('draftPanelLeft', panel.position().left);
                localStorage.setItem('draftPanelTop', panel.position().top);
            }
        });

        $('#btnShowAll').on('click', function() {
            showAllDrafts();
        });

        $('#btnClearAll').on('click', function() {
            clearAllDrafts();
        });

        $('#btnSaveNow').on('click', function() {
            saveDraft();
        });
    });
</script>

<?= $this->endSection('script'); ?>