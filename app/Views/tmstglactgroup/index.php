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

                            <table id="glaccountgrupTable" class="table table-sm table-bordered table-striped">
                                <thead class="table">
                                    <tr>
                                        <th>No</th>
                                        <th>Account Group Number</th>
                                        <th>Account Group Id</th>
                                        <th>Account Group Line</th>
                                        <th>Account Group Name</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="modalform" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-md" role="document">
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
                                            <input type="hidden" id="AccNo" name="AccNo">

                                            <div class="form-group row">
                                                <label for="AccGrId" class="col-sm-4 col-form-label">Account Group ID</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm" id="AccGrId" name="AccGrId">
                                                    <span class="invalid-feedback errorAccGrId"></span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="AccGrLine" class="col-sm-4 col-form-label">Account Group Line</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm" id="AccGrLine" name="AccGrLine">
                                                    <span class="invalid-feedback errorAccGrLine"></span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="AccGrName" class="col-sm-4 col-form-label">Account Group Name</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm" id="AccGrName" name="AccGrName">
                                                    <span class="invalid-feedback errorAccGrName"></span>
                                                </div>
                                            </div>

                                            <div class="created-field" style="display:none">
                                                <div class="form-group row">
                                                    <label for="CreatedBy" class="col-sm-4 col-form-label">Created By</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="CreatedBy" name="CreatedBy" readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="CreatedDate" class="col-sm-4 col-form-label">Created Date</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="CreatedDate" name="CreatedDate" readonly>
                                                    </div>
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
                                        <form action="<?= site_url("tmstglactgroup/preview") ?>" id="uploadForm" method="post" enctype="multipart/form-data">
                                            <?= csrf_field(); ?>
                                            <label for="filename">Import Excel File : <a href="<?= site_url("tmstglactgroup/download") ?>"><u>Download Format</u></a></label> <br>
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
            url: "<?= site_url('tmstglactgroup/preview'); ?>",
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

            $('#AccNo').prop('disabled', false);
            $('#AccGrId').prop('disabled', false);
            $('#AccGrLine').prop('disabled', false);
            $('#AccGrName').prop('disabled', false);

            $('.modal-title').text('Tambah Data');
            $('#action').val('Add');
            $('#submit_button').val('Simpan').html('Simpan').show();
            $('#modalform').modal('show');
        });

        $('#data_form').on('submit', function(event) {
            event.preventDefault();

            $.ajax({
                url: "<?= site_url('tmstglactgroup/action'); ?>",
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
                        // glactgroup();
                        $('#modalform').modal('hide');
                        // reload data
                        $('#glaccountgrupTable').DataTable().ajax.reload(null, false); // false = tetap di halaman sekarang

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
            const fields = ['AccGrId', 'AccGrLine', 'AccGrName'];
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
            const fields = ['AccGrId', 'AccGrLine', 'AccGrName'];
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
            const AccNo = $(this).data('accno');

            $.ajax({
                url: "<?= site_url('tmstglactgroup/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    AccNo
                },
                dataType: "JSON",
                success: function(response) {
                    $('#data_form')[0].reset();
                    $('.is-invalid').removeClass('is-invalid');
                    $('[class^="error"]').html('');

                    const data = response.data;

                    $('#AccNo').val(data.AccNo).prop('disabled', true);
                    $('#AccGrId').val(data.AccGrId).prop('disabled', true);
                    $('#AccGrLine').val(data.AccGrLine).prop('disabled', true);
                    $('#AccGrName').val(data.AccGrName).prop('disabled', true);
                    const rawDate = data.CreatedDate;
                    if (rawDate) {
                        const d = new Date(rawDate);
                        const day = String(d.getDate()).padStart(2, '0');
                        const month = String(d.getMonth() + 1).padStart(2, '0');
                        const year = d.getFullYear();
                        const formatted = `${day}/${month}/${year}`;
                        $('#CreatedDate').val(formatted).prop('disabled', true);
                    }
                    $('#CreatedBy').val(data.CreatedBy).prop('disabled', true);

                    $('.created-field').show();

                    $('.modal-title').text('Lihat Data');
                    $('#action').val('View');
                    $('#submit_button').val('Lihat').hide();
                    $('#modalform').modal('show');
                    $('#hidden_id').val(AccNo);
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal melihat data',
                        text: 'Terjadi kesalahan saat mengambil data Account Group.'
                    });
                    console.error('AJAX Error:', status, error);
                }
            });
        });

        $(document).on('click', '.edit', function() {
            const AccNo = $(this).data('accno');

            $.ajax({
                url: "<?= site_url('tmstglactgroup/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    AccNo
                },
                dataType: "JSON",
                success: function(response) {
                    $('#data_form')[0].reset();
                    $('.is-invalid').removeClass('is-invalid');
                    $('[class^="error"]').html('');

                    const data = response.data;

                    $('#AccNo').val(data.AccNo).prop('readonly', true);
                    $('#AccGrId').val(data.AccGrId).prop('readonly', true);
                    $('#AccGrLine').val(data.AccGrLine).prop('disabled', false);
                    $('#AccGrName').val(data.AccGrName).prop('disabled', false);
                    $('#CreatedDate').val(data.CreatedDate).prop('readonly', true);
                    $('#CreatedBy').val(data.CreatedBy).prop('readonly', true);

                    $('.created-field').hide();

                    $('.modal-title').text('Ubah Data');
                    $('#action').val('Edit');
                    $('#submit_button').val('Simpan').html('Simpan').show();
                    $('#modalform').modal('show');
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal mengambil data',
                        text: 'Terjadi kesalahan saat mengambil data account group.'
                    });
                    console.error('AJAX Error:', status, error);
                }
            });
        });

        function confirmDelete({
            accNo,
            url,
            tableId
        }) {
            Swal.fire({
                title: 'Yakin ingin menghapus data?',
                text: 'Data account group akan dihapus secara permanen.',
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
                        AccNo: accNo
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
            const accNo = $(this).data('accno');
            confirmDelete({
                accNo,
                url: "<?= site_url('tmstglactgroup/delete'); ?>",
                tableId: 'glaccountgrupTable'
            });
        });
    });
</script>

<script>
    $(document).on('blur', '#AccGrId, #AccGrLine', function() {
        const accGrId = $('#AccGrId').val();
        const accGrLine = $('#AccGrLine').val();
        const action = $('#action').val();
        const accNo = $('#AccNo').val();

        if (accGrId && accGrLine) {
            $.ajax({
                url: "<?= site_url('tmstglactgroup/checkduplicate'); ?>",
                method: "POST",
                data: {
                    AccGrId: accGrId,
                    AccGrLine: accGrLine,
                    ExcludeAccNo: action === 'Edit' ? accNo : null
                },
                dataType: "JSON",
                success: function(response) {
                    if (response.isDuplicate) {
                        $('#AccGrId').addClass('is-invalid');
                        $('#AccGrLine').addClass('is-invalid');
                        $('.errorAccGrId').html(response.message);
                        $('.errorAccGrLine').html(response.message);

                        $('#submit_button').prop('disabled', true);
                    } else {
                        $('#AccGrId').removeClass('is-invalid');
                        $('#AccGrLine').removeClass('is-invalid');
                        $('.errorAccGrId').html('');
                        $('.errorAccGrLine').html('');

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
            $('.modal-title').text('Import Data GL Account Group');
            $("#filename").val(null);
            $('#viewpreview').html('');
            $('#modalimport').modal('show');
        });

        $('#uploadForm').submit(function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            $.ajax({
                url: '<?= site_url("tmstglactgroup/preview") ?>',
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

        $("#glaccountgrupTable").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            dom: 'Bfrtip',
            ajax: {
                url: "<?= base_url('tmstglactgroup/datatables') ?>",
                type: "POST",
                contentType: "application/json",
                data: function(d) {
                    return JSON.stringify(d);
                }
            },
            columnDefs: [{
                    orderable: false,
                    targets: [0, 4]
                },
                {
                    targets: [0, 4],
                    className: 'text-center'
                }
            ],
            columns: [{
                    data: 'rownum',
                    orderable: false
                },
                {
                    data: 'accNo',
                    visible: false
                },
                {
                    data: 'accGrId'
                },
                {
                    data: 'accGrLine'
                },
                {
                    data: 'accGrName'
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
                // {
                //     extend: "excel",
                //     text: "Excel",
                //     className: "btn-sm btn-primary <?= session()->get('flag_export') === 1 ? '' : 'd-none' ?>",
                //     exportOptions: {
                //         columns: [0, 1, 2, 3, 4, 5, 6]
                //     }
                // },
                // {
                //     extend: "print",
                //     text: "Cetak",
                //     className: "btn-sm btn-info <?= session()->get('flag_print') === 1 ? '' : 'd-none' ?>",
                //     exportOptions: {
                //         columns: [0, 1, 2, 3, 4, 5, 6]
                //     }
                // }, 
                {
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
        }).buttons().container().appendTo("#glaccountgrupTable_wrapper .col-md-6:eq(0)");

        $('#glaccountgrupTable').on('xhr.dt', function(e, settings, json, xhr) {
            if (json.status === 'session_expired') {
                window.location.href = "<?= base_url('auth/login') ?>";
                alert('Sesi Anda telah berakhir. Silakan login kembali.');
            }
        });
    });
</script>



<?= $this->endSection('script'); ?>