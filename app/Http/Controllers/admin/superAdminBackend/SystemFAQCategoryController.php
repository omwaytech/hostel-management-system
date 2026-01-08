<?php

namespace App\Http\Controllers\admin\superAdminBackend;


use App\Http\Controllers\Controller;
use App\Http\Requests\superAdminBackend\FAQCategoryRequest;
use App\Models\SystemFAQCategory;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SystemFAQCategoryController extends Controller
{
    public function index()
    {
        $categories = SystemFAQCategory::where('is_deleted', 0)->get();
        return view('admin.superAdminBackend.systemFAQCategory.index', compact('categories'));
    }
    public function create()
    {
        return view('admin.superAdminBackend.systemFAQCategory.create', ['category' => null]);
    }

    public function store(FAQCategoryRequest $request)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();
            SystemFAQCategory::create([
                'category_name' => $request->category_name,
                'slug' => Str::slug($request->category_name . '-' . time()),
            ]);
            DB::commit();
            $notification = notificationMessage('success', 'FAQ Category', 'stored');
            return redirect()->route('admin.system-faq-category.index')->with($notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = notificationMessage('error', 'FAQ Category', 'stored');
            return redirect()->route('admin.system-faq-category.index')->with($notification);
        }
    }

    public function edit($slug)
    {
        $category = SystemFAQCategory::whereSlug($slug)->first();
        return view('admin.superAdminBackend.systemFAQCategory.create', compact('category'));
    }

    public function publish(Request $request, $slug)
    {
        SystemFAQCategory::where('slug', $slug)->update([
            'is_published' => $request->is_published
        ]);

        return response()->json(["status" => true, 'message' => "Published Successfully"]);
    }

    public function update(FAQCategoryRequest $request, $slug)
    {
        try {
            DB::beginTransaction();
            $category = SystemFAQCategory::whereSlug($slug)->first();
            $category->update([
                'category_name' => $request->category_name,
                'slug' => Str::slug($request->category_name . '-' . time()),
            ]);
            DB::commit();
            $notification = notificationMessage('success', 'FAQ Category', 'updated');
            return redirect()->route('admin.system-faq-category.index')->with($notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = notificationMessage('error', 'FAQ Category', 'updated');
            return redirect()->route('admin.system-faq-category.index')->with($notification);
        }
    }

    public function destroy($slug)
    {
        try {
            SystemFAQCategory::where('slug', $slug)->update(['is_deleted' => true]);
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
