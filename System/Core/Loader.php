<?php
/**
 * Created by PhpStorm.
 * User: lingchen
 * Date: 2016/3/22
 * Time: 19:58
 */

namespace System\Core;

class Loader
{
    /**
     * 存储已经载入的文件
     * @var array
     */
    private static $loaded = [];

    public static function autoload($class)
    {
        require BASEDIR . '/' . str_replace('\\', '/', $class) . '.php';
    }

    public function helper($name)
    {
        if (isset($loaded['helper'][$name])) {
            return;
        }
        $fileName = SYSTEM_DIR . '/Helper/' . ucfirst($name) . '.php';
        if (file_exists($fileName)) {
            require $fileName;
        }
        $fileName = APP_DIR . '/Helper/' . ucfirst($name) . '.php';
        if (file_exists($fileName)) {
            require $fileName;
        }
        self::$loaded['helper'][$name] = $name;
    }

    public function library($name)
    {
        if (isset($loaded['libraries'][$name])) {
            return;
        }
        $fileName = APP_DIR . '/Libraries/' . ucfirst($name) . '.php';
        if (file_exists($fileName)) {
            require $fileName;
        }
        $fileName = SYSTEM_DIR . '/Libraries/' . ucfirst($name) . '.php';
        if (file_exists($fileName)) {
            require $fileName;
        }
        self::$loaded['Libraries'][$name] = $name;
    }
}