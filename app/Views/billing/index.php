<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>
<link rel="stylesheet" href="<?= base_url('plugins/toastr/toastr.min.css') ?>">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<style>
    .btn-fix-w {
        width: 60px;
        padding-top: 0;
        padding-bottom: 0;
    }

    .form-control-sm {
        font-size: .720rem !important;
    }

    .filter-section {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 15px;
    }

    .filter-section .row {
        margin-bottom: 10px;
    }

    .filter-section .row:last-child {
        margin-bottom: 0;
    }

    .detail-modal .table-details th {
        width: 30%;
    }

    .payment-method-badge {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 3px;
        font-size: 11px;
        margin: 2px;
    }

    .payment-method-badge-deposit {
        background: #17a2b8;
        color: white;
    }

    .payment-method-badge-cash {
        background: #28a745;
        color: white;
    }

    .payment-method-badge-other {
        background: #6c757d;
        color: white;
    }

    .void-reason {
        margin-top: 10px;
    }

    .void-reason textarea {
        width: 100%;
        border-radius: 4px;
        border: 1px solid #ddd;
        padding: 8px;
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
                    <h1>Riwayat Transaksi & Billing</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <button class="btn btn-sm btn-success" id="btnShiftSummary" title="Rekapitulasi Shift">
                        <i class="fas fa-cash-register"></i> Tutup Kasir
                    </button>
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

                            <!-- Filter Section -->
                            <div class="filter-section">
                                <form id="filterForm" autocomplete="off">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Tanggal Mulai</label>
                                            <input type="date" class="form-control form-control-sm" id="startDate" name="startDate">
                                        </div>
                                        <div class="col-md-3">
                                            <label>Tanggal Akhir</label>
                                            <input type="date" class="form-control form-control-sm" id="endDate" name="endDate">
                                        </div>
                                        <div class="col-md-3">
                                            <label>Status Pembayaran</label>
                                            <select class="form-control form-control-sm select2" id="paymentStatus" name="paymentStatus" style="width:100%">
                                                <option value="">Semua Status</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Cara Bayar</label>
                                            <select class="form-control form-control-sm select2" id="paymentMethod" name="paymentMethod" style="width:100%">
                                                <option value="">Semua Cara Bayar</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>No. Registrasi</label>
                                            <input type="text" class="form-control form-control-sm" id="noRegistrasi" name="noRegistrasi" placeholder="Cari No. Registrasi">
                                        </div>
                                        <div class="col-md-3">
                                            <label>Nama Pasien</label>
                                            <input type="text" class="form-control form-control-sm" id="namaPasien" name="namaPasien" placeholder="Cari Nama Pasien">
                                        </div>
                                        <div class="col-md-3">
                                            <label>Pencarian Umum</label>
                                            <input type="text" class="form-control form-control-sm" id="searchGlobal" name="search" placeholder="Cari No. Kwitansi / No. RM">
                                        </div>
                                        <div class="col-md-3 d-flex align-items-end">
                                            <button type="button" class="btn btn-sm btn-primary mr-1" id="btnSearch">
                                                <i class="fas fa-search"></i> Cari Transaksi
                                            </button>
                                            <button type="button" class="btn btn-sm btn-warning" id="btnReset">
                                                <i class="fas fa-undo"></i> Reset
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Table -->
                            <table id="billingTable" class="table table-sm table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tgl Transaksi</th>
                                        <th>No. Billing</th>
                                        <th>No. Registrasi</th>
                                        <th>Nama Pasien</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Kasir</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Billing Pasien</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="detailContent">
                    <div class="text-center py-5">
                        <i class="fas fa-spinner fa-spin fa-2x"></i>
                        <p class="mt-2">Memuat data...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-success" id="btnPrintReceipt">
                    <i class="fas fa-print"></i> Cetak Ulang Kwitansi
                </button>
                <button type="button" class="btn btn-sm btn-info" id="btnPrintDetail">
                    <i class="fas fa-file-invoice"></i> Cetak Rincian
                </button>
                <button type="button" class="btn btn-sm btn-danger" id="btnVoid">
                    <i class="fas fa-times"></i> Void
                </button>
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Shift Summary -->
<div class="modal fade" id="modalShiftSummary" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Rekapitulasi Shift / Tutup Kasir</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="shiftForm">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Shift Mulai</label>
                            <input type="datetime-local" class="form-control form-control-sm" id="shiftStart" name="shiftStart">
                        </div>
                        <div class="col-md-4">
                            <label>Shift Selesai</label>
                            <input type="datetime-local" class="form-control form-control-sm" id="shiftEnd" name="shiftEnd">
                        </div>
                        <div class="col-md-3">
                            <label>Kasir</label>
                            <input type="text" class="form-control form-control-sm" id="shiftKasir" name="kasirId" placeholder="ID Kasir (opsional)">
                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            <button type="button" class="btn btn-sm btn-primary" id="btnLoadShift">
                                <i class="fas fa-sync"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <hr>
                <div id="shiftSummaryResult">
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-cash-register fa-2x"></i>
                        <p class="mt-2">Masukkan periode shift untuk melihat rekap</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-success" id="btnPrintShift">
                    <i class="fas fa-print"></i> Cetak Rekap
                </button>
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Void -->
<div class="modal fade" id="modalVoid" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Konfirmasi Void / Batal</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Perhatian!</strong> Tindakan ini akan membatalkan transaksi dan tidak dapat dibatalkan.
                </div>
                <div class="form-group">
                    <label>No. Kwitansi</label>
                    <input type="text" class="form-control" id="voidNoKwitansi" readonly>
                </div>
                <div class="form-group">
                    <label>Alasan Pembatalan <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="voidReason" rows="3" placeholder="Masukkan alasan pembatalan..."></textarea>
                </div>
                <div class="form-group">
                    <label>Disetujui Oleh (Atasan)</label>
                    <input type="text" class="form-control" id="voidApprovedBy" placeholder="Nama atasan yang menyetujui">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger" id="btnConfirmVoid">
                    <i class="fas fa-check"></i> Ya, Batalkan
                </button>
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
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
    $(document).ready(function() {

        let currentNoKwitansi = '';
        let currentData = null;

        function checkSession(response) {
            if (response && response.status === 'session_expired') {
                window.location.href = "<?= base_url('auth/login') ?>";
                return false;
            }
            return true;
        }

        function formatRupiah(amount) {
            if (!amount) return 'Rp 0';
            return 'Rp ' + Number(amount).toLocaleString('id-ID');
        }

        function formatDateDisplay(dateString) {
            if (!dateString) return '-';
            try {
                const date = new Date(dateString);
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                return date.getDate() + ' ' + months[date.getMonth()] + ' ' + date.getFullYear() + ' ' +
                    String(date.getHours()).padStart(2, '0') + ':' + String(date.getMinutes()).padStart(2, '0');
            } catch (e) {
                return dateString;
            }
        }

        function getStatusBadge(status) {
            const map = {
                'lunas': {
                    class: 'badge-success',
                    label: 'Lunas'
                },
                'belum_bayar': {
                    class: 'badge-warning',
                    label: 'Belum Bayar'
                },
                'lebih_bayar': {
                    class: 'badge-info',
                    label: 'Lebih Bayar'
                },
                'void': {
                    class: 'badge-danger',
                    label: 'Batal'
                }
            };
            const s = map[status] || {
                class: 'badge-secondary',
                label: status || '-'
            };
            return '<span class="badge ' + s.class + '">' + s.label + '</span>';
        }

        // Load filter options
        function loadFilterOptions() {
            $.ajax({
                url: "<?= site_url('billing/filterOptions') ?>",
                method: 'GET',
                dataType: 'JSON',
                success: function(response) {
                    if (response.status === 'success' && response.data) {
                        // Payment Status
                        const statusSelect = $('#paymentStatus');
                        statusSelect.find('option:not(:first)').remove();
                        if (response.data.paymentStatuses) {
                            response.data.paymentStatuses.forEach(function(status) {
                                statusSelect.append('<option value="' + status + '">' +
                                    status.charAt(0).toUpperCase() + status.slice(1) + '</option>');
                            });
                        }

                        // Payment Methods
                        const methodSelect = $('#paymentMethod');
                        methodSelect.find('option:not(:first)').remove();
                        if (response.data.paymentMethods) {
                            response.data.paymentMethods.forEach(function(method) {
                                methodSelect.append('<option value="' + method.jenisPembayaranNm + '">' +
                                    method.jenisPembayaranNm + '</option>');
                            });
                        }
                    }
                }
            });
        }

        // Initialize DataTable
        var billingTable = $('#billingTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            dom: 'Bfrtip',
            ajax: {
                url: "<?= base_url('billing/datatables') ?>",
                type: 'POST',
                contentType: 'application/json',
                data: function(d) {
                    // Add filter values
                    d.startDate = $('#startDate').val();
                    d.endDate = $('#endDate').val();
                    d.paymentStatus = $('#paymentStatus').val();
                    d.paymentMethod = $('#paymentMethod').val();
                    d.noRegistrasi = $('#noRegistrasi').val();
                    d.namaPasien = $('#namaPasien').val();
                    d.search = $('#searchGlobal').val();
                    return JSON.stringify(d);
                }
            },
            columnDefs: [{
                    orderable: false,
                    targets: [0, 8]
                },
                {
                    targets: [0, 8],
                    className: 'text-center'
                }
            ],
            columns: [{
                    data: 'rownum'
                },
                {
                    data: 'tglKwitansiDisplay',
                    defaultContent: '-'
                },
                {
                    data: 'noKwitansi',
                    defaultContent: '-'
                },
                {
                    data: 'noRegistrasi',
                    defaultContent: '-'
                },
                {
                    data: 'namaPasien',
                    defaultContent: '-'
                },
                {
                    data: 'totalTagihanDisplay',
                    defaultContent: 'Rp 0'
                },
                {
                    data: 'paymentStatusBadge',
                    defaultContent: '<span class="badge badge-secondary">-</span>'
                },
                {
                    data: 'kasirName',
                    defaultContent: '-'
                },
                {
                    data: 'aksi',
                    orderable: false,
                    defaultContent: ''
                }
            ],
            buttons: [{
                    extend: 'excel',
                    text: 'Excel',
                    className: 'btn-sm btn-primary <?= session()->get('flag_export') === 1 ? '' : 'd-none' ?>',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                },
                {
                    extend: 'print',
                    text: 'Cetak',
                    className: 'btn-sm btn-info <?= session()->get('flag_print') === 1 ? '' : 'd-none' ?>',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                }
            ],
            oLanguage: {
                sSearch: 'Cari Data:',
                sInfoEmpty: 'Tidak ada data',
                sInfo: 'Menampilkan _START_ - _END_ dari _TOTAL_ data',
                sInfoFiltered: '(difilter dari _MAX_ data)',
                sZeroRecords: 'Data tidak ditemukan',
                sProcessing: '<i class="fas fa-spinner fa-spin fa-2x"></i>',
                oPaginate: {
                    sFirst: 'Awal',
                    sPrevious: 'Sebelum',
                    sNext: 'Berikut',
                    sLast: 'Akhir'
                }
            }
        });

        // Search button
        $('#btnSearch').on('click', function() {
            billingTable.ajax.reload(null, false);
        });

        // Reset button
        $('#btnReset').on('click', function() {
            $('#filterForm')[0].reset();
            $('#paymentStatus').val('').trigger('change');
            $('#paymentMethod').val('').trigger('change');
            billingTable.ajax.reload(null, false);
        });

        // Enter key for search
        $('#filterForm input').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                $('#btnSearch').click();
            }
        });

        // Load filter options on page load
        loadFilterOptions();

        // View Detail
        $(document).on('click', '.view', function() {
            const noKwitansi = $(this).data('id');
            currentNoKwitansi = noKwitansi;

            $('#modalDetail').modal('show');
            $('#detailContent').html(`
            <div class="text-center py-5">
                <i class="fas fa-spinner fa-spin fa-2x"></i>
                <p class="mt-2">Memuat data...</p>
            </div>
        `);

            $.ajax({
                url: "<?= site_url('billing/detail') ?>",
                method: 'GET',
                data: {
                    noKwitansi: noKwitansi
                },
                dataType: 'JSON',
                success: function(response) {
                    if (!checkSession(response)) return;
                    if (response.status === 'error' || !response.data) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message || 'Data tidak ditemukan'
                        });
                        $('#modalDetail').modal('hide');
                        return;
                    }

                    currentData = response.data;
                    renderDetail(currentData);
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan: ' + error
                    });
                    $('#modalDetail').modal('hide');
                }
            });
        });

        function renderDetail(data) {
            let html = '';

            // Info Pasien
            html += `
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h5 class="card-title"><i class="fas fa-user"></i> Info Pasien</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3"><strong>Nama Pasien</strong></div>
                            <div class="col-md-3">: ${data.namaPasien || '-'}</div>
                            <div class="col-md-3"><strong>No. RM</strong></div>
                            <div class="col-md-3">: ${data.noPasien || '-'}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"><strong>No. Registrasi</strong></div>
                            <div class="col-md-3">: ${data.noRegistrasi || '-'}</div>
                            <div class="col-md-3"><strong>Tanggal</strong></div>
                            <div class="col-md-3">: ${data.tanggal || '-'}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"><strong>Status</strong></div>
                            <div class="col-md-3">: ${getStatusBadge(data.paymentStatus)}</div>
                            <div class="col-md-3"><strong>No. Kwitansi</strong></div>
                            <div class="col-md-3">: ${data.noKwitansi || '-'}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;

            // Rincian Tagihan
            html += `
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h5 class="card-title"><i class="fas fa-file-invoice"></i> Rincian Tagihan</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Deskripsi</th>
                                        <th>Qty</th>
                                        <th>Harga</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>`;

            if (data.details && data.details.length > 0) {
                let subTotal = 0;
                let diskon = 0;
                data.details.forEach(function(item) {
                    const total = item.total || 0;
                    const tarif = item.tarif || 0;
                    subTotal += total;
                    diskon += item.potongan || 0;
                    html += `
                    <tr>
                        <td>${item.itemCd || '-'}</td>
                        <td>${item.itemName || '-'}</td>
                        <td class="text-center">${item.jumlah || 0}</td>
                        <td class="text-right">${formatRupiah(tarif)}</td>
                        <td class="text-right">${formatRupiah(total)}</td>
                    </tr>`;
                });
                html += `
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-right"><strong>Sub Total</strong></td>
                                        <td class="text-right"><strong>${formatRupiah(subTotal)}</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-right"><strong>Diskon</strong></td>
                                        <td class="text-right"><strong>${formatRupiah(diskon)}</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-right"><strong>Total</strong></td>
                                        <td class="text-right"><strong>${data.totalTagihan || 'Rp 0'}</strong></td>
                                    </tr>
                                </tfoot>`;
            } else {
                html += `
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada rincian tagihan</td>
                                </tr>`;
            }

            html += `
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;

            // Info Pembayaran
            html += `
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-success">
                    <div class="card-header">
                        <h5 class="card-title"><i class="fas fa-credit-card"></i> Info Pembayaran</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3"><strong>Cara Bayar</strong></div>
                            <div class="col-md-3">: ${data.caraBayar || '-'}</div>
                            <div class="col-md-3"><strong>Bayar</strong></div>
                            <div class="col-md-3">: ${data.totalDibayar || 'Rp 0'}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"><strong>Kembalian</strong></div>
                            <div class="col-md-3">: ${data.changeAmount || 'Rp 0'}</div>
                            <div class="col-md-3"><strong>Petugas</strong></div>
                            <div class="col-md-3">: ${data.petugas || '-'}</div>
                        </div>`;

            if (data.paymentMethods && data.paymentMethods.length > 0) {
                html += `
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <strong>Rincian Pembayaran:</strong><br>
                                <div class="mt-1">`;
                data.paymentMethods.forEach(function(pm) {
                    const cls = pm.isDeposit ? 'payment-method-badge-deposit' :
                        (pm.jenisPembayaranNm === 'Tunai' ? 'payment-method-badge-cash' : 'payment-method-badge-other');
                    html += `<span class="payment-method-badge ${cls}">${pm.jenisPembayaranNm}: ${formatRupiah(pm.amount)}</span> `;
                });
                html += `
                                </div>
                            </div>
                        </div>`;
            }

            html += `
                    </div>
                </div>
            </div>
        </div>`;

            // Void button visibility
            if (data.canVoid && data.paymentStatus !== 'void') {
                $('#btnVoid').show();
            } else {
                $('#btnVoid').hide();
            }

            $('#detailContent').html(html);
        }

        // Print Receipt
        $(document).on('click', '.print', function() {
            const noKwitansi = $(this).data('id');
            printReceipt(noKwitansi, 'KWITANSI');
        });

        $('#btnPrintReceipt').on('click', function() {
            if (currentNoKwitansi) {
                printReceipt(currentNoKwitansi, 'KWITANSI');
            }
        });

        $('#btnPrintDetail').on('click', function() {
            if (currentNoKwitansi) {
                printReceipt(currentNoKwitansi, 'RINCIAN');
            }
        });

        function printReceipt(noKwitansi, type) {
            Swal.fire({
                title: 'Mencetak...',
                text: 'Mohon tunggu',
                allowOutsideClick: false,
                didOpen: function() {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: "<?= site_url('billing/printReceipt') ?>",
                method: 'POST',
                data: {
                    noKwitansi: noKwitansi,
                    printType: type
                },
                dataType: 'JSON',
                success: function(response) {
                    Swal.close();
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message || 'Kwitansi berhasil dicetak'
                        });
                        // In real implementation, open print dialog or download PDF
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message || 'Gagal mencetak'
                        });
                    }
                },
                error: function() {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal menghubungi server'
                    });
                }
            });
        }

        // Void Transaction
        $('#btnVoid').on('click', function() {
            if (!currentNoKwitansi) return;

            $('#voidNoKwitansi').val(currentNoKwitansi);
            $('#voidReason').val('');
            $('#voidApprovedBy').val('');
            $('#modalVoid').modal('show');
            $('#modalDetail').modal('hide');
        });

        $(document).on('click', '.void', function() {
            const noKwitansi = $(this).data('id');
            const status = $(this).data('status');

            if (status === 'void') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Info',
                    text: 'Transaksi ini sudah dibatalkan'
                });
                return;
            }

            $('#voidNoKwitansi').val(noKwitansi);
            $('#voidReason').val('');
            $('#voidApprovedBy').val('');
            $('#modalVoid').modal('show');
        });

        $('#btnConfirmVoid').on('click', function() {
            const noKwitansi = $('#voidNoKwitansi').val();
            const reason = $('#voidReason').val().trim();
            const approvedBy = $('#voidApprovedBy').val().trim();

            if (!reason) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Alasan pembatalan harus diisi'
                });
                $('#voidReason').focus();
                return;
            }

            Swal.fire({
                title: 'Yakin ingin membatalkan transaksi?',
                text: 'Tindakan ini tidak dapat dibatalkan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Batalkan!',
                cancelButtonText: 'Batal'
            }).then(function(result) {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= site_url('billing/void') ?>",
                        method: 'POST',
                        data: {
                            noKwitansi: noKwitansi,
                            reason: reason,
                            approvedBy: approvedBy
                        },
                        dataType: 'JSON',
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                $('#modalVoid').modal('hide');
                                billingTable.ajax.reload(null, false);
                                // Close detail if open
                                if ($('#modalDetail').hasClass('show')) {
                                    $('#modalDetail').modal('hide');
                                }
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.message
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Gagal menghubungi server'
                            });
                        }
                    });
                }
            });
        });

        // Shift Summary
        $('#btnShiftSummary').on('click', function() {
            // Set default date range to today
            const now = new Date();
            const today = now.toISOString().slice(0, 10);
            const shiftStart = new Date(now);
            shiftStart.setHours(7, 0, 0, 0);
            const shiftEnd = new Date(now);
            shiftEnd.setHours(15, 0, 0, 0);

            $('#shiftStart').val(shiftStart.toISOString().slice(0, 16));
            $('#shiftEnd').val(shiftEnd.toISOString().slice(0, 16));
            $('#shiftKasir').val('');
            $('#shiftSummaryResult').html(`
            <div class="text-center py-4 text-muted">
                <i class="fas fa-cash-register fa-2x"></i>
                <p class="mt-2">Klik tombol refresh untuk melihat rekap</p>
            </div>
        `);
            $('#modalShiftSummary').modal('show');
        });

        $('#btnLoadShift').on('click', function() {
            const shiftStart = $('#shiftStart').val();
            const shiftEnd = $('#shiftEnd').val();
            const kasirId = $('#shiftKasir').val();

            if (!shiftStart || !shiftEnd) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Tanggal shift harus diisi'
                });
                return;
            }

            $('#shiftSummaryResult').html(`
            <div class="text-center py-4">
                <i class="fas fa-spinner fa-spin fa-2x"></i>
                <p class="mt-2">Memuat data...</p>
            </div>
        `);

            $.ajax({
                url: "<?= site_url('billing/shiftSummary') ?>",
                method: 'GET',
                data: {
                    shiftStart: shiftStart,
                    shiftEnd: shiftEnd,
                    kasirId: kasirId
                },
                dataType: 'JSON',
                success: function(response) {
                    if (response.status === 'success' && response.data) {
                        const d = response.data;
                        let html = `
                    <div class="row">
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fas fa-receipt"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Transaksi</span>
                                    <span class="info-box-number">${d.totalTransactions || 0}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-money-bill-wave"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Pendapatan</span>
                                    <span class="info-box-number">${formatRupiah(d.totalRevenue || 0)}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="fas fa-hand-holding-usd"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Deposit Terpakai</span>
                                    <span class="info-box-number">${formatRupiah(d.depositUsed || 0)}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-coins"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Tunai</span>
                                    <span class="info-box-number">${formatRupiah(d.cashTotal || 0)}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-primary"><i class="fas fa-credit-card"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Non-Tunai</span>
                                    <span class="info-box-number">${formatRupiah(d.nonCashTotal || 0)}</span>
                                </div>
                            </div>
                        </div>
                    </div>`;

                        if (d.paymentMethodSummary && d.paymentMethodSummary.length > 0) {
                            html += `
                        <div class="row">
                            <div class="col-md-12">
                                <h6>Rincian Metode Pembayaran</h6>
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Metode</th>
                                            <th>Jumlah Transaksi</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>`;
                            d.paymentMethodSummary.forEach(function(pm) {
                                html += `
                                        <tr>
                                            <td>${pm.methodName || '-'}</td>
                                            <td class="text-center">${pm.count || 0}</td>
                                            <td class="text-right">${formatRupiah(pm.totalAmount || 0)}</td>
                                        </tr>`;
                            });
                            html += `
                                    </tbody>
                                </table>
                            </div>
                        </div>`;
                        }

                        html += `
                    <div class="row">
                        <div class="col-md-12">
                            <small class="text-muted">
                                <i class="fas fa-user"></i> Kasir: ${d.kasirName || '-'} 
                                | <i class="fas fa-clock"></i> Shift: ${formatDateDisplay(d.shiftStart)} - ${formatDateDisplay(d.shiftEnd)}
                            </small>
                        </div>
                    </div>`;

                        $('#shiftSummaryResult').html(html);
                    } else {
                        $('#shiftSummaryResult').html(`
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                            ${response.message || 'Gagal memuat data'}
                        </div>
                    `);
                    }
                },
                error: function() {
                    $('#shiftSummaryResult').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                        Gagal menghubungi server
                    </div>
                `);
                }
            });
        });

        $('#btnPrintShift').on('click', function() {
            window.print();
        });

        // Toastr configuration
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: 3000
        };

    });
</script>

<?= $this->endSection('script'); ?>