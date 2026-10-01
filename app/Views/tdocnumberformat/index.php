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
                    <h1>Format Nomor Dokumen</h1>
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
                            <div class="card-title"></div>

                            <table id="docNumberFormatTable" class="table table-sm table-bordered table-striped">
                                <thead class="table">
                                    <tr>
                                        <th>No</th>
                                        <th>Tipe Dokumen</th>
                                        <th>Format Pattern</th>
                                        <th>Reset Type</th>
                                        <th>Sequence Name</th>
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
                                            <div class="mb-3 row">
                                                <label for="docType" class="col-sm-3 col-form-label">Tipe Dokumen *</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control form-control-sm" id="docType" name="docType">
                                                    <span class="error invalid-feedback errorDocType"></span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="formatPattern" class="col-sm-3 col-form-label">Format Pattern *</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control form-control-sm" id="formatPattern" name="formatPattern"
                                                        placeholder="Contoh: {BRANCH}/{PREFIX}/{YEAR}/{MONTH}/{DAY}/{SEQ:5}">
                                                    <span class="error invalid-feedback errorFormatPattern"></span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="resetType" class="col-sm-3 col-form-label">Reset Type *</label>
                                                <div class="col-sm-9">
                                                    <?= $cb_reset_type ?>
                                                    <span class="error invalid-feedback errorResetType"></span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="sequenceName" class="col-sm-3 col-form-label">Sequence Name *</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control form-control-sm" id="sequenceName" name="sequenceName"
                                                        placeholder="Contoh: SEQ_INVOICE">
                                                    <span class="error invalid-feedback errorSequenceName"></span>
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

            $('#docType').prop('readonly', false);
            $('#formatPattern').prop('disabled', false);
            $('#resetType').prop('disabled', false);
            $('#sequenceName').prop('readonly', false);

            $('.modal-title').text('Tambah Format Dokumen');
            $('#action').val('Add');
            $('#submit_button').val('Simpan').html('Simpan').show();
            $('#modalform').modal('show');
        });

        $('#data_form').on('submit', function(event) {
            event.preventDefault();

            $.ajax({
                url: "<?= site_url('tdocnumberformat/action'); ?>",
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
                        $('#docNumberFormatTable').DataTable().ajax.reload(null, false);
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
            const fields = ['docType', 'formatPattern', 'resetType', 'sequenceName'];
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
            const fields = ['docType', 'formatPattern', 'resetType', 'sequenceName'];
            fields.forEach(function(field) {
                $('#' + field).removeClass('is-invalid');
                $('.error' + capitalize(field)).html('');
            });
        }

        function capitalize(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

        $(document).on('click', '.view', function() {
            const doc_type = $(this).data('doc_type');

            $.ajax({
                url: "<?= site_url('tdocnumberformat/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    doc_type
                },
                dataType: "JSON",
                success: function(response) {
                    if (!checkSession(response)) return;

                    $('#data_form')[0].reset();
                    $('.is-invalid').removeClass('is-invalid');
                    $('[class^="error"]').html('');

                    const data = response.data;

                    $('#docType').val(data.docType).prop('disabled', true);
                    $('#formatPattern').val(data.formatPattern).prop('disabled', true);
                    $('#resetType').val(data.resetType).prop('disabled', true).trigger('change.select2');
                    $('#sequenceName').val(data.sequenceName).prop('disabled', true);

                    $('.modal-title').text('Lihat Format Dokumen');
                    $('#action').val('View');
                    $('#submit_button').val('Lihat').hide();
                    $('#modalform').modal('show');
                    $('#hidden_id').val(doc_type);
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal mengambil data',
                        text: 'Terjadi kesalahan saat mengambil data format dokumen.'
                    });
                    console.error('AJAX Error:', status, error);
                }
            });
        });

        $(document).on('click', '.edit', function() {
            const doc_type = $(this).data('doc_type');

            $.ajax({
                url: "<?= site_url('tdocnumberformat/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    doc_type
                },
                dataType: "JSON",
                success: function(response) {
                    if (!checkSession(response)) return;

                    $('#data_form')[0].reset();
                    $('.is-invalid').removeClass('is-invalid');
                    $('[class^="error"]').html('');

                    const data = response.data;

                    $('#docType').val(data.docType).prop('readonly', true);
                    $('#formatPattern').val(data.formatPattern).prop('disabled', false);
                    $('#resetType').val(data.resetType).prop('disabled', false).trigger('change.select2');
                    $('#sequenceName').val(data.sequenceName).prop('readonly', true);

                    $('.modal-title').text('Ubah Format Dokumen');
                    $('#action').val('Edit');
                    $('#submit_button').val('Simpan').html('Simpan').show();
                    $('#modalform').modal('show');
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal mengambil data',
                        text: 'Terjadi kesalahan saat mengambil data format dokumen.'
                    });
                    console.error('AJAX Error:', status, error);
                }
            });
        });

        $(document).on('click', '.delete', function() {
            const doc_type = $(this).data('doc_type');

            Swal.fire({
                title: 'Yakin ingin menghapus data?',
                text: 'Format dokumen akan dihapus secara permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= site_url('tdocnumberformat/delete'); ?>",
                        method: "POST",
                        data: {
                            doc_type
                        },
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
                                $('#docNumberFormatTable').DataTable().ajax.reload(null, false);
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
        $("#docNumberFormatTable").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            dom: 'Bfrtip',
            ajax: {
                url: "<?= base_url('tdocnumberformat/datatables') ?>",
                type: "POST",
                contentType: "application/json",
                data: function(d) {
                    return JSON.stringify(d);
                }
            },
            columnDefs: [{
                    orderable: false,
                    targets: [0, 5]
                },
                {
                    targets: [0, 5],
                    className: 'text-center'
                }
            ],
            columns: [{
                    data: 'rownum',
                    orderable: false
                },
                {
                    data: 'docType'
                },
                {
                    data: 'formatPattern'
                },
                {
                    data: 'resetType'
                },
                {
                    data: 'sequenceName'
                },
                {
                    data: 'aksi',
                    orderable: false
                }
            ],
            buttons: [{
                    text: "Tambah",
                    action: function() {},
                    attr: {
                        id: "add_record",
                        style: "background-color:#56b746; <?= session()->get('flag_insert') === 1 ? '' : 'd-none' ?>",
                        name: "add_record",
                    }
                },
                {
                    extend: "excel",
                    text: "Excel",
                    className: "btn-sm btn-primary <?= session()->get('flag_export') === 1 ? '' : 'd-none' ?>",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                },
                {
                    extend: "print",
                    text: "Cetak",
                    className: "btn-sm btn-info <?= session()->get('flag_print') === 1 ? '' : 'd-none' ?>",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
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
        }).buttons().container().appendTo("#docNumberFormatTable_wrapper .col-md-6:eq(0)");

        $('#docNumberFormatTable').on('xhr.dt', function(e, settings, json, xhr) {
            if (json.status === 'session_expired') {
                window.location.href = "<?= base_url('auth/login') ?>";
                alert('Sesi Anda telah berakhir. Silakan login kembali.');
            }
        });
    });
</script>

<?= $this->endSection('script'); ?>