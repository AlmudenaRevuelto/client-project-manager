<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Router\Router;
use App\Controller\HomeController;
use App\Controller\ProjectController;

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
$router->get('/projects', [$projectController, 'list']);
$router->get('/projects/{id}', [$projectController, 'show']);

$router->dispatch($uri, $method);