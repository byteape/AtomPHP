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

$urlSelf = $_SERVER['PHP_SELF'];
$rootStr = str_replace('public/index.php', '', $urlSelf);
define('__ROOT__', $rootStr);

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

Route::run();









