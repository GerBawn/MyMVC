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
    }

    public function update($sql)
    {
        $this->conn->query($sql);

        if ($this->conn->errno != 0) {
            Log::write('ERROR', $this->conn->errno . ': ' . $this->conn->error . ": $sql");

            return false;
        }

        return $this->conn->affected_rows;
    }

    public function insert($sql)
    {
        $this->conn->query($sql);
        if ($this->conn->errno != 0) {
            Log::write('ERROR', $this->conn->errno . ': ' . $this->conn->error . ": $sql");

            return false;
        }

        return $this->conn->insert_id;
    }

    public function query($sql)
    {
        $this->result = $this->conn->query($sql);
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

    public function close()
    {
        $this->conn->close();
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
        return $this->conn->insert_id;
    }

    public function affectedRow()
    {
        return $this->conn->affected_rows;
    }


    public function __destruct()
    {
        $this->close();
    }
}