<?php
use System\Libraries\Cache;
use System\Libraries\Factory;
use System\Libraries\Input;

/**
 * 用来获取各种实例
 * User: GerBawn
 * Date: 2016/4/9
 * Time: 13:41
 */

/**
 * @return Cache
 */
function cache()
{
    return Factory::createCache();
}

/**
 * @return Input
 */
function input()
{
    return Factory::createInput();
}