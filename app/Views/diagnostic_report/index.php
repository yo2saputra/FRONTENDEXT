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

        .alert-warning {
            background: #fff3cd;
            color: #856404;
            border-color: #ffeeba;
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
            width: 200px;
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

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-final {
            background: #d1e7dd;
            color: #0f5132;
        }

        .badge-preliminary {
            background: #cfe2ff;
            color: #084298;
        }

        .badge-entered-in-error {
            background: #f8d7da;
            color: #842029;
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
        <h1>📊 <?= esc($title) ?></h1>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">✅ <?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-error">❌ <?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form method="get" action="" class="toolbar">
            <label for="patient_id"><strong>Patient ID:</strong></label>
            <input type="text" id="patient_id" name="patient_id" value="<?= esc($patientId) ?>" placeholder="100000030009">
            <button type="submit" class="btn btn-secondary">🔍 Cari</button>
            <a href="<?= base_url('diagnostic-report/create') ?>" class="btn btn-primary">+ Buat Laporan</a>
        </form>

        <?php if (!empty($error)): ?>
            <div class="alert alert-error">❌ <strong>Gagal memuat data:</strong>
                <pre style="white-space: pre-wrap; margin: 5px 0 0;"><?= esc($error) ?></pre>
            </div>
        <?php endif; ?>

        <?php if (!empty($suppressedCount) && $suppressedCount > 0): ?>
            <div class="alert alert-warning">
                ⚠️ <strong><?= $suppressedCount ?></strong> data disembunyikan oleh SATUSEHAT karena aturan privasi.
            </div>
        <?php endif; ?>

        <?php if (empty($reports)): ?>
            <div class="empty">
                <p>📭 Belum ada data Laporan Pemeriksaan<?= !empty($patientId) ? ' untuk Patient <strong>' . esc($patientId) . '</strong>' : '' ?>.</p>
                <p>Klik <strong>+ Buat Laporan</strong> untuk membuat laporan baru.</p>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th style="width: 22%;">ID</th>
                        <th>Kode Laporan</th>
                        <th>Nama Laporan</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th style="width: 12%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reports as $entry): ?>
                        <?php
                        $r = $entry['resource'] ?? [];
                        $id = $r['id'] ?? '';
                        $code = $r['code']['coding'][0]['code'] ?? '-';
                        $display = $r['code']['coding'][0]['display'] ?? '-';
                        $status = $r['status'] ?? '-';
                        $effective = $r['effectiveDateTime'] ?? '-';
                        $badgeCls = 'badge-' . str_replace('_', '-', $status);
                        ?>
                        <tr>
                            <td class="id-cell" title="<?= esc($id) ?>"><?= esc($id) ?></td>
                            <td><span class="code-cell"><?= esc($code) ?></span></td>
                            <td><?= esc($display) ?></td>
                            <td><span class="badge <?= esc($badgeCls) ?>"><?= esc(ucfirst($status)) ?></span></td>
                            <td><small><?= esc(substr($effective, 0, 16)) ?></small></td>
                            <td>
                                <a href="<?= base_url('diagnostic-report/edit/' . $id) ?>" class="btn btn-warning btn-sm">✏️</a>
                                <a href="<?= base_url('diagnostic-report/debug/' . $id) ?>" class="btn btn-info btn-sm" target="_blank">🔍</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>

</html>