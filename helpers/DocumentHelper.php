<?php

namespace Helpers;

use Mpdf\Mpdf;

class DocumentHelper {

    public static function generatePDF($html, $savePath = null, $fileName = null, $stream = false) {
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4'
        ]);

        $mpdf->WriteHTML($html);

        if ($stream) {
            // Force download in browser
            $mpdf->Output($fileName ?? 'document.pdf', 'D');
        } elseif ($savePath && $fileName) {
            // Save on server
            $mpdf->Output($savePath . $fileName, \Mpdf\Output\Destination::FILE);
            return $fileName;
        } else {
            // Return raw string content (optional use case)
            return $mpdf->Output('', 'S');
        }
    }

    public static function generateFromTemplate($templatePath, $data = [], $savePath = null, $fileName = null, $stream = false) {
        if (!file_exists($templatePath)) {
            throw new \InvalidArgumentException("Missing PDF template: $templatePath");
        }        

        $html = file_get_contents($templatePath);

        // Replace {{key}} with $data['key']
        foreach ($data as $key => $value) {
            $html = str_replace('{{' . $key . '}}', $value, $html);
        }

        return self::generatePDF($html, $savePath, $fileName, $stream);
    }
}
