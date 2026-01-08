<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemTestimonial extends Model
{
    protected $fillable = [
        'person_name',
        'person_image',
        'person_address',
        'rating',
        'person_statement',
        'slug',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
