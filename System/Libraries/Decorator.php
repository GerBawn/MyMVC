<?php
/**
 * User: GerBawn
 * Date: 2016/4/8 23:37
 */
namespace System\Libraries;

interface Decorator
{
    public function beforeAction();

    public function afterAction();
}
