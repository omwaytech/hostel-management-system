<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    protected $fillable = [
        'block_id',
        'day',
        'early_morning',
        'morning',
        'day_meal',
        'evening',
    ];

    public function block()
    {
        return $this->belongsTo(Block::class, 'block_id', 'id');
    }
}
