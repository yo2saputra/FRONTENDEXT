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

        #viewdatapetunjuk { background-color: #fff !important; }
        #viewdatapetunjuk table { background-color: #fff !important; color: #333 !important; }
        #viewdatapetunjuk table thead tr th { background-color: #ffffff !important; color: #333 !important; }
        #viewdatapetunjuk table tbody tr td { background-color: #fff !important; color: #333 !important; }
        #viewdatapetunjuk table tbody tr:nth-child(even) td { background-color: #fafafa !important; }

        .btn-input-section { min-width: 120px; }

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
                                        <button type="button" class="btn btn-nav-dark btn-input-section" disabled
                                            data-toggle="modal" data-target="#modalAddDiag">
                                            <i class="fas fa-file-medical"></i> Diagnosis &amp; Vital
                                        </button>
                                        <button type="button" class="btn btn-nav-dark btn-input-section" disabled
                                            data-toggle="modal" data-target="#modalAddObat">
                                            <i class="fas fa-pills"></i> Obat &amp; Lembar
                                        </button>
                                        <button type="button" class="btn btn-nav-dark btn-input-section" disabled
                                            data-toggle="modal" data-target="#modalAddKontrol">
                                            <i class="fas fa-calendar-check"></i> Kontrol &amp; Penyuluhan
                                        </button>
                                        <button type="button" class="btn btn-nav-dark btn-input-section" disabled
                                            data-toggle="modal" data-target="#modalAddPemeriksaan">
                                            <i class="fas fa-clipboard-list"></i> Pemeriksaan &amp; Penjelasan
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

                                <div class="table-responsive" id="viewdatapetunjuk">
                                    <p class="text-muted text-center">Pilih pasien untuk melihat data petunjuk pulang.</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modal: Diagnosis & Vital -->
        <div class="modal fade" id="modalAddDiag" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title"><i class="fas fa-file-medical mr-2"></i>Input Diagnosis &amp; Vital</h5>
                        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <form id="form_diag" autocomplete="off">
                        <input type="hidden" name="no_registrasi" class="sync-no-registrasi">
                        <input type="hidden" name="action" value="Add">
                        <div class="modal-body">
                            <div class="row"><div class="col-md-8 offset-md-2">
                                <div class="mb-3 row"><label class="col-sm-4 col-form-label">Diagnosa Medis</label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" name="diagnosa_medis" placeholder="Masukkan diagnosa medis"></div></div>
                                <div class="mb-3 row"><label class="col-sm-4 col-form-label">Berat Badan <span class="label-unit">(kg)</span></label><div class="col-sm-8"><input type="number" step="0.1" class="form-control form-control-sm" name="berat_badan" placeholder="Cth: 60.5"></div></div>
                                <div class="mb-3 row"><label class="col-sm-4 col-form-label">Tinggi Badan <span class="label-unit">(cm)</span></label><div class="col-sm-8"><input type="number" step="0.1" class="form-control form-control-sm" name="tinggi_badan" placeholder="Cth: 165"></div></div>
                                <div class="mb-3 row"><label class="col-sm-4 col-form-label">Tensi <span class="label-unit">(mmHg)</span></label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" name="tensi" placeholder="Cth: 120/80"></div></div>
                                <div class="mb-3 row"><label class="col-sm-4 col-form-label">Nadi <span class="label-unit">(x/mnt)</span></label><div class="col-sm-8"><input type="number" class="form-control form-control-sm" name="nadi" placeholder="Cth: 80"></div></div>
                                <div class="mb-3 row"><label class="col-sm-4 col-form-label">Respiratory Rate <span class="label-unit">(x/mnt)</span></label><div class="col-sm-8"><input type="number" class="form-control form-control-sm" name="respiratory_rate" placeholder="Cth: 20"></div></div>
                                <div class="mb-3 row"><label class="col-sm-4 col-form-label">Suhu <span class="label-unit">(°C)</span></label><div class="col-sm-8"><input type="number" step="0.1" class="form-control form-control-sm" name="suhu" placeholder="Cth: 36.5"></div></div>
                            </div></div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-add-submit"><i class="fas fa-save mr-1"></i> Simpan</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal: Obat & Lembar -->
        <div class="modal fade" id="modalAddObat" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title"><i class="fas fa-pills mr-2"></i>Input Obat &amp; Lembar</h5>
                        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <form id="form_obat" autocomplete="off">
                        <input type="hidden" name="no_registrasi" class="sync-no-registrasi">
                        <input type="hidden" name="action" value="Add">
                        <div class="modal-body">
                            <div class="row"><div class="col-md-8 offset-md-2">
                                <div class="mb-3 row"><label class="col-sm-4 col-form-label">Obat Diberikan</label><div class="col-sm-8"><textarea class="form-control form-control-sm" name="diberikan_obt" rows="3" placeholder="Nama obat yang diberikan"></textarea></div></div>
                                <div class="mb-3 row"><label class="col-sm-4 col-form-label">Obat Dibawa Pulang</label><div class="col-sm-8"><textarea class="form-control form-control-sm" name="dibawapulang_obt" rows="3" placeholder="Nama obat yang dibawa pulang"></textarea></div></div>
                                <div class="mb-3 row"><label class="col-sm-4 col-form-label">Laboratorium <span class="label-unit">(lembar)</span></label><div class="col-sm-8"><input type="number" min="0" class="form-control form-control-sm" name="laboratorium_lmbr" placeholder="0"></div></div>
                                <div class="mb-3 row"><label class="col-sm-4 col-form-label">Foto Thorax <span class="label-unit">(lembar)</span></label><div class="col-sm-8"><input type="number" min="0" class="form-control form-control-sm" name="foto_thorax_lmbr" placeholder="0"></div></div>
                                <div class="mb-3 row"><label class="col-sm-4 col-form-label">USG <span class="label-unit">(lembar)</span></label><div class="col-sm-8"><input type="number" min="0" class="form-control form-control-sm" name="usg_lmbr" placeholder="0"></div></div>
                                <div class="mb-3 row"><label class="col-sm-4 col-form-label">Lainnya <span class="label-unit">(lembar)</span></label><div class="col-sm-8"><input type="number" min="0" class="form-control form-control-sm" name="lainnya_lmbr" placeholder="0"></div></div>
                            </div></div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-add-submit"><i class="fas fa-save mr-1"></i> Simpan</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal: Kontrol & Penyuluhan -->
        <div class="modal fade" id="modalAddKontrol" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title"><i class="fas fa-calendar-check mr-2"></i>Input Kontrol &amp; Penyuluhan</h5>
                        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <form id="form_kontrol" autocomplete="off">
                        <input type="hidden" name="no_registrasi" class="sync-no-registrasi">
                        <input type="hidden" name="action" value="Add">
                        <input type="hidden" name="penyuluhan_kesehatan" id="add_penyuluhan_merged">
                        <div class="modal-body">
                            <div class="row"><div class="col-md-8 offset-md-2">
                                <div class="mb-3 row"><label class="col-sm-4 col-form-label">Penyuluhan 1</label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" id="add_penyuluhan_1" placeholder="Penyuluhan kesehatan ke-1"></div></div>
                                <div class="mb-3 row"><label class="col-sm-4 col-form-label">Penyuluhan 2</label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" id="add_penyuluhan_2" placeholder="Penyuluhan kesehatan ke-2"></div></div>
                                <div class="mb-3 row"><label class="col-sm-4 col-form-label">Penyuluhan 3</label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" id="add_penyuluhan_3" placeholder="Penyuluhan kesehatan ke-3"></div></div>
                                <div class="mb-3 row"><label class="col-sm-4 col-form-label">Tanggal Kontrol</label><div class="col-sm-8"><input type="date" class="form-control form-control-sm" name="tgl_kntrl"></div></div>
                                <div class="mb-3 row"><label class="col-sm-4 col-form-label">Poli Kontrol</label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" name="poli_kntrl" placeholder="Nama poli kontrol"></div></div>
                                <div class="mb-3 row"><label class="col-sm-4 col-form-label">Membawa</label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" name="membawa_kntrl" placeholder="Dokumen yang dibawa saat kontrol"></div></div>
                            </div></div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-add-submit"><i class="fas fa-save mr-1"></i> Simpan</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal: Pemeriksaan & Penjelasan -->
        <div class="modal fade" id="modalAddPemeriksaan" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title"><i class="fas fa-clipboard-list mr-2"></i>Input Pemeriksaan &amp; Penjelasan</h5>
                        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <form id="form_pemeriksaan" autocomplete="off">
                        <input type="hidden" name="no_registrasi" class="sync-no-registrasi">
                        <input type="hidden" name="action" value="Add">
                        <div class="modal-body">
                            <div class="row"><div class="col-md-8 offset-md-2">
                                <div class="mb-3 row"><label class="col-sm-4 col-form-label">Tanggal Pemeriksaan</label><div class="col-sm-8"><input type="date" class="form-control form-control-sm" name="tgl_pemeriksaan"></div></div>
                                <div class="mb-3 row"><label class="col-sm-4 col-form-label">Diberi Penjelasan</label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" name="diberi_pnjlsan" placeholder="Nama penerima penjelasan"></div></div>
                                <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label">Pemberi Penjelasan</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm bg-light" name="pemberi_pnjlsan" id="add_pemberi_pnjlsan" readonly>
                                        <small class="text-muted">Otomatis diisi dari nama perawat yang login.</small>
                                    </div>
                                </div>
                            </div></div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-add-submit"><i class="fas fa-save mr-1"></i> Simpan</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal: Edit -->
        <div class="modal fade" id="modalEditPetunjuk" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title"><i class="fas fa-edit mr-2"></i>Ubah Data Petunjuk Pulang</h5>
                        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <form id="edit_form" autocomplete="off">
                        <input type="hidden" id="edit_no_registrasi" name="no_registrasi" value="">
                        <input type="hidden" id="edit_action"        name="action"        value="Edit">
                        <input type="hidden" name="penyuluhan_kesehatan" id="edit_penyuluhan_merged">
                        <div class="modal-body">
                            <div class="mb-3">
                                <span class="badge badge-primary px-3 py-2" style="font-size:0.9rem;" id="edit-section-label"></span>
                            </div>
                            <ul class="nav nav-tabs mb-3 d-none" id="edit-petunjuk-tabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#edit-tab-diag">Diagnosis &amp; Vital</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#edit-tab-obat">Obat &amp; Lembar</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#edit-tab-kontrol">Kontrol &amp; Penyuluhan</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#edit-tab-pemeriksaan">Pemeriksaan &amp; Penjelasan</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="edit-tab-diag" role="tabpanel">
                                    <div class="row"><div class="col-md-8 offset-md-2">
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">Diagnosa Medis</label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" id="edit_diagnosa_medis" name="diagnosa_medis"></div></div>
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">Berat Badan <span class="label-unit">(kg)</span></label><div class="col-sm-8"><input type="number" step="0.1" class="form-control form-control-sm" id="edit_berat_badan" name="berat_badan"></div></div>
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">Tinggi Badan <span class="label-unit">(cm)</span></label><div class="col-sm-8"><input type="number" step="0.1" class="form-control form-control-sm" id="edit_tinggi_badan" name="tinggi_badan"></div></div>
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">Tensi <span class="label-unit">(mmHg)</span></label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" id="edit_tensi" name="tensi" placeholder="Cth: 120/80"></div></div>
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">Nadi <span class="label-unit">(x/mnt)</span></label><div class="col-sm-8"><input type="number" class="form-control form-control-sm" id="edit_nadi" name="nadi"></div></div>
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">Respiratory Rate <span class="label-unit">(x/mnt)</span></label><div class="col-sm-8"><input type="number" class="form-control form-control-sm" id="edit_respiratory_rate" name="respiratory_rate"></div></div>
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">Suhu <span class="label-unit">(°C)</span></label><div class="col-sm-8"><input type="number" step="0.1" class="form-control form-control-sm" id="edit_suhu" name="suhu"></div></div>
                                    </div></div>
                                </div>
                                <div class="tab-pane fade" id="edit-tab-obat" role="tabpanel">
                                    <div class="row"><div class="col-md-8 offset-md-2">
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">Obat Diberikan</label><div class="col-sm-8"><textarea class="form-control form-control-sm" id="edit_diberikan_obt" name="diberikan_obt" rows="3"></textarea></div></div>
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">Obat Dibawa Pulang</label><div class="col-sm-8"><textarea class="form-control form-control-sm" id="edit_dibawapulang_obt" name="dibawapulang_obt" rows="3"></textarea></div></div>
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">Laboratorium <span class="label-unit">(lembar)</span></label><div class="col-sm-8"><input type="number" min="0" class="form-control form-control-sm" id="edit_laboratorium_lmbr" name="laboratorium_lmbr"></div></div>
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">Foto Thorax <span class="label-unit">(lembar)</span></label><div class="col-sm-8"><input type="number" min="0" class="form-control form-control-sm" id="edit_foto_thorax_lmbr" name="foto_thorax_lmbr"></div></div>
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">USG <span class="label-unit">(lembar)</span></label><div class="col-sm-8"><input type="number" min="0" class="form-control form-control-sm" id="edit_usg_lmbr" name="usg_lmbr"></div></div>
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">Lainnya <span class="label-unit">(lembar)</span></label><div class="col-sm-8"><input type="number" min="0" class="form-control form-control-sm" id="edit_lainnya_lmbr" name="lainnya_lmbr"></div></div>
                                    </div></div>
                                </div>
                                <div class="tab-pane fade" id="edit-tab-kontrol" role="tabpanel">
                                    <div class="row"><div class="col-md-8 offset-md-2">
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">Penyuluhan 1</label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" id="edit_penyuluhan_1" placeholder="Penyuluhan kesehatan ke-1"></div></div>
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">Penyuluhan 2</label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" id="edit_penyuluhan_2" placeholder="Penyuluhan kesehatan ke-2"></div></div>
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">Penyuluhan 3</label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" id="edit_penyuluhan_3" placeholder="Penyuluhan kesehatan ke-3"></div></div>
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">Tanggal Kontrol</label><div class="col-sm-8"><input type="date" class="form-control form-control-sm" id="edit_tgl_kntrl" name="tgl_kntrl"></div></div>
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">Poli Kontrol</label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" id="edit_poli_kntrl" name="poli_kntrl"></div></div>
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">Membawa</label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" id="edit_membawa_kntrl" name="membawa_kntrl"></div></div>
                                    </div></div>
                                </div>
                                <div class="tab-pane fade" id="edit-tab-pemeriksaan" role="tabpanel">
                                    <div class="row"><div class="col-md-8 offset-md-2">
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">Tanggal Pemeriksaan</label><div class="col-sm-8"><input type="date" class="form-control form-control-sm" id="edit_tgl_pemeriksaan" name="tgl_pemeriksaan"></div></div>
                                        <div class="mb-3 row"><label class="col-sm-4 col-form-label">Diberi Penjelasan</label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" id="edit_diberi_pnjlsan" name="diberi_pnjlsan"></div></div>
                                        <div class="mb-3 row">
                                            <label class="col-sm-4 col-form-label">Pemberi Penjelasan</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm bg-light" id="edit_pemberi_pnjlsan" name="pemberi_pnjlsan" readonly>
                                                <small class="text-muted">Otomatis diisi dari nama perawat yang login.</small>
                                            </div>
                                        </div>
                                    </div></div>
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

    var CURRENT_PERAWAT_NAME = "<?= esc($session_emp_nm ?? '') ?>";

    function tregistrasi() {
        $.ajax({
            method: "GET",
            url: "<?= site_url('petunjukpasien/fetchAll'); ?>",
            success: function(data){ $('#viewdata').html(data); },
            error:   function(xhr){ console.error('fetchAll error:', xhr.responseText); }
        });
    }

    function fetchPetunjukData() {
        var no_reg = $('#f_no_registrasi').val();
        if (!no_reg) return;

        $('#viewdatapetunjuk').html('<p class="text-center text-muted py-3"><i class="fas fa-spinner fa-spin"></i> Memuat data...</p>');

        $.ajax({
            url: "<?= site_url('petunjukpasien/fetchPetunjukByRegistrasi'); ?>",
            method: "GET", cache: false,
            data: { no_registrasi: no_reg },
            success: function(data){
                $('#viewdatapetunjuk').html(data);
                checkDataExists();
            },
            error: function(){
                $('#viewdatapetunjuk').html('<p class="text-center text-danger py-3">Gagal memuat data. Coba refresh.</p>');
            }
        });
    }

    function checkDataExists() {
        var hasData = ($('#viewdatapetunjuk table tbody tr').length > 0 &&
                       $('#viewdatapetunjuk table tbody tr td[colspan]').length === 0);
        $('.btn-input-section').prop('disabled', hasData);
    }

    function syncHiddenFields() {
        var no_reg = $('#f_no_registrasi').val();
        $('.sync-no-registrasi').val(no_reg);
    }

    function resetForm($form) {
        $form[0].reset();
        $form.find('input[type="text"], input[type="number"], input[type="date"], input[type="time"]').val('');
        $form.find('textarea').val('');
    }

    function extractError(response) {
        if (!response.error) return 'Terjadi kesalahan tidak dikenal.';
        if (typeof response.error === 'string') return response.error;
        if (typeof response.error === 'object') {
            return Object.values(response.error).filter(Boolean).join('\n');
        }
        return JSON.stringify(response.error);
    }

    function mergePenyuluhan(p1, p2, p3) {
        return [$.trim(p1), $.trim(p2), $.trim(p3)].filter(Boolean).join('||');
    }

    function splitPenyuluhan(val) {
        var parts = (val || '').split('||');
        return [
            $.trim(parts[0] || ''),
            $.trim(parts[1] || ''),
            $.trim(parts[2] || '')
        ];
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

        $.ajax({ url:"<?= site_url('petunjukpasien/setNoRegistrasi'); ?>", method:"GET", data:{ no_registrasi: no_registrasi, patient_no: patient_no } });

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
        fetchPetunjukData();
    });

    $('#modalAddDiag, #modalAddObat, #modalAddKontrol, #modalAddPemeriksaan').on('show.bs.modal', function() {
        resetForm($(this).find('form'));
        $('#add_penyuluhan_1, #add_penyuluhan_2, #add_penyuluhan_3').val('');
        syncHiddenFields();

        // Auto-isi nama pemberi penjelasan dari perawat yang login
        if ($(this).attr('id') === 'modalAddPemeriksaan') {
            $('#add_pemberi_pnjlsan').val(CURRENT_PERAWAT_NAME);
        }
    });

    $('#modalAddDiag, #modalAddObat, #modalAddKontrol, #modalAddPemeriksaan').on('hidden.bs.modal', function() {
        resetForm($(this).find('form'));
        $('#add_penyuluhan_1, #add_penyuluhan_2, #add_penyuluhan_3').val('');
        syncHiddenFields();
    });

    $('#form_diag, #form_obat, #form_kontrol, #form_pemeriksaan').off('submit').on('submit', function(e) {
        e.preventDefault();
        var $form  = $(this);
        var $btn   = $form.find('.btn-add-submit');
        var no_reg = $('#f_no_registrasi').val();

        if (!no_reg) {
            Swal.fire({ icon:'warning', title:'Peringatan', text:'Pilih pasien terlebih dahulu.' });
            return;
        }

        $form.find('.sync-no-registrasi').val(no_reg);

        if ($form.attr('id') === 'form_kontrol') {
            $('#add_penyuluhan_merged').val(
                mergePenyuluhan($('#add_penyuluhan_1').val(), $('#add_penyuluhan_2').val(), $('#add_penyuluhan_3').val())
            );
        }

        $.ajax({
            url: "<?= site_url('petunjukpasien/action'); ?>",
            method: "POST",
            data: $form.serialize(),
            dataType: "JSON",
            beforeSend: function(){ $btn.prop('disabled',true).html('<i class="fa fa-spin fa-spinner"></i> Menyimpan...'); },
            complete:   function(){ $btn.prop('disabled',false).html('<i class="fas fa-save mr-1"></i> Simpan'); },
            success: function(response) {
                if (response.error) {
                    Swal.fire({ icon:'error', title:'Gagal Menyimpan', text: extractError(response) });
                } else if (response.success) {
                    Swal.fire({ icon:'success', title:'Berhasil', text: response.success }).then(function(){
                        $form.closest('.modal').modal('hide');
                        fetchPetunjukData();
                    });
                } else {
                    Swal.fire({ icon:'error', title:'Error', text:'Response tidak dikenali.' });
                }
            },
            error: function(){ Swal.fire({ icon:'error', title:'Gagal', text:'Tidak dapat menghubungi server.' }); }
        });
    });

    $('#btn_refresh').on('click', function(){ fetchPetunjukData(); });

    $('#btn_cetak').on('click', function() {
        var no_reg = $('#f_no_registrasi').val();
        if (!no_reg) { Swal.fire({ icon:'warning', title:'Peringatan', text:'Pilih pasien terlebih dahulu.' }); return; }
        var params = new URLSearchParams({
            no_rm       : $('#medrec_id_info').text().trim(),
            nama_pasien : $('#fullname_tm').text().trim(),
            tgl_lahir   : $('#birth_dt_tm').text().trim(),
            gender      : $('#gender_tm').text().trim()
        });
        window.open("<?= site_url('petunjukpasien/printPetunjuk'); ?>/" + no_reg + '?' + params.toString(), '_blank');
    });

    $(document).on('click', '.clickable-col', function() {
        var tab = $(this).data('tab');
        var d   = $(this).closest('tr').data('row');
        if (!d) return;

        var no_reg = $('#f_no_registrasi').val();
        $('#edit_no_registrasi').val(no_reg);

        resetForm($('#edit_form'));

        $('#edit_diagnosa_medis').val(d.diagnosa_medis             || '');
        $('#edit_berat_badan').val(d.berat_badan                   || '');
        $('#edit_tinggi_badan').val(d.tinggi_badan                 || '');
        $('#edit_tensi').val(d.tensi                               || '');
        $('#edit_nadi').val(d.nadi                                 || '');
        $('#edit_respiratory_rate').val(d.respiratory_rate         || '');
        $('#edit_suhu').val(d.suhu                                 || '');
        $('#edit_diberikan_obt').val(d.diberikan_obt               || '');
        $('#edit_dibawapulang_obt').val(d.dibawapulang_obt         || '');
        $('#edit_laboratorium_lmbr').val(d.laboratorium_lmbr       || '');
        $('#edit_foto_thorax_lmbr').val(d.foto_thorax_lmbr         || '');
        $('#edit_usg_lmbr').val(d.usg_lmbr                         || '');
        $('#edit_lainnya_lmbr').val(d.lainnya_lmbr                 || '');
        var pparts = splitPenyuluhan(d.penyuluhan_kesehatan || '');
        $('#edit_penyuluhan_1').val(pparts[0]);
        $('#edit_penyuluhan_2').val(pparts[1]);
        $('#edit_penyuluhan_3').val(pparts[2]);
        $('#edit_tgl_kntrl').val(d.tgl_kntrl           ? d.tgl_kntrl.split('T')[0]         : '');
        $('#edit_poli_kntrl').val(d.poli_kntrl                     || '');
        $('#edit_membawa_kntrl').val(d.membawa_kntrl               || '');
        $('#edit_tgl_pemeriksaan').val(d.tgl_pemeriksaan ? d.tgl_pemeriksaan.split('T')[0] : '');
        $('#edit_diberi_pnjlsan').val(d.diberi_pnjlsan             || '');
        // Selalu pakai nama perawat yang sedang login, bukan data lama (server juga override ini)
        $('#edit_pemberi_pnjlsan').val(CURRENT_PERAWAT_NAME);

        $('#edit_no_registrasi').val(no_reg);

        var tabLabels = {
            'edit-tab-diag':        'Diagnosis & Vital',
            'edit-tab-obat':        'Obat & Lembar',
            'edit-tab-kontrol':     'Kontrol & Penyuluhan',
            'edit-tab-pemeriksaan': 'Pemeriksaan & Penjelasan'
        };
        $('#edit-section-label').text(tabLabels[tab] || '');
        $('#edit-petunjuk-tabs a[href="#' + tab + '"]').tab('show');
        $('#modalEditPetunjuk').modal('show');
    });

    $('#modalEditPetunjuk').on('hidden.bs.modal', function() {
        resetForm($('#edit_form'));
        $('#edit_penyuluhan_1, #edit_penyuluhan_2, #edit_penyuluhan_3').val('');
    });

    $('#edit_form').off('submit').on('submit', function(e) {
        e.preventDefault();
        var no_reg = $('#f_no_registrasi').val();
        $('#edit_no_registrasi').val(no_reg);

        $('#edit_penyuluhan_merged').val(
            mergePenyuluhan($('#edit_penyuluhan_1').val(), $('#edit_penyuluhan_2').val(), $('#edit_penyuluhan_3').val())
        );

        $.ajax({
            url: "<?= site_url('petunjukpasien/action'); ?>",
            method: "POST",
            data: $(this).serialize(),
            dataType: "JSON",
            beforeSend: function(){ $('#edit_submit_button').prop('disabled',true).html('<i class="fa fa-spin fa-spinner"></i> Menyimpan...'); },
            complete:   function(){ $('#edit_submit_button').prop('disabled',false).html('<i class="fas fa-save mr-1"></i> Simpan Perubahan'); },
            success: function(response) {
                if (response.error) {
                    Swal.fire({ icon:'error', title:'Gagal', text: extractError(response) });
                } else if (response.success) {
                    Swal.fire({ icon:'success', title:'Berhasil', text: response.success }).then(function(){
                        $('#modalEditPetunjuk').modal('hide');
                        fetchPetunjukData();
                    });
                } else {
                    Swal.fire({ icon:'error', title:'Error', text:'Response tidak dikenali.' });
                }
            },
            error: function(){ Swal.fire({ icon:'error', title:'Gagal', text:'Tidak dapat menghubungi server.' }); }
        });
    });

    $(document).on('click', '.delete', function() {
        const no_registrasi = $(this).data('no_registrasi');
        if (!no_registrasi) { Swal.fire({ icon:'error', title:'Error', text:'No. Registrasi tidak ditemukan.' }); return; }

        Swal.fire({
            title: 'Yakin ingin menghapus data?',
            text: 'Data petunjuk pulang akan dihapus secara permanen.',
            icon: 'warning', showCancelButton: true,
            confirmButtonText: 'Ya, hapus!', cancelButtonText: 'Batal'
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('petunjukpasien/delete'); ?>",
                    method: "POST",
                    data: { no_registrasi: no_registrasi },
                    dataType: "JSON",
                    success: function(response) {
                        if (response.status === 'error') {
                            Swal.fire({ icon:'error', title:'Gagal', text: response.message || 'Gagal menghapus.' });
                        } else {
                            Swal.fire({ icon:'success', title:'Berhasil', text: response.message || 'Data berhasil dihapus.' })
                                .then(function(){ fetchPetunjukData(); });
                        }
                    },
                    error: function(){ Swal.fire({ icon:'error', title:'Gagal', text:'Terjadi kesalahan server.' }); }
                });
            }
        });
    });
    </script>
    <?= $this->endSection('script'); ?>