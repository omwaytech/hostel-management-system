<?php

namespace App\Http\Controllers\frontend\hostelPortal;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\Hostel;
use App\Models\HostelFeature;
use App\Models\Review;
use App\Models\Room;
use App\Models\ShortTermBooking;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index($slug)
    {
        $hostel = session('active_hostel');

        $sliders = Slider::where('hostel_id', $hostel->id)
            ->where('is_published', 1)
            ->where('is_deleted', 0)
            ->get()
            ->map(function ($slider) {
                return [
                    'image' => asset('storage/images/sliderImages/' . $slider->slider_image),
                    'title' => $slider->slider_title ?? '',
                    'description' => $slider->slider_subtitle ?? ''
                ];
            })
            ->values();

        $blocks = Block::where('hostel_id', $hostel->id)
            ->with(['floors.rooms.occupancy', 'floors.rooms.beds'])
            ->where('is_deleted', 0)
            ->get();

        $hostelFeatures = HostelFeature::where('hostel_id', $hostel->id)->get();

        $reviews = Review::where('hostel_id', $hostel->id)
            ->where('is_deleted', 0)
            ->latest()
            ->take(6)
            ->get();

        // Calculate average rating from HostelReview
        $averageRating = $hostel->hostelReviews()
            ->where('is_approved', true)
            ->avg('rating');

        $reviewCount = $hostel->hostelReviews()
            ->where('is_approved', true)
            ->count();

        $averageRating = $averageRating ? round($averageRating, 1) : 0;

        return view('frontend.hostelPortal.index', compact('hostel', 'blocks', 'hostelFeatures', 'reviews', 'sliders', 'averageRating', 'reviewCount'));
    }

    public function searchRooms(Request $request, $slug)
    {
        $hostel = session('active_hostel');

        // Get search parameters
        $daysOfStay = $request->input('days_of_stay', 1);
        $roomType = $request->input('room_type', 'Private');
        $priceRange = $request->input('price_range', '5000-15000');

        // Parse price range
        $priceParts = explode('-', $priceRange);
        $minPrice = isset($priceParts[0]) ? (int)$priceParts[0] : 0;
        $maxPrice = isset($priceParts[1]) ? (int)$priceParts[1] : PHP_INT_MAX;

        // Map room type to occupancy types
        // Private = Single occupancy, Shared = Double/Triple occupancy
        $occupancyTypes = ($roomType === 'Private') ? ['Single'] : ['Double', 'Triple'];

        // Query rooms based on filters
        $rooms = Room::whereHas('floor.block', function($query) use ($hostel) {
                $query->where('hostel_id', $hostel->id);
            })
            ->whereHas('occupancy', function($query) use ($occupancyTypes, $minPrice, $maxPrice) {
                $query->whereIn('occupancy_type', $occupancyTypes)
                      ->whereBetween('monthly_rent', [$minPrice, $maxPrice]);
            })
            ->with(['occupancy', 'beds', 'floor.block'])
            ->get();

        // If AJAX request, return JSON
        if ($request->wantsJson() || $request->ajax()) {
            $roomsData = $rooms->map(function($room) use ($daysOfStay) {
                $availableBeds = $room->beds->where('status', 'Available')->count();
                $totalBeds = $room->beds->count();
                $monthlyRent = $room->occupancy ? $room->occupancy->monthly_rent : 0;
                $dailyRate = round(($monthlyRent / 30) * $daysOfStay);

                return [
                    'id' => $room->id,
                    'room_number' => $room->room_number,
                    'slug' => $room->slug,
                    'photo_url' => $room->photo ? asset('storage/images/roomPhotos/' . $room->photo) : null,
                    'block_name' => $room->floor->block->name ?? 'N/A',
                    'location_name' => $room->floor->block->location ?? 'N/A',
                    'occupancy_type' => $room->occupancy ? $room->occupancy->occupancy_type : 'Standard',
                    'available_beds' => $availableBeds,
                    'total_beds' => $totalBeds,
                    'monthly_rent' => $monthlyRent,
                    'daily_rate' => $dailyRate,
                ];
            });

            return response()->json(['rooms' => $roomsData]);
        }

        // For non-AJAX requests, return full page view
        $sliders = Slider::where('hostel_id', $hostel->id)
            ->where('is_published', 1)
            ->where('is_deleted', 0)
            ->get()
            ->map(function ($slider) {
                return [
                    'image' => asset('storage/images/sliderImages/' . $slider->slider_image),
                    'title' => $slider->slider_title ?? '',
                    'description' => $slider->slider_subtitle ?? ''
                ];
            })
            ->values();

        $blocks = Block::where('hostel_id', $hostel->id)
            ->with(['floors.rooms.occupancy', 'floors.rooms.beds'])
            ->get();

        $hostelFeatures = HostelFeature::where('hostel_id', $hostel->id)->get();

        $reviews = Review::where('hostel_id', $hostel->id)
            ->where('is_deleted', 0)
            ->latest()
            ->take(6)
            ->get();

        $averageRating = $hostel->hostelReviews()
            ->where('is_approved', true)
            ->avg('rating');

        $reviewCount = $hostel->hostelReviews()
            ->where('is_approved', true)
            ->count();

        $averageRating = $averageRating ? round($averageRating, 1) : 0;

        return view('frontend.hostelPortal.index', compact('hostel', 'blocks', 'hostelFeatures', 'reviews', 'sliders', 'averageRating', 'reviewCount', 'rooms'));
    }

    public function storeBooking(Request $request, $slug)
    {
        $hostel = session('active_hostel');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'permanent_address' => 'nullable|string|max:255',
            'message' => 'nullable|string',
            'room_id' => 'nullable|integer',
            'days_of_stay' => 'nullable|integer',
            'room_type' => 'nullable|string',
            'price_range' => 'nullable|string',
        ]);

        try {
            $booking = ShortTermBooking::create([
                'hostel_id' => $hostel->id,
                'room_id' => $request->room_id,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'permanent_address' => $request->permanent_address,
                'message' => $request->message,
                'days_of_stay' => $request->days_of_stay,
                'room_type' => $request->room_type,
                'price_range' => $request->price_range,
                'status' => 'pending',
                'slug' => Str::slug($request->name . '-' . time()),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Booking submitted successfully!',
                'data' => [
                    'name' => $booking->name,
                    'email' => $booking->email,
                    'phone' => $booking->phone,
                    'permanent_address' => $booking->permanent_address,
                    'message' => $booking->message,
                    'booking_id' => $booking->id,
                    'status' => $booking->status,
                ]
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Booking submission error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit booking. Please try again.'
            ], 500);
        }
    }
}
