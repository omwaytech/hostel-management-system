<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Occupancy extends Model
{
    protected $fillable = [
        'block_id',
        'occupancy_type',
        'monthly_rent',
        'slug',
    ];

    public function block()
    {
        return $this->belongsTo(Block::class, 'block_id', 'id');
    }
    public function residents()
    {
        return $this->hasMany(Resident::class, 'occupancy_id');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class, 'occupancy_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

}
