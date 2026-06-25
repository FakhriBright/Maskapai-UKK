<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airplane extends Model
{
    use HasFactory;

    protected $fillable = ['airline_id', 'model', 'registration_number', 'capacity', 'description', 'photos'];

    // Relasi: Pesawat milik satu Maskapai
    public function airline()
    {
        return $this->belongsTo(Airline::class);
    }

    // Relasi: Pesawat punya banyak Kursi
    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

    // Relasi: Pesawat digunakan untuk banyak Penerbangan
    public function flights()
    {
        return $this->hasMany(Flight::class);
    }
}