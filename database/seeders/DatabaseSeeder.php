<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\seed\CategoriesSeeder;
use Database\Seeders\seed\GallerySeeder;
use Database\Seeders\seed\ProductCategorySeeder;
use Database\Seeders\seed\ProductsSeeder;
use Database\Seeders\seed\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategoriesSeeder::class,
            ProductsSeeder::class,
            GallerySeeder::class,
            ProductCategorySeeder::class,
        ]);
    }
}
