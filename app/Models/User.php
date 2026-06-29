<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'email_verified_at',
        // Profile fields
        'nik',
        'phone',
        'gender',
        'birth_date',
        'address',
        'city',
        'province',
        'postal_code',
        'identity_type',
        'identity_number',
        'nationality',
        'photo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
        ];
    }

    // Relasi ke Bookings
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Relasi ke Passengers
    public function passengers()
    {
        return $this->hasMany(Passenger::class);
    }
}