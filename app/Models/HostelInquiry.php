<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HostelInquiry extends Model
{
    protected $fillable = [
        'hostel_id',
        'full_name',
        'email_address',
        'subject',
        'meal_radio',
        'message',
        'slug'
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
