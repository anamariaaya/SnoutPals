<?php

use Core\DB;

require_once __DIR__ . '/../includes/app.php';
require_once __DIR__ . '/../Core/DB.php';

DB::connect($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_BD']);

$migrationsPath = __DIR__ . '/migrations';

// Ensure the table exists
DB::query("CREATE TABLE IF NOT EXISTS migrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");

$result = DB::query("SELECT name FROM migrations ORDER BY id DESC");
$executed = [];
while ($row = $result->fetch_assoc()) {
    $executed[] = $row['name'];
}

if (empty($executed)) {
    echo "No migrations to rollback.\n";
    exit;
}

$lastMigration = array_shift($executed);
require_once $migrationsPath . '/' . $lastMigration;

// Build class name based on filename
$className = 'Migration_' . pathinfo($lastMigration, PATHINFO_FILENAME);

if (!class_exists($className)) {
    echo "Class $className not found.\n";
    exit;
}

echo "Rolling back: $className\n";
$migration = new $className();
$migration->down();

// Remove from migrations table
$stmt = DB::getConnection()->prepare("DELETE FROM migrations WHERE name = ?");
$stmt->bind_param('s', $lastMigration);
$stmt->execute();

echo "Rolled back: $lastMigration\n";
