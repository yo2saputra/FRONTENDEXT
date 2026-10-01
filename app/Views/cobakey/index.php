<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Gudang</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables Bootstrap 5 -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">📦 Daftar Gudang</h2>

        <table id="warehouseTable" class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Kode Gudang</th>
                    <th>Nama Gudang</th>
                    <th>Lokasi</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <!-- jQuery & DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#warehouseTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '<?= base_url('cobakey/datatables') ?>',
                    type: 'POST',
                    contentType: 'application/json',
                    data: function(d) {
                        return JSON.stringify(d); // wajib agar ASP.NET Core bisa bind ke [FromBody]
                    }
                },
                columns: [{
                        data: 'warehouse_cd'
                    },
                    {
                        data: 'warehouse_nm'
                    },
                    {
                        data: 'lokasi'
                    },
                    {
                        data: 'warehouse_sta_id'
                    }
                ]
            });
        });
    </script>
</body>

</html>