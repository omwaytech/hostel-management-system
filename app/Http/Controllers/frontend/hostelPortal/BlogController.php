<?php

namespace App\Http\Controllers\frontend\hostelPortal;

use App\Http\Controllers\Controller;
use App\Models\NewsAndBlog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function blog()
    {
        $hostel = session('active_hostel');
        $newsAndBlogs = NewsAndBlog::where('hostel_id', $hostel->id)
        ->where('is_deleted', 0)
        ->where('is_published', 1)
        ->paginate(6);
        return view('frontend.hostelPortal.blog', compact('hostel', 'newsAndBlogs'));
    }

    public function blogDetail($hostelSlug, $blogSlug)
    {
        $hostel = session('active_hostel');

        $blog = NewsAndBlog::where('slug', $blogSlug)
            ->where('hostel_id', $hostel->id)
            ->where('is_deleted', 0)
            ->where('is_published', 1)
            ->firstOrFail();

        $recentNews = NewsAndBlog::where('hostel_id', $hostel->id)
            ->where('is_deleted', 0)
            ->where('is_published', 1)
            ->where('id', '!=', $blog->id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('frontend.hostelPortal.blogDetail', compact('hostel', 'blog', 'recentNews'));
    }
}
