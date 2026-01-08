<?php

namespace App\Mail;

use App\Models\Resident;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResidentCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $resident;
    public $user;
    public $password;
    public $block;
    public $hostel;
    public $bed;
    public $room;
    public $floor;
    public $occupancy;

    public function __construct(Resident $resident, User $user, $password)
    {
        $this->resident = $resident;
        $this->user = $user;
        $this->password = $password;

        // Load relationships
        $this->bed = $resident->bed;
        $this->room = $this->bed->room ?? null;
        $this->floor = $this->room->floor ?? null;
        $this->block = $resident->block;
        $this->hostel = $this->block->hostel ?? null;
        $this->occupancy = $resident->occupancy ?? null;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to ' . ($this->hostel ? $this->hostel->name : 'Our Hostel'),
        );
    }

    public function build()
    {
        return $this->subject('Welcome to ' . ($this->hostel ? $this->hostel->name : 'Our Hostel'))
                    ->view('admin.hostelAdminBackend.emails.residentCreated');
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
