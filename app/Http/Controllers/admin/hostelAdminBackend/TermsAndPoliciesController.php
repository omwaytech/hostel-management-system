<?php

namespace App\Http\Controllers\admin\hostelAdminBackend;

use App\Http\Controllers\Controller;
use App\Models\TermsAndPolicies;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TermsAndPoliciesController extends Controller
{
    public function index()
    {
        $hostelId = session('current_hostel_id');
        $termsAndPolicies = TermsAndPolicies::where('hostel_id', $hostelId)->where('is_deleted', 0)->get();
        return view('admin.hostelAdminBackend.termsAndPolicies.index', compact('termsAndPolicies'));
    }

    public function create()
    {
        $hostelId = session('current_hostel_id');
        return view('admin.hostelAdminBackend.termsAndPolicies.create', ['termsAndPolicy' => null, 'hostelId' => $hostelId]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'hostel_id' => 'required|exists:hostels,id',
            'tp_title' => 'required|string|max:255',
            'tp_description' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            TermsAndPolicies::create([
                'hostel_id' => $request->hostel_id,
                'tp_title' => $request->tp_title,
                'tp_description' => $request->tp_description,
                'slug' => Str::slug($request->tp_title . '-' . time()),
            ]);

            DB::commit();
            $notification = notificationMessage('success', 'Terms and Policies', 'stored');
            return redirect()->route('hostelAdmin.terms-and-policies.index')->with($notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = notificationMessage('error', 'Terms and Policies', 'stored');
            return redirect()->route('hostelAdmin.terms-and-policies.index')->with($notification);
        }
    }

    public function edit($slug)
    {
        $hostelId = session('current_hostel_id');
        $termsAndPolicy = TermsAndPolicies::whereSlug($slug)->firstOrFail();
        return view('admin.hostelAdminBackend.termsAndPolicies.create', compact('termsAndPolicy', 'hostelId'));
    }

    public function publish(Request $request, TermsAndPolicies $termsAndPolicy)
    {
        $hostelId = session('current_hostel_id');
        if ($termsAndPolicy->hostel_id != $hostelId && auth()->user()->role_id != 1) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $termsAndPolicy->is_published = $request->input('is_published');
        $termsAndPolicy->save();

        return response()->json(['success' => true]);
    }

    public function update(Request $request, $slug)
    {
        $request->validate([
            'hostel_id' => 'required|exists:hostels,id',
            'tp_title' => 'required|string|max:255',
            'tp_description' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $termsAndPolicy = TermsAndPolicies::whereSlug($slug)->firstOrFail();

            $hostelId = session('current_hostel_id');
            if ($termsAndPolicy->hostel_id != $hostelId && auth()->user()->role_id != 1) {
                DB::rollBack();
                $notification = notificationMessage('error', 'Access', 'denied');
                return redirect()->route('hostelAdmin.terms-and-policies.index')->with($notification);
            }

            $termsAndPolicy->update([
                'tp_title' => $request->tp_title,
                'tp_description' => $request->tp_description,
                'slug' => Str::slug($request->tp_title . '-' . time()),
            ]);

            DB::commit();
            $notification = notificationMessage('success', 'Terms and Policies', 'updated');
            return redirect()->route('hostelAdmin.terms-and-policies.index')->with($notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = notificationMessage('error', 'Terms and Policies', 'updated');
            return redirect()->route('hostelAdmin.terms-and-policies.index')->with($notification);
        }
    }

    public function destroy($slug)
    {
        try {
            TermsAndPolicies::where('slug', $slug)->update(['is_deleted' => true]);
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
