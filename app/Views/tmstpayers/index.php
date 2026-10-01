<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>
<link rel="stylesheet" href="<?= base_url('plugins/toastr/toastr.min.css') ?>">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<style>
    .btn-fix-w { width: 60px; padding-top: 0; padding-bottom: 0; }
    .form-control-sm { font-size: .720rem !important; }
</style>
<?= $this->endSection('style'); ?>

<?= $this->section('content'); ?>
<?php $session = session(); ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Payers</h1>
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

                            <table id="payersTable" class="table table-sm table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Address</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Contact Person</th>
                                        <th>Coverage (%)</th>
                                        <th>Due Days</th>
                                        <th>Is Active</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>

                        </div>

                        <div class="modal fade" id="modalform" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title"></h4>
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="post" id="data_form" autocomplete="off">
                                        <?= csrf_field(); ?>
                                        <div class="modal-body">
                                            <div class="row">

                                                <div class="col-md-6">

                                                    <div class="mb-3 row">
                                                        <label class="col-sm-4 col-form-label">Payer Code <span class="text-danger">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm" id="payerCode" name="payerCode">
                                                            <span class="error invalid-feedback errorPayerCode"></span>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 row">
                                                        <label class="col-sm-4 col-form-label">Payer Name <span class="text-danger">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm" id="payerName" name="payerName">
                                                            <span class="error invalid-feedback errorPayerName"></span>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 row">
                                                        <label class="col-sm-4 col-form-label">Payer Type <span class="text-danger">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm" id="payerType" name="payerType">
                                                            <span class="error invalid-feedback errorPayerType"></span>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 row">
                                                        <label class="col-sm-4 col-form-label">Address</label>
                                                        <div class="col-sm-8">
                                                            <textarea class="form-control form-control-sm" id="address" name="address" rows="2"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 row">
                                                        <label class="col-sm-4 col-form-label">Phone</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm" id="phone" name="phone">
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 row">
                                                        <label class="col-sm-4 col-form-label">Email</label>
                                                        <div class="col-sm-8">
                                                            <input type="email" class="form-control form-control-sm" id="email" name="email">
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-md-6">

                                                    <div class="mb-3 row">
                                                        <label class="col-sm-4 col-form-label">Contact Person</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm" id="contactPerson" name="contactPerson">
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 row">
                                                        <label class="col-sm-4 col-form-label">Coverage (%)</label>
                                                        <div class="col-sm-8">
                                                            <input type="number" step="0.01" min="0" max="100" class="form-control form-control-sm" id="coveragePercent" name="coveragePercent">
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 row">
                                                        <label class="col-sm-4 col-form-label">Default Due Days</label>
                                                        <div class="col-sm-8">
                                                            <input type="number" step="1" min="0" class="form-control form-control-sm" id="defaultDueDays" name="defaultDueDays">
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 row">
                                                        <label class="col-sm-4 col-form-label">Is Active</label>
                                                        <div class="col-sm-8 d-flex align-items-center">
                                                            <div class="icheck-primary">
                                                                <input type="checkbox" id="isActive" name="isActive" value="1" checked>
                                                                <label for="isActive">Aktif</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div id="auditFields" style="display:none;">
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
                                            <input type="hidden" id="hidden_id" name="hidden_id">
                                            <input type="hidden" id="action" name="action" value="Add">
                                            <button type="submit" id="submit_button" class="btn btn-sm btn-primary">Simpan</button>
                                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="modalimport" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title"></h4>
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="<?= site_url('tmstpayers/preview') ?>" id="uploadForm" method="post" enctype="multipart/form-data">
                                            <?= csrf_field(); ?>
                                            <label for="filename">Import Excel File : <a href="<?= site_url('tmstpayers/download') ?>"><u>Download Format</u></a></label><br>
                                            <input type="file" name="filename" id="filename">
                                            <button type="submit" name="preview" class="btn btn-sm btn-primary" id="preview">Preview</button>
                                        </form>
                                        <div id="viewpreview"></div><br>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
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
<script src="<?= base_url('plugins/toastr/toastr.min.js') ?>"></script>
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
$(document).ready(function () {

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
            const date    = new Date(dateString);
            const day     = String(date.getDate()).padStart(2, '0');
            const month   = String(date.getMonth() + 1).padStart(2, '0');
            const year    = date.getFullYear();
            const hours   = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            return `${day}/${month}/${year} ${hours}:${minutes}`;
        } catch (e) { return dateString; }
    }

    function capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    function clearFormValidation() {
        ['payerCode', 'payerName', 'payerType'].forEach(function (field) {
            $('#' + field).removeClass('is-invalid');
            $('.error' + capitalize(field)).html('');
        });
    }

    function showValidationErrors(errors) {
        ['payerCode', 'payerName', 'payerType'].forEach(function (field) {
            if (errors[field]) {
                $('#' + field).addClass('is-invalid');
                $('.error' + capitalize(field)).html(errors[field]);
            } else {
                $('#' + field).removeClass('is-invalid');
                $('.error' + capitalize(field)).html('');
            }
        });
    }

    function resetForm() {
        $('#data_form')[0].reset();
        clearFormValidation();
        $('#auditFields').hide();
        $('#isActive').prop('checked', true);
        $('#payerCode, #payerName, #payerType, #address, #phone, #email, #contactPerson, #coveragePercent, #defaultDueDays, #isActive')
            .prop('disabled', false)
            .prop('readonly', false);
    }

    $(document).on('click', '#add_record', function () {
        resetForm();
        $('.modal-title').text('Tambah Data Payer');
        $('#action').val('Add');
        $('#hidden_id').val('');
        $('#submit_button').html('Simpan').show();
        $('#modalform').modal('show');
    });

    $('#data_form').on('submit', function (e) {
        e.preventDefault();

        const isActiveVal = $('#isActive').is(':checked') ? '1' : '0';
        if ($('#isActiveHidden').length === 0) {
            $('<input>').attr({ type: 'hidden', id: 'isActiveHidden', name: 'isActive' }).appendTo('#data_form');
        }
        $('#isActiveHidden').val(isActiveVal);
        $('#isActive').prop('disabled', true);

        $.ajax({
            url: "<?= site_url('tmstpayers/action') ?>",
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'JSON',
            beforeSend: function () {
                $('#submit_button').prop('disabled', true).html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function () {
                $('#submit_button').prop('disabled', false).html('Simpan');
                $('#isActive').prop('disabled', false);
            },
            success: function (response) {
                if (!checkSession(response)) return;
                if (response.error) {
                    showValidationErrors(response.error);
                } else if (response.status === 'error') {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: response.message || 'Terjadi kesalahan.' });
                } else {
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message || 'Data berhasil disimpan.' });
                    clearFormValidation();
                    $('#data_form')[0].reset();
                    $('#modalform').modal('hide');
                    $('#payersTable').DataTable().ajax.reload(null, false);
                }
            },
            error: function (xhr, status, error) {
                Swal.fire({ icon: 'error', title: 'Server Error', text: 'Gagal menghubungi server.' });
            }
        });
    });

    $(document).on('click', '.view', function () {
        const payerId = $(this).data('id');
        $.ajax({
            url: "<?= site_url('tmstpayers/fetchSingleData') ?>",
            method: 'GET',
            data: { payerId: payerId },
            dataType: 'JSON',
            success: function (response) {
                if (!checkSession(response)) return;
                if (response.status === 'error' || !response.data) {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: response.message || 'Data tidak ditemukan' });
                    return;
                }
                const d = response.data;
                resetForm();

                $('#payerCode').val(d.payerCode).prop('disabled', true);
                $('#payerName').val(d.payerName).prop('disabled', true);
                $('#payerType').val(d.payerType).prop('disabled', true);
                $('#address').val(d.address).prop('disabled', true);
                $('#phone').val(d.phone).prop('disabled', true);
                $('#email').val(d.email).prop('disabled', true);
                $('#contactPerson').val(d.contactPerson).prop('disabled', true);
                $('#coveragePercent').val(d.coveragePercent).prop('disabled', true);
                $('#defaultDueDays').val(d.defaultDueDays).prop('disabled', true);
                $('#isActive').prop('checked', d.isActive).prop('disabled', true);

                $('#auditFields').show();
                $('#createdBy').val(d.createdBy && d.createdBy.trim() !== '' ? d.createdBy : 'N/A');
                $('#createdDate').val(d.createdDate ? formatDate(d.createdDate) : '-');
                $('#updatedBy').val(d.updatedBy && d.updatedBy.trim() !== '' ? d.updatedBy : '-');
                $('#updatedDate').val(d.updatedDate ? formatDate(d.updatedDate) : '-');

                $('.modal-title').text('Lihat Data Payer');
                $('#action').val('View');
                $('#hidden_id').val(d.payerId);
                $('#submit_button').hide();
                $('#modalform').modal('show');
            },
            error: function (xhr, status, error) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan: ' + error });
            }
        });
    });

    $(document).on('click', '.edit', function () {
        const payerId = $(this).data('id');
        $.ajax({
            url: "<?= site_url('tmstpayers/fetchSingleData') ?>",
            method: 'GET',
            data: { payerId: payerId },
            dataType: 'JSON',
            success: function (response) {
                if (!checkSession(response)) return;
                if (response.status === 'error' || !response.data) {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: response.message || 'Data tidak ditemukan' });
                    return;
                }
                const d = response.data;
                resetForm();

                $('#payerCode').val(d.payerCode).prop('readonly', true);
                $('#payerName').val(d.payerName);
                $('#payerType').val(d.payerType);
                $('#address').val(d.address);
                $('#phone').val(d.phone);
                $('#email').val(d.email);
                $('#contactPerson').val(d.contactPerson);
                $('#coveragePercent').val(d.coveragePercent);
                $('#defaultDueDays').val(d.defaultDueDays);
                $('#isActive').prop('checked', d.isActive);

                $('.modal-title').text('Ubah Data Payer');
                $('#action').val('Edit');
                $('#hidden_id').val(d.payerId);
                $('#submit_button').html('Simpan').show();
                $('#modalform').modal('show');
            },
            error: function (xhr, status, error) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan: ' + error });
            }
        });
    });

    $(document).on('click', '.delete', function () {
        const payerId = $(this).data('id');
        Swal.fire({
            title: 'Yakin ingin menghapus data?',
            text: 'Data payer akan dihapus.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('tmstpayers/delete') ?>",
                    method: 'POST',
                    data: { payerId: payerId },
                    dataType: 'JSON',
                    success: function (response) {
                        if (!checkSession(response)) return;
                        if (response.status === 'error') {
                            Swal.fire({ icon: 'error', title: 'Gagal', text: response.message || 'Gagal menghapus data.' });
                        } else {
                            Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message || 'Data berhasil dihapus.' });
                            $('#payersTable').DataTable().ajax.reload(null, false);
                        }
                    },
                    error: function () {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal menghubungi server.' });
                    }
                });
            }
        });
    });

    $(document).on('click', '#import', function () {
        $('.modal-title').text('Import Data Payer');
        $('#filename').val(null);
        $('#viewpreview').html('');
        $('#modalimport').modal('show');
    });

    $('#uploadForm').submit(function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        $.ajax({
            url: "<?= site_url('tmstpayers/preview') ?>",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () { $('#preview').prop('disabled', true).html('<i class="fa fa-spin fa-spinner"></i>'); },
            complete: function () { $('#preview').prop('disabled', false).html('Preview'); },
            success: function () {
                $.ajax({
                    method: 'GET',
                    url: "<?= site_url('tmstpayers/preview') ?>",
                    success: function (data) { $('#viewpreview').html(data); }
                });
            },
            error: function (xhr) { console.error('Error:', xhr.responseText); }
        });
    });

    $('#payersTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        dom: 'Bfrtip',
        ajax: {
            url: "<?= base_url('tmstpayers/datatables') ?>",
            type: 'POST',
            contentType: 'application/json',
            data: function (d) { return JSON.stringify(d); }
        },
        columnDefs: [
            { orderable: false, targets: [0, 11] },
            { targets: [0, 11], className: 'text-center' }
        ],
        columns: [
            { data: 'rownum' },
            { data: 'payerCode',       defaultContent: '-' },
            { data: 'payerName',       defaultContent: '-' },
            { data: 'payerType',       defaultContent: '-' },
            { data: 'address',         defaultContent: '-' },
            { data: 'phone',           defaultContent: '-' },
            { data: 'email',           defaultContent: '-' },
            { data: 'contactPerson',   defaultContent: '-' },
            { data: 'coveragePercent', defaultContent: '-' },
            { data: 'defaultDueDays',  defaultContent: '-' },
            {
                data: 'isActive',
                defaultContent: '-',
                render: function (data) {
                    return data
                        ? '<span class="badge badge-success">Aktif</span>'
                        : '<span class="badge badge-secondary">Tidak Aktif</span>';
                }
            },
            { data: 'aksi', orderable: false, defaultContent: '' }
        ],
        buttons: [
            {
                text: 'Tambah',
                action: function () {},
                attr: {
                    id: 'add_record',
                    style: 'background-color:#56b746; <?= session()->get('flag_insert') === 1 ? '' : 'display:none;' ?>',
                    name: 'add_record'
                }
            },
            {
                extend: 'excel', text: 'Excel',
                className: 'btn-sm btn-primary <?= session()->get('flag_export') === 1 ? '' : 'd-none' ?>',
                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10] }
            },
            {
                extend: 'print', text: 'Cetak',
                className: 'btn-sm btn-info <?= session()->get('flag_print') === 1 ? '' : 'd-none' ?>',
                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10] }
            },
            {
                text: 'Import',
                action: function () {},
                attr: {
                    id: 'import',
                    style: 'background-color:#56b746; <?= session()->get('flag_insert') === 1 ? '' : 'display:none;' ?>',
                    name: 'import'
                }
            }
        ],
        oLanguage: {
            sSearch: 'Cari Data:', sInfoEmpty: 'Tidak ada data',
            sInfo: 'Total: _TOTAL_ data', sInfoFiltered: ' dari _MAX_ data',
            sZeroRecords: 'Data tidak ditemukan',
            oPaginate: { sFirst: 'Awal', sPrevious: 'Sebelum', sNext: 'Berikut', sLast: 'Akhir' }
        }
    }).buttons().container().appendTo('#payersTable_wrapper .col-md-6:eq(0)');

    $('#payersTable').on('xhr.dt', function (e, settings, json) {
        if (json && json.status === 'session_expired') {
            window.location.href = "<?= base_url('auth/login') ?>";
            alert('Sesi Anda telah berakhir. Silakan login kembali.');
        }
    });

});
</script>

<?= $this->endSection('script'); ?>