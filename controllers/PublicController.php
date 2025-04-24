<?php
namespace Controllers;

use MVC\Router;

class PublicController {
    public static function home(Router $router) {
        $title = 'home.title';
        $init = true;
        $router->render('pages/index',[
            'title' => $title,
            'init' => $init
        ]);
    }
}

