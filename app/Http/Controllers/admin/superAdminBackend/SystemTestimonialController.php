<?php

namespace App\Http\Controllers\admin\superAdminBackend;


use App\Http\Controllers\Controller;
use App\Http\Requests\superAdminBackend\TestimonialRequest;
use App\Models\SystemTestimonial;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SystemTestimonialController extends Controller
{
    public function index()
    {
        $testimonials = SystemTestimonial::where('is_deleted', 0)->get();
        return view('admin.superAdminBackend.systemTestimonial.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.superAdminBackend.systemTestimonial.create', ['testimonial' => null]);
    }

    public function store(TestimonialRequest $request)
    {
        try {
            DB::beginTransaction();
            $testimonial = SystemTestimonial::create([
                'person_name' => $request->person_name,
                'person_address' => $request->person_address,
                'rating' => $request->rating,
                'person_statement' => $request->person_statement,
                'slug' => Str::slug($request->person_name . '-' . time()),
            ]);

            if ($request->hasFile('person_image')) {
                $originalName = $request->file('person_image')->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/testimonialImages/');
                $request->file('person_image')->move($path, $fileName);

                $testimonial->person_image = $fileName;
                $testimonial->save();
            }

            DB::commit();
            $notification = notificationMessage('success', 'Testimonial', 'stored');
            return redirect()->route('admin.system-testimonial.index')->with($notification);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            $notification = notificationMessage('error', 'Testimonial', 'stored');
            return redirect()->route('admin.system-testimonial.index')->with($notification);
        }
    }

    public function edit($slug)
    {
        $testimonial = SystemTestimonial::whereSlug($slug)->first();
        return view('admin.superAdminBackend.systemTestimonial.create', compact('testimonial'));
    }

    public function publish(Request $request, $slug)
    {
        SystemTestimonial::where('slug', $slug)->update([
            'is_published' => $request->is_published
        ]);

        return response()->json(["status" => true, 'message' => "Published Successfully"]);
    }


    public function update(TestimonialRequest $request, $slug)
    {
        try {
            DB::beginTransaction();
            $testimonial = SystemTestimonial::whereSlug($slug)->first();

            $testimonial->update([
                'person_name' => $request->person_name,
                'person_address' => $request->person_address,
                'rating' => $request->rating,
                'person_statement' => $request->person_statement,
                'slug' => Str::slug($request->person_name . '-' . time()),
            ]);

            if ($request->hasFile('person_image')) {
                if ($testimonial->person_image) {
                    $oldImagePath = public_path('storage/images/testimonialImages/' . $testimonial->person_image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                $originalName = $request->file('person_image')->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/testimonialImages/');
                $request->file('person_image')->move($path, $fileName);

                $testimonial->person_image = $fileName;
                $testimonial->save();
            }

            DB::commit();
            $notification = notificationMessage('success', 'Testimonial', 'stored');
            return redirect()->route('admin.system-testimonial.index')->with($notification);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            $notification = notificationMessage('error', 'Testimonial', 'stored');
            return redirect()->route('admin.system-testimonial.index')->with($notification);
        }
    }

    public function destroy($slug)
    {
        try {
            SystemTestimonial::where('slug', $slug)->update(['is_deleted' => true]);
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
