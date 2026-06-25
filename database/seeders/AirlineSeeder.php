<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AirlineSeeder extends Seeder {
    public function run(): void {
        $airlines = [
            ['name' => 'Garuda Indonesia', 'code' => 'GA', 'logo' => null, 'description' => 'Flag carrier of Indonesia'],
            ['name' => 'Lion Air', 'code' => 'JT', 'logo' => null, 'description' => 'Low cost carrier'],
            ['name' => 'Citilink', 'code' => 'QG', 'logo' => null, 'description' => 'Full service low cost carrier'],
            ['name' => 'Batik Air', 'code' => 'ID', 'logo' => null, 'description' => 'Full service subsidiary of Lion Air'],
        ];
        DB::table('airlines')->insert($airlines);
    }
}