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
    if (($count == 2 && $actArr[0] != '') || $actStr == '') {
        $controller = $actStr ? lcfirst($actArr[0]) : CONTROLLER_NAME;
        $action     = $actStr ? $actArr[1] : ACTION_NAME;

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
                $url .= '&' . implode('&', $paramsArr);
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
        return __ROOT__ . '/';
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
 * @param string $configFile config文件名称
 * @param array $dbConfig 自定义连接数组
 * @return \Medoo\Medoo|mixed
 */
function db($configFile = '', $dbConfig = []) {
    return \freamwork\Model::db($configFile, $dbConfig);
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

/**
 * session管理函数
 * @param string|array $name session名称 如果为数组则表示进行session设置
 * @param mixed $value session值
 * @return mixed
 */
function session($name = '', $value = '') {
    $prefix = config('SESSION_PREFIX');
    if (is_array($name)) { // session初始化 在session_start 之前调用
        if (isset($name['prefix'])) config('SESSION_PREFIX', $name['prefix']);
        if (config('VAR_SESSION_ID') && isset($_REQUEST[config('VAR_SESSION_ID')])) {
            session_id($_REQUEST[config('VAR_SESSION_ID')]);
        } else if (isset($name['id'])) {
            session_id($name['id']);
        }
        if (isset($name['name'])) session_name($name['name']);
        if (isset($name['path'])) session_save_path($name['path']);
        if (isset($name['domain'])) ini_set('session.cookie_domain', $name['domain']);
        if (isset($name['expire'])) {
            ini_set('session.gc_maxlifetime', $name['expire']);
            ini_set('session.cookie_lifetime', $name['expire']);
        }
        if (isset($name['use_trans_sid'])) ini_set('session.use_trans_sid', $name['use_trans_sid'] ? 1 : 0);
        if (isset($name['use_cookies'])) ini_set('session.use_cookies', $name['use_cookies'] ? 1 : 0);
        if (isset($name['cache_limiter'])) session_cache_limiter($name['cache_limiter']);
        if (isset($name['cache_expire'])) session_cache_expire($name['cache_expire']);
        if (isset($name['type'])) config('SESSION_TYPE', $name['type']);
        if (config('SESSION_TYPE')) { // 读取session驱动
            $type   = config('SESSION_TYPE');
            $class  = strpos($type, '\\') ? $type : 'Think\\Session\\Driver\\' . ucwords(strtolower($type));
            $hander = new $class();
            session_set_save_handler(
                array(&$hander, "open"),
                array(&$hander, "close"),
                array(&$hander, "read"),
                array(&$hander, "write"),
                array(&$hander, "destroy"),
                array(&$hander, "gc"));
        }
        // 启动session
        if (config('SESSION_AUTO_START')) session_start();
    } else if ('' === $value) {
        if ('' === $name) {
            // 获取全部的session
            return $prefix ? $_SESSION[$prefix] : $_SESSION;
        } else if (0 === strpos($name, '[')) { // session 操作
            if ('[pause]' == $name) { // 暂停session
                session_write_close();
            } else if ('[start]' == $name) { // 启动session
                session_start();
            } else if ('[destroy]' == $name) { // 销毁session
                $_SESSION = array();
                session_unset();
                session_destroy();
            } else if ('[regenerate]' == $name) { // 重新生成id
                session_regenerate_id();
            }
        } else if (0 === strpos($name, '?')) { // 检查session
            $name = substr($name, 1);
            if (strpos($name, '.')) { // 支持数组
                list($name1, $name2) = explode('.', $name);
                return $prefix ? isset($_SESSION[$prefix][$name1][$name2]) : isset($_SESSION[$name1][$name2]);
            } else {
                return $prefix ? isset($_SESSION[$prefix][$name]) : isset($_SESSION[$name]);
            }
        } else if (is_null($name)) { // 清空session
            if ($prefix) {
                unset($_SESSION[$prefix]);
            } else {
                $_SESSION = array();
            }
        } else if ($prefix) { // 获取session
            if (strpos($name, '.')) {
                list($name1, $name2) = explode('.', $name);
                return isset($_SESSION[$prefix][$name1][$name2]) ? $_SESSION[$prefix][$name1][$name2] : null;
            } else {
                return isset($_SESSION[$prefix][$name]) ? $_SESSION[$prefix][$name] : null;
            }
        } else {
            if (strpos($name, '.')) {
                list($name1, $name2) = explode('.', $name);
                return isset($_SESSION[$name1][$name2]) ? $_SESSION[$name1][$name2] : null;
            } else {
                return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
            }
        }
    } else if (is_null($value)) { // 删除session
        if (strpos($name, '.')) {
            list($name1, $name2) = explode('.', $name);
            if ($prefix) {
                unset($_SESSION[$prefix][$name1][$name2]);
            } else {
                unset($_SESSION[$name1][$name2]);
            }
        } else {
            if ($prefix) {
                unset($_SESSION[$prefix][$name]);
            } else {
                unset($_SESSION[$name]);
            }
        }
    } else { // 设置session
        if (strpos($name, '.')) {
            list($name1, $name2) = explode('.', $name);
            if ($prefix) {
                $_SESSION[$prefix][$name1][$name2] = $value;
            } else {
                $_SESSION[$name1][$name2] = $value;
            }
        } else {
            if ($prefix) {
                $_SESSION[$prefix][$name] = $value;
            } else {
                $_SESSION[$name] = $value;
            }
        }
    }
    return null;
}

/**
 * Cookie 设置、获取、删除
 * @param string $name cookie名称
 * @param mixed $value cookie值
 * @param mixed $option cookie参数
 * @return mixed
 */
function cookie($name = '', $value = '', $option = null) {
    // 默认设置
    $config = array(
        'prefix'   => config('COOKIE_PREFIX'), // cookie 名称前缀
        'expire'   => config('COOKIE_EXPIRE'), // cookie 保存时间
        'path'     => config('COOKIE_PATH'), // cookie 保存路径
        'domain'   => config('COOKIE_DOMAIN'), // cookie 有效域名
        'secure'   => config('COOKIE_SECURE'), //  cookie 启用安全传输
        'httponly' => config('COOKIE_HTTPONLY'), // httponly设置
    );
    // 参数设置(会覆盖黙认设置)
    if (!is_null($option)) {
        if (is_numeric($option))
            $option = array('expire' => $option);
        else if (is_string($option))
            parse_str($option, $option);
        $config = array_merge($config, array_change_key_case($option));
    }
    if (!empty($config['httponly'])) {
        ini_set("session.cookie_httponly", 1);
    }
    // 清除指定前缀的所有cookie
    if (is_null($name)) {
        if (empty($_COOKIE))
            return null;
        // 要删除的cookie前缀，不指定则删除config设置的指定前缀
        $prefix = empty($value) ? $config['prefix'] : $value;
        if (!empty($prefix)) {// 如果前缀为空字符串将不作处理直接返回
            foreach ($_COOKIE as $key => $val) {
                if (0 === stripos($key, $prefix)) {
                    setcookie($key, '', time() - 3600, $config['path'], $config['domain'], $config['secure'], $config['httponly']);
                    unset($_COOKIE[$key]);
                }
            }
        }
        return null;
    } else if ('' === $name) {
        // 获取全部的cookie
        return $_COOKIE;
    }
    $name = $config['prefix'] . str_replace('.', '_', $name);
    if ('' === $value) {
        if (isset($_COOKIE[$name])) {
            $value = $_COOKIE[$name];
            if (0 === strpos($value, 'think:')) {
                $value = substr($value, 6);
                return array_map('urldecode', json_decode(MAGIC_QUOTES_GPC ? stripslashes($value) : $value, true));
            } else {
                return $value;
            }
        } else {
            return null;
        }
    } else {
        if (is_null($value)) {
            setcookie($name, '', time() - 3600, $config['path'], $config['domain'], $config['secure'], $config['httponly']);
            unset($_COOKIE[$name]); // 删除指定cookie
        } else {
            // 设置cookie
            if (is_array($value)) {
                $value = 'think:' . json_encode(array_map('urlencode', $value));
            }
            $expire = !empty($config['expire']) ? time() + intval($config['expire']) : 0;
            setcookie($name, $value, $expire, $config['path'], $config['domain'], $config['secure'], $config['httponly']);
            $_COOKIE[$name] = $value;
        }
    }
    return null;
}

/**
 * URL重定向
 * @param string $url 重定向的URL地址
 * @param integer $time 重定向的等待时间（秒）
 * @param string $msg 重定向前的提示信息
 * @return void
 */
function redirect($url, $time = 0, $msg = '') {
    //多行URL地址支持
    $url = str_replace(array("\n", "\r"), '', url($url));
    if (empty($msg))
        $msg = "系统将在{$time}秒之后自动跳转到{$url}！";
    if (!headers_sent()) {
        // redirect
        if (0 === $time) {
            header('Location: ' . $url);
        } else {
            header("refresh:{$time};url={$url}");
            echo($msg);
        }
        exit();
    } else {
        $str = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
        if ($time != 0)
            $str .= $msg;
        exit($str);
    }
}