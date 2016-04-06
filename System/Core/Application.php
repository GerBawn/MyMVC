<?php
/**
 * User: GerBawn
 * Date: 2016/4/6 22:21
 */
namespace System\Core;

class Application
{
    private static $instance;

    public $config;

    private function __construct($baseDir)
    {
        $this->baseDir = $baseDir;
        $this->config = new Config($baseDir . '/configs');
    }

    public static function getInstance($baseDir = '')
    {
        if (empty(self::$instance)) {
            self::$instance = new self($baseDir);
        }

        return self::$instance;
    }

    public function run()
    {
        $controller = ucfirst($_REQUEST['c']);
        $method = $_REQUEST['m'];
        $class = '\\App\\Controller\\' . $controller;
        $obj = new $class();
        $obj->$method();
    }
}