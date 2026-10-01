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
        #viewdatadischarge { background-color: #fff !important; }
        #viewdatadischarge table { background-color: #fff !important; color: #333 !important; }
        #viewdatadischarge table thead tr th { background-color: #ffffff !important; color: #333 !important; }
        #viewdatadischarge table tbody tr td { background-color: #fff !important; color: #333 !important; }
        #viewdatadischarge table tbody tr:nth-child(even) td { background-color: #fafafa !important; }
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

        /* Light mode: background bar lebih terang, teks gelap */
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

        /* Dark mode: background bar gelap, teks terang */
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

        /* Base shared */
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
                                        <button type="button" class="btn btn-nav-dark btn-input-section" id="btn_add_umum" disabled
                                            data-toggle="modal" data-target="#modalAddUmum">
                                            <i class="fas fa-file-medical"></i> Data Umum
                                        </button>
                                        <button type="button" class="btn btn-nav-dark btn-input-section" id="btn_add_perawatan" disabled
                                            data-toggle="modal" data-target="#modalAddPerawatan">
                                            <i class="fas fa-home"></i> Perawatan Rumah
                                        </button>
                                        <button type="button" class="btn btn-nav-dark btn-input-section" id="btn_add_diet" disabled
                                            data-toggle="modal" data-target="#modalAddDiet">
                                            <i class="fas fa-utensils"></i> Diet &amp; Nutrisi
                                        </button>
                                        <button type="button" class="btn btn-nav-dark btn-input-section" id="btn_add_obat" disabled
                                            data-toggle="modal" data-target="#modalAddObat">
                                            <i class="fas fa-pills"></i> Obat &amp; Aktivitas
                                        </button>
                                        <button type="button" class="btn btn-nav-dark btn-input-section" id="btn_add_lainlain" disabled
                                            data-toggle="modal" data-target="#modalAddLainLain">
                                            <i class="fas fa-file-alt"></i> Hasil &amp; Lain-lain
                                        </button>
                                        <button type="button" class="btn btn-nav-dark" id="btn_add_ttd" disabled
                                            title="Fitur tanda tangan belum tersedia">
                                            <i class="fas fa-signature"></i> Tanda Tangan
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
                                <div class="table-responsive" id="viewdatadischarge">
                                    <p class="text-muted text-center">Pilih pasien untuk melihat data discharge planning.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== MODAL ADD: Data Umum ===== -->
        <div class="modal fade" id="modalAddUmum" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document"><div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-file-medical mr-2"></i> Data Umum</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form class="form-add-section" autocomplete="off">
                    <input type="hidden" name="no_registrasi" class="sync-no-reg">
                    <input type="hidden" name="action" value="Add">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2 row"><label class="col-sm-5 col-form-label col-form-label-sm">Diagnosa Medis</label><div class="col-sm-7"><input type="text" class="form-control form-control-sm" name="diagnosa_medis" placeholder="Diagnosa medis"></div></div>
                                <div class="mb-2 row"><label class="col-sm-5 col-form-label col-form-label-sm">Keadaan Pulang</label><div class="col-sm-7"><select class="form-control form-control-sm" name="keadaan_pulang"><option value="">-- Pilih --</option><option>Sembuh</option><option>Meneruskan Berobat Jalan</option><option>Pindah ke Klinik/RS Lain</option><option>Pulang Paksa</option><option>Lari</option><option>Meninggal</option></select></div></div>
                                <div class="mb-2 row"><label class="col-sm-5 col-form-label col-form-label-sm">Tgl Pemeriksaan</label><div class="col-sm-7"><input type="date" class="form-control form-control-sm" name="tgl_pemeriksaan"></div></div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2 row"><label class="col-sm-5 col-form-label col-form-label-sm">Waktu Kontrol</label><div class="col-sm-7"><input type="datetime-local" class="form-control form-control-sm" name="waktu_kntrl"></div></div>
                                <div class="mb-2 row"><label class="col-sm-5 col-form-label col-form-label-sm">Tempat Kontrol</label><div class="col-sm-7"><input type="text" class="form-control form-control-sm" name="tempat_kntrl" placeholder="Cth: Poli Umum Medicelle"></div></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer"><button type="submit" class="btn btn-primary btn-add-submit"><i class="fas fa-save mr-1"></i> Simpan</button><button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button></div>
                </form>
            </div></div>
        </div>

        <!-- ===== MODAL ADD: Perawatan Rumah ===== -->
        <div class="modal fade" id="modalAddPerawatan" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document"><div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-home mr-2"></i> B. Lanjutan Perawatan di Rumah</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form class="form-add-section" autocomplete="off">
                    <input type="hidden" name="no_registrasi" class="sync-no-reg">
                    <input type="hidden" name="action" value="Add">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6"><div class="mb-2 row"><label class="col-sm-3 col-form-label col-form-label-sm">Baris 1</label><div class="col-sm-9"><textarea class="form-control form-control-sm" name="lanjutan_perawatan_dirumah1" rows="3" placeholder="Cth: Kompres dingin di area luka"></textarea></div></div></div>
                            <div class="col-md-6"><div class="mb-2 row"><label class="col-sm-3 col-form-label col-form-label-sm">Baris 2</label><div class="col-sm-9"><textarea class="form-control form-control-sm" name="lanjutan_perawatan_dirumah2" rows="3" placeholder="Opsional"></textarea></div></div></div>
                        </div>
                    </div>
                    <div class="modal-footer"><button type="submit" class="btn btn-primary btn-add-submit"><i class="fas fa-save mr-1"></i> Simpan</button><button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button></div>
                </form>
            </div></div>
        </div>

        <!-- ===== MODAL ADD: Diet & Nutrisi ===== -->
        <div class="modal fade" id="modalAddDiet" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document"><div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-utensils mr-2"></i> C. Aturan Diet / Nutrisi</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form class="form-add-section" autocomplete="off">
                    <input type="hidden" name="no_registrasi" class="sync-no-reg">
                    <input type="hidden" name="action" value="Add">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6"><div class="mb-2 row"><label class="col-sm-3 col-form-label col-form-label-sm">Baris 1</label><div class="col-sm-9"><textarea class="form-control form-control-sm" name="aturan_diet_nutrisi1" rows="3" placeholder="Cth: Makanan yang bergizi"></textarea></div></div></div>
                            <div class="col-md-6"><div class="mb-2 row"><label class="col-sm-3 col-form-label col-form-label-sm">Baris 2</label><div class="col-sm-9"><textarea class="form-control form-control-sm" name="aturan_diet_nutrisi2" rows="3" placeholder="Opsional"></textarea></div></div></div>
                        </div>
                    </div>
                    <div class="modal-footer"><button type="submit" class="btn btn-primary btn-add-submit"><i class="fas fa-save mr-1"></i> Simpan</button><button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button></div>
                </form>
            </div></div>
        </div>

        <!-- ===== MODAL ADD: Obat & Aktivitas ===== -->
        <div class="modal fade" id="modalAddObat" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document"><div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-pills mr-2"></i> D. Obat &amp; E. Aktivitas</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form class="form-add-section" autocomplete="off">
                    <input type="hidden" name="no_registrasi" class="sync-no-reg">
                    <input type="hidden" name="action" value="Add">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="section-divider" style="font-size:0.75rem;"><i class="fas fa-pills mr-1"></i> D. Obat-obatan</div>
                                <div class="mb-2 row"><label class="col-sm-3 col-form-label col-form-label-sm">Obat 1</label><div class="col-sm-9"><input type="text" class="form-control form-control-sm" name="obat_diminum_jumlah1" placeholder="Cth: Kalhofen tab 2x1"></div></div>
                                <div class="mb-2 row"><label class="col-sm-3 col-form-label col-form-label-sm">Obat 2</label><div class="col-sm-9"><input type="text" class="form-control form-control-sm" name="obat_diminum_jumlah2" placeholder="Cth: Cefixin tab 2x1"></div></div>
                            </div>
                            <div class="col-md-6">
                                <div class="section-divider" style="font-size:0.75rem;"><i class="fas fa-running mr-1"></i> E. Aktivitas</div>
                                <div class="mb-2 row"><label class="col-sm-3 col-form-label col-form-label-sm">Baris 1</label><div class="col-sm-9"><textarea class="form-control form-control-sm" name="aktivitas_istirahat1" rows="2" placeholder="Instruksi aktivitas / istirahat"></textarea></div></div>
                                <div class="mb-2 row"><label class="col-sm-3 col-form-label col-form-label-sm">Baris 2</label><div class="col-sm-9"><textarea class="form-control form-control-sm" name="aktivitas_istirahat2" rows="2" placeholder="Opsional"></textarea></div></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer"><button type="submit" class="btn btn-primary btn-add-submit"><i class="fas fa-save mr-1"></i> Simpan</button><button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button></div>
                </form>
            </div></div>
        </div>

        <!-- ===== MODAL ADD: Hasil & Lain-lain ===== -->
        <div class="modal fade" id="modalAddLainLain" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document"><div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-file-alt mr-2"></i> F. Hasil &amp; G. Lain-lain</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form class="form-add-section" autocomplete="off">
                    <input type="hidden" name="no_registrasi" class="sync-no-reg">
                    <input type="hidden" name="action" value="Add">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="section-divider" style="font-size:0.75rem;"><i class="fas fa-file-alt mr-1"></i> F. Hasil Pemeriksaan / Surat</div>
                                <div class="mb-2 row"><label class="col-sm-3 col-form-label col-form-label-sm">Surat 1</label><div class="col-sm-9"><textarea class="form-control form-control-sm" name="hasil_surat1" rows="3" placeholder="Cth: Hasil USG"></textarea></div></div>
                                <div class="mb-2 row"><label class="col-sm-3 col-form-label col-form-label-sm">Surat 2</label><div class="col-sm-9"><textarea class="form-control form-control-sm" name="hasil_surat2" rows="3" placeholder="Cth: Surat Keterangan Istirahat"></textarea></div></div>
                            </div>
                            <div class="col-md-6">
                                <div class="section-divider" style="font-size:0.75rem;"><i class="fas fa-comment-medical mr-1"></i> G. Lain-lain</div>
                                <textarea class="form-control form-control-sm" name="lain_lain" rows="4" placeholder="Catatan lain-lain (opsional)"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer"><button type="submit" class="btn btn-primary btn-add-submit"><i class="fas fa-save mr-1"></i> Simpan</button><button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button></div>
                </form>
            </div></div>
        </div>

        <!-- ===== MODAL ADD: Tanda Tangan ===== -->
        <div class="modal fade" id="modalAddTtd" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document"><div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-signature mr-2"></i> Tanda Tangan</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form class="form-add-section" autocomplete="off">
                    <input type="hidden" name="no_registrasi" class="sync-no-reg">
                    <input type="hidden" name="action" value="Add">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2 row"><label class="col-sm-5 col-form-label col-form-label-sm">Pasien / Keluarga</label><div class="col-sm-7"><input type="text" class="form-control form-control-sm" name="pasien_keluarga" placeholder="Nama pasien atau keluarga"></div></div>
                                <div class="mb-2 row"><label class="col-sm-5 col-form-label col-form-label-sm">Dokter (TTD)</label><div class="col-sm-7"><input type="text" class="form-control form-control-sm" name="usr_dokter_display" value="<?= $session_is_dokter ? esc($session_emp_nm ?? '') : '(diisi otomatis saat dokter login)' ?>" readonly></div></div>
                                <div class="mb-2 row"><label class="col-sm-5 col-form-label col-form-label-sm">Perawat (TTD)</label><div class="col-sm-7"><input type="text" class="form-control form-control-sm" name="usr_perawat_display" value="<?= !$session_is_dokter ? esc($session_emp_nm ?? '') : '(diisi otomatis saat perawat login)' ?>" readonly></div></div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2 row"><label class="col-sm-5 col-form-label col-form-label-sm">Tanggal TTD</label><div class="col-sm-7"><input type="date" class="form-control form-control-sm" name="tgl_ttd"></div></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer"><button type="submit" class="btn btn-primary btn-add-submit"><i class="fas fa-save mr-1"></i> Simpan</button><button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button></div>
                </form>
            </div></div>
        </div>

        <!-- ===== MODAL EDIT ===== -->
        <div class="modal fade" id="modalEditDischarge" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title"><i class="fas fa-edit mr-2"></i>Ubah Data Discharge Planning</h5>
                        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <form id="edit_form" autocomplete="off">
                        <input type="hidden" id="edit_no_registrasi" name="no_registrasi" value="">
                        <input type="hidden" name="action" value="Edit">
                        <div class="modal-body">

                            <div class="mb-3">
                                <span class="badge badge-primary px-3 py-2" style="font-size:0.9rem;" id="edit-section-label"></span>
                            </div>

                            <!-- Section: Data Umum -->
                            <div id="edit-section-umum" style="display:none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-2 row">
                                            <label class="col-sm-5 col-form-label col-form-label-sm">Diagnosa Medis</label>
                                            <div class="col-sm-7"><input type="text" class="form-control form-control-sm" id="edit_diagnosa_medis" name="diagnosa_medis"></div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-sm-5 col-form-label col-form-label-sm">Keadaan Pulang</label>
                                            <div class="col-sm-7">
                                                <select class="form-control form-control-sm" id="edit_keadaan_pulang" name="keadaan_pulang">
                                                    <option value="">-- Pilih --</option>
                                                    <option value="Sembuh">Sembuh</option>
                                                    <option value="Meneruskan Berobat Jalan">Meneruskan Berobat Jalan</option>
                                                    <option value="Pindah ke Klinik/RS Lain">Pindah ke Klinik/RS Lain</option>
                                                    <option value="Pulang Paksa">Pulang Paksa</option>
                                                    <option value="Lari">Lari</option>
                                                    <option value="Meninggal">Meninggal</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-sm-5 col-form-label col-form-label-sm">Tgl Pemeriksaan</label>
                                            <div class="col-sm-7"><input type="date" class="form-control form-control-sm" id="edit_tgl_pemeriksaan" name="tgl_pemeriksaan"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-2 row">
                                            <label class="col-sm-5 col-form-label col-form-label-sm">Waktu Kontrol</label>
                                            <div class="col-sm-7"><input type="datetime-local" class="form-control form-control-sm" id="edit_waktu_kntrl" name="waktu_kntrl"></div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-sm-5 col-form-label col-form-label-sm">Tempat Kontrol</label>
                                            <div class="col-sm-7"><input type="text" class="form-control form-control-sm" id="edit_tempat_kntrl" name="tempat_kntrl"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section: Perawatan Rumah -->
                            <div id="edit-section-perawatan" style="display:none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-2 row">
                                            <label class="col-sm-3 col-form-label col-form-label-sm">Baris 1</label>
                                            <div class="col-sm-9"><textarea class="form-control form-control-sm" id="edit_lanjutan_perawatan_dirumah1" name="lanjutan_perawatan_dirumah1" rows="3"></textarea></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-2 row">
                                            <label class="col-sm-3 col-form-label col-form-label-sm">Baris 2</label>
                                            <div class="col-sm-9"><textarea class="form-control form-control-sm" id="edit_lanjutan_perawatan_dirumah2" name="lanjutan_perawatan_dirumah2" rows="3"></textarea></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section: Diet & Nutrisi -->
                            <div id="edit-section-diet" style="display:none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-2 row">
                                            <label class="col-sm-3 col-form-label col-form-label-sm">Baris 1</label>
                                            <div class="col-sm-9"><textarea class="form-control form-control-sm" id="edit_aturan_diet_nutrisi1" name="aturan_diet_nutrisi1" rows="3"></textarea></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-2 row">
                                            <label class="col-sm-3 col-form-label col-form-label-sm">Baris 2</label>
                                            <div class="col-sm-9"><textarea class="form-control form-control-sm" id="edit_aturan_diet_nutrisi2" name="aturan_diet_nutrisi2" rows="3"></textarea></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section: Obat & Aktivitas -->
                            <div id="edit-section-obat" style="display:none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="font-weight-bold border-bottom pb-1 mb-2" style="font-size:0.8rem;">Obat Diminum</h6>
                                        <div class="mb-2 row">
                                            <label class="col-sm-4 col-form-label col-form-label-sm">Obat 1</label>
                                            <div class="col-sm-8"><input type="text" class="form-control form-control-sm" id="edit_obat_diminum_jumlah1" name="obat_diminum_jumlah1"></div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-sm-4 col-form-label col-form-label-sm">Obat 2</label>
                                            <div class="col-sm-8"><input type="text" class="form-control form-control-sm" id="edit_obat_diminum_jumlah2" name="obat_diminum_jumlah2"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="font-weight-bold border-bottom pb-1 mb-2" style="font-size:0.8rem;">Aktivitas &amp; Istirahat</h6>
                                        <div class="mb-2 row">
                                            <label class="col-sm-4 col-form-label col-form-label-sm">Baris 1</label>
                                            <div class="col-sm-8"><textarea class="form-control form-control-sm" id="edit_aktivitas_istirahat1" name="aktivitas_istirahat1" rows="2"></textarea></div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-sm-4 col-form-label col-form-label-sm">Baris 2</label>
                                            <div class="col-sm-8"><textarea class="form-control form-control-sm" id="edit_aktivitas_istirahat2" name="aktivitas_istirahat2" rows="2"></textarea></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section: Hasil & Lain-lain -->
                            <div id="edit-section-lainlain" style="display:none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-2 row">
                                            <label class="col-sm-3 col-form-label col-form-label-sm">Surat 1</label>
                                            <div class="col-sm-9"><textarea class="form-control form-control-sm" id="edit_hasil_surat1" name="hasil_surat1" rows="3"></textarea></div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-sm-3 col-form-label col-form-label-sm">Surat 2</label>
                                            <div class="col-sm-9"><textarea class="form-control form-control-sm" id="edit_hasil_surat2" name="hasil_surat2" rows="3"></textarea></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-2 row">
                                            <label class="col-sm-3 col-form-label col-form-label-sm">Lain-lain</label>
                                            <div class="col-sm-9"><textarea class="form-control form-control-sm" id="edit_lain_lain" name="lain_lain" rows="4"></textarea></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section: Tanda Tangan -->
                            <div id="edit-section-ttd" style="display:none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-2 row">
                                            <label class="col-sm-5 col-form-label col-form-label-sm">Pasien / Keluarga</label>
                                            <div class="col-sm-7"><input type="text" class="form-control form-control-sm" id="edit_pasien_keluarga" name="pasien_keluarga"></div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-sm-5 col-form-label col-form-label-sm">Dokter (TTD)</label>
                                            <div class="col-sm-7"><input type="text" class="form-control form-control-sm" id="edit_usr_dokter" readonly></div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-sm-5 col-form-label col-form-label-sm">Perawat (TTD)</label>
                                            <div class="col-sm-7"><input type="text" class="form-control form-control-sm" id="edit_usr_perawat" readonly></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-2 row">
                                            <label class="col-sm-5 col-form-label col-form-label-sm">Tanggal TTD</label>
                                            <div class="col-sm-7"><input type="date" class="form-control form-control-sm" id="edit_tgl_ttd" name="tgl_ttd"></div>
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
        'umum':      { div: 'edit-section-umum',      label: 'Data Umum' },
        'perawatan': { div: 'edit-section-perawatan',  label: 'B. Perawatan Rumah' },
        'diet':      { div: 'edit-section-diet',       label: 'C. Diet & Nutrisi' },
        'obat':      { div: 'edit-section-obat',       label: 'D. Obat & Aktivitas' },
        'lainlain':  { div: 'edit-section-lainlain',   label: 'F. Hasil & Lain-lain' },
        'ttd':       { div: 'edit-section-ttd',        label: 'Tanda Tangan' }
    };

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
            url: "<?= site_url('discharge/fetchAll'); ?>",
            success: function(data){ $('#viewdata').html(data); },
            error:   function(xhr){ console.error('fetchAll error:', xhr.responseText); }
        });
    }

    function fetchDischargeData() {
        var no_reg = $('#f_no_registrasi').val();
        if (!no_reg) return;
        $('#viewdatadischarge').html('<p class="text-center text-muted py-3"><i class="fas fa-spinner fa-spin"></i> Memuat data...</p>');
        $.ajax({
            url: "<?= site_url('discharge/fetchDischargeByRegistrasi'); ?>",
            method: "GET", cache: false,
            data: { no_registrasi: no_reg },
            success: function(data){
                $('#viewdatadischarge').html(data);
                checkDataExists();
            },
            error: function(){
                $('#viewdatadischarge').html('<p class="text-center text-danger py-3">Gagal memuat data. Coba refresh.</p>');
            }
        });
    }

    function checkDataExists() {
        var hasData = ($('#viewdatadischarge table tbody tr').length > 0 &&
                       $('#viewdatadischarge table tbody tr td[colspan]').length === 0);
        $('.btn-input-section').prop('disabled', hasData);
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

        $.ajax({ url:"<?= site_url('discharge/setNoRegistrasi'); ?>", method:"GET",
            data:{ no_registrasi: no_registrasi, patient_no: patient_no } });

        $('#f_no_registrasi').val(no_registrasi);
        $('#f_medrec_id').val(patient_no);
        $('.sync-no-reg').val(no_registrasi);
        $('#edit_no_registrasi').val(no_registrasi);

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
        fetchDischargeData();
    });

    $('.modal[id^="modalAdd"]').on('hidden.bs.modal', function() {
        $(this).find('form')[0].reset();
        $('.sync-no-reg').val($('#f_no_registrasi').val());
    });

    $(document).on('submit', '.form-add-section', function(e) {
        e.preventDefault();
        var no_reg = $('#f_no_registrasi').val();
        if (!no_reg) { Swal.fire({ icon:'warning', title:'Peringatan', text:'Pilih pasien terlebih dahulu.' }); return; }
        var $form = $(this);
        var $btn  = $form.find('.btn-add-submit');
        $.ajax({
            url: "<?= site_url('discharge/action'); ?>",
            method: "POST", data: $form.serialize(), dataType: "JSON",
            beforeSend: function(){ $btn.prop('disabled',true).html('<i class="fa fa-spin fa-spinner"></i> Menyimpan...'); },
            complete:   function(){ $btn.prop('disabled',false).html('<i class="fas fa-save mr-1"></i> Simpan'); },
            success: function(response) {
                if (response.error) {
                    Swal.fire({ icon:'error', title:'Gagal Menyimpan', text: Object.values(response.error).filter(Boolean).join('\n') });
                } else if (response.success) {
                    Swal.fire({ icon:'success', title:'Berhasil', text: response.success }).then(function(){
                        $form.closest('.modal').modal('hide');
                        fetchDischargeData();
                    });
                }
            },
            error: function(){ Swal.fire({ icon:'error', title:'Gagal', text:'Tidak dapat menghubungi server.' }); }
        });
    });

    $('#btn_refresh').on('click', function(){ fetchDischargeData(); });

    $('#btn_cetak').on('click', function() {
        var no_reg = $('#f_no_registrasi').val();
        if (!no_reg) { Swal.fire({ icon:'warning', title:'Peringatan', text:'Pilih pasien terlebih dahulu.' }); return; }
        var params = new URLSearchParams({
            no_rm       : $('#medrec_id_info').text().trim(),
            nama_pasien : $('#fullname_tm').text().trim(),
            tgl_lahir   : $('#birth_dt_tm').text().trim(),
            gender      : $('#gender_tm').text().trim()
        });
        window.open("<?= site_url('discharge/printDischarge'); ?>/" + no_reg + '?' + params.toString(), '_blank');
    });

    $(document).on('click', '.clickable-col', function() {
        var tab = $(this).data('tab');
        var d   = $(this).closest('tr').data('row');
        if (!d) return;

        var tabToSection = {
            'edit-tab-umum':      'umum',
            'edit-tab-perawatan': 'perawatan',
            'edit-tab-diet':      'diet',
            'edit-tab-obat':      'obat',
            'edit-tab-lainlain':  'lainlain',
            'edit-tab-ttd':       'ttd'
        };

        $('#edit_no_registrasi').val(d.no_registrasi || $('#f_no_registrasi').val());
        $('#edit_diagnosa_medis').val(d.diagnosa_medis           || '');
        $('#edit_tgl_pemeriksaan').val(d.tgl_pemeriksaan         ? d.tgl_pemeriksaan.substring(0,10) : '');
        $('#edit_tgl_ttd').val(d.tgl_ttd                         ? d.tgl_ttd.substring(0,10) : '');
        $('#edit_keadaan_pulang').val(d.keadaan_pulang            || '');
        var waktu_raw = d.waktu_kntrl || '';
        if (waktu_raw && waktu_raw.indexOf('T') === -1 && waktu_raw.length >= 16) {
            waktu_raw = waktu_raw.substring(0, 16).replace(' ', 'T');
        } else if (waktu_raw) {
            waktu_raw = waktu_raw.substring(0, 16);
        }
        $('#edit_waktu_kntrl').val(waktu_raw);
        $('#edit_tempat_kntrl').val(d.tempat_kntrl                || '');
        $('#edit_usr_perawat').val(d.usr_perawat                  || '');
        $('#edit_usr_dokter').val(d.usr_dokter                    || '');
        $('#edit_pasien_keluarga').val(d.pasien_keluarga          || '');
        $('#edit_lanjutan_perawatan_dirumah1').val(d.lanjutan_perawatan_dirumah1 || '');
        $('#edit_lanjutan_perawatan_dirumah2').val(d.lanjutan_perawatan_dirumah2 || '');
        $('#edit_aturan_diet_nutrisi1').val(d.aturan_diet_nutrisi1 || '');
        $('#edit_aturan_diet_nutrisi2').val(d.aturan_diet_nutrisi2 || '');
        $('#edit_obat_diminum_jumlah1').val(d.obat_diminum_jumlah1 || '');
        $('#edit_obat_diminum_jumlah2').val(d.obat_diminum_jumlah2 || '');
        $('#edit_aktivitas_istirahat1').val(d.aktivitas_istirahat1 || '');
        $('#edit_aktivitas_istirahat2').val(d.aktivitas_istirahat2 || '');
        $('#edit_hasil_surat1').val(d.hasil_surat1 || '');
        $('#edit_hasil_surat2').val(d.hasil_surat2 || '');
        $('#edit_lain_lain').val(d.lain_lain       || '');

        showEditSection(tabToSection[tab] || 'umum');
        $('#modalEditDischarge').modal('show');
    });

    $('#modalEditDischarge').on('hidden.bs.modal', function() { $('#edit_form')[0].reset(); });

    $('#edit_form').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= site_url('discharge/action'); ?>",
            method: "POST", data: $(this).serialize(), dataType: "JSON",
            beforeSend: function(){ $('#edit_submit_button').prop('disabled',true).html('<i class="fa fa-spin fa-spinner"></i> Menyimpan...'); },
            complete:   function(){ $('#edit_submit_button').prop('disabled',false).html('<i class="fas fa-save mr-1"></i> Simpan Perubahan'); },
            success: function(response) {
                if (response.error) {
                    Swal.fire({ icon:'error', title:'Gagal', text: Object.values(response.error).join('\n') });
                } else if (response.success) {
                    Swal.fire({ icon:'success', title:'Berhasil', text: response.success }).then(function(){
                        $('#modalEditDischarge').modal('hide');
                        fetchDischargeData();
                    });
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
            text: 'Data discharge planning akan dihapus secara permanen.',
            icon: 'warning', showCancelButton: true,
            confirmButtonText: 'Ya, hapus!', cancelButtonText: 'Batal'
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('discharge/delete'); ?>",
                    method: "POST", data: { no_registrasi: no_registrasi }, dataType: "JSON",
                    success: function(response) {
                        if (response.status === 'error') {
                            Swal.fire({ icon:'error', title:'Gagal', text: response.message || 'Gagal menghapus.' });
                        } else {
                            Swal.fire({ icon:'success', title:'Berhasil', text: response.message || 'Data berhasil dihapus.' })
                                .then(function(){ fetchDischargeData(); });
                        }
                    },
                    error: function(){ Swal.fire({ icon:'error', title:'Gagal', text:'Terjadi kesalahan server.' }); }
                });
            }
        });
    });
    </script>
    <?= $this->endSection('script'); ?>