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
<!-- fullCalendar -->
<link rel="stylesheet" href="<?= base_url('plugins/fullcalendar/main.css') ?>">

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

    /* set background-color red if day sunday */
    .fc-daygrid-day.fc-day.fc-day-sun {
        /* background-color: red; */
        color: red;
    }

    .fc-daygrid-day-number {
        font-size: 1.1rem !important;
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
                <div class="col-md-12">
                    <div class="col-12 col-sm-12">
                        <div class="card card-primary card-outline card-outline-tabs">
                            <div class="card-header p-0 border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="custom-tabs-four-tgl-tab" data-toggle="pill" href="#custom-tabs-four-tgl" role="tab" aria-controls="custom-tabs-four-tgl" aria-selected="false">Berdasarkan Tanggal</a>
                                    </li>
                                    <!-- <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-four-dokter-tab" data-toggle="pill" href="#custom-tabs-four-dokter" role="tab" aria-controls="custom-tabs-four-dokter" aria-selected="true">Berdasarkan Dokter</a>
                                    </li> -->
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-four-tabContent">
                                    <div class="tab-pane fade active show" id="custom-tabs-four-tgl" role="tabpanel" aria-labelledby="custom-tabs-four-tgl-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card card-primary">
                                                    <div class="card-body p-2">
                                                        <!-- THE CALENDAR -->
                                                        <!-- <div class="col-sm-12"> -->
                                                        <div id="calendar"></div>
                                                        <!-- </div> -->
                                                    </div>
                                                    <!-- /.card-body -->
                                                </div>
                                                <!-- /.card -->
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-md-6" id="jadwalbytgl">
                                                <div class="sticky-top mb-3">
                                                    <div class="card">
                                                        <!-- <div class="card-header">
                                                            <h4 class="card-title">Dokter</h4>
                                                        </div> -->
                                                        <div class="card-body">

                                                            <div id="viewjadwalbytgl"></div>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <!-- /.row -->
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-four-dokter" role="tabpanel" aria-labelledby="custom-tabs-four-dokter-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <div class="card">
                                                        <!-- <div class="card-header">
                                                            <h4 class="card-title">Dokter</h4>
                                                        </div> -->
                                                        <div class="card-body">
                                                            <div class="col-sm-12">
                                                                <span id="viewdokter"></span>
                                                            </div>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-md-6" id="jadwalbydokter">
                                                <div class="sticky-top mb-3">
                                                    <div class="card">
                                                        <!-- <div class="card-header">
                                                            <h4 class="card-title">Dokter</h4>
                                                        </div> -->
                                                        <div class="card-body">
                                                            <div class="col-sm-12">
                                                                <span id="viewjadwalbydokter"></span>
                                                            </div>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <!-- /.row -->
                                    </div>
                                </div>
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
                                                    <label for="tujuan_registrasi_x" class="col-sm-2 col-form-label">Tujuan</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control form-control-sm" id="tujuan_registrasi_x" name="tujuan_registrasi_x" value="Konsul Dokter" readonly>
                                                        <span class="error invalid-feedback errorTujuan_registrasi_x">
                                                        </span>
                                                    </div>
                                                    <input type="hidden" id="tujuan_registrasi" name="tujuan_registrasi" />
                                                </div>
                                                <div class="mb-3 row">
                                                    <?= $cb_type_pasien ?>
                                                    <?= $cb_asuransi ?>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="nama_dokter" class="col-sm-2 col-form-label">Nama Dokter</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control form-control-sm" id="nama_dokter" name="nama_dokter" readonly>
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
                                                        <input type="text" class="form-control form-control-sm" id="tgl_registrasi" name="tgl_registrasi" value="" readonly>
                                                        <span class="error invalid-feedback errorTgl_registrasi">
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="jam_mulai" class="col-sm-2 col-form-label">Mulai</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control form-control-sm" id="jam_mulai" name="jam_mulai" readonly>
                                                        <span class="error invalid-feedback errorJam_mulai">
                                                        </span>
                                                    </div>
                                                    <label for="jam_selesai" class="col-sm-2 col-form-label">Selesai</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control form-control-sm" id="jam_selesai" name="jam_selesai" readonly>
                                                        <span class="error invalid-feedback errorJam_selesai">
                                                        </span>
                                                    </div>
                                                </div>


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
                                                                    <label for="usia" class="col-sm-2 col-form-label">Usia</label>
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
                                                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

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

<!-- fullCalendar 2.2.5 -->
<script src="<?= base_url('plugins/moment/moment.min.js') ?>"></script>
<script src="<?= base_url('plugins/fullcalendar/main.js') ?>"></script>

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
    function jadwalDokter() {
        $.ajax({
            method: "get",
            url: "<?= site_url('jadwaldokter/fetchDokter'); ?>",
            success: function(data) {
                $('#viewdokter').html(data);
            }
        });
    }

    function defaultJadwalByTgl() {
        var tgl_new = new Date().toLocaleDateString('en-US');
        var d_arr = tgl_new.split("/");
        var fromDate = d_arr[2] + '-' + d_arr[0] + '-' + d_arr[1];
        var tgl_praktek = fromDate.split(' ')[0];

        $.ajax({
            url: "<?= site_url('jadwaldokter/fetchJadwalByTgl'); ?>",
            method: "GET",
            data: {
                tgl_praktek: tgl_praktek
            },
            // dataType: "JSON",
            success: function(data) {

                if ($("#jadwalbytgl").is(":hidden")) {
                    $('#jadwalbytgl').show();
                }
                $('#viewjadwalbytgl').html(data);

            }
        });
    }

    defaultJadwalByTgl();

    $(document).ready(function() {
        $('#jadwalbytgl').hide();
        $('#jadwalbydokter').hide();
        jadwalDokter();

    });
</script>

<script>
    $(document).ready(function() {

        $('#Tipe_Pasien').on("change", function(e) {
            var val = $(this).val();
            if (val === 'ASRN') {
                $('#asr_cd').removeAttr('disabled');
            } else {
                $('#asr_cd').val(' ');
                $('#asr_cd').trigger('change');
                $('#asr_cd').attr('disabled', '');
            }
        });

        $(document).on('click', '.view', function() {
            var kode_dokter = $(this).data('kode_dokter');
            $.ajax({
                url: "<?= site_url('jadwaldokter/fetchJadwalByDokter'); ?>",
                method: "GET",
                data: {
                    kode_dokter: kode_dokter
                },
                // dataType: "JSON",
                success: function(data) {

                    if ($("#jadwalbydokter").is(":hidden")) {
                        $('#jadwalbydokter').show();
                    }
                    $('#viewjadwalbydokter').html(data);
                }
            })
        });

        $(document).on('click', '#custom-tabs-four-tgl-tab', function() {

            calendar.render();

        });

        $('#patient_no.select2').on('change', function() {
            var patient_no = $("#patient_no.select2 option:selected").val();

            if (patient_no !== ' ') {

                $.ajax({
                    url: "<?= site_url('patient/fetchSingleData'); ?>",
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
                        // $('#birth_dt').val(response.data.birth_dt);
                        $('#birth_dt').val(birth_dt);
                        $('#addr').val(response.data.addr);
                        $('#mobile_no').val(response.data.mobile_no);
                        calculate();
                    }
                });
            }
        });

        // $('#tujuan_registrasi.select2').on('change', function() {
        //     var data = $("#tujuan_registrasi.select2 option:selected").val();
        //     // alert(data);
        // });

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
            $('#tujuan_registrasi').val(' ');

            //set selected data select2
            $('#patient_no').val(' ');
            $('#patient_no').trigger('change');

            $('#data_form')[0].reset();

            //remove error validation message
            $('#patient_no').removeClass('is-invalid');
            $('.errorPatient_no').html('');
            $('#tujuan_registrasi').removeClass('is-invalid');
            $('.errorTujuan_registrasi').html('');
            $('#Tipe_Pasien').removeClass('is-invalid');
            $('.errorTipe_Pasien').html('');
            $('#asr_cd').removeClass('is-invalid');
            $('.errorAsr_cd').html('');

            $('#jadwal_id').val(jadwal_id);
            $('#jam_mulai').val(jam_mulai);
            $('#jam_selesai').val(jam_selesai);
            $('#kode_dokter').val(kode_dokter);
            $('#nama_dokter').val(nama_dokter);
            $('#tanggal').val(convertDateUs(tanggal));
            $('#tgl_registrasi').val(tgl_registrasi);
            $('#tujuan_registrasi').val('dokter');
            $('#asr_cd').attr('disabled', '');


            $('#modalformregistrasi').modal('show');

            // set modal & form
            $('.modal-title').text('Registrasi ');
            $('#action').val('Registrasi');
            $('#submit_button4').val('Registrasi');
            $('#submit_button4').html('Registrasi');
            $('#modalformregistrasi').modal('show');

        });

        $('#data_form').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "<?= site_url('tregistrasi/action'); ?>",
                method: "POST",
                data: $(this).serialize(),
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
                        $('#deleted').removeAttr('checked');

                        $('#modalformregistrasi').modal('hide');
                    }
                },
            })
        });
    });
</script>

<!-- Page specific script -->
<script>
    $(function() {

        /* initialize the calendar
         -----------------------------------------------------------------*/
        //Date for the calendar events (dummy data)
        var date = new Date()
        var d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear()

        var Calendar = FullCalendar.Calendar;
        var calendarEl = document.getElementById('calendar');

        var calendar = new Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: ''
                // right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            themeSystem: 'bootstrap',
            selectable: true,
            buttonText: {
                today: "Hari ini"
            },
            dateClick: function(info) {
                var tgl_praktek = info.dateStr;
                // alert(tgl_praktek);
                $.ajax({
                    url: "<?= site_url('jadwaldokter/fetchJadwalByTgl'); ?>",
                    method: "GET",
                    data: {
                        tgl_praktek: tgl_praktek
                    },
                    // dataType: "JSON",
                    success: function(data) {

                        if ($("#jadwalbytgl").is(":hidden")) {
                            $('#jadwalbytgl').show();
                        }
                        $('#viewjadwalbytgl').html(data);

                    }
                })

            }
            //Random default events

        });
        calendar.setOption('locale', 'id');

        calendar.render();
    })
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
        var fromDate = d_arr[0] + '/' + d_arr[1] + '/' + d_arr[2];
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