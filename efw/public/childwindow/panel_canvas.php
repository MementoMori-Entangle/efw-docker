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
        <link rel="stylesheet" href="./../css/gcss20181102.css">
        <link rel="stylesheet" href="./../css/jquery-ui.css">
        <link rel="stylesheet" href="./../css/jquery.contextMenu.css">
        <link rel="stylesheet" href="./../css/fabric.css">
        <link rel="stylesheet" href="./../css/normalize.css">
        <link rel="stylesheet" href="./../css/milligram.css">
    </head>
    <body>
        <div class="container">
            <div>Panel canvas</div>
            <div class="panel_win_canvas_container">
                <img class="frame_img" src="./../img/frame2.png">
                <canvas id="panelCanvasWin" width="640" height="480"></canvas>
            </div>
            <div>
                <span id="panel_win_object_menu" class="context-menu-panel_win btn btn-neutral square_btn">Menu</span>
            </div>
        </div>

        <video width="640" height="480" id="webCam_1" style="display: none" muted controls></video>
        <video width="640" height="480" id="webCam_2" style="display: none" muted controls></video>
        <video width="640" height="480" id="webCam_3" style="display: none" muted controls></video>
        <video width="640" height="480" id="webCam_4" style="display: none" muted controls></video>
        <video width="640" height="480" id="webCam_5" style="display: none" muted controls></video>
        <video width="640" height="480" id="webCam_6" style="display: none" muted controls></video>
        <video width="640" height="480" id="webCam_7" style="display: none" muted controls></video>
        <video width="640" height="480" id="webCam_8" style="display: none" muted controls></video>
        <video width="640" height="480" id="webCam_9" style="display: none" muted controls></video>
        <video width="640" height="480" id="webCam_10" style="display: none" muted controls></video>
        <video width="640" height="480" id="webCam_11" style="display: none" muted controls></video>
        <video width="640" height="480" id="webCam_12" style="display: none" muted controls></video>
        <video width="640" height="480" id="webCam_13" style="display: none" muted controls></video>
        <video width="640" height="480" id="webCam_14" style="display: none" muted controls></video>
        <video width="640" height="480" id="webCam_15" style="display: none" muted controls></video>
        <video width="640" height="480" id="webCam_16" style="display: none" muted controls></video>

        <script type="text/javascript">
            var panelCanvasWin = new fabric.Canvas('panelCanvasWin');

            var clickObjectContextmenu = 3;

            var index = 1;

            //var resizeScaleX = getImageScale(640, 155); // 4 * 4
            //var resizeScaleY = getImageScale(480, 115);
            //var resizeScaleX = getImageScale(640, 210); // 3 * 3
            //var resizeScaleY = getImageScale(480, 160);
            var resizeScaleX = getImageScale(640, 310); // 2 * 2
            var resizeScaleY = getImageScale(480, 230);

            //var xPos = [0, 158, 318, 480, 0, 158, 318, 480, 0, 158, 318, 480, 0, 158, 318, 480];
            //var yPos = [0, 0, 0, 0, 118, 118, 118, 118, 236, 236, 236, 236, 236, 360, 360, 360, 360];
            //var xPos = [0, 215, 430, 0, 215, 430, 0, 215, 430];
            //var yPos = [0, 0, 0, 160, 160, 160, 320, 320, 320];
            var xPos = [0, 324, 0, 324];
            var yPos = [2, 2, 242, 242];

            var testId = null;

            navigator.mediaDevices.enumerateDevices().then(function(devices) {
                devices.forEach(function(device) {
                    if ('videoinput' === device.kind) {
                        addWebCam(panelCanvasWin, device.deviceId, xPos[index - 1], yPos[index - 1], index);
                        index++;
                        testId = device.deviceId;
                    }
                });
            });

            for (var i = 1; i < xPos.length; i++) {
                addWebCam(panelCanvasWin, testId, yPos[i], xPos[i], i + 1);
            }

            $(function() {
                $.contextMenu({
                    selector: '.context-menu-panel_win',
                    callback: function(key, options) {
                        canvasExceute(key);
                    },
                    items: {
                        'play': {'name': 'Play', 'icon': 'play'},
                        'pause': {'name': 'Pause', 'icon': 'pause'},
                        'upVolume': {'name': 'UpVolume', 'icon': 'upvolume'},
                        'downVolume': {'name': 'DownVolume', 'icon': 'downvolume'},
                        'mute': {'name': 'Mute', 'icon': 'mute'},
                    }
                });

                $('#panel_win_object_menu').on('click', function(opt) {
                    $('#panel_win_object_menu').trigger('contextmenu');
                });
            });

            function canvasExceute(key) {
                switch (key) {
                    case 'play':
                        canvasObjectPlay(panelCanvasWin);
                        break;
                    case 'pause':
                        canvasObjectPause(panelCanvasWin);
                        break;
                    case 'upVolume':
                        canvasObjectUpVolume(panelCanvasWin);
                        break;
                    case 'downVolume':
                        canvasObjectDownVolume(panelCanvasWin);
                        break;
                    case 'mute':
                        canvasObjectMute(panelCanvasWin);
                        break;
                }
            }

            function addWebCam(canvas, deviceId, objTop, objLeft, no) {
                var webCamEl = document.getElementById('webCam_' + no);

                var webCam = new fabric.Image(webCamEl, {
                    name: 'webCam_' + no,
                    top: objTop,
                    left: objLeft,
                    scaleX: resizeScaleX,
                    scaleY: resizeScaleY,
                    objectCaching: false,
                });

                webCam.on('mouseup:before', function(opt) {
                    if (clickObjectContextmenu === opt.e.which) {
                        $('#panel_win_object_menu').trigger('contextmenu');
                    }
                });

                navigator.getUserMedia({video: {optional: [{sourceId: deviceId}]}
                    }, function(stream) {
                        var video = document.getElementById('webCam_' + no);

                        video.src = window.URL.createObjectURL(stream);

                        panelCanvasWin.add(webCam);
                        webCam.moveTo(0);
                        webCam.getElement().play();
                    }, function(err){
                        alert(err.name);
                    }

                );

                fabric.util.requestAnimFrame(function render() {
                    panelCanvasWin.renderAll();
                    fabric.util.requestAnimFrame(render);
                });
            }

            function canvasObjectPlay(canvas) {
                var obj = canvas.getActiveObject();

                if (null != obj) {
                    obj.getElement().play();
                }
            }

            function canvasObjectPause(canvas) {
                var obj = canvas.getActiveObject();

                if (null != obj) {
                    obj.getElement().pause();
                }
            }

            function canvasObjectUpVolume(canvas) {
                var obj = canvas.getActiveObject();

                if (null != obj) {
                    obj.getElement().volume = obj.getElement().volume + addVolume;
                }
            }

            function canvasObjectDownVolume(canvas) {
                var obj = canvas.getActiveObject();

                if (null != obj && 0 < (obj.getElement().volume - addVolume)) {
                    obj.getElement().volume = obj.getElement().volume - addVolume;
                }
            }

            function canvasObjectMute(canvas) {
                var obj = canvas.getActiveObject();

                if (null != obj) {
                    obj.getElement().muted = obj.getElement().muted ? false : true;
                }
            }

            function getImageScale(baseSize, targetSize) {
                var scale = 1.0;

                scale = (targetSize / baseSize);

                return scale;
            }

        </script>
    </body>
</html>