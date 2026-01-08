<?php

namespace App\Http\Controllers\admin\hostelUserBackend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResidentAuthController extends Controller
{
    // public function showLoginForm()
    // {
    //     return view('auth.resident-login');
    // }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role_id == 4) {
                $request->session()->regenerate();

                // Get resident details
                $resident = $user->resident;

                if ($resident) {
                    // Store resident info in session
                    session(['current_resident_id' => $resident->id]);
                    session(['current_resident' => $resident]);

                    // Set session flash message for toastr
                    $request->session()->flash('message', 'Welcome back, ' . $resident->full_name . '!');
                    $request->session()->flash('alert-type', 'success');

                    return response()->json([
                        'success' => true,
                        'message' => 'Login successful',
                        'redirect' => route('resident.dashboard')
                    ]);
                }
            }

            // If not a student, logout and return error
            Auth::logout();

            // Set session flash message for toastr error
            $request->session()->flash('message', 'You do not have access to the resident portal.');
            $request->session()->flash('alert-type', 'error');

            return response()->json([
                'success' => false,
                'message' => 'You do not have access to the resident portal.',
                'showToastr' => true
            ], 403);
        }

        // Set session flash message for toastr error
        $request->session()->flash('message', 'Invalid email or password.');
        $request->session()->flash('alert-type', 'error');

        return response()->json([
            'success' => false,
            'message' => 'Invalid email or password.',
            'showToastr' => true
        ], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with(
            notificationMessage('success', 'Logout', 'completed', 'You have been logged out successfully.')
        );
    }
}
