<?php
// Inclure tous les fichiers nécessaires
require_once '../vendor/autoload.php';

use App\Config\Router;
use App\Controllers\ListController;
use App\Controllers\TaskController;

// Configuration des en-têtes
header('Content-Type: application/json');

// Création et configuration du routeur
$router = new Router();

// Routes pour les listes
$router->addRoute('GET', 'lists', 'ListController', 'index');
$router->addRoute('GET', 'lists/{id}', 'ListController', 'show');
$router->addRoute('POST', 'lists', 'ListController', 'create');

// Routes pour les tâches
$router->addRoute('GET', 'lists/{id}/tasks', 'TaskController', 'index');
$router->addRoute('POST', 'lists/{id}/tasks', 'TaskController', 'create');

try {
    $method = $_SERVER['REQUEST_METHOD'];
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = trim($uri, '/');

    $router->handleRequest($method, $uri);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
