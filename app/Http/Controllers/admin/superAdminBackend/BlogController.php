<?php

namespace App\Http\Controllers\admin\superAdminBackend;

use App\Http\Controllers\Controller;
use App\Models\SystemBlog;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = SystemBlog::where('is_deleted', 0)->get();
        return view('admin.superAdminBackend.blog.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.superAdminBackend.blog.create', ['blog' => null]);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $cleanTags = array_filter($request->meta_tags, function ($tag) {
                return !is_null($tag) && trim($tag) !== '';
            });
            $blog = SystemBlog::create([
                'blog_title' => $request->blog_title,
                'blog_badge' => $request->blog_badge,
                'blog_time_to_read' => $request->blog_time_to_read,
                'blog_description' => $request->blog_description,
                'blog_author_name' => $request->blog_author_name,
                'slug' => Str::slug($request->blog_title),

                'page_title' => $request->page_title,
                'meta_tags' => json_encode(array_values($cleanTags)),
                'meta_description' => $request->meta_description,
            ]);
            if ($request->hasFile('blog_image')) {
                $originalName = $request->file('blog_image')->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/blogImages/');
                $request->file('blog_image')->move($path, $fileName);

                $blog->blog_image = $fileName;
                $blog->save();
            }
            if ($request->hasFile('blog_author_image')) {
                $originalName = $request->file('blog_author_image')->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/authorImages/');
                $request->file('blog_author_image')->move($path, $fileName);

                $blog->blog_author_image = $fileName;
                $blog->save();
            }
            DB::commit();
            $notification = notificationMessage('success', 'Blog', 'stored');
            return redirect()->route('admin.news-blog.index')->with($notification);
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            $notification = notificationMessage('error', 'Blog', 'stored');
            return redirect()->route('admin.news-blog.index')->with($notification);
        }
    }

    public function edit($slug)
    {
        $blog = SystemBlog::whereSlug($slug)->first();
        return view('admin.superAdminBackend.blog.create', compact('blog'));
    }

    public function publish(Request $request, $slug)
    {
        SystemBlog::where('slug', $slug)->update([
            'is_published' => $request->is_published
        ]);

        return response()->json(["status" => true, 'message' => "Published Successfully"]);
    }

    public function update(Request $request, $slug)
    {
        try {
            DB::beginTransaction();
            $blog = SystemBlog::whereSlug($slug)->first();
            $blog->update([
                'blog_title' => $request->blog_title,
                'blog_badge' => $request->blog_badge,
                'blog_time_to_read' => $request->blog_time_to_read,
                'blog_description' => $request->blog_description,
                'blog_author_name' => $request->blog_author_name,
                'slug' => Str::slug($request->blog_title),

                'page_title' => $request->page_title,
                'meta_description' => $request->meta_description,
            ]);
            if ($request->has('meta_tags')) {
                $cleanTags = array_filter($request->meta_tags, function ($tag) {
                    return !is_null($tag) && trim($tag) !== '';
                });

                $blog->meta_tags = json_encode(array_values($cleanTags));
                $blog->save();
            }
            if ($request->hasFile('blog_image')) {
                if ($blog->blog_image) {
                    $oldImagePath = public_path('storage/images/blogImages/' . $blog->blog_image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                $originalName = $request->file('blog_image')->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/blogImages/');
                $request->file('blog_image')->move($path, $fileName);

                $blog->blog_image = $fileName;
                $blog->save();
            }
            if ($request->hasFile('blog_author_image')) {
                if ($blog->blog_author_image) {
                    $oldAuthorImagePath = public_path('storage/images/authorImages/' . $blog->blog_author_image);
                    if (file_exists($oldAuthorImagePath)) {
                        unlink($oldAuthorImagePath);
                    }
                }
                $originalName = $request->file('blog_author_image')->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/authorImages/');
                $request->file('blog_author_image')->move($path, $fileName);

                $blog->blog_author_image = $fileName;
                $blog->save();
            }
            DB::commit();
            $notification = notificationMessage('success', 'Blog', 'updated');
            return redirect()->route('admin.news-blog.index')->with($notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = notificationMessage('error', 'Blog', 'updated');
            return redirect()->route('admin.news-blog.index')->with($notification);
        }
    }

    public function destroy($slug)
    {
        try {
            SystemBlog::where('slug', $slug)->update(['is_deleted' => true]);
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
