<?php

namespace App\Http\Controllers\admin\hostelAdminBackend;

use App\Http\Controllers\Controller;
use App\Http\Requests\hostelAdminBackend\HostelFeatureRequest;
use App\Models\HostelFeature;
use App\Models\Icon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FeatureController extends Controller
{
    public function index()
    {
        $hostelId = session('current_hostel_id');
        $features = HostelFeature::where('hostel_id', $hostelId)
        ->where('is_deleted', 0)->get();
        return view('admin.hostelAdminBackend.feature.index', compact('features'));
    }

    public function create()
    {
        $hostelId = session('current_hostel_id');
        $icons = Icon::where('is_published', 1)->where('is_deleted', 0)->get();
        return view('admin.hostelAdminBackend.feature.create', ['hostelId' => $hostelId, 'icons' => $icons]);
    }

    public function store(HostelFeatureRequest $request)
    {
        try {
            foreach ($request->feature as $day => $data) {
                if(isset($data['feature_name']) && $data['feature_name']) {
                    HostelFeature::create([
                        'hostel_id' => $request->hostel_id,
                        'feature_name' => $data['feature_name'],
                        'feature_icon' => $data['feature_icon'],
                        'slug' => Str::slug($data['feature_name'] . '-' . time())
                    ]);
                }
            }
            $notification = notificationMessage('success', 'Feature', 'created');
            return redirect()->route('hostelAdmin.hostel-feature.index')->with($notification);
        } catch (\Exception $e) {
            $notification = notificationMessage('error', 'Feature', 'created');
            return redirect()->route('hostelAdmin.hostel-feature.index')->with($notification);
        }
    }

    public function publish(Request $request, $slug)
    {
        HostelFeature::where('slug', $slug)->update([
            'is_published' => $request->is_published
        ]);

        return response()->json(["status" => true, 'message' => "Published Successfully"]);
    }

    public function edit($slug)
    {
        $feature = HostelFeature::where('slug', $slug)->first();
        $icons = Icon::where('is_published', 1)->where('is_deleted', 0)->get();
        return view('admin.hostelAdminBackend.feature.edit', compact('feature', 'icons'));
    }

    public function update(HostelFeatureRequest $request, $slug)
    {
        try {
            $feature = HostelFeature::where('slug', $slug)->first();
            $feature->update([
                'feature_name' => $request->feature_name,
                'feature_icon' => $request->feature_icon,
                'slug' => Str::slug($request->feature_name . '-' . time())
            ]);
            $notification = notificationMessage('success', 'Feature', 'updated');
            return redirect()->route('hostelAdmin.hostel-feature.index')->with($notification);
        } catch (\Exception $e) {
            $notification = notificationMessage('error', 'Feature', 'updated');
            return redirect()->route('hostelAdmin.hostel-feature.index')->with($notification);
        }
    }

    public function destroy($slug)
    {
        try {
            HostelFeature::where('slug', $slug)->update(['is_deleted' => true]);
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
