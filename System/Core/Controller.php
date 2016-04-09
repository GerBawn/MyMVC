<?php
/**
 * User: GerBawn
 * Date: 2016/4/6 22:59
 */
namespace System\Core;

use System\Libraries\Cache;

abstract class Controller
{
    protected $cache;
    protected $load;

    public function __construct()
    {
        $this->cache = Cache::getInstance([]);
        $this->load = Application::getInstance()->load;
    }

    public function assign($key, $value)
    {

    }

    public function display($file)
    {

    }
}