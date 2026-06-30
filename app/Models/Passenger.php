<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'user_id',
        'full_name',
        'gender',
        'birth_date',
        'passport_number',
        'seat_number',
        'checked_in_at',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'checked_in_at' => 'datetime',
    ];

    // Relasi ke Booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Dapatkan kelas kursi penumpang berdasarkan detail pesawat dan nomor kursi.
     */
    public function getSeatClass(): string
    {
        $airplaneId = $this->booking->flight->airplane_id ?? null;
        if ($airplaneId) {
            $seat = \App\Models\Seat::where('airplane_id', $airplaneId)
                ->where('seat_number', $this->seat_number)
                ->first();
            return $seat ? $seat->class : 'economy';
        }
        return 'economy';
    }
}
