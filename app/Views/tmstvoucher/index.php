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
                                                <label for="VoucherID" class="col-sm-2 col-form-label">Transaction ID</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="VoucherID" name="VoucherID">
                                                    <span class="error invalid-feedback errorVoucherID">
                                                    </span>
                                                </div>
                                                <label for="Description" class="col-sm-2 col-form-label">Description</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="Description" name="Description">
                                                    <span class="error invalid-feedback errorDescription">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="TotalVoucher" class="col-sm-2 col-form-label">Total Voucher</label>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control form-control-sm text-right" id="TotalVoucher" name="TotalVoucher">
                                                    <span class="error invalid-feedback errorTotalVoucher">
                                                    </span>
                                                </div>
                                                <!-- <label for="Applicable" class="col-sm-2 col-form-label">Applicable</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="Applicable" name="Applicable">
                                                    <span class="error invalid-feedback errorApplicable">
                                                    </span>
                                                </div> -->
                                                <?= $cb_applicable ?>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="Amount" class="col-sm-2 col-form-label">Amount</label>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control form-control-sm text-right" id="Amount" name="Amount">
                                                    <span class="error invalid-feedback errorTotalAmount">
                                                    </span>
                                                </div>
                                                <!-- <label for="ExpiredDate" class="col-sm-2 col-form-label">Expired Date</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="ExpiredDate" name="ExpiredDate">
                                                    <span class="error invalid-feedback errorExpiredDate">
                                                    </span>
                                                </div> -->
                                                <label for="ExpiredDate" class="col-sm-2 col-form-label">Expired Date</label>
                                                <div class="col-sm-4">
                                                    <div class="input-group date ExpiredDate" data-date-format="mm/dd/yyyy">
                                                        <input type="text" class="form-control form-control-sm datepicker" placeholder="dd-mm-yyyy" id="ExpiredDate" name="ExpiredDate">
                                                        <div class="input-group-append" data-target="#ExpiredDate" data-toggle="ExpiredDate">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                    </div>
                                                    <span class="error invalid-feedback errorExpiredDate">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="Remark1" class="col-sm-2 col-form-label">Remark 1</label>
                                                <div class="col-sm-4">
                                                    <textarea class="form-control form-control-sm" rows="3" placeholder="..." id="Remark1" name="Remark1" autocomplete="off"></textarea>
                                                    <span class="error invalid-feedback errorRemark1">
                                                    </span>
                                                </div>
                                                <label for="Remark2" class="col-sm-2 col-form-label">Remark 2</label>
                                                <div class="col-sm-4">
                                                    <textarea class="form-control form-control-sm" rows="3" placeholder="..." id="Remark2" name="Remark2" autocomplete="off"></textarea>
                                                    <span class="error invalid-feedback errorRemark2">
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

                        <!-- Modal Detail -->
                        <div class="modal fade" id="modaldetail" tabindex="" role="dialog" aria-labelledby="exampleModalLabelVoucher" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLabelVoucher">Voucher Detail</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <span id="viewdatadetail"></span>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                                    </div>


                                </div>
                            </div>
                        </div>

                        <!-- Modal Import -->
                        <div class="modal fade" id="modalimport" tabindex="" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLabel"></h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="<?= site_url("tmstvoucher/preview") ?>" id="uploadForm" method="post" enctype="multipart/form-data">
                                            <?= csrf_field(); ?>
                                            <label for="filename">Import Excel File : <a href="<?= site_url("tmstvoucher/download") ?>"><u>Download Format</u></a></label> <br>
                                            <input type="file" name="filename" id="filename">
                                            <button type="submit" name="preview" class="btn btn-sm btn-primary" id="preview">Preview</button>
                                        </form>


                                        <div id="viewpreview"></div>
                                        <br>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                                    </div>
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

<!-- set menu name by active-menu -->
<script>
    $('#active-menu').html($('p#active-menu').html()); // set top navbar
    $(document).prop("title", $('p#active-menu').html()); // set title
</script>

<script>
    // $(document).on('click', '.prints1', function() {
    //     var voucherid = $(this).data('voucherid');
    //     // alert(voucherid);
    //     // const newTab = window.open('', '_blank'); // Open it immediately
    //     $.ajax({
    //         url: "<?= site_url('/tmstvoucher/printi1'); ?>",
    //         method: "POST",
    //         data: {
    //             VoucherID: voucherid
    //         },
    //         dataType: "JSON",
    //         success: function(data) {
    //             window.open("<?= base_url('/tmstvoucher/printi1'); ?>", '_blank');
    //             // alert(voucherid);
    //             // newTab.location.href = 'https://deltafood.co.id'; // Redirect once AJAX completes
    //         }
    //     });
    // });

    // $(document).on('click', '.prints1', function() {
    //     var voucherid = $(this).data('voucherid');

    //     // Buka tab kosong dulu agar tidak diblokir
    //     var newTab = window.open('', '_blank');

    //     $.ajax({
    //         url: "<?= site_url('/tmstvoucher/printi1'); ?>",
    //         method: "POST",
    //         data: {
    //             VoucherID: voucherid
    //         },
    //         dataType: "JSON",
    //         success: function(data) {
    //             // Update tab baru dengan URL target
    //             newTab.location.href = "<?= base_url('/tmstvoucher/printi1'); ?>";
    //         },
    //         error: function(xhr, status, error) {
    //             newTab.document.write("<h1>Gagal memuat halaman cetak</h1><p>" + error + "</p>");
    //         }
    //     });
    // });

    $(document).on('click', '.prints1', function() {

        if (confirm("Print voucher hanya dapat dilakukan 1 kali, apakah anda yakin?")) {
            var voucherid = $(this).data('voucherid');
            var newTab = window.open('', '_blank'); // Buka kosong dulu

            $.ajax({
                url: "<?= site_url('/tmstvoucher/printi1'); ?>",
                method: "POST",
                data: {
                    VoucherID: voucherid
                },
                success: function(html) {
                    newTab.document.open();
                    newTab.document.write(html);
                    newTab.document.close();
                    tmstwarehouse();
                },
                error: function() {
                    newTab.document.write("<h3>Gagal memuat konten voucher!</h3>");
                }
            });
        }
    });

    $('#AccountNo.select2custom').on('change', function() {
        const selectedOption = $(this).find('option:selected');
        const desc = selectedOption.data('desc');
        $('#AccountDescription').val(desc);
    });

    function tmstwarehouse() {
        $.ajax({
            method: "get",
            url: "<?= site_url('/tmstvoucher/fetchAll'); ?>",
            success: function(data) {
                $('#viewdata').html(data);
            }
        });
    }

    function tmstvoucherdetail() {
        $.ajax({
            method: "get",
            url: "<?= site_url('/tmstvoucher/fetchAllDetail'); ?>",
            success: function(data) {
                $('#viewdatadetail').html(data);
            }
        });
    }

    function tmstdiagnosapreview() {
        $.ajax({
            method: "get",
            url: "<?= site_url('tmstvoucher/preview'); ?>",
            success: function(data) {
                $('#viewpreview').html(data);
            }
        });
    }

    $(document).on('click', '.approve', function() {
        var voucherid = $(this).data('voucherid');
        var user = $(this).data('user');
        var datenow = $(this).data('datenow');

        if (confirm("Apakah anda yakin merubah status menjadi approved?")) {
            $.ajax({
                url: "<?= site_url('tmstvoucher/approve'); ?>",
                method: "POST",
                data: {
                    VoucherID: voucherid,
                    ApprovedBy: user,
                    DateApproved: datenow
                },
                dataType: "JSON",
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.success,
                        //footer: '<a href="">Why do I have this issue?</a>'
                    });
                    tmstwarehouse();
                    setTimeout(function() {
                        $('#message').html('');
                    }, 5000);
                }
            })
        }
    });

    $(document).on('click', '.cancel', function() {
        var voucherid = $(this).data('voucherid');
        var user = $(this).data('user');
        var datenow = $(this).data('datenow');

        if (confirm("Apakah anda yakin merubah status menjadi cancel?")) {
            $.ajax({
                url: "<?= site_url('tmstvoucher/cancel'); ?>",
                method: "POST",
                data: {
                    VoucherID: voucherid,
                    ApprovedBy: user,
                    DateApproved: datenow
                },
                dataType: "JSON",
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.success,
                        //footer: '<a href="">Why do I have this issue?</a>'
                    });
                    tmstwarehouse();
                    setTimeout(function() {
                        $('#message').html('');
                    }, 5000);
                }
            })
        }
    });

    $(document).ready(function() {
        tmstwarehouse()

        $('#ExpiredDate').datepicker("setDate", new Date());

        $(document).on('click', '#add_record', function() {
            //set input
            $('#VoucherID').attr('disabled', '');
            // $('#VoucherID').removeAttr('disabled');
            $('#Description').removeAttr('disabled');
            $('#MarkupPercentage').removeAttr('disabled');
            $('#Type').removeAttr('disabled');
            $('#Type').removeAttr('checked');
            $('#IntegratedModule').removeAttr('disabled');
            $('#IntegratedModule').removeAttr('checked');
            $('#VoucherID').removeAttr('readonly');


            $('#data_form')[0].reset();

            //set error validation
            $('#VoucherID').removeClass('is-invalid');
            $('#Description').removeClass('is-invalid');
            $('#Type').removeClass('is-invalid');
            $('#MarkupPercentage').removeClass('is-invalid');
            $('#IntegratedModule').removeClass('is-invalid');
            $('.errorKodeCaraBayar').html('');
            $('.errorDescriptionCaraBayar').html('');
            $('.errorType').html('');
            $('.errorDiag_sta_id').html('');

            //set selected data select2
            $('#Type').val(' ');
            $('#Type').trigger('change');
            $('#IntegratedModule').val(' ');
            $('#IntegratedModule').trigger('change');
            $('#AccountNo').val(' ');
            $('#AccountNo').trigger('change');

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
                url: "<?= site_url('tmstvoucher/action'); ?>",
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
                        if (response.error.VoucherID) {
                            $('#VoucherID').addClass('is-invalid');
                            $('.errorKodeCaraBayar').html(response.error.VoucherID);
                        } else {
                            $('#VoucherID').removeClass('is-invalid');
                            $('.errorKodeCaraBayar').html('');
                        }
                        if (response.error.warehouse_nm) {
                            $('#warehouse_nm').addClass('is-invalid');
                            $('.errorDescriptionCaraBayar').html(response.error.warehouse_nm);
                        } else {
                            $('#warehouse_nm').removeClass('is-invalid');
                            $('.errorDescriptionCaraBayar').html('');
                        }
                        if (response.error.Type) {
                            $('#Type').addClass('is-invalid');
                            $('.errorType').html(response.error.Type);
                        } else {
                            $('#Type').removeClass('is-invalid');
                            $('.errorType').html('');
                        }
                        if (response.error.IntegratedModule) {
                            $('#IntegratedModule').addClass('is-invalid');
                            $('.errorDiag_sta_id').html(response.error.IntegratedModule);
                        } else {
                            $('#IntegratedModule').removeClass('is-invalid');
                            $('.errorDiag_sta_id').html('');
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
                        $('#VoucherID').removeClass('is-invalid');
                        $('#warehouse_nm').removeClass('is-invalid');
                        $('#Type').removeClass('is-invalid');
                        $('#IntegratedModule').removeClass('is-invalid');
                        $('#VoucherID').val('');
                        $('#warehouse_nm').val('');
                        $('#Type').val('');
                        $('#IntegratedModule').removeAttr('checked');

                        tmstwarehouse();
                        $('#modalform').modal('hide');
                    }
                },
            })
        });

        $(document).on('click', '.view', function() {
            var VoucherID = $(this).data('voucherid');

            $.ajax({
                url: "<?= site_url('tmstvoucher/fetchAllDetail'); ?>",
                method: "GET",
                data: {
                    VoucherID: VoucherID
                },
                // dataType: "JSON",
                success: function(data) {
                    $('#viewdatadetail').html(data);
                    $('#modaldetail').modal('show');
                }
            })
        });

        $(document).on('click', '.edit', function() {
            var VoucherID = $(this).data('VoucherID');

            $.ajax({
                url: "<?= site_url('tmstvoucher/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    VoucherID: VoucherID
                },
                dataType: "JSON",
                success: function(response) {
                    //set input
                    $('#VoucherID').removeAttr('disabled');
                    $('#warehouse_nm').removeAttr('disabled');
                    $('#Type').removeAttr('disabled');
                    // $('#IntegratedModule').removeAttr('disabled');
                    $('#VoucherID').attr('readonly', '');
                    $('#IntegratedModule').removeAttr('disabled');
                    $('#IntegratedModule').removeAttr('checked');
                    $('#Description').removeAttr('disabled');
                    $('#MarkupPercentage').removeAttr('disabled');
                    $('#AccountDescription').removeAttr('disabled');
                    $('#AccountNo').removeAttr('disabled');
                    $('#AccountNo').removeAttr('checked');


                    $('#data_form')[0].reset();

                    //set data from response record
                    $('#VoucherID').val(response.data.VoucherID);
                    $('#warehouse_nm').val(response.data.warehouse_nm);
                    $('#MarkupPercentage').val(response.data.MarkupPercentage);
                    $('#Description').val(response.data.Description);
                    $('#AccountDescription').val(response.data.AccountDescription);

                    //set error validation
                    $('#VoucherID').removeClass('is-invalid');
                    $('#warehouse_nm').removeClass('is-invalid');
                    $('#Type').removeClass('is-invalid');
                    $('#IntegratedModule').removeClass('is-invalid');
                    $('.errorKodeCaraBayar').html('');
                    $('.errorDescriptionCaraBayar').html('');
                    $('.errorMarkupPercentage').html('');
                    $('.errorType').html('');
                    $('.errorDiag_sta_id').html('');
                    $('#AccountNo').removeClass('is-invalid');

                    //set selected data select2
                    $('#Type').val(response.data.Type);
                    $('#Type').trigger('change');
                    $('#IntegratedModule').val(response.data.IntegratedModule);
                    $('#IntegratedModule').trigger('change');
                    $('#AccountNo').val(response.data.AccountNo);
                    $('#AccountNo').trigger('change');

                    //set modal & form
                    $('.modal-title').text('Ubah Data');
                    $('#action').val('Edit');
                    $('#submit_button').show();
                    $('#submit_button').val('Simpan');
                    $('#submit_button').html('Simpan');
                    $('#modalform').modal('show');
                    // $('#hidden_id').val(VoucherID);
                }
            })
        });

        $(document).on('click', '.delete', function() {
            var VoucherID = $(this).data('VoucherID');
            alert(VoucherID);
            if (confirm("Are you sure you want to remove it?")) {
                $.ajax({
                    url: "<?= site_url('tmstvoucher/delete'); ?>",
                    method: "POST",
                    data: {
                        VoucherID: VoucherID
                    },
                    dataType: "JSON",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                            //footer: '<a href="">Why do I have this issue?</a>'
                        });
                        tmstwarehouse();
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

        $(document).on('click', '#import', function() {

            //set modal & form
            $('.modal-title').text('Import Data');
            $("#filename").val(null);
            $('#viewpreview').html('');
            $('#modalimport').modal('show');


        });

        $('#uploadForm').submit(function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            $.ajax({
                url: '/tmstvoucher/preview',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#preview').prop('disabled', true);
                    $('#preview').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('#preview').prop('disabled', false);
                    $('#preview').html('Preview');
                },
                success: function(data) {
                    tmstdiagnosapreview();
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                }
            });
        });


    });
</script>

<!-- Datepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<script>
    $('#ExpiredDate').datepicker({
        todayHighlight: true,
        autoclose: true,
        format: 'dd-mm-yyyy'
    }).val();
</script>



<?= $this->endSection('script'); ?>