<?php

namespace freamwork;

/**
 * 多语言
 * Class Lanuage
 * @package freamwork
 */
class Lanuage {

    /**
     * 只加载一次的配置数据
     * @var array
     */
    static $lData = [];

    /**
     * 获取语言文件
     * @param $key
     * @return mixed
     */
    public static function get($key) {
        $directory    = __DIR__ . '/../resources/languages/';
        $languageFile = $directory . Config::get('app', 'LANGUAGE') . '.php';

        if (self::$lData) {
            $data = self::$lData;
        } else {
            $data        = require_once $languageFile;
            self::$lData = $data;
        }

        return isset($data[$key]) ? $data[$key] : '';
    }
}