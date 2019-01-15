<?php

namespace freamwork;


use Twig_Environment;
use Twig_Extension_Debug;
use Twig_Loader_Filesystem;
use freamwork\Config;

/**
 * 控制器
 * Class Controller
 * @package freamwork
 */
class Controller {

    /**
     * 模板引擎
     * @var Twig_Environment
     */
    protected $tpl;

    /**
     * 实例模板引擎
     * Controller constructor.
     */
    public function __construct() {
        $debug     = Config::get('app', 'APP_DEBUG');
        $className = get_class($this);
        $viewDir   = str_replace(['app\Controllers\\', ucfirst('Controller')], '', $className);
        $loader    = new Twig_Loader_Filesystem(__DIR__ . '/../app/Views/' . $viewDir);
        $twig      = new Twig_Environment($loader, [
            'cache' => __DIR__ . '/../runtime/temp',
            'debug' => $debug,
        ]);

        //dump调试信息
        if ($debug) {
            $twig->addExtension(new Twig_Extension_Debug());
        }

        //设置模板date时区
        $twig->getExtension('Twig_Extension_Core')->setTimezone(TIME_ZONE);

        $this->tpl = $twig;

        //自动注册加载
        if (Config::get('app', 'AUTO_LOAD_MODEL')) {
            require_once 'Loader.class.php';
            spl_autoload_register(__NAMESPACE__ . '\Loader::autoload');
        }
    }
}