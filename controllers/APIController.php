<?php
namespace Controllers;

use MVC\Router;

class APIController {
    public static function language(Router $router) {
        echo json_encode($_SESSION['lang']);
    }

    public static function alerts(){
        //leer el archivo de alerts.json
        $alerts = file_get_contents(__DIR__.'/../alerts.json');
        //convertir el json a un arreglo asociativo
        $alerts = json_decode($alerts, true);

        echo json_encode($alerts);
    }
}