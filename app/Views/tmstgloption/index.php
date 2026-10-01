<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>
<!-- Toastr -->
<link rel="stylesheet" href="<?= base_url('plugins/toastr/toastr.min.css') ?>">
<!-- Button datatable -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
<!-- Bootstrap Datepicker CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
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

    /* Custom styles for tabs */
    .content-wrapper {
        background-color: #f4f6f9;
        min-height: 100vh;
    }

    .card-outline {
        border-top: 3px solid #17a2b8;
    }

    .nav-tabs {
        border-bottom: 1px solid #dee2e6;
        background-color: transparent;
    }

    .nav-tabs .nav-link {
        color: #6c757d;
        font-weight: 500;
        border: none;
        padding: 12px 20px;
        background-color: transparent;
        margin-bottom: 0;
    }

    .nav-tabs .nav-link:hover {
        color: #17a2b8;
        background-color: transparent;
        border: none;
    }

    .nav-tabs .nav-link.active {
        color: #17a2b8;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-bottom-color: #fff;
        border-radius: 4px 4px 0 0;
    }

    .nav-tabs .nav-link:not(.active):hover {
        color: #17a2b8;
        background-color: rgba(23, 162, 184, 0.05);
        border-radius: 4px 4px 0 0;
    }

    .section-content {
        padding: 20px 0;
    }

    .form-section {
        background-color: #fff;
        border-radius: 5px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 0 1px rgba(0, 0, 0, 0.1);
    }

    .btn-info {
        background-color: #17a2b8;
        border-color: #17a2b8;
    }

    .btn-info:hover {
        background-color: #138496;
        border-color: #117a8b;
    }

    .table-actions .btn {
        margin-right: 5px;
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
                <div class="col-sm-12">
                    <!-- jquery validation -->
                    <div class="card card-outline card-info">
                        <div class="card-body">
                            <div class="card-title">
                                <!-- Tab Navigation -->
                                <ul class="nav nav-tabs" id="sectionTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="address-tab" data-bs-toggle="tab" data-bs-target="#address" type="button" role="tab" aria-controls="address" aria-selected="true">
                                            Address
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="posting-tab" data-bs-toggle="tab" data-bs-target="#posting" type="button" role="tab" aria-controls="posting" aria-selected="false">
                                            Posting
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="segments-tab" data-bs-toggle="tab" data-bs-target="#segments" type="button" role="tab" aria-controls="segments" aria-selected="false">
                                            Segments
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="email-tab" data-bs-toggle="tab" data-bs-target="#email" type="button" role="tab" aria-controls="email" aria-selected="false">
                                            Email
                                        </button>
                                    </li>
                                </ul>
                            </div>

                            <!-- Tab Content -->
                            <div class="tab-content mt-5" id="sectionTabsContent">
                                <!-- GL Option Address Section -->
                                <div class="tab-pane fade show active" id="address" role="tabpanel" aria-labelledby="address-tab">
                                    <div class="section-content">
                                        <div class="form-section">
                                            <form id="gloptionaddressform" autocomplete="off">
                                                <?= csrf_field(); ?>
                                                <input type="hidden" class="form-control" id="SystemID" name="SystemID">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="mb-3">
                                                            <label for="CompanyId" class="form-label">Company ID</label>
                                                            <input type="text" class="form-control" id="CompanyId" name="CompanyId">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="mb-3">
                                                            <label for="LegalName" class="form-label">Legal Name</label>
                                                            <input type="text" class="form-control" id="LegalName" name="LegalName">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="mb-3">
                                                            <label for="TaxNumber" class="form-label">Tax Number</label>
                                                            <input type="text" class="form-control" id="TaxNumber" name="TaxNumber">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-9">
                                                        <div class="mb-3">
                                                            <label for="BusinessRegistration" class="form-label">Business Registration Number</label>
                                                            <input type="text" class="form-control" id="BusinessRegistration" name="BusinessRegistration">
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>

                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="mb-3">
                                                            <label for="ContactName" class="form-label">Contact Name</label>
                                                            <input type="text" class="form-control" id="ContactName" name="ContactName">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="mb-3">
                                                            <label for="Phone" class="form-label">Phone</label>
                                                            <input type="text" class="form-control" id="Phone" name="Phone">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="mb-3">
                                                            <label for="Fax" class="form-label">Fax</label>
                                                            <input type="text" class="form-control" id="Fax" name="Fax">
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="mb-3">
                                                            <label for="AddressLine1" class="form-label">Address Line 1</label>
                                                            <input type="text" class="form-control" id="AddressLine1" name="AddressLine1">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="mb-3">
                                                            <label for="City" class="form-label">City</label>
                                                            <input type="text" class="form-control" id="City" name="City">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="mb-3">
                                                            <label for="State" class="form-label">State/Province</label>
                                                            <input type="text" class="form-control" id="State" name="State">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="mb-3">
                                                            <label for="AddressLine2" class="form-label">Address Line 2</label>
                                                            <input type="text" class="form-control" id="AddressLine2" name="AddressLine2">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="Country" class="form-label">Country</label>
                                                        <?= $cb_country ?>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="mb-3">
                                                            <label for="PostalCode" class="form-label">ZIP/Postal Code</label>
                                                            <input type="text" class="form-control" id="PostalCode" name="PostalCode">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="mb-3">
                                                            <label for="AddressLine3" class="form-label">Address Line 3</label>
                                                            <input type="text" class="form-control" id="AddressLine3" name="AddressLine3">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="mb-3">
                                                            <label for="AddressLine4" class="form-label">Address Line 4</label>
                                                            <input type="text" class="form-control" id="AddressLine4" name="AddressLine4">
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>

                                                <div class="d-flex justify-content-end mt-3">
                                                    <button type="button" class="btn btn-success" id="SaveGlOptionAddress">Save Address</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- GL Option Posting Section -->
                                <div class="tab-pane fade" id="posting" role="tabpanel" aria-labelledby="posting-tab">
                                    <div class="section-content">
                                        <div class="form-section">
                                            <form id="gloptionpostingform" autocomplete="off">
                                                <input type="hidden" class="form-control" id="SystemID" name="SystemID">
                                                <input type="hidden" id="Edited" name="Edited" value="0">
                                                <div class="row">
                                                    <div class="col-sm-8">
                                                        <div class="form-check mb-3">
                                                            <input class="form-check-input" type="checkbox" id="LockBudgetSets" name="LockBudgetSets" style="transform: scale(1.3);">
                                                            <label class="form-check-label" for="LockBudgetSets">Lock Budget Sets</label>
                                                        </div>

                                                        <div class="form-check mb-3">
                                                            <input class="form-check-input" type="checkbox" id="UseAccountGroups" name="UseAccountGroups" style="transform: scale(1.3);">
                                                            <label class="form-check-label" for="UseAccountGroups">Use Account Groups</label>
                                                        </div>

                                                        <div class="form-check mb-3">
                                                            <input class="form-check-input" type="checkbox" id="AllowImportedEntries" name="AllowImportedEntries" style="transform: scale(1.3);">
                                                            <label class="form-check-label" for="AllowImportedEntries">Allow Imported Entries</label>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="DefaultSourceCode" class="form-label">Default Source Code</label>
                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <?= $cb_srceledger ?>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <?= $cb_srcetype ?>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="FunctionalCurrency" class="form-label">Functional Currency</label>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <?= $cb_functionalcurrency ?>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="DefaultClosingAccount" class="form-label">Default Closing Account</label>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <?= $cb_defaultclosingaccount ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="mb-3 fw-bold">
                                                            <h5>Posting Statistics</h5>
                                                        </div>

                                                        <div class="mb-2 d-flex justify-content-between">
                                                            <span>Last Batch</span>
                                                            <span id="LastBatch"></span>
                                                        </div>
                                                        <div class="mb-2 d-flex justify-content-between">
                                                            <span>Next Posting Sequence</span>
                                                            <span id="NextPostingSequence"></span>
                                                        </div>
                                                        <hr>
                                                        <div class="mb-2 d-flex justify-content-between align-items-center">
                                                            <span>Start Year</span>
                                                            <span id="StartYear"></span>
                                                        </div>
                                                        <div class="mb-2 d-flex justify-content-between align-items-center">
                                                            <span>Current Fiscal Year</span>
                                                            <span id="CurrentFiscalYear"></span>
                                                        </div>
                                                        <div class="mb-2 d-flex justify-content-between align-items-center">
                                                            <span>Next Year of Fiscal</span>
                                                            <span id="NextYearFiscal"></span>
                                                        </div>
                                                        <div class="mb-2 d-flex justify-content-end align-items-center">
                                                            <button type="button" class="btn btn-sm btn-outline-primary ms-2" id="btnSetYear">
                                                                <i class="fa fa-edit"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>

                                                <div class="d-flex justify-content-end">
                                                    <button type="button" class="btn btn-success" id="SaveGlOptionPosting">Save Posting</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Set Year -->
                                <div class="modal fade" id="setYearModal" tabindex="-1" aria-labelledby="setYearModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="setYearModalLabel">Set Year Settings</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="modalStartYear" class="form-label">Start Year</label>
                                                    <input type="text" class="form-control yearpicker" id="modalStartYear" placeholder="Click to select year">
                                                </div>

                                                <input type="hidden" id="modalCurrentFiscalYear">
                                                <input type="hidden" id="modalNextYearFiscal">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary" id="saveYearSettings">Save Changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- GL Option Segment Section -->
                                <div class="tab-pane fade" id="segments" role="tabpanel" aria-labelledby="segments-tab">
                                    <div class="section-content">
                                        <div class="form-section">
                                            <form id="SegmentsForm">
                                                <?= csrf_field(); ?>
                                                <div class="table-responsive mb-4">
                                                    <table class="table table-bordered table-sm" id="SegmentsTable">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th style="width: 10%;">Segment Number</th>
                                                                <th style="width: 15%;">Segment ID</th>
                                                                <th style="width: 30%;">Segment Name</th>
                                                                <th style="width: 20%;">Length</th>
                                                                <th style="width: 25%;">Use in Closing</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="SegmentsTbody">
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="row mb-4">
                                                    <div class="col-sm-3">
                                                        <label for="AccountSegment" class="form-label">Account Segment</label>
                                                        <?= $cb_segmentaccount ?>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="SegmentDelimiter" class="form-label">Segment Delimiter</label>
                                                        <?= $cb_segmentdelimiter ?>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="SegmentCode" class="form-label">Default Structure Code</label>
                                                        <?= $cb_structurecode ?>
                                                    </div>
                                                </div>

                                                <hr>

                                                <div class="d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-success" id="SaveGlOptionSegment">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- GL Option Email Section -->
                                <div class="tab-pane fade" id="email" role="tabpanel" aria-labelledby="email-tab">
                                    <div class="section-content">
                                        <div class="form-section">
                                            <form id="gloptionemailform" autocomplete="off">
                                                <?= csrf_field(); ?>
                                                <input type="hidden" class="form-control" id="SystemID" name="SystemID">
                                                <div class="row mb-4">
                                                    <div class="col-sm-6">
                                                        <label for="EmailService" class="form-label">Email Service</label>
                                                        <?= $cb_emailservice ?>
                                                    </div>
                                                </div>

                                                <div class="row mb-4">
                                                    <div class="col-sm-6">
                                                        <label for="ServerName" class="form-label">Server Name</label>
                                                        <input type="text" class="form-control" id="ServerName" name="ServerName" autocomplete="off">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="ServerPort" class="form-label">Server Port</label>
                                                        <input type="number" class="form-control" id="ServerPort" name="ServerPort" autocomplete="off">
                                                    </div>
                                                    <div class="col-sm-3 d-flex mt-4">
                                                        <div class="form-check" style="margin-top: 7px;">
                                                            <input class="form-check-input" type="checkbox" id="Ssl" name="Ssl" style="transform: scale(1.3);">
                                                            <label class="form-check-label" for="Ssl">Use SSL</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-4">
                                                    <div class="col-sm-6">
                                                        <label for="Username" class="form-label">Username</label>
                                                        <input type="text" class="form-control" id="Username" name="Username" autocomplete="off">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="Password" class="form-label">Password</label>
                                                        <input type="password" class="form-control" id="Password" name="Password" autocomplete="new-password">
                                                    </div>
                                                </div>

                                                <div class="row mb-4">
                                                    <div class="col-sm-6">
                                                        <label for="FormEmail" class="form-label">From Email Address</label>
                                                        <input type="email" class="form-control" id="FormEmail" name="FormEmail" autocomplete="off">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="SendCopies" class="form-label d-flex justify-content-between">
                                                            <span>Send Copies To</span>
                                                            <i class="bi bi-info-circle text-muted"></i>
                                                        </label>
                                                        <input type="email" class="form-control" id="SendCopies" name="SendCopies" autocomplete="off">
                                                    </div>
                                                </div>

                                                <hr>

                                                <div class="row mb-4">
                                                    <div class="col-sm-6">
                                                        <label for="SendTest" class="form-label">Send Test Email</label>
                                                        <div class="input-group">
                                                            <input type="email" class="form-control" id="SendTest" name="SendTest" autocomplete="off">
                                                            <button type="button" class="btn btn-outline-primary">Send Test Email</button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-end">
                                                    <button type="button" class="btn btn-success" id="SaveGlOptionEmail">Save Email</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.nav-link').forEach(tab => {
            tab.classList.remove('active');
            tab.setAttribute('aria-selected', 'false');
        });

        document.querySelectorAll('.tab-pane').forEach(pane => {
            pane.classList.remove('show', 'active');
        });
    });
</script>

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

<!-- Bootstrap Datepicker JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<!-- set menu name by active-menu -->
<script>
    $('#active-menu').html($('p#active-menu').html());
    $(document).prop("title", $('p#active-menu').html());
</script>

<!-- Start GL Option Address -->
<script>
    let addressLoaded = false;
    document.addEventListener('DOMContentLoaded', function() {
        $('#address-tab').on('shown.bs.tab', function(e) {
            if (!addressLoaded) {
                loadGlOptionAddress();
                addressLoaded = true;
            }
        });

        if (document.getElementById('address').classList.contains('active')) {
            loadGlOptionAddress();
            addressLoaded = true;
        }
    });

    $('#SaveGlOptionAddress').on('click', function() {
        saveGlOptionAddress();
    });

    function saveGlOptionAddress() {
        const $btn = $('#SaveGlOptionAddress');
        const originalHtml = $btn.html();

        $btn.prop('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Saving...');

        const formData = $('#gloptionaddressform').serialize();

        $.ajax({
            url: "<?= site_url('tmstgloption/saveGlOptionAddress'); ?>",
            method: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                $btn.prop('disabled', false).html(originalHtml);

                if (!checkSession(response)) return;

                if (response.status === 'error') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: response.message || 'Error saving data.'
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message || 'Address saved successfully.'
                    });
                    loadGlOptionAddress();
                }
            },
            error: function(xhr, status, error) {
                $btn.prop('disabled', false).html(originalHtml);

                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: 'Failed to connect to server. Please try again.'
                });
            }
        });
    }

    function loadGlOptionAddress() {
        $.ajax({
            url: "<?= site_url('tmstgloption/fetchGlOptionAddress'); ?>",
            method: "GET",
            dataType: "JSON",
            success: function(response) {

                if (!checkSession(response)) return;

                if (response.status === 'success' && response.data) {
                    const data = response.data;
                    $('#SystemID').val(data.SystemID);
                    $('#CompanyId').val(data.CompanyId);
                    $('#LegalName').val(data.LegalName);
                    $('#TaxNumber').val(data.TaxNumber);
                    $('#BusinessRegistration').val(data.BusinessRegistration);
                    $('#ContactName').val(data.ContactName);
                    $('#Phone').val(data.Phone);
                    $('#Fax').val(data.Fax);

                    $('#AddressLine1').val(data.AddressLine1);
                    $('#AddressLine2').val(data.AddressLine2);
                    $('#AddressLine3').val(data.AddressLine3);
                    $('#AddressLine4').val(data.AddressLine4);
                    $('#City').val(data.City);
                    $('#State').val(data.State);
                    $('#Country').val(data.Country);
                    $('#PostalCode').val(data.PostalCode);

                }
            }
        });
    }
</script>
<!-- End GL Option Address -->

<!-- Start GL Option Posting -->
<script>
    let postingLoaded = false;

    document.addEventListener('DOMContentLoaded', function() {
        const postingTab = document.getElementById('posting-tab');
        const postingPane = document.getElementById('posting');

        const loadPosting = () => {
            fetchPostingData();
            postingLoaded = true;
        };

        if (postingTab) {
            postingTab.addEventListener('shown.bs.tab', function() {
                if (!postingLoaded) loadPosting();
            });
        }

        if (postingPane?.classList.contains('active')) {
            loadPosting();
        }

        initYearPicker();
    });

    $('#SaveGlOptionPosting').on('click', function() {
        saveGlOptionPosting();
    });

    $('#btnSetYear').on('click', function() {
        showSetYearModal();
    });

    $('#saveYearSettings').on('click', function() {
        saveYearSettings();
    });

    function initYearPicker() {
        $('#modalStartYear').datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoclose: true,
            startDate: "2000",
            endDate: "2100"
        });
    }

    function showSetYearModal() {
        const startYear = $('#StartYear').text();

        $('#modalStartYear').val(startYear);

        calculateFiscalYears(startYear);

        $('#setYearModal').modal('show');
    }

    function calculateFiscalYears(startYear) {
        if (startYear && !isNaN(startYear)) {
            const start = parseInt(startYear);
            const currentFiscalYear = start;
            const nextYearFiscal = start + 1;

            $('#modalCurrentFiscalYear').val(currentFiscalYear);
            $('#modalNextYearFiscal').val(nextYearFiscal);
        }
    }

    function saveYearSettings() {
        const startYear = $('#modalStartYear').val();

        if (!startYear) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Start Year is required!'
            });
            return;
        }

        const currentFiscalYear = $('#modalCurrentFiscalYear').val();
        const nextYearFiscal = $('#modalNextYearFiscal').val();

        $('#StartYear').text(startYear);
        $('#CurrentFiscalYear').text(currentFiscalYear);
        $('#setYearModal').modal('hide');

        updateNextYearFiscalDisplay();

        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Year settings updated successfully!'
        });
    }

    function updateNextYearFiscalDisplay() {
        const currentFiscalYear = $('#CurrentFiscalYear').text();
        if (currentFiscalYear && !isNaN(currentFiscalYear)) {
            const nextYear = parseInt(currentFiscalYear) + 1;
            $('#NextYearFiscal').text(nextYear);
        } else {
            $('#NextYearFiscal').text('-');
        }
    }

    function controlSpecificFieldsBasedOnEdited(editedStatus) {
        const isEdited = editedStatus === 1 || editedStatus === '1' || editedStatus === true;

        const controlledDropdowns = [{
                selector: 'select[name="cb_srceledger"]',
                name: 'cb_srceledger'
            },
            {
                selector: 'select[name="cb_srcetype"]',
                name: 'cb_srcetype'
            },
            {
                selector: 'select[name="cb_functionalcurrency"]',
                name: 'cb_functionalcurrency'
            }
        ];

        controlledDropdowns.forEach(dropdown => {
            const $element = $(dropdown.selector);
            const shouldBeDisabled = !isEdited;

            $element.prop('disabled', shouldBeDisabled);

            if (shouldBeDisabled) {
                $element.attr('disabled', 'disabled');
            } else {
                $element.removeAttr('disabled');
            }

            if (isEdited) {
                $element.removeClass('bg-light');
            } else {
                $element.addClass('bg-light');
            }

            if (shouldBeDisabled) {
                $element.css({
                    'background-color': '#f8f9fa',
                    'cursor': 'not-allowed',
                    'opacity': '0.7'
                });
            } else {
                $element.css({
                    'background-color': '',
                    'cursor': '',
                    'opacity': ''
                });
            }

            $element.trigger('change');
        });

        if (isEdited) {
            $('#btnSetYear').show().prop('disabled', false);
        } else {
            $('#btnSetYear').hide().prop('disabled', true);
        }
    }

    function fetchPostingData() {
        $.ajax({
            url: "<?= site_url('tmstgloption/fetchGlOptionPosting'); ?>",
            method: "GET",
            dataType: "JSON",
            success: function(response) {
                if (!checkSession(response)) return;

                if (response.status === 'success' && response.data) {
                    const data = response.data;
                    const postingData = data.postingData || {};

                    $('#LastBatch').text(postingData.lastBatch || '-');
                    $('#NextPostingSequence').text(data.nextPostingSequence || '0');
                    $('#StartYear').text(postingData.startYear || '-');
                    $('#CurrentFiscalYear').text(postingData.currentYearFiscal || '-');

                    updateNextYearFiscalDisplay();

                    $('#LockBudgetSets').prop('checked',
                        postingData.lockBudgetSets === true ||
                        postingData.lockBudgetSets === 'true' ||
                        postingData.lockBudgetSets === 1 ||
                        postingData.lockBudgetSets === '1'
                    );

                    $('#UseAccountGroups').prop('checked',
                        postingData.useAccountGroups === true ||
                        postingData.useAccountGroups === 'true' ||
                        postingData.useAccountGroups === 1 ||
                        postingData.useAccountGroups === '1'
                    );

                    $('#AllowImportedEntries').prop('checked',
                        postingData.allowImportedEntries === true ||
                        postingData.allowImportedEntries === 'true' ||
                        postingData.allowImportedEntries === 1 ||
                        postingData.allowImportedEntries === '1'
                    );

                    const editedValue =
                        postingData.edited === true ||
                        postingData.edited === 'true' ||
                        postingData.edited === 1 ||
                        postingData.edited === '1' ||
                        postingData.Edited === true ||
                        postingData.Edited === 'true' ||
                        postingData.Edited === 1 ||
                        postingData.Edited === '1' ? '1' : '0';

                    $('#Edited').val(editedValue);

                    $('select[name="cb_srceledger"]').val(postingData.defaultSrceLedger || '');
                    $('select[name="cb_srcetype"]').val(postingData.defaultSrceType || '');
                    $('select[name="cb_functionalcurrency"]').val(postingData.functionalCurrency || '');
                    $('select[name="cb_defaultclosingaccount"]').val(postingData.defaultClosingAccount || '');

                    $('#SystemID').val(postingData.systemID || postingData.SystemID || 'Medicelle');

                    setTimeout(() => {
                        controlSpecificFieldsBasedOnEdited(editedValue);
                    }, 100);

                    if (Object.keys(postingData).length === 0) {
                        console.warn('No posting data found');
                        Swal.fire({
                            icon: 'info',
                            title: 'Info',
                            text: 'No posting configuration found. Please save new configuration.',
                            timer: 3000
                        });
                    }
                } else {
                    console.error('Response not successful:', response);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Failed to load posting data'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('fetchPostingData error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: 'Failed to connect to server. Please try again.'
                });
            }
        });
    }

    function fetchPostingDataWithoutFormToggle() {
        $.ajax({
            url: "<?= site_url('tmstgloption/fetchGlOptionPosting'); ?>",
            method: "GET",
            dataType: "JSON",
            success: function(response) {
                if (!checkSession(response)) return;

                if (response.status === 'success' && response.data) {
                    const data = response.data;
                    const postingData = data.postingData || {};

                    $('#LastBatch').text(postingData.lastBatch || '-');
                    $('#NextPostingSequence').text(data.nextPostingSequence || '0');
                    $('#StartYear').text(postingData.startYear || '-');
                    $('#CurrentFiscalYear').text(postingData.currentYearFiscal || '-');

                    updateNextYearFiscalDisplay();

                    $('#LockBudgetSets').prop('checked', postingData.lockBudgetSets === true || postingData.lockBudgetSets === 'true');
                    $('#UseAccountGroups').prop('checked', postingData.useAccountGroups === true || postingData.useAccountGroups === 'true');
                    $('#AllowImportedEntries').prop('checked', postingData.allowImportedEntries === true || postingData.allowImportedEntries === 'true');

                    $('select[name="cb_srceledger"]').val(postingData.defaultSrceLedger || '');
                    $('select[name="cb_srcetype"]').val(postingData.defaultSrceType || '');
                    $('select[name="cb_functionalcurrency"]').val(postingData.functionalCurrency || '');
                    $('select[name="cb_defaultclosingaccount"]').val(postingData.defaultClosingAccount || '');
                    $('#SystemID').val(postingData.systemID || 'Medicelle');

                    $('#Edited').val('0');

                    setTimeout(() => {
                        controlSpecificFieldsBasedOnEdited('0');
                    }, 100);
                }
            },
            error: function(error) {
                console.error('Failed to load posting data:', error);
            }
        });
    }

    function saveGlOptionPosting() {

        const $btn = $('#SaveGlOptionPosting');
        const originalHtml = $btn.html();

        $btn.prop('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Saving...');

        const srceledgerDisabled = $('select[name="cb_srceledger"]').prop('disabled');
        const srcetypeDisabled = $('select[name="cb_srcetype"]').prop('disabled');
        const functionalCurrencyDisabled = $('select[name="cb_functionalcurrency"]').prop('disabled');

        $('select[name="cb_srceledger"]').prop('disabled', false);
        $('select[name="cb_srcetype"]').prop('disabled', false);
        $('select[name="cb_functionalcurrency"]').prop('disabled', false);

        const formData = $('#gloptionpostingform').serialize();
        const fullData = formData +
            '&StartYear=' + $('#StartYear').text() +
            '&CurrentYearFiscal=' + $('#CurrentFiscalYear').text();

        $('select[name="cb_srceledger"]').prop('disabled', srceledgerDisabled);
        $('select[name="cb_srcetype"]').prop('disabled', srcetypeDisabled);
        $('select[name="cb_functionalcurrency"]').prop('disabled', functionalCurrencyDisabled);

        $.ajax({
            url: "<?= site_url('tmstgloption/saveGlOptionPosting'); ?>",
            method: "POST",
            data: fullData,
            dataType: "json",
            success: function(response) {
                $btn.prop('disabled', false).html(originalHtml);
                if (!checkSession(response)) return;

                if (response.status === 'success' || response.success === true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message || 'Posting configuration saved successfully.'
                    });

                    setTimeout(() => {
                        fetchPostingData();
                    }, 500);

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: response.message || 'Error saving data.'
                    });
                }
            },
            error: function(xhr) {
                console.error('saveGlOptionPosting error:', xhr);

                $btn.prop('disabled', false).html(originalHtml);

                try {
                    const parsedResponse = JSON.parse(xhr.responseText);
                    if (parsedResponse.status === 'success' || parsedResponse.success === true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: parsedResponse.message || 'Data saved successfully!'
                        });
                        setTimeout(() => {
                            fetchPostingData();
                        }, 500);
                        return;
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: 'Failed to connect to server. Please try again.'
                });
            }
        });
    }

    $(document).on('changeDate', '#modalStartYear', function(e) {
        const selectedYear = e.format();
        calculateFiscalYears(selectedYear);
    });

    $(document).on('DOMSubtreeModified', '#CurrentFiscalYear', function() {
        updateNextYearFiscalDisplay();
    });
</script>
<!-- End GL Option Posting -->

<!-- Start GL Option Segment -->
<script>
    let segmentsData = [];

    $(document).ready(function() {
        $('#segments-tab').on('click', function() {
            LoadSegmentsData();
        });

        $('#SegmentsForm').on('submit', function(e) {
            e.preventDefault();
            SaveSegments();
        });

        $('#cb_segmentaccount').prop('disabled', true);
        $('#cb_segmentdelimiter').prop('disabled', true);
        $('#cb_structurecode').prop('disabled', true);
    });

    function LoadSegmentsData() {
        $.ajax({
            url: "<?= site_url('tmstgloption/fetchGlOptionSegment'); ?>",
            method: "GET",
            dataType: "JSON",
            success: function(response) {
                if (typeof CheckSession === 'function' && !CheckSession(response)) return;

                if (response.status === 'success') {
                    segmentsData = response.data;
                    RenderSegmentsTable(response.data);
                } else {
                    segmentsData = [];
                    RenderSegmentsTable([]);
                }
            },
            error: function() {
                segmentsData = [];
                RenderSegmentsTable([]);
            }
        });
    }

    function RenderSegmentsTable(segments) {
        const tbody = $('#SegmentsTbody');
        tbody.empty();

        segments.forEach(s => {
            const isClosing = Boolean(s.SegmentClosing);
            const isSegmentOne = parseInt(s.SegmentNumber) === 1;

            const hasSavedSegmentId = s.SegmentID && s.SegmentID.trim() !== '';

            const readonlyAttr = (isSegmentOne || hasSavedSegmentId) ? 'readonly' : '';
            const bgClass = (isSegmentOne || hasSavedSegmentId) ? 'bg-light' : '';

            tbody.append(`
            <tr>
                <td class="text-center align-middle">${s.SegmentNumber}</td>
                <td>
                    <input type="text" 
                           class="form-control form-control-sm ${bgClass}" 
                           name="SegmentID${s.SegmentNumber}" 
                           value="${s.SegmentID}" 
                           placeholder="Enter Segment ID"
                           maxlength="10"
                           ${readonlyAttr}>
                </td>
                <td>
                    <input type="text" 
                           class="form-control form-control-sm" 
                           name="SegmentName${s.SegmentNumber}" 
                           value="${s.SegmentName}" 
                           placeholder="Enter segment name">
                </td>
                <td>
                    <input type="number" 
                           class="form-control form-control-sm" 
                           name="SegmentLength${s.SegmentNumber}" 
                           value="${s.SegmentLength || 0}" 
                           min="0" 
                           max="10">
                </td>
                <td>
                    <select class="form-control form-control-sm" name="UseInClosing${s.SegmentNumber}">
                        <option value="no" ${!isClosing ? 'selected' : ''}>No</option>
                        <option value="yes" ${isClosing ? 'selected' : ''}>Yes</option>
                    </select>
                </td>
            </tr>
        `);
        });
    }

    $(document).on('input', 'input[name^="SegmentLength"]', function() {
        let val = $(this).val();

        val = val.replace(/\D/g, '');

        if (val === '') {
            $(this).val('');
            return;
        }

        val = parseInt(val, 10);

        $(this).val(val);
    });

    function SaveSegments() {
        const rows = $('#SegmentsTbody tr');
        const CurrentSegments = [];
        const segmentIds = new Set();
        let isValid = true;

        rows.each(function() {
            const segmentNumber = $(this).find('td:eq(0)').text().trim();
            const $segmentID = $(this).find(`[name="SegmentID${segmentNumber}"]`);
            const $segmentName = $(this).find(`[name="SegmentName${segmentNumber}"]`);
            const $segmentLength = $(this).find(`[name="SegmentLength${segmentNumber}"]`);
            const $useInClosing = $(this).find(`[name="UseInClosing${segmentNumber}"]`);

            const isSegmentOne = parseInt(segmentNumber) === 1;

            const segmentID = $segmentID.val().trim();
            const segmentName = $segmentName.val().trim();
            let segmentLength = $segmentLength.val().trim();
            const useInClosing = $useInClosing.val() || 'no';

            $(this).find('input').removeClass('is-invalid');

            if (!segmentLength || isNaN(segmentLength)) {
                segmentLength = 0;
                $segmentLength.val(0);
            }

            const len = parseInt(segmentLength, 10) || 0;
            const idEmpty = !segmentID;
            const nameEmpty = !segmentName;
            const lengthEmpty = len === 0;
            const allFilled = !idEmpty && !nameEmpty && !lengthEmpty;
            const allEmpty = idEmpty && nameEmpty && lengthEmpty;

            if (isSegmentOne) {
                CurrentSegments.push({
                    SegmentNumber: parseInt(segmentNumber),
                    SegmentID: segmentID,
                    SegmentName: segmentName,
                    SegmentLength: len,
                    SegmentClosing: useInClosing === 'yes'
                });
                return;
            }

            if (allEmpty) {
                CurrentSegments.push({
                    SegmentNumber: parseInt(segmentNumber),
                    SegmentID: '',
                    SegmentName: '',
                    SegmentLength: 0,
                    SegmentClosing: useInClosing === 'yes'
                });
                return;
            }

            let rowValid = true;

            if (segmentID && segmentIds.has(segmentID)) {
                $segmentID.addClass('is-invalid');
                rowValid = false;
                isValid = false;
            } else if (segmentID) {
                segmentIds.add(segmentID);
            }

            if (!allEmpty && !allFilled) {
                if (idEmpty) $segmentID.addClass('is-invalid');
                if (nameEmpty) $segmentName.addClass('is-invalid');
                if (lengthEmpty) $segmentLength.addClass('is-invalid');
                rowValid = false;
                isValid = false;
            }

            if (segmentID && segmentName && len === 0) {
                $segmentLength.addClass('is-invalid');
                rowValid = false;
                isValid = false;
            }

            CurrentSegments.push({
                SegmentNumber: parseInt(segmentNumber),
                SegmentID: segmentID,
                SegmentName: segmentName,
                SegmentLength: len,
                SegmentClosing: useInClosing === 'yes'
            });
        });

        if (!isValid) {
            Swal.fire({
                icon: 'warning',
                title: 'Validasi Gagal',
                text: 'Setiap Segment Number yang diisi harus memiliki Segment ID, Nama Segment, dan Panjang Segment (lebih dari 0).'
            });
            return;
        }

        if (CurrentSegments.length === 0) {
            Swal.fire({
                icon: 'info',
                title: 'No Data',
                text: 'No segment data entered to save.'
            });
            return;
        }

        const $btn = $('#SaveGlOptionSegment');
        const originalText = $btn.html();
        $btn.prop('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Saving...');

        $.ajax({
            url: "<?= site_url('tmstgloption/saveGlOptionSegment'); ?>",
            method: "POST",
            contentType: "application/json",
            data: JSON.stringify(CurrentSegments),
            dataType: "JSON",
            success: function(response) {
                $btn.prop('disabled', false).html(originalText);
                if (typeof CheckSession === 'function' && !CheckSession(response)) return;

                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message || 'Segments saved successfully',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        LoadSegmentsData();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Failed to save segments',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(xhr, status, error) {
                $btn.prop('disabled', false).html(originalText);
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: 'Failed to connect to server: ' + error,
                    confirmButtonText: 'OK'
                });
            }
        });
    }

    $(document).on('input', 'input[name^="SegmentID"], input[name^="SegmentName"], input[name^="SegmentLength"]', function() {
        $(this).removeClass('is-invalid');
    });
</script>
<!-- End GL Option Segment -->

<!-- Start GL Option Email -->
<script>
    let emailLoaded = false;
    document.addEventListener('DOMContentLoaded', function() {
        $('#email-tab').on('shown.bs.tab', function(e) {
            if (!emailLoaded) {
                loadGlOptionEmail();
                emailLoaded = true;
            }
        });

        if (document.getElementById('email').classList.contains('active')) {
            loadGlOptionEmail();
            emailLoaded = true;
        }
    });

    $('#SaveGlOptionEmail').on('click', function() {
        saveGlOptionEmail();
    });

    function saveGlOptionEmail() {
        const $btn = $('#SaveGlOptionEmail');
        const originalHtml = $btn.html();

        $btn.prop('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Saving...');

        const formData = $('#gloptionemailform').serialize();

        $.ajax({
            url: "<?= site_url('tmstgloption/saveGlOptionEmail'); ?>",
            method: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                $btn.prop('disabled', false).html(originalHtml);

                if (!checkSession(response)) return;

                if (response.status === 'error') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: response.message || 'Error saving data.'
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message || 'Email configuration saved successfully.'
                    });
                    loadGlOptionEmail();
                }
            },
            error: function(xhr, status, error) {
                $btn.prop('disabled', false).html(originalHtml);

                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: 'Failed to connect to server. Please try again.'
                });
            }
        });
    }

    function loadGlOptionEmail() {
        $.ajax({
            url: "<?= site_url('tmstgloption/fetchGlOptionEmail'); ?>",
            method: "GET",
            dataType: "JSON",
            success: function(response) {

                if (!checkSession(response)) return;

                if (response.status === 'success' && response.data) {
                    const data = response.data;
                    $('#SystemID').val(data.SystemID);
                    $('#EmailService').val(data.EmailService);
                    $('#ServerName').val(data.ServerName);
                    $('#ServerPort').val(data.ServerPort);

                    const ssl = data.Ssl === true || data.Ssl === 'true';
                    $('#Ssl').prop('checked', ssl);

                    $('#Username').val(data.Username);
                    $('#Password').val(data.Password);
                    $('#FormEmail').val(data.FormEmail);
                    $('#SendCopies').val(data.SendCopies);
                    $('#SendTest').val(data.SendTest);
                }
            }
        });
    }
</script>
<!-- End GL Option Email -->

<!-- Start Script For Check Session User -->
<script>
    function checkSession(response) {
        if (response.status === 'session_expired') {
            window.location.href = "<?= base_url('auth/login') ?>";
            return false;
        }
        return true;
    }
</script>
<!-- End Script For Check Session User -->

<?= $this->endSection('script'); ?>