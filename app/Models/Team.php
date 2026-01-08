<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'hostel_id',
        'member_name',
        'member_image',
        'member_designation',
        'member_description',
        'slug',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
