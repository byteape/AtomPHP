<?php

namespace freamwork;

use PHPAngular\Angular;
use freamwork\Config;

/**
 * 控制器
 * Class Controller
 * @package freamwork
 */
class Controller {

    protected $tpl;

    /**
     * 实例模板引擎
     * Controller constructor.
     */
    public function __construct() {
        $debug = config('APP_DEBUG');
        ///模板参数
        $config = [
            'debug'            => $debug, // 是否开启调试, 开启调试会实时生成缓存
            'tpl_path'         => __DIR__ . '/../app/Views/', // 模板根目录
            'tpl_suffix'       => config('TPL_SUFFIX'), // 模板的后缀
            'tpl_cache_path'   => __DIR__ . '/../runtime/temp/', // 模板缓存目录
            'tpl_cache_suffix' => '.php', // 模板缓存后缀
            'directive_prefix' => 'php-', // 指令前缀
            'directive_max'    => 10000, // 指令的最大解析次数
        ];

        $view      = new Angular($config);
        $this->tpl = $view;
    }

    /**
     * 模板变量赋值
     * @access protected
     * @param mixed $name 要显示的模板变量
     * @param mixed $value 变量的值
     * @return Action
     */
    protected function assign($name, $value = '') {
        $this->tpl->assign($name, $value);
        return $this;
    }

    /**
     * 编译模板输出结果
     * @param string $tpl_file
     * @param array $tpl_var
     */
    protected function display($tpl_file = '', $tpl_var = []) {
        $tpl_file  = $tpl_file ? $tpl_file : ACTION_NAME;
        $className = get_class($this);
        $viewDir   = str_replace(array('app\Controllers\\', ucfirst('Controller')), '', $className);
        echo $this->tpl->display($viewDir . '/' . $tpl_file, $tpl_var);
    }

    /**
     * 错误跳转
     * @param string $message
     * @param string $jumpUrl
     * @param bool $ajax
     */
    protected function error($message = '', $jumpUrl = '', $ajax = false) {
        $this->dispatchJump($message, 0, $jumpUrl, $ajax);
    }

    /**
     * 成功跳转
     * @param string $message
     * @param string $jumpUrl
     * @param bool $ajax
     */
    protected function success($message = '', $jumpUrl = '', $ajax = false) {
        $this->dispatchJump($message, 1, $jumpUrl, $ajax);
    }


    /**
     * Ajax方式返回数据到客户端
     * @param $data
     * @param string $type
     * @param int $json_option
     */
    protected function ajaxReturn($data, $type = '', $json_option = 0) {
        if (empty($type)) $type = config('DEFAULT_AJAX_RETURN');
        switch (strtoupper($type)) {
            case 'XML'  :
                // 返回xml格式数据
                header('Content-Type:text/xml; charset=utf-8');
                exit(xml_encode($data));
            case 'JSONP':
                // 返回JSON数据格式到客户端 包含状态信息
                header('Content-Type:application/json; charset=utf-8');
                $handler = isset($_GET[config('VAR_JSONP_HANDLER')]) ? $_GET[config('VAR_JSONP_HANDLER')] : config('DEFAULT_JSONP_HANDLER');
                exit($handler . '(' . json_encode($data, $json_option) . ');');
            case 'EVAL' :
                // 返回可执行的js脚本
                header('Content-Type:text/html; charset=utf-8');
                exit($data);
            default     :
                // 返回JSON数据格式到客户端 包含状态信息
                header('Content-Type:application/json; charset=utf-8');
                exit(json_encode($data, $json_option));
        }
    }

    /**
     * 跳转输出
     * @param $message
     * @param int $status
     * @param string $jumpUrl
     * @param bool $ajax
     */
    private function dispatchJump($message, $status = 1, $jumpUrl = '', $ajax = false) {
        if (true === $ajax || IS_AJAX) {// AJAX提交
            $data           = is_array($ajax) ? $ajax : array();
            $data['info']   = $message;
            $data['status'] = $status;
            $data['url']    = $jumpUrl;
            $this->ajaxReturn($data);
        }
        if (is_int($ajax)) $this->assign('waitSecond', $ajax);
        if (!empty($jumpUrl)) $this->assign('jumpUrl', $jumpUrl);
        // 提示标题
        $this->assign('msgTitle', $status ? 'SUCCESS' : 'ERROR');
        //如果设置了关闭窗口，则提示完毕后自动关闭窗口
        if (Request::get('closeWin')) $this->assign('jumpUrl', 'javascript:window.close();');
        $this->assign('status', $status);   // 状态
        if ($status) { //发送成功信息
            $this->assign('message', $message);// 提示信息
            // 成功操作后默认停留1秒
            if (!isset($this->waitSecond)) $this->assign('waitSecond', '1');
            // 默认操作成功自动返回操作前页面
            if (!isset($this->jumpUrl)) $this->assign("jumpUrl", $_SERVER["HTTP_REFERER"]);
            $this->display(__DIR__ . '/../resources/template/jump.html');
        } else {
            $this->assign('error', $message);// 提示信息
            //发生错误时候默认停留3秒
            if (!isset($this->waitSecond)) $this->assign('waitSecond', '3');
            // 默认发生错误的话自动返回上页
            if (!isset($this->jumpUrl)) $this->assign('jumpUrl', "javascript:history.back(-1);");
            $this->display(__DIR__ . '/../resources/template/jump.html');
            // 中止执行  避免出错后继续执行
            exit;
        }
    }
}