<?php

namespace Model;

class UserToken extends ActiveRecord {
    protected static $table = 'user_tokens';
    protected static $columnsDB = ['id', 'user_id', 'token', 'type', 'expires_at', 'created_at'];

    public int|null $id = null;
    public int|null $user_id = null;
    public string|null $token = null;
    public string|null $type = null;
    public string|null $expires_at = null;
    public string|null $created_at = null;

    public function __construct(array $args = []) {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public static function generate($userId, $type = 'confirmation', $expiresInMinutes = 60): self {
        $token = bin2hex(random_bytes(16));

        $expiresAt = (new \DateTime())->add(new \DateInterval("PT{$expiresInMinutes}M"))->format('Y-m-d H:i:s');

        $userToken = new self([
            'user_id' => $userId,
            'token' => $token,
            'type' => $type,
            'expires_at' => $expiresAt
        ]);

        $userToken->save();
        return $userToken;
    }

    public static function validateToken($token, $type = 'confirmation'): ?self {
        $now = date('Y-m-d H:i:s');
        $tokenRecord = self::where('token', $token)
            ->where('type', $type)
            ->where('expires_at', '>=', $now)
            ->first();

        return $tokenRecord;
    }
}
