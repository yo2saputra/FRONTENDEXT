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
                                                <label for="SupplierID" class="col-sm-2 col-form-label">Kode</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="SupplierID" name="SupplierID">
                                                    <span class="error invalid-feedback errorSupplierID">
                                                    </span>
                                                </div>
                                                <label for="NamaSupplier" class="col-sm-2 col-form-label">Supplier</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="NamaSupplier" name="NamaSupplier">
                                                    <span class="error invalid-feedback errorNamaSupplier">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <!-- <label for="Alamat" class="col-sm-2 col-form-label">Alamat</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="Alamat" name="Alamat">
                                                    <span class="error invalid-feedback errorKeterangan">
                                                    </span>
                                                </div> -->
                                                <label for="Alamat" class="col-sm-2 col-form-label">Alamat</label>
                                                <div class="col-sm-4">
                                                    <textarea class="form-control form-control-sm" rows="3" placeholder="..." id="Alamat" name="Alamat" autocomplete="off"></textarea>
                                                    <span class="error invalid-feedback errorAlamat">
                                                    </span>
                                                </div>
                                                <label for="Kontak" class="col-sm-2 col-form-label">Kontak</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="Kontak" name="Kontak">
                                                    <span class="error invalid-feedback errorKontak">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <?= $cb_aktif ?>
                                                <div class="col-sm-6"></div>
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
                                        <form action="<?= site_url("tmstsupplier/preview") ?>" id="uploadForm" method="post" enctype="multipart/form-data">
                                            <?= csrf_field(); ?>
                                            <label for="filename">Import Excel File : <a href="<?= site_url("tmstsupplier/download") ?>"><u>Download Format</u></a></label> <br>
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
    function tmstsupplier() {
        $.ajax({
            method: "get",
            url: "<?= site_url('/tmstsupplier/fetchAll'); ?>",
            success: function(data) {
                $('#viewdata').html(data);
            }
        });
    }

    function tmstdiagnosapreview() {
        $.ajax({
            method: "get",
            url: "<?= site_url('tmstsupplier/preview'); ?>",
            success: function(data) {
                $('#viewpreview').html(data);
            }
        });
    }

    $(document).ready(function() {
        tmstsupplier()

        $(document).on('click', '#add_record', function() {
            //set input
            $('#SupplierID').attr('disabled', '');
            // $('#SupplierID').removeAttr('disabled');
            $('#NamaSupplier').removeAttr('disabled');
            $('#Alamat').removeAttr('disabled');
            $('#Kontak').removeAttr('disabled');
            $('#SupplierStaID').removeAttr('disabled');
            $('#SupplierID').removeAttr('readonly');
            $('#SupplierStaID').removeAttr('checked');

            $('#data_form')[0].reset();

            //set error validation
            $('#SupplierID').removeClass('is-invalid');
            $('#NamaSupplier').removeClass('is-invalid');
            $('#Alamat').removeClass('is-invalid');
            $('#Kontak').removeClass('is-invalid');
            $('#SupplierStaID').removeClass('is-invalid');
            $('.errorSupplierID').html('');
            $('.errorNamaSupplier').html('');
            $('.errorAlamat').html('');
            $('.errorSupplierStaID').html('');

            //set selected data select2
            $('#SupplierStaID').val(' ');
            $('#SupplierStaID').trigger('change');

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
                url: "<?= site_url('tmstsupplier/action'); ?>",
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
                        if (response.error.SupplierID) {
                            $('#SupplierID').addClass('is-invalid');
                            $('.errorSupplierID').html(response.error.SupplierID);
                        } else {
                            $('#SupplierID').removeClass('is-invalid');
                            $('.errorSupplierID').html('');
                        }
                        if (response.error.NamaSupplier) {
                            $('#NamaSupplier').addClass('is-invalid');
                            $('.errorNamaSupplier').html(response.error.NamaSupplier);
                        } else {
                            $('#NamaSupplier').removeClass('is-invalid');
                            $('.errorNamaSupplier').html('');
                        }
                        if (response.error.Alamat) {
                            $('#Alamat').addClass('is-invalid');
                            $('.errorAlamat').html(response.error.Alamat);
                        } else {
                            $('#Alamat').removeClass('is-invalid');
                            $('.errorAlamat').html('');
                        }
                        if (response.error.Kontak) {
                            $('#Kontak').addClass('is-invalid');
                            $('.errorKontak').html(response.error.Kontak);
                        } else {
                            $('#Kontak').removeClass('is-invalid');
                            $('.errorKontak').html('');
                        }
                        if (response.error.SupplierStaID) {
                            $('#SupplierStaID').addClass('is-invalid');
                            $('.errorSupplierStaID').html(response.error.SupplierStaID);
                        } else {
                            $('#SupplierStaID').removeClass('is-invalid');
                            $('.errorSupplierStaID').html('');
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
                        $('#SupplierID').removeClass('is-invalid');
                        $('#NamaSupplier').removeClass('is-invalid');
                        $('#Alamat').removeClass('is-invalid');
                        $('#Kontak').removeClass('is-invalid');
                        $('#SupplierStaID').removeClass('is-invalid');
                        $('#SupplierID').val('');
                        $('#NamaSupplier').val('');
                        $('#Alamat').val('');
                        $('#Kontak').val('');
                        $('#SupplierStaID').removeAttr('checked');

                        tmstsupplier();
                        $('#modalform').modal('hide');
                    }
                },
            })
        });

        $(document).on('click', '.view', function() {
            var SupplierID = $(this).data('supplierid');

            $.ajax({
                url: "<?= site_url('tmstsupplier/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    SupplierID: SupplierID
                },
                dataType: "JSON",
                success: function(response) {
                    //set input
                    $('#SupplierID').attr('disabled', '');
                    $('#NamaSupplier').attr('disabled', '');
                    $('#Alamat').attr('disabled', '');
                    $('#Kontak').attr('disabled', '');
                    $('#SupplierStaID').attr('disabled', '');
                    $('#SupplierStaID').removeAttr('checked');

                    $('#data_form')[0].reset();

                    //set data from response record
                    $('#SupplierID').val(response.data.SupplierID);
                    $('#NamaSupplier').val(response.data.NamaSupplier);
                    $('#Alamat').val(response.data.Alamat);
                    $('#Kontak').val(response.data.Kontak);

                    //set error validation
                    $('#SupplierID').removeClass('is-invalid');
                    $('#NamaSupplier').removeClass('is-invalid');
                    $('#Alamat').removeClass('is-invalid');
                    $('#Kontak').removeClass('is-invalid');
                    $('#SupplierStaID').removeClass('is-invalid');
                    $('.errorSupplierID').html('');
                    $('.errorNamaSupplier').html('');
                    $('.errorAlamat').html('');
                    $('.errorKontak').html('');
                    $('.errorSupplierStaID').html('');

                    //set selected data select2
                    $('#SupplierStaID').val(response.data.SupplierStaID);
                    $('#SupplierStaID').trigger('change');

                    //set modal & form
                    $('.modal-title').text('Lihat Data');
                    $('#action').val('View');
                    $('#submit_button').hide();
                    $('#submit_button').val('Lihat');
                    $('#submit_button').html('Lihat');
                    $('#modalform').modal('show');
                    $('#hidden_id').val(SupplierID);
                }
            })
        });

        $(document).on('click', '.edit', function() {
            var SupplierID = $(this).data('supplierid');

            $.ajax({
                url: "<?= site_url('tmstsupplier/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    SupplierID: SupplierID
                },
                dataType: "JSON",
                success: function(response) {
                    //set input
                    $('#SupplierID').removeAttr('disabled');
                    $('#NamaSupplier').removeAttr('disabled');
                    $('#Alamat').removeAttr('disabled');
                    $('#Kontak').removeAttr('disabled');
                    $('#SupplierStaID').removeAttr('disabled');
                    $('#SupplierID').attr('readonly', '');
                    $('#SupplierStaID').removeAttr('checked');

                    $('#data_form')[0].reset();

                    //set data from response record
                    $('#SupplierID').val(response.data.SupplierID);
                    $('#NamaSupplier').val(response.data.NamaSupplier);
                    $('#Alamat').val(response.data.Alamat);
                    $('#Kontak').val(response.data.Kontak);

                    //set error validation
                    $('#SupplierID').removeClass('is-invalid');
                    $('#NamaSupplier').removeClass('is-invalid');
                    $('#Alamat').removeClass('is-invalid');
                    $('#Kontak').removeClass('is-invalid');
                    $('#SupplierStaID').removeClass('is-invalid');
                    $('.errorSupplierID').html('');
                    $('.errorNamaSupplier').html('');
                    $('.errorAlamat').html('');
                    $('.errorKontak').html('');
                    $('.errorBranchStaID').html('');

                    //set selected data select2
                    $('#SupplierStaID').val(response.data.SupplierStaID);
                    $('#SupplierStaID').trigger('change');

                    //set modal & form
                    $('.modal-title').text('Ubah Data');
                    $('#action').val('Edit');
                    $('#submit_button').show();
                    $('#submit_button').val('Simpan');
                    $('#submit_button').html('Simpan');
                    $('#modalform').modal('show');
                    // $('#hidden_id').val(SupplierID);
                }
            })
        });

        $(document).on('click', '.delete', function() {
            var SupplierID = $(this).data('supplierid');
            if (confirm("Are you sure you want to remove it?")) {
                $.ajax({
                    url: "<?= site_url('tmstsupplier/delete'); ?>",
                    method: "POST",
                    data: {
                        SupplierID: SupplierID
                    },
                    dataType: "JSON",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                            //footer: '<a href="">Why do I have this issue?</a>'
                        });
                        tmstsupplier();
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
                url: '/tmstsupplier/preview',
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