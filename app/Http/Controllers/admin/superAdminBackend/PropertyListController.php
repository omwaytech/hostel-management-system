<?php

namespace App\Http\Controllers\admin\superAdminBackend;


use App\Http\Controllers\Controller;
use App\Models\Hostel;
use App\Models\PropertyList;
use App\Models\User;
use App\Notifications\NewHostelAdded;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class PropertyListController extends Controller
{
    public function index()
    {
        $properties = PropertyList::where('is_deleted', 0)->get();
        return view('admin.superAdminBackend.propertyList.index', compact('properties'));
    }
    public function show($slug)
    {
        $property = PropertyList::whereSlug($slug)->firstOrFail();
        return view('admin.superAdminBackend.propertyList.show', compact('property'));
    }

    public function approve($slug)
    {
        $property = PropertyList::where('slug', $slug)->firstOrFail();

        $property->is_approved = true;
        $property->save();

        $hostel = Hostel::create([
            'token' => Str::uuid(),
            'name' => $property->hostel_name,
            'contact' => $property->hostel_contact,
            'location' => $property->hostel_location,
            'email' => $property->hostel_email,
            'slug' => Str::slug($property->hostel_name . '-' . time()),
        ]);

        $superAdmin = User::where('role_id', 1)->first();
        Notification::send($superAdmin, new NewHostelAdded($hostel));

        return redirect()->route('admin.property-list.index')->with('success', 'Property approved successfully!');
    }

    public function reject($slug)
    {
        $property = PropertyList::where('slug', $slug)->firstOrFail();

        $property->is_approved = false;
        $property->save();

        // Optionally, notify owner or superadmin
        return redirect()->back()->with('error', 'Property has been rejected.');
    }

    public function destroy($slug)
    {
        try {
            PropertyList::where('slug', $slug)->update(['is_deleted' => true]);
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
