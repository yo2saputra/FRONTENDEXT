<!-- view tab-one -->

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
                                            <div id="overlay-rujukan">
                                                <div class="w-100 d-flex justify-content-center align-items-center">
                                                    <div class="spinner"></div>
                                                </div>
                                            </div>
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
                                        <button id="draft_button_all" class="btn btn-warning" style="display:none;">Simpan Sebagai Draft</button> <!-- style="display:none;" -->
                                        <button id="submit_button_all" class="btn btn-primary ml-2">SIMPAN</button>
                                    </div>
                                </div>
                                <!-- /.col-->
                            </div>
                            <!-- ./row -->
                        </div>
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
                                                                            <input type="text" name="suhu" class="form-control" placeholder="" id="suhu" min="1" tabindex="18">
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
                                                                    <!-- <select class="form-control form-control-sm select2 titi" name="name1" id="titikKeluhan" style="width: 100%; heigh:100%;" tabindex="22">
                                                                        <option selected>-- Select --</option>
                                                                        <option value="Head">Head</option>
                                                                        <option value="Breast">Breast</option>
                                                                        <option value="Dental">Dental</option>
                                                                        <option value="RectumAnalCanal">Rectum Anal Canal</option>
                                                                        <option value="Wajah">Wajah</option>
                                                                        <option value="Wajah2">Wajah 2</option>
                                                                        <option value="Blank">Blank</option>
                                                                    </select> -->
                                                                    <select class="form-control form-control-sm select2 titi" name="name1" id="titikKeluhan" style="width: 100%; heigh:100%;" tabindex="22">
                                                                        <option selected value="">-- Select --</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="card card-info">
                                                                    <div class="card-header">

                                                                        <h3 class="card-title">
                                                                            <button type="button" class="btn btn-tool refreshTitikKeluhan" data-card-widget="" data-no_registrasi="REG240600207"><i id="refreshBtn" class="fas fa-sync-alt"></i>
                                                                            </button>

                                                                        </h3>
                                                                        <div class="card-tools" style="margin: 0rem 0rem 0rem !important;">
                                                                            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>

                                                                    <!-- <div class="card-body" style="height: 62.5vh; overflow-x: scroll;">
                                                                        <div id="printcard"></div>
                                                                    </div> -->
                                                                    <div class="card-body" style="height: 47vh; overflow-x: auto; overflow-y: hidden; white-space: nowrap; padding: 0;">
                                                                        <div id="printcard" style="display: flex; flex-direction: row; height: 100%;"></div>
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