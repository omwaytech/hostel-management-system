<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    protected $fillable = [
        'inventory_id',
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
    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id', 'id');
    }
}
