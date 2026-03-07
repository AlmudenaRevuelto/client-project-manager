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
}