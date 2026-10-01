<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>
<!-- SweetAlert2 -->
<link rel="stylesheet" href="<?= base_url('plugins/sweetalert2/sweetalert2.min.css') ?>">
<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<!-- Toastr -->
<link rel="stylesheet" href="<?= base_url('plugins/toastr/toastr.min.css') ?>">

<style>
    /* Card Styling */
    .card-outline.card-info {
        border-top: 3px solid #17a2b8;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .card-body {
        padding: 20px;
    }

    /* Header Badge */
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

    /* Fiscal Year Card Styling */
    .fiscal-year-card {
        background: white;
        border: 1px solid #dee2e6;
        margin-bottom: 2rem;
    }

    .fiscal-year-header {
        background: #f8f9fa;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #dee2e6;
    }

    .fiscal-year-title {
        font-size: 1.75rem;
        font-weight: 600;
        color: #343a40;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .fiscal-year-title i {
        background: rgba(0, 123, 255, 0.1);
        color: #007bff;
        padding: 8px;
        border-radius: 8px;
    }

    .badge-current-year {
        background: #28a745;
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-left: 10px;
    }

    .period-container {
        padding: 0;
    }

    .period-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        border-top: 1px solid #dee2e6;
    }

    .period-card {
        background: white;
        border-right: 1px solid #dee2e6;
        border-bottom: 1px solid #dee2e6;
        padding: 1rem;
        text-align: center;
    }

    .period-card:nth-child(7n) {
        border-right: none;
    }

    .period-badge {
        display: inline-block;
        background: #007bff;
        color: white;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.25rem 0.75rem;
        margin-bottom: 0.75rem;
    }

    .period-dates {
        font-size: 0.85rem;
        line-height: 1.5;
    }

    .date-label {
        font-size: 0.75rem;
        color: #6c757d;
        font-weight: 500;
        margin-bottom: 0.25rem;
    }

    .date-value {
        font-weight: 500;
        color: #495057;
        font-size: 0.9rem;
    }

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

    .period-count {
        font-size: 0.9rem;
        color: #6c757d;
    }

    /* Pagination Container */
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

    /* Search Container */
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

    /* Loading Spinner */
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

    /* Button Generate Styling */
    .btn-generate {
        font-size: 0.9rem;
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-weight: 500;
        transition: all 0.2s;
        background: #28a745;
        border-color: #28a745;
        color: white;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-generate:hover {
        background: #218838;
        border-color: #1e7e34;
        transform: translateY(-1px);
    }

    .btn-generate:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Modal Styling */
    .modal-content {
        border-radius: 12px;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        background: linear-gradient(150deg, #007bff 0%, #fff 100%);
        color: white;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
        padding: 1.25rem 1.5rem;
        border-bottom: none;
    }

    .modal-title {
        font-weight: 600;
        font-size: 1.25rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-footer {
        border-top: 1px solid #e9ecef;
        padding: 1rem 1.5rem;
    }

    /* Year Option Cards */
    .year-option-card {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-bottom: 1rem;
        height: 180px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .year-option-card:hover {
        border-color: #007bff;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.1);
    }

    .year-option-card.active {
        border-color: #28a745;
        background: rgba(40, 167, 69, 0.05);
    }

    .year-option-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        color: #007bff;
    }

    .year-option-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #343a40;
        margin-bottom: 0.5rem;
    }

    .year-option-desc {
        font-size: 0.9rem;
        color: #6c757d;
        margin-bottom: 0.5rem;
    }

    .year-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: #28a745;
    }

    /* Year Input Container */
    .year-input-container {
        margin-top: 1.5rem;
        text-align: center;
        display: none;
        animation: fadeIn 0.3s ease;
    }

    .year-input-container.show {
        display: block;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Custom Number Input */
    .number-input-wrapper {
        max-width: 300px;
        margin: 0 auto;
    }

    .number-input {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
    }

    .number-btn {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: #007bff;
        color: white;
        border: none;
        font-size: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .number-btn:hover {
        background: #0056b3;
        transform: scale(1.05);
    }

    .number-btn:active {
        transform: scale(0.95);
    }

    .number-btn:disabled {
        background: #adb5bd;
        cursor: not-allowed;
        transform: none;
    }

    .year-input {
        width: 150px;
        height: 70px;
        font-size: 2.5rem;
        font-weight: 700;
        text-align: center;
        border: 3px solid #007bff;
        border-radius: 10px;
        color: #28a745;
        background: #f8f9fa;
        outline: none;
    }

    .year-input:focus {
        border-color: #0056b3;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .year-input::-webkit-inner-spin-button,
    .year-input::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }


    /* Responsive Design */
    @media (max-width: 1200px) {
        .period-grid {
            grid-template-columns: repeat(5, 1fr);
        }

        .period-card:nth-child(7n) {
            border-right: 1px solid #dee2e6;
        }

        .period-card:nth-child(5n) {
            border-right: none;
        }
    }

    @media (max-width: 992px) {
        .period-grid {
            grid-template-columns: repeat(4, 1fr);
        }

        .period-card:nth-child(5n) {
            border-right: 1px solid #dee2e6;
        }

        .period-card:nth-child(4n) {
            border-right: none;
        }

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

        .current-year-badge {
            font-size: 0.9rem;
            padding: 0.4rem 1.2rem;
        }

        .fiscal-year-title {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 768px) {
        .period-grid {
            grid-template-columns: repeat(3, 1fr);
        }

        .period-card:nth-child(4n) {
            border-right: 1px solid #dee2e6;
        }

        .period-card:nth-child(3n) {
            border-right: none;
        }

        .current-year-badge {
            font-size: 0.85rem;
            padding: 0.35rem 1rem;
        }

        .fiscal-year-title {
            font-size: 1.25rem;
        }

        .fiscal-year-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .period-count {
            align-self: flex-end;
        }

        .year-option-card {
            padding: 1rem;
            height: 160px;
        }

        .year-option-icon {
            font-size: 2rem;
        }

        .year-value {
            font-size: 1.5rem;
        }

        .year-input {
            width: 120px;
            height: 60px;
            font-size: 2rem;
        }

        .number-btn {
            width: 45px;
            height: 45px;
        }
    }

    @media (max-width: 576px) {
        .period-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .period-card:nth-child(3n) {
            border-right: 1px solid #dee2e6;
        }

        .period-card:nth-child(2n) {
            border-right: none;
        }

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

        .current-year-badge {
            font-size: 0.8rem;
            padding: 0.3rem 0.8rem;
        }

        .btn-generate {
            font-size: 0.8rem;
            padding: 0.35rem 0.8rem;
        }

        .modal-dialog {
            margin: 0.5rem;
        }

        .modal-body {
            padding: 1rem;
        }

        .year-option-card {
            height: 140px;
        }

        .number-input {
            gap: 10px;
        }

        .year-input {
            width: 100px;
            height: 50px;
            font-size: 1.75rem;
        }

        .number-btn {
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
        }
    }

    @media (max-width: 400px) {
        .period-grid {
            grid-template-columns: 1fr;
        }

        .period-card {
            border-right: none;
        }

        .current-year-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.7rem;
            gap: 0.5rem;
        }

        .pagination-controls {
            flex-wrap: wrap;
            justify-content: center;
        }

        .year-input {
            width: 80px;
            font-size: 1.5rem;
        }
    }
</style>
<?= $this->endSection('style'); ?>

<?= $this->section('content'); ?>
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
                                            <i class="fas fa-calendar-alt"></i>
                                            Fiscal Calendar | <?= $default_fiscal_year ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4 text-md-right">
                                    <?php if (session()->get('flag_insert') === 1): ?>
                                        <button id="btn_generate" class="btn btn-generate">
                                            <i class="fas fa-cogs mr-1"></i> Generate Year
                                        </button>
                                    <?php endif; ?>
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
                                <span id="paginationInfo" class="pagination-info">Halaman 1 dari 1</span>
                                <button id="nextPage" class="page-btn" disabled>
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>

                            <div class="search-container">
                                <input type="text" id="yearSearch" class="search-input" placeholder="Cari tahun...">
                            </div>
                        </div>

                        <!-- Loading State -->
                        <div id="fiscalMatrixContainer" class="p-3">
                            <div class="text-center py-5">
                                <div class="loading-spinner mb-3"></div>
                                <p class="text-muted">Memuat kalender fiskal...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Generate Year -->
<div class="modal fade" id="generateModal" tabindex="-1" role="dialog" aria-labelledby="generateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">
                    <i class="fas fa-calendar-plus"></i> Generate Fiscal Year
                </div>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="generateForm">
                <div class="modal-body">
                    <!-- Option Cards -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="year-option-card active" data-option="current">
                                <div class="year-option-icon">
                                    <i class="fas fa-bolt"></i>
                                </div>
                                <div class="year-option-title">Current Year</div>
                                <div class="year-option-desc">Generate berdasarkan tahun fiskal</div>
                                <div class="year-value"><?= $default_fiscal_year ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="year-option-card" data-option="custom">
                                <div class="year-option-icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="year-option-title">Custom Year</div>
                                <div class="year-option-desc">Klik untuk memilih tahun</div>
                            </div>
                        </div>
                    </div>

                    <div class="year-input-container" id="yearInputContainer">
                        <div class="number-input-wrapper">
                            <div class="number-input">
                                <button type="button" class="number-btn" id="decreaseYear">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number"
                                    class="year-input"
                                    id="selectedYear"
                                    min="2000"
                                    max="2100"
                                    value="<?= $default_fiscal_year + 1 ?>"
                                    required />
                                <button type="button" class="number-btn" id="increaseYear">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden Input -->
                    <input type="hidden" id="selectedYearValue" name="year" value="<?= $default_fiscal_year ?>">
                    <input type="hidden" id="selectedOption" name="option" value="current">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary" id="btnConfirmGenerate">
                        <i class="fas fa-cogs mr-1"></i> Generate
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>

<?= $this->section('script'); ?>
<script src="<?= base_url('plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
<script src="<?= base_url('plugins/toastr/toastr.min.js') ?>"></script>

<script>
    $('#active-menu').html($('p#active-menu').html());
    $(document).prop("title", $('p#active-menu').html());

    let currentPage = 1;
    let totalPages = 1;
    const yearsPerPage = 1;
    let allYearsData = {};
    let allYearsList = [];
    let filteredYearsList = [];
    let searchTimeout = null;
    const defaultFiscalYear = <?= $default_fiscal_year ?>;

    $(document).ready(function() {
        loadAllFiscalYears();

        // Event Listeners
        $('#btn_generate').on('click', showGenerateModal);
        $('#prevPage').on('click', () => goToPage(currentPage - 1));
        $('#nextPage').on('click', () => goToPage(currentPage + 1));

        $('#yearSearch').on('input', function() {
            const query = $(this).val().trim();
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => performSearch(query), 500);
        });

        // Modal Events
        $('#generateModal').on('shown.bs.modal', initializeModal);

        // Option card events
        $('.year-option-card').on('click', function() {
            const option = $(this).data('option');
            selectOption(option);
        });

        // Year input events
        $('#decreaseYear').on('click', decreaseYear);
        $('#increaseYear').on('click', increaseYear);
        $('#selectedYear').on('input', updateYearFromInput);

        // Quick year buttons
        $('.quick-year-btn').on('click', function() {
            const year = $(this).data('year');
            setSelectedYear(year);
        });

        // Form submit
        $('#generateForm').on('submit', function(e) {
            e.preventDefault();
            confirmGenerate();
        });
    });

    // ==================== MODAL FUNCTIONS ====================

    function initializeModal() {
        // Reset to current year
        selectOption('current');
        setSelectedYear(defaultFiscalYear + 1);
    }

    function showGenerateModal() {
        $('#generateModal').modal('show');
    }

    function selectOption(option) {
        // Update UI
        $('.year-option-card').removeClass('active');
        $(`.year-option-card[data-option="${option}"]`).addClass('active');

        // Update hidden option
        $('#selectedOption').val(option);

        // Handle year input visibility
        const yearInputContainer = $('#yearInputContainer');

        if (option === 'current') {
            // Hide year input, set to default year
            yearInputContainer.removeClass('show');
            $('#selectedYearValue').val(defaultFiscalYear);
        } else {
            // Show year input
            yearInputContainer.addClass('show');

            // Get current value or default to next year
            const currentValue = $('#selectedYear').val();
            const selectedYear = currentValue || (defaultFiscalYear + 1);

            // Update values
            setSelectedYear(selectedYear);
        }
    }

    function decreaseYear() {
        const currentYear = parseInt($('#selectedYear').val());
        if (currentYear > 2000) {
            setSelectedYear(currentYear - 1);
        }
    }

    function increaseYear() {
        const currentYear = parseInt($('#selectedYear').val());
        if (currentYear < 2100) {
            setSelectedYear(currentYear + 1);
        }
    }

    function updateYearFromInput() {
        const year = $('#selectedYear').val();
        if (year >= 2000 && year <= 2100) {
            setSelectedYear(year);
        }
    }

    function setSelectedYear(year) {
        // Update input field
        $('#selectedYear').val(year);

        // Update quick buttons
        $('.quick-year-btn').removeClass('active');
        $(`.quick-year-btn[data-year="${year}"]`).addClass('active');

        // Update hidden value if custom option is active
        if ($('#selectedOption').val() === 'custom') {
            $('#selectedYearValue').val(year);
        }
    }

    function confirmGenerate() {
        const year = $('#selectedYearValue').val();
        const option = $('#selectedOption').val();

        if (!year) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Tahun belum dipilih'
            });
            return;
        }

        $('#generateModal').modal('hide');

        Swal.fire({
            title: 'Generate Fiscal Year?',
            html: `Apakah Anda yakin ingin generate fiscal year <b>${year}</b>?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Generate',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                generateFiscalYear(year);
            }
        });
    }

    // ==================== FISCAL CALENDAR FUNCTIONS ====================

    function loadAllFiscalYears() {
        fetch("<?= base_url('tmstfiscalcalender/datatables') ?>", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    draw: 1,
                    start: 0,
                    length: 10000
                })
            })
            .then(res => res.json())
            .then(res => {
                if (res.data && Array.isArray(res.data)) {
                    processAllYearsData(res.data);
                } else {
                    showEmptyState('Belum ada data kalender fiskal');
                }
            })
            .catch(err => {
                console.error(err);
                showEmptyState('Gagal memuat data fiscal calendar');
            });
    }

    function processAllYearsData(data) {
        allYearsData = {};
        allYearsList = [];

        data.forEach(item => {
            if (!allYearsData[item.fiscYear]) {
                allYearsData[item.fiscYear] = [];
                allYearsList.push(item.fiscYear.toString());
            }
            allYearsData[item.fiscYear].push(item);
        });

        allYearsList.sort((a, b) => parseInt(b) - parseInt(a));
        filteredYearsList = [...allYearsList];

        if (filteredYearsList.length > 0) {
            totalPages = Math.ceil(filteredYearsList.length / yearsPerPage);
            loadPage(1);
        } else {
            showEmptyState('Belum ada data kalender fiskal');
        }
    }

    function performSearch(query) {
        if (query === '') {
            filteredYearsList = [...allYearsList];
        } else {
            filteredYearsList = allYearsList.filter(year => year.includes(query));
        }

        currentPage = 1;
        totalPages = Math.ceil(filteredYearsList.length / yearsPerPage);

        if (filteredYearsList.length === 0) {
            showEmptyState('Tidak ditemukan tahun yang sesuai dengan pencarian');
        } else {
            loadPage(1);
        }

        updatePagination();
    }

    function loadPage(page) {
        currentPage = page;
        const startIndex = (page - 1) * yearsPerPage;
        const endIndex = Math.min(startIndex + yearsPerPage, filteredYearsList.length);
        const yearsToShow = filteredYearsList.slice(startIndex, endIndex);

        if (yearsToShow.length === 0) {
            showEmptyState('Tidak ada data untuk ditampilkan');
            updatePagination();
            return;
        }

        renderFiscalCards(yearsToShow);
        updatePagination();
    }

    function goToPage(page) {
        if (page < 1 || page > totalPages || page === currentPage) return;
        loadPage(page);
    }

    function updatePagination() {
        const paginationContainer = $('#paginationContainer');
        const paginationInfo = $('#paginationInfo');
        const prevPageBtn = $('#prevPage');
        const nextPageBtn = $('#nextPage');

        paginationContainer.css('display', 'flex');

        const totalYears = filteredYearsList.length;

        if (totalYears > 0) {
            const currentYear = filteredYearsList[currentPage - 1] || '';
            const isCurrentFiscalYear = currentYear == defaultFiscalYear;
            const yearLabel = isCurrentFiscalYear ? `${currentYear} (Current)` : currentYear;
            paginationInfo.text(`Tahun ${yearLabel} (${currentPage} dari ${totalYears})`);
            prevPageBtn.prop('disabled', currentPage === 1);
            nextPageBtn.prop('disabled', currentPage === totalPages);
        } else {
            paginationInfo.text('Tidak ada data');
            prevPageBtn.prop('disabled', true);
            nextPageBtn.prop('disabled', true);
        }
    }

    function renderFiscalCards(years) {
        const container = $('#fiscalMatrixContainer');
        let html = '';

        years.forEach(year => {
            const periods = allYearsData[year];
            const isCurrentYear = year == defaultFiscalYear;

            periods.sort((a, b) => {
                const aNum = parseInt(a.fiscPeriod);
                const bNum = parseInt(b.fiscPeriod);
                return aNum - bNum;
            });

            html += `
                <div class="fiscal-year-card">
                    <div class="fiscal-year-header d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fiscal-year-title">
                                <i class="fas fa-calendar-alt"></i>
                                Tahun ${year}
                                ${isCurrentYear ? '<span class="badge-current-year">Current Year</span>' : ''}
                            </h2>
                        </div>
                        <div class="period-count">
                            ${periods.length} Period
                        </div>
                    </div>
                    <div class="period-container">
                        <div class="period-grid">
            `;

            periods.forEach(period => {
                const periodNum = period.fiscPeriod;
                html += `
                    <div class="period-card">
                        <div class="period-badge">Period ${periodNum}</div>
                        <div class="period-dates">
                            <div class="mb-2">
                                <div class="date-label">Start</div>
                                <div class="date-value">${formatDate(period.startDate)}</div>
                            </div>
                            <div>
                                <div class="date-label">End</div>
                                <div class="date-value">${formatDate(period.endDate)}</div>
                            </div>
                        </div>
                    </div>
                `;
            });

            html += `
                        </div>
                    </div>
                </div>
            `;
        });

        container.html(html);
    }

    function showEmptyState(message) {
        const container = $('#fiscalMatrixContainer');

        container.html(`
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-calendar-plus text-secondary"></i>
                </div>
                <h3 class="empty-state-title">${message}</h3>
            </div>
        `);
    }

    function formatDate(dateStr) {
        if (!dateStr) return '-';
        try {
            const d = new Date(dateStr);
            const day = String(d.getDate()).padStart(2, '0');
            const month = String(d.getMonth() + 1).padStart(2, '0');
            const year = d.getFullYear();
            return `${day}/${month}/${year}`;
        } catch (e) {
            return '-';
        }
    }

    function generateFiscalYear(year) {
        const btn = $('#btnConfirmGenerate');
        const originalText = btn.html();

        btn.html('<i class="fas fa-spinner fa-spin mr-1"></i> Generating...');
        btn.prop('disabled', true);

        fetch("<?= base_url('tmstfiscalcalender/action') ?>", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: JSON.stringify({
                    action: 'Generate',
                    year: year
                })
            })
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success') {
                    Swal.fire({
                        title: 'Berhasil!',
                        html: `<b>${res.message}</b><br>
                              <small>Total berhasil: ${res.total_success} periode<br>
                              Total gagal: ${res.total_error} periode</small>`,
                        icon: 'success',
                        confirmButtonColor: '#28a745',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        loadAllFiscalYears();
                        $('#yearSearch').val('');
                    });
                } else {
                    Swal.fire({
                        title: 'Gagal!',
                        text: res.message || 'Gagal generate tahun fiskal.',
                        icon: 'error',
                        confirmButtonColor: '#dc3545',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(err => {
                console.error(err);
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat generate tahun fiskal.',
                    icon: 'error',
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'OK'
                });
            })
            .finally(() => {
                btn.html(originalText);
                btn.prop('disabled', false);
            });
    }
</script>

<?= $this->endSection('script'); ?>