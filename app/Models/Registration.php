<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = [
        'hostel_id',
        'registered_to',
        'registered_number',
        'slug',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
