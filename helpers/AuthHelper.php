<?php

class AuthHelper {

    public static function isLoggedIn(): bool {
        return isset($_SESSION['user_id']);
    }

    public static function userId(): ?int {
        return $_SESSION['user_id'] ?? null;
    }

    public static function userRole(): ?string {
        return $_SESSION['role_slug'] ?? null;
    }

    public static function isAdmin(): bool {
        return self::userRole() === 'admin';
    }

    public static function isVet(): bool {
        return self::userRole() === 'vet';
    }

    public static function isPetOwner(): bool {
        return self::userRole() === 'pet-owner';
    }

    public static function logout(): void {
        session_unset();
        session_destroy();
        header('Location: /');
        exit;
    }
}
