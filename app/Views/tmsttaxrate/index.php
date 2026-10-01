<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="<?= base_url('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">
<style>
    #tableTaxClass tbody tr {
        cursor: pointer;
        transition: background-color 0.2s;
    }

    #tableTaxClass tbody tr:hover {
        background-color: #e9ecef !important;
    }

    .select2-container--bootstrap4 .select2-selection--single {
        height: calc(1.8125rem + 2px) !important;
    }

    .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
        line-height: 1.8125rem !important;
        font-size: 0.875rem !important;
    }

    .select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow {
        height: 1.8125rem !important;
    }

    .form-control-sm,
    .input-group-sm .form-control {
        font-size: 0.875rem !important;
        padding: 0.25rem 0.5rem !important;
        height: calc(1.8125rem + 2px) !important;
    }

    .col-form-label-sm {
        font-size: 0.875rem !important;
        padding-top: 0.25rem !important;
        padding-bottom: 0.25rem !important;
    }

    .input-group-text-sm {
        font-size: 0.875rem !important;
        padding: 0.25rem 0.5rem !important;
    }

    .btn-sm {
        font-size: 0.875rem !important;
        padding: 0.25rem 0.5rem !important;
    }

    .font-weight-medium {
        font-weight: 500 !important;
    }

    .gap-2>.btn+.btn {
        margin-left: 0.5rem;
    }

    #TaxId.is-invalid {
        border-color: #dc3545;
    }

    #TaxIdError {
        font-size: 0.8rem;
        margin-top: 0.25rem;
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
                            <form id="tax_rate_form" autocomplete="off">
                                <?= csrf_field(); ?>

                                <div class="form-group row align-items-center">
                                    <label for="TaxId" class="col-sm-2 col-form-label col-form-label-sm font-weight-medium text-secondary">Tax ID</label>
                                    <div class="col-sm-6">
                                        <div class="input-group input-group-sm">
                                            <input type="text"
                                                class="form-control form-control-sm"
                                                id="TaxId"
                                                name="TaxId"
                                                placeholder="Select Tax ID"
                                                value=""
                                                readonly>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-secondary btn-sm" id="btnSearch" title="Search">
                                                    <i class="bi bi-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <span class="text-danger small" id="TaxIdError" style="display:none;">Tax ID tidak boleh mengandung spasi</span>
                                    </div>
                                </div>

                                <div class="form-group row align-items-center">
                                    <label for="TaxRateName" class="col-sm-2 col-form-label col-form-label-sm font-weight-medium text-secondary">Tax Rate Name</label>
                                    <div class="col-sm-6">
                                        <input type="text"
                                            class="form-control form-control-sm"
                                            id="TaxRateName"
                                            name="TaxRateName"
                                            placeholder="Enter Tax Rate Name"
                                            value="">
                                    </div>
                                </div>

                                <div class="form-group row align-items-center">
                                    <label for="TaxRate" class="col-sm-2 col-form-label col-form-label-sm font-weight-medium text-secondary">Tax Rate</label>
                                    <div class="col-sm-6">
                                        <input type="text"
                                            class="form-control form-control-sm"
                                            id="TaxRate"
                                            name="TaxRate"
                                            placeholder="Enter Tax Rate"
                                            value=""
                                            step="0.01"
                                            min="0"
                                            max="99.99">
                                        <span class="text-danger small" id="TaxRateError" style="display:none;">Tax Rate maksimal 2 digit di belakang koma</span>
                                    </div>
                                </div>

                                <input type="hidden" id="EditLineNo" name="EditLineNo" value="">

                                <div class="row">
                                    <div class="col-12">
                                        <hr class="my-4">
                                    </div>
                                </div>

                                <div class="row" id="taxRateDetailRow" style="display: none;">
                                    <div class="col-sm-12">
                                        <label class="font-weight-medium">Tax Rate Details</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="tableTaxRateDetail" class="table table-sm table-bordered table-striped w-100" style="display: none;">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tax Rate Name</th>
                                                    <th>Line No</th>
                                                    <th>Tax Rate</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-end mt-3">
                                            <button type="button" class="btn btn-sm btn-primary mr-2" id="btnSave" style="display: none;">Add</button>
                                            <button type="button" class="btn btn-sm btn-warning mr-2" id="btnNewEntry" style="display: none;">New Entry</button>
                                            <button type="button" class="btn btn-sm btn-danger" id="btnDelete" style="display: none;">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="modalSearchTaxClass" tabindex="-1" role="dialog" aria-labelledby="modalSearchTaxClassLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSearchTaxClassLabel">
                    <i class="bi bi-search mr-2"></i>Search Tax Class
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="tableTaxClass" class="table table-sm table-bordered table-striped">
                        <thead class="table">
                            <tr>
                                <th>No</th>
                                <th>Tax ID</th>
                                <th>Tax Name</th>
                                <th>Account Tax Sales</th>
                                <th>Account Tax Purchase</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection('content'); ?>

<?= $this->section('script'); ?>

<script src="<?= base_url('plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
<script src="<?= base_url('plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('plugins/select2/js/select2.full.min.js') ?>"></script>

<script>
    $('#active-menu').html($('p#active-menu').html());
    $(document).prop("title", $('p#active-menu').html());

    $(document).ready(function() {
        let modalSearch = $('#modalSearchTaxClass').modal({
            show: false,
            backdrop: 'static'
        });

        let taxDataTable;
        let detailTable;
        let isEditing = false;
        let isDetailEdit = false;

        function initSelect2() {
            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%',
                containerCssClass: 'select2-sm'
            });
        }

        initSelect2();

        function initDetailTable() {
            if ($.fn.DataTable.isDataTable('#tableTaxRateDetail')) {
                $('#tableTaxRateDetail').DataTable().destroy();
            }

            detailTable = $('#tableTaxRateDetail').DataTable({
                processing: true,
                serverSide: false,
                responsive: true,
                autoWidth: false,
                paging: false,
                searching: false,
                ordering: false,
                info: false,
                data: [],
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'taxRateName'
                    },
                    {
                        data: 'lineNo'
                    },
                    {
                        data: 'taxRate',
                        render: function(data) {
                            if (data === null || data === undefined || data === '') return '';
                            let num = parseFloat(data);
                            if (isNaN(num)) return '';
                            return num.toFixed(2);
                        }
                    },
                    {
                        data: null,
                        className: 'text-center',
                        render: function(data, type, row) {
                            return '<button class="btn btn-info btn-sm btn-edit-detail mr-1" data-taxid="' + row.taxId + '" data-lineno="' + row.lineNo + '">Edit</button>' +
                                '<button class="btn btn-danger btn-sm btn-delete-detail" data-taxid="' + row.taxId + '" data-lineno="' + row.lineNo + '">Delete</button>';
                        }
                    }
                ],
                language: {
                    emptyTable: "Tidak ada data tax rate detail"
                }
            });

            $('#tableTaxRateDetail').hide();
        }

        function showTaxRateDetails() {
            $('#taxRateDetailRow').show();
            $('#tableTaxRateDetail').show();
            $('#btnSave').show();
            if (detailTable) {
                detailTable.columns.adjust().draw();
            }
        }

        function hideTaxRateDetails() {
            $('#taxRateDetailRow').hide();
            $('#tableTaxRateDetail').hide();
            $('#btnSave').hide();
            $('#btnDelete').hide();
            $('#btnNewEntry').hide();
        }

        function loadTaxRateDetails(taxId) {
            if (!taxId) {
                if (detailTable) {
                    detailTable.clear().draw();
                }
                hideTaxRateDetails();
                return;
            }

            $.ajax({
                url: '<?= site_url('tmsttaxrate/getTaxRateDetails') ?>',
                type: 'GET',
                data: {
                    TaxId: taxId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success && response.data && Array.isArray(response.data) && response.data.length > 0) {
                        showTaxRateDetails();
                        if (detailTable) {
                            detailTable.clear().rows.add(response.data).draw();
                        }
                    } else {
                        if (detailTable) {
                            detailTable.clear().draw();
                        }
                        showTaxRateDetails();
                    }
                },
                error: function() {
                    if (detailTable) {
                        detailTable.clear().draw();
                    }
                    showTaxRateDetails();
                }
            });
        }

        function initTaxTable() {
            if ($.fn.DataTable.isDataTable('#tableTaxClass')) {
                $('#tableTaxClass').DataTable().destroy();
            }

            taxDataTable = $('#tableTaxClass').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                ajax: {
                    url: "<?= base_url('tmsttaxrate/datatablestaxclass') ?>",
                    type: "POST",
                    contentType: "application/json",
                    data: function(d) {
                        return JSON.stringify(d);
                    }
                },
                columnDefs: [{
                        targets: [0],
                        className: 'text-center'
                    },
                    {
                        targets: [5],
                        className: 'text-center'
                    }
                ],
                columns: [{
                        data: 'rownum'
                    },
                    {
                        data: 'taxId'
                    },
                    {
                        data: 'taxName'
                    },
                    {
                        data: 'actTaxPSales'
                    },
                    {
                        data: 'actTaxPurch'
                    },
                    {
                        data: 'status'
                    }
                ],
                createdRow: function(row, data, dataIndex) {
                    if (data.encoded_data) {
                        $(row).attr('data-tax-base64', data.encoded_data);
                        $(row).addClass('cursor-pointer');
                    }
                },
                language: {
                    search: "Cari Data:",
                    searchPlaceholder: "Search...",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data",
                    infoFiltered: "(difilter dari _MAX_ total data)",
                    zeroRecords: "Data tidak ditemukan",
                    paginate: {
                        first: "Awal",
                        previous: "Sebelum",
                        next: "Berikut",
                        last: "Akhir"
                    },
                    processing: "Memuat data..."
                }
            });
        }

        function updateButtonState() {
            let taxId = $('#TaxId').val().trim();

            if (taxId) {
                checkTaxExists(taxId, false);
            } else {
                isEditing = false;
                isDetailEdit = false;
                hideTaxRateDetails();
            }
        }

        function checkTaxExists(taxId, fillForm) {
            fillForm = typeof fillForm !== 'undefined' ? fillForm : true;
            $.ajax({
                url: '<?= site_url('tmsttaxrate/fetchSingleData') ?>',
                type: 'GET',
                data: {
                    TaxId: taxId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.data) {
                        isEditing = true;
                        showTaxRateDetails();
                        $('#btnSave').text('Add').removeClass('btn-success').addClass('btn-primary').show();
                        $('#btnDelete').show();
                        $('#btnNewEntry').show();

                        if (fillForm) {
                            $('#TaxRateName').val(response.data.TaxRateName || '');
                            $('#TaxRate').val(response.data.TaxRate || '');
                        }
                    } else {
                        isEditing = false;
                        isDetailEdit = false;
                        showTaxRateDetails();
                        $('#btnSave').text('Add').removeClass('btn-success').addClass('btn-primary').show();
                        $('#btnDelete').hide();
                        $('#btnNewEntry').hide();
                    }
                },
                error: function() {
                    isEditing = false;
                    isDetailEdit = false;
                    showTaxRateDetails();
                    $('#btnSave').text('Add').removeClass('btn-success').addClass('btn-primary').show();
                    $('#btnDelete').hide();
                    $('#btnNewEntry').hide();
                }
            });
        }

        function resetForm() {
            $('#TaxId').val('');
            $('#TaxRateName').val('');
            $('#TaxRate').val('');
            $('#EditLineNo').val('');
            $('#TaxId').removeClass('is-invalid');
            $('#TaxIdError').hide();
            isEditing = false;
            isDetailEdit = false;
            hideTaxRateDetails();
            if (detailTable) {
                detailTable.clear().draw();
            }
            $('#TaxId').focus();
        }

        function resetFormAfterSave() {
            $('#TaxRate').val('');
            $('#EditLineNo').val('');
            isDetailEdit = false;
            isEditing = false;
            $('#btnSave').text('Add').removeClass('btn-success').addClass('btn-primary').show();
            $('#btnDelete').hide();
            $('#btnNewEntry').hide();
            $('#TaxId').focus();
        }

        function openTaxModal() {
            $('#modalSearchTaxClass').modal('show');
            if (!$.fn.DataTable.isDataTable('#tableTaxClass')) {
                initTaxTable();
            } else {
                $('#tableTaxClass').DataTable().ajax.reload(null, false);
            }
        }

        $('#btnSearch').on('click', function() {
            openTaxModal();
        });

        $(document).on('click', '#tableTaxClass tbody tr', function() {
            try {
                const encodedData = $(this).data('tax-base64');
                if (!encodedData) return;

                const taxData = JSON.parse(atob(encodedData));

                $('#TaxId').val(taxData.taxId || '');
                $('#TaxRateName').val(taxData.taxName || '');
                $('#TaxRate').val(taxData.taxRate || '');
                $('#EditLineNo').val('');

                checkTaxExists(taxData.taxId, false);
                loadTaxRateDetails(taxData.taxId);
                $('#modalSearchTaxClass').modal('hide');
            } catch (e) {}
        });

        $('#modalSearchTaxClass').on('hidden.bs.modal', function() {
            if ($.fn.DataTable.isDataTable('#tableTaxClass')) {
                $('#tableTaxClass').DataTable().ajax.reload(null, false);
            }
        }).on('shown.bs.modal', function() {
            if ($.fn.DataTable.isDataTable('#tableTaxClass')) {
                $('#tableTaxClass').DataTable().columns.adjust().draw();
            }
        });

        $('#TaxId').on('blur', function() {
            let taxId = $(this).val().trim();
            if (taxId) {
                checkTaxExists(taxId, true);
                loadTaxRateDetails(taxId);
            } else {
                resetForm();
            }
        });

        $(document).on('click', '.btn-edit-detail', function() {
            let taxId = $(this).data('taxid');
            let lineNo = $(this).data('lineno');

            if (!taxId || !lineNo) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Data tidak lengkap'
                });
                return;
            }

            $('#EditLineNo').val(lineNo);

            $.ajax({
                url: '<?= site_url('tmsttaxrate/getDetailData') ?>',
                type: 'GET',
                data: {
                    TaxId: taxId,
                    Line_No: lineNo
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success && response.data) {
                        $('#TaxId').val(response.data.taxId);
                        $('#TaxRateName').val(response.data.taxRateName);
                        $('#TaxRate').val(response.data.taxRate);
                        $('#EditLineNo').val(lineNo);

                        isDetailEdit = true;
                        isEditing = true;
                        showTaxRateDetails();
                        $('#btnSave').text('Save').removeClass('btn-success').addClass('btn-primary').show();
                        $('#btnDelete').show();
                        $('#btnNewEntry').show();

                        Swal.fire({
                            icon: 'info',
                            title: 'Edit Mode',
                            text: 'Silakan ubah data dan klik Save',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'Gagal mengambil data'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to connect to server'
                    });
                }
            });
        });

        $(document).on('click', '.btn-delete-detail', function() {
            let taxId = $(this).data('taxid');
            let lineNo = $(this).data('lineno');

            if (!taxId || !lineNo) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Data tidak lengkap'
                });
                return;
            }

            Swal.fire({
                title: 'Delete Detail?',
                text: 'Are you sure you want to delete this tax rate detail?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger mr-2',
                    cancelButton: 'btn btn-secondary'
                }
            }).then(function(result) {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?= site_url('tmsttaxrate/deleteDetail') ?>',
                        type: 'POST',
                        data: {
                            TaxId: taxId,
                            Line_No: lineNo
                        },
                        dataType: 'json',
                        beforeSend: function() {
                            Swal.fire({
                                title: 'Deleting...',
                                text: 'Please wait',
                                allowOutsideClick: false,
                                didOpen: function() {
                                    Swal.showLoading();
                                },
                                buttonsStyling: false
                            });
                        },
                        success: function(response) {
                            Swal.close();
                            if (response.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted',
                                    text: response.message,
                                    timer: 1500,
                                    showConfirmButton: false,
                                    buttonsStyling: false
                                });
                                loadTaxRateDetails(taxId);
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message || 'Failed to delete detail',
                                    buttonsStyling: false,
                                    customClass: {
                                        confirmButton: 'btn btn-primary'
                                    }
                                });
                            }
                        },
                        error: function() {
                            Swal.close();
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to connect to server',
                                buttonsStyling: false,
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                }
                            });
                        }
                    });
                }
            });
        });

        $('#btnNewEntry').on('click', function() {
            Swal.fire({
                title: 'New Entry?',
                text: 'Are you sure you want to create a new entry?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, New Entry',
                cancelButtonText: 'Cancel',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-primary mr-2',
                    cancelButton: 'btn btn-secondary'
                }
            }).then(function(result) {
                if (result.isConfirmed) {
                    resetForm();
                    Swal.fire({
                        icon: 'success',
                        title: 'Ready',
                        text: 'You can now add a new tax rate',
                        timer: 1500,
                        showConfirmButton: false,
                        buttonsStyling: false
                    });
                }
            });
        });

        function formatTaxRate(value) {
            value = value.replace(/[^0-9.,]/g, '');
            value = value.replace(/,/g, '.');
            var parts = value.split('.');
            if (parts.length > 2) {
                value = parts[0] + '.' + parts.slice(1).join('');
                parts = value.split('.');
            }
            if (parts.length >= 1) {
                var intPart = parts[0];
                if (intPart.length > 2) {
                    intPart = intPart.substring(0, 2);
                }
                parts[0] = intPart;
            }
            if (parts.length === 2) {
                var decPart = parts[1];
                if (decPart.length > 2) {
                    decPart = decPart.substring(0, 2);
                }
                parts[1] = decPart;
            }
            value = parts.join('.');
            if (value.endsWith('.')) {
                value = value.slice(0, -1);
            }
            return value;
        }

        function validateTaxRate(value) {
            if (!value) return true;
            var num = parseFloat(value);
            if (isNaN(num)) return false;
            if (num < 0 || num > 99.99) return false;
            var parts = value.split('.');
            if (parts.length === 2 && parts[1].length > 2) return false;
            if (parts.length >= 1 && parts[0].length > 2) return false;
            return true;
        }

        $('#TaxRate').on('input', function() {
            var value = $(this).val();
            var formatted = formatTaxRate(value);
            $(this).val(formatted);
            if (formatted && !validateTaxRate(formatted)) {
                $(this).addClass('is-invalid');
                $('#TaxRateError').show();
            } else {
                $(this).removeClass('is-invalid');
                $('#TaxRateError').hide();
            }
        });

        $('#TaxRate').on('blur', function() {
            var value = $(this).val();
            if (value) {
                var num = parseFloat(value);
                if (!isNaN(num) && num >= 0 && num <= 99.99) {
                    $(this).val(num.toString());
                    $(this).removeClass('is-invalid');
                    $('#TaxRateError').hide();
                }
            }
        });

        $('#TaxRate').on('keydown', function(e) {
            var key = e.key;
            if ([8, 9, 37, 38, 39, 40, 46, 35, 36].includes(e.keyCode)) {
                return;
            }
            if (!/[0-9.,]/.test(key)) {
                e.preventDefault();
                return;
            }
            var value = $(this).val();
            var parts = value.split('.');
            if ((key === '.' || key === ',') && parts.length >= 2) {
                e.preventDefault();
                return;
            }
            if (parts.length === 2 && parts[1].length >= 2 && key !== '.' && key !== ',') {
                e.preventDefault();
                return;
            }
            if (parts.length === 1 && parts[0].length >= 2 && key !== '.' && key !== ',') {
                e.preventDefault();
                return;
            }
        });

        $('#btnSave').on('click', function() {
            var taxId = $('#TaxId').val().trim();
            var taxRateName = $('#TaxRateName').val().trim();
            var taxRate = $('#TaxRate').val();
            var editLineNo = $('#EditLineNo').val();

            if (!taxId) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Tax ID is required',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
                return;
            }

            if (!taxRateName) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Tax Rate Name is required',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
                return;
            }

            if (!taxRate) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Tax Rate is required',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
                return;
            }

            var taxRateValue = parseFloat(taxRate);
            if (isNaN(taxRateValue)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Tax Rate harus berupa angka',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
                return;
            }

            if (taxRateValue < 0 || taxRateValue > 99.99) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Tax Rate hanya boleh antara 0 - 99.99',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
                return;
            }

            var parts = taxRate.toString().split('.');
            if (parts.length === 2 && parts[1].length > 2) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Tax Rate hanya boleh 2 digit di belakang koma',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
                return;
            }

            var isUpdate = (editLineNo && editLineNo !== '' && editLineNo !== 'undefined' && editLineNo !== null);
            var actionText = isUpdate ? 'Update' : 'Add';

            Swal.fire({
                title: actionText + ' Tax Rate?',
                text: 'Are you sure you want to ' + actionText.toLowerCase() + ' this tax rate?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, ' + actionText,
                cancelButtonText: 'Cancel',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-primary mr-2',
                    cancelButton: 'btn btn-secondary'
                }
            }).then(function(result) {
                if (result.isConfirmed) {
                    saveTaxRate(taxId, taxRateName, taxRate, editLineNo);
                }
            });
        });

        function saveTaxRate(taxId, taxRateName, taxRate, editLineNo) {
            var lineNoValue = parseInt(editLineNo);
            var isUpdate = !isNaN(lineNoValue) && lineNoValue > 0;

            var postData = {
                TaxId: taxId,
                TaxRateName: taxRateName,
                TaxRate: taxRate
            };

            if (isUpdate) {
                postData.action = 'Update';
                postData.LineNo = lineNoValue;
            } else {
                postData.action = 'Add';
            }

            $.ajax({
                url: '<?= site_url('tmsttaxrate/action') ?>',
                type: 'POST',
                data: postData,
                dataType: 'json',
                beforeSend: function() {
                    Swal.fire({
                        title: 'Saving...',
                        text: 'Please wait',
                        allowOutsideClick: false,
                        didOpen: function() {
                            Swal.showLoading();
                        },
                        buttonsStyling: false
                    });
                },
                success: function(response) {
                    Swal.close();
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false,
                            buttonsStyling: false
                        });
                        if ($('#modalSearchTaxClass').hasClass('show') && $.fn.DataTable.isDataTable('#tableTaxClass')) {
                            $('#tableTaxClass').DataTable().ajax.reload(null, false);
                        }
                        loadTaxRateDetails(taxId);
                        resetFormAfterSave();
                    } else if (response.error) {
                        var errorMsg = '';
                        $.each(response.error, function(key, value) {
                            errorMsg += value + '\n';
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            text: errorMsg,
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'Failed to save tax rate',
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            }
                        });
                    }
                },
                error: function() {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to connect to server',
                        buttonsStyling: false,
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        }
                    });
                }
            });
        }

        $('#btnDelete').on('click', function() {
            var taxId = $('#TaxId').val().trim();

            if (!taxId) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Please select a tax rate to delete',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
                return;
            }

            Swal.fire({
                title: 'Delete Tax Rate?',
                text: 'Are you sure you want to delete this tax rate?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger mr-2',
                    cancelButton: 'btn btn-secondary'
                }
            }).then(function(result) {
                if (result.isConfirmed) {
                    deleteTaxRate(taxId);
                }
            });
        });

        function deleteTaxRate(taxId) {
            $.ajax({
                url: '<?= site_url('tmsttaxrate/action') ?>',
                type: 'POST',
                data: {
                    action: 'Delete',
                    TaxId: taxId
                },
                dataType: 'json',
                beforeSend: function() {
                    Swal.fire({
                        title: 'Deleting...',
                        text: 'Please wait',
                        allowOutsideClick: false,
                        didOpen: function() {
                            Swal.showLoading();
                        },
                        buttonsStyling: false
                    });
                },
                success: function(response) {
                    Swal.close();
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false,
                            buttonsStyling: false
                        });
                        resetForm();
                        if ($('#modalSearchTaxClass').hasClass('show') && $.fn.DataTable.isDataTable('#tableTaxClass')) {
                            $('#tableTaxClass').DataTable().ajax.reload(null, false);
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'Failed to delete tax rate',
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            }
                        });
                    }
                },
                error: function() {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to connect to server',
                        buttonsStyling: false,
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        }
                    });
                }
            });
        }

        $('#tax_rate_form').on('submit', function(e) {
            e.preventDefault();
        });

        initDetailTable();
        resetForm();
    });
</script>

<?= $this->endSection('script'); ?>