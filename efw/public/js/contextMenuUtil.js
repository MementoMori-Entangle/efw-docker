$(function() {
    $.contextMenu({
        selector: '.context-menu-tmp',
        callback: function(key, options) {
            tmpCanvasExceute(key);
        },
        items: {
            'move': {'name': 'Move', 'icon': 'loading'},
            'cut': {'name': 'Cut', 'icon': 'cut'},
            'copy': {'name': 'Copy', 'icon': 'copy'},
            'paste': {'name': 'Paste', 'icon': 'paste'},
            'delete': {'name': 'Delete', 'icon': 'delete'},
            'show': {'name': 'Show', 'icon': 'show'},
            'sep1': '---------',
            'list': {'name': 'List', 'icon': 'list'},
            'clear': {'name': 'Clear', 'icon': 'delete'},
        },
    });

    $('#tmp_object_menu').on('click', function(opt) {
        $('#tmp_object_menu').trigger('contextmenu');
    });
});

$(function() {
    $.contextMenu({
        selector: '.context-menu-base',
        callback: function(key, options) {
            baseCanvasExceute(key, options);
        },
        items: {
            'moveToTmp': {'name': 'MoveToTmp', 'icon': 'loading'},
            'moveToPanel': {'name': 'MoveToPanel', 'icon': 'loading'},
            'show': {'name': 'Show', 'icon': 'show'},
            'paramter': {'name': 'Paramter', 'icon': 'paramter'},

            'fold_freedrawing': {
                'name': 'freedrawing',
                'items': {
                    'freedrawing_width': {
                        'name': 'freedrawing_width',
                        'items': {
                            select: {
                                name: 'freedrawing_width',
                                type: 'select',
                                options: widthMap,
                                selected: 0,
                                events: {
                                    change: function(e) {
                                        baseCanvasExceute('freedrawing_width', e.target.options);
                                    }
                                },
                            },
                        },
                    },
                    'freedrawing_color': {
                        'name': 'freedrawing_color',
                        'items': {
                            select: {
                                name: 'freedrawing_color',
                                type: 'select',
                                options: colorMap,
                                selected: 0,
                                events: {
                                    change: function(e) {
                                        baseCanvasExceute('freedrawing_color', e.target.options);
                                    }
                                },
                            },
                        },
                    },
                },
            },

            'fold_font': {
                'name': 'font',
                'items': {
                    'font_fontSize': {
                        'name': 'font_fontSize',
                        'items': {
                            select: {
                                name: 'font_fontSize',
                                type: 'select',
                                options: sizeMap,
                                selected: 0,
                                events: {
                                    change: function(e) {
                                        baseCanvasExceute('font_fontSize', e.target.options);
                                    }
                                },
                            },
                        },
                    },
                    'font_fill': {
                        'name': 'font_fill',
                        'items': {
                            select: {
                                name: 'font_fill',
                                type: 'select',
                                options: colorMap,
                                selected: 0,
                                events: {
                                    change: function(e) {
                                        baseCanvasExceute('font_fill', e.target.options);
                                    }
                                },
                            },
                        },
                    },
                    'font_fontFamily': {
                        'name': 'font_fontFamily',
                        'items': {
                            select: {
                                name: 'font_fontFamily',
                                type: 'select',
                                options: fontFamilyMap,
                                selected: 0,
                                events: {
                                    change: function(e) {
                                        baseCanvasExceute('font_fontFamily', e.target.options);
                                    }
                                },
                            },
                        },
                    },
                    'font_fontWeight': {
                        'name': 'font_fontWeight',
                        'items': {
                            select: {
                                name: 'font_fontWeight',
                                type: 'select',
                                options: fontWeightMap,
                                selected: 0,
                                events: {
                                    change: function(e) {
                                        baseCanvasExceute('font_fontWeight', e.target.options);
                                    }
                                },
                            },
                        },
                    },
                    'font_textAlign': {
                        'name': 'font_textAlign',
                        'items': {
                            select: {
                                name: 'font_textAlign',
                                type: 'select',
                                options: textAlignMap,
                                selected: 0,
                                events: {
                                    change: function(e) {
                                        baseCanvasExceute('font_textAlign', e.target.options);
                                    }
                                },
                            },
                        },
                    },
                },
            },

            'fold_edit': {
                'name': 'edit',
                'items': {
                    'cut': {'name': 'Cut', 'icon': 'cut'},
                    'copy': {'name': 'Copy', 'icon': 'copy'},
                    'paste': {'name': 'Paste', 'icon': 'paste'},
                    'delete': {'name': 'Delete', 'icon': 'delete'},
                    'showCoordinate': {'name': 'ShowCoordinate', 'icon': 'showcoordinate'},
                    'clearCoordinate': {'name': 'ClearCoordinate', 'icon': 'clearcoordinate'},
                    'rectClip': {'name': 'RectClip', 'icon': 'rectclip'},
                    'pathClip': {'name': 'PathClip', 'icon': 'pathclip'},
                    'rectCutImg': {'name': 'RectCutImg', 'icon': 'rectcutimg'},
                    'pathCutImg': {'name': 'PathCutImg', 'icon': 'pathcutimg'},
                    'sendBackwards': {'name': 'SendBackwards', 'icon': 'sendbackwards'},
                    'sendToBack': {'name': 'SendToBack', 'icon': 'sendtoback'},
                    'bringForward': {'name': 'BringForward', 'icon': 'bringforward'},
                    'bringToFront': {'name': 'BringToFront', 'icon': 'bringtofront'},
                },
            },

            'fold_video': {
                'name': 'video',
                'items': {
                    'play': {'name': 'Play', 'icon': 'play'},
                    'pause': {'name': 'Pause', 'icon': 'pause'},
                    'currentToTop': {'name': 'CurrentToTop', 'icon': 'currenttotop'},
                    'currentTimePlus': {'name': 'CurrentTimePlus', 'icon': 'currenttimeplus'},
                    'currentTimeMinus': {'name': 'CurrentTimeMinus', 'icon': 'currenttimeminus'},
                    'upVolume': {'name': 'UpVolume', 'icon': 'upvolume'},
                    'downVolume': {'name': 'DownVolume', 'icon': 'downvolume'},
                    'mute': {'name': 'Mute', 'icon': 'mute'},
                    'thumbnail': {'name': 'Thumbnail', 'icon': 'thumbnail'},
                    'thumbnails': {'name': 'Thumbnails', 'icon': 'thumbnails'},
                },
            },

            'sep1': '---------',
            'list': {'name': 'List', 'icon': 'list'},
            'clear': {'name': 'Clear', 'icon': 'delete'},
        }
    });

    $('#base_object_menu').on('click', function(opt) {
        $('#base_object_menu').trigger('contextmenu');
    });
});

$(function() {
    $.contextMenu({
        selector: '.context-menu-createjs',
        callback: function(key, options) {
            createjsSaveToSVG();
        },
        items: {
            'saveToSVG': {'name': 'SaveToSVG', 'icon': 'add'},
        }
    });

    $('#createjs_object_menu').on('click', function(opt) {
        $('#createjs_object_menu').trigger('contextmenu');
    });
});

$(function() {
    $.contextMenu({
        selector: '.context-menu-panel',
        callback: function(key, options) {
            panelCanvasExceute(key);
        },
        items: {
            'saveToSVG': {'name': 'SaveToSVG', 'icon': 'add'},
            'delete': {'name': 'Delete', 'icon': 'delete'},
            'show': {'name': 'Show', 'icon': 'show'},
            'sep1': '---------',
            'list': {'name': 'List', 'icon': 'list'},
            'clear': {'name': 'Clear', 'icon': 'delete'},
        }
    });

    $('#panel_object_menu').on('click', function(opt) {
        $('#panel_object_menu').trigger('contextmenu');
    });
});
