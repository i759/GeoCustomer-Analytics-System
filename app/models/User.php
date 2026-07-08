<?php

namespace GCAS\Models;

use GCAS\Core\Database;
use PDO;

class User
{
    private PDO $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    /**
     * Find a user by email or username.
     */
    public function findByLogin(string $login): array|false
    {
        $sql = "SELECT * FROM users
                WHERE email = :login
                   OR username = :login
                LIMIT 1";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':login', $login);

        $stmt->execute();

        return $stmt->fetch();
    }
}