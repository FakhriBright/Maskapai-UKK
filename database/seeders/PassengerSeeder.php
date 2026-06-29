<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PassengerSeeder extends Seeder
{
    public function run(): void
    {
        $bookings = DB::table('bookings')->get();
        $users = DB::table('users')->get();
        $flights = DB::table('flights')->get();
        $airplanes = DB::table('airplanes')->get();
        
        if ($bookings->isEmpty()) {
            $this->command->warn('⚠️ Tidak ada booking. Skipping PassengerSeeder.');
            return;
        }
        
        $firstNames = ['Budi', 'Siti', 'Ahmad', 'Dewi', 'Rudi', 'Ani', 'Joko', 'Megawati', 'Prabowo', 'Sri', 'Basuki', 'Rizal', 'Luhut', 'Retno', 'Erick', 'Nadiem', 'Sandiaga', 'Ganjar', 'Anies', 'Ridwan'];
        $lastNames = ['Santoso', 'Nurhaliza', 'Dahlan', 'Lestari', 'Hermawan', 'Yudhoyono', 'Widodo', 'Sukarno', 'Subianto', 'Mulyani', 'Tjahaja', 'Ramli', 'Panjaitan', 'Marsudi', 'Thohir', 'Makarim', 'Uno', 'Pranowo', 'Baswedan', 'Kamil'];
        
        $passengersToInsert = [];
        $usedSeats = []; // Track seat yang sudah dipakai per flight
        
        foreach ($bookings as $booking) {
            $user = $users->where('id', $booking->user_id)->first();
            $flight = $flights->where('id', $booking->flight_id)->first();
            
            if (!$flight) continue;
            
            // Get airplane untuk flight ini
            $airplane = $airplanes->where('id', $flight->airplane_id)->first();
            if (!$airplane) continue;
            
            // Get semua seat untuk airplane ini
            $availableSeats = DB::table('seats')
                ->where('airplane_id', $airplane->id)
                ->pluck('seat_number')
                ->toArray();
            
            // Filter seat yang sudah dipakai untuk flight ini
            $flightKey = 'flight_' . $flight->id;
            if (!isset($usedSeats[$flightKey])) {
                $usedSeats[$flightKey] = [];
            }
            
            $remainingSeats = array_diff($availableSeats, $usedSeats[$flightKey]);
            
            for ($i = 0; $i < $booking->total_passengers; $i++) {
                if (empty($remainingSeats)) {
                    $this->command->warn("⚠️ Kursi habis untuk flight {$flight->flight_number}");
                    break;
                }
                
                // Ambil seat random yang masih tersedia
                $seatNumber = $remainingSeats[array_rand($remainingSeats)];
                $usedSeats[$flightKey][] = $seatNumber;
                $remainingSeats = array_diff($remainingSeats, [$seatNumber]);
                
                $firstName = $firstNames[array_rand($firstNames)];
                $lastName = $lastNames[array_rand($lastNames)];
                $fullName = $firstName . ' ' . $lastName;
                
                $gender = rand(0, 1) ? 'male' : 'female';
                $birthDate = Carbon::now()->subYears(rand(18, 65))->format('Y-m-d');
                
                // Generate passport_number acak (format: A1234567)
                $passportNumber = chr(rand(65, 90)) . str_pad(rand(1000000, 9999999), 7, '0', STR_PAD_LEFT);
                
                $passengersToInsert[] = [
                    'booking_id' => $booking->id,
                    'user_id' => $booking->user_id,
                    'full_name' => $fullName,
                    'gender' => $gender,
                    'birth_date' => $birthDate,
                    'passport_number' => $passportNumber,
                    'seat_number' => $seatNumber,
                    'created_at' => $booking->created_at,
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('passengers')->insert($passengersToInsert);
        
        $this->command->info('✅ Berhasil membuat ' . count($passengersToInsert) . ' penumpang!');
        $this->command->info('   - Semua kursi diambil dari tabel seats (no duplicate)');
    }
}