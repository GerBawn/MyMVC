<?php
/**
 * User: GerBawn
 * Date: 2016/4/6 23:03
 */
namespace System\Core;

use System\Libraries\Cache;

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

    /**
     * 保存缓存连接
     * @var
     */
    protected $cache;

    /**
     * Model constructor.
     * @param string $db
     */
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

        $this->cache = Cache::getInstance([]);
    }

    public function insert($sql)
    {
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
    protected function startTransaction()
    {
        $this->conn->startTransaction();
    }

    /**
     *
     */
    protected function commit()
    {
        $this->conn->commit();
    }

    /**
     *
     */
    protected function rollback()
    {
        $this->conn->rollback();
    }
}