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
            <div>Tmp canvas</div>
            <canvas id="tmpCanvasWin" width="640" height="480"></canvas>
        </div>
        <script type="text/javascript">
            var pTmpCanvas = window.opener.tmpCanvas;

            var objs = pTmpCanvas.getObjects();
            var cnt = objs.length;

            var tmpCanvasWin = new fabric.Canvas('tmpCanvasWin');

            for (var i = 0; i < cnt; i++) {
                tmpCanvasWin.add(objs[i]);
            }

            tmpCanvasWin.renderAll();
        </script>
    </body>
</html>