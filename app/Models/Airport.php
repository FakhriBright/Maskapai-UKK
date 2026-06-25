<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'city', 'country', 'iata_code'];

    // Relasi: Bandara sebagai titik keberangkatan
    public function departureFlights()
    {
        return $this->hasMany(Flight::class, 'departure_airport_id');
    }

    // Relasi: Bandara sebagai titik kedatangan
    public function arrivalFlights()
    {
        return $this->hasMany(Flight::class, 'arrival_airport_id');
    }
}