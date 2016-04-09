<?php
/**
 * User: GerBawn
 * Date: 2016/4/7
 * Time: 10:26
 */
namespace System\Driver\Database;

interface IDatabase
{
    public function update($sql);

    public function insert($sql);

    public function query($sql);

    public function one();

    public function all();

    public function close();

    public function startTransaction();

    public function commit();

    public function rollback();

    public function lastInsertId();

    public function affectedRow();
}