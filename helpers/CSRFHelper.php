<?php

class CSRFHelper {
    protected static string $tokenKey = '_csrf_token';

    // Generate a token and store it in session if not already set
    public static function generateToken(): string {
        if (!isset($_SESSION)) session_start();

        if (empty($_SESSION[self::$tokenKey])) {
            $_SESSION[self::$tokenKey] = bin2hex(random_bytes(32));
        }

        return $_SESSION[self::$tokenKey];
    }

    // Return the hidden field to include in HTML forms
    public static function getTokenField(): string {
        $token = self::generateToken();
        return '<input type="hidden" name="_csrf_token" value="' . $token . '">';
    }

    // Validate token from POST or header
    public static function validateToken(): bool {
        if (!isset($_SESSION)) session_start();

        $token = $_POST['_csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        return hash_equals($_SESSION[self::$tokenKey] ?? '', $token);
    }

    // Optional: Regenerate token after validation to prevent reuse
    public static function regenerate(): void {
        if (!isset($_SESSION)) session_start();
        $_SESSION[self::$tokenKey] = bin2hex(random_bytes(32));
    }
}
