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
                                                <label for="kode_paket" class="col-sm-2 col-form-label">Kode</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="kode_paket" name="kode_paket">
                                                    <span class="error invalid-feedback errorKode_paket">
                                                    </span>
                                                </div>
                                                <label for="nama_paket" class="col-sm-2 col-form-label">Paket</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="nama_paket" name="nama_paket">
                                                    <span class="error invalid-feedback errorObat">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="tanggal_dibuat" class="col-sm-2 col-form-label">Create Date</label>
                                                <div class="col-sm-4">
                                                    <div class="input-group date tanggal_dibuat" data-date-format="mm/dd/yyyy">
                                                        <input type="text" class="form-control form-control-sm datepicker" placeholder="mm/dd/yyyy" id="tanggal_dibuat" name="tanggal_dibuat">
                                                        <div class="input-group-append" data-target="#tanggal_dibuat" data-toggle="tanggal_dibuat">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                    </div>
                                                    <span class="error invalid-feedback errorTanggal_dibuat">
                                                    </span>
                                                </div>
                                                <?= $cb_aktif ?>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="periode_dari" class="col-sm-2 col-form-label">From Date</label>
                                                <div class="col-sm-4">
                                                    <div class="input-group date periode_dari" data-date-format="mm/dd/yyyy">
                                                        <input type="text" class="form-control form-control-sm datepicker" placeholder="mm/dd/yyyy" id="periode_dari" name="periode_dari">
                                                        <div class="input-group-append" data-target="#periode_dari" data-toggle="periode_dari">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                    </div>
                                                    <span class="error invalid-feedback errorPeriode_dari">
                                                    </span>
                                                </div>
                                                <label for="periode_sampai" class="col-sm-2 col-form-label">To Date</label>
                                                <div class="col-sm-4">
                                                    <div class="input-group date periode_sampai" data-date-format="mm/dd/yyyy">
                                                        <input type="text" class="form-control form-control-sm datepicker" placeholder="mm/dd/yyyy" id="periode_sampai" name="periode_sampai">
                                                        <div class="input-group-append" data-target="#periode_sampai" data-toggle="periode_sampai">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                    </div>
                                                    <span class="error invalid-feedback errorPeriode_sampai">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control form-control-sm" rows="3" placeholder="..." id="keterangan" name="keterangan"></textarea>
                                                    <span class="error invalid-feedback errorKeterangan">
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
                                        <form action="<?= site_url("tmstpaket/preview") ?>" id="uploadForm" method="post" enctype="multipart/form-data">
                                            <?= csrf_field(); ?>
                                            <label for="filename">Import Excel File : <a href="<?= site_url("tmstpaket/download") ?>"><u>Download Format</u></a></label> <br>
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

<!-- Datepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>


<!-- set menu name by active-menu -->
<script>
    $('#active-menu').html($('p#active-menu').html()); // set top navbar
    $(document).prop("title", $('p#active-menu').html()); // set title
</script>

<script>
    $('#tanggal_dibuat').datepicker({
        todayHighlight: true,
        autoclose: true,
        dateFormat: 'MM/DD/YYYY'
    }).val();
    $('#periode_dari').datepicker({
        todayHighlight: true,
        autoclose: true,
        dateFormat: 'MM/DD/YYYY'
    }).val();
    $('#periode_sampai').datepicker({
        todayHighlight: true,
        autoclose: true,
        dateFormat: 'MM/DD/YYYY'
    }).val();
</script>

<script>
    function tmstpaket() {
        $.ajax({
            method: "get",
            url: "<?= site_url('/tmstpaket/fetchAll'); ?>",
            success: function(data) {
                $('#viewdata').html(data);
            }
        });
    }

    function tmstobatpreview() {
        $.ajax({
            method: "get",
            url: "<?= site_url('tmstpaket/preview'); ?>",
            success: function(data) {
                $('#viewpreview').html(data);
            }
        });
    }

    $(document).ready(function() {
        tmstpaket()

        $(document).on('click', '#add_record', function() {
            //set input
            $('#kode_paket').removeAttr('disabled');
            $('#kode_paket').attr('readonly', '');
            $('#nama_paket').removeAttr('disabled');
            $('#keterangan').removeAttr('disabled');
            $('#tanggal_dibuat').removeAttr('disabled');
            $('#status_paket').removeAttr('disabled');
            $('#periode_dari').removeAttr('disabled');
            $('#periode_sampai').removeAttr('disabled');
            $('#status_paket').removeAttr('checked');

            $('#data_form')[0].reset();

            //set error validation
            $('#kode_paket').removeClass('is-invalid');
            $('#nama_paket').removeClass('is-invalid');
            $('#keterangan').removeClass('is-invalid');
            $('#tanggal_dibuat').removeClass('is-invalid');
            $('#status_paket').removeClass('is-invalid');
            $('#periode_dari').removeClass('is-invalid');
            $('#periode_sampai').removeClass('is-invalid');

            $('.errorKode_paket').html('');
            $('.errorNama_paket').html('');
            $('.errorKeterangan').html('');
            $('.errorTanggal_dibuat').html('');
            $('.errorStatus_paket').html('');
            $('.errorPeriode_dari').html('');
            $('.errorPeriode_sampai').html('');

            //set selected data select2
            $('#status_paket').val(' ');
            $('#status_paket').trigger('change');

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
                url: "<?= site_url('tmstpaket/action'); ?>",
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
                        if (response.error.kode_paket) {
                            $('#kode_paket').addClass('is-invalid');
                            $('.errorObat_cd').html(response.error.kode_paket);
                        } else {
                            $('#kode_paket').removeClass('is-invalid');
                            $('.errorObat_cd').html('');
                        }
                        if (response.error.obat) {
                            $('#obat').addClass('is-invalid');
                            $('.errorObat').html(response.error.obat);
                        } else {
                            $('#obat').removeClass('is-invalid');
                            $('.errorObat').html('');
                        }
                        if (response.error.jenis_admin) {
                            $('#jenis_admin').addClass('is-invalid');
                            $('.errorJenis_admin').html(response.error.jenis_admin);
                        } else {
                            $('#jenis_admin').removeClass('is-invalid');
                            $('.errorJenis_admin').html('');
                        }
                        if (response.error.kelas_terapi) {
                            $('#kelas_terapi').addClass('is-invalid');
                            $('.errorKelas_terapi').html(response.error.kelas_terapi);
                        } else {
                            $('#kelas_terapi').removeClass('is-invalid');
                            $('.errorKelas_terapi').html('');
                        }
                        if (response.error.subkelas_terapi) {
                            $('#subkelas_terapi').addClass('is-invalid');
                            $('.errorSubkelas_terapi').html(response.error.subkelas_terapi);
                        } else {
                            $('#subkelas_terapi').removeClass('is-invalid');
                            $('.errorSubkelas_terapi').html('');
                        }
                        if (response.error.nm_generik) {
                            $('#nm_generik').addClass('is-invalid');
                            $('.errorNm_generik').html(response.error.nm_generik);
                        } else {
                            $('#nm_generik').removeClass('is-invalid');
                            $('.errorNm_generik').html('');
                        }
                        if (response.error.nm_dagang) {
                            $('#nm_dagang').addClass('is-invalid');
                            $('.errorNm_dagang').html(response.error.nm_dagang);
                        } else {
                            $('#nm_dagang').removeClass('is-invalid');
                            $('.errorNm_dagang').html('');
                        }
                        if (response.error.obat_sta_id) {
                            $('#obat_sta_id').addClass('is-invalid');
                            $('.errorObat_sta_id').html(response.error.obat_sta_id);
                        } else {
                            $('#obat_sta_id').removeClass('is-invalid');
                            $('.errorObat_sta_id').html('');
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
                        $('#kode_paket').removeClass('is-invalid');
                        $('#obat').removeClass('is-invalid');
                        $('#jenis_admin').removeClass('is-invalid');
                        $('#kelas_terapi').removeClass('is-invalid');
                        $('#subkelas_terapi').removeClass('is-invalid');
                        $('#nm_generik').removeClass('is-invalid');
                        $('#nm_dagang').removeClass('is-invalid');
                        $('#obat_sta_id').removeClass('is-invalid');
                        $('#kode_paket').val('');
                        $('#obat').val('');
                        // $('#obat_sta_id').removeAttr('checked');

                        tmstpaket();
                        $('#modalform').modal('hide');
                    }
                },
            })
        });

        $(document).on('click', '.view', function() {
            var kode_paket = $(this).data('kode_paket');

            $.ajax({
                url: "<?= site_url('tmstpaket/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    kode_paket: kode_paket
                },
                dataType: "JSON",
                success: function(response) {
                    //set input
                    $('#kode_paket').attr('disabled', '');
                    $('#kode_paket').attr('readonly', '');
                    $('#nama_paket').attr('disabled', '');
                    $('#keterangan').attr('disabled', '');
                    // $('#tanggal_dibuat').attr('disabled', '');
                    $('#status_paket').attr('disabled', '');
                    $('#periode_dari').attr('disabled', '');
                    $('#periode_sampai').attr('disabled', '');

                    $('#data_form')[0].reset();

                    //set data from response record
                    $('#kode_paket').val(response.data.kode_paket);
                    $('#nama_paket').val(response.data.nama_paket);
                    $('#create_date').val(response.data.create_date);
                    $('#periode_dari').val(response.data.periode_dari);
                    $('#periode_sampai').val(response.data.periode_sampai);
                    $('#keterangan').val(response.data.keterangan);

                    //set error validation
                    $('#kode_paket').removeClass('is-invalid');
                    $('#nama_paket').removeClass('is-invalid');
                    $('#keterangan').removeClass('is-invalid');
                    // $('#tanggal_dibuat').removeClass('is-invalid');
                    $('#status_paket').removeClass('is-invalid');
                    $('#periode_dari').removeClass('is-invalid');
                    $('#periode_sampai').removeClass('is-invalid');

                    $('.errorKode_paket').html('');
                    $('.errorNama_paket').html('');
                    $('.errorKeterangan').html('');
                    // $('.errorTanggal_dibuat').html('');
                    $('.errorStatus_paket').html('');
                    $('.errorPeriode_dari').html('');
                    $('.errorPeriode_sampai').html('');

                    //set selected data select2
                    $('#status_paket').val(response.data.status_paket);
                    $('#status_paket').trigger('change');

                    // $('#kelas_terapi').val(response.data.kelas_terapi);
                    // $('#kelas_terapi').trigger('change');
                    // $('#subkelas_terapi').val(response.data.subkelas_terapi);
                    // $('#subkelas_terapi').trigger('change');
                    // $('#nm_generik').val(response.data.nm_generik);
                    // $('#nm_generik').trigger('change');
                    // $('#nm_dagang').val(response.data.nm_dagang);
                    // $('#nm_dagang').trigger('change');
                    // $('#obat_sta_id').val(response.data.obat_sta_id);
                    // $('#obat_sta_id').trigger('change');

                    //set modal & form
                    $('.modal-title').text('Lihat Data');
                    $('#action').val('View');
                    $('#submit_button').hide();
                    $('#submit_button').val('Lihat');
                    $('#submit_button').html('Lihat');
                    $('#modalform').modal('show');
                    $('#hidden_id').val(kode_paket);
                }
            })
        });

        $(document).on('click', '.edit', function() {
            var kode_paket = $(this).data('kode_paket');

            $.ajax({
                url: "<?= site_url('tmstpaket/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    kode_paket: kode_paket
                },
                dataType: "JSON",
                success: function(response) {
                    //set input
                    $('#kode_paket').removeAttr('disabled');
                    $('#kode_paket').attr('readonly', '');
                    $('#nama_paket').removeAttr('disabled');
                    $('#keterangan').removeAttr('disabled');
                    $('#tanggal_dibuat').removeAttr('disabled');
                    $('#status_paket').removeAttr('disabled');
                    $('#periode_dari').removeAttr('disabled');
                    $('#periode_sampai').removeAttr('disabled');
                    $('#status_paket').removeAttr('checked');

                    $('#data_form')[0].reset();

                    //set data from response record
                    $('#kode_paket').val(response.data.kode_paket);
                    $('#nama_paket').val(response.data.nama_paket);
                    $('#periode_dari').val(response.data.periode_dari);
                    $('#periode_sampai').val(response.data.periode_sampai);
                    $('#keterangan').val(response.data.keterangan);

                    //set error validation
                    $('#kode_paket').removeClass('is-invalid');
                    $('#nama_paket').removeClass('is-invalid');
                    $('#keterangan').removeClass('is-invalid');
                    // $('#tanggal_dibuat').removeClass('is-invalid');
                    $('#status_paket').removeClass('is-invalid');
                    $('#periode_dari').removeClass('is-invalid');
                    $('#periode_sampai').removeClass('is-invalid');

                    $('.errorKode_paket').html('');
                    $('.errorNama_paket').html('');
                    $('.errorKeterangan').html('');
                    // $('.errorTanggal_dibuat').html('');
                    $('.errorStatus_paket').html('');
                    $('.errorPeriode_dari').html('');
                    $('.errorPeriode_sampai').html('');

                    //set selected data select2
                    $('#status_paket').val(response.data.status_paket);
                    $('#status_paket').trigger('change');

                    //set modal & form
                    $('.modal-title').text('Ubah Data');
                    $('#action').val('Edit');
                    $('#submit_button').show();
                    $('#submit_button').val('Simpan');
                    $('#submit_button').html('Simpan');
                    $('#modalform').modal('show');
                    // $('#hidden_id').val(kode_paket);
                }
            })
        });

        $(document).on('click', '.delete', function() {
            var kode_paket = $(this).data('kode_paket');
            if (confirm("Are you sure you want to remove it?")) {
                $.ajax({
                    url: "<?= site_url('tmstpaket/delete'); ?>",
                    method: "POST",
                    data: {
                        kode_paket: kode_paket
                    },
                    dataType: "JSON",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                            //footer: '<a href="">Why do I have this issue?</a>'
                        });
                        tmstpaket();
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
                url: '/tmstpaket/preview',
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
                    tmstobatpreview();
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                }
            });
        });


    });
</script>



<?= $this->endSection('script'); ?>