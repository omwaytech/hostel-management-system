<?php

namespace App\Http\Controllers\frontend\hostelPortal;

use App\Http\Controllers\Controller;
use App\Http\Requests\hostelPortalFrontend\ContactRequest;
use App\Models\HostelContact;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContactController extends Controller
{
    public function contact()
    {
        $hostel = session('active_hostel');
        return view('frontend.hostelPortal.contact', compact('hostel'));
    }

    public function contactStore(ContactRequest $request)
    {
        // dd($request->all());
        try {
            HostelContact::create([
                'hostel_id' => $request->hostel_id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email_address' => $request->email_address,
                'phone_number' => $request->phone_number,
                'message' => $request->message,
                'slug' => Str::slug($request->hostel_id . '-' . $request->first_name . '-' . time())
            ]);
            $notification = notificationMessage('success', 'Contact', 'submitted');
            return redirect()->back()->with($notification);
        } catch (\Exception $e) {
            $notification = notificationMessage('error', 'Contact', 'submitted');
            return redirect()->back()->with($notification);
        }
    }
}
