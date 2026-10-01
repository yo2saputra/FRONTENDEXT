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
                                                <?= $cb_patient ?>
                                                <label for="diagnosa" class="col-sm-2 col-form-label">Diagnosa</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="diagnosa" name="diagnosa">
                                                    <span class="error invalid-feedback errorReported_dt">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="alergi" class="col-sm-2 col-form-label">alergi</label>
                                                <div class="col-sm-4">
                                                    <textarea class="form-control form-control-sm" rows="3" placeholder="..." id="alergi" name="alergi" autocomplete="off"></textarea>
                                                    <span class="error invalid-feedback errorAlergi">
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
                                        <form action="<?= site_url("tpatientalergi/preview") ?>" id="uploadForm" method="post" enctype="multipart/form-data">
                                            <?= csrf_field(); ?>
                                            <label for="filename">Import Excel File : <a href="<?= site_url("tpatientalergi/download") ?>"><u>Download Format</u></a></label> <br>
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
    function tpatientalergi() {
        $.ajax({
            method: "get",
            url: "<?= site_url('/tpatientalergi/fetchAll'); ?>",
            success: function(data) {
                $('#viewdata').html(data);
            }
        });
    }

    function tpatientalergipreview() {
        $.ajax({
            method: "get",
            url: "<?= site_url('tpatientalergi/preview'); ?>",
            success: function(data) {
                $('#viewpreview').html(data);
            }
        });
    }

    $(document).ready(function() {
        tpatientalergi()

        $(document).on('click', '#add_record', function() {
            //set input
            $('#reported_dt').removeAttr('disabled');
            $('#alergi').removeAttr('disabled');
            $('#patient_no').removeAttr('disabled');
            $('#patient_no').removeAttr('checked');

            $('#data_form')[0].reset();

            //set error validation
            $('#reported_dt').removeClass('is-invalid');
            $('#alergi').removeClass('is-invalid');
            $('#patient_no').removeClass('is-invalid');
            $('.errorReported_dt').html('');
            $('.errorAlergi').html('');
            $('.errorPatient_no').html('');

            //set selected data select2
            $('#patient_no').val(' ');
            $('#patient_no').trigger('change');

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
                url: "<?= site_url('tpatientalergi/action'); ?>",
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
                        if (response.error.diagnosa) {
                            $('#reported_dt').addClass('is-invalid');
                            $('.errorReported_dt').html(response.error.diagnosa);
                        } else {
                            $('#reported_dt').removeClass('is-invalid');
                            $('.errorReported_dt').html('');
                        }
                        if (response.error.alergi) {
                            $('#alergi').addClass('is-invalid');
                            $('.errorAlergi').html(response.error.alergi);
                        } else {
                            $('#alergi').removeClass('is-invalid');
                            $('.errorAlergi').html('');
                        }
                        if (response.error.diag_sta_id) {
                            $('#patient_no').addClass('is-invalid');
                            $('.errorPatient_no').html(response.error.diag_sta_id);
                        } else {
                            $('#patient_no').removeClass('is-invalid');
                            $('.errorPatient_no').html('');
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
                        $('#reported_dt').removeClass('is-invalid');
                        $('#alergi').removeClass('is-invalid');
                        $('#patient_no').removeClass('is-invalid');
                        $('#reported_dt').val('');
                        $('#alergi').val('');
                        $('#patient_no').removeAttr('checked');

                        tpatientalergi();
                        $('#modalform').modal('hide');
                    }
                },
            })
        });

        $(document).on('click', '.view', function() {
            var patient_no = $(this).data('patient_no');

            $.ajax({
                url: "<?= site_url('tpatientalergi/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    patient_no: patient_no
                },
                dataType: "JSON",
                success: function(response) {
                    //set input
                    $('#reported_dt').attr('disabled', '');
                    $('#alergi').attr('disabled', '');
                    $('#patient_no').attr('disabled', '');
                    $('#patient_no').removeAttr('checked');

                    $('#data_form')[0].reset();

                    //set data from response record
                    $('#reported_dt').val(response.data.diagnosa);
                    $('#alergi').val(response.data.alergi);

                    //set error validation
                    $('#reported_dt').removeClass('is-invalid');
                    $('#alergi').removeClass('is-invalid');
                    $('#patient_no').removeClass('is-invalid');
                    $('.errorReported_dt').html('');
                    $('.errorAlergi').html('');
                    $('.errorPatient_no').html('');

                    //set selected data select2
                    $('#patient_no').val(response.data.diag_sta_id);
                    $('#patient_no').trigger('change');

                    //set modal & form
                    $('.modal-title').text('Lihat Data');
                    $('#action').val('View');
                    $('#submit_button').hide();
                    $('#submit_button').val('Lihat');
                    $('#submit_button').html('Lihat');
                    $('#modalform').modal('show');
                    $('#hidden_id').val(patient_no);
                }
            })
        });

        $(document).on('click', '.edit', function() {
            var patient_no = $(this).data('patient_no');

            $.ajax({
                url: "<?= site_url('tpatientalergi/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    patient_no: patient_no
                },
                dataType: "JSON",
                success: function(response) {
                    //set input
                    $('#reported_dt').removeAttr('disabled');
                    $('#alergi').removeAttr('disabled');
                    $('#patient_no').removeAttr('disabled');
                    $('#patient_no').removeAttr('checked');

                    $('#data_form')[0].reset();

                    //set data from response record
                    $('#reported_dt').val(response.data.diagnosa);
                    $('#alergi').val(response.data.alergi);

                    //set error validation
                    $('#reported_dt').removeClass('is-invalid');
                    $('#alergi').removeClass('is-invalid');
                    $('#patient_no').removeClass('is-invalid');
                    $('.errorReported_dt').html('');
                    $('.errorAlergi').html('');
                    $('.errorPatient_no').html('');

                    //set selected data select2
                    $('#patient_no').val(response.data.diag_sta_id);
                    $('#patient_no').trigger('change');

                    //set modal & form
                    $('.modal-title').text('Ubah Data');
                    $('#action').val('Edit');
                    $('#submit_button').show();
                    $('#submit_button').val('Simpan');
                    $('#submit_button').html('Simpan');
                    $('#modalform').modal('show');
                }
            })
        });

        $(document).on('click', '.delete', function() {
            var patient_no = $(this).data('patient_no');
            if (confirm("Are you sure you want to remove it?")) {
                $.ajax({
                    url: "<?= site_url('tpatientalergi/delete'); ?>",
                    method: "POST",
                    data: {
                        patient_no: patient_no
                    },
                    dataType: "JSON",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                            //footer: '<a href="">Why do I have this issue?</a>'
                        });
                        tpatientalergi();
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
                url: '/tpatientalergi/preview',
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
                    tpatientalergipreview();
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                }
            });
        });


    });
</script>



<?= $this->endSection('script'); ?>