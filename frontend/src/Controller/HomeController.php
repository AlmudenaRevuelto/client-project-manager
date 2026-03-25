<?php

namespace Frontend\Controller;

use Frontend\Core\View;
use Frontend\Service\GithubService;

class HomeController
{
    public function index()
    {
        $github = new GithubService();

        $user = $github->getUser('AlmudenaRevuelto');

        return View::render('home/index.twig', [
            'user' => $user
        ]);
    }
}