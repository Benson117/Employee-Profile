<?php
// config/database.php

class Database {
    private $server = "tcp:tbserver2025.database.windows.net,1433";
    private $database = "TBportfolio_db";
    private $username = "CloudSA219c14b7";
    private $password = "Tanaka117";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            // Exact format from Azure sample code
            $this->conn = new PDO(
                "sqlsrv:server = " . $this->server . "; Database = " . $this->database,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch(PDOException $e) {
            echo "Error connecting to SQL Server: ";
            print_r($e->getMessage());
            return null;
        }
        return $this->conn;
    }
    
    // Alternative method using sqlsrv_connect
    public function getSQLServerConnection() {
        $connectionInfo = array(
            "UID" => $this->username,
            "pwd" => $this->password,
            "Database" => $this->database,
            "LoginTimeout" => 30,
            "Encrypt" => 1,
            "TrustServerCertificate" => 0
        );
        
        $conn = sqlsrv_connect($this->server, $connectionInfo);
        
        if ($conn === false) {
            echo "Error connecting to SQL Server: ";
            die(print_r(sqlsrv_errors(), true));
        }
        
        return $conn;
    }
}

