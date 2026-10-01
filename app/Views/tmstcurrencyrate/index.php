<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="<?= base_url('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">
<?= $this->endSection('style'); ?>

<?= $this->section('content'); ?>

<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-outline card-info mt-5">
                        <div class="card-body">
                            <form id="currency_form" autocomplete="off">
                                <?= csrf_field(); ?>
                                <input type="hidden" id="CurrencyIdHidden" name="CurrencyIdHidden">
                                <input type="hidden" id="EditMode" name="EditMode" value="0">
                                <input type="hidden" id="OriginalFromCurrency" name="OriginalFromCurrency">
                                <input type="hidden" id="OriginalRateDate" name="OriginalRateDate">

                                <div class="row">
                                    <div class="col-sm-4 mb-3">
                                        <label>To Currency Code</label>
                                        <?= $cb_to_currency_code ?>
                                        <span class="error invalid-feedback errorToCurrencyCode"></span>
                                    </div>

                                    <div class="col-sm-4 mb-3">
                                        <label>Rate Type</label>
                                        <?= $cb_rate_type ?>
                                        <span class="error invalid-feedback errorRateType"></span>
                                    </div>

                                    <div class="col-sm-4 mb-3">
                                        <label>Rate Operation</label>
                                        <div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="RateOperation" id="rateMultiply" value="Multiply" checked>
                                                <label class="form-check-label" for="rateMultiply">Multiply</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="RateOperation" id="rateDivide" value="Divide">
                                                <label class="form-check-label" for="rateDivide">Divide</label>
                                            </div>
                                        </div>
                                        <span class="error invalid-feedback errorRateOperation"></span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4 mb-3">
                                        <label>From Currency</label>
                                        <div>
                                            <?= $cb_from_currency_code ?>
                                        </div>
                                        <span class="error invalid-feedback errorFromCurrency"></span>
                                    </div>
                                    <div class="col-sm-4 mb-3">
                                        <label>Rate</label>
                                        <input type="text" class="form-control form-control-sm" id="Rate" name="Rate" placeholder="Enter rate">
                                        <span class="error invalid-feedback errorRate"></span>
                                    </div>
                                    <div class="col-sm-4 mb-3">
                                        <label>Rate Date</label>
                                        <input type="date" class="form-control form-control-sm" id="RateDate" name="RateDate" value="<?= date('Y-m-d') ?>">
                                        <span class="error invalid-feedback errorRateDate"></span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>Rate Detail List</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="tableRateDetail" class="table table-sm table-bordered table-striped w-100">
                                            <thead>
                                                <tr>
                                                    <th>From Currency</th>
                                                    <th>Rate Date</th>
                                                    <th>Rate</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 text-right mt-3">
                                        <button type="button" class="btn btn-primary btn-sm" id="btnSave">Save</button>
                                        <button type="button" class="btn btn-danger btn-sm d-none" id="btnDelete">Delete</button>
                                        <button type="button" class="btn btn-secondary btn-sm d-none" id="btnClear">Clear</button>
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

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>

<script src="<?= base_url('plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
<script src="<?= base_url('plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('plugins/select2/js/select2.full.min.js') ?>"></script>

<script>
    $('#active-menu').html($('p#active-menu').html());
    $(document).prop("title", $('p#active-menu').html());
</script>

<script>
    $(document).ready(function() {
        let detailTable;
        let isEditing = false;
        let editMode = '';

        $('.select2').select2({
            theme: 'bootstrap4',
            width: '100%'
        });

        $('select, input').on('change keyup', function() {
            let fieldId = $(this).attr('id');
            if (fieldId) {
                $('.error' + fieldId).hide();
                $(this).removeClass('is-invalid');
            }
        });

        function loadCurrencies() {
            $.get("<?= base_url('tmstcurrencyrate/getAllCurrencies') ?>", function(res) {
                if (res.success) {
                    let option = '<option value="">Select</option>';
                    $.each(res.data, function(i, curr) {
                        let val = curr.currencyCode + ' - ' + curr.currencyName;
                        option += `<option value="${curr.currencyCode}">${val}</option>`;
                    });
                    $('#ToCurrencyCode').html(option);
                    $('#FromCurrencyCode').html(option);
                    $('#ToCurrencyCode, #FromCurrencyCode').select2({
                        theme: 'bootstrap4',
                        width: '100%'
                    });
                }
            }, 'json');
        }

        function loadRateTypes() {
            $.get("<?= base_url('tmstcurrencyrate/getAllRateTypes') ?>", function(res) {
                if (res.success) {
                    let option = '<option value="">Select rate type</option>';
                    $.each(res.data, function(i, type) {
                        option += `<option value="${type.rateTypeCode}">${type.rateTypeName}</option>`;
                    });
                    $('#cb_rate_type').html(option);
                    $('#cb_rate_type').select2({
                        theme: 'bootstrap4',
                        width: '100%'
                    });
                }
            }, 'json');
        }

        function initDetailTable() {
            if (detailTable) detailTable.destroy();
            detailTable = $('#tableRateDetail').DataTable({
                processing: true,
                serverSide: true,
                paging: false,
                lengthChange: false,
                info: false,
                searching: true,
                ordering: true,
                dom: '<"d-flex justify-content-end"l>rt',
                ajax: {
                    url: "<?= base_url('tmstcurrencyrate/datatables') ?>",
                    type: "POST",
                    contentType: "application/json",
                    data: function(d) {
                        d.currencyId = $('#CurrencyIdHidden').val();
                        d.start = 0;
                        d.length = 999999;
                        return JSON.stringify(d);
                    },
                    dataSrc: function(json) {
                        return json.data;
                    }
                },
                columns: [{
                        data: 'fromCurrency'
                    },
                    {
                        data: 'rateDate',
                        render: function(data) {
                            return data ? data : '';
                        }
                    },
                    {
                        data: 'rate',
                        render: function(data) {
                            return data ? parseFloat(data).toLocaleString('en-US', {
                                minimumFractionDigits: 4,
                                maximumFractionDigits: 8
                            }) : '0.0000';
                        }
                    },
                    {
                        data: null,
                        className: 'text-center',
                        render: function(data, type, row) {
                            return '<button class="btn btn-info btn-sm btn-edit" data-from="' + row.fromCurrency + '" data-date="' + row.rateDate + '">Edit</button> ' +
                                '<button class="btn btn-danger btn-sm btn-delete-detail" data-from="' + row.fromCurrency + '" data-date="' + row.rateDate + '">Delete</button>';
                        }
                    }
                ],
                order: [
                    [0, 'asc']
                ],
                language: {
                    lengthMenu: "Show _MENU_ entries"
                }
            });

            $('#tableRateDetail tbody').on('click', '.btn-edit', function(e) {
                e.preventDefault();
                let fromCurrency = $(this).data('from');
                let rateDate = $(this).data('date');
                let toCurrency = $('#ToCurrencyCode').val();

                $.get("<?= site_url('tmstcurrencyrate/fetchSingleData') ?>", {
                    ToCurrencyCode: toCurrency,
                    FromCurrency: fromCurrency,
                    RateDate: rateDate
                }, function(res) {
                    if (res.data) {
                        isEditing = true;
                        editMode = 'detail';
                        $('#EditMode').val('2');
                        $('#OriginalFromCurrency').val(fromCurrency);
                        $('#OriginalRateDate').val(rateDate);

                        $('#FromCurrencyCode').val(res.data.FromCurrency).trigger('change');
                        $('#Rate').val(res.data.Rate);

                        if (res.data.RateDate) {
                            let date = new Date(res.data.RateDate);
                            let year = date.getFullYear();
                            let month = String(date.getMonth() + 1).padStart(2, '0');
                            let day = String(date.getDate()).padStart(2, '0');
                            $('#RateDate').val(year + '-' + month + '-' + day);
                        }

                        $('#btnSave').text('Update Detail').removeClass('btn-primary').addClass('btn-success');
                        $('#btnDelete').addClass('d-none');
                        $('#btnClear').removeClass('d-none');
                        t
                        if (res.data.FromCurrency === toCurrency) {
                            $('.errorFromCurrency').text('From Currency tidak boleh sama dengan To Currency').show();
                            $('#FromCurrencyCode').addClass('is-invalid');
                        }
                    }
                }, 'json');
            });

            $('#tableRateDetail tbody').on('click', '.btn-delete-detail', function(e) {
                e.preventDefault();
                let fromCurrency = $(this).data('from');
                let rateDate = $(this).data('date');
                let currencyId = $('#CurrencyIdHidden').val();

                if (!currencyId || !fromCurrency || !rateDate) {
                    Swal.fire('Error', 'Data tidak lengkap untuk menghapus', 'error');
                    return;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post("<?= site_url('tmstcurrencyrate/deleteDetail') ?>", {
                            CurrencyId: currencyId,
                            FromCurrency: fromCurrency,
                            RateDate: rateDate
                        }, function(res) {
                            if (res.status === 'success') {
                                Swal.fire('Deleted', res.message, 'success');
                                if (detailTable) detailTable.ajax.reload();
                            } else {
                                Swal.fire('Error', res.message || 'Gagal menghapus data', 'error');
                            }
                        }, 'json');
                    }
                });
            });
        }

        function resetForm(keepMainFields = false) {
            if (!keepMainFields) {
                $('#currency_form')[0].reset();
                $('.select2').val(null).trigger('change');
                $('#rateMultiply').prop('checked', true);
                $('#RateDate').val('<?= date('Y-m-d') ?>');
                $('#Rate').val('');
                $('#CurrencyIdHidden').val('');
                $('#EditMode').val('0');
                $('#OriginalFromCurrency').val('');
                $('#OriginalRateDate').val('');

                $('#ToCurrencyCode').prop('disabled', false);
                $('#cb_rate_type').prop('disabled', false);
                $('input[name="RateOperation"]').prop('disabled', false);
            } else {
                $('#FromCurrencyCode').val(null).trigger('change');
                $('#Rate').val('');
                $('#RateDate').val('<?= date('Y-m-d') ?>');
                $('#EditMode').val('0');
                $('#OriginalFromCurrency').val('');
                $('#OriginalRateDate').val('');
            }

            $('#FromCurrencyCode').prop('disabled', false);
            $('#Rate').prop('disabled', false);
            $('#RateDate').prop('disabled', false);

            $('.error').hide();
            $('.is-invalid').removeClass('is-invalid');

            isEditing = false;
            editMode = '';
            $('#btnSave').text('Save').removeClass('btn-success').addClass('btn-primary');
            $('#btnDelete').addClass('d-none');
            $('#btnClear').addClass('d-none');
        }

        function loadDetailsByToCurrency() {
            let toCurrency = $('#ToCurrencyCode').val();
            let rateType = $('#cb_rate_type').val();

            if (toCurrency) {
                $.post("<?= site_url('tmstcurrencyrate/getDetailsByToCurrency') ?>", {
                    ToCurrencyCode: toCurrency,
                    RateType: rateType
                }, function(res) {
                    if (res.success) {
                        if (res.rateType) {
                            $('#cb_rate_type').val(res.rateType).trigger('change');
                        }
                        if (res.rateOperation === 'Divide') {
                            $('#rateDivide').prop('checked', true);
                        } else {
                            $('#rateMultiply').prop('checked', true);
                        }

                        $('#FromCurrencyCode').val(null).trigger('change');
                        $('#Rate').val('');
                        $('#RateDate').val('<?= date('Y-m-d') ?>');
                    }
                }, 'json');
            }
        }

        $('#ToCurrencyCode').change(function() {
            let toCurrency = $(this).val();

            if (toCurrency) {
                $('#CurrencyIdHidden').val('');

                $.get("<?= site_url('tmstcurrencyrate/getCurrencyId') ?>", {
                    ToCurrencyCode: toCurrency
                }, function(res) {
                    $('#CurrencyIdHidden').val(res.currencyId);
                    if (detailTable) {
                        detailTable.ajax.reload();
                    }
                }, 'json');

                loadDetailsByToCurrency();

            } else {
                $('#CurrencyIdHidden').val('');
                if (detailTable) {
                    detailTable.ajax.reload();
                }

                $('#cb_rate_type').val(null).trigger('change');
                $('#rateMultiply').prop('checked', true);
                $('#FromCurrencyCode').val(null).trigger('change');
                $('#Rate').val('');
                $('#RateDate').val('<?= date('Y-m-d') ?>');
            }
        });

        $('#cb_rate_type').change(function() {
            let toCurrency = $('#ToCurrencyCode').val();
            if (toCurrency && detailTable && !isEditing) {
                detailTable.ajax.reload();
            }
        });

        $('#btnSave').click(function() {
            $('.error').hide();
            $('.is-invalid').removeClass('is-invalid');

            let toCurrency = $('#ToCurrencyCode').val();
            let rateType = $('#cb_rate_type').val();
            let rateOperation = $('input[name="RateOperation"]:checked').val();
            let fromCurrency = $('#FromCurrencyCode').val();
            let rate = $('#Rate').val();
            let rateDate = $('#RateDate').val();

            let hasError = false;

            if (!toCurrency || toCurrency === '') {
                $('.errorToCurrencyCode').text('To Currency harus dipilih').show();
                $('#ToCurrencyCode').addClass('is-invalid');
                hasError = true;
            }
            if (!rateType || rateType === '') {
                $('.errorRateType').text('Rate Type harus dipilih').show();
                $('#cb_rate_type').addClass('is-invalid');
                hasError = true;
            }

            if (hasError) return;

            let fromCurrencyEmpty = !fromCurrency || fromCurrency === '' || fromCurrency === '0' || fromCurrency === null;
            let rateEmpty = !rate || rate === '' || rate === null;

            if (!fromCurrencyEmpty && fromCurrency === toCurrency) {
                $('.errorFromCurrency').text('From Currency tidak boleh sama dengan To Currency').show();
                $('#FromCurrencyCode').addClass('is-invalid');
                hasError = true;
            }

            let isHeaderOnly = fromCurrencyEmpty && rateEmpty;

            if (!isHeaderOnly) {
                if (fromCurrencyEmpty) {
                    $('.errorFromCurrency').text('From Currency harus dipilih').show();
                    $('#FromCurrencyCode').addClass('is-invalid');
                    hasError = true;
                }
                if (rateEmpty) {
                    $('.errorRate').text('Rate harus diisi').show();
                    $('#Rate').addClass('is-invalid');
                    hasError = true;
                } else if (isNaN(parseFloat(rate))) {
                    $('.errorRate').text('Rate harus berupa angka').show();
                    $('#Rate').addClass('is-invalid');
                    hasError = true;
                }

                if (hasError) return;
            }

            $.get("<?= site_url('tmstcurrencyrate/getCurrencyId') ?>", {
                ToCurrencyCode: toCurrency
            }, function(res) {
                let action = res.currencyId ? 'Update' : 'Save';

                let data = {
                    action: action,
                    ToCurrencyCode: toCurrency,
                    RateType: rateType,
                    RateOperation: rateOperation,
                    FromCurrency: fromCurrencyEmpty ? '' : fromCurrency,
                    Rate: rateEmpty ? '' : rate,
                    RateDate: rateDate,
                    OldFromCurrency: $('#OriginalFromCurrency').val(),
                    OldRateDate: $('#OriginalRateDate').val(),
                    EditMode: editMode,
                    HeaderOnly: isHeaderOnly ? 'true' : 'false'
                };

                $.post("<?= site_url('tmstcurrencyrate/action') ?>", data, function(res) {
                    if (res.status === 'success') {
                        Swal.fire('Success', res.message, 'success');

                        let currentToCurrency = $('#ToCurrencyCode').val();
                        let currentRateType = $('#cb_rate_type').val();
                        let currentRateOperation = $('input[name="RateOperation"]:checked').val();

                        resetForm(true);

                        $('#ToCurrencyCode').val(currentToCurrency).trigger('change');
                        $('#cb_rate_type').val(currentRateType).trigger('change');
                        if (currentRateOperation === 'Divide') {
                            $('#rateDivide').prop('checked', true);
                        } else {
                            $('#rateMultiply').prop('checked', true);
                        }

                        if (detailTable) detailTable.ajax.reload();
                    } else if (res.error) {
                        $.each(res.error, function(key, value) {
                            if (key === 'ToCurrencyCode') {
                                $('.errorToCurrencyCode').text(value).show();
                                $('#ToCurrencyCode').addClass('is-invalid');
                            } else if (key === 'RateType') {
                                $('.errorRateType').text(value).show();
                                $('#cb_rate_type').addClass('is-invalid');
                            } else if (key === 'RateOperation') {
                                $('.errorRateOperation').text(value).show();
                            } else if (key === 'FromCurrency') {
                                $('.errorFromCurrency').text(value).show();
                                $('#FromCurrencyCode').addClass('is-invalid');
                            } else if (key === 'Rate') {
                                $('.errorRate').text(value).show();
                                $('#Rate').addClass('is-invalid');
                            }
                        });
                    } else {
                        Swal.fire('Error', res.message || 'Gagal menyimpan data', 'error');
                    }
                }, 'json');
            }, 'json');
        });

        $('#btnDelete').click(function() {
            let toCurrency = $('#ToCurrencyCode').val();
            let fromCurrency = $('#FromCurrencyCode').val();
            let rateDate = $('#RateDate').val();

            if (!toCurrency || !fromCurrency || !rateDate) {
                Swal.fire('Error', 'Data tidak lengkap', 'error');
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post("<?= site_url('tmstcurrencyrate/delete') ?>", {
                        ToCurrencyCode: toCurrency,
                        FromCurrency: fromCurrency,
                        RateDate: rateDate
                    }, function(res) {
                        if (res.status === 'success') {
                            Swal.fire('Deleted', res.message, 'success');

                            let currentToCurrency = $('#ToCurrencyCode').val();
                            let currentRateType = $('#cb_rate_type').val();
                            let currentRateOperation = $('input[name="RateOperation"]:checked').val();

                            resetForm(true);

                            $('#ToCurrencyCode').val(currentToCurrency).trigger('change');
                            $('#cb_rate_type').val(currentRateType).trigger('change');
                            if (currentRateOperation === 'Divide') {
                                $('#rateDivide').prop('checked', true);
                            } else {
                                $('#rateMultiply').prop('checked', true);
                            }

                            if (detailTable) detailTable.ajax.reload();
                        } else {
                            Swal.fire('Error', res.message || 'Gagal menghapus data', 'error');
                        }
                    }, 'json');
                }
            });
        });

        $('#btnClear').click(function() {
            resetForm(false);
        });

        loadCurrencies();
        loadRateTypes();
        initDetailTable();
        resetForm(false);
    });
</script>

<?= $this->endSection(); ?>