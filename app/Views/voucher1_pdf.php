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
            align-items: flex-start;
            flex-wrap: nowrap;
        }

        .qr-wrapper {
            width: 100px;
            flex-shrink: 0;
            display: flex;
            justify-content: center;
        }

        .voucher-main {
            display: flex;
            flex-grow: 1;
            margin-left: 20px;
        }

        /* .voucher-content {
            flex: 1;
        } */

        .voucher-remark {
            flex-shrink: 0;
            padding-left: 15px;
            font-size: 0.9rem;
            color: #555;
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
                display: flex;
            }

            @page {
                margin: 10mm;
            }

            .voucher-remark {
                max-width: none;
            }
        }
    </style>
</head>

<body>

    <div class="container" id="voucher-container">
        <?php foreach ($produk as $item): ?>
            <div class="voucher">
                <div class="qr-wrapper">
                    <input id="id" type="hidden" value="<?= $item['voucherID'] ?>" />
                    <div id="qrcode-<?= esc($item['serialNo']) ?>" aria-label="QR voucher <?= esc($item['serialNo']) ?>"></div>
                </div>
                <div class="voucher-main">
                    <div class="voucher-content">
                        <h5 class="font-weight-bold">No: <?= esc($item['serialNo']) ?></h5>
                        <p>Expired: <strong><?= esc(date('d/m/Y', strtotime($item["expiredDate"]))) ?></strong></p>
                        <p>Jumlah: <strong><?= esc(number_format($item["amount"], 0, ",", ".")) ?></strong></p>
                    </div>
                    <div class="voucher-remark">
                        <p><strong></strong> <?= esc($item['remarks1'] ?? '-') ?></p>
                        <p><strong></strong> <?= esc($item['remarks2'] ?? '-') ?></p>
                    </div>
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
            $qrText = "$nomor"; ?>
            new QRCode(document.getElementById("qrcode-<?= $nomor ?>"), {
                text: "<?= $qrText ?>",
                width: 100,
                height: 100,
                correctLevel: QRCode.CorrectLevel.H
            });
        <?php endforeach ?>
    </script>

    <script>
        // window.onload = function() {
        //     setTimeout(function() {
        //         window.print();
        //         setTimeout(() => window.close(), 1000);
        //     }, 500);
        // };

        window.onload = function() {
            setTimeout(() => {
                window.print();
            }, 500);

            window.onafterprint = function() {
                fetch('/track-print', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        printed: true,
                        timestamp: Date.now()
                    })
                });
                // setTimeout(() => window.close(), 1000);
            };

            window.onafterprint = function() {
                // Kirim tracking ke backend via jQuery AJAX
                var id = $('id').val();
                alert(id);
                $.ajax({
                    url: '/track-print',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        printed: true,
                        timestamp: Date.now()
                    }),
                    success: function(res) {
                        console.log('Tracking berhasil:', res);
                    },
                    error: function(xhr, status, err) {
                        console.error('Tracking gagal:', err);
                    },
                    complete: function() {
                        // Tutup window setelah tracking selesai
                        setTimeout(() => {
                            window.close();
                        }, 1000);
                    }
                });
            };

        };
    </script>
</body>

</html>