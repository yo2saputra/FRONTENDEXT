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
                                                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control form-control-sm" id="nama" name="nama" autofocus>
                                                    <span class="error invalid-feedback errorNama">
                                                    </span>
                                                </div>

                                            </div>
                                            <div class="mb-3 row">
                                                <label for="value" class="col-sm-2 col-form-label">Value</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control form-control-sm" id="value" name="value">
                                                    <span class="error invalid-feedback errorValue">
                                                    </span>
                                                </div>

                                            </div>
                                            <div class="mb-3 row">
                                                <label for="desc" class="col-sm-2 col-form-label">Desc</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control form-control-sm" id="desc" name="desc">
                                                    <span class="error invalid-feedback errorDesc">
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
    function controlparameter() {
        $.ajax({
            method: "get",
            url: "<?= site_url('controlparameter/fetchAll'); ?>",
            success: function(data) {
                $('#viewdata').html(data);
            }
        });
    }
    $(document).ready(function() {
        controlparameter()

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
            $('#nama').removeAttr('disabled');
            $('#value').removeAttr('disabled');
            $('#desc').removeAttr('disabled');
            $('#nama').removeAttr('readonly');

            $('#data_form')[0].reset();

            //set error validation
            $('#nama').removeClass('is-invalid');
            $('#value').removeClass('is-invalid');
            $('#desc').removeClass('is-invalid');
            $('.errorNama').html('');
            $('.errorValue').html('');
            $('.errorDesc').html('');

            //set modal & form
            $('.modal-title').text('Tambah Data');
            $('#action').val('Add');
            $('#submit_button').val('Simpan');
            $('#submit_button').html('Simpan');
            $('#modalform').modal('show');


        });

        $('#data_form').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "<?= site_url('controlparameter/action'); ?>",
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
                        if (response.error.nama) {
                            $('#nama').addClass('is-invalid');
                            $('.errorNama').html(response.error.nama);
                        } else {
                            $('#nama').removeClass('is-invalid');
                            $('.errorNama').html('');
                        }
                        if (response.error.value) {
                            $('#value').addClass('is-invalid');
                            $('.errorValue').html(response.error.value);
                        } else {
                            $('#value').removeClass('is-invalid');
                            $('.errorValue').html('');
                        }
                        if (response.error.desc) {
                            $('#desc').addClass('is-invalid');
                            $('.errorDesc').html(response.error.desc);
                        } else {
                            $('#desc').removeClass('is-invalid');
                            $('.errorDesc').html('');
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
                        $('#nama').removeClass('is-invalid');
                        $('#value').removeClass('is-invalid');
                        $('#desc').removeClass('is-invalid');
                        $('#nama').val('');
                        $('#value').val('');
                        $('#desc').val('');

                        controlparameter();
                        $('#modalform').modal('hide');
                    }
                },
            })
        });

        $(document).on('click', '.view', function() {
            var parm_nm = $(this).data('parm_nm');
            var parm_valu = $(this).data('parm_valu');

            $.ajax({
                url: "<?= site_url('controlparameter/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    parm_nm: parm_nm,
                    parm_valu: parm_valu
                },
                dataType: "JSON",
                success: function(response) {
                    //set input
                    $('#nama').attr('disabled', '');
                    $('#value').attr('disabled', '');
                    $('#desc').attr('disabled', '');
                    $('#nama').attr('readonly', '');

                    $('#data_form')[0].reset();

                    //set data from response record
                    $('#nama').val(response.data.nama);
                    $('#value').val(response.data.value);
                    $('#desc').val(response.data.desc);

                    //set error validation
                    $('#nama').removeClass('is-invalid');
                    $('#value').removeClass('is-invalid');
                    $('#desc').removeClass('is-invalid');
                    $('.errorNama').html('');
                    $('.errorValue').html('');
                    $('.errorDesc').html('');

                    //set selected data

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
            var parm_nm = $(this).data('parm_nm');
            var parm_valu = $(this).data('parm_valu');

            $.ajax({
                url: "<?= site_url('controlparameter/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    parm_nm: parm_nm,
                    parm_valu: parm_valu
                },
                dataType: "JSON",
                success: function(response) {
                    //set input
                    $('#nama').removeAttr('disabled');
                    $('#value').removeAttr('disabled');
                    $('#desc').removeAttr('disabled');
                    $('#nama').attr('readonly', '');

                    $('#data_form')[0].reset();

                    //set data from response record
                    $('#nama').val(response.data.nama);
                    $('#value').val(response.data.value);
                    $('#desc').val(response.data.desc);

                    //set error validation
                    $('#nama').removeClass('is-invalid');
                    $('#value').removeClass('is-invalid');
                    $('#desc').removeClass('is-invalid');
                    $('.errorNama').html('');
                    $('.errorValue').html('');
                    $('.errorDesc').html('');

                    //set selected data

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
            var parm_nm = $(this).data('parm_nm');
            var parm_valu = $(this).data('parm_valu');
            if (confirm("Are you sure you want to remove it?")) {
                $.ajax({
                    url: "<?= site_url('controlparameter/delete'); ?>",
                    method: "POST",
                    data: {
                        parm_nm: parm_nm,
                        parm_valu: parm_valu
                    },
                    dataType: "JSON",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                            //footer: '<a href="">Why do I have this issue?</a>'
                        });
                        controlparameter();
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