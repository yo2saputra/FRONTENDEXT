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

        .tableheader {
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

        .tcenter {
            text-align: center;
        }

        .tleft {
            text-align: left;
        }

        #table .tright {
            text-align: right;
        }

        .tableheader .tright {
            text-align: right;
        }
    </style>
</head>

<body>
    <table class="tableheader">
        <tr>
            <td>Medic Elle CLinic <br>Jl. Raya Gubeng No.11 <br>Surabaya (ID) <br>info@medicelle.co.id | 08990118008</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="tright"><img src="https://clinictest.deltafood.co.id/assets/login/logo_medicelle_nobg_1.png" class="" style="width: 220px;"></td>
        </tr>
    </table>

    <div style="text-align:center">
        <h3><?= $title_pdf; ?></h3>
    </div>
    <hr>

    <table class="tableheader">
        <tr>
            <td>NO KWITANSI</td>
            <td>:</td>
            <td><?= $produk[0]['no_kwitansi']; ?></td>
            <td>NO REGISTRASI</td>
            <td>:</td>
            <td><?= $produk[0]['no_registrasi']; ?></td>
        </tr>
        <tr>
            <td>TGL</td>
            <td>:</td>
            <td><?= $produk[0]['tgl_kwitansi']; ?></td>
            <td>PETUGAS</td>
            <td>:</td>
            <td><?= $produk[0]['emp_cd']; ?></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
    <br>
    <table id="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Item</th>
                <th>Jumlah</th>
                <th>Potongan</th>
                <th class="tright">Tarif</th>
                <th class="tright">Total</th>
            </tr>
        </thead>
        <tbody>
            <?= $n = 1; ?>
            <?php for ($a = 0; $a < count($produk); $a++) : ?>
                <tr>
                    <td scope="row"><?= $n++ ?></td>
                    <td><?= $produk[$a]['item_cd']; ?></td>
                    <td><?= $produk[$a]['item_nm']; ?></td>
                    <td><?= $produk[$a]['jumlah']; ?></td>
                    <td><?= $produk[$a]['potongan']; ?></td>
                    <td class="tright"><?= $produk[$a]['tarif']; ?></td>
                    <td class="tright"><?= $produk[$a]['total']; ?></td>
                </tr>
            <?php endfor ?>
            <tr>
                <td colspan="6">GRAND TOTAL :</td>
                <td class="tright"><?= number_format($produk[0]['tagihan'], 2, ",", "."); ?></td>
            </tr>
        </tbody>
    </table>
</body>

</html>