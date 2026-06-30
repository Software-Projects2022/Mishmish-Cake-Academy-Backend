<?php

namespace App\Console\Commands;

use App\Models\Chapter;
use App\Services\GcsUploadService;
use Illuminate\Console\Command;

class DebugVideoPlayback extends Command
{
    protected $signature = 'video:playback-debug {chapter : Chapter ID}';

    protected $description = 'Show why a chapter would or would not get MP4 fallback playback';

    public function handle(GcsUploadService $gcs): int
    {
        $chapter = Chapter::with('video')->find($this->argument('chapter'));

        if (!$chapter) {
            $this->error('Chapter not found.');

            return 1;
        }

        $this->line('Chapter #' . $chapter->id . ': ' . $chapter->title);
        $this->line('video_id: ' . ($chapter->video_id ?: '(none — legacy video_url)'));
        $this->line('legacy video_url: ' . ($chapter->getRawOriginal('video_url') ?: '(none)'));
        $this->line('allow_mp4_fallback (config): ' . (config('video.allow_mp4_fallback') ? 'true' : 'false'));
        $this->newLine();

        if (!$chapter->video) {
            $this->warn('No video library record — playback uses legacy chapter.video_url path.');

            return 0;
        }

        $video = $chapter->video;
        $storagePath = $video->storagePath();

        $this->table(
            ['Field', 'Value'],
            [
                ['video.id', (string) $video->id],
                ['status', (string) $video->status],
                ['hls_status', (string) ($video->hls_status ?: '(null)')],
                ['path', $video->path ?: '(empty)'],
                ['url', $video->url ?: '(empty)'],
                ['storagePath()', $storagePath ?: '(empty)'],
                ['hls_path', $video->hls_path ?: '(empty)'],
            ]
        );

        if ($video->hls_status === 'ready' && $video->hls_path) {
            $this->info('Playback mode: HLS (ready)');
        } elseif (config('video.allow_mp4_fallback') && $storagePath) {
            $this->info('Playback mode: MP4 fallback');

            try {
                $signed = $gcs->generateSignedReadUrl($storagePath);
                $this->line('Signed URL OK (' . strlen($signed) . ' chars)');
                $this->line('GCS object exists: ' . ($gcs->fileExists($storagePath) ? 'yes' : 'NO'));
            } catch (\Throwable $e) {
                $this->error('Signed URL failed: ' . $e->getMessage());
            }
        } else {
            $this->warn('Playback mode: blocked (processing message, no src)');

            if (!config('video.allow_mp4_fallback')) {
                $this->line('- VIDEO_ALLOW_MP4_FALLBACK is false (or cached config). Run: php artisan config:clear && php artisan config:cache');
            }

            if (!$storagePath) {
                $this->line('- No GCS path on video record (path/url missing).');
            }
        }

        return 0;
    }
}
