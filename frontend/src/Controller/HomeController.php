<?php

namespace App\Controller;

use App\Service\ApiService;
use App\Core\View;

class HomeController
{
    public function index()
    {
        $api = new ApiService();

        $projects = $api->getProjects();

        View::render('home/index.twig', [
            'projects' => $projects
        ]);
    }
}