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

}