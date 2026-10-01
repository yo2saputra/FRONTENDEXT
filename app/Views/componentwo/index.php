<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>
<!-- Include dropdown CSS -->

<!-- Toastr -->
<link rel="stylesheet" href="<?= base_url('plugins/toastr/toastr.min.css') ?>">
<!-- Button datatable -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<!-- iCheck -->
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

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dropdown Demo</h1>
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

                            <!-- ========================================== -->
                            <!-- DEMO DROPDOWN -->
                            <!-- ========================================== -->
                            <div class="row">
                                <!-- 1. Single Select -->
                                <div class="col-md-4">
                                    <h6>1. Single Select</h6>
                                    <?= view('components/dropdown2', [
                                        'id'          => 'demo-single',
                                        'name'        => 'demo_single',
                                        'apiUrl'      => base_url('/dropdown/customize/1/1/warehouse/null/action/getall/null/null'),
                                        'selected'    => 'WH00002',
                                        'placeholder' => 'Pilih Warehouse',
                                        'extraKeys'   => [
                                            'data-code' => 'warehouse_cd',
                                            'data-name' => 'warehouse_nm'
                                        ]
                                    ]) ?>
                                    <small class="text-muted">✅ Default: WH00002</small>
                                </div>

                                <!-- 2. Multiple Select -->
                                <div class="col-md-4">
                                    <h6>2. Multiple Select</h6>
                                    <?= view('components/dropdown2', [
                                        'id'          => 'demo-multiple',
                                        'name'        => 'demo_multiple[]',
                                        'apiUrl'      => base_url('/dropdown/customize/1/1/warehouse/null/action/getall/null/null'),
                                        'multiple'    => true,
                                        'selected'    => ['WH00002', 'WH00005'],
                                        'placeholder' => 'Pilih Warehouse',
                                    ]) ?>
                                    <small class="text-muted">✅ Default: WH00002, WH00005</small>
                                </div>

                                <!-- 3. Filter NOT IN (Disabled) -->
                                <div class="col-md-4">
                                    <h6>3. Filter NOT IN (Disabled)</h6>
                                    <?= view('components/dropdown2', [
                                        'id'          => 'demo-notin',
                                        'name'        => 'demo_notin',
                                        'apiUrl'      => base_url('/dropdown/customize/1/1/warehouse/null/action/getall/null/null'),
                                        'filterNotIn' => ['WH00001', 'WH00003', 'WH00009'],
                                        'selected'    => 'WH00009',
                                        'placeholder' => 'Pilih Warehouse',
                                        'filterMode'  => 'show'
                                    ]) ?>
                                    <small class="text-muted">🔒 WH00001, WH00003, WH00009 disabled</small>
                                </div>
                            </div>

                            <hr>

                            <!-- 4. Filter IN -->
                            <div class="row">
                                <div class="col-md-4">
                                    <h6>4. Filter IN</h6>
                                    <?= view('components/dropdown2', [
                                        'id'          => 'demo-in',
                                        'name'        => 'demo_in',
                                        'apiUrl'      => base_url('/dropdown/customize/1/1/warehouse/null/action/getall/null/null'),
                                        'filterIn'    => ['WH00002', 'WH00005', 'WH00007'],
                                        'selected'    => 'WH00005',
                                        'placeholder' => 'Pilih Warehouse',
                                    ]) ?>
                                    <small class="text-muted">✅ Hanya WH00002, WH00005, WH00007</small>
                                </div>

                                <!-- 5. Multiple + Filter -->
                                <div class="col-md-4">
                                    <h6>5. Multiple + Filter</h6>
                                    <?= view('components/dropdown2', [
                                        'id'          => 'demo-multiple-filter',
                                        'name'        => 'demo_multiple_filter[]',
                                        'apiUrl'      => base_url('/dropdown/customize/1/1/warehouse/null/action/getall/null/null'),
                                        'multiple'    => true,
                                        'filterIn'    => ['WH00002', 'WH00005', 'WH00007', 'WH00010'],
                                        'selected'    => ['WH00002', 'WH00005', 'WH00007'],
                                        'placeholder' => 'Pilih Warehouse',
                                    ]) ?>
                                    <small class="text-muted">✅ Filtered + Multiple</small>
                                </div>

                                <!-- 6. Tanpa Allow Clear -->
                                <div class="col-md-4">
                                    <h6>6. Tanpa Allow Clear</h6>
                                    <?= view('components/dropdown2', [
                                        'id'          => 'demo-no-clear',
                                        'name'        => 'demo_no_clear',
                                        'apiUrl'      => base_url('/dropdown/customize/1/1/warehouse/null/action/getall/null/null'),
                                        'selected'    => 'WH00002',
                                        'placeholder' => '--Wajib Pilih--',
                                        'allowClear'  => false
                                    ]) ?>
                                    <small class="text-muted">❌ Tidak bisa clear</small>
                                </div>
                            </div>

                            <hr>

                            <!-- ========================================== -->
                            <!-- BUTTON TEST -->
                            <!-- ========================================== -->
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-sm btn-primary" id="btnSetSingle">Set Single: WH00005</button>
                                    <button type="button" class="btn btn-sm btn-success" id="btnSetMultiple">Set Multiple: WH00002, WH00007</button>
                                    <button type="button" class="btn btn-sm btn-warning" id="btnRefreshSet">Refresh & Set</button>
                                    <button type="button" class="btn btn-sm btn-info" id="btnGetValue">Get Value</button>
                                    <button type="button" class="btn btn-sm btn-danger" id="btnClear">Clear</button>
                                    <button type="button" class="btn btn-sm btn-secondary" id="btnRefreshAll">Refresh All</button>
                                </div>
                            </div>

                            <hr>

                            <!-- ========================================== -->
                            <!-- RESULT DISPLAY -->
                            <!-- ========================================== -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-info" id="resultDisplay">
                                        <strong>Selected Values:</strong> <span id="selectedValues">-</span>
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

<!-- Include dropdown JS -->

<!-- Toastr -->
<script src="<?= base_url('plugins/toastr/toastr.min.js') ?>"></script>

<!-- Button datatable -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function() {

        // ============================================
        // SET SINGLE VALUE
        // ============================================
        $("#btnSetSingle").on("click", function() {
            const dropdown = window.dropdown_demo_single;
            if (dropdown) {
                dropdown.setValue('WH00005');
                toastr.success('Value set to: WH00005');
                updateDisplay();
            } else {
                toastr.error('Dropdown belum siap!');
            }
        });

        // ============================================
        // SET MULTIPLE VALUE
        // ============================================
        $("#btnSetMultiple").on("click", function() {
            const dropdown = window.dropdown_demo_multiple;
            if (dropdown) {
                dropdown.setValue(['WH00002', 'WH00007']);
                toastr.success('Value set to: WH00002, WH00007');
                updateDisplay();
            } else {
                toastr.error('Dropdown belum siap!');
            }
        });

        // ============================================
        // REFRESH & SET
        // ============================================
        $("#btnRefreshSet").on("click", function() {
            const dropdown = window.dropdown_demo_single;
            if (dropdown) {
                dropdown.refresh(function() {
                    dropdown.setValue('WH00003');
                    toastr.success('Refreshed and set to: WH00003');
                    updateDisplay();
                });
            }
        });

        // ============================================
        // GET VALUE
        // ============================================
        $("#btnGetValue").on("click", function() {
            const dropdown = window.dropdown_demo_single;
            if (dropdown) {
                const value = dropdown.getValue();
                const text = dropdown.getSelectedText();
                const data = dropdown.getSelectedData();

                let display = 'Value: ' + value + '\n';
                display += 'Text: ' + text + '\n';
                display += 'Data: ' + JSON.stringify(data, null, 2);

                alert(display);
            }
        });

        // ============================================
        // CLEAR
        // ============================================
        $("#btnClear").on("click", function() {
            const dropdown = window.dropdown_demo_single;
            if (dropdown) {
                dropdown.setValue('');
                toastr.info('Cleared!');
                updateDisplay();
            }
        });

        // ============================================
        // REFRESH ALL
        // ============================================
        $("#btnRefreshAll").on("click", function() {
            $(document).trigger('refresh-all-dropdowns');
            toastr.info('All dropdowns refreshed!');
            setTimeout(updateDisplay, 1000);
        });

        // ============================================
        // UPDATE DISPLAY
        // ============================================
        function updateDisplay() {
            const dropdown = window.dropdown_demo_single;
            if (dropdown) {
                const value = dropdown.getValue();
                $('#selectedValues').text(value || '-');
            }
        }

        // ============================================
        // EVENT: Ketika value di-set
        // ============================================
        $('#demo-single').on('dropdown-value-set', function(e, value) {
            console.log('Value set event:', value);
            $('#selectedValues').text(value || '-');
        });

        // ============================================
        // EVENT: Ketika dropdown berubah
        // ============================================
        $(document).on('dropdown-change', function(e) {
            const $target = $(e.target);
            if ($target.attr('id') === 'demo-single') {
                const value = $target.val();
                $('#selectedValues').text(value || '-');
            }
        });

        // ============================================
        // TOASTR CONFIG
        // ============================================
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        };

        // ============================================
        // INISIALISASI AWAL
        // ============================================
        setTimeout(updateDisplay, 1000);

    });
</script>

<?= $this->endSection('script'); ?>