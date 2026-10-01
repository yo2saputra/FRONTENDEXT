<?php
$isEdit = !empty($request['id']);

$valPatientId   = old('patient_id')   ?? str_replace('Patient/', '', $request['subject']['reference'] ?? '');
$valPatientName = old('patient_name') ?? ($request['subject']['display'] ?? '');
$valPractId     = old('practitioner_id') ?? str_replace('Practitioner/', '', $request['requester']['reference'] ?? '');
$valPractName   = old('practitioner_name') ?? ($request['requester']['display'] ?? '');
$valPrescription = old('prescription_id') ?? ($request['identifier'][0]['value'] ?? '');
$valMedName     = old('medication_name') ?? '';
$valKfaCode     = old('kfa_code') ?? '';
$valDosage      = old('dosage_text') ?? ($request['dosageInstruction'][0]['text'] ?? '');
$valReasonCode  = old('reason_code') ?? ($request['reasonCode'][0]['coding'][0]['code'] ?? '');
$valReasonDisp  = old('reason_display') ?? ($request['reasonCode'][0]['coding'][0]['display'] ?? '');
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
        <h1>💊 <?= esc($title) ?></h1>
        <div class="card">

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error">❌ <?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <?php if ($isEdit): ?>
                <div class="form-group">
                    <label>MedicationRequest ID</label>
                    <div class="readonly-info"><?= esc($request['id']) ?></div>
                    <small class="hint">Dibuat otomatis oleh SATUSEHAT</small>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= esc($action) ?>">
                <?= csrf_field() ?>

                <!-- ============================================ -->
                <div class="section-title">👤 Data Pasien & Dokter</div>
                <!-- ============================================ -->

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

                <!-- ============================================ -->
                <div class="section-title">💊 Data Obat</div>
                <!-- ============================================ -->

                <div class="form-row">
                    <div class="form-group">
                        <label for="prescription_id">Nomor Resep *</label>
                        <input type="text" id="prescription_id" name="prescription_id" value="<?= esc($valPrescription) ?>" placeholder="RESEP-2024-001" required>
                        <small class="hint">Nomor lokal resep dari RME Anda</small>
                    </div>
                    <div class="form-group">
                        <label for="kfa_code">Kode KFA Obat *</label>
                        <input type="text" id="kfa_code" name="kfa_code" value="<?= esc($valKfaCode) ?>" placeholder="93001019" required>
                        <small class="hint">Kode dari Kamus Farmasi dan Alat Kesehatan (KFA)</small>
                    </div>
                </div>
                <div class="form-group">
                    <label for="encounter_id">Encounter ID *</label>
                    <input type="text" id="encounter_id" name="encounter_id"
                        value="<?= esc(old('encounter_id') ?? '') ?>"
                        placeholder="UUID Encounter" required>
                    <small class="hint">
                        ID Encounter tempat resep ini dibuat. Dapatkan dari halaman <strong>Daftar Encounter</strong>.
                    </small>
                </div>

                <div class="form-group">
                    <label for="medication_name">Nama Obat *</label>
                    <input type="text" id="medication_name" name="medication_name" value="<?= esc($valMedName) ?>" placeholder="Paracetamol 500 mg Tablet" required>
                </div>

                <!-- ============================================ -->
                <div class="section-title">📋 Aturan Pakai & Indikasi</div>
                <!-- ============================================ -->

                <div class="form-group">
                    <label for="dosage_text">Aturan Pakai *</label>
                    <textarea id="dosage_text" name="dosage_text" placeholder="3 x 1 tablet setelah makan" required><?= esc($valDosage) ?></textarea>
                    <small class="hint">Instruksi penggunaan obat untuk pasien</small>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="reason_code">Kode Diagnosis (ICD-10)</label>
                        <input type="text" id="reason_code" name="reason_code" value="<?= esc($valReasonCode) ?>" placeholder="A15.0">
                    </div>
                    <div class="form-group">
                        <label for="reason_display">Nama Diagnosis</label>
                        <input type="text" id="reason_display" name="reason_display" value="<?= esc($valReasonDisp) ?>" placeholder="Tuberculosis of lung">
                    </div>
                </div>

                <!-- TOMBOL -->
                <div class="btn-row">
                    <button type="submit" class="btn btn-primary">💾 <?= $isEdit ? 'Simpan Perubahan' : 'Simpan Resep' ?></button>
                    <a href="<?= base_url('medication-request') ?>" class="btn btn-secondary">↩️ Batal</a>
                </div>

            </form>
        </div>
    </div>
</body>

</html>