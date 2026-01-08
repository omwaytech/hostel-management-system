<?php

namespace App\Http\Controllers\admin\hostelAdminBackend;

use App\Http\Controllers\Controller;
use App\Http\Requests\hostelAdminBackend\NewsBlogRequest;
use App\Models\NewsAndBlog;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsAndBlogController extends Controller
{
    public function index()
    {
        $hostelId = session('current_hostel_id');
        $newsAndBlogs = NewsAndBlog::where('hostel_id', $hostelId)->where('is_deleted', 0)->get();
        return view('admin.hostelAdminBackend.newsAndBlog.index', compact('newsAndBlogs'));
    }

    public function create()
    {
        $hostelId = session('current_hostel_id');
        return view('admin.hostelAdminBackend.newsAndBlog.create', ['newsAndBlog' => null, 'hostelId' => $hostelId]);
    }

    public function store(NewsBlogRequest $request)
    {
        try {
            DB::beginTransaction();
            $newsBlog = NewsAndBlog::create([
                'hostel_id' => $request->hostel_id,
                'nb_title' => $request->nb_title,
                'nb_badge' => $request->nb_badge,
                'nb_time_to_read' => $request->nb_time_to_read,
                'nb_description' => $request->nb_description,
                'nb_author_name' => $request->nb_author_name,
                'slug' => Str::slug($request->nb_title),
            ]);
            if ($request->hasFile('nb_image')) {
                $originalName = $request->file('nb_image')->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/newsBlogImages/');
                $request->file('nb_image')->move($path, $fileName);

                $newsBlog->nb_image = $fileName;
                $newsBlog->save();
            }
            if ($request->hasFile('nb_author_image')) {
                $originalName = $request->file('nb_author_image')->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/authorImages/');
                $request->file('nb_author_image')->move($path, $fileName);

                $newsBlog->nb_author_image = $fileName;
                $newsBlog->save();
            }
            DB::commit();
            $notification = notificationMessage('success', 'News And Blog', 'stored');
            return redirect()->route('hostelAdmin.news-and-blog.index')->with($notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = notificationMessage('error', 'News And Blog', 'stored');
            return redirect()->route('hostelAdmin.news-and-blog.index')->with($notification);
        }
    }

    public function edit($slug)
    {
        $newsAndBlog = NewsAndBlog::whereSlug($slug)->first();
        $hostelId = session('current_hostel_id');
        return view('admin.hostelAdminBackend.newsAndBlog.create', compact('newsAndBlog', 'hostelId'));
    }

    public function publish(Request $request, $slug)
    {
        NewsAndBlog::where('slug', $slug)->update([
            'is_published' => $request->is_published
        ]);

        return response()->json(["status" => true, 'message' => "Published Successfully"]);
    }

    public function update(NewsBlogRequest $request, $slug)
    {
        try {
            DB::beginTransaction();
            $newsAndBlog = NewsAndBlog::whereSlug($slug)->first();
            $newsAndBlog->update([
                'nb_title' => $request->nb_title,
                'nb_badge' => $request->nb_badge,
                'nb_time_to_read' => $request->nb_time_to_read,
                'nb_description' => $request->nb_description,
                'nb_author_name' => $request->nb_author_name,
                'slug' => Str::slug($request->nb_title),
            ]);
            if ($request->hasFile('nb_image')) {
                if ($newsAndBlog->nb_image) {
                    $oldImagePath = public_path('storage/images/newsBlogImages/' . $newsAndBlog->nb_image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                $originalName = $request->file('nb_image')->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/newsBlogImages/');
                $request->file('nb_image')->move($path, $fileName);

                $newsAndBlog->nb_image = $fileName;
                $newsAndBlog->save();
            }
            if ($request->hasFile('nb_author_image')) {
                if ($newsAndBlog->nb_author_image) {
                    $oldAuthorImagePath = public_path('storage/images/authorImages/' . $newsAndBlog->nb_author_image);
                    if (file_exists($oldAuthorImagePath)) {
                        unlink($oldAuthorImagePath);
                    }
                }
                $originalName = $request->file('nb_author_image')->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/authorImages/');
                $request->file('nb_author_image')->move($path, $fileName);

                $newsAndBlog->nb_author_image = $fileName;
                $newsAndBlog->save();
            }
            DB::commit();
            $notification = notificationMessage('success', 'News And Blog', 'updated');
            return redirect()->route('hostelAdmin.news-and-blog.index')->with($notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = notificationMessage('error', 'News And Blog', 'updated');
            return redirect()->route('hostelAdmin.news-and-blog.index')->with($notification);
        }
    }

    public function destroy($slug)
    {
        try {
            NewsAndBlog::where('slug', $slug)->update(['is_deleted' => true]);
            return response()->json([
                'success' => true,
                'message' => 'Successfully removed.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
