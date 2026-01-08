<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Icon extends Model
{
    protected $fillable = [
        'icon_name',
        'icon_path',
        'slug'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
