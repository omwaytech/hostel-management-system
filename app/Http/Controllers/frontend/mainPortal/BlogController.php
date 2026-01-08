<?php

namespace App\Http\Controllers\frontend\mainPortal;

use App\Http\Controllers\Controller;
use App\Models\SystemBlog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function blog()
    {
        $blogs = SystemBlog::where('is_deleted', 0)
        ->where('is_published', 1)
        ->orderBy('created_at', 'desc')
        ->paginate(8);
        return view('frontend.mainPortal.blog', compact('blogs'));
    }
    public function blogDetail($slug)
    {
        $blogs = SystemBlog::where('is_deleted', 0)
        ->where('is_published', 1)->get();
        $blogDetail = SystemBlog::whereSlug($slug)->first();
        return view('frontend.mainPortal.blogDetail', compact('blogs','blogDetail'));
    }
}
