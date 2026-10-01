<!-- view tab-two -->

<div class="row">
    <div class="col-12">
        <h5>RIWAYAT PEMERIKSAAN</h5>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-info">
                    <div class="card-body" style="height: 38vh; overflow-y: scroll;">
                        <span id="viewriwayatcard"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div id="overlay-riwayat-pemeriksaan">
            <div class="w-100 d-flex justify-content-center align-items-center">
                <div class="spinner"></div>
            </div>
        </div>
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
                                                            <th>Komponen</th>
                                                            <th>Reaksi</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="r_dynamic_alergi_body">
                                                        <!-- rows di-append via JS -->
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