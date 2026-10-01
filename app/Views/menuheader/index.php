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
                                                <label for="id" class="col-sm-2 col-form-label">Id</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="id" name="id" disabled>
                                                    <span class="error invalid-feedback errorId">
                                                    </span>
                                                </div>
                                                <label for="header_nm" class="col-sm-2 col-form-label">Nama</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="header_nm" name="header_nm">
                                                    <span class="error invalid-feedback errorHeader_nm">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="header_order" class="col-sm-2 col-form-label">Order</label>
                                                <div class="col-sm-4">
                                                    <input min="0" type="number" class="form-control form-control-sm" id="header_order" name="header_order">
                                                    <span class="error invalid-feedback errorHeader_order">
                                                    </span>
                                                </div>
                                                <label for="header_icon" class="col-sm-2 col-form-label">Icon</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="header_icon" name="header_icon">
                                                    <span class="error invalid-feedback errorHeader_icon">
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
    function menuheader() {
        $.ajax({
            method: "get",
            url: "<?= site_url('/menuheader/fetchAll'); ?>",
            success: function(data) {
                $('#viewdata').html(data);
            }
        });
    }
    $(document).ready(function() {
        menuheader()

        $(document).on('click', '#add_record', function() {
            //set input
            $('#id').attr('disabled');
            $('#header_nm').removeAttr('disabled', '');
            $('#header_order').removeAttr('disabled', '');
            $('#header_icon').removeAttr('disabled', '');
            $('#id').removeAttr('readonly');
            $('#deleted').removeAttr('checked');

            $('#data_form')[0].reset();

            //set error validation
            $('#id').removeClass('is-invalid');
            $('#header_nm').removeClass('is-invalid');
            $('#header_order').removeClass('is-invalid');
            $('#header_icon').removeClass('is-invalid');
            $('.errorId').html('');
            $('.errorHeader_nm').html('');
            $('.errorHeader_order').html('');
            $('.errorHeader_icon').html('');

            //set selected data select2
            $('#id').val(' ');
            $('#id').trigger('change');

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
                url: "<?= site_url('menuheader/action'); ?>",
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
                        if (response.error.id) {
                            $('#id').addClass('is-invalid');
                            $('.errorId').html(response.error.id);
                        } else {
                            $('#id').removeClass('is-invalid');
                            $('.errorId').html('');
                        }
                        if (response.error.header_nm) {
                            $('#header_nm').addClass('is-invalid');
                            $('.errorHeader_nm').html(response.error.header_nm);
                        } else {
                            $('#header_nm').removeClass('is-invalid');
                            $('.errorHeader_nm').html('');
                        }
                        if (response.error.header_order) {
                            $('#header_order').addClass('is-invalid');
                            $('.errorHeader_order').html(response.error.header_order);
                        } else {
                            $('#header_order').removeClass('is-invalid');
                            $('.errorHeader_order').html('');
                        }
                        if (response.error.header_icon) {
                            $('#header_icon').addClass('is-invalid');
                            $('.errorHeader_icon').html(response.error.header_icon);
                        } else {
                            $('#header_icon').removeClass('is-invalid');
                            $('.errorHeader_icon').html('');
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
                        $('#id').removeClass('is-invalid');
                        $('#header_nm').removeClass('is-invalid');
                        $('#header_order').removeClass('is-invalid');
                        $('#header_icon').removeClass('is-invalid');
                        $('#id').val('');
                        $('#header_nm').val('');
                        $('#header_order').val('');
                        $('#header_icon').val('');

                        menuheader();
                        $('#modalform').modal('hide');
                    }
                },
            })
        });

        $(document).on('click', '.view', function() {
            var id = $(this).data('id');

            $.ajax({
                url: "<?= site_url('menuheader/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(response) {
                    //set input
                    $('#id').attr('disabled', '');
                    $('#header_nm').attr('disabled', '');
                    $('#header_order').attr('disabled', '');
                    $('#header_icon').attr('disabled', '');

                    $('#data_form')[0].reset();

                    //set data from response record
                    $('#id').val(response.data.id);
                    $('#header_nm').val(response.data.header_nm);
                    $('#header_order').val(response.data.header_order);
                    $('#header_icon').val(response.data.header_icon);

                    //set error validation
                    $('#id').removeClass('is-invalid');
                    $('#header_nm').removeClass('is-invalid');
                    $('#header_order').removeClass('is-invalid');
                    $('#header_icon').removeClass('is-invalid');
                    $('.errorid').html('');
                    $('.errorHeader_nm').html('');
                    $('.errorHeader_order').html('');
                    $('.errorHeader_icon').html('');

                    //set selected data select2

                    //set modal & form
                    $('.modal-title').text('Lihat Data');
                    $('#action').val('View');
                    $('#submit_button').hide();
                    $('#submit_button').val('Lihat');
                    $('#submit_button').html('Lihat');
                    $('#modalform').modal('show');
                    $('#hidden_id').val(id);
                }
            })
        });

        $(document).on('click', '.edit', function() {
            var id = $(this).data('id');

            $.ajax({
                url: "<?= site_url('menuheader/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(response) {
                    //set input
                    $('#id').removeAttr('disabled', '');
                    $('#header_nm').removeAttr('disabled', '');
                    $('#header_order').removeAttr('disabled', '');
                    $('#header_icon').removeAttr('disabled', '');
                    $('#id').attr('readonly', '');

                    $('#data_form')[0].reset();

                    //set data from response record
                    $('#id').val(response.data.id);
                    $('#header_nm').val(response.data.header_nm);
                    $('#header_order').val(response.data.header_order);
                    $('#header_icon').val(response.data.header_icon);

                    //set error validation
                    $('#id').removeClass('is-invalid');
                    $('#header_nm').removeClass('is-invalid');
                    $('#header_order').removeClass('is-invalid');
                    $('#header_icon').removeClass('is-invalid');
                    $('.errorid').html('');
                    $('.errorHeader_nm').html('');
                    $('.errorHeader_order').html('');
                    $('.errorHeader_icon').html('');

                    //set selected data select2

                    //set modal & form
                    $('.modal-title').text('Ubah Data');
                    $('#action').val('Edit');
                    $('#submit_button').show();
                    $('#submit_button').val('Ubah');
                    $('#submit_button').html('Ubah');
                    $('#modalform').modal('show');
                    $('#hidden_id').val(id);
                }
            })
        });

        $(document).on('click', '.delete', function() {
            var id = $(this).data('id');
            if (confirm("Are you sure you want to remove it?")) {
                $.ajax({
                    url: "<?= site_url('menuheader/delete'); ?>",
                    method: "POST",
                    data: {
                        id: id
                    },
                    dataType: "JSON",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                            //footer: '<a href="">Why do I have this issue?</a>'
                        });
                        menuheader();
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