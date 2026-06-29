<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FixedRolesSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'admin@maskapai.test',
                'role' => 'admin',
            ],
            [
                'name' => 'Top Manager',
                'email' => 'manager@maskapai.test',
                'role' => 'manager',
            ],
            [
                'name' => 'Staff Operasional 1',
                'email' => 'staff1@maskapai.test',
                'role' => 'staff',
            ],
            [
                'name' => 'Staff Operasional 2',
                'email' => 'staff2@maskapai.test',
                'role' => 'staff',
            ],
            [
                'name' => 'Staff Operasional 3',
                'email' => 'staff3@maskapai.test',
                'role' => 'staff',
            ],
        ];

        foreach ($users as $u) {
            User::updateOrCreate(
                ['email' => $u['email']],
                [
                    'name' => $u['name'],
                    'password' => Hash::make('password123'),
                    'role' => $u['role'],
                    'email_verified_at' => now(),
                ]
            );
        }
        
        $this->command->info('✅ Berhasil membuat ' . count($users) . ' user dengan role tetap!');
    }
}