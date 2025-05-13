<!DOCTYPE html>
<html>
    <head>
        <title>Fabric</title>
        <!-- CSS And JavaScript -->
        <script type="text/javascript" src="./../js/jquery-3.7.1.min.js"></script>
        <script type="text/javascript" src="./../js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="./../js/jquery.ui.position.min.js"></script>
        <script type="text/javascript" src="./../js/fabric.min.5.3.js"></script>
        <link rel="stylesheet" href="./../css/gcss20181102.css">
        <link rel="stylesheet" href="./../css/jquery-ui.css">
        <link rel="stylesheet" href="./../css/fabric.css">
        <link rel="stylesheet" href="./../css/normalize.css">
        <link rel="stylesheet" href="./../css/milligram.css">
    </head>
    <body>
        <div class="container">
            <div class="form-group">
                <div class="col-sm-3">
                    <div>Object paramter</div>
                    <table>
                        <thead>
                            <tr>
                                <th>Number</th>
                                <th>&nbsp;</th>
                             </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select name="select_object_number" id="select_object_number" class="form-control input_size_200">
                                        <option value=""></option>
                                        <option id="object_name_rx" style="display: none" value="rx">RX</option>
                                        <option id="object_name_ry" style="display: none" value="ry">RY</option>
                                        <option id="object_name_top" style="display: none" value="top">Top</option>
                                        <option id="object_name_left" style="display: none" value="left">Left</option>
                                        <option id="object_name_width" style="display: none" value="width">Width</option>
                                        <option id="object_name_height" style="display: none" value="height">Height</option>
                                        <option id="object_name_angle" style="display: none" value="angle">Angle</option>
                                        <option id="object_name_radius" style="display: none" value="radius">Radius</option>
                                        <option id="object_name_strokeWidth" style="display: none" value="strokeWidth">StrokeWidth</option>
                                        <option id="object_name_fontSize" style="display: none" value="fontSize">FontSize</option>
                                        <option id="object_name_brushWidth" style="display: none" value="brushWidth">BrushWidth</option>
                                        <option id="object_name_lineHeight" style="display: none" value="lineHeight">LineHeight</option>
                                        <option id="object_name_opacity" style="display: none" value="opacity">Opacity</option>
                                        <option id="object_name_scaleX" style="display: none" value="scaleX">ScaleX</option>
                                        <option id="object_name_scaleY" style="display: none" value="scaleY">ScaleY</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="obj_numer" id="obj_numer" class="input_size_param" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table>
                        <thead>
                             <tr>
                                <th>String</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select name="select_object_string" id="select_object_string" class="form-control input_size_200">
                                        <option value=""></option>
                                        <option id="object_name_fill" style="display: none" value="fill">Fill</option>
                                        <option id="object_name_stroke" style="display: none" value="stroke">Stroke</option>
                                        <option id="object_name_strokeStyle" style="display: none" value="strokeStyle">StrokeStyle</option>
                                        <option id="object_name_fontFamily" style="display: none" value="fontFamily">FontFamily</option>
                                        <option id="object_name_fontWeight" style="display: none" value="fontWeight">FontWeight</option>
                                        <option id="object_name_textAlign" style="display: none" value="textAlign">TextAlign</option>
                                        <option id="object_name_originX" style="display: none" value="originX">OriginX</option>
                                        <option id="object_name_originY" style="display: none" value="originY">OriginY</option>
                                        <option id="object_name_textBaseline" style="display: none" value="textBaseline">TextBaseline</option>
                                        <option id="object_name_shadow" style="display: none" value="shadow">Shadow</option>
                                        <option id="object_name_backgroundColor" style="display: none" value="backgroundColor">BackgroundColor</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="obj_string" id="obj_string" class="input_size_param" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table>
                        <thead>
                             <tr>
                                <th>Boolean</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select name="select_object_boolean" id="select_object_boolean" class="form-control input_size_200">
                                        <option value=""></option>
                                        <option id="object_name_underline" style="display: none" value="underline">Underline</option>
                                        <option id="object_name_linethrough" style="display: none" value="linethrough">Linethrough</option>
                                        <option id="object_name_overline" style="display: none" value="overline">Overline</option>
                                        <option id="object_name_flipX" style="display: none" value="flipX">FlipX</option>
                                        <option id="object_name_flipY" style="display: none" value="flipY">FlipY</option>
                                        <option id="object_name_selectable" style="display: none" value="selectable">Selectable</option>
                                        <option id="object_name_objectCaching" style="display: none" value="objectCaching">ObjectCaching</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="checkbox" name="obj_boolean" id="obj_boolean" class="input_size_param" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <input type="button" id="select_object_update" value="Update" />
                </div>
            </div>
        </div>

        <script type="text/javascript">
            var objectName = 'object_name_';
            var canvas = window.opener.paramterCanvas;
            var obj = null;

            if (canvas.getActiveObject()) {
                obj = canvas.getActiveObject();
            }

            function setCSSDisplay(key, status) {
                $('#' + objectName + key).css('display', status);
            }

            if (null != obj) {
                var keys = [];
                switch (obj.type) {
                    case 'circle':
                        keys = ['top', 'left', 'strokeWidth', 'radius', 'fill', 'stroke', 'selectable', 'objectCaching'];
                        break;
                    case 'ellipse':
                        keys = ['top', 'left', 'rx', 'ry', 'strokeWidth', 'fill', 'stroke', 'selectable', 'objectCaching'];
                        break;
                    case 'line':
                        keys = ['strokeWidth', 'stroke', 'selectable', 'objectCaching'];
                        break;
                    case 'polygon':
                        keys = ['top', 'left', 'strokeWidth', 'fill', 'stroke', 'selectable', 'objectCaching'];
                        break;
                    case 'polyline':
                        keys = ['top', 'left', 'strokeWidth', 'fill', 'stroke', 'selectable', 'objectCaching'];
                        break;
                    case 'rect':
                        keys = ['top', 'left', 'angle', 'strokeWidth', 'fill', 'stroke', 'selectable', 'objectCaching'];
                        break;
                    case 'triangle':
                        keys = ['top', 'left', 'angle', 'strokeWidth', 'fill', 'stroke', 'selectable', 'objectCaching'];
                        break;
                    case 'text':
                    case 'textbox':
                    case 'stextbox':
                        keys = ['top', 'left', 'angle', 'strokeWidth', 'fontSize', 'fill', 'stroke', 'strokeStyle', 'fontFamily', 'fontWeight'
                              , 'underline', 'linethrough', 'overline', 'shadow', 'textAlign', 'textBackgroundColor', 'selectable', 'objectCaching'];
                        break;
                    case 'path':
                        keys = ['top', 'left', 'width', 'height', 'angle', 'strokeWidth', 'fill', 'stroke', 'opacity', 'selectable', 'objectCaching'];
                        break;
                    case 'image':
                        if (obj.getSrc().match(/\.(mp4|webm|ogv)$/i) || obj.getSrc().match(/^blob:http/)) {
                            keys = ['top', 'left', 'angle', 'opacity', 'originX', 'originY', 'flipX', 'flipY', 'objectCaching', 'selectable', 'objectCaching'];
                        } else {
                            keys = ['top', 'left', 'angle', 'opacity', 'flipX', 'flipY', 'selectable', 'objectCaching'];
                        }
                        break;
                }

                var cnt = keys.length;

                for (var i = 0; i < cnt; i++) {
                    setCSSDisplay(keys[i], 'block');
                }
            }

            $('#select_object_update').on('click', function() {
                if (null == obj) {
                    return;
                }

                var param = $('#select_object_number').val();

                if ('' !== param) {
                    if ('rx' === param && undefined != obj.rx) {
                        obj.rx = $('#obj_numer').val();
                    } else if ('ry' === param && undefined != obj.ry) {
                        obj.ry = $('#obj_numer').val();
                    } else if ('top' === param && undefined != obj.top) {
                        obj.top = $('#obj_numer').val();
                    } else if ('left' === param && undefined != obj.left) {
                        obj.left = $('#obj_numer').val();
                    } else if ('width' === param && undefined != obj.width) {
                        obj.width = $('#obj_numer').val();
                    } else if ('height' === param && undefined != obj.height) {
                        obj.height = $('#obj_numer').val();
                    } else if ('angle' === param && undefined != obj.angle) {
                        obj.angle = $('#obj_numer').val();
                    } else if ('radius' === param && undefined != obj.radius) {
                        obj.radius = $('#obj_numer').val();
                    } else if ('strokeWidth' === param && undefined != obj.strokeWidth) {
                        obj.strokeWidth = $('#obj_numer').val();
                    } else if ('fontSize' === param && undefined != obj.fontSize) {
                        obj.fontSize = $('#obj_numer').val();
                    } else if ('brushWidth' === param && undefined != obj.brushWidth) {
                        obj.brushWidth = $('#obj_numer').val();
                    } else if ('lineHeight' === param && undefined != obj.lineHeight) {
                        obj.lineHeight = $('#obj_numer').val();
                    } else if ('opacity' === param && undefined != obj.opacity) {
                        obj.opacity = $('#obj_numer').val();
                    } else if ('scaleX' === param && undefined != obj.scaleX) {
                        obj.scaleX = $('#obj_numer').val();
                    } else if ('scaleY' === param && undefined != obj.scaleY) {
                        obj.scaleY = $('#obj_numer').val();
                    }
                }

                param = $('#select_object_string').val();

                if ('' !== param) {
                    if ('fill' === param && undefined != obj.fill) {
                        obj.fill = $('#obj_string').val();
                    } else if ('stroke' === param && undefined != obj.stroke) {
                        obj.stroke = $('#obj_string').val();
                    } else if ('strokeStyle' === param && undefined != obj.strokeStyle) {
                        obj.strokeStyle = $('#obj_string').val();
                    } else if ('fontFamily' === param && undefined != obj.fontFamily) {
                        obj.fontFamily = $('#obj_string').val();
                    } else if ('fontWeight' === param && undefined != obj.fontWeight) {
                        obj.fontWeight = $('#obj_string').val();
                    } else if ('textAlign' === param && undefined != obj.textAlign) {
                        obj.textAlign = $('#obj_string').val();
                    } else if ('originX' === param && undefined != obj.originX) {
                        obj.originX = $('#obj_string').val();
                    } else if ('originY' === param && undefined != obj.originY) {
                        obj.originY = $('#obj_string').val();
                    } else if ('textBaseline' === param && undefined != obj.textBaseline) {
                        obj.textBaseline = $('#obj_string').val();
                    } else if ('shadow' === param && undefined != obj.shadow) {
                        obj.shadow = $('#obj_string').val();
                    } else if ('backgroundColor' === param && undefined != obj.backgroundColor) {
                        obj.backgroundColor = $('#obj_string').val();
                    }
                }

                param = $('#select_object_boolean').val();

                if ('' !== param) {
                    if ('underline' === param && undefined != obj.underline) {
                        obj.underline = $('#obj_boolean').prop('checked');
                    } else if ('linethrough' === param && undefined != obj.linethrough) {
                        obj.linethrough = $('#obj_boolean').prop('checked');
                    } else if ('overline' === param && undefined != obj.overline) {
                        obj.overline = $('#obj_boolean').prop('checked');
                    } else if ('flipX' === param && undefined != obj.flipX) {
                        obj.flipX = $('#obj_boolean').prop('checked');
                    } else if ('flipY' === param && undefined != obj.flipY) {
                        obj.flipY = $('#obj_boolean').prop('checked');
                    } else if ('selectable' === param && undefined != obj.selectable) {
                        obj.selectable = $('#obj_boolean').prop('checked');
                    } else if ('objectCaching' === param && undefined != obj.objectCaching) {
                        obj.objectCaching = $('#obj_boolean').prop('checked');
                    }
                }

                var tmpObjectCaching = false;

                if (obj.objectCaching) {
                    obj.objectCaching = false;
                    tmpObjectCaching = true;
                }

                canvas.renderAll();

                if (tmpObjectCaching) {
                    obj.objectCaching = true;
                }
            });

            $('#select_object_number').change(function() {
                var param = $('#select_object_number').val();

                if (null == obj || '' === param) {
                    return;
                }

                if ('rx' === param && undefined != obj.rx) {
                    $('#obj_numer').val(obj.rx);
                } else if ('ry' === param && undefined != obj.ry) {
                    $('#obj_numer').val(obj.ry);
                } else if ('top' === param && undefined != obj.top) {
                    $('#obj_numer').val(obj.top);
                } else if ('left' === param && undefined != obj.left) {
                    $('#obj_numer').val(obj.left);
                } else if ('width' === param && undefined != obj.width) {
                    $('#obj_numer').val(obj.width);
                } else if ('height' === param && undefined != obj.height) {
                    $('#obj_numer').val(obj.height);
                } else if ('angle' === param && undefined != obj.angle) {
                    $('#obj_numer').val(obj.angle);
                } else if ('radius' === param && undefined != obj.radius) {
                    $('#obj_numer').val(obj.radius);
                } else if ('strokeWidth' === param && undefined != obj.strokeWidth) {
                    $('#obj_numer').val(obj.strokeWidth);
                } else if ('fontSize' === param && undefined != obj.fontSize) {
                    $('#obj_numer').val(obj.fontSize);
                } else if ('brushWidth' === param && undefined != obj.brushWidth) {
                    $('#obj_numer').val(obj.brushWidth);
                } else if ('lineHeight' === param && undefined != obj.lineHeight) {
                    $('#obj_numer').val(obj.lineHeight);
                } else if ('opacity' === param && undefined != obj.opacity) {
                    $('#obj_numer').val(obj.opacity);
                } else if ('scaleX' === param && undefined != obj.scaleX) {
                    $('#obj_numer').val(obj.scaleX);
                } else if ('scaleY' === param && undefined != obj.scaleY) {
                    $('#obj_numer').val(obj.scaleY);
                }
            });

            $('#select_object_string').change(function() {
                var param = $('#select_object_string').val();

                if (null == obj || '' === param) {
                    return;
                }

                if ('fill' === param && undefined != obj.fill) {
                    $('#obj_string').val(obj.fill);
                } else if ('stroke' === param && undefined != obj.stroke) {
                    $('#obj_string').val(obj.stroke);
                } else if ('strokeStyle' === param && undefined != obj.strokeStyle) {
                    $('#obj_string').val(obj.strokeStyle);
                } else if ('fontFamily' === param && undefined != obj.fontFamily) {
                    $('#obj_string').val(obj.fontFamily);
                } else if ('fontWeight' === param && undefined != obj.fontWeight) {
                    $('#obj_string').val(obj.fontWeight);
                } else if ('textAlign' === param && undefined != obj.textAlign) {
                    $('#obj_string').val(obj.textAlign);
                } else if ('originX' === param && undefined != obj.originX) {
                    $('#obj_string').val(obj.originX);
                } else if ('originY' === param && undefined != obj.originY) {
                    $('#obj_string').val(obj.originY);
                } else if ('textBaseline' === param && undefined != obj.textBaseline) {
                    $('#obj_string').val(obj.textBaseline);
                } else if ('shadow' === param && undefined != obj.shadow) {
                    $('#obj_string').val(obj.shadow);
                } else if ('backgroundColor' === param && undefined != obj.backgroundColor) {
                    $('#obj_string').val(obj.backgroundColor);
                }
            });

            $('#select_object_boolean').change(function() {
                var param = $('#select_object_boolean').val();

                if (null == obj || '' === param) {
                    return;
                }

                if ('underline' === param && undefined != obj.underline) {
                    $('#obj_boolean').prop('checked', obj.underline);
                } else if ('linethrough' === param && undefined != obj.linethrough) {
                    $('#obj_boolean').prop('checked', obj.linethrough);
                } else if ('overline' === param && undefined != obj.overline) {
                    $('#obj_boolean').prop('checked', obj.overline);
                } else if ('flipX' === param && undefined != obj.flipX) {
                    $('#obj_boolean').prop('checked', obj.flipX);
                } else if ('flipY' === param && undefined != obj.flipY) {
                    $('#obj_boolean').prop('checked', obj.flipY);
                } else if ('selectable' === param && undefined != obj.selectable) {
                    $('#obj_boolean').prop('checked', obj.selectable);
                } else if ('objectCaching' === param && undefined != obj.objectCaching) {
                    $('#obj_boolean').prop('checked', obj.objectCaching);
                }
            });

        </script>
    </body>
</html>