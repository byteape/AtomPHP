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
        $request = $_REQUEST;

        $urlModel = config('URL_MODEL');
        if ($urlModel == 0) {
            $controller = ucfirst(isset($request['c']) ? $request['c'] : 'Index');
            $action     = isset($request['a']) ? $request['a'] : 'index';
        } else if (($urlModel == 1 || $urlModel == 2) && !empty($_SERVER['PATH_INFO'])) {
            $pathArr = explode('/', $_SERVER['PATH_INFO']);
            $caArr   = [];
            foreach ($pathArr as $k => $v) {
                if ($v) {
                    $caArr[] = preg_replace('/\.' . config('URL_HTML_SUFFIX') . '(.*)?/i', '', $v);
                }
            }
            $controller = ucfirst(isset($caArr[0]) ? $caArr[0] : 'Index');
            $action     = isset($caArr[1]) ? $caArr[1] : 'index';
        } else {
            $controller = 'Index';
            $action     = 'index';
        }

        //定义常量
        define('CONTROLLER_NAME', $controller);
        define('ACTION_NAME', $action);
        define('IS_AJAX', ((isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') || !empty($_POST[config('VAR_AJAX_SUBMIT')]) || !empty($_GET[config('VAR_AJAX_SUBMIT')])) ? true : false);

        $controllerFile = __DIR__ . '/../app/Controllers/' . $controller . 'Controller.php';
        require_once $controllerFile;

        //启动session
        if (config('SESSION_AUTO_START')) session_start();

        //实例控制器
        $controller = "\app\Controllers\\" . $controller . "Controller";
        $object     = new $controller();

        //调用方法
        $object->$action();
    }
}