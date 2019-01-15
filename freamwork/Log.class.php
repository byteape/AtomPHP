<?php
/**
 * Created by PhpStorm.
 * Author: wgl
 * Time:2019-01-15 9:25
 */

namespace freamwork;

use Monolog\Formatter\LineFormatter;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

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
     * @param int $level
     * @param string $logFile
     * @throws \Exception
     */
    private static function setObj($level = Logger::DEBUG, $logFile = '') {
        // the default date format is "Y-m-d H:i:s"
        $dateFormat = "Y-m-d H:i:s";
        // the default output format is "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n"
        $output = "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n";
        // finally, create a formatter
        $formatter = new LineFormatter($output, $dateFormat);
        $logFile   = $logFile ? $logFile : date('Y-m-d');
        $stream    = new StreamHandler(__DIR__ . '/../runtime/log/' . $logFile . '.log', $level);
        $stream->setFormatter($formatter);

        $log = new Logger('atom');
        $log->pushHandler($stream);
        self::$logObj = $log;
    }

    /**
     * 详细的debug信息
     * @param $message
     * @param array $context
     * @param string $level
     * @param string $logFile
     * @throws \Exception
     */
    public static function debug($message, $context = [], $level = '', $logFile = '') {
        self::setObj($level, $logFile);
        $logObj = self::$logObj;
        $logObj->debug($message, $context);
    }

    /**
     * 感兴趣的事件。像用户登录，SQL日志
     * @param $message
     * @param array $context
     * @param string $level
     * @param string $logFile
     * @throws \Exception
     */
    public static function info($message, $context = [], $level = '', $logFile = '') {
        self::setObj($level, $logFile);
        $logObj = self::$logObj;
        $logObj->info($message, $context);
    }

    /**
     * 正常但有重大意义的事件。
     * @param $message
     * @param array $context
     * @param string $level
     * @param string $logFile
     * @throws \Exception
     */
    public static function notice($message, $context = [], $level = '', $logFile = '') {
        self::setObj($level, $logFile);
        $logObj = self::$logObj;
        $logObj->notice($message, $context);
    }

    /**
     * 发生异常，使用了已经过时的API。
     * @param $message
     * @param array $context
     * @param string $level
     * @param string $logFile
     * @throws \Exception
     */
    public static function warning($message, $context = [], $level = '', $logFile = '') {
        self::setObj($level, $logFile);
        $logObj = self::$logObj;
        $logObj->warning($message, $context);
    }

    /**
     * 运行时发生了错误，错误需要记录下来并监视，但错误不需要立即处理。
     * @param $message
     * @param array $context
     * @param string $level
     * @param string $logFile
     * @throws \Exception
     */
    public static function error($message, $context = [], $level = '', $logFile = '') {
        self::setObj($level, $logFile);
        $logObj = self::$logObj;
        $logObj->error($message, $context);
    }

    /**
     * 关键错误，像应用中的组件不可用。
     * @param $message
     * @param array $context
     * @param string $level
     * @param string $logFile
     * @throws \Exception
     */
    public static function critical($message, $context = [], $level = '', $logFile = '') {
        self::setObj($level, $logFile);
        $logObj = self::$logObj;
        $logObj->critical($message, $context);
    }

    /**
     * 需要立即采取措施的错误，像整个网站挂掉了，数据库不可用。
     * @param $message
     * @param array $context
     * @param string $level
     * @param string $logFile
     * @throws \Exception
     */
    public static function alert($message, $context = [], $level = '', $logFile = '') {
        self::setObj($level, $logFile);
        $logObj = self::$logObj;
        $logObj->alert($message, $context);
    }
}