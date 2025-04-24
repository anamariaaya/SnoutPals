<?php
namespace Helpers;

class ViewHelper {
    public static function renderEmail(string $templatePath, array $data = []): string {
        extract($data);
        ob_start();
        require $templatePath;
        return ob_get_clean();
    }
}
