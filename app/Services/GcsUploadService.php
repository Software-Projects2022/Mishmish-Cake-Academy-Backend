<?php

namespace App\Services;

use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\Str;

class GcsUploadService
{
    protected StorageClient $storage;
    protected string $bucketName;
    protected $bucket;

    public function __construct()
    {
        $this->bucketName = config('filesystems.disks.gcs.bucket');

        // Get key file path and convert to absolute path if relative
        $keyFile = config('filesystems.disks.gcs.key_file');
        if ($keyFile && !str_starts_with($keyFile, '/') && !preg_match('/^[A-Z]:/i', $keyFile)) {
            $keyFile = base_path($keyFile);
        }

        $this->storage = new StorageClient([
            'keyFilePath' => $keyFile,
            'projectId' => config('filesystems.disks.gcs.project_id'),
        ]);

        $this->bucket = $this->storage->bucket($this->bucketName);
    }

    /**
     * Generate a signed URL for uploading a file directly to GCS.
     *
     * @param string $fileName Original file name
     * @param string $mimeType File MIME type
     * @param int $expiresInMinutes URL expiration time
     * @return array Contains signedUrl, path, and publicUrl
     */
    public function generateSignedUploadUrl(
        string $fileName,
        string $mimeType,
        int $expiresInMinutes = 60
    ): array {
        // Generate unique path
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $uniqueName = Str::uuid() . '.' . $extension;
        $path = 'videos/' . date('Y/m/d') . '/' . $uniqueName;

        // Create the object reference
        $object = $this->bucket->object($path);

        // Generate signed URL for upload (PUT request)
        $signedUrl = $object->signedUrl(
            new \DateTime('+' . $expiresInMinutes . ' minutes'),
            [
                'method' => 'PUT',
                'contentType' => $mimeType,
                'version' => 'v4',
            ]
        );

        // Public URL (after upload)
        $publicUrl = sprintf(
            'https://storage.googleapis.com/%s/%s',
            $this->bucketName,
            $path
        );

        return [
            'signed_url' => $signedUrl,
            'path' => $path,
            'public_url' => $publicUrl,
            'expires_in' => $expiresInMinutes * 60, // seconds
        ];
    }

    /**
     * Generate a signed URL for resumable upload (for large files).
     *
     * @param string $fileName Original file name
     * @param string $mimeType File MIME type
     * @return array Contains resumable upload URI and metadata
     */
    public function generateResumableUploadUrl(
        string $fileName,
        string $mimeType
    ): array {
        // Generate unique path
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $uniqueName = Str::uuid() . '.' . $extension;
        $path = 'videos/' . date('Y/m/d') . '/' . $uniqueName;

        // Create resumable upload session
        $object = $this->bucket->object($path);

        // For resumable uploads, we need to use the beginSignedUploadSession method
        $uploader = $this->bucket->getResumableUploader(
            '', // Empty content, client will upload
            [
                'name' => $path,
                'metadata' => [
                    'contentType' => $mimeType,
                ],
            ]
        );

        // Get the resumable upload URI
        $resumeUri = $uploader->getResumeUri();

        // Public URL (after upload)
        $publicUrl = sprintf(
            'https://storage.googleapis.com/%s/%s',
            $this->bucketName,
            $path
        );

        return [
            'resumable_uri' => $resumeUri,
            'path' => $path,
            'public_url' => $publicUrl,
        ];
    }

    /**
     * Delete a file from GCS.
     *
     * @param string $path File path in bucket
     * @return bool
     */
    public function deleteFile(string $path): bool
    {
        try {
            $object = $this->bucket->object($path);
            $object->delete();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Delete all objects under a GCS prefix.
     */
    public function deleteByPrefix(string $prefix): void
    {
        $objects = $this->bucket->objects(['prefix' => rtrim($prefix, '/') . '/']);

        foreach ($objects as $object) {
            $object->delete();
        }
    }

    /**
     * Check if a file exists in GCS.
     *
     * @param string $path File path in bucket
     * @return bool
     */
    public function fileExists(string $path): bool
    {
        try {
            return $this->bucket->object($path)->exists();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Extract the object path from a public GCS URL for this bucket.
     */
    public function pathFromPublicUrl(string $url): ?string
    {
        $prefix = 'https://storage.googleapis.com/' . $this->bucketName . '/';

        if (!str_starts_with($url, $prefix)) {
            return null;
        }

        $path = substr($url, strlen($prefix));

        return $path !== '' ? $path : null;
    }

    /**
     * Generate a signed URL for reading a private file from GCS.
     */
    public function generateSignedReadUrl(
        string $path,
        ?int $expiresInMinutes = null
    ): string {
        $expiresInMinutes ??= config('video.signed_url_expiry_minutes', 30);

        $object = $this->bucket->object($path);

        return $object->signedUrl(
            new \DateTime('+' . $expiresInMinutes . ' minutes'),
            [
                'method' => 'GET',
                'version' => 'v4',
            ]
        );
    }

    /**
     * Download a GCS object to a local file with retries and HTTP fallback.
     */
    public function downloadToLocal(string $path, string $localPath, int $maxAttempts = 3): void
    {
        $directory = dirname($localPath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $lastException = null;

        for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
            try {
                $this->bucket->object($path)->downloadToFile($localPath);

                if (is_file($localPath) && filesize($localPath) > 0) {
                    return;
                }

                throw new \RuntimeException('Downloaded file is empty.');
            } catch (\Throwable $e) {
                $lastException = $e;

                if (is_file($localPath)) {
                    @unlink($localPath);
                }

                if ($attempt < $maxAttempts) {
                    sleep($attempt * 3);
                }
            }
        }

        try {
            $this->downloadToLocalViaSignedUrl($path, $localPath);
        } catch (\Throwable $httpException) {
            throw $lastException ?? $httpException;
        }
    }

    protected function downloadToLocalViaSignedUrl(string $path, string $localPath): void
    {
        $url = $this->generateSignedReadUrl($path, 30);

        $response = \Illuminate\Support\Facades\Http::timeout(600)
            ->retry(3, 3000)
            ->withOptions(['stream' => true])
            ->get($url);

        if (!$response->successful()) {
            throw new \RuntimeException('HTTP download failed with status ' . $response->status());
        }

        $handle = fopen($localPath, 'wb');
        if ($handle === false) {
            throw new \RuntimeException('Unable to open local file for writing.');
        }

        $body = $response->toPsrResponse()->getBody();
        while (!$body->eof()) {
            fwrite($handle, $body->read(1024 * 1024));
        }

        fclose($handle);

        if (!is_file($localPath) || filesize($localPath) === 0) {
            throw new \RuntimeException('HTTP download produced an empty file.');
        }
    }

    /**
     * Get object contents as a string.
     */
    public function getObjectContents(string $path): string
    {
        return $this->bucket->object($path)->downloadAsString();
    }

    /**
     * Open a read stream for a GCS object.
     *
     * @return resource|null
     */
    public function openReadStream(string $path)
    {
        $stream = $this->bucket->object($path)->downloadAsStream();

        return $stream->detach();
    }

    /**
     * Upload a local file to GCS.
     */
    public function uploadFromLocal(
        string $localPath,
        string $gcsPath,
        ?string $contentType = null,
        int $maxAttempts = 3
    ): void {
        $lastException = null;

        for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
            try {
                $options = ['name' => $gcsPath];

                if ($contentType) {
                    $options['metadata'] = ['contentType' => $contentType];
                }

                $this->bucket->upload(fopen($localPath, 'r'), $options);

                return;
            } catch (\Throwable $e) {
                $lastException = $e;

                if ($attempt < $maxAttempts) {
                    sleep($attempt * 3);
                }
            }
        }

        throw $lastException ?? new \RuntimeException('GCS upload failed.');
    }

    /**
     * Upload all files from a local directory to a GCS prefix.
     */
    public function uploadDirectory(string $localDir, string $gcsPrefix): void
    {
        $files = glob(rtrim($localDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . '*');

        foreach ($files as $file) {
            if (!is_file($file)) {
                continue;
            }

            $filename = basename($file);
            $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            if (!in_array($extension, ['m3u8', 'ts'], true)) {
                continue;
            }

            $gcsPath = rtrim($gcsPrefix, '/') . '/' . $filename;
            $contentType = $this->guessContentType($filename);

            $this->uploadFromLocal($file, $gcsPath, $contentType);
        }
    }

    protected function guessContentType(string $filename): ?string
    {
        return match (strtolower(pathinfo($filename, PATHINFO_EXTENSION))) {
            'm3u8' => 'application/vnd.apple.mpegurl',
            'ts' => 'video/mp2t',
            'mp4' => 'video/mp4',
            default => null,
        };
    }
}
