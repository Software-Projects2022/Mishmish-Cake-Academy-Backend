<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use RuntimeException;

class HlsTranscodingService
{
    public function transcodeToHls(string $inputPath, string $outputDir, string $keyUri): array
    {
        if (!is_file($inputPath)) {
            throw new RuntimeException('Source video file not found for transcoding.');
        }

        File::ensureDirectoryExists($outputDir);

        $encryptionKey = random_bytes(16);
        $keyFile = $outputDir . DIRECTORY_SEPARATOR . 'enc.key';
        $keyInfoFile = $outputDir . DIRECTORY_SEPARATOR . 'enc.keyinfo';
        $playlistPath = $outputDir . DIRECTORY_SEPARATOR . 'playlist.m3u8';
        $segmentPattern = $outputDir . DIRECTORY_SEPARATOR . 'segment_%03d.ts';

        file_put_contents($keyFile, $encryptionKey);
        file_put_contents($keyInfoFile, implode(PHP_EOL, [
            $keyUri,
            $keyFile,
            bin2hex($encryptionKey),
        ]) . PHP_EOL);

        $ffmpeg = config('video.ffmpeg_path', 'ffmpeg');
        $segmentDuration = config('video.hls_segment_duration', 10);

        $command = sprintf(
            '%s -y -i %s -c:v libx264 -c:a aac -hls_time %d -hls_playlist_type vod -hls_key_info_file %s -hls_segment_filename %s %s 2>&1',
            escapeshellarg($ffmpeg),
            escapeshellarg($inputPath),
            $segmentDuration,
            escapeshellarg($keyInfoFile),
            escapeshellarg($segmentPattern),
            escapeshellarg($playlistPath)
        );

        exec($command, $output, $exitCode);

        if ($exitCode !== 0 || !is_file($playlistPath)) {
            throw new RuntimeException('FFmpeg transcoding failed: ' . implode(PHP_EOL, $output));
        }

        return [
            'encryption_key' => $encryptionKey,
            'playlist_path' => $playlistPath,
            'output_dir' => $outputDir,
        ];
    }

    public function makeTempDirectory(int $videoId): string
    {
        $dir = storage_path('app/temp/hls/' . $videoId . '-' . Str::uuid());

        File::ensureDirectoryExists($dir);

        return $dir;
    }

    public function cleanupDirectory(string $directory): void
    {
        if (is_dir($directory)) {
            File::deleteDirectory($directory);
        }
    }
}
