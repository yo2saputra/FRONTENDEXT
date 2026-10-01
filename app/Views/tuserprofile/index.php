<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>
<!-- Toastr -->
<link rel="stylesheet" href="<?= base_url('plugins/toastr/toastr.min.css') ?>">
<!-- Button datatable -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<!-- datepicker styles -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css">
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
                                                <label for="usr_id" class="col-sm-2 col-form-label">ID</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="usr_id" name="usr_id">
                                                    <span class="error invalid-feedback errorUsr_id">
                                                    </span>
                                                </div>
                                                <label for="fullname" class="col-sm-2 col-form-label">Nama Lengkap</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="fullname" name="fullname">
                                                    <span class="error invalid-feedback errorFullname">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="email" name="email">
                                                    <span class="error invalid-feedback errorEmail">
                                                    </span>
                                                </div>
                                                <label for="mobile_no" class="col-sm-2 col-form-label">No HP</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="mobile_no" name="mobile_no">
                                                    <span class="error invalid-feedback errorMobile_no">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="home_no" class="col-sm-2 col-form-label">No Rumah</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="home_no" name="home_no">
                                                    <span class="error invalid-feedback errorHome_no">
                                                    </span>
                                                </div>
                                                <label for="mobile_no_process" class="col-sm-2 col-form-label">No HP Prosess</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="mobile_no_process" name="mobile_no_process">
                                                    <span class="error invalid-feedback errorMobile_no_process">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="pwd_exp_dt" class="col-sm-2 col-form-label">Password Exp</label>
                                                <div class="col-sm-4">
                                                    <div class="input-group date pwd_exp_dt" data-date-format="mm/dd/yyyy">
                                                        <input type="text" class="form-control form-control-sm datepicker" placeholder="mm/dd/yyyy" id="pwd_exp_dt" name="pwd_exp_dt" autocomplete="off">
                                                        <div class="input-group-append" data-target="#pwd_exp_dt" data-toggle="pwd_exp_dt">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                    </div>
                                                    <span class="error invalid-feedback errorPwd_exp_dt">
                                                    </span>
                                                </div>
                                                <label for="resign_dt" class="col-sm-2 col-form-label">Tgl Resign</label>
                                                <div class="col-sm-4">
                                                    <div class="input-group date resign_dt" data-date-format="mm/dd/yyyy">
                                                        <input type="text" class="form-control form-control-sm datepicker" placeholder="mm/dd/yyyy" id="resign_dt" name="resign_dt" autocomplete="off">
                                                        <div class="input-group-append" data-target="#resign_dt" data-toggle="resign_dt">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                    </div>
                                                    <span class="error invalid-feedback errorResign_dt">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="whatsapp_no" class="col-sm-2 col-form-label">Whatsapp No</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="whatsapp_no" name="whatsapp_no">
                                                    <span class="error invalid-feedback errorWhatsapp_no">
                                                    </span>
                                                </div>
                                                <?= $cb_employee ?>
                                            </div>
                                            <!-- <div class="mb-3 row">
                                                <label for="salespointcd" class="col-sm-2 col-form-label">Sales Point Code</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="salespointcd" name="salespointcd">
                                                    <span class="error invalid-feedback errorSalespointcd">
                                                    </span>
                                                </div>
                                                <label for="initname" class="col-sm-2 col-form-label">Init Name</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="initname" name="initname">
                                                    <span class="error invalid-feedback errorInitname">
                                                    </span>
                                                </div>
                                            </div> -->
                                            <!-- <div class="mb-3 row">
                                                
                                                <label for="isactive" class="col-sm-2 col-form-label"></label>
                                                <div class="col-sm-4">
                                                    <div class="icheck-primary d-inline">
                                                        <input type="checkbox" id="isactive" name="isactive">
                                                        <label for="isactive">Isactive</label>
                                                    </div>
                                                    <span class="error invalid-feedback errorIsactive">
                                                    </span>
                                                </div>
                                            </div> -->
                                            <div class="mb-3 row">
                                                <?= $cb_role ?>
                                                <label for="passwd" class="col-sm-2 col-form-label">Password</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="passwd" name="passwd">
                                                    <span class="error invalid-feedback errorPasswd">
                                                    </span>
                                                </div>
                                            </div>
                                            <!-- <div class="mb-3 row">
                                                <?= $cb_role ?>
                                                <label for="token_dt" class="col-sm-2 col-form-label">Token Date</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="token_dt" name="token_dt">
                                                    <span class="error invalid-feedback errorToken_dt">
                                                    </span>
                                                </div>
                                            </div> -->
                                            <div class="mb-3 row">
                                                <div class="col-sm-2"></div>
                                                <div class="col-sm-10">
                                                    <div class="icheck-primary d-inline">
                                                        <input type="checkbox" id="isactive" name="isactive" checked>
                                                        <label for="isactive">Isactive</label>
                                                    </div>
                                                    <span class="error invalid-feedback errorIsactive">
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

<!-- Datepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

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
    $('#resign_dt').datepicker({
        todayHighlight: true,
        autoclose: true,
        dateFormat: 'MM/DD/YYYY'
    }).val();
    $('#pwd_exp_dt').datepicker({
        todayHighlight: true,
        autoclose: true,
        dateFormat: 'MM/DD/YYYY'
    }).val();
</script>

<script>
    function tuserprofile() {
        $.ajax({
            method: "get",
            url: "<?= site_url('/tuserprofile/fetchAll'); ?>",
            success: function(data) {
                $('#viewdata').html(data);
            }
        });
    }
    $(document).ready(function() {
        tuserprofile()

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
            $('#usr_id').removeAttr('disabled');
            $('#fullname').removeAttr('disabled');
            $('#email').removeAttr('disabled');
            $('#mobile_no').removeAttr('disabled');
            $('#mobile_no_process').removeAttr('disabled');
            $('#home_no').removeAttr('disabled');
            $('#pwd_exp_dt').removeAttr('disabled');
            $('#resign_dt').removeAttr('disabled');
            $('#whatsapp_no').removeAttr('disabled');
            // $('#last_token').removeAttr('disabled');
            $('#passwd').removeAttr('disabled');
            $('#emp_cd').removeAttr('disabled');
            // $('#salespointcd').removeAttr('disabled');
            // $('#token_dt').removeAttr('disabled');
            // $('#initname').removeAttr('disabled');
            $('#isactive').removeAttr('disabled');
            $('#role_cd').removeAttr('disabled');
            // $('#pwdbinary').removeAttr('disabled');
            $('#usr_id').removeAttr('readonly');
            $('#isactive').removeAttr('checked');

            $('#data_form')[0].reset();

            //set error validation
            $('#usr_id').removeClass('is-invalid');
            $('#fullname').removeClass('is-invalid');
            $('#email').removeClass('is-invalid');
            $('#mobile_no').removeClass('is-invalid');
            $('#mobile_no_process').removeClass('is-invalid');
            $('#home_no').removeClass('is-invalid');
            $('#pwd_exp_dt').removeClass('is-invalid');
            $('#resign_dt').removeClass('is-invalid');
            $('#whatsapp_no').removeClass('is-invalid');
            // $('#last_token').removeClass('is-invalid');
            $('#passwd').removeClass('is-invalid');
            $('#emp_cd').removeClass('is-invalid');
            // $('#salespointcd').removeClass('is-invalid');
            // $('#token_dt').removeClass('is-invalid');
            // $('#initname').removeClass('is-invalid');
            // $('#isactive').removeClass('is-invalid');
            $('#role_cd').removeClass('is-invalid');
            // $('#pwdbinary').removeClass('is-invalid');

            $('.errorUsr_id').html('');
            $('.errorFullname').html('');
            $('.errorEmail').html('');
            $('.errorMobile_no').html('');
            $('.errorMobile_no_process').html('');
            $('.errorHome_no').html('');
            $('.errorPwd_exp_dt').html('');
            $('.errorResign_dt').html('');
            $('.errorWhatsapp_no').html('');
            // $('.errorLast_token').html('');
            $('.errorPasswd').html('');
            $('.errorEmp_cd').html('');
            // $('.errorSalespointcd').html('');
            // $('.errorToken_dt').html('');
            // $('.errorInitname').html('');
            // $('.errorIsactive').html('');
            $('.errorRole_cd').html('');
            // $('.errorPwdbinary').html('');
            $('#passwd').val('12345678');

            //set selected data select2
            $('#role_cd').val(' ');
            $('#role_cd').trigger('change');
            $('#emp_cd').val(' ');
            $('#emp_cd').trigger('change');

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
                url: "<?= site_url('tuserprofile/action'); ?>",
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
                        if (response.error.usr_id) {
                            $('#usr_id').addClass('is-invalid');
                            $('.errorUsr_id').html(response.error.usr_id);
                        } else {
                            $('#usr_id').removeClass('is-invalid');
                            $('.errorUsr_id').html('');
                        }
                        if (response.error.fullname) {
                            $('#fullname').addClass('is-invalid');
                            $('.errorFullname').html(response.error.fullname);
                        } else {
                            $('#fullname').removeClass('is-invalid');
                            $('.errorFullname').html('');
                        }
                        if (response.error.email) {
                            $('#email').addClass('is-invalid');
                            $('.errorEmail').html(response.error.email);
                        } else {
                            $('#email').removeClass('is-invalid');
                            $('.errorEmail').html('');
                        }
                        if (response.error.mobile_no) {
                            $('#mobile_no').addClass('is-invalid');
                            $('.errorMobile_no').html(response.error.mobile_no);
                        } else {
                            $('#mobile_no').removeClass('is-invalid');
                            $('.errorMobile_no').html('');
                        }
                        if (response.error.mobile_no_process) {
                            $('#mobile_no_process').addClass('is-invalid');
                            $('.errorMobile_no_process').html(response.error.mobile_no_process);
                        } else {
                            $('#mobile_no_process').removeClass('is-invalid');
                            $('.errorMobile_no_process').html('');
                        }
                        if (response.error.home_no) {
                            $('#home_no').addClass('is-invalid');
                            $('.errorHome_no').html(response.error.home_no);
                        } else {
                            $('#home_no').removeClass('is-invalid');
                            $('.errorHome_no').html('');
                        }
                        if (response.error.pwd_exp_dt) {
                            $('#pwd_exp_dt').addClass('is-invalid');
                            $('.errorPwd_exp_dt').html(response.error.pwd_exp_dt);
                        } else {
                            $('#pwd_exp_dt').removeClass('is-invalid');
                            $('.errorPwd_exp_dt').html('');
                        }
                        if (response.error.resign_dt) {
                            $('#resign_dt').addClass('is-invalid');
                            $('.errorResign_dt').html(response.error.resign_dt);
                        } else {
                            $('#resign_dt').removeClass('is-invalid');
                            $('.errorResign_dt').html('');
                        }
                        if (response.error.whatsapp_no) {
                            $('#whatsapp_no').addClass('is-invalid');
                            $('.errorWhatsapp_no').html(response.error.whatsapp_no);
                        } else {
                            $('#whatsapp_no').removeClass('is-invalid');
                            $('.errorWhatsapp_no').html('');
                        }
                        // if (response.error.last_token) {
                        //     $('#last_token').addClass('is-invalid');
                        //     $('.errorLast_token').html(response.error.last_token);
                        // } else {
                        //     $('#last_token').removeClass('is-invalid');
                        //     $('.errorLast_token').html('');
                        // }
                        // if (response.error.passwd) {
                        //     $('#passwd').addClass('is-invalid');
                        //     $('.errorPasswd').html(response.error.passwd);
                        // } else {
                        //     $('#passwd').removeClass('is-invalid');
                        //     $('.errorPasswd').html('');
                        // }
                        if (response.error.emp_cd) {
                            $('#emp_cd').addClass('is-invalid');
                            $('.errorEmp_cd').html(response.error.emp_cd);
                        } else {
                            $('#emp_cd').removeClass('is-invalid');
                            $('.errorEmp_cd').html('');
                        }
                        // if (response.error.salespointcd) {
                        //     $('#salespointcd').addClass('is-invalid');
                        //     $('.errorSalespointcd').html(response.error.salespointcd);
                        // } else {
                        //     $('#salespointcd').removeClass('is-invalid');
                        //     $('.errorSalespointcd').html('');
                        // }
                        // if (response.error.token_dt) {
                        //     $('#token_dt').addClass('is-invalid');
                        //     $('.errorToken_dt').html(response.error.token_dt);
                        // } else {
                        //     $('#token_dt').removeClass('is-invalid');
                        //     $('.errorToken_dt').html('');
                        // }
                        // if (response.error.initname) {
                        //     $('#initname').addClass('is-invalid');
                        //     $('.errorInitname').html(response.error.initname);
                        // } else {
                        //     $('#initname').removeClass('is-invalid');
                        //     $('.errorInitname').html('');
                        // }
                        // if (response.error.isactive) {
                        //     $('#isactive').addClass('is-invalid');
                        //     $('.errorIsactive').html(response.error.isactive);
                        // } else {
                        //     $('#isactive').removeClass('is-invalid');
                        //     $('.errorIsactive').html('');
                        // }
                        if (response.error.role_cd) {
                            $('#role_cd').addClass('is-invalid');
                            $('.errorRole_cd').html(response.error.role_cd);
                        } else {
                            $('#role_cd').removeClass('is-invalid');
                            $('.errorRole_cd').html('');
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
                        $('#usr_id').removeClass('is-invalid');
                        $('#fullname').removeClass('is-invalid');
                        $('#email').removeClass('is-invalid');
                        $('#mobile_no').removeClass('is-invalid');
                        $('#mobile_no_process').removeClass('is-invalid');
                        $('#home_no').removeClass('is-invalid');
                        $('#pwd_exp_dt').removeClass('is-invalid');
                        $('#resign_dt').removeClass('is-invalid');
                        $('#whatsapp_no').removeClass('is-invalid');
                        // $('#last_token').removeClass('is-invalid');
                        $('#passwd').removeClass('is-invalid');
                        $('#emp_cd').removeClass('is-invalid');
                        // $('#salespointcd').removeClass('is-invalid');
                        // $('#token_dt').removeClass('is-invalid');
                        // $('#initname').removeClass('is-invalid');
                        $('#isactive').removeClass('is-invalid');
                        $('#role_cd').removeClass('is-invalid');
                        // $('#pwdbinary').removeClass('is-invalid');

                        $('.errorUsr_id').html('');
                        $('.errorFullname').html('');
                        $('.errorEmail').html('');
                        $('.errorMobile_no').html('');
                        $('.errorMobile_no_process').html('');
                        $('.errorHome_no').html('');
                        $('.errorPwd_exp_dt').html('');
                        $('.errorResign_dt').html('');
                        $('.errorWhatsapp_no').html('');
                        // $('.errorLast_token').html('');
                        $('.errorPasswd').html('');
                        $('.errorEmp_cd').html('');
                        // $('.errorSalespointcd').html('');
                        // $('.errorToken_dt').html('');
                        // $('.errorInitname').html('');
                        $('.errorIsactive').html('');
                        $('.errorRole_cd').html('');
                        // $('.errorPwdbinary').html('');
                        $('#isactive').removeAttr('checked');

                        tuserprofile();
                        $('#modalform').modal('hide');
                    }
                },
            })
        });

        $(document).on('click', '.view', function() {
            var usr_id = $(this).data('usr_id');

            $.ajax({
                url: "<?= site_url('tuserprofile/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    usr_id: usr_id
                },
                dataType: "JSON",
                success: function(response) {
                    //set input
                    $('#usr_id').attr('disabled', '');
                    $('#fullname').attr('disabled', '');
                    $('#email').attr('disabled', '');
                    $('#mobile_no').attr('disabled', '');
                    $('#mobile_no_process').attr('disabled', '');
                    $('#home_no').attr('disabled', '');
                    $('#pwd_exp_dt').attr('disabled', '');
                    $('#resign_dt').attr('disabled', '');
                    $('#whatsapp_no').attr('disabled', '');
                    // $('#last_token').attr('disabled', '');
                    $('#passwd').attr('disabled', '');
                    $('#emp_cd').attr('disabled', '');
                    // $('#salespointcd').attr('disabled', '');
                    // $('#token_dt').attr('disabled', '');
                    // $('#initname').attr('disabled', '');
                    $('#isactive').attr('disabled', '');
                    $('#role_cd').attr('disabled', '');
                    // $('#pwdbinary').attr('disabled','');
                    $('#usr_id').attr('readonly', '');
                    $('#isactive').removeAttr('checked');

                    $('#data_form')[0].reset();

                    // alert(response.data.usr_id);
                    // alert(response.data.menu_nm);
                    // alert(response.data.reference);
                    // alert(response.data.header_id);

                    //set datepicker input value
                    $('#pwd_exp_dt').datepicker('update', response.data.pwd_exp_dt);
                    $('#resign_dt').datepicker('update', response.data.resign_dt);

                    //set data from response record
                    $('#usr_id').val(response.data.usr_id);
                    $('#fullname').val(response.data.fullname);
                    $('#email').val(response.data.email);
                    $('#mobile_no').val(response.data.mobile_no);
                    $('#mobile_no_process').val(response.data.mobile_no_process);
                    $('#home_no').val(response.data.home_no);
                    $('#pwd_exp_dt').val(response.data.pwd_exp_dt);
                    $('#resign_dt').val(response.data.resign_dt);
                    $('#whatsapp_no').val(response.data.whatsapp_no);
                    // $('#last_token').val(response.data.last_token);
                    $('#passwd').val(response.data.passwd);
                    $('#emp_cd').val(response.data.emp_cd);
                    // $('#salespointcd').val(response.data.salespointcd);
                    // $('#token_dt').val(response.data.token_dt);
                    // $('#initname').val(response.data.initname);
                    // $('#isactive').val(response.data.isactive);
                    $('#role_cd').val(response.data.role_cd);
                    // $('#pwdbinary').val(response.data.pwdbinary);
                    (response.data.isactive === 1 ? $('#isactive').attr('checked', 'checked') : $('#isactive').removeAttr('checked'));

                    //set error validation
                    $('#usr_id').removeClass('is-invalid');
                    $('#fullname').removeClass('is-invalid');
                    $('#email').removeClass('is-invalid');
                    $('#mobile_no').removeClass('is-invalid');
                    $('#mobile_no_process').removeClass('is-invalid');
                    $('#home_no').removeClass('is-invalid');
                    $('#pwd_exp_dt').removeClass('is-invalid');
                    $('#resign_dt').removeClass('is-invalid');
                    $('#whatsapp_no').removeClass('is-invalid');
                    // $('#last_token').removeClass('is-invalid');
                    $('#passwd').removeClass('is-invalid');
                    $('#emp_cd').removeClass('is-invalid');
                    // $('#salespointcd').removeClass('is-invalid');
                    // $('#token_dt').removeClass('is-invalid');
                    // $('#initname').removeClass('is-invalid');
                    $('#isactive').removeClass('is-invalid');
                    $('#role_cd').removeClass('is-invalid');
                    // $('#pwdbinary').removeClass('is-invalid');

                    $('.errorUsr_id').html('');
                    $('.errorFullname').html('');
                    $('.errorEmail').html('');
                    $('.errorMobile_no').html('');
                    $('.errorMobile_no_process').html('');
                    $('.errorHome_no').html('');
                    $('.errorPwd_exp_dt').html('');
                    $('.errorResign_dt').html('');
                    $('.errorWhatsapp_no').html('');
                    // $('.errorLast_token').html('');
                    $('.errorPasswd').html('');
                    $('.errorEmp_cd').html('');
                    // $('.errorSalespointcd').html('');
                    // $('.errorToken_dt').html('');
                    // $('.errorInitname').html('');
                    $('.errorIsactive').html('');
                    $('.errorRole_cd').html('');
                    // $('.errorPwdbinary').html('');

                    //set selected data select2
                    $('#role_cd').val(response.data.role_cd);
                    $('#role_cd').trigger('change');
                    $('#emp_cd').val(response.data.emp_cd);
                    $('#emp_cd').trigger('change');

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
            var usr_id = $(this).data('usr_id');

            $.ajax({
                url: "<?= site_url('tuserprofile/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    usr_id: usr_id
                },
                dataType: "JSON",
                success: function(response) {
                    //set input
                    $('#usr_id').removeAttr('disabled');
                    $('#fullname').removeAttr('disabled');
                    $('#email').removeAttr('disabled');
                    $('#mobile_no').removeAttr('disabled');
                    $('#mobile_no_process').removeAttr('disabled');
                    $('#home_no').removeAttr('disabled');
                    $('#pwd_exp_dt').removeAttr('disabled');
                    $('#resign_dt').removeAttr('disabled');
                    $('#whatsapp_no').removeAttr('disabled');
                    // $('#last_token').removeAttr('disabled');
                    $('#passwd').removeAttr('disabled');
                    $('#emp_cd').removeAttr('disabled');
                    // $('#salespointcd').removeAttr('disabled');
                    // $('#token_dt').removeAttr('disabled');
                    // $('#initname').removeAttr('disabled');
                    $('#isactive').removeAttr('disabled');
                    $('#role_cd').removeAttr('disabled');
                    // $('#pwdbinary').removeAttr('disabled');
                    $('#usr_id').attr('readonly', '');
                    $('#isactive').removeAttr('checked');

                    $('#data_form')[0].reset();

                    // alert(response.data.usr_id);
                    // alert(response.data.menu_nm);
                    // alert(response.data.reference);
                    // alert(response.data.header_id);

                    //set datepicker input value
                    $('#pwd_exp_dt').datepicker('update', response.data.pwd_exp_dt);
                    $('#resign_dt').datepicker('update', response.data.resign_dt);

                    //set data from response record
                    $('#usr_id').val(response.data.usr_id);
                    $('#fullname').val(response.data.fullname);
                    $('#email').val(response.data.email);
                    $('#mobile_no').val(response.data.mobile_no);
                    $('#mobile_no_process').val(response.data.mobile_no_process);
                    $('#home_no').val(response.data.home_no);
                    $('#pwd_exp_dt').val(response.data.pwd_exp_dt);
                    $('#resign_dt').val(response.data.resign_dt);
                    $('#whatsapp_no').val(response.data.whatsapp_no);
                    // $('#last_token').val(response.data.last_token);
                    $('#passwd').val(response.data.passwd);
                    $('#emp_cd').val(response.data.emp_cd);
                    // $('#salespointcd').val(response.data.salespointcd);
                    // $('#token_dt').val(response.data.token_dt);
                    // $('#initname').val(response.data.initname);
                    // $('#isactive').val(response.data.isactive);
                    $('#role_cd').val(response.data.role_cd);
                    // $('#pwdbinary').val(response.data.pwdbinary);
                    (response.data.isactive === 1 ? $('#isactive').attr('checked', 'checked') : $('#isactive').removeAttr('checked'));

                    //set error validation
                    $('#usr_id').removeClass('is-invalid');
                    $('#fullname').removeClass('is-invalid');
                    $('#email').removeClass('is-invalid');
                    $('#mobile_no').removeClass('is-invalid');
                    $('#mobile_no_process').removeClass('is-invalid');
                    $('#home_no').removeClass('is-invalid');
                    $('#pwd_exp_dt').removeClass('is-invalid');
                    $('#resign_dt').removeClass('is-invalid');
                    $('#whatsapp_no').removeClass('is-invalid');
                    // $('#last_token').removeClass('is-invalid');
                    $('#passwd').removeClass('is-invalid');
                    $('#emp_cd').removeClass('is-invalid');
                    // $('#salespointcd').removeClass('is-invalid');
                    // $('#token_dt').removeClass('is-invalid');
                    // $('#initname').removeClass('is-invalid');
                    $('#isactive').removeClass('is-invalid');
                    $('#role_cd').removeClass('is-invalid');
                    // $('#pwdbinary').removeClass('is-invalid');

                    $('.errorUsr_id').html('');
                    $('.errorFullname').html('');
                    $('.errorEmail').html('');
                    $('.errorMobile_no').html('');
                    $('.errorMobile_no_process').html('');
                    $('.errorHome_no').html('');
                    $('.errorPwd_exp_dt').html('');
                    $('.errorResign_dt').html('');
                    $('.errorWhatsapp_no').html('');
                    // $('.errorLast_token').html('');
                    $('.errorPasswd').html('');
                    $('.errorEmp_cd').html('');
                    // $('.errorSalespointcd').html('');
                    // $('.errorToken_dt').html('');
                    // $('.errorInitname').html('');
                    $('.errorIsactive').html('');
                    $('.errorRole_cd').html('');
                    // $('.errorPwdbinary').html('');

                    //set selected data select2
                    $('#role_cd').val(response.data.role_cd);
                    $('#role_cd').trigger('change');
                    $('#emp_cd').val(response.data.emp_cd);
                    $('#emp_cd').trigger('change');

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
            var usr_id = $(this).data('usr_id');
            if (confirm("Are you sure you want to remove it?")) {
                $.ajax({
                    url: "<?= site_url('tuserprofile/delete'); ?>",
                    method: "POST",
                    data: {
                        usr_id: usr_id
                    },
                    dataType: "JSON",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                            //footer: '<a href="">Why do I have this issue?</a>'
                        });
                        tuserprofile();
                        setTimeout(function() {
                            $('#message').html('');
                        }, 5000);
                    }
                })
            }
        });
    });
</script>



<?= $this->endSection('script'); ?>