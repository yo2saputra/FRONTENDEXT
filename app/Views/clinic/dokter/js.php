<script>
    function dokter() {
        $.ajax({
            method: "get",
            url: "<?= site_url('clinic/dokter/ambildata'); ?>",
            success: function(data) {
                $('#viewdata').html(data);
            }
        });
    }
    $(document).ready(function() {
        dokter();
        $('.formtambahdokter').submit(function(e) {
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

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.suskess,
                            footer: '<a href="">Why do I have this issue?</a>'
                        });

                        $('#nama').val('');
                        $('#value').val('');
                        $('#desc').val('');

                        dokter();
                        $('#modaltambah').modal('hide');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        dokter();
        $('.formeditdokter').submit(function(e) {
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

                    dokter();
                    $('#modaledit').modal('hide');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });

        // function dokter() {
        //     $.ajax({
        //         method: "get",
        //         url: "<?= site_url('clinic/dokter/ambildata'); ?>",
        //         success: function(data) {
        //             $('#viewdata').html(data);
        //         }
        //     });
        // }

        // $('.tomboltambah').click(function(e) {
        //     e.preventDefault();
        //     $.ajax({
        //         //type: "post",
        //         url: "<?= site_url('clinic/dokter/formtambah') ?>",
        //         dataType: "json",
        //         success: function(response) {
        //             $('#modaltambah').modal('show');
        //         },
        //         error: function(xhr, ajaxOptions, thrownError) {
        //             alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        //         }
        //     });
        // });

        $(document).on('click', '.tomboldelete', function() {
            var fld_nm = $(this).data("id");

            $.ajax({
                method: "post",
                url: "<?= site_url('clinic/dokter/deletedata'); ?>",
                data: {
                    fld_nm: fld_nm
                },
                dataType: "json",
                success: function(data) {
                    dokter();
                }
            });

        });


    });
</script>