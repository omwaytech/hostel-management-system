<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'photo',
        'citizenship',
        'contact_number',
        'date_of_birth',
        'gender',
        'permanent_address',
        'email',
        'password',
        'role_id',
        'slug',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function hostels()
    {
        return $this->belongsToMany(Hostel::class)->withPivot('role_id')->withTimestamps();
    }
    public function wardenBlock()
    {
        return $this->hasOne(Block::class, 'warden_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function resident()
    {
        return $this->hasOne(Resident::class, 'user_id', 'id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
