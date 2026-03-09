<?php

require_once __DIR__ . '/../Models/Project.php';
require_once __DIR__ . '/../../config/database.php';

class ProjectRepository
{
    private PDO $connection;

    public function __construct()
    {
        $database = new Database();
        $this->connection = $database->connect();
    }
    
    public function findByClientId(int $clientId): array
    {
        $query = "SELECT * FROM projects WHERE client_id = :client_id";

        $stmt = $this->connection->prepare($query);

        $stmt->execute([
            'client_id' => $clientId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findAllWithClient(): array
    {
        $query = "SELECT p.id, p.name, p.status, p.created_at, c.id AS client_id, c.name AS client_name FROM projects p JOIN clients c ON p.client_id = c.id ORDER BY p.id";

        $stmt = $this->connection->query($query);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data): int
    {
        $query = "INSERT INTO projects (client_id, name, status) VALUES (:client_id, :name, :status)";

        $stmt = $this->connection->prepare($query);

        $stmt->execute([
            'client_id' => $data['client_id'],
            'name' => $data['name'],
            'status' => $data['status'] ?? 'active'
        ]);

        return (int)$this->connection->lastInsertId();
    }
}