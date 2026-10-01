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

                    <!-- jquery validation -->
                    <div class="card card-outline card-info">

                        <div class="card-body">

                            <button type="button" class="btn btn-success btn-sm tomboltambah">
                                <i class="fa fa-plus-circle"></i> Tambah data
                            </button>
                            <br>
                            <br>

                            <div class="card-title">
                            </div>

                            <span id="viewdata"></span>


                        </div>

                        <!-- <div class="viewmodal" style="display: none;"></div>
                        <div class="editmodal" style="display: none;"></div> -->

                        <!-- Modal -->
                        <div class="modal fade" id="modaltambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Insert Data Pasien</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?= form_open('clinic/pasien/simpandata', ['class' => 'formtambahpasien']) ?>
                                    <?= csrf_field(); ?>
                                    <div class="modal-body">
                                        <div class="mb-3 row">
                                            <label for="" class="col-sm-2 col-form-label">Nama</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="nama" name="nama" autofocus>
                                                <span class="error invalid-feedback errorNama">
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="" class="col-sm-2 col-form-label">Value</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="value" name="value">
                                                <span class="error invalid-feedback errorValue">
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="" class="col-sm-2 col-form-label">Desc</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="desc" name="desc">
                                                <span id="exampleInputEmail1-error" class="error invalid-feedback errorDesc">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary btnsimpan">Simpan</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                    <?= form_close() ?>
                                </div>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="modaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Data Pasien</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?= form_open('clinic/pasien/updatedata', ['class' => 'formeditpasien']) ?>
                                    <?= csrf_field(); ?>
                                    <div class="modal-body">
                                        <div class="mb-3 row">
                                            <label for="" class="col-sm-2 col-form-label">Nama</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="nama" name="nama" value="">
                                                <span class="error invalid-feedback errorNama">
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="" class="col-sm-2 col-form-label">Value</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="value" name="value" value="">
                                                <span class="error invalid-feedback errorValue">
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="" class="col-sm-2 col-form-label">Desc</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="desc" name="desc" value="">
                                                <span id="exampleInputEmail1-error" class="error invalid-feedback errorDesc">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary btnsimpan">Simpan</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                    <?= form_close() ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->

                    <!-- <table id="example2" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Filed Name</th>
                                <th>Filed Value</th>
                                <th>Filed Description</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>fff</td>
                                <td>fff</td>
                                <td>ff</td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm tomboltambah">
                                        <i class="fas fa-tags"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm tomboltambah">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>

                        </tbody>
                    </table> -->

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


<!-- <script>
    function pasien() {
        $.ajax({
            method: "get",
            url: "<?= site_url('clinic/pasien/ambildata'); ?>",
            success: function(data) {
                $('#viewdata').html(data);
            }
        });
    }

    $(document).ready(function() {

        pasien();

        $('.tomboltambah').click(function(e) {
            e.preventDefault();
            $.ajax({
                //type: "post",
                url: "<?= site_url('clinic/pasien/formtambah') ?>",
                dataType: "json",
                success: function(response) {
                    $('.viewmodal').html(response.data).show();
                    $('#modaltambah').modal('show');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });
</script> -->

<?= $this->endSection('content'); ?>