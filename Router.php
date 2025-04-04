<?php

namespace MVC;

class Router
{
    public array $getRoutes = [];
    public array $postRoutes = [];

    public function get($url, $fn)
    {
        $this->getRoutes[$url] = $fn;
    }
    

    public function post($url, $fn)
    {
        $this->postRoutes[$url] = $fn;
    }

    public function checkRoutes()
    {
        define('DEFAULT_LANGUAGE', 'en');
        chooseLanguage();        

        $url_current = $_SERVER['PATH_INFO'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {
            $fn = $this->getRoutes[$url_current] ?? null;
        } else {
            $fn = $this->postRoutes[$url_current] ?? null;
        }
        if ( $fn ) {
            call_user_func($fn, $this);
        } else {
            echo "Páge not found or invalid route";
            $this->renderJson(['error' => 'Page not found or invalid route'], 404);
        }
    }

    public function render($view, $data = []){
        $lang_file = __DIR__ . "/lang.json";

        if (file_exists($lang_file)) {
            $lang_json = file_get_contents($lang_file);
            $lang_array = json_decode($lang_json, true);
            if (is_array($lang_array)) {
                $data = array_merge($data, $lang_array);
            }
        }

        foreach ($data as $key => $value) {
            $$key = $value; 
        }

        ob_start();

        include_once __DIR__ . "/views/$view.php";
        $content = ob_get_clean(); 

        $pattern = '/\{%\s*([\w\.-]+)\s*%\}/';
        $content = preg_replace_callback($pattern, function($matches) {
            return tt($matches[1]);
        }, $content);


        
        $url_current = $_SERVER['PATH_INFO'] ?? '/';

        if(str_contains($url_current, '/pets')) {
            include_once __DIR__ . "/views/layouts/pets-layout.php";
        } elseif(str_contains($url_current, '/vets')) {
            include_once __DIR__ . "/views/layouts/vets-layout.php";
        } elseif(str_contains($url_current, '/admin')) {
            include_once __DIR__ . "/views/layouts/admin-layout.php";
        } else {
            include_once __DIR__ . "/views/layouts/main-layout.php";
        }
    }

    public function renderJson($data = [], $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}                                                                                                