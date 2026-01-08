<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HostelContact extends Model
{
    protected $fillable = [
        'hostel_id',
        'first_name',
        'last_name',
        'email_address',
        'phone_number',
        'message',
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
