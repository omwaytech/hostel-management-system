<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $fillable = [
        'hostel_id',
        'about_title',
        'about_description',
        'about_mission',
        'about_vision',
        'about_value',
        'slug',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
