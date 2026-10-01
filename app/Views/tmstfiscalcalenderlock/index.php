<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>
<!-- SweetAlert2 -->
<link rel="stylesheet" href="<?= base_url('plugins/sweetalert2/sweetalert2.min.css') ?>">
<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<!-- Toastr -->
<link rel="stylesheet" href="<?= base_url('plugins/toastr/toastr.min.css') ?>">

<style>
    /* Card Styling - sama dengan fiscal calendar */
    .card-outline.card-info {
        border-top: 3px solid #17a2b8;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .card-body {
        padding: 20px;
    }

    /* Header Badge - sama dengan fiscal calendar */
    .current-year-badge {
        background: #28a745;
        color: white;
        padding: 0.4rem 1.5rem;
        border-radius: 20px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.8rem;
        font-size: 0.95rem;
    }

    /* Lock Cell Styling */
    .lock-cell {
        text-align: center;
        vertical-align: middle;
        user-select: none;
        min-width: 40px;
        padding: 12px 8px !important;
    }

    .lock-cell.locked {
        font-weight: bold;
        color: #dc3545;
        background-color: rgba(220, 53, 69, 0.1);
    }

    /* EDIT MODE PER YEAR */
    .edit-year-active .lock-cell {
        cursor: pointer;
        position: relative;
        transition: all 0.2s;
    }

    .edit-year-active .lock-cell:hover {
        background-color: rgba(108, 117, 125, 0.15);
        transform: scale(1.02);
    }

    .edit-year-active .lock-cell:hover::before {
        content: '✏️';
        position: absolute;
        top: -8px;
        right: -8px;
        font-size: 12px;
        background: #6c757d;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Year Header Styling - disesuaikan dengan fiscal calendar */
    .year-header {
        background: #f8f9fa;
        padding: 1rem 1.5rem !important;
        border-bottom: 1px solid #dee2e6;
    }

    .year-header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }

    .year-title {
        font-size: 1.75rem;
        font-weight: 600;
        color: #343a40;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .year-title i {
        background: rgba(0, 123, 255, 0.1);
        color: #007bff;
        padding: 8px;
        border-radius: 8px;
    }

    /* Badge untuk current year di table */
    .badge-current-year {
        background: #28a745;
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-left: 10px;
    }

    /* Edit Button Styling - Secondary Theme */
    .btn-edit-year {
        font-size: 12px;
        padding: 5px 12px;
        border-radius: 20px;
        border: 2px solid transparent;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        font-weight: 500;
    }

    .btn-edit-year.btn-secondary {
        background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
        border-color: #545b62;
        color: white;
    }

    .btn-edit-year.btn-secondary:hover {
        background: linear-gradient(135deg, #5a6268 0%, #484e53 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .btn-edit-year.btn-success {
        background: linear-gradient(135deg, #28a745 0%, #218838 100%);
        border-color: #1e7e34;
        color: white;
        animation: pulse 1.5s infinite;
    }

    .btn-edit-year.btn-success:hover {
        background: linear-gradient(135deg, #218838 0%, #1c7430 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.4);
        }

        70% {
            box-shadow: 0 0 0 6px rgba(40, 167, 69, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(40, 167, 69, 0);
        }
    }

    /* Period Header */
    .period-header {
        background-color: #e9ecef;
        color: #495057;
        font-weight: 600;
        text-align: center;
        padding: 12px 8px !important;
        border-bottom: 2px solid #dee2e6;
    }

    /* Module Column */
    .module-header {
        background-color: #f8f9fa;
        color: #495057;
        font-weight: 600;
        padding: 12px 15px !important;
        border-right: 2px solid #dee2e6;
    }

    /* Pagination Container - sama dengan fiscal calendar */
    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        border-bottom: 1px solid #dee2e6;
        background: #f8f9fa;
        margin-bottom: 20px;
        border-radius: 8px;
    }

    .pagination-controls {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .pagination-info {
        font-size: 0.9rem;
        color: #6c757d;
        min-width: 150px;
        text-align: center;
    }

    .page-btn {
        background: #fff;
        border: 1px solid #dee2e6;
        padding: 0.375rem 0.75rem;
        cursor: pointer;
        border-radius: 4px;
        transition: all 0.2s ease;
        min-width: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .page-btn:hover:not(:disabled) {
        background: #007bff;
        color: white;
        border-color: #007bff;
    }

    .page-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .page-btn i {
        font-size: 12px;
    }

    /* Search Container - sama dengan fiscal calendar */
    .search-container {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .search-input {
        padding: 0.375rem 0.75rem;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        width: 200px;
        font-size: 0.9rem;
    }

    .search-input:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    /* Loading Spinner - sama dengan fiscal calendar */
    .loading-spinner {
        display: inline-block;
        width: 2rem;
        height: 2rem;
        border: 3px solid rgba(0, 123, 255, 0.2);
        border-radius: 50%;
        border-top-color: #007bff;
        animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    /* Empty State - sama dengan fiscal calendar */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
    }

    .empty-state-icon {
        font-size: 3rem;
        color: #adb5bd;
        margin-bottom: 1rem;
    }

    .empty-state-title {
        font-size: 1.25rem;
        color: #6c757d;
        margin-bottom: 0.5rem;
    }

    /* Table Responsive */
    .table-responsive {
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #dee2e6;
    }

    .table-sm th,
    .table-sm td {
        padding: 10px 8px;
    }

    .table-bordered {
        border-collapse: separate;
        border-spacing: 0;
        margin-bottom: 0;
    }

    /* Responsive Design - sama dengan fiscal calendar */
    @media (max-width: 992px) {
        .pagination-container {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .search-container {
            align-self: stretch;
        }

        .search-input {
            width: 100%;
        }

        .year-title {
            font-size: 1.5rem;
        }

        .current-year-badge {
            font-size: 0.9rem;
            padding: 0.4rem 1.2rem;
        }
    }

    @media (max-width: 768px) {
        .year-header-content {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .btn-edit-year {
            align-self: flex-end;
        }

        .lock-cell {
            min-width: 35px;
            padding: 10px 6px !important;
        }

        .current-year-badge {
            font-size: 0.85rem;
            padding: 0.35rem 1rem;
        }
    }

    @media (max-width: 576px) {
        .pagination-container {
            align-items: stretch;
        }

        .pagination-controls {
            justify-content: center;
        }

        .search-container {
            width: 100%;
        }

        .search-input {
            width: 100%;
        }

        .year-title {
            font-size: 1.25rem;
        }

        .current-year-badge {
            font-size: 0.8rem;
            padding: 0.3rem 0.8rem;
        }
    }

    @media (max-width: 400px) {
        .pagination-controls {
            flex-wrap: wrap;
            justify-content: center;
        }

        .lock-cell {
            min-width: 30px;
            padding: 8px 4px !important;
            font-size: 0.85rem;
        }

        .current-year-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.7rem;
            gap: 0.5rem;
        }
    }
</style>
<?= $this->endSection('style'); ?>

<?= $this->section('content'); ?>
<?php
$session = session();
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1></h1>
                </div>
                <div class="col-sm-6">
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- Header Card -->
                    <div class="card card-outline card-info">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="d-flex align-items-center flex-wrap gap-3">
                                        <span class="current-year-badge">
                                            <i class="fas fa-lock"></i>
                                            Fiscal Calendar Lock | <?= $default_fiscal_year ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4 text-md-right">
                                    <!-- Optional: Tambahkan tombol action jika diperlukan -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content Card -->
                    <div class="card card-outline card-info">
                        <!-- Pagination & Search -->
                        <div id="paginationContainer" class="pagination-container">
                            <div class="pagination-controls">
                                <button id="prevPage" class="page-btn" disabled>
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <span id="paginationInfo" class="pagination-info">Loading...</span>
                                <button id="nextPage" class="page-btn" disabled>
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>

                            <div class="search-container">
                                <input type="text" id="searchPivot" class="search-input" placeholder="Cari tahun">
                            </div>
                        </div>

                        <!-- Loading State -->
                        <div id="loadingState" class="text-center py-5">
                            <div class="loading-spinner mb-3"></div>
                            <p class="text-muted">Memuat data fiscal lock...</p>
                        </div>

                        <!-- Table Container -->
                        <div id="tableContainer" class="p-3" style="display: none;">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead id="pivotHead"></thead>
                                    <tbody id="pivotBody"></tbody>
                                </table>
                            </div>
                        </div>

                        <!-- No Data State -->
                        <div id="noDataState" class="empty-state" style="display: none;">
                            <div class="empty-state-icon">
                                <i class="fas fa-search"></i>
                            </div>
                            <h3 class="empty-state-title">Tidak ada data ditemukan</h3>
                            <p class="text-muted">Coba gunakan kata kunci pencarian yang berbeda</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection('content'); ?>

<?= $this->section('script'); ?>
<script src="<?= base_url('plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
<script src="<?= base_url('plugins/toastr/toastr.min.js') ?>"></script>

<script>
    $('#active-menu').html($('p#active-menu').html());
    $(document).prop("title", $('p#active-menu').html());
</script>

<script>
    let editYear = null;
    let currentPage = 1;
    let totalPages = 1;
    let totalYears = 0;
    let currentYear = '';
    let searchTimeout = null;
    const currentFiscalYear = '<?= $default_fiscal_year ?>';

    $(document).ready(function() {
        loadPivotData(currentPage, '');

        // Search functionality
        $('#searchPivot').on('keyup', function() {
            const searchQuery = $(this).val();
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                loadPivotData(1, searchQuery);
            }, 500);
        });

        // Pagination controls
        $('#prevPage').on('click', function() {
            if (currentPage > 1) {
                loadPivotData(currentPage - 1, $('#searchPivot').val());
            }
        });

        $('#nextPage').on('click', function() {
            if (currentPage < totalPages) {
                loadPivotData(currentPage + 1, $('#searchPivot').val());
            }
        });

        // Edit year button
        $(document).on('click', '.btn-edit-year', function() {
            let year = $(this).data('year');

            if (editYear === year) {
                // Nonaktifkan edit mode
                editYear = null;
                $('body').removeClass('edit-year-active');

                $('.btn-edit-year')
                    .removeClass('btn-success')
                    .addClass('btn-secondary')
                    .html('<i class="fas fa-edit mr-1"></i> Edit');

                toastr.info('Edit mode nonaktif', '', {
                    timeOut: 1500,
                    positionClass: 'toast-top-center'
                });
            } else {
                // Aktifkan edit mode untuk tahun ini
                editYear = year;
                $('body').addClass('edit-year-active');

                $('.btn-edit-year')
                    .removeClass('btn-success')
                    .addClass('btn-secondary')
                    .html('<i class="fas fa-edit mr-1"></i> Edit');

                $(this)
                    .removeClass('btn-secondary')
                    .addClass('btn-success')
                    .html('<i class="fas fa-check mr-1"></i> Selesai');

                toastr.success(`Edit mode aktif untuk tahun ${year}`, '', {
                    timeOut: 2000,
                    positionClass: 'toast-top-center'
                });
            }
        });

        // Lock cell click handler
        $(document).on('click', '.lock-cell', function() {
            let cell = $(this);
            let year = cell.data('year');

            if (editYear !== year) {
                toastr.warning(`Aktifkan edit mode untuk tahun ${year} terlebih dahulu!`, '', {
                    timeOut: 3000,
                    positionClass: 'toast-top-center'
                });
                return;
            }

            let payload = {
                fiscYear: year,
                fiscPeriod: cell.data('period'),
                moduleName: cell.data('module'),
                statusLock: cell.data('lock') === 1 ? 0 : 1
            };

            cell.css('opacity', 0.5);

            $.post("<?= base_url('tmstfiscalcalenderlock/update-lock') ?>", payload, function(res) {
                if (!res.success) {
                    toastr.error(res.message || 'Gagal update');
                    return;
                }

                cell.data('lock', payload.statusLock);

                if (payload.statusLock) {
                    cell.addClass('locked').text('x');
                } else {
                    cell.removeClass('locked').text('');
                }

                toastr.success('Status berhasil diperbarui', '', {
                    timeOut: 1500,
                    positionClass: 'toast-top-center'
                });
            }).always(() => cell.css('opacity', 1));
        });
    });

    function loadPivotData(page, search) {
        showLoading();

        $.ajax({
            url: "<?= base_url('tmstfiscalcalenderlock/pivot') ?>",
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify({
                draw: 1,
                pageNumber: page,
                pageSize: 1,
                countOnly: false,
                search: {
                    value: search
                }
            }),
            success: function(response) {
                if (response.data && response.data.length > 0) {
                    renderPivot(response.data);
                    updatePaginationInfo(response);
                    showTable();
                } else {
                    showNoData('Tidak ada data ditemukan');
                }
            },
            error: function(xhr, status, error) {
                showNoData('Gagal memuat data: ' + error);
            }
        });
    }

    function renderPivot(data) {
        if (editYear && editYear !== currentYear) {
            editYear = null;
            $('body').removeClass('edit-year-active');
        }

        let thead = '';
        let tbody = '';

        // Kelompokkan data berdasarkan tahun
        let grouped = {};
        data.forEach(r => {
            if (!grouped[r.FiscYear]) {
                grouped[r.FiscYear] = [];
            }
            grouped[r.FiscYear].push(r);
        });

        // Urutkan tahun dari yang terbaru
        const sortedYears = Object.keys(grouped).sort((a, b) => b - a);

        // Karena 1 tahun per halaman, hanya ambil tahun pertama
        if (sortedYears.length > 0) {
            const year = sortedYears[0];
            currentYear = year;

            let rows = grouped[year];

            // Dapatkan semua period columns (tidak termasuk FiscYear dan ModuleName)
            if (rows.length > 0) {
                const firstRow = rows[0];
                let periods = Object.keys(firstRow)
                    .filter(k => k !== 'FiscYear' && k !== 'ModuleName');

                // Sort periods untuk urutan yang benar
                periods.sort((a, b) => {
                    // Urutan khusus: Period 01-12, lalu Adjs, lalu Closing
                    if (a === 'Adjs') return periods.length - 1;
                    if (b === 'Adjs') return -1;
                    if (a === 'Closing') return periods.length;
                    if (b === 'Closing') return -2;

                    // Untuk Period 01-12, ekstrak angka
                    const numA = parseInt(a.replace('Period ', ''));
                    const numB = parseInt(b.replace('Period ', ''));
                    return numA - numB;
                });

                // Cek apakah tahun ini adalah tahun fiskal saat ini
                const isCurrentFiscalYear = year === currentFiscalYear;

                // Header tahun
                thead = `
                    <tr>
                        <th colspan="${periods.length + 1}" class="year-header">
                            <div class="year-header-content">
                                <div class="year-title">
                                    <i class="fas fa-calendar-alt"></i>
                                    Tahun ${year}
                                    ${isCurrentFiscalYear ? '<span class="badge-current-year">Current Year</span>' : ''}
                                </div>
                                <button class="btn btn-sm btn-edit-year btn-secondary"
                                        data-year="${year}">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </button>
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th class="module-header">Module</th>
                        ${periods.map(p => `<th class="period-header">${p}</th>`).join('')}
                    </tr>
                `;

                // Data rows
                rows.forEach(row => {
                    tbody += `<tr><td class="font-weight-bold module-header">${row.ModuleName}</td>`;

                    periods.forEach(p => {
                        let locked = row[p] === 'x' || row[p] === 'X';

                        tbody += `
                            <td class="lock-cell ${locked ? 'locked' : ''}"
                                data-year="${year}"
                                data-period="${p}"
                                data-module="${row.ModuleName}"
                                data-lock="${locked ? 1 : 0}">
                                ${locked ? 'x' : ''}
                            </td>
                        `;
                    });

                    tbody += '</tr>';
                });
            }
        }

        $('#pivotHead').html(thead);
        $('#pivotBody').html(tbody);
    }

    function updatePaginationInfo(response) {
        currentPage = response.pagination?.currentPage || 1;
        totalPages = response.pagination?.totalPages || 1;
        totalYears = response.pagination?.totalYears || 0;
        currentYear = response.pagination?.currentYear || '';

        // Update info display
        const isCurrentFiscalYear = currentYear === currentFiscalYear;
        const yearLabel = isCurrentFiscalYear ? `${currentYear} (Current)` : currentYear;
        $('#paginationInfo').text(`Tahun ${yearLabel} (${currentPage} dari ${totalYears})`);

        // Update button states
        $('#prevPage').prop('disabled', currentPage <= 1);
        $('#nextPage').prop('disabled', currentPage >= totalPages);
    }

    function showLoading() {
        $('#loadingState').show();
        $('#tableContainer').hide();
        $('#noDataState').hide();
        $('#paginationContainer').show();
    }

    function showTable() {
        $('#loadingState').hide();
        $('#tableContainer').show();
        $('#noDataState').hide();
        $('#paginationContainer').show();
    }

    function showNoData(message) {
        $('#loadingState').hide();
        $('#tableContainer').hide();
        $('#noDataState').show().find('.empty-state-title').text(message || 'Tidak ada data ditemukan');
        $('#paginationContainer').show();
        $('#pivotHead').html('');
        $('#pivotBody').html('');

        // Reset pagination info
        currentPage = 1;
        totalPages = 1;
        totalYears = 0;
        currentYear = '';

        $('#paginationInfo').text('Tidak ada data');
        $('#prevPage').prop('disabled', true);
        $('#nextPage').prop('disabled', true);
    }
</script>

<?= $this->endSection('script'); ?>