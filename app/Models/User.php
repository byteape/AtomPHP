<?php
/**
 * Created by PhpStorm.
 * Author: wgl
 * Time:2019-01-14 15:44
 */

namespace app\Models;

use freamwork\Model;

/**
 * 数据模型
 * Class User
 * @package app\Models
 */
class User extends Model {

    /**
     * 表名
     * @var string
     */
    private static $tableName = 'user';

    public function getname($id) {
        return self::db()->select(self::$tableName, [
            "id",
            "name"
        ], [
            "id" => $id
        ]);
    }
}