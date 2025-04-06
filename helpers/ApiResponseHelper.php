<?php

class ApiResponseHelper {
    
    public static function success($data = [], $message = 'OK', $status = 200): string {
        http_response_code($status);
        return json_encode([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ]);
    }

    public static function error($message = 'Something went wrong', $status = 400, $errors = []): string {
        http_response_code($status);
        return json_encode([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors
        ]);
    }

    public static function validation($errors, $message = 'Validation failed', $status = 422): string {
        http_response_code($status);
        return json_encode([
            'status' => 'fail',
            'message' => $message,
            'errors' => $errors
        ]);
    }
}
