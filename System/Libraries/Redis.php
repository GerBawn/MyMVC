<?php
/**
 * User: GerBawn
 * Date: 2016/4/12
 * Time: 16:01
 */
namespace System\Libraries;

use Predis\Client;
use System\Core\Application;

class Redis
{
    private static $instance;

    private $redis;

    private $config;

    private function __construct($config = [])
    {
        $this->config = array_merge(Application::getInstance()->config['redis'], $config);
        $this->redis = new Client($this->config);
    }

    public static function getInstance($config = [])
    {
        if (empty(self::$instance)) {
            self::$instance = new self($config);
        }

        return self::$instance;
    }

    public function __call($name, $params)
    {
        if ($this->redis) {
            return call_user_func_array([$this->redis, $name], $params);
        }
    }
}