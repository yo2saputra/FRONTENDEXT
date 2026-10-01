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

    /* #scan_input {
        background-color: #F9F39A;
    } */
</style>
<?= $this->endSection('style'); ?>

<?= $this->section('content'); ?>

<?php
$session = session();
?>

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

                            <div class="mb-3 row">
                                <label for="no_kwitansi" class="col-sm-2 col-form-label">NO. KWITANSI</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-sm" id="no_kwitansi" name="no_kwitansi" style="direction: ltr;" disabled>
                                    <span class="error invalid-feedback errorno_kwitansi">
                                    </span>
                                </div>
                                <div class="col-sm-2"></div>
                                <label for="tgl_kwitansi" class="col-sm-2 col-form-label">TGL. KWITANSI</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-sm" id="tgl_kwitansi" name="tgl_kwitansi" value="<?= date("d/m/Y") ?>" style="direction: rtl;" disabled>
                                    <span class="error invalid-feedback errortgl_kwitansi">
                                    </span>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="no_registrasi" class="col-sm-2 col-form-label">NO. REGISTRASI</label>
                                <div class="input-group input-group-sm col-sm-3">
                                    <input type="text" class="form-control" id="no_registrasi" style="direction: ltr;" value="<?= $session->get('no_registrasi') !== '' ? $session->get('no_registrasi') : '' ?>" disabled>
                                    <span class="input-group-append">
                                        <button type="button" class="btn btn-success btn-flat" id="registrasi"><i class='fas fa-search'></i></button>
                                    </span>
                                </div>
                                <div class="col-sm-2"></div>
                                <label for="user" class="col-sm-2 col-form-label">PETUGAS</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-sm" id="user" name="user" value="<?= $session->get('usr_id'); ?>" style="direction: rtl;" disabled>
                                    <span class="error invalid-feedback errorUser">
                                    </span>
                                </div>
                            </div>

                            <div class="mb-1 row">
                                <div class="col-sm-7"></div>
                                <div class="col-sm-5 text-right">
                                    <strong style="font-size: 2rem;">Rp <span id="grandTotal">0.00</span></strong>
                                </div>
                            </div>

                            <div class="mb-3 row">

                                <!-- <label for="item_cd" class="col-sm-2 col-form-label">NO. REGISTRASI</label> -->
                                <div class="input-group input-group-sm col-sm-5">
                                    <input type="text" class="form-control" id="scan_input" style="direction: ltr;" placeholder="BARCODE SCANNER">
                                    <span class="input-group-append">
                                        <button type="button" class="btn btn-info btn-flat" id="item"><i class='fas fa-barcode'></i></button>
                                    </span>
                                </div>
                                <div class="col-sm-7"></div>
                            </div>


                            <div class="mb-3 row">

                                <div class="form-row" style="display: none;">
                                    <div class="form-group col-md-4">
                                        <label for="itemInput">Item:</label>
                                        <input type="text" class="form-control" id="itemInput" placeholder="Item">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="quantityInput">Quantity:</label>
                                        <input type="number" min="1" class="form-control" id="quantityInput" placeholder="Quantity">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="rateInput">Rate:</label>
                                        <input type="number" class="form-control" id="rateInput" placeholder="Rate">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="discountInput">Discount:</label>
                                        <input type="number" class="form-control" id="discountInput" placeholder="Discount">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="taxInput">Tax:</label>
                                        <input type="number" class="form-control" id="taxInput" placeholder="Tax">
                                    </div>
                                </div>

                                <table class="table tabledetail">
                                    <thead>
                                        <tr>
                                            <th scope="col">
                                                <input type="checkbox" id="selectAllCheckbox" onclick="selectAllItems()">
                                            </th>
                                            <th scope="col" class="">Code</th>
                                            <th scope="col">Item</th>
                                            <th scope="col" class="text-right">Jumlah</th>
                                            <th scope="col" class="text-right">Tarif</th>
                                            <th scope="col">Potongan</th>
                                            <th scope="col">Pajak</th>
                                            <th scope="col" class="text-right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>

                            </div>
                            <div class="mt-3">
                                <button class="btn btn-primary mb-3" onclick="addItem()" style="display: none;">ADD</button>
                                <button class="btn btn-info mb-3" onclick="postData()">DEPOSIT</button>
                                <button class="btn btn-danger mb-3" onclick="deleteSelectedItems()">DELETE</button>
                                <button class="btn btn-success mb-3" onclick="postData()">SAVE</button>

                            </div>


                        </div>

                        <!-- Modal List Registrasi-->
                        <div class="modal fade" id="modalformregistrasi" tabindex="" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLabel"></h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <span id="live_fetchDataRegistrasi"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal List Item-->
                        <div class="modal fade" id="modalformitem" tabindex="" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLabel"></h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <span id="live_fetchDataItem"></span>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <!-- /.card -->

                </div>
                <!--/.col (left) -->

                <!-- right column -->
                <!-- <div class="col-md-4"> -->
                <!-- jquery validation -->
                <!-- <div class="card card-outline card-info">

                        <div class="card-body">
                        </div>

                    </div> -->
                <!-- </div> -->
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

            //remove error validation message
            $('#patient_no').removeClass('is-invalid');
            $('.errorPatient_no').html('');
            $('#tujuan_registrasi').removeClass('is-invalid');
            $('.errorTujuan_registrasi').html('');
            $('#Tipe_Pasien').removeClass('is-invalid');
            $('.errorTipe_Pasien').html('');
            $('#asr_cd').removeClass('is-invalid');
            $('.errorAsr_cd').html('');

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

<script>
    $(document).ready(function() {
        displayItems();
    });

    function addItem() {
        var itemInput = $('#itemInput');
        var quantityInput = $('#quantityInput');
        var rateInput = $('#rateInput');
        var discountInput = $('#discountInput');
        var taxInput = $('#taxInput');

        var itemList = JSON.parse(localStorage.getItem('items')) || [];

        if (itemInput.val().trim() !== '') {
            var total = calculateTotal(quantityInput.val(), rateInput.val(), discountInput.val(), taxInput.val());
            itemList.push({
                item: itemInput.val(),
                quantity: quantityInput.val(),
                rate: rateInput.val(),
                discount: discountInput.val(),
                tax: taxInput.val(),
                total: total
            });
            localStorage.setItem('items', JSON.stringify(itemList));
            clearInputFields();
            displayItems();
        }
    }

    function calculateTotal(quantity, rate, discount, tax) {
        var subtotal = quantity * rate;
        var discountedAmount = subtotal * (1 - discount / 100);
        var taxedAmount = discountedAmount + (discountedAmount * (tax / 100));
        return taxedAmount.toFixed(2);
    }

    function displayItems() {
        var itemList = JSON.parse(localStorage.getItem('items')) || [];
        var itemTableBody = $('.tabledetail tbody');
        itemTableBody.empty();

        itemList.forEach(function(item, index) {
            var row = $('<tr>');
            row.append('<td><input type="checkbox"class="item-checkbox"></td>');
            row.append('<td>' + item.item_cd + '</td>');
            row.append('<td>' + item.item + '</td>');
            row.append('<td class="text-right"><input type="text" min="1" maxlength="3" size="3" class="quantity-input" value="' + item.quantity + '"></td>');
            row.append('<td class="text-right">' + formatNumber(item.rate) + '</td>');
            row.append('<td>' + item.discount + '%</td>');
            row.append('<td>' + item.tax + '%</td>');
            row.append('<td class="text-right">' + formatNumber(item.total) + '</td>');
            itemTableBody.append(row);
        });

        attachQuantityChangeEvent();
        updateGrandTotal();
    }

    function attachQuantityChangeEvent() {
        $('.quantity-input').off('input').on('input', function() {
            var index = $(this).closest('tr').index();
            var newQuantity = $(this).val();

            updateQuantity(index, newQuantity);
            updateTotal(index);
            displayItems();
        });
    }

    function updateQuantity(index, newQuantity) {
        var itemList = JSON.parse(localStorage.getItem('items')) || [];
        itemList[index].quantity = newQuantity;
        localStorage.setItem('items', JSON.stringify(itemList));
    }

    function updateTotal(index) {
        var itemList = JSON.parse(localStorage.getItem('items')) || [];
        var quantity = itemList[index].quantity;
        var rate = itemList[index].rate;
        var discount = itemList[index].discount;
        var tax = itemList[index].tax;

        var newTotal = calculateTotal(quantity, rate, discount, tax);
        itemList[index].total = newTotal;
        localStorage.setItem('items', JSON.stringify(itemList));
    }

    function postData() {
        var itemList = JSON.parse(localStorage.getItem('items')) || [];
        // console.log('Sending data to the server:', itemList);

        // Mengonversi JSON ke objek JavaScript
        const parsedData = JSON.parse(localStorage.getItem('items')) || [];

        // Memeriksa duplikat berdasarkan nilai kunci 'item_cd'
        const seenItemCds = new Set();
        const duplicates = [];

        parsedData.forEach(item => {
            if (seenItemCds.has(item.item_cd)) {
                duplicates.push(item);
            } else {
                seenItemCds.add(item.item_cd);
            }
        });

        if (parsedData.length == 0) {
            //sweet alert
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Item Masih Kosong!',
                //footer: '<a href="">Why do I have this issue?</a>'
            });

        } else {

            // Menampilkan data duplikat jika ada
            if (duplicates.length > 0) {
                //sweet alert
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Terdapat Item Duplikat!',
                    //footer: '<a href="">Why do I have this issue?</a>'
                });

            } else {

                if ($("#no_registrasi").val() !== '') {
                    $.ajax({
                        type: 'POST',
                        url: '<?= site_url('kasir/store'); ?>',
                        contentType: 'application/json',
                        data: JSON.stringify(itemList),
                        success: function(response) {
                            console.log('Data successfully sent to the server:', response);
                            localStorage.removeItem('items');
                            // Tambahkan logika atau tindakan lain yang diperlukan setelah sukses
                            displayItems();
                            removeNoRegistrasi();
                        },
                        error: function(error) {
                            console.error('Error sending data to the server:', error);
                            // Tambahkan logika atau tindakan lain yang diperlukan pada kesalahan
                        }
                    });

                } else {
                    //sweet alert
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: 'No Registrasi Belum Dipilih!',
                        //footer: '<a href="">Why do I have this issue?</a>'
                    });
                }

            }
        }

    }

    function removeNoRegistrasi() {
        $.ajax({
            method: "GET",
            url: "<?= site_url('kasir/removenoregistrasi'); ?>",
            success: function(data) {
                $("#no_registrasi").val('');
            }
        });
    }

    function clearInputFields() {
        $('#itemInput, #quantityInput, #rateInput, #discountInput, #taxInput').val('');
    }

    function selectAllItems() {
        var checkboxes = $('.item-checkbox');
        var selectAllCheckbox = $('#selectAllCheckbox');

        checkboxes.prop('checked', selectAllCheckbox.prop('checked'));
    }

    function deleteSelectedItems() {
        var checkboxes = $('.item-checkbox');
        var itemList = JSON.parse(localStorage.getItem('items')) || [];
        var updatedItemList = [];

        checkboxes.each(function(index) {
            if (!$(this).prop('checked')) {
                updatedItemList.push(itemList[index]);
            }
        });

        localStorage.setItem('items', JSON.stringify(updatedItemList));
        displayItems();
    }

    function formatNumber(number) {
        return parseFloat(number).toLocaleString('in-IN', {
            minimumFractionDigits: 2
        });
    }

    function updateGrandTotal() {
        var itemList = JSON.parse(localStorage.getItem('items')) || [];
        var grandTotal = itemList.reduce(function(total, item) {
            return total + parseFloat(item.total);
        }, 0);

        $('#grandTotal').text(formatNumber(grandTotal));
    }

    function fetchDataListRegistrasi() {
        $.ajax({
            method: "GET",
            url: "<?= site_url('kasir/registrasi'); ?>",
            success: function(data) {
                $('#live_fetchDataRegistrasi').html(data);
            }
        });
    }
    // fetchDataListRegistrasi();

    $(document).on('click', '#registrasi', function() {
        fetchDataListRegistrasi();
        $('#modalformregistrasi').modal('show');

    });

    //add no_registrasi to input no.registrasi on row double click
    $(document).on("dblclick", "tr#addRowRegistrasi", function() {
        var no_registrasi = $(this).data("id");

        $.ajax({
            url: "<?= site_url('kasir/setnoregistrasi'); ?>",
            method: "GET",
            data: {
                no_registrasi: no_registrasi
            },
            dataType: "JSON",
            success: function(response) {
                $("#no_registrasi").val(no_registrasi);
                $('#modalformregistrasi').modal('hide');
            }
        })

    });

    //add no_registrasi to input (no.registrasi) on click
    $(document).on("click", ".addRegistrasi", function() {
        var no_registrasi = $(this).data("id");
        $.ajax({
            url: "<?= site_url('kasir/setnoregistrasi'); ?>",
            method: "GET",
            data: {
                no_registrasi: no_registrasi
            },
            dataType: "JSON",
            success: function(response) {
                $("#no_registrasi").val(no_registrasi);
                $('#modalformregistrasi').modal('hide');
            }
        })

    });

    function fetchDataListItem() {
        $.ajax({
            method: "GET",
            url: "<?= site_url('kasir/item'); ?>",
            success: function(data) {
                $('#live_fetchDataItem').html(data);
            }
        });
    }
    // fetchDataListItem();

    $(document).on('click', '#item', function() {
        fetchDataListItem();
        $('#modalformitem').modal('show');
    });

    //insert barang ke list pembelian detail pada saat baris data barang di double klik
    $(document).on("dblclick", "tr#addRowItem", function() {
        var item_cd = $(this).data("id");

        $.ajax({
            url: "<?= site_url('tmstitem/fetchSingleData'); ?>",
            method: "GET",
            data: {
                item_cd: item_cd
            },
            dataType: "JSON",
            success: function(response) {

                var itemList = JSON.parse(localStorage.getItem('items')) || [];

                if (item_cd.trim() !== '') {
                    var total = calculateTotal(1, response.data.unitprice, 0, (response.data.isvat === 1 ? 11 : 0));
                    itemList.push({
                        item_cd: response.data.item_cd,
                        item: response.data.item_nm,
                        quantity: 1,
                        rate: response.data.unitprice,
                        discount: 0,
                        tax: (response.data.isvat === 1 ? 11 : 0),
                        total: total
                    });
                    localStorage.setItem('items', JSON.stringify(itemList));
                    // clearInputFields();
                    displayItems();
                }

                $('#modalformitem').modal('hide');

            }
        })
    });

    //insert barang ke list pembelian detail pada saat kolom item_cd di klik
    $(document).on("click", ".addItem", function() {
        var item_cd = $(this).data("id");

        $.ajax({
            url: "<?= site_url('tmstitem/fetchSingleData'); ?>",
            method: "GET",
            data: {
                item_cd: item_cd
            },
            dataType: "JSON",
            success: function(response) {

                var itemList = JSON.parse(localStorage.getItem('items')) || [];

                if (item_cd.trim() !== '') {
                    var total = calculateTotal(1, response.data.unitprice, 0, (response.data.isvat === 1 ? 11 : 0));
                    itemList.push({
                        item_cd: response.data.item_cd,
                        item: response.data.item_nm,
                        quantity: 1,
                        rate: response.data.unitprice,
                        discount: 0,
                        tax: (response.data.isvat === 1 ? 11 : 0),
                        total: total
                    });
                    localStorage.setItem('items', JSON.stringify(itemList));
                    // clearInputFields();
                    displayItems();
                }

                $('#modalformitem').modal('hide');

            }
        })
    });

    $(document).on('click', '.view', function() {
        var item_cd = $(this).data('item_cd');

        $.ajax({
            url: "<?= site_url('tmstitem/fetchSingleData'); ?>",
            method: "GET",
            data: {
                item_cd: item_cd
            },
            dataType: "JSON",
            success: function(response) {

                var itemList = JSON.parse(localStorage.getItem('items')) || [];

                if (itemInput.val().trim() !== '') {
                    var total = calculateTotal(1, response.data.unitprice, 0, (response.data.isvat === 1 ? 11 : 0));
                    itemList.push({
                        item_cd: response.data.item_cd,
                        item: response.data.item_nm,
                        quantity: 1,
                        rate: response.data.unitprice,
                        discount: 0,
                        tax: (response.data.isvat === 11 ? 1 : 0),
                        total: total
                    });
                    localStorage.setItem('items', JSON.stringify(itemList));
                    // clearInputFields();
                    displayItems();
                }


            }
        })
    });

    //insert melalui scanner atau ketik manual penjualan
    $('#scan_input').keypress(function(e) {
        if (e.which == 13) {
            var item_cd = $('#scan_input').val();

            $.ajax({
                url: "<?= site_url('tmstitem/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    item_cd: item_cd
                },
                dataType: "JSON",
                success: function(response) {

                    var itemList = JSON.parse(localStorage.getItem('items')) || [];

                    if (item_cd.trim() !== '') {
                        var total = calculateTotal(1, response.data.unitprice, 0, (response.data.isvat === 1 ? 11 : 0));
                        itemList.push({
                            item_cd: response.data.item_cd,
                            item: response.data.item_nm,
                            quantity: 1,
                            rate: response.data.unitprice,
                            discount: 0,
                            tax: (response.data.isvat === 1 ? 11 : 0),
                            total: total
                        });
                        localStorage.setItem('items', JSON.stringify(itemList));
                        // clearInputFields();
                        displayItems();
                    }
                    $("#scan_input").val('');
                    $("#scan_input").focus();

                },
                error: function() {
                    alert('Kode Tidak Terdaftar!');
                    $("#scan_input").focus();
                }
            })
        }
    });
</script>


<?= $this->endSection('script'); ?>