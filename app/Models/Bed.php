<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bed extends Model
{
    protected $fillable = [
        'room_id',
        'bed_number',
        'photo',
        'status',
        'slug',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }
    public function bedTransfersFrom()
    {
        return $this->hasMany(BedTransferHistory::class, 'from_bed_id');
    }

    public function resident()
    {
        return $this->hasOne(Resident::class);
    }

    public function bedTransfersTo()
    {
        return $this->hasMany(BedTransferHistory::class, 'to_bed_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
