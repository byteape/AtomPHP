<?php

namespace app\Controllers;

use app\Models\User;
use freamwork\Cache;
use freamwork\Controller;
use freamwork\Lanuage;
use freamwork\Log;
use freamwork\Model;
use freamwork\Request;
use freamwork\Url;

/**
 * 测试控制器
 * Class IndexController
 * @package app\Controllers
 */
class IndexController extends Controller {

    public function index() {

        echo '<h1>:)ATOMPHP</h1><br/><a href="' . Url::go('index/tpl', array('test' => 1)) . '">跳转模板</a>';

        //获取参数
        //var_dump(Request::all());
        //var_dump(Request::get('c'));

        //获取链接
        //var_dump(Url::go('index/test', array('test' => 1)));

        //输出日志
        //Log::notice('这是一个日志信息');
        //……

        //获取数据库数据
        //$user = new User();
        //$user = $user->getname(2);
        //var_dump($user);
        //var_dump(Model::db()->select('user','*'));

        //输出自定义函数信息
        //var_dump(testFunction());

        //定义与获取数据缓存
        //Cache::save('key','data',60);
        //var_dump(Cache::fetch('key'));

        //获取语言包文件
        //var_dump(Lanuage::get('Home'));
    }

    public function tpl() {
        $navigation = [
            [
                'href'    => '#',
                'caption' => 'AtomPHP1',
            ],
            [
                'href'    => '#',
                'caption' => 'AtomPHP2',
            ],
            [
                'href'    => '#',
                'caption' => 'AtomPHP3',
            ],
        ];

        $title = 'AtomPHP';

        $tplData = ['navigation' => $navigation, 'title' => $title];
        $this->tpl->display('index.html', $tplData);
    }
}