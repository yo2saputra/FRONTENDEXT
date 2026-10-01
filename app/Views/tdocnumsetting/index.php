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
                            <!-- <div id="result"></div> -->
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
                                                <label for="name" class="col-sm-2 col-form-label">Name</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="name" name="name">
                                                    <span class="error invalid-feedback errorName">
                                                    </span>
                                                </div>
                                                <label for="prefix" class="col-sm-2 col-form-label">Prefix</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="prefix" name="prefix">
                                                    <span class="error invalid-feedback errorPrefix">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="docnum_description" class="col-sm-2 col-form-label">Description</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control form-control-sm" id="docnum_description" name="docnum_description">
                                                    <span class="error invalid-feedback errorDocnum_description">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="startwith" class="col-sm-2 col-form-label">Start</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="startwith" name="startwith">
                                                    <span class="error invalid-feedback errorStartwith">
                                                    </span>
                                                </div>
                                                <label for="increment" class="col-sm-2 col-form-label">Increment</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="increment" name="increment">
                                                    <span class="error invalid-feedback errorIncrement">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="minvalue" class="col-sm-2 col-form-label">Min Value</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="minvalue" name="minvalue">
                                                    <span class="error invalid-feedback errorMinvalue">
                                                    </span>
                                                </div>
                                                <label for="maxvalue" class="col-sm-2 col-form-label">Max Value</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="maxvalue" name="maxvalue">
                                                    <span class="error invalid-feedback errorMaxvalue">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="leadingprefix" class="col-sm-2 col-form-label"></label>
                                                <div class="col-sm-3">
                                                    <div class="icheck-primary d-inline">
                                                        <input type="checkbox" id="leadingprefix" name="leadingprefix" checked>
                                                        <label for="leadingprefix">Leading Prefix</label>
                                                    </div>
                                                    <span class="error invalid-feedback errorLeadingprefix">
                                                    </span>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="icheck-primary d-inline">
                                                        <input type="checkbox" id="leadingzero" name="leadingzero" checked>
                                                        <label for="leadingzero">Leading Zero</label>
                                                    </div>
                                                    <span class="error invalid-feedback errorLeadingzero">
                                                    </span>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="icheck-primary d-inline">
                                                        <input type="checkbox" id="leadingmonth" name="leadingmonth" checked>
                                                        <label for="leadingmonth">Leading Month</label>
                                                    </div>
                                                    <span class="error invalid-feedback errorLeadingmonth">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="leadingyear" class="col-sm-2 col-form-label"></label>
                                                <div class="col-sm-3">
                                                    <div class="icheck-primary d-inline">
                                                        <input type="checkbox" id="leadingyear" name="leadingyear" checked>
                                                        <label for="leadingyear">Leading Year</label>
                                                    </div>
                                                    <span class="error invalid-feedback errorLeadingyear">
                                                    </span>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="icheck-primary d-inline">
                                                        <input type="checkbox" id="restart_month" name="restart_month" checked>
                                                        <label for="restart_month">Restart Month</label>
                                                    </div>
                                                    <span class="error invalid-feedback errorRestart_month">
                                                    </span>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="icheck-primary d-inline">
                                                        <input type="checkbox" id="restart_year" name="restart_year" checked>
                                                        <label for="restart_year">Restart Year</label>
                                                    </div>
                                                    <span class="error invalid-feedback errorRestart_year">
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
                                        <form action="<?= site_url("tdocnumsetting/preview") ?>" id="uploadForm" method="post" enctype="multipart/form-data">
                                            <?= csrf_field(); ?>
                                            <label for="filename">Import Excel File : <a href="<?= site_url("tdocnumsetting/download") ?>"><u>Download Format</u></a></label> <br>
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
            url: "<?= site_url('tdocnumsetting/fetchAll'); ?>",
            success: function(data) {
                $('#viewdata').html(data);
            }
        });
    }

    function tmenurolepreview() {
        $.ajax({
            method: "get",
            url: "<?= site_url('tdocnumsetting/preview'); ?>",
            success: function(data) {
                $('#viewpreview').html(data);
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
            $('#prefix').removeAttr('readonly', '');
            $('#name').removeAttr('readonly', '');
            $('#docnum_description').removeAttr('readonly', '');
            $('#startwith').removeAttr('readonly', '');
            $('#increment').removeAttr('readonly', '');
            $('#minvalue').removeAttr('readonly', '');
            $('#maxvalue').removeAttr('readonly', '');
            $('#leadingprefix').removeAttr('disabled', '');
            $('#leadingzero').removeAttr('disabled', '');
            $('#leadingmonth').removeAttr('disabled', '');
            $('#leadingyear').removeAttr('disabled', '');
            $('#restart_month').removeAttr('disabled', '');
            $('#restart_year').removeAttr('disabled', '');

            // $('#nama').removeAttr('readonly');
            // $('#value').removeAttr('readonly');
            $('#leadingprefix').removeAttr('checked');
            $('#leadingzero').removeAttr('checked');
            $('#leadingmonth').removeAttr('checked');
            $('#leadingyear').removeAttr('checked');
            $('#restart_month').removeAttr('checked');
            $('#restart_year').removeAttr('checked');

            $('#data_form')[0].reset();

            //set error validation
            $('#role_cd').removeClass('is-invalid');
            $('#name').removeClass('is-invalid');
            $('#leadingprefix').removeClass('is-invalid');
            $('#leadingzero').removeClass('is-invalid');
            $('#leadingmonth').removeClass('is-invalid');
            $('#leadingyear').removeClass('is-invalid');
            $('#restart_month').removeClass('is-invalid');
            $('#restart_year').removeClass('is-invalid');
            $('.errorRole_cd').html('');
            $('.errorMenu_cd').html('');
            $('.errorFlag_insert').html('');
            $('.errorFlag_update').html('');
            $('.errorFlag_delete').html('');
            $('.errorFlag_view').html('');
            $('.errorFlag_print').html('');
            $('.errorFlag_export').html('');

            //set selected data select2
            // $('#name').val(' ');
            // $('#name').trigger('change');
            // $('#role_cd').val(' ');
            // $('#role_cd').trigger('change');

            //set modal & form
            $('.modal-title').text('Tambah Data');
            $('#action').val('Add');
            $('#submit_button').show();
            $('#submit_button').val('Simpan');
            $('#submit_button').html('Simpan');
            $('#modalform').modal('show');


        });

        $(document).on('click', '#import', function() {

            //set modal & form
            $('.modal-title').text('Import Data');
            $("#filename").val(null);
            $('#viewpreview').html('');
            $('#modalimport').modal('show');


        });

        $('#data_form').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "<?= site_url('tdocnumsetting/action'); ?>",
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
                        if (response.error.name) {
                            $('#name').addClass('is-invalid');
                            $('.errorMenu_cd').html(response.error.name);
                        } else {
                            $('#name').removeClass('is-invalid');
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
                        // $('#name').removeClass('is-invalid');
                        // $('#role_cd').removeClass('is-invalid');
                        // $('#name').val('');
                        // $('#role_cd').val('');
                        $('#leadingprefix').removeAttr('checked');
                        $('#leadingzero').removeAttr('checked');
                        $('#leadingmonth').removeAttr('checked');
                        $('#leadingyear').removeAttr('checked');
                        $('#restart_month').removeAttr('checked');
                        $('#restart_year').removeAttr('checked');

                        tmenurole();
                        $('#modalform').modal('hide');
                    }
                },
            })
        });

        $(document).on('click', '.view', function() {
            var name = $(this).data('name');

            $.ajax({
                url: "<?= site_url('tdocnumsetting/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    name: name
                },
                dataType: "JSON",
                success: function(response) {
                    //set input
                    $('#name').attr('readonly', '');
                    $('#prefix').attr('readonly', '');
                    $('#docnum_description').attr('readonly', '');
                    $('#startwith').attr('readonly', '');
                    $('#increment').attr('readonly', '');
                    $('#minvalue').attr('readonly', '');
                    $('#maxvalue').attr('readonly', '');
                    $('#leadingprefix').attr('disabled', '');
                    $('#leadingzero').attr('disabled', '');
                    $('#leadingmonth').attr('disabled', '');
                    $('#leadingyear').attr('disabled', '');
                    $('#restart_month').attr('disabled', '');
                    $('#restart_year').attr('disabled', '');

                    // $('#role_cd').attr('readonly', '');
                    // $('#name').attr('readonly', '');
                    $('#leadingprefix').removeAttr('checked');
                    $('#leadingzero').removeAttr('checked');
                    $('#leadingmonth').removeAttr('checked');
                    $('#leadingyear').removeAttr('checked');
                    $('#restart_month').removeAttr('checked');
                    $('#restart_year').removeAttr('checked');

                    $('#data_form')[0].reset();

                    //set data from response record
                    $('#name').val(response.data.name);
                    $('#prefix').val(response.data.prefix);
                    $('#docnum_description').val(response.data.docnum_description);
                    $('#startwith').val(response.data.start_value);
                    $('#increment').val(response.data.increment);
                    $('#minvalue').val(response.data.minimum_value);
                    $('#maxvalue').val(response.data.maximum_value);
                    (response.data.leadingprefix === 1 ? $('#leadingprefix').attr('checked', 'checked') : $('#leadingprefix').removeAttr('checked'));
                    (response.data.leadingzero === 1 ? $('#leadingzero').attr('checked', 'checked') : $('#leadingzero').removeAttr('checked'));
                    (response.data.leadingmonth === 1 ? $('#leadingmonth').attr('checked', 'checked') : $('#leadingmonth').removeAttr('checked'));
                    (response.data.leadingyear === 1 ? $('#leadingyear').attr('checked', 'checked') : $('#leadingyear').removeAttr('checked'));
                    (response.data.restart_month === 1 ? $('#restart_month').attr('checked', 'checked') : $('#restart_month').removeAttr('checked'));
                    (response.data.restart_year === 1 ? $('#restart_year').attr('checked', 'checked') : $('#restart_year').removeAttr('checked'));

                    //set error validation
                    $('#name').removeClass('is-invalid');
                    $('#role_cd').removeClass('is-invalid');
                    $('.errorMenu_cd').html('');
                    $('.errorRole_cd').html('');

                    //set selected data
                    // $('#name').val(response.data.name);
                    // $('#name').trigger('change');
                    // $('#role_cd').val(response.data.role_cd);
                    // $('#role_cd').trigger('change');

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
            var name = $(this).data('name');
            var role_cd = $(this).data('role_cd');

            $.ajax({
                url: "<?= site_url('tdocnumsetting/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    name: name,
                    role_cd: role_cd
                },
                dataType: "JSON",
                success: function(response) {
                    //set input
                    $('#name').attr('readonly', '');
                    $('#prefix').attr('readonly', '');
                    $('#docnum_description').attr('readonly', '');
                    $('#startwith').attr('readonly', '');
                    $('#increment').attr('readonly', '');
                    $('#minvalue').attr('readonly', '');
                    $('#maxvalue').attr('readonly', '');
                    $('#leadingprefix').removeAttr('disabled', '');
                    $('#leadingzero').removeAttr('disabled', '');
                    $('#leadingmonth').removeAttr('disabled', '');
                    $('#leadingyear').removeAttr('disabled', '');
                    $('#restart_month').removeAttr('disabled', '');
                    $('#restart_year').removeAttr('disabled', '');

                    // $('#role_cd').attr('readonly', '');
                    // $('#name').attr('readonly', '');
                    $('#leadingprefix').removeAttr('checked');
                    $('#leadingzero').removeAttr('checked');
                    $('#leadingmonth').removeAttr('checked');
                    $('#leadingyear').removeAttr('checked');
                    $('#restart_month').removeAttr('checked');
                    $('#restart_year').removeAttr('checked');

                    $('#data_form')[0].reset();

                    //set data from response record
                    $('#name').val(response.data.name);
                    $('#prefix').val(response.data.prefix);
                    $('#docnum_description').val(response.data.docnum_description);
                    $('#startwith').val(response.data.start_value);
                    $('#increment').val(response.data.increment);
                    $('#minvalue').val(response.data.minimum_value);
                    $('#maxvalue').val(response.data.maximum_value);
                    (response.data.leadingprefix === 1 ? $('#leadingprefix').attr('checked', 'checked') : $('#leadingprefix').removeAttr('checked'));
                    (response.data.leadingzero === 1 ? $('#leadingzero').attr('checked', 'checked') : $('#leadingzero').removeAttr('checked'));
                    (response.data.leadingmonth === 1 ? $('#leadingmonth').attr('checked', 'checked') : $('#leadingmonth').removeAttr('checked'));
                    (response.data.leadingyear === 1 ? $('#leadingyear').attr('checked', 'checked') : $('#leadingyear').removeAttr('checked'));
                    (response.data.restart_month === 1 ? $('#restart_month').attr('checked', 'checked') : $('#restart_month').removeAttr('checked'));
                    (response.data.restart_year === 1 ? $('#restart_year').attr('checked', 'checked') : $('#restart_year').removeAttr('checked'));

                    //set error validation
                    $('#name').removeClass('is-invalid');
                    $('#role_cd').removeClass('is-invalid');
                    $('.errorMenu_cd').html('');
                    $('.errorRole_cd').html('');

                    //set selected data
                    // $('#name').val(response.data.name);
                    // $('#name').trigger('change');
                    // $('#role_cd').val(response.data.role_cd);
                    // $('#role_cd').trigger('change');

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
            var name = $(this).data('name');
            var role_cd = $(this).data('role_cd');
            if (confirm("Are you sure you want to remove it?")) {
                $.ajax({
                    url: "<?= site_url('tdocnumsetting/delete'); ?>",
                    method: "POST",
                    data: {
                        name: name,
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
        // $('#uploadForm2').submit(function(e) {
        //     e.preventDefault();

        //     const formData = new FormData(this);

        //     $.ajax({
        //         url: '/tdocnumsetting/upload2',
        //         type: 'POST',
        //         data: formData,
        //         processData: false,
        //         contentType: false,
        //         success: function(response) {

        //             Swal.fire({
        //                 icon: 'success',
        //                 title: 'Success',
        //                 text: response.success,
        //                 //footer: '<a href="">Why do I have this issue?</a>'
        //             });
        //         },
        //         error: function(xhr) {
        //             console.error('Error:', xhr.responseText);
        //         }
        //     });
        // });

        $('#uploadForm').submit(function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            $.ajax({
                url: '/tdocnumsetting/preview',
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
                    tmenurolepreview();
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                }
            });
        });

        // $('#postButton').click(function() {
        //     $.post('<?= site_url('tdocnumsetting/upload'); ?>', {

        //         })
        //         .done(function(response) {
        //             $('#modalimport').modal('hide');
        //             alert('done');
        //             console.log('Data Loaded: ' + response);
        //         })
        //         .fail(function(error) {
        //             alert('error');
        //             console.error('Error: ' + error);
        //         });
        // });


        // preview excel data before import
        // $('#uploadForm').submit(function(e) {
        //     e.preventDefault();

        //     const formData = new FormData(this);

        //     $.ajax({
        //         url: '/tdocnumsetting/upload',
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