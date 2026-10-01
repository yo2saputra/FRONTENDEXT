<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>
<!-- Toastr -->
<link rel="stylesheet" href="<?= base_url('plugins/toastr/toastr.min.css') ?>">
<!-- Button datatable -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<!-- datepicker styles -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="<?= base_url('plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">

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

    select.is-invalid#id_typ {
        border-color: #FF0000 !important;
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
                        <li class="breadcrumb-item active">patient</li>
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
                                            <div class="col-12 col-sm-12">
                                                <div class="card card-primary card-outline card-outline-tabs">
                                                    <div class="card-header p-0 border-bottom-0">
                                                        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                                            <li class="nav-item">
                                                                <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Informasi Umum</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Domisili</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">Keluarga Terdekat</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="tab-content" id="custom-tabs-four-tabContent">
                                                            <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                                                <div class="col-sm-12">
                                                                    <div class="mb-3 row">
                                                                        <label for="" class="col-sm-4 col-form-label">Pasien No.</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control form-control-sm" id="patient_no" name="patient_no" autofocus autocomplete="off">
                                                                            <span class="error invalid-feedback errorPatient_no">
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 row">
                                                                        <label for="" class="col-sm-4 col-form-label">Nama Pasien</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control form-control-sm" id="fullname" name="fullname" autocomplete="off">
                                                                            <span class="error invalid-feedback errorFullname">
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <?= $cb_id_typ ?>
                                                                    <div class="mb-3 row">
                                                                        <label for="" class="col-sm-4 col-form-label">No. Identitas Pasien</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control form-control-sm" id="id_no" name="id_no" autocomplete="off">
                                                                            <span class="error invalid-feedback errorId_no">
                                                                            </span>
                                                                        </div>
                                                                    </div>

                                                                    <?= $cb_gender ?>
                                                                    <?= $cb_married_sta_id ?>
                                                                    <div class="mb-3 row">
                                                                        <label for="" class="col-sm-4 col-form-label">No. Hp</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control form-control-sm" id="mobile_no" name="mobile_no" placeholder="No. Hp" autocomplete="off">
                                                                            <span class="error invalid-feedback errorMobile_no">
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <?= $cb_religion ?>
                                                                    <?= $cb_job_title_cd ?>
                                                                    <?= $cb_education ?>
                                                                    <?= $cb_source_info ?>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                                                                <div class="col-sm-12">
                                                                    <div class="mb-3 row">
                                                                        <label for="" class="col-sm-4 col-form-label">Tempat / Tanggal Lahir</label>
                                                                        <div class="col-sm-4">
                                                                            <input type="text" class="form-control form-control-sm" placeholder="Tempat Lahir" id="birthplace" name="birthplace" autocomplete="off">
                                                                            <span class="error invalid-feedback errorBirthplace">
                                                                            </span>
                                                                        </div>
                                                                        <div class="col-sm-4">
                                                                            <div class="input-group date birth_dt" data-date-format="mm/dd/yyyy">
                                                                                <input type="text" class="form-control form-control-sm datepicker" placeholder="mm/dd/yyyy" id="birth_dt" name="birth_dt" autocomplete="off">
                                                                                <div class="input-group-append" data-target="#birth_dt" data-toggle="birth_dt">
                                                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                                </div>
                                                                            </div>
                                                                            <span class="error invalid-feedback errorBirth_dt">
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 row">
                                                                        <label for="" class="col-sm-4 col-form-label">Alamat Lengkap</label>
                                                                        <div class="col-sm-8">
                                                                            <textarea class="form-control form-control-sm" rows="3" placeholder="..." id="addr" name="addr" autocomplete="off"></textarea>
                                                                            <span class="error invalid-feedback errorAddr">
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 row">
                                                                        <label for="" class="col-sm-4 col-form-label"></label>
                                                                        <?= $cb_city_cd ?>
                                                                        <div class="col-sm-4">
                                                                            <input type="text" class="form-control form-control-sm" id="postcode" name="postcode" placeholder="Kode Pos" autocomplete="off">
                                                                            <span class="error invalid-feedback errorPostcode">
                                                                            </span>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
                                                                <div class="col-sm-12">
                                                                    <div class="mb-3 row">
                                                                        <label for="" class="col-sm-4 col-form-label">Nama Lengkap</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control form-control-sm" id="family_name" name="family_name" autocomplete="off">
                                                                            <span class="error invalid-feedback errorFamily_name">
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 row">
                                                                        <label for="" class="col-sm-4 col-form-label">Alamat Lengkap</label>
                                                                        <div class="col-sm-8">
                                                                            <textarea class="form-control form-control-sm" rows="3" placeholder="..." id="family_addr" name="family_addr" autocomplete="off"></textarea>
                                                                            <span class="error invalid-feedback errorFamily_addr">
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 row">
                                                                        <label for="" class="col-sm-4 col-form-label">No. Hp</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control form-control-sm" id="family_handphone" name="family_handphone" autocomplete="off">
                                                                            <span class="error invalid-feedback errorFamily_handphone">
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <?= $cb_family_relation ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /.card -->
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

<!-- Select2 -->
<script src="<?= base_url('plugins/select2/js/select2.full.min.js') ?>"></script>

<!-- Datepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<!-- set menu name by active-menu -->
<script>
    $('#active-menu').html($('p#active-menu').html()); // set top navbar
    $(document).prop("title", $('p#active-menu').html()); // set title
</script>

<script>
    $(".select").select2({
        minimumResultsForSearch: Infinity
    });
    $('#birth_dt').datepicker({
        todayHighlight: true,
        autoclose: true,
        dateFormat: 'MM/DD/YYYY'
    }).val();
</script>

<script>
    function patient() {
        $.ajax({
            method: "get",
            url: "<?= site_url('patient/fetchAll'); ?>",
            success: function(data) {
                $('#viewdata').html(data);
            }
        });
    }
    $(document).ready(function() {

        patient()

        //datatable server side
        // $('#sample_table').DataTable({
        //     "order": [],
        //     "serverSide": true,
        //     "ajax": {
        //         url: "<?php echo base_url("/ajax_crud/fetchAll"); ?>",
        //         type: "POST",
        //     }
        // });

        //Initialize Select2 Elements
        $('.select2').select2()

        $(document).on('click', '#add_record', function() {

            //set input
            $('#patient_no').removeAttr('disabled');
            $('#fullname').removeAttr('disabled');
            $('#id_typ').removeAttr('disabled');
            $('#id_no').removeAttr('disabled');
            $('#gender').removeAttr('disabled');
            $('#addr').removeAttr('disabled');
            $('#mobile_no').removeAttr('disabled');
            $('#birth_dt').removeAttr('disabled');
            $('#register_dt').removeAttr('disabled');
            $('#job_title_cd').removeAttr('disabled');
            $('#religion').removeAttr('disabled');
            $('#city_cd').removeAttr('disabled');
            $('#postcode').removeAttr('disabled');
            $('#phone_no').removeAttr('disabled');
            $('#birthplace').removeAttr('disabled');
            $('#married_sta_id').removeAttr('disabled');
            $('#createdby').removeAttr('disabled');
            $('#education').removeAttr('disabled');
            $('#source_info').removeAttr('disabled');
            $('#family_name').removeAttr('disabled');
            $('#family_addr').removeAttr('disabled');
            $('#family_handphone').removeAttr('disabled');
            $('#family_relation').removeAttr('disabled');
            $('#patient_no').prop('disabled', true);

            //set datepicker input value
            $('#birth_dt').datepicker('update', '');

            $('#data_form')[0].reset();
            // $('.modal-title').text('Add Data');

            //set error validation
            $('#patient_no').removeClass('is-invalid');
            $('#fullname').removeClass('is-invalid');
            $('#id_typ').removeClass('is-invalid');
            $("[aria-labelledby=select2-id_typ-container]").css("border-color", "#aaa");
            $('#id_no').removeClass('is-invalid');
            $('#gender').removeClass('is-invalid');
            $('#addr').removeClass('is-invalid');
            $('#mobile_no').removeClass('is-invalid');
            $('#birth_dt').removeClass('is-invalid');
            $('#register_dt').removeClass('is-invalid');
            $('#job_title_cd').removeClass('is-invalid');
            $('#religion').removeClass('is-invalid');
            $('#city_cd').removeClass('is-invalid');
            $('#postcode').removeClass('is-invalid');
            $('#phone_no').removeClass('is-invalid');
            $('#birthplace').removeClass('is-invalid');
            $('#married_sta_id').removeClass('is-invalid');
            $('#createdby').removeClass('is-invalid');
            $('#education').removeClass('is-invalid');
            $('#source_info').removeClass('is-invalid');
            $('#family_name').removeClass('is-invalid');
            $('#family_addr').removeClass('is-invalid');
            $('#family_handphone').removeClass('is-invalid');
            $('#family_relation').removeClass('is-invalid');

            $('.errorPatient_no').html('');
            $('.errorFullname').html('');
            $('.errorId_typ').html('');
            $('.errorId_no').html('');
            $('.errorGender').html('');
            $('.errorAddr').html('');
            $('.errorMobile_no').html('');
            $('.errorBirth_dt').html('');
            $('.errorRegister_dt').html('');
            $('.errorJob_title_cd').html('');
            $('.errorReligion').html('');
            $('.errorCity_cd').html('');
            $('.errorPostcode').html('');
            $('.errorPhone_no').html('');
            $('.errorBirthplace').html('');
            $('.errorMarried_sta_id').html('');
            $('.errorCreatedby').html('');
            $('.errorEducation').html('');
            $('.errorSource_info').html('');
            $('.errorFamily_name').html('');
            $('.errorFamily_addr').html('');
            $('.errorFamily_handphone').html('');
            $('.errorFamily_relation').html('');

            //clear input value
            $('#patient_no').val('');
            $('#fullname').val('');
            // $('#id_typ').val('');
            $('#id_no').val('');
            // $('#gender').val('');
            $('#addr').text('');
            $('#mobile_no').val('');
            $('#birth_dt').val('');
            $('#register_dt').val('');
            // $('#job_title_cd').val('');
            // $('#religion').val('');
            // $('#city_cd').val('');
            $('#postcode').val('');
            $('#phone_no').val('');
            $('#birthplace').val('');
            // $('#married_sta_id').val('');
            $('#createdby').val('');
            // $('#education').val('');
            // $('#source_info').val('');
            $('#family_name').val('');
            $('#family_addr').text('');
            $('#family_handphone').val('');
            // $('#family_relation').val('');

            //set selected data select2
            $('#gender').val(' ');
            $('#gender').trigger('change');
            $('#id_typ').val(' ');
            $('#id_typ').trigger('change');
            $('#job_title_cd').val(' ');
            $('#job_title_cd').trigger('change');
            $('#religion').val(' ');
            $('#religion').trigger('change');
            $('#city_cd').val(' ');
            $('#city_cd').trigger('change');
            $('#married_sta_id').val(' ');
            $('#married_sta_id').trigger('change');
            $('#education').val(' ');
            $('#education').trigger('change');
            $('#source_info').val(' ');
            $('#source_info').trigger('change');
            $('#family_relation').val(' ');
            $('#family_relation').trigger('change');

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
            // alert($('#birth_dt').datepicker('getFormattedDate', 'yyyy-mm-dd'));
            //$('.birth_dt').val($('#birth_dt').datepicker('getFormattedDate', 'dd/mm/yyyy'));
            //$('#birth_dt').val('30/01/2023');
            // alert($('#patient_no').val());
            // alert($('#postcode').val());

            $.ajax({
                url: "<?= site_url('patient/action'); ?>",
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
                        if (response.error.patient_no) {
                            $('#patient_no').addClass('is-invalid');
                            $('.errorPatient_no').html(response.error.patient_no);
                        } else {
                            $('#patient_no').removeClass('is-invalid');
                            $('.errorPatient_no').html('');
                        }
                        if (response.error.fullname) {
                            $('#fullname').addClass('is-invalid');
                            $('.errorFullname').html(response.error.fullname);
                        } else {
                            $('#fullname').removeClass('is-invalid');
                            $('.errorFullname').html('');
                        }
                        if (response.error.id_typ) {
                            $('#id_typ').addClass('is-invalid');
                            $('.errorId_typ').html(response.error.id_typ);
                        } else {
                            $('#id_typ').removeClass('is-invalid');
                            $('.errorId_typ').html('');
                        }
                        if (response.error.id_no) {
                            $('#id_no').addClass('is-invalid');
                            $('.errorId_no').html(response.error.id_no);
                        } else {
                            $('#id_no').removeClass('is-invalid');
                            $('.errorId_no').html('');
                        }
                        if (response.error.gender) {
                            $('#gender').addClass('is-invalid');
                            $('.errorGender').html(response.error.gender);
                        } else {
                            $('#gender').removeClass('is-invalid');
                            $('.errorGender').html('');
                        }
                        if (response.error.addr) {
                            $('#addr').addClass('is-invalid');
                            $('.errorAddr').html(response.error.addr);
                        } else {
                            $('#addr').removeClass('is-invalid');
                            $('.errorAddr').html('');
                        }
                        if (response.error.mobile_no) {
                            $('#mobile_no').addClass('is-invalid');
                            $('.errorMobile_no').html(response.error.mobile_no);
                        } else {
                            $('#mobile_no').removeClass('is-invalid');
                            $('.errorMobile_no').html('');
                        }
                        if (response.error.birth_dt) {
                            $('#birth_dt').addClass('is-invalid');
                            $('.errorBirth_dt').html(response.error.birth_dt);
                        } else {
                            $('#birth_dt').removeClass('is-invalid');
                            $('.errorBirth_dt').html('');
                        }
                        if (response.error.register_dt) {
                            $('#register_dt').addClass('is-invalid');
                            $('.errorRegister_dt').html(response.error.register_dt);
                        } else {
                            $('#register_dt').removeClass('is-invalid');
                            $('.errorRegister_dt').html('');
                        }
                        if (response.error.job_title_cd) {
                            $('#job_title_cd').addClass('is-invalid');
                            $('.errorJob_title_cd').html(response.error.job_title_cd);
                        } else {
                            $('#job_title_cd').removeClass('is-invalid');
                            $('.errorJob_title_cd').html('');
                        }
                        if (response.error.religion) {
                            $('#religion').addClass('is-invalid');
                            $('.errorReligion').html(response.error.religion);
                        } else {
                            $('#religion').removeClass('is-invalid');
                            $('.errorReligion').html('');
                        }
                        if (response.error.city_cd) {
                            $('#city_cd').addClass('is-invalid');
                            $('.errorCity_cd').html(response.error.city_cd);
                        } else {
                            $('#city_cd').removeClass('is-invalid');
                            $('.errorCity_cd').html('');
                        }
                        if (response.error.postcode) {
                            $('#postcode').addClass('is-invalid');
                            $('.errorPostcode').html(response.error.postcode);
                        } else {
                            $('#postcode').removeClass('is-invalid');
                            $('.errorPostcode').html('');
                        }
                        if (response.error.phone_no) {
                            $('#phone_no').addClass('is-invalid');
                            $('.errorPhone_no').html(response.error.phone_no);
                        } else {
                            $('#phone_no').removeClass('is-invalid');
                            $('.errorPhone_no').html('');
                        }
                        if (response.error.birthplace) {
                            $('#birthplace').addClass('is-invalid');
                            $('.errorBirthplace').html(response.error.birthplace);
                        } else {
                            $('#birthplace').removeClass('is-invalid');
                            $('.errorBirthplace').html('');
                        }
                        if (response.error.married_sta_id) {
                            $('#married_sta_id').addClass('is-invalid');
                            $('.errorMarried_sta_id').html(response.error.married_sta_id);
                        } else {
                            $('#married_sta_id').removeClass('is-invalid');
                            $('.errorMarried_sta_id').html('');
                        }
                        if (response.error.createdby) {
                            $('#createdby').addClass('is-invalid');
                            $('.errorCreatedby').html(response.error.createdby);
                        } else {
                            $('#createdby').removeClass('is-invalid');
                            $('.errorCreatedby').html('');
                        }
                        if (response.error.education) {
                            $('#education').addClass('is-invalid');
                            $('.errorEducation').html(response.error.education);
                        } else {
                            $('#education').removeClass('is-invalid');
                            $('.errorEducation').html('');
                        }
                        if (response.error.source_info) {
                            $('#source_info').addClass('is-invalid');
                            $('.errorSource_info').html(response.error.source_info);
                        } else {
                            $('#source_info').removeClass('is-invalid');
                            $('.errorSource_info').html('');
                        }
                        if (response.error.family_name) {
                            $('#family_name').addClass('is-invalid');
                            $('.errorFamily_name').html(response.error.family_name);
                        } else {
                            $('#family_name').removeClass('is-invalid');
                            $('.errorFamily_name').html('');
                        }
                        if (response.error.family_addr) {
                            $('#family_addr').addClass('is-invalid');
                            $('.errorFamily_addr').html(response.error.family_addr);
                        } else {
                            $('#family_addr').removeClass('is-invalid');
                            $('.errorFamily_addr').html('');
                        }
                        if (response.error.family_handphone) {
                            $('#family_handphone').addClass('is-invalid');
                            $('.errorFamily_handphone').html(response.error.family_handphone);
                        } else {
                            $('#family_handphone').removeClass('is-invalid');
                            $('.errorFamily_handphone').html('');
                        }
                        if (response.error.family_relation) {
                            $('#family_relation').addClass('is-invalid');
                            $('.errorFamily_relation').html(response.error.family_relation);
                        } else {
                            $('#family_relation').removeClass('is-invalid');
                            $('.errorFamily_relation').html('');
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
                        $('#patient_no').removeClass('is-invalid');
                        $('#fullname').removeClass('is-invalid');
                        $('#id_typ').removeClass('is-invalid');
                        $('#id_no').removeClass('is-invalid');
                        $('#gender').removeClass('is-invalid');
                        $('#addr').removeClass('is-invalid');
                        $('#mobile_no').removeClass('is-invalid');
                        $('#birth_dt').removeClass('is-invalid');
                        $('#register_dt').removeClass('is-invalid');
                        $('#job_title_cd').removeClass('is-invalid');
                        $('#religion').removeClass('is-invalid');
                        $('#city_cd').removeClass('is-invalid');
                        $('#postcode').removeClass('is-invalid');
                        $('#phone_no').removeClass('is-invalid');
                        $('#birthplace').removeClass('is-invalid');
                        $('#married_sta_id').removeClass('is-invalid');
                        $('#createdby').removeClass('is-invalid');
                        $('#education').removeClass('is-invalid');
                        $('#source_info').removeClass('is-invalid');
                        $('#family_name').removeClass('is-invalid');
                        $('#family_addr').removeClass('is-invalid');
                        $('#family_handphone').removeClass('is-invalid');
                        $('#family_relation').removeClass('is-invalid');

                        $('.errorPatient_no').html('');
                        $('.errorFullname').html('');
                        $('.errorId_typ').html('');
                        $('.errorId_no').html('');
                        $('.errorGender').html('');
                        $('.errorAddr').html('');
                        $('.errorMobile_no').html('');
                        $('.errorBirth_dt').html('');
                        $('.errorRegister_dt').html('');
                        $('.errorJob_title_cd').html('');
                        $('.errorReligion').html('');
                        $('.errorCity_cd').html('');
                        $('.errorPostcode').html('');
                        $('.errorPhone_no').html('');
                        $('.errorBirthplace').html('');
                        $('.errorMarried_sta_id').html('');
                        $('.errorCreatedby').html('');
                        $('.errorEducation').html('');
                        $('.errorSource_info').html('');
                        $('.errorFamily_name').html('');
                        $('.errorFamily_addr').html('');
                        $('.errorFamily_handphone').html('');
                        $('.errorFamily_relation').html('');

                        patient();
                        $('#modalform').modal('hide');
                    }
                },
            })
        });

        $(document).on('click', '.view', function() {
            var patient_no = $(this).data('patient_no');

            $.ajax({
                url: "<?= site_url('patient/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    patient_no: patient_no
                },
                dataType: "JSON",
                success: function(response) {

                    $('#patient_no').attr('disabled', '');
                    $('#fullname').attr('disabled', '');
                    $('#id_typ').attr('disabled', '');
                    $('#id_no').attr('disabled', '');
                    $('#gender').attr('disabled', '');
                    $('#addr').attr('disabled', '');
                    $('#mobile_no').attr('disabled', '');
                    $('#birth_dt').attr('disabled', '');
                    $('#register_dt').attr('disabled', '');
                    $('#job_title_cd').attr('disabled', '');
                    $('#religion').attr('disabled', '');
                    $('#city_cd').attr('disabled', '');
                    $('#postcode').attr('disabled', '');
                    $('#phone_no').attr('disabled', '');
                    $('#birthplace').attr('disabled', '');
                    $('#married_sta_id').attr('disabled', '');
                    $('#createdby').attr('disabled', '');
                    $('#education').attr('disabled', '');
                    $('#source_info').attr('disabled', '');
                    $('#family_name').attr('disabled', '');
                    $('#family_addr').attr('disabled', '');
                    $('#family_handphone').attr('disabled', '');
                    $('#family_relation').attr('disabled', '');
                    $('#patient_no').prop('disabled', false);

                    //set input readonly
                    $('#patient_no').attr('readonly', '');

                    //set datepicker input value
                    $('#birth_dt').datepicker('update', response.data.birth_dt);

                    //set data from response record
                    $('#patient_no').val(response.data.patient_no);
                    $('#fullname').val(response.data.fullname);
                    $('#id_typ').val(response.data.id_typ);
                    $('#id_no').val(response.data.id_no);
                    $('#gender').val(response.data.gender);
                    $('#addr').text(response.data.addr);
                    $('#mobile_no').val(response.data.mobile_no);
                    $('#birth_dt').val(response.data.birth_dt);
                    $('#register_dt').val(response.data.register_dt);
                    $('#job_title_cd').val(response.data.job_title_cd);
                    $('#religion').val(response.data.religion);
                    $('#city_cd').val(response.data.city_cd);
                    $('#postcode').val(response.data.postcode);
                    $('#phone_no').val(response.data.phone_no);
                    $('#birthplace').val(response.data.birthplace);
                    $('#married_sta_id').val(response.data.married_sta_id);
                    $('#createdby').val(response.data.createdby);
                    $('#education').val(response.data.education);
                    $('#source_info').val(response.data.source_info);
                    $('#family_name').val(response.data.family_name);
                    $('#family_addr').text(response.data.family_addr);
                    $('#family_handphone').val(response.data.family_handphone);
                    $('#family_relation').val(response.data.family_relation);

                    //set error validation
                    $('#patient_no').removeClass('is-invalid');
                    $('#fullname').removeClass('is-invalid');
                    $('#id_typ').removeClass('is-invalid');
                    $('#id_no').removeClass('is-invalid');
                    $('#gender').removeClass('is-invalid');
                    $('#addr').removeClass('is-invalid');
                    $('#mobile_no').removeClass('is-invalid');
                    $('#birth_dt').removeClass('is-invalid');
                    $('#register_dt').removeClass('is-invalid');
                    $('#job_title_cd').removeClass('is-invalid');
                    $('#religion').removeClass('is-invalid');
                    $('#city_cd').removeClass('is-invalid');
                    $('#postcode').removeClass('is-invalid');
                    $('#phone_no').removeClass('is-invalid');
                    $('#birthplace').removeClass('is-invalid');
                    $('#married_sta_id').removeClass('is-invalid');
                    $('#createdby').removeClass('is-invalid');
                    $('#education').removeClass('is-invalid');
                    $('#source_info').removeClass('is-invalid');
                    $('#family_name').removeClass('is-invalid');
                    $('#family_addr').removeClass('is-invalid');
                    $('#family_handphone').removeClass('is-invalid');
                    $('#family_relation').removeClass('is-invalid');

                    $('.errorPatient_no').html('');
                    $('.errorFullname').html('');
                    $('.errorId_typ').html('');
                    $('.errorId_no').html('');
                    $('.errorGender').html('');
                    $('.errorAddr').html('');
                    $('.errorMobile_no').html('');
                    $('.errorBirth_dt').html('');
                    $('.errorRegister_dt').html('');
                    $('.errorJob_title_cd').html('');
                    $('.errorReligion').html('');
                    $('.errorCity_cd').html('');
                    $('.errorPostcode').html('');
                    $('.errorPhone_no').html('');
                    $('.errorBirthplace').html('');
                    $('.errorMarried_sta_id').html('');
                    $('.errorCreatedby').html('');
                    $('.errorEducation').html('');
                    $('.errorSource_info').html('');
                    $('.errorFamily_name').html('');
                    $('.errorFamily_addr').html('');
                    $('.errorFamily_handphone').html('');
                    $('.errorFamily_relation').html('');


                    //set selected data select2
                    $('#gender').val(response.data.gender);
                    $('#gender').trigger('change');
                    $('#id_typ').val(response.data.id_typ);
                    $('#id_typ').trigger('change');
                    $('#job_title_cd').val(response.data.job_title_cd);
                    $('#job_title_cd').trigger('change');
                    $('#religion').val(response.data.religion);
                    $('#religion').trigger('change');
                    $('#city_cd').val(response.data.city_cd);
                    $('#city_cd').trigger('change');
                    $('#married_sta_id').val(response.data.married_sta_id);
                    $('#married_sta_id').trigger('change');
                    $('#education').val(response.data.education);
                    $('#education').trigger('change');
                    $('#source_info').val(response.data.source_info);
                    $('#source_info').trigger('change');
                    $('#family_relation').val(response.data.family_relation);
                    $('#family_relation').trigger('change');

                    //set selected data
                    // $("#gender option[value='" + response.data.gender + "']").attr('selected', 'selected');
                    // $("#id_typ option[value='" + response.data.id_typ + "']").attr('selected', 'selected');
                    // $("#job_title_cd option[value='" + response.data.job_title_cd + "']").attr('selected', 'selected');
                    // $("#religion option[value='" + response.data.religion + "']").attr('selected', 'selected');
                    // $("#city_cd option[value='" + response.data.city_cd + "']").attr('selected', 'selected');
                    // $("#married_sta_id option[value='" + response.data.married_sta_id + "']").attr('selected', 'selected');
                    // $("#source_info option[value='" + response.data.source_info + "']").attr('selected', 'selected');
                    // $("#education option[value='" + response.data.education + "']").attr('selected', 'selected');
                    // $("#family_relation option[value='" + response.data.family_relation + "']").attr('selected', 'selected');

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
                url: "<?= site_url('patient/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    patient_no: patient_no
                },
                dataType: "JSON",
                success: function(response) {

                    $('#patient_no').removeAttr('disabled');
                    $('#fullname').removeAttr('disabled');
                    $('#id_typ').removeAttr('disabled');
                    $('#id_no').removeAttr('disabled');
                    $('#gender').removeAttr('disabled');
                    $('#addr').removeAttr('disabled');
                    $('#mobile_no').removeAttr('disabled');
                    $('#birth_dt').removeAttr('disabled');
                    $('#register_dt').removeAttr('disabled');
                    $('#job_title_cd').removeAttr('disabled');
                    $('#religion').removeAttr('disabled');
                    $('#city_cd').removeAttr('disabled');
                    $('#postcode').removeAttr('disabled');
                    $('#phone_no').removeAttr('disabled');
                    $('#birthplace').removeAttr('disabled');
                    $('#married_sta_id').removeAttr('disabled');
                    $('#createdby').removeAttr('disabled');
                    $('#education').removeAttr('disabled');
                    $('#source_info').removeAttr('disabled');
                    $('#family_name').removeAttr('disabled');
                    $('#family_addr').removeAttr('disabled');
                    $('#family_handphone').removeAttr('disabled');
                    $('#family_relation').removeAttr('disabled');
                    $('#patient_no').prop('disabled', false);

                    //set input readonly
                    $('#patient_no').attr('readonly', '');

                    //set datepicker input value
                    $('#birth_dt').datepicker('update', response.data.birth_dt);

                    //set data from response record
                    $('#patient_no').val(response.data.patient_no);
                    $('#fullname').val(response.data.fullname);
                    $('#id_typ').val(response.data.id_typ);
                    $('#id_no').val(response.data.id_no);
                    $('#gender').val(response.data.gender);
                    $('#addr').text(response.data.addr);
                    $('#mobile_no').val(response.data.mobile_no);
                    $('#birth_dt').val(response.data.birth_dt);
                    $('#register_dt').val(response.data.register_dt);
                    $('#job_title_cd').val(response.data.job_title_cd);
                    $('#religion').val(response.data.religion);
                    $('#city_cd').val(response.data.city_cd);
                    $('#postcode').val(response.data.postcode);
                    $('#phone_no').val(response.data.phone_no);
                    $('#birthplace').val(response.data.birthplace);
                    $('#married_sta_id').val(response.data.married_sta_id);
                    $('#createdby').val(response.data.createdby);
                    $('#education').val(response.data.education);
                    $('#source_info').val(response.data.source_info);
                    $('#family_name').val(response.data.family_name);
                    $('#family_addr').text(response.data.family_addr);
                    $('#family_handphone').val(response.data.family_handphone);
                    $('#family_relation').val(response.data.family_relation);

                    //set error validation
                    $('#patient_no').removeClass('is-invalid');
                    $('#fullname').removeClass('is-invalid');
                    $('#id_typ').removeClass('is-invalid');
                    $('#id_no').removeClass('is-invalid');
                    $('#gender').removeClass('is-invalid');
                    $('#addr').removeClass('is-invalid');
                    $('#mobile_no').removeClass('is-invalid');
                    $('#birth_dt').removeClass('is-invalid');
                    $('#register_dt').removeClass('is-invalid');
                    $('#job_title_cd').removeClass('is-invalid');
                    $('#religion').removeClass('is-invalid');
                    $('#city_cd').removeClass('is-invalid');
                    $('#postcode').removeClass('is-invalid');
                    $('#phone_no').removeClass('is-invalid');
                    $('#birthplace').removeClass('is-invalid');
                    $('#married_sta_id').removeClass('is-invalid');
                    $('#createdby').removeClass('is-invalid');
                    $('#education').removeClass('is-invalid');
                    $('#source_info').removeClass('is-invalid');
                    $('#family_name').removeClass('is-invalid');
                    $('#family_addr').removeClass('is-invalid');
                    $('#family_handphone').removeClass('is-invalid');
                    $('#family_relation').removeClass('is-invalid');

                    $('.errorPatient_no').html('');
                    $('.errorFullname').html('');
                    $('.errorId_typ').html('');
                    $('.errorId_no').html('');
                    $('.errorGender').html('');
                    $('.errorAddr').html('');
                    $('.errorMobile_no').html('');
                    $('.errorBirth_dt').html('');
                    $('.errorRegister_dt').html('');
                    $('.errorJob_title_cd').html('');
                    $('.errorReligion').html('');
                    $('.errorCity_cd').html('');
                    $('.errorPostcode').html('');
                    $('.errorPhone_no').html('');
                    $('.errorBirthplace').html('');
                    $('.errorMarried_sta_id').html('');
                    $('.errorCreatedby').html('');
                    $('.errorEducation').html('');
                    $('.errorSource_info').html('');
                    $('.errorFamily_name').html('');
                    $('.errorFamily_addr').html('');
                    $('.errorFamily_handphone').html('');
                    $('.errorFamily_relation').html('');


                    //set selected data select2
                    $('#gender').val(response.data.gender);
                    $('#gender').trigger('change');
                    $('#id_typ').val(response.data.id_typ);
                    $('#id_typ').trigger('change');
                    $('#job_title_cd').val(response.data.job_title_cd);
                    $('#job_title_cd').trigger('change');
                    $('#religion').val(response.data.religion);
                    $('#religion').trigger('change');
                    $('#city_cd').val(response.data.city_cd);
                    $('#city_cd').trigger('change');
                    $('#married_sta_id').val(response.data.married_sta_id);
                    $('#married_sta_id').trigger('change');
                    $('#education').val(response.data.education);
                    $('#education').trigger('change');
                    $('#source_info').val(response.data.source_info);
                    $('#source_info').trigger('change');
                    $('#family_relation').val(response.data.family_relation);
                    $('#family_relation').trigger('change');

                    //set selected data
                    // $("#gender option[value='" + response.data.gender + "']").attr('selected', 'selected');
                    // $("#id_typ option[value='" + response.data.id_typ + "']").attr('selected', 'selected');
                    // $("#job_title_cd option[value='" + response.data.job_title_cd + "']").attr('selected', 'selected');
                    // $("#religion option[value='" + response.data.religion + "']").attr('selected', 'selected');
                    // $("#city_cd option[value='" + response.data.city_cd + "']").attr('selected', 'selected');
                    // $("#married_sta_id option[value='" + response.data.married_sta_id + "']").attr('selected', 'selected');
                    // $("#source_info option[value='" + response.data.source_info + "']").attr('selected', 'selected');
                    // $("#education option[value='" + response.data.education + "']").attr('selected', 'selected');
                    // $("#family_relation option[value='" + response.data.family_relation + "']").attr('selected', 'selected');

                    //set modal & form
                    $('.modal-title').text('Ubah Data');
                    $('#action').val('Edit');
                    $('#submit_button').show();
                    $('#submit_button').val('Simpan');
                    $('#submit_button').html('Simpan');
                    $('#modalform').modal('show');
                    $('#hidden_id').val(patient_no);
                }
            })
        });

        $(document).on('click', '.delete', function() {
            var patient_no = $(this).data('patient_no');
            if (confirm("Are you sure you want to remove it?")) {
                $.ajax({
                    url: "<?= site_url('patient/delete'); ?>",
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
                        patient();
                        setTimeout(function() {
                            $('#message').html('');
                        }, 5000);
                    }
                })
            }
        });

        $(document).on('click', '.usia', function() {
            var patient_no = $(this).data('patient_no');

            $.ajax({
                url: "<?= site_url('patient/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    patient_no: patient_no
                },
                dataType: "JSON",
                success: function(response) {

                    $('#patient_no').prop('disabled', false);

                    //set input
                    $('#patient_no').attr('readonly', '');
                    $('#value').attr('readonly', '');

                    //set data from response record
                    $('#patient_no').val(response.data.patient_no);
                    $('#fullname').val(response.data.fullname);
                    $('#id_no').val(response.data.id_no);
                    $('#gender').val(response.data.gender);
                    $('#addr').val(response.data.addr);
                    $('#mobile_no').val(response.data.mobile_no);
                    $('#birth_dt').val(response.data.birth_dt);
                    $('#register_dt').val(response.data.register_dt);

                    //set error validation
                    $('#patient_no').removeClass('is-invalid');
                    $('#fullname').removeClass('is-invalid');
                    $('#id_no').removeClass('is-invalid');
                    $('#gender').removeClass('is-invalid');
                    $('#addr').removeClass('is-invalid');
                    $('#mobile_no').removeClass('is-invalid');
                    $('#birth_dt').removeClass('is-invalid');
                    $('#register_dt').removeClass('is-invalid');
                    $('.errorPatient_no').html('');
                    $('.errorFullname').html('');
                    $('.errorId_no').html('');
                    $('.errorGender').html('');
                    $('.errorAddr').html('');
                    $('.errorMobile_no').html('');
                    $('.errorBirth_dt').html('');
                    $('.errorRegister_dt').html('');

                    //set selected data
                    $("#gender option[value='" + response.data.gender + "']").attr('selected', 'selected');

                    //set modal & form
                    $('.modal-title').text('Ubah Data');
                    $('#action').val('Edit');
                    $('#submit_button').val('Simpan');
                    $('#submit_button').html('Simpan');
                    $('#modalform').modal('show');
                    $('#hidden_id').val(patient_no);
                }
            })
        });
    });
</script>

<?= $this->endSection('script'); ?>