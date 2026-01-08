<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Models\Block;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->role_id == 1) {
            session()->flash('success', 'Super Admin Logged In!');
            return redirect()->route('admin.dashboard');
        }

        $hostel = $user->hostels()->wherePivot('role_id', 2)->first();

        if ($hostel) {
            Session::put('current_hostel_id', $hostel->id);

            session()->flash('success', 'Admin Logged In!');
            return redirect()->route('hostelAdmin.dashboard', ['token' => $hostel->token]);
        }

        $warden = $user->hostels()->wherePivot('role_id', 3)->first();
        if ($warden) {
            $block = Block::where('hostel_id', $warden->id)
                ->where('warden_id', $user->id)
                ->first();

            if ($block) {
                Session::put([
                    'current_hostel_id' => $block->hostel_id,
                    'current_block_id' => $block->id,
                ]);
                session()->flash('success', 'Warden Logged In!');
                return redirect()->route('hostelAdmin.dashboard', ['token' => $block->token]);
            }
        }

        Auth::logout();
        return redirect()->route('login')->withErrors([
            'email' => 'Access denied | Contact administrator.',
        ]);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        $redirectRoute = 'login'; // Default redirect

        // Check if user is hostel admin or warden and get their hostel
        if ($user) {
            // Check for Hostel Admin (role_id = 2)
            $hostel = $user->hostels()->wherePivot('role_id', 2)->first();

            // If not admin, check for Warden (role_id = 3)
            if (!$hostel) {
                $hostel = $user->hostels()->wherePivot('role_id', 3)->first();
            }

            // If user has a hostel, redirect to hostel signin page
            if ($hostel) {
                $redirectRoute = 'hostel.signin';
                $redirectParam = $hostel->slug;
            }
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $notification = notificationMessage('success', 'Logout', 'completed', 'You have been logged out successfully.');

        // Redirect to appropriate page
        if (isset($redirectParam)) {
            return redirect()->route($redirectRoute, $redirectParam)->with($notification);
        }

        return redirect()->route($redirectRoute)->with($notification);
    }
}
