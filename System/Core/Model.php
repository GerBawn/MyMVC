<?php
/**
 * User: GerBawn
 * Date: 2016/4/6 23:03
 */
namespace System\Core;

use System\Libraries\Cache;
use System\Libraries\Factory;

class Model
{
    /**
     * 保存数据库连接
     * @var
     */
    public $conn;

    /**
     * 配置信息
     * @var
     */
    private $config;

    protected $app;

    /**
     * @var string 保存模型对应的数据表
     */
    protected $table;

    /**
     * Model constructor.
     * @param string $db
     */
    public function __construct($db = 'default')
    {
        $this->app = Application::getInstance();
        $dbConfig = $this->app->config['database'];
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
        $this->conn = Factory::createDb($class, $this->config);
    }

    public function insert($needle)
    {
        $cols = implode(',', array_keys($needle));
        $values = '';
        foreach ($needle as $value) {
            $values .= "'{$value}',";
        }
        $values = substr($values, 0, strlen($values) - 1);
        $sql = "INSERT INTO {$this->table}($cols) VALUES({$values})";
        return $this->conn->insert($sql);
    }

    public function update($sql)
    {
        return $this->conn->update($sql);
    }

    /**
     * @param $sql
     */
    public function query($sql)
    {
        $this->conn->query($sql);
    }

    /**
     * @return mixed
     */
    public function one()
    {
        return $this->conn->one();
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->conn->all();
    }

    /**
     *
     */
    public function startTransaction()
    {
        $this->conn->startTransaction();
    }

    /**
     *
     */
    public function commit()
    {
        $this->conn->commit();
    }

    /**
     *
     */
    public function rollback()
    {
        $this->conn->rollback();
    }

    public function lastInsertId()
    {
        return $this->conn->lastInsertId();
    }

    public function affectedRows()
    {
        return $this->conn->affectedRows();
    }
}