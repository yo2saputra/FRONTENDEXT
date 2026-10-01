<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>
<!-- Toastr -->
<link rel="stylesheet" href="<?= base_url('plugins/toastr/toastr.min.css') ?>">
<!-- Button datatable -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
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

<?php $session = session(); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1></h1>
                </div>
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

                            <div class="card-title"></div>

                            <table id="subUnitTable" class="table table-sm table-bordered table-striped">
                                <thead class="table">
                                    <tr>
                                        <th>No</th>
                                        <th>Sub Unit ID</th>
                                        <th>Nama Sub Unit</th>
                                        <th>Segment No</th>
                                        <th>Segment Value</th>
                                        <th>Unit ID</th>
                                        <th>Unit Name</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <!-- Modal Form -->
                        <div class="modal fade" id="modalform" tabindex="-1" role="dialog" aria-labelledby="modalformLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="modalformLabel"></h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="post" id="data_form" autocomplete="off">
                                        <?= csrf_field(); ?>
                                        <div class="modal-body">

                                            <div class="mb-3 row">
                                                <label for="subUnit_ID" class="col-sm-2 col-form-label">Sub Unit ID</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="subUnit_ID" name="subUnit_ID">
                                                    <span class="error invalid-feedback errorSubUnit_ID"></span>
                                                </div>
                                                <label for="subUnit_Name" class="col-sm-2 col-form-label">Nama Sub Unit</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="subUnit_Name" name="subUnit_Name">
                                                    <span class="error invalid-feedback errorSubUnit_Name"></span>
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label for="unit_ID" class="col-sm-2 col-form-label">Unit ID</label>
                                                <div class="col-sm-4">
                                                    <?= view('components/dropdown', [
                                                        'name'      => 'unit_ID',
                                                        'apiUrl'    => base_url('/dropdown/customize/2/1/dropdown/unit/null/null/null/null'),
                                                        'extraKeys' => [],
                                                        'selected'  => '',
                                                        'errors'    => $errors ?? []
                                                    ]) ?>
                                                    <span class="error invalid-feedback errorUnit_ID"></span>
                                                </div>
                                                <label for="segment_No" class="col-sm-2 col-form-label">Segment No</label>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control form-control-sm" id="segment_No" name="segment_No">
                                                    <span class="error invalid-feedback errorSegment_No"></span>
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label for="segment_Value" class="col-sm-2 col-form-label">Segment Value</label>
                                                <div class="col-sm-4">
                                                    <input type="number" step="0.01" class="form-control form-control-sm" id="segment_Value" name="segment_Value">
                                                    <span class="error invalid-feedback errorSegment_Value"></span>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" id="hidden_id" name="hidden_id" />
                                            <input type="hidden" id="action" name="action" value="Add" />
                                            <button type="submit" name="submit" id="submit_button" class="btn btn-sm btn-primary">Simpan</button>
                                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /Modal Form -->

                        <!-- Modal Import -->
                        <div class="modal fade" id="modalimport" tabindex="-1" role="dialog" aria-labelledby="modalimportLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="modalimportLabel">Import Data</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="<?= site_url('tmstsubunit/preview') ?>" id="uploadForm" method="post" enctype="multipart/form-data">
                                            <?= csrf_field(); ?>
                                            <label for="filename">Import Excel File : <a href="<?= site_url('tmstsubunit/download') ?>"><u>Download Format</u></a></label><br>
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
                        <!-- /Modal Import -->

                    </div>
                    <!-- /.card -->

                </div>
            </div>
        </div>
    </section>
</div>

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
    $('#active-menu').html($('p#active-menu').html());
    $(document).prop("title", $('p#active-menu').html());
</script>

<script>
    function tmstsubunitpreview() {
        $.ajax({
            method: "get",
            url: "<?= site_url('tmstsubunit/preview'); ?>",
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
            clearFormValidation();

            $('#subUnit_ID').prop('disabled', false).prop('readonly', false);
            $('#subUnit_Name').prop('disabled', false);
            $('select[name="unit_ID"]').val('').prop('disabled', false).trigger('change.select2');
            $('#segment_No').prop('disabled', false);
            $('#segment_Value').prop('disabled', false);

            $('.modal-title').text('Tambah Data');
            $('#action').val('Add');
            $('#submit_button').html('Simpan').show();
            $('#modalform').modal('show');
        });

        $('#data_form').on('submit', function(event) {
            event.preventDefault();

            $.ajax({
                url: "<?= site_url('tmstsubunit/action'); ?>",
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
                        Swal.fire({ icon: 'error', title: 'Gagal', text: response.message || 'Terjadi kesalahan saat menyimpan data.' });
                    } else {
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message || 'Data berhasil disimpan.' });
                        clearFormValidation();
                        $('#data_form')[0].reset();
                        $('#modalform').modal('hide');
                        $('#subUnitTable').DataTable().ajax.reload(null, false);
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({ icon: 'error', title: 'Server Error', text: 'Gagal menghubungi server. Silakan coba lagi nanti.' });
                    console.error('AJAX Error:', status, error);
                }
            });
        });

        function showValidationErrors(errors) {
            const fields = ['subUnit_ID', 'subUnit_Name', 'unit_ID', 'segment_No', 'segment_Value'];
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

        function clearFormValidation() {
            const fields = ['subUnit_ID', 'subUnit_Name', 'unit_ID', 'segment_No', 'segment_Value'];
            fields.forEach(function(field) {
                $('#' + field).removeClass('is-invalid');
                $('.error' + capitalize(field)).html('');
            });
        }

        function capitalize(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

        $(document).on('click', '.view', function() {
            const subUnit_id = $(this).data('id');

            $.ajax({
                url: "<?= site_url('tmstsubunit/fetchSingleData'); ?>",
                method: "GET",
                data: { subUnit_id },
                dataType: "JSON",
                success: function(response) {
                    if (!checkSession(response)) return;

                    clearFormValidation();
                    $('#data_form')[0].reset();

                    const d = response.data;
                    $('#subUnit_ID').val(d.subUnit_ID).prop('disabled', true);
                    $('#subUnit_Name').val(d.subUnit_Name).prop('disabled', true);
                    $('select[name="unit_ID"]').val(d.unit_ID).prop('disabled', true).trigger('change.select2');
                    $('#segment_No').val(d.segment_No).prop('disabled', true);
                    $('#segment_Value').val(d.segment_Value).prop('disabled', true);

                    $('.modal-title').text('Lihat Data');
                    $('#action').val('View');
                    $('#submit_button').hide();
                    $('#hidden_id').val(subUnit_id);
                    $('#modalform').modal('show');
                },
                error: function() {
                    Swal.fire({ icon: 'error', title: 'Gagal mengambil data', text: 'Terjadi kesalahan saat mengambil data Sub Unit.' });
                }
            });
        });

        $(document).on('click', '.edit', function() {
            const subUnit_id = $(this).data('id');

            $.ajax({
                url: "<?= site_url('tmstsubunit/fetchSingleData'); ?>",
                method: "GET",
                data: { subUnit_id },
                dataType: "JSON",
                success: function(response) {
                    if (!checkSession(response)) return;

                    clearFormValidation();
                    $('#data_form')[0].reset();

                    const d = response.data;
                    $('#subUnit_ID').val(d.subUnit_ID).prop('disabled', false).prop('readonly', true);
                    $('#subUnit_Name').val(d.subUnit_Name).prop('disabled', false);
                    $('select[name="unit_ID"]').val(d.unit_ID).prop('disabled', false).trigger('change.select2');
                    $('#segment_No').val(d.segment_No).prop('disabled', false);
                    $('#segment_Value').val(d.segment_Value).prop('disabled', false);

                    $('.modal-title').text('Ubah Data');
                    $('#action').val('Edit');
                    $('#submit_button').html('Simpan').show();
                    $('#hidden_id').val(subUnit_id);
                    $('#modalform').modal('show');
                },
                error: function() {
                    Swal.fire({ icon: 'error', title: 'Gagal mengambil data', text: 'Terjadi kesalahan saat mengambil data Sub Unit.' });
                }
            });
        });

        $(document).on('click', '.delete', function() {
            const subUnit_id = $(this).data('id');

            Swal.fire({
                title: 'Yakin ingin menghapus data?',
                text: 'Data Sub Unit akan dihapus secara permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= site_url('tmstsubunit/delete'); ?>",
                        method: "POST",
                        data: { subUnit_id },
                        dataType: "JSON",
                        success: function(response) {
                            if (!checkSession(response)) return;

                            if (response.status === 'error') {
                                Swal.fire({ icon: 'error', title: 'Gagal', text: response.message || 'Terjadi kesalahan saat menghapus data.' });
                            } else {
                                Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message || 'Data berhasil dihapus.' });
                                $('#subUnitTable').DataTable().ajax.reload(null, false);
                            }
                        },
                        error: function() {
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
            $('.modal-title').text('Import Data');
            $('#filename').val(null);
            $('#viewpreview').html('');
            $('#modalimport').modal('show');
        });

        $('#uploadForm').submit(function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            $.ajax({
                url: '/tmstsubunit/preview',
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
                success: function() {
                    tmstsubunitpreview();
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

        $("#subUnitTable").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            dom: 'Bfrtip',
            ajax: {
                url: "<?= base_url('tmstsubunit/datatables') ?>",
                type: "POST",
                contentType: "application/json",
                data: function(d) {
                    return JSON.stringify(d);
                }
            },
            columnDefs: [
                { orderable: false, targets: [0, 7] },
                { targets: [0, 7], className: 'text-center' }
            ],
            columns: [
                { data: 'rownum',        orderable: false },
                { data: 'subUnit_ID' },
                { data: 'subUnit_Name' },
                { data: 'segment_No' },
                { data: 'segment_Value' },
                { data: 'unit_ID' },
                { data: 'unit_Name' },
                { data: 'aksi',          orderable: false }
            ],
            buttons: [
                {
                    text: "Tambah",
                    action: function() {},
                    attr: {
                        id: "add_record",
                        style: "background-color:#56b746; <?= session()->get('flag_insert') === 1 ? '' : 'display:none;' ?>",
                        name: "add_record"
                    }
                },
                {
                    extend: "excel",
                    text: "Excel",
                    className: "btn-sm btn-primary <?= session()->get('flag_export') === 1 ? '' : 'd-none' ?>",
                    exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
                },
                {
                    extend: "print",
                    text: "Cetak",
                    className: "btn-sm btn-info <?= session()->get('flag_print') === 1 ? '' : 'd-none' ?>",
                    exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
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
        }).buttons().container().appendTo("#subUnitTable_wrapper .col-md-6:eq(0)");

        $('#subUnitTable').on('xhr.dt', function(e, settings, json) {
            if (json && json.status === 'session_expired') {
                window.location.href = "<?= base_url('auth/login') ?>";
                alert('Sesi Anda telah berakhir. Silakan login kembali.');
            }
        });

    });
</script>

<?= $this->endSection('script'); ?>