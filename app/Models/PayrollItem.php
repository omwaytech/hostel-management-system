<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayrollItem extends Model
{
    protected $fillable = [
        'payroll_id',
        'type',
        'particular',
        'amount',
        'slug',
    ];

    public function payroll()
    {
        return $this->belongsTo(Payroll::class, 'payroll_id', 'id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
