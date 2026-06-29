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
            // SkyLine Airways (airline_id = 1)
            ['airline_id' => 1, 'model' => 'Airbus A320-200', 'reg' => 'PK-SLA', 'cap' => 180],
            ['airline_id' => 1, 'model' => 'Airbus A321Neo', 'reg' => 'PK-SLB', 'cap' => 220],
            ['airline_id' => 1, 'model' => 'Boeing 737-800', 'reg' => 'PK-SLC', 'cap' => 160],
            
            // Garuda Indonesia (airline_id = 2)
            ['airline_id' => 2, 'model' => 'Boeing 777-300ER', 'reg' => 'PK-GIA', 'cap' => 350],
            ['airline_id' => 2, 'model' => 'Airbus A330-300', 'reg' => 'PK-GIB', 'cap' => 280],
            ['airline_id' => 2, 'model' => 'Airbus A330-900Neo', 'reg' => 'PK-GIC', 'cap' => 300],
            
            // Citilink (airline_id = 3)
            ['airline_id' => 3, 'model' => 'Airbus A320-200', 'reg' => 'PK-QGA', 'cap' => 180],
            ['airline_id' => 3, 'model' => 'ATR 72-600', 'reg' => 'PK-QGB', 'cap' => 72],
            
            // Lion Air (airline_id = 4)
            ['airline_id' => 4, 'model' => 'Boeing 737-900ER', 'reg' => 'PK-JTA', 'cap' => 180],
            ['airline_id' => 4, 'model' => 'Boeing 737 MAX 8', 'reg' => 'PK-JTB', 'cap' => 190],
            ['airline_id' => 4, 'model' => 'Airbus A320-200', 'reg' => 'PK-JTC', 'cap' => 180],
            
            // Batik Air (airline_id = 5)
            ['airline_id' => 5, 'model' => 'Airbus A320-200', 'reg' => 'PK-IDA', 'cap' => 180],
            ['airline_id' => 5, 'model' => 'Boeing 737-800', 'reg' => 'PK-IDB', 'cap' => 160],
            
            // Pelita Air (airline_id = 6)
            ['airline_id' => 6, 'model' => 'Airbus A320-200', 'reg' => 'PK-6DA', 'cap' => 180],
            
            // Super Air Jet (airline_id = 7)
            ['airline_id' => 7, 'model' => 'Airbus A320-200', 'reg' => 'PK-IUA', 'cap' => 180],
            ['airline_id' => 7, 'model' => 'Boeing 737-800', 'reg' => 'PK-IUB', 'cap' => 160],
            
            // Sriwijaya Air (airline_id = 8)
            ['airline_id' => 8, 'model' => 'Boeing 737-800', 'reg' => 'PK-SJA', 'cap' => 160],
            ['airline_id' => 8, 'model' => 'Boeing 737-900ER', 'reg' => 'PK-SJB', 'cap' => 180],
            
            // Wings Air (airline_id = 9)
            ['airline_id' => 9, 'model' => 'ATR 72-600', 'reg' => 'PK-IWA', 'cap' => 72],
            ['airline_id' => 9, 'model' => 'ATR 72-600', 'reg' => 'PK-IWB', 'cap' => 72],
            
            // TransNusa (airline_id = 10)
            ['airline_id' => 10, 'model' => 'Airbus A320-200', 'reg' => 'PK-8BA', 'cap' => 180],
            
            // NAM Air (airline_id = 11)
            ['airline_id' => 11, 'model' => 'Boeing 737-500', 'reg' => 'PK-INA', 'cap' => 120],
            
            // Indonesia AirAsia (airline_id = 12)
            ['airline_id' => 12, 'model' => 'Airbus A320-200', 'reg' => 'PK-QZA', 'cap' => 180],
            ['airline_id' => 12, 'model' => 'Airbus A320-200', 'reg' => 'PK-QZB', 'cap' => 180],
        ];

        $seedsToInsert = [];

        foreach ($planes as $p) {
            $plane = Airplane::create([
                'airline_id' => $p['airline_id'],
                'model' => $p['model'],
                'registration_number' => $p['reg'],
                'capacity' => $p['cap'],
                'description' => null,
            ]);

            $rows = intdiv($p['cap'], 6);
            for ($r = 1; $r <= $rows; $r++) {
                foreach (['A', 'B', 'C', 'D', 'E', 'F'] as $col) {
                    $seatNum = $r . $col;
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

        if (!empty($seedsToInsert)) {
            DB::table('seats')->insert($seedsToInsert);
        }
        
        $this->command->info('✅ Berhasil membuat ' . count($planes) . ' pesawat dan ' . count($seedsToInsert) . ' kursi!');
    }
}