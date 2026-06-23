<?php

namespace App\Console\Commands;

use App\Jobs\ProcessVideoToHls;
use App\Models\Video;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Console\Command;

class ProcessVideoHls extends Command
{
    protected $signature = 'video:process-hls {video? : Video ID to process (optional, processes all pending)}';

    protected $description = 'Transcode uploaded videos to encrypted HLS format';

    public function handle(): int
    {
        $videoId = $this->argument('video');

        if ($videoId) {
            $video = Video::find($videoId);

            if (!$video) {
                $this->error("Video #{$videoId} not found.");
                return 1;
            }

            if ($video->status !== 'completed' || !$video->path) {
                $this->error('Video must be uploaded and completed before HLS processing.');
                return 1;
            }

            ProcessVideoToHls::dispatch($video);
            $this->info("HLS processing queued for video #{$video->id}.");

            return 0;
        }

        $videos = Video::query()
            ->where('status', 'completed')
            ->whereNotNull('path')
            ->where(function ($query) {
                $query->whereNull('hls_status')
                    ->orWhereIn('hls_status', ['pending', 'failed']);
            })
            ->get();

        if ($videos->isEmpty()) {
            $this->info('No videos pending HLS processing.');
            return 0;
        }

        foreach ($videos as $video) {
            $video->update(['hls_status' => 'pending']);
            ProcessVideoToHls::dispatch($video);
            $this->line("Queued video #{$video->id} ({$video->name})");
        }

        $this->info("Queued {$videos->count()} video(s) for HLS processing.");

        return 0;
    }
}
