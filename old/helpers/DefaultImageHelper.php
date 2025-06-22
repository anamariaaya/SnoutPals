<?php

class DefaultImageHelper {
    public static function get($type) {
        return match($type) {
            'pet' => 'default-pet.webp',
            'owner' => 'default-avatar.webp',
            'vet' => 'default-logo.webp',
            default => 'default-image.webp'
        };
    }
}
