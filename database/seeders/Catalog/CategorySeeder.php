<?php

namespace Database\Seeders\Catalog;

use App\Models\Catalog\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory(5)->create();
    }
}
