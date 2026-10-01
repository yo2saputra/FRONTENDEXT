<?= $this->extend('clinic_template'); ?>

<?= $this->section('style'); ?>

<style>
    /* set width action button crud */
    .btn-fix-w {
        width: 50px;
    }

    /* set font size dropdown select2 */
    select.form-control-sm~.select2-container--default {
        font-size: .720rem !important;
    }

    /* set font size input form */
    .form-control-sm {
        font-size: .720rem !important;
    }
</style>

<!-- CSS -->
<style>
    #my_camera {
        width: 320px;
        height: 240px;
        border: 1px solid black;
    }
</style>

<?= $this->endSection('style'); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1></h1>
                </div>
                <div class="col-sm-6">
                    <!-- <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">patient</li>
                    </ol> -->
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
                            <?php helper('form'); ?>



                            <?= form_open_multipart('', ['class' => 'formupload']) ?>
                            <?= csrf_field(); ?>
                            <input type="hidden" value="yoyo" name="nobp">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="" class="col-sm-2 col-form-label">Ambil Gambar (WebCam)</label>
                                            <div class="col-sm-10">
                                                <div id="my_camera"></div>
                                                <p>
                                                    <button type="button" class="btn btn-sm btn-info mt-3" onclick="take_picture();">Ambil Gambar</button>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="" class="col-sm-2 col-form-label">Capture</label>
                                            <div class="col-sm-10" id="results"></div>
                                            <input type="hidden" name="imagecam" class="image-tag">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group row text-center">
                                    <button type="submit" class="btn btn-primary btnupload">Upload</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="card-footer">
                            <button type="submit" class="btn btn-primary btnupload">Upload</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div> -->
                        <?= form_close() ?>
                    </div>
                    <!-- /.card -->

                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?= $this->endSection('content'); ?>

<?= $this->section('script'); ?>

<!-- set menu name by active-menu -->
<script>
    $('#active-menu').html($('p#active-menu').html()); // set top navbar
    $(document).prop("title", $('p#active-menu').html()); // set title
</script>

<!-- Webcam.min.js -->
<script type="text/javascript" src="<?= base_url('assets/js/webcam.min.js') ?>"></script>

<script>
    $(document).ready(function() {
        $('.btnupload').click(function(e) {
            e.preventDefault();

            let form = $('.formupload')[0];

            let data = new FormData(form);

            $.ajax({
                type: "post",
                url: "<?= site_url('selfregistration/doupload') ?>",
                data: data,
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json",
                beforeSend: function(e) {
                    $('.btnupload').prop('disabled', 'disabled');
                    $('.btnupload').html(`<i class="fa fa-spin fa-spinner"></i>`);
                },
                complete: function(e) {
                    $('.btnupload').removeAttr('disabled');
                    $('.btnupload').html(`Upload`);
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.foto) {
                            $('#foto').addClass('is-invalid');
                            $('.errorfoto').html(response.error.foto);
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Maaf',
                            text: response.error,
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.success,
                        });
                        $('#modalupload').modal('hide');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" +
                        thrownError);
                }
            });
        });
    });
</script>


<script>
    Webcam.set({
        width: 320,
        height: 240,
        image_format: 'jpeg',
        jpeg_quality: 100
    });
    Webcam.attach('#my_camera');

    function take_picture() {
        Webcam.snap(function(data_uri) {
            $(".image-tag").val(data_uri);

            document.getElementById('results').innerHTML = '<img class="img-fluid" src="' + data_uri + '"/>';

        });
    }
</script>

<?= $this->endSection('script'); ?>