<?php

namespace Systeme;

use PDO;

class Database
{
    private $dbName;
    private $dbUser;
    private $dbPass;
    private $dbHost;
    protected $pdo;

    public function __construct ($dbName, $dbHost = 'localhost', $dbUser = 'root', $dbPass = '')
    {
        $this->dbName = $dbName;
        $this->dbHost = $dbHost;
        $this->dbUser = $dbUser;
        $this->dbPass = $dbPass;
    }

    private function getPDO ()
    {
        if ($this->pdo === null) {
            $pdo = new PDO('mysql:dbname=' .$this->dbName. ';host=' .$this->dbHost, $this->dbUser, $this->dbPass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
        }
        return $this->pdo;
    }

    public function query ($statement, $className = null, $all = true)
    {
        $req = $this->getPDO()->query($statement);

        if ($className === null) {
            $req->setFetchMode(PDO::FETCH_OBJ);
        } else {
            $req->setFetchMode(PDO::FETCH_CLASS, $className);
        }

        if ($all) {
            $datas = $req->fetchAll();
        } else {
            $datas = $req->fetch();
        }

        return $datas;
    }

    public function prepare ($statement, $attributes, $className = null, $all = true)
    {
        $req = $this->getPDO()->prepare($statement);
        $req->execute($attributes);

        if ($className === null) {
            $req->setFetchMode(PDO::FETCH_OBJ);
        } else {
            $req->setFetchMode(PDO::FETCH_CLASS, $className);
        }

        if ($all) {
            $datas = $req->fetchAll();
        } else {
            $datas = $req->fetch();
        }

        return $datas;
    }

    public function lastId ()
    {
        return $this->getPDO()->lastInsertId();
    }
}