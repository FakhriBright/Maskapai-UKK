<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'flight_id',
        'booking_code',
        'total_passengers',
        'total_price',
        'status',
    ];

    protected $casts = [
        'total_passengers' => 'integer',
        'total_price' => 'decimal:2',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Flight
    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }

    // Relasi ke Passengers
    public function passengers()
    {
        return $this->hasMany(Passenger::class);
    }

    // Relasi ke Payment
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}