<?php
$isEdit = !empty($request['id']);

$valPatientId      = old('patient_id')      ?? ($request['patient_id'] ?? '');
$valPatientName    = old('patient_name')    ?? ($request['patient_name'] ?? '');
$valEncounterId    = old('encounter_id')    ?? ($request['encounter_id'] ?? '');
$valPractitionerId = old('practitioner_id') ?? ($request['practitioner_id'] ?? 'N10000001');
$valPractName      = old('practitioner_name') ?? ($request['practitioner_name'] ?? '');
$valLoincCode      = old('loinc_code')      ?? ($request['loinc_code'] ?? '58410-2');
$valLoincDisplay   = old('loinc_display')   ?? ($request['loinc_display'] ?? 'CBC panel - Blood by Automated count');
$valLocalId        = old('local_id')        ?? ($request['local_id'] ?? '');
$valCategoryCode   = old('category_code')   ?? ($request['category_code'] ?? '108252007');
$valCategoryDisp   = old('category_display') ?? ($request['category_display'] ?? 'Laboratory procedure');
$valPriority       = old('priority')        ?? ($request['priority'] ?? 'routine');
$valNote           = old('note')            ?? ($request['note'] ?? '');
$valStatus         = old('status')          ?? ($request['status'] ?? 'active');
$valPerformerId      = old('performer_id')      ?? ($request['performer_id'] ?? '');
$valPerformerName    = old('performer_name')    ?? ($request['performer_name'] ?? '');
$valEncounterDisplay = old('encounter_display') ?? ($request['encounter_display'] ?? '');
$valIntent           = old('intent')            ?? ($request['intent'] ?? 'original-order');
$valOccurrence       = old('occurrence_date')   ?? ($request['occurrence_date'] ?? '');
$valReasonText       = old('reason_text')       ?? ($request['reason_text'] ?? '');
$valLoincText        = old('loinc_text')        ?? ($request['loinc_text'] ?? '');
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

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
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

        .btn-success {
            background: #28a745;
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

        .code-info {
            background: #d1ecf1;
            padding: 10px 12px;
            border-radius: 4px;
            font-size: 12px;
            color: #0c5460;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>🧪 <?= esc($title) ?></h1>
        <div class="card">

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">✅ <?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error">❌ <?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <?php if ($isEdit): ?>
                <div class="form-group">
                    <label>ServiceRequest ID</label>
                    <div class="readonly-info"><?= esc($request['id']) ?></div>
                    <small class="hint">Dibuat otomatis oleh SATUSEHAT. Salin untuk membuat Specimen.</small>
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
                    <small class="hint">Encounter tempat permintaan lab dibuat.</small>
                </div>

                <!-- ============================================ -->
                <div class="section-title">👨‍⚕️ Petugas Laboratorium (Opsional)</div>
                <!-- ============================================ -->

                <div class="form-row">
                    <div class="form-group">
                        <label for="performer_id">Performer ID</label>
                        <input type="text" id="performer_id" name="performer_id"
                            value="<?= esc($valPerformerId) ?>"
                            placeholder="N10000005">
                        <small class="hint">Practitioner yang mengerjakan pemeriksaan.</small>
                    </div>
                    <div class="form-group">
                        <label for="performer_name">Nama Performer</label>
                        <input type="text" id="performer_name" name="performer_name"
                            value="<?= esc($valPerformerName) ?>"
                            placeholder="Fatma">
                    </div>
                </div>

                <!-- ============================================ -->
                <div class="section-title">📝 Detail Tambahan</div>
                <!-- ============================================ -->

                <div class="form-group">
                    <label for="encounter_display">Deskripsi Encounter</label>
                    <input type="text" id="encounter_display" name="encounter_display"
                        value="<?= esc($valEncounterDisplay) ?>"
                        placeholder="Permintaan BTA Sputum Budi Santoso">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="intent">Intent</label>
                        <select id="intent" name="intent">
                            <option value="original-order" <?= $valIntent === 'original-order' ? 'selected' : '' ?>>Original Order</option>
                            <option value="order" <?= $valIntent === 'order'          ? 'selected' : '' ?>>Order</option>
                            <option value="reflex-order" <?= $valIntent === 'reflex-order'   ? 'selected' : '' ?>>Reflex Order</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="occurrence_date">Waktu Pemeriksaan</label>
                        <input type="datetime-local" id="occurrence_date" name="occurrence_date"
                            value="<?= esc($valOccurrence) ?>">
                        <small class="hint">Kapan pemeriksaan dijadwalkan.</small>
                    </div>
                </div>

                <div class="form-group">
                    <label for="reason_text">Alasan Pemeriksaan</label>
                    <input type="text" id="reason_text" name="reason_text"
                        value="<?= esc($valReasonText) ?>"
                        placeholder="Periksa jika ada kemungkinan Tuberculosis">
                </div>

                <div class="form-group">
                    <label for="loinc_text">Teks Tambahan (opsional)</label>
                    <input type="text" id="loinc_text" name="loinc_text"
                        value="<?= esc($valLoincText) ?>"
                        placeholder="Pemeriksaan Sputum BTA">
                </div>

                <div class="section-title">👨‍⚕️ Dokter Peminta</div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="practitioner_id">Practitioner ID *</label>
                        <input type="text" id="practitioner_id" name="practitioner_id" value="<?= esc($valPractitionerId) ?>" placeholder="N10000001" required>
                    </div>
                    <div class="form-group">
                        <label for="practitioner_name">Nama Dokter</label>
                        <input type="text" id="practitioner_name" name="practitioner_name" value="<?= esc($valPractName) ?>" placeholder="dr. Abele Rose">
                    </div>
                </div>

                <div class="section-title">🔬 Pemeriksaan yang Diminta</div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="loinc_code">Kode LOINC *</label>
                        <input type="text" id="loinc_code" name="loinc_code" value="<?= esc($valLoincCode) ?>" placeholder="58410-2" required>
                        <small class="hint">CBC: 58410-2, Glukosa: 2339-0, Hb: 718-7</small>
                    </div>
                    <div class="form-group">
                        <label for="loinc_display">Nama Pemeriksaan</label>
                        <input type="text" id="loinc_display" name="loinc_display" value="<?= esc($valLoincDisplay) ?>" placeholder="CBC panel - Blood by Automated count">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="category_code">Kategori (SNOMED-CT)</label>
                        <input type="text" id="category_code" name="category_code" value="<?= esc($valCategoryCode) ?>" placeholder="108252007">
                    </div>
                    <div class="form-group">
                        <label for="category_display">Nama Kategori</label>
                        <input type="text" id="category_display" name="category_display" value="<?= esc($valCategoryDisp) ?>" placeholder="Laboratory procedure">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="priority">Prioritas</label>
                        <select id="priority" name="priority">
                            <option value="routine" <?= $valPriority === 'routine' ? 'selected' : '' ?>>Routine</option>
                            <option value="urgent" <?= $valPriority === 'urgent'  ? 'selected' : '' ?>>Urgent</option>
                            <option value="asap" <?= $valPriority === 'asap'    ? 'selected' : '' ?>>ASAP</option>
                            <option value="stat" <?= $valPriority === 'stat'    ? 'selected' : '' ?>>STAT</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="local_id">Nomor Lokal (opsional)</label>
                        <input type="text" id="local_id" name="local_id" value="<?= esc($valLocalId) ?>" placeholder="Auto-generate">
                    </div>
                </div>

                <div class="section-title">📝 Catatan Tambahan</div>

                <div class="form-group">
                    <label for="note">Catatan</label>
                    <textarea id="note" name="note" placeholder="Catatan untuk petugas lab, kondisi khusus pasien, dll"><?= esc($valNote) ?></textarea>
                </div>

                <?php if ($isEdit): ?>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status">
                            <option value="active" <?= $valStatus === 'active'    ? 'selected' : '' ?>>Active</option>
                            <option value="completed" <?= $valStatus === 'completed' ? 'selected' : '' ?>>Completed</option>
                            <option value="revoked" <?= $valStatus === 'revoked'   ? 'selected' : '' ?>>Revoked (Dibatalkan)</option>
                        </select>
                    </div>
                <?php endif; ?>

                <div class="btn-row">
                    <button type="submit" class="btn btn-primary">💾 <?= $isEdit ? 'Simpan Perubahan' : 'Buat ServiceRequest' ?></button>
                    <a href="<?= base_url('service-request') ?>" class="btn btn-secondary">↩️ Batal</a>
                    <?php if ($isEdit): ?>
                        <a href="<?= base_url('specimen/create?service_request_id=' . ($request['id'] ?? '')) ?>" class="btn btn-success">
                            🧪 Buat Specimen
                        </a>
                    <?php endif; ?>
                </div>

            </form>
        </div>
    </div>
</body>

</html>