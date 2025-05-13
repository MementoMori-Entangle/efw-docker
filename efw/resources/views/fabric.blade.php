@extends('layout')

@section('content')
    <script type="text/javascript" src="./js/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="./js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="./js/jquery.contextMenu.min.js"></script>
    <script type="text/javascript" src="./js/jquery.ui.position.min.js"></script>
    <script type="text/javascript" src="./js/fabric.min.5.3.js"></script>
    <script type="text/javascript" src="./js/fabricUtil.js"></script>
    <script type="text/javascript" src="./js/contextMenuUtil.js"></script>
    <script type="text/javascript" src="./js/easeljs-NEXT.min.js"></script>
    <script type="text/javascript" src="./js/preloadjs-NEXT.min.js"></script>
    <script type="text/javascript" src="./js/SVGExporter.js"></script>
    <script type="text/javascript" src="./js/Graphics.js"></script>
    <link rel="stylesheet" href="./css/jquery-ui.css">
    <link rel="stylesheet" href="./css/jquery.contextMenu.css">
    <link rel="stylesheet" href="./css/fabric.css">

    <h1>Fabric</h1>
    <form action="/fabric" name="form1" id="form1" method="POST" class="form-horizontal" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="image_physics_name" id="image_physics_name" value="" />
        <input type="hidden" name="image_logic_name" id="image_logic_name" value="" />
        <input type="hidden" name="svg_physics_name" id="svg_physics_name" value="" />
        <input type="hidden" name="svg_logic_name" id="svg_logic_name" value="" />
        <input type="hidden" name="video_physics_name" id="video_physics_name" value="" />
        <input type="hidden" name="video_logic_name" id="video_logic_name" value="" />
        <input type="hidden" name="image_json" id="image_json" value="" />
        <input type="hidden" name="image_svg" id="image_svg" value="" />
        <input type="hidden" name="load_mode" id="load_mode" value="" />
        <input type="hidden" name="upload_mode" id="upload_mode" value="" />
        <input type="hidden" name="upload_dl_data" id="upload_dl_data" value="" />
        <input type="hidden" name="upload_dl_ext" id="upload_dl_ext" value="" />

        <!-- Fabric Name -->
        <div class="form-group">
            <label for="fabric" class="col-sm-3 control-label">Fabric Name</label>
            <div class="col-sm-3">
                <input type="text" name="name" id="fabric_name" value="Test" class="form-control">
            </div>
        </div>

        <!-- Object Select -->
        <div class="form-group">
            <div class="col-sm-3">
                <table>
                    <thead>
                        <tr>
                            <th>X1</th>
                            <th>Y1</th>
                            <th>X2</th>
                            <th>Y2</th>
                            <th>RX</th>
                            <th>RY</th>
                            <th>Top</th>
                            <th>Left</th>
                            <th>Width</th>
                            <th>Height</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" name="obj_x1" id="obj_x1" class="input_size_param" /></td>
                            <td><input type="text" name="obj_y1" id="obj_y1" class="input_size_param" /></td>
                            <td><input type="text" name="obj_x2" id="obj_x2" class="input_size_param" /></td>
                            <td><input type="text" name="obj_y2" id="obj_y2" class="input_size_param" /></td>
                            <td><input type="text" name="obj_rx" id="obj_rx" class="input_size_param" /></td>
                            <td><input type="text" name="obj_ry" id="obj_ry" class="input_size_param" /></td>
                            <td><input type="text" name="obj_top" id="obj_top" class="input_size_param" /></td>
                            <td><input type="text" name="obj_left" id="obj_left" class="input_size_param" /></td>
                            <td><input type="text" name="obj_width" id="obj_width" class="input_size_param" /></td>
                            <td><input type="text" name="obj_height" id="obj_height" class="input_size_param" /></td>
                        </tr>
                    </tbody>
                </table>

                <table>
                    <thead>
                        <tr>
                            <th>Angle</th>
                            <th>Radius</th>
                            <th>StrokeWidth</th>
                            <th>FontSize</th>
                            <th>BrushWidth</th>
                            <th>LineHeight</th>
                            <th>Opacity</th>
                            <th>ScaleX</th>
                            <th>ScaleY</th>
                            <th>Alpha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" name="obj_angle" id="obj_angle" class="input_size_param" /></td>
                            <td><input type="text" name="obj_radius" id="obj_radius" class="input_size_param" /></td>
                            <td><input type="text" name="obj_stroke_width" id="obj_stroke_width" class="input_size_param" /></td>
                            <td><input type="text" name="obj_font_size" id="obj_font_size" class="input_size_param" /></td>
                            <td><input type="text" name="obj_free_drawing_brush_width" id="obj_free_drawing_brush_width" class="input_size_param" /></td>
                            <td><input type="text" name="obj_line_height" id="obj_line_height" class="input_size_param" /></td>
                            <td><input type="text" name="obj_opacity" id="obj_opacity" class="input_size_param" /></td>
                            <td><input type="text" name="obj_scale_x" id="obj_scale_x" class="input_size_param" /></td>
                            <td><input type="text" name="obj_scale_y" id="obj_scale_y" class="input_size_param" /></td>
                            <td><input type="text" name="obj_alpha" id="obj_alpha" class="input_size_param" /></td>
                        </tr>
                    </tbody>
                </table>

                <table>
                    <thead>
                        <tr>
                            <th>FillColor</th>
                            <th>StrokeColor</th>
                            <th>StrokeStyle</th>
                            <th>BrushColor</th>
                            <th>FontFamily</th>
                            <th>FontWeight</th>
                            <th>TextAlign</th>
                            <th>OriginX</th>
                            <th>OriginY</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" name="obj_fill" id="obj_fill" class="input_size_param" /></td>
                            <td><input type="text" name="obj_stroke" id="obj_stroke" class="input_size_param" /></td>
                            <td><input type="text" name="obj_stroke_style" id="obj_stroke_style" class="input_size_param" /></td>
                            <td><input type="text" name="obj_free_drawing_brush_color" id="obj_free_drawing_brush_color" class="input_size_param" /></td>
                            <td><input type="text" name="obj_font_family" id="obj_font_family" class="input_size_param" /></td>
                            <td><input type="text" name="obj_font_weight" id="obj_font_weight" class="input_size_param" /></td>
                            <td><input type="text" name="obj_text_align" id="obj_text_align" class="input_size_param" /></td>
                            <td><input type="text" name="obj_origin_x" id="obj_origin_x" class="input_size_param" /></td>
                            <td><input type="text" name="obj_origin_y" id="obj_origin_y" class="input_size_param" /></td>
                        </tr>
                    </tbody>
                </table>

                <table>
                    <thead>
                        <tr>
                            <th>DrawPoints</th>
                            <th>ColorStops</th>
                            <th>TextBaseline</th>
                            <th>Shadow</th>
                            <th>BackgroundColor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><textarea name="obj_draw_points" id="obj_draw_points" rows="3" cols="30"></textarea></td>
                            <td><textarea name="obj_color_stops" id="obj_color_stops" rows="3" cols="30"></textarea></td>
                            <td><input type="text" name="obj_text_baseline" id="obj_text_baseline" class="input_size_param" /></td>
                            <td><input type="text" name="obj_shadow" id="obj_shadow" class="input_size_param" /></td>
                            <td><input type="text" name="obj_text_background_color" id="obj_text_background_color" class="input_size_param" /></td>
                        </tr>
                    </tbody>
                </table>

                <table>
                    <thead>
                        <tr>
                            <th>Underline</th>
                            <th>Linethrough</th>
                            <th>Overline</th>
                            <th>FlipX</th>
                            <th>FlipY</th>
                            <th>Selectable</th>
                            <th>ObjectCaching</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="checkbox" name="obj_underline" id="obj_underline" value="false" /></td>
                            <td><input type="checkbox" name="obj_linethrough" id="obj_linethrough" value="false" /></td>
                            <td><input type="checkbox" name="obj_overline" id="obj_overline" value="false" /></td>
                            <td><input type="checkbox" name="obj_flip_x" id="obj_flip_x" value="false" /></td>
                            <td><input type="checkbox" name="obj_flip_y" id="obj_flip_y" value="false" /></td>
                            <td><input type="checkbox" name="obj_selectable" id="obj_selectable" value="false" /></td>
                            <td><input type="checkbox" name="obj_object_caching" id="obj_object_caching" value="false" /></td>
                        </tr>
                    </tbody>
                </table>

                <table>
                    <thead>
                        <tr>
                            <th>File load</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                Img : <input type="file" name="img_upload" id="img_upload" /><br />
                                <div class="imageDiffCanvasWindow">Simple image diff</div>
                                <div class="animateCanvasWindow">Animate canvas</div>
                                <div class="weaveCanvasWindow">Weave canvas</div>
                            </td>
                            <td>
                                <label for="slider_image_check"><input type="checkbox" name="slider_image_check" id="slider_image_check" value="1" />Slider image</label>
                                <label for="image_object_check"><input type="checkbox" name="image_object_check" id="image_object_check" value="1" checked />Image Object</label>
                             </td>
                            <td>
                                <label for="object_image_radio"><input type="radio" name="image_radio" id="object_image_radio" value="1" checked />Object image</label>
                                <label for="background_image_radio"><input type="radio" name="image_radio" id="background_image_radio" value="2" />Background image</label>
                                <label for="overlay_image_radio"><input type="radio" name="image_radio" id="overlay_image_radio" value="3" />Overlay image</label>
                            </td>
                            <td>
                                <label for="image_base64_check"><input type="checkbox" name="image_base64_check" id="image_base64_check" value="1" checked />Base64 Data</label>
                                <label for="image_json_check"><input type="checkbox" name="image_json_check" id="image_json_check" value="1" checked />Json Data</label>
                                <label for="image_svg_check"><input type="checkbox" name="image_svg_check" id="image_svg_check" value="1" checked />SVG Data</label>
                            </td>
                        </tr>
                        <tr>
                            <td>SVG : <input type="file" name="svg_upload" id="svg_upload" /></td>
                            <td id="video_upload_area">Video : <input type="file" name="video_upload" id="video_upload" /></td>
                        </tr>
                    </tbody>
                </table>

                <table>
                    <thead>
                        <tr>
                            <th>String</th>
                            <th>Path</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><textarea name="obj_string" id="obj_string" rows="3" cols="30"></textarea></td>
                            <td><textarea name="obj_path" id="obj_path" rows="3" cols="35"></textarea></td>
                            <td>
                                <label for="drawing_mode_check"><input type="checkbox" name="drawing_mode_check" id="drawing_mode_check" value="1" />Drawing mode</label>
                                <label for="zoom_panning_check"><input type="checkbox" name="zoom_panning_check" id="zoom_panning_check" value="1" />Zoom and panning</label>
                                <!-- ver5.3 not available 
                                <label for="webcam_check"><input type="checkbox" name="webcam_check" id="webcam_check" value="1" />Web camera use</label>
                                -->
                            </td>
                            <td>
                                <label for="panel_img_resize_check"><input type="checkbox" name="panel_img_resize_check" id="panel_img_resize_check" value="1" checked />
                                    Panel img resize
                                </label>
                                <label for="video_image_capture_check"><input type="checkbox" name="video_image_capture_check" id="video_image_capture_check" value="1" checked />
                                    Video image capture
                                </label>
                                <label for="object_slider_check"><input type="checkbox" name="object_slider_check" id="object_slider_check" value="1" />
                                    Object slider view
                                </label>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <label for="select_object_name" class="col-sm-3 control-label">Object Name</label>
                <select name="select_object_name" id="select_object_name" class="form-control input_size_200">
                    <option value=""></option>
                    <option value="circle">Create Circle</option>
                    <option value="ellipse">Create Ellipse</option>
                    <option value="line">Create Line</option>
                    <option value="polygon">Create Polygon</option>
                    <option value="polyline">Create Polyline</option>
                    <option value="rect">Create Rect</option>
                    <option value="triangle">Create Triangle</option>
                    <option value="text">Create Text</option>
                    <option value="textbox">Create TextBox</option>
                    <option value="stextbox">Create STextBox</option>
                    <option value="path">Create Path</option>
                </select>

                <input type="button" name="button_reload" id="button_reload" value="Reload" class="reloadObject" />
                <button type="button" onClick="clearCanvas();">Clear</button>
                <button type="button" onClick="undoCanvas();">Undo</button>
                <button type="button" onClick="redoCanvas();">Redo</button>
                <button type="button" onClick="convertCanvasData(baseCanvas);">Json and SVG</button>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-3">
                <button type="submit" class="btn btn-default">
                    <i class="fa fa-plus"></i> Add DB
                </button>
                <button type="button" onClick="setObjectGradientFill(baseCanvas);">Select Gradient</button>
                <button type="button" onClick="allCanvasObjectsGroup('base');">Objects Group</button>
                <button type="button" onClick="discardCanvasGroup('base');">Group Discard</button>
                <button type="button" onClick="loadCreatejsDataForFabric();">SVG to Createjs</button>
                <button type="button" onClick="allCanvasClear();">All Canvas Clear</button>
                <button type="button" onClick="loadCreatejsData();">Createjs</button>
                <button type="button" onClick="addImageCreatejsData();">Createjs Add Image</button>
                <button type="button" onClick="loadSVGData();">Createjs SVG</button>
            </div>
            <div class="col-sm-offset-3 col-sm-3">
                <table>
                    <thead>
                        <tr>
                            <th>AnimateType</th>
                            <th>&nbsp;</th>
                            <th>AnimateDuration</th>
                            <th>AnimateAlign</th>
                            <th>AnimateValue</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select name="select_animate_type" id="select_animate_type" class="form-control input_size_200">
                                    <option value=""></option>
                                    <option value="InBack">InBack</option>
                                    <option value="InBounce">InBounce</option>
                                    <option value="InCirc">InCirc</option>
                                    <option value="InCubic">InCubic</option>
                                    <option value="InExpo">InExpo</option>
                                    <option value="InOutBack">InOutBack</option>
                                    <option value="InOutBounce">InOutBounce</option>
                                    <option value="InOutCirc">InOutCirc</option>
                                    <option value="InOutCubic">InOutCubic</option>
                                    <option value="InOutElastic">InOutElastic</option>
                                    <option value="InOutExpo">InOutExpo</option>
                                    <option value="InOutQuad">InOutQuad</option>
                                    <option value="InOutQuart">InOutQuart</option>
                                    <option value="InOutQuint">InOutQuint</option>
                                    <option value="InOutSine">InOutSine</option>
                                    <option value="InQuad">InQuad</option>
                                    <option value="InQuart">InQuart</option>
                                    <option value="InQuint">InQuint</option>
                                    <option value="InSine">InSine</option>
                                    <option value="OutBack">OutBack</option>
                                    <option value="OutBounce">OutBounce</option>
                                    <option value="OutCirc">OutCirc</option>
                                    <option value="OutCubic">OutCubic</option>
                                    <option value="OutElastic">OutElastic</option>
                                    <option value="OutExpo">OutExpo</option>
                                    <option value="OutQuad">OutQuad</option>
                                    <option value="OutQuart">OutQuart</option>
                                    <option value="OutQuint">OutQuint</option>
                                    <option value="OutSine">OutSine</option>
                                </select>
                            </td>
                            <td><button type="button" onClick="animateCanvas(baseCanvas);">Animate</button></td>
                            <td><input type="text" name="obj_animate_duration" id="obj_animate_duration" class="input_size_param" /></td>
                            <td><input type="text" name="obj_animate_align" id="obj_animate_align" class="input_size_param" /></td>
                            <td><input type="text" name="obj_animate_value" id="obj_animate_value" class="input_size_param" /></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Canvas -->
        <div class="base_canvas_container">
            <img class="frame_img" src="./img/frame.png">
            <canvas id="baseCanvas" width="640" height="480"></canvas>
            <p class="canvas_title">Fabric base</p>
        </div>

        <div class="tmp_canvas_container">
            <canvas id="tmpCanvas" width="100" height="360"></canvas>
            <p class="tmp_canvas_title tmpCanvasWindow">Fabric tmp</p>
        </div>

        <div class="cs_canvas_container">
            <canvas id="csCanvas" width="640" height="480"></canvas>
            <p class="canvas_title">Createjs-Easeljs</p>
        </div>

        <div class="panel_canvas_container">
            <img class="frame_img" src="./img/frame2.png">
            <canvas id="panelCanvas" width="640" height="480"></canvas>
            <p class="canvas_title panelCanvasWindow">Fabric panel</p>
        </div>

        <video width="640" height="480" id="video" style="display: none" muted></video>
        <video width="640" height="480" id="webCam" style="display: none" muted></video>
    </form>

    <div id="video_copy_div" style="display: none"></div>

    <!-- Fabric List -->
    <div class="list_container">
        <h2>Fabric List</h2>
        <table class="table table-striped fabric-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Json</th>
                    <th>SVG</th>
                    <th>Delete</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($fabric as $data)
                    <tr>
                        <td>
                            <div>{{ $data->name }}</div>
                        </td>
                        <td>
                            @if ('' != $data->logic_name)
                            <p>{{ $data->logic_name }}</p>
                            @endif
                            @if ('' != $data->physics_name)
                            <a href="./upload/img/{{ $data->physics_name }}" target="_blank">
                                <img src="./upload/img/{{ $data->physics_name }}" id="img_id_{{ $data->id }}" class="img_size_100" />
                            </a>
                            @endif
                        </td>
                        <td>
                            @if ('' != $data->json_name)
                            <a href="./output/json/{{ $data->json_name }}" target="_blank">Json</a>
                            @endif
                        </td>
                        <td>
                            @if ('' != $data->svg_name)
                            <a href="./output/svg/{{ $data->svg_name }}" target="_blank">
                                <img src="./output/svg/{{ $data->svg_name }}" id="svg_id_{{ $data->id }}" class="img_size_100" />
                            </a>
                            @endif
                        </td>
                        <td>
                            <form action="/fabric/{{ $data->id }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button>Delete Fabric</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <span id="tmp_object_menu" class="context-menu-tmp btn btn-neutral square_btn">Tmp object menu</span>
    <span id="base_object_menu" class="context-menu-base btn btn-neutral square_btn">Base object menu</span>
    <span id="createjs_object_menu" class="context-menu-createjs btn btn-neutral square_btn">Createjs object menu</span>
    <span id="panel_object_menu" class="context-menu-panel btn btn-neutral square_btn">Panel object menu</span>

    <span id="freedrawing_width_view"></span>
    <span id="freedrawing_color_view"></span>

    <span id="coordinate_no_view"></span>
    <span id="coordinate_x_view"></span>
    <span id="coordinate_y_view"></span>
    <span id="coordinate_x1_view"></span>
    <span id="coordinate_y1_view"></span>
    <span id="coordinate_x2_view"></span>
    <span id="coordinate_y2_view"></span>

    <img src="./img/slider_before_btn.png" id="slider_before_btn" class="slider_before_btn" style="position: absolute; display:none">
    <img src="./img/slider_after_btn.png" id="slider_after_btn" class="slider_after_btn" style="position: absolute; display:none">

    <script type="text/javascript">
        baseCanvas = new fabric.Canvas('baseCanvas');
        tmpCanvas = new fabric.Canvas('tmpCanvas');
        panelCanvas = new fabric.Canvas('panelCanvas');

        var stage = new createjs.Stage('csCanvas');

        $('#select_object_name').change(function() {
            var functionName = $('#select_object_name').val();

            executeCallback(baseCanvas, functionName, 'base');
        });

        function addImageCreatejsData() {
            if (null != imgBase64 && '' !== imgBase64) {
                var imageObject = document.createElement('img');
                imageObject.setAttribute('src', imgBase64);
                var img = new createjs.Bitmap(imageObject);

                img.scaleX = $('#obj_scale_x').val();
                img.scaleY = $('#obj_scale_y').val();
                img.x = $('#obj_x1').val();
                img.y = $('#obj_y1').val();

                img.addEventListener('mousedown', startDrag);
                stage.addChild(img);

                createjs.Ticker.setFPS(30);
                createjs.Ticker.addEventListener('tick', function(){
                    stage.update();
                });
            }
        }

        function loadCreatejsDataForFabric() {
            convertCanvasData(baseCanvas);
            tmpSVGFileUpload();

            setTimeout(function(){
                createjsLoader();
            }, 500);
        }

        function createjsLoader() {
            var filePath = './upload/tmp/' + $('#svg_physics_name').val();

            var loader = new createjs.LoadQueue(true);

            loader.addEventListener('fileload', svgDraw);
            loader.loadFile({src: filePath, type: createjs.AbstractLoader.SVG});
        }

        function svgDraw(eventObj) {
            var bitmap = new createjs.Bitmap(eventObj.item.src);

            bitmap.image.onload = function() {
                bitmap.scaleX = $('#obj_scale_x').val();
                bitmap.scaleY = $('#obj_scale_y').val();
                bitmap.x = $('#obj_x1').val();
                bitmap.y = $('#obj_y1').val();

                bitmap.addEventListener('mousedown', startDrag);
                stage.addChild(bitmap);

                createjs.Ticker.setFPS(30);
                createjs.Ticker.addEventListener('tick', function(){
                    stage.update();
                });
            };

            runExport();
        }

        function createjsSetup() {
/*
            var mask = new createjs.Shape();
            mask.graphics.beginFill($('#obj_fill').val()).drawEllipse($('#obj_x1').val(), $('#obj_y1').val(), $('#obj_x2').val(), $('#obj_y2').val());
            stage.mask = mask;
*/
            if (null != imgBase64 && '' !== imgBase64) {
                var imageObject = document.createElement('img');
                imageObject.setAttribute('src', imgBase64);
                var img = new createjs.Bitmap(imageObject);

                img.scaleX = $('#obj_scale_x').val();
                img.scaleY = $('#obj_scale_y').val();
                img.x = $('#obj_x1').val();
                img.y = $('#obj_y1').val();

                img.addEventListener('mousedown', startDrag);
                stage.addChild(img);

                createjs.Ticker.setFPS(30);
                createjs.Ticker.addEventListener('tick', function() {
                    stage.update();
                });
            }
/**/
            var shape = new createjs.Shape();
            shape.graphics.beginStroke($('#obj_stroke').val());
            shape.graphics.beginFill($('#obj_fill').val()).drawRect($('#obj_x1').val(), $('#obj_y1').val(), $('#obj_x2').val(), $('#obj_y2').val());
            shape.x = 5 + $('#obj_x1').val();
            shape.y = 5 + $('#obj_y1').val();
            //shape.alpha = $('#obj_alpha').val(); // TODO : alphaを設定するとSVGExporterでエラーとなる
            shape.addEventListener('mousedown', startDrag);
            stage.addChild(shape);
/**/
            var text = new createjs.Text($('#obj_string').val(), $('#obj_font_size').val() + 'px ' + $('#obj_font_family').val(), $('#obj_fill').val());

            text.x = 5 + $('#obj_x1').val();
            text.y = 5 + $('#obj_y1').val();
            text.lineWidth = $('#obj_width').val();
            text.textAlign = $('#obj_text_align').val();
            text.textBaseline = $('#obj_text_baseline').val();
            text.outline = $('#obj_stroke_width').val();
            text.addEventListener('mousedown', startDrag);
            stage.addChild(text);

            stage.update();
        }

        function startDrag(eventObject) {
            var instance = eventObject.target;
            instance.addEventListener('pressmove', drag);
            instance.addEventListener('pressup', stopDrag);
            instance.offset = new createjs.Point(instance.x - eventObject.stageX, instance.y - eventObject.stageY);
        }

        function drag(eventObject) {
            var instance = eventObject.target;
            var offset = instance.offset;
            instance.x = eventObject.stageX + offset.x;
            instance.y = eventObject.stageY + offset.y;
            stage.update();
        }

        function stopDrag(eventObject) {
            var instance = eventObject.target;
            instance.removeEventListener('pressmove', drag);
            instance.removeEventListener('pressup', stopDrag);
        }

        function loadCreatejsData() {
            createjsSetup();
            runExport();
        }

        function loadSVGData() {
            runExport();
        }

        function runExport() {
            var exporter = new SVGExporter(stage, false, false, false);
            exporter.run();

            var serializer = new XMLSerializer();
            var svgStr = serializer.serializeToString(exporter.svg);

            $('#image_svg').val(svgStr);
        }

        function createjsSaveToSVG() {
            runExport();

            var svg = $('#image_svg').val();

            if (CLICK_OVER_LENGTH < svg.length) {
                alert('Sorry, SVG is 2MB over.');
                return;
            }

            var a = document.createElement('a');
            a.href = 'data:image/svg+xml;utf8,' + unescape(svg);
            a.download = saveSVGFileName;
            a.target = '_blank';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }

        function allCanvasClear() {
            stage = new createjs.Stage('csCanvas');
            stage.update();

            clearCanvas();
        }

        function clearCanvas() {
            baseCanvas.clear();
            tmpCanvas.clear();
            panelCanvas.clear();

            $('#image_json').val('');
            $('#image_svg').val('');
            $('#video_copy_div').remove();
        }

    </script>
@endsection
