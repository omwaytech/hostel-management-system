<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsAndBlog extends Model
{
    protected $fillable = [
        'hostel_id',
        'nb_title',
        'nb_image',
        'nb_badge',
        'nb_time_to_read',
        'nb_description',
        'nb_author_name',
        'nb_author_image',
        'slug',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
