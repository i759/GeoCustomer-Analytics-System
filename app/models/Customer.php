<?php

namespace GCAS\Models;

use GCAS\Core\Database;
use PDO;

class Customer
{
    private PDO $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO customers
            (customer_code, first_name, last_name, phone, email, street_address, city, state, country, latitude, longitude)
            VALUES (:customer_code, :first_name, :last_name, :phone, :email, :street_address, :city, :state, :country, :latitude, :longitude)";

        return $this->db->prepare($sql)->execute($data);
    }

    public function getAll(): array
    {
        return $this->db->query("SELECT * FROM customers ORDER BY created_at DESC")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM customers WHERE customer_id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE customers SET
            first_name = :first_name,
            last_name = :last_name,
            phone = :phone,
            email = :email,
            street_address = :street_address,
            city = :city,
            state = :state,
            country = :country,
            latitude = :latitude,
            longitude = :longitude
            WHERE customer_id = :id";

        $data['id'] = $id;
        return $this->db->prepare($sql)->execute($data);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM customers WHERE customer_id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function countCustomers(): int
    {
        return (int) $this->db->query("SELECT COUNT(*) FROM customers")->fetchColumn();
    }

    public function countStates(): int
    {
        return (int) $this->db->query("SELECT COUNT(DISTINCT state) FROM customers WHERE state IS NOT NULL AND state <> ''")->fetchColumn();
    }

    public function countMonthlyCustomers(): int
    {
        return (int) $this->db->query("SELECT COUNT(*) FROM customers WHERE MONTH(created_at)=MONTH(CURRENT_DATE()) AND YEAR(created_at)=YEAR(CURRENT_DATE())")->fetchColumn();
    }

    public function getTopState(): string
    {
        $stmt = $this->db->query("SELECT state, COUNT(*) AS total FROM customers WHERE state IS NOT NULL AND state <> '' GROUP BY state ORDER BY total DESC LIMIT 1");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['state'] ?? 'N/A';
    }

    public function customersByState(): array
    {
        return $this->db->query("SELECT state, COUNT(*) AS total FROM customers WHERE state IS NOT NULL AND state <> '' GROUP BY state ORDER BY total DESC")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function monthlyRegistrations(): array
    {
        return $this->db->query("SELECT DATE_FORMAT(created_at,'%b') AS month, COUNT(*) AS total FROM customers GROUP BY MONTH(created_at) ORDER BY MONTH(created_at)")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecentCustomers(int $limit = 5): array
    {
        $stmt = $this->db->prepare("SELECT * FROM customers ORDER BY created_at DESC LIMIT :limit");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function topArea(): string
    {
        return $this->getTopState();
    }
}
