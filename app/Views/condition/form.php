<?php
$isEdit = !empty($condition['id']);

// Ambil nilai
$valPatientId   = old('patient_id')      ?? str_replace('Patient/', '', $condition['subject']['reference'] ?? '');
$valPatientName = old('patient_name')    ?? ($condition['subject']['display'] ?? '');
$valEncounterId = old('encounter_id')    ?? str_replace('Encounter/', '', $condition['encounter']['reference'] ?? '');
$valIcdCode     = old('icd_code')        ?? ($condition['code']['coding'][0]['code'] ?? '');
$valIcdDisplay  = old('icd_display')     ?? ($condition['code']['coding'][0]['display'] ?? ($condition['code']['text'] ?? ''));
$valCategory    = old('category')        ?? ($condition['category'][0]['coding'][0]['code'] ?? 'encounter-diagnosis');
$valClinical    = old('clinical_status') ?? ($condition['clinicalStatus']['coding'][0]['code'] ?? 'active');
$valOnset       = old('onset_date');

if ($valOnset === null && !empty($condition['onsetDateTime'])) {
    $valOnset = date('Y-m-d\TH:i', strtotime($condition['onsetDateTime']));
}

$valNote = old('note') ?? ($condition['note'][0]['text'] ?? '');
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
            min-height: 80px;
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

        <h1>🩺 <?= esc($title) ?></h1>

        <div class="card">

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error">
                    ❌ <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if ($isEdit): ?>
                <div class="form-group">
                    <label>Condition ID</label>
                    <div class="readonly-info"><?= esc($condition['id']) ?></div>
                    <small class="hint">Dibuat otomatis oleh SATUSEHAT</small>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= esc($action) ?>">
                <?= csrf_field() ?>

                <!-- ============================================ -->
                <div class="section-title">👤 Data Pasien</div>
                <!-- ============================================ -->

                <div class="form-row">
                    <div class="form-group">
                        <label for="patient_id">Patient ID (IHS) *</label>
                        <input type="text" id="patient_id" name="patient_id"
                            value="<?= esc($valPatientId) ?>"
                            placeholder="100000030009" required>
                    </div>
                    <div class="form-group">
                        <label for="patient_name">Nama Pasien</label>
                        <input type="text" id="patient_name" name="patient_name"
                            value="<?= esc($valPatientName) ?>"
                            placeholder="Budi Santoso">
                    </div>
                </div>

                <div class="form-group">
                    <label for="encounter_id">Encounter ID *</label>
                    <input type="text" id="encounter_id" name="encounter_id"
                        value="<?= esc($valEncounterId) ?>"
                        placeholder="UUID Encounter (dari POST Encounter)" required>
                    <small class="hint">
                        ID Encounter tempat diagnosis ini ditegakkan.
                        Dapatkan dari halaman <strong>Daftar Encounter</strong>.
                    </small>
                </div>

                <!-- ============================================ -->
                <div class="section-title">🔬 Diagnosis (ICD-10)</div>
                <!-- ============================================ -->

                <div class="form-row">
                    <div class="form-group">
                        <label for="icd_code">Kode ICD-10 *</label>
                        <input type="text" id="icd_code" name="icd_code"
                            value="<?= esc($valIcdCode) ?>"
                            placeholder="A15.0" required>
                        <small class="hint">Contoh: A15.0 (TB Paru), E11 (DM Tipe 2)</small>
                    </div>
                    <div class="form-group">
                        <label for="icd_display">Nama Diagnosis *</label>
                        <input type="text" id="icd_display" name="icd_display"
                            value="<?= esc($valIcdDisplay) ?>"
                            placeholder="Tuberculosis of lung" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="category">Kategori</label>
                        <select id="category" name="category">
                            <option value="encounter-diagnosis" <?= $valCategory === 'encounter-diagnosis' ? 'selected' : '' ?>>
                                Encounter Diagnosis (Diagnosis Kunjungan)
                            </option>
                            <option value="problem-list-item" <?= $valCategory === 'problem-list-item'   ? 'selected' : '' ?>>
                                Problem List Item (Riwayat Penyakit)
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="clinical_status">Status Klinis</label>
                        <select id="clinical_status" name="clinical_status">
                            <option value="active" <?= $valClinical === 'active'   ? 'selected' : '' ?>>Active (Masih diderita)</option>
                            <option value="resolved" <?= $valClinical === 'resolved' ? 'selected' : '' ?>>Resolved (Sembuh)</option>
                            <option value="inactive" <?= $valClinical === 'inactive' ? 'selected' : '' ?>>Inactive (Tidak aktif)</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="onset_date">Tanggal Onset (mulai sakit)</label>
                    <input type="datetime-local" id="onset_date" name="onset_date"
                        value="<?= esc($valOnset) ?>">
                    <small class="hint">Kosongkan jika tidak diketahui</small>
                </div>

                <div class="form-group">
                    <label for="note">Catatan Tambahan</label>
                    <textarea id="note" name="note"
                        placeholder="Catatan dokter, kondisi khusus, dll"><?= esc($valNote) ?></textarea>
                </div>

                <!-- TOMBOL -->
                <div class="btn-row">
                    <button type="submit" class="btn btn-primary">
                        💾 <?= $isEdit ? 'Simpan Perubahan' : 'Simpan Condition' ?>
                    </button>
                    <a href="<?= base_url('condition') ?>" class="btn btn-secondary">
                        ↩️ Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
</body>

</html>