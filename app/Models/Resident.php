<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    protected $fillable = [
        'user_id',
        'booking_id',
        'block_id',
        'bed_id',
        'occupancy_id',
        'full_name',
        'email',
        'contact_number',
        'guardian_contact',
        'photo',
        'citizenship',
        'due_amount',
        'advance_rent_payment',
        'check_in_date',
        'check_out_date',
        'slug'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }

    public function block()
    {
        return $this->belongsTo(Block::class, 'block_id', 'id');
    }

    public function occupancy()
    {
        return $this->belongsTo(Occupancy::class, 'occupancy_id', 'id');
    }
    public function bed()
    {
        return $this->belongsTo(Bed::class, 'bed_id', 'id');
    }

    public function bedTransfers()
    {
        return $this->hasMany(BedTransferHistory::class);
    }

    public function rentPayments()
    {
        return $this->hasMany(RentPaymentHistory::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
