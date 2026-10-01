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
                                                <label for="KodeCaraBayar" class="col-sm-2 col-form-label">Kode</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="KodeCaraBayar" name="KodeCaraBayar">
                                                    <span class="error invalid-feedback errorKodeCaraBayar">
                                                    </span>
                                                </div>
                                                <label for="DescriptionCaraBayar" class="col-sm-2 col-form-label">Description</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="DescriptionCaraBayar" name="DescriptionCaraBayar">
                                                    <span class="error invalid-feedback errorDescriptionCaraBayar">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <!-- <label for="Type" class="col-sm-2 col-form-label">Type</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="Type" name="Type">
                                                    <span class="error invalid-feedback errorType">
                                                    </span>
                                                </div> -->
                                                <?= $cb_type ?>
                                                <?= $cb_integrated_module ?>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="MarkupPercentage" class="col-sm-2 col-form-label">Markup Peercentage</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control form-control-sm text-right" id="MarkupPercentage" name="MarkupPercentage">
                                                    <span class="error invalid-feedback errorMarkupPercentage">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <?= $cb_glcoa ?>
                                                <!-- <label for="AccountDescription" class="col-sm-2 col-form-label">Account Desc</label> -->
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control form-control-sm" id="AccountDescription" name="AccountDescription" readonly>
                                                    <span class="error invalid-feedback errorAccountDescription">
                                                    </span>
                                                </div>
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
                                        <form action="<?= site_url("tmstcarabayar/preview") ?>" id="uploadForm" method="post" enctype="multipart/form-data">
                                            <?= csrf_field(); ?>
                                            <label for="filename">Import Excel File : <a href="<?= site_url("tmstcarabayar/download") ?>"><u>Download Format</u></a></label> <br>
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
    $('#AccountNo.select2custom').on('change', function() {
        const selectedOption = $(this).find('option:selected');
        const desc = selectedOption.data('desc');
        $('#AccountDescription').val(desc);
    });

    function tmstwarehouse() {
        $.ajax({
            method: "get",
            url: "<?= site_url('/tmstcarabayar/fetchAll'); ?>",
            success: function(data) {
                $('#viewdata').html(data);
            }
        });
    }

    function tmstdiagnosapreview() {
        $.ajax({
            method: "get",
            url: "<?= site_url('tmstcarabayar/preview'); ?>",
            success: function(data) {
                $('#viewpreview').html(data);
            }
        });
    }

    $(document).ready(function() {
        tmstwarehouse()

        $(document).on('click', '#add_record', function() {
            //set input
            $('#KodeCaraBayar').attr('disabled', '');
            // $('#KodeCaraBayar').removeAttr('disabled');
            $('#DescriptionCaraBayar').removeAttr('disabled');
            $('#MarkupPercentage').removeAttr('disabled');
            $('#Type').removeAttr('disabled');
            $('#Type').removeAttr('checked');
            $('#IntegratedModule').removeAttr('disabled');
            $('#IntegratedModule').removeAttr('checked');
            $('#KodeCaraBayar').removeAttr('readonly');


            $('#data_form')[0].reset();

            //set error validation
            $('#KodeCaraBayar').removeClass('is-invalid');
            $('#DescriptionCaraBayar').removeClass('is-invalid');
            $('#Type').removeClass('is-invalid');
            $('#MarkupPercentage').removeClass('is-invalid');
            $('#IntegratedModule').removeClass('is-invalid');
            $('.errorKodeCaraBayar').html('');
            $('.errorDescriptionCaraBayar').html('');
            $('.errorType').html('');
            $('.errorDiag_sta_id').html('');

            //set selected data select2
            $('#Type').val(' ');
            $('#Type').trigger('change');
            $('#IntegratedModule').val(' ');
            $('#IntegratedModule').trigger('change');
            $('#AccountNo').val(' ');
            $('#AccountNo').trigger('change');

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
                url: "<?= site_url('tmstcarabayar/action'); ?>",
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
                        if (response.error.KodeCaraBayar) {
                            $('#KodeCaraBayar').addClass('is-invalid');
                            $('.errorKodeCaraBayar').html(response.error.KodeCaraBayar);
                        } else {
                            $('#KodeCaraBayar').removeClass('is-invalid');
                            $('.errorKodeCaraBayar').html('');
                        }
                        if (response.error.warehouse_nm) {
                            $('#warehouse_nm').addClass('is-invalid');
                            $('.errorDescriptionCaraBayar').html(response.error.warehouse_nm);
                        } else {
                            $('#warehouse_nm').removeClass('is-invalid');
                            $('.errorDescriptionCaraBayar').html('');
                        }
                        if (response.error.Type) {
                            $('#Type').addClass('is-invalid');
                            $('.errorType').html(response.error.Type);
                        } else {
                            $('#Type').removeClass('is-invalid');
                            $('.errorType').html('');
                        }
                        if (response.error.IntegratedModule) {
                            $('#IntegratedModule').addClass('is-invalid');
                            $('.errorDiag_sta_id').html(response.error.IntegratedModule);
                        } else {
                            $('#IntegratedModule').removeClass('is-invalid');
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
                        $('#KodeCaraBayar').removeClass('is-invalid');
                        $('#warehouse_nm').removeClass('is-invalid');
                        $('#Type').removeClass('is-invalid');
                        $('#IntegratedModule').removeClass('is-invalid');
                        $('#KodeCaraBayar').val('');
                        $('#warehouse_nm').val('');
                        $('#Type').val('');
                        $('#IntegratedModule').removeAttr('checked');

                        tmstwarehouse();
                        $('#modalform').modal('hide');
                    }
                },
            })
        });

        $(document).on('click', '.view', function() {
            var KodeCaraBayar = $(this).data('kodecarabayar');

            $.ajax({
                url: "<?= site_url('tmstcarabayar/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    KodeCaraBayar: KodeCaraBayar
                },
                dataType: "JSON",
                success: function(response) {
                    //set input
                    $('#KodeCaraBayar').attr('disabled', '');
                    $('#warehouse_nm').attr('disabled', '');
                    // $('#Type').attr('disabled', '');
                    $('#Type').attr('disabled', '');
                    $('#Type').removeAttr('checked');
                    $('#IntegratedModule').attr('disabled', '');
                    $('#IntegratedModule').removeAttr('checked');
                    $('#DescriptionCaraBayar').attr('disabled', '');
                    $('#MarkupPercentage').attr('disabled', '');
                    $('#AccountDescription').attr('disabled', '');
                    $('#AccountNo').attr('disabled', '');
                    $('#AccountNo').removeAttr('checked');

                    $('#data_form')[0].reset();

                    //set data from response record
                    $('#KodeCaraBayar').val(response.data.KodeCaraBayar);
                    $('#warehouse_nm').val(response.data.warehouse_nm);
                    $('#MarkupPercentage').val(response.data.MarkupPercentage);
                    $('#DescriptionCaraBayar').val(response.data.DescriptionCaraBayar);
                    $('#AccountDescription').val(response.data.AccountDescription);

                    //set error validation
                    $('#KodeCaraBayar').removeClass('is-invalid');
                    $('#warehouse_nm').removeClass('is-invalid');
                    $('#Type').removeClass('is-invalid');
                    $('#IntegratedModule').removeClass('is-invalid');
                    $('.errorKodeCaraBayar').html('');
                    $('.errorDescriptionCaraBayar').html('');
                    $('.errorMarkupPercentage').html('');
                    $('.errorType').html('');
                    $('.errorDiag_sta_id').html('');
                    $('#AccountNo').removeClass('is-invalid');

                    //set selected data select2
                    $('#Type').val(response.data.Type);
                    $('#Type').trigger('change');
                    $('#IntegratedModule').val(response.data.IntegratedModule);
                    $('#IntegratedModule').trigger('change');
                    $('#AccountNo').val(response.data.AccountNo);
                    $('#AccountNo').trigger('change');

                    //set modal & form
                    $('.modal-title').text('Lihat Data');
                    $('#action').val('View');
                    $('#submit_button').hide();
                    $('#submit_button').val('Lihat');
                    $('#submit_button').html('Lihat');
                    $('#modalform').modal('show');
                    $('#hidden_id').val(KodeCaraBayar);
                }
            })
        });

        $(document).on('click', '.edit', function() {
            var KodeCaraBayar = $(this).data('kodecarabayar');

            $.ajax({
                url: "<?= site_url('tmstcarabayar/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    KodeCaraBayar: KodeCaraBayar
                },
                dataType: "JSON",
                success: function(response) {
                    //set input
                    $('#KodeCaraBayar').removeAttr('disabled');
                    $('#warehouse_nm').removeAttr('disabled');
                    $('#Type').removeAttr('disabled');
                    // $('#IntegratedModule').removeAttr('disabled');
                    $('#KodeCaraBayar').attr('readonly', '');
                    $('#IntegratedModule').removeAttr('disabled');
                    $('#IntegratedModule').removeAttr('checked');
                    $('#DescriptionCaraBayar').removeAttr('disabled');
                    $('#MarkupPercentage').removeAttr('disabled');
                    $('#AccountDescription').removeAttr('disabled');
                    $('#AccountNo').removeAttr('disabled');
                    $('#AccountNo').removeAttr('checked');


                    $('#data_form')[0].reset();

                    //set data from response record
                    $('#KodeCaraBayar').val(response.data.KodeCaraBayar);
                    $('#warehouse_nm').val(response.data.warehouse_nm);
                    $('#MarkupPercentage').val(response.data.MarkupPercentage);
                    $('#DescriptionCaraBayar').val(response.data.DescriptionCaraBayar);
                    $('#AccountDescription').val(response.data.AccountDescription);

                    //set error validation
                    $('#KodeCaraBayar').removeClass('is-invalid');
                    $('#warehouse_nm').removeClass('is-invalid');
                    $('#Type').removeClass('is-invalid');
                    $('#IntegratedModule').removeClass('is-invalid');
                    $('.errorKodeCaraBayar').html('');
                    $('.errorDescriptionCaraBayar').html('');
                    $('.errorMarkupPercentage').html('');
                    $('.errorType').html('');
                    $('.errorDiag_sta_id').html('');
                    $('#AccountNo').removeClass('is-invalid');

                    //set selected data select2
                    $('#Type').val(response.data.Type);
                    $('#Type').trigger('change');
                    $('#IntegratedModule').val(response.data.IntegratedModule);
                    $('#IntegratedModule').trigger('change');
                    $('#AccountNo').val(response.data.AccountNo);
                    $('#AccountNo').trigger('change');

                    //set modal & form
                    $('.modal-title').text('Ubah Data');
                    $('#action').val('Edit');
                    $('#submit_button').show();
                    $('#submit_button').val('Simpan');
                    $('#submit_button').html('Simpan');
                    $('#modalform').modal('show');
                    // $('#hidden_id').val(KodeCaraBayar);
                }
            })
        });

        $(document).on('click', '.delete', function() {
            var KodeCaraBayar = $(this).data('kodecarabayar');
            alert(KodeCaraBayar);
            if (confirm("Are you sure you want to remove it?")) {
                $.ajax({
                    url: "<?= site_url('tmstcarabayar/delete'); ?>",
                    method: "POST",
                    data: {
                        KodeCaraBayar: KodeCaraBayar
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
                url: '/tmstcarabayar/preview',
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