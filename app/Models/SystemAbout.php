<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemAbout extends Model
{
    protected $fillable = [
        'about_title',
        'about_description',
        'about_mission',
        'about_vision',
        'slug',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function values()
    {
        return $this->hasMany(SystemValue::class, 'system_about_id');
    }
}
