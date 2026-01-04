<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);
        Newsletter::create($request->all());
        return redirect()->back()->with('success', 'تم الاشتراك بنجاح');
    }
}
