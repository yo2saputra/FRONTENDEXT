<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="<?= base_url('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">
<style>
    #tableTaxGroupHeader tbody tr {
        cursor: pointer;
        transition: background-color 0.2s;
    }

    #tableTaxGroupHeader tbody tr:hover {
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

    .select2-sm {
        font-size: 0.875rem !important;
    }

    .select2-container--bootstrap4 .select2-selection--single {
        height: calc(1.8125rem + 2px) !important;
    }

    .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
        line-height: calc(1.8125rem + 2px) !important;
    }

    .detail-table tbody tr.selected {
        background-color: #cce5ff !important;
    }

    .btn-icon-sm {
        padding: 0.2rem 0.4rem !important;
        font-size: 0.75rem !important;
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
                            <form id="tax_group_form" autocomplete="off">
                                <?= csrf_field(); ?>

                                <div class="form-group row align-items-center">
                                    <label for="TaxGroup" class="col-sm-2 col-form-label col-form-label-sm font-weight-medium text-secondary">Tax Group</label>
                                    <div class="col-sm-6">
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control form-control-sm" id="TaxGroup" name="TaxGroup" placeholder="Enter Tax Group">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-secondary btn-sm" id="btnSearchGroup" title="Search">
                                                    <i class="bi bi-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row align-items-center">
                                    <label for="TaxGroupName" class="col-sm-2 col-form-label col-form-label-sm font-weight-medium text-secondary">Tax Group Name</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-sm" id="TaxGroupName" name="TaxGroupName" placeholder="Enter Tax Group Name" value="">
                                    </div>
                                </div>

                                <div class="form-group row align-items-center">
                                    <label for="cb_tax_type" class="col-sm-2 col-form-label col-form-label-sm font-weight-medium text-secondary">Tax Type</label>
                                    <div class="col-sm-6">
                                        <?= $cb_tax_type ?>
                                    </div>
                                </div>

                                <div class="form-group row align-items-center">
                                    <label class="col-sm-2 col-form-label col-form-label-sm font-weight-medium text-secondary">Status</label>
                                    <div class="col-sm-6">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="Status" name="Status" checked>
                                            <label class="form-check-label" for="Status">Active</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <hr class="my-4">
                                        <h6 class="text-info font-weight-bold">Detail - Tax Rate List</h6>
                                    </div>
                                </div>

                                <div class="card bg-light mb-3">
                                    <div class="card-body p-3">
                                        <div class="form-row">
                                            <div class="form-group col-md-4 mb-0">
                                                <label for="cb_tax_id" class="small font-weight-medium text-secondary">Tax ID</label>
                                                <?= $cb_tax_id ?>
                                            </div>
                                            <div class="form-group col-md-3 mb-0">
                                                <label for="cb_tax_group_line_no" class="small font-weight-medium text-secondary">Tax Line</label>
                                                <?= $cb_tax_group_line_no ?>
                                            </div>
                                            <div class="form-group col-md-3 mb-0">
                                                <label for="cb_tax_group_rate_type" class="small font-weight-medium text-secondary">Tax Rate (%)</label>
                                                <?= $cb_tax_group_rate_type ?>
                                            </div>
                                            <div class="form-group col-md-2 mb-0 d-flex align-items-end">
                                                <button type="button" class="btn btn-success btn-sm btn-block" id="btnAddLine">
                                                    <i class="bi bi-plus-circle"></i> Add Line
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive mb-3">
                                    <table class="table table-bordered table-hover table-sm detail-table" id="taxRateTable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th style="width: 40px;">No</th>
                                                <th>Tax ID</th>
                                                <th>Tax Line</th>
                                                <th>Tax Rate (%)</th>
                                                <th style="width: 100px;" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="taxRateTableBody"></tbody>
                                    </table>
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

<div class="modal fade" id="modalSearchTaxGroupHeader" tabindex="-1" role="dialog" aria-labelledby="modalSearchTaxGroupHeaderLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSearchTaxGroupHeaderLabel">
                    <i class="bi bi-search mr-2"></i>Search Tax Group
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="tableTaxGroupHeader" class="table table-sm table-bordered table-striped">
                        <thead class="table">
                            <tr>
                                <th>No</th>
                                <th>Tax Group</th>
                                <th>Tax Group Name</th>
                                <th>Tax Type</th>
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
        let isEditing = false;
        let taxRateDetails = [];
        let editDetailId = null;
        let selectedRow = null;

        function initSelect2() {
            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%',
                containerCssClass: 'select2-sm'
            });
        }
        initSelect2();

        function renderDetailTable() {
            let html = '';
            taxRateDetails.forEach((item, index) => {
                let rateDisplay = parseFloat(item.rate).toFixed(8);
                html += '<tr data-id="' + item.id + '">' +
                    '<td>' + (index + 1) + '</td>' +
                    '<td>' + item.taxId + '</td>' +
                    '<td>' + item.taxLine + '</td>' +
                    '<td>' + rateDisplay + '</td>' +
                    '<td class="text-center">' +
                    '<button type="button" class="btn btn-warning btn-icon-sm" onclick="editDetail(' + item.id + ')" title="Edit">' +
                    '<i class="bi bi-pencil"></i>' +
                    '</button>' +
                    '<button type="button" class="btn btn-danger btn-icon-sm" onclick="deleteDetail(' + item.id + ')" title="Delete">' +
                    '<i class="bi bi-trash"></i>' +
                    '</button>' +
                    '</td>' +
                    '</tr>';
            });
            $('#taxRateTableBody').html(html);
        }

        renderDetailTable();

        function clearDetailForm() {
            $('#cb_tax_id').val('').trigger('change');
            $('#cb_tax_group_line_no').html('<option value="">--Select Line No--</option>').trigger('change');
            $('#cb_tax_group_rate_type').html('<option value="">--Select Rate Type--</option>').trigger('change');
            editDetailId = null;
            $('#btnAddLine').html('<i class="bi bi-plus-circle"></i> Add Line');
        }

        function loadLineNo(taxId, callback) {
            if (!taxId) {
                $('#cb_tax_group_line_no').html('<option value="">--Select Line No--</option>');
                $('#cb_tax_group_rate_type').html('<option value="">--Select Rate Type--</option>');
                if (callback) callback();
                return;
            }

            $.ajax({
                url: '<?= site_url('tmsttaxgroup/getLineNoDropdown') ?>',
                type: 'GET',
                data: {
                    TaxId: taxId
                },
                dataType: 'json',
                success: function(response) {
                    let options = '<option value="">--Select Line No--</option>';
                    if (response.success && response.data) {
                        $.each(response.data, function(key, val) {
                            options += '<option value="' + val.value + '">' + val.desc + '</option>';
                        });
                    }
                    $('#cb_tax_group_line_no').html(options);
                    if (callback) callback();
                },
                error: function() {
                    if (callback) callback();
                }
            });
        }

        function loadRateType(taxId, lineNo, callback, selectedValue) {
            if (!taxId || !lineNo) {
                $('#cb_tax_group_rate_type').html('<option value="">--Select Rate Type--</option>');
                if (callback) callback();
                return;
            }

            $.ajax({
                url: '<?= site_url('tmsttaxgroup/getRateTypeDropdown') ?>',
                type: 'GET',
                data: {
                    TaxId: taxId,
                    Line_No: lineNo
                },
                dataType: 'json',
                success: function(response) {
                    let options = '<option value="">--Select Rate Type--</option>';
                    if (response.success && response.data) {
                        $.each(response.data, function(key, val) {
                            var selected = (selectedValue && val.value == selectedValue) ? 'selected' : '';
                            options += '<option value="' + val.value + '" ' + selected + '>' + val.desc + '</option>';
                        });
                    }
                    $('#cb_tax_group_rate_type').html(options);
                    if (callback) callback();
                },
                error: function() {
                    if (callback) callback();
                }
            });
        }

        $(document).on('change', '#cb_tax_id', function() {
            let taxId = $(this).val();
            loadLineNo(taxId);
        });

        $(document).on('change', '#cb_tax_group_line_no', function() {
            let taxId = $('#cb_tax_id').val();
            let lineNo = $(this).val();
            loadRateType(taxId, lineNo);
        });

        $('#btnAddLine').on('click', function() {
            const taxId = $('#cb_tax_id').val();
            const lineNo = $('#cb_tax_group_line_no').val();
            const rate = $('#cb_tax_group_rate_type').val();

            if (!taxId || !lineNo || !rate) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Please select tax id, line no and rate type',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
                return;
            }

            const isDuplicate = taxRateDetails.some(function(item) {
                return item.taxLine === lineNo;
            });

            if (isDuplicate && !editDetailId) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Line No ' + lineNo + ' already exists. Please use a different Line No.',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
                return;
            }

            if (editDetailId) {
                const isDuplicateEdit = taxRateDetails.some(function(item) {
                    return item.taxLine === lineNo && item.id !== editDetailId;
                });

                if (isDuplicateEdit) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: 'Line No ' + lineNo + ' already exists. Please use a different Line No.',
                        buttonsStyling: false,
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        }
                    });
                    return;
                }
            }

            if (editDetailId) {
                const index = taxRateDetails.findIndex(item => item.id === editDetailId);
                if (index !== -1) {
                    taxRateDetails[index] = {
                        ...taxRateDetails[index],
                        taxId: taxId,
                        taxLine: lineNo,
                        rate: rate
                    };
                }
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Line updated successfully',
                    timer: 1500,
                    showConfirmButton: false,
                    buttonsStyling: false
                });
            } else {
                const newId = taxRateDetails.length > 0 ? Math.max(...taxRateDetails.map(item => item.id)) + 1 : 1;
                taxRateDetails.push({
                    id: newId,
                    taxId: taxId,
                    taxLine: lineNo,
                    rate: rate
                });
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Line added successfully',
                    timer: 1500,
                    showConfirmButton: false,
                    buttonsStyling: false
                });
            }

            renderDetailTable();
            clearDetailForm();
        });

        window.editDetail = function(id) {
            const detail = taxRateDetails.find(item => item.id === id);
            if (detail) {
                var taxId = detail.taxId;
                var lineNo = detail.taxLine;
                var rate = detail.rate;

                $('#cb_tax_id').val(taxId).trigger('change');

                loadLineNo(taxId, function() {
                    $('#cb_tax_group_line_no').val(lineNo).trigger('change');
                    loadRateType(taxId, lineNo, null, rate);
                });

                editDetailId = id;
                $('#btnAddLine').html('<i class="bi bi-pencil"></i> Update Line');
            }
        };

        window.deleteDetail = function(id) {
            Swal.fire({
                title: 'Delete Line?',
                text: 'Are you sure you want to delete this line?',
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
                    taxRateDetails = taxRateDetails.filter(item => item.id !== id);
                    renderDetailTable();
                    clearDetailForm();
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted',
                        text: 'Line deleted successfully',
                        timer: 1500,
                        showConfirmButton: false,
                        buttonsStyling: false
                    });
                }
            });
        };

        $(document).on('click', '#taxRateTable tbody tr', function() {
            $('#taxRateTable tbody tr').removeClass('selected');
            $(this).addClass('selected');
            selectedRow = $(this).data('id');
        });

        function initTaxGroupHeaderTable() {
            if ($.fn.DataTable.isDataTable('#tableTaxGroupHeader')) {
                $('#tableTaxGroupHeader').DataTable().destroy();
            }

            $('#tableTaxGroupHeader').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                ajax: {
                    url: "<?= base_url('tmsttaxgroup/datatablesgroupheader') ?>",
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
                        data: 'taxGroup'
                    },
                    {
                        data: 'taxGroupName'
                    },
                    {
                        data: 'taxType'
                    },
                    {
                        data: 'status'
                    }
                ],
                createdRow: function(row, data, dataIndex) {
                    if (data.encoded_data) {
                        $(row).attr('data-tax-group-header-base64', data.encoded_data);
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

        function openTaxGroupHeaderModal() {
            $('#modalSearchTaxGroupHeader').modal('show');
            if (!$.fn.DataTable.isDataTable('#tableTaxGroupHeader')) {
                initTaxGroupHeaderTable();
            } else {
                $('#tableTaxGroupHeader').DataTable().ajax.reload(null, false);
            }
        }

        $('#btnSearchGroup').on('click', function() {
            openTaxGroupHeaderModal();
        });

        $(document).on('click', '#tableTaxGroupHeader tbody tr', function() {
            try {
                const encodedData = $(this).data('tax-group-header-base64');
                if (!encodedData) return;

                const taxGroupData = JSON.parse(atob(encodedData));

                $('#TaxGroup').val(taxGroupData.taxGroup || '');
                $('#TaxGroupName').val(taxGroupData.taxGroupName || '');
                $('#cb_tax_type').val(taxGroupData.taxType || '').trigger('change');

                let isActive = taxGroupData.isactive;
                if (typeof isActive === 'boolean') {
                    $('#Status').prop('checked', isActive);
                } else if (typeof isActive === 'number') {
                    $('#Status').prop('checked', isActive === 1);
                } else if (typeof isActive === 'string') {
                    $('#Status').prop('checked', isActive.toLowerCase() === 'active' || isActive === '1' || isActive === 'true');
                }

                loadTaxGroupDetails(taxGroupData.taxGroup);

                $('#modalSearchTaxGroupHeader').modal('hide');
            } catch (e) {}
        });

        function loadTaxGroupDetails(taxGroup) {
            if (!taxGroup) {
                taxRateDetails = [];
                renderDetailTable();
                return;
            }

            $.ajax({
                url: '<?= site_url('tmsttaxgroup/fetchSingleData') ?>',
                type: 'GET',
                data: {
                    TaxGroup: taxGroup
                },
                dataType: 'json',
                success: function(response) {
                    if (response.data && response.data.details && response.data.details.length > 0) {
                        taxRateDetails = response.data.details.map((item, index) => ({
                            id: index + 1,
                            taxId: item.taxId || item.TaxId || '',
                            taxLine: item.taxLine || item.TaxLine || '',
                            rate: parseFloat(item.taxRate || item.TaxRate || 0)
                        }));
                    } else {
                        taxRateDetails = [];
                    }
                    renderDetailTable();
                },
                error: function() {
                    taxRateDetails = [];
                    renderDetailTable();
                }
            });
        }

        $('#modalSearchTaxGroupHeader').on('hidden.bs.modal', function() {
            if ($.fn.DataTable.isDataTable('#tableTaxGroupHeader')) {
                $('#tableTaxGroupHeader').DataTable().ajax.reload(null, false);
            }
        }).on('shown.bs.modal', function() {
            if ($.fn.DataTable.isDataTable('#tableTaxGroupHeader')) {
                $('#tableTaxGroupHeader').DataTable().columns.adjust().draw();
            }
        });

        function checkTaxGroupExists(taxGroup, fillForm) {
            fillForm = typeof fillForm !== 'undefined' ? fillForm : true;
            $.ajax({
                url: '<?= site_url('tmsttaxgroup/fetchSingleData') ?>',
                type: 'GET',
                data: {
                    TaxGroup: taxGroup
                },
                dataType: 'json',
                success: function(response) {
                    if (response.data) {
                        isEditing = true;
                        $('#btnSave').text('Save').removeClass('btn-success').addClass('btn-primary');
                        $('#btnDelete').show();
                        $('#btnNewEntry').show();

                        if (fillForm) {
                            $('#TaxGroupName').val(response.data.TaxGroupName || '');
                            $('#cb_tax_type').val(response.data.TaxType || '').trigger('change');
                            $('#Status').prop('checked', response.data.IsActive === true);

                            if (response.data.details && response.data.details.length > 0) {
                                taxRateDetails = response.data.details.map((item, index) => ({
                                    id: index + 1,
                                    taxId: item.taxId || item.TaxId || '',
                                    taxLine: item.taxLine || item.TaxLine || '',
                                    rate: parseFloat(item.taxRate || item.TaxRate || 0)
                                }));
                            } else {
                                taxRateDetails = [];
                            }
                            renderDetailTable();
                        }
                    } else {
                        isEditing = false;
                        $('#btnSave').text('Add').removeClass('btn-success').addClass('btn-primary');
                        $('#btnDelete').hide();
                        $('#btnNewEntry').hide();
                    }
                },
                error: function() {
                    isEditing = false;
                    $('#btnSave').text('Add').removeClass('btn-success').addClass('btn-primary');
                    $('#btnDelete').hide();
                    $('#btnNewEntry').hide();
                }
            });
        }

        function resetForm() {
            $('#TaxGroup').val('');
            $('#TaxGroupName').val('');
            $('#cb_tax_type').val('').trigger('change');
            $('#Status').prop('checked', true);
            taxRateDetails = [];
            renderDetailTable();
            clearDetailForm();
            isEditing = false;
            $('#btnSave').text('Add').removeClass('btn-success').addClass('btn-primary');
            $('#btnDelete').hide();
            $('#btnNewEntry').hide();
        }

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
            let taxGroup = $('#TaxGroup').val().trim();
            let taxGroupName = $('#TaxGroupName').val().trim();
            let taxType = $('#cb_tax_type').val();
            let status = $('#Status').is(':checked');

            if (!taxGroup) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Tax Group is required',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
                return;
            }

            if (!taxGroupName) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Tax Group Name is required',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
                return;
            }

            if (!taxType || taxType === '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Tax Type is required',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
                return;
            }

            if (taxRateDetails.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'At least one tax rate detail is required',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
                return;
            }

            let actionText = isEditing ? 'Update' : 'Add';

            Swal.fire({
                title: actionText + ' Tax Group?',
                text: 'Are you sure you want to ' + actionText.toLowerCase() + ' this tax group?',
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
                    saveTaxGroup(taxGroup, taxGroupName, taxType, status);
                }
            });
        });

        function saveTaxGroup(taxGroup, taxGroupName, taxType, status) {
            let details = taxRateDetails.map(function(item) {
                return {
                    taxId: item.taxId,
                    taxLine: item.taxLine,
                    taxRate: parseFloat(item.rate) || 0
                };
            });

            $.ajax({
                url: '<?= site_url('tmsttaxgroup/action') ?>',
                type: 'POST',
                data: {
                    action: 'Save',
                    TaxGroup: taxGroup,
                    TaxGroupName: taxGroupName,
                    TaxType: taxType,
                    Isactive: status,
                    Details: JSON.stringify(details)
                },
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
                        if ($('#modalSearchTaxGroupHeader').hasClass('show') && $.fn.DataTable.isDataTable('#tableTaxGroupHeader')) {
                            $('#tableTaxGroupHeader').DataTable().ajax.reload(null, false);
                        }
                        checkTaxGroupExists(taxGroup, false);
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
                            text: response.message || 'Failed to save tax group',
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
            var taxGroup = $('#TaxGroup').val().trim();

            if (!taxGroup) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Please select a tax group to delete',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
                return;
            }

            Swal.fire({
                title: 'Delete Tax Group?',
                text: 'Are you sure you want to delete this tax group?',
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
                    deleteTaxGroup(taxGroup);
                }
            });
        });

        function deleteTaxGroup(taxGroup) {
            $.ajax({
                url: '<?= site_url('tmsttaxgroup/action') ?>',
                type: 'POST',
                data: {
                    action: 'Delete',
                    TaxGroup: taxGroup
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

                        if ($('#modalSearchTaxGroupHeader').hasClass('show') && $.fn.DataTable.isDataTable('#tableTaxGroupHeader')) {
                            $('#tableTaxGroupHeader').DataTable().ajax.reload(null, false);
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'Failed to delete tax group',
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

        $('#tax_group_form').on('submit', function(e) {
            e.preventDefault();
        });

        resetForm();
    });
</script>

<?= $this->endSection('script'); ?>