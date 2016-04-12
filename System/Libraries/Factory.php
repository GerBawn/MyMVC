<?php
/**
 * User: GerBawn
 * Date: 2016/4/12
 * Time: 9:43
 */
namespace System\Libraries;

/**
 * 工厂类，用来创建各种实例，方便以后扩展
 * Class Factory
 * @package System\Libraries
 */
class Factory
{
    /**
     * @var
     */
    private static $class;

    /**
     * 创建数据库
     * @param string $class
     * @param array $config
     * @return mixed
     */
    public static function createDb($class, $config)
    {
        $configStr = implode('', $config);
        $keys = substr(md5($configStr), 0, 6);
        if (!isset(self::$class[$keys])) {
            self::$class[$keys] = new $class($config);
        }

        return self::$class[$keys];
    }

    /**
     * @return Cache
     */
    public static function createCache()
    {
        return Cache::getInstance();
    }

    /**
     * @return Input
     */
    public static function createInput()
    {
        return Input::getInstance();
    }
}