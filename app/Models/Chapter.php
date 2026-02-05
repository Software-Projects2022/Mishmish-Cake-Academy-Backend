<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    /**
     * Get video URL (from video relation or legacy video_url field).
     */
    public function getVideoUrlAttribute($value)
    {
        // If there's a related video, use its URL
        if ($this->video) {
            return $this->video->url;
        }
        // Fallback to legacy video_url field
        return $value;
    }
}
