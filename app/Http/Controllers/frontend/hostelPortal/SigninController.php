<?php

namespace App\Http\Controllers\frontend\hostelPortal;

use App\Http\Controllers\Controller;
use App\Models\Block;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SigninController extends Controller
{
    public function signin()
    {
        $hostel = session('active_hostel');
        return view('frontend.hostelPortal.signin', compact('hostel'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->has('rememberMe');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            $hostel = session('active_hostel');

            // Check if user is Hostel Admin (role_id = 2) for this hostel
            $hostelAdmin = $user->hostels()->wherePivot('role_id', 2)->where('hostels.id', $hostel->id)->first();

            if ($hostelAdmin) {
                Session::put('current_hostel_id', $hostelAdmin->id);

                // Set session flash message for toastr
                $request->session()->flash('message', 'Hostel Admin logged in successfully!');
                $request->session()->flash('alert-type', 'success');

                return response()->json([
                    'success' => true,
                    'message' => 'Hostel Admin logged in successfully!',
                    'redirect' => route('hostelAdmin.dashboard', ['token' => $hostelAdmin->token])
                ]);
            }

            // Check if user is Warden (role_id = 3) for this hostel
            $warden = $user->hostels()->wherePivot('role_id', 3)->where('hostels.id', $hostel->id)->first();

            if ($warden) {
                $block = Block::where('hostel_id', $warden->id)
                    ->where('warden_id', $user->id)
                    ->first();

                if ($block) {
                    Session::put([
                        'current_hostel_id' => $block->hostel_id,
                        'current_block_id' => $block->id,
                    ]);

                    // Set session flash message for toastr
                    $request->session()->flash('message', 'Warden logged in successfully!');
                    $request->session()->flash('alert-type', 'success');

                    return response()->json([
                        'success' => true,
                        'message' => 'Warden logged in successfully!',
                        'redirect' => route('hostelAdmin.dashboard', ['token' => $block->token])
                    ]);
                }
            }

            // User doesn't have permission for this hostel
            Auth::logout();

            // Set session flash message for toastr error
            $request->session()->flash('message', 'You do not have access to this hostel. Please contact the administrator.');
            $request->session()->flash('alert-type', 'error');

            return response()->json([
                'success' => false,
                'message' => 'You do not have access to this hostel. Please contact the administrator.',
                'showToastr' => true
            ], 403);
        }

        // Set session flash message for toastr error
        $request->session()->flash('message', 'Invalid email or password. Please try again.');
        $request->session()->flash('alert-type', 'error');

        return response()->json([
            'success' => false,
            'message' => 'Invalid email or password. Please try again.',
            'showToastr' => true
        ], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $hostel = session('active_hostel');

        if ($hostel) {
            return redirect()->route('hostel.signin', $hostel->slug)->with(
                notificationMessage('success', 'Logout', 'completed', 'You have been logged out successfully.')
            );
        }

        return redirect()->route('home')->with(
            notificationMessage('success', 'Logout', 'completed', 'You have been logged out successfully.')
        );
    }
}
