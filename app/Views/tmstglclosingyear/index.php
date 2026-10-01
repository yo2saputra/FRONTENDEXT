<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>
<!-- Toastr -->
<link rel="stylesheet" href="<?= base_url('plugins/toastr/toastr.min.css') ?>">
<style>
    .btn-fix-w {
        width: 60px;
        padding-top: 0px;
        padding-bottom: 0px;
    }

    .simple-card {
        border: 1px solid #dee2e6;
        border-radius: 5px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .year-display {
        font-size: 2.5rem;
        font-weight: bold;
        color: #007bff;
        text-align: center;
    }

    .checklist-item {
        margin-bottom: 10px;
        padding-left: 30px;
        position: relative;
    }

    .checklist-item i {
        position: absolute;
        left: 0;
        top: 3px;
        color: #28a745;
    }
</style>
<?= $this->endSection('style'); ?>

<?= $this->section('content'); ?>

<!-- MENU SCRIPT (hidden) -->
<p id="active-menu" style="display: none;">Closing Year</p>

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
                    <!-- Breadcrumb optional -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-info">
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <div class="year-display"><?= $default_fiscal_year ?></div>
                                <p class="text-muted">Closing Year <?= $default_fiscal_year ?></p>
                            </div>

                            <!-- Checklist -->
                            <div class="simple-card">
                                <h5 class="mb-3">Prasyarat:</h5>
                                <div class="checklist-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Data sudah di-backup</span>
                                </div>
                                <div class="checklist-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Sudah generate fiscal calendar</span>
                                </div>
                                <div class="checklist-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Setup RE untuk semua account Income Statement</span>
                                </div>
                            </div>

                            <!-- Confirmation -->
                            <div class="simple-card">
                                <div class="form-group text-center">
                                    <div class="custom-control custom-checkbox d-inline-block">
                                        <input class="custom-control-input" type="checkbox" id="confirmAll" name="confirmAll">
                                        <label class="custom-control-label" for="confirmAll">
                                            Semua prasyarat telah dipenuhi
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Start Button -->
                            <div class="text-center mt-4">
                                <button type="button" class="btn btn-danger btn-lg" id="btnStartClosing" disabled style="min-width: 200px;">
                                    <i class="fas fa-play mr-2"></i>Start Closing Year
                                </button>
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
                <h5 class="modal-title">Konfirmasi Closing Year</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-question-circle fa-3x text-warning mb-3"></i>
                <h5>Start Closing Year untuk tahun <?= $default_fiscal_year ?>?</h5>
                <p class="text-muted">Proses ini akan mengunci transaksi tahun <?= $default_fiscal_year ?></p>

                <div class="mt-4">
                    <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Tidak</button>
                    <button type="button" class="btn btn-danger" id="btnConfirmYes">Ya, Start</button>
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
                <h4>Closing Year Berhasil!</h4>
                <p>Tahun <?= $default_fiscal_year ?> telah berhasil di-closing</p>
                <div id="batchInfo" style="display: none;" class="mt-3">
                    <!-- Batch info akan diisi via JS -->
                </div>
                <button type="button" class="btn btn-primary mt-3" data-dismiss="modal" onclick="window.location.reload()">OK</button>
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
        $('#confirmAll').change(function() {
            $('#btnStartClosing').prop('disabled', !$(this).is(':checked'));
        });

        $('#btnStartClosing').click(function() {
            $('#confirmModal').modal('show');
        });

        $('#btnConfirmYes').click(function() {
            var $btn = $(this);
            $btn.html('<i class="fas fa-spinner fa-spin mr-2"></i>Processing...').prop('disabled', true);

            $.ajax({
                url: '<?= base_url("tmstglclosingyear/action") ?>',
                type: 'POST',
                data: {
                    fiscal_year: '<?= $default_fiscal_year ?>',
                    confirmed: true
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#confirmModal').modal('hide');
                        if (response.batchId) {
                            $('#batchInfo').html(`
                            <div class="alert alert-info">
                                <strong>Batch ID:</strong> ${response.batchId}<br>
                                <strong>Pesan:</strong> ${response.message}
                            </div>
                        `).show();
                        }
                        $('#successModal').modal('show');
                    } else {
                        $btn.html('Ya, Start').prop('disabled', false);
                        toastr.error(response.message || 'Terjadi kesalahan');
                    }
                },
                error: function(xhr) {
                    $btn.html('Ya, Start').prop('disabled', false);
                    let msg = xhr.responseJSON?.message || 'Koneksi error. Silakan coba lagi';
                    toastr.error(msg);
                }
            });
        });

        $('#confirmModal').on('hidden.bs.modal', function() {
            $('#btnConfirmYes').html('Ya, Start').prop('disabled', false);
        });

        $('#successModal').on('hidden.bs.modal', function() {
            $('#batchInfo').html('').hide();
        });
    });
</script>


<?= $this->endSection('script'); ?>