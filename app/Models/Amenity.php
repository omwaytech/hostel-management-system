<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    protected $fillable = [
        'amenity_name',
        'amenity_icon',
        'slug',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function hostels()
    {
        return $this->belongsToMany(Hostel::class, 'hostel_amenities');
    }
}
