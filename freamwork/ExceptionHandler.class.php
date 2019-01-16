<?php
/**
 * Created by PhpStorm.
 * Author: wgl
 * Time:2019-01-16 10:42
 */

namespace freamwork;

use freamwork\Log;

/**
 * 异常处理类
 * Class ExceptionHandler
 * @package freamwork
 */
class ExceptionHandler {

    /**
     * 启动
     */
    public static function run() {
        //程序执行时异常终止错误捕获处理函数注册
        register_shutdown_function('\freamwork\ExceptionHandler::fatalError');
        //错误捕获自定义处理函数注册
        set_error_handler('\freamwork\ExceptionHandler::appError');
        //异常捕获自定义处理函数注册
        set_exception_handler('\freamwork\ExceptionHandler::appException');
    }

    /**
     * 异常捕获
     * @param $exception
     * @throws \Exception
     */
    public static function appException($exception) {
        $string = $exception->getTraceAsString();
        $info   = '<h2>:(' . $exception->getMessage() . '</h2>';
        $info   .= str_replace("\n", '<br/>', $string);

        // 发送404信息
        header('HTTP/1.1 404 Not Found');
        header('Status:404 Not Found');
        self::log($exception);

        self::dump($info);
    }

    /**
     * 错误捕获
     * @param $errno
     * @param $errstr
     * @param $errfile
     * @param $errline
     * @throws \Exception
     */
    public static function appError($errno, $errstr, $errfile, $errline) {
        switch ($errno) {
            case E_ERROR:
            case E_PARSE:
            case E_CORE_ERROR:
            case E_COMPILE_ERROR:
            case E_USER_ERROR:
                ob_end_clean();
                $errorStr = "$errstr " . $errfile . " 第 $errline 行.";
                Log::error("[$errno] " . $errorStr);
                self::dump($errorStr);
                break;
            default:
                $errorStr = "[$errno] $errstr " . $errfile . " 第 $errline 行.";
                Log::error("[$errno] " . $errorStr);
                self::dump($errorStr);
                break;
        }
    }

    /**
     * 异常终止
     * @throws \Exception
     */
    public static function fatalError() {
        if ($e = error_get_last()) {
            switch ($e['type']) {
                case E_ERROR:
                case E_PARSE:
                case E_CORE_ERROR:
                case E_COMPILE_ERROR:
                case E_USER_ERROR:
                    ob_end_clean();
                    $errorStr = $e['message'] . ' ' . $e['file]'] . " 第 " . $e['line'] . " 行.";
                    Log::error($errorStr);
                    self::dump($errorStr);
                    break;
            }
        }
    }

    /**
     * 打印内容
     * @param $info
     */
    public static function dump($info) {
        ob_end_clean();
        $errorMessage = $info;
        //调试信息
        $debug = Config::get('app', 'APP_DEBUG');
        if ($debug) {
            include_once __DIR__ . '/tpl/error.html';
        } else {
            ini_set("error_reporting", "E_ALL & ~E_NOTICE");
        }
    }

    /**
     * 记录日志
     * @param $exception
     * @throws \Exception
     */
    public static function log($exception) {
        $logInfo = 'Message:' . $exception->getMessage() . " Info:" . $exception->getTraceAsString();
        Log::error($logInfo);
    }

}

ExceptionHandler::run();
