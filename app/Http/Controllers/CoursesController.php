<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseCategory;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    //
    public function index()
    {
        $courses = Course::whereHas('lessons.chapters')->with('lessons.chapters')->orderBy('created_at', 'desc')->get();
        $course_categories = CourseCategory::all();
        return view('courses', compact('courses', 'course_categories'));
    }
}
