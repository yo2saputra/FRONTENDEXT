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

        .btn-danger {
            background: #dc3545;
            color: white;
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

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-active {
            background: #d1e7dd;
            color: #0f5132;
        }

        .badge-inactive {
            background: #e2e3e5;
            color: #383d41;
        }

        .id-cell {
            font-family: monospace;
            font-size: 12px;
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
        <h1>💊 <?= esc($title) ?></h1>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">✅ <?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-error">❌ <?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <div class="toolbar">
            <a href="<?= base_url('medication/create') ?>" class="btn btn-primary">+ Tambah Obat</a>
            <a href="<?= base_url('medication-request') ?>" class="btn btn-secondary">💊 Daftar Resep</a>
        </div>

        <?php if (!empty($info)): ?>
            <div class="alert alert-info">ℹ️ <?= esc($info) ?></div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert alert-error">❌ <strong>Gagal memuat data:</strong>
                <pre style="white-space: pre-wrap; margin: 5px 0 0;"><?= esc($error) ?></pre>
            </div>
        <?php endif; ?>

        <?php if (empty($medications)): ?>
            <div class="empty">
                <p>📭 Belum ada data Medication yang dapat ditampilkan.</p>
                <p>Klik <strong>+ Tambah Obat</strong> untuk membuat data obat baru, atau buat resep melalui menu <strong>Daftar Resep</strong> (Medication akan dibuat otomatis).</p>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th style="width: 22%;">ID</th>
                        <th>Kode Lokal</th>
                        <th>Nama Obat</th>
                        <th>Kode KFA</th>
                        <th>Status</th>
                        <th style="width: 18%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($medications as $entry): ?>
                        <?php
                        $m = $entry['resource'] ?? [];
                        $id = $m['id'] ?? '';
                        $localId = $m['identifier'][0]['value'] ?? '-';
                        $medName = $m['code']['coding'][0]['display'] ?? '-';
                        $kfa = $m['code']['coding'][0]['code'] ?? '-';
                        $status = $m['status'] ?? '-';
                        $badgeCls = 'badge-' . $status;
                        ?>
                        <tr>
                            <td class="id-cell" title="<?= esc($id) ?>"><?= esc($id) ?></td>
                            <td><span class="code-cell"><?= esc($localId) ?></span></td>
                            <td><?= esc($medName) ?></td>
                            <td><span class="code-cell"><?= esc($kfa) ?></span></td>
                            <td><span class="badge <?= esc($badgeCls) ?>"><?= esc(ucfirst($status)) ?></span></td>
                            <td>
                                <a href="<?= base_url('medication/edit/' . $id) ?>" class="btn btn-warning btn-sm">✏️ Edit</a>
                                <a href="<?= base_url('medication/debug/' . $id) ?>" class="btn btn-info btn-sm" target="_blank">🔍</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>

</html>