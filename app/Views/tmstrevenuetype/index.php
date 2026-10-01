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
                            <table id="revenueTypeTable" class="table table-sm table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Revenue</th>
                                        <th>Nama Revenue</th>
                                        <th>Revenue Acc</th>
                                        <th>Disc Acc</th>
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
                                                <label for="revenue_ID" class="col-sm-2 col-form-label">Kode</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="revenue_ID" name="revenue_ID">
                                                    <span class="error invalid-feedback errorRevenue_ID"></span>
                                                </div>
                                                <label for="revenue_Name" class="col-sm-2 col-form-label">Nama Revenue</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="revenue_Name" name="revenue_Name">
                                                    <span class="error invalid-feedback errorRevenue_Name"></span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="revenue_Acc" class="col-sm-2 col-form-label">Revenue Acc</label>
                                                <div class="col-sm-4">
                                                    <?= view('components/dropdown', [
                                                        'name'      => 'revenue_Acc',
                                                        'apiUrl'    => base_url('/dropdown/customize/2/1/dropdown/glcoa/null/null/null/null'),
                                                        'extraKeys' => [],
                                                        'selected'  => '',
                                                        'errors'    => $errors ?? []
                                                    ]) ?>
                                                    <span class="error invalid-feedback errorRevenue_Acc"></span>
                                                </div>
                                                <label for="disc_Acc" class="col-sm-2 col-form-label">Disc Acc</label>
                                                <div class="col-sm-4">
                                                    <?= view('components/dropdown', [
                                                        'name'      => 'disc_Acc',
                                                        'apiUrl'    => base_url('/dropdown/customize/2/1/dropdown/glcoa/null/null/null/null'),
                                                        'extraKeys' => [],
                                                        'selected'  => '',
                                                        'errors'    => $errors ?? []
                                                    ]) ?>
                                                    <span class="error invalid-feedback errorDisc_Acc"></span>
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
                                        <form action="<?= site_url("tmstrevenuetype/preview") ?>" id="uploadForm" method="post" enctype="multipart/form-data">
                                            <?= csrf_field(); ?>
                                            <label for="filename">Import Excel File : <a href="<?= site_url("tmstrevenuetype/download") ?>"><u>Download Format</u></a></label><br>
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
    function tmstrevenuetypepreview() {
        $.ajax({
            method: "get",
            url: "<?= site_url('tmstrevenuetype/preview'); ?>",
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

        // ── Tambah ─────────────────────────────────────────────────────────
        $(document).on('click', '#add_record', function() {
            $('#data_form')[0].reset();
            $('.is-invalid').removeClass('is-invalid');
            $('[class^="error"]').html('');

            $('#revenue_ID').prop('disabled', false).prop('readonly', false);
            $('#revenue_Name').prop('disabled', false);
            $('select[name="revenue_Acc"]').val('').prop('disabled', false).trigger('change.select2');
            $('select[name="disc_Acc"]').val('').prop('disabled', false).trigger('change.select2');

            $('.modal-title').text('Tambah Data');
            $('#action').val('Add');
            $('#submit_button').val('Simpan').html('Simpan').show();
            $('#modalform').modal('show');
        });

        // ── Submit ─────────────────────────────────────────────────────────
        $('#data_form').on('submit', function(event) {
            event.preventDefault();

            $.ajax({
                url: "<?= site_url('tmstrevenuetype/action'); ?>",
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
                        $('#revenueTypeTable').DataTable().ajax.reload(null, false);
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({ icon: 'error', title: 'Server Error', text: 'Gagal menghubungi server. Silakan coba lagi nanti.' });
                    console.error('AJAX Error:', status, error);
                }
            });
        });

        function showValidationErrors(errors) {
            const fields = ['revenue_ID', 'revenue_Name', 'revenue_Acc', 'disc_Acc'];
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
            ['revenue_ID', 'revenue_Name', 'revenue_Acc', 'disc_Acc'].forEach(function(field) {
                $('#' + field).removeClass('is-invalid');
                $('.error' + capitalize(field)).html('');
            });
        }

        function capitalize(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

        // ── View ───────────────────────────────────────────────────────────
        $(document).on('click', '.view', function() {
            const revenue_id = $(this).data('revenue_id');

            $.ajax({
                url: "<?= site_url('tmstrevenuetype/fetchSingleData'); ?>",
                method: "GET",
                data: { revenue_id },
                dataType: "JSON",
                success: function(response) {
                    if (!checkSession(response)) return;

                    $('#data_form')[0].reset();
                    $('.is-invalid').removeClass('is-invalid');
                    $('[class^="error"]').html('');

                    const data = response.data;

                    $('#revenue_ID').val(data.revenue_ID).prop('disabled', true);
                    $('#revenue_Name').val(data.revenue_Name).prop('disabled', true);
                    $('select[name="revenue_Acc"]').val(data.revenue_Acc).prop('disabled', true).trigger('change.select2');
                    $('select[name="disc_Acc"]').val(data.disc_Acc).prop('disabled', true).trigger('change.select2');

                    $('.modal-title').text('Lihat Data');
                    $('#action').val('View');
                    $('#submit_button').hide();
                    $('#hidden_id').val(revenue_id);
                    $('#modalform').modal('show');
                },
                error: function(xhr, status, error) {
                    Swal.fire({ icon: 'error', title: 'Gagal mengambil data', text: 'Terjadi kesalahan saat mengambil data revenue type.' });
                    console.error('AJAX Error:', status, error);
                }
            });
        });

        // ── Edit ───────────────────────────────────────────────────────────
        $(document).on('click', '.edit', function() {
            const revenue_id = $(this).data('revenue_id');

            $.ajax({
                url: "<?= site_url('tmstrevenuetype/fetchSingleData'); ?>",
                method: "GET",
                data: { revenue_id },
                dataType: "JSON",
                success: function(response) {
                    if (!checkSession(response)) return;

                    $('#data_form')[0].reset();
                    $('.is-invalid').removeClass('is-invalid');
                    $('[class^="error"]').html('');

                    const data = response.data;

                    $('#revenue_ID').val(data.revenue_ID).prop('disabled', false).prop('readonly', true);
                    $('#revenue_Name').val(data.revenue_Name).prop('disabled', false);
                    $('select[name="revenue_Acc"]').val(data.revenue_Acc).prop('disabled', false).trigger('change.select2');
                    $('select[name="disc_Acc"]').val(data.disc_Acc).prop('disabled', false).trigger('change.select2');

                    $('.modal-title').text('Ubah Data');
                    $('#action').val('Edit');
                    $('#submit_button').val('Simpan').html('Simpan').show();
                    $('#hidden_id').val(revenue_id);
                    $('#modalform').modal('show');
                },
                error: function(xhr, status, error) {
                    Swal.fire({ icon: 'error', title: 'Gagal mengambil data', text: 'Terjadi kesalahan saat mengambil data revenue type.' });
                    console.error('AJAX Error:', status, error);
                }
            });
        });

        // ── Delete ─────────────────────────────────────────────────────────
        $(document).on('click', '.delete', function() {
            const revenue_id = $(this).data('revenue_id');

            Swal.fire({
                title: 'Yakin ingin menghapus data?',
                text: 'Data revenue type akan dihapus secara permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= site_url('tmstrevenuetype/delete'); ?>",
                        method: "POST",
                        data: { revenue_id },
                        dataType: "JSON",
                        success: function(response) {
                            if (!checkSession(response)) return;

                            if (response.status === 'error') {
                                Swal.fire({ icon: 'error', title: 'Gagal', text: response.message || 'Terjadi kesalahan saat menghapus data.' });
                            } else {
                                Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message || 'Data berhasil dihapus.' });
                                $('#revenueTypeTable').DataTable().ajax.reload(null, false);
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

        // ── Import ─────────────────────────────────────────────────────────
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
                url: '/tmstrevenuetype/preview',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() { $('#preview').prop('disabled', true).html('<i class="fa fa-spin fa-spinner"></i>'); },
                complete: function() { $('#preview').prop('disabled', false).html('Preview'); },
                success: function() { tmstrevenuetypepreview(); },
                error: function(xhr) { console.error('Error:', xhr.responseText); }
            });
        });

        // ── DataTable ──────────────────────────────────────────────────────
        $("#revenueTypeTable").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            dom: 'Bfrtip',
            ajax: {
                url: "<?= base_url('tmstrevenuetype/datatables') ?>",
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
                { data: 'revenue_ID' },
                { data: 'revenue_Name' },
                { data: 'revenue_Acc' },
                { data: 'disc_Acc' },
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
        }).buttons().container().appendTo("#revenueTypeTable_wrapper .col-md-6:eq(0)");

        $('#revenueTypeTable').on('xhr.dt', function(e, settings, json, xhr) {
            if (json.status === 'session_expired') {
                window.location.href = "<?= base_url('auth/login') ?>";
                alert('Sesi Anda telah berakhir. Silakan login kembali.');
            }
        });

    });
</script>
<?= $this->endSection('script'); ?>