<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

public function run(): void {
    $this->call([
        FixedRolesSeeder::class,
        AirportSeeder::class,
        AirlineSeeder::class,
        AirplaneSeeder::class,
        // FlightSeeder::class, // Kita buat manual nanti via Admin CRUD
    ]);
}
}
