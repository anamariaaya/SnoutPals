<?php

use Dotenv\Dotenv;
use Core\DB;
use Model\ActiveRecord;

require __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

require 'functions.php';
require 'database.php';

//Conectarnos a la BD
$db = DB::connect($host, $user, $pass, $base);
ActiveRecord::setDB($db);
