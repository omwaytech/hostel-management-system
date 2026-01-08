<?php

namespace App\Http\Controllers\frontend\mainPortal;

use App\Http\Controllers\Controller;
use App\Models\HostelReview;
use App\Models\Hostel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HostelReviewController extends Controller
{
    /**
     * Store a new review for a hostel.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'You must be logged in to submit a review.',
                'requiresLogin' => true
            ], 401);
        }

        // Validate the request
        $validated = $request->validate([
            'hostel_id' => 'required|exists:hostels,id',
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();

        // Check if user already reviewed this hostel
        $existingReview = HostelReview::where('user_id', $user->id)
            ->where('hostel_id', $validated['hostel_id'])
            ->first();

        if ($existingReview) {
            return response()->json([
                'success' => false,
                'message' => 'You have already submitted a review for this hostel.'
            ], 422);
        }

        // Get resident_id if user has a resident profile
        $residentId = $user->resident ? $user->resident->id : null;

        // Create the review
        $review = HostelReview::create([
            'hostel_id' => $validated['hostel_id'],
            'user_id' => $user->id,
            'resident_id' => $residentId,
            'rating' => $validated['rating'],
            'review_text' => $validated['review_text'],
            'is_approved' => true, // Auto-approve
        ]);

        // Load relationships for response
        $review->load(['user', 'resident']);

        return response()->json([
            'success' => true,
            'message' => 'Thank you for your feedback!',
            'review' => [
                'id' => $review->id,
                'user_name' => $review->user->name,
                'rating' => $review->rating,
                'review_text' => $review->review_text,
                'created_at' => $review->created_at->format('F d, Y'),
            ]
        ]);
    }

    /**
     * Get reviews for a specific hostel.
     */
    public function index($hostelId, Request $request)
    {
        $reviews = HostelReview::where('hostel_id', $hostelId)
            ->where('is_approved', true)
            ->with(['user', 'resident'])
            ->latest()
            ->paginate(1); // 6 reviews per page (3 rows × 2 columns)

        $reviewsData = $reviews->map(function ($review) {
            return [
                'id' => $review->id,
                'user_name' => $review->user->name,
                'rating' => $review->rating,
                'review_text' => $review->review_text,
                'created_at' => $review->created_at->format('F d, Y'),
                'user_photo' => $review->resident && $review->resident->photo
                    ? asset('storage/images/residentPhotos/' . $review->resident->photo)
                    : null,
            ];
        });

        return response()->json([
            'success' => true,
            'reviews' => $reviewsData,
            'pagination' => [
                'current_page' => $reviews->currentPage(),
                'last_page' => $reviews->lastPage(),
                'per_page' => $reviews->perPage(),
                'total' => $reviews->total(),
                'has_more_pages' => $reviews->hasMorePages(),
            ]
        ]);
    }
}
