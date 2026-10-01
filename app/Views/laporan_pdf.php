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
    </style>
</head>

<body>
    <div style="text-align:center">
        <h3><?= $title_pdf; ?></h3>
    </div>
    <table id="table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Field Nama</th>
                <th>Field Value</th>
                <th>Field Description</th>
            </tr>
        </thead>
        <tbody>
            <?= $n = 1; ?>
            <?php for ($a = 0; $a < count($produk); $a++) : ?>
                <tr>
                    <td scope="row"><?= $n++ ?></td>
                    <td><?= $produk[$a]['fld_nm']; ?></td>
                    <td><?= $produk[$a]['fld_valu']; ?></td>
                    <td><?= $produk[$a]['fld_desc']; ?></td>
                </tr>
            <?php endfor ?>
        </tbody>
    </table>
    <br>
    <div style="text-align:center">
        <h3><?= $title_pdf; ?></h3>
    </div>
    <table id="table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Field Nama</th>
                <th>Field Value</th>
                <th>Field Description</th>
            </tr>
        </thead>
        <tbody>
            <?= $n = 1; ?>
            <?php for ($a = 0; $a < count($produk); $a++) : ?>
                <tr>
                    <td scope="row"><?= $n++ ?></td>
                    <td><?= $produk[$a]['fld_nm']; ?></td>
                    <td><?= $produk[$a]['fld_valu']; ?></td>
                    <td><?= $produk[$a]['fld_desc']; ?></td>
                </tr>
            <?php endfor ?>
        </tbody>
    </table>
</body>

</html>