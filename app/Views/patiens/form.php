<?php
$isEdit = !empty($patient['id']);

$valNik         = old('nik')        ?? ($patient['nik'] ?? '');
$valPaspor      = old('paspor')     ?? ($patient['paspor'] ?? '');
$valKk          = old('kk')         ?? ($patient['kk'] ?? '');
$valName        = old('name')       ?? ($patient['name'] ?? '');
$valGender      = old('gender')     ?? ($patient['gender'] ?? 'male');
$valBirthDate   = old('birth_date') ?? ($patient['birth_date'] ?? '');
$valBirthPlace  = old('birth_place') ?? ($patient['birth_place'] ?? '');
$valCitizenship = old('citizenship_status') ?? ($patient['citizenship_status'] ?? 'WNI');
$valDeceased    = old('deceased_boolean')   ?? ($patient['deceased_boolean'] ?? '0');
$valMultiple    = old('multiple_birth')     ?? ($patient['multiple_birth'] ?? '0');

$valPhone       = old('phone')      ?? ($patient['phone'] ?? '');
$valHomePhone   = old('home_phone') ?? ($patient['home_phone'] ?? '');
$valEmail       = old('email')      ?? ($patient['email'] ?? '');

$valAddress     = old('address_line') ?? ($patient['address_line'] ?? '');
$valCity        = old('city')         ?? ($patient['city'] ?? '');
$valPostal      = old('postal_code')  ?? ($patient['postal_code'] ?? '');
$valCountry     = old('country')      ?? ($patient['country'] ?? 'ID');
$valProvince    = old('province_code') ?? ($patient['province_code'] ?? '');
$valCityCode    = old('city_code')    ?? ($patient['city_code'] ?? '');
$valDistrict    = old('district_code') ?? ($patient['district_code'] ?? '');
$valVillage     = old('village_code') ?? ($patient['village_code'] ?? '');
$valRt          = old('rt')           ?? ($patient['rt'] ?? '');
$valRw          = old('rw')           ?? ($patient['rw'] ?? '');

$valMarital     = old('marital_status') ?? ($patient['marital_status'] ?? '');
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
        input[type=email],
        input[type=date],
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

        input[readonly] {
            background: #eee;
            cursor: not-allowed;
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
        <h1>👤 <?= esc($title) ?></h1>
        <div class="card">

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error">❌ <?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <?php if ($isEdit): ?>
                <div class="form-group">
                    <label>IHS Number (ID SATUSEHAT)</label>
                    <div class="readonly-info"><?= esc($patient['id']) ?></div>
                    <small class="hint">Dibuat otomatis oleh SATUSEHAT. Gunakan untuk semua resource klinis.</small>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= esc($action) ?>">
                <?= csrf_field() ?>

                <div class="section-title">📋 Identitas Utama</div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="nik">NIK (16 digit) *</label>
                        <input type="text" id="nik" name="nik" value="<?= esc($valNik) ?>"
                            placeholder="3174031002890009"
                            maxlength="16" pattern="[0-9]{16}"
                            <?= $isEdit ? 'readonly' : 'required' ?>>
                        <small class="hint">
                            <?= $isEdit ? 'NIK tidak dapat diubah setelah dibuat.' : 'Harus 16 digit angka.' ?>
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="name">Nama Lengkap *</label>
                        <input type="text" id="name" name="name" value="<?= esc($valName) ?>"
                            placeholder="John Smith" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="paspor">No. Paspor (opsional)</label>
                        <input type="text" id="paspor" name="paspor" value="<?= esc($valPaspor) ?>" placeholder="A01111222">
                    </div>
                    <div class="form-group">
                        <label for="kk">No. Kartu Keluarga (opsional)</label>
                        <input type="text" id="kk" name="kk" value="<?= esc($valKk) ?>" placeholder="367400001111111">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="gender">Jenis Kelamin *</label>
                        <select id="gender" name="gender" required>
                            <option value="male" <?= $valGender === 'male'    ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="female" <?= $valGender === 'female'  ? 'selected' : '' ?>>Perempuan</option>
                            <option value="other" <?= $valGender === 'other'   ? 'selected' : '' ?>>Lainnya</option>
                            <option value="unknown" <?= $valGender === 'unknown' ? 'selected' : '' ?>>Tidak Diketahui</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="birth_date">Tanggal Lahir *</label>
                        <input type="date" id="birth_date" name="birth_date" value="<?= esc($valBirthDate) ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="birth_place">Tempat Lahir *</label>
                        <input type="text" id="birth_place" name="birth_place" value="<?= esc($valBirthPlace) ?>" placeholder="Bandung" required>
                    </div>
                    <div class="form-group">
                        <label for="citizenship_status">Kewarganegaraan</label>
                        <select id="citizenship_status" name="citizenship_status">
                            <option value="WNI" <?= $valCitizenship === 'WNI' ? 'selected' : '' ?>>WNI</option>
                            <option value="WNA" <?= $valCitizenship === 'WNA' ? 'selected' : '' ?>>WNA</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="multiple_birth">Status Kembar</label>
                        <select id="multiple_birth" name="multiple_birth">
                            <option value="0" <?= $valMultiple == '0' ? 'selected' : '' ?>>Tidak Kembar</option>
                            <option value="1" <?= $valMultiple == '1' ? 'selected' : '' ?>>Kembar (Anak ke-1)</option>
                            <option value="2" <?= $valMultiple == '2' ? 'selected' : '' ?>>Kembar (Anak ke-2)</option>
                            <option value="3" <?= $valMultiple == '3' ? 'selected' : '' ?>>Kembar (Anak ke-3)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="deceased_boolean">Status Hidup</label>
                        <select id="deceased_boolean" name="deceased_boolean">
                            <option value="0" <?= $valDeceased === '0' ? 'selected' : '' ?>>Hidup</option>
                            <option value="1" <?= $valDeceased === '1' ? 'selected' : '' ?>>Meninggal</option>
                        </select>
                    </div>
                </div>

                <div class="section-title">📞 Kontak</div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="phone">No. HP</label>
                        <input type="text" id="phone" name="phone" value="<?= esc($valPhone) ?>" placeholder="08123456789">
                    </div>
                    <div class="form-group">
                        <label for="home_phone">Telepon Rumah</label>
                        <input type="text" id="home_phone" name="home_phone" value="<?= esc($valHomePhone) ?>" placeholder="+622123456789">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?= esc($valEmail) ?>" placeholder="john.smith@example.com">
                </div>

                <div class="section-title">🏠 Alamat</div>

                <div class="form-group">
                    <label for="address_line">Alamat Lengkap</label>
                    <input type="text" id="address_line" name="address_line" value="<?= esc($valAddress) ?>" placeholder="Jl. H.R. Rasuna Said Blok X5 Kav. 4-9 Kuningan">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="rt">RT</label>
                        <input type="text" id="rt" name="rt" value="<?= esc($valRt) ?>" placeholder="2">
                    </div>
                    <div class="form-group">
                        <label for="rw">RW</label>
                        <input type="text" id="rw" name="rw" value="<?= esc($valRw) ?>" placeholder="2">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="province_code">Kode Provinsi</label>
                        <input type="text" id="province_code" name="province_code" value="<?= esc($valProvince) ?>" placeholder="10 (DKI Jakarta)">
                    </div>
                    <div class="form-group">
                        <label for="city_code">Kode Kota/Kabupaten</label>
                        <input type="text" id="city_code" name="city_code" value="<?= esc($valCityCode) ?>" placeholder="1010">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="district_code">Kode Kecamatan</label>
                        <input type="text" id="district_code" name="district_code" value="<?= esc($valDistrict) ?>" placeholder="1010101">
                    </div>
                    <div class="form-group">
                        <label for="village_code">Kode Kelurahan</label>
                        <input type="text" id="village_code" name="village_code" value="<?= esc($valVillage) ?>" placeholder="1010101101">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="city">Kota/Kabupaten</label>
                        <input type="text" id="city" name="city" value="<?= esc($valCity) ?>" placeholder="Jakarta">
                    </div>
                    <div class="form-group">
                        <label for="postal_code">Kode Pos</label>
                        <input type="text" id="postal_code" name="postal_code" value="<?= esc($valPostal) ?>" placeholder="12950">
                    </div>
                </div>

                <div class="form-group">
                    <label for="country">Negara</label>
                    <input type="text" id="country" name="country" value="<?= esc($valCountry) ?>" placeholder="ID">
                    <small class="hint">Kode negara ISO 2 huruf (ID = Indonesia)</small>
                </div>

                <div class="section-title">💍 Status Pernikahan</div>

                <div class="form-group">
                    <label for="marital_status">Status Pernikahan</label>
                    <select id="marital_status" name="marital_status">
                        <option value="">-- Pilih --</option>
                        <option value="S" <?= $valMarital === 'S' ? 'selected' : '' ?>>Belum Menikah</option>
                        <option value="M" <?= $valMarital === 'M' ? 'selected' : '' ?>>Menikah</option>
                        <option value="D" <?= $valMarital === 'D' ? 'selected' : '' ?>>Cerai</option>
                        <option value="W" <?= $valMarital === 'W' ? 'selected' : '' ?>>Janda/Duda</option>
                        <option value="U" <?= $valMarital === 'U' ? 'selected' : '' ?>>Tidak Diketahui</option>
                    </select>
                </div>

                <div class="btn-row">
                    <button type="submit" class="btn btn-primary">💾 <?= $isEdit ? 'Simpan Perubahan' : 'Simpan Pasien' ?></button>
                    <a href="<?= base_url('patiens') ?>" class="btn btn-secondary">↩️ Batal</a>
                </div>

            </form>
        </div>
    </div>
</body>

</html>