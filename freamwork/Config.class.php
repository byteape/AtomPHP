<?php

namespace freamwork;

/**
 * 读取配置
 * Class Config
 * @package freamwork
 */
class Config {

    /**
     * 配置文件目录
     */
    const directory = __DIR__ . '/../config/';

    /**
     * 只加载一次的配置数据
     * @var array
     */
    static $configData = [];

    /**
     * 读取配置文件
     * @param $file
     * @param $key
     * @return mixed
     */
    public static function get($file, $key) {
        $nowFile = self::directory . $file;
        if (self::$configData) {
            $data = self::$configData;
        } else {
            $data             = require_once $nowFile . '.php';
            self::$configData = $data;
        }

        return isset($data[$key]) ? $data[$key] : '';
    }
}