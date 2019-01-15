<?php
// +----------------------------------------------------------------------
// | AtomPHP [ Minimum Atomic Framework ]
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: wgl <1132083961@qq.com>
// +----------------------------------------------------------------------

// 应用入口文件

// 检测PHP环境
if (version_compare(PHP_VERSION, '5.6.0', '<')) die('require PHP > 5.6.0 !');

//自动加载
require __DIR__ . "/../vendor/autoload.php";

//框架文件
require __DIR__ . "/../freamwork/Atom.php";
