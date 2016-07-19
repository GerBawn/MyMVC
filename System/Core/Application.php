<?php
/**
 * User: GerBawn
 * Date: 2016/4/6 22:21
 */
namespace System\Core;

use System\Libraries\Log;

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

    public function run($argc = 0, $argv = [])
    {
        if (php_sapi_name() == 'cli') {
            $controller = $argv[1];
            $method = $argv[2];
        } else {
            $controller = empty($_REQUEST['action']) ? $this->config['controller']['defaultController'] :
                $_REQUEST['action'];
            $method = empty($_REQUEST['operation']) ? $this->config['controller']['defaultMethod'] :
                $_REQUEST['operation'];
        }

        $class = '\\App\\Controller\\' . ucfirst($controller) . 'Controller';
        if (!class_exists($class)) {
            Log::write('ERROR', "class[{$class}] is not exists");
            exit("class[{$class}] is not exists");
        }
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
        if (!method_exists($obj, $method)) {
            Log::write('ERROR', "method[{$method}] is not exists in {$class}");
            exit("method[{$method}] is not exists in {$class}");
        }
        $res = $obj->$method();
        foreach ($decorators as $decorator) {
            $decorator->afterAction($res);
        }

        echo $res;
    }
}