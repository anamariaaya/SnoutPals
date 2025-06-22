<?php

use Core\DB;

require_once __DIR__ . '/../includes/app.php';
require_once __DIR__ . '/../Core/DB.php';

DB::connect($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_BD']);

require_once __DIR__ . '/seeders/20250407_00_roles_permissions.php';

$seeder = new Seeder_20250407_00_roles_permissions;
$seeder->run();
