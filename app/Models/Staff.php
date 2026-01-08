<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = [
        'block_id',
        'full_name',
        'role',
        'contact_number',
        'basic_salary',
        'photo',
        'citizenship',
        'join_date',
        'leave_date',
        'pan_number',
        'bank_account_number',
        'income_tax',
        'cit',
        'ssf',
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

    public function payrolls()
    {
        return $this->hasMany(Payroll::class, 'staff_id');
    }
}
