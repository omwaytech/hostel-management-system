<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NotificationDropdown extends Component
{
    public $notifications;
    public $unreadCount;

    public function __construct()
    {
        $this->notifications = auth()->user()->notifications()->latest()->get();
        $this->unreadCount = auth()->user()->unreadNotifications()->count();
    }

    public function render()
    {
        return view('admin.components.notificationDropdown');
    }
}
