<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AirportSeeder extends Seeder
{
    public function run(): void
    {
        $airports = [
            ['name' => 'Soekarno-Hatta International Airport', 'city' => 'Jakarta', 'country' => 'Indonesia', 'iata_code' => 'CGK', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Halim Perdanakusuma International Airport', 'city' => 'Jakarta', 'country' => 'Indonesia', 'iata_code' => 'HLP', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ngurah Rai International Airport', 'city' => 'Denpasar', 'country' => 'Indonesia', 'iata_code' => 'DPS', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Juanda International Airport', 'city' => 'Surabaya', 'country' => 'Indonesia', 'iata_code' => 'SUB', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sultan Hasanuddin International Airport', 'city' => 'Makassar', 'country' => 'Indonesia', 'iata_code' => 'UPG', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kualanamu International Airport', 'city' => 'Medan', 'country' => 'Indonesia', 'iata_code' => 'KNO', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sultan Syarif Kasim II International Airport', 'city' => 'Pekanbaru', 'country' => 'Indonesia', 'iata_code' => 'PKU', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Minangkabau International Airport', 'city' => 'Padang', 'country' => 'Indonesia', 'iata_code' => 'PDG', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Achmad Yani International Airport', 'city' => 'Semarang', 'country' => 'Indonesia', 'iata_code' => 'SRG', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Yogyakarta International Airport', 'city' => 'Yogyakarta', 'country' => 'Indonesia', 'iata_code' => 'YIA', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Adisutjipto International Airport', 'city' => 'Yogyakarta', 'country' => 'Indonesia', 'iata_code' => 'JOG', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sultan Aji Muhammad Sulaiman Airport', 'city' => 'Balikpapan', 'country' => 'Indonesia', 'iata_code' => 'BPN', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sultan Mahmud Badaruddin II International Airport', 'city' => 'Palembang', 'country' => 'Indonesia', 'iata_code' => 'PLM', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Radin Inten II Airport', 'city' => 'Bandar Lampung', 'country' => 'Indonesia', 'iata_code' => 'TKG', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sam Ratulangi International Airport', 'city' => 'Manado', 'country' => 'Indonesia', 'iata_code' => 'MDC', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Dominique Edward Osok Airport', 'city' => 'Sorong', 'country' => 'Indonesia', 'iata_code' => 'SOQ', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sentani International Airport', 'city' => 'Jayapura', 'country' => 'Indonesia', 'iata_code' => 'DJJ', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Hang Nadim International Airport', 'city' => 'Batam', 'country' => 'Indonesia', 'iata_code' => 'BTH', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Zainuddin Abdul Madjid International Airport', 'city' => 'Lombok', 'country' => 'Indonesia', 'iata_code' => 'LOP', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pattimura International Airport', 'city' => 'Ambon', 'country' => 'Indonesia', 'iata_code' => 'AMQ', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('airports')->insert($airports);
        
        $this->command->info('✅ Berhasil membuat ' . count($airports) . ' bandara!');
    }
}