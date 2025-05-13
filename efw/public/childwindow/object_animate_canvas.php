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
        <script type="text/javascript" src="./../js/jquery.smSearchInputSelector.min.js"></script>
        <link rel="stylesheet" href="./../css/gcss20181102.css">
        <link rel="stylesheet" href="./../css/jquery-ui.css">
        <link rel="stylesheet" href="./../css/jquery.contextMenu.css">
        <link rel="stylesheet" href="./../css/fabric.css">
        <link rel="stylesheet" href="./../css/normalize.css">
        <link rel="stylesheet" href="./../css/milligram.css">
    </head>
    <body>
        <div class="container">
            <div class="context-menu-animate" id="animate_object_menu">
                Object animate canvas
            </div>
            <div class="animate_button_container">
                <button type="button" id="play">Play</button>
                <button type="button" id="pause">Pause</button>
            </div>
            <div class="animate_a_canvas_container">
                <img class="frame_img" src="./../img/frame.png">
                <canvas id="ssCanvasA" width="640" height="480"></canvas>
            </div>
            <div class="animate_select_type_container">
                <select name="select_animate_type" id="select_animate_type" class="form-control">
                    <option value="angle">Angle</option>
                    <option value="slider">Slider</option>
                    <option value="wave">Wave</option>
                    <option value="circle">Circle</option>
                    <option value="individual">Individual</option>
                </select>
            </div>
            <div class="animate_select_direction_container">
                <select name="select_animate_direction" id="select_animate_direction" class="form-control">
                    <option value="right_bottom">Right-Bottom</option>
                    <option value="left_bottom">Left-Bottom</option>
                    <option value="right_top">Right-Top</option>
                    <option value="left_top">Left-Top</option>
                    <option value="right">Right</option>
                    <option value="left">Left</option>
                    <option value="top">Top</option>
                    <option value="bottom">Bottom</option>
                </select>
            </div>
            <div class="animate_select_interval_container">
                <input class="selector_interval" type="text" id="select_animate_interval" name="select_animate_interval[]" data-value="" value="" />
            </div>
            <div class="animate_select_speed_container">
                <input class="selector_speed" type="text" id="select_animate_speed" name="select_animate_speed[]" data-value="" value="" />
            </div>
            <div class="animate_select_radius_container">
                <input class="selector_radius" type="text" id="select_animate_radius" name="select_animate_radius[]" data-value="" value="" />
            </div>
            <div class="animate_text_posx_container">
                <input type="text" id="text_posx" name="text_posx" value="" />
            </div>
            <div class="animate_text_posy_container">
                <input type="text" id="text_posy" name="text_posy" value="" />
            </div>
            <div class="animate_b_canvas_container">
                <canvas id="ssCanvasB" width="640" height="300"></canvas>
            </div>
            <div>
                <button class="animate_capture_record_start_btn" id="capture_record_start"></button>
                <button class="animate_capture_record_stop_btn" id="capture_record_stop"></button>
                <button class="animate_capture_record_pause_btn" id="capture_record_pause"></button>
                <span class="animate_capture_recorded_time" id="capture_recorded_time"></span>
                <button class="animate_capture_recorded_start_btn" id="capture_recorded_start"></button>
                <button class="animate_capture_recorded_stop_btn" id="capture_recorded_stop"></button>
                <button class="animate_capture_recorded_pause_btn" id="capture_recorded_pause"></button>
                <button class="animate_capture_recorded_dl_btn" id="capture_recorded_dl"></button>
            </div>
        </div>

        <video width="640" height="480" id="video" style="display: none" muted></video>
        <div id="video_copy_div" style="display: none"></div>

        <script type="text/javascript">
            const ANIMATE_TYPE_ANGLE = 'angle';
            const ANIMATE_TYPE_SLIDER = 'slider';
            const ANIMATE_TYPE_WAVE = 'wave';
            const ANIMATE_TYPE_CIRCLE = 'circle';
            const ANIMATE_TYPE_INDIVIDUAL = 'individual';

            const ANIMATE_DIRECTION_RIGHT_BOTTOM = 'right_bottom';
            const ANIMATE_DIRECTION_LEFT_BOTTOM = 'left_bottom';
            const ANIMATE_DIRECTION_RIGHT_TOP = 'right_top';
            const ANIMATE_DIRECTION_LEFT_TOP = 'left_top';
            const ANIMATE_DIRECTION_RIGHT = 'right';
            const ANIMATE_DIRECTION_LEFT = 'left';
            const ANIMATE_DIRECTION_TOP = 'top';
            const ANIMATE_DIRECTION_BOTTOM = 'bottom';
            const ANIMATE_UP = 'up';
            const ANIMATE_DOWN = 'down';

            const ANIMATE_CANVAS_WIDTH = 640;
            const ANIMATE_CANVAS_HEIGHT = 480;
            const ANIMATE_TIME_BASE = 60;

            var clickObjectContextmenu = 3;
            var addVolume = 0.25;
            var currentTimePlus = 10;
            var currentTimeMinus = -10;
            var objTop = 10;
            var objLeft = 10;
            var objScaleX = 0.5;
            var objScaleY = 0.5;
            var objObjectCaching = false;

            var ssCanvasA = new fabric.Canvas('ssCanvasA');
            var ssCanvasB = new fabric.Canvas('ssCanvasB');
            var pCanvas = window.opener.baseCanvas;
            var recorder = null;
            var recordedVideo = null;
            var blobUrl = null;

            var copyVideoElement = [];
            var animateSettingPosXs = [];
            var animateSettingPosYs = [];
            var animateSettingTypes = [];
            var videoCopyName = 'video_copy_';
            var animateObjName = 'animate_obj_';
            var selectAnimateType = ANIMATE_TYPE_ANGLE;
            var selectAnimateDirection = ANIMATE_DIRECTION_RIGHT_BOTTOM;
            var timing = 0;
            var speed = 1;
            var timeCnt = 1;
            var time = 1;
            var radius = 50;
            var baseRadiusSpeed = Math.PI * 2 / 60;
            var radiusSpeed = baseRadiusSpeed;
            var animateObjCnt = 0;
            var timer = null;
            var isAnimateLoop = true;
            var isPause = false;

            var posXs = [0, 0, 0, 0, 260];
            var posYs = [0, 0, 50, 50, 100];

            var selectInterval = [
                {value:0, name:'0 i-sec', search:'0 sec'},
                {value:1, name:'1 i-sec', search:'1 sec'},
                {value:3, name:'3 i-sec', search:'3 sec'},
                {value:5, name:'5 i-sec', search:'5 sec'},
            ];

            var selectSpeed = [
                {value:1, name:'1 s-px', search:'1 px'},
                {value:2, name:'2 s-px', search:'2 px'},
                {value:3, name:'3 s-px', search:'3 px'},
                {value:4, name:'4 s-px', search:'4 px'},
                {value:5, name:'5 s-px', search:'5 px'},
                {value:10, name:'10 s-px', search:'10 px'},
                {value:25, name:'30 s-px', search:'25 px'},
                {value:50, name:'50 s-px', search:'50 px'},
                {value:75, name:'75 s-px', search:'75 px'},
                {value:100, name:'100 s-px', search:'100 px'},
            ];

            var selectRadius = [
                {value:10, name:'10 r-px', search:'10 px'},
                {value:30, name:'30 r-px ', search:'30 px'},
                {value:50, name:'50 r-px ', search:'50 px'},
                {value:100, name:'100 r-px ', search:'100 px'},
                {value:150, name:'150 r-px ', search:'150 px'},
                {value:200, name:'200 r-px ', search:'200 px'},
            ];

            var objs = pCanvas.getObjects();
            var cnt = objs.length;
            var index = 0;
            var canvasSSA = document.getElementById('ssCanvasA');
            var canvasStream = canvasSSA.captureStream();

            recorder = new MediaRecorder(canvasStream);

            recorder.ondataavailable = function(evt) {
                var videoBlob = new Blob([evt.data], { type: evt.data.type });
                blobUrl = window.URL.createObjectURL(videoBlob);

                recordedVideo = getRecordedVideoObject();

                recordedVideo.getElement().addEventListener('timeupdate', function() {
                    var currentTime = recordedVideo.getElement().currentTime;
                    var durationTime = recordedVideo.getElement().duration;

                    if (Infinity === durationTime) {
                        durationTime = 'Calculating...';
                    }

                    $('#capture_recorded_time').text(currentTime + ' / ' + durationTime);
                }, false);
            }

            for (var i = 0; i < cnt; i++) {
                if ('image' === objs[i].type && !isVideo(objs[i].getSrc()) && !isWebCam(objs[i].getSrc())) {
                    var copyScaleX = objs[i].scaleX;
                    var copyScaleY = objs[i].scaleY;

                    fabric.Image.fromURL(objs[i].getSrc(), function(img) {
                        var image = img.set(
                                {
                                    scaleX: copyScaleX,
                                    scaleY: copyScaleY,
                                });

                        image.on('mouseup:before', function(opt) {
                            if (clickObjectContextmenu === opt.e.which) {
                                $('#animate_object_menu').trigger('contextmenu');
                            }
                        });

                        image.id = i;

                        ssCanvasB.add(image);
                    });
                } else {
                    var obj = objs[i];

                    obj.clone(function(cloned) {
                        var video = copyVideoObject(obj, true);

                        if (null != video) {
                            cloned = video;

                            fabric.util.requestAnimFrame(function render() {
                                ssCanvasB.renderAll();
                                fabric.util.requestAnimFrame(render);
                            });
                        }

                        cloned.on('mouseup:before', function(opt) {
                            if (clickObjectContextmenu === opt.e.which) {
                                $('#animate_object_menu').trigger('contextmenu');
                            }
                        });

                        cloned.id = i;

                        ssCanvasB.add(cloned);
                    });
                }

                ssCanvasB.renderAll();
            }

            (function animate() {
                animates();

                ssCanvasA.renderAll();
                fabric.util.requestAnimFrame(animate);
            })();

            $(function(){
                $('.selector_interval').smSearchInputSelector({
                    uniquename : 'selector_interval',
                    selector : selectInterval,
                    selected : function (value) {
                        if (isNumber(value)) {
                            timing = ANIMATE_TIME_BASE * value;
                        } else {
                            timing = 0;
                        }
                    }
                });

                $('.selector_speed').smSearchInputSelector({
                    uniquename : 'selector_speed',
                    selector : selectSpeed,
                    selected : function (value) {
                        if (isNumber(value)) {
                            speed = value;
                        } else {
                            speed = 1;
                        }

                        radiusSpeed = baseRadiusSpeed * speed;
                    }
                });

                $('.selector_radius').smSearchInputSelector({
                    uniquename : 'selector_radius',
                    selector : selectRadius,
                    selected : function (value) {
                        if (isNumber(value)) {
                            radius = value;
                        } else {
                            radius = 50;
                        }
                    }
                });
            });

            $(function() {
                $('#play').on('click', function() {
                    isPause = false;
                    $('#pause').text('Pause');
                    startAnimate();

                    /*timer = setInterval(function() {
                        startAnimate();
                    }, 1000 * 5);*/
                });

                $('#pause').on('click', function() {
                    if (!isPause) {
                        isPause = true;
                        $('#pause').text('RePlay');
                    } else {
                        isPause = false;
                        $('#pause').text('Pause');
                    }

                    if (null != timer) {
                        clearInterval(timer);
                    }
                });

                $('#select_animate_type').change(function() {
                    selectAnimateType = $('#select_animate_type').val();
                });

                $('#select_animate_direction').change(function() {
                    selectAnimateDirection = $('#select_animate_direction').val();

                    var objs = ssCanvasA.getObjects();
                    var obj = null;

                    if (0 < objs.length) {
                        obj = objs[0];
                    } else {
                        return;
                    }

                    var updateDirection = null;

                    switch (selectAnimateDirection) {
                        case ANIMATE_DIRECTION_RIGHT_BOTTOM:
                        case ANIMATE_DIRECTION_LEFT_BOTTOM:
                        case ANIMATE_DIRECTION_BOTTOM:
                        case ANIMATE_DIRECTION_LEFT:
                        case ANIMATE_DIRECTION_RIGHT:
                            if (-1 !== obj.name.indexOf(ANIMATE_UP)) {
                                updateDirection = ANIMATE_DOWN;
                            }
                            break;
                        case ANIMATE_DIRECTION_RIGHT_TOP:
                        case ANIMATE_DIRECTION_LEFT_TOP:
                        case ANIMATE_DIRECTION_TOP:
                            if (-1 !== obj.name.indexOf(ANIMATE_DOWN)) {
                                updateDirection = ANIMATE_UP;
                            }
                            break;
                    }

                    if (null != updateDirection) {
                        objs.forEach(function(obj) {
                            obj.name = animateObjName + updateDirection;
                        });
                    }
                });

                $('#capture_record_start').on('click', function() {
                    var state = $('#capture_record_start').css('background-image');

                    if (-1 !== state.indexOf('reg_off.png')) {
                        recorder.start();
                        $('#capture_record_start').css('background-image', "url('./../img/reg_on.png')");
                    }
                });

                $('#capture_record_stop').on('click', function() {
                    var state = $('#capture_record_stop').css('background-image');

                    if (-1 !== state.indexOf('stop_off.png')) {
                        if ('recording' === recorder.state || 'paused' === recorder.state) {
                            recorder.stop();
                            $('#capture_record_start').css('background-image', "url('./../img/reg_off.png')");
                            $('#capture_record_pause').css('background-image', "url('./../img/pause_off.png')");
                        }
                    }
                });

                $('#capture_record_pause').on('click', function() {
                    var state = $('#capture_record_pause').css('background-image');

                    if (-1 !== state.indexOf('pause_off.png')) {
                        if ('recording' === recorder.state) {
                            recorder.pause();
                            $('#capture_record_pause').css('background-image', "url('./../img/pause_on.png')");
                        }
                    } else {
                        if ('paused' === recorder.state) {
                            recorder.resume();
                            $('#capture_record_pause').css('background-image', "url('./../img/pause_off.png')");
                        }
                    }
                });

                $('#capture_recorded_start').on('click', function() {
                    if (null == blobUrl) {
                        return;
                    }

                    var state = $('#capture_recorded_start').css('background-image');

                    if (-1 !== state.indexOf('start_off.png')) {
                        ssCanvasB.add(recordedVideo)

                        recordedVideo.getElement().play();

                        fabric.util.requestAnimFrame(function render() {
                            ssCanvasB.renderAll();
                            fabric.util.requestAnimFrame(render);
                        });

                        $('#capture_recorded_start').css('background-image', "url('./../img/start_on.png')");
                        $('#capture_recorded_pause').css('background-image', "url('./../img/pause_off.png')");
                    }
                });

                $('#capture_recorded_stop').on('click', function() {
                    if (null == blobUrl) {
                        return;
                    }

                    var state = $('#capture_recorded_stop').css('background-image');

                    if (-1 !== state.indexOf('stop_off.png')) {
                        recordedVideo.getElement().pause();
                        recordedVideo.getElement().currentTime = 0;
                        $('#capture_recorded_start').css('background-image', "url('./../img/start_off.png')");
                        $('#capture_recorded_pause').css('background-image', "url('./../img/pause_off.png')");
                    }
                });

                $('#capture_recorded_pause').on('click', function() {
                    if (null == blobUrl) {
                        return;
                    }

                    var state = $('#capture_recorded_pause').css('background-image');

                    if (-1 !== state.indexOf('pause_off.png')) {
                        recordedVideo.getElement().pause();
                        $('#capture_recorded_start').css('background-image', "url('./../img/start_off.png')");
                        $('#capture_recorded_pause').css('background-image', "url('./../img/pause_on.png')");
                    } else {
                        recordedVideo.getElement().play();
                        $('#capture_recorded_start').css('background-image', "url('./../img/start_on.png')");
                        $('#capture_recorded_pause').css('background-image', "url('./../img/pause_off.png')");
                    }
                });

                $('#capture_recorded_dl').on('click', function() {
                    if (null != blobUrl) {
                        var a = document.createElement('a');
                        a.href = blobUrl;
                        a.download = 'recorded.webm';
                        a.target = '_blank';
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                    }
                });
            });

            $(function() {
                $.contextMenu({
                    selector: '.context-menu-animate',
                    callback: function(key, options) {
                        canvasExceute(key);
                    },
                    items: {
                        'delete': {'name': 'Delete', 'icon': 'delete'},
                        'show': {'name': 'Show', 'icon': 'show'},
                        'animateSetting': {'name': 'AnimateSetting', 'icon': 'animatesetting'},
                        'play': {'name': 'Play', 'icon': 'play'},
                        'pause': {'name': 'Pause', 'icon': 'pause'},
                        'currentToTop': {'name': 'CurrentToTop', 'icon': 'currenttotop'},
                        'currentTimePlus': {'name': 'CurrentTimePlus', 'icon': 'currenttimeplus'},
                        'currentTimeMinus': {'name': 'CurrentTimeMinus', 'icon': 'currenttimeminus'},
                        'upVolume': {'name': 'UpVolume', 'icon': 'upvolume'},
                        'downVolume': {'name': 'DownVolume', 'icon': 'downvolume'},
                        'mute': {'name': 'Mute', 'icon': 'mute'},
                    }
                });

                $('#animate_object_menu').on('click', function(opt) {
                    $('#animate_object_menu').trigger('contextmenu');
                });
            });

            function animateAngleAndSlider(obj) {
                switch (selectAnimateDirection) {
                    case ANIMATE_DIRECTION_RIGHT_BOTTOM:
                        obj.top += speed;
                        obj.left += (obj.movingLeft ? -1 : speed);
                        break;
                    case ANIMATE_DIRECTION_LEFT_BOTTOM:
                        obj.top += speed;
                        obj.left -= (obj.movingLeft ? -1 : speed);
                        break;
                    case ANIMATE_DIRECTION_RIGHT_TOP:
                        obj.top -= speed;
                        obj.left += (obj.movingLeft ? -1 : speed);
                        break;
                    case ANIMATE_DIRECTION_LEFT_TOP:
                        obj.top -= speed;
                        obj.left -= (obj.movingLeft ? -1 : speed);
                        break;
                    case ANIMATE_DIRECTION_RIGHT:
                        obj.left += (obj.movingLeft ? -1 : speed);
                        break;
                    case ANIMATE_DIRECTION_LEFT:
                        obj.left -= (obj.movingLeft ? -1 : speed);
                        break;
                    case ANIMATE_DIRECTION_TOP:
                        obj.top -= speed;
                        break;
                    case ANIMATE_DIRECTION_BOTTOM:
                        obj.top += speed;
                        break;
                }

                return obj;
            }

            function animateAngle(obj) {
                obj = animateAngleAndSlider(obj);

                if (obj.left > (ANIMATE_CANVAS_WIDTH + obj.width) || obj.left < (-100 + (obj.width * -1)) || obj.top > (ANIMATE_CANVAS_HEIGHT + obj.height)) {
                    if (isAnimateLoop) {
                        obj.top = 0;
                        obj.left = 0;
                    } else {
                        ssCanvasA.remove(obj);
                    }
                } else {
                    obj.rotate(obj.get(ANIMATE_TYPE_ANGLE) + 2);
                }
            }

            function animateSlider(obj) {
                obj = animateAngleAndSlider(obj);

                if (obj.left > (ANIMATE_CANVAS_WIDTH + obj.width) || obj.left < (-100 + (obj.width * -1)) || obj.top > (ANIMATE_CANVAS_HEIGHT + obj.height)) {
                    if (isAnimateLoop) {
                        obj.top = 0;
                        obj.left = 0;
                    } else {
                        ssCanvasA.remove(obj);
                    }
                }
            }

            function animateWave(obj) {
                if (undefined == obj.name) {
                    return obj;
                }

                switch (selectAnimateDirection) {
                    case ANIMATE_DIRECTION_RIGHT:
                    case ANIMATE_DIRECTION_BOTTOM:
                    case ANIMATE_DIRECTION_RIGHT_BOTTOM:
                        if (-1 !== obj.name.indexOf(ANIMATE_DOWN) && (ANIMATE_CANVAS_HEIGHT - obj.height) > obj.top) {
                            obj.top += speed;
                        } else {
                            obj.name = animateObjName + ANIMATE_UP;
                        }

                        if (-1 !== obj.name.indexOf(ANIMATE_UP) && 0 < obj.top) {
                            obj.top -= speed;
                        } else {
                            obj.name = animateObjName + ANIMATE_DOWN;
                        }

                        if (ANIMATE_CANVAS_WIDTH > obj.left) {
                            obj.left += speed;
                        } else {
                            obj.left = 0;
                        }
                        break;
                    case ANIMATE_DIRECTION_LEFT:
                    case ANIMATE_DIRECTION_LEFT_BOTTOM:
                        if (-1 !== obj.name.indexOf(ANIMATE_DOWN) && (ANIMATE_CANVAS_HEIGHT - obj.height) > obj.top) {
                            obj.top += speed;
                        } else {
                            obj.name = animateObjName + ANIMATE_UP;
                        }

                        if (-1 !== obj.name.indexOf(ANIMATE_UP) && 0 < obj.top) {
                            obj.top -= speed;
                        } else {
                            obj.name = animateObjName + ANIMATE_DOWN;
                        }

                        if (0 < obj.left) {
                            obj.left -= speed;
                        } else {
                            obj.left = ANIMATE_CANVAS_WIDTH;
                        }
                        break;
                    case ANIMATE_DIRECTION_TOP:
                    case ANIMATE_DIRECTION_RIGHT_TOP:
                        if (-1 !== obj.name.indexOf(ANIMATE_DOWN) && (ANIMATE_CANVAS_HEIGHT - obj.height) > obj.top) {
                            obj.top += speed;
                        } else {
                            obj.name = animateObjName + ANIMATE_UP;
                        }

                        if (-1 !== obj.name.indexOf(ANIMATE_UP) && 0 < obj.top) {
                            obj.top -= speed;
                        } else {
                            obj.name = animateObjName + ANIMATE_DOWN;
                        }

                        if (ANIMATE_CANVAS_WIDTH > obj.left) {
                            obj.left += speed;
                        } else {
                            obj.left = 0;
                        }
                        break;
                    case ANIMATE_DIRECTION_LEFT_TOP:
                        if (-1 !== obj.name.indexOf(ANIMATE_DOWN) && (ANIMATE_CANVAS_HEIGHT - obj.height) > obj.top) {
                            obj.top += speed;
                        } else {
                            obj.name = animateObjName + ANIMATE_UP;
                        }

                        if (-1 !== obj.name.indexOf(ANIMATE_UP) && 0 < obj.top) {
                            obj.top -= speed;
                        } else {
                            obj.name = animateObjName + ANIMATE_DOWN;
                        }

                        if (0 < obj.left) {
                            obj.left -= speed;
                        } else {
                            obj.left = ANIMATE_CANVAS_WIDTH;
                        }
                        break;
                }

                if (obj.left > (ANIMATE_CANVAS_WIDTH + obj.width) || obj.left < (-100 + (obj.width * -1)) || obj.top > (ANIMATE_CANVAS_HEIGHT + obj.height)) {
                    if (isAnimateLoop) {
                        obj.top = ANIMATE_CANVAS_HEIGHT / 2;
                        obj.left = 0;
                    } else {
                        ssCanvasA.remove(obj);
                    }
                }
            }

            function animateCircle(obj) {
                var objWidthCenter = ANIMATE_CANVAS_WIDTH / 2;
                var objHeightCenter = ANIMATE_CANVAS_HEIGHT / 2;

                if (0 < posXs[obj.id]) {
                    objWidthCenter = posXs[obj.id];
                }

                if (0 < posYs[obj.id]) {
                    objHeightCenter = posYs[obj.id];
                }

                switch (selectAnimateDirection) {
                    case ANIMATE_DIRECTION_RIGHT:
                    case ANIMATE_DIRECTION_BOTTOM:
                    case ANIMATE_DIRECTION_RIGHT_BOTTOM:
                    case ANIMATE_DIRECTION_LEFT_BOTTOM:
                        obj.left = (objWidthCenter - obj.width) + Math.cos((time / animateObjCnt) * radiusSpeed) * radius;
                        obj.top = (objHeightCenter - obj.height) + Math.sin((time / animateObjCnt) * radiusSpeed) * radius;
                        break;
                    case ANIMATE_DIRECTION_LEFT:
                    case ANIMATE_DIRECTION_TOP:
                    case ANIMATE_DIRECTION_RIGHT_TOP:
                    case ANIMATE_DIRECTION_LEFT_TOP:
                        obj.left = (objWidthCenter - obj.width) + Math.sin((time / animateObjCnt) * radiusSpeed) * radius;
                        obj.top = (objHeightCenter - obj.height) + Math.cos((time / animateObjCnt) * radiusSpeed) * radius;
                        break;
                }

                if (obj.left > (ANIMATE_CANVAS_WIDTH + obj.width) || obj.left < (-100 + (obj.width * -1)) || obj.top > (ANIMATE_CANVAS_HEIGHT + obj.height)) {
                    if (isAnimateLoop) {
                        obj.top = ANIMATE_CANVAS_HEIGHT / 2;
                        obj.left = ANIMATE_CANVAS_WIDTH / 2;
                    } else {
                        ssCanvasA.remove(obj);
                    }
                }
            }

            function animates() {
                ssCanvasA.getObjects().concat().forEach(function(obj) {
                    if (isPause) {
                        return;
                    }

                    if (getIntervalState()) {
                        return;
                    }

                    var selectType = null;

                    if (undefined != obj.animateType) {
                        selectType = obj.animateType;
                    } else {
                        selectType = selectAnimateType;
                    }

                    switch (selectType) {
                        case ANIMATE_TYPE_ANGLE:
                            animateAngle(obj);
                            break;
                        case ANIMATE_TYPE_SLIDER:
                            animateSlider(obj);
                            break;
                        case ANIMATE_TYPE_WAVE:
                            animateWave(obj);
                            break;
                        case ANIMATE_TYPE_CIRCLE:
                            animateCircle(obj);
                            break;
                    }
                });
            }

            function getIntervalState() {
                if (0 == time % timing) {
                    timeCnt++;
                }

                if (0 == time % timing || 0 == timeCnt % 2) {
                    time++;
                    return true;
                }

                time++;

                return false;
            }

            function animateObject(no, obj, type, posX, posY, cPosX, sPosX, ePosX, durationTime) {
                obj.top = posY;
                obj.left = posX;

                /*if ('left' === type && ePosX === obj.left) {
                    obj.left = sPosX;
                } else if ('right' === type && ePosX === obj.left) {
                    obj.left = sPosX;
                }*/

                ssCanvasA.add(obj);

                /*if ('left' === type) {
                    ssCanvasA.item(no).animate('left', ssCanvasA.item(no).left === cPosX ? sPosX : ePosX, {
                        duration: durationTime,
                        onChange: ssCanvasA.renderAll.bind(ssCanvasA),
                        easing: fabric.util.ease.easeOutBounce,
                    });
                } else if ('right' === type) {
                    ssCanvasA.item(no).animate('left', ssCanvasA.item(no).left === cPosX ? sPosX : ePosX, {
                        duration: durationTime,
                        onChange: ssCanvasA.renderAll.bind(ssCanvasA),
                        easing: fabric.util.ease.easeOutBounce,
                    });
                } else if ('angle' === type) {
                    ssCanvasA.item(no).animate('angle', ssCanvasA.item(no).angle === cPosX ? sPosX : ePosX, {
                        duration: durationTime,
                        onChange: ssCanvasA.renderAll.bind(ssCanvasA),
                        easing: fabric.util.ease.easeOutBounce,
                    });
                }*/
            }

            function startAnimate() {
                var acw = ANIMATE_CANVAS_WIDTH;
                var ach = ANIMATE_CANVAS_HEIGHT / 2;

                var types = ['left', 'right', 'left', 'right', 'angle'];
                var animateTypes = [];
                var cPosXs = [200, 200, 200, 200, 180];
                var sPosXs = [0, acw, 0, acw, 260];
                var ePosXs = [acw, 0, acw, 0, 325];
                var durationTimes = [1000, 1000, 2000, 2000, 3000];
                var typeCnt = types.length
                var posCnt = posXs.length;
                var objCnt = ssCanvasB.getObjects().length;
                var animateTypesCnt = 0;
                var objIndex = 0;
                var typeIndex = 0;
                var posIndex = 0;
                var animateTypesIndex = 0;
                var obj = null;
                var animateDirection = null;

                animateObjCnt = objCnt;

                if (ANIMATE_TYPE_ANGLE === selectAnimateType || ANIMATE_TYPE_SLIDER === selectAnimateType) {
                    switch (selectAnimateDirection) {
                        case ANIMATE_DIRECTION_RIGHT:
                        case ANIMATE_DIRECTION_RIGHT_BOTTOM:
                            posXs = [0, 0, 0, 0, 0, 0, 0, 0, 0];
                            posYs = [0, 50, 100, 150, 200, 250, 300, 350, 400];
                            break;
                        case ANIMATE_DIRECTION_LEFT:
                        case ANIMATE_DIRECTION_LEFT_BOTTOM:
                            posXs = [acw, acw, acw, acw, acw, acw, acw, acw, acw];
                            posYs = [0, 50, 100, 150, 200, 250, 300, 350, 400];
                            break;
                        case ANIMATE_DIRECTION_RIGHT_TOP:
                            posXs = [0, 0, 0, 0, 0, 0, 0, 0, 0];
                            posYs = [450, 400, 350, 300, 250, 200, 150, 100, 50];
                            break;
                        case ANIMATE_DIRECTION_LEFT_TOP:
                            posXs = [acw, acw, acw, acw, acw, acw, acw, acw, acw];
                            posYs = [450, 400, 350, 300, 250, 200, 150, 100, 50];
                            break;
                        case ANIMATE_DIRECTION_TOP:
                            posXs = [450, 400, 350, 300, 250, 200, 150, 100, 50];
                            posYs = [450, 400, 350, 300, 250, 200, 150, 100, 50];
                            break;
                        case ANIMATE_DIRECTION_BOTTOM:
                            posXs = [0, 50, 100, 150, 200, 250, 300, 350, 400];
                            posYs = [0, 50, 100, 150, 200, 250, 300, 350, 400];
                            break;
                    }

                    animateTypes = [selectAnimateType];
                } else if (ANIMATE_TYPE_WAVE === selectAnimateType) {
                    switch (selectAnimateDirection) {
                        case ANIMATE_DIRECTION_RIGHT:
                        case ANIMATE_DIRECTION_BOTTOM:
                        case ANIMATE_DIRECTION_RIGHT_BOTTOM:
                            posXs = [0, 50, 100, 150, 200, 250, 300, 350, 400];
                            posYs = [ach, ach + 15, ach + 30, ach + 45, ach + 60, ach + 75, ach + 90, ach + 105, ach + 120];
                            animateDirection = ANIMATE_DOWN;
                            break;
                        case ANIMATE_DIRECTION_LEFT:
                        case ANIMATE_DIRECTION_LEFT_BOTTOM:
                            posXs = [450, 400, 350, 300, 250, 200, 150, 100, 50];
                            posYs = [ach, ach + 15, ach + 30, ach + 45, ach + 60, ach + 75, ach + 90, ach + 105, ach + 120];
                            animateDirection = ANIMATE_DOWN;
                            break;
                        case ANIMATE_DIRECTION_TOP:
                        case ANIMATE_DIRECTION_RIGHT_TOP:
                            posXs = [0, 50, 100, 150, 200, 250, 300, 350, 400];
                            posYs = [ach, ach - 15, ach - 30, ach - 45, ach - 60, ach - 75, ach - 90, ach - 105, ach - 120];
                            animateDirection = ANIMATE_UP;
                            break;
                        case ANIMATE_DIRECTION_LEFT_TOP:
                            posXs = [450, 400, 350, 300, 250, 200, 150, 100, 50];
                            posYs = [ach, ach - 15, ach - 30, ach - 45, ach - 60, ach - 75, ach - 90, ach - 105, ach - 120];
                            animateDirection = ANIMATE_UP;
                            break;
                    }

                    animateTypes = [selectAnimateType];
                } else if (ANIMATE_TYPE_CIRCLE === selectAnimateType) {
                    posXs = [100, 150, 200, 250, 300, 350, 400, 450, 500];
                    posYs = [ach, ach, ach, ach, ach, ach, ach, ach, ach];
                    animateTypes = [selectAnimateType];
                } else if (ANIMATE_TYPE_INDIVIDUAL === selectAnimateType) {
                    posXs = [100, 150, 200, 250, 300, 350, 400, 450, 500];
                    posYs = [ach, ach, ach, ach, ach, ach, ach, ach, ach];
                    animateTypes = [
                        ANIMATE_TYPE_ANGLE, ANIMATE_TYPE_SLIDER, ANIMATE_TYPE_WAVE, ANIMATE_TYPE_CIRCLE,
                        ANIMATE_TYPE_ANGLE, ANIMATE_TYPE_SLIDER, ANIMATE_TYPE_WAVE, ANIMATE_TYPE_CIRCLE,
                        ANIMATE_TYPE_ANGLE,
                    ];
                }

                if (0 < animateSettingPosXs.length) {
                    posXs = animateSettingPosXs;
                }

                if (0 < animateSettingPosYs.length) {
                    posYs = animateSettingPosYs;
                }

                if (0 < animateSettingTypes.length) {
                    animateTypes = animateSettingTypes;
                }

                posCnt = posXs.length;
                animateTypesCnt = animateTypes.length;

                ssCanvasA.clear();

                for (var i = 0; i < objCnt; i++) {
                    obj = ssCanvasB.getObjects()[i];

                    if ('image' === obj.type && !isVideo(obj.getSrc()) && !isWebCam(obj.getSrc())) {
                        var copyScaleX = obj.scaleX;
                        var copyScaleY = obj.scaleY;

                        fabric.Image.fromURL(obj.getSrc(), function(img) {
                            var image = img.set({
                                id: posIndex,
                                animateType: animateTypes[animateTypesIndex],
                                name: animateObjName + animateDirection,
                                scaleX: copyScaleX,
                                scaleY: copyScaleY,
                            });

                            image.setControlsVisibility({
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

                            animateObject(objIndex, image, types[typeIndex], posXs[posIndex], posYs[posIndex], cPosXs[typeIndex], sPosXs[typeIndex], ePosXs[typeIndex], durationTimes[typeIndex]);

                            objIndex++;
                            typeIndex++;
                            posIndex++;
                            animateTypesIndex++;

                            if (typeCnt <= typeIndex) {
                                typeIndex = 0;
                            }

                            if (posCnt <= posIndex) {
                                posIndex = 0;
                            }

                            if (animateTypesCnt <= animateTypesIndex) {
                                animateTypesIndex = 0;
                            }
                        });
                    } else {
                        obj.clone(function(cloned) {
                            var video = copyVideoObject(obj, true);

                            if (null != video) {
                                if (!obj.getElement().paused) {
                                    video.getElement().currentTime = obj.getElement().currentTime;
                                    video.getElement().play();
                                }

                                cloned = video;
                            }

                            cloned.id = posIndex;
                            cloned.name = animateObjName + animateDirection;
                            cloned.animateType = animateTypes[animateTypesIndex];

                            cloned.setControlsVisibility({
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

                            animateObject(objIndex, cloned, types[typeIndex], posXs[posIndex], posYs[posIndex], cPosXs[typeIndex], sPosXs[typeIndex], ePosXs[typeIndex], durationTimes[typeIndex]);

                            objIndex++;
                            typeIndex++;
                            posIndex++;
                            animateTypesIndex++;

                            if (typeCnt <= typeIndex) {
                                typeIndex = 0;
                            }

                            if (posCnt <= posIndex) {
                                posIndex = 0;
                            }

                            if (animateTypesCnt <= animateTypesIndex) {
                                animateTypesIndex = 0;
                            }
                        });
                    }
                }

                fabric.util.requestAnimFrame(function render() {
                    ssCanvasA.renderAll();
                    fabric.util.requestAnimFrame(render);
                });
            }

            function canvasExceute(key) {
                switch (key) {
                    case 'delete':
                        canvasObjectDelete(ssCanvasB);
                        break;
                    case 'show':
                        showCanvasObjects(ssCanvasB);
                        break;
                    case 'animateSetting':
                        animateSettingObject(ssCanvasB);
                        break;
                    case 'play':
                        canvasObjectPlay(ssCanvasB);
                        break;
                    case 'pause':
                        canvasObjectPause(ssCanvasB);
                        break;
                    case 'currentToTop':
                        canvasObjectCurrentToTop(ssCanvasB);
                        break;
                    case 'currentTimePlus':
                        canvasObjectCurrentAddTime(ssCanvasB, currentTimePlus);
                        break;
                    case 'currentTimeMinus':
                        canvasObjectCurrentAddTime(ssCanvasB, currentTimeMinus);
                        break;
                    case 'upVolume':
                        canvasObjectUpVolume(ssCanvasB);
                        break;
                    case 'downVolume':
                        canvasObjectDownVolume(ssCanvasB);
                        break;
                    case 'mute':
                        canvasObjectMute(ssCanvasB);
                        break;
                }
            }

            function canvasObjectDelete(canvas) {
                if (!canvas.getActiveObject()) {
                    return;
                }

                var obj = canvas.getActiveObject();

                canvas.remove(obj);
            }

            function showCanvasObjects(canvas) {
                if (!canvas.getActiveObject()) {
                    return;
                }

                var obj = canvas.getActiveObject();

                alert(JSON.stringify(obj));
            }

            function animateSettingObject(canvas) {
                if (!canvas.getActiveObject()) {
                    return;
                }

                var obj = canvas.getActiveObject();

                if (undefined != obj.id) {
                    if ($('#text_posx').val() && $('#text_posy').val() && $('#select_animate_type').val()) {
                        animateSettingPosXs[obj.id] = $('#text_posx').val();
                        animateSettingPosYs[obj.id] = $('#text_posy').val();
                        animateSettingTypes[obj.id] = $('#select_animate_type').val();
                    }
                }
            }

            function canvasObjectPlay(canvas) {
                var obj = getViedoObject(canvas);

                if (null != obj) {
                    obj.getElement().play();
                }
            }

            function canvasObjectPause(canvas) {
                var obj = getViedoObject(canvas);

                if (null != obj) {
                    obj.getElement().pause();
                }
            }

            function canvasObjectCurrentToTop(canvas) {
                var obj = getViedoObject(canvas);

                if (null != obj) {
                    obj.getElement().currentTime = 0;
                }
            }

            function canvasObjectCurrentAddTime(canvas, addTime) {
                var obj = getViedoObject(canvas);

                if (null != obj && obj.getElement().duration > obj.getElement().currentTime) {
                    obj.getElement().currentTime = obj.getElement().currentTime + addTime;
                }
            }

            function canvasObjectUpVolume(canvas) {
                var obj = getViedoObject(canvas);

                if (null != obj) {
                    obj.getElement().volume = obj.getElement().volume + addVolume;
                }
            }

            function canvasObjectDownVolume(canvas) {
                var obj = getViedoObject(canvas);

                if (null != obj && 0 < (obj.getElement().volume - addVolume)) {
                    obj.getElement().volume = obj.getElement().volume - addVolume;
                }
            }

            function canvasObjectMute(canvas) {
                var obj = getViedoObject(canvas);

                if (null != obj) {
                    obj.getElement().muted = obj.getElement().muted ? false : true;
                }
            }

            function getViedoObject(canvas) {
                var obj = null;

                if (!canvas.getActiveObject()) {
                    return obj;
                }

                var obj = canvas.getActiveObject();

                if ('image' !== obj.type || !isVideo(obj.getSrc())) {
                    obj = null;
                }

                return obj;
            }

            function getRecordedVideoObject() {
                var videoEl = document.createElement('video');

                videoEl.setAttribute('src', blobUrl);
                videoEl.setAttribute('width', ANIMATE_CANVAS_WIDTH);
                videoEl.setAttribute('height', ANIMATE_CANVAS_HEIGHT);
                videoEl.setAttribute('controls', false);

                var video = new fabric.Image(videoEl, {
                    top: objTop,
                    left: objLeft,
                    scaleX: objScaleX,
                    scaleY: objScaleY,
                    objectCaching: objObjectCaching,
                });

                return video;
            }

            function createVideoElement(no, src, controls) {
                var video = document.createElement('video');

                video.setAttribute('id', videoCopyName + no);
                video.setAttribute('src', src);
                video.setAttribute('width', document.getElementById('video').width);
                video.setAttribute('height', document.getElementById('video').height);
                video.setAttribute('controls', controls);

                copyVideoElement[no] = video;

                $('#video_copy_div').append(video);

                return video;
            }

            function copyVideoObject(obj, isForced) {
                var video = null;

                if (!isForced && 'image' === obj.type && (isVideo(obj.getSrc()) || isWebCam(obj.getSrc()))) {
                    return obj;
                }

                if (null != obj && 'image' === obj.type && isVideo(obj.getSrc())) {
                    var videoName = videoCopyName;
                    var currentNo = copyVideoElement.length;

                    videoName += currentNo;

                    var videoEl = createVideoElement(currentNo, obj.getSrc(), false);

                    var video = new fabric.Image(videoEl, {
                        name: videoName,
                        top: obj.top,
                        left: obj.left,
                        angle: obj.angle,
                        opacity: obj.opacity,
                        originX: obj.originX,
                        originY: obj.originY,
                        flipX: obj.flipX,
                        flipY: obj.flipY,
                        objectCaching: obj.objectCaching,
                    });
                }

                return video;
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

            function isNumber(value) {
                var regex = new RegExp(/^[-+]?[0-9]+(\.[0-9]+)?$/);
                return regex.test(value);
            }

        </script>
    </body>
</html>