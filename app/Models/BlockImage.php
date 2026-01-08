<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockImage extends Model
{
    protected $fillable = [
        'block_id',
        'image',
        'caption',
        'slug',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function block()
    {
        return $this->belongsTo(Block::class, 'block_id', 'id');
    }
}
