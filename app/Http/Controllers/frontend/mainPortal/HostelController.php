<?php

namespace App\Http\Controllers\frontend\mainPortal;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\Hostel;
use App\Models\Occupancy;
use Illuminate\Http\Request;

class HostelController extends Controller
{
    public function hostel(Request $request)
    {
        $limit = $request->get('limit', 3); // default 3
        $offset = $request->get('offset', 0);

        $hostels = Hostel::with(['images', 'hostelReviews' => function($query) {
                $query->where('is_approved', true);
            }])
            ->where('is_deleted', 0)
            ->skip($offset)
            ->take($limit)
            ->get()
            ->map(function($hostel) {
                // Calculate average rating and review count
                $averageRating = $hostel->hostelReviews->avg('rating');
                $reviewCount = $hostel->hostelReviews->count();

                $hostel->average_rating = $averageRating ? round($averageRating, 1) : 0;
                $hostel->review_count = $reviewCount;

                return $hostel;
            });

        if ($request->ajax()) {
            return view('frontend.mainPortal.partials.filteredHostel', compact('hostels'))->render();
        }
        $amenities = Amenity::where('is_deleted', 0)->where('is_published',  1)->get();
        $roomTypes = Occupancy::select('occupancy_type')
        ->distinct()
        ->pluck('occupancy_type');
        return view('frontend.mainPortal.hostel', compact('hostels', 'amenities', 'roomTypes'));
    }

    public function filter(Request $request)
    {
        $query = Hostel::with(['blocks.occupancies', 'amenities', 'images', 'hostelReviews' => function($q) {
            $q->where('is_approved', true);
        }]);

        if ($request->filled('roomType')) {
            $roomType = $request->input('roomType');
            $query->whereHas('blocks.occupancies', function ($q) use ($roomType) {
                $q->where('occupancy_type', $roomType);
            });
        }

        if ($request->filled('minPrice') && $request->filled('maxPrice')) {
            $min = $request->input('minPrice');
            $max = $request->input('maxPrice');
            $query->whereHas('blocks.occupancies', function ($q) use ($min, $max) {
                $q->whereBetween('monthly_rent', [$min, $max]);
            });
        }

        if ($request->filled('amenities')) {
            $amenities = $request->input('amenities');
            $query->whereHas('amenities', function ($q) use ($amenities) {
                $q->whereIn('amenity_name', $amenities);
            });
        }

        $hostels = $query->get()->map(function($hostel) {
            // Calculate average rating and review count
            $averageRating = $hostel->hostelReviews->avg('rating');
            $reviewCount = $hostel->hostelReviews->count();

            $hostel->average_rating = $averageRating ? round($averageRating, 1) : 0;
            $hostel->review_count = $reviewCount;

            return $hostel;
        });

        // Filter by rating if provided
        if ($request->filled('ratings') && is_array($request->ratings) && count($request->ratings) > 0) {
            $minRating = min($request->ratings); // Get the lowest selected rating
            $hostels = $hostels->filter(function($hostel) use ($minRating) {
                return $hostel->average_rating >= $minRating;
            });
        }

        $html = view('frontend.mainPortal.partials.filteredHostel', compact('hostels'))->render();

        return response()->json(['html' => $html]);
    }

    public function hostelDetail($slug)
    {
        $hostelDetail = Hostel::whereSlug($slug)
            ->with(['images', 'amenities'])
            ->first();

        // Get hostel features
        $hostelFeatures = \App\Models\HostelFeature::where('hostel_id', $hostelDetail->id)->get();

        // Get hostel configurations
        $hostelConfigs = \App\Models\HostelConfig::where('hostel_id', $hostelDetail->id)
            ->pluck('value', 'key')
            ->toArray();

        return view('frontend.mainPortal.hostelDetail', compact('hostelDetail', 'hostelFeatures', 'hostelConfigs'));
    }
}
