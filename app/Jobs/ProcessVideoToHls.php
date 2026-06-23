<?php

namespace App\Jobs;

use App\Models\Video;
use App\Services\GcsUploadService;
use App\Services\HlsTranscodingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class ProcessVideoToHls implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 3600;

    public function __construct(public Video $video)
    {
    }

    public function handle(
        GcsUploadService $gcsService,
        HlsTranscodingService $hlsService
    ): void {
        $video = $this->video->fresh();

        if (!$video || !$video->path) {
            return;
        }

        $video->update([
            'hls_status' => 'processing',
            'hls_error' => null,
        ]);

        $tempDir = $hlsService->makeTempDirectory($video->id);
        $sourcePath = $tempDir . DIRECTORY_SEPARATOR . 'source.mp4';

        try {
            $gcsService->downloadToLocal($video->path, $sourcePath);

            $keyUri = 'https://placeholder.local/hls-key';
            $result = $hlsService->transcodeToHls($sourcePath, $tempDir . DIRECTORY_SEPARATOR . 'hls', $keyUri);

            $hlsPrefix = 'videos/hls/' . $video->id;
            $gcsService->uploadDirectory($result['output_dir'], $hlsPrefix);

            $video->update([
                'hls_path' => $hlsPrefix . '/playlist.m3u8',
                'encryption_key' => Crypt::encryptString(base64_encode($result['encryption_key'])),
                'hls_status' => 'ready',
                'hls_error' => null,
            ]);
        } catch (\Throwable $e) {
            Log::error('HLS processing failed for video ' . $video->id . ': ' . $e->getMessage());

            $video->update([
                'hls_status' => 'failed',
                'hls_error' => $e->getMessage(),
            ]);

            throw $e;
        } finally {
            $hlsService->cleanupDirectory($tempDir);
        }
    }
}
