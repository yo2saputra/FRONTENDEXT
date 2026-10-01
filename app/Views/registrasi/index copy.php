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

    fieldset.scheduler-border {
        border: 1px groove #ddd !important;
        padding: 0 1.4em 1.4em 1.4em !important;
        margin: 0 0 1.5em 0 !important;
        -webkit-box-shadow: 0px 0px 0px 0px #000;
        box-shadow: 0px 0px 0px 0px #000;
    }

    legend.scheduler-border {
        font-size: 1.2em !important;
        font-weight: bold !important;
        text-align: left !important;
        width: auto;
        padding: 0 10px;
        border-bottom: none;
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
                        <div class="modal fade" id="modalformregistrasi" tabindex="" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                <?= $cb_pasien ?>
                                                <?= $cb_tujuan ?>
                                            </div>
                                            <div class="mb-3 row">
                                                <?= $cb_type_pasien ?>
                                                <?= $cb_asuransi ?>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="tgl_registrasi" class="col-sm-2 col-form-label">Tanggal Registrasi</label>
                                                <div class="col-sm-4">
                                                    <div class="input-group date tgl_registrasi" data-date-format="mm/dd/yyyy">
                                                        <input type="text" class="form-control form-control-sm datepicker" placeholder="mm/dd/yyyy" id="tgl_registrasi" name="tgl_registrasi" autocomplete="off">
                                                        <div class="input-group-append" data-target="#tgl_registrasi" data-toggle="tgl_registrasi">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                    </div>
                                                    <span class="error invalid-feedback errorBirth_dt">
                                                    </span>
                                                </div>
                                                <label for="birth_dt" class="col-sm-2 col-form-label">Tanggal Praktek</label>
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
                                            <div class="mb-3 row kode_dokter">
                                                <label for="kode_dokter" class="col-sm-2 col-form-label">Dokter</label>
                                                <div class="col-sm-10">
                                                    <span id="dropdown_dokter"></span>
                                                </div>
                                            </div>

                                            <input type="hidden" id="cashless" name="cashless" value="0">
                                            <input type="hidden" id="nama_dokter" name="nama_dokter">
                                            <input type="hidden" id="tanggal" name="tanggal">
                                            <!-- <input type="hidden" id="tgl_registrasi" name="tgl_registrasi"> -->
                                            <input type="hidden" id="jam_mulai" name="jam_mulai">
                                            <input type="hidden" id="jam_selesai" name="jam_selesai">

                                            <!-- <input type="hidden" id="kode_dokter" name="kode_dokter"> -->
                                            <input type="hidden" id="tahun" name="tahun">
                                            <input type="hidden" id="bulan" name="bulan">
                                            <input type="hidden" id="hari" name="hari">
                                            <!-- <input type="hidden" id="registrasi_via" name="registrasi_via" value="offline"> -->

                                            <br>

                                            <div class="mb-3 row">
                                                <div class="col-sm-12">
                                                    <fieldset class="scheduler-border">
                                                        <legend class="scheduler-border">Profile Pasien</legend>
                                                        <div class="control-group">
                                                            <div class="mb-3 row">
                                                                <label for="nama" class="col-sm-2 col-form-label">Nama Pasien</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control form-control-sm" id="nama" name="nama" disabled>
                                                                    <span class="error invalid-feedback errorNama">
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label for="gender" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                                                                <div class="col-sm-4">
                                                                    <input type="text" class="form-control form-control-sm" id="gender" name="gender" disabled>
                                                                    <span class="error invalid-feedback errorGender">
                                                                    </span>
                                                                </div>
                                                                <label for="mobile_no" class="col-sm-2 col-form-label">Nomor HP</label>
                                                                <div class="col-sm-4">
                                                                    <input type="text" class="form-control form-control-sm" id="mobile_no" name="mobile_no" disabled>
                                                                    <span class="error invalid-feedback errorMobile_no">
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label for="birth_dt" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                                                                <div class="col-sm-4">
                                                                    <input type="text" class="form-control form-control-sm" id="birth_dt" name="birth_dt" disabled>
                                                                    <span class="error invalid-feedback errorBirth_dt">
                                                                    </span>
                                                                </div>
                                                                <span for="usia" class="col-sm-2 col-form-label"><b>Usia</b></span>
                                                                <div class="col-sm-4">
                                                                    <p id="usia" class="mt-1"></p>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label for="addr" class="col-sm-2 col-form-label">Alamat Lengkap</label>
                                                                <div class="col-sm-10">
                                                                    <textarea class="form-control form-control-sm" rows="3" placeholder="..." id="addr" name="addr" disabled></textarea>
                                                                    <span class="error invalid-feedback errorAddr">
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" id="hidden_id" name="hidden_id" />
                                            <input type="hidden" id="action" name="action" value="Add" />
                                            <button type="submit" name="submit" id="submit_button4" class="btn btn-sm btn-primary" value="Add"></button>
                                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>


                        <!-- Modal -->
                        <div class="modal fade" id="modalformview" tabindex="" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLabel"></h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="post" id="data_formx" autocomplete="off">
                                        <?= csrf_field(); ?>
                                        <div class="modal-body">
                                            <div class="mb-3 row">
                                                <?= $cb_pasien2 ?>
                                                <?= $cb_tujuan2 ?>
                                            </div>
                                            <div class="mb-3 row">
                                                <?= $cb_type_pasien2 ?>
                                                <?= $cb_asuransi2 ?>
                                            </div>

                                            <div class="mb-3 row">
                                                <label for="nama_dokter" class="col-sm-2 col-form-label">Nama Dokter</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control form-control-sm" id="nama_dokter_v" name="nama_dokter" readonly>
                                                    <span class="error invalid-feedback errorNama_dokter">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="tanggal" class="col-sm-2 col-form-label">Tanggal Praktek</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="tanggal" name="tanggal" readonly>
                                                    <span class="error invalid-feedback errorTanggal">
                                                    </span>
                                                </div>
                                                <label for="tgl_registrasi" class="col-sm-2 col-form-label">Tanggal Registrasi</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="tgl_registrasi" name="tgl_registrasi" readonly>
                                                    <span class="error invalid-feedback errorTgl_registrasi">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="jam_mulai" class="col-sm-2 col-form-label">Jam Mulai</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="jam_mulai_v" name="jam_mulai" readonly>
                                                    <span class="error invalid-feedback errorJam_mulai">
                                                    </span>
                                                </div>
                                                <label for="jam_selesai" class="col-sm-2 col-form-label">jam Selesai</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="jam_selesai_v" name="jam_selesai" readonly>
                                                    <span class="error invalid-feedback errorJam_selesai">
                                                    </span>
                                                </div>
                                            </div>

                                            <input type="hidden" id="cashless" name="cashless">
                                            <input type="hidden" id="kode_dokter" name="kode_dokter">
                                            <input type="hidden" id="tahun" name="tahun">
                                            <input type="hidden" id="bulan" name="bulan">
                                            <input type="hidden" id="hari" name="hari">
                                            <input type="hidden" id="jadwal_id" name="jadwal_id">
                                            <!-- <input type="hidden" id="registrasi_via" name="registrasi_via" value="offline"> -->

                                            <br>

                                            <div class="mb-3 row">
                                                <div class="col-sm-12">
                                                    <fieldset class="scheduler-border">
                                                        <legend class="scheduler-border">Profile Pasien</legend>
                                                        <div class="control-group">
                                                            <div class="mb-3 row">
                                                                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control form-control-sm" id="nama_v" name="nama" disabled>
                                                                    <span class="error invalid-feedback errorNama">
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label for="gender" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                                                                <div class="col-sm-4">
                                                                    <input type="text" class="form-control form-control-sm" id="gender_v" name="gender" disabled>
                                                                    <span class="error invalid-feedback errorGender">
                                                                    </span>
                                                                </div>
                                                                <label for="mobile_no" class="col-sm-2 col-form-label">Nomor HP</label>
                                                                <div class="col-sm-4">
                                                                    <input type="text" class="form-control form-control-sm" id="mobile_no_v" name="mobile_no" disabled>
                                                                    <span class="error invalid-feedback errorMobile_no">
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label for="birth_dt" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                                                                <div class="col-sm-4">
                                                                    <input type="text" class="form-control form-control-sm" id="birth_dt_v" name="birth_dt" disabled>
                                                                    <span class="error invalid-feedback errorBirth_dt">
                                                                    </span>
                                                                </div>
                                                                <label for="usia" class="col-sm-2 col-form-label">Usia</label>
                                                                <div class="col-sm-4">
                                                                    <p id="usia" class="mt-1"></p>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label for="addr" class="col-sm-2 col-form-label">Alamat Lengkap</label>
                                                                <div class="col-sm-10">
                                                                    <textarea class="form-control form-control-sm" rows="3" placeholder="..." id="addr_v" name="addr" disabled></textarea>
                                                                    <span class="error invalid-feedback errorAddr">
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
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

<!-- Datepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>


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
    $(".select").select2({
        minimumResultsForSearch: Infinity
    });
    $('#tgl_registrasi').datepicker({
        startDate: new Date(),
        todayHighlight: true,
        autoclose: true,
        dateFormat: 'MM/DD/YYYY'
    }).val();
    $('#birth_dt').datepicker({
        startDate: new Date(),
        todayHighlight: true,
        autoclose: true,
        dateFormat: 'MM/DD/YYYY'
    }).val();
</script>

<script>
    function registrasi() {
        $.ajax({
            method: "get",
            url: "<?= site_url('/tregistrasi/fetchAll'); ?>",
            success: function(data) {
                $('#viewdata').html(data);
            }
        });
    }

    $(document).ready(function() {
        registrasi()


        //datatable server side
        // $('#sample_table').DataTable({
        //     "order": [],
        //     "serverSide": true,
        //     "ajax": {
        //         url: "<?php echo base_url("/ajax_crud/fetchAll"); ?>",
        //         type: "POST",
        //     }
        // });

        $('#Tipe_Pasien').on("change", function(e) {
            var val = $(this).val();
            if (val === 'ASRN') {
                $('#asr_cd').removeAttr('disabled');
            } else {
                $('#asr_cd').val(' ');
                $('#asr_cd').trigger('change');
                $('#asr_cd').attr('disabled', '');
                // $('#asr_cd').prop('disabled', true);
            }
        });

        $(document).on('click', '#add_record', function() {

            var today = new Date();
            $('#tanggal').val(today.toLocaleDateString("en-US"));
            $('#tgl_registrasi').val(today.toLocaleDateString("en-US"));

            //set selected data select2
            $('#patient_no').val(' ');
            $('#patient_no').trigger('change');
            $('#tujuan_registrasi').val(' ');
            $('#tujuan_registrasi').trigger('change');
            $('#Tipe_Pasien').val(' ');
            $('#Tipe_Pasien').trigger('change');
            $('#asr_cd').val(' ');
            $('#asr_cd').trigger('change');
            $('#asr_cd_v').attr('disabled', '');
            $('#birthplace').removeAttr('disabled');

            //set datepicker input value
            $('#birth_dt').datepicker('update', '');
            $('#tgl_registrasi').datepicker('update', today.toLocaleDateString("en-US"));
            $('#tanggal').datepicker('update', today.toLocaleDateString("en-US"));

            //remove error validation message
            $('#patient_no').removeClass('is-invalid');
            $('.errorPatient_no').html('');
            $('#tujuan_registrasi').removeClass('is-invalid');
            $('.errorTujuan_registrasi').html('');
            $('#Tipe_Pasien').removeClass('is-invalid');
            $('.errorTipe_Pasien').html('');
            $('#asr_cd').removeClass('is-invalid');
            $('.errorAsr_cd').html('');

            // clear form profile input
            $('#nama').val("");
            $('#gender').val("");
            $('#birth_dt').val("");
            $('#addr').val("");
            $('#mobile_no').val("");
            $('p#usia').html('<b>0</b> Tahun, <b>0</b> Bulan, <b>0</b> Hari');

            //set modal & form
            $('.modal-title').text('Tambah Data');
            $('#action').val('Registrasi');
            $('#submit_button4').val('Simpan');
            $('#submit_button4').html('Simpan');
            $('#modalformregistrasi').modal('show');


        });

        $(document).on('click', '.edit', function() {
            var menu_cd = $(this).data('menu_cd');

            $.ajax({
                url: "<?= site_url('menu/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    menu_cd: menu_cd
                },
                dataType: "JSON",
                success: function(response) {
                    //set input
                    $('#menu_cd').removeAttr('disabled');
                    $('#menu_nm').removeAttr('disabled');
                    $('#reference').removeAttr('disabled');
                    $('#menu_order').removeAttr('disabled');
                    $('#menu_icon').removeAttr('disabled');
                    $('#deleted').removeAttr('disabled');
                    $('#id').removeAttr('disabled');

                    $('#menu_cd').attr('readonly', '');
                    $('#deleted').removeAttr('checked');

                    $('#data_form')[0].reset();

                    //set data from response record
                    $('#menu_cd').val(response.data.menu_cd);
                    $('#menu_nm').val(response.data.menu_nm);
                    $('#reference').val(response.data.reference);
                    $('#menu_order').val(response.data.menu_order);
                    $('#menu_icon').val(response.data.menu_icon);
                    (response.data.deleted === 1 ? $('#deleted').attr('checked', 'checked') : $('#deleted').removeAttr('checked'));

                    //set error validation
                    $('#id').removeClass('is-invalid');
                    $('#menu_cd').removeClass('is-invalid');
                    $('#menu_nm').removeClass('is-invalid');
                    $('#reference').removeClass('is-invalid');
                    $('#menu_order').removeClass('is-invalid');
                    $('#menu_icon').removeClass('is-invalid');
                    $('.errorId').html('');
                    $('.errorMenu_cd').html('');
                    $('.errorMenu_nm').html('');
                    $('.errorReference').html('');
                    $('.errorMenu_order').html('');
                    $('.errorMenu_icon').html('');

                    //set selected data select2
                    $('#id').val(response.data.header_id);
                    $('#id').trigger('change');

                    //set datepicker input value
                    $('#birth_dt').datepicker('update', response.data.birth_dt);

                    //set modal & form
                    $('.modal-title').text('Ubah Data');
                    $('#action').val('Edit');
                    $('#submit_button').show();
                    $('#submit_button').val('Simpan');
                    $('#submit_button').html('Simpan');
                    $('#modalform').modal('show');
                    $('#hidden_id').val(id);
                }
            })
        });

        $(document).on('click', '.hadir', function() {
            var no_registrasi = $(this).data('no_registrasi');
            if (confirm("Apakah anda yakin merubah status menjadi hadir?")) {
                $.ajax({
                    url: "<?= site_url('tregistrasi/hadir'); ?>",
                    method: "POST",
                    data: {
                        no_registrasi: no_registrasi
                    },
                    dataType: "JSON",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                            //footer: '<a href="">Why do I have this issue?</a>'
                        });
                        registrasi();
                        setTimeout(function() {
                            $('#message').html('');
                        }, 5000);
                    }
                })
            }
        });

        $(document).on('click', '.batal', function() {
            var no_registrasi = $(this).data('no_registrasi');
            if (confirm("Apakah anda yakin merubah status menjadi batal?")) {
                $.ajax({
                    url: "<?= site_url('tregistrasi/batal'); ?>",
                    method: "POST",
                    data: {
                        no_registrasi: no_registrasi
                    },
                    dataType: "JSON",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                            //footer: '<a href="">Why do I have this issue?</a>'
                        });
                        registrasi();
                        setTimeout(function() {
                            $('#message').html('');
                        }, 5000);
                    }
                })
            }
        });

        $(document).on('click', '.delete', function() {
            var no_registrasi = $(this).data('no_registrasi');
            if (confirm("Are you sure you want to remove it?")) {
                $.ajax({
                    url: "<?= site_url('tregistrasi/delete'); ?>",
                    method: "POST",
                    data: {
                        no_registrasi: no_registrasi
                    },
                    dataType: "JSON",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                            //footer: '<a href="">Why do I have this issue?</a>'
                        });
                        registrasi();
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

        $(document).on('click', '.view', function() {
            var no_registrasi = $(this).data('no_registrasi');

            $.ajax({
                url: "<?= site_url('tregistrasi/fetchAllView'); ?>",
                method: "GET",
                data: {
                    no_registrasi: no_registrasi
                },
                dataType: "JSON",
                beforeSend: function() {
                    $('#submit_button4').prop('disabled', true);
                    $('#submit_button4').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('#submit_button4').prop('disabled', false);
                    $('#submit_button4').html($('#submit_button4').val());
                },
                success: function(response) {
                    // $('#no_pasien_v').val(response.data.no_pasien);
                    $('#tgl_registrasi_v').val(convertDateIndo(response.data.tgl_registrasi));
                    $('#tanggal_v').val(convertDateIndo(response.data.tgl_praktek));
                    $('#nama_dokter_v').val(response.data.nama_dokter);
                    $('#jam_mulai_v').val(response.data.jam_mulai);
                    $('#jam_selesai_v').val(response.data.jam_selesai);

                    $('#patient_no_v').val(response.data.no_pasien);
                    $('#patient_no_v').trigger('change');
                    $('#patient_no_v').attr('disabled', '');
                    $('#tujuan_registrasi_v').val(response.data.tujuan_registrasi);
                    $('#tujuan_registrasi_v').trigger('change');
                    $('#tujuan_registrasi_v').attr('disabled', '');
                    $('#Tipe_Pasien_v').val(response.data.Tipe_Pasien);
                    $('#Tipe_Pasien_v').trigger('change');
                    $('#Tipe_Pasien_v').attr('disabled', '');
                    $('#asr_cd_v').val(response.data.asr_cd);
                    $('#asr_cd_v').trigger('change');
                    $('#asr_cd_v').attr('disabled', '');

                    //set datepicker input value
                    $('#birth_dt').datepicker('update', response.data.birth_dt);

                    $('#nama_v').val(response.data.fullname);
                    $('#gender_v').val(response.data.gender == 'F' ? 'Perempuan' : 'Laki - Laki');
                    $('#birth_dt_v').val(convertDateIndo(response.data.birth_dt));
                    $('#addr_v').val(response.data.addr);
                    $('#mobile_no_v').val(response.data.mobile_no);
                    $('p#usia').html('<b>' + response.data.tahun + '</b> Tahun, <b>' + response.data.bulan + '</b> Bulan, <b>' + response.data.hari + '</b> Hari');

                    $('.modal-title').text('Lihat Data');
                    $("#modalformview").modal('show');
                    // $('#viewjadwalbydokter').html(data);
                }
            });
        });

        $(document).on('click', '#custom-tabs-four-tgl-tab', function() {

            calendar.render();

        });

        $('#patient_no.select2').on('change', function() {
            var patient_no = $("#patient_no.select2 option:selected").val();

            if (patient_no !== ' ') {

                $.ajax({
                    url: "<?= site_url('mod/fetchSingleDataPasien'); ?>",
                    method: "GET",
                    data: {
                        patient_no: patient_no
                    },
                    dataType: "JSON",
                    beforeSend: function() {
                        $('#submit_button4').prop('disabled', true);
                        $('#submit_button4').html('<i class="fa fa-spin fa-spinner"></i>');
                    },
                    complete: function() {
                        $('#submit_button4').prop('disabled', false);
                        $('#submit_button4').html($('#submit_button4').val());
                    },
                    success: function(response) {

                        // $('#data_form')[0].reset();

                        //set data from response record
                        $('#nama').val(response.data.fullname);
                        $('#gender').val((response.data.gender == 'F' ? 'Perempuan' : 'Laki - Laki'));
                        var d_arr = response.data.birth_dt.split("/");
                        var birth_dt = d_arr[1] + '/' + d_arr[0] + '/' + d_arr[2];
                        $('#birth_dt').val(birth_dt);
                        $('#addr').val(response.data.addr);
                        $('#mobile_no').val(response.data.mobile_no);
                        calculate();
                    }
                });
            }
        });

        $('#tujuan_registrasi.select2').on('change', function() {
            // $(document).on('click', '#tujuan_registrasi.select2', function() {
            var poli = $("#tujuan_registrasi.select2 option:selected").val();


            if (poli !== ' ') {

                $.ajax({
                    url: "<?= site_url('tregistrasi/getDropdown'); ?>",
                    method: "GET",
                    data: {
                        poli: poli
                    },
                    // dataType: "JSON",
                    beforeSend: function() {
                        $('#submit_button4').prop('disabled', true);
                        $('#submit_button4').html('<i class="fa fa-spin fa-spinner"></i>');
                    },
                    complete: function() {
                        $('#submit_button4').prop('disabled', false);
                        $('#submit_button4').html($('#submit_button4').val());
                    },
                    success: function(data) {
                        $('#dropdown_dokter').html(data);
                        $('#kode_dokter').select2(); // Set up a Select2 control
                    }
                });
                $('.kode_dokter').show();
            } else {
                $('.kode_dokter').hide();
            }
        });


        $('#asr_cd.select2').on('change', function() {
            // $(document).on('click', '#asr_cd.select2', function() {
            var asr_cd = $("#asr_cd.select2 option:selected").val();

            if (asr_cd !== ' ') {

                $.ajax({
                    url: "<?= site_url('mod/fetchSingleDataAsuransi'); ?>",
                    method: "GET",
                    data: {
                        asr_cd: asr_cd
                    },
                    dataType: "JSON",
                    beforeSend: function() {
                        $('#submit_button4').prop('disabled', true);
                        $('#submit_button4').html('<i class="fa fa-spin fa-spinner"></i>');
                    },
                    complete: function() {
                        $('#submit_button4').prop('disabled', false);
                        $('#submit_button4').html($('#submit_button4').val());
                    },
                    success: function(response) {
                        $('#cashless').val(response.data.cashless);
                    }
                });
            } else {
                $('#cashless').val(0);
            }
        });

        $(document).on('click', '.pilih', function() {
            var jadwal_id = $(this).data('jadwal_id');
            var kode_dokter = $(this).data('kode_dokter');
            var jam_mulai = $(this).data('jam_mulai');
            var jam_selesai = $(this).data('jam_selesai');
            var nama_dokter = $(this).data('nama_dokter');
            var tanggal = $(this).data('tgl_praktek');
            var tgl_registrasi = new Date(Date.now()).toLocaleString().split(',')[0];

            $('#jadwal_id').val('');
            $('#jam_mulai').val('');
            $('#jam_selesai').val('');
            $('#kode_dokter').val('');
            $('#nama_dokter').val('');
            $('#tanggal').val('');
            $('#tgl_daftar').val('');
            $('#usia').html('');

            $('#data_form')[0].reset();

            $('#jadwal_id').val(jadwal_id);
            $('#jam_mulai').val(jam_mulai);
            $('#jam_selesai').val(jam_selesai);
            $('#kode_dokter').val(kode_dokter);
            $('#nama_dokter').val(nama_dokter);
            $('#tanggal').val(tanggal);
            $('#tgl_registrasi').val(tgl_registrasi);

            $('#modalformregistrasi').modal('show');

            // set modal & form
            $('.modal-title').text('Registrasi ');
            $('#action').val('Registrasi');
            $('#submit_button4').val('Simpan');
            $('#submit_button4').html('Simpan');
            $('#modalformregistrasi').modal('show');

        });

        $('#data_form').on('submit', function(event) {
            $('#asr_cd').removeAttr('disabled');
            if (!$.trim($('#asr_cd').val())) {
                $('#asr_cd').removeAttr('disabled');
                $('#asr_cd').val(' ');
                $('#asr_cd').trigger('change');
            }
            event.preventDefault();
            $.ajax({
                url: "<?= site_url('tregistrasi/action'); ?>",
                method: "POST",
                data: $(this).serialize(),
                // data: {
                //     nama: nama,
                //     value: value,
                //     desc: desc,
                //     action: action
                // },
                dataType: "JSON",
                // beforeSend: function() {
                //     // $('#asr_cd').removeAttr('disabled');
                //     // $('#asr_cd').val('ASR202402008');
                //     // $('#asr_cd').trigger('change');
                // },
                // complete: function() {
                //     $('#asr_cd').attr('disabled', '');
                // },
                beforeSend: function() {
                    $('#submit_button4').prop('disabled', true);
                    $('#submit_button4').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('#submit_button4').prop('disabled', false);
                    $('#submit_button4').html('Simpan');
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
                        if (response.error.tujuan_registrasi) {
                            $('#tujuan_registrasi').addClass('is-invalid');
                            $('.errorTujuan_registrasi').html(response.error.tujuan_registrasi);
                        } else {
                            $('#tujuan_registrasi').removeClass('is-invalid');
                            $('.errorTujuan_registrasi').html('');
                        }
                        if (response.error.Tipe_Pasien) {
                            $('#Tipe_Pasien').addClass('is-invalid');
                            $('.errorTipe_Pasien').html(response.error.Tipe_Pasien);
                        } else {
                            $('#Tipe_Pasien').removeClass('is-invalid');
                            $('.errorTipe_Pasien').html('');
                        }
                        if (response.error.asr_cd) {
                            $('#asr_cd').addClass('is-invalid');
                            $('.errorAsr_cd').html(response.error.asr_cd);
                        } else {
                            $('#asr_cd').removeClass('is-invalid');
                            $('.errorAsr_cd').html('');
                        }
                        if (response.error.kode_dokter) {
                            $('#kode_dokter').addClass('is-invalid');
                            $('.errorKode_dokter').html(response.error.kode_dokter);
                        } else {
                            $('#kode_dokter').removeClass('is-invalid');
                            $('.errorKode_dokter').html('');
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
                        $('#patient_no').val('');
                        $('#tujuan_registrasi').removeClass('is-invalid');
                        $('#tujuan_registrasi').val('');
                        $('#Tipe_Pasien').removeClass('is-invalid');
                        $('#Tipe_Pasien').val('');
                        $('#asr_cd').removeClass('is-invalid');
                        $('#asr_cd').val('');
                        $('#kode_dokter').removeClass('is-invalid');
                        $('#kode_dokter').val('');
                        registrasi();

                        $('#modalformregistrasi').modal('hide');
                    }
                },
            })
        });
    });
</script>


<script>
    function convertDateIndo(date) {
        var d_arr = date.split("/");
        var fromDate = d_arr[1] + '/' + d_arr[0] + '/' + d_arr[2];
        dateNew = fromDate.split(' ')[0];
        // var fromDate = date.toLocaleDateString('en-GB');
        return dateNew;
    }

    function convertDateUs(date) {
        var d_arr = date.split("/");
        var fromDate = d_arr[1] + '/' + d_arr[0] + '/' + d_arr[2];
        dateNew = fromDate.split(' ')[0];
        return dateNew;
    }

    function getDateUs() {
        var dateNew = new Date().toLocaleDateString('en-US');
        // var dateNew = date.toLocaleDateString('en-US');
        return dateNew;
    }

    function getDateIndo() {
        var dateNew = new Date().toLocaleDateString('en-GB');
        return dateNew;
    }

    function calculate() {
        //var birth_dt = new Date();
        var d_arr2 = $('#birth_dt').val().split("/");
        var fromDate = d_arr2[1] + '-' + d_arr2[0] + '-' + d_arr2[2];
        var toDate = new Date();

        try {
            // document.getElementById('usia').innerHTML = '';
            $('p#usia').val('');

            var result = getDateDifference(new Date(fromDate), new Date(toDate));

            if (result && !isNaN(result.years)) {
                document.getElementById('usia').innerHTML = '<b>' +
                    result.years + '</b> Tahun, <b>' +
                    result.months + '</b> Bulan, <b>' +
                    result.days + '</b> Hari';

                $('#tahun').val(result.years);
                $('#bulan').val(result.months);
                $('#hari').val(result.days);
            }
        } catch (e) {
            console.error(e);
        }
    }

    function getDateDifference(startDate, endDate) {
        if (startDate > endDate) {
            console.error('Start date must be before end date');
            return null;
        }
        var startYear = startDate.getFullYear();
        var startMonth = startDate.getMonth();
        var startDay = startDate.getDate();

        var endYear = endDate.getFullYear();
        var endMonth = endDate.getMonth();
        var endDay = endDate.getDate();

        // We calculate February based on end year as it might be a leep year which might influence the number of days.
        var february = (endYear % 4 == 0 && endYear % 100 != 0) || endYear % 400 == 0 ? 29 : 28;
        var daysOfMonth = [31, february, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

        var startDateNotPassedInEndYear = (endMonth < startMonth) || endMonth == startMonth && endDay < startDay;
        var years = endYear - startYear - (startDateNotPassedInEndYear ? 1 : 0);

        var months = (12 + endMonth - startMonth - (endDay < startDay ? 1 : 0)) % 12;

        // (12 + ...) % 12 makes sure index is always between 0 and 11
        var days = startDay <= endDay ? endDay - startDay : daysOfMonth[(12 + endMonth - 1) % 12] - startDay + endDay;

        return {
            years: years,
            months: months,
            days: days
        };
    }
</script>

<?= $this->endSection('script'); ?>