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
                                                <label for="jadwal_id" class="col-sm-2 col-form-label">ID</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="jadwal_id" name="jadwal_id">
                                                    <span class="error invalid-feedback errorJadwal_id">
                                                    </span>
                                                </div>
                                                <label for="tgl_praktek" class="col-sm-2 col-form-label">Tanggal</label>
                                                <!-- <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="tgl_praktek" name="tgl_praktek">
                                                    <span class="error invalid-feedback errorTgl_praktek">
                                                    </span>
                                                </div> -->
                                                <div class="col-sm-4">
                                                    <div class="input-group date tgl_praktek" data-date-format="mm/dd/yyyy">
                                                        <input type="text" class="form-control form-control-sm datepicker" placeholder="mm/dd/yyyy" id="tgl_praktek" name="tgl_praktek">
                                                        <div class="input-group-append" data-target="#tgl_praktek" data-toggle="tgl_praktek">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                    </div>
                                                    <span class="error invalid-feedback errorTgl_praktek">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <?= $cb_dokter ?>

                                            </div>
                                            <div class="mb-3 row">
                                                <label for="jam_mulai" class="col-sm-2 col-form-label">Jam Mulai</label>
                                                <div class="col-sm-4">
                                                    <input type="time" class="form-control form-control-sm" id="jam_mulai" name="jam_mulai">
                                                    <span class="error invalid-feedback errorJam_mulai">
                                                    </span>
                                                </div>
                                                <label for="jam_selesai" class="col-sm-2 col-form-label">Jam Selesai</label>
                                                <div class="col-sm-4">
                                                    <input type="time" class="form-control form-control-sm" id="jam_selesai" name="jam_selesai">
                                                    <span class="error invalid-feedback errorJam_selesai">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <?= $cb_jenis ?>
                                                <div class="col-sm-2"></div>
                                                <div class="col-sm-4">
                                                    <div class="icheck-primary d-inline">
                                                        <input type="checkbox" id="status_jadwal" name="status_jadwal" checked>
                                                        <label for="status_jadwal">Aktif</label>
                                                    </div>
                                                    <span class="error invalid-feedback errorStatus_jadwal">
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

                        <!-- Modal -->
                        <div class="modal fade" id="modalform2" tabindex="" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLabel"></h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="post" id="data_form2" autocomplete="off">
                                        <?= csrf_field(); ?>
                                        <div class="modal-body">
                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <div class="col-sm-6 p-3">
                                                        <h3 class="text-center">OLD</h3>
                                                        <div class="mb-3 row">
                                                            <label for="jadwal_id2" class="col-sm-2 col-form-label">ID</label>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control form-control-sm" id="jadwal_id2" name="jadwal_id2">
                                                                <span class="error invalid-feedback errorJadwal_id2">
                                                                </span>
                                                            </div>
                                                            <label for="tgl_praktek2" class="col-sm-2 col-form-label">Tanggal</label>
                                                            <div class="col-sm-4">
                                                                <div class="input-group date tgl_praktek2" data-date-format="mm/dd/yyyy">
                                                                    <input type="text" class="form-control form-control-sm datepicker" placeholder="mm/dd/yyyy" id="tgl_praktek2" name="tgl_praktek2">
                                                                    <div class="input-group-append" data-target="#tgl_praktek2" data-toggle="tgl_praktek2">
                                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                    </div>
                                                                </div>
                                                                <span class="error invalid-feedback errorTgl_praktek3">
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <?= $cb_dokter2 ?>

                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="jam_mulai2" class="col-sm-2 col-form-label">Jam Mulai</label>
                                                            <div class="col-sm-4">
                                                                <input type="time" class="form-control form-control-sm" id="jam_mulai2" name="jam_mulai2">
                                                                <span class="error invalid-feedback errorJam_mulai2">
                                                                </span>
                                                            </div>
                                                            <label for="jam_selesai2" class="col-sm-2 col-form-label">Jam Selesai</label>
                                                            <div class="col-sm-4">
                                                                <input type="time" class="form-control form-control-sm" id="jam_selesai2" name="jam_selesai2">
                                                                <span class="error invalid-feedback errorJam_selesai2">
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <?= $cb_jenis2 ?>
                                                            <div class="col-sm-2"></div>
                                                            <div class="col-sm-4">
                                                                <div class="icheck-primary d-inline">
                                                                    <input type="checkbox" id="status_jadwal2" name="status_jadwal2" checked>
                                                                    <label for="status_jadwal2">Aktif</label>
                                                                </div>
                                                                <span class="error invalid-feedback errorStatus_jadwal2">
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="keterangan2" class="col-sm-2 col-form-label">Keterangan</label>
                                                            <div class="col-sm-10">
                                                                <textarea class="form-control form-control-sm" rows="3" placeholder="..." id="keterangan2" name="keterangan2"></textarea>
                                                                <span class="error invalid-feedback errorKeterangan2">
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 p-3">
                                                        <h3 class="text-center">NEW</h3>
                                                        <div class="mb-3 row">
                                                            <label for="jadwal_id3" class="col-sm-2 col-form-label">ID</label>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control form-control-sm" id="jadwal_id3" name="jadwal_id3">
                                                                <span class="error invalid-feedback errorJadwal_id3">
                                                                </span>
                                                            </div>
                                                            <label for="tgl_praktek3" class="col-sm-2 col-form-label">Tanggal</label>
                                                            <div class="col-sm-4">
                                                                <div class="input-group date tgl_praktek3" data-date-format="mm/dd/yyyy">
                                                                    <input type="text" class="form-control form-control-sm datepicker" placeholder="mm/dd/yyyy" id="tgl_praktek3" name="tgl_praktek3">
                                                                    <div class="input-group-append" data-target="#tgl_praktek3" data-toggle="tgl_praktek3">
                                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                    </div>
                                                                </div>
                                                                <span class="error invalid-feedback errorTgl_praktek3">
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <?= $cb_dokter3 ?>

                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="jam_mulai3" class="col-sm-2 col-form-label">Jam Mulai</label>
                                                            <div class="col-sm-4">
                                                                <input type="time" class="form-control form-control-sm" id="jam_mulai3" name="jam_mulai3">
                                                                <span class="error invalid-feedback errorJam_mulai3">
                                                                </span>
                                                            </div>
                                                            <label for="jam_selesai3" class="col-sm-2 col-form-label">Jam Selesai</label>
                                                            <div class="col-sm-4">
                                                                <input type="time" class="form-control form-control-sm" id="jam_selesai3" name="jam_selesai3">
                                                                <span class="error invalid-feedback errorJam_selesai3">
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <?= $cb_jenis3 ?>
                                                            <div class="col-sm-2"></div>
                                                            <div class="col-sm-4">
                                                                <div class="icheck-primary d-inline">
                                                                    <input type="checkbox" id="status_jadwal3" name="status_jadwal3" checked>
                                                                    <label for="status_jadwal3">Status</label>
                                                                </div>
                                                                <span class="error invalid-feedback errorStatus_jadwal3">
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="keterangan3" class="col-sm-2 col-form-label">Keterangan</label>
                                                            <div class="col-sm-10">
                                                                <textarea class="form-control form-control-sm" rows="3" placeholder="..." id="keterangan3" name="keterangan3"></textarea>
                                                                <span class="error invalid-feedback errorKeterangan3">
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" id="kode_dokter3_h" name="kode_dokter3_h" />
                                            <input type="hidden" id="jenis_jadwal3_h" name="jenis_jadwal3_h" value="REGT" />
                                            <input type="hidden" id="status_jadwal3_h" name="status_jadwal3_h" value="TRUE" />
                                            <input type="hidden" id="jadwal_id3_h" name="jadwal_id3_h" value="TRUE" />
                                            <!-- <input type="hidden" id="hidden_id" name="hidden_id" /> -->
                                            <input type="hidden" id="action2" name="action2" value="Rescedule" />
                                            <button type="submit" name="submit" id="submit_button2" class="btn btn-sm btn-primary" value="Simpan"></button>
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
    $('#tgl_praktek').datepicker({
        todayHighlight: true,
        autoclose: true,
        dateFormat: 'MM/DD/YYYY'
    }).val();
    $('#tgl_praktek2').datepicker({
        todayHighlight: true,
        autoclose: true,
        dateFormat: 'MM/DD/YYYY'
    }).val();
    $('#tgl_praktek3').datepicker({
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
    function tdokterjadwal() {
        $.ajax({
            method: "get",
            url: "<?= site_url('/tdokterjadwal/fetchAll'); ?>",
            success: function(data) {
                $('#viewdata').html(data);
            }
        });
    }
    $(document).ready(function() {
        tdokterjadwal()

        //datatable server side
        // $('#sample_table').DataTable({
        //     "order": [],
        //     "serverSide": true,
        //     "ajax": {
        //         url: "<?php echo base_url("/ajax_crud/fetchAll"); ?>",
        //         type: "POST",
        //     }
        // });

        $(document).on('click', '#add_record', function() {
            //set input
            $('#kode_dokter').removeAttr('disabled');
            $('#tgl_praktek').removeAttr('disabled');
            $('#jam_mulai').removeAttr('disabled');
            $('#jam_selesai').removeAttr('disabled');
            $('#keterangan').removeAttr('disabled');
            $('#jenis_jadwal').removeAttr('disabled');
            $('#resign_dt').removeAttr('disabled');
            $('#whatsapp_no').removeAttr('disabled');
            // $('#last_token').removeAttr('disabled');
            $('#passwd').removeAttr('disabled');
            $('#emp_cd').removeAttr('disabled');
            // $('#salespointcd').removeAttr('disabled');
            // $('#token_dt').removeAttr('disabled');
            // $('#initname').removeAttr('disabled');
            $('#status_jadwal').removeAttr('disabled');
            $('#role_cd').removeAttr('disabled');
            // $('#pwdbinary').removeAttr('disabled');
            $('#jadwal_id').removeAttr('readonly');
            $('#status_jadwal').removeAttr('checked');
            $('#jadwal_id').attr('readonly', '');

            $('#data_form')[0].reset();

            //set error validation
            $('#jadwal_id').removeClass('is-invalid');
            $('#kode_dokter').removeClass('is-invalid');
            $('#tgl_praktek').removeClass('is-invalid');
            $('#jam_mulai').removeClass('is-invalid');
            $('#jam_selesai').removeClass('is-invalid');
            $('#keterangan').removeClass('is-invalid');
            $('#jenis_jadwal').removeClass('is-invalid');
            $('#resign_dt').removeClass('is-invalid');
            $('#whatsapp_no').removeClass('is-invalid');
            // $('#last_token').removeClass('is-invalid');
            $('#passwd').removeClass('is-invalid');
            $('#emp_cd').removeClass('is-invalid');
            // $('#salespointcd').removeClass('is-invalid');
            // $('#token_dt').removeClass('is-invalid');
            // $('#initname').removeClass('is-invalid');
            // $('#status_jadwal').removeClass('is-invalid');
            $('#role_cd').removeClass('is-invalid');
            // $('#pwdbinary').removeClass('is-invalid');

            $('.errorJadwal_id').html('');
            $('.errorKode_dokter').html('');
            $('.errorTgl_praktek').html('');
            $('.errorJam_mulai').html('');
            $('.errorJam_selesai').html('');
            $('.errorKeterangan').html('');
            $('.errorJenis_jadwal').html('');
            $('.errorResign_dt').html('');
            $('.errorWhatsapp_no').html('');
            // $('.errorLast_token').html('');
            $('.errorPasswd').html('');
            $('.errorEmp_cd').html('');
            // $('.errorSalespointcd').html('');
            // $('.errorToken_dt').html('');
            // $('.errorInitname').html('');
            // $('.errorstatus_jadwal').html('');
            $('.errorRole_cd').html('');
            // $('.errorPwdbinary').html('');
            $('#passwd').val('12345678');

            //set selected data select2
            $('#kode_dokter').val(' ');
            $('#kode_dokter').trigger('change');
            $('#status_jadwal').attr('checked', '');

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
                url: "<?= site_url('tdokterjadwal/action'); ?>",
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
                        if (response.error.kode_dokter) {
                            $('#kode_dokter').addClass('is-invalid');
                            $('.errorKode_dokter').html(response.error.kode_dokter);
                        } else {
                            $('#kode_dokter').removeClass('is-invalid');
                            $('.errorKode_dokter').html('');
                        }
                        if (response.error.tgl_praktek) {
                            $('#tgl_praktek').addClass('is-invalid');
                            $('.errorTgl_praktek').html(response.error.tgl_praktek);
                        } else {
                            $('#tgl_praktek').removeClass('is-invalid');
                            $('.errorTgl_praktek').html('');
                        }
                        if (response.error.jam_mulai) {
                            $('#jam_mulai').addClass('is-invalid');
                            $('.errorJam_mulai').html(response.error.jam_mulai);
                        } else {
                            $('#jam_mulai').removeClass('is-invalid');
                            $('.errorJam_mulai').html('');
                        }
                        if (response.error.jam_selesai) {
                            $('#jam_selesai').addClass('is-invalid');
                            $('.errorJam_selesai').html(response.error.jam_selesai);
                        } else {
                            $('#jam_selesai').removeClass('is-invalid');
                            $('.errorJam_selesai').html('');
                        }
                        if (response.error.jenis_jadwal) {
                            $('#jenis_jadwal').addClass('is-invalid');
                            $('.errorJenis_jadwal').html(response.error.jenis_jadwal);
                        } else {
                            $('#jenis_jadwal').removeClass('is-invalid');
                            $('.errorJenis_jadwal').html('');
                        }
                        if (response.error.keterangan) {
                            $('#keterangan').addClass('is-invalid');
                            $('.errorKeterangan').html(response.error.keterangan);
                        } else {
                            $('#keterangan').removeClass('is-invalid');
                            $('.errorKeterangan').html('');
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
                        $('#jadwal_id').removeClass('is-invalid');
                        $('#kode_dokter').removeClass('is-invalid');
                        $('#tgl_praktek').removeClass('is-invalid');
                        $('#jam_mulai').removeClass('is-invalid');
                        $('#jam_selesai').removeClass('is-invalid');
                        $('#keterangan').removeClass('is-invalid');
                        $('#jenis_jadwal').removeClass('is-invalid');
                        $('#resign_dt').removeClass('is-invalid');
                        $('#whatsapp_no').removeClass('is-invalid');
                        // $('#last_token').removeClass('is-invalid');
                        $('#passwd').removeClass('is-invalid');
                        $('#emp_cd').removeClass('is-invalid');
                        // $('#salespointcd').removeClass('is-invalid');
                        // $('#token_dt').removeClass('is-invalid');
                        // $('#initname').removeClass('is-invalid');
                        $('#status_jadwal').removeClass('is-invalid');
                        $('#role_cd').removeClass('is-invalid');
                        // $('#pwdbinary').removeClass('is-invalid');

                        $('.errorJadwal_id').html('');
                        $('.errorKode_dokter').html('');
                        $('.errorTgl_praktek').html('');
                        $('.errorJam_mulai').html('');
                        $('.errorJam_selesai').html('');
                        $('.errorKeterangan').html('');
                        $('.errorJenis_jadwal').html('');
                        $('.errorResign_dt').html('');
                        $('.errorWhatsapp_no').html('');
                        // $('.errorLast_token').html('');
                        $('.errorPasswd').html('');
                        $('.errorEmp_cd').html('');
                        // $('.errorSalespointcd').html('');
                        // $('.errorToken_dt').html('');
                        // $('.errorInitname').html('');
                        $('.errorstatus_jadwal').html('');
                        $('.errorRole_cd').html('');
                        // $('.errorPwdbinary').html('');
                        $('#status_jadwal').removeAttr('checked');

                        tdokterjadwal();
                        $('#modalform').modal('hide');
                    }
                },
            })
        });

        $('#data_form2').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "<?= site_url('tdokterjadwal/actionRescedule'); ?>",
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                beforeSend: function() {
                    $('#submit_button2').prop('disabled', true);
                    $('#submit_button2').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('#submit_button2').prop('disabled', false);
                    $('#submit_button2').html($('#submit_button2').val());
                },
                success: function(response) {

                    if (response.error) {
                        if (response.error.kode_dokter) {
                            $('#kode_dokter3').addClass('is-invalid');
                            $('.errorKode_dokter3').html(response.error.kode_dokter);
                        } else {
                            $('#kode_dokter3').removeClass('is-invalid');
                            $('.errorKode_dokter3').html('');
                        }
                        if (response.error.tgl_praktek) {
                            $('#tgl_praktek3').addClass('is-invalid');
                            $('.errorTgl_praktek3').html(response.error.tgl_praktek);
                        } else {
                            $('#tgl_praktek3').removeClass('is-invalid');
                            $('.errorTgl_praktek3').html('');
                        }
                        if (response.error.jam_mulai) {
                            $('#jam_mulai3').addClass('is-invalid');
                            $('.errorJam_mulai3').html(response.error.jam_mulai);
                        } else {
                            $('#jam_mulai3').removeClass('is-invalid');
                            $('.errorJam_mulai3').html('');
                        }
                        if (response.error.jam_selesai) {
                            $('#jam_selesai3').addClass('is-invalid');
                            $('.errorJam_selesai3').html(response.error.jam_selesai);
                        } else {
                            $('#jam_selesai3').removeClass('is-invalid');
                            $('.errorJam_selesai3').html('');
                        }
                        if (response.error.jenis_jadwal) {
                            $('#jenis_jadwal3').addClass('is-invalid');
                            $('.errorJenis_jadwal3').html(response.error.jenis_jadwal);
                        } else {
                            $('#jenis_jadwal3').removeClass('is-invalid');
                            $('.errorJenis_jadwal3').html('');
                        }
                        if (response.error.keterangan) {
                            $('#keterangan3').addClass('is-invalid');
                            $('.errorKeterangan3').html(response.error.keterangan);
                        } else {
                            $('#keterangan3').removeClass('is-invalid');
                            $('.errorKeterangan3').html('');
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
                        $('#jadwal_id3').removeClass('is-invalid');
                        $('#kode_dokter3').removeClass('is-invalid');
                        $('#tgl_praktek3').removeClass('is-invalid');
                        $('#jam_mulai3').removeClass('is-invalid');
                        $('#jam_selesai3').removeClass('is-invalid');
                        $('#keterangan3').removeClass('is-invalid');
                        $('#jenis_jadwal3').removeClass('is-invalid');
                        $('#status_jadwal3').removeClass('is-invalid');


                        $('.errorJadwal_id3').html('');
                        $('.errorKode_dokter3').html('');
                        $('.errorTgl_praktek3').html('');
                        $('.errorJam_mulai3').html('');
                        $('.errorJam_selesai3').html('');
                        $('.errorKeterangan3').html('');
                        $('.errorJenis_jadwal3').html('');
                        $('.errorStatus_jadwal3').html('');

                        $('#status_jadwal3').removeAttr('checked');

                        tdokterjadwal();
                        $('#modalform2').modal('hide');
                    }
                },
            })
        });

        $(document).on('click', '.view', function() {
            var jadwal_id = $(this).data('jadwal_id');

            $.ajax({
                url: "<?= site_url('tdokterjadwal/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    jadwal_id: jadwal_id
                },
                dataType: "JSON",
                success: function(response) {
                    //set input
                    $('#jadwal_id').attr('disabled', '');
                    $('#kode_dokter').attr('disabled', '');
                    $('#tgl_praktek').attr('disabled', '');
                    $('#jam_mulai').attr('disabled', '');
                    $('#jam_selesai').attr('disabled', '');
                    $('#keterangan').attr('disabled', '');
                    $('#jenis_jadwal').attr('disabled', '');
                    $('#resign_dt').attr('disabled', '');
                    $('#whatsapp_no').attr('disabled', '');
                    // $('#last_token').attr('disabled', '');
                    $('#passwd').attr('disabled', '');
                    $('#emp_cd').attr('disabled', '');
                    // $('#salespointcd').attr('disabled', '');
                    // $('#token_dt').attr('disabled', '');
                    // $('#initname').attr('disabled', '');
                    $('#status_jadwal').attr('disabled', '');
                    $('#role_cd').attr('disabled', '');
                    // $('#pwdbinary').attr('disabled','');
                    $('#jadwal_id').attr('readonly', '');
                    $('#status_jadwal').removeAttr('checked');

                    $('#data_form')[0].reset();

                    // alert(response.data.jadwal_id);
                    // alert(response.data.menu_nm);
                    // alert(response.data.reference);
                    // alert(response.data.header_id);

                    //set data from response record
                    $('#jadwal_id').val(response.data.jadwal_id);
                    $('#kode_dokter').val(response.data.kode_dokter);
                    $('#tgl_praktek').val(response.data.tgl_praktek);
                    $('#jam_mulai').val(response.data.jam_mulai);
                    $('#jam_selesai').val(response.data.jam_selesai);
                    $('#keterangan').val(response.data.keterangan);
                    $('#jenis_jadwal').val(response.data.jenis_jadwal);
                    $('#resign_dt').val(response.data.resign_dt);
                    $('#whatsapp_no').val(response.data.whatsapp_no);
                    // $('#last_token').val(response.data.last_token);
                    $('#passwd').val(response.data.passwd);
                    $('#emp_cd').val(response.data.emp_cd);
                    // $('#salespointcd').val(response.data.salespointcd);
                    // $('#token_dt').val(response.data.token_dt);
                    // $('#initname').val(response.data.initname);
                    // $('#status_jadwal').val(response.data.status_jadwal);
                    $('#role_cd').val(response.data.role_cd);
                    // $('#pwdbinary').val(response.data.pwdbinary);
                    (response.data.status_jadwal === 1 ? $('#status_jadwal').attr('checked', 'checked') : $('#status_jadwal').removeAttr('checked'));

                    //set error validation
                    $('#jadwal_id').removeClass('is-invalid');
                    $('#kode_dokter').removeClass('is-invalid');
                    $('#tgl_praktek').removeClass('is-invalid');
                    $('#jam_mulai').removeClass('is-invalid');
                    $('#jam_selesai').removeClass('is-invalid');
                    $('#keterangan').removeClass('is-invalid');
                    $('#jenis_jadwal').removeClass('is-invalid');
                    $('#resign_dt').removeClass('is-invalid');
                    $('#whatsapp_no').removeClass('is-invalid');
                    // $('#last_token').removeClass('is-invalid');
                    $('#passwd').removeClass('is-invalid');
                    $('#emp_cd').removeClass('is-invalid');
                    // $('#salespointcd').removeClass('is-invalid');
                    // $('#token_dt').removeClass('is-invalid');
                    // $('#initname').removeClass('is-invalid');
                    $('#status_jadwal').removeClass('is-invalid');
                    $('#role_cd').removeClass('is-invalid');
                    // $('#pwdbinary').removeClass('is-invalid');

                    $('.errorJadwal_id').html('');
                    $('.errorKode_dokter').html('');
                    $('.errorTgl_praktek').html('');
                    $('.errorJam_mulai').html('');
                    $('.errorJam_selesai').html('');
                    $('.errorKeterangan').html('');
                    $('.errorJenis_jadwal').html('');
                    $('.errorResign_dt').html('');
                    $('.errorWhatsapp_no').html('');
                    // $('.errorLast_token').html('');
                    $('.errorPasswd').html('');
                    $('.errorEmp_cd').html('');
                    // $('.errorSalespointcd').html('');
                    // $('.errorToken_dt').html('');
                    // $('.errorInitname').html('');
                    $('.errorstatus_jadwal').html('');
                    $('.errorRole_cd').html('');
                    // $('.errorPwdbinary').html('');

                    //set selected data select2
                    $('#kode_dokter').val(response.data.kode_dokter);
                    $('#kode_dokter').trigger('change');
                    $('#jenis_jadwal').val(response.data.jenis_jadwal);
                    $('#jenis_jadwal').trigger('change');

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
            var jadwal_id = $(this).data('jadwal_id');

            $.ajax({
                url: "<?= site_url('tdokterjadwal/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    jadwal_id: jadwal_id
                },
                dataType: "JSON",
                success: function(response) {
                    //set input
                    $('#jadwal_id').removeAttr('disabled');
                    $('#kode_dokter').removeAttr('disabled');
                    $('#tgl_praktek').removeAttr('disabled');
                    $('#jam_mulai').removeAttr('disabled');
                    $('#jam_selesai').removeAttr('disabled');
                    $('#keterangan').removeAttr('disabled');
                    $('#jenis_jadwal').removeAttr('disabled');
                    $('#resign_dt').removeAttr('disabled');
                    $('#whatsapp_no').removeAttr('disabled');
                    // $('#last_token').removeAttr('disabled');
                    $('#passwd').removeAttr('disabled');
                    $('#emp_cd').removeAttr('disabled');
                    // $('#salespointcd').removeAttr('disabled');
                    // $('#token_dt').removeAttr('disabled');
                    // $('#initname').removeAttr('disabled');
                    $('#status_jadwal').removeAttr('disabled');
                    $('#role_cd').removeAttr('disabled');
                    // $('#pwdbinary').removeAttr('disabled');
                    $('#jadwal_id').attr('readonly', '');
                    $('#status_jadwal').removeAttr('checked');

                    $('#data_form')[0].reset();

                    // alert(response.data.jadwal_id);
                    // alert(response.data.menu_nm);
                    // alert(response.data.reference);
                    // alert(response.data.header_id);

                    //set data from response record
                    $('#jadwal_id').val(response.data.jadwal_id);
                    $('#kode_dokter').val(response.data.kode_dokter);
                    $('#tgl_praktek').val(response.data.tgl_praktek);
                    $('#jam_mulai').val(response.data.jam_mulai);
                    $('#jam_selesai').val(response.data.jam_selesai);
                    $('#keterangan').val(response.data.keterangan);
                    $('#jenis_jadwal').val(response.data.jenis_jadwal);
                    $('#resign_dt').val(response.data.resign_dt);
                    $('#whatsapp_no').val(response.data.whatsapp_no);
                    // $('#last_token').val(response.data.last_token);
                    $('#passwd').val(response.data.passwd);
                    $('#emp_cd').val(response.data.emp_cd);
                    // $('#salespointcd').val(response.data.salespointcd);
                    // $('#token_dt').val(response.data.token_dt);
                    // $('#initname').val(response.data.initname);
                    // $('#status_jadwal').val(response.data.status_jadwal);
                    $('#role_cd').val(response.data.role_cd);
                    // $('#pwdbinary').val(response.data.pwdbinary);
                    (response.data.status_jadwal === 1 ? $('#status_jadwal').attr('checked', 'checked') : $('#status_jadwal').removeAttr('checked'));

                    //set error validation
                    $('#jadwal_id').removeClass('is-invalid');
                    $('#kode_dokter').removeClass('is-invalid');
                    $('#tgl_praktek').removeClass('is-invalid');
                    $('#jam_mulai').removeClass('is-invalid');
                    $('#jam_selesai').removeClass('is-invalid');
                    $('#keterangan').removeClass('is-invalid');
                    $('#jenis_jadwal').removeClass('is-invalid');
                    $('#resign_dt').removeClass('is-invalid');
                    $('#whatsapp_no').removeClass('is-invalid');
                    // $('#last_token').removeClass('is-invalid');
                    $('#passwd').removeClass('is-invalid');
                    $('#emp_cd').removeClass('is-invalid');
                    // $('#salespointcd').removeClass('is-invalid');
                    // $('#token_dt').removeClass('is-invalid');
                    // $('#initname').removeClass('is-invalid');
                    $('#status_jadwal').removeClass('is-invalid');
                    $('#role_cd').removeClass('is-invalid');
                    // $('#pwdbinary').removeClass('is-invalid');

                    $('.errorJadwal_id').html('');
                    $('.errorKode_dokter').html('');
                    $('.errorTgl_praktek').html('');
                    $('.errorJam_mulai').html('');
                    $('.errorJam_selesai').html('');
                    $('.errorKeterangan').html('');
                    $('.errorJenis_jadwal').html('');
                    $('.errorResign_dt').html('');
                    $('.errorWhatsapp_no').html('');
                    // $('.errorLast_token').html('');
                    $('.errorPasswd').html('');
                    $('.errorEmp_cd').html('');
                    // $('.errorSalespointcd').html('');
                    // $('.errorToken_dt').html('');
                    // $('.errorInitname').html('');
                    $('.errorstatus_jadwal').html('');
                    $('.errorRole_cd').html('');
                    // $('.errorPwdbinary').html('');

                    //set selected data select2
                    $('#kode_dokter').val(response.data.kode_dokter);
                    $('#kode_dokter').trigger('change');
                    $('#jenis_jadwal').val(response.data.jenis_jadwal);
                    $('#jenis_jadwal').trigger('change');

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

        $(document).on('click', '.rescedule', function() {
            var jadwal_id = $(this).data('jadwal_id');

            $.ajax({
                url: "<?= site_url('tdokterjadwal/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    jadwal_id: jadwal_id
                },
                dataType: "JSON",
                success: function(response) {
                    //set input form2
                    $('#jadwal_id2').removeAttr('disabled');
                    $('#kode_dokter2').removeAttr('disabled');
                    $('#tgl_praktek2').removeAttr('disabled');
                    $('#jam_mulai2').removeAttr('disabled');
                    $('#jam_selesai2').removeAttr('disabled');
                    $('#keterangan2').removeAttr('disabled');
                    $('#jenis_jadwal2').removeAttr('disabled');
                    $('#status_jadwal2').removeAttr('disabled');

                    $('#jadwal_id2').attr('disabled', '');
                    $('#status_jadwal2').removeAttr('checked');
                    $('#kode_dokter2').attr('disabled', '');
                    $('#tgl_praktek2').attr('disabled', '');
                    $('#jam_mulai2').attr('disabled', '');
                    $('#jam_selesai2').attr('disabled', '');
                    $('#keterangan2').attr('disabled', '');
                    $('#status_jadwal2').attr('disabled', '');
                    $('#jenis_jadwal2').attr('disabled', '');

                    //set input form3
                    $('#jadwal_id3').removeAttr('disabled');
                    $('#kode_dokter3').removeAttr('disabled');
                    $('#tgl_praktek3').removeAttr('disabled');
                    $('#jam_mulai3').removeAttr('disabled');
                    $('#jam_selesai3').removeAttr('disabled');
                    $('#keterangan3').removeAttr('disabled');
                    $('#jenis_jadwal3').removeAttr('disabled');
                    $('#status_jadwal3').removeAttr('disabled');
                    $('#jadwal_id3').attr('readonly', '');
                    $('#jadwal_id3').attr('disabled', '');
                    $('#jenis_jadwal3').attr('disabled', '');
                    $('#kode_dokter3').attr('disabled', '');
                    $('#status_jadwal3').attr('disabled', '');
                    //$('#status_jadwal3').removeAttr('checked');

                    $('#data_form')[0].reset();
                    $('#data_form2')[0].reset();

                    //set data from2 response record
                    $('#jadwal_id2').val(response.data.jadwal_id);
                    $('#kode_dokter2').val(response.data.kode_dokter);
                    $('#tgl_praktek2').val(response.data.tgl_praktek);
                    $('#jam_mulai2').val(response.data.jam_mulai);
                    $('#jam_selesai2').val(response.data.jam_selesai);
                    $('#keterangan2').val(response.data.keterangan);
                    $('#jenis_jadwal2').val(response.data.jenis_jadwal);
                    // $('#status_jadwal2').val(response.data.status_jadwal);
                    (response.data.status_jadwal === 1 ? $('#status_jadwal2').attr('checked', 'checked') : $('#status_jadwal2').removeAttr('checked'));

                    //set data from response record
                    $('#jadwal_id3').val('');
                    $('#jadwal_id3_h').val(response.data.jadwal_id);
                    $('#kode_dokter3').val(response.data.kode_dokter);
                    $('#kode_dokter3_h').val(response.data.kode_dokter);
                    $('#tgl_praktek3').val(response.data.tgl_praktek);
                    $('#jam_mulai3').val(response.data.jam_mulai);
                    $('#jam_selesai3').val(response.data.jam_selesai);
                    $('#keterangan3').val(response.data.keterangan);
                    $('#jenis_jadwal3').val(response.data.jenis_jadwal);
                    // $('#jenis_jadwal3_h').val(response.data.jenis_jadwal);
                    // $('#status_jadwal').val(response.data.status_jadwal);
                    (response.data.status_jadwal === 1 ? $('#status_jadwal3').attr('checked', 'checked') : $('#status_jadwal3').removeAttr('checked'));

                    //set error validation
                    $('#jadwal_id3').removeClass('is-invalid');
                    $('#kode_dokter3').removeClass('is-invalid');
                    $('#tgl_praktek3').removeClass('is-invalid');
                    $('#jam_mulai3').removeClass('is-invalid');
                    $('#jam_selesai3').removeClass('is-invalid');
                    $('#keterangan3').removeClass('is-invalid');
                    $('#jenis_jadwal3').removeClass('is-invalid');
                    $('#status_jadwal3').removeClass('is-invalid');

                    $('.errorJadwal_id3').html('');
                    $('.errorKode_dokter3').html('');
                    $('.errorTgl_praktek3').html('');
                    $('.errorJam_mulai3').html('');
                    $('.errorJam_selesai3').html('');
                    $('.errorKeterangan3').html('');
                    $('.errorJenis_jadwal3').html('');
                    $('.errorStatus_jadwal3').html('');

                    //set selected data select2 form2
                    $('#kode_dokter2').val(response.data.kode_dokter);
                    $('#kode_dokter2').trigger('change');
                    $('#jenis_jadwal2').val(response.data.jenis_jadwal);
                    $('#jenis_jadwal2').trigger('change');

                    //set selected data select2 form
                    $('#kode_dokter3').val(response.data.kode_dokter);
                    $('#kode_dokter3').trigger('change');
                    $('#jenis_jadwal3').val('REGT');
                    $('#jenis_jadwal3').trigger('change');

                    //set modal & form
                    $('.modal-title').text('Rescedule Data');
                    $('#action2').val('Rescedule');
                    $('#submit_button2').show();
                    $('#submit_button2').val('Simpan');
                    $('#submit_button2').html('Simpan');
                    $('#modalform2').modal('show');
                    // $('#hidden_id').val(id);
                }
            })
        });

        $(document).on('click', '.delete', function() {
            var jadwal_id = $(this).data('jadwal_id');
            if (confirm("Are you sure you want to remove it?")) {
                $.ajax({
                    url: "<?= site_url('tdokterjadwal/delete'); ?>",
                    method: "POST",
                    data: {
                        jadwal_id: jadwal_id
                    },
                    dataType: "JSON",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                            //footer: '<a href="">Why do I have this issue?</a>'
                        });
                        tdokterjadwal();
                        setTimeout(function() {
                            $('#message').html('');
                        }, 5000);
                    }
                })
            }
        });
    });
</script>



<?= $this->endSection('script'); ?>