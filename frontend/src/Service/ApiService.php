<?php

namespace App\Service;

class ApiService
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = 'http://localhost/api';
    }

    private function request(string $endpoint): array
    {
        $url = $this->baseUrl . $endpoint;

        $response = file_get_contents($url);

        if ($response === false) {
            return [];
        }

        return json_decode($response, true) ?? [];
    }

    public function getClients(): array
    {
        return $this->request('/clients');
    }

    public function getClient(int $id): array
    {
        return $this->request('/clients/' . $id);
    }

    public function getProjects(): array
    {
        return $this->request('/projects');
    }

    public function getProject(int $id): array
    {
        return $this->request('/projects/' . $id);
    }

    public function getProjectsByClient(int $clientId): array
    {
        return $this->request('/clients/' . $clientId . '/projects');
    }
}