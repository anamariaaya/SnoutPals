<?php

namespace Resources\Emails;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Helpers\ViewHelper;

class Email {
    public string $email;
    public string $name;
    public string $token;

    public function __construct(string $email, string $name, string $token) {
        $this->email = $email;
        $this->name = $name;
        $this->token = $token;
    }

    public function sendConfirmation(string $lang = 'en'): void {
        $translations = [
            'en' => [
                'subject' => 'Activate your SnoutPals account',
                'heading' => "Welcome to SnoutPals, {$this->name}!",
                'text' => 'To confirm your account, click the button below:',
                'button' => 'Confirm Account',
                'footer' => 'If you did not create an account, no further action is required.'
            ],
            'es' => [
                'subject' => 'Activa tu cuenta de SnoutPals',
                'heading' => "¡Bienvenido(a) a SnoutPals, {$this->name}!",
                'text' => 'Necesitamos verificar tu correo electrónico para darte acceso a la mejor plataforma de cuidado animal.',
                'button' => 'Confirmar Cuenta',
                'footer' => 'Si no creaste una cuenta, no es necesario que hagas nada.'
            ]
        ];
    
        $t = $translations[$lang] ?? $translations['en']; // fallback to English
    
        $htmlContent = ViewHelper::renderEmail(__DIR__ . '/templates/layout.php', [
            'title' => $t['subject'],
            'content' => "
                <h1>{$t['heading']}</h1>
                <p>{$t['text']}</p>
                <a class='button' href='http://localhost:3000/confirm-account?token={$this->token}&lang={$lang}'>{$t['button']}</a>
                <footer class='footer'>{$t['footer']}</footer>
            "
        ]);

    
        $this->send($t['subject'], $htmlContent);
    }
    

    private function send(string $subject, string $htmlContent): void {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = $_ENV['EMAIL_HOST'];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['EMAIL_USER'];
            $mail->Password = $_ENV['EMAIL_PASS'];
            $mail->Port = $_ENV['EMAIL_PORT'];

            $mail->setFrom('no-reply@snoutpals.com', 'SnoutPals');
            $mail->addAddress($this->email, $this->name);

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = $subject;
            $mail->Body = $htmlContent;

            $mail->send();
        } catch (Exception $e) {
            error_log("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
        }
    }
}
