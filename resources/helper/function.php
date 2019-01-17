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
        $controller = lcfirst($actArr[0]);
        $action     = $actArr[1];

        $urlModel = config('URL_MODEL');
        if ($urlModel == 0) {
            $url = __ROOT__ . '/index.php?c=' . $controller . '&a=' . $action;
        } else if ($urlModel == 1) {
            $url = __ROOT__ . '/index.php/' . $controller . '/' . $action . '.' . config('URL_HTML_SUFFIX');
        } else if ($urlModel == 2) {
            $url = __ROOT__ . '/' . $controller . '/' . $action . '.' . config('URL_HTML_SUFFIX');
        }


        if ($params) {
            $paramsArr = [];
            foreach ($params as $k => $v) {
                $paramsArr[] = $k . '=' . $v;
            }
            if ($urlModel == 0) {
                $url .= implode('&', $paramsArr);
            } else if ($urlModel == 1 || $urlModel == 2) {
                if (count($paramsArr) > 1) {
                    $url .= '?' . implode('&', $paramsArr);
                } else {
                    $url .= '?' . $paramsArr[0];
                }
            }
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

/**
 * 获取数据库连接对象
 * @return \Medoo\Medoo
 */
function db() {
    return \freamwork\Model::db();
}

/**
 * 判断是否SSL协议
 * @return boolean
 */
function is_ssl() {
    if (isset($_SERVER['HTTPS']) && ('1' == $_SERVER['HTTPS'] || 'on' == strtolower($_SERVER['HTTPS']))) {
        return true;
    } else if (isset($_SERVER['SERVER_PORT']) && ('443' == $_SERVER['SERVER_PORT'])) {
        return true;
    }
    return false;
}

/**
 * 数组递归处理
 * @param $filter
 * @param $data
 * @return array
 */
function array_map_recursive($filter, $data) {
    $result = array();
    foreach ($data as $key => $val) {
        $result[$key] = is_array($val)
            ? array_map_recursive($filter, $val)
            : call_user_func($filter, $val);
    }
    return $result;
}

/**
 * 安全过滤
 * @param $value
 */
function atom_filter(&$value) {
    // TODO 其他安全过滤
    // 过滤查询特殊字符
    if (preg_match('/^(EXP|NEQ|GT|EGT|LT|ELT|OR|XOR|LIKE|NOTLIKE|NOT BETWEEN|NOTBETWEEN|BETWEEN|NOTIN|NOT IN|IN)$/i', $value)) {
        $value .= ' ';
    }
}

/**
 * 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @param boolean $adv 是否进行高级模式获取（有可能被伪装）
 * @return mixed
 */
function get_client_ip($type = 0, $adv = false) {
    $type = $type ? 1 : 0;
    static $ip = null;
    if ($ip !== null) return $ip[$type];
    if ($adv) {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos = array_search('unknown', $arr);
            if (false !== $pos) unset($arr[$pos]);
            $ip = trim($arr[0]);
        } else if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else if (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
    } else if (isset($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u", ip2long($ip));
    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}

/**
 * 不区分大小写的in_array实现
 * @param $value
 * @param $array
 * @return bool
 */
function in_array_case($value, $array) {
    return in_array(strtolower($value), array_map('strtolower', $array));
}