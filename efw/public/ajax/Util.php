<?php

/**
 * ユーティリティ
 */
class Util {
    /**
     * ファイルアップロード処理
     *
     * @param string $filePath ファイルパス
     * @param string $keyName キー名称
     * @param integer $maxSize 最大サイズ
     * @throws Exception ファイルアップロード例外
     */
    public function uploadFile($filePath, $keyName, $maxSize = 1024 * 1000 * 1000 * 5) {
        try {
            if (is_uploaded_file($_FILES[$keyName]['tmp_name'])) {
                if ($maxSize < filesize($_FILES[$keyName]['tmp_name'])) {
                    throw new Exception('upload error.');
                }

                if (!move_uploaded_file($_FILES[$keyName]['tmp_name'], $filePath)) {
                    throw new Exception('upload error.');
                }
            } else {
                throw new Exception('upload error.');
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * ファイルアップロード物理ファイル名を返す
     *
     * @param string $addString 追加文字列
     * @return string 物理ファイル名
     */
    public function getFileUploadPhysicsFileName($addString = null) {
        $result = null;

        $result = date('YmdHis') . substr(explode(".", (microtime(true) . ""))[1], 0, 4);

        if (!is_null($addString)) {
            $result .= $addString;
        }

        return $result;
    }

    /**
     * ドキュメントルートを返す
     *
     * @return string ドキュメントルート
     */
    public function getDocRoot() {
        $docRoot = '';

        return $docRoot;
    }
}