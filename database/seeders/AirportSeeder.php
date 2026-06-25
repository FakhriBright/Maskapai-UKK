<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AirportSeeder extends Seeder {
    public function run(): void {
        $airports = [
            ['name' => 'Soekarno-Hatta International', 'city' => 'Jakarta', 'country' => 'Indonesia', 'iata_code' => 'CGK'],
            ['name' => 'Ngurah Rai International', 'city' => 'Denpasar', 'country' => 'Indonesia', 'iata_code' => 'DPS'],
            ['name' => 'Juanda International', 'city' => 'Surabaya', 'country' => 'Indonesia', 'iata_code' => 'SUB'],
            ['name' => 'Sultan Hasanuddin', 'city' => 'Makassar', 'country' => 'Indonesia', 'iata_code' => 'UPG'],
            ['name' => 'Kualanamu International', 'city' => 'Medan', 'country' => 'Indonesia', 'iata_code' => 'KNO'],
            ['name' => 'Adisutjipto International', 'city' => 'Yogyakarta', 'country' => 'Indonesia', 'iata_code' => 'JOG'],
        ];
        DB::table('airports')->insert($airports);
    }
}