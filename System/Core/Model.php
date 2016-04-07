<?php
/**
 * User: GerBawn
 * Date: 2016/4/6 23:03
 */
namespace System\Core;

class Model
{
    public $conn;

    private $config;

    public function __construct($db = 'default')
    {
        $dbConfig = Application::getInstance()->config['database'];
        if (isset($dbConfig[$db]) && !empty($dbConfig[$db])) {
            $this->config = $dbConfig[$db];
        } else {
            $this->config = $dbConfig['default'];
        }
        $driver = $dbConfig['driver'];
        $class = '';
        if ($driver == 'mysqli') {
            $class = 'System\Driver\Database\MySQL';
        } elseif ($driver == 'pdo') {
            $class = '\System\Driver\Database\PdoMySQL';
        }
        $this->conn = new $class($this->config);
    }

    public function query($sql)
    {
        $this->conn->query($sql);
    }

    public function one()
    {
        return $this->conn->one();
    }

    public function all()
    {
        return $this->conn->all();
    }

    protected function startTransaction()
    {
        $this->conn->startTransaction();
    }

    protected function commit()
    {
        $this->conn->commit();
    }

    protected function rollback()
    {
        $this->conn->rollback();
    }
}