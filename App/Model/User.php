<?php
/**
 * User: GerBawn
 * Date: 2016/4/7
 * Time: 11:17
 */
namespace App\Model;

use System\Core\Model;

class User extends Model
{
    public function __construct()
    {
        parent::__construct('test');
    }

    public function getOneUser()
    {
        $this->query("SELECT * FROM m1");

        return $this->one();
    }

    public function getAllUser()
    {
        $this->query("SELECT * FROM m1");

        return $this->all();
    }

    public function createUser($user)
    {
        $cols = implode(',', array_keys($user));
        $values = '';
        foreach ($user as $value) {
            $values .= "'{$value}',";
        }
        $values = substr($values, 0, strlen($values) - 1);
        $sql = "INSERT INTO m1({$cols}) VALUES({$values})";
        if ($this->insert($sql)) {
            return true;
        }
    }

    public function updateUser($user)
    {
        $sql = "UPDATE m1 SET `name` = 'ger' WHERE `name` = 'lingchen'";
        var_dump($this->update($sql));
    }
}