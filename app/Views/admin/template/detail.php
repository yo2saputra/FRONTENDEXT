<?= $this->extend('admin/admin_template'); ?>

<?= $this->section('content'); ?>

<?php $session = session() ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Template</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Template</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>


    <?php if ($session->get('role') == 1) : ?>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">

                        <div class="card card-outline card-info">
                            <div class="card-body">
                                <form action="/admin/mitra/update/<?= $templates['id'] ?>" id="quickForm" method="post" enctype="multipart/form-data">
                                    <?= csrf_field(); ?>

                                    <input type="hidden" name="id" value="<?= $templates['id'] ?>">
                                    <input type="hidden" name="faviconLama" value="<?= $templates['favicon'] ?>">
                                    <input type="hidden" name="logoLama" value="<?= $templates['logo'] ?>">
                                    <input type="hidden" name="logoMobileLama" value="<?= $templates['logoMobile'] ?>">

                                    <div class="mb-3 row">
                                        <label for="" class="col-sm-2 col-form-label"></label>
                                        <div class="col-sm-10">
                                            <div class="mb-3 row">
                                                <div class="col-sm-6">
                                                    <!-- text input -->
                                                    <div class="form-group">
                                                        <label class="col-sm-4">Logo</label>
                                                        <div class="col-sm-8 text-center">
                                                            <img src="<?= base_url('/assets/img/') . $templates['logo'] ?>" alt="" style="height:100px;" class="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-sm-4">Logo Mobile</label>
                                                        <div class="col-sm-8 text-center">
                                                            <img src="<?= base_url('/assets/img/') . $templates['logoMobile'] ?>" alt="" style="height:100px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="" class="col-sm-2 col-form-label">Favicon</label>
                                        <div class="col-sm-10">
                                            <div class="col-sm-8">
                                                <img src="<?= base_url('/assets/img/') . $templates['favicon'] ?>" alt="favicon" style="height:50px;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="linkFacebook" class="col-sm-2 col-form-label">Link Facebook</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="linkFacebook" name="linkFacebook" value="<?= $templates['linkFacebook'] ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="linkTwitter" class="col-sm-2 col-form-label">Link Twitter</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="linkTwitter" name="linkTwitter" value="<?= $templates['linkTwitter'] ?>" disabled>

                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="linkInstagram" class="col-sm-2 col-form-label">Link Instagram</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="linkInstagram" name="linkInstagram" value="<?= $templates['linkInstagram'] ?>" disabled>

                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="linkLinkedin" class="col-sm-2 col-form-label">Link Linkedin</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="linkLinkedin" name="linkLinkedin" value="<?= $templates['linkLinkedin'] ?>" disabled>

                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="textCopyright" class="col-sm-2 col-form-label">Text Copyright</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control summernote summernote-disable" id="textCopyright" rows="3" name="textCopyright" disabled><?= set_value('textCopyright') ? set_value('textCopyright') : $templates['textCopyright'] ?>
                                    </textarea>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="warna" class="col-sm-2 col-form-label">Warna</label>
                                        <div class="col-sm-2">
                                            <label for="color4" class="form-label">LINK NAVBAR</label>
                                            <input type="color" class="form-control form-control-color" id="color4" value="<?= $templates['color4'] ?>" title="Choose your color" name="color4" disabled>
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="color1" class="form-label">NAV, COPYRIGHT</label>
                                            <input type="color" class="form-control form-control-color" id="color1" value="<?= $templates['color1'] ?>" title="Choose your color" name="color1" disabled>
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="color2" class="form-label">BTN, LINK</label>
                                            <input type="color" class="form-control form-control-color" id="color2" value="<?= $templates['color2'] ?>" title="Choose your color" name="color2" disabled>
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="color3" class="form-label">FOOTER</label>
                                            <input type="color" class="form-control form-control-color" id="color3" value="<?= $templates['color3'] ?>" title="Choose your color" name="color3" disabled>
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="color5" class="form-label">PLAY BTN</label>
                                            <input type="color" class="form-control form-control-color" id="color5" value="<?= $templates['color5'] ?>" title="Choose your color" name="color5" disabled>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="" class="col-sm-2 col-form-label"></label>
                                        <div class="col-sm-2">
                                            <label for="color6" class="form-label">BG BODY</label>
                                            <input type="color" class="form-control form-control-color" id="color6" value="<?= $templates['color6'] ?>" title="Choose your color" name="color6" disabled>
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="color7" class="form-label">BG CARD</label>
                                            <input type="color" class="form-control form-control-color" id="color7" value="<?= $templates['color7'] ?>" title="Choose your color" name="color7" disabled>
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="color10" class="form-label">HOV BTN</label>
                                            <input type="color" class="form-control form-control-color" id="color10" value="<?= $templates['color10'] ?>" title="Choose your color" name="color10" disabled>
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="color11" class="form-label">TITLE</label>
                                            <input type="color" class="form-control form-control-color" id="color11" value="<?= $templates['color11'] ?>" title="Choose your color" name="color11" disabled>
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="color12" class="form-label">BTN CAROUSEL</label>
                                            <input type="color" class="form-control form-control-color" id="color12" value="<?= $templates['color12'] ?>" title="Choose your color" name="color12" disabled>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="" class="col-sm-2 col-form-label"></label>
                                        <div class="col-sm-2">
                                            <label for="color13" class="form-label">TEXT FOOTER</label>
                                            <input type="color" class="form-control form-control-color" id="color13" value="<?= $templates['color13'] ?>" title="Choose your color" name="color13" disabled>
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="color14" class="form-label">PAGINATION</label>
                                            <input type="color" class="form-control form-control-color" id="color14" value="<?= $templates['color14'] ?>" title="Choose your color" name="color14" disabled>
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="color15" class="form-label">TITLE FOOTER</label>
                                            <input type="color" class="form-control form-control-color" id="color15" value="<?= $templates['color15'] ?>" title="Choose your color" name="color15" disabled>
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="color16" class="form-label">MOBILE NAV</label>
                                            <input type="color" class="form-control form-control-color" id="color16" value="<?= $templates['color16'] ?>" title="Choose your color" name="color16" disabled>
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="color17" class="form-label">TEXT COPYRIGHT</label>
                                            <input type="color" class="form-control form-control-color" id="color17" value="<?= $templates['color17'] ?>" title="Choose your color" name="color17" disabled>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="" class="col-sm-2 col-form-label"></label>
                                        <div class="col-sm-2">
                                            <label for="color18" class="form-label">LINK COPYRIGHT</label>
                                            <input type="color" class="form-control form-control-color" id="color18" value="<?= $templates['color18'] ?>" title="Choose your color" name="color18" disabled>
                                        </div>
                                        <div class="col-sm-2" style="display: none;">
                                            <label for="color19" class="form-label"></label>
                                            <input type="color" class="form-control form-control-color" id="color19" value="<?= $templates['color19'] ?>" title="Choose your color" name="color19" disabled>
                                        </div>
                                        <div class="col-sm-2" style="display: none;">
                                            <label for="color20" class="form-label"></label>
                                            <input type="color" class="form-control form-control-color" id="color20" value="<?= $templates['color20'] ?>" title="Choose your color" name="color20" disabled>
                                        </div>
                                        <div class="col-sm-2" style="display: none;">
                                            <label for="color21" class="form-label"></label>
                                            <input type="color" class="form-control form-control-color" id="color21" value="<?= $templates['color21'] ?>" title="Choose your color" name="color21" disabled>
                                        </div>
                                        <div class="col-sm-2" style="display: none;">
                                            <label for="color22" class="form-label"></label>
                                            <input type="color" class="form-control form-control-color" id="color22" value="<?= $templates['color22'] ?>" title="Choose your color" name="color22" disabled>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="labelDisc" class="col-sm-2 col-form-label">Label Disc</label>
                                        <div class="col-sm-2">
                                            <label for="color8" class="form-label">Warna 1</label>
                                            <input type="color" class="form-control form-control-color" id="color8" value="<?= $templates['color8'] ?>" title="Choose your color" name="color8" disabled>
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="color9" class="form-label">Warna 2</label>
                                            <input type="color" class="form-control form-control-color" id="color9" value="<?= $templates['color9'] ?>" title="Choose your color" name="color9" disabled>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <a href="<?= base_url('/admin/template/edit/') . $templates['id'] ?>" class="btn btn-primary">Edit</a>
                            </div>
                        </div>
                        <!--/.col (left) -->
                        <!-- right column -->
                        <div class="col-md-6">

                        </div>
                        <!--/.col (right) -->
                    </div>
                    <!-- /.card -->

                </div>
            </div>
            <!-- /.row -->
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->

    <?php endif ?>

</div>
<!-- /.content-wrapper -->

<?= $this->endSection('content'); ?>