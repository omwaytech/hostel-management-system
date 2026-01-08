<?php

namespace App\Http\Controllers\admin\hostelAdminBackend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SliderController extends Controller
{
    public function index()
    {
        $hostelId = session('current_hostel_id');
        $sliders = Slider::where('is_deleted', false)->where('hostel_id', $hostelId)->get();
        return view('admin.hostelAdminBackend.slider.index', compact('sliders'));
    }

    public function create()
    {
        $hostelId = session('current_hostel_id');
        return view('admin.hostelAdminBackend.slider.create', ['slider' => null, 'hostelId' => $hostelId]);
    }

    public function store(Request $request)
    {
        try {
            $slider = Slider::create([
                'hostel_id' => $request->hostel_id,
                'slider_title' => $request->slider_title,
                'slider_subtitle' => $request->slider_subtitle,
                'slug' => Str::slug($request->slider_title),
            ]);
            if ($request->hasFile('slider_image')) {
                $originalName = $request->file('slider_image')->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/sliderImages/');
                $request->file('slider_image')->move($path, $fileName);

                $slider->slider_image = $fileName;
                $slider->save();
            }
            $notification = notificationMessage('success', 'Slider', 'stored');
            return redirect()->route('hostelAdmin.slider.index')->with($notification);
        } catch (\Exception $e) {
            $notification = notificationMessage('error', 'Slider', 'stored');
            return redirect()->route('hostelAdmin.slider.index')->with($notification);
        }
    }

    public function show($slug)
    {

    }

    public function edit($slug)
    {
        $slider = Slider::whereSlug($slug)->first();
        $hostelId = session('current_hostel_id');
        return view('admin.hostelAdminBackend.slider.create', compact('slider', 'hostelId'));
    }

    public function publish(Request $request, $slug)
    {
        Slider::where('slug', $slug)->update([
            'is_published' => $request->is_published
        ]);

        return response()->json(["status" => true, 'message' => "Published Successfully"]);
    }

    public function update(Request $request, $slug)
    {
        try {
            $slider = Slider::whereSlug($slug)->first();
            $oldImage = $slider->slider_image;
            $slider->update([
                'slider_title' => $request->slider_title,
                'slider_subtitle' => $request->slider_subtitle,
                'slug' => Str::slug($request->slider_title),
            ]);
            if ($request->hasFile('slider_image')) {
                $fileNamePath = public_path('storage/images/sliderImages/' . $oldImage);
                if ($oldImage && file_exists($fileNamePath)) {
                    unlink($fileNamePath);
                }
                $originalName = $request->file('slider_image')->getClientOriginalName();
                $fileName = time() . '_' . $originalName;
                $path = public_path('storage/images/sliderImages');
                $request->file('slider_image')->move($path, $fileName);

                $slider->slider_image = $fileName;
                $slider->save();
            }

            $notification = notificationMessage('success', 'Slider', 'updated');
            return redirect()->route('hostelAdmin.slider.index')->with($notification);
        } catch (\Exception $e) {
            $notification = notificationMessage('error', 'Slider', 'updated');
            return redirect()->route('hostelAdmin.slider.index')->with($notification);
        }
    }

    public function destroy($slug)
    {
        try {
            Slider::where('slug', $slug)->update(['is_deleted' => true]);
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
