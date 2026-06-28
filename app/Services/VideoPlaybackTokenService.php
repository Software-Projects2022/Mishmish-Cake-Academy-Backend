<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class VideoPlaybackTokenService
{
    public function generate(int $clientId, int $videoId): string
    {
        $expiresAt = now()->addMinutes($this->ttlMinutes())->timestamp;
        $payload = "{$clientId}:{$videoId}:{$expiresAt}";
        $signature = $this->sign($payload);

        return $this->base64UrlEncode("{$payload}:{$signature}");
    }

    public function validate(?string $token, int $clientId, int $videoId): bool
    {
        if ($token === null || $token === '') {
            return false;
        }

        $decoded = $this->base64UrlDecode($token);

        if ($decoded === null) {
            return false;
        }

        $parts = explode(':', $decoded, 4);

        if (count($parts) !== 4) {
            return false;
        }

        [$tokenClientId, $tokenVideoId, $expiresAt, $signature] = $parts;

        if ((int) $tokenClientId !== $clientId || (int) $tokenVideoId !== $videoId) {
            return false;
        }

        if ((int) $expiresAt < now()->timestamp) {
            return false;
        }

        $payload = "{$tokenClientId}:{$tokenVideoId}:{$expiresAt}";
        $expected = $this->sign($payload);

        if (!hash_equals($expected, $signature)) {
            return false;
        }

        return true;
    }

    public function appendToUrl(string $url, string $token): string
    {
        $separator = str_contains($url, '?') ? '&' : '?';

        return $url . $separator . 'token=' . rawurlencode($token);
    }

    public function logKeyAccess(
        string $event,
        int $clientId,
        int $videoId,
        int $chapterId,
        ?string $reason = null
    ): void {
        Log::channel('single')->info('video_key_access', [
            'event' => $event,
            'client_id' => $clientId,
            'video_id' => $videoId,
            'chapter_id' => $chapterId,
            'reason' => $reason,
            'ip' => request()->ip(),
            'user_agent' => substr((string) request()->userAgent(), 0, 500),
        ]);
    }

    protected function ttlMinutes(): int
    {
        return (int) config('video.key_token_ttl_minutes', 30);
    }

    protected function sign(string $payload): string
    {
        return hash_hmac('sha256', $payload, (string) config('app.key'));
    }

    protected function base64UrlEncode(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }

    protected function base64UrlDecode(string $value): ?string
    {
        $padded = strtr($value, '-_', '+/');
        $remainder = strlen($padded) % 4;

        if ($remainder > 0) {
            $padded .= str_repeat('=', 4 - $remainder);
        }

        $decoded = base64_decode($padded, true);

        return $decoded === false ? null : $decoded;
    }
}
