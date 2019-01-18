<?php
/**
 * 应用配置文件
 */
return [

    //缓存引擎
    'CACHE_DRIVER'   => 'file',

    //调试模式
    'APP_DEBUG'      => getenv('APP_DEBUG') == 'true' ? true : false,

    // 默认参数过滤方法...
    'DEFAULT_FILTER' => 'htmlspecialchars',

    //模板文件后缀
    'TPL_SUFFIX'     => '.html',

    //默认语言包
    'LANGUAGE'       => 'zh-cn',

];