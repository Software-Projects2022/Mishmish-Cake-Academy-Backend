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
     * Legacy accessor — does not expose direct GCS URLs when using the video library.
     */
    public function getVideoUrlAttribute($value)
    {
        if ($this->video_id) {
            return null;
        }

        return $value;
    }
}
