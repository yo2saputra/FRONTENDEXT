<?= $this->extend('./clinic_template'); ?>

<?= $this->section('style'); ?>
<link rel="stylesheet" href="<?= base_url('plugins/fontawesome-free/css/all.min.css') ?>">
<style>
    .detail-container {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        margin: 20px;
    }

    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 15px;
        border-bottom: 2px solid #f1f3f5;
        margin-bottom: 20px;
    }

    .detail-header h3 {
        font-weight: 600;
        color: #2d3748;
    }

    .patient-info-card {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px 20px;
        margin-bottom: 20px;
        border: 1px solid #e9ecef;
    }

    .patient-info-card .info-row {
        display: flex;
        flex-wrap: wrap;
        gap: 10px 25px;
    }

    .patient-info-card .info-item {
        font-size: 14px;
        color: #4a5568;
    }

    .patient-info-card .info-item strong {
        color: #2d3748;
    }

    .kunjungan-container {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #e9ecef;
    }

    .kunjungan-container .kunjungan-header {
        background: #f8f9fa;
        padding: 12px 18px;
        border-bottom: 1px solid #e9ecef;
        font-weight: 600;
        font-size: 14px;
        color: #2d3748;
    }

    .kunjungan-item {
        padding: 12px 18px;
        border-bottom: 1px solid #f1f3f5;
        transition: background 0.2s;
    }

    .kunjungan-item:hover {
        background: #f8f9fa;
    }

    .kunjungan-item:last-child {
        border-bottom: none;
    }

    .kunjungan-item .kunjungan-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }

    .kunjungan-item .kunjungan-title {
        font-weight: 600;
        color: #2d3748;
        font-size: 14px;
    }

    .kunjungan-item .kunjungan-title .badge-status {
        font-size: 10px;
        font-weight: 500;
        padding: 2px 10px;
        border-radius: 12px;
        margin-left: 8px;
    }

    .kunjungan-item .kunjungan-date {
        color: #718096;
        font-size: 12px;
    }

    .kunjungan-item .kunjungan-bottom {
        margin-top: 4px;
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .kunjungan-item .kunjungan-bottom .info-item {
        font-size: 12px;
        color: #4a5568;
    }

    .kunjungan-item .kunjungan-bottom .info-item strong {
        color: #2d3748;
        font-weight: 500;
    }

    .kunjungan-detail {
        display: none;
        padding: 12px 15px 10px;
        background: #f8f9fa;
        border-radius: 6px;
        margin-top: 8px;
    }

    .kunjungan-detail.active {
        display: block;
        animation: fadeIn 0.3s ease;
    }

    .kunjungan-detail .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .kunjungan-detail .detail-group .detail-label {
        font-size: 10px;
        font-weight: 600;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin-bottom: 2px;
    }

    .kunjungan-detail .detail-group .detail-value {
        font-size: 13px;
        color: #2d3748;
        padding: 5px 10px;
        background: white;
        border-radius: 4px;
        border: 1px solid #e9ecef;
        min-height: 28px;
    }

    .kunjungan-detail .detail-group .detail-value .badge-detail {
        background: #e9ecef;
        padding: 1px 8px;
        border-radius: 10px;
        font-size: 11px;
        color: #495057;
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
        padding: 40px 20px;
        color: #6c757d;
    }

    .no-data i {
        font-size: 40px;
        opacity: 0.3;
        margin-bottom: 12px;
        display: block;
    }

    .no-data h6 {
        color: #2d3748;
        margin-bottom: 4px;
        font-size: 15px;
    }

    .no-data p {
        font-size: 13px;
        margin-bottom: 0;
    }

    .loading-state {
        text-align: center;
        padding: 40px 20px;
        color: #6c757d;
    }

    .loading-state i {
        font-size: 30px;
        color: #007bff;
        margin-bottom: 10px;
        display: block;
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

    @media (max-width: 768px) {
        .kunjungan-detail .detail-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
<?= $this->endSection('style'); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="detail-container">
                <div class="detail-header">
                    <h3>
                        <i class="fas fa-<?= $menu == 'kunjungan' ? 'history' : ($menu == 'alergi' ? 'allergies' : 'notes-medical') ?> text-primary mr-2"></i>
                        <?= $menu == 'kunjungan' ? 'Riwayat Kunjungan' : ($menu == 'alergi' ? 'Riwayat Alergi' : 'Riwayat Diagnosis') ?>
                    </h3>
                    <button class="btn btn-sm btn-outline-secondary" onclick="window.close()">
                        <i class="fas fa-times"></i> Tutup
                    </button>
                </div>

                <div id="detailContent">
                    <div class="loading-state">
                        <i class="fas fa-spinner fa-spin"></i>
                        <span>Memuat data...</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection('content'); ?>

<?= $this->section('script'); ?>
<script>
    $(document).ready(function() {
        var patientNo = '<?= $patientNo ?>';
        var menu = '<?= $menu ?>';

        $.ajax({
            url: "<?= site_url('rmriwayatmedis/getDetailPageData') ?>",
            method: "POST",
            data: {
                patient_no: patientNo,
                menu: menu
            },
            dataType: "JSON",
            success: function(response) {
                if (response.status === 'success') {
                    var patient = response.patient || {};
                    var items = response.data || [];

                    // Tampilkan info pasien
                    var html = `
                    <div class="patient-info-card">
                        <div class="info-row">
                            <span class="info-item"><strong>Nama:</strong> ${patient.fullName || '-'}</span>
                            <span class="info-item"><strong>No. RM:</strong> ${patient.patientNo || '-'}</span>
                            <span class="info-item"><strong>Tanggal Lahir:</strong> ${formatDate(patient.birthDt)}</span>
                            <span class="info-item"><strong>Jenis Kelamin:</strong> ${patient.gender === 'F' ? 'Perempuan' : 'Laki-laki'}</span>
                        </div>
                    </div>
                `;

                    // Tampilkan data sesuai menu
                    if (menu === 'kunjungan') {
                        html += renderKunjungan(items);
                    } else if (menu === 'alergi') {
                        html += renderAlergi(items);
                    } else if (menu === 'diagnosis') {
                        html += renderDiagnosis(items);
                    }

                    $('#detailContent').html(html);
                } else {
                    $('#detailContent').html(`
                    <div class="no-data text-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h6>Gagal memuat data</h6>
                        <p>Silahkan coba lagi</p>
                    </div>
                `);
                }
            },
            error: function() {
                $('#detailContent').html(`
                <div class="no-data text-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    <h6>Gagal terhubung ke server</h6>
                    <p>Silahkan coba lagi</p>
                </div>
            `);
            }
        });
    });

    function renderKunjungan(items) {
        var html = `
        <div class="kunjungan-container">
            <div class="kunjungan-header">
                <i class="fas fa-history text-primary mr-2"></i>
                Riwayat Kunjungan
                <span class="badge badge-primary ml-2">${items.length}</span>
            </div>
    `;

        if (items.length === 0) {
            html += `
            <div class="no-data">
                <i class="fas fa-folder-open"></i>
                <h6>Belum ada riwayat kunjungan</h6>
                <p>Pasien ini belum pernah melakukan kunjungan</p>
            </div>
        `;
        } else {
            items.forEach(function(item) {
                var statusBadge = item.status === 'DT' ? 'warning' : 'success';
                var statusLabel = item.status === 'DT' ? 'Draft' : 'Selesai';
                var tgl = formatDate(item.tglRegistrasi || item.tglPraktek);

                html += `
                <div class="kunjungan-item" data-no_registrasi="${item.noRegistrasi}">
                    <div class="kunjungan-top">
                        <div>
                            <span class="kunjungan-title">
                                <i class="fas fa-file-medical text-primary"></i>
                                ${item.noRegistrasi}
                                <span class="badge badge-${statusBadge} badge-status">${statusLabel}</span>
                            </span>
                        </div>
                        <span class="kunjungan-date">
                            <i class="far fa-calendar-alt"></i> ${tgl}
                        </span>
                    </div>
                    <div class="kunjungan-bottom">
                        <span class="info-item">
                            <i class="fas fa-user-md"></i> <strong>${item.namaDokter || '-'}</strong>
                        </span>
                        <span class="info-item">
                            <i class="fas fa-clinic-medical"></i> ${item.tujuanRegistrasiDesc || '-'}
                        </span>
                        <span class="info-item">
                            <i class="fas fa-notes-medical"></i> ${item.keluhanUtama || '-'}
                        </span>
                        <button class="btn btn-sm btn-link p-0" onclick="toggleDetail('${item.noRegistrasi}', this)">
                            <i class="fas fa-chevron-down"></i> Detail
                        </button>
                    </div>
                    <div class="kunjungan-detail" id="detailKunjungan_${item.noRegistrasi}">
                        <div class="text-center p-2">
                            <i class="fas fa-spinner fa-spin"></i> Memuat detail...
                        </div>
                    </div>
                </div>
            `;
            });
        }

        html += `</div>`;
        return html;
    }

    function renderAlergi(items) {
        var html = `
        <div class="kunjungan-container">
            <div class="kunjungan-header">
                <i class="fas fa-allergies text-primary mr-2"></i>
                Daftar Alergi
                <span class="badge badge-primary ml-2">${items.length}</span>
            </div>
    `;

        if (items.length === 0) {
            html += `
            <div class="no-data">
                <i class="fas fa-check-circle text-success"></i>
                <h6>Tidak ada alergi terdaftar</h6>
                <p>Pasien ini tidak memiliki riwayat alergi</p>
            </div>
        `;
        } else {
            items.forEach(function(item) {
                var levelBadge = item.tingkatKegawatan === 'Berat' ? 'danger' :
                    item.tingkatKegawatan === 'Sedang' ? 'warning' : 'info';

                html += `
                <div class="alergi-item">
                    <div>
                        <span class="alergi-name">
                            <span class="badge badge-${levelBadge}">${item.kategori || '-'}</span>
                            ${item.bahan || ''}
                        </span>
                        <div class="alergi-category mt-1">
                            <small><strong>Reaksi:</strong> ${item.reaksi || '-'}</small>
                        </div>
                    </div>
                    <div>
                        <span class="badge badge-secondary">${item.status || '-'}</span>
                    </div>
                </div>
            `;
            });
        }

        html += `</div>`;
        return html;
    }

    function renderDiagnosis(items) {
        var html = `
        <div class="kunjungan-container">
            <div class="kunjungan-header">
                <i class="fas fa-notes-medical text-primary mr-2"></i>
                Riwayat Diagnosa
                <span class="badge badge-primary ml-2">${items.length}</span>
            </div>
    `;

        if (items.length === 0) {
            html += `
            <div class="no-data">
                <i class="fas fa-folder-open"></i>
                <h6>Belum ada diagnosa tercatat</h6>
                <p>Diagnosa akan muncul setelah kunjungan</p>
            </div>
        `;
        } else {
            items.forEach(function(item) {
                html += `
                <div class="kunjungan-item" style="cursor:default;">
                    <div class="kunjungan-top">
                        <span class="kunjungan-title">
                            <i class="fas fa-file-medical text-primary"></i>
                            ${item.noRegistrasi}
                        </span>
                    </div>
                    <div class="kunjungan-bottom">
                        <span class="info-item">
                            <strong>Diagnosa Utama:</strong> ${item.diagnosaUtama || '-'}
                            <span class="badge badge-secondary ml-1">${item.icd10Utama || '-'}</span>
                        </span>
                    </div>
                    ${item.diagnosaSekunder ? `
                        <div class="kunjungan-bottom">
                            <span class="info-item">
                                <strong>Diagnosa Sekunder:</strong> ${item.diagnosaSekunder}
                                <span class="badge badge-secondary ml-1">${item.icd10Sekunder || '-'}</span>
                            </span>
                        </div>
                    ` : ''}
                </div>
            `;
            });
        }

        html += `</div>`;
        return html;
    }

    function toggleDetail(noRegistrasi, element) {
        var $detail = $('#detailKunjungan_' + noRegistrasi);

        if ($detail.hasClass('active')) {
            $detail.removeClass('active');
            $(element).html('<i class="fas fa-chevron-down"></i> Detail');
            return;
        }

        $detail.addClass('active');
        $(element).html('<i class="fas fa-chevron-up"></i> Tutup');

        if ($detail.data('loaded')) return;

        $.ajax({
            url: "<?= site_url('rmriwayatmedis/getDetailKunjungan') ?>",
            method: "POST",
            data: {
                no_registrasi: noRegistrasi
            },
            dataType: "JSON",
            success: function(response) {
                if (response.status === 'success') {
                    renderDetailKunjungan(noRegistrasi, response.data);
                    $detail.data('loaded', true);
                }
            }
        });
    }

    function renderDetailKunjungan(noRegistrasi, data) {
        var $detail = $('#detailKunjungan_' + noRegistrasi);
        var html = '<div class="detail-grid">';

        var anamnesa = data.anamnesa;
        if (anamnesa) {
            html += `
            <div>
                <div class="detail-group">
                    <div class="detail-label"><i class="fas fa-user-md"></i> Anamnesa</div>
                    <div class="detail-value">
                        <strong>Keluhan Utama:</strong> ${anamnesa.keluhanUtama || '-'}<br>
                        <strong>Riwayat Perjalanan:</strong> ${anamnesa.riwayatPerjalananKeluhan || '-'}<br>
                        <strong>Riwayat Dahulu:</strong> ${anamnesa.riwayatPenyakitDahulu || '-'}<br>
                        <strong>Operasi/Pengobatan:</strong> ${anamnesa.riwayatOperasiPengobatan || '-'}
                    </div>
                </div>
            </div>
        `;
        }

        var periksa = data.periksa;
        if (periksa) {
            html += `
            <div>
                <div class="detail-group">
                    <div class="detail-label"><i class="fas fa-heartbeat"></i> Pemeriksaan</div>
                    <div class="detail-value">
                        <strong>Kondisi Umum:</strong> ${periksa.kondisiUmum || '-'}<br>
                        <strong>TD:</strong> ${periksa.sistolik || '-'}/${periksa.diastolik || '-'} mmHg<br>
                        <strong>Nadi:</strong> ${periksa.denyutNadi || '-'} bpm<br>
                        <strong>Suhu:</strong> ${periksa.suhu || '-'} °C
                    </div>
                </div>
            </div>
        `;
        }

        var diagnosa = data.diagnosa;
        if (diagnosa) {
            html += `
            <div>
                <div class="detail-group">
                    <div class="detail-label"><i class="fas fa-notes-medical"></i> Diagnosa</div>
                    <div class="detail-value">
                        <strong>Utama:</strong> ${diagnosa.diagnosaUtama || '-'}<br>
                        <strong>ICD 10:</strong> <span class="badge-detail">${diagnosa.icd10Utama || '-'}</span><br>
                        <strong>Sekunder:</strong> ${diagnosa.diagnosaSekunder || '-'}
                    </div>
                </div>
            </div>
        `;
        }

        if (data.diagnosaTambahan && data.diagnosaTambahan.length > 0) {
            var tambahanHtml = data.diagnosaTambahan.map(function(d) {
                return `${d.diagnosa || '-'} <span class="badge-detail">${d.icd10 || '-'}</span>`;
            }).join('<br>');

            html += `
            <div>
                <div class="detail-group">
                    <div class="detail-label"><i class="fas fa-plus-circle"></i> Diagnosa Tambahan</div>
                    <div class="detail-value">${tambahanHtml}</div>
                </div>
            </div>
        `;
        }

        html += '</div>';
        $detail.html(html);
    }

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
</script>
<?= $this->endSection('script'); ?>