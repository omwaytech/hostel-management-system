<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemFAQCategory extends Model
{
    protected $fillable = [
        'category_name',
        'slug',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function faqs()
    {
        return $this->hasMany(SystemFAQ::class, 'category_id');
    }
}
