<?php

/**
 * PHP MySQL Create Table Demo
 */

class Database {
    /**
    * DB_HOST: Domain of the site
    * DB_NAME: Name of the database
    * DB_USER: Owner of the database
    * DB_PASSWORD: Owner's password to the database
    */

    const DB_HOST = 'localhost';
    const DB_NAME = 'id6011112_atm ';
    const DB_USER = 'id6011112_joseph';
    const DB_PASSWORD = '';

    // PHP Data Object used for connecting to databases
    private $pdo = null;
}

class MySQLDatabase extends Database {

    // Open a database connection
    public function __construct() {
        $conStr = sprintf("mysql:host=%s;dbname=%s", self::DB_HOST, self::DB_NAME);
        try {
            $this->pdo = new PDO($conStr, self::DB_USER, self::DB_PASSWORD);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Close the database connection
    public function __destruct() { $this->pdo = null; }

    // Returns the PDO
    public function getPDO() { return $this->pdo; }
}

class UsersTable extends MySQLDatabase {
    /**
     * create the tasks table
     * @return boolean returns true on success or false on failure
     */
    public function createTaskTable() {
        $sql = <<<EOSQL
            CREATE TABLE IF NOT EXISTS tasks (
                task_id     INT AUTO_INCREMENT PRIMARY KEY,
                subject     VARCHAR (255)        DEFAULT NULL,
                start_date  DATE                 DEFAULT NULL,
                end_date    DATE                 DEFAULT NULL,
                description VARCHAR (400)        DEFAULT NULL
            );
EOSQL;
        return $this->pdo->exec($sql);
    }
    
    public function insUser() {
        $sql = <<<EOSQL
        INSERT INTO Users
        VALUES (
            
        );
EOSQL;
        return $this->pdo->exec($sql);
    }
}

// create tasks table
$obj = new UsersTable();
$obj->createTaskTable();
?>
