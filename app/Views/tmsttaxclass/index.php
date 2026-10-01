<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="<?= base_url('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') ?>">
<style>
    #tableTaxClass tbody tr {
        cursor: pointer;
        transition: background-color 0.2s;
    }

    #tableTaxClass tbody tr:hover {
        background-color: #e9ecef !important;
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

    .form-check-input {
        margin-top: 0.25rem !important;
    }

    .form-check-label {
        font-size: 0.875rem !important;
    }

    .font-weight-medium {
        font-weight: 500 !important;
    }

    .gap-2>.btn+.btn {
        margin-left: 0.5rem;
    }
</style>
<?= $this->endSection('style'); ?>

<?= $this->section('content'); ?>

<?php
$session = session();
?>

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
                            <form id="tax_class_form" autocomplete="off">
                                <?= csrf_field(); ?>

                                <div class="form-group row align-items-center">
                                    <label for="TaxId" class="col-sm-2 col-form-label col-form-label-sm font-weight-medium text-secondary">Tax ID</label>
                                    <div class="col-sm-6">
                                        <div class="input-group input-group-sm">
                                            <input type="text"
                                                class="form-control form-control-sm"
                                                id="TaxId"
                                                name="TaxId"
                                                placeholder="Enter Tax ID"
                                                value="">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-secondary btn-sm" id="btnSearch" title="Search">
                                                    <i class="bi bi-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row align-items-center">
                                    <label for="TaxName" class="col-sm-2 col-form-label col-form-label-sm font-weight-medium text-secondary">Tax Name</label>
                                    <div class="col-sm-6">
                                        <input type="text"
                                            class="form-control form-control-sm"
                                            id="TaxName"
                                            name="TaxName"
                                            placeholder="Enter Tax Name"
                                            value="">
                                    </div>
                                </div>

                                <div class="form-group row align-items-center">
                                    <label for="ActTaxPSales" class="col-sm-2 col-form-label col-form-label-sm font-weight-medium text-secondary">Account Tax Sales</label>
                                    <div class="col-sm-6">
                                        <?= str_replace('form-control form-control-sm ', '', $cb_account_tax_sales) ?>
                                    </div>
                                </div>

                                <div class="form-group row align-items-center">
                                    <label for="ActTaxPurch" class="col-sm-2 col-form-label col-form-label-sm font-weight-medium text-secondary">Account Tax Purchase</label>
                                    <div class="col-sm-6">
                                        <?= str_replace('form-control form-control-sm ', '', $cb_account_tax_purchase) ?>
                                    </div>
                                </div>

                                <div class="form-group row align-items-center">
                                    <label for="Isactive" class="col-sm-2 col-form-label col-form-label-sm font-weight-medium text-secondary">Status</label>
                                    <div class="col-sm-6">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="Isactive" name="Isactive" checked>
                                            <label class="form-check-label" for="Isactive">Active</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <hr class="my-4">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-sm btn-primary mr-2" id="btnSave">Add</button>
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

<div class="modal fade" id="modalSearchTax" tabindex="-1" role="dialog" aria-labelledby="modalSearchTaxLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSearchTaxLabel">
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
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection('content'); ?>

<?= $this->section('script'); ?>

<script src="<?= base_url('plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
<script src="<?= base_url('plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>

<script>
    $('#active-menu').html($('p#active-menu').html()); // set top navbar
    $(document).prop("title", $('p#active-menu').html()); // set title
</script>

<script>
    $(document).ready(function() {
        let modalSearch = $('#modalSearchTax').modal({
            show: false,
            backdrop: 'static'
        });

        let taxDataTable;
        let isEditing = false;

        function initSelect2() {
            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%',
                containerCssClass: 'select2-sm'
            });
        }

        initSelect2();

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
                    url: "<?= base_url('tmsttaxclass/datatables') ?>",
                    type: "POST",
                    contentType: "application/json",
                    data: function(d) {
                        return JSON.stringify(d);
                    }
                },
                columnDefs: [{
                    targets: [0],
                    className: 'text-center'
                }],
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
                $('#btnSave')
                    .text('Add')
                    .removeClass('btn-success')
                    .addClass('btn-primary');
                $('#btnDelete').hide();
                $('#btnNewEntry').hide();
            }
        }

        function checkTaxExists(taxId, fillForm = true) {
            $.ajax({
                url: '<?= site_url('tmsttaxclass/fetchSingleData') ?>',
                type: 'GET',
                data: {
                    TaxId: taxId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.data) {
                        isEditing = true;
                        $('#btnSave')
                            .text('Save')
                            .removeClass('btn-success')
                            .addClass('btn-primary');
                        $('#btnDelete').show();
                        $('#btnNewEntry').show();

                        if (fillForm) {
                            $('#TaxName').val(response.data.TaxName || '');
                            $('#ActTaxPSales').val(response.data.ActTaxPSales || '').trigger('change');
                            $('#ActTaxPurch').val(response.data.ActTaxPurch || '').trigger('change');
                            $('#Isactive').prop('checked', response.data.IsactiveChecked === true);
                        }
                    } else {
                        isEditing = false;
                        $('#btnSave')
                            .text('Add')
                            .removeClass('btn-success')
                            .addClass('btn-primary');
                        $('#btnDelete').hide();
                        $('#btnNewEntry').hide();
                    }
                },
                error: function() {
                    isEditing = false;
                    $('#btnSave')
                        .text('Add')
                        .removeClass('btn-success')
                        .addClass('btn-primary');
                    $('#btnDelete').hide();
                    $('#btnNewEntry').hide();
                }
            });
        }

        function resetForm() {
            $('#TaxId').val('');
            $('#TaxName').val('');
            $('#ActTaxPSales').val('').trigger('change');
            $('#ActTaxPurch').val('').trigger('change');
            $('#Isactive').prop('checked', true);
            isEditing = false;
            $('#btnSave')
                .text('Add')
                .removeClass('btn-success')
                .addClass('btn-primary');
            $('#btnDelete').hide();
            $('#btnNewEntry').hide();
        }

        function openTaxModal() {
            $('#modalSearchTax').modal('show');
            if (!$.fn.DataTable.isDataTable('#tableTaxClass')) {
                initTaxTable();
            } else {
                $('#tableTaxClass').DataTable().ajax.reload(null, false);
            }
        }

        $('#btnSearch').on('click', function() {
            openTaxModal();
        });

        $('#TaxId').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                $('#btnSearch').click();
            }
        });

        $(document).on('click', '#tableTaxClass tbody tr', function() {
            try {
                const encodedData = $(this).data('tax-base64');
                if (!encodedData) return;

                const taxData = JSON.parse(atob(encodedData));

                $('#TaxId').val(taxData.taxId || '');
                $('#TaxName').val(taxData.taxName || '');
                $('#ActTaxPSales').val(taxData.actTaxPSales || '').trigger('change');
                $('#ActTaxPurch').val(taxData.actTaxPurch || '').trigger('change');

                let isActive = taxData.isactive;
                if (typeof isActive === 'boolean') {
                    $('#Isactive').prop('checked', isActive);
                } else if (typeof isActive === 'number') {
                    $('#Isactive').prop('checked', isActive === 1);
                } else if (typeof isActive === 'string') {
                    $('#Isactive').prop('checked', isActive.toLowerCase() === 'active' || isActive === '1' || isActive === 'true');
                }

                checkTaxExists(taxData.taxId, false);
                $('#modalSearchTax').modal('hide');
            } catch (e) {
                console.error('Selection error:', e);
            }
        });

        $('#modalSearchTax').on('hidden.bs.modal', function() {
            if ($.fn.DataTable.isDataTable('#tableTaxClass')) {
                $('#tableTaxClass').DataTable().ajax.reload(null, false);
            }
        }).on('shown.bs.modal', function() {
            if ($.fn.DataTable.isDataTable('#tableTaxClass')) {
                $('#tableTaxClass').DataTable().columns.adjust().draw();
            }
        });

        $('#TaxId').on('keydown', function(e) {
            if (e.key === ' ' || e.key === 'Space') {
                e.preventDefault();
                return false;
            }
        });

        $('#TaxId').on('input', function() {
            let value = $(this).val();
            let cleanValue = value.replace(/\s/g, '');
            if (value !== cleanValue) {
                $(this).val(cleanValue);
                $(this).addClass('is-invalid');
                $('#TaxIdError').text('Tax ID tidak boleh mengandung spasi').show();
            } else {
                $(this).removeClass('is-invalid');
                $('#TaxIdError').hide();
            }
        });

        $('#TaxId').on('blur', function() {
            let value = $(this).val();
            let cleanValue = value.replace(/\s/g, '');
            if (value !== cleanValue) {
                $(this).val(cleanValue);
                $(this).addClass('is-invalid');
                $('#TaxIdError').text('Tax ID tidak boleh mengandung spasi').show();
            } else {
                $(this).removeClass('is-invalid');
                $('#TaxIdError').hide();
            }
        });

        $('#TaxId').on('paste', function(e) {
            e.preventDefault();
            let pastedText = (e.originalEvent || e).clipboardData.getData('text/plain');
            let cleanText = pastedText.replace(/\s/g, '');
            $(this).val(cleanText);
            if (cleanText !== pastedText) {
                $(this).addClass('is-invalid');
                $('#TaxIdError').text('Tax ID tidak boleh mengandung spasi').show();
            }
        });

        $('#btnNewEntry').on('click', function() {
            Swal.fire({
                title: 'New Entry?',
                text: 'Are you sure you want to create a new entry? Current form data will be cleared.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, New Entry',
                cancelButtonText: 'Cancel',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-primary mr-2',
                    cancelButton: 'btn btn-secondary'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    resetForm();
                    Swal.fire({
                        icon: 'success',
                        title: 'Ready',
                        text: 'Form is ready for new entry',
                        timer: 1500,
                        showConfirmButton: false,
                        buttonsStyling: false
                    });
                }
            });
        });

        $('#btnSave').on('click', function() {
            let taxId = $('#TaxId').val().trim();
            let taxName = $('#TaxName').val().trim();
            let actTaxPSales = $('#ActTaxPSales').val();
            let actTaxPurch = $('#ActTaxPurch').val();
            let isactive = $('#Isactive').is(':checked');

            if (taxId.includes(' ')) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Tax ID tidak boleh mengandung spasi',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
                $('#TaxId').addClass('is-invalid');
                $('#TaxIdError').text('Tax ID tidak boleh mengandung spasi').show();
                return;
            }

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

            if (!taxName) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Tax Name is required',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
                return;
            }

            let actionText = isEditing ? 'Update' : 'Add';

            Swal.fire({
                title: actionText + ' Tax Class?',
                text: 'Are you sure you want to ' + actionText.toLowerCase() + ' this tax class?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, ' + actionText,
                cancelButtonText: 'Cancel',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-primary mr-2',
                    cancelButton: 'btn btn-secondary'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    saveTaxClass(taxId, taxName, actTaxPSales, actTaxPurch, isactive);
                }
            });
        });

        function saveTaxClass(taxId, taxName, actTaxPSales, actTaxPurch, isactive) {
            let isactiveValue = isactive ? true : false;

            $.ajax({
                url: '<?= site_url('tmsttaxclass/action') ?>',
                type: 'POST',
                data: {
                    action: 'Save',
                    TaxId: taxId,
                    TaxName: taxName,
                    ActTaxPSales: actTaxPSales,
                    ActTaxPurch: actTaxPurch,
                    Isactive: isactiveValue
                },
                dataType: 'json',
                beforeSend: function() {
                    Swal.fire({
                        title: 'Saving...',
                        text: 'Please wait',
                        allowOutsideClick: false,
                        didOpen: () => {
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

                        if ($('#modalSearchTax').hasClass('show') && $.fn.DataTable.isDataTable('#tableTaxClass')) {
                            $('#tableTaxClass').DataTable().ajax.reload(null, false);
                        }

                        updateButtonState();
                    } else if (response.error) {
                        let errorMsg = '';
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
                            text: response.message || 'Failed to save tax class',
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
            let taxId = $('#TaxId').val().trim();

            if (!taxId) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Please select a tax class to delete',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
                return;
            }

            Swal.fire({
                title: 'Delete Tax Class?',
                text: 'Are you sure you want to delete this tax class?',
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
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteTaxClass(taxId);
                }
            });
        });

        function deleteTaxClass(taxId) {
            $.ajax({
                url: '<?= site_url('tmsttaxclass/action') ?>',
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
                        didOpen: () => {
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

                        if ($('#modalSearchTax').hasClass('show') && $.fn.DataTable.isDataTable('#tableTaxClass')) {
                            $('#tableTaxClass').DataTable().ajax.reload(null, false);
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'Failed to delete tax class',
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

        $('#tax_class_form').on('submit', function(e) {
            e.preventDefault();
        });

        resetForm();
    });
</script>

<?= $this->endSection('script'); ?>