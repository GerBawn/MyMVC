<?php
/**
 * User: GerBawn
 * Date: 2016/4/8
 * Time: 15:04
 */
namespace System\Driver\Cache;

use Predis\Client;

class Predis
{
    private $redis;

    public function __construct($config)
    {
        $this->redis = new Client($config);
    }

    public function get($key)
    {
        return $this->redis->get($key);
    }

    public function set($key, $value, $expire)
    {
        $this->redis->setex($key, $expire, $value);
    }
}