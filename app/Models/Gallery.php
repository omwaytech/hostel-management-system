<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'album_id',
        'gallery_image',
        'gallery_image_name',
        'slug',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function album()
    {
        return $this->belongsTo(ALbum::class, 'album_id', 'id');
    }
}
