<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewHostelRequest extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $property;

    public function __construct($property)
    {
        $this->property = $property;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'Property Request',
            'title' => 'New Hostel Request Submitted',
            'hostel_name' => $this->property->hostel_name,
            'location' => $this->property->hostel_location,
            'property_id' => $this->property->id,
            'message' => "{$this->property->hostel_name} located at {$this->property->hostel_location} has been submitted.",
            'link' => route('admin.property-list.show', $this->property->slug),
        ];
    }
}
