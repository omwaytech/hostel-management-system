<?php

namespace App\Notifications;

use App\Models\Block;
use App\Models\Hostel;
use App\Models\Resident;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewHostelStudentAdded extends Notification
{
    use Queueable;

    protected $resident;
    protected $hostel;
    protected $block;

    public function __construct(Resident $resident, Hostel $hostel, Block $block)
    {
        $this->resident = $resident;
        $this->hostel = $hostel;
        $this->block = $block;
    }

    public function via($notifiable)
    {
        return ['database']; // You can remove mail if you only want in-app notifications
    }

    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //         ->subject('New Student Added')
    //         ->line('A new student has been added.')
    //         ->line('Name: ' . $this->resident->full_name)
    //         ->line('Hostel: ' . $this->hostel->name)
    //         ->line('Block: ' . $this->block->name)
    //         ->action('View Details', url('/admin/residents/' . $this->resident->id))
    //         ->line('Please check the resident details.');
    // }

    public function toArray($notifiable)
    {
        return [
            // 'resident_id' => $this->resident->id,
            // 'resident_name' => $this->resident->full_name,
            // 'hostel_id' => $this->hostel->id,
            // 'hostel_name' => $this->hostel->name,
            // 'block_id' => $this->block->id,
            // 'block_name' => $this->block->name,
            'type' => 'Student Added',
            'title' => "New Student Added to hostel {$this->hostel->name}",
            'link' => route('hostelAdmin.resident.show', $this->resident->slug),
            'message' => 'New student added: ' . $this->resident->full_name . ' added to hostel.',
        ];
    }
}
