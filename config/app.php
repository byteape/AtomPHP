<?php
/**
 * 应用配置文件
 */
return [

    //缓存引擎
    'cache_driver'    => 'file',

    //调试模式
    'APP_DEBUG'       => getenv('APP_DEBUG') == 'true' ? 1 : 0,

    // 输入变量是否自动强制转换为字符串 如果开启则数组变量需要手动传入变量修饰符获取变量
    'VAR_AUTO_STRING' => false,
    // 默认参数过滤方法...
    'DEFAULT_FILTER'  => 'htmlspecialchars',


    //默认语言包
    'LANGUAGE'        => 'zh-cn',

    //是否自动加载model文件
    'AUTO_LOAD_MODEL' => false,

];