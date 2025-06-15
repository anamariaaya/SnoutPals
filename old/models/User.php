<?php

namespace Model;

class User extends ActiveRecord {
    protected static $table = 'users';

    protected static $columnsDB = [
        'id', 'role_id', 'name', 'lastname', 'email', 'password', 'avatar',
        'created_at', 'updated_at', 'deleted_at', 'confirmed_at'
    ];

    // --- DB fields
    public ?int $id = null;
    public ?int $role_id = null;
    public ?string $name = null;
    public ?string $lastname = null;
    public ?string $email = null;
    public ?string $password = null;
    public ?string $avatar = null;
    public ?string $created_at = null;
    public ?string $updated_at = null;
    public ?string $deleted_at = null;
    public ?string $confirmed_at = null;

    // --- Non-DB logic fields
    public ?string $confirmPassword = null;

    public function __construct(array $args = []) {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    // --- Validations ---
    public function validateAccount(): array {
        if (!$this->name) {
            self::$alerts['error'][] = 'user_alerts.name_required';
        }
        if (!$this->lastname) {
            self::$alerts['error'][] = 'user_alerts.lastname_required';
        }
        if (!$this->email) {
            self::$alerts['error'][] = 'user_alerts.email_required';
        }
        if ($this->email && !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alerts['error'][] = 'user_alerts.email_invalid';
        }
        return self::$alerts;
    }

    public function validatePassword(): array {
        if (!$this->password) {
            self::$alerts['error'][] = 'user_alerts.password_required';
        }

        if ($this->password && strlen($this->password) < 8) {
            self::$alerts['error'][] = 'user_alerts.password_length';
        }

        if ($this->password) {
            $uppercase = preg_match('@[A-Z]@', $this->password);
            $lowercase = preg_match('@[a-z]@', $this->password);
            $number    = preg_match('@[0-9]@', $this->password);

            if (!$uppercase || !$lowercase || !$number) {
                self::$alerts['error'][] = 'user_alerts.password_weak';
            }

            if (isset($this->confirmPassword) && $this->password !== $this->confirmPassword) {
                self::$alerts['error'][] = 'user_alerts.passwords_not_match';
            }
        }

        return self::$alerts;
    }

    // --- Utils ---
    public function hashPassword(): void {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function checkPassword(string $input): bool {
        return password_verify($input, $this->password);
    }

    public function isConfirmed(): bool {
        return !empty($this->confirmed_at);
    }
}
