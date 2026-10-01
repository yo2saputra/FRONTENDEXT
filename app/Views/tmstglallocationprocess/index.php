<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>
<!-- Toastr -->
<link rel="stylesheet" href="<?= base_url('plugins/toastr/toastr.min.css') ?>">
<style>
    .allocation-title {
        font-size: 28px;
        font-weight: 600;
        text-align: center;
        margin-bottom: 30px;
        color: #495057;
    }

    .note-text {
        font-style: italic;
        color: #6c757d;
        text-align: center;
        margin-top: 25px;
    }

    .form-group label {
        font-weight: 500;
        margin-bottom: 5px;
    }

    .btn-process {
        padding: 8px 30px;
        font-size: 16px;
        font-weight: 500;
    }
</style>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<p id="active-menu" style="display:none;">Allocation Process</p>

<div class="content-wrapper">

    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1></h1>
                </div>
                <div class="col-sm-6"></div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">

                    <div class="card card-outline card-info">
                        <div class="card-body">

                            <div class="allocation-title">
                                Allocation Process
                            </div>

                            <form id="allocationForm">

                                <div class="row justify-content-center mb-4">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Transaction Date:</label>
                                            <input type="date" class="form-control form-control-sm"
                                                id="transaction_date"
                                                value="<?= $transaction_date ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Year:</label>
                                            <?= $cb_fiscal_calender_year ?>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Period:</label>
                                            <?= $cb_fiscal_period ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="button" class="btn btn-primary btn-process" id="startAllocationProcess">
                                        <i class="fas fa-play mr-2"></i>Start Process
                                    </button>
                                </div>

                            </form>

                            <!-- NOTE -->
                            <div class="note-text">
                                Note: Process will create journal entries for active allocations.
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Allocation Process</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-question-circle fa-3x text-warning mb-3"></i>
                <h5>Start Allocation Process?</h5>
                <p class="text-muted" id="confirmationDetails">
                </p>
                <div class="mt-4">
                    <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="btnConfirmYes">Yes, Start</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center py-5">
                <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                <h4>Allocation Process Successful!</h4>
                <p id="successMessage"></p>
                <div id="processInfo" style="display: none;" class="mt-3">
                    <!-- Process info will be filled via JS -->
                </div>
                <button type="button" class="btn btn-primary mt-3" data-dismiss="modal" onclick="window.location.reload()">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center py-5">
                <i class="fas fa-times-circle fa-4x text-danger mb-3"></i>
                <h4>Allocation Process Failed</h4>
                <p id="errorMessage"></p>
                <button type="button" class="btn btn-primary mt-3" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection('content'); ?>

<?= $this->section('script'); ?>
<!-- Toastr -->
<script src="<?= base_url('plugins/toastr/toastr.min.js') ?>"></script>

<script>
    $(document).ready(function() {
        // SET MENU SCRIPT
        $('#active-menu').html($('p#active-menu').html());
        $(document).prop("title", $('p#active-menu').html());
    });
</script>

<script>
    $(document).ready(function() {
        // When Start Process button is clicked
        $('#startAllocationProcess').click(function() {
            // Get form values
            var fiscalYear = $('#cb_fiscal_calender_year').val();
            var fiscalPeriod = $('#cb_fiscal_period').val();

            if (!fiscalYear || !fiscalPeriod) {
                toastr.error('Please select both Year and Period');
                return;
            }

            // Update confirmation details
            $('#confirmationDetails').html(
                'Year: <strong>' + fiscalYear + '</strong><br>' +
                'Period: <strong>' + fiscalPeriod + '</strong>'
            );

            // Show confirmation modal
            $('#confirmModal').modal('show');
        });

        // When Yes button in confirmation modal is clicked
        $('#btnConfirmYes').click(function() {
            var $btn = $(this);
            $btn.html('<i class="fas fa-spinner fa-spin mr-2"></i>Processing...').prop('disabled', true);

            // Get form values
            var fiscalYear = $('#cb_fiscal_calender_year').val();
            var fiscalPeriod = $('#cb_fiscal_period').val();

            $.ajax({
                url: '<?= base_url("tmstglallocationprocess/action") ?>',
                type: 'POST',
                data: {
                    fiscal_year: fiscalYear,
                    fiscal_period: fiscalPeriod,
                    confirmed: true
                },
                dataType: 'json',
                success: function(response) {
                    $btn.html('Yes, Start').prop('disabled', false);

                    if (response.success) {
                        $('#confirmModal').modal('hide');

                        // Update success message
                        $('#successMessage').text(response.message || 'Process completed successfully.');

                        if (response.ProcessedCount !== undefined) {
                            $('#processInfo').html(`
                                <div class="alert alert-info">
                                    <strong>Processed:</strong> ${response.ProcessedCount}<br>
                                    <strong>Errors:</strong> ${response.ErrorCount || 0}
                                </div>
                            `).show();
                        }

                        $('#successModal').modal('show');
                    } else {
                        $('#errorMessage').text(response.message || 'An error occurred');
                        $('#errorModal').modal('show');
                    }
                },
                error: function(xhr) {
                    $btn.html('Yes, Start').prop('disabled', false);

                    let msg = xhr.responseJSON?.message || 'Connection error. Please try again';
                    $('#errorMessage').text(msg);
                    $('#errorModal').modal('show');
                }
            });
        });

        // Reset button when modal closes
        $('#confirmModal').on('hidden.bs.modal', function() {
            $('#btnConfirmYes').html('Yes, Start').prop('disabled', false);
        });

        // Clear modals when hidden
        $('#successModal').on('hidden.bs.modal', function() {
            $('#processInfo').html('').hide();
            $('#successMessage').text('');
        });

        $('#errorModal').on('hidden.bs.modal', function() {
            $('#errorMessage').text('');
        });
    });
</script>
<?= $this->endSection('script'); ?>