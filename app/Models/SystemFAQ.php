<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemFAQ extends Model
{
    protected $fillable = [
        'category_id',
        'faq_question',
        'faq_answer',
        'slug',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function category()
    {
        return $this->belongsTo(SystemFAQCategory::class, 'category_id', 'id');
    }
}
