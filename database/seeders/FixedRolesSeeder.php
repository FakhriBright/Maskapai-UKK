<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FixedRolesSeeder extends Seeder {
    public function run(): void {
        $users = [
            ['name' => 'Super Admin', 'email' => 'admin@maskapai.test', 'role' => 'admin'],
            ['name' => 'Petugas Staff', 'email' => 'staff@maskapai.test', 'role' => 'staff'],
            ['name' => 'Top Manager', 'email' => 'manager@maskapai.test', 'role' => 'manager'],
        ];

        foreach ($users as $u) {
            User::updateOrCreate(
                ['email' => $u['email']],
                [
                    'name' => $u['name'],
                    'password' => Hash::make('password123'),
                    'role' => $u['role'],
                    'email_verified_at' => now(), // Langsung verified biar bisa login
                ]
            );
        }
    }
}