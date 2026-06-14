<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * UserSeeder
 * 
 * Membuat akun default untuk Pak Cokomi (owner) dan Mas Wowo (kasir).
 */
class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'cokomi@toko.com'],
            [
                'name'              => 'Pak Cokomi',
                'email'             => 'cokomi@toko.com',
                'password'          => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'wowo@toko.com'],
            [
                'name'              => 'Mas Wowo',
                'email'             => 'wowo@toko.com',
                'password'          => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
    }
}
