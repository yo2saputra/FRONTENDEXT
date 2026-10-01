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

        td {
            vertical-align: top
        }

        .trbt {
            border-bottom: 1pt solid black;
        }

        .tdbreak {
            word-break: break-all
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

<?php

$session = session();

function terbilang($x)
{
    $angka = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];

    if ($x < 12)
        return " " . $angka[$x];
    elseif ($x < 20)
        return terbilang($x - 10) . " belas";
    elseif ($x < 100)
        return terbilang($x / 10) . " puluh" . terbilang($x % 10);
    elseif ($x < 200)
        return "seratus" . terbilang($x - 100);
    elseif ($x < 1000)
        return terbilang($x / 100) . " ratus" . terbilang($x % 100);
    elseif ($x < 2000)
        return "seribu" . terbilang($x - 1000);
    elseif ($x < 1000000)
        return terbilang($x / 1000) . " ribu" . terbilang($x % 1000);
    elseif ($x < 1000000000)
        return terbilang($x / 1000000) . " juta" . terbilang($x % 1000000);
}

// function convert_date($date)
// {
//     $dateTime = DateTime::createFromFormat('n/j/Y h:i:s A', $date);
//     $formattedDate = $dateTime->format('j M Y H:i:s');
//     return $formattedDate;
// }

function convert_date($date)
{
    $dateTime = DateTime::createFromFormat('d/m/Y H:i:s', $date);
    if (!$dateTime) {
        return 'Invalid date';
    }
    return $dateTime->format('j M Y');
}

?>

<body>
    <table class="tableheader">
        <tr>
            <td>MedicElle Clinic <br>Jl. Raya Gubeng No.11 <br>Surabaya (ID) <br>info@medicelle.co.id | 08990118008</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="tright"><img src="<?= base_url(); ?>assets/login/logo_medicelle_nobg_1.png" class="" style="width: 150px;"></td>
        </tr>
    </table>

    <div style="text-align:center">
        <h3><?= $title_pdf; ?></h3>
    </div>
    <hr>

    <table class="tableheader" style="width:100%">
        <tr>
            <td width="20%">Kwitansi #</td>
            <td width="30%"><?= $produk[0]['no_kwitansi']; ?></td>
            <td width="20%">No. bayar #</td>
            <td width="30%"></td>
        </tr>
        <tr>
            <td>Dibayar oleh</td>
            <td><?= strtoupper($produk[0]['fullname']); ?></td>
            <td>Pasien</td>
            <td><?= strtoupper($produk[0]['fullname']); ?></td>
        </tr>
        <tr>
            <td>Alamat pasien</td>
            <td><?= ucwords($produk[0]['addr']); ?></td>
            <td>Nomor rekam medis</td>
            <td><?= $produk[0]['medrec_id']; ?></td>
        </tr>
        <tr>
            <td>Tipe kunjungan</td>
            <td><?= ucwords($produk[0]['tipe_kunjungan']); ?></td>
            <td>Dokter admisi</td>
            <td><?= $produk[0]['nama_dokter']; ?></td>
        </tr>
        <tr>
            <td>Dicetak pada/oleh</td>
            <td colspan="3"><?= date("d M Y H:i:s"); ?>, <?= ucwords($session->get('usr_id')); ?>.</td>
        </tr>
    </table>

    <br>
    <table id="table">
        <thead>
            <tr>
                <!-- <th>No</th>
                <th>Kode</th> -->
                <th>Produk</th>
                <th class="tright">Harga</th>
                <th>Qty</th>
                <th>Diskon</th>
                <th>Pajak</th>
                <th class="tright">Total Pasien</th>
            </tr>
        </thead>
        <tbody>
            <?php $sumDiskon = 0; ?>
            <?= $n = 1; ?>
            <?php for ($a = 0; $a < count($produk); $a++) : ?>
                <?php $diskon = 0; ?>
                <tr>
                    <!-- <td scope="row"><?= $n++ ?></td>
                    <td><?= $produk[$a]['item_cd']; ?></td> -->
                    <td><?= $produk[$a]['item_nm']; ?></td>
                    <td class="tright">Rp <?= number_format(floatval($produk[$a]['tarif']), 2, ",", "."); ?></td>
                    <td><?= number_format(floatval($produk[$a]['jumlah'])); ?></td>
                    <td><?= number_format(floatval($produk[$a]['potongan'])); ?></td>
                    <td><?= number_format(floatval($produk[$a]['pajak'])); ?></td>
                    <td class="tright">Rp <?= number_format(floatval($produk[$a]['total']), 2, ",", "."); ?></td>
                </tr>
                <?php //$diskon = intval($produk[$a]['tarif']) * intval($produk[$a]['pajak']) / 100; 
                ?>
                <?php $diskon = intval($produk[$a]['potongan']); ?>
                <?php $sumDiskon += $diskon; ?>
            <?php endfor ?>
            <!-- <tr>
                <td colspan="4">GRAND TOTAL :</td>
                <td class="tright"><?= number_format($produk[0]['tagihan'], 2, ",", "."); ?></td>
            </tr> -->

        </tbody>
    </table>
    <hr>
    <?php
    $riwayatBayar = $produk[0]['riwayat_pembayaran'] ?? [];
    $depositRows  = array_filter($riwayatBayar, function ($r) {
        return !empty($r['isFromDeposit']);
    });
    $metodeRows   = array_filter($riwayatBayar, function ($r) {
        return empty($r['isFromDeposit']);
    });
    $totalDeposit = array_sum(array_column($depositRows, 'nominal'));
    ?>
    <table class="tableheader">
        <tr>
            <td colspan="4"><b>Dibayar dari deposit</b></td>

        </tr>
        <tr class="trbt">
            <td width="15%"></td>
            <td width="20%">Nilai terbayar</td>
            <td width="1%">:</td>
            <td width="64%">Rp <?= number_format($totalDeposit, 2, ",", "."); ?></td>
        </tr>
        <tr>
            <td colspan="4"><b>Pembayaran</b></td>

        </tr>
        <?php if (count($metodeRows)) : ?>
            <?php foreach ($metodeRows as $r) : ?>
                <tr>
                    <td></td>
                    <td>
                        <?= esc($r['metode'] ?? '-'); ?><?php if (!empty($r['isAr'])) : ?> (Piutang/AR)<?php elseif (!empty($r['isAsuransi'])) : ?> (Asuransi)<?php endif; ?><?php if (!empty($r['voucherId'])) : ?> - <?= esc($r['voucherId']); ?><?php endif; ?><?php if (!empty($r['referenceNo'])) : ?> (Ref: <?= esc($r['referenceNo']); ?>)<?php endif; ?>
                    </td>
                    <td>:</td>
                    <td>Rp <?= number_format($r['nominal'], 2, ",", "."); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td></td>
                <td>Kartu Kredit/Debit:</td>
                <td>:</td>
                <td>Rp <?= number_format($produk[0]['tagihan'], 2, ",", "."); ?></td>
            </tr>
        <?php endif; ?>
        <tr>
            <td></td>
            <td>Nilai dibayar</td>
            <td>:</td>
            <td><?= ucwords(terbilang($produk[0]['tagihan'])); ?></td>
        </tr>
        <tr class="trbt">
            <td></td>
            <td>Nilai Diskon</td>
            <td>:</td>
            <td>Rp <?= number_format($sumDiskon, 2, ",", "."); ?></td>
        </tr>
        <tr>
            <td></td>
            <td>Tgl Dibuat</td>
            <td>:</td>
            <td><?= convert_date($produk[0]['tgl_kwitansi']); ?></td>
        </tr>
        <tr>
            <td></td>
            <td>Petugas Kasir</td>
            <td>:</td>
            <td><?= ucwords($produk[0]['emp_cd']); ?>.</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>_____________________</td>
        </tr>
        <tr class="trbt">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>

        <tr>
            <td colspan="4">
                <center><b>MedicElle Clinic</b></center>
            </td>
        </tr>
    </table>

    <table class="tableheader">

    </table>
</body>

</html>