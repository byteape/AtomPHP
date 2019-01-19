<?php

namespace freamwork;

use Medoo\Medoo;

/**
 * 数据库连接模型
 * Class Model
 * @package freamwork
 */
class Model {

    static $_db = [];

    /**
     * 获取连接句柄
     * @param string $configFile
     * @return Medoo
     */
    public static function db($configFile = '') {
        $configFile = $configFile ? $configFile : 'database';
        $dbconfig   = require __DIR__ . "/../config/" . $configFile . '.php';
        if (self::$_db[$configFile]) {
            return self::$_db[$configFile];
        } else {
            $database               = new Medoo($dbconfig);
            self::$_db[$configFile] = $database;
            return $database;
        }
    }

}