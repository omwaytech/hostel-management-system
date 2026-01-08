<?php

namespace App\Http\Controllers\admin\hostelAdminBackend;

use App\Http\Controllers\Controller;
use App\Http\Requests\hostelAdminBackend\AboutRequest;
use App\Models\About;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AboutController extends Controller
{
    public function index()
    {
        $hostelId = session('current_hostel_id');
        $abouts = About::where('hostel_id', $hostelId)
        ->where('is_deleted', 0)->get();
        return view('admin.hostelAdminBackend.about.index', compact('abouts'));
    }
    public function create()
    {
        $hostelId = session('current_hostel_id');
        return view('admin.hostelAdminBackend.about.create', ['about' => null, 'hostelId' => $hostelId]);
    }

    public function store(AboutRequest $request)
    {
        try {
            DB::beginTransaction();
            About::create([
                'hostel_id' => $request->hostel_id,
                'about_title' => $request->about_title,
                'about_description' => $request->about_description,
                'about_mission' => $request->about_mission,
                'about_vision' => $request->about_vision,
                'about_value' => $request->about_value,
                'slug' => Str::slug($request->about_title),
            ]);
            DB::commit();
            $notification = notificationMessage('success', 'About', 'stored');
            return redirect()->route('hostelAdmin.about.index')->with($notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = notificationMessage('error', 'About', 'stored');
            return redirect()->route('hostelAdmin.about.index')->with($notification);
        }
    }

    public function edit($slug)
    {
        $about = About::whereSlug($slug)->first();
        $hostelId = session('current_hostel_id');
        return view('admin.hostelAdminBackend.about.create', compact('about', 'hostelId'));
    }

    public function update(AboutRequest $request, $slug)
    {
        try {
            DB::beginTransaction();
            $about = About::whereSlug($slug)->first();
            $about->update([
                'about_title' => $request->about_title,
                'about_description' => $request->about_description,
                'about_mission' => $request->about_mission,
                'about_vision' => $request->about_vision,
                'about_value' => $request->about_value,
                'slug' => Str::slug($request->about_title),
            ]);
            DB::commit();
            $notification = notificationMessage('success', 'About', 'updated');
            return redirect()->route('hostelAdmin.about.index')->with($notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = notificationMessage('error', 'About', 'updated');
            return redirect()->route('hostelAdmin.about.index')->with($notification);
        }
    }
    public function destroy($slug)
    {
        try {
            About::where('slug', $slug)->update(['is_deleted' => true]);
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
