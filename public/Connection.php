<?php

/**
 * PHP MySQL Create Table Demo
 */
class Users {

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

    /**
     *
     * @var type
     */
    private $pdo = null;

    /**
     * Open the database connection
     */
    public function __construct() {
        // open database connection
        $conStr = sprintf("mysql:host=%s;dbname=%s", self::DB_HOST, self::DB_NAME);
        try {
            $this->pdo = new PDO($conStr, self::DB_USER, self::DB_PASSWORD);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * close the database connection
     */
    public function __destruct() {
        // close the database connection
        $this->pdo = null;
    }

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
$obj = new Users();
$obj->createTaskTable();
?>
