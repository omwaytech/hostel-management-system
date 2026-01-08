<?php

namespace App\Http\Controllers\admin\hostelAdminBackend;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\Occupancy;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OccupancyController extends Controller
{
    public function index()
    {

        // $occupancies = Occupancy::where('is_deleted', false)->get();
        return view('admin.hostelAdminBackend.occupancy.index', compact('occupancies'));
    }

    public function create()
    {
        $hostelId = session('current_hostel_id');

        $blocks = Block::where('hostel_id', $hostelId)
        ->where('is_deleted', 0)
        ->get();

        return view('admin.hostelAdminBackend.occupancy.create', [
            'occupancy' => null,
            'blocks' => $blocks
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        try {
            Occupancy::create([
                'block_id' => $request->block_id,
                'occupancy_type' => $request->occupancy_type,
                'monthly_rent' => $request->monthly_rent,
                'slug' => Str::slug($request->block_id . '-' . $request->occupancy_type),
            ]);
            $notification = notificationMessage('success', 'Occupancy', 'stored');
            return redirect()->route('hostelAdmin.occupancy.index')->with($notification);
        } catch (\Exception $e) {
            $notification = notificationMessage('error', 'Occupancy', 'stored');
            return redirect()->route('hostelAdmin.occupancy.index')->with($notification);
        }
    }

    public function show($slug)
    {
        //
    }

    public function edit($slug)
    {
        $occupancy = Occupancy::whereSlug($slug)->first();
        return view('admin.hostelAdminBackend.occupancy.create', compact('occupancy'));
    }

    public function update(Request $request, $slug)
    {
        try {
            $occupancy = Occupancy::whereSlug($slug)->first();

            $occupancy->update([
                'block_id' => $request->block_id,
                'occupancy_type' => $request->occupancy_type,
                'monthly_rent' => $request->monthly_rent,
                'slug' => Str::slug($request->block_id . '-' . $request->occupancy_type),
            ]);
            $notification = notificationMessage('success', 'Occupancy', 'updated');
            return redirect()->route('hostelAdmin.occupancy.index')->with($notification);
        } catch (\Exception $e) {
            $notification = notificationMessage('error', 'Occupancy', 'updated');
            return redirect()->route('hostelAdmin.occupancy.index')->with($notification);
        }
    }

    public function destroy($slug)
    {
        try {
            Occupancy::where('slug', $slug)->update(['is_deleted' => true]);
            return response()->json([
                'success' => true,
                'message' => 'Successfully removed.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove !',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
