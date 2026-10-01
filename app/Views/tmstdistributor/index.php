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
                                                <label for="kodedistributor" class="col-sm-2 col-form-label">Kode</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="kodedistributor" name="kodedistributor">
                                                    <span class="error invalid-feedback errorKodedistributor">
                                                    </span>
                                                </div>
                                                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="nama" name="nama">
                                                    <span class="error invalid-feedback errorNama">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="namakontak" class="col-sm-2 col-form-label">Nama Kontak</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="namakontak" name="namakontak">
                                                    <span class="error invalid-feedback errorNamakontak">
                                                    </span>
                                                </div>
                                                <label for="nomorkontak" class="col-sm-2 col-form-label">Nomor Kontak</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="nomorkontak" name="nomorkontak">
                                                    <span class="error invalid-feedback errorNomorkontak">
                                                    </span>
                                                </div>

                                            </div>
                                            <div class="mb-3 row">
                                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="email" name="email">
                                                    <span class="error invalid-feedback errorEmail">
                                                    </span>
                                                </div>
                                                <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                                                <div class="col-sm-4">
                                                    <textarea class="form-control form-control-sm" rows="3" placeholder="..." id="alamat" name="alamat" autocomplete="off"></textarea>
                                                    <span class="error invalid-feedback errorAlamat">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="kodekota" class="col-sm-2 col-form-label">Kota</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="kodekota" name="kodekota">
                                                    <span class="error invalid-feedback errorKodekota">
                                                    </span>
                                                </div>
                                                <label for="kodenegara" class="col-sm-2 col-form-label">Negara</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="kodenegara" name="kodenegara">
                                                    <span class="error invalid-feedback errorKodenegara">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="npwp" class="col-sm-2 col-form-label">NPWP</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="npwp" name="npwp">
                                                    <span class="error invalid-feedback errorNpwp">
                                                    </span>
                                                </div>
                                                <label for="namasebutan" class="col-sm-2 col-form-label">Nama Sebutan</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="namasebutan" name="namasebutan">
                                                    <span class="error invalid-feedback errorNamasebutan">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="tglterdaftar" class="col-sm-2 col-form-label">Tgl Terdaftar</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="tglterdaftar" name="tglterdaftar">
                                                    <span class="error invalid-feedback errorTglterdaftar">
                                                    </span>
                                                </div>
                                                <?= $cb_kategori; ?>
                                            </div>
                                            <div class="mb-3 row">
                                                <div class="col-sm-2"></div>
                                                <div class="col-sm-10">
                                                    <div class="icheck-primary d-inline">
                                                        <input type="checkbox" id="inactive" name="inactive" checked>
                                                        <label for="inactive">Inactive</label>
                                                    </div>
                                                    <span class="error invalid-feedback errorInactive">
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

<!-- Datepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<script>
    $('#').datepicker({
        todayHighlight: true,
        autoclose: true,
        dateFormat: 'MM/DD/YYYY'
    }).val();
    $('#').datepicker({
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
    function tmstdistributor() {
        $.ajax({
            method: "get",
            url: "<?= site_url('/tmstdistributor/fetchAll'); ?>",
            success: function(data) {
                $('#viewdata').html(data);
            }
        });
    }
    $(document).ready(function() {
        tmstdistributor();

        // $('#employee_status').attr('disabled');
        // $('#jenis_dokter').attr('disabled');
        // $('#tujuan_registrasi').attr('disabled');

        //datatable server side
        // $('#sample_table').DataTable({
        //     "order": [],
        //     "serverSide": true,
        //     "ajax": {
        //         url: "<?php echo base_url("/ajax_crud/fetchAll"); ?>",
        //         type: "POST",
        //     }
        // });

        // $('#kategori').on("change", function(e) {
        //     var val = $(this).val();
        //     if (val === 'DR') {
        //         $('#jenis_dokter').removeAttr('disabled');

        //         $('#spesialis').removeAttr('disabled');
        //         // $('#inactive').attr('disabled', '');
        //         $('#inactive').attr('checked', 'checked');

        //     } else {
        //         $('#jenis_dokter').val(' ');
        //         $('#jenis_dokter').trigger('change');
        //         $('#jenis_dokter').attr('disabled', '');

        //         $('#spesialis').val(' ');
        //         $('#spesialis').trigger('change');
        //         $('#spesialis').attr('disabled', '');

        //         // $('#inactive').attr('disabled', '');
        //         $('#inactive').removeAttr('checked');

        //     }
        // });

        $(document).on('click', '#add_record', function() {
            //set input
            $('#kodedistributor').removeAttr('readonly');
            $('#kodedistributor').attr('readonly', '');
            $('#nama').removeAttr('disabled');
            $('#kategori').removeAttr('disabled');
            $('#spesialis').removeAttr('disabled');
            $('#namakontak').removeAttr('disabled');
            $('#nomorkontak').removeAttr('disabled');
            $('#email').removeAttr('disabled');
            $('#alamat').removeAttr('disabled');
            $('#kodekota').removeAttr('disabled');
            $('#kodenegara').removeAttr('disabled');
            $('#npwp').removeAttr('disabled');
            $('#namasebutan').removeAttr('disabled');
            $('#tglterdaftar').removeAttr('disabled');
            $('#inactive').removeAttr('disabled');
            $('#inactive').removeAttr('checked');
            $('#jenis_dokter').removeAttr('disabled');



            $('#data_form')[0].reset();

            //set error validation
            $('#kodedistributor').removeClass('is-invalid');
            $('#nama').removeClass('is-invalid');
            $('#kategori').removeClass('is-invalid');
            $('#spesialis').removeClass('is-invalid');
            $('#namakontak').removeClass('is-invalid');
            $('#nomorkontak').removeClass('is-invalid');
            $('#email').removeClass('is-invalid');
            $('#alamat').removeClass('is-invalid');
            $('#kodekota').removeClass('is-invalid');
            $('#kodenegara').removeClass('is-invalid');
            $('#npwp').removeClass('is-invalid');
            $('#namasebutan').removeClass('is-invalid');
            $('#tglterdaftar').removeClass('is-invalid');
            $('#emp_sta_cd').removeClass('is-invalid');
            $('#jenis_dokter').removeClass('is-invalid');

            $('.errorKodedistributor').html('');
            $('.errorNama').html('');
            $('.errorKategori').html('');
            $('.errorSpesialis').html('');
            $('.errorPhone_no').html('');
            $('.errorMobile_no').html('');
            $('.errorEmail').html('');
            $('.errorAlamat').html('');
            $('.errorKodekota').html('');
            $('.errorKodenegara').html('');
            $('.errorNpwp').html('');
            $('.errorNamasebutan').html('');
            $('.errorWhatsapp_cd').html('');
            $('.errorLevel_cd').html('');
            $('.errorEmp_sta_cd').html('');
            $('.errorPoli').html('');
            $('.errorJenis_dokter').html('');

            //set selected data select2
            // $('#emp_sta_cd').val(' ');
            // $('#emp_sta_cd').trigger('change');
            $('#kategori').val(' ');
            $('#kategori').trigger('change');
            $('#jenis_dokter').val(' ');
            $('#jenis_dokter').trigger('change');
            $('#spesialis').val(' ');
            $('#spesialis').trigger('change');

            //set modal & form
            $('.modal-title').text('Tambah Data');
            $('#action').val('Add');
            $('#submit_button').show();
            $('#submit_button').val('Simpan');
            $('#submit_button').html('Simpan');
            $('#modalform').modal('show');


        });

        $('#data_form').on('submit', function(event) {
            $('#inactive').removeAttr('disabled');
            event.preventDefault();
            $.ajax({
                url: "<?= site_url('tmstdistributor/action'); ?>",
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
                    $('#inactive').attr('disabled', '');
                },
                success: function(response) {

                    if (response.error) {
                        // if (response.error.kodedistributor) {
                        //     $('#kodedistributor').addClass('is-invalid');
                        //     $('.errorKodedistributor').html(response.error.kodedistributor);
                        // } else {
                        //     $('#kodedistributor').removeClass('is-invalid');
                        //     $('.errorKodedistributor').html('');
                        // }
                        if (response.error.nama) {
                            $('#nama').addClass('is-invalid');
                            $('.errorNama').html(response.error.nama);
                        } else {
                            $('#nama').removeClass('is-invalid');
                            $('.errorNama').html('');
                        }
                        if (response.error.kategori) {
                            $('#kategori').addClass('is-invalid');
                            $('.errorKategori').html(response.error.kategori);
                        } else {
                            $('#kategori').removeClass('is-invalid');
                            $('.errorKategori').html('');
                        }
                        if (response.error.alamat) {
                            $('#alamat').addClass('is-invalid');
                            $('.errorAlamat').html(response.error.alamat);
                        } else {
                            $('#alamat').removeClass('is-invalid');
                            $('.errorAlamat').html('');
                        }
                        if (response.error.kodekota) {
                            $('#kodekota').addClass('is-invalid');
                            $('.errorKodekota').html(response.error.kodekota);
                        } else {
                            $('#kodekota').removeClass('is-invalid');
                            $('.errorKodekota').html('');
                        }
                        if (response.error.kodenegara) {
                            $('#kodenegara').addClass('is-invalid');
                            $('.errorKodenegara').html(response.error.kodenegara);
                        } else {
                            $('#kodenegara').removeClass('is-invalid');
                            $('.errorKodenegara').html('');
                        }
                        if (response.error.namakontak) {
                            $('#namakontak').addClass('is-invalid');
                            $('.errorPhone_no').html(response.error.namakontak);
                        } else {
                            $('#namakontak').removeClass('is-invalid');
                            $('.errorPhone_no').html('');
                        }
                        if (response.error.nomorkontak) {
                            $('#nomorkontak').addClass('is-invalid');
                            $('.errorMobile_no').html(response.error.nomorkontak);
                        } else {
                            $('#nomorkontak').removeClass('is-invalid');
                            $('.errorMobile_no').html('');
                        }
                        if (response.error.email) {
                            $('#email').addClass('is-invalid');
                            $('.errorEmail').html(response.error.email);
                        } else {
                            $('#email').removeClass('is-invalid');
                            $('.errorEmail').html('');
                        }
                        if (response.error.npwp) {
                            $('#npwp').addClass('is-invalid');
                            $('.errorNpwp').html(response.error.npwp);
                        } else {
                            $('#npwp').removeClass('is-invalid');
                            $('.errorNpwp').html('');
                        }
                        if (response.error.namasebutan) {
                            $('#namasebutan').addClass('is-invalid');
                            $('.errorNamasebutan').html(response.error.namasebutan);
                        } else {
                            $('#namasebutan').removeClass('is-invalid');
                            $('.errorNamasebutan').html('');
                        }
                        if (response.error.tglterdaftar) {
                            $('#tglterdaftar').addClass('is-invalid');
                            $('.errorWhatsapp_cd').html(response.error.tglterdaftar);
                        } else {
                            $('#tglterdaftar').removeClass('is-invalid');
                            $('.errorWhatsapp_cd').html('');
                        }
                        if (response.error.emp_sta_cd) {
                            $('#emp_sta_cd').addClass('is-invalid');
                            $('.errorEmp_sta_cd').html(response.error.emp_sta_cd);
                        } else {
                            $('#emp_sta_cd').removeClass('is-invalid');
                            $('.errorEmp_sta_cd').html('');
                        }
                        if (response.error.jenis_dokter) {
                            $('#jenis_dokter').addClass('is-invalid');
                            $('.errorJenis_dokter').html(response.error.jenis_dokter);
                        } else {
                            $('#jenis_dokter').removeClass('is-invalid');
                            $('.errorJenis_dokter').html('');
                        }
                        if (response.error.spesialis) {
                            $('#spesialis').addClass('is-invalid');
                            $('.errorSpesialis').html(response.error.spesialis);
                        } else {
                            $('#spesialis').removeClass('is-invalid');
                            $('.errorSpesialis').html('');
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
                        $('#kodedistributor').removeClass('is-invalid');
                        $('#nama').removeClass('is-invalid');
                        $('#kategori').removeClass('is-invalid');
                        $('#spesailis').removeClass('is-invalid');
                        $('#namakontak').removeClass('is-invalid');
                        $('#nomorkontak').removeClass('is-invalid');
                        $('#email').removeClass('is-invalid');
                        $('#alamat').removeClass('is-invalid');
                        $('#kodekota').removeClass('is-invalid');
                        $('#kodenegara').removeClass('is-invalid');
                        $('#npwp').removeClass('is-invalid');
                        $('#namasebutan').removeClass('is-invalid');
                        $('#tglterdaftar').removeClass('is-invalid');
                        $('#inactive').removeAttr('checked');
                        $('#emp_sta_cd').removeClass('is-invalid');
                        $('#jenis_dokter').removeClass('is-invalid');


                        $('.errorEmp_cd').html('');
                        $('.errorAsr_nm').html('');
                        $('.errorKategori').html('');
                        $('.errorSpesialis').html('');
                        $('.errorPhone_no').html('');
                        $('.errorMobile_no').html('');
                        $('.errorEmail').html('');
                        $('.errorAlamat').html('');
                        $('.errorKodekota').html('');
                        $('.errorKodenegara').html('');
                        $('.errorNpwp').html('');
                        $('.errorNamasebutan').html('');
                        $('.errorWhatsapp_cd').html('');
                        $('.errorLevel_cd').html('');
                        $('.errorEmp_sta_cd').html('');
                        $('.errorPoli').html('');
                        $('.errorJenis_dokter').html('');

                        tmstdistributor();
                        $('#modalform').modal('hide');
                    }
                },
            })
        });

        $(document).on('click', '.view', function() {
            var kodedistributor = $(this).data('kodedistributor');

            $.ajax({
                url: "<?= site_url('tmstdistributor/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    kodedistributor: kodedistributor
                },
                dataType: "JSON",
                success: function(response) {
                    //set input
                    $('#kodedistributor').attr('disabled', '');
                    $('#nama').attr('disabled', '');
                    $('#kategori').attr('disabled', '');
                    $('#spesialis').attr('disabled', '');
                    $('#namakontak').attr('disabled', '');
                    $('#nomorkontak').attr('disabled', '');
                    $('#email').attr('disabled', '');
                    $('#alamat').attr('disabled', '');
                    $('#kodekota').attr('disabled', '');
                    $('#kodenegara').attr('disabled', '');
                    $('#npwp').attr('disabled', '');
                    $('#namasebutan').attr('disabled', '');
                    $('#tglterdaftar').attr('disabled', '');
                    // $('#inactive').attr('disabled', '');
                    $('#inactive').removeAttr('checked');
                    $('#emp_sta_cd').attr('disabled', '');
                    $('#jenis_dokter').attr('disabled', '');

                    $('#data_form')[0].reset();


                    //set data from response record
                    $('#kodedistributor').val(response.data.kodedistributor);
                    $('#nama').val(response.data.nama);
                    $('#kategori').val(response.data.kategori);
                    $('#spesialis').val(response.data.kategori);
                    $('#namakontak').val(response.data.namakontak);
                    $('#nomorkontak').val(response.data.nomorkontak);
                    $('#email').val(response.data.email);
                    $('#alamat').val(response.data.alamat);
                    $('#kodekota').val(response.data.kodekota);
                    $('#kodenegara').val(response.data.kodenegara);
                    $('#npwp').val(response.data.npwp);
                    $('#namasebutan').val(response.data.namasebutan);
                    $('#tglterdaftar').val(response.data.tglterdaftar);
                    $('#jenis_dokter').val(response.data.jenis_dokter);
                    (response.data.inactive === 1 ? $('#inactive').attr('checked', 'checked') : $('#inactive').removeAttr('checked'));
                    // (response.data.emp_sta_cd === 'A' ? $('#emp_sta_cd').attr('checked', 'checked') : $('#emp_sta_cd').removeAttr('checked'));

                    //set error validation
                    $('#kodedistributor').removeClass('is-invalid');
                    $('#nama').removeClass('is-invalid');
                    $('#kategori').removeClass('is-invalid');
                    $('#spesialis').removeClass('is-invalid');
                    $('#namakontak').removeClass('is-invalid');
                    $('#nomorkontak').removeClass('is-invalid');
                    $('#email').removeClass('is-invalid');
                    $('#alamat').removeClass('is-invalid');
                    $('#kodekota').removeClass('is-invalid');
                    $('#kodenegara').removeClass('is-invalid');
                    $('#npwp').removeClass('is-invalid');
                    $('#namasebutan').removeClass('is-invalid');
                    $('#tglterdaftar').removeClass('is-invalid');
                    $('#emp_sta_cd').removeClass('is-invalid');
                    $('#jenis_dokter').removeClass('is-invalid');

                    $('.errorEmp_cd').html('');
                    $('.errorEmp_nm').html('');
                    $('.errorKategori').html('');
                    $('.errorSpesialis').html('');
                    $('.errorPhone_no').html('');
                    $('.errorMobile_no').html('');
                    $('.errorEmail').html('');
                    $('.errorAlamat').html('');
                    $('.errorKodekota').html('');
                    $('.errorKodenegara').html('');
                    $('.errorNpwp').html('');
                    $('.errorNamasebutan').html('');
                    $('.errorWhatsapp_cd').html('');
                    $('.errorLevel_cd').html('');
                    $('.errorEmp_sta_cd').html('');
                    $('.errorPoli').html('');
                    $('.errorJenis_dokter').html('');

                    //set selected data select2
                    $('#emp_sta_cd').val(response.data.emp_sta_cd);
                    $('#emp_sta_cd').trigger('change');
                    $('#kategori').val(response.data.kategori);
                    $('#kategori').trigger('change');
                    $('#jenis_dokter').val(response.data.jenis_dokter);
                    $('#jenis_dokter').trigger('change');
                    $('#spesialis').val(response.data.spesialis);
                    $('#spesialis').trigger('change');

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
            var kodedistributor = $(this).data('kodedistributor');

            $.ajax({
                url: "<?= site_url('tmstdistributor/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    kodedistributor: kodedistributor
                },
                dataType: "JSON",
                success: function(response) {
                    //set input
                    // $('#kodedistributor').removeAttr('disabled');
                    $('#nama').removeAttr('disabled');
                    $('#kategori').removeAttr('disabled');
                    $('#spesialis').removeAttr('disabled');
                    $('#namakontak').removeAttr('disabled');
                    $('#nomorkontak').removeAttr('disabled');
                    $('#email').removeAttr('disabled');
                    $('#alamat').removeAttr('disabled');
                    $('#kodekota').removeAttr('disabled');
                    $('#kodenegara').removeAttr('disabled');
                    $('#npwp').removeAttr('disabled');
                    $('#namasebutan').removeAttr('disabled');
                    $('#tglterdaftar').removeAttr('disabled');
                    $('#emp_sta_cd').removeAttr('disabled');
                    $('#jenis_dokter').removeAttr('disabled');

                    // $('#kodedistributor').attr('disabled', '');
                    $('#kodedistributor').attr('readonly', '');
                    // $('#inactive').removeAttr('disabled');
                    $('#inactive').prop("disabled", false);
                    $('#inactive').removeAttr('checked');


                    $('#data_form')[0].reset();

                    // $('#inactive').attr('disabled', '');

                    //set datepicker input value


                    //set data from response record
                    $('#kodedistributor').val(response.data.kodedistributor);
                    $('#nama').val(response.data.nama);
                    $('#kategori').val(response.data.kategori);
                    $('#spesialis').val(response.data.spesialis);
                    $('#namakontak').val(response.data.namakontak);
                    $('#nomorkontak').val(response.data.nomorkontak);
                    $('#email').val(response.data.email);
                    $('#alamat').val(response.data.alamat);
                    $('#kodekota').val(response.data.kodekota);
                    $('#kodenegara').val(response.data.kodenegara);
                    $('#npwp').val(response.data.npwp);
                    $('#namasebutan').val(response.data.namasebutan);
                    $('#tglterdaftar').val(response.data.tglterdaftar);
                    $('#jenis_dokter').val(response.data.jenis_dokter);
                    (response.data.inactive === 1 ? $('#inactive').attr('checked', 'checked') : $('#inactive').removeAttr('checked'));
                    // (response.data.emp_sta_cd === 'A' ? $('#emp_sta_cd').attr('checked', 'checked') : $('#emp_sta_cd').removeAttr('checked'));

                    //set error validation
                    $('#kodedistributor').removeClass('is-invalid');
                    $('#nama').removeClass('is-invalid');
                    $('#kategori').removeClass('is-invalid');
                    $('#spesialis').removeClass('is-invalid');
                    $('#namakontak').removeClass('is-invalid');
                    $('#nomorkontak').removeClass('is-invalid');
                    $('#email').removeClass('is-invalid');
                    $('#alamat').removeClass('is-invalid');
                    $('#kodekota').removeClass('is-invalid');
                    $('#kodenegara').removeClass('is-invalid');
                    $('#npwp').removeClass('is-invalid');
                    $('#namasebutan').removeClass('is-invalid');
                    $('#tglterdaftar').removeClass('is-invalid');
                    $('#emp_sta_cd').removeClass('is-invalid');
                    $('#jenis_dokter').removeClass('is-invalid');

                    $('.errorEmp_cd').html('');
                    $('.errorEmp_nm').html('');
                    $('.errorKategori').html('');
                    $('.errorSpesialis').html('');
                    $('.errorPhone_no').html('');
                    $('.errorMobile_no').html('');
                    $('.errorEmail').html('');
                    $('.errorAlamat').html('');
                    $('.errorKodekota').html('');
                    $('.errorKodenegara').html('');
                    $('.errorNpwp').html('');
                    $('.errorNamasebutan').html('');
                    $('.errorWhatsapp_cd').html('');
                    $('.errorLevel_cd').html('');
                    $('.errorEmp_sta_cd').html('');
                    $('.errorPoli').html('');
                    $('.errorJenis_dokter').html('');

                    //set selected data select2
                    $('#emp_sta_cd').val(response.data.emp_sta_cd);
                    $('#emp_sta_cd').trigger('change');
                    $('#kategori').val(response.data.kategori);
                    $('#kategori').trigger('change');
                    $('#jenis_dokter').val(response.data.jenis_dokter);
                    $('#jenis_dokter').trigger('change');
                    $('#spesialis').val(response.data.spesialis);
                    $('#spesialis').trigger('change');


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
            var kodedistributor = $(this).data('kodedistributor');
            if (confirm("Are you sure you want to remove it?")) {
                $.ajax({
                    url: "<?= site_url('tmstdistributor/delete'); ?>",
                    method: "POST",
                    data: {
                        kodedistributor: kodedistributor
                    },
                    dataType: "JSON",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                            //footer: '<a href="">Why do I have this issue?</a>'
                        });
                        tmstdistributor();
                        setTimeout(function() {
                            $('#message').html('');
                        }, 5000);
                    }
                })
            }
        });

        // $('#kategori').on("change", function(e) {
        //     var val = $(this).val();
        //     if (val === 'dokter') {
        //         // $('#asr_cd').removeAttr('disabled');

        //         $('#jenis_dokter').removeAttr('disabled');

        //         $('#employee_status').removeAttr('disabled');

        //         $('#tujuan_registrasi').removeAttr('disabled');
        //     } else {
        //         // $('#asr_cd').val(' ');
        //         // $('#asr_cd').trigger('change');
        //         // $('#asr_cd').attr('disabled', '');

        //         $('#jenis_dokter').val(' ');
        //         $('#jenis_dokter').trigger('change');
        //         $('#jenis_dokter').attr('disabled', '');

        //         $('#employee_status').val(' ');
        //         $('#employee_status').trigger('change');
        //         $('#employee_status').attr('disabled', '');

        //         $('#tujuan_registrasi').val(' ');
        //         $('#tujuan_registrasi').trigger('change');
        //         $('#tujuan_registrasi').attr('disabled', '');
        //     }
        // });
    });
</script>



<?= $this->endSection('script'); ?>