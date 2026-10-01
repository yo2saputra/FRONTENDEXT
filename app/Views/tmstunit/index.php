<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>
<!-- Toastr -->
<link rel="stylesheet" href="<?= base_url('plugins/toastr/toastr.min.css') ?>">
<!-- Button datatable -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<style>
    .btn-fix-w { width: 60px; padding-top: 0px; padding-bottom: 0px; }
    select.form-control-sm~.select2-container--default { font-size: .720rem !important; }
    .form-control-sm { font-size: .720rem !important; }
</style>
<?= $this->endSection('style'); ?>

<?= $this->section('content'); ?>
<?php $session = session(); ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1></h1></div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-info">
                        <div class="card-body">
                            <table id="unitTable" class="table table-sm table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Unit</th>
                                        <th>Nama Unit</th>
                                        <th>Segment No</th>
                                        <th>Segment Value</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <!-- Modal Form -->
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
                                            <div class="mb-3 row">
                                                <label for="unit_ID" class="col-sm-2 col-form-label">Kode</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="unit_ID" name="unit_ID">
                                                    <span class="error invalid-feedback errorUnit_ID"></span>
                                                </div>
                                                <label for="unit_Name" class="col-sm-2 col-form-label">Nama Unit</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="unit_Name" name="unit_Name">
                                                    <span class="error invalid-feedback errorUnit_Name"></span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="segment_No" class="col-sm-2 col-form-label">Segment No</label>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control form-control-sm" id="segment_No" name="segment_No">
                                                    <span class="error invalid-feedback errorSegment_No"></span>
                                                </div>
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
                                            <button type="submit" name="submit" id="submit_button" class="btn btn-sm btn-primary" value="Simpan"></button>
                                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
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
                                        <form action="<?= site_url("tmstunit/preview") ?>" id="uploadForm" method="post" enctype="multipart/form-data">
                                            <?= csrf_field(); ?>
                                            <label for="filename">Import Excel File : <a href="<?= site_url("tmstunit/download") ?>"><u>Download Format</u></a></label><br>
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
<!-- Toastr -->
<script src="<?= base_url('plugins/toastr/toastr.min.js') ?>"></script>
<!-- Button datatable -->
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
    function tmstunitpreview() {
        $.ajax({
            method: "get",
            url: "<?= site_url('tmstunit/preview'); ?>",
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

            $('#unit_ID').prop('disabled', false).prop('readonly', false);
            $('#unit_Name').prop('disabled', false);
            $('#segment_No').prop('disabled', false);
            $('#segment_Value').prop('disabled', false);

            $('.modal-title').text('Tambah Data');
            $('#action').val('Add');
            $('#submit_button').val('Simpan').html('Simpan').show();
            $('#modalform').modal('show');
        });
        $('#data_form').on('submit', function(event) {
            event.preventDefault();

            $.ajax({
                url: "<?= site_url('tmstunit/action'); ?>",
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
                        $('#unitTable').DataTable().ajax.reload(null, false);
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({ icon: 'error', title: 'Server Error', text: 'Gagal menghubungi server. Silakan coba lagi nanti.' });
                    console.error('AJAX Error:', status, error);
                }
            });
        });

        function showValidationErrors(errors) {
            const fields = ['unit_ID', 'unit_Name', 'segment_No', 'segment_Value'];
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
            ['unit_ID', 'unit_Name', 'segment_No', 'segment_Value'].forEach(function(field) {
                $('#' + field).removeClass('is-invalid');
                $('.error' + capitalize(field)).html('');
            });
        }

        function capitalize(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }
        $(document).on('click', '.view', function() {
            const unit_id = $(this).data('unit_id');

            $.ajax({
                url: "<?= site_url('tmstunit/fetchSingleData'); ?>",
                method: "GET",
                data: { unit_id },
                dataType: "JSON",
                success: function(response) {
                    if (!checkSession(response)) return;

                    $('#data_form')[0].reset();
                    $('.is-invalid').removeClass('is-invalid');
                    $('[class^="error"]').html('');

                    const data = response.data;

                    $('#unit_ID').val(data.unit_ID).prop('disabled', true);
                    $('#unit_Name').val(data.unit_Name).prop('disabled', true);
                    $('#segment_No').val(data.segment_No).prop('disabled', true);
                    $('#segment_Value').val(data.segment_Value).prop('disabled', true);

                    $('.modal-title').text('Lihat Data');
                    $('#action').val('View');
                    $('#submit_button').hide();
                    $('#hidden_id').val(unit_id);
                    $('#modalform').modal('show');
                },
                error: function(xhr, status, error) {
                    Swal.fire({ icon: 'error', title: 'Gagal mengambil data', text: 'Terjadi kesalahan saat mengambil data unit.' });
                    console.error('AJAX Error:', status, error);
                }
            });
        });
        $(document).on('click', '.edit', function() {
            const unit_id = $(this).data('unit_id');

            $.ajax({
                url: "<?= site_url('tmstunit/fetchSingleData'); ?>",
                method: "GET",
                data: { unit_id },
                dataType: "JSON",
                success: function(response) {
                    if (!checkSession(response)) return;

                    $('#data_form')[0].reset();
                    $('.is-invalid').removeClass('is-invalid');
                    $('[class^="error"]').html('');

                    const data = response.data;

                    $('#unit_ID').val(data.unit_ID).prop('disabled', false).prop('readonly', true);
                    $('#unit_Name').val(data.unit_Name).prop('disabled', false);
                    $('#segment_No').val(data.segment_No).prop('disabled', false);
                    $('#segment_Value').val(data.segment_Value).prop('disabled', false);

                    $('.modal-title').text('Ubah Data');
                    $('#action').val('Edit');
                    $('#submit_button').val('Simpan').html('Simpan').show();
                    $('#hidden_id').val(unit_id);
                    $('#modalform').modal('show');
                },
                error: function(xhr, status, error) {
                    Swal.fire({ icon: 'error', title: 'Gagal mengambil data', text: 'Terjadi kesalahan saat mengambil data unit.' });
                    console.error('AJAX Error:', status, error);
                }
            });
        });
        $(document).on('click', '.delete', function() {
            const unit_id = $(this).data('unit_id');

            Swal.fire({
                title: 'Yakin ingin menghapus data?',
                text: 'Data unit akan dihapus secara permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= site_url('tmstunit/delete'); ?>",
                        method: "POST",
                        data: { unit_id },
                        dataType: "JSON",
                        success: function(response) {
                            if (!checkSession(response)) return;

                            if (response.status === 'error') {
                                Swal.fire({ icon: 'error', title: 'Gagal', text: response.message || 'Terjadi kesalahan saat menghapus data.' });
                            } else {
                                Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message || 'Data berhasil dihapus.' });
                                $('#unitTable').DataTable().ajax.reload(null, false);
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({ icon: 'error', title: 'Gagal menghapus data', text: 'Terjadi kesalahan saat menghubungi server.' });
                            console.error('AJAX Error:', status, error);
                        }
                    });
                }
            });
        });
        $(document).on('click', '#import', function() {
            $('.modal-title').text('Import Data');
            $("#filename").val(null);
            $('#viewpreview').html('');
            $('#modalimport').modal('show');
        });

        $('#uploadForm').submit(function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            $.ajax({
                url: '/tmstunit/preview',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() { $('#preview').prop('disabled', true).html('<i class="fa fa-spin fa-spinner"></i>'); },
                complete: function() { $('#preview').prop('disabled', false).html('Preview'); },
                success: function() { tmstunitpreview(); },
                error: function(xhr) { console.error('Error:', xhr.responseText); }
            });
        });
        $("#unitTable").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            dom: 'Bfrtip',
            ajax: {
                url: "<?= base_url('tmstunit/datatables') ?>",
                type: "POST",
                contentType: "application/json",
                data: function(d) { return JSON.stringify(d); }
            },
            columnDefs: [
                { orderable: false, targets: [0, 5] },
                { targets: [0, 5], className: 'text-center' }
            ],
            columns: [
                { data: 'rownum',        orderable: false },
                { data: 'unit_ID' },
                { data: 'unit_Name' },
                { data: 'segment_No' },
                { data: 'segment_Value' },
                { data: 'aksi',          orderable: false }
            ],
            buttons: [
                {
                    text: "Tambah", action: function() {},
                    attr: { id: "add_record", style: "background-color:#56b746; <?= session()->get('flag_insert') === 1 ? '' : 'd-none' ?>", name: "add_record" }
                },
                {
                    extend: "excel", text: "Excel",
                    className: "btn-sm btn-primary <?= session()->get('flag_export') === 1 ? '' : 'd-none' ?>",
                    exportOptions: { columns: [0, 1, 2, 3, 4] }
                },
                {
                    extend: "print", text: "Cetak",
                    className: "btn-sm btn-info <?= session()->get('flag_print') === 1 ? '' : 'd-none' ?>",
                    exportOptions: { columns: [0, 1, 2, 3, 4] }
                },
                {
                    text: "Import", action: function() {},
                    attr: { id: "import", style: "background-color:#56b746; <?= session()->get('flag_insert') === 1 ? '' : 'd-none' ?>" }
                }
            ],
            oLanguage: {
                sSearch: "Cari Data:",
                sInfoEmpty: "Tidak ada data",
                sInfo: "Total: _TOTAL_ data",
                sInfoFiltered: " dari _MAX_ data",
                sZeroRecords: "Data tidak ditemukan",
                oPaginate: { sFirst: "Awal", sPrevious: "Sebelum", sNext: "Berikut", sLast: "Akhir" }
            }
        }).buttons().container().appendTo("#unitTable_wrapper .col-md-6:eq(0)");

        $('#unitTable').on('xhr.dt', function(e, settings, json, xhr) {
            if (json.status === 'session_expired') {
                window.location.href = "<?= base_url('auth/login') ?>";
                alert('Sesi Anda telah berakhir. Silakan login kembali.');
            }
        });

    });
</script>
<?= $this->endSection('script'); ?>