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
</style>

<style>
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

    .form-section {
        margin-bottom: 12px;
    }

    .field-group {
        border: 1px solid #e9ecef;
        border-radius: 4px;
        padding: 10px 14px;
        margin-bottom: 12px;
        background: #fff;
    }

    .field-group-title {
        font-size: 0.85rem;
        font-weight: 700;
        color: #007bff;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    /* CSS untuk tombol keterangan alergi */
    .btn-keterangan-alergi {
        padding: 2px 8px;
        font-size: 12px;
        min-width: 30px;
    }

    .btn-keterangan-alergi i {
        font-size: 12px;
    }

    .btn_remove_alergi {
        padding: 2px 8px;
        font-size: 12px;
    }

    /* CSS untuk field riwayat operasi */
    #riwayat_operasi_pengobatan {
        min-height: 60px;
    }

    /* CSS untuk select2 multiple */
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #007bff;
        color: #fff;
        border: 1px solid #0062cc;
        border-radius: 3px;
        padding: 2px 8px;
        font-size: 11px;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: #fff;
        margin-right: 5px;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
        color: #ffc107;
    }
</style>

<style>
    .content-header-fixed {
        position: sticky;
        top: 0;
        color: #fff;
        z-index: 800;
        padding: 5px;
    }

    @media (max-width:767px) {
        .content-header-fixed {
            position: relative !important;
        }
    }
</style>

<style type="text/css">
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
    <section class="content-header-fixed" id="header-identitas-pasien" style="display:none;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card bg-info" style="padding:2px;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-6">
                                    <dl>
                                        <dt class="caption_text">Nomor Registrasi</dt><span id="no_registrasi" class="content_text">&nbsp;</span>
                                    </dl>
                                </div>
                                <div class="col-md-3 col-6">
                                    <dl>
                                        <dt class="caption_text">No. Rekam Medis</dt><span class="content_text medrec_id_info">&nbsp;</span>
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

    <!-- Main content -->
    <section class="content" id='melayang'>
        <div class="container-fluid" id="body-container" style="display: none;">
            <div class="row contents">
                <div class="col-md-12">

                    <div class="row">
                        <div class="col-12">
                            <h5>PEMERIKSAAN SAAT INI</h5>
                        </div>
                    </div>

                    <form method="post" id="data_form" autocomplete="off">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-12 col-sm-6">
                                <div class="card card-primary card-outline">
                                    <div class="card-body">

                                        <!-- ========================================= -->
                                        <!-- SECTION 1: ANAMNESA -->
                                        <!-- ========================================= -->
                                        <div class="field-group">
                                            <div class="field-group-title"><i class="fas fa-notes-medical mr-1"></i> Anamnesa</div>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Keluhan Utama</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-9">
                                                    <div class="form-group">
                                                        <label></label>
                                                        <textarea class="form-control" name="keluhan_utama" rows="3" placeholder="Enter ..." id="keluhan_utama"></textarea>
                                                        <span class="error invalid-feedback errorKeluhan_utama">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Riwayat Kesehatan Dahulu</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-9">
                                                    <div class="form-group">
                                                        <label></label>
                                                        <textarea class="form-control" name="riwayat_kesehatan_pasien" rows="3" placeholder="Enter ..." id="riwayat_kesehatan_pasien"></textarea>
                                                        <span class="error invalid-feedback errorRiwayat_kesehatan_pasien">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- TAMBAHKAN FIELD RIWAYAT OPERASI/PENGOBATAN DI SINI -->
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Riwayat Operasi / Pengobatan</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-9">
                                                    <div class="form-group">
                                                        <label></label>
                                                        <textarea class="form-control" name="riwayat_operasi_pengobatan" rows="3" placeholder="Masukkan riwayat operasi atau pengobatan ..." id="riwayat_operasi_pengobatan"></textarea>
                                                        <span class="error invalid-feedback errorRiwayat_operasi_pengobatan">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- ========================================= -->
                                        <!-- SECTION 2: ANTROPOMETRI -->
                                        <!-- ========================================= -->
                                        <div class="field-group">
                                            <div class="field-group-title"><i class="fas fa-weight mr-1"></i> Antropometri</div>
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <label>BMI</label>
                                                        <input type="number" class="form-control" placeholder="" id="bmi" min="0" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-sm-5">
                                                    <div class="form-group">
                                                        <label>Tinggi (cm)</label>
                                                        <input type="number" name="tinggi_badan" class="form-control" placeholder="" id="tinggi_badan" min="0">
                                                        <span class="error invalid-feedback errorTinggi_badan"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-5">
                                                    <div class="form-group">
                                                        <label>Berat (kg)</label>
                                                        <input type="number" name="berat_badan" class="form-control" placeholder="" id="berat_badan" min="0">
                                                        <span class="error invalid-feedback errorBerat_badan"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <label>WHR</label>
                                                        <input type="number" class="form-control" placeholder="" id="whr" min="0" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-sm-5">
                                                    <div class="form-group">
                                                        <label>Lingkar Pinggang (cm)</label>
                                                        <input type="number" name="lingkar_pinggang" class="form-control" placeholder="" id="lingkar_pinggang" min="0">
                                                        <span class="error invalid-feedback errorLingkar_pinggang"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-5">
                                                    <div class="form-group">
                                                        <label>Lingkar Pinggul (cm)</label>
                                                        <input type="number" name="lingkar_pinggul" class="form-control" placeholder="" id="lingkar_pinggul" min="0">
                                                        <span class="error invalid-feedback errorLingkar_pinggul"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <label>Lingkar Lengan Atas</label>
                                                        <input type="text" name="lingkar_lengan_atas" class="form-control" placeholder="" id="lingkar_lengan_atas" min="0" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-sm-5">
                                                    <div class="form-group">
                                                        <label id="muach">MUAC (cm)</label>
                                                        <input type="number" name="muac" class="form-control" placeholder="" id="muac" min="0">
                                                        <span class="error invalid-feedback errorMuac"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-5">
                                                    <!-- kosong -->
                                                </div>
                                            </div>
                                        </div>

                                        <!-- ========================================= -->
                                        <!-- SECTION 3: TANDA VITAL -->
                                        <!-- ========================================= -->
                                        <div class="field-group">
                                            <div class="field-group-title"><i class="fas fa-heartbeat mr-1"></i> Tanda Vital</div>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Sistem Peredaran Darah</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Sistolik (mmHG)</label>
                                                        <input type="number" name="sistolik" class="form-control" placeholder="" id="sistolik" min="0">
                                                        <span class="error invalid-feedback errorSistolik"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Diastolik (mmHG)</label>
                                                        <input type="number" name="diastolik" class="form-control" placeholder="" id="diastolik" min="0">
                                                        <span class="error invalid-feedback errorDiastolik"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Denyut Nadi (bpm)</label>
                                                        <input type="number" name="nadi" class="form-control" placeholder="" id="nadi" min="0">
                                                        <span class="error invalid-feedback errorNadi"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Respirasi</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Laju Pernafasan (rpm)</label>
                                                        <input type="number" name="laju_nafas" class="form-control" placeholder="" id="laju_nafas" min="0">
                                                        <span class="error invalid-feedback errorLaju_nafas"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>SpO2 (%)</label>
                                                        <input type="number" name="spo2" class="form-control" placeholder="" id="spo2" min="0">
                                                        <span class="error invalid-feedback errorSpo2"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <!-- kosong -->
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Suhu</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Suhu (&deg;c)</label>
                                                        <input type="number" name="suhu" class="form-control" placeholder="" id="suhu" min="0">
                                                        <span class="error invalid-feedback errorSuhu"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <!-- kosong -->
                                                </div>
                                                <div class="col-sm-3">
                                                    <!-- kosong -->
                                                </div>
                                            </div>
                                        </div>

                                        <!-- ========================================= -->
                                        <!-- SECTION 4: OBSERVASI LAINNYA -->
                                        <!-- ========================================= -->
                                        <div class="field-group">
                                            <div class="field-group-title"><i class="fas fa-stethoscope mr-1"></i> Observasi Lainnya</div>

                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <div class="form-group">
                                                        <label>Kondisi Umum</label>
                                                        <?= $cb_kondisi_umum ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="form-group">
                                                        <label>Kesadaran Umum</label>
                                                        <?= $cb_kesadaran ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="form-group">
                                                        <label>Psikososial dan Spiritual</label>
                                                        <?= $cb_psikososial_dan_spiritual ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <div class="form-group">
                                                        <label>Status Fungsional</label><br>
                                                        <div class="icheck-primary">
                                                            <input type="radio" id="mandiri" name="status_fungsional" value="mandiri" checked>
                                                            <label for="mandiri">Mandiri</label>
                                                        </div>
                                                        <div class="icheck-primary">
                                                            <input type="radio" id="perlu_bantuan" name="status_fungsional" value="perlubantuan">
                                                            <label for="perlu_bantuan">Perlu Bantuan</label>
                                                        </div>
                                                        <div class="icheck-primary">
                                                            <input type="radio" id="ketergantungan_total" name="status_fungsional" value="ketergantungantotal">
                                                            <label for="ketergantungan_total">Ketergantungan Total</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="form-group">
                                                        <label>Perlu Bantuan</label>
                                                        <input type="text" name="status_fungsional_perlubantuan_text" class="form-control" placeholder="" id="perlu_bantuan_text" min="0" step="5">
                                                        <span class="error invalid-feedback errorStatus_fungsional_perlubantuan_text"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="form-group">
                                                        <label>Kebutuhan Edukasi</label>
                                                        <textarea class="form-control" name="kebutuhan_edukasi" rows="3" placeholder="Enter ..." id="kebutuhan_edukasi"></textarea>
                                                        <span class="error invalid-feedback errorKebutuhan_edukasi">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <div class="form-group">
                                                        <label>Kepala dan Wajah</label>
                                                        <textarea class="form-control" name="kepala_dan_wajah" rows="3" placeholder="Enter ..." id="kepala_dan_wajah"></textarea>
                                                        <span class="error invalid-feedback errorKepala_dan_wajah">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="form-group">
                                                        <label>Cervical Spin</label>
                                                        <textarea class="form-control" name="cervical_spin" rows="3" placeholder="Enter ..." id="cervical_spin"></textarea>
                                                        <span class="error invalid-feedback errorCervical_spin">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="form-group">
                                                        <label>Thorax</label>
                                                        <textarea class="form-control" name="thorax" rows="3" placeholder="Enter ..." id="thorax"></textarea>
                                                        <span class="error invalid-feedback errorThorax">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <div class="form-group">
                                                        <label>Abdomen</label>
                                                        <textarea class="form-control" name="abdomen" rows="3" placeholder="Enter ..." id="abdomen"></textarea>
                                                        <span class="error invalid-feedback errorAbdomen">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="form-group">
                                                        <label>Pemeriksaan Neurologis</label>
                                                        <textarea class="form-control" name="pemeriksaan_neurologis" rows="3" placeholder="Enter ..." id="pemeriksaan_neurologis"></textarea>
                                                        <span class="error invalid-feedback errorPemeriksaan_neurologis">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="form-group">
                                                        <label>Ekstremitas / Muskulosekeletal</label>
                                                        <textarea class="form-control" name="ekstremitas_muskulosekeletal" rows="3" placeholder="Enter ..." id="ekstremitas_muskulosekeletal"></textarea>
                                                        <span class="error invalid-feedback errorEkstremitas_muskulosekeletal">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <div class="form-group">
                                                        <label>Status Lokalis</label>
                                                        <textarea class="form-control" name="status_lokalis" rows="3" placeholder="Enter ..." id="status_lokalis"></textarea>
                                                        <span class="error invalid-feedback errorStatus_lokalis">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="form-group">
                                                        <label>Riwayat Penggunaan Obat</label>
                                                        <textarea class="form-control" name="riwayat_penggunaan_obat" rows="3" placeholder="Enter ..." id="riwayat_penggunaan_obat"></textarea>
                                                        <span class="error invalid-feedback errorRiwayat_penggunaan_obat">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="form-group">
                                                        <label>Skrining Nyeri</label>
                                                        <?= $cb_skrining_nyeri ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <div class="form-group">
                                                        <label>Status Kehamilan</label><br>
                                                        <div class="icheck-primary">
                                                            <input type="radio" id="status_kehamilan_tidak" name="status_kehamilan" value="tidak" checked>
                                                            <label for="status_kehamilan_tidak">Tidak Hamil</label>
                                                        </div>
                                                        <div class="icheck-danger">
                                                            <input type="radio" id="status_kehamilan_hamil" name="status_kehamilan" value="hamil">
                                                            <label for="status_kehamilan_hamil">Hamil</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="form-group">
                                                        <label>HPHT</label>
                                                        <input type="text" name="status_kehamilan_hpht" class="form-control" placeholder="HPHT" id="status_kehamilan_hpht" min="0" step="5">
                                                        <span class="error invalid-feedback errorStatus_kehamilan_hpht"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="form-group">
                                                        <label>Gravid</label>
                                                        <input type="text" name="status_kehamilan_gravid" class="form-control" placeholder="Gravid" id="status_kehamilan_gravid" min="0" step="5">
                                                        <span class="error invalid-feedback errorStatus_kehamilan_gravid"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <div class="form-group">
                                                        <label>Abortus</label>
                                                        <input type="text" name="status_kehamilan_abortus" class="form-control" placeholder="Abortus" id="status_kehamilan_abortus" min="0" step="5">
                                                        <span class="error invalid-feedback errorStatus_kehamilan_abortus"></span>
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
                                                                    <th style="width:15%;">Jenis</th>
                                                                    <th style="width:25%;">Komponen</th>
                                                                    <th style="width:25%;">Reaksi</th>
                                                                    <th style="width:20%;">Keterangan</th>
                                                                    <th style="width:15%;"></th>
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

                                        <div class="field-group">
                                            <div class="field-group-title"><i class="fas fa-save mr-1"></i> Simpan Catatan</div>
                                            <div class="row">
                                                <div class="col-sm-12 text-center">
                                                    <input type="hidden" id="alergi_array_length">
                                                    <input type="hidden" id="patient_no" name="patient_no" />
                                                    <input type="hidden" class="no_registrasi" name="no_registrasi" />
                                                    <input type="hidden" id="action" name="action" value="Add" />
                                                    <button type="submit" name="submit" id="submit_button" class="btn btn-lg btn-primary" value="Simpan">Simpan</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
</div>

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
<!-- /end modal -->

<!-- Modal Keterangan Alergi -->
<div class="modal fade" id="modalKeteranganAlergi" tabindex="-1" role="dialog" aria-labelledby="modalKeteranganAlergiLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalKeteranganAlergiLabel">
                    <i class="fas fa-info-circle mr-2"></i>Keterangan Alergi
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="keterangan_alergi_modal">Keterangan <span class="text-muted">(opsional)</span></label>
                    <textarea class="form-control" id="keterangan_alergi_modal" rows="4" placeholder="Masukkan keterangan alergi..."></textarea>
                    <small class="form-text text-muted">Contoh: Riwayat alergi sejak kecil, pernah dirawat karena reaksi berat, dll.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="simpanKeteranganAlergi">
                    <i class="fas fa-save mr-1"></i>Simpan
                </button>
            </div>
        </div>
    </div>
</div>
<!-- /end modal keterangan alergi -->

<!-- Modal Copy Anamnesa -->
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
                                                <label>Riwayat Penyakit Sekarang</label>
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
<!-- /end modal -->

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

<script>
    $('#active-menu').html($('p#active-menu').html());
    $(document).prop("title", $('p#active-menu').html());
</script>

<script>
    function tregistrasi() {
        $.ajax({
            method: "get",
            url: "<?= site_url('pemeriksaanawal/fetchAll'); ?>",
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

    $(document).ready(function() {
        $(".tab-pane").css("display", "none");
        $('#titikKeluhan').addClass('disabled');
        $('#submit_button').prop('disabled', true);
        $('#header-identitas-pasien').hide();
        $('[data-widget="control-sidebar"]').ControlSidebar('show');
        tregistrasi();
    });

    // Variable untuk menyimpan row yang sedang diedit
    var currentKeteranganRow = null;

    // =============================================
    // FUNGSI INISIALISASI SELECT2 UNTUK ALERGI
    // =============================================
    function initSelect2Alergi(rowIndex, kategoriValue, komponenValues, reaksiValues, komponenDescs, reaksiDescs) {
        // 1. KATEGORI (single select)
        $('#kategori_alergi' + rowIndex).select2({
            ajax: {
                url: "<?= site_url('konsultasidokter/ajaxKategoriAlergi/kategori_alergi'); ?>",
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
            templateResult: function(data) {
                if (data.loading) {
                    return data.text;
                }
                return $('<span>' + data.text + '</span>');
            },
            templateSelection: function(data) {
                return data.text || data.id;
            }
        });

        // Set nilai kategori jika ada
        if (kategoriValue) {
            var kategoriText = kategoriValue;
            if (window.kategoriDescs && window.kategoriDescs[rowIndex]) {
                kategoriText = window.kategoriDescs[rowIndex];
            }
            var kategoriOption = new Option(kategoriText, kategoriValue, true, true);
            $('#kategori_alergi' + rowIndex).append(kategoriOption).trigger('change');
        }

        // 2. KOMPONEN (multiple select)
        $('#komponen_alergi' + rowIndex).select2({
            ajax: {
                url: "<?= site_url('konsultasidokter/ajaxKategoriAlergi/komponen_alergi'); ?>",
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
            templateResult: function(data) {
                if (data.loading) {
                    return data.text;
                }
                return $('<span>' + data.text + '</span>');
            },
            templateSelection: function(data) {
                return data.text || data.id;
            }
        });

        // Set nilai komponen jika ada - PAKAI SETTIMEOUT UNTUK MENUNGGU SELECT2 SIAP
        if (komponenValues && komponenValues.length > 0) {
            setTimeout(function() {
                $('#komponen_alergi' + rowIndex).empty();
                $.each(komponenValues, function(j, val) {
                    var text = val;
                    if (komponenDescs && komponenDescs[j] && komponenDescs[j].trim() !== '') {
                        text = komponenDescs[j];
                    }
                    var option = new Option(text, val, true, true);
                    $('#komponen_alergi' + rowIndex).append(option);
                });
                $('#komponen_alergi' + rowIndex).trigger('change');
            }, 200);
        }

        // 3. REAKSI (multiple select)
        $('#reaksi_alergi' + rowIndex).select2({
            ajax: {
                url: "<?= site_url('konsultasidokter/ajaxKategoriAlergi/reaksi_alergi'); ?>",
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
            templateResult: function(data) {
                if (data.loading) {
                    return data.text;
                }
                return $('<span>' + data.text + '</span>');
            },
            templateSelection: function(data) {
                return data.text || data.id;
            }
        });

        // Set nilai reaksi jika ada - PAKAI SETTIMEOUT UNTUK MENUNGGU SELECT2 SIAP
        if (reaksiValues && reaksiValues.length > 0) {
            setTimeout(function() {
                $('#reaksi_alergi' + rowIndex).empty();
                $.each(reaksiValues, function(j, val) {
                    var text = val;
                    if (reaksiDescs && reaksiDescs[j] && reaksiDescs[j].trim() !== '') {
                        text = reaksiDescs[j];
                    }
                    var option = new Option(text, val, true, true);
                    $('#reaksi_alergi' + rowIndex).append(option);
                });
                $('#reaksi_alergi' + rowIndex).trigger('change');
            }, 200);
        }
    }

    $(document).on('click', '.pilihpasien', function() {
        $('#body-container').show();
        $('#header-identitas-pasien').fadeIn();

        var no_registrasi = $(this).data('no_registrasi');
        var patient_no = $(this).data('patient_no');

        // Set session no_registrasi
        $.ajax({
            url: "<?= site_url('pemeriksaanawal/setNoRegistrasi'); ?>",
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

        // =============================================
        // 1. AMBIL DATA ALERGI
        // =============================================
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

                // Inisialisasi objek untuk menyimpan deskripsi
                window.kategoriDescs = {};
                window.komponenDescs = {};
                window.reaksiDescs = {};

                for (var i = 0; i < data.length; i++) {
                    // Proses data komponen dan reaksi
                    var komponenValues = data[i].komponen ? String(data[i].komponen).split(',') : [];
                    var reaksiValues = data[i].reaksi ? String(data[i].reaksi).split(',') : [];

                    var komponenDescs = [];
                    if (data[i].komponen_desc && data[i].komponen_desc.trim() !== '') {
                        komponenDescs = String(data[i].komponen_desc).split(',');
                    }

                    var reaksiDescs = [];
                    if (data[i].reaksi_desc && data[i].reaksi_desc.trim() !== '') {
                        reaksiDescs = String(data[i].reaksi_desc).split(',');
                    }

                    // Bersihkan nilai
                    komponenValues = komponenValues.map(function(v) {
                        return v.replace(/\+/g, '').trim();
                    }).filter(function(v) {
                        return v !== '';
                    });

                    reaksiValues = reaksiValues.map(function(v) {
                        return v.replace(/\+/g, '').trim();
                    }).filter(function(v) {
                        return v !== '';
                    });

                    komponenDescs = komponenDescs.map(function(v) {
                        return v.replace(/\+/g, '').trim();
                    }).filter(function(v) {
                        return v !== '';
                    });

                    reaksiDescs = reaksiDescs.map(function(v) {
                        return v.replace(/\+/g, '').trim();
                    }).filter(function(v) {
                        return v !== '';
                    });

                    // Jika deskripsi kosong, gunakan value sebagai text
                    if (komponenDescs.length === 0 && komponenValues.length > 0) {
                        komponenDescs = komponenValues.slice();
                    }
                    if (reaksiDescs.length === 0 && reaksiValues.length > 0) {
                        reaksiDescs = reaksiValues.slice();
                    }

                    // Simpan deskripsi
                    if (data[i].kategori_desc && data[i].kategori_desc.trim() !== '') {
                        window.kategoriDescs[i] = data[i].kategori_desc;
                    } else {
                        window.kategoriDescs[i] = data[i].kategori;
                    }
                    if (komponenDescs.length > 0) {
                        window.komponenDescs[i] = komponenDescs;
                    }
                    if (reaksiDescs.length > 0) {
                        window.reaksiDescs[i] = reaksiDescs;
                    }

                    // Buat row tabel
                    var keteranganValue = data[i].keterangan || '';
                    var alergiNo = data[i].alergi_no || '';

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
                        '</td>' +
                        '<td>' +
                        '<input type="hidden" name="alergi[' + i + '][keterangan]" id="keterangan_alergi_hidden_' + i + '" value="' + keteranganValue + '">' +
                        '<button type="button" class="btn btn-sm btn-info btn-keterangan-alergi" data-row="' + i + '" data-keterangan="' + keteranganValue + '">' +
                        '<i class="fas fa-pen"></i>' +
                        '</button>' +
                        '<input type="hidden" name="alergi[' + i + '][alergi_no]" value="' + alergiNo + '">' +
                        '</td>' +
                        '<td>' +
                        '<button type="button" name="remove" id="' + i + '" ' +
                        'class="btn btn-sm btn-danger btn_remove_alergi" ' +
                        'data-alergi_no="' + alergiNo + '" ' +
                        'data-patient_no="' + (data[i].patient_no || patient_no) + '">' +
                        '<i class="fas fa-trash"></i>' +
                        '</button>' +
                        '</td>' +
                        '</tr>'
                    );

                    // Inisialisasi Select2
                    initSelect2Alergi(i, data[i].kategori, komponenValues, reaksiValues, komponenDescs, reaksiDescs);
                }

                // Update tombol keterangan
                setTimeout(function() {
                    $('.btn-keterangan-alergi').each(function() {
                        var keterangan = $(this).data('keterangan');
                        if (keterangan && keterangan.trim() !== '') {
                            $(this).html('<i class="fas fa-check-circle text-success"></i>');
                            $(this).removeClass('btn-info').addClass('btn-success');
                            $(this).attr('title', 'Klik untuk mengubah keterangan');
                        }
                    });
                }, 500);
            }
        });

        // =============================================
        // 2. AMBIL DATA DIAGNOSA TAMBAHAN
        // =============================================
        $.ajax({
            url: "<?= site_url('pemeriksaanawal/apiDataGetDiagnosaTambahanByRegistrasi'); ?>",
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
                $('#diagnosa_array_length').val(data.length);
                $('.all_row_diagnosa').remove();

                for (var i = 0; i < data.length; i++) {
                    function formatResult2(item) {
                        if (!item.id) {
                            return item.text;
                        }
                        var element = $(`<span>${item.id} - ${item.english} <br><span style="color:red;">[ ${item.indonesia} ]</span></span>'`)
                        return element;
                    };

                    $('#dynamic_field').append('<div class="card all_row_diagnosa" id="row' + i + '"><div class="card-body"><div class="row"><div class="col-sm-12"><div class="form-group"><label>Diagnosa Tambahan</label><input type="text" name="diagnosa_tambahan[]" class="form-control" placeholder="" id="diagnosa_tambahan' + i + '" value="' + data[i].diagnosa + '"><span class="error invalid-feedback errorDiagnosa_tambahan"></span></div></div></div><div class="row"><div class="col-sm-12"><label>ICD 10 Utama</label><div class="form-group"><select class="form-control form-control-sm" name="icd10_tambahan[]" id="icd10_tambahan' + i + '"><option value=" " selected="selected">-- Select --</option></select></div></div></div><div class="row"><div class="col-sm-12"><label></label><br><div class="form-group d-flex justify-content-between align-items-center"><div class="form-check-inline"><label class="form-check-label"><input type="radio" class="form-check-input radio" name="klasifikasi_tambahan' + i + '" value="terduga" data-id="' + i + '" ' + (data[i].klasifikasi == 'terduga' ? 'checked' : '') + '>Terduga</label></div><div class="form-check-inline"><label class="form-check-label"><input type="radio" class="form-check-input radio" name="klasifikasi_tambahan' + i + '" value="gejala"  data-id="' + i + '" ' + (data[i].klasifikasi == 'gejala' ? 'checked' : '') + '>Gejala</label></div><div class="form-check-inline"><label class="form-check-label"><input type="radio" class="form-check-input radio" name="klasifikasi_tambahan' + i + '" value="dikonfirmasi" data-id="' + i + '" ' + (data[i].klasifikasi == 'dikonfirmasi' ? 'checked' : '') + '>Sudah Dikonfirmasi</label></div><br></div></div></div><div class="row"><input type="hidden" name="klasifikasi_tambahan[]" id="klasifikasi_tambahan' + i + '" value="' + data[i].klasifikasi + '"><div class="col-sm-12"><input type="hidden" name="seq_id[]" value="' + data[i].seq_id + '"><button type="button" name="remove" id="' + i + '" class="btn btn-xs btn-danger btn_remove float-right" data-no_registrasi="' + data[i].no_registrasi + '" data-seq_id="' + data[i].seq_id + '">HAPUS</button></div></div></div></div>');

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

                    var defaultValueUtama = {
                        id: data[i].icd10,
                        text: data[i].icd10
                    };
                    var newOptionUtama = new Option(defaultValueUtama.text, defaultValueUtama.id, true, true);
                    $('#icd10_tambahan' + i + '', '#dynamic_field').append(newOptionUtama).trigger('change');
                }
            }
        });

        // =============================================
        // CEK APAKAH DATA PEMERIKSAAN AWAL SUDAH ADA
        // =============================================
        $.ajax({
            url: "<?= site_url('pemeriksaanawal/fetchPemeriksaanAwalByRegistrasi'); ?>",
            method: "GET",
            data: {
                no_registrasi: no_registrasi
            },
            dataType: "JSON",
            success: function(response) {
                if (response.status === 'success' && response.data) {
                    $('#action').val('Edit');
                    $('#submit_button').val('Ubah').text('Ubah');
                    fillPemeriksaanAwalExisting(response.data);
                } else {
                    $('#action').val('Add');
                    $('#submit_button').val('Simpan').text('Simpan');
                }
            },
            error: function() {
                $('#action').val('Add');
            }
        });

        // =============================================
        // AMBIL DATA PEMERIKSAAN PERAWAT
        // =============================================
        $.ajax({
            url: "<?= site_url('pemeriksaanawal/setDataPemeriksaanPerawat'); ?>",
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
                if (response.status === 'success' && response.data) {
                    var pemeriksaanData = response.data;
                    console.log('Data pemeriksaan:', pemeriksaanData);
                    fillPemeriksaanPerawatForm(pemeriksaanData);
                } else {
                    console.log('Data pemeriksaan tidak ditemukan atau error');
                    // resetPemeriksaanPerawatForm();
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

                // resetPemeriksaanPerawatForm();
            }
        });

        // =============================================
        // SET STATUS DAN DATA PASIEN
        // =============================================
        if ($(this).data('status') === 'DT') {
            $('#status').val('Draft');
        } else {
            $('#status').val('New');
        }

        var medrec_id = $(this).data('medrec_id');
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

        $('#patient_no').val(patient_no);
        $('#fullname_tm').html(fullname);
        $('#tgl_pemeriksaan').val(today.toLocaleDateString("en-US"));
        $('#birth_dt_tm').html(convertDateIndo(birth_dt));
        $('#tahun').html(tahun);
        $('#bulan').html(bulan);
        $('#gender_tm').html(gender);
        $('#nama_dokter').html(nama_dokter);
        $('#tujuan_registrasi_desc').html(tujuan_registrasi_desc);
        $('#no_registrasi').html(no_registrasi);
        $('.medrec_id_info').html(patient_no);
        $('.medrec_id').val(patient_no);
        $('#type_pasien').html(type_pasien);
        $('#birth_dt_tmx').html(flag_alergi || '-');
        $(".tab-pane").css("display", "");
        $('#alergi').val(alergi);
        $('.alergi').html(alergi);
        $('#no_kwitansi').val(no_kwitansi);
        $('.no_registrasi').val(no_registrasi);

        // =============================================
        // RESET FORM
        // =============================================
        // Anamnesa
        $('input[name=responden]').prop('checked', false);
        $('#keluhan_utama').val('');
        $('#riwayat_perjalanan_keluhan').val('');
        $('#riwayat_penyakit_sekarang').val('');
        $('#riwayat_penyakit_dahulu').val('');
        $('#riwayat_operasi_pengobatan').val('');
        $('#riwayat_penyakit_keluarga').val('');
        $('#riwayat_lain').val('');

        // Pemeriksaan
        $('#kondisi_umum').val('').trigger('change');
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

        // Diagnosa
        $('#diagnosa_utama').val('');
        $('input[name=klasifikasi_utama]').prop('checked', false);
        $('#diagnosa_sekunder').val('');
        $('input[name=klasifikasi_sekunder]').prop('checked', false);

        // Tindakan
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

        // Rujukan
        $('#summernotet').val('');
        $('#ket_rujukan').val('');
        $('#dokter_rujukan').val('').trigger('change');
        $('#user_rujukan').val('');

        // =============================================
        // SET FORM DENGAN DATA DARI REGISTRASI
        // =============================================
        // Anamnesa
        $('input[name=responden][name*=responden][value=' + ($(this).data('responden') == 'True' ? 1 : 0) + ']').prop('checked', true);
        $('#keluhan_utama').val($(this).data('keluhan_utama'));
        $('#riwayat_perjalanan_keluhan').val($(this).data('riwayat_perjalanan_keluhan'));
        $('#riwayat_penyakit_sekarang').val($(this).data('riwayat_penyakit_sekarang'));
        $('#riwayat_penyakit_dahulu').val($(this).data('riwayat_penyakit_dahulu'));
        $('#riwayat_operasi_pengobatan').val($(this).data('riwayat_operasi_pengobatan'));
        $('#riwayat_penyakit_keluarga').val($(this).data('riwayat_penyakit_keluarga'));
        $('#riwayat_lain').val($(this).data('riwayat_lain'));

        // Pemeriksaan dari data registrasi
        $('#kondisi_umum').val($(this).data('kondisi_umum')).trigger('change');
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

        // Diagnosa
        $('#diagnosa_utama').val($(this).data('diagnosa_utama'));
        $('input[name=klasifikasi_utama]').prop('checked', false);
        $('#diagnosa_sekunder').val($(this).data('diagnosa_sekunder'));
        $('input[name=klasifikasi_sekunder]').prop('checked', false);

        // Tindakan
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

        // Rujukan
        $('#summernotet').val($(this).data('summernotet'));
        $('#ket_rujukan').val($(this).data('ket_rujukan'));
        $('#dokter_rujukan').val($(this).data('dokter_rujukan')).trigger('change');
        $('#user_rujukan').val($(this).data('user_rujukan'));

        // =============================================
        // AMBIL RIWAYAT CARD
        // =============================================
        $.ajax({
            url: "<?= site_url('pemeriksaanawal/fetchAllRiwayatCardByPasien'); ?>",
            method: "GET",
            data: {
                patient_no: patient_no
            },
            success: function(data) {
                $('#viewriwayatcard').html(data);
            }
        });
    });

    function fillPemeriksaanAwalExisting(d) {
        if (!d) return;

        if (d.tinggi_badan) $('#tinggi_badan').val(d.tinggi_badan);
        if (d.berat_badan) $('#berat_badan').val(d.berat_badan);
        if (d.lingkar_pinggang) $('#lingkar_pinggang').val(d.lingkar_pinggang);
        if (d.lingkar_pinggul) $('#lingkar_pinggul').val(d.lingkar_pinggul);
        if (d.lingkar_lengan_atas) $('#muac').val(d.lingkar_lengan_atas);
        $('#tinggi_badan, #berat_badan').trigger('change');
        $('#lingkar_pinggang, #lingkar_pinggul').trigger('change');
        $('#muac').trigger('change');

        if (d.sistolik) $('#sistolik').val(d.sistolik);
        if (d.diastolik) $('#diastolik').val(d.diastolik);
        if (d.nadi) $('#nadi').val(d.nadi);
        if (d.laju_nafas) $('#laju_nafas').val(d.laju_nafas);
        if (d.spo2) $('#spo2').val(d.spo2);
        if (d.suhu) $('#suhu').val(d.suhu);

        if (d.kondisi_umum) $('#kondisi_umum').val(d.kondisi_umum).trigger('change');
        if (d.kesadaran_umum) $('#kesadaran').val(d.kesadaran_umum).trigger('change');
        if (d.skala_nyeri) $('#skrining_nyeri').val(d.skala_nyeri).trigger('change');

        if (d.status_fungsional === 'mandiri') $('#mandiri').prop('checked', true);
        else if (d.status_fungsional === 'perlubantuan') $('#perlu_bantuan').prop('checked', true);
        else if (d.status_fungsional === 'ketergantungantotal') $('#ketergantungan_total').prop('checked', true);
        if (d.status_fungsional_perlubantuan_text) $('#perlu_bantuan_text').val(d.status_fungsional_perlubantuan_text);

        if (d.kebutuhan_edukasi) $('#kebutuhan_edukasi').val(d.kebutuhan_edukasi);
        if (d.keluhan_utama) $('#keluhan_utama').val(d.keluhan_utama);
        if (d.riwayat_kesehatan_pasien) $('#riwayat_kesehatan_pasien').val(d.riwayat_kesehatan_pasien);
        if (d.riwayat_operasi_pengobatan) $('#riwayat_operasi_pengobatan').val(d.riwayat_operasi_pengobatan);

        if (d.kepala_dan_wajah) $('#kepala_dan_wajah').val(d.kepala_dan_wajah);
        if (d.cervical_spin) $('#cervical_spin').val(d.cervical_spin);
        if (d.thorax) $('#thorax').val(d.thorax);
        if (d.abdomen) $('#abdomen').val(d.abdomen);
        if (d.pemeriksaan_neurologis) $('#pemeriksaan_neurologis').val(d.pemeriksaan_neurologis);
        if (d.ekstremitas_muskulosekeletal) $('#ekstremitas_muskulosekeletal').val(d.ekstremitas_muskulosekeletal);
        if (d.status_lokalis) $('#status_lokalis').val(d.status_lokalis);

        if (d.psikososial_dan_spiritual) $('#psikososial_dan_spiritual').val(d.psikososial_dan_spiritual).trigger('change');
        if (d.riwayat_penggunaan_obat) $('#riwayat_penggunaan_obat').val(d.riwayat_penggunaan_obat);

        if (d.status_kehamilan === 'hamil') $('#status_kehamilan_hamil').prop('checked', true);
        else $('#status_kehamilan_tidak').prop('checked', true);
        if (d.status_kehamilan_hpht) $('#status_kehamilan_hpht').val(d.status_kehamilan_hpht);
        if (d.status_kehamilan_gravid) $('#status_kehamilan_gravid').val(d.status_kehamilan_gravid);
        if (d.status_kehamilan_abortus) $('#status_kehamilan_abortus').val(d.status_kehamilan_abortus);

        if (d.pemeriksaan_diagnostik) $('#pemeriksaan_diagnostik').val(d.pemeriksaan_diagnostik);
        if (d.diagnosa_keperawatan) $('#diagnosa_keperawatan').val(d.diagnosa_keperawatan);
    }

    function fillPemeriksaanPerawatForm(data) {
        console.log('Mengisi form dengan data:', data);

        // Anamnesa
        if (data.keluhanUtama) $('#keluhan_utama').val(data.keluhanUtama);
        if (data.riwayatKesehatanPasien) $('#riwayat_kesehatan_pasien').val(data.riwayatKesehatanPasien);
        if (data.riwayatOperasiPengobatan) $('#riwayat_operasi_pengobatan').val(data.riwayatOperasiPengobatan);

        // Antropometri
        if (data.tinggiBadan) $('#tinggi_badan').val(data.tinggiBadan);
        if (data.beratBadan) $('#berat_badan').val(data.beratBadan);
        if (data.lingkarPinggang) $('#lingkar_pinggang').val(data.lingkarPinggang);
        if (data.lingkarPinggul) $('#lingkar_pinggul').val(data.lingkarPinggul);
        if (data.lingkarLenganAtas) $('#muac').val(data.lingkarLenganAtas);
        $('#tinggi_badan, #berat_badan').trigger('change');
        $('#lingkar_pinggang, #lingkar_pinggul').trigger('change');
        $('#muac').trigger('change');

        // Tanda Vital
        if (data.sistolik) $('#sistolik').val(data.sistolik);
        if (data.diastolik) $('#diastolik').val(data.diastolik);
        if (data.nadi) $('#nadi').val(data.nadi);
        if (data.lajuNafas) $('#laju_nafas').val(data.lajuNafas);
        if (data.spo2) $('#spo2').val(data.spo2);
        if (data.suhu) $('#suhu').val(data.suhu);

        // Kondisi Umum
        if (data.kondisiUmum) $('#kondisi_umum').val(data.kondisiUmum).trigger('change');
        if (data.kesadaranUmum) $('#kesadaran').val(data.kesadaranUmum).trigger('change');

        // Status Fungsional
        if (data.statusFungsional) {
            var status = data.statusFungsional.toLowerCase();
            if (status === 'mandiri' || status === '1') {
                $('#mandiri').prop('checked', true);
            } else if (status === 'perlubantuan' || status === '2') {
                $('#perlu_bantuan').prop('checked', true);
            } else if (status === 'ketergantungantotal' || status === '3') {
                $('#ketergantungan_total').prop('checked', true);
            }
        }

        if (data.statusFungsionalPerlubantuan) $('#perlu_bantuan_text').val(data.statusFungsionalPerlubantuan);
        if (data.kebutuhanEdukasi) $('#kebutuhan_edukasi').val(data.kebutuhanEdukasi);

        // Pemeriksaan Fisik
        if (data.kepalaDanWajah) $('#kepala_dan_wajah').val(data.kepalaDanWajah);
        if (data.cervicalSpin) $('#cervical_spin').val(data.cervicalSpin);
        if (data.thorax) $('#thorax').val(data.thorax);
        if (data.abdomen) $('#abdomen').val(data.abdomen);
        if (data.pemeriksaanNeurologis) $('#pemeriksaan_neurologis').val(data.pemeriksaanNeurologis);
        if (data.ekstremitasMuskulosekeletal) $('#ekstremitas_muskulosekeletal').val(data.ekstremitasMuskulosekeletal);
        if (data.statusLokalis) $('#status_lokalis').val(data.statusLokalis);

        if (data.psikososialDanSpiritual) $('#psikososial_dan_spiritual').val(data.psikososialDanSpiritual).trigger('change');
        if (data.riwayatPenggunaanObat) $('#riwayat_penggunaan_obat').val(data.riwayatPenggunaanObat);

        // Skrining Nyeri
        var nyeri = data.skalaNyeri || data.skriningNyeri;
        if (nyeri) $('#skrining_nyeri').val(nyeri).trigger('change');

        // Status Kehamilan
        if (data.statusKehamilan) {
            var kehamilan = data.statusKehamilan.toLowerCase();
            if (kehamilan === 'hamil' || kehamilan === '1') {
                $('#status_kehamilan_hamil').prop('checked', true);
            } else {
                $('#status_kehamilan_tidak').prop('checked', true);
            }
        }
        if (data.statusKehamilanHpht) $('#status_kehamilan_hpht').val(data.statusKehamilanHpht);
        if (data.statusKehamilanGravid) $('#status_kehamilan_gravid').val(data.statusKehamilanGravid);
        if (data.statusKehamilanAbortus) $('#status_kehamilan_abortus').val(data.statusKehamilanAbortus);

        if (data.pemeriksaanDiagnostik) $('#pemeriksaan_diagnostik').val(data.pemeriksaanDiagnostik);
        if (data.diagnosaKeperawatan) $('#diagnosa_keperawatan').val(data.diagnosaKeperawatan);

        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Data pemeriksaan berhasil dimuat',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });
    }

    function resetPemeriksaanPerawatForm() {
        $('#keluhan_utama').val('');
        $('#riwayat_kesehatan_pasien').val('');
        $('#riwayat_operasi_pengobatan').val('');
        $('#tinggi_badan').val('');
        $('#berat_badan').val('');
        $('#lingkar_pinggang').val('');
        $('#lingkar_pinggul').val('');
        $('#muac').val('');
        $('#lingkar_lengan_atas').val('');
        $('#sistolik').val('');
        $('#diastolik').val('');
        $('#nadi').val('');
        $('#laju_nafas').val('');
        $('#spo2').val('');
        $('#suhu').val('');
        $('#bmi').val('');
        $('#whr').val('');
        $('#kondisi_umum').val('').trigger('change');
        $('#kesadaran').val('').trigger('change');
        $('#mandiri').prop('checked', true);
        $('#perlu_bantuan_text').val('');
        $('#kebutuhan_edukasi').val('');
        $('#kepala_dan_wajah').val('');
        $('#cervical_spin').val('');
        $('#thorax').val('');
        $('#abdomen').val('');
        $('#pemeriksaan_neurologis').val('');
        $('#ekstremitas_muskulosekeletal').val('');
        $('#status_lokalis').val('');
        $('#psikososial_dan_spiritual').val('').trigger('change');
        $('#riwayat_penggunaan_obat').val('');
        $('#skrining_nyeri').val('').trigger('change');
        $('#status_kehamilan_tidak').prop('checked', true);
        $('#status_kehamilan_hpht').val('');
        $('#status_kehamilan_gravid').val('');
        $('#status_kehamilan_abortus').val('');
        $('#pemeriksaan_diagnostik').val('');
        $('#diagnosa_keperawatan').val('');
    }

    // =============================================
    // EVENT HANDLER KETERANGAN ALERGI
    // =============================================
    $(document).on('click', '.btn-keterangan-alergi', function() {
        currentKeteranganRow = $(this).data('row');
        var keterangan = $(this).data('keterangan') || '';
        $('#keterangan_alergi_modal').val(keterangan);
        $('#modalKeteranganAlergi').modal('show');
    });

    $(document).on('click', '#simpanKeteranganAlergi', function() {
        if (currentKeteranganRow !== null) {
            var keterangan = $('#keterangan_alergi_modal').val();
            $('#keterangan_alergi_hidden_' + currentKeteranganRow).val(keterangan);

            var btn = $('.btn-keterangan-alergi[data-row="' + currentKeteranganRow + '"]');
            if (keterangan.trim() !== '') {
                btn.html('<i class="fas fa-check-circle text-success"></i>');
                btn.removeClass('btn-info').addClass('btn-success');
                btn.attr('title', 'Klik untuk mengubah keterangan');
            } else {
                btn.html('<i class="fas fa-pen"></i>');
                btn.removeClass('btn-success').addClass('btn-info');
                btn.attr('title', 'Tambah keterangan');
            }
            btn.data('keterangan', keterangan);
            $('#modalKeteranganAlergi').modal('hide');
            currentKeteranganRow = null;
        }
    });

    $(document).on('hidden.bs.modal', '#modalKeteranganAlergi', function() {
        currentKeteranganRow = null;
    });

    // =============================================
    // FUNGSI TAMBAH ALERGI
    // =============================================
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
            '</td>' +
            '<td>' +
            '<input type="hidden" name="alergi[' + i + '][keterangan]" id="keterangan_alergi_hidden_' + i + '" value="">' +
            '<button type="button" class="btn btn-sm btn-info btn-keterangan-alergi" data-row="' + i + '" data-keterangan="">' +
            '<i class="fas fa-pen"></i>' +
            '</button>' +
            '<input type="hidden" name="alergi[' + i + '][alergi_no]" value="">' +
            '</td>' +
            '<td>' +
            '<button type="button" name="remove" id="' + i + '" ' +
            'class="btn btn-sm btn-danger btn_remove_alergi" ' +
            'data-patient_no="' + patient_no + '" ' +
            'data-alergi_no="">' +
            '<i class="fas fa-trash"></i>' +
            '</button>' +
            '</td>' +
            '</tr>'
        );

        initSelect2Alergi(i, null, [], [], [], []);
        $('#alergi_array_length').val(i + 1);
    });

    // =============================================
    // EVENT HAPUS ALERGI
    // =============================================
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
                    });
                }
            })
        }
    });

    // =============================================
    // SUBMIT FORM
    // =============================================
    $('#data_form').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
            url: "<?= site_url('pemeriksaanawal/action'); ?>",
            method: "POST",
            data: $(this).serialize(),
            dataType: "JSON",
            beforeSend: function() {
                $('#submit_button').prop('disabled', true);
                $('#submit_button').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function() {
                $('#submit_button').prop('disabled', false);
                $('#submit_button').html('Simpan');
            },
            success: function(response) {
                if (response.error) {
                    $.each(response.error, function(key, value) {
                        $('#' + key).addClass('is-invalid');
                        $('.error' + key.charAt(0).toUpperCase() + key.slice(1)).html(value);
                    });
                } else {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: response.success,
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    });
                    $('.is-invalid').removeClass('is-invalid');
                    $('[class^="error"]').html('');
                    tregistrasi();
                    $('#action').val('Edit');
                    $('#submit_button').val('Ubah').text('Ubah');
                }
            }
        });
    });

    function convertDateIndo(date) {
        var d_arr = date.split("/");
        var fromDate = d_arr[1] + '/' + d_arr[0] + '/' + d_arr[2];
        dateNew = fromDate.split(' ')[0];
        return dateNew;
    }

    // BMI, WHR, MUAC calculations
    $(document).on('change keyup', '#tinggi_badan, #berat_badan', function() {
        var tinggi = $('#tinggi_badan').val();
        var berat = $('#berat_badan').val();
        var bmi = berat / ((tinggi / 100) * (tinggi / 100));
        $('#bmi').val(Math.round(bmi * 100) / 100);
    });

    $(document).on('change keyup', '#lingkar_pinggang , #lingkar_pinggul', function() {
        var lingkar_pinggang = $('#lingkar_pinggang').val();
        var lingkar_pinggul = $('#lingkar_pinggul').val();
        var whr = lingkar_pinggang / lingkar_pinggul;
        $('#whr').val(whr);
    });

    $(document).on('change keyup', '#muac', function() {
        var muac = $('#muac').val();
        var lla = '';
        if (muac < 115) {
            lla = 'Kekurangan gizi parah';
        } else if (muac >= 115 && muac <= 125) {
            lla = 'Kekurangan gizi sedang';
        } else if (muac > 125) {
            lla = 'Gizi cukup';
        } else {
            lla = '';
        }
        $('#lingkar_lengan_atas').val(lla);
    });

    $(document).ready(function() {
        $('#summernotet').summernote({
            height: 250
        });
        $('#summernotet2').summernote({
            height: 250
        });
    });
</script>

<?= $this->endSection('script'); ?>