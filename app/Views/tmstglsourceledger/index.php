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

                            <table id="glsourceledgerTable" class="table table-sm table-bordered table-striped">
                                <thead class="table">
                                    <tr>
                                        <th>No</th>
                                        <th>Source Id</th>
                                        <th>Source Ledger</th>
                                        <th>Source Type</th>
                                        <th>Source Description</th>
                                        <th>Audit Date</th>
                                        <th>Audit Time</th>
                                        <th>Audit User</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="modalform" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalTitle"></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <form method="post" id="data_form" autocomplete="off">
                                        <?= csrf_field(); ?>

                                        <div class="modal-body">
                                            <input type="hidden" id="SrceId" name="SrceId">
                                            <div class="form-group row">
                                                <label for="SrceLedger" class="col-sm-3 col-form-label">Source Ledger</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control form-control-sm" id="SrceLedger" name="SrceLedger">
                                                    <span class="invalid-feedback errorSrceLedger"></span>
                                                </div>

                                                <label for="SrceType" class="col-sm-3 col-form-label">Source Type</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control form-control-sm" id="SrceType" name="SrceType">
                                                    <span class="invalid-feedback errorSrceType"></span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="SrceDesc" class="col-sm-3 col-form-label">Source Description</label>
                                                <div class="col-sm-9">
                                                    <textarea
                                                        class="form-control form-control-sm"
                                                        id="SrceDesc"
                                                        name="SrceDesc"
                                                        rows="3"
                                                        style="resize: vertical;"></textarea>
                                                    <span class="invalid-feedback errorSrceDesc"></span>
                                                </div>
                                            </div>

                                            <!-- Audit -->
                                            <div class="form-group row audit-field" style="display:none">
                                                <label for="AudtUser" class="col-sm-3 col-form-label">Audit User</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control form-control-sm" id="AudtUser" name="AudtUser">
                                                </div>

                                                <label for="AudtDate" class="col-sm-3 col-form-label">Audit Date</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control form-control-sm" id="AudtDate" name="AudtDate">
                                                </div>
                                            </div>

                                            <div class="form-group row audit-field2" style="display:none">
                                                <label for="AudtTime" class="col-sm-3 col-form-label">Audit Time</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control form-control-sm" id="AudtTime" name="AudtTime">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="modal-footer">
                                            <input type="hidden" id="hidden_id" name="hidden_id">
                                            <input type="hidden" id="action" name="action" value="Add">

                                            <button type="submit" id="submit_button" class="btn btn-sm btn-primary">
                                                Simpan
                                            </button>
                                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                                                Tutup
                                            </button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>


                        <!-- Modal Import -->
                        <div class="modal fade" id="modalimport" tabindex="" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLabel"></h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="<?= site_url("tmstglsourceledger/preview") ?>" id="uploadForm" method="post" enctype="multipart/form-data">
                                            <?= csrf_field(); ?>
                                            <label for="filename">Import Excel File : <a href="<?= site_url("tmstglsourceledger/download") ?>"><u>Download Format</u></a></label> <br>
                                            <div class="mb-3 row">
                                                <div class="col-sm-7">
                                                    <input type="file" name="filename" id="filename" class="form-control form-control-sm">
                                                </div>
                                                <input type="hidden" name="hide" value="gas">
                                                <div class="col-sm-3">
                                                    <select class="form-control form-control-sm" name="pas">
                                                        <option value="insert">Insert</option>
                                                        <!-- <option value="update">Update</option> -->
                                                    </select>
                                                </div>
                                                <div class="col-sm-2">
                                                    <button type="submit" name="preview" class="btn btn-sm btn-primary form-control form-control-sm" id="preview">Preview</button>
                                                </div>
                                            </div>
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
    function tmstdiagnosapreview() {
        $.ajax({
            method: "get",
            url: "<?= site_url('tmstglsourceledger/preview'); ?>",
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

            $('#SrceId').prop('disabled', false);
            $('#SrceLedger').prop('disabled', false);
            $('#SrceType').prop('disabled', false);
            $('#SrceDesc').prop('disabled', false);

            $('.modal-title').text('Tambah Data');
            $('#action').val('Add');
            $('#submit_button').val('Simpan').html('Simpan').show();
            $('#modalform').modal('show');
        });

        $('#data_form').on('submit', function(event) {
            event.preventDefault();

            $.ajax({
                url: "<?= site_url('tmstglsourceledger/action'); ?>",
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

                    // Jika response berisi error validasi
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
                        // glsourceledger();
                        $('#modalform').modal('hide');
                        // reload data
                        $('#glsourceledgerTable').DataTable().ajax.reload(null, false); // false = tetap di halaman sekarang

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

        // 🔧 Fungsi bantu untuk menampilkan error validasi
        function showValidationErrors(errors) {
            const fields = ['SrceLedger', 'SrceType', 'SrceDesc'];
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

        // 🔧 Fungsi bantu untuk reset validasi
        function clearFormValidation() {
            const fields = ['SrceLedger', 'SrceType', 'SrceDesc'];
            fields.forEach(function(field) {
                $('#' + field).removeClass('is-invalid');
                $('.error' + capitalize(field)).html('');
            });
        }

        // 🔧 Capitalize helper
        function capitalize(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

        /*--------------------------------------------------*/

        $(document).on('click', '.view', function() {
            const SrceId = $(this).data('srceid');

            $.ajax({
                url: "<?= site_url('tmstglsourceledger/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    SrceId
                },
                dataType: "JSON",
                success: function(response) {
                    $('#data_form')[0].reset();
                    $('.is-invalid').removeClass('is-invalid');
                    $('[class^="error"]').html('');

                    const data = response.data;

                    $('#SrceId').val(data.SrceId).prop('disabled', true);
                    $('#SrceLedger').val(data.SrceLedger).prop('disabled', true);
                    $('#SrceType').val(data.SrceType).prop('disabled', true);
                    $('#SrceDesc').val(data.SrceDesc).prop('disabled', true);
                    const rawDate = data.AudtDate;
                    if (rawDate) {
                        const d = new Date(rawDate);
                        const day = String(d.getDate()).padStart(2, '0');
                        const month = String(d.getMonth() + 1).padStart(2, '0');
                        const year = d.getFullYear();
                        const formatted = `${day}/${month}/${year}`;
                        $('#AudtDate').val(formatted).prop('disabled', true);
                    }
                    $('#AudtTime').val(data.AudtTime).prop('disabled', true);
                    $('#AudtUser').val(data.AudtUser).prop('disabled', true);

                    $('.audit-field').show();
                    $('.audit-field2').show();

                    $('.modal-title').text('Lihat Data');
                    $('#action').val('View');
                    $('#submit_button').val('Lihat').hide();
                    $('#modalform').modal('show');
                    $('#hidden_id').val(SrceId);
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal melihat data',
                        text: 'Terjadi kesalahan saat mengambil data Source Ledger.'
                    });
                    console.error('AJAX Error:', status, error);
                }
            });
        });

        $(document).on('click', '.edit', function() {
            const SrceId = $(this).data('srceid');

            $.ajax({
                url: "<?= site_url('tmstglsourceledger/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    SrceId
                },
                dataType: "JSON",
                success: function(response) {
                    $('#data_form')[0].reset();
                    $('.is-invalid').removeClass('is-invalid');
                    $('[class^="error"]').html('');

                    const data = response.data;

                    $('#SrceId').val(data.SrceId).prop('readonly', true);
                    $('#SrceLedger').val(data.SrceLedger);
                    $('#SrceType').val(data.SrceType);
                    $('#SrceDesc').val(data.SrceDesc);
                    $('#AudtDate').val(data.AudtDate).prop('readonly', true);
                    $('#AudtTime').val(data.AudtTime).prop('readonly', true);
                    $('#AudtUser').val(data.AudtUser).prop('readonly', true);

                    $('.audit-field').hide();
                    $('.audit-field2').hide();

                    $('.modal-title').text('Ubah Data');
                    $('#action').val('Edit');
                    $('#submit_button').val('Simpan').html('Simpan').show();
                    $('#modalform').modal('show');
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal mengambil data',
                        text: 'Terjadi kesalahan saat mengambil data source ledger.'
                    });
                    console.error('AJAX Error:', status, error);
                }
            });
        });

        function confirmDelete({
            srceId,
            url,
            tableId
        }) {
            Swal.fire({
                title: 'Yakin ingin menghapus data?',
                text: 'Data source ledger akan dihapus secara permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (!result.isConfirmed) return;

                $.ajax({
                    url,
                    method: 'POST',
                    data: {
                        SrceId: srceId
                    },
                    dataType: 'JSON',
                    success: function(res) {
                        if (res.status === 'success') {
                            Swal.fire('Berhasil', res.message || 'Data berhasil dihapus.', 'success');
                            $(`#${tableId}`).DataTable().ajax.reload(null, false);
                        } else {
                            Swal.fire('Gagal', res.message || 'Terjadi kesalahan saat menghapus data.', 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Gagal menghapus data', 'Terjadi kesalahan saat menghubungi server.', 'error');
                        console.error('AJAX Error:', status, error);
                    }
                });
            });
        }

        $(document).on('click', '.delete', function() {
            const srceId = $(this).data('srceid');
            confirmDelete({
                srceId,
                url: "<?= site_url('tmstglsourceledger/delete'); ?>",
                tableId: 'glsourceledgerTable'
            });
        });
    });
</script>

<script>
    $(document).on('blur', '#SrceLedger, #SrceType', function() {
        const srceLedger = $('#SrceLedger').val();
        const srceType = $('#SrceType').val();
        const action = $('#action').val();
        const srceId = $('#SrceId').val();

        if (srceLedger && srceType) {
            $.ajax({
                url: "<?= site_url('tmstglsourceledger/checkduplicate'); ?>",
                method: "POST",
                data: {
                    SrceLedger: srceLedger,
                    SrceType: srceType,
                    ExcludeSrceId: action === 'Edit' ? srceId : null
                },
                dataType: "JSON",
                success: function(response) {
                    if (response.isDuplicate) {
                        $('#SrceLedger').addClass('is-invalid');
                        $('#SrceType').addClass('is-invalid');
                        $('.errorSrceLedger').html(response.message);
                        $('.errorSrceType').html(response.message);

                        $('#submit_button').prop('disabled', true);
                    } else {
                        $('#SrceLedger').removeClass('is-invalid');
                        $('#SrceType').removeClass('is-invalid');
                        $('.errorSrceLedger').html('');
                        $('.errorSrceType').html('');

                        $('#submit_button').prop('disabled', false);
                    }
                }
            });
        }
    });
</script>

<script>
    $(document).ready(function() {

        $(document).on('click', '#import', function() {
            //set modal & form
            $('.modal-title').text('Import Data GL Source Ledger');
            $("#filename").val(null);
            $('#viewpreview').html('');
            $('#modalimport').modal('show');
        });

        $('#uploadForm').submit(function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            $.ajax({
                url: '<?= site_url("tmstglsourceledger/preview") ?>',
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
                success: function(data) {
                    $('#viewpreview').html(data);
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

        $("#glsourceledgerTable").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            dom: 'Bfrtip',
            ajax: {
                url: "<?= base_url('tmstglsourceledger/datatables') ?>",
                type: "POST",
                contentType: "application/json",
                data: function(d) {
                    return JSON.stringify(d);
                }
            },
            columnDefs: [{
                    orderable: false,
                    targets: [0, 8]
                },
                {
                    targets: [0, 8],
                    className: 'text-center'
                }
            ],
            columns: [{
                    data: 'rownum',
                    orderable: false
                },
                {
                    data: 'srceId',
                    visible: false
                },
                {
                    data: 'srceLedger'
                },
                {
                    data: 'srceType'
                },
                {
                    data: 'srceDesc'
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
                    data: 'audtTime'
                },
                {
                    data: 'audtUser'
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
                    }

                },
                {
                    extend: "excel",
                    text: "Excel",
                    className: "btn-sm btn-primary <?= session()->get('flag_export') === 1 ? '' : 'd-none' ?>",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: "print",
                    text: "Cetak",
                    className: "btn-sm btn-info <?= session()->get('flag_print') === 1 ? '' : 'd-none' ?>",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                }, {
                    text: "Import",
                    action: function() {
                        // Import logic
                    },
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
        }).buttons().container().appendTo("#glsourceledgerTable_wrapper .col-md-6:eq(0)");

        $('#glsourceledgerTable').on('xhr.dt', function(e, settings, json, xhr) {
            if (json.status === 'session_expired') {
                window.location.href = "<?= base_url('auth/login') ?>";
                alert('Sesi Anda telah berakhir. Silakan login kembali.');
            }
        });
    });
</script>



<?= $this->endSection('script'); ?>