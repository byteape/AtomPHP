<?php
/**
 * Created by PhpStorm.
 * Author: wgl
 * Time:2019-01-18 11:26
 */

return [
    // 输入变量是否自动强制转换为字符串 如果开启则数组变量需要手动传入变量修饰符获取变量
    'VAR_AUTO_STRING'    => false,

    //是否自动加载model文件
    'AUTO_LOAD_MODEL'    => true,

    //url模式[0]普通模式 [1]pathinfo [2]rewrite,需要重写规则
    'URL_MODEL'          => 2,

    //伪静态后缀设置
    'URL_HTML_SUFFIX'    => 'html',

    //是否开启session
    'SESSION_AUTO_START' => true,

    //SESSION前缀
    'SESSION_PREFIX'     => 'atom_',

    //sessionID的提交变量
    'VAR_SESSION_ID'     => 'session_id',

    // session hander类型 默认无需设置 除非扩展了session hander驱动
    'SESSION_TYPE'       => '',


    /* Cookie设置 */
    'COOKIE_EXPIRE'      => 0,       // Cookie有效期
    'COOKIE_DOMAIN'      => '',      // Cookie有效域名
    'COOKIE_PATH'        => '/',     // Cookie路径
    'COOKIE_PREFIX'      => '',      // Cookie前缀 避免冲突
    'COOKIE_SECURE'      => false,   // Cookie安全传输
    'COOKIE_HTTPONLY'    => '',      // Cookie httponly设置

    'DEFAULT_AJAX_RETURN'   => 'JSON',  // 默认AJAX 数据返回格式,可选JSON XML ...
    'DEFAULT_JSONP_HANDLER' => 'jsonpReturn', // 默认JSONP格式返回的处理方法
    'VAR_AJAX_SUBMIT'       => 'ajax',  // 默认的AJAX提交变量
];