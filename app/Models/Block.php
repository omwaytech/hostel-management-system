<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $fillable = [
        'token',
        'hostel_id',
        'warden_id',
        'block_number',
        'name',
        'photo',
        'description',
        'contact',
        'facilities',
        'location',
        'no_of_floor',
        'email',
        'map',
        'slug',
    ];

    public function hostel()
    {
        return $this->belongsTo(Hostel::class, 'hostel_id', 'id');
    }

    public function floors()
    {
        return $this->hasMany(Floor::class, 'block_id');
    }

    public function occupancies()
    {
        return $this->hasMany(Occupancy::class, 'block_id');
    }
    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'block_id');
    }

    public function images()
    {
        return $this->hasMany(BlockImage::class, 'block_id');
    }

    public function meals()
    {
        return $this->hasMany(Meal::class, 'block_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

}
