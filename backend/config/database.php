<?php

class Database
{
    private string $host = 'localhost';
    private string $dbName = 'client_project_manager';
    private string $username = 'root';
    private string $password = '';

    public function connect(): PDO
    {
        try {
            $connection = new PDO(
                "mysql:host={$this->host};dbname={$this->dbName};charset=utf8",
                $this->username,
                $this->password
            );

            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $connection;

        } catch (PDOException $e) {
            die('Database connection error: ' . $e->getMessage());
        }
    }
}
