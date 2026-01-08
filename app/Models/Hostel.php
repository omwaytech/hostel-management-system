<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hostel extends Model
{
    protected $fillable = [
        'owner_id',
        'token',
        'name',
        'logo',
        'description',
        'contact',
        'location',
        'latitude',
        'longitude',
        'email',
        'type',
        'slug',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('role_id')->withTimestamps();
    }

    public function blocks()
    {
        return $this->hasMany(Block::class, 'hostel_id');
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'hostel_amenities')
        ->withTimestamps();
    }

    public function images()
    {
        return $this->hasMany(HostelImage::class, 'hostel_id');
    }

    public function inquiries()
    {
        return $this->hasMany(HostelInquiry::class, 'hostel_id');
    }

    public function contacts()
    {
        return $this->hasMany(HostelContact::class, 'hostel_id');
    }

    public function hostelReviews()
    {
        return $this->hasMany(HostelReview::class, 'hostel_id');
    }

    public function termsAndPolicies()
    {
        return $this->hasMany(TermsAndPolicies::class, 'hostel_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Calculate distance between two coordinates using Haversine formula
     * Returns distance in kilometers
     */
    public static function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // Earth's radius in kilometers

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
             cos($latFrom) * cos($latTo) *
             sin($lonDelta / 2) * sin($lonDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
