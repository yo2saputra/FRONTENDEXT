var canvas = document.getElementById('signature-pad');
	

// Adjust canvas coordinate space taking into account pixel ratio,
// to make it look crisp on mobile devices.
// This also causes canvas to be cleared.
function resizeCanvas() {
    // When zoomed out to less than 100%, for some very strange reason,
    // some browsers report devicePixelRatio as less than 1
    // and only part of the canvas is cleared then.
    var ratio =  Math.max(window.devicePixelRatio || 1, 1);
    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    canvas.getContext("2d").scale(ratio, ratio);
	
	var image = new Image();
	image.src = '/dist/img/Blank.jpg';
	image.onload = function () {
		var cxt = canvas.getContext('2d');
		cxt.drawImage(image,
			 //canvas.offsetWidth * ratio / 2 - image.width / 2,
			 //canvas.offsetHeight * ratio / 2 - image.height / 2
			 canvas.width * 0.5- image.width * 0.5,
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

document.getElementById('save-jpeg').addEventListener('click', function () {
  if (signaturePad.isEmpty()) {
    alert("Coretan Kosong! Silahkan beri coretan terlebih dulu.");
  }else{
    var data = signaturePad.toDataURL('image/jpeg');
    //console.log(data);
    $('#myModal').modal('show').find('.modal-body').html('<h4>Format .JPEG</h4><img src="'+data+'"><input type="hidden" name="gambar" value="'+data+'"><textarea id="signature64" name="signed" style="display:none">'+data+'</textarea>');
  }
});

document.getElementById('clear').addEventListener('click', function () {
  signaturePad.clear();
  resizeCanvas();
});

document.getElementById('undo').addEventListener('click', function () {
	var data = signaturePad.toData();
	resizeCanvas();
	if (data) {
	data.pop(); // remove the last dot or line
	signaturePad.fromData(data);
	}
});