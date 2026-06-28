<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Google\Cloud\Storage\StorageClient;

class ConfigureGcsCors extends Command
{
    protected $signature = 'video:configure-cors';

    protected $description = 'Configure CORS on the GCS bucket for browser uploads and HLS playback';

    public function handle(): int
    {
        $projectId = config('filesystems.disks.gcs.project_id');
        $bucketName = config('filesystems.disks.gcs.bucket');
        $keyFile = config('filesystems.disks.gcs.key_file');

        if (!$projectId || !$bucketName || !$keyFile) {
            $this->error('Configure GCS settings in .env first (GCS_PROJECT_ID, GCS_BUCKET, GCS_KEY_FILE).');
            return 1;
        }

        if (!file_exists($keyFile) && !file_exists(base_path($keyFile))) {
            $this->error("Key file not found at: $keyFile");
            return 1;
        }

        $origins = config('video.cors_origins', []);

        if ($origins === []) {
            $origins = array_values(array_unique(array_filter([
                rtrim((string) config('app.url'), '/'),
                'http://localhost',
                'http://127.0.0.1',
            ])));
        }

        if ($origins === []) {
            $origins = ['*'];
        }

        try {
            $storage = new StorageClient([
                'projectId' => $projectId,
                'keyFilePath' => $keyFile,
            ]);

            $bucket = $storage->bucket($bucketName);

            $cors = [
                [
                    'method' => ['GET', 'HEAD', 'OPTIONS'],
                    'origin' => $origins,
                    'responseHeader' => [
                        'Content-Type',
                        'Content-Length',
                        'Content-Range',
                        'Accept-Ranges',
                        'Range',
                    ],
                    'maxAgeSeconds' => 3600,
                ],
                [
                    'method' => ['GET', 'PUT', 'POST', 'OPTIONS'],
                    'origin' => $origins,
                    'responseHeader' => ['Content-Type', 'x-goog-resumable'],
                    'maxAgeSeconds' => 3600,
                ],
            ];

            $bucket->update(['cors' => $cors]);

            $this->info("CORS configured for bucket: {$bucketName}");
            $this->line('Origins: ' . implode(', ', $origins));

        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
