<?php

namespace Helpers;

class SecurityHelper
{
    public static function createToken(int $length = 32): string
    {
        return bin2hex(random_bytes($length));
    }

    public static function secureCompare(string $a, string $b): bool
    {
        return hash_equals($a, $b);
    }

    public static function generateRandomString(int $length = 16): string
    {
        return substr(str_shuffle(bin2hex(random_bytes($length))), 0, $length);
    }
}
