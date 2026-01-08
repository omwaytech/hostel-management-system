<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = [
        'staff_id',
        'invoice_number',
        'pay_date',
        'month',
        'total_earning',
        'total_deduction',
        'total',
        'generated_by',
        'slug',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function payrollItems()
    {
        return $this->hasMany(PayrollItem::class, 'payroll_id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'id');
    }
}
