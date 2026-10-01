<?php
$isEdit = !empty($medication['id']);

// Ambil nilai lama (old input) atau dari data medication
$valLocalId     = old('local_id')     ?? ($medication['identifier'][0]['value'] ?? '');
$valKfaCode     = old('kfa_code')     ?? ($medication['code']['coding'][0]['code'] ?? '');
$valMedName     = old('medication_name') ?? ($medication['code']['coding'][0]['display'] ?? '');
$valFormCode    = old('form_code')    ?? ($medication['form']['coding'][0]['code'] ?? 'BS023');
$valFormDisplay = old('form_display') ?? ($medication['form']['coding'][0]['display'] ?? 'Kaplet Salut Selaput');
$valStatus      = old('status')       ?? ($medication['status'] ?? 'active');
$valManufacturer = old('manufacturer_id') ?? str_replace('Organization/', '', $medication['manufacturer']['reference'] ?? '');
$valMedType     = old('medication_type') ?? ($medication['extension'][0]['valueCodeableConcept']['coding'][0]['code'] ?? 'NC');

// Ingredient dari data lama
$oldIngredients = [];
if (!empty($medication['ingredient'])) {
    foreach ($medication['ingredient'] as $ing) {
        $oldIngredients[] = [
            'code'     => $ing['itemCodeableConcept']['coding'][0]['code'] ?? '',
            'display'  => $ing['itemCodeableConcept']['coding'][0]['display'] ?? '',
            'strength' => $ing['strength']['numerator']['value'] ?? ''
        ];
    }
}
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

        .btn-danger {
            background: #dc3545;
            color: white;
            padding: 10px 14px;
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

        .ingredient-row {
            display: grid;
            grid-template-columns: 2fr 2fr 1fr auto;
            gap: 8px;
            margin-bottom: 8px;
            align-items: start;
        }

        @media (max-width: 600px) {
            .ingredient-row {
                grid-template-columns: 1fr;
            }
        }

        .ingredient-row input {
            padding: 8px 10px;
            font-size: 13px;
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
                    <label>Medication ID</label>
                    <div class="readonly-info"><?= esc($medication['id']) ?></div>
                    <small class="hint">Dibuat otomatis oleh SATUSEHAT</small>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= esc($action) ?>">
                <?= csrf_field() ?>

                <!-- ============================================ -->
                <div class="section-title">💊 Informasi Utama Obat</div>
                <!-- ============================================ -->

                <div class="form-row">
                    <div class="form-group">
                        <label for="local_id">Kode Lokal Obat</label>
                        <input type="text" id="local_id" name="local_id" value="<?= esc($valLocalId) ?>" placeholder="123456789">
                        <small class="hint">Kosongkan untuk auto-generate</small>
                    </div>
                    <div class="form-group">
                        <label for="kfa_code">Kode KFA Obat *</label>
                        <input type="text" id="kfa_code" name="kfa_code" value="<?= esc($valKfaCode) ?>" placeholder="93001019" required>
                        <small class="hint">Kode dari Kamus Farmasi dan Alat Kesehatan</small>
                    </div>
                </div>

                <div class="form-group">
                    <label for="medication_name">Nama Obat Lengkap *</label>
                    <input type="text" id="medication_name" name="medication_name" value="<?= esc($valMedName) ?>"
                        placeholder="Obat Anti Tuberculosis / Rifampicin 150 mg / Isoniazid 75 mg ..." required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status">
                            <option value="active" <?= $valStatus === 'active'           ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= $valStatus === 'inactive'         ? 'selected' : '' ?>>Inactive</option>
                            <option value="entered-in-error" <?= $valStatus === 'entered-in-error' ? 'selected' : '' ?>>Entered in Error</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="medication_type">Jenis Obat *</label>
                        <select id="medication_type" name="medication_type">
                            <option value="NC" <?= $valMedType === 'NC' ? 'selected' : '' ?>>Non-compound (Obat Pabrik)</option>
                            <option value="C" <?= $valMedType === 'C'  ? 'selected' : '' ?>>Compound (Racikan)</option>
                        </select>
                        <small class="hint">NC = obat tunggal/kombinasi pabrik, C = racikan</small>
                    </div>
                </div>

                <!-- ============================================ -->
                <div class="section-title">🏭 Produsen & Bentuk Sediaan</div>
                <!-- ============================================ -->

                <div class="form-group">
                    <label for="manufacturer_id">Manufacturer ID (Produsen) *</label>
                    <input type="text" id="manufacturer_id" name="manufacturer_id"
                        value="<?= esc($valManufacturer) ?>" placeholder="900001" required>
                    <small class="hint">IHS Number industri farmasi (tanpa prefix "Organization/")</small>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="form_code">Kode Bentuk Sediaan *</label>
                        <input type="text" id="form_code" name="form_code"
                            value="<?= esc($valFormCode) ?>" placeholder="BS023" required>
                        <small class="hint">Terminologi Kemenkes. Ex: BS023 (Kaplet Salut Selaput)</small>
                    </div>
                    <div class="form-group">
                        <label for="form_display">Nama Bentuk Sediaan</label>
                        <input type="text" id="form_display" name="form_display"
                            value="<?= esc($valFormDisplay) ?>" placeholder="Kaplet Salut Selaput">
                    </div>
                </div>

                <!-- ============================================ -->
                <div class="section-title">🧬 Kandungan Zat Aktif (Ingredient)</div>
                <!-- ============================================ -->

                <div class="form-group">
                    <label>Zat Aktif Obat *</label>
                    <div id="ingredient-list">
                        <?php if (!empty($oldIngredients)): ?>
                            <?php foreach ($oldIngredients as $ing): ?>
                                <div class="ingredient-row">
                                    <input type="text" name="ingredient_code[]" value="<?= esc($ing['code']) ?>" placeholder="Kode KFA (91000330)" required>
                                    <input type="text" name="ingredient_display[]" value="<?= esc($ing['display']) ?>" placeholder="Nama Zat (Rifampin)">
                                    <input type="text" name="ingredient_strength[]" value="<?= esc($ing['strength']) ?>" placeholder="mg (150)">
                                    <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger">×</button>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <button type="button" onclick="addIngredient()" class="btn btn-secondary" style="margin-top:8px;">+ Tambah Zat Aktif</button>
                    <small class="hint">Setiap zat aktif punya kode KFA sendiri (beda dari kode KFA obat).</small>
                </div>

                <!-- TOMBOL -->
                <div class="btn-row">
                    <button type="submit" class="btn btn-primary">💾 <?= $isEdit ? 'Simpan Perubahan' : 'Simpan Medication' ?></button>
                    <a href="<?= base_url('medication') ?>" class="btn btn-secondary">↩️ Batal</a>
                </div>

            </form>
        </div>
    </div>

    <script>
        /**
         * Tambah baris ingredient secara dinamis.
         */
        function addIngredient(code = '', display = '', strength = '') {
            const html = `
        <div class="ingredient-row">
            <input type="text" name="ingredient_code[]"     value="${escapeHtml(code)}"     placeholder="Kode KFA (91000330)" required>
            <input type="text" name="ingredient_display[]"  value="${escapeHtml(display)}"  placeholder="Nama Zat (Rifampin)">
            <input type="text" name="ingredient_strength[]" value="${escapeHtml(strength)}" placeholder="mg (150)">
            <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger">×</button>
        </div>
    `;
            document.getElementById('ingredient-list').insertAdjacentHTML('beforeend', html);
        }

        function escapeHtml(text) {
            if (text === null || text === undefined) return '';
            const div = document.createElement('div');
            div.textContent = String(text);
            return div.innerHTML;
        }

        // Auto-tambah 1 baris saat halaman dibuka (kalau belum ada)
        document.addEventListener('DOMContentLoaded', function() {
            const list = document.getElementById('ingredient-list');
            if (list && list.children.length === 0) {
                addIngredient();
            }
        });
    </script>

</body>

</html>