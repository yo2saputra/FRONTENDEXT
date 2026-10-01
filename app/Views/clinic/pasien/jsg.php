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