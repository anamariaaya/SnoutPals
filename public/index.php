<?php

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\APIController;
use Controllers\AuthController;
use Controllers\PublicController;



$router = new Router();
session_start();

$router->get('/', [PublicController::class, 'home']);

// Auth Routes
$router->get('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'register']);
$router->get('/account-created', [AuthController::class, 'accountCreated']);

//Auth API Routes
$router->post('/api/auth/login', [AuthController::class, 'loginPost']);
$router->post('/api/auth/register', [AuthController::class, 'registerPost']);

//API Routes
$router->get('/api/language', [APIController::class, 'language']);
$router->get('/api/alerts', [APIController::class, 'alerts']);

$router->checkRoutes();