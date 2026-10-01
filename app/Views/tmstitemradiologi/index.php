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
                                                <label for="kd_item" class="col-sm-2 col-form-label">Kode</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="kd_item" name="kd_item">
                                                    <span class="error invalid-feedback errorKd_item">
                                                    </span>
                                                </div>
                                                <label for="nama_item" class="col-sm-2 col-form-label">Nama Item</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="nama_item" name="nama_item">
                                                    <span class="error invalid-feedback errorNama_item">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="kolom_no" class="col-sm-2 col-form-label">Kolom</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="kolom_no" name="kolom_no">
                                                    <span class="error invalid-feedback errorKolom_no">
                                                    </span>
                                                </div>
                                                <label for="urutan" class="col-sm-2 col-form-label">Urutan</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="urutan" name="urutan">
                                                    <span class="error invalid-feedback errorUrutan">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <?= $cb_aktif ?>
                                                <label for="deleted" class="col-sm-2 col-form-label"></label>
                                                <div class="col-sm-4">
                                                    <div class="icheck-primary d-inline">
                                                        <input type="checkbox" id="deleted" name="deleted" checked>
                                                        <label for="deleted">Deleted
                                                        </label>
                                                    </div>
                                                    <span class="error invalid-feedback errorDeleted">
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
                                        <form action="<?= site_url("tmstitemradiologi/preview") ?>" id="uploadForm" method="post" enctype="multipart/form-data">
                                            <?= csrf_field(); ?>
                                            <label for="filename">Import Excel File : <a href="<?= site_url("tmstitemradiologi/download") ?>"><u>Download Format</u></a></label> <br>
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
    function tmstnama_item() {
        $.ajax({
            method: "get",
            url: "<?= site_url('/tmstitemradiologi/fetchAll'); ?>",
            success: function(data) {
                $('#viewdata').html(data);
            }
        });
    }

    function tmstnama_itempreview() {
        $.ajax({
            method: "get",
            url: "<?= site_url('tmstitemradiologi/preview'); ?>",
            success: function(data) {
                $('#viewpreview').html(data);
            }
        });
    }

    $(document).ready(function() {
        tmstnama_item()

        $(document).on('click', '#add_record', function() {
            //set input
            $('#kd_item').attr('disabled', '');
            $('#kd_item').removeAttr('readonly');
            // $('#kd_item').removeAttr('disabled');
            $('#nama_item').removeAttr('disabled');
            $('#deleted').removeAttr('disabled');
            $('#deleted').removeAttr('checked');
            $('#kd_parent').removeAttr('disabled');
            $('#kd_parent').removeAttr('checked');
            $('#kolom_no').removeAttr('disabled');
            $('#urutan').removeAttr('disabled');

            $('#data_form')[0].reset();

            //set error validation
            $('#kd_item').removeClass('is-invalid');
            $('#nama_item').removeClass('is-invalid');
            $('#deleted').removeClass('is-invalid');
            $('#kd_parent').removeClass('is-invalid');
            $('#kolom_no').removeClass('is-invalid');
            $('#urutan').removeClass('is-invalid');
            $('.errorKd_item').html('');
            $('.errorNama_item').html('');
            $('.errorDeleted').html('');
            $('.errorKd_parent').html('');
            $('.errorKolom_no').html('');
            $('.errorUrutan').html('');

            //set selected data select2
            $('#kd_parent').val(' ');
            $('#kd_parent').trigger('change');

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
                url: "<?= site_url('tmstitemradiologi/action'); ?>",
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
                        if (response.error.kd_item) {
                            $('#kd_item').addClass('is-invalid');
                            $('.errorKd_item').html(response.error.kd_item);
                        } else {
                            $('#kd_item').removeClass('is-invalid');
                            $('.errorKd_item').html('');
                        }
                        if (response.error.nama_item) {
                            $('#nama_item').addClass('is-invalid');
                            $('.errorNama_item').html(response.error.nama_item);
                        } else {
                            $('#nama_item').removeClass('is-invalid');
                            $('.errorNama_item').html('');
                        }
                        if (response.error.kolom_no) {
                            $('#kolom_no').addClass('is-invalid');
                            $('.errorKolom_no').html(response.error.kolom_no);
                        } else {
                            $('#kolom_no').removeClass('is-invalid');
                            $('.errorKolom_no').html('');
                        }
                        if (response.error.urutan) {
                            $('#urutan').addClass('is-invalid');
                            $('.errorUrutan').html(response.error.urutan);
                        } else {
                            $('#urutan').removeClass('is-invalid');
                            $('.errorUrutan').html('');
                        }
                        if (response.error.kd_parent) {
                            alert(poly_sta_id);
                            $('#kd_parent').addClass('is-invalid');
                            $('.errorKd_parent').html(response.error.kd_parent);
                        } else {
                            $('#kd_parent').removeClass('is-invalid');
                            $('.errorKd_parent').html('');
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
                        $('#kd_item').removeClass('is-invalid');
                        $('#nama_item').removeClass('is-invalid');
                        $('#deleted').removeClass('is-invalid');
                        $('#kd_parent').removeClass('is-invalid');
                        $('#kolom_no').removeClass('is-invalid');
                        $('#urutan').removeClass('is-invalid');


                        $('#kd_item').val('');
                        $('#nama_item').val('');
                        $('#deleted').removeAttr('checked');
                        $('#kd_parent').removeAttr('checked');
                        $('#kolom_no').val('');
                        $('#urutan').val('');

                        tmstnama_item();
                        $('#modalform').modal('hide');
                    }
                },
            })
        });

        $(document).on('click', '.view', function() {
            var kd_item = $(this).data('kd_item');

            $.ajax({
                url: "<?= site_url('tmstitemradiologi/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    kd_item: kd_item
                },
                dataType: "JSON",
                success: function(response) {
                    //set input
                    $('#kd_item').attr('disabled', '');
                    $('#nama_item').attr('disabled', '');
                    $('#deleted').attr('disabled', '');
                    $('#deleted').removeAttr('checked');
                    $('#kd_parent').attr('disabled', '');
                    $('#kd_parent').removeAttr('checked');
                    $('#kolom_no').attr('disabled', '');
                    $('#urutan').attr('disabled', '');


                    $('#data_form')[0].reset();

                    //set data from response record
                    $('#kd_item').val(response.data.kd_item);
                    $('#nama_item').val(response.data.nama_item);
                    $('#kolom_no').val(response.data.kolom_no);
                    $('#urutan').val(response.data.urutan);
                    (response.data.deleted === 1 ? $('#deleted').attr('checked', 'checked') : $('#deleted').removeAttr('checked'));

                    //set error validation
                    $('#kd_item').removeClass('is-invalid');
                    $('#nama_item').removeClass('is-invalid');
                    $('#deleted').removeClass('is-invalid');
                    $('#kd_parent').removeClass('is-invalid');
                    $('#kolom_no').removeClass('is-invalid');
                    $('#urutan').removeClass('is-invalid');
                    $('.errorKd_item').html('');
                    $('.errorNama_item').html('');
                    $('.errorDeleted').html('');
                    $('.errorKd_parent').html('');
                    $('.errorKolom_no').html('');
                    $('.errorUrutan').html('');

                    //set selected data select2
                    $('#kd_parent').val(response.data.kd_parent);
                    $('#kd_parent').trigger('change');

                    //set modal & form
                    $('.modal-title').text('Lihat Data');
                    $('#action').val('View');
                    $('#submit_button').hide();
                    $('#submit_button').val('Lihat');
                    $('#submit_button').html('Lihat');
                    $('#modalform').modal('show');
                    $('#hidden_id').val(kd_item);
                }
            })
        });

        $(document).on('click', '.edit', function() {
            var kd_item = $(this).data('kd_item');

            $.ajax({
                url: "<?= site_url('tmstitemradiologi/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    kd_item: kd_item
                },
                dataType: "JSON",
                success: function(response) {
                    //set input
                    $('#kd_item').removeAttr('disabled');
                    $('#nama_item').removeAttr('disabled');
                    $('#deleted').removeAttr('disabled');
                    $('#deleted').removeAttr('checked');
                    $('#kd_parent').removeAttr('disabled');
                    $('#kd_item').attr('readonly', '');
                    $('#kd_parent').removeAttr('checked');
                    $('#kolom_no').removeAttr('disabled');
                    $('#urutan').removeAttr('disabled');

                    $('#data_form')[0].reset();

                    //set data from response record
                    $('#kd_item').val(response.data.kd_item);
                    $('#nama_item').val(response.data.nama_item);
                    $('#kolom_no').val(response.data.kolom_no);
                    $('#urutan').val(response.data.urutan);
                    (response.data.deleted === 1 ? $('#deleted').attr('checked', 'checked') : $('#deleted').removeAttr('checked'));

                    //set error validation
                    $('#kd_item').removeClass('is-invalid');
                    $('#nama_item').removeClass('is-invalid');
                    $('#deleted').removeClass('is-invalid');
                    $('#kd_parent').removeClass('is-invalid');
                    $('#kolom_no').removeClass('is-invalid');
                    $('#urutan').removeClass('is-invalid');
                    $('.errorKd_item').html('');
                    $('.errorNama_item').html('');
                    $('.errorDeleted').html('');
                    $('.errorKd_parent').html('');
                    $('.errorKolom_no').html('');
                    $('.errorUrutan').html('');

                    //set selected data select2
                    $('#kd_parent').val(response.data.kd_parent);
                    $('#kd_parent').trigger('change');

                    //set modal & form
                    $('.modal-title').text('Ubah Data');
                    $('#action').val('Edit');
                    $('#submit_button').show();
                    $('#submit_button').val('Simpan');
                    $('#submit_button').html('Simpan');
                    $('#modalform').modal('show');
                    // $('#hidden_id').val(kd_item);
                }
            })
        });

        $(document).on('click', '.delete', function() {
            var kd_item = $(this).data('kd_item');
            if (confirm("Are you sure you want to remove it?")) {
                $.ajax({
                    url: "<?= site_url('tmstitemradiologi/delete'); ?>",
                    method: "POST",
                    data: {
                        kd_item: kd_item
                    },
                    dataType: "JSON",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                            //footer: '<a href="">Why do I have this issue?</a>'
                        });
                        tmstnama_item();
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
                url: '/tmstitemradiologi/preview',
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
                    tmstnama_itempreview();
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                }
            });
        });


    });
</script>



<?= $this->endSection('script'); ?>