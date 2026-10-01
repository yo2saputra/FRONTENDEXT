<?php
$isEdit = !empty($dispense['id']);

$valPatientId    = old('patient_id')    ?? ($dispense['patient_id'] ?? '');
$valPatientName  = old('patient_name')  ?? ($dispense['patient_name'] ?? '');
$valEncounterId  = old('encounter_id')  ?? ($dispense['encounter_id'] ?? '');
$valMedReqId     = old('medication_request_id') ?? ($dispense['medication_request_id'] ?? '');
$valMedicationId = old('medication_id') ?? ($dispense['medication_id'] ?? '');
$valPerformerId  = old('performer_id')  ?? ($dispense['performer_id'] ?? '');
$valPerformerName = old('performer_name') ?? ($dispense['performer_name'] ?? '');
$valLocationId   = old('location_id')   ?? ($dispense['location_id'] ?? '');
$valLocationName = old('location_name') ?? ($dispense['location_name'] ?? '');
$valQtyValue     = old('quantity_value') ?? ($dispense['quantity_value'] ?? '');
$valQtyUnit      = old('quantity_unit') ?? ($dispense['quantity_unit'] ?? 'TAB');
$valDaysSupply   = old('days_supply')   ?? ($dispense['days_supply'] ?? '');
$valWhenPrepared = old('when_prepared');
if ($valWhenPrepared === null && !empty($dispense['when_prepared'])) {
    $valWhenPrepared = date('Y-m-d\TH:i', strtotime($dispense['when_prepared']));
}
$valWhenHandedOver = old('when_handed_over');
if ($valWhenHandedOver === null && !empty($dispense['when_handed_over'])) {
    $valWhenHandedOver = date('Y-m-d\TH:i', strtotime($dispense['when_handed_over']));
}
$valDosageText   = old('dosage_text')   ?? ($dispense['dosage_text'] ?? '');
$valStatus       = old('status')        ?? ($dispense['status'] ?? 'completed');
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title><?= esc($title) ?></title>
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
        textarea,
        select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            font-family: inherit;
            background: white;
        }

        textarea {
            resize: vertical;
            min-height: 60px;
        }

        input:focus,
        textarea:focus,
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

        .btn-secondary {
            background: #6c757d;
            color: white;
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
        <h1>📦 <?= esc($title) ?></h1>
        <div class="card">

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error">❌ <?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <?php if ($isEdit): ?>
                <div class="form-group">
                    <label>MedicationDispense ID</label>
                    <div class="readonly-info"><?= esc($dispense['id']) ?></div>
                    <small class="hint">Dibuat otomatis oleh SATUSEHAT</small>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= esc($action) ?>">
                <?= csrf_field() ?>

                <!-- Data Pasien & Encounter -->
                <div class="section-title">👤 Data Pasien & Kunjungan</div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="patient_id">Patient ID (IHS) *</label>
                        <input type="text" id="patient_id" name="patient_id" value="<?= esc($valPatientId) ?>" placeholder="100000030009" required>
                    </div>
                    <div class="form-group">
                        <label for="patient_name">Nama Pasien</label>
                        <input type="text" id="patient_name" name="patient_name" value="<?= esc($valPatientName) ?>" placeholder="Budi Santoso">
                    </div>
                </div>

                <div class="form-group">
                    <label for="encounter_id">Encounter ID *</label>
                    <input type="text" id="encounter_id" name="encounter_id" value="<?= esc($valEncounterId) ?>" placeholder="UUID Encounter" required>
                    <small class="hint">Encounter tempat obat diserahkan.</small>
                </div>

                <!-- Referensi Resep & Obat -->
                <div class="section-title">💊 Referensi Resep & Obat</div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="medication_request_id">MedicationRequest ID *</label>
                        <input type="text" id="medication_request_id" name="medication_request_id" value="<?= esc($valMedReqId) ?>" placeholder="UUID MedicationRequest" required>
                        <small class="hint">ID MedicationRequest dari POST resep sebelumnya.</small>
                    </div>
                    <div class="form-group">
                        <label for="medication_id">Medication ID *</label>
                        <input type="text" id="medication_id" name="medication_id" value="<?= esc($valMedicationId) ?>" placeholder="UUID Medication" required>
                        <small class="hint">ID Medication dari POST resep sebelumnya.</small>
                    </div>
                </div>

                <!-- Performer -->
                <div class="section-title">👨‍⚕️ Petugas Apoteker</div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="performer_id">Practitioner ID *</label>
                        <input type="text" id="performer_id" name="performer_id" value="<?= esc($valPerformerId) ?>" placeholder="N10000001" required>
                    </div>
                    <div class="form-group">
                        <label for="performer_name">Nama Apoteker</label>
                        <input type="text" id="performer_name" name="performer_name" value="<?= esc($valPerformerName) ?>" placeholder="Apoteker">
                    </div>
                </div>

                <!-- ============================================ -->
                <div class="section-title">🏥 Lokasi Penyerahan (Apotek)</div>
                <!-- ============================================ -->

                <div class="form-row">
                    <div class="form-group">
                        <label for="location_id">Location ID (Apotek) *</label>
                        <input type="text" id="location_id" name="location_id"
                            value="<?= esc($valLocationId) ?>"
                            placeholder="UUID Location" required>
                        <small class="hint">Contoh: 52e135eb-1956-4871-ba13-e833e662484d</small>
                    </div>
                    <div class="form-group">
                        <label for="location_name">Nama Lokasi</label>
                        <input type="text" id="location_name" name="location_name"
                            value="<?= esc($valLocationName) ?>"
                            placeholder="Apotek RSUD Jati Asih">
                    </div>
                </div>

                <!-- Jumlah & Waktu -->
                <div class="section-title">📦 Jumlah & Waktu Serah</div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="quantity_value">Jumlah Diserahkan *</label>
                        <input type="text" id="quantity_value" name="quantity_value" value="<?= esc($valQtyValue) ?>" placeholder="10" required>
                    </div>
                    <div class="form-group">
                        <label for="quantity_unit">Satuan</label>
                        <input type="text" id="quantity_unit" name="quantity_unit" value="<?= esc($valQtyUnit) ?>" placeholder="TAB">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="days_supply">Jumlah Hari Supply</label>
                        <input type="text" id="days_supply" name="days_supply" value="<?= esc($valDaysSupply) ?>" placeholder="5">
                    </div>
                    <div class="form-group">
                        <label for="when_prepared">Waktu Dikemas</label>
                        <input type="datetime-local" id="when_prepared" name="when_prepared" value="<?= esc($valWhenPrepared) ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="when_handed_over">Waktu Serah Terima *</label>
                    <input type="datetime-local" id="when_handed_over" name="when_handed_over" value="<?= esc($valWhenHandedOver) ?>" required>
                    <small class="hint">Waktu lokal, akan diformat ke UTC +00</small>
                </div>

                <?php if ($isEdit): ?>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status">
                            <option value="completed" <?= $valStatus === 'completed' ? 'selected' : '' ?>>Completed</option>
                            <option value="cancelled" <?= $valStatus === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                            <option value="entered-in-error" <?= $valStatus === 'entered-in-error' ? 'selected' : '' ?>>Entered in Error</option>
                        </select>
                    </div>
                <?php endif; ?>

                <!-- Aturan Pakai -->
                <div class="section-title">📋 Aturan Pakai</div>

                <div class="form-group">
                    <label for="dosage_text">Aturan Pakai *</label>
                    <textarea id="dosage_text" name="dosage_text" placeholder="3 x 1 tablet setelah makan" required><?= esc($valDosageText) ?></textarea>
                </div>

                <!-- TOMBOL -->
                <div class="btn-row">
                    <button type="submit" class="btn btn-primary">💾 <?= $isEdit ? 'Simpan Perubahan' : 'Simpan Tebus Obat' ?></button>
                    <a href="<?= base_url('medication-dispense') ?>" class="btn btn-secondary">↩️ Batal</a>
                </div>

            </form>
        </div>
    </div>
</body>

</html>