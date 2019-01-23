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
     * @param array $dbConfig
     * @return Medoo|mixed
     */
    public static function db($configFile = '', $dbConfig = []) {
        $configFile = $configFile ? $configFile : 'database';
        if (self::$_db[$configFile]) {
            return self::$_db[$configFile];
        } else {
            if (!$dbConfig) {
                $dbConfig = require __DIR__ . "/../config/" . $configFile . '.php';
            }
            $database               = new Medoo($dbConfig);
            self::$_db[$configFile] = $database;
            return $database;
        }
    }

}