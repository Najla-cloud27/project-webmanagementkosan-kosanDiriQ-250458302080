<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin/Pemilik Kosan
        User::updateOrCreate(
            ['email' => 'admin@kosan.com'],
            [
                'name' => 'Admin Pemilik',
                'phone_number' => '08123456789',
                'nik' => '1111111111',
                'role' => 'pemilik',
                'avatar_url' => null,
                'password' => bcrypt('password'),
            ]
        );

        // User/Penyewa 1
        User::updateOrCreate(
            ['email' => 'penyewa@kosan.com'],
            [
                'name' => 'Penyewa 1',
                'phone_number' => '082233445566',
                'nik' => '2222222222',
                'role' => 'penyewa',
                'avatar_url' => null,
                'password' => bcrypt('password'),
            ]
        );

        // User/Penyewa 2
        User::updateOrCreate(
            ['email' => 'penyewa2@kosan.com'],
            [
                'name' => 'Penyewa 2',
                'phone_number' => '0843211876',
                'nik' => '3333333333',
                'role' => 'penyewa',
                'avatar_url' => null,
                'password' => bcrypt('password'),
            ]
        );
    }
}