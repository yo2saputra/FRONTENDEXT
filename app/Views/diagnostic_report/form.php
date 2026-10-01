<?php
$isEdit = !empty($report['id']);

$valPatientId    = old('patient_id')    ?? ($report['patient_id'] ?? '');
$valPatientName  = old('patient_name')  ?? ($report['patient_name'] ?? '');
$valEncounterId  = old('encounter_id')  ?? ($report['encounter_id'] ?? '');
$valServiceReqId = old('service_request_id') ?? ($report['service_request_id'] ?? '');
$valSpecimenId   = old('specimen_id')   ?? ($report['specimen_id'] ?? '');
$valPractId      = old('practitioner_id') ?? ($report['practitioner_id'] ?? '');
$valPractName    = old('practitioner_name') ?? ($report['practitioner_name'] ?? '');
$valReportCode   = old('report_code')   ?? ($report['report_code'] ?? '58410-2');
$valReportDisp   = old('report_display') ?? ($report['report_display'] ?? 'CBC panel - Blood by Automated count');
$valReportSystem = old('report_system') ?? ($report['report_system'] ?? 'http://loinc.org');
$valEffective    = old('effective_date');
if ($valEffective === null && !empty($report['effective_date'])) {
    $valEffective = date('Y-m-d\TH:i', strtotime($report['effective_date']));
}
if ($valEffective === null) $valEffective = date('Y-m-d\TH:i');
$valIssued       = old('issued_date');
if ($valIssued === null && !empty($report['issued_date'])) {
    $valIssued = date('Y-m-d\TH:i', strtotime($report['issued_date']));
}
$valConclusion   = old('conclusion')    ?? ($report['conclusion'] ?? '');
$valStatus       = old('status')        ?? ($report['status'] ?? 'final');
$valObservationIds = old('observation_id') ?? ($report['observation_ids'] ?? []);
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

        .obs-row {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 8px;
            margin-bottom: 8px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>📊 <?= esc($title) ?></h1>
        <div class="card">

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error">❌ <?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <?php if ($isEdit): ?>
                <div class="form-group">
                    <label>DiagnosticReport ID</label>
                    <div class="readonly-info"><?= esc($report['id']) ?></div>
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

                <div class="section-title">🔗 Referensi Sumber</div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="service_request_id">ServiceRequest ID</label>
                        <input type="text" id="service_request_id" name="service_request_id" value="<?= esc($valServiceReqId) ?>" placeholder="UUID ServiceRequest">
                    </div>
                    <div class="form-group">
                        <label for="specimen_id">Specimen ID</label>
                        <input type="text" id="specimen_id" name="specimen_id" value="<?= esc($valSpecimenId) ?>" placeholder="UUID Specimen">
                    </div>
                </div>

                <div class="section-title">📊 Kode Laporan</div>

                <div class="form-group">
                    <label for="report_system">Sistem Kode</label>
                    <select id="report_system" name="report_system">
                        <option value="http://loinc.org" <?= $valReportSystem === 'http://loinc.org' ? 'selected' : '' ?>>LOINC</option>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="report_code">Kode Laporan *</label>
                        <input type="text" id="report_code" name="report_code" value="<?= esc($valReportCode) ?>" placeholder="58410-2" required>
                    </div>
                    <div class="form-group">
                        <label for="report_display">Nama Laporan</label>
                        <input type="text" id="report_display" name="report_display" value="<?= esc($valReportDisp) ?>" placeholder="CBC panel">
                    </div>
                </div>

                <div class="section-title">📅 Waktu Laporan</div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="effective_date">Waktu Pemeriksaan *</label>
                        <input type="datetime-local" id="effective_date" name="effective_date" value="<?= esc($valEffective) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="issued_date">Waktu Terbit</label>
                        <input type="datetime-local" id="issued_date" name="issued_date" value="<?= esc($valIssued) ?>">
                    </div>
                </div>

                <div class="section-title">🔬 Hasil Pemeriksaan (Observation)</div>

                <div class="form-group">
                    <label>Observation ID *</label>
                    <div id="observation-list">
                        <?php if (!empty($valObservationIds) && is_array($valObservationIds)): ?>
                            <?php foreach ($valObservationIds as $obsId): ?>
                                <div class="obs-row">
                                    <input type="text" name="observation_id[]" value="<?= esc($obsId) ?>" placeholder="UUID Observation" required>
                                    <button type="button" onclick="this.parentElement.remove()" class="btn btn-secondary">×</button>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="obs-row">
                                <input type="text" name="observation_id[]" value="" placeholder="UUID Observation" required>
                                <button type="button" onclick="this.parentElement.remove()" class="btn btn-secondary">×</button>
                            </div>
                        <?php endif; ?>
                    </div>
                    <button type="button" onclick="addObservation()" class="btn btn-secondary" style="margin-top:8px;">+ Tambah Hasil</button>
                    <small class="hint">Referensi ke hasil pemeriksaan (Observation) yang sudah dibuat.</small>
                </div>

                <div class="section-title">👨‍⚕️ Petugas & Catatan</div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="practitioner_id">Practitioner ID</label>
                        <input type="text" id="practitioner_id" name="practitioner_id" value="<?= esc($valPractId) ?>" placeholder="N10000001">
                    </div>
                    <div class="form-group">
                        <label for="practitioner_name">Nama Petugas</label>
                        <input type="text" id="practitioner_name" name="practitioner_name" value="<?= esc($valPractName) ?>" placeholder="dr. Abele Rose">
                    </div>
                </div>

                <div class="form-group">
                    <label for="conclusion">Kesimpulan</label>
                    <textarea id="conclusion" name="conclusion" placeholder="Kesimpulan hasil pemeriksaan"><?= esc($valConclusion) ?></textarea>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="final" <?= $valStatus === 'final' ? 'selected' : '' ?>>Final</option>
                        <option value="preliminary" <?= $valStatus === 'preliminary' ? 'selected' : '' ?>>Preliminary</option>
                        <option value="amended" <?= $valStatus === 'amended' ? 'selected' : '' ?>>Amended</option>
                        <option value="entered-in-error" <?= $valStatus === 'entered-in-error' ? 'selected' : '' ?>>Entered in Error</option>
                    </select>
                </div>

                <div class="btn-row">
                    <button type="submit" class="btn btn-primary">💾 <?= $isEdit ? 'Simpan Perubahan' : 'Simpan Laporan' ?></button>
                    <a href="<?= base_url('diagnostic-report') ?>" class="btn btn-secondary">↩️ Batal</a>
                </div>

            </form>
        </div>
    </div>

    <script>
        function addObservation() {
            const html = `
        <div class="obs-row">
            <input type="text" name="observation_id[]" value="" placeholder="UUID Observation" required>
            <button type="button" onclick="this.parentElement.remove()" class="btn btn-secondary">×</button>
        </div>
    `;
            document.getElementById('observation-list').insertAdjacentHTML('beforeend', html);
        }
    </script>
</body>

</html>