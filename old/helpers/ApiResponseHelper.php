<?php

namespace Helpers;

class ApiResponseHelper {

    protected static bool $debug = false; // Set to true in dev environment if needed

    public static function setDebug(bool $enabled): void
    {
        self::$debug = $enabled;
    }
    
    public static function success($data = [], $message = 'api-response.success', $status = 200): string {
        http_response_code($status);
        return json_encode([
            'status' => 'success',
            'message' => tt($message),
            'data' => $data
        ]);
    }

    public static function error($message = 'api-response.error', $status = 400, $errors = []): string {
        http_response_code($status);
        return json_encode([
            'status' => 'error',
            'message' => tt($message),
            'errors' => $errors,
            'debug' => self::$debug ? debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS) : null
        ]);
    }

    public static function validation($errors, $message = 'api-response.validation', $status = 422): string {
        http_response_code($status);
        return json_encode([
            'status' => 'fail',
            'message' => tt($message),
            'errors' => $errors,
            'debug' => self::$debug ? debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS) : null
        ]);
    }

    public static function unauthorized(string $message = 'api-response.unauthorized'): void
    {
        self::error($message, 401);
    }

    public static function forbidden(string $message = 'api-response.forbidden'): void
    {
        self::error($message, 403);
    }

    public static function notFound(string $message = 'api-response.not_found'): void
    {
        self::error($message, 404);
    }
}
