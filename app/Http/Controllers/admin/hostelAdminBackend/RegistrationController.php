<?php

namespace App\Http\Controllers\admin\hostelAdminBackend;

use App\Http\Controllers\Controller;
use App\Http\Requests\hostelAdminBackend\RegistrationRequest;
use App\Models\Registration;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    public function index()
    {
        $hostelId = session('current_hostel_id');
        $registrations = Registration::where('hostel_id', $hostelId)->where('is_deleted', 0)->get();
        return view('admin.hostelAdminBackend.registration.index', compact('registrations'));
    }

    public function create()
    {
        $hostelId = session('current_hostel_id');
        return view('admin.hostelAdminBackend.registration.create', ['registration' => null, 'hostelId' => $hostelId]);
    }

    public function store(RegistrationRequest $request)
    {
        try {
            DB::beginTransaction();
            Registration::create([
                'hostel_id' => $request->hostel_id,
                'registered_to' => $request->registered_to,
                'registered_number' => $request->registered_number,
                'slug' => Str::slug($request->registered_to . '-' . time()),
            ]);
            DB::commit();
            $notification = notificationMessage('success', 'Registration', 'stored');
            return redirect()->route('hostelAdmin.registration.index')->with($notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = notificationMessage('error', 'Registration', 'stored');
            return redirect()->route('hostelAdmin.registration.index')->with($notification);
        }
    }

    public function edit($slug)
    {
        $registration = Registration::whereSlug($slug)->first();
        $hostelId = session('current_hostel_id');
        return view('admin.hostelAdminBackend.registration.create', compact('registration', 'hostelId'));
    }

    public function publish(Request $request, $slug)
    {
        Registration::where('slug', $slug)->update([
            'is_published' => $request->is_published
        ]);

        return response()->json(["status" => true, 'message' => "Published Successfully"]);
    }

    public function update(RegistrationRequest $request, $slug)
    {
        try {
            DB::beginTransaction();
            $registration = Registration::whereSlug($slug)->first();
            $registration->update([
                'registered_to' => $request->registered_to,
                'registered_number' => $request->registered_number,
            ]);
            DB::commit();
            $notification = notificationMessage('success', 'Registration', 'updated');
            return redirect()->route('hostelAdmin.registration.index')->with($notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = notificationMessage('error', 'Registration', 'updated');
            return redirect()->route('hostelAdmin.registration.index')->with($notification);
        }
    }

    public function destroy($slug)
    {
        try {
            Registration::where('slug', $slug)->update(['is_deleted' => true]);
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
