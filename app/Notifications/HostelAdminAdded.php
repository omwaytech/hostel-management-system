<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class HostelAdminAdded extends Notification
{
    use Queueable;

    public $hostel;
    public $user;
    public $for; // 'superadmin' or 'hosteladmin'

    public function __construct($hostel, $user, $for)
    {
        $this->hostel = $hostel;
        $this->user = $user;
        $this->for = $for;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        if ($this->for === 'Super Admin') {
            return [
                'type' => 'Hostel Admin Approve',
                'title' => 'New Hostel Admin Added',
                'message' => "{$this->user->name} has been assigned as an admin for {$this->hostel->name}.",
                'link' => route('admin.hostel.dashboard', $this->hostel->token),
            ];
        }

        return [
            'type' => 'Hostel Admin Approve',
            'title' => 'Assigned as Hostel Admin',
            'message' => "{$this->user->name} is assigned as an admin for {$this->hostel->name}. Welcome aboard!",
            // 'link' => route('hostelAdmin.dashboard', $this->hostel->token),
        ];
    }
}
