const BASE_PATH = './';
const UPLOAD_IMG_PATH = BASE_PATH + 'upload/img/';
const UPLOAD_TMP_PATH = BASE_PATH + 'upload/tmp/';
const UPLOAD_SLIDER_IMG_PATH = BASE_PATH + 'upload/slider_img/';
const UPLOAD_SVG_PATH = BASE_PATH + 'upload/svg/';
const UPLOAD_VIDEO_PATH = BASE_PATH + 'upload/video/';
const SLIDER_BACKGROUND_IMAGE_PATH = BASE_PATH + 'img/slider_bg.png';
const SLIDER_IMAGE_NAME_KEY = 'slider_image_';
const CUT_IMAGE_NAME_KEY = 'cut_image_';
const CUT_IMAGE_PATH_NAME_KEY = 'cut_image_path';
const WEB_CAM_NAME_KEY = 'webCam';
const SLIDER_OBJECT_IMAGE_NAME_KEY = 'slider_object_image';
const SLIDER_BTN_IMAGE_NAME_KEY = 'slider_btn_image';
const VIDEO_COPY_NAME_KEY = 'video_copy_'
const COORDINATE_PATH_XY_NAME_KEY = 'coordinate_path_xy_';
const COORDINATE_XY_RECT_NAME_KEY = 'coordinate_xy_rect';
const COPY_CTRL_KEY_CODE_VALUE = 67;
const CUT_CTRL_KEY_CODE_VALUE = 88;
const PASTE_CTRL_KEY_CODE_VALUE = 86;
const DELETE_CTRL_KEY_CODE_VALUE = 68;
const DELETE_KEY_CODE_VALUE = 46;
const BASE_SET_TIMEOUT_MS = 500;
const BASE_THUMBNAIL_SET_TIMEOUT_MS = 100;
const SLIDER_SET_TIMEOUT_COEFFICIENT = 10;
const TMP_CANVAS_WINDOW_WIDTH = 680;
const TMP_CANVAS_WINDOW_HEIGHT = 520;
const PANEL_CANVAS_WINDOW_WIDTH = 900;
const PANEL_CANVAS_WINDOW_HEIGHT = 560;
const IMAGE_DIFF_WINDOW_WIDTH = 1380;
const IMAGE_DIFF_WINDOW_HEIGHT = 950;
const ANIMATE_WINDOW_WIDTH = 800;
const ANIMATE_WINDOW_HEIGHT = 900;
const WEAVE_WINDOW_WIDTH = 700;
const WEAVE_WINDOW_HEIGHT = 900;
const OBJECT_PARAMTER_WINDOW_WIDTH = 680;
const OBJECT_PARAMTER_WINDOW_HEIGHT = 570;
const MB_SIZE_NUMERATOR = 1024 * 1000;
const UPLOAD_FILE_SIZE_NUMERATOR = 1024 * 100;
const ANCHOR_CLICK_OVER_LENGTH = 1024 * 1900;

// Processing definition
var baseCanvas = null;
var tmpCanvas = null;
var panelCanvas = null;
var trimCanvas = null;
var baseFile = null;
var baseFunctionName = null;
var imgBase64 = null;
var clipImage = null;
var tmpObjectData = null;
var baseObjectData = null;
var panelObjectData = null;
var tmpCanvasWin = null;
var paramterCanvas = null;
var sliderObjectIndex = 0;
var dialogViewFlg = false;
var isWebCamCopy = false;
var isStartTargetXY = true;

var canvasHistory = [];
var canvasUndo = [];
var copyVideoElement = [];
var uploadSliderObjects = [];
var sliderObjects = [];
var targetXY = [];
var targetPathXY = [];
var videoThumbnails = [];

// Function setting value
var moveTop = 5;
var moveLeft = 5;
var pasteTop = 10;
var pasteLeft = 10;
var panelWidth = 155;
var panelHeight = 115
var clickObjectContextmenu = 3; // 1 = left click, 2 : middle click, 3 : right click
var clickObjectXY = 0; // 0 = dblclick, 1 = left click, 2 : middle click, 3 : right click
var addVolume = 0.25;
var currentTimePlus = 10;
var currentTimeMinus = -10;
var addSliderBtnTop = 5;
var addSliderBtnLeft = -140;
var sliderObjectTop = 20;
var sliderObjectLeft = 300;
var sliderBeforeBtnTop = 10;
var sliderBeforeBtnLeft = 20;
var sliderAfterBtnTop = 10;
var sliderAfterBtnLeft = 540;
var coordinateXYIndex = 1;
var drawCoordinateXYRadius = 2;
var downloadSetTime = 250;
var thumbnailWidth = 310;
var thumbnailHeight = 230;
var thumbnailsInterval = 5;
var thumbnailsQuantity = 3;
var outOfFrameType = 'selected'; // selected or moving
var saveSVGFileName = 'save.svg';
var captureImageMimeType = 'image/png';
var conversionImageMimeType = 'image/png';
var videoThumbnailPlaceBydblclick = 'tmp'; // baseToPanel, baseToTmp or tmp(myself)
var videoThumbnailPlaceByContmenu = 'baseToPanel'; // baseToPanel, baseToTmp or tmp(myself)
var videoThumbnailsPlaceByContmenu = 'baseToPanel'; // baseToPanel, baseToTmp or tmp(myself)
var drawCoordinateXYColor = 'red';
var drawCoordinatePathXYColor = 'green';
var drawCutCoordinateXYFill = 'rgba(0, 0, 0, 0)';
var isGradientFillAuto = true;
var isObjectByCanvasOutOfFrameUse = false;
var isObjectContextmenu = true;
var isUploadVideoStart = false;
var isFunctionKey = false;
var isClickOverUpload = true;

var angleMap = {0: '', 1: '0', 2: '45', 3: '90', 4: '135', 5: '180', 6: '225', 7: '270', 8: '315'};
var sizeMap = {0: '', 1: '9', 2: '11', 3: '14', 4: '16', 5: '18', 6: '20', 7: '32', 8: '64'};
var widthMap = {0: '', 1: '1', 2: '2', 3: '3', 4: '4', 5: '5'};
var colorMap = {0: '', 1: 'black', 2: 'red', 3: 'blue', 4: 'yellow', 5: 'green', 6: 'white'};
var fontFamilyMap = {0: '', 1: 'Arial', 2: 'Century Gothic', 3: 'Gulim', 4: 'Dotum', 5: 'Trebuchet'};
var fontWeightMap = {0: '', 1: 'normal', 2: 'bold'};
var lineHeightMap = {0: '', 1: '1', 2: '2', 3: '3', 4: '4', 5: '5'};
var textAlignMap = {0: '', 1: 'left', 2: 'center', 3: 'right'};
var defaultSliderObjects = ['./img/slider_after_btn.png', './img/slider_before_btn.png', './img/slider_bg.png'];

// Input paramter
var objX1 = 5;
var objY1 = 5;
var objX2 = 105;
var objY2 = 105;
var objRX = 50;
var objRY = 30;
var objTop = 100;
var objLeft = 100;
var objWidth = 20;
var objHeight = 20;
var objAngle = 0;
var objRadius = 20;
var objStrokeWidth = 2;
var objFontSize = 16;
var objTextBoxWidth = 300;
var objTextBoxHeight = 150;
var objFreeDrawingBrushWidth = 3;
var objLineHeight = 3;
var objAnimateDuration = 1000;
var objOpacity = 1.0;
var objScaleX = 1.0;
var objScaleY = 1.0;
var objAlpha = 0.2;
var objFill = 'red';
var objStroke = 'black';
var objStrokeStyle = 'green';
var objFontFamily = 'Arial';
var objFontWeight = 'bold';
var objFreeDrawingBrushColor = 'black';
var objShadow = 'green -5px -5px 3px';
var objTextAlign = 'left';
var objTextBaseline = 'alphabetic';
var objTextBackgroundColor = 'rgb(255, 255, 255)';
var objOriginX = 'center';
var objOriginY = 'center';
var objAnimateAlign = 'angle';
var objAnimateValue = '-=5';
var objDrawPoints = '{x: 73, y: 192},{x: 73, y: 160},{x: 340, y: 23},{x: 500, y: 109},{x: 499, y: 139},{x: 342, y: 93}';
var objColorStops = '{0: "red",0.2: "orange",0.4: "yellow",0.6: "green",0.8: "blue",1: "purple"}';
var objPath = 'M121.32,0L44.58,0C36.67,0,29.5,3.22,24.31,8.41\c-5.19,5.19-8.41,12.37-8.41,20.28c0,15.82,12.87,28.69,28.69,28.69c0,0,4.4,\0,7.48,0C36.66,72.78,8.4,101.04,8.4,101.04C2.98,106.45,0,113.66,0,121.32\c0,7.66,2.98,14.87,8.4,20.29l0,0c5.42,5.42,12.62,8.4,20.28,8.4c7.66,0,14.87\-2.98,20.29-8.4c0,0,28.26-28.25,43.66-43.66c0,3.08,0,7.48,0,7.48c0,15.82,\x0a.87,28.69,28.69,28.69c7.66,0,14.87-2.99,20.29-8.4c5.42-5.42,8.4-12.62,8.4\-20.28l0-76.74c0-7.66-2.98-14.87-8.4-20.29C136.19,2.98,128.98,0,121.32,0z';
var objString = 'Test Canvas';
var objUnderline = false;
var objLinethrough = false;
var objOverline = false;
var objFlipX = false;
var objFlipY = false;
var objSelectable = true;
var objObjectCaching = false;

$(document).ready(function() {
    $('#obj_x1').val(objX1);
    $('#obj_y1').val(objY1);
    $('#obj_x2').val(objX2);
    $('#obj_y2').val(objY2);
    $('#obj_rx').val(objRX);
    $('#obj_ry').val(objRY);
    $('#obj_top').val(objTop);
    $('#obj_left').val(objLeft);
    $('#obj_width').val(objWidth);
    $('#obj_height').val(objHeight);
    $('#obj_angle').val(objAngle);
    $('#obj_radius').val(objRadius);
    $('#obj_stroke_width').val(objStrokeWidth);
    $('#obj_font_size').val(objFontSize);
    $('#obj_free_drawing_brush_width').val(objFreeDrawingBrushWidth);
    $('#obj_line_height').val(objLineHeight);
    $('#obj_animate_duration').val(objAnimateDuration);

    $('#obj_opacity').val(objOpacity.toFixed(1));
    $('#obj_scale_x').val(objScaleX.toFixed(1));
    $('#obj_scale_y').val(objScaleY.toFixed(1));
    $('#obj_alpha').val(objAlpha.toFixed(1));

    $('#obj_fill').val(objFill);
    $('#obj_stroke').val(objStroke);
    $('#obj_stroke_style').val(objStrokeStyle);
    $('#obj_font_family').val(objFontFamily);
    $('#obj_font_weight').val(objFontWeight);
    $('#obj_free_drawing_brush_color').val(objFreeDrawingBrushColor);
    $('#obj_shadow').val(objShadow);
    $('#obj_text_align').val(objTextAlign);
    $('#obj_text_baseline').val(objTextBaseline);
    $('#obj_text_background_color').val(objTextBackgroundColor);
    $('#obj_origin_x').val(objOriginX);
    $('#obj_origin_y').val(objOriginY);
    $('#obj_animate_align').val(objAnimateAlign);
    $('#obj_animate_value').val(objAnimateValue);

    $('#obj_draw_points').text(objDrawPoints);
    $('#obj_color_stops').text(objColorStops);
    $('#obj_path').text(objPath);
    $('#obj_string').text(objString);

    $('#obj_underline').val(objUnderline);
    $('#obj_linethrough').val(objLinethrough);
    $('#obj_overline').val(objOverline);
    $('#obj_flip_x').val(objFlipX);
    $('#obj_flip_y').val(objFlipY);
    $('#obj_selectable').val(objSelectable);
    $('#obj_object_caching').val(objObjectCaching);

    if (objUnderline) {
        $('#obj_underline').prop('checked', true);
    }

    if (objLinethrough) {
        $('#obj_linethrough').prop('checked', true);
    }

    if (objOverline) {
        $('#obj_overline').prop('checked', true);
    }

    if (objFlipX) {
        $('#obj_flip_x').prop('checked', true);
    }

    if (objFlipY) {
        $('#obj_flip_y').prop('checked', true);
    }

    if (objSelectable) {
        $('#obj_selectable').prop('checked', true);
    }

    if (objObjectCaching) {
        $('#obj_object_caching').prop('checked', true);
    }
});

$(document).on('click', '.reloadObject', function() {
    if (null != baseCanvas && null != baseFunctionName) {
        executeCallback(baseCanvas, baseFunctionName, 'base');
        setCanvasHistory(baseCanvas);
    }
});

$(function($) {
    $(window).keydown(function(e) {
        if (!isFunctionKey) {
            return;
        }

        if (event.ctrlKey) {
            switch (e.keyCode) {
                case COPY_CTRL_KEY_CODE_VALUE:
                    canvasObjectCopy(baseCanvas, 'base');
                    break;
                case CUT_CTRL_KEY_CODE_VALUE:
                    canvasObjectCut(baseCanvas, 'base');
                    break;
                case PASTE_CTRL_KEY_CODE_VALUE:
                    canvasObjectPaste(baseCanvas, 'base');
                    break;
                case DELETE_CTRL_KEY_CODE_VALUE:
                    canvasObjectDelete(baseCanvas);
                    break;
            }
        } else if (DELETE_KEY_CODE_VALUE === e.keyCode) {
            canvasObjectDelete(baseCanvas);
        }

        return false;
    });
});

$(function() {
    loadSliderImgage();

    $('#image_object_check').on('click', function() {
        $('#img_upload').val('');
    });

    $('#image_base64_check').on('click', function() {
        $('#img_upload').val('');
    });

    if (!isVideoAvailable()) {
        $('#video_upload_area').css('display', 'none');
    }

    $('#slider_before_btn').on('click', function() {
        if (0 <= (sliderObjectIndex - 1)) {
            var removeObj = sliderObjects[sliderObjectIndex];

            sliderObjectIndex--;

            var addObj = sliderObjects[sliderObjectIndex];

            baseCanvas.setActiveObject(addObj);

            baseCanvas.remove(removeObj);
            baseCanvas.add(addObj);
        }
    });

    $('#slider_after_btn').on('click', function() {
        if (sliderObjects.length > (sliderObjectIndex + 1)) {
            var removeObj = sliderObjects[sliderObjectIndex];

            sliderObjectIndex++;

            var addObj = sliderObjects[sliderObjectIndex];

            baseCanvas.setActiveObject(addObj);

            baseCanvas.remove(removeObj);
            baseCanvas.add(addObj);
        }
    });
});

$(function() {
    $('#webcam_check').on('click', function() {
        if ($('#webcam_check').prop('checked')) {
            addWebCam(baseCanvas, 'base');
        } else {
            removeWebCam(baseCanvas, 'base');
        }
    });
});

$(function() {
    $('#object_slider_check').on('click', function() {
        if ($('#object_slider_check').prop('checked')) {
            var objs = createObjectSlider(baseCanvas, 'base');

            setTimeout(function() {
                var cnt = sliderObjects.length;

                if ($('#image_base64_check').prop('checked')) {
                    for (var i = 0; i < cnt; i++) {
                        if (SLIDER_IMAGE_NAME_KEY + '0' === sliderObjects[i].id) {
                            sliderObjectIndex = i;
                            baseCanvas.add(sliderObjects[i]);
                            baseCanvas.setActiveObject(sliderObjects[i]);
                        }
                    }
                } else {
                    for (var i = 0; i < cnt; i++) {
                        if (objs[0].split('/').pop() === sliderObjects[i].getSrc().split('/').pop()) {
                            sliderObjectIndex = i;
                            baseCanvas.add(sliderObjects[i]);
                            baseCanvas.setActiveObject(sliderObjects[i]);
                        }
                    }
                }

                baseCanvas.renderAll();
            }, BASE_SET_TIMEOUT_MS + (uploadSliderObjects.length * SLIDER_SET_TIMEOUT_COEFFICIENT));

            $('#slider_before_btn').css('display', 'block');
            $('#slider_after_btn').css('display', 'block');
        } else {
            removeObjectSlider(baseCanvas, 'base');
            $('#slider_before_btn').css('display', 'none');
            $('#slider_after_btn').css('display', 'none');
        }
    });

    $('.tmpCanvasWindow').on('click', function () {
        fabricjsportal.openWindow(BASE_PATH + 'childwindow/tmp_canvas.php', 'tmp_canvas_win', TMP_CANVAS_WINDOW_WIDTH, TMP_CANVAS_WINDOW_HEIGHT);
    });

    $('.panelCanvasWindow').on('click', function () {
        fabricjsportal.openWindow(BASE_PATH + 'childwindow/panel_canvas.php', 'panel_canvas_win', PANEL_CANVAS_WINDOW_WIDTH, PANEL_CANVAS_WINDOW_HEIGHT);
    });

    $('.imageDiffCanvasWindow').on('click', function () {
        fabricjsportal.openWindow(BASE_PATH + 'childwindow/image_diff_canvas.php', 'image_diff_canvas_win', IMAGE_DIFF_WINDOW_WIDTH, IMAGE_DIFF_WINDOW_HEIGHT);
    });

    $('.animateCanvasWindow').on('click', function () {
        fabricjsportal.openWindow(BASE_PATH + 'childwindow/object_animate_canvas.php', 'object_animate_canvas_win', ANIMATE_WINDOW_WIDTH, ANIMATE_WINDOW_HEIGHT);
    });

    $('.weaveCanvasWindow').on('click', function () {
        fabricjsportal.openWindow(BASE_PATH + 'childwindow/weave_in_string_canvas.php', 'weave_canvas_win', WEAVE_WINDOW_WIDTH, WEAVE_WINDOW_HEIGHT);
    });
});

$(function() {
    $('input[type="checkbox"]').on('click', function() {
        if ($('#drawing_mode_check').prop('checked')) {
            baseCanvas.isDrawingMode = true;
            baseCanvas.freeDrawingBrush.width = objFreeDrawingBrushWidth;
            baseCanvas.freeDrawingBrush.color = objFreeDrawingBrushColor;
            baseCanvas.renderAll();
            baseCanvas.calcOffset();

            $('#freedrawing_width_view').text('Width : ' + objFreeDrawingBrushWidth);
            $('#freedrawing_color_view').text('Color : ' + objFreeDrawingBrushColor);
        } else {
            baseCanvas.isDrawingMode = false;

            $('#freedrawing_width_view').text('');
            $('#freedrawing_color_view').text('');
        }

        if ($('#zoom_panning_check').prop('checked')) {
            baseCanvas.on('mouse:wheel', function(opt) {
                if ($('#zoom_panning_check').prop('checked')) {
                    var delta = opt.e.deltaY;
                    var zoom = baseCanvas.getZoom();

                    zoom = zoom + delta / 200;

                    if (zoom > 20) {
                        zoom = 20;
                    }

                    if (zoom < 0.01) {
                        zoom = 0.01;
                    }

                    baseCanvas.setZoom(zoom);
                    opt.e.preventDefault();
                    opt.e.stopPropagation();
                } else {
                    baseCanvas.setZoom(1);
                }
            });
        } else {
            baseCanvas.setZoom(1);
        }

        setObjBoolean('#obj_underline');
        setObjBoolean('#obj_linethrough');
        setObjBoolean('#obj_overline');
        setObjBoolean('#obj_flip_x');
        setObjBoolean('#obj_flip_y');
        setObjBoolean('#obj_selectable');
    });
});

// Fabric function callback class.

var CallbackClass = function() {
    this.circle = function(canvas, type) {
        loadParam();

        var circle = new fabric.Circle({
            top: objTop,
            left: objLeft,
            strokeWidth: objStrokeWidth,
            radius: objRadius,
            fill: objFill,
            stroke: objStroke,
            selectable: objSelectable,
        });

        circle = addEventObjectCanvas(canvas, circle, type);
        canvas.add(circle);
        canvas.setActiveObject(circle);
        convertCanvasData(canvas);
    };

    this.ellipse = function(canvas, type) {
        loadParam();

        var ellipse = new fabric.Ellipse({
            top: objTop,
            left: objLeft,
            rx: objRX,
            ry: objRY,
            strokeWidth: objStrokeWidth,
            fill: objFill,
            stroke: objStroke,
            selectable: objSelectable,
        });

        ellipse = addEventObjectCanvas(canvas, ellipse, type);
        canvas.add(ellipse);
        canvas.setActiveObject(ellipse);
        convertCanvasData(canvas);
    };

    this.line = function(canvas, type) {
        loadParam();

        var line = new fabric.Line([objX1, objY1, objX2, objY2], {
            strokeWidth: objStrokeWidth,
            stroke: objStroke,
            selectable: objSelectable,
        });

        line = addEventObjectCanvas(canvas, line, type);
        canvas.add(line);
        canvas.setActiveObject(line);
        convertCanvasData(canvas);
    };

    this.polygon = function(canvas, type) {
        loadParam();

        var drawPoints = getDrawPoints();

        var polygon = new fabric.Polygon(drawPoints, {
            top: objTop,
            left: objLeft,
            strokeWidth: objStrokeWidth,
            fill: objFill,
            stroke: objStroke,
            selectable: objSelectable,
        });

        polygon = addEventObjectCanvas(canvas, polygon, type);
        canvas.add(polygon);
        canvas.setActiveObject(polygon);
        convertCanvasData(canvas);
    };

    this.polyline = function(canvas, type) {
        loadParam();

        var drawPoints = getDrawPoints();

        var polyline = new fabric.Polyline(drawPoints, {
            top: objTop,
            left: objLeft,
            strokeWidth: objStrokeWidth,
            fill: objFill,
            stroke: objStroke,
            selectable: objSelectable,
        });

        polyline = addEventObjectCanvas(canvas, polyline, type);
        canvas.add(polyline);
        canvas.setActiveObject(polyline);
        convertCanvasData(canvas);
    };

    this.rect = function(canvas, type) {
        loadParam();

        var rect = new fabric.Rect({
            top: objTop,
            left: objLeft,
            width: objWidth,
            height: objHeight,
            angle: objAngle,
            strokeWidth: objStrokeWidth,
            fill: objFill,
            stroke: objStroke,
            selectable: objSelectable,
        });

        rect = addEventObjectCanvas(canvas, rect, type);
        canvas.add(rect);
        canvas.setActiveObject(rect);
        convertCanvasData(canvas);
    };

    this.triangle = function(canvas, type) {
        loadParam();

        var triangle = new fabric.Triangle({
            top: objTop,
            left: objLeft,
            width: objWidth,
            height: objHeight,
            angle: objAngle,
            strokeWidth: objStrokeWidth,
            fill: objFill,
            stroke: objStroke,
            selectable: objSelectable,
        });

        triangle = addEventObjectCanvas(canvas, triangle, type);
        canvas.add(triangle);
        canvas.setActiveObject(triangle);
        convertCanvasData(canvas);
    };

    this.text = function(canvas, type) {
        loadParam();

        var text = new fabric.Text(objString, {
            top: objTop,
            left: objLeft,
            angle: objAngle,
            strokeWidth: objStrokeWidth,
            fontSize: objFontSize,
            fill: objFill,
            stroke: objStroke,
            strokeStyle: objStrokeStyle,
            fontFamily: objFontFamily,
            fontWeight: objFontWeight,
            lineHeight: objLineHeight,
            underline: objUnderline,
            linethrough: objLinethrough,
            overline: objOverline,
            shadow: objShadow,
            textAlign: objTextAlign,
            textBackgroundColor: objTextBackgroundColor,
            selectable: objSelectable,
        });

        text = addEventObjectCanvas(canvas, text, type);
        canvas.add(text);
        canvas.setActiveObject(text);
        convertCanvasData(canvas);
    };

    this.textbox = function(canvas, type) {
        loadParam();

        var text = new fabric.Textbox(objString, {
            top: objTop,
            left: objLeft,
            angle: objAngle,
            strokeWidth: objStrokeWidth,
            fontSize: objFontSize,
            fill: objFill,
            stroke: objStroke,
            strokeStyle: objStrokeStyle,
            fontFamily: objFontFamily,
            fontWeight: objFontWeight,
            lineHeight: objLineHeight,
            underline: objUnderline,
            linethrough: objLinethrough,
            overline: objOverline,
            shadow: objShadow,
            textAlign: objTextAlign,
            textBackgroundColor: objTextBackgroundColor,
            width: objTextBoxWidth,
            height: objTextBoxHeight,
            selectable: objSelectable,
        });

        text = addEventObjectCanvas(canvas, text, type);
        canvas.add(text);
        canvas.setActiveObject(text);
        convertCanvasData(canvas);
    };

    this.stextbox = function(canvas, type) {
        loadParam();

        var text = new fabric.Textbox(objString, {
            top: objTop,
            left: objLeft,
            fontSize: objFontSize,
            width: objTextBoxWidth,
            height: objTextBoxHeight,
            selectable: objSelectable,
        });

        text = addEventObjectCanvas(canvas, text, type);
        canvas.add(text);
        canvas.setActiveObject(text);
        convertCanvasData(canvas);
    };

    this.path = function(canvas, type) {
        loadParam();

        var path = new fabric.Path(objPath, {
            top: objTop,
            left: objLeft,
            width: objWidth,
            height: objHeight,
            angle: objAngle,
            strokeWidth: objStrokeWidth,
            fill: objFill,
            stroke: objStroke,
            opacity: objOpacity,
            selectable: objSelectable,
        });

        path = addEventObjectCanvas(canvas, path, type);
        canvas.add(path);
        canvas.setActiveObject(path);
        convertCanvasData(canvas);
    };

    this.image = function(canvas, type) {
        loadParam();

        var imageData = null;

        if ($('#image_base64_check').prop('checked')) {
            imageData = imgBase64;
        } else {
            imageData = UPLOAD_IMG_PATH + $('#image_physics_name').val();
        }


        if ($('#object_image_radio').prop('checked')) {
            fabric.Image.fromURL(imageData, function(img) {
                var image = img.set({
                    top: objTop,
                    left: objLeft,
                    angle: objAngle,
                    opacity: objOpacity,
                    flipX: objFlipX,
                    flipY: objFlipY,
                    selectable: objSelectable,
                });

                image = addEventObjectCanvas(canvas, image, type);
                canvas.add(image);
                canvas.setActiveObject(image);
                canvas.renderAll();
            });
        } else if ($('#background_image_radio').prop('checked')) {
            canvas.setBackgroundImage(imageData, canvas.renderAll.bind(canvas));
        } else if ($('#overlay_image_radio').prop('checked')) {
            canvas.setOverlayImage(imageData, canvas.renderAll.bind(canvas));
        }
    };

    this.video = function(canvas, type) {
        loadParam();

        var videoEl = document.getElementById('video');

        videoEl.setAttribute('src', UPLOAD_VIDEO_PATH + $('#video_physics_name').val());

        var video = new fabric.Image(videoEl, {
            top: objTop,
            left: objLeft,
            angle: objAngle,
            opacity: objOpacity,
            originX: objOriginX,
            originY: objOriginY,
            flipX: objFlipX,
            flipY: objFlipY,
            objectCaching: objObjectCaching,
            selectable: objSelectable,
        });

        video = addEventObjectCanvas(canvas, video, type);
        canvas.add(video);
        canvas.setActiveObject(video);

        if (isUploadVideoStart) {
            video.getElement().play();
        }

        fabric.util.requestAnimFrame(function render() {
            canvas.renderAll();
            fabric.util.requestAnimFrame(render);
        });
    };

    this.svg = function(canvas, type) {
        loadParam();

        var filePath = UPLOAD_SVG_PATH + $('#svg_physics_name').val();

        fabric.loadSVGFromURL(filePath, function(objects, options) {
            var loadedObject = fabric.util.groupSVGElements(objects, options);

            loadedObject.set({
                top: objTop,
                left: objLeft,
                angle: objAngle,
                selectable: objSelectable,
            });

            loadedObject = addEventObjectCanvas(canvas, loadedObject, type);
            loadedObject.setCoords();
            canvas.add(loadedObject);
            canvas.setActiveObject(loadedObject);
            canvas.calcOffset();
        });
    };

    this.group = function(canvas, objects, type) {
        var group = new fabric.Group(objects, {
            top: objTop,
            left: objLeft,
            angle: objAngle,
            selectable: objSelectable,
        });

        group = addEventObjectCanvas(canvas, group, type);
        canvas.add(group);
        canvas.setActiveObject(group);
    };
};

// Exceute file.

$(function() {
    $('form').on('change', 'input[type="file"]', function(e) {
        var file = e.target.files[0];
        baseFile = file;

        if (null != file && 'img_upload' === e.target.id) {
            if ($('#image_object_check').prop('checked')) {
                if (!file.name.match(/\.(png|gif|jpg|jpeg|bmp)$/i)) {
                    alert('Image is png|gif|jpg|jpeg|bmp');
                    return;
                }

                loadCanvasBase64(file);

                imgFileUpload(file.name);

                setTimeout(function() {
                    executeCallback(baseCanvas, 'image', 'base');
                }, BASE_SET_TIMEOUT_MS + (file.size / UPLOAD_FILE_SIZE_NUMERATOR));
            }

            if ($('#slider_image_check').prop('checked')) {
                sliderImgFileUpload(file.name);
            }
        } else if (null != file && 'svg_upload' === e.target.id) {
            if (!file.name.match(/\.(svg)$/i)) {
                alert('SVG is svg');
                return;
            }

            svgFileUpload(file.name);

            setTimeout(function() {
                executeCallback(baseCanvas, 'svg', 'base');
            }, BASE_SET_TIMEOUT_MS + (file.size / UPLOAD_FILE_SIZE_NUMERATOR));
        } else if (null != file && 'video_upload' === e.target.id) {
            if (!file.name.match(/\.(mp4|webm|ogv)$/i)) {
                alert('Video is mp4|webm|ogv');
                return;
            }

            videoFileUpload(file.name);

            setTimeout(function() {
                executeCallback(baseCanvas, 'video', 'base');
            }, BASE_SET_TIMEOUT_MS + (file.size / UPLOAD_FILE_SIZE_NUMERATOR));
        }
    });
});

function loadCanvasBase64(file) {
    var fileReader = new FileReader();

    fileReader.onload = function(evt) {
        imgBase64 = evt.target.result;
    }

    fileReader.readAsDataURL(file);
}

// File upload.

function imgFileUpload(fileName) {
    fileUpload('img', fileName);
}

function sliderImgFileUpload(fileName) {
    fileUpload('slider_img', fileName);
}

function svgFileUpload(fileName) {
    fileUpload('svg', fileName);
}

function videoFileUpload(fileName) {
    fileUpload('video', fileName);
}

function tmpSVGFileUpload() {
    fileUpload('tmp_svg', null);
}

function clickOverFileUpload() {
    fileUpload('click_over', null);
}

// Ajax

function fileUpload(uploadMode, fileName) {
    $('#upload_mode').val(uploadMode);

    var formData = new FormData($('#form1').get(0));

    $.ajax({
        url: BASE_PATH + 'ajax/uploadFile.php',
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
            physicsName = obj['info'];
        }

        if ('img' === uploadMode) {
            $('#image_physics_name').val(physicsName);
            $('#image_logic_name').val(fileName);
        } else if ('slider_img' === uploadMode) {
            uploadSliderObjects.push(UPLOAD_SLIDER_IMG_PATH + physicsName);
        } else if ('svg' === uploadMode) {
            $('#svg_physics_name').val(physicsName);
            $('#svg_logic_name').val(fileName);
        } else if ('video' === uploadMode) {
            $('#video_physics_name').val(physicsName);
            $('#video_logic_name').val(fileName);
        } else if ('tmp_svg' === uploadMode) {
            $('#svg_physics_name').val(physicsName);
        } else if ('click_over' === uploadMode) {
            $('#svg_physics_name').val(physicsName);
        }
    }).fail(function() {
        console.log(data);
    });
}

function loadSliderImgage() {
    $('#load_mode').val('slider_img');

    var formData = new FormData($('#form1').get(0));

    $.ajax({
        url: BASE_PATH + 'ajax/loadFile.php',
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
                uploadSliderObjects.push(UPLOAD_SLIDER_IMG_PATH + obj['info'][keys[i]]);
            }
        }
    }).fail(function() {
        console.log(data);
    });
}

// Canvas History.

function undoCanvas() {
    var cnt = canvasHistory.length - 1;

    if (0 > cnt) {
        return;
    }

    baseCanvas.clear();

    for (var i = 0; i < cnt; i++) {
        baseCanvas.add(canvasHistory[i]);
    }

    canvasUndo.push(canvasHistory[canvasHistory.length - 1]);
    canvasHistory.pop();
}

function redoCanvas() {
    var undoCnt = canvasUndo.length;

    if (0 < undoCnt) {
        canvasHistory.push(canvasUndo[undoCnt - 1]);
        canvasUndo.pop();
    }

    var cnt = canvasHistory.length;

    baseCanvas.clear();

    for (var i = 0; i < cnt; i++) {
        baseCanvas.add(canvasHistory[i]);
    }
}

function setCanvasHistory(canvas) {
    var hisCnt = canvasHistory.length;
    var objs = canvas.getObjects();
    var cnt = objs.length;

    if (hisCnt < cnt) {
        for (var i = hisCnt; i < cnt; i++) {
            canvasHistory.push(objs[i]);
        }
    } else if (hisCnt > cnt) {
        for (var i = hisCnt - 1; i >= cnt; i--) {
            canvasHistory.pop();
        }
    }
}

// Canvas object animation.

function animateCanvas(canvas) {
    if (!canvas.getActiveObject()) {
        return;
    }

    loadParam();

    var easingType = null;

    switch ($('#select_animate_type').val()) {
        case 'InBack':
            easingType = fabric.util.ease.easeInBack;
            break;
        case 'InBounce':
            easingType = fabric.util.ease.easeInBounce;
            break;
        case 'InCirc':
            easingType = fabric.util.ease.easeInCirc;
            break;
        case 'InCubic':
            easingType = fabric.util.ease.easeInCubic;
            break;
        case 'InExpo':
            easingType = fabric.util.ease.easeInExpo;
            break;
        case 'InOutBack':
            easingType = fabric.util.ease.easeInOutBack;
            break;
        case 'InOutBounce':
            easingType = fabric.util.ease.easeInOutBounce;
            break;
        case 'InOutCirc':
            easingType = fabric.util.ease.easeInOutCirc;
            break;
        case 'InOutCubic':
            easingType = fabric.util.ease.easeInOutCubic;
            break;
        case 'InOutElastic':
            easingType = fabric.util.ease.easeInOutElastic;
            break;
        case 'InOutExpo':
            easingType = fabric.util.ease.easeInOutExpo;
            break;
        case 'InOutQuad':
            easingType = fabric.util.ease.easeInOutQuad;
            break;
        case 'InOutQuart':
            easingType = fabric.util.ease.easeInOutQuart;
            break;
        case 'InOutQuint':
            easingType = fabric.util.ease.easeInOutQuint;
            break;
        case 'InOutSine':
            easingType = fabric.util.ease.easeInOutSine;
            break;
        case 'InQuad':
            easingType = fabric.util.ease.easeInQuad;
            break;
        case 'InQuart':
            easingType = fabric.util.ease.easeInQuart;
            break;
        case 'InQuint':
            easingType = fabric.util.ease.easeInQuint;
            break;
        case 'InSine':
            easingType = fabric.util.ease.easeInSine;
            break;
        case 'OutBack':
            easingType = fabric.util.ease.easeOutBack;
            break;
        case 'OutBounce':
            easingType = fabric.util.ease.easeOutBounce;
            break;
        case 'OutCirc':
            easingType = fabric.util.ease.easeOutCirc;
            break;
        case 'OutCubic':
            easingType = fabric.util.ease.easeOutCubic;
            break;
        case 'OutElastic':
            easingType = fabric.util.ease.easeOutElastic;
            break;
        case 'OutExpo':
            easingType = fabric.util.ease.easeOutExpo;
            break;
        case 'OutQuad':
            easingType = fabric.util.ease.easeOutQuad;
            break;
        case 'OutQuart':
            easingType = fabric.util.ease.easeOutQuart;
            break;
        case 'OutQuint':
            easingType = fabric.util.ease.easeOutQuint;
            break;
        case 'OutSine':
            easingType = fabric.util.ease.easeOutSine;
            break;
    }

    if (null != easingType) {
        canvas.getActiveObject().animate(objAnimateAlign, objAnimateValue, {
            onChange: canvas.renderAll.bind(canvas),
            duration: objAnimateDuration,
            easing: easingType,
        });
    } else {
        canvas.getActiveObject().animate(objAnimateAlign, objAnimateValue, {
            onChange: canvas.renderAll.bind(canvas),
            duration: objAnimateDuration,
        });
    }
}

// Canvas object modifiy.

function setObjectGradientFill(canvas) {
    if (!canvas.getActiveObject()) {
        return;
    }

    var colorStopsData = getColorStops();
    var gfX1 = objX1;
    var gfY1 = objY1;
    var gfX2 = objX2;
    var gfY2 = objY2;

    if (isGradientFillAuto) {
        gfX1 = 0;
        gfY1 = canvas.getActiveObject().height / 2;
        gfX2 = canvas.getActiveObject().width;
        gfY2 = canvas.getActiveObject().height / 2;
    }

    canvas.getActiveObject().setGradient('fill', {
        x1: gfX1,
        y1: gfY1,
        x2: gfX2,
        y2: gfY2,
        colorStops: colorStopsData,
    });

    canvas.renderAll();
}

function discardCanvasGroup(type) {
    var canvas = null;

    if ('tmp' === type) {
        canvas = tmpCanvas;
    } else if ('base' === type) {
        canvas = baseCanvas;
    } else if ('panel' === type) {
        canvas = panelCanvas;
    }

    if (!canvas.getActiveObject()) {
        return;
    }

    if ('group' !== canvas.getActiveObject().type) {
        return;
    }

    canvas.getActiveObject().toActiveSelection();
    canvas.requestRenderAll();
}

function allCanvasObjectsGroup(type) {
    var canvas = null;

    if ('tmp' === type) {
        canvas = tmpCanvas;
    } else if ('base' === type) {
        canvas = baseCanvas;
    } else if ('panel' === type) {
        canvas = panelCanvas;
    }

    var objs = canvas.getObjects();
    var cnt = objs.length;

    executeCallbackObjects(canvas, objs, 'group', type);

    for (var i = 0; i < cnt; i++) {
        canvas.remove(objs[i]);
    }
}

// Exceute context menu.

function tmpCanvasExceute(key) {
    switch (key) {
        case 'move':
            canvasObjectMove(tmpCanvas, 'tmp');
            break;
        case 'cut':
            canvasObjectCut(tmpCanvas, 'tmp');
            break;
        case 'copy':
            canvasObjectCopy(tmpCanvas, 'tmp');
            break;
        case 'paste':
            canvasObjectPaste(tmpCanvas, 'tmp');
            break;
        case 'delete':
            canvasObjectDelete(tmpCanvas);
            break;
        case 'show':
            showCanvasObjects(tmpCanvas);
            break;
        case 'list':
            listCanvasObjects(tmpCanvas);
            break;
        case 'clear':
            tmpCanvas.clear();
            break;
    }

    if (null != tmpCanvasWin) {
        tmpCanvasWin.location.reload();
    }
}

function baseCanvasExceute(key, options) {
    if (-1 != key.indexOf('font')) {
        canvasObjectFont(baseCanvas, key, options);
    }

    switch (key) {
        case 'moveToTmp':
            canvasObjectMove(baseCanvas, 'baseToTmp');

            if (null != tmpCanvasWin) {
                tmpCanvasWin.location.reload();
            }
            break;
        case 'moveToPanel':
            canvasObjectMove(baseCanvas, 'baseToPanel');
            break;
        case 'show':
            showCanvasObjects(baseCanvas);
            break;
        case 'paramter':
            if (!baseCanvas.getActiveObject()) {
                return;
            }

            paramterCanvas = baseCanvas;

            fabricjsportal.openWindow(BASE_PATH + 'childwindow/object_paramter.php', 'object_paramter_win', OBJECT_PARAMTER_WINDOW_WIDTH, OBJECT_PARAMTER_WINDOW_HEIGHT);
            break;
        case 'freedrawing_color':
            objFreeDrawingBrushColor = colorMap[options.selectedIndex];
            baseCanvas.freeDrawingBrush.color = objFreeDrawingBrushColor;
            break;
        case 'freedrawing_width':
            objFreeDrawingBrushWidth = widthMap[options.selectedIndex];
            baseCanvas.freeDrawingBrush.width = objFreeDrawingBrushWidth;
            break;
        case 'sendBackwards':
            canvasObjectSendBackwards(baseCanvas);
            break;
        case 'sendToBack':
            canvasObjectSendToBack(baseCanvas);
            break;
        case 'bringForward':
            canvasObjectBringForward(baseCanvas);
            break;
        case 'bringToFront':
            canvasObjectBringToFront(baseCanvas);
            break;
        case 'rectClip':
            canvasObjectClip(baseCanvas, 'base', 'rect');
            break;
        case 'pathClip':
            canvasObjectClip(baseCanvas, 'base', 'path');
            break;
        case 'rectCutImg':
            canvasObjectCutImage(baseCanvas, 'base', 'rect');
            break;
        case 'pathCutImg':
            canvasObjectCutImage(baseCanvas, 'base', 'path');
            break;
        case 'cut':
            canvasObjectCut(baseCanvas, 'base');
            break;
        case 'copy':
            canvasObjectCopy(baseCanvas, 'base');
            break;
        case 'paste':
            canvasObjectPaste(baseCanvas, 'base');
            break;
        case 'delete':
            canvasObjectDelete(baseCanvas);
            break;
        case 'play':
            canvasObjectPlay(baseCanvas);
            break;
        case 'pause':
            canvasObjectPause(baseCanvas);
            break;
        case 'currentToTop':
            canvasObjectCurrentToTop(baseCanvas);
            break;
        case 'currentTimePlus':
            canvasObjectCurrentAddTime(baseCanvas, currentTimePlus);
            break;
        case 'currentTimeMinus':
            canvasObjectCurrentAddTime(baseCanvas, currentTimeMinus);
            break;
        case 'upVolume':
            canvasObjectUpVolume(baseCanvas);
            break;
        case 'downVolume':
            canvasObjectDownVolume(baseCanvas);
            break;
        case 'mute':
            canvasObjectMute(baseCanvas);
            break;
        case 'thumbnail':
            var thumbnails = createVideoThumbnail(baseCanvas);
            var thumbnailCanvas = null;
            var width = thumbnailWidth;
            var height = thumbnailHeight;

            if ('tmp' === videoThumbnailPlaceByContmenu) {
                thumbnailCanvas = baseCanvas;
            } else if ('baseToTmp' === videoThumbnailPlaceByContmenu) {
                thumbnailCanvas = tmpCanvas;
            } else if ('baseToPanel' === videoThumbnailPlaceByContmenu) {
                thumbnailCanvas = panelCanvas;
                width = panelWidth;
                height = panelHeight;
            }

            setTimeout(function() {
                setThumbnailCanvas(thumbnailCanvas, thumbnails, width, height, videoThumbnailPlaceByContmenu);
            }, BASE_THUMBNAIL_SET_TIMEOUT_MS * (thumbnails.length + 1));
            break;
        case 'thumbnails':
            createVideoThumbnails(baseCanvas, thumbnailsInterval, thumbnailsQuantity);

            setTimeout(function() {
                var thumbnailCanvas = null;
                var width = thumbnailWidth;
                var height = thumbnailHeight;

                if ('tmp' === videoThumbnailsPlaceByContmenu) {
                    thumbnailCanvas = baseCanvas;
                } else if ('baseToTmp' === videoThumbnailsPlaceByContmenu) {
                    thumbnailCanvas = tmpCanvas;
                } else if ('baseToPanel' === videoThumbnailsPlaceByContmenu) {
                    thumbnailCanvas = panelCanvas;
                    width = panelWidth;
                    height = panelHeight;
                }

                setThumbnailCanvas(thumbnailCanvas, videoThumbnails, width, height, videoThumbnailPlaceByContmenu);
            }, BASE_SET_TIMEOUT_MS + (BASE_SET_TIMEOUT_MS * thumbnailsQuantity));
            break;
        case 'showCoordinate':
            showCoordinate('path');
            break;
        case 'clearCoordinate':
            removeObject(baseCanvas, COORDINATE_PATH_XY_NAME_KEY, 'like');
            removeObject(baseCanvas, COORDINATE_XY_RECT_NAME_KEY, 'like');
            targetXY = [];
            targetPathXY = [];
            break;
        case 'list':
            listCanvasObjects(baseCanvas);
            break;
        case 'clear':
            baseCanvas.clear();
            break;
    }
}

function panelCanvasExceute(key) {
    switch (key) {
        case 'saveToSVG':
            canvasObjectSaveToSVG(panelCanvas);
            break;
        case 'delete':
            canvasObjectDelete(panelCanvas);
            break;
        case 'show':
            showCanvasObjects(panelCanvas);
            break;
        case 'list':
            listCanvasObjects(panelCanvas);
            break;
        case 'clear':
            panelCanvas.clear();
            break;
    }
}

// Canvas object execute.

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
                url = UPLOAD_TMP_PATH + $('#svg_physics_name').val();
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

function canvasObjectMove(canvas, type) {
    if (!canvas.getActiveObject()) {
        return;
    }

    var obj = canvas.getActiveObject();

    obj.clone(function(cloned) {
        var video = copyVideoObject(obj, false);

        if (null != video) {
            cloned = video;

            if ($('#video_image_capture_check').prop('checked') && 'baseToPanel' === type) {
                var videoEl = getVideoElement(obj);
                var imageData = getVideoCaptureImageData(videoEl, captureImageMimeType);

                fabric.Image.fromURL(imageData, function(img) {
                    var image = img.set({
                        top: moveTop,
                        left: moveLeft,
                    });

                    addObjectCanvasCenter(panelCanvas, image, panelWidth, panelHeight, type);
                });

                canvas.remove(obj);

                return;
            } else {
                removeEventObject(cloned);
            }
        }

        cloned.top = moveTop;
        cloned.left = moveLeft;

        if ('tmp' === type) {
            cloned = addEventObjectCanvas(baseCanvas, cloned, 'base');
            baseCanvas.add(cloned);
        } else if ('baseToTmp' === type) {
            cloned = addEventObjectCanvas(tmpCanvas, cloned, 'tmp');
            tmpCanvas.add(cloned);
        } else if ('baseToPanel' === type) {
            cloned = addEventObjectCanvas(panelCanvas, cloned, 'panel');
            addObjectCanvasCenter(panelCanvas, cloned, panelWidth, panelHeight, type);
        }
    });

    canvas.remove(obj);
}

function canvasObjectSendBackwards(canvas) {
    if (!canvas.getActiveObject()) {
        return;
    }

    canvas.sendBackwards(canvas.getActiveObject());
}

function canvasObjectSendToBack(canvas) {
    if (!canvas.getActiveObject()) {
        return;
    }

    canvas.sendToBack(canvas.getActiveObject());
}

function canvasObjectBringForward(canvas) {
    if (!canvas.getActiveObject()) {
        return;
    }

    canvas.bringForward(canvas.getActiveObject());
}

function canvasObjectBringToFront(canvas) {
    if (!canvas.getActiveObject()) {
        return;
    }

    canvas.bringToFront(canvas.getActiveObject());
}

function canvasObjectClip(canvas, type, clipType) {
    if (!canvas.getActiveObject()) {
        return;
    }

    var obj = canvas.getActiveObject();

    if ('image' !== obj.type || isVideo(obj.getSrc()) || isWebCam(obj.getSrc())) {
        alert('Clip is image only.');
        return;
    }

    if ('rect' === clipType) {
        if (4 == targetXY.length) {
            obj.clipTo = function (ctx) {
                var top = (obj.width / 2) + obj.top;
                var left = (obj.height / 2) + obj.left;

                ctx.strokeStyle = objStrokeStyle;
                ctx.beginPath();
                ctx.moveTo(targetXY[0] - top, targetXY[1] - left);
                ctx.lineTo(targetXY[2] - top, targetXY[1] - left);
                ctx.lineTo(targetXY[2] - top, targetXY[3] - left);
                ctx.lineTo(targetXY[0] - top, targetXY[3] - left);
                ctx.closePath();
                ctx.stroke();
            }
        } else {
            alert('Set x1 y1 x2 y2');
        }
    } else {
        if (4 <= targetPathXY.length) {
            obj.clipTo = function (ctx) {
                var top = (obj.height / 2) + obj.top;
                var left = (obj.width / 2) + obj.left;
                var cnt = targetPathXY.length;

                ctx.strokeStyle = objStrokeStyle;
                ctx.beginPath();
                ctx.moveTo(targetPathXY[0] - left, targetPathXY[1] - top);

                for (var i = 2; i < cnt; i += 2) {
                    ctx.lineTo(targetPathXY[i] - left, targetPathXY[i + 1] - top);
                }

                ctx.closePath();
                ctx.stroke();
            }
        } else {
            alert('Set x1 y1 x2 y2 ...');
        }
    }
}

function canvasObjectCutImage(canvas, type, cutType) {
    if (!canvas.getActiveObject()) {
        return;
    }

    var obj = canvas.getActiveObject();

    if ('image' !== obj.type || isVideo(obj.getSrc()) || isWebCam(obj.getSrc())) {
        alert('Cut is image only.');
        return;
    }

    if ('rect' === cutType) {
        if (4 == targetXY.length) {
            var x = targetXY[0];
            var y = targetXY[1];
            var width = obj.width;
            var height = obj.height;
            var sX = targetXY[0];
            var sY = targetXY[1];
            var sWidth = targetXY[2] - targetXY[0];
            var sHeight = targetXY[3] - targetXY[1];

            if (sX > targetXY[2]) {
                x = targetXY[2];
                sX = targetXY[2];
            }

            if (sY > targetXY[3]) {
                y = targetXY[3];
                sY = targetXY[3];
            }

            sX = (sX * -1) + obj.left;
            sY = (sY * -1) + obj.top;

            if (0 > sWidth) {
                sWidth *= -1;
            }

            if (0 > sHeight) {
                sHeight *= -1;
            }

            canvasCutDrawImage(canvas, type, obj.getSrc(), x, y, width, height, sX, sY, sWidth, sHeight);
        } else {
            alert('Set x1 y1 x2 y2');
        }
    } else {
        if (4 <= targetPathXY.length) {
            var cutCanvas = document.createElement('canvas');

            cutCanvas.width = obj.width;
            cutCanvas.height = obj.height;

            var ctx = cutCanvas.getContext('2d');
            var img = new Image();

            var top = obj.top;
            var left = obj.left;
            var maxTop = 0;
            var maxLeft = 0;
            var cnt = targetPathXY.length;

            ctx.strokeStyle = drawCoordinatePathXYColor;
            ctx.beginPath();
            ctx.moveTo(targetPathXY[0] - left, targetPathXY[1] - top);

            if (maxTop < targetPathXY[1]) {
                maxTop = targetPathXY[1];
            }

            if (maxLeft < targetPathXY[0]) {
                maxLeft = targetPathXY[0];
            }

            for (var i = 2; i < cnt; i += 2) {
                ctx.lineTo(targetPathXY[i] - left, targetPathXY[i + 1] - top);

                if (maxTop < targetPathXY[i + 1]) {
                    maxTop = targetPathXY[i + 1];
                }

                if (maxLeft < targetPathXY[i]) {
                    maxLeft = targetPathXY[i];
                }
            }

            ctx.closePath();
            ctx.stroke();
            ctx.clip();

            img.onload = function() {
                ctx.drawImage(img, 0, 0, obj.width, obj.height);

                var imageBase64 = cutCanvas.toDataURL(conversionImageMimeType);

                fabric.Image.fromURL(imageBase64, function(img) {
                    var image = img.set({
                        name: CUT_IMAGE_PATH_NAME_KEY,
                        top: obj.top,
                        left: obj.left,
                        width: maxLeft,
                        height: maxTop,
                    });

                    image = addEventObjectCanvas(canvas, image, type);

                    canvas.add(image);
                    canvas.setActiveObject(image);
                });
            }

            img.src = obj.getSrc();
        } else {
            alert('Set x1 y1 x2 y2 ...');
        }
    }
}

function canvasObjectCut(canvas, type) {
    if (!canvas.getActiveObject()) {
        return;
    }

    canvasObjectCopy(canvas, type);

    canvas.remove(canvas.getActiveObject());
}

function canvasObjectCopy(canvas, type) {
    if (!canvas.getActiveObject()) {
        return;
    }

    var obj = canvas.getActiveObject();

    if ('image' === obj.type && isWebCam(obj.getSrc())) {
        isWebCamCopy = true;
        return;
    }

    isWebCamCopy = false;

    obj.clone(function(cloned) {
        var video = copyVideoObject(obj, true);

        if (null != video) {
            cloned = video;
        }

        cloned = addEventObjectCanvas(canvas, cloned, type);

        if ('tmp' === type) {
            tmpObjectData = cloned;
        } else if ('base' === type) {
            baseObjectData = cloned;
        } else if ('panel' === type) {
            panelObjectData = cloned;
        }
    });
}

function canvasObjectPaste(canvas, type) {
    var obj = null;

    if (isWebCamCopy) {
        addWebCam(canvas, type);
        return;
    }

    isWebCamCopy = false;

    if ('tmp' === type && null != tmpObjectData) {
        obj = tmpObjectData;
    } else if ('base' === type && null != baseObjectData) {
        obj = baseObjectData;
    } else if ('panel' === type && null != panelObjectData) {
        obj = panelObjectData;
    }

    if (null == obj) {
        return;
    }

    if ('image' === obj.type && isVideo(obj.getSrc())) {
        var video = copyVideoObject(obj, true);

        video.top += pasteTop;
        video.left += pasteLeft;

        video = addEventObjectCanvas(canvas, video, type);

        canvas.add(video);
    } else {
        obj.top += pasteTop;
        obj.left += pasteLeft;

        canvas.add(obj);
    }

    if ('base' === type) {
        setCanvasHistory(canvas);
    }
}

function canvasObjectDelete(canvas) {
    if (!canvas.getActiveObject()) {
        return;
    }

    var obj = canvas.getActiveObject();

    deleteCopyVideoElement(obj);
    canvas.remove(obj);
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

function canvasObjectFont(canvas, key, options) {
    if (!canvas.getActiveObject()) {
        return;
    }

    var obj = canvas.getActiveObject();

    if (!('text' === obj.type || 'textbox' === obj.type)) {
        return;
    }

    switch (key) {
        case 'font_angle':
            obj.angle = angleMap[options.selectedIndex];
            break;
        case 'font_strokeWidth':
            obj.strokeWidth = widthMap[options.selectedIndex];
            break;
        case 'font_fontSize':
            obj.fontSize = sizeMap[options.selectedIndex];
            break;
        case 'font_fill':
            obj.fill = colorMap[options.selectedIndex];
            break;
        case 'font_stroke':
            obj.stroke = colorMap[options.selectedIndex];
            break;
        case 'font_strokeStyle':
            obj.stroke = colorMap[options.selectedIndex];
            break;
        case 'font_fontFamily':
            obj.fontFamily = fontFamilyMap[options.selectedIndex];
            break;
        case 'font_fontWeight':
            obj.fontWeight = fontWeightMap[options.selectedIndex];
            break;
        case 'font_lineHeight':
             obj.lineHeight = lineHeightMap[options.selectedIndex];
            break;
        case 'font_textAlign':
            obj.textAlign = textAlignMap[options.selectedIndex];
            break;
        case 'font_textBackgroundColor':
            obj.textBackgroundColor = colorMap[options.selectedIndex];
            break;
    }
}

function addObjectCanvasCenter(canvas, obj, width, height, type) {
    obj.top = canvas.height / 2;
    obj.left = canvas.width / 2;

    if ('image' === obj.type && !isVideo(obj.getSrc()) && $('#panel_img_resize_check').prop('checked')) {
        var image = null;
        var imageData = null;

        imageData = obj.getSrc();

        if (null == imageData) {
            imageData = imgBase64;
        }

        var resizeScaleX = getImageScale(obj.width, width);
        var resizeScaleY = getImageScale(obj.height, height);

        fabric.Image.fromURL(imageData, function(img) {
            var image = img.set({
                top: obj.top,
                left: obj.left,
                scaleX: resizeScaleX,
                scaleY: resizeScaleY,
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

            if ('tmp' === type) {
                image = addEventObjectCanvas(baseCanvas, image, 'base');
            } else if ('baseToTmp' === type) {
                image = addEventObjectCanvas(tmpCanvas, image, 'tmp');
            } else if ('baseToPanel' === type) {
                image = addEventObjectCanvas(panelCanvas, image, 'panel');
            }

            canvas.add(image);
        });
    } else {
        obj.scaleX = 1;
        obj.scaleY = 1;

        obj.width = width;
        obj.height = height;

        obj.setControlsVisibility({
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

        canvas.add(obj);

        if ('image' === obj.type && isVideo(obj.getSrc())) {
            fabric.util.requestAnimFrame(function render() {
                canvas.renderAll();
                fabric.util.requestAnimFrame(render);
            });
        }
    }
}

function removeObjectSlider(canvas, type) {
    removeObject(canvas, SLIDER_BTN_IMAGE_NAME_KEY, '=');
}

function createObjectSlider(canvas, type) {
    var objs = defaultSliderObjects;

    if ($('#slider_image_check').prop('checked') && 0 < uploadSliderObjects.length) {
        objs = uploadSliderObjects;
    }

    if (null == objs || 0 === objs.length) {
        return objs;
    }

    fabric.Object.prototype.transparentCorners = false;

    fabric.Canvas.prototype.getAbsoluteCoords = function(object) {
        return {
            top: object.top + this._offset.top,
            left: object.left + this._offset.left,
        };
    }

    var sliderBeforeBtn = document.getElementById('slider_before_btn');
    var sliderAfterBtn = document.getElementById('slider_after_btn');

    function positionBeforeBtn(obj) {
        var absCoords = canvas.getAbsoluteCoords(obj);

        sliderBeforeBtn.style.top = (absCoords.top + addSliderBtnTop) + 'px';
        sliderBeforeBtn.style.left = (absCoords.left + addSliderBtnLeft) + 'px';
    };

    function positionAfterBtn(obj) {
        var absCoords = canvas.getAbsoluteCoords(obj);

        sliderAfterBtn.style.top = (absCoords.top + addSliderBtnTop) + 'px';
        sliderAfterBtn.style.left = (absCoords.left + addSliderBtnLeft) + 'px';
    };

    var cnt = objs.length;
    var imgObjs = [];

    if ($('#image_base64_check').prop('checked')) {
        for (var i = 0; i < cnt; i++) {
            imgObjs[i] = new Image();

            imgObjs[i].onload = function onImageLoad() {
                var imageCanvas = document.createElement('canvas');

                imageCanvas.width = this.width;
                imageCanvas.height = this.height;

                imageCanvas.getContext('2d').drawImage(this, 0, 0, imageCanvas.width, imageCanvas.height);

                var id = this.id;
                var imageData = imageCanvas.toDataURL(conversionImageMimeType);

                fabric.Image.fromURL(imageData, function(img) {
                    img = addEventObjectCanvas(canvas, img, type);

                    img.set({
                        id: id,
                        name: SLIDER_OBJECT_IMAGE_NAME_KEY,
                        top: sliderObjectTop,
                        left: sliderObjectLeft,
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

                    sliderObjects.push(img);
                });
            }

            imgObjs[i].id = SLIDER_IMAGE_NAME_KEY + i;
            imgObjs[i].src = objs[i];
        }
    } else {
        for (var i = 0; i < cnt; i++) {
            fabric.Image.fromURL(objs[i], function(img) {
                img = addEventObjectCanvas(canvas, img, type);

                img.set({
                    name: SLIDER_OBJECT_IMAGE_NAME_KEY,
                    top: sliderObjectTop,
                    left: sliderObjectLeft,
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

                sliderObjects.push(img);
            });
        }
    }

    fabric.Image.fromURL(SLIDER_BACKGROUND_IMAGE_PATH, function(img) {
        canvas.add(
            img.set({
                name: SLIDER_BTN_IMAGE_NAME_KEY,
                top: sliderBeforeBtnTop,
                left: sliderBeforeBtnLeft,
            })
        );

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

        img.on('moving', function() { positionBeforeBtn(img) });
        positionBeforeBtn(img);
    });

    fabric.Image.fromURL(SLIDER_BACKGROUND_IMAGE_PATH, function(img) {
        canvas.add(
            img.set({
                name: SLIDER_BTN_IMAGE_NAME_KEY,
                top: sliderAfterBtnTop,
                left: sliderAfterBtnLeft,
            })
        );

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

        img.on('moving', function() { positionAfterBtn(img) });
        positionAfterBtn(img);
    });

    return objs;
}

// Object add event listener.

function addEventObjectCanvas(canvas, obj, type) {
    if (isObjectByCanvasOutOfFrameUse) {
        obj.on(outOfFrameType, function() {
            objectByCanvasOutOfFrame(canvas, this);
        });
    }

    if (isObjectContextmenu) {
        obj.on('mouseup:before', function(opt) {
            if (clickObjectContextmenu === opt.e.which) {
                var key = '#' + type + '_object_menu';
                $(key).trigger('contextmenu');
            }
        });
    }

    if ('image' === obj.type && !isVideo(obj.getSrc()) && !isWebCam(obj.getSrc())) {
        if (0 === clickObjectXY) {
            obj.on('mousedblclick', function(opt) {
                setCoordinateXY(canvas, opt);
            });
        } else {
            obj.on('mousedown:before', function(opt) {
                if (clickObjectXY === opt.e.which) {
                    setCoordinateXY(canvas, opt);
                }
            });
        }
    }

    if ('image' === obj.type && isVideo(obj.getSrc())) {
        obj.on('mousedblclick', function() {
            var thumbnails = createVideoThumbnail(canvas);
            var thumbnailCanvas = null;
            var width = thumbnailWidth;
            var height = thumbnailHeight;

            if ('tmp' === videoThumbnailPlaceBydblclick) {
                thumbnailCanvas = baseCanvas;
            } else if ('baseToTmp' === videoThumbnailPlaceBydblclick) {
                thumbnailCanvas = tmpCanvas;
            } else if ('baseToPanel' === videoThumbnailPlaceBydblclick) {
                thumbnailCanvas = panelCanvas;
                width = panelWidth;
                height = panelHeight;
            }

            setTimeout(function() {
                setThumbnailCanvas(thumbnailCanvas, thumbnails, width, height, videoThumbnailPlaceBydblclick);
            }, BASE_THUMBNAIL_SET_TIMEOUT_MS * (thumbnails.length + 1));
        });
    }

    return obj;
}

function setCoordinateXY(canvas, opt) {
    var mousePos = canvas.getPointer(opt.e);

    if (isStartTargetXY) {
        targetXY[0] = mousePos.x;
        targetXY[1] = mousePos.y;
        isStartTargetXY = false;

        targetPathXY.push(targetXY[0]);
        targetPathXY.push(targetXY[1]);

        $('#coordinate_x1_view').text('x1 : ' + targetXY[0]);
        $('#coordinate_y1_view').text('y1 : ' + targetXY[1]);

        removeObject(canvas, COORDINATE_XY_RECT_NAME_KEY, 'like');
    } else {
        targetXY[2] = mousePos.x;
        targetXY[3] = mousePos.y;
        isStartTargetXY = true;

        targetPathXY.push(targetXY[2]);
        targetPathXY.push(targetXY[3]);

        $('#coordinate_x2_view').text('x2 : ' + targetXY[2]);
        $('#coordinate_y2_view').text('y2 : ' + targetXY[3]);

        drawCoordinateXYRect(canvas, targetXY[0], targetXY[1], targetXY[2], targetXY[3]);
    }

    drawCoordinateXY(canvas, mousePos.x, mousePos.y, COORDINATE_PATH_XY_NAME_KEY, drawCoordinatePathXYColor);
}

function drawCoordinateXYRect(canvas, x1, y1, x2, y2) {
    var drawTop = y1 + 1;
    var drawLeft = x1 + 1;
    var drawWidth = (x2 - x1) + 1;
    var drawHeight = (y2 - y1) + 1;

    if (0 > drawWidth) {
        drawLeft = x2 + 1;
        drawWidth = (drawWidth * -1) + 2;
    }

    if (0 > drawHeight) {
        drawTop = y2 + 1;
        drawHeight = (drawHeight * -1) + 2;
    }

    var rect = new fabric.Rect({
        name: COORDINATE_XY_RECT_NAME_KEY,
        top: drawTop,
        left: drawLeft,
        width: drawWidth,
        height: drawHeight,
        fill: drawCutCoordinateXYFill,
        stroke: drawCoordinateXYColor,
    });

    rect.setControlsVisibility({
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

    rect.selectable = false;

    canvas.add(rect);
    canvas.setActiveObject(rect);
}

function drawCoordinateXY(canvas, x, y, coordinateName, coordinateXYColor) {
    var circle = new fabric.Circle({
        name: coordinateName + coordinateXYIndex,
        top: y,
        left: x,
        radius: drawCoordinateXYRadius,
        fill: coordinateXYColor,
    });

    circle.setControlsVisibility({
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

    circle.on('mousemove', function(opt) {
        $('#coordinate_no_view').text('no : ' + parseInt(opt.target.name.slice(coordinateName.length)));
        $('#coordinate_x_view').text('x : ' + opt.target.left);
        $('#coordinate_y_view').text('y : ' + opt.target.top);
    });

    circle.selectable = false;

    canvas.add(circle);
    canvas.setActiveObject(circle);

    coordinateXYIndex++;
}

function removeEventObject(obj) {
    obj.off(outOfFrameType);
    obj.off('mouseup:before');
    obj.off('mousedown:before');
    obj.off('mousedblclick');
}

function objectByCanvasOutOfFrame(canvas, obj) {
    var top = canvas.height - obj.height;
    var left = canvas.width - obj.width;

    if (0 > obj.top && !dialogViewFlg) {
        top = 0;
        tmpMoveObjectConfirm(canvas, obj, top);
    }

    if (top < obj.top && !dialogViewFlg) {
        top = canvas.height - obj.height;
        panelMoveObjectConfirm(canvas, obj, top);
    }

    if (0 > obj.left && !dialogViewFlg) {
        left = 0;
        deleteObjectConfirm(canvas, obj, left);
    }

    if (left < obj.left && !dialogViewFlg) {
        left = canvas.width - obj.width;
        deleteObjectConfirm(canvas, obj, left);
    }
}

function tmpMoveObjectConfirm(canvas, obj, top) {
    var buttons = [
        {
            text: 'OK',
            click: function () {
                canvasObjectMove(canvas, 'baseToTmp')

                $(this).dialog('close');
            }
        },
        {
            text: 'Cancel',
            click: function () {
                $(this).dialog('close');
            }
        }
    ];

    var message = 'Tmp move object ' + obj.type + ' ?';

    showDialog('Tmp move confirm', message, buttons, canvas, obj, top, null);
}

function panelMoveObjectConfirm(canvas, obj, top) {
    var buttons = [
        {
            text: 'OK',
            click: function () {
                canvasObjectMove(canvas, 'baseToPanel')

                $(this).dialog('close');
            }
        },
        {
            text: 'Cancel',
            click: function () {
                $(this).dialog('close');
            }
        }
    ];

    var message = 'panel move object ' + obj.type + ' ?';

    showDialog('Panel move confirm', message, buttons, canvas, obj, top, null);
}

function deleteObjectConfirm(canvas, obj, left) {
    var buttons = [
        {
            text: 'OK',
            click: function () {
                canvas.remove(obj);
                setCanvasHistory(canvas);
                $(this).dialog('close');
            }
        },
        {
            text: 'Cancel',
            click: function () {
                $(this).dialog('close');
            }
        }
    ];

    var message = 'Delete object ' + obj.type + ' ?';

    showDialog('Delete object confirm', message, buttons, canvas, obj, null, left);
}

function showDialog(title, message, buttons, canvas, obj, top, left) {
    var htmlDialog = '<div>' + message + '</div>';

    $(htmlDialog).dialog({
        title: title,
        buttons: buttons,
        close: function() {
            dialogViewFlg = false;

            if (null != top) {
                obj.top = top;
            }

            if (null != left) {
                obj.left = left;
            }

            obj.setCoords();

            canvas.renderAll();
            canvas.calcOffset();

            $(this).remove();
        }
    });

    dialogViewFlg = true;
}

// FabricJS function callback.

function executeCallback(canvas, functionName, type) {
    if (null == functionName || '' === functionName) {
        return;
    }

    var callback = new CallbackClass();

    if ('tmp' === type) {
        tmpCanvas = canvas;
    } else if ('base' === type) {
        baseCanvas = canvas;
    } else if ('panel' === type) {
        panelCanvas = canvas;
    }

    baseFunctionName = functionName;

    callback[functionName](canvas, type);
    setCanvasHistory(canvas);
}

function executeCallbackObjects(canvas, objects, functionName, type) {
    if (null == functionName || '' === functionName) {
        return;
    }

    var callback = new CallbackClass();

    if ('tmp' === type) {
        tmpCanvas = canvas;
    } else if ('base' === type) {
        baseCanvas = canvas;
    } else if ('panel' === type) {
        panelCanvas = canvas;
    }

    baseFunctionName = functionName;

    callback[functionName](canvas, objects, type);

    if ('group' !== functionName) {
        setCanvasHistory(canvas);
    }
}

// Util function.

function getTimeoutByUrlLength(len) {
    var time = downloadSetTime * Math.floor(len / MB_SIZE_NUMERATOR);

    return time;
}

function canvasCutDrawImage(canvas, type, imageData, x, y, width, height, sX, sY, sWidth, sHeight) {
    var $defer = new $.Deferred();

    $.when(
        $defer
    ).done(function() {
        var imageBase64 = trimCanvas.toDataURL(conversionImageMimeType);

        fabric.Image.fromURL(imageBase64, function(img) {
            var image = img.set({
                name: CUT_IMAGE_NAME_KEY + y + ',' + x + ',' + sWidth + ',' + sHeight,
                top: y,
                left: x,
                width: sWidth,
                height: sHeight,
            });

            image = addEventObjectCanvas(canvas, image, type);

            canvas.add(image);
            canvas.setActiveObject(image);
        });
    });

    var func = function() {
        setTimeout(function() {
            setTrimImage(imageData, sX, sY, width, height, sWidth, sHeight);
            return $defer.resolve();
        }, BASE_SET_TIMEOUT_MS);

        return $defer.promise();
    };

    func();
}

function setTrimImage(imageData, x, y, width, height, sWidth, sHeight) {
    var canvas = document.createElement('canvas');
    var ctx = canvas.getContext('2d');
    var img = new Image();

    canvas.id = 'trimCanvas';
    canvas.width = sWidth;
    canvas.height = sHeight;

    img.onload = function() {
        ctx.drawImage(img, x, y, width, height);
        trimCanvas = canvas;
    };

    img.src = imageData;
}

function removeWebCam(canvas, type) {
    removeObject(canvas, WEB_CAM_NAME_KEY, '=');
}

function addWebCam(canvas, type) {
    loadParam();

    var webCamEl = document.getElementById('webCam');

    var webCam = new fabric.Image(webCamEl, {
        name: WEB_CAM_NAME_KEY,
        top: objTop,
        left: objLeft,
        angle: objAngle,
        originX: objOriginX,
        originY: objOriginY,
        objectCaching: objObjectCaching,
    });

    webCam = addEventObjectCanvas(canvas, webCam, type);

    canvas.setActiveObject(webCam);

    getUserMedia({video: true},
        function getWebcamAllowed(localMediaStream) {
            var video = document.getElementById('webCam');

            video.src = window.URL.createObjectURL(localMediaStream);

            canvas.add(webCam);
            webCam.moveTo(0);
            webCam.getElement().play();
        }, function getWebcamNotAllowed(e) {}
    );

    fabric.util.requestAnimFrame(function render() {
        canvas.renderAll();
        fabric.util.requestAnimFrame(render);
    });
}

function removeObject(canvas, name, type) {
    var objs = canvas.getObjects();
    var cnt = objs.length;

    if ('=' === type) {
        for (var i = 0; i < cnt; i++) {
            if (name === objs[i].name) {
                canvas.remove(objs[i]);
            }
        }
    } else if ('like' === type) {
        for (var i = 0; i < cnt; i++) {
            if (undefined != objs[i].name && -1 != objs[i].name.indexOf(name)) {
                canvas.remove(objs[i]);
            }
        }
    }
}

function getVideoCaptureImageData(video, mimeType) {
    var canvas = document.createElement('canvas');

    if (null == video) {
        video = document.getElementById('video');
    }

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);

    return canvas.toDataURL(mimeType);
}

function getImageScale(baseSize, targetSize) {
    var scale = 1.0;

    scale = (targetSize / baseSize);

    return scale;
}

function getVideoElement(obj) {
    var video = null;

    if (undefined !== obj.name && '' !== obj.name) {
        video = getCopyVideoElement(obj.name);
    } else {
        if (isVideo(obj.getSrc())) {
            video = document.getElementById('video');
        } else if (isWebCam(obj.getSrc())) {
            video = document.getElementById('webCam');
        }
    }

    return video;
}

function deleteCopyVideoElement(obj) {
    if (undefined !== obj.name && '' !== obj.name) {
        var no = parseInt(obj.name.slice(VIDEO_COPY_NAME_KEY.length));

        copyVideoElement[no] = null;

        $('#' + VIDEO_COPY_NAME_KEY + no).remove();
    }
}

function getCopyVideoElement(videoName) {
    var no = parseInt(videoName.slice(VIDEO_COPY_NAME_KEY.length));

    var video = copyVideoElement[no];

    return video;
}

function createVideoElement(no, src, controls) {
    var video = document.createElement('video');

    video.setAttribute('id', VIDEO_COPY_NAME_KEY + no);
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
        var videoName = VIDEO_COPY_NAME_KEY;
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

function createVideoThumbnail(canvas) {
    var thumbnails = [];

    if (!canvas.getActiveObject()) {
        return thumbnails;
    }

    var obj = canvas.getActiveObject();

    if ('image' === obj.type || isVideo(obj.getSrc())) {
        var videoEl = getVideoElement(obj);
        var imageData = getVideoCaptureImageData(videoEl, captureImageMimeType)

        thumbnails.push(imageData);
    }

    return thumbnails;
}

function createVideoThumbnails(canvas, interval, quantity) {
    videoThumbnails = [];

    loopSleep(quantity, BASE_SET_TIMEOUT_MS, function(i) {
        loadVideoThumbnail(canvas);
        canvasObjectCurrentAddTime(canvas, interval);
    });
}

function loadVideoThumbnail(canvas) {
    if (!canvas.getActiveObject()) {
        return false;
    }

    var obj = canvas.getActiveObject();

    if ('image' === obj.type || isVideo(obj.getSrc())) {
        var videoEl = getVideoElement(obj);
        var imageData = getVideoCaptureImageData(videoEl, captureImageMimeType)

        videoThumbnails.push(imageData);

        return true;
    }

    return false;
}

function setThumbnailCanvas(canvas, thumbnails, width, height, type) {
    var cnt = thumbnails.length;

    for (var i = 0; i < cnt; i++) {
        fabric.Image.fromURL(thumbnails[i], function(img) {
            var image = img.set({
                top: moveTop,
                left: moveLeft,
            });

            addObjectCanvasCenter(canvas, image, width, height, type);
        });
    }
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

function showCanvasObjects(canvas) {
    if (!canvas.getActiveObject()) {
        return;
    }

    var obj = canvas.getActiveObject();

    alert(JSON.stringify(obj));
}

function listCanvasObjects(canvas) {
    var objs = canvas.getObjects();
    var cnt = objs.length;
    var objsStr = 'Object number = ' + cnt + '\n';

    for (var i = 0; i < cnt; i++) {
        objsStr += objs[i];

        if (undefined !== objs[i].name) {
            objsStr += '(' + objs[i].name + ')';
        }

        objsStr += '\n';
    }

    alert(objsStr);
}

function showCoordinate(type) {
    var cnt = 0;
    var xy = null;

    if ('path' === type) {
        cnt = targetPathXY.length;
        xy = targetPathXY;
    } else {
        cnt = targetXY.length;
        xy = targetXY;
    }

    var xyStr = 'xy number = ' + (cnt / 2) + '\n';

    for (var i = 0; i < cnt; i++) {
        if (0 == i % 2) {
            xyStr += 'x = ' + xy[i] + ',';
        } else {
            xyStr += 'y = ' + xy[i] + '\n';
        }
    }

    alert(xyStr);
}

function convertCanvasData(canvas) {
    if ($('#image_json_check').prop('checked')) {
        $('#image_json').val(JSON.stringify(canvas));
    }

    if ($('#image_svg_check').prop('checked')) {
        $('#image_svg').val(canvas.toSVG());
    }
}

function setObjBoolean(keyName) {
    if ($(keyName).prop('checked')) {
        $(keyName).val('true');
    } else {
        $(keyName).val('false');
    }
}

function loopSleep(_loopLimit, _interval, _mainFunc) {
    var loopLimit = _loopLimit;
    var interval = _interval;
    var mainFunc = _mainFunc;
    var i = 0;

    var loopFunc = function () {
        var result = mainFunc(i);

        if (true === result) {
            return;
        }

        i = i + 1;

        if (i < loopLimit) {
            setTimeout(loopFunc, interval);
        }
    }

    loopFunc();
}

function isVideoAvailable() {
    var result = true;
    var userAgent = window.navigator.userAgent.toLowerCase();

    if (userAgent.indexOf('msie') != -1 || userAgent.indexOf('trident') != -1) {
        result = false;
    } else if (userAgent.indexOf('edge') != -1) {
        result = false;
    } else if(userAgent.indexOf('chrome') != -1) {
        result = true;
    } else if(userAgent.indexOf('safari') != -1) {
        result = false;
    } else if(userAgent.indexOf('firefox') != -1) {
        result = true;
    } else if(userAgent.indexOf('opera') != -1) {
        result = false;
    } else {
        result = false;
    }

    return result
}

function getUserMedia() {
    var userMediaFunc = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;

    if (userMediaFunc) {
        userMediaFunc.apply(navigator, arguments);
    }
}

(function(window, undefined) {
    if (undefined === window.fabricjsportal) {
        window.fabricjsportal = {};
    }

    var fabricjsportal = window.fabricjsportal;

    fabricjsportal.defaults = {
        formId:'formFabricjsportal',
        windowFeatures:{
            scrollbars:'yes',
            resizable:'no',
            toolbar:'no',
            location:'no',
            directories:'no',
            status:'no',
            focus:true,
            formTarget:''
        }
    };

    fabricjsportal.openWindow = function(URL, name, width, height, option) {
        var features = 'width=' + width + ',height=' + height;

        if (undefined === option) {
            option = fabricjsportal.defaults.windowFeatures;
        } else {
            option = $.extend(fabricjsportal.defaults.windowFeatures, option);
        }

        features = features + ',scrollbars=' + option.scrollbars
                 + ',resizable=' + option.resizable
                 + ',toolbar=' + option.toolbar
                 + ',location=' + option.location
                 + ',directories=' + option.directories
                 + ',status=' + option.status;

        if (option.hasOwnProperty('menubar')) {
            features = features + ',menubar=' + option.menubar;
        }

        var win = window.open(URL, name, features);

        if ('' !== option.formTarget) {
            document.forms[option.formTarget].target = name;
        }

        if (option.focus) {
            win.focus();
        }

        if ('tmp_canvas_win' === name) {
            tmpCanvasWin = win;
        }
    };

    fabricjsportal.isOpener = function() {
        var ua = navigator.userAgent;

        if (window.opener) {
            if (-1 !== ua.indexOf('MSIE 4') && -1 !== ua.indexOf('Win')) {
                if (window.opener.hasOwnProperty('closed')) {
                    return !window.opener.closed;
                } else {
                    return false;
                }
            } else {
                return typeof 'object' === window.opener.document;
            }
        } else {
            return false;
        }
    };
})(window);

// Load paramter.

function getDrawPoints() {
    var drawPoints = [];

    var text = objDrawPoints.replace(new RegExp('{', 'g'), '');
    text = text.replace(new RegExp('}', 'g'), '');
    text = text.replace(new RegExp(' ', 'g'), '');
    text = text.replace(new RegExp(':', 'g'), '');
    text = text.replace(new RegExp('x', 'g'), '');
    text = text.replace(new RegExp('y', 'g'), '');

    var datas = text.split(',');
    var cnt = datas.length;
    var xPos = 0;
    var yPos = 0;

    for (var i = 0; i < cnt; i++) {
        if (i % 2 == 0) {
            xPos = parseInt(datas[i]);
        } else {
            yPos = parseInt(datas[i]);

            drawPoints.push({x: xPos, y: yPos});
        }
    }

    return drawPoints;
}

function getColorStops() {
    var colorStops = [];

    var text = objColorStops.replace(new RegExp('{', 'g'), '');
    text = text.replace(new RegExp('}', 'g'), '');
    text = text.replace(new RegExp(' ', 'g'), '');
    text = text.replace(new RegExp('"', 'g'), '');

    var datas = text.split(',');
    var cnt = datas.length;
    var pos = '';
    var color = '';

    for (var i = 0; i < cnt; i++) {
        var posColor = datas[i].split(':');
        pos = parseFloat(posColor[0]);
        color = posColor[1];

        colorStops[pos] = color;
    }

    return colorStops;
}

function loadParam() {
    if (null != $('#obj_x1').val() || undefined != $('#obj_x1').val()) {
        objX1 = parseInt($('#obj_x1').val());
    }

    if (null != $('#obj_y1').val() || undefined != $('#obj_y1').val()) {
        objY1 = parseInt($('#obj_y1').val());
    }

    if (null != $('#obj_x2').val() || undefined != $('#obj_x2').val()) {
        objX2 = parseInt($('#obj_x2').val());
    }

    if (null != $('#obj_y2').val() || undefined != $('#obj_y2').val()) {
        objY2 = parseInt($('#obj_y2').val());
    }

    if (null != $('#obj_rx').val() || undefined != $('#obj_rx').val()) {
        objRX = parseInt($('#obj_rx').val());
    }

    if (null != $('#obj_ry').val() || undefined != $('#obj_ry').val()) {
        objRY = parseInt($('#obj_ry').val());
    }

    if (null != $('#obj_top').val() || undefined != $('#obj_top').val()) {
        objTop = parseInt($('#obj_top').val());
    }

    if (null != $('#obj_left').val() || undefined != $('#obj_left').val()) {
        objLeft = parseInt($('#obj_left').val());
    }

    if (null != $('#obj_width').val() || undefined != $('#obj_width').val()) {
        objWidth = parseInt($('#obj_width').val());
    }

    if (null != $('#obj_height').val() || undefined != $('#obj_height').val()) {
        objHeight = parseInt($('#obj_height').val());
    }

    if (null != $('#obj_angle').val() || undefined != $('#obj_angle').val()) {
        objAngle = parseInt($('#obj_angle').val());
    }

    if (null != $('#obj_radius').val() || undefined != $('#obj_radius').val()) {
        objRadius = parseInt($('#obj_radius').val());
    }

    if (null != $('#obj_stroke_width').val() || undefined != $('#obj_stroke_width').val()) {
        objStrokeWidth = parseInt($('#obj_stroke_width').val());
    }

    if (null != $('#obj_font_size').val() || undefined != $('#obj_font_size').val()) {
        objFontSize = parseInt($('#obj_font_size').val());
    }

    if (null != $('#obj_free_drawing_brush_width').val() || undefined != $('#obj_free_drawing_brush_width').val()) {
        objFreeDrawingBrushWidth = parseInt($('#obj_free_drawing_brush_width').val());
    }

    if (null != $('#obj_line_height').val() || undefined != $('#obj_line_height').val()) {
        objLineHeight = parseInt($('#obj_line_height').val());
    }

    if (null != $('#obj_animate_duration').val() || undefined != $('#obj_animate_duration').val()) {
        objAnimateDuration = parseInt($('#obj_animate_duration').val());
    }

    if (null != $('#obj_opacity').val() || undefined != $('#obj_opacity').val()) {
        objOpacity = parseFloat($('#obj_opacity').val());
    }

    if (null != $('#obj_scale_x').val() || undefined != $('#obj_scale_x').val()) {
        objScaleX = parseFloat($('#obj_scale_x').val());
    }

    if (null != $('#obj_scale_y').val() || undefined != $('#obj_scale_y').val()) {
        objScaleY = parseFloat($('#obj_scale_y').val());
    }

    if (null != $('#obj_alpha').val() || undefined != $('#obj_alpha').val()) {
        objAlpha = parseFloat($('#obj_alpha').val());
    }

    if (null != $('#obj_fill').val() || undefined != $('#obj_fill').val()) {
        objFill = $('#obj_fill').val();
    }

    if (null != $('#obj_stroke').val() || undefined != $('#obj_stroke').val()) {
        objStroke = $('#obj_stroke').val();
    }

    if (null != $('#obj_stroke_style').val() || undefined != $('#obj_stroke_style').val()) {
        objStrokeStyle = $('#obj_stroke_style').val();
    }

    if (null != $('#obj_font_family').val() || undefined != $('#obj_font_family').val()) {
        objFontFamily = $('#obj_font_family').val();
    }

    if (null != $('#obj_font_weight').val() || undefined != $('#obj_font_weight').val()) {
        objFontWeight = $('#obj_font_weight').val();
    }

    if (null != $('#obj_free_drawing_brush_color').val() || undefined != $('#obj_free_drawing_brush_color').val()) {
        objFreeDrawingBrushColor = $('#obj_free_drawing_brush_color').val();
    }

    if (null != $('#obj_shadow').val() || undefined != $('#obj_shadow').val()) {
        objShadow = $('#obj_shadow').val();
    }

    if (null != $('#obj_text_align').val() || undefined != $('#obj_text_align').val()) {
        objTextAlign = $('#obj_text_align').val();
    }

    if (null != $('#obj_text_baseline').val() || undefined != $('#obj_text_baseline').val()) {
        textBaseline = $('#obj_text_baseline').val();
    }

    if (null != $('#obj_text_background_color').val() || undefined != $('#obj_text_background_color').val()) {
        objTextBackgroundColor = $('#obj_text_background_color').val();
    }

    if (null != $('#obj_origin_x').val() || undefined != $('#obj_origin_x').val()) {
        objOriginX = $('#obj_origin_x').val();
    }

    if (null != $('#obj_origin_y').val() || undefined != $('#obj_origin_y').val()) {
        objOriginY = $('#obj_origin_y').val();
    }

    if (null != $('#obj_animate_align').val() || undefined != $('#obj_animate_align').val()) {
        objAnimateAlign = $('#obj_animate_align').val();
    }

    if (null != $('#obj_animate_value').val() || undefined != $('#obj_animate_value').val()) {
        objAnimateValue = $('#obj_animate_value').val();
    }

    if (null != $('#obj_draw_points').text() || undefined != $('#obj_draw_points').text()) {
        objDrawPoints = $('#obj_draw_points').text();
    }

    if (null != $('#obj_color_stops').text() || undefined != $('#obj_color_stops').text()) {
        objColorStops = $('#obj_color_stops').text();
    }

    if (null != $('#obj_path').text() || undefined != $('#obj_path').text()) {
        objPath = $('#obj_path').text();
    }

    if (null != $('#obj_string').text() || undefined != $('#obj_string').text()) {
        objString = $('#obj_string').text();
    }

    if (null != $('#obj_underline').val() || undefined != $('#obj_underline').val()) {
        if ('true' === $('#obj_underline').val()) {
            objUnderline = true;
        } else {
            objUnderline = false;
        }
    }

    if (null != $('#obj_linethrough').val() || undefined != $('#obj_linethrough').val()) {
        if ('true' === $('#obj_linethrough').val()) {
            objLinethrough = true;
        } else {
            objLinethrough = false;
        }
    }

    if (null != $('#obj_overline').val() || undefined != $('#obj_overline').val()) {
        if ('true' === $('#obj_overline').val()) {
            objOverline = true;
        } else {
            objOverline = false;
        }
    }

    if (null != $('#obj_flip_x').val() || undefined != $('#obj_flip_x').val()) {
        if ('true' === $('#obj_flip_x').val()) {
            objFlipX = true;
        } else {
            objFlipX = false;
        }
    }

    if (null != $('#obj_flip_y').val() || undefined != $('#obj_flip_y').val()) {
        if ('true' === $('#obj_flip_y').val()) {
            objFlipY = true;
        } else {
            objFlipY = false;
        }
    }

    if (null != $('#obj_selectable').val() || undefined != $('#obj_selectable').val()) {
        if ('true' === $('#obj_selectable').val()) {
            objSelectable = true;
        } else {
            objSelectable = false;
        }
    }

    if (null != $('#obj_object_caching').val() || undefined != $('#obj_object_caching').val()) {
        if ('true' === $('#obj_object_caching').val()) {
            objObjectCaching = true;
        } else {
            objObjectCaching = false;
        }
    }
}
