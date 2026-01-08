<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShortTermBooking extends Model
{
    protected $fillable = [
        'hostel_id',
        'room_id',
        'bed_id',
        'name',
        'email',
        'phone',
        'permanent_address',
        'message',
        'days_of_stay',
        'room_type',
        'price_range',
        'status',
        'slug',
    ];

    public function hostel()
    {
        return $this->belongsTo(Hostel::class, 'hostel_id', 'id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }

    public function bed()
    {
        return $this->belongsTo(Bed::class, 'bed_id', 'id');
    }
}
