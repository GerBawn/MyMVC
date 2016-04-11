<?php
use System\Libraries\Cache;
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
    return Cache::getInstance();
}

/**
 * @return Input
 */
function input()
{
    return Input::getInstance();
}