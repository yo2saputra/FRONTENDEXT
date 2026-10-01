<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<style>
    :root {
        --pkt-blue: #155eef;
        --pkt-blue-dark: #0f4fd1;
        --pkt-blue-soft: #eef3ff;
        --pkt-text: #1f2430;
        --pkt-muted: #7b8291;
        --pkt-border: #e7e9ee;
        --pkt-bg-soft: #f8f9fb;
        --pkt-green-bg: #e6f7ec;
        --pkt-green-text: #16a34a;
        --pkt-gray-bg: #eef0f3;
        --pkt-gray-text: #6c757d;
        --pkt-orange: #f0a020;
        --pkt-red: #e03131;
        --pkt-amber-bg: #fdf6e6;
        --pkt-amber-border: #f3e3b0;
        --pkt-amber-text: #8a6d1d;
    }

    .form-control-sm {
        font-size: .78rem !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered,
    .select2-container--default .select2-selection--single,
    .select2-results__option {
        font-size: .78rem !important;
    }

    .content-wrapper {
        background-color: var(--pkt-bg-soft);
    }

    .paket-page-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 1.1rem;
        flex-wrap: wrap;
        gap: .75rem;
    }

    .content-header h1.paket-title {
        font-size: 1.6rem;
        font-weight: 700;
        color: var(--pkt-text);
        margin-bottom: 2px;
    }

    .paket-subtitle {
        font-size: .85rem;
        color: var(--pkt-muted);
    }

    .btn-pkt-primary {
        background-color: var(--pkt-blue);
        border-color: var(--pkt-blue);
        color: #fff;
        font-weight: 600;
        font-size: .82rem;
        border-radius: .5rem;
        padding: .55rem 1.05rem;
        box-shadow: 0 1px 2px rgba(21, 94, 239, .25);
    }

    .btn-pkt-primary:hover {
        background-color: var(--pkt-blue-dark);
        border-color: var(--pkt-blue-dark);
        color: #fff;
    }

    .btn-pkt-primary:disabled {
        opacity: .6;
    }

    .btn-pkt-outline {
        background-color: #fff;
        border: 1px solid var(--pkt-border);
        color: var(--pkt-text);
        font-weight: 600;
        font-size: .8rem;
        border-radius: .5rem;
        padding: .5rem .9rem;
    }

    .btn-pkt-outline:hover {
        background-color: var(--pkt-bg-soft);
        color: var(--pkt-text);
    }

    .paket-card {
        background: #fff;
        border: 1px solid var(--pkt-border);
        border-radius: .65rem;
        box-shadow: 0 1px 2px rgba(16, 24, 40, .04);
    }

    .paket-filter-card {
        padding: 1.1rem 1.25rem;
        margin-bottom: 1rem;
    }

    .paket-filter-card label {
        font-size: .75rem;
        font-weight: 700;
        color: var(--pkt-text);
        margin-bottom: .35rem;
    }

    .paket-filter-card .form-control,
    .paket-filter-card select {
        border-radius: .45rem;
        border: 1px solid var(--pkt-border);
        font-size: .82rem;
        height: calc(1.6em + .8rem + 2px);
    }

    .paket-search-wrap {
        position: relative;
    }

    .paket-search-wrap input {
        padding-right: 2.2rem;
    }

    .paket-search-wrap i {
        position: absolute;
        right: .8rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--pkt-muted);
        font-size: .82rem;
    }

    .paket-table-card {
        padding: 1.1rem 1.25rem 0.5rem;
    }

    .paket-table-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: .9rem;
        flex-wrap: wrap;
        gap: .6rem;
    }

    .paket-table-toolbar .total-label {
        font-weight: 700;
        font-size: .88rem;
        color: var(--pkt-text);
    }

    #paketTable_wrapper .dt-buttons {
        display: flex;
        gap: .5rem;
    }

    #paketTable_wrapper .dt-buttons .btn {
        font-size: .78rem;
        font-weight: 600;
        border-radius: .5rem;
        padding: .5rem .9rem;
        border: 1px solid var(--pkt-border);
        background-color: #fff;
        color: var(--pkt-text);
    }

    #paketTable_wrapper .dt-buttons .btn:hover {
        background-color: var(--pkt-bg-soft);
    }

    #paketTable_wrapper .dt-buttons #add_record_paket,
    #paketTable_wrapper .dt-buttons button[name="add_record_paket"] {
        background-color: var(--pkt-blue) !important;
        border-color: var(--pkt-blue) !important;
        color: #fff !important;
    }

    #paketTable_wrapper .dt-buttons button[name="import_paket"] {
        background-color: #17a568 !important;
        border-color: #17a568 !important;
        color: #fff !important;
    }

    #paketTable_wrapper .dataTables_filter {
        display: none;
    }

    #paketTable_wrapper .dataTables_length {
        display: none;
    }

    #paketTable thead th {
        background-color: var(--pkt-bg-soft) !important;
        font-size: .74rem;
        font-weight: 700;
        color: var(--pkt-text);
        white-space: nowrap;
        border-top: none;
        border-bottom: 1px solid var(--pkt-border);
        padding: .75rem .9rem;
    }

    #paketTable tbody td {
        font-size: .83rem;
        vertical-align: middle;
        color: var(--pkt-text);
        padding: .8rem .9rem;
        border-bottom: 1px solid var(--pkt-border);
        border-top: none;
    }

    #paketTable.table-striped tbody tr:nth-of-type(odd),
    #paketTable.table-striped tbody tr:nth-of-type(even) {
        background-color: #fff;
    }

    #paketTable tbody tr:hover {
        background-color: var(--pkt-bg-soft);
    }

    #paketTable {
        border-collapse: separate;
    }

    .kode-paket-link {
        color: var(--pkt-blue);
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
    }

    .kode-paket-link:hover {
        text-decoration: underline;
        color: var(--pkt-blue-dark);
    }

    .badge-pkt-aktif,
    .badge-pkt-nonaktif {
        display: inline-block;
        font-size: .72rem;
        font-weight: 700;
        padding: .3rem .75rem;
        border-radius: 999px;
    }

    .badge-pkt-aktif {
        background-color: var(--pkt-green-bg);
        color: var(--pkt-green-text);
    }

    .badge-pkt-nonaktif {
        background-color: var(--pkt-gray-bg);
        color: var(--pkt-gray-text);
    }

    .last-updated-date {
        font-weight: 600;
    }

    .last-updated-by {
        font-size: .73rem;
        color: var(--pkt-muted);
        display: block;
    }

    .aksi-cell {
        display: flex;
        align-items: center;
        gap: .55rem;
    }

    .btn-icon-pkt {
        background: transparent;
        border: none;
        padding: 0;
        width: 22px;
        height: 22px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: var(--pkt-muted);
        font-size: .92rem;
    }

    .btn-icon-pkt.view {
        color: var(--pkt-blue);
    }

    .btn-icon-pkt.edit {
        color: #495057;
    }

    .btn-icon-pkt.more {
        color: var(--pkt-muted);
    }

    .btn-icon-pkt:hover {
        opacity: .7;
    }

    .aksi-dropdown {
        position: relative;
        display: inline-block;
    }

    .aksi-dropdown-menu {
        display: none;
        position: absolute;
        right: 0;
        top: 24px;
        z-index: 50;
        background: #fff;
        border: 1px solid var(--pkt-border);
        border-radius: .5rem;
        box-shadow: 0 6px 16px rgba(16, 24, 40, .12);
        min-width: 140px;
        padding: .35rem;
    }

    .aksi-dropdown-menu.show {
        display: block;
    }

    .aksi-dropdown-menu button {
        width: 100%;
        text-align: left;
        border: none;
        background: transparent;
        font-size: .8rem;
        padding: .45rem .6rem;
        border-radius: .35rem;
        color: var(--pkt-text);
    }

    .aksi-dropdown-menu button:hover {
        background-color: var(--pkt-bg-soft);
    }

    .aksi-dropdown-menu button.text-danger-item {
        color: var(--pkt-red);
    }

    .paket-table-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 0;
        flex-wrap: wrap;
        gap: .75rem;
    }

    .paket-table-footer .dataTables_length,
    .paket-table-footer .dataTables_info {
        font-size: .8rem;
        color: var(--pkt-muted);
    }

    .paket-table-footer .dataTables_length select {
        border: 1px solid var(--pkt-border);
        border-radius: .4rem;
        font-size: .8rem;
        padding: .25rem .5rem;
        margin: 0 .35rem;
    }

    #paketTable_wrapper .dataTables_paginate .pagination {
        margin: 0;
    }

    #paketTable_wrapper .dataTables_paginate .page-link {
        border-radius: .4rem !important;
        margin: 0 3px;
        font-size: .8rem;
        color: var(--pkt-text);
        border-color: var(--pkt-border);
        min-width: 32px;
        text-align: center;
    }

    #paketTable_wrapper .dataTables_paginate .page-item.active .page-link {
        background-color: var(--pkt-blue);
        border-color: var(--pkt-blue);
        color: #fff;
    }

    #paketTable_wrapper .dataTables_paginate .page-item.disabled .page-link {
        opacity: .5;
    }

    #modalformpaket .modal-content,
    #modalhargapaket .modal-content,
    #modalimportpaket .modal-content,
    #modalPilihItem .modal-content {
        border-radius: .7rem;
        border: none;
    }

    #modalformpaket .modal-header,
    #modalhargapaket .modal-header,
    #modalPilihItem .modal-header {
        border-bottom: none;
        padding-bottom: .25rem;
    }

    #modalformpaket .modal-title,
    #modalhargapaket .modal-title,
    #modalPilihItem .modal-title {
        font-weight: 700;
        font-size: 1.15rem;
        color: var(--pkt-text);
    }

    html.dark-mode #modalformpaket .modal-title,
    html.dark-mode #modalhargapaket .modal-title,
    html.dark-mode #modalPilihItem .modal-title {
        color: #f1f1f1;
    }

    .paket-stepper {
        display: flex;
        align-items: center;
        padding: .5rem 0 1.25rem;
        margin-bottom: 1.1rem;
        border-bottom: 1px solid var(--pkt-border);
    }

    .paket-stepper .step-item {
        display: flex;
        align-items: center;
        gap: .5rem;
        cursor: pointer;
        flex: 1;
        position: relative;
    }

    .paket-stepper .step-item:not(:last-child)::after {
        content: '';
        flex: 1;
        height: 2px;
        background: var(--pkt-border);
        margin: 0 .75rem;
    }

    .paket-stepper .step-circle {
        width: 26px;
        height: 26px;
        min-width: 26px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .78rem;
        font-weight: 700;
        background-color: var(--pkt-gray-bg);
        color: var(--pkt-muted);
        transition: all .15s ease;
    }

    .paket-stepper .step-label {
        font-size: .82rem;
        font-weight: 600;
        color: var(--pkt-muted);
        white-space: nowrap;
    }

    .paket-stepper .step-item.active .step-circle {
        background-color: var(--pkt-blue);
        color: #fff;
    }

    .paket-stepper .step-item.active .step-label {
        color: var(--pkt-blue);
    }

    .paket-stepper .step-item.done .step-circle {
        background-color: var(--pkt-green-text);
        color: #fff;
    }

    .paket-stepper .step-item.done .step-label {
        color: var(--pkt-text);
    }

    .wizard-pane-title {
        font-weight: 700;
        font-size: .98rem;
        color: var(--pkt-text);
        margin-bottom: .2rem;
    }

    .wizard-pane-sub {
        font-size: .8rem;
        color: var(--pkt-muted);
        margin-bottom: 1rem;
    }

    #data_form_paket .form-group label,
    .paket-field-label {
        font-size: .78rem;
        font-weight: 600;
        color: var(--pkt-text);
        margin-bottom: .3rem;
    }

    #data_form_paket .form-control,
    #data_form_paket select,
    .modal-harga-body .form-control,
    .modal-harga-body select {
        border-radius: .45rem;
        border: 1px solid var(--pkt-border);
        font-size: .82rem;
    }

    .paket-section-title {
        font-weight: 700;
        font-size: .92rem;
        color: var(--pkt-text);
        margin: 1.1rem 0 .8rem;
    }

    .pengaturan-box {
        border-top: 1px solid var(--pkt-border);
        padding-top: .9rem;
        margin-top: .5rem;
    }

    .info-note {
        background-color: var(--pkt-blue-soft);
        border: 1px solid #d6e2fd;
        border-radius: .5rem;
        padding: .7rem .9rem;
        font-size: .78rem;
        color: #35405c;
    }

    .info-note i {
        color: var(--pkt-blue);
        margin-right: .3rem;
    }

    .info-note ul {
        margin: .25rem 0 0 1.1rem;
        padding: 0;
    }

    .warning-note {
        background-color: var(--pkt-amber-bg);
        border: 1px solid var(--pkt-amber-border);
        border-radius: .5rem;
        padding: .7rem .9rem;
        font-size: .78rem;
        color: var(--pkt-amber-text);
    }

    .warning-note i {
        margin-right: .3rem;
    }

    .pkt-switch {
        position: relative;
        display: inline-block;
        width: 40px;
        height: 22px;
    }

    .pkt-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .pkt-switch .slider {
        position: absolute;
        cursor: pointer;
        inset: 0;
        background-color: #ccced3;
        transition: .15s;
        border-radius: 999px;
    }

    .pkt-switch .slider::before {
        content: '';
        position: absolute;
        height: 16px;
        width: 16px;
        left: 3px;
        top: 3px;
        background-color: #fff;
        transition: .15s;
        border-radius: 50%;
    }

    .pkt-switch input:checked+.slider {
        background-color: var(--pkt-blue);
    }

    .pkt-switch input:checked+.slider::before {
        transform: translateX(18px);
    }

    .pkt-switch input:disabled+.slider {
        opacity: .5;
        cursor: not-allowed;
    }

    .ringkasan-box {
        border: 1px solid var(--pkt-border);
        border-radius: .6rem;
        background-color: var(--pkt-bg-soft);
        padding: 1.1rem;
    }

    .ringkasan-icon-box {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 1.4rem 1rem;
        border: 1px dashed #d9dde5;
        border-radius: .5rem;
        background: #fff;
    }

    .ringkasan-icon-box i.icon-empty {
        font-size: 2.1rem;
        color: #e0b98c;
        margin-bottom: .5rem;
    }

    .ringkasan-icon-box .ringkasan-code {
        font-weight: 700;
        color: var(--pkt-blue);
        font-size: .95rem;
    }

    .ringkasan-icon-box .ringkasan-name {
        font-weight: 700;
        color: var(--pkt-text);
        font-size: .92rem;
        margin-top: 2px;
    }

    .ringkasan-icon-box .ringkasan-empty-title {
        font-weight: 700;
        font-size: .92rem;
        color: var(--pkt-text);
    }

    .ringkasan-icon-box .ringkasan-empty-sub {
        font-size: .75rem;
        color: var(--pkt-muted);
        margin-top: 2px;
    }

    .ringkasan-badge-draft {
        display: inline-block;
        margin-top: 4px;
        font-size: .68rem;
        font-weight: 600;
        background: var(--pkt-gray-bg);
        color: var(--pkt-gray-text);
        padding: .15rem .55rem;
        border-radius: 999px;
    }

    .ringkasan-stat-row {
        display: flex;
        justify-content: space-between;
        font-size: .82rem;
        padding: .45rem 0;
        color: var(--pkt-text);
    }

    .ringkasan-stat-row span:first-child {
        color: var(--pkt-muted);
    }

    .ringkasan-stat-row span:last-child {
        font-weight: 700;
    }

    .ringkasan-divider {
        border-top: 1px solid var(--pkt-border);
        margin: .4rem 0;
    }

    .ringkasan-price-box {
        background-color: #eafaf1;
        border: 1px solid #cdefdd;
        border-radius: .5rem;
        padding: .8rem .9rem;
        margin-top: .9rem;
    }

    .ringkasan-price-box .title {
        font-weight: 700;
        font-size: .82rem;
        color: var(--pkt-text);
        margin-bottom: .4rem;
    }

    .ringkasan-price-box .row-item {
        display: flex;
        justify-content: space-between;
        font-size: .8rem;
        padding: .15rem 0;
    }

    .tips-box {
        background-color: var(--pkt-amber-bg);
        border: 1px solid var(--pkt-amber-border);
        border-radius: .5rem;
        padding: .85rem 1rem;
        margin-top: .9rem;
        font-size: .78rem;
        color: #6b551b;
    }

    .tips-box .title {
        font-weight: 700;
        margin-bottom: .35rem;
        color: #6b551b;
    }

    .tips-box i {
        color: #e0a72e;
        margin-right: .3rem;
    }

    .tips-box ul {
        margin: 0;
        padding-left: 1.1rem;
    }

    .komponen-add-box,
    .harga-add-box {
        border: 1px solid var(--pkt-border);
        border-radius: .55rem;
        background: #fff;
        padding: 1rem 1.1rem;
        margin-bottom: 1.1rem;
    }

    .komponen-add-box .title,
    .harga-add-box .title {
        font-weight: 700;
        font-size: .85rem;
        margin-bottom: .8rem;
    }

    .table-mini-title {
        font-weight: 700;
        font-size: .85rem;
        color: var(--pkt-text);
    }

    #tableKomponenPaket,
    #tableHargaPaket {
        font-size: .8rem;
    }

    #tableKomponenPaket thead th,
    #tableHargaPaket thead th {
        background-color: var(--pkt-bg-soft);
        font-size: .72rem;
        font-weight: 700;
        color: var(--pkt-text);
        border-bottom: 1px solid var(--pkt-border);
        white-space: nowrap;
    }

    #tableKomponenPaket td,
    #tableHargaPaket td {
        vertical-align: middle;
    }

    .qty-input,
    .harga-jual-input {
        width: 85px;
        border-radius: .4rem;
        border: 1px solid var(--pkt-border);
        font-size: .8rem;
        padding: .3rem .5rem;
        text-align: right;
    }

    .harga-jual-input {
        width: 120px;
    }

    .btn-row-icon {
        background: transparent;
        border: none;
        padding: 0 4px;
        font-size: .9rem;
    }

    .btn-row-icon.edit {
        color: var(--pkt-orange);
    }

    .btn-row-icon.delete {
        color: var(--pkt-red);
    }

    .stat-card-row {
        display: flex;
        gap: .8rem;
        flex-wrap: wrap;
        margin-top: .5rem;
    }

    .stat-card {
        flex: 1;
        min-width: 140px;
        border: 1px solid var(--pkt-border);
        border-radius: .55rem;
        padding: .8rem .95rem;
        background: #fff;
    }

    .stat-card .label {
        font-size: .74rem;
        color: var(--pkt-muted);
        margin-bottom: .3rem;
    }

    .stat-card .value {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--pkt-text);
    }

    .stat-card .value.green {
        color: var(--pkt-green-text);
    }

    .step-num-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: var(--pkt-blue);
        color: #fff;
        font-size: .72rem;
        font-weight: 700;
        margin-right: .4rem;
    }

    .modal-harga-section-title {
        font-weight: 700;
        font-size: .88rem;
        margin: 1rem 0 .7rem;
        display: flex;
        align-items: center;
    }

    #tablePilihItem {
        font-size: 0.82rem;
        margin-bottom: 0;
    }

    #tablePilihItem thead th {
        background-color: var(--pkt-bg-soft) !important;
        font-size: 0.72rem;
        font-weight: 700;
        color: var(--pkt-text);
        border-bottom: 2px solid var(--pkt-border);
        padding: 0.5rem 0.7rem;
        white-space: nowrap;
    }

    #tablePilihItem tbody td {
        padding: 0.45rem 0.7rem;
        vertical-align: middle;
        border-bottom: 1px solid var(--pkt-border);
        cursor: pointer;
    }

    #tablePilihItem tbody tr:hover {
        background-color: var(--pkt-blue-soft) !important;
        cursor: pointer;
    }

    #tablePilihItem tbody tr.selected-item {
        background-color: var(--pkt-blue-soft) !important;
        border-left: 3px solid var(--pkt-blue);
    }

    .btn-pilih-item {
        padding: 0.15rem 0.5rem;
        font-size: 0.72rem;
        border-radius: 0.3rem;
        border: none;
        background-color: var(--pkt-blue);
        color: #fff;
        transition: all 0.15s;
    }

    .btn-pilih-item:hover {
        background-color: var(--pkt-blue-dark);
        color: #fff;
    }

    .btn-pilih-item:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .highlight-match {
        background-color: #ffeb3b;
        padding: 0 2px;
        border-radius: 2px;
    }

    #komponen_search_results {
        position: absolute;
        z-index: 100;
        width: 100%;
        background: #fff;
        border: 1px solid var(--pkt-border);
        border-radius: .45rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, .1);
        max-height: 200px;
        overflow-y: auto;
    }

    #komponen_search_results .list-group-item {
        border: none;
        border-bottom: 1px solid var(--pkt-border);
        padding: .5rem .8rem;
        font-size: .8rem;
        cursor: pointer;
    }

    #komponen_search_results .list-group-item:last-child {
        border-bottom: none;
    }

    #komponen_search_results .list-group-item:hover {
        background-color: var(--pkt-blue-soft);
    }

    html.dark-mode .content-wrapper {
        background-color: #24282e;
    }

    html.dark-mode .paket-card,
    html.dark-mode .komponen-add-box,
    html.dark-mode .harga-add-box,
    html.dark-mode .stat-card,
    html.dark-mode .modal-content,
    html.dark-mode #komponen_search_results {
        background-color: #343a40;
        border-color: #454d55;
    }

    html.dark-mode .ringkasan-box {
        background-color: #2b3035;
        border-color: #454d55;
    }

    html.dark-mode .ringkasan-icon-box {
        background-color: #343a40;
        border-color: #555d66;
    }

    html.dark-mode .paket-title,
    html.dark-mode .wizard-pane-title,
    html.dark-mode .table-mini-title,
    html.dark-mode .paket-field-label,
    html.dark-mode .paket-section-title,
    html.dark-mode .stat-card .value,
    html.dark-mode .stat-card .label,
    html.dark-mode .komponen-add-box .title,
    html.dark-mode .harga-add-box .title,
    html.dark-mode .modal-title,
    html.dark-mode .ringkasan-empty-title,
    html.dark-mode .ringkasan-code,
    html.dark-mode .ringkasan-name,
    html.dark-mode .total-label {
        color: #f1f1f1;
    }

    html.dark-mode .paket-subtitle,
    html.dark-mode .last-updated-by,
    html.dark-mode .wizard-pane-sub,
    html.dark-mode .paket-filter-card label,
    html.dark-mode .paket-table-footer .dataTables_info,
    html.dark-mode .ringkasan-empty-sub,
    html.dark-mode .ringkasan-stat-row {
        color: #adb5bd;
    }

    html.dark-mode .ringkasan-stat-row span:last-child {
        color: #f1f1f1;
    }

    html.dark-mode #paketTable thead th,
    html.dark-mode #tableKomponenPaket thead th,
    html.dark-mode #tableHargaPaket thead th,
    html.dark-mode #tablePilihItem thead th {
        background-color: #2b3035 !important;
        border-color: #454d55 !important;
        color: #adb5bd;
    }

    html.dark-mode #paketTable tbody td,
    html.dark-mode #tableKomponenPaket tbody td,
    html.dark-mode #tableHargaPaket tbody td,
    html.dark-mode #tablePilihItem tbody td {
        color: #dee2e6;
        border-color: #454d55;
    }

    html.dark-mode #paketTable.table-striped tbody tr:nth-of-type(odd),
    html.dark-mode #paketTable.table-striped tbody tr:nth-of-type(even) {
        background-color: #343a40;
    }

    html.dark-mode #paketTable tbody tr:hover,
    html.dark-mode #tableKomponenPaket tbody tr:hover,
    html.dark-mode #tableHargaPaket tbody tr:hover,
    html.dark-mode #tablePilihItem tbody tr:hover {
        background-color: #3a4149 !important;
    }

    html.dark-mode #modalformpaket .modal-body,
    html.dark-mode #modalhargapaket .modal-body,
    html.dark-mode #modalimportpaket .modal-body,
    html.dark-mode #modalPilihItem .modal-body {
        color: #dee2e6;
    }

    html.dark-mode #data_form_paket .form-group label,
    html.dark-mode .paket-field-label,
    html.dark-mode .modal-body label,
    html.dark-mode .modal-body .form-group label {
        color: #dee2e6;
    }

    html.dark-mode .icheck-primary label,
    html.dark-mode .icheck-primary>label {
        color: #dee2e6;
    }

    html.dark-mode .modal-header {
        border-color: #454d55;
    }

    html.dark-mode .modal-footer {
        border-color: #454d55;
        background-color: #343a40;
    }

    html.dark-mode .modal-footer .btn {
        color: #f1f1f1;
    }

    html.dark-mode select.form-control-sm option {
        background-color: #2b3035;
        color: #f1f1f1;
    }

    html.dark-mode input[type="date"].form-control-sm {
        color-scheme: dark;
    }

    html.dark-mode .paket-filter-card .form-control,
    html.dark-mode .paket-filter-card select,
    html.dark-mode #data_form_paket .form-control,
    html.dark-mode #data_form_paket select,
    html.dark-mode .modal-harga-body .form-control,
    html.dark-mode .modal-harga-body select,
    html.dark-mode .qty-input,
    html.dark-mode .harga-jual-input {
        background-color: #2b3035;
        border-color: #555d66;
        color: #f1f1f1;
    }

    html.dark-mode .paket-filter-card .form-control::placeholder {
        color: #6c757d;
    }

    html.dark-mode .paket-search-wrap i {
        color: #6c757d;
    }

    html.dark-mode #komponen_search_results .list-group-item {
        border-color: #454d55;
        color: #dee2e6;
    }

    html.dark-mode #komponen_search_results .list-group-item:hover {
        background-color: #3a4149;
    }

    html.dark-mode #paketTable_wrapper .dataTables_paginate .page-link {
        background-color: #343a40;
        border-color: #454d55;
        color: #adb5bd;
    }

    html.dark-mode #paketTable_wrapper .dataTables_paginate .page-item.active .page-link {
        background-color: var(--pkt-blue);
        border-color: var(--pkt-blue);
        color: #fff;
    }

    html.dark-mode .paket-table-footer .dataTables_length select {
        background-color: #2b3035;
        border-color: #555d66;
        color: #f1f1f1;
    }

    html.dark-mode #paketTable_wrapper .dt-buttons .btn {
        background-color: #343a40;
        border-color: #454d55;
        color: #f1f1f1;
    }

    html.dark-mode .badge-pkt-nonaktif {
        background-color: #495057;
        color: #adb5bd;
    }

    html.dark-mode .aksi-dropdown-menu {
        background-color: #343a40;
        border-color: #454d55;
    }

    html.dark-mode .aksi-dropdown-menu button {
        color: #f1f1f1;
    }

    html.dark-mode .aksi-dropdown-menu button:hover {
        background-color: #3a4149;
    }

    html.dark-mode .btn-icon-pkt.edit,
    html.dark-mode .btn-icon-pkt.more {
        color: #adb5bd;
    }

    html.dark-mode .btn-icon-pkt.delete {
        color: #ff6b6b;
    }

    html.dark-mode .btn-row-icon.edit {
        color: #ffa94d;
    }

    html.dark-mode .btn-row-icon.delete {
        color: #ff6b6b;
    }

    html.dark-mode .step-circle {
        background-color: #454d55;
        color: #adb5bd;
    }

    html.dark-mode .step-item.active .step-circle {
        background-color: var(--pkt-blue);
        color: #fff;
    }

    html.dark-mode .step-item.done .step-circle {
        background-color: var(--pkt-green-text);
        color: #fff;
    }

    html.dark-mode .step-label {
        color: #adb5bd;
    }

    html.dark-mode .step-item.active .step-label {
        color: var(--pkt-blue);
    }

    html.dark-mode .step-item.done .step-label {
        color: #f1f1f1;
    }

    html.dark-mode .paket-stepper {
        border-color: #454d55;
    }

    html.dark-mode .paket-stepper .step-item:not(:last-child)::after {
        background: #454d55;
    }

    html.dark-mode .ringkasan-price-box {
        background-color: #1e3a2f;
        border-color: #2d5a44;
    }

    html.dark-mode .ringkasan-price-box .title {
        color: #86efac;
    }

    html.dark-mode .ringkasan-price-box .row-item {
        color: #dee2e6;
    }

    html.dark-mode .ringkasan-badge-draft {
        background-color: #495057;
        color: #adb5bd;
    }

    html.dark-mode .info-note {
        background-color: #1a2a3f;
        border-color: #2a4060;
        color: #93c5fd;
    }

    html.dark-mode .info-note i {
        color: #60a5fa;
    }

    html.dark-mode .warning-note {
        background-color: #3a2e10;
        border-color: #5a4a20;
        color: #fcd34d;
    }

    html.dark-mode .btn-pkt-outline {
        background-color: #343a40;
        border-color: #454d55;
        color: #f1f1f1;
    }

    html.dark-mode .btn-pkt-outline:hover {
        background-color: #3a4149;
    }

    html.dark-mode .tips-box {
        background-color: #3a2e10;
        border-color: #5a4a20;
        color: #fcd34d;
    }

    html.dark-mode .tips-box .title {
        color: #fcd34d;
    }

    html.dark-mode .tips-box i {
        color: #fbbf24;
    }

    html.dark-mode .pkt-switch .slider {
        background-color: #555d66;
    }

    html.dark-mode .pengaturan-box {
        border-color: #454d55;
    }

    html.dark-mode .table-responsive {
        border-color: #454d55;
    }

    html.dark-mode .page-link {
        background-color: #343a40;
        border-color: #454d55;
        color: #adb5bd;
    }

    html.dark-mode .swal2-popup {
        background-color: #343a40;
        color: #dee2e6;
    }

    html.dark-mode .swal2-title {
        color: #f1f1f1;
    }

    html.dark-mode .swal2-html-container {
        color: #dee2e6;
    }
</style>
<?= $this->endSection('style'); ?>

<?= $this->section('content'); ?>
<?php $session = session(); ?>

<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">

            <div class="paket-page-head">
                <div>
                    <h1 class="paket-title">Master Paket</h1>
                    <div class="paket-subtitle">Kelola data paket tindakan / layanan klinik</div>
                </div>
                <div>
                </div>
            </div>

            <div class="paket-card paket-filter-card">
                <div class="row">
                    <div class="col-md-4 mb-2 mb-md-0">
                        <label>Cari Paket</label>
                        <div class="paket-search-wrap">
                            <input type="text" class="form-control form-control-sm" id="f_cari_paket" placeholder="Cari kode / nama paket">
                            <i class="fas fa-search"></i>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2 mb-md-0">
                        <label>Kategori</label>
                        <select class="form-control form-control-sm" id="f_kategori">
                            <option value="">Semua Kategori</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2 mb-md-0">
                        <label>Status</label>
                        <select class="form-control form-control-sm" id="f_status">
                            <option value="">Semua Status</option>
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Non-Aktif</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn-pkt-outline btn-block" id="btn_reset_filter_paket">
                            <i class="fas fa-sync-alt mr-1"></i> Reset Filter
                        </button>
                    </div>
                </div>
            </div>

            <div class="paket-card paket-table-card">
                <div class="paket-table-toolbar">
                    <div class="total-label" id="paket_total_label">Total 0 Data</div>
                </div>

                <div class="table-responsive">
                    <table id="paketTable" class="table table-sm table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Paket</th>
                                <th>Nama Paket</th>
                                <th>Kategori</th>
                                <th>Harga Jual</th>
                                <th>Status</th>
                                <th>Terakhir Diperbarui</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <div class="paket-table-footer" id="paket_custom_footer" style="display:none;"></div>
            </div>

            <div class="modal fade" id="modalformpaket" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"></h4>
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="post" id="data_form_paket" autocomplete="off">
                            <?= csrf_field(); ?>
                            <div class="modal-body">

                                <div class="paket-stepper">
                                    <div class="step-item active" data-step="1">
                                        <div class="step-circle">1</div>
                                        <div class="step-label">Informasi Paket</div>
                                    </div>
                                    <div class="step-item" data-step="2">
                                        <div class="step-circle">2</div>
                                        <div class="step-label">Komponen Paket</div>
                                    </div>
                                    <div class="step-item" data-step="3">
                                        <div class="step-circle">3</div>
                                        <div class="step-label">Harga Paket</div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-8">

                                        <div class="wizard-pane" id="step_pane_1">
                                            <div class="wizard-pane-title">Informasi Paket</div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="paket-field-label">Kode Paket</label>
                                                        <input type="text" class="form-control form-control-sm" id="kodePaket" name="kodePaket" placeholder="Otomatis dibuat oleh sistem" disabled>
                                                        <span class="error invalid-feedback errorKodePaket"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="paket-field-label">Nama Paket <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control form-control-sm" id="namaPaket" name="namaPaket" placeholder="Masukkan nama paket">
                                                        <span class="error invalid-feedback errorNamaPaket"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="paket-field-label">Kategori <span class="text-danger">*</span></label>

                                                        <?= view('components/dropdown2', [
                                                            'id'      => 'kategoriId',
                                                            'name'      => 'kategoriId',
                                                            'apiUrl'    => base_url('/dropdown/server5/1/1/item-categories/null/action/getall/null/null'),
                                                            'extraKeys' => [],
                                                            'selected'  => '',
                                                            'errors'    => $errors ?? []
                                                        ]) ?>

                                                        <span class="error invalid-feedback errorKategoriId"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="paket-field-label">Deskripsi</label>
                                                        <textarea class="form-control form-control-sm" id="deskripsi" name="deskripsi" rows="1" maxlength="250" placeholder="Masukkan deskripsi paket (opsional)"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="paket-field-label">Satuan Dasar <span class="text-danger">*</span></label>
                                                        <?= view('components/dropdown', [
                                                            'name'      => 'satuanDasar',
                                                            'apiUrl'    => base_url('tmstpaketbaru/getSatuanDropdown'),
                                                            'extraKeys' => [],
                                                            'selected'  => '',
                                                            'errors'    => $errors ?? []
                                                        ]) ?>
                                                        <span class="error invalid-feedback errorSatuanDasar"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="paket-field-label">Status <span class="text-danger">*</span></label><br>
                                                        <div class="icheck-primary d-inline-block mr-3">
                                                            <input type="radio" id="statusAktif" name="statusRadio" value="1" checked>
                                                            <label for="statusAktif">Aktif</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline-block">
                                                            <input type="radio" id="statusNonAktif" name="statusRadio" value="0">
                                                            <label for="statusNonAktif">Non-Aktif</label>
                                                        </div>
                                                        <input type="hidden" id="isActive" name="isActive" value="1">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="pengaturan-box">
                                                <div class="paket-section-title" style="margin-top:0;">Pengaturan Paket</div>
                                                <div class="row">
                                                    <div class="col-md-3 mb-2">
                                                        <label class="paket-field-label">Tipe Paket</label><br>
                                                        <div class="icheck-primary d-inline-block mr-3">
                                                            <input type="radio" id="tipeStandar" name="tipePaket" value="standar" checked>
                                                            <label for="tipeStandar">Standar</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline-block">
                                                            <input type="radio" id="tipeCustom" name="tipePaket" value="custom">
                                                            <label for="tipeCustom">Custom</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mb-2">
                                                        <label class="paket-field-label">Berlaku Untuk</label>
                                                        <select class="form-control form-control-sm" id="berlakuUntuk" name="berlakuUntuk">
                                                            <option value="semua_outlet">Semua Outlet</option>
                                                            <option value="outlet_tertentu">Outlet Tertentu</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mb-2">
                                                        <label class="paket-field-label">Berlaku Mulai</label>
                                                        <input type="date" class="form-control form-control-sm" id="berlakuMulai" name="berlakuMulai">
                                                    </div>
                                                    <div class="col-md-3 mb-2">
                                                        <label class="paket-field-label">Berlaku Sampai</label>
                                                        <input type="date" class="form-control form-control-sm" id="berlakuSampai" name="berlakuSampai">
                                                    </div>
                                                </div>

                                                <div class="info-note mb-3">
                                                    <i class="fas fa-info-circle"></i><strong>Tipe Paket Standar:</strong> komposisi paket bersifat tetap untuk semua outlet.<br>
                                                    <span style="margin-left:1.1rem; display:inline-block;"><strong>Tipe Paket Custom:</strong> komposisi dapat berbeda berdasarkan outlet (jika diperlukan).</span>
                                                </div>

                                                <div class="form-group mb-0">
                                                    <label class="paket-field-label">Catatan Internal (Opsional)</label>
                                                    <textarea class="form-control form-control-sm" id="catatanInternal" name="catatanInternal" rows="2" maxlength="250" placeholder="Masukkan catatan internal"></textarea>
                                                </div>
                                            </div>

                                            <div id="auditFieldsPaket" style="display:none;" class="pengaturan-box">
                                                <div class="paket-section-title" style="margin-top:0;">Informasi Audit</div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-2">
                                                        <label class="paket-field-label">Created By</label>
                                                        <input type="text" class="form-control form-control-sm" id="createdBy" readonly>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <label class="paket-field-label">Created Date</label>
                                                        <input type="text" class="form-control form-control-sm" id="createdDate" readonly>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <label class="paket-field-label">Updated By</label>
                                                        <input type="text" class="form-control form-control-sm" id="updatedBy" readonly>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <label class="paket-field-label">Updated Date</label>
                                                        <input type="text" class="form-control form-control-sm" id="updatedDate" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="wizard-pane" id="step_pane_2" style="display:none;">
                                            <div class="wizard-pane-title">Komponen Paket</div>
                                            <div class="wizard-pane-sub">Tambahkan obat, alat kesehatan, atau jasa/tindakan sebagai komponen paket.</div>

                                            <div class="komponen-add-box">
                                                <div class="title">Tambah Komponen</div>
                                                <div class="row align-items-end">
                                                    <div class="col-md-9 mb-2">
                                                        <label class="paket-field-label">Cari Item <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <input type="text"
                                                                class="form-control form-control-sm"
                                                                id="komponen_cari_item"
                                                                placeholder="Ketik kode / nama item, lalu ENTER"
                                                                autocomplete="off">
                                                            <div class="input-group-append">
                                                                <button class="btn btn-primary btn-sm" type="button" id="btn_cari_item_modal" title="Cari di modal">
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <small class="text-muted" id="komponen_cari_status">Ketik kode/nama lalu ENTER atau klik "Tambah" untuk tambah langsung, atau klik 🔍 untuk cari di modal</small>
                                                        <div id="komponen_search_results" class="list-group" style="display:none; max-height:200px; overflow:auto; margin-top:.4rem;"></div>
                                                    </div>
                                                    <div class="col-md-3 mb-2">
                                                        <button type="button" class="btn-pkt-primary btn-block" id="btn_tambah_komponen">
                                                            <i class="fas fa-plus mr-1"></i> Tambah
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div class="table-mini-title">Daftar Komponen (<span id="komponen_count">0</span> Item)</div>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table table-sm table-bordered mb-2" id="tableKomponenPaket">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Kode Item</th>
                                                            <th>Nama Item</th>
                                                            <th>Tipe</th>
                                                            <th>Satuan</th>
                                                            <th>Qty</th>
                                                            <th>Harga Satuan (Rp)</th>
                                                            <th>Subtotal (Rp)</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="9" class="text-center text-muted">Belum ada komponen.</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <div>
                                                    <button type="button" class="btn-pkt-outline" id="btn_hapus_semua_komponen">
                                                        <i class="fas fa-trash-alt mr-1"></i> Hapus Semua Komponen
                                                    </button>
                                                </div>
                                                <div>
                                                    <span class="font-weight-bold ml-3">Total&nbsp; <span id="komponen_total_text">Rp 0</span></span>
                                                </div>
                                            </div>

                                            <div class="info-note">
                                                <i class="fas fa-info-circle"></i><strong>Informasi</strong>
                                                <ul>
                                                    <li>Pastikan komponen yang ditambahkan sudah memiliki satuan dan harga.</li>
                                                    <li>Harga satuan mengikuti harga jual saat ini pada satuan yang dipilih.</li>
                                                    <li>Klik <strong>"Selanjutnya"</strong> untuk menyimpan semua perubahan komponen ke server.</li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="wizard-pane" id="step_pane_3" style="display:none;">
                                            <div class="wizard-pane-title">Harga Paket</div>
                                            <div class="wizard-pane-sub">Tentukan harga jual paket untuk setiap kelas harga dan periode berlaku.</div>

                                            <div class="harga-add-box">
                                                <div class="row align-items-end">
                                                    <div class="col-md-3 mb-2">
                                                        <label class="paket-field-label">Kelas Harga <span class="text-danger">*</span></label>
                                                        <select class="form-control form-control-sm" id="harga_kelas">
                                                            <option value="">Pilih kelas harga</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mb-2">
                                                        <label class="paket-field-label">Mata Uang <span class="text-danger">*</span></label>
                                                        <select class="form-control form-control-sm" id="harga_mata_uang">
                                                            <option value="IDR">IDR - Rupiah</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mb-2">
                                                        <label class="paket-field-label">Berlaku Mulai <span class="text-danger">*</span></label>
                                                        <input type="date" class="form-control form-control-sm" id="harga_berlaku_mulai">
                                                    </div>
                                                    <div class="col-md-3 mb-2">
                                                        <button type="button" class="btn-pkt-primary btn-block" id="btn_tambah_harga">
                                                            <i class="fas fa-plus mr-1"></i> Tambah Harga
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="table-mini-title mb-2">Daftar Harga Paket (<span id="harga_count">0</span> Data)</div>

                                            <div class="table-responsive">
                                                <table class="table table-sm table-bordered mb-3" id="tableHargaPaket">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Kelas Harga</th>
                                                            <th>Mata Uang</th>
                                                            <th>Harga Jual (Rp)</th>
                                                            <th>Berlaku Mulai</th>
                                                            <th>Berlaku Sampai</th>
                                                            <th>Aktif</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="8" class="text-center text-muted">Belum ada harga paket.</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="info-note mb-3">
                                                <i class="fas fa-info-circle"></i><strong>Informasi</strong>
                                                <ul>
                                                    <li>Harga paket wajib diisi minimal untuk 1 kelas harga.</li>
                                                    <li>Harga jual tidak termasuk pajak (jika ada).</li>
                                                    <li>Setiap harga yang ditambahkan atau diubah langsung tersimpan ke server.</li>
                                                </ul>
                                            </div>

                                            <div class="paket-section-title">Ringkasan Perhitungan</div>
                                            <div class="stat-card-row mb-3">
                                                <div class="stat-card">
                                                    <div class="label">Total Komponen</div>
                                                    <div class="value" id="calc_total_komponen">0 Item</div>
                                                </div>
                                                <div class="stat-card">
                                                    <div class="label">Estimasi HPP</div>
                                                    <div class="value" id="calc_hpp">Rp 0</div>
                                                </div>
                                                <div class="stat-card">
                                                    <div class="label">Harga Jual (Rata-rata)</div>
                                                    <div class="value" id="calc_harga_jual">Rp 0</div>
                                                </div>
                                                <div class="stat-card">
                                                    <div class="label">Estimasi Margin</div>
                                                    <div class="value green" id="calc_margin">0 %</div>
                                                </div>
                                                <div class="stat-card">
                                                    <div class="label">Estimasi Keuntungan</div>
                                                    <div class="value green" id="calc_untung">Rp 0</div>
                                                </div>
                                            </div>

                                            <div class="warning-note">
                                                <i class="fas fa-exclamation-triangle"></i>
                                                Estimasi margin dan keuntungan dihitung berdasarkan rata-rata harga jual dan estimasi HPP.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="ringkasan-box">
                                            <div class="font-weight-bold mb-2" style="font-size:.9rem;">Ringkasan Paket</div>

                                            <div class="ringkasan-icon-box" id="ringkasan_step1_box">
                                                <i class="fas fa-box-open icon-empty"></i>
                                                <div class="ringkasan-empty-title">Belum ada komponen</div>
                                                <div class="ringkasan-empty-sub">Tambahkan komponen pada langkah berikutnya.</div>
                                            </div>
                                            <div class="ringkasan-icon-box" id="ringkasan_filled_box" style="display:none; align-items:flex-start; text-align:left;">
                                                <div style="display:flex; align-items:center; gap:.6rem; width:100%;">
                                                    <i class="fas fa-cube" style="font-size:1.4rem; color: var(--pkt-blue);"></i>
                                                    <div>
                                                        <div class="ringkasan-code" id="ringkasan_kode">PKT-00000</div>
                                                        <div class="ringkasan-name" id="ringkasan_nama">Nama Paket</div>
                                                        <span class="ringkasan-badge-draft" id="ringkasan_status_draft">Belum disimpan</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="ringkasan-stat-row"><span>Jumlah Komponen</span><span id="rk_jumlah_komponen">0 Item</span></div>
                                            <div class="ringkasan-stat-row"><span>Estimasi HPP</span><span id="rk_hpp">Rp 0</span></div>
                                            <div class="ringkasan-stat-row"><span>Harga Jual<span id="rk_harga_jual_label"></span></span><span id="rk_harga_jual">Rp 0</span></div>
                                            <div class="ringkasan-divider"></div>
                                            <div class="ringkasan-stat-row"><span>Estimasi Margin</span><span id="rk_margin">0 %</span></div>
                                            <div class="ringkasan-stat-row"><span>Estimasi Keuntungan</span><span id="rk_untung">Rp 0</span></div>

                                            <div class="ringkasan-price-box" id="rk_price_box" style="display:none;">
                                                <div class="title">Daftar Harga Paket</div>
                                                <div id="rk_price_list"></div>
                                            </div>

                                            <div class="tips-box">
                                                <div class="title"><i class="fas fa-lightbulb"></i>Tips</div>
                                                <ul id="rk_tips_list">
                                                    <li>Tambahkan komponen paket pada langkah 2.</li>
                                                    <li>Harga paket dapat ditentukan pada langkah 3.</li>
                                                    <li>Pastikan semua informasi sudah benar sebelum menyimpan.</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer justify-content-between">
                                <div>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="btn_wizard_prev" style="display:none;">
                                        <i class="fas fa-arrow-left mr-1"></i> Sebelumnya
                                    </button>
                                </div>
                                <div>
                                    <input type="hidden" id="hidden_id_paket" name="hidden_id">
                                    <input type="hidden" id="action_paket" name="action" value="Add">
                                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                                    <button type="button" class="btn-pkt-primary" id="btn_wizard_next" style="border-radius:.5rem; padding:.5rem 1rem; font-size:.82rem;">
                                        Selanjutnya <i class="fas fa-arrow-right ml-1"></i>
                                    </button>
                                    <button type="submit" id="submit_button_paket" class="btn-pkt-primary" style="display:none; border-radius:.5rem; padding:.5rem 1rem; font-size:.82rem;">
                                        <i class="fas fa-save mr-1"></i> Simpan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalhargapaket" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div>
                                <h4 class="modal-title">Tambah Harga Paket</h4>
                                <div class="paket-subtitle" style="margin-top:2px;">Tambahkan harga jual paket untuk kelas harga tertentu</div>
                            </div>
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body modal-harga-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="modal-harga-section-title"><span class="step-num-badge">1</span> Informasi Harga</div>
                                    <div class="row">
                                        <div class="col-md-4 mb-2">
                                            <label class="paket-field-label">Kelas Harga <span class="text-danger">*</span></label>
                                            <select class="form-control form-control-sm" id="mh_kelas_harga">
                                                <option value="">Pilih kelas harga</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label class="paket-field-label">Mata Uang <span class="text-danger">*</span></label>
                                            <select class="form-control form-control-sm" id="mh_mata_uang">
                                                <option value="IDR">IDR - Rupiah</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label class="paket-field-label">Harga Jual (Rp) <span class="text-danger">*</span></label>
                                            <input type="number" min="0" class="form-control form-control-sm" id="mh_harga_jual" placeholder="0">
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label class="paket-field-label">Berlaku Mulai <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control form-control-sm" id="mh_berlaku_mulai">
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label class="paket-field-label">Berlaku Sampai</label>
                                            <input type="date" class="form-control form-control-sm" id="mh_berlaku_sampai">
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label class="paket-field-label d-block">Status <span class="text-danger">*</span></label>
                                            <select class="form-control form-control-sm" id="mh_status">
                                                <option value="1">Aktif</option>
                                                <option value="0">Non-Aktif</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-2 d-flex align-items-center">
                                            <div class="icheck-primary">
                                                <input type="checkbox" id="mh_tanpa_batas">
                                                <label for="mh_tanpa_batas">Tanpa Batas</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-harga-section-title"><span class="step-num-badge">2</span> Keterangan (Opsional)</div>
                                    <div class="form-group">
                                        <label class="paket-field-label">Keterangan / Catatan</label>
                                        <textarea class="form-control form-control-sm" id="mh_keterangan" rows="3" maxlength="250" placeholder="Masukkan keterangan harga paket (opsional)"></textarea>
                                    </div>

                                    <div class="modal-harga-section-title"><span class="step-num-badge">3</span> Preview &amp; Estimasi</div>
                                    <div class="stat-card-row mb-2">
                                        <div class="stat-card">
                                            <div class="label">Total Komponen</div>
                                            <div class="value" id="mh_calc_total_komponen">0 Item</div>
                                        </div>
                                        <div class="stat-card">
                                            <div class="label">Estimasi HPP</div>
                                            <div class="value" id="mh_calc_hpp">Rp 0</div>
                                        </div>
                                        <div class="stat-card">
                                            <div class="label">Harga Jual</div>
                                            <div class="value" id="mh_calc_harga_jual">Rp 0</div>
                                        </div>
                                        <div class="stat-card">
                                            <div class="label">Estimasi Margin</div>
                                            <div class="value green" id="mh_calc_margin">0 %</div>
                                        </div>
                                        <div class="stat-card">
                                            <div class="label">Estimasi Keuntungan</div>
                                            <div class="value green" id="mh_calc_untung">Rp 0</div>
                                        </div>
                                    </div>
                                    <div class="info-note">
                                        <i class="fas fa-info-circle"></i> Margin dan keuntungan dihitung berdasarkan estimasi HPP saat ini.
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="ringkasan-box">
                                        <div class="font-weight-bold mb-2" style="font-size:.9rem;">Ringkasan Paket</div>
                                        <div style="display:flex; align-items:center; gap:.6rem;">
                                            <i class="fas fa-cube" style="font-size:1.4rem; color: var(--pkt-blue);"></i>
                                            <div>
                                                <div class="ringkasan-code" id="mh_ringkasan_kode">PKT-00000</div>
                                                <div class="ringkasan-name" id="mh_ringkasan_nama">Nama Paket</div>
                                                <span class="ringkasan-badge-draft">Belum disimpan</span>
                                            </div>
                                        </div>
                                        <div class="ringkasan-divider"></div>
                                        <div class="ringkasan-stat-row"><span>Jumlah Komponen</span><span id="mh_rk_jumlah">0 Item</span></div>
                                        <div class="ringkasan-stat-row"><span>Estimasi HPP</span><span id="mh_rk_hpp">Rp 0</span></div>
                                        <div class="ringkasan-stat-row"><span>Harga Jual (Rata-rata)</span><span id="mh_rk_harga">Rp 0</span></div>
                                        <div class="ringkasan-stat-row"><span>Estimasi Margin</span><span id="mh_rk_margin">0 %</span></div>
                                        <div class="ringkasan-stat-row"><span>Estimasi Keuntungan</span><span id="mh_rk_untung">Rp 0</span></div>

                                        <div class="tips-box">
                                            <div class="title"><i class="fas fa-lightbulb"></i>Tips</div>
                                            <ul>
                                                <li>Pastikan tanggal berlaku tidak tumpang tindih dengan harga lain pada kelas harga yang sama.</li>
                                                <li>Harga akan digunakan saat transaksi penjualan sesuai periode berlaku.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" id="mh_edit_index" value="">
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                                <i class="fas fa-times mr-1"></i> Batal
                            </button>
                            <button type="button" class="btn-pkt-primary" id="btn_simpan_harga" style="border-radius:.5rem; padding:.5rem 1rem; font-size:.82rem;">
                                <i class="fas fa-save mr-1"></i> Simpan Harga
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalPilihItem" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div>
                                <h4 class="modal-title">Cari Item</h4>
                                <div class="paket-subtitle" style="margin-top:2px;">Cari dan pilih item untuk ditambahkan sebagai komponen paket</div>
                            </div>
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" id="modal_cari_item" placeholder="Cari kode / nama item...">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary btn-sm" type="button" id="btn_modal_cari">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <!-- <select class="form-control form-control-sm" id="modal_filter_tipe">
                                        <option value="">Semua Tipe</option>
                                    </select> -->
                                    <?= view('components/dropdown2', [
                                        'id'      => 'modal_filter_tipe',
                                        'name'      => 'modal_filter_tipe',
                                        'apiUrl'    => base_url('/dropdown/server5/1/1/item-types/null/action/getall/null/null'),
                                        'extraKeys' => [],
                                        'selected'  => '',
                                        'errors'    => $errors ?? []
                                    ]) ?>

                                    <span class="error invalid-feedback errorKategoriId"></span>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn-pkt-outline btn-block btn-sm" id="btn_modal_reset">
                                        <i class="fas fa-sync-alt mr-1"></i> Reset
                                    </button>
                                </div>
                            </div>

                            <div id="modal_item_loading" class="text-center py-4" style="display:none;">
                                <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
                                <p class="mt-2 text-muted">Memuat data...</p>
                            </div>

                            <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                <table class="table table-sm table-hover table-bordered" id="tablePilihItem">
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
                                    <tbody id="modal_item_tbody">
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-3">
                                                <i class="fas fa-search mr-2"></i> Ketik kata kunci untuk mencari item
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div class="text-muted small" id="modal_item_info">Menampilkan 0 item</div>
                                <div>
                                    <span class="badge badge-info" id="modal_item_count">0</span> item ditemukan
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

            <div class="modal fade" id="modalimportpaket" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"></h4>
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="<?= site_url('tmstpaketbaru/preview') ?>" id="uploadFormPaket" method="post" enctype="multipart/form-data">
                                <?= csrf_field(); ?>
                                <label for="filenamePaket">Import Excel File : <a href="<?= site_url('tmstpaketbaru/download') ?>"><u>Download Format</u></a></label><br>
                                <input type="file" name="filename" id="filenamePaket">
                                <button type="submit" name="preview" class="btn btn-sm btn-primary" id="previewPaket">Preview</button>
                            </form>
                            <div id="viewpreviewpaket"></div><br>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<?= $this->endSection('content'); ?>

<?= $this->section('script'); ?>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<script>
    $('#active-menu').html($('p#active-menu').html());
    $(document).prop("title", $('p#active-menu').html());
</script>

<script>
    $(document).ready(function() {

        var currentStep = 1;
        var totalSteps = 3;
        var komponenList = [];
        var hargaList = [];
        var modalItemList = [];
        var isSubmittingStep1 = false;

        window.currentPaketCode = null;
        window.isEditModePaket = false;
        window.isViewModePaket = false;
        window.currentPaketUomId = null;

        function checkSession(response) {
            if (response && response.status === 'session_expired') {
                window.location.href = "<?= base_url('auth/login') ?>";
                return false;
            }
            return true;
        }

        function formatDate(dateString) {
            if (!dateString) return '-';
            try {
                const date = new Date(dateString);
                const day = String(date.getDate()).padStart(2, '0');
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const year = date.getFullYear();
                const hours = String(date.getHours()).padStart(2, '0');
                const minutes = String(date.getMinutes()).padStart(2, '0');
                return `${day}/${month}/${year} ${hours}:${minutes}`;
            } catch (e) {
                return dateString;
            }
        }

        function formatDateShort(dateString) {
            if (!dateString) return '-';
            const p = dateString.split('-');
            if (p.length === 3) return `${p[2]}/${p[1]}/${p[0]}`;
            return dateString;
        }

        function rupiah(n) {
            n = Number(n) || 0;
            return 'Rp ' + n.toLocaleString('id-ID');
        }

        function capitalize(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

        function $field(field) {
            var $el = $('#' + field);
            if ($el.length === 0) $el = $('[name="' + field + '"]');
            return $el;
        }

        function clearFormValidation() {
            ['kodePaket', 'namaPaket', 'kategoriId', 'satuanDasar'].forEach(function(field) {
                $field(field).removeClass('is-invalid');
                $('.error' + capitalize(field)).html('');
            });
        }

        function showValidationErrors(errors) {
            ['kodePaket', 'namaPaket', 'kategoriId', 'satuanDasar'].forEach(function(field) {
                if (errors[field]) {
                    $field(field).addClass('is-invalid');
                    $('.error' + capitalize(field)).html(errors[field]);
                } else {
                    $field(field).removeClass('is-invalid');
                    $('.error' + capitalize(field)).html('');
                }
            });
        }

        function setFormDisabled(disabled) {
            $('#data_form_paket input:not([type=hidden]), #data_form_paket textarea, #data_form_paket select').prop('disabled', disabled);
        }

        function highlightText(text, search) {
            if (!text || !search) return text;
            var regex = new RegExp('(' + search.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'gi');
            return text.replace(regex, '<span class="highlight-match">$1</span>');
        }

        function calcSummary() {
            var hpp = komponenList.reduce(function(sum, k) {
                return sum + (k.qty * (k.harga || 0));
            }, 0);
            var activeHarga = hargaList.filter(function(h) {
                return h.aktif;
            });
            var avgHargaJual = 0;
            if (activeHarga.length > 0) {
                avgHargaJual = activeHarga.reduce(function(s, h) {
                    return s + Number(h.hargaJual);
                }, 0) / activeHarga.length;
            }
            var margin = avgHargaJual > 0 ? ((avgHargaJual - hpp) / avgHargaJual) * 100 : 0;
            var untung = avgHargaJual - hpp;
            return {
                hpp: hpp,
                hargaJual: avgHargaJual,
                margin: margin,
                untung: untung
            };
        }

        function loadSatuanKomponenDropdown() {
            $.ajax({
                method: 'GET',
                url: "<?= site_url('tmstpaketbaru/getSatuanDropdown'); ?>",
                dataType: 'JSON',
                success: function(response) {
                    if (response.status === 'success') {
                        var opts = '<option value="">Pilih satuan</option>';
                        (response.data || []).forEach(function(item) {
                            opts += '<option value="' + item.id + '">' + item.text + '</option>';
                        });
                        $('#komponen_satuan').html(opts);
                    }
                }
            });
        }
        loadSatuanKomponenDropdown();

        function loadItemTypeDropdown() {
            $.ajax({
                method: 'GET',
                url: "<?= site_url('tmstpaketbaru/getItemTypeDropdown'); ?>",
                dataType: 'JSON',
                success: function(response) {
                    if (response.status === 'success') {
                        var opts = '<option value="">Semua</option>';
                        (response.data || []).forEach(function(item) {
                            opts += '<option value="' + item.id + '">' + item.text + '</option>';
                        });
                        $('#komponen_tipe_item').html(opts);
                        $('#modal_filter_tipe').html('<option value="">Semua Tipe</option>' + opts.replace('<option value="">Semua</option>', ''));
                    }
                }
            });
        }
        loadItemTypeDropdown();

        function loadKelasHargaDropdown() {
            $.ajax({
                method: 'GET',
                url: "<?= site_url('tmstpaketbaru/getKelasHargaDropdown'); ?>",
                dataType: 'JSON',
                success: function(response) {
                    if (response.status === 'success') {
                        var opts = '<option value="">Pilih kelas harga</option>';
                        (response.data || []).forEach(function(item) {
                            opts += '<option value="' + item.id + '">' + item.text + '</option>';
                        });
                        $('#harga_kelas, #mh_kelas_harga').html(opts);
                    }
                }
            });
        }
        loadKelasHargaDropdown();

        function loadKategoriFilterDropdown() {
            $.ajax({
                method: 'GET',
                url: "<?= site_url('tmstpaketbaru/getKategoriDropdown'); ?>",
                dataType: 'JSON',
                success: function(response) {
                    if (response.status === 'success') {
                        (response.data || []).forEach(function(item) {
                            $('#f_kategori').append('<option value="' + item.id + '">' + item.text + '</option>');
                        });
                    }
                }
            });
        }
        loadKategoriFilterDropdown();

        function goToStep(step) {
            currentStep = step;
            $('.wizard-pane').hide();
            $('#step_pane_' + step).show();

            $('.paket-stepper .step-item').removeClass('active done');
            $('.paket-stepper .step-item').each(function() {
                var s = parseInt($(this).data('step'));
                if (s < step) $(this).addClass('done');
                if (s === step) $(this).addClass('active');
            });

            $('#btn_wizard_prev').toggle(step > 1);

            if (step === totalSteps) {
                $('#btn_wizard_next').hide();
                if ($('#action_paket').val() !== 'View') {
                    $('#submit_button_paket').show();
                }
            } else {
                $('#btn_wizard_next').show();
                $('#submit_button_paket').hide();
            }

            updateRingkasanSidebar();
        }

        $('.paket-stepper .step-item').on('click', function() {
            var target = parseInt($(this).data('step'));
            if (target > 1 && !window.currentPaketCode) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Simpan Informasi Paket (Step 1) terlebih dahulu.'
                });
                return;
            }
            goToStep(target);
            if (target === 2) loadKomponenPaket();
            if (target === 3) loadHargaPaket();
        });

        $('#btn_wizard_next').on('click', function() {
            if (currentStep === 1) {
                if ($('#action_paket').val() === 'View') {
                    goToStep(2);
                    loadKomponenPaket();
                    loadHargaPaket();
                    return;
                }
                var ok = true;
                if (!$('#namaPaket').val().trim()) {
                    $('#namaPaket').addClass('is-invalid');
                    $('.errorNamaPaket').html('Nama Paket harus diisi');
                    ok = false;
                }
                if (!$field('kategoriId').val()) {
                    $field('kategoriId').addClass('is-invalid');
                    $('.errorKategoriId').html('Kategori harus dipilih');
                    ok = false;
                }
                if (!$field('satuanDasar').val()) {
                    $field('satuanDasar').addClass('is-invalid');
                    $('.errorSatuanDasar').html('Satuan Dasar harus diisi');
                    ok = false;
                }
                if (!ok) return;
                clearFormValidation();
                submitStep1PaketThenGoNext();
                return;
            }

            if (currentStep === 2) {
                if ($('#action_paket').val() === 'View') {
                    goToStep(3);
                    return;
                }
                saveKomponenPaketToServer(function() {
                    goToStep(3);
                });
                return;
            }

            if (currentStep < totalSteps) goToStep(currentStep + 1);
        });

        $('#btn_wizard_prev').on('click', function() {
            if (currentStep > 1) goToStep(currentStep - 1);
        });

        function submitStep1PaketThenGoNext() {
            if (isSubmittingStep1) return;
            isSubmittingStep1 = true;

            var payload = {
                action: window.isEditModePaket ? 'Edit' : 'Add',
                hidden_id: window.currentPaketCode || '',
                kodePaket: $('#kodePaket').val(),
                namaPaket: $('#namaPaket').val(),
                kategoriId: $field('kategoriId').val(),
                deskripsi: $('#deskripsi').val(),
                satuanDasar: $field('satuanDasar').val(),
                isActive: $('#isActive').val(),
            };
            var $btnNext = $('#btn_wizard_next');
            $btnNext.prop('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Menyimpan...');
            $.ajax({
                url: "<?= site_url('tmstpaketbaru/action') ?>",
                method: 'POST',
                data: payload,
                dataType: 'JSON',
                success: function(response) {
                    if (response.error) {
                        showValidationErrors(response.error);
                        return;
                    }
                    if (response.status === 'success') {
                        window.currentPaketCode = response.itemCode;
                        window.currentPaketUomId = response.baseUomId || '';
                        window.isEditModePaket = true;

                        $('#action_paket').val('Edit');
                        $('#hidden_id_paket').val(response.itemCode);
                        $('#kodePaket').prop('disabled', true);

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message || 'Data berhasil disimpan.'
                        });
                        goToStep(2);
                        loadKomponenPaket();
                        loadHargaPaket();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message || 'Gagal menyimpan.'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan koneksi ke server.'
                    });
                },
                complete: function() {
                    isSubmittingStep1 = false;
                    $btnNext.prop('disabled', false).html('Selanjutnya <i class="fas fa-arrow-right ml-1"></i>');
                }
            });
        }

        $('#data_form_paket').on('keydown', 'input, select', function(e) {
            if (e.key === 'Enter') {
                var excludedIds = ['komponen_cari_item'];
                if (excludedIds.indexOf(this.id) !== -1) {
                    return;
                }
                e.preventDefault();
                if (currentStep < totalSteps) $('#btn_wizard_next').trigger('click');
                return false;
            }
        });

        $('input[name="statusRadio"]').on('change', function() {
            $('#isActive').val($(this).val());
        });

        function renderKomponenTable() {
            var $tbody = $('#tableKomponenPaket tbody');
            var isView = window.isViewModePaket || false;
            $tbody.empty();
            if (komponenList.length === 0) {
                $tbody.html('<tr><td colspan="9" class="text-center text-muted">Belum ada komponen.</td></tr>');
            } else {
                komponenList.forEach(function(k, i) {
                    var subtotal = (k.qty || 0) * (k.harga || 0);
                    $tbody.append('<tr data-idx="' + i + '">' +
                        '<td>' + (i + 1) + '</td>' +
                        '<td>' + k.kode + '</td>' +
                        '<td>' + k.nama + '</td>' +
                        '<td>' + k.tipe + '</td>' +
                        '<td>' + k.satuan + '</td>' +
                        '<td><input type="number" min="1" class="qty-input komponen-qty" value="' + (k.qty || 1) + '" data-idx="' + i + '"' + (isView ? ' disabled' : '') + '></td>' +
                        '<td class="text-right">' + (k.harga || 0).toLocaleString('id-ID') + '</td>' +
                        '<td class="text-right">' + subtotal.toLocaleString('id-ID') + '</td>' +
                        '<td>' +
                        '<button type="button" class="btn-row-icon delete komponen-delete" data-idx="' + i + '" title="Hapus"' + (isView ? ' disabled style="opacity:0.5"' : '') + '><i class="fas fa-trash-alt"></i></button>' +
                        '</td>' +
                        '</tr>');
                });
            }
            $('#komponen_count').text(komponenList.length);
            var total = komponenList.reduce(function(s, k) {
                return s + ((k.qty || 0) * (k.harga || 0));
            }, 0);
            $('#komponen_total_text').text(rupiah(total));
            updateHargaCalcCards();
            updateRingkasanSidebar();
        }

        function loadKomponenPaket() {
            if (!window.currentPaketCode) return;
            $.ajax({
                url: "<?= site_url('tmstpaketbaru/packageComponents') ?>/" + window.currentPaketCode,
                method: 'GET',
                dataType: 'JSON',
                success: function(response) {
                    if (response.status === 'success') {
                        komponenList = response.data.map(function(d) {
                            return {
                                id: d.id || null,
                                kode: d.kode || '',
                                nama: d.nama || '',
                                tipe: d.tipe || '-',
                                satuan: d.satuan || '',
                                uomId: d.uomId || '',
                                qty: d.qty || 1,
                                harga: Number(d.harga) || 0,
                                isOptional: d.optional || false,
                                isChargedSeparately: d.terpisah || false,
                                isStockDeducted: d.potongStok !== undefined ? d.potongStok : true,
                                sortNo: d.sortNo || 0,
                                isActive: d.aktif !== undefined ? d.aktif : true
                            };
                        });
                        renderKomponenTable();
                    }
                },
                error: function() {
                    console.error('Gagal load komponen');
                }
            });
        }

        $(document).on('change', '.komponen-qty', function() {
            var idx = $(this).data('idx');
            var val = parseInt($(this).val()) || 1;
            if (komponenList[idx]) {
                komponenList[idx].qty = val;
                renderKomponenTable();
            }
        });

        function cariDanTambahKomponenDariInput() {
            var search = $('#komponen_cari_item').val().trim();
            if (!search) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Masukkan kode atau nama item.'
                });
                return;
            }
            if (!window.currentPaketCode) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Simpan Informasi Paket (Step 1) dulu.'
                });
                return;
            }
            $.ajax({
                url: "<?= site_url('tmstpaketbaru/searchItem') ?>",
                method: 'GET',
                data: {
                    q: search
                },
                dataType: 'JSON',
                success: function(response) {
                    if (response.status === 'success' && response.data.length > 0) {
                        if (response.data.length === 1) {
                            tambahItemKeKomponen(response.data[0]);
                            $('#komponen_cari_item').val('');
                            $('#komponen_search_results').hide();
                        } else {
                            showQuickSearchResults(search);
                        }
                    } else {
                        Swal.fire({
                            icon: 'info',
                            title: 'Tidak ditemukan',
                            text: 'Item "' + search + '" tidak ditemukan.'
                        });
                    }
                }
            });
        }

        $('#komponen_cari_item').on('keydown', function(e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                e.preventDefault();
                e.stopPropagation();
                cariDanTambahKomponenDariInput();
            }
        });

        $('#btn_tambah_komponen').on('click', function() {
            cariDanTambahKomponenDariInput();
        });

        function showQuickSearchResults(search) {
            if (search.length < 2) return;
            $.ajax({
                url: "<?= site_url('tmstpaketbaru/searchItem') ?>",
                method: 'GET',
                data: {
                    q: search
                },
                dataType: 'JSON',
                success: function(response) {
                    var $results = $('#komponen_search_results');
                    $results.empty().show();

                    if (response.status !== 'success' || response.data.length === 0) {
                        $results.append('<div class="list-group-item text-muted"><i class="fas fa-search-minus mr-2"></i> Tidak ada item ditemukan</div>');
                        return;
                    }

                    var items = response.data.slice(0, 5);
                    var total = response.data.length;

                    items.forEach(function(item) {
                        var badge = '';
                        if (item.tipe === 'PACKAGE') badge = '<span class="badge badge-warning ml-2">Paket</span>';
                        else if (item.tipe === 'SERVICE') badge = '<span class="badge badge-info ml-2">Service</span>';
                        else if (item.tipe === 'DRUG') badge = '<span class="badge badge-success ml-2">Obat</span>';
                        else badge = '<span class="badge badge-secondary ml-2">' + item.tipe + '</span>';

                        var isAdded = komponenList.some(function(k) {
                            return k.kode === item.kode;
                        });

                        $results.append(
                            '<a href="#" class="list-group-item list-group-item-action quick-select-item ' + (isAdded ? 'text-muted' : '') + '" ' +
                            'data-kode="' + item.kode + '" data-nama="' + item.nama + '" data-tipe="' + item.tipe + '" ' +
                            'data-uomid="' + item.uomId + '" data-satuan="' + item.satuan + '" ' +
                            (isAdded ? 'style="cursor:not-allowed; opacity:0.6;"' : '') + '>' +
                            '<div class="d-flex justify-content-between align-items-center">' +
                            '<div><strong>' + item.kode + '</strong> - ' + item.nama + ' ' + badge +
                            (isAdded ? ' <span class="badge badge-secondary">Sudah ditambahkan</span>' : '') +
                            '</div>' +
                            '<i class="fas fa-' + (isAdded ? 'check' : 'plus') + ' text-' + (isAdded ? 'secondary' : 'primary') + '"></i>' +
                            '</div></a>'
                        );
                    });

                    if (total > 5) {
                        $results.append(
                            '<div class="list-group-item text-center text-muted small">' +
                            '<i class="fas fa-ellipsis-h mr-1"></i> ' + (total - 5) + ' item lainnya. ' +
                            '<a href="#" id="btn_lihat_semua" class="text-primary">Lihat semua</a>' +
                            '</div>'
                        );
                    }
                }
            });
        }

        $(document).on('click', '.quick-select-item', function(e) {
            e.preventDefault();
            var kode = $(this).data('kode');
            if (!kode) return;

            var exists = komponenList.some(function(k) {
                return k.kode === kode;
            });
            if (exists) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Item sudah ada di daftar komponen.'
                });
                $('#komponen_search_results').hide();
                return;
            }

            tambahItemKeKomponen({
                kode: kode,
                nama: $(this).data('nama'),
                tipe: $(this).data('tipe'),
                uomId: $(this).data('uomid'),
                satuan: $(this).data('satuan')
            });
            $('#komponen_cari_item').val('');
            $('#komponen_search_results').hide();
        });

        $(document).on('click', '#btn_lihat_semua', function(e) {
            e.preventDefault();
            $('#komponen_search_results').hide();
            var search = $('#komponen_cari_item').val();
            if (search) {
                $('#modal_cari_item').val(search);
                $('#modalPilihItem').modal('show');
                setTimeout(function() {
                    searchItemModal();
                }, 300);
            }
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest('#komponen_cari_item, #komponen_search_results, #btn_cari_item_modal').length) {
                $('#komponen_search_results').hide();
            }
        });

        $('#btn_cari_item_modal').on('click', function() {
            var currentSearch = $('#komponen_cari_item').val();
            if (currentSearch) {
                $('#modal_cari_item').val(currentSearch);
                setTimeout(function() {
                    searchItemModal();
                }, 300);
            }
            $('#modalPilihItem').modal('show');
        });

        $('#btn_modal_cari').on('click', function() {
            searchItemModal();
        });
        $('#modal_cari_item').on('keyup', function(e) {
            if (e.keyCode === 13) {
                e.preventDefault();
                searchItemModal();
            }
        });

        $('#btn_modal_reset').on('click', function() {
            $('#modal_cari_item').val('');
            $('#modal_filter_tipe').val('');
            $('#modal_item_tbody').html(
                '<tr><td colspan="6" class="text-center text-muted py-3"><i class="fas fa-search mr-2"></i> Ketik kata kunci untuk mencari item</td></tr>'
            );
            $('#modal_item_info').text('Menampilkan 0 item');
            $('#modal_item_count').text('0');
        });

        function searchItemModal() {
            var search = $('#modal_cari_item').val().trim();
            var tipe = $('#modal_filter_tipe').val();

            if (search.length < 2 && !tipe) {
                Swal.fire({
                    icon: 'info',
                    title: 'Info',
                    text: 'Masukkan minimal 2 karakter untuk mencari, atau pilih filter tipe.'
                });
                return;
            }

            $('#modal_item_tbody').html(
                '<tr><td colspan="6" class="text-center py-4"><i class="fas fa-spinner fa-spin fa-2x text-primary"></i><p class="mt-2 text-muted">Mencari data...</p></td></tr>'
            );
            $('#modal_item_info').text('Sedang mencari...');
            $('#modal_item_count').text('...');

            $.ajax({
                url: "<?= site_url('tmstpaketbaru/searchItem') ?>",
                method: 'GET',
                data: {
                    q: search,
                    tipe: tipe
                },
                dataType: 'JSON',
                success: function(response) {
                    if (response.status === 'success') {
                        modalItemList = response.data || [];
                        renderModalItemList(modalItemList, search);
                    } else {
                        $('#modal_item_tbody').html(
                            '<tr><td colspan="6" class="text-center text-muted py-3"><i class="fas fa-exclamation-circle mr-2"></i> Gagal memuat data</td></tr>'
                        );
                        $('#modal_item_info').text('Gagal memuat data');
                        $('#modal_item_count').text('0');
                    }
                },
                error: function() {
                    $('#modal_item_tbody').html(
                        '<tr><td colspan="6" class="text-center text-danger py-3"><i class="fas fa-exclamation-triangle mr-2"></i> Terjadi kesalahan koneksi</td></tr>'
                    );
                    $('#modal_item_info').text('Error');
                    $('#modal_item_count').text('0');
                }
            });
        }

        function renderModalItemList(items, searchTerm) {
            var $tbody = $('#modal_item_tbody');
            $tbody.empty();

            if (items.length === 0) {
                $tbody.html(
                    '<tr><td colspan="6" class="text-center text-muted py-3"><i class="fas fa-search-minus mr-2"></i> Tidak ada item ditemukan</td></tr>'
                );
                $('#modal_item_info').text('Tidak ada item ditemukan');
                $('#modal_item_count').text('0');
                return;
            }

            var searchLower = (searchTerm || '').toLowerCase();

            items.forEach(function(item, index) {
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

                var badgeTipe = '';
                if (tipe === 'PACKAGE') badgeTipe = '<span class="badge badge-warning">Paket</span>';
                else if (tipe === 'SERVICE') badgeTipe = '<span class="badge badge-info">Service</span>';
                else if (tipe === 'DRUG') badgeTipe = '<span class="badge badge-success">Obat</span>';
                else badgeTipe = '<span class="badge badge-secondary">' + tipe + '</span>';

                var isAlreadyAdded = komponenList.some(function(k) {
                    return k.kode === kode;
                });
                var btnDisabled = isAlreadyAdded ? 'disabled' : '';
                var btnText = isAlreadyAdded ? 'Sudah Ada' : 'Pilih';
                var btnClass = isAlreadyAdded ? 'btn-secondary' : 'btn-pilih-item';

                $tbody.append(
                    '<tr data-kode="' + kode + '" data-nama="' + nama + '" data-tipe="' + tipe + '" data-uomid="' + uomId + '" data-satuan="' + satuan + '" class="' + (isAlreadyAdded ? 'table-secondary' : '') + '">' +
                    '<td class="text-center">' + (index + 1) + '</td>' +
                    '<td><strong>' + displayKode + '</strong></td>' +
                    '<td>' + displayNama + '</td>' +
                    '<td>' + badgeTipe + '</td>' +
                    '<td>' + satuan + '</td>' +
                    '<td class="text-center"><button type="button" class="' + btnClass + '" data-kode="' + kode + '" ' + btnDisabled + '><i class="fas fa-' + (isAlreadyAdded ? 'check' : 'plus') + ' mr-1"></i> ' + btnText + '</button></td>' +
                    '</tr>'
                );
            });

            $('#modal_item_info').text('Menampilkan ' + items.length + ' item');
            $('#modal_item_count').text(items.length);
        }

        $(document).on('click', '.btn-pilih-item', function() {
            var kode = $(this).data('kode');
            if (kode) pilihItemDariModal(kode);
        });

        function pilihItemDariModal(kode) {
            var item = modalItemList.find(function(i) {
                return i.kode === kode;
            });
            if (!item) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Item tidak ditemukan.'
                });
                return;
            }

            var exists = komponenList.some(function(k) {
                return k.kode === item.kode;
            });
            if (exists) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Item "' + item.nama + '" sudah ada.'
                });
                return;
            }

            $('#modalPilihItem').modal('hide');
            tambahItemKeKomponen(item);
            $('#komponen_cari_item').val('');
        }

        function tambahItemKeKomponen(item) {
            if (!window.currentPaketCode) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Simpan Informasi Paket (Step 1) dulu.'
                });
                return;
            }

            var exists = komponenList.some(function(k) {
                return k.kode === item.kode;
            });
            if (exists) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Item "' + item.nama + '" sudah ada.'
                });
                return;
            }

            var newKomponen = {
                id: null,
                kode: item.kode,
                nama: item.nama,
                tipe: item.tipe || '-',
                satuan: item.satuan || '',
                uomId: item.uomId || '',
                qty: 1,
                harga: 0,
                isOptional: false,
                isChargedSeparately: false,
                isStockDeducted: true,
                sortNo: komponenList.length,
                isActive: true
            };

            komponenList.push(newKomponen);
            renderKomponenTable();

            cariHargaKomponen(item.kode, item.uomId, function(harga) {
                var idx = komponenList.findIndex(function(k) {
                    return k.kode === item.kode;
                });
                if (idx !== -1) {
                    komponenList[idx].harga = harga || 0;
                    renderKomponenTable();
                }
            });

            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Item "' + item.nama + '" berhasil ditambahkan.',
                timer: 1200,
                showConfirmButton: false
            });
        }

        function cariHargaKomponen(itemCode, uomId, callback) {
            if (!itemCode || !window.currentPaketCode) {
                if (callback) callback(0);
                return;
            }
            $.ajax({
                url: "<?= site_url('tmstpaketbaru/harga') ?>/" + itemCode,
                method: 'GET',
                dataType: 'JSON',
                success: function(response) {
                    if (response.status === 'success' && response.data && response.data.length > 0) {
                        var activePrices = response.data.filter(function(p) {
                            return p.aktif === true;
                        });
                        if (activePrices.length > 0) {
                            var found = activePrices.find(function(p) {
                                return p.uomId === uomId;
                            });
                            var harga = found ? found.hargaJual : activePrices[0].hargaJual;
                            if (callback) callback(harga);
                            return;
                        }
                    }
                    if (callback) callback(0);
                },
                error: function() {
                    if (callback) callback(0);
                }
            });
        }

        $(document).on('click', '.komponen-delete', function() {
            var idx = $(this).data('idx');
            var item = komponenList[idx];
            if (!item) return;

            Swal.fire({
                title: 'Hapus Komponen?',
                text: 'Yakin akan menghapus ' + item.nama + '?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#dc3545'
            }).then(function(result) {
                if (!result.isConfirmed) return;
                komponenList.splice(idx, 1);
                renderKomponenTable();
            });
        });

        $('#btn_hapus_semua_komponen').on('click', function() {
            if (komponenList.length === 0) return;
            Swal.fire({
                title: 'Hapus semua komponen?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then(function(r) {
                if (r.isConfirmed) {
                    komponenList = [];
                    renderKomponenTable();
                }
            });
        });

        function saveKomponenPaketToServer(onSuccess, onError) {
            if (!window.currentPaketCode) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Simpan Informasi Paket (Step 1) dulu.'
                });
                if (onError) onError();
                return;
            }
            if (komponenList.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Minimal 1 komponen harus ditambahkan.'
                });
                if (onError) onError();
                return;
            }

            var components = komponenList.map(function(k) {
                return {
                    componentItemCode: k.kode,
                    uomId: k.uomId || '',
                    qty: k.qty || 1,
                    isOptional: k.isOptional ? '1' : '0',
                    isChargedSeparately: k.isChargedSeparately ? '1' : '0',
                    isStockDeducted: k.isStockDeducted !== undefined ? (k.isStockDeducted ? '1' : '0') : '1',
                    sortNo: k.sortNo || 0,
                    isActive: k.isActive !== undefined ? (k.isActive ? '1' : '0') : '1',
                    createdBy: '<?= session()->get('fullname') ?? 'SYSTEM' ?>'
                };
            });

            Swal.fire({
                title: 'Menyimpan...',
                text: 'Mohon tunggu',
                allowOutsideClick: false,
                didOpen: function() {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: "<?= site_url('tmstpaketbaru/saveAllPackageComponents') ?>/" + window.currentPaketCode,
                method: 'POST',
                data: {
                    components: components
                },
                dataType: 'JSON',
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message || 'Komponen berhasil disimpan.',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        loadKomponenPaket();
                        updateRingkasanSidebar();
                        if (onSuccess) onSuccess();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message || 'Gagal menyimpan komponen.'
                        });
                        if (onError) onError();
                    }
                },
                error: function(xhr) {
                    var message = 'Terjadi kesalahan';
                    if (xhr.responseJSON && xhr.responseJSON.message) message = xhr.responseJSON.message;
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: message
                    });
                    if (onError) onError();
                }
            });
        }

        function renderHargaTable() {
            var $tbody = $('#tableHargaPaket tbody');
            var isView = window.isViewModePaket || false;
            $tbody.empty();
            if (hargaList.length === 0) {
                $tbody.html('<tr><td colspan="8" class="text-center text-muted">Belum ada harga paket.</td></tr>');
            } else {
                hargaList.forEach(function(h, i) {
                    $tbody.append('<tr data-idx="' + i + '">' +
                        '<td>' + (i + 1) + '</td>' +
                        '<td>' + h.kelas + '</td>' +
                        '<td>' + h.mataUang + '</td>' +
                        '<td><input type="number" min="0" class="harga-jual-input harga-edit" value="' + h.hargaJual + '" data-idx="' + i + '"' + (isView ? ' disabled' : '') + '></td>' +
                        '<td>' + formatDateShort(h.berlakuMulai) + '</td>' +
                        '<td>' + (h.berlakuSampai ? formatDateShort(h.berlakuSampai) : '-') + '</td>' +
                        '<td><label class="pkt-switch"><input type="checkbox" class="harga-toggle-aktif" data-idx="' + i + '" ' + (h.aktif ? 'checked' : '') + (isView ? ' disabled' : '') + '><span class="slider"></span></label></td>' +
                        '<td>' +
                        '<button type="button" class="btn-row-icon edit harga-edit-btn" data-idx="' + i + '" title="Edit"' + (isView ? ' disabled style="opacity:0.5"' : '') + '><i class="fas fa-pencil-alt"></i></button>' +
                        '<button type="button" class="btn-row-icon delete harga-delete" data-idx="' + i + '" title="Hapus"' + (isView ? ' disabled style="opacity:0.5"' : '') + '><i class="fas fa-trash-alt"></i></button>' +
                        '</td>' +
                        '</tr>');
                });
            }
            $('#harga_count').text(hargaList.length);
            updateHargaCalcCards();
            updateRingkasanSidebar();
        }

        function loadHargaPaket() {
            if (!window.currentPaketCode) return;
            $.ajax({
                url: "<?= site_url('tmstpaketbaru/harga') ?>/" + window.currentPaketCode,
                method: 'GET',
                dataType: 'JSON',
                success: function(response) {
                    if (response.status === 'success') {
                        hargaList = response.data.map(function(d) {
                            return {
                                id: d.id || null,
                                kelasId: d.kelasId || '',
                                kelas: d.kelas || '',
                                mataUang: d.mataUang || 'IDR',
                                hargaJual: d.hargaJual || 0,
                                berlakuMulai: d.berlakuMulai ? d.berlakuMulai.split('T')[0] : '',
                                berlakuSampai: d.berlakuSampai ? d.berlakuSampai.split('T')[0] : '',
                                aktif: d.aktif !== undefined ? d.aktif : true,
                                keterangan: d.keterangan || ''
                            };
                        });
                        renderHargaTable();
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal memuat harga paket.'
                    });
                }
            });
        }

        function updateHargaCalcCards() {
            var calc = calcSummary();
            $('#calc_total_komponen').text(komponenList.length + ' Item');
            $('#calc_hpp').text(rupiah(calc.hpp));
            $('#calc_harga_jual').text(rupiah(calc.hargaJual));
            $('#calc_margin').text((isFinite(calc.margin) ? calc.margin.toFixed(2) : 0) + ' %');
            $('#calc_untung').text(rupiah(calc.untung));
        }

        function updateRingkasanSidebar() {
            var calc = calcSummary();
            var nama = $('#namaPaket').val().trim();
            var kode = $('#kodePaket').val().trim() || 'PKT-00000';

            if (komponenList.length === 0 && hargaList.length === 0 && !nama) {
                $('#ringkasan_step1_box').show();
                $('#ringkasan_filled_box').hide();
            } else {
                $('#ringkasan_step1_box').hide();
                $('#ringkasan_filled_box').show();
                $('#ringkasan_kode').text(kode);
                $('#ringkasan_nama').text(nama || 'Nama Paket');
            }

            $('#rk_jumlah_komponen').text(komponenList.length + ' Item');
            $('#rk_hpp').text(rupiah(calc.hpp));
            $('#rk_harga_jual_label').text(hargaList.length > 1 ? ' (Rata-rata)' : '');
            $('#rk_harga_jual').text(rupiah(calc.hargaJual));
            $('#rk_margin').text((isFinite(calc.margin) ? calc.margin.toFixed(2) : 0) + ' %');
            $('#rk_untung').text(rupiah(calc.untung));

            if (hargaList.length > 0) {
                $('#rk_price_box').show();
                var html = '';
                hargaList.forEach(function(h) {
                    html += '<div class="row-item"><span>' + h.kelas + '</span><span>' + rupiah(h.hargaJual) + '</span></div>';
                });
                $('#rk_price_list').html(html);
            } else {
                $('#rk_price_box').hide();
            }

            var tips = {
                1: ['Tambahkan komponen paket pada langkah 2.', 'Harga paket dapat ditentukan pada langkah 3.', 'Pastikan semua informasi sudah benar sebelum menyimpan.'],
                2: ['Gunakan tombol edit untuk mengubah qty.', 'Hapus komponen yang tidak diperlukan.', 'Klik "Simpan Semua Komponen" untuk menyimpan.'],
                3: ['Anda dapat menambahkan lebih dari satu harga.', 'Pastikan harga sudah sesuai.', 'Klik "Simpan Semua Harga" untuk menyimpan.']
            };
            var tipHtml = '';
            (tips[currentStep] || []).forEach(function(t) {
                tipHtml += '<li>' + t + '</li>';
            });
            $('#rk_tips_list').html(tipHtml);
        }

        $(document).on('change', '.harga-jual-input', function() {
            var idx = $(this).data('idx');
            var item = hargaList[idx];
            if (!item || !item.id || !window.currentPaketCode) return;

            var newHarga = parseFloat($(this).val()) || 0;
            $.ajax({
                url: "<?= site_url('tmstpaketbaru/saveHarga') ?>/" + window.currentPaketCode,
                method: 'POST',
                data: {
                    price_id: item.id,
                    priceClassId: item.kelasId,
                    uomId: window.currentPaketUomId || '',
                    hargaJual: newHarga,
                    berlakuMulai: item.berlakuMulai,
                    berlakuSampai: item.berlakuSampai,
                    isActive: item.aktif ? '1' : '0'
                },
                dataType: 'JSON',
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Harga diperbarui.',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        loadHargaPaket();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message
                        });
                        loadHargaPaket();
                    }
                }
            });
        });

        $(document).on('change', '.harga-toggle-aktif', function() {
            var idx = $(this).data('idx');
            var item = hargaList[idx];
            if (!item || !item.id || !window.currentPaketCode) return;

            $.ajax({
                url: "<?= site_url('tmstpaketbaru/saveHarga') ?>/" + window.currentPaketCode,
                method: 'POST',
                data: {
                    price_id: item.id,
                    priceClassId: item.kelasId,
                    uomId: window.currentPaketUomId || '',
                    hargaJual: item.hargaJual,
                    berlakuMulai: item.berlakuMulai,
                    berlakuSampai: item.berlakuSampai,
                    isActive: $(this).is(':checked') ? '1' : '0'
                },
                dataType: 'JSON',
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Status harga diperbarui.',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        loadHargaPaket();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message
                        });
                        loadHargaPaket();
                    }
                }
            });
        });

        $(document).on('click', '.harga-delete', function() {
            var idx = $(this).data('idx');
            var item = hargaList[idx];
            if (!item || !item.id || !window.currentPaketCode) return;

            Swal.fire({
                title: 'Hapus Harga?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then(function(r) {
                if (!r.isConfirmed) return;
                $.ajax({
                    url: "<?= site_url('tmstpaketbaru/deleteHarga') ?>/" + window.currentPaketCode + "/" + item.id,
                    method: 'DELETE',
                    dataType: 'JSON',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message || 'Harga dihapus.',
                                timer: 2000
                            });
                            loadHargaPaket();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        var message = 'Gagal menghubungi server.';
                        if (xhr.responseJSON && xhr.responseJSON.message) message = xhr.responseJSON.message;
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: message
                        });
                    }
                });
            });
        });

        $(document).on('click', '.harga-edit-btn', function() {
            var idx = $(this).data('idx');
            var h = hargaList[idx];
            $('#mh_edit_index').val(idx);
            $('#mh_kelas_harga').prop('disabled', false).val(h.kelasId);
            $('#mh_mata_uang').val(h.mataUang);
            $('#mh_harga_jual').val(h.hargaJual);
            $('#mh_berlaku_mulai').val(h.berlakuMulai);
            $('#mh_berlaku_sampai').val(h.berlakuSampai);
            $('#mh_status').val(h.aktif ? '1' : '0');
            $('#mh_keterangan').val(h.keterangan || '');
            openModalHarga();
        });

        $('#btn_tambah_harga').on('click', function() {
            $('#mh_edit_index').val('');
            var kelasTerpilih = $('#harga_kelas').val() || '';
            $('#mh_kelas_harga').val(kelasTerpilih);
            $('#mh_kelas_harga').prop('disabled', !!kelasTerpilih);
            $('#mh_mata_uang').val($('#harga_mata_uang').val() || 'IDR');
            $('#mh_harga_jual').val('');
            $('#mh_berlaku_mulai').val(new Date().toISOString().slice(0, 10));
            $('#mh_berlaku_sampai').val('');
            $('#mh_status').val('1');
            $('#mh_keterangan').val('');
            openModalHarga();
        });

        function openModalHarga() {
            $('#mh_ringkasan_kode').text($('#kodePaket').val().trim() || 'PKT-00000');
            $('#mh_ringkasan_nama').text($('#namaPaket').val().trim() || 'Nama Paket');
            updateModalHargaCalc();
            $('#modalhargapaket').modal('show');
        }

        function updateModalHargaCalc() {
            var calc = calcSummary();
            var hargaInput = parseFloat($('#mh_harga_jual').val()) || 0;
            var margin = hargaInput > 0 ? ((hargaInput - calc.hpp) / hargaInput) * 100 : 0;
            var untung = hargaInput - calc.hpp;

            $('#mh_calc_total_komponen').text(komponenList.length + ' Item');
            $('#mh_calc_hpp').text(rupiah(calc.hpp));
            $('#mh_calc_harga_jual').text(rupiah(hargaInput));
            $('#mh_calc_margin').text((isFinite(margin) ? margin.toFixed(2) : 0) + ' %');
            $('#mh_calc_untung').text(rupiah(untung));

            $('#mh_rk_jumlah').text(komponenList.length + ' Item');
            $('#mh_rk_hpp').text(rupiah(calc.hpp));
            $('#mh_rk_harga').text(rupiah(calc.hargaJual));
            $('#mh_rk_margin').text((isFinite(calc.margin) ? calc.margin.toFixed(2) : 0) + ' %');
            $('#mh_rk_untung').text(rupiah(calc.untung));
        }

        $(document).on('input change', '#mh_harga_jual', updateModalHargaCalc);
        $('#mh_tanpa_batas').on('change', function() {
            $('#mh_berlaku_sampai').prop('disabled', $(this).is(':checked')).val('');
        });

        $('#btn_simpan_harga').on('click', function() {
            if (!window.currentPaketCode) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Simpan Informasi Paket (Step 1) dulu.'
                });
                return;
            }

            var kelas = $('#mh_kelas_harga').val();
            var harga = parseFloat($('#mh_harga_jual').val());
            var mulai = $('#mh_berlaku_mulai').val();

            if (!kelas || !harga || !mulai) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Kelas Harga, Harga Jual, dan Berlaku Mulai wajib diisi.'
                });
                return;
            }

            var editIdx = $('#mh_edit_index').val();
            var priceId = (editIdx !== '' && hargaList[parseInt(editIdx)]) ? hargaList[parseInt(editIdx)].id : '';

            var $btn = $(this);
            var originalHtml = $btn.html();
            $btn.prop('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Menyimpan...');

            $.ajax({
                url: "<?= site_url('tmstpaketbaru/saveHarga') ?>/" + window.currentPaketCode,
                method: 'POST',
                data: {
                    price_id: priceId || '',
                    priceClassId: kelas,
                    uomId: window.currentPaketUomId || '',
                    hargaJual: harga,
                    berlakuMulai: mulai,
                    berlakuSampai: $('#mh_tanpa_batas').is(':checked') ? '' : $('#mh_berlaku_sampai').val(),
                    isActive: $('#mh_status').val()
                },
                dataType: 'JSON',
                success: function(response) {
                    $btn.prop('disabled', false).html(originalHtml);
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message || 'Harga berhasil disimpan.'
                        });
                        loadHargaPaket();
                        $('#modalhargapaket').modal('hide');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message || 'Gagal menyimpan harga.'
                        });
                    }
                },
                error: function() {
                    $btn.prop('disabled', false).html(originalHtml);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan koneksi.'
                    });
                }
            });
        });

        function resetForm() {
            window.currentPaketCode = null;
            window.isEditModePaket = false;
            window.isViewModePaket = false;
            window.currentPaketUomId = null;

            $('#data_form_paket')[0].reset();
            clearFormValidation();
            $('#auditFieldsPaket').hide();
            $('#statusAktif').prop('checked', true);
            $('#isActive').val('1');
            $('#tipeStandar').prop('checked', true);
            $field('kategoriId').val('').trigger('change.select2');
            $field('satuanDasar').val('').trigger('change.select2');
            setFormDisabled(false);
            $('#kodePaket').prop('disabled', true);
            window.isViewModePaket = false;
            $('#btn_tambah_komponen, #btn_hapus_semua_komponen, #btn_tambah_harga, #btn_simpan_semua_harga')
                .prop('disabled', false).css('opacity', 1);
            $('#komponen_cari_item, #komponen_tipe_item, #komponen_satuan').prop('disabled', false);
            komponenList = [];
            hargaList = [];
            renderKomponenTable();
            renderHargaTable();
            goToStep(1);
        }

        function fetchAndOpen(paketId, mode) {
            $.ajax({
                url: "<?= site_url('tmstpaketbaru/fetchSingleData') ?>",
                method: 'GET',
                data: {
                    paketId: paketId
                },
                dataType: 'JSON',
                success: function(response) {
                    if (!checkSession(response)) return;
                    if (response.status === 'error' || !response.data) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message || 'Data tidak ditemukan'
                        });
                        return;
                    }
                    const d = response.data;
                    const isView = (mode === 'View');
                    resetForm();
                    window.isViewModePaket = isView;

                    $('#kodePaket').val(d.kodePaket);
                    $('#namaPaket').val(d.namaPaket);
                    $field('kategoriId').val(d.kategoriId).trigger('change.select2');
                    $field('satuanDasar').val(d.satuanDasar).trigger('change.select2');
                    $('#deskripsi').val(d.deskripsi);
                    $('#berlakuUntuk').val(d.berlakuUntuk || 'semua_outlet');
                    $('#berlakuMulai').val(d.berlakuMulai || '');
                    $('#berlakuSampai').val(d.berlakuSampai || '');
                    $('#catatanInternal').val(d.catatanInternal || '');
                    $('#isActive').val(d.isActive ? '1' : '0');
                    $(d.isActive ? '#statusAktif' : '#statusNonAktif').prop('checked', true);
                    if (d.tipePaket === 'custom') $('#tipeCustom').prop('checked', true);
                    else $('#tipeStandar').prop('checked', true);

                    if (isView) {
                        setFormDisabled(true);
                        $('#btn_tambah_komponen, #btn_hapus_semua_komponen, #btn_tambah_harga, #btn_simpan_semua_harga')
                            .prop('disabled', true).css('opacity', 0.5);
                        $('#komponen_cari_item, #komponen_tipe_item, #komponen_satuan').prop('disabled', true);
                        $('#auditFieldsPaket').show();
                        $('#createdBy').val(d.createdBy || 'N/A');
                        $('#createdDate').val(d.createdDate ? formatDate(d.createdDate) : '-');
                        $('#updatedBy').val(d.updatedBy || '-');
                        $('#updatedDate').val(d.updatedDate ? formatDate(d.updatedDate) : '-');
                    }

                    $('#kodePaket').prop('disabled', true);
                    $('#modalformpaket .modal-title').text(isView ? 'Lihat Data Paket' : 'Ubah Data Paket');
                    $('#action_paket').val(mode);
                    $('#hidden_id_paket').val(d.paketId);
                    window.currentPaketCode = d.paketId;
                    window.currentPaketUomId = d.baseUomId || '';
                    window.isEditModePaket = true;
                    updateRingkasanSidebar();
                    goToStep(1);
                    $('#modalformpaket').modal('show');

                    if (mode === 'Edit') {
                        setTimeout(function() {
                            loadKomponenPaket();
                            loadHargaPaket();
                        }, 300);
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan: ' + error
                    });
                }
            });
        }

        $(document).on('click', '.view, .paket-link', function() {
            fetchAndOpen($(this).data('id'), 'View');
        });
        $(document).on('click', '.edit', function() {
            fetchAndOpen($(this).data('id'), 'Edit');
        });

        function doDelete(paketId) {
            Swal.fire({
                title: 'Yakin ingin menghapus data?',
                text: 'Data paket akan dihapus.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then(function(result) {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= site_url('tmstpaketbaru/delete') ?>",
                        method: 'POST',
                        data: {
                            paketId: paketId
                        },
                        dataType: 'JSON',
                        success: function(response) {
                            if (!checkSession(response)) return;
                            if (response.status === 'error') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.message || 'Gagal menghapus data.'
                                });
                            } else {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message || 'Data berhasil dihapus.'
                                });
                                $('#paketTable').DataTable().ajax.reload(null, false);
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Gagal menghubungi server.'
                            });
                        }
                    });
                }
            });
        }

        $(document).on('click', '.btn-icon-pkt.delete', function() {
            doDelete($(this).data('id'));
        });

        var paketTable = $('#paketTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            dom: 'Bfrt<"paket-table-footer"lip>',
            ajax: {
                url: "<?= base_url('tmstpaketbaru/datatables') ?>",
                type: 'POST',
                contentType: 'application/json',
                data: function(d) {
                    d.cari_paket = $('#f_cari_paket').val();
                    d.kategori = $('#f_kategori').val();
                    d.status = $('#f_status').val();
                    return JSON.stringify(d);
                }
            },
            columnDefs: [{
                    orderable: false,
                    targets: [0, 7]
                },
                {
                    targets: [0],
                    className: 'text-center'
                }
            ],
            columns: [{
                    data: 'rownum',
                    defaultContent: ''
                },
                {
                    data: 'kodePaketLink',
                    defaultContent: '-'
                },
                {
                    data: 'namaPaket',
                    defaultContent: '-'
                },
                {
                    data: 'kategori',
                    defaultContent: '-'
                },
                {
                    data: 'hargaJualFormat',
                    defaultContent: '-'
                },
                {
                    data: 'statusBadge',
                    defaultContent: '-'
                },
                {
                    data: 'updatedInfo',
                    defaultContent: '-'
                },
                {
                    data: 'aksi',
                    orderable: false,
                    defaultContent: '',
                    render: function(data, type, row) {
                        var canView = <?= session()->get('flag_view') === 1 ? 'true' : 'false' ?>;
                        var canEdit = <?= session()->get('flag_update') === 1 ? 'true' : 'false' ?>;
                        var canDelete = <?= session()->get('flag_delete') === 1 ? 'true' : 'false' ?>;
                        var html = '<div class="aksi-cell">';
                        if (canView) html += '<button type="button" class="btn-icon-pkt view" data-id="' + row.paketId + '" title="Lihat"><i class="fas fa-eye"></i></button>';
                        if (canEdit) html += '<button type="button" class="btn-icon-pkt edit" data-id="' + row.paketId + '" title="Edit"><i class="fas fa-pencil-alt"></i></button>';
                        if (canDelete) html += '<button type="button" class="btn-icon-pkt delete text-danger-item" data-id="' + row.paketId + '" title="Hapus"><i class="fas fa-trash"></i></button>';
                        html += '</div>';
                        return html;
                    }
                }
            ],
            buttons: [{
                    text: '<i class="fas fa-plus mr-1"></i> Tambah Paket',
                    action: function() {},
                    className: 'btn-pkt-primary',
                    attr: {
                        id: 'add_record_paket',
                        style: '<?= session()->get('flag_insert') === 1 ? '' : 'display:none;' ?>',
                        name: 'add_record_paket'
                    }
                },
                {
                    extend: 'excel',
                    text: '<i class="fas fa-download mr-1"></i> Export',
                    className: '<?= session()->get('flag_export') === 1 ? '' : 'd-none' ?>',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print mr-1"></i> Cetak',
                    className: '<?= session()->get('flag_print') === 1 ? '' : 'd-none' ?>',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    text: '<i class="fas fa-file-import mr-1"></i> Import',
                    action: function() {},
                    attr: {
                        id: 'import_paket',
                        style: '<?= session()->get('flag_insert') === 1 ? '' : 'display:none;' ?>',
                        name: 'import_paket'
                    }
                }
            ],
            oLanguage: {
                sSearch: 'Cari Data:',
                sInfoEmpty: 'Tidak ada data',
                sInfo: 'Menampilkan _START_ - _END_ dari _TOTAL_ data',
                sInfoFiltered: '',
                sZeroRecords: 'Data tidak ditemukan',
                sLengthMenu: 'Rows per page: _MENU_',
                oPaginate: {
                    sFirst: '&laquo;',
                    sPrevious: '&lsaquo;',
                    sNext: '&rsaquo;',
                    sLast: '&raquo;'
                }
            },
            drawCallback: function(settings) {
                var total = settings.fnRecordsTotal();
                $('#paket_total_label').text('Total ' + total + ' Data');
            }
        }).buttons().container().appendTo('#paketTable_wrapper .paket-table-toolbar');

        $('#f_cari_paket, #f_kategori, #f_status').on('keyup change', function() {
            $('#paketTable').DataTable().ajax.reload();
        });

        $('#btn_reset_filter_paket').on('click', function() {
            $('#f_cari_paket').val('');
            $('#f_kategori').val('');
            $('#f_status').val('');
            $('#paketTable').DataTable().ajax.reload();
        });

        $(document).on('click', '#add_record_paket', function() {
            resetForm();
            $('#modalformpaket .modal-title').text('Tambah Data Paket');
            $('#action_paket').val('Add');
            $('#hidden_id_paket').val('');
            $('#submit_button_paket').hide();
            $('#modalformpaket').modal('show');
        });

        $('#data_form_paket').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('tmstpaketbaru/action') ?>",
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'JSON',
                beforeSend: function() {
                    $('#submit_button_paket').prop('disabled', true).html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('#submit_button_paket').prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Simpan');
                },
                success: function(response) {
                    if (!checkSession(response)) return;
                    if (response.error) {
                        showValidationErrors(response.error);
                        goToStep(1);
                    } else if (response.status === 'error') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message || 'Terjadi kesalahan.'
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message || 'Data berhasil disimpan.'
                        });
                        clearFormValidation();
                        $('#modalformpaket').modal('hide');
                        $('#paketTable').DataTable().ajax.reload(null, false);
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'Gagal menghubungi server.'
                    });
                }
            });
        });

        $(document).on('click', '#import_paket', function() {
            $('#modalimportpaket .modal-title').text('Import Data Paket');
            $('#filenamePaket').val(null);
            $('#viewpreviewpaket').html('');
            $('#modalimportpaket').modal('show');
        });

        $('#uploadFormPaket').submit(function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            $.ajax({
                url: "<?= site_url('tmstpaketbaru/preview') ?>",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#previewPaket').prop('disabled', true).html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('#previewPaket').prop('disabled', false).html('Preview');
                },
                success: function() {
                    $.ajax({
                        method: 'GET',
                        url: "<?= site_url('tmstpaketbaru/preview') ?>",
                        success: function(data) {
                            $('#viewpreviewpaket').html(data);
                        }
                    });
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                }
            });
        });

        $('#namaPaket').on('input change', updateRingkasanSidebar);
        $(document).on('change', '[name="kategoriId"]', updateRingkasanSidebar);

        $('#paketTable').on('xhr.dt', function(e, settings, json) {
            if (json && json.status === 'session_expired') {
                window.location.href = "<?= base_url('auth/login') ?>";
            }
        });

        $(document).on('shown.bs.modal', '#modalformpaket', function() {
            if (window.isViewModePaket) {
                $('#auditFieldsPaket').show();
            }
        });

    });
</script>

<?= $this->endSection('script'); ?>