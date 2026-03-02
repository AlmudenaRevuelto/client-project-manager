<?php

require_once __DIR__ . '/../Models/Client.php';
require_once __DIR__ . '/../../config/database.php';

class ClientRepository
{
    private PDO $connection;

    public function __construct()
    {
        $database = new Database();
        $this->connection = $database->connect();
    }

    /**
     * @return Client[]
     */
    public function findAll(): array
    {
        $query = "SELECT * FROM clients";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();

        $clients = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $clients[] = new Client(
                (int) $row['id'],
                $row['name'],
                $row['email']
            );
        }

        return $clients;
    }

    public function findById(int $id): ?Client
    {
        $query = "SELECT * FROM clients WHERE id = :id LIMIT 1";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return new Client(
            (int) $row['id'],
            $row['name'],
            $row['email']
        );
    }

    public function create(Client $client): bool
    {
        $query = "INSERT INTO clients (name, email) VALUES (:name, :email)";
        $stmt = $this->connection->prepare($query);

        return $stmt->execute([
            ':name' => $client->getName(),
            ':email' => $client->getEmail()
        ]);
    }

    public function delete(int $id): bool
    {
        $query = "DELETE FROM clients WHERE id = :id";
        $stmt = $this->connection->prepare($query);

        return $stmt->execute([':id' => $id]);
    }
}
