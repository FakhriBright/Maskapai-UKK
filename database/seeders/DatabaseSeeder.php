<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // ← TAMBAHKAN INI

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🚀 Memulai seeding database...');
        $this->command->info('');
        
        $this->call([
            FixedRolesSeeder::class,
            AirportSeeder::class,
            AirlineSeeder::class,
            AirplaneSeeder::class,
            FlightSeeder::class,
            CustomerSeeder::class,
            BookingSeeder::class,
            PassengerSeeder::class,
        ]);
        
        $this->command->info('');
        $this->command->info('✅ Seeding database selesai!');
        $this->command->info('');
        $this->command->info('📊 Ringkasan data:');
        $this->command->table(
            ['Tabel', 'Jumlah Record'],
            [
                ['Users', DB::table('users')->count()],
                ['Airlines', DB::table('airlines')->count()],
                ['Airports', DB::table('airports')->count()],
                ['Airplanes', DB::table('airplanes')->count()],
                ['Seats', DB::table('seats')->count()],
                ['Flights', DB::table('flights')->count()],
                ['Bookings', DB::table('bookings')->count()],
                ['Passengers', DB::table('passengers')->count()],
                ['Payments', DB::table('payments')->count() . ' (dari Midtrans)'],
            ]
        );
    }
}