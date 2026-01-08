<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email_address',
        'phone_number',
        'message',
        'slug'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
