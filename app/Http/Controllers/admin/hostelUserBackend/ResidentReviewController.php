<?php

namespace App\Http\Controllers\admin\hostelUserBackend;

use App\Http\Controllers\Controller;
use App\Models\Hostel;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use DB;

class ResidentReviewController extends Controller
{
    /**
     * Show the form for creating a new review
     */
    public function create($hostelId)
    {
        $user = Auth::user();
        $resident = $user->resident;

        if (!$resident) {
            return redirect()->back()->with(
                notificationMessage('error', 'Access Denied', 'failed', 'Resident profile not found.')
            );
        }

        $hostel = Hostel::findOrFail($hostelId);

        // Check if resident can review this hostel
        if (!$resident->canReviewHostel($hostelId)) {
            $message = $resident->reviews()->where('hostel_id', $hostelId)->exists()
                ? 'You have already reviewed this hostel.'
                : 'You can only review hostels where you have stayed.';

            return redirect()->back()->with(
                notificationMessage('warning', 'Review Not Allowed', 'failed', $message)
            );
        }

        return view('admin.hostelUserBackend.reviews.create', compact('hostel', 'resident'));
    }

    /**
     * Store a newly created review
     */
    public function store(Request $request)
    {
        $request->validate([
            'hostel_id' => 'required|exists:hostels,id',
            'rating' => 'required|numeric|min:1|max:5',
            'review_text' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();
        $resident = $user->resident;

        if (!$resident) {
            return redirect()->back()->with(
                notificationMessage('error', 'Error', 'failed', 'Resident profile not found.')
            );
        }

        // Verify resident can review this hostel
        if (!$resident->canReviewHostel($request->hostel_id)) {
            return redirect()->back()->with(
                notificationMessage('error', 'Review Not Allowed', 'failed', 'You cannot review this hostel.')
            );
        }

        try {
            DB::beginTransaction();

            // Create the review
            $review = Review::create([
                'hostel_id' => $request->hostel_id,
                'user_id' => $user->id,
                'resident_id' => $resident->id,
                'person_name' => $resident->full_name,
                'person_image' => $resident->photo,
                'person_address' => optional($resident->block)->location ?? 'N/A',
                'rating' => $request->rating,
                'person_statement' => $request->review_text,
                'review_date' => now(),
                'is_verified_stay' => true, // Resident actually stayed
                'slug' => Str::slug($resident->full_name . '-' . $request->hostel_id . '-' . now()->timestamp),
            ]);

            // Update hostel rating statistics
            $hostel = Hostel::find($request->hostel_id);
            $hostel->updateRatingStats();

            DB::commit();

            return redirect()->route('resident.hostels.show', $request->hostel_id)->with(
                notificationMessage('success', 'Review Submitted', 'completed', 'Thank you for your review!')
            );

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(
                notificationMessage('error', 'Error', 'failed', 'Failed to submit review. Please try again.')
            );
        }
    }

    /**
     * Remove the specified review
     */
    public function destroy($id)
    {
        try {
            $user = Auth::user();
            $review = Review::findOrFail($id);

            // Check if this review belongs to the current user
            if ($review->user_id != $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'You can only delete your own reviews.'
                ], 403);
            }

            $hostelId = $review->hostel_id;
            $review->delete();

            // Update hostel rating statistics
            $hostel = Hostel::find($hostelId);
            $hostel->updateRatingStats();

            return response()->json([
                'success' => true,
                'message' => 'Review deleted successfully.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete review.'
            ], 500);
        }
    }
}
