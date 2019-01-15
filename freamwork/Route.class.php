<?php

namespace freamwork;


/**
 * 路由处理
 * Class Route
 * @package freamwork
 */
class Route {

    /**
     * 路由调用
     */
    public static function run() {
        $request    = $_REQUEST;
        $controller = ucfirst(isset($request['c']) ? $request['c'] : 'Index');
        $action     = isset($request['a']) ? $request['a'] : 'index';
        require_once __DIR__ . '/../app/Controllers/' . $controller . 'Controller.php';

        //实例控制器
        $controller = "\app\Controllers\\" . $controller . "Controller";
        $object     = new $controller();

        //调用方法
        $object->$action();
    }
}