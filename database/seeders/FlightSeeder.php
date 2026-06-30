<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FlightSeeder extends Seeder
{
    public function run(): void
    {
        $routes = [
            // Dari Jakarta (CGK)
            ['from' => 'CGK', 'to' => 'DPS', 'price' => 1200000, 'duration' => 120, 'times' => ['07:00', '10:30', '14:00', '18:30']],
            ['from' => 'CGK', 'to' => 'SUB', 'price' => 900000, 'duration' => 90, 'times' => ['08:00', '13:00', '19:00']],
            ['from' => 'CGK', 'to' => 'KNO', 'price' => 1100000, 'duration' => 150, 'times' => ['09:00', '16:00']],
            ['from' => 'CGK', 'to' => 'UPG', 'price' => 1500000, 'duration' => 180, 'times' => ['07:30', '14:30']],
            ['from' => 'CGK', 'to' => 'YIA', 'price' => 850000, 'duration' => 75, 'times' => ['08:30', '15:00', '20:00']],
            ['from' => 'CGK', 'to' => 'PKU', 'price' => 950000, 'duration' => 120, 'times' => ['10:00', '17:00']],
            ['from' => 'CGK', 'to' => 'PDG', 'price' => 1000000, 'duration' => 130, 'times' => ['09:30', '16:30']],
            ['from' => 'CGK', 'to' => 'BPN', 'price' => 1300000, 'duration' => 150, 'times' => ['08:00', '15:30']],
            ['from' => 'CGK', 'to' => 'PLM', 'price' => 750000, 'duration' => 60, 'times' => ['07:00', '12:00', '18:00']],
            ['from' => 'CGK', 'to' => 'SRG', 'price' => 800000, 'duration' => 70, 'times' => ['08:00', '14:00', '20:00']],
            ['from' => 'CGK', 'to' => 'BTH', 'price' => 700000, 'duration' => 50, 'times' => ['07:30', '11:30', '15:30', '19:30']],
            
            // Dari Denpasar (DPS)
            ['from' => 'DPS', 'to' => 'CGK', 'price' => 1200000, 'duration' => 120, 'times' => ['08:00', '12:00', '16:00', '20:00']],
            ['from' => 'DPS', 'to' => 'SUB', 'price' => 600000, 'duration' => 45, 'times' => ['09:00', '14:00', '19:00']],
            ['from' => 'DPS', 'to' => 'UPG', 'price' => 1400000, 'duration' => 150, 'times' => ['10:00', '17:00']],
            ['from' => 'DPS', 'to' => 'YIA', 'price' => 700000, 'duration' => 60, 'times' => ['08:30', '15:00']],
            
            // Dari Surabaya (SUB)
            ['from' => 'SUB', 'to' => 'CGK', 'price' => 900000, 'duration' => 90, 'times' => ['09:00', '14:00', '20:00']],
            ['from' => 'SUB', 'to' => 'DPS', 'price' => 600000, 'duration' => 45, 'times' => ['10:00', '15:00', '20:00']],
            ['from' => 'SUB', 'to' => 'UPG', 'price' => 1100000, 'duration' => 120, 'times' => ['08:00', '15:00']],
            ['from' => 'SUB', 'to' => 'KNO', 'price' => 1300000, 'duration' => 180, 'times' => ['09:00']],
            
            // Dari Medan (KNO)
            ['from' => 'KNO', 'to' => 'CGK', 'price' => 1100000, 'duration' => 150, 'times' => ['08:00', '14:00', '20:00']],
            ['from' => 'KNO', 'to' => 'SUB', 'price' => 1300000, 'duration' => 180, 'times' => ['09:00', '16:00']],
            ['from' => 'KNO', 'to' => 'UPG', 'price' => 1500000, 'duration' => 210, 'times' => ['10:00']],
            
            // Dari Makassar (UPG)
            ['from' => 'UPG', 'to' => 'CGK', 'price' => 1500000, 'duration' => 180, 'times' => ['08:00', '15:00']],
            ['from' => 'UPG', 'to' => 'DPS', 'price' => 1400000, 'duration' => 150, 'times' => ['09:00', '16:00']],
            ['from' => 'UPG', 'to' => 'SUB', 'price' => 1100000, 'duration' => 120, 'times' => ['10:00', '17:00']],
            ['from' => 'UPG', 'to' => 'MDC', 'price' => 900000, 'duration' => 90, 'times' => ['08:30', '14:30']],
            
            // Dari Yogyakarta (YIA)
            ['from' => 'YIA', 'to' => 'CGK', 'price' => 850000, 'duration' => 75, 'times' => ['09:00', '15:00', '21:00']],
            ['from' => 'YIA', 'to' => 'DPS', 'price' => 700000, 'duration' => 60, 'times' => ['10:00', '16:00']],
            
            // Rute lainnya
            ['from' => 'PKU', 'to' => 'CGK', 'price' => 950000, 'duration' => 120, 'times' => ['09:00', '16:00']],
            ['from' => 'PDG', 'to' => 'CGK', 'price' => 1000000, 'duration' => 130, 'times' => ['08:00', '15:00']],
            ['from' => 'BPN', 'to' => 'CGK', 'price' => 1300000, 'duration' => 150, 'times' => ['09:00', '16:00']],
            ['from' => 'PLM', 'to' => 'CGK', 'price' => 750000, 'duration' => 60, 'times' => ['08:00', '13:00', '19:00']],
            ['from' => 'SRG', 'to' => 'CGK', 'price' => 800000, 'duration' => 70, 'times' => ['09:00', '15:00', '21:00']],
            ['from' => 'BTH', 'to' => 'CGK', 'price' => 700000, 'duration' => 50, 'times' => ['08:00', '12:00', '16:00', '20:00']],
            ['from' => 'MDC', 'to' => 'UPG', 'price' => 900000, 'duration' => 90, 'times' => ['09:00', '15:00']],
            ['from' => 'MDC', 'to' => 'CGK', 'price' => 1800000, 'duration' => 210, 'times' => ['08:00']],
        ];

        $airlines = DB::table('airlines')->get();
        $airplanes = DB::table('airplanes')->get();
        $airports = DB::table('airports')->pluck('id', 'iata_code');
        
        $flightsToInsert = [];
        $flightNumberCounter = 1;
        
        // Generate flights untuk 30 hari ke depan
        for ($day = 0; $day <= 30; $day++) {
            $date = Carbon::today()->addDays($day);
            
            foreach ($routes as $route) {
                foreach ($route['times'] as $time) {
                    // Pilih airline dan airplane random
                    $airline = $airlines->random();
                    $airplane = $airplanes->where('airline_id', $airline->id)->random();
                    
                    if (!$airplane) {
                        // Jika airline tidak punya airplane, pilih airplane random
                        $airplane = $airplanes->random();
                    }
                    
                    $departureTime = $date->copy()->setTimeFromTimeString($time);
                    $arrivalTime = $departureTime->copy()->addMinutes($route['duration']);
                    
                    $flightNumber = $airline->code . $flightNumberCounter;
                    $flightNumberCounter++;
                    
                    $statuses = ['scheduled', 'scheduled', 'scheduled', 'scheduled', 'delayed', 'boarding'];
                    $status = $statuses[array_rand($statuses)];
                    
                    // HAPUS 'gate' dan 'terminal' karena tidak ada di tabel
                    $flightsToInsert[] = [
                        'airline_id' => $airline->id,
                        'airplane_id' => $airplane->id,
                        'departure_airport_id' => $airports[$route['from']],
                        'arrival_airport_id' => $airports[$route['to']],
                        'flight_number' => $flightNumber,
                        'departure_time' => $departureTime,
                        'arrival_time' => $arrivalTime,
                        'price' => $route['price'],
                        'available_seats' => $airplane->capacity,
                        'status' => $status,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        $chunks = array_chunk($flightsToInsert, 200);
        foreach ($chunks as $chunk) {
            DB::table('flights')->insert($chunk);
        }
        
        // Seed flight classes untuk semua flights yang baru di-insert
        $flights = DB::table('flights')->select('id', 'price')->get();
        $classesToInsert = [];
        
        foreach ($flights as $f) {
            // Economy Class
            $classesToInsert[] = [
                'flight_id' => $f->id,
                'class_name' => 'economy',
                'price_multiplier' => 1.00,
                'baggage_allowance' => 20,
                'seat_prefix' => 'Y',
                'seat_rows' => 25,
                'seat_columns' => 6,
                'lounge_access' => false,
                'meal_type' => 'Snack Only',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            // Business Class
            $classesToInsert[] = [
                'flight_id' => $f->id,
                'class_name' => 'business',
                'price_multiplier' => 1.80, // Multiplier 1.8x
                'baggage_allowance' => 30,
                'seat_prefix' => 'C',
                'seat_rows' => 4,
                'seat_columns' => 4,
                'lounge_access' => true,
                'meal_type' => 'Premium Hot Meal',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            // First Class
            $classesToInsert[] = [
                'flight_id' => $f->id,
                'class_name' => 'first',
                'price_multiplier' => 3.00, // Multiplier 3.0x
                'baggage_allowance' => 45,
                'seat_prefix' => 'F',
                'seat_rows' => 1,
                'seat_columns' => 4,
                'lounge_access' => true,
                'meal_type' => 'Fine Dining & Champagne',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $classChunks = array_chunk($classesToInsert, 500);
        foreach ($classChunks as $chunk) {
            DB::table('flight_classes')->insert($chunk);
        }
        
        $this->command->info('✅ Berhasil membuat ' . count($flightsToInsert) . ' penerbangan!');
        $this->command->info('✅ Berhasil membuat ' . count($classesToInsert) . ' kelas penerbangan!');
    }
}