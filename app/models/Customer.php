<?php

namespace GCAS\Models;

use GCAS\Core\Database;
use PDO;

class Customer
{
    private PDO $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    /**
     * Add a new customer
     */
    public function create(array $data): bool
    {
        $sql = "INSERT INTO customers
        (
            customer_code,
            first_name,
            last_name,
            phone,
            email,
            street_address,
            city,
            state,
            country,
            latitude,
            longitude
        )

        VALUES
        (
            :customer_code,
            :first_name,
            :last_name,
            :phone,
            :email,
            :street_address,
            :city,
            :state,
            :country,
            :latitude,
            :longitude
        )";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute($data);
    }

    /**
     * Get all customers
     */
    public function getAll(): array
    {
        $stmt = $this->db->query(
            "SELECT * FROM customers
             ORDER BY created_at DESC"
        );

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get customer by ID
     */
    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT *
             FROM customers
             WHERE customer_id = :id"
        );

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Count all customers
     */
    public function countCustomers(): int
    {
        return (int)$this->db
            ->query("SELECT COUNT(*) FROM customers")
            ->fetchColumn();
    }

    /**
     * Count states represented
     */
    public function countStates(): int
    {
        return (int)$this->db
            ->query("SELECT COUNT(DISTINCT state) FROM customers")
            ->fetchColumn();
    }

    /**
     * Customers added this month
     */
    public function countMonthlyCustomers(): int
    {
        return (int)$this->db
            ->query("
                SELECT COUNT(*)
                FROM customers
                WHERE MONTH(created_at)=MONTH(CURRENT_DATE())
                AND YEAR(created_at)=YEAR(CURRENT_DATE())
            ")
            ->fetchColumn();
    }
    /**
 * Get the state with the highest number of customers
 */
public function getTopState(): string
{
    $stmt = $this->db->query("
        SELECT state, COUNT(*) AS total
        FROM customers
        GROUP BY state
        ORDER BY total DESC
        LIMIT 1
    ");

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row ? $row['state'] : "N/A";
}
/**
 * Get customer distribution by state
 */
public function customersByState(): array
{
    $stmt = $this->db->query("
        SELECT
            state,
            COUNT(*) AS total
        FROM customers
        GROUP BY state
        ORDER BY state ASC
    ");

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


/**
 * Get customer registrations by month
 */
public function monthlyRegistrations(): array
{
    $stmt = $this->db->query("
        SELECT
            DATE_FORMAT(created_at,'%b') AS month,
            COUNT(*) AS total
        FROM customers
        GROUP BY MONTH(created_at)
        ORDER BY MONTH(created_at)
    ");

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
 /**
     * Get latest customers
     */

    public function getRecentCustomers(int $limit = 5): array
{
    $stmt = $this->db->prepare(
        "SELECT *
         FROM customers
         ORDER BY created_at DESC
         LIMIT :limit"
    );

    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
    /**
 * Most represented state
 */
public function topArea(): string
{
    $stmt = $this->db->query("
        SELECT state
        FROM customers
        GROUP BY state
        ORDER BY COUNT(*) DESC
        LIMIT 1
    ");

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['state'] ?? 'N/A';
}

}