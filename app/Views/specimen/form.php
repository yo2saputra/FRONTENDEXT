<?php
$isEdit = !empty($specimen['id']);

$valPatientId   = old('patient_id')   ?? str_replace('Patient/', '', $specimen['subject']['reference'] ?? '');
$valPatientName = old('patient_name') ?? ($specimen['subject']['display'] ?? '');
$valOrgId       = old('org_id')       ?? '';
$valSpecimenId  = old('specimen_id')  ?? ($specimen['identifier'][0]['value'] ?? '');
$valTypeCode    = old('specimen_type') ?? ($specimen['type']['coding'][0]['code'] ?? '');
$valTypeDisplay = old('specimen_type_display') ?? ($specimen['type']['coding'][0]['display'] ?? '');
$valCollection  = old('collection_time');
if ($valCollection === null && !empty($specimen['collection']['collectedDateTime'])) {
    $valCollection = date('Y-m-d\TH:i', strtotime($specimen['collection']['collectedDateTime']));
}
if ($valCollection === null) $valCollection = date('Y-m-d\TH:i');
$valCollectorId   = old('collector_id')   ?? str_replace('Practitioner/', '', $specimen['collection']['collector']['reference'] ?? '');
$valCollectorName = old('collector_name') ?? ($specimen['collection']['collector']['display'] ?? '');
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
        input[type=datetime-local] {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            font-family: inherit;
            background: white;
        }

        input:focus {
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
        <h1>🧪 <?= esc($title) ?></h1>
        <div class="card">

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error">❌ <?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <?php if ($isEdit): ?>
                <div class="form-group">
                    <label>Specimen ID</label>
                    <div class="readonly-info"><?= esc($specimen['id']) ?></div>
                    <small class="hint">Dibuat otomatis oleh SATUSEHAT</small>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= esc($action) ?>">
                <?= csrf_field() ?>

                <!-- ============================================ -->
                <div class="section-title">👤 Data Pasien & Fasyankes</div>
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

                <div class="form-group">
                    <label>Organization ID (dari .env)</label>
                    <div class="readonly-info"><?= esc($_ENV['SATUSEHAT_ORG_ID'] ?? 'BELUM DIISI DI .env') ?></div>
                    <small class="hint">Diambil dari <code>SATUSEHAT_ORG_ID</code> di file .env</small>
                </div>

                <!-- TAMBAHKAN field ServiceRequest ID -->
                <div class="form-group">
                    <label for="service_request_id">ServiceRequest ID *</label>
                    <input type="text" id="service_request_id" name="service_request_id"
                        value="<?= esc(old('service_request_id') ?? '') ?>"
                        placeholder="UUID ServiceRequest" required>
                    <small class="hint">
                        ID ServiceRequest yang menjadi dasar permintaan pemeriksaan.
                        Dapatkan dari hasil POST /ServiceRequest.
                    </small>
                </div>

                <!-- ============================================ -->
                <div class="section-title">🧪 Detail Spesimen</div>
                <!-- ============================================ -->

                <div class="form-row">
                    <div class="form-group">
                        <label for="specimen_id">Nomor Spesimen *</label>
                        <input type="text" id="specimen_id" name="specimen_id" value="<?= esc($valSpecimenId) ?>" placeholder="00001" required>
                        <small class="hint">Nomor internal dari RME Anda</small>
                    </div>
                    <div class="form-group">
                        <label for="specimen_type">Kode SNOMED-CT *</label>
                        <input type="text" id="specimen_type" name="specimen_type" value="<?= esc($valTypeCode) ?>" placeholder="119294007" required>
                        <small class="hint">Contoh: 119294007 (Dried blood)</small>
                    </div>
                </div>

                <div class="form-group">
                    <label for="specimen_type_display">Nama Jenis Spesimen</label>
                    <input type="text" id="specimen_type_display" name="specimen_type_display" value="<?= esc($valTypeDisplay) ?>" placeholder="Dried blood specimen">
                </div>

                <!-- ============================================ -->
                <div class="section-title">📅 Waktu & Petugas Pengambilan</div>
                <!-- ============================================ -->

                <div class="form-group">
                    <label for="collection_time">Waktu Pengambilan *</label>
                    <input type="datetime-local" id="collection_time" name="collection_time" value="<?= esc($valCollection) ?>" required>
                    <small class="hint">Waktu lokal, akan diformat ke UTC +00</small>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="collector_id">ID Petugas Pengambil</label>
                        <input type="text" id="collector_id" name="collector_id" value="<?= esc($valCollectorId) ?>" placeholder="N10000001">
                    </div>
                    <div class="form-group">
                        <label for="collector_name">Nama Petugas</label>
                        <input type="text" id="collector_name" name="collector_name" value="<?= esc($valCollectorName) ?>" placeholder="dr. Abele Rose">
                    </div>
                </div>

                <!-- TOMBOL -->
                <div class="btn-row">
                    <button type="submit" class="btn btn-primary">💾 <?= $isEdit ? 'Simpan Perubahan' : 'Simpan Specimen' ?></button>
                    <a href="<?= base_url('specimen') ?>" class="btn btn-secondary">↩️ Batal</a>
                </div>

            </form>
        </div>
    </div>
</body>

</html>