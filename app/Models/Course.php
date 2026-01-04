<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function courseCategory()
    {
        return $this->belongsTo(CourseCategory::class, 'course_category_id');
    }
    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'instructor_id');
    }
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
    public function bookings()
    {
        return $this->hasMany(CourseBooking::class);
    }


}
