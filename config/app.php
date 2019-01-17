<?php
/**
 * 应用配置文件
 */
return [

    //缓存引擎
    'CACHE_DRIVER'      => 'file',

    //调试模式
    'APP_DEBUG'         => getenv('APP_DEBUG') == 'true' ? true : false,

    // 输入变量是否自动强制转换为字符串 如果开启则数组变量需要手动传入变量修饰符获取变量
    'VAR_AUTO_STRING'   => false,
    // 默认参数过滤方法...
    'DEFAULT_FILTER'    => 'htmlspecialchars',

    // PATHINFO模式下，各参数之间的分割符号
    'URL_PATHINFO_DEPR' => '-',

    //模板文件后缀
    'TPL_SUFFIX'        => '.html',

    //默认语言包
    'LANGUAGE'          => 'zh-cn',

    //是否自动加载model文件
    'AUTO_LOAD_MODEL'   => true,

];