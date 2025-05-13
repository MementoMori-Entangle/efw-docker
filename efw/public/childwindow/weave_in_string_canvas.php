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
        <script type="text/javascript" src="./../js/languageArray.js"></script>
        <script type="text/javascript" src="./../js/color16Array.js"></script>
        <link rel="stylesheet" href="./../css/gcss20181102.css">
        <link rel="stylesheet" href="./../css/jquery-ui.css">
        <link rel="stylesheet" href="./../css/jquery.contextMenu.css">
        <link rel="stylesheet" href="./../css/fabric.css">
        <link rel="stylesheet" href="./../css/normalize.css">
        <link rel="stylesheet" href="./../css/milligram.css">
    </head>
    <body>
        <div class="container">
            <div class="context-menu-weave" id="weave_string_menu">
                Weave in string canvas
            </div>
            <div class="weave_button_container">
                <button type="button" id="draw">Draw</button>
                <button type="button" id="load">Load</button>
                <select id="weave_select" class="input_size_100"></select>
                <select id="color_select" class="input_size_150">
                    <option value="customize_color">Default color</option>
                    <option value="japanese_color">Japanese color</option>
                    <option value="primary_color">Primary color</option>
                    <option value="western_color">Western color</option>
                </select>
            </div>
            <div class="weave_canvas_container">
                <img class="frame_img" src="./../img/frame.png">
                <canvas id="weaveCanvas" width="640" height="480"></canvas>
            </div>
            <div class="weave_string_container">
                <textarea id="weave_string" rows="5" cols="75"></textarea>
            </div>
            <form action="/fabric" name="formWin" id="formWin" method="POST" class="form-horizontal" enctype="multipart/form-data">
                <input type="hidden" name="load_mode" id="load_mode" value="" />
                <input type="hidden" name="upload_mode" id="upload_mode" value="" />
                <input type="hidden" name="file_name" id="file_name" value="" />
                <input type="hidden" name="mime_type" id="mime_type" value="" />
                <input type="hidden" name="img_physics_name" id="img_physics_name" value="" />
                <input type="hidden" name="svg_physics_name" id="svg_physics_name" value="" />
                <input type="hidden" name="upload_dl_data" id="upload_dl_data" value="" />
                <input type="hidden" name="upload_dl_ext" id="upload_dl_ext" value="" />
            </form>
        </div>

        <script type="text/javascript">
            const WEAVE_CANVAS_WIDTH = 640;
            const WEAVE_CANVAS_HEIGHT = 480;
            const BASE_MAGNIFICATION = 3;
            const ANCHOR_CLICK_OVER_LENGTH = 1024 * 1900;
            const NO_MEANING_STRING = '{#Thereisnomeaning.}';
            const NOT_STRING_REPLACEMENT = '?';
            const UPLOAD_WEAVE_PATH = './../upload/weave/';

            var saveSVGFileName = 'save.svg';
            var savePNGFileName = 'save.png';
            var conversionImageMimeType = 'image/png';
            var clickObjectContextmenu = 3;
            var objTop = 10;
            var objLeft = 10;
            var objStrokeWidth = 10;
            var objX1 = 0;
            var objY1 = 0;
            var objX2 = 0;
            var objY2 = 0;
            var downloadSetTime = 250;
            var isClickOverUpload = true;

            var weaveCanvas = new fabric.Canvas('weaveCanvas');

            var magnification = BASE_MAGNIFICATION;
            var isHeightLimit = false;
            var isMarginFill = true;
            var isNotStringReplacement = true;
            var notStringReplacement = '';
            var imgBase64 = null;

            var weaveFiles = [];
            var colorData = getColorData(CUSTOMIZE_COLOR_KEY);
            var stringPosData = getLanguageData(LANG_ALL_KEY);
            var lineData = createLineData();

            loadWeaveSVG();

            setTimeout(function() {
                var options = $.map(weaveFiles, function(name, value) {
                    var $option = $('<option>', { value: name, text: name });

                    return $option;
                });

                $('#weave_select').append(options);
            }, 500);

            $(function() {
                $('#draw').on('click', function() {
                    objX1 = 0;
                    objY1 = 0;
                    objX2 = 0;
                    objY2 = 0;

                    notStringReplacement = '';

                    startAnimate();
                });

                $('#load').on('click', function() {
                    var fileName = $('#weave_select').val();

                    if (fileName.match(/\.(svg)$/i)) {
                        loadSVG(fileName);
                    } else {
                        $('#file_name').val(fileName);
                        $('#mime_type').val(conversionImageMimeType);

                        loadWeaveImage();

                        setTimeout(function() {
                            var imageData = null;

                            if (null == imgBase64) {
                                imageData = UPLOAD_WEAVE_PATH + fileName;
                                alert(imageData);
                            } else {
                                imageData = imgBase64;
                            }

                            loadImage(imageData);
                        }, 500);
                    }
                });

                $('#color_select').change(function() {
                    colorData = getColorData($('#color_select').val());
                    lineData = createLineData();
                });
            });

            $(function() {
                $.contextMenu({
                    selector: '.context-menu-weave',
                    callback: function(key, options) {
                        canvasExceute(key);
                    },
                    items: {
                        'clear': {'name': 'Clear', 'icon': 'clear'},
                        'imgDL': {'name': 'ImgDL', 'icon': 'imgdl'},
                        'svgDL': {'name': 'SVGDL', 'icon': 'svgdl'},
                    }
                });

                $('#weave_string_menu').on('click', function(opt) {
                    $('#weave_string_menu').trigger('contextmenu');
                });
            });

            function createLineData() {
                var lineData = [];
                var colorLen =  Object.keys(colorData).length;
                var stringLen = Object.keys(stringPosData).length;
                var widthMax = Math.floor(stringLen / colorLen) + 1;
                var index = 0;

                for (var i = 1; i <= widthMax; i++) {
                    for (var j = 0; j < colorLen; j++) {
                        lineData[index] = [i, j];
                        index++;

                        if (stringLen <= index) {
                            i = widthMax + 1;
                            break;
                        }
                    }
                }

                return lineData;
            }

            function startAnimate() {
                weaveCanvas.clear();

                var lineObjs = [];
                var str = $('#weave_string').val();

                if (undefined == str || 0 == str.length) {
                    return;
                }

                var characters = str.split('');
                var cnt = characters.length;

                for (var i = 0; i < cnt; i++) {
                    if (isHeightLimit && (WEAVE_CANVAS_HEIGHT - (objTop + objStrokeWidth)) < objY1) {
                        break;
                    }

                    lineObjs.push(getWeaveLineObjectByCharacter(characters[i]));
                }

                if (isMarginFill && (WEAVE_CANVAS_HEIGHT - objTop) > (objY1 + objStrokeWidth)) {
                    str = NO_MEANING_STRING;

                    characters = str.split('');
                    cnt = characters.length;

                    for (var i = 0; i < cnt; i++) {
                        lineObjs.push(getWeaveLineObjectByCharacter(characters[i]));
                    }

                    while ((WEAVE_CANVAS_HEIGHT - objTop) > (objY1 + objStrokeWidth)) {
                        lineObjs.push(getWeaveLineObjectByCharacter(getRandomCharacters()));
                    }
                }

                if (0 < notStringReplacement.length) {
                    alert(notStringReplacement + ' -> ' + NOT_STRING_REPLACEMENT)
                }

                var group = new fabric.Group(lineObjs, {
                    top: objTop,
                    left: objLeft,
                });

                group.on('mouseup:before', function(opt) {
                    if (clickObjectContextmenu === opt.e.which) {
                        $('#weave_string_menu').trigger('contextmenu');
                    }
                });

                group.setControlsVisibility({
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

                weaveCanvas.add(group);
                weaveCanvas.setActiveObject(group);
            }

            function getRandomCharacters() {
                var value = getRandomNumber(0, (Object.keys(stringPosData).length - 1));

                var c = Object.keys(stringPosData).filter((key) => {
                    return stringPosData[key] === value
                });

                return c;
            }

            function getWeaveLineObjectByCharacter(c) {
                if (isNotStringReplacement && undefined == stringPosData[c]) {
                    notStringReplacement += c;
                    c = NOT_STRING_REPLACEMENT;
                }

                var sPos = stringPosData[c];
                var weaveData = lineData[sPos];

                var lineXS = weaveData[0];
                var lineXC = colorData[weaveData[1]];

                if ((WEAVE_CANVAS_WIDTH - objLeft) <= (objX2 + (lineXS * magnification))) {
                    objX1 = 0;
                    objX2 = 0;
                    objY1 += objStrokeWidth;
                    objY2 += objStrokeWidth;
                }

                objX2 += (lineXS * magnification);

                var line = new fabric.Line([objX1, objY1, objX2, objY2], {
                    strokeWidth: objStrokeWidth,
                    stroke: lineXC,
                });

                objX1 += (lineXS * magnification);

                return line;
            }

            function canvasExceute(key) {
                switch (key) {
                    case 'clear':
                        weaveCanvas.clear();
                        break;
                    case 'imgDL':
                        canvasObjectSaveToImage(weaveCanvas);
                        break;
                    case 'svgDL':
                        canvasObjectSaveToSVG(weaveCanvas);
                        break;
                }
            }

            function loadImage(imageData) {
                fabric.Image.fromURL(imageData, function(img) {
                    var image = img.set({
                        top: objTop,
                        left: objLeft,
                    });

                    image.on('mouseup:before', function(opt) {
                        if (clickObjectContextmenu === opt.e.which) {
                            $('#weave_string_menu').trigger('contextmenu');
                        }
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

                    weaveCanvas.add(image);
                    weaveCanvas.setActiveObject(image);
                });
            }

            function loadSVG(fileName) {
                var filePath = UPLOAD_WEAVE_PATH + fileName;

                fabric.loadSVGFromURL(filePath, function(objects, options) {
                    var loadedObject = fabric.util.groupSVGElements(objects, options);

                    loadedObject.set({
                        top: objTop,
                        left: objLeft,
                    });

                    loadedObject.on('mouseup:before', function(opt) {
                        if (clickObjectContextmenu === opt.e.which) {
                            $('#weave_string_menu').trigger('contextmenu');
                        }
                    });

                    loadedObject.setControlsVisibility({
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

                    loadedObject.setCoords();
                    weaveCanvas.add(loadedObject);
                    weaveCanvas.setActiveObject(loadedObject);
                    weaveCanvas.calcOffset();

                    var cnt = objects.length;

                    if (1 < cnt && 'group' !== loadedObject.type) {
                        return;
                    }

                    var xWidth = 0;
                    var cPos = 0;
                    var lineCnt = 0;
                    var rgbCnt = 0;
                    var color = '';
                    var text = '';
                    var characters = '';
                    var character = '';
                    var rgb = [];
                    var rgbArray = [];

                    for (var i = 0; i < cnt; i++) {
                        xWidth = (objects[i].x2 - objects[i].x1) / magnification;
                        text = objects[i].stroke.replace(new RegExp('rgb', 'g'), '');
                        rgb = text.substr(1, text.length - 2).split(',');

                        rgbCnt = rgb.length;
                        rgbArray = [];

                        for (var j = 0; j < rgbCnt; j++) {
                            rgbArray.push(parseInt(rgb[j]));
                        }

                        color = rgb2hex(rgbArray);

                        cPos = Object.keys(colorData).filter((key) => {
                            return colorData[key] === color
                        });

                        lineCnt = Object.keys(lineData).length;

                        for (var j = 0; j < lineCnt; j++) {
                            if (lineData[j][0] == xWidth && lineData[j][1] == cPos) {

                                character = Object.keys(stringPosData).filter((key) => {
                                    return stringPosData[key] === j
                                });

                                characters += character;
                                break;
                            }
                        }
                    }

                    var removePos = characters.indexOf(NO_MEANING_STRING);

                    characters = characters.substr(0, removePos);

                    $('#weave_string').val(characters);
                });
            }

            function rgb2hex(rgb) {
                return '#' + rgb.map(function(value) {
                    return ('0' + value.toString(16)).slice(-2);
                }).join('');
            }

            function canvasObjectSaveToImage(canvas) {
                var img = canvas.toDataURL(conversionImageMimeType);
                var imgLen = img.length;

                if (ANCHOR_CLICK_OVER_LENGTH < imgLen) {
                    if (isClickOverUpload) {
                        $('#upload_dl_data').val(img);
                        $('#upload_dl_ext').val('png');

                        clickOverFileUpload();

                        setTimeout(function() {
                            var url = UPLOAD_WEAVE_PATH + $('#img_physics_name').val();
                            downloadClick(url, savePNGFileName);
                        }, getTimeoutByUrlLength(imgLen));
                    } else {
                        return;
                    }
                } else {
                    downloadClick(img, savePNGFileName);
                }
            }

            function canvasObjectSaveToSVG(canvas) {
                var svg = unescape(canvas.toSVG());
                var url = 'data:image/svg+xml;utf8,' + svg;
                var urlLen = url.length;

                if (ANCHOR_CLICK_OVER_LENGTH < urlLen) {
                    if (isClickOverUpload) {
                        $('#upload_dl_data').val(svg);
                        $('#upload_dl_ext').val('svg');

                        clickOverFileUpload();

                        setTimeout(function() {
                            url = UPLOAD_WEAVE_PATH + $('#svg_physics_name').val();
                            downloadClick(url, saveSVGFileName);
                        }, getTimeoutByUrlLength(urlLen));
                    } else {
                        return;
                    }
                } else {
                    downloadClick(url, saveSVGFileName);
                }
            }

            function downloadClick(url, fileName) {
                var a = document.createElement('a');
                a.href = url;
                a.download = fileName;
                a.target = '_blank';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            }

            function getTimeoutByUrlLength(len) {
                var cnt = Math.floor(len / (1024 * 1000));

                if (1 > cnt) {
                    cnt = 1;
                }

                return downloadSetTime * cnt;
            }

            function clickOverFileUpload() {
                fileUpload('click_over', null);
            }

            function fileUpload(uploadMode, fileName) {
                $('#upload_mode').val(uploadMode);

                var formData = new FormData($('#formWin').get(0));

                $.ajax({
                    url: './../ajax/uploadFile.php',
                    type:'POST',
                    dataType: 'html',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    async: true,
                }).done(function(data) {
					if (!data.substring(0, 1).match(/^[a-zA-Z0-9]+$/)) {
						data = data.substring(1);
					}

                    var obj = $.parseJSON(data);
                    var keys = Object.keys(obj['info']);
                    var cnt = keys.length;
                    var physicsName = '';

                    if (0 < cnt) {
                        physicsName = obj['info'][keys[0]];
                    }

                    if ('click_over' === uploadMode) {
                        if ('png' === $('#upload_dl_ext').val()) {
                            $('#img_physics_name').val(physicsName);
                        } else if ('svg' === $('#upload_dl_ext').val()) {
                            $('#svg_physics_name').val(physicsName);
                        }
                    }
                }).fail(function() {
                    console.log(data);
                });
            }

            function loadWeaveSVG() {
                $('#load_mode').val('weave_svg');

                var formData = new FormData($('#formWin').get(0));

                $.ajax({
                    url: './../ajax/loadFile.php',
                    type:'POST',
                    dataType: 'html',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    async: true,
                }).done(function(data) {
					if (!data.substring(0, 1).match(/^[a-zA-Z0-9]+$/)) {
						data = data.substring(1);
					}

                    var obj = $.parseJSON(data);

                    var keys = Object.keys(obj['info']);
                    var cnt = keys.length;

                    if (0 < cnt) {
                        for (var i = 0; i < cnt; i++) {
                            weaveFiles.push(obj['info'][keys[i]]);
                        }
                    }
                }).fail(function() {
                    console.log(data);
                });
            }

            function loadWeaveImage() {
                $('#load_mode').val('weave_img');

                var formData = new FormData($('#formWin').get(0));

                $.ajax({
                    url: './../ajax/loadFile.php',
                    type:'POST',
                    dataType: 'html',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    async: true,
                }).done(function(data) {
					if (!data.substring(0, 1).match(/^[a-zA-Z0-9]+$/)) {
						data = data.substring(1);
					}

                    var obj = $.parseJSON(data);

                    imgBase64 = obj['info'];
                }).fail(function() {
                    console.log(data);
                });
            }

            function getRandomNumber(min, max) {
                var random = Math.floor(Math.random() * (max + 1 - min)) + min;

                return random;
            }

        </script>
    </body>
</html>