<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Print Voucher</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: #f8f9fa;
            padding: 20px;
        }

        .voucher {
            background: #fff;
            border: 1px solid #dee2e6;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            flex-wrap: nowrap;
        }

        .qr-wrapper {
            width: 100px;
            flex-shrink: 0;
            display: flex;
            justify-content: center;
        }

        .voucher-content {
            margin-left: 20px;
            flex-grow: 1;
        }

        @media print {
            body {
                background: none;
                padding: 0;
            }

            .voucher {
                box-shadow: none;
                page-break-inside: avoid;
                break-inside: avoid;
                width: auto;
                /* Hindari layout 2 kolom */
                display: flex;
                /* Tetap gunakan layout fleksibel */
                margin-right: 0;
            }
        }
    </style>
</head>

<body>

    <div class="container" id="voucher-container">
        <?php foreach ($produk as $item): ?>
            <div class="voucher">
                <div class="qr-wrapper">
                    <div id="qrcode-<?= esc($item['serialNo']) ?>"></div>
                </div>
                <div class="voucher-content">
                    <h5 class="font-weight-bold">No: <?= esc($item['serialNo']) ?></h5>
                    <p>Expired: <strong><?= esc(date('d/m/Y', strtotime($item["expiredDate"]))) ?></strong></p>
                    <p>Jumlah: <strong><?= esc(number_format($item["amount"], 0, ",", ".")) ?></strong></p>
                </div>

            </div>
        <?php endforeach ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        <?php foreach ($produk as $item):
            $nomor = $item['serialNo'];
            $jumlah = $item['amount'];
            $tanggal = $item['expiredDate'];
            $qrText = "$nomor|$jumlah|$tanggal"; ?>
            new QRCode(document.getElementById("qrcode-<?= $nomor ?>"), {
                text: "<?= $qrText ?>",
                width: 100,
                height: 100,
                correctLevel: QRCode.CorrectLevel.H
            });
        <?php endforeach ?>
    </script>

    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
                setTimeout(() => window.close(), 1000);
            }, 500);
        };
    </script>
</body>

</html>