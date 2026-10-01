<?= $this->extend('clinic_template'); ?>

    <?= $this->section('style'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css">
    <style>
        .btn-fix-w { width: 60px; padding-top: 0px; padding-bottom: 0px; }
        .control-sidebar { color: black; }
        .list-group { max-height: 80vh; margin-bottom: 10px; overflow-y: scroll; -webkit-overflow-scrolling: touch; }
        .content-header-fixed {
            -webkit-transition: -webkit-transform .3s ease-in-out, margin .3s ease-in-out;
            transition: transform .3s ease-in-out, margin .3s ease-in-out;
            position: fixed; color: #fff; margin-left: 245px;
            left: 0; right: 0; padding: 5px; z-index: 800;
        }
        @media (min-width:768px) {
            .contents { margin-top: 1.5rem; }
            .sidebar-collapse .content-header-fixed { margin-left: 0px; }
            .sidebar-mini.sidebar-collapse .content-header-fixed { margin-left: 70px !important; z-index: 840; }
            #melayang { padding-top: 180px; }
        }
        @media (max-width:767px) {
            .contents { margin-top: 5.5rem; }
            .sidebar-collapse .content-header-fixed { margin-left: 0px; }
            .sidebar-mini.sidebar-collapse .content-header-fixed { margin-left: 0px !important; z-index: 840; }
            .content-header-fixed { position: relative !important; margin-left: 0 !important; }
            #melayang { padding-top: 0 !important; display: block !important; }
        }
        .caption_text { font-size: 0.6rem; }
        .content_text  { font-size: 0.8rem; }
        .form-control-sm { font-size: .720rem !important; }
        .label-unit { font-size: 0.72rem; color: #888; font-weight: normal; }

        #viewdataobservasi { background-color: #fff !important; }
        #viewdataobservasi table { background-color: #fff !important; color: #333 !important; table-layout: fixed; width: 100%; }
        #viewdataobservasi table thead tr th { background-color: #ffffff !important; color: #333 !important; }
        #viewdataobservasi table tbody tr td { background-color: #fff !important; color: #333 !important; word-break: break-word; overflow-wrap: break-word; }
        #viewdataobservasi table tbody tr:nth-child(even) td { background-color: #fafafa !important; }

        .btn-input-section { min-width: 120px; }
        .section-divider {
            font-weight: bold; font-size: 0.8rem;
            background: #e9ecef; padding: 4px 8px;
            border-radius: 4px; margin-bottom: 10px; margin-top: 6px;
        }

        .btn-nav-bar {
            background-color: #343a40;
            border-radius: 4px;
            padding: 4px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 2px;
        }

        body:not(.dark-mode) .btn-nav-bar {
            background-color: #e9ecef;
        }
        body:not(.dark-mode) .btn-nav-bar .btn-nav-dark {
            color: #343a40 !important;
        }
        body:not(.dark-mode) .btn-nav-bar .btn-nav-dark:hover:not(:disabled) {
            background-color: rgba(0,0,0,0.08);
            color: #000000 !important;
            border-left-color: #007bff;
            text-decoration: none;
        }
        body:not(.dark-mode) .btn-nav-bar .btn-nav-dark:disabled,
        body:not(.dark-mode) .btn-nav-bar .btn-nav-dark[disabled] {
            opacity: 1 !important;
            color: #6c757d !important;
            cursor: not-allowed;
            pointer-events: none;
        }
        body:not(.dark-mode) .btn-nav-bar .btn-nav-dark.btn-nav-active {
            color: #d97706 !important;
            border-left-color: #d97706;
            background-color: rgba(217,119,6,0.1);
        }

        body.dark-mode .btn-nav-bar {
            background-color: #343a40;
        }
        body.dark-mode .btn-nav-bar .btn-nav-dark {
            color: #c2c7d0 !important;
        }
        body.dark-mode .btn-nav-bar .btn-nav-dark:hover:not(:disabled) {
            background-color: rgba(255,255,255,0.1);
            color: #ffffff !important;
            border-left-color: #3b8beb;
            text-decoration: none;
        }
        body.dark-mode .btn-nav-bar .btn-nav-dark:disabled,
        body.dark-mode .btn-nav-bar .btn-nav-dark[disabled] {
            opacity: 1 !important;
            color: #6c757d !important;
            cursor: not-allowed;
            pointer-events: none;
        }
        body.dark-mode .btn-nav-bar .btn-nav-dark.btn-nav-active {
            color: #ffc107 !important;
            border-left-color: #ffc107;
            background-color: rgba(255,193,7,0.08);
        }

        .btn-nav-dark {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background-color: transparent;
            border: none;
            border-left: 3px solid transparent;
            border-radius: 0;
            padding: 6px 14px;
            font-size: 0.82rem;
            font-weight: 500;
            transition: background 0.18s, border-color 0.18s, color 0.18s;
            white-space: nowrap;
        }
        .btn-nav-dark i {
            font-size: 0.8rem;
            width: 14px;
            text-align: center;
        }

    </style>
    <?= $this->endSection('style'); ?>

    <?= $this->section('controlsidebaricon'); ?>
    <li class="nav-item">
        <a class="nav-link text-md" data-widget="control-sidebar" data-slide="true" href="#" role="button" id="toggle-sidebar-pasien">
            <i class="fas fa-wheelchair"></i>
        </a>
    </li>
    <?= $this->endSection('controlsidebaricon'); ?>

    <?= $this->section('content'); ?>
    <div class="content-wrapper">

        <input type="hidden" id="f_no_registrasi" value="">
        <input type="hidden" id="f_medrec_id"     value="">

        <section class="content-header-fixed" id="header-identitas-pasien" style="display:none;">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card bg-info" style="padding:2px;">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 col-6"><dl><dt class="caption_text">Nomor Registrasi</dt><span id="no_registrasi_display" class="content_text">&nbsp;</span></dl></div>
                                    <div class="col-md-3 col-6"><dl><dt class="caption_text">No. Rekam Medis</dt><span id="medrec_id_info" class="content_text">&nbsp;</span></dl></div>
                                    <div class="col-md-3 col-6"><dl><dt class="caption_text">Nama Pasien</dt><span id="fullname_tm" class="content_text">&nbsp;</span></dl></div>
                                    <div class="col-md-3 col-6"><dl><dt class="caption_text">Jenis Kelamin - Tanggal Lahir - Usia</dt><span class="content_text"><span id="gender_tm">&nbsp;</span> - <span id="birth_dt_tm">&nbsp;</span> - <span id="tahun">&nbsp;</span> Th,<span id="bulan">&nbsp;</span> Bln.</span></dl></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 col-6"><dl><dt class="caption_text">Poliklinik</dt><span id="tujuan_registrasi_desc" class="content_text">&nbsp;</span></dl></div>
                                    <div class="col-md-3 col-6"><dl><dt class="caption_text">Dokter</dt><span id="nama_dokter" class="content_text">&nbsp;</span></dl></div>
                                    <div class="col-md-3 col-6"><dl><dt class="caption_text">Jaminan</dt><span id="type_pasien" class="content_text">&nbsp;</span></dl></div>
                                    <div class="col-md-3 col-6"><dl><dt class="caption_text">Riwayat Alergi</dt><span id="riwayat_alergi_display" class="content_text">&nbsp;</span></dl></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="content" id="melayang" style="display:none;">
            <div class="container-fluid">
                <div class="row contents">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-sm-12 d-flex flex-wrap align-items-center btn-nav-bar">
                                        <button type="button" class="btn btn-nav-dark btn-input-section" id="btn_open_data_umum" disabled
                                            data-toggle="modal" data-target="#modalAddDataUmum">
                                            <i class="fas fa-file-medical"></i> Data Umum
                                        </button>
                                        <button type="button" class="btn btn-nav-dark btn-input-section" id="btn_open_kpt" disabled
                                            data-toggle="modal" data-target="#modalAddKpt">
                                            <i class="fas fa-heartbeat"></i> Pra Tindakan
                                        </button>
                                        <button type="button" class="btn btn-nav-dark btn-input-section" id="btn_open_kit" disabled
                                            data-toggle="modal" data-target="#modalAddKit">
                                            <i class="fas fa-procedures"></i> Intra Tindakan
                                        </button>
                                        <button type="button" class="btn btn-nav-dark btn-input-section" id="btn_open_kpot" disabled
                                            data-toggle="modal" data-target="#modalAddKpot">
                                            <i class="fas fa-notes-medical"></i> Post Tindakan
                                        </button>
                                        <button type="button" class="btn btn-nav-dark btn-input-section" id="btn_open_catatan" disabled
                                            data-toggle="modal" data-target="#modalAddCatatan">
                                            <i class="fas fa-comment-medical"></i> Catatan
                                        </button>
                                        <div class="ml-auto d-flex" style="gap:6px; padding-right:4px;">
                                            <button type="button" id="btn_refresh" class="btn btn-sm btn-secondary">
                                                <i class="fas fa-sync-alt"></i> Refresh
                                            </button>
                                            <button type="button" id="btn_cetak" class="btn btn-sm btn-danger">
                                                <i class="fas fa-print"></i> Cetak PDF
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive" id="viewdataobservasi">
                                    <p class="text-muted text-center">Pilih pasien untuk melihat data observasi.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== MODAL ADD: Data Umum ===== -->
        <div class="modal fade" id="modalAddDataUmum" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title"><i class="fas fa-file-medical mr-2"></i>Input Data Umum</h5>
                        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <form id="form_data_umum" autocomplete="off">
                        <input type="hidden" name="no_registrasi" class="sync-no-registrasi">
                        <input type="hidden" name="medrec_id"     class="sync-medrec-id">
                        <input type="hidden" name="action"        value="Add">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="mb-3 row">
                                        <label class="col-sm-4 col-form-label">Diagnosis Medis</label>
                                        <div class="col-sm-8"><input type="text" class="form-control form-control-sm" name="diagnosis_medis" placeholder="Masukkan diagnosis medis"></div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-4 col-form-label">Tindakan</label>
                                        <div class="col-sm-8"><input type="text" class="form-control form-control-sm" name="tindakan" placeholder="Masukkan tindakan"></div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-4 col-form-label">Dokter (otomatis)</label>
                                        <div class="col-sm-8"><input type="text" class="form-control form-control-sm bg-light" value="<?= (!empty($session_is_dokter)) ? esc($session_emp_nm ?? '') : '(diisi otomatis saat dokter login)' ?>" readonly></div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-4 col-form-label">Perawat (otomatis)</label>
                                        <div class="col-sm-8"><input type="text" class="form-control form-control-sm bg-light" value="<?= empty($session_is_dokter) ? esc($session_emp_nm ?? '') : '(diisi otomatis saat perawat login)' ?>" readonly></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-add-submit"><i class="fas fa-save mr-1"></i> Simpan</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- ===== MODAL ADD: Pra Tindakan ===== -->
        <div class="modal fade" id="modalAddKpt" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title"><i class="fas fa-heartbeat mr-2"></i>Input Pra Tindakan</h5>
                        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <form id="form_kpt" autocomplete="off">
                        <input type="hidden" name="no_registrasi" class="sync-no-registrasi">
                        <input type="hidden" name="medrec_id"     class="sync-medrec-id">
                        <input type="hidden" name="action"        value="Add">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="mb-3 row"><label class="col-sm-4 col-form-label">Keadaan Umum</label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" name="keadaan_umum_kpt" placeholder="Cth: Baik / Sedang / Lemah"></div></div>
                                    <div class="mb-3 row"><label class="col-sm-4 col-form-label">Tekanan Darah <span class="label-unit">(mmHg)</span></label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" name="tekanan_darah_kpt" placeholder="Cth: 120/80"></div></div>
                                    <div class="mb-3 row"><label class="col-sm-4 col-form-label">Suhu <span class="label-unit">(°C)</span></label><div class="col-sm-8"><input type="number" step="0.1" class="form-control form-control-sm" name="suhu_kpt" placeholder="Cth: 36.5"></div></div>
                                    <div class="mb-3 row"><label class="col-sm-4 col-form-label">Nadi <span class="label-unit">(x/mnt)</span></label><div class="col-sm-8"><input type="number" class="form-control form-control-sm" name="nadi_kpt" placeholder="Cth: 80"></div></div>
                                    <div class="mb-3 row"><label class="col-sm-4 col-form-label">RR <span class="label-unit">(x/mnt)</span></label><div class="col-sm-8"><input type="number" class="form-control form-control-sm" name="rr_kpt" placeholder="Cth: 20"></div></div>
                                    <div class="mb-3 row"><label class="col-sm-4 col-form-label">SpO2 <span class="label-unit">(%)</span></label><div class="col-sm-8"><input type="number" class="form-control form-control-sm" name="spo2_kpt" placeholder="Cth: 98"></div></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-add-submit"><i class="fas fa-save mr-1"></i> Simpan</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- ===== MODAL ADD: Intra Tindakan ===== -->
        <div class="modal fade" id="modalAddKit" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title"><i class="fas fa-procedures mr-2"></i>Input Intra Tindakan</h5>
                        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <form id="form_kit" autocomplete="off">
                        <input type="hidden" name="no_registrasi" class="sync-no-registrasi">
                        <input type="hidden" name="medrec_id"     class="sync-medrec-id">
                        <input type="hidden" name="action"        value="Add">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3 row"><label class="col-sm-4 col-form-label">Keadaan Umum</label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" name="keadaan_umum_kit" placeholder="Cth: Baik / Sedang / Lemah"></div></div>
                                    <div class="mb-3 row"><label class="col-sm-4 col-form-label">Dokter</label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" name="dokter_kit" placeholder="Nama dokter"></div></div>
                                    <div class="mb-3 row"><label class="col-sm-4 col-form-label">Obat Anestesi Lokal</label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" name="obat_anestesi_lokal_kit" placeholder="Nama obat"></div></div>
                                    <div class="mb-3 row"><label class="col-sm-4 col-form-label">Dosis Obat</label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" name="dosis_obat_kit" placeholder="Cth: 2 mg"></div></div>
                                    <div class="mb-3 row"><label class="col-sm-4 col-form-label">Rute Obat</label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" name="rute_obat_kit" placeholder="IV / SC / IM / Topikal"></div></div>
                                    <div class="mb-3 row"><label class="col-sm-4 col-form-label">Jam Mulai</label><div class="col-sm-8"><input type="time" class="form-control form-control-sm" name="jam_mulai_kit"></div></div>
                                    <div class="mb-3 row"><label class="col-sm-4 col-form-label">Jam Selesai</label><div class="col-sm-8"><input type="time" class="form-control form-control-sm" name="jam_selesai_kit"></div></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3 row"><label class="col-sm-4 col-form-label">Tekanan Darah <span class="label-unit">(mmHg)</span></label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" name="tekanan_darah_kit" placeholder="Cth: 120/80"></div></div>
                                    <div class="mb-3 row"><label class="col-sm-4 col-form-label">Suhu <span class="label-unit">(°C)</span></label><div class="col-sm-8"><input type="number" step="0.1" class="form-control form-control-sm" name="suhu_kit" placeholder="Cth: 36.5"></div></div>
                                    <div class="mb-3 row"><label class="col-sm-4 col-form-label">Nadi <span class="label-unit">(x/mnt)</span></label><div class="col-sm-8"><input type="number" class="form-control form-control-sm" name="nadi_kit" placeholder="Cth: 80"></div></div>
                                    <div class="mb-3 row"><label class="col-sm-4 col-form-label">RR <span class="label-unit">(x/mnt)</span></label><div class="col-sm-8"><input type="number" class="form-control form-control-sm" name="rr_kit" placeholder="Cth: 20"></div></div>
                                    <div class="mb-3 row"><label class="col-sm-4 col-form-label">SpO2 <span class="label-unit">(%)</span></label><div class="col-sm-8"><input type="number" class="form-control form-control-sm" name="spo2_kit" placeholder="Cth: 98"></div></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-add-submit"><i class="fas fa-save mr-1"></i> Simpan</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- ===== MODAL ADD: Post Tindakan ===== -->
        <div class="modal fade" id="modalAddKpot" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title"><i class="fas fa-notes-medical mr-2"></i>Input Post Tindakan</h5>
                        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <form id="form_kpot" autocomplete="off">
                        <input type="hidden" name="no_registrasi" class="sync-no-registrasi">
                        <input type="hidden" name="medrec_id"     class="sync-medrec-id">
                        <input type="hidden" name="action"        value="Add">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="mb-3 row"><label class="col-sm-4 col-form-label">Keadaan Umum</label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" name="keadaan_umum_kpot" placeholder="Cth: Baik / Sedang / Lemah"></div></div>
                                    <div class="mb-3 row"><label class="col-sm-4 col-form-label">Tekanan Darah <span class="label-unit">(mmHg)</span></label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" name="tekanan_darah_kpot" placeholder="Cth: 120/80"></div></div>
                                    <div class="mb-3 row"><label class="col-sm-4 col-form-label">Suhu <span class="label-unit">(°C)</span></label><div class="col-sm-8"><input type="number" step="0.1" class="form-control form-control-sm" name="suhu_kpot" placeholder="Cth: 36.5"></div></div>
                                    <div class="mb-3 row"><label class="col-sm-4 col-form-label">Nadi <span class="label-unit">(x/mnt)</span></label><div class="col-sm-8"><input type="number" class="form-control form-control-sm" name="nadi_kpot" placeholder="Cth: 80"></div></div>
                                    <div class="mb-3 row"><label class="col-sm-4 col-form-label">RR <span class="label-unit">(x/mnt)</span></label><div class="col-sm-8"><input type="number" class="form-control form-control-sm" name="rr_kpot" placeholder="Cth: 20"></div></div>
                                    <div class="mb-3 row"><label class="col-sm-4 col-form-label">SpO2 <span class="label-unit">(%)</span></label><div class="col-sm-8"><input type="number" class="form-control form-control-sm" name="spo2_kpot" placeholder="Cth: 98"></div></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-add-submit"><i class="fas fa-save mr-1"></i> Simpan</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- ===== MODAL ADD: Catatan ===== -->
        <div class="modal fade" id="modalAddCatatan" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title"><i class="fas fa-comment-medical mr-2"></i>Input Catatan</h5>
                        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <form id="form_catatan" autocomplete="off">
                        <input type="hidden" name="no_registrasi" class="sync-no-registrasi">
                        <input type="hidden" name="medrec_id"     class="sync-medrec-id">
                        <input type="hidden" name="action"        value="Add">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="mb-3 row">
                                        <label class="col-sm-4 col-form-label">Catatan</label>
                                        <div class="col-sm-8"><textarea class="form-control form-control-sm" name="catatan" rows="6" placeholder="Catatan tambahan"></textarea></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-add-submit"><i class="fas fa-save mr-1"></i> Simpan</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- ===== MODAL EDIT — pola discharge (section toggle, no tabs) ===== -->
        <div class="modal fade" id="modalEditObservasi" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title"><i class="fas fa-edit mr-2"></i>Ubah Data Observasi</h5>
                        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <form id="edit_form" autocomplete="off">
                        <input type="hidden" id="edit_hidden_obs_id" name="hidden_obs_id">
                        <input type="hidden" id="edit_no_registrasi" name="no_registrasi" value="">
                        <input type="hidden" id="edit_action"        name="action"         value="Edit">
                        <div class="modal-body">

                            <!-- Badge label section aktif -->
                            <div class="mb-3">
                                <span class="badge badge-primary px-3 py-2" style="font-size:0.9rem;" id="edit-section-label"></span>
                            </div>

                            <!-- Section: Data Umum -->
                            <div id="edit-section-umum" style="display:none;">
                                <div class="row">
                                    <div class="col-md-8 offset-md-2">
                                        <div class="mb-3 row">
                                            <label class="col-sm-4 col-form-label">Diagnosis Medis</label>
                                            <div class="col-sm-8"><input type="text" class="form-control form-control-sm" id="edit_diagnosis_medis" name="diagnosis_medis"></div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-sm-4 col-form-label">Tindakan</label>
                                            <div class="col-sm-8"><input type="text" class="form-control form-control-sm" id="edit_tindakan" name="tindakan"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section: Pra Tindakan -->
                            <div id="edit-section-kpt" style="display:none;">
                                <div class="row">
                                    <div class="col-md-8 offset-md-2">
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">Keadaan Umum</label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" id="edit_keadaan_umum_kpt" name="keadaan_umum_kpt"></div></div>
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">Tekanan Darah <span class="label-unit">(mmHg)</span></label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" id="edit_tekanan_darah_kpt" name="tekanan_darah_kpt" placeholder="Cth: 120/80"></div></div>
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">Suhu <span class="label-unit">(°C)</span></label><div class="col-sm-8"><input type="number" step="0.1" class="form-control form-control-sm" id="edit_suhu_kpt" name="suhu_kpt"></div></div>
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">Nadi <span class="label-unit">(x/mnt)</span></label><div class="col-sm-8"><input type="number" class="form-control form-control-sm" id="edit_nadi_kpt" name="nadi_kpt"></div></div>
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">RR <span class="label-unit">(x/mnt)</span></label><div class="col-sm-8"><input type="number" class="form-control form-control-sm" id="edit_rr_kpt" name="rr_kpt"></div></div>
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">SpO2 <span class="label-unit">(%)</span></label><div class="col-sm-8"><input type="number" class="form-control form-control-sm" id="edit_spo2_kpt" name="spo2_kpt"></div></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section: Intra Tindakan -->
                            <div id="edit-section-kit" style="display:none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">Keadaan Umum</label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" id="edit_keadaan_umum_kit" name="keadaan_umum_kit"></div></div>
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">Dokter</label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" id="edit_dokter_kit" name="dokter_kit"></div></div>
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">Obat Anestesi Lokal</label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" id="edit_obat_anestesi_lokal_kit" name="obat_anestesi_lokal_kit"></div></div>
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">Dosis Obat</label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" id="edit_dosis_obat_kit" name="dosis_obat_kit"></div></div>
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">Rute Obat</label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" id="edit_rute_obat_kit" name="rute_obat_kit"></div></div>
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">Jam Mulai</label><div class="col-sm-8"><input type="time" class="form-control form-control-sm" id="edit_jam_mulai_kit" name="jam_mulai_kit"></div></div>
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">Jam Selesai</label><div class="col-sm-8"><input type="time" class="form-control form-control-sm" id="edit_jam_selesai_kit" name="jam_selesai_kit"></div></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">Tekanan Darah <span class="label-unit">(mmHg)</span></label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" id="edit_tekanan_darah_kit" name="tekanan_darah_kit" placeholder="Cth: 120/80"></div></div>
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">Suhu <span class="label-unit">(°C)</span></label><div class="col-sm-8"><input type="number" step="0.1" class="form-control form-control-sm" id="edit_suhu_kit" name="suhu_kit"></div></div>
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">Nadi <span class="label-unit">(x/mnt)</span></label><div class="col-sm-8"><input type="number" class="form-control form-control-sm" id="edit_nadi_kit" name="nadi_kit"></div></div>
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">RR <span class="label-unit">(x/mnt)</span></label><div class="col-sm-8"><input type="number" class="form-control form-control-sm" id="edit_rr_kit" name="rr_kit"></div></div>
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">SpO2 <span class="label-unit">(%)</span></label><div class="col-sm-8"><input type="number" class="form-control form-control-sm" id="edit_spo2_kit" name="spo2_kit"></div></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section: Post Tindakan -->
                            <div id="edit-section-kpot" style="display:none;">
                                <div class="row">
                                    <div class="col-md-8 offset-md-2">
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">Keadaan Umum</label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" id="edit_keadaan_umum_kpot" name="keadaan_umum_kpot"></div></div>
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">Tekanan Darah <span class="label-unit">(mmHg)</span></label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" id="edit_tekanan_darah_kpot" name="tekanan_darah_kpot" placeholder="Cth: 120/80"></div></div>
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">Suhu <span class="label-unit">(°C)</span></label><div class="col-sm-8"><input type="number" step="0.1" class="form-control form-control-sm" id="edit_suhu_kpot" name="suhu_kpot"></div></div>
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">Nadi <span class="label-unit">(x/mnt)</span></label><div class="col-sm-8"><input type="number" class="form-control form-control-sm" id="edit_nadi_kpot" name="nadi_kpot"></div></div>
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">RR <span class="label-unit">(x/mnt)</span></label><div class="col-sm-8"><input type="number" class="form-control form-control-sm" id="edit_rr_kpot" name="rr_kpot"></div></div>
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">SpO2 <span class="label-unit">(%)</span></label><div class="col-sm-8"><input type="number" class="form-control form-control-sm" id="edit_spo2_kpot" name="spo2_kpot"></div></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section: Catatan -->
                            <div id="edit-section-catatan" style="display:none;">
                                <div class="row">
                                    <div class="col-md-8 offset-md-2">
                                        <div class="mb-3 row">
                                            <label class="col-sm-4 col-form-label">Catatan</label>
                                            <div class="col-sm-8"><textarea class="form-control form-control-sm" id="edit_catatan" name="catatan" rows="6"></textarea></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="edit_submit_button" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan Perubahan</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <?= $this->endSection('content'); ?>

    <?= $this->section('control-sidebar'); ?>
    <aside class="control-sidebar control-sidebar-dark" style="height:100vh;">
        <div class="p-1 control-sidebar-content" style="height:602px; overflow-y:auto;">
            <div class="card">
                <div class="card-header bg-primary"><h3 class="card-title">Daftar Pasien</h3></div>
                <div class="card-body p-0"><span id="viewdata"></span></div>
            </div>
        </div>
    </aside>
    <?= $this->endSection('control-sidebar'); ?>

    <?= $this->section('script'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>
    $(document).prop("title", $('p#active-menu').html());

    var sectionMap = {
        'edit-tab-umum':    { div: 'edit-section-umum',    label: 'Data Umum' },
        'edit-tab-kpt':     { div: 'edit-section-kpt',     label: 'Pra Tindakan' },
        'edit-tab-kit':     { div: 'edit-section-kit',     label: 'Intra Tindakan' },
        'edit-tab-kpot':    { div: 'edit-section-kpot',    label: 'Post Tindakan' },
        'edit-tab-catatan': { div: 'edit-section-catatan', label: 'Catatan' }
    };


    var dataTTV = {
        tekananDarah: "",
        suhu: "",
        nadi: "",
        rr: "",
        spo2: "",
        kondisiUmum: ""
    };

    function fillTTVFromPerawat(data) {
        dataTTV.tekananDarah = (data.sistolik && data.diastolik) ? (data.sistolik + '/' + data.diastolik) : "";
        dataTTV.suhu = data.suhu || "";
        dataTTV.nadi = data.nadi || "";
        dataTTV.rr   = data.lajuNafas || "";
        dataTTV.spo2 = data.spo2 || "";
    }

    function fillKondisiUmumFromPemeriksaanAwal(data) {
        dataTTV.kondisiUmum = data && data.kondisi_umum ? data.kondisi_umum : "";
    }

    function resetTTV() {
        dataTTV = { tekananDarah: "", suhu: "", nadi: "", rr: "", spo2: "", kondisiUmum: "" };
    }

    function showEditSection(key) {
        $.each(sectionMap, function(k, v) { $('#' + v.div).hide(); });
        if (sectionMap[key]) {
            $('#' + sectionMap[key].div).show();
            $('#edit-section-label').text(sectionMap[key].label);
        }
    }

    function tregistrasi() {
        $.ajax({
            method: "GET",
            url: "<?= site_url('observasi/fetchAll'); ?>",
            success: function(data){ $('#viewdata').html(data); },
            error:   function(xhr){ console.error('fetchAll error:', xhr.responseText); }
        });
    }

    function fetchObservasiData() {
        var no_reg = $('#f_no_registrasi').val();
        if (!no_reg) return;
        $('#viewdataobservasi').html('<p class="text-center text-muted py-3"><i class="fas fa-spinner fa-spin"></i> Memuat data...</p>');
        $.ajax({
            url: "<?= site_url('observasi/fetchObservasiByRegistrasi'); ?>",
            method: "GET", cache: false,
            data: { no_registrasi: no_reg },
            success: function(data){
                $('#viewdataobservasi').html(data);
                checkDataExists();
            },
            error: function(){
                $('#viewdataobservasi').html('<p class="text-center text-danger py-3">Gagal memuat data. Coba refresh.</p>');
            }
        });
    }

    function checkDataExists() {
        var hasData = ($('#viewdataobservasi table tbody tr').length > 0 &&
                       $('#viewdataobservasi table tbody tr td[colspan]').length === 0);
        $('.btn-input-section').prop('disabled', hasData);
    }

    function syncHiddenFields() {
        var no_reg = $('#f_no_registrasi').val();
        var medrec = $('#f_medrec_id').val();
        $('.sync-no-registrasi').val(no_reg);
        $('.sync-medrec-id').val(medrec);
    }

    $(document).ready(function() {
        $('.btn-input-section').prop('disabled', true);
        tregistrasi();
        if (!$('body').hasClass('control-sidebar-slide-open')) {
            $('#toggle-sidebar-pasien').trigger('click');
        }
    });

    $(document).on('click', '.btn-nav-dark:not([disabled])', function() {
        $('.btn-nav-dark').removeClass('btn-nav-active');
        $(this).addClass('btn-nav-active');
    });

    $(document).on('click', '.pilihpasien', function() {
        var no_registrasi          = $(this).data('no_registrasi');
        var patient_no             = $(this).data('patient_no');
        var fullname               = $(this).data('fullname');
        var birth_dt               = $(this).data('birth_dt');
        var tahun                  = $(this).data('tahun');
        var bulan                  = $(this).data('bulan');
        var gender                 = $(this).data('gender');
        var nama_dokter            = $(this).data('nama_dokter');
        var tujuan_registrasi_desc = $(this).data('tujuan_registrasi_desc');
        var type_pasien            = $(this).data('type_pasien');
        var flag_alergi            = $(this).data('flag_alergi');

        $.ajax({ url:"<?= site_url('observasi/setNoRegistrasi'); ?>", method:"GET",
            data:{ no_registrasi: no_registrasi, patient_no: patient_no } });

        $('#f_no_registrasi').val(no_registrasi);
        $('#f_medrec_id').val(patient_no);
        $('#edit_no_registrasi').val(no_registrasi);
        syncHiddenFields();

        var clean_birth_dt = '';
        if (birth_dt) {
            var dateOnly = String(birth_dt).split(' ')[0];
            var parts = dateOnly.split('/');
            if (parts.length === 3) { clean_birth_dt = parts[1]+'/'+parts[0]+'/'+parts[2]; }
            else {
                var dash = dateOnly.split('-');
                clean_birth_dt = (dash.length === 3) ? dash[2]+'/'+dash[1]+'/'+dash[0] : dateOnly;
            }
        }

        $('#no_registrasi_display').html(no_registrasi);
        $('#medrec_id_info').html(patient_no);
        $('#fullname_tm').html(fullname);
        $('#birth_dt_tm').html(clean_birth_dt);
        $('#tahun').html(tahun);
        $('#bulan').html(bulan);
        $('#gender_tm').html(gender);
        $('#nama_dokter').html(nama_dokter);
        $('#tujuan_registrasi_desc').html(tujuan_registrasi_desc);
        $('#type_pasien').html(type_pasien);
        $('#riwayat_alergi_display').html(flag_alergi || '-');

        $('#header-identitas-pasien').fadeIn();
        $('#melayang').fadeIn();
        fetchObservasiData();

        resetTTV();
        $.ajax({
            url: "<?= site_url('observasi/setDataPemeriksaanPerawat'); ?>",
            method: "GET",
            data: { no_registrasi: no_registrasi },
            dataType: "JSON",
            success: function(response) {
                if (response.status === 'success' && response.data) {
                    fillTTVFromPerawat(response.data);
                }
            },
            error: function() {
                console.log('Gagal mengambil data pemeriksaan perawat untuk observasi.');
            }
        });

        $.ajax({
            url: "<?= site_url('pemeriksaanawal/fetchPemeriksaanAwalByRegistrasi'); ?>",
            method: "GET",
            data: { no_registrasi: no_registrasi },
            dataType: "JSON",
            success: function(response) {
                if (response.status === 'success' && response.data) {
                    fillKondisiUmumFromPemeriksaanAwal(response.data);
                }
            },
            error: function(xhr) {

            }
        });
        });

        $('#modalAddDataUmum, #modalAddKpt, #modalAddKit, #modalAddKpot, #modalAddCatatan').on('show.bs.modal', function() {
        syncHiddenFields();

        if ($(this).attr('id') === 'modalAddKpt') {
            if (dataTTV.tekananDarah) $('input[name="tekanan_darah_kpt"]').val(dataTTV.tekananDarah);
            if (dataTTV.suhu)         $('input[name="suhu_kpt"]').val(dataTTV.suhu);
            if (dataTTV.nadi)         $('input[name="nadi_kpt"]').val(dataTTV.nadi);
            if (dataTTV.rr)           $('input[name="rr_kpt"]').val(dataTTV.rr);
            if (dataTTV.spo2)         $('input[name="spo2_kpt"]').val(dataTTV.spo2);
            if (dataTTV.kondisiUmum)  $('input[name="keadaan_umum_kpt"]').val(dataTTV.kondisiUmum);
        }
    });

    $('#modalAddDataUmum, #modalAddKpt, #modalAddKit, #modalAddKpot, #modalAddCatatan').on('hidden.bs.modal', function() {
        $(this).find('form')[0].reset();
        syncHiddenFields();
    });

    $('#form_data_umum, #form_kpt, #form_kit, #form_kpot, #form_catatan').on('submit', function(e) {
        e.preventDefault();
        var $form  = $(this);
        var $btn   = $form.find('.btn-add-submit');
        var no_reg = $('#f_no_registrasi').val();

        if (!no_reg) {
            Swal.fire({ icon:'warning', title:'Peringatan', text:'Pilih pasien terlebih dahulu.' });
            return;
        }

        $.ajax({
            url: "<?= site_url('observasi/action'); ?>",
            method: "POST", data: $form.serialize(), dataType: "JSON",
            beforeSend: function(){ $btn.prop('disabled',true).html('<i class="fa fa-spin fa-spinner"></i> Menyimpan...'); },
            complete:   function(){ $btn.prop('disabled',false).html('<i class="fas fa-save mr-1"></i> Simpan'); },
            success: function(response) {
                if (response.error) {
                    Swal.fire({ icon:'error', title:'Gagal Menyimpan', text: Object.values(response.error).filter(Boolean).join('\n') });
                } else if (response.success) {
                    Swal.fire({ icon:'success', title:'Berhasil', text: response.success }).then(function(){
                        $form.closest('.modal').modal('hide');
                        fetchObservasiData();
                    });
                } else {
                    Swal.fire({ icon:'error', title:'Error', text:'Response tidak dikenali.' });
                }
            },
            error: function(){ Swal.fire({ icon:'error', title:'Gagal', text:'Tidak dapat menghubungi server.' }); }
        });
    });

    $('#btn_refresh').on('click', function(){ fetchObservasiData(); });

    $('#btn_cetak').on('click', function() {
        var no_reg = $('#f_no_registrasi').val();
        if (!no_reg) { Swal.fire({ icon:'warning', title:'Peringatan', text:'Pilih pasien terlebih dahulu.' }); return; }
        var params = new URLSearchParams({
            no_rm       : $('#medrec_id_info').text().trim(),
            nama_pasien : $('#fullname_tm').text().trim(),
            tgl_lahir   : $('#birth_dt_tm').text().trim(),
            gender      : $('#gender_tm').text().trim()
        });
        window.open("<?= site_url('observasi/printObservasi'); ?>/" + no_reg + '?' + params.toString(), '_blank');
    });

    $(document).on('click', '.clickable-col', function() {
        var tab = $(this).data('tab');
        var d   = $(this).closest('tr').data('row');
        if (!d) return;

        $('#edit_hidden_obs_id').val(d.id              || '');
        $('#edit_no_registrasi').val(d.no_registrasi   || $('#f_no_registrasi').val());
        $('#edit_diagnosis_medis').val(d.diagnosis_medis           || '');
        $('#edit_tindakan').val(d.tindakan                         || '');
        $('#edit_catatan').val(d.catatan                           || '');
        $('#edit_keadaan_umum_kpt').val(d.keadaan_umum_kpt         || '');
        $('#edit_tekanan_darah_kpt').val(d.tekanan_darah_kpt       || '');
        $('#edit_suhu_kpt').val(d.suhu_kpt                         || '');
        $('#edit_nadi_kpt').val(d.nadi_kpt                         || '');
        $('#edit_rr_kpt').val(d.rr_kpt                             || '');
        $('#edit_spo2_kpt').val(d.spo2_kpt                         || '');
        $('#edit_keadaan_umum_kit').val(d.keadaan_umum_kit         || '');
        $('#edit_dokter_kit').val(d.dokter_kit                     || '');
        $('#edit_obat_anestesi_lokal_kit').val(d.obat_anestesi_lokal_kit || '');
        $('#edit_dosis_obat_kit').val(d.dosis_obat_kit             || '');
        $('#edit_rute_obat_kit').val(d.rute_obat_kit               || '');
        $('#edit_jam_mulai_kit').val(d.jam_mulai_kit               || '');
        $('#edit_jam_selesai_kit').val(d.jam_selesai_kit           || '');
        $('#edit_tekanan_darah_kit').val(d.tekanan_darah_kit       || '');
        $('#edit_suhu_kit').val(d.suhu_kit                         || '');
        $('#edit_nadi_kit').val(d.nadi_kit                         || '');
        $('#edit_rr_kit').val(d.rr_kit                             || '');
        $('#edit_spo2_kit').val(d.spo2_kit                         || '');
        $('#edit_keadaan_umum_kpot').val(d.keadaan_umum_kpot       || '');
        $('#edit_tekanan_darah_kpot').val(d.tekanan_darah_kpot     || '');
        $('#edit_suhu_kpot').val(d.suhu_kpot                       || '');
        $('#edit_nadi_kpot').val(d.nadi_kpot                       || '');
        $('#edit_rr_kpot').val(d.rr_kpot                           || '');
        $('#edit_spo2_kpot').val(d.spo2_kpot                       || '');

        showEditSection(tab);
        $('#modalEditObservasi').modal('show');
    });

    $('#modalEditObservasi').on('hidden.bs.modal', function() {
        $('#edit_form')[0].reset();
        $('#edit_hidden_obs_id').val('');
        $.each(sectionMap, function(k, v) { $('#' + v.div).hide(); });
    });

    $('#edit_form').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= site_url('observasi/action'); ?>",
            method: "POST", data: $(this).serialize(), dataType: "JSON",
            beforeSend: function(){ $('#edit_submit_button').prop('disabled',true).html('<i class="fa fa-spin fa-spinner"></i> Menyimpan...'); },
            complete:   function(){ $('#edit_submit_button').prop('disabled',false).html('<i class="fas fa-save mr-1"></i> Simpan Perubahan'); },
            success: function(response) {
                if (response.error) {
                    Swal.fire({ icon:'error', title:'Gagal', text: Object.values(response.error).join('\n') });
                } else if (response.success) {
                    Swal.fire({ icon:'success', title:'Berhasil', text: response.success }).then(function(){
                        $('#modalEditObservasi').modal('hide');
                        fetchObservasiData();
                    });
                } else {
                    Swal.fire({ icon:'error', title:'Error', text:'Response tidak dikenali.' });
                }
            },
            error: function(){ Swal.fire({ icon:'error', title:'Gagal', text:'Tidak dapat menghubungi server.' }); }
        });
    });

    $(document).on('click', '.delete', function() {
        const obs_id = $(this).data('id');
        if (!obs_id) { Swal.fire({ icon:'error', title:'Error', text:'ID tidak ditemukan.' }); return; }

        Swal.fire({
            title: 'Yakin ingin menghapus data?',
            text: 'Data observasi akan dihapus secara permanen.',
            icon: 'warning', showCancelButton: true,
            confirmButtonText: 'Ya, hapus!', cancelButtonText: 'Batal'
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('observasi/delete'); ?>",
                    method: "POST", data: { obs_id: obs_id }, dataType: "JSON",
                    success: function(response) {
                        if (response.status === 'error') {
                            Swal.fire({ icon:'error', title:'Gagal', text: response.message || 'Gagal menghapus.' });
                        } else {
                            Swal.fire({ icon:'success', title:'Berhasil', text: response.message || 'Data berhasil dihapus.' })
                                .then(function(){ fetchObservasiData(); });
                        }
                    },
                    error: function(){ Swal.fire({ icon:'error', title:'Gagal', text:'Terjadi kesalahan server.' }); }
                });
            }
        });
    });
    </script>
    <?= $this->endSection('script'); ?>