<?= $this->extend('clinic/clinic_template'); ?>

<?= $this->section('style'); ?>
<!-- Toastr -->
<link rel="stylesheet" href="<?= base_url('plugins/toastr/toastr.min.css') ?>">

<style>
    .btn-fix-w {
        width: 50px;
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
                    <h1>Dokter</h1>
                </div>
                <div class="col-sm-6">
                    <!-- <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Dokter</li>
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

                            <button type="button" name="add_record" id="add_record" class="btn btn-success btn-sm">
                                <i class="fa fa-plus-circle"></i> ADD
                            </button>
                            <br>
                            <br>

                            <div class="card-title">
                            </div>

                            <span id="viewdata"></span>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="modalform" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Insert Data dokter</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="post" id="data_form">
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
                                            <!-- <div class="mb-3 row">
                                                <label for="blood_typ" class="col-sm-2 col-form-label">Blood Type</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" name="blood_typ" id="blood_typ">
                                                        <option value="">--SELECT--</option>
                                                        <?php foreach ($blood_typ as $data) : ?>
                                                            <option value="<?= $data['fld_valu'] ?>"><?= $data['fld_desc'] ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                            </div> -->
                                            <!-- <?= $cb_city_cd ?>
                                            <?= $cb_classteraphy_cd ?>
                                            <?= $cb_drug_typ ?> -->
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" id="hidden_id" name="hidden_id" />
                                            <input type="hidden" id="action" name="action" value="Add" />
                                            <button type="submit" name="submit" id="submit_button" class="btn btn-primary" value="Add"></button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

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

<?= $this->section('script'); ?>

<!-- Toastr -->
<script src="<?= base_url('plugins/toastr/toastr.min.js') ?>"></script>

<script>
    function dokter() {
        $.ajax({
            method: "get",
            url: "<?= site_url('clinic/dokter2/fetchAll'); ?>",
            success: function(data) {
                $('#viewdata').html(data);
            }
        });
    }
    $(document).ready(function() {
        dokter()
        // $('#sample_table').DataTable({
        //     "order": [],
        //     "serverSide": true,
        //     "ajax": {
        //         url: "<?php echo base_url("/ajax_crud/fetchAll"); ?>",
        //         type: "POST",
        //     }
        // });

        $('#add_record').click(function() {
            $('#nama').removeAttr('readonly');
            $('#value').removeAttr('readonly');

            var bc = 'BTA-';
            var bd = 'CT06220002';
            var be = 'CT06220002';
            $('#data_form')[0].reset();
            $('.modal-title').text('Add Data');

            $('#nama').removeClass('is-invalid');
            $('#value').removeClass('is-invalid');
            $('#desc').removeClass('is-invalid');
            $('.errorNama').html('');
            $('.errorValue').html('');
            $('.errorDesc').html('');

            $("#blood_typ option[value='" + bc + "']").attr('selected', 'selected');
            $("#city_cd option[value='" + bd + "']").attr('selected', 'selected');
            $("#city_cd option[value='" + bd + "']").attr('selected', 'selected');

            $('.modal-header').text('Add Data');
            $('#action').val('Add');
            $('#submit_button').val('Add');
            $('#submit_button').html('Add');
            $('#modalform').modal('show');


        });

        $('#data_form').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "<?= site_url('clinic/dokter2/action'); ?>",
                method: "POST",
                data: $(this).serialize(),
                // data: {
                //     nama: nama,
                //     value: value,
                //     desc: desc,
                //     action: action
                // },
                dataType: "JSON",
                beforeSend: function() {
                    $('#submit_button').prop('disabled', true)
                    $('#submit_button').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('#submit_button').prop('disabled', false)
                    $('#submit_button').html($('#submit_button').val());
                },
                success: function(response) {

                    if (response.error) {
                        if (response.error.nama) {
                            $('#nama').addClass('is-invalid');
                            $('.errorNama').html(response.error.nama);
                        } else {
                            $('#nama').removeClass('is-invalid');
                            $('.errorNama').html('');
                        }
                        if (response.error.value) {
                            $('#value').addClass('is-invalid');
                            $('.errorValue').html(response.error.value);
                        } else {
                            $('#value').removeClass('is-invalid');
                            $('.errorValue').html('');
                        }
                        if (response.error.desc) {
                            $('#desc').addClass('is-invalid');
                            $('.errorDesc').html(response.error.desc);
                        } else {
                            $('#desc').removeClass('is-invalid');
                            $('.errorDesc').html('');
                        }
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                            //footer: '<a href="">Why do I have this issue?</a>'
                        });

                        $('#nama').removeClass('is-invalid');
                        $('#value').removeClass('is-invalid');
                        $('#desc').removeClass('is-invalid');
                        $('#nama').val('');
                        $('#value').val('');
                        $('#desc').val('');

                        dokter();
                        $('#modalform').modal('hide');
                    }
                },
            })
        });

        $(document).on('click', '.edit', function() {
            var fld_nm = $(this).data('fld_nm');
            var fld_valu = $(this).data('fld_valu');

            $.ajax({
                url: "<?= site_url('clinic/dokter2/fetchSingleData'); ?>",
                method: "POST",
                data: {
                    fld_nm: fld_nm,
                    fld_valu: fld_valu
                },
                dataType: "JSON",
                success: function(response) {
                    $('#nama').attr('readonly', '');
                    $('#value').attr('readonly', '');

                    $('#nama').val(response.data.nama);
                    $('#value').val(response.data.value);
                    $('#desc').val(response.data.desc);

                    $('#nama').removeClass('is-invalid');
                    $('#value').removeClass('is-invalid');
                    $('#desc').removeClass('is-invalid');
                    $('.errorNama').html('');
                    $('.errorValue').html('');
                    $('.errorDesc').html('');

                    $('.modal-header').text('Edit Data');
                    $('#action').val('Edit');
                    $('#submit_button').val('Edit');
                    $('#submit_button').html('Edit');
                    $('#modalform').modal('show');
                    $('#hidden_id').val(id);
                }
            })
        });

        $(document).on('click', '.delete', function() {
            var fld_nm = $(this).data('fld_nm');
            var fld_valu = $(this).data('fld_valu');
            if (confirm("Are you sure you want to remove it?")) {
                $.ajax({
                    url: "<?= site_url('clinic/dokter2/delete'); ?>",
                    method: "POST",
                    data: {
                        fld_nm: fld_nm,
                        fld_valu: fld_valu
                    },
                    dataType: "JSON",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                            //footer: '<a href="">Why do I have this issue?</a>'
                        });
                        dokter();
                        setTimeout(function() {
                            $('#message').html('');
                        }, 5000);
                    }
                })
            }
        });
    });
</script>
<?= $this->endSection('script'); ?>