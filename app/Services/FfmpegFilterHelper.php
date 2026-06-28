<?php

namespace App\Services;

class FfmpegFilterHelper
{
    /**
     * Escape a filesystem path for use inside an ffmpeg drawtext filter on Windows/Linux.
     */
    public static function escapePath(string $path): string
    {
        $path = str_replace('\\', '/', $path);

        if (preg_match('/^[A-Za-z]:/', $path)) {
            $path = substr($path, 0, 1) . '\\:' . substr($path, 2);
        }

        return str_replace("'", "\\'", $path);
    }

    public static function drawtextFromTextFile(
        string $fontPath,
        string $textFilePath,
        int $fontSize = 22,
        string $extraOptions = ''
    ): string {
        $font = self::escapePath($fontPath);
        $textFile = self::escapePath($textFilePath);

        return sprintf(
            "drawtext=fontfile='%s':textfile='%s':reload=1:fontsize=%d:fontcolor=white@0.35:borderw=1:bordercolor=black@0.25:x=mod(n*48\\,w-text_w):y=mod(n*32\\,h-text_h)%s",
            $font,
            $textFile,
            $fontSize,
            $extraOptions
        );
    }

    /**
     * Quote a command argument for ffmpeg on Windows without breaking %03d patterns.
     */
    public static function shellArg(string $value): string
    {
        if (PHP_OS_FAMILY === 'Windows' && str_contains($value, '%')) {
            if (str_contains($value, ' ') || str_contains($value, "\t")) {
                return '"' . str_replace('"', '', $value) . '"';
            }

            return $value;
        }

        return escapeshellarg($value);
    }
}
