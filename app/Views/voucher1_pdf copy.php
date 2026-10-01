<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Preview Voucher</title>
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
            }
        }
    </style>
</head>

<body>

    <div class="container" id="voucher-container"></div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        const container = document.getElementById("voucher-container");


        for (let i = 1; i <= 20; i++) {
            const nomor = `VCH${String(i).padStart(5, '0')}`;
            const tanggal = "04 Agustus 2025";
            const jumlah = "Rp 500.000";

            const voucherHTML = `
            <div class="voucher">
                <div class="qr-wrapper">
                <div id="qrcode-${nomor}"></div>
                </div>
                <div class="voucher-content">
                <h5 class="font-weight-bold">No: ${nomor}</h5>
                <p>Expired: <strong>${tanggal}</strong></p>
                <p>Jumlah: <strong>${jumlah}</strong></p>
                </div>
            </div>
            `;

            container.insertAdjacentHTML("beforeend", voucherHTML);

            new QRCode(document.getElementById(`qrcode-${nomor}`), {
                text: `${nomor}|${jumlah}|${tanggal}`,
                width: 100,
                height: 100,
                correctLevel: QRCode.CorrectLevel.H
            });
        }
    </script>

    <script>
        window.onload = function() {
            window.print();

            // Tunggu sebentar sebelum tab ditutup (pastikan proses print tidak terganggu)
            setTimeout(function() {
                window.close();
            }, 1000); // Delay 1 detik
        };
    </script>

</body>

</html>