<?php

namespace App\Http\Controllers\frontend\mainPortal;

use App\Http\Controllers\Controller;
use App\Http\Requests\mainPortalFrontend\PropertyListRequest;
use App\Models\Amenity;
use App\Models\Hostel;
use App\Models\HostelAmenity;
use App\Models\PropertyList;
use App\Models\SystemTestimonial;
use App\Models\User;
use App\Notifications\NewHostelRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;
use App\Models\Occupancy;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        $hostels = Hostel::with(['amenities', 'images', 'blocks.occupancies', 'hostelReviews' => function ($query) {
            $query->where('is_approved', true);
        }])
            ->where('is_deleted', 0)
            ->where('is_published', 1)
            ->get()
            ->map(function ($hostel) {
                // Calculate average rating and review count
                $averageRating = $hostel->hostelReviews->avg('rating');
                $reviewCount = $hostel->hostelReviews->count();

                // Add calculated values to hostel object
                $hostel->average_rating = $averageRating ? round($averageRating, 1) : 0;
                $hostel->review_count = $reviewCount;

                return $hostel;
            })
            ->sortByDesc('average_rating'); // Order by average rating (highest first)

        $hostelsData = $hostels->map(function ($hostel) {
            return [
                'slug' => $hostel->slug,
                'name' => $hostel->name,
                'type' => $hostel->type,
                'rating' => $hostel->average_rating,
                'reviews' => $hostel->review_count,
                'price' => optional($hostel->blocks
                    ->flatMap(fn($block) => $block->occupancies))
                    ->min('monthly_rent') ?? 0,
                'images' => $hostel->images->pluck('image')->map(function ($img) {
                    return asset('storage/images/hostelImages/' . $img); // or the correct path
                })->toArray(),
            ];
        })->values()->toArray();

        $testimonials = SystemTestimonial::where('is_deleted', 0)
            ->where('is_published', 1)
            ->paginate(1); // 6 testimonials per page (3 rows with 2 columns)

        // Get amenities and room types for filter
        $amenities = Amenity::where('is_deleted', 0)->where('is_published', 1)->get();
        $roomTypes = \App\Models\Occupancy::select('occupancy_type')
            ->distinct()
            ->pluck('occupancy_type');

        return view('frontend.mainPortal.index', compact('hostels', 'hostelsData', 'testimonials', 'amenities', 'roomTypes'));
    }

    public function propertyListSubmit(PropertyListRequest $request)
    {
        try {
            $property = PropertyList::create([
                'hostel_name' => $request->hostel_name,
                'owner_name' => $request->owner_name,
                'hostel_email' => $request->hostel_email,
                'hostel_contact' => $request->hostel_contact,
                'hostel_city' => $request->hostel_city,
                'hostel_location' => $request->hostel_location,
                'slug' => Str::slug($request->hostel_name . '-' . time()),
            ]);
            $superAdmin = User::where('role_id', 1)->first();
            Notification::send($superAdmin, new NewHostelRequest($property));

            $notification = notificationMessage('success', 'Hostel Request', 'submitted');
            return redirect()->back()->with($notification);
        } catch (\Exception $e) {
            // dd($e->getMessage());
            $notification = notificationMessage('error', 'Hostel Request', 'submitted');
            return redirect()->back()->with($notification);
        }
    }

    public function paginateTestimonials(Request $request)
    {
        $testimonials = SystemTestimonial::where('is_deleted', 0)
            ->where('is_published', 1)
            ->paginate(1);

        if ($request->ajax()) {
            $testimonialsData = $testimonials->map(function ($testimonial) {
                return [
                    'person_name' => $testimonial->person_name,
                    'person_image' => asset('storage/images/testimonialImages/' . $testimonial->person_image),
                    'rating' => $testimonial->rating,
                    'person_statement' => strip_tags($testimonial->person_statement),
                    'created_at' => \Carbon\Carbon::parse($testimonial->created_at)->format('d M Y')
                ];
            });

            return response()->json([
                'testimonials' => $testimonialsData,
                'pagination' => [
                    'current_page' => $testimonials->currentPage(),
                    'last_page' => $testimonials->lastPage(),
                    'has_more_pages' => $testimonials->hasMorePages(),
                    'on_first_page' => $testimonials->onFirstPage(),
                ]
            ]);
        }
    }

    public function filterHostels(Request $request)
    {
        $query = Hostel::with(['blocks.occupancies', 'amenities', 'images', 'hostelReviews' => function ($q) {
            $q->where('is_approved', true);
        }])
            ->where('is_deleted', 0)
            ->where('is_published', 1);

        // Room Type Filter
        if ($request->filled('roomType')) {
            $roomType = $request->input('roomType');
            $query->whereHas('blocks.occupancies', function ($q) use ($roomType) {
                $q->where('occupancy_type', $roomType);
            });
        }

        // Gender Filter
        if ($request->filled('gender')) {
            $gender = $request->input('gender');
            $query->where('type', $gender);
        }

        // Price Range Filter
        if ($request->filled('minPrice') && $request->filled('maxPrice')) {
            $min = $request->input('minPrice');
            $max = $request->input('maxPrice');

            // For the highest range (20000+), use >= instead of between
            if ($max >= 100000) {
                $query->whereHas('blocks.occupancies', function ($q) use ($min) {
                    $q->where('monthly_rent', '>=', $min);
                });
            } else {
                $query->whereHas('blocks.occupancies', function ($q) use ($min, $max) {
                    $q->whereBetween('monthly_rent', [$min, $max]);
                });
            }
        }

        // Amenities Filter - Filter hostels that have ALL selected amenities
        if ($request->filled('amenities')) {
            $amenities = $request->input('amenities');
            foreach ($amenities as $amenity) {
                $query->whereHas('amenities', function ($q) use ($amenity) {
                    $q->where('amenity_name', $amenity);
                });
            }
        }

        $hostels = $query->get()->map(function ($hostel) {
            // Calculate average rating
            $averageRating = $hostel->hostelReviews->avg('rating');
            $reviewCount = $hostel->hostelReviews->count();

            $hostel->average_rating = $averageRating ? round($averageRating, 1) : 0;
            $hostel->review_count = $reviewCount;

            return $hostel;
        });

        // Rating Filter (apply after mapping)
        if ($request->filled('rating')) {
            $minRating = $request->input('rating');
            $hostels = $hostels->filter(function ($hostel) use ($minRating) {
                return $hostel->average_rating >= $minRating;
            })->values();
        }

        // Sort by rating
        $hostels = $hostels->sortByDesc('average_rating')->values();

        return response()->json([
            'hostels' => $hostels,
            'count' => $hostels->count()
        ]);
    }

    public function nearMe(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $userLat = $request->input('latitude');
        $userLon = $request->input('longitude');

        // Get all published hostels with coordinates
        $hostels = Hostel::with(['amenities', 'images', 'blocks.occupancies', 'hostelReviews' => function ($query) {
            $query->where('is_approved', true);
        }])
            ->where('is_deleted', 0)
            ->where('is_published', 1)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get()
            ->map(function ($hostel) use ($userLat, $userLon) {
                // Calculate distance
                $distance = Hostel::calculateDistance(
                    $userLat,
                    $userLon,
                    $hostel->latitude,
                    $hostel->longitude
                );

                // Calculate average rating
                $averageRating = $hostel->hostelReviews->avg('rating');
                $reviewCount = $hostel->hostelReviews->count();

                $hostel->distance = round($distance, 2);
                $hostel->average_rating = $averageRating ? round($averageRating, 1) : 0;
                $hostel->review_count = $reviewCount;

                return $hostel;
            })
            ->sortBy('distance')
            ->take(5)
            ->values();

        return response()->json([
            'hostels' => $hostels,
            'count' => $hostels->count()
        ]);
    }
}
