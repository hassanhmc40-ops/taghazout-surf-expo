<?php
require_once __DIR__ . '/../../config/config.php';

class Database {
    // Holds the single instance of this class
    public static ?Database $instance = null;

    // Holds the PDO connection
    public PDO $connection;

    // Private constructor — nobody can do "new Database()" from outside
    public function __construct() {
        $host   = Config::getHost();
        $dbName = Config::getDbName();
        $user   = Config::getUser();
        $pass   = Config::getPass();

        try {
            $this->connection = new PDO(
                'mysql:host=' . $host . ';dbname=' . $dbName . ';charset=utf8mb4',
                $user,
                $pass
            );

            // Tell PDO to throw exceptions when something goes wrong
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Return results as associative arrays by default
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    // The only way to get the instance from outside
    public static function getInstance(): Database {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Returns the PDO connection to whoever needs it
    public function getConnection(): PDO {
        return $this->connection;
    }
}



