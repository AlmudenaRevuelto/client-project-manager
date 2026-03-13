<?php

namespace Backend\Service;

use Backend\Repository\ProjectRepository;
use Backend\Repository\ClientRepository;
use Backend\Model\Project;
use InvalidArgumentException;

class ProjectService
{
    private ProjectRepository $projectRepository;
    private ClientRepository $clientRepository;

    public function __construct(
        ProjectRepository $projectRepository,
        ClientRepository $clientRepository
    ) {
        $this->projectRepository = $projectRepository;
        $this->clientRepository = $clientRepository;
    }

    /**
     * Return projects that belong to a specific client.
     *
     * @param int $clientId
     * @return Project[]
     */
    public function getProjectsByClient(int $clientId): array
    {
        $client = $this->clientRepository->findById($clientId);

        if (!$client) {
            throw new InvalidArgumentException('Client not found');
        }

        return $this->projectRepository->findByClientId($clientId);
    }

    /**
     * @return Project[]
     */
    public function getAllProjects(): array
    {
        return $this->projectRepository->findAllWithClient();
    }

    /**
     * Validate payload and create a new project.
     *
     * Expected keys in $data: name, client_id, status (optional).
     *
     * @param array $data
     * @return bool
     */
    public function createProject(array $data): bool
    {
        if (empty($data['name'])) {
            throw new InvalidArgumentException('Project name is required');
        }

        if (empty($data['client_id'])) {
            throw new InvalidArgumentException('client_id is required');
        }

        $client = $this->clientRepository->findById((int) $data['client_id']);
        if (!$client) {
            throw new InvalidArgumentException('Client not found');
        }

        $status = $data['status'] ?? 'active';
        $allowedStatus = ['active', 'finished'];

        if (!in_array($status, $allowedStatus, true)) {
            throw new InvalidArgumentException('Invalid status value');
        }

        $project = new Project(
            null,
            $data['name'],
            $status,
            null,
            $client
        );

        return $this->projectRepository->create($project);
    }

    /**
     * Retrieve a project by ID (includes client data).
     *
     * @param int $id
     * @return Project
     */
    public function getProjectById(int $id): Project
    {
        $project = $this->projectRepository->findByIdWithClient($id);

        if (!$project) {
            throw new InvalidArgumentException('Project not found');
        }

        return $project;
    }

    /**
     * Update a project.
     *
     * @param int $id
     * @param array $data
     */
    public function updateProject(int $id, array $data): void
    {
        if (empty($data['name'])) {
            throw new InvalidArgumentException('Project name is required');
        }

        if (!isset($data['status'])) {
            throw new InvalidArgumentException('Project status is required');
        }

        $allowedStatus = ['active', 'finished'];

        if (!in_array($data['status'], $allowedStatus)) {
            throw new InvalidArgumentException('Invalid status value');
        }

        $updated = $this->projectRepository->update($id, $data);

        if (!$updated) {
            throw new InvalidArgumentException('Project not found');
        }
    }

    /**
     * Delete a project by ID.
     *
     * @param int $id
     */
    public function deleteProject(int $id): void
    {
        $deleted = $this->projectRepository->delete($id);

        if (!$deleted) {
            throw new InvalidArgumentException('Project not found');
        }
    }
}