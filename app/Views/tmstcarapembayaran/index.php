<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>
<link rel="stylesheet" href="<?= base_url('plugins/toastr/toastr.min.css') ?>">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<link rel="stylesheet" href="<?= base_url('plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">
<style>
    .btn-fix-w {
        width: 60px;
        padding-top: 0px;
        padding-bottom: 0px;
    }

    select.form-control-sm~.select2-container--default {
        font-size: .720rem !important;
    }

    .form-control-sm {
        font-size: .720rem !important;
    }
</style>
<?= $this->endSection('style'); ?>

<?= $this->section('content'); ?>

<?php
$session = session();
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cara Pembayaran</h1>
                </div>
                <div class="col-sm-6">
                </div>
            </div>
        </div>
    </section>

    <section class="content">

        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">

                    <div class="card card-outline card-info">

                        <div class="card-body">

                            <div class="card-title">
                            </div>

                            <table id="caraPembayaranTable" class="table table-sm table-bordered table-striped">
                                <thead class="table">
                                    <tr>
                                        <th>No</th>
                                        <th>Jenis Pembayaran</th>
                                        <th>Deskripsi Cara Pembayaran</th>
                                        <th>Type</th>
                                        <th>Integrated Module</th>
                                        <th>Markup %</th>
                                        <th>Account No</th>
                                        <th>Account Name</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <div class="modal fade" id="modalform" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
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
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3 row">
                                                        <label for="jenisPembayaranId" class="col-sm-4 col-form-label">Jenis Pembayaran <span class="text-danger">*</span></label>
                                                        <div class="col-sm-8">
                                                            <div id="jenisPembayaranDropdown">
                                                                <?= $cb_jenis_pembayaran ?>
                                                                <span class="error invalid-feedback errorJenisPembayaranId"></span>
                                                            </div>
                                                            <input type="hidden" id="jenisPembayaranNmHidden" name="jenisPembayaranNm">
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 row">
                                                        <label for="descriptionCaraPembayaran" class="col-sm-4 col-form-label">Deskripsi <span class="text-danger">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm" id="descriptionCaraPembayaran" name="descriptionCaraPembayaran">
                                                            <span class="error invalid-feedback errorDescriptionCaraPembayaran"></span>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 row">
                                                        <label for="type" class="col-sm-4 col-form-label">Type <span class="text-danger">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm" id="type" name="type">
                                                            <span class="error invalid-feedback errorType"></span>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 row">
                                                        <label for="integratedModule" class="col-sm-4 col-form-label">Integrated Module</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm" id="integratedModule" name="integratedModule">
                                                            <span class="error invalid-feedback errorIntegratedModule"></span>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 row">
                                                        <label for="markupPercentage" class="col-sm-4 col-form-label">Markup Percentage</label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control form-control-sm" id="markupPercentage" name="markupPercentage" value="" min="0" step="1" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)">
                                                            <span class="error invalid-feedback errorMarkupPercentage"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="mb-3 row">
                                                        <label for="accountNo" class="col-sm-4 col-form-label">Account No <span class="text-danger">*</span></label>
                                                        <div class="col-sm-8">
                                                            <div id="accountNoDropdown">
                                                                <?= $cb_account_no ?>
                                                                <span class="error invalid-feedback errorAccountNo"></span>
                                                            </div>
                
                                                        </div>
                                                    </div>

                                                    <div id="auditFields" style="display: none;">
                                                        <hr>
                                                        <h6 class="text-muted">Informasi Audit</h6>
                                                        
                                                        <div class="mb-3 row">
                                                            <label class="col-sm-4 col-form-label">Created By</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control form-control-sm" id="createdBy" readonly>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3 row">
                                                            <label class="col-sm-4 col-form-label">Created Date</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control form-control-sm" id="createdDate" readonly>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3 row">
                                                            <label class="col-sm-4 col-form-label">Updated By</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control form-control-sm" id="updatedBy" readonly>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3 row">
                                                            <label class="col-sm-4 col-form-label">Updated Date</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control form-control-sm" id="updatedDate" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" id="hidden_id" name="hidden_id" />
                                            <input type="hidden" id="action" name="action" value="Add" />
                                            <button type="submit" name="submit" id="submit_button" class="btn btn-sm btn-primary" value="Simpan">Simpan</button>
                                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="modalimport" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLabel"></h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="<?= site_url("tmstcarapembayaran/preview") ?>" id="uploadForm" method="post" enctype="multipart/form-data">
                                            <?= csrf_field(); ?>
                                            <label for="filename">Import Excel File : <a href="<?= site_url("tmstcarapembayaran/download") ?>"><u>Download Format</u></a></label> <br>
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

                </div>
                <div class="col-md-6">

                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection('content'); ?>

<?= $this->section('script'); ?>

<script src="<?= base_url('plugins/toastr/toastr.min.js') ?>"></script>
<script src="<?= base_url('plugins/select2/js/select2.full.min.js') ?>"></script>
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
        initializeSelect2();
    });

    function initializeSelect2() {
        if ($('#jenisPembayaranId').hasClass('select2-hidden-accessible')) {
            $('#jenisPembayaranId').select2('destroy');
        }
        $('#jenisPembayaranId').select2({
            theme: 'bootstrap4',
            width: '100%',
            minimumResultsForSearch: Infinity,
            dropdownParent: $('#modalform')
        });

        if ($('select[name="params[accountNo]"]').hasClass('select2-hidden-accessible')) {
            $('select[name="params[accountNo]"]').select2('destroy');
        }
        $('select[name="params[accountNo]"]').select2({
            theme: 'bootstrap4',
            width: '100%',
            minimumResultsForSearch: 0,
            placeholder: '-- Pilih Account --',
            allowClear: true,
            dropdownParent: $('#modalform'),
            language: {
                noResults: function() { return "Tidak ditemukan"; },
                searching: function() { return "Mencari..."; },
            }
        });

        $(document).off('change', 'select[name="params[accountNo]"]').on('change', 'select[name="params[accountNo]"]', function() {
            var selectedText = $(this).find('option:selected').text();
            var accountDesc = '';
            if (selectedText && selectedText.includes(' - ')) {
                accountDesc = selectedText.split(' - ').slice(1).join(' - ');
            }
            $('#acctName').val(accountDesc);
            $('#acctNameHidden').val(accountDesc);
        });

        $(document).off("change", "#jenisPembayaranId").on("change", "#jenisPembayaranId", function() {
            var selectedText = $(this).find("option:selected").text();
            $("#jenisPembayaranNmHidden").val(selectedText !== "--Select--" ? selectedText : "");
        });
    }

    $('#modalform').on('shown.bs.modal', function() {
        initializeSelect2();
    });

    function caraPembayaranpreview() {
        $.ajax({
            method: "get",
            url: "<?= site_url('tmstcarapembayaran/preview'); ?>",
            success: function(data) {
                $('#viewpreview').html(data);
            }
        });
    }

    $(document).ready(function() {

        function checkSession(response) {
            if (response && response.status === 'session_expired') {
                window.location.href = "<?= base_url('auth/login') ?>";
                return false;
            }
            return true;
        }

        $(document).on('click', '#add_record', function() {

            $('#data_form')[0].reset();
            $('.is-invalid').removeClass('is-invalid');
            $('[class^="error"]').html('');

            $('#auditFields').hide();

            initializeSelect2();

            $('#jenisPembayaranId').val('').prop('disabled', false).trigger('change.select2');
            $('select[name="params[accountNo]"]').val('').prop('disabled', false).trigger('change.select2');
            $('#descriptionCaraPembayaran').prop('disabled', false);
            $('#type').prop('disabled', false);
            $('#integratedModule').prop('disabled', false);
            $('#markupPercentage').prop('disabled', false);
            $('#acctName').val('');
            $('#acctNameHidden').val('');

            $('.modal-title').text('Tambah Data Cara Pembayaran');
            $('#action').val('Add');
            $('#hidden_id').val('');
            $('#submit_button').val('Simpan').html('Simpan').show();
            $('#modalform').modal('show');
        });

        $('#markupPercentage').on('input', function() {
            var value = $(this).val();
            value = value.replace(/[^0-9]/g, '');
            $(this).val(value);
        });

        $('#data_form').on('submit', function(event) {
            event.preventDefault();

            $('#acctNameHidden').val($('#acctName').val());

            $.ajax({
                url: "<?= site_url('tmstcarapembayaran/action'); ?>",
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
                        $('#caraPembayaranTable').DataTable().ajax.reload(null, false);
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

        function showValidationErrors(errors) {
            const fields = ['jenisPembayaranId', 'descriptionCaraPembayaran', 'type', 'accountNo'];
            fields.forEach(function(field) {
                if (errors[field]) {
                    if (field === 'accountNo') {
                        $('select[name="params[accountNo]"]').addClass('is-invalid');
                    } else {
                        $('#' + field).addClass('is-invalid');
                    }
                    $('.error' + capitalize(field)).html(errors[field]);
                } else {
                    if (field === 'accountNo') {
                        $('select[name="params[accountNo]"]').removeClass('is-invalid');
                    } else {
                        $('#' + field).removeClass('is-invalid');
                    }
                    $('.error' + capitalize(field)).html('');
                }
            });
        }

        function clearFormValidation() {
            const fields = ['jenisPembayaranId', 'descriptionCaraPembayaran', 'type', 'integratedModule', 'markupPercentage', 'acctName'];
            fields.forEach(function(field) {
                $('#' + field).removeClass('is-invalid');
                $('.error' + capitalize(field)).html('');
            });
            $('select[name="params[accountNo]"]').removeClass('is-invalid');
            $('.errorAccountNo').html('');
        }

        function capitalize(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

        function formatDate(dateString) {
            if (!dateString) return '-';
            try {
                const date = new Date(dateString);
                const day     = String(date.getDate()).padStart(2, '0');
                const month   = String(date.getMonth() + 1).padStart(2, '0');
                const year    = date.getFullYear();
                const hours   = String(date.getHours()).padStart(2, '0');
                const minutes = String(date.getMinutes()).padStart(2, '0');
                return `${day}/${month}/${year} ${hours}:${minutes}`;
            } catch (e) {
                return dateString;
            }
        }

        $(document).on('click', '.view', function() {
            const caraPembayaranId = $(this).data('id');

            $.ajax({
                url: "<?= site_url('tmstcarapembayaran/fetchSingleData'); ?>",
                method: "GET",
                data: { caraPembayaranId: caraPembayaranId },
                dataType: "JSON",
                success: function(response) {

                    if (!checkSession(response)) return;

                    if (response.status === 'error') {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: response.message || 'Gagal mengambil data' });
                        return;
                    }

                    if (!response.data) {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: 'Data tidak ditemukan' });
                        return;
                    }

                    $('#data_form')[0].reset();
                    $('.is-invalid').removeClass('is-invalid');
                    $('[class^="error"]').html('');

                    const data = response.data;

                    initializeSelect2();

                    $('#jenisPembayaranId').val(data.jenisPembayaranId).prop('disabled', true).trigger('change.select2');
                    $("#jenisPembayaranNmHidden").val(data.jenisPembayaranNm || '');

                    $('select[name="params[accountNo]"]').val(data.accountNo).prop('disabled', true).trigger('change.select2');

                    $('#descriptionCaraPembayaran').val(data.descriptionCaraPembayaran).prop('disabled', true);
                    $('#type').val(data.type).prop('disabled', true);
                    $('#integratedModule').val(data.integratedModule).prop('disabled', true);
                    $('#markupPercentage').val(data.markupPercentage).prop('disabled', true);
                    $('#acctName').val(data.acctName || '');
                    $('#acctNameHidden').val(data.acctName || '');

                    $('#auditFields').show();
                    $('#createdBy').val(data.createdBy && data.createdBy.trim() !== '' ? data.createdBy : 'N/A');
                    $('#createdDate').val(data.createdDate ? formatDate(data.createdDate) : '-');
                    $('#updatedBy').val(data.updatedBy && data.updatedBy.trim() !== '' ? data.updatedBy : '-');
                    $('#updatedDate').val(data.updatedDate ? formatDate(data.updatedDate) : '-');

                    $('.modal-title').text('Lihat Data Cara Pembayaran');
                    $('#action').val('View');
                    $('#hidden_id').val(data.caraPembayaranId);
                    $('#submit_button').hide();
                    $('#modalform').modal('show');
                },
                error: function(xhr, status, error) {
                    Swal.fire({ icon: 'error', title: 'Gagal mengambil data', text: 'Terjadi kesalahan: ' + error });
                }
            });
        });

        $(document).on('click', '.edit', function() {
            const caraPembayaranId = $(this).data('id');

            $.ajax({
                url: "<?= site_url('tmstcarapembayaran/fetchSingleData'); ?>",
                method: "GET",
                data: { caraPembayaranId: caraPembayaranId },
                dataType: "JSON",
                success: function(response) {

                    if (!checkSession(response)) return;

                    if (response.status === 'error') {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: response.message || 'Gagal mengambil data' });
                        return;
                    }

                    if (!response.data) {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: 'Data tidak ditemukan' });
                        return;
                    }

                    $('#data_form')[0].reset();
                    $('.is-invalid').removeClass('is-invalid');
                    $('[class^="error"]').html('');

                    $('#auditFields').hide();

                    const data = response.data;

                    initializeSelect2();

                    $('#jenisPembayaranId').val(data.jenisPembayaranId).prop('disabled', false).trigger('change.select2');
                    $("#jenisPembayaranNmHidden").val(data.jenisPembayaranNm || "");
                    $('select[name="params[accountNo]"]').val(data.accountNo).prop('disabled', false).trigger('change.select2');

                    $('#descriptionCaraPembayaran').val(data.descriptionCaraPembayaran).prop('disabled', false);
                    $('#type').val(data.type).prop('disabled', false);
                    $('#integratedModule').val(data.integratedModule).prop('disabled', false);
                    $('#markupPercentage').val(data.markupPercentage).prop('disabled', false);
                    $('#acctName').val(data.acctName || '');
                    $('#acctNameHidden').val(data.acctName || '');

                    $('.modal-title').text('Ubah Data Cara Pembayaran');
                    $('#action').val('Edit');
                    $('#hidden_id').val(data.caraPembayaranId);
                    $('#submit_button').val('Simpan').html('Simpan').show();
                    $('#modalform').modal('show');
                },
                error: function(xhr, status, error) {
                    Swal.fire({ icon: 'error', title: 'Gagal mengambil data', text: 'Terjadi kesalahan: ' + error });
                }
            });
        });

        $(document).on('click', '.delete', function() {
            const caraPembayaranId = $(this).data('id');

            Swal.fire({
                title: 'Yakin ingin menghapus data?',
                text: 'Data cara pembayaran akan dihapus secara permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= site_url('tmstcarapembayaran/delete'); ?>",
                        method: "POST",
                        data: { caraPembayaranId: caraPembayaranId },
                        dataType: "JSON",
                        success: function(response) {

                            if (!checkSession(response)) return;

                            if (response.status === 'error') {
                                Swal.fire({ icon: 'error', title: 'Gagal', text: response.message || 'Terjadi kesalahan saat menghapus data.' });
                            } else {
                                Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message || 'Data berhasil dihapus.' });
                                $('#caraPembayaranTable').DataTable().ajax.reload(null, false);
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({ icon: 'error', title: 'Gagal menghapus data', text: 'Terjadi kesalahan saat menghubungi server.' });
                        }
                    });
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {

        $(document).on('click', '#import', function() {
            $('.modal-title').text('Import Data Cara Pembayaran');
            $("#filename").val(null);
            $('#viewpreview').html('');
            $('#modalimport').modal('show');
        });

        $('#uploadForm').submit(function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            $.ajax({
                url: '/tmstcarapembayaran/preview',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#preview').prop('disabled', true).html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('#preview').prop('disabled', false).html('Preview');
                },
                success: function(response) {
                    caraPembayaranpreview();
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {

        $("#caraPembayaranTable").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            dom: 'Bfrtip',
            ajax: {
                url: "<?= base_url('tmstcarapembayaran/datatables') ?>",
                type: "POST",
                contentType: "application/json",
                data: function(d) {
                    return JSON.stringify(d);
                }
            },
            columnDefs: [
                { orderable: false, targets: [0, 8] },
                { targets: [0, 8], className: 'text-center' }
            ],
            columns: [
                { data: 'rownum', orderable: false },
                { data: 'jenisPembayaranNm' },
                { data: 'descriptionCaraPembayaran' },
                { data: 'type' },
                { data: 'integratedModule' },
                {
                    data: 'markupPercentage',
                    render: function(data, type, row) {
                        return data + '%';
                    }
                },
                { data: 'accountNo' },
                { data: 'acctName' },
                { data: 'aksi', orderable: false }
            ],
            buttons: [
                {
                    text: "Tambah",
                    action: function() {},
                    attr: {
                        id: "add_record",
                        style: "background-color:#56b746; <?= session()->get('flag_insert') === 1 ? '' : 'display:none;' ?>",
                        name: "add_record",
                    }
                },
                {
                    extend: "excel",
                    text: "Excel",
                    className: "btn-sm btn-primary <?= session()->get('flag_export') === 1 ? '' : 'd-none' ?>",
                    exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] }
                },
                {
                    extend: "print",
                    text: "Cetak",
                    className: "btn-sm btn-info <?= session()->get('flag_print') === 1 ? '' : 'd-none' ?>",
                    exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] }
                },
                {
                    text: "Import",
                    action: function() {},
                    attr: {
                        id: "import",
                        style: "background-color:#56b746; <?= session()->get('flag_insert') === 1 ? '' : 'display:none;' ?>",
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
        }).buttons().container().appendTo("#caraPembayaranTable_wrapper .col-md-6:eq(0)");

        $('#caraPembayaranTable').on('xhr.dt', function(e, settings, json, xhr) {
            if (json && json.status === 'session_expired') {
                window.location.href = "<?= base_url('auth/login') ?>";
                alert('Sesi Anda telah berakhir. Silakan login kembali.');
            }
        });
    });
</script>

<?= $this->endSection('script'); ?>