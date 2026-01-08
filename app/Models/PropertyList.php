<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyList extends Model
{
    protected $fillable = [
        'hostel_name',
        'owner_name',
        'hostel_email',
        'hostel_contact',
        'hostel_city',
        'hostel_location',
        'slug',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
