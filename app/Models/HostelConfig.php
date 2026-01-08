<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HostelConfig extends Model
{
    protected $fillable = [
        'key',
        'value',
        'hostel_id',
    ];

    public static function getValue($key, $hostelId = null, $default = null)
    {
        $query = static::where('key', $key);
        if ($hostelId) {
            $query->where('hostel_id', $hostelId);
        }
        return $query->value('value') ?? $default;
    }

    public static function setValue($key, $value, $hostelId = null)
    {
        $conditions = ['key' => $key];
        if ($hostelId) {
            $conditions['hostel_id'] = $hostelId;
        }
        return static::updateOrCreate($conditions, ['value' => $value]);
    }
}
