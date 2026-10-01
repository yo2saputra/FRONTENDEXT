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
                <!-- <th>No</th>
                <th>Patien No</th>
                <th>Full Name</th>
                <th>ID No</th>
                <th>Gender</th>
                <th>Address</th>
                <th>Mobile</th>
                <th>Birth Date</th>
                <th>Register Date</th> -->

                <th>No</th>
                <th>Patien No</th>
                <th>Nama Pasien</th>
                <th>No. Identitas Pasien</th>
                <th>Jenis Kelamin</th>
                <th>Alamat Lengkap</th>
                <th>No. Hp</th>
                <th>Tanggal Lahir</th>
                <th>Register Date</th>
            </tr>
        </thead>
        <tbody>
            <?= $n = 1; ?>
            <?php for ($a = 0; $a < count($produk); $a++) : ?>
                <tr>
                    <td scope="row"><?= $n++ ?></td>
                    <td><?= $produk[$a]['patient_no']; ?></td>
                    <td><?= $produk[$a]['fullname']; ?></td>
                    <td><?= $produk[$a]['id_no']; ?></td>
                    <td><?= $produk[$a]['gender']; ?></td>
                    <td><?= $produk[$a]['addr']; ?></td>
                    <td><?= $produk[$a]['mobile_no']; ?></td>
                    <td><?= date('d/m/Y', strtotime($produk[$a]['birth_dt'])); ?></td>
                    <td><?= date('d/m/Y', strtotime($produk[$a]['register_dt'])); ?></td>
                </tr>
            <?php endfor ?>
        </tbody>
    </table>
</body>

</html>