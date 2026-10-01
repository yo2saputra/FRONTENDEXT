<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>

<!-- Toastr -->
<link rel="stylesheet" href="<?= base_url('plugins/toastr/toastr.min.css') ?>">
<!-- Button datatable -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
    /* ngatur lebar tombol aksi biar rapi */
    .btn-fix-w {
        width: 60px;
        padding-top: 0px;
        padding-bottom: 0px;
    }

    /* ngatur ukuran font dropdown select2 */
    select.form-control-sm~.select2-container--default {
        font-size: .720rem !important;
    }

    /* ngatur ukuran font input form */
    .form-control-sm {
        font-size: .720rem !important;
    }

    #gljournallistTable tbody:empty {
        display: none;
    }

    #gljournallistTable tbody .dataTables_empty {
        padding: 0 !important;
        border: none !important;
        height: 0 !important;
        font-size: 0 !important;
    }

    /* style buat checkbox di tabel */
    .checkbox-header {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .checkbox-row {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    /* style buat tombol yang disabled */
    .btn:disabled {
        cursor: not-allowed;
        opacity: 0.6;
    }

    .btn-success:disabled {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    /* style buat line number */
    .input-group .btn-outline-secondary {
        border-color: #ced4da;
    }

    .input-group .btn-outline-secondary:hover {
        background-color: #e9ecef;
        border-color: #ced4da;
    }

    #LineNumber {
        background-color: #f8f9fa;
        font-weight: bold;
    }

    /* style tombol panah buat navigasi batch entry */
    #btnPrevBatchEntry,
    #btnNextBatchEntry {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        transition: all 0.2s ease;
    }

    /* efek pas kursor di atas tombol */
    #btnPrevBatchEntry:hover,
    #btnNextBatchEntry:hover {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
    }

    /* efek icon pas hover */
    #btnPrevBatchEntry:hover .fa-chevron-left,
    #btnNextBatchEntry:hover .fa-chevron-right {
        color: white;
    }

    #btnPrevBatchEntry {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        border-right: 0;
    }

    #btnNextBatchEntry {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        border-left: 0;
        border-right: 1px solid #ced4da;
        /* kasih border kanan biar keliatan pemisah */
    }

    /* style tombol search */
    #btnSearchBatchEntry {
        border-left: 0;
        /* ilangin border kiri biar nyambung sama tombol panah */
    }

    /* style pas tombol disabled */
    #btnPrevBatchEntry:disabled:hover,
    #btnNextBatchEntry:disabled:hover {
        background-color: #e9ecef;
        border-color: #ced4da;
        color: #6c757d;
        cursor: not-allowed;
    }
</style>

<?= $this->endSection('style'); ?>

<?= $this->section('content'); ?>

<?php
$session = session();
?>

<!-- ini wrapper konten utama -->
<div class="content-wrapper">
    <!-- bagian header konten -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1></h1>
                </div>
                <div class="col-sm-6">
                    <!-- <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Field Value</li>
                    </ol> -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- ini konten utama -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- kolom kiri -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="row align-items-end">
                                        <?= csrf_field(); ?>
                                        <div class="col-sm-3">
                                            <label for="">Batch Number</label>
                                            <?= $cb_batchid ?>
                                        </div>

                                        <div class="col-sm-3">
                                            <label for="EnteredBatchIdBy">Entered By</label>
                                            <input type="text" class="form-control form-control-sm" id="EnteredBatchIdBy" name="EnteredBatchIdBy" readonly>
                                            <span class="error invalid-feedback errorDiagnosa_cd"></span>
                                        </div>

                                        <div class="col-sm-3">
                                            <!-- tombol export -->
                                            <button type="button" class="btn btn-sm btn-success" onclick="exportToExcel()" title="Export">
                                                Export
                                            </button>
                                            <!-- tombol import -->
                                            <button type="button" class="btn btn-sm btn-primary" onclick="importFromExcel()" title="Import from Excel">
                                                Import
                                            </button>
                                        </div>
                                    </div>

                                    <div class="row align-items-end mt-2">
                                        <div class="col-sm-6">
                                            <label for="BatchDesc" class="col-form-label">Batch Description</label>
                                            <div class="d-flex align-items-center">
                                                <input type="text" class="form-control form-control-sm flex-grow-1 me-2" id="BatchDesc" name="BatchDesc" readonly>
                                            </div>
                                            <span class="error invalid-feedback errorDiagnosa"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="card-body px-3 py-2">
                                        <h6 class="mb-3 fw-bold">Batch Summary</h6>

                                        <div class="row mb-2">
                                            <div class="col-6 d-flex justify-content-between">
                                                <span class="text-muted">Entries</span>
                                                <span class="fw-bold" id="SummaryEntries"></span>
                                            </div>
                                            <div class="col-6 d-flex justify-content-between">
                                                <span class="text-muted">Debits</span>
                                                <span class="fw-bold" id="SummaryDebits"></span>
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-6 d-flex justify-content-between">
                                                <span class="text-muted">Type</span>
                                                <span class="fw-bold" id="SummaryBatchType"></span>
                                            </div>
                                            <div class="col-6 d-flex justify-content-between">
                                                <span class="text-muted">Credits</span>
                                                <span class="fw-bold" id="SummaryCredits"></span>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6 d-flex justify-content-between">
                                                <span class="text-muted">Status</span>
                                                <span class="fw-bold" id="SummaryBatchStatus"></span>
                                            </div>
                                            <div class="col-6"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row align-items-end">
                                        <?= csrf_field(); ?>
                                        <div class="col-sm-2">
                                            <label for="cb_batchentry" class="form-label">Entry Number</label>

                                            <div class="input-group">
                                                <!-- Tombol panah kiri - awalnya disembunyiin -->
                                                <div class="input-group-prepend" id="prevArrowContainer" style="display: none;">
                                                    <button class="btn btn-outline-secondary btn-sm"
                                                        type="button"
                                                        id="btnPrevBatchEntry"
                                                        title="Previous Entry">
                                                        <i class="fas fa-chevron-left"></i>
                                                    </button>
                                                </div>

                                                <div class="flex-grow-1">
                                                    <?= $cb_batchentry ?>
                                                </div>

                                                <!-- Tombol panah kanan - awalnya disembunyiin -->
                                                <div class="input-group-append" id="nextArrowContainer" style="display: none;">
                                                    <button class="btn btn-outline-secondary btn-sm"
                                                        type="button"
                                                        id="btnNextBatchEntry"
                                                        title="Next Entry">
                                                        <i class="fas fa-chevron-right"></i>
                                                    </button>
                                                </div>

                                                <!-- Tombol search selalu keliatan -->
                                                <div class="input-group-append">
                                                    <span class="input-group-text btn-search-batchentry"
                                                        id="btnSearchBatchEntry"
                                                        style="cursor:pointer">
                                                        <i class="fa fa-search"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="JrnlDesc">Entry Description</label>
                                            <input type="text" class="form-control form-control-sm" id="JrnlDesc" name="JrnlDesc">
                                            <span class="error invalid-feedback errorDiagnosa_cd"></span>
                                        </div>

                                        <!-- Document Date -->
                                        <div class="col-sm-2">
                                            <label for="DataEntry" class="form-label">Document Date</label>
                                            <input type="date"
                                                class="form-control form-control-sm"
                                                id="DataEntry"
                                                name="DataEntry"
                                                value="<?= date('Y-m-d') ?>"
                                                autocomplete="off">
                                        </div>

                                        <!-- Posting Date -->
                                        <div class="col-sm-2">
                                            <label for="PostDate" class="form-label">Posting Date</label>
                                            <input type="date"
                                                class="form-control form-control-sm"
                                                id="PostDate"
                                                name="PostDate"
                                                value="<?= date('Y-m-d') ?>"
                                                autocomplete="off">
                                            <span class="error invalid-feedback errorPostDate"></span>
                                        </div>

                                        <div class="col-sm-2">
                                            <label for="YearPeriod" class="form-label">Year / Period</label>
                                            <div class="input-group date YearPeriod">
                                                <input type="text"
                                                    class="form-control form-control-sm modal-trigger"
                                                    placeholder="yyyy-mm"
                                                    id="YearPeriod"
                                                    name="YearPeriod"
                                                    readonly
                                                    onkeydown="return false;"
                                                    onpaste="return false;"
                                                    style="cursor:pointer; caret-color: transparent;"
                                                    data-toggle="modal" data-target="#modalFiscalCalender"
                                                    autocomplete="off">
                                                <div class="input-group-append">
                                                    <div class="input-group-text btn-modal-fiscal"
                                                        style="cursor:pointer;"
                                                        data-toggle="modal" data-target="#modalFiscalCalender">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="error invalid-feedback errorYearPeriod_date"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-sm-12">
                                    <div class="row align-items-end">
                                        <?= csrf_field(); ?>

                                        <div class="col-sm-3">
                                            <label for="">Source Ledger</label>
                                            <div class="row">
                                                <div class="col">
                                                    <?= $cb_srceledger ?>
                                                </div>
                                                <div class="col">
                                                    <?= $cb_srcetype ?>
                                                    <span class="error invalid-feedback errorDiagnosa_cd"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <label for="SrceDesc">Source Code Description</label>
                                            <input type="text" class="form-control form-control-sm" id="SrceDesc" name="SrceDesc" readonly>
                                            <span class="error invalid-feedback errorDiagnosa_cd"></span>
                                        </div>

                                        <div class="col-sm-1"></div>

                                        <div class="col-sm-2 mb-1">
                                            <span id="BatchEntryDeletedBadge"
                                                style="background:#dc3545;color:#fff;padding:4px 8px;border-radius:3px;font-weight:bold;display:none;">
                                                Deleted
                                            </span>
                                        </div>

                                        <div class="col-sm-2">
                                            <label for="CreateJournalBy">Create By</label>
                                            <input type="text" class="form-control form-control-sm" id="CreateJournalBy" name="CreateJournalBy" readonly>
                                            <span class="error invalid-feedback errorDiagnosa_cd"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- kolom kiri -->
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-outline card-info">
                        <div class="card-body">
                            <table id="gljournallistTable" class="table table-sm table-bordered table-striped">
                                <thead class="table">
                                    <tr>
                                        <th class="text-center">
                                            <input type="checkbox" id="selectAll" class="checkbox-header">
                                        </th>
                                        <th>Line Number</th>
                                        <th>Reference</th>
                                        <th>Description</th>
                                        <th>Account Number</th>
                                        <th>Account Name</th>
                                        <th>Source Currency</th>
                                        <th>Source Debit</th>
                                        <th>Source Credit</th>
                                        <th>Rate</th>
                                        <th>Rate Date</th>
                                        <th>Functional Debit</th>
                                        <th>Functional Credit</th>
                                        <th>Comment</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>

                            <div class="row mt-3 d-none" id="summarySection">
                                <div class="row g-3 align-items-end justify-content-start">
                                    <div class="col-sm-2">
                                        <label for="Debits" class="form-label">Debits</label>
                                        <input type="text" class="form-control form-control-sm text-end" id="Debits" name="Debits" readonly>
                                    </div>

                                    <div class="col-sm-2">
                                        <label for="Credits" class="form-label">Credits</label>
                                        <input type="text" class="form-control form-control-sm text-end" id="Credits" name="Credits" readonly>
                                    </div>

                                    <div class="col-sm-2">
                                        <label for="OutOfBalance" class="form-label">Out of Balance By</label>
                                        <input type="text" class="form-control form-control-sm text-end" id="OutOfBalance" name="OutOfBalance" readonly>
                                    </div>

                                    <div class="col-sm-auto">
                                        <button type="button" class="btn btn-sm btn-success" onclick="saveAllToDatabase()" id="saveToDatabase">
                                            Save
                                        </button>
                                    </div>

                                    <div class="col-sm-auto">
                                        <button type="button" class="btn btn-sm btn-danger" id="btnDeleteBatchEntry">
                                            Delete
                                        </button>
                                    </div>

                                    <div class="col-sm-auto offset-sm-2">
                                        <button type="button" class="btn btn-sm btn-warning" id="btnReverseBatchEntry">
                                            Reverse
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- MODAL: Journal Entry -->
                            <div class="modal fade" id="modalform" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h4 id="exampleModalLabel">Journal Entry</h4>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>

                                        <form method="post" id="data_form" autocomplete="off" novalidate>
                                            <?= csrf_field(); ?>

                                            <div class="modal-body" style="max-height:70vh; overflow-y:auto;">

                                                <div class="row g-3">

                                                    <div class="col-md-6">

                                                        <div class="form-group">
                                                            <label for="LineNumber">Line Number</label>
                                                            <input type="text" class="form-control form-control-sm" id="LineNumber" name="LineNumber" readonly>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="TransRef">Reference</label>
                                                            <input type="text" class="form-control form-control-sm" id="TransRef" name="TransRef" required>
                                                            <div class="invalid-feedback"></div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="AcctId">Account Number</label>

                                                            <div class="input-group">
                                                                <input type="text" class="form-control form-control-sm" id="AcctId" name="AcctId" readonly required>

                                                                <div class="input-group-append">
                                                                    <button class="btn btn-outline-secondary btn-sm" type="button" id="btnSearchAccount">
                                                                        <i class="fas fa-search"></i>
                                                                    </button>
                                                                </div>

                                                            </div>

                                                            <div class="invalid-feedback"></div>
                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">

                                                        <div class="form-group d-flex justify-content-end align-items-center" style="margin-top:25px;">
                                                            <button type="button" class="btn btn-sm btn-success mr-2" id="btnNormalModeModal">
                                                                <i class="fa fa-plus"></i> New Line
                                                            </button>

                                                            <button type="button" class="btn btn-sm btn-warning" id="btnQuickModeModal">
                                                                <i class="fas fa-bolt"></i> Quick Entry Mode
                                                            </button>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="TransDesc">Description</label>
                                                            <input type="text" class="form-control form-control-sm" id="TransDesc" name="TransDesc">
                                                            <div class="invalid-feedback"></div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="AcctName">Account Name</label>
                                                            <input type="text" class="form-control form-control-sm" id="AcctName" name="AcctName" readonly>
                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="row mb-3 justify-content-center">

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label for="ScurnCode">Source Currency</label>
                                                            <?= $cb_scurncode ?>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label for="RateDate">Rate Date</label>
                                                            <input type="date"
                                                                class="form-control form-control-sm"
                                                                id="RateDate"
                                                                name="RateDate"
                                                                value="<?= date('Y-m-d') ?>"
                                                                autocomplete="off">
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label for="ConvRate">Rate</label>
                                                            <input type="number" class="form-control form-control-sm" id="ConvRate" name="ConvRate" readonly required>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row g-3">

                                                    <div class="col-md-6">

                                                        <div class="form-group">
                                                            <label for="ScurnAmtDebit">Source Debit</label>
                                                            <input type="number" class="form-control form-control-sm" id="ScurnAmtDebit" name="ScurnAmtDebit" placeholder="0" step="0.01" min="0">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="TransAmtDebit">Functional Debit</label>
                                                            <input type="number" class="form-control form-control-sm" id="TransAmtDebit" name="TransAmtDebit" placeholder="0" step="0.01" min="0">
                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">

                                                        <div class="form-group">
                                                            <label for="ScurnAmtCredit">Source Credit</label>
                                                            <input type="number" class="form-control form-control-sm" id="ScurnAmtCredit" name="ScurnAmtCredit" placeholder="0" step="0.01" min="0">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="TransAmtCredit">Functional Credit</label>
                                                            <input type="number" class="form-control form-control-sm" id="TransAmtCredit" name="TransAmtCredit" placeholder="0" step="0.01" min="0">
                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="alert alert-warning mt-3 text-center" id="amountValidationAlert" style="display:none;">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                    <span id="amountValidationMessage"></span>
                                                </div>

                                                <div class="form-group">
                                                    <label for="Comment">Comment</label>
                                                    <textarea class="form-control form-control-sm" id="Comment" name="Comment" rows="3"></textarea>
                                                </div>

                                                <input type="hidden" id="HcurnCode" name="HcurnCode">
                                                <input type="hidden" id="AudtUser" name="AudtUser">
                                                <input type="hidden" id="AudtTime" name="AudtTime">
                                                <input type="hidden" id="hidden_id" name="hidden_id">
                                                <input type="hidden" id="action" name="action" value="Add">

                                            </div>

                                            <div class="modal-footer d-flex justify-content-end">

                                                <button type="button"
                                                    class="btn btn-sm btn-primary mr-2"
                                                    onclick="validateAndSaveJournalEntry()">
                                                    Simpan
                                                </button>

                                                <button type="button"
                                                    class="btn btn-sm btn-secondary"
                                                    data-dismiss="modal">

                                                    <i class="fas fa-times"></i> Tutup

                                                </button>

                                            </div>

                                        </form>

                                    </div>
                                </div>
                            </div>

                            <!-- MODAL: buat milih batch entry yang udah ada -->
                            <div class="modal fade" id="modalBatchEntry" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 id="modalBatchEntry">Batch Description</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="table-responsive">
                                                <table id="batchentrydatatables"
                                                    class="table table-bordered table-striped table-hover"
                                                    style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th width="10%">Batch Entry</th>
                                                            <th width="20%">Batch Description</th>
                                                            <th width="5%">Document Date</th>
                                                            <th width="5%">Module</th>
                                                            <th width="5%">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                                                Close
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- MODAL: buat milih account dari chart of accounts -->
                            <div class="modal fade" id="modalAccountCoa" tabindex="-1" role="dialog" aria-labelledby="modalAccountCoaLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 id="modalAccountCoaLabel">Chart Of Accounts</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="table-responsive">
                                                <table class="table table-sm table-bordered table-striped" id="mastercoaget" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Account No</th>
                                                            <th>Account Name</th>
                                                            <th class="text-center">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- MODAL: buat milih fiscal calendar -->
                            <div class="modal fade" id="modalFiscalCalender" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 id="modalFiscalCalender">Fiscal Calender</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="table-responsive">
                                                <table id="fiscalcalenderlockget" class="table table-bordered table-striped table-hover" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th width="10%">Fiscal Year</th>
                                                            <th width="10%">Fiscal Period</th>
                                                            <th width="10%">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- MODAL: buat export data ke excel -->
                            <div class="modal fade" id="modalExport" tabindex="-1" role="dialog" aria-labelledby="modalExportLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                    <div class="modal-content shadow-lg border-0">
                                        <!-- Header -->
                                        <div class="modal-header bg-success text-white">
                                            <h5 id="modalExportLabel">
                                                <i class="fas fa-file-export mr-2"></i> Export Journal
                                            </h5>
                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <!-- Body -->
                                        <div class="modal-body">
                                            <form id="exportForm">
                                                <?= csrf_field(); ?>

                                                <div class="row mb-3">
                                                    <!-- Batch ID -->
                                                    <div class="col-md-6 d-flex">
                                                        <div class="card border-primary w-100">
                                                            <div class="card-body p-2">
                                                                <label class="font-weight-bold mb-1">Batch Number</label>
                                                                <div id="exportBatchIdDisplay" class="form-control-plaintext font-weight-bold text-primary"></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Tipe Export -->
                                                    <div class="col-md-6 d-flex">
                                                        <div class="card border-info w-100">
                                                            <div class="card-body d-flex align-items-center">
                                                                <div>
                                                                    <label class="font-weight-bold mb-2">Tipe Export</label>
                                                                    <div>
                                                                        <div class="form-check form-check-inline">
                                                                            <input class="form-check-input" type="radio" name="exportType" id="exportAll" value="all" checked onchange="toggleRangeFields()">
                                                                            <label class="form-check-label font-weight-bold" for="exportAll">ALL Batch Entries</label>
                                                                        </div>
                                                                        <div class="form-check form-check-inline">
                                                                            <input class="form-check-input" type="radio" name="exportType" id="exportRange" value="range" onchange="toggleRangeFields()">
                                                                            <label class="form-check-label font-weight-bold" for="exportRange">Range Batch Entry</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Range Fields -->
                                                <div id="rangeFields" class="mt-3" style="display: none;">
                                                    <div class="card border-warning">
                                                        <div class="card-body p-2">
                                                            <label class="font-weight-bold">Range Batch Entry</label>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label for="startRangeBatchEntry">Start Batch Entry</label>
                                                                    <?= $cb_startrangebatchentry ?>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="endRangeBatchEntry">End Batch Entry</label>
                                                                    <?= str_replace('cb_endrangebatchentry', 'cb_endrangebatchentry', $cb_endrangebatchentry) ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                        <!-- Footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                                                <i class="fas fa-times"></i> Batal
                                            </button>
                                            <button type="button" class="btn btn-sm btn-success" onclick="processExport()">
                                                <i class="fas fa-download"></i> Export Data
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- MODAL: buat import data dari excel -->
                            <div class="modal fade" id="modalImport" tabindex="-1" role="dialog" aria-labelledby="modalImportLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                                    <div class="modal-content shadow-lg border-0">
                                        <!-- Header -->
                                        <div class="modal-header bg-primary text-white">
                                            <h5 id="modalImportLabel">
                                                <i class="fas fa-file-import mr-2"></i> Import Journal
                                            </h5>
                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <!-- Body -->
                                        <div class="modal-body">
                                            <!-- Batch Number + Download Template in one row -->
                                            <div class="row mb-3">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Batch Number</label>
                                                        <div id="importBatchIdDisplay" class="form-control-plaintext text-info font-weight-bold"></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 d-flex align-items-end">
                                                    <div class="form-group mb-0">
                                                        <label class="font-weight-bold">Download Template</label><br>
                                                        <button type="button" class="btn btn-success btn-sm" onclick="downloadTemplate()">
                                                            <i class="fas fa-download"></i> Download Template
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <!-- Upload Form -->
                                            <form id="importForm" enctype="multipart/form-data">
                                                <?= csrf_field(); ?>
                                                <div class="form-group">
                                                    <label for="importFile" class="font-weight-bold">Pilih File Excel</label>
                                                    <input type="file" class="form-control-file border p-2 rounded" id="importFile" name="filename" accept=".xlsx,.xls,.csv" required>
                                                    <small class="form-text text-muted">Format yang didukung: .xlsx, .xls, .csv</small>
                                                </div>
                                            </form>

                                            <div id="previewSection" class="mt-4" style="display: none;">
                                                <ul class="nav nav-tabs" id="previewTabs" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="summary-tab" data-toggle="tab" href="#summaryPreview" role="tab">
                                                            <i class="fas fa-chart-bar mr-1"></i> Summary
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="validation-tab" data-toggle="tab" href="#validationPreview" role="tab">
                                                            <i class="fas fa-check-circle mr-1"></i> Validation Results
                                                            <span id="validationBadge" class="badge badge-danger ml-1" style="display: none;">!</span>
                                                        </a>
                                                    </li>
                                                </ul>

                                                <div class="tab-content p-4 border border-top-0 bg-white rounded" id="previewContent">
                                                    <!-- Summary Tab -->
                                                    <div class="tab-pane fade show active" id="summaryPreview" role="tabpanel">
                                                        <div id="headerPreviewContent" class="container-fluid">
                                                        </div>
                                                    </div>

                                                    <!-- Validation Results Tab -->
                                                    <div class="tab-pane fade" id="validationPreview" role="tabpanel">
                                                        <div id="validationResults" style="display: none;"></div>
                                                        <div id="validationNotRun" class="text-center text-muted py-4">
                                                            <i class="fas fa-info-circle fa-2x mb-2"></i>
                                                            <p>Hasil validasi akan ditampilkan setelah proses import</p>
                                                        </div>
                                                        <div id="validationLoading" style="display: none;" class="text-center py-4">
                                                            <div class="spinner-border text-primary" role="status">
                                                                <span class="sr-only">Loading...</span>
                                                            </div>
                                                            <p class="mt-2">Memproses validasi...</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Footer -->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                                                    <i class="fas fa-times"></i> Batal
                                                </button>
                                                <button type="button" class="btn btn-sm btn-primary" id="btnPreview" onclick="previewFile()">
                                                    <i class="fas fa-eye mr-1"></i> Preview
                                                </button>
                                                <button type="button" class="btn btn-sm btn-success" id="btnImport" style="display: none;" onclick="processImport()">
                                                    <i class="fas fa-check"></i> Import Data
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection('content'); ?>

<?= $this->section('script'); ?>

<!-- Toastr -->
<script src="<?= base_url('plugins/toastr/toastr.min.js') ?>"></script>

<!-- ===================== MULAI SCRIPT-SCRIPT JAVASCRIPT ===================== -->

<p id="active-menu" hidden>G/L Journal Entry</p>
<script>
    $('#active-menu').html($('p#active-menu').html());
    $(document).prop("title", $('p#active-menu').html());

    $('#active-menu').prepend(`
        <a href="<?= base_url('tmstglbatchlist') ?>" 
           style="margin-right:10px;color:#555;text-decoration:none;">
            <i class="fa fa-arrow-left"></i>
        </a>
    `);
</script>

<!-- ===================================================== -->
<!-- SCRIPT MODAL BATCH ENTRY - buat cari dan pilih batch entry -->
<!-- ===================================================== -->
<script>
    $(document).ready(function() {
        let batchEntryTable = null;

        function initBatchEntryTable() {
            if (batchEntryTable) {
                batchEntryTable.destroy();
            }

            batchEntryTable = $('#batchentrydatatables').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                pageLength: 5,
                lengthMenu: [5, 10, 15, 25, 50, 100],

                ajax: {
                    url: "<?= base_url('tmstgljournal/datatablesbatchentry') ?>",
                    type: "POST",
                    contentType: "application/json",
                    data: function(d) {
                        d.BatchId = $('#cb_batchid').val();
                        return JSON.stringify(d);
                    }
                },

                columns: [{
                        data: 'batchEntry',
                        className: 'text-center'
                    },
                    {
                        data: 'jrnlDesc',
                        className: 'text-center'
                    },
                    {
                        data: 'dateEntry',
                        className: 'text-center',
                        render: function(data, type, row) {
                            if (data) {
                                const date = new Date(data);
                                const day = String(date.getDate()).padStart(2, '0');
                                const month = String(date.getMonth() + 1).padStart(2, '0');
                                const year = date.getFullYear();
                                return `${day}/${month}/${year}`;
                            }
                            return '';
                        }
                    },
                    {
                        data: null,
                        className: 'text-center',
                        render: function(data, type, row) {
                            return row.srceLedger + ' | ' + row.srceType;
                        }
                    },
                    {
                        data: 'statusBatchEntry',
                        className: 'text-center',
                        render: function(data) {
                            return data === 'Deleted' ?
                                '<span class="badge badge-danger">Deleted</span>' :
                                '<span class="badge badge-success">Active</span>';
                        }
                    }
                ],

                createdRow: function(row, data, dataIndex) {
                    $(row).addClass('clickable-row');
                    $(row).css('cursor', 'pointer');
                },

                language: {
                    lengthMenu: "Show _MENU_ entries",
                    search: "Search:",
                    zeroRecords: "Data tidak ditemukan",
                    infoEmpty: "Tidak ada data",
                    paginate: {
                        previous: "Previous",
                        next: "Next"
                    }
                }
            });

            $('#batchentrydatatables tbody').on('click', 'tr', function() {
                const data = batchEntryTable.row(this).data();

                if (data) {
                    const batchEntry = data.batchEntry;

                    $('#cb_batchentry')
                        .val(batchEntry)
                        .trigger('change');

                    $('#modalBatchEntry').modal('hide');
                }
            });
        }

        $(document).on('click', '#btnSearchBatchEntry', function() {
            const batchId = $('#cb_batchid').val();

            $('#modalBatchEntry').modal('show');

            if ($.fn.DataTable.isDataTable('#batchentrydatatables')) {
                $('#batchentrydatatables').DataTable().ajax.reload();
            } else {
                initBatchEntryTable();
            }
        });

        $('<style>')
            .text('.clickable-row { cursor: pointer; } .clickable-row:hover { background-color: rgba(0, 123, 255, 0.1) !important; }')
            .appendTo('head');
    });
</script>

<!-- ===================================================== -->
<!-- SCRIPT MODAL FISCAL CALENDAR - buat milih tahun dan periode -->
<!-- ===================================================== -->
<script>
    $(document).ready(function() {
        let fiscalCalenderTable = null;
        let select2Instance = null;

        function getFiscalParams() {
            const srceLedger = $('#cb_srceledger').val();
            const postDate = $('#PostDate').val();

            let fiscYear = null;

            if (postDate) {
                if (postDate.includes('/')) {
                    const parts = postDate.split('/');
                    if (parts.length === 3) {
                        fiscYear = parts[2];
                    }
                } else if (postDate.includes('-')) {
                    fiscYear = postDate.split('-')[0];
                }
            }

            return {
                srceLedger,
                fiscYear
            };
        }

        function cleanupBeforeInit() {
            if (fiscalCalenderTable !== null && $.fn.DataTable.isDataTable('#fiscalcalenderlockget')) {
                try {
                    fiscalCalenderTable.destroy();
                } catch (e) {
                    console.warn('Error destroying DataTable:', e);
                }
                fiscalCalenderTable = null;
            }

            if (select2Instance && $('#cb_fiscal_calender').hasClass('select2-hidden-accessible')) {
                try {
                    $('#cb_fiscal_calender').select2('destroy');
                } catch (e) {
                    console.warn('Error destroying select2:', e);
                }
                select2Instance = null;
            }

            $('#fiscal-year-dropdown-container').remove();

            $('#fiscalcalenderlockget').empty().html(`
                <thead>
                    <tr>
                        <th width="10%">Fiscal Year</th>
                        <th width="10%">Fiscal Period</th>
                        <th width="10%">Status</th>
                    </tr>
                </thead>
                <tbody></tbody>
            `);
        }

        function initFiscalCalenderTable() {
            cleanupBeforeInit();

            const params = getFiscalParams();
            const selectedYear = params.fiscYear;

            const tableWrapper = $('#fiscalcalenderlockget').closest('.modal-body');

            const dropdownHtml = `
                <div id="fiscal-year-dropdown-container" class="mb-3">
                    <label for="cb_fiscal_calender" class="form-label">Fiscal Year:</label>
                    <div class="dropdown-loading" style="min-height: 38px;">
                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        Loading dropdown...
                    </div>
                    <select class="form-control form-control-sm" id="cb_fiscal_calender" style="width: 100%; display: none;">
                        <option value="">--Select--</option>
                    </select>
                </div>
            `;
            tableWrapper.prepend(dropdownHtml);

            loadFiscalYearDropdown(selectedYear);
        }

        function loadFiscalYearDropdown(selectedYear = null) {
            $.ajax({
                url: "<?= base_url('tmstgljournal/getFiscalYear') ?>",
                type: "GET",
                data: {
                    fiscYear: selectedYear
                },
                dataType: "json",
                success: function(response) {
                    if (response.success && response.data && response.data.length > 0) {
                        const select = $('#cb_fiscal_calender');
                        const loadingDiv = $('.dropdown-loading');

                        loadingDiv.hide();
                        select.show().empty();

                        select.append('<option value="">--Select--</option>');

                        $.each(response.data, function(index, item) {
                            const option = new Option(item.desc, item.value);
                            select.append(option);
                        });

                        if (selectedYear) {
                            if (select.find('option[value="' + selectedYear + '"]').length > 0) {
                                select.val(selectedYear).trigger('change');
                            } else {
                                console.warn('Selected year not found in dropdown:', selectedYear);
                            }
                        }

                        select.off('change.fiscal').on('change.fiscal', function() {
                            if (fiscalCalenderTable) {
                                fiscalCalenderTable.ajax.reload(null, false);
                            }
                        });

                        initDataTable();
                    } else {
                        $('.dropdown-loading').html('<div class="text-muted">No data available</div>');
                        initDataTable();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error loading fiscal year dropdown:', error);
                    $('.dropdown-loading').html('<div class="text-danger">Error loading data</div>');
                    initDataTable();
                }
            });
        }

        function initDataTable() {
            if ($.fn.DataTable.isDataTable('#fiscalcalenderlockget')) {
                console.warn('DataTable already initialized, skipping...');
                return;
            }

            fiscalCalenderTable = $('#fiscalcalenderlockget').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                pageLength: 15,
                dom: '<"row"<"col-sm-12"tr>><"row"<"col-sm-5"i><"col-sm-7"p>>',
                lengthChange: false,
                searching: false,
                deferRender: true,
                destroy: true,
                language: {
                    loadingRecords: '',
                    processing: '',
                    emptyTable: 'No data available'
                },

                ajax: {
                    url: "<?= base_url('tmstgljournal/datatablesfiscalcalender') ?>",
                    type: "POST",
                    contentType: "application/json",

                    data: function(d) {
                        const srceLedger = $('#cb_srceledger').val();
                        const selectedYear = $('#cb_fiscal_calender').val();

                        if (!srceLedger || !selectedYear) {
                            return false;
                        }

                        d.SrceLedger = srceLedger;
                        d.FiscYear = selectedYear;

                        return JSON.stringify(d);
                    },

                    beforeSend: function(xhr, settings) {
                        const srceLedger = $('#cb_srceledger').val();
                        const selectedYear = $('#cb_fiscal_calender').val();

                        if (!srceLedger || !selectedYear) {
                            $('#fiscalcalenderlockget tbody').html(`
                                <tr>
                                    <td colspan="3" class="text-center text-muted">
                                        Silakan pilih Source Ledger dan Fiscal Year terlebih dahulu
                                    </td>
                                </tr>
                            `);
                            return false;
                        }
                    },

                    error: function(xhr) {
                        $('#fiscalcalenderlockget tbody').html(`
                            <tr>
                                <td colspan="3" class="text-center text-danger">
                                    Error loading data
                                </td>
                            </tr>
                        `);
                    }
                },

                columns: [{
                        data: 'fiscYear',
                        className: 'text-center'
                    },
                    {
                        data: 'fiscPeriodName',
                        className: 'text-center',
                        render: function(d, type, row) {
                            return d || '';
                        }
                    },
                    {
                        data: 'statusLockFiscal',
                        className: 'text-center',
                        render: function(d) {
                            return d === 'x' ? '<i class="fa fa-times text-danger"></i>' : '';
                        }
                    }
                ],

                createdRow: function(row, data) {
                    const isLocked =
                        data.statusLock == 1 ||
                        data.statusLock === true ||
                        data.statusLockFiscal === 'x';

                    $(row)
                        .toggleClass('clickable-fiscal-row', !isLocked)
                        .toggleClass('locked-row', isLocked)
                        .css('cursor', isLocked ? 'not-allowed' : 'pointer');
                },

                drawCallback: function(settings) {
                    $('#fiscalcalenderlockget').css('opacity', 0).animate({
                        opacity: 1
                    }, 300);
                },

                initComplete: function(settings, json) {}
            });

            $('#fiscalcalenderlockget').off('click', 'tr.clickable-fiscal-row').on('click', 'tr.clickable-fiscal-row', function() {
                if (!fiscalCalenderTable) return;

                const data = fiscalCalenderTable.row(this).data();
                if (!data) return;

                $('#YearPeriod')
                    .val(data.fiscYear + '-' + String(data.fiscPeriod).padStart(2, '0'))
                    .trigger('change');

                $('#modalFiscalCalender').modal('hide');
            });
        }

        $(document).on('click', '#YearPeriod, .btn-modal-fiscal', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const params = getFiscalParams();

            if (!params.srceLedger && !params.fiscYear) {
                alert('Source Ledger dan Posting Date harus diisi terlebih dahulu');
                return;
            }

            if (!params.srceLedger) {
                alert('Source Ledger harus diisi terlebih dahulu');
                return;
            }

            if (!params.fiscYear) {
                alert('Posting Date harus diisi terlebih dahulu');
                return;
            }

            $('#modalFiscalCalender').modal('show');

            $('#modalFiscalCalender').off('shown.bs.modal');
            $('#modalFiscalCalender').on('shown.bs.modal', function() {
                initFiscalCalenderTable();
            });
        });

        $('#modalFiscalCalender').on('hidden.bs.modal', function() {
            cleanupBeforeInit();
        });

        $('<style>')
            .text(`
                .clickable-fiscal-row:hover { background: rgba(0,123,255,.1); }
                .locked-row { opacity:.6 }
                #fiscal-year-dropdown-container { padding: 10px 15px; background-color: #f8f9fa; border-bottom: 1px solid #dee2e6; margin-bottom: 0; }
                .modal-body { padding-top: 0 !important; }
                .select2-container { width: 100% !important; }
                .dropdown-loading { display: flex; align-items: center; gap: 10px; color: #6c757d; }
                #fiscalcalenderlockget_wrapper { transition: opacity 0.3s ease; }
                .dataTables_processing { 
                    display: none !important;
                }
                table.dataTable {
                    margin-top: 0 !important;
                    margin-bottom: 0 !important;
                    border-collapse: collapse !important;
                }
                .table-responsive {
                    overflow-x: auto;
                    min-height: 200px;
                }
            `)
            .appendTo('head');
    });
</script>

<!-- ===================================================== -->
<!-- SCRIPT MODAL MASTER COA - buat cari dan pilih account -->
<!-- ===================================================== -->
<script>
    $(document).ready(function() {
        let masterCoaTable;

        function initMasterCoaTable() {
            if (masterCoaTable) {
                masterCoaTable.destroy();
            }

            masterCoaTable = $('#mastercoaget').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                ajax: {
                    url: "<?= base_url('tmstgljournal/datatablesmastercoa') ?>",
                    type: "POST",
                    contentType: "application/json",
                    data: function(d) {
                        return JSON.stringify(d);
                    }
                },
                columnDefs: [{
                    orderable: false,
                    targets: [2]
                }, {
                    targets: [2],
                    className: 'text-center'
                }],
                columns: [{
                        data: 'acctNo',
                        className: 'text-center'
                    },
                    {
                        data: 'acctName'
                    },
                    {
                        data: null,
                        orderable: false,
                        render: function(data, type, row) {
                            return `
                                <button type="button" class="btn btn-sm btn-primary select-account" 
                                        data-acctno="${row.acctNo}" 
                                        data-acctname="${row.acctName}">
                                    <i class="fas fa-check"></i> Pilih
                                </button>
                            `;
                        }
                    }
                ],
                oLanguage: {
                    sSearch: "Search:",
                    sInfoEmpty: "Tidak ada data",
                    sInfo: "",
                    sInfoFiltered: "",
                    sZeroRecords: "Data tidak ditemukan",
                    oPaginate: {
                        sFirst: "Awal",
                        sPrevious: "Sebelum",
                        sNext: "Berikut",
                        sLast: "Akhir"
                    }
                }
            }).buttons().container().appendTo("#mastercoaget_wrapper .col-md-6:eq(0)");
        }

        $('#btnSearchAccount').on('click', function() {
            $('#modalAccountCoa').modal('show');

            if (!masterCoaTable) {
                initMasterCoaTable();
            } else {
                masterCoaTable.ajax.reload();
            }
        });

        $(document).on('click', '.select-account', function() {
            const acctNo = $(this).data('acctno');
            const acctName = $(this).data('acctname');

            $('#AcctId').val(acctNo);
            $('#AcctName').val(acctName);
            $('#modalAccountCoa').modal('hide');
            $('#ScurnAmt').focus();
        });

        $('#modalAccountCoa').on('hidden.bs.modal', function() {
            if (masterCoaTable) {
                masterCoaTable.search('').draw();
            }
        });

        $('#AcctId').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                $('#btnSearchAccount').click();
            }
        });

        $(document).on('dblclick', '#mastercoaget tbody tr', function() {
            const acctNo = $(this).find('.select-account').data('acctno');
            const acctName = $(this).find('.select-account').data('acctname');

            if (acctNo && acctName) {
                $('#AcctId').val(acctNo);
                $('#AcctName').val(acctName);
                $('#modalAccountCoa').modal('hide');
            }
        });
    });
</script>

<!-- =====================================================  -->
<!-- SCRIPT UTAMA - GL JOURNAL ENTRY MANAGEMENT SYSTEM      -->
<!-- =====================================================  -->
<!-- DIBUAT OLEH: Rifaa                                     -->
<!-- TANGGAL: 2025-2026                                     -->
<!-- CATATAN: Script ini ngatur semua fungsi journal        -->
<!-- =====================================================  -->

<!-- =====================================================  -->
<!-- BAGIAN 1: KONFIGURASI AWAL & VARIABEL GLOBAL           -->
<!-- =====================================================  -->
<script>
    // =====================================================
    // 1.1 - INISIALISASI VARIABEL GLOBAL
    // =====================================================

    let journalEntries = [];
    let currentEditTransaction = null;

    let editIndex = null;

    let currentEntryMode = 'normal';

    let savedFormData = null;
    let isPostDateManuallyEdited = false;
    let isRateDateManuallyEdited = false;

    let isNewEntry = false;
    let deletedEntries = [];
    let softEditEntries = {};

    let activeBatchId = null;
    let activeBatchEntry = null;
    let pendingAjaxRequests = [];

    let activeSrceDescRequest = null;
    let activeSrceDescBatch = null;
    let activeSrceDescType = null;
    let userCreatedBatchEntries = [];

    const userId = '<?= session()->get("usr_id") ?>';

    const LOCAL_STORAGE_KEY = `gl_journal_${userId}`;

    let currentBatchId = null;
    let currentBatchEntry = null;

    // =====================================================
    // 1.2 - LOAD SOFT EDIT DATA
    // =====================================================
    function loadSoftEditData() {
        const softEditKey = `soft_edit_${userId}`;
        const savedData = localStorage.getItem(softEditKey);
        softEditEntries = savedData ? JSON.parse(savedData) : {};
    }

    // =====================================================
    // 1.3 - PANGGIL FUNGSI
    // =====================================================
    loadSoftEditData();
</script>

<!-- ===================================================== -->
<!-- BAGIAN 2: FUNGSI-FUNGSI UTILITAS        -->
<!-- ===================================================== -->
<script>
    // =====================================================
    // 2.1 - FUNGSI FORMAT TANGGAL
    // =====================================================
    function formatDateDDMMYYYY(dateString) {
        if (!dateString) return '';

        // Jika sudah dalam format DD/MM/YYYY
        if (typeof dateString === 'string' && dateString.match(/^\d{2}\/\d{2}\/\d{4}$/)) {
            return dateString;
        }

        // Jika dalam format YYYY-MM-DD (dari input type date)
        if (typeof dateString === 'string' && dateString.match(/^\d{4}-\d{2}-\d{2}$/)) {
            const parts = dateString.split('-');
            return `${parts[2]}/${parts[1]}/${parts[0]}`;
        }

        // Coba parse dengan Date object
        const date = new Date(dateString);
        if (isNaN(date)) return '';

        const dd = String(date.getDate()).padStart(2, '0');
        const mm = String(date.getMonth() + 1).padStart(2, '0');
        const yyyy = date.getFullYear();
        return `${dd}/${mm}/${yyyy}`;
    }

    // Fungsi baru untuk konversi DD/MM/YYYY ke YYYY-MM-DD
    function formatDateYYYYMMDD(dateString) {
        if (!dateString) return '';

        // Jika dalam format YYYY-MM-DD (dari input type date)
        if (typeof dateString === 'string' && dateString.match(/^\d{4}-\d{2}-\d{2}$/)) {
            return dateString;
        }

        // Jika dalam format DD/MM/YYYY
        if (typeof dateString === 'string' && dateString.match(/^\d{2}\/\d{2}\/\d{4}$/)) {
            const parts = dateString.split('/');
            return `${parts[2]}-${parts[1]}-${parts[0]}`;
        }

        // Coba parse dengan Date object
        const date = new Date(dateString);
        if (isNaN(date)) return '';

        const yyyy = date.getFullYear();
        const mm = String(date.getMonth() + 1).padStart(2, '0');
        const dd = String(date.getDate()).padStart(2, '0');
        return `${yyyy}-${mm}-${dd}`;
    }

    // =====================================================
    // 2.2 - FORMAT TAHUN PERIODE
    // =====================================================
    function formatYearPeriod(year, month) {
        if (!year || !month) return '';
        const formattedMonth = String(month).padStart(2, '0');
        return `${year}-${formattedMonth}`;
    }

    // =====================================================
    // 2.3 - PARSE TANGGAL DD/MM/YYYY KE DATE OBJECT
    // =====================================================
    function parseDDMMYYYY(dateString) {
        if (!dateString) return null;
        const parts = dateString.split('/');
        if (parts.length !== 3) return null;

        const day = parseInt(parts[0], 10);
        const month = parseInt(parts[1], 10) - 1;
        const year = parseInt(parts[2], 10);
        return new Date(year, month, day);
    }

    // =====================================================
    // 2.4 - CAPITALIZE PERTAMA KARAKTER
    // =====================================================
    function capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    // =====================================================
    // 2.5 - CEK APAKAH DATA BERASAL DARI DATABASE
    // =====================================================
    function isDataFromDatabase() {
        const batchId = $('#cb_batchid').find('option:selected').data('batchid');
        const batchEntry = $('#cb_batchentry').val();

        if (!batchId || !batchEntry) return false;

        const isUserCreated = isUserCreatedBatchEntry(batchId, batchEntry);
        const hasDatabaseData = $('#gljournallistTable tbody tr:not(.temp-data)').length > 0;

        return !isUserCreated && hasDatabaseData;
    }

    // =====================================================
    // 2.6 - DAPATKAN LINE NUMBER BERIKUTNYA
    // =====================================================
    function getNextLineNumber(batchId, batchEntry) {
        return new Promise((resolve) => {
            let maxLineNumber = 0;

            $('#gljournallistTable tbody tr:not(.temp-data)').each(function() {
                const lineNumberText = $(this).find('td:eq(1)').text().trim();
                if (lineNumberText && !isNaN(lineNumberText)) {
                    const lineNumber = parseInt(lineNumberText);
                    if (lineNumber > maxLineNumber) {
                        maxLineNumber = lineNumber;
                    }
                }
            });

            const filteredEntries = journalEntries.filter(entry =>
                entry.BatchId === batchId &&
                entry.BatchEntry === batchEntry &&
                entry.AudtUser === userId
            );

            if (filteredEntries.length > 0) {
                const maxLineNumberFromStorage = Math.max(...filteredEntries.map(entry => entry.lineNumber || 0));
                maxLineNumber = Math.max(maxLineNumber, maxLineNumberFromStorage);
            }

            resolve(maxLineNumber === 0 ? 1 : maxLineNumber + 1);
        });
    }

    // =====================================================
    // 2.7 - MEMBATALKAN SEMUA PERMINTAAN AJAX
    // =====================================================
    function cancelAllPendingRequests() {
        pendingAjaxRequests.forEach(xhr => {
            if (xhr && xhr.readyState !== 4) {
                xhr.abort();
            }
        });
        pendingAjaxRequests = [];
    }

    // =====================================================
    // 2.8 - MEMBATALKAN SOURCE DESCRIPTION REQUEST
    // =====================================================
    function cancelActiveSrceDescRequest() {
        if (activeSrceDescRequest && activeSrceDescRequest.readyState !== 4) {
            activeSrceDescRequest.abort();
            activeSrceDescRequest = null;
        }
    }
</script>

<!-- ===================================================== -->
<!-- BAGIAN 3: FUNGSI SOFT EDIT MANAGEMENT                 -->
<!-- ===================================================== -->
<script>
    // =====================================================
    // 3.1 - MEMBUAT KEY UNTUK SOFT EDIT
    // =====================================================
    function getSoftEditKey(batchId, batchEntry, transNbr) {
        return `soft_edit_${batchId}_${batchEntry}_${transNbr}`;
    }

    // =====================================================
    // 3.2 - SIMPAN SOFT EDIT KE LOCALSTORAGE
    // =====================================================
    function saveSoftEditData() {
        const softEditKey = `soft_edit_${userId}`;
        localStorage.setItem(softEditKey, JSON.stringify(softEditEntries));
    }

    // =====================================================
    // 3.3 - CEK APAKAH DATA PUNYA SOFT EDIT
    // =====================================================
    function hasSoftEdit(batchId, batchEntry, transNbr) {
        const key = getSoftEditKey(batchId, batchEntry, transNbr);
        return softEditEntries.hasOwnProperty(key);
    }

    // =====================================================
    // 3.4 - AMBIL DATA SOFT EDIT
    // =====================================================
    function getSoftEdit(batchId, batchEntry, transNbr) {
        const key = getSoftEditKey(batchId, batchEntry, transNbr);
        return softEditEntries[key] || null;
    }

    // =====================================================
    // 3.5 - SIMPAN SOFT EDIT
    // =====================================================
    function saveSoftEdit(batchId, batchEntry, transNbr, editData) {
        const key = getSoftEditKey(batchId, batchEntry, transNbr);
        softEditEntries[key] = {
            ...editData,
            softEditTimestamp: new Date().toISOString(),
            softEditBy: userId
        };
        saveSoftEditData();
    }

    // =====================================================
    // 3.6 - HAPUS SOFT EDIT
    // =====================================================
    function removeSoftEdit(batchId, batchEntry, transNbr) {
        const key = getSoftEditKey(batchId, batchEntry, transNbr);
        delete softEditEntries[key];
        saveSoftEditData();
    }

    // =====================================================
    // 3.7 - HAPUS SEMUA SOFT EDIT UNTUK BATCH TERTENTU
    // =====================================================
    function clearSoftEditByBatch(batchId, batchEntry) {
        Object.keys(softEditEntries).forEach(key => {
            if (key.includes(`soft_edit_${batchId}_${batchEntry}_`)) {
                delete softEditEntries[key];
            }
        });
        saveSoftEditData();
    }

    // =====================================================
    // 3.8 - CEK APAKAH ADA SOFT EDIT YANG BELUM DISIMPAN
    // =====================================================
    function hasUnsavedSoftEdit(batchId, batchEntry) {
        if (!batchId || !batchEntry) return false;

        let hasSoftEdit = false;
        Object.keys(softEditEntries).forEach(key => {
            if (key.includes(`soft_edit_${batchId}_${batchEntry}_`)) {
                hasSoftEdit = true;
            }
        });

        return hasSoftEdit;
    }
</script>

<!-- ===================================================== -->
<!-- BAGIAN 4: FUNGSI BATCH ENTRY MANAGEMENT               -->
<!-- ===================================================== -->
<script>
    // =====================================================
    // 4.1 - GENERATE NOMOR BATCH ENTRY BARU
    // =====================================================
    function generateBatchEntryNumber() {
        return '0000001';
    }

    // =====================================================
    // 4.2 - CEK APAKAH BATCH ENTRY DIBUAT OLEH USER
    // =====================================================
    function isUserCreatedBatchEntry(batchId, batchEntry) {
        return userCreatedBatchEntries.some(entry =>
            entry.batchId === batchId && entry.batchEntry === batchEntry
        );
    }

    // =====================================================
    // 4.3 - TAMBAHKAN USER CREATED BATCH ENTRY
    // =====================================================
    function addUserCreatedBatchEntry(batchId, batchEntry) {
        if (!isUserCreatedBatchEntry(batchId, batchEntry)) {
            userCreatedBatchEntries.push({
                batchId: batchId,
                batchEntry: batchEntry,
                createdAt: new Date().toISOString()
            });
            saveToLocalStorage();
        }
    }

    // =====================================================
    // 4.4 - HAPUS USER CREATED BATCH ENTRY
    // =====================================================
    function removeUserCreatedBatchEntry(batchId, batchEntry) {
        userCreatedBatchEntries = userCreatedBatchEntries.filter(entry =>
            !(entry.batchId === batchId && entry.batchEntry === batchEntry)
        );
        saveToLocalStorage();
    }

    // =====================================================
    // 4.5 - HAPUS BATCH ENTRY DARI DROPDOWN
    // =====================================================
    function removeBatchEntryFromDropdown(batchEntry) {
        $(`#cb_batchentry option[value="${batchEntry}"]`).remove();
    }

    // =====================================================
    // 4.6 - HANDLE TAMBAH BATCH ENTRY BARU
    // =====================================================
    function handleAddNewEntry(batchid) {
        let maxEntry = 0;

        $('#cb_batchentry option').each(function() {
            const val = $(this).val();
            if (val && /^\d+$/.test(val)) {
                const num = parseInt(val, 10);
                if (num > maxEntry) maxEntry = num;
            }
        });

        if (maxEntry >= 9999999) {
            Swal.fire({
                icon: 'warning',
                title: 'Batas Maksimum',
                text: 'EntryNumber udah mencapai batas maksimum.',
                confirmButtonText: 'OK'
            });
            return;
        }

        const nextEntry = maxEntry === 0 ? generateBatchEntryNumber() : String(maxEntry + 1).padStart(7, '0');

        const exists = $('#cb_batchentry option[value="' + nextEntry + '"]').length > 0;

        if (exists) {
            $('#cb_batchentry').val(nextEntry).trigger('change');
            return;
        }

        const selectOption = $('#cb_batchentry option[value=""]');
        const addOption = $('#cb_batchentry option[value="__add__"]');

        const newOption = new Option(nextEntry, nextEntry, true, true);
        $(newOption).attr('data-batchid', batchid).attr('data-entrynumber', nextEntry);

        if (addOption.length > 0) {
            addOption.remove();
            $(newOption).insertAfter(selectOption);
        } else if (selectOption.length > 0) {
            $(newOption).insertAfter(selectOption);
        } else {
            $('#cb_batchentry').prepend(newOption);
        }

        $('#cb_batchentry').val(nextEntry).trigger('change');

        addUserCreatedBatchEntry(batchid, nextEntry);

        resetAllUnsavedStates(batchid, nextEntry);

        resetHeaderFieldsForNewEntry();
        handleNewEntryConditions();
        resetSourceTypeForNewEntry();

        $('#CreateJournalBy').val('');
        $('#JrnlDesc').prop('readonly', false);
    }

    function resetAllUnsavedStates(batchId, batchEntry) {
        journalEntries = journalEntries.filter(entry =>
            !(entry.BatchId === batchId && entry.BatchEntry === batchEntry)
        );

        Object.keys(softEditEntries).forEach(key => {
            if (key.includes(`soft_edit_${batchId}_${batchEntry}_`)) {
                delete softEditEntries[key];
            }
        });

        deletedEntries = deletedEntries.filter(entry =>
            !(entry.BatchId === batchId && entry.BatchEntry === batchEntry)
        );

        saveToLocalStorage();
        saveSoftEditData();

        $(`tr[data-batchid="${batchId}"][data-batchentry="${batchEntry}"]`).remove();
        $('.temp-data').remove();
    }

    // =====================================================
    // 4.7 - LOAD BATCH ENTRIES
    // =====================================================
    function loadBatchEntries(batchid, preserveCurrentValue = true) {
        const currentBatchEntry = $('#cb_batchentry').val();
        const currentSrcetype = $('#cb_srcetype').val();
        const currentSrceDesc = $('#SrceDesc').val();
        const currentSrcetypeDisabled = $('#cb_srcetype').prop('disabled');

        $('#cb_batchentry')
            .prop('disabled', true)
            .html('<option value="">Loading...</option>');

        cancelAllPendingRequests();

        const requestTime = Date.now();
        const currentRequestId = `req_${batchid}_${requestTime}`;

        if (!window.lastBatchRequest) {
            window.lastBatchRequest = {};
        }
        window.lastBatchRequest[batchid] = currentRequestId;

        const xhr = $.ajax({
            url: "<?= site_url('tmstgljournal/getBatchEntry') ?>",
            method: "GET",
            data: {
                batchId: batchid,
                includeDeleted: true,
                _t: requestTime
            },
            dataType: "JSON",
            beforeSend: function(xhr) {
                pendingAjaxRequests.push(xhr);
            },
            success: function(response) {
                const index = pendingAjaxRequests.indexOf(xhr);
                if (index > -1) pendingAjaxRequests.splice(index, 1);
                if (window.lastBatchRequest[batchid] !== currentRequestId) {
                    return;
                }

                if (activeBatchId !== batchid) {
                    return;
                }

                let options = '<option value="">--Select--</option>';
                let hasData = false;

                if (response.success && response.data && response.data.length > 0) {

                    response.data.sort((a, b) => parseInt(b.value) - parseInt(a.value));

                    response.data.forEach(function(item) {
                        if (item.value && item.desc) {
                            options += `<option value="${item.value}"
            data-batchid="${batchid}"
            data-entrynumber="${item.desc}"
            data-deleted="${item.deleted || false}">
            ${item.desc}</option>`;
                            hasData = true;
                        }
                    });
                }

                $('#cb_batchentry')
                    .html(options)
                    .prop('disabled', false);

                disableSelect2('#cb_srcetype', true);

                let valueToSet = '';

                if (preserveCurrentValue && currentBatchEntry && currentBatchEntry !== '') {
                    if ($('#cb_batchentry option[value="' + currentBatchEntry + '"]').length > 0) {
                        valueToSet = currentBatchEntry;
                    }
                }

                if (!valueToSet) {
                    if ($('#cb_batchentry option[value="0000001"]').length > 0) {
                        valueToSet = '0000001';
                    }
                }

                if (valueToSet) {
                    $('#cb_batchentry').val(valueToSet);
                } else {
                    $('#cb_batchentry').val('');
                }

                $('#cb_batchentry').trigger('change');

                if (response.fscsYr && response.fscsPerd) {
                    $('#YearPeriod').val(formatYearPeriod(response.fscsYr, response.fscsPerd));
                }

                setTimeout(() => {
                    if (activeBatchId === batchid && window.lastBatchRequest[batchid] === currentRequestId) {
                        if (currentSrcetype) {
                            $('#cb_srcetype').val(currentSrcetype).trigger('change');
                            $('#cb_srcetype').prop('disabled', currentSrcetypeDisabled);
                        }

                        if (currentSrceDesc) {
                            $('#SrceDesc').val(currentSrceDesc);
                        }
                    }
                }, 300);

                setTimeout(() => {
                    if (activeBatchId === batchid && window.lastBatchRequest[batchid] === currentRequestId) {
                        updateAddOptionVisibility();
                    }
                }, 100);
            },
            error: function(xhr, status, error) {
                const index = pendingAjaxRequests.indexOf(xhr);
                if (index > -1) pendingAjaxRequests.splice(index, 1);

                if (status === 'abort') {
                    return;
                }

                if (window.lastBatchRequest[batchid] === currentRequestId && activeBatchId === batchid) {
                    const options = '<option value="">--Select--</option>';
                    $('#cb_batchentry')
                        .html(options)
                        .prop('disabled', false)
                        .val('')
                        .trigger('change');

                    $('#cb_srcetype')
                        .prop('disabled', true)
                        .css('background-color', '#e9ecef');

                    console.error('Error loading batch entries:', error);
                }
            },
            complete: function() {
                if (window.lastBatchRequest[batchid] === currentRequestId) {}
            }
        });
    }
</script>

<!-- ===================================================== -->
<!-- BAGIAN 5: FUNGSI ADD OPTION MANAGEMENT                -->
<!-- ===================================================== -->
<script>
    // =====================================================
    // 5.1 - TAMPILKAN OPSI --TAMBAH-- DI DROPDOWN
    // =====================================================
    function showAddOption() {
        if ($('#cb_batchentry option[value="__add__"]').length === 0) {
            const selectOption = $('#cb_batchentry option[value=""]');
            if (selectOption.length > 0) {
                $('<option value="__add__">--Tambah--</option>').insertAfter(selectOption);
            } else {
                $('#cb_batchentry').prepend('<option value="__add__">--Tambah--</option>');
            }
        }
    }

    // =====================================================
    // 5.2 - SEMBUNYIKAN OPSI --TAMBAH--
    // =====================================================
    function hideAddOption() {
        $('#cb_batchentry option[value="__add__"]').remove();
    }

    // =====================================================
    // 5.3 - UPDATE VISIBILITAS OPSI TAMBAH
    // =====================================================
    function updateAddOptionVisibility() {
        const batchId = $('#cb_batchid').find('option:selected').data('batchid');
        const batchEntry = $('#cb_batchentry').val();
        const batchStat = $('#cb_batchid').find('option:selected').data('batchstat');

        if (!batchId) {
            hideAddOption();
            return;
        }

        const isEntryDeleted = batchEntry && $(`#cb_batchentry option[value="${batchEntry}"]`).data('deleted');
        const isUserCreated = isUserCreatedBatchEntry(batchId, batchEntry);

        const shouldShowAddOption =
            (batchStat != "2" && batchStat != "4" && batchStat != "9") &&
            (!isEntryDeleted || isEntryDeleted === false) &&
            !isUserCreated;

        if (shouldShowAddOption) {
            showAddOption();
        } else {
            hideAddOption();
        }
    }
</script>

<!-- ===================================================== -->
<!-- BAGIAN 6: FUNGSI BUTTON DISABLE/ENABLE                -->
<!-- ===================================================== -->
<script>
    // =====================================================
    // 6.1 - NONAKTIFKAN SEMUA TOMBOL
    // =====================================================
    function disableAllButtons(allowImport = false) {
        $('#add_record, #btnQuickEntryMode, #saveToDatabase, #btnNormalModeModal, #btnQuickModeModal')
            .prop('disabled', true)
            .css({
                opacity: '0.6',
                cursor: 'not-allowed'
            })
            .hide();

        $('button[onclick="importFromExcel()"], button[onclick="validateAndSaveJournalEntry()"]')
            .prop('disabled', true)
            .css({
                opacity: '0.6',
                cursor: 'not-allowed'
            })
            .hide();

        $('.edit, .delete, .view')
            .prop('disabled', true)
            .css({
                opacity: '0.6',
                cursor: 'not-allowed'
            })
            .hide();

        $('#summarySection .btn-danger').hide();

        $('#cb_srcetype')
            .prop('disabled', true)
            .css({
                'background-color': '#e9ecef',
                'cursor': 'not-allowed',
                'pointer-events': 'none'
            });

        if ($('#cb_srcetype').hasClass('select2-hidden-accessible')) {
            $('#cb_srcetype').next('.select2-container').find('.select2-selection').css({
                'background-color': '#e9ecef',
                'border-color': '#ced4da',
                'cursor': 'not-allowed',
                'pointer-events': 'none'
            });
            $('#cb_srcetype').next('.select2-container').find('.select2-selection__arrow').hide();
        }

        $('#JrnlDesc')
            .prop('readonly', true)
            .css({
                'background-color': '#e9ecef',
                'cursor': 'not-allowed'
            });

        $('#DataEntry, #PostDate, #YearPeriod')
            .prop('disabled', true)
            .prop('readonly', true)
            .css({
                'background-color': '#e9ecef',
                'cursor': 'not-allowed',
                'pointer-events': 'none'
            });

        $('.input-group-append .input-group-text')
            .not('#btnSearchBatchEntry')
            .css({
                'pointer-events': 'none',
                'opacity': '0.6'
            });

        if (allowImport) {
            $('button[onclick="importFromExcel()"]')
                .prop('disabled', false)
                .css({
                    opacity: '',
                    cursor: ''
                })
                .show();
        }
    }

    // =====================================================
    // 6.2 - AKTIFKAN KEMBALI SEMUA BUTTIN
    // =====================================================
    function enableAllButtons() {
        $('#add_record, #btnQuickEntryMode, #saveToDatabase, #btnNormalModeModal, #btnQuickModeModal')
            .prop('disabled', false)
            .css({
                opacity: '',
                cursor: ''
            })
            .show();

        $('button[onclick="importFromExcel()"], button[onclick="validateAndSaveJournalEntry()"]')
            .prop('disabled', false)
            .css({
                opacity: '',
                cursor: ''
            })
            .show();

        $('.edit, .delete, .view')
            .prop('disabled', false)
            .css({
                opacity: '',
                cursor: ''
            })
            .removeAttr('title')
            .show();

        $('#summarySection .btn-danger').show();

        const batchEntry = $('#cb_batchentry').val();
        const isEditable = batchEntry && batchEntry !== '__add__';

        $('#cb_srcetype')
            .prop('disabled', !isEditable)
            .css({
                'background-color': '',
                'cursor': ''
            });

        $('#JrnlDesc')
            .prop('readonly', !isEditable)
            .css({
                'background-color': '',
                'cursor': ''
            });

        $('#DataEntry, #PostDate')
            .prop('disabled', !isEditable)
            .prop('readonly', !isEditable)
            .css({
                'background-color': '',
                'cursor': '',
                'pointer-events': isEditable ? '' : 'none'
            });

        $('#YearPeriod')
            .prop('disabled', !isEditable)
            .prop('readonly', !isEditable)
            .css({
                'background-color': '',
                'cursor': isEditable ? 'pointer' : 'not-allowed',
                'pointer-events': isEditable ? '' : 'none'
            });

        if (isEditable) {
            $('#YearPeriod').off('click').on('click', () => $('#modalFiscalCalender').modal('show'));
            $('.btn-modal-fiscal').off('click').on('click', (e) => {
                e.preventDefault();
                $('#modalFiscalCalender').modal('show');
            });
        }
    }

    // =====================================================
    // 6.3 - CEK STATUS BATCH DAN NONAKTIFKAN TOMBOL
    // =====================================================
    function checkBatchStatusAndDisableButtons(batchId) {
        if (!batchId) {
            enableAllButtons();
            $("#btnReverseBatchEntry").addClass("d-none");
            return;
        }

        const selectedBatch = $(`#cb_batchid option[data-batchid="${batchId}"]`);
        if (selectedBatch.length > 0) {
            const batchStat = selectedBatch.data('batchstat');
            const selectedEntry = $('#cb_batchentry').find('option:selected');
            const isEntryDeleted = selectedEntry.data('deleted');

            if (isEntryDeleted === true || isEntryDeleted === 'true') {
                disableAllButtons(false);
                $("#btnReverseBatchEntry").addClass("d-none");
            } else if (batchStat == '2' || batchStat == 2 || batchStat == '4' || batchStat == 4 || batchStat == '9' || batchStat == 9) {
                const shouldAllowImport = (typeof allowimport !== 'undefined' && allowimport === true);
                disableAllButtons(shouldAllowImport);

                $('#cb_srcetype')
                    .prop('disabled', true)
                    .css({
                        'background-color': '#e9ecef',
                        'pointer-events': 'none'
                    });

                if (batchStat == '4' || batchStat == 4) {
                    $("#btnReverseBatchEntry").removeClass("d-none");
                } else {
                    $("#btnReverseBatchEntry").addClass("d-none");
                }
            } else {
                enableAllButtons();
                $("#btnReverseBatchEntry").addClass("d-none");
            }
        }
    }

    // =====================================================
    // 6.4 - CEK STATUS BATCH UNTUK SEMUA TOMBOL
    // =====================================================
    function checkBatchStatForButtons() {
        const batchStat = $('#cb_batchid').find('option:selected').data('batchstat');

        if (batchStat === '2' || batchStat === 2 || batchStat === '4' || batchStat === 4 || batchStat === '9' || batchStat === 9) {
            disableAllButtons();
        } else {
            enableAllButtons();
        }
    }
    // =====================================================
    // 6.5 - CEK STATUS DELETED BATCH ENTRY
    // =====================================================
    function checkBatchEntryDeletedStatus() {
        const selected = $('#cb_batchentry').find('option:selected');
        const isDeleted = selected.data('deleted');
        const batchId = $('#cb_batchid').find('option:selected').data('batchid');
        const batchEntry = selected.val();
        const batchStat = $('#cb_batchid').find('option:selected').data('batchstat');

        if (batchEntry && batchEntry !== '__add__') {
            if (isDeleted === true || isDeleted === 'true') {
                $('#BatchEntryDeletedBadge')
                    .text('Deleted')
                    .css({
                        'background': '#dc3545',
                        'color': '#fff',
                        'padding': '4px 8px',
                        'border-radius': '3px',
                        'font-weight': 'bold'
                    })
                    .show();

                disableAllButtons();

                $('#gljournallistTable th:contains("Aksi")').hide();
                $('#gljournallistTable td:nth-child(15)').hide();

                showAddOption();
            } else {
                if (batchStat === '2' || batchStat === 2 || batchStat === '4' || batchStat === 4 || batchStat === '9' || batchStat === 9) {
                    disableAllButtons();
                    $('#gljournallistTable th:contains("Aksi")').hide();
                    $('#gljournallistTable td:nth-child(15)').hide();
                    hideAddOption();
                } else {
                    enableAllButtons();
                    $('#gljournallistTable th:contains("Aksi")').show();
                    $('#gljournallistTable td:nth-child(15)').show();
                    showAddOption();
                }

                $('#BatchEntryDeletedBadge').hide();
            }
        } else {
            if (batchStat === '2' || batchStat === 2 || batchStat === '4' || batchStat === 4 || batchStat === '9' || batchStat === 9) {
                disableAllButtons();
                $('#gljournallistTable th:contains("Aksi")').hide();
                $('#gljournallistTable td:nth-child(15)').hide();
                hideAddOption();
            } else {
                enableAllButtons();
                const hasData = $('#gljournallistTable tbody tr').length > 0;
                if (hasData) {
                    $('#gljournallistTable th:contains("Aksi")').show();
                    $('#gljournallistTable td:nth-child(15)').show();
                } else {
                    $('#gljournallistTable th:contains("Aksi")').hide();
                    $('#gljournallistTable td:nth-child(15)').hide();
                }
                showAddOption();
            }
            $('#BatchEntryDeletedBadge').hide();
        }
    }

    // =====================================================
    // 6.6 - TOGGLE HEADER AKSI DI TABEL
    // =====================================================
    function toggleActionHeader() {
        const batchStat = $('#cb_batchid').find('option:selected').data('batchstat');
        const selectedEntry = $('#cb_batchentry').find('option:selected');
        const isEntryDeleted = selectedEntry.data('deleted');

        const shouldHide = (batchStat == "2" || batchStat == "4" || batchStat == "9") ||
            (isEntryDeleted === true || isEntryDeleted === 'true');

        $('#gljournallistTable th:contains("Aksi")').toggle(!shouldHide);
        $('#gljournallistTable td:nth-child(15)').toggle(!shouldHide);
    }
</script>

<!-- ===================================================== -->
<!-- BAGIAN 7: FUNGSI SOURCE LEDGER MANAGEMENT             -->
<!-- ===================================================== -->
<script>
    // =====================================================
    // 7.1 - SETTING DISABLED DROPDOWN SELECT
    // =====================================================
    function disableSelect2(selector, disable = true) {
        $(selector).prop('disabled', disable);
        if ($(selector).hasClass('select2-hidden-accessible')) {
            const $container = $(selector).next('.select2-container');
            if (disable) {
                $container.find('.select2-selection').css({
                    'background-color': '#e9ecef',
                    'border-color': '#ced4da',
                    'cursor': 'not-allowed',
                    'pointer-events': 'none'
                });
                $container.find('.select2-selection__rendered').css({
                    'color': '#6c757d'
                });
                $container.find('.select2-selection__arrow').hide();
            } else {
                $container.find('.select2-selection').css({
                    'background-color': '',
                    'border-color': '',
                    'cursor': '',
                    'pointer-events': ''
                });
                $container.find('.select2-selection__rendered').css({
                    'color': ''
                });
                $container.find('.select2-selection__arrow').show();
            }
        }
    }

    // =====================================================
    // 7.2 - NONAKTIFKAN SOURCE LEDGER
    // =====================================================
    function disableSourceLedger() {
        $('#cb_srceledger')
            .prop('disabled', true)
            .attr('readonly', 'readonly')
            .css({
                'background-color': '#e9ecef',
                'cursor': 'not-allowed'
            });
    }

    // =====================================================
    // 7.3 - AKTIFKAN SOURCE LEDGER (JIKA KOSONG)
    // =====================================================
    function enableSourceLedger() {
        if (!$('#cb_srceledger').val()) {
            $('#cb_srceledger')
                .prop('disabled', false)
                .removeAttr('readonly')
                .css({
                    'background-color': '',
                    'cursor': ''
                });
        }
    }

    // =====================================================
    // 7.4 - CEK DAN NONAKTIFKAN SOURCE LEDGER
    // =====================================================
    function checkAndDisableSourceLedger() {
        if ($('#cb_srceledger').val()) {
            disableSourceLedger();
        } else {
            enableSourceLedger();
        }
    }

    // =====================================================
    // 7.5 - SET SOURCE LEDGER DARI BATCH YANG DIPILIH
    // =====================================================
    function setSourceLedgerFromBatch(selectedBatch) {
        const srceledger = selectedBatch.data('srcledgr');

        if (srceledger) {
            $('#cb_srceledger').val(srceledger).trigger('change');
            disableSourceLedger();

            $('#SrceDesc').val('');
        }
    }

    // =====================================================
    // 7.6 - SET SOURCE DESCRIPTION DARI BATCH
    // =====================================================
    function setSourceDescriptionFromBatch(selected) {
        const srcedesc = selected.data('srcedesc');
        const srceledger = selected.data('srceledgr');
        const srcetype = selected.data('srcetype');

        if (srceledger) {
            $('#cb_srceledger').val(srceledger);
            setTimeout(() => $('#cb_srceledger').trigger('change'), 100);
        }

        if (srceledger && srcetype) {
            getSrceDescription(srceledger, srcetype, function(srceDesc) {
                if (srceDesc) $('#SrceDesc').val(srceDesc);
            });
        }
    }

    // =====================================================
    // 7.7 - AMBIL SOURCE TYPE DARI LEDGER
    // =====================================================
    function loadSourceType(srceLedger) {
        const currentSrcetype = $('#cb_batchid').find('option:selected').data('srcetype');

        if (window.activeSourceTypeRequest) {
            window.activeSourceTypeRequest.abort();
        }

        window.activeSourceTypeRequest = $.ajax({
            url: "<?= site_url('tmstgljournal/getSourceType') ?>",
            method: "GET",
            data: {
                srceLedger: srceLedger,
                _t: Date.now()
            },
            dataType: "JSON",
            success: function(response) {
                window.activeSourceTypeRequest = null;

                const currentLedger = $('#cb_srceledger').val();
                if (currentLedger !== srceLedger) {
                    return;
                }

                let options = '<option value="">--Select--</option>';

                if (response.success && response.data && response.data.length > 0) {
                    response.data.forEach(function(item) {
                        const value = item.value || item.SrceType || item.srceType || item.code;
                        const desc = item.desc || item.SrceType || item.srceType || item.description || item.name || value;

                        if (value && desc) {
                            options += `<option value="${value}">${desc}</option>`;
                        }
                    });

                    $('#cb_srcetype')
                        .html(options)
                        .prop('disabled', true);

                    if (currentSrcetype) {
                        $('#cb_srcetype').val(currentSrcetype).trigger('change');
                    }

                } else {
                    $('#cb_srcetype')
                        .html('<option value="">No data available</option>')
                        .prop('disabled', true);
                }
            },
            error: function(xhr, status, error) {
                window.activeSourceTypeRequest = null;
                if (status !== 'abort') {
                    $('#cb_srcetype')
                        .html('<option value="">Error loading data</option>')
                        .prop('disabled', true);
                }
            }
        });
    }

    // =====================================================
    // 7.8 - RESET SOURCE FIELDS
    // =====================================================
    function resetSourceFields() {
        const batchEntry = $('#cb_batchentry').val();
        const batchId = $('#cb_batchid').find('option:selected').data('batchid');

        if (batchId && batchEntry && batchEntry !== '' && batchEntry !== '__add__') {
            return;
        }

        $('#cb_srcetype').val('').trigger('change');

        checkAndDisableSourceLedger();
    }

    // =====================================================
    // 7.9 - RESET SOURCE TYPE UNTUK ENTRY BARU
    // =====================================================
    function resetSourceTypeForNewEntry() {
        const batchId = $('#cb_batchid').find('option:selected').data('batchid');
        const batchEntry = $('#cb_batchentry').val();

        if (isUserCreatedBatchEntry(batchId, batchEntry)) {
            $('#cb_srcetype').val('').trigger('change');
            $('#cb_srcetype')
                .prop('disabled', false)
                .css('background-color', '');
        }
    }

    // =====================================================
    // 7.10 - DAPATKAN DESKRIPSI SOURCE
    // =====================================================
    function getSrceDescription(srceLedger, srceType, callback) {
        if (!srceLedger || !srceType) {
            callback('');
            return;
        }

        cancelActiveSrceDescRequest();

        activeSrceDescBatch = srceLedger;
        activeSrceDescType = srceType;

        activeSrceDescRequest = $.ajax({
            url: "<?= site_url('tmstgljournal/getSrceDesc') ?>",
            method: "GET",
            data: {
                SrceLedger: srceLedger,
                SrceType: srceType,
                _t: Date.now()
            },
            dataType: "JSON",
            success: function(response) {
                if (activeSrceDescBatch === srceLedger && activeSrceDescType === srceType) {
                    if (response.success && response.data && response.data.srceDesc) {
                        callback(response.data.srceDesc);
                    } else {
                        callback('');
                    }
                } else {}
                activeSrceDescRequest = null;
            },
            error: function(xhr, status, error) {
                if (status !== 'abort') {
                    callback('');
                }
                activeSrceDescRequest = null;
            }
        });
    }
</script>

<!-- ===================================================== -->
<!-- BAGIAN 8: FUNGSI DATE MANAGEMENT                      -->
<!-- ===================================================== -->
<script>
    // =====================================================
    // 8.1 - TOGGLE FIELD TANGGAL (ENABLE/DISABLE)
    // =====================================================
    function toggleDateFields(enabled) {
        $('#DataEntry, #PostDate, #YearPeriod').prop('disabled', !enabled);

        if (!enabled) {
            $('#DataEntry, #PostDate, #YearPeriod').val('');
        }
    }

    // =====================================================
    // 8.2 - HANDLE KONDISI ENTRY BARU
    // =====================================================
    function handleNewEntryConditions() {
        isPostDateManuallyEdited = false;
        isRateDateManuallyEdited = false;
        isNewEntry = true;

        $('#DataEntry, #PostDate, #YearPeriod').prop('disabled', false);
        resetHeaderFieldsForNewEntry();
        updateRateDateFromDataEntry();
    }

    // =====================================================
    // 8.3 - HANDLE KONDISI EXISTING ENTRY
    // =====================================================
    function handleExistingEntryConditions() {
        isNewEntry = false;
    }

    // =====================================================
    // 8.4 - UPDATE RATE DATE DARI DATA ENTRY
    // =====================================================
    function updateRateDateFromDataEntry() {
        if ((isNewEntry || currentEntryMode === 'normal') && !isRateDateManuallyEdited) {
            const dataEntryValue = $('#DataEntry').val();
            if (dataEntryValue) {
                $('#modalform #RateDate').val(dataEntryValue);
                $('#RateDate').val(dataEntryValue);
            }
        }
    }

    // =====================================================
    // 8.5 - UPDATE POST DATE DARI DATA ENTRY
    // =====================================================
    function updatePostDateFromDataEntry() {
        if (isNewEntry && !isPostDateManuallyEdited) {
            const dataEntryValue = $('#DataEntry').val();
            if (dataEntryValue) {
                $('#PostDate').val(dataEntryValue);
            }
        }
    }

    // =====================================================
    // 8.6 - UPDATE TANGGAL DARI BATCH ENTRY
    // =====================================================
    function updateDatesFromBatchEntry() {
        const batchid = $('#cb_batchid').find('option:selected').data('batchid');
        const batchentry = $('#cb_batchentry').val();

        if (!batchid || !batchentry) return;

        const tableData = table.rows().data();
        if (tableData.length > 0) {
            const firstRow = tableData[0];

            if (firstRow.jrnlDesc) $('#JrnlDesc').val(firstRow.jrnlDesc);

            if (firstRow.dateEntry) {
                $('#DataEntry').val(formatDateYYYYMMDD(firstRow.dateEntry));
            }
            if (firstRow.postDate) {
                $('#PostDate').val(formatDateYYYYMMDD(firstRow.postDate));
            }
            if (firstRow.fscsYr && firstRow.fscsPerd) {
                $('#YearPeriod').val(formatYearPeriod(firstRow.fscsYr, firstRow.fscsPerd));
            }
            if (firstRow.srceLedger) $('#cb_srceledger').val(firstRow.srceLedger).trigger('change');
            if (firstRow.srceType) $('#cb_srcetype').val(firstRow.srceType).trigger('change');
        }
    }
</script>

<!-- ===================================================== -->
<!-- BAGIAN 9: FUNGSI HEADER FIELDS MANAGEMENT             -->
<!-- ===================================================== -->
<script>
    // =====================================================
    // 9.1 - RESET SEMUA FIELD HEADER
    // =====================================================
    function resetHeaderFields() {
        $('#JrnlDesc, #DataEntry, #PostDate, #YearPeriod').val('');

        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const dd = String(today.getDate()).padStart(2, '0');
        const todayFormatted = `${yyyy}-${mm}-${dd}`;

        $('#DataEntry, #PostDate, #RateDate').val(todayFormatted);
    }

    // =====================================================
    // 9.2 - RESET HEADER UNTUK ENTRY BARU
    // =====================================================
    function resetHeaderFieldsForNewEntry() {
        resetHeaderFields();
        isPostDateManuallyEdited = false;
        isRateDateManuallyEdited = false;
        $('#CreateJournalBy, #JrnlDesc').val('');
        $('#JrnlDesc').prop('readonly', false);
        $('#BatchEntryDeletedBadge').hide();
        resetSourceTypeForNewEntry();
        checkAndDisableSourceLedger();
    }

    // =====================================================
    // 9.3 - UPDATE HEADER DARI DATA
    // =====================================================
    function updateHeaderFieldsFromData(data) {
        if (data.dateEntry) $('#DataEntry').val(formatDateYYYYMMDD(data.dateEntry));
        if (data.postDate) $('#PostDate').val(formatDateYYYYMMDD(data.postDate));
        if (data.jrnlDesc) $('#JrnlDesc').val(data.jrnlDesc);
        if (data.fscsYr && data.fscsPerd) {
            $('#YearPeriod').val(formatYearPeriod(data.fscsYr, data.fscsPerd));
        }
        if (data.rateDate) {
            $('#RateDate').val(formatDateYYYYMMDD(data.rateDate));
        } else if (data.dateEntry) {
            $('#RateDate').val(formatDateYYYYMMDD(data.dateEntry));
        }
    }

    // =====================================================
    // 9.4 - UPDATE CREATE JOURNAL BY DARI BATCH ENTRY
    // =====================================================
    function updateCreateJournalByFromBatchEntry(batchId, batchEntry) {
        $('#CreateJournalBy').val('');

        if (isUserCreatedBatchEntry(batchId, batchEntry)) {
            return;
        }

        setTimeout(() => {
            const tableData = table.rows().data();
            if (tableData.length > 0) {
                const firstRow = tableData[0];
                if (firstRow.audtUser) {
                    $('#CreateJournalBy').val(firstRow.audtUser);
                }
            } else {
                const batchOption = $('#cb_batchid option:selected');
                const batchAudtUser = batchOption.data('audtuser');
                if (batchAudtUser) {
                    $('#CreateJournalBy').val(batchAudtUser);
                }
            }
        }, 500);
    }
</script>

<!-- ===================================================== -->
<!-- BAGIAN 10: FUNGSI FORM MANAGEMENT                     -->
<!-- ===================================================== -->
<script>
    // =====================================================
    // 10.1 - RESET FORM KE STATE AWAL
    // =====================================================
    function resetFormToInitialState() {
        $('#data_form')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
        $('[class^="error"]').html('');

        $('#ScurnAmtDebit, #ScurnAmtCredit, #TransAmtDebit, #TransAmtCredit').off();

        $('#LineNumber, #TransRef, #AcctId, #TransDesc, #AcctName, #RateDate, #ConvRate, #ScurnAmtDebit, #ScurnAmtCredit, #TransAmtDebit, #TransAmtCredit, #Comment, #HcurnCode')
            .prop('disabled', false)
            .prop('readonly', function() {
                return ['LineNumber', 'AcctId', 'AcctName', 'ConvRate'].includes(this.id);
            });

        $('#cb_scurncode')
            .prop('disabled', false)
            .val('')
            .trigger('change');
        $('#cb_scurncode').next('.select2-container').find('.select2-selection').css({
            'background-color': '',
            'opacity': ''
        });

        $('#btnSearchAccount').prop('disabled', false).show();
        $('#btnNormalModeModal, #btnQuickModeModal').css('visibility', 'visible').show();
        $('.modal-footer').show();

        $('#AudtUser, #AudtTime, #hidden_id').val('');
        $('#action').val('Add');

        $('.modal-title').text('Tambah Journal Entry');

        updateLockState();

        $('#amountValidationAlert').hide();
        $('#amountValidationMessage').text('');

        setTimeout(setupAmountSync, 100);
    }
    // =====================================================
    // 10.2 - SET DATA KE FORM
    // =====================================================
    function setFormData(data, isEdit = false, isView = false, isSoftEdit = false) {
        resetFormToInitialState();

        $('#LineNumber').val(data.transNbr || data.TransNbr || data.LineNumber || '');
        $('#AcctId').val(data.acctId || data.AcctId || '');
        $('#AcctName').val(data.acctName || data.AcctName || '');
        $('#ConvRate').val(data.convRate || data.ConvRate || 1);

        $('#TransRef').val(data.transRef || data.TransRef || '');
        $('#TransDesc').val(data.transDesc || data.TransDesc || '');

        let scurnCode = data.scurnCode || data.ScurnCode || data.ScurnCode;
        if (scurnCode) {
            $('#cb_scurncode').val(scurnCode).trigger('change');
            $('#ScurnCode').val(scurnCode);
        }

        if (data.rateDate || data.RateDate) {
            $('#RateDate').val(formatDateYYYYMMDD(data.rateDate || data.RateDate));
        } else {
            $('#RateDate').val('');
        }

        if (isSoftEdit) {
            $('#ScurnAmtDebit').val(data.ScurnAmtDebit || data.scurnAmtDebit || '');
            $('#ScurnAmtCredit').val(data.ScurnAmtCredit || data.scurnAmtCredit || '');
            $('#TransAmtDebit').val(data.TransAmtDebit || data.transAmtDebit || '');
            $('#TransAmtCredit').val(data.TransAmtCredit || data.transAmtCredit || '');
        } else {
            const scurnAmt = parseFloat(data.scurnAmt || data.ScurnAmt) || 0;
            const transAmt = parseFloat(data.transAmt || data.TransAmt) || 0;

            $('#ScurnAmtDebit').val(scurnAmt > 0 ? scurnAmt.toString() : '');
            $('#ScurnAmtCredit').val(scurnAmt < 0 ? Math.abs(scurnAmt).toString() : '');
            $('#TransAmtDebit').val(transAmt > 0 ? transAmt.toString() : '');
            $('#TransAmtCredit').val(transAmt < 0 ? Math.abs(transAmt).toString() : '');
        }

        $('#Comment').val(data.comment || data.Comment || '');
        $('#HcurnCode').val(data.hcurnCode || data.HcurnCode || '');

        if (data.AudtUser) $('#AudtUser').val(data.AudtUser);
        if (data.AudtTime) $('#AudtTime').val(data.AudtTime);

        if (isView) {
            setViewMode();
        } else if (isEdit) {
            setEditMode();
        }

        updateLockState();
    }

    // =====================================================
    // 10.3 - SET MODE EDIT
    // =====================================================
    function setEditMode() {
        $('#LineNumber, #AcctId, #AcctName, #ConvRate')
            .prop('disabled', false)
            .prop('readonly', true);

        $('#TransRef, #TransDesc, #RateDate, #ScurnAmtDebit, #ScurnAmtCredit, #TransAmtDebit, #TransAmtCredit, #Comment, #HcurnCode')
            .prop('disabled', false);

        $('#cb_scurncode, #ScurnCode').prop('disabled', false);

        $('#btnSearchAccount').prop('disabled', false).show();
        $('#btnNormalModeModal, #btnQuickModeModal').css('visibility', 'hidden');
        $('.modal-footer').show();

        $('#AudtUser, #AudtTime').prop('disabled', true);

        $('#cb_scurncode').next('.select2-container').find('.select2-selection').css({
            'background-color': '',
            'opacity': ''
        });

        $('#submit_button').val('Simpan').html('Simpan').show();
    }

    // =====================================================
    // 10.4 - SET MODE VIEW
    // =====================================================
    function setViewMode() {
        $('#LineNumber, #TransRef, #AcctId, #TransDesc, #AcctName, #RateDate, #ConvRate, #ScurnAmtDebit, #ScurnAmtCredit, #TransAmtDebit, #TransAmtCredit, #Comment, #HcurnCode, #ScurnCode')
            .prop('disabled', true);

        $('#cb_scurncode, #AudtUser, #AudtTime').prop('disabled', true);

        $('#btnSearchAccount').prop('disabled', true).hide();
        $('#btnNormalModeModal, #btnQuickModeModal').css('visibility', 'hidden');
        $('.modal-footer').hide();

        $('#cb_scurncode').next('.select2-container').find('.select2-selection').css({
            'background-color': '#e9ecef',
            'opacity': 1
        });
    }

    // =====================================================
    // 10.5 - UPDATE LOCK STATE DEBIT/CREDIT
    // =====================================================
    function updateLockState() {
        const debitSource = $('#ScurnAmtDebit');
        const debitFunctional = $('#TransAmtDebit');
        const creditSource = $('#ScurnAmtCredit');
        const creditFunctional = $('#TransAmtCredit');

        if (debitSource.length && !debitSource.prop('disabled')) {
            const debitFilled = debitSource.val().trim() !== '' || (debitFunctional.length && debitFunctional.val().trim() !== '');
            const creditFilled = creditSource.val().trim() !== '' || (creditFunctional.length && creditFunctional.val().trim() !== '');

            const lockDebit = creditFilled;
            const lockCredit = debitFilled;

            debitSource.prop('readonly', lockDebit);
            if (debitFunctional.length) debitFunctional.prop('readonly', lockDebit);

            creditSource.prop('readonly', lockCredit);
            if (creditFunctional.length) creditFunctional.prop('readonly', lockCredit);
        }
    }

    // =====================================================
    // 10.6 - SETUP SYNC AMOUNT FIELDS
    // =====================================================
    function setupAmountSync() {
        const debitSource = $('#ScurnAmtDebit');
        const debitFunctional = $('#TransAmtDebit');
        const creditSource = $('#ScurnAmtCredit');
        const creditFunctional = $('#TransAmtCredit');

        debitSource.off();
        creditSource.off();
        debitFunctional.off();
        creditFunctional.off();

        debitSource.on('input', function() {
            const val = parseFloat($(this).val());
            debitFunctional.val(isNaN(val) ? '' : val);
            updateLockState();
        });

        creditSource.on('input', function() {
            const val = parseFloat($(this).val());
            creditFunctional.val(isNaN(val) ? '' : val);
            updateLockState();
        });

        debitFunctional.on('input', updateLockState);
        creditFunctional.on('input', updateLockState);

    }

    // =====================================================
    // 10.7 - AUTO LOCK AMOUNT FIELDS BERDASARKAN DATA
    // =====================================================
    function autoLockAmountFieldsBasedOnData(data) {
        const scurnAmtDebit = $('#ScurnAmtDebit');
        const scurnAmtCredit = $('#ScurnAmtCredit');
        const transAmtDebit = $('#TransAmtDebit');
        const transAmtCredit = $('#TransAmtCredit');

        scurnAmtDebit.prop('readonly', false);
        scurnAmtCredit.prop('readonly', false);
        transAmtDebit.prop('readonly', false);
        transAmtCredit.prop('readonly', false);

        const hasDebitData = (data.scurnAmtDebit && parseFloat(data.scurnAmtDebit) > 0) ||
            (data.transAmtDebit && parseFloat(data.transAmtDebit) > 0);

        const hasCreditData = (data.scurnAmtCredit && parseFloat(data.scurnAmtCredit) > 0) ||
            (data.transAmtCredit && parseFloat(data.transAmtCredit) > 0);

        if (hasDebitData) {
            scurnAmtCredit.prop('readonly', true);
            transAmtCredit.prop('readonly', true);
        }

        if (hasCreditData) {
            scurnAmtDebit.prop('readonly', true);
            transAmtDebit.prop('readonly', true);
        }
    }

    // =====================================================
    // 10.8 - SETUP LOCK HANDLER UNTUK QUICK ENTRY
    // =====================================================
    function setupQuickEntryLockHandlers() {
        const debitSource = $('#ScurnAmtDebit');
        const debitFunctional = $('#TransAmtDebit');
        const creditSource = $('#ScurnAmtCredit');
        const creditFunctional = $('#TransAmtCredit');

        debitSource.off('input.quickEntryLock');
        creditSource.off('input.quickEntryLock');

        debitSource.on('input.quickEntryLock', function() {
            if (currentEntryMode === 'quick' && $(this).val().trim() !== '') {
                creditSource.prop('readonly', true);
                creditFunctional.prop('readonly', true);
            } else if (currentEntryMode === 'quick' && $(this).val().trim() === '') {
                creditSource.prop('readonly', false);
                creditFunctional.prop('readonly', false);
            }
        });

        creditSource.on('input.quickEntryLock', function() {
            if (currentEntryMode === 'quick' && $(this).val().trim() !== '') {
                debitSource.prop('readonly', true);
                debitFunctional.prop('readonly', true);
            } else if (currentEntryMode === 'quick' && $(this).val().trim() === '') {
                debitSource.prop('readonly', false);
                debitFunctional.prop('readonly', false);
            }
        });
    }

    // =====================================================
    // 10.9 - RESET FORM
    // =====================================================
    function resetForm() {
        $('#data_form')[0].reset();
        editIndex = null;
        $('.modal-title').text('Tambah Journal Entry');
        $('#LineNumber').val('');

        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const dd = String(today.getDate()).padStart(2, '0');
        const todayFormatted = `${yyyy}-${mm}-${dd}`;

        isNewEntry = true;
        isRateDateManuallyEdited = false;
        currentEntryMode = 'normal';

        const dataEntryValue = $('#DataEntry').val();
        $('#RateDate').val(dataEntryValue || todayFormatted);

        $('#cb_scurncode').val('').trigger('change');
        $('#AudtTime').val('');
        $('#AudtUser').val(userId);
        savedFormData = null;

        const saveButton = $('#modalform').find('button[onclick="validateAndSaveJournalEntry()"]');
        saveButton.prop('disabled', false).html('Simpan');
    }
</script>

<!-- ===================================================== -->
<!-- BAGIAN 11: FUNGSI VALIDASI                            -->
<!-- ===================================================== -->
<script>
    // =====================================================
    // 11.1 - RESET VALIDASI FORM
    // =====================================================
    function resetValidation() {
        const form = document.getElementById('data_form');
        if (form) form.classList.remove('was-validated');

        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').hide();

        $('#amountValidationAlert')
            .hide()
            .removeClass('alert-danger')
            .addClass('alert-warning');
        $('#amountValidationMessage').text('');

        $('.select2-selection').removeClass('is-invalid');
    }

    // =====================================================
    // 11.2 - VALIDASI AMOUNT
    // =====================================================
    function validateAmounts() {
        const scurnAmtDebit = parseFloat($('#ScurnAmtDebit').val()) || 0;
        const scurnAmtCredit = parseFloat($('#ScurnAmtCredit').val()) || 0;
        const transAmtDebit = parseFloat($('#TransAmtDebit').val()) || 0;
        const transAmtCredit = parseFloat($('#TransAmtCredit').val()) || 0;

        $('#amountValidationAlert').hide();

        if (scurnAmtDebit === 0 && scurnAmtCredit === 0 &&
            transAmtDebit === 0 && transAmtCredit === 0) {
            $('#amountValidationAlert').show();
            $('#amountValidationMessage').text('Salah satu amount debit atau credit harus diisi');
            return false;
        }

        if ((scurnAmtDebit > 0 && scurnAmtCredit > 0) ||
            (transAmtDebit > 0 && transAmtCredit > 0)) {
            $('#amountValidationAlert').show();
            $('#amountValidationMessage').text('Tidak boleh mengisi debit dan credit secara bersamaan');
            return false;
        }

        return true;
    }

    // =====================================================
    // 11.3 - VALIDASI FORM JOURNAL ENTRY
    // =====================================================
    function validateJournalEntryForm() {
        let isValid = true;
        resetValidation();

        const requiredFields = ['TransRef', 'TransDesc', 'AcctId', 'AcctName', 'ConvRate'];

        requiredFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            }
        });

        const scurnCode = $('#cb_scurncode').val();
        if (!scurnCode) {
            $('#cb_scurncode').addClass('is-invalid');
            isValid = false;
        }

        if (!validateAmounts()) {
            isValid = false;
        }

        return isValid;
    }

    // =====================================================
    // 11.4 - VALIDASI TANGGAL
    // =====================================================
    function isValidDate(dateString) {
        const regex = /^\d{2}\/\d{2}\/\d{4}$/;
        if (!regex.test(dateString)) return false;

        const parts = dateString.split('/');
        const day = parseInt(parts[0], 10);
        const month = parseInt(parts[1], 10);
        const year = parseInt(parts[2], 10);

        if (year < 1000 || year > 3000 || month === 0 || month > 12) return false;

        const monthLength = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

        if (year % 400 === 0 || (year % 100 !== 0 && year % 4 === 0)) {
            monthLength[1] = 29;
        }

        return day > 0 && day <= monthLength[month - 1];
    }

    // =====================================================
    // 11.5 - TAMPILKAN ERROR VALIDASI
    // =====================================================
    function showValidationErrors(errors) {
        const fields = ['SrceLedger', 'SrceType', 'SrceDesc'];
        fields.forEach(function(field) {
            if (errors[field]) {
                $('#' + field).addClass('is-invalid');
                $('.error' + capitalize(field)).html(errors[field]);
            } else {
                $('#' + field).removeClass('is-invalid');
                $('.error' + capitalize(field)).html('');
            }
        });
    }

    // =====================================================
    // 11.6 - HAPUS VALIDASI FORM
    // =====================================================
    function clearFormValidation() {
        const fields = ['SrceLedger', 'SrceType', 'SrceDesc'];
        fields.forEach(function(field) {
            $('#' + field).removeClass('is-invalid');
            $('.error' + capitalize(field)).html('');
        });
    }
</script>

<!-- ===================================================== -->
<!-- BAGIAN 12: FUNGSI SOFT DELETE                         -->
<!-- ===================================================== -->
<script>
    // =====================================================
    // 12.1 - EKSTRAK DATA DARI ROW TABEL
    // =====================================================
    function extractRowData(rowElement) {
        const row = $(rowElement);
        return {
            TransRef: row.find('td:eq(2)').text().trim(),
            TransDesc: row.find('td:eq(3)').text().trim(),
            AcctId: row.find('td:eq(4)').text().trim(),
            AcctName: row.find('td:eq(5)').text().trim(),
            ScurnCode: row.find('td:eq(6)').text().trim(),
            ScurnAmtDebit: parseFloat(row.find('td:eq(7)').text().replace(/[^\d.-]/g, '')) || 0,
            ScurnAmtCredit: parseFloat(row.find('td:eq(8)').text().replace(/[^\d.-]/g, '')) || 0,
            ConvRate: parseFloat(row.find('td:eq(9)').text().replace(/[^\d.-]/g, '')) || 0,
            RateDate: row.find('td:eq(10)').text().trim(),
            TransAmtDebit: parseFloat(row.find('td:eq(11)').text().replace(/[^\d.-]/g, '')) || 0,
            TransAmtCredit: parseFloat(row.find('td:eq(12)').text().replace(/[^\d.-]/g, '')) || 0,
            Comment: row.find('td:eq(13)').text().trim()
        };
    }

    // =====================================================
    // 12.2 - TAMPILKAN PESAN SUKSES DELETE
    // =====================================================
    function showDeleteSuccessMessage() {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'Data berhasil dihapus dari tampilan. Klik "Save" buat nyimpen perubahan permanen.',
            confirmButtonText: 'OK'
        });
    }

    // =====================================================
    // 12.3 - SOFT DELETE JOURNAL ENTRY
    // =====================================================
    window.softDeleteJournalEntry = function(localId = null, batchId = null, batchEntry = null, transNbr = null, element = null) {
        const isLocalData = localId !== null;

        Swal.fire({
            icon: 'warning',
            title: 'Hapus Data Sementara',
            text: 'Data akan terhapus',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6'
        }).then((result) => {
            if (result.isConfirmed) {
                try {
                    let deletedEntry;
                    let targetRow;

                    if (isLocalData) {
                        const entryIndex = journalEntries.findIndex(entry => entry.localId === localId);

                        if (entryIndex === -1) {
                            throw new Error('Data lokal ga ketemu');
                        }

                        deletedEntry = journalEntries[entryIndex];
                        targetRow = $(`tr.temp-data input[data-localid="${localId}"]`).closest('tr');
                        journalEntries.splice(entryIndex, 1);
                    } else {
                        if (!batchId || !batchEntry || !transNbr) {
                            throw new Error('Parameter batchId, batchEntry, atau transNbr ga valid');
                        }

                        targetRow = $(element).closest('tr');
                        const rowData = extractRowData(targetRow);

                        deletedEntry = {
                            BatchId: batchId,
                            BatchEntry: batchEntry,
                            TransNbr: transNbr,
                            lineNumber: transNbr,
                            ...rowData,
                            isLocalData: false,
                            deleteType: 'database'
                        };
                    }

                    const finalDeletedEntry = {
                        ...deletedEntry,
                        deletedAt: new Date().toISOString(),
                        deletedBy: userId,
                        isLocalData: isLocalData,
                        deleteType: isLocalData ? 'local' : 'database'
                    };

                    deletedEntries.push(finalDeletedEntry);

                    targetRow.addClass('deleted-row').hide();

                    saveToLocalStorage();

                    showDeleteSuccessMessage();

                    setTimeout(() => {
                        updateSummarySection();
                    }, 100);

                } catch (error) {
                    console.error('Error di softDelete:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Ada kesalahan pas ngapus data: ' + error.message,
                        confirmButtonText: 'OK'
                    });
                }
            }
        });
    };

    // =====================================================
    // 12.4 - HANDLE SUKSES DELETE BATCH ENTRY
    // =====================================================
    function handleBatchEntryDeletionSuccess(batchId, batchEntry, message) {
        $('#gljournallistTable tbody').empty();
        $('#BatchEntryDeletedBadge').hide();

        clearLocalStorageByBatch(batchId, batchEntry);
        clearSoftEditByBatch(batchId, batchEntry);

        deletedEntries = deletedEntries.filter(entry =>
            !(entry.BatchId === batchId && entry.BatchEntry === batchEntry)
        );

        removeUserCreatedBatchEntry(batchId, batchEntry);

        resetHeaderFieldsForNewEntry();

        Swal.fire({
            icon: 'success',
            title: 'Berhasil Dihapus',
            text: message || 'Batch entry berhasil dihapus',
            confirmButtonText: 'OK'
        }).then(() => {
            refreshAllSummaryData();
            toggleSummarySection();
            showAddOption();
            $('#cb_batchentry').val('').trigger('change');
        });
    }
</script>

<!-- ===================================================== -->
<!-- BAGIAN 13: FUNGSI UNSAVED CHANGES DETECTION           -->
<!-- ===================================================== -->
<script>
    // =====================================================
    // 13.1 - CEK APAKAH ADA DATA YANG BELUM DISIMPAN
    // =====================================================
    function hasUnsavedData(batchId, batchEntry) {
        const filteredEntries = journalEntries.filter(entry =>
            entry.BatchId === batchId &&
            entry.BatchEntry === batchEntry &&
            entry.AudtUser === userId
        );

        return filteredEntries.length > 0;
    }

    // =====================================================
    // 13.2 - CEK APAKAH BATCH ENTRY UDAH DISIMPAN KE DB
    // =====================================================
    function isBatchEntrySavedToDatabase(batchId, batchEntry) {
        const hasDatabaseData = $('#gljournallistTable tbody tr:not(.temp-data)').length > 0;
        const isUserCreated = isUserCreatedBatchEntry(batchId, batchEntry);
        return hasDatabaseData && !isUserCreated;
    }

    // =====================================================
    // 13.3 - CEK APAKAH ADA DELETE YANG BELUM DISIMPAN
    // =====================================================
    function hasPendingDelete(batchId, batchEntry) {
        if (!batchId || !batchEntry) return false;

        const hasDeletedEntries = deletedEntries.some(entry =>
            entry.BatchId === batchId &&
            entry.BatchEntry === batchEntry
        );

        const hasDeletedRows = $('#gljournallistTable tbody tr.database-row.deleted-row').length > 0;

        return hasDeletedEntries || hasDeletedRows;
    }

    // =====================================================
    // 13.4 - CEK APAKAH ADA EDIT YANG BELUM DISIMPAN
    // =====================================================
    function hasPendingEdit(batchId, batchEntry) {
        if (!batchId || !batchEntry) return false;

        let hasSoftEdits = false;
        Object.keys(softEditEntries).forEach(key => {
            if (key.includes(`soft_edit_${batchId}_${batchEntry}_`)) {
                hasSoftEdits = true;
            }
        });

        const hasSoftEditRows = $('#gljournallistTable tbody tr.soft-edit-row').length > 0;

        return hasSoftEdits || hasSoftEditRows;
    }

    // =====================================================
    // 13.5 - CEK APAKAH ADA PERUBAHAN YANG BELUM DISIMPAN
    // =====================================================
    function hasUnsavedChanges(batchId, batchEntry) {
        if (!batchId || !batchEntry) return false;

        const isUserCreated = isUserCreatedBatchEntry(batchId, batchEntry);

        const hasLocalData = hasUnsavedData(batchId, batchEntry);

        const hasSoftEdit = hasUnsavedSoftEdit(batchId, batchEntry);

        const hasDelete = hasPendingDelete(batchId, batchEntry);

        const hasEdit = hasPendingEdit(batchId, batchEntry);

        const result = hasLocalData || isUserCreated || hasSoftEdit || hasDelete || hasEdit;

        return result;
    }

    // =====================================================
    // 13.6 - TAMPILKAN KONFIRMASI RESET
    // =====================================================
    async function showResetConfirmation(batchId, batchEntry) {
        const hasUnsaved = hasUnsavedChanges(batchId, batchEntry);

        if (hasUnsaved) {
            const result = await Swal.fire({
                icon: 'warning',
                title: 'Konfirmasi',
                text: 'Ada data yang belum disimpan. Yakin mau ganti batch entry? Data yang belum disimpan tidak akan berubah.',
                showCancelButton: true,
                confirmButtonText: 'Ya, lanjutin',
                cancelButtonText: 'Batal',
                allowOutsideClick: false,
                allowEscapeKey: false
            });

            if (result.isConfirmed) {
                if (hasUnsavedData(batchId, batchEntry)) {
                    journalEntries = journalEntries.filter(entry =>
                        !(entry.BatchId === batchId && entry.BatchEntry === batchEntry)
                    );
                }


                if (hasUnsavedSoftEdit(batchId, batchEntry) || hasPendingEdit(batchId, batchEntry)) {
                    clearSoftEditByBatch(batchId, batchEntry);
                }

                if (hasPendingDelete(batchId, batchEntry)) {
                    deletedEntries = deletedEntries.filter(entry =>
                        !(entry.BatchId === batchId && entry.BatchEntry === batchEntry)
                    );
                }

                if (isUserCreatedBatchEntry(batchId, batchEntry)) {
                    removeBatchEntryFromDropdown(batchEntry);
                    removeUserCreatedBatchEntry(batchId, batchEntry);
                    showAddOption();
                }

                saveToLocalStorage();
                saveSoftEditData();

                $('.temp-data, .soft-edit-row').remove();

                $(`tr[data-batchid="${batchId}"][data-batchentry="${batchEntry}"]`)
                    .removeClass('deleted-row soft-edit-row')
                    .show();

                return true;
            }
            return false;
        }
        return true;
    }
</script>

<!-- ===================================================== -->
<!-- BAGIAN 14: FUNGSI NAVIGASI BATCH ENTRY                -->
<!-- ===================================================== -->
<script>
    // =====================================================
    // 14.1 - TOGGLE TOMBOL PANAH
    // =====================================================
    function toggleArrowButtons(show = false) {
        const $prevContainer = $('#prevArrowContainer');
        const $nextContainer = $('#nextArrowContainer');
        const batchEntry = $('#cb_batchentry').val();

        const hasValidValue = batchEntry && batchEntry !== '' && batchEntry !== '__add__';

        if (hasValidValue && show) {
            $prevContainer.show();
            $nextContainer.show();
            updateNavigationButtons();
        } else {
            $prevContainer.hide();
            $nextContainer.hide();
        }
    }

    // =====================================================
    // 14.2 - UPDATE STATUS TOMBOL NAVIGASI
    // =====================================================
    function updateNavigationButtons() {
        const batchId = $('#cb_batchid').find('option:selected').data('batchid');
        const batchEntry = $('#cb_batchentry').val();

        const hasValidValue = batchEntry && batchEntry !== '' && batchEntry !== '__add__';

        if (!batchId || !hasValidValue) {
            $('#btnPrevBatchEntry, #btnNextBatchEntry').prop('disabled', true);
            return;
        }

        const allEntries = [];
        $('#cb_batchentry option').each(function() {
            const value = $(this).val();
            if (value && value !== '__add__' && /^\d+$/.test(value)) {
                allEntries.push(parseInt(value));
            }
        });

        if (allEntries.length <= 1) {
            $('#btnPrevBatchEntry, #btnNextBatchEntry').prop('disabled', true);
            return;
        }

        allEntries.sort((a, b) => a - b);
        const currentEntry = parseInt(batchEntry);
        const currentIndex = allEntries.indexOf(currentEntry);

        $('#btnPrevBatchEntry, #btnNextBatchEntry').prop('disabled', false);

        if (currentIndex > -1) {
            const prevEntry = currentIndex > 0 ? allEntries[currentIndex - 1] : allEntries[allEntries.length - 1];
            const nextEntry = currentIndex < allEntries.length - 1 ? allEntries[currentIndex + 1] : allEntries[0];

            $('#btnPrevBatchEntry').attr('title', `Previous: ${String(prevEntry).padStart(7, '0')}`);
            $('#btnNextBatchEntry').attr('title', `Next: ${String(nextEntry).padStart(7, '0')}`);
        }
    }

    // =====================================================
    // 14.3 - FUNGSI NAVIGASI BATCH ENTRY
    // =====================================================
    function navigateBatchEntry(direction) {
        const currentBatchId = $('#cb_batchid').find('option:selected').data('batchid');
        const currentBatchEntry = $('#cb_batchentry').val();

        if (!currentBatchId || !currentBatchEntry || currentBatchEntry === '__add__') {
            return;
        }

        const currentEntry = parseInt(currentBatchEntry);
        if (isNaN(currentEntry)) return;

        const allEntries = [];
        $('#cb_batchentry option').each(function() {
            const value = $(this).val();
            if (value && value !== '__add__' && /^\d+$/.test(value)) {
                allEntries.push(parseInt(value));
            }
        });

        if (allEntries.length === 0) return;

        allEntries.sort((a, b) => a - b);
        let targetEntry;

        if (direction === 'next') {
            targetEntry = allEntries.find(entry => entry > currentEntry) || allEntries[0];
        } else {
            const reversed = [...allEntries].reverse();
            targetEntry = reversed.find(entry => entry < currentEntry) || allEntries[allEntries.length - 1];
        }

        if (targetEntry) {
            const targetEntryStr = String(targetEntry).padStart(7, '0');

            $('#cb_batchentry')
                .val(targetEntryStr)
                .trigger('change');
        }
    }
</script>

<!-- ===================================================== -->
<!-- BAGIAN 15: FUNGSI LOCAL STORAGE MANAGEMENT            -->
<!-- ===================================================== -->
<script>
    // =====================================================
    // 15.1 - LOAD DATA DARI LOCALSTORAGE
    // =====================================================
    function loadFromLocalStorage() {
        const savedData = localStorage.getItem(LOCAL_STORAGE_KEY);
        journalEntries = savedData ? JSON.parse(savedData) : [];

        const userCreatedData = localStorage.getItem(`${LOCAL_STORAGE_KEY}_user_created`);
        userCreatedBatchEntries = userCreatedData ? JSON.parse(userCreatedData) : [];

        const deletedData = localStorage.getItem(`${LOCAL_STORAGE_KEY}_deleted`);
        deletedEntries = deletedData ? JSON.parse(deletedData) : [];

        renderLocalEntriesToTable();
    }

    // =====================================================
    // 15.2 - SIMPAN DATA KE LOCALSTORAGE
    // =====================================================
    function saveToLocalStorage() {
        localStorage.setItem(LOCAL_STORAGE_KEY, JSON.stringify(journalEntries));
        localStorage.setItem(`${LOCAL_STORAGE_KEY}_user_created`, JSON.stringify(userCreatedBatchEntries));
        localStorage.setItem(`${LOCAL_STORAGE_KEY}_deleted`, JSON.stringify(deletedEntries));
        renderLocalEntriesToTable();
    }

    // =====================================================
    // 15.3 - HAPUS DATA DARI LOCALSTORAGE UNTUK BATCH
    // =====================================================
    function clearLocalStorageByBatch(batchId, batchEntry) {
        journalEntries = journalEntries.filter(entry =>
            !(entry.BatchId === batchId &&
                entry.BatchEntry === batchEntry &&
                entry.AudtUser === userId)
        );

        userCreatedBatchEntries = userCreatedBatchEntries.filter(entry =>
            !(entry.batchId === batchId && entry.batchEntry === batchEntry)
        );

        deletedEntries = deletedEntries.filter(entry =>
            !(entry.BatchId === batchId && entry.BatchEntry === batchEntry)
        );

        saveToLocalStorage();

        $('.temp-data').remove();

        toggleSummarySection();
    }

    // =====================================================
    // 15.4 - HAPUS DATA YANG TERSIMPAN SETELAH SAVE
    // =====================================================
    function clearSavedDataFromLocalStorage(batchId, batchEntry) {
        journalEntries = journalEntries.filter(entry =>
            !(entry.BatchId === batchId &&
                entry.BatchEntry === batchEntry &&
                entry.AudtUser === userId)
        );

        userCreatedBatchEntries = userCreatedBatchEntries.filter(entry =>
            !(entry.batchId === batchId && entry.batchEntry === batchEntry)
        );

        deletedEntries = deletedEntries.filter(entry =>
            !(entry.BatchId === batchId && entry.BatchEntry === batchEntry)
        );

        saveToLocalStorage();
    }

    // =====================================================
    // 15.5 - HAPUS DATA LOKAL SEBELUM IMPORT
    // =====================================================
    function clearLocalDataBeforeImport(batchId) {
        try {
            localStorage.removeItem(LOCAL_STORAGE_KEY);
            localStorage.removeItem(`${LOCAL_STORAGE_KEY}_user_created`);
            localStorage.removeItem(`${LOCAL_STORAGE_KEY}_deleted`);

            Object.keys(softEditEntries).forEach(key => {
                if (key.includes(`soft_edit_${batchId}_`)) {
                    delete softEditEntries[key];
                }
            });

            journalEntries = [];
            userCreatedBatchEntries = [];
            deletedEntries = [];

            $('.temp-data').remove();

            toggleSummarySection();
            updateSummarySection();

            return true;
        } catch (error) {
            console.error('error pas ngapus data lokal:', error);
            return false;
        }
    }

    // =====================================================
    // 15.6 - RENDER ENTRI LOKAL KE TABEL
    // =====================================================
    function renderLocalEntriesToTable() {
        const batchId = $('#cb_batchid').find('option:selected').data('batchid');
        const batchEntry = $('#cb_batchentry').val();

        if (!batchId || !batchEntry) return;

        const tempRows = $('#gljournallistTable tbody tr.temp-data');
        if (tempRows.length > 0) tempRows.remove();

        const filteredEntries = journalEntries.filter(entry =>
            entry.BatchId === batchId &&
            entry.BatchEntry === batchEntry &&
            entry.AudtUser === userId
        );

        if (filteredEntries.length === 0) {
            toggleSummarySection();
            return;
        }

        let maxLineNumberFromDB = 0;

        const table = $("#gljournallistTable").DataTable();
        table.rows('.database-row:not(.deleted-row)').every(function() {
            const data = this.data();
            const lineNumber = data.transNbr || data.lineNumber;
            if (lineNumber && !isNaN(lineNumber)) {
                const lineNum = parseInt(lineNumber);
                if (lineNum > maxLineNumberFromDB) {
                    maxLineNumberFromDB = lineNum;
                }
            }
        });

        const sortedEntries = [...filteredEntries].sort((a, b) => {
            if (a.lineNumber && b.lineNumber) {
                return a.lineNumber - b.lineNumber;
            }
            return new Date(a.createdAt || 0) - new Date(b.createdAt || 0);
        });

        sortedEntries.forEach((entry, index) => {
            if (!entry.lineNumber || entry.lineNumber <= maxLineNumberFromDB) {
                entry.lineNumber = maxLineNumberFromDB + index + 1;
            }
        });

        const fragment = document.createDocumentFragment();

        sortedEntries.forEach((entry) => {
            const functionalDebit = entry.TransAmtDebit || '';
            const functionalCredit = entry.TransAmtCredit || '';
            const sourceDebit = entry.ScurnAmtDebit || '';
            const sourceCredit = entry.ScurnAmtCredit || '';
            const rateDateFormatted = formatDateDDMMYYYY(entry.RateDate);

            const isDeleted = deletedEntries.some(deleted =>
                deleted.isLocalData && deleted.localId === entry.localId
            );

            const escapeHtml = (text) => {
                if (!text) return '';
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            };

            const rowHtml = `
        <tr class="temp-data ${isDeleted ? 'deleted-row' : ''}" ${isDeleted ? 'style="display: none;"' : ''}
            data-localid="${escapeHtml(entry.localId)}"
            data-batchid="${escapeHtml(entry.BatchId)}" 
            data-batchentry="${escapeHtml(entry.BatchEntry)}">
            <td class="text-center">
                <input type="checkbox" class="checkbox-row" data-localid="${escapeHtml(entry.localId)}">
            </td>
            <td>${escapeHtml(entry.lineNumber)}</td>
            <td>${escapeHtml(entry.TransRef)}</td>
            <td>${escapeHtml(entry.TransDesc)}</td>
            <td>${escapeHtml(entry.AcctId)}</td>
            <td>${escapeHtml(entry.AcctName)}</td>
            <td>${escapeHtml(entry.ScurnCode)}</td>
            <td>${sourceDebit ? parseFloat(sourceDebit).toFixed(2) : ''}</td>
            <td>${sourceCredit ? parseFloat(sourceCredit).toFixed(2) : ''}</td>
            <td>${entry.ConvRate ? parseFloat(entry.ConvRate).toFixed(4) : ''}</td>
            <td>${escapeHtml(rateDateFormatted)}</td>
            <td>${functionalDebit ? parseFloat(functionalDebit).toFixed(2) : ''}</td>
            <td>${functionalCredit ? parseFloat(functionalCredit).toFixed(2) : ''}</td>
            <td>${escapeHtml(entry.Comment)}</td>
            <td class="btn-group">
                <a class="btn btn-sm btn-info" onclick="viewJournalEntry('${escapeHtml(entry.localId)}')">
                    <i class="fas fa-eye"></i>
                </a>
                <a class="btn btn-sm btn-primary" onclick="editJournalEntry('${escapeHtml(entry.localId)}')">
                    <i class="fas fa-tags"></i>
                </a>
                <a class="btn btn-sm btn-danger" onclick="softDeleteJournalEntry('${escapeHtml(entry.localId)}')">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
        `;
            const template = document.createElement('template');
            template.innerHTML = rowHtml.trim();
            fragment.appendChild(template.content.firstChild);
        });

        $('#gljournallistTable tbody').append(fragment);

        setTimeout(() => {
            toggleSummarySection();
            updateSummarySection();
        }, 50);
    }
</script>

<!-- ===================================================== -->
<!-- BAGIAN 16: FUNGSI SOFT EDIT TABLE OPERATIONS          -->
<!-- ===================================================== -->
<script>
    // =====================================================
    // 16.1 - UPDATE ROW DENGAN SOFT EDIT
    // =====================================================
    function updateTableWithSoftEdit(batchId, batchEntry, transNbr, editData) {
        const targetRow = $(`tr[data-batchid="${batchId}"][data-batchentry="${batchEntry}"][data-transnbr="${transNbr}"]`);

        if (targetRow.length > 0) {
            targetRow.addClass('soft-edit-row');

            targetRow.find('td:eq(2)').text(editData.TransRef);
            targetRow.find('td:eq(3)').text(editData.TransDesc);
            targetRow.find('td:eq(4)').text(editData.AcctId);
            targetRow.find('td:eq(5)').text(editData.AcctName);
            targetRow.find('td:eq(6)').text(editData.ScurnCode);
            targetRow.find('td:eq(7)').text(editData.ScurnAmtDebit ? parseFloat(editData.ScurnAmtDebit).toFixed(2) : '');
            targetRow.find('td:eq(8)').text(editData.ScurnAmtCredit ? parseFloat(editData.ScurnAmtCredit).toFixed(2) : '');
            targetRow.find('td:eq(9)').text(editData.ConvRate ? parseFloat(editData.ConvRate).toFixed(4) : '');
            targetRow.find('td:eq(10)').text(editData.RateDate);
            targetRow.find('td:eq(11)').text(editData.TransAmtDebit ? parseFloat(editData.TransAmtDebit).toFixed(2) : '');
            targetRow.find('td:eq(12)').text(editData.TransAmtCredit ? parseFloat(editData.TransAmtCredit).toFixed(2) : '');
            targetRow.find('td:eq(13)').text(editData.Comment);

            updateRowActions(targetRow, batchId, batchEntry, transNbr, true);

            setTimeout(() => updateSummarySection(), 100);
        }
    }

    // =====================================================
    // 16.2 - UPDATE ACTIONS DI ROW
    // =====================================================
    function updateRowActions(rowElement, batchId, batchEntry, transNbr, hasSoftEdit = false) {
        const actionsHtml = `
    <div class="btn-group">
        <a class="btn btn-sm btn-info view <?= session()->get("flag_view") === 1 ? "" : "d-none" ?>"
           data-batchid="${batchId}"
           data-batchentry="${batchEntry}"
           data-transnbr="${transNbr}">
           <i class="fas fa-eye"></i>
        </a>
        <a class="btn btn-sm btn-primary edit <?= session()->get("flag_update") === 1 ? "" : "d-none" ?>"
           data-batchid="${batchId}"
           data-batchentry="${batchEntry}"
           data-transnbr="${transNbr}">
           <i class="fas fa-tags"></i>
        </a>
        <a class="btn btn-sm btn-danger delete <?= session()->get("flag_delete") === 1 ? "" : "d-none" ?>"
           data-batchid="${batchId}"
           data-batchentry="${batchEntry}"
           data-transnbr="${transNbr}">
           <i class="fas fa-trash"></i>
        </a>
    </div>
    `;

        rowElement.find('td:eq(14)').html(actionsHtml);
    }

    // =====================================================
    // 16.3 - APPLY SOFT EDIT KE TABEL
    // =====================================================
    function applySoftEditToTable() {
        const batchId = $('#cb_batchid').find('option:selected').data('batchid');
        const batchEntry = $('#cb_batchentry').val();

        if (!batchId || !batchEntry) return;

        Object.keys(softEditEntries).forEach(key => {
            if (key.includes(`soft_edit_${batchId}_${batchEntry}_`)) {
                const transNbr = key.split('_').pop();
                const editData = softEditEntries[key];

                updateTableWithSoftEdit(batchId, batchEntry, transNbr, editData);
            }
        });
    }
</script>

<!-- ===================================================== -->
<!-- BAGIAN 17: FUNGSI ENTRY MODES                         -->
<!-- ===================================================== -->
<script>
    // =====================================================
    // 17.1 - NORMAL ENTRY MODE
    // =====================================================
    function normalEntryMode() {
        const batchId = $('#cb_batchid').find('option:selected').data('batchid');
        const batchEntry = $('#cb_batchentry').val();

        if (!batchId || !batchEntry) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Pilih Batch Number dan Entry Number dulu',
                confirmButtonText: 'OK'
            });
            return;
        }

        $('#TransRef, #TransDesc, #AcctId, #AcctName, #ScurnAmt, #ScurnAmtCredit, #ScurnAmtDebit, #TransAmt, #TransAmtCredit, #TransAmtDebit, #ConvRate, #Comment').val('');

        isNewEntry = true;
        isRateDateManuallyEdited = false;
        currentEntryMode = 'normal';

        updateRateDateFromDataEntry();

        getNextLineNumber(batchId, batchEntry).then(nextLine => {
            $('#LineNumber').val(nextLine);
        });

        const saveButton = $('#modalform').find('button[onclick="validateAndSaveJournalEntry()"]');
        saveButton.prop('disabled', false).html('Simpan');
    }

    // =====================================================
    // 17.2 - QUICK ENTRY MODE
    // =====================================================
    function quickEntryMode() {
        const batchId = $('#cb_batchid').find('option:selected').data('batchid');
        const batchEntry = $('#cb_batchentry').val();

        if (!batchId || !batchEntry) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Pilih Batch Number dan Entry Number dulu',
                confirmButtonText: 'OK'
            });
            return;
        }

        $('#ScurnAmtDebit, #ScurnAmtCredit, #Comment').val('');

        if (savedFormData) {
            $('#TransRef').val(savedFormData.TransRef);
            $('#TransDesc').val(savedFormData.TransDesc);
            $('#AcctId').val(savedFormData.AcctId);
            $('#AcctName').val(savedFormData.AcctName);
            $('#cb_scurncode').val(savedFormData.ScurnCode).trigger('change');
            $('#ConvRate').val(savedFormData.ConvRate);
            $('#RateDate').val(savedFormData.RateDate);
            $('#Comment').val(savedFormData.Comment);
        }

        $('#ScurnAmt, #ScurnAmtCredit, #ScurnAmtDebit, #TransAmt, #TransAmtCredit, #TransAmtDebit').val('');

        $('#ScurnAmtDebit, #ScurnAmtCredit, #TransAmtDebit, #TransAmtCredit').prop('readonly', false);

        getNextLineNumber(batchId, batchEntry).then(nextLine => {
            $('#LineNumber').val(nextLine);
        });

        currentEntryMode = 'quick';

        setupQuickEntryLockHandlers();

        const saveButton = $('#modalform').find('button[onclick="validateAndSaveJournalEntry()"]');
        saveButton.prop('disabled', false).html('Simpan');
    }

    // =====================================================
    // 17.3 - BUKA QUICK ENTRY MODE
    // =====================================================
    function openQuickEntryMode() {
        const selectedRows = $('.checkbox-row:checked');

        if (selectedRows.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Pilih satu data buat Quick Entry Mode',
                confirmButtonText: 'OK'
            });
            return;
        }

        if (selectedRows.length > 1) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Cuma boleh milih satu data buat Quick Entry Mode',
                confirmButtonText: 'OK'
            });
            return;
        }

        const firstSelected = selectedRows.first();
        const row = firstSelected.closest('tr');

        const rowData = {
            lineNumber: row.find('td:eq(1)').text().trim(),
            transRef: row.find('td:eq(2)').text().trim(),
            transDesc: row.find('td:eq(3)').text().trim(),
            acctId: row.find('td:eq(4)').text().trim(),
            acctName: row.find('td:eq(5)').text().trim(),
            scurnCode: row.find('td:eq(6)').text().trim(),
            scurnAmtDebit: row.find('td:eq(7)').text().trim(),
            scurnAmtCredit: row.find('td:eq(8)').text().trim(),
            convRate: row.find('td:eq(9)').text().trim(),
            rateDate: row.find('td:eq(10)').text().trim(),
            transAmtDebit: row.find('td:eq(11)').text().trim(),
            transAmtCredit: row.find('td:eq(12)').text().trim(),
            comment: row.find('td:eq(13)').text().trim()
        };

        fillQuickEntryForm(rowData);
        $('#modalform').modal('show');
    }

    // =====================================================
    // 17.4 - ISI FORM UNTUK QUICK ENTRY
    // =====================================================
    function fillQuickEntryForm(data) {
        $('#data_form')[0].reset();

        $('#TransRef').val(data.transRef);
        $('#TransDesc').val(data.transDesc);
        $('#AcctId').val(data.acctId);
        $('#AcctName').val(data.acctName);
        $('#cb_scurncode').val(data.scurnCode).trigger('change');
        $('#RateDate').val(data.rateDate);

        $('#ScurnAmtDebit').val(data.scurnAmtDebit ? data.scurnAmtDebit.replace(/\.00$/, '') : '');
        $('#ScurnAmtCredit').val(data.scurnAmtCredit ? data.scurnAmtCredit.replace(/\.00$/, '') : '');
        $('#TransAmtDebit').val(data.transAmtDebit ? data.transAmtDebit.replace(/\.00$/, '') : '');
        $('#TransAmtCredit').val(data.transAmtCredit ? data.transAmtCredit.replace(/\.00$/, '') : '');

        $('#Comment').val(data.comment);

        currentEntryMode = 'quick';
        $('.modal-title').text('Quick Entry Mode');

        const batchId = $('#cb_batchid').find('option:selected').data('batchid');
        const batchEntry = $('#cb_batchentry').val();

        if (batchId && batchEntry) {
            getNextLineNumber(batchId, batchEntry).then(nextLine => {
                $('#LineNumber').val(nextLine);
            });
        }

        setTimeout(() => autoLockAmountFieldsBasedOnData(data), 100);
    }
</script>

<!-- ===================================================== -->
<!-- BAGIAN 18: FUNGSI SAVE JOURNAL ENTRY                  -->
<!-- ===================================================== -->
<script>
    // =====================================================
    // 18.1 - VALIDASI DAN SIMPAN JOURNAL ENTRY
    // =====================================================
    window.validateAndSaveJournalEntry = async function() {
        if (!validateJournalEntryForm()) {
            return;
        }
        await saveJournalEntry();
    }

    // =====================================================
    // 18.2 - SIMPAN JOURNAL ENTRY
    // =====================================================
    window.saveJournalEntry = async function() {
        const saveButton = $('#modalform').find('button[onclick="validateAndSaveJournalEntry()"]');
        const action = $('#action').val();

        if (action === 'Edit' && currentEditTransaction) {
            await saveSoftEditEntry();
            return;
        }

        if (action === 'EditSoft' && currentEditTransaction) {
            await saveSoftEditEntry();
            return;
        }

        if (action === 'EditLocal' && editIndex !== null) {}

        saveButton.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');

        try {
            const batchId = $('#cb_batchid').find('option:selected').data('batchid');
            const batchEntry = $('#cb_batchentry').val();

            if (!batchId || !batchEntry) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Pilih Batch Number dan Entry Number dulu',
                    confirmButtonText: 'OK'
                });
                saveButton.prop('disabled', false).html('Simpan');
                return;
            }

            let lineNumber = $('#LineNumber').val();
            if (!lineNumber) {
                lineNumber = await getNextLineNumber(batchId, batchEntry);
            }

            const currentTime = new Date().toISOString();

            const scurnAmtDebit = $('#ScurnAmtDebit').val().trim();
            const scurnAmtCredit = $('#ScurnAmtCredit').val().trim();
            const transAmtDebit = $('#TransAmtDebit').val().trim();
            const transAmtCredit = $('#TransAmtCredit').val().trim();

            const dataEntryFormatted = $('#DataEntry').val();
            const postDateFormatted = $('#PostDate').val();
            const rateDateFormatted = $('#RateDate').val();

            const journalData = {
                localId: action === 'EditLocal' && editIndex !== null ? journalEntries[editIndex].localId : 'journal_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9),
                TransRef: $('#TransRef').val(),
                TransDesc: $('#TransDesc').val(),
                AcctId: $('#AcctId').val(),
                AcctName: $('#AcctName').val(),
                ScurnCode: $('#cb_scurncode').val(),
                ScurnAmtDebit: scurnAmtDebit,
                ScurnAmtCredit: scurnAmtCredit,
                ConvRate: parseFloat($('#ConvRate').val()) || 1,
                RateDate: rateDateFormatted,
                TransAmtDebit: transAmtDebit,
                TransAmtCredit: transAmtCredit,
                Comment: $('#Comment').val(),
                BatchId: batchId,
                BatchEntry: batchEntry,
                HcurnCode: $('#cb_scurncode').val(),
                lineNumber: parseInt(lineNumber),
                createdAt: currentTime,
                status: 'draft',
                AudtUser: userId,
                AudtTime: currentTime,
                SrceLedger: $('#cb_srceledger').val(),
                SrceType: $('#cb_srcetype').val(),
                JrnlDesc: $('#JrnlDesc').val(),
                DataEntry: dataEntryFormatted,
                PostDate: postDateFormatted,
                YearPeriod: $('#YearPeriod').val()
            };

            if (action === 'EditLocal' && editIndex !== null) {
                journalEntries[editIndex] = journalData;

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Data lokal berhasil diupdate',
                    confirmButtonText: 'OK'
                });

                saveToLocalStorage();
                $('#modalform').modal('hide');
                resetFormToInitialState();
                saveButton.prop('disabled', false).html('Simpan');

                editIndex = null;

            } else {
                journalEntries.push(journalData);

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Data line number ' + lineNumber + ' berhasil disimpan',
                    confirmButtonText: 'OK'
                });

                saveToLocalStorage();

                savedFormData = {
                    TransRef: $('#TransRef').val(),
                    TransDesc: $('#TransDesc').val(),
                    AcctId: $('#AcctId').val(),
                    AcctName: $('#AcctName').val(),
                    ScurnCode: $('#cb_scurncode').val(),
                    ConvRate: $('#ConvRate').val(),
                    RateDate: $('#RateDate').val(),
                    Comment: $('#Comment').val()
                };

                $('#LineNumber').val(lineNumber);
                saveButton.prop('disabled', true).html('<i class="fas fa-check"></i> Tersimpan');

                isNewEntry = false;
                isRateDateManuallyEdited = false;
            }

            toggleSummarySection();
            setTimeout(() => updateSummarySection(), 100);

        } catch (error) {
            saveButton.prop('disabled', false).html('Simpan');
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ada kesalahan pas nyimpen data',
                confirmButtonText: 'OK'
            });
        }
    };

    // =====================================================
    // 18.3 - SIMPAN SOFT EDIT ENTRY
    // =====================================================
    async function saveSoftEditEntry() {

        if (!validateJournalEntryForm()) {
            return;
        }

        const saveButton = $('#modalform').find('button[onclick="validateAndSaveJournalEntry()"]');
        saveButton.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');

        try {
            if (!currentEditTransaction) {
                console.error('Ga ada currentEditTransaction');
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ga ada data yang lagi diedit',
                    confirmButtonText: 'OK'
                });
                saveButton.prop('disabled', false).html('Simpan');
                return;
            }

            const {
                batchId,
                batchEntry,
                transNbr
            } = currentEditTransaction;

            const acctId = $('#AcctId').val();
            if (!acctId) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Account ID harus diisi',
                    confirmButtonText: 'OK'
                });
                saveButton.prop('disabled', false).html('Simpan');
                return;
            }

            const scurnAmtDebit = $('#ScurnAmtDebit').val().trim();
            const scurnAmtCredit = $('#ScurnAmtCredit').val().trim();
            const transAmtDebit = $('#TransAmtDebit').val().trim();
            const transAmtCredit = $('#TransAmtCredit').val().trim();

            const scurnAmtDebitNum = scurnAmtDebit ? parseFloat(scurnAmtDebit) : 0;
            const scurnAmtCreditNum = scurnAmtCredit ? parseFloat(scurnAmtCredit) : 0;
            const transAmtDebitNum = transAmtDebit ? parseFloat(transAmtDebit) : 0;
            const transAmtCreditNum = transAmtCredit ? parseFloat(transAmtCredit) : 0;

            const editData = {
                BatchId: batchId,
                BatchEntry: batchEntry,
                TransNbr: parseInt(transNbr),
                JournalId: $('#JournalId').val(),
                TransRef: $('#TransRef').val(),
                TransDesc: $('#TransDesc').val(),
                AcctId: acctId,
                AcctName: $('#AcctName').val(),
                ScurnCode: $('#cb_scurncode').val(),
                ScurnAmtDebit: scurnAmtDebit,
                ScurnAmtCredit: scurnAmtCredit,
                ScurnAmt: scurnAmtDebitNum - scurnAmtCreditNum,
                HcurnCode: $('#cb_scurncode').val(),
                TransAmtDebit: transAmtDebit,
                TransAmtCredit: transAmtCredit,
                TransAmt: transAmtDebitNum - transAmtCreditNum,
                RateDate: formatDateDDMMYYYY($('#RateDate').val()),
                ConvRate: parseFloat($('#ConvRate').val()) || 1,
                Comment: $('#Comment').val(),
                isSoftEdit: true,
                lineNumber: $('#LineNumber').val()
            };

            saveSoftEdit(batchId, batchEntry, transNbr, editData);

            updateTableWithSoftEdit(batchId, batchEntry, transNbr, editData);

            setTimeout(() => updateSummarySection(), 50);

            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Perubahan disimpan sementara. Klik "Save" di bawah buat nyimpen permanen ke database.',
                confirmButtonText: 'OK'
            }).then(() => {
                $('#modalform').modal('hide');
                currentEditTransaction = null;
            });

            saveButton.prop('disabled', false).html('Simpan');

        } catch (error) {
            console.error('Error di saveSoftEditEntry:', error);
            saveButton.prop('disabled', false).html('Simpan');
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ada kesalahan pas nyimpen: ' + error.message,
                confirmButtonText: 'OK'
            });
        }
    }
</script>

<!-- ===================================================== -->
<!-- BAGIAN 19: FUNGSI SAVE ALL TO DATABASE                -->
<!-- ===================================================== -->
<script>
    // =====================================================
    // 19.0 - VALIDASI HEADER SEBELUM SAVE
    // =====================================================
    function validateHeaderBeforeSave() {
        let isValid = true;
        let errorMessages = [];

        $('#JrnlDesc, #YearPeriod, #cb_srcetype').removeClass('is-invalid');
        $('.error-JrnlDesc, .error-YearPeriod, .error-cb_srcetype').remove();

        const jrnlDesc = $('#JrnlDesc').val().trim();
        if (!jrnlDesc) {
            isValid = false;
            errorMessages.push('Entry Description harus diisi');
            $('#JrnlDesc').addClass('is-invalid');

            if ($('#JrnlDesc').next('.invalid-feedback').length === 0) {
                $('#JrnlDesc').after('<div class="invalid-feedback error-JrnlDesc">Entry Description wajib diisi</div>');
            }
        }

        const yearPeriod = $('#YearPeriod').val().trim();
        if (!yearPeriod) {
            isValid = false;
            errorMessages.push('Year / Period harus diisi');
            $('#YearPeriod').addClass('is-invalid');

            if ($('#YearPeriod').parent().find('.invalid-feedback').length === 0) {
                $('#YearPeriod').parent().after('<div class="invalid-feedback error-YearPeriod">Year / Period wajib diisi</div>');
            }
        }

        const cb_srcetype = $('#cb_srcetype').val().trim();
        if (!cb_srcetype) {
            isValid = false;
            errorMessages.push('Source Type harus diisi');
            $('#cb_srcetype').addClass('is-invalid');

            if ($('#cb_srcetype').parent().find('.invalid-feedback').length === 0) {
                $('#cb_srcetype').parent().after('<div class="invalid-feedback error-cb_srcetype">Year / Period wajib diisi</div>');
            }
        }

        if (!isValid) {
            Swal.fire({
                icon: 'warning',
                title: 'Validasi Gagal',
                html: errorMessages.map(msg => `<i class="fas fa-exclamation-circle text-danger mr-2"></i>${msg}<br>`).join(''),
                confirmButtonText: 'OK'
            });
        }

        return isValid;
    }

    // =====================================================
    // 19.1 - PERSIAPAN DATA UNTUK SAVE
    // =====================================================
    function prepareSaveData(batchId, batchEntry) {
        const headerData = {
            SrceLedger: $('#cb_srceledger').val(),
            SrceType: $('#cb_srcetype').val(),
            JrnlDesc: $('#JrnlDesc').val(),
            DataEntry: $('#DataEntry').val(),
            PostDate: $('#PostDate').val(),
            YearPeriod: $('#YearPeriod').val()
        };

        const entries = journalEntries.filter(entry =>
            entry.BatchId === batchId &&
            entry.BatchEntry === batchEntry &&
            entry.AudtUser === userId
        ).map(entry => ({
            lineNumber: entry.lineNumber,
            TransRef: entry.TransRef,
            TransDesc: entry.TransDesc,
            AcctId: entry.AcctId,
            AcctName: entry.AcctName,
            ScurnCode: entry.ScurnCode,
            ScurnAmtDebit: entry.ScurnAmtDebit,
            ScurnAmtCredit: entry.ScurnAmtCredit,
            ConvRate: entry.ConvRate,
            RateDate: entry.RateDate,
            TransAmtDebit: entry.TransAmtDebit,
            TransAmtCredit: entry.TransAmtCredit,
            Comment: entry.Comment,
            HcurnCode: entry.HcurnCode,
            SrceLedger: entry.SrceLedger || headerData.SrceLedger,
            SrceType: entry.SrceType || headerData.SrceType,
            JrnlDesc: entry.JrnlDesc || headerData.JrnlDesc,
            DataEntry: entry.DataEntry || headerData.DataEntry,
            PostDate: entry.PostDate || headerData.PostDate,
            YearPeriod: entry.YearPeriod || headerData.YearPeriod
        }));

        const softEditEntriesData = [];
        Object.keys(softEditEntries).forEach(key => {
            if (key.includes(`soft_edit_${batchId}_${batchEntry}_`)) {
                const editData = softEditEntries[key];
                softEditEntriesData.push({
                    TransNbr: editData.TransNbr,
                    TransRef: editData.TransRef,
                    TransDesc: editData.TransDesc,
                    AcctId: editData.AcctId,
                    AcctName: editData.AcctName,
                    ScurnCode: editData.ScurnCode,
                    ScurnAmtDebit: editData.ScurnAmtDebit,
                    ScurnAmtCredit: editData.ScurnAmtCredit,
                    ConvRate: editData.ConvRate,
                    RateDate: editData.RateDate,
                    TransAmtDebit: editData.TransAmtDebit,
                    TransAmtCredit: editData.TransAmtCredit,
                    Comment: editData.Comment,
                    HcurnCode: editData.HcurnCode
                });
            }
        });

        const deletedEntriesData = deletedEntries.filter(entry =>
            entry.BatchId === batchId && entry.BatchEntry === batchEntry
        ).map(entry => ({
            BatchId: entry.BatchId,
            BatchEntry: entry.BatchEntry,
            TransNbr: entry.TransNbr || entry.lineNumber || entry.transNbr,
            isLocalData: entry.isLocalData || false,
            lineNumber: entry.lineNumber,
            transNbr: entry.transNbr
        }));

        return {
            batchId: batchId,
            batchEntry: batchEntry,
            header: headerData,
            entries: entries,
            softEditEntries: softEditEntriesData,
            deletedEntries: deletedEntriesData
        };
    }

    // =====================================================
    // 19.2 - KIRIM DATA SAVE KE SERVER
    // =====================================================
    async function sendSaveData(saveData) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "<?= site_url('tmstgljournal/savedata') ?>",
                method: "POST",
                contentType: "application/json",
                data: JSON.stringify(saveData),
                dataType: "JSON",
                success: function(response) {
                    resolve(response);
                },
                error: function(xhr, status, error) {
                    reject(new Error('gagal nyimpen data: ' + error));
                }
            });
        });
    }

    // =====================================================
    // 19.3 - REFRESH TABEL DATA
    // =====================================================
    function refreshDataTable() {
        table.ajax.reload(function(json) {
            setTimeout(() => {
                toggleSummarySection();
                updateSummarySection();

                const batchId = $('#cb_batchid').find('option:selected').data('batchid');
                if (batchId) {
                    refreshSummaryData(batchId);
                }
            }, 200);
        }, false);
    }

    // =====================================================
    // 19.4 - REORDER DROPDOWN BATCH ENTRY
    // =====================================================
    function reorderBatchEntryDropdown() {
        const batchId = $('#cb_batchid').find('option:selected').data('batchid');
        if (!batchId) return;

        const currentValue = $('#cb_batchentry').val();
        loadBatchEntries(batchId);

        setTimeout(() => {
            if (currentValue) {
                $('#cb_batchentry').val(currentValue).trigger('change');
            }
        }, 500);
    }

    // =====================================================
    // 19.5 - SIMPAN SEMUA KE DATABASE
    // =====================================================
    window.saveAllToDatabase = async function() {
        if (!validateHeaderBeforeSave()) {
            return;
        }

        const debits = parseFloat($('#Debits').val().replace(/[^\d.-]/g, '')) || 0;
        const credits = parseFloat($('#Credits').val().replace(/[^\d.-]/g, '')) || 0;

        if (Math.abs(debits - credits) > 0.01) {
            Swal.fire({
                icon: 'error',
                title: 'Ga Bisa Nyimpen',
                text: 'Debit dan Credit harus balance sebelum nyimpen data',
                confirmButtonText: 'OK'
            });
            return;
        }

        const batchId = $('#cb_batchid').find('option:selected').data('batchid');
        const batchEntry = $('#cb_batchentry').val();

        if (!batchId || !batchEntry) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Pilih Batch Number dan Entry Number dulu',
                confirmButtonText: 'OK'
            });
            return;
        }

        $('#saveToDatabase').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');

        try {
            const saveData = prepareSaveData(batchId, batchEntry);
            const result = await sendSaveData(saveData);

            if (result.success) {
                clearSavedDataFromLocalStorage(batchId, batchEntry);
                clearSoftEditByBatch(batchId, batchEntry);

                deletedEntries = deletedEntries.filter(entry =>
                    !(entry.BatchId === batchId && entry.BatchEntry === batchEntry)
                );

                removeUserCreatedBatchEntry(batchId, batchEntry);

                $('.temp-data').remove();
                $('.soft-edit-row').removeClass('soft-edit-row');

                saveToLocalStorage();

                $('#cb_batchentry').val(batchEntry);

                table.ajax.reload(function(json) {
                    if (result.summary) {
                        updateSummaryDisplay(result.summary);
                    }

                    setTimeout(() => {
                        toggleSummarySection();
                        updateSummarySection();
                    }, 200);

                }, false);

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: result.message || `Data berhasil disimpan`,
                    confirmButtonText: 'OK'
                });

            } else {
                let errorMessage = result.message || 'Ada kesalahan pas nyimpen data';
                if (result.errors && result.errors.length > 0) {
                    errorMessage += '\n\nDetail Error:\n' + result.errors.join('\n');
                }

                Swal.fire({
                    icon: 'warning',
                    title: 'Ada Masalah',
                    text: errorMessage,
                    confirmButtonText: 'OK'
                });
            }

        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Gagal nyimpen data: ' + error.message,
                confirmButtonText: 'OK'
            });
        } finally {
            $('#saveToDatabase').prop('disabled', false).html('Save');
        }
    };
</script>

<!-- ===================================================== -->
<!-- BAGIAN 20: FUNGSI SUMMARY SECTION                     -->
<!-- ===================================================== -->
<script>
    // =====================================================
    // 20.1 - TOGGLE SUMMARY SECTION
    // =====================================================
    function toggleSummarySection() {
        const table = $("#gljournallistTable").DataTable();
        const rowCount = table.rows({
            filter: 'applied'
        }).count();
        const localRowCount = $('.temp-data').length;
        const totalRowCount = rowCount + localRowCount;

        if (totalRowCount > 0) {
            $('#summarySection').show().removeClass('d-none');
            autoUpdateSummary();
        } else {
            $('#summarySection').hide().addClass('d-none');
        }
    }

    // =====================================================
    // 20.2 - AUTO UPDATE SUMMARY
    // =====================================================
    function autoUpdateSummary() {
        setTimeout(() => updateSummarySection(), 100);
    }

    // =====================================================
    // 20.3 - UPDATE SUMMARY SECTION
    // =====================================================
    window.updateSummarySection = function() {
        const batchId = $('#cb_batchid').find('option:selected').data('batchid');
        const batchEntry = $('#cb_batchentry').val();

        if (!batchId || !batchEntry || batchEntry === '__add__') {
            $('#Debits').val('0');
            $('#Credits').val('0');
            $('#OutOfBalance').val('0');
            $('#saveToDatabase').prop('disabled', true);
            return;
        }

        $.ajax({
            url: "<?= site_url('tmstgljournal/checkBalance') ?>",
            method: "GET",
            data: {
                batchId: batchId,
                batchEntry: batchEntry,
                _t: Date.now()
            },
            dataType: "JSON",
            success: function(response) {
                if (response.success && response.data) {
                    var debit = parseFloat(response.data.TotalDebit) || 0;
                    var credit = parseFloat(response.data.TotalCredit) || 0;
                    var outOfBalance = parseFloat(response.data.OutOfBalance) || 0;

                    var formattedDebit = debit.toLocaleString('id-ID', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    var formattedCredit = credit.toLocaleString('id-ID', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    var formattedOutOfBalance = outOfBalance.toLocaleString('id-ID', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });

                    $('#Debits').val(formattedDebit);
                    $('#Credits').val(formattedCredit);
                    $('#OutOfBalance').val(formattedOutOfBalance);
                    $('#saveToDatabase').prop('disabled', outOfBalance > 0.01);
                } else {
                    fallbackToLocalBalance();
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching balance from API:', error);
                fallbackToLocalBalance();
            }
        });
    }

    function fallbackToLocalBalance() {
        var totalDebit = 0;
        var totalCredit = 0;

        $('#gljournallistTable tbody tr:visible').each(function() {
            var debit = parseFloat($(this).find('td:eq(11)').text().replace(/[^\d.-]/g, '')) || 0;
            var credit = parseFloat($(this).find('td:eq(12)').text().replace(/[^\d.-]/g, '')) || 0;
            totalDebit += debit;
            totalCredit += credit;
        });

        var formattedDebit = totalDebit.toLocaleString('id-ID', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        var formattedCredit = totalCredit.toLocaleString('id-ID', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        var outOfBalance = Math.abs(totalDebit - totalCredit);
        var formattedOutOfBalance = outOfBalance.toLocaleString('id-ID', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        $('#Debits').val(formattedDebit);
        $('#Credits').val(formattedCredit);
        $('#OutOfBalance').val(formattedOutOfBalance);
        $('#saveToDatabase').prop('disabled', outOfBalance > 0.01);
    }

    // =====================================================
    // 20.4 - CEK BALANCE DARI DATABASE
    // =====================================================
    function checkDatabaseBalance(batchId, batchEntry) {
        return new Promise((resolve, reject) => {
            const xhr = $.ajax({
                url: "<?= site_url('tmstgljournal/checkBalance') ?>",
                method: "GET",
                data: {
                    batchId: batchId,
                    batchEntry: batchEntry,
                    _t: Date.now()
                },
                dataType: "JSON",
                beforeSend: function(xhr) {
                    pendingAjaxRequests.push(xhr);
                },
                success: function(response) {
                    const index = pendingAjaxRequests.indexOf(xhr);
                    if (index > -1) pendingAjaxRequests.splice(index, 1);

                    if (response.success && response.data) {
                        resolve({
                            TotalDebit: parseFloat(response.data.TotalDebit) || 0,
                            TotalCredit: parseFloat(response.data.TotalCredit) || 0,
                            Transactions: response.data.Transactions || []
                        });
                    } else {
                        resolve({
                            TotalDebit: 0,
                            TotalCredit: 0,
                            Transactions: []
                        });
                    }
                },
                error: function(xhr, status, error) {
                    const index = pendingAjaxRequests.indexOf(xhr);
                    if (index > -1) pendingAjaxRequests.splice(index, 1);

                    if (status === 'abort') {
                        reject({
                            statusText: 'abort'
                        });
                    } else {
                        reject(error);
                    }
                }
            });
        });
    }

    // =====================================================
    // 20.5 - HITUNG BALANCE LOKAL
    // =====================================================
    function calculateLocalBalance(batchId, batchEntry) {
        let totalDebit = 0;
        let totalCredit = 0;

        const softEditMap = {};

        Object.keys(softEditEntries).forEach(key => {
            if (key.includes(`soft_edit_${batchId}_${batchEntry}_`)) {
                const transNbr = key.split('_').pop();
                const editData = softEditEntries[key];

                softEditMap[transNbr] = {
                    TransAmtDebit: parseFloat(editData.TransAmtDebit) || 0,
                    TransAmtCredit: parseFloat(editData.TransAmtCredit) || 0,
                    ScurnAmtDebit: parseFloat(editData.ScurnAmtDebit) || 0,
                    ScurnAmtCredit: parseFloat(editData.ScurnAmtCredit) || 0
                };
            }
        });

        const deletedMap = {};
        deletedEntries.forEach(entry => {
            if (entry.BatchId === batchId && entry.BatchEntry === batchEntry) {
                const transNbr = entry.TransNbr || entry.lineNumber;
                deletedMap[transNbr] = true;
            }
        });

        const table = $("#gljournallistTable").DataTable();
        table.rows('.database-row').every(function() {
            const data = this.data();
            const transNbr = data.transNbr;

            if (deletedMap[transNbr]) {
                return;
            }

            if (softEditMap[transNbr]) {
                return;
            }

            const transAmt = parseFloat(data.transAmt) || 0;
            const scurnAmt = parseFloat(data.scurnAmt) || 0;

            if (transAmt > 0) {
                totalDebit += transAmt;
            } else if (transAmt < 0) {
                totalCredit += Math.abs(transAmt);
            } else if (scurnAmt > 0) {
                totalDebit += scurnAmt;
            } else if (scurnAmt < 0) {
                totalCredit += Math.abs(scurnAmt);
            }
        });

        Object.keys(softEditMap).forEach(transNbr => {
            if (deletedMap[transNbr]) {
                return;
            }

            const edit = softEditMap[transNbr];

            if (edit.TransAmtDebit > 0) {
                totalDebit += edit.TransAmtDebit;
            } else if (edit.TransAmtCredit > 0) {
                totalCredit += edit.TransAmtCredit;
            } else if (edit.ScurnAmtDebit > 0) {
                totalDebit += edit.ScurnAmtDebit;
            } else if (edit.ScurnAmtCredit > 0) {
                totalCredit += edit.ScurnAmtCredit;
            }
        });

        const localEntries = journalEntries.filter(entry =>
            entry.BatchId === batchId &&
            entry.BatchEntry === batchEntry &&
            entry.AudtUser === userId
        );

        localEntries.forEach(entry => {
            const isDeleted = deletedEntries.some(deleted =>
                deleted.isLocalData && deleted.localId === entry.localId
            );

            if (isDeleted) {
                return;
            }

            const scurnAmtDebit = parseFloat(entry.ScurnAmtDebit) || 0;
            const scurnAmtCredit = parseFloat(entry.ScurnAmtCredit) || 0;
            const transAmtDebit = parseFloat(entry.TransAmtDebit) || 0;
            const transAmtCredit = parseFloat(entry.TransAmtCredit) || 0;

            if (transAmtDebit > 0) totalDebit += transAmtDebit;
            if (transAmtCredit > 0) totalCredit += transAmtCredit;
            if (scurnAmtDebit > 0 && transAmtDebit === 0) totalDebit += scurnAmtDebit;
            if (scurnAmtCredit > 0 && transAmtCredit === 0) totalCredit += scurnAmtCredit;
        });

        return {
            Debit: totalDebit,
            Credit: totalCredit
        };
    }

    // =====================================================
    // 20.6 - HITUNG BALANCE LOKAL SAJA
    // =====================================================
    function calculateLocalOnlyBalance() {
        const batchId = $('#cb_batchid').find('option:selected').data('batchid');
        const batchEntry = $('#cb_batchentry').val();

        if (!batchId || !batchEntry || batchEntry === '__add__') {
            updateBalanceDisplay(0, 0, 0);
            return;
        }

        const localBalance = calculateLocalBalance(batchId, batchEntry);
        const outOfBalance = Math.abs(localBalance.Debit - localBalance.Credit);

        updateBalanceDisplay(localBalance.Debit, localBalance.Credit, outOfBalance);
    }

    // =====================================================
    // 20.7 - UPDATE TAMPILAN BALANCE
    // =====================================================
    function updateBalanceDisplay(debit, credit, outOfBalance) {
        const formattedDebit = debit.toLocaleString('id-ID', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        const formattedCredit = credit.toLocaleString('id-ID', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        const formattedOutOfBalance = outOfBalance.toLocaleString('id-ID', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        $('#Debits').val(formattedDebit);
        $('#Credits').val(formattedCredit);
        $('#OutOfBalance').val(formattedOutOfBalance);
    }

    // =====================================================
    // 20.8 - TOGGLE TOMBOL SAVE
    // =====================================================
    function toggleSaveButton(isBalanced) {
        const saveButton = $('#saveToDatabase');

        if (isBalanced) {
            saveButton.prop('disabled', false);
            saveButton.removeClass('btn-secondary').addClass('btn-success');
            saveButton.html('Save');
            saveButton.attr('title', 'Klik buat nyimpen data');
        } else {
            saveButton.prop('disabled', true);
            saveButton.removeClass('btn-success').addClass('btn-secondary');
            saveButton.html('<i class="fas fa-ban"></i> Save');
            saveButton.attr('title', 'Debit dan Credit harus balance dulu');
        }
    }

    // =====================================================
    // 20.9 - UPDATE JUMLAH ENTRIES
    // =====================================================
    function updateEntriesCount() {
        const table = $("#gljournallistTable").DataTable();
        const dbRowCount = table.rows({
            filter: 'applied'
        }).count();
        const localRowCount = $('.temp-data').length;
        const totalRowCount = dbRowCount + localRowCount;
    }

    // =====================================================
    // 20.10 - UPDATE TAMPILAN SUMMARY
    // =====================================================
    function updateSummaryDisplay(summaryData) {
        if (!summaryData) {
            summaryData = {
                'SummaryBatchType': '',
                'SummaryBatchStatus': '',
                'SummaryEntries': 0,
                'SummaryDebits': 0,
                'SummaryCredits': 0
            };
        }

        $('#SummaryBatchType').text(summaryData.SummaryBatchType || summaryData.summaryBatchType || '');
        $('#SummaryBatchStatus').text(summaryData.SummaryBatchStatus || summaryData.summaryBatchStatus || '');
        $('#SummaryEntries').text(summaryData.SummaryEntries || summaryData.summaryEntries || 0);

        const debits = parseFloat(summaryData.SummaryDebits || summaryData.summaryDebits || 0);
        const credits = parseFloat(summaryData.SummaryCredits || summaryData.summaryCredits || 0);

        $('#SummaryDebits').text(debits.toLocaleString('id-ID', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }));
        $('#SummaryCredits').text(credits.toLocaleString('id-ID', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }));
    }

    // =====================================================
    // 20.11 - REFRESH DATA SUMMARY
    // =====================================================
    function refreshSummaryData(batchId) {
        $.ajax({
            url: "<?= site_url('tmstgljournal/getSummaryData') ?>",
            method: "GET",
            data: {
                batchId: batchId
            },
            dataType: "json",
            success: function(response) {
                if (response.success && response.data) {
                    updateSummaryDisplay(response.data);
                } else {
                    updateSummaryDisplay(null);
                }
            },
            error: function() {
                updateSummaryDisplay(null);
            }
        });
    }

    // =====================================================
    // 20.12 - REFRESH SEMUA SUMMARY
    // =====================================================
    function refreshAllSummaryData() {
        const batchId = $('#cb_batchid').find('option:selected').data('batchid');
        if (batchId) {
            refreshSummaryData(batchId);
        }
        updateSummarySection();
    }

    // =====================================================
    // 20.13 - RESET SUMMARY
    // =====================================================
    function resetSummary() {
        $('#Debits, #Credits, #OutOfBalance').val('0');
    }
</script>

<!-- ===================================================== -->
<!-- BAGIAN 21: FUNGSI IMPORT/EXPORT                       -->
<!-- ===================================================== -->
<script>
    // =====================================================
    // 21.1 - TAMPILKAN PREVIEW IMPORT
    // =====================================================
    function displayPreview(previewData) {
        const totalHeader = previewData.header && previewData.header.length > 0 ? previewData.header.length : 0;
        const totalDetail = previewData.detail ? previewData.detail.length : 0;

        let previewHtml = `
    <div class="row">
        <div class="col-md-6">
            <div class="card preview-count-card h-100">
                <div class="card-header preview-card-header bg-info text-white text-center">
                    <h6 class="mb-0"><i class="fas fa-list-alt mr-2"></i> Journal Header</h6>
                </div>
                <div class="card-body d-flex flex-column justify-content-center">
                    <div class="text-center">
                        <h2 class="preview-count-number text-primary mb-2">${totalHeader}</h2>
                        <h5 class="preview-count-label">Total Batch Entry</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card preview-count-card h-100">
                <div class="card-header preview-card-header bg-success text-white text-center">
                    <h6 class="mb-0"><i class="fas fa-table mr-2"></i> Journal Detail</h6>
                </div>
                <div class="card-body d-flex flex-column justify-content-center">
                    <div class="text-center">
                        <h2 class="preview-count-number text-success mb-2">${totalDetail}</h2>
                        <h5 class="preview-count-label">Total Row</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <div class="alert alert-secondary">
                <h6><i class="fas fa-info-circle mr-2"></i>Preview Information</h6>
                <ul class="mb-0 pl-3">
                    <li>File berisi <strong>${totalHeader}</strong> header entries dan <strong>${totalDetail}</strong> detail rows</li>
                    <li>Klik tombol "Import Data" buat memproses dengan validasi</li>
                </ul>
            </div>
        </div>
    </div>
    `;

        $('#headerPreviewContent').html(previewHtml);
    }

    // =====================================================
    // 21.2 - IMPORT DARI EXCEL
    // =====================================================
    function importFromExcel() {
        const batchId = $('#cb_batchid').find('option:selected').data('batchid');

        if (!batchId) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Pilih Batch Number terlebih dahulu',
                confirmButtonText: 'OK'
            });
            return;
        }

        $('#importBatchIdDisplay').text($('#cb_batchid').find('option:selected').text());

        $('#importForm')[0].reset();
        $('#previewSection').hide();
        $('#btnImport').hide();
        $('#btnPreview').show().prop('disabled', false).html('<i class="fas fa-eye mr-1"></i> Preview');

        $('#validationResults').hide().empty();
        $('#validationNotRun').show();
        $('#validationLoading').hide();
        $('#validationBadge').hide();

        $('#modalImport').modal('show');
    }

    // =====================================================
    // 21.3 - DOWNLOAD TEMPLATE EXCEL
    // =====================================================
    function downloadTemplate() {
        window.location.href = "<?= site_url('tmstgljournal/download') ?>";
    }

    // =====================================================
    // 21.4 - EXPORT KE EXCEL
    // =====================================================
    function exportToExcel() {
        const batchId = $('#cb_batchid').find('option:selected').data('batchid');

        if (!batchId) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Pilih Batch Number dulu',
                confirmButtonText: 'OK'
            });
            return;
        }

        $('#exportBatchIdDisplay').text($('#cb_batchid').find('option:selected').text());

        $('#exportForm')[0].reset();
        $('input[name="exportType"][value="all"]').prop('checked', true);
        toggleRangeFields();

        $('#currentBatchId').text(batchId);
        $('#modalExport').modal('show');
    }

    // =====================================================
    // 21.5 - TOGGLE RANGE FIELDS
    // =====================================================
    function toggleRangeFields() {
        const exportType = $('input[name="exportType"]:checked').val();
        if (exportType === 'range') {
            $('#rangeFields').show();
        } else {
            $('#rangeFields').hide();
        }
    }

    // =====================================================
    // 21.6 - PROSES EXPORT
    // =====================================================
    function processExport() {
        const batchId = $('#cb_batchid').find('option:selected').data('batchid');
        const exportType = $('input[name="exportType"]:checked').val();
        const startRangeBatchEntry = $('#cb_startrangebatchentry').val();
        const endRangeBatchEntry = $('#cb_endrangebatchentry').val();

        if (!batchId) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Batch ID harus dipilih',
                confirmButtonText: 'OK'
            });
            return;
        }

        let url = `<?= site_url('tmstgljournal/export') ?>?batchId=${batchId}&exportType=${exportType}`;

        if (exportType === 'range') {
            url += `&startBatchEntry=${startRangeBatchEntry}&endBatchEntry=${endRangeBatchEntry}`;
        }

        Swal.fire({
            title: 'Exporting Data',
            text: 'Lagi nyiapin file Excel...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        window.location.href = url;

        setTimeout(() => {
            $('#modalExport').modal('hide');
            Swal.close();
        }, 2000);
    }

    // =====================================================
    // 21.7 - PREVIEW DAN VALIDASI IMPORT
    // =====================================================
    function previewAndValidate() {
        const currentBatchId = $('#cb_batchid').find('option:selected').data('batchid');
        const fileInput = document.getElementById('importFile');
        const file = fileInput.files[0];

        if (!validateImportPrerequisites(currentBatchId, file)) {
            return;
        }

        setupPreviewUI();

        const formData = new FormData();
        formData.append('filename', file);
        formData.append('batchId', currentBatchId);
        formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

        $.ajax({
            url: "<?= site_url('tmstgljournal/preview') ?>",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "JSON",
            success: handlePreviewResponse,
            error: function(xhr, status, error) {
                handleImportError('Error pas preview: ' + error);
            }
        });
    }

    // =====================================================
    // 21.8 - HANDLE PREVIEW RESPONSE
    // =====================================================
    function handlePreviewResponse(response) {
        $('#btnPreview').prop('disabled', false);
        $('#validationLoading').hide();

        if (response.success) {
            displayPreview(response.preview);

            $('#btnPreview').hide();
            $('#btnImport').show();

            Swal.fire({
                icon: 'success',
                title: 'Preview Berhasil',
                text: 'Data siap diimport. Klik tombol Import Data untuk memproses.',
                confirmButtonText: 'OK'
            });
        } else {
            showPreviewError(response.message || 'Gagal memproses file');
        }
    }

    function handlePreviewError(message, responseText) {
        $('#btnPreview').prop('disabled', false).html('<i class="fas fa-eye mr-1"></i> Preview');
        $('#validationLoading').hide();

        let errorMsg = message;
        try {
            if (responseText) {
                const errorData = JSON.parse(responseText);
                if (errorData.message) errorMsg = errorData.message;
                if (errorData.error) errorMsg = errorData.error;
            }
        } catch (e) {
            if (responseText) errorMsg = responseText;
        }

        showPreviewError(errorMsg);
    }

    // =====================================================
    // 21.9 - PROSES IMPORT
    // =====================================================
    function processImport() {
        const currentBatchId = $('#cb_batchid').find('option:selected').data('batchid');
        const fileInput = document.getElementById('importFile');
        const file = fileInput.files[0];

        if (!validateImportPrerequisites(currentBatchId, file)) {
            return;
        }

        Swal.fire({
            icon: 'question',
            title: 'Konfirmasi Import',
            text: 'Data bakal divalidasi dan diproses. Lanjutin?',
            showCancelButton: true,
            confirmButtonText: 'Ya, Import Data',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {
                executeImport(currentBatchId, file);
            }
        });
    }

    // =====================================================
    // 21.10 - VALIDASI PRASYARAT IMPORT
    // =====================================================
    function validateImportPrerequisites(batchId, file) {
        if (!batchId) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Pilih Batch Number dulu',
                confirmButtonText: 'OK'
            });
            return false;
        }

        if (!file) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Pilih file dulu',
                confirmButtonText: 'OK'
            });
            return false;
        }

        const allowedExtensions = ['xlsx', 'xls', 'csv'];
        const fileName = file.name;
        const fileExt = fileName.split('.').pop().toLowerCase();

        if (!allowedExtensions.includes(fileExt)) {
            Swal.fire({
                icon: 'warning',
                title: 'Format File Ga Didukung',
                text: 'Format file harus: ' + allowedExtensions.join(', '),
                confirmButtonText: 'OK'
            });
            return false;
        }

        const maxSize = 10 * 1024 * 1024;
        if (file.size > maxSize) {
            Swal.fire({
                icon: 'warning',
                title: 'File Kebesaran',
                text: 'Ukuran file maksimal 10mb',
                confirmButtonText: 'OK'
            });
            return false;
        }

        return true;
    }


    // =====================================================
    // 21.11 - SETUP UI IMPORT
    // =====================================================
    function setupImportUI() {
        $('#btnPreviewValidate').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Processing...');
        $('#previewSection').show();
        $('#validationResults, #validationNotRun').hide();
        $('#validationLoading').show();
        $('#validationBadge').hide();

        $('#headerPreviewContent').html(`
    <div class="text-center py-4">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <p class="mt-2">Loading preview and validating data...</p>
    </div>
    `);
    }

    // =====================================================
    // 21.12 - EKSEKUSI IMPORT
    // =====================================================
    function executeImport(batchId, file) {
        $('#btnImport').prop('disabled', true);
        $('#btnPreview').hide();

        $('#validationLoading').show();
        $('#validationNotRun').hide();
        $('#validationResults').hide();
        $('#validationBadge').hide();

        const formData = new FormData();
        formData.append('filename', file);
        formData.append('batchId', batchId);
        formData.append('action', 'import');
        formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

        $.ajax({
            url: "<?= site_url('tmstgljournal/upload') ?>",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "JSON",
            success: function(response) {
                $('#btnImport').prop('disabled', false);
                $('#validationLoading').hide();

                if (response.success) {
                    showImportSuccess(response, batchId);
                } else {
                    showValidationErrors(response);
                    $('#validation-tab').tab('show');
                }
            },
            error: function(xhr, status, error) {
                $('#btnImport').prop('disabled', false).html('Import Data');
                $('#btnPreview').show().prop('disabled', false).html('<i class="fas fa-eye mr-1"></i> Preview');
                $('#validationLoading').hide();

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ada kesalahan saat import: ' + error,
                    confirmButtonText: 'OK'
                });
            }
        });
    }

    // =====================================================
    // 21.13 - TAMPILKAN ERROR PREVIEW
    // =====================================================
    function showPreviewError(message) {
        $('#headerPreviewContent').html(`
        <div class="alert alert-danger">
            <h5><i class="fas fa-exclamation-circle mr-2"></i>Error</h5>
            <p class="mb-0">${escapeHtml(message) || 'Ada kesalahan pas memproses file'}</p>
        </div>
    `);
        $('#btnImport').hide();
        $('#validationLoading').hide();

        Swal.fire({
            icon: 'error',
            title: 'Gagal Memproses',
            text: message || 'Ada kesalahan pas memproses file',
            confirmButtonText: 'OK'
        });
    }


    function showPreviewError(message) {
        $('#headerPreviewContent').html(`
        <div class="alert alert-danger">
            <h5><i class="fas fa-exclamation-circle mr-2"></i>Error</h5>
            <p class="mb-0">${message || 'Ada kesalahan pas memproses file'}</p>
        </div>
    `);
        $('#btnImport').hide();

        Swal.fire({
            icon: 'error',
            title: 'Gagal Memproses',
            text: message || 'Ada kesalahan pas memproses file',
            confirmButtonText: 'OK'
        });
    }

    // =====================================================
    // 21.14 - HANDLE IMPORT RESPONSE
    // =====================================================
    function handleImportResponse(response, batchId) {
        $('#btnImport').prop('disabled', false).html('Import Data');

        if (response.success) {
            showImportSuccess(response, batchId);
        } else {
            showImportError(response);
        }
    }

    // =====================================================
    // 21.15 - TAMPILKAN SUKSES IMPORT
    // =====================================================
    function showImportSuccess(response, batchId) {
        let successMessage = response.message || 'Data berhasil diimport';

        if (response.stats) {
            successMessage = `Import Berhasil!\n\n`;
        }

        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: successMessage,
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                refreshAfterImport(batchId);
                resetImportModal();
            }
        });
    }

    function showValidationErrors(response) {
        // Tampilkan badge di tab validation
        $('#validationBadge').show();

        // SEMBUNYIKAN TOMBOL IMPORT, TAMPILKAN TOMBOL PREVIEW
        $('#btnImport').hide();
        $('#btnPreview').show().prop('disabled', false).html('<i class="fas fa-eye mr-1"></i> Preview');

        let errorHtml = '<div class="validation-error-container">';

        let totalErrors = 0;
        let errorsByBatch = {};

        if (response.validation_details && response.validation_details.errors_by_batch) {
            errorsByBatch = response.validation_details.errors_by_batch;

            Object.keys(errorsByBatch).forEach(key => {
                totalErrors += errorsByBatch[key].length;
            });
        }

        // Header dengan ringkasan
        errorHtml += `
        <div class="alert alert-danger">
            <h5><i class="fas fa-exclamation-triangle mr-2"></i>Data Tidak Sesuai</h5>
            <p class="mb-0">${response.message || 'Data tidak lolos validasi'}</p>
            <hr>
            <p class="mb-0">
                <strong>Total Validasi:</strong> ${totalErrors} error
            </p>
        </div>
    `;

        // Tampilkan error dalam tabel 3 kolom
        let batchKeys = Object.keys(errorsByBatch);

        if (batchKeys.length > 0) {
            errorHtml += `
            <div class="table-responsive mt-3">
                <table class="table table-bordered table-hover" style="width:100%">
                    <thead class="bg-secondary text-white" style="position: sticky; top: 0; z-index: 10;">
                        <tr>
                            <th class="text-center" style="width: 15%">Batch ID</th>
                            <th class="text-center" style="width: 15%">Batch Entry</th>
                            <th>Validation Message</th>
                        </tr>
                    </thead>
                    <tbody>
        `;

            batchKeys.forEach(key => {
                let batchErrors = errorsByBatch[key] || [];

                let excelBatchId = 'Unknown';
                let excelBatchEntry = 'Unknown';

                if (batchErrors.length > 0 && batchErrors[0].excelBatchId) {
                    excelBatchId = batchErrors[0].excelBatchId;
                    excelBatchEntry = batchErrors[0].excelBatchEntry;
                }

                batchErrors.forEach((error, index) => {
                    let cleanMessage = error.errorMessage || error;

                    if (typeof cleanMessage === 'string') {
                        cleanMessage = cleanMessage
                            .replace('[Journal Header] ', '')
                            .replace('[Journal Detail] ', '');
                    } else {
                        cleanMessage = error;
                    }

                    errorHtml += `
                    <tr>
                        <td class="text-center align-middle">${escapeHtml(excelBatchId)}</td>
                        <td class="text-center align-middle">${escapeHtml(excelBatchEntry)}</td>
                        <td>${escapeHtml(cleanMessage)}</td>
                    </tr>
                `;
                });
            });

            errorHtml += `
                </tbody>
            </table>
        </div>
        `;
        } else {
            if (response.errors && response.errors.length > 0) {
                errorHtml += '<div class="mt-4">';
                errorHtml += '<h6 class="border-bottom pb-2 mb-3"><i class="fas fa-list mr-2"></i>Daftar Error:</h6>';
                errorHtml += '<ul class="list-group">';

                response.errors.forEach(error => {
                    let cleanError = error
                        .replace('[Journal Header] ', '')
                        .replace('[Journal Detail] ', '');
                    errorHtml += `<li class="list-group-item list-group-item-danger">${escapeHtml(cleanError)}</li>`;
                });

                errorHtml += '</ul></div>';
            } else {
                errorHtml += '<div class="alert alert-warning mt-3">Tidak ada error yang dapat ditampilkan</div>';
            }
        }

        errorHtml += '</div>';

        $('#validationResults').html(errorHtml).show();
        $('#validationNotRun').hide();

        $('#validation-tab').html(`
        <i class="fas fa-check-circle mr-1"></i> Validation Results
        <span class="badge badge-danger ml-1">${totalErrors}</span>
    `);

        $('.modal-body').animate({
            scrollTop: 0
        }, 500);

        Swal.fire({
            icon: 'warning',
            title: 'Import Data Gagal',
            html: response.message + '<br><br>' +
                'Total <strong>' + totalErrors + '</strong> validasi ditemukan',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#validation-tab').tab('show');
            }
        });
    }

    function extractBatchEntryFromError(errorMessage) {
        if (!errorMessage) return null;

        let patterns = [
            /BatchEntry['"]?\s*:\s*['"]?([0-9]+)['"]?/i,
            /BatchEntry['"]?\s*=\s*['"]?([0-9]+)['"]?/i,
            /BatchEntry\s+([0-9]+)/i,
            /JournalId['"]?\s*:\s*['"]?([0-9]+)['"]?/i,
            /pada\s+BatchEntry\s+([0-9]+)/i,
            /BatchEntry:\s*([0-9]+)/i
        ];

        for (let pattern of patterns) {
            let match = errorMessage.match(pattern);
            if (match && match[1]) {
                return match[1];
            }
        }

        return null;
    }

    // =====================================================
    // 21.16 - TAMPILKAN ERROR IMPORT
    // =====================================================
    function showImportError(response) {
        let errorMessage = response.message;
        if (response.errors && response.errors.length > 0) {
            errorMessage += '\n\n' + response.errors.join('\n');
        }

        Swal.fire({
            icon: 'error',
            title: 'Import Gagal',
            html: errorMessage.replace(/\n/g, '<br>'),
            confirmButtonText: 'OK'
        });
    }

    // =====================================================
    // 21.17 - HANDLE ERROR IMPORT
    // =====================================================
    function handleImportError(errorMessage) {
        $('#btnImport').prop('disabled', false).html('Import Data');
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: errorMessage,
            confirmButtonText: 'OK'
        });
    }

    // =====================================================
    // 21.18 - RESET MODAL IMPORT
    // =====================================================
    function resetImportModal() {
        $('#modalImport').modal('hide');
        $('#importForm')[0].reset();
        $('#previewSection').hide();
        $('#btnImport').hide();
        $('#btnPreview').show().prop('disabled', false).html('<i class="fas fa-eye mr-1"></i> Preview');
        $('#headerPreviewContent').empty();

        $('#validationResults').hide().empty();
        $('#validationNotRun').show();
        $('#validationLoading').hide();
        $('#validationBadge').hide();

        $('#summary-tab').tab('show');
    }

    function escapeHtml(text) {
        if (!text) return '';
        var div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // =====================================================
    // 21.19 - REFRESH SETELAH IMPORT
    // =====================================================
    function refreshAfterImport(batchId) {
        if ($.fn.DataTable.isDataTable('#gljournallistTable')) {
            $('#gljournallistTable').DataTable().ajax.reload(null, false);
        }

        if (batchId) {
            $('#cb_batchentry').prop('disabled', true).html('<option value="">Loading...</option>');

            $.ajax({
                url: "<?= site_url('tmstgljournal/getBatchEntry') ?>",
                method: "GET",
                data: {
                    batchId: batchId
                },
                dataType: "JSON",
                success: function(response) {
                    let options = '<option value="">--Select--</option>';
                    let hasData = false;

                    if (response.success && response.data && response.data.length > 0) {
                        response.data.sort((a, b) => parseInt(b.value) - parseInt(a.value));

                        response.data.forEach(function(item) {
                            if (item.value && item.desc) {
                                options += `<option value="${item.value}"
                                data-batchid="${batchId}"
                                data-entrynumber="${item.desc}">
                                ${item.desc}</option>`;
                                hasData = true;
                            }
                        });
                    }

                    $('#cb_batchentry')
                        .html(options)
                        .prop('disabled', false);

                    setTimeout(() => updateAddOptionVisibility(), 100);
                },
                error: function() {
                    $('#cb_batchentry')
                        .html('<option value="">Error loading data</option>')
                        .prop('disabled', false);
                }
            });
        }

        setTimeout(() => {
            $('#cb_batchid').trigger('change');
            if (typeof refreshSummaryData === 'function') {
                refreshSummaryData(batchId);
            }
            if (typeof updateSummarySection === 'function') {
                setTimeout(updateSummarySection, 1000);
            }
        }, 1000);

        setTimeout(() => {
            if (typeof loadFromLocalStorage === 'function') {
                loadFromLocalStorage();
            }
        }, 800);
    }

    // =====================================================
    // 21.20 - SETUP PREVIEW UI
    // =====================================================
    function setupPreviewUI() {
        $('#btnPreview').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Loading...');
        $('#btnImport').hide();
        $('#previewSection').show();
        $('#validationLoading').show();
        $('#validationResults').hide();
        $('#validationNotRun').hide();

        $('#headerPreviewContent').html(`
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <p class="mt-2">Loading preview data...</p>
        </div>
    `);
    }
</script>

<!-- ===================================================== -->
<!-- BAGIAN 22: FUNGSI AUTO SELECT BATCH DARI URL          -->
<!-- ===================================================== -->
<script>
    // =====================================================
    // 22.1 - AUTO SELECT BATCH DARI URL
    // =====================================================
    function autoSelectBatchFromUrl() {
        const urlParams = new URLSearchParams(window.location.search);
        const batchIdFromUrl = urlParams.get('batchId');

        if (batchIdFromUrl) {
            const batchOption = $(`#cb_batchid option[value="${batchIdFromUrl}"]`);

            if (batchOption.length > 0) {
                $('#cb_batchid').val(batchIdFromUrl).trigger('change');
                const newUrl = window.location.pathname;
                window.history.replaceState({}, document.title, newUrl);
            } else {
                setTimeout(() => {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Batch Ga Ketemu',
                        text: `Batch ID ${batchIdFromUrl} ga ada dalam daftar.`,
                        confirmButtonText: 'OK'
                    });
                }, 1000);
            }
        }
    }

    // =====================================================
    // 22.2 - AUTO SELECT BATCH DARI URL DI MODAL
    // =====================================================
    function autoSelectBatchFromUrlModal() {
        const urlParams = new URLSearchParams(window.location.search);
        const batchIdFromUrl = urlParams.get('batchId');

        if (batchIdFromUrl) {
            setTimeout(() => {
                const batchOption = $(`#cb_batchid option[value="${batchIdFromUrl}"]`);
                if (batchOption.length > 0) {
                    $('#cb_batchid').val(batchIdFromUrl).trigger('change');

                    setTimeout(() => {
                        const batchEntryValue = $('#cb_batchentry').val();
                        if (batchEntryValue && batchEntryValue !== '' && batchEntryValue !== '__add__') {
                            toggleArrowButtons(true);
                        }
                    }, 1000);
                }
            }, 1500);
        }
    }
</script>

<!-- ===================================================== -->
<!-- BAGIAN 23: FUNGSI VIEW/EDIT/DELETE DATABASE DATA      -->
<!-- ===================================================== -->
<script>
    // =====================================================
    // 23.1 - TAMPILKAN ERROR ALERT
    // =====================================================
    function showErrorAlert(title, text) {
        Swal.fire({
            icon: 'error',
            title: title,
            text: text
        });
    }

    // =====================================================
    // 23.2 - EDIT DATA DARI DATABASE
    // =====================================================
    $(document).on('click', '.edit', function() {
        const BatchId = $(this).data('batchid');
        const BatchEntry = $(this).data('batchentry');
        const TransNbr = $(this).data('transnbr');

        const saveButton = $('#modalform').find('button[onclick="validateAndSaveJournalEntry()"]');
        saveButton.prop('disabled', false).html('Simpan');

        if (hasSoftEdit(BatchId, BatchEntry, TransNbr)) {
            const softEditData = getSoftEdit(BatchId, BatchEntry, TransNbr);

            resetFormToInitialState();

            setFormData(softEditData, true, false, true);

            setupAmountSync();

            $('.modal-title').text('Edit Journal Entry (Soft Edit)');
            $('#action').val('EditSoft');
            $('#hidden_id').val(BatchId);

            currentEditTransaction = {
                batchId: BatchId,
                batchEntry: BatchEntry,
                transNbr: TransNbr,
                element: this,
                isSoftEdit: true
            };

            $('#modalform').modal('show');
            return;
        }

        $.ajax({
            url: "<?= site_url('tmstgljournal/fetchSingleData'); ?>",
            method: "GET",
            data: {
                BatchId: BatchId,
                BatchEntry: BatchEntry,
                TransNbr: TransNbr
            },
            dataType: "JSON",
            success: function(response) {

                if (response.success) {
                    resetFormToInitialState();
                    setFormData(response.data, true, false, false);
                    setupAmountSync();

                    $('.modal-title').text('Edit Journal Entry - Line ' + response.data.TransNbr);
                    $('#action').val('Edit');
                    $('#hidden_id').val(BatchId);

                    currentEditTransaction = {
                        batchId: BatchId,
                        batchEntry: BatchEntry,
                        transNbr: TransNbr,
                        element: this,
                        isSoftEdit: false,
                        originalData: response.data
                    };

                    $('#modalform').modal('show');
                } else {
                    showErrorAlert('Gagal', response.message || 'Gagal ngambil data');
                }
            },
            error: function(xhr, status, error) {
                showErrorAlert('Gagal ngambil data', 'Ada kesalahan pas ngambil data Journal Entry.');
            }
        });
    });

    // =====================================================
    // 23.3 - VIEW DATA DARI DATABASE
    // =====================================================
    $(document).on('click', '.view', function() {
        const BatchId = $(this).data('batchid');
        const BatchEntry = $(this).data('batchentry');
        const TransNbr = $(this).data('transnbr');

        $.ajax({
            url: "<?= site_url('tmstgljournal/fetchSingleData'); ?>",
            method: "GET",
            data: {
                BatchId,
                BatchEntry,
                TransNbr
            },
            dataType: "JSON",
            success: function(response) {
                if (response.success) {
                    resetFormToInitialState();
                    setFormData(response.data, false, true);

                    $('.modal-title').text('View Journal Entry - Line ' + (response.data.transNbr || response.data.TransNbr));
                    $('#action').val('View');
                    $('#hidden_id').val(BatchId);

                    setTimeout(() => {
                        $('button:contains("Simpan"), button[onclick="validateAndSaveJournalEntry()"]').hide();
                    }, 100);

                    $('#modalform').modal('show');
                } else {
                    showErrorAlert('Gagal', response.message || 'Gagal ngambil data');
                }
            },
            error: function() {
                showErrorAlert('Gagal liat data', 'Ada kesalahan pas ngambil data Journal Entry.');
            }
        });
    });

    // =====================================================
    // 23.4 - DELETE DATA DARI DATABASE (SOFT DELETE)
    // =====================================================
    $(document).on('click', '.delete', function(e) {
        e.preventDefault();
        e.stopPropagation();

        const batchId = $(this).data('batchid');
        const batchEntry = $(this).data('batchentry');
        const transNbr = $(this).data('transnbr');

        softDeleteJournalEntry(null, batchId, batchEntry, transNbr, this);
    });

    // =====================================================
    // 23.5 - EDIT DATA DARI DATABASE (LANGSUNG)
    // =====================================================
    function editDatabaseEntry(batchId, batchEntry, transNbr) {
        $.ajax({
            url: "<?= base_url('tmstgljournal/fetchSingleData') ?>",
            method: "GET",
            data: {
                batchId: batchId,
                batchEntry: batchEntry,
                transNbr: transNbr
            },
            dataType: "json",
            beforeSend: function() {
                $('#modalform').modal('show');
                $('.modal-body').html('<div class="text-center"><i class="fas fa-spinner fa-spin fa-2x"></i><p>Loading data...</p></div>');
            },
            success: function(response) {
                if (response.success && response.data) {
                    fillFormForEdit(response.data);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Gagal muat data',
                        confirmButtonText: 'OK'
                    });
                    $('#modalform').modal('hide');
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error Koneksi',
                    text: 'Ada kesalahan pas muat data: ' + error,
                    confirmButtonText: 'OK'
                });
                $('#modalform').modal('hide');
            }
        });
    }

    // =====================================================
    // 23.6 - ISI FORM UNTUK EDIT
    // =====================================================
    function fillFormForEdit(data) {
        $('#data_form')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
        $('[class^="error"]').html('');

        $('#LineNumber').val(data.transNbr || data.lineNumber || '').prop('readonly', true);
        $('#TransRef').val(data.transRef || '').prop('readonly', false);
        $('#TransDesc').val(data.transDesc || '').prop('readonly', false);
        $('#AcctId').val(data.acctId || '').prop('readonly', true);
        $('#AcctName').val(data.acctName || '').prop('readonly', true);

        $('#cb_scurncode').val(data.scurnCode || '').prop('disabled', false);
        $('#ConvRate').val(data.convRate || '').prop('readonly', false);
        $('#RateDate').val(formatDateDDMMYYYY(data.rateDate || '')).prop('readonly', false);

        $('#ScurnAmtDebit').val(data.scurnAmt > 0 ? Math.abs(data.scurnAmt) : '').prop('readonly', false);
        $('#ScurnAmtCredit').val(data.scurnAmt < 0 ? Math.abs(data.scurnAmt) : '').prop('readonly', false);
        $('#TransAmtDebit').val(data.transAmt > 0 ? Math.abs(data.transAmt) : '').prop('readonly', false);
        $('#TransAmtCredit').val(data.transAmt < 0 ? Math.abs(data.transAmt) : '').prop('readonly', false);

        $('#Comment').val(data.comment || '').prop('readonly', false);

        $('#JournalId').val(data.journalId || '');
        $('#BatchId').val(data.batchId || '');
        $('#BatchEntry').val(data.batchEntry || '');
        $('#HcurnCode').val(data.hcurnCode || data.scurnCode || '');

        $('#btnSearchAccount').show();
        $('#btnNormalModeModal, #btnQuickModeModal').css('visibility', 'visible');

        const saveButton = $('#modalform').find('button[onclick="validateAndSaveJournalEntry()"]');
        saveButton.show().prop('disabled', false).html('Update');

        editIndex = null;
        currentEntryMode = 'edit';

        const dataEntryValue = $('#DataEntry').val();
        const rateDateValue = formatDateDDMMYYYY(data.rateDate || '');
        isRateDateManuallyEdited = (rateDateValue && dataEntryValue && rateDateValue !== dataEntryValue);

        $('.modal-title').text('Edit Journal Entry');

        $('#modalform').modal('show');
    }
</script>

<!-- ===================================================== -->
<!-- BAGIAN 24: FUNGSI VIEW/EDIT/DELETE LOCAL DATA         -->
<!-- ===================================================== -->
<script>
    // =====================================================
    // 24.1 - VIEW JOURNAL ENTRY LOKAL
    // =====================================================
    window.viewJournalEntry = function(localId) {
        const entry = journalEntries.find(entry => entry.localId === localId);
        if (!entry) return;

        $('#data_form')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
        $('[class^="error"]').html('');

        $('#LineNumber').val(entry.lineNumber).prop('readonly', true);
        $('#TransRef').val(entry.TransRef).prop('readonly', true);
        $('#TransDesc').val(entry.TransDesc).prop('readonly', true);
        $('#AcctId').val(entry.AcctId).prop('readonly', true);
        $('#btnSearchAccount').hide();
        $('#btnNormalModeModal, #btnQuickModeModal').css('visibility', 'hidden');
        $('#AcctDesc').val(entry.AcctDesc).prop('readonly', true);

        $('#ScurnAmtDebit').val(entry.ScurnAmtDebit || '').prop('readonly', true);
        $('#ScurnAmtCredit').val(entry.ScurnAmtCredit || '').prop('readonly', true);
        $('#TransAmtDebit').val(entry.TransAmtDebit || '').prop('readonly', true);
        $('#TransAmtCredit').val(entry.TransAmtCredit || '').prop('readonly', true);

        $('#ConvRate').val(entry.ConvRate).prop('readonly', true);
        $('#RateDate').val(entry.RateDate).prop('readonly', true);
        $('#Comment').val(entry.Comment).prop('readonly', true);
        $('#JournalId').val(entry.JournalId).prop('readonly', true);
        $('#cb_scurncode').val(entry.ScurnCode).prop('disabled', true);
        $('#AudtUser').val(entry.AudtUser || userId).prop('readonly', true);
        $('#AudtTime').val(entry.AudtTime || new Date().toISOString()).prop('readonly', true);

        $('#SrceId').val(entry.SrceId).prop('disabled', true);
        $('#SrceLedger').val(entry.SrceLedger).prop('disabled', true);
        $('#SrceType').val(entry.SrceType).prop('disabled', true);
        $('#SrceDesc').val(entry.SrceDesc).prop('disabled', true);

        $('#action').val('View');
        $('#submit_button, button:contains("Simpan")').hide();

        $('.modal-title').text('View Journal Entry');
        $('#modalform').modal('show');
    };

    // =====================================================
    // 24.2 - EDIT JOURNAL ENTRY LOKAL
    // =====================================================
    window.editJournalEntry = function(localId) {
        const entryIndex = journalEntries.findIndex(entry => entry.localId === localId);
        if (entryIndex === -1) {
            console.error('Entry ga ketemu di journalEntries:', localId);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Data tidak ditemukan',
                confirmButtonText: 'OK'
            });
            return;
        }

        const entry = journalEntries[entryIndex];

        resetFormToInitialState();

        $('#LineNumber').val(entry.lineNumber);
        $('#TransRef').val(entry.TransRef || '');
        $('#TransDesc').val(entry.TransDesc || '');
        $('#AcctId').val(entry.AcctId || '');
        $('#AcctName').val(entry.AcctName || '');

        if (entry.ScurnCode) {
            $('#cb_scurncode').val(entry.ScurnCode).trigger('change');
        }

        $('#ConvRate').val(entry.ConvRate || 1);
        $('#RateDate').val(entry.RateDate || '');

        $('#ScurnAmtDebit').val(entry.ScurnAmtDebit ? entry.ScurnAmtDebit.toString().replace(/\.00$/, '') : '');
        $('#ScurnAmtCredit').val(entry.ScurnAmtCredit ? entry.ScurnAmtCredit.toString().replace(/\.00$/, '') : '');
        $('#TransAmtDebit').val(entry.TransAmtDebit ? entry.TransAmtDebit.toString().replace(/\.00$/, '') : '');
        $('#TransAmtCredit').val(entry.TransAmtCredit ? entry.TransAmtCredit.toString().replace(/\.00$/, '') : '');

        $('#Comment').val(entry.Comment || '');
        $('#JournalId').val(entry.JournalId || '');
        $('#AudtUser').val(entry.AudtUser || userId);
        $('#AudtTime').val(entry.AudtTime || new Date().toISOString());
        $('#ScurnCode').val(entry.ScurnCode || '');

        editIndex = entryIndex;
        currentEditTransaction = null;

        $('#action').val('EditLocal');
        $('.modal-title').text('Edit Journal Entry (Local Data)');

        const saveButton = $('#modalform').find('button[onclick="validateAndSaveJournalEntry()"]');
        saveButton.show().prop('disabled', false).html('Update');

        setupAmountSync();
        updateLockState();

        if ((entry.ScurnAmtDebit && parseFloat(entry.ScurnAmtDebit) > 0) ||
            (entry.TransAmtDebit && parseFloat(entry.TransAmtDebit) > 0)) {
            $('#ScurnAmtCredit, #TransAmtCredit').prop('readonly', true);
        } else if ((entry.ScurnAmtCredit && parseFloat(entry.ScurnAmtCredit) > 0) ||
            (entry.TransAmtCredit && parseFloat(entry.TransAmtCredit) > 0)) {
            $('#ScurnAmtDebit, #TransAmtDebit').prop('readonly', true);
        }

        $('#modalform').modal('show');
    };

    // =====================================================
    // 24.3 - DELETE JOURNAL ENTRY LOKAL
    // =====================================================
    window.deleteJournalEntry = function(localId) {
        const currentBatchId = $('#cb_batchid').find('option:selected').data('batchid');
        const currentBatchEntry = $('#cb_batchentry').val();

        Swal.fire({
            icon: 'warning',
            title: 'Konfirmasi Hapus',
            text: 'Apakah kamu yakin mau menghapus data ini?',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6'
        }).then((result) => {
            if (result.isConfirmed) {
                const entryIndex = journalEntries.findIndex(entry => entry.localId === localId);

                if (entryIndex !== -1) {
                    journalEntries.splice(entryIndex, 1);
                    saveToLocalStorage();
                    $(`tr.temp-data input[data-localid="${localId}"]`).closest('tr').remove();
                    toggleSummarySection();
                    setTimeout(() => updateSummarySection(), 100);

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Data berhasil dihapus',
                        confirmButtonText: 'OK'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Data ga ketemu',
                        confirmButtonText: 'OK'
                    });
                }
            }
        });
    };
</script>

<!-- ===================================================== -->
<!-- BAGIAN 25: EVENT HANDLERS UTAMA                       -->
<!-- ===================================================== -->
<script>
    $(document).ready(function() {
        // =================================================
        // 25.1 - INISIALISASI VARIABEL
        // =================================================

        // =================================================
        // 25.2 - SETUP DATEPICKER
        // =================================================

        // =================================================
        // 25.3 - SETUP AWAL
        // =================================================
        $('#AudtUser').val(userId);
        $('#cb_batchid').data('previous-value', currentBatchId);
        $('#cb_batchentry').data('previous-value', currentBatchEntry);

        $('#cb_srceledger')
            .prop('disabled', true)
            .css({
                'background-color': '#e9ecef',
                'cursor': 'not-allowed'
            });

        disableSelect2('#cb_srcetype', true);

        $('#cb_batchentry')
            .prop('disabled', true)
            .css({
                'background-color': '#e9ecef',
                'cursor': 'not-allowed'
            });

        $('#JrnlDesc')
            .prop('readonly', true)
            .css('background-color', '#e9ecef');

        $('#DataEntry, #PostDate, #YearPeriod')
            .prop('disabled', true)
            .css('background-color', '#e9ecef');

        $('#SrceDesc').val('');

        loadFromLocalStorage();

        setTimeout(() => {
            checkBatchStatForButtons();
            checkBatchEntryDeletedStatus();
            toggleSummarySection();
        }, 1000);

        // =================================================
        // 25.4 - EVENT HANDLER: CB_SRCETYPE CHANGE
        // =================================================
        $('#cb_srcetype').on('change', function() {
            const srceLedger = $('#cb_srceledger').val();
            const srceType = $(this).val();
            const currentBatchId = $('#cb_batchid').find('option:selected').data('batchid');

            if (srceLedger && srceType) {
                $('#SrceDesc').val('');

                getSrceDescription(srceLedger, srceType, function(srceDesc) {
                    const newBatchId = $('#cb_batchid').find('option:selected').data('batchid');
                    if (srceDesc && newBatchId === currentBatchId) {
                        $('#SrceDesc').val(srceDesc);
                    }
                });
            }
        });

        // =================================================
        // 25.5 - EVENT HANDLER: CB_SRCELEDGER CHANGE
        // =================================================
        $('#cb_srceledger').on('change', function() {
            const srceLedger = $(this).val();
            const srceType = $('#cb_srcetype').val();
            const currentBatchId = $('#cb_batchid').find('option:selected').data('batchid');

            if (srceLedger && srceType) {
                $('#SrceDesc').val('');

                getSrceDescription(srceLedger, srceType, function(srceDesc) {
                    const newBatchId = $('#cb_batchid').find('option:selected').data('batchid');
                    if (srceDesc && newBatchId === currentBatchId) {
                        $('#SrceDesc').val(srceDesc);
                    }
                });
            }
        });

        // =================================================
        // 25.6 - EVENT HANDLER: DATA ENTRY CHANGE
        // =================================================
        $('#DataEntry').on('change', function() {
            const dataEntryValue = $(this).val();
            if (dataEntryValue) {
                updatePostDateFromDataEntry();
                updateRateDateFromDataEntry();
            } else {
                $('#PostDate, #YearPeriod, #RateDate').val('');
            }
        });

        // =================================================
        // 25.7 - EVENT HANDLER: POST DATE CHANGE
        // =================================================
        $('#PostDate').on('change', function() {
            const postDateValue = $(this).val();
            const dataEntryValue = $('#DataEntry').val();

            if (postDateValue && dataEntryValue && postDateValue !== dataEntryValue) {
                isPostDateManuallyEdited = true;
            }
            if (postDateValue && dataEntryValue && postDateValue === dataEntryValue) {
                isPostDateManuallyEdited = false;
            }
        });

        // =================================================
        // 25.8 - EVENT HANDLER: MODAL FORM SHOW
        // =================================================
        $('#modalform').on('show.bs.modal', function() {
            const saveButton = $('button[onclick="validateAndSaveJournalEntry()"]');
            saveButton.show().prop('disabled', false).html('Simpan');

            if ($('#action').val() === 'View') {
                saveButton.hide();
            }

            $('#amountValidationAlert').hide();
            $('#amountValidationMessage').text('');
        });

        // =================================================
        // 25.9 - EVENT HANDLER: MODAL FORM SHOWN
        // =================================================
        $('#modalform').on('shown.bs.modal', function() {
            setTimeout(() => {
                if (isNewEntry && !isRateDateManuallyEdited) {
                    updateRateDateFromDataEntry();
                }
            }, 100);
        });

        // =================================================
        // 25.10 - EVENT HANDLER: MODAL FORM HIDDEN
        // =================================================
        $('#modalform').on('hidden.bs.modal', function() {
            resetFormToInitialState();
            clearSelection();

            const saveButton = $('button[onclick="validateAndSaveJournalEntry()"]');
            saveButton.show().prop('disabled', false).html('Simpan');

            isNewEntry = false;
            currentEntryMode = 'normal';

            $('#ScurnAmtDebit, #ScurnAmtCredit, #TransAmtDebit, #TransAmtCredit').prop('readonly', false);

            setTimeout(setupAmountSync, 200);
            setTimeout(updateSummarySection, 200);
        });

        // =================================================
        // 25.11 - EVENT HANDLER: RATE DATE CHANGE
        // =================================================
        $('#modalform').on('change', '#RateDate', function() {
            const rateDateValue = $(this).val();
            const dataEntryValue = $('#DataEntry').val();

            if (rateDateValue && dataEntryValue && rateDateValue !== dataEntryValue) {
                isRateDateManuallyEdited = true;
            }
            if (rateDateValue && dataEntryValue && rateDateValue === dataEntryValue) {
                isRateDateManuallyEdited = false;
            }
        });

        // =================================================
        // 25.12 - EVENT HANDLER: ADD RECORD CLICK
        // =================================================
        $(document).on('click', '#add_record', function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            const batchId = $('#cb_batchid').find('option:selected').data('batchid');
            const batchEntry = $('#cb_batchentry').val();

            if (!batchId || !batchEntry) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Pilih Batch Number dan Entry Number dulu',
                    confirmButtonText: 'OK'
                });
                return false;
            }

            $('#data_form')[0].reset();
            $('.is-invalid').removeClass('is-invalid');
            $('[class^="error"]').html('');

            $('#TransRef, #TransDesc, #RateDate, #ScurnAmtDebit, #ScurnAmtCredit, #TransAmtDebit, #TransAmtCredit, #Comment')
                .prop('readonly', false);
            $('#LineNumber, #AcctId, #AcctDesc, #ConvRate').prop('readonly', true);
            $('#cb_scurncode').prop('disabled', false);

            $('#btnSearchAccount, #btnNormalModeModal, #btnQuickModeModal').show();

            $('.modal-title').text('Tambah Data');
            $('#action').val('Add');

            isNewEntry = true;
            isRateDateManuallyEdited = false;
            currentEntryMode = 'normal';

            getNextLineNumber(batchId, batchEntry).then(nextLine => {
                $('#LineNumber').val(nextLine);
                updateRateDateFromDataEntry();
                $('#modalform').modal('show');

                const saveButton = $('#modalform').find('button[onclick="validateAndSaveJournalEntry()"]');
                saveButton.prop('disabled', false).html('Simpan');
            });

            return false;
        });

        // =================================================
        // 25.13 - EVENT HANDLER: NORMAL MODE MODAL
        // =================================================
        $(document).on('click', '#btnNormalModeModal', function() {
            const batchId = $('#cb_batchid').find('option:selected').data('batchid');
            const batchEntry = $('#cb_batchentry').val();

            if (!batchId || !batchEntry) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Pilih Batch Number dan Entry Number dulu',
                    confirmButtonText: 'OK'
                });
                return;
            }

            $('#TransRef, #TransDesc, #AcctId, #AcctName, #ScurnAmtDebit, #ScurnAmtCredit, #TransAmtDebit, #TransAmtCredit, #Comment').val('');

            isNewEntry = true;
            isRateDateManuallyEdited = false;
            currentEntryMode = 'normal';

            updateRateDateFromDataEntry();

            getNextLineNumber(batchId, batchEntry).then(nextLine => {
                $('#LineNumber').val(nextLine);
            });

            const saveButton = $('#modalform').find('button[onclick="validateAndSaveJournalEntry()"]');
            saveButton.prop('disabled', false).html('Simpan');
        });

        // =================================================
        // 25.14 - EVENT HANDLER: QUICK MODE MODAL
        // =================================================
        $(document).on('click', '#btnQuickModeModal', function() {
            const batchId = $('#cb_batchid').find('option:selected').data('batchid');
            const batchEntry = $('#cb_batchentry').val();

            if (!batchId || !batchEntry) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Pilih Batch Number dan Entry Number dulu',
                    confirmButtonText: 'OK'
                });
                return;
            }

            $('#ScurnAmtDebit, #ScurnAmtCredit, #Comment').val('');

            if (savedFormData) {
                $('#TransRef').val(savedFormData.TransRef);
                $('#TransDesc').val(savedFormData.TransDesc);
                $('#AcctId').val(savedFormData.AcctId);
                $('#AcctName').val(savedFormData.AcctName);
                $('#cb_scurncode').val(savedFormData.ScurnCode).trigger('change');
                $('#ConvRate').val(savedFormData.ConvRate);
                $('#RateDate').val(savedFormData.RateDate);
                $('#Comment').val(savedFormData.Comment);
            }

            $('#ScurnAmt, #ScurnAmtCredit, #ScurnAmtDebit, #TransAmt, #TransAmtCredit, #TransAmtDebit').val('');
            $('#ScurnAmtDebit, #ScurnAmtCredit, #TransAmtDebit, #TransAmtCredit').prop('readonly', false);

            getNextLineNumber(batchId, batchEntry).then(nextLine => {
                $('#LineNumber').val(nextLine);
            });

            currentEntryMode = 'quick';
            setupQuickEntryLockHandlers();

            const saveButton = $('#modalform').find('button[onclick="validateAndSaveJournalEntry()"]');
            saveButton.prop('disabled', false).html('Simpan');
        });

        // =================================================
        // 25.15 - EVENT HANDLER: SELECT ALL CHECKBOX
        // =================================================
        $(document).on('change', '#selectAll', function() {
            const isChecked = $(this).prop('checked');
            $('.checkbox-row').prop('checked', isChecked);
        });

        // =================================================
        // 25.16 - EVENT HANDLER: CB_BATCHID CHANGE
        // =================================================
        $('#cb_batchid.select2').on('change', async function() {
            const selected = $(this).find('option:selected');
            const batchid = selected.data('batchid');

            const previousBatchId = $(this).data('previous-value') || currentBatchId;
            const previousBatchEntry = currentBatchEntry;

            $(this).data('previous-value', batchid);

            disableSelect2('#cb_srcetype', true);

            $('#cb_batchentry')
                .prop('disabled', true)
                .html('<option value="">Loading...</option>');

            $('#SrceDesc').val('');

            if (!batchid) {
                disableSelect2('#cb_srcetype', true);
                $('#cb_srceledger').prop('disabled', true).val('').trigger('change');
                $('#cb_batchentry').prop('disabled', true).html('<option value="">--Select--</option>');
                return;
            }

            if (batchid && previousBatchEntry && batchid !== previousBatchId) {
                const shouldProceed = await showResetConfirmation(previousBatchId, previousBatchEntry);

                if (!shouldProceed) {
                    $(this).val(previousBatchId ? previousBatchId.toString() : '').trigger('change.select2');
                    $(this).data('previous-value', previousBatchId);
                    return;
                }

                proceedWithBatchChange(selected, batchid);
            } else {
                proceedWithBatchChange(selected, batchid);
            }
            
            setTimeout(function() {
                if($('#cb_batchentry option[value="0000001"]').length) {
                    $('#cb_batchentry').val('0000001').trigger('change');
                }
            }, 600);
        });

        // =====================================================
        // 25.17 - EVENT HANDLER: CB_BATCHENTRY CHANGE
        // =====================================================
        $('#cb_batchentry').on('change', async function() {
            const selected = $(this).find('option:selected');
            const batchEntry = selected.val();
            const batchId = $('#cb_batchid').find('option:selected').data('batchid');

            const previousBatchEntry = $(this).data('previous-value') || currentBatchEntry;
            const previousBatchId = currentBatchId;

            $(this).data('previous-value', batchEntry);

            if (!batchEntry || batchEntry === '') {
                disableSelect2('#cb_srcetype', true);
                $('#JrnlDesc').prop('readonly', true).val('');
                resetSourceFields();
                $('#BatchEntryDeletedBadge').hide();
                updateAddOptionVisibility();
            } else {
                $('#JrnlDesc').prop('readonly', false);

                const isDeleted = selected.data('deleted');
                const batchStat = $('#cb_batchid').find('option:selected').data('batchstat');

                if (isDeleted === true || isDeleted === 'true' || batchStat === '2' || batchStat === '4') {
                    disableSelect2('#cb_srcetype', true);
                } else {
                    disableSelect2('#cb_srcetype', false);
                }
            }

            if (batchEntry === '__add__') {
                const batchid = $('#cb_batchid').find('option:selected').data('batchid');
                if (batchid) {
                    resetHeaderFieldsForNewEntry();
                    handleAddNewEntry(batchid);
                    disableSelect2('#cb_srcetype', false);
                }
                return;
            }

            if (batchEntry && batchEntry !== '__add__') {
                $('#cb_srceledger').prop('disabled', false);

                const isDeleted = selected.data('deleted');
                const badge = $('#BatchEntryDeletedBadge');

                if (isDeleted === true || isDeleted === 'true') {
                    badge.show();
                    disableAllButtons();
                    hideAddOption();
                    disableSelect2('#cb_srcetype', true);
                } else {
                    badge.hide();
                    checkBatchStatusAndDisableButtons(batchId);
                }
            } else {
                $('#cb_srceledger, #cb_srcetype').prop('disabled', true);
                resetSourceFields();
                $('#BatchEntryDeletedBadge').hide();
                checkBatchStatusAndDisableButtons(batchId);
            }

            if (batchId && previousBatchEntry && batchEntry !== previousBatchEntry) {
                const shouldProceed = await showResetConfirmation(previousBatchId, previousBatchEntry);

                if (!shouldProceed) {
                    $(this).val(previousBatchEntry).trigger('change.select2');
                    $(this).data('previous-value', previousBatchEntry);
                    return;
                }

                proceedWithBatchEntryChange(selected, batchEntry, batchId);
            } else {
                proceedWithBatchEntryChange(selected, batchEntry, batchId);
            }

            checkBatchStatForButtons();
            checkBatchEntryDeletedStatus();
            updateAddOptionVisibility();
        });

        // =================================================
        // 25.18 - EVENT HANDLER: CB_BATCHENTRY SELECT2 SELECT
        // =================================================
        $('#cb_batchentry').on('select2:select', function(e) {
            const selectedValue = e.params.data.id;
            if (selectedValue === '__add__') {
                setTimeout(resetHeaderFieldsForNewEntry, 100);
            }
        });

        // =================================================
        // 25.19 - EVENT HANDLER: REAL-TIME VALIDATION
        // =================================================
        $('#TransRef, #TransDesc, #AcctId, #RateDate, #ConvRate').on('blur', function() {
            if (!$(this).val().trim()) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        $('#cb_scurncode').on('change', function() {
            if (!$(this).val()) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        $('#ScurnAmtDebit, #ScurnAmtCredit, #TransAmtDebit, #TransAmtCredit').on('blur', validateAmounts);

        // =================================================
        // 25.20 - EVENT HANDLER: CB_SCURNCODE CHANGE
        // =================================================
        $('#cb_scurncode').on('change', function() {
            const convrate = $(this).find('option:selected').data('convrate');
            $('#ConvRate').val(convrate);
        });

        // =================================================
        // 25.21 - EVENT HANDLER: SCURNAMT & CONVRATE INPUT
        // =================================================
        $('#ScurnAmt, #ConvRate').on('input', function() {
            const scurnAmtDebit = parseFloat($('#ScurnAmt').val()) || 0;
            const convRate = parseFloat($('#ConvRate').val()) || 1;

            const netScurnAmt = scurnAmtDebit - scurnAmtCredit;
            const netTransAmt = netScurnAmt * convRate;

            if (netTransAmt > 0) {
                $('#TransAmt').val(netTransAmt.toFixed(2));
                $('#TransAmtCredit').val('');
            } else {
                $('#TransAmt').val('');
                $('#TransAmtCredit').val(Math.abs(netTransAmt).toFixed(2));
            }
        });

        // =================================================
        // 25.22 - AUTO SELECT BATCH DARI URL
        // =================================================
        setTimeout(autoSelectBatchFromUrl, 500);

        $(window).on('load', function() {
            setTimeout(autoSelectBatchFromUrl, 1000);
        });

        // =================================================
        // 25.23 - AUTO SELECT BATCH DARI PHP SESSION
        // =================================================
        const preselectedBatchId = '<?= $preselected_batch_id ?? '' ?>';
        if (preselectedBatchId) {
            const checkBatchDropdown = setInterval(() => {
                const batchOption = $(`#cb_batchid option[value="${preselectedBatchId}"]`);
                if (batchOption.length > 0 && $('#cb_batchid').hasClass('select2-hidden-accessible')) {
                    $('#cb_batchid').val(preselectedBatchId).trigger('change.select2');
                    clearInterval(checkBatchDropdown);
                }
            }, 100);
            setTimeout(() => clearInterval(checkBatchDropdown), 5000);
        }

        // =================================================
        // 25.24 - FORCE DISABLE CL & AL
        // =================================================
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === 'disabled') {
                    const srcetypeVal = $('#cb_srcetype').val();
                    if (srcetypeVal === 'CL' || srcetypeVal === 'AL') {
                        if (!$('#cb_srcetype').prop('disabled')) {
                            $('#cb_srcetype')
                                .prop('disabled', true)
                                .css('background-color', '#e9ecef');
                        }
                    }
                }
            });
        });

        const srcetypeElement = document.getElementById('cb_srcetype');
        if (srcetypeElement) {
            observer.observe(srcetypeElement, {
                attributes: true,
                attributeFilter: ['disabled']
            });
        }

        function forceDisableIfCLorAL() {
            const srcetypeVal = $('#cb_srcetype').val();
            if (srcetypeVal === 'CL' || srcetypeVal === 'AL') {
                $('#cb_srcetype')
                    .prop('disabled', true)
                    .css('background-color', '#e9ecef');
            }
        }

        $('#cb_srcetype').on('change', forceDisableIfCLorAL);
        setInterval(forceDisableIfCLorAL, 500);
        setTimeout(forceDisableIfCLorAL, 300);

        // =================================================
        // 25.25 - SETUP AMOUNT SYNC
        // =================================================
        setupAmountSync();

        // =================================================
        // 25.26 - EVENT HANDLER: WINDOW BEFOREUNLOAD
        // =================================================
        $(window).on('beforeunload', function(e) {
            const batchId = $('#cb_batchid').find('option:selected').data('batchid');
            const batchEntry = $('#cb_batchentry').val();

            if (batchId && batchEntry && hasUnsavedChanges(batchId, batchEntry)) {
                const confirmationMessage = 'Ada data yang belum disimpan. Apakah kamu yakin mau meninggalkan halaman ini? Data yang belum disimpan akan hilang.';
                e.preventDefault();
                e.returnValue = confirmationMessage;
                return confirmationMessage;
            }
        });

        // =================================================
        // 25.27 - EVENT HANDLER: WINDOW UNLOAD
        // =================================================
        $(window).on('unload', function() {
            const batchId = $('#cb_batchid').find('option:selected').data('batchid');
            const batchEntry = $('#cb_batchentry').val();

            if (batchId && batchEntry) {
                const isUserCreated = isUserCreatedBatchEntry(batchId, batchEntry);

                if (isUserCreated) {
                    localStorage.removeItem(LOCAL_STORAGE_KEY);
                    localStorage.removeItem(`${LOCAL_STORAGE_KEY}_user_created`);
                } else if (hasUnsavedData(batchId, batchEntry)) {
                    localStorage.removeItem(LOCAL_STORAGE_KEY);
                }
            }
        });

        // =================================================
        // 25.28 - EVENT HANDLER: DELETE BATCH ENTRY
        // =================================================
        $(document).on('click', '#btnDeleteBatchEntry', function() {
            const batchId = $('#cb_batchid').find('option:selected').data('batchid');
            const batchEntry = $('#cb_batchentry').val();

            if (!batchId || !batchEntry) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Pilih Batch Number dan Entry Number dulu',
                    confirmButtonText: 'OK'
                });
                return;
            }

            const currentBatchEntry = batchEntry;

            Swal.fire({
                icon: 'warning',
                title: 'Konfirmasi Hapus',
                html: `Apakah kamu yakin mau menghapus Batch Entry <strong>${batchEntry}</strong>?`,
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#btnDeleteBatchEntry').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menghapus...');

                    $.ajax({
                        url: "<?= site_url('tmstgljournal/deleteBatchEntry') ?>",
                        method: "PUT",
                        contentType: "application/json",
                        data: JSON.stringify({
                            batchId: batchId,
                            batchEntry: batchEntry
                        }),
                        dataType: "JSON",
                        success: function(response) {
                            $('#btnDeleteBatchEntry').prop('disabled', false).html('Delete');

                            if (response.success) {
                                const selectedOption = $(`#cb_batchentry option[value="${currentBatchEntry}"]`);
                                selectedOption.data('deleted', true);

                                $('#BatchEntryDeletedBadge')
                                    .text('Deleted')
                                    .css({
                                        'background': '#dc3545',
                                        'color': '#fff',
                                        'padding': '4px 8px',
                                        'border-radius': '3px',
                                        'font-weight': 'bold'
                                    })
                                    .show();

                                $('#gljournallistTable tbody, .temp-data').empty().remove();

                                clearLocalStorageByBatch(batchId, currentBatchEntry);
                                clearSoftEditByBatch(batchId, currentBatchEntry);

                                deletedEntries = deletedEntries.filter(entry =>
                                    !(entry.BatchId === batchId && entry.BatchEntry === currentBatchEntry)
                                );

                                removeUserCreatedBatchEntry(batchId, currentBatchEntry);

                                resetHeaderFields();
                                $('#JrnlDesc').prop('readonly', true);
                                $('#CreateJournalBy').val('');
                                $('#cb_srcetype').val('').prop('disabled', true);

                                disableAllButtons();

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    $('#cb_batchentry').val(currentBatchEntry).trigger('change');
                                    table.ajax.reload();
                                    showAddOption();
                                    updateAddOptionVisibility();
                                    toggleSummarySection();
                                    refreshAllSummaryData();
                                    $('#gljournallistTable th:contains("Aksi"), #gljournallistTable td:nth-child(15)').hide();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.message,
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            $('#btnDeleteBatchEntry').prop('disabled', false).html('Delete');
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Ada kesalahan: ' + error,
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        });

        // =================================================
        // 25.29 - EVENT HANDLER: REVERSE BATCH ENTRY
        // =================================================
        $(document).on('click', '#btnReverseBatchEntry', function() {
            const batchId = $('#cb_batchid').find('option:selected').data('batchid');
            const batchEntry = $('#cb_batchentry').val();

            if (!batchId || !batchEntry) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Pilih Batch Number dan Entry Number dulu',
                    confirmButtonText: 'OK'
                });
                return;
            }

            const currentBatchEntry = batchEntry;

            Swal.fire({
                icon: 'warning',
                title: 'Konfirmasi Reverse',
                html: `Apakah kamu yakin mau ngereverse Batch Entry <strong>${batchEntry}</strong>?`,
                showCancelButton: true,
                confirmButtonText: 'Ya, Reverse',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#ffc107',
                cancelButtonColor: '#3085d6'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#btnReverseBatchEntry').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Reversing...');

                    $.ajax({
                        url: "<?= site_url('tmstgljournal/reverseBatchEntry') ?>",
                        method: "POST",
                        contentType: "application/json",
                        data: JSON.stringify({
                            batchId: batchId,
                            batchEntry: batchEntry,
                            confirmed: true
                        }),
                        dataType: "JSON",
                        success: function(response) {
                            $('#btnReverseBatchEntry').prop('disabled', false).html('Reverse');

                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    $('#cb_batchentry').val(currentBatchEntry).trigger('change');
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.message,
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            $('#btnReverseBatchEntry').prop('disabled', false).html('Reverse');
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Ada kesalahan: ' + error,
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        });
    });
</script>

<!-- ===================================================== -->
<!-- BAGIAN 26: PROSES BATCH CHANGE                        -->
<!-- ===================================================== -->
<script>
    // =====================================================
    // 26.1 - PROSES PERUBAHAN BATCH
    // =====================================================
    function proceedWithBatchChange(selected, batchid) {
        cancelAllPendingRequests();
        cancelActiveSrceDescRequest();

        activeBatchId = batchid;
        activeBatchEntry = null;

        $('#cb_batchentry').prop('disabled', true).html('<option value="">Loading...</option>');

        $('#SrceDesc').val('');

        if (!batchid) {
            disableSelect2('#cb_srcetype', true);
            $('#cb_srceledger')
                .prop('disabled', true)
                .val('')
                .css('background-color', '#e9ecef');
            $('#EnteredBatchIdBy, #BatchDesc, #CreateJournalBy').val('');
            $('#DataEntry, #PostDate, #YearPeriod').val('').prop('disabled', true);
            $('#JrnlDesc').prop('readonly', true).val('');
            table.clear().draw();
            $('.temp-data').remove();
            toggleSummarySection();
            updateAddOptionVisibility();
            return;
        }

        const batchdesc = selected.data('batchdesc');
        const srceledger = selected.data('srcledgr');
        const srcetype = selected.data('srcetype');
        const srcedesc = selected.data('srcedesc');
        const audtuser = selected.data('audtuser');
        const dataentry = selected.data('dataentry');
        const postdate = selected.data('postdate');

        $('#EnteredBatchIdBy').val(audtuser);
        $('#BatchDesc').val(batchdesc);
        $('#AudtUser').val(audtuser);
        $('#CreateJournalBy').val(audtuser || '');

        setSourceLedgerFromBatch(selected);

        if (srcetype) {
            $('#cb_srcetype').val(srcetype).trigger('change');
            disableSelect2('#cb_srcetype', true);
        } else {
            disableSelect2('#cb_srcetype', true);
        }

        if (srcedesc) {
            $('#SrceDesc').val(srcedesc);
        }

        if (srceledger) {
            loadSourceType(srceledger);
        }

        if (srceledger && srcetype) {
            setTimeout(() => {
                if (activeBatchId === batchid) {
                    getSrceDescription(srceledger, srcetype, function(srceDesc) {
                        if (srceDesc && activeBatchId === batchid) {
                            $('#SrceDesc').val(srceDesc);
                        }
                    });
                }
            }, 200);
        }

        resetHeaderFields();

        if (dataentry) $('#DataEntry').val(formatDateDDMMYYYY(dataentry));
        if (postdate) $('#PostDate').val(formatDateDDMMYYYY(postdate));

        table.clear().draw();
        $('.temp-data').remove();

        toggleDateFields(false);
        $('#JrnlDesc').prop('readonly', true);

        if (batchid) {
            currentBatchId = batchid;
            checkBatchStatusAndDisableButtons(batchid);
            loadBatchEntries(batchid, true);
        }

        updateBalanceDisplay(0, 0, 0);

        setTimeout(() => {
            if (activeBatchId === batchid) {
                toggleSummarySection();
                refreshSummaryData(batchid);
            }
        }, 500);

        updateAddOptionVisibility();
    }

    // =====================================================
    // 26.2 - PROSES PERUBAHAN BATCH ENTRY
    // =====================================================
    function proceedWithBatchEntryChange(selected, batchEntry, batchId) {
        cancelAllPendingRequests();

        activeBatchId = batchId;
        activeBatchEntry = batchEntry;

        const isDeleted = selected.data('deleted');
        const badge = $('#BatchEntryDeletedBadge');

        if (isDeleted === true || isDeleted === 'true') {
            badge.show();
            disableAllButtons();
            $('#cb_srcetype')
                .prop('disabled', true)
                .css('background-color', '#e9ecef');
        } else {
            badge.hide();
            checkBatchStatusAndDisableButtons(batchId);

            const batchStat = $('#cb_batchid').find('option:selected').data('batchstat');
            if (batchStat !== '2' && batchStat !== '4') {
                $('#cb_srcetype')
                    .prop('disabled', false)
                    .css('background-color', '');
            } else {
                $('#cb_srcetype')
                    .prop('disabled', true)
                    .css('background-color', '#e9ecef');
            }
        }

        $('#BatchEntry').val(batchEntry);
        currentBatchEntry = batchEntry;

        if (batchEntry) {
            $('#DataEntry, #PostDate, #YearPeriod').prop('disabled', false);
            $('#JrnlDesc').prop('readonly', false);

            checkAndDisableSourceLedger();
            updateCreateJournalByFromBatchEntry(batchId, batchEntry);

            if (isUserCreatedBatchEntry(batchId, batchEntry)) {
                resetHeaderFieldsForNewEntry();
                resetSourceTypeForNewEntry();
                handleNewEntryConditions();
                $('#cb_srcetype')
                    .prop('disabled', false)
                    .css('background-color', '');
            } else {
                $('#JrnlDesc').val('');
                handleExistingEntryConditions();
            }

            checkBatchStatusAndDisableButtons(batchId);

            updateBalanceDisplay(0, 0, 0);

            table.ajax.reload(null, false, function() {
                if (activeBatchId !== batchId || activeBatchEntry !== batchEntry) {
                    return;
                }

                setTimeout(() => {
                    if (activeBatchId === batchId && activeBatchEntry === batchEntry) {
                        loadFromLocalStorage();
                        refreshSummaryData(batchId);
                        updateCreateJournalByFromBatchEntry(batchId, batchEntry);

                        toggleSummarySection();
                        updateSummarySection();
                    }
                }, 300);
            });

            updateDatesFromBatchEntry();
            updateAddOptionVisibility();

        } else {
            toggleDateFields(false);
            $('#JrnlDesc').prop('readonly', true);
            $('#CreateJournalBy').val('');
            checkAndDisableSourceLedger();
            table.clear().draw();
            $('.temp-data').remove();
            toggleSummarySection();

            $('#cb_srcetype')
                .prop('disabled', true)
                .css('background-color', '#e9ecef');
        }
    }
</script>

<!-- ===================================================== -->
<!-- BAGIAN 27: INISIALISASI DATATABLE                     -->
<!-- ===================================================== -->
<script>
    let table;

    $(document).ready(function() {
        // =================================================
        // 27.1 - INISIALISASI DATATABLE
        // =================================================
        table = $("#gljournallistTable").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            dom: 'Bfrtip',
            ajax: {
                url: "<?= base_url('tmstgljournal/datatables') ?>",
                type: "POST",
                contentType: "application/json",
                data: function(d) {
                    const batch = $('#cb_batchid.select2').find('option:selected');
                    const entry = $('#cb_batchentry.select2').find('option:selected');
                    d.batchId = batch.data('batchid');
                    d.batchEntry = entry.val();
                    return JSON.stringify(d);
                },
                error: function(xhr, error, thrown) {
                    if (xhr.responseJSON && xhr.responseJSON.status === 'session_expired') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Sesi Berakhir',
                            text: 'Sesi kamu udah habis. Silakan login lagi.',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = "<?= base_url('auth/login') ?>";
                        });
                    }
                }
            },
            createdRow: function(row, data, dataIndex) {
                $(row).css('background-color', '');
                $(row).attr({
                    'data-source': 'database',
                    'data-batchid': data.batchId,
                    'data-batchentry': data.batchEntry,
                    'data-transnbr': data.transNbr,
                    'data-batchstat': data.batchStat
                });

                if (data.transNbr) {
                    $(row).addClass('database-row');
                }
            },
            columnDefs: [{
                    orderable: false,
                    targets: [0, 14]
                },
                {
                    targets: [0, 14],
                    className: 'text-center'
                },
                {
                    targets: [1, 7, 8, 9, 11, 12],
                    className: 'text-end'
                }
            ],
            columns: [{
                    data: null,
                    orderable: false,
                    render: function(data, type, row) {
                        return `<input type="checkbox" class="checkbox-row" 
                            data-batchid="${row.batchId || ''}" 
                            data-batchentry="${row.batchEntry || ''}" 
                            data-transnbr="${row.transNbr || ''}">`;
                    }
                },
                {
                    data: 'transNbr',
                    render: d => d || ''
                },
                {
                    data: 'transRef',
                    render: d => d || ''
                },
                {
                    data: 'transDesc',
                    render: d => d || ''
                },
                {
                    data: 'acctId',
                    render: d => d || ''
                },
                {
                    data: 'acctName',
                    render: d => d || ''
                },
                {
                    data: 'scurnCode',
                    render: d => d || ''
                },
                {
                    data: 'scurnAmt',
                    className: 'text-end',
                    render: function(d, type) {
                        if (type === 'display' || type === 'filter') {
                            const val = parseFloat(d);
                            return val > 0 ? val.toFixed(2) : '';
                        }
                        return d > 0 ? d : 0;
                    }
                },
                {
                    data: 'scurnAmt',
                    className: 'text-end',
                    render: function(d, type) {
                        if (type === 'display' || type === 'filter') {
                            const val = parseFloat(d);
                            return val < 0 ? Math.abs(val).toFixed(2) : '';
                        }
                        return d < 0 ? Math.abs(d) : 0;
                    }
                },
                {
                    data: 'convRate',
                    className: 'text-end',
                    render: function(data, type) {
                        if (type === 'display' || type === 'filter') {
                            const val = parseFloat(data);
                            return !isNaN(val) ? val.toLocaleString('id-ID', {
                                minimumFractionDigits: 4,
                                maximumFractionDigits: 4
                            }) : '';
                        }
                        return data;
                    }
                },
                {
                    data: 'rateDate',
                    render: function(data) {
                        return formatDateDDMMYYYY(data) || '';
                    }
                },
                {
                    data: 'transAmt',
                    className: 'text-end',
                    render: function(d, type) {
                        if (type === 'display' || type === 'filter') {
                            const val = parseFloat(d);
                            return val > 0 ? val.toFixed(2) : '';
                        }
                        return d > 0 ? d : 0;
                    }
                },
                {
                    data: 'transAmt',
                    className: 'text-end',
                    render: function(d, type) {
                        if (type === 'display' || type === 'filter') {
                            const val = parseFloat(d);
                            return val < 0 ? Math.abs(val).toFixed(2) : '';
                        }
                        return d < 0 ? Math.abs(d) : 0;
                    }
                },
                {
                    data: 'comment',
                    render: d => d || ''
                },
                {
                    data: null,
                    orderable: false,
                    render: function(data, type, row) {
                        const batchStat = row.batchStat || '';
                        const hideActions = (batchStat == "2" || batchStat == "4" || batchStat == "9");

                        const selectedEntry = $('#cb_batchentry').find('option:selected');
                        const isEntryDeleted = selectedEntry.data('deleted');
                        const hideDeletedActions = (isEntryDeleted === true || isEntryDeleted === 'true');

                        const shouldHideActions = hideActions || hideDeletedActions;

                        const viewClass = `view <?= session()->get("flag_view") === 1 ? "" : "d-none" ?> ${shouldHideActions ? 'd-none' : ''}`;
                        const editClass = `edit <?= session()->get("flag_update") === 1 ? "" : "d-none" ?> ${shouldHideActions ? 'd-none' : ''}`;
                        const deleteClass = `delete <?= session()->get("flag_delete") === 1 ? "" : "d-none" ?> ${shouldHideActions ? 'd-none' : ''}`;

                        return `
                    <div class="btn-group">
                        <a class="btn btn-sm btn-info ${viewClass}"
                           data-batchid="${row.batchId || ''}"
                           data-batchentry="${row.batchEntry || ''}"
                           data-transnbr="${row.transNbr || ''}"
                           data-batchstat="${batchStat}">
                           <i class="fas fa-eye"></i>
                        </a>
                        <a class="btn btn-sm btn-primary ${editClass}"
                           data-batchid="${row.batchId || ''}"
                           data-batchentry="${row.batchEntry || ''}"
                           data-transnbr="${row.transNbr || ''}"
                           data-batchstat="${batchStat}">
                           <i class="fas fa-tags"></i>
                        </a>
                        <a class="btn btn-sm btn-danger ${deleteClass}"
                           data-batchid="${row.batchId || ''}"
                           data-batchentry="${row.batchEntry || ''}"
                           data-transnbr="${row.transNbr || ''}"
                           data-batchstat="${batchStat}">
                           <i class="fas fa-trash"></i>
                        </a>
                    </div>`;
                    }
                }
            ],
            buttons: [{
                    text: '<i class="fa fa-plus"></i> New Line',
                    action: function() {
                        $('#add_record').click();
                    },
                    attr: {
                        id: "add_record",
                        class: "btn btn-sm text-white",
                        style: "background-color:#56b746; margin-right:8px; <?= session()->get('flag_insert') === 1 ? '' : 'd-none' ?>",
                        name: "add_record"
                    }
                },
                {
                    text: '<i class="fas fa-bolt"></i> Quick Entry Mode',
                    action: openQuickEntryMode,
                    attr: {
                        id: "btnQuickEntryMode",
                        class: "btn btn-sm btn-warning",
                        style: "margin-right:8px;",
                        name: "btnQuickEntryMode"
                    }
                }
            ],
            oLanguage: {
                sSearch: "Search:",
                sEmptyTable: "Ga ada data",
                sInfo: "Nampilin _START_ sampe _END_ dari _TOTAL_ entri",
                sInfoEmpty: "Nampilin 0 sampe 0 dari 0 entri",
                sInfoFiltered: "(difilter dari _MAX_ total entri)",
                sZeroRecords: "Ga ada data yang cocok",
                oPaginate: {
                    sFirst: "Awal",
                    sPrevious: "Sebelum",
                    sNext: "Berikut",
                    sLast: "Akhir"
                },
                sLengthMenu: "Tampilin _MENU_ entri"
            },
            drawCallback: function(settings) {
                setTimeout(() => {
                    toggleSummarySection();
                    updateSummarySection();
                    toggleActionHeader();

                    const selectedEntry = $('#cb_batchentry').find('option:selected');
                    const isEntryDeleted = selectedEntry.data('deleted');
                    const batchStat = $('#cb_batchid').find('option:selected').data('batchstat');

                    if (isEntryDeleted === true || isEntryDeleted === 'true') {
                        $('#gljournallistTable .btn-group .btn').addClass('d-none');
                    } else {
                        const hideBatchStatusActions = (batchStat == "2" || batchStat == "4");

                        if (!hideBatchStatusActions) {
                            $('.view').toggleClass('d-none', <?= session()->get("flag_view") === 1 ? "false" : "true" ?>);
                            $('.edit').toggleClass('d-none', <?= session()->get("flag_update") === 1 ? "false" : "true" ?>);
                            $('.delete').toggleClass('d-none', <?= session()->get("flag_delete") === 1 ? "false" : "true" ?>);
                        } else {
                            $('#gljournallistTable .btn-group .btn').addClass('d-none');
                        }
                    }
                }, 100);
            },
            initComplete: function(settings, json) {
                setTimeout(() => {
                    const selectedEntry = $('#cb_batchentry').find('option:selected');
                    const isEntryDeleted = selectedEntry.data('deleted');
                    const batchStat = $('#cb_batchid').find('option:selected').data('batchstat');

                    if (isEntryDeleted === true || isEntryDeleted === 'true' || batchStat === '2' || batchStat === '4') {
                        $('#gljournallistTable .btn-group .btn').addClass('d-none');
                        $('#gljournallistTable th:contains("Aksi"), #gljournallistTable td:nth-child(15)').hide();
                    }
                }, 500);
            }
        });

        table.buttons().container().appendTo("#gljournallistTable_wrapper .col-md-6:eq(0)");

        // =================================================
        // 27.2 - EVENT HANDLER: XHR DATATABLE
        // =================================================
        table.on('xhr.dt', function(e, settings, json, xhr) {
            if (json && json.status === 'session_expired') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Sesi Berakhir',
                    text: 'Sesi kamu sudah abis. Silakan login lagi.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = "<?= base_url('auth/login') ?>";
                });
            }
        });

        table.on('draw.dt', function() {
            const batchentry = $('#cb_batchentry').val();
            if (batchentry) {
                updateDatesFromBatchEntry();

                const batchId = $('#cb_batchid').find('option:selected').data('batchid');
                const batchEntry = batchentry;

                setTimeout(() => {
                    loadFromLocalStorage();
                    toggleSummarySection();
                    updateSummarySection();
                    updateCreateJournalByFromBatchEntry(batchId, batchEntry);
                    updateAddOptionVisibility();

                    if (batchId) {
                        refreshSummaryData(batchId);
                        checkBatchStatusAndDisableButtons(batchId);
                    }
                }, 300);
            }
            toggleSummarySection();
        });

        // =================================================
        // 27.3 - APPLY SOFT EDIT TO TABLE
        // =================================================
        table.on('draw.dt', function() {
            setTimeout(applySoftEditToTable, 100);
        });

        // =================================================
        // 27.4 - EVENT HANDLER: CB_BATCHID, CB_BATCHENTRY CHANGE
        // =================================================
        $('#cb_batchid, #cb_batchentry').on('change', function() {
            const currentBatchId = $('#cb_batchid').find('option:selected').data('batchid');
            const currentBatchEntry = $('#cb_batchentry').val();

            updateBalanceDisplay(0, 0, 0);

            setTimeout(() => {
                const newBatchId = $('#cb_batchid').find('option:selected').data('batchid');
                const newBatchEntry = $('#cb_batchentry').val();

                if (newBatchId === currentBatchId && newBatchEntry === currentBatchEntry) {
                    updateSummarySection();
                    updateAddOptionVisibility();

                    if (newBatchId) {
                        refreshSummaryData(newBatchId);
                    }
                } else {}
            }, 500);
        });
    });
</script>

<!-- ===================================================== -->
<!-- BAGIAN 28: SESSION CHECK                              -->
<!-- ===================================================== -->
<script>
    $('#gljournallistTable').on('xhr.dt', function(e, settings, json, xhr) {
        if (json && json.status === 'session_expired') {
            Swal.fire({
                icon: 'warning',
                title: 'Sesi Berakhir',
                text: 'sesi kamu sudah habis. Silakan login lagi.',
                confirmButtonText: 'OK'
            });
            window.location.href = "<?= base_url('auth/login') ?>";
        }
    });
</script>

<!-- ===================================================== -->
<!-- BAGIAN 29: NAVIGASI KEYBOARD                          -->
<!-- ===================================================== -->
<script>
    $(document).on('keydown', function(e) {
        const isDropdownFocused = $('#cb_batchentry').is(':focus');
        const isModalOpen = $('#modalform').is(':visible') ||
            $('#modalBatchEntry').is(':visible') ||
            $('#modalAccountCoa').is(':visible') ||
            $('#modalFiscalCalender').is(':visible') ||
            $('#modalExport').is(':visible') ||
            $('#modalImport').is(':visible');

        if (isModalOpen) return;

        if (isDropdownFocused && (e.key === 'ArrowLeft' || e.key === 'ArrowRight')) {
            e.preventDefault();
            navigateBatchEntry(e.key === 'ArrowLeft' ? 'prev' : 'next');
        }
    });
</script>

<!-- ===================================================== -->
<!-- BAGIAN 30: SET MENU NAME BY ACTIVE-MENU               -->
<!-- ===================================================== -->
<script>
    $(document).ready(function() {
        activeBatchId = null;
        activeBatchEntry = null;

        setTimeout(() => {
            const initialValue = $('#cb_batchentry').val();

            if (initialValue && initialValue !== '' && initialValue !== '__add__') {
                toggleArrowButtons(true);
            } else {
                toggleArrowButtons(false);
            }

            const batchId = $('#cb_batchid').find('option:selected').data('batchid');
            if (batchId && initialValue && initialValue !== '' && initialValue !== '__add__') {
                toggleArrowButtons(true);
            }
        }, 1000);

        autoSelectBatchFromUrlModal();

        setTimeout(() => {
            const initialBatchId = $('#cb_batchid').find('option:selected').data('batchid');
            if (initialBatchId) {
                checkBatchStatusAndDisableButtons(initialBatchId);
            }
        }, 1000);

        toggleActionHeader();
    });
</script>

<!-- ===================================================== -->
<!-- BAGIAN 31: EVENT HANDLERS NAVIGASI                    -->
<!-- ===================================================== -->
<script>
    $(document).on('click', '#btnPrevBatchEntry', function() {
        navigateBatchEntry('prev');
    });

    $(document).on('click', '#btnNextBatchEntry', function() {
        navigateBatchEntry('next');
    });

    $(document).on('change', '#cb_batchentry', function() {
        const value = $(this).val();

        if (value && value !== '' && value !== '__add__') {
            toggleArrowButtons(true);
        } else {
            toggleArrowButtons(false);
        }

        updateNavigationButtons();
    });

    // =====================================================
    // SRCETYPE DYNAMIC CONTROLLER
    // =====================================================
    $(document).ready(function() {
        let lastBatchData = {
            srcetype: null,
            srcedesc: null,
            shouldLock: false
        };

        function updateSrcetypeFromBatch() {
            const selected = $('#cb_batchid').find('option:selected');
            const srcetype = selected.data('srcetype');
            const srcedesc = selected.data('srcedesc');

            const shouldLock = (srcetype === 'CL' || srcetype === 'AL');

            lastBatchData = {
                srcetype: srcetype,
                srcedesc: srcedesc,
                shouldLock: shouldLock
            };

            if (shouldLock) {
                $('#cb_srcetype').val(srcetype).trigger('change');
                $('#cb_srcetype').prop('disabled', true);
                $('#SrceDesc').val(srcedesc || '');
            } else {
                $('#cb_srcetype').val('').trigger('change');
                $('#cb_srcetype').prop('disabled', false);
                $('#SrceDesc').val('');
            }
        }

        $(document).on('change', '#cb_batchid', function() {
            updateSrcetypeFromBatch();
        });

        setTimeout(updateSrcetypeFromBatch, 500);

        let checkCount = 0;
        const checkInterval = setInterval(function() {
            const selected = $('#cb_batchid').find('option:selected');
            const srcetypeFromBatch = selected.data('srcetype');
            const shouldLock = (srcetypeFromBatch === 'CL' || srcetypeFromBatch === 'AL');
            const currentValue = $('#cb_srcetype').val();
            const isDisabled = $('#cb_srcetype').prop('disabled');

            if (shouldLock) {
                if (currentValue !== srcetypeFromBatch || !isDisabled) {
                    $('#cb_srcetype').val(srcetypeFromBatch).trigger('change');
                    $('#cb_srcetype').prop('disabled', true);
                }
            } else {
                if (isDisabled) {
                    $('#cb_srcetype').prop('disabled', false);
                }
            }

            checkCount++;
            if (checkCount > 30) {
                clearInterval(checkInterval);
            }
        }, 100);

        const srcetypeElement = document.getElementById('cb_srcetype');
        if (srcetypeElement) {
            const observer = new MutationObserver(function(mutations) {
                const selected = $('#cb_batchid').find('option:selected');
                const srcetypeFromBatch = selected.data('srcetype');
                const shouldLock = (srcetypeFromBatch === 'CL' || srcetypeFromBatch === 'AL');

                mutations.forEach(function(mutation) {
                    if (mutation.type === 'attributes') {
                        setTimeout(() => {
                            if (shouldLock) {
                                $('#cb_srcetype').prop('disabled', true);
                                if ($('#cb_srcetype').val() !== srcetypeFromBatch) {
                                    $('#cb_srcetype').val(srcetypeFromBatch).trigger('change');
                                }
                            } else {
                                $('#cb_srcetype').prop('disabled', false);
                            }
                        }, 10);
                    }
                });
            });

            observer.observe(srcetypeElement, {
                attributes: true,
                attributeFilter: ['disabled', 'value']
            });
        }

        const originalVal = $.fn.val;
        $.fn.val = function(value) {
            if (this.is('#cb_srcetype') && arguments.length > 0) {
                const selected = $('#cb_batchid').find('option:selected');
                const srcetypeFromBatch = selected.data('srcetype');
                const shouldLock = (srcetypeFromBatch === 'CL' || srcetypeFromBatch === 'AL');

                if (shouldLock && value !== srcetypeFromBatch) {
                    return this;
                }
            }
            return originalVal.apply(this, arguments);
        };
    });
</script>

<!-- ===================================================== -->
<!-- BAGIAN 32: IMPORT FILE CHANGE HANDLER                 -->
<!-- ===================================================== -->
<script>
    function previewFile() {
        const currentBatchId = $('#cb_batchid').find('option:selected').data('batchid');
        const fileInput = document.getElementById('importFile');
        const file = fileInput.files[0];

        if (!validateImportPrerequisites(currentBatchId, file)) {
            return;
        }

        setupPreviewUI();

        const formData = new FormData();
        formData.append('filename', file);
        formData.append('batchId', currentBatchId);
        formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

        $.ajax({
            url: "<?= site_url('tmstgljournal/preview') ?>",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "JSON",
            success: function(response) {
                handlePreviewResponse(response);
            },
            error: function(xhr, status, error) {
                handlePreviewError('error pas preview: ' + error, xhr.responseText);
            }
        });
    }

    $('#importFile').on('change', function() {
        const file = this.files[0];
        if (!file) return;

        $('#btnImport').hide();
        $('#btnPreview').show().prop('disabled', false).html('<i class="fas fa-eye mr-1"></i> Preview');
        $('#previewSection').hide();
        $('#validationResults').hide().empty();
        $('#validationNotRun').show();
        $('#validationBadge').hide();
    });
</script>

<!-- ===================================================== -->
<!-- BAGIAN 33: MODAL IMPORT HIDDEN HANDLER                -->
<!-- ===================================================== -->
<script>
    $('#modalImport').on('hidden.bs.modal', function() {
        resetImportModal();

        $.ajax({
            url: "<?= site_url('tmstgljournal/clearTempFile') ?>",
            method: "POST",
            data: {
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
            }
        });
    });
</script>

<!-- ===================================================== -->
<!-- BAGIAN 34: INITIALIZATION CHECKS                      -->
<!-- ===================================================== -->
<script>
    $(document).ready(function() {
        setTimeout(() => {
            const initialValue = $('#cb_batchentry').val();

            if (initialValue && initialValue !== '' && initialValue !== '__add__') {
                toggleArrowButtons(true);
            } else {
                toggleArrowButtons(false);
            }

            const batchId = $('#cb_batchid').find('option:selected').data('batchid');
            if (batchId && initialValue && initialValue !== '' && initialValue !== '__add__') {
                toggleArrowButtons(true);
            }
        }, 1000);

        autoSelectBatchFromUrlModal();

        setTimeout(() => {
            const initialBatchId = $('#cb_batchid').find('option:selected').data('batchid');
            if (initialBatchId) {
                checkBatchStatusAndDisableButtons(initialBatchId);
            }
        }, 1000);

        toggleActionHeader();

        setTimeout(function() {
            const batchid = $('#cb_batchid').find('option:selected').data('batchid');
            if (!batchid) {
                $('#cb_srcetype').prop('disabled', true);
                console.log('Force disable srcetype - no batch selected');
            }
        }, 500);

        setTimeout(function() {
            const batchid = $('#cb_batchid').find('option:selected').data('batchid');
            if (!batchid) {
                $('#cb_srcetype').prop('disabled', true);
                console.log('Force disable srcetype - no batch selected (2)');
            }
        }, 1500);

        setTimeout(function() {
            const batchid = $('#cb_batchid').find('option:selected').data('batchid');
            if (!batchid) {
                $('#cb_srcetype').prop('disabled', true);
                console.log('Force disable srcetype - no batch selected (3)');
            }
        }, 3000);
    });
</script>

<!-- ===================================================== -->
<!-- BAGIAN 35: CLEAR SELECTION FUNCTION                   -->
<!-- ===================================================== -->
<script>
    function clearSelection() {
        $('#selectAll').prop('checked', false);
        $('.checkbox-row').prop('checked', false);
    }
</script>

<?= $this->endSection('script'); ?>