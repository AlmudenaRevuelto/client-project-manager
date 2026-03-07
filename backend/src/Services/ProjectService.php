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
}