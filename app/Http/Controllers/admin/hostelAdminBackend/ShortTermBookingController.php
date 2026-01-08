<?php

namespace App\Http\Controllers\admin\hostelAdminBackend;

use App\Http\Controllers\Controller;
use App\Models\ShortTermBooking;
use App\Models\Room;
use App\Models\Bed;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShortTermBookingController extends Controller
{
    public function index()
    {
        $hostelId = session('current_hostel_id');

        $bookings = ShortTermBooking::where('hostel_id', $hostelId)->where('is_deleted', false)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.hostelAdminBackend.shortTermBooking.index', compact('bookings'));
    }

    public function show(string $slug)
    {
        try {
            $booking = ShortTermBooking::with(['room.floor.block', 'bed'])
                ->where('slug', $slug)
                ->firstOrFail();

            return response()->json([
                'success' => true,
                'data' => [
                    'name' => $booking->name,
                    'email' => $booking->email,
                    'phone' => $booking->phone,
                    'permanent_addrexss' => $booking->permanent_address ?? 'N/A',
                    'message' => $booking->message ?? 'N/A',
                    'days_of_stay' => $booking->days_of_stay ?? 'N/A',
                    'room_type' => $booking->room_type ?? 'N/A',
                    'price_range' => $booking->price_range ?? 'N/A',
                    'room' => $booking->room ? $booking->room->floor->block->name . ' - Room ' . $booking->room->room_number : 'Not Assigned',
                    'bed' => $booking->bed ? 'Bed ' . $booking->bed->bed_number : 'Not Assigned',
                    'status' => ucfirst($booking->status),
                    'booking_date' => $booking->created_at->format('F d, Y'),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Booking not found.'
            ], 404);
        }
    }

    public function updateStatus(Request $request, string $slug)
    {
        try {
            $booking = ShortTermBooking::where('slug', $slug)->firstOrFail();
            $oldStatus = $booking->status;
            $newStatus = $request->status;

            // If status is changing to confirmed, find an available bed and mark it as occupied
            if ($newStatus == 'confirmed' && $oldStatus != 'confirmed') {
                if (!$booking->room_id) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Please assign a room first before confirming.'
                    ], 400);
                }

                // Find an available bed in the room
                $availableBed = Bed::where('room_id', $booking->room_id)
                    ->where('status', 'Available')
                    ->first();

                if (!$availableBed) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No available beds in this room.'
                    ], 400);
                }

                // Mark bed as occupied and assign to booking
                $availableBed->update(['status' => 'Occupied']);
                $booking->bed_id = $availableBed->id;
            }

            // If status is changing to completed and there's an assigned bed, mark it as available
            if ($newStatus == 'completed' && $booking->bed_id) {
                $bed = Bed::find($booking->bed_id);
                if ($bed) {
                    $bed->update(['status' => 'Available']);
                }
            }

            // Update booking status
            $booking->status = $newStatus;
            $booking->save();

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(string $slug)
    {
        try {
            ShortTermBooking::where('slug', $slug)->update(['is_deleted' => true]);
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
