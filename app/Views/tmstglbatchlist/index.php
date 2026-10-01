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
    .modal-validation .modal-body {
        max-height: 60vh;
        overflow-y: auto;
    }

    .modal-validation .modal-body::-webkit-scrollbar {
        width: 8px;
    }

    .modal-validation .modal-body::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .modal-validation .modal-body::-webkit-scrollbar-thumb {
        background: #888;
    }

    .modal-validation .modal-body::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .modal-validation .table-responsive {
        max-height: none;
        overflow-x: auto;
    }

    .modal-validation #validationTable thead th {
        position: sticky;
        top: 0;
        background-color: #6c757d;
        color: white;
        z-index: 10;
        border-bottom: 2px solid #dee2e6;
    }

    .modal-validation #validationTable tbody tr td[style*="display: none"] {
        display: none !important;
    }

    .modal-validation #validationTable tbody tr td:first-child {
        text-align: center !important;
        vertical-align: middle !important;
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

                            <table id="glbatchentryTable" class="table table-sm table-bordered table-striped">
                                <thead class="table">
                                    <tr>
                                        <!-- <th>No</th> -->
                                        <th>Batch Number</th>
                                        <th>Batch Description</th>
                                        <th>Source Ledger</th>
                                        <th>Type</th>
                                        <th>Printed</th>
                                        <th>Created User</th>
                                        <th>Created</th>
                                        <th>Total Debit</th>
                                        <th>Total Credit</th>
                                        <th>Entry Count</th>
                                        <th>Posting Sequence</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="modalform" tabindex="" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLabel"></h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="post" id="data_form" autocomplete="off">
                                        <?= csrf_field(); ?>
                                        <div class="modal-body">
                                            <div class="row g-3">
                                                <div class="col-md-4 mt-2 batchid-field" style="display:none">
                                                    <label for="BatchId" class="form-label">Batch Number</label>
                                                    <input type="text" class="form-control form-control-sm" id="BatchId" name="BatchId">
                                                    <span class="error invalid-feedback errorBatchDesc"></span>
                                                </div>

                                                <div class="col-md-4 mt-2">
                                                    <label for="BatchDesc" class="form-label">Batch Description</label>
                                                    <input type="text" class="form-control form-control-sm" id="BatchDesc" name="BatchDesc">
                                                    <span class="error invalid-feedback errorBatchDesc"></span>
                                                </div>

                                                <div class="col-md-4 mt-2">
                                                    <label for="SrceLedgr" class="form-label">Source Ledger</label>
                                                    <?= $cb_sourceledger ?>
                                                    <input type="hidden" id="SrceLedger" name="cb_sourceledger">
                                                    <span class="error invalid-feedback errorSrceLedgr"></span>
                                                </div>

                                                <div class="col-md-4 mt-2" id="batchtype_form_container">
                                                    <label for="BatchType" class="form-label">Type</label>
                                                    <?= $cb_batchtype ?>
                                                    <input type="hidden" id="BatchType" name="cb_batchtype" value="1">
                                                    <span class="error invalid-feedback errorType"></span>
                                                </div>

                                                <div class="col-md-4 mt-2" id="batchtype_view_container" style="display: none;">
                                                    <label for="BatchTypeView" class="form-label">Type</label>
                                                    <input type="text" class="form-control form-control-sm" id="BatchTypeView" readonly>
                                                </div>

                                                <div class="col-md-4 mt-2" id="batchstatus_form_container">
                                                    <label for="BatchStatus" class="form-label">Status</label>
                                                    <?= $cb_batchstatus ?>
                                                    <input type="hidden" id="BatchStatus" name="cb_batchstatusins" value="1">
                                                    <span class="error invalid-feedback errorStatus"></span>
                                                </div>

                                                <div class="col-md-4 mt-2" id="batchstatus_view_container" style="display: none;">
                                                    <label for="BatchStatusView" class="form-label">Status</label>
                                                    <input type="text" class="form-control form-control-sm" id="BatchStatusView" readonly>
                                                </div>

                                                <div class="col-md-4 mt-2 audit-field" style="display:none">
                                                    <label for="AudtUser" class="form-label">Audit User</label>
                                                    <input type="text" class="form-control form-control-sm" id="AudtUser" name="AudtUser">
                                                </div>

                                                <div class="col-md-4 mt-2 audit-field" style="display:none">
                                                    <label for="AudtDate" class="form-label">Audit Date</label>
                                                    <input type="text" class="form-control form-control-sm" id="AudtDate" name="AudtDate">
                                                </div>

                                                <div class="col-md-4 mt-2 audit-field" style="display:none">
                                                    <label for="AudtTime" class="form-label">Audit Time</label>
                                                    <input type="text" class="form-control form-control-sm" id="AudtTime" name="AudtTime">
                                                </div>

                                                <div class="col-md-4 mt-2 audit-field" style="display:none">
                                                    <label for="PostSeq" class="form-label">Posting Sequence</label>
                                                    <input type="text" class="form-control form-control-sm" id="PostSeq" name="PostSeq">
                                                </div>

                                                <div class="col-md-4 mt-2 audit-field" style="display:none">
                                                    <label for="SwPrinted" class="form-label">Printed</label>
                                                    <input type="text" class="form-control form-control-sm" id="SwPrinted" name="SwPrinted">
                                                </div>

                                                <div class="col-md-4 mt-2" style="display:none">
                                                    <label for="SrceType" class="form-label">Source Type</label>
                                                    <input type="text" class="form-control form-control-sm" id="SrceType" name="SrceType">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" id="hidden_id" name="hidden_id" />
                                            <input type="hidden" id="action" name="action" value="Add" />
                                            <button type="submit" name="submit" id="submit_button" class="btn btn-sm btn-primary" value="Simpan"></button>
                                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Validation Results -->
                        <div class="modal fade modal-validation" id="modalValidation" tabindex="-1" role="dialog" aria-labelledby="modalValidationLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title" id="modalValidationLabel">
                                            <i class="fas fa-exclamation-triangle mr-2"></i> Hasil Validasi
                                        </h5>
                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="alert alert-warning" id="validationHeader">
                                        </div>

                                        <div class="table-responsive">
                                            <table id="validationTable" class="table table-bordered" style="width:100%">
                                                <thead class="bg-secondary text-white">
                                                    <tr>
                                                        <th class="text-center">Batch Entry</th>
                                                        <th>Validation Message</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="validationTableBody">
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

                        <!-- Modal Posting Journal -->
                        <div class="modal fade" id="modalposting" tabindex="-1" aria-labelledby="postingModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content shadow-lg">
                                    <div class="modal-header bg-success text-white">
                                        <h4 class="modal-title" id="exampleModalLabel"></h4>
                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <form id="posting_form" method="post" autocomplete="off">
                                        <?= csrf_field(); ?>

                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Batch ID</label>
                                                        <input type="text" class="form-control form-control-sm" id="PostBatchId" name="PostBatchId">
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Source Ledger</label>
                                                        <input type="text" class="form-control form-control-sm" id="PostSrceLedger">
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Created</label>
                                                        <input type="text" class="form-control form-control-sm" id="PostAudtUser">
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Debit Total</label>
                                                        <input type="text" class="form-control form-control-sm text-right" id="PostDebitTot">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Batch Description</label>
                                                        <input type="text" class="form-control form-control-sm" id="PostBatchDesc">
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Batch Type</label>
                                                        <input type="text" class="form-control form-control-sm" id="PostBatchType">
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Batch Entry</label>
                                                        <input type="text" class="form-control form-control-sm" id="PostEntryCnt">
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Credit Total</label>
                                                        <input type="text" class="form-control form-control-sm text-right" id="PostCreditTot">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <input type="hidden" name="action" value="Posting">

                                            <button type="submit" id="btn_posting" class="btn btn-success btn-sm">
                                                <i class="fa fa-upload mr-1"></i> Posting Journal
                                            </button>

                                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                                                <i class="fa fa-times mr-1"></i> Tutup
                                            </button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>

                        <!-- Modal Import -->
                        <div class="modal fade" id="modalimport" tabindex="" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLabel"></h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="<?= site_url("tmstglbatchlist/preview") ?>" id="uploadForm" method="post" enctype="multipart/form-data">
                                            <?= csrf_field(); ?>
                                            <label for="filename">Import Excel File : <a href="<?= site_url("tmstglbatchlist/download") ?>"><u>Download Format</u></a></label> <br>
                                            <input type="file" name="filename" id="filename">
                                            <button type="submit" name="preview" class="btn btn-sm btn-primary" id="preview">Preview</button>
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
    function selectBatchForJournal(batchId, batchDesc, srceledger, audtuser) {
        const batchData = {
            batchId: batchId,
            batchDesc: batchDesc,
            srceledger: srceledger,
            audtuser: audtuser,
            selectedFrom: 'GL_BATCH_LIST',
            timestamp: new Date().getTime()
        };

        localStorage.setItem('preselectedBatch', JSON.stringify(batchData));
    }
</script>

<script>
    function tmstdiagnosapreview() {
        $.ajax({
            method: "get",
            url: "<?= site_url('tmstglbatchlist/preview'); ?>",
            success: function(data) {
                $('#viewpreview').html(data);
            }
        });
    }

    $(document).ready(function() {

        function checkSession(response) {
            if (response.status === 'session_expired') {
                window.location.href = "<?= base_url('auth/login') ?>";
                return false;
            }
            return true;
        }

        $(document).on('click', '#add_record', function() {

            $('#data_form')[0].reset();
            $('.is-invalid').removeClass('is-invalid');
            $('[class^="error"]').html('');

            $('#BatchDesc').prop('disabled', false);
            $('#cb_sourceledger').prop('disabled', true);

            $('#batchtype_form_container').show();
            $('#batchtype_view_container').hide();
            $('#batchstatus_form_container').show();
            $('#batchstatus_view_container').hide();

            $('#cb_batchstatus').prop('disabled', true).val(1).trigger('change.select2');
            $('#cb_batchtype').prop('disabled', true);

            $('.audit-field').hide();
            $('.batchid-field').hide();

            $('.modal-title').text('Tambah Data');
            $('#action').val('Add');
            $('#submit_button').val('Simpan').html('Simpan').show();
            $('#modalform').modal('show');
        });

        $('#data_form').on('submit', function(event) {
            event.preventDefault();

            $('.is-invalid').removeClass('is-invalid');
            $('[class^="error"]').html('');

            $.ajax({
                url: "<?= site_url('tmstglbatchlist/action'); ?>",
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
                        return;
                    }

                    if (response.status === 'validation_error' && response.validations && response.validations.length > 0) {
                        showValidationModal(response);
                        return;
                    }

                    if (response.status === 'error') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message || 'Terjadi kesalahan saat menyimpan data.'
                        });
                        return;
                    }

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message || 'Data berhasil disimpan.',
                        timer: 1500,
                        showConfirmButton: false
                    });

                    clearFormValidation();
                    $('#data_form')[0].reset();
                    $('#modalform').modal('hide');
                    $('#glbatchentryTable').DataTable().ajax.reload(null, false);
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'Gagal menghubungi server. Silakan coba lagi nanti.'
                    });
                }
            });
        });

        function showValidationModal(response) {
            let batchId = response.validations?.[0]?.BatchId || response.validations?.[0]?.batchId || '-';

            $('#validationHeader').html(`
        <i class="fas fa-info-circle mr-2"></i>
        Batch Id : <strong>${batchId}</strong> tidak dapat diubah menjadi Ready To Post karena ditemukan validasi berikut:
    `);

            $('#validationTableBody').empty();

            if (response.validations && response.validations.length > 0) {
                let grouped = {};

                response.validations.forEach(item => {
                    let batchEntry = item.BatchEntry || item.batchEntry || '-';
                    let message = item.ValidationMessage || item.validationMessage || '-';

                    if (!grouped[batchEntry]) {
                        grouped[batchEntry] = [];
                    }
                    grouped[batchEntry].push(message);
                });

                for (let batchEntry in grouped) {
                    let messages = grouped[batchEntry];

                    $('#validationTableBody').append(`
                <tr>
                    <td class="text-center align-middle" rowspan="${messages.length}">${batchEntry}</td>
                    <td>${messages[0]}</td>
                </tr>
            `);

                    for (let i = 1; i < messages.length; i++) {
                        $('#validationTableBody').append(`
                    <tr>
                        <td style="display: none;"></td>
                        <td>${messages[i]}</td>
                    </tr>
                `);
                    }
                }

                $('#modalValidation .modal-title').html(`
            <i class="fas fa-exclamation-triangle mr-2"></i> 
            Hasil Validasi
        `);
            }

            if ($('#modalform').hasClass('show')) {
                $('#modalform').modal('hide');
                $('#modalform').one('hidden.bs.modal', function() {
                    $('#modalValidation').modal('show');
                });
            } else {
                $('#modalValidation').modal('show');
            }
        }

        $('#posting_form').on('submit', function(event) {
            event.preventDefault();

            $.ajax({
                url: "<?= site_url('tmstglbatchlist/action'); ?>",
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                beforeSend: function() {
                    $('#btn_posting').prop('disabled', true).html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('#btn_posting').prop('disabled', false).html('<i class="fa fa-upload mr-1"></i> Posting Journal');
                },
                success: function(response) {
                    if (!checkSession(response)) return;

                    if (response.error) {
                        showValidationErrors(response.error);
                    } else if (response.status === 'validation_error' && response.validations && response.validations.length > 0) {
                        $('#modalposting').modal('hide');

                        $('#validationHeader').html(`
                    <i class="fas fa-info-circle mr-2"></i>
                    Batch Id : <strong>${response.batchId || '-'}</strong> tidak dapat diposting karena ditemukan validasi berikut:
                `);

                        $('#validationTableBody').empty();

                        if (response.validations && response.validations.length > 0) {
                            let grouped = {};

                            response.validations.forEach(item => {
                                let batchEntry = item.BatchEntry || item.batchEntry || '-';
                                let message = item.ValidationMessage || item.validationMessage || '-';

                                if (!grouped[batchEntry]) {
                                    grouped[batchEntry] = [];
                                }
                                grouped[batchEntry].push(message);
                            });

                            for (let batchEntry in grouped) {
                                let messages = grouped[batchEntry];

                                $('#validationTableBody').append(`
                            <tr>
                                <td class="text-center align-middle" rowspan="${messages.length}">${batchEntry}</td>
                                <td>${messages[0]}</td>
                            </tr>
                        `);

                                for (let i = 1; i < messages.length; i++) {
                                    $('#validationTableBody').append(`
                                <tr>
                                    <td style="display: none;"></td>
                                    <td>${messages[i]}</td>
                                </tr>
                            `);
                                }
                            }
                        }

                        $('#modalValidation').modal('show');
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
                        $('#posting_form')[0].reset();
                        $('#modalposting').modal('hide');
                        $('#glbatchentryTable').DataTable().ajax.reload(null, false);
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'Gagal menghubungi server. Silakan coba lagi nanti.'
                    });
                }
            });
        });

        function showValidationErrors(errors) {
            $.each(errors, function(field, message) {
                var inputElement = $('#' + field);

                if (inputElement.length > 0) {
                    inputElement.addClass('is-invalid');
                }

                var errorElement = $('.error' + field);
                if (errorElement.length > 0) {
                    errorElement.html(message);
                } else {
                    $('[class*="error' + field + '"]').html(message);
                }
            });
        }

        function clearFormValidation() {
            $('.is-invalid').removeClass('is-invalid');
            $('[class^="error"]').html('');
        }

        // 🔧 Capitalize helper
        function capitalize(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

        /*--------------------------------------------------*/

        $(document).on('click', '.view', function() {
            const BatchId = $(this).data('batchid');

            $.ajax({
                url: "<?= site_url('tmstglbatchlist/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    BatchId
                },
                dataType: "JSON",
                success: function(response) {
                    $('#data_form')[0].reset();
                    $('.is-invalid').removeClass('is-invalid');
                    $('[class^="error"]').html('');

                    const data = response.data;

                    $('#BatchId').val(data.BatchId).prop('disabled', true);
                    $('#BatchDesc').val(data.BatchDesc).prop('disabled', true);
                    $('#SrceLedger').val(data.SrceLedger).prop('disabled', true);

                    $('#batchtype_form_container').hide();
                    $('#batchtype_view_container').show();
                    $('#batchstatus_form_container').hide();
                    $('#batchstatus_view_container').show();

                    $('#BatchTypeView').val(data.BatchTypeDesc);
                    $('#BatchStatusView').val(data.BatchStatDesc);

                    $('#AudtTime').val(data.AudtTime).prop('disabled', true);

                    const rawDate = data.AudtDate;
                    const formattedDate = rawDate ? new Date(rawDate).toLocaleDateString('id-ID') : '';

                    $('#AudtDate').val(formattedDate).prop('disabled', true);
                    $('#AudtUser').val(data.AudtUser).prop('disabled', true);
                    $('#SwPrinted').val(data.SwPrinted).prop('disabled', true);
                    $('#PostSeq')
                        .val((data.PostSeq === null || data.PostSeq === undefined || data.PostSeq === '' || data.PostSeq === 0) ?
                            'Belum Posting' :
                            data.PostSeq)
                        .prop('disabled', true);

                    $('.audit-field').show();
                    $('.batchid-field').show();

                    $('.modal-title').text('Lihat Data');
                    $('#action').val('View');
                    $('#submit_button').val('Lihat').hide();
                    $('#modalform').modal('show');
                    $('#hidden_id').val(BatchId);
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal melihat data',
                        text: 'Terjadi kesalahan saat mengambil data Batch Number.'
                    });
                }
            });
        });

        $(document).on('click', '.edit', function() {
            const BatchId = $(this).data('batchid');

            $.ajax({
                url: "<?= site_url('tmstglbatchlist/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    BatchId
                },
                dataType: "JSON",
                success: function(response) {
                    $('#data_form')[0].reset();
                    $('.is-invalid').removeClass('is-invalid');
                    $('[class^="error"]').html('');

                    const data = response.data;

                    $('#BatchId').val(data.BatchId).prop('disabled', false).prop('readonly', true);
                    $('#BatchDesc').val(data.BatchDesc).prop('disabled', false);
                    $('#cb_sourceledger').val(data.SrceLedger).prop('disabled', true);

                    $('#batchtype_form_container').show();
                    $('#batchtype_view_container').hide();
                    $('#batchstatus_form_container').show();
                    $('#batchstatus_view_container').hide();

                    $('#cb_batchtype').val(data.BatchType).prop('disabled', true).trigger('change.select2');
                    $('#cb_batchstatus').val(data.BatchStatus).prop('disabled', false).trigger('change.select2');

                    $('#AudtTime').val(data.AudtTime).prop('disabled', true);
                    $('#AudtDate').val(data.AudtDate).prop('disabled', true);
                    $('#AudtUser').val(data.AudtUser).prop('disabled', true);
                    $('#SwPrinted').val(data.SwPrinted).prop('disabled', true);
                    $('#PostSeq')
                        .val((data.PostSeq === null || data.PostSeq === undefined || data.PostSeq === '' || data.PostSeq === 0) ?
                            'Belum Posting' :
                            data.PostSeq)
                        .prop('disabled', true);

                    $('.audit-field').hide();
                    $('.batchid-field').show();

                    $('.modal-title').text('Ubah Data');
                    $('#action').val('Edit');
                    $('#submit_button').val('Simpan').html('Simpan').show();
                    $('#modalform').modal('show');
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal mengambil data',
                        text: 'Terjadi kesalahan saat mengambil data Batch Number.'
                    });
                }
            });
        });

        $(document).on('click', '.posting', function() {

            $('#data_form')[0].reset();
            $('.is-invalid').removeClass('is-invalid');
            $('[class^="error"]').html('');

            const BatchId = $(this).data('batchid');

            $.ajax({
                url: "<?= site_url('tmstglbatchlist/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    BatchId: BatchId
                },
                dataType: "JSON",

                success: function(response) {

                    if (!response || !response.data) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Data tidak ditemukan',
                            text: 'Response tidak berisi data batch.'
                        });
                        return;
                    }

                    const data = response.data;

                    $('#PostBatchId').val(data.BatchId).prop('disabled', false).prop('readonly', true);
                    $('#PostBatchDesc').val(data.BatchDesc).prop('disabled', false).prop('readonly', true);
                    $('#PostDateCreat').val(data.DateCreat).prop('disabled', false).prop('readonly', true);
                    $('#PostAudtUser').val(data.AudtUser).prop('disabled', false).prop('readonly', true);
                    $('#PostSrceLedger').val(data.SrceLedger).prop('disabled', false).prop('readonly', true);
                    $('#PostBatchType').val(data.BatchTypeDesc).prop('disabled', false).prop('readonly', true);

                    $('#PostDebitTot').val(formatNumber(data.DebitTot)).prop('disabled', false).prop('readonly', true);
                    $('#PostCreditTot').val(formatNumber(data.CreditTot)).prop('disabled', false).prop('readonly', true);
                    $('#PostEntryCnt').val(formatNumber(data.EntryCnt)).prop('disabled', false).prop('readonly', true);

                    $('.modal-title').html(
                        '<i class="fa fa-check-circle mr-1"></i> Posting Journal Batch'
                    );

                    $('#action').val('Posting');

                    $('#modalposting').modal('show');
                },

                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal mengambil data',
                        text: 'Terjadi kesalahan: ' + error
                    });
                }
            });
        });


        $(document).on('click', '.delete', function() {
            const BatchId = $(this).data('batchid');

            if (!BatchId) {
                Swal.fire('Error', 'Batch ID tidak ditemukan', 'error');
                return;
            }

            Swal.fire({
                title: 'Konfirmasi Delete',
                text: `Yakin ingin menghapus Batch ${BatchId}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Delete!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Sedang menghapus data',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: "<?= site_url('tmstglbatchlist/action'); ?>",
                        method: "POST",
                        data: {
                            BatchId: BatchId,
                            action: 'SoftDelete'
                        },
                        dataType: "JSON",
                        success: function(response) {
                            if (response.status === 'success' || response.success === true) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message || 'Data berhasil dihapus',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                $('#glbatchentryTable').DataTable().ajax.reload(null, false);
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.message || 'Terjadi kesalahan'
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Gagal menghubungi server'
                            });
                        }
                    });
                }
            });
        });

        // Fungsi Format Angka
        function formatNumber(num) {
            if (num === null || num === undefined) return "0";
            return new Intl.NumberFormat('id-ID').format(num);
        }
    });
</script>

<script>
    $(document).ready(function() {

        $(document).on('click', '#import', function() {

            //set modal & form
            $('.modal-title').text('Import Data');
            $("#filename").val(null);
            $('#viewpreview').html('');
            $('#modalimport').modal('show');


        });

        $('#uploadForm').submit(function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            $.ajax({
                url: '/tmstglbatchlist/preview',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#preview').prop('disabled', true);
                    $('#preview').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('#preview').prop('disabled', false);
                    $('#preview').html('Preview');
                },
                success: function(response) {
                    // if (!checkSession(response)) return;

                    tmstdiagnosapreview();
                }
            });
        });


    });
</script>

<script>
    $(document).ready(function() {

        $("#glbatchentryTable").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            // Tambahkan dom option untuk menempatkan button
            dom: 'Bfrtip',
            ajax: {
                url: "<?= base_url('tmstglbatchlist/datatables') ?>",
                type: "POST",
                contentType: "application/json",
                data: function(d) {
                    return JSON.stringify(d); // hanya kirim data default dari DataTables
                }


            },
            columnDefs: [{
                    orderable: false,
                    targets: [12] // Kolom No dan Aksi tidak bisa diurutkan
                },
                {
                    targets: [12],
                    className: 'text-center'
                }
            ],
            columns: [{
                    data: 'batchId'
                },
                {
                    data: 'batchDesc'
                },
                {
                    data: 'srceLedgr'
                },
                {
                    data: 'batchTypeDesc'
                },
                {
                    data: 'swPrinted'
                },
                {
                    data: 'audtUser'
                },
                {
                    data: 'audtDate',
                    render: function(data) {
                        if (!data) return '';
                        const d = new Date(data);
                        const day = String(d.getDate()).padStart(2, '0');
                        const month = String(d.getMonth() + 1).padStart(2, '0');
                        const year = d.getFullYear();
                        return `${day}/${month}/${year}`;
                    }
                },
                {
                    data: 'debitTot'
                },
                {
                    data: 'creditTot'
                },
                {
                    data: 'entryCnt'
                },
                {
                    data: 'postngSeq'
                },
                {
                    data: 'batchStatDesc'
                },
                {
                    data: 'aksi',
                    orderable: false
                }
            ],
            buttons: [{
                    text: "Tambah",
                    action: function() {
                        // Tambah logic
                    },
                    attr: {
                        id: "add_record",
                        style: "background-color:#56b746; <?= session()->get('flag_insert') === 1 ? '' : 'd-none' ?>",
                        name: "add_record",
                        // nemeClass:"btn-sm btn-primary"
                    }

                }
                // {
                //     extend: "excel",
                //     text: "Excel",
                //     className: "btn-sm btn-primary <?= session()->get('flag_export') === 1 ? '' : 'd-none' ?>",
                //     exportOptions: {
                //         columns: [0, 1, 2, 3, 4, 5, 6]
                //     }
                // },
                // {
                //     extend: "print",
                //     text: "Cetak",
                //     className: "btn-sm btn-info <?= session()->get('flag_print') === 1 ? '' : 'd-none' ?>",
                //     exportOptions: {
                //         columns: [0, 1, 2, 3, 4, 5, 6]
                //     }
                // },
                // {
                //     text: "Import",
                //     action: function() {
                //         // Import logic
                //     },
                //     attr: {
                //         id: "import",
                //         style: "background-color:#56b746; <?= session()->get('flag_insert') === 1 ? '' : 'd-none' ?>",
                //         nameClass: "btn btn-sm btn-warning"
                //     }
                // }
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
        }).buttons().container().appendTo("#glbatchentryTable_wrapper .col-md-6:eq(0)");

        $('#glbatchentryTable').on('xhr.dt', function(e, settings, json, xhr) {
            if (json.status === 'session_expired') {
                window.location.href = "<?= base_url('auth/login') ?>";
                alert('Sesi Anda telah berakhir. Silakan login kembali.');
            }
        });
    });
</script>



<?= $this->endSection('script'); ?>