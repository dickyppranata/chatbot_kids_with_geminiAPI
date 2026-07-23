<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seeding User Admin
        User::updateOrCreate(
            ['email' => 'admin@chatbot.id'],
            [
                'name'     => 'Admin Peneliti',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ]
        );

        // Seeding User Siswa / Anak
        User::updateOrCreate(
            ['email' => 'budi@chatbot.id'],
            [
                'name'     => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role'     => 'anak',
            ]
        );
    }
}
