<?php

namespace freamwork;

/**
 * 辅助函数
 * Class Helper
 * @package freamwork
 */
class Helper {

    /**
     * 加载
     */
    public static function loader() {
        $directory = __DIR__ . '/../app/Helper';
        $fileList  = scandir($directory);
        $modelNum  = count($fileList);
        if ($modelNum >= 3) {
            for ($i = 2; $i < $modelNum; $i++) {
                require_once $directory . '/' . $fileList[$i];
            }
        }
    }
}

Helper::loader();

