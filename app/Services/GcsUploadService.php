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
}
