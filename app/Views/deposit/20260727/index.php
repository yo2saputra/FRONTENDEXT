<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>
<!-- Toastr -->
<link rel="stylesheet" href="<?= base_url('plugins/toastr/toastr.min.css') ?>">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<style>
    .patient-header-card {
        border: 1px solid #e3e6f0;
        border-radius: .35rem;
        background-color: #fff;
        padding: 1rem 1.25rem;
    }

    .patient-avatar {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        object-fit: cover;
        background-color: #eef1f7;
    }

    .patient-name {
        font-size: 1.15rem;
        font-weight: 700;
        margin-bottom: 2px;
        text-transform: uppercase;
    }

    .patient-meta {
        font-size: .80rem;
        color: #6c757d;
    }

    .info-label {
        font-size: .70rem;
        color: #6c757d;
        text-transform: none;
        margin-bottom: 2px;
    }

    .info-value {
        font-size: .85rem;
        font-weight: 600;
        color: #2c2c2c;
    }

    .badge-penjamin {
        background-color: #d7f5e6;
        color: #1c9a5b;
        font-weight: 600;
        font-size: .75rem;
        padding: .3rem .6rem;
        border-radius: .35rem;
    }

    .deposit-stepper {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: .5rem;
    }

    .step-pill {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        padding: .55rem 1rem;
        border-radius: .35rem;
        font-size: .80rem;
        font-weight: 600;
        background-color: #eef1f6;
        color: #8a8f98;
    }

    .step-pill .step-num {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background-color: #cfd4dc;
        color: #fff;
        font-size: .70rem;
    }

    .step-pill.active {
        background-color: #2459e8;
        color: #fff;
    }

    .step-pill.active .step-num {
        background-color: rgba(255, 255, 255, .25);
        color: #fff;
    }

    .step-divider {
        color: #c2c6cc;
    }

    .info-banner {
        background-color: #eaf2ff;
        border: 1px solid #d6e6ff;
        color: #1e4ed8;
        border-radius: .35rem;
        font-size: .80rem;
        padding: .6rem .9rem;
    }

    .panel-card {
        border: 1px solid #e3e6f0;
        border-radius: .35rem;
        background-color: #fff;
        height: 100%;
    }

    .panel-card .panel-header {
        font-size: .85rem;
        font-weight: 700;
        padding: .85rem 1rem;
        border-bottom: 1px solid #eef0f3;
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    .panel-card .panel-body-pad {
        padding: 1rem;
    }

    .nominal-display {
        font-size: 2rem;
        font-weight: 700;
        text-align: right;
        border: 1px solid #2459e8;
        border-radius: .35rem;
        padding: .4rem .9rem;
    }

    .terbilang-text {
        font-size: .75rem;
        color: #6c757d;
        font-style: italic;
    }

    .payment-method-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: .6rem;
    }

    .payment-method-btn {
        border: 1px solid #dfe2e8;
        border-radius: .35rem;
        background-color: #fff;
        padding: .7rem .3rem;
        text-align: center;
        font-size: .70rem;
        font-weight: 600;
        color: #4a4f57;
        cursor: pointer;
        position: relative;
    }

    .payment-method-btn i,
    .payment-method-btn svg {
        display: block;
        margin: 0 auto .35rem auto;
        font-size: 1.25rem;
    }

    .payment-method-btn.active {
        border-color: #17a2b8;
        color: #17a2b8;
        background-color: #f3fcfd;
    }

    .payment-method-btn .check-badge {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background-color: #17a2b8;
        color: #fff;
        font-size: .60rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .deposit-summary-box {
        background-color: #eafaf0;
        border: 1px solid #cdf0dc;
        border-radius: .35rem;
        padding: .85rem 1rem;
    }

    .deposit-summary-box .summary-label {
        font-size: .70rem;
        color: #1c9a5b;
        margin-bottom: 2px;
    }

    .deposit-summary-box .summary-value {
        font-size: 1.15rem;
        font-weight: 700;
        color: #16793f;
    }

    .table-tagihan thead th {
        font-size: .72rem;
        font-weight: 700;
        color: #4a4f57;
        border-top: none;
        white-space: nowrap;
    }

    .table-tagihan tbody td {
        font-size: .80rem;
        vertical-align: middle;
    }

    .total-tagihan-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: .85rem 0 0 0;
        border-top: 1px solid #eef0f3;
        margin-top: .5rem;
    }

    .total-tagihan-row .label {
        font-weight: 700;
        font-size: .85rem;
    }

    .total-tagihan-row .value {
        font-weight: 700;
        font-size: 1.1rem;
        color: #2459e8;
    }

    .gunakan-deposit-box {
        border: 1px solid #e3e6f0;
        border-radius: .35rem;
        padding: .9rem 1rem;
        margin-top: 1rem;
    }

    .gunakan-deposit-box .gd-title {
        font-size: .80rem;
        font-weight: 700;
    }

    .switch-sm {
        position: relative;
        display: inline-block;
        width: 38px;
        height: 20px;
    }

    .switch-sm input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .switch-sm .slider-round {
        position: absolute;
        cursor: pointer;
        inset: 0;
        background-color: #ccc;
        border-radius: 999px;
        transition: .2s;
    }

    .switch-sm .slider-round:before {
        position: absolute;
        content: "";
        height: 14px;
        width: 14px;
        left: 3px;
        bottom: 3px;
        background-color: #fff;
        border-radius: 50%;
        transition: .2s;
    }

    .switch-sm input:checked+.slider-round {
        background-color: #2459e8;
    }

    .switch-sm input:checked+.slider-round:before {
        transform: translateX(18px);
    }

    .ringkasan-row {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        font-size: .82rem;
        margin-bottom: .65rem;
    }

    .ringkasan-row .r-label {
        color: #6c757d;
    }

    .ringkasan-row .r-value {
        font-weight: 600;
    }

    .ringkasan-row.divider {
        border-top: 1px solid #eef0f3;
        padding-top: .65rem;
    }

    .sisa-bayar-value {
        color: #2459e8;
        font-weight: 700;
        font-size: 1rem;
    }

    .daftar-pembayaran-table thead th {
        font-size: .70rem;
        color: #6c757d;
        border-top: none;
        font-weight: 600;
    }

    .empty-payment-state {
        text-align: center;
        color: #adb3bb;
        font-size: .80rem;
        padding: 1.5rem 0;
    }

    .total-dibayar-row,
    .sisa-bayar-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: .85rem;
        margin-bottom: .4rem;
    }

    .total-dibayar-row .value {
        color: #1c9a5b;
        font-weight: 700;
    }

    .sisa-bayar-row .value {
        color: #e03131;
        font-weight: 700;
    }

    .tips-box {
        background-color: #fff7e6;
        border: 1px solid #ffe8b8;
        color: #8a6116;
        border-radius: .35rem;
        font-size: .75rem;
        padding: .6rem .8rem;
        margin-top: .75rem;
    }

    .bottom-info-card {
        border: 1px solid #e3e6f0;
        border-radius: .35rem;
        background-color: #fff;
        height: 100%;
    }

    .bottom-info-card .bic-header {
        font-size: .80rem;
        font-weight: 700;
        padding: .75rem 1rem;
        border-bottom: 1px solid #eef0f3;
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    .bottom-info-card .bic-body {
        padding: .9rem 1rem;
    }

    .deposit-info-row {
        display: flex;
        justify-content: space-between;
        font-size: .82rem;
        margin-bottom: .6rem;
    }

    .deposit-info-row .di-value {
        font-weight: 700;
    }

    .table-riwayat thead th {
        font-size: .70rem;
        color: #6c757d;
        font-weight: 600;
        border-top: none;
    }

    .table-riwayat tbody td {
        font-size: .78rem;
    }

    .aksi-lainnya-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: .6rem;
    }

    .aksi-btn {
        border: 1px solid #e3e6f0;
        border-radius: .35rem;
        background-color: #fff;
        padding: .8rem .3rem;
        text-align: center;
        font-size: .70rem;
        font-weight: 600;
        color: #4a4f57;
        cursor: pointer;
    }

    .aksi-btn i {
        display: block;
        margin: 0 auto .4rem auto;
        font-size: 1.1rem;
    }

    .aksi-btn.danger {
        color: #e03131;
    }

    .btn-fix-w {
        width: 60px;
        padding-top: 0px;
        padding-bottom: 0px;
    }

    .control-sidebar {
        color: black;
    }

    :is(
        body.dark-mode, html.dark-mode,
        body.dark, html.dark,
        [data-bs-theme="dark"],
        [data-theme="dark"]
    ) {

        & .patient-header-card,
        & .panel-card,
        & .bottom-info-card {
            background-color: #343a40;
            border-color: #454d55;
        }

        & .patient-avatar {
            background-color: #454d55;
        }

        & .patient-name {
            color: #f1f1f1;
        }

        & .patient-meta,
        & .info-label,
        & .terbilang-text,
        & .r-label,
        & .empty-payment-state,
        & .table-tagihan thead th,
        & .daftar-pembayaran-table thead th,
        & .table-riwayat thead th {
            color: #adb5bd;
        }

        & .info-value,
        & .r-value,
        & .table-tagihan tbody td,
        & .table-riwayat tbody td,
        & .panel-header,
        & .bic-header,
        & .gd-title,
        & .total-tagihan-row .label,
        & .total-dibayar-row,
        & .sisa-bayar-row,
        & .deposit-info-row,
        & .aksi-btn,
        & .payment-method-btn,
        & .nominal-display,
        & .control-sidebar {
            color: #f1f1f1;
        }

        & .badge-penjamin {
            background-color: #1c9a5b;
            color: #fff;
        }

        & .step-pill {
            background-color: #454d55;
            color: #ced4da;
        }

        & .step-pill .step-num {
            background-color: #6c757d;
        }

        & .step-pill.active {
            background-color: #2459e8;
            color: #fff;
        }

        & .step-divider {
            color: #6c757d;
        }

        & .info-banner {
            background-color: #1c2a4d;
            border-color: #2a3b66;
            color: #8fb4ff;
        }

        & .panel-card .panel-header,
        & .bic-header {
            border-bottom-color: #454d55;
        }

        & .nominal-display {
            background-color: #2b3035;
            border-color: #2459e8;
        }

        & .payment-method-btn {
            background-color: #2b3035;
            border-color: #454d55;
        }

        & .payment-method-btn.active {
            border-color: #17a2b8;
            background-color: #16323a;
            color: #5fd0e3;
        }

        & .deposit-summary-box {
            background-color: #16331f;
            border-color: #1c4d2c;
        }

        & .deposit-summary-box .summary-label {
            color: #5fce8f;
        }

        & .deposit-summary-box .summary-value {
            color: #6fe39c;
        }

        & .gunakan-deposit-box {
            border-color: #454d55;
        }

        & .ringkasan-row.divider,
        & .total-tagihan-row {
            border-top-color: #454d55;
        }

        & .sisa-bayar-value {
            color: #6fa0ff;
        }

        & .total-dibayar-row .value {
            color: #6fe39c;
        }

        & .sisa-bayar-row .value {
            color: #ff7a7a;
        }

        & .tips-box {
            background-color: #3a3115;
            border-color: #5c4c1c;
            color: #e6c878;
        }

        & .aksi-btn {
            background-color: #2b3035;
            border-color: #454d55;
        }

        & .aksi-btn.danger {
            color: #ff7a7a;
        }

        & .form-control,
        & textarea.form-control {
            background-color: #2b3035;
            border-color: #454d55;
            color: #f1f1f1;
        }

        & .form-control::placeholder {
            color: #8a8f98;
        }

        & .switch-sm .slider-round {
            background-color: #6c757d;
        }
    }
</style>
<?= $this->endSection('style'); ?>

<?= $this->section('controlsidebaricon'); ?>
<li class="nav-item">
    <a class="nav-link text-md" data-widget="control-sidebar" data-slide="true" href="#" role="button" id="toggle-sidebar-pasien">
        <i class="fas fa-wheelchair"></i>
    </a>
</li>
<?= $this->endSection('controlsidebaricon'); ?>

<?= $this->section('content'); ?>

<?php
$session = session();
?>

<div class="content-wrapper">

    <input type="hidden" id="f_no_registrasi" value="">
    <input type="hidden" id="f_medrec_id" value="">
    <input type="hidden" id="f_saldo_deposit_raw" value="0">
    <input type="hidden" id="f_no_kwitansi" value="">

    <section class="content pt-3">
        <div class="container-fluid">

            <div id="no-patient-selected" class="text-center py-5">
                <i class="fas fa-user-injured fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Silakan pilih pasien dari sidebar terlebih dahulu.</h5>
                <button class="btn btn-primary mt-2" onclick="$('#toggle-sidebar-pasien').trigger('click')">
                    <i class="fas fa-search mr-1"></i> Buka Daftar Pasien
                </button>
            </div>

            <div id="main-deposit-content" style="display: none;">

                <div class="row">
                    <div class="col-md-12">

                        <div class="patient-header-card mb-3">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <img src="<?= base_url('dist/img/avatar5.png') ?>" alt="foto pasien" class="patient-avatar" id="img_pasien">
                                </div>
                                <div class="col-md-3">
                                    <div class="patient-name" id="lbl_nama_pasien">NAMA PASIEN</div>
                                    <div class="patient-meta">
                                        <span id="lbl_no_rm">RM000000</span> &bull;
                                        <span id="lbl_gender">Laki-laki</span> &bull;
                                        <span id="lbl_umur">0 Tahun</span>
                                    </div>
                                    <div class="patient-meta">
                                        <i class="fas fa-phone-alt"></i> <span id="lbl_mobile_no">-</span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="info-label">No. Registrasi</div>
                                    <div class="info-value" id="lbl_no_registrasi">REG-000000</div>
                                </div>
                                <div class="col-md-1">
                                    <div class="info-label">Tanggal</div>
                                    <div class="info-value" id="lbl_tgl_registrasi">-</div>
                                </div>
                                <div class="col-md-2">
                                    <div class="info-label">Poli</div>
                                    <div class="info-value" id="lbl_poli">Poli Umum</div>
                                </div>
                                <div class="col-md-2">
                                    <div class="info-label">Dokter</div>
                                    <div class="info-value" id="lbl_dokter">Nama Dokter</div>
                                </div>
                                <div class="col-md-1 text-right">
                                    <div class="info-label">Penjamin</div>
                                    <span class="badge-penjamin" id="lbl_penjamin">UMUM</span>
                                </div>
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-md-7">
                                <div class="deposit-stepper">
                                    <span class="step-pill active">
                                        <span class="step-num">1</span> Deposit / Uang Muka
                                    </span>
                                    <span class="step-divider"><i class="fas fa-chevron-right"></i></span>
                                    <span class="step-pill">
                                        <span class="step-num">2</span> Tagihan
                                    </span>
                                    <span class="step-divider"><i class="fas fa-chevron-right"></i></span>
                                    <span class="step-pill">
                                        <span class="step-num">3</span> Pembayaran
                                    </span>
                                    <span class="step-divider"><i class="fas fa-chevron-right"></i></span>
                                    <span class="step-pill">
                                        <span class="step-num">4</span> Selesai
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="info-banner">
                                    <i class="fas fa-info-circle"></i>
                                    Deposit digunakan untuk pembayaran tagihan hari ini atau kunjungan berikutnya.
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <div class="panel-card">
                                    <div class="panel-header">
                                        <i class="fas fa-wallet text-primary"></i> CAPTURE DEPOSIT (UANG MUKA)
                                    </div>
                                    <div class="panel-body-pad">

                                        <div class="form-group">
                                            <label for="jumlah_deposit" class="info-label">Jumlah Deposit</label>
                                            <input type="text" class="form-control nominal-display" id="jumlah_deposit" name="jumlah_deposit" value="0" inputmode="numeric">
                                            <div class="terbilang-text mt-1" id="terbilang_deposit">Terbilang: -</div>
                                        </div>

                                        <div class="form-group">
                                            <label class="info-label">Metode Pembayaran</label>
                                            <div class="payment-method-grid" id="metode_pembayaran">
                                                <div class="payment-method-btn active" data-metode="cash">
                                                    <span class="check-badge"><i class="fas fa-check"></i></span>
                                                    <i class="fas fa-money-bill-wave"></i>
                                                    Cash
                                                </div>
                                                <div class="payment-method-btn" data-metode="transfer">
                                                    <i class="fas fa-university"></i>
                                                    Transfer
                                                </div>
                                                <div class="payment-method-btn" data-metode="qris">
                                                    <i class="fas fa-qrcode"></i>
                                                    QRIS
                                                </div>
                                                <div class="payment-method-btn" data-metode="debit">
                                                    <i class="far fa-credit-card"></i>
                                                    Debit
                                                </div>
                                                <div class="payment-method-btn" data-metode="kartu_kredit">
                                                    <i class="fas fa-credit-card"></i>
                                                    Kartu Kredit
                                                </div>
                                            </div>
                                            <div class="payment-method-grid mt-2" style="grid-template-columns: 1fr;">
                                                <div class="payment-method-btn" data-metode="lainnya">
                                                    <i class="fas fa-ellipsis-h"></i>
                                                    Lainnya
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="catatan_deposit" class="info-label">Catatan (Opsional)</label>
                                            <textarea class="form-control form-control-sm" id="catatan_deposit" name="catatan_deposit" rows="2" placeholder="Contoh: Deposit kunjungan hari ini"></textarea>
                                        </div>

                                        <div class="deposit-summary-box mb-3">
                                            <div class="row">
                                                <div class="col-5">
                                                    <div class="summary-label">RINGKASAN DEPOSIT</div>
                                                </div>
                                            </div>
                                            <div class="row mt-1">
                                                <div class="col-6">
                                                    <div class="summary-label">Deposit Saat Ini</div>
                                                    <div class="summary-value" id="deposit_saat_ini">Rp 0</div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="summary-label">Deposit Setelah Ini</div>
                                                    <div class="summary-value" id="deposit_setelah_ini">Rp 0</div>
                                                </div>
                                            </div>
                                            <div class="info-banner mt-2 mb-0" style="background-color: transparent; border: none; padding: .25rem 0;">
                                                <i class="fas fa-info-circle"></i>
                                                Deposit ini hanya berlaku untuk kunjungan (kwitansi) ini hari ini. Sisa yang tidak terpakai akan hangus dan tidak bisa dibawa ke kunjungan lain.
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <button type="button" class="btn btn-outline-secondary btn-block" id="btn_batal_deposit">BATAL</button>
                                            </div>
                                            <div class="col-6">
                                                <button type="button" class="btn btn-primary btn-block" id="btn_simpan_deposit">SIMPAN DEPOSIT (F5)</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="panel-card">
                                    <div class="panel-header">
                                        <i class="fas fa-file-invoice text-secondary"></i> RINCIAN TAGIHAN (HARI INI)
                                    </div>
                                    <div class="panel-body-pad">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-tagihan mb-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">No.</th>
                                                        <th scope="col">Jenis</th>
                                                        <th scope="col">Deskripsi</th>
                                                        <th scope="col" class="text-right">Qty</th>
                                                        <th scope="col" class="text-right">Tarif</th>
                                                        <th scope="col" class="text-right">Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody_rincian_tagihan">
                                                    <tr>
                                                        <td colspan="6" class="text-center text-muted">Belum ada data tagihan untuk pasien ini.</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="total-tagihan-row">
                                            <span class="label">TOTAL TAGIHAN</span>
                                            <span class="value" id="total_tagihan">Rp 0</span>
                                        </div>

                                        <div class="gunakan-deposit-box">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="gd-title">GUNAKAN DEPOSIT UNTUK PEMBAYARAN HARI INI</span>
                                                <label class="switch-sm mb-0">
                                                    <input type="checkbox" id="toggle_gunakan_deposit">
                                                    <span class="slider-round"></span>
                                                </label>
                                            </div>

                                            <div class="ringkasan-row mt-3">
                                                <span class="r-label">Saldo Deposit Tersedia</span>
                                                <span class="r-value" id="saldo_deposit_tersedia">Rp 0</span>
                                            </div>

                                            <div class="form-group row align-items-center mb-2">
                                                <label class="col-6 info-label mb-0" for="akan_digunakan">Akan Digunakan</label>
                                                <div class="col-6">
                                                    <div class="input-group input-group-sm">
                                                        <input type="text" class="form-control text-right" id="akan_digunakan" name="akan_digunakan" value="0" disabled>
                                                        <div class="input-group-append">
                                                            <button type="button" class="btn btn-outline-primary btn-sm" id="btn_gunakan_max" disabled>Gunakan Max</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="ringkasan-row mb-0">
                                                <span class="r-label">Sisa Deposit</span>
                                                <span class="r-value" id="sisa_deposit">Rp 0</span>
                                            </div>

                                            <div class="terbilang-text mt-2 mb-2">* Deposit yang digunakan tidak dapat dikembalikan (non-refundable).</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="panel-card">
                                    <div class="panel-header">
                                        <i class="fas fa-receipt text-info"></i> RINGKASAN PEMBAYARAN
                                    </div>
                                    <div class="panel-body-pad">

                                        <div class="ringkasan-row">
                                            <span class="r-label">Total Tagihan (Hari Ini)</span>
                                            <span class="r-value" id="ringkasan_total_tagihan">Rp 0</span>
                                        </div>
                                        <div class="ringkasan-row">
                                            <span class="r-label">Deposit Digunakan</span>
                                            <span class="r-value" id="ringkasan_deposit_digunakan">- Rp 0</span>
                                        </div>
                                        <div class="ringkasan-row divider">
                                            <span class="r-label">Sisa yang Harus Dibayar</span>
                                            <span class="sisa-bayar-value" id="ringkasan_sisa_dibayar">Rp 0</span>
                                        </div>

                                        <div class="info-label mt-3 mb-2">DAFTAR PEMBAYARAN</div>
                                        <div class="table-responsive">
                                            <table class="table table-sm daftar-pembayaran-table mb-2">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Metode</th>
                                                        <th scope="col" class="text-right">Nominal</th>
                                                        <th scope="col" class="text-right">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody_daftar_pembayaran">
                                                    <tr>
                                                        <td colspan="3">
                                                            <div class="empty-payment-state">
                                                                <i class="fas fa-print fa-lg mb-1"></i><br>
                                                                Belum ada pembayaran
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <button type="button" class="btn btn-outline-primary btn-sm btn-block mb-3" id="btn_tambah_pembayaran">
                                            <i class="fas fa-plus mr-1"></i> Tambah Pembayaran
                                        </button>

                                        <div class="total-dibayar-row">
                                            <span>TOTAL DIBAYAR</span>
                                            <span class="value" id="ringkasan_total_dibayar">Rp 0</span>
                                        </div>
                                        <div class="sisa-bayar-row">
                                            <span>SISA BAYAR</span>
                                            <span class="value" id="ringkasan_sisa_bayar">Rp 0</span>
                                        </div>

                                        <div class="tips-box">
                                            <i class="fas fa-lightbulb mr-1"></i>
                                            Setelah deposit disimpan, Anda dapat melanjutkan ke pembayaran tagihan jika ada sisa yang harus dibayar.
                                        </div>

                                        <button type="button" class="btn btn-primary btn-block mt-3" id="btn_lanjut_pembayaran">
                                            LANJUT KE PEMBAYARAN <i class="fas fa-arrow-right ml-1"></i>
                                        </button>

                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">

                            <div class="col-md-3 mb-3">
                                <div class="bottom-info-card">
                                    <div class="bic-header">
                                        <i class="fas fa-wallet text-purple"></i> INFORMASI DEPOSIT PASIEN
                                    </div>
                                    <div class="bic-body">
                                        <div class="deposit-info-row">
                                            <span>Saldo Deposit Saat Ini</span>
                                            <span class="di-value text-primary" id="info_saldo_saat_ini">Rp 0</span>
                                        </div>
                                        <div class="deposit-info-row">
                                            <span>Total Deposit</span>
                                            <span class="di-value text-success" id="info_total_deposit">Rp 0</span>
                                        </div>
                                        <div class="deposit-info-row">
                                            <span>Total Digunakan</span>
                                            <span class="di-value text-danger" id="info_total_digunakan">Rp 0</span>
                                        </div>
                                        <div class="deposit-info-row mb-0">
                                            <span>Transaksi Terakhir</span>
                                            <span class="di-value" id="info_transaksi_terakhir">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="bottom-info-card">
                                    <div class="bic-header">
                                        <i class="fas fa-history"></i> RIWAYAT DEPOSIT
                                    </div>
                                    <div class="bic-body">
                                        <div class="table-responsive" style="max-height: 220px; overflow-y: auto;">
                                            <table class="table table-sm table-riwayat mb-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Tanggal</th>
                                                        <th scope="col">Metode</th>
                                                        <th scope="col" class="text-right">Deposit</th>
                                                        <th scope="col" class="text-right">Digunakan</th>
                                                        <th scope="col" class="text-right">Sisa</th>
                                                        <th scope="col">Oleh</th>
                                                        <th scope="col"></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody_riwayat_deposit">
                                                    <tr>
                                                        <td colspan="7" class="text-center text-muted">Belum ada riwayat deposit.</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="text-right mt-2">
                                            <a href="#" class="small" id="btn_lihat_semua_riwayat">Lihat Semua Riwayat <i class="fas fa-arrow-right ml-1"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 mb-3">
                                <div class="bottom-info-card">
                                    <div class="bic-header">
                                        KETERANGAN
                                    </div>
                                    <div class="bic-body">
                                        <textarea class="form-control form-control-sm" id="keterangan_tambahan" name="keterangan_tambahan" rows="3" placeholder="Tulis catatan jika ada..." maxlength="250"></textarea>
                                        <div class="text-right small text-muted mt-1">
                                            <span id="keterangan_count">0</span> / 250
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <div class="bottom-info-card">
                                    <div class="bic-header">
                                        AKSI LAINNYA
                                    </div>
                                    <div class="bic-body">
                                        <div class="aksi-lainnya-grid">
                                            <div class="aksi-btn" id="btn_cetak_kwitansi">
                                                <i class="fas fa-print"></i>
                                                Cetak Kwitansi
                                            </div>
                                            <div class="aksi-btn" id="btn_lihat_saldo_deposit">
                                                <i class="fas fa-sync-alt"></i>
                                                Refresh Saldo
                                            </div>
                                            <div class="aksi-btn danger" id="btn_batalkan_transaksi">
                                                <i class="fas fa-times-circle"></i>
                                                Batalkan Transaksi
                                            </div>
                                        </div>
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

<?= $this->section('control-sidebar'); ?>
<aside class="control-sidebar control-sidebar-dark" style="height:100vh;">
    <div class="p-1 control-sidebar-content" style="height:602px; overflow-y:auto;">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="card-title">Daftar Pasien</h3>
            </div>
            <div class="card-body p-0"><span id="viewdata"></span></div>
        </div>
    </div>
</aside>
<?= $this->endSection('control-sidebar'); ?>

<?= $this->section('script'); ?>

<script src="<?= base_url('plugins/toastr/toastr.min.js') ?>"></script>

<script>
    $('#active-menu').html($('p#active-menu').html());
    $(document).prop("title", $('p#active-menu').html());

    var metodePembayaranOptions = [];
    var draftPembayaran = [];
    var ringkasanState = {
        totalTagihan: 0,
        totalDibayarConfirmed: 0
    };

    function fetchSidebarPasien() {
        $.ajax({
            method: "GET",
            url: "<?= site_url('deposit/registrasi'); ?>",
            success: function(data) {
                $('#viewdata').html(data);
            },
            error: function(xhr) {
                console.error('fetch error:', xhr.responseText);
            }
        });
    }

    function formatRupiah(angka) {
        var num = parseFloat(angka) || 0;
        return 'Rp ' + num.toLocaleString('id-ID', {
            maximumFractionDigits: 0
        });
    }

    function parseRupiahInput(str) {
        return parseFloat(String(str).replace(/[^0-9]/g, '')) || 0;
    }

    function isMetodeAsuransi(m) {
        if (!m) return false;

        if (m.jenisPembayaranId !== undefined && m.jenisPembayaranId !== null) {
            return Number(m.jenisPembayaranId) === 16;
        }

        var jenis = (m.jenisPembayaran || '').toLowerCase().trim();
        if (jenis === 'asuransi') return true;

        if (m.isAsuransi === true || m.is_asuransi === true || m.requireAsuransi === true) return true;

        var nm = (m.namaMetode || '').toLowerCase();
        var keywordAsuransi = [
            'asuransi', 'asurans', 'bpjs', 'insurance',
            'inhealth', 'mandiri inhealth', 'jamsostek', 'jkn',
            'allianz', 'prudential', 'cigna', 'axa', 'aia',
            'sinarmas', 'manulife', 'great eastern', 'fwd',
            'asabri', 'taspen'
        ];

        return keywordAsuransi.some(function(kw) {
            return nm.indexOf(kw) !== -1;
        });
    }

    function isMetodeVoucher(m) {
        if (!m) return false;

        if (m.jenisPembayaranId !== undefined && m.jenisPembayaranId !== null) {
            return Number(m.jenisPembayaranId) === 15;
        }

        var jenis = (m.jenisPembayaran || '').toLowerCase().trim();
        if (jenis === 'voucher') return true;

        if (m.isVoucher === true || m.is_voucher === true) return true;

        var nm = (m.namaMetode || '').toLowerCase();
        return nm.indexOf('voucher') !== -1;
    }

    // Metode pembayaran yang bertipe piutang (Accounts Receivable), mis. "Asuransi AR" / "Voucher AR".
    // Dikirim dari API sebagai flag `isAr` (dari tmst_jenis_pembayaran.IsAr).
    function isMetodeAR(m) {
        if (!m) return false;
        return m.isAr === true || m.isAr === 1 || m.isAr === '1';
    }

    var payerOptions = [];
    var payerOptionsLoaded = false;

    function fetchPayerOptions(callback) {
        if (payerOptionsLoaded) {
            callback();
            return;
        }
        $.ajax({
            url: "<?= site_url('deposit/payerlist'); ?>",
            method: "GET",
            dataType: "JSON",
            success: function(response) {
                if (response && response.status === 'success') {
                    payerOptions = response.data || [];
                }
                payerOptionsLoaded = true;
                callback();
            },
            error: function() {
                payerOptions = [];
                payerOptionsLoaded = true;
                callback();
            }
        });
    }

    function hitungUmur(tanggalLahir) {
        if (!tanggalLahir) return "0 Tahun";
        var today = new Date();
        var birthDate = new Date(tanggalLahir);
        if (isNaN(birthDate.getTime())) return "-";

        var age = today.getFullYear() - birthDate.getFullYear();
        var m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        return age + " Tahun";
    }

    function formatTglWaktu(isoString) {
        if (!isoString) return '-';
        var d = new Date(isoString);
        if (isNaN(d.getTime())) return isoString;
        var dd = String(d.getDate()).padStart(2, '0');
        var mm = String(d.getMonth() + 1).padStart(2, '0');
        var yyyy = d.getFullYear();
        var hh = String(d.getHours()).padStart(2, '0');
        var mi = String(d.getMinutes()).padStart(2, '0');
        return dd + '/' + mm + '/' + yyyy + ' ' + hh + ':' + mi;
    }

    function formatTglSaja(isoString) {
        if (!isoString) return '-';
        var d = new Date(isoString);
        if (isNaN(d.getTime())) return isoString;
        var dd = String(d.getDate()).padStart(2, '0');
        var mm = String(d.getMonth() + 1).padStart(2, '0');
        var yyyy = d.getFullYear();
        return dd + '/' + mm + '/' + yyyy;
    }

    function fetchSaldoDeposit(no_pasien) {
        var no_registrasi = $('#f_no_registrasi').val();

        if (!no_registrasi) {
            console.error('fetchSaldoDeposit: no_registrasi belum tersedia');
            return;
        }

        $.ajax({
            method: "GET",
            url: "<?= site_url('deposit/saldo'); ?>",
            data: {
                no_pasien: no_pasien,
                no_registrasi: no_registrasi
            },
            dataType: "JSON",
            success: function(response) {
                if (response.status === 'success') {
                    var d = response.data || {};
                    var saldo = d.saldoSaatIni || 0;

                    $('#f_saldo_deposit_raw').val(saldo);

                    $('#deposit_saat_ini').text(formatRupiah(saldo));
                    $('#info_saldo_saat_ini').text(formatRupiah(saldo));
                    $('#info_total_deposit').text(formatRupiah(d.totalDeposit || 0));
                    $('#info_total_digunakan').text(formatRupiah(d.totalDigunakan || 0));
                    $('#info_transaksi_terakhir').text(d.transaksiTerakhir ? formatTglWaktu(d.transaksiTerakhir) : '-');

                    $('#saldo_deposit_tersedia').text(formatRupiah(saldo));
                    $('#sisa_deposit').text(formatRupiah(saldo));

                    hitungDepositSetelahIni();
                } else {
                    console.error('fetchSaldoDeposit error:', response.message);
                }
            },
            error: function(xhr) {
                console.error('fetchSaldoDeposit ajax error:', xhr.responseText);
            }
        });
    }

    function fetchRiwayatDeposit(no_pasien) {
        $.ajax({
            method: "GET",
            url: "<?= site_url('deposit/riwayat'); ?>",
            data: {
                no_pasien: no_pasien
            },
            dataType: "JSON",
            success: function(response) {
                var tbody = $('#tbody_riwayat_deposit');
                tbody.empty();

                if (response.status === 'success' && Array.isArray(response.data) && response.data.length > 0) {
                    response.data.forEach(function(row) {
                        var btnBatal = (row.status === 'aktif') ?
                            '<button type="button" class="btn btn-xs btn-outline-danger btn-batal-riwayat" data-deposit_id="' + row.depositId + '"><i class="fas fa-times"></i></button>' :
                            '';

                        var tr = '<tr data-deposit_id="' + row.depositId + '">' +
                            '<td>' + formatTglWaktu(row.createdDate) + '</td>' +
                            '<td class="text-capitalize">' + (row.metode || '-') + '</td>' +
                            '<td class="text-right">' + formatRupiah(row.jumlahDeposit).replace('Rp ', '') + '</td>' +
                            '<td class="text-right">' + formatRupiah(row.digunakan).replace('Rp ', '') + '</td>' +
                            '<td class="text-right">' + formatRupiah(row.sisa).replace('Rp ', '') + '</td>' +
                            '<td>' + (row.createdBy || '-') + '</td>' +
                            '<td class="text-right">' + btnBatal + '</td>' +
                            '</tr>';
                        tbody.append(tr);
                    });
                } else {
                    tbody.html('<tr><td colspan="7" class="text-center text-muted">Belum ada riwayat deposit.</td></tr>');
                }
            },
            error: function(xhr) {
                console.error('fetchRiwayatDeposit ajax error:', xhr.responseText);
                $('#tbody_riwayat_deposit').html('<tr><td colspan="7" class="text-center text-danger">Gagal memuat riwayat deposit.</td></tr>');
            }
        });
    }

    function hitungDepositSetelahIni() {
        var saldoSekarang = parseFloat($('#f_saldo_deposit_raw').val()) || 0;
        var jumlahBaru = parseRupiahInput($('#jumlah_deposit').val());
        $('#deposit_setelah_ini').text(formatRupiah(saldoSekarang + jumlahBaru));
    }

    function resetRingkasanPembayaran() {
        metodePembayaranOptions = [];
        draftPembayaran = [];
        ringkasanState = {
            totalTagihan: 0,
            totalDibayarConfirmed: 0
        };

        $('#tbody_rincian_tagihan').html('<tr><td colspan="6" class="text-center text-muted">Belum ada data tagihan untuk pasien ini.</td></tr>');
        $('#total_tagihan').text(formatRupiah(0));

        renderDaftarPembayaran();
        renderRingkasanPembayaran();
    }

    function fetchTagihanPembayaran(no_kwitansi, no_pasien) {
        $.ajax({
            method: "GET",
            url: "<?= site_url('deposit/tagihanpembayaran'); ?>",
            data: {
                no_kwitansi: no_kwitansi,
                no_pasien: no_pasien
            },
            dataType: "JSON",
            success: function(response) {
                if (response.status === 'success') {
                    var d = response.data || {};
                    var items = d.items || [];

                    metodePembayaranOptions = d.metodePembayaran || [];

                    var tbody = $('#tbody_rincian_tagihan');
                    tbody.empty();

                    if (items.length) {
                        items.forEach(function(it, idx) {
                            var tr = '<tr>' +
                                '<td>' + (idx + 1) + '</td>' +
                                '<td>' + (it.itemCd || '-') + '</td>' +
                                '<td>' + (it.deskripsi || it.itemCd || '-') + '</td>' +
                                '<td class="text-right">' + (it.qty || 0) + '</td>' +
                                '<td class="text-right">' + formatRupiah(it.tarif).replace('Rp ', '') + '</td>' +
                                '<td class="text-right">' + formatRupiah(it.total).replace('Rp ', '') + '</td>' +
                                '</tr>';
                            tbody.append(tr);
                        });
                    } else {
                        tbody.html('<tr><td colspan="6" class="text-center text-muted">Belum ada data tagihan untuk pasien ini.</td></tr>');
                    }

                    $('#total_tagihan').text(formatRupiah(d.totalTagihan || 0));
                } else {
                    console.error('fetchTagihanPembayaran error:', response.message);
                }
            },
            error: function(xhr) {
                console.error('fetchTagihanPembayaran ajax error:', xhr.responseText);
            }
        });
    }

    function fetchRingkasanPembayaran(no_kwitansi) {
        $.ajax({
            method: "GET",
            url: "<?= site_url('deposit/ringkasanpembayaran'); ?>",
            data: {
                no_kwitansi: no_kwitansi
            },
            dataType: "JSON",
            success: function(response) {
                if (response.status === 'success') {
                    var d = response.data || {};

                    ringkasanState.totalTagihan = d.totalTagihan || 0;
                    ringkasanState.totalDibayarConfirmed = d.totalDibayar || 0;

                    draftPembayaran = [];
                    renderDaftarPembayaran();
                    renderRingkasanPembayaran();
                } else {
                    console.error('fetchRingkasanPembayaran error:', response.message);
                }
            },
            error: function(xhr) {
                console.error('fetchRingkasanPembayaran ajax error:', xhr.responseText);
            }
        });
    }

    function loadPembayaranData() {
        var no_kwitansi = $('#f_no_kwitansi').val();
        var no_pasien = $('#f_medrec_id').val();

        resetRingkasanPembayaran();

        if (!no_kwitansi || !no_pasien) return;

        fetchTagihanPembayaran(no_kwitansi, no_pasien);
        fetchRingkasanPembayaran(no_kwitansi);
    }

    function renderDaftarPembayaran() {
        var tbody = $('#tbody_daftar_pembayaran');
        tbody.empty();

        if (!draftPembayaran.length) {
            tbody.html('<tr><td colspan="3"><div class="empty-payment-state"><i class="fas fa-print fa-lg mb-1"></i><br>Belum ada pembayaran</div></td></tr>');
            return;
        }

        draftPembayaran.forEach(function(p, idx) {
            var btnAksi = p.isDeposit ?
                '<button type="button" class="btn btn-xs btn-outline-danger btn-hapus-draft-pembayaran" data-idx="' + idx + '" title="Matikan Gunakan Deposit"><i class="fas fa-times"></i></button>' :
                '<button type="button" class="btn btn-xs btn-outline-danger btn-hapus-draft-pembayaran" data-idx="' + idx + '"><i class="fas fa-times"></i></button>';

            var metodeLabel = p.namaMetode;

            if (p.isAsuransi && p.asrCd) {
                metodeLabel += '<br><span class="text-muted" style="font-size:.65rem;">' +
                    p.asrCd + (p.nomorKartu ? ' &bull; ' + p.nomorKartu : '') +
                    (p.coveragePercent ? ' &bull; coverage ' + p.coveragePercent + '%' : '') +
                    '</span>';
            }

            if (p.isVoucher && p.voucherId) {
                metodeLabel += '<br><span class="text-muted" style="font-size:.65rem;">' +
                    p.voucherId + (p.voucherRef ? ' &bull; Ref: ' + p.voucherRef : '') +
                    '</span>';
            }

            if (p.isAr && p.payerLabel) {
                metodeLabel += '<br><span class="badge badge-warning" style="font-size:.6rem;">PIUTANG (AR)</span> ' +
                    '<span class="text-muted" style="font-size:.65rem;">' + p.payerLabel + '</span>';
            }

            var tr = '<tr>' +
                '<td>' + metodeLabel + '</td>' +
                '<td class="text-right">' + formatRupiah(p.nominal).replace('Rp ', '') + '</td>' +
                '<td class="text-right">' + btnAksi + '</td>' +
                '</tr>';
            tbody.append(tr);
        });
    }

    function syncDepositToDraftPembayaran() {
        draftPembayaran = draftPembayaran.filter(function(p) {
            return !p.isDeposit;
        });

        var isOn = $('#toggle_gunakan_deposit').is(':checked');
        var jumlah = parseRupiahInput($('#akan_digunakan').val());

        if (isOn && jumlah > 0) {
            draftPembayaran.push({
                isDeposit: true,
                caraPembayaranId: null,
                namaMetode: 'Deposit',
                nominal: jumlah,
                referenceNo: '',
                feePercent: 0,
                isAsuransi: false,
                asrCd: '',
                nomorKartu: '',
                coveragePercent: 0,
                isVoucher: false,
                voucherRef: '',
                voucherId: '',
                isAr: false,
                payerId: '',
                payerLabel: ''
            });
        }

        renderDaftarPembayaran();
        renderRingkasanPembayaran();
    }

    function renderRingkasanPembayaran() {
        var sumDraft = draftPembayaran.reduce(function(a, p) {
            return a + p.nominal;
        }, 0);

        var depositDraft = draftPembayaran.filter(function(p) {
            return p.isDeposit;
        }).reduce(function(a, p) {
            return a + p.nominal;
        }, 0);

        // Baseline = sisa tagihan SEBELUM draft pembayaran saat ini (yaitu tagihan
        // dikurangi pembayaran yang sudah benar-benar tersimpan di server).
        var baselineSisa = ringkasanState.totalTagihan - ringkasanState.totalDibayarConfirmed;
        if (baselineSisa < 0) baselineSisa = 0;

        // "Sisa yang Harus Dibayar" = baseline dikurangi HANYA deposit yang ada di draft
        // (preview setelah deposit dipakai, sebelum metode lain ditambahkan).
        var sisaSetelahDeposit = baselineSisa - depositDraft;
        if (sisaSetelahDeposit < 0) sisaSetelahDeposit = 0;

        // "Sisa Bayar" = baseline dikurangi SEMUA baris draft (deposit + metode lain).
        var sisaBayarFinal = baselineSisa - sumDraft;
        if (sisaBayarFinal < 0) sisaBayarFinal = 0;

        $('#ringkasan_total_tagihan').text(formatRupiah(ringkasanState.totalTagihan));
        $('#ringkasan_deposit_digunakan').text('- ' + formatRupiah(depositDraft));
        $('#ringkasan_sisa_dibayar').text(formatRupiah(sisaSetelahDeposit));
        $('#ringkasan_total_dibayar').text(formatRupiah(sumDraft));
        $('#ringkasan_sisa_bayar').text(formatRupiah(sisaBayarFinal));
    }

    function refreshDepositData() {
        var no_pasien = $('#f_medrec_id').val();
        if (!no_pasien) return;
        fetchSaldoDeposit(no_pasien);
        fetchRiwayatDeposit(no_pasien);
        loadPembayaranData();
    }

    $(document).ready(function() {
        fetchSidebarPasien();

        if (!$('body').hasClass('control-sidebar-slide-open')) {
            $('#toggle-sidebar-pasien').trigger('click');
        }

        $(document).on('click', '.payment-method-btn', function() {
            $('.payment-method-btn').removeClass('active').find('.check-badge').remove();
            $(this).addClass('active');
            $(this).prepend('<span class="check-badge"><i class="fas fa-check"></i></span>');
        });

        $('#jumlah_deposit').on('input', function() {
            var raw = parseRupiahInput($(this).val());
            $('#terbilang_deposit').text('Terbilang: ' + (raw > 0 ? terbilang(raw) + ' rupiah' : '-'));
            hitungDepositSetelahIni();
        });

        $('#keterangan_tambahan').on('input', function() {
            $('#keterangan_count').text($(this).val().length);
        });

        $('#toggle_gunakan_deposit').on('change', function() {
            var isOn = $(this).is(':checked');
            $('#akan_digunakan').prop('disabled', !isOn);
            $('#btn_gunakan_max').prop('disabled', !isOn);
            if (!isOn) {
                $('#akan_digunakan').val(0);
                var saldo = parseFloat($('#f_saldo_deposit_raw').val()) || 0;
                $('#sisa_deposit').text(formatRupiah(saldo));
            }
            syncDepositToDraftPembayaran();
        });

        $('#btn_gunakan_max').on('click', function() {
            var saldo = parseFloat($('#f_saldo_deposit_raw').val()) || 0;
            var baselineSisa = ringkasanState.totalTagihan - ringkasanState.totalDibayarConfirmed;
            if (baselineSisa < 0) baselineSisa = 0;
            var pakai = Math.min(saldo, baselineSisa);
            $('#akan_digunakan').val(pakai);
            $('#sisa_deposit').text(formatRupiah(saldo - pakai));
            syncDepositToDraftPembayaran();
        });

        $('#akan_digunakan').on('input', function() {
            var saldo = parseFloat($('#f_saldo_deposit_raw').val()) || 0;
            var baselineSisa = ringkasanState.totalTagihan - ringkasanState.totalDibayarConfirmed;
            if (baselineSisa < 0) baselineSisa = 0;
            var pakai = parseRupiahInput($(this).val());

            var batas = Math.min(saldo, baselineSisa);
            if (pakai > batas) {
                pakai = batas;
                $(this).val(pakai);
            }

            var sisa = saldo - pakai;
            $('#sisa_deposit').text(formatRupiah(sisa < 0 ? 0 : sisa));
            syncDepositToDraftPembayaran();
        });

        $('#btn_batal_deposit').on('click', function() {
            $('#jumlah_deposit').val(0).trigger('input');
            $('#catatan_deposit').val('');
            $('.payment-method-btn').removeClass('active').find('.check-badge').remove();
            $('.payment-method-btn[data-metode="cash"]').addClass('active')
                .prepend('<span class="check-badge"><i class="fas fa-check"></i></span>');
        });

        $('#btn_lihat_saldo_deposit').on('click', function() {
            refreshDepositData();
            toastr.info('Saldo deposit diperbarui.');
        });

        $('#btn_cetak_kwitansi').on('click', function(e) {
            e.preventDefault();
            var no_kwitansi = $('#f_no_kwitansi').val();

            if (!no_kwitansi) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Kwitansi untuk pasien ini tidak ditemukan.'
                });
                return;
            }

            Swal.fire({
                title: 'Konfirmasi Print',
                text: 'Apakah Anda yakin ingin mencetak kwitansi nomor: ' + no_kwitansi + '?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Cetak!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Menyimpan history print',
                        icon: 'info',
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });

                    var payload = {
                        print_type: "print",
                        document_type: "kwitansi",
                        document_id: no_kwitansi,
                        usr_id: "<?= $session->get('usr_id'); ?>"
                    };

                    $.ajax({
                        url: "<?= base_url('/prints/print-history') ?>",
                        type: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify(payload),
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: 'History tersimpan, melanjutkan print...',
                                    icon: 'success',
                                    timer: 1000,
                                    showConfirmButton: false
                                }).then(() => {
                                    const winPdf = window.open("<?= base_url('/deposit/print/') ?>" + no_kwitansi);
                                    if (winPdf) {
                                        winPdf.print();
                                    } else {
                                        Swal.fire({
                                            title: 'Perhatian!',
                                            text: 'Mohon izinkan pop-up window untuk mencetak kwitansi',
                                            icon: 'warning',
                                            confirmButtonText: 'OK'
                                        });
                                    }
                                });
                            } else {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: response.message || 'Gagal menyimpan history print. Proses print dibatalkan.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error:', error);
                            let errorMsg = 'Gagal menyimpan history print. Proses print dibatalkan.';

                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            }

                            Swal.fire({
                                title: 'Gagal!',
                                text: errorMsg,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        });

        $('#btn_tambah_pembayaran').on('click', function() {
            if (!$('#f_no_kwitansi').val()) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Kwitansi aktif untuk pasien ini tidak ditemukan.'
                });
                return;
            }

            if (!metodePembayaranOptions.length) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Data metode pembayaran belum tersedia untuk kwitansi ini.'
                });
                return;
            }

            // Deposit TIDAK ditampilkan di dropdown umum ini. Penggunaan deposit hanya lewat
            // toggle "GUNAKAN DEPOSIT" di panel kiri (syncDepositToDraftPembayaran). Kalau
            // dibiarkan tampil di sini, kasir bisa memilih "Deposit" dua kali (baris duplikat)
            // dan baris kedua itu TIDAK benar-benar memotong saldo deposit pasien - hanya
            // tercatat sebagai nominal, sehingga total pembayaran jadi salah/lebih besar dari
            // yang sebenarnya diterima.
            var optionsHtml = metodePembayaranOptions.map(function(m, idx) {
                var namaLower = (m.namaMetode || '').toLowerCase().trim();
                var jenisLower = (m.jenisPembayaran || '').toLowerCase().trim();
                if (namaLower === 'deposit' || jenisLower === 'deposit') {
                    return '';
                }

                var label = m.namaMetode || m.jenisPembayaran || ('Metode ' + (idx + 1));
                if (m.feePercent) {
                    label += ' (fee ' + m.feePercent + '%)';
                }
                return '<option value="' + idx + '">' + label + '</option>';
            }).join('');

            if (!optionsHtml) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Tidak ada metode pembayaran lain yang tersedia selain Deposit.'
                });
                return;
            }

            Swal.fire({
                title: 'Tambah Pembayaran',
                html:
                    '<div class="form-group text-left">' +
                    '<label class="info-label mb-1">Metode Pembayaran</label>' +
                    '<select id="swal_metode" class="form-control form-control-sm">' + optionsHtml + '</select>' +
                    '</div>' +
                    '<div class="form-group text-left">' +
                    '<label class="info-label mb-1">Nominal</label>' +
                    '<input type="text" id="swal_nominal" class="form-control form-control-sm" inputmode="numeric" placeholder="0">' +
                    '</div>' +
                    '<div class="form-group text-left" id="swal_referensi_wrap">' +
                    '<label class="info-label mb-1">No. Referensi</label>' +
                    '<input type="text" id="swal_referensi" class="form-control form-control-sm" placeholder="Opsional">' +
                    '</div>' +

                    '<div class="form-group text-left mb-0" id="swal_asuransi_wrap" style="display:none;">' +
                    '<hr class="my-2">' +
                    '<label class="info-label mb-1">Kode Asuransi (asrCd)</label>' +
                    '<input type="text" id="swal_asr_cd" class="form-control form-control-sm text-uppercase" placeholder="Contoh: ASR00002">' +
                    '<label class="info-label mb-1 mt-2">No. Kartu Asuransi</label>' +
                    '<input type="text" id="swal_nomor_kartu" class="form-control form-control-sm" placeholder="Contoh: ASRK00002">' +
                    '<label class="info-label mb-1 mt-2">Coverage (%)</label>' +
                    '<input type="number" id="swal_coverage_percent" class="form-control form-control-sm" min="1" max="100" placeholder="0 - 100">' +
                    '</div>' +

                    '<div class="form-group text-left mb-0" id="swal_voucher_wrap" style="display:none;">' +
                    '<hr class="my-2">' +
                    '<label class="info-label mb-1">No. Referensi Voucher</label>' +
                    '<input type="text" id="swal_voucher_ref" class="form-control form-control-sm" placeholder="Contoh: REF-2026-001">' +
                    '<label class="info-label mb-1 mt-2">Voucher ID</label>' +
                    '<input type="text" id="swal_voucher_id" class="form-control form-control-sm text-uppercase" placeholder="Contoh: VCR00001">' +
                    '</div>' +

                    '<div class="form-group text-left mb-0" id="swal_ar_wrap" style="display:none;">' +
                    '<hr class="my-2">' +
                    '<label class="info-label mb-1">Payer (Penanggung Piutang)</label>' +
                    '<select id="swal_payer_id" class="form-control form-control-sm"><option value="">-- Memuat data payer... --</option></select>' +
                    '<small class="text-muted">Metode ini akan dicatat sebagai piutang (AR) ke payer yang dipilih.</small>' +
                    '</div>',

                showCancelButton: true,
                confirmButtonText: 'Tambah',
                cancelButtonText: 'Batal',
                didOpen: function() {
                    var toggleFields = function() {
                        var idx = $('#swal_metode').val();
                        var m = metodePembayaranOptions[idx];
                        $('#swal_referensi_wrap').toggle(!!(m && m.requireReference));
                        $('#swal_asuransi_wrap').toggle(isMetodeAsuransi(m));
                        $('#swal_voucher_wrap').toggle(isMetodeVoucher(m));
                        $('#swal_ar_wrap').toggle(isMetodeAR(m));

                        if (isMetodeAR(m)) {
                            fetchPayerOptions(function() {
                                var opts = payerOptions.map(function(p) {
                                    return '<option value="' + p.payerId + '" data-coverage="' + (p.coveragePercent || 0) + '">' +
                                        p.payerName + ' (' + p.payerType + ')' + '</option>';
                                }).join('');
                                $('#swal_payer_id').html(
                                    '<option value="">-- Pilih Payer --</option>' + opts
                                );
                            });
                        }
                    };
                    $('#swal_metode').on('change', toggleFields);
                    toggleFields();
                },
                preConfirm: function() {
                    var idx = $('#swal_metode').val();
                    var nominal = parseRupiahInput($('#swal_nominal').val());
                    var referensi = $('#swal_referensi').val();
                    var m = metodePembayaranOptions[idx];

                    var asuransi = isMetodeAsuransi(m);
                    var asrCd = ($('#swal_asr_cd').val() || '').trim();
                    var nomorKartu = ($('#swal_nomor_kartu').val() || '').trim();
                    var coveragePercent = parseFloat($('#swal_coverage_percent').val()) || 0;

                    var voucher = isMetodeVoucher(m);
                    var voucherRef = ($('#swal_voucher_ref').val() || '').trim();
                    var voucherId = ($('#swal_voucher_id').val() || '').trim();

                    var isAr = isMetodeAR(m);
                    var payerId = $('#swal_payer_id').val() || '';
                    var payerLabel = $('#swal_payer_id option:selected').text() || '';

                    if (nominal <= 0) {
                        Swal.showValidationMessage('Nominal harus lebih dari 0');
                        return false;
                    }
                    if (m && m.requireReference && !referensi) {
                        Swal.showValidationMessage('No. Referensi wajib diisi untuk metode ini');
                        return false;
                    }
                    if (isAr && !payerId) {
                        Swal.showValidationMessage('Payer wajib dipilih untuk metode pembayaran piutang (AR) ini');
                        return false;
                    }

                    if (asuransi) {
                        if (!asrCd) {
                            Swal.showValidationMessage('Kode Asuransi wajib diisi untuk metode pembayaran asuransi');
                            return false;
                        }
                        if (!nomorKartu) {
                            Swal.showValidationMessage('No. Kartu Asuransi wajib diisi untuk metode pembayaran asuransi');
                            return false;
                        }
                        if (coveragePercent <= 0 || coveragePercent > 100) {
                            Swal.showValidationMessage('Coverage (%) harus di antara 1 - 100');
                            return false;
                        }
                    }

                    if (voucher) {
                        if (!voucherRef) {
                            Swal.showValidationMessage('No. Referensi Voucher wajib diisi');
                            return false;
                        }
                        if (!voucherId) {
                            Swal.showValidationMessage('Voucher ID wajib diisi');
                            return false;
                        }
                    }

                    return {
                        caraPembayaranId: m ? m.caraPembayaranId : null,
                        namaMetode: m ? (m.namaMetode || m.jenisPembayaran) : '-',
                        nominal: nominal,
                        referenceNo: referensi || '',
                        feePercent: m ? (m.feePercent || 0) : 0,
                        isAsuransi: asuransi,
                        asrCd: asuransi ? asrCd.toUpperCase() : '',
                        nomorKartu: asuransi ? nomorKartu : '',
                        coveragePercent: asuransi ? coveragePercent : 0,
                        isVoucher: voucher,
                        voucherRef: voucher ? voucherRef : '',
                        voucherId: voucher ? voucherId.toUpperCase() : '',
                        isAr: isAr,
                        payerId: isAr ? payerId : '',
                        payerLabel: isAr ? payerLabel : ''
                    };
                }
            }).then(function(result) {
                if (result.isConfirmed && result.value) {
                    draftPembayaran.push(result.value);
                    renderDaftarPembayaran();
                    renderRingkasanPembayaran();
                }
            });
        });

        $(document).on('click', '.btn-hapus-draft-pembayaran', function() {
            var idx = $(this).data('idx');
            var item = draftPembayaran[idx];

            if (item && item.isDeposit) {
                $('#toggle_gunakan_deposit').prop('checked', false).trigger('change');
                return;
            }

            draftPembayaran.splice(idx, 1);
            renderDaftarPembayaran();
            renderRingkasanPembayaran();
        });

        $('#btn_lanjut_pembayaran').on('click', function() {
            var no_kwitansi = $('#f_no_kwitansi').val();
            var no_registrasi = $('#f_no_registrasi').val();
            var no_pasien = $('#f_medrec_id').val();

            if (!no_kwitansi) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Kwitansi aktif untuk pasien ini tidak ditemukan.'
                });
                return;
            }

            if (!draftPembayaran.length) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Tambahkan minimal satu metode pembayaran terlebih dahulu.'
                });
                return;
            }

            var depositDigunakan = draftPembayaran.filter(function(p) {
                return p.isDeposit;
            }).reduce(function(a, p) {
                return a + p.nominal;
            }, 0);
            var notes = $('#keterangan_tambahan').val();

            var body = {
                noKwitansi: no_kwitansi,
                noRegistrasi: no_registrasi,
                noPasien: no_pasien,
                depositDigunakan: depositDigunakan,
                metodePembayaran: draftPembayaran.filter(function(p) {
                    return !p.isDeposit;
                }).map(function(p) {
                    return {
                        caraPembayaranId: p.caraPembayaranId,
                        nominal: p.nominal,
                        referenceNo: p.referenceNo || '',
                        keterangan: notes || '',
                        asrCd: p.asrCd || '',
                        nomorKartu: p.nomorKartu || '',
                        coveragePercent: p.coveragePercent || 0,
                        voucherRef: p.voucherRef || '',
                        voucherId: p.voucherId || '',
                        payerId: p.isAr && p.payerId ? p.payerId : null
                    };
                }),
                notes: notes
            };

            var $btn = $(this);

            $.ajax({
                url: "<?= site_url('deposit/prosespembayaran'); ?>",
                method: "POST",
                contentType: "application/json",
                data: JSON.stringify(body),
                dataType: "JSON",
                beforeSend: function() {
                    $btn.prop('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Memproses...');
                },
                complete: function() {
                    $btn.prop('disabled', false).html('LANJUT KE PEMBAYARAN <i class="fas fa-arrow-right ml-1"></i>');
                },
                success: function(response) {
                    if (response.error) {
                        var msgs = Object.values(response.error).filter(Boolean).join('\n');
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: msgs || 'Terjadi kesalahan.'
                        });
                    } else if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.success
                        }).then(function() {
                            refreshDepositData();
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Tidak dapat menghubungi server.'
                    });
                }
            });
        });

        $('#btn_lihat_semua_riwayat').on('click', function(e) {
            e.preventDefault();
            Swal.fire({
                icon: 'info',
                title: 'Belum Tersedia',
                text: 'Endpoint riwayat deposit lengkap belum tersedia.'
            });
        });

        $('#btn_simpan_deposit').on('click', function() {
            var no_registrasi = $('#f_no_registrasi').val();
            var no_pasien = $('#f_medrec_id').val();
            var jumlah = parseRupiahInput($('#jumlah_deposit').val());
            var metode = $('.payment-method-btn.active').data('metode') || 'cash';
            var catatan = $('#catatan_deposit').val();

            if (!no_registrasi || !no_pasien) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Pilih pasien terlebih dahulu.'
                });
                return;
            }

            if (jumlah <= 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Jumlah deposit harus lebih dari 0.'
                });
                return;
            }

            var $btn = $(this);

            $.ajax({
                url: "<?= site_url('deposit/simpan'); ?>",
                method: "POST",
                data: {
                    no_pasien: no_pasien,
                    no_registrasi: no_registrasi,
                    jumlah_deposit: jumlah,
                    metode: metode,
                    catatan: catatan
                },
                dataType: "JSON",
                beforeSend: function() {
                    $btn.prop('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Menyimpan...');
                },
                complete: function() {
                    $btn.prop('disabled', false).html('SIMPAN DEPOSIT (F5)');
                },
                success: function(response) {
                    if (response.error) {
                        var msgs = Object.values(response.error).filter(Boolean).join('\n');
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Menyimpan',
                            text: msgs || 'Terjadi kesalahan.'
                        });
                    } else if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.success
                        }).then(function() {
                            $('#jumlah_deposit').val(0).trigger('input');
                            $('#catatan_deposit').val('');
                            refreshDepositData();
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Tidak dapat menghubungi server.'
                    });
                }
            });
        });

        $('#btn_batalkan_transaksi').on('click', function() {
            Swal.fire({
                icon: 'info',
                title: 'Pilih Transaksi',
                text: 'Klik ikon batal pada baris transaksi di tabel Riwayat Deposit yang ingin dibatalkan.'
            });
        });

        $(document).on('click', '.btn-batal-riwayat', function() {
            var deposit_id = $(this).data('deposit_id');

            Swal.fire({
                title: 'Batalkan Transaksi Deposit?',
                input: 'text',
                inputLabel: 'Alasan pembatalan',
                inputPlaceholder: 'Tulis alasan pembatalan...',
                showCancelButton: true,
                confirmButtonText: 'Ya, Batalkan',
                cancelButtonText: 'Tutup',
                inputValidator: function(value) {
                    if (!value) {
                        return 'Alasan pembatalan wajib diisi.';
                    }
                }
            }).then(function(result) {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= site_url('deposit/batal'); ?>",
                        method: "POST",
                        data: {
                            deposit_id: deposit_id,
                            alasan_batal: result.value
                        },
                        dataType: "JSON",
                        success: function(response) {
                            if (response.error) {
                                var msgs = Object.values(response.error).filter(Boolean).join('\n');
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: msgs || 'Terjadi kesalahan.'
                                });
                            } else if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.success
                                }).then(function() {
                                    refreshDepositData();
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Tidak dapat menghubungi server.'
                            });
                        }
                    });
                }
            });
        });
    });

    $(document).on('click', '.pilihpasien', function() {
        var no_registrasi = $(this).data('no_registrasi');
        var patient_no = $(this).data('patient_no');
        var fullname = $(this).data('fullname') || '-';
        var birth_dt = $(this).data('birth_dt') || '';
        var gender = $(this).data('gender') || 'Laki-laki';
        var nama_dokter = $(this).data('nama_dokter') || '-';
        var tujuan_registrasi_desc = $(this).data('tujuan_registrasi_desc') || '-';
        var type_pasien = $(this).data('type_pasien') || 'UMUM';
        var no_kwitansi = $(this).data('no_kwitansi') || '';

        $.ajax({
            url: "<?= site_url('deposit/setnoregistrasi'); ?>",
            method: "GET",
            data: {
                no_registrasi: no_registrasi,
                patient_no: patient_no
            }
        });

        $('#f_no_registrasi').val(no_registrasi);
        $('#f_medrec_id').val(patient_no);
        $('#f_no_kwitansi').val(no_kwitansi);

        var umur = hitungUmur(birth_dt);

        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        var time = String(today.getHours()).padStart(2, '0') + ":" + String(today.getMinutes()).padStart(2, '0');
        var tglFormat = dd + '/' + mm + '/' + yyyy + ' ' + time;

        $('#lbl_nama_pasien').html(fullname);
        $('#lbl_no_rm').html(patient_no);
        $('#lbl_gender').html(gender);
        $('#lbl_umur').html(umur);
        $('#lbl_no_registrasi').html(no_registrasi);
        $('#lbl_tgl_registrasi').html(tglFormat);
        $('#lbl_poli').html(tujuan_registrasi_desc);
        $('#lbl_dokter').html(nama_dokter);
        $('#lbl_penjamin').html(type_pasien);

        $('#jumlah_deposit').val(0).trigger('input');
        $('#catatan_deposit').val('');
        $('#toggle_gunakan_deposit').prop('checked', false).trigger('change');

        $('#no-patient-selected').hide();
        $('#main-deposit-content').fadeIn();

        refreshDepositData();
    });

    function terbilang(angka) {
        angka = Math.floor(Math.abs(angka));
        var satuan = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'];

        function eja(n) {
            n = Math.floor(n);
            if (n < 12) return satuan[n];
            if (n < 20) return eja(n - 10) + ' belas';
            if (n < 100) return eja(Math.floor(n / 10)) + ' puluh' + (n % 10 !== 0 ? ' ' + eja(n % 10) : '');
            if (n < 200) return 'seratus' + (n - 100 !== 0 ? ' ' + eja(n - 100) : '');
            if (n < 1000) return eja(Math.floor(n / 100)) + ' ratus' + (n % 100 !== 0 ? ' ' + eja(n % 100) : '');
            if (n < 2000) return 'seribu' + (n - 1000 !== 0 ? ' ' + eja(n - 1000) : '');
            if (n < 1000000) return eja(Math.floor(n / 1000)) + ' ribu' + (n % 1000 !== 0 ? ' ' + eja(n % 1000) : '');
            if (n < 1000000000) return eja(Math.floor(n / 1000000)) + ' juta' + (n % 1000000 !== 0 ? ' ' + eja(n % 1000000) : '');
            return eja(Math.floor(n / 1000000000)) + ' miliar' + (n % 1000000000 !== 0 ? ' ' + eja(n % 1000000000) : '');
        }

        if (angka === 0) return 'nol';
        var hasil = eja(angka);
        return hasil.charAt(0).toUpperCase() + hasil.slice(1);
    }
</script>

<?= $this->endSection('script'); ?>