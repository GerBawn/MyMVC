<?php
namespace App\Controller;

use App\Model\User;
use System\Core\Application;
use System\Libraries\Log;

class Index
{
    public function index()
    {
        $model = new User();
        $app =  Application::getInstance();
//        $log = new Log();
//        $log->write('DEBUG', 'my name is lingchen', __CLASS__, __FUNCTION__, __LINE__);
//        var_dump($app->config['name']);
        $model->createUser(['name' => 'lingchen', 'age' => 10]);
    }
}