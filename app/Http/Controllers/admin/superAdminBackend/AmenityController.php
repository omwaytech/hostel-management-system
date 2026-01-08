<?php

namespace App\Http\Controllers\admin\superAdminBackend;


use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\Icon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AmenityController extends Controller
{
    public function index()
    {
        $amenities = Amenity::where('is_deleted', 0)->get();
        return view('admin.superAdminBackend.amenity.index', compact('amenities'));
    }

    public function create()
    {
        $icons = Icon::where('is_published', 1)->where('is_deleted', 0)->get();
        return view('admin.superAdminBackend.amenity.create', ['amenity' => null, 'icons' => $icons]);
    }

    public function store(Request $request)
    {
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
                    Amenity::create([
                        'amenity_name' => $data['amenity_name'],
                        'amenity_icon' => $data['amenity_icon'],
                        'slug' => Str::slug($data['amenity_name'] . '-' . time())
                    ]);
                }
            }
            $notification = notificationMessage('success', 'Amenity', 'created');
            return redirect()->route('admin.amenity.index')->with($notification);
        } catch (\Exception $e) {
            dd($e);
            $notification = notificationMessage('error', 'Amenity', 'created');
            return redirect()->route('admin.amenity.index')->with($notification);
        }
    }

    public function publish(Request $request, $slug)
    {
        Amenity::where('slug', $slug)->update([
            'is_published' => $request->is_published
        ]);

        return response()->json(["status" => true, 'message' => "Published Successfully"]);
    }

    public function edit($slug)
    {
        $amenity = Amenity::where('slug', $slug)->first();
        $icons = Icon::where('is_published', 1)->where('is_deleted', 0)->get();
        return view('admin.superAdminBackend.amenity.edit', compact('amenity', 'icons'));
    }

    public function update(Request $request, $slug)
    {
        try {
            $amenity = Amenity::where('slug', $slug)->first();
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
            return redirect()->route('admin.amenity.index')->with($notification);
        } catch (\Exception $e) {
            $notification = notificationMessage('error', 'Amenity', 'updated');
            return redirect()->route('admin.amenity.index')->with($notification);
        }
    }

    public function destroy($slug)
    {
        try {
            Amenity::where('slug', $slug)->update(['is_deleted' => true]);
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
