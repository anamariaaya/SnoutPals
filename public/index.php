<?php

    require_once __DIR__ . '/../includes/app.php';

    use MVC\Router;
    use Controllers\PublicController;

    $router = new Router();
    session_start();

    $router->get('/', [PublicController::class, 'home']);
    $router->get('/register', [PublicController::class, 'register']);

    $router->checkRoutes();