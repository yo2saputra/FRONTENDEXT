<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gambar Pasien</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
    <style type="text/css">
        .wrapper {
            position: relative; 
            width: 100%; 
            max-width: 450px;
            margin: 0 auto;
            border: 1px solid #ccc;
            border-radius: 5px; 
            background: #fff;
            overflow: hidden;
        }
        canvas { display: block; width: 100% !important; height: auto !important; }
        
        .nav-controls { 
            margin-bottom: 10px; 
            background: #f8f8f8; 
            padding: 10px; 
            border-radius: 5px;
            display: flex; 
            align-items: center; 
            justify-content: center; 
            gap: 10px;
            flex-wrap: nowrap; 
            overflow-x: auto; 
            -webkit-overflow-scrolling: touch;
        }
        .nav-controls::-webkit-scrollbar { display: none; }

        .palette-container { 
            display: flex; 
            gap: 8px; 
            flex-shrink: 0; 
            padding-right: 10px;
            border-right: 1px solid #ddd;
            align-items: center;
        }

        .clr-circle { 
            width: 26px; height: 26px; border-radius: 50%; 
            cursor: pointer; border: 2px solid #fff; box-shadow: 0 0 2px rgba(0,0,0,0.2); 
        }
        .clr-circle.active { border: 2px solid #333; }
        
        .custom-picker-wrapper { 
            position: relative; width: 26px; height: 26px; border-radius: 50%; 
            overflow: hidden; border: 2px solid #fff; 
            background: conic-gradient(red, yellow, lime, aqua, blue, magenta, red); 
        }
        #favcolor { position: absolute; top: -5px; left: -5px; width: 40px; height: 40px; cursor: pointer; opacity: 0; }

        .btn-tools-group { display: flex; gap: 4px; flex-shrink: 0; }
        #preview-img { max-width: 100%; height: auto; border: 1px solid #ddd; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <br>
                <div class="nav-controls">
                    <div class="palette-container">
                        <div class="clr-circle active" style="background-color: #000000;" data-clr="#000000"></div>
                        <div class="custom-picker-wrapper">
                            <input type="color" id="favcolor" value="#000000">
                        </div>
                    </div>

                    <div class="btn-tools-group">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm" id="mode-draw"><i class="fa fa-pencil"></i></button>
                            <button type="button" class="btn btn-default btn-sm" id="mode-select"><i class="fa fa-mouse-pointer"></i></button>
                        </div>
                        <button type="button" class="btn btn-info btn-sm" id="add-text" title="Teks"><i class="fa fa-text"></i></button>
                        <button type="button" class="btn btn-warning btn-sm" id="undo"><i class="fa fa-undo"></i></button>
                        <button type="button" class="btn btn-danger btn-sm" id="delete-obj"><i class="fa fa-trash"></i></button>
                        <button type="button" class="btn btn-default btn-sm" id="clear">Clear</button>
                        <button type="button" class="btn btn-success btn-sm" id="btn-preview">Save</button>
                    </div>
                </div>

                <div class="wrapper" id="canvas-wrapper">
                    <canvas id="c"></canvas>
                </div>
                <img id="scream" src="<?= base_url('dist/img/manhead.jpg') ?>" style="display:none">
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>

    <div class="modal fade" id="modalPreview" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Preview Gambar</h4>
                </div>
                <div class="modal-body text-center"><img id="preview-img" src=""></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary btn-sm" id="btn-upload-final">Upload</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.1/fabric.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            var canvas = new fabric.Canvas('c');
            var imgElement = document.getElementById('scream');
            var wrapper = document.getElementById('canvas-wrapper');
            var currentColor = '#000000';
            var MAX_CHARS = 300;

            function initCanvas() {
                var containerWidth = wrapper.offsetWidth;
                var ratio = imgElement.naturalWidth / imgElement.naturalHeight;
                var containerHeight = containerWidth / ratio;
                var oldWidth = canvas.width;

                canvas.setDimensions({ width: containerWidth, height: containerHeight });
                var scale = containerWidth / imgElement.naturalWidth;

                fabric.Image.fromURL(imgElement.src, function(oImg) {
                    canvas.setBackgroundImage(oImg, canvas.renderAll.bind(canvas), {
                        scaleX: scale, scaleY: scale, originX: 'left', originY: 'top'
                    });
                });

                if (oldWidth > 0 && oldWidth !== containerWidth) {
                    var factor = containerWidth / oldWidth;
                    canvas.getObjects().forEach(obj => {
                        obj.scaleX *= factor; obj.scaleY *= factor;
                        obj.left *= factor; obj.top *= factor;
                        obj.setCoords();
                    });
                }
                canvas.renderAll();
                setMode('draw');
            }

            if (imgElement.complete) { initCanvas(); } else { imgElement.onload = initCanvas; }
            window.addEventListener('resize', () => setTimeout(initCanvas, 100));

            function setMode(mode) {
                canvas.isDrawingMode = (mode === 'draw');
                if (canvas.isDrawingMode) {
                    canvas.freeDrawingBrush.color = currentColor;
                    canvas.freeDrawingBrush.width = 3;
                    $('#mode-draw').addClass('btn-primary').removeClass('btn-default');
                    $('#mode-select').addClass('btn-default').removeClass('btn-primary');
                } else {
                    $('#mode-select').addClass('btn-primary').removeClass('btn-default');
                    $('#mode-draw').addClass('btn-default').removeClass('btn-primary');
                }
            }

            $('.clr-circle').click(function() { currentColor = $(this).data('clr'); updateUI($(this)); });
            $('#favcolor').on('input change', function() { currentColor = $(this).val(); updateUI($('.custom-picker-wrapper')); });

            function updateUI(el) {
                $('.clr-circle, .custom-picker-wrapper').removeClass('active');
                el.addClass('active');
                if (canvas.isDrawingMode) canvas.freeDrawingBrush.color = currentColor;
                let active = canvas.getActiveObject();
                if (active && active.type === 'textbox') { active.set('fill', currentColor); canvas.renderAll(); }
            }

            $('#mode-draw').click(() => setMode('draw'));
            $('#mode-select').click(() => setMode('select'));

            $('#add-text').click(function() {
                Swal.fire({ 
                    title: 'Keterangan', 
                    input: 'textarea', 
                    inputAttributes: { 'maxlength': MAX_CHARS }, 
                    showCancelButton: true 
                })
                .then((res) => {
                    if (res.isConfirmed && res.value) {
                        var txt = new fabric.Textbox(res.value, {
                            left: 50, 
                            top: 50, 
                            fontSize: 20, 
                            fill: currentColor, 
                            width: 180,
                            lockScalingFlip: true, 
                            lockUniScaling: true, 
                            breakWords: true
                        });

                        txt.setControlsVisibility({
                            mt: false, 
                            mb: false, 
                            ml: true,  
                            mr: true,  
                            bl: true, 
                            br: true, 
                            tl: true,  
                            tr: true, 
                            mtr: true  
                        });

                        canvas.add(txt);
                        canvas.setActiveObject(txt);
                        setMode('select');
                    }
                });
            });

            $('#undo').click(() => { let objs = canvas.getObjects(); if(objs.length) canvas.remove(objs[objs.length-1]); });
            $('#delete-obj').click(() => { let active = canvas.getActiveObjects(); if(active.length) { canvas.discardActiveObject(); canvas.remove(...active); } });
            $('#clear').click(() => canvas.getObjects().forEach(o => { if(o !== canvas.backgroundImage) canvas.remove(o); }));

            $('#btn-preview').click(function() {
                let multiplier = imgElement.naturalWidth / canvas.width;
                let data = canvas.toDataURL({ format: 'jpeg', quality: 0.9, multiplier: multiplier });
                $('#preview-img').attr('src', data);
                $('#modalPreview').modal('show');
            });

            $('#btn-upload-final').click(function() {
                $.ajax({
                    type: "POST", url: "<?= site_url('konsultasidokter/doupload1') ?>",
                    data: { gambar: $('#preview-img').attr('src'), image_nm: "HEAD_<?= session()->get('no_registrasi') ?>", no_registrasi: "<?= session()->get('no_registrasi') ?>" },
                    dataType: "json",
                    success: res => { if(res.success) Swal.fire('Berhasil', res.success, 'success').then(() => window.close()); }
                });
            });
        });
    </script>
</body>
</html>