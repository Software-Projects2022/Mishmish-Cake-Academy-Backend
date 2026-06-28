<?php

namespace App\Services;

use App\Models\Video;
use Illuminate\Support\Facades\Cache;

class HlsPlaylistService
{
    public const KEY_URI_PLACEHOLDER = '__VIDEO_KEY_URI__';

    public function __construct(
        protected GcsUploadService $gcsService
    ) {
    }

    /**
     * Cached playlist with signed segment URLs; key URI is a placeholder for per-user injection.
     */
    public function getSignedPlaylistBody(Video $video): string
    {
        $cacheKey = 'hls:playlist:signed:' . $video->id;
        $cacheMinutes = (int) config('video.playlist_cache_minutes', 55);

        return Cache::remember($cacheKey, now()->addMinutes($cacheMinutes), function () use ($video) {
            return $this->buildSignedPlaylistBody($video);
        });
    }

    public function injectKeyUri(string $playlistBody, string $keyUrl): string
    {
        if (str_contains($playlistBody, self::KEY_URI_PLACEHOLDER)) {
            return str_replace(self::KEY_URI_PLACEHOLDER, $keyUrl, $playlistBody);
        }

        $lines = preg_split('/\r\n|\r|\n/', $playlistBody) ?: [];
        $rewritten = [];

        foreach ($lines as $line) {
            $trimmed = trim($line);

            if (str_starts_with($trimmed, '#EXT-X-KEY:')) {
                $rewritten[] = preg_replace(
                    '/URI="[^"]*"/',
                    'URI="' . $keyUrl . '"',
                    $trimmed
                );
                continue;
            }

            $rewritten[] = $line;
        }

        return implode(PHP_EOL, $rewritten);
    }

    public function forgetCache(Video $video): void
    {
        Cache::forget('hls:playlist:signed:' . $video->id);
    }

    protected function buildSignedPlaylistBody(Video $video): string
    {
        $playlist = $this->gcsService->getObjectContents($video->hls_path);
        $hlsDir = dirname($video->hls_path);
        $segmentExpiry = (int) config('video.segment_signed_url_expiry_minutes', 120);
        $lines = preg_split('/\r\n|\r|\n/', $playlist) ?: [];
        $rewritten = [];

        foreach ($lines as $line) {
            $trimmed = trim($line);

            if ($trimmed === '') {
                $rewritten[] = $line;
                continue;
            }

            if (str_starts_with($trimmed, '#EXT-X-KEY:')) {
                $rewritten[] = preg_replace(
                    '/URI="[^"]*"/',
                    'URI="' . self::KEY_URI_PLACEHOLDER . '"',
                    $trimmed
                );
                continue;
            }

            if (!str_starts_with($trimmed, '#') && str_ends_with($trimmed, '.ts')) {
                $segmentPath = $hlsDir . '/' . basename($trimmed);
                $rewritten[] = $this->gcsService->generateSignedReadUrl($segmentPath, $segmentExpiry);
                continue;
            }

            $rewritten[] = $line;
        }

        return implode(PHP_EOL, $rewritten);
    }
}
