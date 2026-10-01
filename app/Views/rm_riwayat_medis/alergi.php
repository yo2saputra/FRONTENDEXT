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

    .alergi-container {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #e9ecef;
    }

    .alergi-container .alergi-header {
        background: #f8f9fa;
        padding: 12px 18px;
        border-bottom: 1px solid #e9ecef;
        font-weight: 600;
        font-size: 14px;
        color: #2d3748;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .alergi-table {
        width: 100%;
        border-collapse: collapse;
    }

    .alergi-table thead {
        background: #f1f3f5;
    }

    .alergi-table thead th {
        padding: 10px 15px;
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        color: #495057;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        border-bottom: 2px solid #dee2e6;
    }

    .alergi-table tbody td {
        padding: 10px 15px;
        font-size: 13px;
        color: #2d3748;
        border-bottom: 1px solid #f1f3f5;
        vertical-align: middle;
    }

    .alergi-table tbody tr:hover {
        background: #f8f9fa;
    }

    .alergi-table tbody tr:last-child td {
        border-bottom: none;
    }

    .badge-alergi {
        display: inline-block;
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 500;
        margin: 2px 3px;
        background: #e9ecef;
        color: #495057;
    }

    .badge-alergi.badge-danger {
        background: #f8d7da;
        color: #721c24;
    }

    .badge-alergi.badge-warning {
        background: #fff3cd;
        color: #856404;
    }

    .badge-alergi.badge-info {
        background: #d1ecf1;
        color: #0c5460;
    }

    .badge-alergi.badge-success {
        background: #d4edda;
        color: #155724;
    }

    .keterangan-text {
        font-size: 12px;
        color: #6c757d;
        font-style: italic;
        max-width: 150px;
        word-wrap: break-word;
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

    .no-wrap {
        white-space: nowrap;
    }

    @media (max-width: 768px) {
        .alergi-table {
            display: block;
            overflow-x: auto;
        }

        .patient-info-card .info-row {
            flex-direction: column;
            gap: 5px;
        }
    }
</style>
<?= $this->endSection('style'); ?>

<?= $this->section('content'); ?>

<div class="content-wrapper">
    <section class="content pt-3 pb-3">
        <div class="container-fluid">
            <div class="detail-container">
                <div class="detail-header">
                    <h3>
                        <i class="fas fa-allergies text-danger mr-2"></i>
                        Riwayat Alergi Pasien
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

        $.ajax({
            url: "<?= site_url('rmriwayatmedis/getDetailPageDataAlergi') ?>",
            method: "POST",
            data: {
                patient_no: patientNo
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

                    // Tampilkan data alergi dalam tabel
                    html += renderAlergiTable(items);

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

    function renderAlergiTable(items) {
        var html = `
    <div class="alergi-container">
        <div class="alergi-header">
            <span><i class="fas fa-list mr-2"></i>Data Alergi</span>
            <span class="badge badge-danger">${items.length} Data</span>
        </div>
    `;

        if (items.length === 0) {
            html += `
        <div class="no-data">
            <i class="fas fa-check-circle text-success"></i>
            <h6>Tidak Ada Alergi</h6>
            <p>Pasien ini tidak memiliki riwayat alergi</p>
        </div>
    `;
        } else {
            html += `
        <table class="alergi-table">
            <thead>
                <tr>
                    <th style="width:5%;" class="no-wrap">NO</th>
                    <th style="width:15%;">Jenis</th>
                    <th style="width:25%;">Komponen</th>
                    <th style="width:25%;">Reaksi</th>
                    <th style="width:30%;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
        `;

            items.forEach(function(item, index) {
                // Parse komponen dan reaksi (jika berbentuk string dengan koma)
                var komponenList = [];
                var reaksiList = [];

                if (item.komponen) {
                    komponenList = String(item.komponen).split(',').map(function(v) {
                        return v.replace(/\+/g, '').trim();
                    }).filter(function(v) {
                        return v !== '';
                    });
                }

                if (item.reaksi) {
                    reaksiList = String(item.reaksi).split(',').map(function(v) {
                        return v.replace(/\+/g, '').trim();
                    }).filter(function(v) {
                        return v !== '';
                    });
                }

                var komponenHtml = komponenList.length > 0 ?
                    komponenList.map(function(k) {
                        return '<span class="badge-alergi badge-info">' + k + '</span>';
                    }).join('') :
                    '<span class="text-muted">-</span>';

                var reaksiHtml = reaksiList.length > 0 ?
                    reaksiList.map(function(r) {
                        return '<span class="badge-alergi badge-warning">' + r + '</span>';
                    }).join('') :
                    '<span class="text-muted">-</span>';

                html += `
            <tr>
                <td class="no-wrap center"><strong>${index + 1}</strong></td>
                <td><strong>${item.kategori || '-'}</strong></td>
                <td>${komponenHtml}</td>
                <td>${reaksiHtml}</td>
                <td>
                    <span class="keterangan-text">
                        ${item.keterangan || '-'}
                    </span>
                </td>
            </tr>
        `;
            });

            html += `
            </tbody>
        </table>
        `;
        }

        html += `</div>`;
        return html;
    }

    function formatDate(dateStr) {
        if (!dateStr) return '-';
        try {
            var d = new Date(dateStr);
            if (isNaN(d.getTime())) return dateStr;
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