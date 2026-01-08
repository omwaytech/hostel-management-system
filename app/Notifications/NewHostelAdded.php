<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewHostelAdded extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $hostel;

    public function __construct($hostel)
    {
        $this->hostel = $hostel;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'Hostel Approve',
            'title' => 'New Hostel Approved',
            'message' => $this->hostel->name . ' has been approved.',
            'link' => route('admin.hostel.dashboard', $this->hostel->token),
        ];
    }
}
