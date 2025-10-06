<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@ticketing.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Karyawan
        User::updateOrCreate(
            ['email' => 'karyawan@ticketing.com'],
            [
                'name' => 'Karyawan',
                'password' => Hash::make('password'),
                'role' => 'karyawan',
            ]
        );

        // Hafiz
        User::updateOrCreate(
            ['email' => 'hafizhelpdesk@gmail.com'],
            [
                'name' => 'Hafiz',
                'password' => Hash::make('password'),
                'role' => 'karyawan',
            ]
        );
    }
}
