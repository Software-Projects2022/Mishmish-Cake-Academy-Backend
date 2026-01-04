<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }
    public function getTotalDurationAttribute()
    {
        return $this->chapters->sum('duration')??0;
    }
    public function getTotalChaptersAttribute()
    {
        return $this->chapters->count()??0;
    }
}
