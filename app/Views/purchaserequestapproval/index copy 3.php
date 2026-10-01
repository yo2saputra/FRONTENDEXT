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
    .table-wrapper {
        overflow-x: hidden;
        /* pastikan scroll horizontal tidak muncul */
    }

    .text-truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

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
<style>
    thead {
        position: sticky;
        top: 0;
        /* background-color: #b7b2b2; */
        z-index: 0;
    }

    thead.fix {
        background-color: #b7b2b2;

    }

    .table-container {
        width: 100%;
        height: 300px;
        overflow-y: auto;
        overflow-x: auto;
    }
</style>
<?= $this->endSection('style'); ?>

<?= $this->section('content'); ?>

<?php
$session = session();
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <br>
    <!-- Content Header (Page header) -->
    <!-- <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Field Value</li>
                    </ol>
                </div>
            </div>
        </div>
    </section> -->
    <!-- /.container-fluid -->

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
                                <label for="branch" class="col-sm-2 col-form-label">PRID</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-sm" id="prid" name="prid" style="direction: rtl;" disabled>
                                    <span class="error invalid-feedback errorBranch">
                                    </span>
                                </div>
                                <input type="hidden" id="branch" name="brach" value="BR001">
                                <div class="col-sm-2"></div>
                                <label for="user" class="col-sm-2 col-form-label">PETUGAS</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-sm" id="user" name="user" value="<?= $session->get('usr_id'); ?>" style="direction: rtl;" disabled>
                                    <span class="error invalid-feedback errorUser">
                                    </span>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="tglStart" class="col-sm-2 col-form-label">START</label>
                                <div class="col-sm-3">
                                    <div class="input-group date tglStart" data-date-format="mm/dd/yyyy">
                                        <input type="text" class="form-control form-control-sm datepicker" placeholder="dd-mm-yyyy" id="tglStart" name="tglStart">
                                        <div class="input-group-append" data-target="#tglStart" data-toggle="tglStart">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                    <span class="error invalid-feedback errorTgl_praktek1">
                                    </span>
                                </div>
                                <div class="col-sm-2"></div>
                                <label for="tglEnd" class="col-sm-2 col-form-label">END</label>
                                <div class="col-sm-3">
                                    <div class="input-group date tglEnd" data-date-format="mm/dd/yyyy">
                                        <input type="text" class="form-control form-control-sm datepicker" placeholder="dd-mm-yyyy" id="tglEnd" name="tglEnd">
                                        <div class="input-group-append" data-target="#tglEnd" data-toggle="tglEnd">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                    <span class="error invalid-feedback errorTgl_praktek2">
                                    </span>
                                </div>
                            </div>

                            <div class="mb-1 row">
                                <!-- <div class="col-sm-7"></div>
                                <div class="col-sm-5 text-right">
                                    <strong style="font-size: 2rem;">Rp <span id="grandTotal">0.00</span></strong>
                                </div> -->
                            </div>

                            <div class="mb-3 row">
                                <!-- <div class="col-sm-7"><button type="button" class="btn btn-info btn-flat" id="" onclick="openDetailModal()"><i class='fas fa-barcode'></i></button></div> -->
                                <div class="col-sm-5"></div>
                                <div class="col-sm-2"></div>
                                <div class="col-sm-5">
                                    <!-- <label for="item_cd" class="col-sm-2 col-form-label">NO. REGISTRASI</label> -->
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" id="scan_input" style="direction: ltr;" placeholder="BARCODE SCANNER">
                                        <span class="input-group-append">
                                            <div class="btn btn-info input-group-text" id="item"><i class="fa fa-barcode"></i></div>
                                            <!-- <button type="button" class="btn btn-info btn-flat" id="item"><i class='fas fa-barcode'></i></button> -->
                                        </span>
                                    </div>
                                </div>

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

                                <!-- <div class="card">
                                    <div class="card-body" style="max-height: 200px; overflow-y: auto;">
                                        <div class="table-container">
                                            <span id="live_fetchDataItem"></span>
                                        </div>
                                    </div>
                                </div> -->


                                <div class="card">
                                    <div class="card-body">
                                        <div id="live_fetchDataItem"></div>
                                    </div>
                                </div>




                                <!-- <div class="table-container">
                                    <table class="table tabledetail">
                                        <thead class="fix">
                                            <tr>
                                                <th scope="col">
                                                    <input type="checkbox" id="selectAllCheckbox" onclick="selectAllItems()">
                                                </th>
                                                <th scope="col" class="">Code 1</th>
                                                <th scope="col">Item 1</th>
                                                <th scope="col" class="text-right">Jumlah 1</th>
                                                <th scope="col" class="text-right">Tarif 1</th>
                                                <th scope="col">Potongan 1</th>
                                                <th scope="col">Pajak 1</th>
                                                <th scope="col" class="text-right">Total 1</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div> -->

                                <!-- Daftar item transaksi -->
                                <div class="table-container">
                                    <table class="table tabledetail">
                                        <thead class="fix">
                                            <tr>
                                                <th>Kode</th>
                                                <th>Produk</th>
                                                <th>Satuan</th>
                                                <th>Distributor</th>
                                                <th>Principal</th>
                                                <th>Qty</th>
                                                <th>Qty Approved</th>
                                                <th>Harga</th>
                                                <th>HNA</th>
                                                <th>Bonus</th>
                                                <th>Diskon</th>
                                                <th>Pajak</th>
                                                <th>Tipe</th>
                                                <th>Diskon Off</th>
                                                <th>Subtotal</th>
                                                <th>Approved</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="detailBody"></tbody>
                                    </table>
                                </div>

                            </div>
                            <hr>
                            <div class="mt-3">
                                <!-- <button class="btn btn-primary mb-3" onclick="addItem()" style="display: none;">ADD</button>
                                <button class="btn btn-warning mb-3 billing">LIST BILLING</button>
                                <button class="btn btn-info mb-3" onclick="postData()">DEPOSIT</button>
                                <button class="btn btn-danger mb-3" onclick="deleteSelectedItems()">DELETE</button>
                                <button class="btn btn-success mb-3" onclick="postData()">SAVE</button> -->
                                <button id="saveBtn" class="btn btn-success mb-3" onclick="saveTransaction()" disabled>SAVE</button>
                            </div>


                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="detailModal" tabindex="" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLabel"></h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div id="data_form" autocomplete="off">
                                        <?= csrf_field(); ?>
                                        <div class="modal-body">
                                            <div class="mb-3 row">
                                                <input type="hidden" id="detailIndex" name="detailIndex">
                                                <?= $cb_obat ?>
                                                <label for="detailProduk" class="col-sm-2 col-form-label">Nama Produk</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="detailProduk" name="detailProduk">
                                                    <span class="error invalid-feedback errorDiagnosa">
                                                    </span>
                                                </div>
                                                <input type="hidden" id="detailProdukHD" name="detailProdukHD">
                                            </div>
                                            <div class="mb-3 row">
                                                <?= $cb_distributor ?>
                                                <input type="hidden" id="detailDistributorHD" name="detailDistributorHD">
                                                <?= $cb_principal ?>
                                                <input type="hidden" id="detailPrincipalHD" name="detailPrincipalHD">
                                            </div>

                                            <div class="mb-3 row">
                                                <label for="detailQty" class="col-sm-2 col-form-label">Qty</label>
                                                <div class="col-sm-2">
                                                    <input type="number" class="form-control form-control-sm" id="detailQty">
                                                </div>
                                                <?= $cb_satuan ?>
                                                <input type="hidden" id="detailSatuanHD" name="detailSatuanHD">
                                                <label for="detailHNA" class="col-sm-2 col-form-label">HNA</label>
                                                <div class="col-sm-2">
                                                    <input type="number" class="form-control form-control-sm" id="detailHNA">
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="detailHarga" class="col-sm-2 col-form-label">Harga</label>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control form-control-sm" id="detailHarga" readonly>
                                                </div>
                                                <label for="detailHargaAkhir" class="col-sm-2 col-form-label">Harga Pembelian Terakhir</label>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control form-control-sm" id="detailHargaAkhir" readonly>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="detailBonus" class="col-sm-2 col-form-label">Bonus</label>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control form-control-sm" id="detailBonus">
                                                </div>
                                                <label for="detailBonusAkhir" class="col-sm-2 col-form-label">Bonus Pembelian Terkhir</label>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control form-control-sm" id="detailBonusAkhir" readonly>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="detailDiskon" class="col-sm-2 col-form-label">Diskon</label>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control form-control-sm" id="detailDiskon">
                                                </div>
                                                <label for="detailDiskonAkhir" class="col-sm-2 col-form-label">Diskon On Terakhir</label>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control form-control-sm" id="detailDiskonAkhir" readonly>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <?= $cb_pajak ?>
                                                <?= $cb_tipe ?>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="detailDiskonOff" class="col-sm-2 col-form-label">Diskon Off</label>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control form-control-sm" id="detailDiskonOff">
                                                </div>
                                                <label for="detailSubtotal" class="col-sm-2 col-form-label">Subtotal</label>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control form-control-sm" id="detailSubtotal" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" id="hidden_id" name="hidden_id" />
                                            <input type="hidden" id="action" name="action" value="Add" />
                                            <button class="btn btn-sm btn-primary" onclick="saveDetail2()">Simpan Item</button>
                                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal List Registrasi-->
                        <div class="modal fade" id="modalformregistrasi" tabindex="" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLabel">List Registrasi</h4>
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
                                        <h4 class="modal-title" id="exampleModalLabel">List Item</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- <span id="live_fetchDataItem"></span> -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal List Billing -->
                        <div class="modal fade" id="modalformbilling" tabindex="" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLabel"></h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <span id="live_fetchDataBilling"></span>
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
        //Set DatePicker to now
        $('#tglStart').datepicker("setDate", new Date());
        $('#tglEnd').datepicker("setDate", new Date());

        localStorage.removeItem('items');
        displayItems();

        $(document).on('click', '#add_record', function() {
            //set input
            $('#warehouse_cd').attr('disabled', '');
            // $('#warehouse_cd').removeAttr('disabled');
            $('#warehouse_nm').removeAttr('disabled');
            $('#lokasi').removeAttr('disabled');
            $('#warehouse_sta_id').removeAttr('disabled');
            $('#warehouse_cd').removeAttr('readonly');
            $('#warehouse_sta_id').removeAttr('checked');

            $('#data_form')[0].reset();

            //set error validation
            $('#warehouse_cd').removeClass('is-invalid');
            $('#warehouse_nm').removeClass('is-invalid');
            $('#lokasi').removeClass('is-invalid');
            $('#warehouse_sta_id').removeClass('is-invalid');
            $('.errorDiagnosa_cd').html('');
            $('.errorDiagnosa').html('');
            $('.errorKeterangan').html('');
            $('.errorDiag_sta_id').html('');

            //set selected data select2
            $('#warehouse_sta_id').val(' ');
            $('#warehouse_sta_id').trigger('change');

            //set modal & form
            $('.modal-title').text('Tambah Data');
            $('#action').val('Add');
            $('#submit_button').show();
            $('#submit_button').val('Simpan');
            $('#submit_button').html('Simpan');
            $('#modalform').modal('show');

        });
    });

    // function addItem() {
    //     var itemInput = $('#itemInput');
    //     var quantityInput = $('#quantityInput');
    //     var rateInput = $('#rateInput');
    //     var discountInput = $('#discountInput');
    //     var taxInput = $('#taxInput');

    //     var itemList = JSON.parse(localStorage.getItem('items')) || [];

    //     if (itemInput.val().trim() !== '') {
    //         var total = calculateTotal(quantityInput.val(), rateInput.val(), discountInput.val(), taxInput.val());
    //         itemList.push({
    //             item: itemInput.val(),
    //             quantity: quantityInput.val(),
    //             rate: rateInput.val(),
    //             discount: discountInput.val(),
    //             tax: taxInput.val(),
    //             flag: 0,
    //             total: total
    //         });
    //         localStorage.setItem('items', JSON.stringify(itemList));
    //         clearInputFields();
    //         displayItems();
    //     }
    // }

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
                flag: 0,
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
        return Math.round(taxedAmount.toFixed(2));
    }

    function displayItems() {
        var itemList = JSON.parse(localStorage.getItem('items')) || [];
        var itemTableBody = $('.tabledetail tbody');
        itemTableBody.empty();

        itemList.forEach(function(item, index) {
            var row = $('<tr>');
            // row.append('<td><input type="checkbox"class="item-checkbox"></td>');
            row.append("<td><input type='checkbox'class='item-checkbox' " + (item.flag == 1 ? 'disabled' : '') + "></td>");
            row.append('<td>' + item.item_cd + '</td>');
            row.append('<td>' + item.item + '</td>');
            // row.append('<td class="text-right"><input type="text" min="1" maxlength="3" size="3" class="quantity-input" value="' + Math.trunc(item.quantity) + '"></td>');
            row.append("<td class='text-right'><input type='text' min='1' maxlength='3' size='3' class='quantity-input' value='" + Math.trunc(item.quantity) + "' " + (item.flag == 1 ? 'disabled' : '') + "></td>");
            row.append('<td class="text-right">' + formatNumber(item.rate) + '</td>');
            row.append('<td>' + Math.trunc(item.discount) + '%</td>');
            row.append('<td>' + Math.trunc(item.tax) + '%</td>');
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

        var newTotal = Math.round(calculateTotal(quantity, rate, discount, tax));
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
                            const msg = JSON.parse(response) || [];
                            alert(msg.no_kwitansi.substr(0, 12));

                            const winPdf = window.open("<?= base_url('/kasir/print/') ?>" + msg.no_kwitansi.substr(0, 12));
                            winPdf.print();

                            // console.log('Data successfully sent to the server:', response.no_kwitansi);
                            localStorage.removeItem('items');
                            // Tambahkan logika atau tindakan lain yang diperlukan setelah sukses
                            displayItems();
                            removeNoRegistrasi();


                        },
                        error: function(error) {
                            // console.error('Error sending data to the server:', error);
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
                $("#no_kwitansi").val('');
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
        var no_kwitansi = $(this).data("no_kwitansi");
        $.ajax({
            url: "<?= site_url('kasir/setnoregistrasi'); ?>",
            method: "GET",
            data: {
                no_registrasi: no_registrasi,
                no_kwitansi: no_kwitansi,
            },
            dataType: "JSON",
            beforeSend: function() {
                $('#item').prop('disabled', true);
                $('#item').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function() {
                $('#item').prop('disabled', false);
                $('#item').html('<i class="fas fa-barcode"></i>');
            },
            success: function(response) {
                $("#no_registrasi").val(no_registrasi);
                $("#no_kwitansi").val(no_kwitansi);
                $('#modalformregistrasi').modal('hide');

                // Mendapatkan data dari server menggunakan Ajax
                $.ajax({
                    method: "POST",
                    url: "<?= site_url('/kasir/fetchallitems'); ?>",
                    dataType: "json",
                    data: {
                        no_registrasi: no_registrasi
                    },
                    success: function(response) {
                        // Simpan data JSON ke localStorage
                        localStorage.setItem("items", JSON.stringify(response));
                        displayItems();
                        fetchDataListRegistrasi();
                        // console.log("Data berhasil disimpan di localStorage.");
                    }
                    // ,
                    // error: function(xhr, status, error) {
                    //     console.error("Terjadi kesalahan saat mengambil data:", error);
                    // }
                });




            }
        })

    });

    // $(document).on('click', '#item', function() {
    //     fetchDataListItem();
    //     $('#modalformitem').modal('show');
    // });

    //insert barang ke list pembelian detail pada saat baris data barang di double klik
    $(document).on("dblclick", "tr#addRowItem", function() {
        var item_cd = $(this).data("id");

        $.ajax({
            url: "<?= site_url('kasir/fetchSingleData'); ?>",
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

    function formatDate(dateString) {
        // Buat objek Date dari string input
        let date = new Date(dateString);

        // Dapatkan tahun, bulan, dan tanggal
        let year = date.getFullYear();
        let month = String(date.getMonth() + 1).padStart(2, '0'); // Tambahkan 1 karena bulan dimulai dari 0
        let day = String(date.getDate()).padStart(2, '0');

        // Format ke bentuk yang diinginkan
        return `${day}-${month}-${year}`;
    }


    //insert barang ke list pembelian detail pada saat kolom item_cd di klik
    $(document).on("click", ".addItem", function() {
        var prid = $(this).data("id");

        $.ajax({
            url: "<?= site_url('purchaserequestapproval/fetchSingleData'); ?>",
            method: "GET",
            data: {
                prid: prid
            },
            dataType: "JSON",
            success: function(response) {

                // var itemList = JSON.parse(response) || [];

                // if (item_cd.trim() !== '') {
                //     var total = calculateTotal(1, response.data.unitprice, 0, (response.data.isvat === 1 ? 11 : 0));
                //     itemList.push({
                //         item_cd: response.data.item_cd,
                //         item: response.data.item_nm,
                //         quantity: 1,
                //         rate: response.data.unitprice,
                //         discount: 0,
                //         tax: (response.data.isvat === 1 ? 11 : 0),
                //         total: total
                //     });
                //     localStorage.setItem('items', JSON.stringify(itemList));
                //     // clearInputFields();
                //     displayItems();
                // }

                // Masukkan data tanggal ke input
                $('#tglStart').val(formatDate(response.tglStart));
                $('#tglEnd').val(formatDate(response.tglEnd));
                $('#prid').val(response.prid);


                // Masukkan data transaksi ke dalam daftar
                details = response.details || [];
                renderDetail2();



                $('#modalformitem').modal('hide');

            }
        })
    });

    $(document).on('click', '.view', function() {
        var item_cd = $(this).data('item_cd');

        $.ajax({
            url: "<?= site_url('kasir/fetchSingleData'); ?>",
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
            var prid = $('#scan_input').val();

            $.ajax({
                url: "<?= site_url('purchaserequestapproval/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    prid: prid
                },
                dataType: "JSON",
                success: function(response) {

                    alert(response.tglStart);
                    // Masukkan data tanggal ke input
                    $('#tglStart').val(response.tglStart);
                    $('#tglEnd').val(response.tglEnd);
                    $('#prid').val(response.prid);

                    // Masukkan data transaksi ke dalam daftar
                    details = response.details || [];
                    renderDetail2();
                    $("#scan_input").val('');
                },
                error: function() {
                    alert('Kode Tidak Terdaftar!');
                    $("#scan_input").focus();
                }
            })
        }
    });

    function fetchDataListBilling() {
        $.ajax({
            method: "GET",
            url: "<?= site_url('kasir/listbilling'); ?>",
            success: function(data) {
                $('#live_fetchDataBilling').html(data);
            }
        });
    }

    $(document).on('click', '.billing', function() {
        fetchDataListBilling();
        $('#modalformbilling').modal('show');
    });

    $(document).on('click', '.print', function() {
        var no_kwitansi = $(this).data('no_kwitansi');
        const winPdf = window.open("<?= base_url('/kasir/print/') ?>" + no_kwitansi);
        winPdf.print();
    });

    $(document).on('click', '.edit', function() {
        var no_kwitansi = $(this).data('no_kwitansi');
        window.open("<?= base_url('/kasir/edit/') ?>" + no_kwitansi);
    });
</script>

<script>
    $('#detailHNA,#detailHarga, #detailDiskon, #detailDiskonOff, #detailPajak').on('input', calculateSubtotal);

    // function calculateSubtotal() {

    //     const qty = parseFloat($('#detailQty').val()) || 0;
    //     const harga = parseFloat($('#detailHarga').val()) || 0;
    //     const diskon = parseFloat($('#detailDiskon').val()) || 0;
    //     const diskon_off = parseFloat($('#detailDiskonOff').val()) || 0;
    //     const pajak = parseFloat($('#detailPajak').val()) || 0;

    //     const subtotal = qty * harga - diskon + pajak - diskon_off;

    //     $('#detailSubtotal').val(subtotal.toFixed(2));
    // }

    function calculateSubtotal() {
        const hna = parseFloat($('#detailHNA').val()) || 0;
        const qty = parseFloat($('#detailQty').val()) || 0;
        // const harga = parseFloat($('#detailHarga').val()) || 0;
        const diskon = parseFloat($('#detailDiskon').val()) || 0;
        const diskon_off = parseFloat($('#detailDiskonOff').val()) || 0;
        const pajak = parseFloat($('#detailPajak').val()) || 0;

        const harga = hna - diskon;
        const subtotal = qty * harga - diskon_off;
        // const subtotal = qty * harga - diskon + pajak - diskon_off;

        $('#detailHarga').val(harga.toFixed(2)); // Menampilkan hasil dengan 2 desimal
        $('#detailSubtotal').val(subtotal.toFixed(2)); // Menampilkan hasil dengan 2 desimal
    }

    $('#detailSatuan').on('change', function() {
        var selectedText = $(this).find(':selected').text();
        $('#detailSatuanHD').val(selectedText);
    });

    $('#detailDistributor').on('change', function() {
        var selectedText = $(this).find(':selected').text();
        $('#detailDistributorHD').val(selectedText);
    });

    $('#detailPrincipal').on('change', function() {
        var selectedText = $(this).find(':selected').text();
        $('#detailPrincipalHD').val(selectedText);
    });

    $('#detailKode').on('change', function() {
        var selectedText = $(this).find(':selected').text();
        $('#detailProduk').val(selectedText);
    });

    $(document).on('click', '#add_item', function() {
        //fetchDataListRegistrasi();
        $('#modalitem').modal('show');

    });

    let details = [];

    /*
        function openDetailModal(index = null) {
            $('#detailModal').modal('show');
            if (index !== null) {
                const item = details[index];
                $('#detailIndex').val(index);
                Object.keys(item).forEach(key => {
                    $(`#detail${key.charAt(0).toUpperCase() + key.slice(1)}`).val(item[key]);
                });
            } else {
                $('#detailIndex').val('');
                $('.form-control').val('');
            }
        }
		*/

    function getDataFromAPI() {
        // fetch('https://example.com/api/transaksi') // Ganti dengan URL API Anda
        //     .then(response => response.json())
        //     .then(data => {
        //         console.log("Data dari API:", data);

        //         // Masukkan data tanggal ke input
        //         $('#tglStart').val(data.tglStart);
        //         $('#tglEnd').val(data.tglEnd);

        //         // Masukkan data transaksi ke dalam daftar
        //         details = data.details || [];
        //         renderDetail2();
        //     })
        //     .catch(error => {
        //         console.error("Error mengambil data:", error);
        //         alert("Gagal mengambil data dari API!");
        //     });

        $.ajax({
            url: 'https://example.com/api/transaksi', // Ganti dengan URL API Anda
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                console.log("Data dari API:", data);

                // Masukkan data tanggal ke input
                $('#tglStart').val(data.tglStart);
                $('#tglEnd').val(data.tglEnd);

                // Masukkan data transaksi ke dalam daftar
                details = data.details || [];
                renderDetail2();
            },
            error: function(xhr, status, error) {
                console.error("Error mengambil data:", error);
                alert("Gagal mengambil data dari API!");
            }
        });

    }

    function openDetailModal(index = null) {
        $('#detailModal').modal('show'); // Menampilkan modal

        if (index !== null) {
            const item = details[index];

            // Set nilai input satu per satu
            // $('#detailKode').val(item.kode);
            $('#detailProduk').val(item.produk);
            // $('#detailSatuan').val(item.satuan);
            // $('#detailDistributor').val(item.distributor);
            // $('#detailPrincipal').val(item.principal);
            $('#detailQty').val(item.qty);
            $('#detailHarga').val(item.harga);
            $('#detailHNA').val(item.hna);
            $('#detailBonus').val(item.bonus);
            $('#detailDiskon').val(item.diskon);
            // $('#detailPajak').val(item.pajak);
            // $('#detailTipe').val(item.tipe);
            $('#detailDiskonOff').val(item.diskon_off);
            $('#detailSubtotal').val(item.subtotal);

            $('#detailPajak').val(item.pajak).trigger('change');
            $('#detailKode').val(item.kode).trigger('change');
            $('#detailDistributor').val(item.distributor).trigger('change');
            $('#detailPrincipal').val(item.principal).trigger('change');
            $('#detailSatuan').val(item.satuan).trigger('change');
            $('#detailTipe').val(item.tipe).trigger('change');

            // Menyimpan indeks item yang sedang diedit
            $('#detailIndex').val(index);
        } else {
            // Reset form jika menambah item baru
            $('#detailIndex').val('');
            // $('#detailKode').val('');
            $('#detailProduk').val('');
            // $('#detailSatuan').val('');
            // $('#detailDistributor').val('');
            // $('#detailPrincipal').val('');
            $('#detailQty').val('');
            $('#detailHarga').val('');
            $('#detailHNA').val('');
            $('#detailBonus').val('');
            $('#detailDiskon').val('');
            // $('#detailPajak').val('');
            // $('#detailTipe').val('');
            $('#detailDiskonOff').val('');
            $('#detailSubtotal').val('');

            $('#detailPajak').val(' ').trigger('change');
            $('#detailKode').val(' ').trigger('change');
            $('#detailDistributor').val(' ').trigger('change');
            $('#detailPrincipal').val(' ').trigger('change');
            $('#detailSatuan').val(' ').trigger('change');
            $('#detailTipe').val(' ').trigger('change');

        }
    }

    function saveDetailx() {
        const index = $('#detailIndex').val();
        const item = {
            kode: $('#detailKode').val(),
            produk: $('#detailProduk').val(),
            satuan: $('#detailSatuan').val(),
            distributor: $('#detailDistributor').val(),
            principal: $('#detailPrincipal').val(),
            qty: $('#detailQty').val(),
            harga: $('#detailHarga').val(),
            hna: $('#detailHNA').val(),
            bonus: $('#detailBonus').val(),
            diskon: $('#detailDiskon').val(),
            pajak: $('#detailPajak').val(),
            tipe: $('#detailTipe').val(),
            diskon_off: $('#detailDiskonOff').val()
        };

        // item.subtotal = item.qty * item.hna - item.diskon + item.pajak - item.diskon_off;
        item.subtotal = item.qty * item.harga - item.diskon + item.pajak - item.diskon_off;

        if (index) {
            details[index] = item;
        } else {
            details.push(item);
        }

        $('#detailModal').modal('hide');
        renderDetail();
    }

    function saveDetail4() {
        const index = $('#detailIndex').val();
        const kode = $('#detailKode').val();
        const produk = $('#detailProduk').val();
        const satuan = $('#detailSatuan').val();
        const satuanhd = $('#detailSatuanHD').val();
        const distributor = $('#detailDistributor').val();
        const distributorhd = $('#detailDistributorHD').val();
        const principal = $('#detailPrincipal').val();
        const principalhd = $('#detailPrincipalHD').val();
        const qty = parseInt($('#detailQty').val()) || 0;
        const harga = parseFloat($('#detailHarga').val()) || 0;
        const hna = parseFloat($('#detailHNA').val()) || 0;
        const bonus = parseInt($('#detailBonus').val()) || 0;
        const diskon = parseFloat($('#detailDiskon').val()) || 0;
        const pajak = parseFloat($('#detailPajak').val()) || 0;
        const tipe = $('#detailTipe').val();
        const diskon_off = parseFloat($('#detailDiskontOff').val()) || 0;

        const subtotal = qty * harga - diskon + pajak - diskon_off;
        alert(kode);
        if (index === '') {
            details.push({
                index,
                kode,
                produk,
                satuan,
                satuanhd, // Data tambahan, tetap disimpan
                distributor,
                distributorhd, // Data tambahan, tetap disimpan
                principal,
                principalhd, // Data tambahan, tetap disimpan
                qty,
                harga,
                hna,
                bonus,
                diskon,
                pajak,
                tipe,
                diskon_off,
                subtotal
            });
        } else {
            details[parseInt(index)] = {
                index,
                kode,
                produk,
                satuan,
                satuanhd, // Data tambahan, tetap disimpan
                distributor,
                distributorhd, // Data tambahan, tetap disimpan
                principal,
                principalhd, // Data tambahan, tetap disimpan
                qty,
                harga,
                hna,
                bonus,
                diskon,
                pajak,
                tipe,
                diskon_off,
                subtotal
            };
        }

        $('#detailModal').modal('hide');
        renderDetail2(); // Memastikan tampilan diperbarui
    }

    function saveDetail2() {
        const index = $('#detailIndex').val();
        const prid = $('#prid').val();
        const kode = $('#detailKode').val();
        const produk = $('#detailProduk').val();
        const satuan = $('#detailSatuan').val();
        const satuanhd = $('#detailSatuanHD').val();
        const distributor = $('#detailDistributor').val();
        const distributorhd = $('#detailDistributorHD').val();
        const principal = $('#detailPrincipal').val();
        const principalhd = $('#detailPrincipalHD').val();
        const qty = parseInt($('#detailQty').val()) || 0;
        const harga = parseFloat($('#detailHarga').val()) || 0;
        const hna = parseFloat($('#detailHNA').val()) || 0;
        const bonus = parseInt($('#detailBonus').val()) || 0;
        const diskon = parseFloat($('#detailDiskon').val()) || 0;
        const pajak = parseFloat($('#detailPajak').val()) || 0;
        const tipe = $('#detailTipe').val();
        const diskon_off = parseFloat($('#detailDiskontOff').val()) || 0;

        // Field yang hanya disimpan, tidak tampil di list


        // const qty = quantity + bonus;
        const subtotal = (qty * harga) - diskon + pajak - diskon_off;



        if (index) { // Jika sedang edit, perbarui data lama
            details[parseInt(index)] = {
                index,
                prid,
                kode,
                produk,
                satuan,
                satuanhd, // Data tambahan, tetap disimpan
                distributor,
                distributorhd, // Data tambahan, tetap disimpan
                principal,
                principalhd, // Data tambahan, tetap disimpan
                qty,
                harga,
                hna,
                bonus,
                diskon,
                pajak,
                tipe,
                diskon_off,
                subtotal
            };
        } else { // Jika tidak ada index, tambahkan item baru
            details.push({
                index,
                prid,
                kode,
                produk,
                satuan,
                satuanhd, // Data tambahan, tetap disimpan
                distributor,
                distributorhd, // Data tambahan, tetap disimpan
                principal,
                principalhd, // Data tambahan, tetap disimpan
                qty,
                harga,
                hna,
                bonus,
                diskon,
                pajak,
                tipe,
                diskon_off,
                subtotal
            });
        }

        $('#detailModal').modal('hide');
        renderDetail2();
    }

    $(document).on('change', '.qtyapproved', function() {
        var index = $(this).data('index');
        // var qty = $('#qtyapproved' + index).val();

        // alert(details[index].qty);

        // const qty = parseInt($('#qtyapproved' + index).val()) || 0;
        // const harga = parseFloat(details[index].harga) || 0;
        // const diskon = parseFloat(details[index].diskon) || 0;
        // const pajak = parseFloat(details[index].pajak) || 0;
        // const diskon_off = parseFloat(details[index].diskon_off) || 0;



        // $('#qtyapproved' + index).val(qty);

        // Mengubah nilai qty dari elemen pertama
        // details[index].qty = 100;
        // details[index].subtotal = (qty * harga) - diskon + pajak - diskon_off;


        const hna = parseFloat(details[index].hna) || 0;
        const qty = parseFloat($('#qtyapproved' + index).val()) || 0;
        const diskon = parseFloat(details[index].diskon) || 0;
        const diskon_off = parseFloat(details[index].diskon_off) || 0;
        const pajak = parseFloat(details[index].pajak) || 0;

        details[index].qtyapproved = qty;


        const harga = hna - diskon;
        // const subtotal = qty * harga - diskon_off;


        // const subtotal = qty * harga - diskon + pajak - diskon_off;

        // $('#detailHarga').val(harga.toFixed(2)); // Menampilkan hasil dengan 2 desimal
        // $('#detailSubtotal').val(subtotal.toFixed(2)); // Menampilkan hasil dengan 2 desimal

        details[index].harga = harga;
        const totalpajak = pajak / 100 * (qty * harga - diskon_off);
        details[index].subtotal = qty * harga - diskon_off + totalpajak;

        renderDetail2();

        $('#qtyapproved' + index).val(qty);


    });

    // $(document).on('change', '.staapproved', function() {
    //     var index = $(this).data('index');

    //     if ($('#staapproved' + index).is(':checked')) {
    //         details[index].staapproved = 1;
    //     } else {
    //         details[index].staapproved = 0;
    //     }

    //     // alert(sta);

    // });

    function editDetail2() {
        const index = $('#detailIndex').val();
        const kode = $('#detailKode').val();
        const produk = $('#detailProduk').val();
        const satuan = $('#detailSatuan').val();
        const satuanhd = $('#detailSatuanHD').val();
        const distributor = $('#detailDistributor').val();
        const distributorhd = $('#detailDistributorHD').val();
        const principal = $('#detailPrincipal').val();
        const principalhd = $('#detailPrincipalHD').val();
        const qty = parseInt($('#detailQty').val()) || 0;
        const harga = parseFloat($('#detailHarga').val()) || 0;
        const hna = parseFloat($('#detailHNA').val()) || 0;
        const bonus = parseInt($('#detailBonus').val()) || 0;
        const diskon = parseFloat($('#detailDiskon').val()) || 0;
        const pajak = parseFloat($('#detailPajak').val()) || 0;
        const tipe = $('#detailTipe').val();
        const diskon_off = parseFloat($('#detailDiskontOff').val()) || 0;

        // Field yang hanya disimpan, tidak tampil di list


        // const qty = quantity + bonus;
        const subtotal = (qty * harga) - diskon + pajak - diskon_off;



        if (index) { // Jika sedang edit, perbarui data lama
            details[parseInt(index)] = {
                index,
                kode,
                produk,
                satuan,
                satuanhd, // Data tambahan, tetap disimpan
                distributor,
                distributorhd, // Data tambahan, tetap disimpan
                principal,
                principalhd, // Data tambahan, tetap disimpan
                qty,
                qtyapproval,
                harga,
                hna,
                bonus,
                diskon,
                pajak,
                tipe,
                diskon_off,
                subtotal,
                staapproval
            };
        } else { // Jika tidak ada index, tambahkan item baru
            details.push({
                index,
                kode,
                produk,
                satuan,
                satuanhd, // Data tambahan, tetap disimpan
                distributor,
                distributorhd, // Data tambahan, tetap disimpan
                principal,
                principalhd, // Data tambahan, tetap disimpan
                qty,
                qtyapproval,
                harga,
                hna,
                bonus,
                diskon,
                pajak,
                tipe,
                diskon_off,
                subtotal,
                staapproval
            });
        }

        $('#detailModal').modal('hide');
        renderDetail2();
    }


    function deleteDetail(index) {
        details.splice(index, 1); // Hapus item dari array
        renderDetail2(); // Perbarui tampilan tabel
    }

    function renderDetail() {
        let rows = '';
        details.forEach((d, index) => {
            rows += `<tr>${Object.values(d).map(val => `<td>${val}</td>`).join('')}
                        <td>
                            <button class="btn btn-xs btn-warning" onclick="openDetailModal(${index})">Edit</button>
                            <button class="btn btn-xs btn-danger" onclick="deleteDetail(${index})">Hapus</button>
                        </td>
                    </tr>`;
        });
        $('#detailBody').html(rows);
    }

    function renderDetail2() {
        let rows = '';
        details.forEach((d, index) => {
            rows += `<tr>
                    <td>${d.kode}</td>
                    <td>${d.produk}</td>
                    <td>${d.satuanhd}</td>
                    <td>${d.distributorhd}</td>
                    <td>${d.principalhd}</td>
                    <td>${d.qty}</td>
                    <td><input type="number" id="qtyapproved${index}" data-index="${index}" value="${d.qtyapproved}" class="qtyapproved"></td>
                    <td>${d.harga}</td>
                    <td>${d.hna}</td>
                    <td>${d.bonus}</td>
                    <td>${d.diskon}</td>
                    <td>${d.pajak}</td>
                    <td>${d.tipe}</td>
                    <td>${d.diskon_off}</td>
                    <td>${d.subtotal}</td>
                    <td><input type="checkbox" id="staapproved${index}" data-index="${index}" class="staapproved" ${d.staapproved === '1'? 'checked' : ''}></td>
                    <td>
                        <button class="btn btn-xs btn-warning" onclick="openDetailModal(${index})">Edit</button>
                        <button class="btn btn-xs btn-danger" onclick="deleteDetail(${index})">Hapus</button>
                    </td>
                 </tr>`;
        });
        $('#detailBody').html(rows); // Pastikan tampilan tabel diperbarui
    }

    function saveTransaction() {
        const prid = $('#prid').val();
        const tglStart = $('#tglStart').val();
        const tglEnd = $('#tglEnd').val();

        if (!tglStart || !tglEnd) {
            alert("Harap isi Tanggal Mulai dan Tanggal Selesai!");
            return;
        }

        const transactionData = {
            prid,
            tglStart,
            tglEnd,
            details
        };

        $.ajax({
            url: '<?= site_url('purchaserequestapproval/store'); ?>',
            type: 'POST',
            data: JSON.stringify(transactionData),
            contentType: 'application/json',
            success: function(response) {
                alert("Transaksi berhasil disimpan!");
                details = [];
                renderDetail2();
            },
            error: function(xhr, status, error) {
                alert("Terjadi kesalahan: " + error);
            }
        });
    }

    // $(document).on('click', '.view', function() {
    //     var obat_cd = $(this).data('obat_cd');
    //     var SupplierID = $(this).data('SupplierID');
    //     var BranchID = $(this).data('BranchID');
    //     var principal_cd = $(this).data('principal_cd');

    //     $.ajax({
    //         url: "<?= site_url('purchaserequest/fetchSingleData'); ?>",
    //         method: "GET",
    //         data: {
    //             obat_cd: obat_cd,
    //             SupplierID: SupplierID,
    //             BranchID: BranchID,
    //             principal_cd: principal_cd
    //         },
    //         dataType: "JSON",
    //         success: function(response) {
    //             //set input
    //             $('#data_form')[0].reset();

    //             //set data from response record
    //             $('#nama').val(response.data.obat_cd);
    //             $('#value').val(response.data.SupplierID);
    //             $('#BranchID').val(response.data.BranchID);
    //             $('#principal_cd').val(response.data.principal_cd);

    //         }
    //     })
    // });

    // Event listener untuk semua Select2
    // $('#detailKode, #detailDistributor, #detailPrincipal').on('change', function() {
    $('#detailKode, #detailDistributor, #detailPrincipal').on('change', function() {
        //Set 0
        $('#detailHNA').val(0);
        $('#detailHargaAkhir').val(0);
        $('#detailBonusAkhir').val(0);
        $('#detailDiskonAkhir').val(0);

        const obat_cd = $('#detailKode').val();
        const SupplierID = $('#detailDistributor').val();
        const BranchID = $('#branch').val();
        const principal_cd = $('#detailPrincipal').val();

        // Pastikan semua nilai terisi sebelum mengirim permintaan
        if (obat_cd != ' ' && SupplierID != ' ' && BranchID != ' ' && principal_cd != ' ') {

            $.ajax({
                url: "<?= site_url('purchaserequest/getPRDetailLastestPrice'); ?>",
                method: "GET",
                data: {
                    obat_cd: obat_cd,
                    SupplierID: SupplierID,
                    BranchID: BranchID,
                    principal_cd: principal_cd
                },
                dataType: "JSON",
                success: function(response) {
                    // Reset form
                    // $('#data_form')[0].reset();

                    // Set data dari response API
                    $('#detailHNA').val(response.data.HNA);
                    $('#detailHargaAkhir').val(response.data.HargaUnit);
                    $('#detailBonusAkhir').val(response.data.Bonus);
                    $('#detailDiskonAkhir').val(response.data.Diskon);
                    calculateSubtotal();
                }
            });
        }
    });

    function saveTransaction2() {
        const tglStart = $('#tglStart').val();
        const tglEnd = $('#tglEnd').val();

        if (!tglStart || !tglEnd) {
            alert("Harap isi Tanggal Mulai dan Tanggal Selesai!");
            return;
        }

        const transactionData = {
            tglStart,
            tglEnd,
            details
        };

        console.log("Mengirim data JSON:", transactionData);

        // Kirim data JSON menggunakan fetch
        fetch('https://example.com/api/transaksi', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(transactionData)
            })
            .then(response => response.json())
            .then(data => {
                console.log("Respon dari server:", data);
                alert("Transaksi berhasil disimpan!");
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Gagal menyimpan transaksi!");
            });

        // Reset data setelah penyimpanan
        $('#tglStart').val('');
        $('#tglEnd').val('');
        details = [];
        renderDetail();
    }
</script>

<!-- Datepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<script>
    $('#tglStart').datepicker({
        todayHighlight: true,
        autoclose: true,
        format: 'dd-mm-yyyy'
    }).val();
    $('#tglEnd').datepicker({
        todayHighlight: true,
        autoclose: true,
        format: 'dd-mm-yyyy'
    }).val();
</script>

<script>
    $(document).ready(function() {

        function fetchDataListItem() {
            $.ajax({
                method: "GET",
                url: "<?= site_url('purchaserequestapproval/pr'); ?>",
                success: function(data) {
                    $('#live_fetchDataItem').html(data);
                }
            });
        }

        fetchDataListItem();

        $(document).on('change', '.staapproved', function() {
            if ($(".staapproved:checked").length === $(".staapproved").length) {
                $("#saveBtn").prop("disabled", false).addClass("active");
            } else {
                $("#saveBtn").prop("disabled", true).removeClass("active");
            }
        });
    });
</script>


<?= $this->endSection('script'); ?>