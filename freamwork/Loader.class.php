<?php
/**
 * Created by PhpStorm.
 * Author: wgl
 * Time:2019-01-15 8:48
 */

namespace freamwork;

/**
 * 自动加载
 * Class Loader
 * @package freamwork
 */
class Loader {
    /**
     * 路径映射
     * @var array
     */
    public static $vendorMap = [
        'app' => __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'app',
    ];

    /**
     * 自动加载器
     * @param $class
     */
    public static function autoload($class) {
        $file = self::findFile($class);
        if (file_exists($file)) {
            self::includeFile($file);
        }
    }

    /**
     * 解析文件路径
     * @param $class
     * @return string
     */
    private static function findFile($class) {
        $vendor    = substr($class, 0, strpos($class, '\\')); // 顶级命名空间
        $vendorDir = self::$vendorMap[$vendor]; // 文件基目录
        $filePath  = substr($class, strlen($vendor)) . '.php'; // 文件相对路径
        return strtr($vendorDir . $filePath, '\\', DIRECTORY_SEPARATOR); // 文件标准路径
    }

    /**
     * 引入文件
     * @param $file
     */
    private static function includeFile($file) {
        if (is_file($file)) {
            include $file;
        }
    }

}