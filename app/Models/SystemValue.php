<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemValue extends Model
{
    protected $fillable = [
        'system_about_id',
        'value_icon',
        'value_title',
        'value_description',
        'slug',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function systemAbout()
    {
        return $this->belongsTo(SystemAbout::class, 'system_about_id', 'id');
    }
}
