<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillItem extends Model
{
    protected $fillable = [
        'bill_id',
        'particular',
        'unit_price',
        'quantity',
        'discount',
        'amount',
        'slug',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function bill()
    {
        return $this->belongsTo(Bill::class, 'bill_id', 'id');
    }
}
