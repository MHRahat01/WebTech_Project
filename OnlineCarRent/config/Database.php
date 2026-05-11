<?php
// config/Database.php
// PDO singleton for connecting to the existing MySQL database.
// Uses the same connection parameters as the project's mysqli config in model/db.php

class Database
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        $host = '127.0.0.1';
        $db   = 'online_car_rent';
        $user = 'root';
        $pass = '';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            // In production, log this instead of echo
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    // Get the singleton PDO instance
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance->pdo;
    }

    // Prevent cloning and unserialization
    private function __clone() {}
    private function __wakeup() {}
}

?>
