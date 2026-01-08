<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HostelImage extends Model
{
    protected $fillable = [
        'hostel_id',
        'image',
        'caption',
        'slug',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function hostel()
    {
        return $this->belongsTo(Hostel::class, 'hostel_id', 'id');
    }
}
