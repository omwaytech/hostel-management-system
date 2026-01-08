<?php

namespace App\Http\Controllers\admin\hostelAdminBackend;

use App\Http\Controllers\Controller;
use App\Http\Requests\hostelAdminBackend\HostelAmenityRequest;
use App\Models\HostelAmenity;
use App\Models\Icon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AmenityController extends Controller
{
    public function index()
    {
        $hostelId = session('current_hostel_id');
        $amenities = HostelAmenity::where('hostel_id', $hostelId)
        ->where('is_deleted', 0)->get();
        return view('admin.hostelAdminBackend.amenity.index', compact('amenities'));
    }

    public function create()
    {
        $hostelId = session('current_hostel_id');
        $icons = Icon::where('is_published', 1)->where('is_deleted', 0)->get();
        return view('admin.hostelAdminBackend.amenity.create', ['hostelId' => $hostelId, 'icons' => $icons]);
    }

    public function store(HostelAmenityRequest $request)
    {
        // dd($request->all());
        try {
            foreach ($request->amenity as $day => $data) {
                $amenityImage = null;
                if (isset($data['amenity_icon']) && $request->hasFile("amenity.$day.amenity_icon")) {
                    $originalName = $request->file("amenity.$day.amenity_icon")->getClientOriginalName();
                    $amenityImage = time() . '_' . $originalName;
                    $path = public_path('storage/images/amenityIcons');
                    $request->file("amenity.$day.amenity_icon")->move($path, $amenityImage);;
                }

                if(isset($data['amenity_name']) && $data['amenity_name']) {
                    HostelAmenity::create([
                        'hostel_id' => $request->hostel_id,
                        'amenity_name' => $data['amenity_name'],
                        'amenity_icon' => $data['amenity_icon'],
                        'slug' => Str::slug($data['amenity_name'] . '-' . time())
                    ]);
                }
            }
            $notification = notificationMessage('success', 'Amenity', 'created');
            return redirect()->route('hostelAdmin.hostel-amenity.index')->with($notification);
        } catch (\Exception $e) {
            $notification = notificationMessage('error', 'Amenity', 'created');
            return redirect()->route('hostelAdmin.hostel-amenity.index')->with($notification);
        }
    }

    public function publish(Request $request, $slug)
    {
        HostelAmenity::where('slug', $slug)->update([
            'is_published' => $request->is_published
        ]);

        return response()->json(["status" => true, 'message' => "Published Successfully"]);
    }

    public function edit($slug)
    {
        $amenity = HostelAmenity::where('slug', $slug)->first();
        $icons = Icon::where('is_published', 1)->where('is_deleted', 0)->get();
        return view('admin.hostelAdminBackend.amenity.edit', compact('amenity', 'icons'));
    }

    public function update(HostelAmenityRequest $request, $slug)
    {
        try {
            $amenity = HostelAmenity::where('slug', $slug)->first();
            $amenity->update([
                'amenity_name' => $request->amenity_name,
                'amenity_icon' => $request->amenity_icon,
                'slug' => Str::slug($request->amenity_name . '-' . time())
            ]);

            if ($request->hasFile('amenity_icon')) {
                if ($amenity->amenity_icon) {
                    $oldImagePath = public_path('storage/images/amenityIcons/' . $amenity->amenity_icon);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $originalName = $request->file('amenity_icon')->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/amenityIcons/');
                $request->file('amenity_icon')->move($path, $fileName);

                $amenity->amenity_icon = $fileName;
                $amenity->save();
            }

            $notification = notificationMessage('success', 'Amenity', 'updated');
            return redirect()->route('hostelAdmin.hostel-amenity.index')->with($notification);
        } catch (\Exception $e) {
            $notification = notificationMessage('error', 'Amenity', 'updated');
            return redirect()->route('hostelAdmin.hostel-amenity.index')->with($notification);
        }
    }

    public function destroy($slug)
    {
        try {
            HostelAmenity::where('slug', $slug)->update(['is_deleted' => true]);
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
