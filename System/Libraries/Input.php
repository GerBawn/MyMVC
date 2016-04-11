<?php
/**
 * User: GerBawn
 * Date: 2016/4/11
 * Time: 10:50
 */
namespace System\Libraries;

class Input
{
    private static $instance;

    private $data;

    private function __construct()
    {
        foreach ($_REQUEST as $key => $value) {
            $this->data[$key] = addslashes($value);
        }

    }

    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function get($key = '')
    {
        if ($key == '') {
            return $this->data;
        }
        if (isset($this->data[$key])) {
            return $this->data[$key];
        }

        return '';
    }

}