<?php

namespace App\Http\Controllers\frontend\mainPortal;

use App\Http\Controllers\Controller;
use App\Models\SystemAbout;
use App\Models\SystemFAQ;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function about()
    {
        $about = SystemAbout::where('is_deleted', 0)->first();
        $faqs = SystemFAQ::where('is_deleted', 0)
        ->where('is_published', 1)
        ->latest()
        ->take(2)
        ->get();
        return view('frontend.mainPortal.about', compact('about', 'faqs'));
    }
}
