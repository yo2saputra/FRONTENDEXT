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
                                                <?= $cb_asuransi; ?>
                                                <label for="persen" class="col-sm-2 col-form-label">Persentase</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="persen" name="persen">
                                                    <span class="error invalid-feedback errorPersen">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="from_date" class="col-sm-2 col-form-label">From Date</label>
                                                <div class="col-sm-4">
                                                    <div class="input-group date from_date" data-date-format="mm/dd/yyyy">
                                                        <input type="text" class="form-control form-control-sm datepicker" placeholder="mm/dd/yyyy" id="from_date" name="from_date">
                                                        <div class="input-group-append" data-target="#from_date" data-toggle="from_date">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                    </div>
                                                    <span class="error invalid-feedback errorFrom_date">
                                                    </span>
                                                </div>
                                                <label for="to_date" class="col-sm-2 col-form-label">To Date</label>
                                                <div class="col-sm-4">
                                                    <div class="input-group date to_date" data-date-format="mm/dd/yyyy">
                                                        <input type="text" class="form-control form-control-sm datepicker" placeholder="mm/dd/yyyy" id="to_date" name="to_date">
                                                        <div class="input-group-append" data-target="#to_date" data-toggle="to_date">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                    </div>
                                                    <span class="error invalid-feedback errorTo_date">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">

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
    $('#from_date').datepicker({
        todayHighlight: true,
        autoclose: true,
        dateFormat: 'MM/DD/YYYY'
    }).val();
    $('#to_date').datepicker({
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
    function tpersen() {
        $.ajax({
            method: "get",
            url: "<?= site_url('/tasuransipersen/fetchAll'); ?>",
            success: function(data) {
                $('#viewdata').html(data);
            }
        });
    }
    $(document).ready(function() {
        tpersen()

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
            $('#persen').removeAttr('disabled');
            $('#from_date').removeAttr('disabled');
            $('#to_date').removeAttr('disabled');
            $('#asr_cd').removeAttr('disabled');
            // $('#asr_cd').removeAttr('readonly');
            // $('#asr_cd').attr('readonly', '');

            $('#data_form')[0].reset();

            //set error validation
            $('#asr_cd').removeClass('is-invalid');
            $('#persen').removeClass('is-invalid');
            $('#from_date').removeClass('is-invalid');
            $('#to_date').removeClass('is-invalid');

            $('.errorAsr_cd').html('');
            $('.errorPersen').html('');
            $('.errorFrom_date').html('');
            $('.errorTo_date').html('');

            //set selected data select2
            $('#asr_cd').val(' ');
            $('#asr_cd').trigger('change');
            $('#asr_cd_v').attr('disabled', '');

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
                url: "<?= site_url('tasuransipersen/action'); ?>",
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
                        if (response.error.asr_cd) {
                            $('#asr_cd').addClass('is-invalid');
                            $('.errorAsr_cd').html(response.error.asr_cd);
                        } else {
                            $('#asr_cd').removeClass('is-invalid');
                            $('.errorAsr_cd').html('');
                        }
                        if (response.error.persen) {
                            $('#persen').addClass('is-invalid');
                            $('.errorPersen').html(response.error.persen);
                        } else {
                            $('#persen').removeClass('is-invalid');
                            $('.errorPersen').html('');
                        }
                        if (response.error.from_date) {
                            $('#from_date').addClass('is-invalid');
                            $('.errorFrom_date').html(response.error.from_date);
                        } else {
                            $('#from_date').removeClass('is-invalid');
                            $('.errorFrom_date').html('');
                        }
                        if (response.error.to_date) {
                            $('#to_date').addClass('is-invalid');
                            $('.errorTo_date').html(response.error.to_date);
                        } else {
                            $('#to_date').removeClass('is-invalid');
                            $('.errorTo_date').html('');
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
                        $('#persen').removeClass('is-invalid');
                        $('#from_date').removeClass('is-invalid');
                        $('#to_date').removeClass('is-invalid');

                        $('.errorAsr_cd').html('');
                        $('.errorPersen').html('');
                        $('.errorFrom_date').html('');
                        $('.errorTo_date').html('');

                        tpersen();
                        $('#modalform').modal('hide');
                    }
                },
            })
        });

        $(document).on('click', '.view', function() {
            var asr_cd = $(this).data('asr_cd');

            $.ajax({
                url: "<?= site_url('tasuransipersen/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    asr_cd: asr_cd
                },
                dataType: "JSON",
                success: function(response) {
                    //set input
                    $('#asr_cd').attr('disabled', '');
                    $('#persen').attr('disabled', '');
                    $('#from_date').attr('disabled', '');
                    $('#to_date').attr('disabled', '');

                    $('#asr_cd').attr('readonly', '');


                    $('#data_form')[0].reset();

                    // alert(response.data.asr_cd);
                    // alert(response.data.menu_nm);
                    // alert(response.data.reference);
                    // alert(response.data.header_id);

                    //set data from response record
                    $('#asr_cd').val(response.data.asr_cd);
                    $('#persen').val(response.data.persen);
                    $('#from_date').val(response.data.from_date);
                    $('#to_date').val(response.data.to_date);

                    //set error validation
                    $('#asr_cd').removeClass('is-invalid');
                    $('#persen').removeClass('is-invalid');
                    $('#from_date').removeClass('is-invalid');
                    $('#to_date').removeClass('is-invalid');

                    $('.errorAsr_cd').html('');
                    $('.errorPersen').html('');
                    $('.errorFrom_date').html('');
                    $('.errorTo_date').html('');

                    //set selected data select2
                    $('#asr_cd').val(response.data.asr_cd);
                    $('#asr_cd').trigger('change');

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
                url: "<?= site_url('tasuransipersen/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    asr_cd: asr_cd
                },
                dataType: "JSON",
                success: function(response) {
                    //set input
                    $('#asr_cd').removeAttr('disabled');
                    $('#persen').removeAttr('disabled');
                    $('#from_date').removeAttr('disabled');
                    $('#to_date').removeAttr('disabled');

                    $('#asr_cd').attr('disabled', '');

                    $('#data_form')[0].reset();

                    // alert(response.data.asr_cd);
                    // alert(response.data.menu_nm);
                    // alert(response.data.reference);
                    // alert(response.data.header_id);

                    //set datepicker input value
                    $('#from_date').datepicker('update', response.data.from_date);
                    $('#to_date').datepicker('update', response.data.to_date);

                    //set data from response record
                    $('#asr_cd').val(response.data.asr_cd);
                    $('#persen').val(response.data.persen);
                    $('#from_date').val(response.data.from_date);
                    $('#to_date').val(response.data.to_date);

                    //set error validation
                    $('#asr_cd').removeClass('is-invalid');
                    $('#persen').removeClass('is-invalid');
                    $('#from_date').removeClass('is-invalid');
                    $('#to_date').removeClass('is-invalid');

                    $('.errorAsr_cd').html('');
                    $('.errorPersen').html('');
                    $('.errorFrom_date').html('');
                    $('.errorTo_date').html('');

                    //set selected data select2
                    $('#asr_cd').val(response.data.asr_cd);
                    $('#asr_cd').trigger('change');


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
                    url: "<?= site_url('tasuransipersen/delete'); ?>",
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
                        tpersen();
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