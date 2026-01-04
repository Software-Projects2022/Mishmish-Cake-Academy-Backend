<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    //
    public function index()
    {
        $page = Page::where('id', '7')->first();
        return view('page', compact('page'));
    }

    public function termsAndConditions()
    {
        $page = Page::where('id', '8')->first();
        return view('page', compact('page'));
    }

    public function privacyPolicy()
    {
        $page = Page::where('id', '9')->first();
        return view('page', compact('page'));
    }
}
