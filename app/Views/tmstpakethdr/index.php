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

                            <table id="paketHdrTable" class="table table-sm table-bordered table-striped">
                                <thead class="table">
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Paket</th>
                                        <th>Nama Paket</th>
                                        <th>Jumlah Visit</th>
                                        <th>Include Admin</th>
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
                                                <label for="paket_ID" class="col-sm-2 col-form-label">Kode</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="paket_ID" name="paket_ID">
                                                    <span class="error invalid-feedback errorPaket_ID"></span>
                                                </div>
                                                <label for="paket_Name" class="col-sm-2 col-form-label">Nama Paket</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="paket_Name" name="paket_Name">
                                                    <span class="error invalid-feedback errorPaket_Name"></span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="jumlah_Visit" class="col-sm-2 col-form-label">Jumlah Visit</label>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control form-control-sm" id="jumlah_Visit" name="jumlah_Visit">
                                                    <span class="error invalid-feedback errorJumlah_Visit"></span>
                                                </div>
                                                <label for="include_Admin" class="col-sm-2 col-form-label">Include Admin</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control form-control-sm" id="include_Admin" name="include_Admin">
                                                        <option value="">-- Pilih --</option>
                                                        <option value="YES">YES</option>
                                                        <option value="NO">NO</option>
                                                    </select>
                                                    <span class="error invalid-feedback errorInclude_Admin"></span>
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
                                        <form action="<?= site_url("tmstpakethdr/preview") ?>" id="uploadForm" method="post" enctype="multipart/form-data">
                                            <?= csrf_field(); ?>
                                            <label for="filename">Import Excel File : <a href="<?= site_url("tmstpakethdr/download") ?>"><u>Download Format</u></a></label> <br>
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
    function tmstpakethdrpreview() {
        $.ajax({
            method: "get",
            url: "<?= site_url('tmstpakethdr/preview'); ?>",
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

            $('#paket_ID').prop('disabled', false).prop('readonly', false);
            $('#paket_Name').prop('disabled', false);
            $('#jumlah_Visit').prop('disabled', false);
            $('#include_Admin').prop('disabled', false);

            $('#include_Admin').val('').trigger('change.select2');

            $('.modal-title').text('Tambah Data');
            $('#action').val('Add');
            $('#submit_button').val('Simpan').html('Simpan').show();
            $('#modalform').modal('show');
        });

        $('#data_form').on('submit', function(event) {
            event.preventDefault();

            $.ajax({
                url: "<?= site_url('tmstpakethdr/action'); ?>",
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
                        $('#paketHdrTable').DataTable().ajax.reload(null, false);
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
            const fields = ['paket_ID', 'paket_Name', 'jumlah_Visit', 'include_Admin'];
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
            const fields = ['paket_ID', 'paket_Name', 'jumlah_Visit', 'include_Admin'];
            fields.forEach(function(field) {
                $('#' + field).removeClass('is-invalid');
                $('.error' + capitalize(field)).html('');
            });
        }

        function capitalize(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

        $(document).on('click', '.view', function() {
            const paket_id = $(this).data('paket_id');

            $.ajax({
                url: "<?= site_url('tmstpakethdr/fetchSingleData'); ?>",
                method: "GET",
                data: { paket_id },
                dataType: "JSON",
                success: function(response) {
                    if (!checkSession(response)) return;

                    $('#data_form')[0].reset();
                    $('.is-invalid').removeClass('is-invalid');
                    $('[class^="error"]').html('');

                    const data = response.data;

                    $('#paket_ID').val(data.paket_ID).prop('disabled', true);
                    $('#paket_Name').val(data.paket_Name).prop('disabled', true);
                    $('#jumlah_Visit').val(data.jumlah_Visit).prop('disabled', true);
                    $('#include_Admin').val(data.include_Admin).prop('disabled', true).trigger('change.select2');

                    $('.modal-title').text('Lihat Data');
                    $('#action').val('View');
                    $('#submit_button').val('Lihat').hide();
                    $('#hidden_id').val(paket_id);
                    $('#modalform').modal('show');
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal mengambil data',
                        text: 'Terjadi kesalahan saat mengambil data paket.'
                    });
                    console.error('AJAX Error:', status, error);
                }
            });
        });

        $(document).on('click', '.edit', function() {
            const paket_id = $(this).data('paket_id');

            $.ajax({
                url: "<?= site_url('tmstpakethdr/fetchSingleData'); ?>",
                method: "GET",
                data: { paket_id },
                dataType: "JSON",
                success: function(response) {
                    if (!checkSession(response)) return;

                    $('#data_form')[0].reset();
                    $('.is-invalid').removeClass('is-invalid');
                    $('[class^="error"]').html('');

                    const data = response.data;

                    $('#paket_ID').val(data.paket_ID).prop('disabled', false).prop('readonly', true);
                    $('#paket_Name').val(data.paket_Name).prop('disabled', false);
                    $('#jumlah_Visit').val(data.jumlah_Visit).prop('disabled', false);
                    $('#include_Admin').val(data.include_Admin).prop('disabled', false).trigger('change.select2');

                    $('.modal-title').text('Ubah Data');
                    $('#action').val('Edit');
                    $('#submit_button').val('Simpan').html('Simpan').show();
                    $('#modalform').modal('show');
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal mengambil data',
                        text: 'Terjadi kesalahan saat mengambil data paket.'
                    });
                    console.error('AJAX Error:', status, error);
                }
            });
        });

        $(document).on('click', '.delete', function() {
            const paket_id = $(this).data('paket_id');

            Swal.fire({
                title: 'Yakin ingin menghapus data?',
                text: 'Data paket akan dihapus secara permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= site_url('tmstpakethdr/delete'); ?>",
                        method: "POST",
                        data: { paket_id },
                        dataType: "JSON",
                        success: function(response) {
                            if (!checkSession(response)) return;

                            if (response.status === 'error') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.message || 'Terjadi kesalahan saat menghapus data.'
                                });
                            } else {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message || 'Data berhasil dihapus.'
                                });
                                $('#paketHdrTable').DataTable().ajax.reload(null, false);
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal menghapus data',
                                text: 'Terjadi kesalahan saat menghubungi server.'
                            });
                            console.error('AJAX Error:', status, error);
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
            $("#filename").val(null);
            $('#viewpreview').html('');
            $('#modalimport').modal('show');
        });

        $('#uploadForm').submit(function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            $.ajax({
                url: '/tmstpakethdr/preview',
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
                    tmstpakethdrpreview();
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

        $("#paketHdrTable").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            dom: 'Bfrtip',
            ajax: {
                url: "<?= base_url('tmstpakethdr/datatables') ?>",
                type: "POST",
                contentType: "application/json",
                data: function(d) {
                    return JSON.stringify(d);
                }
            },
            columnDefs: [
                { orderable: false, targets: [0, 5] },
                { targets: [0, 5], className: 'text-center' }
            ],
            columns: [
                { data: 'rownum',        orderable: false },
                { data: 'paket_ID' },
                { data: 'paket_Name' },
                { data: 'jumlah_Visit' },
                { data: 'include_Admin' },
                { data: 'aksi',          orderable: false }
            ],
            buttons: [
                {
                    text: "Tambah",
                    action: function() {},
                    attr: {
                        id: "add_record",
                        style: "background-color:#56b746; <?= session()->get('flag_insert') === 1 ? '' : 'd-none' ?>",
                        name: "add_record"
                    }
                },
                {
                    extend: "excel",
                    text: "Excel",
                    className: "btn-sm btn-primary <?= session()->get('flag_export') === 1 ? '' : 'd-none' ?>",
                    exportOptions: { columns: [0, 1, 2, 3, 4] }
                },
                {
                    extend: "print",
                    text: "Cetak",
                    className: "btn-sm btn-info <?= session()->get('flag_print') === 1 ? '' : 'd-none' ?>",
                    exportOptions: { columns: [0, 1, 2, 3, 4] }
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
        }).buttons().container().appendTo("#paketHdrTable_wrapper .col-md-6:eq(0)");

        $('#paketHdrTable').on('xhr.dt', function(e, settings, json, xhr) {
            if (json.status === 'session_expired') {
                window.location.href = "<?= base_url('auth/login') ?>";
                alert('Sesi Anda telah berakhir. Silakan login kembali.');
            }
        });

    });
</script>

<?= $this->endSection('script'); ?>