<?php

namespace App\Http\Controllers\frontend\hostelPortal;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\Occupancy;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function room()
    {
        $hostel = session('active_hostel');

        if (!$hostel) {
            return redirect()->route('home');
        }

        $blocks = Block::where('hostel_id', $hostel->id)
            ->where('is_deleted', 0)
            ->get();

        $occupancyTypes = Occupancy::whereIn('block_id', $blocks->pluck('id'))
            ->select('occupancy_type')
            ->distinct()
            ->orderBy('occupancy_type')
            ->pluck('occupancy_type');

        $priceRange = Occupancy::whereIn('block_id', $blocks->pluck('id'))
            ->selectRaw('MIN(monthly_rent) as min_price, MAX(monthly_rent) as max_price')
            ->first();

        $rooms = Room::whereHas('floor.block', function ($query) use ($hostel) {
                $query->where('hostel_id', $hostel->id);
            })
            ->with([
                'occupancy.block',
                'floor.block',
                'roomAmenities',
                'beds'
            ])
            ->get();

        return view('frontend.hostelPortal.room', compact(
            'hostel',
            'blocks',
            'occupancyTypes',
            'priceRange',
            'rooms'
        ));
    }

    public function roomDetail($slug, $roomSlug)
    {
        $hostel = session('active_hostel');

        $room = Room::with([
            'occupancy',
            'floor.block',
            'roomAmenities',
            'beds'
        ])->where('slug', $roomSlug)->firstOrFail();

        return view('frontend.hostelPortal.roomDetail', compact('hostel', 'room'));
    }

    public function filterRooms(Request $request, $slug)
    {
        $hostel = session('active_hostel');

        if (!$hostel) {
            return response()->json(['error' => 'Hostel not found'], 404);
        }

        // Start building the query
        $query = Room::whereHas('floor.block', function ($q) use ($hostel) {
            $q->where('hostel_id', $hostel->id);
        })->with([
            'occupancy.block',
            'floor.block',
            'roomAmenities',
            'beds'
        ]);

        // Filter by room type (occupancy type)
        if ($request->roomType) {
            $query->whereHas('occupancy', function ($q) use ($request) {
                $q->where('occupancy_type', $request->roomType);
            });
        }

        // Filter by blocks
        if ($request->blocks && is_array($request->blocks) && count($request->blocks) > 0) {
            $query->whereHas('floor.block', function ($q) use ($request) {
                $q->whereIn('id', $request->blocks);
            });
        }

        // Filter by price range
        if ($request->minPrice || $request->maxPrice) {
            $query->whereHas('occupancy', function ($q) use ($request) {
                if ($request->minPrice) {
                    $q->where('monthly_rent', '>=', $request->minPrice);
                }
                if ($request->maxPrice) {
                    $q->where('monthly_rent', '<=', $request->maxPrice);
                }
            });
        }

        // Filter by amenities (room must have all selected amenities)
        if ($request->amenities && is_array($request->amenities) && count($request->amenities) > 0) {
            foreach ($request->amenities as $amenity) {
                $query->whereHas('roomAmenities', function ($q) use ($amenity) {
                    $q->where('amenity_name', 'LIKE', '%' . $amenity . '%');
                });
            }
        }

        $rooms = $query->get();

        $html = view('frontend.hostelPortal.partials.filteredRooms', compact('rooms', 'hostel'))->render();

        return response()->json([
            'html' => $html,
            'count' => $rooms->count()
        ]);
    }
}
