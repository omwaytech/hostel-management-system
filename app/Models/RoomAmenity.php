<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomAmenity extends Model
{
    protected $fillable = [
        'room_id',
        'amenity_name',
        'amenity_icon',
        'slug'
    ];
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }
}
