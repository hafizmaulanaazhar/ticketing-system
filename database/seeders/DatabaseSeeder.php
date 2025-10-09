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

        // Rofina
        User::updateOrCreate(
            ['email' => 'rofina@helpdesk.com'],
            [
                'name' => 'Rofina',
                'password' => Hash::make('password'),
                'role' => 'karyawan',
            ]
        );

        // Nisha
        User::updateOrCreate(
            ['email' => 'nishahelpdesk@gmail.com'],
            [
                'name' => 'Nisha',
                'password' => Hash::make('password'),
                'role' => 'karyawan',
            ]
        );

        // Sabian
        User::updateOrCreate(
            ['email' => 'sabianhelpdesk@gmail.com'],
            [
                'name' => 'Anisa',
                'password' => Hash::make('password'),
                'role' => 'karyawan',
            ]
        );

        // Rizky
        User::updateOrCreate(
            ['email' => 'rizkyhelpdesk@gmail.com'],
            [
                'name' => 'Rizky',
                'password' => Hash::make('password'),
                'role' => 'karyawan',
            ]
        );

        // Faisal
        User::updateOrCreate(
            ['email' => 'faisalhelpdesk@gmail.com'],
            [
                'name' => 'Faisal',
                'password' => Hash::make('password'),
                'role' => 'karyawan',
            ]
        );
    }
}
