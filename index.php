<?php
/**
 * User: GerBawn
 * Date: 2016/4/5 23:46
 */
use System\Core\Application;
use System\Core\Config;

define('BASEDIR', __DIR__);

include BASEDIR . '/System/Core/Loader.php';

spl_autoload_register('\System\Core\Loader::autoload');

$app = Application::getInstance(BASEDIR);
$app->run();