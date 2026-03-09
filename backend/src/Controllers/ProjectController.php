<?php

require_once __DIR__ . '/../Services/ProjectService.php';

class ProjectController
{
    private ProjectService $projectService;

    public function __construct()
    {
        $this->projectService = new ProjectService();
    }

    public function listByClient(int $clientId): void
    {
        try {

            $projects = $this->projectService->getProjectsByClient($clientId);

            header('Content-Type: application/json');

            echo json_encode($projects);

        } catch (InvalidArgumentException $e) {

            http_response_code(404);

            echo json_encode([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function list(): void
    {
        $projects = $this->projectService->getAllProjects();

        header('Content-Type: application/json');

        echo json_encode($projects);
    }

    public function create(array $data): void
    {
        try {

            $id = $this->projectService->createProject($data);

            http_response_code(201);

            echo json_encode([
                'message' => 'Project created',
                'id' => $id
            ]);

        } catch (InvalidArgumentException $e) {

            http_response_code(400);

            echo json_encode([
                'error' => $e->getMessage()
            ]);
        }
    }
}