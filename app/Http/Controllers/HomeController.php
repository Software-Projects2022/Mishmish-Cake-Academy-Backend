<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Course;
use App\Models\Design;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    //
    public function index()
    {


        // try {
        //     Storage::disk('bunny')->put('test.txt', 'Hello BunnyCDN');
        //     echo "Success!";
        // } catch (\Exception $e) {
        //     echo "Error: " . $e->getMessage();
        // }


        $sliders = Slider::all();
        $pages_top = Page::where('type', 'home')->take(3)->orderBy('id', 'asc')->get();
        $pages_bottom = Page::where('type', 'home')->take(2)->orderBy('id', 'desc')->get();
        $courses = Course::whereHas('lessons.chapters')->with('lessons.chapters')->take(3)->orderBy('created_at', 'desc')->get();
        $designs = Design::take(4)->orderBy('created_at', 'desc')->get();

        return view('index', compact('sliders', 'pages_top', 'pages_bottom', 'courses', 'designs'));
    }
}
