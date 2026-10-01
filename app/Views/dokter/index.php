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
                                                <label for="emp_cd" class="col-sm-2 col-form-label">ID</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="emp_cd" name="emp_cd">
                                                    <span class="error invalid-feedback errorEmp_cd">
                                                    </span>
                                                </div>
                                                <label for="emp_nm" class="col-sm-2 col-form-label">Name</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="emp_nm" name="emp_nm">
                                                    <span class="error invalid-feedback errorEmp_nm">
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
                                                <label for="mobile_no" class="col-sm-2 col-form-label">Mobile</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="mobile_no" name="mobile_no">
                                                    <span class="error invalid-feedback errormobile_no">
                                                    </span>
                                                </div>

                                            </div>
                                            <div class="mb-3 row">
                                                <label for="phone_no" class="col-sm-2 col-form-label">Phone</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="phone_no" name="phone_no">
                                                    <span class="error invalid-feedback errorphone_no">
                                                    </span>
                                                </div>
                                                <label for="addr" class="col-sm-2 col-form-label">Address</label>
                                                <div class="col-sm-4">
                                                    <textarea class="form-control form-control-sm" rows="3" placeholder="..." id="addr" name="addr" autocomplete="off"></textarea>
                                                    <span class="error invalid-feedback errorAddr">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="city_cd" class="col-sm-2 col-form-label">City</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="city_cd" name="city_cd">
                                                    <span class="error invalid-feedback errorCity_cd">
                                                    </span>
                                                </div>
                                                <label for="level_cd" class="col-sm-2 col-form-label">Level</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="level_cd" name="level_cd">
                                                    <span class="error invalid-feedback errorLevel_cd">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="prefix" class="col-sm-2 col-form-label">Prefix</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="prefix" name="prefix">
                                                    <span class="error invalid-feedback errorPrefix">
                                                    </span>
                                                </div>
                                                <label for="endfix" class="col-sm-2 col-form-label">Endfix</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="endfix" name="endfix">
                                                    <span class="error invalid-feedback errorEndfix">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="whatsapp_cd" class="col-sm-2 col-form-label">Whatsapp</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="whatsapp_cd" name="whatsapp_cd">
                                                    <span class="error invalid-feedback errorWhatsapp_cd">
                                                    </span>
                                                </div>
                                                <?= $cb_jobtitle; ?>
                                            </div>
                                            <div class="mb-3 row">
                                                <?= $cb_empstacd; ?>
                                                <label for="tgl_registrasi" class="col-sm-2 col-form-label">Poli</label>
                                                <div class="col-sm-4">
                                                    <?= view('components/dropdown2', [
                                                        'id'        => 'poli',
                                                        'name'        => 'poli',
                                                        'apiUrl'      => base_url('/dropdown/server3/2/1/dropdown/subunit/null/null/null/null'),
                                                        'extraKeys'   => [],
                                                        'selected'    => '',           // Nilai yang akan terselect
                                                        'errors'      => $errors ?? []
                                                    ]) ?>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="flag_dokter" class="col-sm-2 col-form-label">Dokter</label>
                                                <div class="col-sm-4">
                                                    <div class="icheck-primary d-inline">
                                                        <input type="checkbox" id="flag_dokter" name="flag_dokter" checked>
                                                        <label for="flag_dokter">
                                                        </label>
                                                    </div>
                                                    <span class="error invalid-feedback errorFlag_dokter">
                                                    </span>
                                                </div>
                                                <?= $cb_jenisdokter; ?>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="" class="col-sm-2 col-form-label"></label>
                                                <div class="col-sm-4">

                                                </div>
                                                <?= $cb_spesialis; ?>
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
    function tdokter() {
        $.ajax({
            method: "get",
            url: "<?= site_url('/tdokter/fetchAll'); ?>",
            success: function(data) {
                $('#viewdata').html(data);
            }
        });
    }
    $(document).ready(function() {
        tdokter();

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

        $('#job_title_cd').on("change", function(e) {
            var val = $(this).val();
            if (val === 'DR') {
                $('#jenis_dokter').removeAttr('disabled');
                $('#poli').removeAttr('disabled');
                $('#spesialis').removeAttr('disabled');
                // $('#flag_dokter').attr('disabled', '');
                $('#flag_dokter').attr('checked', 'checked')

            } else {
                $('#jenis_dokter').val(' ');
                $('#jenis_dokter').trigger('change');
                $('#jenis_dokter').attr('disabled', '');

                $('#poli').val(' ');
                $('#poli').trigger('change');
                $('#poli').attr('disabled', '');

                $('#spesialis').val(' ');
                $('#spesialis').trigger('change');
                $('#spesialis').attr('disabled', '');

                $('#flag_dokter').attr('disabled', '');
                $('#flag_dokter').removeAttr('checked');

            }
        });

        $(document).on('click', '#add_record', function() {
            //set input
            $('#emp_cd').removeAttr('readonly');
            $('#emp_cd').attr('readonly', '');
            $('#emp_nm').removeAttr('disabled');
            $('#job_title_cd').removeAttr('disabled');
            $('#spesialis').removeAttr('disabled');
            $('#phone_no').removeAttr('disabled');
            $('#mobile_no').removeAttr('disabled');
            $('#email').removeAttr('disabled');
            $('#addr').removeAttr('disabled');
            $('#city_cd').removeAttr('disabled');
            $('#prefix').removeAttr('disabled');
            $('#endfix').removeAttr('disabled');
            $('#whatsapp_cd').removeAttr('disabled');
            $('#level_cd').removeAttr('disabled');
            $('#level_cd').removeAttr('readonly');
            $('#flag_dokter').removeAttr('disabled');
            $('#flag_dokter').removeAttr('checked');
            $('#emp_sta_cd').removeAttr('disabled');
            $('#poli').removeAttr('disabled');
            $('#jenis_dokter').removeAttr('disabled');


            $('#data_form')[0].reset();

            $('#level_cd').attr('readonly', 'readonly');

            //set error validation
            $('#emp_cd').removeClass('is-invalid');
            $('#emp_nm').removeClass('is-invalid');
            $('#job_title_cd').removeClass('is-invalid');
            $('#spesialis').removeClass('is-invalid');
            $('#phone_no').removeClass('is-invalid');
            $('#mobile_no').removeClass('is-invalid');
            $('#email').removeClass('is-invalid');
            $('#addr').removeClass('is-invalid');
            $('#city_cd').removeClass('is-invalid');
            $('#prefix').removeClass('is-invalid');
            $('#endfix').removeClass('is-invalid');
            $('#whatsapp_cd').removeClass('is-invalid');
            $('#level_cd').removeClass('is-invalid');
            $('#emp_sta_cd').removeClass('is-invalid');
            $('#poli').removeClass('is-invalid');
            $('#jenis_dokter').removeClass('is-invalid');

            $('.errorEmp_cd').html('');
            $('.errorEmp_nm').html('');
            $('.errorJob_title_cd').html('');
            $('.errorSpesialis').html('');
            $('.errorPhone_no').html('');
            $('.errorMobile_no').html('');
            $('.errorEmail').html('');
            $('.errorAddr').html('');
            $('.errorCity_cd').html('');
            $('.errorPrefix').html('');
            $('.errorEndfix').html('');
            $('.errorWhatsapp_cd').html('');
            $('.errorLevel_cd').html('');
            $('.errorEmp_sta_cd').html('');
            $('.errorPoli').html('');
            $('.errorJenis_dokter').html('');

            //set selected data select2
            $('#emp_sta_cd').val(' ');
            $('#emp_sta_cd').trigger('change');
            $('#poli').val(' ');
            $('#poli').trigger('change');
            $('#job_title_cd').val(' ');
            $('#job_title_cd').trigger('change');
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
            $('#flag_dokter').removeAttr('disabled');
            event.preventDefault();
            $.ajax({
                url: "<?= site_url('tdokter/action'); ?>",
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
                    $('#flag_dokter').attr('disabled', '');
                },
                success: function(response) {

                    if (response.error) {
                        // if (response.error.emp_cd) {
                        //     $('#emp_cd').addClass('is-invalid');
                        //     $('.errorEmp_cd').html(response.error.emp_cd);
                        // } else {
                        //     $('#emp_cd').removeClass('is-invalid');
                        //     $('.errorEmp_cd').html('');
                        // }
                        if (response.error.emp_nm) {
                            $('#emp_nm').addClass('is-invalid');
                            $('.errorEmp_nm').html(response.error.emp_nm);
                        } else {
                            $('#emp_nm').removeClass('is-invalid');
                            $('.errorEmp_nm').html('');
                        }
                        if (response.error.job_title_cd) {
                            $('#job_title_cd').addClass('is-invalid');
                            $('.errorJob_title_cd').html(response.error.job_title_cd);
                        } else {
                            $('#job_title_cd').removeClass('is-invalid');
                            $('.errorJob_title_cd').html('');
                        }
                        if (response.error.addr) {
                            $('#addr').addClass('is-invalid');
                            $('.errorAddr').html(response.error.addr);
                        } else {
                            $('#addr').removeClass('is-invalid');
                            $('.errorAddr').html('');
                        }
                        if (response.error.city_cd) {
                            $('#city_cd').addClass('is-invalid');
                            $('.errorCity_cd').html(response.error.city_cd);
                        } else {
                            $('#city_cd').removeClass('is-invalid');
                            $('.errorCity_cd').html('');
                        }
                        if (response.error.phone_no) {
                            $('#phone_no').addClass('is-invalid');
                            $('.errorPhone_no').html(response.error.phone_no);
                        } else {
                            $('#phone_no').removeClass('is-invalid');
                            $('.errorPhone_no').html('');
                        }
                        if (response.error.mobile_no) {
                            $('#mobile_no').addClass('is-invalid');
                            $('.errorMobile_no').html(response.error.mobile_no);
                        } else {
                            $('#mobile_no').removeClass('is-invalid');
                            $('.errorMobile_no').html('');
                        }
                        if (response.error.email) {
                            $('#email').addClass('is-invalid');
                            $('.errorEmail').html(response.error.email);
                        } else {
                            $('#email').removeClass('is-invalid');
                            $('.errorEmail').html('');
                        }
                        if (response.error.prefix) {
                            $('#prefix').addClass('is-invalid');
                            $('.errorPrefix').html(response.error.prefix);
                        } else {
                            $('#prefix').removeClass('is-invalid');
                            $('.errorPrefix').html('');
                        }
                        if (response.error.endfix) {
                            $('#endfix').addClass('is-invalid');
                            $('.errorEndfix').html(response.error.endfix);
                        } else {
                            $('#endfix').removeClass('is-invalid');
                            $('.errorEndfix').html('');
                        }
                        if (response.error.whatsapp_cd) {
                            $('#whatsapp_cd').addClass('is-invalid');
                            $('.errorWhatsapp_cd').html(response.error.whatsapp_cd);
                        } else {
                            $('#whatsapp_cd').removeClass('is-invalid');
                            $('.errorWhatsapp_cd').html('');
                        }
                        if (response.error.level_cd) {
                            $('#level_cd').addClass('is-invalid');
                            $('.errorLevel_cd').html(response.error.level_cd);
                        } else {
                            $('#level_cd').removeClass('is-invalid');
                            $('.errorLevel_cd').html('');
                        }
                        if (response.error.emp_sta_cd) {
                            $('#emp_sta_cd').addClass('is-invalid');
                            $('.errorEmp_sta_cd').html(response.error.emp_sta_cd);
                        } else {
                            $('#emp_sta_cd').removeClass('is-invalid');
                            $('.errorEmp_sta_cd').html('');
                        }
                        if (response.error.poli) {
                            $('#poli').addClass('is-invalid');
                            $('.errorPoli').html(response.error.poli);
                        } else {
                            $('#poli').removeClass('is-invalid');
                            $('.errorPoli').html('');
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
                        $('#emp_cd').removeClass('is-invalid');
                        $('#emp_nm').removeClass('is-invalid');
                        $('#job_title_cd').removeClass('is-invalid');
                        $('#spesailis').removeClass('is-invalid');
                        $('#phone_no').removeClass('is-invalid');
                        $('#mobile_no').removeClass('is-invalid');
                        $('#email').removeClass('is-invalid');
                        $('#addr').removeClass('is-invalid');
                        $('#city_cd').removeClass('is-invalid');
                        $('#prefix').removeClass('is-invalid');
                        $('#endfix').removeClass('is-invalid');
                        $('#whatsapp_cd').removeClass('is-invalid');
                        $('#level_cd').removeClass('is-invalid');
                        $('#flag_dokter').removeAttr('checked');
                        $('#emp_sta_cd').removeClass('is-invalid');
                        $('#poli').removeClass('is-invalid');
                        $('#jenis_dokter').removeClass('is-invalid');


                        $('.errorEmp_cd').html('');
                        $('.errorAsr_nm').html('');
                        $('.errorJob_title_cd').html('');
                        $('.errorSpesialis').html('');
                        $('.errorPhone_no').html('');
                        $('.errorMobile_no').html('');
                        $('.errorEmail').html('');
                        $('.errorAddr').html('');
                        $('.errorCity_cd').html('');
                        $('.errorPrefix').html('');
                        $('.errorEndfix').html('');
                        $('.errorWhatsapp_cd').html('');
                        $('.errorLevel_cd').html('');
                        $('.errorEmp_sta_cd').html('');
                        $('.errorPoli').html('');
                        $('.errorJenis_dokter').html('');

                        tdokter();
                        $('#modalform').modal('hide');
                    }
                },
            })
        });

        $(document).on('click', '.view', function() {
            var emp_cd = $(this).data('emp_cd');

            $.ajax({
                url: "<?= site_url('tdokter/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    emp_cd: emp_cd
                },
                dataType: "JSON",
                success: function(response) {
                    //set input
                    $('#emp_cd').attr('disabled', '');
                    $('#emp_nm').attr('disabled', '');
                    $('#job_title_cd').attr('disabled', '');
                    $('#spesialis').attr('disabled', '');
                    $('#phone_no').attr('disabled', '');
                    $('#mobile_no').attr('disabled', '');
                    $('#email').attr('disabled', '');
                    $('#addr').attr('disabled', '');
                    $('#city_cd').attr('disabled', '');
                    $('#prefix').attr('disabled', '');
                    $('#endfix').attr('disabled', '');
                    $('#whatsapp_cd').attr('disabled', '');
                    $('#level_cd').attr('disabled', '');
                    $('#flag_dokter').attr('disabled', '');
                    $('#flag_dokter').removeAttr('checked');
                    $('#emp_sta_cd').attr('disabled', '');
                    $('#poli').attr('disabled', '');
                    $('#jenis_dokter').attr('disabled', '');

                    $('#data_form')[0].reset();


                    //set data from response record
                    $('#emp_cd').val(response.data.emp_cd);
                    $('#emp_nm').val(response.data.emp_nm);
                    $('#job_title_cd').val(response.data.job_title_cd);
                    $('#spesialis').val(response.data.job_title_cd);
                    $('#phone_no').val(response.data.phone_no);
                    $('#mobile_no').val(response.data.mobile_no);
                    $('#email').val(response.data.email);
                    $('#addr').val(response.data.addr);
                    $('#city_cd').val(response.data.city_cd);
                    $('#prefix').val(response.data.prefix);
                    $('#endfix').val(response.data.endfix);
                    $('#whatsapp_cd').val(response.data.whatsapp_cd);
                    $('#level_cd').val(response.data.level_cd);
                    $('#poli').val(response.data.poli);
                    $('#jenis_dokter').val(response.data.jenis_dokter);
                    (response.data.flag_dokter === 1 ? $('#flag_dokter').attr('checked', 'checked') : $('#flag_dokter').removeAttr('checked'));
                    // (response.data.emp_sta_cd === 'A' ? $('#emp_sta_cd').attr('checked', 'checked') : $('#emp_sta_cd').removeAttr('checked'));

                    //set error validation
                    $('#emp_cd').removeClass('is-invalid');
                    $('#emp_nm').removeClass('is-invalid');
                    $('#job_title_cd').removeClass('is-invalid');
                    $('#spesialis').removeClass('is-invalid');
                    $('#phone_no').removeClass('is-invalid');
                    $('#mobile_no').removeClass('is-invalid');
                    $('#email').removeClass('is-invalid');
                    $('#addr').removeClass('is-invalid');
                    $('#city_cd').removeClass('is-invalid');
                    $('#prefix').removeClass('is-invalid');
                    $('#endfix').removeClass('is-invalid');
                    $('#whatsapp_cd').removeClass('is-invalid');
                    $('#level_cd').removeClass('is-invalid');
                    $('#emp_sta_cd').removeClass('is-invalid');
                    $('#poli').removeClass('is-invalid');
                    $('#jenis_dokter').removeClass('is-invalid');

                    $('.errorEmp_cd').html('');
                    $('.errorEmp_nm').html('');
                    $('.errorJob_title_cd').html('');
                    $('.errorSpesialis').html('');
                    $('.errorPhone_no').html('');
                    $('.errorMobile_no').html('');
                    $('.errorEmail').html('');
                    $('.errorAddr').html('');
                    $('.errorCity_cd').html('');
                    $('.errorPrefix').html('');
                    $('.errorEndfix').html('');
                    $('.errorWhatsapp_cd').html('');
                    $('.errorLevel_cd').html('');
                    $('.errorEmp_sta_cd').html('');
                    $('.errorPoli').html('');
                    $('.errorJenis_dokter').html('');

                    //set selected data select2
                    $('#emp_sta_cd').val(response.data.emp_sta_cd);
                    $('#emp_sta_cd').trigger('change');
                    $('#poli').val(response.data.poli);
                    $('#poli').trigger('change');
                    $('#job_title_cd').val(response.data.job_title_cd);
                    $('#job_title_cd').trigger('change');
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
            var emp_cd = $(this).data('emp_cd');

            $.ajax({
                url: "<?= site_url('tdokter/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    emp_cd: emp_cd
                },
                dataType: "JSON",
                success: function(response) {
                    //set input
                    // $('#emp_cd').removeAttr('disabled');
                    $('#emp_nm').removeAttr('disabled');
                    $('#job_title_cd').removeAttr('disabled');
                    $('#spesialis').removeAttr('disabled');
                    $('#phone_no').removeAttr('disabled');
                    $('#mobile_no').removeAttr('disabled');
                    $('#email').removeAttr('disabled');
                    $('#addr').removeAttr('disabled');
                    $('#city_cd').removeAttr('disabled');
                    $('#prefix').removeAttr('disabled');
                    $('#endfix').removeAttr('disabled');
                    $('#whatsapp_cd').removeAttr('disabled');
                    $('#level_cd').removeAttr('disabled');
                    $('#level_cd').removeAttr('readonly');
                    $('#emp_sta_cd').removeAttr('disabled');
                    $('#poli').removeAttr('disabled');
                    $('#jenis_dokter').removeAttr('disabled');

                    // $('#emp_cd').attr('disabled', '');
                    $('#emp_cd').attr('readonly', '');
                    $('#flag_dokter').removeAttr('disabled');
                    $('#flag_dokter').removeAttr('checked');


                    $('#data_form')[0].reset();

                    // $('#flag_dokter').attr('disabled', '');

                    //set datepicker input value


                    //set data from response record
                    $('#emp_cd').val(response.data.emp_cd);
                    $('#emp_nm').val(response.data.emp_nm);
                    $('#job_title_cd').val(response.data.job_title_cd);
                    $('#spesialis').val(response.data.spesialis);
                    $('#phone_no').val(response.data.phone_no);
                    $('#mobile_no').val(response.data.mobile_no);
                    $('#email').val(response.data.email);
                    $('#addr').val(response.data.addr);
                    $('#city_cd').val(response.data.city_cd);
                    $('#prefix').val(response.data.prefix);
                    $('#endfix').val(response.data.endfix);
                    $('#whatsapp_cd').val(response.data.whatsapp_cd);
                    $('#level_cd').val(response.data.level_cd);
                    $('#poli').val(response.data.poli);
                    $('#jenis_dokter').val(response.data.jenis_dokter);
                    (response.data.flag_dokter === 1 ? $('#flag_dokter').attr('checked', 'checked') : $('#flag_dokter').removeAttr('checked'));
                    // (response.data.emp_sta_cd === 'A' ? $('#emp_sta_cd').attr('checked', 'checked') : $('#emp_sta_cd').removeAttr('checked'));
                    $('#level_cd').attr('readonly', 'readonly');

                    //set error validation
                    $('#emp_cd').removeClass('is-invalid');
                    $('#emp_nm').removeClass('is-invalid');
                    $('#job_title_cd').removeClass('is-invalid');
                    $('#spesialis').removeClass('is-invalid');
                    $('#phone_no').removeClass('is-invalid');
                    $('#mobile_no').removeClass('is-invalid');
                    $('#email').removeClass('is-invalid');
                    $('#addr').removeClass('is-invalid');
                    $('#city_cd').removeClass('is-invalid');
                    $('#prefix').removeClass('is-invalid');
                    $('#endfix').removeClass('is-invalid');
                    $('#whatsapp_cd').removeClass('is-invalid');
                    $('#level_cd').removeClass('is-invalid');
                    $('#emp_sta_cd').removeClass('is-invalid');
                    $('#poli').removeClass('is-invalid');
                    $('#jenis_dokter').removeClass('is-invalid');

                    $('.errorEmp_cd').html('');
                    $('.errorEmp_nm').html('');
                    $('.errorJob_title_cd').html('');
                    $('.errorSpesialis').html('');
                    $('.errorPhone_no').html('');
                    $('.errorMobile_no').html('');
                    $('.errorEmail').html('');
                    $('.errorAddr').html('');
                    $('.errorCity_cd').html('');
                    $('.errorPrefix').html('');
                    $('.errorEndfix').html('');
                    $('.errorWhatsapp_cd').html('');
                    $('.errorLevel_cd').html('');
                    $('.errorEmp_sta_cd').html('');
                    $('.errorPoli').html('');
                    $('.errorJenis_dokter').html('');

                    //set selected data select2
                    $('#emp_sta_cd').val(response.data.emp_sta_cd);
                    $('#emp_sta_cd').trigger('change');
                    $('#poli').val(response.data.poli);
                    $('#poli').trigger('change');
                    $('#job_title_cd').val(response.data.job_title_cd);
                    $('#job_title_cd').trigger('change');
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
            var emp_cd = $(this).data('emp_cd');
            if (confirm("Are you sure you want to remove it?")) {
                $.ajax({
                    url: "<?= site_url('tdokter/delete'); ?>",
                    method: "POST",
                    data: {
                        emp_cd: emp_cd
                    },
                    dataType: "JSON",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                            //footer: '<a href="">Why do I have this issue?</a>'
                        });
                        tdokter();
                        setTimeout(function() {
                            $('#message').html('');
                        }, 5000);
                    }
                })
            }
        });

        $('#Job_title_cd').on("change", function(e) {
            var val = $(this).val();
            if (val === 'dokter') {
                // $('#asr_cd').removeAttr('disabled');

                $('#jenis_dokter').removeAttr('disabled');

                $('#employee_status').removeAttr('disabled');

                $('#tujuan_registrasi').removeAttr('disabled');
            } else {
                // $('#asr_cd').val(' ');
                // $('#asr_cd').trigger('change');
                // $('#asr_cd').attr('disabled', '');

                $('#jenis_dokter').val(' ');
                $('#jenis_dokter').trigger('change');
                $('#jenis_dokter').attr('disabled', '');

                $('#employee_status').val(' ');
                $('#employee_status').trigger('change');
                $('#employee_status').attr('disabled', '');

                $('#tujuan_registrasi').val(' ');
                $('#tujuan_registrasi').trigger('change');
                $('#tujuan_registrasi').attr('disabled', '');
            }
        });
    });
</script>



<?= $this->endSection('script'); ?>