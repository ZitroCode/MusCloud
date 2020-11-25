<?php

class Database {
    private $host = DB_HOST;
    private $user = DB_USERNAME;
    private $password = DB_PASSWORD;
    private $database = DB_DATABASE;

    private $dbh;
    private $stmt;
    private $error;

    public function __construct() {
        // Config for connection
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->database;
        $options = array(
            PDO::ATTR_PERSISTENT => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        // Create a connection
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->password, $options);
            $this->dbh->exec('set names utf8');
        } catch(PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    // Execute request
    public function query($sql) {
        $this->stmt = $this->dbh->prepare($sql);
    }

    // We bind the query with BindValue
    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
                    break;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }
    // We execute the query
    public function run(){
        return $this->stmt->execute();
    }

    // Get records
    public function resultsGet(){
        $this->run();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function resultGet(){
        $this->run();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }
    // Get record
    public function rowsGet(){
        $this->run();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Get number of rows
    public function rowCount() {
        return $this->stmt->rowCount();
    }
}