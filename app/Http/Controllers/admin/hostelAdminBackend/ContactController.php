<?php

namespace App\Http\Controllers\admin\hostelAdminBackend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\HostelContact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $hostelId = session('current_hostel_id');
        $contacts = HostelContact::where('hostel_id', $hostelId)
        ->where('is_deleted', 0)
        ->get();
        return view('admin.hostelAdminBackend.contact.index', compact('contacts'));
    }

    public function destroy($slug)
    {
        try {
            HostelContact::where('slug', $slug)->update(['is_deleted' => true]);
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
