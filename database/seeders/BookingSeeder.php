<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $customers = DB::table('users')->where('role', 'customer')->get();
        $flights = DB::table('flights')->get();
        
        if ($customers->isEmpty() || $flights->isEmpty()) {
            $this->command->warn('⚠️ Tidak ada customer atau flight. Skipping BookingSeeder.');
            return;
        }
        
        $bookingsToInsert = [];
        
        // Status dengan persentase realistis
        // pending 25%, confirmed 65%, cancelled 10%
        $statuses = array_merge(
            array_fill(0, 25, 'pending'),      // 25% pending
            array_fill(0, 65, 'confirmed'),    // 65% confirmed
            array_fill(0, 10, 'cancelled')     // 10% cancelled
        );
        
        for ($i = 0; $i < 150; $i++) {
            $customer = $customers->random();
            $flight = $flights->random();
            
            $totalPassengers = rand(1, 4);
            $totalPrice = $flight->price * $totalPassengers;
            $status = $statuses[array_rand($statuses)];
            
            $bookingCode = 'MSK-' . strtoupper(Str::random(6));
            
            $bookingsToInsert[] = [
                'user_id' => $customer->id,
                'flight_id' => $flight->id,
                'booking_code' => $bookingCode,
                'total_passengers' => $totalPassengers,
                'total_price' => $totalPrice,
                'status' => $status,
                'created_at' => Carbon::now()->subDays(rand(0, 30)),
                'updated_at' => now(),
            ];
        }

        DB::table('bookings')->insert($bookingsToInsert);
        
        $this->command->info('✅ Berhasil membuat ' . count($bookingsToInsert) . ' booking!');
        $this->command->info('   - Pending: ~37 booking');
        $this->command->info('   - Confirmed: ~97 booking');
        $this->command->info('   - Cancelled: ~15 booking');
    }
}