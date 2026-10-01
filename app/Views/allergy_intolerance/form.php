<?php
$isEdit = !empty($allergy['id']);

$valPatientId    = old('patient_id')    ?? ($allergy['patient_id'] ?? '');
$valPatientName  = old('patient_name')  ?? ($allergy['patient_name'] ?? '');
$valEncounterId  = old('encounter_id')  ?? ($allergy['encounter_id'] ?? '');
$valPractId      = old('practitioner_id') ?? ($allergy['practitioner_id'] ?? '');
$valPractName    = old('practitioner_name') ?? ($allergy['practitioner_name'] ?? '');
$valAllergenCode = old('allergen_code') ?? ($allergy['allergen_code'] ?? '91000299');
$valAllergenDisp = old('allergen_display') ?? ($allergy['allergen_display'] ?? 'Aspirin');
$valAllergenText = old('allergen_text') ?? ($allergy['allergen_text'] ?? '');
$valCategory     = old('category')      ?? ($allergy['category'] ?? 'medication');
$valClinical     = old('clinical_status') ?? ($allergy['clinical_status'] ?? 'active');
$valLocalId      = old('local_id')      ?? ($allergy['local_id'] ?? '');
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

        .code-hint-box {
            background: #d1ecf1;
            color: #0c5460;
            padding: 10px 12px;
            border-radius: 4px;
            font-size: 13px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>🚨 <?= esc($title) ?></h1>
        <div class="card">

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error">❌ <?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <?php if ($isEdit): ?>
                <div class="form-group">
                    <label>AllergyIntolerance ID</label>
                    <div class="readonly-info"><?= esc($allergy['id']) ?></div>
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

                <div class="form-row">
                    <div class="form-group">
                        <label for="encounter_id">Encounter ID</label>
                        <input type="text" id="encounter_id" name="encounter_id" value="<?= esc($valEncounterId) ?>" placeholder="UUID Encounter">
                    </div>
                    <div class="form-group">
                        <label for="practitioner_id">Practitioner ID (Pencatat)</label>
                        <input type="text" id="practitioner_id" name="practitioner_id" value="<?= esc($valPractId) ?>" placeholder="N10000001">
                    </div>
                </div>

                <div class="form-group">
                    <label for="practitioner_name">Nama Pencatat</label>
                    <input type="text" id="practitioner_name" name="practitioner_name" value="<?= esc($valPractName) ?>" placeholder="dr. Abele Rose">
                </div>

                <div class="section-title">🚨 Detail Alergi</div>

                <div class="code-hint-box" id="code-hint">
                    ℹ️ <strong>Medication</strong> → gunakan kode <strong>KFA</strong> (contoh: 91000299).<br>
                    ℹ️ <strong>Food / Environment / Biologic</strong> → gunakan kode <strong>SNOMED-CT</strong> (contoh: 226963000).
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="category">Kategori</label>
                        <select id="category" name="category" onchange="updateCodeHint()">
                            <option value="medication" <?= $valCategory === 'medication'  ? 'selected' : '' ?>>Obat (Medication)</option>
                            <option value="food" <?= $valCategory === 'food'        ? 'selected' : '' ?>>Makanan (Food)</option>
                            <option value="environment" <?= $valCategory === 'environment' ? 'selected' : '' ?>>Lingkungan (Environment)</option>
                            <option value="biologic" <?= $valCategory === 'biologic'    ? 'selected' : '' ?>>Biologis (Biologic)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="clinical_status">Status Klinis</label>
                        <select id="clinical_status" name="clinical_status">
                            <option value="active" <?= $valClinical === 'active'   ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= $valClinical === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                            <option value="resolved" <?= $valClinical === 'resolved' ? 'selected' : '' ?>>Resolved</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="allergen_code">Kode Alergen *</label>
                        <input type="text" id="allergen_code" name="allergen_code"
                            value="<?= esc($valAllergenCode) ?>"
                            placeholder="91000299" required>
                        <small class="hint" id="code-system-hint">
                            Sistem: <strong>KFA</strong>
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="allergen_display">Nama Alergen *</label>
                        <input type="text" id="allergen_display" name="allergen_display"
                            value="<?= esc($valAllergenDisp) ?>"
                            placeholder="Aspirin" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="allergen_text">Deskripsi Alergi</label>
                    <input type="text" id="allergen_text" name="allergen_text"
                        value="<?= esc($valAllergenText) ?>"
                        placeholder="Alergi Aspirin sejak kecil">
                    <small class="hint">Keterangan tambahan tentang alergi.</small>
                </div>

                <div class="form-group">
                    <label for="local_id">Nomor Lokal (opsional)</label>
                    <input type="text" id="local_id" name="local_id"
                        value="<?= esc($valLocalId) ?>"
                        placeholder="Auto-generate">
                </div>

                <div class="btn-row">
                    <button type="submit" class="btn btn-primary">💾 <?= $isEdit ? 'Simpan Perubahan' : 'Simpan Alergi' ?></button>
                    <a href="<?= base_url('allergy-intolerance') ?>" class="btn btn-secondary">↩️ Batal</a>
                </div>

            </form>
        </div>
    </div>

    <script>
        function updateCodeHint() {
            const category = document.getElementById('category').value;
            const hint = document.getElementById('code-system-hint');
            const codeInput = document.getElementById('allergen_code');
            const displayInput = document.getElementById('allergen_display');

            if (category === 'medication') {
                hint.innerHTML = 'Sistem: <strong>KFA</strong>';
                codeInput.placeholder = '91000299';
                displayInput.placeholder = 'Aspirin';
            } else if (category === 'food') {
                hint.innerHTML = 'Sistem: <strong>SNOMED-CT</strong>';
                codeInput.placeholder = '226963000';
                displayInput.placeholder = 'Duck - meat';
            } else if (category === 'environment') {
                hint.innerHTML = 'Sistem: <strong>SNOMED-CT</strong>';
                codeInput.placeholder = '260147004';
                displayInput.placeholder = 'House dust';
            } else if (category === 'biologic') {
                hint.innerHTML = 'Sistem: <strong>SNOMED-CT</strong>';
                codeInput.placeholder = '256262006';
                displayInput.placeholder = 'Pollen';
            }
        }

        document.addEventListener('DOMContentLoaded', updateCodeHint);
    </script>
</body>

</html>