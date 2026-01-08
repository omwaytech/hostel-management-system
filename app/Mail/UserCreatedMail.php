<?php

namespace App\Mail;

use App\Models\Hostel;
use App\Models\Role;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $password;
    public $hostel;
    public $role;

    public function __construct($user, $password, $hostel_id, $role_id)
    {
        $this->user = $user;
        $this->password = $password;
        $this->hostel = Hostel::with('blocks')->find($hostel_id);
        $this->role = Role::find($role_id);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'User Created Mail',
        );
    }

    public function build()
    {
        return $this->subject('Welcome to ' . $this->hostel->name)
                    ->view('admin.hostelAdminBackend.emails.userCreated');
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
