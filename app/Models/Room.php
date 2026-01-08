<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'floor_id',
        'occupancy_id',
        'room_number',
        'room_type',
        'photo',
        'has_attached_bathroom',
        'room_size',
        'room_window_number',
        'room_inclusions',
        'room_amenities',
        'slug',
    ];

    protected $casts = [
        'room_inclusions' => 'array',
        'room_amenities' => 'array',
    ];

    public function floor()
    {
        return $this->belongsTo(Floor::class, 'floor_id', 'id');
    }

    public function beds()
    {
        return $this->hasMany(Bed::class, 'room_id');
    }

    public function roomAmenities()
    {
        return $this->hasMany(RoomAmenity::class, 'room_id');
    }

    public function occupancy()
    {
        return $this->belongsTo(Occupancy::class, 'occupancy_id', 'id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
