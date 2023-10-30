<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\Catalog\BrandSeeder;
use Database\Seeders\Catalog\CategorySeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BrandSeeder::class,
            CategorySeeder::class
        ]);
    }
}
