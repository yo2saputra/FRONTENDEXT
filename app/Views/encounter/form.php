<?php

/**
 * View ini dipakai untuk CREATE dan EDIT.
 *
 * @var string      $title
 * @var string      $action
 * @var array|null  $encounter   (null kalau create)
 */
$isEdit = !empty($encounter['id']);

// Ambil nilai lama (old input) atau dari data encounter
$valPatientId   = old('patient_id')      ?? str_replace('Patient/', '', $encounter['subject']['reference'] ?? '');
$valPatientName = old('patient_name')    ?? ($encounter['subject']['display'] ?? '');
$valPractId     = old('practitioner_id') ?? str_replace('Practitioner/', '', $encounter['participant'][0]['individual']['reference'] ?? '');
$valPractName   = old('practitioner_name') ?? ($encounter['participant'][0]['individual']['display'] ?? '');
$valOrgId       = old('org_id')          ?? str_replace('Organization/', '', $encounter['serviceProvider']['reference'] ?? '');
$valLocId       = old('location_id')     ?? str_replace('Location/', '', $encounter['location'][0]['location']['reference'] ?? '');
$valLocName     = old('location_name')   ?? ($encounter['location'][0]['location']['display'] ?? '');
$valEncValue    = old('encounter_value') ?? ($encounter['identifier'][0]['value'] ?? '');
$valStart       = old('start_time');

if ($valStart === null && !empty($encounter['period']['start'])) {
    $valStart = date('Y-m-d\TH:i', strtotime($encounter['period']['start']));
}
if ($valStart === null) {
    $valStart = date('Y-m-d\TH:i');
}

$valStatus = old('status') ?? ($encounter['status'] ?? 'arrived');
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title><?= esc($title ?? 'Form Encounter') ?></title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f7f9fc;
            color: #333;
        }

        .container {
            max-width: 760px;
            margin: 0 auto;
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        @media (max-width: 600px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
            color: #2c3e50;
            font-size: 14px;
        }

        input[type=text],
        input[type=datetime-local],
        select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            font-family: inherit;
            background: white;
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.15);
        }

        small.hint {
            display: block;
            color: #777;
            font-size: 12px;
            margin-top: 4px;
        }

        .alert {
            padding: 12px 16px;
            margin: 0 0 18px 0;
            border-radius: 6px;
            border: 1px solid transparent;
            font-size: 14px;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }

        .btn-row {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .btn {
            display: inline-block;
            padding: 10px 18px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
            border: none;
            font-weight: 500;
        }

        .btn-primary {
            background: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background: #0069d9;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .readonly-info {
            background: #eef3f8;
            padding: 10px 12px;
            border-radius: 4px;
            font-size: 13px;
            font-family: monospace;
            color: #555;
            word-break: break-all;
        }

        .section-title {
            font-size: 13px;
            font-weight: 700;
            color: #007bff;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 25px 0 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #eef3f8;
        }

        .section-title:first-of-type {
            margin-top: 0;
        }
    </style>
</head>

<body>
    <div class="container">

        <h1>🏥 <?= esc($title ?? 'Form Encounter') ?></h1>

        <div class="card">

            <!-- FLASHDATA ERROR -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error">
                    ❌ <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <!-- INFO ID (kalau edit) -->
            <?php if ($isEdit): ?>
                <div class="form-group">
                    <label>Encounter ID</label>
                    <div class="readonly-info"><?= esc($encounter['id']) ?></div>
                    <small class="hint">Dibuat otomatis oleh SATUSEHAT, tidak bisa diubah.</small>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= esc($action) ?>">
                <?= csrf_field() ?>

                <!-- ==================================================== -->
                <div class="section-title">👤 Data Pasien</div>
                <!-- ==================================================== -->

                <div class="form-row">
                    <div class="form-group">
                        <label for="patient_id">Patient ID (IHS) *</label>
                        <input type="text" id="patient_id" name="patient_id"
                            value="<?= esc($valPatientId) ?>"
                            placeholder="100000030009" required>
                        <small class="hint">Tanpa prefix "Patient/"</small>
                    </div>

                    <div class="form-group">
                        <label for="patient_name">Nama Pasien</label>
                        <input type="text" id="patient_name" name="patient_name"
                            value="<?= esc($valPatientName) ?>"
                            placeholder="Budi Santoso">
                    </div>
                </div>

                <!-- ==================================================== -->
                <div class="section-title">🩺 Dokter Pemeriksa</div>
                <!-- ==================================================== -->

                <div class="form-row">
                    <div class="form-group">
                        <label for="practitioner_id">Practitioner ID *</label>
                        <input type="text" id="practitioner_id" name="practitioner_id"
                            value="<?= esc($valPractId) ?>"
                            placeholder="N10000001" required>
                        <small class="hint">Tanpa prefix "Practitioner/"</small>
                    </div>

                    <div class="form-group">
                        <label for="practitioner_name">Nama Dokter</label>
                        <input type="text" id="practitioner_name" name="practitioner_name"
                            value="<?= esc($valPractName) ?>"
                            placeholder="dr. Abele Rose">
                    </div>
                </div>

                <!-- ==================================================== -->
                <div class="section-title">🏨 Fasyankes & Lokasi</div>
                <!-- ==================================================== -->

                <div class="form-group">
                    <label for="org_id">Organization ID *</label>
                    <input type="text" id="org_id" name="org_id"
                        value="<?= esc($valOrgId) ?>"
                        placeholder="10000004" required>
                    <small class="hint">ID Organization dari dashboard SATUSEHAT (tanpa prefix)</small>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="location_id">Location ID *</label>
                        <input type="text" id="location_id" name="location_id"
                            value="<?= esc($valLocId) ?>"
                            placeholder="b017aa54-f1df-4ec2-9d84-8823815d7228" required>
                        <small class="hint">UUID ruangan (tanpa prefix)</small>
                    </div>

                    <div class="form-group">
                        <label for="location_name">Nama Ruangan</label>
                        <input type="text" id="location_name" name="location_name"
                            value="<?= esc($valLocName) ?>"
                            placeholder="Ruang 1A Poliklinik">
                    </div>
                </div>

                <!-- ==================================================== -->
                <div class="section-title">📋 Detail Kunjungan</div>
                <!-- ==================================================== -->

                <div class="form-row">
                    <div class="form-group">
                        <label for="encounter_value">Nomor Encounter *</label>
                        <input type="text" id="encounter_value" name="encounter_value"
                            value="<?= esc($valEncValue ?: 'P' . date('YmdHis')) ?>"
                            placeholder="P20240001" required>
                        <small class="hint">Nomor unik dari RME Anda</small>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status">
                            <option value="arrived" <?= $valStatus === 'arrived'     ? 'selected' : '' ?>>Arrived</option>
                            <option value="in-progress" <?= $valStatus === 'in-progress' ? 'selected' : '' ?>>In Progress</option>
                            <option value="finished" <?= $valStatus === 'finished'    ? 'selected' : '' ?>>Finished</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="start_time">Waktu Mulai *</label>
                    <input type="datetime-local" id="start_time" name="start_time"
                        value="<?= esc($valStart) ?>" required>
                    <small class="hint">Waktu lokal (WIB), akan diformat ke +07:00</small>
                </div>

                <!-- TOMBOL -->
                <div class="btn-row">
                    <button type="submit" class="btn btn-primary">
                        💾 <?= $isEdit ? 'Simpan Perubahan' : 'Simpan Encounter' ?>
                    </button>
                    <a href="<?= base_url('encounter') ?>" class="btn btn-secondary">
                        ↩️ Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
</body>

</html>