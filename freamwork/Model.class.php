<?php

namespace freamwork;

use Medoo\Medoo;

/**
 * 数据库连接模型
 * Class Model
 * @package freamwork
 */
class Model {

    /**
     * 获取连接句柄
     * @return Medoo
     */
    public static function db() {
        $dbconfig = require __DIR__ . "/../config/database.php";
        $database = new Medoo($dbconfig);
        return $database;
    }

}