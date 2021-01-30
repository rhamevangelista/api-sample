<?php
    class Database {
        private $host;
        private $database_name;
        private $username;
        private $password;

        public $conn;

        public function __construct($host = "localhost", $db_name = "test", $username = "root", $password = "")
        {
            $this->host = $host;
            $this->database_name = $db_name;
            $this->username = $username;
            $this->password = $password;
        }

        public function getConnection()
        {
            $this->conn = null;
            try{
                $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database_name, $this->username, $this->password);
                $this->conn->exec("set names utf8");
            }catch(PDOException $exception){
                echo "Database could not be connected: " . $exception->getMessage();
            }
            return $this->conn;
        }
    }  