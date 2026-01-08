<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'hostel_id',
        'slider_title',
        'slider_subtitle',
        'slider_image',
        'slug',
    ];

    public function hostel()
    {
        return $this->belongsTo(Hostel::class, 'hostel_id', 'id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
