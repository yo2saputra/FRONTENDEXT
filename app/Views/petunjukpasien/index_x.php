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
                                    <div class="col-sm-12 d-flex justify-content-between align-items-center">
                                        <span id="petunjuk_info_badge" class="text-muted small"></span>
                                        <div class="d-flex" style="gap:6px;">
                                            <button type="button" id="btn_hapus" class="btn btn-sm btn-outline-danger" style="display:none;">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                            <button type="button" id="btn_refresh" class="btn btn-sm btn-secondary">
                                                <i class="fas fa-sync-alt"></i> Refresh
                                            </button>
                                            <button type="button" id="btn_cetak" class="btn btn-sm btn-danger">
                                                <i class="fas fa-print"></i> Cetak PDF
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <form id="form_petunjuk" autocomplete="off">
                                    <input type="hidden" name="no_registrasi" class="sync-no-registrasi">
                                    <input type="hidden" name="penyuluhan_kesehatan" id="penyuluhan_merged">

                                    <div class="section-divider"><i class="fas fa-file-medical mr-1"></i> Diagnosis &amp; Vital</div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-2 row"><label class="col-sm-4 col-form-label col-form-label-sm">Diagnosa Medis</label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" name="diagnosa_medis" placeholder="Masukkan diagnosa medis"></div></div>
                                            <div class="mb-2 row"><label class="col-sm-4 col-form-label col-form-label-sm">Berat Badan <span class="label-unit">(kg)</span></label><div class="col-sm-8"><input type="number" step="0.1" class="form-control form-control-sm" name="berat_badan" placeholder="Cth: 60.5"></div></div>
                                            <div class="mb-2 row"><label class="col-sm-4 col-form-label col-form-label-sm">Tinggi Badan <span class="label-unit">(cm)</span></label><div class="col-sm-8"><input type="number" step="0.1" class="form-control form-control-sm" name="tinggi_badan" placeholder="Cth: 165"></div></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2 row"><label class="col-sm-4 col-form-label col-form-label-sm">Tensi <span class="label-unit">(mmHg)</span></label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" name="tensi" placeholder="Cth: 120/80"></div></div>
                                            <div class="mb-2 row"><label class="col-sm-4 col-form-label col-form-label-sm">Nadi <span class="label-unit">(x/mnt)</span></label><div class="col-sm-8"><input type="number" class="form-control form-control-sm" name="nadi" placeholder="Cth: 80"></div></div>
                                            <div class="mb-2 row"><label class="col-sm-4 col-form-label col-form-label-sm">Respiratory Rate <span class="label-unit">(x/mnt)</span></label><div class="col-sm-8"><input type="number" class="form-control form-control-sm" name="respiratory_rate" placeholder="Cth: 20"></div></div>
                                            <div class="mb-2 row"><label class="col-sm-4 col-form-label col-form-label-sm">Suhu <span class="label-unit">(°C)</span></label><div class="col-sm-8"><input type="number" step="0.1" class="form-control form-control-sm" name="suhu" placeholder="Cth: 36.5"></div></div>
                                        </div>
                                    </div>

                                    <div class="section-divider"><i class="fas fa-pills mr-1"></i> Obat &amp; Lembar</div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-2 row"><label class="col-sm-4 col-form-label col-form-label-sm">Obat Diberikan</label><div class="col-sm-8"><textarea class="form-control form-control-sm" name="diberikan_obt" rows="3" placeholder="Nama obat yang diberikan"></textarea></div></div>
                                            <div class="mb-2 row"><label class="col-sm-4 col-form-label col-form-label-sm">Obat Dibawa Pulang</label><div class="col-sm-8"><textarea class="form-control form-control-sm" name="dibawapulang_obt" rows="3" placeholder="Nama obat yang dibawa pulang"></textarea></div></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2 row"><label class="col-sm-4 col-form-label col-form-label-sm">Laboratorium <span class="label-unit">(lembar)</span></label><div class="col-sm-8"><input type="number" min="0" class="form-control form-control-sm" name="laboratorium_lmbr" placeholder="0"></div></div>
                                            <div class="mb-2 row"><label class="col-sm-4 col-form-label col-form-label-sm">Foto Thorax <span class="label-unit">(lembar)</span></label><div class="col-sm-8"><input type="number" min="0" class="form-control form-control-sm" name="foto_thorax_lmbr" placeholder="0"></div></div>
                                            <div class="mb-2 row"><label class="col-sm-4 col-form-label col-form-label-sm">USG <span class="label-unit">(lembar)</span></label><div class="col-sm-8"><input type="number" min="0" class="form-control form-control-sm" name="usg_lmbr" placeholder="0"></div></div>
                                            <div class="mb-2 row"><label class="col-sm-4 col-form-label col-form-label-sm">Lainnya <span class="label-unit">(lembar)</span></label><div class="col-sm-8"><input type="number" min="0" class="form-control form-control-sm" name="lainnya_lmbr" placeholder="0"></div></div>
                                        </div>
                                    </div>

                                    <div class="section-divider"><i class="fas fa-calendar-check mr-1"></i> Kontrol &amp; Penyuluhan</div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-2 row"><label class="col-sm-4 col-form-label col-form-label-sm">Penyuluhan 1</label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" id="penyuluhan_1" placeholder="Penyuluhan kesehatan ke-1"></div></div>
                                            <div class="mb-2 row"><label class="col-sm-4 col-form-label col-form-label-sm">Penyuluhan 2</label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" id="penyuluhan_2" placeholder="Penyuluhan kesehatan ke-2"></div></div>
                                            <div class="mb-2 row"><label class="col-sm-4 col-form-label col-form-label-sm">Penyuluhan 3</label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" id="penyuluhan_3" placeholder="Penyuluhan kesehatan ke-3"></div></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2 row"><label class="col-sm-4 col-form-label col-form-label-sm">Tanggal Kontrol</label><div class="col-sm-8"><input type="date" class="form-control form-control-sm" name="tgl_kntrl"></div></div>
                                            <div class="mb-2 row"><label class="col-sm-4 col-form-label col-form-label-sm">Poli Kontrol</label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" name="poli_kntrl" placeholder="Nama poli kontrol"></div></div>
                                            <div class="mb-2 row"><label class="col-sm-4 col-form-label col-form-label-sm">Membawa</label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" name="membawa_kntrl" placeholder="Dokumen yang dibawa saat kontrol"></div></div>
                                        </div>
                                    </div>

                                    <div class="section-divider"><i class="fas fa-clipboard-list mr-1"></i> Pemeriksaan &amp; Penjelasan</div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-2 row"><label class="col-sm-4 col-form-label col-form-label-sm">Tanggal Pemeriksaan</label><div class="col-sm-8"><input type="date" class="form-control form-control-sm" name="tgl_pemeriksaan"></div></div>
                                            <div class="mb-2 row"><label class="col-sm-4 col-form-label col-form-label-sm">Diberi Penjelasan</label><div class="col-sm-8"><input type="text" class="form-control form-control-sm" name="diberi_pnjlsan" placeholder="Nama penerima penjelasan"></div></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2 row">
                                                <label class="col-sm-4 col-form-label col-form-label-sm">Pemberi Penjelasan</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm bg-light" id="pemberi_pnjlsan" readonly>
                                                    <small class="text-muted">Otomatis diisi dari nama perawat yang login.</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center mt-3">
                                        <button type="submit" id="btn_submit_petunjuk" class="btn btn-primary btn-lg" disabled>
                                            <i class="fas fa-save mr-1"></i> <span id="btn_submit_label">Simpan</span>
                                        </button>
                                    </div>
                                </form>

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
    var isEditMode = false;

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

        $('#btn_submit_petunjuk').prop('disabled', true);
        $('#petunjuk_info_badge').html('<i class="fas fa-spinner fa-spin"></i> Memuat data...');

        $.ajax({
            url: "<?= site_url('petunjukpasien/fetchPetunjukJson'); ?>",
            method: "GET", cache: false,
            data: { no_registrasi: no_reg },
            dataType: "JSON",
            success: function(response) {
                resetForm($('#form_petunjuk'));
                $('#penyuluhan_1, #penyuluhan_2, #penyuluhan_3').val('');
                syncHiddenFields();

                                if (response.status === 'success' && response.data) {
                    isEditMode = true;
                    fillFormWithData(response.data);
                    $('#btn_submit_label').text('Ubah');
                    $('#btn_hapus').show();
                    var info = 'Dibuat oleh <b>' + (response.data.created_by || '-') + '</b>';
                    if (response.data.updated_by && response.data.updated_at !== response.data.created_at) {
                        info += ' &middot; Diubah oleh <b>' + response.data.updated_by + '</b>';
                    }
                    $('#petunjuk_info_badge').html(info);
                } else {
                    isEditMode = false;
                    $('#btn_submit_label').text('Simpan');
                    $('#btn_hapus').hide();
                    $('#petunjuk_info_badge').html('<span class="text-muted">Belum ada data petunjuk pulang untuk pasien ini.</span>');
                    autofillVitalFromObservasi();
                    autofillAntropometriFromPemeriksaanAwal();
                }
                $('#pemberi_pnjlsan').val(CURRENT_PERAWAT_NAME);
                $('#btn_submit_petunjuk').prop('disabled', false);
            },
            error: function() {
                $('#petunjuk_info_badge').html('<span class="text-danger">Gagal memuat data. Coba refresh.</span>');
                $('#btn_submit_petunjuk').prop('disabled', false);
            }
        });
    }

            function autofillVitalFromObservasi() {
        var no_reg = $('#f_no_registrasi').val();
        if (!no_reg) return;

        $.ajax({
            url: "<?= site_url('observasi/getPostTindakanForPetunjuk'); ?>",
            method: "GET", cache: false,
            data: { no_registrasi: no_reg },
            dataType: "JSON",
            success: function(response) {

                if (response.status !== 'success' || !response.data) return;

                var d  = response.data;
                var $f = $('#form_petunjuk');

                var hasValue = function(v) {
                    return v !== null && v !== undefined && v !== '' && v !== 0 && v !== '0';
                };

                if (!$f.find('[name="diagnosa_medis"]').val() && hasValue(d.diagnosis_medis)) {
                    $f.find('[name="diagnosa_medis"]').val(d.diagnosis_medis);
                }
                if (!$f.find('[name="tensi"]').val() && hasValue(d.tekanan_darah_kpot)) {
                    $f.find('[name="tensi"]').val(d.tekanan_darah_kpot);
                }
                if (!$f.find('[name="suhu"]').val() && hasValue(d.suhu_kpot)) {
                    $f.find('[name="suhu"]').val(d.suhu_kpot);
                }
                if (!$f.find('[name="nadi"]').val() && hasValue(d.nadi_kpot)) {
                    $f.find('[name="nadi"]').val(d.nadi_kpot);
                }
                if (!$f.find('[name="respiratory_rate"]').val() && hasValue(d.rr_kpot)) {
                    $f.find('[name="respiratory_rate"]').val(d.rr_kpot);
                }
            },
            error: function(xhr) {
            }
        });
    }

    function autofillAntropometriFromPemeriksaanAwal() {
        var no_reg = $('#f_no_registrasi').val();
        if (!no_reg) return;

        $.ajax({
            url: "<?= site_url('pemeriksaanawal/fetchPemeriksaanAwalByRegistrasi'); ?>",
            method: "GET", cache: false,
            data: { no_registrasi: no_reg },
            dataType: "JSON",
            success: function(response) {

                if (response.status !== 'success' || !response.data) return;

                var d  = response.data;
                var $f = $('#form_petunjuk');

                var hasValue = function(v) {
                    return v !== null && v !== undefined && v !== '' && v !== 0 && v !== '0';
                };

                if (!$f.find('[name="berat_badan"]').val() && hasValue(d.berat_badan)) {
                    $f.find('[name="berat_badan"]').val(d.berat_badan);
                }
                if (!$f.find('[name="tinggi_badan"]').val() && hasValue(d.tinggi_badan)) {
                    $f.find('[name="tinggi_badan"]').val(d.tinggi_badan);
                }
            },
            error: function(xhr) {
                console.log('[autofill-pemeriksaanawal] gagal, status:', xhr.status, xhr.responseText); 
            }
        });
    }

    function fillFormWithData(d) {
        var $f = $('#form_petunjuk');
        $f.find('[name="diagnosa_medis"]').val(d.diagnosa_medis || '');
        $f.find('[name="berat_badan"]').val(d.berat_badan || '');
        $f.find('[name="tinggi_badan"]').val(d.tinggi_badan || '');
        $f.find('[name="tensi"]').val(d.tensi || '');
        $f.find('[name="nadi"]').val(d.nadi || '');
        $f.find('[name="respiratory_rate"]').val(d.respiratory_rate || '');
        $f.find('[name="suhu"]').val(d.suhu || '');
        $f.find('[name="diberikan_obt"]').val(d.diberikan_obt || '');
        $f.find('[name="dibawapulang_obt"]').val(d.dibawapulang_obt || '');
        $f.find('[name="laboratorium_lmbr"]').val(d.laboratorium_lmbr || '');
        $f.find('[name="foto_thorax_lmbr"]').val(d.foto_thorax_lmbr || '');
        $f.find('[name="usg_lmbr"]').val(d.usg_lmbr || '');
        $f.find('[name="lainnya_lmbr"]').val(d.lainnya_lmbr || '');
        var pparts = splitPenyuluhan(d.penyuluhan_kesehatan || '');
        $('#penyuluhan_1').val(pparts[0]);
        $('#penyuluhan_2').val(pparts[1]);
        $('#penyuluhan_3').val(pparts[2]);
        $f.find('[name="tgl_kntrl"]').val(d.tgl_kntrl ? d.tgl_kntrl.split('T')[0] : '');
        $f.find('[name="poli_kntrl"]').val(d.poli_kntrl || '');
        $f.find('[name="membawa_kntrl"]').val(d.membawa_kntrl || '');
        $f.find('[name="tgl_pemeriksaan"]').val(d.tgl_pemeriksaan ? d.tgl_pemeriksaan.split('T')[0] : '');
        $f.find('[name="diberi_pnjlsan"]').val(d.diberi_pnjlsan || '');
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

    $('#form_petunjuk').on('submit', function(e) {
        e.preventDefault();
        var $form  = $(this);
        var $btn   = $('#btn_submit_petunjuk');
        var no_reg = $('#f_no_registrasi').val();

        if (!no_reg) {
            Swal.fire({ icon:'warning', title:'Peringatan', text:'Pilih pasien terlebih dahulu.' });
            return;
        }

        $('#penyuluhan_merged').val(
            mergePenyuluhan($('#penyuluhan_1').val(), $('#penyuluhan_2').val(), $('#penyuluhan_3').val())
        );

        $.ajax({
            url: "<?= site_url('petunjukpasien/action'); ?>",
            method: "POST",
            data: $form.serialize(),
            dataType: "JSON",
            beforeSend: function(){ $btn.prop('disabled',true).html('<i class="fa fa-spin fa-spinner"></i> Menyimpan...'); },
            complete:   function(){ $btn.prop('disabled',false).html('<i class="fas fa-save mr-1"></i> <span id="btn_submit_label">' + (isEditMode ? 'Ubah' : 'Simpan') + '</span>'); },
            success: function(response) {
                if (response.error) {
                    Swal.fire({ icon:'error', title:'Gagal Menyimpan', text: extractError(response) });
                } else if (response.success) {
                    Swal.fire({ icon:'success', title:'Berhasil', text: response.success }).then(function(){
                        fetchPetunjukData();
                    });
                } else {
                    Swal.fire({ icon:'error', title:'Error', text:'Response tidak dikenali.' });
                }
            },
            error: function(){ Swal.fire({ icon:'error', title:'Gagal', text:'Tidak dapat menghubungi server.' }); }
        });
    });

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

    $('#btn_hapus').on('click', function() {
        const no_registrasi = $('#f_no_registrasi').val();
        if (!no_registrasi) { Swal.fire({ icon:'error', title:'Error', text:'Pasien belum dipilih.' }); return; }

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