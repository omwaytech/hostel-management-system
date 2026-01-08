<?php

namespace App\Http\Controllers\admin\hostelAdminBackend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function index($slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();
        return view('admin.hostelAdminBackend.setting.index', compact('user'));
    }

    public function verifyPassword(Request $request)
    {
        // $request->validate([
        //     'password' => 'required',
        // ]);

        $user = Auth::user();
        $isValid = Hash::check($request->password, $user->password);

        return response()->json(['valid' => $isValid]);
    }
    public function updateEmail(Request $request)
    {
        // $request->validate([
        //     'new_email' => 'required|email|unique:users,email',
        // ]);

        $user = Auth::user();
        $user->email = $request->new_email;
        $user->save();

        return back()->with('success', 'Email updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        // $request->validate([
        //     'new_email' => 'required|email|unique:users,email',
        // ]);

        $user = Auth::user();
        $user->password = $request->new_password;
        $user->save();

        return back()->with('success', 'Password updated successfully.');
    }

}
