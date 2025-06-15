<?php
namespace Controllers;

use CSRFHelper;
use Model\User;
use MVC\Router;
use Model\UserToken;
use Helpers\SecurityHelper;
use Resources\Emails\Email;
use Helpers\ApiResponseHelper;

class AuthController {
    public static function register(Router $router) {
        $title = 'register.title';
        $role = $_GET['role'] ?? null;
        $router->render('auth/register',[
            'title' => $title
        ]);
    }

    public static function registerPost() {
        header('Content-Type: application/json');
    
        $input = json_decode(file_get_contents('php://input'), true);

        // Honeypot check
        if (!empty($input['honeypot'])) {
            echo ApiResponseHelper::error('api-response.bot_detected', 403);
            return;
        }
    
        // if (!CSRFHelper::check($input['csrf_token'] ?? '')) {
        //     echo ApiResponseHelper::forbidden('Invalid CSRF token.');
        //     return;
        // }
        
        // Role validation
        $role = isset($_GET['role']) ? (int) $_GET['role'] : null;
        if (!in_array($role, [2, 3])) {
            echo ApiResponseHelper::error('api-response.invalid_role', 400);
            return;
        }
    
        // Build user
        $user = new User;
        $user->synchronize($input);
        $user->name = cleanText($user->name);
        $user->lastname = cleanText($user->lastname);
        $user->email = cleanText($user->email);
        $user->role_id = $role;
        $user->confirmPassword = $input['confirmPassword'] ?? null;
    
        // Validations
        $alerts = array_merge(
            $user->validateAccount(),
            $user->validatePassword()
        );
    
        if (!empty($alerts)) {
            echo ApiResponseHelper::validation($alerts);
            return;
        }
    
        // Check if user exists
        if (User::exists('email', $user->email)) {
            echo ApiResponseHelper::error('user_alerts.user_exists', 409);
            return;
        }
    
        // Hash and save user
        $user->hashPassword();
        $user->confirmed_at = null;
    
        if (!$user->save()) {
            echo ApiResponseHelper::error('api-response.user_save_error', 500);
            return;
        }
    
        // Create and store token
        $token = SecurityHelper::createToken();
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 day'));
    
        $userToken = new UserToken([
            'user_id' => $user->id,
            'token' => $token,
            'type' => 'confirmation',
            'expires_at' => $expiresAt
        ]);
    
        if (!$userToken->save()) {
            echo ApiResponseHelper::error('api-response.token_save_error', 500);
            return;
        }
    
        // Send confirmation email
        $email = new Email($user->email, $user->name, $token);
        $email->sendConfirmation($_SESSION['lang'] ?? 'en');
    
        echo ApiResponseHelper::success(null, 'user_alerts.user_created', 201);
    }
    
    


    public static function accountCreated(Router $router) {
        $title = 'register.account_created_title';
        $router->render('auth/account-created',[
            'title' => $title
        ]);
    }
}

