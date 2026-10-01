<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<style>
    :root {
        --bil-blue: #0d6efd;
        --bil-blue-dark: #0b5ed7;
        --bil-blue-soft: #f0f4ff;
        --bil-text: #212529;
        --bil-muted: #6c757d;
        --bil-border: #e9ecef;
        --bil-bg-soft: #f8f9fa;
        --bil-green-bg: #e6f4ea;
        --bil-green-text: #0f5132;
        --bil-green-border: #badbcc;
        --bil-red: #dc3545;
        --bil-red-bg: #fdecea;
        --bil-red-text: #842029;
        --bil-red-border: #f1aeb5;
        --bil-amber-bg: #fff8e1;
        --bil-amber-text: #856404;
        --bil-amber-border: #ffe69c;
    }

    body { background-color: #f4f6f9; color: var(--bil-text); }

    .form-control, .select2-container--default .select2-selection--single {
        font-size: .85rem !important;
        border-radius: .4rem;
        border: 1px solid #ced4da;
    }

    .bil-card {
        background: #fff;
        border: 1px solid var(--bil-border);
        border-radius: .6rem;
        box-shadow: 0 1px 2px rgba(0,0,0,.03);
        padding: 1.25rem;
        margin-bottom: 1.25rem;
    }

    .page-title { font-size: 1.4rem; font-weight: 700; margin-bottom: 2px; color: var(--bil-text); }
    .page-subtitle { font-size: .85rem; color: var(--bil-muted); }
    .breadcrumb-custom { font-size: .8rem; color: var(--bil-muted); margin-bottom: 1.5rem; }
    .breadcrumb-custom a { color: var(--bil-blue); text-decoration: none; }
    .field-label { font-size: .8rem; font-weight: 700; color: var(--bil-text); margin-bottom: .4rem; }

    .btn-bil-primary {
        background-color: var(--bil-blue); border-color: var(--bil-blue); color: #fff;
        font-weight: 600; font-size: .85rem; border-radius: .4rem; padding: .45rem 1.2rem;
    }
    .btn-bil-primary:hover { background-color: var(--bil-blue-dark); color: #fff; }
    .btn-bil-outline {
        background-color: #fff; border: 1px solid #ced4da; color: var(--bil-text);
        font-weight: 600; font-size: .85rem; border-radius: .4rem; padding: .45rem 1.2rem;
    }
    .btn-bil-outline:hover { background-color: var(--bil-bg-soft); color: var(--bil-text); }
    .btn-reset {
        background-color: #fff; border: 1px solid #ced4da; color: var(--bil-text);
        border-radius: .4rem; height: calc(1.5em + .75rem + 2px); width: 100%;
        display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: .85rem;
    }
    .btn-reset:hover { background-color: var(--bil-bg-soft); }

    table.dataTable thead th, .table thead th {
        background-color: var(--bil-bg-soft); font-size: .75rem; color: var(--bil-text);
        font-weight: 600; border-bottom: 1px solid var(--bil-border); border-top: none;
        padding: .8rem; white-space: nowrap;
    }
    table.dataTable tbody td, .table tbody td {
        font-size: .85rem; vertical-align: middle; border-bottom: 1px solid var(--bil-border); padding: .8rem;
    }
    .kwitansi-link { color: var(--bil-blue); font-weight: 600; text-decoration: none; }

    .badge-bil-lunas   { background-color: var(--bil-green-bg); color: var(--bil-green-text); padding: .3rem .8rem; border-radius: 99px; font-size: .72rem; font-weight: 600; border: 1px solid var(--bil-green-border); display: inline-block; text-align: center; min-width: 80px; }
    .badge-bil-belum   { background-color: var(--bil-amber-bg); color: var(--bil-amber-text); padding: .3rem .8rem; border-radius: 99px; font-size: .72rem; font-weight: 600; border: 1px solid var(--bil-amber-border); display: inline-block; text-align: center; min-width: 80px; }
    .badge-bil-lebih   { background-color: var(--bil-blue-soft); color: var(--bil-blue-dark); padding: .3rem .8rem; border-radius: 99px; font-size: .72rem; font-weight: 600; border: 1px solid #cfe0ff; display: inline-block; text-align: center; min-width: 80px; }
    .badge-bil-aktif   { background-color: var(--bil-green-bg); color: var(--bil-green-text); padding: .3rem .8rem; border-radius: 99px; font-size: .72rem; font-weight: 600; border: 1px solid var(--bil-green-border); display: inline-block; text-align: center; min-width: 60px; }
    .badge-bil-batal   { background-color: var(--bil-red-bg); color: var(--bil-red-text); padding: .3rem .8rem; border-radius: 99px; font-size: .72rem; font-weight: 600; border: 1px solid var(--bil-red-border); display: inline-block; text-align: center; min-width: 60px; }

    .aksi-cell { display: flex; gap: .75rem; align-items: center; }
    .btn-icon-bil { background: none; border: none; color: var(--bil-muted); font-size: .95rem; padding: 0; cursor: pointer; }
    .btn-icon-bil.view { color: var(--bil-blue); }
    .btn-icon-bil.print { color: #495057; }
    .btn-icon-bil.void { color: var(--bil-red); }
    .btn-icon-bil.disabled { opacity: .35; cursor: not-allowed; }
    .btn-icon-bil:hover:not(.disabled) { opacity: .7; }

    .dt-footer-wrapper { display: flex; justify-content: space-between; align-items: center; padding-top: 1rem; }
    .dataTables_wrapper .dataTables_info { padding-top: 0 !important; font-size: .85rem; color: var(--bil-muted); }
    .dataTables_wrapper .dataTables_paginate { padding-top: 0 !important; }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: .3rem .8rem; margin-left: 2px; border-radius: .3rem; border: 1px solid var(--bil-border);
        background: #fff; color: var(--bil-text) !important; font-size: .85rem;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current { background: var(--bil-blue) !important; color: #fff !important; border-color: var(--bil-blue); }

    /* Modal detail */
    #modalDetailBilling .modal-dialog { max-width: 680px; }
    .bil-detail-label { font-size: .72rem; color: var(--bil-muted); font-weight: 600; text-transform: uppercase; letter-spacing: .02em; }
    .bil-detail-value { font-size: .9rem; font-weight: 600; color: var(--bil-text); }
    .bil-rincian-table th { background: var(--bil-bg-soft); font-size: .72rem; padding: .5rem .6rem; }
    .bil-rincian-table td { font-size: .82rem; padding: .5rem .6rem; }
    .bil-total-box { background: var(--bil-bg-soft); border-radius: .5rem; padding: .9rem 1rem; }
    .bil-total-row { display: flex; justify-content: space-between; font-size: .85rem; padding: .2rem 0; }
    .bil-total-row.grand { font-weight: 700; font-size: .95rem; border-top: 1px solid var(--bil-border); margin-top: .4rem; padding-top: .5rem; }
    .bil-pay-item { display: flex; justify-content: space-between; font-size: .83rem; padding: .35rem 0; border-bottom: 1px dashed var(--bil-border); }
    .bil-pay-item:last-child { border-bottom: none; }
    .bil-copy-watermark { color: var(--bil-red); font-size: .7rem; font-weight: 700; border: 1px solid var(--bil-red); padding: .1rem .5rem; border-radius: .3rem; }

    html.dark-mode .content-wrapper { background-color: #24282e; color: #dee2e6; }
    html.dark-mode .bil-card, html.dark-mode .bil-total-box { background-color: #343a40; border-color: #454d55; }
    html.dark-mode .page-title, html.dark-mode .field-label, html.dark-mode .bil-detail-value { color: #f1f1f1; }
    html.dark-mode .page-subtitle, html.dark-mode .breadcrumb-custom, html.dark-mode .bil-detail-label { color: #adb5bd; }
    html.dark-mode .form-control, html.dark-mode select.form-control {
        background-color: #2b3035; border-color: #555d66; color: #f1f1f1;
    }
    html.dark-mode table.dataTable thead th, html.dark-mode .table thead th { background-color: #2b3035 !important; color: #adb5bd; border-color: #454d55 !important; }
    html.dark-mode table.dataTable tbody td, html.dark-mode .table tbody td { color: #dee2e6; border-color: #454d55; }
    html.dark-mode table.dataTable tbody tr:hover { background-color: #3a4149; }
    html.dark-mode .btn-bil-outline, html.dark-mode .btn-reset { background-color: #343a40; border-color: #555d66; color: #f1f1f1; }
    html.dark-mode .dataTables_wrapper .dataTables_paginate .paginate_button { background: #343a40; border-color: #454d55; color: #adb5bd !important; }
    html.dark-mode .dataTables_wrapper .dataTables_paginate .paginate_button.current { background: var(--bil-blue) !important; color: #fff !important; border-color: var(--bil-blue); }
</style>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper" style="padding: 1.5rem 2rem;">

    <div class="breadcrumb-custom">
        Kasir &nbsp;&gt;&nbsp; <strong>Riwayat Transaksi / Billing</strong>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title">Riwayat Transaksi &amp; Billing</h1>
            <div class="page-subtitle">Cari, cetak ulang, dan kelola transaksi pembayaran pasien.</div>
        </div>
        <div class="d-flex gap-2">
            <button class="btn-bil-outline" id="btn_export_billing"><i class="fas fa-download mr-1"></i> Export</button>
        </div>
    </div>

    <div class="bil-card">
        <div class="row align-items-end">
            <div class="col-md-3">
                <label class="field-label">Cari (No. Kwitansi / Pasien)</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="f_cari" placeholder="No. kwitansi / no. registrasi / nama pasien...">
                    <div class="input-group-append"><span class="input-group-text"><i class="fas fa-search"></i></span></div>
                </div>
            </div>
            <div class="col-md-2">
                <label class="field-label">Tanggal Mulai</label>
                <input type="date" class="form-control" id="f_start_date">
            </div>
            <div class="col-md-2">
                <label class="field-label">Tanggal Akhir</label>
                <input type="date" class="form-control" id="f_end_date">
            </div>
            <div class="col-md-2">
                <label class="field-label">Status Bayar</label>
                <select class="form-control" id="f_status">
                    <option value="">Semua Status</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="field-label">Kasir</label>
                <select class="form-control" id="f_kasir">
                    <option value="">Semua Kasir</option>
                </select>
            </div>
            <div class="col-md-1">
                <button class="btn-reset" id="btn_reset"><i class="fas fa-sync-alt mr-1"></i></button>
            </div>
        </div>
    </div>

    <div class="bil-card" style="padding: 1.5rem;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 style="font-weight:700; font-size:1rem; margin-bottom:2px;">Daftar Transaksi</h6>
        </div>

        <div class="table-responsive">
            <table id="billingTable" class="table table-hover" style="width:100%; margin:0;">
                <thead>
                    <tr>
                        <th>No. Kwitansi</th>
                        <th>Tanggal</th>
                        <th>No. Registrasi</th>
                        <th>Nama Pasien</th>
                        <th>Kasir</th>
                        <th>Total Tagihan</th>
                        <th>Total Dibayar</th>
                        <th>Status Bayar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <div id="table-footer-wrapper" class="dt-footer-wrapper"></div>
    </div>
</div>

<!-- Modal Detail Billing -->
<div class="modal fade" id="modalDetailBilling" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h4 class="modal-title" style="font-size:1.1rem; font-weight:700;">Detail Billing Pasien</h4>
                </div>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" id="modalDetailBillingBody">
                <div class="text-center py-4"><i class="fas fa-spinner fa-spin fa-2x text-primary"></i></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-bil-outline" id="btn_cetak_rincian" disabled><i class="fas fa-print mr-1"></i> Cetak Rincian</button>
                <button type="button" class="btn-bil-outline" id="btn_cetak_kwitansi" disabled><i class="fas fa-print mr-1"></i> Cetak Ulang Kwitansi</button>
                <button type="button" class="btn-bil-primary" style="background-color: var(--bil-red); border-color: var(--bil-red);" id="btn_open_void" disabled><i class="fas fa-ban mr-1"></i> Void</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Void -->
<div class="modal fade" id="modalVoidBilling" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="font-size:1.1rem; font-weight:700;">Batalkan Transaksi (Void)</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning" style="font-size:.85rem;">
                    <i class="fas fa-exclamation-triangle mr-1"></i>
                    Void memerlukan persetujuan supervisor dan tidak dapat dibatalkan.
                </div>
                <input type="hidden" id="void_no_kwitansi">
                <div class="mb-3">
                    <label class="field-label">No. Kwitansi</label>
                    <input type="text" class="form-control" id="void_no_kwitansi_display" disabled>
                </div>
                <div class="mb-3">
                    <label class="field-label">Alasan Void <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="void_reason" rows="3" placeholder="Masukkan alasan pembatalan transaksi"></textarea>
                    <span class="text-danger errorVoidReason" style="font-size:.75rem;"></span>
                </div>
                <div class="mb-3">
                    <label class="field-label">Approval Supervisor (Username) <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="void_approved_by" placeholder="Masukkan username supervisor">
                    <span class="text-danger errorVoidApprovedBy" style="font-size:.75rem;"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-bil-outline" data-dismiss="modal">Batal</button>
                <button type="button" class="btn-bil-primary" style="background-color: var(--bil-red); border-color: var(--bil-red);" id="btn_confirm_void">
                    <i class="fas fa-ban mr-1"></i> Konfirmasi Void
                </button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script>
$(document).ready(function () {

    function checkSession(response) {
        if (response && response.status === 'session_expired') {
            window.location.href = "<?= base_url('auth/login') ?>";
            return false;
        }
        return true;
    }

    function rupiahBil(n) {
        return 'Rp ' + (Number(n) || 0).toLocaleString('id-ID');
    }

    // ------------------------------------------------------------
    // Filter dropdown: status bayar & kasir
    // ------------------------------------------------------------
    function loadFilterOptions() {
        $.ajax({
            url: "<?= site_url('listbilling/fetchFilterOptions') ?>",
            method: 'GET', dataType: 'JSON',
            success: function (response) {
                if (response.status !== 'success') return;
                var statusLabel = { belum_bayar: 'Belum Bayar', lebih_bayar: 'Lebih Bayar', lunas: 'Lunas' };
                var $status = $('#f_status').empty().append('<option value="">Semua Status</option>');
                (response.data.paymentStatuses || []).forEach(function (s) {
                    $status.append('<option value="' + s + '">' + (statusLabel[s] || s) + '</option>');
                });
            }
        });

        $.ajax({
            url: "<?= site_url('listbilling/fetchKasirList') ?>",
            method: 'GET', dataType: 'JSON',
            success: function (response) {
                if (response.status !== 'success') return;
                var $kasir = $('#f_kasir').empty().append('<option value="">Semua Kasir</option>');
                (response.data || []).forEach(function (k) {
                    $kasir.append('<option value="' + k.id + '">' + k.text + '</option>');
                });
            }
        });
    }
    loadFilterOptions();

    // ------------------------------------------------------------
    // DataTable
    // ------------------------------------------------------------
    var table = $('#billingTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: false,
        autoWidth: false,
        pageLength: 25,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'Semua']],
        order: [[1, 'desc']],
        dom: 'Brt<"dt-footer-wrapper"lip>',
        buttons: [
            {
                extend: 'excel',
                text: 'Export',
                className: 'd-none',
                title: 'Riwayat Transaksi Billing',
                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8] }
            }
        ],
        ajax: {
            url: "<?= site_url('listbilling/datatables') ?>",
            type: 'POST',
            contentType: 'application/json',
            data: function (d) {
                d.cari          = $('#f_cari').val();
                d.startDate     = $('#f_start_date').val();
                d.endDate       = $('#f_end_date').val();
                d.paymentStatus = $('#f_status').val();
                d.kasirId       = $('#f_kasir').val();
                return JSON.stringify(d);
            }
        },
        columns: [
            { data: 'kwitansiLink' },
            { data: 'tglFormat' },
            { data: 'NoRegistrasi' },
            { data: 'NamaPasien' },
            { data: 'KasirName' },
            { data: 'totalTagihanFormat', className: 'text-right' },
            { data: 'totalDibayarFormat', className: 'text-right' },
            { data: 'paymentStatusBadge', className: 'text-center' },
            { data: 'statusKwitansiBadge', className: 'text-center' },
            { data: 'aksi', orderable: false, className: 'text-center' }
        ],
        language: {
            sInfo: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            sInfoEmpty: "Menampilkan 0 - 0 dari 0 data",
            oPaginate: { sPrevious: "<i class='fas fa-angle-left'></i>", sNext: "<i class='fas fa-angle-right'></i>" }
        },
        drawCallback: function () {
            var paginate = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate').detach();
            var info = $(this).closest('.dataTables_wrapper').find('.dataTables_info').detach();
            $('#table-footer-wrapper').empty();
            if (info.length) $('#table-footer-wrapper').append(info);
            if (paginate.length) $('#table-footer-wrapper').append(paginate);
        }
    });

    $('#btn_export_billing').on('click', function () { table.button(0).trigger(); });

    $('#f_cari').on('keyup', function () { table.ajax.reload(); });
    $('#f_start_date, #f_end_date, #f_status, #f_kasir').on('change', function () { table.ajax.reload(); });
    $('#btn_reset').click(function () {
        $('#f_cari, #f_start_date, #f_end_date, #f_status, #f_kasir').val('');
        table.ajax.reload();
    });

    // ------------------------------------------------------------
    // Modal Detail
    // ------------------------------------------------------------
    var currentDetailData = null;

    function renderDetailModal(d) {
        currentDetailData = d;

        var statusBayarBadge = {
            lunas: '<span class="badge-bil-lunas">Lunas</span>',
            belum_bayar: '<span class="badge-bil-belum">Belum Bayar</span>',
            lebih_bayar: '<span class="badge-bil-lebih">Lebih Bayar</span>'
        }[d.paymentStatus] || d.paymentStatus;

        var tglFormat = d.tglKwitansi ? new Date(d.tglKwitansi).toLocaleString('id-ID', {
            day: '2-digit', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit'
        }) + ' WIB' : '-';

        var rincianRows = '';
        (d.details || []).forEach(function (it) {
            rincianRows += '<tr>' +
                '<td>' + it.itemName + '<div style="font-size:.72rem; color:var(--bil-muted);">' + it.itemCd + '</div></td>' +
                '<td class="text-center">' + it.jumlah + '</td>' +
                '<td class="text-right">' + rupiahBil(it.tarif) + '</td>' +
                '<td class="text-right">' + rupiahBil(it.total) + '</td>' +
                '</tr>';
        });
        if (!rincianRows) {
            rincianRows = '<tr><td colspan="4" class="text-center text-muted">Tidak ada rincian item.</td></tr>';
        }

        var paymentRows = '';
        (d.paymentMethods || []).forEach(function (pm) {
            paymentRows += '<div class="bil-pay-item"><span>' + pm.jenisPembayaranNm + (pm.isDeposit ? ' (Deposit)' : '') + '</span><span>' + rupiahBil(pm.amount) + '</span></div>';
        });
        if (!paymentRows) {
            paymentRows = '<div class="text-muted" style="font-size:.82rem;">Belum ada pembayaran.</div>';
        }

        var html = '' +
            '<div class="row mb-3">' +
                '<div class="col-6 mb-2"><div class="bil-detail-label">Nama Pasien</div><div class="bil-detail-value">' + (d.namaPasien || '-') + '</div></div>' +
                '<div class="col-6 mb-2"><div class="bil-detail-label">No. Kwitansi</div><div class="bil-detail-value">' + d.noKwitansi + '</div></div>' +
                '<div class="col-6 mb-2"><div class="bil-detail-label">No. Registrasi</div><div class="bil-detail-value">' + (d.noRegistrasi || '-') + '</div></div>' +
                '<div class="col-6 mb-2"><div class="bil-detail-label">Tanggal</div><div class="bil-detail-value">' + tglFormat + '</div></div>' +
                '<div class="col-6 mb-2"><div class="bil-detail-label">Status Bayar</div><div>' + statusBayarBadge + '</div></div>' +
                '<div class="col-6 mb-2"><div class="bil-detail-label">Kasir</div><div class="bil-detail-value">' + (d.kasirName || '-') + '</div></div>' +
            '</div>' +
            '<div class="mb-3">' +
                '<div class="bil-detail-label mb-2">Rincian Tagihan</div>' +
                '<table class="table table-sm table-bordered bil-rincian-table mb-0">' +
                    '<thead><tr><th>Deskripsi</th><th class="text-center">Qty</th><th class="text-right">Harga</th><th class="text-right">Total</th></tr></thead>' +
                    '<tbody>' + rincianRows + '</tbody>' +
                '</table>' +
            '</div>' +
            '<div class="bil-total-box mb-3">' +
                '<div class="bil-total-row"><span>Total Tagihan</span><span>' + rupiahBil(d.totalTagihan) + '</span></div>' +
                '<div class="bil-total-row"><span>Total Dibayar</span><span>' + rupiahBil(d.totalDibayar) + '</span></div>' +
                '<div class="bil-total-row grand"><span>Kembalian</span><span>' + rupiahBil(d.changeAmount) + '</span></div>' +
            '</div>' +
            '<div class="mb-1">' +
                '<div class="bil-detail-label mb-2">Metode Pembayaran</div>' +
                paymentRows +
            '</div>';

        $('#modalDetailBillingBody').html(html);

        var canVoid = !!d.canVoid;
        $('#btn_open_void').prop('disabled', !canVoid);
        $('#btn_cetak_kwitansi, #btn_cetak_rincian').prop('disabled', false);
    }

    function openDetailModal(noKwitansi) {
        $('#modalDetailBillingBody').html('<div class="text-center py-4"><i class="fas fa-spinner fa-spin fa-2x text-primary"></i></div>');
        $('#btn_cetak_kwitansi, #btn_cetak_rincian, #btn_open_void').prop('disabled', true);
        $('#modalDetailBilling').modal('show');

        $.ajax({
            url: "<?= site_url('listbilling/fetchSingleData') ?>/" + noKwitansi,
            method: 'GET', dataType: 'JSON',
            success: function (response) {
                if (!checkSession(response)) return;
                if (response.status !== 'success') {
                    $('#modalDetailBillingBody').html('<div class="text-center text-muted py-4">' + (response.message || 'Data tidak ditemukan') + '</div>');
                    return;
                }
                renderDetailModal(response.data);
            },
            error: function () {
                $('#modalDetailBillingBody').html('<div class="text-center text-danger py-4">Terjadi kesalahan koneksi ke server.</div>');
            }
        });
    }

    $(document).on('click', '.kwitansi-link, .btn-icon-bil.view', function (e) {
        e.preventDefault();
        openDetailModal($(this).data('nokwitansi'));
    });

    // ------------------------------------------------------------
    // Reprint (cetak ulang) - konten kwitansi/rincian dirender di
    // browser dari data /fetchSingleData, endpoint reprint tetap
    // dipanggil di server untuk pencatatan/audit.
    // ------------------------------------------------------------
    function fetchDetailData(noKwitansi) {
        return $.ajax({
            url: "<?= site_url('listbilling/fetchSingleData') ?>/" + noKwitansi,
            method: 'GET',
            dataType: 'JSON'
        });
    }

    function tglLengkap(iso) {
        if (!iso) return '-';
        return new Date(iso).toLocaleString('id-ID', {
            day: '2-digit', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit'
        }) + ' WIB';
    }

    function buildPrintHtml(d, reprintType) {
        var isKwitansi = reprintType === 'KWITANSI';
        var judul = isKwitansi ? 'KWITANSI PEMBAYARAN' : 'RINCIAN BIAYA';

        var rincianRows = '';
        (d.details || []).forEach(function (it) {
            rincianRows += '<tr>' +
                '<td>' + it.itemName + '</td>' +
                '<td style="text-align:center;">' + it.jumlah + '</td>' +
                '<td style="text-align:right;">' + rupiahBil(it.tarif) + '</td>' +
                '<td style="text-align:right;">' + rupiahBil(it.total) + '</td>' +
                '</tr>';
        });
        if (!rincianRows) {
            rincianRows = '<tr><td colspan="4" style="text-align:center; color:#888;">Tidak ada rincian item.</td></tr>';
        }

        var paymentBlock = '';
        if (isKwitansi) {
            var payRows = '';
            (d.paymentMethods || []).forEach(function (pm) {
                payRows += '<tr><td>' + pm.jenisPembayaranNm + (pm.isDeposit ? ' (Deposit)' : '') + '</td><td style="text-align:right;">' + rupiahBil(pm.amount) + '</td></tr>';
            });
            if (!payRows) payRows = '<tr><td colspan="2" style="text-align:center; color:#888;">Belum ada pembayaran.</td></tr>';

            paymentBlock =
                '<table class="totals">' +
                    '<tr><td>Total Tagihan</td><td style="text-align:right;">' + rupiahBil(d.totalTagihan) + '</td></tr>' +
                    '<tr><td>Total Dibayar</td><td style="text-align:right;">' + rupiahBil(d.totalDibayar) + '</td></tr>' +
                    '<tr class="grand"><td>Kembalian</td><td style="text-align:right;">' + rupiahBil(d.changeAmount) + '</td></tr>' +
                '</table>' +
                '<div class="section-title">Metode Pembayaran</div>' +
                '<table class="items">' + payRows + '</table>';
        } else {
            paymentBlock =
                '<table class="totals">' +
                    '<tr class="grand"><td>Total Tagihan</td><td style="text-align:right;">' + rupiahBil(d.totalTagihan) + '</td></tr>' +
                '</table>';
        }

        return '' +
        '<!DOCTYPE html><html><head><meta charset="utf-8"><title>' + judul + ' - ' + d.noKwitansi + '</title>' +
        '<style>' +
            'body{font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#212529;padding:24px;max-width:560px;margin:0 auto;position:relative;}' +
            '.watermark{position:fixed;top:40%;left:50%;transform:translate(-50%,-50%) rotate(-30deg);font-size:72px;font-weight:700;color:rgba(220,53,69,0.15);pointer-events:none;z-index:0;letter-spacing:4px;}' +
            '.header{text-align:center;border-bottom:2px solid #212529;padding-bottom:10px;margin-bottom:14px;}' +
            '.header h1{font-size:16px;margin:0 0 2px;}' +
            '.header p{font-size:11px;margin:0;color:#555;}' +
            '.title{text-align:center;font-weight:700;font-size:14px;margin:10px 0 16px;text-decoration:underline;}' +
            '.info-grid{display:grid;grid-template-columns:1fr 1fr;gap:4px 12px;font-size:12px;margin-bottom:14px;}' +
            '.info-grid .lbl{color:#666;}' +
            '.section-title{font-weight:700;font-size:12px;margin:14px 0 6px;text-transform:uppercase;color:#444;}' +
            'table.items{width:100%;border-collapse:collapse;font-size:12px;margin-bottom:10px;}' +
            'table.items th{background:#f1f1f1;text-align:left;padding:5px 6px;border:1px solid #ddd;font-size:11px;}' +
            'table.items td{padding:5px 6px;border:1px solid #ddd;}' +
            'table.totals{width:100%;font-size:12.5px;margin-top:6px;}' +
            'table.totals td{padding:3px 0;}' +
            'table.totals tr.grand td{font-weight:700;font-size:14px;border-top:1px solid #212529;padding-top:6px;}' +
            '.footer{margin-top:36px;display:flex;justify-content:space-between;font-size:12px;}' +
            '.footer .sign{text-align:center;width:160px;}' +
            '.footer .sign .line{margin-top:48px;border-top:1px solid #212529;padding-top:4px;}' +
            '.reprint-note{margin-top:18px;font-size:10.5px;color:#888;text-align:center;}' +
            '@media print{.watermark{color:rgba(220,53,69,0.18);}}' +
        '</style></head><body>' +
            '<div class="watermark">CETAK ULANG</div>' +
            '<div class="header">' +
                '<h1>NAMA KLINIK / RUMAH SAKIT</h1>' +
                '<p>Alamat klinik, kota - Telp: (000) 000-0000</p>' +
            '</div>' +
            '<div class="title">' + judul + '</div>' +
            '<div class="info-grid">' +
                '<div><span class="lbl">No. Kwitansi</span><br>' + d.noKwitansi + '</div>' +
                '<div><span class="lbl">No. Registrasi</span><br>' + (d.noRegistrasi || '-') + '</div>' +
                '<div><span class="lbl">Nama Pasien</span><br>' + (d.namaPasien || '-') + '</div>' +
                '<div><span class="lbl">No. Pasien</span><br>' + (d.noPasien || '-') + '</div>' +
                '<div><span class="lbl">Tanggal</span><br>' + tglLengkap(d.tglKwitansi) + '</div>' +
                '<div><span class="lbl">Kasir</span><br>' + (d.kasirName || '-') + '</div>' +
            '</div>' +
            '<div class="section-title">Rincian Tagihan</div>' +
            '<table class="items"><thead><tr><th>Deskripsi</th><th style="text-align:center;">Qty</th><th style="text-align:right;">Harga</th><th style="text-align:right;">Total</th></tr></thead><tbody>' + rincianRows + '</tbody></table>' +
            paymentBlock +
            '<div class="footer">' +
                '<div class="sign">Pasien / Keluarga<div class="line">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</div></div>' +
                '<div class="sign">Kasir<div class="line">' + (d.kasirName || '-') + '</div></div>' +
            '</div>' +
            '<div class="reprint-note">Dokumen ini adalah cetak ulang dan bukan bukti pembayaran asli. Dicetak pada ' + new Date().toLocaleString('id-ID') + '.</div>' +
        '</body></html>';
    }

    function openPrintWindow(d, reprintType) {
        var win = window.open('', '_blank', 'width=680,height=800');
        if (!win) {
            Swal.fire({ icon: 'warning', title: 'Popup diblokir', text: 'Izinkan popup untuk mencetak dokumen.' });
            return;
        }
        win.document.open();
        win.document.write(buildPrintHtml(d, reprintType));
        win.document.close();
        win.onload = function () {
            win.focus();
            win.print();
        };
    }

    function doReprint(noKwitansi, reprintType) {
        Swal.fire({ title: 'Menyiapkan dokumen...', allowOutsideClick: false, didOpen: function () { Swal.showLoading(); } });

        $.ajax({
            url: "<?= site_url('listbilling/reprint') ?>",
            method: 'POST',
            data: { noKwitansi: noKwitansi, reprintType: reprintType },
            dataType: 'JSON'
        }).then(function (response) {
            if (!checkSession(response)) return $.Deferred().reject();
            if (response.status !== 'success') {
                Swal.close();
                Swal.fire({ icon: 'error', title: 'Gagal', text: response.message || 'Gagal mencatat cetak ulang.' });
                return $.Deferred().reject();
            }
            // Pakai data yang sudah ada di modal kalau noKwitansi sama, supaya tidak fetch dua kali.
            if (currentDetailData && currentDetailData.noKwitansi === noKwitansi) {
                return $.Deferred().resolve({ status: 'success', data: currentDetailData });
            }
            return fetchDetailData(noKwitansi);
        }).then(function (detailResponse) {
            Swal.close();
            if (!detailResponse || detailResponse.status !== 'success') {
                Swal.fire({ icon: 'error', title: 'Gagal', text: (detailResponse && detailResponse.message) || 'Data transaksi tidak ditemukan.' });
                return;
            }
            openPrintWindow(detailResponse.data, reprintType);
        }).catch(function () {
            Swal.close();
        });
    }

    $(document).on('click', '.btn-icon-bil.print', function () {
        doReprint($(this).data('nokwitansi'), 'KWITANSI');
    });
    $('#btn_cetak_kwitansi').click(function () {
        if (currentDetailData) doReprint(currentDetailData.noKwitansi, 'KWITANSI');
    });
    $('#btn_cetak_rincian').click(function () {
        if (currentDetailData) doReprint(currentDetailData.noKwitansi, 'RINCIAN');
    });

    // ------------------------------------------------------------
    // Void
    // ------------------------------------------------------------
    function openVoidModal(noKwitansi) {
        $('#void_no_kwitansi').val(noKwitansi);
        $('#void_no_kwitansi_display').val(noKwitansi);
        $('#void_reason').val('');
        $('#void_approved_by').val('');
        $('.errorVoidReason, .errorVoidApprovedBy').text('');
        $('#modalDetailBilling').modal('hide');
        $('#modalVoidBilling').modal('show');
    }

    $(document).on('click', '.btn-icon-bil.void:not(.disabled)', function () {
        openVoidModal($(this).data('nokwitansi'));
    });
    $('#btn_open_void').click(function () {
        if (currentDetailData) openVoidModal(currentDetailData.noKwitansi);
    });

    $('#btn_confirm_void').click(function () {
        $('.errorVoidReason, .errorVoidApprovedBy').text('');

        var noKwitansi = $('#void_no_kwitansi').val();
        var reason     = $('#void_reason').val().trim();
        var approvedBy = $('#void_approved_by').val().trim();

        var valid = true;
        if (!reason)     { $('.errorVoidReason').text('Alasan void harus diisi'); valid = false; }
        if (!approvedBy) { $('.errorVoidApprovedBy').text('Approval supervisor harus diisi'); valid = false; }
        if (!valid) return;

        Swal.fire({
            title: 'Yakin ingin membatalkan transaksi ini?',
            text: 'Tindakan ini tidak dapat dibatalkan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, batalkan transaksi',
            cancelButtonText: 'Tidak'
        }).then(function (result) {
            if (!result.isConfirmed) return;

            $.ajax({
                url: "<?= site_url('listbilling/void') ?>",
                method: 'POST',
                data: { noKwitansi: noKwitansi, reason: reason, approvedBy: approvedBy },
                dataType: 'JSON',
                success: function (response) {
                    if (!checkSession(response)) return;
                    if (response.status === 'success') {
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message || 'Transaksi berhasil dibatalkan.' });
                        $('#modalVoidBilling').modal('hide');
                        table.ajax.reload(null, false);
                    } else if (response.errors) {
                        if (response.errors.reason)     $('.errorVoidReason').text(response.errors.reason);
                        if (response.errors.approvedBy) $('.errorVoidApprovedBy').text(response.errors.approvedBy);
                    } else {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: response.message || 'Gagal membatalkan transaksi.' });
                    }
                },
                error: function () {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan koneksi ke server.' });
                }
            });
        });
    });

});
</script>
<?= $this->endSection(); ?>