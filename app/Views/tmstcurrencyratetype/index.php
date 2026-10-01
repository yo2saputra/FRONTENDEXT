<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>
<link rel="stylesheet" href="<?= base_url('plugins/toastr/toastr.min.css') ?>">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<style>
    .btn-fix-w {
        width: 60px;
        padding-top: 0px;
        padding-bottom: 0px;
    }

    select.form-control-sm~.select2-container--default {
        font-size: .720rem !important;
    }

    .form-control-sm {
        font-size: .720rem !important;
    }
</style>
<?= $this->endSection('style'); ?>

<?= $this->section('content'); ?>

<?php $session = session(); ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1></h1>
                </div>
                <div class="col-sm-6"></div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-info">
                        <div class="card-body">
                            <div class="card-title"></div>
                            <table id="currencyratetypeTable" class="table table-sm table-bordered table-striped">
                                <thead class="table">
                                    <tr>
                                        <th>Rate Type Code</th>
                                        <th>Rate Type Name</th>
                                        <th>Rate</th>
                                        <th>Created By</th>
                                        <th>Created Date</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <div class="modal fade" id="modalform" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalTitle"></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="post" id="data_form" autocomplete="off">
                                        <?= csrf_field(); ?>
                                        <div class="modal-body">
                                            <input type="hidden" id="CurrencyRateTypeCode" name="CurrencyRateTypeCode">
                                            <div class="form-group row">
                                                <label for="CurrencyRateTypeValue" class="col-sm-3 col-form-label">Rate Type Code</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control form-control-sm" id="CurrencyRateTypeValue" name="CurrencyRateTypeValue">
                                                    <span class="invalid-feedback errorCurrencyRateTypeValue"></span>
                                                </div>

                                                <label for="CurrencyRateTypeName" class="col-sm-3 col-form-label">Rate Type Name</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control form-control-sm" id="CurrencyRateTypeName" name="CurrencyRateTypeName">
                                                    <span class="invalid-feedback errorCurrencyRateTypeName"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="CurrencyRate" class="col-sm-3 col-form-label">Rate</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control form-control-sm" id="CurrencyRate" name="CurrencyRate">
                                                    <span class="invalid-feedback errorCurrencyRate"></span>
                                                </div>

                                                <label for="cb_status" class="col-sm-3 col-form-label">Status</label>
                                                <div class="col-sm-3">
                                                    <?= $cb_status ?>
                                                    <span class="invalid-feedback errorcb_status"></span>
                                                </div>
                                            </div>

                                            <div class="form-group row audit-field" style="display:none">
                                                <label for="CreatedBy" class="col-sm-3 col-form-label">Created By</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control form-control-sm" id="CreatedBy" name="CreatedBy" readonly>
                                                </div>
                                                <label for="CreatedDate" class="col-sm-3 col-form-label">Created Date</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control form-control-sm" id="CreatedDate" name="CreatedDate" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" id="hidden_id" name="hidden_id">
                                            <input type="hidden" id="action" name="action" value="Add">
                                            <button type="submit" id="submit_button" class="btn btn-sm btn-primary">Simpan</button>
                                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="modalimport" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Import Data Currency Rate Type</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="<?= site_url("tmstcurrencyratetype/preview") ?>" id="uploadForm" method="post" enctype="multipart/form-data">
                                            <?= csrf_field(); ?>
                                            <label for="filename">Import Excel File : <a href="<?= site_url("tmstcurrencyratetype/download") ?>"><u>Download Format</u></a></label> <br>
                                            <div class="mb-3 row">
                                                <div class="col-sm-7">
                                                    <input type="file" name="filename" id="filename" class="form-control form-control-sm">
                                                </div>
                                                <input type="hidden" name="hide" value="gas">
                                                <div class="col-sm-3">
                                                    <select class="form-control form-control-sm" name="pas">
                                                        <option value="insert">Insert</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-2">
                                                    <button type="submit" name="preview" class="btn btn-sm btn-primary form-control form-control-sm" id="preview">Preview</button>
                                                </div>
                                            </div>
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

    $(document).ready(function() {

        function checkSession(response) {
            if (response.status === 'session_expired') {
                window.location.href = "<?= base_url('auth/login') ?>";
                return false;
            }
            return true;
        }

        $(document).on('click', '#add_record', function() {
            $('#data_form')[0].reset();
            $('.is-invalid').removeClass('is-invalid');
            $('[class^="error"]').html('');
            $('#CurrencyRateTypeCode').prop('readonly', false);
            $('#CurrencyRateTypeValue').prop('readonly', false);
            $('#CurrencyRateTypeName').prop('readonly', false);
            $('#CurrencyRate').prop('readonly', false);
            $('#cb_status').prop('disabled', false);
            $('.audit-field').hide();
            $('.modal-title').text('Tambah Data');
            $('#action').val('Add');
            $('#submit_button').show();
            $('#modalform').modal('show');
        });

        $('#data_form').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "<?= site_url('tmstcurrencyratetype/action'); ?>",
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
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message || 'Terjadi kesalahan saat menyimpan data.'
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message || 'Data berhasil disimpan.'
                        });
                        clearFormValidation();
                        $('#data_form')[0].reset();
                        $('#modalform').modal('hide');
                        $('#currencyratetypeTable').DataTable().ajax.reload(null, false);
                    }
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

        function showValidationErrors(errors) {
            const fields = ['CurrencyRateTypeValue', 'CurrencyRateTypeName', 'CurrencyRate', 'cb_status'];
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
            const fields = ['CurrencyRateTypeValue', 'CurrencyRateTypeName', 'CurrencyRate', 'cb_status'];
            fields.forEach(function(field) {
                $('#' + field).removeClass('is-invalid');
                $('.error' + capitalize(field)).html('');
            });
        }

        function capitalize(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

        $(document).on('click', '.view', function() {
            const CurrencyRateTypeCode = $(this).data('currencyratetypecode');
            $.ajax({
                url: "<?= site_url('tmstcurrencyratetype/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    CurrencyRateTypeCode
                },
                dataType: "JSON",
                success: function(response) {
                    $('#data_form')[0].reset();
                    $('.is-invalid').removeClass('is-invalid');
                    $('[class^="error"]').html('');
                    const data = response.data;
                    $('#CurrencyRateTypeCode').val(data.CurrencyRateTypeCode).prop('readonly', true);
                    $('#CurrencyRateTypeValue').val(data.CurrencyRateTypeValue).prop('readonly', true);
                    $('#CurrencyRateTypeName').val(data.CurrencyRateTypeName).prop('readonly', true);
                    $('#CurrencyRate').val(data.CurrencyRate).prop('readonly', true);
                    if (data.cb_status !== undefined && data.cb_status !== '') {
                        $('#cb_status').val(data.cb_status.toString()).prop('disabled', true);
                    } else {
                        $('#cb_status').val('').prop('disabled', true);
                    }
                    const rawDate = data.CreatedDate;
                    if (rawDate) {
                        const d = new Date(rawDate);
                        const day = String(d.getDate()).padStart(2, '0');
                        const month = String(d.getMonth() + 1).padStart(2, '0');
                        const year = d.getFullYear();
                        $('#CreatedDate').val(`${day}/${month}/${year}`).prop('readonly', true);
                    }
                    $('#CreatedBy').val(data.CreatedBy).prop('readonly', true);
                    $('.audit-field').show();
                    $('.modal-title').text('Lihat Data');
                    $('#action').val('View');
                    $('#submit_button').hide();
                    $('#modalform').modal('show');
                    $('#hidden_id').val(CurrencyRateTypeCode);
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal melihat data',
                        text: 'Terjadi kesalahan saat mengambil data Rate.'
                    });
                }
            });
        });

        $(document).on('click', '.edit', function() {
            const CurrencyRateTypeCode = $(this).data('currencyratetypecode');
            $.ajax({
                url: "<?= site_url('tmstcurrencyratetype/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    CurrencyRateTypeCode
                },
                dataType: "JSON",
                success: function(response) {
                    $('#data_form')[0].reset();
                    $('.is-invalid').removeClass('is-invalid');
                    $('[class^="error"]').html('');
                    const data = response.data;
                    $('#CurrencyRateTypeCode').val(data.CurrencyRateTypeCode).prop('readonly', true);
                    $('#CurrencyRateTypeValue').val(data.CurrencyRateTypeValue).prop('readonly', true);
                    $('#CurrencyRateTypeName').val(data.CurrencyRateTypeName).prop('readonly', false);
                    $('#CurrencyRate').val(data.CurrencyRate).prop('readonly', false);
                    if (data.cb_status !== undefined && data.cb_status !== '') {
                        $('#cb_status').val(data.cb_status.toString()).prop('disabled', false);
                    } else {
                        $('#cb_status').val('').prop('disabled', false);
                    }
                    $('#CreatedBy').val(data.CreatedBy).prop('readonly', true);
                    $('#CreatedDate').val(data.CreatedDate).prop('readonly', true);
                    $('.audit-field').hide();
                    $('.modal-title').text('Ubah Data');
                    $('#action').val('Edit');
                    $('#submit_button').show();
                    $('#hidden_id').val(CurrencyRateTypeCode);
                    $('#modalform').modal('show');
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal mengambil data',
                        text: 'Terjadi kesalahan saat mengambil data rate.'
                    });
                }
            });
        });

        function confirmDelete({
            currencyRateTypeCode,
            url,
            tableId
        }) {
            Swal.fire({
                title: 'Hapus Rate?',
                text: 'Data rate akan dihapus secara permanen. Lanjutkan?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (!result.isConfirmed) return;

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        currencyRateTypeCode: currencyRateTypeCode
                    },
                    dataType: 'JSON',
                    success: function(res) {
                        if (res.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: res.message || 'Data berhasil dihapus',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                $(`#${tableId}`).DataTable().ajax.reload(null, false);
                            });
                        } else {
                            let message = res.message || 'Terjadi kesalahan';

                            if (res.status === 'TERPAKAI') {
                                message = 'Rate tidak dapat dihapus karena sudah digunakan.';
                            } else if (res.status === 'NOTFOUND') {
                                message = 'Data tidak ditemukan.';
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: message
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        let errorMsg = 'Terjadi kesalahan saat menghubungi server.';
                        try {
                            const response = JSON.parse(xhr.responseText);
                            errorMsg = response.message || errorMsg;
                        } catch (e) {}

                        Swal.fire('Gagal menghapus data', errorMsg, 'error');
                        console.error('AJAX Error:', status, error);
                    }
                });
            });
        }

        $(document).on('click', '.delete', function() {
            const currencyRateTypeCode = $(this).data('currencyratetypecode');
            confirmDelete({
                currencyRateTypeCode: currencyRateTypeCode,
                url: "<?= site_url('tmstcurrencyratetype/delete'); ?>",
                tableId: 'currencyratetypeTable'
            });
        });
    });
</script>

<script>
    $(document).on('blur', '#CurrencyRateTypeValue', function() {
        const currencyRateTypeValue = $('#CurrencyRateTypeValue').val();
        const action = $('#action').val();
        const hiddenId = $('#hidden_id').val();

        if ($('#CurrencyRateTypeValue').prop('disabled')) return;

        if (currencyRateTypeValue) {
            $.ajax({
                url: "<?= site_url('tmstcurrencyratetype/checkDuplicate'); ?>", // <-- Ubah ke checkDuplicate
                method: "POST",
                data: {
                    CurrencyRateTypeValue: currencyRateTypeValue,
                    ExcludeCurrencyRateTypeCode: action === 'Edit' ? hiddenId : null
                },
                dataType: "JSON",
                success: function(response) {
                    if (response.isDuplicate) {
                        $('#CurrencyRateTypeValue').addClass('is-invalid');
                        $('.errorCurrencyRateTypeValue').html(response.message);
                        $('#submit_button').prop('disabled', true);
                    } else {
                        $('#CurrencyRateTypeValue').removeClass('is-invalid');
                        $('.errorCurrencyRateTypeValue').html('');
                        $('#submit_button').prop('disabled', false);
                    }
                },
                error: function() {
                    $('#submit_button').prop('disabled', false);
                }
            });
        }
    });

    $(document).on('focus', '#CurrencyRateTypeValue', function() {
        $(this).removeClass('is-invalid');
        $('.errorCurrencyRateTypeValue').html('');
    });
</script>

<script>
    $(document).ready(function() {
        $(document).on('click', '#import', function() {
            $('.modal-title').text('Import Data Currency Rate Type');
            $("#filename").val(null);
            $('#viewpreview').html('');
            $('#modalimport').modal('show');
        });

        $('#uploadForm').submit(function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            $.ajax({
                url: '<?= site_url("tmstcurrencyratetype/preview") ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#preview').prop('disabled', true).html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('#preview').prop('disabled', false).html('Preview');
                },
                success: function(data) {
                    $('#viewpreview').html(data);
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        $("#currencyratetypeTable").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            dom: 'Bfrtip',
            ajax: {
                url: "<?= base_url('tmstcurrencyratetype/datatables') ?>",
                type: "POST",
                contentType: "application/json",
                data: function(d) {
                    return JSON.stringify(d);
                }
            },
            columnDefs: [{
                    orderable: false,
                    targets: [6]
                },
                {
                    targets: [5, 6],
                    className: 'text-center'
                },
                {
                    targets: [2],
                    className: 'text-right'
                }
            ],
            columns: [{
                    data: 'currencyRateTypeValue',
                    className: 'text-left'
                },
                {
                    data: 'currencyRateTypeName',
                    className: 'text-left'
                },
                {
                    data: 'currencyRate',
                    className: 'text-right',
                    render: function(data) {
                        if (data === null || data === undefined) return '';
                        return parseFloat(data).toFixed(8);
                    }
                },
                {
                    data: 'createdBy',
                    className: 'text-left'
                },
                {
                    data: 'createdDate',
                    className: 'text-left',
                    render: function(data) {
                        if (!data) return '';
                        const d = new Date(data);
                        const day = String(d.getDate()).padStart(2, '0');
                        const month = String(d.getMonth() + 1).padStart(2, '0');
                        const year = d.getFullYear();
                        return `${day}/${month}/${year}`;
                    }
                },
                {
                    data: 'statusDesc',
                    className: 'text-center'
                },
                {
                    data: 'aksi',
                    orderable: false,
                    className: 'text-center'
                }
            ],
            buttons: [{
                    text: "Tambah",
                    action: function() {
                        $('#add_record').click();
                    },
                    attr: {
                        id: "add_record",
                        style: "background-color:#56b746; <?= session()->get('flag_insert') === 1 ? '' : 'd-none' ?>",
                    }
                },
                {
                    text: "Excel",
                    action: function() {
                        window.location.href = "<?= site_url('tmstcurrencyratetype/exportExcel') ?>";
                    },
                    className: "btn-sm btn-primary <?= session()->get('flag_export') === 1 ? '' : 'd-none' ?>"
                },
                {
                    extend: "print",
                    text: "Cetak",
                    className: "btn-sm btn-info <?= session()->get('flag_print') === 1 ? '' : 'd-none' ?>",
                    action: function(e, dt, button, config) {
                        $.ajax({
                            url: "<?= site_url('tmstcurrencyratetype/printData') ?>",
                            method: "GET",
                            dataType: "json",
                            success: function(allData) {
                                if (!allData || allData.length === 0) {
                                    alert("Tidak ada data untuk dicetak");
                                    return;
                                }
                                const fields = ['currencyRateTypeValue', 'currencyRateTypeName', 'currencyRate', 'createdBy', 'createdDate', 'statusDesc'];
                                const headers = ['Rate Type Code', 'Rate Type Name', 'Rate', 'Created By', 'Created Date', 'Status'];
                                let html = '<html><head><title>Print - Currency Rate Type</title>';
                                html += '<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">';
                                html += '<style>body { font-family: Arial, sans-serif; padding: 20px; }</style>';
                                html += '</head><body><h3>Data Currency Rate Type</h3>';
                                html += '<table class="display nowrap dataTable" style="width:100%; border-collapse: collapse;" border="1">';
                                html += '<thead><tr>';
                                headers.forEach(h => html += `<th style="padding: 8px; background: #f2f2f2;">${h}</th>`);
                                html += '</tr></thead><tbody>';
                                allData.forEach(row => {
                                    html += '<tr>';
                                    fields.forEach(f => {
                                        if (f === 'currencyRate' && row[f]) {
                                            html += `<td style="padding: 8px;">${parseFloat(row[f]).toFixed(8)}</td>`;
                                        } else if (f === 'createdDate' && row[f]) {
                                            const date = new Date(row[f]);
                                            const day = String(date.getDate()).padStart(2, '0');
                                            const month = String(date.getMonth() + 1).padStart(2, '0');
                                            const year = date.getFullYear();
                                            html += `<td style="padding: 8px;">${day}/${month}/${year}</td>`;
                                        } else {
                                            html += `<td style="padding: 8px;">${row[f] ?? ''}</td>`;
                                        }
                                    });
                                    html += '</tr>';
                                });
                                html += '</tbody></table></body></html>';
                                let printWindow = window.open('', '_blank');
                                printWindow.document.write(html);
                                printWindow.document.close();
                                printWindow.focus();
                                printWindow.print();
                            },
                            error: function() {
                                alert("Gagal mengambil data untuk cetak");
                            }
                        });
                    }
                }
            ],
            oLanguage: {
                sSearch: "Cari Data:",
                sInfoEmpty: "Tidak ada data",
                sInfo: "Total: _TOTAL_ data",
                sInfoFiltered: " dari _MAX_ data",
                sZeroRecords: "Data tidak ditemukan",
                oPaginate: {
                    sFirst: "Awal",
                    sPrevious: "Sebelum",
                    sNext: "Berikut",
                    sLast: "Akhir"
                }
            }
        }).buttons().container().appendTo("#currencyratetypeTable_wrapper .col-md-6:eq(0)");

        $('#currencyratetypeTable').on('xhr.dt', function(e, settings, json, xhr) {
            if (json && json.status === 'session_expired') {
                window.location.href = "<?= base_url('auth/login') ?>";
                alert('Sesi Anda telah berakhir. Silakan login kembali.');
            }
        });
    });
</script>

<?= $this->endSection('script'); ?>