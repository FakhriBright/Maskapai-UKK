<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AirlineSeeder extends Seeder
{
    public function run(): void
    {
        $airlines = [
            [
                'name' => 'SkyLine Airways',
                'code' => 'SL',
                'logo' => null,
                'description' => 'Maskapai premium Indonesia dengan layanan kelas dunia untuk rute domestik dan internasional',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Garuda Indonesia',
                'code' => 'GA',
                'logo' => null,
                'description' => 'Flag carrier Indonesia, maskapai penuh layanan dengan pengalaman perjalanan premium',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Citilink',
                'code' => 'QG',
                'logo' => null,
                'description' => 'Maskapai berbiaya rendah anak perusahaan Garuda Indonesia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lion Air',
                'code' => 'JT',
                'logo' => null,
                'description' => 'Maskapai swasta terbesar di Indonesia dengan jaringan domestik yang luas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Batik Air',
                'code' => 'ID',
                'logo' => null,
                'description' => 'Maskapai layanan penuh anak perusahaan Lion Air Group',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pelita Air',
                'code' => '6D',
                'logo' => null,
                'description' => 'Maskapai yang melayani penerbangan pemerintah dan komersial',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Super Air Jet',
                'code' => 'IU',
                'logo' => null,
                'description' => 'Maskapai berbiaya rendah modern dengan armada muda',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sriwijaya Air',
                'code' => 'SJ',
                'logo' => null,
                'description' => 'Maskapai Indonesia yang melayani rute domestik utama',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Wings Air',
                'code' => 'IW',
                'logo' => null,
                'description' => 'Maskapai pengumpan yang melayani rute jarak pendek dengan pesawat ATR',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'TransNusa',
                'code' => '8B',
                'logo' => null,
                'description' => 'Maskapai regional yang menghubungkan Indonesia timur',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'NAM Air',
                'code' => 'IN',
                'logo' => null,
                'description' => 'Anak perusahaan regional Sriwijaya Air',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Indonesia AirAsia',
                'code' => 'QZ',
                'logo' => null,
                'description' => 'Maskapai berbiaya rendah Indonesia bagian dari AirAsia Group',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('airlines')->insert($airlines);
        
        $this->command->info('✅ Berhasil membuat ' . count($airlines) . ' maskapai penerbangan!');
    }
}