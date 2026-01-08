<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(20);
        return view('admin.notification.index', compact('notifications'));
    }
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->find($id);

        if (! $notification) {
            return response()->json(['success' => false], 404);
        }

        if ($notification->read_at === null) {
            $notification->markAsRead();
        }

        return response()->json(['success' => true]);
    }

}
