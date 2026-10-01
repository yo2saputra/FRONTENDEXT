<?= $this->extend('clinic_template'); ?>

    <?= $this->section('style'); ?>
    <style>
        .btn-fix-w { width: 60px; padding-top: 0px; padding-bottom: 0px; }
        .control-sidebar { color: black; }
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

        #viewdataresiko { background-color: #fff !important; }
        #viewdataresiko table { background-color: #fff !important; color: #333 !important; }
        #viewdataresiko table thead tr th { background-color: #ffffff !important; color: #333 !important; }
        #viewdataresiko table tbody tr td { background-color: #fff !important; color: #333 !important; }
        #viewdataresiko table tbody tr:nth-child(even) td { background-color: #fafafa !important; }

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
                                            data-toggle="modal" data-target="#modalAddPengkajian">
                                            <i class="fas fa-clipboard-check"></i> Pengkajian
                                        </button>
                                        <button type="button" class="btn btn-nav-dark btn-input-section" disabled
                                            data-toggle="modal" data-target="#modalAddPetugas">
                                            <i class="fas fa-user-nurse"></i> Petugas
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
                                <div class="table-responsive" id="viewdataresiko">
                                    <p class="text-muted text-center">Pilih pasien untuk melihat data asesmen risiko jatuh.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="modal fade" id="modalAddPengkajian" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document"><div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-clipboard-check mr-2"></i> 1. Pengkajian</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form class="form-add-section" autocomplete="off">
                    <input type="hidden" name="no_registrasi" class="sync-no-reg">
                    <input type="hidden" name="action" value="Add">
                    <div class="modal-body">
                        <table class="table table-bordered table-sm" style="font-size:0.85rem;">
                            <thead class="thead-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Penilaian/Pengkajian</th>
                                    <th width="10%" class="text-center">Ya</th>
                                    <th width="10%" class="text-center">Tidak</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="table-light">
                                    <td class="text-center align-middle font-weight-bold">a.</td>
                                    <td class="font-weight-bold">Cara berjalan pasien (salah satu atau lebih)</td>
                                    <td class="text-center align-middle">
                                        <input type="radio" class="a-indicator" disabled>
                                    </td>
                                    <td class="text-center align-middle">
                                        <input type="radio" class="a-indicator" disabled checked>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center align-middle">a.1</td>
                                    <td style="padding-left:20px;">Tidak seimbang/sempoyongan</td>
                                    <td class="text-center align-middle"><input type="radio" name="cara_berjalan_1" value="ya"></td>
                                    <td class="text-center align-middle"><input type="radio" name="cara_berjalan_1" value="tidak"></td>
                                </tr>
                                <tr>
                                    <td class="text-center align-middle">a.2</td>
                                    <td style="padding-left:20px;">Jalan dengan menggunakan alat bantu (kruk, tripot, kursi roda, bantuan orang)</td>
                                    <td class="text-center align-middle"><input type="radio" name="cara_berjalan_2" value="ya"></td>
                                    <td class="text-center align-middle"><input type="radio" name="cara_berjalan_2" value="tidak"></td>
                                </tr>
                                <tr>
                                    <td class="text-center align-middle">b.</td>
                                    <td>Menopang saat akan duduk : tampak memegang pinggiran kursi atau meja atau benda lain sebagai penopang saat akan duduk</td>
                                    <td class="text-center align-middle"><input type="radio" name="menopang_duduk" value="ya"></td>
                                    <td class="text-center align-middle"><input type="radio" name="menopang_duduk" value="tidak"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-add-submit"><i class="fas fa-save mr-1"></i> Simpan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div></div>
        </div>

        <div class="modal fade" id="modalAddPetugas" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document"><div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-user-nurse mr-2"></i> TTD / Nama Petugas</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form class="form-add-section" autocomplete="off">
                    <input type="hidden" name="no_registrasi" class="sync-no-reg">
                    <input type="hidden" name="action" value="Add">
                    <div class="modal-body">
                        <div class="mb-2 row">
                            <label class="col-sm-4 col-form-label col-form-label-sm">TTD / Nama Petugas</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-sm" name="usr_petugas"
                                    value="<?= esc($session_emp_nm ?? '') ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-add-submit"><i class="fas fa-save mr-1"></i> Simpan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div></div>
        </div>

        <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document"><div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-edit mr-2"></i> Ubah Data</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form id="form_edit" autocomplete="off">
                    <input type="hidden" id="edit_no_registrasi" name="no_registrasi" value="">
                    <input type="hidden" name="action" value="Edit">
                    <div class="modal-body">

                        <div class="mb-3">
                            <span class="badge badge-primary px-3 py-2" style="font-size:0.9rem;" id="edit-section-label"></span>
                        </div>

                        <div id="edit-section-pengkajian" style="display:none;">
                            <table class="table table-bordered table-sm" style="font-size:0.85rem;">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Penilaian/Pengkajian</th>
                                        <th width="10%" class="text-center">Ya</th>
                                        <th width="10%" class="text-center">Tidak</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="table-light">
                                        <td class="text-center align-middle font-weight-bold">a.</td>
                                        <td class="font-weight-bold">Cara berjalan pasien (salah satu atau lebih)</td>
                                        <td class="text-center align-middle">
                                            <input type="radio" class="a-indicator-edit" disabled>
                                        </td>
                                        <td class="text-center align-middle">
                                            <input type="radio" class="a-indicator-edit" disabled checked>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center align-middle">a.1</td>
                                        <td style="padding-left:20px;">Tidak seimbang/sempoyongan</td>
                                        <td class="text-center align-middle"><input type="radio" name="cara_berjalan_1" id="edit_cara1_ya" value="ya"></td>
                                        <td class="text-center align-middle"><input type="radio" name="cara_berjalan_1" id="edit_cara1_tidak" value="tidak"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center align-middle">a.2</td>
                                        <td style="padding-left:20px;">Jalan dengan menggunakan alat bantu (kruk, tripot, kursi roda, bantuan orang)</td>
                                        <td class="text-center align-middle"><input type="radio" name="cara_berjalan_2" id="edit_cara2_ya" value="ya"></td>
                                        <td class="text-center align-middle"><input type="radio" name="cara_berjalan_2" id="edit_cara2_tidak" value="tidak"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center align-middle">b.</td>
                                        <td>Menopang saat akan duduk : tampak memegang pinggiran kursi atau meja atau benda lain sebagai penopang saat akan duduk</td>
                                        <td class="text-center align-middle"><input type="radio" name="menopang_duduk" id="edit_menopang_ya" value="ya"></td>
                                        <td class="text-center align-middle"><input type="radio" name="menopang_duduk" id="edit_menopang_tidak" value="tidak"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div id="edit-section-petugas" style="display:none;">
                            <div class="mb-2 row">
                                <label class="col-sm-4 col-form-label col-form-label-sm">TTD / Nama Petugas</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="edit_usr_petugas" name="usr_petugas"
                                        value="<?= esc($session_emp_nm ?? '') ?>" readonly>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="edit_submit_button" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan Perubahan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div></div>
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
    <script>
    $(document).prop("title", $('p#active-menu').html());

    var sectionMap = {
        'pengkajian': { div: 'edit-section-pengkajian', label: '1. Pengkajian' },
        'petugas':    { div: 'edit-section-petugas',    label: 'TTD / Nama Petugas' }
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
            url: "<?= site_url('resikojatuh/fetchAll'); ?>",
            success: function(data){ $('#viewdata').html(data); },
            error:   function(xhr){ console.error('fetchAll error:', xhr.responseText); }
        });
    }

    function fetchResikoData() {
        var no_reg = $('#f_no_registrasi').val();
        if (!no_reg) return;
        $('#viewdataresiko').html('<p class="text-center text-muted py-3"><i class="fas fa-spinner fa-spin"></i> Memuat data...</p>');
        $.ajax({
            url: "<?= site_url('resikojatuh/fetchResikoByRegistrasi'); ?>",
            method: "GET", cache: false,
            data: { no_registrasi: no_reg },
            success: function(data){
                $('#viewdataresiko').html(data);
                checkDataExists();
            },
            error: function(){
                $('#viewdataresiko').html('<p class="text-center text-danger py-3">Gagal memuat data. Coba refresh.</p>');
            }
        });
    }

    function updateAIndicator(radioA1Name, radioA2Name, indicatorClass, scope) {
        var $scope = scope ? $(scope) : $(document);
        var val1 = $scope.find('input[name="' + radioA1Name + '"]:checked').val();
        var val2 = $scope.find('input[name="' + radioA2Name + '"]:checked').val();
        var aYa  = (val1 === 'ya' || val2 === 'ya');

        var $indicators = $scope.find('.' + indicatorClass);
        $indicators.eq(0).prop('checked', aYa);
        $indicators.eq(1).prop('checked', !aYa);
    }

    function checkDataExists() {
        var hasData = ($('#viewdataresiko table tbody tr').length > 0 &&
                       $('#viewdataresiko table tbody tr td[colspan]').length === 0);
        $('.btn-input-section').prop('disabled', hasData);
    }

    function extractError(response) {
        if (!response.error) return 'Terjadi kesalahan tidak dikenal.';
        if (typeof response.error === 'string') return response.error;
        if (typeof response.error === 'object') return Object.values(response.error).filter(Boolean).join('\n');
        return JSON.stringify(response.error);
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

        $.ajax({ url:"<?= site_url('resikojatuh/setNoRegistrasi'); ?>", method:"GET",
            data:{ no_registrasi: no_registrasi, patient_no: patient_no } });

        $('#f_no_registrasi').val(no_registrasi);
        $('#f_medrec_id').val(patient_no);
        $('#edit_no_registrasi').val(no_registrasi);
        $('.sync-no-reg').val(no_registrasi);

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
        fetchResikoData();
    });

    $('[id^="modalAdd"]').on('hidden.bs.modal', function() {
        $(this).find('form')[0].reset();
        $('.sync-no-reg').val($('#f_no_registrasi').val());
    });
    $('[id^="modalAdd"]').on('show.bs.modal', function() {
        $(this).find('form')[0].reset();
        $('.sync-no-reg').val($('#f_no_registrasi').val());
        $('#modalAddPengkajian .a-indicator').eq(0).prop('checked', false);
        $('#modalAddPengkajian .a-indicator').eq(1).prop('checked', true);
    });

    $(document).on('change', '#modalAddPengkajian input[name="cara_berjalan_1"], #modalAddPengkajian input[name="cara_berjalan_2"]', function() {
        updateAIndicator('cara_berjalan_1', 'cara_berjalan_2', 'a-indicator', '#modalAddPengkajian');
    });

    $(document).on('change', '#modalEdit input[name="cara_berjalan_1"], #modalEdit input[name="cara_berjalan_2"]', function() {
        updateAIndicator('cara_berjalan_1', 'cara_berjalan_2', 'a-indicator-edit', '#modalEdit');
    });

    $(document).on('submit', '.form-add-section', function(e) {
        e.preventDefault();
        var no_reg = $('#f_no_registrasi').val();
        if (!no_reg) { Swal.fire({ icon:'warning', title:'Peringatan', text:'Pilih pasien terlebih dahulu.' }); return; }
        var $form = $(this);
        var $btn  = $form.find('.btn-add-submit');

        $.ajax({
            url: "<?= site_url('resikojatuh/action'); ?>",
            method: "POST", data: $form.serialize(), dataType: "JSON",
            beforeSend: function(){ $btn.prop('disabled',true).html('<i class="fa fa-spin fa-spinner"></i> Menyimpan...'); },
            complete:   function(){ $btn.prop('disabled',false).html('<i class="fas fa-save mr-1"></i> Simpan'); },
            success: function(response) {
                if (response.error) {
                    Swal.fire({ icon:'error', title:'Gagal Menyimpan', text: extractError(response) });
                } else if (response.success) {
                    Swal.fire({ icon:'success', title:'Berhasil', text: response.success }).then(function(){
                        $form.closest('.modal').modal('hide');
                        fetchResikoData();
                    });
                }
            },
            error: function(){ Swal.fire({ icon:'error', title:'Gagal', text:'Tidak dapat menghubungi server.' }); }
        });
    });

    $('#btn_refresh').on('click', function(){ fetchResikoData(); });

    $('#btn_cetak').on('click', function() {
        var no_reg = $('#f_no_registrasi').val();
        if (!no_reg) { Swal.fire({ icon:'warning', title:'Peringatan', text:'Pilih pasien terlebih dahulu.' }); return; }
        var params = new URLSearchParams({
            no_rm       : $('#medrec_id_info').text().trim(),
            nama_pasien : $('#fullname_tm').text().trim(),
            tgl_lahir   : $('#birth_dt_tm').text().trim(),
            gender      : $('#gender_tm').text().trim()
        });
        window.open("<?= site_url('resikojatuh/printResiko'); ?>/" + no_reg + '?' + params.toString(), '_blank');
    });

    $(document).on('click', '.clickable-col', function() {
        var section = $(this).data('section');
        var d       = $(this).closest('tr').data('row');
        if (!d) return;

        $('#form_edit')[0].reset();
        $('#edit_no_registrasi').val($('#f_no_registrasi').val());

        if (d.cara_berjalan)  $('input[name="cara_berjalan_1"][value="' + d.cara_berjalan  + '"]', '#form_edit').prop('checked', true);
        if (d.cara_berjalan2) $('input[name="cara_berjalan_2"][value="' + d.cara_berjalan2 + '"]', '#form_edit').prop('checked', true);
        if (d.menopang_duduk)  $('input[name="menopang_duduk"][value="'  + d.menopang_duduk  + '"]', '#form_edit').prop('checked', true);

        updateAIndicator('cara_berjalan_1', 'cara_berjalan_2', 'a-indicator-edit', '#modalEdit');

        showEditSection(section);
        $('#modalEdit').modal('show');
    });

    $('#modalEdit').on('hidden.bs.modal', function() { $('#form_edit')[0].reset(); });

    $('#form_edit').off('submit').on('submit', function(e) {
        e.preventDefault();
        $('#edit_no_registrasi').val($('#f_no_registrasi').val());

        $.ajax({
            url: "<?= site_url('resikojatuh/action'); ?>",
            method: "POST", data: $(this).serialize(), dataType: "JSON",
            beforeSend: function(){ $('#edit_submit_button').prop('disabled',true).html('<i class="fa fa-spin fa-spinner"></i> Menyimpan...'); },
            complete:   function(){ $('#edit_submit_button').prop('disabled',false).html('<i class="fas fa-save mr-1"></i> Simpan Perubahan'); },
            success: function(response) {
                if (response.error) {
                    Swal.fire({ icon:'error', title:'Gagal', text: extractError(response) });
                } else if (response.success) {
                    Swal.fire({ icon:'success', title:'Berhasil', text: response.success }).then(function(){
                        $('#modalEdit').modal('hide');
                        fetchResikoData();
                    });
                }
            },
            error: function(){ Swal.fire({ icon:'error', title:'Gagal', text:'Tidak dapat menghubungi server.' }); }
        });
    });

    $(document).on('click', '.delete', function() {
        var no_registrasi = $(this).data('no_registrasi');
        if (!no_registrasi) { Swal.fire({ icon:'error', title:'Error', text:'No. Registrasi tidak ditemukan.' }); return; }
        Swal.fire({
            title: 'Yakin ingin menghapus data?',
            text: 'Data asesmen risiko jatuh akan dihapus secara permanen.',
            icon: 'warning', showCancelButton: true,
            confirmButtonText: 'Ya, hapus!', cancelButtonText: 'Batal'
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('resikojatuh/delete'); ?>",
                    method: "POST", data: { no_registrasi: no_registrasi }, dataType: "JSON",
                    success: function(response) {
                        if (response.status === 'error') {
                            Swal.fire({ icon:'error', title:'Gagal', text: response.message || 'Gagal menghapus.' });
                        } else if (response.status === 'success') {
                            Swal.fire({ icon:'success', title:'Berhasil', text: response.message || 'Data berhasil dihapus.' })
                                .then(function(){ fetchResikoData(); });
                        } else {
                            Swal.fire({ icon:'success', title:'Berhasil', text: 'Data berhasil dihapus.' })
                                .then(function(){ fetchResikoData(); });
                        }
                    },
                    error: function(){ Swal.fire({ icon:'error', title:'Gagal', text:'Terjadi kesalahan server.' }); }
                });
            }
        });
    });
    </script>
    <?= $this->endSection('script'); ?>