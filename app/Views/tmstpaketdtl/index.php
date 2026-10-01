<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>
<link rel="stylesheet" href="<?= base_url('plugins/toastr/toastr.min.css') ?>">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<style>
    .btn-fix-w { width: 60px; padding-top: 0px; padding-bottom: 0px; }
    select.form-control-sm~.select2-container--default { font-size: .720rem !important; }
    .form-control-sm { font-size: .720rem !important; }
</style>
<?= $this->endSection('style'); ?>

<?= $this->section('content'); ?>
<?php $session = session(); ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1></h1></div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-info">
                        <div class="card-body">
                            <table id="paketdtlTable" class="table table-sm table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Paket ID</th>
                                        <th>Line No</th>
                                        <th>Type</th>
                                        <th>Detail Code</th>
                                        <th>Detail Name</th>
                                        <th>Quantity</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <!-- Modal Form -->
                        <div class="modal fade" id="modalform" tabindex="" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="modalTitle"></h4>
                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                    </div>
                                    <form method="post" id="data_form" autocomplete="off">
                                        <?= csrf_field(); ?>
                                        <div class="modal-body">
                                            <div class="mb-3 row">
                                                <label for="paket_ID" class="col-sm-2 col-form-label">Paket ID</label>
                                                <div class="col-sm-4">
                                                     <?= view('components/dropdown', [
                                                        'name'      => 'paket_ID',
                                                        'apiUrl'    => base_url('/dropdown/customize/2/1/dropdown/pakethdr/null/null/null/null'),
                                                        'extraKeys' => [],
                                                        'selected'  => '',
                                                        'errors'    => $errors ?? []
                                                    ]) ?>
                                                    <span class="error invalid-feedback errorPaket_ID"></span>
                                                </div>
                                                <label for="type" class="col-sm-2 col-form-label">Type</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="type" name="type">
                                                    <span class="error invalid-feedback errorType"></span>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="detail_Code" class="col-sm-2 col-form-label">Detail Code</label>
                                                <div class="col-sm-4">
                                                    <?= view('components/dropdown', [
                                                        'name'      => 'detail_Code',
                                                        'apiUrl'    => base_url('/dropdown/customize/2/1/dropdown/tindakan/null/null/null/null'),
                                                        'extraKeys' => [],
                                                        'selected'  => '',
                                                        'errors'    => $errors ?? []
                                                    ]) ?>
                                                    <span class="error invalid-feedback errorDetail_Code"></span>
                                                </div>
                                                <label for="quantity" class="col-sm-2 col-form-label">Quantity</label>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control form-control-sm" id="quantity" name="quantity" min="1">
                                                    <span class="error invalid-feedback errorQuantity"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" id="hidden_paket_id" name="hidden_paket_id" />
                                            <input type="hidden" id="line_no" name="line_no" />
                                            <input type="hidden" id="action" name="action" value="Add" />
                                            <button type="submit" name="submit" id="submit_button" class="btn btn-sm btn-primary">Simpan</button>
                                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Import -->
                        <div class="modal fade" id="modalimport" tabindex="" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title"></h4>
                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="<?= site_url("tmstpaketdtl/preview") ?>" id="uploadForm" method="post" enctype="multipart/form-data">
                                            <?= csrf_field(); ?>
                                            <label for="filename">Import Excel File : <a href="<?= site_url("tmstpaketdtl/download") ?>"><u>Download Format</u></a></label><br>
                                            <input type="file" name="filename" id="filename">
                                            <button type="submit" name="preview" class="btn btn-sm btn-primary" id="preview">Preview</button>
                                        </form>
                                        <div id="viewpreview"></div><br>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection('content'); ?>

<?= $this->section('script'); ?>
<script src="<?= base_url('plugins/toastr/toastr.min.js') ?>"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<script>
    $('#active-menu').html($('p#active-menu').html());
    $(document).prop("title", $('p#active-menu').html());
</script>

<script>
    
    function loadDetailDropdown(type, selectedVal = '') {
        const $sel = $('#detail_Code');
        $sel.find('option:not(:first)').remove();

        if (!type) return;

        if (type === 'T') {
            $.ajax({
                url: "<?= site_url('tmstpaketdtl/getTindakan') ?>",
                method: "GET",
                dataType: "JSON",
                success: function(res) {
                    $.each(res.data, function(i, item) {
                        const label = item.tindakan_ID + ' - ' + item.tindakan_Name + (item.unit_ID ? ' [' + item.unit_ID + ']' : '');
                        $sel.append(new Option(label, item.tindakan_ID, false, item.tindakan_ID == selectedVal));
                    });
                    $sel.trigger('change.select2');
                }
            });
        }
    }

    function tmstpaketdtlpreview() {
        $.ajax({
            method: "get",
            url: "<?= site_url('tmstpaketdtl/preview'); ?>",
            success: function(data) { $('#viewpreview').html(data); }
        });
    }

    $(document).ready(function() {

        $('#paket_ID, #detail_Code').select2({ dropdownParent: $('#modalform'), width: '100%' });

        function checkSession(response) {
            if (response.status === 'session_expired') {
                window.location.href = "<?= base_url('auth/login') ?>";
                return false;
            }
            return true;
        }

        $(document).on('click', '#add_record', function() {
            $('#data_form')[0].reset();
            clearFormValidation();

            $('select[name="paket_ID"]').prop('disabled', false).val('').trigger('change.select2');
            $('#type').prop('disabled', false);
            $('select[name="detail_Code"]').prop('disabled', false).val('').trigger('change.select2');
            $('#quantity').prop('disabled', false);

            $('.modal-title').text('Tambah Data');
            $('#action').val('Add');
            $('#submit_button').html('Simpan').show();
            $('#modalform').modal('show');
        });

        $(document).on('change', '#type', function() {
            loadDetailDropdown($(this).val());
        });

        $('#data_form').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "<?= site_url('tmstpaketdtl/action'); ?>",
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                beforeSend: function() {
                    $('#submit_button').prop('disabled', true).html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('#submit_button').prop('disabled', false).html('Simpan');
                },
                success: function(response) {
                    if (!checkSession(response)) return;
                    if (response.error) {
                        showValidationErrors(response.error);
                    } else if (response.status === 'error') {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: response.message || 'Terjadi kesalahan.' });
                    } else {
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message || 'Data berhasil disimpan.' });
                        clearFormValidation();
                        $('#data_form')[0].reset();
                        $('#modalform').modal('hide');
                        $('#paketdtlTable').DataTable().ajax.reload(null, false);
                    }
                },
                error: function() {
                    Swal.fire({ icon: 'error', title: 'Server Error', text: 'Gagal menghubungi server.' });
                }
            });
        });

        function showValidationErrors(errors) {
            const fields = ['paket_ID', 'type', 'detail_Code', 'quantity'];
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

        function clearFormValidation() {
            ['paket_ID', 'type', 'detail_Code', 'quantity'].forEach(function(field) {
                $('#' + field).removeClass('is-invalid');
                $('.error' + capitalize(field)).html('');
            });
        }

        function capitalize(str) { return str.charAt(0).toUpperCase() + str.slice(1); }

        $(document).on('click', '.view', function() {
            const paket_id = $(this).data('paket_id');
            const line_no  = $(this).data('line_no');
            fetchAndOpenModal(paket_id, line_no, 'View');
        });

        $(document).on('click', '.edit', function() {
            const paket_id = $(this).data('paket_id');
            const line_no  = $(this).data('line_no');
            fetchAndOpenModal(paket_id, line_no, 'Edit');
        });

        function fetchAndOpenModal(paket_id, line_no, mode) 
        {
            $.ajax({
                url: "<?= site_url('tmstpaketdtl/fetchSingleData'); ?>",
                method: "GET",
                data: { paket_id, line_no },
                dataType: "JSON",
                success: function(response) {
                    if (!checkSession(response)) return;

                    $('#data_form')[0].reset();
                    clearFormValidation();

                    const data   = response.data;
                    const isView = (mode === 'View');

                    $('select[name="paket_ID"]').val(data.paket_ID).prop('disabled', isView).trigger('change.select2');

                    $('#type').val(data.type).prop('disabled', isView);

                    $('select[name="detail_Code"]').val(data.detail_Code).prop('disabled', isView).trigger('change.select2');

                    $('#quantity').val(data.quantity).prop('disabled', isView);

                    $('.modal-title').text(isView ? 'Lihat Data' : 'Ubah Data');
                    $('#action').val(mode);
                    $('#hidden_paket_id').val(paket_id);
                    $('#line_no').val(line_no);
                    $('#submit_button')[isView ? 'hide' : 'show']().html('Simpan');

                    $('#modalform').modal('show');
                },
                error: function() {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal mengambil data.' });
                }
            });
        }

        $(document).on('click', '.delete', function() {
            const paket_id = $(this).data('paket_id');
            const line_no  = $(this).data('line_no');

            Swal.fire({
                title: 'Yakin ingin menghapus data?',
                text: 'Data paket detail akan dihapus secara permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= site_url('tmstpaketdtl/delete'); ?>",
                        method: "POST",
                        data: { paket_id, line_no },
                        dataType: "JSON",
                        success: function(response) {
                            if (!checkSession(response)) return;
                            if (response.status === 'error') {
                                Swal.fire({ icon: 'error', title: 'Gagal', text: response.message });
                            } else {
                                Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message });
                                $('#paketdtlTable').DataTable().ajax.reload(null, false);
                            }
                        },
                        error: function() {
                            Swal.fire({ icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan.' });
                        }
                    });
                }
            });
        });

        $(document).on('click', '#import', function() {
            $('.modal-title').text('Import Data');
            $("#filename").val(null);
            $('#viewpreview').html('');
            $('#modalimport').modal('show');
        });

        $('#uploadForm').submit(function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            $.ajax({
                url: '/tmstpaketdtl/preview',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() { $('#preview').prop('disabled', true).html('<i class="fa fa-spin fa-spinner"></i>'); },
                complete: function() { $('#preview').prop('disabled', false).html('Preview'); },
                success: function() { tmstpaketdtlpreview(); },
                error: function(xhr) { console.error('Error:', xhr.responseText); }
            });
        });

        $("#paketdtlTable").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            dom: 'Bfrtip',
            ajax: {
                url: "<?= base_url('tmstpaketdtl/datatables') ?>",
                type: "POST",
                contentType: "application/json",
                data: function(d) { return JSON.stringify(d); }
            },
            columnDefs: [
                { orderable: false, targets: [0, 7] },
                { targets: [0, 7], className: 'text-center' }
            ],
            columns: [
                { data: 'rownum',       orderable: false },
                { data: 'paket_ID' },
                { data: 'line_no' },   
                { data: 'type' },
                { data: 'detail_Code' },
                { data: 'detail_Name',  defaultContent: '-' }, 
                { data: 'quantity' },
                { data: 'aksi',         orderable: false }
            ],
            buttons: [
                {
                    text: "Tambah", action: function() {},
                    attr: { id: "add_record", style: "background-color:#56b746; <?= session()->get('flag_insert') === 1 ? '' : 'd-none' ?>", name: "add_record" }
                },
                {
                    extend: "excel", text: "Excel",
                    className: "btn-sm btn-primary <?= session()->get('flag_export') === 1 ? '' : 'd-none' ?>",
                    exportOptions: { columns: [0,1,2,3,4,5,6] }
                },
                {
                    extend: "print", text: "Cetak",
                    className: "btn-sm btn-info <?= session()->get('flag_print') === 1 ? '' : 'd-none' ?>",
                    exportOptions: { columns: [0,1,2,3,4,5,6] }
                },
                {
                    text: "Import", action: function() {},
                    attr: { id: "import", style: "background-color:#56b746; <?= session()->get('flag_insert') === 1 ? '' : 'd-none' ?>" }
                }
            ],
            oLanguage: {
                sSearch: "Cari Data:", sInfoEmpty: "Tidak ada data",
                sInfo: "Total: _TOTAL_ data", sInfoFiltered: " dari _MAX_ data",
                sZeroRecords: "Data tidak ditemukan",
                oPaginate: { sFirst: "Awal", sPrevious: "Sebelum", sNext: "Berikut", sLast: "Akhir" }
            }
        }).buttons().container().appendTo("#paketdtlTable_wrapper .col-md-6:eq(0)");

        $('#paketdtlTable').on('xhr.dt', function(e, settings, json) {
            if (json && json.status === 'session_expired') {
                window.location.href = "<?= base_url('auth/login') ?>";
            }
        });

    });
</script>
<?= $this->endSection('script'); ?>