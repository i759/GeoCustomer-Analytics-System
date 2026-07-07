<?php

class Database
{
    private $host = DB_HOST;
    private $db_name = DB_NAME;
    private $username = DB_USER;
    private $password = DB_PASS;

    private $connection;

    public function connect()
    {
        $this->connection = null;

        try {
            $this->connection = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4",
                $this->username,
                $this->password
            );

            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            die("Database Connection Failed: " . $e->getMessage());
        }

        return $this->connection;
    }
}