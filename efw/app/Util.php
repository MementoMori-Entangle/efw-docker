<?php

namespace App;

/**
 * ユーティリティ
 */
class Util {
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
}
