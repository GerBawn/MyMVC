<?php
/**
 * User: GerBawn
 * Date: 2016/4/7
 * Time: 15:39
 */
namespace System\Libraries;

use System\Core\Application;

class Log
{
    private static $storage;

    private static $logLevel = [
        'ALERT' => 1,
        'CRITICAL' => 2,
        'ERROR' => 3,
        'WARNING' => 4,
        'NOTICE' => 5,
        'INFO' => 6,
        'DEBUG' => 7,
        'ALL' => 8,
    ];

    private static $threshold;

    public static function write($level, $message)
    {
        $app = Application::getInstance();
        if (empty(self::$threshold)) {
            self::$threshold = $app->config['logLevel'] ? self::$logLevel[$app->config['logLevel']] : 1;
        }
        var_dump(self::$threshold);
        if (self::$logLevel[$level] > self::$threshold) {
            return;
        }
        if (empty(self::$storage)) {
            $app = Application::getInstance();
            $type = $app->config['logType'];
            $config['logPath'] = $app->config['logPath'] ? $app->config['logPath'] : BASEDIR . '/logs';
            $config['logFile'] = $app->config['logFile'] ? $app->config['logFile'] : 'common';
            $class = 'System\\Driver\\Log\\' . ucfirst($type);
            self::$storage = new $class($config);
        }

        self::$storage->write($level, $message);

    }
}