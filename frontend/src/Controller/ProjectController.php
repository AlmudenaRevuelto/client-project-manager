<?php

namespace App\Controller;

use App\Service\ApiService;
use App\Core\View;

class ProjectController
{
    public function list()
    {
        $api = new ApiService();

        $projects = $api->getProjects();

        View::render('project/list.twig', [
            'projects' => $projects
        ]);
    }

    public function show(int $id)
    {
        $api = new ApiService();

        $project = $api->getProject($id);

        View::render('project/show.twig', [
            'project' => $project
        ]);
    }
}