<?php

namespace App\Http\Controllers\frontend\hostelPortal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register()
    {
        $hostel = session('active_hostel');
        return view('frontend.hostelPortal.register', compact('hostel'));
    }
}
