<?php

namespace freamwork;

use Medoo\Medoo;

/**
 * 数据库连接模型
 * Class Model
 * @package freamwork
 */
class Model {

    static $db = [];

    /**
     * 获取连接句柄
     * @param string $configFile
     * @return Medoo
     */
    public static function db($configFile = '') {
        $configFile = $configFile ? $configFile : 'database';
        $dbconfig   = require __DIR__ . "/../config/" . $configFile . '.php';
        if (self::$db) {
            return self::$db;
        } else {
            $database = new Medoo($dbconfig);
            self::$db = $database;
            return $database;
        }
    }

}