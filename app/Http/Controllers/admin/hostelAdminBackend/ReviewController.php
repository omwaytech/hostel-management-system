<?php

namespace App\Http\Controllers\admin\hostelAdminBackend;

use App\Http\Controllers\Controller;
use App\Http\Requests\hostelAdminBackend\ReviewRequest;
use App\Models\Review;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReviewController extends Controller
{
    public function index()
    {
        $hostelId = session('current_hostel_id');
        $reviews = Review::where('is_deleted', 0)->get();
        return view('admin.hostelAdminBackend.review.index', compact('reviews'));
    }

    public function create()
    {
        $hostelId = session('current_hostel_id');
        return view('admin.hostelAdminBackend.review.create', ['review' => null, 'hostelId' => $hostelId]);
    }

    public function store(ReviewRequest $request)
    {
        try {
            DB::beginTransaction();
            $review = Review::create([
                'hostel_id' => $request->hostel_id,
                'person_name' => $request->person_name,
                'person_address' => $request->person_address,
                'rating' => $request->rating,
                'person_statement' => $request->person_statement,
                'slug' => Str::slug($request->person_name . '-' . time()),
            ]);

            if ($request->hasFile('person_image')) {
                $originalName = $request->file('person_image')->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/reviewImages/');
                $request->file('person_image')->move($path, $fileName);

                $review->person_image = $fileName;
                $review->save();
            }

            DB::commit();
            $notification = notificationMessage('success', 'Review', 'stored');
            return redirect()->route('hostelAdmin.review.index')->with($notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = notificationMessage('error', 'Review', 'stored');
            return redirect()->route('hostelAdmin.review.index')->with($notification);
        }
    }

    public function edit($slug)
    {
        $review = Review::whereSlug($slug)->first();
        $hostelId = session('current_hostel_id');
        return view('admin.hostelAdminBackend.review.create', compact('review', 'hostelId'));
    }

    public function publish(Request $request, $slug)
    {
        Review::where('slug', $slug)->update([
            'is_published' => $request->is_published
        ]);

        return response()->json(["status" => true, 'message' => "Published Successfully"]);
    }

    public function update(ReviewRequest $request, $slug)
    {
        try {
            DB::beginTransaction();
            $review = Review::whereSlug($slug)->first();
            $review->update([
                'person_name' => $request->person_name,
                'person_address' => $request->person_address,
                'rating' => $request->rating,
                'person_statement' => $request->person_statement,
            ]);

            if ($request->hasFile('person_image')) {
                if ($review->person_image) {
                    $oldImagePath = public_path('storage/images/reviewImages/' . $review->person_image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                $originalName = $request->file('person_image')->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/reviewImages/');
                $request->file('person_image')->move($path, $fileName);

                $review->person_image = $fileName;
                $review->save();
            }
            DB::commit();
            $notification = notificationMessage('success', 'Review', 'updated');
            return redirect()->route('hostelAdmin.review.index')->with($notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = notificationMessage('error', 'Review', 'updated');
            return redirect()->route('hostelAdmin.review.index')->with($notification);
        }
    }

    public function destroy($slug)
    {
        try {
            Review::where('slug', $slug)->update(['is_deleted' => true]);
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
