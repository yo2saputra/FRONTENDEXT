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
                        <li class="breadcrumb-item active">Obat</li>
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
                        <div class="card-header">
                            <h3 class="card-title"></h3>
                        </div>

                        <!-- /.card-header -->
                        <?php $validation = \Config\Services::validation(); ?>
                        <!-- form start -->
                        <form action="/clinic/obat/save" id="quickForm" method="post">
                            <?= csrf_field(); ?>
                            <div class="card-body">
                                <div class="mb-3 row">
                                    <label for="fld_nm" class="col-sm-2 col-form-label">Nama</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control <?= ($validation->getError('fld_nm') ? 'is-invalid' : '') ?>" id="fld_nm" name="fld_nm" value="<?= set_value('fld_nm'); ?>" autofocus>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="fld_valu" class="col-sm-2 col-form-label">Value</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control <?= ($validation->getError('fld_valu') ? 'is-invalid' : '') ?>" id="fld_valu" name="fld_valu" value="<?= set_value('fld_valu'); ?>" autofocus>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="fld_desc" class="col-sm-2 col-form-label">Desc</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control <?= ($validation->getError('fld_desc') ? 'is-invalid' : '') ?>" id="fld_desc" name="fld_desc" value="<?= set_value('fld_desc'); ?>" autofocus>
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