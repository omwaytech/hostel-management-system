<?php

namespace App\Http\Controllers\admin\hostelAdminBackend;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\Hostel;
use App\Models\Resident;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index($token)
    {
        if (!session()->has('current_hostel_id')) {
            $hostel = Hostel::where('token', $token)->firstOrFail();
            session()->put('current_hostel_id', $hostel->id);
        }

        $hostelId = session('current_hostel_id');

        if (!$hostelId) {
            abort(403, 'Hostel context not found.');
        }

        $totalUsers = User::whereHas('hostels', function ($query) use ($hostelId) {
            $query->where('hostel_id', $hostelId);
        })->get();
        $totalBlocks = Block::whereHas('hostel', function ($query) use ($hostelId) {
            $query->where('hostel_id', $hostelId);
        })->get();
        $totalResidents = Resident::whereHas('block.hostel', function ($query) use ($hostelId) {
            $query->where('hostel_id', $hostelId);
        })->get();
        $totalStaffs = Staff::whereHas('block.hostel', function ($query) use ($hostelId) {
            $query->where('hostel_id', $hostelId);
        })->get();
        return view('admin.hostelAdminBackend.dashboard.index', compact(
            'totalUsers',
            'totalBlocks',
            'totalResidents',
            'totalStaffs'
        ));
    }
}
