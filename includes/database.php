<?php

    $host = $_ENV['DB_HOST'] ?? 'localhost';
    $user = $_ENV['DB_USER'] ?? 'root';
    $pass = $_ENV['DB_PASS'] ?? '';
    $base = $_ENV['DB_BD'] ?? '';

    $db = mysqli_connect($host, $user, $pass, $base);

    if (!$db) {
        die("Error de conexión a la base de datos: " . mysqli_connect_error());
    }
