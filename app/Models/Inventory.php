<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'block_id',
        'type',
        'bill_number',
        'item_name',
        'quantity',
        'unit_price',
        'total',
        'slug'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function block()
    {
        return $this->belongsTo(Block::class, 'block_id', 'id');
    }
    public function items()
    {
        return $this->hasMany(InventoryItem::class, 'inventory_id');
    }
}
