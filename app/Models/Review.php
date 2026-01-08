<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'hostel_id',
        'person_name',
        'person_image',
        'person_address',
        'rating',
        'person_statement',
        'is_helpful',
        'slug',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
