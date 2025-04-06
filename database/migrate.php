<?php

use Core\DB;

require_once __DIR__ . '/../includes/app.php';
require_once __DIR__ . '/../Core/DB.php';

DB::connect($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_BD']);

$migrationsPath = __DIR__ . '/migrations';
$executed = [];

// Ensure the table exists
DB::query("CREATE TABLE IF NOT EXISTS migrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");

$result = DB::query("SELECT name FROM migrations");
while ($row = $result->fetch_assoc()) {
    $executed[] = $row['name'];
}

$files = scandir($migrationsPath);
sort($files); // Ensures they run in the correct order

foreach ($files as $file) {
    if (pathinfo($file, PATHINFO_EXTENSION) !== 'php') continue;
    if (in_array($file, $executed)) continue;

    require_once $migrationsPath . '/' . $file;

    // Class name is based on filename: 20250406_roles.php => Migration_20250406_roles
    $className = 'Migration_' . pathinfo($file, PATHINFO_FILENAME);
    if (class_exists($className)) {
        echo "Running: $className\n";
        $migration = new $className;
        $migration->up();

        // Store it in the migrations table
        $stmt = DB::getConnection()->prepare("INSERT INTO migrations (name) VALUES (?)");
        $stmt->bind_param('s', $file);
        $stmt->execute();
    }
}
