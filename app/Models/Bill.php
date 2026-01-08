<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = [
        'resident_id',
        'invoice_number',
        'month',
        'subtotal',
        'discount',
        'total',
        'paid_amount',
        'due_amount',
        'status',
        'generated_date',
        'generated_by',
        'slug'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function resident()
    {
        return $this->belongsTo(Resident::class, 'resident_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(BillItem::class, 'bill_id');
    }

    public function rentPayments()
    {
        return $this->hasMany(RentPaymentHistory::class);
    }
}
