<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    protected $fillable = [
        'block_id',
        'floor_number',
        'floor_label',
        'slug',
    ];

    public function block()
    {
        return $this->belongsTo(Block::class, 'block_id', 'id');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class, 'floor_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
