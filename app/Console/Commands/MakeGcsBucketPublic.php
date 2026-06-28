<?php

namespace App\Console\Commands;

use Google\Cloud\Storage\StorageClient;
use Illuminate\Console\Command;

class MakeGcsBucketPublic extends Command
{
    protected $signature = 'video:make-bucket-public
                            {--force : Skip confirmation prompt}';

    protected $description = 'Restore public read access on the GCS bucket (reverses video:make-bucket-private)';

    public function handle(): int
    {
        $projectId = config('filesystems.disks.gcs.project_id');
        $bucketName = config('filesystems.disks.gcs.bucket');
        $keyFile = config('filesystems.disks.gcs.key_file');

        if (!$projectId || !$bucketName || !$keyFile) {
            $this->error('Configure GCS settings in .env first (GCS_PROJECT_ID, GCS_BUCKET, GCS_KEY_FILE).');
            return 1;
        }

        if (!str_starts_with($keyFile, '/') && !preg_match('/^[A-Z]:/i', $keyFile)) {
            $keyFile = base_path($keyFile);
        }

        if (!file_exists($keyFile)) {
            $this->error("Key file not found at: {$keyFile}");
            return 1;
        }

        if (!$this->option('force')) {
            $this->warn("This will grant public read (allUsers) on bucket: {$bucketName}");
            $this->warn('Only run this if you intentionally want direct public video URLs again.');

            if (!$this->confirm('Continue?', false)) {
                $this->info('Cancelled.');
                return 0;
            }
        }

        try {
            $storage = new StorageClient([
                'projectId' => $projectId,
                'keyFilePath' => $keyFile,
            ]);

            $bucket = $storage->bucket($bucketName);
            $policy = $bucket->iam()->policy();
            $bindings = $policy['bindings'] ?? [];
            $publicMember = 'allUsers';
            $publicRole = 'roles/storage.objectViewer';
            $alreadyPublic = false;

            foreach ($bindings as $binding) {
                if (($binding['role'] ?? '') === $publicRole
                    && in_array($publicMember, $binding['members'] ?? [], true)) {
                    $alreadyPublic = true;
                    break;
                }
            }

            if ($alreadyPublic) {
                $this->info("Bucket {$bucketName} already allows public read (objectViewer).");
                return 0;
            }

            $bindings[] = [
                'role' => $publicRole,
                'members' => [$publicMember],
            ];

            $policy['bindings'] = $bindings;
            $bucket->iam()->setPolicy($policy);

            $this->info("Public read restored on bucket: {$bucketName}");
            $this->line('Direct URLs like https://storage.googleapis.com/' . $bucketName . '/... should work again.');

        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
