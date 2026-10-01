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
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= $fld_nm ?>">
                        <span class="error invalid-feedback errorNama">
                        </span>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="" class="col-sm-2 col-form-label">Value</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="value" name="value" value="<?= $fld_valu ?>">
                        <span class="error invalid-feedback errorValue">
                        </span>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="" class="col-sm-2 col-form-label">Desc</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="desc" name="desc" value="<?= $fld_desc ?>">
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
        $('.formeditpasien').submit(function(e) {
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
                    $('.btnsimpan').html('Update');
                },
                success: function(response) {

                    //alert(response.sukses);

                    // Swal.fire({
                    //     icon: 'success',
                    //     title: 'Berhasil',
                    //     text: response.suskess,
                    //     footer: '<a href="">Why do I have this issue?</a>'
                    // });

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.sukses
                    })

                    pasien();
                    $('#modaledit').modal('hide');
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