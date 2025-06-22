<?php

class Migration_20250407_02_create_users_table {
    public function up() {
        Core\DB::query("CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            role_id INT NOT NULL,
            name VARCHAR(100) NOT NULL,
            lastname VARCHAR(100) DEFAULT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            avatar VARCHAR(255) DEFAULT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            deleted_at DATETIME DEFAULT NULL,
            confirmed_at DATETIME DEFAULT NULL,
            FOREIGN KEY (role_id) REFERENCES roles(id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");
    }

    public function down() {
        // Drop the users table if it exists
        Core\DB::query("DROP TABLE IF EXISTS users;");
    }
}
