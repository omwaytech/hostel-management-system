<?php

namespace App\Http\Controllers\frontend\hostelPortal;

use App\Http\Controllers\Controller;
use App\Models\TermsAndPolicies;
use Illuminate\Http\Request;

class TermsAndPolicyController extends Controller
{
    public function termsAndPolicy($slug, $termSlug)
    {
        $hostel = session('active_hostel');

        $term = TermsAndPolicies::where('slug', $termSlug)
            ->where('hostel_id', $hostel->id)
            ->where('is_published', true)
            ->where('is_deleted', 0)
            ->first();

        return view('frontend.hostelPortal.termsAndPolicy', compact('hostel','term'));
    }
}
