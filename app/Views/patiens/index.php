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
            max-width: 1200px;
            margin: 0 auto;
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .alert {
            padding: 12px 16px;
            margin: 10px 0;
            border-radius: 6px;
            border: 1px solid transparent;
            font-size: 14px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
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

        .toolbar {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 20px;
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }

        .toolbar input[type=text] {
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 180px;
        }

        .btn {
            display: inline-block;
            padding: 8px 14px;
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

        .btn-warning {
            background: #ffc107;
            color: #212529;
        }

        .btn-info {
            background: #17a2b8;
            color: white;
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        th {
            background: #2c3e50;
            color: white;
            font-weight: 600;
        }

        tr:hover {
            background: #f5f8fb;
        }

        .id-cell {
            font-family: monospace;
            font-size: 11px;
            color: #555;
            max-width: 250px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .code-cell {
            font-family: monospace;
            font-weight: bold;
            background: #eef3f8;
            padding: 2px 6px;
            border-radius: 3px;
            color: #0066cc;
        }

        .empty {
            text-align: center;
            padding: 40px;
            color: #777;
            background: white;
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>👤 <?= esc($title) ?></h1>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">✅ <?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-error">❌ <?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form method="get" action="" class="toolbar">
            <label for="nik"><strong>NIK:</strong></label>
            <input type="text" id="nik" name="nik" value="<?= esc($nik ?? '') ?>" placeholder="16 digit">
            <label for="name"><strong>Nama:</strong></label>
            <input type="text" id="name" name="name" value="<?= esc($name ?? '') ?>" placeholder="Nama pasien">
            <label for="id"><strong>IHS Number:</strong></label>
            <input type="text" id="id" name="id" value="<?= esc($id ?? '') ?>" placeholder="100000030009">
            <button type="submit" class="btn btn-secondary">🔍 Cari</button>
            <a href="<?= base_url('patiens/create') ?>" class="btn btn-primary">+ Tambah Pasien</a>
        </form>

        <div class="alert alert-info">
            ℹ️ Cari berdasarkan salah satu: NIK, Nama, atau IHS Number.
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-error">❌ <strong>Info:</strong> <?= esc($error) ?></div>
        <?php endif; ?>

        <?php if (!empty($patients)): ?>
            <table>
                <thead>
                    <tr>
                        <th style="width: 22%;">IHS Number</th>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>Gender</th>
                        <th>Tgl Lahir</th>
                        <th style="width: 12%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($patients as $entry): ?>
                        <?php
                        $p = $entry['resource'] ?? [];
                        $id = $p['id'] ?? '';
                        $pname = $p['name'][0]['text'] ?? '-';
                        $nik = '-';
                        foreach ($p['identifier'] ?? [] as $i) {
                            if (($i['system'] ?? '') === 'https://fhir.kemkes.go.id/id/nik') {
                                $nik = $i['value'] ?? '-';
                            }
                        }
                        $pgender = $p['gender'] ?? '-';
                        $birthDate = $p['birthDate'] ?? '-';
                        ?>
                        <tr>
                            <td class="id-cell" title="<?= esc($id) ?>"><?= esc($id) ?></td>
                            <td><?= esc($pname) ?></td>
                            <td><span class="code-cell"><?= esc($nik) ?></span></td>
                            <td><?= esc(ucfirst($pgender)) ?></td>
                            <td><?= esc($birthDate) ?></td>
                            <td>
                                <a href="<?= base_url('patiens/edit/' . $id) ?>" class="btn btn-warning btn-sm">✏️</a>
                                <a href="<?= base_url('patiens/debug/' . $id) ?>" class="btn btn-info btn-sm" target="_blank">🔍</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>

</html>