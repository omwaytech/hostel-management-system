<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'hostel_id',
        'room_id',
        'full_name',
        'email',
        'phone',
        'current_address',
        'move_in_date',
        'duration',
        'occupant_count',
        'emergency_contact',
        'dietary_preferences',
        'additional_requests',
        'payment_method',
        'monthly_rent',
        'security_deposit',
        'total_amount',
        'status',
        'terms_accepted',
        'privacy_accepted',
    ];

    protected $casts = [
        // 'move_in_date' => 'date',
        'monthly_rent' => 'decimal:2',
        'security_deposit' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'terms_accepted' => 'boolean',
        'privacy_accepted' => 'boolean',
    ];

    public function hostel()
    {
        return $this->belongsTo(Hostel::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function resident()
    {
        return $this->hasOne(Resident::class, 'booking_id', 'id');
    }
}
