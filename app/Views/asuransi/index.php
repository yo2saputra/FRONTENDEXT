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
                                                <label for="asr_cd" class="col-sm-2 col-form-label">ID</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="asr_cd" name="asr_cd">
                                                    <span class="error invalid-feedback errorAsr_cd">
                                                    </span>
                                                </div>
                                                <label for="asr_nm" class="col-sm-2 col-form-label">Name</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="asr_nm" name="asr_nm">
                                                    <span class="error invalid-feedback errorAsr_nm">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="perjanjian_dt" class="col-sm-2 col-form-label">Perjanjian Date</label>
                                                <div class="col-sm-4">
                                                    <div class="input-group date perjanjian_dt" data-date-format="mm/dd/yyyy">
                                                        <input type="text" class="form-control form-control-sm datepicker" placeholder="mm/dd/yyyy" id="perjanjian_dt" name="perjanjian_dt">
                                                        <div class="input-group-append" data-target="#perjanjian_dt" data-toggle="perjanjian_dt">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                    </div>
                                                    <span class="error invalid-feedback errorPerjanjian_dt">
                                                    </span>
                                                </div>
                                                <label for="efektif_dt" class="col-sm-2 col-form-label">Efektif Date</label>
                                                <div class="col-sm-4">
                                                    <div class="input-group date efektif_dt" data-date-format="mm/dd/yyyy">
                                                        <input type="text" class="form-control form-control-sm datepicker" placeholder="mm/dd/yyyy" id="efektif_dt" name="efektif_dt">
                                                        <div class="input-group-append" data-target="#efektif_dt" data-toggle="efektif_dt">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                    </div>
                                                    <span class="error invalid-feedback errorEfektif_dt">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="pic_nm" class="col-sm-2 col-form-label">PIC Name</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="pic_nm" name="pic_nm">
                                                    <span class="error invalid-feedback errorPic_nm">
                                                    </span>
                                                </div>
                                                <label for="pic_mobile_no" class="col-sm-2 col-form-label">PIC Phone</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="pic_mobile_no" name="pic_mobile_no">
                                                    <span class="error invalid-feedback errorPic_mobile_no">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="pic_email" class="col-sm-2 col-form-label">PIC Email</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="pic_email" name="pic_email">
                                                    <span class="error invalid-feedback errorPic_email">
                                                    </span>
                                                </div>
                                                <label for="" class="col-sm-2 col-form-label">PIC Alamat</label>
                                                <div class="col-sm-4">
                                                    <textarea class="form-control form-control-sm" rows="3" placeholder="..." id="pic_addr" name="pic_addr" autocomplete="off"></textarea>
                                                    <span class="error invalid-feedback errorPic_addr">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="deleted" class="col-sm-2 col-form-label">Deleted</label>
                                                <div class="col-sm-4">
                                                    <div class="icheck-primary d-inline">
                                                        <input type="checkbox" id="deleted" name="deleted" checked>
                                                        <label for="deleted">
                                                        </label>
                                                    </div>
                                                    <span class="error invalid-feedback errorDeleted">
                                                    </span>
                                                </div>
                                                <label for="cashless" class="col-sm-2 col-form-label">Cashless</label>
                                                <div class="col-sm-4">
                                                    <div class="icheck-primary d-inline">
                                                        <input type="checkbox" id="cashless" name="cashless" checked>
                                                        <label for="cashless">
                                                        </label>
                                                    </div>
                                                    <span class="error invalid-feedback errorCashless">
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

<!-- Datepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<script>
    $('#perjanjian_dt').datepicker({
        todayHighlight: true,
        autoclose: true,
        dateFormat: 'MM/DD/YYYY'
    }).val();
    $('#efektif_dt').datepicker({
        todayHighlight: true,
        autoclose: true,
        dateFormat: 'MM/DD/YYYY'
    }).val();
</script>

<!-- set menu name by active-menu -->
<script>
    $('#active-menu').html($('p#active-menu').html()); // set top navbar
    $(document).prop("title", $('p#active-menu').html()); // set title
</script>

<script>
    function tasuransi() {
        $.ajax({
            method: "get",
            url: "<?= site_url('/tasuransi/fetchAll'); ?>",
            success: function(data) {
                $('#viewdata').html(data);
            }
        });
    }
    $(document).ready(function() {
        tasuransi()

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

            $('#asr_nm').removeAttr('disabled');
            $('#perjanjian_dt').removeAttr('disabled');
            $('#efektif_dt').removeAttr('disabled');
            $('#pic_nm').removeAttr('disabled');
            $('#pic_mobile_no').removeAttr('disabled');
            $('#pic_email').removeAttr('disabled');
            $('#pic_addr').removeAttr('disabled');
            $('#asr_cd').removeAttr('readonly');
            $('#asr_cd').attr('readonly', '');
            $('#deleted').removeAttr('disabled');
            $('#deleted').removeAttr('checked');
            $('#cashless').removeAttr('disabled');
            $('#cashless').removeAttr('checked');

            $('#data_form')[0].reset();

            //set error validation
            $('#asr_cd').removeClass('is-invalid');
            $('#asr_nm').removeClass('is-invalid');
            $('#perjanjian_dt').removeClass('is-invalid');
            $('#efektif_dt').removeClass('is-invalid');
            $('#pic_nm').removeClass('is-invalid');
            $('#pic_mobile_no').removeClass('is-invalid');
            $('#pic_email').removeClass('is-invalid');
            $('#pic_addr').removeClass('is-invalid');

            $('.errorAsr_cd').html('');
            $('.errorAsr_nm').html('');
            $('.errorPerjanjian_dt').html('');
            $('.errorEfektif_dt').html('');
            $('.errorPic_nm').html('');
            $('.errorPic_mobile_no').html('');
            $('.errorPic_email').html('');
            $('.errorPic_addr').html('');

            //set selected data select2


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
                url: "<?= site_url('tasuransi/action'); ?>",
                method: "POST",
                data: $(this).serialize(),
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
                        // if (response.error.asr_cd) {
                        //     $('#asr_cd').addClass('is-invalid');
                        //     $('.errorAsr_cd').html(response.error.asr_cd);
                        // } else {
                        //     $('#asr_cd').removeClass('is-invalid');
                        //     $('.errorAsr_cd').html('');
                        // }
                        if (response.error.asr_nm) {
                            $('#asr_nm').addClass('is-invalid');
                            $('.errorAsr_nm').html(response.error.asr_nm);
                        } else {
                            $('#asr_nm').removeClass('is-invalid');
                            $('.errorAsr_nm').html('');
                        }
                        if (response.error.perjanjian_dt) {
                            $('#perjanjian_dt').addClass('is-invalid');
                            $('.errorPerjanjian_dt').html(response.error.perjanjian_dt);
                        } else {
                            $('#perjanjian_dt').removeClass('is-invalid');
                            $('.errorPerjanjian_dt').html('');
                        }
                        if (response.error.efektif_dt) {
                            $('#efektif_dt').addClass('is-invalid');
                            $('.errorEfektif_dt').html(response.error.efektif_dt);
                        } else {
                            $('#efektif_dt').removeClass('is-invalid');
                            $('.errorEfektif_dt').html('');
                        }
                        if (response.error.pic_nm) {
                            $('#pic_nm').addClass('is-invalid');
                            $('.errorPic_nm').html(response.error.pic_nm);
                        } else {
                            $('#pic_nm').removeClass('is-invalid');
                            $('.errorPic_nm').html('');
                        }
                        if (response.error.pic_mobile_no) {
                            $('#pic_mobile_no').addClass('is-invalid');
                            $('.errorPic_mobile_no').html(response.error.pic_mobile_no);
                        } else {
                            $('#pic_mobile_no').removeClass('is-invalid');
                            $('.errorPic_mobile_no').html('');
                        }
                        if (response.error.pic_email) {
                            $('#pic_email').addClass('is-invalid');
                            $('.errorPic_email').html(response.error.pic_email);
                        } else {
                            $('#pic_email').removeClass('is-invalid');
                            $('.errorPic_email').html('');
                        }
                        if (response.error.pic_addr) {
                            $('#pic_addr').addClass('is-invalid');
                            $('.errorPic_addr').html(response.error.pic_addr);
                        } else {
                            $('#pic_addr').removeClass('is-invalid');
                            $('.errorPic_addr').html('');
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
                        $('#asr_cd').removeClass('is-invalid');
                        $('#asr_nm').removeClass('is-invalid');
                        $('#perjanjian_dt').removeClass('is-invalid');
                        $('#efektif_dt').removeClass('is-invalid');
                        $('#pic_nm').removeClass('is-invalid');
                        $('#pic_mobile_no').removeClass('is-invalid');
                        $('#pic_email').removeClass('is-invalid');
                        $('#pic_addr').removeClass('is-invalid');
                        $('#deleted').removeAttr('checked');
                        $('#cashless').removeAttr('checked');

                        $('.errorAsr_cd').html('');
                        $('.errorAsr_nm').html('');
                        $('.errorPerjanjian_dt').html('');
                        $('.errorEfektif_dt').html('');
                        $('.errorPic_nm').html('');
                        $('.errorPic_mobile_no').html('');
                        $('.errorPic_email').html('');
                        $('.errorPic_addr').html('');

                        tasuransi();
                        $('#modalform').modal('hide');
                    }
                },
            })
        });

        $(document).on('click', '.view', function() {
            var asr_cd = $(this).data('asr_cd');

            $.ajax({
                url: "<?= site_url('tasuransi/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    asr_cd: asr_cd
                },
                dataType: "JSON",
                success: function(response) {
                    //set input
                    $('#asr_cd').attr('disabled', '');
                    $('#asr_nm').attr('disabled', '');
                    $('#perjanjian_dt').attr('disabled', '');
                    $('#efektif_dt').attr('disabled', '');
                    $('#pic_nm').attr('disabled', '');
                    $('#pic_mobile_no').attr('disabled', '');
                    $('#pic_email').attr('disabled', '');
                    $('#pic_addr').attr('disabled', '');
                    // $('#asr_cd').attr('readonly', '');
                    $('#deleted').attr('disabled', '');
                    $('#deleted').removeAttr('checked');
                    $('#cashless').attr('disabled', '');
                    $('#cashless').removeAttr('checked');


                    $('#data_form')[0].reset();

                    // alert(response.data.asr_cd);
                    // alert(response.data.menu_nm);
                    // alert(response.data.reference);
                    // alert(response.data.cashless);

                    //set data from response record
                    $('#asr_cd').val(response.data.asr_cd);
                    $('#asr_nm').val(response.data.asr_nm);
                    $('#perjanjian_dt').val(response.data.perjanjian_dt);
                    $('#efektif_dt').val(response.data.efektif_dt);
                    $('#pic_nm').val(response.data.pic_nm);
                    $('#pic_mobile_no').val(response.data.pic_mobile_no);
                    $('#pic_email').val(response.data.pic_email);
                    $('#pic_addr').val(response.data.pic_addr);
                    (response.data.deleted === 1 ? $('#deleted').attr('checked', 'checked') : $('#deleted').removeAttr('checked'));
                    (response.data.cashless === 1 ? $('#cashless').attr('checked', 'checked') : $('#cashless').removeAttr('checked'));

                    //set error validation
                    $('#asr_cd').removeClass('is-invalid');
                    $('#asr_nm').removeClass('is-invalid');
                    $('#perjanjian_dt').removeClass('is-invalid');
                    $('#efektif_dt').removeClass('is-invalid');
                    $('#pic_nm').removeClass('is-invalid');
                    $('#pic_mobile_no').removeClass('is-invalid');
                    $('#pic_email').removeClass('is-invalid');
                    $('#pic_addr').removeClass('is-invalid');

                    $('.errorAsr_cd').html('');
                    $('.errorAsr_nm').html('');
                    $('.errorPerjanjian_dt').html('');
                    $('.errorEfektif_dt').html('');
                    $('.errorPic_nm').html('');
                    $('.errorPic_mobile_no').html('');
                    $('.errorPic_email').html('');
                    $('.errorPic_addr').html('');

                    //set selected data select2
                    // $('#asr_cd').val(response.data.asr_cd);
                    // $('#asr_cd').trigger('change');

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
            var asr_cd = $(this).data('asr_cd');

            $.ajax({
                url: "<?= site_url('tasuransi/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    asr_cd: asr_cd
                },
                dataType: "JSON",
                success: function(response) {
                    //set input
                    // $('#asr_cd').removeAttr('disabled');
                    $('#asr_nm').removeAttr('disabled');
                    $('#perjanjian_dt').removeAttr('disabled');
                    $('#efektif_dt').removeAttr('disabled');
                    $('#pic_nm').removeAttr('disabled');
                    $('#pic_mobile_no').removeAttr('disabled');
                    $('#pic_email').removeAttr('disabled');
                    $('#pic_addr').removeAttr('disabled');

                    // $('#asr_cd').attr('disabled', '');
                    $('#asr_cd').attr('readonly', '');
                    $('#deleted').removeAttr('disabled');
                    $('#deleted').removeAttr('checked');
                    $('#cashless').removeAttr('disabled');
                    $('#cashless').removeAttr('checked');

                    $('#data_form')[0].reset();

                    // alert(response.data.asr_cd);
                    // alert(response.data.menu_nm);
                    // alert(response.data.reference);
                    // alert(response.data.header_id);

                    //set datepicker input value
                    $('#perjanjian_dt').datepicker('update', response.data.perjanjian_dt);
                    $('#efektif_dt').datepicker('update', response.data.efektif_dt);

                    //set data from response record
                    $('#asr_cd').val(response.data.asr_cd);
                    $('#asr_nm').val(response.data.asr_nm);
                    $('#perjanjian_dt').val(response.data.perjanjian_dt);
                    $('#efektif_dt').val(response.data.efektif_dt);
                    $('#pic_nm').val(response.data.pic_nm);
                    $('#pic_mobile_no').val(response.data.pic_mobile_no);
                    $('#pic_email').val(response.data.pic_email);
                    $('#pic_addr').val(response.data.pic_addr);
                    (response.data.deleted === 1 ? $('#deleted').attr('checked', 'checked') : $('#deleted').removeAttr('checked'));
                    (response.data.cashless === 1 ? $('#cashless').attr('checked', 'checked') : $('#cashless').removeAttr('checked'));


                    //set error validation
                    $('#asr_cd').removeClass('is-invalid');
                    $('#asr_nm').removeClass('is-invalid');
                    $('#perjanjian_dt').removeClass('is-invalid');
                    $('#efektif_dt').removeClass('is-invalid');
                    $('#pic_nm').removeClass('is-invalid');
                    $('#pic_mobile_no').removeClass('is-invalid');
                    $('#pic_email').removeClass('is-invalid');
                    $('#pic_addr').removeClass('is-invalid');

                    $('.errorAsr_cd').html('');
                    $('.errorAsr_nm').html('');
                    $('.errorPerjanjian_dt').html('');
                    $('.errorEfektif_dt').html('');
                    $('.errorPic_nm').html('');
                    $('.errorPic_mobile_no').html('');
                    $('.errorPic_email').html('');
                    $('.errorPic_addr').html('');

                    //set selected data select2
                    // $('#asr_cd').val(response.data.asr_cd);
                    // $('#asr_cd').trigger('change');


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
            var asr_cd = $(this).data('asr_cd');
            if (confirm("Are you sure you want to remove it?")) {
                $.ajax({
                    url: "<?= site_url('tasuransi/delete'); ?>",
                    method: "POST",
                    data: {
                        asr_cd: asr_cd
                    },
                    dataType: "JSON",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                            //footer: '<a href="">Why do I have this issue?</a>'
                        });
                        tasuransi();
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