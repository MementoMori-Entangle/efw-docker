<!DOCTYPE html>
<html>
    <head>
        <title>Fabric</title>
        <!-- CSS And JavaScript -->
        <script type="text/javascript" src="./../js/jquery-3.7.1.min.js"></script>
        <script type="text/javascript" src="./../js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="./../js/jquery.ui.position.min.js"></script>
        <script type="text/javascript" src="./../js/jquery.contextMenu.min.js"></script>
        <script type="text/javascript" src="./../js/fabric.min.5.3.js"></script>
        <script type="text/javascript" src="./../js/codemirror.js"></script>
        <script type="text/javascript" src="./../js/mergely.js"></script>
        <link rel="stylesheet" href="./../css/gcss20181102.css">
        <link rel="stylesheet" href="./../css/jquery-ui.css">
        <link rel="stylesheet" href="./../css/jquery.contextMenu.css">
        <link rel="stylesheet" href="./../css/fabric.css">
        <link rel="stylesheet" href="./../css/codemirror.css">
        <link rel="stylesheet" href="./../css/mergely.css">
        <link rel="stylesheet" href="./../css/normalize.css">
        <link rel="stylesheet" href="./../css/milligram.css">
    </head>
    <body>
        <div class="container">
            <div class="context-menu-image_diff" id="image_diff_object_menu">
                Image diff canvas
            </div>
            <div class="image_diff_button_container">
                <button type="button" id="diff">Simple diff</button>
                <button type="button" id="leftClear">Left clear</button>
                <button type="button" id="rightClear">Right clear</button>
                <button type="button" id="lrClear">Left and right clear</button>
                <button type="button" id="compare">Compare</button>
                <input type="checkbox" id="autoLine" checked />Auto Line
            </div>
            <div class="image_diff_a_canvas_container">
                <img class="frame_img" src="./../img/frame.png">
                <canvas id="imgCanvasA" width="640" height="480"></canvas>
                <textarea id="imgCanvasAText" rows="3" cols="50"></textarea>
            </div>
            <div class="image_diff_b_canvas_container">
                <img class="frame_img" src="./../img/frame.png">
                <canvas id="imgCanvasB" width="640" height="480"></canvas>
                <textarea id="imgCanvasBText" rows="3" cols="50"></textarea>
            </div>
            <div class="image_diff_c_canvas_container">
                <canvas id="imgCanvasC" width="640" height="300"></canvas>
            </div>
        </div>
        <div style="padding-top: 30px;">
            <div id="image_diff_compare"></div>
        </div>
        <script type="text/javascript">
            const LINE_ENTER_LENGTH = 80;

            var imgCanvasA = new fabric.Canvas('imgCanvasA');
            var imgCanvasB = new fabric.Canvas('imgCanvasB');
            var imgCanvasC = new fabric.Canvas('imgCanvasC');
            var srcA = '';
            var srcB = '';

            var clickObjectContextmenu = 3;

            var pCanvas = window.opener.baseCanvas;

            var objs = pCanvas.getObjects();
            var cnt = objs.length;

            for (var i = 0; i < cnt; i++) {
                if ('image' === objs[i].type && !isVideo(objs[i].getSrc()) && !isWebCam(objs[i].getSrc())) {
                    var objScaleX = objs[i].scaleX;
                    var objScaleY = objs[i].scaleY;

                    fabric.Image.fromURL(objs[i].getSrc(), function(img) {
                        var image = img.set(
                                {
                                    scaleX: objScaleX,
                                    scaleY: objScaleY,
                                });

                        image.on('mouseup:before', function(opt) {
                            if (clickObjectContextmenu === opt.e.which) {
                                $('#image_diff_object_menu').trigger('contextmenu');
                            }
                        });

                        img.setControlsVisibility({
                            mt: false,
                            mb: false,
                            ml: false,
                            mr: false,
                            bl: false,
                            br: false,
                            tl: false,
                            tr: false,
                            mtr: false,
                        });

                        imgCanvasC.add(image);
                        imgCanvasC.setActiveObject(image);
                        imgCanvasC.renderAll();
                    });
                }
            }

            $(function() {
                $('#diff').on('click', function() {
                    loadImageDataText();

                    if (srcA !== srcB) {
                        alert('Mismatch, Left size = ' + srcA.length + ' : Right size = ' + srcB.length);
                    } else {
                        alert('Match');
                    }
                });

                $('#leftClear').on('click', function() {
                    imgCanvasA.clear();
                });

                $('#rightClear').on('click', function() {
                    imgCanvasB.clear();
                });

                $('#lrClear').on('click', function() {
                    imgCanvasA.clear();
                    imgCanvasB.clear();
                });

                $('#compare').on('click', function() {
                    srcA = $('#imgCanvasAText').val();
                    srcB = $('#imgCanvasBText').val();

                    if ($('#autoLine').prop('checked')) {
                        var tmp = '';
                        var charDatas = srcA.split('');
                        var cnt = charDatas.length;

                        for (var i = 0; i < cnt; i++) {
                            if (0 != i && 0 == i % LINE_ENTER_LENGTH) {
                                tmp += '\n';
                            }
                            tmp += charDatas[i];
                        }

                        srcA = tmp;

                        tmp = '';
                        charDatas = srcB.split('');
                        cnt = charDatas.length;

                        for (var i = 0; i < cnt; i++) {
                            if (0 != i && 0 == i % LINE_ENTER_LENGTH) {
                                tmp += '\n';
                            }
                            tmp += charDatas[i];
                        }

                        srcB = tmp;
                    }

                    $('#image_diff_compare').mergely({
                        cmsettings: {
                            readOnly: false,
                            lineNumbers: true,
                        },
                        lhs: function(setValue) {
                            setValue(srcA);
                        },
                        rhs: function(setValue) {
                            setValue(srcB);
                        }
                    });
                });
            });

            $(function() {
                $.contextMenu({
                    selector: '.context-menu-image_diff',
                    callback: function(key, options) {
                        canvasExceute(key);
                    },
                    items: {
                        'moveToLeft': {'name': 'MoveToLeft', 'icon': 'loading'},
                        'moveToRight': {'name': 'moveToRight', 'icon': 'loading'},
                        'delete': {'name': 'Delete', 'icon': 'delete'},
                    }
                });

                $('#image_diff_object_menu').on('click', function(opt) {
                    $('#image_diff_object_menu').trigger('contextmenu');
                });
            });

            function loadImageDataText() {
                if (1 != imgCanvasA.getObjects().length || 1 != imgCanvasB.getObjects().length) {
                    return;
                }

                var objA = imgCanvasA.getObjects()[0];
                var objB = imgCanvasB.getObjects()[0];
                srcA = objA.getSrc();
                srcB = objB.getSrc();

                $('#imgCanvasAText').text(srcA);
                $('#imgCanvasBText').text(srcB);
            }

            function canvasExceute(key) {
                switch (key) {
                    case 'moveToLeft':
                        canvasObjectMove(imgCanvasC, 'left');
                        break;
                    case 'moveToRight':
                        canvasObjectMove(imgCanvasC, 'right');
                        break;
                    case 'delete':
                        canvasObjectDelete(imgCanvasC);
                        break;
                }
            }

            function canvasObjectMove(canvas, type) {
                if (!canvas.getActiveObject()) {
                    return;
                }

                var obj = canvas.getActiveObject();

                obj.clone(function(cloned) {
                    cloned.top = 10;
                    cloned.left = 10;

                    if ('left' === type) {
                        imgCanvasA.add(cloned);
                    } else if ('right' === type) {
                        imgCanvasB.add(cloned);
                    }
                });
            }

            function canvasObjectDelete(canvas) {
                if (!canvas.getActiveObject()) {
                    return;
                }

                var obj = canvas.getActiveObject();

                canvas.remove(obj);
            }

            function isVideo(src) {
                var result = false;

                if (null != src && src.match(/\.(mp4|webm|ogv)$/i)) {
                    result = true;
                }

                return result;
            }

            function isWebCam(src) {
                var result = false;

                if (null != src && src.match(/^blob:http/)) {
                    result = true;
                }

                return result;
            }
        </script>
    </body>
</html>