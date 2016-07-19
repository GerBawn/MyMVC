<?php
namespace System\Driver\Database;

class PDO implements IDatabase
{

    private $type;

    private $host;

    private $dbname;

    private $password;

    private $insertId;

    private $affectedRows;

    private $dsn;

    private $conn;

    private $user;

    private $result;

    public function __construct($config)
    {
        $this->host = $config['host'];
        $this->type = $config['type'];
        $this->dbname = $config['dbname'];
        $this->password = $config['password'];
        $this->user = $config['user'];
        $this->dsn = $this->type . ':host=' . $this->host . ';dbname=' . $this->dbname;
        try {
            $this->conn = new \PDO($this->dsn, $this->user, $this->password);
        } catch (\PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }

    public function insert($sql)
    {
        $this->query($sql);

        $this->insertId = $this->conn->lastInsertId();

        return $this->affectedRows;
    }

    public function update($sql)
    {
        $this->query($sql);

        return $this->affectedRows;
    }

    public function select($sql)
    {
        $this->result = $this->conn->query($sql);
        if ($this->result === false) {
            die(json_encode($this->conn->errorInfo()));
        }

        $this->affectedRows = $this->result->columnCount();
    }

    public function one($style = \PDO::FETCH_ASSOC)
    {
        return $this->result->fetch($style);
    }

    public function all($style = \PDO::FETCH_ASSOC)
    {
        return $this->result->fetchAll($style);
    }

    public function close()
    {

    }

    public function startTransaction()
    {
        if ($this->conn->inTransaction()) {
            return false;
        }
        try {
            $this->conn->beginTransaction();
        } catch (\PDOException $e) {
            die('begin transaction failed: ' . $e->getMessage());
        }

        return true;
    }

    public function commit()
    {
        if (!$this->conn->inTransaction()) {
            return false;
        }
        try {
            $this->conn->commit();
        } catch (\PDOException $e) {
            die('commit transaction failed: ' . $e->getMessage());
        }

        return true;
    }

    public function rollback()
    {
        if (!$this->conn->inTransaction()) {
            return false;
        }
        try {
            $this->conn->rollBack();
        } catch (\PDOException $e) {
            die('commit transaction failed: ' . $e->getMessage());
        }

        return true;
    }

    public function lastInsertId()
    {
        return $this->insertId;
    }

    public function affectedRows()
    {
        return $this->affectedRows;
    }

    public function delete($sql)
    {
        $this->query($sql);

        return $this->affectedRows;
    }

    public function __destruct()
    {
        
    }

    private function query($sql)
    {
        $this->affectedRows = $this->conn->exec($sql);
        if ($this->affectedRows === false) {
            die(json_encode($this->conn->errorInfo()));
        }
    }
}