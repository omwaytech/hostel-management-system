<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BedTransferHistory extends Model
{
    protected $fillable = [
        'resident_id',
        'from_bed_id',
        'to_bed_id',
        'transfer_date',
        'slug'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function fromBed()
    {
        return $this->belongsTo(Bed::class, 'from_bed_id', 'id');
    }

    public function toBed()
    {
        return $this->belongsTo(Bed::class, 'to_bed_id', 'id');
    }
}
