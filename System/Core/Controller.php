<?php
/**
 * User: GerBawn
 * Date: 2016/4/6 22:59
 */
namespace System\Core;

/**
 * Class Controller
 * @package System\Core
 */
abstract class Controller
{
    /**
     * @var Loader
     */
    protected $load;

    /**
     * @var Application
     */
    protected $app;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->app = Application::getInstance();
        $this->load = $this->app->load;
    }

    /**
     * @param $key
     * @param $value
     */
    public function assign($key, $value)
    {

    }

    /**
     * @param $file
     */
    public function display($file)
    {

    }
}