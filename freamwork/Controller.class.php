<?php

namespace freamwork;

use PHPAngular\Angular;
use freamwork\Config;

/**
 * 控制器
 * Class Controller
 * @package freamwork
 */
class Controller extends Angular {

    /**
     * 实例模板引擎
     * Controller constructor.
     */
    public function __construct() {
        $debug     = config('APP_DEBUG');
        $className = get_class($this);
        $viewDir   = str_replace(array('app\Controllers\\', ucfirst('Controller')), '', $className);

        ///模板参数
        $config = [
            'debug'            => $debug, // 是否开启调试, 开启调试会实时生成缓存
            'tpl_path'         => __DIR__ . '/../app/Views/' . $viewDir . '/', // 模板根目录
            'tpl_suffix'       => config('TPL_SUFFIX'), // 模板的后缀
            'tpl_cache_path'   => __DIR__ . '/../runtime/temp/', // 模板缓存目录
            'tpl_cache_suffix' => '.php', // 模板缓存后缀
            'directive_prefix' => 'php-', // 指令前缀
            'directive_max'    => 10000, // 指令的最大解析次数
        ];

        parent::__construct($config);

        //自动注册加载
        if (config('AUTO_LOAD_MODEL')) {
            require_once 'Loader.class.php';
            spl_autoload_register(__NAMESPACE__ . '\Loader::autoload');
        }
    }
}