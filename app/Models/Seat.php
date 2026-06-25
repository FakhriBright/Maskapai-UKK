<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = ['airplane_id', 'seat_number', 'class'];

    // Relasi: Kursi ada di dalam satu Pesawat
    public function airplane()
    {
        return $this->belongsTo(Airplane::class);
    }

    // Relasi: Kursi dipesan oleh Penumpang
    public function passenger()
    {
        return $this->hasOne(Passenger::class, 'seat_number', 'seat_number');
    }
}