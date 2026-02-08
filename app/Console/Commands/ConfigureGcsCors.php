<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Google\Cloud\Storage\StorageClient;

class ConfigureGcsCors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'video:configure-cors';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Configure CORS for Google Cloud Storage Bucket to allow direct uploads';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $projectId = config('filesystems.disks.gcs.project_id');
        $bucketName = config('filesystems.disks.gcs.bucket');
        $keyFile = config('filesystems.disks.gcs.key_file');

        if (!$projectId || !$bucketName || !$keyFile) {
            $this->error('Please configure GCS settings in .env file first (GCS_PROJECT_ID, GCS_BUCKET, GCS_KEY_FILE).');
            return 1;
        }

        if (!file_exists($keyFile) && !file_exists(base_path($keyFile))) {
             $this->error("Key file not found at: $keyFile");
             return 1;
        }

        try {
            $storage = new StorageClient([
                'projectId' => $projectId,
                'keyFilePath' => $keyFile,
            ]);

            $bucket = $storage->bucket($bucketName);

            $cors = [
                [
                    'method' => ['GET', 'PUT', 'OPTIONS'],
                    'origin' => ['*'], // يمكنك تغيير * إلى رابط موقعك للحماية
                    'responseHeader' => ['Content-Type', 'x-goog-resumable'],
                    'maxAgeSeconds' => 3600,
                ],
            ];

            $bucket->update(['cors' => $cors]);

            $this->info("Successfully configured CORS for bucket: $bucketName");
            $this->info("You can now upload files directly from the browser.");

        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
