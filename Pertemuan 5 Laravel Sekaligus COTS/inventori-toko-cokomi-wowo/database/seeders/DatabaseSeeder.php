<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * DatabaseSeeder — titik masuk utama seeding database.
 * 
 * Menjalankan semua seeder yang diperlukan secara berurutan.
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seeder user default: Pak Cokomi dan Mas Wowo
        $this->call([
            UserSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
