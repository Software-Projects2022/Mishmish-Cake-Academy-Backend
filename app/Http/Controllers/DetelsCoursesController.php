<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class DetelsCoursesController extends Controller
{
    //
    public function index($id)
    {
        $course = Course::find($id);
        return view('detels_courses', compact('course'));
    }
    public function book($id)
    {

        $client = auth()->guard('client')->user();

        $client->bookings()->updateOrCreate([
            'course_id' => $id,
            'client_id' => $client->id,
        ], [
            'status' => 'pending',
        ]);
        return redirect()->back()->with('success', 'تم تسجيل الدورة بنجاح');
    }

    public function show($id)
    {
        $course = Course::find($id);
        $client = auth()->guard('client')->user();
        if ($client->bookings()->where('course_id', $id)->where('status', 'approved')->exists()) {
            $booking = $client->bookings()->where('course_id', $id)->where('status', 'approved')->first();
            return view('profile.course-show', compact('course','booking'));
        } else {
            return redirect()->route('dashboard')->with('error', 'لم تتم تسجيلك لهذه الدورة');
        }
    }
}
