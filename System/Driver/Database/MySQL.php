<?php
/**
 * User: GerBawn
 * Date: 2016/4/7
 * Time: 10:28
 */
namespace System\Driver\Database;

use System\Libraries\Log;

class MySQL implements IDatabase
{

    private $host;

    private $user;

    private $password;

    private $dbname;

    private $port;

    private $conn;

    private $result;

    private $insertId;

    private $affectedRows;

    public function __construct($config)
    {
        $this->host = $config['host'];
        $this->user = $config['user'];
        $this->password = $config['password'];
        $this->dbname = $config['dbname'];
        $this->port = $config['port'];

        $this->conn = new \mysqli(
            $this->host, $this->user, $this->password, $this->dbname,
            $this->port
        );
        if ($this->conn->connect_errno) {
            Log::write('ALERT', 'Can not connect database: ' . $this->conn->connect_error);
            die($this->conn->connect_error);
        }
    }

    public function update($sql)
    {
        $this->conn->query($sql);
        $this->affectedRows = $this->conn->affected_rows;

        return $this->affectedRows;
    }

    public function insert($sql)
    {
        $this->conn->query($sql);
        $this->insertId = $this->conn->insert_id;

        return $this->insertId;
    }

    public function query($sql)
    {
        $this->result = $this->conn->query($sql);
        if ($this->conn->errno != 0) {
            Log::write('ALERT', $this->conn->errno . ': ' . $this->conn->error . ": $sql");
            die($this->conn->error . ': ' . $sql);
        }
        $this->insertId = $this->conn->insert_id;
        $this->affectedRows = $this->conn->affected_rows;
    }

    public function one($returnType = MYSQLI_ASSOC)
    {
        $row = $this->result->fetch_array($returnType);

        return $row;
    }

    public function all($returnType = MYSQLI_ASSOC)
    {
        $row = $this->result->fetch_all($returnType);

        return $row;

    }

    public function startTransaction()
    {
        $this->conn->autocommit(false);
        $this->conn->begin_transaction();
    }

    public function commit()
    {
        $this->conn->commit();
        $this->conn->autocommit(true);
    }

    public function rollback()
    {
        $this->conn->rollback();
        $this->conn->autocommit(true);
    }

    public function lastInsertId()
    {
        return $this->insertId;
    }

    public function affectedRows()
    {
        return $this->affectedRows;
    }

    public function __destruct()
    {
        $this->close();
    }

    public function close()
    {
        $this->conn->close();
    }
}