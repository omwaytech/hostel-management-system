<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HostelReview extends Model
{
    protected $fillable = [
        'hostel_id',
        'user_id',
        'resident_id',
        'rating',
        'review_text',
        'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'created_at' => 'datetime',
    ];

    /**
     * Get the hostel that owns the review.
     */
    public function hostel(): BelongsTo
    {
        return $this->belongsTo(Hostel::class);
    }

    /**
     * Get the user who wrote the review.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the resident who wrote the review (if applicable).
     */
    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class);
    }
}
