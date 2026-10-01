<?= $this->extend('./clinic_template'); ?>

<?= $this->section('style'); ?>
<!-- Font Awesome -->
<link rel="stylesheet" href="<?= base_url('plugins/fontawesome-free/css/all.min.css') ?>">

<style>
    .riwayat-section {
        background: white;
        border-radius: 12px;
        padding: 20px 25px 25px 25px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        margin-top: 10px;
    }

    .riwayat-section .section-title {
        font-weight: 600;
        font-size: 20px;
        color: #2d3748;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f1f3f5;
    }

    .riwayat-section .section-title i {
        color: #007bff;
        margin-right: 10px;
    }

    .search-box-riwayat {
        margin-bottom: 20px;
    }

    .search-box-riwayat .input-group {
        width: 100%;
    }

    .search-box-riwayat .input-group-text {
        background: white;
        border-right: none;
        color: #6c757d;
        border-radius: 8px 0 0 8px;
        padding: 10px 15px;
    }

    .search-box-riwayat .form-control {
        border-left: none;
        padding: 10px 15px;
        font-size: 14px;
        height: 45px;
        border-radius: 0;
    }

    .search-box-riwayat .form-control:focus {
        box-shadow: none;
        border-color: #ced4da;
    }

    .search-box-riwayat .btn-search {
        background: #007bff;
        color: white;
        padding: 8px 30px;
        border-radius: 0 8px 8px 0;
        height: 45px;
        border: 1px solid #007bff;
    }

    .search-box-riwayat .btn-search:hover {
        background: #0069d9;
        border-color: #0069d9;
    }

    .search-box-riwayat .btn-reset-search {
        background: none;
        border: none;
        color: #6c757d;
        cursor: pointer;
        font-size: 13px;
        padding: 8px 15px;
        height: 45px;
    }

    .search-box-riwayat .btn-reset-search:hover {
        color: #dc3545;
    }

    .search-box-riwayat .search-hint {
        font-size: 12px;
        color: #6c757d;
        margin-top: 6px;
        padding-left: 5px;
    }

    .search-box-riwayat .search-hint i {
        margin-right: 5px;
    }

    .result-container {
        display: none;
        margin-top: 5px;
    }

    .result-container.active {
        display: block;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(8px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .result-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
        padding: 8px 0;
    }

    .result-header h6 {
        margin-bottom: 0;
        font-weight: 600;
        font-size: 15px;
        color: #2d3748;
    }

    .result-header .badge-count {
        background: #e9ecef;
        color: #495057;
        padding: 2px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
    }

    .patient-list {
        display: flex;
        flex-direction: column;
        gap: 0;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        overflow: hidden;
    }

    .patient-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 20px;
        background: white;
        border-bottom: 1px solid #f1f3f5;
        transition: background 0.2s;
        cursor: pointer;
    }

    .patient-item:last-child {
        border-bottom: none;
    }

    .patient-item:hover {
        background: #f8f9fa;
    }

    .patient-item .patient-info {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .patient-item .patient-name {
        font-weight: 600;
        font-size: 15px;
        color: #2d3748;
    }

    .patient-item .patient-meta {
        display: flex;
        align-items: center;
        gap: 15px;
        font-size: 13px;
        color: #6c757d;
        flex-wrap: wrap;
    }

    .patient-item .patient-meta .rm-label {
        background: #e9ecef;
        padding: 1px 10px;
        border-radius: 10px;
        font-size: 12px;
        color: #495057;
    }

    .patient-item .patient-meta .gender-label {
        font-size: 12px;
    }

    .patient-item .btn-select {
        background: #007bff;
        color: white;
        border: none;
        padding: 6px 18px;
        border-radius: 6px;
        font-size: 13px;
        transition: all 0.2s;
        white-space: nowrap;
    }

    .patient-item .btn-select:hover {
        background: #0069d9;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 40px;
        opacity: 0.3;
        margin-bottom: 12px;
        display: block;
    }

    .empty-state h6 {
        color: #2d3748;
        margin-bottom: 4px;
        font-size: 15px;
    }

    .empty-state p {
        font-size: 13px;
        margin-bottom: 0;
    }

    .loading-state {
        text-align: center;
        padding: 30px 20px;
        color: #6c757d;
    }

    .loading-state i {
        font-size: 30px;
        color: #007bff;
        margin-bottom: 10px;
        display: block;
    }

    .menu-container {
        display: none;
        animation: fadeIn 0.4s ease;
    }

    .menu-container.active {
        display: block;
    }

    .profile-header {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 18px 22px;
        margin-bottom: 18px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        border: 1px solid #e9ecef;
    }

    .profile-header .profile-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .profile-header .profile-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
        font-weight: 600;
        flex-shrink: 0;
    }

    .profile-header .profile-name {
        font-size: 17px;
        font-weight: 700;
        color: #2d3748;
    }

    .profile-header .profile-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 6px 15px;
        margin-top: 2px;
    }

    .profile-header .profile-meta .meta-item {
        font-size: 12px;
        color: #4a5568;
    }

    .profile-header .profile-meta .meta-item strong {
        color: #2d3748;
    }

    .profile-header .back-btn {
        background: none;
        border: none;
        color: #007bff;
        cursor: pointer;
        font-size: 13px;
        padding: 0;
    }

    .profile-header .back-btn:hover {
        text-decoration: underline;
    }

    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 10px;
        margin-bottom: 18px;
    }

    .menu-card {
        background: white;
        border-radius: 8px;
        padding: 16px 12px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
        border: 2px solid #e9ecef;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
        position: relative;
    }

    .menu-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        border-color: #007bff;
    }

    .menu-card.active {
        border-color: #007bff;
        background: #f0f7ff;
    }

    .menu-card .menu-icon {
        font-size: 24px;
        margin-bottom: 4px;
        display: block;
        color: #007bff;
    }

    .menu-card .menu-label {
        font-size: 13px;
        font-weight: 600;
        color: #2d3748;
    }

    .menu-card .menu-badge {
        background: #007bff;
        color: white;
        border-radius: 50%;
        padding: 0 8px;
        font-size: 10px;
        float: right;
        margin-top: -4px;
    }

    .menu-card .menu-link-icon {
        position: absolute;
        top: 6px;
        right: 8px;
        font-size: 12px;
        color: #007bff;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .menu-card:hover .menu-link-icon {
        opacity: 1;
    }

    .alergi-item {
        padding: 10px 18px;
        border-bottom: 1px solid #f1f3f5;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }

    .alergi-item:last-child {
        border-bottom: none;
    }

    .alergi-item .alergi-name {
        font-weight: 600;
        color: #2d3748;
        font-size: 14px;
    }

    .alergi-item .alergi-category {
        font-size: 12px;
        color: #4a5568;
    }

    .no-data {
        text-align: center;
        padding: 30px 20px;
        color: #6c757d;
    }

    .no-data i {
        font-size: 32px;
        opacity: 0.3;
        margin-bottom: 10px;
        display: block;
    }

    .no-data h6 {
        color: #2d3748;
        margin-bottom: 3px;
        font-size: 14px;
    }

    .no-data p {
        font-size: 13px;
        margin-bottom: 0;
    }

    /* Toast/Swal customization */
    .swal2-popup {
        font-size: 14px !important;
    }

    @media (max-width: 768px) {
        .riwayat-section {
            padding: 15px;
        }

        .profile-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .profile-header .back-btn {
            margin-top: 4px;
        }

        .menu-grid {
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        }

        .patient-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .patient-item .btn-select {
            width: 100%;
            text-align: center;
        }

        .search-box-riwayat .input-group {
            width: 100%;
        }

        .search-box-riwayat .btn-search {
            padding: 8px 20px;
        }
    }
</style>
<?= $this->endSection('style'); ?>

<?= $this->section('content'); ?>

<div class="content-wrapper">
    <div class="content-header" style="padding-bottom: 0;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1 class="m-0" style="font-size: 24px; font-weight: 600;">Riwayat Rekam Medis</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <div class="riwayat-section">

                <div class="section-title">
                    <i class="fas fa-users"></i> Pasien Terdaftar
                </div>

                <!-- SEARCH BOX -->
                <div class="search-box-riwayat">
                    <div class="row">
                        <div class="col-12">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                <input type="text"
                                    class="form-control"
                                    id="searchInput"
                                    placeholder="Cari pasien berdasarkan nama atau No. RM..."
                                    autocomplete="off">
                                <button class="btn btn-search" id="btnSearch" type="button">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                                <button class="btn-reset-search" id="btnClearSearch" type="button" title="Reset pencarian">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="search-hint">
                                <i class="fas fa-info-circle"></i>
                                Masukkan nama lengkap atau Nomor Rekam Medis pasien
                            </div>
                        </div>
                    </div>
                </div>

                <!-- HASIL PENCARIAN -->
                <div class="result-container" id="resultContainer">
                    <div class="result-header">
                        <h6>
                            Hasil Pencarian
                            <span class="badge-count ml-2" id="resultCount">0</span>
                        </h6>
                    </div>
                    <div id="patientList" class="patient-list"></div>
                </div>

                <!-- LAYAR MENU (setelah pilih pasien) -->
                <div id="layarMenu" class="menu-container">

                    <div class="profile-header">
                        <div class="profile-left">
                            <div class="profile-avatar" id="profileAvatar">A</div>
                            <div>
                                <div class="profile-name" id="profileName">-</div>
                                <div class="profile-meta">
                                    <span class="meta-item">
                                        <i class="fas fa-id-card"></i>
                                        <strong id="profileRm">-</strong>
                                    </span>
                                    <span class="meta-item">
                                        <i class="fas fa-calendar-alt"></i>
                                        <strong id="profileBirth">-</strong>
                                    </span>
                                    <span class="meta-item">
                                        <i class="fas fa-venus-mars"></i>
                                        <strong id="profileGender">-</strong>
                                    </span>
                                    <span class="meta-item">
                                        <i class="fas fa-phone"></i>
                                        <strong id="profilePhone">-</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button class="back-btn" id="btnBackToSearch">
                                <i class="fas fa-arrow-left"></i> Kembali ke pencarian
                            </button>
                        </div>
                    </div>

                    <!-- Menu Grid: 3 card dengan link open new tab -->
                    <div class="menu-grid" id="menuGrid">
                        <div class="menu-card active" data-menu="kunjungan" data-url="<?= site_url('/rmriwayatmedis/kunjungan') ?>">
                            <span class="menu-icon"><i class="fas fa-history"></i></span>
                            <span class="menu-label">Riwayat Kunjungan</span>
                            <span class="menu-badge" id="menuBadgeKunjungan">0</span>
                            <span class="menu-link-icon"><i class="fas fa-external-link-alt"></i></span>
                        </div>
                        <div class="menu-card" data-menu="alergi" data-url="<?= site_url('/rmriwayatmedis/alergi') ?>">
                            <span class="menu-icon"><i class="fas fa-allergies"></i></span>
                            <span class="menu-label">Alergi</span>
                            <span class="menu-badge" id="menuBadgeAlergi">0</span>
                            <span class="menu-link-icon"><i class="fas fa-external-link-alt"></i></span>
                        </div>
                        <div class="menu-card" data-menu="diagnosis" data-url="<?= site_url('/rmriwayatmedis/diagnosis') ?>">
                            <span class="menu-icon"><i class="fas fa-notes-medical"></i></span>
                            <span class="menu-label">Diagnosis</span>
                            <span class="menu-link-icon"><i class="fas fa-external-link-alt"></i></span>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </section>
</div>

<input type="hidden" id="selectedPatientNo">

<?= $this->endSection('content'); ?>

<?= $this->section('script'); ?>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $('#active-menu').html('Riwayat Rekam Medis');
    $(document).prop("title", 'Riwayat Rekam Medis');
</script>

<script>
    $(document).ready(function() {

        var currentPatientNo = '';

        // ==========================================
        // SEARCH PASIEN
        // ==========================================
        function searchPatient() {
            var keyword = $('#searchInput').val().trim();

            if (keyword === '') {
                $('#resultContainer').removeClass('active');
                $('#patientList').html('');
                return;
            }

            $.ajax({
                url: "<?= site_url('rmriwayatmedis/searchPatient'); ?>",
                method: "POST",
                data: {
                    keyword: keyword
                },
                dataType: "JSON",
                beforeSend: function() {
                    $('#patientList').html(`
                        <div class="loading-state">
                            <i class="fas fa-spinner fa-spin"></i>
                            <span>Mencari data...</span>
                        </div>
                    `);
                    $('#resultContainer').addClass('active');
                    $('#layarMenu').removeClass('active');
                },
                success: function(response) {
                    if (response.status === 'success' && response.data.length > 0) {
                        renderPatientList(response.data);
                    } else {
                        $('#patientList').html(`
                            <div class="empty-state">
                                <i class="fas fa-user-slash"></i>
                                <h6>Pasien tidak ditemukan</h6>
                                <p>Coba dengan keyword lain</p>
                            </div>
                        `);
                        $('#resultCount').text('0');
                    }
                },
                error: function() {
                    $('#patientList').html(`
                        <div class="empty-state text-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                            <h6>Gagal terhubung ke server</h6>
                            <p>Silahkan coba lagi</p>
                        </div>
                    `);
                }
            });
        }

        function renderPatientList(patients) {
            var html = '';
            $('#resultCount').text(patients.length);

            patients.forEach(function(patient) {
                var genderLabel = patient.gender === 'F' ? 'Perempuan' : 'Laki-laki';
                var genderIcon = patient.gender === 'F' ? 'fa-venus text-danger' : 'fa-mars text-primary';

                html += `
                    <div class="patient-item"
                         data-patient_no="${patient.patientNo}"
                         onclick="selectPatient('${patient.patientNo}')">
                        <div class="patient-info">
                            <div class="patient-name">${patient.fullName || '-'}</div>
                            <div class="patient-meta">
                                <span class="rm-label">
                                    <i class="fas fa-id-card"></i> ${patient.patientNo || '-'}
                                </span>
                                <span class="gender-label">
                                    <i class="fas ${genderIcon}"></i> ${genderLabel}
                                </span>
                                ${patient.hasAlergi ? '<span class="badge badge-danger">Alergi</span>' : ''}
                            </div>
                        </div>
                        <button class="btn-select">
                            <i class="fas fa-chevron-right"></i> Catatan Rekam Medis
                        </button>
                    </div>
                `;
            });

            $('#patientList').html(html);
        }

        // ==========================================
        // SELECT PASIEN -> TAMPILKAN PROFILE + MENU
        // ==========================================
        window.selectPatient = function(patientNo) {
            currentPatientNo = patientNo;
            $('#selectedPatientNo').val(patientNo);

            $.ajax({
                url: "<?= site_url('rmriwayatmedis/getPatientDetail'); ?>",
                method: "POST",
                data: {
                    patient_no: patientNo
                },
                dataType: "JSON",
                beforeSend: function() {
                    $('#layarMenu').addClass('active');
                    $('#resultContainer').removeClass('active');
                },
                success: function(response) {
                    if (response.status === 'success') {
                        var pasien = response.data.patient;
                        var menu = response.data.menu || {};

                        var initial = pasien.fullName ? pasien.fullName.charAt(0).toUpperCase() : '?';
                        $('#profileAvatar').text(initial);
                        $('#profileName').text(pasien.fullName || '-');
                        $('#profileRm').text(pasien.patientNo || '-');
                        $('#profileGender').text(pasien.gender === 'F' ? 'Perempuan' : 'Laki-laki');
                        $('#profileBirth').text(formatDate(pasien.birthDt));
                        $('#profilePhone').text(pasien.mobileNo || '-');

                        $('#menuBadgeKunjungan').text(menu.kunjunganCount || 0);
                        $('#menuBadgeAlergi').text(menu.alergiCount || 0);

                        // Set menu default aktif
                        $('.menu-card').removeClass('active');
                        $('.menu-card[data-menu="kunjungan"]').addClass('active');
                    } else {
                        // Tampilkan error jika perlu
                    }
                },
                error: function() {
                    // Handle error
                }
            });
        };

        // ==========================================
        // MENU CARD CLICK - OPEN NEW TAB
        // ==========================================
        $(document).on('click', '.menu-card', function(e) {
            var menu = $(this).data('menu');
            var baseUrl = $(this).data('url');

            if (!currentPatientNo) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Silakan pilih pasien terlebih dahulu',
                    confirmButtonColor: '#007bff'
                });
                return;
            }

            // Buka new tab dengan URL detail
            var targetUrl = baseUrl + '/' + currentPatientNo;
            window.open(targetUrl, '_blank');

            // Aktifkan menu card yang diklik
            $('.menu-card').removeClass('active');
            $(this).addClass('active');
        });

        // ==========================================
        // HELPERS
        // ==========================================
        function formatDate(dateStr) {
            if (!dateStr) return '-';
            try {
                var d = new Date(dateStr);
                return d.toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                });
            } catch (e) {
                return dateStr;
            }
        }

        // ==========================================
        // EVENTS
        // ==========================================
        $('#btnSearch').on('click', searchPatient);
        $('#searchInput').on('keypress', function(e) {
            if (e.which === 13) searchPatient();
        });

        $('#btnClearSearch').on('click', function() {
            $('#searchInput').val('');
            $('#resultContainer').removeClass('active');
            $('#patientList').html('');
            $('#resultCount').text('0');
            $('#layarMenu').removeClass('active');
            currentPatientNo = '';
            $('#searchInput').focus();
        });

        $('#btnBackToSearch').on('click', function() {
            $('#layarMenu').removeClass('active');
            $('#resultContainer').addClass('active');
            $('#searchInput').focus();
        });

        setTimeout(function() {
            $('#searchInput').focus();
        }, 500);

    });
</script>
<?= $this->endSection('script'); ?>