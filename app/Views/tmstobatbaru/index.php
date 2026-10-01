<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="<?= base_url('plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
<style>
    :root {
        --ob-blue: #0d6efd;
        --ob-blue-dark: #0b5ed7;
        --ob-blue-soft: #f0f4ff;
        --ob-text: #212529;
        --ob-muted: #6c757d;
        --ob-border: #e9ecef;
        --ob-bg-soft: #f8f9fa;
        --ob-green-bg: #e6f4ea;
        --ob-green-text: #0f5132;
        --ob-green-border: #badbcc;
        --ob-gray-bg: #f1f2f4;
        --ob-gray-text: #41464b;
        --ob-amber-bg: #fffbf0;
        --ob-amber-border: #f9e2b0;
        --ob-amber-text: #856404;
        --ob-purple: #6f42c1;
        --ob-yellow: #ffc107;
        --ob-red: #dc3545;
        --ob-card-bg: #ffffff;
        --ob-body-bg: #f4f6f9;
    }

    body { 
        background-color: var(--ob-body-bg); 
        color: var(--ob-text);
    }

    .form-control, .select2-container--default .select2-selection--single { 
        font-size: .85rem !important; 
        border-radius: .4rem; 
        border: 1px solid var(--ob-border);
        background-color: var(--ob-card-bg);
        color: var(--ob-text);
    }
    .form-control:focus {
        border-color: var(--ob-blue);
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
    .form-control[readonly] {
        background-color: var(--ob-bg-soft);
    }
    select.form-control option {
        background-color: var(--ob-card-bg);
        color: var(--ob-text);
    }
    
    .ob-card {
        background: var(--ob-card-bg); 
        border: 1px solid var(--ob-border);
        border-radius: .6rem; 
        box-shadow: 0 1px 2px rgba(0,0,0,.03);
        padding: 1.25rem; 
        margin-bottom: 1.25rem;
    }
    
    .page-title { 
        font-size: 1.4rem; 
        font-weight: 700; 
        margin-bottom: 2px; 
        color: var(--ob-text); 
    }
    .page-subtitle { 
        font-size: .85rem; 
        color: var(--ob-muted); 
    }
    .breadcrumb-custom { 
        font-size: .8rem; 
        color: var(--ob-muted); 
        margin-bottom: 1.5rem; 
    }
    .breadcrumb-custom a { 
        color: var(--ob-blue); 
        text-decoration: none; 
    }

    .btn-ob-primary {
        background-color: var(--ob-blue); 
        border-color: var(--ob-blue); 
        color: #fff;
        font-weight: 600; 
        font-size: .85rem; 
        border-radius: .4rem; 
        padding: .45rem 1.2rem;
        transition: all .2s;
    }
    .btn-ob-primary:hover { 
        background-color: var(--ob-blue-dark); 
        color: #fff; 
        border-color: var(--ob-blue-dark);
    }
    
    .btn-ob-outline {
        background-color: transparent; 
        border: 1px solid var(--ob-border); 
        color: var(--ob-text);
        font-weight: 600; 
        font-size: .85rem; 
        border-radius: .4rem; 
        padding: .45rem 1.2rem;
        transition: all .2s;
    }
    .btn-ob-outline:hover { 
        background-color: var(--ob-bg-soft); 
        color: var(--ob-text); 
        border-color: var(--ob-blue);
    }

    .btn-reset {
        background-color: transparent; 
        border: 1px solid var(--ob-border); 
        color: var(--ob-text);
        border-radius: .4rem; 
        height: calc(1.5em + .75rem + 2px); 
        width: 100%;
        display: flex; 
        align-items: center; 
        justify-content: center; 
        font-weight: 600; 
        font-size: .85rem;
        transition: all .3s;
    }
    .btn-reset:hover { 
        background-color: var(--ob-bg-soft); 
        border-color: var(--ob-blue);
    }

    .btn-sm-light {
        background: var(--ob-card-bg);
        border-color: var(--ob-border);
        color: var(--ob-text);
    }
    .btn-sm-light:hover {
        background: var(--ob-bg-soft);
    }

    table.dataTable thead th, .table thead th {
        background-color: var(--ob-bg-soft); 
        font-size: .75rem; 
        color: var(--ob-text);
        font-weight: 600; 
        border-bottom: 1px solid var(--ob-border); 
        border-top: none;
        padding: .8rem; 
        white-space: nowrap;
    }
    table.dataTable tbody td, .table tbody td { 
        font-size: .85rem; 
        vertical-align: middle; 
        border-bottom: 1px solid var(--ob-border); 
        padding: .8rem;
        color: var(--ob-text);
    }
    table.dataTable tbody tr:hover {
        background-color: var(--ob-bg-soft);
    }
    .kode-link { 
        color: var(--ob-blue); 
        font-weight: 600; 
        text-decoration: none; 
    }
    .kode-link:hover {
        text-decoration: underline;
    }
    
    .badge-ob-aktif { 
        background-color: var(--ob-green-bg); 
        color: var(--ob-green-text); 
        padding: .3rem .8rem; 
        border-radius: 99px; 
        font-size: .75rem; 
        font-weight: 600; 
        border: 1px solid var(--ob-green-border); 
        display: inline-block; 
        text-align: center; 
        min-width: 60px; 
    }
    .badge-ob-nonaktif { 
        background-color: var(--ob-gray-bg); 
        color: var(--ob-gray-text); 
        padding: .3rem .8rem; 
        border-radius: 99px; 
        font-size: .75rem; 
        font-weight: 600; 
        border: 1px solid #d3d4d5; 
        display: inline-block; 
        text-align: center; 
        min-width: 60px; 
    }
    .badge-ob-expired {
        background-color: #fde8e8;
        color: #dc3545;
        padding: .15rem .6rem;
        border-radius: 99px;
        font-size: .7rem;
        font-weight: 600;
        display: inline-block;
        text-align: center;
    }
    .badge-ob-warning {
        background-color: var(--ob-amber-bg);
        color: var(--ob-amber-text);
        padding: .15rem .6rem;
        border-radius: 99px;
        font-size: .7rem;
        font-weight: 600;
        display: inline-block;
        text-align: center;
    }
    .badge-ob-safe {
        background-color: var(--ob-green-bg);
        color: var(--ob-green-text);
        padding: .15rem .6rem;
        border-radius: 99px;
        font-size: .7rem;
        font-weight: 600;
        display: inline-block;
        text-align: center;
    }
    .badge-resep-ya {
        background-color: var(--ob-green-bg);
        color: var(--ob-green-text);
        padding: .15rem .6rem;
        border-radius: 99px;
        font-size: .7rem;
        font-weight: 600;
        display: inline-block;
    }
    .badge-resep-tidak {
        background-color: var(--ob-gray-bg);
        color: var(--ob-gray-text);
        padding: .15rem .6rem;
        border-radius: 99px;
        font-size: .7rem;
        font-weight: 600;
        display: inline-block;
    }

    .aksi-cell { 
        display: flex; 
        gap: .5rem; 
        align-items: center; 
        justify-content: center;
    }
    .btn-icon-ob { 
        background: none; 
        border: none; 
        color: var(--ob-muted); 
        font-size: .95rem; 
        padding: .2rem .4rem; 
        cursor: pointer;
        border-radius: .3rem;
        transition: all .2s;
    }
    .btn-icon-ob.view { 
        color: var(--ob-blue); 
    }
    .btn-icon-ob.view:hover {
        background: var(--ob-blue-soft);
    }
    .btn-icon-ob.delete {
        color: var(--ob-red);
    }
    .btn-icon-ob.edit:hover {
        background: var(--ob-amber-bg);
        color: var(--ob-amber-text);
    }
    .btn-icon-ob.delete:hover {
        background: #fde8e8;
        color: #dc3545;
    }
    .btn-icon-ob:hover { 
        opacity: 0.8; 
    }
    
    .summary-card { 
        background: var(--ob-card-bg); 
        border: 1px solid var(--ob-border);
        border-radius: .5rem; 
        padding: 1rem; 
        margin-bottom: .8rem; 
        display:flex; 
        align-items:center; 
        gap: 1rem;
    }
    .summary-card i { 
        font-size: 1.8rem; 
        padding: .8rem; 
        border-radius: .4rem; 
        width: 3.8rem;
        text-align: center;
    }
    .summary-card .icon-blue { 
        background: var(--ob-blue-soft); 
        color: var(--ob-blue); 
    }
    .summary-card .icon-green { 
        background: var(--ob-green-bg); 
        color: #198754; 
    }
    .summary-card .icon-yellow { 
        background: var(--ob-amber-bg); 
        color: #ffc107; 
    }
    .summary-card .icon-red { 
        background: #fde8e8; 
        color: #dc3545; 
    }
    .summary-card .icon-purple {
        background: #f3e8ff;
        color: #6f42c1;
    }
    .summary-val { 
        font-size: 1.1rem; 
        font-weight: 700; 
        color: var(--ob-text); 
        margin-bottom: 2px;
    }
    .summary-lbl { 
        font-size: .75rem; 
        font-weight: 600; 
        color: var(--ob-text); 
    }
    .summary-sub { 
        font-size: .7rem; 
        color: var(--ob-muted); 
    }

    .formularium-box {
        background-color: var(--ob-blue-soft);
        border: 1px solid #cce5ff;
    }

    html.dark-mode .formularium-box {
        background-color: #1a2a3f;
        border-color: #2a4060;
    }

    .info-box-blue { 
        background-color: var(--ob-blue-soft); 
        border: 1px solid #cce5ff; 
        border-radius: .4rem; 
        padding: .8rem 1rem; 
        font-size: .85rem; 
        color: var(--ob-blue); 
        display: flex; 
        gap: .8rem; 
        align-items: flex-start; 
    }
    .tips-box { 
        background: var(--ob-amber-bg); 
        border: 1px solid var(--ob-amber-border); 
        border-radius: .5rem; 
        padding: 1rem; 
        font-size: .8rem; 
        color: var(--ob-amber-text); 
    }
    .tips-box ul { 
        padding-left: 1.2rem; 
        margin-bottom: 0; 
        margin-top: .4rem;
    }

    .field-label { 
        font-size: .8rem; 
        font-weight: 700; 
        color: var(--ob-text); 
        margin-bottom: .4rem; 
    }
    .input-group-text { 
        background-color: var(--ob-bg-soft); 
        border-color: var(--ob-border); 
        font-size: .85rem; 
        color: var(--ob-muted); 
        font-weight: 600;
    }

    .dataTables_paginate {
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .dataTables_paginate .paginate_button {
        padding: .3rem .8rem !important;
        margin: 0 2px !important;
        border-radius: .3rem !important;
        border: 1px solid var(--ob-border) !important;
        background: var(--ob-card-bg) !important;
        color: var(--ob-text) !important;
        font-size: .85rem !important;
        cursor: pointer;
        transition: all .2s;
    }
    .dataTables_paginate .paginate_button:hover {
        background: var(--ob-bg-soft) !important;
        border-color: var(--ob-blue) !important;
    }
    .dataTables_paginate .paginate_button.current {
        background: var(--ob-blue) !important;
        color: #fff !important;
        border-color: var(--ob-blue) !important;
    }
    .dataTables_paginate .paginate_button.disabled {
        opacity: .5;
        cursor: not-allowed;
    }
    .dataTables_paginate .paginate_button.previous,
    .dataTables_paginate .paginate_button.next {
        padding: .3rem .6rem !important;
    }
    .dataTables_info {
        font-size: .85rem;
        color: var(--ob-muted);
        padding: .5rem 0;
    }
    .dt-footer-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        flex-wrap: wrap;
        gap: .5rem;
    }
    .dt-footer-wrapper .dataTables_paginate {
        display: flex;
        align-items: center;
        gap: 2px;
    }
    .dt-footer-wrapper .dataTables_paginate span {
        display: flex;
        align-items: center;
        gap: 2px;
    }

    .dataTables_wrapper .dataTables_info { 
        padding-top: 0 !important; 
        font-size: .85rem; 
        color: var(--ob-muted); 
    }

    .filter-dropdown {
        position: relative;
        display: inline-block;
        width: 100%;
    }
    .filter-dropdown-menu {
        display: none;
        position: absolute;
        right: 0;
        top: 100%;
        background: var(--ob-card-bg);
        border: 1px solid var(--ob-border);
        border-radius: .4rem;
        padding: 1rem;
        min-width: 280px;
        z-index: 1000;
        box-shadow: 0 4px 12px rgba(0,0,0,.15);
        margin-top: 4px;
    }
    .filter-dropdown-menu.show {
        display: block;
    }
    .filter-dropdown-menu .field-label {
        font-size: .75rem;
        margin-bottom: .2rem;
    }
    .filter-dropdown-menu .form-control {
        font-size: .8rem !important;
    }

    .wizard-header { 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        margin-bottom: 1.5rem; 
        flex-wrap: wrap;
        gap: .5rem;
    }
    .wizard-stepper { 
        display: flex; 
        gap: 1.5rem; 
        margin-bottom: 1.5rem; 
        border-bottom: 1px solid var(--ob-border); 
        padding-bottom: 1rem; 
        flex-wrap: wrap; 
    }
    .step-item { 
        display: flex; 
        align-items: center; 
        gap: .5rem; 
        color: var(--ob-muted); 
        font-weight: 600; 
        font-size: .9rem; 
        cursor: pointer; 
        padding: .3rem .8rem; 
        border-radius: .4rem; 
        transition: all .2s; 
    }
    .step-item.active { 
        color: var(--ob-blue); 
        background: var(--ob-blue-soft); 
    }
    .step-item.done { 
        color: #198754; 
    }
    .step-item:hover { 
        background: var(--ob-bg-soft); 
    }
    
    .step-circle { 
        width: 28px; 
        height: 28px; 
        border-radius: 50%; 
        border: 2px solid var(--ob-muted); 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        font-size: .75rem; 
        font-weight: 700; 
        background: var(--ob-card-bg); 
        color: var(--ob-muted); 
        flex-shrink: 0; 
        transition: all .2s;
    }
    .step-item.active .step-circle { 
        background: var(--ob-blue); 
        color: #fff; 
        border-color: var(--ob-blue); 
    }
    .step-item.done .step-circle { 
        background: #198754; 
        color: #fff; 
        border-color: #198754; 
    }

    .tab-pane { 
        display: none; 
    }
    .tab-pane.active { 
        display: block; 
        animation: fadeIn .3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .uom-base-row { 
        background: var(--ob-blue-soft); 
    }

    .drop-zone {
        border: 2px dashed var(--ob-border);
        border-radius: .5rem;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: all .3s;
        background: var(--ob-bg-soft);
        color: var(--ob-text);
    }
    .drop-zone:hover { 
        border-color: var(--ob-blue); 
        background: var(--ob-blue-soft); 
    }
    .drop-zone.dragover { 
        border-color: var(--ob-blue); 
        background: var(--ob-blue-soft); 
    }
    .drop-zone i { 
        font-size: 3rem; 
        color: var(--ob-muted); 
        margin-bottom: 1rem; 
        display: block; 
    }

    .ob-switch { 
        position: relative; 
        display: inline-block; 
        width: 40px; 
        height: 22px; 
        margin-bottom: 0; 
        vertical-align: middle; 
    }
    .ob-switch input { 
        opacity: 0; 
        width: 0; 
        height: 0; 
    }
    .ob-switch .slider { 
        position: absolute; 
        cursor: pointer; 
        top: 0; 
        left: 0; 
        right: 0; 
        bottom: 0; 
        background-color: #ccc; 
        transition: .2s; 
        border-radius: 34px; 
    }
    .ob-switch .slider:before { 
        position: absolute; 
        content: ""; 
        height: 16px; 
        width: 16px; 
        left: 3px; 
        bottom: 3px; 
        background-color: white; 
        transition: .2s; 
        border-radius: 50%; 
    }
    .ob-switch input:checked + .slider { 
        background-color: var(--ob-blue); 
    }
    .ob-switch input:checked + .slider:before { 
        transform: translateX(18px); 
    }
    .ob-switch-label { 
        font-size: .85rem; 
        font-weight: 600; 
        vertical-align: middle; 
        margin-left: 8px; 
        cursor: pointer; 
        color: var(--ob-text);
    }

    @media (max-width: 768px) {
        .wizard-stepper {
            gap: .5rem;
        }
        .step-item {
            font-size: .75rem;
            padding: .2rem .5rem;
        }
        .step-circle {
            width: 22px;
            height: 22px;
            font-size: .65rem;
        }
        .summary-card i {
            font-size: 1.2rem;
            padding: .5rem;
            width: 2.8rem;
        }
        .summary-val {
            font-size: .9rem;
        }
        .filter-dropdown-menu {
            min-width: 200px;
            right: auto;
            left: 0;
        }
        .dt-footer-wrapper {
            flex-direction: column;
            align-items: center;
        }
    }

    html.dark-mode {
        --ob-blue: #6ea8fe;
        --ob-blue-dark: #4d8fd6;
        --ob-blue-soft: #1a2a3f;
        --ob-text: #dee2e6;
        --ob-muted: #adb5bd;
        --ob-border: #454d55;
        --ob-bg-soft: #2b3035;
        --ob-green-bg: #1a3a2a;
        --ob-green-text: #86efac;
        --ob-green-border: #2d5a44;
        --ob-gray-bg: #343a40;
        --ob-gray-text: #adb5bd;
        --ob-amber-bg: #3a2e10;
        --ob-amber-border: #5a4a20;
        --ob-amber-text: #fcd34d;
        --ob-card-bg: #343a40;
        --ob-body-bg: #24282e;
    }

    html.dark-mode .content-wrapper { background-color: #24282e; color: #dee2e6; }
    html.dark-mode .ob-card,
    html.dark-mode .summary-card { background-color: #343a40; border-color: #454d55; }
    html.dark-mode .tips-box { background-color: #3a2e10; border-color: #5a4a20; color: #fcd34d; }
    html.dark-mode .tips-box ul { color: #fcd34d; }

    html.dark-mode .page-title,
    html.dark-mode .page-subtitle,
    html.dark-mode h6,
    html.dark-mode .field-label,
    html.dark-mode .breadcrumb-custom strong { color: #f1f1f1; }
    html.dark-mode .breadcrumb-custom { color: #adb5bd; }
    html.dark-mode .summary-lbl { color: #adb5bd; }
    html.dark-mode .summary-val { color: #f1f1f1; }
    html.dark-mode .summary-sub { color: #adb5bd; }

    html.dark-mode .summary-card .icon-blue { background-color: #1a2a3f; color: #6ea8fe; }
    html.dark-mode .summary-card .icon-green { background-color: #1a3a2a; color: #86efac; }
    html.dark-mode .summary-card .icon-yellow { background-color: #3a2e10; color: #fbbf24; }
    html.dark-mode .summary-card .icon-red { background-color: #3a1a1a; color: #ff6b6b; }
    html.dark-mode .summary-card .icon-purple { background-color: #2a1a3f; color: #b794f6; }

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
    html.dark-mode table.dataTable tbody tr:hover,
    html.dark-mode .table tbody tr:hover { background-color: #3a4149; }
    html.dark-mode .table-responsive { border-color: #454d55; }
    html.dark-mode table.dataTable tbody tr:nth-child(odd) { background-color: #2b3035; }
    html.dark-mode table.dataTable tbody tr:nth-child(even) { background-color: #343a40; }

    html.dark-mode .dataTables_wrapper .dataTables_paginate .paginate_button { background: #343a40; border-color: #454d55; color: #adb5bd !important; }
    html.dark-mode .dataTables_wrapper .dataTables_paginate .paginate_button.current { background: var(--ob-blue) !important; color: #fff !important; border-color: var(--ob-blue); }
    html.dark-mode .dataTables_wrapper .dataTables_paginate .paginate_button:hover { background: #3a4149; border-color: #6ea8fe; }
    html.dark-mode .dataTables_wrapper .dataTables_info { color: #adb5bd; }
    html.dark-mode .dt-footer-wrapper { color: #adb5bd; }
    html.dark-mode #obatTable_wrapper .dataTables_filter input { background-color: #2b3035; border-color: #555d66; color: #f1f1f1; }

    html.dark-mode .btn-ob-primary { background-color: var(--ob-blue); border-color: var(--ob-blue); }
    html.dark-mode .btn-ob-outline,
    html.dark-mode .btn-sm-light { background-color: #343a40; border-color: #555d66; color: #f1f1f1; }
    html.dark-mode .btn-ob-outline:hover,
    html.dark-mode .btn-sm-light:hover { background-color: #3a4149; }

    html.dark-mode .badge-ob-aktif { background-color: #1a3a2a; color: #86efac; border-color: #2d5a44; }
    html.dark-mode .badge-ob-nonaktif { background-color: #495057; color: #adb5bd; border-color: #555d66; }
    html.dark-mode .badge-ob-batch { background-color: #1a2a3f; color: #93c5fd; border-color: #2a4060; }

    html.dark-mode .btn-icon-ob { color: #adb5bd; }
    html.dark-mode .btn-icon-ob.view { color: #6ea8fe; }
    html.dark-mode .btn-icon-ob.delete { color: #ff6b6b; }
    html.dark-mode .btn-icon-ob.view:hover { background: #1a2a3f; }
    html.dark-mode .btn-icon-ob.edit:hover { background: #3a2e10; color: #fcd34d; }
    html.dark-mode .btn-icon-ob.delete:hover { background: #3a1a1a; color: #ff6b6b; }

    html.dark-mode .step-circle { background-color: #454d55; color: #adb5bd; border-color: #454d55; }
    html.dark-mode .step-item.active .step-circle { background-color: var(--ob-blue); color: #fff; border-color: var(--ob-blue); }
    html.dark-mode .step-item.done .step-circle { background-color: #198754; color: #fff; border-color: #198754; }
    html.dark-mode .step-label { color: #adb5bd; }
    html.dark-mode .step-item.active .step-label { color: var(--ob-blue); }
    html.dark-mode .step-item.done .step-label { color: #f1f1f1; }
    html.dark-mode .wizard-stepper { border-color: #454d55; }
    html.dark-mode .wizard-stepper .step-item:not(:last-child)::after { background: #454d55; }

    html.dark-mode .info-box-blue { background-color: #1a2a3f; border-color: #2a4060; color: #93c5fd; }

    html.dark-mode .icheck-primary label,
    html.dark-mode .icheck-bootstrap label { color: #dee2e6; }

    html.dark-mode .breadcrumb-custom { background-color: #2b3035; border-color: #454d55; }

    html.dark-mode .filter-dropdown-menu { background-color: #343a40; border-color: #454d55; }
    html.dark-mode .filter-dropdown-menu label { color: #dee2e6; }

    html.dark-mode .modal-content { background-color: #343a40; border-color: #454d55; }
    html.dark-mode .modal-header { border-color: #454d55; }
    html.dark-mode .modal-footer { border-color: #454d55; background-color: #343a40; }
    html.dark-mode .modal-body label { color: #dee2e6; }
    html.dark-mode .modal-title { color: #f1f1f1; }

    html.dark-mode .swal2-popup { background-color: #343a40; color: #dee2e6; }
    html.dark-mode .swal2-title { color: #f1f1f1; }
    html.dark-mode .swal2-html-container { color: #dee2e6; }
    html.dark-mode .swal2-styled { color: #f1f1f1; }
    html.dark-mode .swal2-styled:focus { box-shadow: none; }
</style>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper" style="padding: 1.5rem 2rem;">

    <div id="view_main">
        <div class="breadcrumb-custom">
            Master Data &nbsp;&gt;&nbsp; Master Item &nbsp;&gt;&nbsp; <strong>Obat</strong>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
            <div class="d-flex align-items-center">
                <button class="btn btn-sm btn-light border mr-3 btn-sm-light" style="border-radius: .4rem; height:34px; width:34px;">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <div>
                    <h1 class="page-title">Master Obat</h1>
                    <div class="page-subtitle">Kelola data obat yang digunakan di klinik</div>
                </div>
            </div>
            <div class="d-flex gap-2" style="gap:.5rem; flex-wrap:wrap;">
                <button class="btn-ob-outline" id="btn_export"><i class="fas fa-file-export mr-1"></i> Export</button>
                <button class="btn-ob-primary" id="btn_tambah_obat"><i class="fas fa-plus mr-1"></i> Tambah Obat</button>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-9">
                <div class="ob-card">
                    <div class="row align-items-end">
                        <div class="col-md-4">
                            <label class="field-label">Cari Obat</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="f_cari" placeholder="Cari kode obat, nama obat, generic...">
                                <div class="input-group-append"><span class="input-group-text"><i class="fas fa-search"></i></span></div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="field-label">Batch Tracked</label>
                            <select class="form-control" id="f_batch">
                                <option value="">Semua</option>
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="field-label">Expired Tracked</label>
                            <select class="form-control" id="f_expired">
                                <option value="">Semua</option>
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="field-label">&nbsp;</label>
                            <button class="btn-reset" id="btn_reset"><i class="fas fa-sync-alt mr-1"></i> Reset Filter</button>
                        </div>
                    </div>
                    <div class="row mt-3 align-items-end">
                        <div class="col-md-2">
                            <label class="field-label">Kategori</label>
                            <select class="form-control" id="f_kategori">
                                <option value="">Semua</option>
                                <option value="Obat">Obat</option>
                                <option value="Alkes">Alkes</option>
                                <option value="BMHP">BMHP</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="field-label">Group</label>
                            <select class="form-control" id="f_group">
                                <option value="">Semua</option>
                                <option value="Antibiotik">Antibiotik</option>
                                <option value="Analgesik">Analgesik</option>
                                <option value="Antipiretik">Antipiretik</option>
                                <option value="Antihistamin">Antihistamin</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="field-label">Bentuk Sediaan</label>
                            <select class="form-control" id="f_bentuk">
                                <option value="">Semua</option>
                                <option value="Tablet">Tablet</option>
                                <option value="Capsule">Capsule</option>
                                <option value="Sirup">Sirup</option>
                                <option value="Injeksi">Injeksi</option>
                                <option value="Salep">Salep</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="field-label">Resep</label>
                            <select class="form-control" id="f_resep">
                                <option value="">Semua</option>
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="field-label">Status</label>
                            <select class="form-control" id="f_status">
                                <option value="">Semua</option>
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Non Aktif</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="field-label">&nbsp;</label>
                            <div class="filter-dropdown">
                                <button class="btn-ob-outline w-100" id="btn_filter_lainnya"><i class="fas fa-filter mr-1"></i> Filter Lainnya ▼</button>
                                <div class="filter-dropdown-menu" id="filterDropdownMenu">
                                    <div class="row">
                                        <div class="col-12 mb-2">
                                            <label class="field-label">Batch Tracked</label>
                                            <select class="form-control form-control-sm" id="f_batch_dropdown">
                                                <option value="">Semua</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="col-12 mb-2">
                                            <label class="field-label">Expired Tracked</label>
                                            <select class="form-control form-control-sm" id="f_expired_dropdown">
                                                <option value="">Semua</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="col-12 mb-2">
                                            <label class="field-label">Resep</label>
                                            <select class="form-control form-control-sm" id="f_resep_dropdown">
                                                <option value="">Semua</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn-ob-primary btn-sm w-100" id="btn_apply_filter"><i class="fas fa-check mr-1"></i> Terapkan Filter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ob-card" style="padding: 1.5rem;">
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                        <div>
                            <h6 style="font-weight:700; font-size:1rem; margin-bottom:2px; color:var(--ob-text);">Daftar Obat</h6>
                            <div style="font-size:.8rem; color:var(--ob-muted);" id="table_info_text"></div>
                        </div>
                        <div class="d-flex align-items-center" style="gap:.5rem; flex-wrap:wrap;">
                            <select class="form-control form-control-sm mr-2" id="f_per_page" style="width:70px; display:inline-block; background:var(--ob-card-bg); color:var(--ob-text); border-color:var(--ob-border);">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <span style="font-size:.85rem; color:var(--ob-muted);">per halaman</span>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="obatTable" class="table" style="width:100%; margin:0;">
                            <thead>
                                <tr>
                                    <th style="width: 30px; text-align: center;"><div class="icheck-primary d-inline"><input type="checkbox" id="chk_all"><label for="chk_all"></label></div></th>
                                    <th>Kode Obat <i class="fas fa-arrows-alt-v text-muted ml-1" style="font-size:.7rem;"></i></th>
                                    <th>Nama Obat <i class="fas fa-arrows-alt-v text-muted ml-1" style="font-size:.7rem;"></i></th>
                                    <th>Generic Name</th>
                                    <th>Bentuk Sediaan</th>
                                    <th>Strength</th>
                                    <th style="text-align:center;">Resep</th>
                                    <th style="text-align:center;">Stok</th>
                                    <th style="text-align:center;">Exp ≤ 90 Hari</th>
                                    <th style="text-align:center;">Status</th>
                                    <th style="text-align:center; width:120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div style="font-weight:700; font-size:.95rem; margin-bottom:1rem; color:var(--ob-text);">Ringkasan Data</div>
                
                <div class="summary-card">
                    <i class="fas fa-capsules icon-blue"></i>
                    <div>
                        <div class="summary-lbl">Total Obat</div>
                        <div class="summary-val" id="ob_sum_total">-</div>
                        <div class="summary-sub">Semua data obat</div>
                    </div>
                </div>
                <div class="summary-card">
                    <i class="fas fa-check-circle icon-green"></i>
                    <div>
                        <div class="summary-lbl">Obat Aktif</div>
                        <div class="summary-val" id="ob_sum_aktif">-</div>
                        <div class="summary-sub" id="ob_sum_aktif_sub">dari total</div>
                    </div>
                </div>
                <div class="summary-card">
                    <i class="fas fa-tag icon-purple"></i>
                    <div>
                        <div class="summary-lbl">Batch Tracked</div>
                        <div class="summary-val" id="ob_sum_batch">-</div>
                        <div class="summary-sub">Item dengan batch</div>
                    </div>
                </div>
                <div class="summary-card">
                    <i class="fas fa-clock icon-yellow"></i>
                    <div>
                        <div class="summary-lbl">Expired ≤ 90 Hari</div>
                        <div class="summary-val" id="ob_sum_expired">-</div>
                        <div class="summary-sub">Perlu perhatian</div>
                    </div>
                </div>
                <div class="summary-card">
                    <i class="fas fa-times-circle icon-red"></i>
                    <div>
                        <div class="summary-lbl">Stok Habis</div>
                        <div class="summary-val" id="ob_sum_stok">-</div>
                        <div class="summary-sub">Segera diisi ulang</div>
                    </div>
                </div>

                <div class="tips-box mt-3">
                    <div style="font-weight:700; margin-bottom:.5rem;"><i class="far fa-lightbulb text-warning mr-1"></i> Tips</div>
                    <ul style="font-size:.75rem; color:var(--ob-text);">
                        <li>Gunakan pencarian untuk menemukan obat dengan cepat.</li>
                        <li>Perhatikan obat yang mendekati expired.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div id="view_form" style="display:none;">
        <div class="breadcrumb-custom">
            Master Data &nbsp;&gt;&nbsp; Master Item &nbsp;&gt;&nbsp; Obat &nbsp;&gt;&nbsp; <strong>Tambah Obat</strong>
        </div>

        <div class="wizard-header">
            <div class="d-flex align-items-center">
                <button class="btn btn-sm btn-light border mr-3 btn-batal-obat btn-sm-light" style="border-radius: .4rem; height:34px; width:34px;">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <div>
                    <h1 class="page-title">Tambah Obat</h1>
                    <div class="page-subtitle">Lengkap informasi obat dengan benar</div>
                </div>
            </div>
            <div class="d-flex gap-2" style="gap: .5rem; flex-wrap:wrap;">
                <button class="btn-ob-outline btn-batal-obat"><i class="fas fa-times mr-1"></i> Batal</button>
                <button class="btn-ob-primary" id="btn_wizard_next">Simpan &amp; Lanjut <i class="fas fa-arrow-right ml-1"></i></button>
                <button class="btn-ob-primary" id="btn_wizard_save" style="display:none;"><i class="fas fa-save mr-1"></i> Simpan Obat</button>
            </div>
        </div>

        <div class="wizard-stepper">
            <div class="step-item active" data-step="1"><div class="step-circle">1</div> General</div>
            <div class="step-item" data-step="2"><div class="step-circle">2</div> Drug Detail</div>
            <div class="step-item" data-step="3"><div class="step-circle">3</div> UOM Conversion</div>
            <div class="step-item" data-step="4"><div class="step-circle">4</div> Harga</div>
            <div class="step-item" data-step="5"><div class="step-circle">5</div> Supplier</div>
            <div class="step-item" data-step="6"><div class="step-circle">6</div> Stock &amp; Batch</div>
            <div class="step-item" data-step="7" style="display:none;"><div class="step-circle">7</div> Dokumen</div>
        </div>

        <div class="row">
            <div class="col-lg-8" id="step_content_col">
                <div id="step_1" class="tab-pane active ob-card">
                    <h5 style="font-weight:700; font-size:1.1rem; margin-bottom:1.5rem; color:var(--ob-text);">Informasi Umum</h5>
                    <form id="form_general">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="field-label">Kode Obat</label>
                                <input type="text" class="form-control" id="inp_kode" placeholder="Otomatis dibuat oleh sistem" disabled>
                                <div style="font-size:.75rem; color:var(--ob-muted);">Kode akan dibuat otomatis oleh sistem setelah data disimpan.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="field-label">Nama Obat <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="inp_nama" placeholder="Contoh: Amoxicillin 500 mg Capsule">
                            </div>
                            <div class="col-md-4 mb-3" style="display:none;">
                                <label class="field-label">Kategori Item</label>
                                <select class="form-control" id="inp_kategori_id"><option value="">Pilih kategori</option></select>
                            </div>
                            <div class="col-md-4 mb-3" style="display:none;">
                                <label class="field-label">Group Item</label>
                                <select class="form-control" id="inp_group_id"><option value="">Pilih group</option></select>
                            </div>
                            <div class="col-md-4 mb-3" style="display:none;">
                                <label class="field-label">Sub Group Item</label>
                                <select class="form-control" id="inp_sub_group_id"><option value="">Pilih sub group (opsional)</option></select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="field-label">Satuan Dasar (Base UOM) <span class="text-danger">*</span></label>
                                <select class="form-control" id="inp_base_uom_id"><option value="">Pilih satuan dasar</option></select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="field-label">Barcode (Opsional)</label>
                                <input type="text" class="form-control" id="inp_barcode" placeholder="Masukkan barcode">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="field-label">Aturan Pakai Default</label>
                                <input type="text" class="form-control" id="inp_aturan" placeholder="Contoh: 3x sehari 1 kapsul sesudah makan">
                            </div>
                        </div>

                        <h6 style="font-weight:700; font-size:1rem; margin:1.5rem 0 1rem; color:var(--ob-text);">Pengaturan Item</h6>
                        <div class="row">
                            <div class="col-md-3 mb-2">
                                <label class="ob-switch">
                                    <input type="checkbox" id="chk_stock" checked>
                                    <span class="slider"></span>
                                </label>
                                <span class="ob-switch-label">Stock Item</span>
                                <div style="font-size:.7rem; color:var(--ob-muted);">Item ini dikelola stoknya</div>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="ob-switch">
                                    <input type="checkbox" id="chk_purchase" checked>
                                    <span class="slider"></span>
                                </label>
                                <span class="ob-switch-label">Purchase Item</span>
                                <div style="font-size:.7rem; color:var(--ob-muted);">Item ini dapat dibeli</div>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="ob-switch">
                                    <input type="checkbox" id="chk_batch" checked>
                                    <span class="slider"></span>
                                </label>
                                <span class="ob-switch-label">Batch Tracked</span>
                                <div style="font-size:.7rem; color:var(--ob-muted);">Kelola berdasarkan nomor batch</div>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="ob-switch">
                                    <input type="checkbox" id="chk_sale" checked>
                                    <span class="slider"></span>
                                </label>
                                <span class="ob-switch-label">Sale Item</span>
                                <div style="font-size:.7rem; color:var(--ob-muted);">Item ini dapat dijual</div>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="ob-switch">
                                    <input type="checkbox" id="chk_returnable">
                                    <span class="slider"></span>
                                </label>
                                <span class="ob-switch-label">Returnable Item</span>
                                <div style="font-size:.7rem; color:var(--ob-muted);">Item dapat dikembalikan ke supplier</div>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="ob-switch">
                                    <input type="checkbox" id="chk_expired" checked>
                                    <span class="slider"></span>
                                </label>
                                <span class="ob-switch-label">Expired Tracked</span>
                                <div style="font-size:.7rem; color:var(--ob-muted);">Kelola berdasarkan tanggal expired</div>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="ob-switch">
                                    <input type="checkbox" id="chk_resep" checked>
                                    <span class="slider"></span>
                                </label>
                                <span class="ob-switch-label">Prescription Required</span>
                                <div style="font-size:.7rem; color:var(--ob-muted);">Memerlukan resep dokter</div>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="ob-switch">
                                    <input type="checkbox" id="chk_controlled">
                                    <span class="slider"></span>
                                </label>
                                <span class="ob-switch-label">Controlled Item</span>
                                <div style="font-size:.7rem; color:var(--ob-muted);">Item dengan pengawasan khusus</div>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="ob-switch">
                                    <input type="checkbox" id="chk_active" checked>
                                    <span class="slider"></span>
                                </label>
                                <span class="ob-switch-label">Is Active</span>
                                <div style="font-size:.7rem; color:var(--ob-muted);">Item aktif digunakan</div>
                            </div>
                        </div>
                        
                        <h6 style="font-weight:700; font-size:1rem; margin:1.5rem 0 1rem; color:var(--ob-text);">Foto / Gambar (Opsional)</h6>
                        <div class="drop-zone" id="drop_zone">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <div>Klik atau drag file ke sini untuk upload</div>
                            <div style="font-size:.75rem; color:var(--ob-muted);">PNG, JPG, JPEG (Maks. 2MB)</div>
                            <input type="file" style="display:none;" id="file_input" accept="image/*">
                        </div>
                        <div id="image_preview_wrap" style="margin-top:.8rem;"></div>

                        <div class="info-box-blue mt-3">
                            <i class="fas fa-info-circle mt-1"></i>
                            <div>
                                <strong>Informasi</strong>
                                <ul style="padding-left:1.2rem; margin-bottom:0; margin-top:.3rem; font-size:.85rem;">
                                    <li>Field bertanda (*) wajib diisi.</li>
                                    <li>Data obat akan digunakan di seluruh modul klinik.</li>
                                </ul>
                            </div>
                        </div>

                        <div class="mt-4 pt-3" style="border-top:1px solid var(--ob-border); display:flex; justify-content:flex-end; align-items:center;">
                            <button class="btn-ob-primary" id="btn_next_1">Lanjut: Drug Detail <i class="fas fa-arrow-right ml-1"></i></button>
                        </div>
                    </form>
                </div>

                <div id="step_2" class="tab-pane ob-card">
                    <h5 style="font-weight:700; font-size:1.1rem; margin-bottom:1.5rem; color:var(--ob-text);">Informasi Farmasi Obat</h5>
                    <form id="form_drug_detail">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="field-label">Brand Name</label>
                                <input type="text" class="form-control" id="dd_brand" name="dd_brand" value="Amoxil" placeholder="Nama dagang / merek">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="field-label">Strength <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="dd_strength" name="dd_strength" value="500 mg" placeholder="Kekuatan / dosis">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="field-label">Dosage Form <span class="text-danger">*</span></label>
                                <?= view('components/dropdown2', [
                                    'id'      => 'dd_dosage',
                                    'name'      => 'dd_dosage',
                                    'apiUrl'    => base_url('/dropdown/server5/1/1/dosage-forms/null/action/getall/null/null'),
                                    'placeholder' => 'Pilih Dosage Form',
                                    'extraKeys' => [],
                                    'selected'  => '',
                                    'errors'    => $errors ?? []
                                ]) ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="field-label">Therapeutic Class (Kelas Terapi)</label>
                                <?= view('components/dropdown2', [
                                    'id'      => 'dd_therapeutic',
                                    'name'      => 'dd_therapeutic',
                                    'apiUrl'    => base_url('/dropdown/server5/1/1/tfield-value/null/fieldName/therapeutic_class/null/null'),
                                    'placeholder' => 'Pilih Therapeutic Class',
                                    'extraKeys' => [],
                                    'selected'  => '',
                                    'errors'    => $errors ?? []
                                ]) ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="field-label">ATC Code</label>
                                <input type="text" class="form-control" id="dd_atc" name="dd_atc" value="J01CA04">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="field-label">Kode KFA</label>
                                <input type="text" class="form-control" id="dd_kfa" name="dd_kfa" placeholder="Kode Farmasi Alkes (untuk SATUSEHAT)">
                            </div>
                        </div>

                        <h6 style="font-weight:700; font-size:1rem; margin:1.5rem 0 1rem; color:var(--ob-text);">Formularium</h6>
                        <div class="row formularium-box" style="border-radius:.6rem; padding:1rem .5rem; margin-left:0; margin-right:0; margin-bottom:1rem;">
                            <div class="col-md-6 mb-3">
                                <label class="field-label">Route (Cara Pemberian)</label>
                                <?= view('components/dropdown2', [
                                    'id'      => 'dd_route',
                                    'name'      => 'dd_route',
                                    'apiUrl'    => base_url('/dropdown/server5/1/1/tfield-value/null/fieldName/Route/null/null'),
                                    'placeholder' => 'Pilih Route',
                                    'extraKeys' => [],
                                    'selected'  => '',
                                    'errors'    => $errors ?? []
                                ]) ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="field-label">Drug Class (Golongan Obat)</label>
                                <?= view('components/dropdown2', [
                                    'id'      => 'dd_drug_class',
                                    'name'      => 'dd_drug_class',
                                    'apiUrl'    => base_url('/dropdown/server5/1/1/tfield-value/null/fieldName/drug_class/null/null'),
                                    'placeholder' => 'Pilih Drug Class',
                                    'extraKeys' => [],
                                    'selected'  => '',
                                    'errors'    => $errors ?? []
                                ]) ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="field-label">Drug Sub Class (Golongan Obat)</label>
                                <?= view('components/dropdown2', [
                                    'id'      => 'dd_drug_subclass',
                                    'name'      => 'dd_drug_subclass',
                                    'apiUrl'    => base_url('/dropdown/server5/1/1/tfield-value/null/fieldName/drug_subclass/null/null'),
                                    'placeholder' => 'Pilih Drug Sub Class',
                                    'extraKeys' => [],
                                    'selected'  => '',
                                    'errors'    => $errors ?? []
                                ]) ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="field-label">Generic Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="dd_generic" name="dd_generic" value="Amoxicillin">
                            </div>
                        </div>

                        <h6 style="font-weight:700; font-size:1rem; margin:1.5rem 0 1rem; color:var(--ob-text);">Composition (Komposisi)</h6>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="field-label">Komposisi</label>
                                <textarea class="form-control" rows="2" name="dd_composition" id="dd_composition" placeholder="Tiap kapsul mengandung: ...">Tiap kapsul mengandung: Amoxicillin Trihydrate setara dengan Amoxicillin 500 mg</textarea>
                            </div>
                        </div>

                        <h6 style="font-weight:700; font-size:1rem; margin:1.5rem 0 1rem; color:var(--ob-text);">Informasi Klinis</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="field-label">Indication (Indikasi)</label>
                                <textarea class="form-control" rows="3" name="dd_indication" id="dd_indication">Infeksi saluran pernapasan, infeksi kulit dan jaringan lunak, infeksi saluran kemia, infeksi telinga, dan infeksi gigi.</textarea>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="field-label">Contra Indication (Kontra Indikasi)</label>
                                <textarea class="form-control" rows="3" name="dd_contra" id="dd_contra">Pasien yang hipersensitif terhadap amoxicillin atau antibiotik golongan beta-laktam lainnya.</textarea>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="field-label">Side Effect (Efek Samping)</label>
                                <textarea class="form-control" rows="3" name="dd_side" id="dd_side">Mual, muntah, diare, ruam kulit, reaksi alergi.</textarea>
                            </div>
                        </div>

                        <h6 style="font-weight:700; font-size:1rem; margin:1.5rem 0 1rem; color:var(--ob-text);">Regulasi &amp; Penyimpanan</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="field-label">Drug Regulation Class</label>
                                <?= view('components/dropdown2', [
                                    'id'      => 'dd_regulation',
                                    'name'      => 'dd_regulation',
                                    'apiUrl'    => base_url('/dropdown/server5/1/1/tfield-value/null/fieldName/drug_regulation_class/null/null'),
                                    'placeholder' => 'Pilih Drug Regulation Class',
                                    'extraKeys' => [],
                                    'selected'  => '',
                                    'errors'    => $errors ?? []
                                ]) ?>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="field-label">Storage Instruction (Cara Penyimpanan)</label>
                                <input type="text" class="form-control" id="dd_storage" name="dd_storage" value="Simpan pada suhu ruang (15-30°C), terlindung dari cahaya, dan kering.">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="field-label">Shelf Life (Umur Simpan)</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="dd_shelf" value="24">
                                    <div class="input-group-append"><span class="input-group-text">Bulan</span></div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="field-label">Special Instruction (Instruksi Khusus)</label>
                                <input type="text" class="form-control" id="dd_special" value="Habiskan sesuai anjuran dokter.">
                            </div>
                        </div>

                        <h6 style="font-weight:700; font-size:1rem; margin:1.5rem 0 1rem; color:var(--ob-text);">Registrasi</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="field-label">Registration No. (No. Registrasi)</label>
                                <input type="text" class="form-control" id="dd_reg_no" name="dd_reg_no" value="GKL1234567890A1">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="field-label">Registration Date (Tgl. Registrasi)</label>
                                <input type="date" class="form-control" id="dd_reg_date">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="field-label">Expired Date (Tgl. Kedaluwarsa Registrasi)</label>
                                <input type="date" class="form-control" id="dd_reg_exp">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="field-label">Manufacturer (Pabrik / Produsen)</label>
                                <input type="text" class="form-control" id="dd_manufacturer" placeholder="Masukkan nama pabrik / produsen (opsional)">  
                            </div>
                        </div>

                        <div class="info-box-blue mt-3">
                            <i class="fas fa-info-circle mt-1"></i>
                            <div>
                                <strong>Informasi</strong>
                                <ul style="padding-left:1.2rem; margin-bottom:0; margin-top:.3rem; font-size:.85rem;">
                                    <li>Field bertanda (*) wajib diisi.</li>
                                    <li>Data farmasi penting untuk keperluan regulasi dan pelayanan.</li>
                                </ul>
                            </div>
                        </div>

                        <div class="mt-4 pt-3" style="border-top:1px solid var(--ob-border); display:flex; justify-content:space-between; align-items:center;">
                            <button class="btn-ob-outline" id="btn_prev_2"><i class="fas fa-arrow-left mr-1"></i> Sebelumnya</button>
                            <button class="btn-ob-primary" id="btn_next_2">Lanjut: UOM Conversion <i class="fas fa-arrow-right ml-1"></i></button>
                        </div>
                    </form>
                </div>

                <div id="step_3" class="tab-pane ob-card">
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                        <div>
                            <h5 style="font-weight:700; font-size:1.1rem; margin-bottom:4px; color:var(--ob-text);">UOM Conversion (Konversi Satuan)</h5>
                            <div style="font-size:.85rem; color:var(--ob-muted);">Kelola satuan lainnya dan faktor konversi terhadap satuan dasar (Base UOM)</div>
                        </div>
                        <button class="btn-ob-outline" id="btn_tambah_uom"><i class="fas fa-plus text-primary mr-1"></i> Tambah Satuan</button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="uomTable" style="border-color:var(--ob-border);">
                            <thead>
                                <tr>
                                    <th style="width:50px;">No</th>
                                    <th>Satuan (UOM)</th>
                                    <th>Deskripsi</th>
                                    <th style="text-align:right;">Faktor Konversi ke Base UOM</th>
                                    <th>Isi per Satuan</th>
                                    <th style="text-align:center;">Purchase</th>
                                    <th style="text-align:center;">Sales</th>
                                    <th style="text-align:center;">Status</th>
                                    <th style="text-align:center; width:80px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="uomBody">
                            </tbody>
                        </table>
                        <div style="font-size:.85rem; color:var(--ob-muted); margin-top:.5rem;">
                            Total <span id="uomCount">0</span> data
                        </div>
                    </div>

                    <div class="tips-box mt-3">
                        <div style="font-weight:700; margin-bottom:.5rem;"><i class="far fa-lightbulb text-warning mr-1"></i> Catatan Konversi</div>
                        <ul style="font-size:.8rem; color:var(--ob-text); margin-bottom:0;">
                            <li>Faktor konversi harus berupa angka lebih besar dari 0.</li>
                            <li>Satuan dengan level lebih tinggi memiliki faktor konversi lebih besar.</li>
                            <li>Base UOM selalu memiliki faktor konversi = 1.</li>
                            <li>UOM dengan status non-aktif tidak akan digunakan di transaksi.</li>
                        </ul>
                    </div>

                    <div class="mt-4 pt-3" style="border-top:1px solid var(--ob-border); display:flex; justify-content:space-between; align-items:center;">
                        <button class="btn-ob-outline" id="btn_prev_3"><i class="fas fa-arrow-left mr-1"></i> Sebelumnya</button>
                        <button class="btn-ob-primary" id="btn_next_3">Lanjut: Harga <i class="fas fa-arrow-right ml-1"></i></button>
                    </div>
                </div>

                <div id="step_4" class="tab-pane ob-card" style="width:100%;">
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                        <div>
                            <h5 style="font-weight:700; font-size:1.1rem; margin-bottom:4px; color:var(--ob-text);">Informasi Harga</h5>
                            <div style="font-size:.85rem; color:var(--ob-muted);">Kelola harga jual obat berdasarkan price class yang berlaku di klinik.</div>
                        </div>
                        <button class="btn-ob-outline" id="btn_tambah_harga"><i class="fas fa-plus text-primary mr-1"></i> Tambah Harga</button>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 col-6">
                            <div style="background:var(--ob-bg-soft); padding:.8rem; border-radius:.5rem; text-align:center; border:1px solid var(--ob-border);">
                                <div style="font-size:.7rem; color:var(--ob-muted);">Total Price Class Aktif</div>
                                <div style="font-size:1.2rem; font-weight:700; color:var(--ob-blue);" id="hg_total_class">0</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div style="background:var(--ob-bg-soft); padding:.8rem; border-radius:.5rem; text-align:center; border:1px solid var(--ob-border);">
                                <div style="font-size:.7rem; color:var(--ob-muted);">Harga Jual Terendah</div>
                                <div style="font-size:1.1rem; font-weight:700; color:#198754;" id="hg_harga_terendah">Rp 0</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div style="background:var(--ob-bg-soft); padding:.8rem; border-radius:.5rem; text-align:center; border:1px solid var(--ob-border);">
                                <div style="font-size:.7rem; color:var(--ob-muted);">Harga Jual Tertinggi</div>
                                <div style="font-size:1.1rem; font-weight:700; color:#dc3545;" id="hg_harga_tertinggi">Rp 0</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div style="background:var(--ob-bg-soft); padding:.8rem; border-radius:.5rem; text-align:center; border:1px solid var(--ob-border);">
                                <div style="font-size:.7rem; color:var(--ob-muted);">Rata-rata Margin</div>
                                <div style="font-size:1.2rem; font-weight:700; color:var(--ob-purple);" id="hg_rata_margin">0%</div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="hargaTable" style="border-color:var(--ob-border);">
                            <thead>
                                <tr>
                                    <th style="width:50px;">No</th>
                                    <th>Price Class</th>
                                    <th>Deskripsi</th>
                                    <th>Mata Uang</th>
                                    <th style="text-align:right;">Harga Jual</th>
                                    <th style="text-align:right;">HPP / Unit</th>
                                    <th style="text-align:right;">Margin (%)</th>
                                    <th style="text-align:center;">Status</th>
                                    <th style="text-align:center; width:80px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="hargaBody">
                            </tbody>
                        </table>
                        <div style="font-size:.85rem; color:var(--ob-muted); margin-top:.5rem;">
                            Menampilkan 1 sampai 5 dari 5 data
                        </div>
                    </div>

                    <div style="background:var(--ob-bg-soft); border-radius:.5rem; padding:1rem; border:1px solid var(--ob-border); margin-top:1.5rem;">
                        <h6 style="font-weight:700; font-size:.95rem; margin-bottom:1rem; color:var(--ob-text);">Pengaturan Harga Tambahan</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div style="display:flex; align-items:center; gap:.5rem; margin-bottom:.3rem;">
                                    <label class="ob-switch">
                                        <input type="checkbox" id="chk_bulatkan" checked>
                                        <span class="slider"></span>
                                    </label>
                                    <span class="ob-switch-label" style="font-size:.8rem;">Gunakan pembulatan harga jual</span>
                                </div>
                                <div style="font-size:.75rem; color:var(--ob-muted);">Harga akan dibulatkan ke kelipatan</div>
                                <div class="input-group mt-1" style="width:120px;">
                                    <input type="number" class="form-control" id="inp_kelipatan" value="50" style="font-size:.8rem;">
                                    <div class="input-group-append"><span class="input-group-text" style="font-size:.75rem;">Rupiah</span></div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div style="display:flex; align-items:center; gap:.5rem; margin-bottom:.3rem;">
                                    <label class="ob-switch">
                                        <input type="checkbox" id="chk_margin_default">
                                        <span class="slider"></span>
                                    </label>
                                    <span class="ob-switch-label" style="font-size:.8rem;">Terapkan margin default</span>
                                </div>
                                <div style="font-size:.75rem; color:var(--ob-muted);">Margin (%)</div>
                                <div class="input-group mt-1" style="width:120px;">
                                    <input type="number" class="form-control" id="inp_margin" value="20" style="font-size:.8rem;">
                                    <div class="input-group-append"><span class="input-group-text" style="font-size:.75rem;">%</span></div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div style="display:flex; align-items:center; gap:.5rem; margin-bottom:.3rem;">
                                    <label class="ob-switch">
                                        <input type="checkbox" id="chk_promo">
                                        <span class="slider"></span>
                                    </label>
                                    <span class="ob-switch-label" style="font-size:.8rem;">Aktifkan harga promo</span>
                                </div>
                                <div style="font-size:.7rem; color:var(--ob-muted);">Harga Promo (Rp)</div>
                                <input type="text" class="form-control text-right" id="inp_promo_harga" placeholder="0" style="font-size:.75rem;">
                                <div class="row mt-1">
                                    <div class="col-6">
                                        <div style="font-size:.7rem; color:var(--ob-muted);">Tanggal mulai</div>
                                        <input type="date" class="form-control" id="inp_promo_mulai" value="2024-06-01" style="font-size:.75rem;">
                                    </div>
                                    <div class="col-6">
                                        <div style="font-size:.7rem; color:var(--ob-muted);">Tanggal selesai</div>
                                        <input type="date" class="form-control" id="inp_promo_selesai" value="2024-06-30" style="font-size:.75rem;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="info-box-blue mt-3">
                        <i class="fas fa-info-circle mt-1"></i>
                        <div>
                            <strong>Catatan</strong>
                            <div style="font-size:.85rem;">Harga jual akan mengikuti satuan dasar (Base UOM) yaitu CAPS. Harga untuk satuan lainnya akan dihitung otomatis berdasarkan konversi UOM.</div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3" style="border-top:1px solid var(--ob-border); display:flex; justify-content:space-between; align-items:center;">
                        <button class="btn-ob-outline" id="btn_prev_4"><i class="fas fa-arrow-left mr-1"></i> Sebelumnya</button>
                        <button class="btn-ob-primary" id="btn_next_4">Lanjut: Supplier <i class="fas fa-arrow-right ml-1"></i></button>
                    </div>
                </div>

                <div id="step_5" class="tab-pane ob-card" style="width:100%;">
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                        <div>
                            <h5 style="font-weight:700; font-size:1.1rem; margin-bottom:4px; color:var(--ob-text);">Informasi Supplier</h5>
                            <div style="font-size:.85rem; color:var(--ob-muted);">Kelola supplier yang dapat memasok obat ini.</div>
                        </div>
                        <button class="btn-ob-outline" id="btn_tambah_supplier"><i class="fas fa-plus text-primary mr-1"></i> Tambah Supplier</button>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 col-6">
                            <div style="background:var(--ob-bg-soft); padding:.8rem; border-radius:.5rem; text-align:center; border:1px solid var(--ob-border);">
                                <div style="font-size:.7rem; color:var(--ob-muted);">Total Supplier</div>
                                <div style="font-size:1.2rem; font-weight:700; color:var(--ob-blue);" id="sp_total">0</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div style="background:var(--ob-bg-soft); padding:.8rem; border-radius:.5rem; text-align:center; border:1px solid var(--ob-border);">
                                <div style="font-size:.7rem; color:var(--ob-muted);">Supplier Utama</div>
                                <div style="font-size:.9rem; font-weight:700; color:var(--ob-text);" id="sp_utama">-</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div style="background:var(--ob-bg-soft); padding:.8rem; border-radius:.5rem; text-align:center; border:1px solid var(--ob-border);">
                                <div style="font-size:.7rem; color:var(--ob-muted);">Lead Time Rata-rata</div>
                                <div style="font-size:1.2rem; font-weight:700; color:#ffc107;">2 - 5</div>
                                <div style="font-size:.65rem; color:var(--ob-muted);">hari</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div style="background:var(--ob-bg-soft); padding:.8rem; border-radius:.5rem; text-align:center; border:1px solid var(--ob-border);">
                                <div style="font-size:.7rem; color:var(--ob-muted);">Harga Beli Terendah</div>
                                <div style="font-size:1.1rem; font-weight:700; color:#198754;" id="sp_hargaterendah">-</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div style="background:var(--ob-bg-soft); padding:.8rem; border-radius:.5rem; text-align:center; border:1px solid var(--ob-border);">
                                <div style="font-size:.7rem; color:var(--ob-muted);">Total Harga Beli</div>
                                <div style="font-size:1.1rem; font-weight:700; color:#198754;">Rp 3.450</div>
                                <div style="font-size:.65rem; color:var(--ob-muted);">(terendah)</div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="supplierTable" style="border-color:var(--ob-border);">
                            <thead>
                                <tr>
                                    <th style="width:50px;">No</th>
                                    <th>Supplier</th>
                                    <th>Principal</th>
                                    <th>Mata Uang</th>
                                    <th style="text-align:right;">Harga Beli Terakhir</th>
                                    <th style="text-align:center;">Lead Time (Hari)</th>
                                    <th style="text-align:center;">Minimal Order</th>
                                    <th style="text-align:center;">Utama</th>
                                    <th style="text-align:center;">Status</th>
                                    <th style="text-align:center; width:80px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="supplierBody">
                            </tbody>
                        </table>
                        <div style="font-size:.85rem; color:var(--ob-muted); margin-top:.5rem;">
                            Menampilkan 1 sampai 3 dari 3 data
                        </div>
                    </div>

                    <div style="background:var(--ob-bg-soft); border-radius:.5rem; padding:1rem; border:1px solid var(--ob-border); margin-top:1.5rem;">
                        <h6 style="font-weight:700; font-size:.95rem; margin-bottom:1rem; color:var(--ob-text);">Informasi Tambahan Supplier Utama (Default)</h6>
                        <div class="row">
                            <div class="col-md-3 mb-2">
                                <div style="font-size:.7rem; color:var(--ob-muted);">Nama Supplier</div>
                                <div style="font-weight:600; color:var(--ob-text);">PT. Medika Farma</div>
                            </div>
                            <div class="col-md-3 mb-2">
                                <div style="font-size:.7rem; color:var(--ob-muted);">Email</div>
                                <div style="font-weight:600; color:var(--ob-text);">info@medikafarma.co.id</div>
                            </div>
                            <div class="col-md-3 mb-2">
                                <div style="font-size:.7rem; color:var(--ob-muted);">Kontak Person</div>
                                <div style="font-weight:600; color:var(--ob-text);">Budi Santoso</div>
                            </div>
                            <div class="col-md-3 mb-2">
                                <div style="font-size:.7rem; color:var(--ob-muted);">Telepon</div>
                                <div style="font-weight:600; color:var(--ob-text);">(021) 8990 1234</div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <div style="font-size:.7rem; color:var(--ob-muted);">Alamat</div>
                                <div style="font-weight:600; color:var(--ob-text);">Jl. Industri Raya No. 15, Cikarang, Bekasi 17530</div>
                            </div>
                            <div class="col-md-12">
                                <div style="font-size:.7rem; color:var(--ob-muted);">Catatan</div>
                                <div style="font-weight:600; color:var(--ob-text);">Supplier utama untuk obat generik antibiotik.</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3" style="border-top:1px solid var(--ob-border); display:flex; justify-content:space-between; align-items:center;">
                        <button class="btn-ob-outline" id="btn_prev_5"><i class="fas fa-arrow-left mr-1"></i> Sebelumnya</button>
                        <button class="btn-ob-primary" id="btn_next_5">Lanjut: Stock &amp; Batch <i class="fas fa-arrow-right ml-1"></i></button>
                    </div>
                </div>

                <div id="step_6" class="tab-pane ob-card">
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                        <div>
                            <h5 style="font-weight:700; font-size:1.1rem; margin-bottom:4px; color:var(--ob-text);">Informasi Stok</h5>
                            <div style="font-size:.85rem; color:var(--ob-muted);">Kelola stok dan batch/expired obat di setiap warehouse.</div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3 col-6 mb-2">
                            <div style="background:var(--ob-card-bg); border:1px solid var(--ob-border); border-radius:.5rem; padding:1rem; display:flex; align-items:center; gap:.8rem;">
                                <i class="fas fa-cube icon-blue" style="font-size:1.4rem; padding:.6rem; border-radius:.4rem;"></i>
                                <div>
                                    <div style="font-size:.7rem; color:var(--ob-muted);">Total Stok (Semua Warehouse)</div>
                                    <div style="font-size:1.1rem; font-weight:700; color:var(--ob-text);"><span id="sum_total_stok">0</span> <span style="font-size:.7rem; font-weight:600; color:var(--ob-muted);">CAPS</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-2">
                            <div style="background:var(--ob-card-bg); border:1px solid var(--ob-border); border-radius:.5rem; padding:1rem; display:flex; align-items:center; gap:.8rem;">
                                <i class="fas fa-warehouse icon-green" style="font-size:1.4rem; padding:.6rem; border-radius:.4rem;"></i>
                                <div>
                                    <div style="font-size:.7rem; color:var(--ob-muted);">Total Nilai Stok</div>
                                    <div style="font-size:1.1rem; font-weight:700; color:var(--ob-text);">Rp <span id="sum_nilai_stok">0</span> <span style="font-size:.7rem; font-weight:600; color:var(--ob-muted);">(HPP)</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-2">
                            <div style="background:var(--ob-card-bg); border:1px solid var(--ob-border); border-radius:.5rem; padding:1rem; display:flex; align-items:center; gap:.8rem;">
                                <i class="fas fa-exclamation-triangle icon-yellow" style="font-size:1.4rem; padding:.6rem; border-radius:.4rem;"></i>
                                <div>
                                    <div style="font-size:.7rem; color:var(--ob-muted);">Stok Minimum</div>
                                    <div style="font-size:1.1rem; font-weight:700; color:var(--ob-text);"><span id="sum_stok_min">0</span> <span style="font-size:.7rem; font-weight:600; color:var(--ob-muted);">CAPS</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-2">
                            <div style="background:var(--ob-card-bg); border:1px solid var(--ob-border); border-radius:.5rem; padding:1rem; display:flex; align-items:center; gap:.8rem;">
                                <i class="fas fa-calendar-times icon-red" style="font-size:1.4rem; padding:.6rem; border-radius:.4rem;"></i>
                                <div>
                                    <div style="font-size:.7rem; color:var(--ob-muted);">Expired ≤ 90 Hari</div>
                                    <div style="font-size:1.1rem; font-weight:700; color:var(--ob-text);"><span id="sum_exp_90">0</span> <span style="font-size:.7rem; font-weight:600; color:var(--ob-muted);">CAPS</span></div>
                                    <a href="#" id="link_lihat_detail_exp" style="font-size:.7rem; color:var(--ob-blue); text-decoration:none;">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                        <h6 style="font-weight:700; font-size:1rem; margin-bottom:0; color:var(--ob-text);">Stok per Warehouse</h6>
                        <div class="d-flex" style="gap:.5rem;">
                            <button class="btn-ob-outline" id="btn_refresh_stock"><i class="fas fa-sync-alt mr-1"></i> Refresh Stok</button>
                        </div>
                    </div>

                    <div class="table-responsive mb-2">
                        <table class="table table-bordered" id="stockTable" style="border-color:var(--ob-border);">
                            <thead>
                                <tr>
                                    <th style="width:50px;">No</th>
                                    <th>Warehouse</th>
                                    <th>Bin Default</th>
                                    <th style="text-align:center;">Stok Tersedia</th>
                                    <th style="text-align:center;">Stok Minimum</th>
                                    <th style="text-align:center;">Stok Dalam PO</th>
                                    <th style="text-align:center;">Stok Dalam Paket</th>
                                    <th>Satuan</th>
                                    <th style="text-align:right;">Nilai Stok (HPP)</th>
                                </tr>
                            </thead>
                            <tbody id="stockBody">
                            </tbody>
                        </table>
                    </div>
                    <div class="dt-footer-wrapper mb-4">
                        <div class="dataTables_info" id="stock_info_text">Menampilkan 0 sampai 0 dari 0 data</div>
                        <div class="d-flex align-items-center" style="gap:.5rem;">
                            <select class="form-control form-control-sm" id="stock_per_page" style="width:110px; background:var(--ob-card-bg); color:var(--ob-text); border-color:var(--ob-border);">
                                <option value="10">10 / halaman</option>
                                <option value="25">25 / halaman</option>
                                <option value="50">50 / halaman</option>
                            </select>
                            <div class="dataTables_paginate" id="stock_paginate">
                                <span class="paginate_button previous disabled"><i class="fas fa-angle-left"></i></span>
                                <span class="paginate_button current">1</span>
                                <span class="paginate_button next disabled"><i class="fas fa-angle-right"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap">
                        <div>
                            <h6 style="font-weight:700; font-size:1rem; margin-bottom:2px; color:var(--ob-text);">Batch / Expired</h6>
                            <div style="font-size:.8rem; color:var(--ob-muted);">Daftar batch dan tanggal expired untuk obat ini.</div>
                        </div>
                        <div class="d-flex" style="gap:.5rem;">
                            <button class="btn-ob-outline" id="btn_cetak_label"><i class="fas fa-print mr-1"></i> Cetak Label</button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="batchTable" style="border-color:var(--ob-border);">
                            <thead>
                                <tr>
                                    <th style="width:50px;">No</th>
                                    <th>No. Batch</th>
                                    <th>Tanggal Produksi</th>
                                    <th>Tanggal Expired</th>
                                    <th style="text-align:center;">Stok Tersedia</th>
                                    <th style="text-align:center;">Stok Reservasi</th>
                                    <th>Satuan</th>
                                    <th style="text-align:center;">Status</th>
                                </tr>
                            </thead>
                            <tbody id="batchBody">
                            </tbody>
                        </table>
                    </div>
                    <div class="dt-footer-wrapper">
                        <div class="dataTables_info" id="batch_info_text">Menampilkan 0 sampai 0 dari 0 data</div>
                        <div class="d-flex align-items-center" style="gap:.5rem;">
                            <select class="form-control form-control-sm" id="batch_per_page" style="width:110px; background:var(--ob-card-bg); color:var(--ob-text); border-color:var(--ob-border);">
                                <option value="10">10 / halaman</option>
                                <option value="25">25 / halaman</option>
                                <option value="50">50 / halaman</option>
                            </select>
                            <div class="dataTables_paginate" id="batch_paginate">
                                <span class="paginate_button previous disabled"><i class="fas fa-angle-left"></i></span>
                                <span class="paginate_button current">1</span>
                                <span class="paginate_button next disabled"><i class="fas fa-angle-right"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="info-box-blue mt-3">
                        <i class="fas fa-info-circle mt-1"></i>
                        <div>
                            <strong>Catatan</strong>
                            <ul style="padding-left:1.2rem; margin-bottom:0; margin-top:.3rem; font-size:.85rem;">
                                <li>Stok akan berkurang otomatis ketika obat digunakan pada transaksi penjualan, tindakan, atau paket.</li>
                                <li>Pastikan batch dan tanggal expired diinput dengan benar.</li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-4 pt-3" style="border-top:1px solid var(--ob-border); display:flex; justify-content:space-between; align-items:center;">
                        <button class="btn-ob-outline" id="btn_prev_6"><i class="fas fa-arrow-left mr-1"></i> Sebelumnya</button>
                        <button class="btn-ob-primary" id="btn_next_6">Lanjut: Dokumen <i class="fas fa-arrow-right ml-1"></i></button>
                    </div>
                </div>

                <div id="step_7" class="tab-pane ob-card">
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                        <div>
                            <h5 style="font-weight:700; font-size:1.1rem; margin-bottom:4px; color:var(--ob-text);">Dokumen Obat</h5>
                            <div style="font-size:.85rem; color:var(--ob-muted);">Unggah dan kelola dokumen terkait obat ini.</div>
                        </div>
                        <button class="btn-ob-outline" id="btn_tambah_dokumen"><i class="fas fa-plus text-primary mr-1"></i> Tambah Dokumen</button>
                    </div>

                    <div class="info-box-blue mb-3">
                        <i class="fas fa-info-circle mt-1"></i>
                        <div>Pastikan dokumen yang diunggah masih berlaku dan terbaca dengan jelas.</div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="dokumenTable" style="border-color:var(--ob-border);">
                            <thead>
                                <tr>
                                    <th style="width:50px;">No</th>
                                    <th>Jenis Dokumen</th>
                                    <th>Nomor / Referensi</th>
                                    <th>Tanggal</th>
                                    <th>Berlaku Hingga</th>
                                    <th>File</th>
                                    <th>Ukuran</th>
                                    <th style="text-align:center;">Status</th>
                                    <th style="text-align:center; width:80px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="dokumenBody">
                            </tbody>
                        </table>
                        <div style="font-size:.85rem; color:var(--ob-muted); margin-top:.5rem;">
                            Menampilkan 1 sampai 6 dari 6 data
                        </div>
                    </div>

                    <h6 style="font-weight:700; font-size:1rem; margin:1.5rem 0 1rem; color:var(--ob-text);">Dokumen Wajib</h6>
                    <div class="row" id="dokumenWajib">
                    </div>

                    <div class="mt-4 pt-3" style="border-top:1px solid var(--ob-border); display:flex; justify-content:space-between; align-items:center;">
                        <button class="btn-ob-outline" id="btn_prev_7"><i class="fas fa-arrow-left mr-1"></i> Sebelumnya</button>
                        <div>
                            <button class="btn-ob-outline mr-2" id="btn_wizard_cancel"><i class="fas fa-times mr-1"></i> Batal</button>
                            <button class="btn-ob-primary" id="btn_wizard_save"><i class="fas fa-save mr-1"></i> Simpan Obat</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4" id="sidebar_ringkasan">
                <div class="ob-card">
                    <h6 style="font-weight:700; font-size:1rem; margin-bottom:1rem; color:var(--ob-text);">Ringkasan Obat</h6>
                    
                    <div class="d-flex align-items-center mb-4 p-3" style="background:var(--ob-bg-soft); border-radius:.5rem;">
                        <i class="fas fa-capsules mr-3" style="font-size:2rem; color:var(--ob-blue);"></i>
                        <div>
                            <div style="font-weight:700; font-size:.95rem; color:var(--ob-text);" id="lbl_kode_preview">OBT-...</div>
                            <div style="font-size:.85rem; color:var(--ob-muted);" id="lbl_nama_preview">Belum ada data</div>
                        </div>
                    </div>

                    <table class="table table-sm table-borderless" style="font-size:.85rem;">
                        <tr><td class="text-muted pl-0" style="color:var(--ob-muted);" width="40%;">Generic Name</td><td class="text-right pr-0 font-weight-bold" id="lbl_generic_preview" style="color:var(--ob-text);">-</td></tr>
                        <tr><td class="text-muted pl-0" style="color:var(--ob-muted);">Strength</td><td class="text-right pr-0 font-weight-bold" id="lbl_strength_preview" style="color:var(--ob-text);">-</td></tr>
                        <tr><td class="text-muted pl-0" style="color:var(--ob-muted);">Dosage Form</td><td class="text-right pr-0 font-weight-bold" id="lbl_dosage_preview" style="color:var(--ob-text);">-</td></tr>
                        <tr><td class="text-muted pl-0" style="color:var(--ob-muted);">Route</td><td class="text-right pr-0 font-weight-bold" id="lbl_route_preview" style="color:var(--ob-text);">-</td></tr>
                        <tr><td class="text-muted pl-0" style="color:var(--ob-muted);">Status</td><td class="text-right pr-0 font-weight-bold" id="lbl_status_preview" style="color:var(--ob-text);">-</td></tr>
                    </table>

                    <hr style="border-color:var(--ob-border);">

                    <div style="font-weight:700; font-size:.9rem; margin-bottom:.5rem; color:var(--ob-text);">Informasi Tambahan</div>
                    <table class="table table-sm table-borderless" style="font-size:.85rem;">
                        <tr><td class="text-muted pl-0" style="color:var(--ob-muted);" width="40%;">Base UOM</td><td class="text-right pr-0 font-weight-bold" id="lbl_uom_preview" style="color:var(--ob-text);">-</td></tr>
                        <tr><td class="text-muted pl-0" style="color:var(--ob-muted);">Barcode</td><td class="text-right pr-0 font-weight-bold" id="lbl_barcode_preview" style="color:var(--ob-text);">-</td></tr>
                    </table>

                    <div class="tips-box mt-3" style="background-color:var(--ob-amber-bg);">
                        <div style="font-weight:700; margin-bottom:.5rem;"><i class="far fa-lightbulb text-warning mr-1"></i> Tips</div>
                        <ul style="font-size:.75rem; color:var(--ob-text);">
                            <li>Pastikan data obat diisi dengan lengkap dan benar.</li>
                            <li>Data akan digunakan di seluruh modul klinik.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="view_uom_form" style="display:none;">
        <div class="breadcrumb-custom">
            Master Data &nbsp;&gt;&nbsp; Master Item &nbsp;&gt;&nbsp; Obat &nbsp;&gt;&nbsp; Tambah Obat &nbsp;&gt;&nbsp; <strong>Tambah Satuan (UOM)</strong>
        </div>

        <div class="wizard-header">
            <div class="d-flex align-items-center">
                <button class="btn btn-sm btn-light border mr-3 btn-batal-uom" style="border-radius: .4rem; height:34px; width:34px; background:var(--ob-card-bg); border-color:var(--ob-border); color:var(--ob-text);">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <div>
                    <h1 class="page-title">Tambah Satuan (UOM)</h1>
                    <div class="page-subtitle">Tambahkan satuan dan konversinya terhadap base UOM (CAPS)</div>
                </div>
            </div>
            <div class="d-flex gap-2" style="gap: .5rem;">
                <button class="btn-ob-outline btn-batal-uom"><i class="fas fa-times mr-1"></i> Batal</button>
                <button class="btn-ob-primary" id="btn_simpan_uom"><i class="fas fa-save mr-1"></i> Simpan Satuan</button>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="ob-card">
                    <h5 style="font-weight:700; font-size:1.1rem; margin-bottom:1.5rem; color:var(--ob-text);">Informasi Satuan</h5>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Base UOM *</label>
                            <input type="text" class="form-control" value="CAPS - Capsule (Kapsul)" readonly style="background:var(--ob-bg-soft);">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Satuan (UOM) <span class="text-danger">*</span></label>
                            <select class="form-control" id="uom_id_master"><option value="">Pilih satuan</option></select>
                            <div style="font-size:.75rem; color:var(--ob-muted);">Dipilih dari master UOM</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Deskripsi</label>
                            <input type="text" class="form-control" id="uom_deskripsi" placeholder="Terisi otomatis" readonly style="background:var(--ob-bg-soft);">
                        </div>
                        <div class="col-md-4 mb-3">
                            <div style="display:flex; align-items:center; gap:.5rem;">
                                <label class="ob-switch"><input type="checkbox" id="uom_purchase" checked><span class="slider"></span></label>
                                <span class="ob-switch-label">Purchase UOM</span>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div style="display:flex; align-items:center; gap:.5rem;">
                                <label class="ob-switch"><input type="checkbox" id="uom_sales" checked><span class="slider"></span></label>
                                <span class="ob-switch-label">Sales UOM</span>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="field-label">Status</label>
                            <select class="form-control" id="uom_status">
                                <option value="Aktif" selected>Aktif</option>
                                <option value="Non-Aktif">Non-Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="ob-card">
                    <h5 style="font-weight:700; font-size:1.1rem; margin-bottom:1.5rem; color:var(--ob-text);">Konversi ke Base UOM</h5>
                    <div style="font-size:.85rem; color:var(--ob-muted); margin-bottom:1rem;">Tentukan faktor konversi untuk mengubah satuan ini ke base UOM (CAPS).</div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Faktor Konversi ke Base UOM *</label>
                            <input type="number" class="form-control" id="uom_faktor" value="10" min="1">
                            <div style="font-size:.75rem; color:var(--ob-muted);">1 STRIP = 10 CAPS</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Isi per Satuan *</label>
                            <input type="text" class="form-control" id="uom_isi" placeholder="1 STRIP = 10 CAPS" readonly style="background:var(--ob-bg-soft);">
                            <div style="font-size:.75rem; color:var(--ob-muted);">Informasi isi dalam satuan ini (untuk referensi)</div>
                        </div>
                    </div>
                </div>

                <div class="ob-card mb-0">
                    <div class="tips-box">
                        <div style="font-weight:700; margin-bottom:.5rem;"><i class="far fa-lightbulb text-warning mr-1"></i> Catatan</div>
                        <ul style="font-size:.8rem; color:var(--ob-text); margin-bottom:0;">
                            <li>Satuan dengan level lebih tinggi memiliki faktor konversi lebih besar.</li>
                            <li>Base UOM selalu memiliki faktor konversi = 1.</li>
                            <li>Satuan non-aktif tidak akan digunakan pada transaksi.</li>
                            <li>Pastikan faktor konversi diisi dengan angka lebih besar dari 0.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="ob-card">
                    <h6 style="font-weight:700; font-size:1rem; margin-bottom:1rem; color:var(--ob-text);">Preview Konversi</h6>
                    
                    <div style="background:var(--ob-bg-soft); padding:1rem; border-radius:.5rem; border:1px solid var(--ob-border);">
                        <div style="display:flex; justify-content:space-between; padding:.4rem 0; border-bottom:1px solid var(--ob-border);">
                            <span style="color:var(--ob-muted);">Base UOM</span>
                            <span style="font-weight:600; color:var(--ob-text);">CAPS - Capsule (Kapsul)</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; padding:.4rem 0; border-bottom:1px solid var(--ob-border);">
                            <span style="color:var(--ob-muted);">Satuan Baru</span>
                            <span style="font-weight:600; color:var(--ob-text);"><strong id="preview_uom">STRIP</strong> - <span id="preview_desk">Strip (10 kapsul)</span></span>
                        </div>
                        <div style="display:flex; justify-content:space-between; padding:.4rem 0; border-bottom:1px solid var(--ob-border);">
                            <span style="color:var(--ob-muted);">Konversi</span>
                            <span style="font-weight:600; color:var(--ob-text);"><strong id="preview_konversi">1 STRIP = 10 CAPS</strong></span>
                        </div>
                        <div style="background:var(--ob-blue-soft); padding:.4rem .8rem; border-radius:.3rem; font-weight:700; color:var(--ob-blue); text-align:center; margin-top:.5rem;" id="preview_conversion_detail">
                            10 STRIP = 100 CAPS
                        </div>
                        <div style="text-align:center; margin-top:.5rem; font-size:.8rem; color:var(--ob-muted);">
                            100 CAPS = 10 STRIP
                        </div>
                    </div>
                </div>

                <div class="ob-card">
                    <div class="tips-box" style="font-size:.75rem;">
                        <div style="font-weight:700; margin-bottom:.5rem;"><i class="far fa-lightbulb text-warning mr-1"></i> Catatan</div>
                        <ul style="font-size:.75rem; color:var(--ob-text); margin-bottom:0;">
                            <li>Satuan dengan level lebih tinggi memiliki faktor konversi lebih besar.</li>
                            <li>Base UOM selalu memiliki faktor konversi = 1.</li>
                            <li>Satuan non-aktif tidak akan digunakan pada transaksi.</li>
                            <li>Pastikan faktor konversi diisi dengan angka lebih besar dari 0.</li>
                        </ul>
                    </div>
                </div>

                <div class="text-right mt-3">
                    <button class="btn btn-light border btn-batal-uom mr-2" style="font-weight:600; padding:.4rem 1.5rem; background:var(--ob-card-bg); border-color:var(--ob-border); color:var(--ob-text);"><i class="fas fa-times mr-1"></i> Batal</button>
                    <button class="btn-ob-primary" id="btn_simpan_uom_bawah" style="padding:.4rem 1.5rem;"><i class="fas fa-save mr-1"></i> Simpan Satuan</button>
                </div>
            </div>
        </div>
    </div>

    <div id="view_harga_form" style="display:none;">
        <div class="breadcrumb-custom">
            Master Data &nbsp;&gt;&nbsp; Master Item &nbsp;&gt;&nbsp; Obat &nbsp;&gt;&nbsp; Tambah Obat &nbsp;&gt;&nbsp; <strong>Tambah Harga</strong>
        </div>

        <div class="wizard-header">
            <div class="d-flex align-items-center">
                <button class="btn btn-sm btn-light border mr-3 btn-batal-harga" style="border-radius: .4rem; height:34px; width:34px; background:var(--ob-card-bg); border-color:var(--ob-border); color:var(--ob-text);">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <div>
                    <h1 class="page-title">Tambah Harga</h1>
                    <div class="page-subtitle">Kelola harga jual dan margin untuk obat ini.</div>
                </div>
            </div>
            <div class="d-flex gap-2" style="gap: .5rem;">
                <button class="btn-ob-outline btn-batal-harga"><i class="fas fa-times mr-1"></i> Batal</button>
                <button class="btn-ob-primary" id="btn_simpan_harga"><i class="fas fa-save mr-1"></i> Simpan Harga</button>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="ob-card">
                    <h5 style="font-weight:700; font-size:1.1rem; margin-bottom:1.5rem; color:var(--ob-text);">Informasi Obat</h5>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <span class="text-muted" style="color:var(--ob-muted);">Nama Obat</span>
                            <div style="color:var(--ob-text);"><strong>Amoxicillin 500 mg Capsule</strong></div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <span class="text-muted" style="color:var(--ob-muted);">Kode Obat</span>
                            <div style="color:var(--ob-text);"><strong>OBT-AMX500</strong></div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <span class="text-muted" style="color:var(--ob-muted);">Sediaan / Kekuatan</span>
                            <div style="color:var(--ob-text);">Capsule / 500 mg</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <span class="text-muted" style="color:var(--ob-muted);">Satuan Dasar (Base UOM)</span>
                            <div style="color:var(--ob-text);">CAPS</div>
                        </div>
                        <div class="col-md-12">
                            <span class="text-muted" style="color:var(--ob-muted);">Kemasan</span>
                            <div style="color:var(--ob-text);">1 strip @ 10 tablet</div>
                        </div>
                    </div>
                </div>

                <div class="ob-card">
                    <h5 style="font-weight:700; font-size:1.1rem; margin-bottom:1.5rem; color:var(--ob-text);">1. Price Class</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Price Class *</label>
                            <select class="form-control" id="h_price_class">
                                <option value="">Pilih Price Class</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Satuan (UOM) *</label>
                            <input type="text" class="form-control" id="h_uom_id_display" readonly style="background:var(--ob-bg-soft);">
                            <input type="hidden" id="h_uom_id">
                            <div style="font-size:.75rem; color:var(--ob-muted);">Mengikuti Base UOM obat</div>
                        </div>
                    </div>
                </div>

                <div class="ob-card">
                    <h5 style="font-weight:700; font-size:1.1rem; margin-bottom:1.5rem; color:var(--ob-text);">2. Harga &amp; Margin</h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="field-label">Harga Jual *</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                                <input type="text" class="form-control text-right" id="h_harga_jual" value="2.000">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="field-label">HPP / Unit</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                                <input type="text" class="form-control text-right" id="h_hpp" value="1.200">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="field-label">Margin (%)</label>
                            <input type="text" class="form-control text-right" id="h_margin" value="40,00%" readonly style="background:var(--ob-bg-soft);">
                        </div>
                    </div>
                    <div style="font-size:.75rem; color:var(--ob-muted); margin-top:-.5rem;">Rumus Margin (%) = (Harga Jual - HPP) / Harga Jual x 100%</div>
                </div>

                <div class="ob-card">
                    <h5 style="font-weight:700; font-size:1.1rem; margin-bottom:1.5rem; color:var(--ob-text);">3. Rentang Berlaku</h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="field-label">Tanggal Mulai Berlaku *</label>
                            <input type="date" class="form-control" id="h_tgl_mulai" value="2024-01-01">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="field-label">Tanggal Selesai (Opsional)</label>
                            <input type="date" class="form-control" id="h_tgl_selesai">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="field-label d-block">Status</label>
                            <label class="ob-switch mt-1">
                                <input type="checkbox" id="h_status_aktif" checked>
                                <span class="slider"></span>
                            </label>
                            <span class="ob-switch-label text-primary" style="color:var(--ob-blue);">Aktif</span>
                        </div>
                    </div>
                </div>

                <div class="ob-card mb-0">
                    <h5 style="font-weight:700; font-size:1.1rem; margin-bottom:1.5rem; color:var(--ob-text);">4. Keterangan (Opsional)</h5>
                    <textarea class="form-control" rows="2" id="h_catatan" placeholder="Masukkan catatan (opsional)"></textarea>
                    <div class="text-right text-muted mt-1" style="font-size:.75rem; color:var(--ob-muted);">0 / 250</div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="ob-card">
                    <h6 style="font-weight:700; font-size:1rem; margin-bottom:1rem; color:var(--ob-text);">Ringkasan Perhitungan</h6>
                    <table class="table table-sm table-borderless" style="font-size:.85rem;">
                        <tr><td class="text-muted pl-0" style="color:var(--ob-muted);">Harga Jual</td><td class="text-right pr-0 font-weight-bold" id="r_harga" style="color:var(--ob-text);">Rp 2.000</td></tr>
                        <tr><td class="text-muted pl-0" style="color:var(--ob-muted);">HPP / Unit</td><td class="text-right pr-0" id="r_hpp" style="color:var(--ob-text);">Rp 1.200</td></tr>
                        <tr><td class="text-muted pl-0" style="color:var(--ob-muted);">Margin (Nominal)</td><td class="text-right pr-0" id="r_margin_nominal" style="color:var(--ob-text);">Rp 800</td></tr>
                        <tr><td class="text-muted pl-0" style="color:var(--ob-muted);">Margin (%)</td><td class="text-right pr-0 font-weight-bold text-success" id="r_margin_persen" style="color:#198754;">40,00%</td></tr>
                    </table>
                    <div style="font-size:.75rem; color:var(--ob-muted);">Perhitungan margin akan otomatis diperbarui saat Anda mengisi Harga Jual dan HPP.</div>
                </div>

                <div class="ob-card">
                    <h6 style="font-weight:700; font-size:1rem; margin-bottom:1rem; color:var(--ob-text);">Daftar Harga Aktif</h6>
                    <div style="background:var(--ob-blue-soft); border-radius:.4rem; padding:.8rem; margin-bottom:.5rem; border-left:3px solid var(--ob-blue);">
                        <div style="color:var(--ob-text);"><strong>ECERAN</strong></div>
                        <div style="color:var(--ob-text);">Rp 2.000</div>
                        <div style="font-size:.75rem; color:var(--ob-muted);">HPP: Rp 1.200 | Margin: 40,00%</div>
                        <div style="font-size:.75rem; color:var(--ob-muted);">Berlaku sejak 01/01/2024</div>
                        <div><span class="badge-ob-aktif">Aktif</span></div>
                    </div>
                    <div style="background:var(--ob-bg-soft); border-radius:.4rem; padding:.8rem; margin-bottom:.5rem; border-left:3px solid #198754;">
                        <div style="color:var(--ob-text);"><strong>GROSIR</strong></div>
                        <div style="color:var(--ob-text);">Rp 1.800</div>
                        <div style="font-size:.75rem; color:var(--ob-muted);">HPP: Rp 1.200 | Margin: 33,33%</div>
                        <div style="font-size:.75rem; color:var(--ob-muted);">Berlaku sejak 01/01/2024</div>
                        <div><span class="badge-ob-aktif">Aktif</span></div>
                    </div>
                    <div style="background:var(--ob-amber-bg); border-radius:.4rem; padding:.8rem; border-left:3px solid #ffc107;">
                        <div style="color:var(--ob-text);"><strong>ASURANSI</strong></div>
                        <div style="color:var(--ob-text);">Rp 1.600</div>
                        <div style="font-size:.75rem; color:var(--ob-muted);">HPP: Rp 1.200 | Margin: 25,00%</div>
                        <div style="font-size:.75rem; color:var(--ob-muted);">Berlaku sejak 15/02/2024</div>
                        <div><span class="badge-ob-aktif">Aktif</span></div>
                    </div>
                    <div class="text-center mt-2">
                        <button class="btn btn-sm btn-link text-primary" style="color:var(--ob-blue);">Lihat Semua Harga</button>
                    </div>
                </div>

                <div class="text-right">
                    <button class="btn btn-light border btn-batal-harga mr-2" style="font-weight:600; padding:.4rem 1.5rem; background:var(--ob-card-bg); border-color:var(--ob-border); color:var(--ob-text);"><i class="fas fa-times mr-1"></i> Batal</button>
                    <button class="btn-ob-primary" id="btn_simpan_harga_bawah" style="padding:.4rem 1.5rem;"><i class="fas fa-save mr-1"></i> Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <div id="view_supplier_form" style="display:none;">
        <div class="breadcrumb-custom">
            Master Data &nbsp;&gt;&nbsp; Master Item &nbsp;&gt;&nbsp; Obat &nbsp;&gt;&nbsp; Tambah Obat &nbsp;&gt;&nbsp; Supplier &nbsp;&gt;&nbsp; <strong>Tambah Supplier</strong>
        </div>

        <div class="wizard-header">
            <div class="d-flex align-items-center">
                <button class="btn btn-sm btn-light border mr-3 btn-batal-supplier" style="border-radius: .4rem; height:34px; width:34px; background:var(--ob-card-bg); border-color:var(--ob-border); color:var(--ob-text);">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <div>
                    <h1 class="page-title">Tambah Supplier</h1>
                    <div class="page-subtitle">Tambah data supplier baru.</div>
                </div>
            </div>
            <div class="d-flex gap-2" style="gap: .5rem;">
                <button class="btn-ob-outline btn-batal-supplier"><i class="fas fa-times mr-1"></i> Batal</button>
                <button class="btn-ob-primary" id="btn_simpan_supplier"><i class="fas fa-save mr-1"></i> Simpan Supplier</button>
            </div>
        </div>

        <div class="wizard-stepper" style="border-bottom:1px solid var(--ob-border); padding-bottom:1rem; margin-bottom:1.5rem;">
            <div class="step-item active" data-step="1"><div class="step-circle">1</div> Informasi Utama</div>
            <div class="step-item" data-step="2"><div class="step-circle">2</div> Alamat</div>
            <div class="step-item" data-step="3"><div class="step-circle">3</div> Kontak</div>
            <div class="step-item" data-step="4"><div class="step-circle">4</div> Informasi Bisnis</div>
            <div class="step-item" data-step="5"><div class="step-circle">5</div> Lainnya</div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div id="supplier_step_1" class="supplier-step-pane active ob-card">
                    <h5 style="font-weight:700; font-size:1.1rem; margin-bottom:1.5rem; color:var(--ob-text);">Informasi Utama</h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Supplier <span class="text-danger">*</span></label>
                            <select class="form-control" id="s_supplier_id"><option value="">Pilih supplier</option></select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Principal</label>
                            <select class="form-control" id="s_principal_id_input"><option value="">Pilih principal (opsional)</option></select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="field-label">Harga Beli Terakhir (Rp) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control text-right" id="s_harga_beli_input" placeholder="0">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="field-label">Lead Time (Hari)</label>
                            <input type="number" class="form-control" id="s_lead_time_input" min="0" placeholder="0">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="field-label">Minimal Order Qty</label>
                            <input type="number" class="form-control" id="s_min_order_input" min="0" placeholder="0">
                        </div>
                        <div class="col-md-6 mb-3">
                            <div style="display:flex; align-items:center; gap:.5rem;">
                                <label class="ob-switch"><input type="checkbox" id="s_utama_input"><span class="slider"></span></label>
                                <span class="ob-switch-label">Jadikan Supplier Utama (Default)</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="field-label d-block">Status <span class="text-danger">*</span></label>
                            <div class="icheck-primary d-inline mr-3">
                                <input type="radio" id="s_aktif" name="s_status" checked>
                                <label for="s_aktif">Aktif</label>
                            </div>
                            <div class="icheck-primary d-inline">
                                <input type="radio" id="s_nonaktif" name="s_status">
                                <label for="s_nonaktif">Non-Aktif</label>
                            </div>
                        </div>
                    </div>
                </div>
                

                <div id="supplier_step_2" class="supplier-step-pane ob-card" style="display:none;">
                    <h5 style="font-weight:700; font-size:1.1rem; margin-bottom:1.5rem; color:var(--ob-text);">Alamat</h5>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="field-label">Alamat</label>
                            <textarea class="form-control" rows="3" id="s_alamat" placeholder="Masukkan alamat supplier"></textarea>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="field-label">Kota</label>
                            <input type="text" class="form-control" id="s_kota" placeholder="Masukkan kota">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="field-label">Provinsi</label>
                            <input type="text" class="form-control" id="s_provinsi" placeholder="Masukkan provinsi">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="field-label">Kode Pos</label>
                            <input type="text" class="form-control" id="s_kodepos" placeholder="Masukkan kode pos">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="field-label">Negara</label>
                            <input type="text" class="form-control" id="s_negara" placeholder="Masukkan negara" value="Indonesia">
                        </div>
                    </div>
                </div>

                <div id="supplier_step_3" class="supplier-step-pane ob-card" style="display:none;">
                    <h5 style="font-weight:700; font-size:1.1rem; margin-bottom:1.5rem; color:var(--ob-text);">Kontak</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Nama Kontak</label>
                            <input type="text" class="form-control" id="s_kontak" placeholder="Masukkan nama kontak">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Jabatan</label>
                            <input type="text" class="form-control" id="s_jabatan" placeholder="Masukkan jabatan">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Telepon</label>
                            <input type="text" class="form-control" id="s_telepon" placeholder="Masukkan nomor telepon">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Email</label>
                            <input type="email" class="form-control" id="s_email" placeholder="Masukkan email">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Fax</label>
                            <input type="text" class="form-control" id="s_fax" placeholder="Masukkan nomor fax (opsional)">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Mobile</label>
                            <input type="text" class="form-control" id="s_mobile" placeholder="Masukkan nomor mobile (opsional)">
                        </div>
                    </div>
                </div>

                <div id="supplier_step_4" class="supplier-step-pane ob-card" style="display:none;">
                    <h5 style="font-weight:700; font-size:1.1rem; margin-bottom:1.5rem; color:var(--ob-text);">Informasi Bisnis</h5>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Nama Bank</label>
                            <input type="text" class="form-control" id="s_bank" placeholder="Masukkan nama bank">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="field-label">No. Rekening</label>
                            <input type="text" class="form-control" id="s_rekening" placeholder="Masukkan nomor rekening">
                        </div>
                    </div>

                    <h6 style="font-weight:700; font-size:.95rem; margin:1.5rem 0 1rem; color:var(--ob-text);">Tipe &amp; Kategori</h6>
                    <div style="font-size:.85rem; color:var(--ob-muted); margin-bottom:1rem;">Pilih tipe dan kategori supplier untuk memudahkan pengelompokan dan analisis data pembelian.</div>
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <div class="icheck-primary">
                                <input type="radio" id="s_tipe_distributor" name="s_tipe_bisnis" value="Distributor" checked>
                                <label for="s_tipe_distributor"><strong>Distributor</strong></label>
                            </div>
                            <div style="font-size:.75rem; color:var(--ob-muted);">Supplier/distributor umum</div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="icheck-primary">
                                <input type="radio" id="s_tipe_principal" name="s_tipe_bisnis" value="Principal">
                                <label for="s_tipe_principal"><strong>Principal</strong></label>
                            </div>
                            <div style="font-size:.75rem; color:var(--ob-muted);">Principal / Produsen</div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="icheck-primary">
                                <input type="radio" id="s_tipe_importir" name="s_tipe_bisnis" value="Importir">
                                <label for="s_tipe_importir"><strong>Importir</strong></label>
                            </div>
                            <div style="font-size:.75rem; color:var(--ob-muted);">Supplier importir</div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="icheck-primary">
                                <input type="radio" id="s_tipe_lokal" name="s_tipe_bisnis" value="Lokal">
                                <label for="s_tipe_lokal"><strong>Lokal</strong></label>
                            </div>
                            <div style="font-size:.75rem; color:var(--ob-muted);">Supplier lokal</div>
                        </div>
                    </div>
                </div>

                <div id="supplier_step_5" class="supplier-step-pane ob-card" style="display:none;">
                    <h5 style="font-weight:700; font-size:1.1rem; margin-bottom:1.5rem; color:var(--ob-text);">Catatan (Opsional)</h5>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <textarea class="form-control" rows="4" id="s_catatan" placeholder="Masukkan catatan mengenai supplier"></textarea>
                            <div class="text-right text-muted mt-1" style="font-size:.75rem; color:var(--ob-muted);">0 / 250</div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3" style="border-top:1px solid var(--ob-border); display:flex; justify-content:space-between; align-items:center;">
                    <button class="btn-ob-outline" id="btn_supplier_prev"><i class="fas fa-arrow-left mr-1"></i> Sebelumnya</button>
                    <button class="btn-ob-primary" id="btn_supplier_next">Lanjutkan <i class="fas fa-arrow-right ml-1"></i></button>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="ob-card">
                    <h6 style="font-weight:700; font-size:1rem; margin-bottom:1rem; color:var(--ob-text);">Ringkasan</h6>
                    <div class="row">
                        <div class="col-6 mb-2">
                            <div style="font-size:.7rem; color:var(--ob-muted);">Total Pembelian</div>
                            <div style="font-weight:700; color:var(--ob-text);">Rp 0</div>
                        </div>
                        <div class="col-6 mb-2">
                            <div style="font-size:.7rem; color:var(--ob-muted);">Total Hutang</div>
                            <div style="font-weight:700; color:var(--ob-text);">Rp 0</div>
                        </div>
                        <div class="col-6 mb-2">
                            <div style="font-size:.7rem; color:var(--ob-muted);">Pembayaran Terakhir</div>
                            <div style="font-weight:700; color:var(--ob-text);">-</div>
                        </div>
                        <div class="col-6 mb-2">
                            <div style="font-size:.7rem; color:var(--ob-muted);">Lead Time Rata-rata</div>
                            <div style="font-weight:700; color:var(--ob-text);">0 hari</div>
                        </div>
                    </div>
                </div>

                <div class="ob-card">
                    <div class="tips-box" style="font-size:.75rem;">
                        <div style="font-weight:700; margin-bottom:.5rem;"><i class="far fa-lightbulb text-warning mr-1"></i> Catatan</div>
                        <ul style="font-size:.75rem; color:var(--ob-text); margin-bottom:0;">
                            <li>Pastikan data supplier diisi dengan benar.</li>
                            <li>Kode supplier akan digunakan untuk transaksi pembelian.</li>
                        </ul>
                    </div>
                </div>

                <div class="text-right mt-3">
                    <button class="btn btn-light border btn-batal-supplier mr-2" style="font-weight:600; padding:.4rem 1.5rem; background:var(--ob-card-bg); border-color:var(--ob-border); color:var(--ob-text);"><i class="fas fa-times mr-1"></i> Batal</button>
                    <button class="btn-ob-primary" id="btn_simpan_supplier_bawah" style="padding:.4rem 1.5rem;"><i class="fas fa-save mr-1"></i> Simpan Supplier</button>
                </div>
            </div>
        </div>
    </div>

    <div id="view_dokumen_form" style="display:none;">
        <div class="breadcrumb-custom">
            Master Data &nbsp;&gt;&nbsp; Master Item &nbsp;&gt;&nbsp; Obat &nbsp;&gt;&nbsp; Tambah Obat &nbsp;&gt;&nbsp; Dokumen &nbsp;&gt;&nbsp; <strong>Tambah Dokumen</strong>
        </div>

        <div class="wizard-header">
            <div class="d-flex align-items-center">
                <button class="btn btn-sm btn-light border mr-3 btn-batal-dokumen" style="border-radius: .4rem; height:34px; width:34px; background:var(--ob-card-bg); border-color:var(--ob-border); color:var(--ob-text);">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <div>
                    <h1 class="page-title">Tambah Dokumen</h1>
                    <div class="page-subtitle">Lengkap informasi dokumen untuk obat ini.</div>
                </div>
            </div>
            <div class="d-flex gap-2" style="gap: .5rem;">
                <button class="btn-ob-outline btn-batal-dokumen"><i class="fas fa-times mr-1"></i> Batal</button>
                <button class="btn-ob-primary" id="btn_simpan_dokumen"><i class="fas fa-save mr-1"></i> Simpan Dokumen</button>
            </div>
        </div>

        <div class="wizard-stepper" style="border-bottom:1px solid var(--ob-border); padding-bottom:1rem; margin-bottom:1.5rem;">
            <div class="step-item active" data-step="1"><div class="step-circle">1</div> Informasi Dokumen</div>
            <div class="step-item" data-step="2"><div class="step-circle">2</div> File Dokumen</div>
            <div class="step-item" data-step="3"><div class="step-circle">3</div> Konfirmasi</div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div id="dokumen_step_1" class="dokumen-step-pane active ob-card">
                    <h5 style="font-weight:700; font-size:1.1rem; margin-bottom:1.5rem; color:var(--ob-text);">Informasi Dokumen</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Jenis Dokumen</label>
                            <select class="form-control" id="d_jenis">
                                <option value="">Pilih jenis dokumen</option>
                                <option value="Registrasi (NIE)">Registrasi (NIE)</option>
                                <option value="Sertifikat Cara Pembuatan Obat yang Baik (GMP)">Sertifikat Cara Pembuatan Obat yang Baik (GMP)</option>
                                <option value="Hasil Uji Lab (COA)">Hasil Uji Lab (COA)</option>
                                <option value="Brosur / Informasi Produk">Brosur / Informasi Produk</option>
                                <option value="Surat Penunjukan Distribusi">Surat Penunjukan Distribusi</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            <div style="font-size:.75rem; color:var(--ob-muted);">Pilih kategori dokumen yang sesuai</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Tanggal Dokumen</label>
                            <input type="date" class="form-control" id="d_tanggal" value="2024-05-24">
                            <div style="font-size:.75rem; color:var(--ob-muted);">Tanggal diterbitkannya dokumen</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Diterbitkan Oleh</label>
                            <input type="text" class="form-control" id="d_penerbit" placeholder="Masukkan nama penerbit dokumen">
                            <div style="font-size:.75rem; color:var(--ob-muted);">Instansi / lembaga / perusahaan penerbit dokumen</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Nomor / Referensi</label>
                            <input type="text" class="form-control" id="d_nomor" placeholder="Masukkan nomor / referensi dokumen">
                            <div style="font-size:.75rem; color:var(--ob-muted);">Nomor surat, sertifikat, atau referensi dokumen</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Berlaku Hingga</label>
                            <input type="date" class="form-control" id="d_berlaku">
                            <div style="font-size:.75rem; color:var(--ob-muted);">Opsional. Kosongkan jika tidak ada batas berlaku</div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="field-label">Deskripsi (Opsional)</label>
                            <textarea class="form-control" rows="2" id="d_deskripsi" placeholder="Masukkan deskripsi dokumen"></textarea>
                        </div>
                    </div>
                </div>

                <div id="dokumen_step_2" class="dokumen-step-pane ob-card" style="display:none;">
                    <h5 style="font-weight:700; font-size:1.1rem; margin-bottom:1.5rem; color:var(--ob-text);">File Dokumen</h5>
                    
                    <div class="tips-box mb-3">
                        <div style="font-weight:700; margin-bottom:.5rem;"><i class="fas fa-file-alt text-warning mr-1"></i> Persyaratan Dokumen</div>
                        <ul style="font-size:.8rem; color:var(--ob-text); margin-bottom:0;">
                            <li>File harus berformat PDF, JPG, JPEG, atau PNG.</li>
                            <li>Ukuran file maksimal 10 MB.</li>
                            <li>Pastikan dokumen masih berlaku dan terbaca dengan jelas.</li>
                            <li>Hindari file yang terpotong atau buram.</li>
                        </ul>
                    </div>

                    <div class="drop-zone" id="dokumen_drop_zone" style="padding:3rem;">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <div style="font-size:1.1rem; font-weight:600;">Drag &amp; drop file di sini atau</div>
                        <button class="btn-ob-outline mt-2" id="dokumen_pilih_file" style="display:inline-block;">Pilih File</button>
                        <div style="font-size:.75rem; color:var(--ob-muted); margin-top:.5rem;">Format: PDF, JPG, JPEG, PNG (Maks. 10 MB)</div>
                        <input type="file" style="display:none;" id="dokumen_file_input" accept=".pdf,.jpg,.jpeg,.png">
                    </div>

                    <div style="margin-top:1.5rem; border:1px solid var(--ob-border); border-radius:.5rem; padding:1.5rem; text-align:center; background:var(--ob-bg-soft);">
                        <h6 style="font-weight:700; font-size:.95rem; color:var(--ob-text);">Preview Dokumen</h6>
                        <i class="fas fa-file-pdf" style="font-size:4rem; color:var(--ob-muted); display:block; margin:1rem 0;"></i>
                        <div style="font-size:.85rem; color:var(--ob-muted);" id="dokumen_preview_text">Belum ada file</div>
                        <div style="font-size:.75rem; color:var(--ob-muted);">Upload dokumen untuk melihat preview</div>
                        <div style="font-size:.75rem; color:var(--ob-muted); margin-top:.5rem;">Preview akan ditampilkan setelah file berhasil diunggah.</div>
                    </div>

                    <div style="margin-top:1.5rem;">
                        <h6 style="font-weight:700; font-size:.95rem; color:var(--ob-text);">Riwayat Dokumen (Obat ini)</h6>
                        <div style="background:var(--ob-bg-soft); border-radius:.4rem; padding:1rem; text-align:center; border:1px dashed var(--ob-border);">
                            <div style="font-size:.85rem; color:var(--ob-muted);">Belum ada dokumen yang ditambahkan untuk obat ini.</div>
                        </div>
                        <div class="text-right mt-2">
                            <button class="btn btn-sm btn-link text-primary" style="color:var(--ob-blue);">Lihat Semua Dokumen</button>
                        </div>
                    </div>
                </div>

                <div id="dokumen_step_3" class="dokumen-step-pane ob-card" style="display:none;">
                    <h5 style="font-weight:700; font-size:1.1rem; margin-bottom:1.5rem; color:var(--ob-text);">Konfirmasi</h5>
                    <div class="info-box-blue">
                        <i class="fas fa-check-circle mt-1"></i>
                        <div>
                            <strong>Apakah data sudah benar?</strong>
                            <ul style="padding-left:1.2rem; margin-bottom:0; margin-top:.3rem; font-size:.85rem;">
                                <li>Pastikan jenis dokumen sudah sesuai.</li>
                                <li>Pastikan file dokumen terbaca dengan jelas.</li>
                                <li>Dokumen akan tersimpan dan dapat diakses kapan saja.</li>
                            </ul>
                        </div>
                    </div>
                    <div style="background:var(--ob-bg-soft); border-radius:.4rem; padding:1rem; margin-top:1rem;">
                        <div class="row">
                            <div class="col-6"><span class="text-muted" style="color:var(--ob-muted);">Jenis Dokumen</span></div>
                            <div class="col-6 text-right font-weight-bold" id="d_confirm_jenis" style="color:var(--ob-text);">-</div>
                        </div>
                        <div class="row">
                            <div class="col-6"><span class="text-muted" style="color:var(--ob-muted);">Nomor / Referensi</span></div>
                            <div class="col-6 text-right font-weight-bold" id="d_confirm_nomor" style="color:var(--ob-text);">-</div>
                        </div>
                        <div class="row">
                            <div class="col-6"><span class="text-muted" style="color:var(--ob-muted);">Tanggal</span></div>
                            <div class="col-6 text-right font-weight-bold" id="d_confirm_tanggal" style="color:var(--ob-text);">-</div>
                        </div>
                        <div class="row">
                            <div class="col-6"><span class="text-muted" style="color:var(--ob-muted);">Berlaku Hingga</span></div>
                            <div class="col-6 text-right font-weight-bold" id="d_confirm_berlaku" style="color:var(--ob-text);">-</div>
                        </div>
                        <div class="row">
                            <div class="col-6"><span class="text-muted" style="color:var(--ob-muted);">File</span></div>
                            <div class="col-6 text-right font-weight-bold" id="d_confirm_file" style="color:var(--ob-text);">Belum ada file</div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3" style="border-top:1px solid var(--ob-border); display:flex; justify-content:space-between; align-items:center;">
                    <button class="btn-ob-outline" id="btn_dokumen_prev"><i class="fas fa-arrow-left mr-1"></i> Sebelumnya</button>
                    <button class="btn-ob-primary" id="btn_dokumen_next">Lanjutkan <i class="fas fa-arrow-right ml-1"></i></button>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="ob-card">
                    <h6 style="font-weight:700; font-size:1rem; margin-bottom:1rem; color:var(--ob-text);">Ringkasan Obat</h6>
                    <div style="background:var(--ob-bg-soft); border-radius:.4rem; padding:.8rem; border-left:3px solid var(--ob-blue);">
                        <div style="font-weight:700; font-size:.95rem; color:var(--ob-text);">OBT-000123</div>
                        <div style="font-size:.85rem; color:var(--ob-text);">Paracetamol 500 mg Tablet</div>
                        <div style="font-size:.8rem; color:var(--ob-muted);">Tablet / 500 mg | TAB (Tablet)</div>
                        <div style="font-size:.8rem; color:var(--ob-muted);">Kemasan: 1 strip @ 10 tablet</div>
                    </div>
                </div>

                <div class="ob-card">
                    <div class="tips-box" style="font-size:.75rem;">
                        <div style="font-weight:700; margin-bottom:.5rem;"><i class="far fa-lightbulb text-warning mr-1"></i> Tips</div>
                        <ul style="font-size:.75rem; color:var(--ob-text); margin-bottom:0;">
                            <li>Pastikan dokumen yang diunggah masih berlaku.</li>
                            <li>File harus terbaca dengan jelas.</li>
                            <li>Gunakan nama file yang deskriptif.</li>
                        </ul>
                    </div>
                </div>

                <div class="text-right mt-3">
                    <button class="btn btn-light border btn-batal-dokumen mr-2" style="font-weight:600; padding:.4rem 1.5rem; background:var(--ob-card-bg); border-color:var(--ob-border); color:var(--ob-text);"><i class="fas fa-times mr-1"></i> Batal</button>
                    <button class="btn-ob-primary" id="btn_simpan_dokumen_bawah" style="padding:.4rem 1.5rem;"><i class="fas fa-save mr-1"></i> Simpan Dokumen</button>
                </div>
            </div>
        </div>
    </div>

    <div id="view_stock_form" style="display:none;">
        <div class="breadcrumb-custom">
            Master Data &nbsp;&gt;&nbsp; Master Item &nbsp;&gt;&nbsp; Obat &nbsp;&gt;&nbsp; Stock &amp; Batch &nbsp;&gt;&nbsp; <strong>Tambah Stock</strong>
        </div>

        <div class="wizard-header">
            <div class="d-flex align-items-center">
                <button class="btn btn-sm btn-light border mr-3 btn-batal-stock btn-sm-light" style="border-radius: .4rem; height:34px; width:34px;">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <div>
                    <h1 class="page-title">Tambah Stock</h1>
                    <div class="page-subtitle">Tambahkan stok baru ke warehouse.</div>
                </div>
            </div>
            <div class="d-flex gap-2" style="gap: .5rem; flex-wrap:wrap;">
                <button class="btn-ob-outline btn-batal-stock"><i class="fas fa-times mr-1"></i> Batalkan</button>
                <button class="btn-ob-primary" id="btn_simpan_stock"><i class="fas fa-save mr-1"></i> Simpan Stock</button>
            </div>
        </div>

        <div class="wizard-stepper">
            <div class="step-item active" data-step="1"><div class="step-circle">1</div> Informasi Obat</div>
            <div class="step-item" data-step="2"><div class="step-circle">2</div> Batch &amp; Expired</div>
            <div class="step-item" data-step="3"><div class="step-circle">3</div> Detail Stock</div>
            <div class="step-item" data-step="4"><div class="step-circle">4</div> Konfirmasi</div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div id="stock_step_1" class="stock-step-pane active ob-card">
                    <h5 style="font-weight:700; font-size:1.1rem; margin-bottom:1.5rem; color:var(--ob-text);">Informasi Obat</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Obat <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="st_cari_obat" placeholder="Cari kode / nama obat">
                                <div class="input-group-append"><span class="input-group-text"><i class="fas fa-search"></i></span></div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Satuan Dasar (Base UOM)</label>
                            <input type="text" class="form-control" id="st_base_uom" value="TAB (Tablet)" readonly style="background:var(--ob-bg-soft);">
                        </div>
                    </div>

                    <div style="background:var(--ob-blue-soft); border:1px solid #cce5ff; border-radius:.5rem; padding:1rem; display:flex; gap:1rem; align-items:center; margin-bottom:1rem;" id="st_obat_preview">
                        <i class="fas fa-file-alt" style="font-size:1.3rem; color:var(--ob-blue);"></i>
                        <div>
                            <div style="font-weight:700; font-size:.9rem; color:var(--ob-text);" id="st_obat_kode">OBT-000123</div>
                            <div style="font-weight:600; font-size:.9rem; color:var(--ob-text);" id="st_obat_nama">Paracetamol 500 mg Tablet</div>
                            <div style="font-size:.8rem; color:var(--ob-muted);" id="st_obat_detail">Tablet / 500 mg | TAB (Tablet)</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="field-label">Kemasan</label>
                            <input type="text" class="form-control" id="st_kemasan" value="1 strip @ 10 tablet" readonly style="background:var(--ob-bg-soft);">
                        </div>
                    </div>

                    <h6 style="font-weight:700; font-size:1rem; margin:1.5rem 0 1rem; color:var(--ob-text);">Informasi Warehouse &amp; Lokasi</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Warehouse <span class="text-danger">*</span></label>
                            <select class="form-control" id="st_warehouse">
                                <option value="">Pilih warehouse</option>
                                <option value="Gudang Farmasi Utama">Gudang Farmasi Utama</option>
                                <option value="Gudang Klinik 2">Gudang Klinik 2</option>
                                <option value="Gudang Cadangan">Gudang Cadangan</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Bin / Lokasi</label>
                            <select class="form-control" id="st_bin">
                                <option value="">Pilih bin / lokasi (opsional)</option>
                                <option value="BIN-01-A">BIN-01-A</option>
                                <option value="BIN-01-B">BIN-01-B</option>
                                <option value="BIN-02-A">BIN-02-A</option>
                            </select>
                        </div>
                    </div>

                    <h6 style="font-weight:700; font-size:1rem; margin:1.5rem 0 1rem; color:var(--ob-text);">Informasi Transaksi</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Tipe Transaksi <span class="text-danger">*</span></label>
                            <select class="form-control" id="st_tipe_transaksi">
                                <option value="Penerimaan Pembelian">Penerimaan Pembelian</option>
                                <option value="Stok Opname">Stok Opname</option>
                                <option value="Transfer Masuk">Transfer Masuk</option>
                                <option value="Retur Masuk">Retur Masuk</option>
                                <option value="Penyesuaian Manual">Penyesuaian Manual</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Sumber Dokumen <span class="text-danger">*</span></label>
                            <select class="form-control" id="st_sumber_dokumen">
                                <option value="">Pilih dokumen</option>
                                <option value="PO-2024-0512">PO-2024-0512</option>
                                <option value="PO-2024-0498">PO-2024-0498</option>
                                <option value="Manual">Input Manual</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="field-label">No. Dokumen <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="st_no_dokumen" placeholder="Masukkan nomor dokumen">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Tanggal Dokumen <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="st_tgl_dokumen">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="field-label">Keterangan (Opsional)</label>
                            <textarea class="form-control" rows="3" id="st_keterangan" maxlength="250" placeholder="Masukkan keterangan (opsional)"></textarea>
                            <div class="text-right" style="font-size:.75rem; color:var(--ob-muted);"><span id="st_keterangan_count">0</span> / 250</div>
                        </div>
                    </div>
                </div>

                <div id="stock_step_2" class="stock-step-pane ob-card" style="display:none;">
                    <h5 style="font-weight:700; font-size:1.1rem; margin-bottom:1.5rem; color:var(--ob-text);">Batch &amp; Expired</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="field-label">No. Batch <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="st_no_batch" placeholder="Contoh: B240901">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Satuan Batch</label>
                            <input type="text" class="form-control" id="st_batch_satuan" value="TAB" readonly style="background:var(--ob-bg-soft);">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Tanggal Produksi <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="st_tgl_produksi">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Tanggal Expired <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="st_tgl_expired">
                        </div>
                    </div>

                    <div class="info-box-blue mt-2">
                        <i class="fas fa-info-circle mt-1"></i>
                        <div>
                            <strong>Informasi</strong>
                            <ul style="padding-left:1.2rem; margin-bottom:0; margin-top:.3rem; font-size:.85rem;">
                                <li>Status batch (Aman / Hampir Expired / Expired) akan dihitung otomatis dari Tanggal Expired.</li>
                                <li>Pastikan nomor batch belum pernah digunakan sebelumnya untuk obat ini.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div id="stock_step_3" class="stock-step-pane ob-card" style="display:none;">
                    <h5 style="font-weight:700; font-size:1.1rem; margin-bottom:1.5rem; color:var(--ob-text);">Detail Stock</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Jumlah Stok Masuk <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="st_jumlah" min="1" placeholder="0">
                                <div class="input-group-append"><span class="input-group-text" id="st_jumlah_satuan">TAB</span></div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Stok Minimum (Warehouse ini)</label>
                            <input type="number" class="form-control" id="st_stok_min" min="0" placeholder="0">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Harga Beli / Unit (HPP)</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                                <input type="text" class="form-control text-right" id="st_hpp" placeholder="0">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="field-label">Total Nilai Stok</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                                <input type="text" class="form-control text-right" id="st_total_nilai" value="0" readonly style="background:var(--ob-bg-soft);">
                            </div>
                        </div>
                    </div>

                    <div class="tips-box mt-2">
                        <div style="font-weight:700; margin-bottom:.5rem;"><i class="far fa-lightbulb text-warning mr-1"></i> Catatan</div>
                        <ul style="font-size:.8rem; color:var(--ob-text); margin-bottom:0;">
                            <li>Total Nilai Stok dihitung otomatis: Jumlah Stok Masuk × Harga Beli / Unit.</li>
                            <li>Stok Minimum digunakan sebagai acuan notifikasi stok menipis.</li>
                        </ul>
                    </div>
                </div>

                <div id="stock_step_4" class="stock-step-pane ob-card" style="display:none;">
                    <h5 style="font-weight:700; font-size:1.1rem; margin-bottom:1.5rem; color:var(--ob-text);">Konfirmasi</h5>
                    <div class="info-box-blue">
                        <i class="fas fa-check-circle mt-1"></i>
                        <div>
                            <strong>Apakah data sudah benar?</strong>
                            <div style="font-size:.85rem;">Periksa kembali data di bawah ini sebelum menyimpan stok baru.</div>
                        </div>
                    </div>

                    <div style="background:var(--ob-bg-soft); border-radius:.5rem; padding:1rem; margin-top:1rem;">
                        <div class="row">
                            <div class="col-6 mb-2"><span style="color:var(--ob-muted);">Obat</span></div>
                            <div class="col-6 mb-2 text-right font-weight-bold" id="cf_obat" style="color:var(--ob-text);">-</div>
                            <div class="col-6 mb-2"><span style="color:var(--ob-muted);">Warehouse</span></div>
                            <div class="col-6 mb-2 text-right font-weight-bold" id="cf_warehouse" style="color:var(--ob-text);">-</div>
                            <div class="col-6 mb-2"><span style="color:var(--ob-muted);">Bin / Lokasi</span></div>
                            <div class="col-6 mb-2 text-right font-weight-bold" id="cf_bin" style="color:var(--ob-text);">-</div>
                            <div class="col-6 mb-2"><span style="color:var(--ob-muted);">Tipe Transaksi</span></div>
                            <div class="col-6 mb-2 text-right font-weight-bold" id="cf_tipe" style="color:var(--ob-text);">-</div>
                            <div class="col-6 mb-2"><span style="color:var(--ob-muted);">No. Dokumen</span></div>
                            <div class="col-6 mb-2 text-right font-weight-bold" id="cf_nodok" style="color:var(--ob-text);">-</div>
                            <div class="col-6 mb-2"><span style="color:var(--ob-muted);">No. Batch</span></div>
                            <div class="col-6 mb-2 text-right font-weight-bold" id="cf_batch" style="color:var(--ob-text);">-</div>
                            <div class="col-6 mb-2"><span style="color:var(--ob-muted);">Tanggal Expired</span></div>
                            <div class="col-6 mb-2 text-right font-weight-bold" id="cf_expired" style="color:var(--ob-text);">-</div>
                            <div class="col-6 mb-2"><span style="color:var(--ob-muted);">Jumlah Stok Masuk</span></div>
                            <div class="col-6 mb-2 text-right font-weight-bold" id="cf_jumlah" style="color:var(--ob-text);">-</div>
                            <div class="col-6"><span style="color:var(--ob-muted);">Total Nilai Stok</span></div>
                            <div class="col-6 text-right font-weight-bold text-success" id="cf_nilai" style="color:#198754;">-</div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3" style="border-top:1px solid var(--ob-border); display:flex; justify-content:space-between; align-items:center;">
                    <button class="btn-ob-outline" id="btn_stock_prev"><i class="fas fa-arrow-left mr-1"></i> Sebelumnya</button>
                    <button class="btn-ob-primary" id="btn_stock_next">Lanjutkan <i class="fas fa-arrow-right ml-1"></i></button>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="ob-card">
                    <h6 style="font-weight:700; font-size:1rem; margin-bottom:1rem; color:var(--ob-text);">Ringkasan Obat</h6>
                    <div class="d-flex align-items-center mb-2 p-3" style="background:var(--ob-bg-soft); border-radius:.5rem;">
                        <i class="fas fa-capsules mr-3" style="font-size:1.6rem; color:var(--ob-blue);"></i>
                        <div>
                            <div style="font-weight:700; font-size:.9rem; color:var(--ob-text);" id="rg_kode">OBT-000123</div>
                            <div style="font-weight:600; font-size:.85rem; color:var(--ob-text);" id="rg_nama">Paracetamol 500 mg Tablet</div>
                            <div style="font-size:.75rem; color:var(--ob-muted);" id="rg_detail">Tablet / 500 mg | TAB (Tablet)</div>
                            <div style="font-size:.75rem; color:var(--ob-muted);" id="rg_kemasan">Kemasan: 1 strip @ 10 tablet</div>
                        </div>
                    </div>
                </div>

                <div class="ob-card">
                    <h6 style="font-weight:700; font-size:1rem; margin-bottom:1rem; color:var(--ob-text);">Informasi Satuan</h6>
                    <table class="table table-sm table-borderless" style="font-size:.85rem;">
                        <tr><td class="pl-0" style="color:var(--ob-muted);">Base UOM</td><td class="text-right pr-0 font-weight-bold" style="color:var(--ob-text);">TAB (Tablet)</td></tr>
                        <tr><td class="pl-0" style="color:var(--ob-muted);">Kemasan</td><td class="text-right pr-0 font-weight-bold" style="color:var(--ob-text);">1 strip @ 10 tablet</td></tr>
                        <tr><td class="pl-0" style="color:var(--ob-muted);">Isi per Kemasan</td><td class="text-right pr-0 font-weight-bold" style="color:var(--ob-text);">10 Tablet</td></tr>
                        <tr><td class="pl-0" style="color:var(--ob-muted);">UOM Pembelian</td><td class="text-right pr-0 font-weight-bold" style="color:var(--ob-text);">STRIP</td></tr>
                    </table>
                    <div style="font-size:.8rem; color:var(--ob-text); background:var(--ob-bg-soft); border-radius:.4rem; padding:.5rem .8rem; margin-top:.3rem;">
                        Konversi ke Base UOM: <strong>1 STRIP = 10 TAB</strong>
                    </div>
                </div>

                <div class="ob-card">
                    <div class="info-box-blue">
                        <i class="fas fa-info-circle mt-1"></i>
                        <div>
                            <strong>Tips</strong>
                            <div style="font-size:.85rem;">Pastikan informasi obat, warehouse, dan dokumen sudah benar sebelum melanjutkan.</div>
                        </div>
                    </div>
                </div>

                <div class="ob-card mb-0">
                    <div class="tips-box">
                        <div style="font-weight:700; margin-bottom:.5rem;"><i class="far fa-lightbulb text-warning mr-1"></i> Catatan</div>
                        <ul style="font-size:.8rem; color:var(--ob-text); margin-bottom:0;">
                            <li>Stok akan bertambah setelah transaksi disimpan.</li>
                            <li>Pastikan batch dan expired date diisi dengan benar pada langkah berikutnya.</li>
                            <li>Pilih bin/lokasi untuk memudahkan penelusuran stok.</li>
                        </ul>
                    </div>
                </div>

                <div class="text-right mt-3">
                    <button class="btn btn-light border btn-batal-stock mr-2" style="font-weight:600; padding:.4rem 1.5rem; background:var(--ob-card-bg); border-color:var(--ob-border); color:var(--ob-text);"><i class="fas fa-times mr-1"></i> Batalkan</button>
                    <button class="btn-ob-primary" id="btn_simpan_stock_bawah" style="padding:.4rem 1.5rem;"><i class="fas fa-save mr-1"></i> Simpan Stock</button>
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

    function loadObatDropdowns() {
        $.ajax({
            url: "<?= site_url('tmstobatbaru/getKategoriDropdown') ?>",
            method: 'GET', dataType: 'JSON',
            success: function (r) {
                if (r.status !== 'success') return;
                var $sel = $('#inp_kategori_id').empty().append('<option value="">Pilih kategori</option>');
                (r.data || []).forEach(function (i) { $sel.append('<option value="' + i.id + '">' + i.text + '</option>'); });
            }
        });
        $.ajax({
            url: "<?= site_url('tmstobatbaru/getGroupDropdown') ?>",
            method: 'GET', dataType: 'JSON',
            success: function (r) {
                if (r.status !== 'success') return;
                var $sel = $('#inp_group_id').empty().append('<option value="">Pilih group</option>');
                (r.data || []).forEach(function (i) { $sel.append('<option value="' + i.id + '">' + i.text + '</option>'); });
            }
        });
        $.ajax({
            url: "<?= site_url('tmstobatbaru/getSatuanDropdown') ?>",
            method: 'GET', dataType: 'JSON',
            success: function (r) {
                if (r.status !== 'success') return;
                var $sel = $('#inp_base_uom_id').empty().append('<option value="">Pilih satuan dasar</option>');
                (r.data || []).forEach(function (i) { $sel.append('<option value="' + i.id + '">' + i.text + '</option>'); });
            }
        });
        $.ajax({
            url: "<?= site_url('tmstobatbaru/getFixedEnums') ?>",
            method: 'GET', dataType: 'JSON',
            success: function (r) {
                if (r.status !== 'success') return;
                var $route = $('#dd_route').empty();
                (r.route || []).forEach(function (i) {
                    $('#dd_route').append('<option value="' + i.id + '">' + i.text + '</option>');
                });
                var $reg = $('#dd_regulation').empty();
                (r.regulationClass || []).forEach(function (i) {
                    $reg.append('<option value="' + i.id + '">' + i.text + '</option>');
                });
            }
        });
        $.ajax({
            url: "<?= site_url('tmstobatbaru/getDosageFormDropdown') ?>",
            method: 'GET', dataType: 'JSON',
            success: function (r) {
                if (r.status !== 'success') return;
                var $dosage = $('#dd_dosage').empty();
                (r.data || []).forEach(function (i) { $dosage.append('<option value="' + i.id + '">' + i.text + '</option>'); });
            }
        });
        $.ajax({
            url: "<?= site_url('tmstobatbaru/getKelasHargaDropdown') ?>",
            method: 'GET', dataType: 'JSON',
            success: function (r) {
                if (r.status !== 'success') return;
                var $kelas = $('#h_price_class').empty().append('<option value="">Pilih Price Class</option>');
                (r.data || []).forEach(function (i) { $kelas.append('<option value="' + i.id + '">' + i.text + '</option>'); });
            }
        });
    }
    loadObatDropdowns();

    function loadObatSummary() {
        $.ajax({
            url: "<?= site_url('tmstobatbaru/getSummary') ?>",
            method: 'GET',
            dataType: 'JSON',
            success: function (d) {
                if (d.status !== 'success') return;
                $('#ob_sum_total').text(d.total || 0);
                $('#ob_sum_aktif').text(d.aktif || 0);
                $('#ob_sum_aktif_sub').text((d.pctAktif || 0) + '% dari total');
                $('#ob_sum_batch').text(d.batchTracked || 0);
                $('#ob_sum_expired').text(d.expiringSoon || 0);
                $('#ob_sum_stok').text(d.stokHabis || 0);
            }
        });
    }
    loadObatSummary();

    $('#inp_group_id').on('change', function () {
        var groupId = $(this).val();
        var $sub = $('#inp_sub_group_id').empty().append('<option value="">Pilih sub group (opsional)</option>');
        if (!groupId) return;
        $.ajax({
            url: "<?= site_url('tmstobatbaru/getSubGroupDropdown') ?>",
            method: 'GET', data: { groupId: groupId }, dataType: 'JSON',
            success: function (r) {
                if (r.status !== 'success') return;
                (r.data || []).forEach(function (i) { $sub.append('<option value="' + i.id + '">' + i.text + '</option>'); });
            }
        });
    });

    var table = $('#obatTable').DataTable({
        processing: true, 
        serverSide: true, 
        responsive: false, 
        autoWidth: false,
        dom: 'Brt<"dt-footer-wrapper"lip>',
        buttons: [
            {
                extend: 'excel',
                text: 'Export',
                className: 'd-none',
                title: 'Data Obat',
                exportOptions: { columns: [1, 2, 3, 4, 5, 6, 7, 8] }
            }
        ],
        pageLength: 10,
        ajax: {
            url: "<?= site_url('tmstobatbaru/datatables') ?>", 
            type: 'POST', 
            contentType: 'application/json',
            data: function (d) {
                d.cari = $('#f_cari').val();
                d.status = $('#f_status').val();
                d.kategori = $('#f_kategori').val();
                d.group = $('#f_group').val();
                d.bentuk = $('#f_bentuk').val();
                d.resep = $('#f_resep').val();
                d.batch = $('#f_batch').val();
                d.expired = $('#f_expired').val();
                return JSON.stringify(d);
            }
        },
        columns: [
            { data: 'checkbox', orderable: false, className: 'text-center' },
            { data: 'kodeLink' }, 
            { data: 'nama' }, 
            { data: 'generic' },
            { data: 'bentuk' },
            { data: 'strength' },
            { data: 'resep_badge', orderable: false, className: 'text-center' },
            { data: 'stok', className: 'text-center' },
            { data: 'expired_badge', orderable: false, className: 'text-center' },
            { data: 'statusBadge', orderable: false, className: 'text-center' },
            { data: 'aksi', orderable: false, className: 'text-center' }
        ],
        language: { 
            sInfo: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data", 
            sInfoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
            sInfoFiltered: "(difilter dari _MAX_ total data)",
            oPaginate: { 
                sPrevious: "<i class='fas fa-angle-left'></i>", 
                sNext: "<i class='fas fa-angle-right'></i>" 
            } 
        },
        drawCallback: function(settings) {
            var api = this.api();
            var info = api.page.info();
            $('#table_info_text').text('Menampilkan ' + (info.start + 1) + ' - ' + info.end + ' dari ' + info.recordsTotal + ' data');
        }
    });

    $('#f_cari, #f_kategori, #f_group, #f_bentuk, #f_resep, #f_status, #f_batch, #f_expired').on('change keyup', function() { 
        table.ajax.reload(); 
    });

    $('#f_per_page').on('change', function() {
        table.page.len(parseInt($(this).val())).draw();
    });

    $('#btn_reset').click(function() { 
        $('#f_cari, #f_kategori, #f_group, #f_bentuk, #f_resep, #f_status, #f_batch, #f_expired, #f_batch_dropdown, #f_expired_dropdown, #f_resep_dropdown').val(''); 
        table.ajax.reload(); 
    });

    $('#btn_filter_lainnya').click(function(e) {
        e.stopPropagation();
        $('#filterDropdownMenu').toggleClass('show');
    });

    $(document).click(function(e) {
        if (!$(e.target).closest('.filter-dropdown').length) {
            $('#filterDropdownMenu').removeClass('show');
        }
    });

    $('#f_batch_dropdown, #f_expired_dropdown, #f_resep_dropdown').on('change', function() {
        var id = $(this).attr('id').replace('_dropdown', '');
        $('#' + id).val($(this).val());
    });

    $('#btn_apply_filter').click(function() {
        $('#filterDropdownMenu').removeClass('show');
        table.ajax.reload();
    });

    function openObat(itemCode, mode) {
        if (!itemCode) return;
        $.ajax({
            url: "<?= site_url('tmstobatbaru/fetchSingleData') ?>",
            method: 'GET',
            data: { itemCode: itemCode },
            dataType: 'JSON',
            success: function(response) {
                if (!checkSession(response)) return;
                if (response.status === 'error' || !response.data) {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: response.message || 'Data tidak ditemukan' });
                    return;
                }
                var d = response.data;
                var isView = (mode === 'View');
                resetWizard();

                window.currentItemCode = d.itemCode;
                window.isEditMode = !isView;
                window.isViewMode = isView;

                $('#inp_kode').val(d.itemCode || '').prop('disabled', true);
                $('#inp_nama').val(d.itemName || '').prop('readonly', isView);
                $('#inp_barcode').val(d.barcode || '').prop('readonly', isView);
                $('#inp_aturan').val(d.defaultDosageInstruction || '').prop('readonly', isView);

                if (d.itemCategoryId) $('#inp_kategori_id').val(d.itemCategoryId);
                if (d.itemGroupId) {
                    $('#inp_group_id').val(d.itemGroupId);
                    if (d.itemSubGroupId) {
                        $.ajax({
                            url: "<?= site_url('tmstobatbaru/getSubGroupDropdown') ?>",
                            method: 'GET', data: { groupId: d.itemGroupId }, dataType: 'JSON',
                            success: function (r) {
                                var $sub = $('#inp_sub_group_id').empty().append('<option value="">Pilih sub group (opsional)</option>');
                                (r.data || []).forEach(function (i) { $sub.append('<option value="' + i.id + '">' + i.text + '</option>'); });
                                $sub.val(d.itemSubGroupId || '');
                            }
                        });
                    } else {
                        $('#inp_group_id').trigger('change');
                    }
                }
                if (d.baseUomId) $('#inp_base_uom_id').val(d.baseUomId);

                window.currentItemImageUrl = d.itemImageUrl || '';
                renderImagePreview();

                $('#chk_stock').prop('checked', d.isStockItem).prop('disabled', isView);
                $('#chk_purchase').prop('checked', d.isPurchaseItem).prop('disabled', isView);
                $('#chk_batch').prop('checked', d.isBatchTracked).prop('disabled', isView);
                $('#chk_sale').prop('checked', d.isSaleItem).prop('disabled', isView);
                $('#chk_returnable').prop('checked', !!d.isReturnableItem).prop('disabled', isView);
                $('#chk_controlled').prop('checked', !!d.isControlledItem).prop('disabled', isView);
                $('#chk_expired').prop('checked', d.isExpiredTracked).prop('disabled', isView);
                $('#chk_resep').prop('checked', d.isPrescriptionRequired).prop('disabled', isView);
                $('#chk_active').prop('checked', d.isActive).prop('disabled', isView);

                $('#lbl_kode_preview').text(d.itemCode || 'OBT-...');
                $('#lbl_nama_preview').text(d.itemName || '-');
                $('#lbl_generic_preview').text(d.genericName || '-');
                $('#lbl_strength_preview').text(d.strength || '-');
                $('#lbl_dosage_preview').text(d.categoryName || '-');
                $('#lbl_route_preview').text(d.route || '-');
                $('#lbl_status_preview').text(d.isActive ? 'Aktif' : 'Non Aktif');
                $('#lbl_uom_preview').text(d.uomName || '-');
                $('#lbl_barcode_preview').text(d.barcode || '-');

                if (isView) {
                    $('#view_form').find('input, select, textarea').prop('disabled', true);
                    $('#view_form .ob-switch input').prop('disabled', true);
                    $('#view_form .page-title').text('Lihat Obat');
                    $('#view_form .page-subtitle').text('Detail data obat');
                    $('#view_form .btn-batal-obat').off('click').click(function() {
                        window.isViewMode = false;
                        $('#view_form').hide();
                        $('#view_main').fadeIn();
                        resetWizard();
                    });
                } else {
                    $('#view_form .page-title').text(d.itemId ? 'Ubah Obat' : 'Tambah Obat');
                    $('#view_form .page-subtitle').text('Lengkap informasi obat dengan benar');
                }

                $('#view_main').hide();
                $('#view_form').fadeIn();
                goToStep(1);
                updateStepLockUI();
                if (!isView || window.currentItemCode) {
                    loadDrugDetail(); 
                }
            },
            error: function() {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal mengambil data dari server.' });
            }
        });
    }

    $(document).on('click', '#obatTable_wrapper .btn-icon-ob.view', function(e) {
        e.preventDefault();
        openObat($(this).data('code'), 'View');
    });

    $(document).on('click', '#obatTable_wrapper .btn-icon-ob.edit', function(e) {
        e.preventDefault();
        openObat($(this).data('code'), 'Edit');
    });

    $(document).on('click', '#obatTable_wrapper .btn-icon-ob.delete', function(e) {
        e.preventDefault();
        var $btn = $(this);
        var itemCode = $btn.data('code');
        Swal.fire({
            title: 'Yakin ingin menghapus data?',
            text: 'Data obat "' + ($btn.closest('tr').find('td').eq(2).text() || itemCode) + '" akan dihapus.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('tmstobatbaru/delete') ?>",
                    method: 'POST',
                    data: { itemCode: itemCode },
                    dataType: 'JSON',
                    success: function(response) {
                        if (!checkSession(response)) return;
                        if (response.status === 'error') {
                            Swal.fire({ icon: 'error', title: 'Gagal', text: response.message || 'Gagal menghapus data.' });
                        } else {
                            Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message || 'Data berhasil dihapus.' });
                            table.ajax.reload(null, false);
                        }
                    },
                    error: function() {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal menghubungi server.' });
                    }
                });
            }
        });
    });

    $('#btn_tambah_obat').click(function() {
        $('#view_main').hide();
        $('#view_form').fadeIn();
        resetWizard();
    });

    $('#btn_export').click(function() {
        table.button(0).trigger();
    });

    $('.btn-batal-obat').click(function() {
        $('#view_form').hide();
        $('#view_main').fadeIn();
    });

    let currentStep = 1;
    const totalSteps = 6;

    window.currentItemCode = null;
    window.isEditMode = false;
    window.isViewMode = false;

    goToStep(currentStep);
    updateStepLockUI();

    function applyViewMode() {
        if (!window.isViewMode) return;
        $('#btn_wizard_next, #btn_wizard_save, #btn_wizard_cancel').hide();
        $('button[id^="btn_next_"], button[id^="btn_prev_"]').hide();
        $('#btn_tambah_uom, #btn_tambah_harga, #btn_tambah_supplier, #btn_tambah_dokumen, #btn_tambah_stock').hide();
        $('#btn_refresh_stock, #btn_cetak_label').hide();
        $('#view_form .btn-icon-ob.delete, #view_form .btn-icon-ob.edit').hide();
        $('#view_form').find('.aksi-cell .btn-icon-ob').hide();
        $('#view_form .btn-batal-obat:not(.btn-sm)').hide();
        $('#view_form .btn-batal-uom, #view_form .btn-batal-harga, #view_form .btn-batal-supplier, #view_form .btn-batal-dokumen, #view_form .btn-batal-stock').hide();
        $('#view_form .btn-ob-outline').each(function() {
            if ($(this).closest('.wizard-header').length === 0) {
                $(this).hide();
            }
        });
        $('#view_form #btn_simpan_uom, #view_form #btn_simpan_uom_bawah').hide();
        $('#view_form #btn_simpan_harga, #view_form #btn_simpan_harga_bawah').hide();
        $('#view_form #btn_simpan_supplier, #view_form #btn_simpan_supplier_bawah').hide();
        $('#view_form #btn_simpan_dokumen, #view_form #btn_simpan_dokumen_bawah').hide();
    }

    function goToStep(step) {
        $('.tab-pane').removeClass('active');
        $('#step_' + step).addClass('active');
        $('.step-item').removeClass('active done');
        $('.step-item').each(function() {
            let s = parseInt($(this).data('step'));
            if (s < step) $(this).addClass('done');
            if (s === step) $(this).addClass('active');
        });
        currentStep = step;

        $('[id^="btn_prev_"]').hide();
        $('[id^="btn_next_"]').hide();
        if (step > 1) $('#btn_prev_' + step).show();
        if (step < totalSteps) $('#btn_next_' + step).show();

        if (step === totalSteps) {
            $('#btn_wizard_next').hide();
            $('#btn_wizard_save').show();
        } else {
            $('#btn_wizard_next').show();
            $('#btn_wizard_save').hide();
        }

        if (step === 4 || step === 5 || step === 6 || step === 7) {
            $('#sidebar_ringkasan').hide();
            $('#step_content_col').removeClass('col-lg-8').addClass('col-lg-12');
        } else {
            $('#sidebar_ringkasan').show();
            $('#step_content_col').removeClass('col-lg-12').addClass('col-lg-8');
        }

        if (window.currentItemCode) {
            loadStepData(step);
        }

        applyViewMode();
    }

    function updateStepLockUI() {
        var locked = !window.currentItemCode;
        $('.step-item').each(function() {
            var s = parseInt($(this).data('step'));
            if (s > 1) {
                $(this).toggleClass('locked', locked);
                $(this).css('opacity', locked ? '0.45' : '1');
                $(this).css('pointer-events', locked ? 'none' : 'auto');
            }
        });
    }

    function loadStepData(step) {
        switch (step) {
            case 2: loadDrugDetail(); break;
            case 3: loadUOM(); break;
            case 4: loadHarga(); break;
            case 5: loadSupplier(); break;
            case 6: loadStock(); break;
            case 7: loadDokumen(); break;
        }
    }

    $('[id^="btn_next_"]').click(function() {
        if (currentStep === 1) {
            submitStep1ThenGoNext();
            return;
        }
        if (currentStep === 2) {
            submitStep2ThenGoNext();
            return;
        }
        if (currentStep < totalSteps) {
            goToStep(currentStep + 1);
        }
    });

    $('[id^="btn_prev_"]').click(function() {
        if (currentStep > 1) goToStep(currentStep - 1);
    });

    $('.step-item').click(function() {
        var target = parseInt($(this).data('step'));
        if (target > 1 && !window.currentItemCode) {
            Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Simpan Informasi Umum (Step 1) terlebih dahulu sebelum melanjutkan.' });
            return;
        }
        goToStep(target);
    });

    function submitStep1ThenGoNext() {
        if (!$('#inp_nama').val()) { Swal.fire({ icon: 'error', title: 'Gagal', text: 'Nama Obat harus diisi' }); return; }
        if (!$('#inp_base_uom_id').val()) { Swal.fire({ icon: 'error', title: 'Gagal', text: 'Satuan Dasar harus dipilih' }); return; }

        var $btn = $('#btn_next_1, #btn_wizard_next').filter(':visible');
        var originalHtml = $btn.html();
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan...');

        var payload = {
            action: window.isEditMode ? 'Edit' : 'Add',
            hidden_code: window.currentItemCode || '',
            inp_kode: $('#inp_kode').val(),
            inp_nama: $('#inp_nama').val(),
            inp_kategori_id: null,
            inp_group_id: null,
            inp_sub_group_id: null,
            inp_base_uom_id: $('#inp_base_uom_id').val(),
            inp_barcode: $('#inp_barcode').val() || '',
            inp_image_url: window.currentItemImageFileName ? ('PENDING:' + window.currentItemImageFileName) : '',
            chk_stock: $('#chk_stock').is(':checked') ? '1' : '0',
            chk_purchase: $('#chk_purchase').is(':checked') ? '1' : '0',
            chk_batch: $('#chk_batch').is(':checked') ? '1' : '0',
            chk_sale: $('#chk_sale').is(':checked') ? '1' : '0',
            chk_expired: $('#chk_expired').is(':checked') ? '1' : '0',
            chk_resep: $('#chk_resep').is(':checked') ? '1' : '0',
            chk_returnable: $('#chk_returnable').is(':checked') ? '1' : '0',
            chk_controlled: $('#chk_controlled').is(':checked') ? '1' : '0',
            chk_active: $('#chk_active').is(':checked') ? '1' : '0',
            };

        $.ajax({
            url: "<?= site_url('tmstobatbaru/action') ?>",
            type: 'POST',
            data: payload,
            dataType: 'json',
            success: function(response) {
                $btn.prop('disabled', false).html(originalHtml);

                if (response.error) {
                    var msg = Object.values(response.error).join('\n');
                    Swal.fire({ icon: 'error', title: 'Gagal', text: msg });
                    return;
                }

                if (response.status === 'success') {
                    window.currentItemCode = response.itemCode;
                    window.currentBaseUomId = $('#inp_base_uom_id').val();
                    window.isEditMode = true; 
                    updateStepLockUI();
                    $('#inp_kode').val(response.itemCode).prop('disabled', true); 
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message || 'Informasi Umum berhasil disimpan.' });
                    goToStep(2);
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: response.message || 'Gagal menyimpan Informasi Umum.' });
                }
            },
            error: function(xhr) {
                $btn.prop('disabled', false).html(originalHtml);
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan koneksi ke server. Cek endpoint /tmstobatbaru/checkConnection untuk diagnosa.' });
                console.error('submitStep1 error:', xhr.responseText);
            }
        });
    }

    function submitStep2ThenGoNext() {
        if (!window.currentItemCode) {
            Swal.fire({ icon: 'error', title: 'Gagal', text: 'Simpan Informasi Umum (Step 1) terlebih dahulu.' });
            return;
        }

        if (!$('#dd_generic').val().trim()) {
            Swal.fire({ icon: 'error', title: 'Gagal', text: 'Generic Name harus diisi' });
            return;
        }
        if (!$('#dd_regulation').val()) {
            Swal.fire({ icon: 'error', title: 'Gagal', text: 'Drug Regulation Class harus dipilih' });
            return;
        }
        if (!$('#dd_dosage').val()) {
            Swal.fire({ icon: 'error', title: 'Gagal', text: 'Dosage Form harus dipilih' });
            return;
        }
        var $btn = $('#btn_next_2, #btn_wizard_next').filter(':visible');
        var originalHtml = $btn.html();
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan...');

        $.ajax({
            url: "<?= site_url('tmstobatbaru/saveDrugDetail') ?>/" + window.currentItemCode,
            type: 'POST',
            data: $('#form_drug_detail').serialize() + '&dd_aturan=' + encodeURIComponent($('#inp_aturan').val() || ''),
            dataType: 'json',
            success: function(response) {
                $btn.prop('disabled', false).html(originalHtml);
                if (response.status === 'success') {
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message });
                    goToStep(3);
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: response.message || 'Gagal menyimpan Drug Detail.' });
                }
            },
            error: function() {
                $btn.prop('disabled', false).html(originalHtml);
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan koneksi ke server.' });
            }
        });
    }

    $('#btn_wizard_save').click(function() {

        if (!window.currentItemCode) {
            Swal.fire({ icon: 'error', title: 'Gagal', text: 'Data obat belum tersimpan. Selesaikan Step 1 terlebih dahulu.' });
            return;
        }
        Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Obat berhasil disimpan!' });
        $('#view_form').hide();
        $('#view_main').fadeIn();
        table.ajax.reload();
    });

    $('#btn_wizard_cancel').click(function() {
        $('#view_form').hide();
        $('#view_main').fadeIn();
        Swal.fire({ icon: 'info', title: 'Info', text: 'Data obat dibatalkan.' });
    });

    function resetWizard() {
        window.currentItemCode = null;
        window.isEditMode = false;
        window.isViewMode = false;
        goToStep(1);
        updateStepLockUI();

        $('#view_form').find('input, select, textarea').prop('disabled', false);
        $('#view_form .ob-switch input').prop('disabled', false);
        $('#inp_kode').prop('disabled', true); 

        $('#btn_wizard_next, #btn_wizard_save, #btn_wizard_cancel').show();
        $('button[id^="btn_next_"], button[id^="btn_prev_"]').show();
        $('#btn_tambah_uom, #btn_tambah_harga, #btn_tambah_supplier, #btn_tambah_dokumen, #btn_tambah_stock').show();
        $('#btn_refresh_stock, #btn_cetak_label').show();
        $('#view_form .btn-icon-ob.delete, #view_form .btn-icon-ob.edit').show();
        $('#view_form').find('.aksi-cell .btn-icon-ob').show();
        $('#view_form .btn-batal-obat:not(.btn-sm)').show();
        $('#view_form .btn-batal-uom, #view_form .btn-batal-harga, #view_form .btn-batal-supplier, #view_form .btn-batal-dokumen, #view_form .btn-batal-stock').show();
        $('#view_form .btn-ob-outline').show();
        $('#view_form #btn_simpan_uom, #view_form #btn_simpan_uom_bawah').show();
        $('#view_form #btn_simpan_harga, #view_form #btn_simpan_harga_bawah').show();
        $('#view_form #btn_simpan_supplier, #view_form #btn_simpan_supplier_bawah').show();
        $('#view_form #btn_simpan_dokumen, #view_form #btn_simpan_dokumen_bawah').show();

        $('#lbl_kode_preview').text('OBT-...');
        $('#lbl_nama_preview').text('Belum ada data');
        $('#lbl_generic_preview').text('-');
        $('#lbl_strength_preview').text('-');
        $('#lbl_dosage_preview').text('-');
        $('#lbl_route_preview').text('-');
        $('#lbl_status_preview').text('-');
        $('#lbl_uom_preview').text('-');
        $('#lbl_barcode_preview').text('-');
        window.currentItemImageUrl = '';
        window.currentItemImageFile = null;
        window.currentItemImageFileName = '';
        $('#image_preview_wrap').html('');
        $('#form_general')[0]?.reset();
        $('#form_drug_detail')[0]?.reset();
        $('#dd_dosage, #dd_route, #dd_drug_class, #dd_therapeutic, #dd_regulation').val('').trigger('change');

        $('#dd_special, #dd_manufacturer, #dd_reg_date, #dd_reg_exp, #dd_shelf').val('');
    }

    function loadDrugDetail() {
        if (!window.currentItemCode) return;
        $.ajax({
            url: "<?= site_url('tmstobatbaru/drugDetail') ?>/" + window.currentItemCode,
            type: 'GET',
            success: function(response) {
                if (response.status === 'success' && response.data) {
                    var d = response.data;
                    $('#dd_generic').val(d.genericName || '');
                    $('#dd_brand').val(d.brandName || '');
                    $('#dd_strength').val(d.strength || '');
                    $('#dd_dosage').val(d.dosageForm || '').trigger('change');
                    $('#dd_route').val(d.route || '').trigger('change');
                    $('#dd_drug_class').val(d.drugClass || '').trigger('change');
                    $('#dd_therapeutic').val(d.therapeuticClass || '').trigger('change');
                    $('#dd_regulation').val(d.drugRegulationClass || '').trigger('change');
                    $('#dd_atc').val(d.atcCode || '');
                    $('#dd_kfa').val(d.kfaCode || '');
                    $('#dd_composition').val(d.composition || '');
                    $('#dd_indication').val(d.indication || '');
                    $('#dd_contra').val(d.contraIndication || '');
                    $('#dd_side').val(d.sideEffect || '');
                    $('#dd_storage').val(d.storageInstruction || '');
                    $('#inp_aturan').val(d.defaultUsageInstruction || '');
                    $('#dd_reg_no').val(d.registrationNo || '');

                    if (d.genericName) $('#lbl_generic_preview').text(d.genericName);
                    if (d.strength) $('#lbl_strength_preview').text(d.strength);
                    if (d.dosageForm) $('#lbl_dosage_preview').text(d.dosageForm);
                    if (d.route) $('#lbl_route_preview').text(d.route);

                    applyViewMode();
                }
            },
            error: function() {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal memuat Drug Detail. Cek koneksi API.' });
            }
        });
    }

    function loadUOM() {
        if (!window.currentItemCode) {
            $('#uomBody').html('<tr><td colspan="9" class="text-center text-muted py-3">Simpan Informasi Umum terlebih dahulu.</td></tr>');
            $('#uomCount').text(0);
            return;
        }
        $.ajax({
            url: "<?= site_url('tmstobatbaru/uomConversion') ?>/" + window.currentItemCode,
            type: 'GET',
            success: function(response) {
                if (response.status === 'success') {
                    var html = '';
                    $.each(response.data, function(i, item) {
                        var baseClass = item.base ? 'uom-base-row' : '';
                        html += '<tr class="' + baseClass + '">';
                        html += '<td class="text-center">' + (i + 1) + '</td>';
                        html += '<td><strong>' + item.uom + '</strong></td>';
                        html += '<td>' + item.deskripsi + '</td>';
                        html += '<td class="text-right">' + item.faktor + '</td>';
                        html += '<td>' + item.isi + '</td>';
                        html += '<td class="text-center">' + (item.purchase ? '<i class="fas fa-check text-success"></i>' : '-') + '</td>'; 
                        html += '<td class="text-center">' + (item.sales ? '<i class="fas fa-check text-success"></i>' : '-') + '</td>'; 
                        html += '<td class="text-center">' + (item.aktif ? '<span class="badge-ob-aktif">Aktif</span>' : '<span class="badge-ob-nonaktif">Non-Aktif</span>') + '</td>';
                        html += '<td class="text-center">';
                        if (!item.base) {
                            html += '<button class="btn-icon-ob edit" data-id="' + item.id + '" title="Edit"><i class="fas fa-edit"></i></button> ';
                            html += '<button class="btn-icon-ob delete" data-id="' + item.id + '" title="Hapus"><i class="fas fa-trash"></i></button>';
                        }
                        html += '</td></tr>';
                    });
                    $('#uomBody').html(html);
                    $('#uomCount').text(response.data.length);
                    applyViewMode();
                }
            },
            error: function() {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal memuat data UOM. Cek koneksi API.' });
            }
        });
    }

    loadUOM();

    $('#btn_tambah_uom').click(function() {
        $('#view_form').hide();
        $('#view_uom_form').fadeIn();
        window.currentUomId = '';
        $.ajax({
            url: "<?= site_url('tmstobatbaru/getSatuanDropdown') ?>",
            method: 'GET', dataType: 'JSON',
            success: function (r) {
                if (r.status !== 'success') return;
                var $sel = $('#uom_id_master').empty().append('<option value="">Pilih satuan</option>');
                (r.data || []).forEach(function (i) { $sel.append('<option value="' + i.id + '" data-text="' + i.text + '">' + i.text + '</option>'); });
            }
        });
    });

    $(document).on('change', '#uom_id_master', function () {
        var text = $(this).find('option:selected').data('text') || '';
        $('#uom_deskripsi').val(text);
        updateUomPreview();
    });

    $('.btn-batal-uom').click(function() {
        $('#view_uom_form').hide();
        $('#view_form').fadeIn();
    });

    $('#btn_simpan_uom, #btn_simpan_uom_bawah').click(function() {
        if (!window.currentItemCode) {
            Swal.fire({ icon: 'error', title: 'Gagal', text: 'Item belum tersimpan.' });
            return;
        }
        if (!$('#uom_id_master').val()) {
            Swal.fire({ icon: 'error', title: 'Gagal', text: 'Satuan (UOM) harus dipilih.' });
            return;
        }
        if (!$('#uom_faktor').val() || parseFloat($('#uom_faktor').val()) <= 0) {
            Swal.fire({ icon: 'error', title: 'Gagal', text: 'Faktor Konversi harus lebih besar dari 0.' });
            return;
        }
        var payload = {
            uom_id: window.currentUomId || '',
            uom_id_master: $('#uom_id_master').val(),
            uom_faktor: $('#uom_faktor').val(),
            uom_purchase: $('#uom_purchase').is(':checked') ? '1' : '0', 
            uom_sales: $('#uom_sales').is(':checked') ? '1' : '0', 
            uom_status: $('#uom_status').val(),
        };
        $.ajax({
            url: "<?= site_url('tmstobatbaru/saveUom') ?>/" + window.currentItemCode,
            type: 'POST',
            data: payload,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message });
                    $('#view_uom_form').hide();
                    $('#view_form').fadeIn();
                    loadUOM();
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: response.message || 'Gagal menyimpan UOM.' });
                }
            },
            error: function() { Swal.fire({ icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan koneksi ke server.' }); }
        });
    });

    $(document).on('click', '#uomBody .btn-icon-ob.delete', function() {
        var itemUomId = $(this).data('id');
        if (!itemUomId || !window.currentItemCode) return;
        if (!confirm('Yakin ingin menghapus satuan ini?')) return;
        $.ajax({
            url: "<?= site_url('tmstobatbaru/deleteUom') ?>/" + window.currentItemCode + "/" + itemUomId,
            type: 'POST',
            data: { _method: 'DELETE' },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') { Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message }); loadUOM(); }
                else { Swal.fire({ icon: 'error', title: 'Gagal', text: response.message }); }
            }
        });
    }); 

    function loadHarga() {
        if (!window.currentItemCode) {
            $('#hargaBody').html('<tr><td colspan="9" class="text-center text-muted py-3">Simpan Informasi Umum terlebih dahulu.</td></tr>');
            return;
        }

        $.ajax({
            url: "<?= site_url('tmstobatbaru/harga') ?>/" + window.currentItemCode,
            type: 'GET',
            beforeSend: function() {
                $('#hargaBody').html('<tr><td colspan="9" class="text-center text-muted py-3"><i class="fas fa-spinner fa-spin mr-1"></i> Memuat...</td></tr>');
            },
            success: function(response) {
                if (response.status === 'success') {
                    var html = '';
                    $.each(response.data, function(i, item) {
                        var marginClass = (item.margin !== null && item.margin < 0) ? 'text-danger' : ((item.margin !== null && item.margin > 30) ? 'text-success' : '');
                        html += '<tr>';
                        html += '<td class="text-center">' + (i + 1) + '</td>';
                        html += '<td><strong>' + item.price_class + '</strong></td>';
                        html += '<td>' + item.deskripsi + '</td>';
                        html += '<td>' + item.mata_uang + '</td>';
                        html += '<td class="text-right">' + item.harga_jual.toLocaleString('id-ID') + '</td>';
                        html += '<td class="text-right">' + (item.hpp !== null ? item.hpp.toLocaleString('id-ID') : '-') + '</td>';
                        html += '<td class="text-right ' + marginClass + '">' + (item.margin !== null ? item.margin.toFixed(2) + '%' : '-') + '</td>';
                        html += '<td class="text-center">' + (item.aktif ? '<span class="badge-ob-aktif">Aktif</span>' : '<span class="badge-ob-nonaktif">Non-Aktif</span>') + '</td>';
                        html += '<td class="text-center">';
                        html += '<button class="btn-icon-ob delete" data-id="' + item.id + '" title="Hapus"><i class="fas fa-trash"></i></button>';
                        html += '</td>';
                        html += '</tr>';
                    });
                    $('#hargaBody').html(html || '<tr><td colspan="9" class="text-center text-muted py-3">Belum ada data harga.</td></tr>');

                    $('#hg_total_class').text(response.total_price_class || 0);
                    $('#hg_harga_terendah').text('Rp ' + (response.harga_terendah || 0).toLocaleString('id-ID'));
                    $('#hg_harga_tertinggi').text('Rp ' + (response.harga_tertinggi || 0).toLocaleString('id-ID'));
                    $('#hg_rata_margin').text(response.rata_margin !== null ? response.rata_margin + '%' : '-');
                    applyViewMode();
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal memuat data harga.' });
                }
            },
            error: function() {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal memuat data harga. Cek koneksi API.' });
                $('#hargaBody').html('<tr><td colspan="9" class="text-center text-danger py-3">Gagal memuat data.</td></tr>');
            }
        });
    }
    loadHarga();

    $('#btn_tambah_harga').click(function() {
        $('#view_form').hide();
        $('#view_harga_form').fadeIn();
        window.currentPriceId = '';
        $('#h_uom_id').val(window.currentBaseUomId || '');
        $('#h_uom_id_display').val($('#inp_base_uom_id option:selected').text() || '-');
        $('#h_price_class').val('');
        $('#h_harga_jual').val('0');
        $('#h_tgl_mulai').val(new Date().toISOString().slice(0, 10));
        $('#h_tgl_selesai').val('');
        $('#h_status_aktif').prop('checked', true);
    });

    $('.btn-batal-harga').click(function() {
        $('#view_harga_form').hide();
        $('#view_form').fadeIn();
    });

    $('#btn_simpan_harga, #btn_simpan_harga_bawah').click(function() {
        if (!window.currentItemCode) {
            Swal.fire({ icon: 'error', title: 'Gagal', text: 'Item belum tersimpan.' });
            return;
        }
        if (!$('#h_price_class').val()) { Swal.fire({ icon: 'error', title: 'Gagal', text: 'Price Class harus dipilih.' }); return; }
        if (!$('#h_uom_id').val()) { Swal.fire({ icon: 'error', title: 'Gagal', text: 'Satuan (UOM) tidak ditemukan, ulangi dari Step 1.' }); return; }
        var payload = {
            price_id: window.currentPriceId || '',
            h_price_class_id: $('#h_price_class').val(),
            h_uom_id: $('#h_uom_id').val(),
            h_mata_uang: 'IDR',
            h_harga_jual: $('#h_harga_jual').val(),
            h_hpp: parseRupiah($('#h_hpp').val() || '0'),
            h_tgl_mulai: $('#h_tgl_mulai').val(),
            h_tgl_selesai: $('#h_tgl_selesai').val(),
            h_status_aktif: $('#h_status_aktif').is(':checked') ? '1' : '0',
            h_rounding_enabled: $('#chk_bulatkan').is(':checked') ? '1' : '0',
            h_rounding_multiple: $('#inp_kelipatan').val() || '',
            h_margin_enabled: $('#chk_margin_default').is(':checked') ? '1' : '0',
            h_margin_percent: $('#inp_margin').val() || '',
            h_promo_enabled: $('#chk_promo').is(':checked') ? '1' : '0',
            h_promo_harga: parseRupiah($('#inp_promo_harga').val() || '0'),
            h_promo_start: $('#inp_promo_mulai').val() || '',
            h_promo_end: $('#inp_promo_selesai').val() || '',
        };
        $.ajax({
            url: "<?= site_url('tmstobatbaru/saveHarga') ?>/" + window.currentItemCode,
            type: 'POST',
            data: payload,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message });
                    $('#view_harga_form').hide();
                    $('#view_form').fadeIn();
                    loadHarga();
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: response.message || 'Gagal menyimpan harga.' });
                }
            },
            error: function() { Swal.fire({ icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan koneksi ke server.' }); }
        });
    });

    $(document).on('click', '#hargaBody .btn-icon-ob.delete', function() {
        var priceId = $(this).data('id');
        if (!priceId || !window.currentItemCode) return;
        if (!confirm('Yakin ingin menghapus harga ini?')) return;
        $.ajax({
            url: "<?= site_url('tmstobatbaru/deleteHarga') ?>/" + window.currentItemCode + "/" + priceId,
            type: 'POST',
            data: { _method: 'DELETE' },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') { Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message }); loadHarga(); }
                else { Swal.fire({ icon: 'error', title: 'Gagal', text: response.message }); }
            }
        });
    });

    function loadSupplier() {
        if (!window.currentItemCode) {
            $('#supplierBody').html('<tr><td colspan="10" class="text-center text-muted py-3">Simpan Informasi Umum terlebih dahulu.</td></tr>');
            return;
        }
        $.ajax({
            url: "<?= site_url('tmstobatbaru/supplier') ?>/" + window.currentItemCode, 
            type: 'GET',
            success: function(response) {
                if (response.status === 'success') {
                    supplierDataCache = response.data || [];
                    var html = '';
                    $.each(response.data, function(i, item) {
                        html += '<tr>';
                        html += '<td class="text-center">' + (i + 1) + '</td>';
                        html += '<td>' + item.supplier + '</td>';
                        html += '<td>' + item.principal + '</td>';
                        html += '<td>' + item.mata_uang + '</td>';
                        html += '<td class="text-right">' + item.harga_beli.toLocaleString('id-ID') + '</td>';
                        html += '<td class="text-center">' + item.lead_time + '</td>';
                        html += '<td class="text-center">' + item.min_order + '</td>';
                        html += '<td class="text-center">' + (item.utama ? '<i class="fas fa-check-circle text-success"></i>' : '-') + '</td>';
                        html += '<td class="text-center">' + (item.aktif ? '<span class="badge-ob-aktif">Aktif</span>' : '<span class="badge-ob-nonaktif">Non-Aktif</span>') + '</td>';
                        html += '<td class="text-center">';
                        html += '<button class="btn-icon-ob edit" data-id="' + item.id + '" title="Edit"><i class="fas fa-edit"></i></button> ';
                        html += '<button class="btn-icon-ob delete" data-id="' + item.id + '" title="Hapus"><i class="fas fa-trash"></i></button>';
                        html += '</td></tr>';
                    });
                    $('#supplierBody').html(html || '<tr><td colspan="10" class="text-center text-muted py-3">Belum ada supplier.</td></tr>');
                    $('#sp_total').text(response.total_supplier || 0);
                    var utama = (response.data || []).find(function(s){ return s.utama; });
                    $('#sp_utama').text(utama ? utama.supplier : '-');
                    $('#sp_leadtime').text(response.lead_time_avg !== null ? response.lead_time_avg : '-');
                    $('#sp_hargaterendah').text(response.harga_beli_terendah !== null ? 'Rp ' + response.harga_beli_terendah.toLocaleString('id-ID') : '-');
                    applyViewMode();
                }
            },
            error: function() {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal memuat data supplier. Cek koneksi API.' });
            }
        });

        $(document).on('click', '#supplierBody .btn-icon-ob.delete', function() {
            var supplierId = $(this).data('id');
            if (!supplierId || !window.currentItemCode) return;
            if (!confirm('Yakin ingin menghapus supplier ini?')) return;
            $.ajax({
                url: "<?= site_url('tmstobatbaru/deleteSupplier') ?>/" + window.currentItemCode + "/" + supplierId,
                type: 'POST',
                data: { _method: 'DELETE' },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') { Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message }); loadSupplier(); }
                    else { Swal.fire({ icon: 'error', title: 'Gagal', text: response.message }); }
                }
            });
        });
        $(document).on('click', '#supplierBody .btn-icon-ob.edit', function() {
            var supplierId = $(this).data('id');
            var item = supplierDataCache.find(function(s) { return s.id === supplierId; });
            if (!item) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Data supplier tidak ditemukan.' });
                return;
            }

            window.currentSupplierId = item.id;

            $('#view_form').hide();
            $('#view_supplier_form').fadeIn();
            goToSupplierStep(1);

            $.ajax({
                url: "<?= site_url('tmstobatbaru/getSupplierDropdown') ?>",
                method: 'GET', dataType: 'JSON',
                success: function (r) {
                    var $sel = $('#s_supplier_id').empty().append('<option value="">Pilih supplier</option>');
                    (r.data || []).forEach(function (i) { $sel.append('<option value="' + i.id + '">' + i.text + '</option>'); });
                    $sel.val(item.supplierId || '');
                }
            });
            $.ajax({
                url: "<?= site_url('tmstobatbaru/getPrincipalDropdown') ?>",
                method: 'GET', dataType: 'JSON',
                success: function (r) {
                    var $sel = $('#s_principal_id_input').empty().append('<option value="">Pilih principal (opsional)</option>');
                    (r.data || []).forEach(function (i) { $sel.append('<option value="' + i.id + '">' + i.text + '</option>'); });
                    $sel.val(item.principalId || '');
                }
            });

            $('#s_harga_beli_input').val(formatRupiah(item.harga_beli || 0));
            $('#s_lead_time_input').val(item.lead_time || 0);
            $('#s_min_order_input').val(item.min_order || 0);
            $('#s_catatan').val(item.catatan || '');
            $('#s_utama_input').prop('checked', !!item.utama);
            $(item.aktif ? '#s_aktif' : '#s_nonaktif').prop('checked', true);
        });
    }
    loadSupplier();

    let supplierStep = 1;
    const totalSupplierSteps = 5;
    goToSupplierStep(supplierStep);

    function goToSupplierStep(step) {
        $('.supplier-step-pane').removeClass('active');
        $('#supplier_step_' + step).addClass('active');
        $('.step-item').removeClass('active done');
        $('.step-item').each(function() {
            let s = parseInt($(this).data('step'));
            if (s < step) $(this).addClass('done');
            if (s === step) $(this).addClass('active');
        });
        supplierStep = step;
        $('#btn_supplier_prev').toggle(step > 1);
        if (step === totalSupplierSteps) {
            $('#btn_supplier_next').text('Simpan Supplier');
        } else {
            $('#btn_supplier_next').text('Lanjutkan');
        }
    }

    $('#btn_supplier_next').click(function() {
        if (supplierStep < totalSupplierSteps) {
            goToSupplierStep(supplierStep + 1);
        } else {
            saveSupplierData();
        }
    });

    $('#btn_simpan_supplier, #btn_simpan_supplier_bawah').click(function() {
        saveSupplierData();
    });

    $('#btn_supplier_prev').click(function() {
        if (supplierStep > 1) goToSupplierStep(supplierStep - 1);
    });

    $('.step-item').click(function() {
        goToSupplierStep(parseInt($(this).data('step')));
    });

    $('#btn_tambah_supplier').click(function() {
        $('#view_form').hide();
        $('#view_supplier_form').fadeIn();
        goToSupplierStep(1);

        $.ajax({
            url: "<?= site_url('tmstobatbaru/getSupplierDropdown') ?>",
            method: 'GET', dataType: 'JSON',
            success: function (r) {
                if (r.status !== 'success') return;
                var $sel = $('#s_supplier_id').empty().append('<option value="">Pilih supplier</option>');
                (r.data || []).forEach(function (i) { $sel.append('<option value="' + i.id + '">' + i.text + '</option>'); });
            }
        });
        $.ajax({
            url: "<?= site_url('tmstobatbaru/getPrincipalDropdown') ?>",
            method: 'GET', dataType: 'JSON',
            success: function (r) {
                if (r.status !== 'success') return;
                var $sel = $('#s_principal_id_input').empty().append('<option value="">Pilih principal (opsional)</option>');
                (r.data || []).forEach(function (i) { $sel.append('<option value="' + i.id + '">' + i.text + '</option>'); });
            }
        });
    });

    $('.btn-batal-supplier').click(function() {
        $('#view_supplier_form').hide();
        $('#view_form').fadeIn();
    });

    function saveSupplierData() {
        if (!window.currentItemCode) {
            Swal.fire({ icon: 'error', title: 'Gagal', text: 'Item belum tersimpan.' });
            return;
        }
        if (!$('#s_supplier_id').val().trim()) {
            Swal.fire({ icon: 'error', title: 'Gagal', text: 'ID Supplier wajib diisi.' });
            goToSupplierStep(1);
            return;
        }
        if (!$('#s_harga_beli_input').val()) {
            Swal.fire({ icon: 'error', title: 'Gagal', text: 'Harga Beli Terakhir wajib diisi.' });
            goToSupplierStep(1);
            return;
        }
        var payload = {
            item_supplier_id: window.currentSupplierId || '',
            s_supplier_id: $('#s_supplier_id').val().trim(),
            s_principal_id: $('#s_principal_id_input').val().trim(),
            s_harga_beli: parseRupiah($('#s_harga_beli_input').val() || '0').toString(),
            s_lead_time: $('#s_lead_time_input').val() || '0',
            s_min_order: $('#s_min_order_input').val() || '0',
            s_catatan: $('#s_catatan').val() || '',
            s_utama: $('#s_utama_input').is(':checked') ? '1' : '0',
            s_aktif: $('#s_aktif').is(':checked') ? '1' : '0',
        };
        $.ajax({
            url: "<?= site_url('tmstobatbaru/saveSupplier') ?>/" + window.currentItemCode,
            type: 'POST',
            data: payload,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message });
                    $('#view_supplier_form').hide();
                    $('#view_form').fadeIn();
                    loadSupplier();
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: response.message || 'Gagal menyimpan supplier.' });
                }
            },
            error: function() { Swal.fire({ icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan koneksi ke server.' }); }
        });
    }

    var stockPerPage = 10, stockCurrentPage = 1;
    var batchPerPage = 10, batchCurrentPage = 1;
    var stockDataCache = [], batchDataCache = [];
    var supplierDataCache = [];

    function renderStockTable() {
        var start = (stockCurrentPage - 1) * stockPerPage;
        var pageData = stockDataCache.slice(start, start + stockPerPage);
        var html = '';
        $.each(pageData, function(i, item) {
            html += '<tr>';
            html += '<td class="text-center">' + (start + i + 1) + '</td>';
            html += '<td><a href="#" class="kode-link">' + item.warehouse + '</a></td>';
            html += '<td>' + item.bin + '</td>';
            html += '<td class="text-center" style="color:#198754; font-weight:600;">' + item.stok + '</td>';
            html += '<td class="text-center">' + item.min + '</td>';
            html += '<td class="text-center">' + item.po + '</td>';
            html += '<td class="text-center">' + item.paket + '</td>';
            html += '<td>' + item.satuan + '</td>';
            html += '<td class="text-right">Rp ' + item.nilai.toLocaleString('id-ID') + '</td>';
            html += '</tr>';
        });
        $('#stockBody').html(html || '<tr><td colspan="9" class="text-center text-muted py-3">Tidak ada data stok.</td></tr>');

        var total = stockDataCache.length;
        var end = Math.min(start + stockPerPage, total);
        $('#stock_info_text').text('Menampilkan ' + (total ? start + 1 : 0) + ' sampai ' + end + ' dari ' + total + ' data');
        renderStockPagination(total);
    }

    function renderStockPagination(total) {
        var totalPages = Math.max(1, Math.ceil(total / stockPerPage));
        var html = '<span class="paginate_button previous' + (stockCurrentPage === 1 ? ' disabled' : '') + '" data-page="prev"><i class="fas fa-angle-left"></i></span>';
        for (var p = 1; p <= totalPages; p++) {
            html += '<span class="paginate_button' + (p === stockCurrentPage ? ' current' : '') + '" data-page="' + p + '">' + p + '</span>';
        }
        html += '<span class="paginate_button next' + (stockCurrentPage === totalPages ? ' disabled' : '') + '" data-page="next"><i class="fas fa-angle-right"></i></span>';
        $('#stock_paginate').html(html);
    }

    $(document).on('click', '#stock_paginate .paginate_button', function() {
        if ($(this).hasClass('disabled')) return;
        var page = $(this).data('page');
        var totalPages = Math.max(1, Math.ceil(stockDataCache.length / stockPerPage));
        if (page === 'prev') stockCurrentPage = Math.max(1, stockCurrentPage - 1);
        else if (page === 'next') stockCurrentPage = Math.min(totalPages, stockCurrentPage + 1);
        else stockCurrentPage = parseInt(page);
        renderStockTable();
    });

    $('#stock_per_page').on('change', function() {
        stockPerPage = parseInt($(this).val());
        stockCurrentPage = 1;
        renderStockTable();
    });

    function renderBatchTable() {
        var start = (batchCurrentPage - 1) * batchPerPage;
        var pageData = batchDataCache.slice(start, start + batchPerPage);
        var html = '';
        $.each(pageData, function(i, item) {
            var badgeClass = 'badge-ob-safe';
            if (item.status === 'Expired') badgeClass = 'badge-ob-expired';
            else if (item.status === 'Hampir Expired') badgeClass = 'badge-ob-warning';

            html += '<tr>';
            html += '<td class="text-center">' + (start + i + 1) + '</td>';
            html += '<td><strong>' + item.no_batch + '</strong></td>';
            html += '<td>' + item.prod + '</td>';
            html += '<td style="color:' + (item.status === 'Expired' ? '#dc3545' : (item.status === 'Hampir Expired' ? '#856404' : '#0f5132')) + ';">' + item.exp + '</td>';
            html += '<td class="text-center">' + item.stok + '</td>';
            html += '<td class="text-center">' + item.reservasi + '</td>';
            html += '<td>' + item.satuan + '</td>';
            html += '<td class="text-center"><span class="' + badgeClass + '">' + item.status + '</span></td>';
            html += '</tr>';
        });
        $('#batchBody').html(html || '<tr><td colspan="8" class="text-center text-muted py-3">Belum ada data batch.</td></tr>');

        var total = batchDataCache.length;
        var end = Math.min(start + batchPerPage, total);
        $('#batch_info_text').text('Menampilkan ' + (total ? start + 1 : 0) + ' sampai ' + end + ' dari ' + total + ' data');
        renderBatchPagination(total);
    }

    function renderBatchPagination(total) {
        var totalPages = Math.max(1, Math.ceil(total / batchPerPage));
        var html = '<span class="paginate_button previous' + (batchCurrentPage === 1 ? ' disabled' : '') + '" data-page="prev"><i class="fas fa-angle-left"></i></span>';
        for (var p = 1; p <= totalPages; p++) {
            html += '<span class="paginate_button' + (p === batchCurrentPage ? ' current' : '') + '" data-page="' + p + '">' + p + '</span>';
        }
        html += '<span class="paginate_button next' + (batchCurrentPage === totalPages ? ' disabled' : '') + '" data-page="next"><i class="fas fa-angle-right"></i></span>';
        $('#batch_paginate').html(html);
    }

    $(document).on('click', '#batch_paginate .paginate_button', function() {
        if ($(this).hasClass('disabled')) return;
        var page = $(this).data('page');
        var totalPages = Math.max(1, Math.ceil(batchDataCache.length / batchPerPage));
        if (page === 'prev') batchCurrentPage = Math.max(1, batchCurrentPage - 1);
        else if (page === 'next') batchCurrentPage = Math.min(totalPages, batchCurrentPage + 1);
        else batchCurrentPage = parseInt(page);
        renderBatchTable();
    });

    $('#batch_per_page').on('change', function() {
        batchPerPage = parseInt($(this).val());
        batchCurrentPage = 1;
        renderBatchTable();
    });

    function updateStockSummary() {
        var totalStok = 0, totalNilai = 0, totalMin = 0;
        $.each(stockDataCache, function(i, item) {
            totalStok += (item.stok || 0);
            totalNilai += (item.nilai || 0);
            totalMin += (item.min || 0);
        });

        var totalExp90 = 0;
        var today = new Date();
        $.each(batchDataCache, function(i, item) {
            if (item.status === 'Hampir Expired' || item.status === 'Expired') {
                totalExp90 += (item.stok || 0);
            }
        });

        $('#sum_total_stok').text(totalStok.toLocaleString('id-ID'));
        $('#sum_nilai_stok').text(totalNilai.toLocaleString('id-ID'));
        $('#sum_stok_min').text(totalMin.toLocaleString('id-ID'));
        $('#sum_exp_90').text(totalExp90.toLocaleString('id-ID'));
    }

    function loadStock() {
        if (!window.currentItemCode) {
            $('#stockBody').html('<tr><td colspan="10" class="text-center text-muted py-3">Simpan Informasi Umum terlebih dahulu.</td></tr>');
            $('#batchBody').html('<tr><td colspan="9" class="text-center text-muted py-3">Simpan Informasi Umum terlebih dahulu.</td></tr>');
            return;
        }
        $.ajax({
            url: "<?= site_url('tmstobatbaru/stock') ?>/" + window.currentItemCode, 
            type: 'GET',
            beforeSend: function() {
                $('#stockBody').html('<tr><td colspan="10" class="text-center text-muted py-3"><i class="fas fa-spinner fa-spin mr-1"></i> Memuat data...</td></tr>');
                $('#batchBody').html('<tr><td colspan="9" class="text-center text-muted py-3"><i class="fas fa-spinner fa-spin mr-1"></i> Memuat data...</td></tr>');
            },
            success: function(response) {
                if (response.status === 'success') {
                    stockDataCache = response.stock || [];
                    batchDataCache = response.batch || [];
                    stockCurrentPage = 1;
                    batchCurrentPage = 1;
                    renderStockTable();
                    renderBatchTable();
                    updateStockSummary();
                    applyViewMode();
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal memuat data stok.' });
                }
            },
            error: function() {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan saat memuat data stok.' });
                $('#stockBody').html('<tr><td colspan="10" class="text-center text-danger py-3">Gagal memuat data.</td></tr>');
                $('#batchBody').html('<tr><td colspan="9" class="text-center text-danger py-3">Gagal memuat data.</td></tr>');
            }
        });
    }
    loadStock();

    $('#btn_refresh_stock').click(function() {
        var $btn = $(this);
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Memuat...');
        loadStock();
        setTimeout(function() {
            $btn.prop('disabled', false).html('<i class="fas fa-sync-alt mr-1"></i> Refresh Stok');
            Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Data stok berhasil diperbarui.' });
        }, 500);
    });

    $('#btn_cetak_label').click(function() {
        if (batchDataCache.length === 0) {
            Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Tidak ada batch untuk dicetak labelnya.' });
            return;
        }
        Swal.fire({ icon: 'info', title: 'Info', text: 'Menyiapkan label cetak...' });
        window.print();
    });

    $('#link_lihat_detail_exp').click(function(e) {
        e.preventDefault();
        $('html, body').animate({ scrollTop: $('#batchTable').offset().top - 100 }, 400);
    });
    
    loadStock();

    $('#btn_tambah_stock').click(function() {
        $('#view_form').hide();
        $('#view_stock_form').fadeIn();
        goToStockStep(1);
        resetStockForm();
    });

    $('.btn-batal-stock').click(function() {
        $('#view_stock_form').hide();
        $('#view_form').fadeIn();
    });

    let stockStep = 1;
    const totalStockSteps = 4;

    function goToStockStep(step) {
        $('.stock-step-pane').hide().removeClass('active');
        $('#stock_step_' + step).show().addClass('active');

        $('#view_stock_form .step-item').removeClass('active done');
        $('#view_stock_form .step-item').each(function() {
            let s = parseInt($(this).data('step'));
            if (s < step) $(this).addClass('done');
            if (s === step) $(this).addClass('active');
        });

        stockStep = step;
        $('#btn_stock_prev').toggle(step > 1);

        if (step === totalStockSteps) {
            $('#btn_stock_next').html('Simpan Stock <i class="fas fa-save ml-1"></i>');
            updateStockConfirmation();
        } else {
            $('#btn_stock_next').html('Lanjutkan <i class="fas fa-arrow-right ml-1"></i>');
        }
    }

    $('#btn_stock_next').click(function() {
        if (stockStep === 1) {
            if (!$('#st_warehouse').val()) { Swal.fire({ icon: 'error', title: 'Gagal', text: 'Warehouse harus dipilih' }); return; }
            if (!$('#st_no_dokumen').val()) { Swal.fire({ icon: 'error', title: 'Gagal', text: 'No. Dokumen harus diisi' }); return; }
            if (!$('#st_tgl_dokumen').val()) { Swal.fire({ icon: 'error', title: 'Gagal', text: 'Tanggal Dokumen harus diisi' }); return; }
        }
        if (stockStep === 2) {
            if (!$('#st_no_batch').val()) { Swal.fire({ icon: 'error', title: 'Gagal', text: 'No. Batch harus diisi' }); return; }
            if (!$('#st_tgl_produksi').val()) { Swal.fire({ icon: 'error', title: 'Gagal', text: 'Tanggal Produksi harus diisi' }); return; }
            if (!$('#st_tgl_expired').val()) { Swal.fire({ icon: 'error', title: 'Gagal', text: 'Tanggal Expired harus diisi' }); return; }
        }
        if (stockStep === 3) {
            if (!$('#st_jumlah').val() || parseInt($('#st_jumlah').val()) <= 0) { Swal.fire({ icon: 'error', title: 'Gagal', text: 'Jumlah Stok Masuk harus diisi' }); return; }
        }

        if (stockStep < totalStockSteps) {
            goToStockStep(stockStep + 1);
        } else {
            saveStock();
        }
    });

    $('#btn_stock_prev').click(function() {
        if (stockStep > 1) goToStockStep(stockStep - 1);
    });

    $('#view_stock_form .step-item').on('click', function() {
        goToStockStep(parseInt($(this).data('step')));
    });

    $('#st_keterangan').on('keyup', function() {
        $('#st_keterangan_count').text($(this).val().length);
    });

    function calcStockTotal() {
        var jumlah = parseInt($('#st_jumlah').val()) || 0;
        var hpp = parseRupiah($('#st_hpp').val() || '0');
        var total = jumlah * hpp;
        $('#st_total_nilai').val(formatRupiah(total));
    }
    $('#st_jumlah, #st_hpp').on('keyup', calcStockTotal);

    $('#st_warehouse').on('change', function() {
        var bin = { 'Gudang Farmasi Utama': 'BIN-01-A', 'Gudang Klinik 2': 'BIN-01-B', 'Gudang Cadangan': 'BIN-02-A' };
        if (bin[$(this).val()]) $('#st_bin').val(bin[$(this).val()]);
    });

    function updateStockConfirmation() {
        $('#cf_obat').text($('#st_obat_nama').text() || '-');
        $('#cf_warehouse').text($('#st_warehouse').val() || '-');
        $('#cf_bin').text($('#st_bin').val() || '-');
        $('#cf_tipe').text($('#st_tipe_transaksi').val() || '-');
        $('#cf_nodok').text($('#st_no_dokumen').val() || '-');
        $('#cf_batch').text($('#st_no_batch').val() || '-');
        $('#cf_expired').text($('#st_tgl_expired').val() || '-');
        $('#cf_jumlah').text(($('#st_jumlah').val() || '0') + ' ' + $('#st_jumlah_satuan').text());
        $('#cf_nilai').text('Rp ' + $('#st_total_nilai').val());
    }

    function saveStock() {
        if (!window.currentItemCode) {
            Swal.fire({ icon: 'error', title: 'Gagal', text: 'Item belum tersimpan.' });
            return;
        }
        var payload = {
            warehouse: $('#st_warehouse').val(),
            bin: $('#st_bin').val() || '',
            tipe_transaksi: $('#st_tipe_transaksi').val(),
            no_dokumen: $('#st_no_dokumen').val(),
            tgl_dokumen: $('#st_tgl_dokumen').val(),
            no_batch: $('#st_no_batch').val(),
            tgl_produksi: $('#st_tgl_produksi').val(),
            tgl_expired: $('#st_tgl_expired').val(),
            jumlah: $('#st_jumlah').val(),
            stok_min: $('#st_stok_min').val(),
            hpp: parseRupiah($('#st_hpp').val() || '0'),
            keterangan: $('#st_keterangan').val() || '',
        };

        var $btn = $('#btn_simpan_stock, #btn_simpan_stock_bawah');
        $btn.prop('disabled', true);

        $.ajax({
            url: "<?= site_url('tmstobatbaru/saveStock') ?>/" + window.currentItemCode,
            type: 'POST',
            data: payload,
            dataType: 'json',
            success: function(response) {
                $btn.prop('disabled', false);
                if (response.status === 'success') {
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message });
                    $('#view_stock_form').hide();
                    $('#view_form').fadeIn();
                    loadStock();
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Belum Bisa Disimpan',
                        text: response.message
                    });
                }
            },
            error: function() {
                $btn.prop('disabled', false);
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan koneksi ke server.' });
            }
        });
    }

    $('#btn_simpan_stock, #btn_simpan_stock_bawah').click(function() {
        if (!$('#st_warehouse').val()) { Swal.fire({ icon: 'error', title: 'Gagal', text: 'Warehouse harus dipilih' }); goToStockStep(1); return; }
        if (!$('#st_no_dokumen').val()) { Swal.fire({ icon: 'error', title: 'Gagal', text: 'No. Dokumen harus diisi' }); goToStockStep(1); return; }
        if (!$('#st_no_batch').val()) { Swal.fire({ icon: 'error', title: 'Gagal', text: 'No. Batch harus diisi' }); goToStockStep(2); return; }
        if (!$('#st_tgl_expired').val()) { Swal.fire({ icon: 'error', title: 'Gagal', text: 'Tanggal Expired harus diisi' }); goToStockStep(2); return; }
        if (!$('#st_jumlah').val() || parseInt($('#st_jumlah').val()) <= 0) { Swal.fire({ icon: 'error', title: 'Gagal', text: 'Jumlah Stok Masuk harus diisi' }); goToStockStep(3); return; }
        saveStock();
    });

    $('#st_cari_obat').on('keyup', function() {
        var val = $(this).val();
        if (val) {
            $('#st_obat_kode').text('OBT-' + val.toUpperCase().replace(/\s+/g, ''));
            $('#st_obat_nama').text(val);
            $('#rg_kode').text($('#st_obat_kode').text());
            $('#rg_nama').text(val);
        }
    });

    function resetStockForm() {
        $('#st_cari_obat').val('');
        $('#st_warehouse, #st_bin, #st_sumber_dokumen').val('');
        $('#st_no_dokumen, #st_keterangan, #st_no_batch').val('');
        $('#st_tgl_dokumen, #st_tgl_produksi, #st_tgl_expired').val('');
        $('#st_jumlah, #st_stok_min, #st_hpp').val('');
        $('#st_total_nilai').val('0');
        $('#st_keterangan_count').text('0');
        $('#st_tipe_transaksi').val('Penerimaan Pembelian');
    }

    function formatDateDisplay(dateStr) {
        if (!dateStr) return '-';
        var parts = dateStr.split('-');
        if (parts.length !== 3) return dateStr;
        return parts[2] + '/' + parts[1] + '/' + parts[0];
    }

    function loadDokumen() {
        if (!window.currentItemCode) {
            $('#dokumenBody').html('<tr><td colspan="9" class="text-center text-muted py-3">Simpan Informasi Umum terlebih dahulu.</td></tr>');
            return;
        }
        $.ajax({
            url: "<?= site_url('tmstobatbaru/dokumen') ?>/" + window.currentItemCode, 
            type: 'GET',
            success: function(response) {
                if (response.status === 'success') {
                    var html = '';
                    $.each(response.data, function(i, item) {
                        html += '<tr>';
                        html += '<td class="text-center">' + (i + 1) + '</td>';
                        html += '<td>' + item.jenis + '</td>';
                        html += '<td>' + item.nomor + '</td>';
                        html += '<td>' + item.tanggal + '</td>';
                        html += '<td>' + item.berlaku + '</td>';
                        html += '<td><a href="#" style="color:var(--ob-blue);"><i class="fas fa-file-pdf mr-1"></i>' + item.file + '</a></td>';
                        html += '<td>' + item.ukuran + '</td>';
                        html += '<td class="text-center">' + (item.aktif ? '<span class="badge-ob-aktif">Aktif</span>' : '<span class="badge-ob-nonaktif">Non-Aktif</span>') + '</td>';
                        html += '<td class="text-center">';
                        html += '<button class="btn-icon-ob edit" data-id="' + item.id + '" title="Edit"><i class="fas fa-edit"></i></button> ';
                        html += '<button class="btn-icon-ob delete" data-id="' + item.id + '" title="Hapus"><i class="fas fa-trash"></i></button>';
                        html += '</td></tr>';
                    });
                    $('#dokumenBody').html(html);
                    $('#dokumenWajib').html(''); 
                    applyViewMode();
                }
            },
            error: function() {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal memuat data dokumen. Cek koneksi API.' });
            }
        });
    }
    loadDokumen();

    let dokumenStep = 1;
    const totalDokumenSteps = 3;
    goToDokumenStep(dokumenStep);

    function goToDokumenStep(step) {
        $('.dokumen-step-pane').removeClass('active');
        $('#dokumen_step_' + step).addClass('active');
        $('.step-item').removeClass('active done');
        $('.step-item').each(function() {
            let s = parseInt($(this).data('step'));
            if (s < step) $(this).addClass('done');
            if (s === step) $(this).addClass('active');
        });
        dokumenStep = step;
        $('#btn_dokumen_prev').toggle(step > 1);
        if (step === totalDokumenSteps) {
            $('#btn_dokumen_next').text('Simpan Dokumen');
        } else {
            $('#btn_dokumen_next').text('Lanjutkan');
        }
    }

    $('#btn_dokumen_next').click(function() {
        if (dokumenStep < totalDokumenSteps) {
            if (dokumenStep === 2) {
                $('#d_confirm_jenis').text($('#d_jenis option:selected').text() || '-');
                $('#d_confirm_nomor').text($('#d_nomor').val() || '-');
                $('#d_confirm_tanggal').text($('#d_tanggal').val() || '-');
                $('#d_confirm_berlaku').text($('#d_berlaku').val() || '-');
                var fileName = $('#dokumen_file_input').val().split('\\').pop();
                $('#d_confirm_file').text(fileName || 'Belum ada file');
            }
            goToDokumenStep(dokumenStep + 1);
        } else {
            Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Dokumen berhasil disimpan!' });
            $('#view_dokumen_form').hide();
            $('#view_form').fadeIn();
            loadDokumen();
        }
    });

    $('#btn_simpan_dokumen, #btn_simpan_dokumen_bawah').click(function() {
        saveDokumenData();
    });

    $('#btn_dokumen_prev').click(function() {
        if (dokumenStep > 1) goToDokumenStep(dokumenStep - 1);
    });

    $('.step-item').click(function() {
        goToDokumenStep(parseInt($(this).data('step')));
    });

    $('#btn_tambah_dokumen').click(function() {
        $('#view_form').hide();
        $('#view_dokumen_form').fadeIn();
        goToDokumenStep(1);
    });

    $('.btn-batal-dokumen').click(function() {
        $('#view_dokumen_form').hide();
        $('#view_form').fadeIn();
    });

    function saveDokumenData() {
        if (!window.currentItemCode) {
            Swal.fire({ icon: 'error', title: 'Gagal', text: 'Item belum tersimpan.' });
            return;
        }
        if (!$('#d_jenis').val()) { Swal.fire({ icon: 'error', title: 'Gagal', text: 'Jenis Dokumen harus dipilih.' }); return; }

        var formData = new FormData();
        formData.append('document_id', window.currentDocumentId || '');
        formData.append('d_jenis', $('#d_jenis').val());
        formData.append('d_nomor', $('#d_nomor').val());
        formData.append('d_tanggal', $('#d_tanggal').val());
        formData.append('d_berlaku', $('#d_berlaku').val());
        formData.append('d_deskripsi', $('#d_deskripsi').val());
        var fileEl = document.getElementById('dokumen_file_input');
        if (fileEl.files && fileEl.files[0]) {
            formData.append('file', fileEl.files[0]);
        }

        $.ajax({
            url: "<?= site_url('tmstobatbaru/saveDokumen') ?>/" + window.currentItemCode,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message });
                    $('#view_dokumen_form').hide();
                    $('#view_form').fadeIn();
                    loadDokumen();
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: response.message || 'Gagal menyimpan dokumen.' });
                }
            },
            error: function() { Swal.fire({ icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan koneksi ke server.' }); }
        });
    }

    $('#dokumen_pilih_file').click(function() {
        $('#dokumen_file_input').click();
    });

    $('#dokumen_file_input').on('change', function(e) {
        if (this.files && this.files[0]) {
            var file = this.files[0];
            var validTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
            var maxSize = 10 * 1024 * 1024; 
            
            if (!validTypes.includes(file.type)) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Format file tidak didukung. Gunakan PDF, JPG, JPEG, atau PNG.' });
                this.value = '';
                return;
            }
            if (file.size > maxSize) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Ukuran file terlalu besar. Maksimal 10 MB.' });
                this.value = '';
                return;
            }
            
            $('#dokumen_preview_text').text(file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)');
            Swal.fire({ icon: 'success', title: 'Berhasil', text: 'File "' + file.name + '" berhasil dipilih.' });
        }
    });

    var dokumenDropZone = document.getElementById('dokumen_drop_zone');
    if (dokumenDropZone) {
        dokumenDropZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });
        dokumenDropZone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
        });
        dokumenDropZone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            var files = e.dataTransfer.files;
            if (files.length > 0) {
                var file = files[0];
                var validTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
                var maxSize = 10 * 1024 * 1024;
                
                if (!validTypes.includes(file.type)) {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: 'Format file tidak didukung. Gunakan PDF, JPG, JPEG, atau PNG.' });
                    return;
                }
                if (file.size > maxSize) {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: 'Ukuran file terlalu besar. Maksimal 10 MB.' });
                    return;
                }
                
                $('#dokumen_file_input')[0].files = files;
                $('#dokumen_preview_text').text(file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)');
                Swal.fire({ icon: 'success', title: 'Berhasil', text: 'File "' + file.name + '" berhasil di-drop.' });
            }
        });
    }

    $('#drop_zone').click(function() {
        $('#file_input').click();
    });

    function renderImagePreview() {
        var val = window.currentItemImageUrl || '';

        if (val.indexOf('PENDING:') === 0) {
            var namaFile = val.replace('PENDING:', '');
            $('#image_preview_wrap').html(
                '<div style="font-size:.8rem; color:var(--ob-amber-text); background:var(--ob-amber-bg); border:1px solid var(--ob-amber-border); border-radius:.4rem; padding:.6rem .9rem; display:flex; align-items:center; gap:.5rem;">' +
                    '<i class="fas fa-clock"></i>' +
                    '<span>Foto "' + namaFile + '" belum diupload (menunggu fitur storage aktif)</span>' +
                '</div>'
            );
        } else if (val) {
            $('#image_preview_wrap').html(
                '<img src="' + val + '" style="max-height:120px; border-radius:.4rem; border:1px solid var(--ob-border);">' +
                '<div style="font-size:.75rem; color:var(--ob-muted); margin-top:.3rem;">Gambar terpilih. Upload ulang untuk mengganti.</div>'
            );
        } else {
            $('#image_preview_wrap').html('');
        }
    }

    $('#file_input').on('change', function(e) {
        if (this.files && this.files[0]) {
            var file = this.files[0];
            var maxSize = 2 * 1024 * 1024;
            var validTypes = ['image/png', 'image/jpeg', 'image/jpg'];
            if (!validTypes.includes(file.type)) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Format file tidak didukung. Gunakan PNG, JPG, atau JPEG.' });
                this.value = '';
                return;
            }
            if (file.size > maxSize) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Ukuran file terlalu besar. Maksimal 2 MB.' });
                this.value = '';
                return;
            }

            window.currentItemImageFile = file;
            window.currentItemImageFileName = file.name;

            var objectUrl = URL.createObjectURL(file);
            window.currentItemImageUrl = objectUrl;
            $('#image_preview_wrap').html(
                '<img src="' + objectUrl + '" style="max-height:120px; border-radius:.4rem; border:1px solid var(--ob-border);">' +
                '<div style="font-size:.75rem; color:var(--ob-amber-text); margin-top:.3rem;">' +
                    file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB) — belum diupload ke server' +
                '</div>'
            );

            Swal.fire({
                icon: 'info',
                title: 'Info',
                text: 'Upload foto ke server belum tersedia (menunggu endpoint storage). Nama file "' + file.name + '" akan disimpan sebagai catatan sementara.'
            });
        }
    });

    var dropZone = document.getElementById('drop_zone');
    if (dropZone) {
        dropZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });
        dropZone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
        });
        dropZone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            var files = e.dataTransfer.files;
            if (files.length > 0) {
                $('#file_input')[0].files = files;
                $('#file_input').trigger('change');
            }
        });
    }

    function formatRupiah(value) {
        return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function parseRupiah(value) {
        return parseInt(value.replace(/[^0-9]/g, '')) || 0;
    }

    function calculateMargin() {
        var hargaJual = parseRupiah($('#h_harga_jual').val());
        var hpp = parseRupiah($('#h_hpp').val());
        
        if (hargaJual > 0) {
            var margin = ((hargaJual - hpp) / hargaJual * 100);
            $('#h_margin').val(margin.toFixed(2) + '%');
            $('#r_margin_persen').text(margin.toFixed(2) + '%');
            $('#r_margin_nominal').text('Rp ' + formatRupiah(hargaJual - hpp));
        }
        $('#r_harga').text('Rp ' + formatRupiah(hargaJual));
        $('#r_hpp').text('Rp ' + formatRupiah(hpp));
    }

    $('#h_harga_jual, #h_hpp').on('keyup', calculateMargin);
    calculateMargin();

    function updateUomPreview() {
        var kode = $('#uom_id_master option:selected').text() || '-';
        var faktor = parseFloat($('#uom_faktor').val()) || 0;
        var baseUomText = $('#st_base_uom').val() || 'Base UOM';

        $('#preview_uom').text(kode);
        $('#preview_desk').text($('#uom_deskripsi').val() || '-');
        $('#preview_konversi').text('1 ' + kode + ' = ' + faktor + ' ' + baseUomText);
        $('#uom_isi').val('1 ' + kode + ' = ' + faktor + ' ' + baseUomText);
        $('#preview_conversion_detail').text(faktor + ' ' + kode + ' = ' + (faktor * 10) + ' ' + baseUomText);
    }

    $('#uom_deskripsi, #uom_faktor').on('keyup change', function() {
        updateUomPreview();
    });

    updateUomPreview();

    $('#dd_dosage').on('change', function() {
        var val = $(this).val();
        var label = val ? val.split('(')[0].trim() : '';
        $('#lbl_dosage_preview').text(label || '-');
    });
});
</script>
<?= $this->endSection(); ?>