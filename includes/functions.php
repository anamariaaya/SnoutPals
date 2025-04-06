<?php

//Uploads path
define('UPLOADS_PATH', $_SERVER['DOCUMENT_ROOT'].'/uploads/');
define('PETS_IMAGES_PATH', UPLOADS_PATH . 'pets/');
define('VETS_IMAGES_PATH', UPLOADS_PATH . 'vets/');
define('OWNERS_IMAGES_PATH', UPLOADS_PATH . 'owners/');
define('DOCS_PATH', UPLOADS_PATH . 'documents/');


//Resources path
define('RESOURCES_PATH', $_SERVER['DOCUMENT_ROOT'].'/resources/');
define('PLACEHOLDER_PATH', RESOURCES_PATH . 'placeholder/');
define('PDF_TEMPLATES_PATH', RESOURCES_PATH . 'pdf/');
define('EMAIL_TEMPLATES_PATH', RESOURCES_PATH . 'emails/');
define('CONTRACTS_PATH', RESOURCES_PATH . 'contracts/');


//Función para imprimir el código a probar y detener la ejecución del código siguiente
function debugging($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    return htmlspecialchars((string) $html ?? '', ENT_QUOTES, 'UTF-8');
}


function cleanText($value) : string {
    $value = trim((string) $value);
    return str_replace("'", "´", $value);
}


function redirection(string $url){
    $id = s($_GET['id']);
    //Validar la URL por ID válido
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id){
        header("Location:${url}");
    }

    return $id;
}

function isAuth() : void {
    if(!isset($_SESSION['login'])) {
        header('Location: /');
    }
}

//Revisa la página actual para resaltar el ícono del menú
function current_page($path){
    if(str_contains($_SERVER['REQUEST_URI'], $path) === true){
        echo 'active';
    } else{
        return;
    }
}

//Revisa la página actual para resaltar el ícono del menú del dashboard
function admin_page($path){
    if(str_contains($_SERVER['REQUEST_URI'], $path) === true){
        echo 'dashboard__link--current';
    } else{
        return;
    }
}

function isAdmin() : void {
    if(($_SESSION['userLevel'] !== '1')){
        header('Location: /');
    }
}

function isPet() : void {
    if(($_SESSION['userLevel'] !== '2')){
        header('Location: /');
    }
}

function isVet() : void {
    if(($_SESSION['userLevel'] !== '3')){
        header('Location: /');
    }
}

//Compueba si el usuario está logueado y redirige a su dashboard
function sessionActive() : void {
    if($_SESSION['userLevel'] === '1'){
        echo '/admin/dashboard';
    } elseif($_SESSION['userLevel'] === '2'){
        echo '/builder/dashboard';
    } elseif($_SESSION['userLevel'] === '3'){
        echo '/builder/dashboard';
    } else{
        echo '/';
    }
}

function chooseLanguage() {
    if(isset($_GET['lang'])) {
        $_SESSION['lang'] = s($_GET['lang']);
        setcookie("lang_cookie", s($_GET['lang']), time() + 31536000, "/");
    }else if(isset($_COOKIE['lang_cookie'])) {
        $_SESSION['lang'] = $_COOKIE['lang_cookie'];
    }else {
        $_SESSION['lang'] = DEFAULT_LANGUAGE;
    }
    
    return $_SESSION['lang'];
}

//Función para leer e imprimir cada valor del array de idiomas
function tt($key) {
    ob_start();
    $language = chooseLanguage();

    // Absolute path to lang.json regardless of execution point
    $langPath = __DIR__ . '/../lang.json';

    if (!file_exists($langPath)) {
        return "Missing lang.json";
    }

    $json = file_get_contents($langPath);
    $translations = json_decode($json, true);

    if (!is_array($translations)) {
        return "Invalid lang format";
    }

    $segments = explode('.', $key);
    $value = $translations;

    foreach ($segments as $segment) {
        if (is_array($value) && array_key_exists($segment, $value)) {
            $value = $value[$segment];
        } else {
            return "Missing key: $key";
        }
    }

    return $value[$language] ?? "Missing lang: $language in $key";
    ob_clean();
}