<?php
namespace System\Driver\Database;

interface IDatabase
{
    public function update($sql);

    public function insert($sql);

    public function select($sql);

    public function delete($sql);

    public function one();

    public function all();

    public function close();

    public function startTransaction();

    public function commit();

    public function rollback();

    public function lastInsertId();

    public function affectedRows();

}