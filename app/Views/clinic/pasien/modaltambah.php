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

<script>
    $(document).ready(function() {
        $('.formtambahpasien').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('.btnsimpan').attr('disable', 'disabled');
                    $('.btnsimpan').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btnsimpan').removeAttr('disable');
                    $('.btnsimpan').html('Simpan');
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
                        //alert(response.sukses);

                        // Swal.fire({
                        //     icon: 'success',
                        //     title: 'Berhasil',
                        //     text: response.suskess,
                        //     footer: '<a href="">Why do I have this issue?</a>'
                        // });

                        pasien();
                        $('#modaltambah').modal('hide');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });

        function pasien() {
            $.ajax({
                method: "get",
                url: "<?= site_url('clinic/pasien/ambildata'); ?>",
                success: function(data) {
                    $('#viewdata').html(data);
                }
            });
        }
    });
</script>