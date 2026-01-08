<?php

namespace App\Http\Controllers\admin\hostelAdminBackend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $hostelId = session('current_hostel_id');

        $bookings = Booking::with(['room.occupancy', 'room.floor.block', 'resident'])
            ->where('hostel_id', $hostelId)
            ->get();
        return view('admin.hostelAdminBackend.booking.index', compact('bookings'));
    }
}
