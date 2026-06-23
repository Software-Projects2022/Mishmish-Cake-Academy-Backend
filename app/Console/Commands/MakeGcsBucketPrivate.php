<?php

namespace App\Console\Commands;

use Google\Cloud\Storage\StorageClient;
use Illuminate\Console\Command;

class MakeGcsBucketPrivate extends Command
{
    protected $signature = 'video:make-bucket-private';

    protected $description = 'Remove public access from the GCS bucket (required for video protection)';

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

        try {
            $storage = new StorageClient([
                'projectId' => $projectId,
                'keyFilePath' => $keyFile,
            ]);

            $bucket = $storage->bucket($bucketName);
            $policy = $bucket->iam()->policy();

            $bindings = $policy['bindings'] ?? [];
            $updatedBindings = [];
            $removed = false;

            foreach ($bindings as $binding) {
                $members = $binding['members'] ?? [];
                $filteredMembers = array_values(array_filter($members, function ($member) use (&$removed) {
                    if ($member === 'allUsers' || $member === 'allAuthenticatedUsers') {
                        $removed = true;
                        return false;
                    }

                    return true;
                }));

                if (!empty($filteredMembers)) {
                    $binding['members'] = $filteredMembers;
                    $updatedBindings[] = $binding;
                }
            }

            if (!$removed) {
                $this->info("Bucket {$bucketName} already has no public access bindings.");
                return 0;
            }

            $policy['bindings'] = $updatedBindings;
            $bucket->iam()->setPolicy($policy);

            $this->info("Successfully removed public access from bucket: {$bucketName}");
            $this->warn('Videos are now only accessible via signed URLs from the application.');

        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
