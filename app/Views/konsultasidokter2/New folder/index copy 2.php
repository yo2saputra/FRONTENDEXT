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
                                <div class="col-md-4">
                                    <dl>
                                        <dt>Nama</dt>
                                        <dd id="fullname">&nbsp;</dd>
                                    </dl>
                                </div>
                                <div class="col-md-2">
                                    <dl>
                                        <dt>Jenis Kelamin</dt>
                                        <dd id="gender">&nbsp;</dd>
                                    </dl>
                                </div>
                                <div class="col-md-2">
                                    <dl>
                                        <dt>Tanggal Lahir</dt>
                                        <dd id="birth_dt">&nbsp;</dd>
                                    </dl>
                                </div>
                                <div class="col-md-2">
                                    <dl>
                                        <dt>Usia</dt>
                                        <dd id="usia">&nbsp;</dd>
                                    </dl>
                                </div>
                                <div class="col-md-2">
                                    <dl>
                                        <dt>Nomor HP</dt>
                                        <dd id="mobile_no">&nbsp;</dd>
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
                                            <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Konsultasi</a>
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
                                                <div class="mb-3 row">
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
                                                <div class="mb-3 row">
                                                    <label for="" class="col-sm-2 col-form-label">TGL. KUNJUNGAN</label>
                                                    <div class="col-sm-4">
                                                        <div class="input-group date birth_dt" data-date-format="mm/dd/yyyy">
                                                            <input type="text" class="form-control form-control-sm datepicker" placeholder="mm/dd/yyyy" id="birth_dt" name="birth_dt" autocomplete="off">
                                                            <div class="input-group-append" data-target="#birth_dt" data-toggle="birth_dt">
                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                            </div>
                                                        </div>
                                                        <span class="error invalid-feedback errorBirth_dt">
                                                        </span>
                                                    </div>
                                                    <label for="" class="col-sm-2 col-form-label">NAMA PASIEN</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control form-control-sm" placeholder="" id="birthplace" name="birthplace" autocomplete="off">
                                                        <span class="error invalid-feedback errorBirthplace">
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="" class="col-sm-2 col-form-label">JENIS KUNJUNGAN</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control form-control-sm" placeholder="" id="birthplace" name="birthplace" autocomplete="off">
                                                        <span class="error invalid-feedback errorBirthplace">
                                                        </span>
                                                    </div>
                                                    <label for="" class="col-sm-2 col-form-label">JENIS KELAMIN</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control form-control-sm" placeholder="" id="birthplace" name="birthplace" autocomplete="off">
                                                        <span class="error invalid-feedback errorBirthplace">
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="" class="col-sm-2 col-form-label">JENIS PASIEN</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control form-control-sm" placeholder="" id="birthplace" name="birthplace" autocomplete="off">
                                                        <span class="error invalid-feedback errorBirthplace">
                                                        </span>
                                                    </div>
                                                    <label for="" class="col-sm-2 col-form-label">USIA</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control form-control-sm" placeholder="" id="birthplace" name="birthplace" autocomplete="off">
                                                        <span class="error invalid-feedback errorBirthplace">
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="" class="col-sm-2 col-form-label">STATUS REG</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control form-control-sm" placeholder="" id="birthplace" name="birthplace" autocomplete="off">
                                                        <span class="error invalid-feedback errorBirthplace">
                                                        </span>
                                                    </div>
                                                    <label for="" class="col-sm-2 col-form-label"></label>
                                                    <div class="col-sm-4">

                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="mb-3 row">
                                                    <label for="" class="col-sm-2 col-form-label">KELUHAN</label>
                                                    <div class="col-sm-4">
                                                        <textarea class="form-control form-control-sm" rows="3" placeholder="..." id="addr" name="addr" autocomplete="off"></textarea>
                                                        <span class="error invalid-feedback errorAddr">
                                                        </span>
                                                    </div>
                                                    <label for="" class="col-sm-2 col-form-label">DIAGNOSA / ANAMNESA</label>
                                                    <div class="col-sm-4">
                                                        <textarea class="form-control form-control-sm" rows="3" placeholder="..." id="addr" name="addr" autocomplete="off"></textarea>
                                                        <span class="error invalid-feedback errorAddr">
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="" class="col-sm-2 col-form-label">DI RUJUK</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control form-control-sm" placeholder="" id="birthplace" name="birthplace" autocomplete="off">
                                                        <span class="error invalid-feedback errorBirthplace">
                                                        </span>
                                                    </div>
                                                    <label for="" class="col-sm-2 col-form-label"></label>
                                                    <div class="col-sm-4">

                                                    </div>
                                                </div>
                                                <div class="mb-5 row">
                                                    <div class="col-sm text-center">
                                                        <button type="button" class="btn btn-sm btn-primary">RESEP</button><button type="button" class="btn btn-sm btn-primary ml-2">TITIK KELUHAN</button><button type="button" class="btn btn-sm btn-primary ml-2">SIMPAN</button>
                                                    </div>
                                                </div>
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
                                                            <table id="example1" class="table table-sm table-striped">
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

                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Detail Rekam Medis   -->
                                                <div class="col-md-12">
                                                    <div class="card card-info">
                                                        <div class="card-header">
                                                            <h3 class="card-title">
                                                                <i class="fas fa-folder"></i>
                                                                Rekam Medis : 25-05-2022
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
                                                                                        <dd>56 - 5 - 10</dd>
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
                                                                                        <dd>Lorem ipsum dolor Lorem ipsum dolor Lorem ipsum dolor Lorem ipsum
                                                                                            dolor </dd>
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
                                                                            <img src="/dist/img/man_anatomy.png" class="img-fluid" height="250px" alt="">
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
    function tregistrasi() {
        $.ajax({
            method: "get",
            url: "<?= site_url('konsultasidokter/fetchAll'); ?>",
            success: function(data) {
                $('#viewdata').html(data);
            }
        });
    }
    $(document).ready(function() {

        tregistrasi();
    });

    $(document).on('click', '.pilih', function() {

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

        var fullname = $(this).data('fullname');
        var birth_dt = $(this).data('birth_dt');
        var tahun = $(this).data('tahun');
        var bulan = $(this).data('bulan');
        var hari = $(this).data('hari');
        var gender = $(this).data('gender');
        var mobile_no = $(this).data('mobile_no');

        $('#fullname').html(fullname);
        $('#birth_dt').html(convertDateIndo(birth_dt));
        $('#usia').html('<b>' + tahun + '</b> Tahun, <b>' + bulan + '</b> Bulan, <b>' + hari + '</b> Hari');
        $('#gender').html(gender);
        $('#mobile_no').html(mobile_no);

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

<?= $this->endSection('script'); ?>