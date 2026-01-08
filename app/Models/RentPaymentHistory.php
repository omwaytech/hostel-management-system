<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentPaymentHistory extends Model
{
    protected $fillable = [
        'resident_id',
        'bill_id',
        'amount_paid',
        'payment_date',
        'payment_method',
        'slug',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function resident()
    {
        return $this->belongsTo(Resident::class, 'resident_id', 'id');
    }

    public function bill()
    {
        return $this->belongsTo(Bill::class, 'bill_id', 'id');
    }

}
