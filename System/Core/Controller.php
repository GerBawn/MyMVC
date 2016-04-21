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
     * 用来存放需要在视图中使用的参数
     * @var array
     */
    protected $data = [];

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
        $this->data[$key] = $value;
    }

    /**
     * @param $file
     */
    public function display($file = '')
    {
        if (empty($file)) {
            $file = BASEDIR . '/App/View/' . __CLASS__ . '/' . 'index.php';
        }
        $path = BASEDIR . '/App/View/' . $file;
        extract($this->data);
        include $path;
    }
}