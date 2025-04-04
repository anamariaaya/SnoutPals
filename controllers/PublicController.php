<?php
namespace Controllers;

use MVC\Router;

class PublicController {
    public static function home(Router $router) {
        $title = 'home.title';
        $router->render('pages/public/index',[
            'title' => $title,
        ]);
    }
}

?>