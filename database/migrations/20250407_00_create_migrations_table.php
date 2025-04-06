<?php

class Migration_20250407_00_create_migrations_table {
    public function up() {
        Core\DB::query("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            filename VARCHAR(255) NOT NULL UNIQUE,
            migrated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");
    }

    public function down() {
        Core\DB::query("DROP TABLE IF EXISTS migrations;");
    }
}
