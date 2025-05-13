<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ajax/Util.php');

if (!headers_sent()) {
    header('Content-type: text/plain; charset= UTF-8');
}

$util = new Util();
$result = array();
$path = null;
$mode = $_POST['load_mode'];
$docRoot = $util->getDocRoot();

if ('' !== $docRoot) {
    $path = $docRoot;
} else {
    $path = $_SERVER['DOCUMENT_ROOT'];
}

if ('slider_img' == $mode) {
    try {
        $path .= '/upload/slider_img/*';
        $files = array();

        foreach (glob($path) as $file) {
            if (is_file($file)) {
                $files[] = pathinfo($file, PATHINFO_BASENAME);
            }
        }

        $result['info'] = $files;
    } catch (Exception $e) {
        error_log($e->getMessage());
    }
} else if ('weave_svg' == $mode) {
    try {
        $path .= '/upload/weave/*';
        $files = array();

        foreach (glob($path) as $file) {
            if (is_file($file)) {
                $files[] = pathinfo($file, PATHINFO_BASENAME);
            }
        }

        $result['info'] = $files;
    } catch (Exception $e) {
        error_log($e->getMessage());
    }
} else if ('weave_img' == $mode && isset($_POST['file_name']) && isset($_POST['mime_type'])) {
    try {
        $path .= '/upload/weave/' . $_POST['file_name'];
        $str = file_get_contents($path);
        $base64 = base64_encode($str);
        $base64 = 'data:' . $_POST['mime_type'] . ';base64,' . $base64;

        $result['info'] = $base64;
    } catch (Exception $e) {
        error_log($e->getMessage());
    }
}

echo json_encode($result);
exit;
