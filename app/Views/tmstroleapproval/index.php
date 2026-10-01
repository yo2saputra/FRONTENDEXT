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
                                                <label for="warehouse_cd" class="col-sm-2 col-form-label">Kode</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="warehouse_cd" name="warehouse_cd">
                                                    <span class="error invalid-feedback errorDiagnosa_cd">
                                                    </span>
                                                </div>
                                                <label for="warehouse_nm" class="col-sm-2 col-form-label">Warehouse</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="warehouse_nm" name="warehouse_nm">
                                                    <span class="error invalid-feedback errorDiagnosa">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <!-- <label for="lokasi" class="col-sm-2 col-form-label">lokasi</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="lokasi" name="lokasi">
                                                    <span class="error invalid-feedback errorKeterangan">
                                                    </span>
                                                </div> -->
                                                <label for="lokasi" class="col-sm-2 col-form-label">Lokasi</label>
                                                <div class="col-sm-4">
                                                    <textarea class="form-control form-control-sm" rows="3" placeholder="..." id="lokasi" name="lokasi" autocomplete="off"></textarea>
                                                    <span class="error invalid-feedback errorKeterangan">
                                                    </span>
                                                </div>
                                                <?= $cb_aktif ?>
                                            </div>
                                            <!-- <div class="mb-3 row">
                                                <label for="poly_sta_id" class="col-sm-2 col-form-label"></label>
                                                <div class="col-sm-10">
                                                    <div class="icheck-primary d-inline">
                                                        <input type="checkbox" id="poly_sta_id" name="poly_sta_id" checked>
                                                        <label for="poly_sta_id">Aktif
                                                        </label>
                                                    </div>
                                                    <span class="error invalid-feedback errorPoly_sta_id">
                                                    </span>
                                                </div>
                                            </div> -->



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
                                        <form action="<?= site_url("tmstwarehouse/preview") ?>" id="uploadForm" method="post" enctype="multipart/form-data">
                                            <?= csrf_field(); ?>
                                            <label for="filename">Import Excel File : <a href="<?= site_url("tmstwarehouse/download") ?>"><u>Download Format</u></a></label> <br>
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
    function tmstwarehouse() {
        $.ajax({
            method: "get",
            url: "<?= site_url('/tmstwarehouse/fetchAll'); ?>",
            success: function(data) {
                $('#viewdata').html(data);
            }
        });
    }

    function tmstdiagnosapreview() {
        $.ajax({
            method: "get",
            url: "<?= site_url('tmstwarehouse/preview'); ?>",
            success: function(data) {
                $('#viewpreview').html(data);
            }
        });
    }

    $(document).ready(function() {
        tmstwarehouse()

        $(document).on('click', '#add_record', function() {
            //set input
            $('#warehouse_cd').attr('disabled', '');
            // $('#warehouse_cd').removeAttr('disabled');
            $('#warehouse_nm').removeAttr('disabled');
            $('#lokasi').removeAttr('disabled');
            $('#warehouse_sta_id').removeAttr('disabled');
            $('#warehouse_cd').removeAttr('readonly');
            $('#warehouse_sta_id').removeAttr('checked');

            $('#data_form')[0].reset();

            //set error validation
            $('#warehouse_cd').removeClass('is-invalid');
            $('#warehouse_nm').removeClass('is-invalid');
            $('#lokasi').removeClass('is-invalid');
            $('#warehouse_sta_id').removeClass('is-invalid');
            $('.errorDiagnosa_cd').html('');
            $('.errorDiagnosa').html('');
            $('.errorKeterangan').html('');
            $('.errorDiag_sta_id').html('');

            //set selected data select2
            $('#warehouse_sta_id').val(' ');
            $('#warehouse_sta_id').trigger('change');

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
                url: "<?= site_url('tmstwarehouse/action'); ?>",
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
                        if (response.error.warehouse_cd) {
                            $('#warehouse_cd').addClass('is-invalid');
                            $('.errorDiagnosa_cd').html(response.error.warehouse_cd);
                        } else {
                            $('#warehouse_cd').removeClass('is-invalid');
                            $('.errorDiagnosa_cd').html('');
                        }
                        if (response.error.warehouse_nm) {
                            $('#warehouse_nm').addClass('is-invalid');
                            $('.errorDiagnosa').html(response.error.warehouse_nm);
                        } else {
                            $('#warehouse_nm').removeClass('is-invalid');
                            $('.errorDiagnosa').html('');
                        }
                        if (response.error.lokasi) {
                            $('#lokasi').addClass('is-invalid');
                            $('.errorKeterangan').html(response.error.lokasi);
                        } else {
                            $('#lokasi').removeClass('is-invalid');
                            $('.errorKeterangan').html('');
                        }
                        if (response.error.warehouse_sta_id) {
                            $('#warehouse_sta_id').addClass('is-invalid');
                            $('.errorDiag_sta_id').html(response.error.warehouse_sta_id);
                        } else {
                            $('#warehouse_sta_id').removeClass('is-invalid');
                            $('.errorDiag_sta_id').html('');
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
                        $('#warehouse_cd').removeClass('is-invalid');
                        $('#warehouse_nm').removeClass('is-invalid');
                        $('#lokasi').removeClass('is-invalid');
                        $('#warehouse_sta_id').removeClass('is-invalid');
                        $('#warehouse_cd').val('');
                        $('#warehouse_nm').val('');
                        $('#lokasi').val('');
                        $('#warehouse_sta_id').removeAttr('checked');

                        tmstwarehouse();
                        $('#modalform').modal('hide');
                    }
                },
            })
        });

        $(document).on('click', '.view', function() {
            var warehouse_cd = $(this).data('warehouse_cd');

            $.ajax({
                url: "<?= site_url('tmstwarehouse/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    warehouse_cd: warehouse_cd
                },
                dataType: "JSON",
                success: function(response) {
                    //set input
                    $('#warehouse_cd').attr('disabled', '');
                    $('#warehouse_nm').attr('disabled', '');
                    $('#lokasi').attr('disabled', '');
                    $('#warehouse_sta_id').attr('disabled', '');
                    $('#warehouse_sta_id').removeAttr('checked');

                    $('#data_form')[0].reset();

                    //set data from response record
                    $('#warehouse_cd').val(response.data.warehouse_cd);
                    $('#warehouse_nm').val(response.data.warehouse_nm);
                    $('#lokasi').val(response.data.lokasi);

                    //set error validation
                    $('#warehouse_cd').removeClass('is-invalid');
                    $('#warehouse_nm').removeClass('is-invalid');
                    $('#lokasi').removeClass('is-invalid');
                    $('#warehouse_sta_id').removeClass('is-invalid');
                    $('.errorDiagnosa_cd').html('');
                    $('.errorDiagnosa').html('');
                    $('.errorKeterangan').html('');
                    $('.errorDiag_sta_id').html('');

                    //set selected data select2
                    $('#warehouse_sta_id').val(response.data.warehouse_sta_id);
                    $('#warehouse_sta_id').trigger('change');

                    //set modal & form
                    $('.modal-title').text('Lihat Data');
                    $('#action').val('View');
                    $('#submit_button').hide();
                    $('#submit_button').val('Lihat');
                    $('#submit_button').html('Lihat');
                    $('#modalform').modal('show');
                    $('#hidden_id').val(warehouse_cd);
                }
            })
        });

        $(document).on('click', '.edit', function() {
            var warehouse_cd = $(this).data('warehouse_cd');

            $.ajax({
                url: "<?= site_url('tmstwarehouse/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    warehouse_cd: warehouse_cd
                },
                dataType: "JSON",
                success: function(response) {
                    //set input
                    $('#warehouse_cd').removeAttr('disabled');
                    $('#warehouse_nm').removeAttr('disabled');
                    $('#lokasi').removeAttr('disabled');
                    $('#warehouse_sta_id').removeAttr('disabled');
                    $('#warehouse_cd').attr('readonly', '');
                    $('#warehouse_sta_id').removeAttr('checked');

                    $('#data_form')[0].reset();

                    //set data from response record
                    $('#warehouse_cd').val(response.data.warehouse_cd);
                    $('#warehouse_nm').val(response.data.warehouse_nm);
                    $('#lokasi').val(response.data.lokasi);

                    //set error validation
                    $('#warehouse_cd').removeClass('is-invalid');
                    $('#warehouse_nm').removeClass('is-invalid');
                    $('#lokasi').removeClass('is-invalid');
                    $('#warehouse_sta_id').removeClass('is-invalid');
                    $('.errorDiagnosa_cd').html('');
                    $('.errorDiagnosa').html('');
                    $('.errorKeterangan').html('');
                    $('.errorDiag_sta_id').html('');

                    //set selected data select2
                    $('#warehouse_sta_id').val(response.data.warehouse_sta_id);
                    $('#warehouse_sta_id').trigger('change');

                    //set modal & form
                    $('.modal-title').text('Ubah Data');
                    $('#action').val('Edit');
                    $('#submit_button').show();
                    $('#submit_button').val('Simpan');
                    $('#submit_button').html('Simpan');
                    $('#modalform').modal('show');
                    // $('#hidden_id').val(warehouse_cd);
                }
            })
        });

        $(document).on('click', '.delete', function() {
            var warehouse_cd = $(this).data('warehouse_cd');
            if (confirm("Are you sure you want to remove it?")) {
                $.ajax({
                    url: "<?= site_url('tmstwarehouse/delete'); ?>",
                    method: "POST",
                    data: {
                        warehouse_cd: warehouse_cd
                    },
                    dataType: "JSON",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                            //footer: '<a href="">Why do I have this issue?</a>'
                        });
                        tmstwarehouse();
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

        $(document).on('click', '#import', function() {

            //set modal & form
            $('.modal-title').text('Import Data');
            $("#filename").val(null);
            $('#viewpreview').html('');
            $('#modalimport').modal('show');


        });

        $('#uploadForm').submit(function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            $.ajax({
                url: '/tmstwarehouse/preview',
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
                    tmstdiagnosapreview();
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                }
            });
        });


    });
</script>



<?= $this->endSection('script'); ?>