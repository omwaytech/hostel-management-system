<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HostelFeature extends Model
{
    protected $fillable = [
        'hostel_id',
        'feature_name',
        'feature_icon',
        'slug',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
