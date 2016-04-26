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

    public $load;

    private function __construct($baseDir)
    {
        $this->baseDir = $baseDir;
        $this->config = new Config($baseDir . '/configs');
        $this->load = new Loader();
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
        $controller = empty($_REQUEST['action']) ? $this->config['controller']['defaultController'] :
            $_REQUEST['action'];
        $method = empty($_REQUEST['operation']) ? $this->config['controller']['defaultMethod'] :
            $_REQUEST['operation'];
        $class = '\\App\\Controller\\' . ucfirst($controller) . 'Controller';
        $obj = new $class();

        $decorators = [];
        if (isset($this->config['controller']['decorators'])) {
            foreach ($this->config['controller']['decorators'] as $class) {
                $decorators[] = new $class();
            }
        }
        if (isset($this->config['controller'][$controller]['decorators'])) {
            foreach ($this->config['controller'][$controller]['decorators'] as $class) {
                $decorators[] = new $class();
            }
        }

        foreach ($decorators as $decorator) {
            $decorator->beforeAction();
        }
        $obj->$method();
        foreach ($decorators as $decorator) {
            $decorator->afterAction();
        }
    }
}