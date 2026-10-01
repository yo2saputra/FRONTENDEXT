<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Voucher Cetak 2 Kolom Konsisten</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: #f8f9fa;
            padding: 20px;
        }

        .voucher {
            background: #fff;
            border: 1px solid #ccc;
            padding: 12px;
            display: flex;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .qr-wrapper {
            width: 80px;
            flex-shrink: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .voucher-content {
            margin-left: 15px;
        }

        /* ✅ Override saat print untuk tetap 2 kolom */
        @media print {

            body,
            html {
                margin: 0 !important;
                padding: 0 !important;
            }

            .container {
                width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .row {
                display: block !important;
                margin: 0 !important;
            }

            .col-md-6 {
                display: inline-block !important;
                width: 48% !important;
                margin: 1% !important;
                vertical-align: top !important;
            }

            .voucher {
                page-break-inside: avoid !important;
                box-shadow: none !important;
                border: 1px solid #999 !important;
            }
        }
    </style>
</head>

<body>

    <div class="container" id="voucher-container"></div>

    <!-- QRCode Generator -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        const container = document.getElementById("voucher-container");

        for (let i = 1; i <= 20; i += 2) {
            const row = document.createElement("div");
            row.className = "row";

            for (let j = 0; j < 2 && (i + j) <= 20; j++) {
                const nomor = `VCH${String(i + j).padStart(5, '0')}`;
                const qrId = `qr-${nomor}`;

                const col = document.createElement("div");
                col.className = "col-md-6";
                col.innerHTML = `
        <div class="voucher">
          <div class="qr-wrapper"><div id="${qrId}"></div></div>
          <div class="voucher-content">
            <h5>No: ${nomor}</h5>
            <p>Expired: <strong>04 Agustus 2025</strong></p>
            <p>Jumlah: <strong>Rp 500.000</strong></p>
          </div>
        </div>
      `;
                row.appendChild(col);

                setTimeout(() => {
                    new QRCode(document.getElementById(qrId), {
                        text: `${nomor}|Rp 500.000|04 Agustus 2025`,
                        width: 80,
                        height: 80
                    });
                }, 10);
            }

            container.appendChild(row);
        }
    </script>

</body>

</html>