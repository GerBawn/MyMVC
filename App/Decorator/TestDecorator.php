<?php
/**
 * User: GerBawn
 * Date: 2016/4/8 23:42
 */
namespace App\Decorator;

use System\Libraries\Decorator;

class TestDecorator implements Decorator
{

    public function beforeAction()
    {
        echo 'this is beforeAction';
    }

    public function afterAction()
    {
        echo 'this is afterAction';
    }
}