<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>
<!-- Toastr -->
<link rel="stylesheet" href="<?= base_url('plugins/toastr/toastr.min.css') ?>">
<!-- Button datatable -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<!-- Select2 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<!-- iCheck for checkboxes and radio inputs -->
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

    .hr-right-h6 {
        display: flex;
        align-items: center;
        margin: 15px 0;
        font-size: 1rem;
        font-weight: 500;
    }

    .hr-right-h6::after {
        content: '';
        flex: 1;
        border-bottom: 2px solid #0d6efd;
        margin-left: 10px;
    }

    .select2-container--default .select2-selection--single {
        height: calc(1.8125rem + 2px) !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 1.5 !important;
        font-size: 0.875rem !important;
    }

    .select2-container--open {
        z-index: 99999 !important;
    }

    .select2-dropdown {
        z-index: 99999 !important;
    }

    .select2-selection__clear {
        display: none !important;
    }

    .percent-input::placeholder {
        color: #6c757d;
        opacity: 0.6;
    }

    .percent-input:focus::placeholder {
        opacity: 0.3;
    }

    .btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .error-percent {
        font-size: 0.75rem;
        display: none;
        width: 100%;
        margin-top: 0.25rem;
    }

    .field-hidden {
        display: none !important;
    }

    /* Toggle Switch Styles */
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #28a745;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #28a745;
    }

    input:checked+.slider:before {
        transform: translateX(26px);
    }

    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }

    /* Readonly date field */
    .date-readonly {
        background-color: #e9ecef;
        opacity: 1;
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
                <div class="col-sm-6">
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-info">
                        <div class="card-body">
                            <div class="card-title">
                            </div>

                            <table id="glallocationTable" class="table table-sm table-bordered table-striped">
                                <thead class="table">
                                    <tr>
                                        <th>No</th>
                                        <th>Allocation Number</th>
                                        <th>Account Number</th>
                                        <th>Account Name</th>
                                        <th>Allocatoion Description</th>
                                        <th>Allocation Method</th>
                                        <th>Create By</th>
                                        <th>Expired Date</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="modalform" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
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
                                            <input type="hidden" id="AllocationNo" name="AllocationNo">

                                            <div class="form-group row" id="allocationNoField">
                                                <label for="AllocationNo" class="col-sm-3 col-form-label">Allocation Number</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control form-control-sm" id="AllocationNoDisplay" name="AllocationNoDisplay" readonly>
                                                    <span class="invalid-feedback errorAllocationNo"></span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="AllocationDesc" class="col-sm-3 col-form-label">Description</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control form-control-sm" id="AllocationDesc" name="AllocationDesc" rows="1" style="resize: vertical;"></textarea>
                                                    <span class="invalid-feedback errorAllocationDesc"></span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="Status" class="col-sm-3 col-form-label">Status</label>
                                                <div class="col-sm-3">
                                                    <label class="switch mt-2">
                                                        <input type="checkbox" id="Status" name="Status" checked>
                                                        <span class="slider round"></span>
                                                    </label>
                                                    <span class="ml-2 align-middle" id="statusLabel">Active</span>
                                                </div>
                                            </div>

                                            <div class="hr-right-h6 mt-3">Allocation Source</div>

                                            <div class="form-group row">
                                                <label for="FromAlloAccount" class="col-sm-3 col-form-label">Source Account</label>
                                                <div class="col-sm-3">
                                                    <?= $cb_from_allocation_account ?>
                                                    <span class="invalid-feedback errorFromAlloAccount"></span>
                                                </div>

                                                <label for="FromAccountName" class="col-sm-3 col-form-label">Account Name</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control form-control-sm" id="FromAccountName" name="FromAccountName" readonly>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="AllocationMethod" class="col-sm-3 col-form-label">Allocation Method</label>
                                                <div class="col-sm-3">
                                                    <?= $cb_allocation_method ?>
                                                    <span class="invalid-feedback errorAllocationMethod"></span>
                                                </div>

                                                <label for="ExpiredDate" class="col-sm-3 col-form-label">Expired Date</label>
                                                <div class="col-sm-3">
                                                    <input type="date" class="form-control form-control-sm date-input" id="ExpiredDate" name="ExpiredDate">
                                                    <span class="invalid-feedback errorExpiredDate"></span>
                                                </div>
                                            </div>

                                            <div class="hr-right-h6 mt-3">Allocation Account</div>
                                            <div class="mt-2 mb-2">
                                                <button type="button" class="btn btn-sm btn-primary" id="newLineBtn" onclick="addRow()">
                                                    <i class="fa fa-plus"></i> New Line
                                                </button>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table table-bordered table-sm" id="allocationTable">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th width="40">No</th>
                                                            <th>To Allocation Account</th>
                                                            <th>Account Name</th>
                                                            <th width="150">Percentage (%)</th>
                                                            <th>Notes</th>
                                                            <th width="60">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="detailBody">
                                                        <!-- Dynamic Row -->
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="mt-3">
                                                <strong>Total Percentage :</strong>
                                                <span id="totalPercent" class="text-danger font-weight-bold">
                                                    0.00 % ✖ Not Balanced
                                                </span>
                                            </div>

                                            <!-- Audit -->
                                            <div class="form-group row audit-field mt-3" style="display:none">
                                                <label for="AudtUser" class="col-sm-3 col-form-label">Create By</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control form-control-sm" id="AudtUser" name="AudtUser" readonly>
                                                </div>

                                                <label for="AudtDate" class="col-sm-3 col-form-label">Create Date</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control form-control-sm" id="AudtDate" name="AudtDate" readonly>
                                                </div>
                                            </div>

                                            <div class="form-group row audit-field" style="display:none">
                                                <label for="AudtTime" class="col-sm-3 col-form-label">Create Time</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control form-control-sm" id="AudtTime" name="AudtTime" readonly>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="modal-footer">
                                            <input type="hidden" id="hidden_id" name="hidden_id">
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

                        <!-- Modal Import -->
                        <div class="modal fade" id="modalimport" tabindex="" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLabel"></h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="<?= site_url("tmstglallocationentry/preview") ?>" id="uploadForm" method="post" enctype="multipart/form-data">
                                            <?= csrf_field(); ?>
                                            <label for="filename">Import Excel File : <a href="<?= site_url("tmstglallocationentry/download") ?>"><u>Download Format</u></a></label> <br>
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

<!-- Toastr -->
<script src="<?= base_url('plugins/toastr/toastr.min.js') ?>"></script>
<!-- Button datatable -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<!-- set menu name by active-menu -->
<script>
    $('#active-menu').html($('p#active-menu').html());
    $(document).prop("title", $('p#active-menu').html());
</script>

<script>
    function formatSelect2Option(option) {
        if (!option.id) {
            return option.text;
        }
        var $option = $('<span>' + option.text + '</span>');
        return $option;
    }

    function formatSelect2Selection(option) {
        if (!option.id) {
            return option.text;
        }
        var text = option.text;
        var acctNoOnly = text.split(' - ')[0];
        var $selection = $('<span>' + acctNoOnly + '</span>');
        return $selection;
    }

    function updateFromAccountName(selectElement) {
        let $select = $(selectElement);
        let selectedOption = $select.find('option:selected');
        let accountName = selectedOption.data('account-name') || '';
        $('#FromAccountName').val(accountName);
    }

    function updateAccountName(selectElement) {
        let $select = $(selectElement);
        let selectedOption = $select.find('option:selected');
        let accountName = selectedOption.data('account-name') || '';
        $select.closest('tr').find('.account-name').val(accountName);
    }

    function validatePercentage(input) {
        let value = input.value;
        let $input = $(input);
        let $errorSpan = $input.next('.error-percent');

        value = value.replace(/[^\d.]/g, '');

        if (value.length > 1 && value[0] === '0' && value[1] !== '.') {
            value = value.substring(1);
        }

        let decimalParts = value.split('.');
        if (decimalParts.length > 2) {
            value = decimalParts[0] + '.' + decimalParts[1];
        }

        if (decimalParts.length === 2 && decimalParts[1].length > 2) {
            value = decimalParts[0] + '.' + decimalParts[1].substring(0, 2);
        }

        input.value = value;

        let numValue = parseFloat(value) || 0;
        if (numValue < 0 || numValue > 100) {
            $input.addClass('is-invalid');
            $errorSpan.text('Percentage harus antara 0 - 100').show();
        } else {
            $input.removeClass('is-invalid');
            $errorSpan.text('').hide();
        }

        calculateTotal();

        return true;
    }

    function addRow() {
        let tbody = document.getElementById("detailBody");
        let rowCount = tbody.rows.length + 1;
        let uniqueId = 'acc_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);

        let html = `
<tr id="row_${uniqueId}">
    <td>${rowCount}</td>
    <td>
        <select class="form-control form-control-sm select2-dynamic" name="to_allocation_account[]">
            <option value="">--Select--</option>
            <?php
            $dropdown = getDropdownToAllocationAccount('cb_to_allocation_account', 'to_allocation_account');
            preg_match_all('/<option value="([^"]*)"[^>]*data-account-name="([^"]*)">([^<]*)<\/option>/', $dropdown, $matches);
            for ($i = 0; $i < count($matches[0]); $i++) {
                $value = $matches[1][$i];
                $accountName = $matches[2][$i];
                $displayText = htmlspecialchars($value) . ' - ' . htmlspecialchars($accountName);
                echo '<option value="' . htmlspecialchars($value) . '" data-account-name="' . htmlspecialchars($accountName) . '">' . $displayText . '</option>';
            }
            ?>
        </select>
    </td>
    <td>
        <input class="form-control form-control-sm account-name" 
               name="account_name[]" 
               readonly>
    </td>
    <td>
        <input type="text" 
               name="AlloPercent[]" 
               class="form-control form-control-sm text-end percent-input" 
               oninput="validatePercentage(this)" 
               placeholder="0" 
               maxlength="5">
        <span class="invalid-feedback error-percent"></span>
    </td>
    <td><input class="form-control form-control-sm" name="notes[]"></td>
    <td class="text-center">
        <button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">🗑</button>
    </td>
</tr>
`;

        tbody.insertAdjacentHTML("beforeend", html);

        $(`#row_${uniqueId} .select2-dynamic`).select2({
            theme: 'default',
            allowClear: false,
            width: '100%',
            dropdownParent: $('#modalform'),
            templateResult: formatSelect2Option,
            templateSelection: formatSelect2Selection
        }).on('change', function() {
            updateAccountName(this);
        });

        calculateTotal();
    }

    function removeRow(btn) {
        let row = btn.closest("tr");
        $(row).find('.select2-dynamic').select2('destroy');
        row.remove();
        renumberRows();
        calculateTotal();
    }

    function renumberRows() {
        let rows = document.querySelectorAll("#detailBody tr");
        rows.forEach((row, index) => {
            row.cells[0].innerText = index + 1;
        });
    }

    function calculateTotal() {
        let total = 0;
        let hasValue = false;
        let hasEmptyOrZero = false;

        document.querySelectorAll(".percent-input").forEach(el => {
            let value = el.value;
            if (value === '' || value === '0' || value === '0.00' || value === '0.0') {
                hasEmptyOrZero = true;
            } else {
                let numValue = parseFloat(value || 0);
                total += numValue;
                if (numValue > 0) hasValue = true;
            }
        });

        let label = document.getElementById("totalPercent");
        let saveBtn = document.getElementById("submit_button");
        let newLineBtn = document.getElementById("newLineBtn");

        label.innerHTML = total.toFixed(2) + " %";

        if (newLineBtn) {
            if (hasEmptyOrZero) {
                newLineBtn.disabled = true;
                newLineBtn.title = "Harap isi semua percentage sebelum menambahkan baris baru";
            } else {
                newLineBtn.disabled = false;
                newLineBtn.title = "";
            }
        }

        if (total === 100 && hasValue && !hasEmptyOrZero) {
            label.className = "text-success font-weight-bold";
            label.innerHTML += " ✔ Balanced";
            if (saveBtn) saveBtn.disabled = false;
        } else {
            label.className = "text-danger font-weight-bold";
            if (total > 100) {
                label.innerHTML += " ✖ Exceeds 100%";
            } else if (total < 100 && hasValue) {
                label.innerHTML += " ✖ Less than 100%";
            } else {
                label.innerHTML += " ✖ Not Balanced";
            }
            if (saveBtn) saveBtn.disabled = true;
        }
    }

    function updateStatusLabel() {
        let statusCheckbox = document.getElementById('Status');
        let statusLabel = document.getElementById('statusLabel');
        if (statusCheckbox.checked) {
            statusLabel.textContent = 'Active';
            statusLabel.style.color = '#28a745';
        } else {
            statusLabel.textContent = 'Inactive';
            statusLabel.style.color = '#dc3545';
        }
    }
</script>

<script>
    $(document).ready(function() {

        function checkSession(response) {
            if (response.status === 'session_expired') {
                window.location.href = "<?= base_url('auth/login') ?>";
                return false;
            }
            return true;
        }

        $('#cb_from_allocation_account').select2({
            theme: 'default',
            allowClear: false,
            width: '100%',
            dropdownParent: $('#modalform'),
            templateResult: formatSelect2Option,
            templateSelection: formatSelect2Selection
        }).on('change', function() {
            updateFromAccountName(this);
        });

        $('#cb_allocation_method').select2({
            theme: 'default',
            allowClear: false,
            width: '100%',
            dropdownParent: $('#modalform')
        });

        $(document).on('select2:open', function(e) {
            setTimeout(function() {
                const searchField = document.querySelector('.select2-search__field');
                if (searchField) {
                    searchField.focus();
                }
            }, 100);
        });

        function resetGLAllocationModal() {
            $('#data_form')[0].reset();

            $('.is-invalid').removeClass('is-invalid');
            $('.select2-container .select2-selection').removeClass('is-invalid');
            $('[class^="error"]').html('').hide();

            $('#cb_from_allocation_account').val(null).trigger('change');
            $('#cb_allocation_method').val(null).trigger('change');

            $('#FromAccountName').val('');

            $('#detailBody').empty();
            $('#totalPercent').html('0.00 % ✖ Not Balanced');
            $('#totalPercent').removeClass('text-success').addClass('text-danger font-weight-bold');

            $('.audit-field').hide();

            $('#Status').prop('checked', true);
            updateStatusLabel();

            $('#hidden_id').val('');
            $('#action').val('Add');

            $('#AllocationNo').val('');
            $('#AllocationNoDisplay').val('');

            $('#submit_button').prop('disabled', true);

            $('#newLineBtn').prop('disabled', false).prop('title', '');

            $('#AllocationDesc').prop('disabled', false);
            $('#ExpiredDate').prop('disabled', false);
            $('#Status').prop('disabled', false);
            $('#cb_from_allocation_account').prop('disabled', false);
            $('#cb_allocation_method').prop('disabled', false);
            $('.select2-dynamic').prop('disabled', false);
            $('.account-name').prop('disabled', false);

            $('#allocationNoField').addClass('field-hidden');

            $('#ExpiredDate').removeClass('date-readonly');
        }

        $('#modalform').on('hidden.bs.modal', function() {
            resetGLAllocationModal();
        });

        $(document).on('click', '#add_record', function() {
            resetGLAllocationModal();

            $('#allocationNoField').addClass('field-hidden');

            $('#AllocationNoDisplay').val('').prop('disabled', true);

            addRow();

            $('.modal-title').text('Tambah Data');
            $('#action').val('Add');
            $('#submit_button').val('Simpan').html('Simpan').show();
            $('#modalform').modal('show');
        });

        $('#Status').on('change', function() {
            updateStatusLabel();
        });

        $('#data_form').on('submit', function(event) {
            event.preventDefault();

            let total = 0;
            let hasEmpty = false;
            let errorMessages = [];

            $('.percent-input').each(function(index) {
                let value = $(this).val();
                if (value === '' || value === '0' || value === '0.00' || value === '0.0') {
                    hasEmpty = true;
                    $(this).addClass('is-invalid');
                    $(this).next('.error-percent').text('Percentage harus diisi dengan angka lebih dari 0').show();
                    errorMessages.push(`Percentage pada baris ${index + 1} harus diisi`);
                } else {
                    total += parseFloat(value || 0);
                }
            });

            if (hasEmpty) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    html: errorMessages.join('<br>') || 'Semua field percentage harus diisi dengan angka lebih dari 0'
                });
                return;
            }

            if (Math.abs(total - 100) > 0.01) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    text: 'Total Percentage harus tepat 100% (Sekarang: ' + total.toFixed(2) + '%)'
                });
                return;
            }

            $.ajax({
                url: "<?= site_url('tmstglallocationentry/action'); ?>",
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
                    console.log('Server response:', response);

                    if (!checkSession(response)) return;

                    if (response.error) {
                        showValidationErrors(response.error);
                    } else if (response.status === 'error') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message || 'Terjadi kesalahan saat menyimpan data.'
                        });
                        console.error('Error details:', response);
                    } else if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message || 'Data berhasil disimpan.',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        clearFormValidation();
                        resetGLAllocationModal();
                        $('#modalform').modal('hide');
                        $('#glallocationTable').DataTable().ajax.reload(null, false);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error, xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'Gagal menghubungi server. Silakan coba lagi nanti.'
                    });
                }
            });
        });

        function showValidationErrors(errors) {
            console.log('Validation errors:', errors);

            clearFormValidation();

            const fieldMapping = {
                'AllocationNo': {
                    element: '#AllocationNoDisplay',
                    errorSpan: '.errorAllocationNo'
                },
                'AllocationDesc': {
                    element: '#AllocationDesc',
                    errorSpan: '.errorAllocationDesc'
                },
                'ExpiredDate': {
                    element: '#ExpiredDate',
                    errorSpan: '.errorExpiredDate'
                },
                'FromAlloAccount': {
                    element: '#cb_from_allocation_account',
                    errorSpan: '.errorFromAlloAccount'
                },
                'AllocationMethod': {
                    element: '#cb_allocation_method',
                    errorSpan: '.errorAllocationMethod'
                }
            };

            Object.keys(errors).forEach(fieldName => {
                if (fieldMapping[fieldName]) {
                    const {
                        element,
                        errorSpan
                    } = fieldMapping[fieldName];

                    if (fieldName === 'FromAlloAccount' || fieldName === 'AllocationMethod') {
                        $(element).next('.select2-container').find('.select2-selection').addClass('is-invalid');
                    } else {
                        $(element).addClass('is-invalid');
                    }

                    $(errorSpan).html(errors[fieldName]).show();
                }
            });

            if (Object.keys(errors).length > 0) {
                $('#submit_button').prop('disabled', true);
            }
        }

        function clearFormValidation() {
            $('.form-control').removeClass('is-invalid');
            $('.select2-container .select2-selection').removeClass('is-invalid');

            $('[class^="error"]').each(function() {
                $(this).html('').hide();
            });

            $('.select2-container').css('border', '');
        }

        $(document).on('click', '.view, .edit', function() {
            const AllocationNo = $(this).data('allocationno');
            const isEdit = $(this).hasClass('edit');

            Swal.fire({
                title: 'Loading...',
                text: 'Mengambil data allocation',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: "<?= site_url('tmstglallocationentry/fetchSingleData'); ?>",
                method: "GET",
                data: {
                    AllocationNo: AllocationNo
                },
                dataType: "JSON",
                success: function(response) {
                    Swal.close();

                    if (response.data) {
                        resetGLAllocationModal();

                        const data = response.data;
                        const details = response.details || [];

                        $('#allocationNoField').removeClass('field-hidden');

                        $('#AllocationNoDisplay').val(data.AllocationNo).prop('disabled', !isEdit);
                        $('#AllocationDesc').val(data.AllocationDesc).prop('disabled', !isEdit);

                        if (data.ExpiredDate) {
                            $('#ExpiredDate').val(data.ExpiredDate).prop('disabled', !isEdit);
                        }

                        $('#Status').prop('checked', data.Status == 1).prop('disabled', !isEdit);
                        updateStatusLabel();

                        if (data.FromAlloAccount) {
                            $('#cb_from_allocation_account').val(data.FromAlloAccount).trigger('change');

                            let $option = $('#cb_from_allocation_account option[value="' + data.FromAlloAccount + '"]');
                            if ($option.length > 0) {
                                let accountName = $option.data('account-name') || '';
                                $('#FromAccountName').val(accountName);
                            }
                        }

                        if (data.AllocationMethod) {
                            $('#cb_allocation_method').val(data.AllocationMethod).trigger('change');
                        }

                        $('#detailBody').empty();
                        if (details.length > 0) {
                            details.forEach(function(detail, index) {
                                let tbody = document.getElementById("detailBody");
                                let rowCount = tbody.rows.length + 1;
                                let uniqueId = 'acc_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);

                                let percentValue = (detail.AlloPercent == 0 || detail.AlloPercent == '0') ? '' : detail.AlloPercent;

                                let html = `
            <tr id="row_${uniqueId}">
                <td>${rowCount}</td>
                <td>
                    <select class="form-control form-control-sm select2-dynamic" name="to_allocation_account[]">
                        <option value="">--Select--</option>
                        <?php
                        $dropdown = getDropdownToAllocationAccount('cb_to_allocation_account', 'to_allocation_account');
                        preg_match_all('/<option value="([^"]*)"[^>]*data-account-name="([^"]*)">([^<]*)<\/option>/', $dropdown, $matches);
                        for ($i = 0; $i < count($matches[0]); $i++) {
                            $value = $matches[1][$i];
                            $accountName = $matches[2][$i];
                            $displayText = htmlspecialchars($value) . ' - ' . htmlspecialchars($accountName);
                            echo '<option value="' . htmlspecialchars($value) . '" data-account-name="' . htmlspecialchars($accountName) . '">' . $displayText . '</option>';
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <input class="form-control form-control-sm account-name" 
                           name="account_name[]" 
                           value="${detail.AccountName}" readonly>
                </td>
                <td>
                    <input type="text" 
                           name="AlloPercent[]" 
                           class="form-control form-control-sm text-end percent-input" 
                           oninput="validatePercentage(this)" 
                           placeholder="0" 
                           maxlength="5"
                           value="${percentValue}">
                    <span class="invalid-feedback error-percent"></span>
                </td>
                <td>
                    <input class="form-control form-control-sm" 
                           name="notes[]" 
                           value="${detail.Notes}">
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">🗑</button>
                </td>
            </tr>
        `;
                                tbody.insertAdjacentHTML("beforeend", html);

                                let selectElement = $(`#row_${uniqueId} .select2-dynamic`);
                                selectElement.select2({
                                    theme: 'default',
                                    allowClear: false,
                                    width: '100%',
                                    dropdownParent: $('#modalform'),
                                    templateResult: formatSelect2Option,
                                    templateSelection: formatSelect2Selection
                                });

                                if (detail.ToAlloAccount) {
                                    selectElement.val(detail.ToAlloAccount).trigger('change');
                                }

                                if (!isEdit) {
                                    selectElement.prop('disabled', true).select2('enable', false);
                                    $(`#row_${uniqueId} .account-name`).prop('disabled', true);
                                    $(`#row_${uniqueId} .percent-input`).prop('disabled', true);
                                    $(`#row_${uniqueId} input[name="notes[]"]`).prop('disabled', true);
                                    $(`#row_${uniqueId} button`).hide();
                                } else {
                                    selectElement.prop('disabled', false).select2('enable', true);
                                    $(`#row_${uniqueId} .account-name`).prop('readonly', true);
                                    $(`#row_${uniqueId} .percent-input`).prop('disabled', false);
                                    $(`#row_${uniqueId} input[name="notes[]"]`).prop('disabled', false);
                                    $(`#row_${uniqueId} button`).show();
                                }
                            });
                        } else if (isEdit) {
                            addRow();
                        }

                        calculateTotal();

                        if (!isEdit && (data.AudtUser || data.AudtDate)) {
                            $('#AudtUser').val(data.AudtUser);
                            $('#AudtDate').val(data.AudtDate);
                            $('#AudtTime').val(data.AudtTime.split('T')[1].substring(0, 8));
                            $('.audit-field').show();
                        }

                        $('.modal-title').text(isEdit ? 'Ubah Data' : 'Lihat Data');
                        $('#action').val(isEdit ? 'Edit' : 'View');

                        $('#AllocationNo').val(data.AllocationNo);
                        $('#hidden_id').val(data.AllocationNo);

                        if (!isEdit) {
                            $('#submit_button').hide();
                            $('#newLineBtn').hide();
                            $('#AllocationDesc').prop('disabled', true);
                            $('#ExpiredDate').prop('disabled', true).addClass('date-readonly');
                            $('#Status').prop('disabled', true);
                            $('.switch').css('opacity', '0.5');
                        } else {
                            $('#submit_button').show().val('Simpan').html('Simpan');
                            $('#newLineBtn').show();
                            $('#AllocationDesc').prop('disabled', false);
                            $('#ExpiredDate').prop('disabled', false).removeClass('date-readonly');
                            $('#Status').prop('disabled', false);
                            $('.switch').css('opacity', '1');
                        }

                        $('#modalform').modal('show');

                    } else {
                        console.error('Response error: No data property', response);
                        Swal.fire({
                            icon: 'error',
                            title: 'Data Tidak Ditemukan',
                            text: response.message || `Allocation dengan number ${AllocationNo} tidak ditemukan`
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.close();
                    console.error('AJAX Error:', status, error, xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan saat mengambil data allocation'
                    });
                }
            });
        });

        function confirmDelete({
            allocationNo,
            url,
            tableId
        }) {
            Swal.fire({
                title: 'Yakin ingin menghapus data?',
                text: 'Data allocation akan dihapus secara permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (!result.isConfirmed) return;

                $.ajax({
                    url,
                    method: 'POST',
                    data: {
                        AllocationNo: allocationNo
                    },
                    dataType: 'JSON',
                    success: function(res) {
                        if (res.status === 'success') {
                            Swal.fire('Berhasil', res.message || 'Data berhasil dihapus.', 'success');
                            $(`#${tableId}`).DataTable().ajax.reload(null, false);
                        } else {
                            Swal.fire('Gagal', res.message || 'Terjadi kesalahan saat menghapus data.', 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Gagal menghapus data', 'Terjadi kesalahan saat menghubungi server.', 'error');
                        console.error('AJAX Error:', status, error);
                    }
                });
            });
        }

        $(document).on('click', '.delete', function() {
            const allocationNo = $(this).data('allocationno');
            confirmDelete({
                allocationNo,
                url: "<?= site_url('tmstglallocationentry/delete'); ?>",
                tableId: 'glallocationTable'
            });
        });
    });
</script>

<script>
    $(document).ready(function() {

        $(document).on('click', '#import', function() {
            $('.modal-title').text('Import Data GL Allocation');
            $("#filename").val(null);
            $('#viewpreview').html('');
            $('#modalimport').modal('show');
        });

        $('#uploadForm').submit(function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            $.ajax({
                url: '<?= site_url("tmstglallocationentry/preview") ?>',
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

        $("#glallocationTable").DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                dom: 'Bfrtip',

                ajax: {
                    url: "<?= base_url('tmstglallocationentry/datatables') ?>",
                    type: "POST",
                    contentType: "application/json",

                    dataSrc: function(json) {
                        return json.data || [];
                    },

                    data: function(d) {
                        return JSON.stringify(d);
                    }
                },

                columnDefs: [{
                        orderable: false,
                        targets: [0, 9]
                    },
                    {
                        targets: [0, 9],
                        className: 'text-center'
                    }
                ],

                columns: [{
                        data: 'rownum',
                        orderable: false
                    },
                    {
                        data: 'allocationNo',
                        defaultContent: ''
                    },
                    {
                        data: 'fromAlloAccount',
                        defaultContent: ''
                    },
                    {
                        data: 'acctName',
                        defaultContent: ''
                    },
                    {
                        data: 'allocationDesc',
                        defaultContent: ''
                    },
                    {
                        data: 'allocationMethod',
                        defaultContent: ''
                    },
                    {
                        data: 'audtUser',
                        defaultContent: ''
                    },
                    {
                        data: 'expiredDate',
                        render: function(data) {
                            if (!data) return '';
                            const d = new Date(data);
                            if (isNaN(d)) return '';
                            const day = String(d.getDate()).padStart(2, '0');
                            const month = String(d.getMonth() + 1).padStart(2, '0');
                            const year = d.getFullYear();
                            return `${day}/${month}/${year}`;
                        }
                    },
                    {
                        data: 'status',
                    },
                    {
                        data: 'aksi',
                        orderable: false
                    }
                ],

                buttons: [{
                        text: "Tambah",
                        action: function() {},
                        attr: {
                            id: "add_record",
                            style: "background-color:#56b746; <?= session()->get('flag_insert') === 1 ? '' : 'd-none' ?>",
                            name: "add_record"
                        }
                    },
                    {
                        extend: "excel",
                        text: "Excel",
                        className: "btn-sm btn-primary <?= session()->get('flag_export') === 1 ? '' : 'd-none' ?>",
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                        }
                    },
                    {
                        extend: "print",
                        text: "Cetak",
                        className: "btn-sm btn-info <?= session()->get('flag_print') === 1 ? '' : 'd-none' ?>",
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                        }
                    },
                    {
                        text: "Import",
                        action: function() {},
                        attr: {
                            id: "import",
                            style: "background-color:#56b746; <?= session()->get('flag_insert') === 1 ? '' : 'd-none' ?>",
                            nameClass: "btn btn-sm btn-warning"
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
            })
            .buttons()
            .container()
            .appendTo("#glallocationTable_wrapper .col-md-6:eq(0)");

        $('#glallocationTable').on('xhr.dt', function(e, settings, json) {
            if (json && json.status === 'session_expired') {
                alert('Sesi Anda telah berakhir. Silakan login kembali.');
                window.location.href = "<?= base_url('auth/login') ?>";
            }
        });

    });
</script>

<?= $this->endSection('script'); ?>