<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title_pdf; ?></title>
    <style>
        #table {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            font-size: 0.70rem;
        }

        #table td,
        #table th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #table tr:hover {
            background-color: #ddd;
        }

        #table th {
            padding-top: 10px;
            padding-bottom: 10px;
            text-align: left;
            background-color: #4CAF50;
            color: white;
        }

        #table .tr {
            text-align: right;
        }
    </style>
</head>

<?php
$session = session();
?>

<body>
    <div style="text-align:center">
        <h3><?= $title_pdf; ?></h3>
    </div>
    <table>
        <tr>
            <td>Dokter</td>
            <td>:</td>
            <td><?= $session->get('dokter_hd'); ?></td>
        </tr>
        <tr>
            <td>Periode</td>
            <td>:</td>
            <td><?= date('d/m/Y', strtotime($session->get('tgl1'))); ?> s/d <?= date('d/m/Y', strtotime($session->get('tgl2'))); ?></td>
        </tr>
    </table>
    <table id="table">
        <thead>
            <tr>
                <th>No</th>
                <th>No. REG</th>
                <th>No. MEDREC</th>
                <th>Nama Pasien</th>
                <th>Tgl Registrasi</th>
                <th>Via</th>
                <th>Tujuan</th>
                <th>Nama Dokter</th>
                <th>Tgl Praktek</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($produk) : ?>
                <?= $n = 1; ?>
                <?php for ($a = 0; $a < count($produk); $a++) : ?>
                    <tr>
                        <td scope="row"><?= $n++ ?></td>
                        <td><?= $produk[$a]['no_registrasi']; ?></td>
                        <td><?= $produk[$a]['no_pasien']; ?></td>
                        <td><?= $produk[$a]['fullname']; ?></td>
                        <td><?= date('d/m/Y', strtotime($produk[$a]['tgl_registrasi'])); ?></td>
                        <td><?= $produk[$a]['registrasi_via']; ?></td>
                        <td><?= $produk[$a]['poly_nm']; ?></td>
                        <td><?= $produk[$a]['nm_dokter']; ?></td>
                        <td><?= date('d/m/Y', strtotime($produk[$a]['tgl_praktek'])); ?></td>
                    </tr>
                <?php endfor ?>
            <?php else : ?>
                <tr>
                    <td scope="row"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            <?php endif ?>
        </tbody>
    </table>
</body>

</html>