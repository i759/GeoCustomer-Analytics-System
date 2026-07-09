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
    /**
 * Update the user's last login time.
 */
public function updateLastLogin(int $userId): bool
{
    $sql = "UPDATE users
            SET last_login = NOW()
            WHERE id = :id";

    $stmt = $this->db->prepare($sql);

    return $stmt->execute([
        ':id' => $userId
    ]);
}
}