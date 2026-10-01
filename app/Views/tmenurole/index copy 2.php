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

                            <form action="<?= site_url("tmenurole/upload") ?>" id="uploadForm" method="post" enctype="multipart/form-data">
                                <label for="filename">Import Excel File : <a href="<?= site_url("tmenurole/download") ?>"><u>Download Format</u></a></label> <br>
                                <input type="file" name="filename" id="filename">
                                <button type="submit" class="btn btn-sm btn-success">Import</button>
                            </form>


                            <div id="result"></div>
                            <br>

                            <span id="viewdata"></span>
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
                                                <?= $cb_role ?>
                                                <?= $cb_menu ?>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="flag_insert" class="col-sm-2 col-form-label"></label>
                                                <div class="col-sm-3">
                                                    <div class="icheck-primary d-inline">
                                                        <input type="checkbox" id="flag_insert" name="flag_insert" checked>
                                                        <label for="flag_insert">Insert</label>
                                                    </div>
                                                    <span class="error invalid-feedback errorFlag_insert">
                                                    </span>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="icheck-primary d-inline">
                                                        <input type="checkbox" id="flag_update" name="flag_update" checked>
                                                        <label for="flag_update">Update</label>
                                                    </div>
                                                    <span class="error invalid-feedback errorFlag_update">
                                                    </span>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="icheck-primary d-inline">
                                                        <input type="checkbox" id="flag_delete" name="flag_delete" checked>
                                                        <label for="flag_delete">Delete</label>
                                                    </div>
                                                    <span class="error invalid-feedback errorFlag_delete">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="flag_view" class="col-sm-2 col-form-label"></label>
                                                <div class="col-sm-3">
                                                    <div class="icheck-primary d-inline">
                                                        <input type="checkbox" id="flag_view" name="flag_view" checked>
                                                        <label for="flag_view">View</label>
                                                    </div>
                                                    <span class="error invalid-feedback errorFlag_view">
                                                    </span>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="icheck-primary d-inline">
                                                        <input type="checkbox" id="flag_print" name="flag_print" checked>
                                                        <label for="flag_print">Print</label>
                                                    </div>
                                                    <span class="error invalid-feedback errorFlag_print">
                                                    </span>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="icheck-primary d-inline">
                                                        <input type="checkbox" id="flag_export" name="flag_export" checked>
                                                        <label for="flag_export">Export</label>
                                                    </div>
                                                    <span class="error invalid-feedback errorFlag_export">
                                                    </span>
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
    function tmenurole() {
        $.ajax({
            method: "get",
            url: "<?= site_url('tmenurole/fetchAll'); ?>",
            success: function(data) {
                $('#viewdata').html(data);
            }
        });
    }
    $(document).ready(function() {
        tmenurole()

        //datatable server side
        // $('#sample_table').DataTable({
        //     "order": [],
        //     "serverSide": true,
        //     "ajax": {
        //         url: "<?php echo base_url("/ajax_crud/fetchAll"); ?>",
        //         type: "POST",
        //     }
        // });

        $(document).on('click', '#add_record', function() {
            //set input
            $('#role_cd').removeAttr('disabled', '');
            $('#menu_cd').removeAttr('disabled', '');
            $('#flag_insert').removeAttr('disabled', '');
            $('#flag_update').removeAttr('disabled', '');
            $('#flag_delete').removeAttr('disabled', '');
            $('#flag_view').removeAttr('disabled', '');
            $('#flag_print').removeAttr('disabled', '');
            $('#flag_export').removeAttr('disabled', '');

            // $('#nama').removeAttr('readonly');
            // $('#value').removeAttr('readonly');
            $('#flag_insert').removeAttr('checked');
            $('#flag_update').removeAttr('checked');
            $('#flag_delete').removeAttr('checked');
            $('#flag_view').removeAttr('checked');
            $('#flag_print').removeAttr('checked');
            $('#flag_export').removeAttr('checked');

            $('#data_form')[0].reset();

            //set error validation
            $('#role_cd').removeClass('is-invalid');
            $('#menu_cd').removeClass('is-invalid');
            $('#flag_insert').removeClass('is-invalid');
            $('#flag_update').removeClass('is-invalid');
            $('#flag_delete').removeClass('is-invalid');
            $('#flag_view').removeClass('is-invalid');
            $('#flag_print').removeClass('is-invalid');
            $('#flag_export').removeClass('is-invalid');
            $('.errorRole_cd').html('');
            $('.errorMenu_cd').html('');
            $('.errorFlag_insert').html('');
            $('.errorFlag_update').html('');
            $('.errorFlag_delete').html('');
            $('.errorFlag_view').html('');
            $('.errorFlag_print').html('');
            $('.errorFlag_export').html('');

            //set selected data select2
            $('#menu_cd').val(' ');
            $('#menu_cd').trigger('change');
            $('#role_cd').val(' ');
            $('#role_cd').trigger('change');

            //set modal & form
            $('.modal-title').text('Tambah Data');
            $('#action').val('Add');
            $('#submit_button').show();
            $('#submit_button').val('Simpan');
            $('#submit_button').html('Simpan');
            $('#modalform').modal('show');


        });

        $('#data_form').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "<?= site_url('tmenurole/action'); ?>",
                method: "POST",
                data: $(this).serialize(),
                // data: {
                //     nama: nama,
                //     value: value,
                //     desc: desc,
                //     action: action
                // },
                dataType: "JSON",
                beforeSend: function() {
                    $('#submit_button').prop('disabled', true);
                    $('#submit_button').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('#submit_button').prop('disabled', false);
                    $('#submit_button').html($('#submit_button').val());
                },
                success: function(response) {

                    if (response.error) {
                        if (response.error.role_cd) {
                            $('#role_cd').addClass('is-invalid');
                            $('.errorRole_cd').html(response.error.role_cd);
                        } else {
                            $('#role_cd').removeClass('is-invalid');
                            $('.errorRole_cd').html('');
                        }
                        if (response.error.menu_cd) {
                            $('#menu_cd').addClass('is-invalid');
                            $('.errorMenu_cd').html(response.error.menu_cd);
                        } else {
                            $('#menu_cd').removeClass('is-invalid');
                            $('.errorMenu_cd').html('');
                        }

                    } else {
                        //sweet alert
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                            //footer: '<a href="">Why do I have this issue?</a>'
                        });

                        //set error validation
                        // $('#menu_cd').removeClass('is-invalid');
                        // $('#role_cd').removeClass('is-invalid');
                        // $('#menu_cd').val('');
                        // $('#role_cd').val('');
                        $('#flag_insert').removeAttr('checked');
                        $('#flag_update').removeAttr('checked');
                        $('#flag_delete').removeAttr('checked');
                        $('#flag_view').removeAttr('checked');
                        $('#flag_print').removeAttr('checked');
                        $('#flag_export').removeAttr('checked');

                        tmenurole();
                        $('#modalform').modal('hide');
                    }
                },
            })
        });

        $(document).on('click', '.view', function() {
            var menu_cd = $(this).data('menu_cd');
            var role_cd = $(this).data('role_cd');

            $.ajax({
                url: "<?= site_url('tmenurole/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    menu_cd: menu_cd,
                    role_cd: role_cd
                },
                dataType: "JSON",
                success: function(response) {
                    //set input
                    $('#role_cd').attr('disabled', '');
                    $('#menu_cd').attr('disabled', '');
                    $('#flag_insert').attr('disabled', '');
                    $('#flag_update').attr('disabled', '');
                    $('#flag_delete').attr('disabled', '');
                    $('#flag_view').attr('disabled', '');
                    $('#flag_print').attr('disabled', '');
                    $('#flag_export').attr('disabled', '');

                    // $('#role_cd').attr('readonly', '');
                    // $('#menu_cd').attr('readonly', '');
                    $('#flag_insert').removeAttr('checked');
                    $('#flag_update').removeAttr('checked');
                    $('#flag_delete').removeAttr('checked');
                    $('#flag_view').removeAttr('checked');
                    $('#flag_print').removeAttr('checked');
                    $('#flag_export').removeAttr('checked');

                    $('#data_form')[0].reset();

                    //set data from response record
                    $('#menu_cd').val(response.data.menu_cd);
                    $('#role_cd').val(response.data.role_cd);
                    (response.data.flag_insert === 1 ? $('#flag_insert').attr('checked', 'checked') : $('#flag_insert').removeAttr('checked'));
                    (response.data.flag_update === 1 ? $('#flag_update').attr('checked', 'checked') : $('#flag_update').removeAttr('checked'));
                    (response.data.flag_delete === 1 ? $('#flag_delete').attr('checked', 'checked') : $('#flag_delete').removeAttr('checked'));
                    (response.data.flag_view === 1 ? $('#flag_view').attr('checked', 'checked') : $('#flag_view').removeAttr('checked'));
                    (response.data.flag_print === 1 ? $('#flag_print').attr('checked', 'checked') : $('#flag_print').removeAttr('checked'));
                    (response.data.flag_export === 1 ? $('#flag_export').attr('checked', 'checked') : $('#flag_export').removeAttr('checked'));

                    //set error validation
                    $('#menu_cd').removeClass('is-invalid');
                    $('#role_cd').removeClass('is-invalid');
                    $('.errorMenu_cd').html('');
                    $('.errorRole_cd').html('');

                    //set selected data
                    $('#menu_cd').val(response.data.menu_cd);
                    $('#menu_cd').trigger('change');
                    $('#role_cd').val(response.data.role_cd);
                    $('#role_cd').trigger('change');

                    //set modal & form
                    $('.modal-title').text('Lihat Data');
                    $('#action').val('View');
                    $('#submit_button').hide();
                    $('#submit_button').val('Lihat');
                    $('#submit_button').html('Lihat');
                    $('#modalform').modal('show');
                    // $('#hidden_id').val(id);
                }
            })
        });

        $(document).on('click', '.edit', function() {
            var menu_cd = $(this).data('menu_cd');
            var role_cd = $(this).data('role_cd');

            $.ajax({
                url: "<?= site_url('tmenurole/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    menu_cd: menu_cd,
                    role_cd: role_cd
                },
                dataType: "JSON",
                success: function(response) {
                    //set input
                    $('#role_cd').removeAttr('disabled', '');
                    $('#menu_cd').removeAttr('disabled', '');
                    $('#flag_insert').removeAttr('disabled', '');
                    $('#flag_update').removeAttr('disabled', '');
                    $('#flag_delete').removeAttr('disabled', '');
                    $('#flag_view').removeAttr('disabled', '');
                    $('#flag_print').removeAttr('disabled', '');
                    $('#flag_export').removeAttr('disabled', '');

                    // $('#role_cd').attr('readonly', '');
                    // $('#menu_cd').attr('readonly', '');
                    $('#flag_insert').removeAttr('checked');
                    $('#flag_update').removeAttr('checked');
                    $('#flag_delete').removeAttr('checked');
                    $('#flag_view').removeAttr('checked');
                    $('#flag_print').removeAttr('checked');
                    $('#flag_export').removeAttr('checked');

                    $('#data_form')[0].reset();

                    //set data from response record
                    $('#menu_cd').val(response.data.menu_cd);
                    $('#role_cd').val(response.data.role_cd);
                    (response.data.flag_insert === 1 ? $('#flag_insert').attr('checked', 'checked') : $('#flag_insert').removeAttr('checked'));
                    (response.data.flag_update === 1 ? $('#flag_update').attr('checked', 'checked') : $('#flag_update').removeAttr('checked'));
                    (response.data.flag_delete === 1 ? $('#flag_delete').attr('checked', 'checked') : $('#flag_delete').removeAttr('checked'));
                    (response.data.flag_view === 1 ? $('#flag_view').attr('checked', 'checked') : $('#flag_view').removeAttr('checked'));
                    (response.data.flag_print === 1 ? $('#flag_print').attr('checked', 'checked') : $('#flag_print').removeAttr('checked'));
                    (response.data.flag_export === 1 ? $('#flag_export').attr('checked', 'checked') : $('#flag_export').removeAttr('checked'));

                    //set error validation
                    $('#menu_cd').removeClass('is-invalid');
                    $('#role_cd').removeClass('is-invalid');
                    $('.errorMenu_cd').html('');
                    $('.errorRole_cd').html('');

                    //set selected data
                    $('#menu_cd').val(response.data.menu_cd);
                    $('#menu_cd').trigger('change');
                    $('#role_cd').val(response.data.role_cd);
                    $('#role_cd').trigger('change');

                    //set modal & form
                    $('.modal-title').text('Ubah Data');
                    $('#action').val('Edit');
                    $('#submit_button').show();
                    $('#submit_button').val('Simpan');
                    $('#submit_button').html('Simpan');
                    $('#modalform').modal('show');
                    // $('#hidden_id').val(id);
                }
            })
        });

        $(document).on('click', '.delete', function() {
            var menu_cd = $(this).data('menu_cd');
            var role_cd = $(this).data('role_cd');
            if (confirm("Are you sure you want to remove it?")) {
                $.ajax({
                    url: "<?= site_url('tmenurole/delete'); ?>",
                    method: "POST",
                    data: {
                        menu_cd: menu_cd,
                        role_cd: role_cd
                    },
                    dataType: "JSON",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                            //footer: '<a href="">Why do I have this issue?</a>'
                        });
                        tmenurole();
                        setTimeout(function() {
                            $('#message').html('');
                        }, 5000);
                    }
                })
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#uploadForm').submit(function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            $.ajax({
                url: '/tmenurole/upload',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.success,
                        //footer: '<a href="">Why do I have this issue?</a>'
                    });
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                }
            });
        });


        // preview excel data before import
        // $('#uploadForm').submit(function(e) {
        //     e.preventDefault();

        //     const formData = new FormData(this);

        //     $.ajax({
        //         url: '/tmenurole/upload',
        //         type: 'POST',
        //         data: formData,
        //         processData: false,
        //         contentType: false,
        //         success: function(data) {
        //             // Tampilkan data dalam bentuk tabel
        //             const table = $('<table class="table">');
        //             data.forEach(row => {
        //                 const tr = $('<tr>');
        //                 row.forEach(cell => {
        //                     const td = $('<td>').text(cell);
        //                     tr.append(td);
        //                 });
        //                 table.append(tr);
        //             });
        //             $('#result').html(table);
        //         },
        //         error: function(xhr) {
        //             console.error('Error:', xhr.responseText);
        //         }
        //     });
        // });
    });
</script>



<?= $this->endSection('script'); ?>