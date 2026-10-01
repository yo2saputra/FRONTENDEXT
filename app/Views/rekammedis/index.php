<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>

<style>
    /* set width action button crud */
    .btn-fix-w {
        width: 50px;
    }

    /* set font size dropdown select2 */
    select.form-control-sm~.select2-container--default {
        font-size: .720rem !important;
    }

    /* set font size input form */
    .form-control-sm {
        font-size: .720rem !important;
    }
</style>


<?= $this->endSection('style'); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Header content -->
    <section class="content-header">
        <div class="container-fluid">
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-3">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-hospital-user"></i>
                                Info Pasien
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool"><i class="fas fa-info-circle"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <dl class="row">
                                <dt class="col-md-4">No. RM.</dt>
                                <dd class="col-md-8">23092000</dd>
                                <dt class="col-md-4">Nama</dt>
                                <dd class="col-md-8">Tn. Sutan Takdir Alisyahbana Putra</dd>
                                <dt class="col-md-4">Jenis K.</dt>
                                <dd class="col-md-8">Laki-laki</dd>
                                <dt class="col-md-4">Usia</dt>
                                <dd class="col-md-8">40 - 5 - 20</dd>
                                <dt class="col-md-4">G. Darah</dt>
                                <dd class="col-md-8">AB</dd>
                            </dl>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-sm btn-primary float-sm-right">Cari Pasien</button>
                        </div>
                    </div>

                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-calendar"></i>
                                Tanggal Berobat
                            </h3>
                        </div>
                        <div class="card-body" style="height: 26vh; overflow-y: scroll;">
                            <table class="table table-sm table-bordered">
                                <tbody>
                                    <tr>
                                        <th>
                                            Tanggal
                                        </th>
                                        <th>
                                            Layanan
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>
                                            25-05-2002
                                        </td>
                                        <td>
                                            Rawat Jalan
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            14-03-2010
                                        </td>
                                        <td>
                                            Rawat Jalan
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            05-04-2020
                                        </td>
                                        <td>
                                            Rawat Jalan
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            10-08-2022
                                        </td>
                                        <td>
                                            Rawat Jalan
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
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
                                                        <dd>Lorem ipsum dolor Lorem ipsum dolor Lorem ipsum dolor Lorem ipsum dolor </dd>
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
                                                            <dd>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Magni laudantium ad
                                                                ipsam
                                                                ut alias quasi necessitatibus, illo exercitationem laborum cum sequi accusantium
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
                                            <img src="/dist/img/man_anatomy.png" height="250px" alt="" class="img-fluid">
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

            <!-- ------ -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?= $this->endSection('content'); ?>

<?= $this->section('script'); ?>

<!-- set menu name by active-menu -->
<script>
    $('#active-menu').html($('p#active-menu').html()); // set top navbar
    $(document).prop("title", $('p#active-menu').html()); // set title
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
    });

    function dokter() {
        $.ajax({
            method: "get",
            url: "<?= site_url('patient/fetchAll'); ?>",
            success: function(data) {
                $('#viewdata').html(data);
            }
        });
    }
    $(document).ready(function() {

        dokter();
    });

    function obat() {
        $.ajax({
            method: "get",
            url: "<?= site_url('patient/fetchAll'); ?>",
            success: function(data) {
                $('#viewdata').html(data);
            }
        });
    }
    $(document).ready(function() {

        obat();
    });

    function rehab() {
        $.ajax({
            method: "get",
            url: "<?= site_url('patient/fetchAll'); ?>",
            success: function(data) {
                $('#viewdata').html(data);
            }
        });
    }
    $(document).ready(function() {

        rehab();
    });
</script>

<?= $this->endSection('script'); ?>