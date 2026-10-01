<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Gambar Pasien</title>
	<!-- CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
	<link rel="stylesheet" href="<?= base_url('assets/css/signature-pad.css') ?>">
	<style type="text/css">
		.signature-pad {
			border: 1px solid #ccc;
			border-radius: 5px;
			width: 100%;
			height: 547px;

		}
	</style>
</head>
<?php
//$this->load->helper('cookie');
$session = session();
$uri = service('uri');
?>

<body>
	<div class="container">

		<div class="row">
			<?php helper('form'); ?>

			<?= form_open_multipart('', ['class' => 'formupload']) ?>
			<?= csrf_field(); ?>
			<input type="hidden" value="HEAD_<?= $session->get('no_registrasi'); ?>" name="image_nm">
			<input type="hidden" value="<?= $session->get('no_registrasi'); ?>" name="no_registrasi">
			<div class="col-md-4">
			</div>
			<div class="col-md-4">
				<br>
				<br>
				<div class="text-right">
					<!-- <button type="button" class="btn btn-default btn-sm" id="undo"><i class="fa fa-undo"></i> Undo</button>
						<button type="button" class="btn btn-danger btn-sm" id="clear"><i class="fa fa-eraser"></i> Clear</button>-->
				</div>
				<br>
				<img id="scream" src="/dist/img/Head.jpg" alt="The Scream" style="display:none" class="img-fluid">
				<div class="wrapper">
					<canvas id="signature-pad" class="signature-pad"></canvas>
				</div>
				<br>
				<!-- Modal untuk tampil preview tanda tangan-->
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel">Preview Gambar</h4>
							</div>
							<div class="modal-body text-center">
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
								<button type="submit" class="btn btn-primary btn-sm btnupload"><i class="fa fa-upload"></i> Upload</button>
							</div>
						</div>
					</div>
				</div>


			</div>
			<div class="col-md-4">
			</div>
			<div class="nav">
				<div class="clr" data-clr="#000"></div>
				<div class="clr" data-clr="#EF626C"></div>
				<div class="clr" data-clr="#fdec03"></div>
				<div class="clr" data-clr="#24d102"></div>
				<div class="clr" data-clr="#fff"></div>
				<button type="button" class="btn btn-danger btn-sm ml-2" id="clear"><i class="fa fa-eraser"></i> Clear</button>
				<button type="button" class="btn btn-success btn-sm ml-2" id="save-jpeg"><i class="fa fa-save"></i> Save</button>
			</div>
			<?= form_close() ?>
		</div>
	</div>
	<!-- Javascript -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
	<!-- <script type="text/javascript" src="<?= base_url('assets/js/draw1.js') ?>"></script> -->
	<script>
		var canvas = document.getElementById('signature-pad');

		// Adjust canvas coordinate space taking into account pixel ratio,
		// to make it look crisp on mobile devices.
		// This also causes canvas to be cleared.
		function resizeCanvas() {
			// When zoomed out to less than 100%, for some very strange reason,
			// some browsers report devicePixelRatio as less than 1
			// and only part of the canvas is cleared then.
			var ratio = Math.max(window.devicePixelRatio || 1, 1);
			canvas.width = canvas.offsetWidth * ratio;
			canvas.height = canvas.offsetHeight * ratio;
			canvas.getContext("2d").scale(ratio, ratio);

			var image = new Image();
			image.src = '/dist/img/Head.jpg';
			image.onload = function() {
				var cxt = canvas.getContext('2d');
				cxt.drawImage(image,
					//canvas.offsetWidth * ratio / 2 - image.width / 2,
					//canvas.offsetHeight * ratio / 2 - image.height / 2
					canvas.width * 0.5 - image.width * 0.5,
					canvas.height / 2 - image.height / 2
				);
			};


		}

		window.onresize = resizeCanvas;
		resizeCanvas();

		//let cxt2 = canvas.getContext('2d');
		//ctx2.lineWidth = 2;
		let clrs = document.querySelectorAll(".clr")
		clrs = Array.from(clrs)
		clrs.forEach(clr => {
			clr.addEventListener("click", () => {
				//ctx2.strokeStyle = clr.dataset.clr
				//const signaturePad = new SignaturePad(canvas);
				signaturePad.penColor = clr.dataset.clr
			});
		});

		var signaturePad = new SignaturePad(canvas, {
			backgroundColor: 'rgb(255, 255, 255)' // necessary for saving image as JPEG; can be removed is only saving as PNG or SVG
		});

		document.getElementById('save-jpeg').addEventListener('click', function() {
			if (signaturePad.isEmpty()) {
				alert("Coretan Kosong! Silahkan beri coretan terlebih dulu.");
			} else {
				var data = signaturePad.toDataURL('image/jpeg');
				//console.log(data);
				$('#myModal').modal('show').find('.modal-body').html('<h4>Format .JPEG</h4><img src="' + data + '"><input type="hidden" name="gambar" value="' + data + '"><textarea id="signature64" name="signed" style="display:none">' + data + '</textarea>');
			}
		});

		document.getElementById('clear').addEventListener('click', function() {
			signaturePad.clear();
			resizeCanvas();
		});

		document.getElementById('undo').addEventListener('click', function() {
			var data = signaturePad.toData();
			resizeCanvas();
			if (data) {
				data.pop(); // remove the last dot or line
				signaturePad.fromData(data);
			}
		});
	</script>

	<script>
		$(document).ready(function() {
			$('.btnupload').click(function(e) {

				e.preventDefault();

				let form = $('.formupload')[0];

				let data = new FormData(form);

				$.ajax({
					type: "post",
					url: "<?= site_url('konsultasidokter/doupload1') ?>",
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
						// window.opener.doSomething();
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
							window.close();
							Swal.fire({
								icon: 'success',
								title: 'Berhasil',
								text: response.success,
							});

							// $('#modalupload').modal('hide');
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
</body>

</html>