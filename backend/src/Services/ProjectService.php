<?php

require_once __DIR__ . '/../Repositories/ProjectRepository.php';
require_once __DIR__ . '/../Repositories/ClientRepository.php';

class ProjectService
{
    private ProjectRepository $projectRepository;
    private ClientRepository $clientRepository;

    public function __construct()
    {
        $this->projectRepository = new ProjectRepository();
        $this->clientRepository = new ClientRepository();
    }

    public function getProjectsByClient(int $clientId): array
    {
        $client = $this->clientRepository->findById($clientId);

        if (!$client) {
            throw new InvalidArgumentException('Client not found');
        }

        return $this->projectRepository->findByClientId($clientId);
    }

    public function getAllProjects(): array
    {
        $rows = $this->projectRepository->findAllWithClient();

        $projects = [];

        foreach ($rows as $row) {
            $projects[] = [
                'id' => (int)$row['id'],
                'name' => $row['name'],
                'status' => $row['status'],
                'created_at' => $row['created_at'],
                'client' => [
                    'id' => (int)$row['client_id'],
                    'name' => $row['client_name']
                ]
            ];
        }

        return $projects;
    }

    public function createProject(array $data): int
    {
        if (empty($data['name'])) {
            throw new InvalidArgumentException('Project name is required');
        }

        if (empty($data['client_id'])) {
            throw new InvalidArgumentException('client_id is required');
        }

        $client = $this->clientRepository->findById($data['client_id']);

        if (!$client) {
            throw new InvalidArgumentException('Client not found');
        }

        return $this->projectRepository->create($data);
    }
}