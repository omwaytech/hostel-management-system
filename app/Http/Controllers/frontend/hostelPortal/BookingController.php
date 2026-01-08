<?php

namespace App\Http\Controllers\frontend\hostelPortal;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function checkout($slug, Room $room)
    {
        $hostel = session('active_hostel');

        // Fetch the room with all necessary relationships
        $room = Room::with([
            'occupancy',
            'floor.block',
            'roomAmenities',
            'beds'
        ])->where('id', $room->id)->firstOrFail();

        return view('frontend.hostelPortal.checkout', compact('hostel', 'room'));
    }

    public function store(Request $request)
    {
        $hostel = session('active_hostel');

        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'current_address' => 'required|string|max:255',
            'move_in_date' => 'required|date|after_or_equal:today',
            'duration' => 'required|integer|min:1',
            'occupant_count' => 'required|integer|min:1',
            'emergency_contact' => 'required|string|max:20',
            'dietary_preferences' => 'nullable|string',
            'additional_requests' => 'nullable|string',
            'payment_method' => 'nullable|in:cash_on_arrival,full_payment',
            'monthly_rent' => 'nullable|numeric|min:0',
            'security_deposit' => 'nullable|numeric|min:0',
            'total_amount' => 'nullable|numeric|min:0',
            'terms_accepted' => 'required|accepted',
            'privacy_accepted' => 'required|accepted',
        ]);

        $validated['hostel_id'] = $hostel->id;
        $validated['status'] = 'pending';

        $booking = Booking::create($validated);
        $booking->slug = Str::slug($booking->room_id . '-' . $booking->full_name);
        $booking->save();

        // Get room details for the popup
        $room = Room::with(['occupancy', 'floor.block'])->findOrFail($validated['room_id']);

        $notification = notificationMessage('success', 'Booking', 'submitted', 'Booking submitted successfully! We will contact you soon.');
        return redirect()->back()->with($notification)
            ->with('booking_details', [
                'booking_id' => $booking->id,
                'full_name' => $booking->full_name,
                'email' => $booking->email,
                'phone' => $booking->phone,
                'hostel_name' => $hostel->name,
                'room_number' => $room->room_number,
                'room_type' => $room->occupancy ? $room->occupancy->occupancy_type . ' Shared' : 'Standard',
                'block_name' => $room->floor && $room->floor->block ? $room->floor->block->name : 'N/A',
                'location' => $room->floor && $room->floor->block ? $room->floor->block->location : 'N/A',
                'move_in_date' => date('F d, Y', strtotime($booking->move_in_date)),
                'duration' => $booking->duration,
                'occupant_count' => $booking->occupant_count,
                'monthly_rent' => number_format((float)$booking->monthly_rent, 2),
                'security_deposit' => number_format((float)$booking->security_deposit, 2),
                'total_amount' => number_format((float)$booking->total_amount, 2),
                'payment_method' => ucfirst(str_replace('_', ' ', $booking->payment_method)),
                'booked_at' => date('F d, Y'),
            ]);
    }
}
