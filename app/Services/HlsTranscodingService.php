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
        $segmentPattern = 'segment_%03d.ts';
        $playlistFile = 'playlist.m3u8';

        file_put_contents($keyFile, $encryptionKey);
        file_put_contents($keyInfoFile, implode(PHP_EOL, [
            $keyUri,
            'enc.key',
            bin2hex($encryptionKey),
        ]) . PHP_EOL);

        $ffmpeg = config('video.ffmpeg_path', 'ffmpeg');
        $segmentDuration = config('video.hls_segment_duration', 10);
        $videoFilter = $this->buildHlsVideoFilter($outputDir);

        $commandParts = [
            FfmpegFilterHelper::shellArg($ffmpeg),
            '-y',
            '-i', FfmpegFilterHelper::shellArg($inputPath),
        ];

        if ($videoFilter) {
            $commandParts[] = '-vf';
            $commandParts[] = FfmpegFilterHelper::shellArg($videoFilter);
        }

        $commandParts = array_merge($commandParts, [
            '-c:v', 'libx264',
            '-c:a', 'aac',
            '-hls_time', (string) $segmentDuration,
            '-hls_playlist_type', 'vod',
            '-hls_key_info_file', FfmpegFilterHelper::shellArg('enc.keyinfo'),
            '-hls_segment_filename', FfmpegFilterHelper::shellArg($segmentPattern),
            FfmpegFilterHelper::shellArg($playlistFile),
        ]);

        $command = implode(' ', $commandParts);

        $output = [];
        $exitCode = 1;
        $this->runProcess($command, $outputDir, $output, $exitCode);

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

    protected function buildHlsVideoFilter(string $outputDir): ?string
    {
        if (!config('video.hls_burn_brand_watermark', true)) {
            return null;
        }

        $brandFile = $outputDir . DIRECTORY_SEPARATOR . 'brand.txt';
        file_put_contents($brandFile, config('video.brand_watermark_text', 'Mishmish Cake Academy'));

        return FfmpegFilterHelper::drawtextFromTextFile(
            $this->resolveFontFile(),
            $brandFile,
            20
        );
    }

    protected function resolveFontFile(): string
    {
        $configured = config('video.watermark_font');

        if ($configured) {
            $configured = str_replace('\\', '/', $configured);
            if (file_exists($configured)) {
                return $configured;
            }
        }

        foreach ([
            'C:/Windows/Fonts/segoeui.ttf',
            'C:/Windows/Fonts/arial.ttf',
            '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf',
        ] as $candidate) {
            if (file_exists($candidate)) {
                return $candidate;
            }
        }

        throw new RuntimeException('No watermark font file found. Set VIDEO_WATERMARK_FONT in .env');
    }

    protected function runProcess(string $command, string $workingDirectory, array &$output, int &$exitCode): void
    {
        $descriptors = [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ];

        $options = PHP_OS_FAMILY === 'Windows' ? ['bypass_shell' => true] : [];
        $process = proc_open($command, $descriptors, $pipes, $workingDirectory, null, $options);

        if (!is_resource($process)) {
            throw new RuntimeException('Unable to start ffmpeg process.');
        }

        fclose($pipes[0]);
        $stderr = stream_get_contents($pipes[2]) ?: '';
        $output = $stderr !== '' ? preg_split('/\r\n|\r|\n/', trim($stderr)) : [];
        fclose($pipes[1]);
        fclose($pipes[2]);
        $exitCode = proc_close($process);
    }
}
