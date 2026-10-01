<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>
<!-- Toastr -->
<link rel="stylesheet" href="<?= base_url('plugins/toastr/toastr.min.css') ?>">
<!-- Button datatable -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<style>
    /* set width action button crud */
    .btn-fix-w {
        width: 60px;
        padding-top: 0px;
        padding-bottom: 0px;
    }

    /* set font size dropdown select2 */
    select.form-control-sm~.select2-container--default {
        font-size: .720rem !important;
    }

    /* set font size input form */
    .form-control-sm {
        font-size: .720rem !important;
    }
</style>

<style>
    .segment-container {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .segment-input {
        position: relative;
        padding: 0 5px;
    }

    .segment-input label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 5px;
        display: block;
        font-size: 0.85rem;
    }

    .segment-input input {
        width: 100%;
        padding: 8px 10px;
        border: 1px solid #ced4da;
        border-radius: 6px;
        font-size: 0.9rem;
        text-align: center;
        transition: all 0.2s;
    }

    .segment-input input:focus {
        border-color: #86b7fe;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .separator {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 2px;
    }

    .delimiter-display {
        background-color: #e9ecef;
        border: 1px solid #adb5bd;
        border-radius: 4px;
        padding: 15px 5px;
        font-weight: 600;
        color: #495057;
        min-width: 20px;
        text-align: center;
        font-size: 1.1rem;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    @media (max-width: 768px) {
        .separator {
            margin: 10px 0;
        }

        .col-sm-2 {
            margin-bottom: 15px;
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
                    <!-- <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Field Value</li>
                    </ol> -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">

            <div class="row">
                <!-- left column -->
                <div class="col-md-12">

                    <!-- jquery validation -->
                    <div class="card card-outline card-info">

                        <div class="card-body">

                            <div class="card-title">
                            </div>

                            <table id="glcoaTable" class="table table-sm table-bordered table-striped">
                                <thead class="table">
                                    <tr>
                                        <th>No</th>
                                        <th>Account Number</th>
                                        <th>Account Name</th>
                                        <th>Account Type</th>
                                        <th>Account Group Name</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="modalform" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLabel"></h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <!-- Pindahkan form ke DALAM modal-body -->
                                    <div class="modal-body">
                                        <form method="post" id="data_form" autocomplete="off">
                                            <?= csrf_field(); ?>
                                            <!-- Hidden fields untuk menyimpan original values saat edit -->
                                            <input type="hidden" id="original_AcctNo" name="original_AcctNo">
                                            <input type="hidden" id="original_AcctName" name="original_AcctName">
                                            <input type="hidden" id="original_AcctType" name="original_AcctType">
                                            <input type="hidden" id="original_AccGrID" name="original_AccGrID">
                                            <input type="hidden" id="original_StructureID" name="original_StructureID">
                                            <input type="hidden" id="original_AcctBal" name="original_AcctBal">

                                            <!-- Semua konten form Anda tetap sama persis -->
                                            <div class="mb-3 row align-items-center">
                                                <label for="AccountStructure" class="col-sm-2 col-form-label">Account Structure</label>
                                                <div class="col-sm-5">
                                                    <?= $cb_account_structure ?>
                                                    <span class="invalid-feedback errorStructureID"></span>
                                                </div>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control form-control-sm" id="AccountStructureDesc" name="AccountStructureDesc" readonly>
                                                </div>
                                            </div>

                                            <?php
                                            $delimiter_data = apiDropdownSegmentDelimiter('cb_segment_delimiter');
                                            $default_delimiter = isset($delimiter_data['data'][0]['value']) ? $delimiter_data['data'][0]['value'] : '-';
                                            ?>

                                            <!-- Segment Container -->
                                            <div id="segmentContainer" class="segment-container" style="display: none;">
                                                <div class="mb-3 row align-items-end" id="segmentRow">
                                                    <div class="col-sm-2 text-center segment-input segment-1" style="display: none;">
                                                        <label id="labelSegment1">Segment 1</label>
                                                        <input type="text" class="form-control form-control-sm segment-input-field" id="segment1" maxlength="0">
                                                    </div>

                                                    <!-- Delimiter 1 (setelah Segment 1) -->
                                                    <div class="col-sm separator delimiter-after-1" style="display: none;">
                                                        <div class="delimiter-display">
                                                            <span id="delimiterValue1"><?php echo htmlspecialchars($default_delimiter); ?></span>
                                                        </div>
                                                    </div>

                                                    <!-- Segment 2 - DROPDOWN -->
                                                    <div class="col-sm-2 text-center segment-input segment-2" style="display: none;">
                                                        <label id="labelSegment2">Segment 2</label>
                                                        <?= $cb_segment_2 ?>
                                                    </div>

                                                    <!-- Delimiter 2 (setelah Segment 2) -->
                                                    <div class="col-sm separator delimiter-after-2" style="display: none;">
                                                        <div class="delimiter-display">
                                                            <span id="delimiterValue2"><?php echo htmlspecialchars($default_delimiter); ?></span>
                                                        </div>
                                                    </div>

                                                    <!-- Segment 3 - DROPDOWN -->
                                                    <div class="col-sm-2 text-center segment-input segment-3" style="display: none;">
                                                        <label id="labelSegment3">Segment 3</label>
                                                        <?= $cb_segment_3 ?>
                                                    </div>

                                                    <!-- Delimiter 3 (setelah Segment 3) -->
                                                    <div class="col-sm separator delimiter-after-3" style="display: none;">
                                                        <div class="delimiter-display">
                                                            <span id="delimiterValue3"><?php echo htmlspecialchars($default_delimiter); ?></span>
                                                        </div>
                                                    </div>

                                                    <!-- Segment 4 - DROPDOWN -->
                                                    <div class="col-sm-2 text-center segment-input segment-4" style="display: none;">
                                                        <label id="labelSegment4">Segment 4</label>
                                                        <?= $cb_segment_4 ?>
                                                    </div>

                                                    <!-- Delimiter 4 (setelah Segment 4) -->
                                                    <div class="col-sm separator delimiter-after-4" style="display: none;">
                                                        <div class="delimiter-display">
                                                            <span id="delimiterValue4"><?php echo htmlspecialchars($default_delimiter); ?></span>
                                                        </div>
                                                    </div>

                                                    <!-- Segment 5 - DROPDOWN -->
                                                    <div class="col-sm-2 text-center segment-input segment-5" style="display: none;">
                                                        <label id="labelSegment5">Segment 5</label>
                                                        <?= $cb_segment_5 ?>
                                                    </div>

                                                    <!-- Delimiter 5 (setelah Segment 5) -->
                                                    <div class="col-sm separator delimiter-after-5" style="display: none;">
                                                        <div class="delimiter-display">
                                                            <span id="delimiterValue5"><?php echo htmlspecialchars($default_delimiter); ?></span>
                                                        </div>
                                                    </div>

                                                    <!-- Segment 6 - DROPDOWN -->
                                                    <div class="col-sm-2 text-center segment-input segment-6" style="display: none;">
                                                        <label id="labelSegment6">Segment 6</label>
                                                        <?= $cb_segment_6 ?>
                                                    </div>

                                                    <!-- Delimiter 6 (setelah Segment 6) -->
                                                    <div class="col-sm separator delimiter-after-6" style="display: none;">
                                                        <div class="delimiter-display">
                                                            <span id="delimiterValue6"><?php echo htmlspecialchars($default_delimiter); ?></span>
                                                        </div>
                                                    </div>

                                                    <!-- Segment 7 - DROPDOWN -->
                                                    <div class="col-sm-2 text-center segment-input segment-7" style="display: none;">
                                                        <label id="labelSegment7">Segment 7</label>
                                                        <?= $cb_segment_7 ?>
                                                    </div>

                                                    <!-- Delimiter 7 (setelah Segment 7) -->
                                                    <div class="col-sm separator delimiter-after-7" style="display: none;">
                                                        <div class="delimiter-display">
                                                            <span id="delimiterValue7"><?php echo htmlspecialchars($default_delimiter); ?></span>
                                                        </div>
                                                    </div>

                                                    <!-- Segment 8 - DROPDOWN -->
                                                    <div class="col-sm-2 text-center segment-input segment-8" style="display: none;">
                                                        <label id="labelSegment8">Segment 8</label>
                                                        <?= $cb_segment_8 ?>
                                                    </div>

                                                    <!-- Delimiter 8 (setelah Segment 8) -->
                                                    <div class="col-sm separator delimiter-after-8" style="display: none;">
                                                        <div class="delimiter-display">
                                                            <span id="delimiterValue8"><?php echo htmlspecialchars($default_delimiter); ?></span>
                                                        </div>
                                                    </div>

                                                    <!-- Segment 9 - DROPDOWN -->
                                                    <div class="col-sm-2 text-center segment-input segment-9" style="display: none;">
                                                        <label id="labelSegment9">Segment 9</label>
                                                        <?= $cb_segment_9 ?>
                                                    </div>

                                                    <!-- Delimiter 9 (setelah Segment 9) -->
                                                    <div class="col-sm separator delimiter-after-9" style="display: none;">
                                                        <div class="delimiter-display">
                                                            <span id="delimiterValue9"><?php echo htmlspecialchars($default_delimiter); ?></span>
                                                        </div>
                                                    </div>

                                                    <!-- Segment 10 - DROPDOWN -->
                                                    <div class="col-sm-2 text-center segment-input segment-10" style="display: none;">
                                                        <label id="labelSegment10">Segment 10</label>
                                                        <?= $cb_segment_10 ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="mb-3 row">
                                                <label for="AccountNumber" class="col-sm-2 col-form-label">Account Number</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control form-control-sm" id="AccountNumber" name="AcctNo" readonly>
                                                    <span class="invalid-feedback errorAcctNo"></span>
                                                </div>
                                                <label for="AcctName" class="col-sm-2 col-form-label">Account Name</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="AcctName" name="AcctName">
                                                    <span class="invalid-feedback errorAcctName"></span>
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label for="NormalBalance" class="col-sm-2 col-form-label">Normal Balance</label>
                                                <div class="col-sm-3">
                                                    <?= $cb_normal_balance ?>
                                                    <span class="invalid-feedback errorAcctBal"></span>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control form-control-sm" id="NormalBalanceDesc" name="NormalBalanceDesc" readonly>
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label for="AccountType" class="col-sm-2 col-form-label">Account Type</label>
                                                <div class="col-sm-3">
                                                    <?= $cb_account_type ?>
                                                    <span class="invalid-feedback errorAcctType"></span>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control form-control-sm" id="AccountTypeDesc" name="AccountTypeDesc" readonly>
                                                </div>
                                            </div>

                                            <div class="mb-3 row account-closing">
                                                <label for="AccountClosing" class="col-sm-2 col-form-label">Account Closing</label>
                                                <div class="input-group input-group-sm col-sm-3">
                                                    <input type="text" class="form-control form-control-sm" id="AccountClosing" name="AccountClosing" style="direction: ltr;" value="" tabindex="1">
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn form-control form-control-sm btn-success btn-flat accountclosing-search-btn"><i class='fas fa-search'></i></button>
                                                    </span>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control form-control-sm" id="AccountClosingDesc" name="AccountClosingDesc" readonly>
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label for="AccountGroupId" class="col-sm-2 col-form-label">Account Group</label>
                                                <div class="input-group input-group-sm col-sm-3">
                                                    <input type="text" class="form-control form-control-sm" id="AccountGroupId" name="AccGrID" style="direction: ltr;" value="" tabindex="1" readonly>
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn form-control form-control-sm btn-success btn-flat" id="accountgrupdatatables"><i class='fas fa-search'></i></button>
                                                    </span>
                                                    <span class="invalid-feedback errorAccGrID"></span>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control form-control-sm" id="AccountGroupName" name="AccountGroupName" readonly>
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label for="Status" class="col-sm-2 col-form-label">Status</label>
                                                <div class="col-sm-3">
                                                    <?= $cb_sta_coa ?>
                                                    <span class="invalid-feedback errorStatus"></span>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control form-control-sm" id="StatusDesc" name="StatusDesc" readonly>
                                                </div>
                                            </div>

                                            <div class="mb-2 row">
                                                <label for="Comment1" class="col-sm-2 col-form-label">Comment1</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control form-control-sm" id="Comment1" name="Comment1" rows="3" style="resize: vertical;"></textarea>
                                                    <span class="invalid-feedback errorComment1"></span>
                                                </div>
                                            </div>

                                            <div class="mb-2 row">
                                                <label for="Comment2" class="col-sm-2 col-form-label">Comment2</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control form-control-sm" id="Comment2" name="Comment2" rows="3" style="resize: vertical;"></textarea>
                                                    <span class="invalid-feedback errorComment2"></span>
                                                </div>
                                            </div>

                                            <div class="mb-2 row">
                                                <label for="Comment3" class="col-sm-2 col-form-label">Comment3</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control form-control-sm" id="Comment3" name="Comment3" rows="3" style="resize: vertical;"></textarea>
                                                    <span class="invalid-feedback errorComment3"></span>
                                                </div>
                                            </div>

                                            <div class="row" style="display: none;">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Note 1</label>
                                                        <textarea class="form-control" id="Note1" name="Note1" rows="3" placeholder="Enter ..." style="height: 87px;"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Note 2</label>
                                                        <textarea class="form-control" id="Note2" name="Note2" rows="3" placeholder="Enter ..." style="height: 87px;"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Hidden inputs tetap di dalam form -->
                                            <input type="hidden" id="AcctType" name="AcctType">
                                            <input type="hidden" id="StructureID" name="StructureID">
                                            <input type="hidden" id="AcctBal" name="AcctBal">

                                            <input type="hidden" id="segment1_hidden" name="segment1_hidden">
                                            <input type="hidden" id="segment2_hidden" name="segment2_hidden">
                                            <input type="hidden" id="segment3_hidden" name="segment3_hidden">
                                            <input type="hidden" id="segment4_hidden" name="segment4_hidden">
                                            <input type="hidden" id="segment5_hidden" name="segment5_hidden">
                                            <input type="hidden" id="segment6_hidden" name="segment6_hidden">
                                            <input type="hidden" id="segment7_hidden" name="segment7_hidden">
                                            <input type="hidden" id="segment8_hidden" name="segment8_hidden">
                                            <input type="hidden" id="segment9_hidden" name="segment9_hidden">
                                            <input type="hidden" id="segment10_hidden" name="segment10_hidden">
                                            <input type="hidden" id="note1_hidden" name="note1_hidden">
                                            <input type="hidden" id="note2_hidden" name="note2_hidden">

                                            <input type="hidden" id="hidden_id" name="hidden_id" />
                                            <input type="hidden" id="action" name="action" value="Add" />

                                            <!-- Tombol submit dipindah ke modal-footer -->
                                        </form>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" name="submit" id="submit_button" form="data_form" class="btn btn-sm btn-primary" value="Simpan"></button>
                                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal untuk Account Group -->
                        <div class="modal fade" id="accountGroupModal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5>
                                            Account Group
                                        </h5>
                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="table-responsive">
                                            <table id="glaccountgrouptable" class="table table-sm table-bordered table-striped" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th width="50" class="text-center">No</th>
                                                        <th width="150" class="text-center">Account Group ID</th>
                                                        <th>Account Group Name</th>
                                                        <th width="100" class="text-center">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                                            <i class="fas fa-times"></i> Tutup
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal untuk Account Closing -->
                        <div class="modal fade" id="accountClosingModal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5>
                                            Account Closing
                                        </h5>
                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="table-responsive">
                                            <table id="glaccountclosingTable" class="table table-sm table-bordered table-striped" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th width="50" class="text-center">No</th>
                                                        <th width="150" class="text-center">Account Number</th>
                                                        <th>Account Name</th>
                                                        <th width="100" class="text-center">Account Type</th>
                                                        <th width="100" class="text-center">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                                            <i class="fas fa-times"></i> Tutup
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Import -->
                        <div class="modal fade" id="modalimport" tabindex="" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLabel"></h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="<?= site_url("tmstglcoa/preview") ?>" id="uploadForm" method="post" enctype="multipart/form-data">
                                            <?= csrf_field(); ?>
                                            <label for="filename">Import Excel File : <a href="<?= site_url("tmstglcoa/download") ?>"><u>Download Format</u></a></label> <br>
                                            <div class="mb-3 row">
                                                <div class="col-sm-7">
                                                    <input type="file" name="filename" id="filename" class="form-control form-control-sm">
                                                </div>
                                                <input type="hidden" name="hide" value="gas">
                                                <div class="col-sm-3">
                                                    <select class="form-control form-control-sm" name="pas">
                                                        <option value="insert">Insert</option>
                                                        <!-- <option value="update">Update</option> -->
                                                    </select>
                                                </div>
                                                <div class="col-sm-2">
                                                    <button type="submit" name="preview" class="btn btn-sm btn-primary form-control form-control-sm" id="preview">Preview</button>
                                                </div>
                                            </div>
                                        </form>

                                        <div id="viewpreview"></div>
                                        <br>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Validation Results untuk COA -->
                        <div class="modal fade modal-validation" id="modalValidationCoa" tabindex="-1" role="dialog" aria-labelledby="modalValidationCoaLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title" id="modalValidationCoaLabel">
                                            <i class="fas fa-exclamation-triangle mr-2"></i> Hasil Validasi Import COA
                                        </h5>
                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="alert alert-warning" id="validationHeaderCoa">
                                        </div>

                                        <div class="table-responsive">
                                            <table id="validationTableCoa" class="table table-bordered" style="width:100%">
                                                <thead class="bg-secondary text-white">
                                                    <tr>
                                                        <th class="text-center" width="10%">No</th>
                                                        <th class="text-center" width="20%">Account Number</th>
                                                        <th>Validasi</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="validationTableBodyCoa">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                                            <i class="fas fa-times"></i> Tutup
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->

                </div>
                <!--/.col (left) -->
                <!-- right column -->
                <div class="col-md-6">

                </div>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?= $this->endSection('content'); ?>

<?= $this->section('script'); ?>

<!-- Toastr -->
<script src="<?= base_url('plugins/toastr/toastr.min.js') ?>"></script>

<!-- Button datatable -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<!-- set menu name by active-menu -->
<script>
    $('#active-menu').html($('p#active-menu').html()); // set top navbar
    $(document).prop("title", $('p#active-menu').html()); // set title
</script>

<script>
    function tmstdiagnosapreview() {
        $.ajax({
            method: "get",
            url: "<?= site_url('tmstglsourceledger/preview'); ?>",
            success: function(data) {
                $('#viewpreview').html(data);
            }
        });
    }
</script>

<script>
    $(document).on('blur', '#AccountNumber', function() {
        const acctNo = $(this).val();
        const action = $('#action').val();
        const hiddenId = $('#hidden_id').val();

        if (acctNo) {
            $.ajax({
                url: "<?= site_url('tmstglcoa/checkduplicate'); ?>",
                method: "POST",
                data: {
                    AcctNo: acctNo,
                    ExcludeAcctNo: action === 'Edit' ? hiddenId : null
                },
                dataType: "JSON",
                success: function(response) {
                    if (response.isDuplicate) {
                        $('#AccountNumber').addClass('is-invalid');
                        $('.errorAcctNo').html(response.message);
                        $('#submit_button').prop('disabled', true);
                    } else {
                        $('#AccountNumber').removeClass('is-invalid');
                        $('.errorAcctNo').html('');
                        $('#submit_button').prop('disabled', false);
                    }
                }
            });
        }
    });
</script>

<script>
    $(document).ready(function() {
        // ========== INISIALISASI ==========
        const accountStructureSelect = $('#cb_account_structure');
        const accountStructureDesc = $('#AccountStructureDesc');
        const segmentContainer = $('#segmentContainer');
        const accountNumberInput = $('#AccountNumber');
        const delimiter = '<?php echo htmlspecialchars($default_delimiter); ?>';

        // ========== SESSION CHECK ==========
        function checkSession(response) {
            if (response.status === 'session_expired') {
                window.location.href = "<?= base_url('auth/login') ?>";
                return false;
            }
            return true;
        }

        // ========== FORMAT DROPDOWN HELPER ==========
        function resetDropdownText(dropdown) {
            $(dropdown).find('option').each(function() {
                const $opt = $(this);
                if ($opt.val()) $opt.text($opt.val());
            });
        }

        // ========== ACCOUNT STRUCTURE CHANGE ==========
        accountStructureSelect.on('change', function() {
            const selectedOption = $(this).find('option:selected');
            const structureName = selectedOption.data('structure-name');
            const segmentsData = selectedOption.data('segments');

            accountStructureDesc.val(structureName);
            $('.segment-input').hide();
            $('.separator').hide();
            $('#segment1').val('');
            for (let i = 2; i <= 10; i++) $(`#cb_segment_${i}`).val('');
            accountNumberInput.val('');

            if (segmentsData && Array.isArray(segmentsData)) {
                const validSegments = segmentsData.filter(segment =>
                    segment.segmentID && segment.segmentID.trim() !== '' &&
                    segment.segmentNo && segment.segmentNo.trim() !== ''
                ).sort((a, b) => parseInt(a.segmentNo) - parseInt(b.segmentNo));

                if (validSegments.length > 0) {
                    validSegments.forEach((segment, index) => {
                        const segmentNo = parseInt(segment.segmentNo);
                        $(`.segment-${segmentNo}`).show();
                        $(`#labelSegment${segmentNo}`).text(segment.segmentName || `Segment ${segmentNo}`);

                        if (segmentNo === 1) {
                            const len = parseInt(segment.segmentLength) || 4;
                            $('#segment1').attr({
                                'placeholder': 'X'.repeat(len),
                                'maxlength': len
                            });
                        }
                        if (index < validSegments.length - 1) $(`.delimiter-after-${segmentNo}`).show();
                    });
                    segmentContainer.show();
                    setTimeout(() => $('#segment1').focus(), 100);
                    updateAccountNumber();
                } else segmentContainer.hide();
            } else segmentContainer.hide();
        });

        // ========== UPDATE ACCOUNT NUMBER ==========
        function updateAccountNumber() {
            let accountNumber = '';
            for (let i = 1; i <= 10; i++) {
                if (!$(`.segment-${i}`).is(':visible')) continue;
                let value = i === 1 ? $('#segment1').val().trim() : $(`#cb_segment_${i}`).val();
                if (value) {
                    if (accountNumber) accountNumber += delimiter;
                    accountNumber += value;
                }
            }
            accountNumberInput.val(accountNumber);
        }

        // ========== DROPDOWN CHANGE HANDLERS ==========
        $(document).on('change', '#cb_normal_balance', function() {
            const selected = $(this).find('option:selected');
            const desc = selected.data('desc');
            $('#NormalBalanceDesc').val(desc);
            $('#AcctBal').val($(this).val());
            resetDropdownText(this);
        });

        $(document).on('change', '#cb_account_type', function() {
            const selected = $(this).find('option:selected');
            const desc = selected.data('desc');
            const value = $(this).val();
            $('#AccountTypeDesc').val(desc);
            $('#AcctType').val($(this).val());
            resetDropdownText(this);

            if (value === 'I') {
                $('.account-closing').slideDown(300);
            } else {
                $('.account-closing').slideUp(300);
                $('#AccountClosing, #AccountClosingDesc').val('');
            }
        });

        $(document).on('change', '#cb_account_structure', function() {
            $('#StructureID').val($(this).val());
        });

        $(document).on('change', '#cb_sta_coa', function() {
            const selected = $(this).find('option:selected');
            const desc = selected.data('desc');
            $('#StatusDesc').val(desc);
            resetDropdownText(this);
        });

        // ========== SEGMENT CHANGE HANDLERS ==========
        $(document).on('input', '#segment1', function() {
            const maxLength = $(this).attr('maxlength');
            if (maxLength && $(this).val().length > maxLength) {
                $(this).val($(this).val().substring(0, maxLength));
            }
            updateAccountNumber();
            $('#segment1_hidden').val($(this).val());
        });

        $(document).on('change', '#cb_segment_2', function() {
            $('#segment2_hidden').val($(this).val());
            updateAccountNumber();
        });
        $(document).on('change', '#cb_segment_3', function() {
            $('#segment3_hidden').val($(this).val());
            updateAccountNumber();
        });
        $(document).on('change', '#cb_segment_4', function() {
            $('#segment4_hidden').val($(this).val());
            updateAccountNumber();
        });
        $(document).on('change', '#cb_segment_5', function() {
            $('#segment5_hidden').val($(this).val());
            updateAccountNumber();
        });
        $(document).on('change', '#cb_segment_6', function() {
            $('#segment6_hidden').val($(this).val());
            updateAccountNumber();
        });
        $(document).on('change', '#cb_segment_7', function() {
            $('#segment7_hidden').val($(this).val());
            updateAccountNumber();
        });
        $(document).on('change', '#cb_segment_8', function() {
            $('#segment8_hidden').val($(this).val());
            updateAccountNumber();
        });
        $(document).on('change', '#cb_segment_9', function() {
            $('#segment9_hidden').val($(this).val());
            updateAccountNumber();
        });
        $(document).on('change', '#cb_segment_10', function() {
            $('#segment10_hidden').val($(this).val());
            updateAccountNumber();
        });

        $(document).on('input', '#Note1', function() {
            $('#note1_hidden').val($(this).val());
        });
        $(document).on('input', '#Note2', function() {
            $('#note2_hidden').val($(this).val());
        });

        // ========== MOUSEDOWN DROPDOWN ==========
        $(document).on('mousedown', '#cb_normal_balance, #cb_account_type, #cb_sta_coa', function() {
            $(this).find('option').each(function() {
                const $opt = $(this);
                if ($opt.val()) {
                    const id = $opt.data('id') || $opt.val();
                    const desc = $opt.data('desc');
                    if (id && desc) $opt.text(id + ' - ' + desc);
                }
            });
        });

        // ========== ADD RECORD ==========
        $(document).on('click', '#add_record', function() {
            $('#data_form')[0].reset();
            $('.is-invalid').removeClass('is-invalid');
            $('[class^="error"]').html('');

            $('#original_AcctNo, #original_AcctName, #original_AcctType, #original_AccGrID, #original_StructureID, #original_AcctBal').val('');
            $('#AcctType, #StructureID, #AcctBal').val('');
            $('#segment1_hidden, #segment2_hidden, #segment3_hidden, #segment4_hidden, #segment5_hidden, #segment6_hidden, #segment7_hidden, #segment8_hidden, #segment9_hidden, #segment10_hidden, #note1_hidden, #note2_hidden').val('');
            $('#segment1').val('');
            $('#cb_segment_2, #cb_segment_3, #cb_segment_4, #cb_segment_5, #cb_segment_6, #cb_segment_7, #cb_segment_8, #cb_segment_9, #cb_segment_10').val('');

            $('#cb_account_structure, #segment1, #cb_segment_2, #cb_segment_3, #cb_segment_4, #cb_segment_5, #cb_segment_6, #cb_segment_7, #cb_segment_8, #cb_segment_9, #cb_segment_10').prop('disabled', false);
            $('#AccountNumber').prop('readonly', false);
            $('#AcctName, #cb_normal_balance, #cb_account_type, #AccountGroupId, #cb_sta_coa, #AccountClosing, #Comment1, #Comment2, #Comment3').prop('disabled', false);
            $('#AccountStructureDesc, #NormalBalanceDesc, #AccountTypeDesc, #AccountGroupName, #StatusDesc, #AccountClosingDesc').prop('disabled', false);

            $('.accountclosing-search-btn, #accountgrupdatatables').prop('disabled', false);

            $('#AccountNumber').prop('readonly', false);

            $('#submit_button').show();

            setTimeout(() => {
                $('#cb_account_structure, #cb_normal_balance, #cb_account_type, #cb_sta_coa').trigger('change');
                $('#segment1').trigger('input');
                $('#cb_segment_2, #cb_segment_3, #cb_segment_4, #cb_segment_5, #cb_segment_6, #cb_segment_7, #cb_segment_8, #cb_segment_9, #cb_segment_10').trigger('change');
            }, 100);

            $('.modal-title').text('Tambah Data');
            $('#action').val('Add');
            $('#submit_button').val('Simpan').html('Simpan');
            $('#modalform').modal('show');
        });

        // ========== FORM SUBMIT ==========
        $('#data_form').on('submit', function(event) {
            event.preventDefault();

            $.ajax({
                url: "<?= site_url('tmstglcoa/action'); ?>",
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                beforeSend: function() {
                    $('#submit_button').prop('disabled', true).html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('#submit_button').prop('disabled', false).html('Simpan');
                },
                success: function(response) {
                    if (!checkSession(response)) return;

                    if (response.error) {
                        showValidationErrors(response.error);
                    } else if (response.status === 'error') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message || 'Terjadi kesalahan saat menyimpan data.'
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message || 'Data berhasil disimpan.'
                        });

                        clearFormValidation();
                        $('#data_form')[0].reset();
                        $('#modalform').modal('hide');
                        $('#glcoaTable').DataTable().ajax.reload(null, false);
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'Gagal menghubungi server. Silakan coba lagi nanti.'
                    });
                    console.error('AJAX Error:', status, error);
                }
            });
        });

        // ========== VALIDATION FUNCTIONS ==========
        function showValidationErrors(errors) {
            const errorMap = {
                'AcctNo': 'AccountNumber',
                'AcctName': 'AcctName',
                'AcctType': 'cb_account_type',
                'AccGrID': 'AccountGroupId',
                'StructureID': 'cb_account_structure',
                'AcctBal': 'cb_normal_balance'
            };

            $('.is-invalid').removeClass('is-invalid');
            $('[class^="error"]').html('');

            Object.keys(errors).forEach(function(field) {
                const elementId = errorMap[field];
                if (elementId && errors[field]) {
                    $('#' + elementId).addClass('is-invalid');
                    $('.error' + field).html(errors[field]);
                }
            });
        }

        function clearFormValidation() {
            $('.is-invalid').removeClass('is-invalid');
            $('[class^="error"]').html('');
        }

        // ========== IMPORT HANDLER ==========
        // Handler untuk tombol import (menggunakan event delegation karena tombol dibuat dinamis)
        $(document).on('click', '#postButton', function() {
            var btn = $(this);
            var originalText = btn.html();
            btn.html('<i class="fa fa-spinner fa-spin"></i> Importing...').prop('disabled', true);

            console.log('Post button clicked, sending request...');

            // Ambil CSRF token dari meta tag atau gunakan yang sudah ada
            var csrfToken = $('meta[name="csrf-token"]').attr('content') || '<?= csrf_hash() ?>';

            $.ajax({
                url: '<?= site_url('tmstglcoa/upload') ?>',
                type: 'POST',
                data: {
                    csrf_token_name: csrfToken,
                    file_path: $('#current_file_path').val()
                },
                dataType: 'json',
                success: function(response) {
                    console.log('Response received:', response);

                    // Cek apakah ada validasi error
                    if (response.success === false && response.validations && response.validations.length > 0) {
                        console.log('Showing validation modal with', response.validations.length, 'errors');
                        showValidationModalCoa(response.validations, response.message);
                    }
                    // Cek apakah sukses
                    else if (response.success === true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses!',
                            text: response.message || 'Import data berhasil',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#modalimport').modal('hide');
                                $('#glcoaTable').DataTable().ajax.reload(null, false);
                            }
                        });
                    }
                    // Cek error biasa
                    else if (response.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.error,
                            confirmButtonText: 'OK'
                        });
                    }
                    // Response lain
                    else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message || 'Terjadi kesalahan saat import data',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    console.error('Response:', xhr.responseText);

                    let errorMsg = 'Request failed: ' + error;
                    try {
                        let response = JSON.parse(xhr.responseText);
                        if (response.error) errorMsg = response.error;
                        else if (response.message) errorMsg = response.message;
                    } catch (e) {}

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMsg,
                        confirmButtonText: 'OK'
                    });
                },
                complete: function() {
                    btn.html(originalText).prop('disabled', false);
                }
            });
        });

        window.showValidationModalCoa = function(validations, message) {
            $('#validationHeaderCoa').html(`
        <strong>Gagal Import Data, validasi Ditemukan</strong>
    `);

            $('#validationTableBodyCoa').empty();

            if (validations && validations.length > 0) {
                validations.forEach(function(item, index) {
                    let rowNumber = item.rowNumber || item.RowNumber || (index + 1);
                    let acctNo = item.acctNo || item.AcctNo || '-';
                    let validationMsg = item.validationMessage || item.ValidationMessage || '-';

                    validationMsg = validationMsg.replace(/"/g, '');

                    $('#validationTableBodyCoa').append(`
                <tr>
                    <td class="text-center align-middle">${escapeHtml(String(rowNumber))}</td>
                    <td class="text-center align-middle">${escapeHtml(String(acctNo))}</td>
                    <td class="align-middle">${escapeHtml(String(validationMsg)).replace(/;/g, ';<br>')}</td>
                </tr>
            `);
                });
            } else {
                $('#validationTableBodyCoa').append(`
            <tr>
                <td colspan="3" class="text-center">Tidak ada data validasi</td>
            </tr>
        `);
            }

            $('#modalValidationCoa').modal({
                backdrop: 'static',
                keyboard: false
            });
            $('#modalValidationCoa').modal('show');
        };

        window.escapeHtml = function(text) {
            if (!text) return '';
            return String(text)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        };

        // ========== VIEW DATA ==========
        $(document).on('click', '.view', function() {
            const AcctNo = $(this).data('acctno');

            $.ajax({
                url: "<?= site_url('tmstglcoa/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    AcctNo
                },
                dataType: "JSON",
                success: function(response) {
                    $('#data_form')[0].reset();
                    $('.is-invalid').removeClass('is-invalid');
                    $('[class^="error"]').html('');

                    const data = response.data;

                    $('#cb_account_structure').val(data.StructureID).trigger('change');
                    $('#AccountStructureDesc').val(data.StructureName);

                    $('#segment1').val(data.Segment1 || '');
                    $('#cb_segment_2').val(data.Segment2 || '').trigger('change');
                    $('#cb_segment_3').val(data.Segment3 || '').trigger('change');
                    $('#cb_segment_4').val(data.Segment4 || '').trigger('change');
                    $('#cb_segment_5').val(data.Segment5 || '').trigger('change');
                    $('#cb_segment_6').val(data.Segment6 || '').trigger('change');
                    $('#cb_segment_7').val(data.Segment7 || '').trigger('change');
                    $('#cb_segment_8').val(data.Segment8 || '').trigger('change');
                    $('#cb_segment_9').val(data.Segment9 || '').trigger('change');
                    $('#cb_segment_10').val(data.Segment10 || '').trigger('change');

                    if (typeof updateAccountNumber === 'function') updateAccountNumber();

                    $('#AccountNumber').val(data.AcctNo).prop('disabled', true);
                    $('#AcctName').val(data.AcctName).prop('disabled', true);
                    $('#cb_normal_balance').val(data.AcctBal).prop('disabled', true);
                    $('#NormalBalanceDesc').val(data.AcctBalDesc).prop('disabled', true);
                    $('#cb_account_type').val(data.AcctType).prop('disabled', true);
                    $('#AccountTypeDesc').val(data.AcctTypeDesc).prop('disabled', true);
                    $('#AccountGroupId').val(data.AccGrID).prop('disabled', true);
                    $('#AccountGroupName').val(data.AccGrName).prop('disabled', true);

                    const statusValue = data.AcvStatus ? '1' : '0';
                    $('#cb_sta_coa').val(statusValue).prop('disabled', true);
                    $('#StatusDesc').val(data.IsActiveDesc).prop('disabled', true);
                    $('#AccountClosing').val(data.AcctCls === 'NULL' ? '' : data.AcctCls).prop('disabled', true);
                    $('#AccountClosingDesc').val(data.AcctCls === 'NULL' ? '' : data.AcctCls).prop('disabled', true);
                    $('#Comment1').val(data.Comment1).prop('disabled', true);
                    $('#Comment2').val(data.Comment2).prop('disabled', true);
                    $('#Comment3').val(data.Comment3).prop('disabled', true);

                    $('#cb_account_structure, #segment1, #cb_segment_2, #cb_segment_3, #cb_segment_4, #cb_segment_5, #cb_segment_6, #cb_segment_7, #cb_segment_8, #cb_segment_9, #cb_segment_10').prop('disabled', true);
                    $('.accountclosing-search-btn, #accountgrupdatatables').prop('disabled', true);

                    $('.modal-title').text('Lihat Data');
                    $('#action').val('View');
                    $('#submit_button').hide();
                    $('#modalform').modal('show');
                    $('#hidden_id').val(AcctNo);
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal melihat data',
                        text: 'Terjadi kesalahan saat mengambil data COA.'
                    });
                }
            });
        });

        // ========== EDIT DATA ==========
        $(document).on('click', '.edit', function() {
            const AcctNo = $(this).data('acctno');

            $.ajax({
                url: "<?= site_url('tmstglcoa/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    AcctNo
                },
                dataType: "JSON",
                success: function(response) {
                    $('#data_form')[0].reset();
                    $('.is-invalid').removeClass('is-invalid');
                    $('[class^="error"]').html('');

                    const data = response.data;

                    // Original values
                    $('#original_AcctNo').val(data.AcctNo);
                    $('#original_AcctName').val(data.AcctName);
                    $('#original_AcctType').val(data.AcctType);
                    $('#original_AccGrID').val(data.AccGrID);
                    $('#original_StructureID').val(data.StructureID);
                    $('#original_AcctBal').val(data.AcctBal);

                    // Hidden inputs
                    $('#AcctType').val(data.AcctType);
                    $('#StructureID').val(data.StructureID);
                    $('#AcctBal').val(data.AcctBal);

                    // Segment hidden inputs
                    $('#segment1_hidden').val(data.Segment1 || '');
                    $('#segment2_hidden').val(data.Segment2 || '');
                    $('#segment3_hidden').val(data.Segment3 || '');
                    $('#segment4_hidden').val(data.Segment4 || '');
                    $('#segment5_hidden').val(data.Segment5 || '');
                    $('#segment6_hidden').val(data.Segment6 || '');
                    $('#segment7_hidden').val(data.Segment7 || '');
                    $('#segment8_hidden').val(data.Segment8 || '');
                    $('#segment9_hidden').val(data.Segment9 || '');
                    $('#segment10_hidden').val(data.Segment10 || '');
                    $('#note1_hidden').val(data.Note1 || '');
                    $('#note2_hidden').val(data.Note2 || '');

                    $('#cb_account_structure').val(data.StructureID).trigger('change').prop('disabled', false);
                    $('#AccountStructureDesc').val(data.StructureName).prop('disabled', false);

                    $('#segment1').val(data.Segment1 || '').prop('disabled', false);
                    $('#cb_segment_2').val(data.Segment2 || '').trigger('change').prop('disabled', false);
                    $('#cb_segment_3').val(data.Segment3 || '').trigger('change').prop('disabled', false);
                    $('#cb_segment_4').val(data.Segment4 || '').trigger('change').prop('disabled', false);
                    $('#cb_segment_5').val(data.Segment5 || '').trigger('change').prop('disabled', false);
                    $('#cb_segment_6').val(data.Segment6 || '').trigger('change').prop('disabled', false);
                    $('#cb_segment_7').val(data.Segment7 || '').trigger('change').prop('disabled', false);
                    $('#cb_segment_8').val(data.Segment8 || '').trigger('change').prop('disabled', false);
                    $('#cb_segment_9').val(data.Segment9 || '').trigger('change').prop('disabled', false);
                    $('#cb_segment_10').val(data.Segment10 || '').trigger('change').prop('disabled', false);

                    if (typeof updateAccountNumber === 'function') updateAccountNumber();

                    $('#AccountNumber').val(data.AcctNo).prop('readonly', true);
                    $('#AcctName').val(data.AcctName).prop('disabled', false);
                    $('#cb_normal_balance').val(data.AcctBal).trigger('change').prop('disabled', false);
                    $('#NormalBalanceDesc').val(data.AcctBalDesc).prop('disabled', false);
                    $('#cb_account_type').val(data.AcctType).trigger('change').prop('disabled', false);
                    $('#AccountTypeDesc').val(data.AcctTypeDesc).prop('disabled', false);
                    $('#AccountGroupId').val(data.AccGrID).prop('disabled', false);
                    $('#AccountGroupName').val(data.AccGrName).prop('disabled', false);

                    const statusValue = data.AcvStatus ? '1' : '0';
                    $('#cb_sta_coa').val(statusValue).trigger('change').prop('disabled', false);
                    $('#StatusDesc').val(data.IsActiveDesc).prop('disabled', false);
                    $('#AccountClosing').val(data.AcctCls === 'NULL' ? '' : data.AcctCls).prop('disabled', false);
                    $('#AccountClosingDesc').val(data.AcctName === 'NULL' ? '' : data.AcctName).prop('disabled', false);
                    $('#Comment1').val(data.Comment1).prop('disabled', false);
                    $('#Comment2').val(data.Comment2).prop('disabled', false);
                    $('#Comment3').val(data.Comment3).prop('disabled', false);

                    $('.accountclosing-search-btn, #accountgrupdatatables').prop('disabled', false);

                    if ($('#CreatedDate').length && data.CreatedDate) {
                        const d = new Date(data.CreatedDate);
                        const formatted = `${String(d.getDate()).padStart(2,'0')}/${String(d.getMonth()+1).padStart(2,'0')}/${d.getFullYear()}`;
                        $('#CreatedDate').val(formatted).prop('readonly', true);
                    }
                    if ($('#CreatedBy').length) $('#CreatedBy').val(data.CreatedBy).prop('readonly', true);
                    if ($('#UpdatedDate').length) {
                        if (data.UpdatedDate) {
                            const d = new Date(data.UpdatedDate);
                            const formatted = `${String(d.getDate()).padStart(2,'0')}/${String(d.getMonth()+1).padStart(2,'0')}/${d.getFullYear()}`;
                            $('#UpdatedDate').val(formatted).prop('readonly', true);
                        } else $('#UpdatedDate').val('').prop('readonly', true);
                    }
                    if ($('#UpdatedBy').length) $('#UpdatedBy').val(data.UpdatedBy).prop('readonly', true);

                    $('.modal-title').text('Ubah Data Master COA');
                    $('#action').val('Edit');
                    $('#submit_button').val('Simpan').html('Simpan').show();
                    $('#modalform').modal('show');
                    $('#hidden_id').val(data.AcctNo || AcctNo);
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal mengambil data',
                        text: 'Terjadi kesalahan saat mengambil data COA.'
                    });
                }
            });
        });

        function confirmDelete({
            acctNo,
            url,
            tableId
        }) {
            Swal.fire({
                title: 'Hapus COA?',
                text: 'Data COA akan dihapus secara permanen. Lanjutkan?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (!result.isConfirmed) return;

                $.ajax({
                    url,
                    method: 'POST',
                    data: {
                        AcctNo: acctNo
                    },
                    dataType: 'JSON',
                    success: function(res) {
                        if (res.success === true) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: res.message || 'COA berhasil dihapus',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                $(`#${tableId}`).DataTable().ajax.reload(null, false);
                            });
                        } else {
                            let message = res.message || 'Terjadi kesalahan';
                            let title = 'Gagal!';

                            if (res.status === 'TERPAKAI') {
                                title = 'Tidak Dapat Dihapus';
                                message = 'COA tidak dapat dihapus karena sudah digunakan di jurnal.';

                                Swal.fire({
                                    icon: 'error',
                                    title: title,
                                    text: message
                                });
                            } else if (res.status === 'AKTIF') {
                                title = 'COA Masih Aktif';

                                Swal.fire({
                                    icon: 'warning',
                                    title: title,
                                    html: `
                                <div style="text-align: left;">
                                    <p style="margin-bottom: 10px; font-weight: bold; color: #dc3545;">${message}</p>
                                    <p style="margin-bottom: 5px;"><strong>Cara menon-aktifkan COA:</strong></p>
                                    <ol style="text-align: left; margin-top: 5px;">
                                        <li>Klik tombol Edit pada data COA ini</li>
                                        <li>Ubah Status menjadi <strong>Tidak Aktif</strong></li>
                                        <li>Klik tombol Simpan</li>
                                        <li>Kembali hapus data COA</li>
                                    </ol>
                                </div>
                            `,
                                    confirmButtonText: 'Ok',
                                    confirmButtonColor: '#3085d6'
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: title,
                                    text: message
                                });
                            }
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = 'Terjadi kesalahan server';
                        try {
                            const response = JSON.parse(xhr.responseText);
                            errorMsg = response.message || errorMsg;
                        } catch (e) {}

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMsg
                        });
                    }
                });
            });
        }

        $(document).on('click', '.delete', function() {
            const acctNo = $(this).data('acctno');
            confirmDelete({
                acctNo,
                url: "<?= site_url('tmstglcoa/delete'); ?>",
                tableId: 'glcoaTable'
            });
        });

        // ========== IMPORT DATA ==========
        $(document).on('click', '#import', function() {
            $('.modal-title').text('Import Data Chart Of Account');
            $("#filename").val(null);
            $('#viewpreview').html('');
            $('#modalimport').modal('show');
        });

        $('#uploadForm').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: '<?= site_url("tmstglcoa/preview") ?>',
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#preview').prop('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Previewing...');
                },
                complete: function() {
                    $('#preview').prop('disabled', false).html('<i class="fa fa-eye"></i> Preview');
                },
                success: function(data) {
                    $('#viewpreview').html(data);
                },
                error: function(xhr) {
                    let errorMsg = 'Gagal preview file';
                    try {
                        let response = JSON.parse(xhr.responseText);
                        if (response.error) errorMsg = response.error;
                    } catch (e) {}
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMsg
                    });
                }
            });
        });

        // ========== ACCOUNT GROUP MODAL ==========
        var accountGroupTable;
        $('#accountgrupdatatables').on('click', function() {
            $('#accountGroupModal').modal('show');

            if ($.fn.DataTable.isDataTable('#glaccountgrouptable')) {
                $('#glaccountgrouptable').DataTable().destroy();
            }

            accountGroupTable = $("#glaccountgrouptable").DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>><"row"<"col-sm-12"tr>><"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                ajax: {
                    url: "<?= base_url('tmstglcoa/datatablesaccountgroup') ?>",
                    type: "POST",
                    contentType: "application/json",
                    data: function(d) {
                        return JSON.stringify(d);
                    }
                },
                columnDefs: [{
                    orderable: false,
                    targets: [0, 3]
                }, {
                    targets: [0, 3],
                    className: 'text-center'
                }],
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        orderable: false
                    },
                    {
                        data: 'accGrId',
                        className: 'text-center'
                    },
                    {
                        data: 'accGrName'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return '<button class="btn btn-sm btn-primary btn-pilih" data-id="' + row.accGrId + '" data-name="' + row.accGrName + '"><i class="fas fa-check mr-1"></i>Pilih</button>';
                        },
                        orderable: false
                    }
                ],
                language: {
                    sSearch: "Cari:",
                    sInfoEmpty: "Tidak ada data",
                    sInfo: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    sInfoFiltered: "(disaring dari _MAX_ total data)",
                    sZeroRecords: "Data tidak ditemukan",
                    sLengthMenu: "Tampilkan _MENU_ data",
                    oPaginate: {
                        sFirst: "Pertama",
                        sPrevious: "Sebelum",
                        sNext: "Berikut",
                        sLast: "Akhir"
                    }
                }
            });
        });

        $(document).on('click', '#glaccountgrouptable .btn-pilih', function() {
            $('#AccountGroupId').val($(this).data('id'));
            $('#AccountGroupName').val($(this).data('name'));
            $('#accountGroupModal').modal('hide');
        });

        $(document).on('dblclick', '#glaccountgrouptable tbody tr', function() {
            if (accountGroupTable) {
                var data = accountGroupTable.row(this).data();
                if (data) {
                    $('#AccountGroupId').val(data.accGrId);
                    $('#AccountGroupName').val(data.accGrName);
                    $('#accountGroupModal').modal('hide');
                }
            }
        });

        $('#accountGroupModal').on('hidden.bs.modal', function() {
            if ($.fn.DataTable.isDataTable('#glaccountgrouptable')) {
                $('#glaccountgrouptable').DataTable().destroy();
            }
        });

        // ========== ACCOUNT CLOSING MODAL ==========
        $('.account-closing').hide();
        if ($('#cb_account_type').val() === 'I') $('.account-closing').show();

        var accountClosingTable;
        $(document).on('click', '.accountclosing-search-btn', function(e) {
            e.preventDefault();

            if ($('#cb_account_type').val() !== 'I') {
                alert('Hanya bisa memilih Account Closing untuk tipe akun "I"');
                return false;
            }

            $('#accountClosingModal').modal('show');

            if ($.fn.DataTable.isDataTable('#glaccountclosingTable')) {
                $('#glaccountclosingTable').DataTable().destroy();
            }

            accountClosingTable = $("#glaccountclosingTable").DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>><"row"<"col-sm-12"tr>><"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                ajax: {
                    url: "<?= base_url('tmstglcoa/datatablesaccountclosing') ?>",
                    type: "POST",
                    contentType: "application/json",
                    data: function(d) {
                        return JSON.stringify(d);
                    }
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        orderable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'acctNo',
                        className: 'text-center'
                    },
                    {
                        data: 'acctName'
                    },
                    {
                        data: 'acctType',
                        className: 'text-center'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return '<button class="btn btn-sm btn-primary btn-pilih-closing" data-id="' + row.acctNo + '" data-name="' + row.acctName + '"><i class="fas fa-check mr-1"></i>Pilih</button>';
                        },
                        orderable: false,
                        className: 'text-center'
                    }
                ],
                language: {
                    sSearch: "Cari:",
                    sInfoEmpty: "Tidak ada data",
                    sInfo: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    sInfoFiltered: "(disaring dari _MAX_ total data)",
                    sZeroRecords: "Data tidak ditemukan",
                    sLengthMenu: "Tampilkan _MENU_ data",
                    oPaginate: {
                        sFirst: "Pertama",
                        sPrevious: "Sebelum",
                        sNext: "Berikut",
                        sLast: "Akhir"
                    }
                }
            });
        });

        $(document).on('click', '.btn-pilih-closing', function() {
            $('#AccountClosing').val($(this).data('id'));
            $('#AccountClosingDesc').val($(this).data('name'));
            $('#accountClosingModal').modal('hide');
        });

        $(document).on('dblclick', '#glaccountclosingTable tbody tr', function() {
            if (accountClosingTable) {
                var data = accountClosingTable.row(this).data();
                if (data) {
                    $('#AccountClosing').val(data.acctNo);
                    $('#AccountClosingDesc').val(data.acctName);
                    $('#accountClosingModal').modal('hide');
                }
            }
        });

        // ========== DATATABLES GLCOA ==========
        $("#glcoaTable").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            dom: 'Bfrtip',
            ajax: {
                url: "<?= base_url('tmstglcoa/datatables') ?>",
                type: "POST",
                contentType: "application/json",
                data: function(d) {
                    return JSON.stringify(d);
                }
            },
            columnDefs: [{
                orderable: false,
                targets: [0, 6]
            }, {
                targets: [0, 6],
                className: 'text-center'
            }],
            columns: [{
                    data: 'rownum',
                    orderable: false
                },
                {
                    data: 'acctNo'
                },
                {
                    data: 'acctName'
                },
                {
                    data: 'acctTypeDesc'
                },
                {
                    data: 'accGrName'
                },
                {
                    data: 'isActiveDesc'
                },
                {
                    data: 'aksi',
                    orderable: false
                }
            ],
            buttons: [{
                    text: "Tambah",
                    action: function() {},
                    attr: {
                        id: "add_record",
                        style: "background-color:#56b746; <?= session()->get('flag_insert') === 1 ? '' : 'd-none' ?>",
                        name: "add_record"
                    }
                },
                {
                    text: "Excel",
                    action: function() {
                        window.location.href = "<?= site_url('tmstglcoa/exportExcel') ?>";
                    },
                    className: "btn-sm btn-primary <?= session()->get('flag_export') === 1 ? '' : 'd-none' ?>"
                },
                {
                    extend: "print",
                    text: "Cetak",
                    className: "btn-sm btn-info <?= session()->get('flag_print') === 1 ? '' : 'd-none' ?>",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
                {
                    text: "Import",
                    action: function() {},
                    attr: {
                        id: "import",
                        style: "background-color:#56b746; <?= session()->get('flag_insert') === 1 ? '' : 'd-none' ?>",
                        nameClass: "btn btn-sm btn-warning"
                    }
                }
            ],
            oLanguage: {
                sSearch: "Cari Data:",
                sInfoEmpty: "Tidak ada data",
                sInfo: "Total: _TOTAL_ data",
                sInfoFiltered: " dari _MAX_ data",
                sZeroRecords: "Data tidak ditemukan",
                oPaginate: {
                    sFirst: "Awal",
                    sPrevious: "Sebelum",
                    sNext: "Berikut",
                    sLast: "Akhir"
                }
            }
        }).buttons().container().appendTo("#glcoaTable_wrapper .col-md-6:eq(0)");

        $('#glcoaTable').on('xhr.dt', function(e, settings, json) {
            if (json && json.status === 'session_expired') {
                window.location.href = "<?= base_url('auth/login') ?>";
                alert('Sesi Anda telah berakhir. Silakan login kembali.');
            }
        });


        if (accountStructureSelect.val()) {
            accountStructureSelect.trigger('change');
        }
    });
</script>



<?= $this->endSection('script'); ?>