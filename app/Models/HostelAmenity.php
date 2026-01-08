<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HostelAmenity extends Model
{
    protected $fillable = [
        'hostel_id',
        'amenity_id',
        // 'amenity_icon',
        'slug',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
