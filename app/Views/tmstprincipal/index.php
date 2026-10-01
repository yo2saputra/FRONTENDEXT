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
                                                <label for="principal_cd" class="col-sm-2 col-form-label">Kode</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="principal_cd" name="principal_cd">
                                                    <span class="error invalid-feedback errorPrincipal_cd">
                                                    </span>
                                                </div>
                                                <label for="principal_nm" class="col-sm-2 col-form-label">Principal</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="principal_nm" name="principal_nm">
                                                    <span class="error invalid-feedback errorPrincipal_nm">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <!-- <label for="alamat" class="col-sm-2 col-form-label">alamat</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="alamat" name="alamat">
                                                    <span class="error invalid-feedback errorKeterangan">
                                                    </span>
                                                </div> -->
                                                <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                                                <div class="col-sm-4">
                                                    <textarea class="form-control form-control-sm" rows="3" placeholder="..." id="alamat" name="alamat" autocomplete="off"></textarea>
                                                    <span class="error invalid-feedback errorAlamat">
                                                    </span>
                                                </div>
                                                <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                                                <div class="col-sm-4">
                                                    <textarea class="form-control form-control-sm" rows="3" placeholder="..." id="keterangan" name="keterangan" autocomplete="off"></textarea>
                                                    <span class="error invalid-feedback errorKeterangan">
                                                    </span>
                                                </div>

                                            </div>
                                            <div class="mb-3 row">
                                                <label for="kontak" class="col-sm-2 col-form-label">Kontak</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="kontak" name="kontak">
                                                    <span class="error invalid-feedback errorKontak">
                                                    </span>
                                                </div>
                                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="email" name="email">
                                                    <span class="error invalid-feedback errorEmail">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="website" class="col-sm-2 col-form-label">Website</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="website" name="website">
                                                    <span class="error invalid-feedback errorWebsite">
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
                                        <form action="<?= site_url("tmstprincipal/preview") ?>" id="uploadForm" method="post" enctype="multipart/form-data">
                                            <?= csrf_field(); ?>
                                            <label for="filename">Import Excel File : <a href="<?= site_url("tmstprincipal/download") ?>"><u>Download Format</u></a></label> <br>
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
    function tmstprincipal() {
        $.ajax({
            method: "get",
            url: "<?= site_url('/tmstprincipal/fetchAll'); ?>",
            success: function(data) {
                $('#viewdata').html(data);
            }
        });
    }

    function tmstdiagnosapreview() {
        $.ajax({
            method: "get",
            url: "<?= site_url('tmstprincipal/preview'); ?>",
            success: function(data) {
                $('#viewpreview').html(data);
            }
        });
    }

    $(document).ready(function() {
        tmstprincipal()

        $(document).on('click', '#add_record', function() {
            //set input
            $('#principal_cd').attr('disabled', '');
            // $('#principal_cd').removeAttr('disabled');
            $('#principal_nm').removeAttr('disabled');
            $('#alamat').removeAttr('disabled');
            $('#principal_sta_id').removeAttr('disabled');
            $('#principal_cd').removeAttr('readonly');
            $('#principal_sta_id').removeAttr('checked');

            $('#data_form')[0].reset();

            //set error validation
            $('#principal_cd').removeClass('is-invalid');
            $('#principal_nm').removeClass('is-invalid');
            $('#alamat').removeClass('is-invalid');
            $('#principal_sta_id').removeClass('is-invalid');
            $('.errorPrincipal_cd').html('');
            $('.errorPrincipal_nm').html('');
            $('.errorAlamat').html('');
            $('.errorKeterangan').html('');
            $('.errorPrincipal_sta_id').html('');

            $('#kontak').removeAttr('disabled').removeClass('is-invalid').html('');
            $('#email').removeAttr('disabled').removeClass('is-invalid').html('');
            $('#website').removeAttr('disabled').removeClass('is-invalid').html('');

            //set selected data select2
            $('#principal_sta_id').val(' ');
            $('#principal_sta_id').trigger('change');

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
                url: "<?= site_url('tmstprincipal/action'); ?>",
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
                        if (response.error.principal_cd) {
                            $('#principal_cd').addClass('is-invalid');
                            $('.errorPrincipal_cd').html(response.error.principal_cd);
                        } else {
                            $('#principal_cd').removeClass('is-invalid');
                            $('.errorPrincipal_cd').html('');
                        }
                        if (response.error.principal_nm) {
                            $('#principal_nm').addClass('is-invalid');
                            $('.errorPrincipal_nm').html(response.error.principal_nm);
                        } else {
                            $('#principal_nm').removeClass('is-invalid');
                            $('.errorPrincipal_nm').html('');
                        }
                        if (response.error.alamat) {
                            $('#alamat').addClass('is-invalid');
                            $('.errorAlamat').html(response.error.alamat);
                        } else {
                            $('#alamat').removeClass('is-invalid');
                            $('.errorAlamat').html('');
                        }
                        if (response.error.kontak) {
                            $('#kontak').addClass('is-invalid');
                            $('.errorKontak').html(response.error.kontak);
                        } else {
                            $('#kontak').removeClass('is-invalid');
                            $('.errorKontak').html('');
                        }
                        if (response.error.email) {
                            $('#email').addClass('is-invalid');
                            $('.errorEmail').html(response.error.email);
                        } else {
                            $('#email').removeClass('is-invalid');
                            $('.errorEmail').html('');
                        }
                        if (response.error.website) {
                            $('#website').addClass('is-invalid');
                            $('.errorWebsite').html(response.error.website);
                        } else {
                            $('#website').removeClass('is-invalid');
                            $('.errorWebsite').html('');
                        }
                        if (response.error.keterangan) {
                            $('#keterangan').addClass('is-invalid');
                            $('.errorKeterangan').html(response.error.alamat);
                        } else {
                            $('#keterangan').removeClass('is-invalid');
                            $('.errorKeterangan').html('');
                        }
                        if (response.error.principal_sta_id) {
                            $('#principal_sta_id').addClass('is-invalid');
                            $('.errorPrincipal_sta_id').html(response.error.principal_sta_id);
                        } else {
                            $('#principal_sta_id').removeClass('is-invalid');
                            $('.errorPrincipal_sta_id').html('');
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
                        $('#principal_cd').removeClass('is-invalid');
                        $('#principal_nm').removeClass('is-invalid');
                        $('#alamat').removeClass('is-invalid');
                        $('#principal_sta_id').removeClass('is-invalid');
                        $('#principal_cd').val('');
                        $('#principal_nm').val('');
                        $('#alamat').val('');
                        $('#principal_sta_id').removeAttr('checked');

                        //BARU
                        $('#kontak').removeClass('is-invalid').val('');
                        $('#email').removeClass('is-invalid').val('');
                        $('#website').removeClass('is-invalid').val('');

                        tmstprincipal();
                        $('#modalform').modal('hide');
                    }
                },
            })
        });

        $(document).on('click', '.view', function() {
            var principal_cd = $(this).data('principal_cd');

            $.ajax({
                url: "<?= site_url('tmstprincipal/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    principal_cd: principal_cd
                },
                dataType: "JSON",
                success: function(response) {
                    //set input
                    $('#principal_cd').attr('disabled', '');
                    $('#principal_nm').attr('disabled', '');
                    $('#alamat').attr('disabled', '');
                    $('#keterangan').attr('disabled', '');
                    $('#principal_sta_id').attr('disabled', '');
                    $('#principal_sta_id').removeAttr('checked');

                    $('#data_form')[0].reset();

                    //set data from response record
                    $('#principal_cd').val(response.data.principal_cd);
                    $('#principal_nm').val(response.data.principal_nm);
                    $('#alamat').val(response.data.alamat);
                    $('#keterangan').val(response.data.keterangan);

                    //set error validation
                    $('#principal_cd').removeClass('is-invalid');
                    $('#principal_nm').removeClass('is-invalid');
                    $('#alamat').removeClass('is-invalid');
                    $('#principal_sta_id').removeClass('is-invalid');
                    $('.errorPrincipal_cd').html('');
                    $('.errorPrincipal_nm').html('');
                    $('.errorAlamat').html('');
                    $('.errorKeterangan').html('');
                    $('.errorPrincipal_sta_id').html('');

                    //BARU
                    $('#kontak').attr('disabled', '').val(response.data.kontak).removeClass('is-invalid');
                    $('#email').attr('disabled', '').val(response.data.email).removeClass('is-invalid');
                    $('#website').attr('disabled', '').val(response.data.website).removeClass('is-invalid');

                    //set selected data select2
                    $('#principal_sta_id').val(response.data.principal_sta_id);
                    $('#principal_sta_id').trigger('change');

                    //set modal & form
                    $('.modal-title').text('Lihat Data');
                    $('#action').val('View');
                    $('#submit_button').hide();
                    $('#submit_button').val('Lihat');
                    $('#submit_button').html('Lihat');
                    $('#modalform').modal('show');
                    $('#hidden_id').val(principal_cd);
                }
            })
        });

        $(document).on('click', '.edit', function() {
            var principal_cd = $(this).data('principal_cd');

            $.ajax({
                url: "<?= site_url('tmstprincipal/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    principal_cd: principal_cd
                },
                dataType: "JSON",
                success: function(response) {
                    //set input
                    $('#principal_cd').removeAttr('disabled');
                    $('#principal_nm').removeAttr('disabled');
                    $('#alamat').removeAttr('disabled');
                    $('#keterangan').removeAttr('disabled');
                    $('#principal_sta_id').removeAttr('disabled');
                    $('#principal_cd').attr('readonly', '');
                    $('#principal_sta_id').removeAttr('checked');

                    $('#kontak').removeAttr('disabled');
                    $('#email').removeAttr('disabled');
                    $('#website').removeAttr('disabled');

                    $('#data_form')[0].reset();

                    //set data from response record
                    $('#principal_cd').val(response.data.principal_cd);
                    $('#principal_nm').val(response.data.principal_nm);
                    $('#alamat').val(response.data.alamat);
                    $('#keterangan').val(response.data.keterangan);

                    //set error validation
                    $('#principal_cd').removeClass('is-invalid');
                    $('#principal_nm').removeClass('is-invalid');
                    $('#alamat').removeClass('is-invalid');
                    $('#principal_sta_id').removeClass('is-invalid');
                    $('.errorPrincipal_cd').html('');
                    $('.errorPrincipal_nm').html('');
                    $('.errorAlamat').html('');
                    $('.errorKeterangan').html('');
                    $('.errorPrincipal_sta_id').html('');

                    //BARU
                    $('#kontak').val(response.data.kontak).removeClass('is-invalid');
                    $('#email').val(response.data.email).removeClass('is-invalid');
                    $('#website').val(response.data.website).removeClass('is-invalid');

                    //set selected data select2
                    $('#principal_sta_id').val(response.data.principal_sta_id);
                    $('#principal_sta_id').trigger('change');

                    //set modal & form
                    $('.modal-title').text('Ubah Data');
                    $('#action').val('Edit');
                    $('#submit_button').show();
                    $('#submit_button').val('Simpan');
                    $('#submit_button').html('Simpan');
                    $('#modalform').modal('show');
                    // $('#hidden_id').val(principal_cd);
                }
            })
        });

        $(document).on('click', '.delete', function() {
            var principal_cd = $(this).data('principal_cd');
            if (confirm("Are you sure you want to remove it?")) {
                $.ajax({
                    url: "<?= site_url('tmstprincipal/delete'); ?>",
                    method: "POST",
                    data: {
                        principal_cd: principal_cd
                    },
                    dataType: "JSON",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                            //footer: '<a href="">Why do I have this issue?</a>'
                        });
                        tmstprincipal();
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
                url: '/tmstprincipal/preview',
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