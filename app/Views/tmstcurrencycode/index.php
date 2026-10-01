<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="<?= base_url('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">
<style>
    /* Bootstrap 4 custom spacing */
    .gap-2>.btn+.btn {
        margin-left: 0.5rem;
    }

    .fw-medium {
        font-weight: 500;
    }

    .cursor-pointer {
        cursor: pointer;
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
                            <form id="currency_form" autocomplete="off">
                                <?= csrf_field(); ?>

                                <!-- Form Input dengan Bootstrap 4 -->
                                <div class="form-group row align-items-center">
                                    <label for="CurrencyCode" class="col-sm-2 col-form-label font-weight-medium text-secondary">Currency Code</label>
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <input type="text"
                                                class="form-control form-control-sm"
                                                id="CurrencyCode"
                                                name="CurrencyCode"
                                                placeholder="Enter Currency Code"
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
                                    <label for="CurrencyName" class="col-sm-2 col-form-label font-weight-medium text-secondary">Currency Name</label>
                                    <div class="col-sm-4">
                                        <input type="text"
                                            class="form-control form-control-sm"
                                            id="CurrencyName"
                                            name="CurrencyName"
                                            placeholder="Enter Currency Name"
                                            value="">
                                    </div>
                                </div>

                                <div class="form-group row align-items-center">
                                    <label for="Symbol" class="col-sm-2 col-form-label font-weight-medium text-secondary">Symbol</label>
                                    <div class="col-sm-4">
                                        <input type="text"
                                            class="form-control form-control-sm"
                                            id="Symbol"
                                            name="Symbol"
                                            placeholder="Enter Currency Symbol"
                                            value="">
                                    </div>
                                </div>

                                <!-- Separator -->
                                <div class="row">
                                    <div class="col-12">
                                        <hr class="my-4">
                                    </div>
                                </div>

                                <!-- Action Buttons dengan Bootstrap 4 -->
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

<!-- Modal Search -->
<div class="modal fade" id="modalSearchCurrency" tabindex="-1" role="dialog" aria-labelledby="modalSearchCurrencyLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSearchCurrencyLabel">
                    <i class="bi bi-search mr-2"></i>Search Currency
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="tableCurrency" class="table table-sm table-bordered table-striped">
                        <thead class="table">
                            <tr>
                                <th>No</th>
                                <th>Currency Code</th>
                                <th>Currency Name</th>
                                <th>Symbol</th>
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
<script src="<?= base_url('plugins/select2/js/select2.full.min.js') ?>"></script>

<script>
    $('#active-menu').html($('p#active-menu').html());
    $(document).prop("title", $('p#active-menu').html());

    $(document).ready(function() {
        let modalSearch = $('#modalSearchCurrency').modal({
            show: false,
            backdrop: 'static'
        });

        let currencyDataTable;
        let isEditing = false;

        function initCurrencyTable() {
            if ($.fn.DataTable.isDataTable('#tableCurrency')) {
                $('#tableCurrency').DataTable().destroy();
            }

            currencyDataTable = $('#tableCurrency').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                ajax: {
                    url: "<?= base_url('tmstcurrencycode/datatables') ?>",
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
                        data: 'currencyCode'
                    },
                    {
                        data: 'currencyName'
                    },
                    {
                        data: 'symbol'
                    }
                ],
                createdRow: function(row, data, dataIndex) {
                    if (data.encoded_data) {
                        $(row).attr('data-currency-base64', data.encoded_data);
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
            let currencyCode = $('#CurrencyCode').val().trim();

            if (currencyCode) {
                checkCurrencyExists(currencyCode, false);
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

        function checkCurrencyExists(code, fillForm = true) {
            $.ajax({
                url: '<?= site_url('tmstcurrencycode/fetchSingleData') ?>',
                type: 'GET',
                data: {
                    CurrencyCode: code
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
                            $('#CurrencyName').val(response.data.CurrencyName || '');
                            $('#Symbol').val(response.data.Symbol || '');
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
            $('#CurrencyCode').val('');
            $('#CurrencyName').val('');
            $('#Symbol').val('');
            isEditing = false;
            $('#btnSave')
                .text('Add')
                .removeClass('btn-success')
                .addClass('btn-primary');
            $('#btnDelete').hide();
            $('#btnNewEntry').hide();
        }

        function openCurrencyModal() {
            $('#modalSearchCurrency').modal('show');
            if (!$.fn.DataTable.isDataTable('#tableCurrency')) {
                initCurrencyTable();
            }
        }

        $('#btnSearch').on('click', function() {
            openCurrencyModal();
        });

        $(document).on('click', '#tableCurrency tbody tr', function() {
            try {
                const encodedData = $(this).data('currency-base64');
                if (!encodedData) return;

                const currencyData = JSON.parse(atob(encodedData));

                $('#CurrencyCode').val(currencyData.currencyCode || '');
                $('#CurrencyName').val(currencyData.currencyName || '');
                $('#Symbol').val(currencyData.symbol || '');

                checkCurrencyExists(currencyData.currencyCode, false);

                $('#modalSearchCurrency').modal('hide');
            } catch (e) {
                console.error('Selection error:', e);
            }
        });

        $('#modalSearchCurrency').on('hidden.bs.modal', function() {
            if ($.fn.DataTable.isDataTable('#tableCurrency')) {
                $('#tableCurrency').DataTable().ajax.reload(null, false);
            }
        }).on('shown.bs.modal', function() {
            if ($.fn.DataTable.isDataTable('#tableCurrency')) {
                $('#tableCurrency').DataTable().columns.adjust().draw();
            }
        });

        $('#CurrencyCode').on('input', function() {
            updateButtonState();
        });

        $('#CurrencyCode').on('blur', function() {
            let code = $(this).val().trim();
            if (code) {
                checkCurrencyExists(code, true);
            } else {
                resetForm();
            }
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
            }).then((result) => {
                if (result.isConfirmed) {
                    resetForm();
                    $('#CurrencyCode').focus();
                    Swal.fire({
                        icon: 'success',
                        title: 'Ready',
                        text: 'You can now add a new currency',
                        timer: 1500,
                        showConfirmButton: false,
                        buttonsStyling: false
                    });
                }
            });
        });

        $('#btnSave').on('click', function() {
            let currencyCode = $('#CurrencyCode').val().trim();
            let currencyName = $('#CurrencyName').val().trim();
            let symbol = $('#Symbol').val().trim();

            if (!currencyCode) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Currency Code is required',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
                return;
            }

            if (!currencyName) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Currency Name is required',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
                return;
            }

            let actionText = isEditing ? 'Update' : 'Add';

            Swal.fire({
                title: actionText + ' Currency?',
                text: 'Are you sure you want to ' + actionText.toLowerCase() + ' this currency?',
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
                    saveCurrency(currencyCode, currencyName, symbol);
                }
            });
        });

        function saveCurrency(code, name, symbol) {
            $.ajax({
                url: '<?= site_url('tmstcurrencycode/action') ?>',
                type: 'POST',
                data: {
                    action: 'Save',
                    CurrencyCode: code,
                    CurrencyName: name,
                    Symbol: symbol
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

                        if ($('#modalSearchCurrency').hasClass('show') && $.fn.DataTable.isDataTable('#tableCurrency')) {
                            $('#tableCurrency').DataTable().ajax.reload(null, false);
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
                            text: response.message || 'Failed to save currency',
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
            let currencyCode = $('#CurrencyCode').val().trim();

            if (!currencyCode) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Please select a currency to delete',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
                return;
            }

            Swal.fire({
                title: 'Delete Currency?',
                text: 'Are you sure you want to delete this currency?',
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
                    deleteCurrency(currencyCode);
                }
            });
        });

        function deleteCurrency(code) {
            $.ajax({
                url: '<?= site_url('tmstcurrencycode/action') ?>',
                type: 'POST',
                data: {
                    action: 'Delete',
                    CurrencyCode: code
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

                        if ($('#modalSearchCurrency').hasClass('show') && $.fn.DataTable.isDataTable('#tableCurrency')) {
                            $('#tableCurrency').DataTable().ajax.reload(null, false);
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'Failed to delete currency',
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

        $('#currency_form').on('submit', function(e) {
            e.preventDefault();
        });

        resetForm();
    });
</script>

<?= $this->endSection('script'); ?>