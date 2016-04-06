<?php
/**
 * Created by PhpStorm.
 * User: lingchen
 * Date: 2016/3/22
 * Time: 19:58
 */

namespace System\Core;

class Loader
{
    public static function autoload($class)
    {
        require BASEDIR . '/' . str_replace('\\', '/', $class) . '.php';
    }
}