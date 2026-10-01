<?= $this->extend('clinic/clinic_template'); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Distribusi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Distribusi</li>
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

                    <!-- error -->
                    <?php if (session()->has('errors')) : ?>
                        <div class="alert alert-warning alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <ul>
                                <?php foreach (session('errors') as $error) : ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    <?php endif ?>
                    <!-- end error -->

                    <!-- jquery validation -->
                    <div class="card card-outline card-info">

                        <?php $validation = \Config\Services::validation(); ?>

                        <!-- form start -->
                        <form action="/clinic/obat/update/<?= $distribusies['id'] ?>" id="quickForm" method="post" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="card-body">
                                <input type="hidden" name="fld_nm" value="<?= $distribusies['fld_nm'] ?>">
                                <input type="hidden" name="fld_valu" value="<?= $distribusies['fld_valu'] ?>">
                                <div class="mb-3 row">
                                    <label for="fld_nm" class="col-sm-2 col-form-label">Nama</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="fld_nm" name="fld_nm" value="<?= set_value('fld_nm') ? set_value('fld_nm') : $distribusies['fld_nm'] ?>">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="fld_valu" class="col-sm-2 col-form-label">Value</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="fld_valu" name="fld_valu" value="<?= set_value('fld_valu') ? set_value('fld_valu') : $distribusies['fld_valu'] ?>">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="fld_desc" class="col-sm-2 col-form-label">Desc</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="fld_desc" name="fld_desc" value="<?= set_value('fld_desc') ? set_value('fld_desc') : $distribusies['fld_desc'] ?>">
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>

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

<?= $this->endSection('content'); ?>