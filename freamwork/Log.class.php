<?php
/**
 * Created by PhpStorm.
 * Author: wgl
 * Time:2019-01-15 9:25
 */

namespace freamwork;


use Katzgrau\KLogger\Logger;

/**
 * 日志记录
 * Class Log
 * @package freamwork
 */
class Log {

    /**
     * 日志对象
     * @var
     */
    private static $logObj;

    /**
     * 实例对象
     */
    private static function setObj($directory = '') {
        if (!self::$logObj) {
            $logger       = new Logger(__DIR__ . '/../runtime/log/' . $directory);
            self::$logObj = $logger;
        }
    }

    /**
     * 详细的debug信息
     * @param $message
     * @param array $context
     */
    public static function debug($message, $context = []) {
        $funArr = explode('::', __METHOD__);
        self::setObj($funArr[1]);
        $logObj = self::$logObj;
        $logObj->debug($message, $context);
    }

    /**
     * 感兴趣的事件。像用户登录，SQL日志
     * @param $message
     * @param array $context
     */
    public static function info($message, $context = []) {
        $funArr = explode('::', __METHOD__);
        self::setObj($funArr[1]);
        $logObj = self::$logObj;
        $logObj->info($message, $context);
    }

    /**
     * 正常但有重大意义的事件。
     * @param $message
     * @param array $context
     */
    public static function notice($message, $context = []) {
        $funArr = explode('::', __METHOD__);
        self::setObj($funArr[1]);
        $logObj = self::$logObj;
        $logObj->notice($message, $context);
    }

    /**
     * 发生异常，使用了已经过时的API。
     * @param $message
     * @param array $context
     */
    public static function warning($message, $context = []) {
        $funArr = explode('::', __METHOD__);
        self::setObj($funArr[1]);
        $logObj = self::$logObj;
        $logObj->warning($message, $context);
    }

    /**
     * 运行时发生了错误，错误需要记录下来并监视，但错误不需要立即处理。
     * @param $message
     * @param array $context
     */
    public static function error($message, $context = []) {
        $funArr = explode('::', __METHOD__);
        self::setObj($funArr[1]);
        $logObj = self::$logObj;
        $logObj->error($message, $context);
    }

    /**
     * 关键错误，像应用中的组件不可用。
     * @param $message
     * @param array $context
     */
    public static function critical($message, $context = []) {
        $funArr = explode('::', __METHOD__);
        self::setObj($funArr[1]);
        $logObj = self::$logObj;
        $logObj->critical($message, $context);
    }

    /**
     * 需要立即采取措施的错误，像整个网站挂掉了，数据库不可用。
     * @param $message
     * @param array $context
     */
    public static function alert($message, $context = []) {
        $funArr = explode('::', __METHOD__);
        self::setObj($funArr[1]);
        $logObj = self::$logObj;
        $logObj->alert($message, $context);
    }
}