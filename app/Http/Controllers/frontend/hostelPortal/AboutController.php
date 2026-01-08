<?php

namespace App\Http\Controllers\frontend\hostelPortal;

use App\Http\Controllers\Controller;
use App\Http\Requests\hostelPortalFrontend\InquiryRequest;
use App\Models\About;
use App\Models\HostelFeature;
use App\Models\HostelInquiry;
use App\Models\Registration;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AboutController extends Controller
{
    public function about()
    {
        $hostel = session('active_hostel');
        $about = About::where('hostel_id', $hostel->id)
        ->where('is_deleted', 0)->first();

        $hostelFeatures = HostelFeature::where('hostel_id', $hostel->id)
        ->where('is_deleted', 0)
        ->where('is_published', 1)
        ->get();

        $registrations = Registration::where('hostel_id', $hostel->id)
        ->where('is_deleted', 0)
        ->get();

        $hostelTeams = Team::where('hostel_id', $hostel->id)
        ->where('is_deleted', 0)
        ->where('is_published', 1)
        ->get();

        $teamsData = $hostelTeams->map(function($team) {
            return [
                'name' => $team->member_name,
                'role' => $team->member_designation,
                'description' => strip_tags($team->member_description),
                'image' => asset('storage/images/memberImages/' . $team->member_image),
            ];
        });

        return view('frontend.hostelPortal.about', [
            'hostel' => $hostel,
            'about' => $about,
            'hostelFeatures' => $hostelFeatures,
            'registrations' => $registrations,
            'teamsData' => $teamsData,
        ]);
    }

    public function inquiryStore(InquiryRequest $request)
    {
        // dd($request->all());
        try {
            HostelInquiry::create([
                'hostel_id' => $request->hostel_id,
                'full_name' => $request->full_name,
                'email_address' => $request->email_address,
                'subject' => $request->subject,
                'meal_radio' => $request->meal_radio,
                'message' => $request->message,
                'slug' => Str::slug($request->hostel_id . '-' . $request->full_name . '-' . time())
            ]);
            $notification = notificationMessage('success', 'Inquiry', 'submitted');
            return redirect()->back()->with($notification);
        } catch (\Exception $e) {
            $notification = notificationMessage('error', 'Inquiry', 'submitted');
            return redirect()->back()->with($notification);
        }
    }
}
