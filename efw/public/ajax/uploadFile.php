<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ajax/Util.php');

if (!headers_sent()) {
    header('Content-type: text/plain; charset= UTF-8');
}

$util = new Util();
$result = array();
$path = null;
$mode = $_POST['upload_mode'];
$docRoot = $util->getDocRoot();

if ('' !== $docRoot) {
    $path = $docRoot;
} else {
    $path = $_SERVER['DOCUMENT_ROOT'];
}

if (('img' == $mode || 'slider_img' == $mode) && isset($_FILES['img_upload']['tmp_name'])
    && is_uploaded_file($_FILES['img_upload']['tmp_name'])) {
    try {
        $filePhysicsName = $util->getFileUploadPhysicsFileName();
        $ext = pathinfo($_FILES['img_upload']['name'], PATHINFO_EXTENSION);

        switch ($ext) {
            case 'png':
			case 'PNG':
            case 'gif':
			case 'GIF':
            case 'jpg':
			case 'JPG':
            case 'jpeg':
			case 'JPEG':
            case 'bmp':
			case 'BMP':
                if ('img' == $mode) {
                    $path .= '/upload/img/';
                } else if ('slider_img' == $mode) {
                    $path .= '/upload/slider_img/';
                }
                break;
            default:
                $path .= '/upload/etc/';
                break;
        }

        $filePhysicsName .=  '.' . $ext;

        $filePhysicsPath = $path . $filePhysicsName;

        $util->uploadFile($filePhysicsPath, 'img_upload');

        $result['info'] = array($filePhysicsName);
    } catch (Exception $e) {
        error_log($e->getMessage());
    }
} else if ('svg' == $mode && isset($_FILES['svg_upload']['tmp_name'])
    && is_uploaded_file($_FILES['svg_upload']['tmp_name'])) {
    try {
        $path .= '/upload/svg/';
        $filePhysicsName = $util->getFileUploadPhysicsFileName();
        $ext = pathinfo($_FILES['svg_upload']['name'], PATHINFO_EXTENSION);

        $filePhysicsName .=  '.' . $ext;

        $filePhysicsPath = $path . $filePhysicsName;

        $util->uploadFile($filePhysicsPath, 'svg_upload');

        $result['info'] = array($filePhysicsName);
    } catch (Exception $e) {
        error_log($e->getMessage());
    }
} else if ('tmp_svg' == $mode && isset($_POST['image_svg'])) {
    try {
        $path .= '/upload/tmp/';
        $filePhysicsName = $util->getFileUploadPhysicsFileName();
        $ext = 'svg';

        $filePhysicsName .=  '.' . $ext;

        $filePhysicsPath = $path . $filePhysicsName;

        file_put_contents($filePhysicsPath, $_POST['image_svg']);

        $result['info'] = array($filePhysicsName);
    } catch (Exception $e) {
        error_log($e->getMessage());
    }
} else if ('video' == $mode && isset($_FILES['video_upload']['tmp_name'])
    && is_uploaded_file($_FILES['video_upload']['tmp_name'])) {
    try {
        $path .= '/upload/video/';
        $filePhysicsName = $util->getFileUploadPhysicsFileName();
        $ext = pathinfo($_FILES['video_upload']['name'], PATHINFO_EXTENSION);

        $filePhysicsName .=  '.' . $ext;

        $filePhysicsPath = $path . $filePhysicsName;

        $util->uploadFile($filePhysicsPath, 'video_upload', 1024 * 1000 * 1000 * 128);

        $result['info'] = array($filePhysicsName);
    } catch (Exception $e) {
        error_log($e->getMessage());
    }
} else if ('click_over' == $mode && isset($_POST['upload_dl_data']) && isset($_POST['upload_dl_ext'])) {
    try {
        $path .= '/upload/weave/';
        $filePhysicsName = $util->getFileUploadPhysicsFileName();
        $ext = $_POST['upload_dl_ext'];

        $filePhysicsName .=  '.' . $ext;

        $filePhysicsPath = $path . $filePhysicsName;

        if ('svg' == $ext) {
            file_put_contents($filePhysicsPath, $_POST['upload_dl_data']);
        } else if ('png' == $ext) {
            $base64 = str_replace('data:image/png;base64,', '', $_POST['upload_dl_data']);
            $base64 = str_replace(' ', '+', $base64);

            file_put_contents($filePhysicsPath, base64_decode($base64));
        }

        $result['info'] = array($filePhysicsName);
    } catch (Exception $e) {
        error_log($e->getMessage());
    }
}

echo json_encode($result);
exit;
