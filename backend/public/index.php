<?php

require_once __DIR__ . '/../src/Controllers/ClientController.php';

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Simple routing
$controller = new ClientController();

if ($uri === '/clients' && $method === 'GET') {
    $controller->list();
    return;
}

if (preg_match('#^/clients/(\d+)$#', $uri, $matches) && $method === 'GET') {
    $controller->show((int) $matches[1]);
    return;
}

if ($uri === '/clients' && $method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true) ?? [];
    $controller->create($data);
    return;
}

if (preg_match('#^/clients/(\d+)$#', $uri, $matches) && $method === 'DELETE') {
    $controller->delete((int) $matches[1]);
    return;
}

// Fallback
http_response_code(404);
header('Content-Type: application/json');
echo json_encode(['error' => 'Route not found']);
