<?php
/**
 * User: GerBawn
 * Date: 2016/4/8
 * Time: 14:51
 */
namespace System\Libraries;

use System\Core\Application;

class Cache
{
    private $config;

    public static $instance;

    private $driver;

    private function __construct($config)
    {
        $app = Application::getInstance();
        $use = $app->config['cache']['use'];
        $driver = $app->config['cache']['driver'];
        $this->config = array_merge($app->config['cache'][$use], $config);
        $class = 'System\\Driver\\Cache\\'.ucfirst($driver);
        $this->driver = new $class($this->config);
    }

    public static function getInstance($config = [])
    {
        if(empty(self::$instance)){
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    public function get($key)
    {
        return $this->driver->get($key);
    }

    public function set($key, $value, $expire)
    {
        $this->driver->set($key, $value, $expire);
    }
}