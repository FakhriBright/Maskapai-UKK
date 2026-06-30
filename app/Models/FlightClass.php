<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'flight_id',
        'class_name',
        'price_multiplier',
        'baggage_allowance',
        'seat_prefix',
        'seat_rows',
        'seat_columns',
        'lounge_access',
        'meal_type',
    ];

    protected $casts = [
        'price_multiplier' => 'decimal:2',
        'lounge_access' => 'boolean',
        'baggage_allowance' => 'integer',
        'seat_rows' => 'integer',
        'seat_columns' => 'integer',
    ];

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }
}
