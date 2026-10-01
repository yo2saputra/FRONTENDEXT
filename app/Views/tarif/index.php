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
                                                <!-- <label for="item_cd" class="col-sm-2 col-form-label">ID</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control form-control-sm" id="item_cd" name="item_cd">
                                                    <span class="error invalid-feedback errorItem_cd">
                                                    </span>
                                                </div> -->
                                                <?= $cb_itemcd; ?>

                                            </div>
                                            <div class="mb-3 row">
                                                <label for="from_date" class="col-sm-2 col-form-label">From Date</label>
                                                <div class="col-sm-4">
                                                    <div class="input-group date from_date" data-date-format="mm/dd/yyyy">
                                                        <input type="text" class="form-control form-control-sm datepicker" placeholder="mm/dd/yyyy" id="from_date" name="from_date">
                                                        <div class="input-group-append" data-target="#from_date" data-toggle="from_date">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                    </div>
                                                    <span class="error invalid-feedback errorFrom_date">
                                                    </span>
                                                </div>
                                                <label for="to_date" class="col-sm-2 col-form-label">To Date</label>
                                                <div class="col-sm-4">
                                                    <div class="input-group date to_date" data-date-format="mm/dd/yyyy">
                                                        <input type="text" class="form-control form-control-sm datepicker" placeholder="mm/dd/yyyy" id="to_date" name="to_date">
                                                        <div class="input-group-append" data-target="#to_date" data-toggle="to_date">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                    </div>
                                                    <span class="error invalid-feedback errorTo_date">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="hargabeli" class="col-sm-2 col-form-label">Harga Beli</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" name="hargabeli" id="hargabeli">
                                                    <span class="error invalid-feedback errorHargabeli">
                                                    </span>
                                                </div>
                                                <label for="het" class="col-sm-2 col-form-label">HET</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" name="het" id="het">
                                                    <span class="error invalid-feedback errorHargabeli">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="ppn" class="col-sm-2 col-form-label">PPN Pembelian</label>
                                                <div class="col-sm-1">
                                                    <input type="text" class="form-control form-control-sm" name="ppn" id="ppn" placeholder="%">
                                                    <span class="error invalid-feedback errorPpn">
                                                    </span>
                                                </div>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control form-control-sm" name="ppn_nom" id="ppn_nom" placeholder="Nominal">
                                                    <span class="error invalid-feedback errorPpn_nom">
                                                    </span>
                                                </div>
                                                <div class="col-sm-6">
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="diskon_pct" class="col-sm-2 col-form-label">Diskon</label>
                                                <div class="col-sm-1">
                                                    <input type="text" class="form-control form-control-sm" name="diskon_pct" id="diskon_pct" placeholder="%">
                                                    <span class="error invalid-feedback errorDiskon_pct">
                                                    </span>
                                                </div>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control form-control-sm" name="diskon_nom" id="diskon_nom" placeholder="Nominal">
                                                    <span class="error invalid-feedback errorDiskon_nom">
                                                    </span>
                                                </div>
                                                <label for="hb_sdiskon" class="col-sm-2 col-form-label">HB Setelah Diskon</label>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control form-control-sm" name="hb_sdiskon" id="hb_sdiskon">
                                                    <span class="error invalid-feedback errorHb_sdiskon">
                                                    </span>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="checkInclude">
                                                        <label class="form-check-label" for="checkInclude">Include</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="margin_pct" class="col-sm-2 col-form-label">Margin</label>
                                                <div class="col-sm-1">
                                                    <input type="text" class="form-control form-control-sm" name="margin_pct" id="margin_pct" placeholder="%">
                                                    <span class="error invalid-feedback errorMargin_pct">
                                                    </span>
                                                </div>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control form-control-sm" name="margin_nom" id="margin_nom" placeholder="Nominal">
                                                    <span class="error invalid-feedback errorMargin_nom">
                                                    </span>
                                                </div>
                                                <label for="harga_jual" class="col-sm-2 col-form-label">Harga Jual Dasar</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" name="harga_jual" id="harga_jual">
                                                    <span class="error invalid-feedback errorHarga_jual">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="ppn_beli_pct" class="col-sm-2 col-form-label">PPN Penjualan</label>
                                                <div class="col-sm-1">
                                                    <input type="text" class="form-control form-control-sm" name="ppn_beli_pct" id="ppn_beli_pct" placeholder="%">
                                                    <span class="error invalid-feedback errorPpn_beli">
                                                    </span>
                                                </div>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control form-control-sm" name="ppn_beli_nom" id="ppn_beli_nom" placeholder="Nominal">
                                                    <span class="error invalid-feedback errorPpn_beli_nom">
                                                    </span>
                                                </div>
                                                <label for="harga_jual_akhir" class="col-sm-2 col-form-label">Harga Jual Akhir</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" name="harga_jual_akhir" id="harga_jual_akhir">
                                                    <span class="error invalid-feedback errorHarga_jual_akhir">
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
    $('#from_date').datepicker({
        todayHighlight: true,
        autoclose: true,
        dateFormat: 'MM/DD/YYYY'
    }).val();
    $('#to_date').datepicker({
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
    function ttarif() {
        $.ajax({
            method: "get",
            url: "<?= site_url('/ttarif/fetchAll'); ?>",
            success: function(data) {
                $('#viewdata').html(data);
            }
        });
    }
    $(document).ready(function() {
        ttarif()

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
            $('#item_cd').removeAttr('disabled');
            $('#hargabeli').removeAttr('disabled');
            $('#het').removeAttr('disabled');
            $('#from_date').removeAttr('disabled');
            $('#to_date').removeAttr('disabled');
            $('#item_cd').removeAttr('readonly');
            $('#ppn').removeAttr('disabled');
            $('#hb_sppn').removeAttr('disabled');
            $('#diskon_pct').removeAttr('disabled');
            $('#diskon_nom').removeAttr('disabled');
            $('#hb_sdiskon').removeAttr('disabled');
            $('#margin_pct').removeAttr('disabled');
            $('#margin_nom').removeAttr('disabled');
            $('#harga_jual').removeAttr('disabled');


            //set input readonly
            // $('#het').attr('readonly', '');

            $('#data_form')[0].reset();

            //set error validation
            $('#item_cd').removeClass('is-invalid');
            $('#hargabeli').removeClass('is-invalid');
            $('#het').removeClass('is-invalid');
            $('#from_date').removeClass('is-invalid');
            $('#to_date').removeClass('is-invalid');
            $('#ppn').removeClass('is-invalid');
            $('#hb_sppn').removeClass('is-invalid');
            $('#diskon_pct').removeClass('is-invalid');
            $('#diskon_nom').removeClass('is-invalid');
            $('#hb_sdiskon').removeClass('is-invalid');
            $('#margin_pct').removeClass('is-invalid');
            $('#margin_nom').removeClass('is-invalid');
            $('#harga_jual').removeClass('is-invalid');

            $('.errorItem_cd').html('');
            $('.errorHargabeli').html('');
            $('.errorHet').html('');
            $('.errorFrom_date').html('');
            $('.errorTo_date').html('');
            $('.errorPpn').html('');
            $('.errorHb_sppn').html('');
            $('.errorDiskon_pct').html('');
            $('.errorDiskon_nom').html('');
            $('.errorHb_sdiskon').html('');
            $('.errorMargin_pct').html('');
            $('.errorMargin_nom').html('');
            $('.errorHarga_jual').html('');


            //set selected data select2
            $('#item_cd').val(' ');
            $('#item_cd').trigger('change');


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
                url: "<?= site_url('ttarif/action'); ?>",
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

                        if (response.error.hargabeli) {
                            $('#hargabeli').addClass('is-invalid');
                            $('.errorTarif').html(response.error.hargabeli);
                        } else {
                            $('#hargabeli').removeClass('is-invalid');
                            $('.errorTarif').html('');
                        }
                        if (response.error.het) {
                            $('#het').addClass('is-invalid');
                            $('.errorTarif_asr').html(response.error.het);
                        } else {
                            $('#het').removeClass('is-invalid');
                            $('.errorTarif_asr').html('');
                        }
                        if (response.error.from_date) {
                            $('#from_date').addClass('is-invalid');
                            $('.errorFrom_date').html(response.error.from_date);
                        } else {
                            $('#from_date').removeClass('is-invalid');
                            $('.errorFrom_date').html('');
                        }
                        if (response.error.from_date) {
                            $('#to_date').addClass('is-invalid');
                            $('.errorTo_date').html(response.error.to_date);
                        } else {
                            $('#to_date').removeClass('is-invalid');
                            $('.errorTo_date').html('');
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
                        $('#item_cd').removeClass('is-invalid');
                        $('#hargabeli').removeClass('is-invalid');
                        $('#het').removeClass('is-invalid');
                        $('#from_date').removeClass('is-invalid');
                        $('#to_date').removeClass('is-invalid');
                        $('#ppn').removeClass('is-invalid');
                        $('#hb_sppn').removeClass('is-invalid');
                        $('#diskon_pct').removeClass('is-invalid');
                        $('#diskon_nom').removeClass('is-invalid');
                        $('#hb_sdiskon').removeClass('is-invalid');
                        $('#margin_pct').removeClass('is-invalid');
                        $('#margin_nom').removeClass('is-invalid');
                        $('#harga_jual').removeClass('is-invalid');

                        $('.errorItem_cd').html('');
                        $('.errorHargabeli').html('');
                        $('.errorHet').html('');
                        $('.errorFrom_date').html('');
                        $('.errorTo_date').html('');
                        $('.errorPpn').html('');
                        $('.errorHb_sppn').html('');
                        $('.errorDiskon_pct').html('');
                        $('.errorDiskon_nom').html('');
                        $('.errorHb_sdiskon').html('');
                        $('.errorMargin_pct').html('');
                        $('.errorMargin_nom').html('');
                        $('.errorHarga_jual').html('');

                        ttarif();
                        $('#modalform').modal('hide');
                    }
                },
            })
        });

        $(document).on('click', '.view', function() {
            var item_cd = $(this).data('item_cd');

            $.ajax({
                url: "<?= site_url('ttarif/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    item_cd: item_cd
                },
                dataType: "JSON",
                success: function(response) {
                    //set input
                    $('#item_cd').attr('disabled', '');
                    $('#item_cd').attr('readonly', '');
                    $('#hargabeli').attr('disabled', '');
                    $('#het').attr('disabled', '');
                    $('#from_date').attr('disabled', '');
                    $('#to_date').attr('disabled', '');
                    $('#ppn').attr('disabled', '');
                    $('#hb_sppn').attr('disabled', '');
                    $('#diskon_pct').attr('disabled', '');
                    $('#diskon_nom').attr('disabled', '');
                    $('#hb_sdiskon').attr('disabled', '');
                    $('#margin_pct').attr('disabled', '');
                    $('#margin_nom').attr('disabled', '');
                    $('#harga_jual').attr('disabled', '');

                    $('#data_form')[0].reset();

                    //set data from response record
                    $('#item_cd').val(response.data.item_cd);
                    $('#hargabeli').val(response.data.hargabeli);
                    $('#het').val(response.data.het);
                    $('#from_date').val(response.data.from_date);
                    $('#to_date').val(response.data.to_date);
                    $('#ppn').val(response.data.ppn);
                    $('#hb_sppn').val(response.data.hb_sppn);
                    $('#diskon_pct').val(response.data.diskon_pct);
                    $('#diskon_nom').val(response.data.diskon_nom);
                    $('#hb_sdiskon').val(response.data.hb_sdiskon);
                    $('#margin_pct').val(response.data.margin_pct);
                    $('#margin_nom').val(response.data.margin_nom);
                    $('#harga_jual').val(response.data.harga_jual);

                    //set error validation
                    $('#item_cd').removeClass('is-invalid');
                    $('#hargabeli').removeClass('is-invalid');
                    $('#het').removeClass('is-invalid');
                    $('#from_date').removeClass('is-invalid');
                    $('#to_date').removeClass('is-invalid');
                    $('#ppn').removeClass('is-invalid');
                    $('#hb_sppn').removeClass('is-invalid');
                    $('#diskon_pct').removeClass('is-invalid');
                    $('#diskon_nom').removeClass('is-invalid');
                    $('#hb_sdiskon').removeClass('is-invalid');
                    $('#margin_pct').removeClass('is-invalid');
                    $('#margin_nom').removeClass('is-invalid');
                    $('#harga_jual').removeClass('is-invalid');

                    $('.errorItem_cd').html('');
                    $('.errorHargabeli').html('');
                    $('.errorHet').html('');
                    $('.errorFrom_date').html('');
                    $('.errorTo_date').html('');
                    $('.errorPpn').html('');
                    $('.errorHb_sppn').html('');
                    $('.errorDiskon_pct').html('');
                    $('.errorDiskon_nom').html('');
                    $('.errorHb_sdiskon').html('');
                    $('.errorMargin_pct').html('');
                    $('.errorMargin_nom').html('');
                    $('.errorHarga_jual').html('');

                    //set selected data select2
                    $('#item_cd').val(response.data.item_cd);
                    $('#item_cd').trigger('change');

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
            var item_cd = $(this).data('item_cd');

            $.ajax({
                url: "<?= site_url('ttarif/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    item_cd: item_cd
                },
                dataType: "JSON",
                success: function(response) {
                    //set input
                    $('#item_cd').removeAttr('disabled');
                    $('#hargabeli').removeAttr('disabled');
                    $('#het').removeAttr('disabled');
                    $('#from_date').removeAttr('disabled');
                    $('#to_date').removeAttr('disabled');
                    $('#ppn').removeAttr('disabled');
                    $('#hb_sppn').removeAttr('disabled');
                    $('#diskon_pct').removeAttr('disabled');
                    $('#diskon_nom').removeAttr('disabled');
                    $('#hb_sdiskon').removeAttr('disabled');
                    $('#margin_pct').removeAttr('disabled');
                    $('#margin_nom').removeAttr('disabled');
                    $('#harga_jual').removeAttr('disabled');

                    //set input readonly
                    $('#item_cd').attr('readonly', '');
                    // $('#het').attr('readonly', '');

                    $('#data_form')[0].reset();

                    //set datepicker input value
                    $('#from_date').datepicker('update', response.data.from_date);
                    $('#to_date').datepicker('update', response.data.to_date);

                    //set data from response record
                    $('#item_cd').val(response.data.item_cd);
                    $('#hargabeli').val(response.data.hargabeli);
                    $('#het').val(response.data.het);
                    $('#from_date').val(response.data.from_date);
                    $('#to_date').val(response.data.to_date);
                    $('#ppn').val(response.data.ppn);
                    $('#hb_sppn').val(response.data.hb_sppn);
                    $('#diskon_pct').val(response.data.diskon_pct);
                    $('#diskon_nom').val(response.data.diskon_nom);
                    $('#hb_sdiskon').val(response.data.hb_sdiskon);
                    $('#margin_pct').val(response.data.margin_pct);
                    $('#margin_nom').val(response.data.margin_nom);
                    $('#harga_jual').val(response.data.harga_jual);


                    //set error validation
                    $('#item_cd').removeClass('is-invalid');
                    $('#hargabeli').removeClass('is-invalid');
                    $('#het').removeClass('is-invalid');
                    $('#from_date').removeClass('is-invalid');
                    $('#to_date').removeClass('is-invalid');
                    $('#ppn').removeClass('is-invalid');
                    $('#hb_sppn').removeClass('is-invalid');
                    $('#diskon_pct').removeClass('is-invalid');
                    $('#diskon_nom').removeClass('is-invalid');
                    $('#hb_sdiskon').removeClass('is-invalid');
                    $('#margin_pct').removeClass('is-invalid');
                    $('#margin_nom').removeClass('is-invalid');
                    $('#harga_jual').removeClass('is-invalid');

                    $('.errorItem_cd').html('');
                    $('.errorTarif').html('');
                    $('.errorTarif_asr').html('');
                    $('.errorFrom_date').html('');
                    $('.errorTo_date').html('');
                    $('.errorPpn').html('');
                    $('.errorHb_sppn').html('');
                    $('.errorDiskon_pct').html('');
                    $('.errorDiskon_nom').html('');
                    $('.errorHb_sdiskon').html('');
                    $('.errorMargin_pct').html('');
                    $('.errorMargin_nom').html('');
                    $('.errorHarga_jual').html('');

                    //set selected data select2
                    $('#item_cd').val(response.data.item_cd);
                    $('#item_cd').trigger('change');


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
            var item_cd = $(this).data('item_cd');
            if (confirm("Are you sure you want to remove it?")) {
                $.ajax({
                    url: "<?= site_url('ttarif/delete'); ?>",
                    method: "POST",
                    data: {
                        item_cd: item_cd
                    },
                    dataType: "JSON",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                            //footer: '<a href="">Why do I have this issue?</a>'
                        });
                        ttarif();
                        setTimeout(function() {
                            $('#message').html('');
                        }, 5000);
                    }
                })
            }
        });

        $('#hargabeli, #diskon_pct, #margin_pct, #ppn, #ppn_beli_pct, #het').on('input', function() {
            var hargabeli = parseFloat($('#hargabeli').val().replace(/\.(?=\d{3}\.)/g, "")) || 0;
            var diskon_pct = parseFloat($('#diskon_pct').val().replace(/\.(?=\d{3}\.)/g, "")) || 0;
            var margin_pct = parseFloat($('#margin_pct').val().replace(/\.(?=\d{3}\.)/g, "")) || 0;
            var ppn = parseFloat($('#ppn').val().replace(/\.(?=\d{3}\.)/g, "")) || 0;
            var ppn_beli_pct = parseFloat($('#ppn_beli_pct').val().replace(/\.(?=\d{3}\.)/g, "")) || 0;
            var het = parseFloat($('#het').val().replace(/\.(?=\d{3}\.)/g, "")) || 0;

            // replace(/\./g, "")

            var diskon_nom = hargabeli * diskon_pct / 100;
            $('#diskon_nom').val(addCommas(diskon_nom));
            var margin_nom = hargabeli * margin_pct / 100;
            $('#margin_nom').val(addCommas(margin_nom));

            var ppn_nom = hargabeli * ppn / 100;
            $('#ppn_nom').val(addCommas(ppn_nom));

            if ($('input#checkInclude').is(':checked')) {
                var hb_sdiskon = hargabeli - (hargabeli * diskon_pct / 100);
                $('#hb_sdiskon').val(addCommas(hb_sdiskon));
            } else {
                var hb_sdiskon = hargabeli;
                $('#hb_sdiskon').val(addCommas(hb_sdiskon));
            }

            var harga_jual = hb_sdiskon + margin_nom;
            $('#harga_jual').val(addCommas(harga_jual + 0.00));

            var ppn_beli_nom = harga_jual * ppn_beli_pct / 100;
            $('#ppn_beli_nom').val(addCommas(ppn_beli_nom));
            var harga_jual_akhir = harga_jual + ppn_beli_nom;
            $('#harga_jual_akhir').val(addCommas(harga_jual_akhir));

            if (harga_jual_akhir.replace(/\.(?=\d{3}\.)/g, "") > het.replace(/\.(?=\d{3}\.)/g, "")) {
                alert('Harga Jual, Melebihi HET!');
                alert(harga_jual_akhir.replace(/\.(?=\d{3}\.)/g, ""));
            }

            $('#hargabeli').val(addCommas(hargabeli));
            $('#het').val(addCommas(het));
            $('#ppn').val(addCommas(ppn));
            $('#diskon_pct').val(addCommas(diskon_pct));
            $('#margin_pct').val(addCommas(margin_pct));
            $('#ppn_beli_pct').val(addCommas(ppn_beli_pct));
            $('#ppn_beli_nom').val(addCommas(ppn_beli_nom));
            // $('#harga_jual').val(formatNumber(harga_jual));
            // $('#harga_jual').val(formatNumber(harga_jual));
            // if ($('#diskon').val().replace(/\./g, "") >= 0 && $('#diskon').val().replace(/\./g, "") <= 100) {
            //     $('#harga_order').val(($('#bagihasil').val().replace(/\./g, "") - diskon) + (total_normal * 20 / 100));
            //     $('#bagihasil_setelah').val(($('#bagihasil').val().replace(/\./g, "") - diskon));
            //     $('#pengurang').val(diskon);
            // } else {
            //     $('#harga_order').val(($('#bagihasil').val().replace(/\./g, "") - ($('#bagihasil').val().replace(/\./g, "") * diskon / 100)) + (total_normal * 20 / 100));
            //     $('#bagihasil_setelah').val(($('#bagihasil').val().replace(/\./g, "") - ($('#bagihasil').val().replace(/\./g, "") * diskon / 100)));
            //     $('#pengurang').val(($('#bagihasil').val().replace(/\./g, "") * diskon / 100));
            // }

            // if (diskon > $('#bagihasil').val().replace(/\./g, "")) {
            //     alert('Reduksi Melebihi Batas!');
            //     $('#diskon').val(0);
            //     // $('#harga_order').val($('#harga_normal').val().replace(/\./g, ""));
            //     $('#bagihasil_setelah').val($('#bagihasil').val());
            //     $('#harga_order').val($('#harga_normal').val());
            // }

            // if (diskon < 0) {
            //     alert('Nilai Reduksi Tidak Boleh Minus!');
            //     $('#diskon').val(0);
            //     // $('#harga_order').val($('#harga_normal').val().replace(/\./g, ""));
            //     $('#bagihasil_setelah').val($('#bagihasil').val());
            //     $('#harga_order').val($('#harga_normal').val());
            // }

        });

        // function formatNumber(num) {
        //     return num.toLocaleString('id-ID', {
        //         minimumFractionDigits: 2,
        //         maximumFractionDigits: 2
        //     });
        // }

        // function formatNumber(num) {
        //     let parts = num.toString().split('.');
        //     parts[1] = parts[1] ? parts[1].padEnd(2, '0') : '00';
        //     return parts.join('.');
        // }

        $(document).on('click', '#checkInclude', function() {
            var hargabeli = parseFloat($('#hargabeli').val().replace(/\./g, "")) || 0;
            var diskon_pct = parseFloat($('#diskon_pct').val().replace(/\./g, "")) || 0;
            var margin_pct = parseFloat($('#margin_pct').val().replace(/\./g, "")) || 0;
            var ppn = parseFloat($('#ppn').val().replace(/\./g, "")) || 0;
            var ppn_beli_pct = parseFloat($('#ppn_beli_pct').val().replace(/\./g, "")) || 0;
            var het = parseFloat($('#het').val().replace(/\./g, "")) || 0;

            var diskon_nom = hargabeli * diskon_pct / 100;
            $('#diskon_nom').val(addCommas(diskon_nom));
            var margin_nom = hargabeli * margin_pct / 100;
            $('#margin_nom').val(addCommas(margin_nom));

            var ppn_nom = hargabeli * ppn / 100;
            $('#ppn_nom').val(addCommas(ppn_nom));

            if ($('input#checkInclude').is(':checked')) {
                var hb_sdiskon = hargabeli - (hargabeli * diskon_pct / 100);
                $('#hb_sdiskon').val(addCommas(hb_sdiskon));
            } else {
                var hb_sdiskon = hargabeli;
                $('#hb_sdiskon').val(addCommas(hb_sdiskon));
            }

            var harga_jual = hb_sdiskon + margin_nom;
            $('#harga_jual').val(addCommas(harga_jual));

            var ppn_beli_nom = harga_jual * ppn_beli_pct / 100;
            $('#ppn_beli_nom').val(addCommas(ppn_beli_nom));
            var harga_jual_akhir = harga_jual + ppn_beli_nom;
            $('#harga_jual_akhir').val(addCommas(harga_jual_akhir));

            if (harga_jual_akhir > het) {
                alert('Harga Jual, Melebihi HET!');
            }
        });

        // $("#diskon_pct, #margin_pct, #ppn, #ppn_beli_pct, #ppn_jual_pct, #het, #harga_beli").blur(function() {
        //     $("#harga_beli").val(addCommas($("#harga_beli").val()));
        //     $("#het").val(addCommas($("#het").val()));
        //     $("#diskon_nom").val(addCommas($("#diskon_nom").val()));
        //     $('#margin_nom').val(addCommas($('#margin_nom').val()));
        //     $('#ppn_nom').val(addCommas($('#ppn_nom').val()));
        //     $('#hb_sdiskon').val(addCommas($('#hb_sdiskon').val()));
        //     $('#harga_jual').val(addCommas($('#harga_jual').val()));
        //     $('#ppn_beli_nom').val(addCommas($('#ppn_beli_nom').val()));
        //     $('#harga_jual_akhir').val(addCommas($('#harga_jual_akhir').val()));

        // });

        // $('#het, #hargabeli').on('blur', function() {
        //     var hargabeli = parseFloat($('#hargabeli').val().replace(/\./g, "")) || 0;
        //     var het = parseFloat($('#het').val().replace(/\./g, "")) || 0;

        //     $("#hargabeli").val(addCommas(hargabeli));
        //     $("#het").val(addCommas(het));
        // });

        function addCommas(nilai) {
            var bilangan = nilai || 0; // Default to 0 if nilai is empty
            var parts = bilangan.toString().split('.');
            var reverse = parts[0].split('').reverse().join('');
            var ribuan = reverse.match(/\d{1,3}/g).join('.').split('').reverse().join('');
            if (parts[1]) {
                ribuan += ',' + parts[1];
            }
            return ribuan;
        }

        // function addCommas(nilai) {
        //     var bilangan = nilai || 0; // Default to 0 if nilai is empty
        //     // Remove any commas or dots from the input
        //     bilangan = bilangan.toString().replace(/[\.,]/g, '');
        //     // Convert the cleaned string back to a number
        //     var num = parseFloat(bilangan) / 100;
        //     // Format the number with commas and two decimal places
        //     return num.toLocaleString('id-ID', {
        //         minimumFractionDigits: 2,
        //         maximumFractionDigits: 2
        //     });
        // }

    });
</script>



<?= $this->endSection('script'); ?>