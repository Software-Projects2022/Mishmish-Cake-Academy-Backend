<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $hidden = [
        'encryption_key',
    ];

    protected $casts = [
        'size' => 'integer',
        'duration' => 'integer',
    ];

    public function isHlsReady(): bool
    {
        return $this->hls_status === 'ready' && !empty($this->hls_path);
    }

    public function isProcessingHls(): bool
    {
        return in_array($this->hls_status, ['pending', 'processing'], true);
    }

    /**
     * GCS object path for the source MP4 (path column, or parsed from public url).
     */
    public function storagePath(): ?string
    {
        $path = trim((string) $this->path);
        if ($path !== '') {
            return $path;
        }

        $url = trim((string) $this->url);
        if ($url === '') {
            return null;
        }

        $prefix = 'https://storage.googleapis.com/';
        if (!str_starts_with($url, $prefix)) {
            return null;
        }

        $withoutScheme = substr($url, strlen('https://storage.googleapis.com/'));
        $slash = strpos($withoutScheme, '/');

        return $slash !== false ? substr($withoutScheme, $slash + 1) : null;
    }

    /**
     * Get all chapters that use this video.
     */
    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    /**
     * Get formatted file size.
     */
    public function getFormattedSizeAttribute(): string
    {
        $bytes = $this->size;
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        return $bytes . ' bytes';
    }

    /**
     * Get formatted duration.
     */
    public function getFormattedDurationAttribute(): string
    {
        $seconds = $this->duration;
        if (!$seconds) {
            return '--:--';
        }

        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $secs = $seconds % 60;

        if ($hours > 0) {
            return sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
        }
        return sprintf('%02d:%02d', $minutes, $secs);
    }
}
