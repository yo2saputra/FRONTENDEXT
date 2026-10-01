<?php
$isEdit = !empty($observation['id']);

$valPatientId    = old('patient_id')    ?? ($observation['patient_id'] ?? '');
$valPatientName  = old('patient_name')  ?? ($observation['patient_name'] ?? '');
$valEncounterId  = old('encounter_id')  ?? ($observation['encounter_id'] ?? '');
$valEncounterDisp = old('encounter_display') ?? ($observation['encounter_display'] ?? '');
$valServiceReqId = old('service_request_id') ?? ($observation['service_request_id'] ?? '');
$valSpecimenId   = old('specimen_id')   ?? ($observation['specimen_id'] ?? '');
$valPerformerId  = old('performer_id')  ?? ($observation['performer_id'] ?? 'N10000001');
$valLoincCode    = old('loinc_code')    ?? ($observation['loinc_code'] ?? '8867-4');
$valLoincDisplay = old('loinc_display') ?? ($observation['loinc_display'] ?? 'Heart rate');
$valCategoryCode = old('category_code') ?? ($observation['category_code'] ?? 'vital-signs');
$valCategoryDisp = old('category_display') ?? ($observation['category_display'] ?? 'Vital Signs');
$valValueQty     = old('value_quantity') ?? ($observation['value_quantity'] ?? '');
$valValueUnit    = old('value_unit')    ?? ($observation['value_unit'] ?? '');
$valValueUnitCode = old('value_unit_code') ?? ($observation['value_unit_code'] ?? '');
$valEffective    = old('effective_date');
if ($valEffective === null && !empty($observation['effective_date'])) {
    $valEffective = date('Y-m-d\TH:i', strtotime($observation['effective_date']));
}
if ($valEffective === null) $valEffective = date('Y-m-d\TH:i');
$valIssued       = old('issued_date');
if ($valIssued === null && !empty($observation['issued_date'])) {
    $valIssued = date('Y-m-d\TH:i', strtotime($observation['issued_date']));
}
$valStatus       = old('status')        ?? ($observation['status'] ?? 'final');
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
            max-width: 820px;
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
        select,
        textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            font-family: inherit;
            background: white;
        }

        input:focus,
        select:focus,
        textarea:focus {
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

        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border-color: #bee5eb;
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
            font-size: 12px;
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
        <h1>🔬 <?= esc($title) ?></h1>
        <div class="card">

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error">❌ <?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <?php if ($isEdit): ?>
                <div class="form-group">
                    <label>Observation ID</label>
                    <div class="readonly-info"><?= esc($observation['id']) ?></div>
                    <small class="hint">Dibuat otomatis oleh SATUSEHAT.</small>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= esc($action) ?>">
                <?= csrf_field() ?>

                <div class="section-title">👤 Data Pasien & Kunjungan</div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="patient_id">Patient ID *</label>
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
                </div>

                <div class="form-group">
                    <label for="encounter_display">Deskripsi Encounter</label>
                    <input type="text" id="encounter_display" name="encounter_display" value="<?= esc($valEncounterDisp) ?>" placeholder="Pemeriksaan Fisik Nadi">
                </div>

                <div class="section-title">🔬 Detail Pemeriksaan</div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="category_code">Kategori</label>
                        <select id="category_code" name="category_code" onchange="updateCategoryDisplay()">
                            <option value="vital-signs" <?= $valCategoryCode === 'vital-signs' ? 'selected' : '' ?>>Vital Signs</option>
                            <option value="laboratory" <?= $valCategoryCode === 'laboratory'  ? 'selected' : '' ?>>Laboratory</option>
                            <option value="exam" <?= $valCategoryCode === 'exam'        ? 'selected' : '' ?>>Exam</option>
                            <option value="imaging" <?= $valCategoryCode === 'imaging'     ? 'selected' : '' ?>>Imaging</option>
                        </select>
                        <input type="hidden" id="category_display" name="category_display" value="<?= esc($valCategoryDisp) ?>">
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status">
                            <option value="final" <?= $valStatus === 'final'       ? 'selected' : '' ?>>Final</option>
                            <option value="preliminary" <?= $valStatus === 'preliminary' ? 'selected' : '' ?>>Preliminary</option>
                            <option value="amended" <?= $valStatus === 'amended'     ? 'selected' : '' ?>>Amended</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="loinc_code">Kode LOINC *</label>
                        <input type="text" id="loinc_code" name="loinc_code" value="<?= esc($valLoincCode) ?>" placeholder="8867-4" required>
                        <small class="hint">Nadi: 8867-4, Suhu: 8310-5, RR: 9279-1</small>
                    </div>
                    <div class="form-group">
                        <label for="loinc_display">Nama Pemeriksaan</label>
                        <input type="text" id="loinc_display" name="loinc_display" value="<?= esc($valLoincDisplay) ?>" placeholder="Heart rate">
                    </div>
                </div>

                <div class="section-title">📊 Nilai Hasil</div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="value_quantity">Nilai *</label>
                        <input type="text" id="value_quantity" name="value_quantity" value="<?= esc($valValueQty) ?>" placeholder="80" required>
                    </div>
                    <div class="form-group">
                        <label for="value_unit">Satuan *</label>
                        <input type="text" id="value_unit" name="value_unit" value="<?= esc($valValueUnit) ?>" placeholder="beats/minute" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="value_unit_code">Kode Satuan (UCUM) *</label>
                    <input type="text" id="value_unit_code" name="value_unit_code" value="<?= esc($valValueUnitCode) ?>" placeholder="/min" required>
                    <small class="hint">Contoh: /min (nadi), Cel (suhu), mm[Hg] (tensi), g/dL (Hb)</small>
                </div>

                <div class="section-title">📅 Waktu & Referensi</div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="effective_date">Waktu Pemeriksaan *</label>
                        <input type="datetime-local" id="effective_date" name="effective_date" value="<?= esc($valEffective) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="issued_date">Waktu Terbit</label>
                        <input type="datetime-local" id="issued_date" name="issued_date" value="<?= esc($valIssued) ?>">
                        <small class="hint">Kosongkan = sekarang.</small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="service_request_id">ServiceRequest ID</label>
                        <input type="text" id="service_request_id" name="service_request_id" value="<?= esc($valServiceReqId) ?>" placeholder="UUID ServiceRequest">
                    </div>
                    <div class="form-group">
                        <label for="specimen_id">Specimen ID</label>
                        <input type="text" id="specimen_id" name="specimen_id" value="<?= esc($valSpecimenId) ?>" placeholder="UUID Specimen">
                        <small class="hint">Wajib untuk kategori Laboratory.</small>
                    </div>
                </div>

                <div class="section-title">👨‍⚕️ Petugas Pemeriksa</div>

                <div class="form-group">
                    <label for="performer_id">Practitioner ID</label>
                    <input type="text" id="performer_id" name="performer_id" value="<?= esc($valPerformerId) ?>" placeholder="N10000001">
                </div>

                <div class="btn-row">
                    <button type="submit" class="btn btn-primary">💾 <?= $isEdit ? 'Simpan Perubahan' : 'Simpan Hasil' ?></button>
                    <a href="<?= base_url('observation') ?>" class="btn btn-secondary">↩️ Batal</a>
                </div>

            </form>
        </div>
    </div>

    <script>
        function updateCategoryDisplay() {
            const sel = document.getElementById('category_code');
            document.getElementById('category_display').value = sel.options[sel.selectedIndex].text;
        }
        document.addEventListener('DOMContentLoaded', updateCategoryDisplay);
    </script>
</body>

</html>