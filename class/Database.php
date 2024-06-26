<?php
class Database {
    public function getConnect(){
        $host = "localhost";
        $db = "mydatabase";
        $username = "PhanTam";
        $password = "E.7MVCpvJ88AMsX1";

        $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

        try {
            $pdo = new PDO($dsn, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable error reporting
            
            return $pdo;
        } catch (PDOException $ex) {
            echo "Connection failed: " . $ex->getMessage(); // Display error message
            exit;
        }
    }
}
