<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>
<style>
    .btn-fix-w {
        width: 60px;
        padding-top: 0px;
        padding-bottom: 0px;
    }

    .control-sidebar {
        color: black;
    }

    .content-header-fixed {
        -webkit-transition: -webkit-transform .3s ease-in-out, margin .3s ease-in-out;
        transition: transform .3s ease-in-out, margin .3s ease-in-out;
        position: fixed;
        color: #fff;
        margin-left: 245px;
        left: 0;
        right: 0;
        padding: 5px;
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
            padding-top: 180px;
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

        .content-header-fixed {
            position: relative !important;
            margin-left: 0 !important;
        }

        #melayang {
            padding-top: 0 !important;
            display: block !important;
        }
    }

    .caption_text {
        font-size: 0.6rem;
    }

    .content_text {
        font-size: 0.8rem;
    }

    .form-control-sm {
        font-size: .720rem !important;
    }

    .btn-input-section {
        min-width: 100px;
    }

    .step-wizard {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .step-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
        position: relative;
    }

    .step-item:not(:last-child)::after {
        content: '';
        position: absolute;
        top: 18px;
        left: 60%;
        width: 80%;
        height: 3px;
        background: #dee2e6;
        z-index: 0;
    }

    .step-item.done:not(:last-child)::after {
        background: #28a745;
    }

    .step-item.active:not(:last-child)::after {
        background: #dee2e6;
    }

    .step-circle {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1rem;
        border: 3px solid #dee2e6;
        background: #fff;
        color: #adb5bd;
        position: relative;
        z-index: 1;
        transition: all .3s;
    }

    .step-item.done .step-circle {
        background: #28a745;
        border-color: #28a745;
        color: #fff;
    }

    .step-item.active .step-circle {
        background: #007bff;
        border-color: #007bff;
        color: #fff;
        box-shadow: 0 0 0 4px rgba(0, 123, 255, .2);
    }

    .step-item.locked .step-circle {
        background: #f8f9fa;
        border-color: #dee2e6;
        color: #adb5bd;
        cursor: not-allowed;
    }

    .step-label {
        font-size: 0.72rem;
        font-weight: 600;
        margin-top: 6px;
        color: #adb5bd;
        text-align: center;
    }

    .step-item.done .step-label {
        color: #28a745;
    }

    .step-item.active .step-label {
        color: #007bff;
    }

    .step-sublabel {
        font-size: 0.62rem;
        color: #adb5bd;
        text-align: center;
    }

    .step-item.done .step-sublabel {
        color: #6c757d;
    }

    .step-item.active .step-sublabel {
        color: #6c757d;
    }

    .fase-panel {
        display: none;
    }

    .fase-panel.active {
        display: block;
    }

    .fase-header {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        border-radius: 6px 6px 0 0;
        font-size: 0.9rem;
        font-weight: 700;
        color: #fff;
        margin-bottom: 0;
    }

    .fase-header.signin {
        background: #28a745;
    }

    .fase-header.timeout {
        background: #fd7e14;
    }

    .fase-header.signout {
        background: #dc3545;
    }

    .fase-body {
        border: 1px solid #dee2e6;
        border-top: none;
        border-radius: 0 0 6px 6px;
        padding: 16px;
        background: #fff;
    }

    .field-group {
        border: 1px solid #e9ecef;
        border-radius: 4px;
        padding: 8px 10px;
        margin-bottom: 8px;
        background: #fff;
    }

    .field-group-title {
        font-size: 0.72rem;
        font-weight: 700;
        color: #007bff;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .surgical-summary-card {
        border: 1px solid #dee2e6;
        border-radius: 6px;
        overflow: hidden;
    }

    .surgical-summary-card .card-header-section {
        background: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        padding: 8px 12px;
        font-weight: 600;
        font-size: 0.82rem;
        color: #343a40;
    }

    .surgical-summary-card table {
        margin: 0;
        font-size: 0.82rem;
    }

    .badge-signin {
        background-color: #28a745;
        color: #fff;
    }

    .badge-timeout {
        background-color: #fd7e14;
        color: #fff;
    }

    .badge-signout {
        background-color: #dc3545;
        color: #fff;
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
        background-color: rgba(0, 0, 0, 0.08);
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
        background-color: rgba(217, 119, 6, 0.1);
    }

    body.dark-mode .btn-nav-bar {
        background-color: #343a40;
    }

    body.dark-mode .btn-nav-bar .btn-nav-dark {
        color: #c2c7d0 !important;
    }

    body.dark-mode .btn-nav-bar .btn-nav-dark:hover:not(:disabled) {
        background-color: rgba(255, 255, 255, 0.1);
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
        background-color: rgba(255, 193, 7, 0.08);
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

    #panel-signin input,
    #panel-signin select,
    #panel-signin textarea,
    #panel-timeout input,
    #panel-timeout select,
    #panel-timeout textarea,
    #panel-signout input,
    #panel-signout select,
    #panel-signout textarea {
        background-color: #ffffff !important;
        color: #333333 !important;
        border: 1px solid #ced4da !important;
    }

    #panel-signin input::placeholder,
    #panel-timeout input::placeholder,
    #panel-signout input::placeholder,
    #panel-signin textarea::placeholder,
    #panel-timeout textarea::placeholder,
    #panel-signout textarea::placeholder {
        color: #999999 !important;
    }

    #panel-signin .form-check-input,
    #panel-timeout .form-check-input,
    #panel-signout .form-check-input {
        width: auto !important;
        height: auto !important;
        background-color: #ffffff !important;
        border: 1px solid #adb5bd !important;
        margin-top: 3px;
    }

    #panel-signin .form-check-label,
    #panel-timeout .form-check-label,
    #panel-signout .form-check-label {
        color: #333333 !important;
        font-size: 0.82rem;
    }

    .field-group {
        background-color: #f8f9fa !important;
        border: 1px solid #dee2e6 !important;
    }

    .field-group-title {
        color: #007bff !important;
    }

    .fase-body {
        background-color: #ffffff !important;
        color: #333333 !important;
    }

    #panel-signin label,
    #panel-timeout label,
    #panel-signout label {
        color: #333333 !important;
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
    <input type="hidden" id="f_medrec_id" value="">
    <input type="hidden" id="f_is_edit" value="0">

    <section class="content-header-fixed" id="header-identitas-pasien" style="display:none;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card bg-info" style="padding:2px;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-6">
                                    <dl>
                                        <dt class="caption_text">Nomor Registrasi</dt><span id="no_registrasi_display" class="content_text">&nbsp;</span>
                                    </dl>
                                </div>
                                <div class="col-md-3 col-6">
                                    <dl>
                                        <dt class="caption_text">No. Rekam Medis</dt><span id="medrec_id_info" class="content_text">&nbsp;</span>
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
                                        <dt class="caption_text">Riwayat Alergi</dt><span id="riwayat_alergi_display" class="content_text">&nbsp;</span>
                                    </dl>
                                </div>
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

                            <!-- ===== TOOLBAR ===== -->
                            <div class="row mb-3">
                                <div class="col-sm-12 d-flex flex-wrap align-items-center btn-nav-bar">
                                    <button type="button" id="btn_signin_panel" class="btn btn-nav-dark btn-nav-active">
                                        <i class="fas fa-sign-in-alt"></i> Sign In
                                    </button>
                                    <button type="button" id="btn_timeout_panel" class="btn btn-nav-dark">
                                        <i class="fas fa-clock"></i> Time Out
                                    </button>
                                    <button type="button" id="btn_signout_panel" class="btn btn-nav-dark">
                                        <i class="fas fa-sign-out-alt"></i> Sign Out
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

                            <!-- ===== SIGN IN ===== -->
                            <div class="fase-panel active" id="panel-signin">
                                <div class="fase-body">
                                    <form id="form_signin" autocomplete="off">
                                        <input type="hidden" name="fase" value="signin">
                                        <input type="hidden" name="no_registrasi" id="signin_no_registrasi">
                                        <input type="hidden" name="is_edit" id="signin_is_edit" value="0">

                                        <div class="field-group">
                                            <div class="field-group-title">Informasi Umum Tindakan</div>
                                            <div class="row">
                                                <div class="col-md-4 mb-2">
                                                    <label style="font-size:0.8rem;">Tanggal Tindakan</label>
                                                    <input type="date" class="form-control form-control-sm" name="tgl_tindakan" id="si_tgl_tindakan">
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <label style="font-size:0.8rem;">Jenis Tindakan</label>
                                                    <input type="text" class="form-control form-control-sm" name="jenis_tindakan" placeholder="Jenis tindakan">
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <label style="font-size:0.8rem;">Diagnosa</label>
                                                    <input type="text" class="form-control form-control-sm" name="diagnosa" placeholder="Diagnosa">
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <label style="font-size:0.8rem;">Jenis Anastesi</label>
                                                    <input type="text" class="form-control form-control-sm" name="jenis_anastesi" placeholder="Jenis anastesi">
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <label style="font-size:0.8rem;">Obat Anastesi</label>
                                                    <input type="text" class="form-control form-control-sm" name="obat_anastesi" placeholder="Obat anastesi">
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <label style="font-size:0.8rem;">Dokter Operator</label>
                                                    <input type="text" class="form-control form-control-sm" name="dokter_operator" placeholder="Dokter operator">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="field-group">
                                            <div class="field-group-title">Jam Sign In</div>
                                            <div class="col-md-4 px-0">
                                                <input type="time" class="form-control form-control-sm" name="jam_signin">
                                            </div>
                                        </div>

                                        <div class="field-group">
                                            <div class="field-group-title">Verifikasi Pasien</div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="identitas_pasien_verifikasi" id="si_chk_identitas" value="ya">
                                                        <label class="form-check-label" for="si_chk_identitas" style="font-size:0.82rem;">Identitas Pasien</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="informed_consent_verifikasi" id="si_chk_informed" value="ya">
                                                        <label class="form-check-label" for="si_chk_informed" style="font-size:0.82rem;">Informed Consent</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="field-group">
                                            <div class="field-group-title">Pemberian Tanda di Lokasi Operasi</div>
                                            <div class="d-flex" style="gap:20px;">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="tanda_lokasi_operasi" id="si_tanda_ya" value="ya">
                                                    <label class="form-check-label" for="si_tanda_ya" style="font-size:0.82rem;">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="tanda_lokasi_operasi" id="si_tanda_tidak" value="tidak">
                                                    <label class="form-check-label" for="si_tanda_tidak" style="font-size:0.82rem;">Tidak</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="field-group">
                                            <div class="field-group-title">Diagnosa Pasien</div>
                                            <input type="text" class="form-control form-control-sm" name="diagnosa_pasien" placeholder="Diagnosa pasien">
                                        </div>

                                        <div class="field-group">
                                            <div class="field-group-title">Pemeriksaan TTV</div>
                                            <div class="row">
                                                <div class="col-md-3 mb-2">
                                                    <label style="font-size:0.8rem;">TD (mmHg)</label>
                                                    <input type="text" class="form-control form-control-sm" name="tekanan_darah_ttv_si" placeholder="120/80">
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label style="font-size:0.8rem;">N (x/mnt)</label>
                                                    <input type="number" class="form-control form-control-sm" name="nadi_ttv_si" placeholder="0">
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label style="font-size:0.8rem;">S (°C)</label>
                                                    <input type="number" step="0.1" class="form-control form-control-sm" name="suhu_ttv_si" placeholder="0">
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label style="font-size:0.8rem;">RR (x/mnt)</label>
                                                    <input type="number" class="form-control form-control-sm" name="rr_ttv_si" placeholder="0">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="field-group">
                                            <div class="field-group-title">Riwayat Alergi</div>
                                            <div class="d-flex" style="gap:20px; margin-bottom:6px;">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="riwayat_alergi_ra" id="si_alergi_ada" value="ada">
                                                    <label class="form-check-label" for="si_alergi_ada" style="font-size:0.82rem;">Ada, sebutkan:</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="riwayat_alergi_ra" id="si_alergi_tidak" value="tidak_ada">
                                                    <label class="form-check-label" for="si_alergi_tidak" style="font-size:0.82rem;">Tidak Ada</label>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" name="sebutkan_ra" id="si_sebutkan_ra" placeholder="Sebutkan alergi..." style="display:none;">
                                        </div>

                                        <div class="field-group">
                                            <div class="field-group-title">Risiko Aspirasi dan Gangguan Pernafasan</div>
                                            <div class="d-flex" style="gap:20px;">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="resikoaspirasi_ganguanpernafasan" id="si_aspirasi_ya" value="ya">
                                                    <label class="form-check-label" for="si_aspirasi_ya" style="font-size:0.82rem;">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="resikoaspirasi_ganguanpernafasan" id="si_aspirasi_tidak" value="tidak">
                                                    <label class="form-check-label" for="si_aspirasi_tidak" style="font-size:0.82rem;">Tidak</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="field-group">
                                            <div class="field-group-title">Risiko Perdarahan</div>
                                            <div class="d-flex" style="gap:20px;">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="resiko_perdarahan" id="si_perdarahan_ya" value="ya">
                                                    <label class="form-check-label" for="si_perdarahan_ya" style="font-size:0.82rem;">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="resiko_perdarahan" id="si_perdarahan_tidak" value="tidak">
                                                    <label class="form-check-label" for="si_perdarahan_tidak" style="font-size:0.82rem;">Tidak</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end mt-3">
                                            <button type="submit" class="btn btn-success" id="btn_submit_signin">
                                                <i class="fas fa-save mr-1"></i> Simpan Sign In &amp; Lanjut ke Time Out
                                                <i class="fas fa-arrow-right ml-1"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- ===== TIME OUT ===== -->
                            <div class="fase-panel" id="panel-timeout">
                                <div class="fase-body">
                                    <form id="form_timeout" autocomplete="off">
                                        <input type="hidden" name="fase" value="timeout">
                                        <input type="hidden" name="no_registrasi" id="timeout_no_registrasi">
                                        <input type="hidden" name="tgl_tindakan" id="to_tgl_tindakan">
                                        <input type="hidden" name="jenis_tindakan" id="to_jenis_tindakan">
                                        <input type="hidden" name="diagnosa" id="to_diagnosa">
                                        <input type="hidden" name="jenis_anastesi" id="to_jenis_anastesi">
                                        <input type="hidden" name="obat_anastesi" id="to_obat_anastesi">
                                        <input type="hidden" name="dokter_operator" id="to_dokter_operator">
                                        <input type="hidden" name="jam_signin" id="to_jam_signin">
                                        <input type="hidden" name="identitas_pasien_verifikasi" id="to_identitas_pasien_verifikasi">
                                        <input type="hidden" name="informed_consent_verifikasi" id="to_informed_consent_verifikasi">
                                        <input type="hidden" name="tanda_lokasi_operasi" id="to_tanda_lokasi_operasi">
                                        <input type="hidden" name="diagnosa_pasien" id="to_diagnosa_pasien">
                                        <input type="hidden" name="tekanan_darah_ttv_si" id="to_tekanan_darah_ttv_si">
                                        <input type="hidden" name="nadi_ttv_si" id="to_nadi_ttv_si">
                                        <input type="hidden" name="suhu_ttv_si" id="to_suhu_ttv_si">
                                        <input type="hidden" name="rr_ttv_si" id="to_rr_ttv_si">
                                        <input type="hidden" name="riwayat_alergi_ra" id="to_riwayat_alergi_ra">
                                        <input type="hidden" name="sebutkan_ra" id="to_sebutkan_ra">
                                        <input type="hidden" name="resikoaspirasi_ganguanpernafasan" id="to_resikoaspirasi">
                                        <input type="hidden" name="resiko_perdarahan" id="to_resiko_perdarahan">
                                        <input type="hidden" name="petugas_si" id="to_petugas_si">
                                        <input type="hidden" name="jam_signout" id="to_jam_signout" value="">
                                        <input type="hidden" name="istrument_pkslod" id="to_istrument_pkslod" value="tidak">
                                        <input type="hidden" name="kassa_pkslod" id="to_kassa_pkslod" value="tidak">
                                        <input type="hidden" name="jarum_pkslod" id="to_jarum_pkslod" value="tidak">
                                        <input type="hidden" name="preparat_pkbp" id="to_preparat_pkbp" value="">
                                        <input type="hidden" name="jenis_pkbp" id="to_jenis_pkbp" value="">
                                        <input type="hidden" name="lainnya_pkbp" id="to_lainnya_pkbp" value="">
                                        <input type="hidden" name="tekanan_darah_ttv_so" id="to_tekanan_darah_ttv_so" value="">
                                        <input type="hidden" name="nadi_ttv_so" id="to_nadi_ttv_so" value="0">
                                        <input type="hidden" name="suhu_ttv_so" id="to_suhu_ttv_so" value="0">
                                        <input type="hidden" name="rr_ttv_so" id="to_rr_ttv_so" value="0">
                                        <input type="hidden" name="skalanyeri_ttv_so" id="to_skalanyeri_ttv_so" value="">
                                        <input type="hidden" name="rembesan_pklo" id="to_rembesan_pklo" value="">
                                        <input type="hidden" name="instruksi_khusus" id="to_instruksi_khusus" value="">
                                        <input type="hidden" name="petugas_so" id="to_petugas_so" value="">

                                        <div class="field-group">
                                            <div class="field-group-title">Jam Time Out</div>
                                            <div class="col-md-4 px-0">
                                                <input type="time" class="form-control form-control-sm" name="jam_timeout">
                                            </div>
                                        </div>

                                        <div class="field-group">
                                            <div class="field-group-title">Pemeriksaan TTV</div>
                                            <div class="row">
                                                <div class="col-md-3 mb-2">
                                                    <label style="font-size:0.8rem;">TD (mmHg)</label>
                                                    <input type="text" class="form-control form-control-sm" name="tekanan_darah_ttv_to" placeholder="120/80">
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label style="font-size:0.8rem;">N (x/mnt)</label>
                                                    <input type="number" class="form-control form-control-sm" name="nadi_ttv_to" placeholder="0">
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label style="font-size:0.8rem;">S (°C)</label>
                                                    <input type="number" step="0.1" class="form-control form-control-sm" name="suhu_ttv_to" placeholder="0">
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label style="font-size:0.8rem;">RR (x/mnt)</label>
                                                    <input type="number" class="form-control form-control-sm" name="rr_ttv_to" placeholder="0">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="field-group">
                                            <div class="field-group-title">Kelengkapan Tim dan Fasilitas Operasi</div>
                                            <div class="d-flex" style="gap:20px; margin-bottom:6px;">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="kelengkapantim_ktdfo" id="to_ktdfo_lengkap" value="lengkap">
                                                    <label class="form-check-label" for="to_ktdfo_lengkap" style="font-size:0.82rem;">Lengkap</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="kelengkapantim_ktdfo" id="to_ktdfo_tidak" value="tidak_lengkap">
                                                    <label class="form-check-label" for="to_ktdfo_tidak" style="font-size:0.82rem;">Tidak Lengkap, Karena:</label>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" name="alasan_tdklengkap_ktdfo" id="to_alasan_ktdfo" placeholder="Alasan tidak lengkap..." style="display:none;">
                                        </div>

                                        <div class="field-group">
                                            <div class="field-group-title">Pemeriksaan Kelengkapan Peralatan Operasi</div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="istrument_pkpo" id="to_chk_instrument" value="ya">
                                                        <label class="form-check-label" for="to_chk_instrument" style="font-size:0.82rem;">Instrumen</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="kassa_pkpo" id="to_chk_kassa" value="ya">
                                                        <label class="form-check-label" for="to_chk_kassa" style="font-size:0.82rem;">Kassa</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="jarum_pkpo" id="to_chk_jarum" value="ya">
                                                        <label class="form-check-label" for="to_chk_jarum" style="font-size:0.82rem;">Jarum</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="field-group">
                                            <div class="field-group-title">Baca Secara Verbal</div>
                                            <div class="row">
                                                <div class="col-md-6 mb-1">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="tgl_tindakan_bsv" value="ya">
                                                        <label class="form-check-label" style="font-size:0.82rem;">Tanggal Tindakan</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-1">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="nama_tindakan_bsv" value="ya">
                                                        <label class="form-check-label" style="font-size:0.82rem;">Nama Tindakan</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-1">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="lokasi_tindakan_bsv" value="ya">
                                                        <label class="form-check-label" style="font-size:0.82rem;">Lokasi Tindakan</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-1">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="identitas_pasien_bsv" value="ya">
                                                        <label class="form-check-label" style="font-size:0.82rem;">Identitas Pasien</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-1">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="prosedur_tindakan_bsv" value="ya">
                                                        <label class="form-check-label" style="font-size:0.82rem;">Prosedur Tindakan</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-1">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="informed_consent_bsv" value="ya">
                                                        <label class="form-check-label" style="font-size:0.82rem;">Informed Consent</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="field-group">
                                            <div class="field-group-title">Antibiotik Profilaksis <small class="text-muted font-weight-normal">(diberikan &lt; 60 menit)</small></div>
                                            <div class="d-flex" style="gap:20px; margin-bottom:8px;">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="diberikan_kurang_dari60menit_ap" id="to_ab_ya" value="ya">
                                                    <label class="form-check-label" for="to_ab_ya" style="font-size:0.82rem;">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="diberikan_kurang_dari60menit_ap" id="to_ab_tidak" value="tidak">
                                                    <label class="form-check-label" for="to_ab_tidak" style="font-size:0.82rem;">Tidak</label>
                                                </div>
                                            </div>
                                            <div id="to_detail_antibiotik" style="display:none;">
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <label style="font-size:0.8rem;">Nama Obat</label>
                                                        <input type="text" class="form-control form-control-sm" name="nama_obat_ap" placeholder="Nama obat">
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label style="font-size:0.8rem;">Dosis Obat</label>
                                                        <input type="text" class="form-control form-control-sm" name="dosis_obat_ap" placeholder="Dosis">
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label style="font-size:0.8rem;">Jam Diberikan</label>
                                                        <input type="time" class="form-control form-control-sm" name="jam_diberikan_ap">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between mt-3">
                                            <button type="submit" class="btn btn-warning text-white" id="btn_submit_timeout">
                                                <i class="fas fa-save mr-1"></i> Simpan Time Out &amp; Lanjut ke Sign Out
                                                <i class="fas fa-arrow-right ml-1"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- ===== SIGN OUT ===== -->
                            <div class="fase-panel" id="panel-signout">
                                <div class="fase-body">
                                    <form id="form_signout" autocomplete="off">
                                        <input type="hidden" name="fase" value="signout">
                                        <input type="hidden" name="no_registrasi" id="signout_no_registrasi">
                                        <input type="hidden" name="tgl_tindakan" id="so_tgl_tindakan">
                                        <input type="hidden" name="jenis_tindakan" id="so_jenis_tindakan">
                                        <input type="hidden" name="diagnosa" id="so_diagnosa">
                                        <input type="hidden" name="jenis_anastesi" id="so_jenis_anastesi">
                                        <input type="hidden" name="obat_anastesi" id="so_obat_anastesi">
                                        <input type="hidden" name="dokter_operator" id="so_dokter_operator">
                                        <input type="hidden" name="jam_signin" id="so_jam_signin">
                                        <input type="hidden" name="identitas_pasien_verifikasi" id="so_identitas_pasien_verifikasi">
                                        <input type="hidden" name="informed_consent_verifikasi" id="so_informed_consent_verifikasi">
                                        <input type="hidden" name="tanda_lokasi_operasi" id="so_tanda_lokasi_operasi">
                                        <input type="hidden" name="diagnosa_pasien" id="so_diagnosa_pasien">
                                        <input type="hidden" name="tekanan_darah_ttv_si" id="so_tekanan_darah_ttv_si">
                                        <input type="hidden" name="nadi_ttv_si" id="so_nadi_ttv_si">
                                        <input type="hidden" name="suhu_ttv_si" id="so_suhu_ttv_si">
                                        <input type="hidden" name="rr_ttv_si" id="so_rr_ttv_si">
                                        <input type="hidden" name="riwayat_alergi_ra" id="so_riwayat_alergi_ra">
                                        <input type="hidden" name="sebutkan_ra" id="so_sebutkan_ra">
                                        <input type="hidden" name="resikoaspirasi_ganguanpernafasan" id="so_resikoaspirasi">
                                        <input type="hidden" name="resiko_perdarahan" id="so_resiko_perdarahan">
                                        <input type="hidden" name="petugas_si" id="so_petugas_si">
                                        <input type="hidden" name="jam_timeout" id="so_jam_timeout">
                                        <input type="hidden" name="kelengkapantim_ktdfo" id="so_kelengkapantim_ktdfo">
                                        <input type="hidden" name="alasan_tdklengkap_ktdfo" id="so_alasan_tdklengkap_ktdfo">
                                        <input type="hidden" name="istrument_pkpo" id="so_istrument_pkpo">
                                        <input type="hidden" name="kassa_pkpo" id="so_kassa_pkpo">
                                        <input type="hidden" name="jarum_pkpo" id="so_jarum_pkpo">
                                        <input type="hidden" name="tgl_tindakan_bsv" id="so_tgl_tindakan_bsv">
                                        <input type="hidden" name="nama_tindakan_bsv" id="so_nama_tindakan_bsv">
                                        <input type="hidden" name="lokasi_tindakan_bsv" id="so_lokasi_tindakan_bsv">
                                        <input type="hidden" name="identitas_pasien_bsv" id="so_identitas_pasien_bsv">
                                        <input type="hidden" name="prosedur_tindakan_bsv" id="so_prosedur_tindakan_bsv">
                                        <input type="hidden" name="informed_consent_bsv" id="so_informed_consent_bsv">
                                        <input type="hidden" name="diberikan_kurang_dari60menit_ap" id="so_diberikan_ap">
                                        <input type="hidden" name="nama_obat_ap" id="so_nama_obat_ap">
                                        <input type="hidden" name="dosis_obat_ap" id="so_dosis_obat_ap">
                                        <input type="hidden" name="jam_diberikan_ap" id="so_jam_diberikan_ap">
                                        <input type="hidden" name="petugas_to" id="so_petugas_to">
                                        <input type="hidden" name="tekanan_darah_ttv_to" id="so_tekanan_darah_ttv_to" value="">
                                        <input type="hidden" name="nadi_ttv_to" id="so_nadi_ttv_to" value="0">
                                        <input type="hidden" name="suhu_ttv_to" id="so_suhu_ttv_to" value="0">
                                        <input type="hidden" name="rr_ttv_to" id="so_rr_ttv_to" value="0">

                                        <div class="field-group">
                                            <div class="field-group-title">Jam Sign Out</div>
                                            <div class="col-md-4 px-0">
                                                <input type="time" class="form-control form-control-sm" name="jam_signout">
                                            </div>
                                        </div>

                                        <div class="field-group">
                                            <div class="field-group-title">Pemeriksaan Kelengkapan Sebelum Luka Ditutup</div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="istrument_pkslod" id="so_chk_instrument" value="ya">
                                                        <label class="form-check-label" for="so_chk_instrument" style="font-size:0.82rem;">Instrumen</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="kassa_pkslod" id="so_chk_kassa" value="ya">
                                                        <label class="form-check-label" for="so_chk_kassa" style="font-size:0.82rem;">Kassa</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="jarum_pkslod" id="so_chk_jarum" value="ya">
                                                        <label class="form-check-label" for="so_chk_jarum" style="font-size:0.82rem;">Jarum</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="field-group">
                                            <div class="field-group-title">Pemeriksaan Kelengkapan Bahan Pemeriksaan</div>
                                            <p class="mb-1" style="font-size:0.8rem; font-weight:600;">• Preparat</p>
                                            <div class="d-flex" style="gap:20px; margin-bottom:8px; padding-left:10px;">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="preparat_pkbp" id="so_preparat_ya" value="ya">
                                                    <label class="form-check-label" for="so_preparat_ya" style="font-size:0.82rem;">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="preparat_pkbp" id="so_preparat_tidak" value="tidak">
                                                    <label class="form-check-label" for="so_preparat_tidak" style="font-size:0.82rem;">Tidak</label>
                                                </div>
                                            </div>
                                            <p class="mb-1" style="font-size:0.8rem; font-weight:600;">• Jenis</p>
                                            <div class="row pl-2">
                                                <div class="col-md-8">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="jenis_pkbp" id="so_jenis_pa" value="PA">
                                                        <label class="form-check-label" for="so_jenis_pa" style="font-size:0.82rem;">PA</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="jenis_pkbp" id="so_jenis_kultur" value="Kultur">
                                                        <label class="form-check-label" for="so_jenis_kultur" style="font-size:0.82rem;">Kultur</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="jenis_pkbp" id="so_jenis_sitologi" value="Sitologi">
                                                        <label class="form-check-label" for="so_jenis_sitologi" style="font-size:0.82rem;">Sitologi</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="jenis_pkbp" id="so_jenis_tidak_ada" value="Tidak ada">
                                                        <label class="form-check-label" for="so_jenis_tidak_ada" style="font-size:0.82rem;">Tidak Ada</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="jenis_pkbp" id="so_jenis_lainnya" value="Lainnya">
                                                        <label class="form-check-label" for="so_jenis_lainnya" style="font-size:0.82rem;">Lainnya:</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control form-control-sm" name="lainnya_pkbp" id="so_lainnya_pkbp_input" placeholder="Sebutkan..." style="display:none;">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="field-group">
                                            <div class="field-group-title">Pemeriksaan TTV</div>
                                            <div class="row">
                                                <div class="col-md-3 mb-2">
                                                    <label style="font-size:0.8rem;">TD (mmHg)</label>
                                                    <input type="text" class="form-control form-control-sm" name="tekanan_darah_ttv_so" placeholder="120/80">
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <label style="font-size:0.8rem;">N (x/mnt)</label>
                                                    <input type="number" class="form-control form-control-sm" name="nadi_ttv_so" placeholder="0">
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <label style="font-size:0.8rem;">S (°C)</label>
                                                    <input type="number" step="0.1" class="form-control form-control-sm" name="suhu_ttv_so" placeholder="0">
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <label style="font-size:0.8rem;">RR (x/mnt)</label>
                                                    <input type="number" class="form-control form-control-sm" name="rr_ttv_so" placeholder="0">
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label style="font-size:0.8rem;">Skala Nyeri</label>
                                                    <input type="text" class="form-control form-control-sm" name="skalanyeri_ttv_so" placeholder="Skala nyeri">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="field-group">
                                            <div class="field-group-title">Pemeriksaan Kembali Luka Operasi</div>
                                            <div class="d-flex" style="gap:20px;">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="rembesan_pklo" id="so_rembesan_ada" value="ada">
                                                    <label class="form-check-label" for="so_rembesan_ada" style="font-size:0.82rem;">Ada Rembesan</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="rembesan_pklo" id="so_rembesan_tidak" value="tidak_ada">
                                                    <label class="form-check-label" for="so_rembesan_tidak" style="font-size:0.82rem;">Tidak Ada Rembesan</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="field-group">
                                            <div class="field-group-title">Instruksi Khusus</div>
                                            <textarea class="form-control form-control-sm" name="instruksi_khusus" rows="3" placeholder="Instruksi khusus..."></textarea>
                                        </div>

                                        <div class="d-flex justify-content-between mt-3">
                                            <button type="submit" class="btn btn-danger" id="btn_submit_signout">
                                                <i class="fas fa-save mr-1"></i> Simpan Sign Out &amp; Selesai
                                                <i class="fas fa-check ml-1"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div id="viewdatasurgical" class="mt-3"></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
<?= $this->endSection('content'); ?>

<?= $this->section('control-sidebar'); ?>
<aside class="control-sidebar control-sidebar-dark" style="height:100vh;">
    <div class="p-1 control-sidebar-content" style="height:602px; overflow-y:auto;">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="card-title">Daftar Pasien</h3>
            </div>
            <div class="card-body p-0"><span id="viewdata"></span></div>
        </div>
    </div>
</aside>
<?= $this->endSection('control-sidebar'); ?>

<?= $this->section('script'); ?>
<script>
    $(document).prop("title", $('p#active-menu').html());

    var sessionUsrId = "<?= (string)(session('usr_id') ?? '') ?>";
    var sessionUsrName = "<?= trim((string)(session('emp_nm') ?? session('fullname') ?? session('usr_id') ?? '')) ?>";
    console.log('sessionUsrName:', sessionUsrName);
    var currentData = null;
    var faseDone = '';

    function isSameUser(storedName, currentName) {
        if (!storedName || !currentName) return false;
        return String(storedName).trim().toLowerCase() === String(currentName).trim().toLowerCase();
    }

    function toISODateTime(val) {
        if (!val) return '';
        val = String(val).trim();
        if (val === '') return '';
        if (val.indexOf('T') !== -1) return val;
        if (/^\d{4}-\d{2}-\d{2}$/.test(val)) return val + 'T00:00:00';
        return val;
    }

    function checkAndEnableButtons() {
        $('#btn_signin_panel, #btn_timeout_panel, #btn_signout_panel')
            .prop('disabled', false)
            .removeClass('disabled');
    }

    function showPanel(fase) {
        $('.fase-panel').removeClass('active');
        $('#panel-' + fase).addClass('active');

        $('#btn_signin_panel, #btn_timeout_panel, #btn_signout_panel')
            .removeClass('btn-nav-active');

        $('#btn_' + fase + '_panel')
            .addClass('btn-nav-active');

        $('html, body').animate({
            scrollTop: 0
        }, 300);
    }

    function tregistrasi() {
        $.ajax({
            method: "GET",
            url: "<?= site_url('surgicalsafety/fetchAll'); ?>",
            success: function(data) {
                $('#viewdata').html(data);
            },
            error: function(xhr) {
                console.error('fetchAll error:', xhr.responseText);
            }
        });
    }

    function applyLockPerTab(data) {
        $('.lock-message').remove();

        var hasSI = (data.jam_signin && data.jam_signin !== '') || (data.petugas_si && data.petugas_si !== '');
        if (hasSI && !isSameUser(data.petugas_si, sessionUsrName)) {
            $('#panel-signin').find('input, select, textarea, button[type="submit"]').prop('disabled', true);
            $('#panel-signin button[type="submit"]').hide();
            $('#panel-signin').prepend('<div class="alert alert-warning lock-message"><i class="fas fa-lock mr-1"></i> Sign In telah diisi oleh ' + data.petugas_si + '. Anda tidak dapat mengubahnya.</div>');
        } else if (hasSI && isSameUser(data.petugas_si, sessionUsrName)) {
            $('#panel-signin').find('input, select, textarea, button[type="submit"]').prop('disabled', false);
            $('#panel-signin button[type="submit"]').show();
        } else {
            $('#panel-signin').find('input, select, textarea, button[type="submit"]').prop('disabled', false);
            $('#panel-signin button[type="submit"]').show();
        }

        var hasTO = (data.jam_timeout && data.jam_timeout !== '') || (data.petugas_to && data.petugas_to !== '');
        if (hasTO && !isSameUser(data.petugas_to, sessionUsrName)) {
            $('#panel-timeout').find('input, select, textarea, button[type="submit"]').prop('disabled', true);
            $('#panel-timeout button[type="submit"]').hide();
            $('#panel-timeout').prepend('<div class="alert alert-warning lock-message"><i class="fas fa-lock mr-1"></i> Time Out telah diisi oleh ' + data.petugas_to + '. Anda tidak dapat mengubahnya.</div>');
        } else if (hasTO && isSameUser(data.petugas_to, sessionUsrName)) {
            $('#panel-timeout').find('input, select, textarea, button[type="submit"]').prop('disabled', false);
            $('#panel-timeout button[type="submit"]').show();
        } else {
            $('#panel-timeout').find('input, select, textarea, button[type="submit"]').prop('disabled', false);
            $('#panel-timeout button[type="submit"]').show();
        }

        var hasSO = (data.jam_signout && data.jam_signout !== '') || (data.petugas_so && data.petugas_so !== '');
        if (hasSO && !isSameUser(data.petugas_so, sessionUsrName)) {
            $('#panel-signout').find('input, select, textarea, button[type="submit"]').prop('disabled', true);
            $('#panel-signout button[type="submit"]').hide();
            $('#panel-signout').prepend('<div class="alert alert-warning lock-message"><i class="fas fa-lock mr-1"></i> Sign Out telah diisi oleh ' + data.petugas_so + '. Anda tidak dapat mengubahnya.</div>');
        } else if (hasSO && isSameUser(data.petugas_so, sessionUsrName)) {
            $('#panel-signout').find('input, select, textarea, button[type="submit"]').prop('disabled', false);
            $('#panel-signout button[type="submit"]').show();
        } else {
            $('#panel-signout').find('input, select, textarea, button[type="submit"]').prop('disabled', false);
            $('#panel-signout button[type="submit"]').show();
        }
    }

    function fetchSurgicalData(callback) {
        var no_reg = $('#f_no_registrasi').val();
        if (!no_reg) return;

        $.ajax({
            url: "<?= site_url('surgicalsafety/fetchByRegistrasi'); ?>",
            method: "GET",
            cache: false,
            data: {
                no_registrasi: no_reg
            },
            dataType: "JSON",
            success: function(resp) {
                currentData = resp.data || null;
                if (currentData) {
                    console.log('petugas_si:', currentData.petugas_si);
                    console.log('sessionUsrName:', sessionUsrName);
                    console.log('isSameUser result:', isSameUser(currentData.petugas_si, sessionUsrName));
                    $('#f_is_edit').val('1');
                    $('#signin_is_edit').val('1');
                    determineFaseDone(currentData);
                    populateAllForms(currentData);

                    applyLockPerTab(currentData);

                    if (faseDone === 'signout') {
                        showPanel('signout');
                    } else if (faseDone === 'timeout') {
                        showPanel('signout');
                    } else if (faseDone === 'signin') {
                        showPanel('timeout');
                    } else {
                        showPanel('signin');
                    }
                } else {
                    $('#f_is_edit').val('0');
                    $('#signin_is_edit').val('0');
                    faseDone = '';
                    showPanel('signin');
                    $('#form_signin')[0].reset();
                    $('#form_timeout')[0].reset();
                    $('#form_signout')[0].reset();
                    $('#si_sebutkan_ra, #to_alasan_ktdfo, #to_detail_antibiotik, #so_lainnya_pkbp_input').hide();
                    $('.fase-panel').find('input, select, textarea, button[type="submit"]').prop('disabled', false);
                    $('.fase-panel button[type="submit"]').show();
                    $('.lock-message').remove();
                }
                checkAndEnableButtons();
                if (typeof callback === 'function') callback();
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Gagal memuat data.'
                });
            }
        });
    }

    function determineFaseDone(d) {
        var hasSI = (d.jam_signin && d.jam_signin !== '') || (d.petugas_si && d.petugas_si !== '');
        var hasTO = (d.jam_timeout && d.jam_timeout !== '') || (d.petugas_to && d.petugas_to !== '');
        var hasSO = (d.jam_signout && d.jam_signout !== '') || (d.petugas_so && d.petugas_so !== '');

        if (hasSO) faseDone = 'signout';
        else if (hasTO) faseDone = 'timeout';
        else if (hasSI) faseDone = 'signin';
        else faseDone = '';
    }

    function populateAllForms(d) {
        if (!d) return;

        var toHHmm = function(v) {
            if (!v) return '';
            return String(v).substring(0, 5);
        };
        var tglOnly = function(v) {
            if (!v) return '';
            return String(v).substring(0, 10);
        };

        function matchValue(actual, expected) {
            if (!actual) return false;
            actual = String(actual).toLowerCase().trim();
            expected = String(expected).toLowerCase().trim();
            if (expected === 'tidak_lengkap' && (actual === 'tidak_leng' || actual === 'tidak lengkap')) return true;
            return actual === expected;
        }

        // ========== SIGN IN ==========
        var fsi = $('#form_signin');
        fsi.find('[name="tgl_tindakan"]').val(tglOnly(d.tgl_tindakan));
        fsi.find('[name="jenis_tindakan"]').val(d.jenis_tindakan || '');
        fsi.find('[name="diagnosa"]').val(d.diagnosa || '');
        fsi.find('[name="jenis_anastesi"]').val(d.jenis_anastesi || '');
        fsi.find('[name="obat_anastesi"]').val(d.obat_anastesi || '');
        fsi.find('[name="dokter_operator"]').val(d.dokter_operator || '');
        fsi.find('[name="jam_signin"]').val(toHHmm(d.jam_signin));

        fsi.find('[name="identitas_pasien_verifikasi"]').prop('checked', matchValue(d.identitas_pasien_verifikasi, 'ya'));
        fsi.find('[name="informed_consent_verifikasi"]').prop('checked', matchValue(d.informed_consent_verifikasi, 'ya'));

        var lokasiVal = d.tanda_lokasi_operasi || '';
        fsi.find('input[name="tanda_lokasi_operasi"]').each(function() {
            $(this).prop('checked', matchValue(lokasiVal, $(this).val()));
        });

        fsi.find('[name="diagnosa_pasien"]').val(d.diagnosa_pasien || '');
        fsi.find('[name="tekanan_darah_ttv_si"]').val(d.tekanan_darah_ttv_si || '');
        fsi.find('[name="nadi_ttv_si"]').val(d.nadi_ttv_si ?? '');
        fsi.find('[name="suhu_ttv_si"]').val(d.suhu_ttv_si ?? '');
        fsi.find('[name="rr_ttv_si"]').val(d.rr_ttv_si ?? '');

        var alergiVal = d.riwayat_alergi_ra || '';
        fsi.find('input[name="riwayat_alergi_ra"]').each(function() {
            $(this).prop('checked', matchValue(alergiVal, $(this).val()));
        });
        var showAlergiInput = matchValue(alergiVal, 'ada');
        $('#si_sebutkan_ra').toggle(showAlergiInput);
        fsi.find('[name="sebutkan_ra"]').val(d.sebutkan_ra || '');

        var aspirasiVal = d.resikoaspirasi_ganguanpernafasan || '';
        fsi.find('input[name="resikoaspirasi_ganguanpernafasan"]').each(function() {
            $(this).prop('checked', matchValue(aspirasiVal, $(this).val()));
        });
        var perdarahanVal = d.resiko_perdarahan || '';
        fsi.find('input[name="resiko_perdarahan"]').each(function() {
            $(this).prop('checked', matchValue(perdarahanVal, $(this).val()));
        });

        // ========== TIME OUT ==========
        var fto = $('#form_timeout');
        fto.find('[name="jam_timeout"]').val(toHHmm(d.jam_timeout));
        fto.find('[name="tekanan_darah_ttv_to"]').val(d.tekanan_darah_ttv_to || '');
        fto.find('[name="nadi_ttv_to"]').val(d.nadi_ttv_to ?? '');
        fto.find('[name="suhu_ttv_to"]').val(d.suhu_ttv_to ?? '');
        fto.find('[name="rr_ttv_to"]').val(d.rr_ttv_to ?? '');

        var timVal = d.kelengkapantim_ktdfo || '';
        fto.find('input[name="kelengkapantim_ktdfo"]').each(function() {
            $(this).prop('checked', matchValue(timVal, $(this).val()));
        });
        var showAlasan = matchValue(timVal, 'tidak_lengkap');
        $('#to_alasan_ktdfo').toggle(showAlasan);
        fto.find('[name="alasan_tdklengkap_ktdfo"]').val(d.alasan_tdklengkap_ktdfo || '');

        fto.find('[name="istrument_pkpo"]').prop('checked', matchValue(d.istrument_pkpo, 'ya'));
        fto.find('[name="kassa_pkpo"]').prop('checked', matchValue(d.kassa_pkpo, 'ya'));
        fto.find('[name="jarum_pkpo"]').prop('checked', matchValue(d.jarum_pkpo, 'ya'));

        fto.find('[name="tgl_tindakan_bsv"]').prop('checked', matchValue(d.tgl_tindakan_bsv, 'ya'));
        fto.find('[name="nama_tindakan_bsv"]').prop('checked', matchValue(d.nama_tindakan_bsv, 'ya'));
        fto.find('[name="lokasi_tindakan_bsv"]').prop('checked', matchValue(d.lokasi_tindakan_bsv, 'ya'));
        fto.find('[name="identitas_pasien_bsv"]').prop('checked', matchValue(d.identitas_pasien_bsv, 'ya'));
        fto.find('[name="prosedur_tindakan_bsv"]').prop('checked', matchValue(d.prosedur_tindakan_bsv, 'ya'));
        fto.find('[name="informed_consent_bsv"]').prop('checked', matchValue(d.informed_consent_bsv, 'ya'));

        var abVal = d.diberikan_kurang_dari60menit_ap || '';
        fto.find('input[name="diberikan_kurang_dari60menit_ap"]').each(function() {
            $(this).prop('checked', matchValue(abVal, $(this).val()));
        });
        var showAntibiotik = matchValue(abVal, 'ya');
        $('#to_detail_antibiotik').toggle(showAntibiotik);
        fto.find('[name="nama_obat_ap"]').val(d.nama_obat_ap || '');
        fto.find('[name="dosis_obat_ap"]').val(d.dosis_obat_ap || '');
        fto.find('[name="jam_diberikan_ap"]').val(toHHmm(d.jam_diberikan_ap));

        // ========== SIGN OUT ==========
        var fso = $('#form_signout');
        fso.find('[name="jam_signout"]').val(toHHmm(d.jam_signout));

        fso.find('[name="istrument_pkslod"]').prop('checked', matchValue(d.istrument_pkslod, 'ya'));
        fso.find('[name="kassa_pkslod"]').prop('checked', matchValue(d.kassa_pkslod, 'ya'));
        fso.find('[name="jarum_pkslod"]').prop('checked', matchValue(d.jarum_pkslod, 'ya'));

        var preparatVal = d.preparat_pkbp || '';
        fso.find('input[name="preparat_pkbp"]').each(function() {
            $(this).prop('checked', matchValue(preparatVal, $(this).val()));
        });

        var jenisVal = d.jenis_pkbp || '';
        fso.find('input[name="jenis_pkbp"]').each(function() {
            $(this).prop('checked', matchValue(jenisVal, $(this).val()));
        });
        var showLainnya = matchValue(jenisVal, 'lainnya');
        $('#so_lainnya_pkbp_input').toggle(showLainnya);
        fso.find('[name="lainnya_pkbp"]').val(d.lainnya_pkbp || '');

        fso.find('[name="tekanan_darah_ttv_so"]').val(d.tekanan_darah_ttv_so || '');
        fso.find('[name="nadi_ttv_so"]').val(d.nadi_ttv_so ?? '');
        fso.find('[name="suhu_ttv_so"]').val(d.suhu_ttv_so ?? '');
        fso.find('[name="rr_ttv_so"]').val(d.rr_ttv_so ?? '');
        fso.find('[name="skalanyeri_ttv_so"]').val(d.skalanyeri_ttv_so || '');

        var rembesVal = d.rembesan_pklo || '';
        fso.find('input[name="rembesan_pklo"]').each(function() {
            $(this).prop('checked', matchValue(rembesVal, $(this).val()));
        });

        fso.find('[name="instruksi_khusus"]').val(d.instruksi_khusus || '');

        // ========== HIDDEN FIELDS ==========
        $('#to_tgl_tindakan').val(tglOnly(d.tgl_tindakan));
        $('#to_jenis_tindakan').val(d.jenis_tindakan || '');
        $('#to_diagnosa').val(d.diagnosa || '');
        $('#to_jenis_anastesi').val(d.jenis_anastesi || '');
        $('#to_obat_anastesi').val(d.obat_anastesi || '');
        $('#to_dokter_operator').val(d.dokter_operator || '');
        $('#to_jam_signin').val(toHHmm(d.jam_signin));
        $('#to_identitas_pasien_verifikasi').val(d.identitas_pasien_verifikasi || '');
        $('#to_informed_consent_verifikasi').val(d.informed_consent_verifikasi || '');
        $('#to_tanda_lokasi_operasi').val(d.tanda_lokasi_operasi || '');
        $('#to_diagnosa_pasien').val(d.diagnosa_pasien || '');
        $('#to_tekanan_darah_ttv_si').val(d.tekanan_darah_ttv_si || '');
        $('#to_nadi_ttv_si').val(d.nadi_ttv_si || 0);
        $('#to_suhu_ttv_si').val(d.suhu_ttv_si || 0);
        $('#to_rr_ttv_si').val(d.rr_ttv_si || 0);
        $('#to_riwayat_alergi_ra').val(d.riwayat_alergi_ra || '');
        $('#to_sebutkan_ra').val(d.sebutkan_ra || '');
        $('#to_resikoaspirasi').val(d.resikoaspirasi_ganguanpernafasan || '');
        $('#to_resiko_perdarahan').val(d.resiko_perdarahan || '');
        $('#to_petugas_si').val(d.petugas_si || '');
        $('#to_jam_signout').val(toHHmm(d.jam_signout));
        $('#to_istrument_pkslod').val(d.istrument_pkslod || 'tidak');
        $('#to_kassa_pkslod').val(d.kassa_pkslod || 'tidak');
        $('#to_jarum_pkslod').val(d.jarum_pkslod || 'tidak');
        $('#to_preparat_pkbp').val(d.preparat_pkbp || '');
        $('#to_jenis_pkbp').val(d.jenis_pkbp || '');
        $('#to_lainnya_pkbp').val(d.lainnya_pkbp || '');
        $('#to_tekanan_darah_ttv_so').val(d.tekanan_darah_ttv_so || '');
        $('#to_nadi_ttv_so').val(d.nadi_ttv_so || 0);
        $('#to_suhu_ttv_so').val(d.suhu_ttv_so || 0);
        $('#to_rr_ttv_so').val(d.rr_ttv_so || 0);
        $('#to_skalanyeri_ttv_so').val(d.skalanyeri_ttv_so || '');
        $('#to_rembesan_pklo').val(d.rembesan_pklo || '');
        $('#to_instruksi_khusus').val(d.instruksi_khusus || '');
        $('#to_petugas_so').val(d.petugas_so || '');

        $('#so_tgl_tindakan').val(tglOnly(d.tgl_tindakan));
        $('#so_jenis_tindakan').val(d.jenis_tindakan || '');
        $('#so_diagnosa').val(d.diagnosa || '');
        $('#so_jenis_anastesi').val(d.jenis_anastesi || '');
        $('#so_obat_anastesi').val(d.obat_anastesi || '');
        $('#so_dokter_operator').val(d.dokter_operator || '');
        $('#so_jam_signin').val(toHHmm(d.jam_signin));
        $('#so_identitas_pasien_verifikasi').val(d.identitas_pasien_verifikasi || '');
        $('#so_informed_consent_verifikasi').val(d.informed_consent_verifikasi || '');
        $('#so_tanda_lokasi_operasi').val(d.tanda_lokasi_operasi || '');
        $('#so_diagnosa_pasien').val(d.diagnosa_pasien || '');
        $('#so_tekanan_darah_ttv_si').val(d.tekanan_darah_ttv_si || '');
        $('#so_nadi_ttv_si').val(d.nadi_ttv_si || 0);
        $('#so_suhu_ttv_si').val(d.suhu_ttv_si || 0);
        $('#so_rr_ttv_si').val(d.rr_ttv_si || 0);
        $('#so_riwayat_alergi_ra').val(d.riwayat_alergi_ra || '');
        $('#so_sebutkan_ra').val(d.sebutkan_ra || '');
        $('#so_resikoaspirasi').val(d.resikoaspirasi_ganguanpernafasan || '');
        $('#so_resiko_perdarahan').val(d.resiko_perdarahan || '');
        $('#so_petugas_si').val(d.petugas_si || '');
        $('#so_jam_timeout').val(toHHmm(d.jam_timeout));
        $('#so_kelengkapantim_ktdfo').val(d.kelengkapantim_ktdfo || '');
        $('#so_alasan_tdklengkap_ktdfo').val(d.alasan_tdklengkap_ktdfo || '');
        $('#so_istrument_pkpo').val(d.istrument_pkpo || 'tidak');
        $('#so_kassa_pkpo').val(d.kassa_pkpo || 'tidak');
        $('#so_jarum_pkpo').val(d.jarumbsp_pkpo || 'tidak');
        $('#so_tgl_tindakan_bsv').val(matchValue(d.tgl_tindakan_bsv, 'ya') ? 'ya' : 'tidak');
        $('#so_nama_tindakan_bsv').val(matchValue(d.nama_tindakan_bsv, 'ya') ? 'ya' : 'tidak');
        $('#so_lokasi_tindakan_bsv').val(matchValue(d.lokasi_tindakan_bsv, 'ya') ? 'ya' : 'tidak');
        $('#so_identitas_pasien_bsv').val(matchValue(d.identitas_pasien_bsv, 'ya') ? 'ya' : 'tidak');
        $('#so_prosedur_tindakan_bsv').val(matchValue(d.prosedur_tindakan_bsv, 'ya') ? 'ya' : 'tidak');
        $('#so_informed_consent_bsv').val(matchValue(d.informed_consent_bsv, 'ya') ? 'ya' : 'tidak');
        $('#so_diberikan_ap').val(d.diberikan_kurang_dari60menit_ap || '');
        $('#so_nama_obat_ap').val(d.nama_obat_ap || '');
        $('#so_dosis_obat_ap').val(d.dosis_obat_ap || '');
        $('#so_jam_diberikan_ap').val(toHHmm(d.jam_diberikan_ap));
        $('#so_petugas_to').val(d.petugas_to || '');
        $('#so_tekanan_darah_ttv_to').val(d.tekanan_darah_ttv_to || '');
        $('#so_nadi_ttv_to').val(d.nadi_ttv_to || 0);
        $('#so_suhu_ttv_to').val(d.suhu_ttv_to || 0);
        $('#so_rr_ttv_to').val(d.rr_ttv_to || 0);
    }

    function submitFase(formId, btnId, successCb) {
        var $form = $('#' + formId);
        var $btn = $('#' + btnId);
        var no_reg = $('#f_no_registrasi').val();
        if (!no_reg) {
            Swal.fire({
                icon: 'warning',
                title: 'Pilih pasien terlebih dahulu.'
            });
            return;
        }

        $form.find('[name="no_registrasi"]').val(no_reg);

        var checkboxNames = {
            'form_signin': ['identitas_pasien_verifikasi', 'informed_consent_verifikasi'],
            'form_timeout': ['istrument_pkpo', 'kassa_pkpo', 'jarum_pkpo',
                'tgl_tindakan_bsv', 'nama_tindakan_bsv', 'lokasi_tindakan_bsv',
                'identitas_pasien_bsv', 'prosedur_tindakan_bsv', 'informed_consent_bsv'
            ],
            'form_signout': ['istrument_pkslod', 'kassa_pkslod', 'jarum_pkslod'],
        };

        var formData = $form.serializeArray();

        if (formId === 'form_signin') {
            var extraData = $('#form_signout').serializeArray();
            var excludeFields = ['petugas_si', 'petugas_to', 'petugas_so', 'fase'];
            extraData = extraData.filter(function(item) {
                return excludeFields.indexOf(item.name) === -1;
            });
            extraData.forEach(function(item) {
                if (!formData.some(function(f) {
                        return f.name === item.name;
                    })) {
                    formData.push(item);
                }
            });
        }

        formData = formData.map(function(field) {
            if (field.name === 'tgl_tindakan' && field.value) {
                field.value = toISODateTime(field.value);
            }
            return field;
        });

        (checkboxNames[formId] || []).forEach(function(name) {
            if (!formData.some(function(f) {
                    return f.name === name;
                })) {
                formData.push({
                    name: name,
                    value: 'tidak'
                });
            }
        });

        $.ajax({
            url: "<?= site_url('surgicalsafety/action'); ?>",
            method: "POST",
            data: $.param(formData),
            dataType: "JSON",
            beforeSend: function() {
                $btn.prop('disabled', true).prepend('<i class="fa fa-spin fa-spinner mr-1"></i>');
            },
            complete: function() {
                $btn.prop('disabled', false).find('.fa-spin').remove();
            },
            success: function(response) {
                if (response.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.error
                    });
                } else if (response.success) {
                    faseDone = response.fase;
                    $('#f_is_edit').val('1');
                    $('#signin_is_edit').val('1');
                    if (typeof successCb === 'function') successCb(response.fase);
                    fetchSurgicalData();
                }
            },
            error: function(xhr) {
                var msg = 'Tidak dapat menghubungi server.';
                try {
                    var r = JSON.parse(xhr.responseText);
                    if (r.message) msg = r.message;
                } catch (e) {}
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: msg
                });
            }
        });
    }

    function printSurgical(no_registrasi, nama_pasien, no_rm, tgl_lahir, gender) {
        window.open(
            '<?= base_url("surgicalsafety/printSurgical") ?>?no_registrasi=' + no_registrasi +
            '&nama_pasien=' + encodeURIComponent(nama_pasien) +
            '&no_rm=' + encodeURIComponent(no_rm) +
            '&tgl_lahir=' + encodeURIComponent(tgl_lahir) +
            '&gender=' + encodeURIComponent(gender),
            '_blank'
        );
    }

    function autofillTTVFromPemeriksaanAwal(no_registrasi) {
        // Jangan timpa kalau Sign In sudah pernah diisi sebelumnya
        if (currentData && currentData.jam_signin) {
            return;
        }

        $.ajax({
            url: "<?= site_url('pemeriksaanawal/fetchPemeriksaanAwalByRegistrasi'); ?>",
            method: "GET",
            data: {
                no_registrasi: no_registrasi
            },
            dataType: "JSON",
            success: function(response) {
                if (response.status === 'success' && response.data) {
                    var d = response.data;
                    var $fsi = $('#form_signin');

                    if (!$fsi.find('[name="tekanan_darah_ttv_si"]').val() && d.sistolik && d.diastolik) {
                        $fsi.find('[name="tekanan_darah_ttv_si"]').val(d.sistolik + '/' + d.diastolik);
                    }
                    if (!$fsi.find('[name="nadi_ttv_si"]').val() && d.nadi) {
                        $fsi.find('[name="nadi_ttv_si"]').val(d.nadi);
                    }
                    if (!$fsi.find('[name="suhu_ttv_si"]').val() && d.suhu) {
                        $fsi.find('[name="suhu_ttv_si"]').val(d.suhu);
                    }
                    if (!$fsi.find('[name="rr_ttv_si"]').val() && d.laju_nafas) {
                        $fsi.find('[name="rr_ttv_si"]').val(d.laju_nafas);
                    }
                }
            },
            error: function(xhr) {
                console.log('[surgicalsafety-pemeriksaanawal] gagal, status:', xhr.status, xhr.responseText);
            }
        });
    }

    function autofillAlergiFromPemeriksaanAwal(patient_no) {
        // Jangan timpa kalau Sign In sudah pernah diisi/tersimpan sebelumnya
        if (currentData && currentData.jam_signin) {
            return;
        }
        // Jangan timpa kalau user sudah pilih radio alergi secara manual
        if ($('#form_signin input[name="riwayat_alergi_ra"]:checked').length > 0) {
            return;
        }

        $.ajax({
            url: "<?= site_url('pemeriksaanawal/apiDataGetAlergiByPasien'); ?>",
            method: "GET",
            data: {
                patient_no: patient_no
            },
            dataType: "JSON",
            success: function(data) {
                if (data && data.length > 0) {
                    var deskripsi = data.map(function(a) {
                        var parts = [];
                        if (a.kategori_desc) parts.push(a.kategori_desc);
                        else if (a.kategori) parts.push(a.kategori);

                        if (a.komponen_desc) parts.push(a.komponen_desc);
                        else if (a.komponen) parts.push(a.komponen);

                        if (a.keterangan) parts.push('(' + a.keterangan + ')');

                        return parts.join(' - ');
                    }).filter(Boolean).join('; ');

                    $('#si_alergi_ada').prop('checked', true);
                    $('#si_sebutkan_ra').show().val(deskripsi);
                } else {
                    $('#si_alergi_tidak').prop('checked', true);
                    $('#si_sebutkan_ra').hide().val('');
                }
            },
            error: function(xhr) {
                console.log('[surgicalsafety-alergi] gagal, status:', xhr.status, xhr.responseText);
            }
        });
    }

    $(document).ready(function() {
        tregistrasi();
        if (!$('body').hasClass('control-sidebar-slide-open')) {
            $('#toggle-sidebar-pasien').trigger('click');
        }

        $('#btn_signin_panel').on('click', function() {
            showPanel('signin');
        });
        $('#btn_timeout_panel').on('click', function() {
            showPanel('timeout');
        });
        $('#btn_signout_panel').on('click', function() {
            showPanel('signout');
        });

        $('input[name="riwayat_alergi_ra"]').on('change', function() {
            $('#si_sebutkan_ra').toggle($(this).val() === 'ada');
        });
        $('input[name="kelengkapantim_ktdfo"]').on('change', function() {
            $('#to_alasan_ktdfo').toggle($(this).val() === 'tidak_lengkap');
        });
        $('input[name="diberikan_kurang_dari60menit_ap"]').on('change', function() {
            $('#to_detail_antibiotik').toggle($(this).val() === 'ya');
        });
        $('input[name="jenis_pkbp"]').on('change', function() {
            $('#so_lainnya_pkbp_input').toggle($(this).val() === 'Lainnya');
        });

        $('#btn_refresh').on('click', function() {
            var no_reg = $('#f_no_registrasi').val();
            if (!no_reg) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Pilih pasien terlebih dahulu.'
                });
                return;
            }
            var $btn = $(this);
            var originalText = $btn.html();
            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Refreshing...');
            fetchSurgicalData(function() {
                $btn.prop('disabled', false).html(originalText);
            });
        });

        $('#btn_cetak').on('click', function() {
            var no_reg = $('#f_no_registrasi').val();
            if (!no_reg) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Pilih pasien terlebih dahulu.'
                });
                return;
            }
            var params = new URLSearchParams({
                no_rm: $('#medrec_id_info').text().trim(),
                nama_pasien: $('#fullname_tm').text().trim(),
                tgl_lahir: $('#birth_dt_tm').text().trim(),
                gender: $('#gender_tm').text().trim()
            });
            window.open("<?= site_url('surgicalsafety/printSurgical'); ?>/" + no_reg + '?' + params.toString(), '_blank');
        });

        $('#form_signin').on('submit', function(e) {
            e.preventDefault();
            if (currentData && currentData.jam_signin && !isSameUser(currentData.petugas_si, sessionUsrName)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Akses Ditolak',
                    text: 'Sign In telah diisi oleh ' + currentData.petugas_si + '. Anda tidak dapat mengubahnya.'
                });
                return;
            }

            if (currentData) {
                $('#signin_is_edit').val('1');
                $('#f_is_edit').val('1');
            } else {
                $('#signin_is_edit').val('0');
                $('#f_is_edit').val('0');
            }

            var fsi = document.getElementById('form_signin');
            var tglVal = $(fsi).find('[name="tgl_tindakan"]').val();
            var tglISO = tglVal ? tglVal + 'T00:00:00' : '';

            var siData = {
                tgl_tindakan: tglISO,
                jenis_tindakan: $(fsi).find('[name="jenis_tindakan"]').val(),
                diagnosa: $(fsi).find('[name="diagnosa"]').val(),
                jenis_anastesi: $(fsi).find('[name="jenis_anastesi"]').val(),
                obat_anastesi: $(fsi).find('[name="obat_anastesi"]').val(),
                dokter_operator: $(fsi).find('[name="dokter_operator"]').val(),
                jam_signin: $(fsi).find('[name="jam_signin"]').val(),
                identitas_pasien_verifikasi: $(fsi).find('[name="identitas_pasien_verifikasi"]').is(':checked') ? 'ya' : 'tidak',
                informed_consent_verifikasi: $(fsi).find('[name="informed_consent_verifikasi"]').is(':checked') ? 'ya' : 'tidak',
                tanda_lokasi_operasi: $(fsi).find('[name="tanda_lokasi_operasi"]:checked').val() || '',
                diagnosa_pasien: $(fsi).find('[name="diagnosa_pasien"]').val(),
                tekanan_darah_ttv_si: $(fsi).find('[name="tekanan_darah_ttv_si"]').val(),
                nadi_ttv_si: $(fsi).find('[name="nadi_ttv_si"]').val() || 0,
                suhu_ttv_si: $(fsi).find('[name="suhu_ttv_si"]').val() || 0,
                rr_ttv_si: $(fsi).find('[name="rr_ttv_si"]').val() || 0,
                riwayat_alergi_ra: $(fsi).find('[name="riwayat_alergi_ra"]:checked').val() || '',
                sebutkan_ra: $(fsi).find('[name="sebutkan_ra"]').val(),
                resikoaspirasi_ganguanpernafasan: $(fsi).find('[name="resikoaspirasi_ganguanpernafasan"]:checked').val() || '',
                resiko_perdarahan: $(fsi).find('[name="resiko_perdarahan"]:checked').val() || '',
            };

            $('#to_tgl_tindakan').val(siData.tgl_tindakan);
            $('#to_jenis_tindakan').val(siData.jenis_tindakan);
            $('#to_diagnosa').val(siData.diagnosa);
            $('#to_jenis_anastesi').val(siData.jenis_anastesi);
            $('#to_obat_anastesi').val(siData.obat_anastesi);
            $('#to_dokter_operator').val(siData.dokter_operator);
            $('#to_jam_signin').val(siData.jam_signin);
            $('#to_identitas_pasien_verifikasi').val(siData.identitas_pasien_verifikasi);
            $('#to_informed_consent_verifikasi').val(siData.informed_consent_verifikasi);
            $('#to_tanda_lokasi_operasi').val(siData.tanda_lokasi_operasi);
            $('#to_diagnosa_pasien').val(siData.diagnosa_pasien);
            $('#to_tekanan_darah_ttv_si').val(siData.tekanan_darah_ttv_si);
            $('#to_nadi_ttv_si').val(siData.nadi_ttv_si);
            $('#to_suhu_ttv_si').val(siData.suhu_ttv_si);
            $('#to_rr_ttv_si').val(siData.rr_ttv_si);
            $('#to_riwayat_alergi_ra').val(siData.riwayat_alergi_ra);
            $('#to_sebutkan_ra').val(siData.sebutkan_ra);
            $('#to_resikoaspirasi').val(siData.resikoaspirasi_ganguanpernafasan);
            $('#to_resiko_perdarahan').val(siData.resiko_perdarahan);

            $('#so_tgl_tindakan').val(siData.tgl_tindakan);
            $('#so_jenis_tindakan').val(siData.jenis_tindakan);
            $('#so_diagnosa').val(siData.diagnosa);
            $('#so_jenis_anastesi').val(siData.jenis_anastesi);
            $('#so_obat_anastesi').val(siData.obat_anastesi);
            $('#so_dokter_operator').val(siData.dokter_operator);
            $('#so_jam_signin').val(siData.jam_signin);
            $('#so_identitas_pasien_verifikasi').val(siData.identitas_pasien_verifikasi);
            $('#so_informed_consent_verifikasi').val(siData.informed_consent_verifikasi);
            $('#so_tanda_lokasi_operasi').val(siData.tanda_lokasi_operasi);
            $('#so_diagnosa_pasien').val(siData.diagnosa_pasien);
            $('#so_tekanan_darah_ttv_si').val(siData.tekanan_darah_ttv_si);
            $('#so_nadi_ttv_si').val(siData.nadi_ttv_si);
            $('#so_suhu_ttv_si').val(siData.suhu_ttv_si);
            $('#so_rr_ttv_si').val(siData.rr_ttv_si);
            $('#so_riwayat_alergi_ra').val(siData.riwayat_alergi_ra);
            $('#so_sebutkan_ra').val(siData.sebutkan_ra);
            $('#so_resikoaspirasi').val(siData.resikoaspirasi_ganguanpernafasan);
            $('#so_resiko_perdarahan').val(siData.resiko_perdarahan);

            submitFase('form_signin', 'btn_submit_signin', function() {
                faseDone = 'signin';
                checkAndEnableButtons();
                Swal.fire({
                        icon: 'success',
                        title: 'Sign In Tersimpan!',
                        text: 'Silakan lanjutkan ke Time Out.'
                    })
                    .then(function() {
                        showPanel('timeout');
                    });
            });
        });

        $('#form_timeout').on('submit', function(e) {
            e.preventDefault();
            if (currentData && currentData.jam_timeout && !isSameUser(currentData.petugas_to, sessionUsrName)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Akses Ditolak',
                    text: 'Time Out telah diisi oleh ' + currentData.petugas_to + '. Anda tidak dapat mengubahnya.'
                });
                return;
            }

            var fto = document.getElementById('form_timeout');

            $('#so_jam_timeout').val($(fto).find('[name="jam_timeout"]').val());
            $('#so_kelengkapantim_ktdfo').val($(fto).find('[name="kelengkapantim_ktdfo"]:checked').val() || '');
            $('#so_alasan_tdklengkap_ktdfo').val($(fto).find('[name="alasan_tdklengkap_ktdfo"]').val());
            $('#so_istrument_pkpo').val($(fto).find('[name="istrument_pkpo"]').is(':checked') ? 'ya' : 'tidak');
            $('#so_kassa_pkpo').val($(fto).find('[name="kassa_pkpo"]').is(':checked') ? 'ya' : 'tidak');
            $('#so_jarum_pkpo').val($(fto).find('[name="jarum_pkpo"]').is(':checked') ? 'ya' : 'tidak');
            $('#so_tgl_tindakan_bsv').val($(fto).find('[name="tgl_tindakan_bsv"]').is(':checked') ? 'ya' : 'tidak');
            $('#so_nama_tindakan_bsv').val($(fto).find('[name="nama_tindakan_bsv"]').is(':checked') ? 'ya' : 'tidak');
            $('#so_lokasi_tindakan_bsv').val($(fto).find('[name="lokasi_tindakan_bsv"]').is(':checked') ? 'ya' : 'tidak');
            $('#so_identitas_pasien_bsv').val($(fto).find('[name="identitas_pasien_bsv"]').is(':checked') ? 'ya' : 'tidak');
            $('#so_prosedur_tindakan_bsv').val($(fto).find('[name="prosedur_tindakan_bsv"]').is(':checked') ? 'ya' : 'tidak');
            $('#so_informed_consent_bsv').val($(fto).find('[name="informed_consent_bsv"]').is(':checked') ? 'ya' : 'tidak');
            $('#so_diberikan_ap').val($(fto).find('[name="diberikan_kurang_dari60menit_ap"]:checked').val() || '');
            $('#so_nama_obat_ap').val($(fto).find('[name="nama_obat_ap"]').val());
            $('#so_dosis_obat_ap').val($(fto).find('[name="dosis_obat_ap"]').val());
            $('#so_jam_diberikan_ap').val($(fto).find('[name="jam_diberikan_ap"]').val());
            $('#so_tekanan_darah_ttv_to').val($(fto).find('[name="tekanan_darah_ttv_to"]').val());
            $('#so_nadi_ttv_to').val($(fto).find('[name="nadi_ttv_to"]').val() || 0);
            $('#so_suhu_ttv_to').val($(fto).find('[name="suhu_ttv_to"]').val() || 0);
            $('#so_rr_ttv_to').val($(fto).find('[name="rr_ttv_to"]').val() || 0);
            $('#so_petugas_to').val('');

            submitFase('form_timeout', 'btn_submit_timeout', function() {
                faseDone = 'timeout';
                checkAndEnableButtons();
                Swal.fire({
                        icon: 'success',
                        title: 'Time Out Tersimpan!',
                        text: 'Silakan lanjutkan ke Sign Out.'
                    })
                    .then(function() {
                        showPanel('signout');
                    });
            });
        });

        $('#form_signout').on('submit', function(e) {
            e.preventDefault();
            if (currentData && currentData.jam_signout && !isSameUser(currentData.petugas_so, sessionUsrName)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Akses Ditolak',
                    text: 'Sign Out telah diisi oleh ' + currentData.petugas_so + '. Anda tidak dapat mengubahnya.'
                });
                return;
            }
            submitFase('form_signout', 'btn_submit_signout', function() {
                faseDone = 'signout';
                checkAndEnableButtons();
                Swal.fire({
                        icon: 'success',
                        title: 'Selesai!',
                        text: 'Surgical Safety Checklist lengkap tersimpan.'
                    })
                    .then(function() {
                        fetchSurgicalData();
                    });
            });
        });
    });

    $(document).on('click', '.pilihpasien', function() {
        var no_registrasi = $(this).data('no_registrasi');
        var patient_no = $(this).data('patient_no');
        var fullname = $(this).data('fullname');
        var birth_dt = $(this).data('birth_dt');
        var tahun = $(this).data('tahun');
        var bulan = $(this).data('bulan');
        var gender = $(this).data('gender');
        var nama_dokter = $(this).data('nama_dokter');
        var tujuan_registrasi_desc = $(this).data('tujuan_registrasi_desc');
        var type_pasien = $(this).data('type_pasien');
        var flag_alergi = $(this).data('flag_alergi');

        $.ajax({
            url: "<?= site_url('surgicalsafety/setNoRegistrasi'); ?>",
            method: "GET",
            data: {
                no_registrasi: no_registrasi,
                patient_no: patient_no
            }
        });

        $('#f_no_registrasi').val(no_registrasi);
        $('#f_medrec_id').val(patient_no);
        $('#signin_no_registrasi').val(no_registrasi);
        $('#timeout_no_registrasi').val(no_registrasi);
        $('#signout_no_registrasi').val(no_registrasi);

        var clean_birth_dt = '';
        if (birth_dt) {
            var dateOnly = String(birth_dt).split(' ')[0];
            var parts = dateOnly.split('/');
            if (parts.length === 3) {
                clean_birth_dt = parts[1] + '/' + parts[0] + '/' + parts[2];
            } else {
                var dash = dateOnly.split('-');
                clean_birth_dt = (dash.length === 3) ? dash[2] + '/' + dash[1] + '/' + dash[0] : dateOnly;
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

        $('#form_signin')[0].reset();
        $('#form_timeout')[0].reset();
        $('#form_signout')[0].reset();
        $('#si_sebutkan_ra, #to_alasan_ktdfo, #to_detail_antibiotik, #so_lainnya_pkbp_input').hide();
        $('#f_is_edit').val('0');
        $('#signin_is_edit').val('0');
        $('#si_tgl_tindakan').val(new Date().toISOString().substring(0, 10));

        currentData = null;
        faseDone = '';
        $('#btn_signin_panel, #btn_timeout_panel, #btn_signout_panel').prop('disabled', false);
        $('.lock-message').remove();
        $('.fase-panel').find('input, select, textarea, button[type="submit"]').prop('disabled', false);
        $('.fase-panel button[type="submit"]').show();
        $('.lock-message').remove();

        $('#header-identitas-pasien').fadeIn();
        $('#melayang').fadeIn();

        fetchSurgicalData(function() {
            autofillTTVFromPemeriksaanAwal(no_registrasi);
            autofillAlergiFromPemeriksaanAwal(patient_no);
        });
    });

    $('#btnPrint').click(function() {
        var no_registrasi = $('#no_registrasi').val();
        var nama_pasien = $('#nama_pasien').val();
        var no_rm = $('#no_rm').val();
        var tgl_lahir = $('#tgl_lahir').val();
        var gender = $('#gender').val();

        printSurgical(no_registrasi, nama_pasien, no_rm, tgl_lahir, gender);
    });

    $(document).on('click', '.btn-delete-surgical', function() {
        var no_registrasi = $(this).data('no_registrasi');
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: 'Data surgical safety checklist akan dihapus permanen.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('surgicalsafety/delete'); ?>",
                    method: "POST",
                    data: {
                        no_registrasi: no_registrasi
                    },
                    dataType: "JSON",
                    success: function(response) {
                        if (response.status === 'error') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message
                            });
                        } else {
                            Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message || 'Data berhasil dihapus.'
                                })
                                .then(function() {
                                    currentData = null;
                                    faseDone = '';
                                    $('#form_signin')[0].reset();
                                    $('#form_timeout')[0].reset();
                                    $('#form_signout')[0].reset();
                                    $('#f_is_edit').val('0');
                                    $('#signin_is_edit').val('0');
                                    $('#btn_timeout_panel, #btn_signout_panel').prop('disabled', true);
                                    showPanel('signin');
                                    $('#viewdatasurgical').html('');
                                    $('.fase-panel').find('input, select, textarea, button[type="submit"]').prop('disabled', false);
                                    $('.fase-panel button[type="submit"]').show();
                                    $('.lock-message').remove();
                                });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Terjadi kesalahan server.'
                        });
                    }
                });
            }
        });
    });
</script>
<?= $this->endSection('script'); ?>