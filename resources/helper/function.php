<?php
/**
 * Created by PhpStorm.
 * Author: wgl
 * Time:2019-01-17 9:01
 */

/**
 * url获取
 * @param $actStr
 * @param array $params
 * @return mixed|string
 */
function url($actStr, $params = array()) {
    $actArr = explode('/', $actStr);
    $count  = count($actArr);
    if ($count == 2) {
        $controller = $actArr[0];
        $action     = $actArr[1];

        $url = __ROOT__ . '?c=' . $controller . '&a=' . $action;

        if ($params) {
            $paramsArr[] = '';
            foreach ($params as $k => $v) {
                $paramsArr[] = $k . '=' . $v;
            }
            $url .= implode('&', $paramsArr);
        }
        return $url;
    } else {
        return __ROOT__;
    }
}

/**
 * 获取语言包
 * @param $key
 * @return mixed
 */
function language($key) {
    return \freamwork\Lanuage::get($key);
}

/**
 * 获取配置信息
 * @param $key
 * @param string $file
 * @return mixed
 */
function config($key, $file = '') {
    return \freamwork\Config::get($key, $file);
}