<?php

class APIResource {
    public static function collection(array $items, $resourceClass) {
        return array_map(fn($item) => (new $resourceClass($item))->toArray(), $items);
    }
}
