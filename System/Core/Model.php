<?php
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
            $class = '\System\Driver\Database\PDO';
        }
        $this->conn = Factory::createDb($class, $this->config);
    }

    protected function insert($needle)
    {
        if (is_array($needle)) {
            $cols = implode(',', array_keys($needle));
            $values = '';
            foreach ($needle as $value) {
                $values .= "'{$value}',";
            }
            $values = substr($values, 0, strlen($values) - 1);
            $sql = "INSERT INTO `{$this->table}`($cols) VALUES({$values})";
        } else {
            $sql = $needle;
        }

        return $this->conn->insert($sql);
    }

    protected function update($needle, $where = [], $table = '')
    {
        if (is_string($needle)) {
            $sql = $needle;
        } elseif (is_array($needle)) {
            $set = '';
            foreach ($needle as $key => $value) {
                $set .= "`{$key}` = '" . addslashes($value) . "', ";
            }
            $set = substr($set, 0, strlen($set) - 1);
            $whereStr = '';
            $index = 0;
            $len = sizeof($where);
            foreach ($where as $key => $value) {
                if ($index == $len) {
                    $whereStr .= "`{$key}` = '" . addslashes($value) . "'";
                } else {
                    $whereStr .= "`{$key}` = '" . addslashes($value) . "' AND ";
                }
            }
            if ($table == '') {
                $table = $this->table;
            }
            $sql = "UPDATE {$table} SET {$set} WHERE {$where}";
        }
        return $this->conn->update($sql);
    }

    /**
     * @param $sql
     */
    protected function select($sql)
    {
        $this->conn->select($sql);
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
        return $this->conn->startTransaction();
    }

    /**
     *
     */
    public function commit()
    {
        return $this->conn->commit();
    }

    /**
     *
     */
    public function rollback()
    {
        return $this->conn->rollback();
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