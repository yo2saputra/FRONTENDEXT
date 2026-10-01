<?php
$isEdit = !empty($procedure['id']);

$valPatientId    = old('patient_id')    ?? ($procedure['patient_id'] ?? '');
$valPatientName  = old('patient_name')  ?? ($procedure['patient_name'] ?? '');
$valEncounterId  = old('encounter_id')  ?? ($procedure['encounter_id'] ?? '');
$valPractId      = old('practitioner_id') ?? ($procedure['practitioner_id'] ?? 'N10000001');
$valPractName    = old('practitioner_name') ?? ($procedure['practitioner_name'] ?? '');
$valProcedureCode = old('procedure_code') ?? ($procedure['procedure_code'] ?? '89.03');
$valProcedureDisp = old('procedure_display') ?? ($procedure['procedure_display'] ?? 'Physical examination');
$valProcedureSys = old('procedure_system') ?? ($procedure['procedure_system'] ?? 'http://hl7.org/fhir/sid/icd-9-cm');
$valPerformedDate = old('performed_date');
if ($valPerformedDate === null && !empty($procedure['performed_date'])) {
    $valPerformedDate = date('Y-m-d\TH:i', strtotime($procedure['performed_date']));
}
$valStatus       = old('status')        ?? ($procedure['status'] ?? 'completed');
$valNote         = old('note')          ?? ($procedure['note'] ?? '');
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

        textarea {
            resize: vertical;
            min-height: 60px;
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
        <h1>⚕️ <?= esc($title) ?></h1>
        <div class="card">

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error">❌ <?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <?php if ($isEdit): ?>
                <div class="form-group">
                    <label>Procedure ID</label>
                    <div class="readonly-info"><?= esc($procedure['id']) ?></div>
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
                    <small class="hint">Encounter tempat tindakan dilakukan.</small>
                </div>

                <div class="section-title">👨‍⚕️ Dokter Pelaksana</div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="practitioner_id">Practitioner ID *</label>
                        <input type="text" id="practitioner_id" name="practitioner_id" value="<?= esc($valPractId) ?>" placeholder="N10000001" required>
                    </div>
                    <div class="form-group">
                        <label for="practitioner_name">Nama Dokter</label>
                        <input type="text" id="practitioner_name" name="practitioner_name" value="<?= esc($valPractName) ?>" placeholder="dr. Abele Rose">
                    </div>
                </div>

                <div class="section-title">⚕️ Detail Tindakan</div>

                <div class="form-group">
                    <label for="procedure_system">Sistem Kode</label>
                    <select id="procedure_system" name="procedure_system">
                        <option value="http://hl7.org/fhir/sid/icd-9-cm" <?= $valProcedureSys === 'http://hl7.org/fhir/sid/icd-9-cm' ? 'selected' : '' ?>>ICD-9-CM (Tindakan)</option>
                        <option value="http://snomed.info/sct" <?= $valProcedureSys === 'http://snomed.info/sct' ? 'selected' : '' ?>>SNOMED-CT</option>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="procedure_code">Kode Tindakan *</label>
                        <input type="text" id="procedure_code" name="procedure_code" value="<?= esc($valProcedureCode) ?>" placeholder="89.03" required>
                        <small class="hint">Contoh ICD-9-CM: 89.03 (Physical exam)</small>
                    </div>
                    <div class="form-group">
                        <label for="procedure_display">Nama Tindakan</label>
                        <input type="text" id="procedure_display" name="procedure_display" value="<?= esc($valProcedureDisp) ?>" placeholder="Physical examination">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="performed_date">Waktu Tindakan *</label>
                        <input type="datetime-local" id="performed_date" name="performed_date" value="<?= esc($valPerformedDate) ?>" required>
                        <small class="hint">Waktu lokal, akan diformat ke UTC +00</small>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status">
                            <option value="completed" <?= $valStatus === 'completed' ? 'selected' : '' ?>>Completed</option>
                            <option value="in-progress" <?= $valStatus === 'in-progress' ? 'selected' : '' ?>>In Progress</option>
                            <option value="entered-in-error" <?= $valStatus === 'entered-in-error' ? 'selected' : '' ?>>Entered in Error</option>
                        </select>
                    </div>
                </div>

                <div class="section-title">📝 Catatan Tambahan</div>

                <div class="form-group">
                    <label for="note">Catatan</label>
                    <textarea id="note" name="note" placeholder="Catatan tindakan, kondisi khusus, dll"><?= esc($valNote) ?></textarea>
                </div>

                <div class="btn-row">
                    <button type="submit" class="btn btn-primary">💾 <?= $isEdit ? 'Simpan Perubahan' : 'Simpan Tindakan' ?></button>
                    <a href="<?= base_url('procedure') ?>" class="btn btn-secondary">↩️ Batal</a>
                </div>

            </form>
        </div>
    </div>
</body>

</html>