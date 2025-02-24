<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User Seeder
        // $this->call(UserSeeder::class);
        // Admin Seeder
        // $this->call(AdminSeeder::class);
        // language Seeder
        $this->call(LanguageSeeder::class);
    }
}
