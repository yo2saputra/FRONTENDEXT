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
    .tr {
        text-align: rihgt;
    }

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
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">

                                    </div>
                                    <form id="data_form" autocomplete="off">
                                        <div class="row">
                                            <?= csrf_field(); ?>
                                            <?= $cb_pasien ?>
                                            <input type="hidden" id="no_pasien_hd" name="no_pasien_hd" />
                                            <label for="tgl_praktek1" class="col-sm-1 col-form-label">MULAI</label>
                                            <div class="col-sm-2">
                                                <div class="input-group date tgl_praktek1" data-date-format="mm/dd/yyyy">
                                                    <input type="text" class="form-control form-control-sm datepicker" placeholder="dd-mm-yyyy" id="tgl_praktek1" name="tgl_praktek1">
                                                    <div class="input-group-append" data-target="#tgl_praktek1" data-toggle="tgl_praktek1">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                                <span class="error invalid-feedback errorTgl_praktek1">
                                                </span>
                                            </div>
                                            <label for="tgl_praktek2" class="col-sm-1 col-form-label">SAMPAI</label>
                                            <div class="col-sm-2">
                                                <div class="input-group date tgl_praktek2" data-date-format="mm/dd/yyyy">
                                                    <input type="text" class="form-control form-control-sm datepicker" placeholder="dd-mm-yyyy" id="tgl_praktek2" name="tgl_praktek2">
                                                    <div class="input-group-append" data-target="#tgl_praktek2" data-toggle="tgl_praktek2">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                                <span class="error invalid-feedback errorTgl_praktek2">
                                                </span>
                                            </div>
                                            <button type="submit" name="submit" id="submit_button" class="btn btn-sm btn-primary col-sm-1"><i class="fas fa-search"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
    function rptregistrasi() {
        $.ajax({
            method: "GET",
            url: "<?= site_url('rptregistrasi/search'); ?>",
            success: function(data) {
                $('#viewdata').html(data);
            }
        });
    }

    $(document).ready(function() {
        rptregistrasi();

        //Set DatePicker to now
        $('#tgl_praktek1').datepicker("setDate", new Date());
        $('#tgl_praktek2').datepicker("setDate", new Date());

        $('#no_pasien_hd').val('ALL');

        $(document).on('change', '#no_pasien', function(e) {
            var theSelection = $("#no_pasien :selected").select2(this.data);
            no_pasien = $(theSelection).text();
            if (no_pasien == '--ALL--') {
                $('#no_pasien_hd').val('ALL');
            } else {
                $('#no_pasien_hd').val(no_pasien);
            }

        });

    });
</script>

<script>
    $(document).ready(function() {

        $('#data_form').on('submit', function(event) {
            event.preventDefault();

            $.ajax({
                url: "<?= site_url('inqregistrasi/search'); ?>",
                method: "GET",
                data: $(this).serialize(),
                // dataType: "JSON",
                beforeSend: function() {
                    $('#submit_button4').prop('disabled', true);
                    $('#submit_button').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('#submit_button').prop('disabled', false);
                    $('#submit_button').html('<i class="fas fa-search"></i>');
                },
                success: function(data) {
                    $('#viewdata').html(data);
                },
            })
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


    });
</script>

<!-- Datepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<script>
    $('#tgl_praktek1').datepicker({
        todayHighlight: true,
        autoclose: true,
        format: 'dd-mm-yyyy'
    }).val();
    $('#tgl_praktek2').datepicker({
        todayHighlight: true,
        autoclose: true,
        format: 'dd-mm-yyyy'
    }).val();
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