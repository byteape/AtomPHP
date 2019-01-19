<?php

namespace freamwork;

use freamwork\Helper;
use freamwork\Config;
use freamwork\Log;
use freamwork\Cache;
use freamwork\Model;
use freamwork\Route;
use freamwork\Request;
use freamwork\Lanuage;
use freamwork\ExceptionHandler;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

// 当前文件名
if (!defined('_PHP_FILE_')) {
    define('_PHP_FILE_', rtrim($_SERVER['SCRIPT_NAME'], '/'));
}
if (!defined('__ROOT__')) {
    $_root = rtrim(dirname(_PHP_FILE_), '/');
    define('__ROOT__', (($_root == '/' || $_root == '\\') ? '' : $_root));
}

$dotenv = \Dotenv\Dotenv::create(__DIR__ . "/../");
$dotenv->load();

define('TIME_ZONE', getenv('TIME_ZONE'));
ini_set('date.timezone', TIME_ZONE);

// 定义当前请求的系统常量
define('NOW_TIME', $_SERVER['REQUEST_TIME']);
define('REQUEST_METHOD', $_SERVER['REQUEST_METHOD']);
define('IS_GET', REQUEST_METHOD == 'GET' ? true : false);
define('IS_POST', REQUEST_METHOD == 'POST' ? true : false);
define('IS_PUT', REQUEST_METHOD == 'PUT' ? true : false);
define('IS_DELETE', REQUEST_METHOD == 'DELETE' ? true : false);
define('__PUBLIC__', __ROOT__ . '/public');

require_once __DIR__ . '/../resources/helper/function.php';
require_once __DIR__ . '/ExceptionHandler.class.php';
require_once __DIR__ . '/Helper.class.php';
require_once __DIR__ . '/Config.class.php';
require_once __DIR__ . '/Log.class.php';
require_once __DIR__ . '/Cache.class.php';
require_once __DIR__ . '/Model.class.php';
require_once __DIR__ . '/Route.class.php';
require_once __DIR__ . '/Controller.class.php';
require_once __DIR__ . '/Request.class.php';
require_once __DIR__ . '/Lanuage.class.php';

//自动注册加载
if (config('AUTO_LOAD_MODEL')) {
    spl_autoload_register(__NAMESPACE__ . '\Loader::autoload');
}

//调试判断
if (config('APP_DEBUG')) {
    $whoops  = new  Run;
    $handler = new PrettyPageHandler;
    $handler->setPageTitle("出现错误了");
    $whoops->pushHandler($handler);
    $whoops->register();
} else {
    ini_set("error_reporting", "E_ALL & ~E_NOTICE");
}

Route::run();









