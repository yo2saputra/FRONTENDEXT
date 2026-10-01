<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="<?= base_url('plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
<style>
    :root {
        --tnd-blue: #0d6efd;
        --tnd-blue-dark: #0b5ed7;
        --tnd-blue-soft: #f0f4ff;
        --tnd-text: #212529;
        --tnd-muted: #6c757d;
        --tnd-border: #e9ecef;
        --tnd-bg-soft: #f8f9fa;
        --tnd-green-bg: #e6f4ea;
        --tnd-green-text: #0f5132;
        --tnd-green-border: #badbcc;
        --tnd-gray-bg: #f1f2f4;
        --tnd-gray-text: #41464b;
        --tnd-amber-bg: #fffbf0;
        --tnd-amber-border: #f9e2b0;
        --tnd-amber-text: #856404;
        --tnd-purple: #6f42c1;
        --tnd-yellow: #ffc107;
        --tnd-red: #dc3545;
        --tnd-step-green: #198754;
    }

    body { background-color: #f4f6f9; color: var(--tnd-text); }
    
    .form-control, .select2-container--default .select2-selection--single { 
        font-size: .85rem !important; 
        border-radius: .4rem; 
        border: 1px solid #ced4da;
    }

    .tnd-card {
        background: #fff; 
        border: 1px solid var(--tnd-border);
        border-radius: .6rem; 
        box-shadow: 0 1px 2px rgba(0,0,0,.03);
        padding: 1.25rem; 
        margin-bottom: 1.25rem;
    }
 
    .page-title { font-size: 1.4rem; font-weight: 700; margin-bottom: 2px; color: var(--tnd-text); }
    .page-subtitle { font-size: .85rem; color: var(--tnd-muted); }
    .breadcrumb-custom { font-size: .8rem; color: var(--tnd-muted); margin-bottom: 1.5rem; }
    .breadcrumb-custom a { color: var(--tnd-blue); text-decoration: none; }

    .btn-tnd-primary {
        background-color: var(--tnd-blue); border-color: var(--tnd-blue); color: #fff;
        font-weight: 600; font-size: .85rem; border-radius: .4rem; padding: .45rem 1.2rem;
    }
    .btn-tnd-primary:hover { background-color: var(--tnd-blue-dark); color: #fff; }
    
    .btn-tnd-outline {
        background-color: #fff; border: 1px solid #ced4da; color: var(--tnd-text);
        font-weight: 600; font-size: .85rem; border-radius: .4rem; padding: .45rem 1.2rem;
    }
    .btn-tnd-outline:hover { background-color: var(--tnd-bg-soft); color: var(--tnd-text); }

    .btn-reset {
        background-color: #fff; border: 1px solid #ced4da; color: var(--tnd-text);
        border-radius: .4rem; height: calc(1.5em + .75rem + 2px); width: 100%;
        display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: .85rem;
    }
    .btn-reset:hover { background-color: var(--tnd-bg-soft); }

    table.dataTable thead th, .table thead th {
        background-color: var(--tnd-bg-soft); font-size: .75rem; color: var(--tnd-text);
        font-weight: 600; border-bottom: 1px solid var(--tnd-border); border-top: none;
        padding: .8rem; white-space: nowrap;
    }
    table.dataTable tbody td, .table tbody td { 
        font-size: .85rem; vertical-align: middle; border-bottom: 1px solid var(--tnd-border); padding: .8rem;
    }
    .kode-link { color: var(--tnd-blue); font-weight: 600; text-decoration: none; }

    .badge-tnd-aktif { background-color: var(--tnd-green-bg); color: var(--tnd-green-text); padding: .3rem .8rem; border-radius: 99px; font-size: .75rem; font-weight: 600; border: 1px solid var(--tnd-green-border); display: inline-block; text-align: center; min-width: 60px; }
    .badge-tnd-nonaktif { background-color: var(--tnd-gray-bg); color: var(--tnd-gray-text); padding: .3rem .8rem; border-radius: 99px; font-size: .75rem; font-weight: 600; border: 1px solid #d3d4d5; display: inline-block; text-align: center; min-width: 60px; }

    .aksi-cell { display: flex; gap: .75rem; align-items: center; }
    .btn-icon-tnd { background: none; border: none; color: var(--tnd-muted); font-size: .95rem; padding: 0; cursor: pointer;}
    .btn-icon-tnd.view { color: var(--tnd-blue); }
    .btn-icon-tnd.edit { color: #495057; }
    .btn-icon-tnd.delete { color: var(--tnd-red, #dc3545); }
    .btn-icon-tnd:hover { opacity: 0.7; }

    .tnd-switch { position: relative; display: inline-block; width: 40px; height: 22px; margin-bottom: 0; vertical-align: middle; }
    .tnd-switch input { opacity: 0; width: 0; height: 0; }
    .tnd-switch .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .2s; border-radius: 34px; }
    .tnd-switch .slider:before { position: absolute; content: ""; height: 16px; width: 16px; left: 3px; bottom: 3px; background-color: white; transition: .2s; border-radius: 50%; }
    .tnd-switch input:checked + .slider { background-color: var(--tnd-blue); }
    .tnd-switch input:checked + .slider:before { transform: translateX(18px); }
    .tnd-switch-label { font-size: .85rem; font-weight: 600; vertical-align: middle; margin-left: 8px; cursor: pointer; }

    .tnd-section-title { font-weight: 700; font-size: 1rem; margin-bottom: 1rem; color: var(--tnd-text); border-bottom: 1px solid var(--tnd-border); padding-bottom: .8rem; }
    .field-label { font-size: .8rem; font-weight: 700; color: var(--tnd-text); margin-bottom: .4rem; }
    .input-group-text { background-color: #fff; border-color: #ced4da; font-size: .85rem; color: var(--tnd-muted); font-weight: 600;}

    .info-box-blue { background-color: #f0f4ff; border: 1px solid #cce5ff; border-radius: .4rem; padding: .8rem 1rem; font-size: .85rem; color: #0b5ed7; display: flex; gap: .8rem; align-items: flex-start; }
    .tips-box { background: var(--tnd-amber-bg); border: 1px solid var(--tnd-amber-border); border-radius: .5rem; padding: 1rem; font-size: .8rem; color: var(--tnd-amber-text); }
    .tips-box ul { padding-left: 1.2rem; margin-bottom: 0; margin-top: .4rem;}

    .wizard-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
    .wizard-stepper { display: flex; gap: 1.5rem; margin-bottom: 1.5rem; border-bottom: 1px solid var(--tnd-border); padding-bottom: 1rem; }
    .step-item { display: flex; align-items: center; gap: .5rem; color: var(--tnd-muted); font-weight: 600; font-size: .95rem; cursor: pointer;}
    .step-item.active { color: var(--tnd-blue); }
    .step-item.done { color: var(--tnd-step-green); }
    
    .step-circle { width: 24px; height: 24px; border-radius: 50%; border: 2px solid var(--tnd-muted); display: flex; align-items: center; justify-content: center; font-size: .75rem; font-weight: 700; background: #fff; color: var(--tnd-muted);}
    .step-item.active .step-circle { background: var(--tnd-blue); color: #fff; border-color: var(--tnd-blue); }
    .step-item.done .step-circle { background: var(--tnd-step-green); color: #fff; border-color: var(--tnd-step-green); }

    .summary-card { background: #fff; border: 1px solid var(--tnd-border); border-radius: .5rem; padding: 1rem; margin-bottom: .8rem; display:flex; align-items:center; gap: 1rem; }
    .summary-card i { font-size: 1.8rem; padding: .8rem; border-radius: .4rem; }
    .summary-card .icon-blue { background: var(--tnd-blue-soft); color: var(--tnd-blue); }
    .summary-card .icon-green { background: var(--tnd-green-bg); color: #198754; }
    .summary-card .icon-yellow { background: var(--tnd-amber-bg); color: #ffc107; }
    .summary-card .icon-purple { background: #f3e8ff; color: #6f42c1; }
    .summary-val { font-size: 1.1rem; font-weight: 700; color: var(--tnd-text); margin-bottom: 2px;}
    .summary-lbl { font-size: .75rem; font-weight: 600; color: var(--tnd-text); }
    .summary-sub { font-size: .7rem; color: var(--tnd-muted); }

    .donut-chart-container { display: flex; align-items: center; justify-content: space-between; margin-top: 1rem; }
    .donut-chart {
        width: 90px; height: 90px; border-radius: 50%;
        background: conic-gradient(
            var(--tnd-blue) 0% 61.8%,
            #198754 61.8% 88.3%,
            var(--tnd-yellow) 88.3% 97.1%,
            var(--tnd-purple) 97.1% 100%
        );
        position: relative;
    }
    .donut-chart::before { content: ""; position: absolute; inset: 15px; background: #fff; border-radius: 50%; }
    .chart-legend { font-size: .75rem; }
    .legend-item { display: flex; align-items: center; justify-content: space-between; margin-bottom: .3rem; width: 140px;}
    .legend-dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; margin-right: 6px; }

    .dt-footer-wrapper { display: flex; justify-content: space-between; align-items: center; padding-top: 1rem; }
    .dataTables_wrapper .dataTables_info { padding-top: 0 !important; font-size: .85rem; color: var(--tnd-muted); }
    .dataTables_wrapper .dataTables_paginate { padding-top: 0 !important; }
    .dataTables_wrapper .dataTables_paginate .paginate_button { 
        padding: .3rem .8rem; margin-left: 2px; border-radius: .3rem; border: 1px solid var(--tnd-border); 
        background: #fff; color: var(--tnd-text) !important; font-size: .85rem; 
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current { background: var(--tnd-blue) !important; color: #fff !important; border-color: var(--tnd-blue); }

    .kebutuhan-list-item {
        display: flex;
        align-items: flex-start;
        padding: .5rem 0;
        border-bottom: 1px solid var(--tnd-border);
    }
    .kebutuhan-list-item:last-child { border-bottom: none; }
    .kebutuhan-list-item .badge-jenis {
        font-size: .65rem;
        padding: .15rem .6rem;
        border-radius: 99px;
        font-weight: 600;
        margin-left: .5rem;
        flex-shrink: 0;
    }
    .badge-obat { background: var(--tnd-green-bg); color: var(--tnd-green-text); }
    .badge-bmhp { background: var(--tnd-amber-bg); color: var(--tnd-amber-text); }
    .badge-alat { background: #e6e6ff; color: #4a4a8a; }

    .review-table td { padding: .4rem .5rem; font-size: .85rem; border: none; }
    .review-table td:first-child { color: var(--tnd-muted); width: 40%; }
    .review-table td:last-child { font-weight: 600; }
    .review-section-title { font-weight: 700; font-size: .95rem; margin-top: 1.2rem; margin-bottom: .5rem; color: var(--tnd-text); }
    .review-section-title:first-child { margin-top: 0; }

    html.dark-mode .content-wrapper { background-color: #24282e; color: #dee2e6; }
    html.dark-mode .tnd-card,
    html.dark-mode .summary-card,
    html.dark-mode .tips-box { background-color: #343a40; border-color: #454d55; }
    html.dark-mode .tips-box { background-color: #3a2e10; border-color: #5a4a20; color: #fcd34d; }

    html.dark-mode .page-title,
    html.dark-mode .page-subtitle,
    html.dark-mode h6,
    html.dark-mode .field-label,
    html.dark-mode .tnd-section-title,
    html.dark-mode .review-section-title { color: #f1f1f1; }
    html.dark-mode .page-subtitle,
    html.dark-mode .breadcrumb-custom,
    html.dark-mode .summary-lbl,
    html.dark-mode .summary-sub { color: #adb5bd; }
    html.dark-mode .summary-val { color: #f1f1f1; }
    html.dark-mode .breadcrumb-custom a { color: #6ea8fe; }

    html.dark-mode .form-control,
    html.dark-mode .form-control-sm,
    html.dark-mode select.form-control,
    html.dark-mode select.form-control-sm,
    html.dark-mode input.form-control,
    html.dark-mode textarea.form-control {
        background-color: #2b3035; border-color: #555d66; color: #f1f1f1;
    }
    html.dark-mode select.form-control option,
    html.dark-mode select.form-control-sm option { background-color: #2b3035; color: #f1f1f1; }
    html.dark-mode .form-control::placeholder { color: #6c757d; }
    html.dark-mode .input-group-text { background-color: #2b3035; border-color: #555d66; color: #adb5bd; }

    html.dark-mode table.dataTable thead th,
    html.dark-mode .table thead th { background-color: #2b3035 !important; color: #adb5bd; border-color: #454d55 !important; }
    html.dark-mode table.dataTable tbody td,
    html.dark-mode .table tbody td { color: #dee2e6; border-color: #454d55; }
    html.dark-mode table.dataTable tbody tr:hover { background-color: #3a4149; }
    html.dark-mode .table-responsive { border-color: #454d55; }

    html.dark-mode .dataTables_wrapper .dataTables_paginate .paginate_button { background: #343a40; border-color: #454d55; color: #adb5bd !important; }
    html.dark-mode .dataTables_wrapper .dataTables_paginate .paginate_button.current { background: var(--tnd-blue) !important; color: #fff !important; border-color: var(--tnd-blue); }
    html.dark-mode .dataTables_wrapper .dataTables_info { color: #adb5bd; }
    html.dark-mode .dt-footer-wrapper { color: #adb5bd; }

    html.dark-mode .btn-tnd-primary { background-color: var(--tnd-blue); border-color: var(--tnd-blue); }
    html.dark-mode .btn-tnd-outline,
    html.dark-mode .btn-reset { background-color: #343a40; border-color: #555d66; color: #f1f1f1; }
    html.dark-mode .btn-tnd-outline:hover,
    html.dark-mode .btn-reset:hover { background-color: #3a4149; }

    html.dark-mode .badge-tnd-aktif { background-color: #1a3a2a; color: #86efac; border-color: #2d5a44; }
    html.dark-mode .badge-tnd-nonaktif { background-color: #495057; color: #adb5bd; border-color: #555d66; }

    html.dark-mode .btn-icon-tnd { color: #adb5bd; }
    html.dark-mode .btn-icon-tnd.view { color: #6ea8fe; }
    html.dark-mode .btn-icon-tnd.delete { color: #ff6b6b; }

    html.dark-mode .tnd-switch .slider { background-color: #555d66; }

    html.dark-mode .wizard-stepper { border-color: #454d55; }
    html.dark-mode .step-circle { background-color: #454d55; color: #adb5bd; border-color: #454d55; }
    html.dark-mode .step-item.active .step-circle { background-color: var(--tnd-blue); color: #fff; border-color: var(--tnd-blue); }
    html.dark-mode .step-item.done .step-circle { background-color: var(--tnd-step-green); color: #fff; border-color: var(--tnd-step-green); }
    html.dark-mode .step-label { color: #adb5bd; }

    html.dark-mode .donut-chart::before { background-color: #343a40; }
    html.dark-mode .legend-item { color: #dee2e6; }

    html.dark-mode .tips-box { background-color: #3a2e10; border-color: #5a4a20; color: #fcd34d; }
    html.dark-mode .tips-box ul { color: #fcd34d; }

    html.dark-mode .review-table td { color: #dee2e6; }
    html.dark-mode .review-table td:first-child { color: #adb5bd; }

    html.dark-mode .info-box-blue { background-color: #1a2a3f; border-color: #2a4060; color: #93c5fd; }

    html.dark-mode .icheck-primary label { color: #dee2e6; }

    html.dark-mode .kebutuhan-list-item { border-color: #454d55; color: #dee2e6; }

    .ringkasan-box {
        border: 1px solid var(--tnd-border);
        border-radius: .6rem;
        background-color: var(--tnd-bg-soft);
        padding: 1.1rem;
    }
    .ringkasan-icon-box {
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        text-align: center; padding: 1.4rem 1rem;
        border: 1px dashed #d9dde5; border-radius: .5rem; background: #fff;
    }
    .ringkasan-icon-box i.icon-empty { font-size: 2.1rem; color: #e0b98c; margin-bottom: .5rem; }
    .ringkasan-icon-box .ringkasan-code { font-weight: 700; color: var(--tnd-blue); font-size: .95rem; }
    .ringkasan-icon-box .ringkasan-name { font-weight: 700; color: var(--tnd-text); font-size: .92rem; margin-top: 2px; }
    .ringkasan-icon-box .ringkasan-empty-title { font-weight: 700; font-size: .92rem; color: var(--tnd-text); }
    .ringkasan-icon-box .ringkasan-empty-sub { font-size: .75rem; color: var(--tnd-muted); margin-top: 2px; }
    .ringkasan-badge-draft {
        display: inline-block; margin-top: 4px; font-size: .68rem; font-weight: 600;
        background: #e9ecef; color: #6c757d; padding: .15rem .55rem; border-radius: 999px;
    }
    .ringkasan-stat-row {
        display: flex; justify-content: space-between; font-size: .82rem;
        padding: .45rem 0; color: var(--tnd-text);
    }
    .ringkasan-stat-row span:first-child { color: var(--tnd-muted); }
    .ringkasan-stat-row span:last-child { font-weight: 700; }
    .ringkasan-divider { border-top: 1px solid var(--tnd-border); margin: .4rem 0; }
    .ringkasan-price-box {
        background-color: #eafaf1; border: 1px solid #cdefdd; border-radius: .5rem;
        padding: .8rem .9rem; margin-top: .9rem;
    }
    .ringkasan-price-box .title { font-weight: 700; font-size: .82rem; color: var(--tnd-text); margin-bottom: .4rem; }
    .ringkasan-price-box .row-item { display: flex; justify-content: space-between; font-size: .8rem; padding: .15rem 0; }

    html.dark-mode .ringkasan-box { background-color: #2b3035; border-color: #454d55; }
    html.dark-mode .ringkasan-icon-box { background-color: #343a40; border-color: #555d66; }
    html.dark-mode .ringkasan-icon-box .ringkasan-empty-title { color: #f1f1f1; }
    html.dark-mode .ringkasan-icon-box .ringkasan-empty-sub { color: #adb5bd; }
    html.dark-mode .ringkasan-icon-box .ringkasan-code { color: var(--tnd-blue); }
    html.dark-mode .ringkasan-icon-box .ringkasan-name { color: #f1f1f1; }
    html.dark-mode .ringkasan-badge-draft { background-color: #495057; color: #adb5bd; }
    html.dark-mode .ringkasan-stat-row { color: #adb5bd; }
    html.dark-mode .ringkasan-stat-row span:last-child { color: #f1f1f1; }
    html.dark-mode .ringkasan-divider { border-color: #454d55; }
    html.dark-mode .ringkasan-price-box { background-color: #1e3a2f; border-color: #2d5a44; }
    html.dark-mode .ringkasan-price-box .title { color: #86efac; }
    html.dark-mode .ringkasan-price-box .row-item { color: #dee2e6; }

    #tablePilihItemTnd {
        font-size: 0.82rem;
        margin-bottom: 0;
    }
    #tablePilihItemTnd thead th {
        background-color: var(--tnd-bg-soft) !important;
        font-size: 0.72rem;
        font-weight: 700;
        color: var(--tnd-text);
        border-bottom: 2px solid var(--tnd-border);
        padding: 0.5rem 0.7rem;
        white-space: nowrap;
    }
    #tablePilihItemTnd tbody td {
        padding: 0.45rem 0.7rem;
        vertical-align: middle;
        border-bottom: 1px solid var(--tnd-border);
        cursor: pointer;
    }
    #tablePilihItemTnd tbody tr:hover {
        background-color: var(--tnd-blue-soft) !important;
        cursor: pointer;
    }
    .btn-pilih-item-tnd {
        padding: 0.15rem 0.5rem;
        font-size: 0.72rem;
        border-radius: 0.3rem;
        border: none;
        background-color: var(--tnd-blue);
        color: #fff;
        transition: all 0.15s;
    }
    .btn-pilih-item-tnd:hover { background-color: var(--tnd-blue-dark); color: #fff; }
    .btn-pilih-item-tnd:disabled { opacity: 0.5; cursor: not-allowed; }
    .highlight-match-tnd { background-color: #ffeb3b; padding: 0 2px; border-radius: 2px; }

    html.dark-mode #tablePilihItemTnd thead th {
        background-color: #2b3035 !important;
        border-color: #454d55 !important;
        color: #adb5bd;
    }
    html.dark-mode #tablePilihItemTnd tbody td {
        color: #dee2e6;
        border-color: #454d55;
    }
    html.dark-mode #tablePilihItemTnd tbody tr:hover {
        background-color: #3a4149 !important;
    }
</style>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper" style="padding: 1.5rem 2rem;">

    <div id="view_main">
        <div class="breadcrumb-custom">
            Master Data &nbsp;&gt;&nbsp; Master Item &nbsp;&gt;&nbsp; <strong>Tindakan</strong>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center">
                <button class="btn btn-sm btn-light border mr-3" style="border-radius: .4rem; height:34px; width:34px;"><i class="fas fa-arrow-left"></i></button>
                <div>
                    <h1 class="page-title">Master Tindakan</h1>
                    <div class="page-subtitle">Kelola data tindakan / jasa medis yang tersedia di klinik.</div>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button class="btn-tnd-outline mr-2" id="btn_export_tindakan"><i class="fas fa-download mr-1"></i> Export</button>
                <button class="btn-tnd-primary" id="btn_tambah_tindakan"><i class="fas fa-plus mr-1"></i> Tambah Tindakan</button>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-9">
                <div class="tnd-card">
                    <div class="row align-items-end">
                        <div class="col-md-4">
                            <label class="field-label">Cari Tindakan</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="f_cari" placeholder="Cari kode atau nama tindakan...">
                                <div class="input-group-append"><span class="input-group-text"><i class="fas fa-search"></i></span></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="field-label">Kategori</label>
                            <select class="form-control" id="f_kategori">
                                <option value="">Semua Kategori</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="field-label">Jenis Tindakan</label>
                            <select class="form-control" id="f_jenis">
                                <option value="">Semua Jenis</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="field-label">Status</label>
                            <select class="form-control" id="f_status">
                                <option value="">Semua Status</option>
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Non Aktif</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button class="btn-reset" id="btn_reset"><i class="fas fa-sync-alt mr-1"></i> Reset</button>
                        </div>
                    </div>
                </div>

                <div class="tnd-card" style="padding: 1.5rem;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 style="font-weight:700; font-size:1rem; margin-bottom:2px;">Daftar Tindakan</h6>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="tindakanTable" class="table table-hover" style="width:100%; margin:0;">
                            <thead>
                                <tr>
                                    <th style="width: 30px; text-align: center;"><div class="icheck-primary d-inline"><input type="checkbox" id="chk_all"><label for="chk_all"></label></div></th>
                                    <th>Kode Tindakan <i class="fas fa-arrows-alt-v text-muted ml-1" style="font-size:.7rem;"></i></th>
                                    <th>Nama Tindakan <i class="fas fa-arrows-alt-v text-muted ml-1" style="font-size:.7rem;"></i></th>
                                    <th>Kategori</th>
                                    <th>Jenis</th>
                                    <th>Durasi</th>
                                    <th>Harga Mulai dari</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                </tbody>
                        </table>
                    </div>
                    <div id="table-footer-wrapper" class="dt-footer-wrapper"></div>
                </div>
            </div>

            <div class="col-lg-3">
                <div style="font-weight:700; font-size:.95rem; margin-bottom:1rem;">Ringkasan Data</div>
                
                <div class="summary-card">
                    <i class="fas fa-stethoscope icon-blue"></i>
                    <div>
                        <div class="summary-lbl">Total Tindakan</div>
                        <div class="summary-val" id="tnd_sum_total">-</div>
                        <div class="summary-sub">Semua data tindakan</div>
                    </div>
                </div>
                <div class="summary-card">
                    <i class="fas fa-check-circle icon-green"></i>
                    <div>
                        <div class="summary-lbl">Tindakan Aktif</div>
                        <div class="summary-val" id="tnd_sum_aktif">-</div>
                        <div class="summary-sub" id="tnd_sum_aktif_sub">dari total</div>
                    </div>
                </div>
                <div class="summary-card">
                    <i class="fas fa-clock icon-yellow"></i>
                    <div>
                        <div class="summary-lbl">Rata-rata Durasi</div>
                        <div class="summary-val" id="tnd_sum_durasi">-</div>
                        <div class="summary-sub">Durasi tindakan</div>
                    </div>
                </div>
                <div class="summary-card">
                    <i class="fas fa-dollar-sign icon-purple"></i>
                    <div>
                        <div class="summary-lbl">Rata-rata Harga</div>
                        <div class="summary-val" id="tnd_sum_harga">-</div>
                        <div class="summary-sub">Dari tindakan aktif</div>
                    </div>
                </div>

                <div class="tnd-card mt-3">
                    <div style="font-weight:700; font-size:.9rem;">Kategori Tindakan</div>
                    <div class="donut-chart-container">
                        <div class="donut-chart" id="tnd_donut_chart"></div>
                        <div class="chart-legend" id="tnd_chart_legend">
                            <div class="legend-item text-muted" style="font-size:.8rem;">Memuat data...</div>
                        </div>
                    </div>
                    <div class="text-right mt-2" style="font-size:.75rem; font-weight:700;">Total &nbsp;&nbsp; 68</div>
                </div>

                <div class="tips-box mt-3" style="background-color:#fffdf0;">
                    <div style="font-weight:700; margin-bottom:.5rem;"><i class="far fa-lightbulb text-warning mr-1"></i> Tips</div>
                    <ul style="font-size:.75rem; color:var(--tnd-text);">
                        <li>Gunakan pencarian untuk menemukan tindakan dengan cepat.</li>
                        <li>Pastikan harga dan durasi sudah sesuai kebijakan klinik.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <div id="view_form" style="display:none;">
        <div class="breadcrumb-custom">
            Master Data &nbsp;&gt;&nbsp; Master Item &nbsp;&gt;&nbsp; Tindakan &nbsp;&gt;&nbsp; <strong>Entry Tindakan</strong>
        </div>

        <div class="wizard-header">
            <div class="d-flex align-items-center">
                <button class="btn btn-sm btn-light border mr-3 btn-batal-entry" style="border-radius: .4rem; height:34px; width:34px;"><i class="fas fa-arrow-left"></i></button>
                <div>
                    <h1 class="page-title">Entry Tindakan</h1>
                    <div class="page-subtitle">Tambah tindakan baru</div>
                </div>
            </div>
            <div class="d-flex gap-2" style="gap: .5rem;">
                <button class="btn-tnd-outline btn-batal-entry"><i class="fas fa-times mr-1"></i> Batal</button>
                <button class="btn-tnd-primary" id="btn_wizard_next">Simpan &amp; Lanjut <i class="fas fa-arrow-right ml-1"></i></button>
            </div>
        </div>

        <div class="wizard-stepper">
            <div class="step-item active" data-step="1"><div class="step-circle">1</div> Informasi Tindakan</div>
            <div class="step-item" data-step="2"><div class="step-circle">2</div> Harga &amp; Tarif</div>
            <div class="step-item" data-step="3"><div class="step-circle">3</div> Kebutuhan &amp; Alat</div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div id="step_1" class="step-pane tnd-card">
                    <h5 style="font-weight:700; font-size:1.1rem; margin-bottom:1.5rem;">Informasi Tindakan</h5>
                    <form id="form_info">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="field-label">Kode Tindakan</label>
                                <input type="text" class="form-control" id="inp_kode" placeholder="Otomatis dibuat oleh sistem" disabled>
                                <div style="font-size:.75rem; color:var(--tnd-muted);">Kode akan dibuat otomatis oleh sistem setelah data disimpan.</div>
                                <span class="error text-danger errorInpKode" style="font-size:.75rem;"></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="field-label">Nama Tindakan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="inp_nama" placeholder="Masukkan nama tindakan">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="field-label">Kategori Tindakan <span class="text-danger">*</span></label>
                                <select class="form-control" id="inp_kategori"><option value="">Pilih kategori tindakan</option></select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="field-label">Jenis Tindakan <span class="text-danger">*</span></label>
                                <select class="form-control" id="inp_jenis"><option value="">Pilih jenis tindakan</option></select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="field-label">Satuan / Unit <span class="text-danger">*</span></label>
                                <select class="form-control" id="inp_satuan"><option value="">Pilih satuan</option></select>
                            </div>
                            <div class="col-md-8 mb-3">
                                <label class="field-label">Deskripsi</label>
                                <textarea class="form-control" id="inp_deskripsi" rows="3" maxlength="500" placeholder="Masukkan deskripsi tindakan (tujuan, prosedur singkat, dll)"></textarea>
                                <div class="text-right text-muted mt-1" style="font-size:.75rem;"><span id="inp_deskripsi_count">0</span> / 500</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="field-label">Durasi (Menit)</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="inp_durasi" placeholder="Masukkan durasi">
                                    <div class="input-group-append"><span class="input-group-text">Menit</span></div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="field-label">Indikasi (Opsional)</label>
                                <textarea class="form-control" rows="2" placeholder="Masukkan indikasi tindakan"></textarea>
                                <div class="text-right text-muted mt-1" style="font-size:.75rem;">0 / 250</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="field-label">Kontraindikasi (Opsional)</label>
                                <textarea class="form-control" rows="2" placeholder="Masukkan kontraindikasi tindakan"></textarea>
                                <div class="text-right text-muted mt-1" style="font-size:.75rem;">0 / 250</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="field-label">Dokter / Tenaga Pelaksana</label>
                                <select class="form-control"><option>Pilih dokter / tenaga</option></select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="field-label">Tingkat Kesulitan</label>
                                <select class="form-control"><option>Pilih tingkat kesulitan</option></select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="field-label">Prioritas</label>
                                <select class="form-control"><option>Pilih prioritas</option></select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="field-label d-block">Status <span class="text-danger">*</span></label>
                                <div class="icheck-primary d-inline mr-3"><input type="radio" id="st_aktif" name="st" checked><label for="st_aktif">Aktif</label></div>
                                <div class="icheck-primary d-inline"><input type="radio" id="st_non" name="st"><label for="st_non">Non-Aktif</label></div>
                                <input type="hidden" id="inp_status" value="1">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="field-label">Urutan</label>
                                <input type="number" class="form-control" placeholder="Masukkan urutan">
                            </div>
                        </div>
                    </form>
                    
                    <div class="info-box-blue mt-2">
                        <i class="fas fa-info-circle mt-1"></i>
                        <div>
                            <strong>Informasi</strong>
                            <ul style="padding-left:1.2rem; margin-bottom:0; margin-top:.3rem; font-size:.85rem;">
                                <li>Pastikan data tindakan diisi dengan benar.</li>
                                <li>Data harga dan kebutuhan dapat diatur pada langkah berikutnya.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div id="step_2" class="step-pane tnd-card" style="display:none;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 style="font-weight:700; font-size:1.1rem; margin-bottom:4px;">Harga &amp; Tarif Tindakan</h5>
                            <div style="font-size:.85rem; color:var(--tnd-muted);">Atur harga jual dan tarif tindakan berdasarkan kelas harga. Anda dapat menambahkan lebih dari satu kelas harga.</div>
                        </div>
                        <button class="btn-tnd-outline" id="btn_goto_harga"><i class="fas fa-plus text-primary mr-1"></i> Tambah Harga</button>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th style="width:50px;">No</th>
                                    <th>Kelas Harga</th>
                                    <th>Mata Uang</th>
                                    <th style="text-align:right;">Harga Jual (Rp)</th>
                                    <th>Berlaku Mulai</th>
                                    <th>Berlaku Sampai</th>
                                    <th style="text-align:center;">Status</th>
                                    <th style="text-align:center; width:100px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_harga_tindakan">
                                <tr><td colspan="8" class="text-center text-muted">Belum ada harga.</td></tr>
                            </tbody>
                        </table>
                        <div style="font-size:.85rem; color:var(--tnd-muted); margin-top:.5rem;" id="harga_tindakan_info">
                            Menampilkan 0 dari 0 data
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div style="font-weight:700; font-size:.95rem; margin-bottom:1rem;">Ringkasan Harga</div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div style="background:var(--tnd-bg-soft); padding:1rem; border-radius:.5rem; text-align:center; border:1px solid var(--tnd-border);">
                                        <div style="font-size:.75rem; color:var(--tnd-muted); font-weight:600;">Jumlah Kelas Harga</div>
                                        <div style="font-size:1.5rem; font-weight:700; color:var(--tnd-blue);">4</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div style="background:var(--tnd-bg-soft); padding:1rem; border-radius:.5rem; text-align:center; border:1px solid var(--tnd-border);">
                                        <div style="font-size:.75rem; color:var(--tnd-muted); font-weight:600;">Harga Tertinggi</div>
                                        <div style="font-size:1.5rem; font-weight:700; color:#198754;">Rp 150.000</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div style="background:var(--tnd-bg-soft); padding:1rem; border-radius:.5rem; text-align:center; border:1px solid var(--tnd-border);">
                                        <div style="font-size:.75rem; color:var(--tnd-muted); font-weight:600;">Harga Terendah</div>
                                        <div style="font-size:1.5rem; font-weight:700; color:#dc3545;">Rp 75.000</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div style="background:var(--tnd-bg-soft); padding:1rem; border-radius:.5rem; text-align:center; border:1px solid var(--tnd-border);">
                                        <div style="font-size:.75rem; color:var(--tnd-muted); font-weight:600;">Rata-rata Harga</div>
                                        <div style="font-size:1.5rem; font-weight:700; color:var(--tnd-purple);">Rp 118.750</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="tips-box" style="background-color:#fffdf0;">
                                <div style="font-weight:700; margin-bottom:.5rem;"><i class="far fa-lightbulb text-warning mr-1"></i> Tips</div>
                                <ul style="font-size:.8rem; color:var(--tnd-text); margin-bottom:0;">
                                    <li>Gunakan kelas harga sesuai kebutuhan (Umum, Asuransi, BPJS, Perusahaan, dll).</li>
                                    <li>Anda dapat menonaktifkan harga tanpa menghapus data.</li>
                                    <li>Perubahan harga akan menjadi riwayat dan dapat dilihat historinya.</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box-blue">
                                <i class="fas fa-info-circle mt-1"></i>
                                <div>
                                    <strong>Info</strong>
                                    <ul style="padding-left:1.2rem; margin-bottom:0; margin-top:.3rem; font-size:.8rem;">
                                        <li>Harga yang dimasukkan akan digunakan pada proses pendaftaran, tindakan, dan pembayaran.</li>
                                        <li>Pastikan periode berlaku tidak saling overlap untuk kelas harga yang sama.</li>
                                        <li>Harga dapat diubah sewaktu-waktu sesuai kebijakan klinik.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3" style="border-top:1px solid var(--tnd-border); display:flex; justify-content:space-between; align-items:center;">
                        <div>
                            <button class="btn-tnd-outline btn-wizard-prev" style="display:none;"><i class="fas fa-arrow-left mr-1"></i> Sebelumnya</button>
                        </div>
                        <div>
                            <button class="btn-tnd-outline mr-2 btn-wizard-cancel"><i class="fas fa-times mr-1"></i> Batal</button>
                            <button class="btn-tnd-primary btn-wizard-next">Lanjut: Kebutuhan &amp; Alat <i class="fas fa-arrow-right ml-1"></i></button>
                            <button class="btn-tnd-primary btn-wizard-save" style="display:none;"><i class="fas fa-save mr-1"></i> Simpan Tindakan</button>
                        </div>
                    </div>
                </div>

                <div id="step_3" class="step-pane tnd-card" style="display:none;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 style="font-weight:700; font-size:1.1rem; margin-bottom:4px;">Kebutuhan Bahan / Alat</h5>
                            <div style="font-size:.85rem; color:var(--tnd-muted);">Tambah bahan (obat, BMHP) dan alat kesehatan yang dibutuhkan untuk melakukan tindakan ini.</div>
                        </div>
                        <button class="btn-tnd-outline" id="btn_tambah_kebutuhan"><i class="fas fa-plus text-primary mr-1"></i> Tambah Item</button>
                    </div>

                    <div class="mb-3">
                        <ul class="nav nav-pills nav-fill" style="border-bottom:1px solid var(--tnd-border); padding-bottom:.5rem;">
                            <li class="nav-item" style="width:auto; margin-right:1rem;">
                                <a class="nav-link kebutuhan-tab-link active" href="#" data-tab="bahan" id="tab_bahan_obat" style="background:var(--tnd-blue); color:#fff; border-radius:.4rem; padding:.3rem 1.5rem; font-size:.85rem;">Bahan / Obat / BMHP</a>
                            </li>
                            <li class="nav-item" style="width:auto;">
                                <a class="nav-link kebutuhan-tab-link" href="#" data-tab="alat" id="tab_alat_kesehatan" style="background:var(--tnd-bg-soft); color:var(--tnd-text); border-radius:.4rem; padding:.3rem 1.5rem; font-size:.85rem; border:1px solid var(--tnd-border);">Alat Kesehatan</a>
                            </li>
                        </ul>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width:50px;">No</th>
                                    <th>Jenis</th>
                                    <th>Item</th>
                                    <th>Satuan</th>
                                    <th style="text-align:center;">Kuantitas</th>
                                    <th>Keterangan</th>
                                    <th style="text-align:center; width:100px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_kebutuhan_tindakan">
                                <tr><td colspan="7" class="text-center text-muted">Belum ada kebutuhan.</td></tr>
                            </tbody>
                        </table>
                        <div style="font-size:.85rem; color:var(--tnd-muted); margin-top:.5rem;" id="kebutuhan_tindakan_info">
                            Menampilkan 0 dari 0 data
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="field-label">Catatan (Opsional)</label>
                        <textarea class="form-control" rows="3" placeholder="Masukkan catatan kebutuhan bahan / alat tindakan (opsional)"></textarea>
                        <div class="text-right text-muted mt-1" style="font-size:.75rem;">0 / 250</div>
                    </div>

                    <div class="info-box-blue mt-3">
                        <i class="fas fa-info-circle mt-1"></i>
                        <div>
                            <ul style="padding-left:1.2rem; margin-bottom:0; margin-top:.3rem; font-size:.85rem;">
                                <li>Kuantitas adalah kebutuhan standar per 1 kali tindakan.</li>
                                <li>Data ini digunakan sebagai acuan perencanaan stok dan estimasi biaya tindakan.</li>
                                <li>Kuantitas dapat disesuaikan saat pelayanan berlangsung.</li>
                            </ul>
                        </div>
                    </div>

                    <div class="tips-box mt-3" style="background-color:#fffdf0;">
                        <div style="font-weight:700; margin-bottom:.5rem;"><i class="far fa-lightbulb text-warning mr-1"></i> Tips</div>
                        <ul style="font-size:.8rem; color:var(--tnd-text); margin-bottom:0;">
                            <li>Tambahkan semua bahan dan alat yang umumnya digunakan untuk tindakan ini.</li>
                            <li>Pastikan kuantitas sesuai standar penggunaan.</li>
                            <li>Anda dapat mengubah daftar ini kapan saja.</li>
                        </ul>
                    </div>

                    <div class="mt-4 pt-3" style="border-top:1px solid var(--tnd-border); display:flex; justify-content:space-between; align-items:center;">
                        <div>
                            <button class="btn-tnd-outline" id="btn_wizard_prev" style="display:none;"><i class="fas fa-arrow-left mr-1"></i> Sebelumnya</button>
                        </div>
                        <div>
                            <button class="btn-tnd-outline mr-2" id="btn_wizard_cancel"><i class="fas fa-times mr-1"></i> Batal</button>
                            <button class="btn-tnd-primary btn-wizard-save"><i class="fas fa-save mr-1"></i> Simpan Tindakan</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="ringkasan-box">
                    <div class="font-weight-bold mb-2" style="font-size:.9rem;">Ringkasan Tindakan</div>

                    <div class="ringkasan-icon-box" id="tnd_ringkasan_empty">
                        <i class="fas fa-notes-medical icon-empty"></i>
                        <div class="ringkasan-empty-title">Belum ada data</div>
                        <div class="ringkasan-empty-sub">Isi informasi tindakan pada langkah 1.</div>
                    </div>
                    <div class="ringkasan-icon-box" id="tnd_ringkasan_filled" style="display:none; align-items:flex-start; text-align:left;">
                        <div style="display:flex; align-items:center; gap:.6rem; width:100%;">
                            <i class="fas fa-clipboard-list" style="font-size:1.4rem; color: var(--tnd-blue);"></i>
                            <div>
                                <div class="ringkasan-code" id="tnd_rk_kode">TND-...</div>
                                <div class="ringkasan-name" id="tnd_rk_nama">Nama Tindakan</div>
                                <span class="ringkasan-badge-draft" id="tnd_rk_draft">Belum disimpan</span>
                            </div>
                        </div>
                    </div>

                    <div class="ringkasan-stat-row"><span>Kategori</span><span id="tnd_rk_kategori">-</span></div>
                    <div class="ringkasan-stat-row"><span>Jenis</span><span id="tnd_rk_jenis">-</span></div>
                    <div class="ringkasan-stat-row"><span>Satuan</span><span id="tnd_rk_satuan">-</span></div>
                    <div class="ringkasan-stat-row"><span>Status</span><span id="tnd_rk_status">-</span></div>
                    <div class="ringkasan-divider"></div>
                    <div class="ringkasan-stat-row"><span>Jumlah Kelas Harga</span><span id="tnd_rk_jumlah_harga">0</span></div>
                    <div class="ringkasan-stat-row"><span>Harga Jual (Rata-rata)</span><span id="tnd_rk_harga_rata">Rp 0</span></div>
                    <div class="ringkasan-divider"></div>
                    <div class="ringkasan-stat-row"><span>Kebutuhan / Alat</span><span id="tnd_rk_jumlah_kebutuhan">0 Item</span></div>

                    <div class="ringkasan-price-box" id="tnd_rk_price_box" style="display:none;">
                        <div class="title">Daftar Harga</div>
                        <div id="tnd_rk_price_list"></div>
                    </div>

                    <div id="tnd_rk_kebutuhan_box" style="display:none; margin-top:.9rem;">
                        <div style="font-weight:700; font-size:.82rem; margin-bottom:.4rem; color:var(--tnd-text);">Daftar Kebutuhan</div>
                        <div id="tnd_rk_kebutuhan_list"></div>
                    </div>

                    <div class="tips-box" id="tnd_rk_tips">
                        <div class="title"><i class="fas fa-lightbulb"></i> Tips</div>
                        <ul id="tnd_rk_tips_list">
                            <li>Isi informasi tindakan pada langkah 1.</li>
                            <li>Tambahkan harga jual pada langkah 2.</li>
                            <li>Tambahkan kebutuhan/alat pada langkah 3.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="view_harga_form" style="display:none;">
        <div class="breadcrumb-custom">
            Master Data &nbsp;&gt;&nbsp; Master Item &nbsp;&gt;&nbsp; Tindakan &nbsp;&gt;&nbsp; Entry Tindakan &nbsp;&gt;&nbsp; Harga &amp; Tarif &nbsp;&gt;&nbsp; <strong>Tambah Harga Tindakan</strong>
        </div>

        <div class="wizard-header">
            <div class="d-flex align-items-center">
                <button class="btn btn-sm btn-light border mr-3 btn-batal-harga" style="border-radius: .4rem; height:34px; width:34px;"><i class="fas fa-arrow-left"></i></button>
                <div>
                    <h1 class="page-title">Tambah Harga Tindakan</h1>
                    <div class="page-subtitle">Buat harga atau tarif baru untuk tindakan</div>
                </div>
            </div>
            <div class="d-flex gap-2" style="gap: .5rem;">
                <button class="btn-tnd-outline btn-batal-harga"><i class="fas fa-times mr-1"></i> Batal</button>
                <button class="btn-tnd-primary" id="btn_simpan_harga_full"><i class="fas fa-save mr-1"></i> Simpan Harga</button>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="tnd-card">
                    <h5 style="font-weight:700; font-size:1.1rem; margin-bottom:1.5rem;">Informasi Harga</h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="field-label">Tindakan <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="h_tindakan_label" value="TND-..." readonly style="background-color: var(--tnd-bg-soft);">
                                <div class="input-group-append"><span class="input-group-text"><i class="fas fa-search"></i></span></div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="field-label">Price Class / Kelas Harga <span class="text-danger">*</span></label>
                            <select class="form-control" id="h_kelas">
                                <option value="">Pilih kelas harga</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="field-label">Mata Uang <span class="text-danger">*</span></label>
                            <select class="form-control" id="h_matauang"><option value="IDR">IDR - Rupiah</option></select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="field-label">Berlaku Mulai <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="h_mulai" value="2024-05-24">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="field-label">Berlaku Sampai</label>
                            <input type="date" class="form-control" id="h_sampai">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="field-label d-block">Status <span class="text-danger">*</span></label>
                            <label class="tnd-switch mt-1">
                                <input type="checkbox" id="h_status" checked>
                                <span class="slider"></span>
                            </label>
                            <span class="tnd-switch-label text-primary">Aktif</span>
                        </div>
                    </div>
                </div>

                <div class="tnd-card">
                    <h5 style="font-weight:700; font-size:1.1rem; margin-bottom:1.5rem;">Harga &amp; Tarif</h5>
                    <div class="row align-items-center mb-4">
                        <div class="col-md-4">
                            <label class="field-label text-danger">Harga Jual (Rp) *</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                                <input type="text" class="form-control text-right" id="h_jual" value="150.000">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="info-box-blue" style="margin-top: 1.5rem;">
                                <i class="fas fa-info-circle mt-1"></i>
                                <div>Harga jual adalah harga yang akan digunakan pada transaksi pelayanan.</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="field-label">Tarif Dokter / Tenaga (Rp)</label>
                            <div class="input-group mb-1">
                                <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                                <input type="text" class="form-control text-right" id="h_dokter" value="100.000">
                            </div>
                            <div style="font-size:.75rem; color:var(--tnd-muted);">Tarif / fee untuk dokter atau tenaga pelaksana.</div>
                        </div>
                        <div class="col-md-4">
                            <label class="field-label">Tarif Alat / Sarana (Rp)</label>
                            <div class="input-group mb-1">
                                <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                                <input type="text" class="form-control text-right" id="h_alat" value="30.000">
                            </div>
                            <div style="font-size:.75rem; color:var(--tnd-muted);">Biaya penggunaan alat atau sarana (jika ada).</div>
                        </div>
                        <div class="col-md-4">
                            <label class="field-label">Biaya Bahan Habis Pakai (Rp)</label>
                            <div class="input-group mb-1">
                                <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                                <input type="text" class="form-control text-right" id="h_bhp" value="20.000">
                            </div>
                            <div style="font-size:.75rem; color:var(--tnd-muted);">Estimasi biaya bahan/alat habis pakai (jika ada).</div>
                        </div>
                    </div>

                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <label class="field-label">Total Biaya (Rp)</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text" style="background:var(--tnd-bg-soft);">Rp</span></div>
                                <input type="text" class="form-control text-right font-weight-bold" id="h_total" value="150.000" readonly style="background:var(--tnd-bg-soft);">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="info-box-blue" style="background-color:var(--tnd-green-bg); color:var(--tnd-green-text); border-color:var(--tnd-green-border); margin-top: 1.5rem;">
                                <i class="fas fa-check-circle mt-1"></i>
                                <div>Total biaya adalah penjumlahan dari tarif dokter, alat/sarana, dan bahan habis pakai.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tnd-card mb-0">
                    <h5 style="font-weight:700; font-size:1.1rem; margin-bottom:1.5rem;">Catatan</h5>
                    <label class="field-label">Catatan (Opsional)</label>
                    <textarea class="form-control" rows="4" placeholder="Masukkan catatan tambahan (opsional)"></textarea>
                    <div class="text-right text-muted mb-4 mt-1" style="font-size:.8rem;">0 / 250</div>
                    
                    <div class="info-box-blue">
                        <i class="fas fa-info-circle mt-1"></i>
                        <div>
                            <strong>Informasi</strong>
                            <ul style="padding-left:1.2rem; margin-bottom:0; margin-top:.3rem; font-size:.85rem;">
                                <li>Hanya satu harga aktif yang boleh berlaku pada satu periode untuk kombinasi Tindakan + Kelas Harga + Mata Uang.</li>
                                <li>Periode harga tidak boleh overlap dengan data harga yang sudah ada.</li>
                                <li>Anda dapat menonaktifkan harga lama jika membuat harga baru.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="tnd-card">
                    <h6 style="font-weight:700; font-size:1rem; margin-bottom:1rem;">Ringkasan Tindakan</h6>
                    
                    <div class="d-flex align-items-center mb-4 p-3" style="background:var(--tnd-bg-soft); border-radius:.5rem;">
                        <i class="fas fa-clipboard-list mr-3" style="font-size:1.8rem; color:var(--tnd-blue);"></i>
                        <div>
                            <div style="font-weight:700; font-size:.95rem; color:var(--tnd-text);" id="h_rk_kode">TND-...</div>
                            <div style="font-size:.85rem; color:var(--tnd-muted);" id="h_rk_nama">Nama Tindakan</div>
                        </div>
                    </div>

                    <table class="table table-sm table-borderless" style="font-size:.85rem; margin-bottom:1.5rem;">
                        <tr><td class="text-muted pl-0" width="40%">Kategori</td><td class="font-weight-bold pr-0 text-right" id="h_rk_kategori">: -</td></tr>
                        <tr><td class="text-muted pl-0">Jenis Tindakan</td><td class="font-weight-bold pr-0 text-right" id="h_rk_jenis">: -</td></tr>
                        <tr><td class="text-muted pl-0">Satuan / Unit</td><td class="font-weight-bold pr-0 text-right" id="h_rk_satuan">: -</td></tr>
                        <tr><td class="text-muted pl-0">Status</td><td class="font-weight-bold pr-0 text-right" id="h_rk_status">: -</td></tr>
                    </table>

                    <div style="border:1px solid var(--tnd-blue); border-radius:.5rem; padding:1.2rem; background-color:#f8faff;">
                        <h6 style="font-weight:700; font-size:.95rem; margin-bottom:1rem;">Ringkasan Harga</h6>
                        
                        <table class="table table-sm table-borderless mb-0" style="font-size:.85rem;">
                            <tr><td class="text-muted pl-0">Kelas Harga</td><td class="font-weight-bold pr-0 text-right">: Umum</td></tr>
                            <tr><td class="text-muted pl-0">Mata Uang</td><td class="font-weight-bold pr-0 text-right">: IDR - Rupiah</td></tr>
                            <tr><td class="text-muted pl-0">Harga Jual</td><td class="font-weight-bold pr-0 text-right">: Rp 150.000</td></tr>
                            <tr><td class="text-muted pl-0">Tarif Dokter / Tenaga</td><td class="font-weight-bold pr-0 text-right">: Rp 100.000</td></tr>
                            <tr><td class="text-muted pl-0">Tarif Alat / Sarana</td><td class="font-weight-bold pr-0 text-right">: Rp 30.000</td></tr>
                            <tr><td class="text-muted pl-0">Bahan Habis Pakai</td><td class="font-weight-bold pr-0 text-right">: Rp 20.000</td></tr>
                            <tr><td colspan="2" class="p-0"><hr style="margin:.5rem 0;"></td></tr>
                            <tr><td class="text-primary font-weight-bold pl-0">Total Biaya</td><td class="text-primary font-weight-bold pr-0 text-right">: Rp 150.000</td></tr>
                        </table>
                    </div>

                    <div class="tips-box mt-3" style="background-color:#fffdf0;">
                        <div style="font-weight:700; margin-bottom:.5rem;"><i class="far fa-lightbulb text-warning mr-1"></i> Tips</div>
                        <ul style="font-size:.8rem; color:var(--tnd-text);">
                            <li>Pastikan harga yang diinput sudah sesuai kebijakan klinik.</li>
                            <li>Anda dapat membuat harga berbeda untuk setiap kelas harga.</li>
                            <li>Harga akan digunakan pada proses pelayanan & penagihan.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <input type="hidden" id="h_edit_id" value="">
        <div class="text-right mt-3 mb-5">
             <button class="btn btn-light border btn-batal-harga mr-2" style="font-weight:600; padding:.4rem 1.5rem;"><i class="fas fa-times mr-1"></i> Batal</button>
             <button class="btn-tnd-primary" id="btn_simpan_harga_bawah" style="padding:.4rem 1.5rem;"><i class="fas fa-save mr-1"></i> Simpan Harga</button>
        </div>
    </div>

    <div id="view_kebutuhan_form" style="display:none;">
        <div class="breadcrumb-custom">
            Master Data &nbsp;&gt;&nbsp; Master Item &nbsp;&gt;&nbsp; Tindakan &nbsp;&gt;&nbsp; Entry Tindakan &nbsp;&gt;&nbsp; Kebutuhan &amp; Alat &nbsp;&gt;&nbsp; <strong>Tambah Kebutuhan &amp; Alat Tindakan</strong>
        </div>

        <div class="wizard-header">
            <div class="d-flex align-items-center">
                <button class="btn btn-sm btn-light border mr-3 btn-batal-kebutuhan" style="border-radius: .4rem; height:34px; width:34px;"><i class="fas fa-arrow-left"></i></button>
                <div>
                    <h1 class="page-title">Tambah Kebutuhan &amp; Alat Tindakan</h1>
                    <div class="page-subtitle">Tambah bahan (obat, BMHP) atau alat kesehatan yang dibutuhkan untuk tindakan ini.</div>
                </div>
            </div>
            <div class="d-flex gap-2" style="gap: .5rem;">
                <button class="btn-tnd-outline btn-batal-kebutuhan"><i class="fas fa-times mr-1"></i> Batal</button>
                <button class="btn-tnd-primary" id="btn_simpan_kebutuhan_full"><i class="fas fa-save mr-1"></i> Simpan Kebutuhan</button>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="tnd-card">
                    <h5 style="font-weight:700; font-size:1.1rem; margin-bottom:1.5rem;">Informasi Item</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Jenis Item <span class="text-danger">*</span></label>
                            <select class="form-control" id="k_jenis_item">
                                <option value="Obat">Obat</option>
                                <option value="BMHP">BMHP</option>
                                <option value="Alat Kesehatan">Alat Kesehatan</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3" style="position:relative;">
                            <label class="field-label">Pilih Item <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="k_cari_item" placeholder="Ketik nama / kode item untuk mencari" autocomplete="off">
                                <div class="input-group-append">
                                    <button class="btn btn-primary btn-sm" type="button" id="btn_cari_item_modal_tnd" title="Cari di modal">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" id="k_item_code" value="">
                            <input type="hidden" id="k_item_uom_id" value="">
                            <div id="k_hasil_pencarian" class="list-group" style="display:none; max-height:180px; overflow:auto; position:absolute; z-index:50; width:calc(100% - 30px);"></div>
                            <div style="font-size:.75rem; color:var(--tnd-muted); margin-top:.3rem;">Ketik nama/kode lalu pilih dari daftar, atau klik 🔍 untuk cari di modal</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Satuan <span class="text-danger">*</span></label>
                            <select class="form-control" id="k_satuan">
                                <option value="Ampul">Ampul</option>
                                <option value="Pcs">Pcs</option>
                                <option value="Botol">Botol</option>
                                <option value="Tablet">Tablet</option>
                                <option value="Vial">Vial</option>
                                <option value="Set">Set</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Unit Konversi</label>
                            <select class="form-control" id="k_unit_konversi">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            <div style="font-size:.75rem; color:var(--tnd-muted); margin-top:.3rem;">1 Ampul</div>
                        </div>
                    </div>
                </div>

                <div class="tnd-card">
                    <h5 style="font-weight:700; font-size:1.1rem; margin-bottom:1.5rem;">Penggunaan &amp; Kuantitas</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Kuantitas <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="k_kuantitas" value="1" min="1">
                                <div class="input-group-append"><span class="input-group-text" id="k_satuan_label">Ampul</span></div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Penggunaan</label>
                            <select class="form-control" id="k_penggunaan">
                                <option value="Sekali pakai">Sekali pakai</option>
                                <option value="Berulang">Berulang</option>
                                <option value="Sesuai kebutuhan">Sesuai kebutuhan</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="tnd-card mb-0">
                    <h5 style="font-weight:700; font-size:1.1rem; margin-bottom:1.5rem;">Catatan (Opsional)</h5>
                    <textarea class="form-control" rows="3" id="k_catatan" placeholder="Masukkan catatan tambahan..."></textarea>
                    <div class="text-right text-muted mt-1" style="font-size:.75rem;">0 / 250</div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="tnd-card">
                    <h6 style="font-weight:700; font-size:1rem; margin-bottom:1rem;">Ringkasan Tindakan</h6>
                    
                    <div class="d-flex align-items-center mb-4 p-3" style="background:var(--tnd-bg-soft); border-radius:.5rem;">
                        <i class="fas fa-clipboard-list mr-3" style="font-size:1.8rem; color:var(--tnd-blue);"></i>
                        <div>
                            <div style="font-weight:700; font-size:.95rem; color:var(--tnd-text);" id="k_rk_kode">TND-...</div>
                            <div style="font-size:.85rem; color:var(--tnd-muted);" id="k_rk_nama">Nama Tindakan</div>
                        </div>
                    </div>

                    <table class="table table-sm table-borderless" style="font-size:.85rem; margin-bottom:1.5rem;">
                        <tr><td class="text-muted pl-0" width="40%">Kategori</td><td class="font-weight-bold pr-0 text-right" id="k_rk_kategori">: -</td></tr>
                        <tr><td class="text-muted pl-0">Jenis Tindakan</td><td class="font-weight-bold pr-0 text-right" id="k_rk_jenis">: -</td></tr>
                        <tr><td class="text-muted pl-0">Satuan / Unit</td><td class="font-weight-bold pr-0 text-right" id="k_rk_satuan">: -</td></tr>
                        <tr><td class="text-muted pl-0">Status</td><td class="font-weight-bold pr-0 text-right" id="k_rk_status">: -</td></tr>
                    </table>

                    <hr>

                    <div style="font-weight:700; font-size:.9rem; margin-bottom:.5rem;">Daftar Kebutuhan &amp; Alat <span style="font-size:.8rem; color:var(--tnd-muted);" id="k_rk_count">(0 item)</span></div>
                    <div id="k_rk_list">
                        <div style="font-size:.8rem; color:var(--tnd-muted); padding:.5rem 0;">Belum ada kebutuhan.</div>
                    </div>

                    <div class="tips-box mt-3" style="background-color:#fffdf0;">
                        <div style="font-weight:700; margin-bottom:.5rem;"><i class="far fa-lightbulb text-warning mr-1"></i> Tips</div>
                        <ul style="font-size:.8rem; color:var(--tnd-text);">
                            <li>Kuantitas adalah kebutuhan standar per 1 kali tindakan.</li>
                            <li>Anda dapat mengubah kuantitas di daftar jika diperlukan.</li>
                            <li>Pastikan satuan sesuai standar penggunaan di klinik.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-right mt-3 mb-5">
            <button class="btn btn-light border btn-batal-kebutuhan mr-2" style="font-weight:600; padding:.4rem 1.5rem;"><i class="fas fa-times mr-1"></i> Batal</button>
            <button class="btn-tnd-primary" id="btn_simpan_kebutuhan_bawah" style="padding:.4rem 1.5rem;"><i class="fas fa-save mr-1"></i> Simpan Kebutuhan</button>
        </div>
    </div>

    <div class="modal fade" id="modalPilihItemTnd" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h4 class="modal-title">Cari Item</h4>
                        <div class="page-subtitle" style="margin-top:2px;">Cari dan pilih item untuk ditambahkan sebagai kebutuhan/alat tindakan</div>
                    </div>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm" id="modal_cari_item_tnd" placeholder="Cari kode / nama item...">
                                <div class="input-group-append">
                                    <button class="btn btn-primary btn-sm" type="button" id="btn_modal_cari_tnd">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control form-control-sm" id="modal_filter_jenis_tnd">
                                <option value="">Semua Jenis</option>
                                <option value="Obat">Obat</option>
                                <option value="BMHP">BMHP</option>
                                <option value="Alat Kesehatan">Alat Kesehatan</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn-tnd-outline btn-block btn-sm" id="btn_modal_reset_tnd">
                                <i class="fas fa-sync-alt mr-1"></i> Reset
                            </button>
                        </div>
                    </div>

                    <div id="modal_item_loading_tnd" class="text-center py-4" style="display:none;">
                        <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
                        <p class="mt-2 text-muted">Memuat data...</p>
                    </div>

                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-sm table-hover table-bordered" id="tablePilihItemTnd">
                            <thead style="position: sticky; top: 0; background: #fff; z-index: 10;">
                                <tr>
                                    <th width="50">#</th>
                                    <th width="120">Kode</th>
                                    <th>Nama Item</th>
                                    <th width="100">Tipe</th>
                                    <th width="100">Satuan</th>
                                    <th width="80">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="modal_item_tbody_tnd">
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-3">
                                        <i class="fas fa-search mr-2"></i> Ketik kata kunci untuk mencari item
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <div class="text-muted small" id="modal_item_info_tnd">Menampilkan 0 item</div>
                        <div>
                            <span class="badge badge-info" id="modal_item_count_tnd">0</span> item ditemukan
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script>
$(document).ready(function () {
    function checkSession(response) {
        if (response && response.status === 'session_expired') {
            window.location.href = "<?= base_url('auth/login') ?>";
            return false;
        }
        return true;
    }

    function highlightText(text, search) {
        if (!text || !search) return text;
        var regex = new RegExp('(' + search.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'gi');
        return text.replace(regex, '<span class="highlight-match-tnd">$1</span>');
    }

    var modalItemListTnd = [];

    function searchItemModalTnd() {
        var search = $('#modal_cari_item_tnd').val().trim();
        var jenis = $('#modal_filter_jenis_tnd').val();

        if (search.length < 2 && !jenis) {
            Swal.fire({
                icon: 'info',
                title: 'Info',
                text: 'Masukkan minimal 2 karakter untuk mencari, atau pilih filter jenis.'
            });
            return;
        }

        $('#modal_item_tbody_tnd').html(
            '<tr><td colspan="6" class="text-center py-4"><i class="fas fa-spinner fa-spin fa-2x text-primary"></i><p class="mt-2 text-muted">Mencari data...</p></td></tr>'
        );
        $('#modal_item_info_tnd').text('Sedang mencari...');
        $('#modal_item_count_tnd').text('...');

        $.ajax({
            url: "<?= site_url('tmsttindakanbaru/searchItem') ?>",
            method: 'GET',
            data: { q: search, jenis: jenis },
            dataType: 'JSON',
            success: function (response) {
                if (response.status === 'success') {
                    modalItemListTnd = response.data || [];
                    renderModalItemListTnd(modalItemListTnd, search);
                } else {
                    $('#modal_item_tbody_tnd').html(
                        '<tr><td colspan="6" class="text-center text-muted py-3"><i class="fas fa-exclamation-circle mr-2"></i> Gagal memuat data</td></tr>'
                    );
                    $('#modal_item_info_tnd').text('Gagal memuat data');
                    $('#modal_item_count_tnd').text('0');
                }
            },
            error: function () {
                $('#modal_item_tbody_tnd').html(
                    '<tr><td colspan="6" class="text-center text-danger py-3"><i class="fas fa-exclamation-triangle mr-2"></i> Terjadi kesalahan koneksi</td></tr>'
                );
                $('#modal_item_info_tnd').text('Error');
                $('#modal_item_count_tnd').text('0');
            }
        });
    }

    function renderModalItemListTnd(items, searchTerm) {
        var $tbody = $('#modal_item_tbody_tnd');
        $tbody.empty();

        if (items.length === 0) {
            $tbody.html(
                '<tr><td colspan="6" class="text-center text-muted py-3"><i class="fas fa-search-minus mr-2"></i> Tidak ada item ditemukan</td></tr>'
            );
            $('#modal_item_info_tnd').text('Tidak ada item ditemukan');
            $('#modal_item_count_tnd').text('0');
            return;
        }

        var searchLower = (searchTerm || '').toLowerCase();

        items.forEach(function (item, index) {
            var kode = item.kode || '';
            var nama = item.nama || '';
            var tipe = item.tipe || '-';
            var satuan = item.satuan || '-';
            var uomId = item.uomId || '';

            var displayKode = kode;
            var displayNama = nama;
            if (searchLower && searchLower.length > 1) {
                displayKode = highlightText(kode, searchLower);
                displayNama = highlightText(nama, searchLower);
            }

            var badgeTipe = '<span class="badge badge-secondary">' + tipe + '</span>';

            var isAlreadySelected = ($('#k_item_code').val() === kode);
            var btnDisabled = isAlreadySelected ? 'disabled' : '';
            var btnText = isAlreadySelected ? 'Terpilih' : 'Pilih';
            var btnClass = isAlreadySelected ? 'btn-secondary' : 'btn-pilih-item-tnd';

            $tbody.append(
                '<tr data-kode="' + kode + '" data-nama="' + nama + '" data-tipe="' + tipe + '" data-uomid="' + uomId + '" data-satuan="' + satuan + '">' +
                '<td class="text-center">' + (index + 1) + '</td>' +
                '<td><strong>' + displayKode + '</strong></td>' +
                '<td>' + displayNama + '</td>' +
                '<td>' + badgeTipe + '</td>' +
                '<td>' + satuan + '</td>' +
                '<td class="text-center"><button type="button" class="' + btnClass + '" data-kode="' + kode + '" ' + btnDisabled + '><i class="fas fa-' + (isAlreadySelected ? 'check' : 'plus') + ' mr-1"></i> ' + btnText + '</button></td>' +
                '</tr>'
            );
        });

        $('#modal_item_info_tnd').text('Menampilkan ' + items.length + ' item');
        $('#modal_item_count_tnd').text(items.length);
    }

    function pilihItemDariModalTnd(kode) {
        var item = modalItemListTnd.find(function (i) { return i.kode === kode; });
        if (!item) {
            Swal.fire({ icon: 'error', title: 'Error', text: 'Item tidak ditemukan.' });
            return;
        }

        $('#k_cari_item').val(item.nama);
        $('#k_item_code').val(item.kode);
        $('#k_item_uom_id').val(item.uomId || '');
        $('#k_satuan_label').text(item.satuan || '');
        $('#k_hasil_pencarian').hide().empty();

        $('#modalPilihItemTnd').modal('hide');
    }

    $('#btn_cari_item_modal_tnd').on('click', function () {
        var currentSearch = $('#k_cari_item').val();
        if (currentSearch) {
            $('#modal_cari_item_tnd').val(currentSearch);
            setTimeout(function () { searchItemModalTnd(); }, 300);
        }
        $('#modalPilihItemTnd').modal('show');
    });

    $('#btn_modal_cari_tnd').on('click', function () {
        searchItemModalTnd();
    });
    $('#modal_cari_item_tnd').on('keydown', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            e.preventDefault();
            e.stopPropagation();
            searchItemModalTnd();
        }
    });

    $('#btn_modal_reset_tnd').on('click', function () {
        $('#modal_cari_item_tnd').val('');
        $('#modal_filter_jenis_tnd').val('');
        $('#modal_item_tbody_tnd').html(
            '<tr><td colspan="6" class="text-center text-muted py-3"><i class="fas fa-search mr-2"></i> Ketik kata kunci untuk mencari item</td></tr>'
        );
        $('#modal_item_info_tnd').text('Menampilkan 0 item');
        $('#modal_item_count_tnd').text('0');
    });

    $(document).on('click', '.btn-pilih-item-tnd', function () {
        var kode = $(this).data('kode');
        if (kode) pilihItemDariModalTnd(kode);
    });

    var table = $('#tindakanTable').DataTable({
        processing: true, 
        serverSide: true, 
        responsive: false, 
        autoWidth: false,
        pageLength: 25,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'Semua']],
        dom: 'Brt<"dt-footer-wrapper"lip>',
        buttons: [
            {
                extend: 'excel',
                text: 'Export',
                className: 'd-none',
                title: 'Data Tindakan',
                exportOptions: { columns: [1, 2, 3, 4, 5, 6, 7] }
            }
        ],
        ajax: {
            url: "<?= site_url('tmsttindakanbaru/datatables') ?>", 
            type: 'POST', 
            contentType: 'application/json',
            data: function (d) {
                d.cari = $('#f_cari').val();
                d.kategori = $('#f_kategori').val();
                d.jenis = $('#f_jenis').val();
                d.status = $('#f_status').val();
                return JSON.stringify(d);
            }
        },
        columns: [
            { data: 'checkbox', orderable: false, className: 'text-center' },
            { data: 'kodeLink' }, { data: 'nama' }, { data: 'kategori' },
            { data: 'jenis' }, { data: 'durasi' }, { data: 'hargaFormat' },
            { data: 'statusBadge' }, { data: 'aksi', orderable: false }
        ],
        language: { 
            sInfo: "Menampilkan _START_ - _END_ dari _TOTAL_ data", 
            sInfoEmpty: "Menampilkan 0 - 0 dari 0 data",
            oPaginate: { sPrevious: "<i class='fas fa-angle-left'></i>", sNext: "<i class='fas fa-angle-right'></i>" } 
        },
        drawCallback: function() {
            var paginate = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate').detach();
            var info = $(this).closest('.dataTables_wrapper').find('.dataTables_info').detach();
            
            $('#table-footer-wrapper').empty();
            if(info.length) $('#table-footer-wrapper').append(info);
            if(paginate.length) $('#table-footer-wrapper').append(paginate);
        }
    });

    $('#btn_export_tindakan').on('click', function () {
        table.button(0).trigger();
    });

    $('#f_cari, #f_kategori, #f_jenis, #f_status').on('keyup change', function() { table.ajax.reload(); });
    $('#btn_reset').click(function() { 
        $('#f_cari, #f_kategori, #f_jenis, #f_status').val(''); 
        table.ajax.reload(); 
    });

    $(document).on('change', '#chk_all', function () {
        $('.row-chk').prop('checked', $(this).is(':checked'));
    });
    $(document).on('change', '.row-chk', function () {
        var total = $('.row-chk').length;
        var checked = $('.row-chk:checked').length;
        $('#chk_all').prop('checked', total > 0 && total === checked);
    });

    window.isViewModeTindakan = false;

    function setTindakanFormDisabled(disabled) {
        $('#form_info input, #form_info select, #form_info textarea').prop('disabled', disabled);
        $('#btn_goto_harga, #btn_tambah_kebutuhan').prop('disabled', disabled).css('opacity', disabled ? 0.5 : 1);
        $('.harga-delete-tnd, .kebutuhan-delete-tnd').prop('disabled', disabled).css('opacity', disabled ? 0.5 : 1);
        $('#btn_wizard_save, .btn-wizard-save').toggle(!disabled);
    }

    function fetchAndOpenTindakan(itemCode, mode) {
        $.ajax({
            url: "<?= site_url('tmsttindakanbaru/fetchSingleData') ?>",
            method: 'GET',
            data: { itemCode: itemCode },
            dataType: 'JSON',
            success: function (response) {
                if (!checkSession(response)) return;
                if (response.status === 'error' || !response.data) {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: response.message || 'Data tidak ditemukan' });
                    return;
                }
                var d = response.data;
                resetWizard();

                $('#inp_kode').val(d.itemCode).prop('disabled', true);
                $('#inp_nama').val(d.itemName);
                $('#inp_kategori').val(d.categoryId).trigger('change');
                $('#inp_jenis').val(d.groupId).trigger('change');
                $('#inp_satuan').val(d.baseUomId).trigger('change');
                $('#inp_deskripsi').val(d.notes);
                $('#inp_deskripsi_count').text((d.notes || '').length);
                $(d.isActive ? '#st_aktif' : '#st_non').prop('checked', true);
                $('#inp_status').val(d.isActive ? '1' : '0');

                window.currentTindakanCode  = d.itemCode;
                window.currentTindakanUomId = d.baseUomId || '';
                window.isEditModeTindakan   = true;
                window.isViewModeTindakan   = (mode === 'View');

                updateRingkasanTindakan();

                $('#view_main').hide();
                $('#view_form').fadeIn();
                goToStep(1);

                setTindakanFormDisabled(window.isViewModeTindakan);
            },
            error: function () {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan koneksi ke server.' });
            }
        });
    }

    $(document).on('click', '.btn-icon-tnd.view', function () {
        fetchAndOpenTindakan($(this).data('code'), 'View');
    });
    $(document).on('click', '.btn-icon-tnd.edit', function () {
        fetchAndOpenTindakan($(this).data('code'), 'Edit');
    });
    
    $('#btn_tambah_tindakan').click(function() {
        $('#view_main').hide(); 
        $('#view_harga_form').hide(); 
        $('#view_kebutuhan_form').hide();
        $('#view_form').fadeIn();
        resetWizard();
    });
    
    $('.btn-batal-entry').click(function() {
        $('#view_form').hide(); 
        $('#view_main').fadeIn();
    });

    $('#btn_goto_harga').click(function() {
        if (!window.currentTindakanUomId) {
            Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Satuan / Unit tindakan belum diatur. Lengkapi Informasi Tindakan (Step 1) terlebih dahulu, lalu simpan ulang.' });
            return;
        }
        $('#h_edit_id').val('');
        $('#h_kelas').val('');
        $('#h_matauang').val('IDR');
        $('#h_jual, #h_dokter, #h_alat, #h_bhp').val('0');
        $('#h_total').val('0');
        $('#h_mulai').val(new Date().toISOString().slice(0, 10));
        $('#h_sampai').val('');
        $('#h_status').prop('checked', true);
        $('#view_form').hide(); 
        updateSubRingkasan('h');
        $('#view_harga_form').fadeIn();
    });

    $('.btn-batal-harga').click(function() {
        $('#view_harga_form').hide();
        $('#view_form').fadeIn();
    });

    $('#btn_simpan_harga_full, #btn_simpan_harga_bawah').click(function() {
        if (!window.currentTindakanCode) {
            Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Simpan Informasi Tindakan (Step 1) terlebih dahulu.' });
            return;
        }
        var payload = {
            price_id: $('#h_edit_id').val() || '',
            kelasHargaId: $('#h_kelas').val(),
            mataUang: $('#h_matauang').val(),
            hargaJual: $('#h_jual').val().replace(/\./g, ''),
            berlakuMulai: $('#h_mulai').val(),
            berlakuSampai: $('#h_sampai').val(),
            uomId: window.currentTindakanUomId || '',
            status: $('#h_status').is(':checked') ? '1' : '0'
        };
        $.ajax({
            url: "<?= site_url('tmsttindakanbaru/saveHarga') ?>/" + window.currentTindakanCode,
            method: 'POST',
            data: payload,
            dataType: 'JSON',
            success: function (response) {
                if (response.status === 'success') {
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message });
                    $('#view_harga_form').hide();
                    $('#view_form').fadeIn();
                    loadHargaTindakan();
                    $('#h_edit_id').val('');
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: response.message });
                }
            },
            error: function () {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan koneksi ke server.' });
            }
        });
    });

    $(document).on('click', '.harga-delete-tnd', function () {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Yakin ingin menghapus harga ini?', icon: 'warning',
            showCancelButton: true, confirmButtonText: 'Ya, hapus', cancelButtonText: 'Batal'
        }).then(function (r) {
            if (!r.isConfirmed) return;
            $.ajax({
                url: "<?= site_url('tmsttindakanbaru/deleteHarga') ?>/" + window.currentTindakanCode + "/" + id,
                method: 'POST',
                dataType: 'JSON',
                success: function (response) {
                    if (response.status === 'success') { Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message }); loadHargaTindakan(); }
                    else Swal.fire({ icon: 'error', title: 'Gagal', text: response.message });
                }
            });
        });
    });

    $(document).on('click', '.kebutuhan-delete-tnd', function () {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Yakin ingin menghapus kebutuhan ini?', icon: 'warning',
            showCancelButton: true, confirmButtonText: 'Ya, hapus', cancelButtonText: 'Batal'
        }).then(function (r) {
            if (!r.isConfirmed) return;
            $.ajax({
                url: "<?= site_url('tmsttindakanbaru/deleteKebutuhan') ?>/" + window.currentTindakanCode + "/" + id,
                method: 'POST',
                dataType: 'JSON',
                success: function (response) {
                    if (response.status === 'success') { Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message }); loadKebutuhanTindakan(); }
                    else Swal.fire({ icon: 'error', title: 'Gagal', text: response.message });
                }
            });
        });
    });

    window.currentKebutuhanTab = 'bahan';

    $('#btn_tambah_kebutuhan').click(function() {
        $('#k_jenis_item').val(window.currentKebutuhanTab === 'alat' ? 'Alat Kesehatan' : 'Obat');
        $('#k_cari_item, #k_item_code, #k_item_uom_id').val('');
        $('#k_satuan').val('Ampul');
        $('#k_unit_konversi').val('1');
        $('#k_satuan_label').text('Ampul');
        $('#k_kuantitas').val('1');
        $('#k_penggunaan').val('Sekali pakai');
        $('#k_catatan').val('');
        $('#view_form').hide(); 
        updateSubRingkasan('k');
        $('#view_kebutuhan_form').fadeIn();
    });

    $(document).on('click', '.kebutuhan-tab-link', function (e) {
        e.preventDefault();
        var tab = $(this).data('tab');
        window.currentKebutuhanTab = tab;

        $('.kebutuhan-tab-link').removeClass('active').css({
            'background': 'var(--tnd-bg-soft)', 'color': 'var(--tnd-text)', 'border': '1px solid var(--tnd-border)'
        });
        $(this).addClass('active').css({
            'background': 'var(--tnd-blue)', 'color': '#fff', 'border': 'none'
        });

        renderKebutuhanTindakan();
    });

    $('.btn-batal-kebutuhan').click(function() {
        $('#view_kebutuhan_form').hide();
        $('#view_form').fadeIn();
    });

    $('#btn_simpan_kebutuhan_full, #btn_simpan_kebutuhan_bawah').click(function() {
        if (!window.currentTindakanCode) {
            Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Simpan Informasi Tindakan (Step 1) terlebih dahulu.' });
            return;
        }
        if (!$('#k_item_code').val()) {
            Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Pilih item terlebih dahulu.' });
            return;
        }
        var payload = {
            itemCode: $('#k_item_code').val(),
            satuanId: $('#k_item_uom_id').val(),
            kuantitas: $('#k_kuantitas').val()
        };
        $.ajax({
            url: "<?= site_url('tmsttindakanbaru/saveKebutuhan') ?>/" + window.currentTindakanCode,
            method: 'POST',
            data: payload,
            dataType: 'JSON',
            success: function (response) {
                if (response.status === 'success') {
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message });
                    $('#view_kebutuhan_form').hide();
                    $('#view_form').fadeIn();
                    loadKebutuhanTindakan();
                    $('#k_cari_item, #k_item_code, #k_item_uom_id').val('');
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: response.message });
                }
            },
            error: function () {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan koneksi ke server.' });
            }
        });
    });

    function hitungTotalBiayaHarga() {
        var dokter = parseFloat(($('#h_dokter').val() || '0').replace(/\./g, '')) || 0;
        var alat   = parseFloat(($('#h_alat').val()   || '0').replace(/\./g, '')) || 0;
        var bhp    = parseFloat(($('#h_bhp').val()    || '0').replace(/\./g, '')) || 0;
        var total  = dokter + alat + bhp;
        $('#h_total').val(total.toLocaleString('id-ID'));
    }
    $(document).on('input', '#h_dokter, #h_alat, #h_bhp', hitungTotalBiayaHarga);

    $('#k_satuan').on('change', function() {
        $('#k_satuan_label').text($(this).val());
    });

    $('#k_satuan').on('change', function() {
        $('#k_satuan_label').text($(this).val());
    }); 

    $('#k_unit_konversi').on('change', function() {
        var satuan = $('#k_satuan').val();
        var val = $(this).val();
        $('#k_satuan_label').text(val + ' ' + satuan);
    });



    var searchItemTimeout;
    $(document).on('keyup', '#k_cari_item', function () {
        var q = $(this).val().trim();
        clearTimeout(searchItemTimeout);
        if (q.length < 2) { $('#k_hasil_pencarian').hide().empty(); return; }
        searchItemTimeout = setTimeout(function () {
            $.ajax({
                url: "<?= site_url('tmsttindakanbaru/searchItem') ?>",
                method: 'GET',
                data: { q: q, jenis: $('#k_jenis_item').val() },
                dataType: 'JSON',
                success: function (response) {
                    var $box = $('#k_hasil_pencarian').empty();
                    if (response.status === 'success' && response.data.length > 0) {
                        response.data.forEach(function (it) {
                            $box.append(
                                '<a href="#" class="list-group-item list-group-item-action item-pencarian-tnd" ' +
                                'data-kode="' + it.kode + '" data-nama="' + it.nama + '" data-uom="' + it.uomId + '" data-satuan="' + it.satuan + '">' +
                                '<strong>' + it.nama + '</strong> <span class="text-muted" style="font-size:.75rem;">(' + it.kode + ')</span></a>'
                            );
                        });
                        $box.show();
                    } else {
                        $box.hide();
                    }
                }
            });
        }, 300);
    });

    $(document).on('click', '.item-pencarian-tnd', function (e) {
        e.preventDefault();
        $('#k_cari_item').val($(this).data('nama'));
        $('#k_item_code').val($(this).data('kode'));
        $('#k_item_uom_id').val($(this).data('uom'));
        $('#k_satuan_label').text($(this).data('satuan'));
        $('#k_hasil_pencarian').hide().empty();
    });

    var hargaListTindakan = [];
    var kebutuhanListTindakan = [];

    function loadHargaTindakan() {
        if (!window.currentTindakanCode) return;
        $.ajax({
            url: "<?= site_url('tmsttindakanbaru/getHarga') ?>/" + window.currentTindakanCode,
            method: 'GET',
            dataType: 'JSON',
            success: function (response) {
                if (response.status === 'success') {
                    hargaListTindakan = response.data;
                    renderHargaTindakan();
                }
            }
        });
    }

    function renderHargaTindakan() {
        var $tbody = $('#tbody_harga_tindakan');
        var isView = window.isViewModeTindakan || false;
        $tbody.empty();
        if (hargaListTindakan.length === 0) {
            $tbody.html('<tr><td colspan="8" class="text-center text-muted">Belum ada harga.</td></tr>');
        } else {
            hargaListTindakan.forEach(function (h, i) {
                $tbody.append(
                    '<tr>' +
                    '<td class="text-center">' + (i + 1) + '</td>' +
                    '<td><strong>' + h.kelas + '</strong></td>' +
                    '<td>' + h.mataUang + '</td>' +
                    '<td style="text-align:right; font-weight:600;">' + Number(h.hargaJual).toLocaleString('id-ID') + '</td>' +
                    '<td>' + (h.berlakuMulai ? h.berlakuMulai.split('T')[0] : '-') + '</td>' +
                    '<td>' + (h.berlakuSampai ? h.berlakuSampai.split('T')[0] : '-') + '</td>' +
                    '<td class="text-center">' + (h.aktif ? '<span class="badge-tnd-aktif">Aktif</span>' : '<span class="badge-tnd-nonaktif">Non Aktif</span>') + '</td>' +
                    '<td class="text-center"><div class="aksi-cell" style="justify-content:center;">' +
                        '<button class="btn-icon-tnd harga-delete-tnd" data-id="' + h.id + '" title="Hapus" style="color:#dc3545;"' + (isView ? ' disabled style="opacity:0.5;color:#dc3545;"' : '') + '><i class="fas fa-trash"></i></button>' +
                    '</div></td></tr>'
                );
            });
        }
        $('#harga_tindakan_info').text('Menampilkan ' + hargaListTindakan.length + ' dari ' + hargaListTindakan.length + ' data');
        updateRingkasanTindakan();
    }

    function loadKebutuhanTindakan() {
        if (!window.currentTindakanCode) return;
        $.ajax({
            url: "<?= site_url('tmsttindakanbaru/getKebutuhan') ?>/" + window.currentTindakanCode,
            method: 'GET',
            dataType: 'JSON',
            success: function (response) {
                if (response.status === 'success') {
                    kebutuhanListTindakan = response.data;
                    renderKebutuhanTindakan();
                }
            }
        });
    }

    function isAlatKesehatan(jenis) {
        var j = (jenis || '').toLowerCase();
        return j.indexOf('alat') !== -1 || j.indexOf('device') !== -1 || j.indexOf('medis') !== -1 && j.indexOf('habis') === -1;
    }

    function renderKebutuhanTindakan() {
        var $tbody = $('#tbody_kebutuhan_tindakan');
        var isView = window.isViewModeTindakan || false;
        var activeTab = window.currentKebutuhanTab || 'bahan';

        var filteredList = kebutuhanListTindakan.filter(function (k) {
            var isAlat = isAlatKesehatan(k.jenis);
            return activeTab === 'alat' ? isAlat : !isAlat;
        });

        $tbody.empty();
        if (filteredList.length === 0) {
            var emptyText = activeTab === 'alat' ? 'Belum ada alat kesehatan.' : 'Belum ada bahan / obat / BMHP.';
            $tbody.html('<tr><td colspan="7" class="text-center text-muted">' + emptyText + '</td></tr>');
        } else {
            filteredList.forEach(function (k, i) {
                $tbody.append(
                    '<tr>' +
                    '<td class="text-center">' + (i + 1) + '</td>' +
                    '<td><span class="badge" style="background:#e6f4ea; color:#0f5132; padding:.3rem .8rem;">' + (k.jenis || 'Obat') + '</span></td>' +
                    '<td><div><strong>' + k.nama + '</strong></div><div style="font-size:.75rem; color:var(--tnd-muted);">' + k.kode + '</div></td>' +
                    '<td>' + k.satuan + '</td>' +
                    '<td style="text-align:center; font-weight:600;">' + k.qty + '</td>' +
                    '<td>' + (k.keterangan || '-') + '</td>' +
                    '<td class="text-center"><div class="aksi-cell" style="justify-content:center;">' +
                        '<button class="btn-icon-tnd kebutuhan-delete-tnd" data-id="' + k.id + '" title="Hapus" style="color:#dc3545;"' + (isView ? ' disabled style="opacity:0.5;color:#dc3545;"' : '') + '><i class="fas fa-trash"></i></button>' +
                    '</div></td></tr>'
                );
            });
        }
        $('#kebutuhan_tindakan_info').text('Menampilkan ' + filteredList.length + ' dari ' + kebutuhanListTindakan.length + ' data');
        updateRingkasanTindakan();

        $('#k_rk_count').text('(' + kebutuhanListTindakan.length + ' item)');
        var $kList = $('#k_rk_list').empty();
        if (kebutuhanListTindakan.length === 0) {
            $kList.html('<div style="font-size:.8rem; color:var(--tnd-muted); padding:.5rem 0;">Belum ada kebutuhan.</div>');
        } else {
            kebutuhanListTindakan.forEach(function (k) {
                var j = (k.jenis || '').toLowerCase();
                var badge = j.indexOf('alat') !== -1 ? 'badge-alat' : (j.indexOf('bmhp') !== -1 ? 'badge-bmhp' : 'badge-obat');
                $kList.append(
                    '<div class="kebutuhan-list-item">' +
                        '<div style="flex:1;">' +
                            '<div style="font-weight:600; font-size:.85rem;">' + k.nama + '</div>' +
                            '<div style="font-size:.75rem; color:var(--tnd-muted);">' + k.qty + ' ' + k.satuan + '</div>' +
                        '</div>' +
                        '<span class="badge-jenis ' + badge + '">' + (k.jenis || 'Obat') + '</span>' +
                    '</div>'
                );
            });
        }
    }

    function rupiahTnd(n) {
        n = Number(n) || 0;
        return 'Rp ' + n.toLocaleString('id-ID');
    }

    function updateRingkasanTindakan() {
        var nama = $('#inp_nama').val().trim();
        var kode = $('#inp_kode').val().trim() || 'TND-...';
        var kategori = $('#inp_kategori option:selected').text();
        var jenis = $('#inp_jenis option:selected').text();
        var satuan = $('#inp_satuan option:selected').text();
        var isActive = $('#inp_status').val() === '1';

        if (!nama && hargaListTindakan.length === 0 && kebutuhanListTindakan.length === 0) {
            $('#tnd_ringkasan_empty').show();
            $('#tnd_ringkasan_filled').hide().css('display', 'none');
        } else {
            $('#tnd_ringkasan_empty').hide();
            $('#tnd_ringkasan_filled').show().css('display', 'flex');
            $('#tnd_rk_kode').text(kode);
            $('#tnd_rk_nama').text(nama || 'Nama Tindakan');
        }

        $('#tnd_rk_kategori').text(kategori || '-');
        $('#tnd_rk_jenis').text(jenis || '-');
        $('#tnd_rk_satuan').text(satuan || '-');
        $('#tnd_rk_status').text(isActive ? 'Aktif' : 'Non-Aktif');
        $('#tnd_rk_status').css('color', isActive ? '#198754' : '#dc3545');

        $('#tnd_rk_jumlah_harga').text(hargaListTindakan.length);
        if (hargaListTindakan.length > 0) {
            var totalHarga = 0;
            hargaListTindakan.forEach(function (h) { totalHarga += Number(h.hargaJual) || 0; });
            var avgHarga = totalHarga / hargaListTindakan.length;
            $('#tnd_rk_harga_rata').text(rupiahTnd(avgHarga));

            $('#tnd_rk_price_box').show();
            var html = '';
            hargaListTindakan.forEach(function (h) {
                html += '<div class="row-item"><span>' + h.kelas + '</span><span>' + rupiahTnd(h.hargaJual) + '</span></div>';
            });
            $('#tnd_rk_price_list').html(html);
        } else {
            $('#tnd_rk_harga_rata').text('Rp 0');
            $('#tnd_rk_price_box').hide();
        }

        $('#tnd_rk_jumlah_kebutuhan').text(kebutuhanListTindakan.length + ' Item');
        if (kebutuhanListTindakan.length > 0) {
            $('#tnd_rk_kebutuhan_box').show();
            var $kbList = $('#tnd_rk_kebutuhan_list').empty();
            kebutuhanListTindakan.forEach(function (k) {
                $kbList.append(
                    '<div class="kebutuhan-list-item">' +
                        '<div style="flex:1;">' +
                            '<div style="font-weight:600; font-size:.82rem;">' + k.nama + '</div>' +
                            '<div style="font-size:.72rem; color:var(--tnd-muted);">' + k.qty + ' ' + k.satuan + '</div>' +
                        '</div>' +
                        '<span style="font-size:.7rem; color:var(--tnd-muted);">' + (k.jenis || '-') + '</span>' +
                    '</div>'
                );
            });
        } else {
            $('#tnd_rk_kebutuhan_box').hide();
        }

        var tips = {
            1: ['Isi informasi tindakan pada langkah 1.', 'Tambahkan harga jual pada langkah 2.', 'Tambahkan kebutuhan/alat pada langkah 3.'],
            2: ['Anda dapat menambahkan lebih dari satu kelas harga.', 'Pastikan harga sudah sesuai kebijakan klinik.'],
            3: ['Tambahkan semua bahan dan alat yang diperlukan.', 'Pastikan kuantitas sesuai standar penggunaan.'],
        };
        var tipHtml = '';
        (tips[currentStep] || []).forEach(function (t) { tipHtml += '<li>' + t + '</li>'; });
        $('#tnd_rk_tips_list').html(tipHtml);
    }

    function loadTindakanDropdowns() {
        $.ajax({
            url: "<?= site_url('tmsttindakanbaru/getKategoriDropdown') ?>",
            method: 'GET', dataType: 'JSON',
            success: function (response) {
                if (response.status === 'success') {
                    var $kat  = $('#inp_kategori').empty().append('<option value="">Pilih kategori tindakan</option>');
                    var $fkat = $('#f_kategori').empty().append('<option value="">Semua Kategori</option>');
                    (response.data || []).forEach(function (item) {
                        $kat.append('<option value="' + item.id + '">' + item.text + '</option>');
                        $fkat.append('<option value="' + item.id + '">' + item.text + '</option>');
                    });
                }
            }
        });

        $.ajax({
            url: "<?= site_url('tmsttindakanbaru/getJenisDropdown') ?>",
            method: 'GET', dataType: 'JSON',
            success: function (response) {
                if (response.status === 'success') {
                    var $jen  = $('#inp_jenis').empty().append('<option value="">Pilih jenis tindakan</option>');
                    var $fjen = $('#f_jenis').empty().append('<option value="">Semua Jenis</option>');
                    (response.data || []).forEach(function (item) {
                        $jen.append('<option value="' + item.id + '">' + item.text + '</option>');
                        $fjen.append('<option value="' + item.id + '">' + item.text + '</option>');
                    });
                }
            }
        });

        $.ajax({
            url: "<?= site_url('tmsttindakanbaru/getSatuanDropdown') ?>",
            method: 'GET', dataType: 'JSON',
            success: function (response) {
                if (response.status === 'success') {
                    var $sat = $('#inp_satuan').empty().append('<option value="">Pilih satuan</option>');
                    (response.data || []).forEach(function (item) {
                        $sat.append('<option value="' + item.id + '">' + item.text + '</option>');
                    });
                }
            }
        });

        $.ajax({
            url: "<?= site_url('tmsttindakanbaru/getKelasHargaDropdown') ?>",
            method: 'GET', dataType: 'JSON',
            success: function (response) {
                if (response.status === 'success') {
                    var $kelas = $('#h_kelas').empty().append('<option value="">Pilih kelas harga</option>');
                    (response.data || []).forEach(function (item) {
                        $kelas.append('<option value="' + item.id + '">' + item.text + '</option>');
                    });
                }
            }
        });
    }
    loadTindakanDropdowns();

    function getSubRingkasanData() {
        var kode = $('#inp_kode').val().trim() || 'TND-...';
        var nama = $('#inp_nama').val().trim() || 'Nama Tindakan';
        var kategori = $('#inp_kategori option:selected').text() || '-';
        var jenis = $('#inp_jenis option:selected').text() || '-';
        var satuan = $('#inp_satuan option:selected').text() || '-';
        var isActive = $('#inp_status').val() === '1';
        return { kode: kode, nama: nama, kategori: kategori, jenis: jenis, satuan: satuan, isActive: isActive };
    }

    function updateSubRingkasan(prefix) {
        var d = getSubRingkasanData();
        $('#' + prefix + '_rk_kode').text(d.kode);
        $('#' + prefix + '_rk_nama').text(d.nama);
        $('#' + prefix + '_rk_kategori').text(': ' + d.kategori);
        $('#' + prefix + '_rk_jenis').text(': ' + d.jenis);
        $('#' + prefix + '_rk_satuan').text(': ' + d.satuan);
        $('#' + prefix + '_rk_status').text(': ' + (d.isActive ? 'Aktif' : 'Non-Aktif'));
        $('#' + prefix + '_rk_status').css('color', d.isActive ? '#198754' : '#dc3545');
        if (prefix === 'h') {
            $('#h_tindakan_label').val(d.kode + ' - ' + d.nama);
        }
    }

    var donutColors = ['var(--tnd-blue)', '#198754', 'var(--tnd-yellow)', 'var(--tnd-purple)', '#dc3545', '#0dcaf0'];

    function rupiahSummary(n) {
        return 'Rp ' + (Number(n) || 0).toLocaleString('id-ID');
    }

    function loadTindakanSummary() {
        $.ajax({
            url: "<?= site_url('tmsttindakanbaru/getSummary') ?>",
            method: 'GET',
            dataType: 'JSON',
            success: function (d) {
                if (d.status !== 'success') return;

                $('#tnd_sum_total').text(d.total || 0);
                $('#tnd_sum_aktif').text(d.aktif || 0);
                $('#tnd_sum_aktif_sub').text((d.pctAktif || 0) + '% dari total');
                $('#tnd_sum_durasi').text((d.avgDurasi || 0) + ' Menit');
                $('#tnd_sum_harga').text(rupiahSummary(d.avgHarga));

                var cats = d.kategori || [];
                var $legend = $('#tnd_chart_legend').empty();
                var $donut  = $('#tnd_donut_chart').empty();
                if (cats.length === 0) {
                    $legend.html('<div class="legend-item text-muted" style="font-size:.8rem;">Tidak ada data</div>');
                    $donut.css('background', 'var(--tnd-border)');
                    return;
                }

                var conic = '';
                var offset = 0;
                cats.forEach(function (c, i) {
                    var clr = donutColors[i % donutColors.length];
                    conic += clr + ' ' + offset + '% ' + (offset + c.persen) + '%, ';
                    $legend.append(
                        '<div class="legend-item"><span class="legend-dot" style="background:' + clr + ';"></span>' +
                        c.nama + ' <b>' + c.jumlah + ' (' + c.persen + '%)</b></div>'
                    );
                    offset += c.persen;
                });
                $donut.css('background', 'conic-gradient(' + conic.slice(0, -2) + ')');
            }
        });
    }
    loadTindakanSummary();

    let currentStep = 1;
    window.currentTindakanCode = null;
    window.currentTindakanUomId = null;
    window.isEditModeTindakan = false;
    goToStep(currentStep);

    function goToStep(step) {
        $('.step-pane').hide();
        $('#step_' + step).fadeIn();
        $('.step-item').removeClass('active done');
        $('.step-item').each(function() {
            let s = $(this).data('step');
            if (s < step) $(this).addClass('done');
            if (s == step) $(this).addClass('active');
        });
        currentStep = step;
        $('#btn_wizard_prev, .btn-wizard-prev').toggle(step > 1);

        var isView = window.isViewModeTindakan || false;

        if (step === 3) {
            $('#btn_wizard_next, .btn-wizard-next').hide();
            $('#btn_wizard_save, .btn-wizard-save').toggle(!isView);
        } else {
            $('#btn_wizard_next, .btn-wizard-next').toggle(!isView);
            $('#btn_wizard_save, .btn-wizard-save').hide();
        }

        if (step === 2) loadHargaTindakan();
        if (step === 3) loadKebutuhanTindakan();
    }

    function submitStep1TindakanThenGoNext() {
        var payload = {
            action: window.isEditModeTindakan ? 'Edit' : 'Add',
            hidden_code: window.currentTindakanCode || '',
            inp_kode: $('#inp_kode').val(),
            inp_nama: $('#inp_nama').val(),
            inp_kategori: $('#inp_kategori').val(),
            inp_jenis: $('#inp_jenis').val(),
            inp_satuan: $('#inp_satuan').val(),
            inp_deskripsi: $('#inp_deskripsi').val(),
            inp_status: $('#inp_status').val()
        };
        $.ajax({
            url: "<?= site_url('tmsttindakanbaru/action') ?>",
            method: 'POST',
            data: payload,
            dataType: 'JSON',
            success: function (response) {
                if (response.error) {
                    Swal.fire({ icon: 'warning', title: 'Perhatian', text: Object.values(response.error).join('\n') });
                    return;
                }
                if (response.status === 'success') {
                    window.currentTindakanCode = response.itemCode;
                    window.currentTindakanUomId = response.baseUomId || '';
                    window.isEditModeTindakan = true;
                    $('#inp_kode').val(response.itemCode).prop('disabled', true);
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message });
                    goToStep(2);
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: response.message || 'Gagal menyimpan.' });
                }
            },
            error: function () {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan koneksi ke server.' });
            }
        });
    }

    $(document).on('click', '#btn_wizard_next, .btn-wizard-next', function () {
        if (currentStep === 1) {
            $('.errorInpKode').text('');
            var msgs = [];
            if ($('#inp_nama').val().trim() === '') msgs.push('Nama tindakan harus diisi');
            if (!$('#inp_kategori').val()) msgs.push('Kategori tindakan harus dipilih');
            if (!$('#inp_jenis').val()) msgs.push('Jenis tindakan harus dipilih');
            if (!$('#inp_satuan').val()) msgs.push('Satuan / Unit harus dipilih');
            if (msgs.length > 0) { Swal.fire({ icon: 'warning', title: 'Perhatian', text: msgs.join('<br>') }); return; }
            submitStep1TindakanThenGoNext();
            return;
        }
        if (currentStep < 3) goToStep(currentStep + 1);
    });

    $(document).on('click', '#btn_wizard_prev, .btn-wizard-prev', function () {
        if (currentStep > 1) goToStep(currentStep - 1);
    });

    $('.step-item').click(function() {
        goToStep($(this).data('step'));
    });

    $(document).on('click', '#btn_wizard_cancel, .btn-wizard-cancel', function () {
        $('#view_form').hide();
        $('#view_main').fadeIn();
        Swal.fire({ icon: 'info', title: 'Dibatalkan', text: 'Data tindakan dibatalkan.' });
    });

    $(document).on('click', '#btn_wizard_save, .btn-wizard-save', function () {
        if (window.currentTindakanCode) {
            Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Tindakan berhasil disimpan!' });
        }
        $('#view_form').hide();
        $('#view_main').fadeIn();
    });

    function resetWizard() {
        $('#form_info')[0].reset();
        $('#form_info input, #form_info select, #form_info textarea').prop('disabled', false);
        $('.errorInpKode').text('');
        window.currentTindakanCode = null;
        window.currentTindakanUomId = null;
        window.isEditModeTindakan = false;
        window.isViewModeTindakan = false;   
        window.currentKebutuhanTab = 'bahan';
        $('.kebutuhan-tab-link').removeClass('active').css({
            'background': 'var(--tnd-bg-soft)', 'color': 'var(--tnd-text)', 'border': '1px solid var(--tnd-border)'
        });
        $('#tab_bahan_obat').addClass('active').css({
            'background': 'var(--tnd-blue)', 'color': '#fff', 'border': 'none'
        });
        setTindakanFormDisabled(false);      
        $('#inp_kode').prop('disabled', true);
        hargaListTindakan = [];
        kebutuhanListTindakan = [];
        $('#inp_status').val('1');
        $('#st_aktif').prop('checked', true);
        $('#inp_deskripsi_count').text('0');
        renderHargaTindakan();
        renderKebutuhanTindakan();
        goToStep(1);
        updateRingkasanTindakan();
    }
    
    $(document).on('change', 'input[name="st"]', function () {
        $('#inp_status').val(this.id === 'st_aktif' ? '1' : '0');
        updateRingkasanTindakan();
    });
    $(document).on('keyup', '#inp_deskripsi', function () {
        $('#inp_deskripsi_count').text($(this).val().length);
    });

    $('#inp_nama').on('keyup', updateRingkasanTindakan);
    $('#inp_kategori').on('change', updateRingkasanTindakan);
    $('#inp_jenis').on('change', updateRingkasanTindakan);
    $('#inp_satuan').on('change', updateRingkasanTindakan);
    

    function doDelete(itemCode) {
        Swal.fire({
            title: 'Yakin ingin menghapus data?',
            text: 'Data tindakan akan dihapus.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('tmsttindakanbaru/delete') ?>",
                    method: 'POST',
                    data: { itemCode: itemCode },
                    dataType: 'JSON',
                    success: function (response) {
                        if (!checkSession(response)) return;
                        if (response.status === 'error') {
                            Swal.fire({ icon: 'error', title: 'Gagal', text: response.message || 'Gagal menghapus data.' });
                        } else {
                            Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message || 'Data berhasil dihapus.' });
                            $('#tindakanTable').DataTable().ajax.reload(null, false);
                        }
                    },
                    error: function () {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal menghubungi server.' });
                    }
                });
            }
        });
    }

    $(document).on('click', '.btn-icon-tnd.delete', function (e) {
        e.stopPropagation();
        doDelete($(this).data('code'));
    });
});
</script>
<?= $this->endSection(); ?>