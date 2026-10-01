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

        #viewdataskrining { background-color: #fff !important; }
        #viewdataskrining table { background-color: #fff !important; color: #333 !important; }
        #viewdataskrining table thead tr th { background-color: #ffffff !important; color: #333 !important; }
        #viewdataskrining table tbody tr td { background-color: #fff !important; color: #333 !important; }
        #viewdataskrining table tbody tr:nth-child(even) td { background-color: #fafafa !important; }

        .btn-input-section { min-width: 140px; }

        .btn-nav-bar {
            background-color: #343a40;
            border-radius: 4px;
            padding: 4px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 2px;
        }
        body:not(.dark-mode) .btn-nav-bar { background-color: #e9ecef; }
        body:not(.dark-mode) .btn-nav-bar .btn-nav-dark { color: #343a40 !important; }
        .btn-nav-dark {
            display: inline-flex; align-items: center; gap: 6px;
            background-color: transparent; border: none; border-left: 3px solid transparent;
            border-radius: 0; padding: 6px 14px; font-size: 0.82rem; font-weight: 500;
            transition: background 0.18s, border-color 0.18s, color 0.18s; white-space: nowrap;
        }
        .btn-nav-dark i { font-size: 0.8rem; width: 14px; text-align: center; }

        .jenis-toggle-wrap { display: flex; gap: 10px; margin-bottom: 12px; }
        .jenis-toggle-btn {
            flex: 1; padding: 10px; text-align: center; border: 2px solid #dee2e6;
            border-radius: 6px; cursor: pointer; font-weight: 600; color: #6c757d; background: #fff;
        }
        .jenis-toggle-btn.active { border-color: #007bff; color: #007bff; background: #eaf3ff; }
        .jenis-toggle-btn input { display: none; }

        .skor-badge { font-size: 0.85rem; padding: 6px 10px; }
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
                                            data-toggle="modal" data-target="#modalAddSkrining">
                                            <i class="fas fa-clipboard-check"></i> Skrining Gizi
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
                                <div class="table-responsive" id="viewdataskrining">
                                    <p class="text-muted text-center">Pilih pasien untuk melihat data skrining gizi.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="modal fade" id="modalAddSkrining" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document"><div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-clipboard-check mr-2"></i> Skrining Gizi</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form id="form_skrining" autocomplete="off">
                    <input type="hidden" name="no_registrasi" id="skr_no_registrasi">
                    <input type="hidden" name="action" id="skr_action" value="Add">
                    <input type="hidden" name="jenisScreening" id="skr_jenis" value="DEWASA">
                    <input type="hidden" name="perluPengkajian" id="skr_perlu_pengkajian" value="0">

                    <div class="modal-body">

                        <div class="jenis-toggle-wrap">
                            <label class="jenis-toggle-btn active" id="toggle_dewasa">
                                <input type="radio" name="jenis_toggle" value="DEWASA" checked>
                                <i class="fas fa-user mr-1"></i> Skrining Gizi Dewasa
                            </label>
                            <label class="jenis-toggle-btn" id="toggle_anak">
                                <input type="radio" name="jenis_toggle" value="ANAK">
                                <i class="fas fa-child mr-1"></i> Skrining Gizi Anak (0-16 th)
                            </label>
                        </div>

                        <div id="section_dewasa">
                            <table class="table table-bordered table-sm" style="font-size:0.85rem;">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Parameter</th>
                                        <th width="15%" class="text-center">Skor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center align-middle">1</td>
                                        <td>
                                            Apakah pasien mengalami penurunan BB yang tidak diinginkan dalam 6 bulan terakhir?
                                            <div class="mt-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="penurunanBeratBadan" id="pbb_0" value="0" checked>
                                                    <label class="form-check-label" for="pbb_0">A. Tidak ada penurunan berat badan</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="penurunanBeratBadan" id="pbb_2" value="2">
                                                    <label class="form-check-label" for="pbb_2">B. Tidak yakin/tidak tahu/terasa baju lebih longgar</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="penurunanBeratBadan" id="pbb_c" value="1" data-triggers-jumlah="1">
                                                    <label class="form-check-label" for="pbb_c">C. Jika ya, berapa penurunan berat badan tersebut</label>
                                                </div>
                                            </div>
                                            <div id="jumlah_penurunan_wrap" style="display:none; padding-left:24px; margin-top:6px;">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="jumlahPenurunanBeratBadan" id="jbb_1" value="1">
                                                    <label class="form-check-label" for="jbb_1">1-5 kg</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="jumlahPenurunanBeratBadan" id="jbb_2" value="2">
                                                    <label class="form-check-label" for="jbb_2">6-10 kg</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="jumlahPenurunanBeratBadan" id="jbb_3" value="3">
                                                    <label class="form-check-label" for="jbb_3">11-15 kg</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="jumlahPenurunanBeratBadan" id="jbb_4" value="4">
                                                    <label class="form-check-label" for="jbb_4">&gt; 15 kg</label>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle" id="skor_pbb_display">0</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center align-middle">2</td>
                                        <td>Apakah asupan makanan berkurang karena tidak nafsu makan?</td>
                                        <td class="text-center align-middle">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="asupanBerkurang" id="asupan_tidak" value="0" checked>
                                                <label class="form-check-label" for="asupan_tidak">Tidak</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="asupanBerkurang" id="asupan_ya" value="1">
                                                <label class="form-check-label" for="asupan_ya">Ya</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center align-middle">3</td>
                                        <td>
                                            Pasien dengan diagnosa khusus?
                                            <div class="text-muted mt-1" style="font-size:0.75rem;">
                                                (Garis bawahi bila terdapat pada pasien, contoh: PPOK, Hemodialisis, Fraktur tulang punggung, sirosis hati, hemodialisis, diabetes, kanker, bedah digestive, pneumonia berat, cidera kepala, transplantasi, luka bakar, pasien kritis di ICU/HCU, usia lanjut, psikiatri, mendapat kemoterapi atau radiasi, imunitas rendah / HIV-AIDS, penyakit kronis lain.)
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="diagnosaKhusus" id="dxkhusus_tidak" value="0" checked>
                                                <label class="form-check-label" for="dxkhusus_tidak">Tidak</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="diagnosaKhusus" id="dxkhusus_ya" value="1">
                                                <label class="form-check-label" for="dxkhusus_ya">Ya</label>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="alert alert-light border" style="font-size:0.78rem;">
                                (Bila skor &gt; 2 dan / atau pasien dengan diagnosis khusus, dilakukan pengkajian lebih lanjut oleh nutritionis / dietisen)
                            </div>
                        </div>

                        <div id="section_anak" style="display:none;">
                            <table class="table table-bordered table-sm" style="font-size:0.85rem;">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Parameter</th>
                                        <th width="20%" class="text-center">Jawaban</th>
                                        <th width="10%" class="text-center">Skor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Pasien anak tampak kurus</td>
                                        <td class="text-center">
                                            <div class="form-check"><input class="form-check-input" type="radio" name="tampakKurus" id="tk_ya" value="1"><label class="form-check-label" for="tk_ya">Ya</label></div>
                                            <div class="form-check"><input class="form-check-input" type="radio" name="tampakKurus" id="tk_tidak" value="0" checked><label class="form-check-label" for="tk_tidak">Tidak</label></div>
                                        </td>
                                        <td class="text-center align-middle skor-col" data-max="1">1</td>
                                    </tr>
                                    <tr>
                                        <td>Apakah terdapat penurunan berat badan selama 1 bulan terakhir (berdasarkan penilaian objektif data berat badan bila ada, atau penilaian subjektif orangtua untuk bayi &lt; 1 tahun: berat badan tidak naik 3 bulan terakhir)?</td>
                                        <td class="text-center">
                                            <div class="form-check"><input class="form-check-input" type="radio" name="anakPenurunanBeratBadan" id="apbb_ya" value="1"><label class="form-check-label" for="apbb_ya">Ya</label></div>
                                            <div class="form-check"><input class="form-check-input" type="radio" name="anakPenurunanBeratBadan" id="apbb_tidak" value="0" checked><label class="form-check-label" for="apbb_tidak">Tidak</label></div>
                                        </td>
                                        <td class="text-center align-middle skor-col" data-max="1">1</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Apakah terdapat salah satu kondisi tersebut di bawah ini:
                                            <ul class="mb-0 mt-1" style="font-size:0.78rem;">
                                                <li>Diare &gt; 5 kali sehari dalam seminggu terakhir</li>
                                                <li>Muntah &gt; 3 kali sehari dalam seminggu terakhir</li>
                                                <li>Asupan makan berkurang dalam seminggu terakhir</li>
                                            </ul>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check"><input class="form-check-input" type="radio" name="kondisi" id="kondisi_ya" value="1"><label class="form-check-label" for="kondisi_ya">Ya</label></div>
                                            <div class="form-check"><input class="form-check-input" type="radio" name="kondisi" id="kondisi_tidak" value="0" checked><label class="form-check-label" for="kondisi_tidak">Tidak</label></div>
                                        </td>
                                        <td class="text-center align-middle skor-col" data-max="1">1</td>
                                    </tr>
                                    <tr>
                                        <td>Apakah terdapat penyakit atau keadaan yang mengakibatkan pasien berisiko mengalami malnutrisi atau apakah ada pembedahan besar?</td>
                                        <td class="text-center">
                                            <div class="form-check"><input class="form-check-input" type="radio" name="terdapatPenyakitKeadaan" id="tpk_ya" value="1"><label class="form-check-label" for="tpk_ya">Ya</label></div>
                                            <div class="form-check"><input class="form-check-input" type="radio" name="terdapatPenyakitKeadaan" id="tpk_tidak" value="0" checked><label class="form-check-label" for="tpk_tidak">Tidak</label></div>
                                        </td>
                                        <td class="text-center align-middle skor-col" data-max="2">2</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-right font-weight-bold">Total Skor</td>
                                        <td class="text-center align-middle font-weight-bold" id="skor_anak_total">0</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="alert alert-light border" style="font-size:0.78rem;">
                                Nilai score: 0 = risiko rendah, 1-3 = risiko malnutrisi sedang, 4-5 = risiko malnutrisi tinggi.<br>
                                Total skor jika jawaban Ya &ge; 1 dilakukan pengkajian oleh dietisan.
                            </div>
                        </div>

                        <div class="mt-2">
                            <span class="badge badge-secondary skor-badge" id="badge_perlu_pengkajian">Perlu Pengkajian Lebih Lanjut: Tidak</span>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="btn_submit_skrining"><i class="fas fa-save mr-1"></i> Simpan</button>
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

    function tregistrasi() {
        $.ajax({
            method: "GET",
            url: "<?= site_url('skriningizi/fetchAll'); ?>",
            success: function(data){ $('#viewdata').html(data); },
            error:   function(xhr){ console.error('fetchAll error:', xhr.responseText); }
        });
    }

    function fetchSkriningData() {
        var no_reg = $('#f_no_registrasi').val();
        if (!no_reg) return;
        $('#viewdataskrining').html('<p class="text-center text-muted py-3"><i class="fas fa-spinner fa-spin"></i> Memuat data...</p>');
        $.ajax({
            url: "<?= site_url('skriningizi/fetchByRegistrasi'); ?>",
            method: "GET", cache: false,
            data: { no_registrasi: no_reg },
            success: function(data){
                $('#viewdataskrining').html(data);
                checkDataExists();
            },
            error: function(){
                $('#viewdataskrining').html('<p class="text-center text-danger py-3">Gagal memuat data. Coba refresh.</p>');
            }
        });
    }

    function checkDataExists() {
        var hasData = ($('#viewdataskrining table tbody tr').length > 0 &&
                       $('#viewdataskrining table tbody tr td[colspan]').length === 0);
  
        $('.btn-input-section').prop('disabled', false);
        $('#skr_action').val(hasData ? 'Edit' : 'Add');
    }

    function extractError(response) {
        if (!response.error) return 'Terjadi kesalahan tidak dikenal.';
        if (typeof response.error === 'string') return response.error;
        if (typeof response.error === 'object') return Object.values(response.error).filter(Boolean).join('\n');
        return JSON.stringify(response.error);
    }

    function toggleJenis(jenis) {
        $('#skr_jenis').val(jenis);
        if (jenis === 'DEWASA') {
            $('#section_dewasa').show();
            $('#section_anak').hide();
            $('#toggle_dewasa').addClass('active');
            $('#toggle_anak').removeClass('active');
        } else {
            $('#section_dewasa').hide();
            $('#section_anak').show();
            $('#toggle_dewasa').removeClass('active');
            $('#toggle_anak').addClass('active');
        }
        hitungSkor();
    }

    function hitungSkor() {
        var jenis = $('#skr_jenis').val();
        var perlu = 0;

        if (jenis === 'DEWASA') {
            var pbbVal = parseInt($('input[name="penurunanBeratBadan"]:checked').val() || 0);
            var isC = $('#pbb_c').is(':checked');
            var jbbVal = isC ? parseInt($('input[name="jumlahPenurunanBeratBadan"]:checked').val() || 0) : 0;
            var asupan = parseInt($('input[name="asupanBerkurang"]:checked').val() || 0);
            var dxKhusus = parseInt($('input[name="diagnosaKhusus"]:checked').val() || 0);

            var skorPoin1 = isC ? jbbVal : pbbVal;
            $('#skor_pbb_display').text(skorPoin1);

            var totalSkor = skorPoin1 + asupan;
            perlu = (totalSkor > 2 || dxKhusus === 1) ? 1 : 0;
        } else {
            var total = 0;
            $('#section_anak .skor-col').each(function() {
                var $row = $(this).closest('tr');
                var checked = $row.find('input[type="radio"]:checked').val();
                var max = parseInt($(this).data('max'));
                total += (checked === '1') ? max : 0;
            });
            $('#skor_anak_total').text(total);
            perlu = (total >= 1) ? 1 : 0;
        }

        $('#skr_perlu_pengkajian').val(perlu);
        if (perlu === 1) {
            $('#badge_perlu_pengkajian').removeClass('badge-secondary').addClass('badge-danger').text('Perlu Pengkajian Lebih Lanjut: Ya');
        } else {
            $('#badge_perlu_pengkajian').removeClass('badge-danger').addClass('badge-secondary').text('Perlu Pengkajian Lebih Lanjut: Tidak');
        }
    }

    $(document).ready(function() {
        $('.btn-input-section').prop('disabled', true);
        tregistrasi();
        if (!$('body').hasClass('control-sidebar-slide-open')) {
            $('#toggle-sidebar-pasien').trigger('click');
        }
    });

    $(document).on('change', 'input[name="jenis_toggle"]', function() {
        toggleJenis($(this).val());
    });

    $(document).on('change', 'input[name="penurunanBeratBadan"]', function() {
        var isC = $('#pbb_c').is(':checked');
        $('#jumlah_penurunan_wrap').toggle(isC);
        if (!isC) $('input[name="jumlahPenurunanBeratBadan"]').prop('checked', false);
        hitungSkor();
    });

    $(document).on('change', 'input[name="jumlahPenurunanBeratBadan"], input[name="asupanBerkurang"], input[name="diagnosaKhusus"], #section_anak input[type="radio"]', function() {
        hitungSkor();
    });

    $('#modalAddSkrining').on('show.bs.modal', function() {
        $('#skr_no_registrasi').val($('#f_no_registrasi').val());
    });

    $('#modalAddSkrining').on('hidden.bs.modal', function() {
        $('#form_skrining')[0].reset();
        toggleJenis('DEWASA');
        $('#jumlah_penurunan_wrap').hide();
        $('#skr_no_registrasi').val($('#f_no_registrasi').val());
    });

    $(document).on('submit', '#form_skrining', function(e) {
        e.preventDefault();
        var no_reg = $('#f_no_registrasi').val();
        if (!no_reg) { Swal.fire({ icon:'warning', title:'Peringatan', text:'Pilih pasien terlebih dahulu.' }); return; }

        var $btn = $('#btn_submit_skrining');

        $.ajax({
            url: "<?= site_url('skriningizi/action'); ?>",
            method: "POST", data: $(this).serialize(), dataType: "JSON",
            beforeSend: function(){ $btn.prop('disabled',true).html('<i class="fa fa-spin fa-spinner"></i> Menyimpan...'); },
            complete:   function(){ $btn.prop('disabled',false).html('<i class="fas fa-save mr-1"></i> Simpan'); },
            success: function(response) {
                if (response.error) {
                    Swal.fire({ icon:'error', title:'Gagal Menyimpan', text: extractError(response) });
                } else if (response.success) {
                    Swal.fire({ icon:'success', title:'Berhasil', text: response.success }).then(function(){
                        $('#modalAddSkrining').modal('hide');
                        fetchSkriningData();
                    });
                }
            },
            error: function(){ Swal.fire({ icon:'error', title:'Gagal', text:'Tidak dapat menghubungi server.' }); }
        });
    });

    $('#btn_refresh').on('click', function(){ fetchSkriningData(); });

    $('#btn_cetak').on('click', function() {
        var no_reg = $('#f_no_registrasi').val();
        if (!no_reg) { Swal.fire({ icon:'warning', title:'Peringatan', text:'Pilih pasien terlebih dahulu.' }); return; }
        var params = new URLSearchParams({
            no_rm       : $('#medrec_id_info').text().trim(),
            nama_pasien : $('#fullname_tm').text().trim(),
            tgl_lahir   : $('#birth_dt_tm').text().trim(),
            gender      : $('#gender_tm').text().trim()
        });
        window.open("<?= site_url('skriningizi/printSkriningGizi'); ?>/" + no_reg + '?' + params.toString(), '_blank');
    });

    $(document).on('click', '.clickable-col', function() {
        var d = $(this).closest('tr').data('row');
        if (!d) return;

        $('#skr_action').val('Edit');
        $('#skr_no_registrasi').val($('#f_no_registrasi').val());

        toggleJenis(d.jenisScreening || 'DEWASA');

        if (d.jenisScreening === 'DEWASA') {
            var isJumlah = (d.jumlahPenurunanBeratBadan !== null && d.jumlahPenurunanBeratBadan !== undefined && d.jumlahPenurunanBeratBadan !== 0);
            if (isJumlah) {
                $('#pbb_c').prop('checked', true);
                $('#jumlah_penurunan_wrap').show();
                $('input[name="jumlahPenurunanBeratBadan"][value="' + d.jumlahPenurunanBeratBadan + '"]').prop('checked', true);
            } else {
                $('input[name="penurunanBeratBadan"][value="' + (d.penurunanBeratBadan ?? 0) + '"]').prop('checked', true);
            }
            $('input[name="asupanBerkurang"][value="' + (d.asupanBerkurang ?? 0) + '"]').prop('checked', true);
            $('input[name="diagnosaKhusus"][value="' + (d.diagnosaKhusus ?? 0) + '"]').prop('checked', true);
        } else {
            $('input[name="tampakKurus"][value="' + (d.tampakKurus ?? 0) + '"]').prop('checked', true);
            $('input[name="anakPenurunanBeratBadan"][value="' + (d.anakPenurunanBeratBadan ?? 0) + '"]').prop('checked', true);
            $('input[name="kondisi"][value="' + (d.kondisi ?? 0) + '"]').prop('checked', true);
            $('input[name="terdapatPenyakitKeadaan"][value="' + (d.terdapatPenyakitKeadaan ?? 0) + '"]').prop('checked', true);
        }

        hitungSkor();
        $('#modalAddSkrining').modal('show');
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

        $.ajax({ url:"<?= site_url('skriningizi/setNoRegistrasi'); ?>", method:"GET",
            data:{ no_registrasi: no_registrasi, patient_no: patient_no } });

        $('#f_no_registrasi').val(no_registrasi);
        $('#f_medrec_id').val(patient_no);
        $('#skr_no_registrasi').val(no_registrasi);

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
        fetchSkriningData();
    });

    $(document).on('click', '.delete', function() {
        var no_registrasi = $(this).data('no_registrasi');
        if (!no_registrasi) { Swal.fire({ icon:'error', title:'Error', text:'No. Registrasi tidak ditemukan.' }); return; }
        Swal.fire({
            title: 'Yakin ingin menghapus data?',
            text: 'Data skrining gizi akan dihapus secara permanen.',
            icon: 'warning', showCancelButton: true,
            confirmButtonText: 'Ya, hapus!', cancelButtonText: 'Batal'
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('skriningizi/delete'); ?>",
                    method: "POST", data: { no_registrasi: no_registrasi }, dataType: "JSON",
                    success: function(response) {
                        if (response.status === 'error') {
                            Swal.fire({ icon:'error', title:'Gagal', text: response.message || 'Gagal menghapus.' });
                        } else {
                            Swal.fire({ icon:'success', title:'Berhasil', text: response.message || 'Data berhasil dihapus.' })
                                .then(function(){ fetchSkriningData(); });
                        }
                    },
                    error: function(){ Swal.fire({ icon:'error', title:'Gagal', text:'Terjadi kesalahan server.' }); }
                });
            }
        });
    });
    </script>
    <?= $this->endSection('script'); ?>