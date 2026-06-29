<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 
use App\Models\Airplane;

class AirplaneSeeder extends Seeder
{
    public function run(): void
    {
        $planes = [
            ['airline_id' => 1, 'model' => 'Boeing 737-800', 'reg' => 'PK-GMA', 'cap' => 160],
            ['airline_id' => 1, 'model' => 'Airbus A330-300', 'reg' => 'PK-GPI', 'cap' => 280],
            ['airline_id' => 2, 'model' => 'Boeing 737-900ER', 'reg' => 'PK-LQM', 'cap' => 180],
            ['airline_id' => 3, 'model' => 'Airbus A320-200', 'reg' => 'PK-GLC', 'cap' => 180],
        ];

        $seedsToInsert = [];

        foreach ($planes as $p) {
            $plane = Airplane::create([
                'airline_id' => $p['airline_id'],
                'model' => $p['model'],
                'registration_number' => $p['reg'],
                'capacity' => $p['cap'],
            ]);

            $rows = intdiv($p['cap'], 6); 
            for ($r = 1; $r <= $rows; $r++) {
                foreach (['A', 'B', 'C', 'D', 'E', 'F'] as $col) {
                    $seatNum = $r . $col;
                    // Baris 1-5 Business, sisanya Economy
                    $class = ($r <= 5) ? 'business' : 'economy';
                    
                    $seedsToInsert[] = [
                        'airplane_id' => $plane->id,
                        'seat_number' => $seatNum,
                        'class' => $class,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        // Bulk insert ke database (Sangat cepat untuk ratusan baris!)
        if (!empty($seedsToInsert)) {
            DB::table('seats')->insert($seedsToInsert);
        }
        
        echo "\n✅ Berhasil membuat " . count($seedsToInsert) . " kursi!\n";
    }
}