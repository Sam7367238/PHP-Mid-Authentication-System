<?php

session_start();

class Database {
    protected static $connection;

    public function __construct($config, $username = "root", $password = "") {
        if (!self::$connection) {
            $dsn = "mysql:" . http_build_query($config, "", ";");

            self::$connection = new PDO($dsn, $username, $password, [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
    
            $this -> query("
            CREATE TABLE IF NOT EXISTS Users (
                ID INT AUTO_INCREMENT PRIMARY KEY, 
                Full_Name VARCHAR(100), 
                Email VARCHAR(200) NOT NULL, 
                Password VARCHAR(255) NOT NULL
            );
            ");
        }
    }

    public function query($query, $params = []) {
        $statement = self::$connection -> prepare($query);
        $statement -> execute($params);

        return $statement;
    }
}