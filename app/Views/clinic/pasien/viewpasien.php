<?= $this->extend('clinic/clinic_template'); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Beranda</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Beranda</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">


            <div class="row">
                <!-- left column -->
                <div class="col-md-12">

                    <?php if (session()->getFlashdata('pesan')) : ?>
                        <div class="alert alert-success alert-close" role="alert">
                            <?= session()->getFlashdata('pesan') ?>
                        </div>
                    <?php endif ?>
                    <!-- jquery validation -->
                    <div class="card card-outline card-info">

                        <div class="card-body">

                            <button type="button" class="btn btn-success btn-sm tomboltambah">
                                <i class="fa fa-plus-circle"></i> Tambah data
                            </button>

                            <div class="card-title">
                            </div>

                            <table id="example2" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Filed Name</th>
                                        <th>Filed Value</th>
                                        <th>Filed Description</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($a = 0; $a < count($produk); $a++) : ?>
                                        <tr>
                                            <td><?= $produk[$a]['fld_nm']; ?></td>
                                            <td><?= $produk[$a]['fld_valu']; ?></td>
                                            <td><?= $produk[$a]['fld_desc']; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm tomboltambah">
                                                    <i class="fas fa-note"></i> Edit
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm tomboltambah">
                                                    <i class="fas fa-dumb"></i> Delete
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endfor ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="viewmodal" style="display: none;"></div>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
                <!-- right column -->
                <div class="col-md-6">

                </div>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<script>
    // function pasien() {
    //     $.ajax({
    //         url: "<?= site_url('clinic/pasien/ambildata') ?>",
    //         dataType: "json",
    //         success: function(response) {
    //             $('.viewdata').html(response.data);
    //         },
    //         error: function(xhr, ajaxOptions, thrownError) {
    //             alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
    //         }
    //     });
    // }

    $(document).ready(function() {
        // pasien();
        // $('.tomboltambah').click(function(e) {
        //     e.preventDefault();
        //     $.ajax({
        //         url: "<?= site_url('clinic/pasien/formtambah') ?>",
        //         dataType: "json",
        //         success: function(response) {
        //             $('.viewmodal').html(response.data).show();
        //             $('#modaltambah').modal('show');
        //         },
        //         error: function(xhr, ajaxOptions, thrownError) {
        //             alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        //         }
        //     });
        // });
        $("#example2").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example1').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>

<?= $this->endSection('content'); ?>

<!-- <?= $this->extend('layout/menu') ?> -->