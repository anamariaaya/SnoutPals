<?php

use Core\DB;

class Seeder_20250407_00_roles_permissions {
    public function run() {
        $roles = [
            ['name' => 'Admin', 'slug' => 'admin'],
            ['name' => 'Veterinarian', 'slug' => 'vet'],
            ['name' => 'Pet Owner', 'slug' => 'pet-owner']
        ];

        $permissions = [
            ['name' => 'Manage Users', 'slug' => 'manage_users'],
            ['name' => 'Manage Owned Pets', 'slug' => 'manage_own_pets'],
            ['name' => 'Manage Patients', 'slug' => 'manage_patient_pets'],
            ['name' => 'View Dashboard', 'slug' => 'view_dashboard']
        ];

        $role_permissions = [
            'admin' => ['manage_users', 'manage_own_pets', 'manage_patient_pets', 'view_dashboard'],
            'vet' => ['manage_patient_pets', 'view_dashboard'],
            'pet-owner' => ['manage_own_pets', 'view_dashboard']
        ];

        $db = DB::getConnection();

        // Insert roles if they don't exist
        foreach ($roles as $role) {
            $stmt = $db->prepare("SELECT id FROM roles WHERE slug = ? LIMIT 1");
            $stmt->bind_param('s', $role['slug']);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                $stmt = $db->prepare("INSERT INTO roles (name, slug, created_at, updated_at) VALUES (?, ?, NOW(), NOW())");
                $stmt->bind_param('ss', $role['name'], $role['slug']);
                $stmt->execute();
            }
        }

        // Insert permissions if they don't exist
        foreach ($permissions as $permission) {
            $stmt = $db->prepare("SELECT id FROM permissions WHERE slug = ? LIMIT 1");
            $stmt->bind_param('s', $permission['slug']);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                $stmt = $db->prepare("INSERT INTO permissions (name, slug, created_at, updated_at) VALUES (?, ?, NOW(), NOW())");
                $stmt->bind_param('ss', $permission['name'], $permission['slug']);
                $stmt->execute();
            }
        }

        // Link roles to permissions
        foreach ($role_permissions as $roleSlug => $permSlugs) {
            $roleStmt = $db->prepare("SELECT id FROM roles WHERE slug = ? LIMIT 1");
            $roleStmt->bind_param('s', $roleSlug);
            $roleStmt->execute();
            $roleResult = $roleStmt->get_result();
            $roleRow = $roleResult->fetch_assoc();
            $roleId = $roleRow['id'] ?? null;

            if (!$roleId) continue;

            foreach ($permSlugs as $permSlug) {
                $permStmt = $db->prepare("SELECT id FROM permissions WHERE slug = ? LIMIT 1");
                $permStmt->bind_param('s', $permSlug);
                $permStmt->execute();
                $permResult = $permStmt->get_result();
                $permRow = $permResult->fetch_assoc();
                $permId = $permRow['id'] ?? null;

                if (!$permId) {
                    echo "⚠️ Permission '{$permSlug}' not found. Skipping...\n";
                    continue;
                }

                // Avoid duplicates in role_permissions
                $check = $db->prepare("SELECT id FROM role_permissions WHERE role_id = ? AND permission_id = ? LIMIT 1");
                $check->bind_param('ii', $roleId, $permId);
                $check->execute();
                $checkResult = $check->get_result();

                if ($checkResult->num_rows === 0) {
                    $link = $db->prepare("INSERT INTO role_permissions (role_id, permission_id) VALUES (?, ?)");
                    $link->bind_param('ii', $roleId, $permId);
                    $link->execute();
                }
            }
        }

        echo "\n✅ Seeder 20250407_00_roles_permissions executed successfully.\n";
    }
}
