<?php
/**
 * Created by PhpStorm.
 * Author: wgl
 * Time:2019-01-12 11:43
 */

namespace freamwork;

/**
 * url获取
 * Class Url
 * @package freamwork
 */
class Url {

    /**
     * 获取url
     * @param $actStr
     * @param array $params
     * @return mixed|string
     */
    public static function go($actStr, $params = []) {
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
}