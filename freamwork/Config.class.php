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
    const directory = [__DIR__ . '/../config/', __DIR__ . '/../resources/config/'];

    /**
     * 只加载一次的配置数据
     * @var array
     */
    static $configData = [];

    /**
     * 读取配置文件
     * @param $key
     * @param string $file
     * @return mixed|string
     */
    public static function get($key, $file = '') {
        if (self::$configData) {
            $data = self::$configData;
        } else {
            $data             = self::getConfigData($file);
            self::$configData = $data;
        }

        return isset($data[$key]) ? $data[$key] : '';
    }

    /**
     * 获取所有配置参数
     * @param string $file
     * @return array|mixed
     */
    public static function getConfigData($file = '') {
        $diretory   = self::directory;
        $configData = [];
        foreach ($diretory as $k => $v) {
            $list = scandir($v);
            $num  = count($list);

            for ($i = 2; $i < $num; $i++) {
                if ($file) {
                    $data       = require_once self::directory . $file . '.php';
                    $configData = $data;
                } else {
                    $data = require_once $v . $list[$i];
                    if (count($data)) {
                        if ($i == 2) {
                            $configData = $data;
                        } else {
                            $configData = array_merge($configData, $data);
                        }
                    }
                }

            }
        }
        return $configData;
    }
}