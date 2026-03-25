<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Frontend\Router\Router;
use Frontend\Controller\HomeController;
use Frontend\Controller\ProjectController;

$router = new Router();

$homeController = new HomeController();
$projectController = new ProjectController();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$uri = rtrim($uri, '/') ?: '/';

/*
|--------------------------------------------------------------------------
| Routes
|--------------------------------------------------------------------------
*/

$router->get('/', [$homeController, 'index']);
$router->get('/projects/{id}', [$projectController, 'show']);
$router->add('GET', '/projects', [$projectController, 'index']);

$router->dispatch($uri, $method);