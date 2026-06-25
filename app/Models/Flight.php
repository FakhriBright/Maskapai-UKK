<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    protected $fillable = [
        'airline_id', 
        'airplane_id', 
        'departure_airport_id', 
        'arrival_airport_id', 
        'flight_number', 
        'departure_time', 
        'arrival_time', 
        'price', 
        'available_seats'
    ];

    protected $casts = [
        'departure_time' => 'datetime',
        'arrival_time' => 'datetime',
        'price' => 'decimal:2',
    ];

    // Relasi ke Maskapai
    public function airline()
    {
        return $this->belongsTo(Airline::class);
    }

    // Relasi ke Pesawat
    public function airplane()
    {
        return $this->belongsTo(Airplane::class);
    }

    // Relasi ke Bandara Asal
    public function departureAirport()
    {
        return $this->belongsTo(Airport::class, 'departure_airport_id');
    }

    // Relasi ke Bandara Tujuan
    public function arrivalAirport()
    {
        return $this->belongsTo(Airport::class, 'arrival_airport_id');
    }

    // Relasi ke Booking
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}