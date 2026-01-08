<?php

namespace App\Http\Controllers\admin\superAdminBackend;


use App\Http\Controllers\Controller;
use App\Http\Requests\superAdminBackend\FAQRequest;
use App\Models\SystemFAQ;
use App\Models\SystemFAQCategory;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SystemFAQController extends Controller
{
    public function index()
    {
        $faqs = SystemFAQ::where('is_deleted', 0)->get();
        return view('admin.superAdminBackend.systemFAQCategory.systemFAQ.index', compact('faqs'));
    }

    public function create()
    {
        $categories = SystemFAQCategory::where('is_deleted', 0)
            ->get();
        return view('admin.superAdminBackend.systemFAQCategory.systemFAQ.create', compact('categories'));
    }

    public function store(FAQRequest $request)
    {
        try {
            DB::beginTransaction();
            foreach ($request->faq as $key => $val) {
                SystemFAQ::create([
                    'category_id' => $request->category_id,
                    'faq_question' => $val['faq_question'],
                    'faq_answer' => $val['faq_answer'],
                    'slug' => Str::slug($request->category_id . '-' . $val['faq_question'])
                ]);
            }
            DB::commit();
            $notification = notificationMessage('success', 'FAQ', 'stored');
            return redirect()->route('admin.system-faq.index')->with($notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = notificationMessage('error', 'FAQ', 'stored');
            return redirect()->route('admin.system-faq.index')->with($notification);
        }
    }

    public function edit($slug)
    {
        $categories = SystemFAQCategory::where('is_deleted', 0)
            ->where('is_published', 1)
            ->get();
        $faq = SystemFAQ::whereSlug($slug)->first();
        return view('admin.superAdminBackend.systemFAQCategory.systemFAQ.edit', compact('categories', 'faq'));
    }

    public function publish(Request $request, $slug)
    {
        SystemFAQ::where('slug', $slug)->update([
            'is_published' => $request->is_published
        ]);

        return response()->json(["status" => true, 'message' => "Published Successfully"]);
    }

    public function update(FAQRequest $request, $slug)
    {
        try {
            DB::beginTransaction();
            $faq = SystemFAQ::whereSlug($slug)->first();
            $faq->update([
                'category_id' => $request->category_id,
                'faq_question' => $request->faq_question,
                'faq_answer' => $request->faq_answer,
                'slug' => Str::slug($request->category_id . '-' . $request->faq_question),
            ]);
            DB::commit();
            $notification = notificationMessage('success', 'FAQ', 'updated');
            return redirect()->route('admin.system-faq.index')->with($notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = notificationMessage('error', 'FAQ', 'updated');
            return redirect()->route('admin.system-faq.index')->with($notification);
        }
    }

    public function destroy($slug)
    {
        try {
            SystemFAQ::where('slug', $slug)->update(['is_deleted' => true]);
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
