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
                        <!-- jquery validation -->
                        <div class="card card-outline card-info">

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

                            <?php $validation = \Config\Services::validation(); ?>
                            <!-- form start -->
                            <form action="/admin/template/update/<?= $templates['id'] ?>" id="quickForm" method="post" enctype="multipart/form-data">
                                <div class="card-body">

                                    <?= csrf_field(); ?>

                                    <input type="hidden" name="id" value="<?= $templates['id'] ?>">
                                    <input type="hidden" name="logoLama" value="<?= $templates['logo'] ?>">
                                    <input type="hidden" name="logoMobileLama" value="<?= $templates['logoMobile'] ?>">
                                    <input type="hidden" name="faviconLama" value="<?= $templates['favicon'] ?>">

                                    <div class="mb-3 row">
                                        <label for="" class="col-sm-2 col-form-label">Logo</label>
                                        <div class="col-sm-10">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="customFile" name="logo">
                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="" class="col-sm-2 col-form-label">Logo Mobile</label>
                                        <div class="col-sm-10">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="customFile" name="logoMobile">
                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="" class="col-sm-2 col-form-label">Favicon</label>
                                        <div class="col-sm-10">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="favicon" name="favicon">
                                                <label class="custom-file-label" for="favicon">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="linkFacebook" class="col-sm-2 col-form-label">Link Facebook</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="linkFacebook" name="linkFacebook" value="<?= set_value('linkFacebook') ? set_value('linkFacebook') : $templates['linkFacebook'] ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="linkTwitter" class="col-sm-2 col-form-label">Link Twitter</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="linkTwitter" name="linkTwitter" value="<?= set_value('linkTwitter') ? set_value('linkTwitter') : $templates['linkTwitter'] ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="linkInstagram" class="col-sm-2 col-form-label">Link Instagram</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="linkInstagram" name="linkInstagram" value="<?= set_value('linkInstagram') ? set_value('linkInstagram') : $templates['linkInstagram'] ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="linkLinkedin" class="col-sm-2 col-form-label">Link Linkedin</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="linkLinkedin" name="linkLinkedin" value="<?= set_value('linkLinkedin') ? set_value('linkLinkedin') : $templates['linkLinkedin'] ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="textCopyright" class="col-sm-2 col-form-label">Text Copyright</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control summernote" id="textCopyright" rows="3" name="textCopyright"><?= set_value('textCopyright') ? set_value('textCopyright') : $templates['textCopyright'] ?>
                                    </textarea>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="warna" class="col-sm-2 col-form-label">Warna</label>
                                        <div class="col-sm-2">
                                            <label for="color4" class="form-label">LINK NAVBAR</label>
                                            <input type="color" class="form-control form-control-color" id="color4" value="<?= set_value('color4') ? set_value('color4') : $templates['color4'] ?>" title="Choose your color" name="color4">
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="color1" class="form-label">NAV, COPYRIGHT</label>
                                            <input type="color" class="form-control form-control-color" id="color1" value="<?= set_value('color1') ? set_value('color1') : $templates['color1'] ?>" title="Choose your color" name="color1">
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="color2" class="form-label">BTN,LINK</label>
                                            <input type="color" class="form-control form-control-color" id="color2" value="<?= set_value('color2') ? set_value('color2') : $templates['color2'] ?>" title="Choose your color" name="color2">
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="color3" class="form-label">FOOTER</label>
                                            <input type="color" class="form-control form-control-color" id="color3" value="<?= set_value('color3') ? set_value('color3') : $templates['color3'] ?>" title="Choose your color" name="color3">
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="color5" class="form-label">PLAY BTN</label>
                                            <input type="color" class="form-control form-control-color" id="color5" value="<?= set_value('color5') ? set_value('color5') : $templates['color5'] ?>" title="Choose your color" name="color5">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="" class="col-sm-2 col-form-label"></label>
                                        <div class="col-sm-2">
                                            <label for="color6" class="form-label">BG BODY</label>
                                            <input type="color" class="form-control form-control-color" id="color6" value="<?= set_value('color6') ? set_value('color6') : $templates['color6'] ?>" title="Choose your color" name="color6">
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="color7" class="form-label">BG CARD</label>
                                            <input type="color" class="form-control form-control-color" id="color7" value="<?= set_value('color7') ? set_value('color7') : $templates['color7'] ?>" title="Choose your color" name="color7">
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="color10" class="form-label">HOV BTN</label>
                                            <input type="color" class="form-control form-control-color" id="color10" value="<?= set_value('color10') ? set_value('color10') : $templates['color10'] ?>" title="Choose your color" name="color10">
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="color11" class="form-label">TITLE</label>
                                            <input type="color" class="form-control form-control-color" id="color11" value="<?= set_value('color11') ? set_value('color11') : $templates['color11'] ?>" title="Choose your color" name="color11">
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="color12" class="form-label">BTN CAROUSEL</label>
                                            <input type="color" class="form-control form-control-color" id="color12" value="<?= set_value('color12') ? set_value('color12') : $templates['color12'] ?>" title="Choose your color" name="color12">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="" class="col-sm-2 col-form-label"></label>
                                        <div class="col-sm-2">
                                            <label for="color13" class="form-label">TEXT FOOTER</label>
                                            <input type="color" class="form-control form-control-color" id="color13" value="<?= set_value('color13') ? set_value('color13') : $templates['color13'] ?>" title="Choose your color" name="color13">
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="color14" class="form-label">PAGINATION</label>
                                            <input type="color" class="form-control form-control-color" id="color14" value="<?= set_value('color14') ? set_value('color14') : $templates['color14'] ?>" title="Choose your color" name="color14">
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="color15" class="form-label">TITLE FOOTER</label>
                                            <input type="color" class="form-control form-control-color" id="color15" value="<?= set_value('color15') ? set_value('color15') : $templates['color15'] ?>" title="Choose your color" name="color15">
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="color16" class="form-label">MOBILE NAV</label>
                                            <input type="color" class="form-control form-control-color" id="color16" value="<?= set_value('color16') ? set_value('color16') : $templates['color16'] ?>" title="Choose your color" name="color16">
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="color17" class="form-label">TEXT COPYRIGHT</label>
                                            <input type="color" class="form-control form-control-color" id="color17" value="<?= set_value('color17') ? set_value('color17') : $templates['color17'] ?>" title="Choose your color" name="color17">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="" class="col-sm-2 col-form-label"></label>
                                        <div class="col-sm-2">
                                            <label for="color18" class="form-label">LINK COPYRIGHT</label>
                                            <input type="color" class="form-control form-control-color" id="color18" value="<?= set_value('color18') ? set_value('color18') : $templates['color18'] ?>" title="Choose your color" name="color18">
                                        </div>
                                        <div class="col-sm-2" style="display: none;">
                                            <label for="color19" class="form-label"></label>
                                            <input type="color" class="form-control form-control-color" id="color19" value="<?= set_value('color19') ? set_value('color19') : $templates['color19'] ?>" title="Choose your color" name="color19">
                                        </div>
                                        <div class="col-sm-2" style="display: none;">
                                            <label for="color20" class="form-label"></label>
                                            <input type="color" class="form-control form-control-color" id="color20" value="<?= set_value('color20') ? set_value('color20') : $templates['color20'] ?>" title="Choose your color" name="color20">
                                        </div>
                                        <div class="col-sm-2" style="display: none;">
                                            <label for="color21" class="form-label"></label>
                                            <input type="color" class="form-control form-control-color" id="color21" value="<?= set_value('color21') ? set_value('color21') : $templates['color21'] ?>" title="Choose your color" name="color21">
                                        </div>
                                        <div class="col-sm-2" style="display: none;">
                                            <label for="color22" class="form-label"></label>
                                            <input type="color" class="form-control form-control-color" id="color22" value="<?= set_value('color22') ? set_value('color22') : $templates['color22'] ?>" title="Choose your color" name="color22">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="labelDisc" class="col-sm-2 col-form-label">Label Disc</label>
                                        <div class="col-sm-2">
                                            <label for="color8" class="form-label">Warna 1</label>
                                            <input type="color" class="form-control form-control-color" id="color8" value="<?= set_value('color8') ? set_value('color8') : $templates['color8'] ?>" title="Choose your color" name="color8">
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="color9" class="form-label">Warna 2</label>
                                            <input type="color" class="form-control form-control-color" id="color9" value="<?= set_value('color9') ? set_value('color9') : $templates['color9'] ?>" title="Choose your color" name="color9">
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

    <?php endif ?>
</div>
<!-- /.content-wrapper -->

<?= $this->endSection('content'); ?>