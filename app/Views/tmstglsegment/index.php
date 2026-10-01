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

                    <div class="card card-outline card-info">
                        <div class="card-body">
                            <div class="row align-items-center">

                                <label for="cb_glsegment" class="col-auto col-form-label">
                                    Segment
                                </label>

                                <div class="col-sm-2">
                                    <?= $cb_glsegment ?>
                                    <span class="invalid-feedback errorSegment"></span>
                                </div>

                                <label for="SegmentNameHeader" class="col-auto col-form-label">
                                    Name
                                </label>
                                <div class="col-sm-2">
                                    <input type="text"
                                        class="form-control form-control-sm"
                                        id="SegmentNameHeader"
                                        name="SegmentNameHeader"
                                        placeholder="Segment Name"
                                        readonly>
                                    <span class="invalid-feedback errorSegmentNameHeader"></span>
                                </div>

                                <label for="SegmentLengthHeader" class="col-auto col-form-label">
                                    Length
                                </label>
                                <div class="col-sm-2">
                                    <input type="text"
                                        class="form-control form-control-sm"
                                        id="SegmentLengthHeader"
                                        name="SegmentLengthHeader"
                                        placeholder="Segment Length"
                                        readonly>
                                    <span class="invalid-feedback errorSegmentLengthHeader"></span>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- jquery validation -->
                    <div id="tableWrapper" class="card card-outline card-info d-none">
                        <div class="card-body">

                            <div class="card-title">
                            </div>

                            <table id="glsegmentTable" class="table table-sm table-bordered table-striped">
                                <thead class="table">
                                    <tr>
                                        <th>Segment Id</th>
                                        <th>Segment Name</th>
                                        <th>Value Number</th>
                                        <th>Value Name</th>
                                        <th>Segment Length</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="modalform" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title"></h5>
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>
                                    </div>

                                    <form id="data_form" method="post" autocomplete="off">
                                        <?= csrf_field(); ?>

                                        <div class="modal-body">
                                            <input type="hidden" id="SegmentSeq" name="SegmentSeq">
                                            <input type="hidden" id="SegmentNumber" name="SegmentNumber">

                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Segment Id</label>
                                                <div class="col-sm-3">
                                                    <input type="text"
                                                        class="form-control form-control-sm"
                                                        id="SegmentId"
                                                        name="SegmentId"
                                                        readonly>
                                                </div>
                                                <label class="col-sm-3 col-form-label">Segment Name</label>
                                                <div class="col-sm-3">
                                                    <input type="text"
                                                        class="form-control form-control-sm"
                                                        id="SegmentName"
                                                        name="SegmentName"
                                                        readonly>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Segment Value Number</label>
                                                <div class="col-sm-3">
                                                    <input type="text"
                                                        class="form-control form-control-sm"
                                                        id="SegmentValueNumber"
                                                        name="SegmentValueNumber">
                                                    <span class="invalid-feedback errorSegmentValueNumber"></span>
                                                </div>

                                                <label class="col-sm-3 col-form-label">Segment Value Name</label>
                                                <div class="col-sm-3">
                                                    <input type="text"
                                                        class="form-control form-control-sm"
                                                        id="SegmentValueName"
                                                        name="SegmentValueName">
                                                    <span class="invalid-feedback errorSegmentValueName"></span>
                                                </div>
                                            </div>

                                            <div class="form-group row CreatedField">
                                                <label class="col-sm-3 col-form-label">Created By</label>
                                                <div class="col-sm-3">
                                                    <input type="text"
                                                        class="form-control form-control-sm"
                                                        id="CreatedBy"
                                                        name="CreatedBy">
                                                    <span class="invalid-feedback errorCreatedBy"></span>
                                                </div>

                                                <label class="col-sm-3 col-form-label">Created Date</label>
                                                <div class="col-sm-3">
                                                    <input type="text"
                                                        class="form-control form-control-sm"
                                                        id="CreatedDate"
                                                        name="CreatedDate">
                                                    <span class="invalid-feedback errorCreatedDate"></span>
                                                </div>
                                            </div>

                                            <div class="form-group row UpdatedField">
                                                <label class="col-sm-3 col-form-label">Updated By</label>
                                                <div class="col-sm-3">
                                                    <input type="text"
                                                        class="form-control form-control-sm"
                                                        id="UpdatedBy"
                                                        name="UpdatedBy">
                                                    <span class="invalid-feedback errorUpdatedBy"></span>
                                                </div>

                                                <label class="col-sm-3 col-form-label">Updated Date</label>
                                                <div class="col-sm-3">
                                                    <input type="text"
                                                        class="form-control form-control-sm"
                                                        id="UpdatedDate"
                                                        name="UpdatedDate">
                                                    <span class="invalid-feedback errorUpdatedDate"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <input type="hidden" id="action" name="action" value="Add">

                                            <button type="submit" id="submit_button" class="btn btn-sm btn-primary">
                                                Simpan
                                            </button>
                                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                                                Tutup
                                            </button>
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

<!-- set menu name by active-menu -->
<script>
    $('#active-menu').html($('p#active-menu').html()); // set top navbar
    $(document).prop("title", $('p#active-menu').html()); // set title
</script>

<script>
    function tmstdiagnosapreview() {
        $.ajax({
            method: "get",
            url: "<?= site_url('tmstglsegment/preview'); ?>",
            success: function(data) {
                $('#viewpreview').html(data);
            }
        });
    }

    function fillHeaderToModal() {

        const selected = $('#cb_glsegment').find(':selected');

        if (!selected.val()) return false;

        $('#SegmentId').val(selected.val());
        $('#SegmentNumber').val(selected.data('segment-number'));

        return true;
    }

    $(document).ready(function() {

        function checkSession(response) {
            if (response.status === 'session_expired') {
                window.location.href = "<?= base_url('auth/login') ?>";
                return false;
            }
            return true;
        }

        $(document).on('click', '#add_record', function() {

            if (!$('#cb_glsegment').val()) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Silakan pilih Segment terlebih dahulu'
                });
                return;
            }

            $('#data_form')[0].reset();
            $('.is-invalid').removeClass('is-invalid');
            $('[class^="error"]').html('');

            fillHeaderToModal();
            applySegmentLength();

            $('#SegmentName').val($('#SegmentNameHeader').val());

            $('.modal-title').text('Tambah Data');
            $('#action').val('Add');
            $('#submit_button').show().html('Simpan');

            $('.CreatedField').hide();
            $('.UpdatedField').hide();
            $('#modalform').modal('show');
        });


        $(document).on('input', '#SegmentValueNumber', function() {
            const max = $(this).attr('maxlength');
            if (max && this.value.length > max) {
                this.value = this.value.slice(0, max);
            }
        });

        $('#data_form').on('submit', function(event) {
            event.preventDefault();

            $.ajax({
                url: "<?= site_url('tmstglsegment/action'); ?>",
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                beforeSend: function() {
                    $('#submit_button')
                        .prop('disabled', true)
                        .html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('#submit_button')
                        .prop('disabled', false)
                        .html('Simpan');
                },
                success: function(response) {

                    if (!checkSession(response)) return;

                    if (response.error) {
                        showValidationErrors(response.error);
                        return;
                    }

                    if (response.status === 'error') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message || 'Terjadi kesalahan saat menyimpan data.'
                        });
                        return;
                    }

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message || 'Data berhasil disimpan.'
                    });

                    clearFormValidation();
                    $('#data_form')[0].reset();
                    $('#modalform').modal('hide');

                    // reload datatable
                    $('#glsegmentTable')
                        .DataTable()
                        .ajax.reload(null, false);
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'Gagal menghubungi server. Silakan coba lagi nanti.'
                    });
                    console.error('AJAX Error:', status, error);
                }
            });
        });


        // 🔧 Fungsi bantu untuk menampilkan error validasi
        function showValidationErrors(errors) {
            const fields = ['SegmentId', 'SegmentValueNumber', 'SegmentValueName'];
            fields.forEach(function(field) {
                if (errors[field]) {
                    $('#' + field).addClass('is-invalid');
                    $('.error' + capitalize(field)).html(errors[field]);
                } else {
                    $('#' + field).removeClass('is-invalid');
                    $('.error' + capitalize(field)).html('');
                }
            });
        }

        // 🔧 Fungsi bantu untuk reset validasi
        function clearFormValidation() {
            const fields = ['SegmentId', 'SegmentValueNumber', 'SegmentValueName'];
            fields.forEach(function(field) {
                $('#' + field).removeClass('is-invalid');
                $('.error' + capitalize(field)).html('');
            });
        }

        // 🔧 Capitalize helper
        function capitalize(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

        /*--------------------------------------------------*/
        $(document).on('click', '.view', function() {

            const SegmentSeq = $(this).data('segmentseq');

            $.ajax({
                url: "<?= site_url('tmstglsegment/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    SegmentSeq
                },
                dataType: "JSON",
                success: function(response) {

                    if (!checkSession(response)) return;

                    const data = response.data;

                    $('#data_form')[0].reset();
                    $('.is-invalid').removeClass('is-invalid');
                    $('[class^="error"]').html('');

                    $('#SegmentSeq').val(data.SegmentSeq);
                    $('#SegmentNumber').val(data.SegmentNumber);
                    $('#SegmentId').val(data.SegmentId);
                    $('#SegmentName').val(data.SegmentName);

                    $('#SegmentValueNumber').val(data.SegmentValueNumber).prop('readonly', true);
                    $('#SegmentValueName').val(data.SegmentValueName).prop('readonly', true);

                    $('#CreatedBy').val(data.CreatedBy);
                    $('#CreatedDate').val(data.CreatedDate);
                    $('#UpdatedBy').val(data.UpdatedBy ?? 'Belum Update');
                    $('#UpdatedDate').val(data.UpdatedDate ?? 'Belum Update');

                    $('.modal-title').text('Lihat Data Segment');
                    $('#action').val('View');
                    $('#submit_button').hide();

                    $('.CreatedField').hide();
                    $('.UpdatedField').hide();
                    $('#modalform').modal('show');
                }
            });
        });

        $(document).on('input', '#SegmentValueNumber', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        $(document).on('input', '#SegmentValueNumber', function() {
            const max = $(this).attr('maxlength');
            if (max && this.value.length > max) {
                this.value = this.value.slice(0, max);
            }
        });

        function applySegmentLength() {
            const segmentLength = $('#SegmentLengthHeader').val();

            if (segmentLength) {
                $('#SegmentValueNumber')
                    .attr('maxlength', segmentLength);
            } else {
                $('#SegmentValueNumber')
                    .removeAttr('maxlength')
                    .attr('placeholder', '');
            }
        }


        $(document).on('click', '.edit', function() {

            const SegmentSeq = $(this).data('segmentseq');

            $.ajax({
                url: "<?= site_url('tmstglsegment/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    SegmentSeq
                },
                dataType: "JSON",
                success: function(response) {

                    if (!checkSession(response)) return;

                    const data = response.data;

                    $('#data_form')[0].reset();
                    $('.is-invalid').removeClass('is-invalid');
                    $('[class^="error"]').html('');

                    $('#SegmentSeq').val(data.SegmentSeq);
                    $('#SegmentNumber').val(data.SegmentNumber);
                    $('#SegmentId').val(data.SegmentId);
                    $('#SegmentName').val(data.SegmentName);
                    $('#UpdatedBy').val(data.UpdatedBy);

                    $('#SegmentValueNumber').val(data.SegmentValueNumber).prop('readonly', false);
                    $('#SegmentValueName').val(data.SegmentValueName).prop('readonly', false);

                    applySegmentLength();

                    $('.modal-title').text('Ubah Data Segment');
                    $('#action').val('Edit');
                    $('#submit_button').show().html('Simpan');

                    $('.CreatedField').hide();
                    $('.UpdatedField').hide();

                    $('#modalform').modal('show');
                }
            });
        });

        function confirmDelete({
            segmentSeq,
            url,
            tableId
        }) {
            Swal.fire({
                title: 'Yakin ingin menghapus data?',
                text: 'Data GL Segment akan dihapus secara permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (!result.isConfirmed) return;

                $.ajax({
                    url: url,
                    method: 'POST',
                    dataType: 'JSON',
                    data: {
                        SegmentSeq: segmentSeq
                    },
                    success: function(res) {
                        if (res.status === 'success') {
                            Swal.fire('Berhasil', res.message, 'success');
                            $(`#${tableId}`).DataTable().ajax.reload(null, false);
                        } else {
                            Swal.fire('Gagal', res.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        Swal.fire('Error', 'Terjadi kesalahan saat menghapus data', 'error');
                    }
                });
            });
        }

        $(document).on('click', '.delete', function() {
            const segmentSeq = $(this).data('segmentseq');

            confirmDelete({
                segmentSeq: segmentSeq,
                url: "<?= site_url('tmstglsegment/delete'); ?>",
                tableId: 'glsegmentTable'
            });
        });
    });
</script>

<script>
    $(document).ready(function() {

        let selectedFilter = null;

        const table = $('#glsegmentTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            deferLoading: 0,
            dom: 'Bfrtip',
            ajax: {
                url: "<?= base_url('tmstglsegment/datatables') ?>",
                type: "POST",
                contentType: "application/json",
                data: function(d) {
                    d.Filter = selectedFilter;
                    return JSON.stringify(d);
                },
                dataSrc: function(json) {
                    json.data = json.data || [];
                    return json.data;
                }
            },
            columns: [{
                    data: 'segmentId'
                },
                {
                    data: 'segmentName'
                },
                {
                    data: 'segmentValueNumber'
                },
                {
                    data: 'segmentValueName'
                },
                {
                    data: 'segmentLength'
                },
                {
                    data: 'aksi',
                    orderable: false
                }
            ],
            columnDefs: [{
                targets: [5],
                className: 'text-center'
            }],
            buttons: [{
                text: "Tambah",
                attr: {
                    id: "add_record",
                    class: "btn btn-sm btn-success <?= session()->get('flag_insert') ? '' : 'd-none' ?>"
                }
            }],
            language: {
                sSearch: "Cari Data:",
                sZeroRecords: "Data tidak ditemukan",
                sInfo: "Total: _TOTAL_ data"
            }
        });

        $('#cb_glsegment').on('change', function() {

            const selected = $(this).find(':selected');
            const segmentNumber = selected.data('segment-number');
            const segmentName = selected.data('segment-name');
            const segmentLength = selected.data('segment-length');

            if (!segmentNumber) {
                selectedFilter = null;
                $('#tableWrapper').addClass('d-none');
                table.clear().draw();
                return;
            }

            $('#SegmentNameHeader').val(segmentName);
            $('#SegmentLengthHeader').val(segmentLength);

            if (segmentLength) {
                $('#SegmentValueNumber').attr('maxlength', segmentLength);
            } else {
                $('#SegmentValueNumber').removeAttr('maxlength');
            }

            selectedFilter = segmentNumber;
            $('#tableWrapper').removeClass('d-none');
            table.ajax.reload();
        });

    });
</script>


<?= $this->endSection('script'); ?>