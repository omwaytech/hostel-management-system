<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermsAndPolicies extends Model
{
    protected $fillable = [
        'hostel_id',
        'tp_title',
        'tp_description',
        'slug'
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
