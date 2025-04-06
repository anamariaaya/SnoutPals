<?php

namespace Helpers;

use Intervention\Image\ImageManagerStatic as Image;

class ImageHelper {

    public static function save($file, $folderPath, $resizeTo = 1024, $quality = 80, $defaultImage = null) {
        if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
            return $defaultImage ?? null;
        }

        // Validate file type
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
            throw new \Exception("Invalid image file type");
        }

        // Validate size (max 2MB)
        if ($file['size'] > 2 * 1024 * 1024) {
            throw new \Exception("Image too large (max 2MB)");
        }

        // Ensure folder exists
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        // Generate unique file name
        $uniqueName = md5(uniqid(rand(), true)) . '.' . $ext;

        // Resize and compress using Intervention
        $image = Image::make($file['tmp_name']);
        $image->resize($resizeTo, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $image->save($folderPath . $uniqueName, $quality);

        return $uniqueName;
    }

    public static function delete($filePath) {
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}
